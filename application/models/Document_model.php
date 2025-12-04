<?php
class Document_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_document_details($document_id='')
    {
        $where=" WHERE 1=1 ";  
        
        if($document_id!="")
        {
            $where.=" AND document_id='".$document_id."'";
        }
        
        $sql="select document_id,document_name,status From document_master $where "; 
        $query = $this->db->query($sql);
        return $query->result_array();
    }  
}