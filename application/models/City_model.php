<?php
class City_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_city_details($city_id='',$state_id='')
    {
        $where=" WHERE sm.status='Y' ";  
        
        if($city_id!="")
        {
            $where.=" AND cm.city_id='".$city_id."'";
        }
        if($state_id!="")
        {
            $where.=" AND sm.state_id='".$state_id."'";
        }
        
        $sql="select cm.city_id,cm.city_name,sm.state_id,sm.state_name,cm.status "
                . " From city_master cm "
                . " INNER JOIN state_master sm on sm.state_id=cm.state_id $where "; 
        $query = $this->db->query($sql);
        return $query->result_array();
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