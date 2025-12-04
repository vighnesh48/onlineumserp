<?php
class Course_outcomes_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
  function get_course_outcomes_details($id = '', $sub_id = '', $campus_id = '')
    {
		
		$DB = $this->load->database('obe', TRUE); 
        $sql = "SELECT id, subject_id, subject_code, campus_id, co_number, co_description, status 
                FROM course_outcomes WHERE 1=1";
        $params = [];

        if ($id !== '') {
            $sql .= " AND id = ?";
            $params[] = $id;
        }

        if ($sub_id !== '') {
            $sql .= " AND subject_id = ?";
            $params[] = $sub_id;
        }

        if ($campus_id !== '') {
            $sql .= " AND campus_id = ?";
            $params[] = $campus_id;
        }

        $query = $DB->query($sql, $params);

        return ($id !== '') ? $query->row_array() : $query->result_array();
    }

    function get_subjects_details($sub_id = '', $campus_id = '')
    {
        if ($campus_id == 1) {
            $DB = $this->load->database('umsdb', TRUE);
        } elseif ($campus_id == 2) {
            $DB = $this->load->database('sjumsdb', TRUE);
        } else {
            $DB = $this->load->database('sfumsdb', TRUE);
        }

        $DB->select('sub_id, subject_code, subject_name');
        $DB->from('subject_master');
        if (!empty($sub_id)) {
            $DB->where('sub_id', $sub_id);
        }

        return $DB->get()->row(); // return object
    }
	public function deletesubjectcos($subject_id,$campus_id) {
		$DB3 = $this->load->database('obedel', TRUE);
		$DB3->where('subject_id', $subject_id);
		$DB3->where('campus_id', $campus_id);
		return $DB3->delete('course_outcomes');
	}

}