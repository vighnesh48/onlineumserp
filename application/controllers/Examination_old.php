<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Examination extends CI_Controller
{

    var $currentModule = "";   
    var $title = "";   
    var $table_name = "unittest_master";    
    var $model_name = "Examination_model";   
    var $model;  
    var $view_dir = 'Examination/';
 
    public function __construct()
    {        
        global $menudata;      
        parent::__construct();       
        $this->load->helper("url");     
        $this->load->library('form_validation');        
        if ($this->uri->segment(2) != "" && $this->uri->segment(2) != "submit" && !in_array($this->uri->segment(2), $this->skipActions))
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
    
    
    
    public function index($student_prn='')
    {   		
		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}
        $id= $this->Examination_model->get_student_id_by_prn($stud_prn);
        $stud_id=$id['stud_id'];
		if($stud_id !=''){
			//$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
			//if(!empty($this->data['fee'])){
			//	redirect('Examination/view_form');
			//}else{       
				$this->data['exam']= $this->Examination_model->fetch_stud_curr_exam();
				$this->data['bank']= $this->Examination_model->fetch_banks();
				$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
				$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
				$this->data['sublist']= $this->Examination_model->getStudAllocatedSubject($stud_id);	
			//}
		
		$this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'view',$this->data);
        $this->load->view('footer');
		}else{
			redirect('home');
		}
        
    }
    
    
    
    
    public function list_allstudents()
    {
      
      if($_POST)
      {
        $this->load->view('header',$this->data);        
    
	
		 $college_id = 1;
		 $this->data['emp_list']= $this->Examination_model->list_allstudents();
		 	 $this->data['course_details']= $this->Examination_model->getCollegeCourse();
        $this->load->view($this->view_dir.'student_list',$this->data);
        $this->load->view('footer');    
      }
      else
      {
      
       $this->load->view('header',$this->data);        
    
	
		 $college_id = 1;
		 $this->data['course_details']= $this->Examination_model->getCollegeCourse();
        $this->load->view($this->view_dir.'student_list',$this->data);
        $this->load->view('footer');
      
      }
 
        
    }
    
    
    
    
    public function course_streams()
		{
	 global $model;	    
	    $this->data['campus_details']= $this->Examination_model->course_streams($_POST);     	    
		}
    
    
    
    
	
    public function add_exam_form()
    {  
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam_details =  explode('~',$this->input->post('exam_details'));
		$fee_date = str_replace('/', '-', $_POST['dddate']);
		
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
			"is_absent" => 'Y'); 
			


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
		$DB1->insert("exam_details", $insert_exam_details); 
		$exam_master_id=$DB1->insert_id(); 
		//echo $DB1->last_query();exit;
		$insert_exam_subjects['exam_master_id'] = $exam_master_id;
		//print_r($insert_exam_subjects);	exit;
		$subjects = $this->input->post('sub');
		foreach($subjects as $sub){
			$sub = explode('~', $sub);
			$insert_exam_subjects['subject_id']=$sub[0];
			$insert_exam_subjects['subject_code']= $sub[1];
			$DB1->insert("exam_applied_subjects", $insert_exam_subjects);
			//echo $DB1->last_query();exit;
		}
		
		$studprn = base64_encode($_POST['enrollment_no']);
		/*
		echo "<pre>";
		print_r($insert_array);
		exit; 
		*/
		///////////////////
		include_once "phpqrcode/qrlib.php";
		//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
		$tempDir = 'uploads/exam/DEC-2017/QRCode/';
		//$po_id = $p_row[0]['ord_no'];
		$site_url="http://sandipuniversity.com/erp/";
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
		redirect('examination/view_form/'.$studprn);
		

    } 
	public function edit_exam_form($student_prn)
    {  
		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}
		
        $id= $this->Examination_model->get_student_id_by_prn($stud_prn);
        $stud_id=$id['stud_id'];
		$current_semester =$id['current_semester'];
		$stream =$id['admission_stream'];

        if($stud_id!=''){
			$this->data['exam']= $this->Examination_model->fetch_stud_exam_details($stud_id);
			$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Examination_model->fetch_banks();
			$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
			$this->data['sublist']= $this->Examination_model->getExamAllocatedSubject($stud_id);
			$this->data['semsublist']= $this->Examination_model->getSemesterSubject($current_semester, $stream);
			
		}
		$this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'edit',$this->data);
        $this->load->view('footer');
        
    }	
	// view exam form
	public function view_form($student_prn)
    {  

		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}
		
        $id= $this->Examination_model->get_student_id_by_prn($stud_prn);
        $stud_id=$id['stud_id'];

        if($stud_id!=''){
			$this->data['exam']= $this->Examination_model->fetch_stud_curr_exam();
			$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Examination_model->fetch_banks();
			$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
			$this->data['sublist']= $this->Examination_model->getExamAllocatedSubject($stud_id);	
		}
		$this->load->view('header',$this->data); 
        $this->load->view($this->view_dir.'view_form',$this->data);
        $this->load->view('footer');
        
    }
	//search_exam_form
	public function search_exam_form(){
		$this->load->view('header',$this->data); 
		$this->data['exam']= $this->Examination_model->fetch_stud_curr_exam();
		$this->load->view($this->view_dir.'search',$this->data);
		$this->load->view('footer');
	 }
	 
	 function search_studentdata()
	{
		$_POST['academic_year'] = '2017';
     $data['emp_list']= $this->Examination_model->searchStudentsajax($_POST);
      $data['fees']= $this->Examination_model->fetch_fees($_POST);
	  $data['exam']= $this->Examination_model->fetch_stud_curr_exam();
	      $html = $this->load->view($this->view_dir.'load_studentdata',$data,true);
	  echo $html;
	}
	
	function download_pdf($student_id)
	{
		//load mPDF library
        
        $this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		$this->load->library('m_pdf', $param);
		$stud_id = base64_decode($student_id);
		if($stud_id!=''){
			$this->data['exam']= $this->Examination_model->fetch_stud_curr_exam();
			$exam_month =$this->data['exam'][0]['exam_month'];
			 $exam_year =$this->data['exam'][0]['exam_year'];
			$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Examination_model->fetch_banks();
			$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
			$this->data['sublist']= $this->Examination_model->getExamAllocatedSubject($stud_id,$exam_month,$exam_year);
			$this->data['laddr']= $this->Ums_admission_model->fetch_address_details($stud_id,'STUDENT','CORS');
		}

		$html = $this->load->view($this->view_dir.'exam_form_pdf', $this->data, true);
        $pdfFilePath = $this->data['emp'][0]['enrollment_no']."_exam_form.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);

        $this->m_pdf->pdf->WriteHTML($html);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
		
        // ob_end_flush(); 
		
	}
	// update exam subject
	public function update_subject_details()
    {  
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam_details =  explode('~',$this->input->post('exam_details'));
		$fee_date = str_replace('/', '-', $_POST['dddate']);
		
		$insert_exam_subjects=array(
			"stud_id"=>$this->input->post('student_id'),
			"enrollment_no"=>$this->input->post('enrollment_no'),
			"stream_id"=>$this->input->post('stream_id'),
			"semester"=>$this->input->post('semester'),
			
			"exam_id" => $exam_details[0],
			"exam_month" => $exam_details[1],
			"exam_year" => $exam_details[2],
			"exam_master_id" => $exam_details[3],
			"modify_by" => $this->session->userdata("uid"),
			"modify_from_ip" => $_SERVER['REMOTE_ADDR'],
			"modify_on" => date("Y-m-d H:i:s"),
			"is_absent" => 'Y'); 

		//echo "<pre>";
	//	print_r($insert_exam_subjects);	
		$subjects = $this->input->post('chk_sub');
		$this->Examination_model->delete_subjects($insert_exam_subjects); // delete all student subject
		//exit;
		foreach($subjects as $sub){
			$sub = explode('~', $sub);
			$insert_exam_subjects['subject_id']=$sub[0];
			$insert_exam_subjects['subject_code']= $sub[1];
			$DB1->insert("exam_applied_subjects", $insert_exam_subjects);
		}
		$studprn = base64_encode($_POST['enrollment_no']);
		redirect('examination/view_form/'.$studprn);

    } 
	// 
	public function update_fee_details()
    {  
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
		redirect('examination/view_form/'.$studprn);

    } 
    public function list_examstudents()
    {
    //  echo "ex";exit;
      if($_POST)
      {
		  
        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['semester'] =$_POST['semester'];
		 $college_id = 1;
		 $this->data['emp_list']= $this->Examination_model->list_examallstudents();
		 $this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		 for($i=0;$i<count($this->data['emp_list']);$i++){
	         $student_id =$this->data['emp_list'][$i]['stud_id'];
			 $exam = explode('-', $_POST['exam_session']);
			 $exam_month =$exam[0];
			 $exam_year =$exam[1];
	         $this->data['emp_list'][$i]['fees']=$this->Examination_model->getFeedetails($student_id);
	         $this->data['emp_list'][$i]['isPresent']=$this->Examination_model->getExamformStatus($student_id,$exam_month,$exam_year);
	
          } 
		
		$this->data['course_details']= $this->Examination_model->getCollegeCourse();
		$this->data['schools']= $this->Examination_model->getSchools();
        $this->load->view($this->view_dir.'exam_student_list',$this->data);
        $this->load->view('footer');    
      }
      else
      {
      
       $this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		 $college_id = 1;
		 $this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		 $this->data['course_details']= $this->Examination_model->getCollegeCourse();
		 $this->data['schools']= $this->Examination_model->getSchools();
        $this->load->view($this->view_dir.'exam_student_list',$this->data);
        $this->load->view('footer');
      
      }
 
        
    }
    // insert and update
    public function hold_students()
    {    
		
		$checked_stud = $_POST['chk_stud'];
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		//print_r($_POST);exit;
		foreach ($checked_stud as $stud) {
				$stud_subjects = $this->Examination_model->UpdateHoldStatus($stud,$exam_month, $exam_year);
							
		}
		//$emp_list =array();	
		$emp_list = $this->Examination_model->list_exam_allstudents($_POST);
		for($i=0;$i<count($emp_list);$i++){
	         $student_id =$emp_list[$i]['stud_id'];
	         $emp_list[$i]['fees']=$this->Examination_model->getFeedetails($student_id);
	         $emp_list[$i]['isPresent']=$this->Examination_model->getExamformStatus($student_id,$exam_month,$exam_year);
	
          } 			

		//$allstd = array();
		$allstd['ss'] = $emp_list;

		$str_output = json_encode($allstd);
		echo $str_output;

    } 
	function load_schools() {
        if (isset($_POST["school_code"]) && !empty($_POST["school_code"])) {
            //Get all city data
            $stream = $this->Examination_model->get_courses($_POST["school_code"]);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Course</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
                }
            } else {
                echo '<option value="">Course not available</option>';
            }
        }
    }	
	function load_examschools() {
        if (isset($_POST["school_code"]) && !empty($_POST["school_code"])) {
            //Get all city data
            $stream = $this->Examination_model->get_examcourses($_POST["school_code"]);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Course</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
                }
            } else {
                echo '<option value="">Course not available</option>';
            }
        }
    }	
	function load_streams() {
		//echo $_POST["course_id"];exit;
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all streams
            $stream = $this->Examination_model->get_streams($_POST["course_id"]);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Stream</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['stream_id'] . '">' . $value['stream_name'] . '</option>';
                }
            } else {
                echo '<option value="">stream not available</option>';
            }
        }
    }
	// fetch exam strams
	function load_examstreams() {
		//echo $_POST["course_id"];exit;
        if (isset($_POST["course_id"]) && !empty($_POST["course_id"])) {
            //Get all streams
            $stream = $this->Examination_model->get_examstreams($_POST["course_id"]);
            
            //Count total number of rows
            $rowCount = count($stream);

            //Display cities list
            if ($rowCount > 0) {
                echo '<option value="">Select Stream</option>';
                foreach ($stream as $value) {
                    echo '<option value="' . $value['stream_id'] . '">' . $value['stream_name'] . '</option>';
                }
            } else {
                echo '<option value="">stream not available</option>';
            }
        }
    }
		// fetch exam strams
	function load_examsemesters() {
		//echo $_POST["course_id"];exit;
        if (isset($_POST["stream_id"]) && !empty($_POST["stream_id"])) {
            //Get all streams
            $stream = $this->Examination_model->get_examsemester($_POST["stream_id"]);
            
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
    // approve_students 
    public function approve_students()
    {    
		$checked_stud = $_POST['chk_stud'];
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		//print_r($checked_stud);exit;
		foreach ($checked_stud as $stud) {
				$stud_subjects = $this->Examination_model->UpdateApproveStatus($stud,$exam_month, $exam_year);
							
		}
		
		$emp_list = $this->Examination_model->list_exam_allstudents($_POST);
		
		for($i=0;$i<count($emp_list);$i++){
	         $student_id =$emp_list[$i]['stud_id'];
	         $emp_list[$i]['fees']=$this->Examination_model->getFeedetails($student_id);
	         $emp_list[$i]['isPresent']=$this->Examination_model->getExamformStatus($student_id,$exam_month,$exam_year);
	
          } 			

		$allstd = array();
		$allstd['ss'] = $emp_list;
		$str_output = json_encode($allstd);
		echo $str_output;

    }
function hall_ticket($student_id)
	{
		//load mPDF library
		//echo $student_id;
        $this->load->library('m_pdf');
        $this->load->model('Ums_admission_model');
		$stud_id = base64_decode($student_id);
		
		$exam= $this->Examination_model->fetch_stud_curr_exam();
		$this->data['exam']=$exam;
		$exam_month =$exam[0]['exam_month'];
		$exam_year =$exam[0]['exam_year'];
		$this->data['emp_per']= $this->Examination_model->fetch_personal_details($stud_id);
		$this->data['sublist']= $this->Examination_model->getSubjectTimetable($stud_id, $exam_month, $exam_year);


		
		$this->load->library('m_pdf', $param);
			
		$html = $this->load->view($this->view_dir.'indu_exam_hallticket', $this->data, true);
        $pdfFilePath = $this->data['emp_per'][0]['enrollment_no']."_exam_hallticket.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);

        $this->m_pdf->pdf->WriteHTML($html);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");  
		$this->m_pdf->pdf->Output($_SERVER['DOCUMENT_ROOT'] . '/erp/uploads/exam/DEC-2017/HallTicket/'.$pdfFilePath, 'F');
		
		
	} 
	// Report
    public function reports()
    {
       $this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		 $college_id = 1;
		 $this->data['course_details']= $this->Examination_model->getCollegeCourse();
		 $this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		 $this->data['schools']= $this->Examination_model->getSchools();
        $this->load->view($this->view_dir.'exam_reports',$this->data);
        $this->load->view('footer');
       
    }
// generate reports
	function generateReports(){
		if($_POST['report_type']=='HallTicket')
		{
			//$this->load->view('header',$this->data);        
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['course_details']= $this->Examination_model->getCollegeCourse();
			$this->data['schools']= $this->Examination_model->getSchools();
			$exam= $this->Examination_model->fetch_stud_curr_exam();
			$this->data['emp_list']= $this->Examination_model->exam_report_students();
			$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
			
			
			for($i=0;$i<count($this->data['emp_list']);$i++){
				$student_id =$this->data['emp_list'][$i]['stud_id'];
				$exam_month =$exam[0]['exam_month'];
				$exam_year =$exam[0]['exam_year'];
				$this->data['emp_list'][$i]['emp_per']= $this->Examination_model->fetch_personal_details($student_id);
				$this->data['emp_list'][$i]['sublist']= $this->Examination_model->getSubjectTimetable($student_id, $exam_month, $exam_year);

			} 
			
			$this->load->library('m_pdf');
			
			$html = $this->load->view($this->view_dir.'exam_hallticket', $this->data, true);
			$pdfFilePath = $_POST['school_code']."_HallTicket.pdf";

			//$mpdf->WriteHTML($stylesheet,1);
			//$this->m_pdf->pdf->WriteHTML($stylesheet,1);

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
			//ob_end_clean();
		
		}elseif($_POST['report_type']=='AttendanceSheet'){
			
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['course_details']= $this->Examination_model->getCollegeCourse();
			$this->data['schools']= $this->Examination_model->getSchools();
			$exam= $this->Examination_model->fetch_stud_curr_exam();
			
			$this->data['sublist']= $this->Examination_model->fetchExamSubjects();
			$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
			//print_r($this->data['sublist']);exit;
			
			for($i=0;$i<count($this->data['sublist']);$i++){
				$subject_id =$this->data['sublist'][$i]['subject_id'];
				$exam_month =$exam[0]['exam_month'];
				$exam_year =$exam[0]['exam_year'];
				$this->data['sublist'][$i]['studlist']= $this->Examination_model->getSubjectStudentList($subject_id, $exam_month, $exam_year);

			} 
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '-1');
			$this->load->library('m_pdf');
			
			 ob_clean();
			$html = $this->load->view($this->view_dir.'exam_attendent_report', $this->data, true);
			$pdfFilePath1 =$_POST['school_code']."_Attendancesheet.pdf";
		    $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
			//ob_clean();
		}	
	}
	// Report
    public function attendandReport()
    {
       $this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		 $college_id = 1;
		 $this->data['course_details']= $this->Examination_model->getCollegeCourse();
		 $this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		 $this->data['schools']= $this->Examination_model->getExamSchools();
        $this->load->view($this->view_dir.'exam_attreports',$this->data);
        $this->load->view('footer');
       
    }	
// generate reports
	function generateAttendantReports(){
		if($_POST)
		{
			//$this->load->view('header',$this->data);        
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['course_details']= $this->Examination_model->getCollegeCourse();
			$this->data['schools']= $this->Examination_model->getSchools();
			$exam= $this->Examination_model->fetch_stud_curr_exam();
			
			$this->data['sublist']= $this->Examination_model->fetchExamSubjects();
			$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
			//print_r($this->data['sublist']);exit;
			
			for($i=0;$i<count($this->data['sublist']);$i++){
				$subject_id =$this->data['sublist'][$i]['subject_id'];
				$exam_month =$exam[0]['exam_month'];
				$exam_year =$exam[0]['exam_year'];
				$this->data['sublist'][$i]['studlist']= $this->Examination_model->getSubjectStudentList($subject_id, $exam_month, $exam_year);

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
}
?>