<?php
class Resultdateupdation_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		
    }
    

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function fetch_stud_curr_exam() {
    $DB1 = $this->load->database('umsdb', TRUE);
    $DB1->select("e.exam_month, e.exam_year, e.exam_id, e.exam_type");
    $DB1->from('exam_session e');
    $DB1->order_by("e.exam_id", 'desc');
    $query = $DB1->get();
    return $query->result_array();
}

public function get_exam_session_details($exam_session = '') {     
    $secondDB = $this->load->database('umsdb', TRUE);
    $secondDB->select("result_date_updation.*, school_master.school_name");
    $secondDB->from("result_date_updation");
    $secondDB->join("school_master", "result_date_updation.school = school_master.school_id", "left");
    if (!empty($exam_session)){
        $secondDB->where("result_date_updation.exam_session", $exam_session);    
    }
    $secondDB->order_by("result_date_updation.exam_id", 'desc');
    $query = $secondDB->get();
    return $query->result();   
}
function fetch_stud_curr_examOk(){
    $DB1 = $this->load->database('umsdb', TRUE);
    $DB1->select("e.exam_month,e.exam_year,e.exam_id,e.exam_type,m.frm_end_date,m.frm_open_date,m.frm_latefee_date");
    $DB1->from('exam_session e');
    $DB1->join('marks_entery_date as m','m.exam_id = e.exam_id','left');
    $DB1->where("e.is_active", 'Y');
    $DB1->order_by("e.exam_id", 'desc');
    //$DB1->limit(1);
    $query=$DB1->get();
    $result=$query->result_array();
    //echo $DB1->last_query();exit;
    return $result;
}
    function get_exam_session_detailsOk($id='') {     
        $secondDB = $this->load->database('umsdb', TRUE);
        $secondDB->select("result_date_updation.*, school_master.school_name");
        $secondDB->from("result_date_updation");
        $secondDB->join("school_master", "result_date_updation.school = school_master.school_id", "left");
        if (!empty($id)) {
            $secondDB->where("result_date_updation.exam_id", $id);    
        }
        $secondDB->order_by("result_date_updation.exam_id", 'desc');
        $query = $secondDB->get();
        if (!empty($id)) {
            return $query->row();   
        } else {
            return $query->result();
        }
    }
    

	public function get_school_id($id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		//$DB1->distinct();
		$DB1->select("school_stream.school_id,school_stream.school_code");
		$DB1->from("school_stream");
		
		$where=array("school_stream.stream_id"=>$id);
		$DB1->where($where);
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->row()->school_id.'||'.$query->row()->school_code;
	}



    public function get_school_details($id='')
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("school_master.*,");
		$DB1->from("school_master");
		if($id!='')
		{
			$DB1->where('school_id', $id);
		}
		$DB1->where("is_active", 'Y');
		$DB1->order_by("school_master.school_id", "desc");
		$query = $DB1->get();
		//echo $DB1->last_query();exit();
		return $query->result_array();
	}



    function  get_school_detailss($id='')
    {
		$DB1 = $this->load->database('umsdb', TRUE);
 
        $where=" WHERE 1=1 ";  
        
        if($id!="")
        {
            $where.=" AND id='".$id."'";
        }
        
       // $sql="select ps.*,p.product_name from productsizemaster as ps LEFT join productmaster as p On ps.product_id=p.id $where ";
	    $sql="select * from school_master $where ";
        $query = $DB1->query($sql);
		//echo $secondDB->last_query();die;
        return $query->result_array();
		
    } 


	
	 function  add_exam_session_details($data=array())
    {
           
			
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->insert("exam_session",$data);
            return $secondDB->insert_id();


    } 
    public function update_exam_pubDate_details($exam_id, $data)
    {
        $secondDB = $this->load->database('umsdb', TRUE);
        $secondDB->where('exam_id', $exam_id);
        return $secondDB->update('result_date_updation', $data);
    }

    


    function  add_exam_pubDate_details($data=array())
    {
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->insert("result_date_updation",$data);
            return $secondDB->insert_id();


    } 
	
	
	function  check_already_existsOld($data=array(),$id="")
    {
           
			
            $secondDB = $this->load->database('umsdb', TRUE);
            $secondDB->select("*");
            $secondDB->from("result_date_updation");
			$secondDB->where("exam_session",$data['exam_session']); 
            $secondDB->where("exam_month",$data['exam_month']);
            $secondDB->where("exam_year",$data['exam_year']);
            $secondDB->where("examId",$data['examId']);
			$secondDB->where("school",$data['school']); 
			if($id){
			$secondDB->where("exam_id !=",$id);
			}
            $query = $secondDB->get()->row();
			if(!empty($query )){
				return false;
			}
			else{
				return true;
			}
    }

    public function check_already_exists($data = array(), $id = "")
    {
        $secondDB = $this->load->database('umsdb', TRUE);
        $secondDB->select("*");
        $secondDB->from("result_date_updation");
        $secondDB->where("exam_month", $data['exam_month']);
        $secondDB->where("exam_year", $data['exam_year']);
        $secondDB->where("examId", $data['examId']);
        $secondDB->where("school", $data['school']);
        if ($id !== "") {
            $secondDB->where("exam_id !=", $id);
        }
        $query = $secondDB->get()->row();
        
        return ($query) ? false : true;
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




}