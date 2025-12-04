<?php
class Responsibilities_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_branch_details($branch_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($branch_id!="")
        {
            $where.=" AND branch_id='".$branch_id."'";
        }
        
        $sql="select branch_id,branch_code,branch_name,status From branch_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }  
	
	
	function  get_faculty_details()
    {
	
	  $DB1 = $this->load->database('umsdb', TRUE);  
        $where=" WHERE 1=1 ";  
        $sql="select * From vw_faculty $where ";
        $query = $DB1->query($sql);
        return $query->result_array();
    }  
	
	
	
	 function  staff_details()
    {
        $where=" WHERE 1=1 ";  
        
        
          $DB1 = $this->load->database('umsdb', TRUE);  
        $sql="select * From staff_documents join vw_faculty on staff_documents.staff_id=vw_faculty.emp_reg_id $where ";
        $query = $DB1 ->query($sql);
        return $query->result_array();
    }  
	
	function get_pdf_details(){
		$uid=$this->session->userdata('uid');
		$where=" WHERE 1=1 ";  
		$DB1 = $this->load->database('umsdb', TRUE);  
        $sql="select * From staff_documents join vw_faculty on staff_documents.staff_id=vw_faculty.emp_reg_id  join sandipun_erp.user_master on sandipun_erp.user_master.username=vw_faculty.emp_id  $where and sandipun_erp.user_master.um_id=$uid";
        $query = $DB1 ->query($sql);
		return $query->row();
		//print_r($this->session->all_userdata());
		//exit;
	}
}