<?php
class Color_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
    
    function  get_color_details($color_id='')
    {
		$secondDB = $this->load->database('umsdb', TRUE);
 
        $where=" WHERE 1=1 ";  
        
        if($color_id!="")
        {
            $where.=" AND id='".$color_id."'";
        }
        
        $sql="select * From colormaster $where ";
        $query = $secondDB->query($sql);
        return $query->result_array();
    }  
}