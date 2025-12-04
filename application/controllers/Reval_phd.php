<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reval_phd extends CI_Controller
{
	
    var $currentModule = "";   
    var $title = "";   
    var $table_name = "";    
    var $model_name = "Revalphd_model";   
    var $model;  
    var $view_dir = 'Reval_phd/';
 
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
        $this->load->model('Marks_model');
    }
    
    
 
	//search_student
	public function search_student(){
		//exit;
		//error_reporting(E_ALL); ini_set('display_errors', 1);	
		$this->load->view('header',$this->data);
		$this->load->model('Phd_examination_model'); 
		$this->data['exam']= $this->Revalphd_model->fetch_exam_session_for_reval();
		$this->load->view($this->view_dir.'search_student_byprn',$this->data);
		$this->load->view('footer');
	}
	 
	function search_studentdata($prn=''){
		$this->load->model('Phd_examination_model'); 
		$_POST['academic_year'] = '2017';
		$exam_id= $_POST['exam_id'];
		$this->data['exam_id'] = $_POST['exam_id'];
		//$data['exam']= $this->Phd_examination_model->fetch_stud_curr_exam();
		//$exam_id= $data['exam'][0]['exam_id'];
		if($prn ==''){
			$stud_prn= $_POST['prn'];
			$exam_id= $_POST['exam_id'];
		}else{
			$stud_prn= $prn;
		}
		//echo 'exm_'.$exam_id;exit;
		$id= $this->Phd_examination_model->get_student_id_by_prn($stud_prn);
		$stud_id=$id['stud_id'];
		$this->data['studid'] =$stud_id;
		$current_semester =$id['current_semester'];
		$stream =$id['admission_stream'];

		if($stud_id!=''){
			$this->data['exam']= $this->Phd_examination_model->fetch_stud_exam_details($stud_id, $exam_id);
			//$this->data['fee']= $this->Phd_examination_model->fetch_stud_fee_exam($stud_id, $exam_id);
			//$this->data['bank']= $this->Phd_examination_model->fetch_banks();
			$this->data['emp']= $this->Phd_examination_model->fetch_personal_details($stud_id);
			if(REVAL==0){
				$this->data['sublist']= $this->Revalphd_model->get_stud_result_subjects($stud_id, $exam_id);
			}else{
				$this->data['sublist']= $this->Revalphd_model->get_stud_photocopy_subjects($stud_id, $exam_id);
			}
			//$this->data['backlogsublist']= $this->Phd_examination_model->getStudbacklogSubjectedit($stud_id);
			$regulation = $this->data['emp'][0]['admission_session'];
			
		}

		$html = $this->load->view($this->view_dir.'student_res_ajax_data',$this->data,true);
		echo $html;
	}
	//Re-validate
	public function revalidate(){
		//echo "<pre>";
		//print_r($_POST);
		$role_id = $this->session->userdata("role_id");
		if($role_id ==4){
			$reval = REVAL;
		}else{
			$reval = $this->session->userdata('reval');
		}
		$DB1 = $this->load->database('umsdb', TRUE);
		$p_stud = $_POST['p_checked'];	
		$r_stud = $_POST['r_checked'];
		$applicable_fee = $_POST['applicable_fee'];
		$stud_id = $_POST['student_id'];
		$ex_master_id = $_POST['ex_master_id'];
		// update exam details
		if($reval==0){ // photocopy
			// update exam applied subjects for photocopy
			if(!empty($p_stud)){
				$p_exam_details =array(
					"photocpy_appeared"=>'Y',
					"photocopy_fees"=>$applicable_fee,
					"photocpy_entry_by"=>$this->session->userdata("uid"),
					"photocpy_entry_on"=>date("Y-m-d H:i:s")
				);
				$DB1->where('exam_master_id', $ex_master_id);	
				$DB1->update("phd_exam_details", $p_exam_details); 

				foreach ($p_stud as $p) {
					$pstud = explode('~', $p);
					$p_sub =  $pstud[0];
					$exam_app_sub_id =  $pstud[1];
					$pexam_details =array(
						"photocopy_appeared"=>'Y',
						"photocopy_entry_by"=>$this->session->userdata("uid"),
						"photocopy_entry_on"=>date("Y-m-d H:i:s")
					);
					$DB1->where('exam_subject_id', $exam_app_sub_id);	
					$DB1->update("phd_exam_applied_subjects", $pexam_details); 
					//echo $DB1->last_query();exit;
				}
			}
		}else{
			// update exam applied subjects for revalidation
			if(!empty($r_stud)){
				$phd_exam_details =array(
					"reval_appeared"=>'Y',
					"reval_fees"=>$applicable_fee,
					"reval_entry_by"=>$this->session->userdata("uid"),
					"reval_entry_on"=>date("Y-m-d H:i:s")
				);
				$DB1->where('exam_master_id', $ex_master_id);	
				$DB1->update("phd_exam_details", $phd_exam_details); 

				foreach ($r_stud as $r) {
					$rstud = explode('~', $r);
					$r_sub =  $rstud[0];
					$rexam_app_sub_id =  $rstud[1];
					$rexam_details =array(
						"reval_appeared"=>'Y',
						"reval_entry_by"=>$this->session->userdata("uid"),
						"reval_entry_on"=>date("Y-m-d H:i:s")
					);
					$DB1->where('exam_subject_id', $rexam_app_sub_id);	
					$DB1->update("phd_exam_applied_subjects", $rexam_details); 
				}
			}
		}

		echo "SUCCESS";
	}
	// reval list
	public function list_applied()
    {
		//	error_reporting(E_ALL);
		$this->load->model('Phd_exam_timetable_model');
		if($_POST)
		{
			$this->load->view('header',$this->data);        
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['exam'] =$_POST['exam_session'];
			$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
			$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
			$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
			$exam= explode('-', $_POST['exam_session']);
			$reval_type=$_POST['reval_type'];
			$this->data['reval_type']=$_POST['reval_type'];
			$this->session->set_userdata('reval', $reval_type);
			
			$exam_month =$exam[0];
			$exam_year =$exam[1];
			$exam_id =$exam[2];
			$this->data['exam_month'] =$exam_month;
			$this->data['exam_year'] =$exam_year;
			$this->data['exam_id'] =$exam_id;
			$this->data['rev_list']= $this->Revalphd_model->get_revalidation_list($_POST['admission-branch'],$exam_id);

			$this->load->view($this->view_dir.'reval_list_view',$this->data);

			$this->load->view('footer');    
		}
		else
		{
			$this->load->view('header',$this->data);        
			$this->data['school_code'] ='';
			$this->data['admissioncourse'] = '';
			$this->data['stream'] = '';
			$this->data['semester'] = '';

			$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
			$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
			$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
			$this->load->view($this->view_dir.'reval_list_view',$this->data);
			$this->load->view('footer');
		}
        
    } 
    // excel applied list
    function excel_applied_list($stream_id, $exam_id){
    	//error_reporting(E_ALL); ini_set('display_errors', 1);
    	$this->load->model('Subject_model');
		$this->data['course']= $this->Subject_model->get_stream_details($stream_id);
    	$this->data['rev_list']= $this->Revalphd_model->get_revalidation_list($stream_id,$exam_id);
    	$this->load->view($this->view_dir.'reval_list_excel_view',$this->data);
    }
    // download pdf form
   	function btn_download_rvalform($prn='', $exam_id=''){
		$role_id = $this->session->userdata("role_id");
		if($role_id ==4){
			$reval = REVAL;
		}else{
			$reval = $this->session->userdata('reval');
		}
		$this->load->model('Phd_examination_model'); 
		$_POST['academic_year'] = '2017';
		//$data['exam']= $this->Phd_examination_model->fetch_stud_curr_exam();
		
		if($prn ==''){
			$stud_prn= $_POST['prn'];
		}else{
			$stud_prn= $prn;
		}
		
		$stud_id=$prn;
		$this->data['studid'] =$prn;

		if($stud_id!=''){
			$this->data['exam']= $this->Phd_examination_model->fetch_stud_exam_details($stud_id, $exam_id);
			$this->data['emp']= $this->Phd_examination_model->fetch_personal_details($stud_id);			
			$this->data['sublist']= $this->Revalphd_model->get_stud_reval_subjects($stud_id, $exam_id);
			$regulation = $this->data['emp'][0]['admission_session'];
			
		}
		$this->load->library('m_pdf', $param);
	    $this->m_pdf->pdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');

		$html = $this->load->view($this->view_dir.'reval_pdf_form_view',$this->data,true);
		$this->m_pdf->pdf->WriteHTML($html);
		if($reval==0){
		    $reportName="Photocopy";
		}else{
		    $reportName="Revaluation";
		} 	
	    $pdfFilePath = $this->data['emp'][0]['enrollment_no']."_".$reportName."_Form.pdf";

	    //download it.
	    $this->m_pdf->pdf->Output($pdfFilePath, "D");
	}

	// update Reval subjects
	public function update_revalsubject_details(){  
		$DB1 = $this->load->database('umsdb', TRUE);
		$p_stud = $_POST['p_checked'];	
		$applicable_fee = $_POST['applicable_fee'];
		$stud_id = $_POST['student_id'];
		$ex_master_id = $_POST['ex_master_id'];
		$exam_id= $_POST['exam_id'];
		
		// update exam applied subjects for photocopy
		if(!empty($p_stud)){
			$p_exam_details =array(
				"photocopy_fees"=>$applicable_fee,
				"photocpy_entry_by"=>$this->session->userdata("uid"),
				"photocpy_entry_on"=>date("Y-m-d H:i:s")
			);
			$DB1->where('exam_master_id', $ex_master_id);	
			$DB1->update("phd_exam_details", $p_exam_details); 

			$prev_sub = $this->Revalphd_model->get_stud_reval_subjects($stud_id, $exam_id); // fetch previous all student subject
			//echo "<pre>";print_r($prev_sub);
			if(!empty($prev_sub)){
				foreach($prev_sub as $prvsub){
					$prv_sub_id[]= $prvsub['sub_id']; 
				}
			}

			if(!empty($p_stud)){
				foreach($p_stud as $cursub){
					$cursub1 = explode('~', $cursub);
					$curr_sub_id[]= $cursub1[0]; 
				}
			}

			foreach ($p_stud as $p) {
				$pstud = explode('~', $p);
				$p_sub =  $pstud[0];
				$exam_app_sub_id =  $pstud[1];
				if (in_array($p_sub, $prv_sub_id)){
					//echo "inside";echo "<br>";
				}else{
					$pexam_details =array(
					"photocopy_appeared"=>'Y',
					"photocopy_entry_by"=>$this->session->userdata("uid"),
					"photocopy_entry_on"=>date("Y-m-d H:i:s")
					);
					$DB1->where('exam_subject_id', $exam_app_sub_id);	
					$DB1->update("phd_exam_applied_subjects", $pexam_details); 
				}
				//delete

				foreach($prev_sub as $prsub){
					$subject_id = $prsub['sub_id'];
					if (in_array($subject_id, $curr_sub_id)){
						//echo "by";echo "<br>";
					}else{
						$pdexam_details =array(
						"photocopy_appeared"=>'N',
						"photocopy_entry_by"=>$this->session->userdata("uid"),
						"photocopy_entry_on"=>date("Y-m-d H:i:s")
						);
						$DB1->where('subject_id', $subject_id);	
						$DB1->where('stud_id', $stud_id);
						$DB1->where('exam_id', $exam_id);
						$DB1->update("phd_exam_applied_subjects", $pdexam_details); 
					}
				}

				//echo $DB1->last_query();
			}
		}
	echo "SUCCESS";
	} 
	public function update_revalsubjects(){  
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$r_stud = $_POST['r_checked'];	
		$applicable_fee = $_POST['applicable_fee'];
		$stud_id = $_POST['student_id'];
		$ex_master_id = $_POST['ex_master_id'];
		$exam_id= $_POST['exam_id'];
		
		// update exam applied subjects for photocopy
		if(!empty($r_stud)){
			$r_exam_details =array(
				"reval_fees"=>$applicable_fee,
				"reval_entry_by"=>$this->session->userdata("uid"),
				"reval_entry_on"=>date("Y-m-d H:i:s")
			);
			$DB1->where('exam_master_id', $ex_master_id);	
			$DB1->update("phd_exam_details", $r_exam_details); 
			//echo $DB1->last_query();
			$prev_sub = $this->Revalphd_model->get_stud_photocopy_reval_subjects($stud_id, $exam_id); // fetch previous all student subject
			//echo "<pre>";print_r($prev_sub);
			if(!empty($prev_sub)){
				foreach($prev_sub as $prvsub){
					$prv_sub_id[]= $prvsub['sub_id']; 
				}
			}

			if(!empty($r_stud)){
				foreach($r_stud as $cursub){
					$cursub1 = explode('~', $cursub);
					$curr_sub_id[]= $cursub1[0]; 
				}
			}

			foreach ($r_stud as $r) {
				$rstud = explode('~', $r);
				$r_sub =  $pstud[0];
				$exam_app_sub_id =  $rstud[1];
				if (in_array($r_sub, $prv_sub_id)){
					//echo "inside";echo "<br>";
				}else{
					$pexam_details =array(
					"reval_appeared"=>'Y',
					"reval_entry_by"=>$this->session->userdata("uid"),
					"reval_entry_on"=>date("Y-m-d H:i:s")
					);
					$DB1->where('exam_subject_id', $exam_app_sub_id);	
					$DB1->update("phd_exam_applied_subjects", $pexam_details); 
				}
				//delete

				foreach($prev_sub as $prsub){
					$subject_id = $prsub['sub_id'];
					if (in_array($subject_id, $curr_sub_id)){
						//echo "by";echo "<br>";
					}else{
						$pdexam_details =array(
						"reval_appeared"=>'N',
						"reval_entry_by"=>$this->session->userdata("uid"),
						"reval_entry_on"=>date("Y-m-d H:i:s")
						);
						$DB1->where('subject_id', $subject_id);	
						$DB1->where('stud_id', $stud_id);
						$DB1->where('exam_id', $exam_id);
						$DB1->update("phd_exam_applied_subjects", $pdexam_details); 
					}
				}

				//echo $DB1->last_query();
			}
		}
	echo "SUCCESS";
	} 
	// photocopy summary report
	public function summary_report()
    {
	//	error_reporting(E_ALL);
      $this->load->model('Phd_exam_timetable_model');
      if($_POST)
      {

        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['report_type'] =$_POST['report_type'];
		$this->data['reval_type'] =$_POST['reval_type'];
		$this->data['exam'] =$_POST['exam_session'];
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
		$exam= explode('-', $_POST['exam_session']);

		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_month'] =$exam_month;
		$this->data['exam_year'] =$exam_year;
		$this->data['exam_id'] =$exam_id;
		$stream = $_POST['admission-branch']; 

		$this->load->model('Subject_model');

		if($_POST['report_type']=='subjectwise'){
			$this->data['stream_list']= $this->Revalphd_model->get_summary_stream_list($stream, $exam_id,$_POST['reval_type']);
			$i=0;
			foreach ($this->data['stream_list'] as $value) {
				$stream_id=  $value['stream_id'];
				$this->data['stream_list'][$i]['subject_list']= $this->Revalphd_model->get_summary_subject_list($stream_id, $exam_id,$_POST['reval_type']);			
				$i++;
			}	
			$this->load->view($this->view_dir.'summary_report_view',$this->data);
			$this->load->view('footer');

		}elseif($_POST['report_type']=='studentwise'){
			$this->data['student_list']= $this->Phd_Phd_results_model->get_arrear_student_list($stream_id,$exam_id);
			$i=0;
			foreach ($this->data['student_list'] as $value) {
				$student_id=  $value['student_id'];
				$this->data['student_list'][$i]['stud_sub_applied']= $this->Phd_results_model->stud_arrear_subject_list($stream_id,$student_id,$exam_id);
				$i++;
			}

			$this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'pdf_studentwise_arrear_report',$this->data, true);
			$pdfFilePath1 ="Photocopy_summary_report.pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();
			$this->m_pdf->pdf = new mPDF('utf-8', 'A4', '15', '30', '10', '10', '10', '5');
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");
		}else{
			echo "Something is wrong!!";
		}
 
      }
      else
      {
      
       $this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		$this->data['exam_session']= $this->Phd_exam_timetable_model->fetch_stud_curr_exam();
		$this->data['course_details']= $this->Phd_exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Phd_exam_timetable_model->getSchools();
        $this->load->view($this->view_dir.'summary_report_view',$this->data);
        $this->load->view('footer');
      
      }    
    }
	// download photocopy summary report
	public function download_summary_report($streamid, $exam_session, $report_type,$reval_type)
    {
	//	error_reporting(E_ALL);
      $this->load->model('Phd_exam_timetable_model');

	  $this->load->view('header',$this->data);        

		$exam= explode('-', $exam_session);

		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_month'] =$exam_month;
		$this->data['exam_year'] =$exam_year;
		$this->data['exam_id'] =$exam_id;
		$this->data['reval_type'] =$reval_type;
		$stream = $streamid; 

		$this->load->model('Subject_model');

		if($report_type=='subjectwise'){
			$this->data['stream_list']= $this->Revalphd_model->get_summary_stream_list($stream, $exam_id,$reval_type);
			$i=0;
			foreach ($this->data['stream_list'] as $value) {
				$stream_id=  $value['stream_id'];
				$this->data['stream_list'][$i]['subject_list']= $this->Revalphd_model->get_summary_subject_list($stream_id, $exam_id,$reval_type);			
				$i++;
			}	
			$this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'pdf_subjectwise_arrear_report',$this->data, true);
			if($reval_type==0){
				$fname = "Photocopy";
			}else{
				$fname = "Revaluation";
			}
			$pdfFilePath1 =$fname."_subjectwise_summary_report.pdf";
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			
			$mpdf=new mPDF();
			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '30', '10', '10', '10', '5');
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath1, "D");

		}
    }
		// download photocopy summary report
	public function excel_summary_report($streamid, $exam_session, $report_type,$reval_type)
    {
	//	error_reporting(E_ALL);
		$this->load->model('Phd_exam_timetable_model');
		$exam= explode('-', $exam_session);
		
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$this->data['exam_month'] =$exam_month;
		$this->data['exam_year'] =$exam_year;
		$this->data['exam_id'] =$exam_id;
		$this->data['reval_type'] =$reval_type;
		$stream = $streamid; 

		$this->load->model('Subject_model');

		if($report_type=='subjectwise'){
			$this->data['stream_list']= $this->Revalphd_model->get_summary_stream_list($stream, $exam_id,$reval_type);
			$i=0;
			foreach ($this->data['stream_list'] as $value) {
				$stream_id=  $value['stream_id'];
				$this->data['stream_list'][$i]['subject_list']= $this->Revalphd_model->get_summary_subject_list($stream_id, $exam_id, $reval_type);			
				$i++;
			}	
			$this->load->view($this->view_dir.'excel_subjectwise_photocopy_report',$this->data);

		} 
    }
	//
		//search_student
	public function search_student_admin(){
		//error_reporting(E_ALL); ini_set('display_errors', 1);	
		$this->load->view('header',$this->data);
		$this->load->model('Phd_examination_model'); 
		$this->data['exam']= $this->Revalphd_model->fetch_exam_session_for_reval();
		$this->load->view($this->view_dir.'search_student_byprn_admin',$this->data);
		$this->load->view('footer');
	}
	// search student for admin
	function search_studentdata_admin($prn=''){
		$this->load->model('Phd_examination_model'); 
		$_POST['academic_year'] = '2017';
		$exam_id= $_POST['exam_id'];
		$this->data['exam_id'] = $_POST['exam_id'];
		//$data['exam']= $this->Phd_examination_model->fetch_stud_curr_exam();
		//$exam_id= $data['exam'][0]['exam_id'];
		if($prn ==''){
			$stud_prn= $_POST['prn'];
			$exam_id= $_POST['exam_id'];
			$reval_type= $_POST['reval_type'];
			$this->session->set_userdata('reval', $reval_type);
		}else{
			$stud_prn= $prn;
		}
		//echo 'exm_'.$exam_id;
		$id= $this->Phd_examination_model->get_student_id_by_prn($stud_prn);
		$stud_id=$id['stud_id'];
		$this->data['studid'] =$stud_id;
		$current_semester =$id['current_semester'];
		$stream =$id['admission_stream'];

		if($stud_id!=''){
			$this->data['exam']= $this->Phd_examination_model->fetch_stud_exam_details($stud_id, $exam_id);
			//$this->data['fee']= $this->Phd_examination_model->fetch_stud_fee_exam($stud_id, $exam_id);
			//$this->data['bank']= $this->Phd_examination_model->fetch_banks();
			$this->data['emp']= $this->Phd_examination_model->fetch_personal_details($stud_id);
			if($reval_type==0){
				$this->data['sublist']= $this->Revalphd_model->get_stud_result_subjects($stud_id, $exam_id);
			}else{
				$this->data['sublist']= $this->Revalphd_model->get_stud_photocopy_subjects($stud_id, $exam_id);
			}
			//$this->data['backlogsublist']= $this->Phd_examination_model->getStudbacklogSubjectedit($stud_id);
			$regulation = $this->data['emp'][0]['admission_session'];
			
		}

		$html = $this->load->view($this->view_dir.'student_res_ajax_data_admin',$this->data,true);
		echo $html;
	}
	// for accounts purpose
	public function photocopy_list_for_accounts()
    {
			//error_reporting(E_ALL);
		$this->load->view('header',$this->data);        
		$this->data['exam_session']= $this->Revalphd_model->fetch_exam_session_for_reval();
	
		$exam_month =$this->data['exam_session'][0]['exam_month'];
		$exam_year =$this->data['exam_session'][0]['exam_year'];
		$exam_id =$this->data['exam_session'][0]['exam_id'];
		$this->data['exam_month'] =$exam_month;
		$this->data['exam_year'] =$exam_year;
		$this->data['exam_id'] =$exam_id;
		$this->data['stream_id'] =0;
		$this->data['rev_list']= $this->Revalphd_model->get_revalidation_list($stream_id=0,$exam_id);
		$this->load->view($this->view_dir.'account_reval_list_view',$this->data);
		$this->load->view('footer');
	}	
	public function payments($stud_id,$exam_id)
    {
        //ini_set("display_errors", "On");
//error_reporting(1);
		$this->load->model('Fees_model');
        $this->session->set_userdata('studId', $stud_id);
        $this->load->view('header',$this->data);       
        $this->data['emp']= $this->Fees_model->fetch_personal_details($stud_id);
		$this->data['rev_list']= $this->Revalphd_model->get_revalidation_studdetails($stud_id,$exam_id);
		$this->data['exam_session']= $this->Revalphd_model->fetch_exam_session_for_reval();
		$this->data['get_feedetails']= $this->Revalphd_model->fetch_revalfees_details($stud_id,$exam_id);
		$this->data['get_bankdetails']= $this->Fees_model->get_bankdetails($stud_id);
		$this->data['bank_details']= $this->Fees_model->getbanks();
		$this->data['admission_details']= $this->Fees_model->fetch_admission_details($stud_id); 
		$this->data['installment']= $this->Fees_model->fetch_installment_details($stud_id);
        $this->load->view($this->view_dir.'view_payment_details',$this->data);
		$this->load->view('footer');
        //$this->load->view('footer');
    } 
//
    public function pay_revalexam_fee()
    {
		$this->load->model('Fees_model');
		$stud_id= $_POST['stud_id'];
		$exam_id= $_POST['exam_session'];
		$_POST['academic_year'] ='2019';
		$no_of_installment =1;
		if(!empty($_FILES['payfile']['name'])){
			$filenm=$stud_id.'-'.$no_of_installment.'-'.$_FILES['payfile']['name'];
			$config['upload_path'] = 'uploads/student_challans/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['overwrite']= TRUE;
			$config['max_size']= "2048000";
			//$config['file_name'] = $_FILES['profile_img']['name'];
			$config['file_name'] = $filenm;

			//Load upload library and initialize configuration
			$this->load->library('upload',$config);
			$this->upload->initialize($config);

			if($this->upload->do_upload('payfile')){
				$uploadData = $this->upload->data();
				$payfile = $uploadData['file_name'];
			}else{
				$payfile = '';
			}
		}
		else{
			$payfile = '';
		}
        $this->data['emp']= $this->Revalphd_model->pay_revalexam_fee($_POST,$payfile );
        redirect('reval_phd/payments/'.$stud_id.'/'.$exam_id);
	
}	
	function remove_reval($enrollment_no, $exam_id){
		if($enrollment_no !='' && $exam_id !=''){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$DB1->where('enrollment_no', $enrollment_no);
		$DB1->where('exam_id', $exam_id);
		$pdexam_details['reval_appeared'] ='N';
		$DB1->update("phd_exam_applied_subjects", $pdexam_details);
		$DB1->where('enrollment_no', $enrollment_no);
		$DB1->where('exam_id', $exam_id);
		$DB1->update("phd_exam_details", $pdexam_details);
		//echo $DB1->last_query();exit;
		}
		redirect('reval_phd/list_applied');		
	}
}
  ?>