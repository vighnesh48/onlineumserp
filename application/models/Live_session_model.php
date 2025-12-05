<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Live_session_model extends CI_Model {
	protected $umsdb;   // second DB connection
	protected $table = 'live_sessions';	
	
    public function __construct()
{
    parent::__construct();
    $this->umsdb = $this->load->database('umsdb', TRUE);
    $this->table = 'live_sessions';
}
    

    public function create($data) {
         $this->umsdb->insert($this->table, $data);
        return  $this->umsdb->insert_id();
    }

    public function get($id) {
        return  $this->umsdb->get_where($this->table, ['id' => $id])->row();
    }

   public function list_all($faculty_id = null)
{
    // Resolve faculty id: prefer supplied, otherwise use session
    if (empty($faculty_id)) {
        // model has access to session library in CI
        $faculty_id = $this->session->userdata('name');
    }

    // If still empty, return empty result to avoid exposing all records
    if (empty($faculty_id)) {
        return [];
    }

    return $this->umsdb
        ->select('ls.*, sm.subject_name, sm.subject_code')
        ->from($this->table . ' ls')
        ->join('subject_master sm', 'sm.sub_id = ls.subject_id', 'left')
        ->where('ls.faculty_id', $faculty_id)
        ->order_by('ls.start_time', 'DESC')
        ->get()
        ->result();
}
public function get_sessions_for_student($student_id, $from = null, $to = null)
    {
        if (empty($student_id)) {
            return [];
        }

        $subjectIds = [];

        // ---------- 1) Try student_applied_subject ----------
        if ($this->umsdb->table_exists('student_applied_subject')) {
            $rows = $this->umsdb
                ->select('subject_id')
                ->from('student_applied_subject')
                ->where('stud_id', $student_id)
                ->where('is_active', 'Y')
                ->get()
                ->result();

            if (!empty($rows)) {
                foreach ($rows as $r) {
                    $subjectIds[] = (int)$r->subject_id;
                }
            }
        }

        // ---------- 2) Try other enrollment tables if none found ----------
        if (empty($subjectIds)) {
            $possibleEnrollTables = [
                'enrollments',
                'student_subjects',
                'student_enrollment',
                'student_subject_map',
                'student_course_map',
                'stu_enrollments'
            ];

            foreach ($possibleEnrollTables as $tbl) {
                if ($this->umsdb->table_exists($tbl)) {
                    $cols = $this->umsdb->list_fields($tbl);
                    $subjectCol = null;
                    foreach (['subject_id','sub_id','subject_master_id','subject'] as $c) {
                        if (in_array($c, $cols)) { $subjectCol = $c; break; }
                    }
                    $studentCol = in_array('student_id', $cols) ? 'student_id' : (in_array('stud_id',$cols) ? 'stud_id' : null);

                    if (!$studentCol || !$subjectCol) {
                        continue;
                    }

                    $q = $this->umsdb
                        ->select($subjectCol)
                        ->from($tbl)
                        ->where($studentCol, $student_id);

                    if (in_array('is_active', $cols)) {
                        $q->where('is_active', 'Y');
                    }

                    $rows = $q->get()->result();

                    if (!empty($rows)) {
                        foreach ($rows as $r) {
                            $subjectIds[] = (int)$r->{$subjectCol};
                        }
                        break; // stop at first enrollment table that returns results
                    }
                }
            }
        }

        // Deduplicate
        $subjectIds = array_values(array_filter(array_unique($subjectIds)));

        // ---------- 3) Fallback to infer from student_master if still empty ----------
        if (empty($subjectIds) && $this->umsdb->table_exists('student_master')) {
            $stu = $this->umsdb->get_where('student_master', ['stud_id' => $student_id])->row();
            if ($stu) {
                $where = [];

                // Map likely student fields to subject_master columns (adjust if needed)
                if (!empty($stu->admission_stream))      $where['stream_id'] = $stu->admission_stream;
                elseif (!empty($stu->previous_stream))   $where['stream_id'] = $stu->previous_stream;

                if (!empty($stu->admission_year) && is_numeric($stu->admission_year)) $where['academic_year'] = $stu->admission_year;
                elseif (!empty($stu->academic_year)) $where['academic_year'] = $stu->academic_year;

                if (!empty($stu->current_semester)) $where['semester'] = $stu->current_semester;
                elseif (!empty($stu->admission_semester)) $where['semester'] = $stu->admission_semester;

                if (!empty($stu->kp_id) && is_numeric($stu->kp_id)) $where['course_id'] = $stu->kp_id;
                elseif (!empty($stu->package_id)) $where['course_id'] = $stu->package_id;

                if (!empty($where)) {
                    $qb = $this->umsdb->select('sub_id')->from('subject_master');
                    foreach ($where as $k => $v) {
                        if ($this->umsdb->field_exists($k, 'subject_master')) {
                            $qb->where($k, $v);
                        }
                    }
                    $subRows = $qb->get()->result();
                    foreach ($subRows as $sr) $subjectIds[] = (int)$sr->sub_id;
                    $subjectIds = array_values(array_unique($subjectIds));
                }
            }
        }

        // If still empty, nothing to show
        if (empty($subjectIds)) {
            return [];
        }

        // ---------- 4) Fetch live_sessions for these subjects with optional date filter ----------
        $db = $this->umsdb;
        $db->select('ls.*');
        $db->from($this->table . ' ls');
        $db->where_in('ls.subject_id', $subjectIds);

        // only sessions with start_time
        $db->where('ls.start_time IS NOT NULL', null, false);

        // date range filters (if provided)
        if (!empty($from)) {
            // accept date or datetime strings
            $db->where('ls.end_time >=', $from);
        }
        if (!empty($to)) {
            $db->where('ls.start_time <=', $to);
        }

        $db->order_by('ls.start_time', 'ASC');

        $sessions = $db->get()->result();
        if (empty($sessions)) {
            return [];
        }

        // ---------- 5) fetch subject info and attach ----------
        $subs = $this->umsdb
            ->select('sub_id, subject_name, subject_code')
            ->from('subject_master')
            ->where_in('sub_id', $subjectIds)
            ->get()
            ->result();

        $map = [];
        foreach ($subs as $s) $map[$s->sub_id] = $s;

        $events = [];
        foreach ($sessions as $s) {
            $subject = isset($map[$s->subject_id]) ? $map[$s->subject_id] : null;
            $events[] = (object)[
                'id'           => $s->id,
                'title'        => ($s->title),
                'start'        => date('c', strtotime($s->start_time)),
                'end'          => $s->end_time ? date('c', strtotime($s->end_time)) : null,
                'meet_link'    => $s->meet_link,
                'subject_name' => $subject ? $subject->subject_name : null,
                'subject_code' => $subject ? $subject->subject_code : null,
            ];
        }

        return $events;
    }

    /**
     * Optional helper: list all sessions for a faculty (for admin/faculty view).
     * @param int|null $faculty_id
     * @return array
     */
    public function list_all_for_faculty($faculty_id = null)
    {
        if (empty($faculty_id)) {
            return [];
        }

        return $this->umsdb
            ->select('ls.*, sm.subject_name, sm.subject_code')
            ->from($this->table . ' ls')
            ->join('subject_master sm', 'sm.sub_id = ls.subject_id', 'left')
            ->where('ls.faculty_id', $faculty_id)
            ->order_by('ls.start_time', 'DESC')
            ->get()
            ->result();
    }
	public function mark_leave($attendance_id)
{
    if (empty($attendance_id)) return false;

    // fetch the row using umsdb connection
    $row = $this->umsdb->get_where($this->table, ['id' => $attendance_id])->row();

    if (!$row) {
        log_message('warning', "mark_leave: attendance row not found id={$attendance_id}");
        return false;
    }

    // if already left, nothing to do
    if (!empty($row->left_at)) {
        log_message('info', "mark_leave: already left id={$attendance_id} left_at={$row->left_at}");
        return false;
    }

    $left = date('Y-m-d H:i:s');
    $joined_ts = strtotime($row->joined_at) ?: time();
    $duration = max(0, strtotime($left) - $joined_ts);

    $this->umsdb->where('id', $attendance_id)->update($this->table, [
        'left_at' => $left,
        'duration_seconds' => $duration,
        'last_ping_at' => $left
    ]);

    $affected = $this->umsdb->affected_rows();

    if ($affected > 0) {
        log_message('info', "mark_leave: updated id={$attendance_id} duration={$duration}");
        return true;
    } else {
        log_message('error', "mark_leave: update failed for id={$attendance_id} (affected_rows={$affected}) -- last_query=".$this->umsdb->last_query());
        return false;
    }
}

/**
 * Get row by id for debug/diagnostic (returns object or null).
 * WARNING: only for debugging; remove or restrict in production.
 */
public function get_by_id_for_debug($attendance_id)
{
    if (empty($attendance_id)) return null;
    return $this->umsdb->get_where($this->table, ['id' => $attendance_id])->row();
}
}
