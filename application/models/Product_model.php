<?php
class Product_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_product_details($product_id='')
    {
		$secondDB = $this->load->database('umsdb', TRUE);
 
        $where=" WHERE 1=1 ";  
        
        if($product_id!="")
        {
            $where.=" AND id='".$product_id."'";
        }
        
        $sql="select * From productmaster $where ";
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query($sql); die;
        return $query->result_array();
    }  
}