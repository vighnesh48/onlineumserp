<?php
class Caste_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_caste_details($caste_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($caste_id!="")
        {
            $where.=" AND caste_id='".$caste_id."'";
        }
        
        $sql="select caste_id,caste_code,caste_name,status From caste_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }  
}