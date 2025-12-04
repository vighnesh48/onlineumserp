<?php
class Department_designation_reln_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_mapping_details($ddr_id='',$department_id='',$designation_id='')
    {
        $where=" WHERE dm.status='Y' AND dm2.status='Y' ";  
        
        if($ddr_id!="")
        {
            $where.=" AND ddr_id='".$ddr_id."'";
        }
        if($department_id!="")
        {
            $where.=" AND department_id='".$department_id."'";
        }
        if($designation_id!="")
        {
            $where.=" AND designation_id='".$designation_id."'";
        }
        
        $sql="select dm.department_name,dm.department_id,dm2.designation_id,dm2.designation_name,ddr.ddr_id,ddr.status From department_designation_reln ddr"
                . " INNER JOIN department_master dm on dm.department_id=ddr.department_id"
                . " INNER JOIN designation_master dm2 on dm2.designation_id=ddr.designation_id "
                . " $where ";
        //echo $sql; die;
        $query = $this->db->query($sql);
        return $query->result_array();
    }  
    
    function get_department_details($department_id='')
    {
        if($department_id!="")
        {
            $where.=" AND department_id='".$department_id."'";
        }
        
        $sql="select * From department_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    function  get_designation_details($designation_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($designation_id!="")
        {
            $where.=" AND designation_id='".$designation_id."'";
        }
        
        $sql="select designation_id,designation_code,designation_name,status From designation_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
}