<?php
class Common_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }

    function  get_campus_details($campus_id='')
    {
        $where=" WHERE status='Y' ";  
        
        if($campus_id!="")
        {
            $where.=" AND campus_id='".$campus_id."'";
        }
        
        $sql="select campus_id,campus_code,campus_name,status From campus_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function  get_campuswise_college_details($campus_id='',$college_id='')
    {
        $where=" WHERE cm.status='Y' AND cm2.status='Y' ";  
        
        if($campus_id!="")
        {
            $where.=" AND cm2.campus_id='".$campus_id."'";
        }
        if($college_id!="")
        {
            $where.=" AND cm.college_id='".$college_id."'";
        }
        
        $sql="select cm.college_id,cm.college_code,cm.college_name,cm.status,cm2.campus_id,cm2.campus_code,cm2.campus_name
              From college_master cm 
              INNER JOIN campus_master cm2 on cm2.campus_id=cm.campus_id 
              $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function  get_collegewise_course_details($campus_id,$college_id='',$course_id='',$branch_id='')
    {
        
        $where=" WHERE ccb.status='Y' AND cm.status='Y' AND cm2.status='Y' AND bm.status='Y' AND cm3.status='Y' ";  
        
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
                INNER JOIN college_master cm on cm.college_id=ccb.college_id
                INNER JOIN course_master cm2 on cm2.course_id=ccb.course_id
                INNER JOIN campus_master cm3 on cm3.campus_id=cm.campus_id
                INNER JOIN branch_master bm on bm.branch_id=ccb.branch_id $where ";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    
}
    ?>