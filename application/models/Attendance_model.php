<?php
class Attendance_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
    }
    
	
	// fetch student list
	function getclassRoom($emp_id, $curr_session='')
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$empStreamid =$this->getFacultyStream($emp_id);
		if($curr_session=='SUMMER'){
			$cursession = 'SUM';
		}else{
			$cursession = 'WIN';
		}
        $where=" WHERE 1=1 "; 

		//if($role_id==3 || $role_id==12){
		if(!empty($empStreamid)){
			$sql = "SELECT distinct t.stream_id, vw.stream_code, vw.course_short_name, vw.stream_name,vw.stream_short_name FROM `lecture_time_table` t left join vw_stream_details vw on vw.stream_id =t.stream_id WHERE t.`faculty_code` ='".$emp_id."'";
			if(!empty($empStreamid) && $empStreamid!='71'){
				$sql .=" AND t.academic_session='".$cursession."'";
			}
		}else{
			$sql = "SELECT DISTINCT(course_id),course_name,course_short_name,stream_name,stream_id FROM vw_stream_details";
		if(isset($_SESSION['role_id']) && $_SESSION['role_id']==10)
		{
		    $ex =explode("_",$_SESSION['name']);
		    $sccode = $ex[1];
		    $sql .=" where school_code = $sccode";
		}
		}
		
		
        /*if($emp_id!="")
        {
            $where.=" AND t.faculty_code='".$emp_id."'";
        }		
        $sql="SELECT distinct t.stream_id, vw.stream_code, vw.course_short_name, vw.stream_name FROM `lecture_time_table` t left join vw_stream_details vw on vw.stream_id =t.stream_id $where";*/
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	// fetch student list
	
	
	function suggestions()
	{
  $DB1 = $this->load->database('umsdb', TRUE); 	   
  		$DB1->select('*');
		$DB1->from("student_suggestions");
	$DB1->where("added_by", $_SESSION['name']);
		$query=$DB1->get();
		$result=$query->result_array();
  return $result;
	    
	}
	
	
	function student_suggestions()
	{
  $DB1 = $this->load->database('umsdb', TRUE); 	   
  		$DB1->select('ss.*,sm.first_name,sm.middle_name,sm.last_name,sm.current_year,vsd.stream_name');
		$DB1->from("student_suggestions ss");
	$DB1->join("student_master sm","ss.student_id=sm.enrollment_no","left");
	$DB1->join("vw_stream_details vsd","sm.admission_stream=vsd.stream_id","left");
		$query=$DB1->get();
		$result=$query->result_array();
  return $result;
	    
	}	
	
	
	
	
	
	function add_suggestions()
	{
  $DB1 = $this->load->database('umsdb', TRUE); 	   
  
  $sugg['student_id']=$_SESSION['name'];
  $sugg['suggestion']= $_POST['sugg']; 
  $sugg['category']= $_POST['upstatus'];
    $sugg['role_id']=$_SESSION['role_id'];  
  
  $sugg['added_by']=$_SESSION['name'];  
  $sugg['added_on']= date("Y-m-d H:i:s");
  $sugg['added_by_ip']=$_SERVER['REMOTE_ADDR'];    
  
	$DB1->insert('student_suggestions',$sugg);
		redirect('Attendance/suggestions');	    
	}	
	
	function update_suggestions()
	{

 $DB1 = $this->load->database('umsdb', TRUE); 	   
	    
     $prdet['status']=$_POST['upstatus'];
    $prdet['comment']=$_POST['comment'];  
     
     
    $DB1->where('sugg_id',$_POST['sugg_id']);

	 $DB1->update('student_suggestions',$prdet); 	    

	redirect('Attendance/student_suggestions');	   	    
	    
	}
	
	
	
	
	function getSem($emp_id,$room_no,$curr_sess,$academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $empStreamid =$this->getFacultyStream($emp_id);
        $where=" WHERE academic_year='$academic_year' ";  
        if($room_no!="")
        {
            $where.=" AND faculty_code='".$emp_id."' AND stream_id='".$room_no."'";
            if(!empty($empStreamid) && $empStreamid!='71'){
				$where .=" AND academic_session='".$curr_sess."'";
			}
        }		
        $sql="SELECT distinct semester FROM `lecture_time_table` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
        return $query->result_array();
    }
		// fetch student list
	function getSubjects($emp_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($emp_id!="")
        {
            $where.=" AND faculty_code='".$emp_id."'";
        }		
        $sql="SELECT distinct subject_code FROM `lecture_time_table` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	// fetch student list
	function getEmp_details($emp_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($emp_id!="")
        {
            $where.=" AND faculty_code='".$emp_id."'";
        }		
        $sql="SELECT distinct room_no, semester, subject_code FROM `lecture_time_table` $where";
        $query = $DB1->query($sql);
		echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	// fetch subject list
	function  get_sub_list($stream_id, $semester)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        
        if($stream_id!="")
        {
            $where.=" AND stream_id='".$stream_id."'";
        }
        
		if($semester!="")
        {
            $where.=" AND semester='".$semester."'";
        }
		
        
        $sql="SELECT * FROM `subject_master` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	//
	function markAttendance($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);   
		$DB1->insert('lecture_attendance', $data);
		//echo $DB1->last_query();exit;
		return true;
	}
	function markAttendance_img($data){
		echo '<pre>';print_r($data);exit;
		$DB1 = $this->load->database('umsdb', TRUE);   
		$DB1->insert('lecture_attendance', $data);
		//echo $DB1->last_query();exit;
		return true;
	}
	// check duplicate student 
	function chk_dupbatchToStudent($data){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sem = $data['semester'];
		$batch_code = $data['batch_code'];
		$sub_applied_id = $data['sub_applied_id'];
		$academic_year = $data['academic_year'];
		$sql="SELECT * FROM `student_batch_allocation` where sub_applied_id='$sub_applied_id' and batch_code ='$batch_code' and semester='$sem' and academic_year ='$academic_year' and active='Y'";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		return true;
	}
	//
	 function removeStudent($studId)
	 {
		$DB1 = $this->load->database('umsdb', TRUE);  
		$DB1->where('sub_applied_id', $studId);
		$DB1->delete('student_batch_allocation'); 
		//echo $DB1->last_query();exit;
		return true;
	 } 
	 function get_course_streams($course_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select stream_id,stream_name from vw_stream_details where course_id='" . $course_id . "' ";
        $query = $DB1->query($sql);
        $stream_details = $query->result_array();
		return $stream_details;
    }
	
	function load_subject($room_no, $semesterId, $division, $emp_id,$academic_year) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select distinct t.subject_code, t.division, t.batch_no,s.subject_code as sub_code,s.subject_short_name from lecture_time_table as t  left join subject_master s on s.sub_id = t.subject_code where t.stream_id='" .$room_no. "' and t.semester='" .$semesterId. "' AND t.division='".$division."' AND t.faculty_code='".$emp_id."' AND t.academic_year='$academic_year' order by t.division,t.batch_no";
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();
		return $sub_details;
    }
	// fetch batch allocated student list
	function  get_studbatch_allot_list($subId,$streamId, $semester,$division, $batch, $academic_year,$date='')
    {
		$emp_id = $this->session->userdata("name");
        $DB1 = $this->load->database('umsdb', TRUE); 
		$subdet = $this->getsubdetails($subId);
		//print_r($subdet);exit;
		if($subdet[0]['subject_category']!='VACTT'){
			$chksub = "AND sas.subject_id='$subId'";
		}else{
			$chksub = "";
		}
        $where=" WHERE cancelled_admission ='N' $chksub AND 
		sas.stream_id='$streamId' AND sba.semester='".$semester."' 
		and sba.division='$division' and sba.active='Y'";  
       	if($batch !=0){
			$where .=" and sba.batch='$batch' ";
		}	
		  $course_id=$this->getCourse_ID($streamId);
		 
		if($course_id!=15){
			$where .=" and sba.academic_year='$academic_year' ";
		}
        $sql="SELECT sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,sm.punching_prn,
pa.UserId FROM `student_batch_allocation` as sba 
 join student_applied_subject sas on sas.stud_id=sba.student_id and sas.stream_id=sba.stream_id and sas.semester=sba.semester
 
left join student_master sm on sm.stud_id=sas.stud_id
LEFT JOIN (SELECT UserId FROM sandipun_erp.punching_log WHERE DeviceId IN (SELECT machine_id FROM
 sandipun_erp.student_punching_machines where campus=1) AND STR_TO_DATE(LogDate,'%Y-%m-%d')='$date' 
GROUP BY UserId) AS pa ON sm.punching_prn=pa.UserId 


  $where";
		$sql .=" GROUP BY sm.enrollment_no order by sm.enrollment_no asc";//trim(sm.first_name)
		
		
        $query = $DB1->query($sql);
		
			//echo $DB1->last_query();exit;
			//$query = $DB1->query($sql);
		if($emp_id==110390){
		//echo $DB1->last_query(); exit();
		}
        return $query->result_array();
    }
	function getSlots() {
		$DB1 = $this->load->database('umsdb', TRUE); 
        $sql = "SELECT * FROM lecture_slot";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	// fetch batch allocated student list
	function fetchAbsentStud($sub_code, $today, $slot, $emp_id,$sem_id,$division, $batch)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 AND sm.cancelled_admission='N' and sba.active='Y' and sm.allow_for_attendance_sms='Y' ";  //and pd.subscribe_for_sms='Y'
        
        if($sub_code!="")
        {
            $where.=" AND la.subject_id ='".$sub_code."' and la.is_present='N' and la.attendance_date='".$today."' AND la.slot='".$slot."' AND la.faculty_code='".$emp_id."' AND la.semester='".$sem_id."' AND sba.semester='".$sem_id."' and la.division='$division' and la.batch='$batch'"; // fashion student id not selected for absent sms
        }
		
        $sql="SELECT sba.roll_no, la.attendance_id, sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,la.is_present, pd.parent_mobile2, pd.subscribe_for_sms FROM lecture_attendance la  
		left join student_batch_allocation sba on sba.student_id=la.student_id 
		left join student_master sm on sm.stud_id=la.student_id 
		left join parent_details pd on pd.student_id=sm.stud_id $where";
		
		$sql .= " group by sm.stud_id order by sba.roll_no, sm.enrollment_no";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();//exit;
        return $query->result_array();
    }
	// check duplicate
	function check_dup_attendance($today, $slot,$emp_id,$sem_id, $division, $batch,$sub_code,$stream_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 

        $where.="WHERE batch ='".$batch."' AND division ='".$division."'  AND attendance_date ='".$today."' AND slot='".$slot."' AND faculty_code='".$emp_id."' AND semester='".$sem_id."' and subject_id='".$sub_code."' and stream_id='".$stream_id."'";
		
        $sql="SELECT * from lecture_attendance $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	// load slots
	function load_slot_old($room_no, $semesterId, $emp_id, $academic_year,$subject_id,$division) {
        $DB1 = $this->load->database('umsdb', TRUE);
		/*if($room_no=138){
			$academic_year='2019-20';
		}*/
		$date = date('Y-m-d');
	    $day = date('l', strtotime($date));
        $sql = "select distinct t.lecture_slot, s.from_time, s.to_time, s.slot_am_pm,s.lect_slot_id from lecture_time_table as t left join lecture_slot s on s.lect_slot_id =t.lecture_slot where s.is_active='Y' AND t.stream_id='" .$room_no. "' and t.semester='" .$semesterId. "' AND t.academic_year='$academic_year'  and t.division='$division' and t.subject_code='$subject_id' and t.faculty_code='$emp_id' and t.wday='".$day."' order by s.from_time";
		//and t.subject_code='$subject_id' and t.faculty_code='$emp_id'
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();exit;
		return $sub_details;
    }
	function load_slot($room_no, $semesterId, $emp_id, $academic_year, $subject_id, $division,$batch) {
                $DB1 = $this->load->database('umsdb', TRUE);
                
                $date = date('Y-m-d');
				//$date = '2025-02-17';
                $day = date('l', strtotime($date));
        
                // SQL Query with UNION ALL
                $sql = "SELECT DISTINCT 
                                        t.lecture_slot, 
                                        s.from_time, 
                                        s.to_time, 
                                        s.slot_am_pm, 
                                        s.lect_slot_id 
                                FROM lecture_time_table AS t 
                                LEFT JOIN lecture_slot s ON s.lect_slot_id = t.lecture_slot 
                                WHERE s.is_active = 'Y' 
                                AND t.stream_id = '".$room_no."' 
                                AND t.semester = '".$semesterId."' 
                                AND t.academic_year = '".$academic_year."' 
                                AND t.division = '".$division."' 
                                AND t.subject_code = '".$subject_id."' 
                                AND t.faculty_code = '".$emp_id."' 
                                AND t.wday = '".$day."'
								AND t.batch_no = '".$batch."'
        
                UNION ALL
        
                SELECT DISTINCT 
                                        att.lecture_slot, 
                                        s.from_time, 
                                        s.to_time, 
                                        s.slot_am_pm, 
                                        s.lect_slot_id 
                                FROM alternet_lecture_time_table AS att 
                                LEFT JOIN lecture_slot s ON s.lect_slot_id = att.lecture_slot 
                                WHERE s.is_active = 'Y' 
                                AND att.stream_id = '".$room_no."' 
                                AND att.semester = '".$semesterId."' 
                                AND att.academic_year = '".$academic_year."' 
                                AND att.division = '".$division."' 
                                AND att.subject_code = '".$subject_id."' 
                                AND att.faculty_code = '".$emp_id."' 
                                AND att.wday = '".$day."'
                                AND att.dt_date = '".$date."'
								AND att.batch_no = '".$batch."'
        
                ORDER BY from_time";
        
                $query = $DB1->query($sql);
                $sub_details = $query->result_array();
        
        //        echo $DB1->last_query(); exit; // Debugging purpose, remove in production
        
                return $sub_details;
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
	//load division
	function load_division($room_no, $semesterId, $emp_id, $academic_year) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select distinct division from lecture_time_table where stream_id='" .$room_no. "' and semester='" .$semesterId. "' 
		AND faculty_code='".$emp_id."' AND academic_year='$academic_year' order by division";
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();
		return $sub_details;
    }
	// added on 04/09/17
	function getFacultySubjects($emp_id, $curr_session,$academic_year) {
        $DB1 = $this->load->database('umsdb', TRUE);
		if($curr_session=='WINTER'){
			$cursession ='WIN';
		}else{
			$cursession ='SUM';
		}
		//$cursession ="'WIN','SUM'";
		$empStreamid =$this->getFacultyStream($emp_id);
        $sql = "select distinct l.subject_id, l.batch,l.division, s.subject_code as sub_code,s.subject_short_name,vw.stream_short_name,l.semester,l.stream_id from lecture_attendance as l 
        left join subject_master s on s.sub_id = l.subject_id 
		left join vw_stream_details vw on vw.stream_id =l.stream_id
		where l.faculty_code='".$emp_id."'";
		if(!empty($empStreamid) && $empStreamid!='71'){
				$sql .=" AND l.academic_session in ('$cursession') AND l.academic_year='".$academic_year."'";
			}else{
				$sql .=" AND l.academic_session in ('WIN','SUM') AND l.academic_year='".$academic_year."'";
			}
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();exit;
		return $sub_details;
    }
	//fetchFacAttDates
	function fetchFacAttDates($subId='',$emp_id='', $batch='', $division='', $academic_year='',$semester='',$stream='') {
		
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT distinct l.`attendance_date`, l.slot, sm.from_time, sm.to_time, sm.slot_am_pm  FROM `lecture_attendance` l 
        left join lecture_slot sm on sm.lect_slot_id = l.slot 
        WHERE l.`subject_id` ='".$subId."' AND l.batch ='".$batch."' AND l.division ='".$division."' AND l.academic_year ='".$academic_year."' and faculty_code='".$emp_id."' and semester='".$semester."' and stream_id='".$stream."' 
        order by attendance_date, sm.lect_slot_id asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
    }
	//fetchFacAttPresent
	function fetchFacAttPresent($attendance_date,$subId,$emp_id,$slot, $division, $batch, $academic_year,$semester,$stream) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT count(*) as present  FROM `lecture_attendance` WHERE attendance_date ='".$attendance_date."' and `subject_id` ='".$subId."' and faculty_code='".$emp_id."' AND slot='".$slot."' AND batch ='".$batch."' AND division ='".$division."' AND academic_year ='".$academic_year."' and semester='".$semester."' and stream_id='".$stream."' and is_present='Y' order by attendance_date asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
    }
	//fetchFacAttAbsent
	function fetchFacAttAbsent($attendance_date,$subId,$emp_id,$slot, $division, $batch, $academic_year,$semester,$stream) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT count(*) as absent  FROM `lecture_attendance` WHERE attendance_date ='".$attendance_date."' and `subject_id` ='".$subId."' and faculty_code='".$emp_id."' AND slot='".$slot."' AND batch ='".$batch."' AND division ='".$division."' AND academic_year ='".$academic_year."' and is_present='N' and semester='".$semester."' and stream_id='".$stream."' order by attendance_date asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
    }
	//fetchFacAttDates
	function getStreamName($streamCode) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT stream_name FROM `vw_stream_details` WHERE `stream_id` ='".$streamCode."'";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		return $res;
    }
	
	// fetch batch allocated student list
	function fetchDateSlotwiseAttDetails($att_date,$sub_id,$slot,$emp_id,$sem, $academic_year,$div,$batch)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 AND sm.cancelled_admission='N' and sba.active='Y' ";  
        
        if($att_date!="")
        {
            $where.=" AND la.subject_id ='".$sub_id."' and la.attendance_date='".$att_date."' AND la.slot='".$slot."' AND la.faculty_code='".$emp_id."' AND sba.semester ='".$sem."' AND la.academic_year ='".$academic_year."'";
        }
		if($div !=''){
			$where.=" AND la.division ='".$div."'";
		}
		if($batch !=''){
			$where.=" AND la.batch ='".$batch."'";
		}
        $sql="SELECT sba.roll_no, sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,la.is_present FROM `lecture_attendance` as la  
		left join student_master sm on sm.stud_id=la.student_id 
		left join student_batch_allocation sba on sba.student_id=la.student_id $where";
		$sql.=" group by sm.stud_id order by sba.roll_no, sm.enrollment_no ";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
// added 06/09/17
	// fetch student subject 
	function fetch_student_subjects($enrollment_no,$current_semester)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT `sm`.stud_id,`sm`.form_number,`sm`.enrollment_no,`sm`.first_name,`sm`.middle_name,sm.current_semester,`sm`.last_name,`sm`.mobile,`sm`.admission_stream, `stm`.`stream_name`, `stm`.`course_name`, `stm`.`course_short_name`, `s`.`stream_id` as `strmId`, `sba`.`batch`,s.subject_code,s.subject_name, s.subject_short_name,s.sub_id FROM `student_master` as `sm` LEFT JOIN `vw_stream_details` as `stm` ON `sm`.`admission_stream` = `stm`.`stream_id` 
		LEFT JOIN `student_applied_subject` as `sas` ON `sas`.`stud_id` = `sm`.`stud_id` and sas.semester=sm.current_semester LEFT JOIN `subject_master` as `s` ON `s`.`sub_id` = `sas`.`subject_id` and sas.semester=s.semester LEFT JOIN `student_batch_allocation` as `sba` ON `sba`.`student_id` = `sas`.`stud_id` and sba.semester=sm.current_semester WHERE `enrollment_no` = '".$enrollment_no."' AND s.semester='".$current_semester."' AND sm.cancelled_admission='N'  ORDER BY `sm`.`stud_id` DESC";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	//fetchstudAttDates
	function fetchStudAttDates($enrollment_no,$current_semester) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT distinct l.`attendance_date`, s.stud_id FROM `lecture_attendance` l left join lecture_slot sm on sm.lect_slot_id = l.slot left join student_master s on s.stud_id=l.student_id WHERE s.enrollment_no='".$enrollment_no."' and l.semester='".$current_semester."' order by attendance_date asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
    }
	//fetchStudAttPresent
	function fetchStudAttPresent($attendance_date,$subId,$studId) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT count(*) as present  FROM `lecture_attendance` WHERE attendance_date ='".$attendance_date."' and `subject_id` ='".$subId."' and student_id='".$studId."' and is_present='Y' order by attendance_date asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
    }
	//fetchStudAttPresent
	function fetchStudAttTotLecture($attendance_date,$subId,$studId) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT count(*) as totlect  FROM `lecture_attendance` WHERE attendance_date ='".$attendance_date."' and `subject_id` ='".$subId."' and student_id='".$studId."' order by attendance_date asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
    }
		//fetchStudAttAbsent
	function fetchStudAttAbsent($attendance_date,$subId,$studId) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT count(*) as absentlect  FROM `lecture_attendance` WHERE attendance_date ='".$attendance_date."' and `subject_id` ='".$subId."' and student_id='".$studId."' and is_present='N' order by attendance_date asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
    }
	//student details
	function fetch_stud_details($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name, stm.course_name,stm.course_short_name,stm.stream_short_name, s.stream_id as strmId, sba.batch,sba.division,stm.course_id");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('student_applied_subject as sas','sas.stud_id = sm.stud_id','left');
		$DB1->join('subject_master as s','s.sub_id = sas.subject_id','left');
		$DB1->join('student_batch_allocation as sba','sba.student_id = sas.stud_id','left');
		$DB1->where('enrollment_no', $stud_id);
		$DB1->where('cancelled_admission', 'N');
		$DB1->where('actice_status', 'Y');
		$DB1->group_by("s.stream_id");
		$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}	
	// added on 20/09/17
	function fetch_slot_attendance($slot_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($slot_id!="")
        {
            $where.=" AND lect_slot_id ='".$slot_id."'";
        }		
        $sql="SELECT from_time, to_time, slot_am_pm FROM `lecture_slot` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	//
	function fetch_subject_attendance($sub_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($sub_id!="")
        {
            $where.=" AND sub_id ='".$sub_id."'";
        }		
        $sql="SELECT subject_short_name, subject_code, subject_component FROM `subject_master` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
// added on 210917
	// load sem for attendance report	
	function getSemReport($room_no)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($room_no!="")
        {
            $where.=" AND stream_id='".$room_no."'";
        }		
        $sql="SELECT distinct semester FROM `lecture_time_table` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
        return $query->result_array();
    }
	//load division for report
	function load_division_report($room_no, $semesterId) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select distinct division from lecture_time_table where stream_id='" .$room_no. "' and semester='" .$semesterId. "' 
		order by division";
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();
		return $sub_details;
    }
	//load subjects for report.
	function load_subject_report($streamID, $semesterId, $division, $academic_year) {
        $DB1 = $this->load->database('umsdb', TRUE);
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $sql = "select distinct t.subject_code,t.semester,t.stream_id,t.division,t.batch_no, s.subject_code as sub_code,s.subject_short_name,s.subject_name, f.fname,f.mname,f.lname,f.emp_id,t.faculty_code from lecture_time_table as t left join vw_stream_details vw on vw.stream_id =t.stream_id left join subject_master s on s.sub_id = t.subject_code left join vw_faculty f on f.emp_id = t.faculty_code where t.stream_id='" .$streamID. "' and t.semester='" .$semesterId. "' AND t.division='".$division."' AND t.academic_session='".$cur_ses."' AND t.academic_year='".$acd_yr[0]."'  and t.subject_code !='OFF' order by t.subject_code,t.division,t.batch_no asc";
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();exit;
		return $sub_details;
    }
	
	function getFaqSubjectBatchesReport($subId, $batchcode)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($subId!="")
        {
            $where.=" AND subject_id ='".$subId."' and batch_code LIKE '%".$batchcode."%'";
        }		
        $sql="SELECT distinct batch_code FROM `lecture_attendance` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	//
	function getNoOfLectureReport($subId, $from_date, $to_date, $division, $batch,$streamID,$semester,$faculty_code,$academic_year)
    {
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($subId!="")
        {
            $where.=" AND subject_id ='".$subId."' AND faculty_code='".$faculty_code."' AND division='".$division."' AND a.batch='".$batch."' AND a.academic_session='$cur_ses' and a.academic_year='$acd_yr[0]' and a.semester='$semester' and a.stream_id='$streamID'";
        }
		if($from_date!="")
        {
            $where.=" AND attendance_date BETWEEN '".$from_date."' AND '".$to_date."'";
        }		
        $sql="SELECT a.attendance_date, count(a.student_id) as studCNT, a.division,a.batch, s.subject_code as sub_code, s.subject_short_name FROM `lecture_attendance` a left join subject_master s on s.sub_id = a.subject_id $where";
		$sql.=" group by attendance_date, slot";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	// fetch avgPerOfSubjectReport
	function avgPerOfSubjectReport($subId, $from_date, $to_date, $division, $batch,$streamID,$semester,$faculty_code,$academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $where=" WHERE 1=1 ";  
        if($subId!="")
        {
            $where.=" AND subject_id ='".$subId."' AND faculty_code='".$faculty_code."' AND division='".$division."' AND batch='".$batch."' AND academic_session='$cur_ses' and academic_year='$acd_yr[0]' and semester='$semester' and stream_id='$streamID'";
        }
		if($from_date!="")
        {
            $where.=" AND attendance_date BETWEEN '".$from_date."' AND '".$to_date."'";
        }		
        $sql="SELECT sum(case when is_present='N' then 0 else 1 end) as totPersent, count(*) as totstudents FROM `lecture_attendance` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	// fetch streams list
	function getstreams($emp_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($emp_id!="")
        {
            $where.=" AND t.faculty_code='".$emp_id."'";
        }		
        $sql="SELECT distinct t.stream_id, vw.stream_code, vw.course_short_name, vw.stream_name FROM `lecture_time_table` t left join vw_stream_details vw on vw.stream_id =t.stream_id $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function getFaqSubjects($emp_id, $acd_session, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
		if($acd_session=='WINTER'){
			$cursession ='WIN';
		}else{
			$cursession ='SUM';
		}
        if($emp_id!="")
        {
            $where.=" AND t.faculty_code='".$emp_id."' AND t.academic_session ='".$cursession."' AND t.academic_year ='".$academic_year."' group by t.subject_code,t.semester,t.stream_id,t.division, t.batch_no";
        }		
        $sql="SELECT t.subject_code,sum(slt.duration) as lect_load, count(slt.lect_slot_id) as slotcnt, s.subject_code as sub_code,s.subject_name,s.subject_component,vw.stream_short_name,s.sub_id,t.semester,t.stream_id, f.fname,f.mname,f.lname, t.division, t.batch_no FROM `lecture_time_table` t 
		left join lecture_slot slt on slt.lect_slot_id = t.`lecture_slot`
		left join subject_master s on s.sub_id = t.subject_code 
		left join vw_stream_details vw on vw.stream_id =t.stream_id
		left join vw_faculty f on f.emp_id = t.faculty_code $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function getFaqSubjectBatches($emp_id,$subId,$subject_component)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($emp_id!="")
        {
            $where.=" AND faculty_code='".$emp_id."' AND subject_code ='".$subId."'";
        }	
		if($subject_component=='EM'){
			$where.=" AND batch_no='0'";
		}
        $sql="SELECT distinct division, batch_no as batch,semester FROM `lecture_time_table` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function getFaqSubjectBatches_2019($emp_id,$subId,$subject_component)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($emp_id!="")
        {
            $where.=" AND faculty_code='".$emp_id."' AND subject_code ='".$subId."'";
        }	
		if($subject_component=='EM'){
			$where.=" AND batch_no='0'";
		}
        $sql="SELECT distinct division, batch_no as batch,semester FROM `lecture_time_table` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function getNoOfLecture($emp_id,$subId, $from_date, $to_date, $division, $batch, $academic_session, $academic_year,$stream='',$semester='')
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		if($academic_session=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $where=" WHERE 1=1 ";  
        if($emp_id!="")
        {
            $where.=" AND a.subject_id ='".$subId."' AND a.faculty_code='".$emp_id."' AND a.division='".$division."' AND a.batch='".$batch."' AND a.academic_session='$cur_ses' and a.academic_year='$academic_year' and a.stream_id='$stream' and a.semester='$semester'";
        }
		if($from_date!="")
        {
            $where.=" AND attendance_date BETWEEN '".$from_date."' AND '".$to_date."'";
        }		
        $sql="SELECT distinct a.attendance_date, a.slot, count(a.student_id) as studCNT FROM `lecture_attendance` a left join subject_master s on s.sub_id = a.subject_id $where";
		$sql.=" group by a.attendance_date, a.slot";
        $query = $DB1->query($sql);
			if($subId==18150){	
		//echo $DB1->last_query();exit;
			}
        return $query->result_array();
    }
	function avgPerOfSubject($emp_id,$subId, $from_date, $to_date, $division, $batch, $academic_session, $academic_year,$stream='',$semester='')
    {
        $DB1 = $this->load->database('umsdb', TRUE);
		if($academic_session=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}		
        $where=" WHERE 1=1 ";  
        if($emp_id!="")
        {
            $where.=" AND subject_id ='".$subId."' AND faculty_code='".$emp_id."' AND division='".$division."' AND batch='".$batch."' AND academic_session='$cur_ses' and academic_year='$academic_year' and stream_id='$stream' and semester='$semester'";
        }
		if($from_date!="")
        {
            $where.=" AND attendance_date BETWEEN '".$from_date."' AND '".$to_date."'";
        }		
        $sql="SELECT sum(case when is_present='N' then 0 else 1 end) as totPersent FROM `lecture_attendance` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	//
	function getStreamCode($streamCode) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT stream_code FROM `vw_stream_details` WHERE `stream_id` ='".$streamCode."'";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		return $res;
    }
	
	//delete attendance of faculty
	function DeleteAttendanceEntry($attendance_date, $slot,$sem_id,$emp_id, $division,$batch,$academic_year)
	 {	
		$DB1 = $this->load->database('erpdel', TRUE);  
		$where = " attendance_date='$attendance_date' AND batch='$batch' and division='$division' and academic_year='$academic_year' AND semester='$sem_id' AND slot ='$slot' AND faculty_code='$emp_id'";
		$DB1->where($where);
		$DB1->delete('lecture_attendance'); 
		//echo $DB1->last_query();exit;
		return true;
	 }
////////////////////////////////
	function fetchFaqSubjectsAttendance($emp_id, $sub_id, $division, $batch, $stream, $sem, $academic_session, $academic_year){
		$DB1 = $this->load->database('umsdb', TRUE);
		if($academic_session=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$where=" WHERE 1=1 ";  
        $where.= " AND l.`subject_id` ='".$sub_id."' and l.faculty_code='".$emp_id."' and l.semester='$sem'";

         $where.=" AND l.division='".$division."' AND l.batch='".$batch."' AND l.stream_id='".$stream."' AND l.academic_year='".$academic_year."' and sba.active='Y'";
		 if($stream !=71){
			  $where.=" AND l.academic_session='".$cur_ses."'";
		 }
		  $where.=" AND l.division='".$division."' AND l.batch='".$batch."' AND l.stream_id='".$stream."' AND l.academic_year='".$academic_year."' AND l.academic_session='".$cur_ses."' and sba.active='Y'";
	
         $sql = "SELECT sm.first_name, sm.middle_name, sm.last_name,sm.stud_id, sba.roll_no,sm.enrollment_no, l.student_id FROM `lecture_attendance` as l 
		LEFT JOIN student_batch_allocation sba on sba.student_id = l.student_id and sba.academic_year=l.academic_year and sba.semester=l.semester
		LEFT JOIN student_master sm on sm.stud_id = l.student_id
		$where group by sm.stud_id order by sba.roll_no asc ";
			
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();
		//exit;
		return $res;
	}
	// fetch attendance dates
	function fetchFaqAttendanceDates($emp_id, $sub_id, $division, $batch, $stream_id,$fromdate, $todate, $academic_session, $academic_year){
		if($academic_session=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$DB1 = $this->load->database('umsdb', TRUE);
		
        $sql = "SELECT distinct l.attendance_date, l.slot FROM `lecture_attendance` as l WHERE l.`subject_id` ='".$sub_id."' and l.faculty_code='".$emp_id."' and l.division='".$division."' and l.batch='".$batch."'and l.stream_id='".$stream_id."' AND l.academic_year='".$academic_year."'";
		if($stream_id !=71){
			  $sql.=" AND l.academic_session='".$cur_ses."'";
		 }
		 
		if($fromdate !='' && $todate !=''){
			$sql .=" and attendance_date between '".$fromdate."' AND '".$todate."'";
		}
		
		$sql .=" order by l.attendance_date asc";
		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
	// check student attendence
	function check_attendance($dname,$slotId, $student_id, $subId){
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($emp_id!="")
        {
            $where.=" AND faculty_code='".$emp_id."' AND attendance_date='".$dname."' AND slot='".$slotId."' AND subject_id ='".$subId."' AND student_id ='".$student_id."'";
        }		
        $sql="SELECT is_present FROM `lecture_attendance` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();//exit;
        return $query->result_array();
	}
	// checkConsolidatedAttendance of student
	 function checkConsolidatedAttendance($student_id, $subId,$division,$batch,$stream_id,$sem,$academic_session, $academic_year){
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($emp_id!="")
        {
            $where.=" AND subject_id ='".$subId."' AND student_id ='".$student_id."' AND division='".$division."' AND semester='".$sem."' AND stream_id='".$stream_id."' AND academic_session='".$academic_session."' AND academic_year='".$academic_year."'";
			//AND batch='".$batch."'
        }		
        $sql="SELECT is_present FROM `lecture_attendance` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();echo "<br>";exit;
        return $query->result_array();
	}	
		// fetch subject details
	function  get_subject_details($sub_id='',$stream_id,$sem, $division, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $where=" WHERE 1=1 ";  
        //echo $stream_id; exit;
		if($stream_id!="")
        {
            $where.=" AND l.stream_id='".$stream_id."' AND l.semester='".$sem."' AND l.division='".$division."' and l.academic_session='$cur_ses' and l.academic_year='$acd_yr[0]' AND l.subject_code not in('OFF','Library')";
        }
        
        $sql="SELECT sm.subject_code,sm.sub_id,sm.subject_short_name,sm.subject_name,st.type_name,l.semester, l.division,l.batch_no,l.stream_id, l.academic_year,l.academic_session FROM lecture_time_table l 
		left join `subject_master` as sm on sm.sub_id = l.subject_code
		left join subject_type as st on st.sub_type_id= sm.subject_type $where group by l.subject_code order by sm.subject_code asc";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }

      public  function  countstudentappliedsubject($stud_id='',$stream_id,$sem, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $where=" WHERE 1=1 ";  
        //echo $stream_id; exit;
		if($stream_id!="")
        {
            $where.=" AND l.stream_id='".$stream_id."' AND l.semester='".$sem."'  and l.academic_year='$acd_yr[0]' AND l.stud_id='".$stud_id."'";
        }
        
        $sql="SELECT count(subject_id) as cnt from student_applied_subject as l $where group by l.stud_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
		//exit;
        return $query->result_array();
    }
	// fetch subject
	function getSubjectName($subId){
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT subject_short_name, subject_code FROM `subject_master` WHERE `sub_id` ='".$subId."'";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
	// fetch current session
	function getCurrentSession(){
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT * FROM `academic_session` WHERE `currently_active` ='Y' order by id desc limit 0, 1";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
	function getCurrentSession_for_marks_entry(){
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT * FROM `academic_session` WHERE active_for_marks_entry='Y' order by id desc limit 0, 1";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
	// fetch Faculty Stream
	function getFacultyStream($emp_id,$academic_year=''){
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT distinct stream_id FROM `lecture_time_table` WHERE `faculty_code` = '".$emp_id."'";	
		if(!empty($academic_year)){
			$sql .= " and academic_year = '".$academic_year."'";
		}
		$sql .= " order by stream_id asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res[0]['stream_id'];
	}
	
	function getCourse_ID($stream_id){
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT distinct course_id FROM `vw_stream_details` WHERE `stream_id` = '".$stream_id."'";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res[0]['course_id'];
	}
	// fetch stream from attendance table
	function get_attendance_streams($course_id, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$this->load->model('Subject_model');
		$acd_yr = explode('~',$academic_year);
		$acdyr = explode('-',$acd_yr[0]);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		
		if($course_id==2){
		$sql="SELECT stream_id, stream_code, stream_short_name
FROM vw_stream_details
WHERE 
    (stream_id IN (
        SELECT DISTINCT admission_stream
        FROM student_master
        WHERE academic_year = '".$acdyr[0]."'
    ) 
    OR stream_id = 9) 
    AND course_id = '$course_id' 
    AND stream_short_name IS NOT NULL";
		}else{
			$sql="select stream_id,stream_code,stream_short_name from vw_stream_details where stream_id in(select distinct admission_stream from student_master where academic_year ='".$acdyr[0]."') and course_id ='$course_id' and stream_short_name is not null ";
		}
        //$sql="SELECT distinct l.stream_id, vw.stream_code, vw.stream_short_name, vw.course_short_name, vw.stream_name FROM `lecture_attendance` l inner join vw_stream_details vw on vw.stream_id =l.stream_id and vw.course_id ='$course_id' AND l.academic_session='$cur_ses' and l.academic_year='".$acd_yr[0]."'";
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $sql .=" AND school_code = $schid";
		 }else if(isset($role_id) && $role_id==44){
			 $empsch = $this->Subject_model->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $sql .=" AND school_code = $schid";
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND school_code = $sccode";
		}

			$sql .=" group by stream_id";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
    // fetch semester from attendance table
    function getSemfromAttendance($stream_id, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $acd_yr = explode('~',$academic_year);
        $acdyr = explode('-',$acd_yr[0]);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $where=" WHERE 1=1 ";  
        if($stream_id!="" && $stream_id!=9 && $stream_id!=234)
        {
			
            $where.=" AND admission_stream='".$stream_id."'  and academic_year='$acdyr[0]'";
			$sql="SELECT distinct current_semester as semester FROM `student_master` $where order by semester asc";
        }
		else if($stream_id!="" && $stream_id==234)
        {
			
            $where.=" AND admission_stream='26'  and academic_year='$acdyr[0]'";
			$sql="SELECT distinct current_semester as semester FROM `student_master` $where order by semester asc";
        }
		
		else{
			
			$where.=" AND admission_stream in(5,6,7,8,10)  and academic_year='$acdyr[0]'";
			$sql="SELECT distinct current_semester as semester FROM `student_master` $where order by semester asc";
		}		
        
        $query = $DB1->query($sql);
		//echo $DB1->last_query();
        return $query->result_array();
    } 
	//////////////////////////////////////Faculty Reports/////////////////////////////////////////////////////////////////////////
	function get_faculty_schools()
    {
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT distinct emp_school,college_code FROM `vw_faculty` order by college_code asc";
        $query = $DB1->query($sql);
        return $query->result_array();
    } 
    function load_faculty_departments($school_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT distinct department,department_name FROM `vw_faculty` where emp_school='".$school_id."' order by department_name asc";
        $query = $DB1->query($sql);
        //echo $DB1->last_query();
        return $query->result_array();
    }

    function getallSession(){
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT * FROM `academic_session` where currently_active='Y' order by academic_year desc";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	} 
	// facultywise attendance
	function facultywise_attendance_old($var){
		$academic_year =$var['academic_year'];
		$school_id =$var['school_id'];
		$department_id =$var['department_id'];
		$from_date =$var['from_date'];
		$to_date =$var['to_date'];
		
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "select t.faculty_code, f.college_code,f.designation_name,f.fname,f.mname,f.lname,f.department_name,f.college_name, sum(slt.duration) as totload, a.lacture_load, la.att_percentage,la.tot_students,la.totPersent  
		from lecture_time_table t 
		left join vw_faculty f on f.emp_id = t.faculty_code 
		left join lecture_slot slt on slt.lect_slot_id = t.`lecture_slot` 
		left join (select l.faculty_code, sum(st.duration) as lacture_load from (SELECT faculty_code,attendance_date,slot, subject_id,stream_id,semester, division,batch FROM `lecture_attendance` l WHERE l.`academic_year` = '$academic_year' GROUP BY l.faculty_code,l.`attendance_date`, l.slot,l.subject_id,l.stream_id,l.semester, l.division,l.batch) l 
		left join lecture_slot st on st.lect_slot_id = l.`slot` ) as a on a.faculty_code = t.faculty_code 
		left join (SELECT faculty_code, count(*) as tot_students, sum(case when is_present='Y' then 1 else 0 end) as totPersent, (sum(case when is_present='Y' then 1 else 0 end)/count(*)) *100 as att_percentage FROM `lecture_attendance` WHERE `academic_year` = '2018-19' GROUP BY faculty_code) as la on la.faculty_code=t.faculty_code 
		where t.academic_year='$academic_year' and t.faculty_code IS NOT NULL ";	

		if(!empty($school_id)){
			$sql .=" and f.emp_school='".$school_id."' ";
		}
		if(!empty($department_id)){
			$sql .=" and f.department='".$department_id."' ";
		}
		if(!empty($from_date) && !empty($to_date)){
			$sql .=" and l.attendance_date between $from_date and $to_date ";
		}
		$sql .=" group by t.faculty_code";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
// fetch batch allocated student list
	function  getStudBatchAllotList($stream_id,$semester, $division,$academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $where=" WHERE sba.stream_id='$stream_id' AND sba.semester='".$semester."' and sba.division='$division' and sba.academic_year='$acd_yr[0]' AND sm.cancelled_admission='N' and sba.active='Y'";
        $sql="SELECT sm.stud_id, sba.roll_no, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile, sba.division,sba.batch,sba.stream_id,v.stream_name, sba.semester FROM `student_batch_allocation` as sba 
        left join student_master sm on sm.stud_id=sba.student_id 
        left join vw_stream_details v on v.stream_id=sba.stream_id 
        $where";
		$sql .= "group by sm.enrollment_no order by sba.roll_no";//and sba.student_id='15763'
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }

// facultywise attendance
	function facultywise_attendance($var){
		$acd_session = explode('~', $var['academic_year']);
		$academic_year =$acd_session[0];

		if($acd_session[1]=='WINTER'){
			$academic_sess ='WIN';
		}else{
			$academic_sess ='SUM';
		}

		$school_id =$var['school_id'];
		$department_id =$var['department_id'];
		$from_date =$var['from_date'];
		$to_date =$var['to_date'];
		
		$DB1 = $this->load->database('umsdb', TRUE);

		$sql11="SELECT faculty_code, count(*) as tot_students, sum(case when is_present='Y' then 1 else 0 end) as totPersent, (sum(case when is_present='Y' then 1 else 0 end)/count(*)) *100 as att_percentage FROM `lecture_attendance` WHERE `academic_year` = '".$academic_year."' and academic_session='".$academic_sess."'";
		if(!empty($from_date) && !empty($to_date)){
			$sql11 .=" and attendance_date between '$from_date' and '$to_date'";
		}
		$sql11 .=" GROUP BY faculty_code";
		//echo $sql11;exit;
        $sql = "select t.faculty_code, sum(slt.duration) as tot_lecture_load,count(t.lecture_slot) as cnt_slot, f.college_code,f.college_name,f.designation_name,f.fname,f.mname,f.lname,f.department_name, la.att_percentage,la.tot_students,la.totPersent  
		from lecture_time_table t 
		left join lecture_slot slt on slt.lect_slot_id = t.`lecture_slot` 
		left join vw_faculty f on f.emp_id = t.faculty_code 		
		left join ($sql11) as la on la.faculty_code=t.faculty_code 
		where t.academic_year='".$academic_year."' and t.academic_session='".$academic_sess."' and t.faculty_code IS NOT NULL and f.college_code IS NOT NULL";	

		if(!empty($school_id)){
			$sql .=" and f.emp_school='".$school_id."' ";
		}
		if(!empty($department_id)){
			$sql .=" and f.department='".$department_id."' ";
		}
		if(!empty($from_date) && !empty($to_date)){
			//$sql .=" and la.attendance_date between '$from_date' and '$to_date' ";
		}
		$sql .=" group by t.faculty_code";
		//echo $sql;exit;
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}

    	// facultywise attendance
	function fetch_fac_tot_load($fac_code, $academic_year){	
		//echo $academic_year;exit;
		$acd_session = explode('~',  $academic_year);
		$academic_year =$acd_session[0];

		if($acd_session[1]=='WINTER'){
			$academic_sess ='WIN';
		}else{
			$academic_sess ='SUM';
		}	
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT sum(duration)  as tot_lect_load FROM `lecture_time_table` t 
        left join lecture_slot slt on slt.lect_slot_id = t.`lecture_slot` 
        WHERE t.`academic_year` = '$academic_year' AND t.`academic_session` = '$academic_sess' AND t.`faculty_code` = '$fac_code'";	
		//$sql .=" ";exit;
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}	
	function fetch_fac_taken_lect_load($fac_code, $academic_year, $from_date,$to_date){	
		$acd_session = explode('~',  $academic_year);
		$academic_year =$acd_session[0];

		if($acd_session[1]=='WINTER'){
			$academic_sess ='WIN';
		}else{
			$academic_sess ='SUM';
		}		
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql1="SELECT slt.duration,l.attendance_date FROM `lecture_attendance` l
        left join lecture_slot slt on slt.lect_slot_id = l.`slot` 
        WHERE l.`academic_year` = '$academic_year' AND l.`academic_session` = '$academic_sess' AND l.`faculty_code` = '$fac_code'  ";	
		if(!empty($from_date) && !empty($to_date)){
			$sql1 .=" and l.attendance_date between '$from_date' and '$to_date' ";
		}
		$sql1 .=" group by l.subject_id,l.division,l.batch,l.attendance_date, l.slot ";
        $sql = "SELECT sum(a.duration) as taken_lect_load, count(attendance_date) as lecttaken from ($sql1) as a";			
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}

	function getNoOfLectureTaken($emp_id,$subId, $from_date, $to_date, $division, $batch, $academic_session, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		if($academic_session=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql1 = "SELECT distinct a.attendance_date, a.slot, count(a.student_id) as studCNT,slt.duration FROM `lecture_attendance` a left join lecture_slot slt on slt.lect_slot_id = a.`slot` left join subject_master s on s.sub_id = a.subject_id WHERE a.subject_id ='".$subId."' AND a.faculty_code='".$emp_id."' AND a.division='".$division."' AND a.batch='".$batch."' AND a.academic_session='$cur_ses' and a.academic_year='".$academic_year."' ";
		if(!empty($from_date) && !empty($to_date)){
			$sql1 .=" and a.attendance_date between '$from_date' and '$to_date' ";
		}
		$sql1 .= " group by a.attendance_date, a.slot";
        $sql="select sum(b.duration) no_of_lect_taken, count(b.attendance_date) as cnt_of_lect, b.studCNT from ($sql1) b";
		
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	
	function load_lecture_cources($academic_year){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$acd_yr = explode('~',$academic_year);
		$acdyr = explode('-',$acd_yr[0]);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql="select course_id,course_short_name from vw_stream_details where stream_id in(select distinct admission_stream from student_master where academic_year ='$acdyr[0]') and course_name is not null ";
		//$sql = "select distinct vw.course_id,vw.course_short_name from lecture_attendance t left join vw_stream_details vw on vw.stream_id = t.stream_id where t.academic_year ='$acd_yr[0]' and t.academic_session='$cur_ses' and vw.course_name is not null ";
		if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql .=" AND school_code = $sccode";
			}
		$sql .=" group by course_id order by course_id asc";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();
		$stream_details = $query->result_array();
		return $stream_details;
	}
	function load_division_by_acdmicyear($room_no, $semesterId,$academic_year) {
        $DB1 = $this->load->database('umsdb', TRUE);
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $sql = "select distinct division from lecture_time_table where stream_id='" .$room_no. "' and semester='" .$semesterId. "' and academic_year ='$acd_yr[0]' and academic_session='$cur_ses' order by division";
		//AND t.faculty_code='".$emp_id."'
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();exit;
		return $sub_details;
    }	
	function getFacultySubjects_for_markattendance_old($emp_id, $curr_session,$academic_year){
        $DB1 = $this->load->database('umsdb', TRUE);
		$arr_faq = array();
		if(in_array($emp_id, $arr_faq)){
			$cursession ="'WIN','SUM'";
			$academic_year='2023-24';
		}else{
			if($curr_session=='WINTER'){
				$cursession ="'WIN'";
			}else{
				$cursession ="'SUM'";
			}
			//$cursession ="'WIN','SUM'";
		}
		$date = date('Y-m-d');
	    $day = date('l', strtotime($date));
		$empStreamid =$this->getFacultyStream($emp_id,$academic_year);
		
        $sql = "select distinct t.subject_code as subject_id,t.subject_type, t.batch_no as batch,t.division, s.subject_code as sub_code,s.subject_short_name,vw.stream_short_name,t.semester,t.stream_id from lecture_time_table as t 
        left join subject_master s on s.sub_id = t.subject_code and s.is_active='Y' 
		left join vw_stream_details vw on vw.stream_id = t.stream_id
		where t.faculty_code='".$emp_id."' and t.is_active='Y' and t.wday='".$day."'";
		if(!empty($empStreamid) && $empStreamid!='71'){
				$sql .=" AND t.academic_session in ($cursession) AND t.academic_year='".$academic_year."'";
			}else{
				$sql .=" AND t.academic_session in ('WIN','SUM') AND t.academic_year='".$academic_year."'";
			}
			$sql .=" order by t.division,t.batch_no";
        $query = $DB1->query($sql);
		if($emp_id==110409){
		//echo $DB1->last_query(); exit();
		}

//echo $DB1->last_query(); exit();
        $sub_details = $query->result_array();
		return $sub_details;
    }	
	 function getFacultySubjects_for_markattendance($emp_id, $curr_session, $academic_year) {
                $DB1 = $this->load->database('umsdb', TRUE);
                $arr_faq = array();
        
                if (in_array($emp_id, $arr_faq)) {
                        $cursession = "'WIN','SUM'";
                        $academic_year = '2023-24';
                } else {
                        if ($curr_session == 'WINTER') {
                                $cursession = "'WIN'";
                        } else {
                                $cursession = "'SUM'";
                        }
                }
        
                $date = date('Y-m-d');
				//$date = '2025-02-17';
                $day = date('l', strtotime($date));
                $empStreamid = $this->getFacultyStream($emp_id, $academic_year);
        
                // First Query (Original)
                $sql = "SELECT DISTINCT 
                                        t.subject_code AS subject_id,
                                        t.subject_type,
                                        t.batch_no AS batch,
                                        t.division,
                                        s.subject_code AS sub_code,
                                        s.subject_short_name,
                                        s.subject_name,
                                        vw.stream_short_name,
                                        t.semester,
                                        t.stream_id 
                                FROM lecture_time_table AS t 
                                INNER JOIN subject_master s ON s.sub_id = t.subject_code AND s.is_active='Y' 
                                LEFT JOIN vw_stream_details vw ON vw.stream_id = t.stream_id
                                WHERE t.faculty_code='".$emp_id."' 
                                AND t.is_active='Y' 
                                AND t.wday='".$day."'";
        
                if (!empty($empStreamid) && $empStreamid != '71') {
                        $sql .= " AND t.academic_session IN ($cursession) 
                                          AND t.academic_year='".$academic_year."'";
                } else {
                        $sql .= " AND t.academic_session IN ('WIN','SUM') 
                                          AND t.academic_year='".$academic_year."'";
                }
        
                $sql .= " 
                UNION ALL
                SELECT DISTINCT 
                                        att.subject_code AS subject_id,
                                        att.subject_type,
                                        att.batch_no AS batch,
                                        att.division,
                                        s.subject_code AS sub_code,
                                        s.subject_short_name,
                                        s.subject_name,
                                        vw.stream_short_name,
                                        att.semester,
                                        att.stream_id 
                                FROM alternet_lecture_time_table AS att
                                LEFT JOIN subject_master s ON s.sub_id = att.subject_code AND s.is_active='Y' 
                                LEFT JOIN vw_stream_details vw ON vw.stream_id = att.stream_id
                                WHERE att.faculty_code='".$emp_id."' 
                                AND att.is_active='Y' 
                                AND att.wday='".$day."' 
                                AND att.dt_date = '".$date."'";
        
                if (!empty($empStreamid) && $empStreamid != '71') {
                        $sql .= " AND att.academic_session IN ($cursession) 
                                          AND att.academic_year='".$academic_year."'";
                } else {
                        $sql .= " AND att.academic_session IN ('WIN','SUM') 
                                          AND att.academic_year='".$academic_year."'";
                }
        
                $sql .= " ";
        
                $query = $DB1->query($sql);
        
                if ($emp_id == 110409) {
                //        echo $DB1->last_query(); exit();
                }
                // echo $DB1->last_query(); exit();
                return $query->result_array();
        }


    function getFacultySubjects_for_markattendance_new($emp_id, $curr_session,$academic_year){
        $DB1 = $this->load->database('umsdb', TRUE);
		if($curr_session=='WINTER'){
			$cursession ='WIN';
		}else{
			$cursession ='SUM';
		}
		$empStreamid =$this->getFacultyStream($emp_id,$academic_year);
        $sql = "select distinct t.subject_code as subject_id, t.batch_no as batch,t.division, s.subject_code as sub_code,s.subject_short_name,vw.stream_short_name,s.semester,t.stream_id,t.semester as ltsemester,t.course_id from lecture_time_table as t 
        left join subject_master s on s.sub_id = t.subject_code 
		left join vw_stream_details vw on vw.stream_id = t.stream_id
		where t.faculty_code='".$emp_id."' and s.is_active='Y'";
		if(!empty($empStreamid) && $empStreamid!='71'){
				$sql .=" AND t.academic_session='".$cursession."' AND t.academic_year='".$academic_year."'";
			}
			$sql .=" group by t.stream_id, t.division,t.semester";
			$sql .=" order by t.division,t.batch_no";
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		
		return $sub_details;
    }	
	////////
		function fetch_daywise_attendance_details($todaysdate,$day, $stream_id,$sem,$division, $academic_year){
		$DB1 = $this->load->database('umsdb', TRUE);
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql = "select t.faculty_code,t.subject_code,s.subject_name,s.subject_code as sub_code, t.division,t.batch_no, t.subject_type,lecture_slot,wday,slt.from_time,slt.to_time,slt.slot_am_pm, f.fname,f.mname,f.lname,f.mobile_no, t.faculty_code,vw.school_name, vw.stream_name from lecture_time_table t 
left join lecture_slot slt on slt.lect_slot_id = t.`lecture_slot` 
left join vw_faculty f on f.emp_id = t.faculty_code 
left join vw_stream_details vw on vw.stream_id =t.stream_id 
left join subject_master s on s.sub_id = t.subject_code
where t.academic_year='".$acd_yr[0]."' and t.academic_session='".$cur_ses."' and t.wday='".$day."' and t.stream_id='".$stream_id."' and t.semester='".$sem."' and t.division='".$division."' and t.faculty_code IS NOT NULL order by slt.from_time asc,t.batch_no asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$res = $query->result_array();
		return $res;
	}
	//
	function fetch_todaysattendance($subject_code,$lecture_slot,$academicyear,$todaysdate,$streamId,$semesterNo,$division,$batch){
		$DB1 = $this->load->database('umsdb', TRUE);
		$acd_yr = explode('~',$academicyear);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		
		$sql = "SELECT l.faculty_code,l.subject_id,l.attendance_date,l.slot,l.is_present,sba.roll_no,f.fname,f.mname,f.mobile_no,f.photo_path,f.lname,sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,vw.stream_name FROM `lecture_attendance` l 
		left join student_batch_allocation sba on sba.student_id = l.student_id and sba.academic_year = l.academic_year and sba.stream_id=l.stream_id and sba.semester=l.semester
		left join vw_faculty f on f.emp_id = l.faculty_code
		LEFT JOIN student_master sm on sm.stud_id = l.student_id
	    LEFT JOIN vw_stream_details vw on vw.stream_id =l.stream_id
where l.academic_year='".$acd_yr[0]."' and l.academic_session='".$cur_ses."' and attendance_date='".$todaysdate."' and l.stream_id='".$streamId."' and l.semester='".$semesterNo."' and l.division='".$division."' and l.slot='".$lecture_slot."' and l.batch='".$batch."' and sba.active='Y'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$res = $query->result_array();
		return $res;
	}
	function fetch_faculty_punching($l_assigned, $attDate)
	{
		$sql = "SELECT * FROM punching_backup where UserId='".$l_assigned."' and Intime LIKE '%$attDate%'";
		$query = $this->db->query($sql);
		//echo $DB1->last_query();exit;
		$res = $query->result_array();
		return $res;
	}
	function fetch_fac_taken_lect_load_excel($fac_code, $academic_year,$from_date,$to_date){	
		$acd_session = explode('~',  $academic_year);
		$academic_year =$acd_session[0];

		if($acd_session[1]=='WINTER'){
			$academic_sess ='WIN';
		}else{
			$academic_sess ='SUM';
		}		
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT sum(a.duration) as taken_lect_load, count(a.slot)as lslotcnt, a.subject_component from (SELECT slt.duration,l.slot,s.subject_component FROM `lecture_attendance` l
        left join lecture_slot slt on slt.lect_slot_id = l.`slot` 
		left join subject_master s on s.sub_id = l.subject_id
        WHERE l.`academic_year` = '$academic_year' AND l.`academic_session` = '$academic_sess' AND l.`faculty_code` = '$fac_code' ";
		if(!empty($from_date) && !empty($to_date)){
			$sql .=" and l.attendance_date between '$from_date' and '$to_date' ";
		}
		$sql .=" group by l.attendance_date, l.slot,s.subject_component ) as a group by subject_component";			
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
	// fetch subject lesson plan
	function fetch_subject_lplan($subject_id='',$ad_yr='',$acd_ses='',$division='',$semester='',$batch='')
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$faculty_id = $this->session->userdata("name");
		if($acd_ses=='WINTER'){
			$academic_sess ='WIN';
		}else{
			$academic_sess ='SUM';
		}
		$sql="SELECT * FROM `lecture_plan_details` WHERE `subject_id` = '".$subject_id."' and faculty_id='".$faculty_id."' and academic_session='".$academic_sess."' and academic_year='".$ad_yr."' and division='".$division."' and semester='".$semester."' and parents='0'  group by unit_no,topic_no order by unit_no,topic_no asc";
        $query = $DB1->query($sql);
	/*	echo $DB1->last_query();exit;*/
		return $query->result_array();  
    }
	function load_subtopics($data)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $subject_id = $data['subject_id'];
		$subdet = explode('.', $data['topic_no']);
		$unit_no = $subdet[0];
		$topic_no = $subdet[1];
		$stream = $subdet[2];
		$semester = $subdet[3];
		$division = $subdet[4];
		$sql="SELECT ss.syllabus_id,lpd.lecture_plan_id,lpd.unit_no,lpd.topic_no,lpd.subtopic_id,ss.topic_contents FROM `lecture_plan_details`  as lpd
	inner join subject_syllabus as ss ON ss.subject_id=lpd.subject_id AND ss.unit_no=lpd.unit_no and ss.topic_no=lpd.topic_no and ss.subtopic_no=lpd.subtopic_id
		WHERE lpd.`subject_id` = '".$subject_id."'  and lpd.unit_no='".$unit_no."' and lpd.topic_no='".$topic_no."' and lpd.stream_id='".$stream."' and lpd.semester='".$semester."'  and lpd.division='".$division."' and lpd.parents!='0' order by lpd.unit_no,lpd.topic_no asc";
        $query = $DB1->query($sql);
	//echo $DB1->last_query();
		return $stream_details =  $query->result_array();  
    } 
//////////////////////////////// lesson plan /////////////////////////////////	
	function markAttendance_testing($data){
		
		$DB1 = $this->load->database('umsdb', TRUE);   
		$DB1->insert('lecture_attendance_testing', $data);
		//echo $DB1->last_query();exit;
		return true;
	}
	/*function  getNoOfstudts($subId, $division,$batch_no, $stream_id,$semester, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $where=" WHERE sba.stream_id='$stream_id' AND sba.semester='".$semester."' and sba.division='$division' and sba.academic_year='$acd_yr[0]' and sba.subject_id='$subId' and sba.batch='$batch_no' AND sba.active='Y'";
        $sql="SELECT count(student_id) as CNT  FROM `student_batch_allocation` as sba 
       
        $where";
		$sql .= "group by student_id ";
        $query = $DB1->query($sql);
		echo $DB1->last_query();exit;
        return $query->result_array();
    }	*/
	function  getNoOfstudts($subId, $division,$batch_no, $stream_id,$semester, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE cancelled_admission ='N' AND sas.subject_id='$subId' AND sas.stream_id='$stream_id' AND sba.semester='".$semester."' and sba.division='$division' and sba.academic_year='$academic_year' and sba.active='Y'"; 
		//echo $batch_no;exit;		
       	if($batch_no !=0){
			$where .=" and sba.batch='$batch_no' ";
		}	
        $sql="SELECT count(student_id) as CNT FROM `student_batch_allocation` as sba 
left join student_applied_subject sas on sas.stud_id=sba.student_id and sas.stream_id=sba.stream_id 
left join student_master sm on sm.stud_id=sas.stud_id  $where";
		$sql .=" GROUP BY sm.enrollment_no order by sba.roll_no, sm.enrollment_no";
        $query = $DB1->query($sql);
			//echo $DB1->last_query();//exit;
        return $query->result_array();
    }
    function check_leave($fact,$dt,$to_date){
			$date_from = strtotime($dt); // Convert date to a UNIX timestamp  
			$date_to = strtotime($to_date); // Convert date to a UNIX timestamp  
			  $lev1=array();
			  $lev3=array();
			  $lectcnt =array();
			  $hld = array();
			// Loop from the start date to end date and output all dates inbetween  
		for ($i=$date_from; $i<=$date_to; $i+=86400) {  
				$w_dates[] =date("Y-m-d", $i);
				$l_dates =date("Y-m-d", $i);
				$holday = $this->check_holidays($l_dates, $typ=1);
				//print_r($holday);
				if($holday=='true' || $holday=='RD'){
					$hld_lect_cnt = $this->fetch_no_lecture($l_dates,$fact);
					$hld[] = $hld_lect_cnt[0]['cnt'];
				}
			}	 
			
		$sql="select lid,emp_id,applied_from_date,applied_to_date,leave_duration,l.no_hrs,CASE WHEN l.leave_type ='official' THEN 'OD' ELSE ea.leave_type END AS leave_name FROM leave_applicant_list l LEFT JOIN employee_leave_allocation ea ON l.`leave_type`=ea.`id` WHERE emp_id='$fact' and fstatus = 'Approved' and month(applied_from_date)='".date('m',strtotime($dt))."' and YEAR(applied_from_date)='".date('Y',strtotime($dt))."' ";
		
		$query=$this->db->query($sql);
		 $result=$query->result_array();
		 //print_r($result);
		 $ldate=[];
		 $cnt = count($result);
		 
		 if($cnt>0){
			foreach ($result as $key => $value) {
				//echo $value['leave_duration'];
				if($value['leave_duration']=='full-day'){
					$s='Full Day';
				}else if($value['leave_duration']=='half-day'){
					$s='Half Day';
				}else{
					$s='hrs';
				}
				//echo $value['applied_from_date'].'-'.$value['applied_to_date'];exit;
				
				if(date('Y-m-d',strtotime($value['applied_from_date']))!=date('Y-m-d',strtotime($value['applied_to_date']))){
				$darr = $this->get_dates($value['applied_from_date'],$value['applied_to_date']);
				//echo "<pre>";
				//print_r($darr);
				$l= "(".$s.")";
					foreach($darr as $dv){
					 $ldate[$l][]  = date('Y-m-d',strtotime($dv));
					}
				}else{
					//echo $value['applied_from_date'];
					$l= "(".$s.")";
					$ldate[$l][]  = date('Y-m-d',strtotime($value['applied_from_date'])); 
				}
				
			}
 
			//echo "<pre>";
			//print_r($ldate);
			
			//print_r($hld);
			//$j=0;
			
			foreach ($ldate as $key1 => $value1) {
				// for full day
				if($key1=='(Full Day)'){				
					 $vcnt = count($value1);
					 $vcntt=$vcnt -1;
					//in_array(,$value1);
					for($j=0;$j<=$vcntt; $vcntt--){
						if(in_array($value1[$vcntt],$w_dates)){
							$lect_cnt = $this->fetch_no_lecture($value1[$vcntt],$fact);
							$lectcnt[] = $lect_cnt[0]['cnt'];	
						}
					}	
				}
				// for half day
				if($key1=='(Half Day)'){
					$vcnt1 = count($value1);
					 $vcntt2=$vcnt1;
					//in_array(,$value1);
					for($k=0;$k<=$vcntt2; $vcntt2--){
						if(in_array($value1[$vcntt2],$w_dates)){
							$lev1 []=4;
						}else{
							$lev1[]= '';
						}
					}
				}
				// for od in hrs
				if($key1=='(hrs)'){
					$vcnth = count($value1);
				    $vcntt3=$vcnth;
					for($m=0;$m<=$vcntt3; $vcntt3--){
						if(in_array($value1[$vcntt3],$w_dates)){		
							$lev3[]=$value['no_hrs'];
						}else{
							$lev3[]= 0;
						}
					}
				}
			}
				
		}else{
			$lev = '';
		}
		
		foreach($lev1 as $le){
			if(!empty($le)){
				$newhalf=array($le);
			}
		}
	
		
		 $ll=count($newhalf); //echo "<br>";;
		$half_day=0;
		if($ll!=0){
		 $half_day = count($lev1)/2; //echo "<br>";
		}

		if(!empty($lev3)){
			$hr_od = array_sum($lev3);
		}else{
			$hr_od =0; 
		}
		if(!empty($lev1)){
			$hf_day = array_sum($lev1);
		}else{
			$hf_day =0; 
		}
		$total_count = $full_day + $half_day+$hr_od;
		//print_r($lev);print_r($lev1);exit;
     return array_sum($lectcnt)+$hr_od + $hf_day +array_sum($hld);
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
       
		 if(count($value)==0){$flag="false";}else{
		 	 if($value['is_relax_day']=='Y'){
				 $flag = 'RD';
			 }else{
			 $flag="true";
			 }
		 } 
		 return $flag;		
}	
function get_dates($Date1,$Date2){
		

// Declare two dates 
//echo $Date1; //= '01-10-2010'; 
//echo $Date2; //= '05-10-2010'; 

// Declare an empty array 
$array = array(); 

// Use strtotime function 
$Variable1 = strtotime($Date1); 
$Variable2 = strtotime($Date2); 

// Use for loop to store dates into array 
// 86400 sec = 24 hrs = 60*60*24 = 1 day 
for ($currentDate = $Variable1; $currentDate <= $Variable2; 
								$currentDate += (86400)) { 
									
$Store = date('Y-m-d', $currentDate); 
$array[] = $Store; 
} 

// Display the dates in array format 
return $array; 


	}
	
function fetch_no_lecture($tdate, $fact)
{
	$DB1 = $this->load->database('umsdb', TRUE); 
	$dayOfWeek = date("l", strtotime($tdate));
	$sql ="select count(*) as cnt from lecture_time_table where academic_year='2019-20' and academic_session='WIN' and wday='$dayOfWeek' and faculty_code='$fact'";
 
	$query = $DB1->query($sql);
		//echo $DB1->last_query();//exit;
	return $query->result_array();
	
}
	function fetchempdetails($emp_id)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 	
        $sql="SELECT distinct emp_school,college_code FROM `vw_faculty` where emp_id='$emp_id'";
        $query = $DB1->query($sql);
        return $query->result_array();
    } 
	////////////////////////////////////added on 10-03-2025//////////////////
	function getStudentData($enrollment_no)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$acdyr=ACADEMIC_YEAR;
		$where = " WHERE 1=1 ";
		if (!empty($enrollment_no)) {
			$where .= " AND sm.enrollment_no = '" . $DB1->escape_str($enrollment_no) . "'";
		}

		$sql = "
			SELECT 
				sm.stud_id, 
				sm.first_name, 
				sm.admission_stream, 
				sm.current_year, 
				sm.current_semester,
				roll_no AS roll_no,  
				division AS division,  
				sba.academic_year AS academic_year,  
				sba.stream_id AS stream_id,  
				MAX(vsd.course_id) AS course_id
			FROM student_master sm
			LEFT JOIN student_batch_allocation sba 
				ON sm.stud_id = sba.student_id and sm.current_semester=sba.semester
				AND sba.academic_year = '$acdyr'
			LEFT JOIN vw_stream_details vsd 
				ON sm.admission_stream = vsd.stream_id 
			$where
			GROUP BY sm.stud_id 
		";

		$query = $DB1->query($sql);
		// echo $DB1->last_query(); 
		return $query->result_array();
	}


	public function get_student_attendance_for_parent($streamID, $semesterId, $division, $academic_year, $from_date = null, $to_date = null, $student_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		
		 $academic_year = ACADEMIC_YEAR;
		 $academic_session = CURRENT_SESS;
		 
		//$acd_yr = explode('~', $academic_year);
		//$cur_ses = ($acd_yr[1] == 'WINTER') ? "WIN" : "SUM";

		// $streamID = 34;
		// $semesterId = 10;
		// $division = 'A';

		$DB1->select([
			'la.student_id',
			'smm.first_name',
			'smm.enrollment_no',
			'smm.current_year',
			'sm.subject_short_name',
			'sm.subject_name',
			'la.subject_id',
			'la.subtype',
			'la.division',
			
			'(SELECT COUNT(DISTINCT CONCAT(la2.attendance_date, "-", la2.slot))  
			 FROM lecture_attendance la2
			 WHERE la2.subject_id = la.subject_id 
			 AND la2.stream_id = la.stream_id 
			 AND la2.semester = la.semester 
			 AND la2.division = la.division 
			 AND la2.academic_session = la.academic_session 
			 AND la2.academic_year = la.academic_year
			) AS total_lectures',
	
			'COUNT(DISTINCT CASE WHEN la.is_present = "Y" THEN CONCAT(la.attendance_date, "-", la.slot) END) AS total_attended_lectures',
	
			'MAX(ad.adds_of) AS address',
			'MAX(ad.city) AS city',
			'MAX(d.district_name) AS district',
			'MAX(s.state_name) AS state',
			'MAX(ad.pincode) AS pincode',
			'MAX(t.taluka_name) AS taluka'
		]);
	
		$DB1->from('lecture_attendance la');
		$DB1->join('student_master smm', 'smm.stud_id = la.student_id', 'left');
		$DB1->join('subject_master sm', 'sm.sub_id = la.subject_id', 'left');
		$DB1->join('address_details ad', 'ad.student_id = la.student_id AND ad.address_type = "PERMNT"', 'left');
		$DB1->join('district_name d', 'd.district_id = ad.district_id', 'left');
		$DB1->join('states s', 's.state_id = ad.state_id', 'left');
		$DB1->join('taluka_master t', 't.taluka_id = ad.city', 'left');
	
		$DB1->where('la.stream_id', $streamID);
		$DB1->where('la.semester', $semesterId);
		$DB1->where('la.division', $division);
		$DB1->where('la.academic_session', $academic_session);
		$DB1->where('la.academic_year', $academic_year);
		$DB1->where('la.student_id', $student_id);
	
		if (!empty($from_date) && !empty($to_date)) {
			$DB1->where('la.attendance_date >=', $from_date);
			$DB1->where('la.attendance_date <=', $to_date);
		}
	
		$DB1->group_by([
			'la.student_id',
			'smm.first_name',
			'smm.enrollment_no',
			'sm.subject_short_name',
			'sm.subject_name',
			'la.subject_id',
			'la.subtype'
		]);
	
		$DB1->order_by('la.student_id, sm.subject_name');
	
		$query = $DB1->get();
	//echo $DB1->last_query();exit;
		return $query->result_array();
	}


public function get_student_attendance($streamID, $semesterId, $division, $academic_year, $from_date = null, $to_date = null)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$academic_year = ACADEMIC_YEAR;
		$cur_ses = CURRENT_SESS;

		/* $streamID = 34;
		$semesterId = 10;
		$division = 'A'; */
		
		$DB1->select([
			'la.student_id',
			'smm.first_name',
			'smm.enrollment_no',
			
			'(SELECT COUNT(DISTINCT CONCAT(la2.attendance_date, "-", la2.slot))  
			 FROM lecture_attendance la2
			 WHERE la2.subject_id = la.subject_id 
			 AND la2.stream_id = la.stream_id 
			 AND la2.semester = la.semester 
			 AND la2.division = la.division 
			 AND la2.academic_session = la.academic_session 
			 AND la2.academic_year = la.academic_year
			) AS total_lectures',
	
			'COUNT(DISTINCT CASE WHEN la.is_present = "Y" THEN CONCAT(la.attendance_date, "-", la.slot) END) AS total_attended_lectures',
		
		]);
	
		$DB1->from('lecture_attendance la');
		$DB1->join('student_master smm', 'smm.stud_id = la.student_id', 'left');
	//	$DB1->join('subject_master sm', 'sm.sub_id = la.subject_id', 'left');
	
		$DB1->where('la.stream_id', $streamID);
		$DB1->where('la.semester', $semesterId);
		$DB1->where('la.division', $division);
		$DB1->where('la.academic_session', $cur_ses);
		$DB1->where('la.academic_year', $academic_year);
	
		if (!empty($from_date) && !empty($to_date)) {
			$DB1->where('la.attendance_date >=', $from_date);
			$DB1->where('la.attendance_date <=', $to_date);
		}
	
		$DB1->group_by([
			'la.student_id',
			'smm.first_name',
			'smm.enrollment_no',
			'la.subject_id',
		]);
	
		$DB1->order_by('la.student_id');
	
		$query = $DB1->get();
	
		return $query->result_array();
	}

	/////////////////
	
	//// HK CODE///
	

	public function get_students() {
		$DB1 = $this->load->database('umsdb', TRUE);
		$academic_year = ACADEMIC_YEAR;
		$DB1->select('
			smm.first_name,  
			smm.stud_id,  
			smm.enrollment_no,  
			smm.current_semester,  
			smm.admission_stream,  
			smm.email as s_email,  
			pd.parent_email,  
			sba.academic_year,  
			sba.division,  
			sba.batch
		');
	
		$DB1->from('student_master smm');
		$DB1->join('student_batch_allocation sba', 'sba.student_id = smm.stud_id 
        AND sba.stream_id = smm.admission_stream 
        AND sba.semester = smm.current_semester', 'left');
		$DB1->join('parent_details pd', 'pd.student_id = smm.stud_id','left');
		$DB1->where('smm.actice_status', 'Y');
		$DB1->where('pd.parent_email !=','');
		$DB1->where('sba.active', 'Y');
		$DB1->where('smm.academic_year', '2024');
		$query = $DB1->get();
		// echo $DB1->last_query(); exit;
		return $query->result_array();
	}
	
	public function get_student_attendance_for_parent_cron($streamID, $semesterId, $division, $academic_year, $from_date = null, $to_date = null, $student_id, $batch = null)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
	
		$academic_year = ACADEMIC_YEAR;
		$acd_yr = $academic_year;
		$cur_ses = CURRENT_SESS;
	
		$batch = intval($batch);  
		$student_id = intval($student_id);
		$streamID = intval($streamID);
		$semesterId = intval($semesterId);
		
		// If no date provided, use current month
		if (empty($from_date) && empty($to_date)) {
			$from_date = '2025-03-01'; // First day of current month
			$to_date = '2025-03-31';    // Last day of current month
		}
	
		$DB1->select([
			'smm.stud_id AS student_id',
			'la.batch AS time_table_batch',
			'smm.first_name',
			'smm.enrollment_no',
			'smm.current_year',
			'sm.subject_short_name',
			'sm.subject_name',
			'la.subject_id AS subject_id',
			'la.division',
	
			// Total Lectures
			"(SELECT COUNT(DISTINCT CONCAT(la2.attendance_date, '-', la2.slot))  
			  FROM lecture_attendance la2
			  WHERE la2.subject_id = la.subject_id 
			  AND la2.stream_id = la.stream_id
			  AND la2.semester = la.semester
			  AND la2.division = la.division
			  AND la2.academic_session = la.academic_session
			  AND la2.academic_year = la.academic_year
			  AND la2.attendance_date BETWEEN '{$from_date}' AND '{$to_date}'
			  AND la2.student_id = smm.stud_id
			) AS total_lectures",
	
			// Attended Lectures
			"(SELECT COUNT(DISTINCT CONCAT(la3.attendance_date, '-', la3.slot))  
			  FROM lecture_attendance la3
			  WHERE la3.subject_id = la.subject_id
			  AND la3.stream_id = la.stream_id
			  AND la3.semester = la.semester
			  AND la3.division = la.division
			  AND la3.academic_session = la.academic_session
			  AND la3.academic_year = la.academic_year
			  AND la3.attendance_date BETWEEN '{$from_date}' AND '{$to_date}'
			  AND la3.student_id = smm.stud_id
			  AND la3.is_present = 'Y'
			) AS total_attended_lectures",
	
			'MAX(ad.adds_of) AS adds_of',
			'MAX(ad.address) AS address',
			'MAX(ad.city) AS city',
			'MAX(d.district_name) AS district',
			'MAX(s.state_name) AS state',
			'MAX(ad.pincode) AS pincode',
			'MAX(t.taluka_name) AS taluka'
		]);
	
		$DB1->from('lecture_attendance la');
		$DB1->join('student_master smm', "smm.stud_id = {$student_id}", 'left');
		$DB1->join('subject_master sm', 'sm.sub_id = la.subject_id', 'left');
		$DB1->join('student_applied_subject sas', "sas.stud_id = smm.stud_id AND sas.subject_id = sm.sub_id", 'inner');
		$DB1->join('address_details ad', 'ad.student_id = smm.stud_id AND ad.address_type = "PERMNT"', 'left');
		$DB1->join('district_name d', 'd.district_id = ad.district_id', 'left');
		$DB1->join('states s', 's.state_id = ad.state_id', 'left');
		$DB1->join('taluka_master t', 't.taluka_id = ad.city', 'left');
	
		// Filter conditions
		$DB1->where('la.stream_id', $streamID);
		$DB1->where('la.semester', $semesterId);
		$DB1->where('la.division', $division);
		$DB1->where('la.academic_session', $cur_ses);
		$DB1->where('la.academic_year', $acd_yr);
		$DB1->where('smm.stud_id', $student_id);
		$DB1->where('la.attendance_date >=', $from_date);
		$DB1->where('la.attendance_date <=', $to_date);
	
		// Group and order
		$DB1->group_by([
			'smm.stud_id',
			'smm.first_name',
			'smm.enrollment_no',
			'sm.subject_short_name',
			'sm.subject_name',
			'la.subject_id',
		]);
	
		$DB1->order_by('smm.stud_id, sm.subject_name');
	
		$query = $DB1->get();
//   echo $DB1->last_query(); exit;

		return $query->result_array();
	}
	
	
	public function get_student_by_id($student_id)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    $DB1->select('
        smm.first_name,  
        smm.stud_id,  
        smm.enrollment_no,  
        smm.current_semester,  
        smm.admission_stream,  
        smm.email as s_email,  
        pd.parent_email,  
        sba.academic_year,  
        sba.division,  
        sba.batch
    ');

    $DB1->from('student_master smm');
    $DB1->join('student_batch_allocation sba', 'sba.student_id = smm.stud_id 
        AND sba.stream_id = smm.admission_stream 
        AND sba.semester = smm.current_semester', 'left');
    $DB1->join('parent_details pd', 'pd.student_id = smm.stud_id', 'left');
    $DB1->where('smm.actice_status', 'Y');
    $DB1->where('sba.active', 'Y');
    $DB1->where('smm.academic_year', '2024');
    $DB1->where('smm.stud_id', $student_id);

    $query = $DB1->get();
	// echo $DB1->last_query(); exit;
    return $query->row_array();
}
 public function get_student_attendance_for_parent_cron11($streamID, $semesterId, $division, $academic_year, $from_date = null, $to_date = null, $student_id, $batch = null)
        {
                $DB1 = $this->load->database('umsdb', TRUE);
        
                $academic_year = ACADEMIC_YEAR;
                $acd_yr = $academic_year;
                $cur_ses = CURRENT_SESS;
                
                $batch = intval($batch);  
                $student_id = intval($student_id);
                $streamID = intval($streamID);
                $semesterId = intval($semesterId);
                //$student_id =1796;
        
                if (empty($from_date) && empty($to_date)) {
                        $from_date = ''; 
                        $to_date = '';   
                }
        
                $DB1->select([
                        'smm.stud_id AS student_id',
                        'la.batch AS time_table_batch',
                        'smm.first_name',
                        'smm.enrollment_no',
                        'smm.current_year',
                        'sm.subject_short_name',
                        'sm.subject_name',
                        'la.subject_id AS subject_id',
                        'la.division',
        
                        // Total Lectures
                        "(SELECT COUNT(DISTINCT CONCAT(la2.attendance_date, '-', la2.slot))  
                          FROM lecture_attendance la2
                          WHERE la2.subject_id = la.subject_id 
                          AND la2.stream_id = la.stream_id
                          AND la2.semester = la.semester
                          AND la2.division = la.division
                          AND la2.academic_session = la.academic_session
                          AND la2.academic_year = la.academic_year
                          #AND la2.attendance_date BETWEEN '{$from_date}' AND '{$to_date}'
                          AND la2.student_id = smm.stud_id
                        ) AS total_lectures",
        
                        // Attended Lectures
                        "(SELECT COUNT(DISTINCT CONCAT(la3.attendance_date, '-', la3.slot))  
                          FROM lecture_attendance la3
                          WHERE la3.subject_id = la.subject_id
                          AND la3.stream_id = la.stream_id
                          AND la3.semester = la.semester
                          AND la3.division = la.division
                          AND la3.academic_session = la.academic_session
                          AND la3.academic_year = la.academic_year
                          #AND la3.attendance_date BETWEEN '{$from_date}' AND '{$to_date}'
                          AND la3.student_id = smm.stud_id
                          AND la3.is_present = 'Y'
                        ) AS total_attended_lectures",
        
                        'MAX(ad.adds_of) AS adds_of',
                        'MAX(ad.address) AS address',
                        'MAX(ad.city) AS city',
                        'MAX(d.district_name) AS district',
                        'MAX(s.state_name) AS state',
                        'MAX(ad.pincode) AS pincode',
                        'MAX(t.taluka_name) AS taluka'
                ]);
        
                $DB1->from('lecture_attendance la');
                $DB1->join('student_master smm', "smm.stud_id = {$student_id}", 'left');
                $DB1->join('subject_master sm', 'sm.sub_id = la.subject_id', 'left');
                $DB1->join('student_applied_subject sas', "sas.stud_id = smm.stud_id AND sas.subject_id = sm.sub_id", 'inner');
                $DB1->join('address_details ad', 'ad.student_id = smm.stud_id AND ad.address_type = "PERMNT"', 'left');
                $DB1->join('district_name d', 'd.district_id = ad.district_id', 'left');
                $DB1->join('states s', 's.state_id = ad.state_id', 'left');
                $DB1->join('taluka_master t', 't.taluka_id = ad.city', 'left');
        
                // Filter conditions
                $DB1->where('la.stream_id', $streamID);
                $DB1->where('la.semester', $semesterId);
                $DB1->where('la.division', $division);
                $DB1->where('la.academic_session', $cur_ses);
                $DB1->where('la.academic_year', $acd_yr);
                $DB1->where('smm.stud_id', $student_id);
               // $DB1->where('la.attendance_date >=', $from_date);
                //$DB1->where('la.attendance_date <=', $to_date);
        
                // Group and order
                $DB1->group_by([
                        'smm.stud_id',
                        'smm.first_name',
                        'smm.enrollment_no',
                        'sm.subject_short_name',
                        'sm.subject_name',
                        'la.subject_id',
                ]);
        
                $DB1->order_by('smm.stud_id, sm.subject_name');
        
                $query = $DB1->get();
  // echo $DB1->last_query(); exit;

                return $query->result_array();
        }
        
public function get_student_data()
{
    $DB1 = $this->load->database('umsdb', TRUE);
    $academic_year = defined('ACADEMIC_YEAR') ? ACADEMIC_YEAR : '2024-25';

    $DB1->select('
        smm.first_name,
        smm.stud_id,
        smm.enrollment_no,
        smm.current_semester,
        smm.admission_stream,
        smm.email as s_email, 
        smm.mobile as s_mobile,
        pd.parent_email,
        pd.parent_mobile2,
        pd.parent_mobile1,
        sba.academic_year,
        sba.division,
        sba.batch
    ');

    $DB1->from('student_master smm');

    // INNER JOIN with student_batch_allocation
    $DB1->join('student_batch_allocation sba', 
        'sba.student_id = smm.stud_id 
         AND sba.stream_id = smm.admission_stream 
         AND sba.semester = smm.current_semester 
         AND sba.active = "Y" 
         AND sba.academic_year = "' . $academic_year . '"',
        'inner'
    );

    // Basic join with parent_details
    $DB1->join('parent_details pd', 'pd.student_id = smm.stud_id', 'inner');

    // Apply filters as WHERE clauses
    $DB1->where('smm.actice_status', 'Y');
    $DB1->where('smm.admission_confirm', 'Y');
    $DB1->where('smm.cancelled_admission', 'N');
    $DB1->where('smm.admission_school', 4);
    $DB1->where('pd.parent_mobile2 IS NOT NULL');
    $DB1->where('pd.parent_mobile2 !=', '');
    $DB1->where('CHAR_LENGTH(pd.parent_mobile2) =', 10, false); // disable escaping for function

    $DB1->group_by('smm.stud_id');
    $DB1->order_by('smm.stud_id', 'DESC');
	//$DB1->where('smm.enrollment_no NOT IN (SELECT enrollement_no FROM monthly_student_attendance_report_pdf)', null, false);
    $query = $DB1->get();
    // Uncomment this for debugging the final query
     //echo $DB1->last_query(); exit;

    return $query->result_array();
}


         public function get_student_dataold()
        {
                $DB1 = $this->load->database('umsdb', TRUE);
                $academic_year = defined('ACADEMIC_YEAR') ? ACADEMIC_YEAR : '2024-25';

                $DB1->select('
                        smm.first_name,
                        smm.stud_id,
                        smm.enrollment_no,
                        smm.current_semester,
                        smm.admission_stream,
                        smm.email as s_email, 
                        smm.mobile as s_mobile,
                        pd.parent_email,
                        pd.parent_mobile2,
                        pd.parent_mobile1,
                        sba.academic_year,
                        sba.division,
                        sba.batch
                ');

                $DB1->from('student_master smm');
                $DB1->join('student_batch_allocation sba', 'sba.student_id = smm.stud_id 
                        AND sba.stream_id = smm.admission_stream 
                        AND sba.semester = smm.current_semester', 'left');
                $DB1->join('parent_details pd', 'pd.student_id = smm.stud_id', 'left');
                $DB1->where('smm.actice_status', 'Y');
                $DB1->where('smm.admission_confirm', 'Y');
                $DB1->where('smm.cancelled_admission', 'N');
                $DB1->where('sba.active', 'Y');
                $DB1->where('sba.academic_year', $academic_year);
                $DB1->where('smm.admission_school', 6);
                 //$DB1->where('smm.enrollment_no', '210105131170');
                $DB1->where('pd.parent_mobile2 IS NOT NULL');
                $DB1->group_by('smm.stud_id');
                $DB1->order_by('smm.stud_id', 'DESC');
                //$DB1->limit(10); 

                $query = $DB1->get();
				//echo $DB1->last_query();exit;
                return $query->result_array();
        }
	public function get_student_attendance_data_tbl()
        {
                $DB1 = $this->load->database('umsdb', TRUE);
                $academic_year = defined('ACADEMIC_YEAR') ? ACADEMIC_YEAR : '2024-25';
                $DB1->select('id,parent_mobile,pdf_path');
                $DB1->from('monthly_student_attendance_report_pdf');
				$DB1->where('msg_status', null);
                
                //$DB1->limit(5); 

                $query = $DB1->get();
				//echo $DB1->last_query();exit;
                return $query->result_array();
        }	
		function getFacultySubjects_for_mte_quiz($emp_id, $curr_session,$academic_year){
				$DB1 = $this->load->database('umsdb', TRUE);
				$arr_faq = array();
				if(in_array($emp_id, $arr_faq)){
					$cursession ="'WIN','SUM'";
					$academic_year='2024-25';
				}else{
					if($curr_session=='WINTER'){
						$cursession ="'WIN'";
					}else{
						$cursession ="'SUM'";
					}
					//$cursession ="'WIN','SUM'";
				}
				$empStreamid =$this->getFacultyStream($emp_id);
				
				$sql = "select t.subject_code as subject_id, t.batch_no as batch,t.division, s.subject_code as sub_code,s.subject_short_name,s.subject_name,s.credits,s.sub_id,s.subject_component,t.subject_type,vw.stream_short_name,s.semester,t.stream_id from lecture_time_table as t 
				INNER join subject_master s on s.sub_id = t.subject_code  AND s.is_active = 'Y'
				left join vw_stream_details vw on vw.stream_id = t.stream_id
				where t.faculty_code='".$emp_id."'  and t.is_active='Y'";
				if(!empty($empStreamid) && $empStreamid!='711111'){
						$sql .=" AND t.academic_session in ($cursession) AND t.academic_year='".$academic_year."'";
					}
					$sql .=" GROUP BY t.subject_code, 
    t.batch_no,
    t.division,
    s.subject_component,
    t.semester,
    t.stream_id order by t.semester,
    t.stream_id,t.division,t.batch_no";
				$query = $DB1->query($sql);
				if($emp_id==110478){
				//echo $DB1->last_query(); exit();
				}

		//echo $DB1->last_query(); exit();
				$sub_details = $query->result_array();
				return $sub_details;
			}	

		
	///////////////////end///////////////////////////////
	public function insertAttendanceMaster($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->insert('attendance_master', $data);
		return $attendance_id = $DB1->insert_id();
	}

	public function insertLectureAttendance($data)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->insert('lecture_attendance', $data);
		//echo $DB1->last_query();exit;
	}
	
	
	public function getStudentAttendancePivotgg($stream_id, $semester, $division, $academic_year, $from_date, $to_date)
{
    $DB1 = $this->load->database('umsdb', TRUE);

    // Split academic year & session
    $acd_yr = explode('~', $academic_year);
    $academic_year = $acd_yr[0];
    $cur_ses = ($acd_yr[1] == 'WINTER') ? "WIN" : "SUM";

    // Build date condition
    $dateCondition = "";
    if (!empty($from_date) && !empty($to_date)) {
        $dateCondition = " AND la.attendance_date BETWEEN " . $DB1->escape($from_date) . " AND " . $DB1->escape($to_date) . " ";
    }

    // Step 1: Get subjects
    $subjects = $DB1->query("
        SELECT DISTINCT sub.sub_id, sub.subject_name,sub.subject_code
        FROM lecture_attendance la
        JOIN subject_master sub ON la.subject_id = sub.sub_id and sub.subject_type !='ELT'
        WHERE la.academic_year = " . $DB1->escape($academic_year) . "
          AND la.stream_id     = " . $DB1->escape($stream_id) . "
          AND la.semester      = " . $DB1->escape($semester) . "
          AND la.division      = " . $DB1->escape($division) . "
          {$dateCondition}
        ORDER BY sub.subject_name
    ")->result_array();

    if (empty($subjects)) {
        return [[], []];
    }

    // Step 2: Build dynamic select for each subject
    $selects = [];
    foreach ($subjects as $sub) {
        $sid   = (int) $sub['sub_id'];
        $sname = preg_replace('/[^A-Za-z0-9]/', '_', $sub['subject_name']); // safe alias

        $selects[] = "
            SUM(CASE WHEN la.subject_id = {$sid} THEN 1 ELSE 0 END) AS `{$sname}_Total`
        ";
        $selects[] = "
            SUM(CASE WHEN la.subject_id = {$sid} AND la.is_present='Y' THEN 1 ELSE 0 END) AS `{$sname}_Attended`
        ";
        $selects[] = "
            ROUND(
                (SUM(CASE WHEN la.subject_id = {$sid} AND la.is_present='Y' THEN 1 ELSE 0 END) /
                 NULLIF(SUM(CASE WHEN la.subject_id = {$sid} THEN 1 ELSE 0 END),0)) * 100, 2
            ) AS `{$sname}_Percent`
        ";
    }

    // Append overall totals
    $selects[] = "COUNT(*) AS Overall_Total";
    $selects[] = "SUM(CASE WHEN la.is_present='Y' THEN 1 ELSE 0 END) AS Overall_Attended";
    $selects[] = "
        ROUND(
            (SUM(CASE WHEN la.is_present='Y' THEN 1 ELSE 0 END) / NULLIF(COUNT(*),0)) * 100,
            2
        ) AS Overall_Percent
    ";

    $selectSQL = implode(",\n        ", $selects);

    // Step 3: Final Query
    $sql = "
        SELECT 
            sm.enrollment_no,
            sm.first_name AS student_name,
            {$selectSQL}
        FROM student_master sm
        JOIN lecture_attendance la ON sm.stud_id = la.student_id #and sm.admission_stream=la.stream_id
        WHERE la.academic_year = " . $DB1->escape($academic_year) . "
          AND la.stream_id     = " . $DB1->escape($stream_id) . "
          AND la.semester      = " . $DB1->escape($semester) . "
          AND la.division      = " . $DB1->escape($division) . "
          {$dateCondition}
        GROUP BY sm.stud_id, sm.first_name
        ORDER BY sm.first_name
    ";

    return [$subjects, $DB1->query($sql)->result_array()];
}

public function getStudentAttendancePivot($stream_id, $semester, $division, $academic_year, $from_date, $to_date, $report_type = 'S')
{
    $DB1 = $this->load->database('umsdb', TRUE);

    // Split academic year & session
    $acd_yr = explode('~', $academic_year);
    $academic_year = $acd_yr[0];
    $cur_ses = ($acd_yr[1] == 'WINTER') ? "WIN" : "SUM";

    $dateCondition = "";
    if (!empty($from_date) && !empty($to_date)) {
        $dateCondition = " AND la.attendance_date BETWEEN " . $DB1->escape($from_date) . " AND " . $DB1->escape($to_date) . " ";
    }

    // Subjects same as before
    $subjects = $DB1->query("
        SELECT DISTINCT sub.sub_id, sub.subject_name, sub.subject_code
        FROM lecture_attendance la
        JOIN subject_master sub ON la.subject_id = sub.sub_id AND sub.subject_type != 'ELT'
        WHERE la.academic_year = " . $DB1->escape($academic_year) . "
          AND la.stream_id     = " . $DB1->escape($stream_id) . "
          AND la.semester      = " . $DB1->escape($semester) . "
          AND la.division      = " . $DB1->escape($division) . "
          {$dateCondition}
        ORDER BY sub.subject_name
    ")->result_array();

    if (empty($subjects)) {
        return [[], []];
    }

    // Dynamic subjectwise columns
    $selects = [];
    foreach ($subjects as $sub) {
        $sid   = (int) $sub['sub_id'];
        $sname = preg_replace('/[^A-Za-z0-9]/', '_', $sub['subject_name']);

        $selects[] = "SUM(CASE WHEN la.subject_id = {$sid} THEN 1 ELSE 0 END) AS `{$sname}_Total`";
        $selects[] = "SUM(CASE WHEN la.subject_id = {$sid} AND la.is_present='Y' THEN 1 ELSE 0 END) AS `{$sname}_Attended`";
        $selects[] = "ROUND((SUM(CASE WHEN la.subject_id = {$sid} AND la.is_present='Y' THEN 1 ELSE 0 END) /
                     NULLIF(SUM(CASE WHEN la.subject_id = {$sid} THEN 1 ELSE 0 END),0)) * 100, 2) AS `{$sname}_Percent`";
    }

    // Overall
    $selects[] = "COUNT(*) AS Overall_Total";
    $selects[] = "SUM(CASE WHEN la.is_present='Y' THEN 1 ELSE 0 END) AS Overall_Attended";
    $selects[] = "ROUND((SUM(CASE WHEN la.is_present='Y' THEN 1 ELSE 0 END) / NULLIF(COUNT(*),0)) * 100, 2) AS Overall_Percent";

    $selectSQL = implode(",\n        ", $selects);

    if ($report_type == 'B') {
    $sql = "
        SELECT 
            ba.batch AS batch_name,
            sm.enrollment_no,
            sm.first_name AS student_name,
            {$selectSQL}
        FROM student_master sm
        JOIN lecture_attendance la ON sm.stud_id = la.student_id
        JOIN student_batch_allocation ba ON ba.student_id = sm.stud_id AND la.batch=ba.batch and la.semester=ba.semester and la.academic_year=ba.academic_year
        WHERE la.academic_year = " . $DB1->escape($academic_year) . "
          AND la.stream_id     = " . $DB1->escape($stream_id) . "
          AND la.semester      = " . $DB1->escape($semester) . "
          AND la.division      = " . $DB1->escape($division) . "
          {$dateCondition}
        GROUP BY ba.batch, sm.stud_id, sm.enrollment_no, sm.first_name
        ORDER BY ba.batch, sm.first_name
    ";
} else {
        // ✅ Subjectwise / normal
        $sql = "
            SELECT 
                sm.enrollment_no,
                sm.first_name AS student_name,
                {$selectSQL}
            FROM student_master sm
            JOIN lecture_attendance la ON sm.stud_id = la.student_id
            WHERE la.academic_year = " . $DB1->escape($academic_year) . "
              AND la.stream_id     = " . $DB1->escape($stream_id) . "
              AND la.semester      = " . $DB1->escape($semester) . "
              AND la.division      = " . $DB1->escape($division) . "
              {$dateCondition}
            GROUP BY sm.stud_id, sm.first_name, sm.enrollment_no
            ORDER BY sm.first_name
        ";
    }
	
	

    return [$subjects, $DB1->query($sql)->result_array()];
}




}
