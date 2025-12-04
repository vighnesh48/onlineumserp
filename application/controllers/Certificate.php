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
		if(($this->session->userdata("role_id")==15)||($this->session->userdata("role_id")==14)
			||($this->session->userdata("role_id")==6) ||($this->session->userdata("role_id")==64)||($this->session->userdata("role_id")==66 ) || $this->session->userdata("role_id")==70){}else{
			redirect('home');
			}
		$this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
        $this->load->library('Awssdk');
	}
    
  	public function provisional(){
		//  echo "ex";exit;
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==64){
		}else{
			redirect('home');
		}
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
			"sem1_gpa"=>$this->input->post('sem1_gpa'),
			"sem2_gpa"=>$this->input->post('sem2_gpa'),
			"sem3_gpa"=>$this->input->post('sem3_gpa'),
			"sem4_gpa"=>$this->input->post('sem4_gpa'),
			"sem5_gpa"=>$this->input->post('sem5_gpa'),
			"sem6_gpa"=>$this->input->post('sem6_gpa'),
			"sem7_gpa"=>$this->input->post('sem7_gpa'),
			"sem8_gpa"=>$this->input->post('sem8_gpa'),
			"sem9_gpa"=>$this->input->post('sem9_gpa'),
			"sem10_gpa"=>$this->input->post('sem10_gpa'),
			"cgpa"=>$this->input->post('cgpa'),
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
			"sem1_gpa"=>$this->input->post('sem1_gpa'),
			"sem2_gpa"=>$this->input->post('sem2_gpa'),
			"sem3_gpa"=>$this->input->post('sem3_gpa'),
			"sem4_gpa"=>$this->input->post('sem4_gpa'),
			"sem5_gpa"=>$this->input->post('sem5_gpa'),
			"sem6_gpa"=>$this->input->post('sem6_gpa'),
			"sem7_gpa"=>$this->input->post('sem7_gpa'),
			"sem8_gpa"=>$this->input->post('sem8_gpa'),
			"sem9_gpa"=>$this->input->post('sem9_gpa'),
			"sem10_gpa"=>$this->input->post('sem10_gpa'), 
			"cgpa"=>$this->input->post('cgpa'),
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
			$site_url="https://erp.sandipuniversity.com/";
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
		if($this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==64 || $this->session->userdata("role_id")==70 || $this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
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
			$this->data['prn'] =$_POST['prn'];
	        $this->data['marks_type'] =$_POST['marks_type'];
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
	        $exam= explode('-', $_POST['exam_session']);
	        $exam_month =$exam[0];
	        $exam_year =$exam[1];
	        $exam_id =$exam[2];
			 $prn = $_POST['prn'];
			
	        $this->data['exam_month']= $exam_month;
			$this->data['exam_year']= $exam_year;
			$this->data['exam_id']= $exam_id;
			$this->data['exam_new'] =$exam_month.'-'.$exam_year;
			 
			 $this->data['schoolname_new']= $_POST['schoolname'];
			 $this->data['admissioncourse_new']= $_POST['admissioncourse'];
			 $this->data['admissionbranch_new']= $_POST['admissionbranch'];
			
		    //$this->data['stud_list']= $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id);	
			if($_POST['admission_branch'] !=71){
				//echo 'Inside';exit;
				$this->data['stud_list']= $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id,$prn='');
				
				// print_r($this->data['stud_list']);exit;
				 $this->load->view($this->view_dir.'Certificate_view',$this->data); //markscard_view
			}else{
				//echo 'outside';exit;
				$this->data['stud_list']= $this->Certificate_model->list_result_students_dpharma($_POST,$exam_month,$exam_year,$exam_id);
				 $this->load->view($this->view_dir.'Certificate_view_dpharma',$this->data); //markscard_view
			}				
		   

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
	   $this->load->helper('image');
	   if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==64 || $this->session->userdata("role_id")==66 || $this->session->userdata("role_id")==70){
		}else{
			redirect('home');
		}
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Marks_model');
		$this->load->model('Results_model');
		$this->data['regulatn']= $this->Exam_timetable_model->getRegulation();
	    if($_POST){
	          
	        $this->load->view('header',$this->data);
			$this->data['regulation'] =$_POST['regulation'];
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission_course'];
	        $this->data['stream'] =$_POST['admission_branch'];
			$this->data['prn'] =$_POST['prn'];
			$prn = $_POST['prn'];
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
			
		    $this->data['stud_list']= $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id, $prn='');
			// echo "<pre>";
	        // print_r($this->data['stud_list']);exit;	   				     
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
	
	public function test_img_compress()
	{
		$this->load->helper('image');
		$this->load->library('Awssdk');
		// local sample image (put a jpg in /public/test.jpg or similar)
		$bucket_key = 'uploads/student_photo/220106111001.jpg';
		$imgInput   = $this->awssdk->getImageData($bucket_key); // Could be URL or binary
		// print_r($imgInput);exit;
		// echo '<img src="'.$imgInput.'" alt="" width="50">';
		$path = $imgInput; // FCPATH.'s.jpg';
		// if (!file_exists($path)) { die('Place a test.jpg in webroot'); }

		$raw = file_get_contents($path);
		$orig = strlen($raw);

		$b64 = compress_image_to_base64($raw, 500); // 500KB target
		if (!$b64) { die('Compression failed; check application/logs for errors.'); }

		// Basic output page with before/after sizes
		echo "<h3>Compression Test</h3>";
		echo "<p>Original bytes: {$orig}</p>";
		$decoded = base64_decode(substr($b64, strpos($b64, ',')+1));
		echo "<p>Compressed bytes: ".strlen($decoded)."</p>";
		echo '<img src="'.$b64.'" style="max-width:300px;border:1px solid #999" />';
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
			// print_r($stream);exit;
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
			 if($exam_id >=13 && $exam_id <=27){
					$signature='Sign COE 01.png';
				}else{
					$signature='Sign COE 01_parimala.png';
				}
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
					<td align="right" height="50" class="signature"><img src="'.base_url().'assets/images/'.$signature.'" height="50" width="200"></td>
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
			 if($exam_id >=13 && $exam_id <=27){
					$signature='Sign COE 01.png';
				}else{
					$signature='Sign COE 01_parimala.png';
				}
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
					<td align="right" height="50" class="signature"><img src="'.base_url().'assets/images/'.$signature.'" height="50" width="200"></td>
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
		ini_set("memory_limit", "-1");  
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
		 ob_start();
		 if($report_type=="Degree"){
			//$stream_id[0];
		//	exit;
			//  exam_session
			//exit;
			$i;
			
			/*foreach($student as $stud){
			 	echo $prn=$stud; echo '<br>';
			}
			exit;'default_font' => 'serif'*/
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
				 $student_id =$this->Certificate_model->student_id($prn);
				 $stud_last_exsess= $this->Certificate_model->stud_last_exam_session($student_id);
		        $this->data['stud_last_ex_ses'] =$stud_last_exsess[0]['exam_month'].'-'.$stud_last_exsess[0]['exam_year']; 
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
			$site_url="https://erp.sandipuniversity.com/";
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
			if (file_exists($pngAbsoluteFilePath)) {
				$src_file = $pngAbsoluteFilePath;
				$bucket_name = 'erp-asset';
				$filepath = $pngAbsoluteFilePath;
				$result = $this->awssdk->uploadFile($bucket_name, $filepath, $src_file);
				unlink($filepath);
			}
			//////////////////
		
			//	exit;
			//if(!empty($this->data['emp'])){
				if($stream_id[$key] !=71){
					$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents_new($_REQUEST,$prn,$stream_id[$key],$exam_id[0]);
					// print_r($this->data['emp']);exit;
					//$this->data['grade_marathi']= $this->Certificate_model->get_marathi();
					//$html = $this->load->view($this->view_dir.'degree_certificate_pdf',$this->data, true);
					
					if($exam_id[0]>=20){
						if($prn == '180105041032'){
							$html = $this->load->view($this->view_dir.'degree_certificate_pdf',$this->data, true);	
						}else{
							$html = $this->load->view($this->view_dir.'degree_certificate_pdf_marathi',$this->data, true);
						}
					}else{
						
					 $html = $this->load->view($this->view_dir.'degree_certificate_pdf',$this->data, true);
					}
				}else{
					$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents_dpharma($_REQUEST,$prn,$stream_id[$key],$exam_id[0]);
					$html = $this->load->view($this->view_dir.'degree_certificate_pdf_dpharma',$this->data, true);
				}

			//echo $html;
			//exit();
			//	$pdfFilePath1 =$prn."_degree_certificate.pdf";
			//$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			//$html = mb_convert_encoding($html, 'UTF-8', 'windows-1252');
			// $html = mb_convert_encoding($html,'UTF-8','UTF-8');

			// $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			//$mpdf->adjustFontDescLineheight = 1.14;
			//$html=htmlspecialchars($html, ENT_NOQUOTES, "UTF-8");
			//htmlspecialchars_decode($html);
			//   $this->m_pdf->pdf->SetFont('freesans','',24);
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;
			//['default_font' => 'Devnew']
			//	$this->m_pdf->pdf->SetFont('Devnew');
            $this->m_pdf->pdf->SetAutoFont();


			// $this->m_pdf->pdf->SetDirectionality('rtl');
			$this->m_pdf->pdf->autoScriptToLang = true;
            $this->m_pdf->pdf->autoLangToFont = true;
			//$this->m_pdf->pdf->allow_charset_conversion = true;
			//$mpdf->allow_charset_conversion=true;
            //$this->m_pdf->pdf->charset_in='UTF-8';
		    //$this->m_pdf->pdf->SetDefaultBodyCSS('line-height', 5.2);
			$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML(($html));
			//$this->m_pdf->pdf->WriteHTML(htmlspecialchars($html, ENT_NOQUOTES, "UTF-8"));
			//download it.
			//}
			$i++;
			ob_clean();
			}//$val
			} //foreach
			//	}
			}
			$pdfFilePath1 =$prn."_degree_certificate.pdf";
			//$this->m_pdf->pdf->Output($tempDir.'/'.$pdfFilePath1, "F");
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
	
	
	
	public function download_degree_certificate_new_marathi()
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
		 ob_start();
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
				 $student_id =$this->Certificate_model->student_id($prn);
				 $stud_last_exsess= $this->Certificate_model->stud_last_exam_session($student_id);
		        $this->data['stud_last_ex_ses'] =$stud_last_exsess[0]['exam_month'].'-'.$stud_last_exsess[0]['exam_year']; 
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
			$site_url="https://erp.sandipuniversity.com/";
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
			
		//	exit;
			//if(!empty($this->data['emp'])){
				if($stream_id[$key] !=71){
					$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents_new($_REQUEST,$prn,$stream_id[$key],$exam_id[0]);
					$html = $this->load->view($this->view_dir.'degree_certificate_pdf_marathi',$this->data, true);
				}else{
					$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents_dpharma($_REQUEST,$prn,$stream_id[$key],$exam_id[0]);
					$html = $this->load->view($this->view_dir.'degree_certificate_pdf_dpharma',$this->data, true);
				}
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
			ob_clean();
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
	  $object->getActiveSheet()->setCellValue('D16', 'Gender');
	  $object->getActiveSheet()->getStyle('D16')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  
	  $object->getActiveSheet()->getColumnDimensionByColumn('E')->setAutoSize(false);
      $object->getActiveSheet()->getColumnDimensionByColumn('E')->setWidth('10');
	  $object->getActiveSheet()->setCellValue('E16', 'DOB');
	  $object->getActiveSheet()->getStyle('E16')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  
	  $object->getActiveSheet()->getColumnDimensionByColumn('F')->setAutoSize(false);
      $object->getActiveSheet()->getColumnDimensionByColumn('F')->setWidth('10');
	  $object->getActiveSheet()->setCellValue('F16', 'Classification');
	  $object->getActiveSheet()->getStyle('F16')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  
	  $object->getActiveSheet()->getColumnDimensionByColumn('G')->setAutoSize(false);
      $object->getActiveSheet()->getColumnDimensionByColumn('G')->setWidth('10');
	  $object->getActiveSheet()->setCellValue('G16', 'CGPA');
	  $object->getActiveSheet()->getStyle('G16')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  
	  
	  $object->getActiveSheet()->getColumnDimensionByColumn('H')->setAutoSize(false);
      $object->getActiveSheet()->getColumnDimensionByColumn('H')->setWidth('10');
	  $object->getActiveSheet()->setCellValue('H16', 'Attempt');
	  $object->getActiveSheet()->getStyle('H16')->applyFromArray($styleArray)->applyFromArray($styleArray1);
	  

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

			$res_uniq_sem = $this->Results_model->fetch_student_unique_result_semester($val['stud_id'],$exam_id);
									$res_uniq_subjects = $this->Results_model->fetch_student_subject_completion($val['stud_id']);
									if($val['admission_year']==1){
										$s=1;
									}else{
										$s=3;
									}

									for ($x = $s; $x <= $val['current_semester']; $x++) {
										$studallsem[]=$x;
									}
									foreach($res_uniq_sem as $rsem){
									 $res_uniq_sems[] = $rsem['semester'];  
									}	
									$uniq_sems=array_diff($studallsem,$res_uniq_sems);
									/*if($stud_list[$i]['enrollment_no']=='170101062100'){
										echo 'gfg';print_r($studallsem);echo '<br>';print_r($res_uniq_sems);echo '<br>';print_r($uniq_sems);exit;
									}*/
								if(empty($uniq_sems) && empty($res_uniq_subjects)){	
									
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
									if($val['gender']=='M'){
										$gender='Male';
									}elseif($val['gender']=='F'){
										$gender='Female';
									}else{
										$gender='';
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
$object->getActiveSheet()->setCellValue('D'.$j, $gender);
$object->getActiveSheet()->setCellValue('E'.$j, $val['dob']);
//$object->getActiveSheet()->setCellValue('E'.$j, $val['gender']);
$object->getActiveSheet()->setCellValue('F'.$j,$Resultn);
$object->getActiveSheet()->setCellValue('G'.$j, $val['cumulative_gpa']);
$object->getActiveSheet()->setCellValue('H'.$j, $attm);
		
       // $i++;
      $i++;
$j++;
 }
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
$exam_ses="2019_May_new";
///////////////////
			include_once "phpqrcode/qrlib.php";
			//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
			$tempDir = 'uploads/gradesheet/'.$exam_ses.'/';
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0777, true);
			}
			//$po_id = $p_row[0]['ord_no'];
			$site_url="https://erp.sandipuniversity.com/";
			$codeContents = $site_url.'grade_sheet.php?po='.$student_id;
			
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = 'qrcode_'.$student_id.'.png';		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	



         $dattime=date('Y-m-d');
		 $this->load->library('m_pdf');
		 $mpdf=new mPDF();
		 //$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '20', '20', '20', '20', 'upper_margin', '20');

	    $this->m_pdf->pdf = new mPDF('utf-8', 'A4', '15', '30', '13', '11', '50', '5');
		//$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '30', '10', '10', '10', '5');
		 //////////////////////////////////////////////////////////////////////////////////////////////
		 //	exit;
			//if(!empty($this->data['emp'])){
				 //   $stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css');

			  $html = $this->load->view($this->view_dir.'manual_certificate.php',$this->data,true);
			// exit();
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
if($exam_id >=13 && $exam_id <=27){
					$signature='Sign COE 01.png';
				}else{
					$signature='Sign COE 01_parimala.png';
				}
$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:68px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"><img src="'.base_url().'assets/images/'.$signature.'" height="50" width="200"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" class="signature" style="margin-left:155px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top" style="margin-top:3px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
					
					$footer .=$dattime.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;">'.$dattime.'</small></td>
	</tr>
	</table>';
	/*$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:-5px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" width="70" class="signature" style="margin-left:655px;margin-top:13px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td  height="50" class="signature" valign="top" style="margin-left:550px;"><strong>'; $footer .=$dattime.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:%23CDCACA;"></small></td>
	</tr>
	</table>';*/
				$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
				$this->m_pdf->pdf->SetHTMLFooter($footer);

            //$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		  //  $this->m_pdf->pdf->SetHTMLFooter($footer);
			$this->m_pdf->pdf->WriteHTML($html);
			
			//download it.
			//}
		//	$i++;
		$cu_time= date('h:i:s');
		    $currtnt_time= date('y-m-d h:i:s');//$this->data['schoolname_new'];//date('y-m-d h:i:s');
		    $pdfFilePath1 =$cu_time.$stud_list[0]['enrollment_no']."_Gradesheet.pdf";
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
		
		// Give PHP unlimited time for this request
		ini_set('max_execution_time', '0');   // 0 = unlimited
		set_time_limit(0);

		// Bump memory if needed
		ini_set('memory_limit', '1024M');     // or '2048M'

		// (optional) help long responses stream out
		while (ob_get_level()) ob_end_flush();
		ob_implicit_flush(true);
		header('X-Accel-Buffering: no');      // Nginx buffering off (harmless elsewhere)

			//print_r($_REQUEST);
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
		// print_r($stud_prnn);
		// exit;
		$stud_idd= $_REQUEST['stud_idd'];
		$stream_id= $_REQUEST['stream_id'];
		$exam_id= $_REQUEST['exam_id'];
		$school= $_REQUEST['schoold'];
		$semester= $_REQUEST['semester'];

            $exam= explode('~', $_POST['exam_session']);
	       // $examM =explode('/', $exam[0]);
            
            $exam_month=$exam[0];
	       // $exam_montht =$examM[1];

	        $exam_year =$exam[1];
			$exam_id =$exam[2];


		 $this->data['semester']=$semester;
	     $dattime=date('Y-m-d');
		 $this->load->library('m_pdf');
		
		 $current_date=$_REQUEST['current_date'];
		 $this->data['remark']=$_REQUEST['remark'];
		   //$this->data['stud_list']=$stud_list;
		   $i=0;
	    
		 //$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '20', '20', '20', '20', 'upper_margin', '20');

		     $mpdf=new mPDF();
		  // $this->m_pdf->pdf = new mPDF('utf-8', 'A4', '6', '6', '6', '6', '50', '15');
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '15', '30', '13', '11', '40', '15');
	   foreach($stud_prnn as $list){
	    	$enrollment_no=$this->Certificate_model->enrollment_no($list);
			// exit;
			 $newid=$list; //echo '<br/>';
				// print_r($this->data['stud_list']);
				// echo $list['enrollment_no'];
				 // exit;
			// $k=$this->load->view($this->view_dir.'manual_certificate.php',$this->data,true);
			//echo $k;
			//exit;
				 $exam_ses="2019_May_new";
			//$exam_ses= $exam_month.'_'.$exam_year.'_'.$exam_id;
			///////////////////
			include_once "phpqrcode/qrlib.php";
			//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
			$tempDir = 'uploads/gradesheet/'.$exam_ses.'/';
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0777, true);
			}
			//$po_id = $p_row[0]['ord_no'];
			$site_url="https://erp.sandipuniversity.com/";
			$codeContents = $site_url.'grade_sheet.php?po='.$list;
			
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = 'qrcode_'.$list.'.png';		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	

			//QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	

       
		 
		 //////////////////////////////////////////////////////////////////////////////////////////////
		 //	exit;
			//if(!empty($this->data['emp'])){
				 //   $stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css');
				// echo $list['enrollment_no'];echo '<br>';
				// echo $stud_idd[$i].'-'.$stream_id.'-'.$school_code.'-'.$exam_id.'-'.$semester.'-'.$list;
				// echo '<pre>';
          $stud_list= $this->Certificate_model->Manual_certificate($enrollment_no,$stream_id,$school[$i],$exam_id,$semester,$list);
		  $stud_last_exsess= $this->Certificate_model->stud_last_exam_session($list);
		  $this->data['stud_last_ex_ses'] =$stud_last_exsess[0]['exam_month'].'-'.$stud_last_exsess[0]['exam_year']; 
		 //  print_r($stud_list);exit;
		 
		  $stud_list = $this->orderBy($stud_list, 'subject_order');
		  $this->data['stud_list']=$stud_list;

		  $this->data['exam_month']=$exam_month;
          $this->data['exam_year']=$exam_year;
          $this->data['exam_id']=$exam_id;
		  if($exam_id >=13 && $exam_id <=27){
					$signature='Sign COE 01.png';
				}else{
					$signature='Sign COE 01_parimala.png';
				}
		  //echo '<pre>'; print_r($stud_list);
		  //$html='';
		  
		     $html =$this->load->view($this->view_dir.'manual_certificate.php',$this->data,true);
		  // exit();
		   $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

	        /*$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:-5px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" width="70" class="signature" style="margin-left:655px;margin-top:13px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td  height="50" class="signature" valign="top" style="margin-left:550px;"><strong>'; $footer .=$current_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
			<tr>
			<td align="center" colspan="3" class="signature"><small style="color:%23CDCACA;"></small></td>
			</tr>
			</table>';*/
			$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:35px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:125px;"></td>
					<td align="center" height="50" class="signature">'.$current_date.'</td>
					<td align="right" height="50" class="signature" style="margin-top:30px;position:absolute;z-index: 999;"><img src="'.base_url().'assets/images/'.$signature.'" height="50" width="200"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" class="signature" style="margin-left:155px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>'; 
					
					$footer .='';
				/*$current_date.<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
				<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;">'.$current_date.'</small></td>
				</tr>
				</table>*/
				
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
		   
		  $this->m_pdf->pdf->Output($tempDir.'/'.$enrollment_no."_Gradesheet.pdf", "F");
			//}//forloop
		
	}


function view_consolated(){
		
		   $stud_prnn='180107021005';//$prn;
		   $list=$this->Certificate_model->student_id($stud_prnn);
		   $enrollment_no=$this->Certificate_model->enrollment_no($list);
		   
	    $stud_last_exsess= $this->Certificate_model->stud_last_exam_session($list);
		$stud_last_exsess[0]['exam_month'].'-'.$stud_last_exsess[0]['exam_year'];
	    $stud_prnn= $stud_prnn; //chk_stud //stud_prnn
		//print_r($stud_last_exsess);
		//exit;
		$stud_idd= $stud_last_exsess[0]['student_id'];
		$list=$stud_last_exsess[0]['student_id'];
		$stream_id= $stud_last_exsess[0]['stream_id'];
		$exam_id= $stud_last_exsess[0]['exam_id'];
		$school= $stud_last_exsess[0]['school_id'];
		$semester= $stud_last_exsess[0]['semester'];
	//	print_r($student_id);
		$exam_month=$stud_last_exsess[0]['exam_month'];
	    $exam_year=$stud_last_exsess[0]['exam_year'];
	   
	   
	    $stud_prnn= $list; //chk_stud //stud_prnn
		//print_r($stud_prnn);
		//exit;
		$stud_idd= $list;
		//$stream_id= $stream_id;
		//$exam_id= $exam_id;
		//$school= $school;
		//$semester= $semester;	
		$this->data['semester']=$semester;
	    $dattime=date('Y-m-d');
		
		$current_date=$dattime;

		  // echo "inside";
	    	//$enrollment_no=$this->Certificate_model->enrollment_no($student_id);
			
          $stud_list= $this->Certificate_model->Manual_certificate($enrollment_no,$stream_id,$school,$exam_id,$semester,$stud_idd);
		// print_r($stud_list);
		 
		  $stud_list = $this->orderBy($stud_list, 'subject_order');
		  $this->data['stud_list']=$stud_list;

		  $this->data['exam_month']=$exam_month;
          $this->data['exam_year']=$exam_year;
          $this->data['exam_id']=$exam_id;
		  if($exam_id >=13 && $exam_id <=27){
					$signature='Sign COE 01.png';
				}else{
					$signature='Sign COE 01_parimala.png';
				}
		  //echo '<pre>'; print_r($stud_list);
		  //$html='';
		  //$this->load->view('header',$this->data);
			$this->load->view($this->view_dir.'view_consolidated_gradesheet_certificate_html_view.php',$this->data);
		   
			$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:68px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"><img src="'.base_url().'assets/images/'.$signature.'" height="50" width="200"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" class="signature" style="margin-left:155px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top" style="margin-top:2px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
					
					$footer .=$current_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
				<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;">'.$current_date.'</small></td>
				</tr>
				</table>';

					 	
	}



function Manual_Prn(){
		
		
		//print_r($_REQUEST);
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
		   $stud_prnn='180107021005';//$prn;
		   $list=$this->Certificate_model->student_id($stud_prnn);
		   $enrollment_no=$this->Certificate_model->enrollment_no($list);
		   
	    $stud_last_exsess= $this->Certificate_model->stud_last_exam_session($list);
	    $stud_prnn= $stud_prnn; //chk_stud //stud_prnn
		//print_r($stud_last_exsess);
		//exit;
		$stud_idd= $stud_last_exsess[0]['student_id'];
		$list=$stud_last_exsess[0]['student_id'];
		$stream_id= $stud_last_exsess[0]['stream_id'];
		$exam_id= $stud_last_exsess[0]['exam_id'];
		$school= $stud_last_exsess[0]['school_id'];
		$semester= $stud_last_exsess[0]['semester'];
	//	$stud_last_exsess[0]['exam_month'].'-'.$stud_last_exsess[0]['exam_year']
$this->view_consolated_gradesheet($list,$school,$stream_id,$semester,$exam_id,$stud_last_exsess[0]['exam_month'],$stud_last_exsess[0]['exam_year']);
exit();
            //$exam= explode('~', $_POST['exam_session']);
	       // $examM =explode('/', $exam[0]);
            
           // $exam_month=$exam[0];
	       // $exam_montht =$examM[1];

	        //$exam_year =$exam[1];
			//$exam_id =$exam[2];


		$this->data['semester']=$semester;
	     $dattime=date('Y-m-d');
		 $this->load->library('m_pdf');
		
	 $current_date=$_REQUEST['current_date'];
	   //$this->data['stud_list']=$stud_list;
	   $i=0;
	    
		 //$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '20', '20', '20', '20', 'upper_margin', '20');

		     $mpdf=new mPDF();
		  // $this->m_pdf->pdf = new mPDF('utf-8', 'A4', '6', '6', '6', '6', '50', '15');
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '15', '30', '13', '11', '37', '5');
	  // foreach($stud_prnn as $list)
	   {
	    	$enrollment_no=$this->Certificate_model->enrollment_no($list);
	  // exit;
	 $newid=$list; //echo '<br/>';
	//print_r($this->data['stud_list']);
	 // echo $list['enrollment_no'];
	   //   exit;
	// $k=$this->load->view($this->view_dir.'manual_certificate.php',$this->data,true);
//echo $k;
//exit;
	 $exam_ses="2019_May_new";
//$exam_ses= $exam_month.'_'.$exam_year.'_'.$exam_id;
///////////////////
			include_once "phpqrcode/qrlib.php";
			//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
			$tempDir = 'uploads/gradesheet/'.$exam_ses.'/';
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0777, true);
			}
			//$po_id = $p_row[0]['ord_no'];
			$site_url="https://erp.sandipuniversity.com/";
			$codeContents = $site_url.'grade_sheet.php?po='.$list;
			
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = 'qrcode_'.$list.'.png';		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	

//QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	

       
		 
		 //////////////////////////////////////////////////////////////////////////////////////////////
		 //	exit;
			//if(!empty($this->data['emp'])){
				 //   $stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css');
				//echo $list['enrollment_no'];echo '<br>';
				// $enrollment_no.'-'.$stream_id.'-'.$school.'-'.$exam_id.'-'.$semester.'-'.$list;
          $stud_list= $this->Certificate_model->Manual_certificate($enrollment_no,$stream_id,$school,$exam_id,$semester,$list);
		//  $stud_last_exsess= $this->Certificate_model->stud_last_exam_session($list);
		  $this->data['stud_last_ex_ses'] =$stud_last_exsess[0]['exam_month'].'-'.$stud_last_exsess[0]['exam_year']; 
		// print_r($stud_list);
		// exit();
		  $stud_list = $this->orderBy($stud_list, 'subject_order');
		  $this->data['stud_list']=$stud_list;

		  $this->data['exam_month']=$stud_last_exsess[0]['exam_month'];//$exam_month;
          $this->data['exam_year']=$stud_last_exsess[0]['exam_year'];//$exam_year;
          $this->data['exam_id']=$exam_id;
		  if($exam_id >=13 && $exam_id <=27){
					$signature='Sign COE 01.png';
				}else{
					$signature='Sign COE 01_parimala.png';
				}
		  //echo '<pre>'; print_r($stud_list);
		  //$html='';
		    // $html =  $this->load->view($this->view_dir.'view_consolidated_gradesheet_certificate_html.php',$this->data);
		     //$html =$this->load->view($this->view_dir.'manual_certificate.php',$this->data,true);
		   exit();
		   $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

	        /*$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:-5px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" width="70" class="signature" style="margin-left:655px;margin-top:13px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td  height="50" class="signature" valign="top" style="margin-left:550px;"><strong>'; $footer .=$current_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:%23CDCACA;"></small></td>
	</tr>
	</table>';*/
	$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:70px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:125px;"></td>
					<td align="center" height="50" class="signature">'.$current_date.'</td>
					<td align="right" height="50" class="signature" style="margin-top:30px;position:absolute;z-index: 999;"><img src="'.base_url().'assets/images/'.$signature.'" height="50" width="200"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" class="signature" style="margin-left:155px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>'; 
					
					$footer .='';
				/*$current_date.<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;">'.$current_date.'</small></td>
	</tr>
	</table>*/
				
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
		   
		  $this->m_pdf->pdf->Output($tempDir.'/'.$enrollment_no."_Gradesheet.pdf", "F");
			//}//forloop
		 
			
		 	
	}



	function check_qrcode(){
		$exam_ses="Test";
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
			$site_url="https://erp.sandipuniversity.com/";
			$codeContents = $site_url.'grade_sheet.php?po='.$list;
			
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = 'qrcode_TEST.png';		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	

//QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	

       
		 
		 //////////////////////////////////////////////////////////////////////////////////////////////
	}
	

public function gradesheet_dispatch(){
	
	       // error_reporting(E_ALL);exit();
		   if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==64
		   || $this->session->userdata("role_id")==66){
		}else{
			redirect('home');
		}
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Marks_model');
		$this->load->model('Results_model');
		$this->data['regulatn']= $this->Exam_timetable_model->getRegulation();
		$this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
		    
			$semester_segment=$this->uri->segment(3);//echo '<br>';//examsession//examsession
		 	$stream_segment=$this->uri->segment(4);//echo '<br>';//school//school
		 	$school_segment=$this->uri->segment(5);//echo '<br>';//course//course
		 	$regulation_segment=$this->uri->segment(6);//echo '<br>';//stream//stream
			$exam_id_segment=$this->uri->segment(7);//echo '<br>';//semester//semester
			//echo	$exam_month_segment=$this->uri->segment(8);echo '<br>';//semester//semester
			//echo	$exam_year_segment=$this->uri->segment(9);echo '<br>';//semester//semester
			//echo	$exam_id_segment=$this->uri->segment(10);echo '<br>';//semester//semester
			   $this->data['regulation']=$regulation_segment;
			   $var['school_segment']=$school_segment;
			//  $var['admission_branch']=$stream_segment;
			//  $var['semester']=$semester_segment;
			$this->data['e_session']=$this->session->flashdata('e_session');
			
			// echo $this->uri->segment(3);
			// exit();
			//  echo "<pre>";
	        //   print_r($_POST);exit;
	    if(($_POST)&&($semester_segment=='')){
	        //   echo "<pre>";
	        //   print_r($_REQUEST);exit;
	        $this->load->view('header',$this->data);
			

			
			$this->data['regulation'] =$_POST['regulation'];

	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission_course'];
	        $this->data['stream'] =$_POST['admission_branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];
	        
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
			//list_result_students
			
				/* $var['regulation']=$regulation_segment;
				$var['school_code']=$school_segment;
				$var['admission_branch']=$stream_segment;
				$var['semester']=$semester_segment;*/
			
		    $this->data['stud_list']= $this->Certificate_model->list_result_students_for_markcards($_POST,$exam_month,$exam_year,$exam_id);	   				
			// print_r($this->data['stud_list']);exit();
		    $this->load->view($this->view_dir.'manual_gradesheet_assign',$this->data); //markscard_view

	        $this->load->view('footer');
	    }elseif(($semester_segment!='')&&($exam_id_segment!='')){
		// echo	$regulation=$this->uri->segment(2); echo '<br>';//regulation//regulation
		 	
		 
            
		// exit();
		 //echo   $month_segment=$this->uri->segment(8);echo '<br>';//semester//semester
		 //echo   $year_segment=$this->uri->segment(9);echo '<br>';//semester//semester
		        $this->load->view('header',$this->data);
		      /*  $var['regulation']=$regulation_segment;
				$var['school_code']=$school_segment;
				$var['admission_branch']=$stream_segment;
				$var['semester']=$semester_segment;*/
			$this->data['stud_list']= $this->Certificate_model->list_result_students_for_markcards($var,'','',$exam_id_segment);	
			// print_r($this->data['stud_list']);exit();
			 $this->load->view($this->view_dir.'manual_gradesheet_assign',$this->data); //markscard_view

	        $this->load->view('footer');
		}else
	    {
	        
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] ='';
	        $this->data['admissioncourse'] = '';
	        $this->data['stream'] = '';
	        $this->data['semester'] = '';
	       
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
	        $this->load->view($this->view_dir.'manual_gradesheet_assign',$this->data); //markscard_view
	        $this->load->view('footer');
	        
	    }

}

public function degreeCertificate_dispatch(){
	if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==65 || $this->session->userdata("role_id")==66 || $this->session->userdata("role_id")==70){
		}else{
			redirect('home');
		}
	       // error_reporting(E_ALL);exit();
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Marks_model');
		$this->load->model('Results_model');
		$this->data['regulatn']= $this->Exam_timetable_model->getRegulation();
		$this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
		    
			$semester_segment=$this->uri->segment(3);//echo '<br>';//examsession//examsession
		 	$stream_segment=$this->uri->segment(4);//echo '<br>';//school//school
		 	$school_segment=$this->uri->segment(5);//echo '<br>';//course//course
		 	$regulation_segment=$this->uri->segment(6);//echo '<br>';//stream//stream
			$exam_id_segment=$this->uri->segment(7);//echo '<br>';//semester//semester
			//echo	$exam_month_segment=$this->uri->segment(8);echo '<br>';//semester//semester
			//echo	$exam_year_segment=$this->uri->segment(9);echo '<br>';//semester//semester
			//echo	$exam_id_segment=$this->uri->segment(10);echo '<br>';//semester//semester
			   $this->data['regulation']=$regulation_segment;
			   $var['school_segment']=$school_segment;
			//  $var['admission_branch']=$stream_segment;
			//  $var['semester']=$semester_segment;
			$this->data['e_session']=$this->session->flashdata('e_session');
			
			//$this->uri->segment(2)
			//exit();
	    if(($_REQUEST)&&($semester_segment=='')){
	          //echo "<pre>";
	         // print_r($_POST);exit;
	        $this->load->view('header',$this->data);
			

			
			$this->data['regulation'] =$_REQUEST['regulation'];

	        $this->data['school_code'] =$_REQUEST['school_code'];
	        $this->data['admissioncourse'] =$_REQUEST['admission_course'];
	        $this->data['stream'] =$_REQUEST['admission_branch'];
	        $this->data['semester'] =$_REQUEST['semester'];
	        $this->data['exam'] =$_REQUEST['exam_session'];
	        $this->data['marks_type'] =$_REQUEST['marks_type'];
	        
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
			 
			 $this->data['schoolname_new']= $_REQUEST['schoolname'];
			 $this->data['admissioncourse_new']= $_REQUEST['admissioncourse'];
			 $this->data['admissionbranch_new']= $_REQUEST['admissionbranch'];
			//list_result_students
			
				/* $var['regulation']=$regulation_segment;
				$var['school_code']=$school_segment;
				$var['admission_branch']=$stream_segment;
				$var['semester']=$semester_segment;*/
			
		    $this->data['stud_list']= $this->Certificate_model->list_result_students_for_degree_certificate($_POST,$exam_month,$exam_year,$exam_id);	   				
			
		    $this->load->view($this->view_dir.'manual_degree_cert_assign',$this->data); //markscard_view

	        $this->load->view('footer');
	    }elseif(($semester_segment!='')&&($exam_id_segment!='')){
		// echo	$regulation=$this->uri->segment(2); echo '<br>';//regulation//regulation
		 	
		 
            
		// exit();
		 //echo   $month_segment=$this->uri->segment(8);echo '<br>';//semester//semester
		 //echo   $year_segment=$this->uri->segment(9);echo '<br>';//semester//semester
		        $this->load->view('header',$this->data);
		      /*  $var['regulation']=$regulation_segment;
				$var['school_code']=$school_segment;
				$var['admission_branch']=$stream_segment;
				$var['semester']=$semester_segment;*/
			$this->data['stud_list']= $this->Certificate_model->list_result_students_for_degree_certificate($var,'','',$exam_id_segment);	
			// print_r($this->data['stud_list']);exit();
			 $this->load->view($this->view_dir.'manual_degree_cert_assign',$this->data); //markscard_view

	        $this->load->view('footer');
		}else
	    {
	        
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] ='';
	        $this->data['admissioncourse'] = '';
	        $this->data['stream'] = '';
	        $this->data['semester'] = '';
	       
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
	        $this->load->view($this->view_dir.'manual_degree_cert_assign',$this->data); //markscard_view
	        $this->load->view('footer');
	        
	    }

}


public function gradesheet_dispatch_insert(){

        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		
    //  print_r($_POST);exit;
		$checked_stud = $_POST['chk_stud'];
		$school  = $_POST['school'];
		$stream = $_POST['stream_id'];
		$semester = $_POST['semester'];
		$examsession = $_POST['exam_session'];
		$regulation =$_POST['regulation'];
		$course = $_POST['course'];
		$exam = explode('~',$examsession);
		//print_r($exam);exit;
		$exam_month =$exam[0];
	    $exam_year =$exam[1];
	    $exam_id =$exam[2];
		$markscardno = $_POST['markscardno'];
		$stud_prn = $_POST['stud_prn'];
		//exit;
		$i=0;
		foreach($checked_stud as $key=>$stud){
			
			 $stud_cnt = $this->Certificate_model->CheckStudIn($stud,$exam_id, $stream, $semester,$school);
			//echo ($stud_cnt);

     //  exit;
			if(count($stud_cnt) > 0){				
				$this->Certificate_model->updategradsheetsNo($stud,$exam_id, $stream, $semester,$school);
			}

			$insert_markscard_array=array(
					"student_id"=>$stud,
					"stream_id"=>$stream,
					"semester"=>$semester,
					"exam_month"=>$exam[0],
					"exam_year"=>$exam[1],
					"exam_id"=>$exam_id,
					"enrollment_no" => $stud_prn[$key], //$stud_prn[$key]
					"markscard_no" => $markscardno[$key], 
					"school_id" => $school,	
					"is_active" => 'Y',
					"entry_by" => $this->session->userdata("uid"),
					"entry_on" => date("Y-m-d H:i:s"),
					"entry_ip" => $this->input->ip_address()
					);
			$DB1->insert("gradesheet_assgin_details", $insert_markscard_array); 
			$last_inserted_id_master =$DB1->insert_id();
			
			unset($stud_prn[$key]);
			$i++;
		}

		unset($markscardno);
		unset($stud_prn);
		 //array()
		// regulation_id
		$regulation_id= $_POST['regulation_id'];
		$exam= explode('-', $_POST['exam_session']);
	    $exam_month =$exam[0];
	    $exam_year =$exam[1];
		echo 1;
		//$this->session->set_flashdata('mskrd', 'Gradesheet no assigned successfully.');
		//$this->session->set_flashdata('e_session',$examsession);
	//	redirect(base_url('Certificate/gradesheet_dispatch/'.$semester.'/'.$stream.'/'.$school.'/'.$regulation_id.'/'.$exam_id.'/'.$exam_month.'/'.$exam_year));
}
public function degreeCert_dispatch_insert(){

        $this->load->helper('security');
		$DB1 = $this->load->database('umsdb', TRUE);
		
    
		$checked_stud = $_POST['chk_stud'];
		//  print_r($checked_stud); 
///exit;
		$school  = $_POST['school'];
		$stream = $_POST['stream_id'];
		$semester = $_POST['semester'];
		$examsession = $_POST['exam_session'];
		$regulation =$_POST['regulation'];
		$course = $_POST['course'];
		$exam = explode('~',$examsession);
		//print_r($exam);exit;
		$exam_month =$exam[0];
	    $exam_year =$exam[1];
	    $exam_id =$exam[2];
		$markscardno = $_POST['markscardno'];
		$cumulative_gpa = $_POST['cumulative_gpa'];
		$placed_in = $_POST['placed_in'];
		$issued_date = $_POST['issued_date'];
		$stud_prn = $_POST['stud_prn'];
		//exit;
		$i=0;
		foreach($checked_stud as $key=>$stud){
			
			 $stud_cnt = $this->Certificate_model->CheckDegreeStudIn($stud,$exam_id, $stream, $semester,$school);
			//echo ($stud_cnt);

     //  exit;
			if(count($stud_cnt) > 0){				
				$this->Certificate_model->updateDegreeCertNo($stud,$exam_id, $stream, $semester,$school);
			}

			$insert_markscard_array=array(
					"student_id"=>$stud,
					"stream_id"=>$stream,
					"semester"=>$semester,
					"exam_month"=>$exam[0],
					"exam_year"=>$exam[1],
					"exam_id"=>$exam_id,
					"enrollment_no" => $stud_prn[$key],
					"markscard_no" => $markscardno[$key], 
					"cumulative_gpa" => $cumulative_gpa[$key],
					"issued_date" => $issued_date[$key],
					"placed_in" => $placed_in[$key],
					"school_id" => $school,	
					"is_active" => 'Y',
					"entry_by" => $this->session->userdata("uid"),
					"entry_on" => date("Y-m-d H:i:s"),
					"entry_ip" => $this->input->ip_address()
					);
				//	print_r($insert_markscard_array);
				//	exit;
			$DB1->insert("degreecertficate_assgin_details", $insert_markscard_array); 
			$last_inserted_id_master =$DB1->insert_id();
			
			unset($stud_prn[$i]);
			$i++;
		}

		unset($markscardno);
		unset($stud_prn);
		unset($placed_in);
		unset($cumulative_gpa);
		unset($issued_date);
		 //array()
		// regulation_id
		$regulation_id= $_POST['regulation_id'];
		$exam= explode('-', $_POST['exam_session']);
	    $exam_month =$exam[0];
	    $exam_year =$exam[1];
		echo 1;
		//$this->session->set_flashdata('mskrd', 'Gradesheet no assigned successfully.');
		//$this->session->set_flashdata('e_session',$examsession);
	//	redirect(base_url('Certificate/gradesheet_dispatch/'.$semester.'/'.$stream.'/'.$school.'/'.$regulation_id.'/'.$exam_id.'/'.$exam_month.'/'.$exam_year));
}
function download_mrksno_dispatch_report($mrknodetails)
	{
		$mrknodet =explode('~',$mrknodetails);
		//print_r($mrknodet);exit;
		$stream_id  =$mrknodet[0];
		$semester  =$mrknodet[1];
		$exam_id  =$mrknodet[2];
		$exam_year  =$mrknodet[3];
		$exam_month  =$mrknodet[4];
		
		//$exam_id  =$mrknodet[4];
		$this->data['exam_month'] = $exam_month;
		$this->data['exam_year'] = $exam_year;
		$this->data['semester'] = $semester;
		$this->load->model('Marks_model');
		$this->data['stud_list']= $this->Certificate_model->list_result_students_for_dispatch($stream_id, $semester,$exam_id);


		$strmname = $this->Marks_model->getStreamShortName($stream_id);
		$this->data['strmname'] = $strmname;
		$this->load->library('m_pdf');
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '10', '10', '15', '10', '10', '35');
		$html = $this->load->view($this->view_dir.'gradshhet_dispatch_pdf',$this->data, true);
		
		$pdfFilePath1 =$strmname[0]['stream_code'].'_'.$semester."_gradesheet_dispatch.pdf";
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$dattime = date('d-m-Y H:i:s');
		$mpdf=new mPDF();
		$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:5px">
		  <tr>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>Dispatched By :</strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>Handed Over To :</strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		   
		  </tr>
		  
		  <tr>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>Sign & Date :</strong></td>
		    <td align="center" height="40" width="100" class="signature"><strong></strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>Sign & Date :</strong></td>
			<td align="center" height="40" class="signature"><strong></strong></td>
			<td align="center" height="40" class="signature"><strong></strong></td>
		   
		  </tr>
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>
		  </tr>
		</table>';
		$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->SetHTMLFooter($footer);
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($html);	
		
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath1, "D");
	}
function download_degree_dispatch_report($mrknodetails)
	{
		$mrknodet =explode('~',$mrknodetails);
		//print_r($mrknodet);exit;
		$stream_id  =$mrknodet[0];
		$semester  =$mrknodet[1];
		$exam_id  =$mrknodet[2];
		$exam_year  =$mrknodet[3];
		$exam_month  =$mrknodet[4];
		
		//$exam_id  =$mrknodet[4];
		$this->data['exam_month'] = $exam_month;
		$this->data['exam_year'] = $exam_year;
		$this->data['semester'] = $semester;
		$var['admission_branch']=$stream_id;
		$var['semester']=$semester;
		$var['school_code']=$mrknodet[5];
		$var['regulation']=$mrknodet[6];
		
		$this->load->model('Marks_model');
		$this->data['stud_list']= $this->Certificate_model->list_result_students_for_degree_certificate($var,$stream_id, $semester,$exam_id);


		$strmname = $this->Marks_model->getStreamShortName($stream_id);
		$this->data['strmname'] = $strmname;
		$this->load->library('m_pdf');
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '10', '10', '15', '10', '10', '35');
		$html = $this->load->view($this->view_dir.'gradshhet_dispatch_pdf',$this->data, true);
		
		$pdfFilePath1 =$strmname[0]['stream_code'].'_'.$semester."_gradesheet_dispatch.pdf";
		$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
		$dattime = date('d-m-Y H:i:s');
		$mpdf=new mPDF();
		$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:5px">
		  <tr>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>Dispatched By :</strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>Handed Over To :</strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		   
		  </tr>
		  
		  <tr>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>Sign & Date :</strong></td>
		    <td align="center" height="40" width="100" class="signature"><strong></strong></td>
			<td align="center" height="40" width="100" class="signature"><strong></strong></td>
		    <td align="right" height="40" class="signature" style="text-align:right"><strong>Sign & Date :</strong></td>
			<td align="center" height="40" class="signature"><strong></strong></td>
			<td align="center" height="40" class="signature"><strong></strong></td>
		   
		  </tr>
		  <tr>
		    <td align="right" colspan="3" class="signature"><small><i>Printed on: '.$dattime.'</i></small></td>
		  </tr>
		</table>';
		$footer = mb_convert_encoding($footer, 'UTF-8', 'UTF-8');
		$this->m_pdf->pdf->SetHTMLFooter($footer);
		$this->m_pdf->pdf->AddPage();
		$this->m_pdf->pdf->WriteHTML($html);	
		
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath1, "D");
	}

/////////////////////////////////////////////////////////////////////////////////////		

	function view_consolated_gradesheet($student_id,$school_id,$stream_id,$semester,$exam_id,$exam_month,$exam_year){
		
		
		//print_r($student_id);
		
	 
	    $stud_prnn= $student_id; //chk_stud //stud_prnn
		//print_r($stud_prnn);
		//exit;
		$stud_idd= $student_id;
		$stream_id= $stream_id;
		$exam_id= $exam_id;
		$school= $school_id;
		$semester= $semester;	
		$this->data['semester']=$semester;
	    $dattime=date('Y-m-d');
		
		$current_date=$dattime;

		  // echo "inside";
	    	$enrollment_no=$this->Certificate_model->enrollment_no($student_id);
			
          $stud_list= $this->Certificate_model->Manual_certificate($enrollment_no,$stream_id,$school,$exam_id,$semester,$student_id);
		 //print_r($stud_list);
		 
		  $stud_list = $this->orderBy($stud_list, 'subject_order');
		  $this->data['stud_list']=$stud_list;

		  $this->data['exam_month']=$exam_month;
          $this->data['exam_year']=$exam_year;
          $this->data['exam_id']=$exam_id;
		  if($exam_id >=13 && $exam_id <=27){
					$signature='Sign COE 01.png';
				}else{
					$signature='Sign COE 01_parimala.png';
				}
		  //echo '<pre>'; print_r($stud_list);
		  //$html='';
		  //$this->load->view('header',$this->data);
			 $this->load->view($this->view_dir.'view_consolidated_gradesheet_certificate_html.php',$this->data);
		   //exit();
			$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:68px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"><img src="'.base_url().'assets/images/'.$signature.'" height="50" width="200"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" class="signature" style="margin-left:155px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top" style="margin-top:2px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
					
					$footer .=$current_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
				<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;">'.$current_date.'</small></td>
				</tr>
				</table>';

					 	
	}
	public function view_degree_certificate($prn)
    {
		//echo $prn='170101171034';//exit;
		$this->load->model('Certificate_model');
		$this->data['emp']= $this->Certificate_model->get_degreeCerticateStudents(base64_decode($prn));			
		$this->load->view('Certificate/degree_certificate_html_new',$this->data);

    }
	public function download_degree_certificate_for_2016($prn='160102031004')
    {
		// error_reporting(E_ALL); 
		  
		$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents($prn);  
		  
		 $this->data['exam_session']=$this->data['emp'][0]['degree_completed'];
		 $this->data['school_code']=$this->data['emp'][0]['school_code'];
		 $this->data['stud_last_ex_ses'] =$this->data['emp'][0]['sexam_month'].'-'.$this->data['emp'][0]['sexam_year']; 	
		 $this->data['mrk_cer_date']=$this->data['emp'][0]['issued_date'];
		  //$mrk_cer_date

			$this->load->library('m_pdf');
			$mpdf=new mPDF();
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '25', '25', '25', '25', '47', '25');

       
	 //  echo $_REQUEST['exam_session'];
	   $exam_ses = explode('-', $this->data['emp'][0]['degree_completed']);
	   //echo $exam_ses[0];
       //echo $exam_ses[1];
	   

			//exit;
    		//$exam_ses=$_REQUEST['exam_session'];//"DEC-2017";
			
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
			$site_url="https://erp.sandipuniversity.com/";
		    $codeContents = $site_url."Result.php?po=".$prn."&exam_month=".$exam_ses[0]."&exam_year=".$exam_ses[1];
			//exit;//'&stream_id='.$stream_id.'&exam_id='.$exam_id
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = "qrcode_".$prn.".png";		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	
			if (file_exists($pngAbsoluteFilePath)) {
				$src_file = $pngAbsoluteFilePath;
				$bucket_name = 'erp-asset';
				$filepath = $pngAbsoluteFilePath;
				$result = $this->awssdk->uploadFile($bucket_name, $filepath, $src_file);
				unlink($filepath);
			}

			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
		//	QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	
			//////////////////
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

			$pdfFilePath1 =$prn."_degree_certificate.pdf";
			$this->m_pdf->pdf->Output($tempDir.'/'.$pdfFilePath1, "F");
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
			
			
			////////////////////////////////////////////////////////////////////////////////////////////
			

    }
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function Transcript() //markscard_new
	{
	    error_reporting(E_ALL);exit();
	   if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==64){
		}else{
			redirect('home');
		}
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
			$this->data['prn'] =$_POST['prn'];
			$prn = $_POST['prn'];
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
			
		    $this->data['stud_list']= $this->Certificate_model->list_result_students_Transcript($_POST,$exam_month,$exam_year,$exam_id);	   				     
		    $this->load->view($this->view_dir.'Transcript_view',$this->data); //markscard_view

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
	        $this->load->view($this->view_dir.'Transcript_view',$this->data); //markscard_view
	        $this->load->view('footer');
	        
	    }
	    
	    
	}
	
	
	function Manual_Transcript_All(){
		
		
		//print_r($_REQUEST);
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

            $exam= explode('~', $_POST['exam_session']);
	       // $examM =explode('/', $exam[0]);
            
            $exam_month=$exam[0];
	       // $exam_montht =$examM[1];

	        $exam_year =$exam[1];
			$exam_id =$exam[2];


		$this->data['semester']=$semester;
	     $dattime=date('Y-m-d');
		 $this->load->library('m_pdf');
		
	 $current_date=$_REQUEST['current_date'];
	   //$this->data['stud_list']=$stud_list;
	   $i=0;
	    
		 //$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '20', '20', '20', '20', 'upper_margin', '20');

		     $mpdf=new mPDF();
		  // $this->m_pdf->pdf = new mPDF('utf-8', 'A4', '6', '6', '6', '6', '50', '15');
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '15', '30', '13', '11', '50', '5');
	   foreach($stud_prnn as $list){
	    	$enrollment_no=$this->Certificate_model->enrollment_no($list);
	  // exit;
	 $newid=$list; //echo '<br/>';
	//print_r($this->data['stud_list']);
	 // echo $list['enrollment_no'];
	   //   exit;
	// $k=$this->load->view($this->view_dir.'manual_certificate.php',$this->data,true);
//echo $k;
//exit;
	 $exam_ses="2019_May_new";
//$exam_ses= $exam_month.'_'.$exam_year.'_'.$exam_id;
///////////////////
			include_once "phpqrcode/qrlib.php";
			//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
			$tempDir = 'uploads/gradesheet/'.$exam_ses.'/';
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0777, true);
			}
			//$po_id = $p_row[0]['ord_no'];
			$site_url="https://erp.sandipuniversity.com/";
			$codeContents = $site_url.'grade_sheet.php?po='.$list;
			
			// we need to generate filename somehow, 
			// with md5 or with database ID used to obtains $codeContents...
			$fileName = 'qrcode_'.$list.'.png';		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	

//QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	

       
		 
		 //////////////////////////////////////////////////////////////////////////////////////////////
		 //	exit;
			//if(!empty($this->data['emp'])){
				 //   $stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css');
				//echo $list['enrollment_no'];echo '<br>';
				//echo $stud_idd[$i].'-'.$stream_id.'-'.$school_code.'-'.$exam_id.'-'.$semester.'-'.$list;
          $stud_list= $this->Certificate_model->Manual_certificate($enrollment_no,$stream_id,$school[$i],$exam_id,$semester,$list);
		 //print_r($stud_list);
		 
		  $stud_list = $this->orderBy($stud_list, 'subject_order');
		  $this->data['stud_list']=$stud_list;

		  $this->data['exam_month']=$exam_month;
          $this->data['exam_year']=$exam_year;
          $this->data['exam_id']=$exam_id;
		  if($exam_id >=13){
					$signature='Sign COE 01.png';
				}else{
					$signature='Sign COE 01_parimala.png';
				}
		  //echo '<pre>'; print_r($stud_list);
		  //$html='';
		  
		     $html =$this->load->view($this->view_dir.'manual_Transcript.php',$this->data,true);
		   
		   $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

	        /*$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:-5px">

				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" width="70" class="signature" style="margin-left:655px;margin-top:13px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td  height="50" class="signature" valign="top" style="margin-left:550px;"><strong>'; $footer .=$current_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:%23CDCACA;"></small></td>
	</tr>
	</table>';*/
	$footer = '<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:68px">
                      <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;">&nbsp;</td>
					<td align="center" height="50" class="signature">&nbsp;</td>
					<td align="right" height="50" class="signature">&nbsp;</td>
				  </tr>
					   <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;">&nbsp;</td>
					<td align="center" height="50" class="signature">&nbsp;</td>
					<td align="right" height="50" class="signature"><b>CONTROLLER OF EXAMINATIONS<b></td>
				  </tr>
				  <tr>
					<td align="left" height="50" class="signature" style="margin-left:50px;"></td>
					<td align="center" height="50" class="signature"></td>
					<td align="right" height="50" class="signature"><img src="'.base_url().'assets/images/'.$signature.'" height="50" width="200"></td>
				  </tr>
				 <tr>
					<td align="left" height="50" class="signature" style="margin-left:155px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left" height="50" class="signature" valign="top" style="margin-top:2px;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
					
					$footer .=$current_date.'</strong></td>
					<td align="right" height="50" valign="top" class="signature" style="text-align:top;"></td>
				  </tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" colspan="3" class="signature"><small style="color:#CDCACA;">'.$current_date.'</small></td>
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

	public function test_pdf(){
		
		 $this->load->library('pdfdom');
		//require_once(APPPATH.'third_party/dompdf/autoload.inc.php');
		//echo 'Tet';exit();
		//use Dompdf\Dompdf as Dompdf;
//use Dompdf\Options;
      ///  $dompdf = new Pdfdom();

//echo 'Tet';exit();
define("DOMPDF_UNICODE_ENABLED", true);
define("DOMPDF_ENABLE_REMOTE", false);
define("DOMPDF_ENABLE_CSS_FLOAT", false);
define ("DOMPDF_ENABLE_FONTSUBSETTING",false);
define("DOMPDF_ENABLE_HTML5PARSER",false);

define("DEBUGCSS",false);
define("DEBUG_LAYOUT",false);
define("DEBUG_LAYOUT_LINES",true);
define("DEBUG_LAYOUT_BLOCKS",true);
define("DEBUG_LAYOUT_INLINE",true);	
define("DEBUG_LAYOUT_PADDINGBOX	",true);

ob_start();
   $html =$this->load->view($this->view_dir.'test_html.php',$this->data,true);
  //exit();
 // $html = ob_get_clean();
//$dompdf = new DOMPDF(array('enable_remote' => true));
$this->dompdf->setPaper('A4', 'portrait');

////$options = new Options();
//$this->dompdf_option->set('defaultFont', 'DejaVuSans');
//$html1 = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
$this->dompdf->load_html($html);
$this->dompdf->render();
// $font = $dompdf->getFontMetrics()->get_font("serif", "bold");
// $dompdf->getCanvas()->page_text(72, 18, "                                        Testing", $font, 16, array(0.21,0.11,0.46));
//For view
$this->dompdf->stream("",array("Attachment" => false));
// for download
$this->dompdf->stream("sample.pdf");
  
  
/*$this->dompdf->loadHtml($html);
$this->dompdf->setPaper('A4', 'landscape');
$this->dompdf->render();
$this->dompdf->stream("welcome.pdf", array("Attachment"=>0));*/
  
  
  
  /*$html = ob_get_clean();
$dompdf = new DOMPDF(array('enable_remote' => true));
$dompdf->setPaper('A4', 'portrait');

$options = new Options();
$options->set('defaultFont', 'DejaVuSans');
//$html1 = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
$dompdf->load_html($html);
$dompdf->render();
// $font = $dompdf->getFontMetrics()->get_font("serif", "bold");
// $dompdf->getCanvas()->page_text(72, 18, "                                        Testing", $font, 16, array(0.21,0.11,0.46));
//For view
$dompdf->stream("",array("Attachment" => false));*/
// for download
//$dompdf->stream("sample.pdf");
  
		//echo 'test';
		
		/*$this->load->library('m_pdf');
		$mpdf=new mPDF();
		//$mpdf = new mPDF('utf-8', 'A4', '6', '6', '6', '6', '50', '15');
		   $this->m_pdf->pdf = new mPDF('utf-8', 'A4', '6', '6', '6', '6', '50', '15');
			//$mpdf = new mPDF('utf-8', 'A4', '15', '30', '13', '11', '37', '5');
		
	$html = '<html>
<head>
<title>Certificate</title><style>
    p, td { font-family: freeserif; }
</style></head><body><table class="table">
    <tr>
        <td><label> अथॉरिटी का नाम: <span>*</span></label></td>
        <td>' . $authname[0]['authority_name'] . '</td>
    </tr>
    <tr>
        <td><label> आवेदक का नाम  <span>*</span></label></td>
        <td>' . $feeDetails['applicant_name'] . '</td>
    </tr>
    <tr>
        <td><label> आवदेक का पता  : <span>*</span></label></td>
        <td>' . $feeDetails['applicant_address'] . '</td>
    </tr>
    <tr>
        <td><label> भूखण्ड संख्या : <span>*</span></label></td>
        <td>' . $feeDetails['land_no'] . '</td>
    </tr>
    <tr>
        <td><label> योजना का नाम : <span>*</span></label></td>
        <td>' . $feeDetails['plan_name'] . '</td>
    </tr>
    </table></body></html>';



//$mpdf->WriteHTML($stylesheet, 1);
$this->m_pdf->pdf->WriteHTML($html);

//call watermark content aand image
$this->m_pdf->pdf->SetWatermarkText('phpflow.COM');
$this->m_pdf->pdf->showWatermarkText = true;
$this->m_pdf->pdf->watermarkTextAlpha = 0.1;
$this->m_pdf->pdf->Output("phpflow.pdf", 'F');

$this->m_pdf->pdf->Output();*/
	}
	
	function load_edstreams_for_rank(){
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
				//echo '<option value="all">All</option>';
				
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
	public function Rank_Certificate() //markscard_new
	{

	   // error_reporting(E_ALL);exit();
	   if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==64){
		}else{
			redirect('home');
		}
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
			
		    //$this->data['stud_list']= $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id);
				//echo 'Inside';exit;
				$this->data['stud_list']= $this->Certificate_model->list_result_students_for_rank($_POST,$exam_month,$exam_year,$exam_id);
				//echo '<pre>';
				//print_r($this->data['stud_list']);exit;
				 $this->load->view($this->view_dir.'Rank_view',$this->data); //markscard_view
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
	        $this->load->view($this->view_dir.'Rank_view',$this->data); //markscard_view
	        $this->load->view('footer');
	        
	    }
	    
	    
	}
	
	public function download_degree_certificate_new_for_rank()
    {
        //echo '<pre>';
    	//print_r($_REQUEST);exit;
		 ini_set("memory_limit", "-1");  
		 $this->data['regulation']=$_REQUEST['regulation'];
		 $this->data['exam_session']=$_REQUEST['exam_session'];
		 $this->data['school_code']=$_REQUEST['school_code'];
		 $this->data['admission_course']=$_REQUEST['admission_course'];
		 $this->data['admission_branch']=$_REQUEST['admission_branch'];
		 $this->data['mrk_cer_date']=$_REQUEST['mrk_cer_date'];
		 $report_type=$_REQUEST['report_type'];
		 ob_start();
			$this->load->library('m_pdf');
			$mpdf=new mPDF();
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '25', '25', '25', '25', '47', '25');

            if(isset($_REQUEST['chk_stud'])) {
            $student = $_REQUEST['chk_stud'];
		 $stream_id=  $_REQUEST['stream_idn'];
		 $exam_id =  $_REQUEST['exam_idn'];
		 $rank_id   =  $_REQUEST['rank'];
	     $exam_ses = explode('~', $_REQUEST['exam_session']);
			foreach($student as $key=>$value){
			if(!empty($value)){
			 	  $prn=$value; echo '<br>';
				  $stream_id[$key];echo '<br>';
				  $exam_id[$key];
				 $student_id =$this->Certificate_model->student_id($prn);
				 $stud_last_exsess= $this->Certificate_model->stud_last_exam_session($student_id);
				 $stud_pass_in_limited_year= $this->Certificate_model->stud_pass_in_limited_year($student_id);
		         $this->data['stud_last_ex_ses'] =$stud_last_exsess[0]['exam_month'].'-'.$stud_last_exsess[0]['exam_year']; 
			$exam_ses = explode('~', $_REQUEST['exam_session']);
			include_once "phpqrcode/qrlib.php";
			$tempDir = 'uploads/degree/'.$exam_ses[0].'/'.$exam_ses[1].'/';//'/'.$stream_id.'/'.$exam_id
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				mkdir($tempDir, 0755, true);
			}
			$site_url="https://erp.sandipuniversity.com/";
		    $codeContents = $site_url."Result.php?po=".$prn."&exam_month=".$exam_ses[0]."&exam_year=".$exam_ses[1];
			$fileName = "qrcode_".$prn.".png";		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	
					$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents_new_for_rank($_REQUEST,$prn,$stream_id[$key],$exam_id[0],$rank_id[$key]);	
					 $html = $this->load->view($this->view_dir.'rank_certificate_pdf',$this->data, true);
			$this->m_pdf->pdf->useFixedNormalLineHeight = false;
            $this->m_pdf->pdf->useFixedTextBaseline = false;
            $this->m_pdf->pdf->normalLineheight = 2.7;
            $this->m_pdf->pdf->adjustFontDescLineheight = 2.7;
            $this->m_pdf->pdf->SetAutoFont();
			$this->m_pdf->pdf->autoScriptToLang = true;
            $this->m_pdf->pdf->autoLangToFont = true;
			$this->m_pdf->pdf->PageNumSubstitutions[] = [
								'from' => 1,
								'reset' => 0,
								'type' => 'I',
								'suppress' => 'off'
							];
			$this->m_pdf->pdf->AddPage();
			$this->m_pdf->pdf->WriteHTML(($html));
			$i++;
			ob_clean();
			}
			} 
			}
			$pdfFilePath1 =$prn."_degree_certificate.pdf";
			$this->m_pdf->pdf->Output($tempDir.'/'.$pdfFilePath1, "F");
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");

    }
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

public function Rank_Certificate_all() //markscard_new
	{
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==64){
		}else{
			redirect('home');
		}

	   // error_reporting(E_ALL);exit();
	    $this->load->model('Exam_timetable_model');
		$this->load->model('Marks_model');
		$this->load->model('Results_model');
		$this->data['regulatn']= $this->Exam_timetable_model->getRegulation_for_rank();
	    if($_POST){
	        //  echo "<pre>";
	        //  print_r($_POST);exit;
	        $this->load->view('header',$this->data);
			$this->data['admission_seeion'] =$_POST['regulation'];
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['cource_id'] =$_POST['admission_course'];
	        $this->data['stream'] =$_POST['admission_branch'];
	        $this->data['semester'] =$_POST['semester'];
	        $this->data['exam'] =$_POST['exam_session'];
	        $this->data['marks_type'] =$_POST['marks_type'];
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
	        $this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        $this->data['schools']= $this->Results_model->getresltSchools();
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
			
		    //$this->data['stud_list']= $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id);
				//echo 'Inside';exit;
				$this->data['stream_list']= $this->Certificate_model->list_result_students_for_rank_for_all_stream_list($_POST,$exam_month,$exam_year,$exam_id);
				//echo '<pre>';
				//print_r($this->data['stud_list']);exit;
				 $this->load->view($this->view_dir.'Rank_view_all',$this->data); //markscard_view
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
	        $this->load->view($this->view_dir.'Rank_view_all',$this->data); //markscard_view
	        $this->load->view('footer');
	        
	    }
	    
	    
	}
	
	function load_edschools_for_rank(){

		if($_POST["school_code"] !=''){
			$ex_se = explode('-', $_POST["ex_ses"]);
			//Get all city data
			$stream = $this->Certificate_model->get_edcourses_for_rank($_POST["school_code"], $ex_se[2]);
            
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
	
	public function topper_list() //markscard_new
	{

	   // error_reporting(E_ALL);exit();
	   if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==64){
		}else{
			redirect('home');
		}
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
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession_for_topper();
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
			
		    //$this->data['stud_list']= $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id);
				//echo 'Inside';exit;
				//$this->data['stud_list']= $this->Certificate_model->list_result_students_for_toperlist($_POST,$exam_month,$exam_year,$exam_id);
				$this->data['sem_list']= $this->Certificate_model->semester_for_all_topper_list($_POST,$exam_month,$exam_year,$exam_id);
				//echo '<pre>';
				//print_r($this->data['stud_list']);exit;
				 $this->load->view($this->view_dir.'topper_view',$this->data); //markscard_view
	             $this->load->view('footer');
	    }
	    else
	    {
	        
	        $this->load->view('header',$this->data);
	        $this->data['school_code'] ='';
	        $this->data['admissioncourse'] = '';
	        $this->data['stream'] = '';
	        $this->data['semester'] = '';
	        
	        $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession_for_topper();
	        //$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
	        //$this->data['schools']= $this->Results_model->getresltSchools();
	        $this->load->view($this->view_dir.'topper_view',$this->data); //markscard_view
	        $this->load->view('footer');
	        
	    }
	    
	    
	}
	
	

	
	public function export_excel_bdreport_from_app_ic_head(){
	  $this->load->library('excel');
	  		
$styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
  );
$this->excel->setActiveSheetIndex(0);
$this->excel->getActiveSheet()->setTitle('BD Reporting');
$this->excel->getActiveSheet()->getStyle('A1:Y1')->getFont()->setBold(true);
$this->excel->getActiveSheet()->getStyle('A1:Y1')->applyFromArray($styleArray);
$this->excel->getActiveSheet()->mergeCells('D1:G1');
$this->excel->getActiveSheet()->setCellValue('D1', 'No of Visite');
$this->excel->getActiveSheet()->setCellValue('H1', 'No of Consent Received');
$this->excel->getActiveSheet()->setCellValue('L1', 'No of Seminars Conducted');
$this->excel->getActiveSheet()->setCellValue('P1', 'No of Data Received');
$this->excel->getActiveSheet()->setCellValue('T1', 'No of Students Present');
$this->excel->getActiveSheet()->setCellValue('X1', 'Report');
$this->excel->getActiveSheet()->mergeCells('H1:K1');
$this->excel->getActiveSheet()->mergeCells('L1:O1');
$this->excel->getActiveSheet()->mergeCells('P1:S1');
$this->excel->getActiveSheet()->mergeCells('T1:W1');
$this->excel->getActiveSheet()->mergeCells('X1:Y1');
$this->excel->getActiveSheet()->setCellValue('A2', '#');
$this->excel->getActiveSheet()->setCellValue('B2', 'BDM Name');
$this->excel->getActiveSheet()->setCellValue('C2', 'Date');
$this->excel->getActiveSheet()->setCellValue('D2', 'School');
$this->excel->getActiveSheet()->setCellValue('E2', 'College');
$this->excel->getActiveSheet()->setCellValue('F2', 'Classes');
$this->excel->getActiveSheet()->setCellValue('G2', 'Total');
$this->excel->getActiveSheet()->setCellValue('H2', 'School');
$this->excel->getActiveSheet()->setCellValue('I2', 'College');
$this->excel->getActiveSheet()->setCellValue('J2', 'Classes');
$this->excel->getActiveSheet()->setCellValue('K2', 'Total');
$this->excel->getActiveSheet()->setCellValue('L2', 'School');
$this->excel->getActiveSheet()->setCellValue('M2', 'College');
$this->excel->getActiveSheet()->setCellValue('N2', 'Classes');
$this->excel->getActiveSheet()->setCellValue('O2', 'Total');
$this->excel->getActiveSheet()->setCellValue('P2', 'School');
$this->excel->getActiveSheet()->setCellValue('Q2', 'College');
$this->excel->getActiveSheet()->setCellValue('R2', 'Classes');
$this->excel->getActiveSheet()->setCellValue('S2', 'Total');
$this->excel->getActiveSheet()->setCellValue('T2', 'School');
$this->excel->getActiveSheet()->setCellValue('U2', 'College');
$this->excel->getActiveSheet()->setCellValue('V2', 'Classes');
$this->excel->getActiveSheet()->setCellValue('W2', 'Total');
$this->excel->getActiveSheet()->setCellValue('X2', 'Work Details');
$this->excel->getActiveSheet()->setCellValue('Y2', 'Description of work details (if any)');


/* $this->load->model('Bd_reporting_model');
$bddatas = $this->Bd_reporting_model->get_ic_reporting_for_bdm_app(date('M-Y'));
$i = 3;
$j = 1;
foreach($bddatas as $bddata){
	 //echo '<pre>';
     //print_r($bddata['date']);exit;
			$this->excel->getActiveSheet()->setCellValue('A'.$i, $j);
			$this->excel->getActiveSheet()->setCellValue('B'.$i, $bddata['fname'].$bddata['lname']);
			$this->excel->getActiveSheet()->setCellValue('C'.$i, $bddata['date']);
			$this->excel->getActiveSheet()->setCellValue('D'.$i, $bddata['visite_school_count']);
			$this->excel->getActiveSheet()->setCellValue('E'.$i, $bddata['visite_collage_count']);
			$this->excel->getActiveSheet()->setCellValue('F'.$i, $bddata['visite_classes_count']);
			$this->excel->getActiveSheet()->setCellValue('G'.$i, $bddata['visite_total']);
			$this->excel->getActiveSheet()->setCellValue('H'.$i, $bddata['consent_school_count']);
			$this->excel->getActiveSheet()->setCellValue('I'.$i, $bddata['consent_collage_count']);
			$this->excel->getActiveSheet()->setCellValue('J'.$i, $bddata['consent_classes_count']);
			$this->excel->getActiveSheet()->setCellValue('K'.$i, $bddata['consent_total']);
			$this->excel->getActiveSheet()->setCellValue('L'.$i, $bddata['seminars_school_count']);
			$this->excel->getActiveSheet()->setCellValue('M'.$i, $bddata['seminars_collage_count']);
			$this->excel->getActiveSheet()->setCellValue('N'.$i, $bddata['seminars_classes_count']);
			$this->excel->getActiveSheet()->setCellValue('O'.$i, $bddata['seminars_total']);
			$this->excel->getActiveSheet()->setCellValue('P'.$i, $bddata['data_received_school_count']);
			$this->excel->getActiveSheet()->setCellValue('Q'.$i, $bddata['data_received_college_count']);
			$this->excel->getActiveSheet()->setCellValue('R'.$i, $bddata['data_received_classes_count']);
			$this->excel->getActiveSheet()->setCellValue('S'.$i, $bddata['data_received_total']);
			$this->excel->getActiveSheet()->setCellValue('T'.$i, $bddata['student_school_count']);
			$this->excel->getActiveSheet()->setCellValue('U'.$i, $bddata['student_collage_count']);
			$this->excel->getActiveSheet()->setCellValue('V'.$i, $bddata['student_classes_count']);
			$this->excel->getActiveSheet()->setCellValue('W'.$i, $bddata['student_total']);
			$this->excel->getActiveSheet()->setCellValue('X'.$i, $bddata['work_report']);
			$this->excel->getActiveSheet()->setCellValue('Y'.$i, $bddata['workdonedescription']);
			
			
			$i++;
			$j++;
	
} */


			
$filename='testts.xls'; //save our workbook as this file name
//header('Content-Type: application/vnd.ms-excel'); //mime type
//header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
//header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 

//force user to download the Excel file without writing it to server's HD
//$objWriter->save('php://output');
//$pathh  = 'https://uat-icerp.bvocsun.org/uploads'

//$filePath = "https://uat-icerp.bvocsun.org/uploads".$filename;

$objWriter->save($filename);
 //echo 545;exit;

   $subject='BD Report 11';
		sleep(5);
		$body="Dear Sir, 
                           Please find the attached file of Daily Provisional Admission Report";
		$this->sendattachedemail1211($body,$email='balasaheb.lengare@carrottech.in',$subject,$filename);  

  }
  
  
  public function sendattachedemail1211($body,$email,$subject,$file)
    {
		
		
        $path=$_SERVER["DOCUMENT_ROOT"].'/application/third_party/';
        require_once($path.'PHPMailer/class.phpmailer.php');
        date_default_timezone_set('Asia/Kolkata');
         require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
        
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        //$mail->SMTPDebug = 4;
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        //Username to use for SMTP authentication
        $mail->Username = 'noreply@sandipuniversity.com';
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
          $mail->Password = 'kiran234!';
        //Set who the message is to be sent from
        $mail->setFrom('info@sandipuniversity.edu.in', '');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
       // $mail->addAddress('chaitali.veer@sandipfoundation.org', 'Chaitali');
        $mail->AddAddress('balasaheb.lengare@carrottech.in', 'balasaheb');
		$mail->AddAddress('saurabh.singh@sandipuniversity.edu.in', 'Saurabh');
		//$mail->AddAddress('vighnesh.sukum@sandipuniversity.edu.in', 'vighnesh');
		//$mail->AddAddress('ushakar.jha@sandipuniversity.edu.in ', 'ushakar');
		//$mail->AddAddress('pankaj.mali@sandipuniversity.edu.in', 'pankaj');
		
		//$mail->AddAddress('pramod.thasal@carrottech.in', 'Pramod');
		//$mail->AddAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod');
        //Set the subject line
        $mail->Subject = $subject;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually
//echo 11; exit;
        $mail->Body = $body;


        $mail->AltBody = 'Dear Sir,please find'.$subject;
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        
        $mail->AddAttachment($file);
        //send the message, check for errors
        if (!$mail->send()) {
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            //echo 'Message sent!';
        }
    }
	
	
		 public function smdml()
    {
		
		
        $path=$_SERVER["DOCUMENT_ROOT"].'/application/third_party/';
        require_once($path.'PHPMailer/class.phpmailer.php');
        date_default_timezone_set('Asia/Kolkata');
         require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
        
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        //$mail->SMTPDebug = 4;
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        //Username to use for SMTP authentication
        $mail->Username = 'noreply@sandipuniversity.com';
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
          $mail->Password = 'kiran234!';
        //Set who the message is to be sent from
        $mail->setFrom('info@sandipuniversity.edu.in', '');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
       // $mail->addAddress('chaitali.veer@sandipfoundation.org', 'Chaitali');
        $mail->AddAddress('balasaheb.lengare@carrottech.in', 'balasaheb');
		$mail->AddAddress('saurabh.singh@sandipuniversity.edu.in', 'Saurabh');
		//$mail->AddAddress('vighnesh.sukum@sandipuniversity.edu.in', 'vighnesh');
		//$mail->AddAddress('ushakar.jha@sandipuniversity.edu.in ', 'ushakar');
		//$mail->AddAddress('pankaj.mali@sandipuniversity.edu.in', 'pankaj');
		
		//$mail->AddAddress('pramod.thasal@carrottech.in', 'Pramod');
		//$mail->AddAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod');
        //Set the subject line
        //$mail->Subject = $subject;
        $mail->Subject = 'Hii Test';
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually
//echo 11; exit;
        //$mail->Body = $body;
        $mail->Body = 'TEST Mail FROM SU IT Team';


        $mail->AltBody = 'Dear Sir,please find'.$subject;
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        
        //$mail->AddAttachment($file);
        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
        }
    }
	
	public function convocation_stud_details()
	{    
	    $this->load->view('header',$this->data);
		$this->data['stud_details']=$this->Certificate_model->fetch_convocation_student_details();
		$this->load->view($this->view_dir.'convocation_stud_list',$this->data);
		$this->load->view('footer');
	}

}
?>