<?php
class Examsession_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		
    }
    
    function  get_exam_session_details($session_id='')
    {     
            
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("exam_session");
            if(($session_id)){
             $secondDB->where("exam_id",$session_id);    
            }
			$secondDB->order_by("exam_id",'desc');
            $query = $secondDB->get();
            if(($session_id)){
			
             return $query->row();   
            }
            else{
            return $query->result();
            }
    }  
	
	 function  add_exam_session_details($data=array())
    {
           
			
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->insert("exam_session",$data);
            return $secondDB->insert_id();


    } 
	
	function  check_already_exists($data=array(),$id="")
    {
           
			
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("exam_session");
			$secondDB->where("exam_month",$data['exam_month']); 
			$secondDB->where("exam_year",$data['exam_year']); 
			$secondDB->where("exam_type",$data['exam_type']); 
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
	
	function  check_already_exists_dates($data=array(),$id="")
    {
           
			
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("marks_entery_date");
			$secondDB->where("exam_id",$data['exam_id']); 
			if($id){
			$secondDB->where("id !=",$id);
			}
            $query = $secondDB->get()->row();
			//echo $secondDB->last_query();exit;
			if(!empty($query )){
				return true;
			}
			else{
				return false;
			}
    }	
	 function  add_exam_session_details_dates($data=array())
    {          			
            $secondDB = $this->load->database('umsdb', TRUE);
			unset($data['year_id']);
            $secondDB->insert("marks_entery_date",$data);
			//echo $secondDB->last_query();exit;
            return $secondDB->insert_id();


    } 
		 function  update_exam_session_details_dates($data=array())
    {          			
            $secondDB = $this->load->database('umsdb', TRUE);
			$secondDB->where("exam_id",$data['exam_id']); 
            $secondDB->update("marks_entery_date",$data);
			//echo $secondDB->last_query();exit;
            return true;


    } 
	function get_ex_ses_details($session_id){
	        $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("marks_entery_date");
            if(($session_id)){
             $secondDB->where("exam_id",$session_id);    
            }
			$secondDB->order_by("exam_id",'desc');
            $query = $secondDB->get();
            if(($session_id)){
			
             return $query->row();   
            }
            else{
            return $query->result();
            }	
	}
	function  check_result_generated_or_not($session_id='')
    {     
            $exam_session= fetch_exam_session_for_result();
		//print_r($exam_session);
		$exam_id=$exam_session[0]['exam_id'];
            $DB1 = $this->load->database('umsdb', TRUE);
            $sql="SELECT v.school_short_name,v.stream_name,tbl.stream_id,semester
FROM (
SELECT distinct stream_id,semester FROM exam_applied_subjects where exam_id=$exam_id
UNION ALL
SELECT distinct stream_id,semester FROM exam_result_data where exam_id=$exam_id
) tbl
 join vw_stream_details v on v.stream_id=tbl.stream_id
GROUP BY tbl.stream_id,semester
HAVING count(*) = 1
ORDER BY tbl.stream_id";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
    } 	
}