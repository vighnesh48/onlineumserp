<?php
class Campus_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_campus_details($campus_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($campus_id!="")
        {
            $where.=" AND campus_id='".$campus_id."'";
        }
        
        $sql="select campus_id,campus_code,campus_name,campus_city,campus_state,campus_address,campus_pincode,status From campus_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } 
    
    function  get_campus_details_search($para='')
    {
        $where=" WHERE 1=1 ";  
        
        if($para!="")
        {
            $where.=" AND campus_code like '%".$para."%' OR campus_name like '%".$para."%' OR campus_city like '%".$para."%' OR campus_state like '%".$para."%' OR campus_address like '%".$para."%' OR campus_pincode like '%".$para."%' ";
        }
        
        $sql="select campus_id,campus_code,campus_name,campus_city,campus_state,campus_address,campus_pincode,status From campus_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}