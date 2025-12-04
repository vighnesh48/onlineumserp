<?php
class Feedback_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        $this->load->database('umsdb', TRUE); 
        	$DB1 = $this->load->database('umsdb', TRUE);  
    }
    
   function post_parent_fedback($row){
            $DB1 = $this->load->database('umsdb', TRUE);  
           	$insert_id =$DB1->insert('feedback_parent',$row);
           //	print_r($insert_id );exit();
	        $fetch_id=$DB1->insert_id();
	    	return $insert_id;
      
       
   }
   
   function rating()
   {
  $DB1 = $this->load->database('umsdb', TRUE);  
       $DB1->select("*");
		$DB1->from('general_rating_campaign');
	
		//$DB1->where("feedback_date", $row['date']);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
	//echo	count($result);exit();
	
       return $result;
   }
   
   
   
      function campaigns_list()
   {
  $DB1 = $this->load->database('umsdb', TRUE);  
  
          $query=$DB1->query($sql);
         $sql="select distinct(rating_slot) from general_rating_campaign";
     $query=$DB1->query($sql);
 
  $result=$query->result_array();
		return $result;
  
   }
   
      function all_comments()
   {
  $DB1 = $this->load->database('umsdb', TRUE);  
  
  $where ='';
  if($_POST['fdate']!='')
  {
      $fsate=date('Y-m-d',strtotime($_POST['fdate']));
      $where .=" and rating_date >= '$fsate'";
  }
    if($_POST['tdate']!='')
  {
          $tsate=date('Y-m-d',strtotime($_POST['tdate']));
      $where .= " and rating_date <= '$tsate'";  
  }
      if($_POST['campaign']!='')
  {
      $campaig = $_POST['campaign'];
       $where .= " and rating_slot = '$campaig'";  
  }
    
        
         $sql="select teaching_comment,punctuality_comment,transport_comment,hostel_comment,canteen_comment,cleanliness_comment from general_rating_campaign where 1 $where order by rating_id desc";
     $query=$DB1->query($sql);
 
  $result=$query->result_array();
		return $result;
  
   }
    function all_rating()
   {
  $DB1 = $this->load->database('umsdb', TRUE);  
  var_dump($_POST);
  $where ='';
  if($_POST['fdate']!='')
  {
      $fsate=date('Y-m-d',strtotime($_POST['fdate']));
      $where .=" and rating_date >= '$fsate'";
  }
    if($_POST['tdate']!='')
  {
          $tsate=date('Y-m-d',strtotime($_POST['tdate']));
      $where .= " and rating_date <= '$tsate'";  
  }
      if($_POST['campaign']!='')
  {
      $campaig = $_POST['campaign'];
       $where .= " and rating_slot = '$campaig'";  
  }
    
      $sql="select rating_id,
       sum(case when teaching_rating = 5 then 1 else 0 end )as tfivestar,
       sum(case when teaching_rating = 4 then 1 else 0 end )as tfourstar,
       sum(case when teaching_rating = 3 then 1 else 0 end )as tthreestar,
       sum(case when teaching_rating = 2 then 1 else 0 end )as ttwostar,
       sum(case when teaching_rating = 1 then 1 else 0 end )as tonestar,
       sum(case when punctuality_rating = 5 then 1 else 0 end )as pfivestar,
       sum(case when punctuality_rating = 4 then 1 else 0 end )as pfourstar,
       sum(case when punctuality_rating = 3 then 1 else 0 end )as pthreestar,
       sum(case when punctuality_rating = 2 then 1 else 0 end )as ptwostar,
       sum(case when punctuality_rating = 1 then 1 else 0 end )as ponestar,
       sum(case when transport_rating = 5 then 1 else 0 end )as trfivestar,
       sum(case when transport_rating = 4 then 1 else 0 end )as trfourstar,
       sum(case when transport_rating = 3 then 1 else 0 end )as trthreestar,
       sum(case when transport_rating = 2 then 1 else 0 end )as trtwostar,
       sum(case when transport_rating = 1 then 1 else 0 end )as tronestar,
       sum(case when hostel_rating = 5 then 1 else 0 end )as hfivestar,
       sum(case when hostel_rating = 4 then 1 else 0 end )as hfourstar,
       sum(case when hostel_rating = 3 then 1 else 0 end )as hthreestar,
       sum(case when hostel_rating = 2 then 1 else 0 end )as htwostar,
       sum(case when hostel_rating = 1 then 1 else 0 end )as honestar,
       sum(case when canteen_rating = 5 then 1 else 0 end )as cfivestar,
       sum(case when canteen_rating = 4 then 1 else 0 end )as cfourstar,
       sum(case when canteen_rating = 3 then 1 else 0 end )as cthreestar,
       sum(case when canteen_rating = 2 then 1 else 0 end )as ctwostar,
       sum(case when canteen_rating = 1 then 1 else 0 end )as conestar,
       sum(case when cleanliness_rating = 5 then 1 else 0 end )as clfivestar,
       sum(case when cleanliness_rating = 4 then 1 else 0 end )as clfourstar,
       sum(case when cleanliness_rating = 3 then 1 else 0 end )as clthreestar,
       sum(case when cleanliness_rating = 2 then 1 else 0 end )as cltwostar,
       sum(case when cleanliness_rating = 1 then 1 else 0 end )as clonestar
       
      from general_rating_campaign
   where  1 $where ";
        $query=$DB1->query($sql);
       //echo $DB1->last_query();
        //exit();
  $result=$query->row_array();
		return $result;
   
      // $DB1->select("*");
	//	$DB1->from('general_rating_campaign');
	
		//$DB1->where("feedback_date", $row['date']);
	//	$query=$DB1->get();
	//	$result=$query->result_array();
		//echo $DB1->last_query();
	//echo	count($result);exit();
	
       return $result;
   }
   
   
   
   
   
   
   
   function check_feedback($row){
       $DB1 = $this->load->database('umsdb', TRUE);  
       $DB1->select("*");
		$DB1->from('feedback_parent');
		$DB1->where("prn", $row);
	   $DB1->where("status",'Y');
		//$DB1->where("feedback_date", $row['date']);
		$query=$DB1->get();
		$result=$query->row_array();
		//echo $DB1->last_query();
	//echo	count($result);exit();
		 if(count($result)>0){
		     return 1;
		 }
		 else
		 {
		      return 0;
		 }
       
   }
   
   
   
   function parent_feedback_summary(){
         $DB1 = $this->load->database('umsdb', TRUE);  
       $sql="SELECT 'faculty_advisor' AS facility,faculty_advisor,COUNT(faculty_advisor) AS ftotal FROM feedback_parent WHERE STATUS='Y'
GROUP BY faculty_advisor
UNION 
SELECT  'academic' AS facility,academic,COUNT(academic)AS ftotal FROM feedback_parent WHERE STATUS='Y'
GROUP BY academic
UNION 
SELECT  'transport' AS facility,transport,COUNT(transport)AS ftotal FROM feedback_parent WHERE STATUS='Y'
GROUP BY transport
UNION 
SELECT  'hostel' AS facility,transport,COUNT(hostel) AS ftotal FROM feedback_parent WHERE STATUS='Y'
GROUP BY hostel
UNION 
SELECT  'canteen' AS facility,canteen,COUNT(canteen)AS ftotal FROM feedback_parent WHERE STATUS='Y'
GROUP BY canteen
UNION 
SELECT  'admin_support' AS facility,admin_support,COUNT(admin_support)AS ftotal FROM feedback_parent WHERE STATUS='Y'
GROUP BY admin_support";
    $query=$DB1->query($sql);
 //echo  $DB1->last_query();exit();
$res=$query->result_array();
return $res;


    
   }
   
   function export_parent_feedback($year){
       	$DB1=$this->load->database('umsdb', TRUE);  
       	$sql=("SELECT prn, CONCAT(s.first_name, ' ', s.middle_name, ' ', s.last_name) AS parent_of, s.current_year, v.school_short_name,v.stream_short_name, v.course_short_name, DATE_FORMAT(feedback_date, '%d/%m/%Y')AS f_date,
       	case when faculty_advisor=5 then 'Excellent'  when faculty_advisor=4 then 'Good' when faculty_advisor=3 then 'Avg' when faculty_advisor=2 then 'Poor' else 'NA' end as faculty_advisor1, 
       	case when academic=5 then 'Excellent'  when academic=4 then 'Good' when academic=3 then 'Avg' when academic=2 then 'Poor' else 'NA' end as academic1, 
       	case when transport=5 then 'Excellent'  when transport=4 then 'Good' when transport=3 then 'Avg' when transport=2 then 'Poor' else 'NA' end as transport1, 
        case when hostel=5 then 'Excellent'  when hostel=4 then 'Good' when hostel=3 then 'Avg' when hostel=2 then 'Poor' else 'NA' end as hostel1, 
       	case when canteen=5 then 'Excellent'  when canteen=4 then 'Good' when canteen=3 then 'Avg' when canteen=2 then 'Poor' else 'NA' end as canteen1, 
       	case when admin_support=5 then 'Excellent'  when admin_support=4 then 'Good' when admin_support=3 then 'Avg' when admin_support=2 then 'Poor' else 'NA' end as admin_support1, 
       	COMMENT FROM feedback_parent AS f LEFT JOIN student_master AS s ON f.prn=s.enrollment_no LEFT JOIN vw_stream_details AS v ON s.admission_stream=v.stream_id WHERE f.status = 'Y' AND s.academic_year = '$year'");
        $query=$DB1->query($sql);
      //echo  $DB1->last_query();exit();
       $res=$query->result_array();
       return $res;
 
   }
   // for student feedback
   //student details
	function fetch_stud_details($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
	/* 	$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$actses = explode('~',$cursession); */
		$acdemic_year=C_RE_REG_YEAR;
		$DB1->select("sm.*,stm.stream_name, stm.course_name,stm.course_short_name,stm.stream_short_name, s.stream_id as strmId, sba.batch,sba.division");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('student_applied_subject as sas','sas.stud_id = sm.stud_id and sas.semester = sm.current_semester','left');
		$DB1->join('student_batch_allocation as sba','sba.student_id = sm.stud_id and sba.semester = sm.current_semester','left');
		$DB1->join('subject_master as s','s.sub_id = sas.subject_id and s.semester = sm.current_semester','left');
		$where = '(enrollment_no="'.$stud_id.'" OR enrollment_no_new="'.$stud_id.'")';
		$DB1->where($where);
	 	$DB1->where('sm.academic_year', $acdemic_year);
		$DB1->where('is_detained', 'N');
		$DB1->where('cancelled_admission', 'N');
		$DB1->group_by("s.stream_id");
		$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
			//echo $DB1->last_query();exit;
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
	
	// fetch student subjects
	function fetch_student_subjects($semester, $stream, $division,$studid)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 	
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$actses = explode('~',$cursession);
    /*    SELECT t.subject_code, s.subject_name,t.faculty_code,v.fname,v.lname,v.gender FROM `lecture_time_table` as 
        t join student_applied_subject sps on sps.subject_id =t.subject_code left join subject_master as s on
        s.sub_id=t.subject_code left join vw_faculty as v on v.emp_id=t.faculty_code WHERE t.`stream_id` = '9'
        AND t.`semester` = '2' AND t.`division` = 'D' AND sps.stud_id=2 AND t.subject_code !='OFF' AND t.subject_code !='Library' AND t.faculty_code !=''
        */
		$sql="SELECT distinct t.subject_code, s.subject_name,t.faculty_code,v.fname,v.lname,v.gender FROM `lecture_time_table` as t 
	join student_applied_subject sps on sps.subject_id =t.subject_code
		left join subject_master as s on s.sub_id=t.subject_code 
		left join vw_faculty as v on v.emp_id=t.faculty_code  
		WHERE t.`semester` = '".$semester."' AND t.`division` = '".$division."' AND sps.stud_id='".$studid."' AND t.subject_code !='OFF' AND t.subject_code !='Library' AND t.faculty_code !='' and t.academic_session='$actses[0]' AND t.academic_year='$actses[1]' and t.subject_type='TH' ";
		$arr_stream= array(5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279);
		$arr_stream1= array(27,28,26,29,70,115,126,150,157,164,172,184,185,186,199,200,201,202,203,214,215);
		$arr_stream2= array(23,24,148,149,154,155,182,183,204,205,206,207,211,222);
		$arr_stream3= array(178,180,181);
		$arr_stream4= array(22,113,196);
		//$arr_stream5= array(38,39,40);
		$arr_stream6= array(43,44,45,46,47,66,67,103,104,117,167,193,194,210);

		if($semester=='1' || $semester=='2'){
			 if (in_array($stream, $arr_stream))
			{
				$sql .=" AND t.stream_id='9'";
			}else if(in_array($stream, $arr_stream1)){
				$sql .=" AND t.stream_id='234'";
			}
			else if(in_array($stream, $arr_stream2)){
				$sql .=" AND t.stream_id='235'";
			}
			else if(in_array($stream, $arr_stream3)){
				$sql .=" AND t.stream_id='239'";
			}
			else if(in_array($stream, $arr_stream4)){
				$sql .=" AND t.stream_id='236'";
			}
			else if(in_array($stream, $arr_stream5)){
				$sql .=" AND t.stream_id='237'";
			}
			else if(in_array($stream, $arr_stream6)){
				$sql .=" AND t.stream_id='103'";
			}
			else
			{
			  $sql .=" AND t.stream_id='".$stream."'";
			}
		}else{
			$sql .=" AND t.stream_id='".$stream."'";
		}
		
		$sql.=" GROUP by sps.subject_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	
	
	
		function fetch_student_subjects_org($semester, $stream, $division,$ses)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 	
    /*    SELECT t.subject_code, s.subject_name,t.faculty_code,v.fname,v.lname,v.gender FROM `lecture_time_table` as 
        t join student_applied_subject sps on sps.subject_id =t.subject_code left join subject_master as s on
        s.sub_id=t.subject_code left join vw_faculty as v on v.emp_id=t.faculty_code WHERE t.`stream_id` = '9'
        AND t.`semester` = '2' AND t.`division` = 'D' AND sps.stud_id=2 AND t.subject_code !='OFF' AND t.subject_code !='Library' AND t.faculty_code !=''
        */
		
		$actses = explode('~',$ses);
		$stream_arr = array('5','6','7','8','9','10','11','96','97','107','108','109','158','159','162');
		//echo $stream;
		$sql="SELECT distinct t.subject_code, s.subject_name,t.faculty_code,vw.stream_name,v.fname,v.lname,v.gender FROM `lecture_time_table` as t 
	join student_applied_subject sps on sps.subject_id =t.subject_code
		left join subject_master as s on s.sub_id=t.subject_code 
		left join vw_faculty as v on v.emp_id=t.faculty_code  
		left join vw_stream_details as vw on vw.stream_id=t.stream_id 
		WHERE t.`semester` = '".$semester."' AND t.`division` = '".$division."' and t.academic_session='$actses[0]' AND t.academic_year='$actses[1]' AND t.subject_code !='OFF' AND t.subject_code !='Library' AND t.faculty_code !='' !='' and t.subject_type !='PR' ";
		if (in_array($stream,  $stream_arr)){
		    if($semester==2 || $semester==1)
		    {
		     $sql .=" AND t.stream_id =9";	   
		    }else{
				$sql .=" AND t.`stream_id` = '".$stream."'";	
			}
			
		}else{
			 $sql .=" AND t.`stream_id` = '".$stream."'";	   
		}
		$sql.=" GROUP by sps.subject_id";
        $query = $DB1->query($sql);
//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	
	
	
	public function Factilywise_report($academic_type, $academic_year,$select_School,$school){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		if($school!=""){
		/*$sql="SELECT 
DISTINCT t.subject_code, s.`subject_code` AS subcode,
s.subject_name,vw.`stream_name`,t.`semester`,
t.faculty_code,
v.fname,
v.lname,
v.gender FROM `lecture_time_table` AS t 
inner JOIN student_applied_subject sps ON sps.subject_id =t.subject_code 
inner JOIN subject_master AS s ON s.sub_id=t.subject_code 
inner JOIN vw_faculty AS v ON v.emp_id=t.faculty_code 
inner JOIN vw_stream_details AS vw ON vw.stream_id=t.stream_id
WHERE t.faculty_code='$faculty_code' AND t.academic_session='$academic_type' AND t.academic_year='$academic_year'; ";

#vw.`stream_name`,
#t.`semester`,
#v.fname,
#v.lname,
#v.gender
#inner JOIN student_applied_subject sps ON sps.subject_id =t.subject_code 
#inner JOIN vw_faculty AS v ON v.emp_id=t.faculty_code 
#inner JOIN vw_stream_details AS vw ON vw.stream_id=t.stream_id
*/ 
$sql="SELECT 
DISTINCT t.subject_code, 
s.`subject_code` AS subcode,
vw.school_name,
vw.school_code,
s.subject_name,
t.faculty_code,
t.stream_id,
vw.`stream_name`,
t.`semester`,
t.`division`,
v.fname,
v.lname,
v.gender
FROM `lecture_time_table` AS t 
INNER JOIN subject_master AS s ON s.sub_id=t.subject_code 
inner JOIN vw_faculty AS v ON v.emp_id=t.faculty_code 
inner JOIN vw_stream_details AS vw ON vw.stream_id=t.stream_id

WHERE t.faculty_code='$school' AND t.academic_session='$academic_type' AND t.academic_year='$academic_year'";
$query = $DB1->query($sql);
		}else{
$sql="SELECT 
DISTINCT t.subject_code, 
s.`subject_code` AS subcode,
vw.school_name,
vw.school_code,
s.subject_name,
t.faculty_code,
t.stream_id,
vw.`stream_name`,
t.`semester`,
t.`division`,
v.fname,
v.lname,
v.gender
FROM `lecture_time_table` AS t 
INNER JOIN subject_master AS s ON s.sub_id=t.subject_code 
inner JOIN vw_faculty AS v ON v.emp_id=t.faculty_code 
inner JOIN vw_stream_details AS vw ON vw.stream_id=t.stream_id
WHERE t.academic_session='$academic_type' AND t.academic_year='$academic_year' AND school_code='$select_School' order by t.faculty_code";
//echo $sql;exit;
$query = $DB1->query($sql); 
		}



/*SELECT 
DISTINCT t.subject_code,s.`subject_code` AS subcode, 
s.subject_name,vw.`stream_name`,t.`semester`,
t.faculty_code,
v.fname,
v.lname,
v.gender FROM `lecture_time_table` AS t 
JOIN student_applied_subject sps ON sps.subject_id =t.subject_code 
LEFT JOIN subject_master AS s ON s.sub_id=t.subject_code 
LEFT JOIN vw_faculty AS v ON v.emp_id=t.faculty_code 
LEFT JOIN vw_stream_details AS vw ON vw.stream_id=t.stream_id 
WHERE t.faculty_code='110008' AND t.academic_session='SUM' AND t.academic_year='2018-19'; */
 
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	
	function get_facultybyschool($fbsession,$School){
		//$DB1 = $this->load->database('umsdb', TRUE);
		 $subject_det = explode('~',$fbsession);
		
		 $academic_session=$subject_det[0];//echo '<br>';
		 $academic_year=$subject_det[1];//echo '<br>';
         //$academic_yeare=$subject_det[2];//echo '
		 $DB1 = $this->load->database('umsdb', TRUE);
		//$DB1=$this->load->databse('umsdb',true);
		$sql="SELECT 
#t.faculty_code, 
#s.`subject_code` AS subcode,
#s.subject_name,
#vw.`stream_name`,
#t.`semester`,
#s.subject_name,
vw.school_short_name,
t.faculty_code,
v.fname,
v.lname,
v.emp_id,
v.gender 
FROM `lecture_time_table` AS t 
#INNER JOIN student_applied_subject sps ON sps.subject_id =t.subject_code 
#INNER JOIN subject_master AS s ON s.sub_id=t.subject_code 
INNER JOIN vw_faculty AS v ON v.emp_id=t.faculty_code 
INNER JOIN vw_stream_details AS vw ON vw.stream_id=t.stream_id
WHERE vw.school_code='$School' AND t.academic_session='$academic_session' AND t.academic_year='$academic_year' GROUP BY t.faculty_code";
$squery=$DB1->query($sql);
 //echo $DB1->last_query(); exit;
return $squery->result_array();
	}
	
	
	function fetch_student_division($studid, $stream_id, $semester)
	{
	    $DB1 = $this->load->database('umsdb', TRUE);
		$arr_stream= array(5,6,7,8,9,10,11,96,97,107,108,109,158,159,158,159,162);
		$arr_stream1= array(27,28,26,29,70,115,126,150,157,164,172,184,185,186,199,200,201,202,203,214,215);

		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$actses = explode('~',$cursession);		
	    $DB1->select("division");
	    $DB1->from("student_batch_allocation");
	    $DB1->where("student_id",$studid); 
		 
		$DB1->where("semester",$semester);
		$DB1->where("academic_year",$actses[1]); 
		if($semester=='1' || $semester=='2'){
			if (in_array($stream_id, $arr_stream))
			{
				$DB1->where("stream_id",'9');
			}else if(in_array($stream_id, $arr_stream1)){
				$DB1->where("stream_id",'234');
			}
			else if(in_array($stream_id, $arr_stream2)){
				$sql .=" AND stream_id='235'";
			}
			else if(in_array($stream_id, $arr_stream3)){
				$sql .=" AND stream_id='239'";
			}
			else if(in_array($stream_id, $arr_stream4)){
				$sql .=" AND stream_id='236'";
			}
			else if(in_array($stream_id, $arr_stream5)){
				$sql .=" AND stream_id='237'";
			}
			else if(in_array($stream_id, $arr_stream6)){
				$sql .=" AND stream_id='103'";
			}
			else
			{
			  $sql .=" AND t.stream_id='".$stream."'";
			}
		}else{
			$DB1->where("stream_id", $stream_id);
		}
		
		
	    $query=$DB1->get();
		
	   //echo $DB1->last_query();exit;
		$result=$query->row_array();
		
		$division = $result['division'];
		return $division;
		
	}
	
		function fetch_student_subjects_new($semester, $stream)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT distinct t.subject_code, s.subject_name,t.faculty_code,v.fname,v.lname,v.gender FROM `lecture_time_table` as t 
		left join subject_master as s on s.sub_id=t.subject_code 
		left join vw_faculty as v on v.emp_id=t.faculty_code  
		WHERE t.`stream_id` = '".$stream."' AND t.`semester` = '".$semester."'  AND t.subject_code !='OFF' AND t.subject_code !='Library' AND t.faculty_code !=''";
        $query = $DB1->query($sql);
	//	echo $DB1->last_query();//exit;
        return $query->result_array();
		
	}
	
	// fetch student subjects
	function get_feedback_questions()
	{
		$DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT * FROM feedback_questions where is_active='Y'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	
	function post_student_fedback($row){
			$DB1 = $this->load->database('umsdb', TRUE);  
			$insert_id =$DB1->insert('feedback_student',$row);
			//echo $DB1->last_query();
		   	//print_r($insert_id );exit();
			$fetch_id=$DB1->insert_id();
			return $insert_id;

	}
	
	function check_student_feedback($session,$stud_id)
	{
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$actses = explode('~',$cursession);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$DB1->select("*");
        $DB1->from("feedback_student");
        $DB1->where("academic_type",$actses[0]);
		$DB1->where("academic_year",$actses[1]);
		$DB1->where("feedback_cycle",$actses[2]);
        $DB1->where("student_id",$stud_id);
       $query = $DB1->get($sql);
		//echo $DB1->last_query();exit;
        return $query->row_array();
	}
	
	
	function active_academic_session()
	{
	    	$DB1 = $this->load->database('umsdb', TRUE); 
		$DB1->select("*");
        $DB1->from("academic_session");
        $DB1->where("currently_active",'Y');
   
       $query = $DB1->get();
		//echo $DB1->last_query();exit;
        return $query->row_array();
	    
	}
	
	
	
	function fetch_feedback_subjects($subid, $semester, $stream, $div,$stud_id)
	{
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$actses = explode('~',$cursession);
		$DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT * from feedback_student 
		WHERE `stream_id` = '".$stream."' AND `semester` = '".$semester."' AND `division` = '".$div."' AND subject_id ='".$subid."' AND student_id='".$stud_id."' and academic_type='$actses[0]' AND academic_year='$actses[1]' ";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	

		// fetch faculty report details
	function fetch_feedback_subjects_to_admin($subid, $semester, $stream, $div,$faculty_code, $ses, $cycle)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,158,159,162);
		$stream_arr1 = array(43,44,45,46,47);
		$actses = explode('~', $ses);
		
        $sql="SELECT feedback_id, count(*) as STUD_CNT from feedback_student 
		WHERE `semester` = '".$semester."' AND `division` = '".$div."' AND subject_id ='".$subid."' AND faculty_code='".$faculty_code."' and academic_type='$actses[0]' AND academic_year='$actses[1]' and feedback_cycle='$cycle' ";
		
		if ($stream=='9'){
		    if($semester==2 || $semester==1)
		    {
		     $sql.=" AND stream_id in ('5','6','7','8','9','10','11','96','97','107','108','109','158','159','162')";	   
		    }
			
		}else{
			$sql.=" AND stream_id='".$stream."'";
		}
		$sql.=" group by faculty_code";
		
        $query = $DB1->query($sql);
	//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	
	function fetch_feedback_fsubjects_to_admin($subid, $faculty_code, $academic_type, $cycle){
	$DB1 = $this->load->database('umsdb', TRUE);
	$sql="SELECT feedback_id,COUNT(*) AS STUD_CNT FROM feedback_student WHERE subject_id ='$subid' AND faculty_code='$faculty_code' AND academic_type='$academic_type' and feedback_cycle='$cycle' GROUP BY faculty_code";
   $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
}

	function fetch_feedback_fsubjects_to_admin_attendance($subid, $faculty_code, $academic_type,$academic_year, $cycle,$semester,$division){
	$DB1 = $this->load->database('umsdb', TRUE);
	$sql="SELECT feedback_id,COUNT(*) AS STUD_CNT FROM feedback_student WHERE subject_id ='$subid' AND faculty_code='$faculty_code' AND academic_type='$academic_type' and academic_year='$academic_year' and feedback_cycle='$cycle'  and semester='$semester' and division='$division' GROUP BY faculty_code";
   $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
}
	// fetch faculty details
	function getfacdetails($facultycode)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT emp_id,fname,mname,lname,gender from vw_faculty 
		WHERE `emp_id` = '".$facultycode."'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	
		function getfacdetails_all($facultycode)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT emp_id,fname,mname,lname,gender from vw_faculty";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	
	// fetch faculty report details
	function fetch_feedback_report($subid, $semester, $stream, $div,$faculty_code, $cycle)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT count(*) as quecnt, sum(Q1) as Q1, sum(Q2) as Q2, sum(Q3) as Q3, sum(Q4) as Q4, sum(Q5) as Q5, sum(Q6) as Q6, sum(Q7) as Q7, sum(Q8) as Q8, sum(Q9) as Q9, sum(Q10) as Q10, sum(Q11) as Q11, sum(Q12) as Q12, sum(Q13) as Q13, sum(Q14) as Q14, sum(Q15) as Q15, sum(Q16) as Q16, sum(Q17) as Q17, sum(Q18) as Q18 FROM `feedback_student` WHERE `subject_id` = '".$subid."' AND `faculty_code` LIKE '".$faculty_code."' and division='$div' and semester='$semester' and feedback_cycle='$cycle'";
		if($stream=='9' && ($semester=='2' || $semester=='1')){
			$sql .=" AND stream_id in ('5','6','7','8','9','10','11','96','97','107','108','109','158','159','162')";		
		}else{
			$sql .=" AND stream_id ='".$stream."'";
		}
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	//getStreamShortName
	function getStreamShortName($stream_id){
        $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT stream_short_name,stream_code,stream_name FROM vw_stream_details where stream_id='".$stream_id."'";	
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	//get subject details
	function getsubdetails($subId){
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select * from subject_master where sub_id='" .$subId. "'";
		//AND t.faculty_code='".$emp_id."'
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();
		return $sub_details;
	}
	// fetch student wise report details
	function fetch_studentwise_report($subid, $semester, $stream, $div,$faculty_code)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT  student_id, Q1, Q2, Q3, Q4, Q5,  Q6,  Q7, Q8,  Q9,  Q10, Q11,  Q12,  Q13,Q14,Q16,Q17,Q18, comment FROM `feedback_student` WHERE stream_id ='".$stream."' and `subject_id` = '".$subid."' AND `faculty_code` LIKE '".$faculty_code."'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	
	function getFacultySubjects($emp_id){
		$DB1 = $this->load->database('umsdb', TRUE);
        
		$obj = New Consts();
		$cursession = $obj->fetchCurrSession();

		$empStreamid =$this->getFacultyStream($emp_id);
		$sql = "select distinct t.subject_id, vw.stream_code,s.subject_short_name,s.semester from lecture_attendance as t left join subject_master s on s.sub_id = t.subject_id 
		left join vw_stream_details vw on vw.stream_id =s.stream_id
		where t.faculty_code='".$emp_id."'";
		if(!empty($empStreamid) && $empStreamid!='71'){
			$sql .=" AND t.academic_session='".$cursession."'";
		}
		$query = $DB1->query($sql);
		$sub_details = $query->result_array();
		//echo $DB1->last_query();exit;
		return $sub_details;
	}
	
	
	
	
	function fetch_mrk_reports($subid, $semester, $stream, $div,$faculty_code, $ses, $cycle){
		$DB1 = $this->load->database('umsdb', TRUE); 	
		$actses = explode('~', $ses);

		$sql="SELECT feedback_id, count(*) as STUD_CNT, SUM(IFNULL(Q1, 0))+SUM(IFNULL(Q2, 0))+SUM(IFNULL(Q3, 0))+SUM(IFNULL(Q4, 0))+SUM(IFNULL(Q5, 0))+SUM(IFNULL(Q6, 0))+SUM(IFNULL(Q7, 0)+IFNULL(Q8, 0)+IFNULL(Q9, 0)
  )+SUM(IFNULL(Q10, 0))+SUM(IFNULL(Q11, 0))+SUM(IFNULL(Q12, 0))+SUM(IFNULL(Q13, 0))+SUM(IFNULL(Q14, 0))+SUM(IFNULL(Q15, 0))+SUM(IFNULL(Q16, 0))+SUM(IFNULL(Q17, 0)+IFNULL(Q18, 0)) AS Tot_marks FROM `feedback_student` 
		WHERE `semester` = '".$semester."' AND `division` = '".$div."' AND subject_id ='".$subid."' AND  faculty_code='".$faculty_code."' and academic_type='$actses[0]' and academic_year='$actses[1]' and feedback_cycle='$cycle'";
		if($stream=='9' && ($semester=='1' || $semester=='2')){
			$sql .=" AND stream_id in ('5','6','7','8','9','10','11','96','97','107','108','109','158','159','162')";		
		}else{
			$sql .=" AND stream_id ='".$stream."'";
		}
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	
	public function Fetch_mark_fwise($subid, $faculty_code, $academic_type,$academic_year,$cycle){
		$DB1 = $this->load->database('umsdb', TRUE); 	
		$sql="SELECT 
feedback_id, 
COUNT(*) AS STUD_CNT,
 SUM(IFNULL(Q1, 0))+SUM(IFNULL(Q2, 0))+SUM(IFNULL(Q3, 0))+SUM(IFNULL(Q4, 0))+SUM(IFNULL(Q5, 0))+SUM(IFNULL(Q6, 0))+SUM(IFNULL(Q7, 0)+IFNULL(Q8, 0)+IFNULL(Q9, 0) )+SUM(IFNULL(Q10, 0))+SUM(IFNULL(Q11, 0))+SUM(IFNULL(Q12, 0))+SUM(IFNULL(Q13, 0))+SUM(IFNULL(Q14, 0))+SUM(IFNULL(Q15, 0))+SUM(IFNULL(Q16, 0))+SUM(IFNULL(Q17, 0)+IFNULL(Q18, 0)) AS Tot_marks 
 FROM `feedback_student` WHERE 
  subject_id ='$subid' AND faculty_code='$faculty_code' 
 AND academic_type='$academic_type' AND academic_year='$academic_year' AND feedback_cycle='$cycle'";
 $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	public function Fetch_mark_fwise_attendance($subid, $faculty_code, $academic_type,$academic_year,$cycle,$semester,$division){
		$DB1 = $this->load->database('umsdb', TRUE); 	
		$sql="SELECT 
feedback_id, 
COUNT(*) AS STUD_CNT,
 SUM(IFNULL(Q1, 0))+SUM(IFNULL(Q2, 0))+SUM(IFNULL(Q3, 0))+SUM(IFNULL(Q4, 0))+SUM(IFNULL(Q5, 0))+SUM(IFNULL(Q6, 0))+SUM(IFNULL(Q7, 0)+IFNULL(Q8, 0)+IFNULL(Q9, 0) )+SUM(IFNULL(Q10, 0))+SUM(IFNULL(Q11, 0))+SUM(IFNULL(Q12, 0))+SUM(IFNULL(Q13, 0))+SUM(IFNULL(Q14, 0))+SUM(IFNULL(Q15, 0))+SUM(IFNULL(Q16, 0))+SUM(IFNULL(Q17, 0)+IFNULL(Q18, 0)) AS Tot_marks 
 FROM `feedback_student` WHERE 
  subject_id ='$subid' AND faculty_code='$faculty_code' 
 AND academic_type='$academic_type' AND academic_year='$academic_year' AND feedback_cycle='$cycle' AND semester='$semester' AND division='$division'";
 $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}	
	function fetch_fac_mrk_reports($subid, $faculty_code){
		$DB1 = $this->load->database('umsdb', TRUE); 	
		$sql="SELECT feedback_id, count(*) as STUD_CNT, (SUM(Q1)+SUM(Q2)+SUM(Q3)+SUM(Q4)+SUM(Q5)+SUM(Q6)+SUM(Q7)+SUM(Q8)+SUM(Q9)+SUM(Q10)+SUM(Q11)+SUM(Q12)
		+SUM(Q13)+SUM(Q14)+SUM(Q15)+SUM(Q16)+SUM(Q17)+SUM(Q18)) AS Tot_marks FROM `feedback_student` 
		WHERE subject_id ='".$subid."' AND faculty_code='".$faculty_code."'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	
	
	
	
	
	
	function getFacultyFeedbackSubjects($emp_id){
		$DB1 = $this->load->database('umsdb', TRUE);
        
		$obj = New Consts();
		$cursession = $obj->fetchCurrSession();

		$empStreamid =$this->getFacultyStream($emp_id);
		$sql = "select distinct f.subject_id, vw.stream_code,s.subject_short_name,s.semester from feedback_student as f left join subject_master s on s.sub_id = f.subject_id 
		left join vw_stream_details vw on vw.stream_id =s.stream_id
		where f.faculty_code='".$emp_id."'";
		if(!empty($empStreamid) && $empStreamid!='71'){
			$sql .=" AND f.academic_type='".$cursession."'";
		}
		$query = $DB1->query($sql);
		$sub_details = $query->result_array();
		//echo $DB1->last_query();exit;
		return $sub_details;
	}
	function load_faculty($school_id, $dept_id){
		$sql = "select emp_reg_id,emp_id, CONCAT(fname, ' ', mname, ' ', lname) AS fac_name from employee_master where emp_school='" .$school_id. "' and department='" .$dept_id. "' and emp_status='Y'";
		//echo $sql;
		$query = $this->db->query($sql);
		$res= $query->result_array();
		return $res;

	}
	function get_faculty($emp_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select emp_id, CONCAT(fname, ' ', mname, ' ', lname) AS fac_name from vw_faculty where emp_id='" .$emp_id. "'";
		//echo $sql;
		$query = $DB1->query($sql);
		$res= $query->result_array();
		return $res;

	}	
	// fetch Faculty Stream
	function getFacultyStream($emp_id){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT distinct stream_id FROM `lecture_time_table` WHERE `faculty_code` = '".$emp_id."'";		
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res[0]['stream_id'];
	}
// fetch fetch_feedback_session
	function fetch_feedback_session(){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT distinct academic_type,academic_year FROM `feedback_student` order by academic_year desc limit 2";		
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}

	// fetch fetch_feedback_session
	function fetch_classwise_summary($academic_type, $academic_year,$school, $cycle){
		$DB1 = $this->load->database('umsdb', TRUE);
if($school!='1001'){		
		$sql = "SELECT distinct f.stream_id, f.semester, f.division,vw.stream_short_name, vw.school_short_name, vw.stream_code,vw.course_id FROM `feedback_student` as f 
		left join vw_stream_details vw on vw.stream_id = f.stream_id 
		where academic_type='$academic_type' AND academic_year='$academic_year' AND feedback_cycle='$cycle'";
		if($school !=''){
			$sql .= " AND vw.school_code='$school'";
		  }
		$sql .= " order by vw.school_short_name,f.stream_id, f.semester, f.division";	
}else{
		$sql = "SELECT f.stream_id as strm, f.semester, 
	IF ((f.stream_id=5 || f.stream_id=6 || f.stream_id=8 || f.stream_id=10 || f.stream_id=6
	 || f.stream_id=7 || f.stream_id=11 || f.stream_id=96 || f.stream_id=97 || f.stream_id=107 || f.stream_id=108|| f.stream_id=109)&&(f.semester=2 || f.semester=1), '9', f.stream_id) AS stream_id,
	f.division,vw.stream_short_name, vw.school_short_name, 
	vw.stream_code,vw.course_id FROM `feedback_student` AS f 
	LEFT JOIN vw_stream_details vw ON vw.stream_id = f.stream_id 
	WHERE academic_type='$academic_type' AND academic_year='$academic_year' AND feedback_cycle='$cycle' AND vw.school_code='1001' GROUP BY f.semester,stream_id,f.division  ORDER BY  f.stream_id
	";
}		
		$query = $DB1->query($sql);
		$res = $query->result_array();
	//echo $DB1->last_query();exit;
		return $res;
	}
	function  fetch_classwise_student_count($stream_code, $division,$semester,$academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        //echo $batch_code;exit;
        if($stream_code!="")
        {
            $where.=" AND sba.stream_id='$stream_code'  and sba.division='$division' AND sba.semester='".$semester."' AND sba.academic_year ='$academic_year' and sm.cancelled_admission='N'";
        }
		
        $sql="SELECT sba.batch_id,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no FROM `student_batch_allocation` as sba  left join student_master sm on sm.stud_id=sba.student_id $where";
		$sql .= "group by sm.enrollment_no order by sba.roll_no";
        $query = $DB1->query($sql);
	//echo $DB1->last_query(); exit;echo "<br><br>";
        return $query->result_array();
    }
	function  fetch_classwise_student_count_attendance($stream_code, $division,$semester,$academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        //$where=" WHERE 1=1 "; 
         $where=""; 
        //echo $batch_code;exit;
        if($stream_code!="")
        {
            $where.=" AND sba.stream_id='$stream_code' and sba.division='$division' AND sba.semester='".$semester."' AND sba.academic_year ='$academic_year' and sm.cancelled_admission='N'";
        }
		
        $sql="SELECT sba.batch_id,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no FROM `student_batch_allocation` as sba  left join student_master sm on sm.stud_id=sba.student_id $where";
		$sql .= "group by sm.enrollment_no order by sba.roll_no";
        $query = $DB1->query($sql);
	//echo $DB1->last_query(); exit;echo "<br><br>";
        return $query->result_array();
    }	
	
    // fetch fetch_feedback_session
	function fetch_fbsubmitted_student_count($stream, $semester, $division, $academic_year, $academic_sess,$cycle){
		$DB1 = $this->load->database('umsdb', TRUE);
		$stream_arr = array('5','6','7','8','9','10','11','96','97','107','108','109','158','159','162');		
		$sql = "SELECT distinct student_id FROM `feedback_student` where  semester='$semester' and division='$division' and academic_type='$academic_sess' AND academic_year='$academic_year' and feedback_cycle='$cycle'";
		if($stream=='9' && $semester=='1'){
		$sql .=" AND stream_id in ('5','6','7','8','9','10','11','96','97','107','108','109','158','159','162')";		
		}else{
			$sql .=" AND stream_id='$stream'";
		}
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}	
	  function post_esuggestion($row){
            $DB1 = $this->load->database('umsdb', TRUE);  
           	$insert_id =$DB1->insert('esuggestion',$row);
           //	print_r($insert_id );exit();
	        $fetch_id=$DB1->insert_id();
	    	return $insert_id;   
   }
   	function esuggestion_category(){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT c_id,c_name FROM `esuggestion_category` where status='Y'";		
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
	
	function check_esuggestion($row){
       $DB1 = $this->load->database('umsdb', TRUE);  
       $DB1->select("*");
		$DB1->from('esuggestion');
		$DB1->where("prn", $row['prn']);
		$DB1->where("category", $row['category']);
		$DB1->where("role_id", $row['role_id']);
		$DB1->where("status",'Y');
		//$DB1->where("feedback_date", $row['date']);
		$query=$DB1->get();
		$result=$query->row_array();
		//echo $DB1->last_query();
	//echo	count($result);exit();
		 if(count($result)>0){
		     return 1;
		 }
		 else
		 {
		      return 0;
		 }
       
   }
    function fetch_esuggestions($prn, $role_id){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT e.*, ec.c_name FROM `esuggestion` e left join esuggestion_category ec on ec.c_id=e.category where e.status='Y' and e.prn='$prn' and e.role_id='$role_id'";		
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
	 function fetch_Allesuggestions($category='', $type=""){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT e.*, ec.c_name, s.first_name,s.middle_name,s.last_name,s.father_fname,s.father_mname,s.father_lname,vw.stream_short_name, s.current_semester FROM `esuggestion` e 
		left join esuggestion_category ec on ec.c_id=e.category 
		left join student_master s on s.enrollment_no=e.prn
		left join vw_stream_details vw on vw.stream_id =s.admission_stream
		where e.status='Y'";	
		if($category !=0){
			$sql .=" AND e.category='$category'";
		}
		if($type !=''){
			$sql .=" AND e.role_id='$type'";
		}
		$sql .=" group by e.prn,e.suggestion_date";
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();//exit;
		return $res;
	}
	function fetchcomments($prn,$suggestion_date,$type){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT e.comment, ec.c_name,e.category  FROM `esuggestion` e 
		left join esuggestion_category ec on ec.c_id=e.category 
		left join student_master s on s.enrollment_no=e.prn
		left join vw_stream_details vw on vw.stream_id =s.admission_stream
		where e.status='Y'";	
		if($prn !=''){
			$sql .=" AND e.prn='$prn' and e.suggestion_date='$suggestion_date'";
		}
		if($type !=''){
			$sql .=" AND e.role_id='$type'";
		}
		$sql .=" order by ec.c_name";
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();//exit;
		return $res;
	}
	function fetch_catewisecomments($prn,$suggestion_date,$type, $category){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT e.comment, ec.c_name,e.category  FROM `esuggestion` e 
		left join esuggestion_category ec on ec.c_id=e.category 
		left join student_master s on s.enrollment_no=e.prn
		left join vw_stream_details vw on vw.stream_id =s.admission_stream
		where e.status='Y'";	
		if($prn !=''){
			$sql .=" AND e.prn='$prn' and e.suggestion_date='$suggestion_date' and e.category='$category'";
		}
		if($type !=''){
			$sql .=" AND e.role_id='$type'";
		}
		$sql .=" order by ec.c_name";
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();//exit;
		return $res;
	}
	//feedbak data
    function getStudentsajax($school,$streamid='',$year='',$acdyear='', $cycle){
		$DB1 = $this->load->database('umsdb', TRUE);
		//$obj = New Consts();
		//$cursession = $obj->fetchActiveSession_feedback();
		$actses = explode('~',$acdyear);
		
		if($actses[1]=='SUMMER'){
			$acts = 'SUM';
		}else{
			$acts = 'WIN';
		}

		//$DB1->join('feedback_student as f','f.student_id = ad.student_id','left');
		$sql = "select * from (SELECT l.student_id,l.division,f.student_id as status,s.first_name,s.middle_name,s.enrollment_no,s.current_semester,s.last_name,s.mobile,vsd.stream_name,COUNT(*) AS tot_students, SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END) AS totPersent, 
		(SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END)/COUNT(*)) *100 AS att_percentage 
		FROM `lecture_attendance` l 
		LEFT JOIN student_master s ON s.stud_id=l.student_id 
		LEFT JOIN `vw_stream_details` as `vsd` ON `l`.`stream_id` = `vsd`.`stream_id`  
		LEFT JOIN (select student_id from `feedback_student` where academic_type='$acts' and academic_year='$actses[0]' and feedback_cycle='$cycle' group by student_id) as `f` ON `f`.`student_id` = `l`.`student_id` 
		WHERE s.cancelled_admission='N' and l.academic_year='$actses[0]' AND l.academic_session='$acts'  ";
		if($streamid !='' && $streamid !='0')
		{
			$sql .=" AND l.stream_id='$streamid'";	    
		}
		if($school !='0' && $school !='')
		{
			$sql .=" AND vsd.course_id='$school'";	    
		}
		$sql .=" GROUP BY l.student_id )AS a WHERE a.att_percentage >=80 order by current_semester, division";
		//echo $sql;exit;
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();

	}	
	// fetch fd schools
	function fetch_feedback_schools(){
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$actses = explode('~',$cursession);
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct vw.school_code,vw.school_name from feedback_student f
left join vw_stream_details vw on vw.stream_id =f.stream_id where f.academic_year='".$actses[1]."' and f.academic_type='".$actses[0]."' and vw.school_code is not null";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$res = $query->result_array();
		return $res;
	}

  // fetch fd schools
  function fetch_feedback_schools_details($cursession=''){
   /* $obj = New Consts();
    $cursession = $obj->fetchActiveSession_feedback();
    $actses = explode('~',$cursession);*/
    $actses = explode('~',$cursession);
    $DB1 = $this->load->database('umsdb', TRUE);
    $sql = "select distinct vw.school_code,vw.school_name from feedback_student f
left join vw_stream_details vw on vw.stream_id =f.stream_id where f.academic_year='".$actses[1]."' and f.academic_type='".$actses[0]."' and vw.school_code is not null";
    $query = $DB1->query($sql);
    //echo $DB1->last_query();exit;
    $res = $query->result_array();
    return $res;
  }
	// fetch student subjects feedback
	function get_feedback_questions_cht()
	{
		$DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT * FROM feedback_quest_master_cht where is_active='Y'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	function fetch_sub_question($quest_type)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT * FROM feedback_questions_cant_host_trans where is_active='Y'";
		
		if($quest_type !=''){
			$sql .=" and quest_type='$quest_type'";
		}
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();	
	}
	//
	function post_student_fedback_cht($row){
		//echo '<pre>'; print_r($row);exit;
			$DB1 = $this->load->database('umsdb', TRUE);  
			$insert_id =$DB1->insert('feedback_student_cant_host_trans',$row);
			//echo $DB1->last_query();
		   	//print_r($insert_id );exit();
			$fetch_id=$DB1->insert_id();
			return $insert_id;

	}	
	function fetch_stud_facility_status($type,$stud_id,$curyear){
		//$DB1 = $this->load->database('umsdb', TRUE); 		
        $sql="SELECT * FROM sf_student_facilities where sffm_id='$type' and enrollment_no='$stud_id' and status='Y' and academic_year='$curyear'";
        $query = $this->db->query($sql);
		//echo $this->db->last_query();exit;
        return $query->result_array();

	}
	function check_student_feedback_cht($session,$stud_id)
	{
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$actses = explode('~',$cursession);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$DB1->select("*");
        $DB1->from("feedback_student_cant_host_trans");
        $DB1->where("academic_type",$actses[0]);
		$DB1->where("academic_year",$actses[1]);
		$DB1->where("feedback_cycle",$actses[2]);
        $DB1->where("student_id",$stud_id);
       $query = $DB1->get($sql);
		//echo $DB1->last_query();exit;
        return $query->row_array();
	}
	function check_student_attper($prn)
	{
		$obj = New Consts();
		$cursession = $obj->fetchActiveSession_feedback();
		$actses = explode('~',$cursession);
		$stud_det = $this->getstudentidbyprn($prn);
		$stud_id = $stud_det[0]['stud_id'];
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT stream_id,COUNT(*) AS tot_students, SUM(CASE WHEN is_present='Y' THEN 1 ELSE 0 END) AS totPersent, 
(SUM(CASE WHEN is_present='Y' THEN 1 ELSE 0 END)/COUNT(*)) *100 AS att_percentage 
FROM `lecture_attendance` WHERE academic_year='$actses[1]' AND academic_session='$actses[0]' 
AND student_id='$stud_id' ";//
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	function getstudentidbyprn($prn)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT stud_id from student_master where (enrollment_no='$prn' OR enrollment_no_new='$prn') and cancelled_admission='N'";
        $query = $DB1->query($sql);	
        return $query->result_array();
	}
    function load_courses_for_studentlist($acad_year='',$school_id){
         $DB1 = $this->load->database('umsdb', TRUE);
		 $acad_yr = explode('-',$acad_year);
		$emp_id = $this->session->userdata("name");
		 $sql="SELECT vw.course_id,vw. course_name,vw.course_short_name FROM student_master s left join vw_stream_details vw on s.admission_stream=vw.stream_id where s.academic_year='$acad_yr[0]' and vw.course_id IS NOT NULL and vw.school_code='$school_id'";
		$sql .=" group by vw.course_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
        return $query->result_array();
    }
	 function  load_streams_student_list()
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$acad_year = $_POST['academic_year'];
        $acad_yr = explode('-',$acad_year);
		$sql="SELECT vw.stream_id,vw.stream_name,vw.stream_short_name FROM student_master s left join vw_stream_details vw on s.admission_stream=vw.stream_id where s.academic_year='".$acad_yr[0]."' and vw.course_id='".$_POST['course']."'";
        
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
	function  fetch_classwise_fdapperedstudent_count($stream_code, $division,$semester,$academic_year,$academic_type)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $sql="SELECT * FROM (SELECT stream_id,student_id,semester,division,COUNT(*) AS tot_students, SUM(CASE WHEN is_present='Y' THEN 1 ELSE 0 END) AS totPersent, 
(SUM(CASE WHEN is_present='Y' THEN 1 ELSE 0 END)/COUNT(*)) *100 AS att_percentage 
FROM `lecture_attendance` WHERE academic_year='$academic_year' AND academic_session='$academic_type' and stream_id='$stream_code' and semester='$semester' and division='$division'  GROUP BY student_id) a 
WHERE a.att_percentage >=80 ";
		//$sql .= "group by sm.enrollment_no order by sba.roll_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query(); echo "<br><br>";exit;
        return $query->result_array();
    }	
	function  fetch_classwise_fdapperedstudent_count_attendance($stream_code, $division,$semester,$academic_year,$academic_type,$subid, $faculty_code)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $sql="SELECT stream_id,student_id,semester,division,COUNT(student_id) AS tot_students, SUM(CASE WHEN is_present='Y' THEN 1 ELSE 0 END) AS totPersent, 
((SUM(CASE WHEN is_present='Y' THEN 1 ELSE 0 END)/COUNT(student_id)) *100) AS att_percentage 
FROM `lecture_attendance` WHERE academic_year='$academic_year' AND academic_session='$academic_type' and stream_id='$stream_code' and semester='$semester' and division='$division' and subject_id='$subid' and faculty_code='$faculty_code' GROUP BY student_id HAVING att_percentage >=80";
		//$sql .= "group by sm.enrollment_no order by sba.roll_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query(); echo "<br><br>";exit;
        return $query->result_array();
    }	
	function  fetch_classwise_fdapperedstudent_count_attendance_new($stream_code, $division,$semester,$academic_year,$academic_type)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $sql="SELECT student_id FROM `vw_student_attendance_percentage` WHERE academic_year='$academic_year' AND academic_session='$academic_type' and stream_id='$stream_code' and semester='$semester' and division='$division' and att_percentage >=80 ";
		//$sql .= "group by sm.enrollment_no order by sba.roll_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query(); echo "<br><br>";exit;
        return $query->result_array();
    }
	public function HCT_feedback_report($academic_type, $academic_year,$school, $cycle){
		
		$DB1 = $this->load->database('umsdb', TRUE); 
		
		
		if($school==""){
        $sql="SELECT s.first_name,s.last_name, fqmc.question_name,fqmc.ques_id,(fscht.Q1 + fscht.Q2 + fscht.Q3 + fscht.Q4 + fscht.Q5) AS Totalm,((fscht.Q1 + fscht.Q2 + fscht.Q3 + fscht.Q4 + fscht.Q5) / 25 * 100) AS Total_perct, fscht.* FROM `feedback_student_cant_host_trans` AS fscht 
LEFT JOIN `feedback_quest_master_cht` AS fqmc ON 
fqmc.`ques_id`=fscht.`question_category`
LEFT JOIN `student_master` AS s ON 
s.stud_id=fscht.`student_id`
 WHERE fscht.academic_year='$academic_year' AND fscht.academic_type='$academic_type' and fscht.feedback_cycle='$cycle'";
		//$sql .= "group by sm.enrollment_no order by sba.roll_no";
        $query = $DB1->query($sql);
		}
		else if($school=="All"){
        $sql="SELECT  s.first_name,s.last_name,fqmc.question_name,fqmc.ques_id,(fscht.Q1 + fscht.Q2 + fscht.Q3 + fscht.Q4 + fscht.Q5) AS Totalm,((fscht.Q1 + fscht.Q2 + fscht.Q3 + fscht.Q4 + fscht.Q5) / 25 * 100) AS Total_perct, fscht.* FROM `feedback_student_cant_host_trans` AS fscht 
LEFT JOIN `feedback_quest_master_cht` AS fqmc ON 
fqmc.`ques_id`=fscht.`question_category` 
LEFT JOIN `student_master` AS s ON 
s.stud_id=fscht.`student_id`
WHERE fscht.academic_year='$academic_year' AND fscht.academic_type='$academic_type'  and fscht.feedback_cycle='$cycle'";
		//$sql .= "group by sm.enrollment_no order by sba.roll_no";
        $query = $DB1->query($sql);
		}else if($school=="Group"){
			 $sql="SELECT  s.first_name,s.last_name,fqmc.question_name,fqmc.ques_id,SUM(fscht.Q1 + fscht.Q2 + fscht.Q3 + fscht.Q4 + fscht.Q5) AS Totalm,((SUM(fscht.Q1+fscht.Q2+fscht.Q3+fscht.Q4+fscht.Q5)/(25 * COUNT(*)))*100 ) AS Total_perct, fscht.* FROM `feedback_student_cant_host_trans` AS fscht 
LEFT JOIN `feedback_quest_master_cht` AS fqmc ON 
fqmc.`ques_id`=fscht.`question_category` 
LEFT JOIN `student_master` AS s ON 
s.stud_id=fscht.`student_id`
GROUP BY  fqmc.question_name ";
 $query = $DB1->query($sql);
		}
else if($school=="Canteen"){
			 $sql="SELECT  s.first_name,s.last_name,fqmc.question_name,fqmc.ques_id,(fscht.Q1 + fscht.Q2 + fscht.Q3 + fscht.Q4 + fscht.Q5) AS Totalm,(((fscht.Q1+fscht.Q2+fscht.Q3+fscht.Q4+fscht.Q5)/(25 * 1))*100 ) AS Total_perct, fscht.* FROM `feedback_student_cant_host_trans` AS fscht 
LEFT JOIN `feedback_quest_master_cht` AS fqmc ON 
fqmc.`ques_id`=fscht.`question_category`
LEFT JOIN `student_master` AS s ON 
s.stud_id=fscht.`student_id`
 WHERE fscht.question_category='1'  ";
 $query = $DB1->query($sql);
		}
		else if($school=="Transportation"){
			 $sql="SELECT s.first_name,s.last_name, fqmc.question_name,fqmc.ques_id,(fscht.Q1 + fscht.Q2 + fscht.Q3 + fscht.Q4 + fscht.Q5) AS Totalm,(((fscht.Q1+fscht.Q2+fscht.Q3+fscht.Q4+fscht.Q5)/(25 * 1))*100 ) AS Total_perct, fscht.* FROM `feedback_student_cant_host_trans` AS fscht 
LEFT JOIN `feedback_quest_master_cht` AS fqmc ON 
fqmc.`ques_id`=fscht.`question_category`
LEFT JOIN `student_master` AS s ON 
s.stud_id=fscht.`student_id`
 WHERE fscht.question_category='2' ";
 $query = $DB1->query($sql);
		}
		else if($school=="Hostel"){
			 $sql="SELECT  s.first_name,s.last_name,fqmc.question_name,fqmc.ques_id,(fscht.Q1 + fscht.Q2 + fscht.Q3 + fscht.Q4 + fscht.Q5) AS Totalm,(((fscht.Q1+fscht.Q2+fscht.Q3+fscht.Q4+fscht.Q5)/(25 * 1))*100 ) AS Total_perct, fscht.* FROM `feedback_student_cant_host_trans` AS fscht 
LEFT JOIN `feedback_quest_master_cht` AS fqmc ON 
fqmc.`ques_id`=fscht.`question_category`
LEFT JOIN `student_master` AS s ON 
s.stud_id=fscht.`student_id`
 WHERE fscht.question_category='3'  ";
 $query = $DB1->query($sql);
		}
		//echo $DB1->last_query(); echo "<br><br>";exit;
        return $query->result_array();
	}
	function fetch_total_count($stream_id, $division, $semester,$academic_year,$cycle){
		 $DB1 = $this->load->database('umsdb', TRUE);
		 $sql1="SELECT stud_id FROM  student_master WHERE cancelled_admission='N' AND academic_year='2018'";
		 $query1 = $DB1->query($sql1);
		$data1= $query1->result_array();
		 
		 $sql2="SELECT student_id FROM `feedback_student` WHERE academic_type='SUM' AND academic_year='2018-19' and feedback_cycle='$cycle'  GROUP BY student_id
";
		 $query2 = $DB1->query($sql2);
		 $data2=$query2->result_array();
		 
		 
		 $sql3="SELECT l.student_id,
   SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END) AS totPersent,
 (SUM(CASE WHEN l.is_present='Y' THEN 1 ELSE 0 END)/COUNT(*)) *100 AS att_percentage  FROM `lecture_attendance` l
  WHERE l.academic_year='2018-19' AND l.academic_session='SUM'  GROUP BY l.student_id 
  HAVING att_percentage>=60";
    $query3 = $DB1->query($sql3);
	//$this->db->count_all_results();
	 $data3=$query3->result_array();
//$data=$data1'~'.$data2.'~'.$data3;
	        return count($data1).'~'.count($data3).'~'.count($data2);
	}
	
	
}