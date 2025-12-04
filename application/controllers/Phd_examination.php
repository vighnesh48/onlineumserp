<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH.'third_party/mpdf/mpdf.php');
class Phd_examination extends CI_Controller{

	var $currentModule = "";   
	var $title = "";   
	var $table_name = "unittest_master";    
	var $model_name = "Phd_examination_model";   
	var $model;  
	var $view_dir = 'Phd_examination/';
	
	public function __construct(){        
		global $menudata;      
		parent::__construct();       
		$this->load->helper("url");     
		$this->load->library('form_validation');        
		if($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
		$title = $this->uri->segment(2); //Second segment of uri for action,In case of edit,view,add etc.       
		else
		$title = $this->master_arr['index'];
		$this->currentModule = $this->uri->segment(1);    
		$this->data['currentModule'] = $this->currentModule;       
		$this->data['model_name'] = $this->model_name;             
		$this->load->library('form_validation');       
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
       
		$model = $this->load->model($this->model_name);
		$menu_name = $this->uri->segment(1);
        
		$this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
        
	}
    
    
    
	public function index($student_prn=''){  
	//echo "Last Date to be apply 11th Nov 2019 till 5:00 PM.";exit; 
		$arr_prn= array();
		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}
		
		
		$this->data['exam']= $this->Phd_examination_model->fetch_stud_curr_exam();
		$id= $this->Phd_examination_model->get_student_id_by_prn($stud_prn);
		/****** Exam allowed  student list start ********/
		/* $allowed_prn=$this->Phd_examination_model->get_exam_allowed_studntlist($this->data['exam'][0]['exam_id']);
		foreach($allowed_prn as $pr){
			$arr_prn[] = $pr['enrollment_no'];
		}
		$this->data['arr_prn']=$arr_prn; */
		/*if($id['academic_year'] !='2019'){
			$arr_prn[] = $stud_prn;           //this condition is made for backlog students
		}*/
		
		//print_r($arr_prn);
		//as per email - allow 14 FD students 02May2019 - kishor mehare
		// 180105021014 allowed on request by Pankaj 03May2019 - kishor mehare
		// checking fees
		$ref=0;$other=0;$pending=0;$per_paid=0;
		$stud1=$this->Phd_examination_model->get_studentwise_admission_fees($stud_prn,$id['academic_year']);
		$other=$stud1[0]['opening_balance']+$stud1[0]['cancel_charges'];
		//print_r($arr_prn);exit;
		//if(in_array($stud_prn, $arr_prn)){
			//echo $id['admission_session'];
		if($id['admission_session'] !='2024' ){
		//	echo 'test';
			$pending=0;
			$per_paid =58;
			$other=0;
		}else{
			
			 $pending=($stud1[0]['applicable_total']+$other+$stud1[0]['refund'])-$stud1[0]['fees_total'];
			//exit();
			if($other >=0){
			$fees_app = ($stud1[0]['applicable_total']+$other+$stud1[0]['refund']);//echo"<br>";
		    $fees_paid = $stud1[0]['fees_total'];//echo"<br>";
			}else{
				$fees_app = ($stud1[0]['applicable_total']+$stud1[0]['refund']);
				$fees_paid = $stud1[0]['fees_total']-($other);
			}
			//$fees_app = ($stud1[0]['applicable_total']+$other+$stud1[0]['refund']);
		   // $fees_paid = $stud1[0]['fees_total'];
			$per_paid = round(($fees_paid/$fees_app)*100);//exit;
			
			//$bklgstud_prn=array('170101061008','180104071005','180105011043','180110011027','180105031019','180105031014'); //added for backlog student 260719
			//if(in_array($stud_prn, $bklgstud_prn)){
			//	$pending=0;
			//}
		}
		// echo $fees_paid;exit();
		
		//echo $pending;
		//exit();
		/***** fetching exam form openeing dates **********/
		$this->data['forms_dates']= $this->Phd_examination_model->get_form_entry_dates($this->data['exam'][0]['exam_id']);
		
		
		
		if($fees_paid < 74500 && $id['admission_cycle'] == 'JULY-24'){
			// echo 1111;exit;
			$html = $this->load->view($this->view_dir.'load_studacdemicfees_details',$data,true);
			echo $html;
		}else{
			//echo $pending;
			//exit();
		//echo $per_paid;
		//exit();
		$stud_id=$id['stud_id'];
		$semester = $id['current_semester'];
		$stud_stream = $id['admission_stream'];
		if($stud_id !=''){
    
			
			$this->data['bank']= $this->Phd_examination_model->fetch_banks();
			$this->data['fee']= $this->Phd_examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['emp']= $this->Phd_examination_model->fetch_personal_details($stud_id);

			$this->data['examfees']= $this->Phd_examination_model->fetch_examfeesdetails($this->data['emp'][0]['stream_id'], $this->data['exam'][0]['exam_id']);
			
			if($this->data['exam'][0]['exam_type']=='Regular'){
				$this->data['backlogsublist']= $this->Phd_examination_model->getStudbacklogSubject($stud_id,$semester);
				if(empty($this->data['backlogsublist'])){
					$this->data['sublist']= $this->Phd_examination_model->getStudAllocatedSubject($stud_id, $semester);	
				}
				$batch = $this->data['sublist'][0]['batch'];
				$this->data['semsublist']= $this->Phd_examination_model->getSemesterSubject_edit($semester, $this->data['emp'][0]['stream_id'], $batch);
				$this->data['backlogsublist']= $this->Phd_examination_model->getStudbacklogSubject($stud_id,$semester);
				
				// print_r($this->data['sublist']);
				//	echo $per_paid;
				// exit;
			}else{
		$this->data['sublist']= $this->Phd_examination_model->getExamSubject($stud_id,$stud_stream);
		if(empty($this->data['sublist'])){
		$this->data['sublist']= $this->Phd_examination_model->getStudAllocatedSubject_for_supplimentry($stud_id, $semester-1);	
				}
			}
				
			//}
		// echo 1111;exit;
			$this->load->view('header',$this->data); 
			$this->load->view($this->view_dir.'view',$this->data);
			$this->load->view('footer');
		}else{
			redirect('home');
		}
	}
        
	}
    
    
    
    
	public function list_allstudents(){
      
		if($_POST){
			$this->load->view('header',$this->data);        
    
	
			$college_id = 1;
			$this->data['emp_list']= $this->Phd_examination_model->list_allstudents();
			$this->data['course_details']= $this->Phd_examination_model->getCollegeCourse();
			$this->load->view($this->view_dir.'student_list',$this->data);
			$this->load->view('footer');    
		}
		else{
      
			$this->load->view('header',$this->data);        
    
	
			$college_id = 1;
			$this->data['course_details']= $this->Phd_examination_model->getCollegeCourse();
			$this->load->view($this->view_dir.'student_list',$this->data);
			$this->load->view('footer');
      
		}
 
        
	}
    
    
    
    
	public function course_streams(){
		global $model;	    
		$this->data['campus_details']= $this->Phd_examination_model->course_streams($_POST);     	    
	}
    
    
    
    
	
	public function add_exam_form(){ 
	//exit(); 
		$DB1 = $this->load->database('umsdb', TRUE);
		$this->load->model('Examination_model');
		$exam_details =  explode('~',$this->input->post('exam_details'));
		$fee_date = str_replace('/', '-', $_POST['dddate']);
		// echo "<pre>"; print_r($_POST);
		 //exit();
		$marathiname=$this->input->post('marathi_name');
		$abc_no=$this->input->post('abc_no');
		$studid=$this->input->post('student_id');
		$stdwhere = "stud_id='$studid'";
		$DB1->where($stdwhere);
		$stddata['marathi_name']=$marathiname;	
		if(!empty($abc_no)){			
			$chk_duplicate_abc_no = $this->Examination_model->chk_duplicate_abc_no($studid,$abc_no);
			//echo count($chk_duplicate_abc_no);//exit;
			if(count($chk_duplicate_abc_no) <=0){
				
			}else{
				echo "Duplicate ABC no. please enter correct no."; echo '<a href="https://erp.sandipuniversity.com/home"><button class="btn">Home</button></a>';exit;
			}
			$stddata['abc_no']=$abc_no;
		}
		if($marathiname !=''){
			$DB1->update("student_master", $stddata); 
			//echo $DB1->last_query();exit;
		}
		
		$insert_exam_subjects=array(
			"exam_master_id"=>$this->input->post('room_no'),
			"stud_id"=>$this->input->post('student_id'),
			"enrollment_no"=>$this->input->post('enrollment_no'),
			"stream_id"=>$this->input->post('stream_id'),
			
			"semester"=>$this->input->post('semester'),
			"exam_id" => $exam_details[0],
			"exam_month" => $exam_details[1],
			"exam_year" => $exam_details[2],
			"entry_by" => $this->session->userdata("uid"),
			"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
			"entry_on" => date("Y-m-d H:i:s"),
			"allow_for_exam" => 'Y',
			"is_absent" => 'N'); 
			


		/*$fees_details =array(
		"student_id"=>$this->input->post('student_id'),
		"type_id"=>'4',
		"fees_paid_type"=>$this->input->post('ptype'),
		"receipt_no"=>$this->input->post('receipt_no'),
		"amount" => $this->input->post('ddamount'),
		"fees_date" => date('Y-m-d', strtotime($fee_date)),
		"bank_id" => $this->input->post('bank_id'),
		"bank_city" => $this->input->post('bank_city'),
		"academic_year" => ACADEMIC_YEAR,
		"created_by" => $this->session->userdata("uid"),
		"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
		"created_on" => date("Y-m-d H:i:s")
		); 	
		$DB1->insert("fees_details", $fees_details); 
		$fees_details_id=$DB1->insert_id(); */
		
		$fees_paid_status = 'Y';
		if($exam_details[3]=='Regular'){
			$is_regular_makeup = 'R';
		}else{
			$is_regular_makeup = 'M';
		}
		$exam_ses =$exam_details[1].''.$exam_details[2];	
		$insert_exam_details =array(
			"stud_id"=>$this->input->post('student_id'),
			"enrollment_no"=>$this->input->post('enrollment_no'),
			"stream_id"=>$this->input->post('stream_id'),
			"course_id"=>$this->input->post('course_id'),
			"semester"=>$this->input->post('semester'),
			"school_code"=>$this->input->post('school_code'),
			"exam_fees"=>$this->input->post('applicable_fee'),
			"exam_id" => $exam_details[0],
			"exam_month" => $exam_details[1],
			"exam_year" => $exam_details[2],
			"is_regular_makeup" => $is_regular_makeup,
			"exam_fees_paid" => $fees_paid_status,
			"entry_by" => $this->session->userdata("uid"),
			"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
			"entry_on" => date("Y-m-d H:i:s"),
			"allow_for_exam" => 'Y',
			"is_active" => 'Y',
		); 	
		 $studprn = base64_encode($_POST['enrollment_no']);
		//exit();
		$chk_duplicate = $this->Phd_examination_model->chk_duplicate_exam_form($insert_exam_details);
		
		if(count($chk_duplicate) <=0){
			//echo $chk_duplicate;
			//exit();
		$DB1->insert("phd_exam_details", $insert_exam_details); 
		
		$exam_master_id=$DB1->insert_id(); 
		//echo $DB1->last_query();exit;
		if($exam_master_id !=''){
			$insert_exam_subjects['exam_master_id'] = $exam_master_id;
			//print_r($insert_exam_subjects);	exit;
			//$ex_session = $this->Phd_examination_model->fetch_stud_curr_exam();
			if($exam_details[3]=='Regular'){
				
				$subjects1 = $this->input->post('sub1');
				$subjects = $this->input->post('sub');
				
				//echo "<pre>";
				//print_r($subjects);exit;
				if(!empty($subjects)){
				if(!empty($subjects1)){
				$allsubjects = array_merge($subjects1, $subjects);
				}else{
				$allsubjects = $subjects;
				}					
				}else{
				$allsubjects = $subjects1;
				}
				//print_r($allsubjects);exit;
				foreach($allsubjects as $sub){
					$sub = explode('~', $sub);
					$insert_exam_subjects['subject_id']=$sub[0];
					$insert_exam_subjects['subject_code']= $sub[1];
					$insert_exam_subjects['semester']= $sub[2];
					$DB1->insert("phd_exam_applied_subjects", $insert_exam_subjects);
					//echo $DB1->last_query();exit;
				}
				
			}else{
				$subjects = $this->input->post('sub');
				foreach($subjects as $sub){
					$sub = explode('~', $sub);
					$insert_exam_subjects['subject_id']=$sub[0];
					$insert_exam_subjects['subject_code']= $sub[1];
					$insert_exam_subjects['semester']= $sub[2];
					$DB1->insert("phd_exam_applied_subjects", $insert_exam_subjects);
					//echo $DB1->last_query();exit;
				}
			}
			
			
			/*echo "<pre>";
			print_r($insert_array);
			exit();*/ 
			
			///////////////////
			include_once "phpqrcode/qrlib.php";
			//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
			$tempDir = 'uploads/exam/'.$exam_ses.'/QRCode/';
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0755, true);
			}
			//$po_id = $p_row[0]['ord_no'];
			$site_url="https://erp.sandipuniversity.com/";
			$codeContents = $site_url.'check.php?po='.$_POST['enrollment_no'];
			
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = 'qrcode_'.$_POST['enrollment_no'].'.png';		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	
			//////////////////
			$this->session->set_flashdata('success', 'Exam form added Successfully.');
			if($this->input->post('applicable_fee') <=0){
				redirect('Phd_examination/view_form/'.$studprn);
			}else{
				redirect('online_fee/pay_fees/Examination');		
			}

			}
		}else{
			$this->session->set_flashdata('duplicate', 'This Student is already Applied for Exam form.');			
			redirect('Phd_examination/view_form/'.$studprn);
		}
		

	} 
		public function edit_exam_form($student_prn){  
		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}
		
		$id= $this->Phd_examination_model->get_student_id_by_prn($stud_prn);
		$stud_id=$id['stud_id'];
		$current_semester =1;
		$stream =$id['admission_stream'];
		$ex_session = $this->Phd_examination_model->fetch_stud_curr_exam();
		$this->data['forms_dates']= $this->Phd_examination_model->get_form_entry_dates($ex_session[0]['exam_id']);

		$this->data['ex_session'] = $ex_session;
		if($stud_id!=''){
			$this->data['exam']= $this->Phd_examination_model->fetch_stud_exam_details($stud_id);
			$this->data['fee']= $this->Phd_examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Phd_examination_model->fetch_banks();
			$this->data['emp']= $this->Phd_examination_model->fetch_personal_details($stud_id);
			$this->data['sublist']= $this->Phd_examination_model->getExamAllocatedSubject_edit($stud_id);

			if($ex_session[0]['exam_type']=='Regular'){
				$this->data['backlogsublist']= $this->Phd_examination_model->getStudbacklogSubjectedit($stud_id);
				$regulation = $this->data['sublist'][0]['batch'];
				$this->data['semsublist']= $this->Phd_examination_model->getSemesterSubject_edit($current_semester, $stream, $regulation);
			}else{
				$this->data['allbklist']= $this->Phd_examination_model->getExamSubject($stud_id,$stream);
				//print_r($this->data['allbkist']);
			}
			
		}
		$this->load->view('header',$this->data); 
		$this->load->view($this->view_dir.'edit',$this->data);
		$this->load->view('footer');
        
	}	
		public function edit_exam_form_student($student_prn){  
		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}
		
		$id= $this->Phd_examination_model->get_student_id_by_prn($stud_prn);
		$stud_id=$id['stud_id'];
		$current_semester =1;
		$stream =$id['admission_stream'];
		$ex_session = $this->Phd_examination_model->fetch_stud_curr_exam();
		$this->data['forms_dates']= $this->Phd_examination_model->get_form_entry_dates($ex_session[0]['exam_id']);

		$this->data['ex_session'] = $ex_session;
		if($stud_id!=''){
			$this->data['exam']= $this->Phd_examination_model->fetch_stud_exam_details($stud_id);
			$this->data['fee']= $this->Phd_examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Phd_examination_model->fetch_banks();
			$this->data['emp']= $this->Phd_examination_model->fetch_personal_details($stud_id);
			$this->data['sublist']= $this->Phd_examination_model->getExamAllocatedSubject_edit($stud_id);

			if($ex_session[0]['exam_type']=='Regular'){
				$this->data['backlogsublist']= $this->Phd_examination_model->getStudbacklogSubjectedit($stud_id);
				$regulation = $this->data['sublist'][0]['batch'];
				$this->data['semsublist']= $this->Phd_examination_model->getSemesterSubject_edit($current_semester, $stream, $regulation);
			}else{
				$this->data['allbklist']= $this->Phd_examination_model->getExamSubject($stud_id,$stream);
				//print_r($this->data['allbkist']);
			}
			
		}
		$this->load->view('header',$this->data); 
		$this->load->view($this->view_dir.'edit_student',$this->data);
		$this->load->view('footer');
        
	}	
	//search_exam_form
	public function search_exam_form(){
		
		$this->load->view('header',$this->data); 
		$this->data['exam']= $this->Phd_examination_model->fetch_stud_curr_exam();
		$this->load->view($this->view_dir.'search',$this->data);
		$this->load->view('footer');
	}
	 
	function search_studentdata(){
		//echo '1';exit();
	//	$_POST['academic_year'] = '2019';		
		// checking fees
		$data['exam']= $this->Phd_examination_model->fetch_stud_curr_exam();
		//print_r($data['exam']);
		/****** Exam allowed  student list start ********/
		$allowed_prn=$this->Phd_examination_model->get_exam_allowed_studntlist($data['exam'][0]['exam_id']);
		foreach($allowed_prn as $pr){
			$arr_prn[] = $pr['enrollment_no'];
		}
		
		//print_r($arr_prn);
		$arr_prn =array('231105207047','231105207033','231105207065','221105221001','221106131002','231105207047','232116117004','232101377004','221105221001','231105207078','232101347017');
		$ref=0;$other=0;$pending=0;$per_paid=0;
		$prn = $_POST['prn'];
		//echo $prn;
		 $id= $this->Phd_examination_model->get_student_id_by_prn($prn);
		//exit();
		/*if($id['academic_year'] !='2019'){ // for backlog students
			$arr_prn = array($prn);
		}*/
		$stud1=$this->Phd_examination_model->get_studentwise_admission_fees($prn,$id['academic_year']);
		
		$other=$stud1[0]['opening_balance']+$stud1[0]['cancel_charges'];
		if($id['admission_session'] !='2024' ){
			$pending=0;
			$per_paid =100; 
			$other=0;
		}else{
			$pending=($stud1[0]['applicable_total']+$other+$stud1[0]['refund'])-$stud1[0]['fees_total'];
			//$bklgstud_prn=array('170101061008','180104071005','180105011043','180110011027','180105031019','180105031014');
			//if(in_array($prn, $bklgstud_prn)){
			//	$pending=0;
			//}
			if($other >=0){
			$fees_app = ($stud1[0]['applicable_total']+$other+$stud1[0]['refund']);//echo"<br>";
		    $fees_paid = $stud1[0]['fees_total'];//echo"<br>";
			}else{
				$fees_app = ($stud1[0]['applicable_total']+$stud1[0]['refund']);
				$fees_paid = $stud1[0]['fees_total']-($other);
			}
			$per_paid = round(($fees_paid/$fees_app)*100);
			if($this->session->userdata("role_id")==15){
				//echo $fees_app = ($stud1[0]['applicable_total']+$stud1[0]['refund']);echo"<br>";
				//echo $fees_paid = $stud1[0]['fees_total']-($other);echo"<br>";
				echo 'applicable_total-'.$stud1[0]['applicable_total'];echo"<br>"; echo 'Other-'.$other;echo"<br>";
				echo '%-'.$per_paid; echo"<br>";
				echo 'fees_paid-'.$fees_paid;echo"<br>";
				echo 'fees_app-'.$fees_app;
			}
		}
		
		//if($prn=='180101051083'){
			$data['res_status']= $this->Phd_examination_model->check_stud_result_status($prn);
		//}
		
		if($fees_paid < 74500 && $stud1[0]['admission_cycle'] == 'JULY-24'){
			//	echo 1111;exit;
			$html = $this->load->view($this->view_dir.'load_studacdemicfees_details',$data, TRUE);
			echo $html;

		}else{

			$emp_list= $this->Phd_examination_model->searchStudentsajax($_POST);
			
			if(!empty($emp_list)){
				$data['emp_list']= $emp_list;
				$data['emp_list'][0]['exam_details']= $this->Phd_examination_model->studentExamDetails($_POST);
			//	print_r($emp_list);
		//exit();
			}else{
				$emp_list1= $this->Phd_examination_model->searchCheckStudentbyprn($_POST);
				$data['emp_list']= $emp_list1;
			}
			
			$data['fees']= $this->Phd_examination_model->fetch_fees($_POST);
			
			
			$html = $this->load->view($this->view_dir.'load_studentdata',$data,true);
			echo $html;
		}
	}
	
	function download_pdf1($student_id, $exam_id){
		//load mPDF library
        
		$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		$this->load->library('m_pdf', $param);
		$stud_id = base64_decode($student_id);
		if($stud_id!=''){
			$this->data['exam']= $this->Phd_examination_model->fetch_exam_session_byid($exam_id);
			$exam_month =$this->data['exam'][0]['exam_month'];
			$exam_year =$this->data['exam'][0]['exam_year'];
			$this->data['examdetails']= $this->Phd_examination_model->fetch_stud_phd_exam_details($stud_id,$exam_id);
			//print_r($this->data['examdetails']);exit;
			$this->data['fee']= $this->Phd_examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Phd_examination_model->fetch_banks();
			$this->data['emp']= $this->Phd_examination_model->fetch_personal_details($stud_id);
			$semester = $this->data['emp'][0]['current_semester'];
			$this->data['sublist']= $this->Phd_examination_model->getCurrentExamAllocatedSubject($stud_id, $semester,$exam_id);	
			if($this->data['exam'][0]['exam_year'] =='Regular'){
				$this->data['backlogsublist']= $this->Phd_examination_model->getStudbacklogSubject($stud_id);
			}
			
			$this->data['examfees']= $this->Phd_examination_model->fetch_examfeesdetails($this->data['emp'][0]['stream_id'], $this->data['exam'][0]['exam_id']);
			$this->data['laddr']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');

			foreach($this->data['sublist'] as $sb){
				$sub[] = $sb['semester']; 
			}
			if($this->data['exam'][0]['exam_year'] =='Regular'){
				foreach($this->data['backlogsublist'] as $blk){
					$blksub[] = $blk['semester']; 
				}
			}
			
			if(!empty($blksub)){
				$semarray = array_unique(array_merge(array_unique($blksub), array_unique($sub)));			
			}else{
				$semarray = array_unique($sub);
			}
			$esem ='';
			foreach($semarray as $sem){
				$esem .= $this->numberToRoman($sem).',';
			}
			$this->data['exam_semes'] = rtrim($esem,',');
			//print_r($semarray);
			//exit;
			
		}

		$html = $this->load->view($this->view_dir.'exam_form_pdf_new', $this->data, true);
		$pdfFilePath = $this->data['emp'][0]['enrollment_no']."_exam_form.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);

		$footer ='<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-bottom:30px;">
<tr>
<td width="30%" align="center">--------------------------</td>
<td width="30%" align="center">--------------------------</td>
<td width="40%" align="center">--------------------------</td>
</tr>
<tr>
<td align="center"><strong>Signature of the student</strong></td>
<td align="center"><strong>Signature of the Dean/HOD</strong></td>
<td align="center"><strong>Accounts Dept</strong></td>
</tr>
</table>';
		$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		
		$this->m_pdf->pdf->SetHTMLFooter($footer);
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		// ob_end_flush(); 
		
	}
	function numberToRoman($num)  
	{ 
		 // Make sure that we only use the integer portion of the value 
		 $n = intval($num); 
		 $result = ''; 
	  
		 // Declare a lookup array that we will use to traverse the number: 
		 $lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 
		 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 
		 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1); 
	  
		 foreach ($lookup as $roman => $value)  
		 { 
			 // Determine the number of matches 
			 $matches = intval($n / $value); 
	  
			 // Store that many characters 
			 $result .= str_repeat($roman, $matches); 
	  
			 // Substract that from the number 
			 $n = $n % $value; 
		 } 
	  
		 // The Roman numeral should be built, return it 
		 return $result; 
	}	 
	// update exam subject
	public function update_subject_details(){  
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam_details =  explode('~',$this->input->post('exam_details'));
		$fee_date = str_replace('/', '-', $_POST['dddate']);
		
		$insert_exam_subjects=array(
			"stud_id"=>$this->input->post('student_id'),
			"enrollment_no"=>$this->input->post('enrollment_no'),
			"stream_id"=>$this->input->post('stream_id'),
			"exam_id" => $exam_details[0],
			"exam_month" => $exam_details[1],
			"exam_year" => $exam_details[2],
			"exam_master_id" => $exam_details[3],
			"modify_by" => $this->session->userdata("uid"),
			"modify_from_ip" => $_SERVER['REMOTE_ADDR'],
			"modify_on" => date("Y-m-d H:i:s"),
			"entry_by" => $this->session->userdata("uid"),
			"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
			"entry_on" => date("Y-m-d H:i:s"),
			"is_absent" => 'N'); 

		//echo "<pre>";
		//	print_r($insert_exam_subjects);	
		$subjects = $this->input->post('chk_sub');
		//$this->Phd_examination_model->delete_subjects($insert_exam_subjects); // delete all student subject
		$prev_sub = $this->Phd_examination_model->fetch_prev_subjects($insert_exam_subjects); // fetch previous all student subject
		if(!empty($prev_sub)){
				foreach($prev_sub as $prvsub){
					$prv_sub_id[]= $prvsub['subject_id']; 
				}
		}
		if(!empty($subjects)){
				foreach($subjects as $cursub){
					$cursub1 = explode('~', $cursub);
					$curr_sub_id[]= $cursub1[0]; 
				}
		}
		
		foreach($subjects as $sub){
			$sub = explode('~', $sub);
			if (in_array($sub[0], $prv_sub_id)){
				//echo "inside";echo "<br>";
			}else{
				$insert_exam_subjects['subject_id']=$sub[0];
				$insert_exam_subjects['subject_code']= $sub[1];
				$insert_exam_subjects['semester']= $sub[2];
				$DB1->insert("phd_exam_applied_subjects", $insert_exam_subjects);
				//echo $DB1->last_query();echo "<br>";
				
			}
		}
		
		foreach($prev_sub as $prsub){
			$subject_id = $prsub['subject_id'];
			if (in_array($subject_id, $curr_sub_id)){
				//echo "by";echo "<br>";
			}else{
				$stud_id = $this->input->post('student_id');
				$stream_id = $this->input->post('stream_id');
				//$semester = $this->input->post('stream_id');
				$sql="DELETE FROM `phd_exam_applied_subjects` where subject_id ='$subject_id' and stud_id ='$stud_id' and stream_id ='$stream_id' and exam_id ='$exam_details[0]'";
				$DB1->query($sql);
			}
		}
		if(!empty($_POST['applicable_fee'])){
			$applicable_fee = $_POST['applicable_fee'];
			$exam_master_id = $prev_sub[0]['exam_master_id'];
			$update_exam_details=array(
			"exam_fees"=>$applicable_fee,
			"modify_by" => $this->session->userdata("uid"),
			"modify_from_ip" => $_SERVER['REMOTE_ADDR'],
			"modify_on" => date("Y-m-d H:i:s")
			); 
			$DB1->where('exam_master_id', $exam_master_id);	
			$DB1->update("exam_details", $update_exam_details); 
			//echo $DB1->last_query();exit;
		}

		$studprn = base64_encode($_POST['enrollment_no']);
		redirect('Phd_examination/view_form/'.$studprn);

	} 
	// 
	public function update_fee_details(){  
		$DB1 = $this->load->database('umsdb', TRUE);
		$fee_date = str_replace('/', '-', $_POST['dddate']);
		
		$fees_details =array(
			"student_id"=>$this->input->post('student_id'),
			"type_id"=>'4',
			"fees_paid_type"=>$this->input->post('ptype'),
			"receipt_no"=>$this->input->post('receipt_no'),
			"amount" => $this->input->post('ddamount'),
			"fees_date" => date('Y-m-d', strtotime($fee_date)),
			"bank_id" => $this->input->post('bank_id'),
			"bank_city" => $this->input->post('bank_city'),
			"academic_year" => ACADEMIC_YEAR,
			"modified_by" => $this->session->userdata("uid"),
			"modify_from_ip" => $_SERVER['REMOTE_ADDR'],
			"modified_on" => date("Y-m-d H:i:s")
		); 
		//echo "<pre>";
		//print_r($fees_details);	exit;
		$DB1->where('fees_id', $_POST['fees_id']);	
		$DB1->update("fees_details", $fees_details); 

		$studprn = base64_encode($_POST['enrollment_no']);
		redirect('Phd_examination/view_form/'.$studprn);

	} 
	public function list_examstudents(){
		//  echo "ex";exit;
		if($_POST){
		  
			$this->load->view('header',$this->data);        
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['ex_session'] =$_POST['exam_session'];
			$exam = explode('-', $_POST['exam_session']);
			$exam_id =$exam[2];
			$stream_id = $_POST['admission-branch'];
			$semester = $_POST['semester'];
			
			$this->data['emp_list']= $this->Phd_examination_model->list_exam_appliedStudents($exam_id);
			$this->data['exam_session']= $this->Phd_examination_model->fetch_stud_curr_exam();
			for($i=0;$i<count($this->data['emp_list']);$i++){
				$student_id =$this->data['emp_list'][$i]['stud_id'];
				
				$exam_month =$exam[0];
				
				$this->data['emp_list'][$i]['fees']=$this->Phd_examination_model->getFeedetails($student_id); // exam fees
			 
				$this->data['emp_list'][$i]['applicable_fee']=$this->Phd_examination_model->fetch_admissionApplicable_fees($student_id,$_POST['admission-branch'], $exam_year); // applicable_fee
				$this->data['emp_list'][$i]['tot_fees_paid']=$this->Phd_examination_model->get_tot_fee_paid($student_id, $exam_year); // tot fees
				//$this->data['emp_list'][$i]['subdetails']= $this->Phd_examination_model->get_subject_details($student_id,$stream_id,$semester);
				//$this->data['emp_list'][$i]['isPresent']=$this->Phd_examination_model->getExamformStatus($student_id,$exam_month,$exam_year);
	
			} 
		
			$this->data['course_details']= $this->Phd_examination_model->getCollegeCourse();
			$this->data['schools']= $this->Phd_examination_model->getSchools();
			$this->load->view($this->view_dir.'exam_student_list',$this->data);
			$this->load->view('footer');       
		}
		else{
      
			$this->load->view('header',$this->data);        
			$this->data['school_code'] ='';
			$this->data['admissioncourse'] = '';
			$this->data['stream'] = '';
			$this->data['semester'] = '';
	
			$college_id = 1;
			$this->data['exam_session']= $this->Phd_examination_model->fetch_stud_curr_exam();
			//$this->data['course_details']= $this->Phd_examination_model->getCollegeCourse();
			//$this->data['schools']= $this->Phd_examination_model->getSchools();
			$this->load->view($this->view_dir.'exam_student_list',$this->data);
			$this->load->view('footer');
      
		}
 
        
	}
	// insert and update
	public function hold_students(){    
		
		$checked_stud = $_POST['chk_stud'];
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		//print_r($_POST);exit;
		foreach($checked_stud as $stud){
			$stud_subjects = $this->Phd_examination_model->UpdateHoldStatus($stud,$exam_month, $exam_year);
							
		}
		//$emp_list =array();	
		$emp_list = $this->Phd_examination_model->list_exam_allstudents($_POST);
		for($i=0;$i<count($emp_list);$i++){
			$student_id =$emp_list[$i]['stud_id'];
			$emp_list[$i]['fees']=$this->Phd_examination_model->getFeedetails($student_id);
			$emp_list[$i]['isPresent']=$this->Phd_examination_model->getExamformStatus($student_id,$exam_month,$exam_year);
	
		} 			

		//$allstd = array();
		$allstd['ss'] = $emp_list;

		$str_output = json_encode($allstd);
		echo $str_output;

	} 
	function load_schools(){

		if($_POST["school_code"] !=''){
			
			//Get all city data
			$stream = $this->Phd_examination_model->get_courses($_POST["school_code"]);
            
			//Count total number of rows
			 $rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				//echo '<option value="0">All Course</option>';
				foreach($stream as $value){
					if($value['course_id']==15){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
					}
				}
			/*} else{
				echo '<option value="">Course not available</option>';
			}*/
		}
	}	
	function load_examsess_schools(){
		if(isset($_POST["exam_session"]) && !empty($_POST["exam_session"])){
			//Get all city data
			$stream = $this->Phd_examination_model->load_examsess_schools($_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select School</option>';
				//echo '<option value="All">All</option>';
				foreach($stream as $value){
					if(isset($_POST['school_code']) && ($_POST['school_code']==$value['school_code']))
					{
						 $sel = "selected";
					}
					else
					{
						$sel ='';
					}
					echo '<option value="' . $value['school_code'] . '" '.$sel.'>' . $value['school_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">School not available</option>';
			}
		}
	}
	function load_examsess_schools1(){
		if(isset($_POST["exam_session"]) && !empty($_POST["exam_session"])){
			//Get all city data
			$stream = $this->Phd_examination_model->load_examsess_schools($_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select School</option>';
				//echo '<option value="0">All School</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['school_code'] . '">' . $value['school_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">School not available</option>';
			}
		}
	}
	function load_exam_dates(){
		if(isset($_POST["exam_session"]) && !empty($_POST["exam_session"])){
			//Get all city data
			$stream = $this->Phd_examination_model->load_exam_dates($_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select School</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['school_code'] . '">' . $value['school_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">School not available</option>';
			}
		}
	}	
	function load_examschools(){
		if(isset($_POST["school_code"]) && !empty($_POST["school_code"])){
			//Get all city data
			$stream = $this->Phd_examination_model->get_examcourses($_POST["school_code"], $_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				foreach($stream as $value){
					if(isset($_POST['admission_course']) && ($_POST['admission_course']==$value['course_id']) )
					{
						$seel="selected";

					}
					else
					{
						$seel='';

					}
					echo '<option value="' . $value['course_id'] . '" '.$seel.' >' . $value['course_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">Course not available</option>';
			}
		}
	}	
	function load_streams(){
		//echo $_POST["course_id"];exit;
		if($_POST["course_id"] !=''){
			//Get all streams
			$stream = $this->Phd_examination_model->get_streams($_POST["course_id"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
			//	echo '<option value="0">All Stream</option>';
				foreach($stream as $value){

					/*if(isset($_POST['admission_branch']) && ($_POST['admission_branch']==$value['stream_id']))
					{
						$seel="selected";

					}
					else
					{
						$seel='';

					}*/
					echo '<option value="' . $value['stream_id'] . '" >' . $value['stream_name'] . '</option>';
				}
			/*} else{
				echo '<option value="">stream not available</option>';
			}*/
		}
	}
	// fetch exam strams
	function load_examstreams(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["course_id"]) && !empty($_POST["course_id"])){
			//Get all streams
			$stream = $this->Phd_examination_model->get_examstreams($_POST["course_id"], $_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
				foreach($stream as $value){
					if(isset($_POST['admission_branch']) && ($_POST['admission_branch']==$value['stream_id']))
					{
						$seel="selected";

					}
					else
					{
						$seel='';

					}
					echo '<option value="' . $value['stream_id'] . '" '.$seel.'>' . $value['stream_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">stream not available</option>';
			}
		}
	}
	// fetch exam strams
	function load_examsemesters(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			//echo $_POST["exam_session"];
			$stream = $this->Phd_examination_model->get_examsemester($_POST["stream_id"], $_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Semester</option>';
			//	echo '<option value="0">All Semester</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
				}
			} else{
				echo '<option value="">Semester not available</option>';
			}
		}
	}
	// approve_students 
	public function approve_students(){    
		$checked_stud = $_POST['chk_stud'];
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		//print_r($checked_stud);exit;
		foreach($checked_stud as $stud){
			$stud_subjects = $this->Phd_examination_model->UpdateApproveStatus($stud,$exam_month, $exam_year);
							
		}
		
		$emp_list = $this->Phd_examination_model->list_exam_allstudents($_POST);
		
		for($i=0;$i<count($emp_list);$i++){
			$student_id =$emp_list[$i]['stud_id'];
			$emp_list[$i]['fees']=$this->Phd_examination_model->getFeedetails($student_id);
			$emp_list[$i]['isPresent']=$this->Phd_examination_model->getExamformStatus($student_id,$exam_month,$exam_year);
	
		} 			

		$allstd = array();
		$allstd['ss'] = $emp_list;
		$str_output = json_encode($allstd);
		echo $str_output;

	}
	function hall_ticket($student_id){
		//load mPDF library
		//echo $student_id;
		$this->load->library('m_pdf');
		$this->load->model('Ums_admission_model');
		$stud_id = base64_decode($student_id);
		
		$exam= $this->Phd_examination_model->fetch_stud_curr_exam();
		$this->data['exam']=$exam;
		$exam_month =$exam[0]['exam_month'];
		$exam_year =$exam[0]['exam_year'];
		$exam_id =$exam[0]['exam_id'];
		$this->data['emp_per']= $this->Phd_examination_model->fetch_personal_details($stud_id);
		$this->data['sublist']= $this->Phd_examination_model->getSubjectTimetable($stud_id, $exam_month, $exam_year,$exam_id);


		
		$this->load->library('m_pdf', $param);
			
		$html = $this->load->view($this->view_dir.'indu_exam_hallticket', $this->data, true);
		$pdfFilePath = $this->data['emp_per'][0]['enrollment_no']."_exam_hallticket.pdf";
		
		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);

		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");  
		$this->m_pdf->pdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/exam/AUG2019/HallTicket/'.$pdfFilePath, 'F');
		
		
	} 
	// Report
	public function reports(){
		$this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		$college_id = 1;
		//$this->data['course_details']= $this->Phd_examination_model->getCollegeCourse();
		$this->data['exam_session']= $this->Phd_examination_model->fetch_stud_curr_exam();
		$exam_id = $this->data['exam_session'][0]['exam_id'];
		//$this->data['schools']= $this->Phd_examination_model->getExamAppledSchools($exam_id);
		$this->load->view($this->view_dir.'exam_reports',$this->data);
		$this->load->view('footer');
       
	}
	// generate reports
	function generateReports(){
		$this->load->model('Results_model');
		$StreamShortName =$this->Phd_examination_model->getStreamShortName($_POST['admission-branch']);
		$exam = explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$ex_session = $this->Phd_examination_model->fetch_exam_session_byid($exam_id);
		$exam_type =$ex_session[0]['exam_type'];
		$this->data['exam_session']= $ex_session;
		if($_POST['report_type']=='HallTicket'){      
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['emp_list']= $this->Phd_examination_model->exam_report_students($streamid='',$year='',$exam_id,$exam_type);
			for($i=0;$i<count($this->data['emp_list']);$i++){
				$student_id =$this->data['emp_list'][$i]['stud_id'];
				
				$this->data['emp_list'][$i]['emp_per']= $this->Phd_examination_model->fetch_personal_details($student_id);
				$this->data['emp_list'][$i]['sublist']= $this->Phd_examination_model->getSubjectTimetable($student_id, $exam_month, $exam_year,$exam_id);

			} 
			
			$this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'exam_hallticket', $this->data, true);
			$pdfFilePath = "HT-".$StreamShortName[0]['stream_short_name']."-".$_POST['semester']."-".$_POST['exam_session'].
			".pdf";
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
			//ob_end_clean();
		
		}elseif($_POST['report_type']=='HallTicket_excel'){
		    
		   $this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['emp_list']= $this->Phd_examination_model->get_excel_data($_POST,$exam_month,$exam_year, $exam_id);
				
			$this->load->view($this->view_dir.'exam_hallticket_excel',$this->data); 
		
		}elseif($_POST['report_type']=='AttendanceSheet'){
			//error_reporting(E_ALL);
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
		
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '-1');
			$this->load->library('m_pdf');
			//$mpdf=new mPDF();
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '65', '30');
			$sublist= $this->Phd_examination_model->fetchExamSubjects();
			//echo "<pre>";
			//print_r($sublist);exit;
			$content='<style>  
			table {  
			font-family: arial, sans-serif;  
			border-collapse: collapse;  
			width: 100%; font-size:12px; margin:0 auto;
			}  
			td{vertical-align: top;}
                      
			.signature{
			text-align: center;
			}
			p{padding:0px;margin:0px;}
			h1, h3{margin:0;padding:0}
			
			.content-table tr td{border:1px solid #333;vertical-align:middle;}
			.content-table th{border:1px solid #333;margin:40px}
			</style> ';
			$k=1;
			for($i=0;$i<count($sublist);$i++){
				
				$frmtime = explode(':', $sublist[$i]['from_time']);
				$totime = explode(':', $sublist[$i]['to_time']);
				$frmtime[0].':'.$frmtime[1].'-'.$totime[0].':'.$totime[1];
				$subject_id =$sublist[$i]['subject_id'];
				$subject_component =$sublist[$i]['subject_component'];
				$studlist= $this->Phd_examination_model->getSubjectStudentList($subject_id,$_POST['admission-branch'], $exam_month, $exam_year,$exam_id);
				$streamname= $this->Phd_examination_model->getStreamShortName($_POST['admission-branch']);
				
				$header ='<br><table cellpadding="0" cellspacing="0" border="0" align="center" width="900" style="margin-top:15px">
				<tr>
				<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="'.base_url().'assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
				<td style="font-weight:normal;text-align:center;">
				<h1 style="font-size:30px;">Sandip University</h1>
				<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

				</td>
				<td width="120" align="right" valign="middle" style="text-align:center;padding-top:20px;">
				<span style="border:0px solid #333;padding:10px;"><strong>Room No :</strong>_______</span></td>

				<tr>
				<td></td>
				<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:18px;">Attendance Sheet '.$exam_month.' - '.$exam_year.'</h3></td>
				<td></td>
				</tr>
				</table>
				<table class="content-table" width="900" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
				<tr>
				<td width="100" >&nbsp;<strong>Subject Code:</strong></td>
				<td >&nbsp;'.$sublist[$i]['subject_name'].' - '.$sublist[$i]['subject_code'].'</td>
				<td width="80" height="30">&nbsp;<strong>Date:</strong> </td>
				<td >&nbsp;'.date('d/m/Y', strtotime($sublist[$i]['date'])).'</td>

							
				</tr>
						   
				<tr>
				<td valign="middle">&nbsp;<strong>School Name:</strong></td>
				<td valign="middle">&nbsp;'.$sublist[$i]['school_short_name'].'</td>
				<td valign="middle">&nbsp;<strong>Time:</strong></td>
				<td valign="middle">&nbsp; '.$frmtime[0].':'.$frmtime[1].'-'.$totime[0].':'.$totime[1].'</td>
				</tr>
				<tr>
				<td width="100" height="30" valign="middle">&nbsp;<strong>Stream:</strong></td>
				<td  valign="middle">&nbsp;'.$streamname[0]['stream_name'].'</td>
				<td width="80" height="30" valign="middle">&nbsp;<strong>Semester</strong> </td>
				<td height="30" valign="middle">&nbsp;'.$sublist[$i]['semester'].'</td>
						   
				</tr>
				</table>';

				$content .='<table border="0" cellspacing="5" cellpadding="5" class="content-table" width="900"  style="height:800px;margin-top:20px; position: relative;">
				<tr>
				<th width="50" height="30">Sr No.</th>
				<th>PRN</th>
				<th align="left">Name</th>
				<th>Ans.Booklet No</th>
				<th>Candidate.Sign</th>
				</tr>';
			
				$j=1;
				if(!empty($studlist)){
					foreach($studlist as $stud){
						//echo $stud['enrollment_no'];
						if($subject_component=='EM'){
							$fsubtype=$this->Results_model->get_failed_sub_type1($stud['stud_id'], $subject_id);
						}
						if($subject_component=='EM' && $fsubtype[0]['grade']=='U'){ 
							$fvar="<small>(".$fsubtype[0]['failed_sub_type'].")</small>"; 
						}else{
							$fvar="";
						}
						$sr_no = $j;
						$content .='<tr>
						<td height="30" align="center">'.$sr_no.'</td>
						<td>'.$stud['enrollment_no'].'</td>
						<td>'.$stud['first_name'].' '.$stud['middle_name'].' '.$stud['last_name'].' '.$fvar.'</td>
						<td></td>
						<td></td>
						</tr>';
			
						$j++;
					}
				}
			
       
				$content .='</table>';	
			
				$footer .='<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:15px;">
				<tr>
				<td align="center">
				<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  
  
				<tr>
				<td align="left" class="signature" valign="bottom"><strong>Present :</strong></td>
    
				<td align="left"  class="signature" valign="bottom"><strong>Absent :</strong></td>
   
				<td align="left" class="signature" valign="bottom"><strong>Total :</strong></td>
    
				<td valign="bottom" align="right" width="150" class="signature"  style="border-top:1px solid #000;padding-top:5px;"><strong>Invigilator Signature</strong></td>
   
				</tr>
				</table>

				</td>
				</tr>
				</table><div align="center" style="font-size:10px;"><small>{PAGENO}</small></div>';	

				//$this->m_pdf->pdf->AddPage(); 			 
				//ob_clean();
				$this->m_pdf->pdf->PageNumSubstitutions[] = [
					'from' => 1, 
					'reset' => 0, 
					'type' => 'I', 
					'suppress' => 'off'
				];
				$this->m_pdf->pdf->defaultfooterline = false;
				$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLHeader($header1);		
				$this->m_pdf->pdf->SetHTMLFooter($footer);
				//$this->m_pdf->pdf->setFooter('{PAGENO}');
				$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->AddPage();
			
				$this->m_pdf->pdf->WriteHTML($content);
				//$footer = $this->load->view($this->view_dir.'attendance_footer', $this->data, true);	
				
				unset($header1);
				unset($header);
				unset($content);
				unset($footer);
				unset($studlist);

 	
				ob_clean();
			} 
			$pdfFilePath1 ="AS-".$StreamShortName[0]['stream_short_name']."-".$_POST['semester']."-".$_POST['exam_session'].
			".pdf";			
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
			//ob_clean();
		}	
		elseif($_POST['report_type']=='SeatingArrangement'){
			
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['sublist']= $this->Phd_examination_model->fetchExamSubjects();
			for($i=0;$i<count($this->data['sublist']);$i++){
				$subject_id =$this->data['sublist'][$i]['subject_id'];
				$this->data['sublist'][$i]['studlist']= $this->Phd_examination_model->getSubjectStudentList($subject_id,$_POST['admission-branch'], $exam_month, $exam_year,$exam_id);

			} 
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '-1');
			$this->load->library('m_pdf');
			
			ob_clean();
			$html = $this->load->view($this->view_dir.'seatingArrangement_report', $this->data, true);
			
			$pdfFilePath1 ="SA-".$StreamShortName[0]['stream_short_name']."-".$_POST['semester']."-".$_POST['exam_session'].
			".pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
			//ob_clean();
		}elseif($_POST['report_type']=='SeatingArrangement_excel'){		    
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];	
			$this->data['sublist']= $this->Phd_examination_model->fetchExamSubjects();			
			for($i=0;$i<count($this->data['sublist']);$i++){
				$subject_id =$this->data['sublist'][$i]['subject_id'];
				$this->data['sublist'][$i]['studlist']= $this->Phd_examination_model->getSubjectStudentList($subject_id,$_POST['admission-branch'], $exam_month, $exam_year, $exam_id);
			} 				
			$this->load->view($this->view_dir.'seatingArrangement_report_excel',$this->data); 
		
		}elseif($_POST['report_type']=='Timetable'){
			$this->load->model('Exam_timetable_model');
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['exam_sess']= $exam_month.'-'.$exam_year;
			$this->data['stream_name']=$StreamShortName[0]['stream_short_name'];
			
			$this->data['ex_dt']= $this->Phd_examination_model->fetch_examTimetable($_POST, $exam_month, $exam_year);
			$this->load->library('m_pdf');
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '15', '15');
			$html = $this->load->view($this->view_dir.'exam_timetable_pdf', $this->data, true);
			$pdfFilePath = "HT-".$StreamShortName[0]['stream_short_name']."-".$_POST['semester']."-".$_POST['exam_session'].
			".pdf";
			$footer ='<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  
  <tr>
    <td align="center" class="signature" height="50" >&nbsp;</td>
    <td align="center" class="signature">&nbsp;</td>
    <td align="center" class="signature">&nbsp;</td>
   
  </tr>
  <tr>
    <td align="center" height="50" class="signature"><strong>Student Signature</strong></td>
    <td align="center" height="50" class="signature"><strong>Dean Signature</strong></td>
    <td align="center" height="50" class="signature"><strong>COE Signature</strong></td>
   
  </tr>
</table>';
			$this->m_pdf->pdf->SetHTMLFooter($footer);
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
			
			
		}
	}
	// Report
	public function attendandReport(){
		$this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		$college_id = 1;
		//$this->data['course_details']= $this->Phd_examination_model->getCollegeCourse();
		$this->data['exam_session']= $this->Phd_examination_model->fetch_stud_curr_exam();
		$exam_id = $this->data['exam_session'][0]['exam_id'];
		//$this->data['schools']= $this->Phd_examination_model->getExamAppledSchools($exam_id);
		$this->load->view($this->view_dir.'exam_attreports',$this->data);
		$this->load->view('footer');
       
	}
	public function attendance(){
		$this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		$college_id = 1;
		//$this->data['course_details']= $this->Phd_examination_model->getCollegeCourse();
		$this->data['exam_session']= $this->Phd_examination_model->fetch_stud_curr_exam();
		$this->data['fetch_cycle']= $this->Phd_examination_model->fetch_cycle();
		$exam_id = $this->data['exam_session'][0]['exam_id'];
		//$this->data['schools']= $this->Phd_examination_model->getExamAppledSchools($exam_id);
		$this->load->view($this->view_dir.'exam_attendance',$this->data);
		$this->load->view('footer');
       
	}	
	// generate reports
	function generateAttendantReports(){
		if($_POST){
			//$this->load->view('header',$this->data);        
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['course_details']= $this->Phd_examination_model->getCollegeCourse();
			$this->data['schools']= $this->Phd_examination_model->getSchools();
			$exam= $this->Phd_examination_model->fetch_stud_curr_exam();
			
			$this->data['sublist']= $this->Phd_examination_model->fetchExamSubjects();
			$this->data['exam_session']= $this->Phd_examination_model->fetch_stud_curr_exam();
			//print_r($this->data['sublist']);exit;
			
			for($i=0;$i<count($this->data['sublist']);$i++){
				$subject_id =$this->data['sublist'][$i]['subject_id'];
				$exam_month =$exam[0]['exam_month'];
				$exam_year =$exam[0]['exam_year'];
				$this->data['sublist'][$i]['studlist']= $this->Phd_examination_model->getSubjectStudentList($subject_id,$_POST['admission-branch'], $exam_month, $exam_year);

			} 
			
			$this->load->library('m_pdf', $param);
			
			$html = $this->load->view($this->view_dir.'exam_attendent_report', $this->data, true);
			$pdfFilePath = $_POST['school_code']."_exam_form.pdf";

			//$mpdf->WriteHTML($stylesheet,1);
			//$this->m_pdf->pdf->WriteHTML($stylesheet,1);

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");   
		}	
	}
	// Report
	public function daywise_reports(){
		$this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
		$exam= $this->Phd_examination_model->fetch_stud_curr_exam();	
		$this->data['exam_session'] =$exam;		
		$exam_id =$exam[0]['exam_id'];
		
		$this->data['ex_dates']= $this->Phd_examination_model->fetch_examdates($exam_id);
		$this->load->view($this->view_dir.'QPexam_reports',$this->data);
		$this->load->view('footer');
       
	}
	
	function download_daywise_reports_pdf(){
	   // error_reporting(E_ALL); ini_set('display_errors', '1'); 
	    if($_POST['download_type']=='PDF'){
			$exam = explode('-', $_POST['exam_session']);
			$exam_month =$exam[0];
			$exam_year =$exam[1];
			$exam_id =$exam[2];
			
			$this->data['exam_sess'] = $this->Phd_examination_model->fetch_exam_session_byid($exam_id);
			$exam_done_in_curr_year = $this->Phd_examination_model->fetch_exam_count_in_year($exam_year);
			$exam_cnt =$exam_done_in_curr_year[0]['cnt'];
			$exyr= date('y');
			//print_r($exam_cnt);exit;
    		if($_POST['report_type']=='Daywise'){
    			$exam_date = $_POST['exam_date'];
    			ini_set('max_execution_time', 0);
    			ini_set('memory_limit', '-1');
    			$this->load->library('m_pdf');
    			//$mpdf=new mPDF();
    			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '', '', '15', '5', '55', '35');
    						
    			//echo "<pre>";
    			//print_r($sublist);exit;
    			$content='<style>  
    			table {  
    			font-family: arial, sans-serif;  
    			border-collapse: collapse;  
    			width: 100%; font-size:12px; margin:0 auto;
    			}  
    			td{vertical-align: top;}
                          
    			.signature{
    			text-align: center;
    			}
    			p{padding:0px;margin:0px;}
    			h1, h3{margin:0;padding:0}
    			
    			.content-table tr td{border:1px solid #333;vertical-align:middle;}
    			.content-table th{border:1px solid #333;margin:40px}
				@media print {
				   thead{display: table-header-group;}
				}
    			</style> ';
    			$k=1;
				$j=$exyr.''.$exam_cnt.'001';
				$stream_arr = array('5','6','7','8','9','10','11','96','97','107','108','109','158','159','162');
				$stream_arr1 = array(43,44,45,46,47,66,67,117);
    			for($i=0;$i<count($exam_date);$i++){
    				//$examslots= $this->Phd_examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id);
					//echo "<pre>";print_r($examslots);
					//echo $_POST['exam_timing'];exit;
					if($_POST['exam_timing']=='morning'){
						$examslots[]= array("from_time"=>'10:00:00',"to_time"=>'01:00:00');
					}else if($_POST['exam_timing']=='Afternoon'){
						$examslots[]= array("from_time"=>'02:00:00',"to_time"=>'05:00:00');
					}else{
						$examslots= $this->Phd_examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id);
					}
					
					//print_r($examslots1);exit;
    				foreach($examslots as  $slot){
						$slot_from = $slot['from_time'];
						$slot_to = $slot['to_time'];
						
						$examdetails= $this->Phd_examination_model->exam_daywiseqpindend_report($exam_date[$i],$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);
						
						//print_r($examdetails);exit;
						if(!empty($examdetails)){
							
							$timestamp = strtotime($examdetails[0]['date']);
							$day = date('l', $timestamp);
							$fromtime= explode(':', $examdetails[0]['from_time']);
							$totime= explode(':', $examdetails[0]['to_time']);
							$date_exam = date('d/m/Y', strtotime($examdetails[0]['date']));
							//exit;
							$header ='<table cellpadding="0" cellspacing="0" border="0" align="center" width="900" style="margin:40px;margin-top:15px">
							<tr>
							<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="https://erp.sandipuniversity.com/assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
							<td style="font-weight:normal;text-align:center;">
							<h1 style="font-size:30px;">Sandip University</h1>
							<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>
			
							</td>
							<td width="120" align="right" valign="middle" style="text-align:center;">
							</td>
							</tr>
							<tr>
							<td></td>
							<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>DAY WISE QP REQUIREMENT -'.$exam_month.' - '.$exam_year.'</h3></td>
							<td></td>
							</tr>
							</table>
							
							<table class="content-table" width="800" cellpadding="3" cellspacing="0" border="1" align="center" style="font-size:12px;overflow: hidden;">		   
							<tr>
							<td width="100" height="30"><strong>Date :</strong> '.$date_exam.'</td>					
							<td width="100" height="30"><strong>Day :</strong> '.$day.'</td>
							<td width="100" height="30"><strong>Time :</strong> '.$fromtime[0].':'.$fromtime[1].'-'.$totime[0].':'.$totime[1].'</td>
							</tr>
							</table>';
			
							$content ='<table border="1" cellpadding="3" cellspacing="0" class="content-table" width="800" height="800" style="font-size:12px;">
							<thead>
							<tr>
							<th align="center">S.No.</th>
							<th align="center">Name of the Programme </th>
							<th align="center">Name of the Course</th>
							<th align="center">Course Code</th>
							<th align="center">Sem</th>
							<th align="center">Total Strength</th>
							<th align="center">Exam Applied</th>
							<th align="center">QP Count</th>
							<th align="center">Remark</th>
							</tr></thead>';
						
							$content .='<tbody>';
							$regu_crr="";
							if(!empty($examdetails)){
								foreach($examdetails as $exd){
									
									//$examdetails= $this->Phd_examination_model->checkExamSemester($exd['subject_id'],$exam_month,$exam_year,$exam_id);
									/*if($exd['semester'] == $exd['curr_sem']){
										$subappliedstud = $this->Phd_examination_model->subject_applied_count($exd['subject_id'],$exd['stream_id'],$exd['semester'],$exam_year);
										$applied_cnt = $subappliedstud[0]['applied_cnt'];
									}else{*/
										// total backlog subject count
										$subappliedstud = $this->Phd_examination_model->subject_applied_count_bklog($exd['subject_id'],$exd['stream_id'],$exd['semester'],$exam_id);
										$applied_cnt = $subappliedstud[0]['applied_cnt'];
										// total stud sub applied count
										if($this->data['exam_sess'][0]['exam_type']=='Regular'){
											if($exd['curr_sem']!=$exd['semester']){
												$totsubappliedstud = $this->Phd_examination_model->stud_arrear_subjectcount($exd['subject_id'],$exd['stream_id'],$exd['semester'],$exam_id);
											}else{
												$totsubappliedstud = $this->Phd_examination_model->stud_applied_subjectcount($exd['subject_id'],$exd['stream_id'],$exd['semester'],$exam_id);
											}
										}else{
											$totsubappliedstud = $this->Phd_examination_model->stud_arrear_subjectcount($exd['subject_id'],$exd['stream_id'],$exd['semester'],$exam_id);
										}
										
										
										$totsubapplied_cnt = $totsubappliedstud[0]['sub_applied_cnt'];
									//}
									$exam_subappliedstud = $this->Phd_examination_model->exam_applied_subjectcount($exd['subject_id'],$exd['stream_id'],$exd['semester'],$exam_id);
									$exam_applied_cnt = $exam_subappliedstud[0]['exam_applied_cnt'];
									if($totsubapplied_cnt==0){
										$totsubapplied_cnt = $applied_cnt;
									}else{
										$totsubapplied_cnt = $totsubapplied_cnt;
									}
									
									$fromtime= explode(':', $exd['from_time']);
									$totime= explode(':', $exd['to_time']);
									if($exam_applied_cnt==0){
										$qp_count = 0;
									}elseif($exam_applied_cnt <= 5){
										$qp_count = $exam_applied_cnt +3;
									}elseif($exam_applied_cnt > 5 && $exam_applied_cnt <= 50){
										$qp_count = $exam_applied_cnt +5;
									}elseif($exam_applied_cnt > 50 && $exam_applied_cnt <= 100){
										$qp_count = $exam_applied_cnt +10;
									}elseif($exam_applied_cnt > 100){
										$qp_count = $exam_applied_cnt +15;
									}else{
										$qp_count = $exam_applied_cnt;
									}

									if($regu_crr==""){
											$regu_display=$exd['batch'];
											$regu_crr=$exd['batch'];	
									}
									else if($regu_crr==$exd['batch']) {
										$regu_display='';
									}else{
										//$regu_crr="";
										$regu_display=$exd['batch'];
										$regu_crr=$exd['batch'];	
									}
									
									if($regu_display !=''){
									$content .='<tr>
									<td align="left" colspan="9"><b>Batch: '.$regu_display.'</b></td>

									</tr>';
									}
									if($exd['batch']=='2017' && ($exd['semester']==1 || $exd['semester']==2) && in_array($exd['stream_id'],$stream_arr)){
										$strmname='B.Tech First Year';
									}else if($exd['batch']=='2017' && ($exd['semester']==1 || $exd['semester']==2) && in_array($exd['stream_id'],$stream_arr1)){
										$strmname='B.Sc First Year';
									}else{
										$strmname=$exd['stream_short_name'];
									}
									$sum_totsubapplied_cnt[] = $totsubapplied_cnt;
									$sum_exam_applied_cnt[] = $exam_applied_cnt;
									$sum_qp_count[] = $qp_count;
									
									$content .='<tr>
									<td align="center">'.$j.'</td>
									<td>'.$strmname.'</td>
									<td >'.strtoupper($exd['subject_name']).'</td>
									<td align="center">'.strtoupper($exd['subject_code']).'</td>
									<td align="center">'.$exd['semester'].'</td>
									<td align="center">'.$totsubapplied_cnt.'</td>
									<td align="center">'.$exam_applied_cnt.'</td>
									<td align="center">'.$qp_count.'</td>
									<td style="width:100px;"></td>
									</tr>';
						
									$j++;
									$k++;
									unset($applied_cnt);
									unset($exam_applied_cnt);
									unset($qp_count);
								}
								
							}
							$content .='<tr>
									<td align="center" colspan=5>TOTAL</td>
									<td align="center">'.array_sum($sum_totsubapplied_cnt).'</td>
									<td align="center">'.array_sum($sum_exam_applied_cnt).'</td>
									<td align="center">'.array_sum($sum_qp_count).'</td>
									<td style="width:100px;"></td>
									</tr>';
							$content .='</tbody>';
							unset($sum_totsubapplied_cnt);
							unset($sum_exam_applied_cnt);
							unset($sum_qp_count);	
							$content .='</table>';	
							//echo $header;echo $content;exit;
							$footer .='<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:40px;margin-bottom:10px;font-size:12px;">
							<tr>
							<td align="center">
							<table width="900" border="0" cellspacing="0" cellpadding="0" align="center"> 
							<tr>
							<td align="left" class="signature" valign="bottom"><strong>Checked By </strong></td>
							<td align="center" class="signature" valign="bottom"><strong>Counter Checked By </strong></td>    
							<td align="right" class="signature" valign="bottom"><strong>COE Signature </strong></td>
							</tr>
							<tr>			 
							<td align="right" class="signature" valign="bottom" colspan=3>&nbsp;</td>
							</tr>
							<tr>			 
							<td align="right" class="signature" valign="bottom" colspan=3><small style="font-size:10px;">Printed on: '.date('d-m-Y H:i:s').' </small></td>
							</tr>
							</table>
			
							</td>
							</tr>
							</table>';	
			
							//$this->m_pdf->pdf->AddPage(); 			 
							//ob_clean();
							$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1, 
								'reset' => 0, 
								'type' => 'I', 
								'suppress' => 'off'
							];
							$this->m_pdf->pdf->defaultfooterline = false;
							$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
							$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
							
							$this->m_pdf->pdf->setFooter('{PAGENO}');
							$this->m_pdf->pdf->SetHTMLHeader($header1);		
							$this->m_pdf->pdf->SetHTMLFooter($footer);
							$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
							$this->m_pdf->pdf->AddPage();						
							$this->m_pdf->pdf->WriteHTML($content);
							//$footer = $this->load->view($this->view_dir.'attendance_footer', $this->data, true);	
							
							unset($header1);
							unset($header);
							unset($content);
							unset($footer);
							unset($examdetails);
			
				
							ob_clean();
						}
					} 
    			}
    			$pdfFilePath = "DatewiseQpReport.pdf";
    			//download it.
    			$this->m_pdf->pdf->Output($pdfFilePath, "D");
    			
    			//ob_end_clean();
    		
    		}elseif($_POST['report_type']=='Absent'){
			    
				$exam_date = $_POST['exam_date'];
				ini_set('max_execution_time', 0);
				ini_set('memory_limit', '-1');
				$this->load->library('m_pdf');
				//$mpdf=new mPDF();
				$this->m_pdf->pdf=new mPDF('utf-8', 'A4-L', '', '', '15', '15', '50', '30');
						
				//echo "<pre>";
				//print_r($sublist);exit;
				$content='<style>  
				table {  
				font-family: arial, sans-serif;  
				border-collapse: collapse;  
				width: 100%; font-size:12px; margin:0 auto;
				}  
				td{vertical-align: top;padding:7px;}
                      
				.signature{
				text-align: center;
				}
				p{padding:0px;margin:0px;}
				h1, h3{margin:0;padding:0}
			
				
				.content-table th{border:1px solid #333;margin:40px}
				</style> ';
				$k=1;
				for($i=0;$i<count($exam_date);$i++){
					if($_POST['exam_timing']=='morning'){
						$examslots[]= array("from_time"=>'10:00:00',"to_time"=>'01:00:00');
					}else if($_POST['exam_timing']=='Afternoon'){
						$examslots[]= array("from_time"=>'02:00:00',"to_time"=>'05:00:00');
					}else{
						$examslots= $this->Phd_examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id);
					}
					foreach($examslots as  $slot){
						$slot_from = $slot['from_time'];
						$slot_to = $slot['to_time'];
						$examdetails= $this->Phd_examination_model->exam_daywise_dispatch_report($exam_date[$i],$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);
						if(!empty($examdetails)){
							$timestamp = strtotime($examdetails[0]['date']);
							$day = date('l', $timestamp);
							$fromtime= explode(':', $examdetails[0]['from_time']);
							$totime= explode(':', $examdetails[0]['to_time']);
							$date_exam = date('d/m/Y', strtotime($examdetails[0]['date']));
							//exit;
							$header ='<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin:20px;margin-top:15px">
							<tr>
							<td width="80" align="right" valign="bottom" style="text-align:center;padding-top:10px;"><img src="http://erp.sandipuniversity.com/assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
							<td style="font-weight:normal;text-align:center;">
							<h1 style="font-size:30px;">Sandip University</h1>
							<p>Mahiravani, Trimbak Road, Nashik - 422 213</p>

							</td>
							<td width="120" align="right" valign="middle" style="text-align:center;font-size:20px;"><h3>COE</h3>
							</td>
							</tr>
							<tr>
							<td></td>
							<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>DISPATCH OF ANSWER PAPER PACKETS -'.$exam_month.' - '.$exam_year.'</h3></td>
							<td></td>
							</tr>
							</table>
						
							<table class="content-table" width="100%" cellpadding="3" cellspacing="0" border="1" align="center" style="font-size:12px;overflow: hidden;">		   
							<tr>
							<td width="100" height="30"><strong>Date :</strong> '.$date_exam.'</td>					
							<td width="100" height="30"><strong>Day :</strong> '.$day.'</td>
							<td width="100" height="30"><strong>Time :</strong> '.$fromtime[0].':'.$fromtime[1].'-'.$totime[0].':'.$totime[1].'</td>
							</tr>
							</table>';

							$content ='<table border="1" cellpadding="3" cellspacing="0" class="content-table" width="100%" height="600" style="font-size:12px;">
							<tr>
							<th align="center">S.No.</th>
							<th align="center" width="150">Degree & Semester </th>
							<th align="center">Course Code and Name</th>
							<th align="center">Reg.</th>
							<th align="center">Pre.</th>
							<th align="center">Ab.</th>
							<th align="center">#Malpra.</th>
							<th align="center">Absentee Reg.Nos.</th>
							<th align="center">No of Scripts</th>
							<th align="center">Bundle Nos.</th>
							</tr>';
					
							$j=1;
							$tot_peresent =array();
							if(!empty($examdetails)){
								foreach($examdetails as $exd){
									$fromtime= explode(':', $exd['from_time']);
									$totime= explode(':', $exd['to_time']);
									$sub_id = $exd['subject_id'];
									$stream_id = $exd['stream_id'];
									$present_students= $this->Phd_examination_model->exam_daywise_present_students($exam_date[$i],$sub_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);
									
									$absent_students= $this->Phd_examination_model->exam_daywise_absent_students($exam_date[$i],$sub_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);
									
									$malpractice_students= $this->Phd_examination_model->exam_daywise_malpractice_students($exam_date[$i],$sub_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);
									//print_r($absent_students);
									foreach ($absent_students as $ab){
										$ab_commaList[] = $ab['enrollment_no'];
									}
									$absentlist = implode(', ', $ab_commaList);
									if(!empty($absentlist)){
										$absentlist = $absentlist;
									}else {
										$absentlist ='-';
									}
									$cnt_absent_students = count($absent_students);
									$cnt_present_students = count($present_students);
									$cnt_malpractice_students = count($malpractice_students);
									$cnt_TOTREG = (int)$cnt_present_students + (int)$cnt_absent_students;
									$tot_regestered[] = $cnt_TOTREG;
									$tot_peresent[] = $cnt_present_students;
									$tot_absent[] = $cnt_absent_students;
									$tot_malpract[] = $cnt_malpractice_students;
									$scripts = (int)$cnt_TOTREG - (int)$cnt_absent_students;
									//echo $ab_commaList;exit;
									$content .='<tr>
									<td valign="top">'.$j.'</td>
									<td valign="top">'.$exd['stream_short_name'].'-'.$exd['semester'].'-'.$exd['subject_id'].'</td>
									<td valign="top">'.strtoupper($exd['subject_code']).'-'.strtoupper($exd['subject_name']).'</td>
									<td valign="top">'.$cnt_TOTREG.'</td>
									<td valign="top">'.$cnt_present_students.'</td>
									<td valign="top">'.$cnt_absent_students.'</td>
									<td valign="top">'.$cnt_malpractice_students.'</td>
									<td align="center">'.$absentlist.'</td>
									<td align="center">'.$scripts.'</td>
									<td align="center"></td>
									</tr>';
					
									$j++;
									unset($absent_students);
									unset($ab_commaList);
									unset($scripts);
								}
							}
							$total_scripts= array_sum($tot_regestered)-array_sum($tot_absent);	
							$content .='<tr>
									<td colspan="3"><b>Total</b></td>
									<td valign="top">'.array_sum($tot_regestered).'</td>
									<td valign="top">'.array_sum($tot_peresent).'</td>
									<td valign="top">'.array_sum($tot_absent).'</td>
									<td valign="top">'.array_sum($tot_malpract).'</td>
									<td align="center"></td>
									<td align="center">'.$total_scripts.'</td>
									<td align="center"></td>
									</tr>';
									
							$content .='</table>';	
							//echo $header;echo $content;exit;
							$footer .='<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:40px;font-size:12px;">
							<tr>
							<td align="center">
							<table width="900" border="0" cellspacing="0" cellpadding="0" align="center"> 
							<tr>
							<td align="left" class="signature" valign="bottom"><strong>Handed Over by :</strong></td>   
							<td align="center"  class="signature" valign="bottom"><strong>Total Answer Packets</strong></td>  
							<td align="right" class="signature" valign="bottom"><strong>Taken Over By :</strong></td>
							</tr>
							<tr>
							<td>&nbsp;</td>   
							
							</tr>
							<tr>
							<td align="left" class="signature" valign="bottom"><strong>Signature of the SUP 1 :</strong></td>   
							<td align="center"  class="signature" valign="bottom"><strong>Signature of the SUP 2</strong></td>  
							<td align="right" class="signature" valign="bottom"><strong></strong></td>
							</tr>
							</table>

							</td>
							</tr>
							</table>';	
		//echo $content;exit;
							//$this->m_pdf->pdf->AddPage(); 			 
							//ob_clean();
							$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1, 
								'reset' => 0, 
								'type' => 'I', 
								'suppress' => 'off'
							];
							$this->m_pdf->pdf->defaultfooterline = false;
							$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
							$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
							$this->m_pdf->pdf->SetHTMLHeader($header1);		
							$this->m_pdf->pdf->SetHTMLFooter($footer);
							//$this->m_pdf->pdf->setFooter('{PAGENO}');
							$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
							$this->m_pdf->pdf->AddPage();
					
							$this->m_pdf->pdf->WriteHTML($content);
							//$footer = $this->load->view($this->view_dir.'attendance_footer', $this->data, true);	
						
							unset($header1);
							unset($header);
							unset($content);
							unset($footer);
							unset($examdetails);
							
							unset($tot_regestered);
							unset($tot_peresent);unset($tot_absent);unset($tot_malpract);
			
							ob_clean();
						}
					}
				} 
				$date_file = date('d-m-Y', strtotime($exam_date[0]));
				$pdfFilePath = $date_file."_DispatchReport.pdf";
				//download it.
				$this->m_pdf->pdf->Output($pdfFilePath, "D");
			
				//ob_end_clean();
			}elseif($_POST['report_type']=='Answerbooklets'){
			    
			    $exam_date = $_POST['exam_date'];
			    ini_set('max_execution_time', 0);
			    ini_set('memory_limit', '-1');
			    $this->load->library('m_pdf');
			    //$mpdf=new mPDF();
			    $this->m_pdf->pdf=new mPDF('utf-8', 'A4-L', '15', '15', '15', '15', '35', '20');
			    
			    //echo "<pre>";
			    //print_r($sublist);exit;
			    $content='<style>
				table {
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 100%; font-size:12px; margin:0 auto;
				}
				td{vertical-align: top;}
			        
				.signature{
				text-align: center;
				}
				p{padding:0px;margin:0px;}
				h1, h3{margin:0;padding:0}
			        
				.content-table tr td{border:1px solid #333;vertical-align:top;padding:10px;}
				.content-table th{border:1px solid #333;margin:40px}
				</style> ';
			    $k=1;
			    for($i=0;$i<count($exam_date);$i++){
			       if($_POST['exam_timing']=='morning'){
						$examslots[]= array("from_time"=>'10:00:00',"to_time"=>'01:00:00');
					}else if($_POST['exam_timing']=='Afternoon'){
						$examslots[]= array("from_time"=>'02:00:00',"to_time"=>'05:00:00');
					}else{
						$examslots= $this->Phd_examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id);
					}
					foreach($examslots as  $slot){
						$slot_from = $slot['from_time'];
						$slot_to = $slot['to_time'];
						$examdetails= $this->Phd_examination_model->exam_daywise_dispatch_report($exam_date[$i],$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);
						if(!empty($examdetails)){
							$timestamp = strtotime($examdetails[0]['date']);
							$day = date('l', $timestamp);
							$fromtime= explode(':', $examdetails[0]['from_time']);
							$totime= explode(':', $examdetails[0]['to_time']);
							$date_exam = date('d/m/Y', strtotime($examdetails[0]['date']));
							//exit;
							$header ='<br><table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
							<tr>
							<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="http://sandipuniversity.com/erp/assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
							<td style="font-weight:normal;text-align:center;">
							<h1 style="font-size:30px;">Sandip University</h1>
							<p>Mahiravani, Trimbak Road, Nashik - 422 213</p>
								
							</td>
							<td width="120" align="right" valign="middle" style="text-align:center;">
							</td>
							</tr>
							<tr>
							<td></td>
							<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>ANSWER BOOKLETS FOR -'.$exam_month.' - '.$exam_year.'</h3></td>
							<td></td>
							</tr>
							</table>';
							
							
							$content ='';
							$j=1;
							//echo count($examdetails);exit;
							if(!empty($examdetails)){
								foreach($examdetails as $exd){
									$course_code = $exd['subject_code'].'-'.$exd['subject_name'];
									$stream_name = $exd['stream_short_name'];
									$content .='<table class="content-table" width="100%" cellpadding="5" cellspacing="5" border="1" align="center" style="font-size:12px;xoverflow: hidden;">
									<tr>
									<td width="31%"><strong>Course Code and Name :</strong> '.strtoupper($course_code).'</td>
									<td width="31%" valign="top"><strong>Date/ Day :</strong> '.$date_exam.', '.$day.'</td>
									<td width="31%" valign="top"><strong>Time :</strong> '.$fromtime[0].':'.$fromtime[1].'-'.$totime[0].':'.$totime[1].'</td>
									</tr>
									<tr>
									<td><strong>Programme :</strong> '.$stream_name.'</td>
									<td><strong>Bundle No. :</strong>_________</td>
									<td><strong>Board :</strong>___________</td>
									</tr>
									';
									
									$fromtime= explode(':', $exd['from_time']);
									$totime= explode(':', $exd['to_time']);
									$stream_id = $exd['stream_id'];
									$absent_students= $this->Phd_examination_model->exam_daywise_absent_students($exam_date[$i],$exd['subject_id'],$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);
									$present_students= $this->Phd_examination_model->exam_daywise_present_students($exam_date[$i],$exd['subject_id'],$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);
									//print_r($absent_students[1]['enrollment_no']);exit;
									$cnt_present = count($present_students);
									$cnt_absent = count($absent_students);
									foreach ($absent_students as $ab){
										$ab_commaList[] = $ab['enrollment_no'];
									}
									//$absentlist = implode(', ', $ab_commaList);
								   
									//$stud_prn = $absentlist;
									$content .='
									<tr>
										   <td valign="top" colspan="3" style="height:440px">
												<table class="content-table" width="80%" cellpadding="4" cellspacing="4" border="1">
													<tr>';
									$count=0;
									foreach ($present_students as $pre){
										if($count ==11) {
											$count = 0;
											$content .='<tr>&nbsp;</tr>';
										}
										$content .='<td style="white-space:wrap;">'.$pre['enrollment_no'].'</td>';
										$count++;
									}
							
									$content .='</tr></table>
											</td>       
									</tr>
									<tr>
									<td height="30" colspan="2"><strong>Absentee Register Nos. :</strong>';
									foreach ($absent_students as $ab){
										$content .='<span>'.$ab['enrollment_no'].', </span>';
									}
									$content .='</td>
									<td height="30"><strong>Total Absentee. : </strong>'.$cnt_absent.'</td>
								   
									</tr>
									<tr>
									<td width="100%" height="30" colspan="3"><strong>Total Answer Scripts. : </strong>'.$cnt_present.'</td>
								  
									</tr>
									</table><br><br>';
									
									$j++;
									// unset($ab_commaList);
									//unset($stud_prn);
								}
							}
							
							
							//$content .='';
							//echo $header;echo $content;exit;
							$footer .='<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:40px;font-size:12px;">
							<tr>
							<td align="center">
							<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">

							<tr>
							<td align="left" class="signature" valign="bottom" style="padding-top:30px"><strong>Signature of the SUP 1 :</strong></td>
							<td align="center"  class="signature" valign="bottom" height="50"><strong>Signature of the SUP 2</strong></td>
							<td align="right" class="signature" valign="bottom" height="50"><strong>Signature of the Chif Superitendent</strong></td>
							</tr>
							</table>
								
							</td>
							</tr>
							</table>';
							
							//$this->m_pdf->pdf->AddPage();
							//ob_clean();
							$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
							$this->m_pdf->pdf->defaultfooterline = false;
							$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
							$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
							$this->m_pdf->pdf->SetHTMLHeader($header1);
							$this->m_pdf->pdf->SetHTMLFooter($footer);
							//$this->m_pdf->pdf->setFooter('{PAGENO}');
							$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
							$this->m_pdf->pdf->AddPage();
							
							$this->m_pdf->pdf->WriteHTML($content);
							//$footer = $this->load->view($this->view_dir.'attendance_footer', $this->data, true);
							
							unset($header1);
							unset($header);
							unset($content);
							unset($footer);
							unset($examdetails);
							
							
							ob_clean();
						}
					}
			    }
			    $date_file = date('d-m-Y', strtotime($exam_date[0]));
			    $pdfFilePath = $date_file."_AnswerBookletsReport.pdf";
			    //download it.
			    $this->m_pdf->pdf->Output($pdfFilePath, "D");
			    
			    //ob_end_clean();
			}elseif($_POST['report_type']=='marksheets'){
			    
			    $exam_date = $_POST['exam_date'];				
			    ini_set('max_execution_time', 0);
			    ini_set('memory_limit', '-1');
			    $this->load->library('m_pdf');
			    //$mpdf=new mPDF();
			    $this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '35', '20');
			    
			    //echo "<pre>";
			    //print_r($sublist);exit;
			    $content='<style>
				table {
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 100%; font-size:12px; margin:0 auto;
				}
				td{vertical-align: top;}
			        
				.signature{
				text-align: center;
				}
				p{padding:0px;margin:0px;}
				h1, h3{margin:0;padding:0}
			        
				.content-table tr td{border:1px solid #333;vertical-align:top;padding:10px;}
				.content-table th{border:1px solid #333;margin:40px}
				</style> ';
			    $k=1;
			    for($i=0;$i<count($exam_date);$i++){
			        if($_POST['exam_timing']=='morning'){
						$examslots[]= array("from_time"=>'10:00:00',"to_time"=>'01:00:00');
					}else if($_POST['exam_timing']=='Afternoon'){
						$examslots[]= array("from_time"=>'02:00:00',"to_time"=>'05:00:00');
					}else{
						$examslots= $this->Phd_examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id);
					}
					foreach($examslots as  $slot){
						$slot_from = $slot['from_time'];
						$slot_to = $slot['to_time'];
						$examdetails= $this->Phd_examination_model->exam_daywise_dispatch_report($exam_date[$i],$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);
						//print_r($examdetails);exit;
						if(!empty($examdetails)){
							$timestamp = strtotime($examdetails[0]['date']);
							$day = date('l', $timestamp);
							$fromtime= explode(':', $examdetails[0]['from_time']);
							$totime= explode(':', $examdetails[0]['to_time']);
							$date_exam = date('d/m/Y', strtotime($examdetails[0]['date']));
							//exit;
							$header ='<br><table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
							<tr>
							<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="http://sandipuniversity.com/erp/assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
							<td style="font-weight:normal;text-align:center;">
							<h1 style="font-size:30px;">Sandip University</h1>
							<p>Mahiravani, Trimbak Road, Nashik - 422 213</p>
								
							</td>
							<td width="120" align="right" valign="middle" style="text-align:center;">
							</td>
							</tr>
							<tr>
							<td></td>
							<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>MARKSHEET FOR -<u>'.$exam_month.' - '.$exam_year.'</u></h3></td>
							<td></td>
							</tr>
							</table>';
							
							
							$content ='';
							$j=1;
							//echo count($examdetails);exit;
							if(!empty($examdetails)){
								foreach($examdetails as $exd){
									$course_code = $exd['subject_code'].'-'.$exd['subject_name'];
									$stream_name = $exd['stream_short_name'];
									$content .='<table class="content-table" width="100%" cellpadding="5" cellspacing="5" border="1" align="center" style="font-size:12px;xoverflow: hidden;">
									<tr>
									<td width="31%"><strong>Course Code and Name :</strong> '.strtoupper($course_code).'</td>
									<td width="31%" valign="top"><strong>Date/ Day :</strong> '.$date_exam.', '.$day.'</td>
									<td width="31%" valign="top"><strong>Time :</strong> '.$fromtime[0].':'.$fromtime[1].'-'.$totime[0].':'.$totime[1].'</td>
									</tr>
									<tr>
									<td><strong>Programme :</strong> '.$stream_name.'</td>
									<td><strong>Bundle No. :</strong>_________</td>
									<td><strong>Board :</strong>___________</td>
									</tr></table>
									';
									
									$fromtime= explode(':', $exd['from_time']);
									$totime= explode(':', $exd['to_time']);
									$stream_id = $exd['stream_id'];
									$present_students= $this->Phd_examination_model->exam_marklist_students($exam_date[$i],$exd['subject_id'],$stream_id,$exam_month,$exam_year, $exam_id);
									//print_r($absent_students[1]['enrollment_no']);exit;
									$cnt_present = count($present_students);
								   
									$content .='<table class="content-table" width="100%" cellpadding="5" cellspacing="5" border="1" align="center" style="font-size:12px;xoverflow: hidden;">
									<tr>
										   <td valign="top" style="height:800px" width="33%">
												<table  width="100%" cellpadding="6" cellspacing="6" border="1">
												<tr><th>Sr.N</th><th>PRN</th><th>Marks</th></tr>
												   ';
									$count=0;
									$k=1;
									foreach ($present_students as $pre){
										if($count ==30) {
											$count = 0;
										   
											$content .='</table></td><td valign="top"><table  width="100%" cellpadding="6" cellspacing="6" border="1"><tr><th>Sr.N</th><th>PRN</th><th>Marks</th></tr>
						';
										}
										$content .=' <tr><td style="white-space:wrap;">'.$k.'</td><td style="white-space:wrap;">'.$pre['enrollment_no'].'</td><td style="white-space:wrap;width:70px"></td></tr>';
										$count++;
										$k++;
									}
									
									$content .='</table>
											</td>
									</tr>
									
									</table><br><br>';
								   
									$j++;
									$k=0;
									// unset($ab_commaList);
									//unset($stud_prn);
								}
							}
							
							
							//$content .='';
							//echo $header;echo $content;exit;
							$footer .='<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:40px;font-size:12px;">
							<tr>
							<td align="center">
							<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
								
							<tr>
							<td align="center" class="signature" valign="bottom" style="padding-top:30px" colspan="2"><strong>Entry By :</strong></td>
							
							<td align="center" class="signature" valign="bottom" height="50"><strong>Verified By :</strong></td>
							</tr>
							</table>
								
							</td>
							</tr>
							</table>';
							
							//$this->m_pdf->pdf->AddPage();
							//ob_clean();
							$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
							$this->m_pdf->pdf->defaultfooterline = false;
							$header1 = mb_convert_encoding($header, 'UTF-8', 'UTF-8');
							$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
							$this->m_pdf->pdf->SetHTMLHeader($header1);
							$this->m_pdf->pdf->SetHTMLFooter($footer);
							//$this->m_pdf->pdf->setFooter('{PAGENO}');
							$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
							$this->m_pdf->pdf->AddPage();
							
							$this->m_pdf->pdf->WriteHTML($content);
							//$footer = $this->load->view($this->view_dir.'attendance_footer', $this->data, true);
							
							unset($header1);
							unset($header);
							unset($content);
							unset($footer);
							unset($examdetails);
							
							
							ob_clean();
						}
					}
			    }
			    $date_file = date('d-m-Y', strtotime($exam_date[0]));
			    $pdfFilePath = $date_file."_Marksheet.pdf";
			    //download it.
			    $this->m_pdf->pdf->Output($pdfFilePath, "D");
			    
			    //ob_end_clean();
			}

    	}else{
			$this->DownloadQPReport_excel($_POST);
		}
	}
	
	function DownloadQPReport_excel(){

			$examdate = $_POST['exam_date'];

			$exam= explode('-', $_POST['exam_session']);
			$this->data['exam_sess'] =$exam;
			$exam_month =$exam[0];
			$exam_year =$exam[1];
			$exam_id =$exam[2];

			for($i=0;$i<count($examdate);$i++){
				$exam_date = $examdate[$i];
				//$examslots= $this->Phd_examination_model->exam_daywise_slot($exam_date,$exam_month,$exam_year,$exam_id);
    				/*foreach($examslots as  $slot){
						$slot_from = $slot['from_time'];
						$slot_to = $slot['to_time'];
						$this->data['examdetails']= $this->Phd_examination_model->exam_daywiseqpindend_report($exam_date,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);*/
						$this->data['examdetails']= $this->Phd_examination_model->exam_daywise_report($exam_date,$exam_month,$exam_year,$exam_id);
					//}
			} 

			$this->load->view($this->view_dir.'daywiseQPreport_excel',$this->data);
	}
		function absent_entries(){
		$this->load->view('header',$this->data);        			
		$this->data['exam_session'] =$this->Phd_examination_model->fetch_stud_curr_exam();	
		if(!empty($_POST)){
			$subject_id = $_POST['subject'];
			$stream = $_POST['stream'];
			$exam_date = $_POST['exam_date'];
			
			$this->data['subject'] =$subject_id;
			$this->data['stream'] = $stream;
			$this->data['exam_date'] = $exam_date;
			$this->data['ex_session'] = $_POST['exam_session'];
			$exam= explode('-',$_POST['exam_session']);
			$exam_month =$exam[0];
			$exam_year =$exam[1];
			$exam_id =$exam[2];
			
			$this->data['stud_details']= $this->Phd_examination_model->fetch_exam_datewise_applied_student($stream,$exam_date,$subject_id,$exam_month, $exam_year, $exam_id);
		}
		//$this->data['ex_dates']= $this->Phd_examination_model->fetch_examdates1($exam_month, $exam_year);
		$this->load->view($this->view_dir.'absent_mark_exam_view',$this->data);
		$this->load->view('footer');	
	}
	
	function fetch_examdates_by_session(){
		if(isset($_POST["exam_session"]) && !empty($_POST["exam_session"])){
			//Get all city data
			$exam= explode('-', $_POST["exam_session"]);		
			$exam_id =$exam[2];

			$exdate = $this->Phd_examination_model->fetch_examdates($exam_id);        
			//Count total number of rows
			$rowCount = count($exdate);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Exam Date</option>';
				foreach($exdate as $value){
					echo '<option value="' . $value['exam_date'] . '">' . date('d-m-Y',strtotime($value['exam_date'])).'</option>';
				}
			} else{
				echo '<option value="">Date not available</option>';
			}
		}
	}
	function load_subject(){
		if(isset($_POST["stream"]) && !empty($_POST["stream"])){
			//Get all city data
			$exam= $this->Phd_examination_model->fetch_stud_curr_exam();		
			$exam_month =$exam[0]['exam_month'];
			$exam_year =$exam[0]['exam_year'];
			$exam_id =$exam[0]['exam_id'];
			//
			$stream = $_POST["stream"];
			$exam_date = $_POST["exam_date"];
			$stream = $this->Phd_examination_model->get_exam_subjects($exam_date,$stream,$exam_month,$exam_year,$exam_id);        
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Subject</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['subject_id'] . '">' . $value['subject_code'].'-'.$value['subject_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">Subject not available</option>';
			}
		}
	}	
	function load_stream(){
		if(isset($_POST["exam_date"]) && !empty($_POST["exam_date"])){
			//Get all city data
			$exam= $this->Phd_examination_model->fetch_stud_curr_exam();		
			$exam_month =$exam[0]['exam_month'];
			$exam_year =$exam[0]['exam_year'];
			$exam_id = $exam[0]['exam_id'];
			$stream = $this->Phd_examination_model->get_exam_streams($_POST["exam_date"],$exam_month,$exam_year, $exam_id);
          
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['stream_id'] . '">' . $value['stream_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">Stream not available</option>';
			}
		}
	}
	public function mark_absent_students(){    
		$examdata= $this->Phd_examination_model->fetch_stud_curr_exam();
		$checked_stud = $_POST['chk_stud'];
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$examdata[0]['exam_id'];
		$sub = $_POST['subject'];
		$stream = $_POST['stream'];
		//print_r($_POST);exit;
		foreach($checked_stud as $stud){
			$this->Phd_examination_model->mark_absent_students($stud,$sub, $stream,$exam_month, $exam_year,$exam_id);
							
		}
		echo "success";

	} 	
	public function mark_present_students(){    
		$examdata= $this->Phd_examination_model->fetch_stud_curr_exam();
		$checked_stud = $_POST['chk_stud'];
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$examdata[0]['exam_id'];
		$sub = $_POST['subject'];
		$stream = $_POST['stream'];
		//print_r($_POST['chk_stud']);exit;
		foreach($checked_stud as $stud){
			$this->Phd_examination_model->mark_present_students($stud, $sub, $stream,$exam_month, $exam_year, $exam_id);
							
		}
		echo "success";

	} 		
	public function malpractice_add(){
		$this->load->view('header',$this->data); 
		$this->data['exam_session']= $this->Phd_examination_model->fetch_stud_curr_exam();
		//print_r($this->data['exam_session']);
		$exam_id = $this->data['exam_session'][0]['exam_id'];
		//$exam_year = $this->data['exam_session'][0]['exam_year'];
		$this->data['ex_dates']= $this->Phd_examination_model->fetch_examdates($exam_id);
		$this->load->view($this->view_dir.'search_student',$this->data);
		$this->load->view('footer');
	}
	function search_studentdata_for_malware (){
		$_POST['academic_year'] = '2017';
		//$data['exam']= $this->Phd_examination_model->fetch_stud_curr_exam();
		$exam = explode('-', $_POST['exam_session']);
		$exam_month = $exam[0];
		$exam_year = $exam[1];
		$exam_id =$exam[2];
		$exam_date =$_POST['exam_date'];
		$prn =$_POST['prn'];
		$data['emp_list'] = $this->Phd_examination_model->searchStudent_for_malpractice($prn,$exam_date,$exam_month,$exam_year,$exam_id);
		
		$html = $this->load->view($this->view_dir.'load_studentdata_malware',$data,true);
		echo $html;
	}
	function update_studentdata_for_malware(){
		$is_malpractice = $_POST['is_malpractice'];
		$remark = $_POST['remark'];
		$subject = $_POST['subject'];
		$exam_sub_id = $_POST['examsub_id'];
		$exam= explode('-', $_POST['exam_session']);
		$exam= $this->Phd_examination_model->fetch_stud_curr_exam();
		$exam_month =$exam[0]['exam_month'];
		$exam_year =$exam[0]['exam_year'];
		$exam_id =$exam[0]['exam_id'];
		$this->Phd_examination_model->update_studentdata_for_malware($exam_sub_id,$is_malpractice, $subject,$remark, $exam_month, $exam_year,$exam_id);

		echo "success";
	}
	function generate_excelReports(){
		$StreamShortName =$this->Phd_examination_model->getStreamShortName($_POST['admission-branch']);
		
		if($_POST['report_type']=='HallTicket'){
			//$this->load->view('header',$this->data);        
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['course_details']= $this->Phd_examination_model->getCollegeCourse();
			$this->data['schools']= $this->Phd_examination_model->getSchools();
			$exam= $this->Phd_examination_model->fetch_stud_curr_exam();
			$exam_month =$exam[0]['exam_month'];
			$exam_year =$exam[0]['exam_year'];
			$this->data['emp_list']= $this->Phd_examination_model->get_excel_data($_POST,$exam_month,$exam_year);
				
			$this->load->view($this->view_dir.'exam_hallticket_excel',$this->data);
			//ob_end_clean();
		
		}
	}
	
	function malpractice_list(){
	   // $this->data['exam_session']= $this->Phd_examination_model->fetch_stud_curr_exam();
		$this->load->model('Marks_model');
	    $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	    if(!empty($_POST['exam_session'])){
	        
	    $exam_session = $_POST['exam_session'];
	    $exam = explode('-', $exam_session);
	    $exam_month =$exam[0];
	    $exam_year =$exam[1];
		$exam_id =$exam[2];
	    $this->data['malpractice_list']= $this->Phd_examination_model->get_malpractice_list_data($exam_month,$exam_year, $exam_id);
	    }
        $this->load->view('header',$this->data);
        $this->load->view($this->view_dir.'malpractice_list',$this->data);
        $this->load->view('footer',$this->data);
        //ob_end_clean();
	}
	function malpractice_excelReports($exam_sess){
	        $exam= explode('-', $exam_sess);
	        
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
			$exam_id =$exam[2];
			$this->data['exam_session'] = $exam_month.' '.$exam_year;
	        $this->data['malpractice_list']= $this->Phd_examination_model->get_malpractice_list_data($exam_month,$exam_year,$exam_id);
	        $this->load->view($this->view_dir.'malpractice_excelReports',$this->data);

	}	
	// download student malpractice report
	function malpractice_report($prn, $exam_date){
	   
	    $this->data['exam']= $this->Phd_examination_model->fetch_stud_curr_exam();
	    $exam_month =  $this->data['exam'][0]['exam_month'];
	    $exam_year =  $this->data['exam'][0]['exam_year'];
		$exam_id =  $this->data['exam'][0]['exam_id'];
	    $exam_date = $exam_date;
	    $prn =$prn;
	    $this->data['emp_per'] = $this->Phd_examination_model->searchStudent_for_malpractice($prn,$exam_date,$exam_month,$exam_year,$exam_id);

	    $this->load->library('m_pdf', $param);
	    
	    $html = $this->load->view($this->view_dir.'student_malpractice_report', $this->data, true);
	    $pdfFilePath = $prn."_malpractice_report.pdf";
	    
	    $this->m_pdf->pdf->WriteHTML($html);
	    //download it.
	    $this->m_pdf->pdf->Output($pdfFilePath, "D");
	    
	}
	// fetch exam strams
	function load_examresltstreams(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["course_id"]) && !empty($_POST["course_id"])){
			//Get all streams
			$stream = $this->Phd_examination_model->get_examresltstreams($_POST["course_id"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['stream_id'] . '">' . $value['stream_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">stream not available</option>';
			}
		}
	}
	// fetch exam strams
	function load_examresltsemesters(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			$stream = $this->Phd_examination_model->get_examresltsemester($_POST["stream_id"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Semester</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
				}
			} else{
				echo '<option value="">Semester not available</option>';
			}
		}
	}
	function load_examresltschools(){
		if(isset($_POST["school_code"]) && !empty($_POST["school_code"])){
			//Get all city data
			$stream = $this->Phd_examination_model->get_examresltcourses($_POST["school_code"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">Course not available</option>';
			}
		}
	}
	// for summary excel 
	function reportsummary(){	
		//error_reporting(E_ALL); ini_set('display_errors', '1'); 	
		$this->data['school_code'] =$_POST['school_code'];
		//$this->data['admissioncourse'] =$_POST['admission-course'];
		$exam= explode('-', $_POST['exam_session']);
		$this->data['exam_session'] =$exam[0].'-'.$exam[1];
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id = $exam[2];
		$report_type = $_POST['report_type'];
		$this->data['report_type'] = $_POST['report_type'];
		if($report_type =='Statistics'){
			$this->data['summary_list']= $this->Phd_examination_model->get_exam_app_studcount($_POST,$exam_month,$exam_year, $exam_id);
			$this->load->view($this->view_dir.'examappliedstudentcount_excel.php',$this->data); 
		}else{
			$this->data['summary_list']= $this->Phd_examination_model->get_exam_app_stud($_POST,$exam_month,$exam_year, $exam_id);
			$this->load->view($this->view_dir.'exam_applied_student_excel.php',$this->data); 
		}
	}
	function general_sms(){
		if(!empty($_POST)){
			$DB1 = $this->load->database('umsdb', TRUE);  
			$mobile_nos     = trim($_POST['mobiles']);
			$content = trim($_POST['message']);
			
			$ch = curl_init();
			$sms=urlencode($content);
			$query="?username=SANDIP03&password=sandip2018&from=SANDIP&to=$mobile_nos&text=$sms&coding=0";
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_URL,'http://49.50.67.32/smsapi/httpapi.jsp'.$query); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 3);
			$res = trim(curl_exec($ch));
			curl_close($ch);

		$insert_sms_details =array(
			"mobile_nos"=>$mobile_nos,
			"message"=>$content,
			"entry_by" => $this->session->userdata("uid"),
			"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
			"entry_on" => date("Y-m-d H:i:s"),

		); 	
		$DB1->insert("sms_log", $insert_sms_details); 
		$sms_id=$DB1->insert_id(); 
			if($sms_id !=''){
				echo "success";
			}
		}else{
			$this->load->view('header',$this->data);
			$this->load->view($this->view_dir.'general_sms_view',$this->data);
			$this->load->view('footer',$this->data);
		}
	}
	function download_pdf($student_id, $exam_id){
		//load mPDF library
        
		$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		
		$this->load->library('m_pdf', $param);
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
		$stud_id = base64_decode($student_id);
		if($stud_id!=''){
			$this->data['exam']= $this->Phd_examination_model->fetch_exam_session_byid($exam_id);
			$exam_month =$this->data['exam'][0]['exam_month'];
			$exam_year =$this->data['exam'][0]['exam_year'];
			$this->data['examdetails']= $this->Phd_examination_model->fetch_stud_phd_exam_details($stud_id,$exam_id);
			//print_r($this->data['examdetails']);exit;
			$this->data['fee']= $this->Phd_examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Phd_examination_model->fetch_banks();
			$this->data['emp']= $this->Phd_examination_model->fetch_personal_details($stud_id);
			$semester = $this->data['emp'][0]['current_semester'];
			$this->data['sublist']= $this->Phd_examination_model->getCurrentExamAllocatedSubject($stud_id, $semester,$exam_id);	
			$this->data['examfees']= $this->Phd_examination_model->fetch_examfeesdetails($this->data['emp'][0]['stream_id'], $this->data['exam'][0]['exam_id']);
			$this->data['laddr']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');

			foreach($this->data['sublist'] as $sb){
				$sub_sem[] = $sb['semester']; 
			}

			$semarray = array_unique($sub_sem);

			$esem ='';
			foreach($semarray as $sem){
				$esem .= $this->numberToRoman($sem).',';
			}
			$this->data['exam_semes'] = rtrim($esem,',');
			//print_r($semarray);
			//exit;
			
		}

		$html = $this->load->view($this->view_dir.'exam_form_pdf_new11', $this->data, true);
		$pdfFilePath = $this->data['emp'][0]['enrollment_no']."_exam_form.pdf";
		$stud_name = $this->data['emp'][0]['last_name'].' '.$this->data['emp'][0]['first_name'].' '.$this->data['emp'][0]['middle_name'];
		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		$form_submitted_date= date("d-m-Y H:i:s", strtotime($this->data['examdetails'][0]['entry_on']));
		$footer ='<table cellpadding="0" cellspacing="0" border="0" align="center" width="96%" class="cell-padding">
		<tr><td colspan=3><small>I <b>'.$stud_name.'</b> verified the Name,Photo, DoB, name and the total number of courses, the fee to be paid and other details.<br>
If there is any corrections/discrepancy, submit the necessary documents to the Office of the Controller of Examinations through CoE Coordinator for further processing.</small></td></tr></table>
		<table cellpadding="0" cellspacing="0" border="1" align="center" width="96%" style="margin-bottom:25px;" class="cell-padding">		
<tr>
<td width="25%" align="center" height="40">&nbsp;</td>
<td width="25%" align="center">&nbsp;</td>
<td width="25%" align="center">&nbsp;</td>
</tr>
<tr>
<td align="center"><strong>Sign of the student</strong></td>
<td align="center"><strong>Sign of the Dean/HOD</strong></td>
<td align="center"><strong>COE Sign</strong></td>
</tr>
</table>';
	$footer .='<table cellpadding="0" cellspacing="0" border="0"  width="100%"  style="margin-bottom:15px;font-size:9px;">	
			<tr>
			<td><b style="font-size:9px;float:left;text-align:left;">Form Applied On: '.$form_submitted_date.'</b></td>
				<td style="font-size:9px;float:right;text-align:right;"><b style="font-size:9px;float:right;text-align:right;">Printed On: '.date('d-m-Y H:i:s').'</b>
				</td>
			</tr>
			</table>';
		$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		
		$this->m_pdf->pdf->SetHTMLFooter($footer);
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		// ob_end_flush(); 
		
	}
	function download_arrearpdf($student_id, $exam_id){
		//load mPDF library
        
		$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		
		$this->load->library('m_pdf', $param);
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
		$stud_id = base64_decode($student_id);
		if($stud_id!=''){
			$this->data['exam']= $this->Phd_examination_model->fetch_exam_session_byid($exam_id);
			$exam_month =$this->data['exam'][0]['exam_month'];
			$exam_year =$this->data['exam'][0]['exam_year'];
			$this->data['examdetails']= $this->Phd_examination_model->fetch_stud_phd_exam_details($stud_id,$exam_id);
			//print_r($this->data['examdetails']);exit;
			$this->data['fee']= $this->Phd_examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Phd_examination_model->fetch_banks();
			$this->data['emp']= $this->Phd_examination_model->fetch_personal_details($stud_id);
			$semester = $this->data['emp'][0]['current_semester'];
			$this->data['sublist']= $this->Phd_examination_model->getCurrentExamAllocatedSubject($stud_id, $semester,$exam_id);	
			$this->data['examfees']= $this->Phd_examination_model->fetch_examfeesdetails($this->data['emp'][0]['stream_id'], $this->data['exam'][0]['exam_id']);
			$this->data['laddr']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');

			foreach($this->data['sublist'] as $sb){
				$sub_sem[] = $sb['semester']; 
			}

			$semarray = array_unique($sub_sem);

			$esem ='';
			foreach($semarray as $sem){
				$esem .= $this->numberToRoman($sem).',';
			}
			$this->data['exam_semes'] = rtrim($esem,',');
			//print_r($semarray);
			//exit;
			
		}

		$html = $this->load->view($this->view_dir.'exam_form_arrearpdf', $this->data, true);
		$pdfFilePath = $this->data['emp'][0]['enrollment_no']."_exam_form_arrear.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);

		$footer ='<table cellpadding="0" cellspacing="0" border="1" align="center" width="96%" style="margin-bottom:25px;" class="cell-padding">
<tr>
<td width="25%" align="center" height="40">&nbsp;</td>
<td width="25%" align="center">&nbsp;</td>
<td width="25%" align="center">&nbsp;</td>
<td width="25%" align="center">&nbsp;</td>
</tr>
<tr>
<td align="center"><strong>Sign of the student</strong></td>
<td align="center"><strong>Sign of the Dean/HOD</strong></td>
<td align="center"><strong>Accounts Dept Sign</strong></td>
<td align="center"><strong>COE Sign</strong></td>
</tr>
</table>';
	$footer .='<table cellpadding="0" cellspacing="0" border="0" width="100%"   style="margin-bottom:15px;font-size:9px;float:right;text-align:right;">	
			<tr>
			
				<td style="font-size:9px;float:right;text-align:right;"><b style="font-size:9px;float:right;text-align:right;">Printed On: '.date('d-m-Y H:i:s').'</b>
				</td>
			</tr>
			</table>';
		$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		
		$this->m_pdf->pdf->SetHTMLFooter($footer);
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		// ob_end_flush(); 
		
	}	
	// fetch result streams
	function load_ex_appliedstreams(){
		//echo $_POST["course_id"];exit;
		//if(isset($_POST["course_id"]) && !empty($_POST["course_id"])){
			$exam_details = explode('-', $_POST["exam_session"]);
			$exam_id= $exam_details[2];
			//Get all streams
			$stream = $this->Phd_examination_model->load_ex_appliedstreams($_POST["course_id"],$exam_id);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			echo '<option value="">Select Stream</option>';
			echo '<option value="0">All Stream</option>';
			if($rowCount > 0){							
				foreach($stream as $value){
					echo '<option value="' . $value['stream_id'] . '">' . $value['stream_short_name'] . '</option>';
				}
			} 
		//}
	}
	function load_ex_appliedsemesters(){
		//echo $_POST["course_id"];exit;
		//if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			$exam_details = explode('-', $_POST["exam_session"]);
			$exam_id= $exam_details[2];
			//Get all streams
			$stream = $this->Phd_examination_model->load_ex_appliedsemesters($_POST["stream_id"], $exam_id);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			echo '<option value="">Select Semester</option>';
			echo '<option value="0">All Semester</option>';
			if($rowCount > 0){	
				foreach($stream as $value){
					echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
				}
			}
		//}
	}
	
	
	function load_examdate(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			//echo $_POST["exam_session"];
			$stream = $this->Phd_examination_model->get_examdate($_POST["stream_id"], $_POST["exam_session"], $_POST["semester"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Date</option>';
				foreach($stream as $value){
					if(isset($_POST['subject_Date'])&&  ($_POST['subject_Date']==$value['date']))
					{
						$sel="selected";

					}
					else{
						$sel='';

					}
					echo '<option value="' . $value['date'] . '" '.$sel.'>' . $value['date'].'</option>';
				}
			} else{
				echo '<option value="">Subject not available</option>';
			}
		}
	}
	
	function load_examsubjects(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			//echo $_POST["exam_session"];
			$stream = $this->Phd_examination_model->get_examsubjects($_POST["stream_id"], $_POST["exam_session"], $_POST["semester"],$_POST['subject_Date']);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Subject</option>';
				foreach($stream as $value){
					if(isset($_POST['subject_id'])&&  ($_POST['subject_id']==$value['sub_id']))
					{
						$sel="selected";

					}
					else{
						$sel='';

					}
					echo '<option value="' . $value['sub_id'] . '" '.$sel.'>' . $value['subject_code'].'-'.$value['subject_name'].' ('.$value['batch'].')</option>';
				}
			} else{
				echo '<option value="">Subject not available</option>';
			}
		}
	}
	function search_attendance_data($examsessionn='',$school_code='',$admission_course='',$admission_branch='',$semester='',$subject_id='',$exam_cycle='',$subject_datee=''){
		//error_reporting(E_ALL);
		$this->data['exam_session']= $this->Phd_examination_model->fetch_stud_curr_exam();
		$this->data['fetch_cycle']= $this->Phd_examination_model->fetch_cycle();
		if($examsessionn!='')
		{
			$exam = explode('-', $examsessionn);
			$exam_month =$exam[0];
			$exam_year =$exam[1];
			$exam_id =$exam[2];
			$exam_type =$ex_session[0]['exam_type'];
			$this->data['examsessionn']=$examsessionn;
			$this->data['school_code']=$school_code;
			$this->data['admission_course']=$admission_course;
			$this->data['admission_branch']=$admission_branch;
			$this->data['semester']=$semester;
			$this->data['subject_id']=$subject_id;
			$this->data['exam_cycle']=$exam_cycle;
			$this->data['subject_datee']=$subject_datee;
			$this->data['stud_details']= $this->Phd_examination_model->getSubjectStudentList_for_attendance($subject_id,$admission_branch,$exam_id,$exam_cycle);
		}
		else
		{
			$exam = explode('-', $_POST['exam_session']);
			$exam_month =$exam[0];
			$exam_year =$exam[1];
			$exam_id =$exam[2];
			$exam_type =$ex_session[0]['exam_type'];
			$this->data['examsessionn']=$_POST['exam_session'];
			$this->data['school_code']=$_POST['school_code'];
			$this->data['admission_course']=$_POST['admission-course'];
			$this->data['admission_branch']=$_POST['admission-branch'];
			$this->data['semester']=$_POST['semester'];
			$this->data['subject_id']=$_POST['subject_id'];
			$this->data['exam_cycle']=$_POST['exam_cycle'];
			$this->data['subject_datee']=$_POST['subject_Date'];
			$this->data['stud_details']= $this->Phd_examination_model->getSubjectStudentList_for_attendance($_POST['subject_id'],$_POST['admission-branch'],$exam_id,$_POST['exam_cycle']);

		}
		
		
	
		//$this->data['exam_session']= $ex_session;
		/*echo "<pre>";
		
		print_r($this->data['stud_details']);
		die;*/
		$this->load->view('header',$this->data);   
		$this->load->view($this->view_dir.'exam_attendance',$this->data);
		$this->load->view('footer');
	}
	public function mark_attandance_ansbklt_students(){ 

		//error_reporting(E_ALL);
		$DB1 = $this->load->database('umsdb', TRUE);
		$checked_stud = $_POST['chk_stud'];
		$exam_id =$_POST['exam_id'];
		
		$subject_id = $_POST['subject_id'];
		$stream_id = $_POST['stream_id'];
		$semester = $_POST['semester'];
		$exam_date = $_POST['exam_date'];
		$exam_from_time = $_POST['exam_from_time'];
		$exam_to_time = $_POST['exam_to_time'];
		$chk_prn = $_POST['chk_prn'];
		$ans_booklet_no=$_POST['ans_booklet_no'];
		$ans_booklet_received=$_POST['ans_booklet_received'];
		$chk_att_status=$_POST['chk_att_status'];
		$exam_cycle=$_POST['examm_cycle'];
		$subject_datee=$_POST['subject_datee'];
		$remark=$_POST['remark'];
		//echo"<pre>";print_r($_POST);exit;
		$check_duplicate= $this->Phd_examination_model->check_duplicate_for_attendance($subject_id,$stream_id,$semester,$exam_id,$exam_date);
		
		if(count($check_duplicate)==0){
			$i=0;
			foreach($checked_stud as $stud){
				if(in_array($stud, $chk_att_status)){
					$exam_attendance_status1='P';
				}else{
					$exam_attendance_status1='A';
				}
				if(in_array($stud, $ans_booklet_received)){
					$ans_booklet_received1='Y';
				}else{
					$ans_booklet_received1='N';
				}
				$arr_insert =array('exam_id'=>$exam_id,
				'subject_id'=>$subject_id,
				'stream_id'=>$stream_id,
				'semester'=>$semester,
				'exam_date'=>$exam_date,
				'exam_from_time'=>$exam_from_time,
				'exam_to_time'=>$exam_to_time,
				'student_id'=>$stud,
				'enrollment_no'=>$chk_prn[$i],
				'exam_attendance_status'=>$exam_attendance_status1,
				'ans_bklet_no'=>$ans_booklet_no[$i],
				'ans_bklt_received_status'=>$ans_booklet_received1,
				'remark'=>$remark[$i],
				);
				//echo "<pre>";print_r($_POST);  
				$DB1->insert("exam_phd_ans_booklet_attendance", $arr_insert);
				//echo $DB1->last_query();exit;
				$i++;				
			}
			$this->session->set_flashdata('Successfully','Inserted Successfully ');
		}else{

			//print_r($chk_att_status);
				$i=0;
			foreach($checked_stud as $stud){
				if(in_array($stud, $chk_att_status)){
					$exam_attendance_status1='P';
				}else{
					$exam_attendance_status1='A';
				}
				if(in_array($stud, $ans_booklet_received)){
					$ans_booklet_received1='Y';
				}else{
					$ans_booklet_received1='N';
				}

				
					$update_insert =array(
				'exam_attendance_status'=>$exam_attendance_status1,
				'ans_bklet_no'=>$ans_booklet_no[$i],
				'ans_bklt_received_status'=>$ans_booklet_received1,
				'remark'=>$remark[$i],
				);
				$DB1->where("student_id",$stud);
				$DB1->where("subject_id",$subject_id);
				$DB1->where("stream_id",$stream_id);
				$DB1->where("semester",$semester);
				$DB1->where("exam_date",$exam_date);
				$DB1->where("exam_id",$exam_id);
				//echo "<pre>";print_r($_POST);  
				$DB1->update("exam_phd_ans_booklet_attendance", $update_insert);
				$i++;
				//echo $DB1->last_query();exit;
			}

		
			
	 	$this->session->set_flashdata('Successfully','Updated Successfully ');
			
		}
		
		$examsessionn=$_POST['examsessionn'];
		$school_code=$_POST['school_code'];
		$admission_course=$_POST['admission_course'];

		$admission_branch=$_POST['admission_branch'];
		$semester=$_POST['semester'];
		$subject_id=$_POST['subject_id'];
		if(empty($_POST['examm_cycle'])){
		$examm_cycle=0;
		}else{
			$examm_cycle=$_POST['examm_cycle'];
		}
		$subject_datee=$_POST['subject_datee'];
		redirect('Phd_examination/search_attendance_data/'.$examsessionn.'/'.$school_code.'/'.$admission_course.'/'.$admission_branch.'/'.$semester.'/'.$subject_id.'/'.$exam_cycle.'/'.$subject_datee);
		

	} 	
	function testsms(){
		$username = urlencode("u4282");
		$msg_token = urlencode("j8eAyq");
		$sender_id = urlencode("SANDIP"); // optional (compulsory in transactional sms)
		$message = urlencode("hello");
		$mobile = urlencode("9821739610");

		$api = "http://bulksms.omegatelesolutions.com/api/send_transactional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile."";

		$response = file_get_contents($api);

		echo $response;
	}
		public function edit_exam_form_contocoe($student_prn){  // contact to COE
		if($student_prn !=''){
			$stud_prn = $student_prn;
		}else{
			$stud_prn = $this->session->userdata('name');
		}
		
		$id= $this->Phd_examination_model->get_student_id_by_prn($stud_prn);
		$stud_id=$id['stud_id'];
		$current_semester =$id['current_semester'];
		$stream =$id['admission_stream'];
		$ex_session = $this->Phd_examination_model->fetch_stud_curr_exam();
		$this->data['ex_session'] = $ex_session;
		if($stud_id!=''){
			//$this->data['exam']= $this->Phd_examination_model->fetch_stud_exam_details($stud_id);
			$this->data['fee']= $this->Phd_examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Phd_examination_model->fetch_banks();
			$this->data['emp']= $this->Phd_examination_model->fetch_personal_details($stud_id);
			$this->data['sublist']= $this->Phd_examination_model->get_stud_applied_sub_for_arrear_update($stud_id,$current_semester);
	
		}
		$this->load->view('header',$this->data); 
		$this->load->view($this->view_dir.'edit_exm_form',$this->data);
		$this->load->view('footer');
        
	}
	// arrears update exam subject
	public function update_subject_in_arrears_details(){  
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam_details =  explode('~',$this->input->post('exam_details'));
		$fee_date = str_replace('/', '-', $_POST['dddate']);
		
		$insert_exam_subjects=array(
			"student_id"=>$this->input->post('student_id'),
			"enrollment_no"=>$this->input->post('enrollment_no'),
			"stream_id"=>$this->input->post('stream_id'),
			"exam_id" => $exam_details[0],
			"modify_by" => $this->session->userdata("uid"),
			"modify_on" => date("Y-m-d H:i:s"),
			"entry_by" => $this->session->userdata("uid"),
			"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
			"entry_on" => date("Y-m-d H:i:s"),
			"grade" => 'U',
			"passed" => 'N',
			"remark" => 'Manual updation attempting prev sem exam',
			"no_of_attempt" => 0); 

		//echo "<pre>";
			//print_r($insert_exam_subjects);	exit;
		$subjects = $this->input->post('chk_sub');
		
		foreach($subjects as $sub){
			$sub = explode('~', $sub);
				$insert_exam_subjects['subject_id']=$sub[0];
				$insert_exam_subjects['subject_code']= $sub[1];
				$insert_exam_subjects['semester']= $sub[2];
				$is_sub_exit = $this->Phd_examination_model->check_duplicate_sub_in_arrears($this->input->post('student_id'),$sub[0]);
				//print_r($is_sub_exit);exit;
				if(empty($is_sub_exit)){
					$DB1->insert("phd_exam_student_subject", $insert_exam_subjects);
				}
				//echo $DB1->last_query();echo "<br>";exit;
				
		}
		



		$studprn = base64_encode($_POST['enrollment_no']);
		redirect('Phd_examination/view_form/'.$studprn);

	}
	public function view_form($student_prn){  

		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}
		
		$id= $this->Phd_examination_model->get_student_id_by_prn($stud_prn);
		$stud_id=$id['stud_id'];
		//print_r($stud_id);exit;
		if($stud_id!=''){
			$this->data['exam']= $this->Phd_examination_model->fetch_stud_curr_exam();
			$this->data['examdetails']= $this->Phd_examination_model->fetch_stud_exam_details($stud_id);
			$this->data['fee']= $this->Phd_examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Phd_examination_model->fetch_banks();
			$this->data['emp']= $this->Phd_examination_model->fetch_personal_details($stud_id);
			//print_r($this->data['emp']);exit;
			//if($this->data['exam'][0]['exam_type']=='Regular'){
				$this->data['sublist']= $this->Phd_examination_model->getExamAllocatedSubject($stud_id);	
			//}
			//$this->data['sublist']= $this->Examination_model->getExamAllocatedSubject($stud_id);
			
		}
		//print_r($this->data['emp']);exit;
		$this->load->view('header',$this->data); 
		$this->load->view($this->view_dir.'view_form',$this->data);
		$this->load->view('footer');
        
	}	
	public function search_allow_for_exam(){
		$role_id = $this->session->userdata('role_id');
		/*if($role_id==4){
			echo "Last Date to be apply 25th SEPT 2020 till 5:00 PM.";exit; 
		}else{*/
		$this->load->view('header',$this->data); 
		$this->data['exam']= $this->Phd_examination_model->fetch_stud_curr_exam();
		$this->load->view($this->view_dir.'search_allow_for_exam',$this->data);
		$this->load->view('footer');
		//}
	}	
function search_student_for_exam_allow(){

		$prn = $_POST['prn'];
		$this->data['exam_session_val']= $this->Phd_examination_model->fetch_stud_curr_exam();
		$this->data['forms_dates']= $this->Phd_examination_model->get_form_entry_dates($this->data['exam_session_val'][0]['exam_id']);

		$id= $this->Phd_examination_model->get_student_id_by_prn($prn);
		$stud1=$this->Phd_examination_model->get_studentwise_admission_fees($prn);
		
		$other=$stud1[0]['opening_balance']+$stud1[0]['cancel_charges'];
		if(in_array($prn, $arr_prn)){
			$pending=0;
			$per_paid =100; 
			$other=0;
		}else{
			$pending=($stud1[0]['applicable_total']+$other+$stud1[0]['refund'])-$stud1[0]['fees_total'];

			if($other >=0){
			$fees_app = ($stud1[0]['applicable_total']+$other+$stud1[0]['refund']);//echo"<br>";
		    $fees_paid = $stud1[0]['fees_total'];//echo"<br>";
			}else{
				$fees_app = ($stud1[0]['applicable_total']+$stud1[0]['refund']);
				$fees_paid = $stud1[0]['fees_total']-($other);
			}
			$per_paid = round(($fees_paid/$fees_app)*100);
			
			if($fees_app==0 && $pending==0){
				$per_paid=100;
			}
			if($this->session->userdata("uid")==2 || $this->session->userdata("role_id")==15){
				echo 'applicable_total-'.$stud1[0]['applicable_total'];echo"<br>"; echo 'Other-'.$other;echo"<br>";
				echo '%-'.$per_paid; echo"<br>";
				echo 'fees_paid-'.$fees_paid;echo"<br>";
				echo 'fees_app-'.$fees_app;echo"<br>";
				echo 'fees_pending-'.$pending;
			}
		}
			$emp_list= $this->Phd_examination_model->searchStudentsajax($_POST);
			if(!empty($emp_list)){
				$data['emp_list']= $emp_list;
				$data['emp_list'][0]['exam_details']= $this->Phd_examination_model->studentExamDetails($_POST);
			}else{
				$emp_list1= $this->Phd_examination_model->searchCheckStudentbyprn($_POST);
				$data['emp_list']= $emp_list1;
			}
			$data['fees']= $this->Phd_examination_model->fetch_fees($_POST);
			$data['exam']= $this->Phd_examination_model->fetch_stud_curr_exam();
			$html = $this->load->view($this->view_dir.'load_studentdata_for_allowed',$data,true);
			echo $html;

	}	
	function allow_student_for_exam(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud=$_POST['student_id'];
		$exam_id=$_POST['exam_id'];
		$check_duplicate_student= $this->Phd_examination_model->check_duplicate_allow_student_for_exam($stud,$exam_id);
							
		if($check_duplicate_student==0)
		{
			 if(!empty($_FILES['doc']['name'])){
				 $filenm=$student_id.'-'.time().'-'.$_FILES['doc']['name'];
                $config['upload_path'] = 'uploads/allowed_for_exam/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
				$config['overwrite']= TRUE;
				$config['max_size']= "2048000";
                //$config['file_name'] = $_FILES['profile_img']['name'];
                $config['file_name'] = $filenm;
                
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
                if($this->upload->do_upload('doc')){
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                }else{
                    $picture = '';
                }
            }
			else{
                $picture = '';
            }
			$arr_insert =array('exam_id'=>$_POST['exam_id'],
			'student_id'=>$_POST['student_id'],
			'enrollment_no'=>$_POST['enrollment_no'],
			'permission_doc'=>$picture,
			'remark'=>$_POST['remark'],
			"inserted_by" => $this->session->userdata("uid"),
			"inserted_from_ip" => $_SERVER['REMOTE_ADDR'],
			"inserted_on" => date("Y-m-d H:i:s")
			);
			//echo "<pre>";print_r($arr_insert);  
			$DB1->insert("phd_exam_allowed_students", $arr_insert);
			  //echo $DB1->last_query();exit;  
		}
		redirect('phd_examination/search_allow_for_exam/');
	}	
}
?>