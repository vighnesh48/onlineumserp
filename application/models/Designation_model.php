<?php
class Designation_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
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
		function fetch_user_master_data()
	{		
		$sql="SELECT * FROM sandipun_erp.user_master where roles_id in (14,25,31,26,36,37)";
		$query = $this->db->query($sql);
        return $query->result_array();
	}
	 function  user_search_details($um_id='')
    {
         $inscon='';	
        if($um_id>0)
		{
			$inscon="AND um_id=$um_id";
		}			 
		 $query="select * from user_master where roles_id in (14,25,31,26,36,37) $inscon";
		 $row=$this->db->query($query);
		 return $row->result_array();
    }
}