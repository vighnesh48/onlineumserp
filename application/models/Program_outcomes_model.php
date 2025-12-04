<?php
class Program_outcomes_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
		function get_program_outcomes_details($id = '', $stream_id = '', $campus_id = '')
    {
		$DB = $this->load->database('obe', TRUE); 
        $sql = "SELECT id, campus_id, po_number, po_description, program_id, status FROM program_outcomes WHERE 1=1";
        $params = [];

        if ($id !== '') {
            $sql .= " AND id = ?";
            $params[] = $id;
        }

        if ($stream_id !== '') {
            $sql .= " AND program_id = ?";
            $params[] = $stream_id;
        }

        if ($campus_id !== '') {
            $sql .= " AND campus_id = ?";
            $params[] = $campus_id;
        }

        $query = $DB->query($sql, $params);
        return ($id !== '') ? $query->row_array() : $query->result_array();
    }

}



