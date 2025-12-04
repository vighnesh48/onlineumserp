<?php
class School_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_school_details($school_id='')
    {
		$secondDB = $this->load->database('umsdb', TRUE);
 
        $where=" WHERE 1=1 ";  
        
        if($school_id!="")
        {
            $where.=" AND id='".$school_id."'";
        }
        
       // $sql="select ps.*,p.product_name from productsizemaster as ps LEFT join productmaster as p On ps.product_id=p.id $where ";
	    $sql="select * from schoolmaster $where ";
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
}