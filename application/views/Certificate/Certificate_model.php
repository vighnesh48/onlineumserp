<?php

class Certificate_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    } 	

    function get_student_by_prn($enrollment_no){
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select("s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.academic_year, s.admission_session, s.admission_stream, vw.gradesheet_name,vw.specialization,s.first_name,s.middle_name,s.last_name, s.father_fname,s.father_mname,s.father_lname, vw.school_code,vw.school_name");
        $DB1->from('student_master as s');
        $DB1->join('vw_stream_details as vw','s.admission_stream = vw.stream_id','left');
        $DB1->where("enrollment_no", $enrollment_no);
        
        $query=$DB1->get();
        $result=$query->result_array();
        //echo $DB1->last_query();exit;
        return $result;
    }
    // check duplicates
    function chk_duplicate_prov_form($stud_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select student_id,provcert_id from exam_provisional_certificate  where student_id ='".$stud_id."' and is_active='Y'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $res = $query->result_array();
        return $res;
    }
    // update record
    function updateMarksCardsNo($provcert_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $where = "provcert_id='$provcert_id'";
        $DB1->where($where);   
        $data =array(
            "is_active" => 'N',
            "modified_by" => $this->session->userdata("uid"),
            "modified_ip" => $_SERVER['REMOTE_ADDR'],
            "modified_on" => date("Y-m-d H:i:s")
        );    
        $DB1->update('exam_provisional_certificate', $data);
        //echo $DB1->last_query();exit;
        return true;
    }
     // list
    function list_proviCerticateStudents($var)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select("s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.admission_session,vw.gradesheet_name,vw.specialization,s.first_name,s.middle_name,s.last_name, s.father_fname,s.father_mname,s.father_lname, vw.school_name,c.student_prn,c.academic_year,c.degree_completed, c.issued_date, c.placed_in, c.ppc_no,c.stream_id,c.provcert_id,c.exam_id");
        $DB1->from('exam_provisional_certificate as c');
        $DB1->join('student_master as s','s.stud_id = c.student_id','left');
        $DB1->join('vw_stream_details as vw','c.stream_id = vw.stream_id','left');
        $DB1->where("c.is_active", 'Y');


		if(!empty($var['school_code'])){ 
            $DB1->where("vw.school_code", $var['school_code']);
        }
		if(!empty($var['admission-course'])){ 
            $DB1->where("vw.course_id", $var['admission-course']);
        }
        if(!empty($var['admission-branch'])){ 
            $DB1->where("c.stream_id", $var['admission-branch']);
        }
        if(!empty($var['academic_year'])){
            $DB1->where("c.academic_year", $var['academic_year']);
        }

        $query=$DB1->get();
        $result=$query->result_array();
        //echo $DB1->last_query();exit;
        return $result;
    } 
    //edit
    function get_proviCerticateStudents($enrollment_no)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select("s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender,  s.admission_session,vw.gradesheet_name,vw.specialization,vw.course_name,s.first_name,s.middle_name,s.last_name, s.father_fname,s.father_mname,s.father_lname, vw.school_name,c.student_prn,c.academic_year,c.degree_completed, c.issued_date, c.placed_in, c.ppc_no,c.stream_id,c.provcert_id,c.exam_id");
        $DB1->from('exam_provisional_certificate as c');
        $DB1->join('student_master as s','s.stud_id = c.student_id','left');
        $DB1->join('vw_stream_details as vw','c.stream_id = vw.stream_id','left');
        $DB1->where("c.is_active", 'Y');
        $DB1->where("c.erp_prn", $enrollment_no);
        $query=$DB1->get();
        $result=$query->result_array();
        //echo $DB1->last_query();exit;
        return $result;
    }
    //
    function getAcademicYear(){
        $DB1 = $this->load->database('umsdb', TRUE);    
        $sql = "SELECT academic_year,start_month,last_month,session FROM `academic_year`";      
        $query = $DB1->query($sql);
        $res = $query->result_array();
        //echo $DB1->last_query();exit;
        return $res;
    } 
    //
    function fetch_exam_allsession()
    {       
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM exam_session where deleted ='N'";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
        
    } 
    //
    function getSchools(){
        $DB1 = $this->load->database('umsdb', TRUE); 
        $sql="SELECT DISTINCT(school_code),school_short_name FROM vw_stream_details where school_short_name IS NOT NULL ";
    
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	function get_courses($school_code){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_id =$exam[2];
		$sql="select v.course_id, v.course_name, v.course_short_name from vw_stream_details as v where v.school_code='$school_code' group by v.course_id";	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();		die();  
		return $query->result_array();
	}
	// fetch exam streams
	function load_streams($course_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct vsd.stream_id, vsd.stream_name, vsd.stream_short_name from vw_stream_details as vsd where vsd.course_id='".$course_id."' group by vsd.stream_id";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	function get_stud_details_for_certificate($ex_master_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_id =$exam[2];
		$sql="select stud_id, enrollment_no, stream_id,semester,exam_id,exam_month,exam_year from exam_details where exam_master_id='$ex_master_id' and is_active='Y'";	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();		die();  
		return $query->result_array();
	}
	function fetch_credits_earned($enrollment_no, $exam_id){		
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select  sum(credits_earned) as credits_earned  from exam_result_master WHERE `enrollment_no` = '$enrollment_no' and exam_id <= $exam_id";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
	}	
	function fetch_markscard_no($enrollment_no, $exam_id){		
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select markscard_no from exam_markscard_details WHERE `enrollment_no` = '$enrollment_no' and exam_id = $exam_id";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
	}	
	
//////////////////////////////////////////////////////////////////////

function list_result_students($var,$exam_month, $exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$stream_id = $var['admission-branch'];
		$semester = $var['semester'];
		$sql = "select distinct erm.student_id as stud_id,s.enrollment_no,UPPER(CONCAT(s.last_name,' ',s.first_name,' ',s.middle_name)) as stud_name,erm.semester from exam_result_data as erm  
		left join student_master s on s.stud_id = erm.student_id
		INNER JOIN (SELECT enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec
FROM exam_student_subject GROUP BY enrollment_no) AS a ON a.aenrollment_no=erm.enrollment_no AND a.chec='0'
		where stream_id='".$stream_id."' and exam_id='".$exam_id."' and semester ='".$semester."' order by erm.student_id asc";
		$query = $DB1->query($sql);
		echo $DB1->last_query(); //exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
}
?>