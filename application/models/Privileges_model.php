<?php
class Privileges_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_privileges_details($privileges_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($privileges_id!="")
        {
            $where.=" AND privileges_id='".$privileges_id."'";
        }
        
        $sql="select privileges_id,privileges_name,status From privileges_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } 
    
    function  get_privileges_details_search($para='')
    {
        $where=" WHERE 1=1 ";  
        
        if($para!="")
        {
            $where.=" AND privileges_id like '%".$para."%' OR privileges_name like '%".$para."%' ";
        }
        
        $sql="select privileges_id,privileges_name,status From privileges_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}