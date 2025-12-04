<?php
class School_color_map_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_school_color_details($school_color_id='')
    {
		$secondDB = $this->load->database('umsdb', TRUE);
 
        $where=" WHERE 1=1 ";  
        
        if($school_color_id!="")
        {
            $where.=" AND sc.id='".$school_color_id."'";
        }
        
        $sql="select sc.*,s.school_name,c.colorname as color_name from schoolcolor as sc  
		LEFT join schoolmaster as s On sc.school_id=s.id 
		LEFT JOIN colormaster as c On sc.color_id=c.id 
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
	 function get_color()
    {
		$secondDB = $this->load->database('umsdb', TRUE);
        $sql="select * from colormaster";
        $query = $secondDB->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
    }
}