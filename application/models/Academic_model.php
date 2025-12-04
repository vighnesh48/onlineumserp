<?php
class Academic_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		
    }
    
    function  get_academic_session_details($session_id='')
    {
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("academic_session");
            if(($session_id)){
             $secondDB->where("id",$session_id);    
            }
            $query = $secondDB->get();
            if(($session_id)){
             return $query->row();   
            }
            else{
            return $query->result();
            }
    }  
	function  get_academic_year_details()
    {
			$secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("academic_year"); 
            $query = $secondDB->get(); 
            return $query->result();
    }  
	 function  add_academic_session_details($data=array())
    {
           
			
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->insert("academic_session",$data);
            return $secondDB->insert_id();


    } 
	function  check_already_exists($data=array(),$id="")
    {
           
			
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("academic_session");
			$secondDB->where("academic_year",$data['academic_year']); 
			$secondDB->where("academic_session",$data['academic_session']); 
			$secondDB->where("start_month",$data['start_month']); 
			$secondDB->where("last_month",$data['last_month']);
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
           // error_reporting(E_ALL);
            $secondDB = $this->load->database('umsdb', TRUE);
            $where=array("id"=>$id);
            $secondDB->where($where);
            $secondDB->update("academic_session", $update_array); 
            return $secondDB->affected_rows();


    } 	
	
	
	
}