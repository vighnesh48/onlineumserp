<?php
class Department_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_department_details($department_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($department_id!="")
        {
            $where.=" AND department_id='".$department_id."'";
        }
        
        $sql="select department_id,school_college_id,department_name,status From department_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
function getAllschool(){
	$sql="select college_id,campus_id,college_code,college_name,college_city from college_master where status='Y'";
     $query=$this->db->query($sql);
	 return $query->result_array();
	}
		
}