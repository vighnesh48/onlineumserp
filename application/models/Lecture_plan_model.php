<?php
class Lecture_plan_model extends CI_Model {

    private $table = 'lecture_plan';

    public function get_all_old($subject_id, $faculty_id, $campus_id,$subdetails) {
		$DB3 = $this->load->database('obe', TRUE);     // Contains lecture_plan
		if($campus_id==1){
			$DB2 = $this->load->database('umsdb', TRUE);
		}elseif($campus_id==2){
			$DB2 = $this->load->database('sjumsdb', TRUE);
		}else{
			$DB2 = $this->load->database('sfumsdb', TRUE);
		}   // Contains faculty_master and subject_master
		$sub=base64_decode($subdetails);
		if(!empty($sub)){
			$division=$sub[2];
			$batch=$sub[3];
		}
		
		// Get actual DB names
		$db3 = $DB3->database;
		$db2 = $DB2->database;

		$sql = "
			SELECT lp.*, 
				   f.fname, 
				   s.subject_name,t.topic_order,t.topic_title,st.srno,subtopic_title
			FROM {$db3}.lecture_plan lp
			LEFT JOIN {$db2}.vw_faculty f ON f.emp_id = lp.faculty_id
			LEFT JOIN {$db2}.subject_master s ON s.sub_id = lp.subject_id
			LEFT JOIN {$db3}.syllabus_topics t ON t.topic_id = lp.topic_id and t.subject_id=lp.subject_id 
			LEFT JOIN {$db3}.syllabus_subtopics st ON st.subtopic_id = lp.subtopic_id 
			WHERE lp.subject_id = ? 
			  AND lp.faculty_id = ? 
			  AND lp.campus_id = ?
		";

		return $DB3->query($sql, [$subject_id, $faculty_id, $campus_id])->result();
	}
	public function get_all($subject_id, $faculty_id, $campus_id, $subdetails) {
		$DB3 = $this->load->database('obe', TRUE);

		if ($campus_id == 1) {
			$DB2 = $this->load->database('umsdb', TRUE);
		} elseif ($campus_id == 2) {
			$DB2 = $this->load->database('sjumsdb', TRUE);
		} else {
			$DB2 = $this->load->database('sfumsdb', TRUE);
		}

		// Decode and explode subdetails
		$sub = base64_decode($subdetails);
		$division = '';
		$batch = '';

		if (!empty($sub)) {
			$sub_parts = explode('~', $sub);
			$division = isset($sub_parts[2]) ? $sub_parts[2] : '';
			$batch = isset($sub_parts[3]) ? $sub_parts[3] : '';
		}

		$db3 = $DB3->database;
		$db2 = $DB2->database;

		$sql = "
			SELECT lp.*, 
				   f.fname,f.lname,f.emp_id, 
				   s.subject_name, 
				   t.topic_order, t.topic_title, 
				   st.srno, st.subtopic_title
			FROM {$db3}.lecture_plan lp
			LEFT JOIN {$db2}.vw_faculty f ON f.emp_id = lp.faculty_id
			LEFT JOIN {$db2}.subject_master s ON s.sub_id = lp.subject_id
			LEFT JOIN {$db3}.syllabus_topics t ON t.topic_id = lp.topic_id AND t.subject_id = lp.subject_id
			LEFT JOIN {$db3}.syllabus_subtopics st ON st.subtopic_id = lp.subtopic_id
			WHERE lp.subject_id = ? 
			  AND lp.faculty_id = ? 
			  AND lp.campus_id = ?
		";

		$params = [$subject_id, $faculty_id, $campus_id];

		// Append division condition if set
		if (!empty($division)) {
			$sql .= " AND lp.division = ?";
			$params[] = $division;
		}

		// Append batch condition if set
		if (!empty($batch)) {
			$sql .= " AND lp.batch = ?";
			$params[] = $batch;
		}

		return $DB3->query($sql, $params)->result();
	}


    // 📌 Get lecture plan by ID
    public function get_by_id($plan_id) {
        $DB3 = $this->load->database('obe', TRUE);
        return $DB3->get_where($this->table, ['plan_id' => $plan_id])->row();
    }

    // ➕ Insert
    public function insert($data) {
        $DB3 = $this->load->database('obe', TRUE);
        $DB3->insert($this->table, $data);
        return $DB3->insert_id();
    }

    // ✏️ Update
    public function update($plan_id, $data) {
        $DB3 = $this->load->database('obe', TRUE);
        $DB3->where('plan_id', $plan_id);
        return $DB3->update($this->table, $data);
    }

    // ❌ Delete
    public function delete($plan_id) {
        $DB3 = $this->load->database('obe', TRUE);
        $DB3->where('plan_id', $plan_id);
        return $DB3->delete($this->table);
    }

	// 📚 Get topics by subject ID and campus ID with ordering
	public function get_topics_by_subject($subject_id, $campus_id) {
		$DB3 = $this->load->database('obe', TRUE);
		$DB3->where('subject_id', $subject_id);
		$DB3->where('campus_id', $campus_id);
		$DB3->order_by('topic_order', 'ASC');
		return $DB3->get('syllabus_topics')->result();
	}



    // 📚 Get subtopics by topic ID (AJAX)
    public function get_subtopics_by_topic($topic_id) {
        $DB3 = $this->load->database('obe', TRUE);
        return $DB3->get_where('syllabus_subtopics', ['topic_id' => $topic_id])->result();
    }

    // 👨‍🏫 Get faculty name
    public function get_faculty_name($faculty_id,$campus_id) {
		if($campus_id==1){
			$DB2 = $this->load->database('umsdb', TRUE);
		}elseif($campus_id==2){
			$DB2 = $this->load->database('sjumsdb', TRUE);
		}else{
			$DB2 = $this->load->database('sfumsdb', TRUE);
		}  
        $row = $DB2->get_where('vw_faculty', ['emp_id' => $faculty_id])->row();
        return $row ? $row->fname.' '.$row->lname.' ('.$row->designation_name.')' : '';
    }

    // 📘 Get subject name
    public function get_subject_name($subject_id,$campus_id) {
        if($campus_id==1){
			$DB2 = $this->load->database('umsdb', TRUE);
		}elseif($campus_id==2){
			$DB2 = $this->load->database('sjumsdb', TRUE);
		}else{
			$DB2 = $this->load->database('sfumsdb', TRUE);
		}  
        $row = $DB2->get_where('subject_master', ['sub_id' => $subject_id])->row();
        return $row ? $row->subject_name : '';
    }
	
	public function delete_course_plan($subject_id,$faculty_id,$campus_id,$subdetails) {
		$DB3 = $this->load->database('obedel', TRUE);
		// Step 4: Delete subject Plan
		$sub = base64_decode($subdetails);
		$division = '';
		$batch = '';

		if (!empty($sub)) {
			$sub_parts = explode('~', $sub);
			$division = isset($sub_parts[2]) ? $sub_parts[2] : '';
			$batch = isset($sub_parts[3]) ? $sub_parts[3] : '';
		}
		// Append division condition if set
		if (!empty($division)) {
			$DB3->where('division', $division);
		}

		// Append batch condition if set
		if (!empty($batch)) {
			$DB3->where('batch', $batch);
		}
		
		$DB3->where('subject_id', $subject_id);
		$DB3->where('campus_id', $campus_id);
		$DB3->where('faculty_id', $faculty_id);
		return $DB3->delete('lecture_plan');
	}
	public function getLecturePlanById($plan_id)
	{
		$DB3 = $this->load->database('obe', TRUE);

		$DB3->where('plan_id', $plan_id);
		$plan = $DB3->get('lecture_plan')->row_array();

		if ($plan) {
			$topic_title = get_topic_title($plan['topic_id'], $plan['subject_id'], $plan['campus_id']);
			$subtopic_title = '';
			if (!empty($plan['subtopic_id'])) {
				$subtopic_title = get_subtopic_title($plan['subtopic_id'], $plan['topic_id'], $plan['subject_id'], $plan['campus_id']);
			}
			$plan['topic_title'] = $topic_title;
			$plan['subtopic_title'] = $subtopic_title;
		}

		return $plan;
	}

	public function updateLecturePlanCompletionDate($plan_id, $date)
	{
		$DB3 = $this->load->database('obe', TRUE);

		$DB3->where('plan_id', $plan_id);
		$DB3->update('lecture_plan', ['date_of_completion' => $date, 'updated_at' => date('Y-m-d H:i:s')]);
	}
	public function hasAttendanceWithPlan($subject_id, $campus_id) {

		if($campus_id==1){
			$DB2 = $this->load->database('umsdb', TRUE);
		}elseif($campus_id==2){
			$DB2 = $this->load->database('sjumsdb', TRUE);
		}else{
			$DB2 = $this->load->database('sfumsdb', TRUE);
		}  
		return $DB2->where('subject_id', $subject_id)
				   ->where('plan_id IS NOT NULL', null, false)
				   ->limit(1)
				   ->count_all_results('attendance_master') >= 1;
				   
				  // echo $DB3->last_query();exit;
	}

}
