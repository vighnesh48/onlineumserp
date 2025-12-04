<?php


class Test_attendance extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                                                  ///////// Attendance_model ////////////////

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
	
	// check duplicate student 
	function chk_dupbatchToStudent($data){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sem = $data['semester'];
		$batch_code = $data['batch_code'];
		$sub_applied_id = $data['sub_applied_id'];
		$academic_year = $data['academic_year'];
		$sql="SELECT * FROM `student_batch_allocation` where sub_applied_id='$sub_applied_id' and batch_code ='$batch_code' and semester='$sem' and academic_year ='$academic_year'";
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
	function  get_studbatch_allot_list($subId,$streamId, $semester,$division, $batch, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE cancelled_admission ='N' AND sas.subject_id='$subId' AND sas.stream_id='$streamId' AND sba.semester='".$semester."' and sba.division='$division' and sba.academic_year='$academic_year'";  
       	if($batch !=0){
			$where .=" and sba.batch='$batch' ";
		}	
        $sql="SELECT sba.roll_no,sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile FROM `student_batch_allocation` as sba 
left join student_applied_subject sas on sas.stud_id=sba.student_id and sas.stream_id=sba.stream_id 
left join student_master sm on sm.stud_id=sas.stud_id  $where";
		$sql .=" GROUP BY sm.enrollment_no order by sba.roll_no, sm.enrollment_no";
        $query = $DB1->query($sql);
			//echo $DB1->last_query();//exit;
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
        $where=" WHERE 1=1 AND sm.cancelled_admission='N' ";  
        
        if($sub_code!="")
        {
            $where.=" AND la.subject_id ='".$sub_code."' and la.is_present='N' and la.attendance_date='".$today."' AND la.slot='".$slot."' AND la.faculty_code='".$emp_id."' AND la.semester='".$sem_id."' AND sba.semester='".$sem_id."' and la.division='$division' and la.batch='$batch'";
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
	function check_dup_attendance($today, $slot,$emp_id,$sem_id, $division, $batch,$sub_code)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 

        $where.="WHERE batch ='".$batch."' AND division ='".$division."'  AND attendance_date ='".$today."' AND slot='".$slot."' AND faculty_code='".$emp_id."' AND semester='".$sem_id."' and subject_id='".$sub_code."'";
		
        $sql="SELECT * from lecture_attendance $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	// load slots
	function load_slot($room_no, $semesterId, $emp_id, $academic_year) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select distinct t.lecture_slot, s.from_time, s.to_time, s.slot_am_pm,s.lect_slot_id from lecture_time_table as t left join lecture_slot s on s.lect_slot_id =t.lecture_slot where s.is_active='Y' AND t.stream_id='" .$room_no. "' and t.semester='" .$semesterId. "' AND t.academic_year='$academic_year' order by s.from_time";
		//AND t.faculty_code='".$emp_id."'
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();
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
		$empStreamid =$this->getFacultyStream($emp_id);
        $sql = "select distinct l.subject_id, l.batch,l.division, s.subject_code as sub_code,s.subject_short_name,vw.stream_short_name,s.semester,l.stream_id from lecture_attendance as l 
        left join subject_master s on s.sub_id = l.subject_id 
		left join vw_stream_details vw on vw.stream_id =l.stream_id
		where l.faculty_code='".$emp_id."'";
		if(!empty($empStreamid) && $empStreamid!='71'){
				$sql .=" AND l.academic_session='".$cursession."' AND l.academic_year='".$academic_year."'";
			}
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();exit;
		return $sub_details;
    }
	//fetchFacAttDates
	function fetchFacAttDates($subId,$emp_id, $batch, $division, $academic_year) {
		
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT distinct l.`attendance_date`, l.slot, sm.from_time, sm.to_time, sm.slot_am_pm  FROM `lecture_attendance` l 
        left join lecture_slot sm on sm.lect_slot_id = l.slot 
        WHERE l.`subject_id` ='".$subId."' AND l.batch ='".$batch."' AND l.division ='".$division."' AND l.academic_year ='".$academic_year."' and faculty_code='".$emp_id."' 
        order by attendance_date, sm.lect_slot_id asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
    }
	//fetchFacAttPresent
	function fetchFacAttPresent($attendance_date,$subId,$emp_id,$slot, $division, $batch, $academic_year) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT count(*) as present  FROM `lecture_attendance` WHERE attendance_date ='".$attendance_date."' and `subject_id` ='".$subId."' and faculty_code='".$emp_id."' AND slot='".$slot."' AND batch ='".$batch."' AND division ='".$division."' AND academic_year ='".$academic_year."' and is_present='Y' order by attendance_date asc";
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
    }
	//fetchFacAttAbsent
	function fetchFacAttAbsent($attendance_date,$subId,$emp_id,$slot, $division, $batch, $academic_year) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT count(*) as absent  FROM `lecture_attendance` WHERE attendance_date ='".$attendance_date."' and `subject_id` ='".$subId."' and faculty_code='".$emp_id."' AND slot='".$slot."' AND batch ='".$batch."' AND division ='".$division."' AND academic_year ='".$academic_year."' and is_present='N' order by attendance_date asc";
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
	function fetchDateSlotwiseAttDetails($att_date,$sub_id,$slot,$emp_id,$sem, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 AND sm.cancelled_admission='N' ";  
        
        if($att_date!="")
        {
            $where.=" AND la.subject_id ='".$sub_id."' and la.attendance_date='".$att_date."' AND la.slot='".$slot."' AND la.faculty_code='".$emp_id."' AND sba.semester ='".$sem."' AND la.academic_year ='".$academic_year."'";
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
        $sql="SELECT `sm`.stud_id,`sm`.form_number,`sm`.enrollment_no,`sm`.first_name,`sm`.middle_name,sm.current_semester,`sm`.last_name,`sm`.mobile,`sm`.admission_stream, `stm`.`stream_name`, `stm`.`course_name`, `stm`.`course_short_name`, `s`.`stream_id` as `strmId`, `sba`.`batch`,s.subject_code,s.subject_name, s.subject_short_name,s.sub_id FROM `student_master` as `sm` LEFT JOIN `vw_stream_details` as `stm` ON `sm`.`admission_stream` = `stm`.`stream_id` LEFT JOIN `student_applied_subject` as `sas` ON `sas`.`stud_id` = `sm`.`stud_id` LEFT JOIN `subject_master` as `s` ON `s`.`sub_id` = `sas`.`subject_id` LEFT JOIN `student_batch_allocation` as `sba` ON `sba`.`batch_id` = `sas`.`sub_applied_id` WHERE `enrollment_no` = '".$enrollment_no."' AND s.semester='".$current_semester."' AND sm.cancelled_admission='N' ORDER BY `sm`.`stud_id` DESC";
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
		$DB1->join('student_batch_allocation as sba','sba.batch_id = sas.sub_applied_id','left');
		$DB1->where('enrollment_no', $stud_id);
		$DB1->where('cancelled_admission', 'N');
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
            $where.=" AND t.faculty_code='".$emp_id."' AND t.academic_session ='".$cursession."' AND t.academic_year ='".$academic_year."' group by t.subject_code,t.division, t.batch_no";
        }		
        $sql="SELECT t.subject_code,sum(slt.duration) as lect_load, s.subject_code as sub_code,s.subject_name,s.subject_component,vw.stream_short_name,s.sub_id,t.semester,t.stream_id, f.fname,f.mname,f.lname, t.division, t.batch_no FROM `lecture_time_table` t 
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
            $where.=" AND faculty_code='".$emp_id."' AND subject_id ='".$subId."'";
        }	
		if($subject_component=='EM'){
			$where.=" AND batch='0'";
		}
        $sql="SELECT distinct division, batch,semester FROM `lecture_attendance` $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function getNoOfLecture($emp_id,$subId, $from_date, $to_date, $division, $batch, $academic_session, $academic_year)
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
            $where.=" AND a.subject_id ='".$subId."' AND a.faculty_code='".$emp_id."' AND a.division='".$division."' AND a.batch='".$batch."' AND a.academic_session='$cur_ses' and a.academic_year='$academic_year'";
        }
		if($from_date!="")
        {
            $where.=" AND attendance_date BETWEEN '".$from_date."' AND '".$to_date."'";
        }		
        $sql="SELECT distinct a.attendance_date, a.slot, count(a.student_id) as studCNT FROM `lecture_attendance` a left join subject_master s on s.sub_id = a.subject_id $where";
		$sql.=" group by a.attendance_date, a.slot";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	function avgPerOfSubject($emp_id,$subId, $from_date, $to_date, $division, $batch, $academic_session, $academic_year)
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
            $where.=" AND subject_id ='".$subId."' AND faculty_code='".$emp_id."' AND division='".$division."' AND batch='".$batch."' AND academic_session='$cur_ses' and academic_year='$academic_year'";
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
		$DB1 = $this->load->database('umsdb', TRUE);  
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

         $where.=" AND l.division='".$division."' AND l.batch='".$batch."' AND l.stream_id='".$stream."' AND l.academic_year='".$academic_year."' AND l.academic_session='".$cur_ses."'";
	
         $sql = "SELECT sm.first_name, sm.middle_name, sm.last_name,sm.stud_id, sba.roll_no,sm.enrollment_no, l.student_id FROM `lecture_attendance` as l 
		LEFT JOIN student_batch_allocation sba on sba.student_id = l.student_id and sba.academic_year=l.academic_year and sba.semester=l.semester
		LEFT JOIN student_master sm on sm.stud_id = l.student_id
		$where group by sm.stud_id order by sba.roll_no asc ";
			
        $query = $DB1->query($sql);
        $res = $query->result_array();
	//	echo $DB1->last_query();
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
		
        $sql = "SELECT distinct l.attendance_date, l.slot FROM `lecture_attendance` as l WHERE l.`subject_id` ='".$sub_id."' and l.faculty_code='".$emp_id."' and l.division='".$division."' and l.batch='".$batch."'and l.stream_id='".$stream_id."' AND l.academic_year='".$academic_year."' AND l.academic_session='".$cur_ses."'";
		
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
		//echo $DB1->last_query();echo "<br>";
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
	// fetch Faculty Stream
	function getFacultyStream($emp_id){
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT distinct stream_id FROM `lecture_time_table` WHERE `faculty_code` = '".$emp_id."'";		
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res[0]['stream_id'];
	}
	// fetch stream from attendance table
	function get_attendance_streams($course_id, $academic_year)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$acd_yr = explode('~',$academic_year);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql="select stream_id,stream_code,stream_short_name from vw_stream_details where stream_id in(select distinct stream_id from lecture_attendance where academic_year ='".$acd_yr[0]."' and academic_session='$cur_ses') and course_id ='$course_id' and stream_short_name is not null ";
        //$sql="SELECT distinct l.stream_id, vw.stream_code, vw.stream_short_name, vw.course_short_name, vw.stream_name FROM `lecture_attendance` l inner join vw_stream_details vw on vw.stream_id =l.stream_id and vw.course_id ='$course_id' AND l.academic_session='$cur_ses' and l.academic_year='".$acd_yr[0]."'";
        if(isset($role_id) && $role_id==10){
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
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
        $where=" WHERE 1=1 ";  
        if($stream_id!="")
        {
            $where.=" AND stream_id='".$stream_id."' AND academic_session='$cur_ses' and academic_year='$acd_yr[0]'";
        }		
        $sql="SELECT distinct semester FROM `lecture_attendance` $where order by semester asc";
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
        $sql = "SELECT * FROM `academic_session` order by academic_year desc";		
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
        $where=" WHERE sba.stream_id='$stream_id' AND sba.semester='".$semester."' and sba.division='$division' and sba.academic_year='$acd_yr[0]' AND sm.cancelled_admission='N'";
        $sql="SELECT sm.stud_id, sba.roll_no, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile, sba.division,sba.batch,sba.stream_id,v.stream_name, sba.semester FROM `student_batch_allocation` as sba 
        left join student_master sm on sm.stud_id=sba.student_id 
        left join vw_stream_details v on v.stream_id=sba.stream_id 
        $where";
		$sql .= "group by sm.enrollment_no order by sba.roll_no";
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
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		$sql="select course_id,course_short_name from vw_stream_details where stream_id in(select distinct stream_id from lecture_attendance where academic_year ='$acd_yr[0]' and academic_session='$cur_ses') and course_name is not null ";
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
        $sql = "select distinct division from lecture_attendance where stream_id='" .$room_no. "' and semester='" .$semesterId. "' and academic_year ='$acd_yr[0]' and academic_session='$cur_ses' order by division";
		//AND t.faculty_code='".$emp_id."'
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();exit;
		return $sub_details;
    }	
	function getFacultySubjects_for_markattendance($emp_id, $curr_session,$academic_year){
        $DB1 = $this->load->database('umsdb', TRUE);
		if($curr_session=='WINTER'){
			$cursession ='WIN';
		}else{
			$cursession ='SUM';
		}
		$empStreamid =$this->getFacultyStream($emp_id);
        $sql = "select distinct t.subject_code as subject_id, t.batch_no as batch,t.division, s.subject_code as sub_code,s.subject_short_name,vw.stream_short_name,s.semester,t.stream_id from lecture_time_table as t 
        left join subject_master s on s.sub_id = t.subject_code 
		left join vw_stream_details vw on vw.stream_id = t.stream_id
		where t.faculty_code='".$emp_id."' and s.is_active='Y'";
		if(!empty($empStreamid) && $empStreamid!='71'){
				$sql .=" AND t.academic_session='".$cursession."' AND t.academic_year='".$academic_year."'";
			}
			$sql .=" order by t.division,t.batch_no";
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();exit;
		return $sub_details;
    }	


    function getFacultySubjects_for_markattendance_new($emp_id, $curr_session,$academic_year){
        $DB1 = $this->load->database('umsdb', TRUE);
		if($curr_session=='WINTER'){
			$cursession ='WIN';
		}else{
			$cursession ='SUM';
		}
		$empStreamid =$this->getFacultyStream($emp_id);
        $sql = "select distinct t.subject_code as subject_id, t.batch_no as batch,t.division,
		 s.subject_code as sub_code,s.subject_short_name,vw.stream_short_name,s.semester,t.stream_id,
		 t.semester as ltsemester,t.course_id from lecture_time_table as t 
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
		//echo $DB1->last_query();exit;
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
	function fetch_todaysattendance($subject_code,$lecture_slot,$academicyear,$todaysdate,$streamId,$semesterNo,$division){
		$DB1 = $this->load->database('umsdb', TRUE);
		$acd_yr = explode('~',$academicyear);
		if($acd_yr[1]=='WINTER'){
			$cur_ses="WIN";
		}else{
			$cur_ses="SUM";
		}
		
		$sql = "SELECT l.faculty_code,l.subject_id,l.attendance_date,l.slot,l.is_present,sba.roll_no,f.fname,f.mname,f.mobile_no,f.photo_path,f.lname,sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,vw.stream_name FROM `lecture_attendance` l 
		left join student_batch_allocation sba on sba.student_id = l.student_id and sba.academic_year = l.academic_year 
		left join vw_faculty f on f.emp_id = l.faculty_code
		LEFT JOIN student_master sm on sm.stud_id = l.student_id
	    LEFT JOIN vw_stream_details vw on vw.stream_id =l.stream_id
where l.academic_year='".$acd_yr[0]."' and l.academic_session='".$cur_ses."' and attendance_date='".$todaysdate."' and l.stream_id='".$streamId."' and l.semester='".$semesterNo."' and l.division='".$division."' and l.slot='".$lecture_slot."'";
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
	function fetch_fac_taken_lect_load_excel($fac_code, $academic_year){	
		$acd_session = explode('~',  $academic_year);
		$academic_year =$acd_session[0];

		if($acd_session[1]=='WINTER'){
			$academic_sess ='WIN';
		}else{
			$academic_sess ='SUM';
		}		
		$DB1 = $this->load->database('umsdb', TRUE);	
        $sql = "SELECT sum(a.duration) as taken_lect_load,a.subject_component from (SELECT slt.duration,s.subject_component FROM `lecture_attendance` l
        left join lecture_slot slt on slt.lect_slot_id = l.`slot` 
		left join subject_master s on s.sub_id = l.subject_id
        WHERE l.`academic_year` = '$academic_year' AND l.`academic_session` = '$academic_sess' AND l.`faculty_code` = '$fac_code' group by l.attendance_date, l.slot,s.subject_component ) as a group by subject_component";			
        $query = $DB1->query($sql);
        $res = $query->result_array();
		//echo $DB1->last_query();exit;
		return $res;
	}
	// fetch subject lesson plan
	function fetch_subject_lplan($subject_id,$ad_yr,$acd_ses,$division,$semester,$batch)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
		$faculty_id = $this->session->userdata("name");
		if($acd_ses=='WINTER'){
			$academic_sess ='WIN';
		}else{
			$academic_sess ='SUM';
		}
		$sql="SELECT * FROM `lecture_plan_details` WHERE `subject_id` = '".$subject_id."' and faculty_id='".$faculty_id."' and academic_session='".$academic_sess."' and academic_year='".$ad_yr."' and division='".$division."' and semester='".$semester."' group by unit_no,topic_no order by unit_no,topic_no asc";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();  
    }
	function load_subtopics($data)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $subject_id = $data['subject_id'];
		$subdet = explode('.', $data['topic_no']);
		$unit_no = $subdet[0];
		$topic_no = $subdet[1];
		$sql="SELECT lecture_plan_id,unit_no,topic_no,subtopic_no,covered_topics FROM `lecture_plan_details` WHERE `subject_id` = '".$subject_id."'  and unit_no='".$unit_no."' and topic_no='".$topic_no."' order by unit_no,topic_no asc";
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




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

	}
?>