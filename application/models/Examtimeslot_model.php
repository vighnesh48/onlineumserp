<?php
class Examtimeslot_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		 error_reporting(E_ALL);
    }
    
    function  get_exam_time_slot_details($slot_id='')
    {     
            
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("examtime_slot");
            if(($slot_id)){
             $secondDB->where("id",$session_id);    
            }
			$secondDB->order_by("id", "DESC");
            $query = $secondDB->get();
			//echo $secondDB->last_query();exit;
            if(($slot_id)){
             return $query->row();   
            }
            else{
            return $query->result();
            }
    } 
	 function  get_exam_session_details()
    {     
            
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("exam_session");
            $secondDB->where("is_active",'Y');
			$this->db->order_by("id", "DESC");
            $query = $secondDB->get();
            return $query->result();
    } 
	function  get_exam_name($exam_id)
    {     
            
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("exam_session");
			$secondDB->where("exam_id",$exam_id);
            $query = $secondDB->get();
            return $query->row()->exam_name;
    } 
	

	
	
	 function  add_slot_details($data=array())
    {
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->insert("examtime_slot",$data);
            return $secondDB->insert_id();
    } 
	function  check_already_exists($data=array(),$id="")
    {
           
			
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("examtime_slot");
			$secondDB->where("from_time",$data['from_time']); 
			$secondDB->where("to_time",$data['to_time']); 
			$secondDB->where("exam_id",$data['exam_id']); 
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