<?php
class Roles_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_roles_details($roles_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($roles_id!="")
        {
            $where.=" AND roles_id='".$roles_id."'";
        }
        
        $sql="select roles_id,roles_name,roles_type,status From roles_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } 
    
    function  get_roles_details_search($para='')
    {
        $where=" WHERE 1=1 ";  
        
        if($para!="")
        {
            $where.=" AND roles_id like '%".$para."%' OR roles_name like '%".$para."%' OR roles_type like '%".$para."%' ";
        }
        
        $sql="select roles_id,roles_name,roles_type,status From roles_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}