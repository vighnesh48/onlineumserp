<?php
class Academic_reports_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
    }
    
	
	// fetch student list
	function fetch_timetable_entry($data)
    {
		//error_reporting(E_ALL);
		if($data["campus"]==2){
			$DB1 = $this->load->database('sjumsdb', TRUE); 
		}elseif($data["campus"]==3){
			$DB1 = $this->load->database('sfumsdb', TRUE); 
		}else{
			$DB1 = $this->load->database('umsdb', TRUE); 
		}
        
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$acd_yr = explode('~',$data['academic_year']);
		$curr_session = $acd_yr[1];
		$academicyear = explode('-',$acd_yr[0]);
		$school_code=$data["school_code"];
		$course_id=$data["admission-course"];
		$stream=$data["admission-branch"];
		$semester=$data["semester"];
		if($curr_session=='SUMMER'){
			$cursession = 'SUM';
			$wher=" and current_semester not in ('1','3','5','7','9')";
		}else{
			$cursession = 'WIN';
			$wher="and current_semester not in ('4','6','8','10')";
		}
		
			/* $sql = "SELECT a.*,t.stream_id,t.semester,v.stream_name,v.school_name, (CASE WHEN t.stream_id=admission_stream THEN 'Done' ELSE 'Not done' END) AS entry_status FROM (SELECT DISTINCT admission_stream,current_semester
 FROM student_master WHERE `cancelled_admission`='N' and admission_confirm='Y' AND academic_year='$academicyear[0]' $wher   and enrollment_no !='' and (admission_cycle  is null or admission_cycle='' ) ORDER BY admission_stream, current_semester) a
LEFT JOIN (SELECT DISTINCT stream_id,semester FROM `lecture_time_table` WHERE `academic_year`='$acd_yr[0]' AND `academic_session`='$cursession'
) t ON t.`stream_id` =a.admission_stream AND t.semester=a.current_semester
LEFT JOIN vw_stream_details v ON v.stream_id=a.admission_stream where 1"; */


$sql ="SELECT 
    a.admission_stream,
    a.current_semester,
    v.stream_name,
    v.school_name
FROM
    (
        SELECT DISTINCT
            admission_stream, current_semester
        FROM
            student_master
        WHERE
            cancelled_admission = 'N'
            #AND admission_confirm = 'Y'
            AND academic_year = '$academicyear[0]'
            $wher
            AND enrollment_no != ''
            AND (admission_cycle IS NULL OR admission_cycle = '')
    ) a
LEFT JOIN
    (
        SELECT DISTINCT
            stream_id, semester
        FROM
            lecture_time_table
        WHERE
            academic_year = '$acd_yr[0]'
            AND academic_session = '$cursession'
    ) t ON t.stream_id = a.admission_stream AND t.semester = a.current_semester
LEFT JOIN
    vw_stream_details v ON v.stream_id = a.admission_stream
WHERE
    t.stream_id IS NULL ";

	if($data["campus"]==2){
		$sql .=" AND NOT (
        a.current_semester = '1' 
        AND a.admission_stream IN (5,6,7,8,9,10,11,96,97,107,108,109)  
    ) AND v.course_id NOT IN (3)";
	}elseif($data["campus"]==3){
		$sql .=" AND NOT (
        a.current_semester = '1' 
        AND a.admission_stream IN (1,2,3,4,5,6,7,8,12,17,18)  
    )";
	}else{		
		$sql .=" AND NOT (
			a.current_semester = '1' 
			AND a.admission_stream IN (5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279,27,28,184,185,26)  
		) AND v.course_id NOT IN (3,19) and a.admission_stream not in(50,48,185,288)";
	}
/*if(isset($_SESSION['role_id']) && $_SESSION['role_id']==10)
		{
		    $ex =explode("_",$_SESSION['name']);
		    $sccode = $ex[1];
		    $sql .=" where v.school_code = $sccode";
		}*/
		if(!empty($data['school_code'])){
			$sql .=' AND v.school_code = "'.$school_code.'"';	
		}
		if(!empty($data['admission-course'])){
			$sql .=' AND v.course_id = "'.$course_id.'"';	
		}
		if(!empty($data['admission-branch'])){
			$sql .=' AND t.stream_id = "'.$stream.'"';	
		}
		if(!empty($data['semester'])){
			$sql .=' AND t.semester = "'.$semester.'"';	
		}
		
		$sql .=" order by v.stream_name,a.current_semester";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }

     public function subjectnotallocated_to_student($data)
    {
		//echo "<pre>";print_r($data);
        if($data["campus"]==2){
			$DB1 = $this->load->database('sjumsdb', TRUE); 
		}elseif($data["campus"]==3){
			$DB1 = $this->load->database('sfumsdb', TRUE); 
		}else{
			$DB1 = $this->load->database('umsdb', TRUE); 
		}
         //$DB1 = $this->load->database('umsdb', TRUE); 
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$acd_yr = explode('~',$data['academic_year']);
		$curr_session = $acd_yr[1];
		$academicyear = explode('-',$acd_yr[0]);
		$school_code=$data["school_code"];
		$course_id=$data["admission-course"];
		$stream=$data["admission-branch"];
		$semester=$data["semester"];
		
         $sql1=" SELECT sd.`school_code`,sm.stud_id,sd.course_id,sm.admission_stream,sm.current_semester,IFNULL(sub_applied_id, 0) AS subapplied_id,sd.stream_name,sd.school_name,count(sm.stud_id) as studentcount FROM student_master  AS sm
            LEFT JOIN `student_applied_subject` AS sas ON sas.stud_id=sm.stud_id and sas.academic_year='$acd_yr[0]'
             INNER JOIN vw_stream_details sd ON sd.stream_id = sm.admission_stream
             WHERE sm.academic_year=".$academicyear[0]." $wher and enrollment_no !='' and (sm.admission_cycle  is null or sm.admission_cycle='') and  sm.`is_detained` ='N' and sm.cancelled_admission='N' and admission_confirm='Y'";
		 $sql="SELECT 
    sd.school_code,
    sd.course_id,
    sm.admission_stream,
    sm.current_semester,
    sd.stream_name,
    sd.school_name,
    COUNT(sm.stud_id) AS studentcount
FROM student_master sm
INNER JOIN vw_stream_details sd 
    ON sd.stream_id = sm.admission_stream
LEFT JOIN student_applied_subject sas 
    ON sas.stud_id = sm.stud_id
   AND sas.academic_year = '$acd_yr[0]'
WHERE sm.academic_year = '$academicyear[0]'
  AND sm.enrollment_no != ''
  AND (sm.admission_cycle IS NULL OR sm.admission_cycle = '')
  AND sm.is_detained = 'N'
  AND sm.cancelled_admission = 'N'
  AND sas.stud_id IS NULL ";

if($data["campus"]==3){
		$sql .=" AND NOT (
       sm.current_semester = '1' 
        AND sm.admission_stream IN (5,6,7,8,9,10,11,96,97,107,108,109)  
    ) ";
	}elseif($data["campus"]==2){
		$sql .=" AND NOT (
        sm.current_semester = '1' 
        AND sm.admission_stream IN (1,2,3,4,5,6,7,8,12,17,18)  
    ) ";
	}else{
		
	$sql .=" AND NOT (
        sm.current_semester = '1' 
        AND sm.admission_stream IN (5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279,27,28,184,185,26)  
    ) ";
	}
if($curr_session=='SUMMER'){
			$cursession = 'SUM';
			 $sql .=" and sm.current_semester not in ('1','3','5','7','9') ";
		}else{
			$cursession = 'WIN';
			 $sql .=" and sm.current_semester not in ('2','4','6','8','10') ";
		}
		if(!empty($data['school_code'])){
			$sql .=' AND sd.school_code = "'.$school_code.'"';	
		}
		if(!empty($data['admission-course'])){
			$sql .=' AND sd.course_id = "'.$course_id.'"';	
		}
		if(!empty($data['admission-branch'])){
			$sql .=' AND sm.admission_stream = "'.$stream.'"';	
		}
		if(!empty($data['semester'])){
			$sql .=' AND sm.current_semester = "'.$semester.'"';	
		}
		$sql .=" GROUP BY sm.admission_stream, sm.current_semester
ORDER BY sm.admission_stream, sm.current_semester";
        $query=$DB1->query($sql);
         //echo $DB1->last_query();exit;
        $result=$query->result_array();
            return $result;
    }
	// added by bala
    function load_courses_for_studentlist($acad_year='',$school_code){
         $DB1 = $this->load->database('umsdb', TRUE);
		 $role_id = $this->session->userdata('role_id');
		 $acd_yr = explode('~',$acad_year);
		$curr_session = $acd_yr[1];
		$academicyear = explode('-',$acd_yr[0]);
		$emp_id = $this->session->userdata("name");
		 $sql="SELECT vw.course_id,vw. course_name,vw.course_short_name FROM student_master s left join vw_stream_details vw on s.admission_stream=vw.stream_id where s.academic_year='$academicyear[0]' and vw.school_code='$school_code' and vw.course_id IS NOT NULL ";
		 if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND vw.school_code = $sccode";
			}
			$sql .=" group by vw.course_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
        return $query->result_array();
    }
	function  load_streams_student_list($data)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
        $acd_yr = explode('~',$data['academic_year']);
		$curr_session = $acd_yr[1];
		$academicyear = explode('-',$acd_yr[0]);
		$sql="SELECT vw.stream_id,vw.stream_name,vw.stream_short_name FROM student_master s left join vw_stream_details vw on s.admission_stream=vw.stream_id where s.academic_year='".$academicyear[0]."' and vw.school_code='".$_POST['school_code']."'   and vw.course_id='".$data['course_id']."'";
        
        if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND vw.school_code = $sccode";
			}
		$sql .=" group by s.admission_stream";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
		return $stream_details =  $query->result_array();       
    } 
	function  load_studsemesters($data)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
  		$emp_id = $this->session->userdata("name");
        $acd_yr = explode('~',$data['academic_year']);
		$curr_session = $acd_yr[1];
		if($curr_session=='WINTER'){
			$wher="and s.current_semesterorg in ('1','3','5','7')";
		}else{
			$wher="and s.current_semester  in ('2','4','6','8')";
		}
		$academicyear = explode('-',$acd_yr[0]);
		$sql="SELECT s.current_semester as semester FROM student_master s  where s.academic_year='".$academicyear[0]."' and s.admission_stream='".$data['stream_id']."' $wher";
		$sql .=" group by s.current_semester";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
		return $stream_details =  $query->result_array();       
    } 
function fetch_consolated_lecture_details($data)
    {
		//error_reporting(E_ALL);
		$today =$data['att_date'];
		$unixTimestamp = strtotime($today);
		$dayOfWeek = date("l", $unixTimestamp);
		//$dayOfWeek = 'Friday';
        $DB1 = $this->load->database('umsdb', TRUE); 
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$acd_yr = explode('~',$data['academic_year']);
		$curr_session = $acd_yr[1];
		$academicyear = explode('-',$acd_yr[0]);
		$school_code=$data["school_code"];
		$course_id=$data["admission-course"];
		$stream=$data["admission-branch"];
		$semester=$data["semester"];
		if($curr_session=='SUMMER'){
			$cursession = 'SUM';
			//$wher=" and current_semester not in ('1','3','5','7')";
		}else{
			$cursession = 'WIN';
			//$wher="and current_semester not in ('4','6','8')";
		}
			
		$sql ="SELECT t.stream_id,t.semester,COUNT(t.stream_id) AS allocatedlect,v.stream_name,v.school_name,v.school_short_name FROM lecture_time_table t
		LEFT JOIN vw_stream_details v ON v.stream_id=t.stream_id
 WHERE academic_year='$acd_yr[0]' AND academic_session='$cursession' AND wday='$dayOfWeek'"; 
	

		if(!empty($data['school_code'])){
			$sql .=' AND v.school_code = "'.$school_code.'"';	
		}
		if(!empty($data['admission-course'])){
			$sql .=' AND v.course_id = "'.$course_id.'"';	
		}
		if(!empty($data['admission-branch'])){
			$sql .=' AND t.stream_id = "'.$stream.'"';	
		}
		if(!empty($data['semester'])){
			$sql .=' AND t.semester = "'.$semester.'"';	
		}
		$sql .=" GROUP BY stream_id,semester";
		$sql .=" order by v.stream_name, semester";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
function fetch_lecture_taken_details($stream_id,$semester,$acd_yr,$today)
    {
		$DB1 = $this->load->database('umsdb', TRUE); 
		//$today =date('Y-m-d');
		//$today ='2019-08-16';
		//print_r($acd_yr);
		if($acd_yr[1]=='SUMMER'){
			$cursession = 'SUM';
		}else{
			$cursession = 'WIN';
		}
			
		$sql ="SELECT stream_id,semester,attendance_date,slot FROM lecture_attendance 
 WHERE academic_year='$acd_yr[0]' AND academic_session='$cursession' AND attendance_date='$today' "; 
		if(!empty($stream_id)){
			$sql .=' AND stream_id = "'.$stream_id.'"';	
		}
		if(!empty($semester)){
			$sql .=' AND semester = "'.$semester.'"';	
		}
		$sql .=" group by attendance_date,slot,subject_id";
        $query = $DB1->query($sql);
	    //echo $DB1->last_query();exit;
	    $res = count($query->result_array());
        return $res;
    }
    function check_holidays($date,$typ){
	
	   $d = date('d',strtotime($date));
	   $m = date('m',strtotime($date));
	   $y = date('Y',strtotime($date));
	    if($typ=='1' || $typ=='3'){
		   $ap = ' and (applicable_for = "Teaching+Technical" OR applicable_for = "All")';
	   }elseif($typ=='2'){
		    $ap = ' and (applicable_for = "Non-Teaching" OR applicable_for = "All")';
	   }else{
		   $ap = '';
	   }
	    $sql="SELECT * FROM holiday_list_master WHERE status='Y' and day(hdate) = '$d' and month(hdate)='$m' and year(hdate)='$y' ".$ap;	 
       $query=$this->db->query($sql);
         $value=$query->result_array();
       
		 if(count($value)==0){
			 $flag="false";
		}else{
		 	 $flag =$value;
		 } 
		 return $flag;		
}
function get_student_not_registered_list($var,$acd_yr)
    {
		if($var["campus"]==2){
			$DB1 = $this->load->database('sjumsdb', TRUE); 
		}elseif($var["campus"]==3){
			$DB1 = $this->load->database('sfumsdb', TRUE); 
		}else{
			$DB1 = $this->load->database('umsdb', TRUE); 
		} 
		$acdyr= explode('-',$acd_yr[0]);
		$prev_yer= $acdyr[0]-1;
		$sql ="select v.school_short_name,v.course_short_name,v.stream_name,v.course_duration,v.course_pattern,s.enrollment_no,s.punching_prn,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as student_name,s.mobile,s.email,s.current_semester as current_semester,s.current_year,academic_year,s.package_name,admission_session,admission_stream,p.parent_mobile2,
case when s.academic_year='$acdyr[0]' THEN 'Done' else 'Not Done' end as registration_status,CASE WHEN v.course_pattern ='SEMESTER' THEN v.course_duration * 2  ELSE v.course_duration END as final_sem,st.state_name,s.nationality,cc.name AS countryname,ads.address,tm.taluka_name
from student_master s 
left join vw_stream_details v on v.stream_id=s.admission_stream
left join parent_details p ON p.student_id = s.stud_id
LEFT JOIN address_details ads ON ads.student_id=s.stud_id AND ads.adds_of='STUDENT' AND ads.address_type='PERMNT' 
LEFT JOIN states AS st ON st.state_id=ads.state_id 
LEFT JOIN district_name AS dt ON dt.district_id=ads.district_id 
LEFT JOIN taluka_master AS tm ON tm.taluka_id=ads.city 
LEFT JOIN countries AS cc ON cc.id=ads.country_id 
where s.cancelled_admission='N' and s.is_detained='N' and admission_session !=$acdyr[0] and  academic_year =$prev_yer and admission_confirm='Y' and v.course_id !=15 and  
CASE WHEN v.course_pattern ='SEMESTER' THEN 
    s.current_year !=v.course_duration
  ELSE
    s.current_year !=v.course_duration
  END
";
		if(!empty($var['admission-branch'])){
			$sql .=' AND admission_stream = "'.$var['admission-branch'].'"';	
		}
		if(!empty($var['admission-course'])){
			$sql .=' AND v.course_id = "'.$var['admission-course'].'"';	
		}
		if(!empty($var['school_code'])){
			$sql .=' AND v.school_code = "'.$var['school_code'].'"';	
		}
		if(!empty($var['semester'])){
			$sql .=' AND current_semesterorg = "'.$var['semester'].'"';	
		}
		$sql .=" order by v.school_name,v.course_name,v.stream_name,s.current_semester";
        $query = $DB1->query($sql);
	   // echo $DB1->last_query();exit;
	    $res =$query->result_array();
        return $res;
    }
	///
	public function get_subjects_without_lecture_plan($data,$acd_yr)
	{
		if($data["campus"]==2){
			$db1 = $this->load->database('sjumsdb', TRUE); 
			$course_id =array(3,19,15);
			$campus=2;
		}elseif($data["campus"]==3){
			$db1 = $this->load->database('sfumsdb', TRUE);
			$course_id =array(15);
			$campus=3;			
		}else{
			$db1 = $this->load->database('umsdb', TRUE); 
			$course_id =array(3,19,15);
			$campus=1;
		} // Lecture table DB
		if($acd_yr[1]=='SUMMER'){
			$cursession = 'SUM';
		}else{
			$cursession = 'WIN';
		}
		$db2 = $this->load->database('obe', TRUE);   // Lecture Plan DB (campus_id = 3)

		$sql = "
			SELECT 
				s.school_short_name,
				s.course_short_name,
				s.stream_name,
				t.semester,
				sm.subject_name,
				sm.sub_id,
				sm.subject_code,
				t.faculty_code,CONCAT(f.fname, ' ', f.lname) AS faculty_name
			FROM 
				lecture_time_table t
			JOIN 
				subject_master sm ON t.subject_code = sm.sub_id and sm.is_active='Y' and sm.subject_category !='VACTT' and sm.course_id not in(3,19,15) and sm.syllabus_required='Y'
			LEFT JOIN 
				vw_stream_details s ON t.stream_id = s.stream_id
			LEFT JOIN 
				vw_faculty f ON f.emp_id = t.faculty_code
			WHERE 
				t.academic_year = '$acd_yr[0]'
				AND t.academic_session = '$cursession'
				AND NOT EXISTS (
					SELECT 1 
					FROM obe.lecture_plan lp
					WHERE lp.subject_id = t.subject_code AND lp.campus_id = $campus
				)
			GROUP BY 
				t.subject_code, t.subject_type, t.stream_id, t.division, t.semester, t.batch_no
			ORDER BY 
				s.school_short_name, s.course_short_name, s.stream_name, t.semester
		";
//echo $sql;exit;
		$query = $db1->query($sql);
		return $query->result_array();
	}
	public function get_subjects_without_syllabus($data,$acd_yr)
	{
		if($data["campus"]==2){
			$db1 = $this->load->database('sjumsdb', TRUE); 
			$course_id =array(3,19,15);
			$data["campus"]=2;
		}elseif($data["campus"]==3){
			$db1 = $this->load->database('sfumsdb', TRUE);
			$course_id =array(15);		
			$data["campus"]=3;			
		}else{
			$db1 = $this->load->database('umsdb', TRUE); 
			$course_id =array(3,19,15);
			 $data["campus"]=1;
		}
		$db2 = $this->load->database('obe', TRUE);   // Syllabus DB

		// Step 1: Get subject_ids with syllabus topics for campus_id = 1
		$topic_subjects = $db2
			->distinct()
			->select('subject_id')
			->where('campus_id', $data["campus"])
			->get('syllabus_topics')
			->result_array();
		// Extract subject_id values into array
		$subject_ids_with_topics = array_column($topic_subjects, 'subject_id');

		// Step 2: Get subjects not in that list
		$db1->select('sm.sub_id, sm.subject_code, sm.subject_name,sm.subject_component,sm.semester, s.stream_name, s.course_short_name, s.school_short_name');
		$db1->from('subject_master sm');
		$db1->where('academicyear', $acd_yr[0]);
		$db1->where('sm.is_active', 'Y');
		$db1->where('sm.syllabus_required', 'Y');
		$db1->where('sm.subject_category!=', 'VACTT');
		//$db1->where('sm.course_id!=', '15');
		
		$db1->where_not_in('sm.course_id',$course_id);
		$db1->join('vw_stream_details s', 'sm.stream_id = s.stream_id', 'left');

		if (!empty($subject_ids_with_topics)) {
			$db1->where_not_in('sm.sub_id', $subject_ids_with_topics);
		}

		$query = $db1->get();
		//echo $db1->last_query();exit;
		return $query->result_array();
	}
	public function get_subjects_without_assignment_question_bank($data,$acd_yr)
	{
		if($data["campus"]==2){
			$db1 = $this->load->database('sjumsdb', TRUE); 
			$course_id =array(3,19,15);
			$data["campus"]=2;
		}elseif($data["campus"]==3){
			$db1 = $this->load->database('sfumsdb', TRUE);
			$course_id =array(15);		
			$data["campus"]=3;			
		}else{
			$db1 = $this->load->database('umsdb', TRUE); 
			$course_id =array(3,19,15);
			 $data["campus"]=1;
		}
		$db2 = $this->load->database('obe', TRUE);   // Syllabus DB

		// Step 1: Get subject_ids with syllabus topics for campus_id = 1
		$topic_subjects = $db2
			->distinct()
			->select('subject_id')
			->where('campus_id', $data["campus"])
			->get('assignment_question_bank')
			->result_array();
		// Extract subject_id values into array
		$subject_ids_with_topics = array_column($topic_subjects, 'subject_id');

		// Step 2: Get subjects not in that list
		$db1->select('sm.sub_id, sm.subject_code,sm.subject_component, sm.subject_name,sm.semester, s.stream_name, s.course_short_name, s.school_short_name');
		$db1->from('subject_master sm');
		$db1->where('academicyear', $acd_yr[0]);
		$db1->where('sm.is_active', 'Y');
		$db1->where('sm.subject_category!=', 'VACTT');
		$db1->where('sm.subject_component!=', 'PR');
		$db1->where('sm.assignments_questions=', 'Y');
		$db1->where('sm.syllabus_required=', 'Y');
		//$course_id =array(3,19,15);
		$db1->where_not_in('sm.course_id',$course_id);
		$db1->join('vw_stream_details s', 'sm.stream_id = s.stream_id', 'left');

		if (!empty($subject_ids_with_topics)) {
			$db1->where_not_in('sm.sub_id', $subject_ids_with_topics);
		}

		$query = $db1->get();
		//echo $db1->last_query();exit;
		return $query->result_array();
	}
	
	public function get_faculty_load_report($data,$acd_yr) {
		$db1 = $this->load->database('umsdb', TRUE);
		if($data["campus"]==2){
			$DB1 = $this->load->database('sjumsdb', TRUE); 
		}elseif($data["campus"]==3){
			$DB1 = $this->load->database('sfumsdb', TRUE); 
		}else{
			$DB1 = $this->load->database('umsdb', TRUE); 
		}
		if($acd_yr[1]=='SUMMER'){
			$cursession = 'SUM';
		}else{
			$cursession = 'WIN';
		}
		$sql = "
			-- 1) Unique (faculty, wday, slot) for total load/hours
-- 2) Unique (faculty, wday, slot, subject_type) for TH/PR load/hours
SELECT 
    X.faculty_code,
    MIN(f.college_code)      AS college_code,
    MIN(f.designation_name)  AS designation_name,
    MIN(f.department_name)   AS department_name,
    MIN(f.mobile_no)         AS mobile_no,
    MIN(CONCAT(f.fname, ' ', f.lname)) AS faculty_name,

    /* Loads (counts of unique slots) */
    SUM(CASE WHEN X.subject_type = 'TH' THEN 1 ELSE 0 END) AS th_load,
    SUM(CASE WHEN X.subject_type = 'PR' THEN 1 ELSE 0 END) AS pr_load,
    T.total_load,  -- unique wday+slot across all types

    /* Hours (sum of durations on unique slots) */
    SUM(CASE WHEN X.subject_type = 'TH' THEN X.duration ELSE 0 END) AS th_hours,
    SUM(CASE WHEN X.subject_type = 'PR' THEN X.duration ELSE 0 END) AS pr_hours,
    T.total_hours  -- sum over unique wday+slot
FROM
(
    /* Unique per (faculty, wday, slot, subject_type) → for TH/PR loads & hours */
    SELECT 
        lt.faculty_code,
        lt.subject_type,
        lt.wday,
        lt.lecture_slot,
        ls.duration
    FROM lecture_time_table lt
    JOIN lecture_slot ls 
      ON ls.lect_slot_id = lt.lecture_slot
    WHERE lt.is_active = 'Y'
      AND lt.academic_year = '$acd_yr[0]'
      AND lt.academic_session = '$cursession'
      #AND lt.faculty_code = '212025'
    GROUP BY lt.faculty_code, lt.subject_type, lt.wday, lt.lecture_slot, ls.duration
) AS X
JOIN
(
    /* Unique per (faculty, wday, slot) → for total load & total hours */
    SELECT 
        Y.faculty_code,
        COUNT(*)           AS total_load,
        SUM(Y.duration)    AS total_hours
    FROM
    (
        SELECT 
            lt.faculty_code,
            lt.wday,
            lt.lecture_slot,
            ls.duration
        FROM lecture_time_table lt
        JOIN lecture_slot ls 
          ON ls.lect_slot_id = lt.lecture_slot
        WHERE lt.is_active = 'Y'
          AND lt.academic_year = '$acd_yr[0]'
          AND lt.academic_session = '$cursession'
         # AND lt.faculty_code = '212025'
        GROUP BY lt.faculty_code, lt.wday, lt.lecture_slot, ls.duration
    ) AS Y
    GROUP BY Y.faculty_code
) AS T
  ON T.faculty_code = X.faculty_code
JOIN vw_faculty f
  ON f.emp_id = X.faculty_code
GROUP BY X.faculty_code
ORDER BY college_code;

		";

    $query = $DB1->query($sql, array($acd_yr[0], $cursession));
	 //echo $db1->last_query();exit;
    return $query->result_array();
}
public function get_program_batch_report($academic_year = '2025-26', $academic_session = 'WIN') {
		$db1 = $this->load->database('umsdb', TRUE);
		$sql = "
			SELECT 
			vs.school_short_name,
    vs.course_short_name,
    vs.stream_name,
    sba.semester,
    sba.division,
    sba.batch,
    COUNT(DISTINCT sba.student_id) AS student_count
FROM student_batch_allocation sba
JOIN vw_stream_details vs 
      ON vs.stream_id = sba.stream_id
WHERE sba.academic_year = '$academic_year'
  AND sba.active = 'Y'";
if($academic_session == 'WIN'){
	$sql .=" AND (sba.semester % 2) = 1 ";
}else{
	$sql .=" AND (sba.semester % 2) = 0 ";
}

$sql .="GROUP BY 
	vs.school_short_name,
    vs.course_name,
    vs.stream_name,
    sba.semester,
    sba.division,
    sba.batch
ORDER BY 
	vs.school_short_name,
    vs.course_name,
    vs.stream_name,
    sba.semester,
    sba.division,
    sba.batch;
		";

    $query = $db1->query($sql, array($academic_year, $academic_session));
	 //echo $db1->last_query();exit;
    return $query->result_array();
}
public function get_overlapping_timetable_report($data, $acd_yr) {
		if($data["campus"]==2){
			$DB1 = $this->load->database('sjumsdb', TRUE); 
		}elseif($data["campus"]==3){
			$DB1 = $this->load->database('sfumsdb', TRUE); 
		}else{
			$DB1 = $this->load->database('umsdb', TRUE); 
		}
		if($acd_yr[1]=='SUMMER'){
			$cursession = 'SUM';
		}else{
			$cursession = 'WIN';
		}
		$sql = "
			SELECT 
    CONCAT(vw.fname, ' ', vw.lname) AS facultyname,
    l.faculty_code,vw.department_name,
    l.wday,
    l.lecture_slot,
    ls.from_time,
    ls.to_time,
    vws.school_id,
    vws.school_short_name,
    GROUP_CONCAT(DISTINCT s.subject_code ORDER BY s.subject_code) AS overlapping_subjects,
    COUNT(DISTINCT CONCAT(LEFT(s.subject_code, 2), RIGHT(s.subject_code, 3))) AS subject_group_count
FROM lecture_time_table l
JOIN lecture_slot ls 
    ON l.lecture_slot = ls.lect_slot_id
JOIN subject_master s 
    ON l.subject_code = s.sub_id and s.is_active='Y'
JOIN vw_faculty vw 
    ON l.faculty_code = vw.emp_id
JOIN vw_stream_details vws 
    ON l.stream_id = vws.stream_id
WHERE l.academic_year = '$acd_yr[0]' and l.is_active='Y' and l.academic_session='$cursession'
  AND l.faculty_code <> '' 
  AND vws.school_short_name <> 'SOD' AND vws.course_id  NOT IN (3,10,19)  #AND vws.school_id!=2
GROUP BY l.faculty_code, l.wday, l.lecture_slot
HAVING subject_group_count > 1
   AND COUNT(DISTINCT SOUNDEX(s.subject_name)) > 1";

    $query = $DB1->query($sql, array($acd_yr[0], $cursession));
	// echo $db1->last_query();
    return $query->result_array();
}
}