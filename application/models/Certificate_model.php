<?php

class Certificate_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    } 	

    function get_student_by_prn($enrollment_no){
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select("s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name,
		 s.academic_year, s.admission_session, s.admission_stream, vw.gradesheet_name,vw.specialization,
		 s.first_name,s.middle_name,s.last_name,
		 s.father_fname,s.father_mname,s.father_lname, vw.school_code,vw.school_name");
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
		if(!empty($var['admission_course'])){ 
            $DB1->where("vw.course_id", $var['admission_course']);
        }
        if(!empty($var['admission_branch'])){ 
            $DB1->where("c.stream_id", $var['admission_branch']);
        }
        if(!empty($var['academic_year'])){
            $DB1->where("c.academic_year", $var['academic_year']);
        }

        $query=$DB1->get();
        $result=$query->result_array();
        //echo $DB1->last_query();exit;
        return $result;
    } 
	////////////////////
	
	function list_proviCerticateStudents_new($var)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $DB1->select("s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.admission_session,vw.gradesheet_name,vw.specialization,s.first_name,s.middle_name,s.last_name, s.father_fname,s.father_mname,s.father_lname, vw.school_name,c.student_prn,c.academic_year,c.degree_completed, c.issued_date, c.placed_in, c.ppc_no,c.stream_id,c.provcert_id,c.exam_id");
        $DB1->from('exam_provisional_certificate as c');
        $DB1->join('student_master as s','s.stud_id = c.student_id AND s.admission_session!=2016' ,'left');
        $DB1->join('vw_stream_details as vw','c.stream_id = vw.stream_id','left');
        $DB1->where("c.is_active", 'Y');


		if(!empty($var['school_code'])){ 
            $DB1->where("vw.school_code", $var['school_code']);
        }
		if(!empty($var['admission_course'])){ 
            $DB1->where("vw.course_id", $var['admission_course']);
        }
        if(!empty($var['admission_branch'])){ 
            $DB1->where("c.stream_id", $var['admission_branch']);
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
$DB1->select("UPPER(CONCAT(COALESCE(s.last_name,''), ' ',COALESCE(s.first_name,''),' ',COALESCE(s.middle_name,''))) as stud_name", FALSE);
        $DB1->select("s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender, 
		 s.admission_session,vw.gradesheet_name,vw.specialization,vw.course_name,
		 s.father_fname,s.father_mname,s.father_lname, vw.school_name,c.student_prn,
		 c.academic_year,c.degree_completed, c.issued_date, c.placed_in, c.sem1_gpa,c.sem2_gpa,c.sem3_gpa,c.sem4_gpa,c.sem5_gpa,c.sem6_gpa,c.sem10_gpa,c.sem9_gpa,c.sem8_gpa,c.sem7_gpa,c.cgpa,
		 c.ppc_no,c.stream_id,c.provcert_id,c.exam_id,vw.gradesheet_name,
		 vw.degree_specialization,vw.school_code,erm.exam_month as sexam_month,
		 erm.exam_year as sexam_year,erm.exam_id");
        $DB1->from('exam_provisional_certificate as c');
        $DB1->join('student_master as s','s.stud_id = c.student_id','left');
		$DB1->join('exam_session as erm','erm.exam_id = c.exam_id','left');
        $DB1->join('vw_stream_details as vw','c.stream_id = vw.stream_id','left');
        $DB1->where("c.is_active", 'Y');
        $DB1->where("c.erp_prn", $enrollment_no);
        $query=$DB1->get();
        $result=$query->result_array();
        //echo $DB1->last_query();exit; 
        return $result;
    }
    function get_degreeCerticateStudents($enrollment_no)
    {
		
		//e.estudent_id=erm.student_id
        $DB1 = $this->load->database('umsdb', TRUE);
		//echo $enrollment_no;//exit;
        $DB1->select("vw.course_name_marathi,vw.stream_name_marathi, exx.exam_month_marathi,s.marathi_name,s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender, 
		 s.admission_session,vw.gradesheet_name,vw.degree_specialization,
		vw.specialization,vw.course_name,s.first_name,s.middle_name,s.last_name,
		 s.father_fname,s.father_mname,s.father_lname, vw.school_name,c.enrollment_no as student_prn,
		 s.academic_year,concat(c.exam_month,'/',c.exam_year,'') as degree_completed, c.issued_date, c.placed_in 
		 ,c.stream_id,c.exam_id,
		 CASE WHEN (TRUNCATE(c.cumulative_gpa,2) >= 9.00) THEN 'Honours'
 WHEN (TRUNCATE(c.cumulative_gpa,2) >= 7.50) THEN 'Distinction' 
WHEN TRUNCATE(c.cumulative_gpa,2) >= 6.00 THEN 'First Class'
 WHEN TRUNCATE(c.cumulative_gpa,2) >= 5.00 AND TRUNCATE(c.cumulative_gpa,2) < 6.00 THEN 'Second Class'
 WHEN TRUNCATE(c.cumulative_gpa,2) > 5.00 THEN 'Third Class'
 END AS Result",FALSE);
		 
		$DB1->from('degreecertficate_assgin_details as c');
		$DB1->join('student_master as s','s.stud_id = c.student_id','left');
		
		
		
		//$DB1->join('(SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no FROM exam_result_master as a INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id WHERE a.stream_id=c.stream_id  AND a.exam_id=c.exam_id GROUP BY student_id)  as e','e.estudent_id=erm.student_id','inner');	
        $DB1->join('vw_stream_details as vw','c.stream_id = vw.stream_id','left');
		 $DB1->join('exam_session  as exx','exx.exam_id = c.exam_id','left');
        $DB1->where("c.is_active", 'Y');
        $DB1->where("c.enrollment_no", $enrollment_no);
        $query=$DB1->get();
		
        $result=$query->result_array();
        //echo $DB1->last_query();exit;
        return $result;
    }
	    function phd_get_degreeCerticateStudents($enrollment_no)
    {
		
		//e.estudent_id=erm.student_id
        $DB1 = $this->load->database('umsdb', TRUE);
		//echo $enrollment_no;//exit;
        $DB1->select("vw.stream_name,c.*");
		 
		$DB1->from('phd_degreecertficate_assgin_details as c');
		$DB1->join('student_master as s','s.stud_id = c.student_id','left');
		
		
		
		//$DB1->join('(SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no FROM exam_result_master as a INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id WHERE a.stream_id=c.stream_id  AND a.exam_id=c.exam_id GROUP BY student_id)  as e','e.estudent_id=erm.student_id','inner');	
        $DB1->join('vw_stream_details as vw','c.stream_id = vw.stream_id','left');
        $DB1->where("c.enrollment_no", $enrollment_no);
        $query=$DB1->get();
		
        $result=$query->result_array();
        //echo $DB1->last_query();exit;
        return $result;
    }
function get_proviCerticateStudents_new($var,$enrollment_no,$stream_id,$exam_id)
    {
		//echo $enrollment_no.'_'.$stream_id.'_'.$exam_id;
		//print_r($var);
		//exit;
        $DB1 = $this->load->database('umsdb', TRUE);
        /*$DB1->select("s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender, 
		 s.admission_session,UPPER(CONCAT(s.last_name,' ',s.first_name,' ',s.middle_name)) AS stud_name,vw.gradesheet_name,
		vw.specialization,vw.course_name,s.first_name,s.middle_name,s.last_name,
		 s.father_fname,s.father_mname,s.father_lname, vw.school_name,c.enrollment_no,
		,c.stream_id,c.exam_id");
        $DB1->from('exam_result_data as c');
        $DB1->join('student_master as s','s.stud_id = c.student_id','inner');
        $DB1->join('vw_stream_details as vw','c.stream_id = vw.stream_id','inner');
       // $DB1->where("c.is_active", 'Y');
        $DB1->where("c.enrollment_no", $enrollment_no);
		//$DB1->where("c.stream_id", $stream_id);
        $query=$DB1->get();*/
		$sql = "SELECT DISTINCT TRUNCATE(e.ecumulative_gpa,2) AS `cumulative_gpa`, b.checb,eas.easchecb,erm.stream_id,erm.exam_month,esm.dpharma_class,
		erm.exam_year, esm.`cumulative_gpa` as esmcumulative_gpa,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(COALESCE(s.last_name,''), ' ',COALESCE(s.first_name,''),' ',COALESCE(s.middle_name,''))) as stud_name,s.student_photo_path,s.marathi_name,vw.course_name_marathi,vw.stream_name_marathi,
exx.exam_month_marathi,
erm.semester,s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender, 
		 s.admission_session,s.first_name,s.middle_name,s.last_name,
		 s.father_fname,s.father_mname,s.father_lname,vw.course_duration,vw.gradesheet_name,
		 vw.specialization,vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,
		 erm.exam_month as sexam_month,
		 erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no,
CASE
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 9.00 AND b.checb=0 AND eas.easchecb=0) THEN 'Honours' 
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 7.50 AND b.checb=0 AND eas.easchecb=0) THEN 'Distinction' 
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 6.00 THEN 'First Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 5.00 AND TRUNCATE(e.ecumulative_gpa,2) < 6.00 THEN 'Second Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.00  THEN 'Third Class'
END AS Result

FROM exam_result_data AS erm  
INNER JOIN student_master s ON s.stud_id = erm.student_id

INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id AND vw.school_code='".$var['school']."'

INNER JOIN (SELECT enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
ON a.aenrollment_no=erm.enrollment_no AND a.chec='0'

INNER JOIN (SELECT ed.student_id AS bstudent_id,ed.enrollment_no AS benrollment_no,ed.stream_id AS bstream_id,ed.semester AS bsemester,
ed.exam_id AS bexam_id,ed.subject_id AS bsubject_id,SUM(CASE WHEN (ed.final_grade='U' OR ed.final_grade='F') 
 THEN 1 ELSE 0 END) AS checb FROM exam_result_data as ed
 
  GROUP BY ed.student_id) AS b 
ON b.bstudent_id=erm.student_id AND b.benrollment_no=erm.enrollment_no 

INNER JOIN (SELECT stud_id AS easstudent_id,enrollment_no AS easenrollment_no,
SUM(CASE WHEN is_backlog='Y' THEN 1 ELSE 0 END) AS easchecb FROM exam_applied_subjects GROUP BY stud_id) AS eas 
ON eas.easstudent_id=erm.student_id AND eas.easenrollment_no=erm.enrollment_no


INNER JOIN exam_result_master AS esm ON esm.`student_id`= erm.student_id

INNER JOIN (SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no
FROM exam_result_master as a
INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id
WHERE a.stream_id='".$stream_id."' AND vw.school_code='".$var['school']."' AND a.exam_id='".$exam_id."' GROUP BY student_id ) AS e
 ON e.estudent_id=erm.student_id 
left JOIN exam_session AS exx ON exx.exam_id='".$exam_id."'
WHERE  erm.enrollment_no='".$enrollment_no."' AND erm.exam_id ='".$exam_id."' 
GROUP BY erm.enrollment_no";
//HAVING erm.semester=(2 * vw.course_duration)"; //ORDER BY erm.enrollment_no DESC";
  //erm.stream_id='".$stream_id."'   AND erm.exam_id ='".$exam_id."'
		
		
		$query = $DB1->query($sql);
		if($this->session->userdata("role_id")==6){
	
		}
	   //echo $DB1->last_query();  exit;
		$stream_details = $query->result_array();
		return $stream_details;
    }
function get_proviCerticateStudents_dpharma($var,$enrollment_no,$stream_id,$exam_id)
    {
		//echo $enrollment_no.'_'.$stream_id.'_'.$exam_id;
		//print_r($var);
		//exit;
		$semester= $var['semester'];
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT DISTINCT erm.*,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name,
s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender, 
		 s.admission_session,s.first_name,s.middle_name,s.last_name,
		 s.father_fname,s.father_mname,s.father_lname,vw.course_duration,vw.gradesheet_name,
		 vw.specialization,vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,
		 erm.exam_month as sexam_month,
		 erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no

FROM exam_result_master AS erm  
INNER JOIN student_master s ON s.stud_id = erm.student_id
INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id AND vw.school_code='".$var['school']."'
WHERE  erm.enrollment_no='".$enrollment_no."' AND erm.exam_id ='".$exam_id."' and erm.stream_id='".$stream_id."'  AND erm.semester='".$semester."'
GROUP BY erm.enrollment_no";
//HAVING erm.semester=(2 * vw.course_duration)"; //ORDER BY erm.enrollment_no DESC";
  //erm.stream_id='".$stream_id."'   AND erm.exam_id ='".$exam_id."'
		
		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();  exit;
		if($this->session->userdata("role_id")==6){
		//echo $DB1->last_query();  exit;
		}
		$stream_details = $query->result_array();
		return $stream_details;
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

function list_result_students($var,$exam_month, $exam_year,$exam_id,$prn=''){
		$DB1 = $this->load->database('umsdb', TRUE);
	
	
		$stream_id = $var['admission_branch'];
		$semester = $var['semester'];
		// print_r($var);exit;
		
	if(!empty($var['prn'])){
		$condition = "AND erm.enrollment_no = '".$var['prn']."'";
	}else{ 
		$condition = "";
	}
		if($var['school_code']=="All"){
			$sql = "SELECT DISTINCT TRUNCATE(e.ecumulative_gpa,2) AS `cumulative_gpa`,vw.course_pattern,chex.mxid,b.checb,erm.stream_id,erm.exam_month,erm.exam_year, esm.`cumulative_gpa` as esmcumulative_gpa,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name,
erm.semester,s.stud_id,s.current_semester,s.admission_stream,s.admission_year, s.enrollment_no, s.mother_name, s.gender, 
		 s.admission_session,s.first_name,s.middle_name,s.last_name,s.transefercase,
		 s.father_fname,s.father_mname,s.father_lname,vw.gradesheet_name,
		 vw.course_duration,vw.specialization,vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,
		  erm.exam_month as sexam_month,
		 erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no,
CASE
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 9.00 AND b.checb=0) THEN 'Honours' 
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 7.50 AND b.checb=0) THEN 'Distinction' 
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 6.00 THEN 'First Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 5.00 AND TRUNCATE(e.ecumulative_gpa,2) < 6.00 THEN 'Second Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.00  THEN 'Third Class'
END AS Result

FROM exam_result_data AS erm  
INNER JOIN student_master s ON s.stud_id = erm.student_id AND s.admission_session>='".$var['regulation']."'
INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id 

INNER JOIN (SELECT enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
ON a.aenrollment_no=erm.enrollment_no AND a.chec='0'

INNER JOIN (SELECT ed.student_id AS bstudent_id,ed.enrollment_no AS benrollment_no,ed.stream_id AS bstream_id,ed.semester AS bsemester,
ed.exam_id AS bexam_id,ed.subject_id AS bsubject_id,SUM(CASE WHEN (ed.final_grade='U' OR ess.no_of_attempt='2')
 THEN 1 ELSE 0 END) AS checb FROM exam_result_data as ed 
 LEFT JOIN exam_student_subject AS ess ON ess.student_id=ed.student_id AND ess.subject_id=ed.subject_id

 GROUP BY ed.student_id) AS b 
ON b.bstudent_id=erm.student_id AND b.benrollment_no=erm.enrollment_no 


INNER JOIN exam_result_master AS esm ON esm.`student_id`= erm.student_id  AND erm.stream_id=esm.stream_id


INNER JOIN (SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no
FROM exam_result_master as a
INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id
WHERE a.stream_id='".$stream_id."' AND a.exam_id='".$exam_id."' GROUP BY student_id) AS e ON e.estudent_id=erm.student_id 
AND esm.exam_id='".$exam_id."' AND esm.exam_year
LEFT JOIN (SELECT MAX(exam_id) AS mxid,student_id FROM exam_result_data  GROUP BY student_id) AS chex 
   ON chex.student_id=erm.student_id 

WHERE erm.exam_id='".$exam_id."' $condition AND vw.course_pattern='SEMESTER'  AND erm.school_id in('1001','1009','1006','1010')
GROUP BY erm.enrollment_no
HAVING chex.mxid='$exam_id' AND
CASE WHEN vw.course_pattern ='SEMESTER' THEN 
    s.current_semester=(2 * vw.course_duration)
  ELSE
   s.current_semester=(1 * vw.course_duration)
  END"; 

//ORDER BY erm.enrollment_no DESC //erm.semester=(2 * vw.course_duration)
		
		
		$query = $DB1->query($sql);
		// $DB1->last_query();exit; //exit; AND erm.stream_id='".$stream_id."'
		$stream_details = $query->result_array();
		return $stream_details;
		}else{
		/*$sql = "select distinct erm.student_id as stud_id,s.enrollment_no,UPPER(CONCAT(s.last_name,' ',s.first_name,' ',s.middle_name)) as stud_name,erm.semester from exam_result_data as erm  
		left join student_master s on s.stud_id = erm.student_id
		INNER JOIN (SELECT enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec
FROM exam_student_subject GROUP BY enrollment_no) AS a ON a.aenrollment_no=erm.enrollment_no AND a.chec='0'
		where stream_id='".$stream_id."' and exam_id='".$exam_id."' and semester ='".$semester."' order by erm.student_id asc";
		*/
		
		$sql = "SELECT DISTINCT TRUNCATE(e.ecumulative_gpa,2) as `cumulative_gpa`,eas.easchecb,vw.course_pattern,chex.mxid,b.checb,erm.stream_id,erm.exam_month,
		erm.exam_year, esm.`cumulative_gpa` as esmcumulative_gpa,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name,
erm.semester,s.stud_id,s.current_semester,s.admission_stream,s.admission_year, s.enrollment_no, s.mother_name, s.gender,s.transefercase, 
		 s.admission_session,s.first_name,s.middle_name,s.last_name,
		 s.father_fname,s.father_mname,s.father_lname,s.dob,vw.course_duration,vw.gradesheet_name,
		 vw.specialization,vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,
		  erm.exam_month as sexam_month,
		 erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no,
CASE
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 9.00 AND b.checb=0 AND eas.easchecb=0) THEN 'Honours' 
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 7.50 AND b.checb=0 AND eas.easchecb=0) THEN 'Distinction' 
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 6.00 THEN 'First Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 5.00 AND TRUNCATE(e.ecumulative_gpa,2) < 6.00 THEN 'Second Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.00  THEN 'Third Class'
END AS Result,d.markscard_no

FROM exam_result_data AS erm 
left join degreecertficate_assgin_details d on d.student_id=erm.student_id and d.is_active='Y'
INNER JOIN student_master s ON s.stud_id = erm.student_id AND s.admission_session>='".$var['regulation']."'
INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id AND vw.school_code='".$var['school_code']."'

INNER JOIN (SELECT student_id as astudent_id,enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
ON a.astudent_id=erm.student_id AND a.chec='0'

INNER JOIN (SELECT ed.student_id AS bstudent_id,ed.enrollment_no AS benrollment_no,ed.stream_id AS bstream_id,ed.semester AS bsemester,
ed.exam_id AS bexam_id,ed.subject_id AS bsubject_id,SUM(CASE WHEN (ed.final_grade='U' OR ed.final_grade='F' )
 THEN 1 ELSE 0 END) AS checb FROM exam_result_data as ed 
 
GROUP BY ed.student_id) AS b 
ON b.bstudent_id=erm.student_id 


INNER JOIN exam_result_master AS esm ON esm.`student_id`= erm.student_id 

INNER JOIN (SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no
FROM exam_result_master as a
INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id
WHERE a.stream_id='".$stream_id."' AND vw.school_code='".$var['school_code']."' AND a.exam_id='".$exam_id."'  GROUP BY student_id ) AS e ON e.estudent_id=erm.student_id 

AND esm.exam_id='".$exam_id."'  
LEFT JOIN (SELECT MAX(exam_id) AS mxid,student_id FROM exam_result_data  GROUP BY student_id) AS chex 
   ON chex.student_id=erm.student_id 

INNER JOIN (SELECT stud_id AS easstudent_id,enrollment_no AS easenrollment_no,
SUM(CASE WHEN is_backlog='Y' THEN 1 ELSE 0 END) AS easchecb FROM exam_applied_subjects GROUP BY stud_id) AS eas 
ON eas.easstudent_id=erm.student_id AND eas.easenrollment_no=erm.enrollment_no




WHERE erm.stream_id='".$stream_id."' $condition AND erm.exam_id='".$exam_id."'  AND vw.school_code='".$var['school_code']."'
GROUP BY erm.enrollment_no  having chex.mxid='$exam_id' AND
CASE WHEN vw.course_pattern ='SEMESTER' THEN 
    s.current_semester=(2 * vw.course_duration)
  ELSE
   s.current_semester=(1 * vw.course_duration)
  END
  ";	
		//echo  $sql;exit;
		$query = $DB1->query($sql);
		//	echo '<pre>';
		// echo $DB1->last_query(); exit;
		if($this->session->userdata("role_id")==6){
		// echo $DB1->last_query(); exit;
		}
		$stream_details = $query->result_array();
		//echo '<pre>';
		//print_r($stream_details);exit;
		return $stream_details;
		}
	}	
	
	function list_result_students_dpharma($var,$exam_month, $exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
	
	
		$stream_id = $var['admission_branch'];
		$semester = $var['semester'];

		$sql = "select erm.dpharma_class as Result, erm.`sgpa`,b.checb,erm.stream_id,erm.exam_month,
		erm.exam_year,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(COALESCE(s.last_name,''), ' ',COALESCE(s.first_name,''),' ',COALESCE(s.middle_name,''))) as stud_name,
erm.semester,s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender, 
		 s.admission_session,s.first_name,s.middle_name,s.last_name,
		 s.father_fname,s.father_mname,s.father_lname,vw.course_duration,vw.gradesheet_name,
		 vw.specialization,vw.degree_specialization,vw.course_name,vw.course_pattern,vw.school_name,vw.school_code,
		  erm.exam_month as sexam_month,
		 erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no,d.markscard_no
		 from exam_result_master erm
left join degreecertficate_assgin_details d on d.student_id=erm.student_id and d.is_active='Y'
INNER JOIN student_master s ON s.stud_id = erm.student_id AND s.admission_session>='".$var['regulation']."'
INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id AND vw.school_code='".$var['school_code']."'		

INNER JOIN (SELECT student_id as astudent_id,enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
ON a.astudent_id=erm.student_id AND a.chec='0'

INNER JOIN (SELECT ed.student_id AS bstudent_id,ed.enrollment_no AS benrollment_no,ed.stream_id AS bstream_id,ed.semester AS bsemester,
ed.exam_id AS bexam_id,ed.subject_id AS bsubject_id,SUM(CASE WHEN (ed.final_grade='U' OR ess.no_of_attempt='2')
 THEN 1 ELSE 0 END) AS checb FROM exam_result_data as ed
 LEFT JOIN exam_student_subject AS ess ON ess.student_id=ed.student_id AND ess.subject_id=ed.subject_id

  GROUP BY ed.student_id) AS b 
ON b.bstudent_id=erm.student_id 
WHERE erm.stream_id='".$stream_id."' AND erm.exam_id='".$exam_id."' AND erm.semester ='".$semester."'  AND vw.school_code='".$var['school_code']."'
GROUP BY erm.enrollment_no having 
CASE WHEN vw.course_pattern ='SEMESTER' THEN 
    s.current_semester=(2 * vw.course_duration)
  ELSE
   s.current_semester=(1 * vw.course_duration)
  END"; //ORDER BY erm.enrollment_no DESC AND erm.school_id='".$var['school_code']."'
		
		//exit;//WHEN (TRUNCATE(e.ecumulative_gpa,2) > 9.00 AND b.checb=0) THEN 'Honours'
		$query = $DB1->query($sql);
		//if($this->session->userdata("role_id")==6)
		{
		//echo $DB1->last_query(); exit;
		}
		$stream_details = $query->result_array();
		return $stream_details;
		
	}		
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	
	
function list_result_students_Transcript($var,$exam_month, $exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
	
	
		$stream_id = $var['admission_branch'];
		$semester = $var['semester'];
		// print_r($var);exit;
	if(!empty($var['prn'])){
		$condition = "AND erm.enrollment_no = '".$var['prn']."'";
	}else{ 
		$condition = "";
	}
	
		if($var['school_code']=="All"){
			$sql = "SELECT DISTINCT TRUNCATE(e.ecumulative_gpa,2) AS `cumulative_gpa`,b.checb,erm.stream_id,erm.exam_month,erm.exam_year, esm.`cumulative_gpa` as esmcumulative_gpa,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(COALESCE(s.last_name,''), ' ',COALESCE(s.first_name,''),' ',COALESCE(s.middle_name,''))) as stud_name,
erm.semester,s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender,s.transefercase, 
		 s.admission_session,s.first_name,s.middle_name,s.last_name,
		 s.father_fname,s.father_mname,s.father_lname,vw.gradesheet_name,
		 vw.course_duration,vw.specialization,vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,
		  erm.exam_month as sexam_month,
		 erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no,
			CASE
				WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 9.00 AND b.checb=0) THEN 'Honours' 
				WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 7.50 AND b.checb=0) THEN 'Distinction' 
				WHEN TRUNCATE(e.ecumulative_gpa,2) >= 6.00 THEN 'First Class'
				WHEN TRUNCATE(e.ecumulative_gpa,2) >= 5.00 AND TRUNCATE(e.ecumulative_gpa,2) < 6.00 THEN 'Second Class'
				WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.00  THEN 'Third Class'
			END AS Result

			FROM exam_result_data AS erm  
			INNER JOIN student_master s ON s.stud_id = erm.student_id AND s.admission_session>='".$var['regulation']."'
			INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id 

			INNER JOIN (SELECT enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
			SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
			ON a.aenrollment_no=erm.enrollment_no AND a.chec='0'

			INNER JOIN (SELECT ed.student_id AS bstudent_id,ed.enrollment_no AS benrollment_no,ed.stream_id AS bstream_id,ed.semester AS bsemester,
			ed.exam_id AS bexam_id,ed.subject_id AS bsubject_id,
			SUM(CASE WHEN (ed.final_grade='U' OR ess.no_of_attempt='2') THEN 1 ELSE 0 END) AS checb FROM exam_result_data as ed 
			LEFT JOIN exam_student_subject AS ess ON ess.student_id=ed.student_id AND ess.subject_id=ed.subject_id
			GROUP BY ed.student_id) AS b 
			ON b.bstudent_id=erm.student_id AND b.benrollment_no=erm.enrollment_no 


			INNER JOIN exam_result_master AS esm ON esm.`student_id`= erm.student_id  AND erm.stream_id=esm.stream_id


			INNER JOIN (SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no
			FROM exam_result_master as a
			INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id
			WHERE a.stream_id='".$stream_id."' AND a.exam_id='".$exam_id."' GROUP BY student_id) AS e ON e.estudent_id=erm.student_id 



		AND esm.exam_id='".$exam_id."' AND esm.exam_year
		WHERE erm.exam_id='".$exam_id."' $condition AND vw.course_pattern='SEMESTER'  AND erm.school_id in('1001','1009','1006','1010')
		GROUP BY erm.enrollment_no"; 
		//HAVING erm.semester=(2 * vw.course_duration)"; 
		//ORDER BY erm.enrollment_no DESC
				
				
		$query = $DB1->query($sql);
		 $DB1->last_query();exit; // AND erm.stream_id='".$stream_id."'
		$stream_details = $query->result_array();
		return $stream_details;
		}else{
		/*$sql = "select distinct erm.student_id as stud_id,s.enrollment_no,UPPER(CONCAT(s.last_name,' ',s.first_name,' ',s.middle_name)) as stud_name,erm.semester from exam_result_data as erm  
		left join student_master s on s.stud_id = erm.student_id
		INNER JOIN (SELECT enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec
FROM exam_student_subject GROUP BY enrollment_no) AS a ON a.aenrollment_no=erm.enrollment_no AND a.chec='0'
		where stream_id='".$stream_id."' and exam_id='".$exam_id."' and semester ='".$semester."' order by erm.student_id asc";
		*/
		$sql = "SELECT DISTINCT TRUNCATE(e.ecumulative_gpa,2) as `cumulative_gpa`,b.checb,erm.stream_id,erm.exam_month,
		erm.exam_year, esm.`cumulative_gpa` as esmcumulative_gpa,erm.student_id AS stud_id,s.enrollment_no,
		UPPER(CONCAT(COALESCE(s.last_name,''), ' ',COALESCE(s.first_name,''),' ',COALESCE(s.middle_name,''))) as stud_name,
		erm.semester,s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender,s.transefercase,  
				 s.admission_session,s.first_name,s.middle_name,s.last_name,
				 s.father_fname,s.father_mname,s.father_lname,vw.course_duration,vw.gradesheet_name,
				 vw.specialization,vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,
				  erm.exam_month as sexam_month,
				 erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no,
		CASE
			WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 9.00 AND b.checb=0) THEN 'Honours' 
			WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 7.50 AND b.checb=0) THEN 'Distinction' 
			WHEN TRUNCATE(e.ecumulative_gpa,2) >= 6.00 THEN 'First Class'
			WHEN TRUNCATE(e.ecumulative_gpa,2) >= 5.00 AND TRUNCATE(e.ecumulative_gpa,2) < 6.00 THEN 'Second Class'
			WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.00  THEN 'Third Class'
		END AS Result,d.markscard_no

		FROM exam_result_data AS erm 
		left join degreecertficate_assgin_details d on d.student_id=erm.student_id and d.is_active='Y'
		INNER JOIN student_master s ON s.stud_id = erm.student_id AND s.admission_session>='".$var['regulation']."'
		INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id AND vw.school_code='".$var['school_code']."'

		INNER JOIN (SELECT student_id as astudent_id,enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
		SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
		ON a.astudent_id=erm.student_id AND a.chec='0'

		INNER JOIN (SELECT ed.student_id AS bstudent_id,ed.enrollment_no AS benrollment_no,ed.stream_id AS bstream_id,ed.semester AS bsemester,
		ed.exam_id AS bexam_id,ed.subject_id AS bsubject_id,SUM(CASE WHEN (ed.final_grade='U' OR ess.no_of_attempt='2')
		 THEN 1 ELSE 0 END) AS checb FROM exam_result_data as ed
		 LEFT JOIN exam_student_subject AS ess ON ess.student_id=ed.student_id AND ess.subject_id=ed.subject_id
		 GROUP BY ed.student_id) AS b 
		ON b.bstudent_id=erm.student_id 


		INNER JOIN exam_result_master AS esm ON esm.`student_id`= erm.student_id 

		INNER JOIN (SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no
		FROM exam_result_master as a
		INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id
		WHERE a.stream_id='".$stream_id."' AND vw.school_code='".$var['school_code']."' AND a.exam_id='".$exam_id."' 
		#AND a.semester ='".$semester."' 
		GROUP BY student_id ) AS e ON e.estudent_id=erm.student_id 

		AND esm.exam_id='".$exam_id."' 
		#AND esm.semester='".$semester."' 
		WHERE erm.stream_id='".$stream_id."' AND erm.exam_id='".$exam_id."'  $condition
		#AND erm.semester ='".$semester."' 
		AND vw.school_code='".$var['school_code']."'
		GROUP BY erm.enrollment_no";
//HAVING erm.semester=(2 * vw.course_duration)"; //ORDER BY erm.enrollment_no DESC AND erm.school_id='".$var['school_code']."'
		
		// exit;
		// echo $DB1->last_query();
		$query = $DB1->query($sql);
		echo $DB1->last_query(); exit;
		if($this->session->userdata("role_id")==6){
		//echo $DB1->last_query(); exit;
		}
		$stream_details = $query->result_array();
		return $stream_details;
		}
	}	
	
	
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////	
	
	
	
	
function load_resultstreams($course_id, $exam_session){
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam = explode('-', $exam_session);
		$exam_id= $exam[2];
		$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name from exam_result_master ed 
		left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id where vsd.course_id='".$course_id."' and
		 ed.exam_id='$exam_id'";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}		
	

	function load_edsemesters($stream_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		//$sql = "select distinct semester from exam_details  where stream_id='".$stream_id."'
		// and exam_id='".$exam_id."' order by semester asc";
		$sql = "select course_pattern,course_duration from stream_master  where stream_id='".$stream_id."'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		//print_r($stream_details);
		 $stream_details[0]['course_pattern'];
		 $stream_details[0]['course_duration'];
		if($stream_details[0]['course_pattern']=="SEMESTER"){
		$semister=$stream_details[0]['course_duration'] * 2 ;
		}else if($stream_details[0]['course_pattern']=="YEAR") {
		$semister=$stream_details[0]['course_duration'] * 1;
		}
		return $semister;
	}	
	
	function load_edstreams($course_id, $exam_id,$school_code){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name 
		from exam_details ed left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id
		where vsd.course_id='".$course_id."' AND vsd.school_code='".$school_code."' AND ed.exam_id='$exam_id' ";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	
		function get_edcourses($school_code, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select v.course_id, v.course_name, v.course_short_name from (select DISTINCT stream_id from exam_details where exam_id='$exam_id') as e left join vw_stream_details as v on v.stream_id= e.stream_id  where v.school_code='$school_code' group by v.course_id  order by v.course_name asc";
		$query = $DB1->query($sql);
		if($this->session->userdata("role_id")==15){
		// echo $DB1->last_query(); exit;
		}
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	function fetch_student_exam_unique_id($stud, $stream_id,$semester,$exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT `exam_master_id`,enrollment_no FROM `exam_details` WHERE `stud_id`='".$stud."' and `stream_id`='".$stream_id."' and `semester`='".$semester."' and `exam_id`='".$exam_id."'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	
	function fetch_student_grade_details($stud, $stream_id,$semester,$exam_id)
	{
	   // $this->fetch_student_grades($stud,$exam_id);
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct(s.enrollment_no), UPPER(CONCAT(COALESCE(s.last_name,''), ' ',COALESCE(s.first_name,''),' ',COALESCE(s.middle_name,''))) as stud_name, s.gender,s.dob,s.admission_session,s.admission_stream,s.current_semester,s.mother_name,s.middle_name,vw.stream_name, vw.stream_short_name,vw.school_name,vw.specialization,vw.gradesheet_name, erd.attendance_grade, erd.exam_month,erd.exam_year,    erd.semester,erd.stream_id,erd.exam_id,sm.subject_code,sm.sub_id,sm.subject_component,sm.credits,sm.subject_category,sm.subject_name,erm.credits_registered,erm.credits_earned,erm.grade_points_earned,erm.grade_points_avg, erm.cumulative_credits,erm.cumulative_gpa,erm.sgpa,erm.markscard_issued, erd.final_grade, erd.cia_marks, erd.exam_marks, erd.final_garde_marks 
		from exam_result_data as erd 
		left join student_master as s on s.stud_id =erd.student_id
		left join subject_master sm on sm.sub_id =erd.subject_id
		left join exam_result_master erm on erm.student_id =erd.student_id and erd.exam_id= erm.exam_id	AND erm.semester=erd.semester
		left join vw_stream_details vw on vw.stream_id =erd.stream_id
		where erd.stream_id='".$stream_id."'  AND erd.exam_id='".$exam_id."' AND erd.student_id='".$stud."' and erd.is_deleted='N' order by s.enrollment_no,erd.semester, sm.subject_order asc";
	//	where erd.stream_id='".$stream_id."' AND erd.semester='".$semester."' AND erd.exam_id='".$exam_id."' AND erd.student_id='".$stud."' order by s.enrollment_no, sm.subject_order asc";
	
		$query = $DB1->query($sql);
	//	echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		
	$stream_details[0]['grades']= $this->fetch_student_grades($stud,$exam_id);
		return $stream_details;
	}
	
	
	public function Manual_certificate($prn,$stream_id,$school_code,$exam_id,$semester,$student_id){
		$DB2 = $this->load->database('umsdb', TRUE);
		/*$sql = "SELECT vw.course_pattern,vw.course_duration,sm.`subject_name`,erd.*
			FROM exam_result_data AS erd
			INNER JOIN subject_master AS sm ON sm.sub_id=erd.`subject_id`  
			INNER JOIN vw_stream_details vw ON vw.stream_id = erd.stream_id
			WHERE erd.enrollment_no='170102011061'  AND erd.final_grade!='U'
		";*/
		//	where erd.stream_id='".$stream_id."' AND erd.semester='".$semester."' AND erd.exam_id='".$exam_id."' AND erd.student_id='".$stud."' order by s.enrollment_no, sm.subject_order asc";
	
		if($stream_id=='116' || $stream_id=='119' || $stream_id=='170'){
			$tbl="grade_policy_details_pharma";
			$fail_grade='F';
		}else{
			$tbl="grade_policy_details";
			$fail_grade='U';
		}
	
	$sql="SELECT distinct TRUNCATE(e.ecumulative_gpa,2) AS cumulative_gpa,eas.easchecb,gpd.grade_point,b.checb,esm.`cumulative_gpa` as esmcumulative_gpa ,
	stm.stud_id,
	stm.first_name,stm.middle_name,stm.last_name,stm.gender,stm.dob,stm.`admission_session`,stm.mother_name,
	sm.`credits`,sm.regulation,vw.course_pattern,vw.course_duration,vw.`stream_name`,vw.gradesheet_name,vw.specialization,
	vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,sm.`subject_name`,sm.subject_order,sm.subject_code as new_subject_code,erd.*,
	CASE
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 9.00 AND b.checb=0 AND easchecb=0) THEN 'Honours' 
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 7.50 AND b.checb=0 AND easchecb=0) THEN 'Distinction' 
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 6.00 THEN 'First Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 5.00  AND TRUNCATE(e.ecumulative_gpa,2) < 6.00 THEN 'Second Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.00  THEN 'Third Class'
	END AS Result

	FROM exam_result_data AS erd
	INNER JOIN student_master AS stm ON stm.enrollment_no='".$prn."'
	INNER JOIN subject_master AS sm ON sm.sub_id=erd.`subject_id`  
	INNER JOIN $tbl as gpd ON gpd.grade_letter=erd.final_grade

	INNER JOIN (SELECT ed.student_id AS bstudent_id,ed.enrollment_no AS benrollment_no,ed.stream_id AS bstream_id,ed.semester AS bsemester, 
	ed.exam_id AS bexam_id, ed.subject_id AS bsubject_id,
	SUM(CASE WHEN (final_grade='".$fail_grade."' OR no_of_attempt='2') THEN 1 ELSE 0 END) AS checb FROM exam_result_data AS ed
	LEFT JOIN exam_student_subject AS ess ON ess.student_id=ed.student_id AND ess.subject_id=ed.subject_id
	WHERE ed.enrollment_no='".$prn."') AS b 
	ON b.bstudent_id=erd.student_id AND b.benrollment_no=erd.enrollment_no
	 
	INNER JOIN (SELECT stud_id AS easstudent_id,enrollment_no AS easenrollment_no,
	SUM(CASE WHEN is_backlog='Y' THEN 1 ELSE 0 END) AS easchecb FROM exam_applied_subjects
	WHERE enrollment_no='".$prn."') AS eas 
	ON eas.easstudent_id=erd.student_id AND eas.easenrollment_no=erd.enrollment_no
	 

	left JOIN exam_result_master AS esm ON esm.enrollment_no='".$prn."' AND esm.exam_id=erd.exam_id  AND esm.semester=erd.semester 

	INNER JOIN (SELECT (a.cumulative_gpa) AS ecumulative_gpa,a.stream_id, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no
	FROM exam_result_master as a
	#INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id

	WHERE a.stream_id='".$stream_id."' AND a.school_id='".$school_code."' AND a.exam_id='".$exam_id."' AND
	 student_id='".$student_id."' order by semester desc limit 1) AS e ON e.estudent_id=erd.student_id
	INNER JOIN vw_stream_details vw ON vw.stream_id = e.stream_id

	WHERE erd.enrollment_no='".$prn."'  AND erd.final_grade!='".$fail_grade."' ORDER BY erd.semester ASC";
	$query = $DB2->query($sql);
	// echo '<pre>';
	// echo $DB2->last_query();exit;
	return $query->result_array();
}
public function check_drop_or_not($enroll){
	$DB2 = $this->load->database('umsdb', TRUE);
	$sql="SELECT 
			sm.enrollment_no,
			sm.academic_year,
			sm.admission_session,
			sm.admission_stream,
			s.course_duration,
			((sm.academic_year - sm.admission_session) + sm.admission_year) AS completion_duration
		FROM student_master sm
		INNER JOIN stream_master s 
			ON sm.admission_stream = s.stream_id
		WHERE sm.enrollment_no='".$enroll."' AND ((sm.academic_year - sm.admission_session) + sm.admission_year) <> s.course_duration";
    $query = $DB2->query($sql);
    return $query->num_rows() > 0; // true if drop found
}
public function check_backlog_or_not($enroll){
	$DB2 = $this->load->database('umsdb', TRUE);
	$sql="SELECT 
			ed.enrollment_no
		FROM exam_details ed
		WHERE ed.enrollment_no='".$enroll."' AND ed.is_regular_makeup = 'M'
		";
    $query = $DB2->query($sql);
    return $query->num_rows() > 0; // true if drop found
}
    function enrollment_no($list){
        $DB2 = $this->load->database('umsdb', TRUE);
        $sql="SELECT enrollment_no from student_master where stud_id='".$list."'";
        $query = $DB2->query($sql);
        //echo $DB2->last_query();exit;
         $data=$query->result_array();
        return $data[0]['enrollment_no'];

    }
	 function student_id($list){
        $DB2 = $this->load->database('umsdb', TRUE);
        $sql="SELECT stud_id from student_master where enrollment_no='".$list."'";
        $query = $DB2->query($sql);
        // echo $DB2->last_query();exit;
         $data=$query->result_array();
        return $data[0]['stud_id'];

    }

	
    function stud_last_exam_session($list){
        $DB2 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * from exam_result_master where student_id='".$list."' order by exam_id desc limit 0,1";
        $query = $DB2->query($sql);
        //echo $DB2->last_query();exit;
       return $query->result_array();

    }
    
	function CheckStudIn($stud_id,$exam_id, $stream, $semester,$school)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select count(student_id) as Total from gradesheet_assgin_details  where student_id ='".$stud_id."' and exam_id='".$exam_id."' and semester='".$semester."' and stream_id='".$stream."' AND school_id='".$school."'";
        $query = $DB1->query($sql);
       // echo $DB1->last_query();
        //exit;
        $res = $query->result_array();
        return $res[0]['Total'];
    }
	function CheckDegreeStudIn($stud_id,$exam_id, $stream, $semester,$school)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select count(student_id) as Total from degreecertficate_assgin_details  where student_id ='".$stud_id."' and exam_id='".$exam_id."' and semester='".$semester."' and stream_id='".$stream."' AND school_id='".$school."'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $res = $query->result_array();
        return $res[0]['Total'];
    }
    function updategradsheetsNo($stud,$exam_id, $stream, $semester,$school)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $where = "semester='$semester' and stream_id='$stream' and exam_id='$exam_id' AND student_id='$stud' AND school_id='$school'";
        $DB1->where($where);   
        $data =array(
            "is_active" => 'N',
            "modified_by" => $this->session->userdata("uid"),
            "modified_ip" => $_SERVER['REMOTE_ADDR'],
            "modified_on" => date("Y-m-d H:i:s")
        );    
        $DB1->update('gradesheet_assgin_details', $data);
        //echo $DB1->last_query();exit;
        return true;
    }  
	
	
	function list_result_students_for_markcards($var, $exam_month, $exam_year, $exam_id)
	{
		// echo 'hii';exit;
		$DB1 = $this->load->database('umsdb', TRUE);

		$stream_id   = $var['admission_branch'];
		$school_code = $var['school_code'];
		$min_reg     = $var['regulation']; // admission_session >= this

		$sql = "
		SELECT 
		  ROUND(erm.cumulative_gpa, 2)               AS cumulative_gpa,
		  IFNULL(b.bad_count, 0)                     AS checb,
		  erm.stream_id,
		  erm.exam_month,
		  erm.exam_year,
		  erm.cumulative_gpa                         AS esmcumulative_gpa,
		  erm.student_id                             AS stud_id,
		  s.enrollment_no,
		  UPPER(CONCAT_WS(' ',
		  COALESCE(s.last_name,''), COALESCE(s.first_name,''), COALESCE(s.middle_name,''))) AS stud_name,
		  erm.semester,
		  s.stud_id,
		  s.current_semester,
		  s.admission_stream,
		  s.admission_year,
		  s.enrollment_no,
		  s.mother_name,
		  s.gender,
		  s.admission_session,
		  s.first_name, s.middle_name, s.last_name,
		  s.father_fname, s.father_mname, s.father_lname,
		  vw.course_duration,
		  vw.gradesheet_name,
		  vw.specialization,
		  vw.degree_specialization,
		  vw.course_name,
		  vw.school_name,
		  vw.school_code,
		  vw.course_pattern,
		  erm.exam_month                             AS sexam_month,
		  m.markscard_no,
		  erm.exam_year                              AS sexam_year,
		  erm.exam_id,
		  erm.enrollment_no                          AS nenrollment_no,

		  CASE
			WHEN ROUND(erm.cumulative_gpa,2) >= 9.00  AND IFNULL(b.bad_count,0)=0 THEN 'Honours'
			WHEN ROUND(erm.cumulative_gpa,2) >= 7.50  AND IFNULL(b.bad_count,0)=0 THEN 'Distinction'
			WHEN ROUND(erm.cumulative_gpa,2)  >= 6.00                                THEN 'First Class'
			WHEN ROUND(erm.cumulative_gpa,2)  >= 5.00 AND ROUND(erm.cumulative_gpa,2) < 6.00 THEN 'Second Class'
			WHEN ROUND(erm.cumulative_gpa,2)  > 5.00                                THEN 'Third Class'
		  END AS Result

		FROM exam_result_master AS erm
		JOIN student_master s
		  ON s.stud_id = erm.student_id
		 AND s.admission_session >= '".$min_reg."'
		JOIN vw_stream_details vw
		  ON vw.stream_id  = erm.stream_id
		 AND vw.school_code = $school_code
		LEFT JOIN gradesheet_assgin_details m
		  ON m.student_id = erm.student_id
		 AND m.exam_id    = $exam_id
		 AND m.is_active  = 'Y'

		/* 🔥 Limit to THIS exam + stream (matches your fast SQL) */
		LEFT JOIN (
			SELECT ed.student_id,
				   SUM( (ed.final_grade IN ('U','F')) OR (ess.no_of_attempt='2') ) AS bad_count
			FROM exam_result_data ed
			LEFT JOIN exam_student_subject ess
			  ON ess.student_id = ed.student_id
			 AND ess.subject_id = ed.subject_id
			WHERE ed.exam_id   = $exam_id         /* <-- added */
			  AND ed.stream_id = $stream_id         /* <-- added */
			GROUP BY ed.student_id
		) AS b
		  ON b.student_id = erm.student_id

		INNER JOIN (SELECT student_id as astudent_id,enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
		SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
		ON a.astudent_id=erm.student_id AND a.chec='0'

		INNER JOIN exam_result_master AS esm ON esm.`student_id`= erm.student_id 

		INNER JOIN (SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no
		FROM exam_result_master as a
		INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id
		WHERE a.stream_id='".$stream_id."' AND vw.school_code='".$var['school_code']."' AND a.exam_id='".$exam_id."'  GROUP BY student_id ) AS e ON e.estudent_id=erm.student_id 

		AND esm.exam_id='".$exam_id."'  
		LEFT JOIN (SELECT MAX(exam_id) AS mxid,student_id FROM exam_result_data  GROUP BY student_id) AS chex 
		   ON chex.student_id=erm.student_id 

		INNER JOIN (SELECT stud_id AS easstudent_id,enrollment_no AS easenrollment_no,
		SUM(CASE WHEN is_backlog='Y' THEN 1 ELSE 0 END) AS easchecb FROM exam_applied_subjects GROUP BY stud_id) AS eas 
		ON eas.easstudent_id=erm.student_id AND eas.easenrollment_no=erm.enrollment_no


		WHERE erm.exam_id   = $exam_id
		  AND erm.stream_id = $stream_id
		GROUP BY erm.student_id
		having 
		CASE WHEN vw.course_pattern ='SEMESTER' THEN 
			s.current_semester=(2 * vw.course_duration)
		  ELSE
		   s.current_semester=(1 * vw.course_duration)
		  END
		ORDER BY erm.enrollment_no ASC
		";

		// Bindings must match placeholder order above
		$bindings = [
			$min_reg,          // s.admission_session >= ?
			$school_code,      // vw.school_code = ?
			$exam_id,          // gradesheet_assgin_details.exam_id
			$exam_id,          // b-subquery: ed.exam_id = ?
			$stream_id,        // b-subquery: ed.stream_id = ?
			$exam_id,          // erm.exam_id = ?
			$stream_id,        // erm.stream_id = ?
			$exam_id           // EXISTS(mm.exam_id = ?)
		];

		$query = $DB1->query($sql);
		// echo '<pre>';
        // echo $DB1->last_query();exit;
		return $query->result_array();
	}

	
	
    
    function updateDegreeCertNo($stud,$exam_id, $stream, $semester,$school)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $where = "semester='$semester' and stream_id='$stream' and exam_id='$exam_id' AND student_id='$stud' AND school_id='$school'";
        $DB1->where($where);   
        $data =array(
            "is_active" => 'N',
            "modified_by" => $this->session->userdata("uid"),
            "modified_ip" => $_SERVER['REMOTE_ADDR'],
            "modified_on" => date("Y-m-d H:i:s")
        );    
        $DB1->update('degreecertficate_assgin_details', $data);
        //echo $DB1->last_query();exit;
        return true;
    } 
    function list_result_students_for_markcards_old($var,$exam_month, $exam_year,$exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);
        $stream_id = $var['admission_branch'];
        $semester = $var['semester'];
      /*  $sql = "SELECT DISTINCT 
erm.stud_id AS student_id, 
s.enrollment_no, 
UPPER(CONCAT(s.last_name, ' ', s.first_name, ' ', s.middle_name)) AS stud_name, 
erm.semester, 
m.markscard_no 
FROM   exam_details AS erm
       left JOIN exam_result_data r ON r.`student_id`=erm.stud_id AND r.exam_id=erm.exam_id AND r.semester=erm.semester
       INNER JOIN student_master s 
              ON s.stud_id = erm.stud_id 
       LEFT JOIN  (SELECT student_id, markscard_no FROM exam_markscard_details where is_active='Y' and exam_id='".$exam_id."') m ON m.student_id = erm.stud_id 
       
	   where erm.stream_id='".$stream_id."' and erm.semester ='".$semester."' and erm.exam_id ='".$exam_id."' and s.cancelled_admission='N' order by erm.stud_id asc"; */
        $sql = "SELECT DISTINCT TRUNCATE(e.ecumulative_gpa,2) as `cumulative_gpa`,b.checb,erm.stream_id,erm.exam_month,
        erm.exam_year, esm.`cumulative_gpa` as esmcumulative_gpa,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(COALESCE(s.last_name,''), ' ',COALESCE(s.first_name,''),' ',COALESCE(s.middle_name,''))) as stud_name,
erm.semester,s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender, 
         s.admission_session,s.first_name,s.middle_name,s.last_name,
         s.father_fname,s.father_mname,s.father_lname,vw.course_duration,vw.gradesheet_name,
         vw.specialization,vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,
          erm.exam_month as sexam_month,m.markscard_no,
         erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no,
CASE
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 9.00 AND b.checb=0) THEN 'Honours' 
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 7.50 AND b.checb=0) THEN 'Distinction' 
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 6.00 THEN 'First Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 5.00 AND TRUNCATE(e.ecumulative_gpa,2) < 6.00 THEN 'Second Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.00  THEN 'Third Class'
END AS Result

FROM exam_result_data AS erm  
INNER JOIN student_master s ON s.stud_id = erm.student_id AND s.admission_session>='".$var['regulation']."'
INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id AND vw.school_code='".$var['school_code']."'

INNER JOIN (SELECT student_id as astudent_id,enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
ON a.astudent_id=erm.student_id AND a.chec='0'

INNER JOIN (SELECT ed.student_id AS bstudent_id,ed.enrollment_no AS benrollment_no,ed.stream_id AS bstream_id,ed.semester AS bsemester,
ed.exam_id AS bexam_id,ed.subject_id AS bsubject_id,SUM(CASE WHEN (ed.final_grade='U' OR ed.final_grade='F' OR ess.no_of_attempt='2') THEN 1 ELSE 0 END) AS checb 
FROM exam_result_data as ed 
LEFT JOIN exam_student_subject AS ess ON ess.student_id=ed.student_id AND ess.subject_id=ed.subject_id
GROUP BY ed.student_id) AS b 
ON b.bstudent_id=erm.student_id 

INNER JOIN exam_result_master AS esm ON esm.`student_id`= erm.student_id 

INNER JOIN (SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no
FROM exam_result_master as a
INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id
WHERE a.stream_id='".$stream_id."' AND vw.school_code='".$var['school_code']."' AND a.exam_id='".$exam_id."' 
#AND a.semester ='".$semester."' 
GROUP BY student_id ) AS e ON e.estudent_id=erm.student_id 
AND esm.exam_id='".$exam_id."' 
#AND esm.semester='".$semester."' 
LEFT JOIN  (SELECT student_id, markscard_no FROM gradesheet_assgin_details where is_active='Y' and exam_id='".$exam_id."') m ON 
m.student_id = erm.student_id 
LEFT JOIN
                (
                       SELECT DISTINCT(semester),student_id
                              
                       FROM   exam_result_master
                       
                     ) mm
ON              mm.student_id = erm.student_id
WHERE erm.stream_id='".$stream_id."' AND erm.exam_id='".$exam_id."' 
#AND erm.semester ='".$semester."'  
AND vw.school_code='".$var['school_code']."' AND mm.semester IN (2 * vw.course_duration)
GROUP BY erm.enrollment_no
#HAVING erm.semester=(2 * vw.course_duration)";
        $query = $DB1->query($sql);
		// echo '<pre>';
        // echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }   
	
	
	
    function list_result_students_for_degree_certificate($var=array(),$exam_month='', $exam_year='',$exam_id=''){
		//print_r($var);
        $DB1 = $this->load->database('umsdb', TRUE);
        $stream_id = $var['admission_branch'];
        $semester = $var['semester'];
		
      /*  $sql = "SELECT DISTINCT 
erm.stud_id AS student_id, 
s.enrollment_no, 
UPPER(CONCAT(s.last_name, ' ', s.first_name, ' ', s.middle_name)) AS stud_name, 
erm.semester, 
m.markscard_no 
FROM   exam_details AS erm
       left JOIN exam_result_data r ON r.`student_id`=erm.stud_id AND r.exam_id=erm.exam_id AND r.semester=erm.semester
       INNER JOIN student_master s 
              ON s.stud_id = erm.stud_id 
       LEFT JOIN  (SELECT student_id, markscard_no FROM exam_markscard_details where is_active='Y' and exam_id='".$exam_id."') m ON m.student_id = erm.stud_id 
        where erm.stream_id='".$stream_id."' and erm.semester ='".$semester."' and erm.exam_id ='".$exam_id."' and s.cancelled_admission='N' order by erm.stud_id asc"; */
        //echo $stream_id;exit; 
		if($stream_id ==71){
			//echo $stream_id;exit;
		$sql = "SELECT DISTINCT TRUNCATE(e.ecumulative_gpa,2) as `cumulative_gpa`,b.checb,erm.stream_id,erm.exam_month,
        erm.exam_year, esm.`sgpa` as esmcumulative_gpa,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(COALESCE(s.last_name,''), ' ',COALESCE(s.first_name,''),' ',COALESCE(s.middle_name,''))) as stud_name,
erm.semester,s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender, 
         s.admission_session,s.first_name,s.middle_name,s.last_name,
         s.father_fname,s.father_mname,s.father_lname,vw.course_duration,vw.gradesheet_name,
         vw.specialization,vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,
          erm.exam_month as sexam_month,m.markscard_no,
         erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no,chex.mxid,e.dpharma_class
 AS Result

FROM exam_result_data AS erm  
INNER JOIN student_master s ON s.stud_id = erm.student_id AND s.admission_session>='".$var['regulation']."'
INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id AND vw.school_code='".$var['school_code']."'

INNER JOIN (SELECT student_id as astudent_id,enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
ON a.astudent_id=erm.student_id AND a.chec='0'

INNER JOIN (SELECT student_id AS bstudent_id,enrollment_no AS benrollment_no,stream_id AS bstream_id,semester AS bsemester,
exam_id AS bexam_id,
subject_id AS bsubject_id,SUM(CASE WHEN (final_grade='U' OR final_grade='F')
 THEN 1 ELSE 0 END) AS checb FROM exam_result_data GROUP BY student_id) AS b 
ON b.bstudent_id=erm.student_id 


INNER JOIN exam_result_master AS esm ON esm.`student_id`= erm.student_id 

INNER JOIN (SELECT (a.sgpa) AS ecumulative_gpa,a.dpharma_class as dpharma_class, a.student_id AS estudent_id, a.enrollment_no AS eenrollment_no
FROM exam_result_master as a
INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id
WHERE a.stream_id='".$stream_id."' AND vw.school_code='".$var['school_code']."' AND a.exam_id='".$exam_id."' 
#AND a.semester ='".$semester."' 
GROUP BY student_id ) AS e ON e.estudent_id=erm.student_id 
AND esm.exam_id='".$exam_id."' 
#AND esm.semester='".$semester."' 
LEFT JOIN  (SELECT student_id, markscard_no FROM degreecertficate_assgin_details where is_active='Y' and exam_id='".$exam_id."') m 
ON m.student_id = erm.student_id 
LEFT JOIN
                (
                       SELECT DISTINCT(semester),student_id
                              
                       FROM   exam_result_master
                       
                     ) mm
ON              mm.student_id = erm.student_id
LEFT JOIN (SELECT MAX(exam_id) AS mxid,student_id FROM exam_result_data  GROUP BY student_id) AS chex 
   ON chex.student_id=erm.student_id 

WHERE (CASE WHEN vw.course_pattern ='SEMESTER' THEN 
    mm.semester IN (2 * vw.course_duration)
  ELSE
   mm.semester IN (1 * vw.course_duration)
  END) and erm.stream_id='".$stream_id."' AND erm.exam_id='".$exam_id."'  
#AND mm.semester IN (2 * vw.course_duration)
#AND erm.semester ='".$semester."' 
 AND vw.school_code='".$var['school_code']."'
GROUP BY erm.enrollment_no
HAVING chex.mxid='".$exam_id."'
#HAVING erm.semester=(2 * vw.course_duration)";

		}else{


$sql = "SELECT DISTINCT TRUNCATE(e.ecumulative_gpa,2) as `cumulative_gpa`,b.checb,erm.stream_id,erm.exam_month,
        erm.exam_year, esm.`cumulative_gpa` as esmcumulative_gpa,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(COALESCE(s.last_name,''), ' ',COALESCE(s.first_name,''),' ',COALESCE(s.middle_name,''))) as stud_name,
erm.semester,s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender, 
         s.admission_session,s.first_name,s.middle_name,s.last_name,
         s.father_fname,s.father_mname,s.father_lname,vw.course_duration,vw.gradesheet_name,
         vw.specialization,vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,
          erm.exam_month as sexam_month,m.markscard_no,
         erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no,chex.mxid,
CASE
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 9.00 AND b.checb=0) THEN 'Honours' 
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 7.50 AND b.checb=0) THEN 'Distinction' 
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 6.00 THEN 'First Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 5.00 AND TRUNCATE(e.ecumulative_gpa,2) < 6.00 THEN 'Second Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.00  THEN 'Third Class'
END AS Result

FROM exam_result_data AS erm  
INNER JOIN student_master s ON s.stud_id = erm.student_id AND s.admission_session>='".$var['regulation']."'
INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id AND vw.school_code='".$var['school_code']."'

INNER JOIN (SELECT student_id as astudent_id,enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
ON a.astudent_id=erm.student_id AND a.chec='0'

INNER JOIN (SELECT student_id AS bstudent_id,enrollment_no AS benrollment_no,stream_id AS bstream_id,semester AS bsemester,
exam_id AS bexam_id,
subject_id AS bsubject_id,SUM(CASE WHEN (final_grade='U' OR final_grade='F')
 THEN 1 ELSE 0 END) AS checb FROM exam_result_data GROUP BY student_id) AS b 
ON b.bstudent_id=erm.student_id 


INNER JOIN exam_result_master AS esm ON esm.`student_id`= erm.student_id 

INNER JOIN (SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no
FROM exam_result_master as a
INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id
WHERE a.stream_id='".$stream_id."' AND vw.school_code='".$var['school_code']."' AND a.exam_id='".$exam_id."' 
#AND a.semester ='".$semester."' 
GROUP BY student_id ) AS e ON e.estudent_id=erm.student_id 
AND esm.exam_id='".$exam_id."' 
#AND esm.semester='".$semester."' 
LEFT JOIN  (SELECT student_id, markscard_no FROM degreecertficate_assgin_details where is_active='Y' and exam_id='".$exam_id."') m 
ON m.student_id = erm.student_id 
LEFT JOIN
                (
                       SELECT DISTINCT(semester),student_id
                              
                       FROM   exam_result_master
                       
                     ) mm
ON              mm.student_id = erm.student_id
LEFT JOIN (SELECT MAX(exam_id) AS mxid,student_id FROM exam_result_data  GROUP BY student_id) AS chex 
   ON chex.student_id=erm.student_id 

WHERE (CASE WHEN vw.course_pattern ='SEMESTER' THEN 
    mm.semester IN (2 * vw.course_duration)
  ELSE
   mm.semester IN (1 * vw.course_duration)
  END) and erm.stream_id='".$stream_id."' AND erm.exam_id='".$exam_id."'  
#AND mm.semester IN (2 * vw.course_duration)
#AND erm.semester ='".$semester."' 
 AND vw.school_code='".$var['school_code']."'
GROUP BY erm.enrollment_no
HAVING chex.mxid='".$exam_id."'
#HAVING erm.semester=(2 * vw.course_duration)";
		}
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit; 
        $stream_details = $query->result_array();
        return $stream_details;
    }   	
/////////////////////////////////////////////////////////////////////	



     function list_result_students_for_dispatch($stream_id, $semester,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select s.enrollment_no,UPPER(CONCAT(COALESCE(s.last_name,''), ' ',COALESCE(s.first_name,''),' ',COALESCE(s.middle_name,''))) as stud_name,
		e.markscard_no  
		from gradesheet_assgin_details e 
        left join student_master s on s.stud_id = e.student_id
        where e.exam_id='".$exam_id."' and e.semester='".$semester."' and e.stream_id='".$stream_id."'
		and e.is_active='Y' group by e.student_id order by e.enrollment_no";

        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $res = $query->result_array();
        return $res;
    }      
	
	function get_marathi_grade(){
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select * FROM grade";

        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $res = $query->result_array();
        return $res;
	}
	
	function list_result_students_for_rank($var,$exam_month, $exam_year,$exam_id){

        $DB1 = $this->load->database('umsdb', TRUE);
    
    
        $stream_id = $var['admission_branch'];
        $semester = $var['semester'];
    //  print_r($var);exit;
        
        if($var['school_code']=="All"){

            $sql = "SELECT s.enrollment_no,s.stud_id,e.cumulative_gpa,e.exam_id,e.exam_month,e.exam_year,e.stream_id,e.semester, s.first_name,s.middle_name,s.last_name,v.school_short_name,v.stream_name,s.admission_year,s.admission_session,v.course_duration,v.course_pattern,s.final_semester,s.current_semester,

					CASE WHEN (TRUNCATE(e.cumulative_gpa,2) >= 9.00 ) THEN 'Honours' 
					WHEN (TRUNCATE(e.cumulative_gpa,2) >= 7.50 ) THEN 'Distinction' 

					WHEN TRUNCATE(e.cumulative_gpa,2) >= 6.00 THEN 'First Class' 
					WHEN TRUNCATE(e.cumulative_gpa,2) >= 5.00 AND TRUNCATE(e.cumulative_gpa,2) < 6.00 THEN 'Second Class' 
					WHEN TRUNCATE(e.cumulative_gpa,2) > 5.00 THEN 'Third Class' END AS Result,d.markscard_no 
					FROM `exam_result_master` e LEFT JOIN student_master s ON e.student_id=s.stud_id 
					left join degreecertficate_assgin_details d on d.student_id=e.student_id and d.is_active='Y'
					LEFT JOIN vw_stream_details v ON e.stream_id=v.stream_id  
					WHERE (CASE WHEN v.course_pattern ='SEMESTER' THEN 
						s.current_semester=(2 * v.course_duration)
					  ELSE
					   s.current_semester=(1 * v.course_duration)
					  END) and e.stream_id = '".$stream_id."' and s.stud_id != '' AND s.admission_session ='".$var['regulation']."' and e.student_id NOT IN (SELECT student_id FROM `exam_result_data` WHERE `result_grade` = 'U')GROUP BY e.student_id,e.stream_id,e.school_id
					   ORDER BY e.cumulative_gpa desc";
            /*$sql = "SELECT DISTINCT TRUNCATE(e.ecumulative_gpa,2) AS `cumulative_gpa`,vw.course_pattern,chex.mxid,b.checb,erm.stream_id,erm.exam_month,erm.exam_year, esm.`cumulative_gpa` as esmcumulative_gpa,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(s.last_name,' ',s.first_name,' ',s.middle_name)) AS stud_name,
erm.semester,s.stud_id,s.current_semester,s.admission_stream,s.admission_year, s.enrollment_no, s.mother_name, s.gender, 
         s.admission_session,s.first_name,s.middle_name,s.last_name,
         s.father_fname,s.father_mname,s.father_lname,vw.gradesheet_name,
         vw.course_duration,vw.specialization,vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,
          erm.exam_month as sexam_month,
         erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no,
CASE
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 9.00 AND b.checb=0) THEN 'Honours' 
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 7.50 AND b.checb=0) THEN 'Distinction' 
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 6.00 THEN 'First Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.50 AND TRUNCATE(e.ecumulative_gpa,2) < 6.00 THEN 'Second Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.00  THEN 'Third Class'
END AS Result

FROM exam_result_data AS erm  
INNER JOIN student_master s ON s.stud_id = erm.student_id AND s.admission_session>='".$var['regulation']."'
INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id 

INNER JOIN (SELECT enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
ON a.aenrollment_no=erm.enrollment_no AND a.chec='0'

INNER JOIN (SELECT ed.student_id AS bstudent_id,ed.enrollment_no AS benrollment_no,ed.stream_id AS bstream_id,ed.semester AS bsemester,
ed.exam_id AS bexam_id,ed.subject_id AS bsubject_id,SUM(CASE WHEN (ed.final_grade='U' OR ess.no_of_attempt='2')
 THEN 1 ELSE 0 END) AS checb FROM exam_result_data as ed 
 LEFT JOIN exam_student_subject AS ess ON ess.student_id=ed.student_id AND ess.subject_id=ed.subject_id

 GROUP BY ed.student_id) AS b 
ON b.bstudent_id=erm.student_id AND b.benrollment_no=erm.enrollment_no 


INNER JOIN exam_result_master AS esm ON esm.`student_id`= erm.student_id  AND erm.stream_id=esm.stream_id


INNER JOIN (SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no
FROM exam_result_master as a
INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id
WHERE a.stream_id='".$stream_id."' AND a.exam_id='".$exam_id."' GROUP BY student_id) AS e ON e.estudent_id=erm.student_id 
AND esm.exam_id='".$exam_id."' AND esm.exam_year
LEFT JOIN (SELECT MAX(exam_id) AS mxid,student_id FROM exam_result_data  GROUP BY student_id) AS chex 
   ON chex.student_id=erm.student_id 

WHERE erm.exam_id='".$exam_id."' AND vw.course_pattern='SEMESTER'  AND erm.school_id in('1001','1009','1006','1010')
GROUP BY erm.enrollment_no
HAVING chex.mxid='$exam_id' AND
CASE WHEN vw.course_pattern ='SEMESTER' THEN 
    s.current_semester=(2 * vw.course_duration)
  ELSE
   s.current_semester=(1 * vw.course_duration)
  END"; */

//ORDER BY erm.enrollment_no DESC //erm.semester=(2 * vw.course_duration)
        
        
        $query = $DB1->query($sql);
      echo $DB1->last_query(); exit;//AND erm.stream_id='".$stream_id."'
        $stream_details = $query->result_array();
        return $stream_details;
        }else{
        /*$sql = "select distinct erm.student_id as stud_id,s.enrollment_no,UPPER(CONCAT(s.last_name,' ',s.first_name,' ',s.middle_name)) as stud_name,erm.semester from exam_result_data as erm  
        left join student_master s on s.stud_id = erm.student_id
        INNER JOIN (SELECT enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec
FROM exam_student_subject GROUP BY enrollment_no) AS a ON a.aenrollment_no=erm.enrollment_no AND a.chec='0'
        where stream_id='".$stream_id."' and exam_id='".$exam_id."' and semester ='".$semester."' order by erm.student_id asc";
        */
        /*$sql = "SELECT DISTINCT TRUNCATE(e.ecumulative_gpa,2) as `cumulative_gpa`,vw.course_pattern,chex.mxid,b.checb,erm.stream_id,erm.exam_month,
        erm.exam_year, esm.`cumulative_gpa` as esmcumulative_gpa,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(s.last_name,' ',s.first_name,' ',s.middle_name)) AS stud_name,
erm.semester,s.stud_id,s.current_semester,s.admission_stream,s.admission_year, s.enrollment_no, s.mother_name, s.gender, 
         s.admission_session,s.first_name,s.middle_name,s.last_name,
         s.father_fname,s.father_mname,s.father_lname,vw.course_duration,vw.gradesheet_name,
         vw.specialization,vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,
          erm.exam_month as sexam_month,
         erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no,
CASE
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 9.00 AND b.checb=0) THEN 'Honours' 
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 7.50 AND b.checb=0) THEN 'Distinction' 
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 6.00 THEN 'First Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.50 AND TRUNCATE(e.ecumulative_gpa,2) < 6.00 THEN 'Second Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.00  THEN 'Third Class'
END AS Result,d.markscard_no

FROM exam_result_data AS erm 
left join degreecertficate_assgin_details d on d.student_id=erm.student_id and d.is_active='Y'
INNER JOIN student_master s ON s.stud_id = erm.student_id AND s.admission_session>='".$var['regulation']."'
INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id AND vw.school_code='".$var['school_code']."'

INNER JOIN (SELECT student_id as astudent_id,enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
ON a.astudent_id=erm.student_id AND a.chec='0'

INNER JOIN (SELECT ed.student_id AS bstudent_id,ed.enrollment_no AS benrollment_no,ed.stream_id AS bstream_id,ed.semester AS bsemester,
ed.exam_id AS bexam_id,ed.subject_id AS bsubject_id,SUM(CASE WHEN (ed.final_grade='U' OR ed.final_grade='F' OR ess.no_of_attempt='2')
 THEN 1 ELSE 0 END) AS checb FROM exam_result_data as ed 
 LEFT JOIN exam_student_subject AS ess ON ess.student_id=ed.student_id AND ess.subject_id=ed.subject_id
GROUP BY ed.student_id) AS b 
ON b.bstudent_id=erm.student_id 


INNER JOIN exam_result_master AS esm ON esm.`student_id`= erm.student_id 

INNER JOIN (SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no
FROM exam_result_master as a
INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id
WHERE a.stream_id='".$stream_id."' AND vw.school_code='".$var['school_code']."' AND a.exam_id='".$exam_id."'  GROUP BY student_id ) AS e ON e.estudent_id=erm.student_id 

AND esm.exam_id='".$exam_id."'  
LEFT JOIN (SELECT MAX(exam_id) AS mxid,student_id FROM exam_result_data  GROUP BY student_id) AS chex 
   ON chex.student_id=erm.student_id 

WHERE erm.stream_id='".$stream_id."' AND erm.exam_id='".$exam_id."'  AND vw.school_code='".$var['school_code']."'
GROUP BY erm.enrollment_no  having chex.mxid='$exam_id' AND
CASE WHEN vw.course_pattern ='SEMESTER' THEN 
    s.current_semester=(2 * vw.course_duration)
  ELSE
   s.current_semester=(1 * vw.course_duration)
  END
  ";    */

  /* $sql = "SELECT s.enrollment_no,s.stud_id,TRUNCATE(e.cumulative_gpa,2) as cumulative_gpa,e.exam_id,e.exam_month,e.exam_year,e.stream_id,e.semester, s.first_name,s.middle_name,s.last_name,v.school_short_name,v.stream_name,s.admission_year,s.admission_session,v.course_duration,v.course_pattern,s.final_semester,s.current_semester,v.stream_name,

CASE WHEN (TRUNCATE(e.cumulative_gpa,2) >= 9.00 ) THEN 'Honours' 
WHEN (TRUNCATE(e.cumulative_gpa,2) >= 7.50 ) THEN 'Distinction' 

WHEN TRUNCATE(e.cumulative_gpa,2) > 6.00 THEN 'First Class' 
WHEN TRUNCATE(e.cumulative_gpa,2) > 5.50 AND TRUNCATE(e.cumulative_gpa,2) < 6.00 THEN 'Second Class' 
WHEN TRUNCATE(e.cumulative_gpa,2) > 5.00 THEN 'Third Class' END AS Result,d.markscard_no 
FROM `exam_result_master` e LEFT JOIN student_master s ON e.student_id=s.stud_id 
left join degreecertficate_assgin_details d on d.student_id=e.student_id and d.is_active='Y'
LEFT JOIN vw_stream_details v ON e.stream_id=v.stream_id  AND v.school_code='".$var['school_code']."'
WHERE (CASE WHEN v.course_pattern ='SEMESTER' THEN 
    s.current_semester=(2 * v.course_duration) and e.semester = (2 * v.course_duration)
  ELSE
   s.current_semester=(1 * v.course_duration) and e.semester = (1 * v.course_duration)
  END) and e.stream_id = '".$stream_id."' AND e.exam_id='".$exam_id."' and s.stud_id != '' AND s.admission_session ='".$var['regulation']."' and e.student_id NOT IN (SELECT student_id FROM `exam_result_data` WHERE `final_grade` = 'U' || `final_grade` = 'F')GROUP BY e.student_id,e.stream_id,e.school_id
   ORDER BY e.cumulative_gpa desc"; */
        //exit;
		
$sql = "
SELECT 
    e.ecumulative_gpa AS cumulative_gpa,
    eas.easchecb,
    vw.course_pattern,
    chex.mxid,
    b.checb,
    erm.stream_id,
    erm.exam_month,
    erm.exam_year,
    esm.cumulative_gpa AS esmcumulative_gpa,
    erm.student_id AS stud_id,
    s.enrollment_no,
    UPPER(CONCAT(COALESCE(s.last_name,''),' ',COALESCE(s.first_name,''),' ',COALESCE(s.middle_name,''))) AS stud_name,
    erm.semester,
    s.stud_id,
    s.current_semester,
    s.admission_stream,
    s.admission_year,
    s.mother_name,
    s.gender,
    s.admission_session,
    s.first_name,
    s.middle_name,
    s.last_name,
    s.father_fname,
    s.father_mname,
    s.father_lname,
    vw.course_duration,
    vw.gradesheet_name,
    vw.specialization,
    vw.degree_specialization,
    vw.course_name,
    vw.school_name,
    vw.school_code,
    erm.exam_month AS sexam_month,
    erm.exam_year AS sexam_year,
    erm.exam_id,
    erm.enrollment_no AS nenrollment_no,
    CASE 
        WHEN e.ecumulative_gpa >= 9.00 AND b.checb = 0 AND eas.easchecb = 0 THEN 'Honours'
        WHEN e.ecumulative_gpa >= 7.50 AND b.checb = 0 AND eas.easchecb = 0 THEN 'Distinction'
        WHEN e.ecumulative_gpa >= 6.00 THEN 'First Class'
        WHEN e.ecumulative_gpa >= 5.00 AND e.ecumulative_gpa < 6.00 THEN 'Second Class'
        WHEN e.ecumulative_gpa > 5.00 THEN 'Third Class'
    END AS Result,
    d.markscard_no
FROM exam_result_data AS erm
LEFT JOIN degreecertficate_assgin_details d 
    ON d.student_id = erm.student_id 
    AND d.stream_id = ? 
    AND d.exam_id = ? 
    AND d.is_active = 'Y'
INNER JOIN student_master s 
    ON s.stud_id = erm.student_id 
    AND s.admission_session >= ?
INNER JOIN vw_stream_details vw 
    ON vw.stream_id = erm.stream_id 
    AND vw.school_code = ?
INNER JOIN exam_result_master esm 
    ON esm.student_id = erm.student_id
INNER JOIN (
    SELECT student_id, TRUNCATE(cumulative_gpa,2) AS ecumulative_gpa
    FROM exam_result_master
    WHERE stream_id = ? AND exam_id = ?
) AS e ON e.student_id = erm.student_id
LEFT JOIN (
    SELECT student_id, MAX(exam_id) AS mxid
    FROM exam_result_data
    GROUP BY student_id
) AS chex ON chex.student_id = erm.student_id
LEFT JOIN (
    SELECT ed.student_id, SUM(CASE WHEN (ed.final_grade='U' OR ed.final_grade='F' OR ess.no_of_attempt=2) THEN 1 ELSE 0 END) AS checb
    FROM exam_result_data ed
    LEFT JOIN exam_student_subject ess 
        ON ess.student_id = ed.student_id 
        AND ess.subject_id = ed.subject_id
    GROUP BY ed.student_id
) AS b ON b.student_id = erm.student_id
INNER JOIN (
    SELECT student_id, SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec
    FROM exam_student_subject
    GROUP BY student_id
) AS a ON a.student_id = erm.student_id 
      AND a.chec = 0
INNER JOIN (
    SELECT stud_id, enrollment_no, SUM(CASE WHEN is_backlog='Y' THEN 1 ELSE 0 END) AS easchecb
    FROM exam_applied_subjects
    GROUP BY stud_id, enrollment_no
) AS eas ON eas.stud_id = erm.student_id 
        AND eas.enrollment_no = erm.enrollment_no
WHERE erm.stream_id = ? 
  AND erm.exam_id = ? 
  AND vw.school_code = ?
GROUP BY erm.enrollment_no
HAVING chex.mxid = ? 
   AND CASE 
           WHEN vw.course_pattern = 'SEMESTER' THEN s.current_semester = 2*vw.course_duration
           ELSE s.current_semester = 1*vw.course_duration
       END
ORDER BY cumulative_gpa DESC
";

// Then execute using query bindings to prevent SQL injection
$query = $DB1->query($sql, [
    $stream_id, $exam_id, $var['regulation'], $var['school_code'],
    $stream_id, $exam_id,
    $stream_id, $exam_id, $var['school_code'],
    $exam_id
]);

      //  echo $DB1->last_query(); exit;
        if($this->session->userdata("role_id")==6){
     //echo $DB1->last_query(); exit;
        }
        $stream_details = $query->result_array();
        return $stream_details;
        }
    }
	
	 function stud_pass_in_limited_year($list){
        $DB2 = $this->load->database('umsdb', TRUE);
        $pass_year="SELECT * from exam_result_master where student_id='".$list."' order by exam_id desc limit 0,1";
        $query = $DB2->query($pass_year);
        $pass_year = $query->result_array();
        $pass_year1 = $pass_year['0']['exam_year'];

        $addmission_year = "SELECT * from student_master where stud_id='".$list."'";
        $query = $DB2->query($addmission_year);
        $addmission_year = $query->result_array();
        $addmission_year_1 = $addmission_year['0']['admission_session'];
        $admission_stream = $addmission_year['0']['admission_stream'];

        $stream_details = "SELECT * from stream_master where stream_id='".$admission_stream."'";
        $query = $DB2->query($stream_details);
        $stream_details = $query->result_array();
        $stream_details1 = $stream_details['0']['course_duration'];

        $c_dur = $pass_year1 - $addmission_year_1;
        //echo '<pre>';
        //
        //print_r($c_dur);exit;
        
        if($c_dur == $stream_details1 || $stream_details1 > $c_dur){

           return 1; 
        }else{
            return 0;
        }

        
    
       

    }
	
	function get_proviCerticateStudents_new_for_rank($var,$enrollment_no,$stream_id,$exam_id,$rank)
    {
        ///echo '<pre>';
        //print_r($rank);exit;
        $cnt = $var['count'];
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT DISTINCT TRUNCATE(e.ecumulative_gpa,2) AS `cumulative_gpa`,$cnt as stcount, $rank as rnk, b.checb,erm.stream_id,erm.exam_month,esm.dpharma_class,
        erm.exam_year, esm.`cumulative_gpa` as esmcumulative_gpa,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(COALESCE(s.last_name,''), ' ',COALESCE(s.first_name,''),' ',COALESCE(s.middle_name,''))) as stud_name,s.marathi_name,vw.course_name_marathi,vw.stream_name_marathi,
exx.exam_month_marathi,
erm.semester,s.stud_id,s.current_semester,s.admission_stream, s.enrollment_no, s.mother_name, s.gender, 
         s.admission_session,s.first_name,s.middle_name,s.last_name,
         s.father_fname,s.father_mname,s.father_lname,vw.course_duration,vw.gradesheet_name,
         vw.specialization,vw.degree_specialization,vw.course_name,vw.school_name,vw.school_code,
         erm.exam_month as sexam_month,
         erm.exam_year as  sexam_year,erm.exam_id,erm.enrollment_no AS nenrollment_no,
CASE
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 9.00 AND b.checb=0) THEN 'Honours' 
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 7.50 AND b.checb=0) THEN 'Distinction' 
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 6.00 THEN 'First Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 5.00 AND TRUNCATE(e.ecumulative_gpa,2) < 6.00 THEN 'Second Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) > 5.00  THEN 'Third Class'
END AS Result

FROM exam_result_data AS erm  
INNER JOIN student_master s ON s.stud_id = erm.student_id

INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id AND vw.school_code='".$var['school']."'

INNER JOIN (SELECT enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id,
SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a 
ON a.aenrollment_no=erm.enrollment_no AND a.chec='0'

INNER JOIN (SELECT ed.student_id AS bstudent_id,ed.enrollment_no AS benrollment_no,ed.stream_id AS bstream_id,ed.semester AS bsemester,
ed.exam_id AS bexam_id,ed.subject_id AS bsubject_id,SUM(CASE WHEN (ed.final_grade='U' OR ed.final_grade='F') 
 THEN 1 ELSE 0 END) AS checb FROM exam_result_data as ed
  GROUP BY ed.student_id) AS b 
ON b.bstudent_id=erm.student_id AND b.benrollment_no=erm.enrollment_no 


INNER JOIN exam_result_master AS esm ON esm.`student_id`= erm.student_id

INNER JOIN (SELECT (a.cumulative_gpa) AS ecumulative_gpa, a.student_id AS estudent_id,a.enrollment_no AS eenrollment_no
FROM exam_result_master as a
INNER JOIN vw_stream_details AS vw ON vw.stream_id=a.stream_id
WHERE a.stream_id='".$stream_id."' AND vw.school_code='".$var['school']."' AND a.exam_id='".$exam_id."' GROUP BY student_id ) AS e
 ON e.estudent_id=erm.student_id 
left JOIN exam_session AS exx ON exx.exam_id='".$exam_id."'
WHERE  erm.enrollment_no='".$enrollment_no."' AND erm.exam_id ='".$exam_id."' 
GROUP BY erm.enrollment_no";  
        $query = $DB1->query($sql);
        if($this->session->userdata("role_id")==6){
        }
       //echo $DB1->last_query();  exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	
	 function list_result_students_for_rank_for_all_stream_list($var,$exam_month, $exam_year,$exam_id){

        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select distinct vsd.stream_id, vsd.stream_name, vsd.stream_short_name from vw_stream_details as vsd where vsd.course_id='".$var['admission_course']."' group by vsd.stream_id";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;

    }
        
        function list_result_students_for_rank_for_all($school_code,$admission_session,$exam_id, $stream_id){

            //print_r($var['admission_course']);exit;

        $DB1 = $this->load->database('umsdb', TRUE);
    
    
        //$stream_id = $var['admission_branch'];
        //$semester = $var['semester'];
                     
  $sql = "SELECT s.enrollment_no,s.stud_id,TRUNCATE(e.cumulative_gpa,2) as cumulative_gpa,(select exam_id from exam_result_master where student_id = e.student_id order by exam_id desc limit 1) as exam_id,(select exam_month from exam_result_master where student_id = e.student_id order by exam_id desc limit 1) as exam_month,(select exam_year from exam_result_master where student_id = e.student_id order by exam_id desc limit 1) as exam_year,e.stream_id,e.semester, s.first_name,s.middle_name,s.last_name,v.school_short_name,v.stream_name,s.admission_year,s.admission_session,v.course_duration,v.course_pattern,s.final_semester,s.current_semester,v.course_short_name,

CASE WHEN (TRUNCATE(e.cumulative_gpa,2) >= 9.00 ) THEN 'Honours' 
WHEN (TRUNCATE(e.cumulative_gpa,2) >= 7.50 ) THEN 'Distinction' 

WHEN TRUNCATE(e.cumulative_gpa,2) >= 6.00 THEN 'First Class' 
WHEN TRUNCATE(e.cumulative_gpa,2) >= 5.00 AND TRUNCATE(e.cumulative_gpa,2) < 6.00 THEN 'Second Class' 
WHEN TRUNCATE(e.cumulative_gpa,2) > 5.00 THEN 'Third Class' END AS Result,d.markscard_no 
FROM `exam_result_master` e LEFT JOIN student_master s ON e.student_id=s.stud_id 
left join degreecertficate_assgin_details d on d.student_id=e.student_id and d.is_active='Y'
LEFT JOIN vw_stream_details v ON e.stream_id=v.stream_id  AND v.school_code='".$school_code."'

INNER JOIN (SELECT student_id as astudent_id,enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id, SUM(CASE WHEN passed='Y' THEN 0 ELSE 1 END) AS chec 
 FROM exam_student_subject GROUP BY student_id) AS a ON a.astudent_id=e.student_id AND a.chec='0'

WHERE (CASE WHEN v.course_pattern ='SEMESTER' THEN 
    s.current_semester=(2 * v.course_duration) and e.semester = (2 * v.course_duration)
  ELSE
   s.current_semester=(1 * v.course_duration) and e.semester = (1 * v.course_duration)
  END) and e.stream_id = '".$stream_id."' and s.stud_id != ''  GROUP BY e.student_id,e.stream_id,e.school_id
   ORDER BY e.cumulative_gpa desc";
        //exit;
        $query = $DB1->query($sql);
        ///echo $DB1->last_query(); exit;
        if($this->session->userdata("role_id")==6){
     //echo $DB1->last_query(); exit;
        }
        $stream_details = $query->result_array();
        return $stream_details;
      
    }
	
	function get_edcourses_for_rank($school_code){
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select v.course_id, v.course_name, v.course_short_name from (select DISTINCT stream_id from exam_details) as e left join vw_stream_details as v on v.stream_id= e.stream_id  where v.school_code='$school_code' group by v.course_id  order by v.course_name asc";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	
	function list_result_students_for_toperlist($school_code,$admission_session,$exam_id, $stream_id,$semester){

        $DB1 = $this->load->database('umsdb', TRUE);
    
    
        //$stream_id = $var['admission_branch'];
        //$semester = $var['semester'];
        //print_r($var);exit;
        
        if($var['school_code']=="All"){

            $sql = "SELECT s.enrollment_no,s.stud_id,e.cumulative_gpa,e.exam_id,e.exam_month,e.exam_year,e.stream_id,e.semester, s.first_name,s.middle_name,s.last_name,v.school_short_name,v.stream_name,s.admission_year,s.admission_session,v.course_duration,v.course_pattern,s.final_semester,s.current_semester,

CASE WHEN (TRUNCATE(e.cumulative_gpa,2) >= 9.00 ) THEN 'Honours' 
WHEN (TRUNCATE(e.cumulative_gpa,2) >= 7.50 ) THEN 'Distinction' 

WHEN TRUNCATE(e.cumulative_gpa,2) >= 6.00 THEN 'First Class' 
WHEN TRUNCATE(e.cumulative_gpa,2) >= 5.00 AND TRUNCATE(e.cumulative_gpa,2) < 6.00 THEN 'Second Class' 
WHEN TRUNCATE(e.cumulative_gpa,2) > 5.00 THEN 'Third Class' END AS Result,d.markscard_no 
FROM `exam_result_master` e LEFT JOIN student_master s ON e.student_id=s.stud_id 
left join degreecertficate_assgin_details d on d.student_id=e.student_id and d.is_active='Y'
LEFT JOIN vw_stream_details v ON e.stream_id=v.stream_id  
WHERE (CASE WHEN v.course_pattern ='SEMESTER' THEN 
    s.current_semester=(2 * v.course_duration)
  ELSE
   s.current_semester=(1 * v.course_duration)
  END) and e.stream_id = '".$stream_id."' and s.stud_id != '' AND s.admission_session ='".$admission_session."' and e.student_id NOT IN (SELECT student_id FROM `exam_result_data` WHERE `result_grade` = 'U')GROUP BY e.student_id,e.stream_id,e.school_id
   ORDER BY e.cumulative_gpa desc";
        $query = $DB1->query($sql);
      //echo $DB1->last_query(); exit;//AND erm.stream_id='".$stream_id."'
        $stream_details = $query->result_array();
        return $stream_details;
        }else{
  $sql = "SELECT s.enrollment_no,s.stud_id,TRUNCATE(e.cumulative_gpa,2) as cumulative_gpa,e.exam_id,e.exam_month,e.exam_year,e.stream_id,e.semester, s.first_name,s.middle_name,s.last_name,v.school_short_name,v.stream_name,s.admission_year,s.admission_session,v.course_duration,v.course_pattern,s.final_semester,s.current_semester,v.stream_name,

CASE WHEN (TRUNCATE(e.cumulative_gpa,2) >= 9.00 ) THEN 'Honours' 
WHEN (TRUNCATE(e.cumulative_gpa,2) >= 7.50 ) THEN 'Distinction' 

WHEN TRUNCATE(e.cumulative_gpa,2) >= 6.00 THEN 'First Class' 
WHEN TRUNCATE(e.cumulative_gpa,2) >= 5.00 AND TRUNCATE(e.cumulative_gpa,2) < 6.00 THEN 'Second Class' 
WHEN TRUNCATE(e.cumulative_gpa,2) > 5.00 THEN 'Third Class' END AS Result,d.markscard_no 
FROM `exam_result_master` e LEFT JOIN student_master s ON e.student_id=s.stud_id 
left join degreecertficate_assgin_details d on d.student_id=e.student_id and d.is_active='Y'
LEFT JOIN vw_stream_details v ON e.stream_id=v.stream_id  AND v.school_code='".$school_code."'
WHERE e.semester%2=0 and  e.stream_id ='".$stream_id."' and e.exam_id = '".$exam_id."' and s.stud_id != ''   and e.semester = '".$semester."' and e.student_id NOT IN (SELECT student_id FROM `exam_result_data` WHERE `final_grade` = 'U' || `final_grade` = 'F')GROUP BY e.student_id,e.stream_id,e.school_id
   ORDER BY e.cumulative_gpa desc";
        //exit;
        $query = $DB1->query($sql);
        //echo $DB1->last_query(); exit;
        if($this->session->userdata("role_id")==6){
     //echo $DB1->last_query(); exit;
        }
        $stream_details = $query->result_array();
        return $stream_details;
        }
    }


    function semester_for_all_topper_list($var,$exam_month, $exam_year,$exam_id){
        //echo '<pre>';print_r($var['admission_branch']);exit;
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select distinct semester from exam_result_master where exam_id = '".$exam_id."' and semester%2 = 0 and stream_id = '".$var['admission_branch']."' order by semester asc";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;

    }
	function stud_last_exam_details($list){
        $DB2 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * from exam_details where exam_master_id='".$list."'";
        $query = $DB2->query($sql);
        //echo $DB2->last_query();exit;
       return $query->result_array();

    }
	function stud_last_exam_details_phd($list){
        $DB2 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * from phd_exam_details where exam_master_id='".$list."'";
        $query = $DB2->query($sql);
        //echo $DB2->last_query();exit;
       return $query->result_array();

    }
	public function fetch_convocation_student_details()
	  {
		   $this->load->database();
		   $DB1 = $this->load->database('umsdb', TRUE);		   
		   $DB1->select('c.*');
		   $DB1->select('s.stream_name,s.course_short_name,s.school_short_name');
		   $DB1->select('sm.first_name,sm.middle_name,sm.last_name');
		   $DB1->from('convocation_registration c');
		   $DB1->join('student_master sm','sm.stud_id=c.student_id');
		   $DB1->join('vw_stream_details s','s.stream_id=c.stream_id');
		   $DB1->order_by('conv_id','DESC');
		   $query=$DB1->get();
		   //echo $DB1->last_query();
		  return $query->result_array();
	  }
}
?>