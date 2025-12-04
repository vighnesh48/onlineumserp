<?php

class Remuneration_model extends CI_Model 
{

    function __construct()
    {
        parent::__construct();
    } 
	
    function get_unittest_details($id = '') {
        $DB1 = $this->load->database('umsdb', TRUE);  
		if($id!=''){
			$DB1->where('unit_test_id', $id);  
		}
		$DB1->from('student_test_master');
		$DB1->order_by("unit_test_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
}
?>