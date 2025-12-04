<?php
class Quota_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_quota_details($quota_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($quota_id!="")
        {
            $where.=" AND quota_id='".$quota_id."'";
        }
        
        $sql="select quota_id,quota_code,quota_name,status From quota_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }  
}