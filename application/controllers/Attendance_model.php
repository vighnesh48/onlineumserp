<?php
class Attendance_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
		$DB1 = $this->load->database('umsdb', TRUE);
    }
    
	
	// fetch student list
	function getclassRoom($emp_id)
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
	// fetch student list
	function getSem($emp_id,$room_no)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        if($room_no!="")
        {
            $where.=" AND faculty_code='".$emp_id."' AND stream_id='".$room_no."'";
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
	
	function load_subject($room_no, $semesterId, $emp_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select distinct t.subject_code, vw.stream_code, t.division, t.batch_no,s.subject_code as sub_code,s.subject_short_name from lecture_time_table as t left join vw_stream_details vw on vw.stream_id =t.stream_id left join subject_master s on s.sub_id = t.subject_code where t.stream_id='" .$room_no. "' and t.semester='" .$semesterId. "' AND t.faculty_code='".$emp_id."' order by t.division,t.batch_no";
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();
		return $sub_details;
    }
	// fetch batch allocated student list
	function  get_studbatch_allot_list($batch_code)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        
        if($batch_code!="")
        {
            $where.=" AND sba.batch_code ='".$batch_code."'";
        }
		
        $sql="SELECT sba.sub_applied_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile FROM `student_batch_allocation` as sba left join student_applied_subject sas on sas.sub_applied_id=sba.sub_applied_id left join student_master sm on sm.stud_id=sas.stud_id $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
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
	function fetchAbsentStud($batch_code, $today)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        
        if($batch_code!="")
        {
            $where.=" AND sba.batch_code ='".$batch_code."' and is_present='N' and attendance_date='".$today."'";
        }
		
        $sql="SELECT sba.sub_applied_id, sm.stud_id, sm.first_name,sm.middle_name,sm.last_name,sm.enrollment_no,sm.mobile,la.is_present, pd.parent_mobile2, pd.subscribe_for_sms FROM `student_batch_allocation` as sba left join student_applied_subject sas on sas.sub_applied_id=sba.sub_applied_id left join student_master sm on sm.stud_id=sas.stud_id left join lecture_attendance la on la.student_id=sba.sub_applied_id left join parent_details pd on pd.student_id=sm.stud_id $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }
	// check duplicate
	function check_dup_attendance($batch_code, $today)
    {
        $DB1 = $this->load->database('umsdb', TRUE); 
        $where=" WHERE 1=1 ";  
        
        if($batch_code!="")
        {
            $where.=" AND batch_code ='".$batch_code."' AND attendance_date ='".$today."'";
        }
		
        $sql="SELECT * from lecture_attendance $where";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
    }	
	// load slots
	function load_slot($room_no, $semesterId, $emp_id) {
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select distinct t.lecture_slot, s.from_time, s.to_time, s.slot_am_pm,s.lect_slot_id from lecture_time_table as t left join lecture_slot s on s.lect_slot_id =t.lecture_slot where s.is_active='Y' AND t.stream_id='" .$room_no. "' and t.semester='" .$semesterId. "' order by s.from_time";
		//AND t.faculty_code='".$emp_id."'
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();
		return $sub_details;
    }
	function getsubdetails($subId){
		$DB1 = $this->load->database('umsdb', TRUE);
        $sql = "select * from subject_master where sub_id='" .$subId. "'";
		//AND t.faculty_code='".$emp_id."'
        $query = $DB1->query($sql);
        $sub_details = $query->result_array();
		//echo $DB1->last_query();
		return $sub_details;
	}
}