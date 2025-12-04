<?php
class Course_branch_reln_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_details($ccb_id='',$campus_id,$college_id='',$course_id='',$branch_id='')
    {
        
        $where=" WHERE cm.status='Y' AND cm2.status='Y' AND bm.status='Y' AND cm3.status='Y' ";  
        
        if($ccb_id!="")
        {
            $where.=" AND ccb.ccb_id='".$ccb_id."'";
        }
        if($campus_id!="")
        {
            $where.=" AND cm3.campus_id='".$campus_id."'";
        }
        if($college_id!="")
        {
            $where.=" AND cm.college_id='".$college_id."'";
        }
        if($course_id!="")
        {
            $where.=" AND cm2.course_id='".$course_id."'";
        }
        if($branch_id!="")
        {
            $where.=" AND bm.branch_id='".$branch_id."'";
        }
        
        $sql="SELECT cm3.campus_name,cm3.campus_id,cm.college_code,cm.college_id,cm2.course_code,cm2.course_id,bm.branch_name,bm.branch_id,ccb.ccb_id,ccb.status 
                FROM college_course_branch_reln ccb 
                RIGHT JOIN college_master cm on cm.college_id=ccb.college_id
                RIGHT JOIN course_master cm2 on cm2.course_id=ccb.course_id
                RIGHT JOIN campus_master cm3 on cm3.campus_id=cm.campus_id
                RIGHT JOIN branch_master bm on bm.branch_id=ccb.branch_id $where ";
        $query = $this->db->query($sql);        
        return $query->result_array();
    }  

     function  get_course_details($course_id='')
    {
        $where=" WHERE status='Y' ";  
        
        if($course_id!="")
        {
            $where.=" AND course_id='".$course_id."'";
        }
        
        $sql="select course_id,course_code,course_name,course_type,duration,status From course_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } 

    function  get_branch_details($branch_id='')
    {
        $where=" WHERE status='Y' ";  
        
        if($branch_id!="")
        {
            $where.=" AND branch_id='".$branch_id."'";
        }
        
        $sql="select branch_id,branch_code,branch_name,status From branch_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } 
}