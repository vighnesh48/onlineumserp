<?php
class Exam_timetable_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    } 		function getStudAllocatedSubject($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE 1=1 ";  
        
        if($stud_id!="")
        {
            $where.=" sm.subject_component='TH' AND sas.stud_id='".$stud_id."'";
        }	
		
		$sql="SELECT sas.stud_id, sm.subject_name, sas.sub_applied_id, sm.sub_id, sm.subject_code,sm.semester FROM `student_applied_subject` as sas left join subject_master sm on sm.sub_id=sas.subject_id $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	//
	function fetch_stud_curr_exam()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('exam_session');
		$DB1->where("is_active", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	function fetch_session_for_timetable_exam()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('exam_session');
		$DB1->where("active_for_timetable", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	function fetch_marks_entry_exam_session()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('exam_session');
		$DB1->where("active_for_marks_entry", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}	
	function course_streams()
	{
	       $DB1 = $this->load->database('umsdb', TRUE); 
        $sql="select stream_id,stream_name,stream_short_name from vw_stream_details where course_id='".$_POST['course']."' ";
        $query = $DB1->query($sql);
       $stream_details =  $query->result_array();
        
        
       echo '<select name="admission-stream" class="form-control" id="admission-stream">
									<option value="">Select Stream</option><option value="0">All Streams</option>';
									
									foreach($stream_details as $course){
									
										echo '<option value="'.$course['stream_id'].'"'.$sel.'>'.$course['stream_name'].'</option>';
									} 
									echo '</select></div>';
        
	}
	
	
	
	
	
	
	
	
	//
	function fetch_stud_exam_details()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('exam_details');
		$DB1->where("is_active", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	
	// fetch semester subject
	function list_exam_subjects_old($data){
		
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sem= $data['semester'];
		$stream= $data['admission-branch'];
		$batch = $data['regulation'];
		//$sem= $data['semester'];
		$where=" WHERE sm.is_active='Y' and sm.batch='$batch'";  
       // $stream_arr = array(5,6,7,8,9,10,11,96,97);
		//$stream_arr1 = array(43,44,45,46,47);
        if($sem!="")
        {
            $where.=" AND sm.semester='".$sem."'";
        }
	
		if (in_array($stream,  $stream_arr)){
			$where.=" AND sm.stream_id =9";	
		}else if(in_array($stream,  $stream_arr1)){
			$where.=" AND sm.stream_id =103";
		}else{
			$where.=" AND sm.stream_id='".$stream."'";
		}	
		$sql="SELECT sm.* FROM subject_master sm $where";
        $query = $DB1->query($sql);
		echo $DB1->last_query();exit;
        return $query->result_array();
	}	
	//
	function list_exam_subjects($data){
		
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sem= $data['semester'];
		$stream= $data['admission-branch'];
		$batch = $data['regulation'];
		//$sem= $data['semester'];
		$where=" WHERE sm.is_active='Y' and sm.batch='$batch'";  
       // $stream_arr = array(5,6,7,8,9,10,11,96,97);
		//$stream_arr1 = array(43,44,45,46,47);
        if($sem!="")
        {
            $where.=" AND e.semester='".$sem."'";
        }
	
		if (in_array($stream,  $stream_arr)){
			$where.=" AND sm.stream_id =9";	
		}else if(in_array($stream,  $stream_arr1)){
			$where.=" AND sm.stream_id =103";
		}else{
			$where.=" AND e.stream_id='".$stream."'";
		}	
		if($stream==9 && ($sem==1 || $sem==2)){
			 $sql="SELECT sm.* FROM lecture_time_table e 
left join subject_master sm on sm.sub_id=e.subject_code $where and e.academic_year='2022-23' and e.academic_session='SUM' group by e.subject_code";
		}else{
		/*$sql="SELECT sm.* FROM exam_applied_subjects e 
left join exam_details ed on ed.stud_id=e.stud_id and e.exam_id=ed.exam_id
left join subject_master sm on sm.sub_id=e.subject_id $where group by e.subject_id";*/
$sql="SELECT sm.* FROM lecture_time_table e 
left join subject_master sm on sm.sub_id=e.subject_code $where and e.academic_year='2022-23' and e.academic_session='SUM' group by e.subject_code";
		}
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}

function list_exam_subjects_new($data){
		
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sem= $data['semester'];
		$stream= $data['admission-branch'];
		$batch = $data['regulation'];
		//$sem= $data['semester'];
		$where=" WHERE is_active='Y' and batch='$batch'";  
       // $stream_arr = array(5,6,7,8,9,10,11,96,97);
		//$stream_arr1 = array(43,44,45,46,47);
         if($sem!="")
        {
            $where.=" AND semester='".$sem."'";
         
		 }
		 
		 if($stream!="")
        {
            $where.=" AND stream_id='".$stream."'";
         
		 }
	
		/*if (in_array($stream,  $stream_arr)){
			$where.=" AND stream_id =9";	
		}else if(in_array($stream,  $stream_arr1)){
			$where.=" AND stream_id =103";
		}/* else{
			$where.=" AND e.stream_id='".$stream."'";
		} */	
		/* if($stream==9 && ($sem==1 || $sem==2)){
			 $sql="SELECT * FROM  subject_master  $where group by subject_code";
		}else{ */
		/*$sql="SELECT sm.* FROM exam_applied_subjects e 
left join exam_details ed on ed.stud_id=e.stud_id and e.exam_id=ed.exam_id
left join subject_master sm on sm.sub_id=e.subject_id $where group by e.subject_id";*/
$sql="SELECT * FROM  subject_master  $where  group by subject_code";
		//}
        $query = $DB1->query($sql);
	//echo $DB1->last_query();exit;
        return $query->result_array();
	}	
	
	function getCollegeCourse(){
         $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT(course_id),course_name,course_short_name FROM vw_stream_details";
	
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function fetch_examTimetable($data,$exam_id)
	{
		$stream = $data['admission-branch'];
		$semester = $data['semester'];
		$exam_type = $data['exam_type'];
		$batch = $data['regulation'];
		$DB1 = $this->load->database('umsdb', TRUE); 
		if($exam_type=='bklg'){
		    $bklg .="Y" ;
		}else{
		    $bklg="N" ;
		}
		$sql="SELECT et.*, s.sub_id,s.subject_name,s.subject_code FROM subject_master as s
left join exam_time_table as et on s.sub_id= et.subject_id AND et.exam_id='$exam_id' AND et.is_backlog='$bklg' where  s.stream_id='$stream' AND s.semester='$semester' and s.batch='$batch'  AND s.is_active='Y' group by s.sub_id";
	    
        $query = $DB1->query($sql);
	    //echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	function fetch_examTimetable_check($data,$exam_id)
	{
		$stream = $data['admission-branch'];
		$semester = $data['semester'];
		$exam_type = $data['exam_type'];
		$batch = $data['regulation'];
		$DB1 = $this->load->database('umsdb', TRUE); 
		if($exam_type=='bklg'){
		    $bklg .="Y" ;
		}else{
		    $bklg="N" ;
		}
		$sql="SELECT et.*, s.sub_id,s.subject_name,s.subject_code FROM exam_time_table as et 
left join subject_master as s on s.sub_id= et.subject_id where  et.stream_id='$stream' AND et.semester='$semester' and et.batch='$batch' AND et.is_active='Y' AND et.exam_id='$exam_id' AND et.is_backlog='$bklg'";
	    
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	
	function fetch_exam_timeslots($exam_id='',$group_by=''){
		$secondDB = $this->load->database('umsdb', TRUE); 
		$secondDB->select("*");
        $secondDB->from("examtime_slot");
		  if($exam_id !=""){
		$secondDB->where("exam_id",$exam_id);
		  }
		$secondDB->where("is_active",'Y');
		  if($group_by==1){
			$secondDB->group_by("from_time");
             $secondDB->order_by("id");			
		  }
		  else if($group_by==2){
			$secondDB->group_by("to_time");  
		    $secondDB->order_by("id");
		  }
        $query = $secondDB->get();
		//echo $secondDB->last_query();exit;
		return $query->result();
	}
				 
	function getSchools(){
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		//print_r($emp_id);exit;
		$this->load->model('Subject_model');
        $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT(school_code),school_short_name FROM vw_stream_details where school_code IS NOT NULL";
		
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $sql .=" and school_code = $schid";
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" and school_code = $sccode";
		}else if(isset($role_id) && $role_id==37){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" and school_code = $sccode";
		}
	
        $query = $DB1->query($sql);
	//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	 function get_course_streams($course_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		if($role_id==3){
			$sql = "SELECT distinct l.stream_id, v.stream_name FROM `lecture_time_table` as l left join vw_stream_details as v on v.stream_id=l.stream_id WHERE l.`faculty_code` ='".$emp_id."' and v.course_id='" .$course_id. "'";
		}else{
			$sql = "select stream_id,stream_name from vw_stream_details where course_id='".$course_id."' ";
		}
        $query = $DB1->query($sql);
        $stream_details = $query->result_array();
		return $stream_details;
    }
	
	function get_courses($school_code){
         $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT(course_id),course_name,course_short_name FROM vw_stream_details where school_code='".$school_code."' ";
	
        $query = $DB1->query($sql);
        return $query->result_array();
    }	
	 function get_streams($course_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");

		$sql = "select stream_id,stream_name from vw_stream_details where course_id='".$course_id."' ";

        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
		return $stream_details;
    }
	function getRegulation(){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT distinct regulation FROM `subject_master` WHERE `is_active` = 'Y'";		
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	} 
	//
	function fetch_curr_exam_session()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('exam_session');
		$DB1->where("is_active", 'Y');
		$DB1->where("active_for_exam", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	
	function fetch_exam_session_for_marks_entry()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('exam_session');
		$DB1->where("active_for_marks_entry", 'Y');
		$query=$DB1->get();
		
		// echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
	}	
	

	
	function getCurrentSession_for_marks_entry(){
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT * FROM `academic_session` WHERE active_for_marks_entry='Y' order by id desc limit 0, 1";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
//
function get_examttschools($exam_id){
         $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT vw.school_code,vw.school_short_name FROM `exam_time_table` as et left join vw_stream_details vw on et.stream_id =vw.stream_id  where et.exam_id = '".$exam_id."' group by vw.school_code";	
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
function get_examttcourses($exam_id, $school_id){
        $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT vw.course_id,vw.course_short_name FROM `exam_time_table` as et left join vw_stream_details vw on et.stream_id =vw.stream_id  where et.exam_id = '".$exam_id."' and vw.school_code='".$school_id."' group by vw.course_id";	
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	function get_examttstreams($exam_id, $school_id,$course_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT vw.stream_id,vw.stream_short_name FROM `exam_time_table` as et left join vw_stream_details vw on et.stream_id =vw.stream_id  where et.exam_id = '".$exam_id."' and vw.school_code='".$school_id."' and vw.course_id='".$course_id."' group by vw.stream_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
		return $stream_details;
    }	
	 function get_examttsemester($exam_id, $stream_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT et.semester FROM `exam_time_table` as et where et.exam_id = '".$exam_id."' and et.stream_id='".$stream_id."' group by et.semester";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
		return $stream_details;
    }
	function fetch_examTimetablestreams($school, $course_id,$admissionbranch, $semester,$exam_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select stream_id,stream_code,stream_short_name,stream_name,school_short_name,school_name from vw_stream_details 
		where stream_id in(select distinct stream_id from exam_time_table where is_active = 'Y' and exam_id='$exam_id' and stream_short_name is not null ) ";
		if($course_id !=0){
			$sql .=" and course_id ='$course_id'"; 
		}
		if($admissionbranch !=0){
			$sql .=" and stream_id ='$admissionbranch'"; 
		}
		if($school !=0){
			$sql .=" and school_code ='$school'"; 
		}
		$sql .=" group by stream_id order by stream_id"; 
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
		return $stream_details;
    }	
	function fetch_examTimetable_details($admissionbranch,$exam_id,$semester)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT et.*,est.session, s.subject_name,s.subject_code, s.regulation, s.batch as sub_batch 
		FROM exam_time_table as et left join examtime_slot as est on est.id= et.exam_slot_id and est.exam_id=et.exam_id 
		left join subject_master as s on s.sub_id= et.subject_id 
		where et.exam_id='$exam_id' AND et.stream_id='$admissionbranch' AND et.is_active='Y' AND s.is_active='Y' AND s.subject_component !='PR' and et.date !='2000-01-01'";
	    if($semester !=0){
			$sql .=" and et.semester ='$semester'"; 
		}
		$sql .=" order by batch,semester desc";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	function fetch_examTimetable_batches($admissionbranch,$exam_id,$semester)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT batch FROM exam_time_table where exam_id='$exam_id' AND stream_id='$admissionbranch' AND is_active='Y' ";
	    if($semester !=0){
			$sql .=" and semester ='$semester'"; 
		}
		 
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	function fetch_examTimetable_slots($admissionbranch,$exam_id,$semester)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT from_time,to_time FROM exam_time_table where exam_id='$exam_id' AND stream_id='$admissionbranch' AND is_active='Y' ";
	    if($semester !=0){
			$sql .=" and semester ='$semester'"; 
		}
		$sql .=" order by from_time desc";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	function fetch_exam_session($exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('exam_session');
		$DB1->where("is_active", 'Y');
		$DB1->where("exam_id", $exam_id);
		$DB1->where("active_for_exam", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	// fetch backlog subjects
	function list_backlog_subjects($data,$exam_id){
		
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sem= $data['semester'];
		$stream= $data['admission-branch'];
		$batch = $data['regulation'];
		//$sem= $data['semester'];
		$where=" WHERE sm.is_active='Y' and sm.batch='$batch'";  
        if($sem!="")
        {
            $where.=" AND ess.semester='".$sem."' AND ess.stream_id='".$stream."' AND ess.passed='N' and sm.subject_component !='PR'";
        }
		$sql="SELECT sm.* FROM exam_student_subject ess left join subject_master sm on ess.subject_id=sm.sub_id $where group by ess.subject_id
		UNION
		(SELECT sm.* 
from exam_applied_subjects ess 
join exam_details e on e.exam_id=ess.exam_id and e.stud_id=ess.stud_id and e.semester!=ess.semester
join subject_master sm on sm.sub_id=ess.subject_id 
WHERE ess.exam_id='$exam_id' AND ess.semester='".$sem."' AND ess.stream_id='".$stream."' and sm.subject_component !='PR' group by ess.subject_id)
		";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	
	function getRegulation_for_rank(){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$sql = "SELECT distinct exam_year as regulation FROM `exam_result_master`";		
		$query = $DB1->query($sql);
		$res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	} 
	function fetch_exam_session_for_qp()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('exam_session');
		$DB1->where("active_for_qp", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	} 
	

}?>