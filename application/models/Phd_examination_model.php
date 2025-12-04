<?php
class Phd_examination_model extends CI_Model{
	function __construct(){
		parent::__construct();
	} 		
	function getStudAllocatedSubject($stud_id, $semester){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE sas.is_active='Y' ";  
        
		if($stud_id!=""){
			$where.=" AND sas.stud_id='".$stud_id."' AND sas.semester='$semester' AND sm.is_active='Y'";
		}	// and sas.academic_year='2019-20'
		
		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester,sm.batch,sm.credits FROM `student_applied_subject` as sas left join subject_master sm on sm.sub_id=sas.subject_id $where";
		$query = $DB1->query($sql);
		// echo $DB1->last_query();exit();
		return $query->result_array();
	}
	
	//
	function getExamAllocatedSubject($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_id =$ex_session[0]['exam_id'];

		$sql="SELECT sas.stud_id, sm.subject_name, sas.subject_id, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester FROM `phd_exam_applied_subjects` as sas left join subject_master sm on sm.sub_id=sas.subject_id where sas.stud_id='".$stud_id."' and sas.exam_id='$exam_id' and sm.is_active='Y'";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function getCurrentExamAllocatedSubject($stud_id,$semester,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		/*$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_id =$ex_session[0]['exam_id'];*/

		$sql="SELECT sas.stud_id, sm.subject_name, sas.subject_id, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester, d.semester as ed_sem FROM `phd_exam_applied_subjects` as sas 
		left join phd_exam_details d on d.stud_id= sas.stud_id and d.exam_id=sas.exam_id and d.stream_id=sas.stream_id
		left join subject_master sm on sm.sub_id=sas.subject_id where sas.stud_id='".$stud_id."' and sas.exam_id='$exam_id' and sm.is_active='Y'";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function get_student_id_by_prn($enrollment_no){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("admission_cycle,stud_id,current_semester,admission_stream,admission_session,academic_year");
		$DB1->from('student_master');
		$DB1->where("enrollment_no", $enrollment_no);
		$where = "admission_cycle is  NOT NULL";
		$DB1->where($where);
		$query=$DB1->get();
		$result=$query->row_array();
		//echo $DB1->last_query();exit;
		return $result;
        

	}
	// fetch personal details
	function fetch_personal_details($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,stm.gradesheet_name,stm.specialization, stm.course_name,stm.stream_code,stm.course_short_name, stm.course_id, stm.stream_id,stm.school_name,stm.school_code, stm.school_short_name, stm.course_duration, stm.course_pattern");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->where('sm.stud_id', $stud_id);
		$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
		function fetch_stud_curr_exam(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("e.exam_month,e.exam_year,e.exam_id,e.exam_type,m.frm_end_date,m.frm_open_date,m.frm_latefee_date");
		$DB1->from('phd_exam_session e');
		$DB1->join('phd_marks_entery_date as m','m.exam_id = e.exam_id','left');
		$DB1->where("e.is_active", 'Y');
		$DB1->order_by("e.exam_id", 'desc');
		//$DB1->limit(1);
		$query=$DB1->get();
		$result=$query->result_array();
	// echo $DB1->last_query();
		return $result;
	}
	function fetch_exam_session_byid($exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('phd_exam_session');
		$DB1->where("exam_id", $exam_id);
		$DB1->where("is_active", 'Y');	
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}	
	function course_streams(){
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
	function fetch_stud_phd_exam_details($stud_id='', $exam_id=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		if($exam_id==''){
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_id =$ex_session[0]['exam_id'];
		}
		$DB1->select("*");
		$DB1->from('phd_exam_details');
		$DB1->where("stud_id", $stud_id);
		$DB1->where("exam_id", $exam_id);
		$DB1->where("is_active", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	
	// fetch banks
	function fetch_banks(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('bank_master');
		$DB1->where("active", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}	
	
	// fetch student fee details
    function fetch_stud_fee_exam($stud_id){
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_month =$ex_session[0]['exam_month'];
		$exam_year =$ex_session[0]['exam_year'];
		$exam_id =$ex_session[0]['exam_id'];
		$DB1 = $this->load->database('umsdb', TRUE);
		if($exam_type!='Makeup'){
			$DB1->select("f.*,b.bank_name");
			$DB1->from('fees_details as f');
			$DB1->join('bank_master as b','f.bank_id = b.bank_id','left');
			$DB1->where('f.exam_session', $exam_id);
			$DB1->where('f.student_id', $stud_id);
			$DB1->where('f.type_id', 5);
			$DB1->where("chq_cancelled",'N');
		}else{
			$DB1->select("exam_fees");
			$DB1->from('phd_exam_details');
			$DB1->where('exam_month', $exam_month);
			$DB1->where('exam_year', $exam_year);
			$DB1->where("stud_id",$stud_id);	
		}
		$query=$DB1->get();
		$result=$query->result_array();
	//	echo $DB1->last_query();exit;
		return $result;
	}
	
	function searchStudentsajax($data){
		//print_r($data['prn']);exit;
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_month =$ex_session[0]['exam_month'];
		$exam_year =$ex_session[0]['exam_year'];
		$prn = $data['prn'];
		$academic_year = $data['academic_year'];
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,stm.school_name,stm.school_code,stm.school_short_name");
		$DB1->from('student_master as sm');
		$where = "admission_cycle is  NOT NULL";
		$DB1->where($where);
		//$DB1->join('phd_exam_details as ed','sm.stud_id = ed.stud_id','left');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');

		if($prn!=''){
			$where = "sm.enrollment_no='$prn' AND sm.cancelled_admission='N'";
			$DB1->where($where);	    
		}
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		
		return $result;
	}
	function studentExamDetails($data){
		//print_r($data['prn']);exit;
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_id =$ex_session[0]['exam_id'];
		$prn = $data['prn'];
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month, exam_fees, exam_year,allow_for_exam,exam_id, semester as exam_semester");
		$DB1->from('phd_exam_details');
		if($prn!=''){
			$where = "enrollment_no='$prn' and exam_id='$exam_id'";
			$DB1->where($where);	    
		}
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		
		return $result;
	}
	function fetch_fees($data){
		$DB1 = $this->load->database('umsdb', TRUE);
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_id =$ex_session[0]['exam_id'];
		$DB1->select("f.amount");
		$DB1->from('student_master as sm');
		$DB1->join('fees_details as f','sm.stud_id = f.student_id','left');
		$DB1->where('f.type_id', 5);
		$DB1->where('f.exam_session', $exam_id);
		if($data['prn']!=''){
			$DB1->where("sm.enrollment_no",$data['prn']);	    
		}
		$query=$DB1->get();

		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}	
	// fetch semester subject
	function getSemesterSubject($sem, $stream){
		
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE is_active='Y' ";  
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,158,159,162);
		$stream_arr1 = array(43,44,45,46,47);
		if($sem!=""){
			$where.=" AND sm.semester='".$sem."'";
		}
	
		if(in_array($stream,  $stream_arr)){
			$where.=" AND sm.stream_id =9";	


		}else{
			$where.=" AND sm.stream_id='".$stream."'";
		}
		/*else if(in_array($stream,  $stream_arr1)){
			$where.=" AND sm.stream_id =103";
		}*/	
		
		$sql="SELECT sm.* FROM subject_master sm $where";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}	
	//
	function delete_subjects($data){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sem = $data['semester'];
		$exam_id = $data['exam_id'];
		$stream_id = $data['stream_id'];
		$exam_month = $data['exam_month'];
		$exam_year = $data['exam_year'];
		$stud_id = $data['stud_id'];
		$sql="DELETE FROM `phd_exam_applied_subjects` where stud_id ='$stud_id' and stream_id ='$stream_id' and exam_month ='$exam_month' and exam_year ='$exam_year' and exam_id ='$exam_id'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return true;
	}
	
	
	function getCollegeCourse(){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT(course_id),course_name,course_short_name FROM vw_stream_details";
	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	
	
	
	function list_allstudents($streamid='',$year=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.enrollment_no,sm.enrollment_no_new,sm.first_name,sm.middle_name,sm.current_year,sm.current_semester,sm.last_name,vsd.school_short_name,vsd.course_short_name,vsd.stream_name");
		$DB1->from('student_master as sm');
		//	$DB1->join('couse_master as scm','d.emp_id = e.emp_id','left');
		//	$DB1->join('stream_master as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
		if($_POST['admission-course']==0){
			    
		}
		else{
			$DB1->where("vsd.course_id",$_POST['admission-course']);	    
		}
		
		if($_POST['admission-stream']!=''){
			//$DB1->where("sm.admission_stream", $year);
			if($_POST['admission-stream']==0){
			    
			}
			else{
				$DB1->where("sm.admission_stream",$_POST['admission-stream']);	    
			}
			
		}
		
		if($_POST['semester']!=''){
			//$DB1->where("sm.admission_stream", $year);
			if($_POST['semester']==0){
			    
			}
			else{
				$DB1->where("sm.current_semester",$_POST['semester']);	    
			}
			
		}
		

		$DB1->where("sm.cancelled_admission",'N');
		$DB1->where("sm.academic_year",'2019');
	
		$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
		 // echo $DB1->last_query();
		//die();  
		$result=$query->result_array();
		//echo $this->db->last_query();
		/* die();   */  
		//	$result=$query->result_array();
		return $result;
	}
	
	
	function list_examallstudents($streamid='',$year=''){
		//print_r($_POST);exit;
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.enrollment_no,sm.admission_semester,sm.enrollment_no,sm.first_name,sm.middle_name,sm.current_year,sm.current_semester,sm.last_name,vsd.school_short_name,vsd.course_short_name,vsd.stream_name,vsd.stream_short_name, ed.exam_fees_paid,ed.exam_fees as fee, ed.allow_for_exam,sm.stud_id");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
		$DB1->join('phd_exam_details as ed','sm.stud_id = ed.stud_id','left');
		
		if($exam_type=='Makeup'){
			$categories = array('U','WH');
			$DB1->join('exam_result_data as er','ed.stud_id = er.student_id','left');
			$DB1->where_in('er.result_grade', $categories);
		}
		$DB1->where("sm.cancelled_admission",'N');
		$DB1->where("sm.academic_year",'2019');
		//$DB1->where("ed.exam_id",'7');
		//$DB1->where("ed.exam_month",$ex_session[0]['exam_month']);
	//	$DB1->where("ed.exam_year",$ex_session[0]['exam_year']);
		
		
		if($_POST['admission-branch']!=''){
			//$DB1->where("sm.admission_stream", $year);
			if($_POST['admission-branch']==0){
			    
			}
			else{
				$DB1->where("sm.admission_stream",$_POST['admission-branch']);	    
			}
			
		}
		
		if($exam_type !='Makeup'){
			if($_POST['semester']!=''){
				if($_POST['semester']==0){
				    
				}
				else{
					$DB1->where("sm.current_semester",$_POST['semester']);	    
				}
				
			}
		}else{
			if($_POST['semester']!=''){
				if($_POST['semester']==0){
				    
				}
				else{
					$DB1->where("ed.semester",$_POST['semester']);	    
				}
				
			}
			$DB1->group_by("sm.enrollment_no");
		}

		$DB1->group_by("sm.enrollment_no");		
		$DB1->order_by("sm.enrollment_no", "asc");
		$DB1->order_by("sm.admission_stream", "asc");
		$DB1->order_by("sm.current_semester", "asc");
		$query=$DB1->get();
		  //echo $DB1->last_query();die();   
		$result=$query->result_array();
		return $result;
	}	
	
	function getFeedetails($student_id){
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_month =$ex_session[0]['exam_month'];
		$exam_year =$ex_session[0]['exam_year'];
		$DB1 = $this->load->database('umsdb', TRUE);
		if($exam_type!='Makeup'){
			$DB1->select("f.amount");
			$DB1->from('fees_details as f');
			$DB1->where('f.type_id', 5);
			$DB1->where("f.student_id",$student_id);	    
		}else{
			$DB1->select("exam_fees");
			$DB1->from('phd_exam_details as f');
			$DB1->where('exam_month', $exam_month);
			$DB1->where('exam_year', $exam_year);
			$DB1->where("stud_id",$student_id);	
		}
		$query=$DB1->get();

		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
		
	function getExamformStatus($student_id,$exam_month, $exam_year){
		$DB1 = $this->load->database('umsdb', TRUE);
		$query = $DB1->query('SELECT * FROM phd_exam_details where exam_month ="'.$exam_month.'" and exam_year="'.$exam_year.'" and stud_id="'.$student_id.'"');
		//echo $query->num_rows();
		//echo $DB1->last_query();exit;
		return $query->num_rows();
	}
	
	function UpdateHoldStatus($student_id,$exam_month, $exam_year){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where = "exam_month='$exam_month' AND exam_year='$exam_year' AND stud_id='$student_id'";
		$DB1->set('allow_for_exam', 'N');
		$DB1->where($where);
		$DB1->update('phd_exam_details'); 
		
		$DB1->set('allow_for_exam', 'N');
		$DB1->where($where);
		$DB1->update('phd_exam_applied_subjects');
		//echo $DB1->last_query();exit;
		return true;
	} 
	function UpdateApproveStatus($student_id,$exam_month, $exam_year){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where = "exam_month='$exam_month' AND exam_year='$exam_year' AND stud_id='$student_id'";
		$DB1->set('allow_for_exam', 'Y');
		$DB1->where($where);
		
		$DB1->update('phd_exam_details'); 
		$DB1->set('allow_for_exam', 'Y');
		$DB1->where($where);
		$DB1->update('phd_exam_applied_subjects');
		//echo $DB1->last_query();exit;
		return true;
	}	 
	function getSchools(){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT(stream_id),school_code, school_short_name FROM vw_stream_details";
	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	function getExamAppledSchools($exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT ed.school_code, vw.school_short_name FROM phd_exam_details ed left join vw_stream_details vw on vw.school_code = ed.school_code where ed.exam_id = '$exam_id'";	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	function get_course_streams($course_id){
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
	function get_streams($course_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");

		$sql = "select stream_id,stream_name,stream_short_name from vw_stream_details where course_id='".$course_id."' ";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	function list_exam_allstudents($data){
		//print_r($data);exit;
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.enrollment_no,sm.admission_semester,sm.enrollment_no_new,sm.first_name,sm.middle_name,sm.current_year,sm.last_name,vsd.school_short_name,vsd.course_short_name,vsd.stream_name, ed.exam_fees_paid, ed.allow_for_exam,sm.stud_id");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as vsd','sm.admission_stream = vsd.stream_id','left');
		$DB1->join('phd_exam_details as ed','sm.stud_id = ed.stud_id','left');
		if($data['admission_course']==0){
			    
		}
		else{
			$DB1->where("vsd.course_id",$data['admission_course']);	    
		}
		
		if($data['admission_stream']!=''){
			//$DB1->where("sm.admission_stream", $year);
			if($data['admission_stream']==0){
					
			}
			else{
				$DB1->where("sm.admission_stream",$data['admission_stream']);	    
			}
			
		}
		
		if($data['semester']!=''){
			//$DB1->where("sm.admission_stream", $year);
			if($data['semester']==0){
			    
			}
			else{
				$DB1->where("sm.current_semester",$data['semester']);	    
			}
			
		}
		

		$DB1->where("sm.cancelled_admission",'N');
		$DB1->where("sm.academic_year",'2019');
	
		$DB1->order_by("sm.enrollment_no_new", "asc");
		$query=$DB1->get();
		//echo $DB1->last_query();
		//die(); 
		$result=$query->result_array();
		//echo $this->db->last_query();
		//  die();     
		//	$result=$query->result_array();
		return $result;
	}		
	
	function getSubjectTimetable($stud_id, $exam_month, $exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		//$ex_session = $this->fetch_stud_curr_exam();
		//$exam_type =$ex_session[0]['exam_type'];


		$sql="SELECT sas.stud_id, sm.subject_name, sas.subject_id, sm.sub_id, sm.subject_code,sm.subject_code1,sm.semester,sm.subject_component,sm.subject_type, et.date,et.from_time,et.to_time,case when sm.subject_component='EM' then 'TH' else sm.subject_component end as subtype FROM phd_exam_applied_subjects as sas 
		left join subject_master sm on sm.sub_id = sas.subject_id 
		left join phd_exam_time_table as et on et.subject_id =sas.subject_id and et.exam_id=sas.exam_id
		where sas.stud_id='".$stud_id."' AND sas.exam_id='$exam_id' and et.display_on_hallticket='Y'";		
		
		$sql.=" group by sas.subject_id order by et.semester,subtype desc, et.date";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	
	function exam_report_students($streamid='',$year='', $exam_id,$exam_type){

		$DB1 = $this->load->database('umsdb', TRUE);
		
		$DB1->select("ed.*, sm.enrollment_no, sm.first_name, sm.middle_name, sm.last_name,sm.current_semester");
		$DB1->from('phd_exam_details as ed');
		if($exam_type=='Makeup'){
		//	$DB1->where_in('er.result_grade', $categories);
			$DB1->join('exam_result_data as er','ed.stud_id = er.student_id','left');	
		}
		$DB1->join('student_master as sm','sm.stud_id = ed.stud_id','left');
		
		if($_POST['school_code']==0){
			    
		}
		else{
			//$DB1->where("ed.school_code",$_POST['school_code']);	    
		}
		
		if($_POST['admission-branch']!=''){

			if($_POST['admission-branch']==''){
					
			}
			else{
				$DB1->where("ed.stream_id",$_POST['admission-branch']);	    
			}
			
		}
		
		if($_POST['semester']!=''){
			if($_POST['semester']==0){
					
			}
			else{
				$DB1->where("ed.semester",$_POST['semester']);	    
			}
			
		}
		

		$DB1->where("ed.allow_for_exam",'Y');
		$DB1->where("ed.exam_id", $exam_id);
		$DB1->where("sm.cancelled_admission",'N');
	//	$DB1->where("sm.academic_year",'2017');
		if($exam_type=='Makeup'){
			$DB1->group_by("sm.enrollment_no");
		}
		$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
		//echo $DB1->last_query();		die();  
		$result=$query->result_array();
		return $result;
	}
	// Fetch exam details schools
	function getExamSchools(){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT(ed.school_code),vsd.school_short_name FROM phd_exam_details ed left join vw_stream_details as vsd on ed.school_code = vsd.school_code";
	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	// fetch exam cources
	function get_examcourses($school_code, $exam_session){
		$exam = explode('-',$exam_session);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_id =$exam[2];
		$sql="select v.course_id, v.course_name, v.course_short_name from (select DISTINCT stream_id from phd_exam_details where exam_id='$exam_id') as e left join vw_stream_details as v on v.stream_id= e.stream_id where v.school_code='$school_code' group by v.course_id";
	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();		die();  
		return $query->result_array();
	}
	function load_examsess_schools($exam_session){
		$exam = explode('-',$exam_session);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_id =$exam[2];
		$sql="select v.stream_id, v.school_code, v.school_short_name from (select DISTINCT stream_id from phd_exam_details where exam_id='$exam_id') as e left join vw_stream_details as v on v.stream_id= e.stream_id group by v.school_code";	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	function load_exam_dates($exam_session){
		$exam = explode('-',$exam_session);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_id =$exam[2];
		$sql="select v.stream_id, v.school_code, v.school_short_name from (select DISTINCT stream_id from phd_exam_details where exam_id='$exam_id') as e left join vw_stream_details as v on v.stream_id= e.stream_id group by v.school_code";	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	// fetch exam streams
	function get_examstreams($course_id, $exam_session){
		$exam = explode('-',$exam_session);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_id =$exam[2];
		$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name from phd_exam_details ed left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id where vsd.course_id='".$course_id."' and ed.exam_id='$exam_id'";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// fetch exam strams
	function get_examsemester($stream_id,$exam_session){
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam =explode('-', $exam_session);
		$exam_id = $exam[2];
		$sql = "select distinct semester from phd_exam_applied_subjects where stream_id='".$stream_id."' and exam_id ='$exam_id' and allow_for_exam='Y' order by semester asc";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// fetch exam subjects
	function fetchExamSubjects($streamid='',$year=''){
	    $stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,158,159,162);
	    $streamid = $_POST['admission-branch'];
        /*if(in_array($streamid,  $stream_arr)){
			$stream_id='9';	
		}else{
		    $stream_id= $streamid;	
		}*/
		$exam_session = explode('-',$_POST['exam_session']);
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select et.subject_id, eas.subject_code,eas.subject_component, eas.subject_name, vsd.stream_name, vsd.school_short_name, et.date,et.from_time,et.to_time,et.semester from phd_exam_applied_subjects es 
left join phd_exam_time_table as et on et.subject_id = es.subject_id and et.exam_id=es.exam_id 
left join subject_master as eas on et.subject_id = eas.sub_id 
left join vw_stream_details as vsd on et.stream_id = vsd.stream_id   
		where es.exam_month='".$exam_session[0]."' AND es.exam_year='".$exam_session[1]."' AND es.stream_id='".$streamid."' AND es.semester='".$_POST['semester']."' and eas.is_active='Y' and es.allow_for_exam='Y' group by es.subject_id";
		
		$query = $DB1->query($sql);
	    //echo $DB1->last_query();		die();  
		$result=$query->result_array();
		return $result;
	}
	
	function getSubjectStudentList($subject_id,$stream_id, $exam_month, $exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);  

		/*$sql="SELECT sas.stud_id,s.is_detained, sas.enrollment_no, sas.subject_id,s.first_name, s.middle_name,
		 s.last_name,sas.is_absent FROM `phd_exam_applied_subjects` as sas 
		left join phd_exam_details ed on ed.exam_id=sas.exam_id and ed.enrollment_no=sas.enrollment_no
		left join subject_master sm on sm.sub_id=sas.subject_id 
		left join student_master s on s.stud_id=sas.stud_id 
		left join exam_ans_booklet_attendance eb on eb.student_id=sas.stud_id and eb.exam_id=sas.exam_id and eb.subject_id=sas.subject_id
		where sas.subject_id='".$subject_id."' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' 
		and sm.is_active='Y' and sas.allow_for_exam='Y'  ";
		$sql.=" group by sas.stud_id order by sas.enrollment_no";*/
		$sql="
			SELECT sas.stud_id,s.is_detained, sas.enrollment_no, sas.subject_id,s.first_name, s.middle_name, s.last_name,
			eb.exam_attendance_status as is_absent 
			FROM `phd_exam_applied_subjects` as sas 
			LEFT JOIN phd_exam_details ed on ed.exam_id=sas.exam_id and ed.enrollment_no=sas.enrollment_no
			LEFT JOIN subject_master sm on sm.sub_id=sas.subject_id 
			LEFT JOIN student_master s on s.stud_id=sas.stud_id 
			LEFT JOIN exam_phd_ans_booklet_attendance eb on eb.student_id=sas.stud_id and eb.exam_id=sas.exam_id and eb.subject_id=sas.subject_id
			where sas.subject_id='".$subject_id."' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and sm.is_active='Y' and sas.allow_for_exam='Y'  ";
		$sql.=" group by sas.stud_id order by sas.enrollment_no";
		$query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// get_tot_fee_paid
	function get_tot_fee_paid($studentId, $academic_year){
		$DB1 = $this->load->database('umsdb', TRUE);

		$sql = "SELECT sum(`amount`) as tot_fee_paid FROM `fees_details` WHERE `student_id`=$studentId and chq_cancelled='N' and Type_id=2 and academic_year='$academic_year'";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
		
	}	
	// fetch Applicable fees
	function fetch_admissionApplicable_fees($studentId, $stream_id, $academic_year){
		$DB1 = $this->load->database('umsdb', TRUE);

		$sql = "SELECT applicable_fee, total_fees_paid FROM `admission_details` WHERE `student_id`=$studentId and cancelled_admission='N' and stream_id='$stream_id' and academic_year='$academic_year'";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
		
	}
	function get_subject_details($studentId, $stream, $sem){
		$DB1 = $this->load->database('umsdb', TRUE);
		$where=" WHERE sas.is_active='Y' AND sas.academic_year='2019-20' AND sas.stud_id='$studentId' ";  
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,158,159,162);
		$stream_arr1 = array(43,44,45,46,47);
		if($sem!=""){
			$where.=" AND sm.semester='".$sem."' AND sm.is_active='Y'";
		}
	
		if(in_array($stream,  $stream_arr)){
			$where.=" AND sm.stream_id =9";	


		}else{
			$where.=" AND sm.stream_id='".$stream."'";
		}	
		/*else if(in_array($stream,  $stream_arr1)){
			$where.=" AND sm.stream_id =103";
		}*/
		$sql = "SELECT sm.* FROM student_applied_subject sas 
		left join `subject_master` as sm on sm.sub_id = sas.subject_id
		$where ";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
		
	}
	// check 
	function checkConsolidatedAttendance($student_id, $subId, $semester){
		$emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where=" WHERE 1=1 ";  
		if($emp_id!=""){
			$where.=" AND subject_id ='".$subId."' AND student_id ='".$student_id."' and academic_year='2019-20' and semester='$semester'";
		}		
		$sql="SELECT is_present FROM `lecture_attendance` $where";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();echo "<br>";
		return $query->result_array();
	}
	//getStreamShortName
	function getStreamShortName($stream_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT stream_short_name,stream_code,stream_name, school_short_name,school_name FROM vw_stream_details where stream_id='".$stream_id."'";	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	function searchCheckStudentbyprn($data){
		//print_r($data['prn']);exit;
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_month =$ex_session[0]['exam_month'];
		$exam_year =$ex_session[0]['exam_year'];
		$prn = $data['prn'];
		$academic_year = $data['academic_year'];
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,stm.school_name,stm.school_code, ed.exam_month,ed.exam_fees, ed.exam_year,ed.allow_for_exam,ed.semester as exam_semester, stm.school_short_name");
		$DB1->from('student_master as sm');
		$DB1->join('phd_exam_details as ed','sm.stud_id = ed.stud_id','left');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		if($prn!=''){
			$where = " sm.enrollment_no='$prn' AND sm.cancelled_admission='N' AND sm.academic_year='$academic_year'";
			$DB1->where($where);	    
		}
		$DB1->group_by('sm.enrollment_no');
		$query=$DB1->get();
		//echo $DB1->last_query();
		$result=$query->result_array();
		
		return $result;
	}
	function searchCheckStudent($data){
		//print_r($data['prn']);exit;
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_month =$ex_session[0]['exam_month'];
		$exam_year =$ex_session[0]['exam_year'];
		$prn = $data['prn'];
		$academic_year = $data['academic_year'];
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,stm.school_name,stm.school_code, ed.exam_month,ed.exam_fees, ed.exam_year,ed.allow_for_exam,stm.school_short_name");
		$DB1->from('student_master as sm');
		$DB1->join('phd_exam_details as ed','sm.stud_id = ed.stud_id','left');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$categories = array('U','WH');
		$DB1->join('exam_result_data as er','ed.stud_id = er.student_id','left');
		$DB1->where_in('er.result_grade', $categories);
		if($prn!=''){
			$where = " er.enrollment_no='$prn' AND sm.cancelled_admission='N' AND sm.academic_year='$academic_year'";
			$DB1->where($where);	    
		}
		$DB1->group_by('er.enrollment_no');
		$query=$DB1->get();
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		
		return $result;
	}
	function getExamSubject($stud_id, $stud_stream=''){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$prev_exam_id=$ex_session[0]['exam_id']-1;
		$where=" WHERE 1=1 ";  
        

		if($exam_type=='Regular'){
			$sql="SELECT sas.stud_id, sm.subject_name, sas.subject_id, sm.sub_id, sm.subject_code,sm.semester,sm.subject_component FROM `phd_exam_applied_subjects` as sas left join subject_master sm on sm.sub_id=sas.subject_id where sas.stud_id='".$stud_id."' and sm.is_active='Y'";	
		}else{
			$sql="SELECT er.student_id as stud_id, sm.subject_name, er.subject_id, sm.sub_id, sm.subject_code,sm.credits,sm.subject_code1,sm.semester,sm.subject_component  FROM `exam_result_data` as er 
		left join phd_exam_details d on d.stud_id=er.student_id and d.exam_id=er.exam_id and d.stream_id=er.stream_id and d.semester=er.semester  
		left join subject_master sm on sm.sub_id=er.subject_id 
		where er.student_id='".$stud_id."' and d.semester=er.semester and er.final_grade ='U' and er.final_grade !='WH' and er.exam_id='$prev_exam_id' and (sm.subject_component='TH'  OR sm.subject_component='EM')";//and er.malpractice='N' 
			if($stud_stream=='71'){
				$sql .=" and er.semester =1";
			}else{
				//$sql .=" and er.semester in('1','3','5')";
			}
		}	
		$query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch exam dates	
	function fetch_examdates($exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where exam_id='$exam_id'" ;
		$sql="SELECT distinct `date` as exam_date FROM `phd_exam_time_table` $where order by date asc";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;		
	}	
	function exam_daywise_report($exam_date,$exam_month,$exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' " ;
		if($exam_date !='' && $exam_date !='0'){
			$where .= " and t.date='$exam_date'";
		}
		$sql="SELECT t.`exam_id`, t.`subject_id`, count(*)AS TOT, vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code,s.subject_name, t.`stream_id`, t.`semester`,t.`from_time`,t.`to_time`,t.`date` 
FROM `phd_exam_applied_subjects` eas 
left join phd_exam_time_table as t on eas.subject_id = t.subject_id and t.exam_id=eas.exam_id
left join subject_master as s on s.sub_id = t.subject_id 
left join vw_stream_details vw on vw.stream_id = t.stream_id   
		$where group by eas.subject_id order by t.date,t.from_time,t.to_time, t.stream_id, t.semester asc";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;		
	}
	function exam_daywiseqpindend_report($exam_date,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' and e.allow_for_exam='Y' and t.exam_id='$exam_id'" ;
		if($exam_date !='' && $exam_date !='0'){
			$where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
		}
		$sql="SELECT t.`exam_id`, t.`subject_id`, count(*)AS TOT, vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code,s.subject_name,s.regulation, t.`stream_id`, t.`semester`,e.semester as curr_sem, t.`from_time`,t.`to_time`,t.`date`,t.batch  
FROM phd_exam_time_table as t
left join `phd_exam_applied_subjects` eas on eas.subject_id = t.subject_id and t.exam_id=eas.exam_id
left join phd_exam_details as e on e.stud_id = eas.stud_id and e.exam_id=eas.exam_id
left join subject_master as s on s.sub_id = t.subject_id 
left join vw_stream_details vw on vw.stream_id = t.stream_id   
		$where group by t.subject_id,s.batch order by s.batch desc,t.date,t.from_time,t.to_time, t.semester, t.stream_id asc";
		$query = $DB1->query($sql);
		$result = $query->result_array();
	//echo $DB1->last_query(); echo"<br>";exit;
		return $result;		
	}
	//
	function exam_daywise_slot($exam_date,$exam_month,$exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' and t.exam_id='$exam_id'" ;
		if($exam_date !='' && $exam_date !='0'){
			$where .= " and t.date='$exam_date'";
		}
		$sql="SELECT t.`from_time`, t.`to_time`, t.`date` FROM `phd_exam_applied_subjects` eas left join phd_exam_time_table as t on eas.subject_id = t.subject_id  
		$where group by t.from_time,t.to_time order by t.from_time desc";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;		
	}
	//
	function get_excel_data($arr, $exam_month, $exam_year, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$stream = $arr['admission-branch'];
		$semester =$arr['semester'];
		$where ="where e.stream_id='$stream' AND e.semester='$semester' AND e.exam_id='$exam_id'" ;
		$sql="SELECT CONCAT(' ',e.enrollment_no),UPPER(CONCAT(sm.first_name,'   ',sm.middle_name,'  ',sm.last_name)) as stud_name,e.semester,t.date,t.from_time,t.to_time,s.subject_code,s.subject_name,v.stream_short_name,v.school_short_name,v.course_short_name FROM phd_exam_applied_subjects e 
		LEFT JOIN phd_exam_time_table t ON e.exam_id=t.exam_id AND e.subject_id=t.subject_id
		LEFT JOIN subject_master s ON s.sub_id=t.subject_id
		LEFT JOIN vw_stream_details v ON v.stream_id=e.stream_id
		LEFT JOIN student_master sm ON sm.enrollment_no=e.enrollment_no

		$where ORDER BY t.date,t.stream_id,t.semester,t.subject_code";//exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}	
	//  fetch exam applied stream
	function fetch_exam_applied_streams($exam_month, $exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where eas.exam_month='$exam_month' AND eas.exam_year='$exam_year' and eas.exam_id='$exam_id' " ;
		$sql="SELECT distinct eas.`stream_id`,vw.stream_short_name, vw.stream_code FROM `phd_exam_applied_subjects` eas 
		LEFT JOIN vw_stream_details vw on vw.stream_id = eas.stream_id 
		$where order by stream_short_name asc";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;		
	}
	function get_exam_subjects($ex_date, $stream, $exam_month,$exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where t.date='$ex_date' and eas.exam_month='$exam_month' AND eas.exam_year='$exam_year' and eas.exam_id='$exam_id' and eas.stream_id='$stream'" ;
		$sql="SELECT distinct eas.`subject_id`, eas.stream_id, s.subject_code1, s.subject_code, s.subject_short_name FROM `phd_exam_applied_subjects` eas 
		LEFT JOIN subject_master s on s.sub_id = eas.subject_id 
		left join phd_exam_time_table as t on eas.subject_id = t.subject_id 
		$where order by subject_short_name asc";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;		
	}	
	function get_exam_streams($ex_date,$exam_month,$exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where t.date='$ex_date' and eas.exam_month='$exam_month' AND eas.exam_year='$exam_year' and eas.exam_id='$exam_id' " ;
		$sql="SELECT vw.stream_short_name, vw.stream_code, eas.`stream_id`,t.`date` FROM `phd_exam_applied_subjects` eas 
		left join phd_exam_time_table as t on eas.subject_id= t.subject_id
		left join vw_stream_details vw on vw.stream_id = eas.stream_id 
		$where group by eas.stream_id";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;		
	}
	function fetch_exam_datewise_applied_student($stream,$exam_date,$subject_id,$exam_month, $exam_year, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' AND eas.stream_id='$stream' AND t.date='$exam_date' AND eas.exam_id='$exam_id' and eas.subject_id='$subject_id' and eas.allow_for_exam='Y'" ;

		$sql="SELECT eas.is_absent, eas.exam_subject_id,t.`exam_id`, t.`subject_id`,eas.stud_id,sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,
		vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code1,s.subject_name, t.`stream_id`,
		t.`semester`,t.`from_time`,t.`to_time`,t.`date` FROM `phd_exam_applied_subjects` eas 
		left join phd_exam_time_table as t on eas.subject_id = t.subject_id 
		left join subject_master as s on s.sub_id = eas.subject_id 
		left join vw_stream_details vw on vw.stream_id = eas.stream_id  
		left join student_master sm on sm.stud_id = eas.stud_id 
		$where GROUP BY eas.stud_id";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}
	function mark_absent_students($stud,$sub, $stream,$exam_month, $exam_year, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where = "exam_subject_id='$stud' and subject_id='$sub' and stream_id='$stream' and exam_id='$exam_id'";
		$data = array(
               'is_absent' => 'Y',
               'absent_mark_by' => $this->session->userdata("uid"),
               'absent_mark_on' => date("Y-m-d H:i:s")
            );
		//$DB1->set('is_absent', 'Y');
		$DB1->where($where);
		$DB1->update('phd_exam_applied_subjects', $data); 
		//echo $DB1->last_query();exit;
		return true;
	}
	function mark_present_students($stud,$sub, $stream,$exam_month, $exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where = "exam_subject_id='$stud' and subject_id='$sub' and stream_id='$stream' and exam_id='$exam_id'";
		$data = array(
               'is_absent' => 'N',
               'absent_mark_by' => $this->session->userdata("uid"),
               'absent_mark_on' => date("Y-m-d H:i:s")
            );
		//$DB1->set('is_absent', 'N');
		$DB1->where($where);
		$DB1->update('phd_exam_applied_subjects', $data); 
		//echo $DB1->last_query();exit;
		return true;
	}
	function searchStudent_for_malpractice($prn,$exam_date,$exam_month, $exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where eas.enrollment_no='$prn' AND t.date='$exam_date' AND eas.exam_id='$exam_id' group by eas.subject_id"  ;

		$sql="SELECT eas.malpractice as is_malpractice,eas.remark, eas.exam_subject_id,t.`exam_id`, t.`subject_id`,eas.stud_id,sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,
		vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code1,s.subject_code,s.subject_name, t.`stream_id`,
		t.`semester`,t.`from_time`,t.`to_time`,t.`date` FROM `phd_exam_applied_subjects` eas 
		left join phd_exam_time_table as t on eas.subject_id = t.subject_id and eas.exam_id =t.exam_id
		left join subject_master as s on s.sub_id = t.subject_id 
		left join student_master sm on sm.stud_id = eas.stud_id 
		left join vw_stream_details vw on vw.stream_id = sm.admission_stream  
		
		$where";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}
	function update_studentdata_for_malware($exam_sub_id, $is_malpractice, $subject, $remark, $exam_month, $exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where = "exam_month='$exam_month' AND exam_year='$exam_year' AND exam_subject_id='$exam_sub_id' and subject_id='$subject' and exam_id='$exam_id'";
		$data = array(
               'malpractice' => $is_malpractice,
			   'remark' => $remark,
               'malpractice_by' => $this->session->userdata("uid"),
               'malpractice_on' => date("Y-m-d H:i:s")
            );
		//$DB1->set('malpractice', $is_malpractice);
		//$DB1->set('remark', $remark);
		$DB1->where($where);
		$DB1->update('phd_exam_applied_subjects', $data); 
		return true;
	}	
	// fetch exam_daywise_dispatch_report
	function exam_daywise_dispatch_report($exam_date,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' AND eas.exam_id='$exam_id' and eas.allow_for_exam='Y'" ;
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="SELECT t.`exam_id`, t.`subject_id`,count(eas.exam_subject_id) as TOTREG, sum(case when exam_attendance_status='P' then 1 else 0 end) as totPresent, sum(case when exam_attendance_status='A' then 1 else 0 end) as totAbsent, sum(case when malpractice='Y' then 1 else 0 end) as totmalpractice, vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code1,s.subject_code,s.subject_name, eas.`stream_id`, t.`semester`,t.`from_time`,t.`to_time`,t.`date` FROM `phd_exam_applied_subjects` eas 
		left join exam_phd_ans_booklet_attendance as eba on eas.subject_id = eba.subject_id and eba.exam_id=eas.exam_id
		left join phd_exam_time_table as t on eas.subject_id = t.subject_id left join subject_master as s on s.sub_id = t.subject_id left join vw_stream_details vw on vw.stream_id = eas.stream_id 
		$where group by eas.subject_id, eas.stream_id order by t.date, vw.stream_short_name, eas.stream_id, t.semester asc";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
	// fetch exam_daywise_absent_students
	function exam_daywise_absent_students_old($exam_date,$subject_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' AND eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`is_absent`='Y' and eas.allow_for_exam='Y'" ;
	    
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="select sm.enrollment_no FROM `phd_exam_applied_subjects` eas left join phd_exam_time_table as t on eas.subject_id = t.subject_id left join student_master sm on sm.stud_id = eas.stud_id
		$where group by sm.enrollment_no order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		//echo "<br>";
		return $result;
	}
	function exam_daywise_absent_students($exam_date,$subject_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' AND eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`exam_attendance_status`='A'" ;
	    
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="select sm.enrollment_no FROM `exam_phd_ans_booklet_attendance` eas left join phd_exam_time_table as t on eas.subject_id = t.subject_id left join student_master sm on sm.stud_id = eas.student_id
		$where group by sm.enrollment_no order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		//echo "<br>";
		return $result;
	}
	function exam_daywise_present_students($exam_date,$subject_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' AND eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`exam_attendance_status`='P'" ;
	    
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="select sm.enrollment_no FROM `exam_phd_ans_booklet_attendance` eas left join phd_exam_time_table as t on eas.subject_id = t.subject_id left join student_master sm on sm.stud_id = eas.student_id
		$where group by sm.enrollment_no order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}	
	// fetch exam_daywise_Present_students
	function exam_daywise_present_students_old($exam_date,$subject_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' AND eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`is_absent`='N' and eas.allow_for_exam='Y'" ;
	    
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="select sm.enrollment_no FROM `phd_exam_applied_subjects` eas left join phd_exam_time_table as t on eas.subject_id = t.subject_id left join student_master sm on sm.stud_id = eas.stud_id
		$where group by sm.enrollment_no order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}	
	// fetch exam_daywise_malpractice_students
	function exam_daywise_malpractice_students($exam_date,$subject_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' AND eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`malpractice`='Y' and eas.allow_for_exam='Y'" ;
	    
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="select sm.enrollment_no FROM `phd_exam_applied_subjects` eas left join phd_exam_time_table as t on eas.subject_id = t.subject_id left join student_master sm on sm.stud_id = eas.stud_id
		$where group by sm.enrollment_no order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
	function get_malpractice_list_data($exam_month,$exam_year, $exam_id){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where eas.exam_id='$exam_id' and eas.`malpractice`='Y' group by eas.stud_id, eas.subject_id order by t.date desc" ;
	    
	    $sql="SELECT eas.malpractice,eas.remark, eas.exam_subject_id,t.`exam_id`,eas.exam_month,eas.exam_year, t.`subject_id`,eas.stud_id,sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,
		vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code1,s.subject_code,s.subject_name, t.`stream_id`,
		t.`semester`,t.`from_time`,t.`to_time`,t.`date` FROM `phd_exam_applied_subjects` eas 
		left join phd_exam_time_table as t on eas.subject_id = t.subject_id and eas.exam_id = t.exam_id 
		left join subject_master as s on s.sub_id = t.subject_id 
		left join student_master sm on sm.stud_id = eas.stud_id 
		left join vw_stream_details vw on vw.stream_id = sm.admission_stream  
		
		$where ";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
    function exam_marklist_students($exam_date,$subject_id,$stream_id,$exam_month,$exam_year,$exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);
        $where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' AND eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`is_absent`='N' and malpractice='N'" ;
        
        if($exam_date !='' && $exam_date !='0'){
            $where .= " and t.date='$exam_date'";
        }
        $sql="select sm.enrollment_no FROM `phd_exam_applied_subjects` eas left join phd_exam_time_table as t on eas.subject_id = t.subject_id left join student_master sm on sm.stud_id = eas.stud_id
		$where order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
    }
    // student backlog subject list
    function getStudbacklogSubject($stud_id,$current_semester=''){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$academic_year=$this->config->item('academic_current_year');
		$curr_acd_yr= explode('-',$academic_year);
		$where=" WHERE 1=1 ";  
       $role_id = $this->session->userdata('role_id');
        if($role_id==15){     // time being this condition is added
			if($stream_id==71){
				$varb ="sas.academic_year !='$academic_year'";
			}else{
				$varb ="sas.semester !='$current_semester'";
			}
		}else{
			if($stream_id==71){
				$varb ="sas.academic_year !='$academic_year'";
			}else{
				$varb ="sas.semester !='$current_semester'";
			}
			
			
		}
		// if($std_acd_year !=$curr_acd_yr[0]){
		//	$varb ='1';
		// }
		if($stud_id!=""){
			$where.=" AND erd.student_id='".$stud_id."' AND erd.passed ='N'";
		}		
		$sql="SELECT erd.student_id, sm.subject_name, sm.sub_id, sm.subject_code,sm.semester,sm.credits,sm.batch,erd.exam_id 
		FROM `phd_exam_student_subject` as erd left join subject_master sm on sm.sub_id=erd.subject_id $where";
		
		$sql="SELECT erd.student_id, sm.subject_name, sm.sub_id, sm.subject_code,sm.semester,sm.credits,sm.batch FROM `phd_exam_student_subject` as erd left join subject_master sm on sm.sub_id=erd.subject_id $where 
		UNION 
SELECT sas.stud_id as student_id, sm.subject_name, sm.sub_id, sm.subject_code,sm.semester,sm.credits,sm.batch FROM student_applied_subject sas 
		left join `subject_master` as sm on sm.sub_id = sas.subject_id
		WHERE sas.is_active='Y' and sas.stud_id='$stud_id' AND sm.is_active='Y' and $varb and subject_id not in(select subject_id from phd_exam_applied_subjects where stud_id='".$stud_id."' and allow_for_exam ='Y')";
		
		$query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		return $query->result_array();
	}	
	    // student backlog subject list
    function getStudbacklogSubjectedit($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE 1=1 ";  
        
		if($stud_id!=""){
			$where.=" AND erd.student_id='".$stud_id."' AND erd.passed ='N'";
		}		
		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code,sm.subject_code1,sm.semester,sm.batch,sm.credits
		 FROM `phd_exam_student_subject` as erd left join subject_master sm on sm.sub_id=erd.subject_id $where";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch_examfeesdetails
    function fetch_examfeesdetails($stream_id, $examid){
		$DB1 = $this->load->database('umsdb', TRUE);  	
		$sql="SELECT * FROM `exam_fees` where exam_id='$examid' and stream_id='$stream_id' and is_active='Y'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	//
	function getExamAllocatedSubject_edit($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_id =$ex_session[0]['exam_id'];

		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester,sm.batch, sm.credits FROM `phd_exam_applied_subjects` as sas left join subject_master sm on sm.sub_id=sas.subject_id where sas.stud_id='".$stud_id."' and sas.exam_id='$exam_id'";				
		$query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch semester subject
	function getSemesterSubject_edit($sem, $stream, $batch){
		//echo $stream;
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE is_active='Y' ";  
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,158,159,162);
		$stream_arr1 = array(43,44,45,46,47);
		if($sem!=""){
			$where.=" AND sm.semester='".$sem."' and sm.batch='$batch'";//
		}
		if($sem ==1 || $sem ==2){
			if(in_array($stream,  $stream_arr) ){
				$where.=" AND sm.stream_id =9";	


			}else{
				$where.=" AND sm.stream_id='".$stream."'";
			}
			/*else if(in_array($stream,  $stream_arr1)){
				$where.=" AND sm.stream_id =103";
			}*/
		}else{
			$where.=" AND sm.stream_id='".$stream."'";
		}			
		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester,sm.batch,sm.credits FROM subject_master sm $where";
		$query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		return $query->result_array();
	}
	//
	function getExamappliedFess($stud_id, $semester){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_id =$ex_session[0]['exam_id'];

		$sql="SELECT exam_fees FROM `phd_exam_details` where stud_id='".$stud_id."' and exam_id='$exam_id' and semester='".$semester."'";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}	
	//exam result streams
	function get_examresltcourses($school_code){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT(ed.course_id),vsd.course_name, vsd.course_short_name FROM phd_exam_details ed left join vw_stream_details as vsd on ed.course_id = vsd.course_id where ed.school_code='".$school_code."' ";
	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	// fetch exam streams
	function get_examresltstreams($course_id){
		$DB1 = $this->load->database('umsdb', TRUE);

		$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name from phd_exam_details ed left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id where ed.course_id='".$course_id."' ";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// fetch exam strams
	function get_examresltsemester($stream_id){
		$DB1 = $this->load->database('umsdb', TRUE);

		$sql = "select distinct ed.semester from phd_exam_details ed where ed.stream_id='".$stream_id."' order by ed.semester asc";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	function get_exam_app_studcount($arr, $exam_month, $exam_year, $exam_id){
		
		$DB1 = $this->load->database('umsdb', TRUE); 

		$school_code =$arr['school_code'];
		
		
		$sql="select ed.stud_id, vsd.school_code, ed.stream_id, ed.semester, count(distinct ed.stud_id) as cnt, vsd.stream_name, vsd.stream_short_name,vsd.school_short_name from phd_exam_applied_subjects as ed 
		left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id 
		where ed.exam_id ='$exam_id'";
		if($school_code !='' && $school_code ==0){
			
		}else{
			$sql.=" AND vsd.school_code='$school_code'";
		}
		$sql.=" group by vsd.school_code, ed.stream_id, ed.semester";
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}	
	//
	function subject_applied_count($subject_id,$stream_id,$semester,$exam_year)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		if($exam_year=='2018'){
			$year = '2017-18';
		}elseif($exam_year=='2017'){
			$year = '2016-17';
		}elseif($exam_year=='2019'){
			$year = '2018-19';
		}else{
			$year = '2019-20';
		}
		$sql="SELECT `subject_id`, count(subject_id) as applied_cnt FROM `student_applied_subject` WHERE subject_id='$subject_id' and `stream_id`='$stream_id' and semester='$semester' and `academic_year`='$year'";
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}
	//
	function subject_applied_count_bklog($subject_id,$stream_id,$semester,$exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT es.`subject_id`, count(es.subject_id) as applied_cnt FROM `phd_exam_student_subject` es
		left join student_master s on s.stud_id = es.student_id  
		WHERE es.subject_id='$subject_id'  and es.semester='$semester' and es.`passed`='N' and s.cancelled_admission='N'";//and `stream_id`='$stream_id'
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}
	// summary report
	function get_exam_app_stud($arr, $exam_month, $exam_year, $exam_id){
		
		$DB1 = $this->load->database('umsdb', TRUE); 
		$school_code =$arr['school_code'];
		$report_type =$arr['report_type'];
		$sql="SELECT `sm`.`enrollment_no`,`sm`.`first_name`, `sm`.`middle_name`,sm.last_name, vsd.school_code, ed.stream_id, vsd.stream_name, vsd.stream_short_name,vsd.school_short_name, ed.stud_id, vsd.school_code, ed.stream_id, ed.semester,d.semester,ed.semester=d.semester AS stud_type,
vsd.stream_name, vsd.stream_short_name,vsd.school_short_name 
FROM phd_exam_applied_subjects AS ed 
LEFT JOIN phd_exam_details d ON ed.stud_id=d.stud_id AND d.exam_id=ed.exam_id
left join student_master as sm on ed.stud_id = sm.stud_id
LEFT JOIN vw_stream_details AS vsd ON ed.stream_id = vsd.stream_id 
WHERE ed.exam_id ='$exam_id' ";
		if($school_code !='' && $school_code ==0){
			
		}else{
			$sql.=" AND vsd.school_code='$school_code' ";
		}
		if($report_type == 'Statistics'){
			
		}else if($report_type == 'backlog'){
			$sql.="AND (ed.semester=d.semester)=0 ";
		}else{
			$sql.="AND (ed.semester=d.semester)=1 ";
		}
		
		$sql.=" group by ed.stud_id, ed.semester order by ed.stream_id, ed.semester";
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}
	// fetch previous all student subject
	function fetch_prev_subjects($data){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sem = $data['semester'];
		$exam_id = $data['exam_id'];
		$stream_id = $data['stream_id'];
		$exam_month = $data['exam_month'];
		$exam_year = $data['exam_year'];
		$stud_id = $data['stud_id'];
		$sql="SELECT subject_id,exam_master_id FROM `phd_exam_applied_subjects` where stud_id ='$stud_id' and stream_id ='$stream_id' and exam_month ='$exam_month' and exam_year ='$exam_year' and exam_id ='$exam_id'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch exam streams
	function load_ex_appliedstreams($course_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name from phd_exam_applied_subjects ed left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id where vsd.course_id='".$course_id."' and ed.exam_id='".$exam_id."'";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	// fetch result strams
	function load_ex_appliedsemesters($stream_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct semester from phd_exam_applied_subjects  where stream_id='".$stream_id."' and exam_id='".$exam_id."' order by semester asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	//list_exam_appliedStudents
	function list_exam_appliedStudents($exam_id){
		//print_r($_POST);exit;
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.enrollment_no,sm.admission_semester,sm.enrollment_no,sm.first_name,sm.middle_name,sm.mobile,sm.current_year,ed.semester as current_semester,sm.last_name,vsd.school_short_name,vsd.course_short_name,vsd.stream_name,vsd.stream_short_name, ed.exam_fees_paid,ed.exam_fees as fee, ed.allow_for_exam,sm.stud_id");
		$DB1->from('phd_exam_details as ed');
		$DB1->join('vw_stream_details as vsd','ed.stream_id = vsd.stream_id','left');
		$DB1->join('student_master as sm','sm.stud_id = ed.stud_id','left');
		$DB1->where("ed.exam_id",$exam_id);	 
		//$DB1->where("ed.semester",$_POST['semester']);

		if($_POST['semester']!=''){
			//$DB1->where("sm.admission_stream", $year);
			if($_POST['semester']==0){
			    
			}
			else{
				$DB1->where("ed.semester",$_POST['semester']);	    
			}
			
		}	 
		if($_POST['admission-branch']!=''){
			//$DB1->where("sm.admission_stream", $year);
			if($_POST['admission-branch']==0){
			    
			}
			else{
				$DB1->where("ed.stream_id",$_POST['admission-branch']);	    
			}
			
		}
		if($_POST['admission-course']!=''){
			//$DB1->where("sm.admission_stream", $year);
			if($_POST['admission-course']==0){
			    
			}
			else{
				$DB1->where("ed.course_id",$_POST['admission-course']);	    
			}
			
		}
		if($_POST['school_code']!=''){
			//$DB1->where("sm.admission_stream", $year);
			if($_POST['school_code']=='All'){
			    
			}
			else{
				$DB1->where("ed.school_code",$_POST['school_code']);	    
			}
			
		}
	/*	
		if($exam_type !='Makeup'){
			if($_POST['semester']!=''){
				if($_POST['semester']==0){
				    
				}
				else{
					$DB1->where("sm.current_semester",$_POST['semester']);	    
				}
				
			}
		}else{
			if($_POST['semester']!=''){
				if($_POST['semester']==0){
				    
				}
				else{
					$DB1->where("ed.semester",$_POST['semester']);	    
				}
				
			}
			$DB1->group_by("sm.enrollment_no");
		}
    */
		$DB1->group_by("sm.enrollment_no");		
		$DB1->order_by("ed.enrollment_no", "asc");
		$DB1->order_by("ed.stream_id", "asc");
		$DB1->order_by("ed.semester", "asc");
		$query=$DB1->get();
		  //echo $DB1->last_query();die();   
		$result=$query->result_array();
		return $result;
	}
	// fetch exam timetable details	
	function fetch_examTimetable($data, $exam_month, $exam_year)
	{
		$stream = $data['admission-branch'];
		$semester = $data['semester'];
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where et.exam_month='$exam_month' AND et.exam_year='$exam_year' " ;
		
		if($stream !='all'){
			$where .=" AND et.stream_id='$stream' " ;	
		}
		if($semester !='all'){
			$where .=" AND et.semester='$semester' " ;	
		}
		$sql="SELECT et.*, s.subject_name,s.subject_code as sub_code FROM phd_exam_time_table as et left join subject_master as s on s.sub_id= et.subject_id $where order by et.date, s.subject_order, et.semester asc";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	function exam_applied_subjectcount($subject_id,$stream_id,$semester,$exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT `subject_id`, count(subject_id) as exam_applied_cnt FROM `phd_exam_applied_subjects` WHERE subject_id='$subject_id'  and semester='$semester' and exam_id=$exam_id and allow_for_exam='Y'";//and `stream_id`='$stream_id'
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}	
	function stud_applied_subjectcount($subject_id,$stream_id,$semester,$exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT `subject_id`, count(stud_id) as sub_applied_cnt FROM `student_applied_subject` WHERE subject_id='$subject_id'  and semester='$semester' and stream_id='$stream_id' and academic_year='2019-20'";//and `stream_id`='$stream_id'
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}
	// arrear student count
	function stud_arrear_subjectcount($subject_id,$stream_id,$semester,$exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam_id =$exam_id-1;		
		$sql="SELECT `subject_id`, count(student_id) as sub_applied_cnt FROM `phd_exam_student_subject` WHERE subject_id='$subject_id'  and semester='$semester' and passed='N'";//and `stream_id`='$stream_id'and exam_id='$exam_id'
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}	
	//chk_duplicate_exam_form
	function chk_duplicate_exam_form($var)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$stud_id = $var['stud_id'];
		$exam_id = $var['exam_id'];
		$sql="SELECT stud_id FROM `phd_exam_details` WHERE stud_id='$stud_id' and `exam_id`='$exam_id'";
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}
 public function get_studentwise_admission_fees($prn='',$academic_year=''){
     $DB1 = $this->load->database('umsdb', TRUE);
	 $check = substr($prn, 0, 2);
	//exit();
if($check=="18"){
	$year='2018';
}else{
	$year='2019';
}
     $sql ="SELECT 
       sm.stud_id, 
       sm.enrollment_no,  
       sm.first_name, 
       sm.middle_name, 
       sm.last_name, 
       sm.mobile, 
       sm.gender, 
	   sm.admission_cycle,
       v.school_short_name, 
       v.course_short_name    AS course, 
       v.stream_short_name, 
       v.stream_id, 
       ad.year                AS admission_year, 
       SUM(ad.applicable_fee) AS applicable_total, 
       SUM(ad.actual_fee)     AS actual_fees, 
       SUM(CASE 
             WHEN f.amount IS NULL THEN 0 
             ELSE f.amount 
           END)               AS fees_total, 
       SUM(f.charges)         AS cancel_charges, 
       COUNT(ad.student_id)   AS stud_total, 
       ad.cancelled_admission, 
       SUM(CASE 
             WHEN rf.amount IS NULL THEN 0 
             ELSE rf.amount 
           END)               AS refund, 
       ad.academic_year, 
       ad.opening_balance 
FROM   admission_details ad 
       LEFT JOIN vw_stream_details v 
              ON v.stream_id = ad.stream_id 
       LEFT JOIN (SELECT DISTINCT student_id, 
                                  academic_year, 
                                  COUNT(student_id)AS total_count, 
                                  SUM(CASE 
                                        WHEN chq_cancelled = 'N' THEN amount 
                                        ELSE 0 
                                      END)         AS amount, 
                                  SUM(CASE 
                                        WHEN chq_cancelled = 'Y' THEN 
                                        canc_charges 
                                        ELSE 0 
                                      END)         AS charges 
                  FROM   fees_details 
                  WHERE  is_deleted = 'N' 
                         AND type_id = '2' 
                  GROUP  BY student_id, 
                            academic_year) f 
              ON CAST(ad.student_id AS CHAR) = f.student_id 
                 AND ad.academic_year = f.academic_year 
       LEFT JOIN student_master sm 
              ON sm.stud_id = ad.student_id 
       LEFT JOIN (SELECT DISTINCT student_id, 
                                  academic_year, 
                                  SUM(CASE 
                                        WHEN is_deleted = 'N' THEN amount 
                                        ELSE 0 
                                      END) AS amount 
                  FROM   fees_refunds 
                  WHERE  is_deleted = 'N' 
                  GROUP  BY student_id, 
                            academic_year) rf 
              ON ad.student_id = rf.student_id 
                 AND ad.academic_year = rf.academic_year 
WHERE  ad.academic_year = '$academic_year' AND sm.enrollment_no='$prn' AND sm.`admission_cycle` IS NOT NULL
GROUP  BY sm.stud_id, 
          course, 
          v.stream_id, 
          admission_year 
ORDER  BY ad.cancelled_admission, 
          admission_year, 
          sm.enrollment_no ASC";
        $query=$DB1->query($sql);
		//if($this->session->userdata("uid")==2){
 // echo $DB1->last_query();exit;
		//}
		$result=$query->result_array();
		return $result;
   
 }	
 	function check_stud_result_status($prn)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$stud_id = $var['stud_id'];
		$exam_id = $exam_id-1;
		$sql="SELECT DISTINCT enrollment_no FROM exam_result_data WHERE final_grade='WH' and `exam_id` in ('11','12') and enrollment_no='$prn'";
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}
	// fetch_exam_count_in_year
 	function fetch_exam_count_in_year($exam_year)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="select count(*) as cnt from phd_exam_session where exam_year='$exam_year'";
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}	
	function getStudAllocatedSubject_for_supplimentry($stud_id, $semester){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE sas.is_active='Y' ";  
        
		if($stud_id!=""){
			$where.=" AND sas.stud_id='".$stud_id."' AND sas.semester='$semester' AND sm.is_active='Y' and (sm.subject_component='TH' OR sm.subject_component='EM')";
		}	
		
		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester,sm.batch,sm.credits FROM `student_applied_subject` as sas left join subject_master sm on sm.sub_id=sas.subject_id $where";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();//exit;
		return $query->result_array();
	}
	function get_examdate($stream_id,$exam_session, $semester){
		
		$phd_exam_details = explode('-', $exam_session);
			$exam_id= $phd_exam_details[2];
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE  sas.allow_for_exam='Y'";  
        

		//$where.=" AND sas.semester='$semester' AND sm.is_active='Y' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' group by sas.subject_id";
		$where.=" AND sas.semester='$semester' AND sm.is_active='Y' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' group by tm.date";

		
		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester,sm.batch,sm.credits,tm.date FROM `phd_exam_applied_subjects` as sas left join subject_master sm on sm.sub_id=sas.subject_id 
		LEFT JOIN phd_exam_time_table tm ON tm.subject_id=sas.subject_id 
AND tm.`exam_id`=sas.`exam_id` AND tm.`stream_id`=sas.stream_id AND tm.`semester`=sas.semester
		$where";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}	
	
	function get_examsubjects($stream_id,$exam_session, $semester,$date){
		
		$phd_exam_details = explode('-', $exam_session);
			$exam_id= $phd_exam_details[2];
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE  sas.allow_for_exam='Y'";  
        

		$where.=" AND sas.semester='$semester' AND sm.is_active='Y' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and tm.date='".$date."' group by sas.subject_id";
		//$where.=" AND sas.semester='$semester' AND sm.is_active='Y' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' group by tm.date";

		
		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester,sm.batch,sm.credits,tm.date FROM `phd_exam_applied_subjects` as sas left join subject_master sm on sm.sub_id=sas.subject_id 
		LEFT JOIN phd_exam_time_table tm ON tm.subject_id=sas.subject_id 
AND tm.`exam_id`=sas.`exam_id` AND tm.`stream_id`=sas.stream_id AND tm.`semester`=sas.semester
		$where";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}	
	
	
	function getSubjectStudentList_for_attendance($subject_id,$stream_id,$exam_id,$exam_cycle){
		$DB1 = $this->load->database('umsdb', TRUE);  

		$sql="SELECT sas.stud_id,s.is_detained, sas.enrollment_no, sas.subject_id,s.first_name, s.middle_name, s.last_name,et.from_time,et.to_time,et.date as exam_date, sm.subject_code, sm.subject_name, sm.batch, et.exam_month, et.`exam_year`, sas.semester, v.stream_name, sas.exam_id,sas.stream_id, sas.semester, b.ans_bklt_received_status, b.student_id, b.exam_attendance_status, b.ans_bklet_no, b.remark FROM `phd_exam_applied_subjects` as sas 
		left join phd_exam_details ed on ed.exam_id=sas.exam_id and ed.enrollment_no=sas.enrollment_no
		left join subject_master sm on sm.sub_id=sas.subject_id 
		left join student_master s on s.stud_id=sas.stud_id 
		left join phd_exam_time_table et on et.subject_id=sas.subject_id AND et.exam_id=sas.exam_id
		left join vw_stream_details v on v.stream_id=sas.stream_id 
		left join exam_phd_ans_booklet_attendance b on  b.student_id=sas.stud_id and  b.stream_id=sas.stream_id and b.subject_id=sas.subject_id and b.exam_id=sas.exam_id and b.semester=sas.semester
		where sas.subject_id='".$subject_id."' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and sm.is_active='Y'
		 and sas.allow_for_exam='Y'";// AND s.admission_cycle='".$exam_cycle."'
		$sql.=" group by sas.stud_id order by sas.enrollment_no";
		$query = $DB1->query($sql);
	//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function check_duplicate_for_attendance($subject_id,$stream_id,$semester,$exam_id,$exam_date)
	{
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sql="SELECT * from exam_phd_ans_booklet_attendance where subject_id='".$subject_id."' and stream_id='$stream_id' and exam_id='$exam_id' and semester='$semester' and exam_date='$exam_date'";
		$query = $DB1->query($sql);
		//$query->num_rows();
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	
	function fetch_cycle(){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sql="SELECT admission_cycle FROM student_master WHERE admission_cycle IS NOT NULL GROUP BY admission_cycle ORDER BY CAST(admission_cycle AS UNSIGNED) ";
		$query = $DB1->query($sql);
		//$query->num_rows();
		//echo $DB1->last_query();exit;
		return $query->result_array();
		
	}
	
	function fetch_stud_exam_details($stud_id='', $exam_id=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		if($exam_id==''){
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_id =$ex_session[0]['exam_id'];
		}
		$DB1->select("*");
		$DB1->from('phd_exam_details');
		$DB1->where("stud_id", $stud_id);
		$DB1->where("exam_id", $exam_id);
		$DB1->where("is_active", 'Y');
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}	
	function get_stud_applied_sub_for_arrear_update($studentId,$current_semester){
		$DB1 = $this->load->database('umsdb', TRUE);
		$where=" WHERE sas.is_active='Y' and sas.stud_id='$studentId' AND sm.is_active='Y'  and subject_id not in(select subject_id from phd_exam_applied_subjects where stud_id='".$studentId."')";  

		$sql = "SELECT sm.* FROM student_applied_subject sas 
		left join `subject_master` as sm on sm.sub_id = sas.subject_id
		$where ";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
		
	}	
	function check_duplicate_sub_in_arrears($stud_id, $subject_id)
    {       
       // print_r($var);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_exam_student_subject where student_id ='".$stud_id."' AND subject_id ='".$subject_id."'";        
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;   
        return $query->result_array();       
    }
	function get_form_entry_dates($exam_id)
    {       
       // print_r($var);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_marks_entery_date where exam_id ='".$exam_id."' AND status ='Y'";        
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;   
        return $query->result_array();       
    }
	function check_duplicate_allow_student_for_exam($stud,$exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sql="SELECT * from phd_exam_allowed_students where student_id='".$stud."' and exam_id='$exam_id' ";
		$query = $DB1->query($sql);
		//$query->num_rows();
		//echo $DB1->last_query();
		return  $query->num_rows();
	}	
	
	function get_exam_allowed_studntlist($exam_id)
    {       
       // print_r($var);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM phd_exam_allowed_students where exam_id ='".$exam_id."'";        
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;   
        return $query->result_array();       
    }
}?>