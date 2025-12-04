<?php
class Branch_model extends CI_Model 
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
}