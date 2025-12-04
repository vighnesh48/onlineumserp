<?php
class Phd_exam_timetable_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    } 	
	
	function getStudAllocatedSubject($stud_id){
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
		$DB1->from('phd_exam_session');
		$DB1->where("is_active", 'Y');
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
		$DB1->from('phd_exam_details');
		$DB1->where("is_active", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	
	// fetch semester subject
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
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}	
	//
	
	function getCollegeCourse(){
         $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT(course_id),course_name,course_short_name FROM vw_stream_details";
	
        $query = $DB1->query($sql);
        return $query->result_array();
    }
	function fetch_examTimetable($data,$exam_id)
	{
		$stream = $data['admission-branch'];
		$semester = $data['semester'];
		$exam_type = $data['exam_type'];
		$batch = $data['regulation'];
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT et.*, s.subject_name,s.subject_code FROM phd_exam_time_table as et left join subject_master as s on s.sub_id= et.subject_id where et.exam_id='$exam_id' AND et.stream_id='$stream' AND et.semester='$semester' AND et.is_active='Y' and et.batch='$batch' ";
	    if($exam_type=='bklg'){
		    $sql .=" AND et.is_backlog='Y' " ;
		}else{
		    $sql .=" AND et.is_backlog='N' " ;
		}
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
				 
	function getSchools(){
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
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
		}
	
        $query = $DB1->query($sql);
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
		$DB1->from('phd_exam_session');
		$DB1->where("is_active", 'Y');
		$DB1->where("active_for_exam", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
//
function get_examttschools($exam_id){
         $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT vw.school_code,vw.school_short_name FROM `phd_exam_time_table` as et left join vw_stream_details vw on et.stream_id =vw.stream_id  where et.exam_id = '".$exam_id."' group by vw.school_code";	
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
function get_examttcourses($exam_id, $school_id){
        $DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT vw.course_id,vw.course_short_name FROM `phd_exam_time_table` as et left join vw_stream_details vw on et.stream_id =vw.stream_id  where et.exam_id = '".$exam_id."' and vw.school_code='".$school_id."' group by vw.course_id";	
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	function get_examttstreams($exam_id, $school_id,$course_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT vw.stream_id,vw.stream_short_name FROM `phd_exam_time_table` as et left join vw_stream_details vw on et.stream_id =vw.stream_id  where et.exam_id = '".$exam_id."' and vw.school_code='".$school_id."' and vw.course_id='".$course_id."' group by vw.stream_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
		return $stream_details;
    }	
	 function get_examttsemester($exam_id, $stream_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql = "SELECT et.semester FROM `phd_exam_time_table` as et where et.exam_id = '".$exam_id."' and et.stream_id='".$stream_id."' group by et.semester";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
		return $stream_details;
    }
	function fetch_examTimetablestreams($school, $course_id,$admissionbranch, $semester,$exam_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select stream_id,stream_code,stream_short_name,stream_name from vw_stream_details where stream_id in(select distinct stream_id from phd_exam_time_table  where exam_id='$exam_id' and stream_short_name is not null ) ";
		if($course_id !=0){
			$sql .=" and course_id ='$course_id'"; 
		}
		if($admissionbranch !=0){
			$sql .=" and stream_id ='$admissionbranch'"; 
		}
		/*if($semester !=0){
			$sql .=" and semester ='$semester'"; 
		}*/
		$sql .=" group by stream_id order by stream_id"; 
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        $stream_details = $query->result_array();
		return $stream_details;
    }	
	function fetch_examTimetable_details($admissionbranch,$exam_id,$semester)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT et.*, s.subject_name,s.subject_code, s.regulation FROM phd_exam_time_table as et left join subject_master as s on s.sub_id= et.subject_id where et.exam_id='$exam_id' AND et.stream_id='$admissionbranch' AND et.is_active='Y' AND s.subject_component !='PR' and et.date !='2019-02-01'";
	    if($semester !=0){
			$sql .=" and et.semester ='$semester'"; 
		}
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	function fetch_examTimetable_batches($admissionbranch,$exam_id,$semester)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT batch FROM phd_exam_time_table where exam_id='$exam_id' AND stream_id='$admissionbranch' AND is_active='Y' ";
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
		$sql="SELECT DISTINCT from_time,to_time FROM phd_exam_time_table where exam_id='$exam_id' AND stream_id='$admissionbranch' AND is_active='Y' ";
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
		$DB1->from('phd_exam_session');
		$DB1->where("is_active", 'Y');
		$DB1->where("exam_id", $exam_id);
		$DB1->where("active_for_exam", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	// fetch backlog subjects
	function list_backlog_subjects($data){
		
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sem= $data['semester'];
		$stream= $data['admission-branch'];
		$batch = $data['regulation'];
		//$sem= $data['semester'];
		$where=" WHERE sm.is_active='Y' and sm.batch='$batch'";  
        if($sem!="")
        {
            $where.=" AND ess.semester='".$sem."' AND ess.stream_id='".$stream."' AND ess.passed='N'";
        }
		$sql="SELECT sm.* FROM phd_exam_student_subject ess left join subject_master sm on ess.subject_id=sm.sub_id $where group by ess.subject_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
	}
	function fetch_exam_session_for_marks_entry()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('phd_exam_session');
		$DB1->where("active_for_marks_entry", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}	
}?>