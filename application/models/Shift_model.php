<?php
class Shift_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_shift_details($shift_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($shift_id!="")
        {
            $where.=" AND shift_id='".$shift_id."'";
        }
        
        $sql="select shift_id,shift_name,shift_start_time,shift_end_time,status From shift_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }  
}