<?php
//error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH.'third_party/mpdf/mpdf.php');
class Certificate extends CI_Controller{

	var $currentModule = "";   
	var $title = "";   
	var $table_name = "unittest_master";    
	var $model_name = "Certificate_model";   
	var $model;  
	var $view_dir = 'Certificate/';
 
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
        $this->load->model('Results_model');
		$model = $this->load->model($this->model_name);
		$menu_name = $this->uri->segment(1);
        //15
		 $this->session->userdata("role_id");
		if(($this->session->userdata("role_id")==15)||($this->session->userdata("role_id")==6)){}else{
			redirect('home');
			}
		$this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
        
	}
    
  	public function provisional(){
		//  echo "ex";exit;
		$this->data['academic_year']= $this->Certificate_model->getAcademicYear();	
		$this->data['exam_session']= $this->Certificate_model->fetch_exam_allsession();
		$this->data['schools']= $this->Certificate_model->getSchools();
		$this->load->view('header',$this->data);       
		if($_POST){      
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission_course'];
			$this->data['stream'] =$_POST['admission_branch'];
			$this->data['acd_year'] =$_POST['academic_year'];
			/*$exam = explode('-', $_POST['exam_session']);
			$exam_id =$exam[2];*/
			$stream_id = $_POST['admission_branch'];			
			$this->data['emp_list']= $this->Certificate_model->list_proviCerticateStudents($_POST);
			$this->load->view($this->view_dir.'provisional_certificate_list',$this->data);
			     
		}
		else{
      			 
			$this->data['school_code'] ='';
			$this->data['admissioncourse'] = '';
			$this->data['stream'] = '';
			$this->data['semester'] = '';
			
			$this->load->view($this->view_dir.'provisional_certificate_list',$this->data);      
		} 
		$this->load->view('footer');    
	}

	//search_student
	public function provisional_form(){
		$this->load->view('header',$this->data);
		$this->load->view($this->view_dir.'search_student_byprn',$this->data);
		$this->load->view('footer');
	}
	 
	function search_studentdata($prn=''){
		$this->data['academic_year']= $this->Certificate_model->getAcademicYear();	
		$this->data['exam_session']= $this->Certificate_model->fetch_exam_allsession();
		$stud_prn= $_POST['prn'];		
		if($_POST['edit_flag'] ==''){			
			$this->data['emp']= $this->Certificate_model->get_student_by_prn($stud_prn);  // for add data
		}else{
			$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents($stud_prn); // for edit data
		}

		$html = $this->load->view($this->view_dir.'student_res_ajax_data',$this->data,true);
		echo $html;
	}

	// submit provisional form
	public function add_provisional_form(){  
		$DB1 = $this->load->database('umsdb', TRUE);

		$issued_date = str_replace('/', '-', $_POST['issued_date']);
		$issued_date1 = date('Y-m-d', strtotime($issued_date));
		$student_id = $this->input->post('student_id');
		$exam = explode('-',$this->input->post('degree_completed'));
		$insert_data=array(
			"student_id"=>$student_id,
			"erp_prn"=>$this->input->post('erp_prn'),
			"student_prn"=>$this->input->post('student_prn'),
			"stream_id"=>$this->input->post('stream_id'),		
			"academic_year"=>$this->input->post('academic_year'),
			"degree_completed" =>$exam[0].'-'.$exam[1],
			"exam_id" =>$exam[2],
			"issued_date" => $issued_date1,
			"placed_in" => $this->input->post('placed_in'),
			"ppc_no" => $this->input->post('ppc_no'),
			"entry_by" => $this->session->userdata("uid"),
			"entry_ip" => $_SERVER['REMOTE_ADDR'],
			"entry_on" => date("Y-m-d H:i:s")
		); 		
		$chk_duplicate = $this->Certificate_model->chk_duplicate_prov_form($student_id);
		if(count($chk_duplicate) > 0){
			$provcert_id = $chk_duplicate[0]['provcert_id'];
			$this->Certificate_model->updateMarksCardsNo($provcert_id);
		}

		$DB1->insert("exam_provisional_certificate", $insert_data); 
		//$DB1->last_query();
		echo "SUCCESS";
	} 
	public function update_provisional_form(){  
		$DB1 = $this->load->database('umsdb', TRUE);

		$issued_date = str_replace('/', '-', $_POST['issued_date']);
		$issued_date1 = date('Y-m-d', strtotime($issued_date));
		$provcert_id = $this->input->post('provcert_id');
		$exam = explode('-',$this->input->post('degree_completed'));
		$update_data=array(
			"student_prn"=>$this->input->post('student_prn'),		
			"academic_year"=>$this->input->post('academic_year'),
			"degree_completed" =>$exam[0].'-'.$exam[1],
			"exam_id" =>$exam[2],
			"issued_date" => $issued_date1,
			"placed_in" => $this->input->post('placed_in'),
			"ppc_no" => $this->input->post('ppc_no'),
			"modified_by" => $this->session->userdata("uid"),
			"modified_ip" => $_SERVER['REMOTE_ADDR'],
			"modified_on" => date("Y-m-d H:i:s")
		); 		
		$DB1->where('provcert_id', $provcert_id);
		$DB1->update("exam_provisional_certificate", $update_data);
		//echo $DB1->last_query();exit;  		
		echo "SUCCESS";
	} 
	
	public function download_provisional_certificate($prn)
    {
    		
    		$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents($prn);
			$this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'provisional_certificate_pdf',$this->data, true);
			$pdfFilePath1 =$prn."_provisional_certificate.pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();//$mpdf->adjustFontDescLineheight = 1.14;
			
 
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '25', '25', '30', '25', '57', '25');
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
           $this->m_pdf->pdf->useFixedTextBaseline = false;
           $this->m_pdf->pdf->normalLineheight = 2.3;
           $this->m_pdf->pdf->adjustFontDescLineheight = 2.3;
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");

    }
    //
	function load_examschools(){
		if(isset($_POST["school_code"])){
			$this->load->model('Examination_model');
			if($_POST["school_code"]==0){
				echo '<option value="">Select Course</option>';
				echo '<option value="0">All Course</option>';
			}else{
				$stream = $this->Certificate_model->get_courses($_POST["school_code"]);
	            
				//Count total number of rows
				$rowCount = count($stream);

				//Display cities list
				if($rowCount > 0){
					echo '<option value="">Select Course</option>';
					echo '<option value="0">All Course</option>';
					foreach($stream as $value){
						echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
					}
				} else{
					echo '<option value="">Course not available</option>';
				}
			}
		}
	} 
	function load_streams(){
		//Get all streams
		$stream = $this->Certificate_model->load_streams($_POST["course_id"]);           
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
	}	
	function markscard($exam_master_id='2843'){
		//error_reporting(E_ALL); ini_set('display_errors', 1);
		 //echo "<pre>";
		 $this->load->helper("url");
		 $this->load->model('Results_model');
		 $stud_details  = $this->Certificate_model->get_stud_details_for_certificate($exam_master_id);
		 $stud = $stud_details[0]['stud_id'];
		 $this->data['exam_id'] = $stud_details[0]['exam_id'];
		 $this->data['enrollment_no'] = $stud_details[0]['enrollment_no'];
		 $certf_dat = str_replace('/', '-', $_POST['mrk_cer_date']);
		 $certf_date = date('d M, Y', strtotime($certf_dat));
		 $stream_id = $stud_details[0]['stream_id'];
		 $semester = $stud_details[0]['semester'];
		 $exam_id =$stud_details[0]['exam_id']; 
		 $exam_ses =$stud_details[0]['exam_month'].''.$stud_details[0]['exam_year'];
		 $today_date = date('d-m-Y');
		 $this->data['today_date'] = $today_date;
		 $mrksno  = $this->Certificate_model->fetch_markscard_no($stud_details[0]['enrollment_no'], $stud_details[0]['exam_id']);
		 $this->data['markscard_no'] = $mrksno[0]['markscard_no'];
		 $exam_unique_id  = $this->Results_model->fetch_student_exam_unique_id($stud, $stream_id,$semester,$exam_id);
		 $this->data['stud_data'] = $this->Results_model->fetch_student_grade_details($stud, $stream_id,$semester,$exam_id);
		 //print_r($this->data['stud_data']);exit;
		 $this->data['exam_master_id'][] = $exam_unique_id[0]['exam_master_id'];
		$this->load->view($this->view_dir.'marsk_card_certificate',$this->data);
	}
	
	
	public function download_degree_certificate($prn='160106061002')
    {
		   // $student = $_POST['chk_stud'];
			//foreach($student as $stud)
			{
			//	$prn=$stud;
    		$exam_ses="DEC-2017";
			///////////////////
			include_once "phpqrcode/qrlib.php";
			//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
			$tempDir = 'uploads/exam/'.$exam_ses.'/';
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0755, true);
			}
			//$po_id = $p_row[0]['ord_no'];
			$site_url="https://sandipuniversity.com/erp/";
			$codeContents = $site_url.'check.php?po='.$prn;
			
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = 'qrcode_'.$prn.'.png';		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	
			//////////////////
			
			
    		$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents($prn);
			$this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'degree_certificate_pdf',$this->data, true);
			$pdfFilePath1 =$prn."_degree_certificate.pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();//$mpdf->adjustFontDescLineheight = 1.14;
			
 
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '25', '25', '25', '25', '47', '25');
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;
		    //$this->m_pdf->pdf->SetDefaultBodyCSS('line-height', 5.2);
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
			}

    }





	public function view($prn)
    {
		$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents($prn);			
		$this->load->view($this->view_dir.'degree_certificate_html',$this->data);

    }	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	


 public function Degree_Certificate() //markscard_new
	{
	   // error_reporting(E_ALL);exit();
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Marks_model');
		$this->load->model('Results_model');
		$this->data['regulatn']= $this->Exam_timetable_model->getRegulation();
	    if($_POST){
	        //  echo "<pre>";
	        //  print_r($_POST);exit;
	        $this->load->view('header',$this->data);
			$this->data['regulation'] =$_POST['regulation'];
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission_course'];
	        $this->data['stream'] =$_POST['admission_branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
			
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
			$this->data['exam_new'] =$exam_month.'-'.$exam_year;
			 
			 $this->data['schoolname_new']= $_POST['schoolname'];
			 $this->data['admissioncourse_new']= $_POST['admissioncourse'];
			 $this->data['admissionbranch_new']= $_POST['admissionbranch'];
			
		    $this->data['stud_list']= $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id);	   				     
		    $this->load->view($this->view_dir.'Certificate_view',$this->data); //markscard_view

	        $this->load->view('footer');
	    }
	    else
	    {
	        
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] ='';
	        $this->data['admissioncourse'] = '';
	        $this->data['stream'] = '';
	        $this->data['semester'] = '';
	        
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
	        $this->load->view($this->view_dir.'Certificate_view',$this->data); //markscard_view
	        $this->load->view('footer');
	        
	    }
	    
	    
	}
	
	public function Gradesheet() //markscard_new
	{
	   // error_reporting(E_ALL);exit();
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Marks_model');
		$this->load->model('Results_model');
		$this->data['regulatn']= $this->Exam_timetable_model->getRegulation();
	    if($_POST){
	          //echo "<pre>";
	         // print_r($_POST);exit;
	        $this->load->view('header',$this->data);
			$this->data['regulation'] =$_POST['regulation'];
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission_course'];
	        $this->data['stream'] =$_POST['admission_branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
			
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
			$this->data['exam_new'] =$exam_month.'-'.$exam_year;
			 
			 $this->data['schoolname_new']= $_POST['schoolname'];
			 $this->data['admissioncourse_new']= $_POST['admissioncourse'];
			 $this->data['admissionbranch_new']= $_POST['admissionbranch'];
			
		    $this->data['stud_list']= $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id);	   				     
		    $this->load->view($this->view_dir.'Gradesheet_view',$this->data); //markscard_view

	        $this->load->view('footer');
	    }
	    else
	    {
	        
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] ='';
	        $this->data['admissioncourse'] = '';
	        $this->data['stream'] = '';
	        $this->data['semester'] = '';
	        
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
	        $this->load->view($this->view_dir.'Gradesheet_view',$this->data); //markscard_view
	        $this->load->view('footer');
	        
	    }
	    
	    
	}

	
		// fetch result streams
	function load_resultstreams(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["course_id"]) && !empty($_POST["course_id"])){
			//Get all streams
			$stream = $this->Results_model->load_resultstreams($_POST["course_id"], $_POST["exam_session"]);
            
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
	
	function load_edsemesters(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			$ex_se = explode('-', $_POST["ex_ses"]);
			//Get all streams
			echo $stream = $this->Certificate_model->load_edsemesters($_POST["stream_id"], $ex_se[2]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			/*if($rowCount > 0){
				echo '<option value="">Select Semester</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
				}
			} else{
				echo '<option value="">Semester not available</option>';
			}*/
			
		}
	}	
	
	function Test_load(){
					$stream = $this->Certificate_model->load_edsemesters('6', '1');
					//print_r();
}

function load_edstreams(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["course_id"]) && !empty($_POST["course_id"])){
			$ex_se = explode('-', $_POST["ex_ses"]);
			//Get all streams
			$stream = $this->Certificate_model->load_edstreams($_POST["course_id"], $ex_se[2],$_POST["school_code"]);
            
			//Count total number of rows
			$rowCount = count($stream);
            $select="";
			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
				
				foreach($stream as $value){
					
					if($_POST['admission_branch']==$value['stream_id']){
					$select="selected";
				    }else{
					$select="";	
					}
					echo '<option value="' . $value['stream_id'] . '"'.$select.'>' . $value['stream_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">stream not available</option>';
			}
		}
	}
	function load_edschools(){

		if($_POST["school_code"] !=''){
			$ex_se = explode('-', $_POST["ex_ses"]);
			//Get all city data
			$stream = $this->Certificate_model->get_edcourses($_POST["school_code"], $ex_se[2]);
            
			//Count total number of rows
			echo $rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Course</option>';
			//	echo '<option value="0">All Course</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
			/*} else{
				echo '<option value="">Course not available</option>';
			}*/
		}
	}	
	
	/*function load_edstreams(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["course_id"]) && !empty($_POST["course_id"])){
			$ex_se = explode('-', $_POST["ex_ses"]);
			//Get all streams
			$stream = $this->Certificate_model->load_edstreams($_POST["course_id"], $ex_se[2]);
            
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
	}*/
	
	function generate_markscard(){
		//print_r($_REQUEST);
		//error_reporting(E_ALL); ini_set('display_errors', 1);
		 //echo "<pre>";
		// echo $chk_stud= $chk_checked; $semester=$sem;$admission_stream=$stream;$exam_session=$exam_session;
	     //print_r($_POST);exit;
		 //$this->Results_model->fetch_student_grade_details($_POST);
		 if($_POST['stream_id'] !='71'){
			//echo '1t';
			 $student = $_POST['chk_stud'];
			 $exam_session = explode('~', $_POST['exam_session']);
			 $certf_dat = str_replace('/', '-', $_POST['mrk_cer_date']);
			 $certf_date = date('d M, Y', strtotime($certf_dat));
			 $stream_id = $_POST['stream_id'];
			 $semester = $_POST['semester'];
			 $exam_id =$exam_session[2]; 
			 $exam_ses =$exam_session[0].''.$exam_session[1];
			 $today_date = date('d-m-Y');
			 $gd_log['exam_id'] = $exam_id;	
			 $gd_log['generated_by'] = $this->session->userdata("uid");
			 $gd_log['generated_on'] = date('Y-m-d H:i:s');
			 $gd_log['generated_ip'] = $this->input->ip_address();

			 foreach($student as $stud){
				 $exam_unique_id  = $this->Results_model->fetch_student_exam_unique_id($stud, $stream_id,$semester,$exam_id);
				 $this->data['stud_data'][] = $this->Results_model->fetch_student_grade_details($stud, $stream_id,$semester,$exam_id);
				 $this->data['exam_master_id'][] = $exam_unique_id[0]['exam_master_id'];
	  //$this->data['stud_data'][][]=$this->Results_model->fetch_student_grades($stud,$exam_id);
				 ///////////////////
				include_once "phpqrcode/qrlib.php";
				//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
				//The name of the directory that we need to create.
				$tempDir = 'uploads/gradesheet/'.$exam_ses.'/QRCode/';
				//Check if the directory already exists.
				if(!is_dir($tempDir)){
					//Directory does not exist, so lets create it.
					mkdir($tempDir, 0755, true);
				}
				
				//$po_id = $p_row[0]['ord_no'];
				$siteurl="https://sandipuniversity.com/student/";
				$codeContents = $siteurl.'index.php?type=cert&id='.$exam_unique_id[0]['exam_master_id'];
				
				// we need to generate filename somehow, 
				// with md5 or with database ID used to obtains $codeContents...
				$fileName = 'qrcode_'.$exam_unique_id[0]['exam_master_id'].'.png';		
				$pngAbsoluteFilePath = $tempDir.$fileName;
				$urlRelativeFilePath = $pngAbsoluteFilePath;
				
				// generating
				//if (!file_exists($pngAbsoluteFilePath)) {
				QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 2, 2);	
				//////////////////
				//log start
				$gd_log['student_id'] = $stud;
				$gd_log['enrollment_no'] = $exam_unique_id[0]['enrollment_no'];	
				//echo '2t';
				$this->Results_model->save_gradesheet_log($gd_log);
			 }//echo '3t';
			 $strmname = $this->data['stud_data'][0][0]['stream_short_name'];
			 //print_r($this->data['stud_data']);exit;
			 $report_type= $_POST['report_type'];
			 if($report_type=='pdf')
			 {//echo '4t';
				$this->load->library('m_pdf');
				$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '30', '10', '10', '10', '5');
				$html = $this->load->view($this->view_dir.'marsk_card_pdf',$this->data, true);
				//echo $html;
				//exit();
				$pdfFilePath1 =$strmname.'_'.$semester."_Markscard.pdf";
				$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
				//$header='';
				//echo '5t';
				$mpdf=new mPDF();
				$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:58px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"><img src="'.base_url().'assets/images/Sign COE 01.png" height="50" width="200"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" class="signature" style="margin-left:150px;margin-top:1px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top"><strong>'; $footer .=$certf_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>

				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;">'.$today_date.'</small></td>
	</tr>
	</table>'; //echo '6t';
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLFooter($footer);
				$this->m_pdf->pdf->AddPage();
				$this->m_pdf->pdf->WriteHTML($html);	
				//echo '7t';
				//download it.
				$this->m_pdf->pdf->Output($pdfFilePath1, "D");
			 }else{
				$this->load->view($this->view_dir.'marsk_card_excel',$this->data); 
			 }
		}else{
			//echo 'TEAT';
			// for dpharma
			 $student = $_POST['chk_stud'];
			 $exam_session = explode('~', $_POST['exam_session']);
			 $certf_dat = str_replace('/', '-', $_POST['mrk_cer_date']);
			 $certf_date = date('d M, Y', strtotime($certf_dat));
			 $stream_id = $_POST['stream_id'];
			 $semester = $_POST['semester'];
			 $exam_id =$exam_session[2]; 
			 $exam_ses =$exam_session[0].''.$exam_session[1];
			 $today_date = date('d-m-Y');
			 $gd_log['exam_id'] = $exam_id;	
			 $gd_log['generated_by'] = $this->session->userdata("uid");
			 $gd_log['generated_on'] = date('Y-m-d H:i:s');
			 $gd_log['generated_ip'] = $this->input->ip_address();

			 foreach($student as $stud){
				 $exam_unique_id  = $this->Results_model->fetch_student_exam_unique_id($stud, $stream_id,$semester,$exam_id);
				 $this->data['stud_data'][] = $this->Results_model->fetch_student_grade_details($stud, $stream_id,$semester,$exam_id);
				 $this->data['exam_master_id'][] = $exam_unique_id[0]['exam_master_id'];
	  //$this->data['stud_data'][][]=$this->Results_model->fetch_student_grades($stud,$exam_id);
				 ///////////////////
				include_once "phpqrcode/qrlib.php";
				//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
				//The name of the directory that we need to create.
				$tempDir = 'uploads/gradesheet/'.$exam_ses.'/QRCode/';
				//Check if the directory already exists.
				if(!is_dir($tempDir)){
					//Directory does not exist, so lets create it.
					mkdir($tempDir, 0755, true);
				}
				
				//$po_id = $p_row[0]['ord_no'];
				$siteurl="https://sandipuniversity.com/student/";
				$codeContents = $siteurl.'index.php?type=cert&id='.$exam_unique_id[0]['exam_master_id'];
				
				// we need to generate filename somehow, 
				// with md5 or with database ID used to obtains $codeContents...
				$fileName = 'qrcode_'.$exam_unique_id[0]['exam_master_id'].'.png';		
				$pngAbsoluteFilePath = $tempDir.$fileName;
				$urlRelativeFilePath = $pngAbsoluteFilePath;
				
				// generating
				//if (!file_exists($pngAbsoluteFilePath)) {
				QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 2, 2);	
				//////////////////
				//log start
				$gd_log['student_id'] = $stud;
				$gd_log['enrollment_no'] = $exam_unique_id[0]['enrollment_no'];	
				$this->Results_model->save_gradesheet_log($gd_log);
			 }
			 $strmname = $this->data['stud_data'][0][0]['stream_short_name'];
			 //print_r($this->data['stud_data']);exit;
			 $report_type= $_POST['report_type'];
			 if($report_type=='pdf')
			 {
				$this->load->library('m_pdf');
				$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '20', '10', '10', '10', '5');
				$html = $this->load->view($this->view_dir.'dpharma_marsk_card_pdf',$this->data, true);
		//		echo $html;
			//	exit();
				$pdfFilePath1 =$strmname.'_'.$semester."_Markscard.pdf";
				$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
				//$header='';
				$mpdf=new mPDF();
				$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:55px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"><img src="'.base_url().'assets/images/Sign COE 01.png" height="50" width="200"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" class="signature" style="margin-left:150px;margin-top:1px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top"><strong>'; $footer .=$certf_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;"></small></td>
	</tr>
	</table>';
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLFooter($footer);
				$this->m_pdf->pdf->AddPage();
				$this->m_pdf->pdf->WriteHTML($html);	
				
				//download it.
				$this->m_pdf->pdf->Output($pdfFilePath1, "D");
			 }else{
				//$this->load->view($this->view_dir.'marsk_card_excel',$this->data); 
			 }
		 }
	}
	// generate markscard excel
	function generate_markscard_excel(){
		 //echo "<pre>";
		// echo $chk_stud= $chk_checked; $semester=$sem;$admission_stream=$stream;$exam_session=$exam_session;
	     //print_r($_POST);exit;
		 //$this->Results_model->fetch_student_grade_details($_POST);
		 $student = $_POST['chk_stud'];
		 $exam_session = explode('~', $_POST['exam_session']);;
		 $stream_id = $_POST['stream_id'];
		 $semester = $_POST['semester'];
		 $exam_id =$exam_session[2]; 
		 foreach($student as $stud){			
			 $this->data['stud_data'][] = $this->Results_model->fetch_student_grade_details($stud, $stream_id,$semester,$exam_id);
		 }
		 $strmname = $this->data['stud_data'][0][0]['stream_short_name'];
		 //print_r($this->data['stud_data']);exit;
		$this->load->view($this->view_dir.'marsk_card_excel',$this->data); 

	}	
	
	public function download_degree_certificate_new()
    {
		  
		/*foreach($student as $key=>$value){
			//echo $prn=$value; echo '<br>';
				 echo $stream_id[$key];echo 'y<br>';
				//echo  $exam_id[$key];echo '<br>';
			
	if(!empty($value)){
			 	 
			 	echo $prn=$value; echo '<br>';
				 echo $stream_id[$key];echo '<br>';
				echo  $exam_id[$key];echo '<br>';
	}
}



exit;*/
		 $this->data['regulation']=$_REQUEST['regulation'];
		 $this->data['exam_session']=$_REQUEST['exam_session'];
		 $this->data['school_code']=$_REQUEST['school_code'];
		 $this->data['admission_course']=$_REQUEST['admission_course'];
		 $this->data['admission_branch']=$_REQUEST['admission_branch'];
		 $this->data['mrk_cer_date']=$_REQUEST['mrk_cer_date'];
		  //$mrk_cer_date
		 $report_type=$_REQUEST['report_type'];
		 if($report_type=="Degree"){
			//$stream_id[0];
		//	exit;
			//  exam_session
			//exit;
			$i;
			
			/*foreach($student as $stud){
			 	echo $prn=$stud; echo '<br>';
			}
			exit;*/
			$this->load->library('m_pdf');
			$mpdf=new mPDF();
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '25', '25', '25', '25', '47', '25');

            if(isset($_REQUEST['chk_stud'])) {
			//if(!empty($_REQUEST['chk_stud'])){
            $student = $_REQUEST['chk_stud'];
		 //exit;
		//$student=array();
		 $stream_id=  $_REQUEST['stream_idn'];
		$exam_id=  $_REQUEST['exam_idn'];
       
	 //  echo $_REQUEST['exam_session'];
	   $exam_ses = explode('~', $_REQUEST['exam_session']);
	 //  echo $exam_ses[0];
     //  echo $exam_ses[1];
	   
			foreach($student as $key=>$value){
			if(!empty($value)){
			 	 $prn=$value; echo '<br>';
				  $stream_id[$key];echo '<br>';
				  $exam_id[$key];
				
			//exit;
    		//$exam_ses=$_REQUEST['exam_session'];//"DEC-2017";
			$exam_ses = explode('~', $_REQUEST['exam_session']);
			///////////////////
			include_once "phpqrcode/qrlib.php";
			//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
			$tempDir = 'uploads/degree/'.$exam_ses[0].'/'.$exam_ses[1].'/';//'/'.$stream_id.'/'.$exam_id
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0755, true);
			}
			//$po_id = $p_row[0]['ord_no'];
			$site_url="https://sandipuniversity.com/erp/";
		    $codeContents = $site_url."Result.php?po=".$prn."&exam_month=".$exam_ses[0]."&exam_year=".$exam_ses[1];
			//exit;//'&stream_id='.$stream_id.'&exam_id='.$exam_id
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = "qrcode_".$prn.".png";		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	
			//////////////////
			
			
    		$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents_new($_REQUEST,$prn,$stream_id[$key],$exam_id[0]);
			
		//	exit;
			//if(!empty($this->data['emp'])){
			$html = $this->load->view($this->view_dir.'degree_certificate_pdf',$this->data, true);
		//	$pdfFilePath1 =$prn."_degree_certificate.pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			//$mpdf->adjustFontDescLineheight = 1.14;
			
 
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;
		    //$this->m_pdf->pdf->SetDefaultBodyCSS('line-height', 5.2);
			$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			//}
			$i++;
		//	ob_clean();
			}//$val
			} //foreach
		//	}
			}
			$pdfFilePath1 =$prn."_degree_certificate.pdf";
			$this->m_pdf->pdf->Output($tempDir.'/'.$pdfFilePath1, "F");
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
			
			
			////////////////////////////////////////////////////////////////////////////////////////////
			}else if($report_type=="Provisional"){
			  $student = $_REQUEST['chk_stud'];
			
			// $prn = $this->uri->segment(3);
			// $stream = $this->uri->segment(4);
			// $exam_id = $this->uri->segment(5);
			  $stream_id=  $_REQUEST['stream_idn'];
		      $exam_id=  $_REQUEST['exam_idn'];
			 
			$this->load->library('m_pdf');
			$mpdf=new mPDF();
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '25', '25', '25', '25', '47', '25');
			
			$i=0;
			//if(isset($_REQUEST['chk_stud'])) {
			foreach($student as $key=>$value){
				 $prn=$value;
    		$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents_new($_REQUEST,$prn,$stream_id[$key],$exam_id[0]);
			
			//print_r($this->data['emp']);
			//exit;
			
			$html = $this->load->view($this->view_dir.'provisional_certificate_new_pdf.php',$this->data,true);
			//print_r($html);
			//exit;
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			//$mpdf=new mPDF();//$mpdf->adjustFontDescLineheight = 1.14;
			
 
			//$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '25', '25', '30', '25', '57', '25');
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.3;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.3;
			$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$i++;
			ob_clean();
			
			}
			//}
			$pdfFilePath1 =$prn."_provisional_certificate.pdf";
			//$this->m_pdf->pdf->Output($pdfFilePath1, "F");
			 $this->m_pdf->pdf->Output($pdfFilePath1, "D");
			}

    }
	
	
	public function provisional_New(){
		//  echo "ex";exit;
		$this->data['academic_year']= $this->Certificate_model->getAcademicYear();	
		$this->data['exam_session']= $this->Certificate_model->fetch_exam_allsession();
		$this->data['schools']= $this->Certificate_model->getSchools();
		$this->load->view('header',$this->data);       
		if($_POST){      
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission_course'];
			$this->data['stream'] =$_POST['admission_branch'];
			$this->data['acd_year'] =$_POST['academic_year'];
			/*$exam = explode('-', $_POST['exam_session']);
			$exam_id =$exam[2];*/
			$stream_id = $_POST['admission_branch'];			
			$this->data['emp_list']= $this->Certificate_model->list_proviCerticateStudents_new($_POST);
			$this->load->view($this->view_dir.'provisional_certificate_list_new',$this->data);
			     
		}
		else{
      			 
			$this->data['school_code'] ='';
			$this->data['admissioncourse'] = '';
			$this->data['stream'] = '';
			$this->data['semester'] = '';
			
			$this->load->view($this->view_dir.'provisional_certificate_list_new',$this->data);      
		} 
		$this->load->view('footer');    
	}
	
	public function download_provisional_certificate_new()
    {
    		 $prn = $this->uri->segment(3);
			 $stream = $this->uri->segment(4);
			 $exam_id = $this->uri->segment(5);
			
    		$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents_new('',$prn,$stream,$exam_id);
			
			//print_r($this->data['emp']);
			//exit;
			$this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'provisional_certificate_new_pdf.php',$this->data, true);
			$pdfFilePath1 =$prn."_provisional_certificate.pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();//$mpdf->adjustFontDescLineheight = 1.14;
			
 
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '25', '25', '30', '25', '57', '25');
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.3;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.3;
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");

    }
	public function Manual_excel(){
		
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Marks_model');
		$this->load->model('Results_model');
		$this->data['regulatn']= $this->Exam_timetable_model->getRegulation();
	    if($_POST){
	         // echo "<pre>";
	         // print_r($_POST);exit;
	        $this->load->view('header',$this->data);
			$this->data['regulation'] =$_POST['regulation'];
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission_course'];
	        $this->data['stream'] =$_POST['admission_branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
			
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
			$this->data['exam_new'] =$exam_month.'-'.$exam_year;
			 
			 $this->data['schoolname_new']= $_POST['schoolname'];
			 $this->data['admissioncourse_new']= $_POST['admissioncourse'];
			 $this->data['admissionbranch_new']= $_POST['admissionbranch'];
			
		//$cd= $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id);	   				     
		   // $this->load->view($this->view_dir.'Certificate_view',$this->data); //markscard_view
		   // echo "<pre>";
	         // print_r($cd);exit;
		 //  foreach($cd as $val) { 
          //echo $val['Result'];
		//   }
	       // $this->load->view('footer');
	  //  }	
		
		
		
		
		
		
		//$this->load->view('header',$this->data);
		// $this->load->view($this->view_dir.'manual_excel');
		   // $this->load->view('footer');
		  //  function export_cd_fou_list($coid='',$sid='',$cid='',$rid=''){
//exit;
$this->load->library('excel');  
header('Content-Type: application/vnd.ms-excel');
header('Cache-Control: max-age=0');
header('Content-Disposition: attachment;filename="Degree_Certificate.xls"');
$styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
  );
$styleArray1 = array(
    'font'  => array(
        'bold'  => true,       
        'size'  => 8,
        'name'  => 'Arial'
    ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));
		
		$styleArray2 = array(
    'font'  => array(
        'size'  => 8,
        'name'  => 'Times New Roman'
    ),
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' =>PHPExcel_Style_Alignment::VERTICAL_CENTER
        ));

      $object = new PHPExcel();
	 // $object->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(false);
      $object->getActiveSheet()->getColumnDimensionByColumn('B')->setWidth('50');
	  $object->setActiveSheetIndex(0);
	  
	  
	  $object->getActiveSheet()->mergeCells('B2:F2');
	 // $object->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###0');
      
      $object->getActiveSheet()->getStyle('B2:F2')->getFont()->setBold(true);
      $object->getActiveSheet()->getStyle('B2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $object->getActiveSheet()->setCellValue('B2', 'SANDIP UNIVERSITY,NASHIK');
      $object->getActiveSheet()->mergeCells('B3:F3');  
	  $object->getActiveSheet()->getStyle('B3:F3')->getFont()->setBold(true);
      $object->getActiveSheet()->getStyle('B3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	  $object->getActiveSheet()->setCellValue('B3', 'OFFICE OF THE CONTROLLER OF EXAMINATIONS');
      $object->getActiveSheet()->mergeCells('B6:F6');  
      $object->getActiveSheet()->getStyle('B6:F6')->getFont()->setBold(true);      
      $object->getActiveSheet()->getStyle('B6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	  $object->getActiveSheet()->setCellValue('B6', 'Degree Certificate Details ');
      
	  $object->getActiveSheet()->mergeCells('B8:F8');  
      $object->getActiveSheet()->getStyle('B8:F8')->getFont()->setBold(true);      
      $object->getActiveSheet()->getStyle('B8:F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	  $object->getActiveSheet()->setCellValue('B8', 'SCHOOL NAME: ');
	  
	  $object->getActiveSheet()->mergeCells('B9:F9');  
      $object->getActiveSheet()->getStyle('B9:F9')->getFont()->setBold(false);      
      $object->getActiveSheet()->getStyle('B9:F9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	  $object->getActiveSheet()->setCellValue('B9',$_POST['schoolname']);

      $object->getActiveSheet()->mergeCells('B10:F10');  
      $object->getActiveSheet()->getStyle('B10:F10')->getFont()->setBold(true);      
      $object->getActiveSheet()->getStyle('B10:F10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	  $object->getActiveSheet()->setCellValue('B10', 'PROGRAMME NAME & SPECIALIZATION:                                  BATCH :');
	  
	  $object->getActiveSheet()->mergeCells('B11:F11');  
      $object->getActiveSheet()->getStyle('B11:F11')->getFont()->setBold(false);      
      $object->getActiveSheet()->getStyle('B11:F11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	  $object->getActiveSheet()->setCellValue('B11', '                   '.$_POST['admissioncourse'].'         
	                                                                                    '.$_POST['admissionbranch']);
	  
	   $object->getActiveSheet()->mergeCells('B12:F12');  
      $object->getActiveSheet()->getStyle('B12:F12')->getFont()->setBold(true);      
      $object->getActiveSheet()->getStyle('B12:F12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	  $object->getActiveSheet()->setCellValue('B12', ' REGULATIONS:                Month & Year of Passing: ');
      $object->getActiveSheet()->mergeCells('B13:F13');  
      $object->getActiveSheet()->getStyle('B13:F13')->getFont()->setBold(false);      
      $object->getActiveSheet()->getStyle('B13:F13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	  $object->getActiveSheet()->setCellValue('B13', ' '.$_POST['regulation'].'                                   '.$_POST['exam_session']);
    

      $object->getActiveSheet()->setCellValue('A16', 'Sr.no');
	  $object->getActiveSheet()->getStyle('A16')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  
	   
	  $object->getActiveSheet()->setCellValue('B16', 'PRN');
	  $object->getActiveSheet()->getStyle('B16')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	 
	  
	  
	  $object->getActiveSheet()->getColumnDimensionByColumn('C')->setAutoSize(false);
      $object->getActiveSheet()->getColumnDimensionByColumn('C')->setWidth('10');
	  $object->getActiveSheet()->setCellValue('C16', 'Student Name');
	  $object->getActiveSheet()->getStyle('C16')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  
	   $object->getActiveSheet()->getColumnDimensionByColumn('D')->setAutoSize(false);
      $object->getActiveSheet()->getColumnDimensionByColumn('D')->setWidth('10');
	  $object->getActiveSheet()->setCellValue('D16', 'Classification');
	  $object->getActiveSheet()->getStyle('D16')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	 
	  
	  $object->getActiveSheet()->getColumnDimensionByColumn('E')->setAutoSize(false);
      $object->getActiveSheet()->getColumnDimensionByColumn('E')->setWidth('10');
	  $object->getActiveSheet()->setCellValue('E16', 'CGPA');
	  $object->getActiveSheet()->getStyle('E16')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  
	  
	  $object->getActiveSheet()->getColumnDimensionByColumn('F')->setAutoSize(false);
      $object->getActiveSheet()->getColumnDimensionByColumn('F')->setWidth('10');
	  $object->getActiveSheet()->setCellValue('F16', 'Attempt');
	  $object->getActiveSheet()->getStyle('F16')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  

/*$this->excel->getActiveSheet()->setCellValue('A4', 'Sr.No');
$this->excel->getActiveSheet()->setCellValue('B4', 'PRN');
$this->excel->getActiveSheet()->setCellValue('C4', 'Student Name');
$this->excel->getActiveSheet()->setCellValue('D4', 'Classification');
$this->excel->getActiveSheet()->setCellValue('E4', 'CGPA');
$this->excel->getActiveSheet()->setCellValue('F4', 'Attempt');*/

/*$coid=$_REQUEST['coid'];
$sid=$_REQUEST['sid'];
$cid=$_REQUEST['cid'];
$rid=$_REQUEST['rid'];*/
/*if($coid !=''){
  $d['coid'] = $coid;
}    
if($sid !=''){
  $d['sid'] = $sid;
}    
if($cid !=''){
  $d['cid'] = $cid;
} 
if($rid !=''){
  $d['rid'] = $rid;
}     */
$Honours='0'; $Distinction='0';  $FirstClass='0';     $SecondClass='0';   $ThirdClass='0';
       $cd = $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id);;
        $i=1;
	    $j=17;
        foreach($cd as $val) { 
		                           if(($val['Result']=="Honours")){
									$Resultn= "FCH";
									}else if($val['Result']=="Distinction") {
									$Resultn= "FWD";
									}else if($val['Result']=="First Class") {
									$Resultn=  "FC";	
									}else if($val['Result']=="Second Class") {
									$Resultn=  "SC";	
									}else if($val['Result']=="Third Class") {
									$Resultn=  "TC";	
									}
									
									if(($val['Result']=="Honours")){
									$Honours +=1;
									}else if($val['Result']=="Distinction") {
									$Distinction +=1;
									}else if($val['Result']=="First Class") {
									$FirstClass +=1;	
									}else if($val['Result']=="Second Class") {
									$SecondClass +=1;	
									}else if($val['Result']=="Third Class") {
									$ThirdClass +=1;		
									}
		  if($val['checb']==0){ $attm='First Attempt'; }else{ $attm='-';}
        	//$reff= $this->Students_model->get_ic_details($val['co_reff_by']);
        /*$this->excel->getActiveSheet()->setCellValue('A'.$j,$k );
        $this->excel->getActiveSheet()->setCellValue('B'.$j,$val['enrollment_no'] );
        $this->excel->getActiveSheet()->setCellValue('C'.$j,$val['stud_name'] );
        $this->excel->getActiveSheet()->setCellValue('D'.$j,$Resultn );
        $this->excel->getActiveSheet()->setCellValue('E'.$j,$val['cumulative_gpa'] );
        $this->excel->getActiveSheet()->setCellValue('F'.$j,$attm );*/
		
$object->getActiveSheet()->setCellValue('A'.$j, $i);
$object->getActiveSheet()->getStyle('A'.$j.':F'.$j)->applyFromArray($styleArray)->applyFromArray($styleArray2);
$object->getActiveSheet()->setCellValue('B'.$j, $val['enrollment_no']);

$object->getActiveSheet()->setCellValue('C'.$j, $val['stud_name']);
//$object->getActiveSheet()->setCellValue('E'.$j, $val['gender']);
$object->getActiveSheet()->setCellValue('D'.$j,$Resultn);
$object->getActiveSheet()->setCellValue('E'.$j, $val['cumulative_gpa']);
$object->getActiveSheet()->setCellValue('F'.$j, $attm);
		
       // $i++;
      $i++;
$j++;
 }
     $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		$objWriter->setPreCalculateFormulas(true);      
		
		
			echo $objWriter->save('php://output');
/*$ct = $j+1;
for($k=0; $k<$ct; $k++){
  $this->excel->getActiveSheet()->getStyle("A".$k.":N".$k)->applyFromArray(
    array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_MEDIUM         
        )
      )
    )
  );
}
$filename= 'fou_cl_List.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output');*/

    // }
	}
	}//Post

/////////////////////////////////////////////////////////////////////////////////
public function Manual_Pdf()
    {
		 
       
	        $this->data['regulation'] =$_POST['regulation'];
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission_course'];
	        $this->data['stream'] =$_POST['admission_branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];
//$this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
			
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
			$this->data['exam_new'] =$exam_month.'-'.$exam_year;
			 
			$this->data['schoolname_new']= $_POST['schoolname'];
		    $this->data['admissioncourse_new']= $_POST['admissioncourse'];
			$this->data['admissionbranch_new']= $_POST['admissionbranch'];
			
		    $this->data['stud_list']= $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id);
	   
	   
	   
	//print_r($this->data['stud_list']);
	   
	      //exit;
		 
		 $this->load->library('m_pdf');
		 $mpdf=new mPDF();
		 //$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '20', '20', '20', '20', 'upper_margin', '20');

		 $this->m_pdf->pdf = new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
		 
		 //////////////////////////////////////////////////////////////////////////////////////////////
		 //	exit;
			//if(!empty($this->data['emp'])){
			$html = $this->load->view($this->view_dir.'pdf_manually.php',$this->data, true);
		//	$pdfFilePath1 =$prn."_degree_certificate.pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			//$mpdf->adjustFontDescLineheight = 1.14;
			
 
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;
		    //$this->m_pdf->pdf->SetDefaultBodyCSS('line-height', 5.2);
			/*$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];*/
		//	$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			//}
		//	$i++;
		    $currtnt_time= $this->data['schoolname_new'];//date('y-m-d h:i:s');
		    $pdfFilePath1 =$currtnt_time."_degree_certificate.pdf";
		//	$this->m_pdf->pdf->Output($tempDir.'/'.$pdfFilePath1, "F");
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		 
		 	
    }	
	
	function Manual_certificate(){
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);		//exit;
       $prn = $this->uri->segment(3);
	   $stream_id = $this->uri->segment(4);
	   $school_code = $this->uri->segment(5);
	   $exam_id = $this->uri->segment(6);
	   $semester = $this->uri->segment(7);
       $student_id = $this->uri->segment(8);
	   $this->data['semester']=$semester;
		$stud_list= $this->Certificate_model->Manual_certificate($prn,$stream_id,$school_code,$exam_id,$semester,$student_id);
	   $stud_list = $this->orderBy($stud_list, 'subject_order');
	   $this->data['stud_list']=$stud_list;
	   
	   
	//print_r($this->data['stud_list']);
	   
	      //exit;
	// $k=$this->load->view($this->view_dir.'manual_certificate.php',$this->data,true);
//echo $k;
//exit;
$exam_ses="2019_May";
///////////////////
			include_once "phpqrcode/qrlib.php";
			//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
			$tempDir = 'uploads/grade_sheet/'.$exam_ses.'/';
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0777, true);
			}
			//$po_id = $p_row[0]['ord_no'];
			$site_url="https://sandipuniversity.com/erp/";
			$codeContents = $site_url.'grade_sheet.php?po='.$stud_list[0]['enrollment_no'];
			
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = 'qrcode_'.$stud_list[0]['enrollment_no'].'.png';		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	



         $dattime=date('Y-m-d');
		 $this->load->library('m_pdf');
		 $mpdf=new mPDF();
		 //$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '20', '20', '20', '20', 'upper_margin', '20');

		 $this->m_pdf->pdf = new mPDF('utf-8', 'A4', '5', '5', '5', '5', '55', '20');
		 
		 //////////////////////////////////////////////////////////////////////////////////////////////
		 //	exit;
			//if(!empty($this->data['emp'])){
				 //   $stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css');

			  $html = $this->load->view($this->view_dir.'manual_certificate.php',$this->data, true);
			  
			// $this->load->view($this->view_dir.'manual_certificate.php',$this->data);
			//exit;
		//	$pdfFilePath1 =$prn."_degree_certificate.pdf";
			//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			//$mpdf->adjustFontDescLineheight = 1.14;
			
 
			/*$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;*/
		    //$this->m_pdf->pdf->SetDefaultBodyCSS('line-height', 5.2);
			/*$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];*/
		//	$this->m_pdf->pdf->AddPage();
			//$this->m_pdf->pdf->WriteHTML($stylesheet,1);
			/*$footer = '<div class="row" style="margin-top:-30px;">
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;'.$dattime.'</div>
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:right"></div>
</div><div class="row">
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:left"></div>
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:right"></div>
</div>';*/

 /*$this->m_pdf->pdf->SetHTMLFooter('
<table width="100%">
    <tr>
        <td width="33%">{DATE j-m-Y}</td>
        <td width="33%" align="center">{PAGENO}/{nbpg}</td>
        <td width="33%" style="text-align: right;">My document</td>
    </tr>
</table>');*/

	$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:82px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" width="70" class="signature" style="margin-left:655px;margin-top:1px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td  height="50" class="signature" valign="top" style="margin-left:550px;"><strong>'; $footer .=$dattime.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:%23CDCACA;"></small></td>
	</tr>
	</table>';
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLFooter($footer);

            //$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		  //  $this->m_pdf->pdf->SetHTMLFooter($footer);
			$this->m_pdf->pdf->WriteHTML($html);
			
			//download it.
			//}
		//	$i++;
		    $currtnt_time= date('y-m-d h:i:s');//$this->data['schoolname_new'];//date('y-m-d h:i:s');
		    $pdfFilePath1 =$stud_list[0]['enrollment_no']."_Gradesheet.pdf";
			$this->m_pdf->pdf->Output($tempDir.'/'.$pdfFilePath1, "F");
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		 
		 	
	}
	function searchsemister(){
		 foreach ($array as $key => $val) {
       if ($val['semester'] === $id) {
           return 1;
       }
   }
   return 0;
	}
	
	 function orderBy($data, $field)
  {
    $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
    usort($data, create_function('$a,$b', $code));
    return $data;
  }
	function Manual_certificate_All(){
		
		
	//	print_r($_REQUEST);
		//exit;
		
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);		//exit;
     //  $prn = $this->uri->segment(3);
	 // $stud_list= $this->Certificate_model->Manual_certificate($prn);
	        /*$this->data['regulation'] =$_POST['regulation'];
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission_course'];
	        $this->data['stream'] =$_POST['admission_branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];
			
	       // $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
			
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
			
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
			
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
			$this->data['exam_new'] =$exam_month.'-'.$exam_year;
			 
			 $this->data['schoolname_new']= $_POST['schoolname'];
			 $this->data['admissioncourse_new']= $_POST['admissioncourse'];
			 $this->data['admissionbranch_new']= $_POST['admissionbranch'];
			*/
		  //  $stud_list= $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id);
	 
	    $stud_prnn= $_REQUEST['chk_stud']; //chk_stud //stud_prnn
		//print_r($stud_prnn);
		//exit;
		$stud_idd= $_REQUEST['stud_idd'];
		$stream_id= $_REQUEST['stream_id'];
		$exam_id= $_REQUEST['exam_id'];
		$school= $_REQUEST['schoold'];
		$semester= $_REQUEST['semester'];
		$this->data['semester']=$semester;
	     $dattime=date('Y-m-d');
		 $this->load->library('m_pdf');
		
	 $current_date=$_REQUEST['current_date'];
	   //$this->data['stud_list']=$stud_list;
	   $i=0;
	    
		 //$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '20', '20', '20', '20', 'upper_margin', '20');

		     $mpdf=new mPDF();
		   $this->m_pdf->pdf = new mPDF('utf-8', 'A4', '5', '5', '5', '5', '55', '20');
			
	   foreach($stud_prnn as $list){
	 $newid=$list; //echo '<br/>';
	//print_r($this->data['stud_list']);
	 // echo $list['enrollment_no'];
	   //   exit;
	// $k=$this->load->view($this->view_dir.'manual_certificate.php',$this->data,true);
//echo $k;
//exit;
$exam_ses="2019_May";
///////////////////
			include_once "phpqrcode/qrlib.php";
			//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
			$tempDir = 'uploads/grade_sheet/'.$exam_ses.'/';
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0777, true);
			}
			//$po_id = $p_row[0]['ord_no'];
			$site_url="https://sandipuniversity.com/erp/";
			$codeContents = $site_url.'grade_sheet.php?po='.$newid;
			
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = 'qrcode_'.$newid.'.png';		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	



       
		 
		 //////////////////////////////////////////////////////////////////////////////////////////////
		 //	exit;
			//if(!empty($this->data['emp'])){
				 //   $stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css');
				//echo $list['enrollment_no'];echo '<br>';
			//	echo $stud_idd[$i].'-'.$stream_id.'-'.$school_code.'-'.$exam_id.'-'.$semester.'-'.$list;
          $stud_list= $this->Certificate_model->Manual_certificate($stud_idd[$i],$stream_id,$school[$i],$exam_id,$semester,$list);
		 //print_r($stud_list);
		 
		  $stud_list = $this->orderBy($stud_list, 'subject_order');
		  $this->data['stud_list']=$stud_list;
		  //echo '<pre>'; print_r($stud_list);
		  //$html='';
		  
		     $html =$this->load->view($this->view_dir.'manual_certificate.php',$this->data,true);
		   
		   $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

	        $footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:82px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" width="70" class="signature" style="margin-left:655px;margin-top:1px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td  height="50" class="signature" valign="top" style="margin-left:550px;"><strong>'; $footer .=$current_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:%23CDCACA;"></small></td>
	</tr>
	</table>';
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLFooter($footer);

			
		
			
 
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;
		    //$this->m_pdf->pdf->SetDefaultBodyCSS('line-height', 5.2);
			$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML($html);
			
			 
			ob_clean();
			
			$i++;
			
			} //LOop
			
			$currtnt_time= date('y-m-d h:i:s');
			//$this->data['schoolname_new'];//date('y-m-d h:i:s');
		    $pdfFilePath1 =$currtnt_time."_Gradesheet.pdf";
			
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		
		//echo $i;
		//exit;
		   
			//$this->m_pdf->pdf->Output($tempDir.'/'.$pdfFilePath1, "F");
			//}//forloop
		 
			
		 	
	}
	
/////////////////////////////////////////////////////////////////////////////////////		
}
?>