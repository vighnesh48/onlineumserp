<?php
class School_product_map_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_school_product_details($school_product_id='')
    {
		$secondDB = $this->load->database('umsdb', TRUE);
 
        $where=" WHERE 1=1 ";  
        
        if($school_product_id!="")
        {
            $where.=" AND sc.id='".$school_product_id."'";
        }
        
        $sql="select sc.*,s.school_name,p.product_name as product_name from schoolproduct as sc  
		LEFT join schoolmaster as s On sc.school_id=s.id 
		LEFT JOIN productmaster as p On sc.product_id=p.id 
		$where ";
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
		
    }  

    function get_school()
    {
		$secondDB = $this->load->database('umsdb', TRUE);
        $sql="select * from schoolmaster";
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
    }
	 function get_product()
    {
		$secondDB = $this->load->database('umsdb', TRUE);
        $sql="select * from productmaster";
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
    }
}