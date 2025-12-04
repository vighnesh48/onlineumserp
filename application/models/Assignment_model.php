<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignment_model extends CI_Model {
    private $obe; // for lecture_plan / syllabus
    private $ums; // for students (adjust if you split campuses)

    public function __construct() {
        parent::__construct();
        $this->obe = $this->load->database('obe', TRUE);
        $this->ums = $this->load->database('umsdb', TRUE); // change per campus if you use sjumsdb/sfumsdb
    }

    # ---------- QUICK LOOKUPS ----------
    public function lecture_plans($subject_id, $faculty_id, $campus_id) {
        $this->obe->select('lp.plan_id, lp.topic_id, lp.subtopic_id, t.topic_order, t.topic_title, st.srno, st.subtopic_title');
        $this->obe->from('lecture_plan lp');
        $this->obe->join('syllabus_topics t', 't.topic_id=lp.topic_id AND t.subject_id=lp.subject_id', 'left');
        $this->obe->join('syllabus_subtopics st', 'st.subtopic_id=lp.subtopic_id', 'left');
        $this->obe->where([
            'lp.subject_id' => $subject_id,
            'lp.faculty_id' => $faculty_id,
            'lp.campus_id'  => $campus_id
        ]);
        $this->obe->order_by('lp.planned_date','ASC');
       return  $this->obe->get()->result();
		// echo $this->obe->last_query();exit;
    }

    public function questions_by_topic($subject_id, $campus_id, $topic_id, $subtopic_id = null) {
        $this->obe->from('assignment_question_bank');
        $this->obe->where(['subject_id'=>$subject_id, 'campus_id'=>$campus_id, 'topic_id'=>$topic_id]);
        if (!empty($subtopic_id)) $this->obe->where('subtopic_id', $subtopic_id);
        $this->obe->order_by('id','DESC');
        return $this->obe->get()->result();
		// echo $this->obe->last_query();exit;
    }
	public function get_questions_for_plan($plan_id)
    {
        $plan = $this->obe->get_where('lecture_plan', ['plan_id' => (int)$plan_id])->row();
        if (!$plan) return [];

        $this->obe->from('assignment_question_bank AS aqb');
        $this->obe->where('aqb.status', 1);
        $this->obe->where('aqb.campus_id', (int)$plan->campus_id);
        $this->obe->where('aqb.subject_id', (int)$plan->subject_id);
        #$this->obe->where('aqb.topic_id', (int)$plan->topic_id);

        // Only require subtopic match if plan has a subtopic_id
        if (!empty($plan->subtopic_id)) {
           // $this->obe->where('aqb.subtopic_id', (int)$plan->subtopic_id);
        }

        // Optional: order for nicer display
        $this->obe->order_by('aqb.blooms_level IS NULL, aqb.blooms_level', 'ASC', false);
        $this->obe->order_by('aqb.marks IS NULL, aqb.marks', 'ASC', false);
        $this->obe->order_by('aqb.id', 'DESC');

        return $this->obe->get()->result();
    }

    # students of a subject/batch/whatever you filter by
    public function students_for_assignment($subject_id, $campus_id, $division=null, $batch=null, $sem=null, $stream_id=null) {
        // keep it simple: get all enrolled in subject (replace with your real view)
        $this->ums->from('student_subject_allotment'); // <- adjust to your actual mapping table/view
        $this->ums->where(['subject_id'=>$subject_id, 'campus_id'=>$campus_id]);
        if ($division)  $this->ums->where('division', $division);
        if ($batch)     $this->ums->where('batch', $batch);
        if ($sem)       $this->ums->where('semester', $sem);
        if ($stream_id) $this->ums->where('stream_id', $stream_id);
        return $this->ums->get()->result(); // expects columns: student_id, first_name, last_name, etc.
    }

    # ---------- CREATE ASSIGNMENT (TX + BATCH) ----------
    public function create_assignment($payload) {
        $now = date('Y-m-d H:i:s');
        $this->obe->trans_start();

        $master = [
            'campus_id'     => $payload['campus_id'],
            'subject_id'    => $payload['subject_id'],
            'faculty_id'    => $payload['faculty_id'],
            'lecture_plan_id'=> $payload['lecture_plan_id'] ?: null,
            'topic_id'      => $payload['topic_id'] ?: null,
            'subtopic_id'   => $payload['subtopic_id'] ?: null,
            'title'         => $payload['title'],
            'description'   => $payload['description'],
            'due_date'      => $payload['due_date'],
            'max_marks'     => $payload['max_marks'] ?: null,
            'status'        => 1,
            'created_at'    => $now,
            'updated_at'    => $now
        ];
		//echo '<pre>';print_r($master);exit;
        $this->obe->insert('assignment_master', $master);
        $assignment_id = $this->obe->insert_id();
		//echo $this->obe->last_query();exit;
        if (!empty($payload['question_ids'])) {
            $rows = [];
            foreach ($payload['question_ids'] as $qid) $rows[] = ['assignment_id'=>$assignment_id,'question_id'=>$qid];
            $this->obe->insert_batch('assignment_questions_map', $rows);
        }

        if (!empty($payload['student_ids'])) {
            $rows = [];
            foreach ($payload['student_ids'] as $sid) $rows[] = ['assignment_id'=>$assignment_id,'student_id'=>$sid];
            $this->obe->insert_batch('assignment_student_map', $rows);
        }

       $this->obe->trans_complete();
        if (!$this->obe->trans_status()) return false;
        return $assignment_id;
    }

    # ---------- LISTS ----------
    public function faculty_assignments($faculty_id, $subject_id = null, $campus_id = null)
	{
		$this->obe->select("
			am.*,
			am.max_marks,
			COUNT(DISTINCT sa.student_id) AS total_students,
			SUM(CASE WHEN sa.status = 'pending' THEN 1 ELSE 0 END) AS pending_count,
			SUM(CASE WHEN sa.status = 'submitted' THEN 1 ELSE 0 END) AS submitted_count,
			SUM(CASE WHEN sa.status = 'evaluated' THEN 1 ELSE 0 END) AS evaluated_count
		");
		$this->obe->from('assignment_master AS am');
		$this->obe->join('assignment_student_map AS sa', 'sa.assignment_id = am.id', 'left');
		$this->obe->where('am.faculty_id', $faculty_id);

		if ($subject_id) $this->obe->where('am.subject_id', $subject_id);
		if ($campus_id)  $this->obe->where('am.campus_id', $campus_id);

		$this->obe->group_by('am.id');
		$this->obe->order_by('am.created_at', 'DESC');

		return $this->obe->get()->result();
	}


    public function assignment_detail_old($assignment_id) {
        return $this->obe->get_where('assignment_master', ['id'=>$assignment_id])->row();
    }
	public function assignment_detail($assignment_id)
	{
		$umsDb = $this->ums->database; // e.g., 'umsdb'
		$this->obe->select('a.*, s.subject_name,s.subject_code');
		$this->obe->from('assignment_master a');
		$this->obe->join("{$umsDb}.subject_master s", 's.sub_id = a.subject_id', 'left');
		$this->obe->where('a.id', $assignment_id);
		return $this->obe->get()->row();
	}

    public function assignment_questions($assignment_id) {
        $this->obe->select('aq.*, qb.question_text, qb.marks, qb.course_outcome, qb.blooms_level');
        $this->obe->from('assignment_questions_map aq');
        $this->obe->join('assignment_question_bank qb', 'qb.id=aq.question_id', 'left');
        $this->obe->where('aq.assignment_id', $assignment_id);
        return $this->obe->get()->result();
    }

    public function assignment_students($assignment_id) {
        return $this->obe->get_where('assignment_student_map', ['assignment_id'=>$assignment_id])->result();
    }

    # ---------- SUBMISSION / EVALUATION ----------
// Save or update student submission
    public function submit_answer($assignment_id, $student_id, $data) {
        $exists = $this->obe->get_where("assignment_student_map", [
            'assignment_id' => $assignment_id,
            'student_id'    => $student_id
        ])->row();

        if ($exists) {
            $this->obe->where(['assignment_id' => $assignment_id, 'student_id' => $student_id]);
           $this->obe->update("assignment_student_map", $data);
        } else {
            $data['assignment_id'] = $assignment_id;
            $data['student_id'] = $student_id;
            $this->obe->insert("assignment_student_map", $data);
        }
		//echo $this->obe->last_query();exit;
    }
    public function evaluate($assignment_id, $student_id, $marks, $feedback, $evaluator) {
        $data = [
            'status'        => 'Evaluated',
            'marks_obtained'=> $marks,
            'feedback'      => $feedback,
            'evaluated_by'  => $evaluator,
            'evaluated_at'  => date('Y-m-d H:i:s')
        ];
        $this->obe->where(['assignment_id'=>$assignment_id,'student_id'=>$student_id])->update('assignment_student_map', $data);
        return $this->obe->affected_rows() > 0;
    }

    # ---------- STUDENT DASH ----------
    public function student_assignments($student_id) {
        $this->obe->select('am.*, asm.status, asm.submitted_at, asm.marks_obtained');
        $this->obe->from('assignment_student_map asm');
        $this->obe->join('assignment_master am', 'am.id=asm.assignment_id', 'left');
        $this->obe->where('asm.student_id', $student_id);
        $this->obe->order_by('am.due_date','ASC');
        return $this->obe->get()->result();
    }
	/* join student names from UMS DB */
	public function assignment_students_with_names($assignment_id)
	{
		// 1) Fetch mapped students from OBE
		$rows = $this->obe
			->order_by('id', 'ASC')
			->get_where('assignment_student_map', ['assignment_id' => $assignment_id])
			->result_array();
		//print_r($rows);exit;
		if (empty($rows)) return [];

		// 2) Build unique list of student IDs
		$student_ids = array_values(array_unique(array_column($rows, 'student_id')));
		if (empty($student_ids)) return [];

		// 3) Fetch student bio from UMS
		$students = $this->ums
			->select('stud_id, first_name, last_name, enrollment_no')
			->from('student_master')      // adjust if your view/table name differs
			->where_in('stud_id', $student_ids)
			->get()
			->result_array();

		// 4) Index by stud_id for fast merge
		$nameMap = [];
		foreach ($students as $s) {
			$nameMap[$s['stud_id']] = $s;
		}

		// 5) Merge back into OBE rows (preserve original order)
		foreach ($rows as &$r) {
			$s = $nameMap[$r['student_id']] ?? null;
			$r['first_name']    = $s['first_name']    ?? '';
			$r['last_name']     = $s['last_name']     ?? '';
			$r['enrollment_no'] = $s['enrollment_no'] ?? '';
			$r['roll_no']       = $s['roll_no']       ?? '';
		}
		unset($r); // break reference

		// Return as objects to match CI result() style
		return json_decode(json_encode($rows));
	}


	/* build topic/subtopic context using OBE */
	public function assignment_context($assignment)
	{
		$ctx = (object)['topic_label'=>'', 'subtopic_label'=>''];
		if (!$assignment) return $ctx;

		$topic = null; $sub = null;
		if (!empty($assignment->topic_id)) {
			$this->obe->from('syllabus_topics');
			$this->obe->where([
				'topic_id'   => $assignment->topic_id,
				'subject_id' => $assignment->subject_id
			]);
			$topic = $this->obe->get()->row();
		}
		if (!empty($assignment->subtopic_id)) {
			$this->obe->from('syllabus_subtopics');
			$this->obe->where([
				'subtopic_id' => $assignment->subtopic_id
			]);
			$sub = $this->obe->get()->row();
		}
		if ($topic)     $ctx->topic_label    = trim(($topic->topic_order ? $topic->topic_order.'. ' : '').$topic->topic_title);
		if ($sub)       $ctx->subtopic_label = trim(($sub->srno ? $sub->srno.'. ' : '').$sub->subtopic_title);
		return $ctx;
	}
	
	public function get_student_assignments($student_id)
	{
		$umsDb = $this->ums->database; // e.g., 'umsdb'

		$this->obe->select("
			asm.id AS map_id,am.max_marks,am.is_closed,am.created_at,
			am.id  AS assignment_id,
			am.title, am.description, am.due_date,
			asm.status, asm.answer_file, asm.submitted_at,
			sm.subject_name,asm.marks_obtained,am.subject_id
		");
		$this->obe->from('assignment_student_map asm');
		$this->obe->join('assignment_master am', 'am.id = asm.assignment_id', 'left');
		$this->obe->join("{$umsDb}.subject_master sm", 'sm.sub_id = am.subject_id', 'left', false);
		$this->obe->where('asm.student_id', (int)$student_id);
		$this->obe->order_by('am.due_date', 'ASC');

		$q = $this->obe->get();
		if (!$q) {
			$err = $this->obe->error();
			show_error('DB Error: '.$err['message']); // swap to log_message in prod
			return [];
		}
		return $q->result();
	}

    // Fetch assignment details with student status
   public function get_assignment_details($assignment_id, $student_id)
{
    $umsDb = $this->ums->database; // e.g. 'umsdb'

    $this->obe->select("
        a.*,
        s.subject_name,
        asm.status, asm.answer_text, asm.answer_file,
        asm.submitted_at, asm.marks_obtained, asm.feedback
    ", false);

    $this->obe->from('assignment_master a');

    // Important: tell CI not to escape the table string so the "<db>.<table> alias" stays intact.
    $this->obe->join($umsDb . '.subject_master s', 'a.subject_id = s.sub_id', 'left', false);

    $this->obe->join(
        'assignment_student_map asm',
        'asm.assignment_id = a.id AND asm.student_id = ' . $this->obe->escape($student_id),
        'left',
        false
    );

    $this->obe->where('a.id', (int)$assignment_id);

    // (Optional) See the SQL that will run:
    // $sql = $this->obe->get_compiled_select();
    // log_message('debug', '[get_assignment_details] SQL: ' . $sql);

    $q = $this->obe->get();
    if ($q === false) {
        // Show useful debug info instead of calling row() on false
        $err = $this->obe->error(); // ['code'=>..., 'message'=>...]
        // For quick on-screen debugging (remove in production):
        echo '<pre>SQL ERROR: ' . print_r($err, true) . "\n\n";
        echo "LAST QUERY:\n" . $this->obe->last_query() . '</pre>';
        exit;
    }

    return $q->row();
}


    // Fetch questions for an assignment
    public function get_assignment_questions($assignment_id) {
        $this->obe->select("q.*");
        $this->obe->from("assignment_questions_map aqm");
        $this->obe->join("assignment_question_bank q", "aqm.question_id = q.id", "left");
        $this->obe->where("aqm.assignment_id", $assignment_id);
        return $this->obe->get()->result();
		// echo "LAST QUERY:\n" . $this->obe->last_query() . '</pre>';
    }


    public function submit_assignment($map_id, $file_name)
    {
        $data = [
            'submission_file' => $file_name,
            'submitted_at'    => date('Y-m-d H:i:s'),
            'status'          => 'Submitted'
        ];
        return $this->obe->where('id', $map_id)
                         ->update('assignment_student_map', $data);
    }
	
	public function getAssignmentById($assignment_id)
	{
		return $this->obe->get_where('assignment_master', ['id' => $assignment_id])->row();
	}

	public function closeAssignment($assignment_id)
	{
		$this->obe->where('id', $assignment_id);
		return $this->obe->update('assignment_master', [
			'is_closed' => 1,
			'closed_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		]);
	}
	public function reopenAssignment($assignment_id)
	{
		$this->obe->where('id', $assignment_id);
		return $this->obe->update('assignment_master', [
			'is_closed' => 0,
			'closed_at' => NULL,
			'updated_at' => date('Y-m-d H:i:s')
		]);
	}

	public function calculate_cia1_marks($subject_id, $campus_id)
{
    // ✅ Step 1: Calculate obtained (only Evaluated) and total max (all)
    $this->obe->select("
        asm.student_id,
        SUM(CASE WHEN asm.status = 'Evaluated' THEN asm.marks_obtained ELSE 0 END) AS total_obtained,
        SUM(am.max_marks) AS total_max
    ", false);
    $this->obe->from('assignment_student_map asm');
    $this->obe->join('assignment_master am', 'am.id = asm.assignment_id', 'inner');
    $this->obe->where('am.subject_id', $subject_id);
    $this->obe->where('am.campus_id', $campus_id);
    $this->obe->group_by('asm.student_id');
    $evaluated = $this->obe->get()->result();

    // echo $this->obe->last_query(); exit; // uncomment for debugging if needed

    // ✅ Step 2: Get all students who have assignments in this subject
    $students = $this->obe->select('DISTINCT asm.student_id', false)
                          ->from('assignment_student_map asm')
                          ->join('assignment_master am', 'am.id = asm.assignment_id', 'inner')
                          ->where('am.subject_id', $subject_id)
                          ->where('am.campus_id', $campus_id)
                          ->get()
                          ->result_array();

    // ✅ Step 3: Map evaluated data
    $evalMap = [];
    foreach ($evaluated as $e) {
        $evalMap[$e->student_id] = $e;
    }

    // ✅ Step 4: Insert or update CIA-1 marks for each student
    foreach ($students as $stu) {
        $sid = $stu['student_id'];
        $obt = isset($evalMap[$sid]) ? (float)$evalMap[$sid]->total_obtained : 0;
        $max = isset($evalMap[$sid]) ? (float)$evalMap[$sid]->total_max : 0;
        $cia_marks = ($max > 0) ? round(($obt / $max) * 10, 2) : 0;

        $data = [
            'student_id'        => $sid,
            'subject_id'        => $subject_id,
            'campus_id'         => $campus_id,
            'cia_number'        => 1, // CIA-1
            'marks_obtained'    => $obt,
            'max_marks'         => $max,
            'cia_marks_outof10' => $cia_marks,
            'status'            => 'Evaluated'
        ];

        // Upsert (replace if exists)
        $exists = $this->obe->where('student_id', $sid)
                            ->where('subject_id', $subject_id)
                            ->where('cia_number', 1)
                            ->get('student_internal_assessment')
                            ->row();

        if ($exists) {
            $this->obe->where('id', $exists->id)->update('student_internal_assessment', $data);
        } else {
            $this->obe->insert('student_internal_assessment', $data);
        }
    }

    return true;
}

}
