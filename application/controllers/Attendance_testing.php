<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 // error_reporting(E_ALL);
class Attendance_testing extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $table_name="subject_master";
    var $model_name="Attendance_model";
    var $model;
    var $view_dir='Attendance/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
        
        $this->load->helper("url");		
        $this->load->library('form_validation');
        
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
       
        
        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    //view
    public function index()
    {
		$this->load->view('header',$this->data); 
		$this->load->model('Subject_model');
		$emp_id = $this->session->userdata("name");
		$curr_session= $this->Attendance_model->getCurrentSession();
		
		$this->data['sb']= $this->Attendance_model->getFacultySubjects_for_markattendance($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year']);
		
		$this->data['academic_year'] = $curr_session[0]['academic_year'];
		//$this->data['classRoom']= $this->Attendance_model->getclassRoom($emp_id,$curr_session[0]['academic_session']);
		$this->data['slots']= $this->Attendance_model->getSlots();
        $this->load->view($this->view_dir.'view_attendance',$this->data);
        $this->load->view('footer');

	}
	
	
    public function suggestions()
    {
        if($_POST)
        {
     
   $this->Attendance_model->add_suggestions();         
        }
        else
        {
		$this->load->view('header',$this->data); 
	
		$this->data['suggestions']= $this->Attendance_model->suggestions();

        $this->load->view($this->view_dir.'suggestion',$this->data);
        $this->load->view('footer');
        }

	}	
	
	
    public function student_suggestions()
    {
        if($_POST)
        {
     
  $this->Attendance_model->update_suggestions();         
        }
        else
        {
		$this->load->view('header',$this->data); 
	
		$this->data['suggestions']= $this->Attendance_model->student_suggestions();

        $this->load->view($this->view_dir.'student_suggestions',$this->data);
        $this->load->view('footer');
        }

	}		
	
	
	
	
	
	
    //search
    public function search_subAndStudent()
    {
		$emp_id = $this->session->userdata("name");
		$this->load->model('Subject_model');
        $this->load->view('header',$this->data);                    
		$subject_id = explode('-', $_POST['subject']);
		$this->data['slot_no'] = $_POST['slot_no'];
		//echo  $subject_id[2];exit;
		$this->data['subCode'] = $subject_id[0];
		$this->data['division'] = $subject_id[1];
		$this->data['batch'] = $subject_id[2];
		//$this->data['sub_batch'] = $_POST['subject'];
		$this->data['classId'] = $subject_id[4];
		$this->data['semesterNo'] = $subject_id[3];
		$this->data['sub_details'] = $_POST['subject'];
		
		$division = $subject_id[1];
		$batch = $subject_id[2];
		$semester = $subject_id[3];
		$streamId=$subject_id[4];
		$curr_session= $this->Attendance_model->getCurrentSession();
		$acd_yr = $curr_session[0]['academic_year'];
		$this->data['academic_year'] = $acd_yr;
		$this->data['sb']= $this->Attendance_model->getFacultySubjects_for_markattendance($emp_id, $curr_session[0]['academic_session'], $acd_yr);
		$this->data['classRoom']= $this->Attendance_model->getclassRoom($emp_id,$acd_yr);
		$this->data['subdetails']= $this->Attendance_model->getsubdetails($subject_id[0]);
		//$this->data['slots']= $this->Attendance_model->getSlots();
		$this->data['topics']=$this->Attendance_model->fetch_subject_lplan($subject_id[0],$acd_yr,$curr_session[0]['academic_session']);
		
		if(!empty($semester) && !empty($semester)){
			$this->data['studbatch_allot_list']= $this->Attendance_model->get_studbatch_allot_list($subject_id[0],$streamId,$semester,$division, $batch,$acd_yr);			
		}
		
        $this->load->view($this->view_dir.'view_attendance_testing',$this->data);
        $this->load->view('footer');
    }    
	// load subject
	public function load_subject(){
		$emp_id = $this->session->userdata("name");
		$room_no = $_POST['room_no'];
		$semesterId = $_POST['semesterId'];
		$division = $_POST['division'];
		$academic_year = $_POST['academic_year'];
		$sub_details = $this->Attendance_model->load_subject($room_no, $semesterId,$division, $emp_id, $academic_year);
		$rowCount = count($sub_details);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Subject</option>';
                foreach ($sub_details as $sub) {
					if($sub['subject_code'] !='OFF'){
						if($sub['batch_no'] ==0){
							$batch = "";
						}else{
							$batch =$sub['batch_no'];
						}
						echo '<option value="'.$sub['subject_code'].'-'.$sub['division'].'-'.$sub['batch_no'].'"' . $sel . '>'.$sub['subject_short_name'].'('.$sub['sub_code'].')-'.$sub['division'].''.$batch.'</option>';
					}
				}
            } else {
                echo '<option value="">Subject not available</option>';
            }
	}
	// load streams

	function load_sem() {
		// load library function for session
		$obj = New Consts();
		$curr_sess = $obj->fetchCurrSession();
		
		$emp_id = $this->session->userdata("name");
        if (isset($_POST["room_no"]) && !empty($_POST["room_no"])) {
            //Get all city data
            $stream = $this->Attendance_model->getSem($emp_id,$_POST["room_no"],$curr_sess, $_POST["academic_year"]);
           // print_r($stream);
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Semester</option>';
                foreach ($stream as $value) {
					
                    echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
                }
            } else {
                echo '<option value="">Semester not available</option>';
            }
        }
    }
	public function load_division(){
		$emp_id = $this->session->userdata("name");
		$room_no = $_POST['room_no'];
		$semesterId = $_POST['semesterId'];
		$sub_details = $this->Attendance_model->load_division($room_no, $semesterId, $emp_id,$_POST["academic_year"]);
		$rowCount = count($sub_details);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Division</option>';
                foreach ($sub_details as $sub) {
					
					echo '<option value="'.$sub['division'].'">'.$sub['division'].'</option>';
				}
            } else {
                echo '<option value="">Division not available</option>';
            }
	}
    // insert and update
    public function markAttendance()
    {    
    	$DB1 = $this->load->database('umsdb', TRUE); 
		$emp_id = $this->session->userdata("name");
		$today = $_POST['today_date'];
		$checked_stud = $_POST['chk_stud'];
		$sem_id = $_POST['sem'];
		$stream_id = $_POST['stream_code'];
		$slot = $_POST['slot'];
		$sub_code = $_POST['sub_code'];
		$academic_year = $_POST['academic_year'];
		$division = $_POST['division'];
		$batch = $_POST['batch'];

		//echo "<pre>";
		//print_r($_POST);exit;
		$CntDup = $this->Attendance_model->check_dup_attendance($today, $slot, $emp_id, $sem_id, $division, $batch,$sub_code);
		//echo count($CntDup);
		if(count($CntDup) == 0){
			$allbatchStudent = $this->Attendance_model->get_studbatch_allot_list($sub_code,$stream_id, $sem_id,$division, $batch,$academic_year);
			$curr_session= $this->Attendance_model->getCurrentSession();
			if($curr_session[0]['academic_session']=='WINTER'){
				$curr_ses = 'WIN';
			}else{
				$curr_ses = 'SUM';
			}
			
			if(!empty($checked_stud)){
					foreach($checked_stud as $stud_checked){
						//echo $stud_checked;echo "<br>";
						$stud_app_id[]= $stud_checked; 
					}
			}

			foreach ($allbatchStudent as $stud) {
				
				$data['student_id'] = $stud['stud_id'];
				$data['semester'] = $sem_id;
				$data['stream_id'] = $stream_id;
				$data['division'] = $_POST['division']; // newly added
				$data['batch'] = $_POST['batch']; // newly added
				$data['slot'] = $slot;
				$data['subject_id'] = $sub_code;
				$data['academic_year'] = $_POST['academic_year'];
				$data['academic_session'] = $curr_ses;
				$data['attendance_date'] = $today;
				$data['inserted_datetime'] = date('Y-m-d H:i:s');
				$data['faculty_code'] = $this->session->userdata("name");
				
				if (in_array($stud['stud_id'], $stud_app_id)){
					$data['is_present'] = 'Y';
				}else{
					$data['is_present'] = 'N';
				}
			
				$this->Attendance_model->markAttendance($data);
			}
			
			$cnt_present = count($checked_stud);
			$cnt_all =  count($allbatchStudent);
			$absent_stud = $this->Attendance_model->fetchAbsentStud($sub_code,$today,$slot,$emp_id,$sem_id,$division, $batch);
			///////////////////////////////////////////////////////////////////////////////////

			$today_date = date('d-m-Y', strtotime($today));		
		    $slot1 = $this->Attendance_model->fetch_slot_attendance($slot);
			$subject = $this->Attendance_model->fetch_subject_attendance($sub_code);
			$slot_time= $slot1[0]['from_time'].' - '.$slot1[0]['to_time'].' '.$slot1[0]['slot_am_pm'];
			$subject_type = $subject[0]['subject_component'];
			if($subject_type=='TH'){
				$subType ="Theory";
			}else{
				$subType ="Practical";
			}
			foreach ($absent_stud as $value) {
				$stud_name = $value['first_name'].' '.$value['last_name'];
				$pmob=$value['parent_mobile2'];
				$smob1=$value['mobile'].','.$value['parent_mobile2'];
				$smob='9821739610,8850633088';
				$sms = 'Dear Parent, 
Your ward '.$stud_name.' is absent from '.$slot_time.' '.$subType.' on '.$today_date.'
Thanks,
Sandip University.';
		//echo $sms;exit;
			$sms_message =urlencode($sms);
			$ch = curl_init();
			$sms=$sms_message;
			$query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$smob";
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_URL,'http://bulksms.omegatelesolutions.com/api/send_transactional_sms.php' . $query); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			//$res = trim(curl_exec($ch));
			curl_close($ch);
			$sms_data['mobile_nos'] =$smob;
			$sms_data['sms_type'] ='Attendance';
			$sms_data['attendance_id'] =$value['attendance_id'];
			$sms_data['message'] =$sms;
			$sms_data['entry_by'] =$this->session->userdata("name");
			$sms_data['entry_on'] =date('Y-m-d H:i:s');

			$DB1->insert('sms_log', $sms_data);

			}
			/////////////////////////////////////////////////////////////////////////////////////////////////
			$cnt_absent =  count($absent_stud);
			$allstd = array();
			$allstd['ss'] = $absent_stud;
			$allstd['allcnt'] = $cnt_all;
			$allstd['cnt_present'] = $cnt_present;
			$allstd['cnt_absent'] = $cnt_absent;
			/////////////////////////////////////////////////////////////////////////////////////////////////
			// for syllabus covered

			$syll_data['academic_year'] =$_POST['academic_year'];
			$syll_data['academic_session'] = $curr_ses;
			$syll_data['stream_id'] =$stream_id;
			$syll_data['semester'] =$sem_id;
			$syll_data['division'] =$division;
			$syll_data['batch'] =$batch;
			$syll_data['subject_id'] =$sub_code;
			$syll_data['faculty_id'] =$emp_id;
			$syll_data['attendance_date'] =$today;
			$syll_data['attendance_slot'] =$slot;

			$topic_covered =$_POST['top_checked'];
			$lplan_type =$_POST['lplan_type'];
			if($lplan_type=='LP'){
				$syll_data['is_from_lesson_plan'] ='Y';
				$topic_covered =$_POST['top_checked'];
				$topic =explode('.',$_POST['topic_no']);
				$syll_data['unit_no'] = $topic[0];
				$syll_data['topic_no'] =$topic[1];
				foreach ($topic_covered as $tvalue) {
					$syll_data['topic_covered'] =$tvalue;
					$DB1->insert('lecture_syllabus_covered', $syll_data);
				}
			}else{
				$syll_data['is_from_lesson_plan'] ='N';
				$syll_data['other_topic'] =$_POST['topic_contents'];
				$DB1->insert('lecture_syllabus_covered', $syll_data);
			}
			

			//$syll_data['entry_by'] =$this->session->userdata("name");
			//$syll_data['entry_on'] =date('Y-m-d H:i:s');
			//echo '<pre>';
			//print_r($_POST['top_checked']);exit;
			
			
				//echo $DB1->last_query();exit;
			//////////////////////////////////////////////////////////////////////////////////////////////////

			$str4 = json_encode($allstd);
			echo $str4;
		}else{
			echo "dupyes";
		}
		//redirect('Attendance/');
    } 
	//remove
	public function removeStudFromBatch($studId)
	{
        $this->load->view('header',$this->data); 
		$checked_stud = $_POST['chk_stud_batch'];
		foreach ($checked_stud as $stud) {
			$this->Batch_allocation_model->removeStudent($stud);
		}
		redirect('batch_allocation/');
	}	
	public function load_slot(){
		$emp_id = $this->session->userdata("name");
		$sbdetails = explode('-', $_POST['subject']);	
		//$this->data['sub_Code'] = $_POST['subject'];
		$stream_id = $sbdetails[4];
		$semesterId = $sbdetails[3];
		$curr_session= $this->Attendance_model->getCurrentSession();
		$academic_year = $curr_session[0]['academic_year'];
		$sub_details = $this->Attendance_model->load_slot($stream_id, $semesterId,$emp_id, $academic_year);
		$rowCount = count($sub_details);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Slot</option>';
                foreach ($sub_details as $sub) {
			
					echo '<option value="'.$sub['lect_slot_id'].'"' . $sel . '>'.$sub['from_time'].'-'.$sub['to_time'].' '.$sub['slot_am_pm'].'</option>';
				}
            } else {
                echo '<option value="">Slot not available</option>';
            }
	}
	
	// view attendance added on 04/09/17
	function view(){		
		$this->load->view('header',$this->data); 
		$this->load->model('Subject_model');
		$emp_id = $this->session->userdata("name");
		$curr_session= $this->Attendance_model->getCurrentSession();
		$this->data['sb']= $this->Attendance_model->getFacultySubjects($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year']);
		//echo "<pre>";
		//print_r($this->data['sb']);exit;
        $this->load->view($this->view_dir.'view_faculty_attendance',$this->data);
        $this->load->view('footer');	
	}
    //search date wise attendance
    public function search_date_wise_attendance($subCode='', $empID='')
    {
		if($empID ==''){
			$emp_id = $this->session->userdata("name");
		}else{
			$emp_id =$empID;
			$this->data['empId'] = $empID;
		}
		$this->load->model('Subject_model');
        $this->load->view('header',$this->data);  
		if($subCode !=''){
			$subject_id = explode('-', $subCode);
			$this->data['sub_Code'] = $subCode;			
		}else{
			$subject_id = explode('-', $_POST['subject']);	
			$this->data['sub_Code'] = $_POST['subject'];
		}		

		$this->data['subCode'] = $subject_id[0];
		$this->data['division'] = $subject_id[1];
		$this->data['divbatch'] = $subject_id[2];
		$this->data['semesterNo'] = $subject_id[3];
		$streamCode = $subject_id[4];
		$this->data['sub_batch'] = $_POST['subject'];
		$batch_code = $subject_id[1].'-'.$subject_id[2].'-'.$subject_id[3];		
		$subId = $subject_id[0];
		$this->data['subId'] = $subject_id[0]; // subjectid
		$this->data['subjectName']= $this->Attendance_model->getSubjectName($subId);
		$this->data['streamName']= $this->Attendance_model->getStreamName($streamCode);
		$curr_session= $this->Attendance_model->getCurrentSession();
		$this->data['sb']= $this->Attendance_model->getFacultySubjects($emp_id, $curr_session[0]['academic_session'],$curr_session[0]['academic_year']);
		$this->data['attCnt']= $this->Attendance_model->fetchFacAttDates($subId,$emp_id,$subject_id[2], $subject_id[1], $curr_session[0]['academic_year']);
		
		for($i=0;$i<count($this->data['attCnt']);$i++){
			$attendance_date = $this->data['attCnt'][$i]['attendance_date'];
			$slot = $this->data['attCnt'][$i]['slot'];
			$this->data['attCnt'][$i]['P_attCnt']= $this->Attendance_model->fetchFacAttPresent($attendance_date,$subId,$emp_id,$slot,$subject_id[1], $subject_id[2],$curr_session[0]['academic_year']);
			$this->data['attCnt'][$i]['A_attCnt']= $this->Attendance_model->fetchFacAttAbsent($attendance_date,$subId,$emp_id,$slot,$subject_id[1], $subject_id[2],$curr_session[0]['academic_year']);
		}

        $this->load->view($this->view_dir.'view_faculty_attendance',$this->data);
        $this->load->view('footer');
    } 
    //search date wise attendance
    public function search_date_wise_attendance_admin($subCode='', $empID='')
    {
		if($empID ==''){
			$emp_id = $this->session->userdata("name");
		}else{
			$emp_id =$empID;
			$this->data['empId'] = $empID;
		}
		$this->load->model('Subject_model');
        $this->load->view('header',$this->data);  
		if($subCode !=''){
			$subject_id = explode('-', $subCode);
			$this->data['sub_Code'] = $subCode;			
		}else{
			$subject_id = explode('-', $_POST['subject']);	
			$this->data['sub_Code'] = $_POST['subject'];
		}		

		$this->data['subCode'] = $subject_id[0];
		$this->data['division'] = $subject_id[1];
		$this->data['divbatch'] = $subject_id[2];
		$this->data['semesterNo'] = $subject_id[3];
		$streamCode = $subject_id[4];
		$this->data['sub_batch'] = $_POST['subject'];
		$batch_code = $subject_id[1].'-'.$subject_id[2].'-'.$subject_id[3];		
		$subId = $subject_id[0];
		$this->data['subId'] = $subject_id[0]; // subjectid
		$this->data['subjectName']= $this->Attendance_model->getSubjectName($subId);
		$this->data['streamName']= $this->Attendance_model->getStreamName($streamCode);
		$curr_session= $this->Attendance_model->getCurrentSession();
		$this->data['sb']= $this->Attendance_model->getFacultySubjects($emp_id, $curr_session[0]['academic_session'],$curr_session[0]['academic_year']);
		$this->data['attCnt']= $this->Attendance_model->fetchFacAttDates($subId,$emp_id,$subject_id[2], $subject_id[1], $curr_session[0]['academic_year']);
		
		for($i=0;$i<count($this->data['attCnt']);$i++){
			$attendance_date = $this->data['attCnt'][$i]['attendance_date'];
			$slot = $this->data['attCnt'][$i]['slot'];
			$this->data['attCnt'][$i]['P_attCnt']= $this->Attendance_model->fetchFacAttPresent($attendance_date,$subId,$emp_id,$slot,$subject_id[1], $subject_id[2],$curr_session[0]['academic_year']);
			$this->data['attCnt'][$i]['A_attCnt']= $this->Attendance_model->fetchFacAttAbsent($attendance_date,$subId,$emp_id,$slot,$subject_id[1], $subject_id[2],$curr_session[0]['academic_year']);
		}

        $this->load->view($this->view_dir.'view_subjectwise_att_to_admin',$this->data);
        $this->load->view('footer');
    } 	
	//fetch date/slotwise attendance
    public function fetchDateSlotwiseAttDetails()
    {    
		if(!empty($_POST['empId'])){
			$emp_id = $_POST['empId'];
		}else{
			$emp_id = $this->session->userdata("name");	
		}	
		$curr_session= $this->Attendance_model->getCurrentSession();
		$att_date = $_POST['att_date'];
		$sub_id = $_POST['sub_id'];
		$slot = $_POST['slot'];
		$sem = $_POST['sem'];
		
		$stud_att = $this->Attendance_model->fetchDateSlotwiseAttDetails($att_date,$sub_id,$slot,$emp_id,$sem,$curr_session[0]['academic_year']);
		//echo count($CntDup);
		if(!empty($stud_att)){			
			$allstd = array();
			$allstd['ss'] = $stud_att;
			$str4 = json_encode($allstd);
			echo $str4;
		}else{
			echo "dupyes";
		}
    }
	// student attendance added on 06/09/17
	function studentview(){
		//error_reporting(E_ALL); ini_set('display_errors', '1');		
		$stud_enroll_no = $this->session->userdata("name");
		$this->load->view('header',$this->data); 
		$this->load->model('Subject_model');
		// fetch student details like stream,semester,div,batch
		$stud_det= $this->Attendance_model->fetch_stud_details($stud_enroll_no);

		$division = $stud_det[0]['division'];
			
		$this->data['course_short_name']= $stud_det[0]['course_short_name'];
		$this->data['stream_name']= $stud_det[0]['stream_short_name'];
		$this->data['semester']= $stud_det[0]['current_semester'];
		$this->data['course_id']= $stud_det[0]['course_id'];
		$current_semester = $stud_det[0]['current_semester'];
		if($stud_det[0]['batch'] !=0){
		$this->data['batch']= $stud_det[0]['division'].''.$stud_det[0]['batch'];
		}elseif($division !=''){
			$this->data['batch']= $division;	
		}else{
			$this->data['batch']= 'A';	
		}
		// load subjects of students
		$this->data['sb']= $this->Attendance_model->fetch_student_subjects($stud_enroll_no,$current_semester);
		// load unique dates
		$this->data['attCnt']= $this->Attendance_model->fetchStudAttDates($stud_enroll_no,$current_semester);		
		for($i=0;$i<count($this->data['attCnt']);$i++){
			
			$attendance_date = $this->data['attCnt'][$i]['attendance_date'];
			$studId = $this->data['attCnt'][$i]['stud_id'];
			for($j=0;$j<count($this->data['sb']);$j++){				
				$subId = $this->data['sb'][$j]['sub_id'];
				$this->data['attCnt'][$i]['subject'][$j]= $subId;
				$this->data['attCnt'][$i]['P_attCnt'][$j]= $this->Attendance_model->fetchStudAttPresent($attendance_date,$subId,$studId);
				$this->data['attCnt'][$i]['P_attCnt'][$j]['total']= $this->Attendance_model->fetchStudAttTotLecture($attendance_date,$subId,$studId);
				$this->data['attCnt'][$i]['P_attCnt'][$j]['absent']= $this->Attendance_model->fetchStudAttAbsent($attendance_date,$subId,$studId);
			}
		}
		//echo "<pre>";
		//print_r($this->data['attCnt']);exit;
        $this->load->view($this->view_dir.'view_student_attendance',$this->data);
        $this->load->view('footer');	
	}
	// absent student sms to parents
	function sendAbsentSms()
	{
		$emp_id = $this->session->userdata("name");

		$sub_id = $_POST['sub_code'];
		$slot_id = $_POST['slot'];
		$today_date = date('d-m-Y', strtotime($_POST['today_date']));		
	    $slot = $this->Attendance_model->fetch_slot_attendance($slot_id);
		$subject = $this->Attendance_model->fetch_subject_attendance($sub_id);
		$slot_time= $slot[0]['from_time'].' - '.$slot[0]['to_time'].' '.$slot[0]['slot_am_pm'];
		$subject_type = $subject[0]['subject_component'];
		if($subject_type=='TH'){
			$subType ="Theory";
		}else{
			$subType ="Practical";
		}
		$absentStud = $_POST['absentStud'];
		//$absentStud = "9821739610~SHUBHAM MORE,9545453097~POOJA SAWANT";
		$pMobile=explode(",",$absentStud); 
		foreach($pMobile as $pd){
			$pm=explode("~",$pd);
			$pmob = $pm[0];		
			//$pmob = '8850633088';			
			//$pmob = '9821739610,9545453097,9322226111,9769752714,9545453222';//9769752714,9545453222,9322226111
			$stud_name = $pm[1];
			$sms = 'Dear Parent, 
Your ward '.$stud_name.' is absent from '.$slot_time.' '.$subType.' on '.$today_date.'
Thanks,
Sandip University.';
		//echo $sms;exit;
			$sms_message =urlencode($sms);
			$ch = curl_init();
			$sms=$sms_message;
			$query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$pmob";
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_URL,'http://bulksms.omegatelesolutions.com/api/send_transactional_sms.php' . $query); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			$res = trim(curl_exec($ch));
			curl_close($ch);

			
		}
		echo "success";
	}
// added on 210917
	// view attendance report for faculty
	public function report()
    {
		//error_reporting(E_ALL);
		$emp_id = $this->session->userdata("name");
		if(!empty($_POST['from_date'])){
			$from_date = $_POST['from_date'];
			$to_date = $_POST['to_date'];
		}else{
			$from_date = "";
			$to_date = "";
		}
		$curr_session= $this->Attendance_model->getCurrentSession();
		$academic_session = $curr_session[0]['academic_session'];
		$academic_year = $curr_session[0]['academic_year'];
		
		$this->data['subject']= $this->Attendance_model->getFaqSubjects($emp_id, $academic_session, $academic_year);
		//echo "<pre>";
		//print_r($this->data['subject']);exit;
		for($j=0;$j<count($this->data['subject']);$j++){			
			$subId = $this->data['subject'][$j]['subject_code'];
			$division = $this->data['subject'][$j]['division'];
			$batch_no = $this->data['subject'][$j]['batch_no'];
			$this->data['subject'][$j]['cntLect']= $this->Attendance_model->getNoOfLecture($emp_id, $subId, $from_date, $to_date, $division,$batch_no, $academic_session, $academic_year);
			
			$this->data['subject'][$j]['AvgLectPer']= $this->Attendance_model->avgPerOfSubject($emp_id, $subId, $from_date, $to_date,$division,$batch_no, $academic_session, $academic_year);
		}
		//exit;
		$this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'report_attendance',$this->data);
        $this->load->view('footer');

	}
	// general Attendance report
	public function general_attendance_report()
    {
		$this->load->view('header',$this->data); 
		$this->load->model('Subject_model');
		$emp_id = $this->session->userdata("name");
		$this->data['classRoom']= $this->Attendance_model->getclassRoom();
        $this->load->view($this->view_dir.'report_attendance_general',$this->data);
        $this->load->view('footer');

	}
	//load sem for report
	function load_sem_report() {
		$emp_id = $this->session->userdata("name");
        if (isset($_POST["room_no"]) && !empty($_POST["room_no"])) {
            //Get all city data
            $stream = $this->Attendance_model->getSemReport($_POST["room_no"]);
           // print_r($stream);
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Semester</option>';
                foreach ($stream as $value) {
					
                    echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
                }
            } else {
                echo '<option value="">Semester not available</option>';
            }
        }
    }
	// load division for report
	public function load_division_report(){
		$emp_id = $this->session->userdata("name");
		$room_no = $_POST['room_no'];
		$semesterId = $_POST['semesterId'];
		$sub_details = $this->Attendance_model->load_division_report($room_no, $semesterId);
		$rowCount = count($sub_details);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Division</option>';
                foreach ($sub_details as $sub) {
					
					echo '<option value="'.$sub['division'].'">'.$sub['division'].'</option>';
				}
            } else {
                echo '<option value="">Division not available</option>';
            }
	}
	// general attendance report
	public function report_general()
    {
		//error_reporting(E_ALL);
		$emp_id = $this->session->userdata("name");
		$this->load->model('Subject_model'); 
		$this->load->model('Timetable_model');
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id='');	
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();
		//$this->data['classRoom']= $this->Attendance_model->getclassRoom();
		if(!empty($_POST['stream_id'])){
			$streamID = $_POST['stream_id'];
			$semester = $_POST['semester'];
			$division = $_POST['division'];

			$this->data['streamID'] = $_POST['stream_id'];
			$this->data['division'] = $division;
			$this->data['semesterNo'] = $_POST['semester'];
			$this->data['courseId'] = $_POST['course_id'];
		}else{
		}
		$this->data['academicyear'] =$_POST['academic_year'];
		
		if(!empty($_POST['from_date'])){
			$from_date = $_POST['from_date'];
			$to_date = $_POST['to_date'];
		}else{
			$from_date = "";
			$to_date = "";
		}
		$streamName= $this->Attendance_model->getStreamCode($streamID);
		$create_batch_name = $streamName[0]['stream_code'].'-'.$division;
		$this->data['subject']= $this->Attendance_model->load_subject_report($streamID, $semester, $division, $_POST['academic_year']);
		//echo "<pre>";
		//print_r($this->data['subject']);exit;
		for($j=0;$j<count($this->data['subject']);$j++){
			
			$subId = $this->data['subject'][$j]['subject_code'];
			$faculty_code =  $this->data['subject'][$j]['emp_id'];
			$batch = $this->data['subject'][$j]['batch_no'];
			$this->data['subject'][$j]['cntLect']= $this->Attendance_model->getNoOfLectureReport($subId, $from_date, $to_date, $division, $batch,$streamID,$semester,$faculty_code,$_POST['academic_year']);			
			$this->data['subject'][$j]['AvgLectPer']= $this->Attendance_model->avgPerOfSubjectReport($subId, $from_date, $to_date, $division, $batch,$streamID,$semester,$faculty_code,$_POST['academic_year']);
		}
		//exit;
		$this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'report_attendance_general',$this->data);
        $this->load->view('footer');

	}
	//delete attendance of faculty
	public function DeleteAttendanceEntry($attendance_date, $slot, $sub_details)
	{
		$emp_id = $this->session->userdata("name");
		$subdetails = explode('-', $sub_details);
		$sub_id = $subdetails[0];
		$th_batch = $subdetails[3];
		$division = $subdetails[1];
		$batch = $subdetails[2];
		$sem_id = $subdetails[3];
		$curr_session= $this->Attendance_model->getCurrentSession();
		$academic_year = $curr_session[0]['academic_year'];
		
        $this->load->view('header',$this->data); 
		if($this->Attendance_model->DeleteAttendanceEntry($attendance_date, $slot,$sem_id,$emp_id,$division,$batch,$academic_year))
		{
			redirect('attendance/search_date_wise_attendance/'.$sub_details);
		}
	}	
	///////////////////////////
	// student attendance report added on 02/10/17
	function studentAttendenceReport($subId=''){		
		$emp_id = $this->session->userdata("name");
		if(!empty($_POST['from_date'])){
			$from_date = $_POST['from_date'];
			$todate = $_POST['to_date'];					
			$this->data['attend_date']= $_POST['from_date'];			
		}else{
			$from_date = "";
			$this->data['attend_date']= $from_date;
			$to_date = "";
		}
		
		if(!empty($_POST['sub_id'])){
			$subdetails = explode('-', $_POST['sub_id']);
			$sub_id = $subdetails[0];
			$this->data['subId']=$_POST['sub_id'];
			$this->data['subject_id']= $subdetails[0];
			$division = $subdetails[1];
			$batch = $subdetails[2];
			$semester = $subdetails[3];
			$stream_id = $subdetails[4];
		}else{
			$subdetails = explode('-', $subId);
			$sub_id = $subdetails[0];
			$this->data['subId']=$subId;
			$this->data['subject_id']= $subdetails[0];
			$division = $subdetails[1];
			$batch = $subdetails[2];
			$semester = $subdetails[3];
			$stream_id = $subdetails[4];
		}
		//echo $sub_id;
		$curr_session= $this->Attendance_model->getCurrentSession();
		$academic_session = $curr_session[0]['academic_session'];
		$academic_year = $curr_session[0]['academic_year'];
		$this->data['subjects']= $this->Attendance_model->getFacultySubjects($emp_id, $academic_session, $academic_year);
		if(!empty($_POST['sub_id']) || $subId !=''){			
			$this->data['stud_list']= $this->Attendance_model->fetchFaqSubjectsAttendance($emp_id, $sub_id, $division, $batch, $stream_id, $semester, $academic_session, $academic_year);
			$this->data['attDates']= $this->Attendance_model->fetchFaqAttendanceDates($emp_id, $sub_id,$division, $batch, $stream_id,$from_date, $todate, $academic_session, $academic_year);
		}		
		//echo "<pre>";
		//print_r($this->data['stud_list']);exit;
		$this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'student_subjectwise_attreport',$this->data);
        $this->load->view('footer');	
	}
	//added on 04/10/17
    public function genericAttendanceReport()
    {
		$this->load->model('Subject_model');
		$this->load->model('Attendance_model');
		$this->load->model('Batchallocation_model');
		$this->load->model('Timetable_model');
        $this->load->view('header',$this->data);
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();		
        $course_id = $_POST['course_id'];
		$stream_id = $_POST['stream_id'];
		$semester = $_POST['semester'];
		$division = $_POST['division'];
		$subject_id = explode('-', $_POST['subject']);
		
		$this->data['courseId'] = $_POST['course_id'];
		$this->data['streamId'] = $_POST['stream_id'];
		$this->data['semesterNo'] = $_POST['semester'];
		$this->data['division'] = $_POST['division'];
		$this->data['academicyear'] =$_POST['academic_year'];		
		
		$strm_code = $this->Batchallocation_model->getStreamCode($stream_id);
		$stream_code = $strm_code[0]['stream_code'];
		$this->data['streamName'] = $strm_code[0]['stream_name'];
		//$batch_code = $subject_id[1].'-'.$subject_id[2];
		$batch_code = $stream_code.'-'.$division;
		
		$this->data['subdetails']= $this->Attendance_model->get_subject_details($sub_id='',$stream_id,$semester,$division,$_POST['academic_year']);
		if(!empty($stream_id) && !empty($semester)){
			$this->data['batchstudents']= $this->Attendance_model->getStudBatchAllotList($stream_id, $semester,$division,$_POST['academic_year']);			
		}
		
		$this->data['course_details']= $this->Subject_model->getCollegeCourse($college_id);		    

        $this->load->view($this->view_dir.'genericAttendanceReport',$this->data);
        $this->load->view('footer');
    } 
    // load stream for consolidated reports
    function load_streams() {
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all city data
            $stream = $this->Attendance_model->get_attendance_streams($_POST["course_id"],$_POST['academic_year']);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Stream</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['stream_id'] . '">' . $value['stream_short_name'] . '</option>';
                }
            } else {
                echo '<option value="">stream not available</option>';
            }
        }
    } 
    // get semester from attendance table session wise
    function getSemfromAttendance() {

        if (isset($_POST["stream_id"]) && !empty($_POST["stream_id"])) {
            //Get all city data
            $stream = $this->Attendance_model->getSemfromAttendance($_POST["stream_id"], $_POST['academic_year']);
           // print_r($stream);
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Semester</option>';
                foreach ($stream as $value) {
					
                    echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
                }
            } else {
                echo '<option value="">Semester not available</option>';
            }
        }
    }
   	function load_lecture_cources(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["academic_year"]) && !empty($_POST["academic_year"])){
			//Get all streams
			$stream = $this->Attendance_model->load_lecture_cources($_POST["academic_year"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
			}else{
				echo '<option value="">Courses not available</option>';
			}
		}
	} 
	public function load_division_by_acdmicyear(){
		$emp_id = $this->session->userdata("name");
		$room_no = $_POST['room_no'];
		$semesterId = $_POST['semesterId'];
		$sub_details = $this->Attendance_model->load_division_by_acdmicyear($room_no, $semesterId, $_POST["academic_year"]);
		$rowCount = count($sub_details);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Division</option>';
                foreach ($sub_details as $sub) {
					
					echo '<option value="'.$sub['division'].'">'.$sub['division'].'</option>';
				}
            } else {
                echo '<option value="">Division not available</option>';
            }
	}
	 	//  Attendance board
	public function dashboard()
    {
		//error_reporting(E_ALL);
		$this->load->view('header',$this->data); 
		$this->load->model('Timetable_model');
		$emp_id = $this->session->userdata("name");
		$this->data['academic_year']= $this->Timetable_model->fetch_Curracademic_session(); 
		$this->data['courseId']=$_POST['course_id'];
		$this->data['division']=$_POST['division'];
		$this->data['semesterNo']=$_POST['semester'];
		$this->data['streamId']=$_POST['stream_id'];
		$this->data['academicyear']=$_POST['academic_year'];
		
		$todaysdate =$_POST['att_date'];
		//$todaysdate ='2018-08-23';
		$day = date('l', strtotime($todaysdate)); 
		$courseId = $_POST['course_id']; 
		$stream_id = $_POST['stream_id'];
		$sem =$_POST['semester'];
		$division =$_POST['division'];
		$academic_year =$_POST['academic_year'];
		$this->data['todaysdate']=$todaysdate;
		$this->data['details']= $this->Attendance_model->fetch_daywise_attendance_details($todaysdate,$day, $stream_id,$sem,$division, $academic_year);
		//echo "<pre>";
//print_r($this->data['details']);		
        $this->load->view('attendance_board',$this->data);
        $this->load->view('footer');

	}  
    // load subtopics
	function load_subtopics1() {
		$this->load->model('Attendance_model');
        $this->data['subtpc'] = $this->Attendance_model->load_subtopics($_POST);
		echo $this->load->view('Lessonplan/subtopic_ajax_mark_attendance',$this->data);
    }
    public function load_subtopics(){
        $this->load->model('Attendance_model');
        $subtpc = $this->Attendance_model->load_subtopics($_POST);
        if (!empty($subtpc)) {
        	$i=1;
                foreach ($subtpc as $val) {
					$arr_val = explode('~~~',$val['covered_topics']);
					//echo '<pre>';
					//print_r($arr_val);exit;
					foreach($arr_val as $value){
                    $topic_value = $val['unit_no'].'_'.$val['topic_no'];
                    $topic_val = $val['unit_no'].'~'.$val['topic_no'].'~'.$value;
	         echo '<li>
	                    <input type="checkbox" name="empsid[]" id="'.$topic_value.'"  value="'.$topic_val.'" /> ' . $val['unit_no'].'.'.$val['topic_no'].'.'.$value. ' </li>';
	       
			unset($value);
			$i++;
					}
					
					unset($arr_val);
                }
				//echo '<option value="Other">Other</option>';
            } else {
                echo '<option value="">subtopic not available</option>';
            }
	}
}
?>