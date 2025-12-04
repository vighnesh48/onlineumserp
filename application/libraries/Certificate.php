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
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['acd_year'] =$_POST['academic_year'];
			/*$exam = explode('-', $_POST['exam_session']);
			$exam_id =$exam[2];*/
			$stream_id = $_POST['admission-branch'];			
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
	          //echo "<pre>";
	         // print_r($_POST);exit;
	        $this->load->view('header',$this->data);
			$this->data['regulation'] =$_POST['regulation'];
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission-course'];
	        $this->data['stream'] =$_POST['admission-branch'];
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
		 $this->data['admission_course']=$_REQUEST['admission-course'];
		 $this->data['admission_branch']=$_REQUEST['admission-branch'];
		  
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
			
			
    		$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents_new($prn,$stream_id[$key],$exam_id[0]);
			
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
    		$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents_new($prn,$stream_id[$key],$exam_id[0]);
			
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
			$pdfFilePath1 ="_provisional_certificate.pdf";
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
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['acd_year'] =$_POST['academic_year'];
			/*$exam = explode('-', $_POST['exam_session']);
			$exam_id =$exam[2];*/
			$stream_id = $_POST['admission-branch'];			
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
			
    		$this->data['emp']= $this->Certificate_model->get_proviCerticateStudents_new($prn,$stream,$exam_id);
			
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
	          //echo "<pre>";
	         // print_r($_POST);exit;
	        $this->load->view('header',$this->data);
			$this->data['regulation'] =$_POST['regulation'];
	        $this->data['school_code'] =$_POST['school_code'];
	        $this->data['admissioncourse'] =$_POST['admission-course'];
	        $this->data['stream'] =$_POST['admission-branch'];
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
		   // $this->load->view($this->view_dir.'Certificate_view',$this->data); //markscard_view

	       // $this->load->view('footer');
	  //  }	
		
		
		
		
		
		
		//$this->load->view('header',$this->data);
		// $this->load->view($this->view_dir.'manual_excel');
		   // $this->load->view('footer');
		  //  function export_cd_fou_list($coid='',$sid='',$cid='',$rid=''){
//exit;
 $this->load->library('excel');
$styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
  );

$this->excel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($styleArray);
$this->excel->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);
$this->excel->getActiveSheet()->mergeCells('A1:R1')->setCellValue('k1', 'SANDIP UNIVERSITY ');
$this->excel->getActiveSheet()->getStyle('A1:R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('A2:R2')->getFont()->setBold(true);
$this->excel->setActiveSheetIndex(0);
$this->excel->getActiveSheet()->setTitle('FOU_Consultants List');
$this->excel->getActiveSheet()->setCellValue('A2', 'Sr.No');
$this->excel->getActiveSheet()->setCellValue('B2', 'PRN');
$this->excel->getActiveSheet()->setCellValue('C2', 'Student Name');
$this->excel->getActiveSheet()->setCellValue('D2', 'Classification');
$this->excel->getActiveSheet()->setCellValue('E2', 'CGPA');
$this->excel->getActiveSheet()->setCellValue('F2', 'Attempt');

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
       $cd = $this->Certificate_model->list_result_students($_POST,$exam_month,$exam_year,$exam_id);;
       $j = 3; $k=1; $j=1;  $Honours='0'; $Distinction='0';  $FirstClass='0';     $SecondClass='0';   $ThirdClass='0';
        foreach($cd as $val) { 
		                           if(($stud_list[$i]['Result']=="Honours")){
									$Resultn= "FCH";
									}else if($stud_list[$i]['Result']=="Distinction") {
									$Resultn= "FWD";
									}else if($stud_list[$i]['Result']=="First Class") {
									$Resultn=  "FC";	
									}else if($stud_list[$i]['Result']=="Second Class") {
									$Resultn=  "SC";	
									}else if($stud_list[$i]['Result']=="Third Class") {
									$Resultn=  "TC";	
									}
									
									if(($stud_list[$i]['Result']=="Honours")){
									$Honours +=1;
									}else if($stud_list[$i]['Result']=="Distinction") {
									$Distinction +=1;
									}else if($stud_list[$i]['Result']=="First Class") {
									$FirstClass +=1;	
									}else if($stud_list[$i]['Result']=="Second Class") {
									$SecondClass +=1;	
									}else if($stud_list[$i]['Result']=="Third Class") {
									$ThirdClass +=1;		
									}
		  if($stud_list[$i]['checb']==0){ $attm='First Attempt'; }else{ $attm='-';}
        	//$reff= $this->Students_model->get_ic_details($val['co_reff_by']);
        $this->excel->getActiveSheet()->setCellValue('A'.$j, $k );
       $this->excel->getActiveSheet()->setCellValue('B'.$j, $val['enrollment_no'] );
        $this->excel->getActiveSheet()->setCellValue('C'.$j,  $val['stud_name'] );
         $this->excel->getActiveSheet()->setCellValue('D'.$j, $Resultn );
       $this->excel->getActiveSheet()->setCellValue('E'.$j, $val['cumulative_gpa'] );
        $this->excel->getActiveSheet()->setCellValue('F'.$j, $attm );
        
       $j++;
       $k++;
 }
    
$ct = $j+1;
for($k=0; $k<$ct; $k++){
  $this->excel->getActiveSheet()->getStyle("A".$k.":R".$k)->applyFromArray(
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
$objWriter->save('php://output');

    // }
	}
	}//Post
/////////////////////////////////////////////////////////////////////////////////////		
}
?>