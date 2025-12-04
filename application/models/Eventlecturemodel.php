<?php
class Eventlecturemodel extends CI_Model {


    function get_academic_years(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
        //print_r($emp_id);exit;
		$sql = "select academic_year,academic_session from academic_session ";		
		if(isset($role_id) && ($role_id==15 || $role_id==6 || $emp_id=='admin_1010') ){
			$sql .=" Order by academic_year desc limit 0,2";
		}elseif($emp_id == 'research_admin'){
			$sql .=" Order by academic_year desc limit 0,4";
			
		}else{
			$sql .="  where currently_active='Y'";
			
		}
		
		
		$query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		return $query->result_array();
		 
	}
    function getSchools() {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT school_id,school_short_name FROM school_master";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
   /* public function get_time_slots() {
        $DB1 = $this->load->database('umsdb', TRUE); 
        return $DB1->get('lecture_slot')->result_array();
    }*/
    public function get_time_slots($academic_year, $course_id, $stream_id, $semester, $division) {
        $DB1 = $this->load->database('umsdb', TRUE);
    
        $sql = "
            SELECT 
                ls.lect_slot_id, 
                ls.from_time, 
                ls.to_time, 
                ls.slot_am_pm,
                vf.fname, 
                vf.mname, 
                vf.lname,
                sm.subject_code,
                ltt.subject_type
            FROM lecture_time_table ltt
            LEFT JOIN vw_faculty vf ON vf.emp_id = ltt.faculty_code
            LEFT JOIN lecture_slot ls ON ls.lect_slot_id = ltt.lecture_slot
            LEFT JOIN subject_master sm ON sm.sub_id = ltt.subject_code
            WHERE ltt.academic_year = ?
            AND ltt.course_id = ?
            AND ltt.stream_id = ?
            AND ltt.semester = ?
            AND ltt.division = ?
			and ltt.faculty_code IS NOT NULL 
			and ltt.faculty_code !=''
            GROUP BY ltt.lecture_slot, vf.fname, vf.mname, vf.lname
            ORDER BY ls.from_time
        ";
    
        $query = $DB1->query($sql, [$academic_year, $course_id, $stream_id, $semester, $division]);
        return $query->result_array();
    }
    
    public function get_events($filters = []) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT e.*, s.school_short_name,sd.stream_name,sd.course_short_name,ls.from_time,ls.to_time,ls.slot_am_pm FROM event_lecture_drop e 
                LEFT JOIN school_master s ON e.school_id = s.school_id
                LEFT JOIN vw_stream_details sd ON e.stream_id = sd.stream_id
                LEFT JOIN lecture_slot ls ON e.time_slot = ls.lect_slot_id
                 WHERE 1=1
                 ORDER BY e.id DESC
                 ";

        if (!empty($filters['school_id'])) {
            $sql .= " AND e.school_id = " . $DB1->escape($filters['school_id']);
        }
        if (!empty($filters['course_id'])) {
            $sql .= " AND e.course_id = " . $DB1->escape($filters['course_id']);
        }
        if (!empty($filters['stream_id'])) {
            $sql .= " AND e.stream_id = " . $DB1->escape($filters['stream_id']);
        }
        if (!empty($filters['semester'])) {
            $sql .= " AND e.semester = " . $DB1->escape($filters['semester']);
        }
        if (!empty($filters['division'])) {
            $sql .= " AND e.division = " . $DB1->escape($filters['division']);
        }

        return $DB1->query($sql)->result_array();
    }

    public function insert_event($data) {
        $DB1 = $this->load->database('umsdb', TRUE);
    
        // print_r($data);exit;
        if (!$DB1->insert('event_lecture_drop', $data)) {
          // echo $DB1->last_query();exit;
            return false;
        }
        return $DB1->insert_id();
    }
    

    public function get_event_by_id($id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        return $DB1->get_where('event_lecture_drop', ['id' => $id])->row_array();
    }

    public function update_event($id, $data) {
        $DB1 = $this->load->database('umsdb', TRUE);
        return $DB1->where('id', $id)->update('event_lecture_drop', $data);
    }

    public function toggle_status($id, $status) {
        $DB1 = $this->load->database('umsdb', TRUE);
        return $DB1->where('id', $id)->update('event_lecture_drop', ['status' => $status]);
    }

    public function delete_event($id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        return $DB1->where('id', $id)->delete('event_lecture_drop');
    }

}
