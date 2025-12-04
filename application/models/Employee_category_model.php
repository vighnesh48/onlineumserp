<?php
class Employee_category_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_Category_details($emp_cat_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($emp_cat_id!="")
        {
            $where.=" AND emp_cat_id='".$emp_cat_id."'";
        }
        
        $sql="select emp_cat_id ,emp_cat_name,status From employee_category $where ";
		/* echo $this->db->last_query();
		die(); */
        $query = $this->db->query($sql);
        return $query->result_array();
    }  
}