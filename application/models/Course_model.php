<?php
class Course_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
  /*  function  get_course_details($course_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($course_id!="")
        {
            $where.=" AND course_id='".$course_id."'";
        }
        
        $sql="select course_id,course_code,course_name,course_type,duration,status From course_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    } */

    function  get_course_details($course_id='')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $where=" WHERE 1=1 ";  
        
        if($course_id!="")
        {
            $where.=" AND course_id='".$course_id."'";
        }
        
        $sql="select course_id,course_short_name,course_name From course_master $where ";
       
        $query = $DB1->query($sql); 
        if($query !== FALSE && $query->num_rows() > 0){
            foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
    }

    return $data;
    } 
    
    function  get_course_details_search($course_id='')
    {
         $DB1 = $this->load->database('umsdb', TRUE);
        $where=" WHERE 1=1 ";  
        
        if($course_id!="")
        {
            $where.=" AND course_id='".$course_id."'";
        }
        
        $sql="select course_id,course_short_name,course_name From course_master $where ";
       
        $query = $DB1->query($sql); 
        if($query !== FALSE && $query->num_rows() > 0){
            foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        }

    return $data;
    }
    /* function  get_course_details_search($course_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($course_id!="")
        {
            $where.=" AND course_id='".$course_id."'";
        }
        
        $sql="select course_id,course_code,course_name,course_type,duration,status From course_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }*/
}