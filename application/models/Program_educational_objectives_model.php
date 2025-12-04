<?php
class Program_educational_objectives_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
		public function get_program_edu_obj_details($id = '', $stream_id = '', $campus_id = '')
    {
		$DB = $this->load->database('obe', TRUE); 
        $sql = "SELECT peo_id, program_id, campus_id, peo_number, peo_description, status 
                FROM program_educational_objectives WHERE 1=1";
        $params = [];

        if (!empty($id)) {
            $sql .= " AND peo_id = ?";
            $params[] = $id;
        }

        if (!empty($stream_id)) {
            $sql .= " AND program_id = ?";
            $params[] = $stream_id;
        }

        if (!empty($campus_id)) {
            $sql .= " AND campus_id = ?";
            $params[] = $campus_id;
        }

        $query = $DB->query($sql, $params);
        return ($id != '') ? $query->row_array() : $query->result_array();
    }


}