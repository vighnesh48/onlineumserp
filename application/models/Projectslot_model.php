<?php
class Projectslot_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		 error_reporting(E_ALL);
    }
    
    function  get_project_slot_details($slot_id='')
    {     
            
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("project_slot");
            if(($slot_id)){
             $secondDB->where("id",$session_id);    
            }
			$this->db->order_by("lect_slot_id", "DESC");
            $query = $secondDB->get();
			
            if(($slot_id)){
             return $query->row();   
            }
            else{
            return $query->result();
            }
    }  
	
	 function  add_slot_details($data=array())
    {
           
			
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->insert("project_slot",$data);
            return $secondDB->insert_id();


    } 
	function  check_already_exists($data=array(),$id="")
    {
           
			
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("project_slot");
			$secondDB->where("from_time",$data['from_time']); 
			$secondDB->where("to_time",$data['to_time']); 
			$secondDB->where("duration",$data['duration']);
			if($id){
			$secondDB->where("id !=",$id);
			}
            $query = $secondDB->get()->row();
			if(!empty($query )){
				return false;
			}
			else{
				return true;
			}
           		


    }

   function  update_session_details($update_array=array(),$id="")
    {
           
            $secondDB = $this->load->database('umsdb', TRUE);
            $where=array("id"=>$id);
            $secondDB->where($where);
            $secondDB->update("academic_session", $update_array); 
            return $secondDB->affected_rows();


    } 	
	
	
	
}