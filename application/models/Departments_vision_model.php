<?php
class Departments_vision_model extends CI_Model {

    public function get_all() {
		$DB3 = $this->load->database('obe', TRUE); // for institutes_vision
		$DB2 = $this->load->database('umsdb', TRUE); // for school_master (different DB)

		$db3Name = $DB3->database;
		$db2Name = $DB2->database;

		$sql = "
			SELECT v.*, s.school_name,s.stream_name
			FROM {$db3Name}.departments_vision AS v
			LEFT JOIN {$db2Name}.vw_stream_details AS s ON s.stream_id = v.department_id
		";

		return $DB3->query($sql)->result();
		}

    public function get_by_id($id) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->get_where('departments_vision', ['id' => $id])->row();
    }

    public function insert($data) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->insert('departments_vision', $data);
    }

    public function update($id, $data) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->where('id', $id)->update('departments_vision', $data);
    }

    public function delete($id) {
		$DB3 = $this->load->database('obe', TRUE);
        return $DB3->where('id', $id)->delete('departments_vision');
    }

    public function get_institutes($campus_id) {
		if($campus_id==1){
			$DB2 = $this->load->database('umsdb', TRUE);
		}elseif($campus_id==2){
			$DB2 = $this->load->database('sjumsdb', TRUE);
		}else{
			$DB2 = $this->load->database('sfumsdb', TRUE);
		}
        return $DB2->where('is_active', 'Y')->get('school_master')->result();// Assuming institutes table exists
    }
	function get_courses($school_code, $campus_id){
		$exam = explode('-',$exam_session);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_id =$exam[2];
		$sql="select v.course_id, v.course_name, v.course_short_name from vw_stream_details v where v.school_id='$school_code' and is_active='Y' group by v.course_id";	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();		die();  
		return $query->result_array();
	}
	function getStreamsBySchoolCourse($course_id, $campus_id,$school_code){

		$DB1 = $this->load->database('umsdb', TRUE); 
	
		$DB1->select('stream_id, stream_name, stream_short_name');
		$DB1->from('vw_stream_details');
		$DB1->where_in('school_id', $school_code);		
		$DB1->where('course_id', $course_id);
		$query = $DB1->get();

		// echo $DB1->last_query();exit;

		$stream_details = $query->result_array();
		return $stream_details;
	}
}
