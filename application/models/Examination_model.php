<?php
class Examination_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->helper('common_helper.php');
	} 		
	function getStudAllocatedSubject($stud_id, $semester){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE sas.is_active='Y' ";  
        $academic_year=$this->config->item('academic_current_year');
        $academic_year='2025-26';
		if($stud_id!=""){
			$where.=" AND sas.stud_id='".$stud_id."' AND sas.semester='$semester' 
			and sas.academic_year='$academic_year' AND sm.is_active='Y'"; // AND sas.semester not in (1,2)
		}	
		
		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_code1,
		sm.semester,sm.batch,sm.credits 
		FROM `student_applied_subject` as sas 
		left join subject_master sm on sm.sub_id=sas.subject_id $where 
		and sm.sub_id not in(select distinct subject_id from exam_applied_subjects where stud_id=$stud_id)";
		$query = $DB1->query($sql);
	//	echo $DB1->last_query();exit;
		return $query->result_array();
	} 
	
	//
	function getExamAllocatedSubject($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_id =$ex_session[0]['exam_id'];

		$sql="SELECT sas.stud_id, sm.subject_name, sas.subject_id, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester FROM `exam_applied_subjects` as sas left join subject_master sm on sm.sub_id=sas.subject_id where sas.stud_id='".$stud_id."' and sas.exam_id='$exam_id' and sm.is_active='Y'";		
		$query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function getCurrentExamAllocatedSubject($stud_id,$semester,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		/*$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_id =$ex_session[0]['exam_id'];*/

		$sql="SELECT sas.stud_id, sm.subject_name, sas.subject_id, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester, d.semester as current_semester,sm.subject_component as ed_sem FROM `exam_applied_subjects` as sas 
		left join exam_details d on d.stud_id= sas.stud_id and d.exam_id=sas.exam_id and d.stream_id=sas.stream_id
		left join subject_master sm on sm.sub_id=sas.subject_id
		where sas.stud_id='".$stud_id."' and sas.exam_id='$exam_id' and sm.is_active='Y'";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function get_student_id_by_prn($enrollment_no){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("CASE WHEN stm.course_pattern ='SEMESTER' THEN 
   (2 * stm.course_duration) 
  ELSE
  (1 * stm.course_duration) 
  END as final_semester,ad.state_id,stm.course_id,stm.course_type,stm.course_duration,sm.stud_id,sm.enrollment_no,sm.enrollment_no_new,sm.current_semester,
  sm.current_year,sm.admission_stream,sm.admission_session,sm.academic_year,stm.course_id,sm.nationality,stm.school_code,sm.belongs_to,
  sm.package_name,ad.country_id");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('address_details as ad','sm.stud_id = ad.student_id and ad.adds_of="STUDENT" and ad.address_type="PERMNT"','left');
		$DB1->where("enrollment_no", $enrollment_no);
		$query=$DB1->get();
		$result=$query->row_array();
		//echo $DB1->last_query();exit;
		return $result;
        

	}
	// fetch personal details
	function fetch_personal_details($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,stm.course_type,stm.gradesheet_name,stm.specialization, stm.course_name,stm.stream_code,stm.course_short_name, stm.course_id, stm.stream_id,stm.school_name,stm.school_code, stm.school_short_name, stm.course_duration, stm.course_pattern");
		$DB1->from('student_master as sm');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->where('sm.stud_id', $stud_id);
		$DB1->order_by("sm.stud_id", "desc");
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
	function fetch_exam_center_details($admission_school,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("em.center_code,em.center_name");
		$DB1->from('exam_center_allocation as sm');
		$DB1->join('exam_center_master as em','em.ec_id = sm.center_id','left');
		$DB1->where('sm.school_id', $admission_school);
		$DB1->where('sm.exam_id', $exam_id);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
	function fetch_stud_curr_exam(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("e.exam_month,e.exam_year,e.exam_id,e.exam_type,m.frm_end_date,m.frm_open_date,m.frm_latefee_date");
		$DB1->from('exam_session e');
		$DB1->join('marks_entery_date as m','m.exam_id = e.exam_id','left');
		$DB1->where("e.is_active", 'Y');
		$DB1->order_by("e.exam_id", 'desc');
		//$DB1->limit(1);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	function fetch_stud_suppli_prev_exam($stud_id,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$categories = array('37');
		$DB1->select("e.stud_id");
		$DB1->from('exam_details e');
		$DB1->where_in("e.exam_id", $categories);
		$DB1->where("e.enrollment_no", $stud_id);
		//$DB1->order_by("e.exam_id", 'desc');
		//$DB1->limit(1);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
	function fetch_stud_curr_exam_ecr(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("e.exam_month,e.exam_year,e.exam_id,e.exam_type,m.frm_end_date,m.frm_open_date,m.frm_latefee_date");
		$DB1->from('exam_session e');
		$DB1->join('marks_entery_date as m','m.exam_id = e.exam_id','left');
		$DB1->where("e.active_for_exam", 'Y');
		$DB1->order_by("e.exam_id", 'desc');
		//$DB1->limit(1);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}	
	function fetch_stud_curr_year(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("*");
		$DB1->from('academic_year');
		$DB1->where("currently_active", 'Y');
		$DB1->order_by("id", 'desc');
		//$DB1->limit(1);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	function fetch_exam_session_byid($exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('exam_session');
		$DB1->where("exam_id", $exam_id);
		//$DB1->where("is_active", 'Y');	
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
	function fetch_stud_exam_details($stud_id='', $exam_id=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		if($exam_id==''){
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_id =$ex_session[0]['exam_id'];
		}
		$DB1->select("*");
		$DB1->from('exam_details');
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
			$DB1->from('exam_details');
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
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_month =$ex_session[0]['exam_month'];
		$exam_year =$ex_session[0]['exam_year'];
		$prn = $data['prn'];
		$academic_year = $data['academic_year'];
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,stm.school_name,stm.school_code,stm.school_short_name");
		$DB1->from('student_master as sm');
		//$DB1->join('exam_details as ed','sm.stud_id = ed.stud_id','left');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $DB1->where("stm.school_code",$schid);	 
			 
		 }else if(isset($role_id) && $role_id==44){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $DB1->where("stm.school_code",$schid);	 
			 
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$DB1->where("stm.school_code",$sccode);	 
		}else if(isset($role_id) && $role_id==41){
				$DB1->where("stm.course_id",15);					
		}
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
		$DB1->from('exam_details');
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
	function fetch_onlinefees($data){
		//print_r($data);exit;
		$categories=array(5,7);
		$DB1 = $this->load->database('umsdb', TRUE);
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		if(!empty($data['examid'])){
			$exam_id =$data['examid'];
		}else{
			$exam_id =$ex_session[0]['exam_id'];
		}
		$DB1->select("sum(amount) as amount");
		$DB1->from('online_payment');
		$DB1->where('registration_no', $data['prn']);
		$DB1->where('payment_status', 'success');
		$DB1->where('examsession', $exam_id);
		$query1 =$DB1->get();
		//echo $DB1->last_query();exit;
		$result1=$query1->result_array();
		//echo $result1[0]['amount'];
		if(empty($result1[0]['amount'])){
		$DB1->select("sum(f.amount) as amount");
		$DB1->from('fees_details as f');
		$DB1->join('student_master as sm','sm.stud_id = f.student_id','left');
		$DB1->where('sm.enrollment_no', $data['prn']);
		$DB1->where_in('f.type_id', $categories);
		$DB1->where('f.exam_session', $exam_id);
		//$query2 =$DB1->get_compiled_select();
		//$sqlquery=$DB1->query($query1 . ' UNION ' . $query2);
		$query2 =$DB1->get();
		$result2=$query2->result_array();
	  //echo $DB1->last_query();exit;
		//$result=$sqlquery->result_array();
		//echo $DB1->last_query();exit;
		return $result2;
		}else{
			return $result1;
		}
	}	
	// fetch semester subject
	function getSemesterSubject($sem, $stream){
		
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE is_active='Y' ";  
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279);
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
		$sql="DELETE FROM `exam_applied_subjects` where stud_id ='$stud_id' and stream_id ='$stream_id' and exam_month ='$exam_month' and exam_year ='$exam_year' and exam_id ='$exam_id'";
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
		$DB1->join('exam_details as ed','sm.stud_id = ed.stud_id','left');
		
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
	
	function getFeedetails($student_id,$exam_id){
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_month =$ex_session[0]['exam_month'];
		$exam_year =$ex_session[0]['exam_year'];
		$DB1 = $this->load->database('umsdb', TRUE);
		if($exam_type=='Makeup'){
			$type_array = array(5,7);
			$DB1->select("f.amount");
			$DB1->from('fees_details as f');
			$DB1->where_in('f.type_id', $type_array);
			$DB1->where("f.student_id",$student_id);
			$DB1->where("f.exam_session",$exam_id);			
		}else{
			$DB1->select("exam_fees");
			$DB1->from('exam_details as f');
			$DB1->where('exam_id', $exam_id);
			$DB1->where("stud_id",$student_id);	
		}
		$query=$DB1->get();

		$result=$query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
		
	function getExamformStatus($student_id,$exam_month, $exam_year){
		$DB1 = $this->load->database('umsdb', TRUE);
		$query = $DB1->query('SELECT * FROM exam_details where exam_month ="'.$exam_month.'" and exam_year="'.$exam_year.'" and stud_id="'.$student_id.'"');
		//echo $query->num_rows();
		//echo $DB1->last_query();exit;
		return $query->num_rows();
	}
	
	function UpdateHoldStatus($student_id,$exam_month, $exam_year){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where = "exam_month='$exam_month' AND exam_year='$exam_year' AND stud_id='$student_id'";
		$DB1->set('allow_for_exam', 'N');
		$DB1->where($where);
		$DB1->update('exam_details'); 
		
		$DB1->set('allow_for_exam', 'N');
		$DB1->where($where);
		$DB1->update('exam_applied_subjects');
		//echo $DB1->last_query();exit;
		return true;
	} 
	function UpdateApproveStatus($student_id,$exam_month, $exam_year){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where = "exam_month='$exam_month' AND exam_year='$exam_year' AND stud_id='$student_id'";
		$DB1->set('allow_for_exam', 'Y');
		$DB1->where($where);
		
		$DB1->update('exam_details'); 
		$DB1->set('allow_for_exam', 'Y');
		$DB1->where($where);
		$DB1->update('exam_applied_subjects');
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
		$sql="SELECT DISTINCT ed.school_code, vw.school_short_name FROM exam_details ed left join vw_stream_details vw on vw.school_code = ed.school_code where ed.exam_id = '$exam_id'";	
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
	
	function get_courses($school_code='',$examsess=''){
		$DB1 = $this->load->database('umsdb', TRUE);
if(empty($examsess)){		
		$exam_session= fetch_exam_session_for_marks_entry();
		$exam_id=$exam_session[0]['exam_id'];
}else{
	$exam = explode('-',$examsess);
	$exam_id=$exam[2];
}
		//print_r($examsess);exit;
		
		$sql="SELECT DISTINCT(vw.course_id),course_name,course_short_name FROM vw_stream_details vw join exam_details ed on ed.stream_id=vw.stream_id 
		where vw.school_code='".$school_code."'";
		if($exam_id!=''){
			 $sql .=" and ed.exam_id=$exam_id";
		}
	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function get_courses_tts($school_code='',$examsess=''){
		$DB1 = $this->load->database('umsdb', TRUE);
if(empty($examsess)){		
		$exam_session= fetch_exam_session_for_marks_entry();
		$exam_id=$exam_session[0]['exam_id'];
}else{
	$exam = explode('-',$examsess);
	$exam_id=$exam[2];
}
		//print_r($examsess);exit;
		
		$sql="SELECT DISTINCT(vw.course_id),course_name,course_short_name FROM vw_stream_details vw join exam_details ed on ed.stream_id=vw.stream_id 
		where vw.school_code='".$school_code."'";
		if($exam_id!=''){
			 //$sql .=" and ed.exam_id=$exam_id";
		}
	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function get_courses_results($school_code=''){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_session= fetch_exam_session_for_result();
		//print_r($exam_session);
		$exam_id=$exam_session[0]['exam_id'];
		$sql="SELECT DISTINCT(vw.course_id),course_name,course_short_name FROM vw_stream_details vw join exam_details ed on ed.stream_id=vw.stream_id 
		where vw.school_code='".$school_code."' and ed.exam_id=$exam_id";
	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	function get_streams_for_result($course_id,$school_code=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$exam_session= fetch_exam_session_for_result();
		// print_r($exam_session);
		$exam_id=$exam_session[0]['exam_id'];
		$sql = "select vw.stream_id,stream_name,stream_short_name from vw_stream_details vw join exam_details ed on ed.stream_id=vw.stream_id where vw.course_id='".$course_id."' ";
		if($school_code !=''){
			$sql .= "and vw.school_code='".$school_code."'";
		}
		$sql .=" and ed.exam_id=$exam_id group by vw.stream_id";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	function get_streams($course_id,$school_code=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$exam_session= fetch_exam_session_for_marks_entry();
		//print_r($exam_session);
		$exam_id=$exam_session[0]['exam_id'];
		$sql = "select vw.stream_id,stream_name,stream_short_name from vw_stream_details vw join exam_details ed on ed.stream_id=vw.stream_id where 1";
		if($school_code !=''){
			$sql .= " and vw.school_code='".$school_code."'";
		}
		if($course_id !=0){
			$sql .= " and vw.course_id='".$course_id."'";
		}
		$sql .=" and ed.exam_id=$exam_id group by vw.stream_id";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	function get_courses_timetable($school_code){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_session= $this->fetch_stud_curr_exam();
		//print_r($exam_session);
		$exam_id=$exam_session[0]['exam_id'];
		$sql="SELECT DISTINCT(vw.course_id),course_name,course_short_name FROM vw_stream_details vw join exam_details ed on ed.stream_id=vw.stream_id 
		where vw.school_code='".$school_code."' and ed.exam_id=$exam_id";
	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function get_streams_timetable($course_id,$school_code=''){
		$DB1 = $this->load->database('umsdb', TRUE);
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		$exam_session= $this->fetch_stud_curr_exam();
		//print_r($exam_session);
		$exam_id=$exam_session[0]['exam_id'];
		$sql = "select vw.stream_id,stream_name,stream_short_name from vw_stream_details vw join exam_details ed on ed.stream_id=vw.stream_id where vw.course_id='".$course_id."' ";
		if($school_code !=''){
			$sql .= "and vw.school_code='".$school_code."'";
		}
		$sql .=" and ed.exam_id=$exam_id group by vw.stream_id";
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
		$DB1->join('exam_details as ed','sm.stud_id = ed.stud_id','left');
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


		$sql="SELECT sas.stud_id, sm.subject_name, sas.subject_id, sm.sub_id, sm.subject_code,sm.subject_code1,sm.semester,sm.subject_component,sm.subject_type,
			  et.date,et.from_time,et.to_time,case when sm.subject_component='EM' then 'TH' else sm.subject_component end as subtype 
			FROM exam_applied_subjects as sas 
			LEFT JOIN subject_master sm on sm.sub_id = sas.subject_id 
			LEFT JOIN exam_time_table as et on et.subject_id =sas.subject_id and et.exam_id=sas.exam_id
			WHERE sas.stud_id='".$stud_id."' AND sas.exam_id='$exam_id' and et.display_on_hallticket='Y' AND sm.is_active='Y'  ";		//and  et.date not like '%2000%'
		
		$sql.=" group by sas.subject_id order by et.semester,subtype desc, et.date";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	
	function exam_report_students_old($streamid='',$year='', $exam_id,$exam_type){

		$DB1 = $this->load->database('umsdb', TRUE);
		
		$DB1->select("ed.*, sm.enrollment_no, sm.first_name, sm.middle_name, sm.last_name,sm.current_semester");
		$DB1->from('exam_details as ed');
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
		
		//$array_stud=array();
		$DB1->where("ed.allow_for_exam",'Y');
		$DB1->where("ed.exam_id", $exam_id);
		$DB1->where("sm.cancelled_admission",'N');
		//$DB1->where_in("ed.exam_master_id",$array_stud);
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
		$sql="SELECT DISTINCT(ed.school_code),vsd.school_short_name FROM exam_details ed left join vw_stream_details as vsd on ed.school_code = vsd.school_code";
	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	// fetch exam cources
	function get_examcourses($school_code, $exam_session){
		$exam = explode('-',$exam_session);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_id =$exam[2];
		$sql="select v.course_id, v.course_name, v.course_short_name from (select DISTINCT stream_id from exam_details where exam_id='$exam_id') as e left join vw_stream_details as v on v.stream_id= e.stream_id where v.school_code='$school_code' group by v.course_id";
	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();		die();  
		return $query->result_array();
	}
	
	function get_examcourses_new($school_code, $exam_session){

		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="select v.course_id, v.course_name, v.course_short_name from (SELECT DISTINCT admission_stream  AS stream_id FROM student_master 
		WHERE academic_year='$exam_session') as e left join vw_stream_details as v on v.stream_id= e.stream_id where v.school_code='$school_code' group by v.course_id";
	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();		die();  
		return $query->result_array();
	}
	
	function load_examsess_schools($exam_session){
		$exam = explode('-',$exam_session);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_id =$exam[2];
		$sql="select v.stream_id, v.school_code, v.school_short_name from (select DISTINCT stream_id from exam_details where exam_id='$exam_id') as e left join vw_stream_details as v on v.stream_id= e.stream_id group by v.school_code";	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	
	function load_examsess_schools_new($exam_session){
		
		 $DB1 = $this->load->database('umsdb', TRUE); 
		 $role_id = $this->session->userdata('role_id');
		 $emp_id = $this->session->userdata("name");
		 $condition1="where v.school_code is not null ";
		  if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $condition1 .=" AND v.school_code = $schid  ";
			  //$DB1->where('v.school_code!=',$schid);
			
		 }else if(isset($role_id) && $role_id==10 || $role_id==49){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$condition1 .=" AND v.school_code = $sccode" ;
				
		}
		$sql="SELECT v.stream_id, v.school_code, v.school_short_name
		 FROM (SELECT DISTINCT admission_stream  AS stream_id FROM student_master 
		WHERE academic_year='$exam_session') 
		AS e LEFT JOIN vw_stream_details AS v ON v.stream_id= e.stream_id ".$condition1." GROUP BY v.school_code";	
		$query = $DB1->query($sql);
		
		return $query->result_array();
	}
	function load_exam_dates($exam_session){
		$exam = explode('-',$exam_session);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_id =$exam[2];
		$sql="select v.stream_id, v.school_code, v.school_short_name from (select DISTINCT stream_id from exam_details where exam_id='$exam_id') as e left join vw_stream_details as v on v.stream_id= e.stream_id group by v.school_code";	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	// fetch exam streams
	function get_examstreams($course_id, $exam_session){
		$exam = explode('-',$exam_session);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_id =$exam[2];
		$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name from exam_details ed left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id where vsd.course_id='".$course_id."' and ed.exam_id='$exam_id'";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// fetch exam strams
	function get_examsemester_for_result($stream_id,$exam_session){
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam =explode('-', $exam_session);
		$exam_id = $exam[2];
		$sql = "select distinct semester from exam_applied_subjects where stream_id='".$stream_id."' and exam_id ='$exam_id' and allow_for_exam='Y' order by semester asc";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	function get_examsemester($stream_id,$exam_session){
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam =explode('-', $exam_session);
		$exam_id = $exam[2];
		$sql = "select distinct semester from exam_applied_subjects where stream_id='".$stream_id."' and exam_id ='$exam_id' and allow_for_exam='Y' order by semester asc";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// fetch exam subjects
	function fetchExamSubjects($streamid='',$year=''){
	    $stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279);
	    $streamid = $_POST['admission-branch'];
        /*if(in_array($streamid,  $stream_arr)){
			$stream_id='9';	
		}else{
		    $stream_id= $streamid;	
		}*/
		$exam_session = explode('-',$_POST['exam_session']);
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select et.subject_id, eas.subject_code,eas.subject_component, eas.subject_name, vsd.stream_name, vsd.school_short_name, et.date,et.from_time,et.to_time,et.semester from exam_applied_subjects es 
left join exam_time_table as et on et.subject_id = es.subject_id and et.exam_id=es.exam_id 
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

		$sql="SELECT sas.barcode,sas.stud_id,s.is_detained, sas.enrollment_no, sas.subject_id,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as stud_name,s.admission_stream,eb.exam_attendance_status as is_absent,sas.malpractice,eb.ans_bklet_no FROM `exam_applied_subjects` as sas 
		left join exam_details ed on ed.exam_id=sas.exam_id and ed.enrollment_no=sas.enrollment_no
		left join subject_master sm on sm.sub_id=sas.subject_id 
		left join student_master s on s.stud_id=sas.stud_id 
		left join exam_ans_booklet_attendance eb on eb.student_id=sas.stud_id and eb.exam_id=sas.exam_id and eb.subject_id=sas.subject_id
		where sas.subject_id='".$subject_id."' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and sm.is_active='Y' and sas.allow_for_exam='Y'  ";
		$sql.=" group by sas.stud_id order by sas.enrollment_no";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
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
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279);
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
	function fetch_result_publication_dates($school_code,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT school_code, school_short_name,school_name,start_date FROM school_master v join result_date_updation rpd on rpd.school=v.school_id where rpd.examId='".$exam_id."'  and v.school_code='".$school_code."'";	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	function searchCheckStudentbyprn($data){
		//print_r($data['prn']);exit;
		$role_id = $this->session->userdata('role_id');
		$emp_id = $this->session->userdata("name");
		
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_month =$ex_session[0]['exam_month'];
		$exam_year =$ex_session[0]['exam_year'];
		$prn = $data['prn'];
		$academic_year = $data['academic_year'];
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("sm.*,stm.stream_name,stm.school_name,stm.school_code, ed.exam_month,ed.exam_fees, ed.exam_year,ed.allow_for_exam,ed.semester as exam_semester, stm.school_short_name");
		$DB1->from('student_master as sm');
		$DB1->join('exam_details as ed','sm.stud_id = ed.stud_id','left');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		if($prn!=''){
			$where = " sm.enrollment_no='$prn' AND sm.cancelled_admission='N' AND sm.academic_year='$academic_year'";
			$DB1->where($where);	    
		}
		if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $DB1->where("stm.school_code",$schid);
			 //$sql .=" AND vsd.school_code = $schid";
		 }else if(isset($role_id) && $role_id==44){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 $DB1->where("stm.school_code",$schid);
			 //$sql .=" AND vsd.school_code = $schid";
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$DB1->where("stm.school_code",$sccode);
				//$sql .=" AND vsd.school_code = $sccode";
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
		$DB1->join('exam_details as ed','sm.stud_id = ed.stud_id','left');
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
		$prev_exam_id_one=$ex_session[0]['exam_id']-1;
		$where=" WHERE 1=1 ";  
        $academic_year=$this->config->item('cyear');

		if($exam_type=='Regular'){
			$sql="SELECT sas.stud_id, sm.subject_name, sas.subject_id, sm.sub_id, sm.subject_code,sm.semester,sm.subject_component FROM `exam_applied_subjects` as sas left join subject_master sm on sm.sub_id=sas.subject_id where sas.stud_id='".$stud_id."' and sm.is_active='Y'";	
		}else{
			$sql="SELECT er.student_id as stud_id, sm.subject_name, er.subject_id, sm.sub_id, sm.subject_code,sm.credits,sm.subject_code1,sm.semester,sm.subject_component,er.failed_sub_type  FROM `exam_result_data` as er 
		left join exam_details d on d.stud_id=er.student_id and d.exam_id=er.exam_id and d.stream_id=er.stream_id and d.semester=er.semester  
		left join subject_master sm on sm.sub_id=er.subject_id 
		left join student_master s on s.stud_id=er.student_id  
		where er.student_id='".$stud_id."' and s.academic_year in('$academic_year','2023') and d.semester=er.semester and er.final_grade in('U','F') and er.with_held !='Y' and er.exam_id in ('$prev_exam_id') ";//and er.malpractice='N' er.exam_id='$prev_exam_id' and (sm.subject_component='TH'  OR sm.subject_component='EM')
			if($stud_stream=='71'){
				$sql .=" and er.semester in(1,2)";
			}else{
				$sql .=" and er.semester in('2','4','6','8','10')";
			}
		}	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch exam dates	
	function fetch_examdates($exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where exam_id='$exam_id' and date not in('2000-01-01','0000-00-00','1970-01-01')" ;
		$sql="SELECT distinct `date` as exam_date FROM `exam_time_table` $where order by date asc";
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
FROM `exam_applied_subjects` eas 
left join exam_time_table as t on eas.subject_id = t.subject_id and t.exam_id=eas.exam_id
left join subject_master as s on s.sub_id = t.subject_id 
left join vw_stream_details vw on vw.stream_id = t.stream_id   
		$where group by eas.subject_id order by t.date,t.from_time,t.to_time, t.stream_id, t.semester asc";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;		
	}
	function exam_daywiseqpindend_report_old($exam_date,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to,$school_code,$var){
		
		//print_r($var);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' and e.allow_for_exam='Y' and t.exam_id='$exam_id'" ;
		if($exam_date !='' && $exam_date !='0'){
			$where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to' ";//and t.stream_id NOT IN (160,161)
		}
		if(!empty($school_code)  && $var['school_code'] !='All'){			
			$sch_code = implode(",", $school_code);
			$where .= " and vw.school_code in($school_code)";
		}
		if(!empty($var['admission-branch']) && isset($var['admission-branch'])){
			$strm_id=$var['admission-branch'];
			$strm_id_1 = implode(",", $strm_id);
			$where .= " and vw.stream_id in($strm_id)";
		}
		$sql="SELECT t.`exam_id`, t.`subject_id`, count(*)AS TOT, vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code,s.subject_name,s.regulation, t.`stream_id`, t.`semester`,e.semester as curr_sem, t.`from_time`,t.`to_time`,t.`date`,t.batch  
FROM exam_time_table as t
left join `exam_applied_subjects` eas on eas.subject_id = t.subject_id and t.exam_id=eas.exam_id
left join exam_details as e on e.stud_id = eas.stud_id and e.exam_id=eas.exam_id
left join subject_master as s on s.sub_id = t.subject_id 
left join vw_stream_details vw on vw.stream_id = t.stream_id   
		$where group by t.subject_id,t.stream_id,s.batch order by s.batch desc,t.date,t.from_time,t.to_time, t.semester, t.stream_id asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query(); echo"<br>";exit;
		$result = $query->result_array();
	
		return $result;		
	}
		function exam_daywiseqpindend_report($exam_date,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to,$school_code,$var){
		
		//print_r($var);
		$DB1 = $this->load->database('umsdb', TRUE); 
		$centers = $this->session->userdata('center_ids');

        if (!empty($centers)) {
            $DB1->select('school_id');
            $DB1->from('exam_center_allocation');
            $DB1->where_in('center_id', $centers);
            if(!empty($exam_id)){
            $DB1->where('exam_id', $exam_id);
            }   
            $school_ids = $DB1->get()->result_array();
            $school_ids = array_column($school_ids, 'school_id');
        }


		
		$where ="where  e.allow_for_exam='Y' and t.exam_id='$exam_id'" ;
		if($exam_date !='' && $exam_date !='0'){
			$where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to' ";//and t.stream_id NOT IN (160,161)
		}
		if(!empty($school_code)  && $var['school_code'] !='All'){			
			$sch_code = implode(",", $school_code);
			$where .= " and vw.school_code in($school_code)";
		}
		if(!empty($var['admission-branch']) && isset($var['admission-branch'])){
			$strm_id=$var['admission-branch'];
			$strm_id_1 = implode(",", $strm_id);
			$where .= " and vw.stream_id in($strm_id)";
		}
		if($var['school_code'] =='All'){			
			$sch_code = implode(",", $school_code);
			if (!empty($centers)) {
                $where .= " and vw.school_id in(" . implode(',', $school_ids) . ")";
            } else {
                $where .= "";
            }
		}
		
		$sql="SELECT ec.center_name,ec.center_code,t.`exam_id`, t.`subject_id`, count(*)AS TOT, vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code,s.subject_name,s.regulation, eas.`stream_id`, eas.`semester`,e.semester as curr_sem, t.`from_time`,t.`to_time`,t.`date`,t.batch  
FROM `exam_applied_subjects` eas 
left join exam_time_table as t on eas.subject_id = t.subject_id and t.exam_id=eas.exam_id 
left join exam_details as e on e.stud_id = eas.stud_id and e.exam_id=eas.exam_id
left join subject_master as s on s.sub_id = t.subject_id 
left join vw_stream_details vw on vw.stream_id = eas.stream_id   
left join exam_center_allocation em on em.school_id = vw.school_id  and em.exam_id='$exam_id' 
left join exam_center_master ec on ec.ec_id = em.center_id   
		$where group by  eas.subject_id,eas.stream_id,s.batch order by s.batch desc,t.date,t.from_time,t.to_time, eas.semester, eas.stream_id asc";
		$query = $DB1->query($sql);
		//echo $DB1->last_query(); echo"<br>";exit;
		$result = $query->result_array();
	
		return $result;		
	}
	//
	function exam_daywise_slot($exam_date,$exam_month,$exam_year,$exam_id,$con){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where='';
		$and='';
		if($con=="Morning"){
		$where .= " LEFT JOIN examtime_slot as ets ON ets.id=t.exam_slot_id ";
		$and .=" AND ets.session='FN'";
		}elseif($con=="Afternoon"){
		$where .= " LEFT JOIN examtime_slot as ets ON ets.id=t.exam_slot_id ";
		$and .=" AND ets.session='AN'";
		}else{
		$where .= "LEFT JOIN examtime_slot as ets ON ets.id=t.exam_slot_id ";	
		}
		
		$where .="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' and t.exam_id='$exam_id'" ;
		if($exam_date !='' && $exam_date !='0'){
		$where .= " and t.date='$exam_date'";
		}
		
		$sql="SELECT t.`from_time`, t.`to_time`, t.`date` FROM `exam_applied_subjects` eas 
		left join exam_time_table as t on eas.subject_id = t.subject_id  
		$where $and group by t.from_time,t.to_time order by t.from_time desc";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query(); exit();
		return $result;	
	}
	//
	function get_excel_data($arr, $exam_month, $exam_year, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$stream = $arr['admission-branch'];
		$semester =$arr['semester'];
		$where ="where e.stream_id='$stream' AND e.semester='$semester' AND e.exam_id='$exam_id'" ;
		$sql="SELECT CONCAT(' ',e.enrollment_no),UPPER(CONCAT(sm.first_name,'   ',sm.middle_name,'  ',sm.last_name)) as stud_name,e.semester,t.date,t.from_time,t.to_time,s.subject_code,s.subject_name,v.stream_short_name,v.school_short_name,v.course_short_name FROM exam_applied_subjects e 
		LEFT JOIN exam_time_table t ON e.exam_id=t.exam_id AND e.subject_id=t.subject_id
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
		$sql="SELECT distinct eas.`stream_id`,vw.stream_short_name, vw.stream_code FROM `exam_applied_subjects` eas 
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
		$sql="SELECT distinct eas.`subject_id`, eas.stream_id, s.subject_code1, s.subject_code, s.subject_short_name FROM `exam_applied_subjects` eas 
		LEFT JOIN subject_master s on s.sub_id = eas.subject_id 
		left join exam_time_table as t on eas.subject_id = t.subject_id 
		$where order by subject_short_name asc";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;		
	}	
	function get_exam_streams($ex_date,$exam_month,$exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where t.date='$ex_date' and eas.exam_month='$exam_month' AND eas.exam_year='$exam_year' and eas.exam_id='$exam_id' " ;
		$sql="SELECT vw.stream_short_name, vw.stream_code, eas.`stream_id`,t.`date` FROM `exam_applied_subjects` eas 
		left join exam_time_table as t on eas.subject_id= t.subject_id
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
		t.`semester`,t.`from_time`,t.`to_time`,t.`date` FROM `exam_applied_subjects` eas 
		left join exam_time_table as t on eas.subject_id = t.subject_id 
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
		$DB1->update('exam_applied_subjects', $data); 
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
		$DB1->update('exam_applied_subjects', $data); 
		//echo $DB1->last_query();exit;
		return true;
	}
	function searchStudent_for_malpractice($prn,$exam_date,$exam_month, $exam_year,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where ="where eas.enrollment_no='$prn' AND t.date='$exam_date' AND eas.exam_id='$exam_id'  group by eas.subject_id"  ;

		$sql="SELECT m.malcount, eas.malpractice as is_malpractice, eas.remark, eas.exam_subject_id,t.`exam_id`, t.`subject_id`,eas.stud_id,sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,
		vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code1,s.subject_code,s.subject_name, t.`stream_id`,
		t.`semester`,t.`from_time`,t.`to_time`,t.`date` FROM `exam_applied_subjects` eas 
		left join exam_time_table as t on eas.subject_id = t.subject_id and eas.exam_id =t.exam_id

		left join (select count(exam_subject_id) as malcount,enrollment_no from exam_applied_subjects  where enrollment_no='$prn' and malpractice='Y' ) as m on m.enrollment_no=eas.enrollment_no
		left join subject_master as s on s.sub_id = t.subject_id 
		left join student_master sm on sm.stud_id = eas.stud_id 
		left join vw_stream_details vw on vw.stream_id = sm.admission_stream  
		
		$where";
		
		
		$query = $DB1->query($sql);
		$result = $query->result_array();
		
		return $result;	
	}


	function pdfforStudent_for_malpractice($exam_month,$exam_year, $exam_id,$schoolid,$studentid_lis){
		$DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where eas.exam_id='$exam_id' and eas.`malpractice`='Y' and ed.school_code=".$schoolid." and eas.stud_id='$studentid_lis'  group by eas.stud_id, eas.subject_id order by t.date desc" ;
	    
	    $sql="SELECT m.malcount,eas.malpractice,eas.remark, eas.exam_subject_id,t.`exam_id`,eas.exam_month,eas.exam_year, t.`subject_id`,eas.stud_id,sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,es.exam_type,ed.mal_practice_token,ed.build_block_date,
		vw.stream_name,vw.school_name,vw.course_short_name, sm.current_year,sm.current_semester,eas.semester, vw.stream_code,vw.school_code,vw.school_short_name, s.subject_short_name,s.subject_code1,s.subject_code,s.subject_name, t.`stream_id`,
		t.`semester`,t.`from_time`,t.`to_time`,t.`date` FROM `exam_applied_subjects` eas 
		
		left join exam_time_table as t on eas.subject_id = t.subject_id and eas.exam_id = t.exam_id 
		left join exam_details as ed on ed.stud_id = eas.stud_id and ed.exam_id = eas.exam_id 
		left join subject_master as s on s.sub_id = t.subject_id 
		left join exam_session as es on es.exam_id = eas.exam_id
		left join student_master sm on sm.stud_id = eas.stud_id 
		left join vw_stream_details vw on vw.stream_id = sm.admission_stream  
		left join (select count(exam_subject_id) as malcount,enrollment_no from exam_applied_subjects  where  malpractice='Y' GROUP BY enrollment_no  ) as m on m.enrollment_no=eas.enrollment_no
		
		$where ";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}

	function get_malpractice_no($exam_month,$exam_year, $exam_id,$schoolid,$studentdata_id,$blockaddress)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$where = "exam_month='$exam_month' AND exam_year='$exam_year' and exam_id='$exam_id' and school_code='$schoolid' and mal_practice_token is not null";
		$DB1->select('max(mal_practice_token) as maxval');
		$DB1->from('exam_details');
		$DB1->where($where);
		$queryd=$DB1->get();
		/*echo $DB1->last_query();
		die;*/
		$datas=$queryd->result_array();
		

		if((!empty($datas)) && ($datas[0]['maxval']!=''))
		{
			
			
			$i=1;
			
			foreach($studentdata_id as $studentid)
			{
				$where1 = "exam_month='$exam_month' AND exam_year='$exam_year' and exam_id='$exam_id' and school_code='$schoolid' and stud_id='$studentid'";
				$malcode=$datas[0]['maxval']+$i;

				$data = array(
               'mal_practice_token' =>$malcode,
               'build_block_date' =>$blockaddress,
               'modify_by' => $this->session->userdata("uid"),
               'modify_on' => date("Y-m-d H:i:s")
            	);
				//$DB1->set('malpractice', $is_malpractice);
				//$DB1->set('remark', $remark);
				$DB1->where($where1);
				$DB1->update('exam_details', $data); 
					
					$i++;
				 

			}
			
		}

		else
		{
		

			$i=1;
			
			foreach($studentdata_id as $studentid)
			{
			
				
				$where1 = "exam_month='$exam_month' AND exam_year='$exam_year' and exam_id='$exam_id' and school_code='$schoolid' and stud_id='$studentid'";
				
				$malcode=$schoolid.'0'.$i;

				$data = array(
               'mal_practice_token' =>$malcode,
               'build_block_date' =>$blockaddress,
               'modify_by' => $this->session->userdata("uid"),
               'modify_on' => date("Y-m-d H:i:s")
            	);
				//$DB1->set('malpractice', $is_malpractice);
				//$DB1->set('remark', $remark);
				$DB1->where($where1);
				$DB1->update('exam_details', $data); 
					
					$i++;
				 

			}

		}
		
		

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
		$DB1->update('exam_applied_subjects', $data); 
		return true;
	}	
	// fetch exam_daywise_dispatch_report
	function exam_daywise_dispatch_report_12_05_2025($exam_date='',$exam_month='',$exam_year='',$exam_id='', $slot_from='',$slot_to='',$school_code='',$var=array()){
	    $DB1 = $this->load->database('umsdb', TRUE);
		$centers = $this->session->userdata('center_ids');

        if (!empty($centers)) {
            $DB1->select('school_id');
            $DB1->from('exam_center_allocation');
            $DB1->where_in('center_id', $centers);
            if(!empty($exam_id)){
            $DB1->where('exam_id', $exam_id);
            }   
            $school_ids = $DB1->get()->result_array();
            $school_ids = array_column($school_ids, 'school_id');
        }


		
	    $where ="where eas.exam_id='$exam_id' and eas.allow_for_exam='Y'" ;
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to' and eas.stream_id NOT IN (160,161)";
	    }
		
		if(!empty($school_code) && $school_code !='All'){			
			//$sch_code = implode(",", $school_code);
			
			/*if(in_array('1001',$school_code) && in_array('1006',$school_code)){
				//$where .= " and vw.course_id in(2,3,9,10)";
				$where .= " and vw.stream_id in(11,109,162,97,96,7) AND eas.semester IN(1)";
			}else if(in_array('1001',$school_code)){
				$where .= " and vw.course_id in(2,3)";
			}else if(in_array('1006',$school_code)){
				$where .= " and vw.course_id in(9,10)";
			}else{*/
				$where .= " and vw.school_code in($school_code)";
			//}
		}
		
		if(!empty($var['admission-branch'])){
			$strm_id=$var['admission-branch'];
			//$strm_id_1 = implode(",", $strm_id);
			$where .= " and vw.stream_id in($strm_id)";
		}
		/*if(!empty($var['semester'])){
			$semesters=$var['semester'];
			$semesters_1 = implode(",", $semesters);
			$where .= " and eas.semester in($semesters_1)";
		}*/
		
		if($var['school_code'] =='All'){			
			$sch_code = implode(",", $school_code);
			if (!empty($centers)) {
                $where .= " and vw.school_id in(" . implode(',', $school_ids) . ")";
            } else {
                $where .= "";
            }
		}
		
		
	   $sql="SELECT ec.center_name,ec.center_code,t.`exam_id`, t.`subject_id`,count(eas.exam_subject_id) as TOTREG, sum(case when exam_attendance_status='P' then 1 else 0 end) as totPresent, sum(case when exam_attendance_status='A' then 1 else 0 end) as totAbsent, sum(case when malpractice='Y' then 1 else 0 end) as totmalpractice, vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code1,s.subject_code,s.subject_name, eas.`stream_id`, t.`semester`,t.`from_time`,t.`to_time`,t.`date`
		FROM `exam_applied_subjects` eas 
		left join exam_ans_booklet_attendance as eba on eas.subject_id = eba.subject_id and eba.exam_id=eas.exam_id
		left join exam_time_table as t on eas.subject_id = t.subject_id and t.exam_id=eas.exam_id
		left join subject_master as s on s.sub_id = t.subject_id 
		left join vw_stream_details vw on vw.stream_id = eas.stream_id
		left join exam_center_allocation em on em.school_id = vw.school_id  and em.exam_id =eas.exam_id 
		left join exam_center_master ec on ec.ec_id = em.center_id   
		$where group by eas.subject_id, eas.stream_id order by t.date, vw.stream_short_name, eas.stream_id, t.semester asc";
		$query = $DB1->query($sql); 
		$result = $query->result_array();
		// echo $DB1->last_query();exit;
		return $result;
	}
	
	function exam_daywise_dispatch_report($exam_date='',$exam_month='',$exam_year='',$exam_id='', $slot_from='',$slot_to='',$school_code='',$var=array()){
	    $DB1 = $this->load->database('umsdb', TRUE);

		$centers = $this->session->userdata('center_ids');

        if (!empty($centers)) {
            $DB1->select('school_id');
            $DB1->from('exam_center_allocation');
            $DB1->where_in('center_id', $centers);
            if(!empty($exam_id)){
            $DB1->where('exam_id', $exam_id);
            }   
            $school_ids = $DB1->get()->result_array();
            $school_ids = array_column($school_ids, 'school_id');
        }



	    $where ="where eas.exam_id='$exam_id' and eas.allow_for_exam='Y'" ;
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to' and eas.stream_id NOT IN (160,161)";
	    }
		
		if(!empty($school_code) && $school_code !='All'){			
			//$sch_code = implode(",", $school_code);
			/*if(in_array('1001',$school_code) && in_array('1006',$school_code)){
				//$where .= " and vw.course_id in(2,3,9,10)";
				$where .= " and vw.stream_id in(11,109,162,97,96,7) AND eas.semester IN(1)";
			}else if(in_array('1001',$school_code)){
				$where .= " and vw.course_id in(2,3)";
			}else if(in_array('1006',$school_code)){
				$where .= " and vw.course_id in(9,10)";
			}else{*/
				$where .= " and vw.school_code in($school_code)";
			//}
		}
		
		if(!empty($var['admission-branch'])){
			$strm_id=$var['admission-branch'];
			//$strm_id_1 = implode(",", $strm_id);
			$where .= " and vw.stream_id in($strm_id)";
		}
		/*if(!empty($var['semester'])){
			$semesters=$var['semester'];
			$semesters_1 = implode(",", $semesters);
			$where .= " and eas.semester in($semesters_1)";
		}*/
		if($var['school_code'] =='All'){			
			$sch_code = implode(",", $school_code);
			if (!empty($centers)) {
                $where .= " and vw.school_id in(" . implode(',', $school_ids) . ")";
            } else {
                $where .= "";
            }
		}
	   $sql="SELECT GROUP_CONCAT(DISTINCT eas.bundle_no ORDER BY eas.bundle_no ASC) AS bundle_numbers,ec.center_name,ec.center_code,t.`exam_id`, t.`subject_id`,count(eas.exam_subject_id) as TOTREG, sum(case when exam_attendance_status='P' then 1 else 0 end) as totPresent, sum(case when exam_attendance_status='A' then 1 else 0 end) as totAbsent, sum(case when malpractice='Y' then 1 else 0 end) as totmalpractice, vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code1,s.subject_code,s.subject_name, eas.`stream_id`, t.`semester`,t.`from_time`,t.`to_time`,t.`date` 
	   	FROM `exam_applied_subjects` eas 
		left join exam_ans_booklet_attendance as eba on eas.subject_id = eba.subject_id and eba.exam_id=eas.exam_id
		left join exam_time_table as t on eas.subject_id = t.subject_id and t.exam_id=eas.exam_id
		left join subject_master as s on s.sub_id = t.subject_id 
		left join vw_stream_details vw on vw.stream_id = eas.stream_id
		left join exam_center_allocation em on em.school_id = vw.school_id  and em.exam_id =eas.exam_id 
		left join exam_center_master ec on ec.ec_id = em.center_id   
		$where group by eas.subject_id, eas.stream_id order by t.date, vw.stream_short_name, eas.stream_id, t.semester asc";
		$query = $DB1->query($sql); 
		$result = $query->result_array();
		//	echo $DB1->last_query();exit;
		return $result;
	}

	
	// fetch exam_daywise_absent_students
	function exam_daywise_absent_students_old($exam_date,$subject_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where  eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`is_absent`='Y' and eas.allow_for_exam='Y'" ;
	    
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="select sm.enrollment_no FROM `exam_applied_subjects` eas left join exam_time_table as t on eas.subject_id = t.subject_id left join student_master sm on sm.stud_id = eas.stud_id
		$where group by sm.enrollment_no order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		//echo "<br>";
		return $result;
	}
		function exam_daywise_absent_students($exam_date='',$subject_id='',$stream_id='',$exam_month='',$exam_year='',$exam_id='', $slot_from='',$slot_to='',$bundle_no=''){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where es.bundle_no='$bundle_no' AND eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`exam_attendance_status`='A'" ;
	    
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="select sm.enrollment_no FROM `exam_ans_booklet_attendance` eas 
		LEFT JOIN exam_applied_subjects as es ON es.exam_id = eas.exam_id AND es.subject_id = eas.subject_id AND es.enrollment_no = eas.enrollment_no 
		left join exam_time_table as t on eas.subject_id = t.subject_id 
		left join student_master sm on sm.stud_id = eas.student_id
		$where group by sm.enrollment_no order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		// echo $DB1->last_query();exit;
		//echo "<br>";
		return $result;
	}
	function exam_daywise_present_students($exam_date='',$subject_id='',$stream_id='',$exam_month='',$exam_year='',$exam_id='', $slot_from='',$slot_to='',$bundle_no=''){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where es.bundle_no='$bundle_no' AND eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`exam_attendance_status`='P'" ;
	    
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="select sm.enrollment_no FROM `exam_ans_booklet_attendance` eas 
			LEFT JOIN exam_applied_subjects as es ON es.exam_id = eas.exam_id AND es.subject_id = eas.subject_id AND es.enrollment_no = eas.enrollment_no 
			left join exam_time_table as t on eas.subject_id = t.subject_id 
			left join student_master sm on sm.stud_id = eas.student_id
		$where group by sm.enrollment_no order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		// echo $DB1->last_query();exit;
		return $result;
	}	

	function exam_daywise_absent_students_daywise($exam_date='',$subject_id='',$stream_id='',$exam_month='',$exam_year='',$exam_id='', $slot_from='',$slot_to=''){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`exam_attendance_status`='A'" ;
	    
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="select sm.enrollment_no FROM `exam_ans_booklet_attendance` eas 
		LEFT JOIN exam_applied_subjects as es ON es.exam_id = eas.exam_id AND es.subject_id = eas.subject_id AND es.enrollment_no = eas.enrollment_no 
		left join exam_time_table as t on eas.subject_id = t.subject_id 
		left join student_master sm on sm.stud_id = eas.student_id
		$where group by sm.enrollment_no order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		// echo $DB1->last_query();exit;
		// echo "<br>";
		return $result;
	}
	function exam_daywise_present_students_daywise($exam_date='',$subject_id='',$stream_id='',$exam_month='',$exam_year='',$exam_id='', $slot_from='',$slot_to=''){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`exam_attendance_status`='P'" ;
	    
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="select sm.enrollment_no FROM `exam_ans_booklet_attendance` eas 
			LEFT JOIN exam_applied_subjects as es ON es.exam_id = eas.exam_id AND es.subject_id = eas.subject_id AND es.enrollment_no = eas.enrollment_no 
			left join exam_time_table as t on eas.subject_id = t.subject_id 
			left join student_master sm on sm.stud_id = eas.student_id
		$where group by sm.enrollment_no order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		// echo $DB1->last_query();exit;
		return $result;
	}	
	// fetch exam_daywise_Present_students
	function exam_daywise_present_students_old($exam_date,$subject_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`is_absent`='N' and eas.allow_for_exam='Y'" ;
	    
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="select sm.enrollment_no FROM `exam_applied_subjects` eas left join exam_time_table as t on eas.subject_id = t.subject_id and t.exam_id=eas.exam_id left join student_master sm on sm.stud_id = eas.stud_id
		$where group by sm.enrollment_no order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}	
	// fetch exam_daywise_malpractice_students
	function exam_daywise_malpractice_students($exam_date,$subject_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eas.`malpractice`='Y' and eas.allow_for_exam='Y'" ;
	    
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to'";
	    }
	    $sql="select sm.enrollment_no FROM `exam_applied_subjects` eas left join exam_time_table as t on eas.subject_id = t.subject_id left join student_master sm on sm.stud_id = eas.stud_id
		$where group by sm.enrollment_no order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
	function get_malpractice_list_data($exam_month='',$exam_year='', $exam_id){
	    $DB1 = $this->load->database('umsdb', TRUE);
		$centers = $this->session->userdata('center_ids');

        if (!empty($centers)) {
            $DB1->select('school_id');
            $DB1->from('exam_center_allocation');
            $DB1->where_in('center_id', $centers);
            if(!empty($exam_id)){
            $DB1->where('exam_id', $exam_id);
            }   
            $school_ids = $DB1->get()->result_array();
            $school_ids = array_column($school_ids, 'school_id');
			$school_ids = implode(',', array_map('intval', $school_ids));
        }

		

	    $where ="where eas.exam_id='$exam_id' and eas.`malpractice`='Y'" ;
		if(!empty($school_ids)){
			$where .= " AND vw.school_id in ($school_ids)";
		}
	    $where .=" group by eas.stud_id, eas.subject_id order by t.date desc" ;
	    $sql="SELECT m.malcount,eas.malpractice,eas.remark, eas.exam_subject_id,t.`exam_id`,eas.exam_month,eas.exam_year, t.`subject_id`,eas.stud_id,sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,
		vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code1,s.subject_code,s.subject_name, t.`stream_id`,
		t.`semester`,t.`from_time`,t.`to_time`,t.`date` FROM `exam_applied_subjects` eas 
		
		left join exam_time_table as t on eas.subject_id = t.subject_id and eas.exam_id = t.exam_id and eas.exam_id='$exam_id'
		
		left join subject_master as s on s.sub_id = t.subject_id 
		left join student_master sm on sm.stud_id = eas.stud_id 
		left join vw_stream_details vw on vw.stream_id = sm.admission_stream  
		left join (select count(exam_subject_id) as malcount,enrollment_no from exam_applied_subjects  where  malpractice='Y' and exam_id='$exam_id' GROUP BY enrollment_no  ) as m on m.enrollment_no=eas.enrollment_no
		
		$where ";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}

		function get_malpractice_list_of_student($exam_month,$exam_year, $exam_id,$schoolid){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where eas.exam_id='$exam_id' and eas.`malpractice`='Y' and ed.school_code=".$schoolid." group by eas.enrollment_no order by t.date desc" ;
	    
	    $sql="SELECT m.malcount,sm.stud_id ,eas.malpractice,eas.remark, eas.exam_subject_id,t.`exam_id`,eas.exam_month,eas.exam_year, t.`subject_id`,eas.stud_id,sm.enrollment_no,sm.first_name,sm.middle_name,sm.last_name,ed.mal_practice_token,
		vw.stream_short_name, vw.stream_code, s.subject_short_name,eas.semester as current_semester,s.subject_code1,s.subject_code,s.subject_name, t.`stream_id`,
		t.`semester`,t.`from_time`,t.`to_time`,t.`date` FROM `exam_applied_subjects` eas 
		
		left join exam_time_table as t on eas.subject_id = t.subject_id and eas.exam_id = t.exam_id 

		left join exam_details as ed on ed.stud_id = eas.stud_id and ed.exam_id = eas.exam_id 
		
		left join subject_master as s on s.sub_id = t.subject_id 
		left join student_master sm on sm.stud_id = eas.stud_id 
		left join vw_stream_details vw on vw.stream_id = sm.admission_stream  
		left join (select count(exam_subject_id) as malcount,enrollment_no from exam_applied_subjects  where  malpractice='Y' GROUP BY enrollment_no  ) as m on m.enrollment_no=eas.enrollment_no
		
		$where ";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
    function exam_marklist_students($exam_date,$subject_id,$stream_id,$exam_month,$exam_year,$exam_id){
        $DB1 = $this->load->database('umsdb', TRUE);
        $where ="where t.exam_month='$exam_month' AND t.exam_year='$exam_year' AND eas.subject_id='$subject_id' AND eas.stream_id ='$stream_id' AND eas.exam_id='$exam_id' and eb.`exam_attendance_status`='P' and malpractice='N'" ;
        
        if($exam_date !='' && $exam_date !='0'){
            $where .= " and t.date='$exam_date'";
        }
        $sql="select sm.enrollment_no FROM `exam_applied_subjects` eas 
		left join exam_time_table as t on eas.subject_id = t.subject_id 
		left join student_master sm on sm.stud_id = eas.stud_id
		left join exam_ans_booklet_attendance eb on eb.student_id=eas.stud_id and eb.exam_id=eas.exam_id and eb.subject_id=eas.subject_id
		$where order by sm.enrollment_no";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
    }
    // student backlog subject list
    function getStudbacklogSubject($stud_id,$current_semester,$stream_id='',$std_acd_year=''){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$academic_year=$this->config->item('academic_current_year');
		$academic_year='2025-26';
		$curr_acd_yr= explode('-',$academic_year);
		//print_r($curr_acd_yr);
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
		if($std_acd_year !=$curr_acd_yr[0]){
			$varb ='1';
		}
		if($stud_id!=""){
			$where =" WHERE erd.student_id='".$stud_id."' AND (erd.passed ='N' OR erd.grade in ('U','F')) ";//and erd.semester NOT IN(1,2,3,4)
		}		
		$sql="SELECT erd.student_id, sm.subject_name, sm.sub_id, sm.subject_code,sm.semester,
		sm.credits,sm.batch FROM `exam_student_subject` as erd left join subject_master sm on sm.sub_id=erd.subject_id $where 
			UNION 
			SELECT sas.stud_id as student_id, sm.subject_name, sm.sub_id, sm.subject_code,
			sm.semester,sm.credits,sm.batch FROM student_applied_subject sas 
			left join `subject_master` as sm on sm.sub_id = sas.subject_id
			WHERE sas.is_active='Y' and sas.stud_id='$stud_id' AND sm.is_active='Y' 
			and $varb and 
			subject_id not in(select subject_id 
			from exam_applied_subjects 
			where stud_id='".$stud_id."' and allow_for_exam ='Y')";//(sas.academic_year !='$academic_year')
		$query = $DB1->query($sql);
		// echo $DB1->last_query();exit;
		return $query->result_array();
	}	
	    // student backlog subject list
    function getStudbacklogSubjectedit($stud_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE 1=1 ";  
        
		if($stud_id!=""){
			$where.=" AND erd.student_id='".$stud_id."' AND (erd.passed ='N' OR erd.grade in ('U','F'))";
		}		
		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code,sm.subject_code1,sm.semester,sm.batch,sm.credits FROM `exam_student_subject` as erd left join subject_master sm on sm.sub_id=erd.subject_id $where";
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

		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester,sm.batch, sm.credits FROM `exam_applied_subjects` as sas left join subject_master sm on sm.sub_id=sas.subject_id where sas.stud_id='".$stud_id."' and sas.exam_id='$exam_id'";				
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch semester subject
	function getSemesterSubject_edit($sem, $stream, $batch){
		//echo $stream;
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE is_active='Y' ";  
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279);
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
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	//
	function getExamappliedFess($stud_id, $semester){
		$DB1 = $this->load->database('umsdb', TRUE);  
		$ex_session = $this->fetch_stud_curr_exam();
		$exam_id =$ex_session[0]['exam_id'];

		$sql="SELECT exam_fees FROM `exam_details` where stud_id='".$stud_id."' and exam_id='$exam_id' and semester='".$semester."'";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}	
	//exam result streams
	function get_examresltcourses($school_code){
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT DISTINCT(ed.course_id),vsd.course_name, vsd.course_short_name FROM exam_details ed left join vw_stream_details as vsd on ed.course_id = vsd.course_id where ed.school_code='".$school_code."' ";
	
		$query = $DB1->query($sql);
		return $query->result_array();
	}
	// fetch exam streams
	function get_examresltstreams($course_id){
		$DB1 = $this->load->database('umsdb', TRUE);

		$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name from exam_details ed left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id where ed.course_id='".$course_id."' ";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	// fetch exam strams
	function get_examresltsemester($stream_id){
		$DB1 = $this->load->database('umsdb', TRUE);

		$sql = "select distinct ed.semester from exam_details ed where ed.stream_id='".$stream_id."' order by ed.semester asc";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	function get_exam_app_studcount($arr, $exam_month, $exam_year, $exam_id){
		
		$DB1 = $this->load->database('umsdb', TRUE); 

		$school_code =$arr['school_code'];
		
		
		$sql="select ed.stud_id, vsd.school_code, ed.stream_id, ed.semester, count(distinct ed.stud_id) as cnt, vsd.stream_name, vsd.stream_short_name,vsd.school_short_name from exam_applied_subjects as ed 
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
	
		//echo $DB1->last_query();
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
		$sql="SELECT es.`subject_id`, count(es.subject_id) as applied_cnt FROM `exam_student_subject` es
		left join student_master s on s.stud_id = es.student_id  
		WHERE es.subject_id='$subject_id'  and es.semester='$semester' and (es.passed ='N' OR es.grade in ('U','F')) and s.cancelled_admission='N' and `stream_id`='$stream_id'";//and `stream_id`='$stream_id'
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
FROM exam_applied_subjects AS ed 
LEFT JOIN exam_details d ON ed.stud_id=d.stud_id AND d.exam_id=ed.exam_id
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
		$sql="SELECT subject_id,exam_master_id FROM `exam_applied_subjects` where stud_id ='$stud_id' and stream_id ='$stream_id' and exam_month ='$exam_month' and exam_year ='$exam_year' and exam_id ='$exam_id'";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	// fetch exam streams
	function load_ex_appliedstreams($course_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name from exam_applied_subjects ed left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id where vsd.course_id='".$course_id."' and ed.exam_id='".$exam_id."'";

		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	
	
	function load_ex_appliedstreams_new($course_id, $exam_id,$school_code){
		$DB1 = $this->load->database('umsdb', TRUE);
		//$sql = "select distinct ed.stream_id, vsd.stream_name, vsd.stream_short_name from exam_applied_subjects ed left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id where vsd.course_id='".$course_id."' and ed.exam_id='".$exam_id."'";
		
		if($course_id==0){
			$where=" vsd.school_code='$school_code' ";
		}else{
			$where=" vsd.course_id='$course_id' ";
		}
       $sql = "SELECT DISTINCT vsd.stream_id, vsd.stream_name, vsd.stream_short_name FROM  vw_stream_details AS 
         vsd  WHERE $where";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}	
	// fetch result strams
	function load_ex_appliedsemesters($stream_id, $exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);
		$sql = "select distinct semester from exam_applied_subjects  where stream_id='".$stream_id."' and exam_id='".$exam_id."' order by semester asc";
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
		$DB1->from('exam_details as ed');
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
				//$DB1->where("ed.school_code",$_POST['school_code']);	    
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
		$sql="SELECT et.*, s.subject_name,s.subject_code as sub_code FROM exam_time_table as et left join subject_master as s on s.sub_id= et.subject_id $where order by et.date, s.subject_order, et.semester asc";
        $query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
        return $query->result_array();
		
	}
	function exam_applied_subjectcount($subject_id,$stream_id,$semester,$exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT `subject_id`, count(subject_id) as exam_applied_cnt FROM `exam_applied_subjects` WHERE subject_id='$subject_id'  and semester='$semester' and exam_id=$exam_id and allow_for_exam='Y' and `stream_id`='$stream_id'";//
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}	
	function stud_applied_subjectcount($subject_id,$stream_id,$semester,$exam_id,$batch = '')
	{
		$stream_arr = array(5,6,7,8,9,10,11,96,97,107,108,109,151,158,159,162,245,266,275,279);
		$academic_year=ACADEMIC_YEAR;
		$DB1 = $this->load->database('umsdb', TRUE);
        if(($semester==1 || $semester==2) && in_array($stream_id,$stream_arr)){
		   //$stream_id=9;
		   $stream_id=$stream_id;
       }else{
		   $stream_id=$stream_id;
	   } 		   
		$sql="SELECT `subject_id`, count(sas.stud_id) as sub_applied_cnt FROM `student_applied_subject` sas
left join student_master s on s.stud_id=sas.stud_id WHERE subject_id='$subject_id'  and semester='$semester'  and `admission_stream`='$stream_id'" ;//and `stream_id`='$stream_id'   sas.academic_year='$academic_year' and
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
		$exam_id =$exam_id;		
		$sql="select sum(sub_applied_cnt) as sub_applied_cnt from(SELECT `subject_id`, count(student_id) as sub_applied_cnt FROM `exam_student_subject` WHERE subject_id='$subject_id'  and semester='$semester' and (passed ='N' OR grade in ('U','F')) and `stream_id`='$stream_id') as b";//and `stream_id`='$stream_id'and exam_id='$exam_id'
		//Union SELECT `subject_id`, count(stud_id) as sub_applied_cnt FROM `exam_applied_subjects` WHERE subject_id='$subject_id'  and semester='$semester' and `stream_id`='$stream_id'  and exam_id='$exam_id' 
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
		$sql="SELECT stud_id FROM `exam_details` WHERE stud_id='$stud_id' and `exam_id`='$exam_id'";
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}
	function chk_duplicate_abc_no($studid,$abc_no)
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$sql="SELECT stud_id FROM `student_master` WHERE `abc_no`='$abc_no' and stud_id !='$studid'";
		//echo $sql;exit;
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;	
	}
 public function get_studentwise_admission_fees($prn,$academic_year){
     $DB1 = $this->load->database('umsdb', TRUE);
	
     $sql ="SELECT 
       sm.stud_id, 
       sm.enrollment_no,  
       sm.first_name, 
       sm.middle_name, 
       sm.last_name, 
       sm.mobile, 
       sm.gender, 
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
WHERE  ad.academic_year = '$academic_year' AND sm.enrollment_no='$prn'
GROUP  BY sm.stud_id, 
          course, 
          v.stream_id, 
          admission_year 
ORDER  BY ad.cancelled_admission, 
          admission_year, 
          sm.enrollment_no ASC";
        $query=$DB1->query($sql);
		if($this->session->userdata("uid")==2){
  //echo $DB1->last_query();exit;
		}
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
   
 }	
 	function check_stud_result_status($prn,$exam_id="")
	{
		$DB1 = $this->load->database('umsdb', TRUE); 
		$stud_id = $var['stud_id'];
		$exam_id = $exam_id-1;
		$sql="SELECT DISTINCT enrollment_no FROM exam_result_data WHERE final_grade='WH' and `exam_id` in ('$exam_id')  and enrollment_no='$prn'";
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
		$sql="select count(*) as cnt from exam_session where exam_year='$exam_year'";
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
			$where.=" AND sas.stud_id='".$stud_id."'  AND sm.is_active='Y' and subject_id not in(select distinct subject_id from exam_student_subject where student_id='".$stud_id."' and (passed ='Y' OR grade not in ('U','F')) ) #and (sm.subject_component='TH' OR sm.subject_component='PR') AND sas.semester !='$semester'";
		}	
		
		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester,sm.batch,sm.credits FROM `student_applied_subject` as sas left join subject_master sm on sm.sub_id=sas.subject_id $where";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function get_examsubjects($stream_id,$exam_session, $semester){
		
		$exam_details = explode('-', $exam_session);
			$exam_id= $exam_details[2];
		$DB1 = $this->load->database('umsdb', TRUE);  
		$where=" WHERE  sas.allow_for_exam='Y'";  
        

			$where.=" AND sas.semester='$semester' AND sm.is_active='Y' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' group by sas.subject_id";

		
		$sql="SELECT sm.subject_name, sm.sub_id, sm.subject_code, sm.subject_code1,sm.semester,sm.batch,sm.credits FROM `exam_applied_subjects` as sas left join subject_master sm on sm.sub_id=sas.subject_id $where";
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}	
	function getSubjectStudentList_for_attendance($subject_id,$stream_id,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);  

		$sql="SELECT sas.stud_id,s.is_detained, sas.enrollment_no, sas.subject_id,s.first_name, s.middle_name, s.last_name,et.from_time,et.to_time,et.date as exam_date, sm.subject_code, sm.subject_name, sm.batch, et.exam_month, et.`exam_year`, sas.semester, v.stream_name, sas.exam_id,sas.stream_id, sas.semester, b.ans_bklt_received_status, b.student_id, b.exam_attendance_status, b.ans_bklet_no, b.remark FROM `exam_applied_subjects` as sas 
		
		left join subject_master sm on sm.sub_id=sas.subject_id 
		left join student_master s on s.stud_id=sas.stud_id 
		left join exam_time_table et on et.subject_id=sas.subject_id AND et.exam_id=sas.exam_id
		left join vw_stream_details v on v.stream_id=sas.stream_id 
		left join exam_ans_booklet_attendance b on  b.student_id=sas.stud_id and  b.stream_id=sas.stream_id and b.subject_id=sas.subject_id and b.exam_id=sas.exam_id and b.semester=sas.semester
		where sas.subject_id='".$subject_id."' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and sm.is_active='Y' and sas.allow_for_exam='Y'";
		$sql.=" group by sas.stud_id order by sas.enrollment_no";//left join exam_details ed on ed.exam_id=sas.exam_id and ed.enrollment_no=sas.enrollment_no
		$query = $DB1->query($sql);
	//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function check_duplicate_for_attendance($subject_id,$stream_id,$semester,$exam_id,$exam_date)
	{
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sql="SELECT att_id from exam_ans_booklet_attendance where subject_id='".$subject_id."' and stream_id='$stream_id' and exam_id='$exam_id' and semester='$semester' and exam_date='$exam_date'";
		$query = $DB1->query($sql);
		//$query->num_rows();
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function check_duplicate_for_attendance_indivisual_student($stud,$subject_id,$stream_id,$semester,$exam_id,$exam_date)
	{
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sql="SELECT att_id from exam_ans_booklet_attendance where student_id='".$stud."' and   subject_id='".$subject_id."' and stream_id='$stream_id' and exam_id='$exam_id' and semester='$semester' and exam_date='$exam_date'";
		$query = $DB1->query($sql);
		//$query->num_rows();
		//echo $DB1->last_query();
		return  $query->num_rows();
	}
	
	
	/* code by vighnesh */
	
	function get_exam_studcount_applied_and_not_applied($arr, $exam_month, $exam_year, $exam_id,$type){
		
		
		$role_id = $this->session->userdata('role_id');
	    $emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_year=$DB1->get_where('academic_year',array('currently_active'=>'Y'))->row()->session;
		$table='exam_details';
		$stream_condition=' AND sm.admission_cycle IS NULL';
		if($type=="2"){
		$table='phd_exam_details';
		$stream_condition='AND sm.admission_cycle IS NOT NULL ';	
		}

		$school_code =$arr['school_code'];
		//error_reporting(E_ALL);
		
		/*$sql="select ed.stud_id, vsd.school_code, ed.stream_id, ed.semester, count(distinct ed.stud_id) as cnt, vsd.stream_name, vsd.stream_short_name,vsd.school_short_name from exam_applied_subjects as ed 
		left join vw_stream_details as vsd on ed.stream_id = vsd.stream_id 
		where ed.exam_id ='$exam_id'";*/
		//AND FIND_IN_SET(ea.stud_id,GROUP_CONCAT(sm.stud_id))
		$sql="	SELECT COUNT(sm.stud_id) AS total_students,sm.admission_stream,sm.current_semester,vsd.stream_name, vsd.stream_short_name,vsd.school_short_name,
		(SELECT 
            COUNT(DISTINCT ea.stud_id)
        FROM
            ".$table." ea
        WHERE
            ea.stream_id = sm.admission_stream
                AND ea.exam_id = ".$exam_id."
                AND ea.semester = sm.current_semester
                AND ea.stud_id IN (
                    SELECT sm_inner.stud_id
                    FROM student_master sm_inner
                    WHERE sm_inner.admission_stream = sm.admission_stream
                        AND sm_inner.current_semester = sm.current_semester
                        AND sm_inner.academic_year = '".$exam_year."'
                        AND sm_inner.cancelled_admission = 'N'
                        AND sm_inner.admission_confirm = 'Y'
                        AND sm_inner.is_detained = 'N'
                        AND sm_inner.admission_cycle IS NULL
                )
    ) AS applied
		FROM student_master sm 
		JOIN vw_stream_details AS vsd ON sm.admission_stream = vsd.stream_id 
		WHERE 
		sm.academic_year='".$exam_year."'  AND 
		sm.cancelled_admission='N' and admission_confirm='Y'
		AND sm.is_detained='N' ".$stream_condition;
	
		
		
	
		if($school_code !='' && $school_code ==0){
			 if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 if($emp_id !='110074'){
				$schid= $empsch[0]['school_code']; 
				 $sql .=" AND vsd.school_code = $schid AND sm.admission_cycle IS NULL ";
			 }else{
				 $schid= $empsch[0]['school_code'];
				  $sql .=" AND vsd.school_code in(1001,1005) AND sm.admission_cycle IS NULL ";
			 }
			 
			
			  //$DB1->where('v.school_code!=',$schid);
			
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql.=" AND vsd.school_code = $sccode" ;
				
		}
			
		}else{
			
			
			$sql.=" AND vsd.school_code='$school_code'";
		}
		
		$sql.=" GROUP BY sm.admission_stream,sm.current_semester ";
     
		$query = $DB1->query($sql);
		$result = $query->result_array();
		 // echo '<pre>';
		// echo $DB1->last_query();exit;
		return $result;	
	}
	
	
	
	function get_exam_studcount_applied_and_not_applied_details_old($exam_id,$exam_year,$current_semester,$stream,$is_of,$type){ 
	 
	    $role_id = $this->session->userdata('role_id');
	    $condition='';
	    $table='exam_details';
		$stream_condition=' AND sm.admission_cycle IS NULL';
		if($type=="2"){
		$table='phd_exam_details';
		$stream_condition='';	
		}

	 
	  if($is_of==1){
		$condition.=" AND  sm.stud_id in (SELECT DISTINCT ea.stud_id FROM 
		".$table." ea WHERE ea.stream_id =".$stream." AND ea.exam_id=".$exam_id." AND ea.semester=".$current_semester.") ";  
	  }
	  else if($is_of==2){
		$condition.=" AND  sm.stud_id not in (SELECT DISTINCT ea.stud_id FROM
		".$table." ea WHERE ea.stream_id =".$stream." AND ea.exam_id=".$exam_id." AND ea.semester=".$current_semester.")";  
	  }
	 
	    $emp_id = $this->session->userdata("name");
		$DB1 = $this->load->database('umsdb', TRUE); 
		$exam_year=$DB1->get_where('academic_year',array('currently_active'=>'Y'))->row()->session;
		$school_code =$arr['school_code'];
		$sql="SELECT sm.*,sm.admission_stream,sm.current_semester,vsd.stream_name, vsd.stream_short_name,vsd.school_short_name,sum(ad.applicable_fee) as  applicable_total ,sum(ad.actual_fee) as actual_fees,
	    sum(case when f.amount is null then 0 else f.amount end ) as fees_total, 
        sum(f.charges) as cancel_charges,sum(case when rf.amount is null then 0 else rf.amount end )as refund ,ad.opening_balance 
		FROM student_master sm 
		JOIN vw_stream_details AS vsd ON sm.admission_stream = vsd.stream_id  LEFT JOIN admission_details as ad
	    ON sm.stud_id = ad.student_id    AND sm.academic_year=ad.academic_year LEFT JOIN ( select distinct student_id,academic_year,count(student_id)as total_count,sum( case when chq_cancelled='N' then amount else 0 end) as amount,sum( case when chq_cancelled='Y' then canc_charges else 0 end) as charges from fees_details where is_deleted='N' and academic_year='".$exam_year."' and type_id=2  group by student_id,academic_year) f 
        on CAST(ad.student_id  AS CHAR)=f.student_id and ad.academic_year=f.academic_year 
		 left join ( SELECT DISTINCT student_id,academic_year,SUM( CASE WHEN is_deleted='N' THEN amount ELSE 0 END) AS amount FROM fees_refunds WHERE is_deleted='N' GROUP BY student_id,academic_year) rf
         ON ad.student_id=rf.student_id AND ad.academic_year=rf.academic_year
		WHERE sm.academic_year='".$exam_year."'  AND sm.cancelled_admission='N' and sm.admission_confirm='Y'
		AND sm.is_detained='N'".$condition." AND sm.admission_stream=".$stream." AND sm.current_semester=".$current_semester.$stream_condition;  
		

		
			 if(isset($role_id) && $role_id==20){
			 $empsch = $this->loadempschool($emp_id);
			 $schid= $empsch[0]['school_code'];
			 if($emp_id !='110074'){
				$schid= $empsch[0]['school_code']; 
				 $sql .=" AND vsd.school_code = $schid AND sm.admission_cycle IS NULL ";
			 }else{
				 $schid= $empsch[0]['school_code'];
				  $sql .=" AND vsd.school_code in(1001,1005) AND sm.admission_cycle IS NULL ";
			 }
			
		 }else if(isset($role_id) && $role_id==10){
				$ex =explode("_",$emp_id);
				$sccode = $ex[1];
				$sql.=" AND vsd.school_code = $sccode" ;
				
		}
		$sql .=" GROUP BY sm.stud_id ";
			
	
		$query = $DB1->query($sql);
		// $DB1->last_query();
		
		$result = $query->result_array();
	
		
		return $result;	
	
    }
	 
	 function get_exam_studcount_applied_and_not_applied_details($exam_id, $exam_year, $current_semester, $stream, $is_of, $type) { 
    $role_id = $this->session->userdata('role_id');
    $emp_id = $this->session->userdata("name");
    $DB1 = $this->load->database('umsdb', TRUE);

    // Determine the active academic year
    $exam_year = $DB1->get_where('academic_year', ['currently_active' => 'Y'])->row()->session;

    // Set table and stream condition based on type
    $table = ($type == "2") ? 'phd_exam_details' : 'exam_details';
    $stream_condition = ($type == "2") ? '' : ' AND sm.admission_cycle IS NULL AND sm.admission_confirm="Y"';

    // Condition for applied or not applied
    $condition = '';
    if ($is_of == 1) {
        // Applied students
        $condition .= " AND EXISTS (
            SELECT 1 
            FROM $table ea 
            WHERE ea.stream_id = $stream 
              AND ea.exam_id = $exam_id 
              AND ea.semester = $current_semester 
              AND ea.stud_id = sm.stud_id
        )";
    } elseif ($is_of == 2) {
        // Not applied students
        $condition .= " AND NOT EXISTS (
            SELECT 1 
            FROM $table ea 
            WHERE ea.stream_id = $stream 
              AND ea.exam_id = $exam_id 
              AND ea.semester = $current_semester 
              AND ea.stud_id = sm.stud_id
        )";
    }

    // Base SQL query
    $sql = "
        SELECT 
            sm.*, 
            sm.admission_stream, 
            sm.current_semester, 
            vsd.stream_name, 
            vsd.stream_short_name, 
            vsd.school_short_name,
            SUM(ad.applicable_fee) AS applicable_total, 
            SUM(ad.actual_fee) AS actual_fees,
            SUM(CASE WHEN f.amount IS NULL THEN 0 ELSE f.amount END) AS fees_total, 
            SUM(f.charges) AS cancel_charges,
            SUM(CASE WHEN rf.amount IS NULL THEN 0 ELSE rf.amount END) AS refund,
            ad.opening_balance
        FROM student_master sm 
        JOIN vw_stream_details vsd 
            ON sm.admission_stream = vsd.stream_id
        LEFT JOIN admission_details ad 
            ON sm.stud_id = ad.student_id 
           AND sm.academic_year = ad.academic_year
        LEFT JOIN (
            SELECT 
                student_id, 
                academic_year, 
                COUNT(student_id) AS total_count,
                SUM(CASE WHEN chq_cancelled = 'N' THEN amount ELSE 0 END) AS amount,
                SUM(CASE WHEN chq_cancelled = 'Y' THEN canc_charges ELSE 0 END) AS charges
            FROM fees_details 
            WHERE is_deleted = 'N' 
              AND academic_year = '$exam_year' 
              AND type_id = 2 
            GROUP BY student_id, academic_year
        ) f 
        ON CAST(ad.student_id AS CHAR) = f.student_id 
           AND ad.academic_year = f.academic_year
        LEFT JOIN (
            SELECT 
                student_id, 
                academic_year, 
                SUM(CASE WHEN is_deleted = 'N' THEN amount ELSE 0 END) AS amount
            FROM fees_refunds 
            WHERE is_deleted = 'N' 
            GROUP BY student_id, academic_year
        ) rf 
        ON ad.student_id = rf.student_id 
           AND ad.academic_year = rf.academic_year
        WHERE sm.academic_year = '$exam_year' 
          AND sm.cancelled_admission = 'N'
          AND sm.is_detained = 'N'
          $condition
          AND sm.admission_stream = $stream 
          AND sm.current_semester = $current_semester 
          $stream_condition";

    // Role-based condition
    if (isset($role_id)) {
        if ($role_id == 20) {
            $empsch = $this->loadempschool($emp_id);
            $schid = $empsch[0]['school_code'];
            $sql .= " AND vsd.school_code = $schid";
        } elseif ($role_id == 10) {
            $ex = explode("_", $emp_id);
            $sccode = $ex[1];
            $sql .= " AND vsd.school_code = $sccode";
        }
    }

    // Grouping by student ID
    $sql .= " GROUP BY sm.stud_id";

    // Execute the query
    $query = $DB1->query($sql);

    // Log the last executed query (optional for debugging)
    $DB1->last_query();

    // Return the result
    return $query->result_array();
}
	 
	
	 function loadempschool($emp_id){
			$DB1 = $this->load->database('umsdb', TRUE); 
			$sql="SELECT v.school_code,f.department from vw_faculty f 
			LEFT JOIN sandipun_erp.employee_master e  ON e.emp_id=f.emp_id
			INNER JOIN school_master c  ON c.erp_mapp_school_id=f.emp_school
			LEFT JOIN vw_stream_details v ON v.school_id=c.school_id where f.emp_id='$emp_id' group by v.school_code
			";
			$query = $DB1->query($sql);
			return $query->result_array();
	 }

     function fetch_stud_curr_phd_exam(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("exam_month,exam_year,exam_id,exam_type");
		$DB1->from('phd_exam_session');
		$DB1->where("is_active", 'Y');
		$DB1->order_by("exam_id", 'desc');
		//$DB1->limit(1);
		$query=$DB1->get();
		$result=$query->result_array();
		//echo $DB1->last_query();
		return $result;
	}
	 function get_june_exam_credits($prn,$exam_id){
			$DB1 = $this->load->database('umsdb', TRUE); 
			$sql="SELECT sum(s.credits) as sub_credits
FROM `exam_applied_subjects` e join subject_master s on e.subject_id=s.sub_id
WHERE `exam_id` = '$exam_id' AND `enrollment_no` = '$prn'
			";
			$query = $DB1->query($sql);
			return $query->result_array();
	 }

	function get_stud_applied_sub_for_arrear_update($studentId,$current_semester){
		$DB1 = $this->load->database('umsdb', TRUE);
		$where=" WHERE sas.is_active='Y' and sas.stud_id='$studentId' AND sm.is_active='Y' and sas.semester !='$current_semester' and subject_id not in(select subject_id from exam_applied_subjects where stud_id='".$studentId."' and allow_for_exam ='Y')";  

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
        $sql = "SELECT * FROM exam_student_subject where student_id ='".$stud_id."' AND subject_id ='".$subject_id."'";        
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;   
        return $query->result_array();       
    }
	function get_form_entry_dates($exam_id)
    {       
       // print_r($var);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM marks_entery_date where exam_id ='".$exam_id."' AND status ='Y'";        
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;   
        return $query->result_array();       
    }	
	function check_duplicate_allow_student_for_exam($stud,$exam_id)
	{
		$DB1 = $this->load->database('umsdb', TRUE);  
		$sql="SELECT * from exam_allowed_students where student_id='".$stud."' and exam_id='$exam_id' ";
		$query = $DB1->query($sql);
		//$query->num_rows();
		//echo $DB1->last_query();
		return  $query->num_rows();
	}	
	
	function get_exam_allowed_studntlist($exam_id,$stud_prn)
    {       
       // print_r($var);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM exam_allowed_students where exam_id ='".$exam_id."' and enrollment_no='$stud_prn'";        
        $query = $DB1->query($sql);
		 if($stud_prn=='240105231346'){
       // echo $DB1->last_query();exit;   
		 }
        return $query->result_array();       
    }
	function get_maxcredits_allowed_studntlist()
    {       
       // print_r($var);
        $DB1 = $this->load->database('umsdb', TRUE);
        $sql = "SELECT * FROM semester_promotion_log ";        
        $query = $DB1->query($sql);
       // echo $DB1->last_query();exit;   
        return $query->result_array();       
    }
	function student_arrears_list($prn){
		$DB1 = $this->load->database('umsdb', TRUE);  
		
		$sql="SELECT s.is_detained, sas.*,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as student_name, sm.subject_code, sm.subject_name, sm.batch, ed.exam_month, ed.`exam_year`, v.stream_name FROM `exam_student_subject` as sas 
		left join exam_details ed on ed.exam_id=sas.exam_id and ed.enrollment_no=sas.enrollment_no
		left join subject_master sm on sm.sub_id=sas.subject_id 
		left join student_master s on s.stud_id=sas.student_id 
		left join vw_stream_details v on v.stream_id=sas.stream_id 
		where sas.enrollment_no='".$prn."'  ";
		$sql.=" order by sas.semester,subject_id";
		$query = $DB1->query($sql);
	//echo $DB1->last_query();exit;
		return $query->result_array();
	}
		function student_marks_entry_list($prn){
		$DB1 = $this->load->database('umsdb', TRUE);  
		
		$sql="SELECT s.exam_id,s.exam_month,s.exam_year,s.enrollment_no,UPPER(CONCAT(COALESCE(sm.first_name,''), ' ',COALESCE(sm.middle_name,''),' ',COALESCE(sm.last_name,''))) as student_name,s.stream_id,s.semester,s.subject_id,sb.subject_code,sb.subject_component,sb.subject_name ,c.cia_marks,mp.marks as pr_marks,c.attendance_marks,m.marks,
sb.theory_max,sb.theory_min_for_pass,sb.internal_max,sb.internal_min_for_pass,sb.sub_min,sb.sub_max,sb.sub_max,sb.sub_max
FROM exam_applied_subjects  s 
LEFT JOIN marks_entry_cia c ON c.stud_id=s.stud_id AND s.subject_id=c.subject_id AND c.exam_id=s.exam_id
LEFT JOIN marks_entry m ON m.stud_id=s.stud_id AND s.subject_id=m.subject_id AND s.exam_id=m.exam_id and m.marks_type='TH'
LEFT JOIN marks_entry mp ON mp.stud_id=s.stud_id AND s.subject_id=mp.subject_id AND s.exam_id=mp.exam_id and mp.marks_type='PR'
LEFT JOIN subject_master sb ON sb.sub_id=s.subject_id
left join student_master sm on sm.stud_id=s.stud_id 

WHERE  s.enrollment_no='".$prn."' and s.allow_for_exam='Y' order by s.semester,s.subject_id ";
		$query = $DB1->query($sql);
	//echo $DB1->last_query();exit;
		return $query->result_array();
	}
	function student_result_entry_list($prn,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);  
		
		$sql="SELECT s.*,sb.subject_code,sb.subject_name,sb.subject_component,sb.theory_max,sb.theory_min_for_pass,sb.internal_max,sb.internal_min_for_pass,sb.sub_min,sb.sub_max,sb.sub_max,sb.sub_max
FROM exam_result_data s 
LEFT JOIN subject_master sb ON sb.sub_id=s.subject_id
WHERE  s.enrollment_no='".$prn."' and s.exam_id='".$exam_id."' order by s.semester,s.subject_id ";
		$query = $DB1->query($sql);
	//echo $DB1->last_query();exit;
		return $query->result_array();
	}
 public function get_studentwise_hostel_fees($prn){
     $DB1 = $this->load->database('umsdb', TRUE);
	
    /* $sql ="SELECT 
	sum(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees-f.excemption_fees) as appl, COALESCE(a.fees_paid,0) as fees_paid, sum(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees-f.excemption_fees)-
	COALESCE(a.fees_paid,0) as pending_fees
	FROM sandipun_erp.sf_student_facilities f 

	LEFT JOIN (SELECT enrollment_no,student_id,academic_year,SUM( amount ) AS fees_paid,SUM(exam_fee_fine) AS fine,college_receiptno,type_id FROM sandipun_erp.sf_fees_details 
	WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='1' and enrollment_no ='$prn' GROUP BY enrollment_no) a 
	ON a.enrollment_no=f.enrollment_no AND a.student_id=f.student_id 

	INNER JOIN sandipun_ums.student_master s ON (s.enrollment_no=f.enrollment_no or s.enrollment_no_new=f.enrollment_no) and s.stud_id=f.student_id 

	where f.sffm_id=1 and f.status='Y' and f.cancelled_facility='N' and  f.enrollment_no ='$prn'
	group by f.enrollment_no";*/

	$sql ="SELECT 
	SUM(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees-f.excemption_fees) AS appl, COALESCE(a.fees_paid,0) AS fees_paid, 
	SUM(f.deposit_fees+f.actual_fees+f.gym_fees+f.fine_fees-f.excemption_fees)- COALESCE(a.fees_paid,0) AS pending_fees
	FROM sandipun_erp.sf_student_facilities f 
	#INNER JOIN sandipun_erp.sf_student_facility_allocation af ON af.enrollment_no=f.enrollment_no AND f.academic_year=af.academic_year 

	LEFT JOIN (SELECT enrollment_no,student_id,academic_year,SUM( amount ) AS fees_paid,SUM(exam_fee_fine) AS fine,college_receiptno,type_id
	 FROM sandipun_erp.sf_fees_details 
	WHERE chq_cancelled='N' AND is_deleted='N' AND type_id='1' AND enrollment_no ='".$prn."' GROUP BY enrollment_no) a 
	ON a.enrollment_no=f.enrollment_no AND a.student_id=f.student_id 

	INNER JOIN sandipun_ums.student_master s ON (s.enrollment_no=f.enrollment_no OR s.enrollment_no_new=f.enrollment_no) AND s.stud_id=f.student_id 

	WHERE f.sffm_id=1 AND f.status='Y' AND f.cancelled_facility='N'   AND f.enrollment_no ='".$prn."'
	#AND af.is_active='Y'
	GROUP BY f.enrollment_no";
        $query=$DB1->query($sql);
		if($this->session->userdata("uid")==2){
		  //echo $DB1->last_query();exit;
		  //#inner join sandipun_erp.sf_student_facility_allocation af on af.enrollment_no=f.enrollment_no and f.academic_year=af.academic_year 
		  //af.is_active='Y'  and
		}
		$result=$query->result_array();
		return $result;
   
 }
 	 function fetch_exam_applied_stud_data($exam_id){
			$DB1 = $this->load->database('umsdb', TRUE); 
			$sql="SELECT sm.subject_code,sm.subject_name,sm.batch,v.school_short_name,v.course_short_name,v.stream_name,s.current_semester,e.semester,sm.subject_component,s.enrollment_no, UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as student_name,
s.mobile,s.email, case when is_backlog='Y' then 'Y' else '' end as 'backlog' 
FROM `exam_applied_subjects` e left join student_master s on s.stud_id=e.stud_id
left join subject_master sm on sm.sub_id=e.subject_id
left join vw_stream_details v on v.stream_id=e.stream_id
where e.exam_id='$exam_id'
ORDER BY enrollment_no,subject_code";
			//echo $sql;exit;
			$query = $DB1->query($sql);
			return  $row =$query->result_array();
			 
	 }
 	 function fetch_exam_applied_stud_data_time_table($exam_id){
			$DB1 = $this->load->database('umsdb', TRUE); 
			$sql="SELECT s.enrollment_no,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) AS student_name,s.mobile,s.email,s.dob,
sm.subject_code,sm.subject_name,sm.subject_component,t.date as exam_date,et.session,s.admission_session,s.current_semester,e.semester,s.current_year,v.school_short_name,v.course_short_name,v.stream_name
FROM student_master AS s
left join exam_applied_subjects e on e.stud_id=s.stud_id and e.exam_id='$exam_id'
left join subject_master sm on sm.sub_id=e.subject_id
left join exam_time_table t on t.subject_id=e.subject_id
left join examtime_slot et on et.id=t.exam_slot_id and et.exam_id=e.exam_id
LEFT JOIN vw_stream_details v ON v.stream_id=s.admission_stream
where e.exam_id='$exam_id' and et.session is not null and et.is_active='Y'
ORDER BY sm.subject_code,sm.subject_name
			";
			$query = $DB1->query($sql);
			return $query->result_array();
	 }

function get_student_latest_exam($exam_id,$student_id){
	 	$DB1 = $this->load->database('umsdb', TRUE); 
        $sql="SELECT exam_id FROM `exam_details` where stud_id='$student_id' and exam_id='$exam_id'";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();

	 }	

function load_examsess_schools_for_rank_data($admissionsesssion){
		//$exam = explode('-',$exam_session);
		$DB1 = $this->load->database('umsdb', TRUE); 
		//$exam_id =$exam[2];
		$sql="select v.stream_id, v.school_code, v.school_short_name from (select DISTINCT stream_id from exam_details) as e left join vw_stream_details as v on v.stream_id= e.stream_id group by v.school_code";	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	}

function malpractice_count($prn){

		$DB1 = $this->load->database('umsdb', TRUE); 
		//$exam_id =$exam[2];
		$sql="select count(exam_subject_id) as malcount,enrollment_no from exam_applied_subjects  where enrollment_no='$prn' and malpractice='Y'";	
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();


	}

    function get_exam_detail_data($exam_id,$enrollment_no,$student_id,$txnid){
	 	$DB1 = $this->load->database('umsdb', TRUE); 
        $sql="SELECT * FROM `exam_details_transaction` where stud_id='$student_id' and exam_id='$exam_id' and enrollment_no = '$enrollment_no' and txnid = '$txnid' ";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();

	 }
	function check_duplicate_exam_detail_data($exam_id,$enrollment_no,$student_id,$txnid){
	 	$DB1 = $this->load->database('umsdb', TRUE); 
        $sql="SELECT * FROM `exam_details` where stud_id='$student_id' and exam_id='$exam_id' and enrollment_no = '$enrollment_no'";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();

	 }
function get_exam_subject_detail_data($exam_id,$enrollment_no,$student_id,$txnid,$exam_master_id){
	 	$DB1 = $this->load->database('umsdb', TRUE); 
        $sql="SELECT * FROM `exam_applied_subjects_transaction` where stud_id='$student_id' and exam_id='$exam_id' and enrollment_no = '$enrollment_no' and txnid = '$txnid' and exam_master_id = '$exam_master_id'";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();

	 }	

  function get_exam_student_data(){
	  
	    $DB1 = $this->load->database('umsdb', TRUE); 
        $sql="SELECT * FROM `exam_details` where  exam_id=31 and enrollment_no ='220105131173'";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		return $query->result_array();
	  
	  
  }

	function exam_report_students($streamid='',$year='', $exam_id,$exam_type){

		$DB1 = $this->load->database('umsdb', TRUE);
		
		$DB1->select("ecm.center_code,ecm.center_name,ed.*, sm.*,stm.stream_name,stm.course_type,stm.gradesheet_name,stm.specialization,stm.course_name,stm.stream_code, stm.course_short_name, stm.course_id,stm.stream_id,stm.school_name,stm.school_code,stm.school_short_name,stm.course_duration,stm.course_pattern");
		$DB1->from('exam_details as ed');
		if($exam_type=='Makeup'){
		//	$DB1->where_in('er.result_grade', $categories);
			$DB1->join('exam_result_data as er','ed.stud_id = er.student_id','left');	
		}
		$DB1->join('student_master as sm','sm.stud_id = ed.stud_id','left');
		$DB1->join('vw_stream_details as stm','sm.admission_stream = stm.stream_id','left');
		$DB1->join('exam_center_allocation as eca','eca.school_id = sm.admission_school and eca.exam_id = ed.exam_id','left');
		$DB1->join('exam_center_master as ecm','eca.center_id = ecm.ec_id','left');
		
		if($_POST['school_code']==0){
			    
		}
		else{
			//  $DB1->where("ed.school_code",$_POST['school_code']);	    
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
		
		//  $array_stud=array();
		$DB1->where("ed.allow_for_exam",'Y');
		$DB1->where("ed.exam_id", $exam_id);
		$DB1->where("sm.cancelled_admission",'N');
		if($_POST['lstart']!=''){
		$DB1->limit(200,$_POST['lstart']);
		}
		//  $DB1->where_in("ed.exam_master_id",$array_stud);
		//	$DB1->where("sm.academic_year",'2017');
		if($exam_type=='Makeup'){
			$DB1->group_by("sm.enrollment_no");
		}
		$DB1->order_by("sm.enrollment_no", "asc");
		$query=$DB1->get();
		// echo $DB1->last_query();	die();  
		$result=$query->result_array();
		return $result;
	}  
	function get_degree_completed_data($exam_month='',$exam_year='', $exam_id){
	    $DB1 = $this->load->database('umsdb', TRUE);	    	    
	    $sql="select s.enrollment_no,UPPER(CONCAT(COALESCE(s.first_name,''), ' ',COALESCE(s.middle_name,''),' ',COALESCE(s.last_name,''))) as student_name,s.mobile,s.admission_year,s.lateral_entry,v.course_pattern,s.email,concat(exam_month,'-',exam_year) as exam_month,e.exam_id,v.school_short_name,v.course_short_name,v.stream_name,s.admission_session,s.academic_year,current_semester,s.current_year,v.course_duration  from exam_details e 
INNER JOIN student_master s ON s.stud_id = e.stud_id and e.semester=s.current_semester
inner join vw_stream_details v on v.stream_id=s.admission_stream 
INNER JOIN (SELECT student_id as astudent_id,enrollment_no AS aenrollment_no,stream_id AS astream_id,semester AS asemester,exam_id AS aexam_id, 
SUM(CASE WHEN (passed ='Y' OR grade not in ('U','F')) THEN 0 ELSE 1 END) AS chec FROM exam_student_subject GROUP BY student_id) AS a ON a.astudent_id=e.stud_id AND a.chec='0' 
where e.exam_id='$exam_id' and s.current_year=v.course_duration #and s.academic_year !='2023'
order by v.school_short_name,v.course_short_name,v.stream_name";
		$query = $DB1->query($sql);
		$result = $query->result_array();
		//echo $DB1->last_query();exit;
		return $result;
	}
/////////////////////////////////////////////////////
	function getSubjectStudentList_for_attendance_excel($subject_id,$stream_id,$exam_id){
		$DB1 = $this->load->database('umsdb', TRUE);  

		$sql="SELECT sas.barcode, sas.stud_id,s.is_detained, sas.enrollment_no, sas.subject_id,s.first_name, s.middle_name, s.last_name,et.from_time,et.to_time,et.date as exam_date, sm.subject_code, sm.subject_name, sm.batch, et.exam_month, et.`exam_year`, sas.semester, v.stream_name, sas.exam_id,sas.stream_id, sas.semester, b.ans_bklt_received_status, b.student_id, b.exam_attendance_status, b.ans_bklet_no, b.remark 
		FROM `exam_applied_subjects` as sas 
		left join subject_master sm on sm.sub_id=sas.subject_id 
		left join student_master s on s.stud_id=sas.stud_id 
		left join exam_time_table et on et.subject_id=sas.subject_id AND et.exam_id=sas.exam_id
		left join vw_stream_details v on v.stream_id=sas.stream_id 
		left join exam_ans_booklet_attendance b on  b.student_id=sas.stud_id and  b.stream_id=sas.stream_id and b.subject_id=sas.subject_id and b.exam_id=sas.exam_id and b.semester=sas.semester
		where sas.subject_id='".$subject_id."' and sas.stream_id='$stream_id' and sas.exam_id='$exam_id' and sm.is_active='Y' and sas.allow_for_exam='Y'";
		$sql.=" group by sas.stud_id order by sas.enrollment_no";

		//left join exam_details ed on ed.exam_id=sas.exam_id and ed.enrollment_no=sas.enrollment_no

		$query = $DB1->query($sql);

		// echo $DB1->last_query();exit;

		return $query->result_array();
	}



	public function generate_and_update_barcodes($exam_id) {
		

	
		// Generate all possible barcode numbers
		$barcodes = range(1, 999999);
		shuffle($barcodes);
		$index = 0;
	
		// print_r($exam_id);exit;
		// Select exam subjects by exam_id

		$DB1 = $this->load->database('umsdb', TRUE); 
         $sql="SELECT exam_subject_id FROM `exam_applied_subjects` WHERE `exam_id` = $exam_id and barcode is null
		 ";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$exam_subjects= $query->result_array();
		//echo count($exam_subjects);exit;
		//print_r($exam_subjects);exit;

		// Update barcode for each exam subject
		foreach ($exam_subjects as $row) {
			$barcode = str_pad($barcodes[$index], 6, '0', STR_PAD_LEFT);
			$id = $row['exam_subject_id']; // Assuming 'exam_subject_id' is the primary key of your table
	
		//	echo '<pre>';

		//	print_r($id); 

			$data_sam = array('barcode' => $barcode);
	
			// Update barcode in the database

			$DB1->where('exam_subject_id', $id);
			$DB1->update('exam_applied_subjects', $data_sam);
	
		//	echo $DB1->last_query();
			 $index++;
		//exit;
		//echo $index;
		} 
		
		/*
		$DB1 = $this->load->database('umsdb', TRUE);

		// Step 1: Get all existing barcodes for exam_id = 41
		$usedBarcodeQuery = $DB1->query("SELECT barcode FROM exam_applied_subjects WHERE exam_id = 41 AND stream_id = 211 AND barcode IS NOT NULL");
		$usedBarcodes = array_column($usedBarcodeQuery->result_array(), 'barcode');
		
		// Step 2: Generate all possible barcodes and exclude the used ones
		$allBarcodes = range(1, 999999);
		shuffle($allBarcodes);
		ini_set('memory_limit', '512M');

		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		// error_reporting(E_ALL);

		// Step 3: Filter out already used barcodes
		$availableBarcodes = array_diff($allBarcodes, $usedBarcodes);
		$availableBarcodes = array_values($availableBarcodes); // reindex array
		$index = 0;

		// Step 4: Fetch records to assign new barcodes
         $sql="SELECT exam_subject_id FROM `exam_applied_subjects` WHERE `exam_id` = $exam_id and barcode is null AND stream_id = 211";		
		 
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$exam_subjects= $query->result_array();

		// Step 5: Update barcodes
		foreach ($exam_subjects as $row) {
			if (!isset($availableBarcodes[$index])) {
				// echo "❌ Not enough unique barcodes left.";
				break;
			}

			$barcode = str_pad($availableBarcodes[$index], 6, '0', STR_PAD_LEFT);
			$data = ['barcode' => $barcode];

			$DB1->where('exam_subject_id', $row['exam_subject_id']);
			$DB1->update('exam_applied_subjects', $data);

			$index++;
		} */
		// exit;
	}
  function get_exam_data_by_id($exam_id){
	  
	    $DB1 = $this->load->database('umsdb', TRUE); 
         $sql="SELECT * FROM `exam_applied_subjects` WHERE `exam_id` = 37 limit 10";		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$datar= $query->result_array();
		//print_r($datar);
	  return $datar;
	  
  }
    public function get_exam_data_by_id11($exam_id) {

		$DB1 = $this->load->database('umsdb', TRUE);

        // Query to fetch exam data by ID

        $sql="SELECT * FROM `exam_applied_subjects` WHERE `exam_id` = 37";
		
		//left join exam_details ed on ed.exam_id=sas.exam_id and ed.enrollment_no=sas.enrollment_no

		$query = $DB1->query($sql);

		// echo $DB1->last_query();exit;

		return $query->result_array();

        
    }


	public function generate_barcodes($exam_id, $admission_branch, $semester, $subject_id) {
		
		$DB1 = $this->load->database('umsdb', TRUE);  
	
		// Build the SQL query based on the additional parameters
		$sql = "SELECT * FROM exam_applied_subjects WHERE exam_id='$exam_id'";

		if (!empty($admission_branch)) {
			$sql .= " AND stream_id='$admission_branch'";
		}
		if (!empty($semester)) {
			$sql .= " AND semester='$semester'";
		}
		if (!empty($subject_id)) {
			$sql .= " AND subject_id='$subject_id'";
		}
		$sql .= "  order by enrollment_no";
		$query = $DB1->query($sql);

		// echo $DB1->last_query();exit;

		$result = $query->result();
	
		$data = array();
	
		foreach ($result as $row) {
			$data[] = $row->barcode;
		}
		
		return $data;
	}
	
	
	public function get_studentwise_admission_fees_pending(){
     $DB1 = $this->load->database('umsdb', TRUE);
	 $academic_year=C_RE_REG_YEAR;
     $sql ="SELECT 
       sm.stud_id, 
       sm.enrollment_no,  
       sm.first_name, 
       sm.middle_name, 
       sm.last_name, 
       sm.mobile, 
       sm.gender, 
       v.school_short_name, 
       v.course_short_name    AS course, 
       v.stream_short_name, 
       v.stream_id,p.parent_mobile2, 
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
		left join (select parent_mobile2,student_id from parent_details group by student_id) as p on sm.stud_id=p.student_id		 
				 
WHERE  ad.academic_year = '$academic_year' AND sm.enrollment_no!='' AND  sm.cancelled_admission='N' AND sm.admission_confirm='Y'  AND sm.academic_year='$academic_year' and sm.mobile!='' and sm.mobile IS NOT NULL
GROUP  BY sm.stud_id, 
          course, 
          v.stream_id, 
          admission_year 
ORDER  BY ad.cancelled_admission, 
          admission_year, 
          sm.enrollment_no ASC";
        $query=$DB1->query($sql);
		if($this->session->userdata("uid")==2){
  //echo $DB1->last_query();exit;
		}
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
   
 }	
 
/////////////////////////////	
	/////////////Bundle no code start/////////////////////
		public function get_filtered_students($exam_id, $school_code, $admission_course, $admission_branch, $semester, $subject_id) {
                $DB1 = $this->load->database('umsdb', TRUE); 

                $DB1->select('e.*');                                      
                $DB1->from('exam_applied_subjects e');      
               // $DB1->join('vw_stream_details v','v.stream_id= e.stream_id','left');                                
                $DB1->where('e.exam_id', $exam_id);                                      
               // $DB1->where('v.school_code', $school_code);                                      
               // $DB1->where('v.course_id', $admission_course);                                      
                $DB1->where('e.stream_id', $admission_branch);                                      
                $DB1->where('e.semester', $semester);                                      
                $DB1->where('e.subject_id', $subject_id);                                      
                $DB1->order_by('e.enrollment_no');                                      
                $query = $DB1->get();                                      
        //        echo $DB1->last_query();exit;                                      
                return $query->result_array();                                      
        }
		public function get_center_code($exam_id, $school_code){
                $DB1 = $this->load->database('umsdb', TRUE);
                $sql="SELECT cm.ec_id FROM `exam_center_allocation` as ca left join exam_center_master as cm on cm.ec_id = ca.center_id left join school_master as sch on sch.school_id = ca.school_id where sch.school_code = $school_code  and ca.exam_id = $exam_id";
                $query = $DB1->query($sql);
        //        echo $DB1->last_query();exit;
                return $query->row_array();
        }

		public function get_exam_session($exam_id) {
                $DB1 = $this->load->database('umsdb', TRUE);
                $sql = "SELECT `session` FROM `examtime_slot` WHERE exam_id = ?";
                $query = $DB1->query($sql, array($exam_id));
        
                $result = $query->row_array(); // Get the first row as an associative array
        
                if ($result) {
                        $session = $result['session'];
                        if ($session === 'FN') {
                                return 1;
                        } elseif ($session === 'AN') {
                                return 2;
                        } else {
                                return null; // Or handle other cases if necessary
                        }
                } else {
                        return null; // No result found
                }
        }

	public function get_bundle_recent_sr_no($exam_id, $center_id, $school_code, $admission_branch) {
		$DB1 = $this->load->database('umsdb', TRUE);

		$DB1->select('vs.stream_id');
		$DB1->from('vw_stream_details vs');
		$DB1->join('exam_center_allocation eca', 'eca.school_id = vs.school_id', 'left');
		$DB1->where('eca.exam_id', $exam_id);
		$DB1->where('eca.center_id', $center_id);
		$streams = $DB1->get()->result_array();
		$stream_ids = array();
		foreach ($streams as $stream) {
			$stream_ids[] = $stream['stream_id'];
		}

		if (count($stream_ids) > 0) {
			$DB1->select('MAX(eas.bundle_sr_no) as bundle_sr_no');
			$DB1->from('exam_applied_subjects eas');
			$DB1->where('eas.exam_id', $exam_id);
			$DB1->where_in('eas.stream_id', $stream_ids);
			$query = $DB1->get();
			// echo $DB1->last_query();exit;
			$result = $query->row_array();
			if ($result) {
				return $result['bundle_sr_no'];
			} else {
				return null; // Return null if no records are found
			}
		}

	}

	public function update_bundle_number($student_id, $bundle_no, $i, $exam_id, $school_code, $admission_course, $admission_branch, $semester, $subject_id) {
                $DB1 = $this->load->database('umsdb', TRUE); 

                $DB1->where('stud_id', $student_id);
                $DB1->where('exam_id', $exam_id);
        //        $DB1->where('school_code', $school_code);
        //        $DB1->where('course_id', $admission_course);
                $DB1->where('stream_id', $admission_branch);
                $DB1->where('semester', $semester);
                $DB1->where('subject_id', $subject_id);
                $DB1->update('exam_applied_subjects', array('bundle_no' => $bundle_no, 'bundle_sr_no' => $i));

                //  echo $DB1->last_query();exit;
        
        }
		
	public function check_bundle_number_exists($subject_id,$exam_id, $admission_branch) {
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('bundle_no');
		$DB1->from('exam_applied_subjects');
		$DB1->where('subject_id', $subject_id);
		$DB1->where('exam_id', $exam_id);
		$DB1->where('stream_id', $admission_branch);
		$DB1->where('bundle_no IS NOT NULL', null, false);
		$query = $DB1->get();
		// echo $DB1->last_query();exit;
		$result = $query->row_array();
		if ($result) {
			return $result['bundle_no'];
		} else {
			return null; // Return null if no records are found
		}
	}

 public function get_studentwise_caution_fees($prn,$academic_year){
     $DB1 = $this->load->database('umsdb', TRUE);
	
     $sql ="SELECT 
		SUM(c.current_pay) AS caution_money, 
		SUM(d.amount) AS paid_caution_money,
		CASE 
			WHEN SUM(c.current_pay) = SUM(d.amount) THEN TRUE 
			ELSE FALSE 
		END AS is_equal
		FROM sandipun_ums.university_caution c
		JOIN online_payment d ON  d.registration_no=c.enrollment_no AND d.productinfo='causion_money' and payment_status='success'
		WHERE c.enrollment_no = '$prn'
		GROUP BY c.enrollment_no;";
        $query=$DB1->query($sql);
		if($this->session->userdata("uid")==2){
  //echo $DB1->last_query();exit;
		}
		//echo $DB1->last_query();exit;
		$result=$query->result_array();
		return $result;
   
 }
 	function get_streams_for_arrears($course_id,$school_code=''){
		$DB1 = $this->load->database('umsdb', TRUE);		
		$sql = "select vw.stream_id,stream_name,stream_short_name from vw_stream_details vw where 1";
		if($school_code !=''){
			$sql .= " and vw.school_code='".$school_code."'";
		}
		if($course_id !=0){
			$sql .= " and vw.course_id='".$course_id."'";
		}
		
		$query = $DB1->query($sql);
		//echo $DB1->last_query();exit;
		$stream_details = $query->result_array();
		return $stream_details;
	}
	
	function getSchoolsByCenter($exam_id){

		$DB1 = $this->load->database('umsdb', TRUE); 

        $centers = $this->session->userdata('center_ids');
		//print_r($centers);

		$exam_id = explode('-', $exam_id);
		$exam_id = $exam_id[2];

		$DB1->select('sm.school_id, sm.school_code, sm.school_short_name');
		$DB1->from('exam_center_allocation eca');
		$DB1->join('school_master sm', 'eca.school_id = sm.school_id', 'left');
		if(!empty($centers)){
			$DB1->where_in('eca.center_id', $centers);
		}
		$DB1->where('eca.exam_id', $exam_id);

		$query = $DB1->get()->result_array();
		return $query;
	}
	
	function get_examstreamsBySchool($course_id, $exam_session){

		$exam = explode('-',$exam_session);
		$exam_id =$exam[2];
		$DB1 = $this->load->database('umsdb', TRUE); 

        $centers = $this->session->userdata('center_ids');

        $user_role = $this->session->userdata('role_id');

        if (!empty($centers)) {
            $DB1->select('school_id');
            $DB1->from('exam_center_allocation');
            $DB1->where_in('center_id', $centers);
            if(!empty($exam_id)){
            $DB1->where('exam_id', $exam_id);
            }   
            $school_ids = $DB1->get()->result_array();
            $school_ids = array_column($school_ids, 'school_id');
        }
		

		$DB1->select('stream_id, stream_name, stream_short_name');
		$DB1->from('vw_stream_details');
		if(!empty($school_ids)){
			$DB1->where_in('school_id', $school_ids);
		}
		$DB1->where('course_id', $course_id);
		$query = $DB1->get();

		// echo $DB1->last_query();exit;

		$stream_details = $query->result_array();
		return $stream_details;
	}

	/////////////Bundle no code END/////////////////////
	
		function exam_daywise_Answerbooklets_report($exam_date='',$exam_month='',$exam_year='',$exam_id='', $slot_from='',$slot_to='',$school_code='',$var=array()){
	    $DB1 = $this->load->database('umsdb', TRUE);
	    $where ="where eas.exam_id='$exam_id' and eas.allow_for_exam='Y'" ;
	    if($exam_date !='' && $exam_date !='0'){
	        $where .= " and t.date='$exam_date' and t.from_time='$slot_from' and t.to_time='$slot_to' and eas.stream_id NOT IN (160,161)";
	    }
		
		if(!empty($school_code) && $school_code !='All'){			
			//$sch_code = implode(",", $school_code);
			
			/*if(in_array('1001',$school_code) && in_array('1006',$school_code)){
				//$where .= " and vw.course_id in(2,3,9,10)";
				$where .= " and vw.stream_id in(11,109,162,97,96,7) AND eas.semester IN(1)";
			}else if(in_array('1001',$school_code)){
				$where .= " and vw.course_id in(2,3)";
			}else if(in_array('1006',$school_code)){
				$where .= " and vw.course_id in(9,10)";
			}else{*/
				$where .= " and vw.school_code in($school_code)";
			//}
		}
		
		if(!empty($var['admission-branch'])){
			$strm_id=$var['admission-branch'];
			//$strm_id_1 = implode(",", $strm_id);
			$where .= " and vw.stream_id in($strm_id)";
		}
		/*if(!empty($var['semester'])){
			$semesters=$var['semester'];
			$semesters_1 = implode(",", $semesters);
			$where .= " and eas.semester in($semesters_1)";
		}*/
	   $sql="SELECT eas.bundle_no,ec.center_name,ec.center_code,t.`exam_id`, t.`subject_id`,count(eas.exam_subject_id) as TOTREG, sum(case when exam_attendance_status='P' then 1 else 0 end) as totPresent, sum(case when exam_attendance_status='A' then 1 else 0 end) as totAbsent, sum(case when malpractice='Y' then 1 else 0 end) as totmalpractice, vw.stream_short_name, vw.stream_code, s.subject_short_name,s.subject_code1,s.subject_code,s.subject_name, eas.`stream_id`, t.`semester`,t.`from_time`,t.`to_time`,t.`date` 
	   	FROM `exam_applied_subjects` eas 
		left join exam_ans_booklet_attendance as eba on eas.subject_id = eba.subject_id and eba.exam_id=eas.exam_id
		left join exam_time_table as t on eas.subject_id = t.subject_id and t.exam_id=eas.exam_id
		left join subject_master as s on s.sub_id = t.subject_id 
		left join vw_stream_details vw on vw.stream_id = eas.stream_id
		left join exam_center_allocation em on em.school_id = vw.school_id  and em.exam_id =eas.exam_id 
		left join exam_center_master ec on ec.ec_id = em.center_id   
		$where group by eas.bundle_no,eas.subject_id, eas.stream_id order by eas.enrollment_no asc";
		$query = $DB1->query($sql); 
		$result = $query->result_array();
	//	echo $DB1->last_query();exit;
		return $result;
	}
	
	public function get_student_admission_yr($enrollment_no) {
		$DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select('admission_session,admission_year,nationality,package_name,ad.state_id');
		$DB1->from('student_master');
		$DB1->join('address_details ad','ad.student_id = student_master.stud_id','left');
		$DB1->where('enrollment_no', $enrollment_no);
		$query = $DB1->get();
		// echo $DB1->last_query();exit;
		return $query->row_array();

	}
	
}?>