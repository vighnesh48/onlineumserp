<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 // error_reporting(E_ALL);
class Attendance extends CI_Controller 
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
        $this->load->library(['form_validation','session','encryption']);
        $this->load->helper(['obe','url','form','encryption']);


        
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
       
        
        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
		
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
		$emp_details = $this->Attendance_model->fetchempdetails($emp_id);
//print_r($_SESSION);
//exit;
		//echo  $emp_details[0]['emp_school'];
		$this->session->set_userdata('emp_school_id', $emp_details[0]['emp_school']);
		$this->data['sb']= $this->Attendance_model->getFacultySubjects_for_markattendance($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year']);

		$this->data['academic_year'] = $curr_session[0]['academic_year'];
		//$this->data['classRoom']= $this->Attendance_model->getclassRoom($emp_id,$curr_session[0]['academic_session']);
		$this->data['slots']= $this->Attendance_model->getSlots();
		if($emp_id=='211636'){
        $this->load->view($this->view_dir.'view_attendance_obe',$this->data);
        //$this->load->view($this->view_dir.'view_attendance_img',$this->data);
		}else{
        $this->load->view($this->view_dir.'view_attendance_obe',$this->data);
		}
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
		//echo 'Under maintenance please wait for 10 minutes';exit;
		$emp_id = $this->session->userdata("name");
		$this->load->model('Subject_model');
        $this->load->view('header',$this->data);                    
		$subject_id = explode('-', $_POST['subject']);
		$this->data['slot_no'] = $_POST['slot_no'];
		//echo  $subject_id[2];exit;
		$this->data['subbdetails'] = $_POST['subject'];
		$this->data['subCode'] = $subject_id[0];
		$this->data['division'] = $subject_id[1];
		$this->data['batch'] = $subject_id[2];
		//$this->data['sub_batch'] = $_POST['subject'];
		$this->data['classId'] = $subject_id[4];
		$this->data['semesterNo'] = $subject_id[3];
		$this->data['sub_details'] = $_POST['subject'];
		$td=$_POST['today_date'];
		
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
			$this->data['studbatch_allot_list']= $this->Attendance_model->get_studbatch_allot_list($subject_id[0],$streamId,$semester,$division, $batch,$acd_yr,$td);			
		}
		if($emp_id=='211636'){
        $this->load->view($this->view_dir.'view_attendance_obe',$this->data);
        //$this->load->view($this->view_dir.'view_attendance_img',$this->data);
		}else{
        $this->load->view($this->view_dir.'view_attendance_obe',$this->data);
		}
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
		$subject_id = explode('-', $_POST['subject']);
		$subject_type = $subject_id[5];
		
		//echo "<pre>";
		//print_r($_POST);exit;
		$CntDup = $this->Attendance_model->check_dup_attendance($today, $slot, $emp_id, $sem_id, $division, $batch,$sub_code,$stream_id);
		//echo count($CntDup);
		if(count($CntDup) == 0){
			$allbatchStudent = $this->Attendance_model->get_studbatch_allot_list($sub_code,$stream_id, $sem_id,$division, $batch,$academic_year,$today);
			
			
			
			
			
			
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
			
			
			//echo "<pre>";
			//print_r($stud_app_id);
			//exit;

			foreach ($allbatchStudent as $stud) {
				
				$data['student_id'] = $stud['stud_id'];
				$data['semester'] = $sem_id;
				$data['stream_id'] = $stream_id;
				$data['division'] = $_POST['division']; // newly added
				$data['batch'] = $_POST['batch']; // newly added
				$data['slot'] = $slot;
				$data['subject_id'] = $sub_code;
				$data['subtype'] = $subject_type;
				$data['academic_year'] = $_POST['academic_year'];
				$data['academic_session'] = $curr_ses;
				$data['attendance_date'] = $today;
				$data['inserted_datetime'] = date('Y-m-d H:i:s');
				$data['faculty_code'] = $this->session->userdata("name");
				$data['syllabus_covered_remark'] = $_POST['topic_contents'];
				
				if (in_array($stud['stud_id'], $stud_app_id)){
					$data['is_present'] = 'Y';
					//echo $stud['stud_id'];
					//echo "<br>";
				}else{
					$data['is_present'] = 'N';
				}
			
				$this->Attendance_model->markAttendance($data);
			}
			//exit;
			 $cnt_present = count($checked_stud);
			 $cnt_all =  count($allbatchStudent);
			
			
			
			$absent_stud = $this->Attendance_model->fetchAbsentStud($sub_code,$today,$slot,$emp_id,$sem_id,$division, $batch);
		
			
			///////////////////////////////////////////////////////////////////////////////////
			//SMS for absent students starts
			$tdate=date('Y-m-d');			
			if($tdate==$today){ //not allowed sms for backdated attendance 
				
			$today_date = date('d-m-Y', strtotime($today));		
		    $slot1 = $this->Attendance_model->fetch_slot_attendance($slot);
			$subject = $this->Attendance_model->fetch_subject_attendance($sub_code);
			$slot_time= $slot1[0]['from_time'].' - '.$slot1[0]['to_time'].' '.$slot1[0]['slot_am_pm'];
			$subject_type = $subject[0]['subject_component'];
			$subjectCode = $subject[0]['subject_code'];
			if($subject_type=='TH'){
				$subType ="Theory";
			}else{
				$subType ="Practical";
			}
			
			foreach ($absent_stud as $value) {
				$stud_name = $value['first_name'].' '.$value['last_name'];
				$pmob=$value['parent_mobile2'];
				$smob=$value['mobile'];
				
				if($pmob !=''){
					$smob .=','.$pmob;
				}
				
				if($emp_id !='1100521231'){
					$smob=$smob;
				}else{
					$smob ='8850633088';
				}
				//$smob ='8850633088';
				$sms = "Dear Parent, 
Your ward $stud_name is absent from $slot_time $subjectCode $subType on $today_date
Thanks,
Sandip University.";
		//echo $sms;exit;
			$sms_message =urlencode($sms);				
			$smsGatewayUrl="http://login.businesslead.co.in/api/mt/SendSMS?user=SANDIPFOUNDATION&password=ABC@789&senderid=SANDIP&channel=TRANS&DCS=0&flashsms=0&number=$smob&text=$sms_message&route=22";
	//&peid=1701159161247599930
			$url = $smsGatewayUrl;

			$ch = curl_init();                       // initialize CURL
			curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$content = curl_exec($ch);
			curl_close($ch); 
			$response = json_decode($content, true);  
						
			$sms_data['mobile_nos'] =$smob;
			$sms_data['sms_type'] ='Attendance';
			$sms_data['attendance_id'] =$value['attendance_id'];
			$sms_data['message'] =($sms);
			$sms_data['entry_by'] =$this->session->userdata("name");
			$sms_data['entry_on'] =date('Y-m-d H:i:s');
			//$sms_data['gateway_responce'] = $response;
			$DB1->insert('sms_log', $sms_data);
			//echo  $DB1->last_query();
			}
		}
			/////////////////////////////////////////////////////////////////////////////////////////////////
			$cnt_absent =  count($absent_stud);
			$allstd = array();
			$allstd['ss'] = $absent_stud;
			$allstd['allcnt'] = $cnt_all;
			$allstd['cnt_present'] = $cnt_present;
			$allstd['cnt_absent'] = $cnt_absent;
			

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
		$subject_id = $sbdetails[0];
		$division = $sbdetails[1];
		$stream_id = $sbdetails[4];
		$semesterId = $sbdetails[3];
		$batch = $sbdetails[2];
		$curr_session= $this->Attendance_model->getCurrentSession();
		$academic_year = $curr_session[0]['academic_year'];
		$sub_details = $this->Attendance_model->load_slot($stream_id, $semesterId,$emp_id, $academic_year,$subject_id,$division,$batch);
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
		$this->data['attCnt']= $this->Attendance_model->fetchFacAttDates($subId,$emp_id,$subject_id[2], $subject_id[1], $curr_session[0]['academic_year'],$subject_id[3],$subject_id[4]);
		
		for($i=0;$i<count($this->data['attCnt']);$i++){
			$attendance_date = $this->data['attCnt'][$i]['attendance_date'];
			$slot = $this->data['attCnt'][$i]['slot'];
			$this->data['attCnt'][$i]['P_attCnt']= $this->Attendance_model->fetchFacAttPresent($attendance_date,$subId,$emp_id,$slot,$subject_id[1], $subject_id[2],$curr_session[0]['academic_year'],$subject_id[3],$subject_id[4]);
			$this->data['attCnt'][$i]['A_attCnt']= $this->Attendance_model->fetchFacAttAbsent($attendance_date,$subId,$emp_id,$slot,$subject_id[1], $subject_id[2],$curr_session[0]['academic_year'],$subject_id[3],$subject_id[4]);
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
		$this->data['attCnt']= $this->Attendance_model->fetchFacAttDates($subId,$emp_id,$subject_id[2], $subject_id[1], $curr_session[0]['academic_year'],$subject_id[3],$subject_id[4]);
		
		for($i=0;$i<count($this->data['attCnt']);$i++){
			$attendance_date = $this->data['attCnt'][$i]['attendance_date'];
			$slot = $this->data['attCnt'][$i]['slot'];
			$this->data['attCnt'][$i]['P_attCnt']= $this->Attendance_model->fetchFacAttPresent($attendance_date,$subId,$emp_id,$slot,$subject_id[1], $subject_id[2],$curr_session[0]['academic_year'],$subject_id[3],$subject_id[4]);
			$this->data['attCnt'][$i]['A_attCnt']= $this->Attendance_model->fetchFacAttAbsent($attendance_date,$subId,$emp_id,$slot,$subject_id[1], $subject_id[2],$curr_session[0]['academic_year'],$subject_id[3],$subject_id[4]);
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
		$div = $_POST['div']; 
		$batch = $_POST['batch'];
		
		$stud_att = $this->Attendance_model->fetchDateSlotwiseAttDetails($att_date,$sub_id,$slot,$emp_id,$sem,$curr_session[0]['academic_year'],$div,$batch);
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
			$semester = $this->data['subject'][$j]['semester'];
			$stream = $this->data['subject'][$j]['stream_id'];
			$batch_no = $this->data['subject'][$j]['batch_no'];
			$this->data['subject'][$j]['cntLect']= $this->Attendance_model->getNoOfLecture($emp_id, $subId, $from_date, $to_date, $division,$batch_no, $academic_session, $academic_year,$stream,$semester);
			
			$this->data['subject'][$j]['AvgLectPer']= $this->Attendance_model->avgPerOfSubject($emp_id, $subId, $from_date, $to_date,$division,$batch_no, $academic_session, $academic_year,$stream,$semester);
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
		//error_reporting(E_ALL);	
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
    public function genericAttendanceReport_old()
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
				//if()
					
				/* if($_POST["course_id"]=='2'){
					echo '<option value="9">B.Tech First Year</option>';
				} */
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
				
				if($_POST["stream_id"]=='9' || $_POST["stream_id"]=='234' || $_POST["stream_id"]=='235' || $_POST["stream_id"]=='236' || $_POST["stream_id"]=='237' || $_POST["stream_id"]=='239'){ // || $_POST["stream_id"]=='103'
					echo '<option value="">Select Semester</option>';
					echo '<option value="1">1</option>';
					echo '<option value="2">2</option>';
				}
				else{
                foreach ($stream as $value) {
					
                    echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
                }
				}
            } else{               
				
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
	/*function load_subtopics() {
		$this->load->model('Attendance_model');
        $this->data['subtpc'] = $this->Attendance_model->load_subtopics($_POST);
		echo $this->load->view('Lessonplan/subtopic_ajax_mark_attendance',$this->data);
    }*/
	///////////////////////////////////////////////////////////////////////////////////////////////////
	public function load_subtopics(){
        $this->load->model('Attendance_model');
        $subtpc = $this->Attendance_model->load_subtopics($_POST);
        if (!empty($subtpc)) {
        	$i=1;
                foreach ($subtpc as $val) {
                	
                	 $topic_value = $val['unit_no'].'_'.$val['topic_no'].'_'.$val['syllabus_id'];
                	  $topic_contents = $val['topic_contents'];
					//$arr_val = explode('~~~',$val['covered_topics']);
					//echo '<pre>';
					//print_r($arr_val);exit;
					/*foreach($arr_val as $value){
                    $topic_value = $val['unit_no'].'_'.$val['topic_no'];
                    $topic_val = $val['unit_no'].'~'.$val['topic_no'].'~'.$value;
	         echo '<li>
	                    <input type="checkbox" name="empsid[]" id="'.$topic_value.'"  value="'.$topic_val.'" /> ' . $val['unit_no'].'.'.$val['topic_no'].'.'.$value. ' </li>';
	       
			unset($value);
			$i++;
					}*/
					 echo '<li>
	                    <input type="checkbox" name="empsid[]" id="'.$topic_value.'"  value="'.$topic_value.'" /> ' . $val['unit_no'].'.'.$val['topic_no'].'.'.$topic_contents. ' </li>';


					//unset($arr_val);
                }
				//echo '<option value="Other">Other</option>';
            } else {
                echo '<option value="">subtopic not available</option>';
            }
	}
	public function attendance_test()
    {
		$this->load->view('header',$this->data); 
		$this->load->model('Subject_model');
		$emp_id = $this->session->userdata("name");
		$curr_session= $this->Attendance_model->getCurrentSession();
		
		$this->data['sb']= $this->Attendance_model->getFacultySubjects_for_markattendance($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year']);
		
		$this->data['academic_year'] = $curr_session[0]['academic_year'];
		//$this->data['classRoom']= $this->Attendance_model->getclassRoom($emp_id,$curr_session[0]['academic_session']);
		$this->data['slots']= $this->Attendance_model->getSlots();
        $this->load->view($this->view_dir.'view_attendance_testing',$this->data);
        $this->load->view('footer');

	}
	
	public function markAttendance_testing()
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
			
				$this->Attendance_model->markAttendance_testing($data);
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

			//$DB1->insert('sms_log', $sms_data);

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

			//$topic_covered =explode('_',$_POST['top_checked']);
			$lplan_type =$_POST['lplan_type'];
			if($lplan_type=='LP'){
				$syll_data['is_from_lesson_plan'] ='Y';
				//$topic_covered =$_POST['top_checked'];
				$topic =explode('.',$_POST['topic_no']);
				$syll_data['unit_no'] = $topic[0];
				$syll_data['remark'] =$_POST['remark'];
				$syll_data['topic_no'] =$topic[1];
				foreach ($topic_covered as $tvalue) {
					$tvalue2=explode('_',$tvalue);
					$syll_data['topic_covered'] =$tvalue2[2];
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
	
    public function search_subAndStudent_testing()
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
		$this->data['topics']=$this->Attendance_model->fetch_subject_lplan($subject_id[0],$acd_yr,$curr_session[0]['academic_session'],$division,$semester,$batch);
		
		if(!empty($semester) && !empty($semester)){
			$this->data['studbatch_allot_list']= $this->Attendance_model->get_studbatch_allot_list($subject_id[0],$streamId,$semester,$division, $batch,$acd_yr);			
		}
		
        $this->load->view($this->view_dir.'view_attendance_testing',$this->data);
        $this->load->view('footer');
    } 	
	
public function markAttendance_img()
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
		$subject_id = explode('-', $_POST['subject']);
		$subject_type = $subject_id[5];
		
		$this->load->library('upload');

        // Initialize an array to store uploaded file data
        $uploaded_files = [];

        // Configure upload settings for staffuserfile
        if (!empty($_FILES['staffuserfile']['name'])) {
            $config['upload_path'] = 'uploads/staff_images/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2048; // 2MB max size
            $config['file_name'] = 'staff_' . time(); // Unique filename
			//$data['staff_file_name']=$config['file_name'];
            $this->upload->initialize($config);

            if ($this->upload->do_upload('staffuserfile')) {
                $uploaded_files['staffuserfile'] = $this->upload->data();
				$data['staff_file_name']=$uploaded_files['staffuserfile']['file_name'];
            } else {
                $data['error'] = $this->upload->display_errors();
            }
        }

        // Configure upload settings for classuserfile
        if (!empty($_FILES['classuserfile']['name'])) {
            $config['upload_path'] = 'uploads/staff_images/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2048; // 2MB max size
            $config['file_name'] = 'class_' . time(); // Unique filename
			//$data['class_file_name']=$config['file_name'];
            $this->upload->initialize($config);

            if ($this->upload->do_upload('classuserfile')) {
                $uploaded_files['classuserfile'] = $this->upload->data();
				$data['class_file_name']=$uploaded_files['classuserfile']['file_name'];
            } else {
                $data['error'] = $this->upload->display_errors();
            }
        }
		//echo "<pre>";
		//print_r($_POST);exit;
		$CntDup = $this->Attendance_model->check_dup_attendance($today, $slot, $emp_id, $sem_id, $division, $batch,$sub_code,$stream_id);
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
				$data['subtype'] = $subject_type;
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
			
				$this->Attendance_model->markAttendance_img($data);
			}
			
			$cnt_present = count($checked_stud);
			$cnt_all =  count($allbatchStudent);
			$absent_stud = $this->Attendance_model->fetchAbsentStud($sub_code,$today,$slot,$emp_id,$sem_id,$division, $batch);
			///////////////////////////////////////////////////////////////////////////////////
			//SMS for absent students starts
			$tdate=date('Y-m-d');			
			if($tdate==$today){ //not allowed sms for backdated attendance 
				
			$today_date = date('d-m-Y', strtotime($today));		
		    $slot1 = $this->Attendance_model->fetch_slot_attendance($slot);
			$subject = $this->Attendance_model->fetch_subject_attendance($sub_code);
			$slot_time= $slot1[0]['from_time'].' - '.$slot1[0]['to_time'].' '.$slot1[0]['slot_am_pm'];
			$subject_type = $subject[0]['subject_component'];
			$subjectCode = $subject[0]['subject_code'];
			if($subject_type=='TH'){
				$subType ="Theory";
			}else{
				$subType ="Practical";
			}
			
			foreach ($absent_stud as $value) {
				$stud_name = $value['first_name'].' '.$value['last_name'];
				$pmob=$value['parent_mobile2'];
				$smob=$value['mobile'];
				
				if($pmob !=''){
					$smob .=','.$value['parent_mobile2'];
				}
				
				if($emp_id !='1100521231'){
					$smob=$smob;
				}else{
					$smob ='8850633088';
				}
				//$smob ='8850633088';
				$sms = "Dear Parent, 
Your ward $stud_name is absent from $slot_time $subjectCode $subType on $today_date
Thanks,
Sandip University.";
		//echo $sms;exit;
			$sms_message =urlencode($sms);				
			$smsGatewayUrl="http://login.businesslead.co.in/api/mt/SendSMS?user=SANDIPFOUNDATION&password=ABC@789&senderid=SANDIP&channel=TRANS&DCS=0&flashsms=0&number=$smob&text=$sms_message&route=22";
	//&peid=1701159161247599930
			$url = $smsGatewayUrl;

			$ch = curl_init();                       // initialize CURL
			curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$content = curl_exec($ch);
			curl_close($ch); 
			$response = json_decode($content, true);  
						
			$sms_data['mobile_nos'] =$smob;
			$sms_data['sms_type'] ='Attendance';
			$sms_data['attendance_id'] =$value['attendance_id'];
			$sms_data['message'] =($sms);
			$sms_data['entry_by'] =$this->session->userdata("name");
			$sms_data['entry_on'] =date('Y-m-d H:i:s');
			//$sms_data['gateway_responce'] = $response;
			$DB1->insert('sms_log', $sms_data);
			//echo  $DB1->last_query();
			}
		}
			/////////////////////////////////////////////////////////////////////////////////////////////////
			$cnt_absent =  count($absent_stud);
			$allstd = array();
			$allstd['ss'] = $absent_stud;
			$allstd['allcnt'] = $cnt_all;
			$allstd['cnt_present'] = $cnt_present;
			$allstd['cnt_absent'] = $cnt_absent;
			

			$str4 = json_encode($allstd);
			echo $str4;
		}else{
			echo "dupyes";
		}
		//redirect('Attendance/');
    } 	
	///////////////////////////////////added on 10-03-2025//////////////////
	public function student_attendance_pdf_dowload()
	{
		//error_reporting(E_ALL);
		$emp_id = $this->session->userdata("name");
		$this->load->model('Subject_model');
		$this->load->model('Timetable_model');
		$this->data['course_details'] = $this->Subject_model->getCollegeCourse($college_id = '');
		$this->data['academic_year'] = $this->Timetable_model->fetch_Allacademic_session();
		//$this->data['classRoom']= $this->Attendance_model->getclassRoom();
		if (!empty($_POST['stream_id'])) {
			$streamID = $_POST['stream_id'];
			$semester = $_POST['semester'];
			$division = $_POST['division'];

			$this->data['streamID'] = $_POST['stream_id'];
			$this->data['division'] = $division;
			$this->data['semesterNo'] = $_POST['semester'];
			$this->data['courseId'] = $_POST['course_id'];
		} else {
		}
		$this->data['academicyear'] = $_POST['academic_year'];

		if (!empty($_POST['from_date'])) {
			$from_date = $_POST['from_date'];
			$to_date = $_POST['to_date'];
		} else {
			$from_date = "";
			$to_date = "";
		}
		$streamName = $this->Attendance_model->getStreamCode($streamID);
		$create_batch_name = $streamName[0]['stream_code'] . '-' . $division;
		$this->data['attendance_data'] = $this->Attendance_model->get_student_attendance($streamID, $semester, $division, $_POST['academic_year'], $from_date, $to_date);


		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'student_attendance_pdf_dowload', $this->data);
		$this->load->view('footer');
	}


	public function parent_letter_report()
	{
		$this->load->model('Subject_model');
		$this->load->model('Timetable_model');
		$this->load->model('Attendance_model');

		$student_id = $this->input->post('student_id');
		$streamID = $this->input->post('stream_id');
		$semester = $this->input->post('semester');
		$division = $this->input->post('division');
		$courseId = $this->input->post('course_id');
		$academic_year = $this->input->post('academic_year');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		
		$this->data['attendance_data'] = $this->Attendance_model->get_student_attendance_for_parent(
			$streamID,
			$semester,
			$division,
			$academic_year,
			$from_date,
			$to_date,
			$student_id
		);
//  echo "<pre>"; print_r($this->data['attendance_data']);exit;

		$this->data['from_date'] = $from_date;
		$this->data['to_date'] = $to_date;
		$this->load->library('M_pdf');

		$html = $this->load->view($this->view_dir . 'parent_letter', $this->data, TRUE);
		$mpdf = new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');

		$mpdf->WriteHTML($html);

		$mpdf->Output("Parent_Letter_$student_id.pdf", "D");
	}

	public function student_attendance()
	{
		$roles_id = $this->session->userdata('role_id');
		$enrollment_no = $this->session->userdata('name');
	
		$student_data = $this->Attendance_model->getStudentData($enrollment_no);
	
		if (!empty($student_data)) {
			$student_id = $student_data[0]['stud_id'];
			$first_name = $student_data[0]['first_name'];
			$admission_stream = $student_data[0]['admission_stream'];
			$current_year = $student_data[0]['current_year'];
			$current_semester = $student_data[0]['current_semester'];
			$roll_no = $student_data[0]['roll_no'];
			$division = $student_data[0]['division'];
			$streamID = $student_data[0]['stream_id'];
			$semester = $student_data[0]['current_semester'];
			$courseId = $student_data[0]['course_id'];
			$academic_year = $student_data[0]['academic_year'];
	
			$this->data['student_id'] = $student_id;
			$this->data['first_name'] = $first_name;
			$this->data['admission_stream'] = $admission_stream;
			$this->data['current_year'] = $current_year;
			$this->data['current_semester'] = $current_semester;
			$this->data['roll_no'] = $roll_no;
			$this->data['division'] = $division;
			$this->data['streamID'] = $streamID;
			$this->data['semester'] = $semester;
			$this->data['courseId'] = $courseId;
			$this->data['academic_year'] = $academic_year;
		} else {
			$this->data['student_id'] = null;
			$this->data['first_name'] = "Not Found";
			$this->data['admission_stream'] = null;
			$this->data['current_year'] = null;
			$this->data['current_semester'] = null;
			$this->data['roll_no'] = null;
			$this->data['division'] = null;
			$this->data['streamID'] = null;
			$this->data['semester'] = null;
			$this->data['courseId'] = null;
			$this->data['academic_year'] = null;
		}
	
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
	
		$this->load->model('Subject_model');
		$this->load->model('Timetable_model');
		$this->load->model('Attendance_model');
	
		$this->data['academic_year'] = $this->Timetable_model->fetch_Allacademic_session();
	//print_r($this->data['academic_year']);exit;
		$this->data['attendance_data'] = $this->Attendance_model->get_student_attendance_for_parent(
			$streamID,
			$semester,
			$division,
			$this->data['academic_year'],
			$from_date,
			$to_date,
			$student_id
		);
		
		// echo "<pre>";
		// print_r($this->data['attendance_data']);exit;
	
		$this->load->view('header', $this->data);
		$this->load->view($this->view_dir . 'student_attendance_view', $this->data);
		$this->load->view('footer');
	}

	////////////////////////
	public function faculty_subjects()
    {
		//error_reporting(E_ALL); ini_set('display_errors', 1);
      $this->load->model('Exam_timetable_model');
	  $this->load->view('header',$this->data); 
	  $roll_id = $this->session->userdata("role_id");	
	  $emp_id = $this->session->userdata("name");	  	  

		  // for faculty
		$emp_id = $this->session->userdata("name");
		$curr_session= $this->Attendance_model->getCurrentSession();
		$emp_details = $this->Attendance_model->fetchempdetails($emp_id);
//print_r($_SESSION);
//exit;
		//echo  $emp_details[0]['emp_school'];
		$this->session->set_userdata('emp_school_id', $emp_details[0]['emp_school']);
		$this->data['subject']= $this->Attendance_model->getFacultySubjects_for_mte_quiz($emp_id, $curr_session[0]['academic_session'], $curr_session[0]['academic_year']);

		$this->data['academic_year'] = $curr_session[0]['academic_year'];
		$this->load->view($this->view_dir.'faculty_subjects',$this->data);
	  	
	  $this->load->view('footer');
	}
	//
	public function getLecturePlansForDropdown()
{
    $DB3 = $this->load->database('obe', TRUE);

    $subject_input = $this->input->post('subject_id');
    $parts = explode('-', $subject_input);
    $subject_id = $parts[0];
	$division = $parts[1];
	$batch = $parts[2];
		
    $faculty_id = $this->input->post('faculty_id');
    $campus_id = $this->input->post('campus_id');

    $plans = $DB3->where('subject_id', $subject_id)
                 ->where('faculty_id', $faculty_id)
                 ->where('campus_id', $campus_id)
				 ->where('division', $division)
				 ->where('batch', $batch)
                 ->where('date_of_completion IS NULL') // Only unmarked
                 ->order_by('planned_date', 'ASC')
                 ->get('lecture_plan')
                 ->result();

    $result = [];

    foreach ($plans as $plan) {
        // ✅ Get Topic Title + Order
        $topic = $DB3->where('topic_id', $plan->topic_id)
                     ->where('subject_id', $subject_id)
                     ->where('campus_id', $campus_id)
                     ->get('syllabus_topics')
                     ->row();

        $topic_text = $topic ? $topic->topic_order . '. ' . $topic->topic_title : 'N/A';

        // ✅ Get Subtopic Title + Sr. No.
        $subtopic_text = '';
        if ($plan->subtopic_id) {
            $subtopic = $DB3->where('subtopic_id', $plan->subtopic_id)
                            ->where('topic_id', $plan->topic_id)
                            ->where('subject_id', $subject_id)
                            ->where('campus_id', $campus_id)
                            ->get('syllabus_subtopics')
                            ->row();
            if ($subtopic) {
                $subtopic_text = $subtopic->srno . '. ' . $subtopic->subtopic_title;
            }
        }

        $result[] = [
            'plan_id' => $plan->plan_id,
            'topic_title' => $topic_text,
            'subtopic_title' => $subtopic_text
        ];
    }

    echo json_encode($result);
}

	////////////////
	public function markAttendance_obe()
	{
		$DB1 = $this->load->database('umsdb', TRUE);
		$this->obe = $this->load->database('obe', TRUE);
		$emp_id = $this->session->userdata("name");
		$this->load->model('lecture_plan_model');
		$this->load->model('Assignment_model');
		$today = $_POST['today_date'];
		$checked_stud = $_POST['chk_stud'];
		$sem_id = $_POST['sem'];
		$stream_id = $_POST['stream_code'];
		$slot = $_POST['slot'];
		$sub_code = $_POST['sub_code'];
		$academic_year = $_POST['academic_year'];
		$division = $_POST['division'];
		$batch = $_POST['batch'];
		$subject_id_explode = explode('-', $_POST['subject']);
		$subject_type = $subject_id_explode[5];

		$lecture_plan_id = $_POST['lecture_plan_dropdown'];
		$other_topic = $_POST['other_topic'];
		$topic_contents = $other_topic.' → '.$_POST['topic_contents'];
		$campus_id = 1;
		
		$CntDup = $this->Attendance_model->check_dup_attendance($today, $slot, $emp_id, $sem_id, $division, $batch, $sub_code, $stream_id);

		if (count($CntDup) == 0) {
			$allbatchStudent = $this->Attendance_model->get_studbatch_allot_list($sub_code, $stream_id, $sem_id, $division, $batch, $academic_year, $today);
			$curr_session = $this->Attendance_model->getCurrentSession();
			$curr_ses = ($curr_session[0]['academic_session'] == 'WINTER') ? 'WIN' : 'SUM';

			// All student IDs in batch
			$all_student_ids = array_column($allbatchStudent, 'stud_id');

			// Present students from POST
			$present_student_ids = $checked_stud;

			// Absent students = all - present
			$absent_student_ids = array_diff($all_student_ids, $present_student_ids);

			// If lecture plan selected, update topic_contents
			if (!empty($lecture_plan_id)) {
				$planDetails = $this->lecture_plan_model->getLecturePlanById($lecture_plan_id);
				if ($planDetails) {
					$topic_contents = "Topic: " . $planDetails['topic_title'];
					if (!empty($planDetails['subtopic_title'])) {
						$topic_contents .= " → Subtopic: " . $planDetails['subtopic_title'];
					}
				}
			}
			
			$cnt_present = count($checked_stud);
			$cnt_all = count($allbatchStudent);
			$cnt_absent = $cnt_all - $cnt_present;

			if ($cnt_all > 0) {
				$present_percentage = round(($cnt_present / $cnt_all) * 100, 2);
				$absent_percentage = round(($cnt_absent / $cnt_all) * 100, 2);
			} else {
				$present_percentage = 0;
				$absent_percentage = 0;
			}
			

			// Insert master
			$data_master = [
				'faculty_id'        => $emp_id,
				'subject_id'        => $sub_code,
				'campus_id'         => $campus_id,
				'stream_id'         => $stream_id,
				'academic_year'     => $academic_year,
				'academic_session'  => $curr_ses,
				'semester'          => $sem_id,
				'division'          => $division,
				'batch'             => $batch,
				'slot'              => $slot,
				'attendance_date'   => $today,
				'total_students'    => $cnt_all,
				'present_count'     => $cnt_present,
				'absent_count'      => $cnt_absent,
				'present_percentage'=> $present_percentage,
				'absent_percentage' => $absent_percentage,
				'inserted_datetime' => date('Y-m-d H:i:s'),
				'subtype'           => $subject_type,
				'plan_id'           => !empty($lecture_plan_id) ? $lecture_plan_id : NULL,
				'remarks'           => $topic_contents,
				'status'            => 1
			];
			//echo '<pre>';print_r($data_master);exit;
			$attendance_id = $this->Attendance_model->insertAttendanceMaster($data_master);
			if($emp_id!=211636){
			//echo '<pre>'; print_r($_POST);exit;
			//$attendance_id = $this->Attendance_model->insertAttendanceMaster($data_master);
			}
			
			//echo '-'.$attendance_id;
			//echo $DB1->last_query();exit;
			// Insert detail (lecture_attendance)
			foreach ($all_student_ids as $stud_id) {
				$data_detail = [
					'attendance_id' => $attendance_id,
					'student_id'    => $stud_id,
					'is_present'    => in_array($stud_id, $present_student_ids) ? 'Y' : 'N',
					'faculty_code'        => $emp_id,
					'subject_id'        => $sub_code,
					'stream_id'         => $stream_id,
					'academic_year'     => $academic_year,
					'academic_session'  => $curr_ses,
					'semester'          => $sem_id,
					'division'          => $division,
					'batch'             => $batch,
					'slot'              => $slot,
					'attendance_date'   => $today,
					'subtype'           => $subject_type,
					'inserted_datetime' => date('Y-m-d H:i:s'),
				];
				$this->Attendance_model->insertLectureAttendance($data_detail);
				if($emp_id!=211636){
				//echo '<pre>'; print_r($_POST);exit;
				//$this->Attendance_model->insertLectureAttendance($data_detail);
				}
			}

			// Update lecture plan completion date
			if (!empty($lecture_plan_id)) {
				$this->lecture_plan_model->updateLecturePlanCompletionDate($lecture_plan_id, $today);
			}

			// Prepare present & absent student data
			$absent_stud = $this->Attendance_model->fetchAbsentStud($sub_code,$today,$slot,$emp_id,$sem_id,$division, $batch);
			// Count
			$cnt_present = $cnt_present;
			$cnt_absent  = $cnt_absent;
			$cnt_all     = $cnt_all;
			
			/////////////////////////////////////////////////////////////
			$question_ids = $this->input->post('question_ids', true);

				// Normalize & validate questions
				$question_ids = is_array($question_ids) ? array_values(array_filter($question_ids, 'strlen')) : [];

				// Optional: also respect a "create_assignment" flag if you send it from JS
				$wantsAssignment = (string)$this->input->post('create_assignment') === '1';

				// Guard: create assignment only when requested AND questions are non-empty
				if ($wantsAssignment && !empty($question_ids)) {

				$plan = $this->obe->get_where('lecture_plan', ['plan_id' => (int)$lecture_plan_id])->row();		
				
				$payload = [
					'campus_id'       => $campus_id,
					'subject_id'      => $sub_code,
					'faculty_id'      => $emp_id,
					'lecture_plan_id' => $lecture_plan_id,
					'topic_id'        => $plan->topic_id,
					'subtopic_id'     => $plan->subtopic_id,
					'title'           => $this->input->post('title'),
					'description'     => $this->input->post('description'),
					'due_date'        => $this->input->post('due_date'),
					'max_marks'       => $this->input->post('max_marks'),
					'question_ids'    => $this->input->post('question_ids') ?: [],
					'student_ids'     => $this->input->post('student_ids') ?? ($all_student_ids ?? [])
				];
				//echo '<pre>'; print_r($payload);exit;	
				$id = $this->Assignment_model->create_assignment($payload);
		}
			//////////////////////////////////////////////////////////////

			//////////////////////////////////////////////////
			// SMS logic for absent students
			//////////////////////////////////////////////////
			$tdate = date('Y-m-d');
			if ($tdate == $today) {
				$today_date = date('d-m-Y', strtotime($today));
				$slot1 = $this->Attendance_model->fetch_slot_attendance($slot);
				$subject = $this->Attendance_model->fetch_subject_attendance($sub_code);
				$slot_time = $slot1[0]['from_time'].' - '.$slot1[0]['to_time'].' '.$slot1[0]['slot_am_pm'];
				$subject_type_disp = $subject[0]['subject_component'] == 'TH' ? "Theory" : "Practical";
				$subjectCode = $subject[0]['subject_code'];

				 foreach ($absent_stud as $value) {
					$stud_name = $value['first_name'].' '.$value['last_name'];
					$pmob=$value['parent_mobile2'];
					$smob=$value['mobile'];
					
					if($pmob !=''){
						$smob .=','.$pmob;
					}
					
					if($emp_id !='1100521231'){
						$smob=$smob;
					}else{
						$smob ='8850633088';
					}
					//$smob ='8850633088';
					$sms = "Dear Parent, 
Your ward $stud_name is absent from $slot_time $subjectCode $subject_type_disp on $today_date
Thanks,
Sandip University.";
			//echo $sms;exit;
				$sms_message =urlencode($sms);				
				$smsGatewayUrl="http://login.businesslead.co.in/api/mt/SendSMS?user=SANDIPFOUNDATION&password=ABC@789&senderid=SANDIP&channel=TRANS&DCS=0&flashsms=0&number=$smob&text=$sms_message&route=22";
				$url = $smsGatewayUrl;

				$ch = curl_init();                       // initialize CURL
				curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$content = curl_exec($ch);
				curl_close($ch); 
				$response = json_decode($content, true);  
							
				$sms_data['mobile_nos'] =$smob;
				$sms_data['sms_type'] ='Attendance';
				$sms_data['attendance_id'] =$value['attendance_id'];
				$sms_data['message'] =($sms);
				$sms_data['entry_by'] =$this->session->userdata("name");
				$sms_data['entry_on'] =date('Y-m-d H:i:s');
				//$sms_data['gateway_responce'] = $response;
				$DB1->insert('sms_log', $sms_data);
				//echo  $DB1->last_query();
				} 
			}

			// Prepare response
			$allstd = array();
			$allstd['ss']          = $absent_students;
			$allstd['allcnt']      = $cnt_all;
			$allstd['cnt_present'] = $cnt_present;
			$allstd['cnt_absent']  = $cnt_absent;

			echo json_encode($allstd);

		} else {
			echo "dupyes";
		}
	}
public function genericAttendanceReport()
    {
		$this->load->model('Subject_model');
		$this->load->model('Attendance_model');
		$this->load->model('Batchallocation_model');
		$this->load->model('Timetable_model');
        //$this->load->view('header',$this->data);
		$this->data['academic_year']= $this->Timetable_model->fetch_Allacademic_session();		
        $course_id = $_POST['course_id'];
		$stream_id = $_POST['stream_id'];
		$semester = $_POST['semester'];
		$division = $_POST['division'];
		$subject_id = explode('-', $_POST['subject']);
		$from_date     = $this->input->post('from_date'); // NEW
		$to_date       = $this->input->post('to_date');   // NEW
		
		$this->data['courseId'] = $_POST['course_id'];
		$this->data['streamId'] = $_POST['stream_id'];
		$this->data['semesterNo'] = $_POST['semester'];
		$this->data['division'] = $_POST['division'];
		$this->data['academicyear'] =$_POST['academic_year'];
		$this->data['from_date'] =$this->input->post('from_date'); 
		$this->data['to_date'] =$this->input->post('to_date');
		
		
		$strm_code = $this->Batchallocation_model->getStreamCode($stream_id);
		$stream_code = $strm_code[0]['stream_code'];
		$this->data['streamName'] = $strm_code[0]['stream_name'];
		//$batch_code = $subject_id[1].'-'.$subject_id[2];
		//print_r($_POST);exit;
		$batch_code = $stream_code.'-'.$division;
        if ($this->input->post()) {
            $stream_id     = $this->input->post('stream_id');
            $semester      = $this->input->post('semester');
            $division      = $this->input->post('division');
            $academic_year = $this->input->post('academic_year');
			$report_type = $this->input->post('report_type');

            list($subjects, $report) = $this->Attendance_model
    ->getStudentAttendancePivot($stream_id, $semester, $division, $academic_year, $from_date, $to_date, $report_type);

            $data['subjects'] = $subjects;
            $data['attendanceReport'] = $report;
			$data['report_type']      = $report_type; 

            $this->load->view('header',$this->data);
            $this->load->view('Attendance/genericAttendanceReport', $data);
            $this->load->view('footer');
        } else {
            // load filter form
            $this->load->view('header',$this->data);
            $this->load->view('Attendance/genericAttendanceReport',$this->data);
            $this->load->view('footer');
        }
    }
	
	public function downloadAttendanceReportjj()
{
    $this->load->model('Attendance_model');

    $stream_id     = $this->input->post('stream_id');
    $semester      = $this->input->post('semester');
    $division      = $this->input->post('division');
    $academic_year = $this->input->post('academic_year');
    $from_date     = $this->input->post('from_date');
    $to_date       = $this->input->post('to_date');
    $report_type   = $this->input->post('report_type') ?? 'S';

    // Get attendance data
    list($subjects, $report) = $this->Attendance_model
        ->getStudentAttendancePivot($stream_id, $semester, $division, $academic_year, $from_date, $to_date, $report_type);

    // Load PDF library (using dompdf)
    $this->load->library('pdf'); // make sure DomPDF is configured

    $data['subjects']         = $subjects;
    $data['attendanceReport'] = $report;
    $data['report_type']      = $report_type;

    $html = $this->load->view('Attendance/attendanceReportPdf', $data, true);

    $this->pdf->loadHtml($html);
    $this->pdf->setPaper('A4', 'landscape');
    $this->pdf->render();
    $this->pdf->stream("AttendanceReport.pdf", array("Attachment" => 1));
}

	
	public function downloadAttendanceReport()
	{
		// Load models
		$this->load->model('Attendance_model');
		$this->load->model('Batchallocation_model');

		// Get POST/GET params (depending on your form)
		 $stream_id     = $this->input->post('stream_id');
		$semester      = $this->input->post('semester');
		$division      = $this->input->post('division');
		$academic_year = $this->input->post('academic_year');
		$from_date     = $this->input->post('from_date'); // new
		$to_date       = $this->input->post('to_date');   // new
		$report_type   = $this->input->post('report_type') ?? 'S';

		  list($subjects, $report) = $this->Attendance_model
        ->getStudentAttendancePivot($stream_id, $semester, $division, $academic_year, $from_date, $to_date, $report_type);

		$data['subjects']         = $subjects;
		$data['attendanceReport'] = $report;
		$data['academic_year']    = $academic_year;
		$data['stream_id']        = $stream_id;
		$data['semester']         = $semester;
		$data['division']         = $division;
		$data['from_date']        = $from_date;
		$data['to_date']          = $to_date;
		$data['report_type']      = $report_type;
		
		$strm_code = $this->Batchallocation_model->getStreamCode($stream_id);
		$stream_code = $strm_code[0]['stream_code'];
		$data['streamName'] = $strm_code[0]['stream_name'];
		// Load Dompdf
		$this->load->library('m_pdf'); // wrapper library you created earlier

		// Render view into HTML string
		$html = $this->load->view('Attendance/attendanceReportPdf', $data, true);
		$pdfFilePath = 'Attendance_Report'.$academic_year.'_'.$stream_code.'_'.$semester.'_'.$division.'.pdf';
		// Generate PDF
		//$this->pdf->load($html, "Attendance_Report.pdf", "A4", "landscape");
		$mpdf=new mPDF('utf-8', 'A3-L', '10', '10', '10', '5', '5', '5');
        $mpdf->autoScriptToLang = true;
		$mpdf->baseScript = 1;  // Use values in classes/ucdn.php  1 = LATIN
		$mpdf->autoVietnamese = true;
	 //   $mpdf->autoArabic = true;
	 //   $mpdf->autoLangToFont = true;
		//$mpdf->SetMargins(10,10,15);
		$mpdf->SetDisplayMode('fullpage');                   
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($html);
        //$this->Results_model->update_resultdownloadStatus($reg_no);
        //download it.
        $mpdf->Output($pdfFilePath, "D");
	}

}
?>