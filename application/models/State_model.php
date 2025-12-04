<?php
class State_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_state_details($state_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($state_id!="")
        {
            $where.=" AND state_id='".$state_id."'";
        }
        
        $sql="select state_id,state_name,status From state_master $where "; 
        $query = $this->db->query($sql);
        return $query->result_array();
    }  
}