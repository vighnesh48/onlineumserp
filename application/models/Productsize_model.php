<?php
class Productsize_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_productsize_details($productsize_id='')
    {
		$secondDB = $this->load->database('umsdb', TRUE);
 
        $where=" WHERE 1=1 ";  
        
        if($productsize_id!="")
        {
            $where.=" AND ps.id='".$productsize_id."'";
        }
        
        $sql="select ps.*,p.product_name from productsizemaster as ps LEFT join productmaster as p On ps.product_id=p.id $where ORDER BY product_id";
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
		
    }  

    function get_proudcts()
    {
		$secondDB = $this->load->database('umsdb', TRUE);
        $sql="select * from productmaster";
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
    }

     function get_ps($product_id,$sizecode,$size)
    {
        $secondDB = $this->load->database('umsdb', TRUE);
        $sql="select * from productsizemaster where product_id=".$product_id." AND size='".$size."'";
        $query = $secondDB->query($sql);
       // echo $secondDB->last_query();
        return $query->result();
    }
}