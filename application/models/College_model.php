<?php
class College_model extends CI_Model 
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
        
        $sql="select campus_id,campus_name,status From campus_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } 
    
    function  get_college_details($college_id='')
    {
        //$where=" WHERE cm.status='Y' AND cm2.status='Y' ";  
        $where=" WHERE 1=1 ";  
        
        if($college_id!="")
        {
            $where.=" AND college_id='".$college_id."'";
        }
        
        $sql="select cm2.campus_id,cm2.campus_name ,cm.college_id,cm.college_code,cm.college_name,cm.college_state,cm.college_city,cm.college_state,cm.college_address,cm.college_pincode,cm.status 
              From college_master  cm 
              INNER JOIN campus_master cm2 on cm2.campus_id=cm.campus_id
              
              $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function  get_college_search_details($college_id='')
    {
        $where=" WHERE cm.status='Y' AND cm2.status='Y' ";  
        
        if($college_id!="")
        {
            $where.=" AND college_id='".$college_id."'";
        }
        
        $sql="select cm2.campus_id,cm2.campus_name ,cm.college_id,cm.college_code,cm.college_name,cm.college_state,cm.college_city,cm.college_state,cm.college_address,cm.college_pincode,cm.status 
              From college_master  cm 
              INNER JOIN campus_master cm2 on cm2.campus_id=cm.campus_id
              
              $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}