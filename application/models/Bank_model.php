<?php
class Bank_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_bank_details($bank_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($bank_id!="")
        {
            $where.=" AND bank_id='".$bank_id."'";
        }
        
        $sql="select bank_id,branch_name,account_name,bank_code,bank_name,bank_address,bank_account_no,bank_micr,bank_ifsc,status From bank_master $where ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }  
}