<?php
class Organization_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_organization_details($organisation_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($organisation_id!="")
        {
            $where.=" AND organisation_id='".$organisation_id."'";
        }
        
        $sql="select organisation_id ,org_name,org_city,org_state,org_address,org_pincode,status From organization_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }  
}