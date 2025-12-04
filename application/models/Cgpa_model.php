<?php

class Cgpa_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    } 
	
    function getStudentSubjectMarks($var,$exam_month,$exam_year, $exam_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $where=" WHERE 1=1 ";
        // echo $stud_id;exit;
        $sem = $var['semester'];
        $stream_id = $var['admission-branch'];
        
        if(!empty($var)){
            $where.=" AND sas.semester='".$sem."' and sas.stream_id='$stream_id' and sas.exam_id='".$exam_id."'";
        }
        
        $sql="SELECT sas.stud_id,sas.semester, vw.stream_name, vw.school_short_name, vw.stream_short_name, sas.enrollment_no, sas.subject_id, sm.subject_code1, subject_name, sm.subject_short_name,s.first_name, s.middle_name, s.last_name FROM `exam_applied_subjects` as sas
		left join subject_master sm on sm.sub_id=sas.subject_id
		left join student_master s on s.stud_id=sas.stud_id
        left join vw_stream_details as vw on vw.stream_id = sas.stream_id
		$where";
		$sql.=" order by sas.stud_id ";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
    }

    function fetch_result_data($result_data) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[2];
        $exam_month =$res_data[3];
        $exam_year =$res_data[4];
		$exam_id =$res_data[5];
        $where=" where sas.semester='".$semester."' AND sas.exam_month='$exam_month' AND sas.exam_year='$exam_year'and sas.stream_id='$stream_id' and sas.exam_id='$exam_id'";

        $sql="SELECT sas.subject_id FROM `exam_applied_subjects` as sas
        $where";
        $sql.=" group by sas.subject_id";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function fetch_theory_marks($subjectId, $stream, $semester, $exam_month, $exam_year)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT m.*, s.subject_code1 FROM marks_entry m left join subject_master s on s.sub_id=m.subject_id where m.subject_id='" . $subjectId . "' AND m.exam_month='" . $exam_month . "' AND m.exam_year='" . $exam_year . "' AND m.stream_id ='" . $stream . "' AND m.semester ='" . $semester . "'";           
        $sql .= " AND marks_type='TH'";
 
        $query = $DB1->query($sql);        
       // echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    function fetch_cia_marks($sub_id, $stream, $semester, $exam_month, $exam_year)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM marks_entry_cia where subject_id='".$sub_id."' AND exam_month='" . $exam_month . "' AND exam_year='" . $exam_year . "' AND stream_id ='" . $stream . "' AND semester ='" . $semester . "'";
    
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    function check_for_duplicate_marks($stud_id,$subject_id, $stream, $semester, $exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM exam_result_data where student_id ='$stud_id' and subject_id='".$subject_id."' AND exam_id='" . $exam_id . "' AND stream_id ='".$stream."' AND semester ='".$semester."'";
    
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
    }
    function check_for_duplicate_result($stream, $semester, $exam_month, $exam_year,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM exam_result_details where stream_id ='".$stream."' AND semester ='".$semester."' and exam_id='".$exam_id."'";
    
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    function get_result_stream_data($stream_id,$exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);
        $role_id = $this->session->userdata('role_id');
        $emp_id = $this->session->userdata("name");       
        $sql = "SELECT ed.stream_id, vw.stream_short_name, ed.semester,ed.ready_for_result, ed.result_regenerated, ed.result_generated,ed.is_verified,ed.res_detail_id FROM `exam_result_details` as ed left join vw_stream_details vw on vw.stream_id = ed.stream_id where ed.stream_id='".$stream_id."' AND ed.exam_id='".$exam_id."' ORDER BY ed.`semester` ASC ";        
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
    function fetch_result_data_for_grade($result_data) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];
		
        $where=" where sas.semester='".$semester."' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id'";

        $sql="SELECT distinct sas.student_id FROM `exam_result_data` as sas
        $where ";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }     
    function fetch_gread_rule($stream_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT grade_rule,grade_id FROM `stream_grade_criteria` where stream_id='$stream_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }   

    function fetch_grade($stud_f_mrks,$grd_rule) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `grade_policy_details` where $stud_f_mrks between min_range and max_range and rule='$grd_rule'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    function fetch_grade_pharma($stud_f_mrks,$grd_rule) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT * FROM `grade_policy_details_pharma` where $stud_f_mrks between min_range and max_range and rule='$grd_rule'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    function update_reslt_grade($subject,$semester,$stream,$exam_id,$stud_id, $data){
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $where = "subject_id='$subject' and semester='$semester' and stream_id='$stream' and exam_id='$exam_id' AND student_id='$stud_id'";
        $DB1->where($where);        
        $DB1->update('exam_result_data', $data);
        //echo $DB1->last_query();echo "<br>break";
        return true;
    }
    function fetch_reslt_subjects($result_data, $student_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];

        $sql="SELECT subject_id, final_garde_marks,subject_code,cia_marks,exam_marks,result_grade,final_grade FROM `exam_result_data` where semester='".$semester."' AND exam_id='$exam_id' and stream_id='$stream_id' and student_id='$student_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    // subject max marks  
    function fetch_subject_marks($subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);
        $sql="SELECT sub_max, theory_max FROM `subject_master` where sub_id='$subject_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    // chech for duplicate 
    function check_for_duplicate_result_entry($stud_id, $stream, $semester, $exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM exam_result_master where student_id ='$stud_id' AND exam_id='".$exam_id."' AND stream_id ='".$stream."' AND semester ='".$semester."'";
    
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;
        
        return $query->result_array();
    }
    // fetch subjects of semester
    function fetch_subjects_exam_semester($result_data,$batch) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		 $exam_id =$res_data[4];

        $sql="SELECT distinct e.subject_id, s.subject_code1,s.subject_code,s.subject_component,s.subject_name,s.subject_short_name,s.practical_min_for_pass,s.theory_max,s.theory_min_for_pass,s.internal_max,s.internal_min_for_pass,s.sub_min,s.sub_max,s.credits FROM `exam_result_data` e left join subject_master s on e.subject_id= s.sub_id where e.semester='".$semester."' and e.exam_id='$exam_id' AND e.stream_id='$stream_id' and s.batch='$batch' order by s.subject_order asc";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    // fetch student result data
    function fetch_studen_result_data($result_data,$batch) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);
        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];
		
        $where=" where sas.semester='".$semester."' AND  sas.stream_id='$stream_id' and sas.exam_id='$exam_id'";
        if($batch=='2018'){
			$where .=" and s.admission_session='$batch' and s.admission_year=1 ";
		}elseif($batch=='2017'){
			if($stream_id =='71' && $semester =='1'){
				$where .=" and s.admission_session='2017'";
			}else{
				$where .=" and s.current_year=2 ";
			}
		}else{
			$where .=" and s.current_year=3";
		}
        $sql="SELECT sas.*,s.first_name, s.middle_name, s.last_name,s.admission_session,s.current_semester,rm.sgpa,rm.grade_points_avg FROM `exam_result_data` as sas 
		left join exam_result_master rm on rm.student_id=sas.student_id and rm.exam_id=sas.exam_id and rm.semester =sas.semester
		left join student_master s on s.stud_id=sas.student_id
        $where group by sas.student_id";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // fetch students subject marks
    function fetch_stud_sub_marks($student_id, $subject_id, $exam_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        // $res_data = explode('~', $result_data);

        // $school_code  =$res_data[0];
        // $stream_id =$res_data[1];
        // $semester =$res_data[4];
        // $exam_month =$res_data[2];
        // $exam_year =$res_data[3];

        $sql="SELECT subject_id,practical_marks,cia_garde_marks,final_garde_marks,subject_code,cia_marks,exam_marks,result_grade,final_grade FROM `exam_result_data` where student_id='".$student_id."' AND subject_id='$subject_id' AND exam_id='$exam_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // fetch subject details
    function fetch_subject_details($subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        //$res_data = explode('~', $result_data);
        $sql="SELECT * FROM `subject_master` where sub_id='$subject_id' and is_active='Y'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    
    // fetch students from exam applied
    function fetch_students_from_exam_applied($result_data) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[2];
        $exam_month =$res_data[3];
        $exam_year =$res_data[4];
		$exam_id =$res_data[5];

        $where=" where sas.semester='".$semester."' AND sas.stream_id='$stream_id' and sas.exam_id='".$exam_id."'";

        $sql="SELECT sas.stud_id FROM `exam_applied_subjects` as sas
        $where";
        $sql.=" group by sas.stud_id";
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // fetch exam appled student subjects
    function fetch_stud_exam_applied_subjects($result_data, $student_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[2];
        $exam_month =$res_data[3];
        $exam_year =$res_data[4];
		$exam_id =$res_data[5];
		
        $where=" where semester='".$semester."' AND exam_month='$exam_month' AND exam_year='$exam_year'and stream_id='$stream_id' and exam_id='$exam_id' and stud_id='$student_id'";

        $sql="SELECT subject_id FROM `exam_applied_subjects`
        $where";
        
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }  
    // fetch theory marks for result generation
    function fetch_theory_marks_for_result($student_id, $subjectId, $stream, $semester, $exam_month, $exam_year)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT m.*, s.subject_code as subject_code1 FROM marks_entry m left join subject_master s on s.sub_id=m.subject_id where m.subject_id='" . $subjectId . "' AND m.exam_month='" . $exam_month . "' AND m.exam_year='" . $exam_year . "' AND m.stream_id ='" . $stream . "' AND m.semester ='" . $semester . "' and stud_id='$student_id'";           
        //$sql .= " AND marks_type='TH'";
 
        $query = $DB1->query($sql);        
        
        return $query->result_array();
        
    }
    // fetch cia marks for result generation
    function fetch_cia_marks_for_result($student_id,$sub_id, $stream, $semester, $exam_month, $exam_year)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM marks_entry_cia where subject_id='".$sub_id."' AND exam_month='" . $exam_month . "' AND exam_year='" . $exam_year . "' AND stream_id ='" . $stream . "' AND semester ='" . $semester . "' and stud_id='$student_id'";
    
        $query = $DB1->query($sql);
        return $query->result_array();
        
    } 
    // update result grades
    function update_resltsubject_grace($subject,$semester,$stream,$exam_id,$stud_id, $data){
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $where = "subject_id='$subject' and semester='$semester' and stream_id='$stream' and exam_id='$exam_id' AND student_id='$stud_id'";
        $DB1->where($where);        
        $DB1->update('exam_result_data', $data);
        return true;
    } 
    // update forworded marks
    function update_mrks_forwarded($subject,$semester,$stream,$exam_month,$exam_year,$stud_id, $data){
        $DB1 = $this->load->database('umsdb', TRUE);
        $where = "subject_id='$subject' and semester='$semester' and stream_id='$stream' and exam_month='$exam_month' and exam_year='$exam_year' AND student_id='$stud_id'";
        $DB1->where($where);        
        $DB1->update('exam_result_data', $data);
		//echo $DB1->last_query();exit;
        return true;
    } 
	//getresltSchools
	 function getresltSchools(){
        $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT erm.school_code, vw.school_short_name FROM exam_details erm left join vw_stream_details vw on vw.stream_id = erm.stream_id";	
		$query = $DB1->query($sql);
		return $query->result_array();
    } 
	// fetch exam streams
	function load_resultstreams($course_id, $exam_session){
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam = explode('-', $exam_session);
		$exam_id= $exam[2];
		$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name from exam_result_master ed left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id where vsd.course_id='".$course_id."' and ed.exam_id='$exam_id'";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	// fetch result strams
	function load_resultsemesters($stream_id, $exam_session){
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam = explode('-', $exam_session);
		$exam_id= $exam[2];
		$sql = "select distinct semester from exam_result_master  where stream_id='".$stream_id."' and exam_id='$exam_id' order by semester asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// fetch result student
	function list_result_students($var,$exam_month, $exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$stream_id = $var['admission-branch'];
		$semester = $var['semester'];
		//$sql = "select distinct erm.student_id as stud_id,s.enrollment_no,UPPER(CONCAT(s.last_name,' ',s.first_name,' ',s.middle_name)) as stud_name,erm.semester from exam_result_data as erm  
		//left join student_master s on s.stud_id = erm.student_id
		//where stream_id='".$stream_id."' and exam_id='".$exam_id."' and semester ='".$semester."' order by erm.student_id asc";
		
		
		 $sql = "SELECT DISTINCT TRUNCATE(e.ecumulative_gpa,2) AS `cumulative_gpa`, b.checb,erm.student_id AS stud_id,s.enrollment_no,
UPPER(CONCAT(s.last_name,' ',s.first_name,' ',s.middle_name)) AS stud_name,erm.semester,vw.stream_name,vw.school_short_name,vw.course_short_name,vw.stream_name,
CASE
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 9.0 AND b.checb=0) THEN 'Honours' 
    WHEN (TRUNCATE(e.ecumulative_gpa,2) >= 7.5 AND b.checb=0) THEN 'Distinction' 
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 6.0 THEN 'First Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 5.5 AND TRUNCATE(e.ecumulative_gpa,1) <= 6.0 THEN 'Second Class'
    WHEN TRUNCATE(e.ecumulative_gpa,2) >= 5.0  THEN 'Third Class'
END AS Result 

FROM exam_result_data AS erm  

INNER JOIN student_master s ON s.stud_id = erm.student_id AND s.admission_session>='".$var['regulation']."'
INNER JOIN vw_stream_details vw ON vw.stream_id = erm.stream_id

INNER JOIN (SELECT student_id AS bstudent_id,enrollment_no AS benrollment_no,stream_id AS bstream_id,semester AS bsemester,
exam_id AS bexam_id,
subject_id AS bsubject_id,SUM(CASE WHEN final_grade='U' 
 THEN 1 ELSE 0 END) AS checb FROM exam_result_data 
WHERE  stream_id='$stream_id' AND school_id='".$var['school_code']."' AND semester <='$semester'  GROUP BY student_id) AS b 
ON b.bstudent_id=erm.student_id 
		
INNER JOIN (SELECT (cumulative_gpa) AS ecumulative_gpa,semester, student_id AS estudent_id,enrollment_no AS eenrollment_no
FROM exam_result_master WHERE stream_id='$stream_id' AND school_id='".$var['school_code']."' AND  exam_id='$exam_id' AND semester ='$semester'  GROUP BY student_id ) AS e ON e.estudent_id=erm.student_id 
		
WHERE erm.school_id='".$var['school_code']."' AND erm.stream_id='$stream_id' AND erm.exam_id='$exam_id' AND erm.semester ='$semester' ORDER BY erm.student_id ASC";
		
		
		
		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	
	//added by jugal
	function fetch_student_grades($stud,$exam_id)
	{
	$DB1 = $this->load->database('umsdb', TRUE);
	$DB1->select('*');
    $DB1->from('exam_result_master');
     $DB1->where('student_id',$stud);
    $DB1->where('exam_id',$exam_id);
    
       $DB1->order_by('semester');
    	$query=$DB1->get();
		$result=$query->result_array();
	foreach($result as $result1)
	{
	    $sem = $result1['semester'];
	   $arr[$sem]= $result1;
	}

		return $arr;

	}
	
	//
	//fetch_student_grade_details
	
	
	function fetch_student_grade_details($stud, $stream_id,$semester,$exam_id)
	{
	   // $this->fetch_student_grades($stud,$exam_id);
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct(s.enrollment_no),s.stud_id, UPPER(CONCAT(s.last_name,' ',s.first_name,' ',s.middle_name)) as stud_name, s.gender,s.dob,s.admission_session,s.admission_stream,s.current_semester,s.mother_name,s.middle_name,vw.stream_name, vw.stream_short_name,vw.school_name,vw.specialization,vw.gradesheet_name, erd.attendance_grade, erd.exam_month,erd.exam_year,    erd.semester,erd.stream_id,erd.exam_id,sm.subject_code,sm.sub_id,sm.subject_component,sm.credits,sm.subject_category,sm.subject_name,erm.credits_registered,erm.credits_earned,erm.grade_points_earned,erm.grade_points_avg, erm.cumulative_credits,erm.cumulative_gpa,erm.sgpa,erm.markscard_issued, erd.final_grade, erd.cia_marks, erd.exam_marks, erd.final_garde_marks 
		from exam_result_data as erd 
		left join student_master as s on s.stud_id =erd.student_id
		left join subject_master sm on sm.sub_id =erd.subject_id
		left join exam_result_master erm on erm.student_id =erd.student_id and erd.exam_id= erm.exam_id	AND erm.semester=erd.semester
		left join vw_stream_details vw on vw.stream_id =erd.stream_id
		where erd.exam_id='".$exam_id."' AND erd.student_id='".$stud."' and erd.is_deleted='N' ";
		if($stream_id =='106' || $stream_id =='105'){
		
		}else{
			$sql .= " AND erd.stream_id='".$stream_id."' ";
		}
		
		$sql .= " order by s.enrollment_no,erd.semester, sm.subject_order asc";
	//	where erd.stream_id='".$stream_id."' AND erd.semester='".$semester."' AND erd.exam_id='".$exam_id."' AND erd.student_id='".$stud."' order by s.enrollment_no, sm.subject_order asc";
	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		
	$stream_details[0]['grades']= $this->fetch_student_grades($stud,$exam_id);
		return $stream_details;
	}
	//
		//fetch_student_exam_unique_id
	function fetch_student_exam_unique_id($stud, $stream_id,$semester,$exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT `exam_master_id`,enrollment_no FROM `exam_details` WHERE `stud_id`='".$stud."' and `stream_id`='".$stream_id."' and `semester`='".$semester."' and `exam_id`='".$exam_id."'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// fetch exam details streams
	function load_edstreams($course_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name from exam_details ed left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id where vsd.course_id='".$course_id."'  and ed.exam_id='$exam_id' ";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	// fetch exam details semester
	function load_edsemesters($stream_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct semester from exam_details  where stream_id='".$stream_id."' and exam_id='$exam_id' order by semester asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	// fetch exam details course
	function get_edcourses($school_code, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select v.course_id, v.course_name, v.course_short_name from (select DISTINCT stream_id from exam_details where exam_id='$exam_id') as e left join vw_stream_details as v on v.stream_id= e.stream_id  where v.school_code='$school_code' group by v.course_id  order by v.course_name asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	// fetching for comparing TH/PR max marks while grade generation
	function fetch_max_marks_thpr($stream,$exam_id,$semester,$subject)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT max_marks FROM `marks_entry_master` where subject_id='".$subject."' and semester='".$semester."' and exam_id='".$exam_id."' and marks_type in('PR','TH') ";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	// fetching for comparing cia max marks while grade generation 
    function fetch_max_marks_cia($stream,$exam_id,$semester,$subject)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT max_marks FROM `marks_entry_master` where subject_id='".$subject."' and semester='".$semester."' and exam_id='".$exam_id."' and marks_type ='CIA' ";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	//fetch_subject_marks_status
    function fetch_subject_marks_status($stream,$exam_id,$semester,$stud_id)
    {      
        $DB1 = $this->load->database('umsdb', TRUE);
        $where = " WHERE sb.is_active='Y'";
        $where .= " AND s.stream_id='" . $stream . "' AND s.exam_id ='$exam_id' AND s.semester='$semester' and s.stud_id='$stud_id' ";   
        $sql = "SELECT s.subject_id, CASE WHEN sb.theory_max=0 THEN 'N' ELSE 'Y' END AS th_status, CASE WHEN sb.internal_max=0 THEN 'N' ELSE 'Y' END AS cia_status, sb.internal_max, sb.theory_max FROM exam_applied_subjects as s LEFT JOIN subject_master sb ON sb.sub_id= s.subject_id $where group by s.subject_id";     
        $query = $DB1->query($sql);   
       // echo $DB1->last_query();exit;   
        return $query->result_array();
        
    } 	
    function get_cia_and_thmarks_details($stud_id, $sub_id, $stream, $semester, $exam_id)
    {
        
        $DB1 = $this->load->database('umsdb', TRUE);
        
        $sql = "SELECT s.enrollment_no,s.stream_id,s.semester,s.subject_id,s.subject_code ,c.cia_marks,c.attendance_marks,m.marks,s.stud_id,s.exam_month,s.exam_year,
sb.theory_max,sb.theory_min_for_pass,sb.internal_max,sb.internal_min_for_pass,sb.sub_min,sb.sub_max
FROM exam_applied_subjects  s 
LEFT JOIN marks_entry_cia c ON c.stud_id=s.stud_id AND s.subject_id=c.subject_id AND c.exam_id=s.exam_id
LEFT JOIN marks_entry m ON m.stud_id=s.stud_id AND s.subject_id=m.subject_id AND s.exam_id=m.exam_id
LEFT JOIN subject_master sb ON sb.sub_id=s.subject_id
WHERE s.exam_id='$exam_id' AND s.stream_id='$stream' AND s.semester='$semester' and s.subject_id='$sub_id' and s.stud_id='$stud_id'";
        
        $query = $DB1->query($sql);
        
        //echo $DB1->last_query();exit;
        
        return $query->result_array();
        
    }
    
    function get_result_program_analysis($row){
    
       $DB1 = $this->load->database('umsdb', TRUE);
      
       if($row['school_code']!="0"){
           $where.=" where  a.school_code='".$row['school_code']."'";
       }
       if($row['course_id']!="0"){
           $where.=" and a.course_id='".$row['course_id']."'";
       }
       $sql="
	            SELECT a.exam_name,a.school_code,a.course_id,a.stream_short_name,a.semester,COUNT(a.student_id)AS appeared,
                SUM(CASE WHEN a.fail=1 THEN 1 ELSE 0 END)AS sub1,
                SUM(CASE WHEN a.fail=2 THEN 1 ELSE 0 END)AS sub2,
                SUM(CASE WHEN a.fail=3 THEN 1 ELSE 0 END)AS sub3,
                SUM(CASE WHEN a.fail=4 THEN 1 ELSE 0 END)AS sub4,
                SUM(CASE WHEN a.fail=5 THEN 1 ELSE 0 END)AS sub5,
                SUM(CASE WHEN a.fail=6 THEN 1 ELSE 0 END)AS sub6,
                SUM(CASE WHEN a.fail=7 THEN 1 ELSE 0 END)AS sub7,
                SUM(CASE WHEN a.fail=8 THEN 1 ELSE 0 END)AS sub8,
                SUM(CASE WHEN a.fail=9 THEN 1 ELSE 0 END)AS sub9,
                SUM(CASE WHEN a.fail=10 THEN 1 ELSE 0 END)AS sub10,
                SUM(CASE WHEN a.fail=11 THEN 1 ELSE 0 END)AS sub11,
                SUM(CASE WHEN a.withheald=0 THEN 0 ELSE 1 END)AS with_heald,
                SUM(CASE WHEN a.not_done=0 THEN 0 ELSE 1 END)AS not_done,
                SUM(CASE WHEN a.pass=a.sub_total THEN 1 ELSE 0 END)AS all_clear
                FROM (
                SELECT e.exam_name,st.stream_short_name,st.course_id,st.school_code,s.semester,s.student_id,COUNT( s.student_id)AS sub_total,
                SUM(s.is_fail)AS fail,SUM(s.is_withHeld)AS withheald,SUM(s.is_clear)AS pass,SUM(s.is_not_done)AS not_done
                 FROM (
                SELECT student_id,exam_id,stream_id,semester,subject_id,final_grade,
                CASE WHEN final_grade='U' THEN 1 ELSE 0 END AS is_fail,
                CASE WHEN malpractice='Y' THEN 1 ELSE 0 END AS is_withHeld,
                CASE WHEN final_grade NOT IN ('WH','U') THEN 1 ELSE 0 END AS is_clear,
                CASE WHEN final_grade IS NULL THEN 1 ELSE 0 END AS is_not_done
                FROM exam_result_data WHERE exam_id='".$row['exam_session']."' 
                ) s 
                LEFT JOIN vw_stream_details st ON st.stream_id=s.stream_id
                LEFT JOIN exam_session e ON s.exam_id=e.exam_id
                GROUP BY st.stream_short_name,s.semester,s.student_id
                ) a  $where GROUP BY a.stream_short_name,a.semester
                ORDER BY a.semester,a.stream_short_name";
              //  echo $sql ;exit();
	         $query =	$DB1->query($sql);
               $result=$query->result_array();  
            //	echo $DB1->last_query(); exit();
             return $result;
}
    function get_result_course_analysis($row){
    
       $DB1 = $this->load->database('umsdb', TRUE);
      
       if($row['school_code']!="0"){
           $where.=" where  st.school_code='".$row['school_code']."'";
       }
       if($row['course_id']!="0"){
           $where.=" and st.course_id='".$row['course_id']."'";
       }
       $sql="
	            
                SELECT e.exam_name,st.stream_short_name,st.course_id,st.school_code,s.semester,s.subject_id,sb.subject_code,sb.subject_name,sb.subject_order,COUNT( s.student_id)AS sub_total,
                SUM(s.is_fail)AS fail,SUM(s.is_withHeld)AS withheald,SUM(s.is_clear)AS pass,SUM(s.is_not_done)AS not_done
                 FROM (
                SELECT student_id,exam_id,stream_id,semester,subject_id,final_grade,
                CASE WHEN final_grade='U' THEN 1 ELSE 0 END AS is_fail,
                CASE WHEN malpractice='Y' THEN 1 ELSE 0 END AS is_withHeld,
                CASE WHEN final_grade NOT IN ('WH','U') THEN 1 ELSE 0 END AS is_clear,
                CASE WHEN final_grade IS NULL THEN 1 ELSE 0 END AS is_not_done
                FROM exam_result_data WHERE exam_id='".$row['exam_session']."' 
                ) s 
                 LEFT JOIN vw_stream_details st ON st.stream_id=s.stream_id
            LEFT JOIN exam_session e ON s.exam_id=e.exam_id
            LEFT JOIN subject_master sb ON sb.sub_id=s.subject_id
            $where
            GROUP BY st.stream_short_name,s.semester,s.subject_id
           
            ORDER BY st.stream_short_name,s.semester,s.subject_id,sb.subject_order ";
              //echo $sql ;exit();
	         $query =	$DB1->query($sql);
               $result=$query->result_array();  
            //	echo $DB1->last_query(); exit();
             return $result;
}
	// fetch grade details    
    function list_grade_details($rule)
    {       
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT distinct `grade_letter`,grade_point,performance FROM `grade_policy_details` where rule='$rule' order by policy_id";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
        
    }
	function list_grade_pharma_details($rule)
    {       
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT distinct `grade_letter`,grade_point,performance FROM `grade_policy_details_pharma` where rule='$rule' order by policy_id";     
        $query = $DB1->query($sql);    
        //echo $DB1->last_query();exit;       
        return $query->result_array();
        
    }
   // student backlog subject list
    function getStudbacklogSubject($stud_id){
        $DB1 = $this->load->database('umsdb', TRUE);  
        $where=" WHERE 1=1 ";  
        
        if($stud_id!=""){
            $where.=" AND erd.student_id='".$stud_id."' AND erd.passed ='N'";
        }       
        $sql="SELECT erd.student_id, sm.subject_name, sm.sub_id, sm.subject_code,sm.semester,erd.exam_id FROM `exam_student_subject` as erd left join subject_master sm on sm.sub_id=erd.subject_id $where";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }  

    // get_arrear_subject_list 
    function get_arrear_subject_list($stream_id,$batch, $exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);       
        $sql="SELECT distinct d.subject_id,ess.semester,sm.subject_name, sm.sub_id,sm.batch, sm.subject_code FROM exam_details ess 
left join `exam_student_subject` as d on d.semester=ess.semester and d.stream_id=ess.stream_id and ess.stud_id=d.student_id
left join subject_master sm on sm.sub_id=d.subject_id
WHERE ess.`stream_id` = '$stream_id' AND d.`passed` = 'N'";  //and ess.exam_id='$exam_id' //d.exam_id=ess.exam_id and
		if($batch!="0"){
            $sql.=" AND sm.batch='".$batch."'";
        }  
		 $sql.=" ORDER BY ess.semester,sm.subject_order";
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // student backlog subject list
    function stud_arrear_sub_applied_list($stream_id,$subject_id, $exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);       
        $sql="SELECT distinct ess.`student_id`, ess.enrollment_no, ess.`semester` FROM `exam_student_subject` as ess 
        left join exam_details d on d.stud_id=ess.student_id and d.semester=ess.semester and d.stream_id=ess.stream_id
        WHERE ess.`stream_id` = '$stream_id' AND ess.`passed` = 'N' and ess.subject_id='$subject_id' ORDER BY ess.`enrollment_no` asc"; //d.exam_id=ess.exam_id and
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    // get_arrear_student_list 
    function get_arrear_student_list($stream_id,$batch,$exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);       
        $sql="SELECT distinct ess.student_id,s.enrollment_no,UPPER(CONCAT(s.first_name,' ',s.middle_name,' ',s.last_name)) as stud_name FROM `exam_student_subject` as ess 
		left join exam_details d on d.exam_id=ess.exam_id and d.stud_id=ess.student_id and d.semester=ess.semester and d.stream_id=ess.stream_id 
		left join student_master s on s.stud_id=ess.student_id 
		left join subject_master sm on sm.sub_id=ess.subject_id
		WHERE ess.`passed` = 'N' and s.cancelled_admission='N' ";//and d.exam_id='$exam_id' 
		if($stream_id !=0){
            $sql .=" and ess.stream_id='$stream_id'";
        } 
		if($batch!="0"){
            $sql.=" AND sm.batch='".$batch."'";
        }  		
        $sql .=" ORDER BY s.enrollment_no"; 
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // student backlog subject list
    function stud_arrear_subject_list($stream_id,$student_id,$batch,$exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);       
        $sql="SELECT distinct d.subject_id,ess.semester,sm.subject_name, sm.sub_id, sm.subject_code FROM exam_details ess 
left join `exam_student_subject` as d on d.semester=ess.semester and d.stream_id=ess.stream_id and ess.stud_id=d.student_id
left join subject_master sm on sm.sub_id=d.subject_id
WHERE d.`passed` = 'N' and ess.stud_id='$student_id' ";//and ess.exam_id='$exam_id'd.exam_id=ess.exam_id and 
		if($stream_id !=0){
            $sql .=" and ess.stream_id='$stream_id'";
        }  
		if($batch!="0"){
            $sql.=" AND sm.batch='".$batch."'";
        }  
		
        $sql .=" ORDER BY ess.semester,sm.subject_order"; 
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	// get_arrear_stream_list 
    function get_arrear_stream_list($school_code,$course_id,$stream_id, $exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);  
        $sql="SELECT distinct d.stream_id, v.stream_name FROM exam_details ess left join `exam_student_subject` as d on d.exam_id=ess.exam_id and d.semester=ess.semester and d.stream_id=ess.stream_id and ess.stud_id=d.student_id LEFT JOIN vw_stream_details v on v.stream_id=ess.stream_id WHERE d.`passed` = 'N'"; // and ess.exam_id='$exam_id'
		if($school_code !=0){
            $sql .=" and ess.school_code='$school_code'";
        }		
		if($course_id !=0){
            $sql .=" and ess.course_id='$course_id'";
        } 
        if($stream_id !=0){
            $sql .=" and ess.stream_id='$stream_id'";
        }  
        $sql .=" ORDER BY v.stream_name";     
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
//fetch_arrear_students
    function fetch_arrear_students($stream_id, $subject_id, $exam_id){
		//echo $subject_id;
        $DB1 = $this->load->database('umsdb', TRUE);       
        $sql="SELECT distinct ess.student_id,ess.semester,s.enrollment_no,UPPER(CONCAT(s.first_name,' ',s.middle_name,' ',s.last_name)) as stud_name FROM `exam_student_subject` as ess left join exam_details d on d.exam_id=ess.exam_id and d.stud_id=ess.student_id and d.semester=ess.semester and d.stream_id=ess.stream_id left join student_master s on s.stud_id=ess.student_id WHERE ess.`subject_id` = '$subject_id' AND ess.`passed` = 'N' and s.cancelled_admission='N' ";// and d.exam_id='$exam_id' 
		if($stream_id !=0){
            $sql .=" and ess.stream_id='$stream_id'";
        }  
        $sql .=" ORDER BY s.enrollment_no"; 
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	//save_gradesheet_log
	function save_gradesheet_log($gd_log){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$DB1->insert('gradesheet_log', $gd_log);
		//echo $DB1->last_query();exit;
		return true;
	}
	//marks card allocation starts
	function list_result_students_for_markcards($var,$exam_month, $exam_year,$exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);
        $stream_id = $var['admission-branch'];
        $semester = $var['semester'];
        $sql = "select distinct erm.student_id,s.enrollment_no,UPPER(CONCAT(s.last_name,' ',s.first_name,' ',s.middle_name)) as stud_name,erm.semester,m.markscard_no from exam_result_master as erm  
        left join student_master s on s.stud_id = erm.student_id
        left join (SELECT student_id, markscard_no FROM exam_markscard_details where is_active='Y' and exam_id='".$exam_id."') m ON m.student_id = erm.student_id 
        where erm.stream_id='".$stream_id."' and erm.semester ='".$semester."' and erm.exam_id ='".$exam_id."' and s.cancelled_admission='N' order by erm.student_id asc";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }	
	function CheckStudIn($stud_id,$exam_id, $stream, $semester)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select student_id from exam_markscard_details  where student_id ='".$stud_id."' and exam_id='".$exam_id."' and semester='".$semester."' and stream_id='".$stream."'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $res = $query->result_array();
        return $res;
    }

    function updateMarksCardsNo($stud,$exam_id, $stream, $semester,$markscardno)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $where = "semester='$semester' and stream_id='$stream' and exam_id='$exam_id' AND student_id='$stud'";
        $DB1->where($where);   
        $data =array(
            "is_active" => 'N',
            "modified_by" => $this->session->userdata("uid"),
            "modified_ip" => $_SERVER['REMOTE_ADDR'],
            "modified_on" => date("Y-m-d H:i:s")
        );    
        $DB1->update('exam_markscard_details', $data);
        //echo $DB1->last_query();exit;
        return true;
    }  
    //
     function list_result_students_for_dispatch($stream_id, $semester,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select s.enrollment_no,UPPER(CONCAT(s.first_name,'   ',s.middle_name,'  ',s.last_name)) as stud_name,e.markscard_no  from exam_markscard_details e 
        left join student_master s on s.stud_id = e.student_id
        where e.exam_id='".$exam_id."' and e.semester='".$semester."' and e.stream_id='".$stream_id."' and e.is_active='Y' group by e.student_id";

        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $res = $query->result_array();
        return $res;
    }		
	///////////////////////////////////////////////////////////////
	function fetch_thobtained_marks($result_data, $student_id,$subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];

        $sql="SELECT subject_id, marks FROM `marks_entry` where semester='".$semester."' AND exam_id='$exam_id' AND stream_id='$stream_id' and stud_id='$student_id' and marks_type='PR' and subject_id='$subject_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_probtained_marks($result_data, $student_id,$subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];

        $sql="SELECT subject_id, marks FROM `marks_entry` where semester='".$semester."' AND exam_id='$exam_id' and stream_id='$stream_id' and stud_id='$student_id' and marks_type='TH' and subject_id='$subject_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_ciaobtained_marks($result_data, $student_id,$subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $res_data = explode('~', $result_data);

        $school_code  =$res_data[0];
        $stream_id =$res_data[1];
        $semester =$res_data[5];
        $exam_month =$res_data[2];
        $exam_year =$res_data[3];
		$exam_id =$res_data[4];

        $sql="SELECT subject_id, cia_marks,attendance_marks FROM `marks_entry_cia` where semester='".$semester."' AND exam_id='$exam_id' and stream_id='$stream_id' and stud_id='$student_id' and subject_id='$subject_id'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_max_marks_theory($stream,$exam_id,$semester,$subject)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT max_marks FROM `marks_entry_master` where subject_id='".$subject."' and semester='".$semester."' and exam_id='".$exam_id."' and marks_type in('TH') ";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	function fetch_max_marks_practcal($stream,$exam_id,$semester,$subject)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT max_marks FROM `marks_entry_master` where subject_id='".$subject."' and semester='".$semester."' and exam_id='".$exam_id."' and marks_type in('PR') ";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    }
	// fetching result session
	function fetch_result_exam_session()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('exam_session');
		$DB1->where("active_for_result", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	// fetching with-held results
	function fetch_withheld_result($exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT e.enrollment_no,e.with_held,UPPER(CONCAT(s.first_name,'   ',s.middle_name,'  ',s.last_name)) as stud_name,v.stream_name,e.semester FROM `exam_result_data` e
		left join student_master s on s.stud_id = e.student_id 
		LEFT JOIN vw_stream_details v on v.stream_id=e.stream_id 
		where e.exam_id ='$exam_id' and e.with_held='Y' group by e.enrollment_no order by e.stream_id,e.semester ";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
	}
//
    function update_withheld_result($data,$exam_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		$str_prn = implode(',', $data['chk_stud']);
		//print_r($data);
		//echo $str_prn;exit;
		$exam_id=$data['exam_id'];
		$sql = "UPDATE `exam_result_data` SET final_grade=result_grade,with_held='N' WHERE exam_id ='$exam_id' and enrollment_no IN($str_prn)";
        $query = $DB1->query($sql);
        return true;
    }
/////////////////////////////////////////////////	
	function update_failed_sub_type($stud, $subject_id,$exam_id,$res_fail)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
        $where = "subject_id='$subject_id' and exam_id='$exam_id' AND student_id='$stud'";
        $DB1->where($where);   
        $data =array(
            "failed_sub_type" => $res_fail,
            "modify_by" => $this->session->userdata("uid"),
            "modify_on" => date("Y-m-d H:i:s")
        );    
        $DB1->update('exam_student_subject', $data);
        //echo $DB1->last_query();exit;
        return true;
	}
	//	
	function get_failed_sub_type1($stud, $subject_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT failed_sub_type, grade FROM `exam_student_subject` where subject_id='$subject_id' and exam_id='9' AND student_id='$stud'";
        $query = $DB1->query($sql);
       //echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
        return $stream_details;
    } 
    // subject max marks  
    function fetchsubject_details($subject_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT sub_max, theory_max,theory_min_for_pass,internal_max,internal_min_for_pass,practical_max,practical_min_for_pass,sub_min FROM `subject_master` where sub_id='$subject_id' and is_active='Y'";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
	function fetch_with_held_exam_session($exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$sql="SELECT e.exam_month,e.exam_year,e.exam_id,e.exam_type FROM `exam_result_data`es LEFT JOIN exam_session e ON es.exam_id=e.exam_id WHERE es.with_held='Y' AND es.final_grade='WH' GROUP BY es.exam_id";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit
		
		 return $query->result_array();
	}	
	function fetch_backlog_semesters($prn){
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$sql="SELECT semester from exam_student_subject WHERE passed='N' and enrollment_no='$prn' group by semester";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit
		 return $query->result_array();
	}
	function fetch_student_result_dpharma($stud, $stream_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$sql="SELECT semester,stream_id,student_id from exam_result_data WHERE student_id='$stud'"; 
		if($exam_id==7 || $exam_id==8){
			$sql .=" and semester=1";
		}
		$sql .=" group by semester";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
		return $res = $query->result_array();
		
	}
	function fetchDpharmaresult_details($stud, $stream_id,$semester, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$sql="SELECT s.theory_max,s.internal_max,e.*  FROM exam_result_data e
LEFT JOIN subject_master s ON s.sub_id=e.subject_id
 WHERE e.student_id='$stud' AND e.semester='$semester' and e.stream_id='$stream_id'";
		if($exam_id){
			$sql .=" and e.exam_id <= $exam_id";
		}
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
		return $res = $query->result_array();		
	}
	function fetchDpharmaresult_grades($stud, $stream_id,$semester, $exam_id){
		//echo $exam_id;exit;
		$DB1 = $this->load->database('umsdb', TRUE);	
		if($semester==1 && $exam_id=='8'){
			 $sql="SELECT grade as final_grade  FROM exam_student_subject e WHERE e.student_id='$stud' AND e.semester='$semester' and e.stream_id='$stream_id' and passed='N' and exam_id='$exam_id' ";
		}else{
			 $sql="SELECT final_grade  FROM exam_result_data e WHERE e.student_id='$stud' AND e.semester='$semester' and e.stream_id='$stream_id' and exam_id='$exam_id' ";
		}
		//exit;
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
		$res = $query->result_array();
		foreach($res as $rs){
			$f_grade[] = $rs['final_grade'];
		}
		return	$f_grade;	
	}
	
	// fetch defarma no of attempt
	function fetchDpharma_no_of_attempt($stud, $stream_id,$semester,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql="SELECT enrollment_no,subject_id,exam_id,COUNT(subject_id) AS no_of_attempt FROM exam_result_data e WHERE e.student_id='$stud' AND e.semester='$semester' and e.stream_id='$stream_id' and exam_id <='$exam_id' GROUP BY enrollment_no,subject_id HAVING COUNT(subject_id) >1";
		//exit;
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
		$res = $query->result_array();
		return	$res;	
	}
	// fetch defarma no of backlogs
	function fetchDpharma_no_of_bklogs($stud, $stream_id,$semester,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql="SELECT enrollment_no,subject_id FROM exam_result_data WHERE stream_id='$stream_id' AND semester='$semester' AND final_grade='U' and student_id='$stud' and exam_id <='$exam_id'  GROUP BY enrollment_no,subject_id ";
		//exit;
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
		$res = $query->result_array();
		return	$res;	
	}
	///////////////////////////Attendance grade updation/////////////////////////////////////////
	   function get_examresult_data($exam_id) {

        $DB1 = $this->load->database('umsdb', TRUE);
        $sql="SELECT  e.enrollment_no,e.result_id,e.subject_code,e.subject_id, c.attendance_marks,e.attendance_grade 
FROM marks_entry_cia c
LEFT JOIN exam_result_data e ON e.subject_id=c.subject_id AND e.semester=c.semester AND e.enrollment_no=c.enrollment_no and e.exam_id=c.exam_id
WHERE e.exam_id='$exam_id' GROUP BY c.enrollment_no, c.subject_id 
";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();exit;
        return $query->result_array();
    } 
    function update_attendance_grade($stud,$exam_id)
    {
    	//print_r($stud);
		if($stud['attendance_marks'] >= 95){
			$att_grade='O';
		}
		if($stud['attendance_marks'] >= 85 && $stud['attendance_marks'] < 95){
			$att_grade='M';
		}
		if($stud['attendance_marks'] < 85){
			$att_grade='S';
		}
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql2="update `exam_result_data` set attendance_grade='$att_grade' WHERE `result_id` ='".$stud['result_id']."' and exam_id='$exam_id' and subject_id='".$stud['subject_id']."'";
        $query2 = $DB1->query($sql2);
       // unset();
        return true;
    }	
}
?>