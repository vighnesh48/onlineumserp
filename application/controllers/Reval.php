<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reval extends CI_Controller
{
	
    var $currentModule = "";   
    var $title = "";   
    var $table_name = "";    
    var $model_name = "Reval_model";   
    var $model;  
    var $view_dir = 'Reval/';
 
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
        $this->load->model('Online_feemodel');
    }
    
    
 
	//search_student
	public function search_student(){
		// echo "Last date to apply is over";exit;
		//error_reporting(E_ALL); ini_set('display_errors', 1);	
		$this->load->view('header',$this->data);
		$this->load->model('Examination_model'); 
		$this->data['exam']= $this->Reval_model->fetch_exam_session_for_reval();
		$this->load->view($this->view_dir.'search_student_byprn',$this->data);
		$this->load->view('footer');
	}
	 
	function search_studentdata($prn=''){
		// echo "Last date to apply is over";exit;
		$this->load->model('Examination_model'); 
		$_POST['academic_year'] = '2017';
		$exam_id= $_POST['exam_id'];
		$this->data['exam_id'] = $_POST['exam_id'];
		//$data['exam']= $this->Examination_model->fetch_stud_curr_exam();
		//$exam_id= $data['exam'][0]['exam_id'];
		if($prn ==''){
			$stud_prn= $_POST['prn'];
			$exam_id= $_POST['exam_id'];
		}else{
			$stud_prn= $prn;
		}
		$arr_mal=array();
		$arr_hold=array('24SUN0412','24SUN0844','24SUN1356','24SUN2607','24SUN3251','24SUN3277','24SUN3463','24SUN3474','24SUN3501','24SUN3560','24SUN3597','24SUN3782','24SUN4132','24SUN4444','24SUN4492','24SUN4657','24SUN4783','24SUN4806','24SUN5041','24SUN5290','24SUN5496','24SUN5501','24SUN5507');
		if(in_array($enrollment_no, $arr_hold)){
			echo "<span style='color:red;'>You are not applicable for Revaluation.</span>";exit;
		}
		//echo 'exm_'.$exam_id;
		$id= $this->Examination_model->get_student_id_by_prn($stud_prn);
		$stud_id=$id['stud_id'];
		$enrollment_no=$id['enrollment_no'];
		$this->data['studid'] =$stud_id;
		$current_semester =$id['current_semester'];
		$stream =$id['admission_stream'];
		$check_malpractice = $this->Reval_model->check_malpractice($stud_id, $exam_id);
		foreach($check_malpractice as $ml){
			$arr_mal[] = $ml['enrollment_no'];
		}
		if(in_array($enrollment_no, $arr_mal)){
			echo "<span style='color:red;'>You are not applicable for Revaluation as you  are involved in malpractice</span>";exit;
		}else{
			if($stud_id!=''){
				$this->data['exam']= $this->Examination_model->fetch_stud_exam_details($stud_id, $exam_id);
				//$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id, $exam_id);
				//$this->data['bank']= $this->Examination_model->fetch_banks();
				$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
				
				if(REVAL==0){
					$this->data['sublist']= $this->Reval_model->get_stud_result_subjects($stud_id, $exam_id);
				}else{
					$this->data['sublist']= $this->Reval_model->get_stud_photocopy_subjects($stud_id, $exam_id);
				}
				//$this->data['backlogsublist']= $this->Examination_model->getStudbacklogSubjectedit($stud_id);
				$regulation = $this->data['emp'][0]['admission_session'];
				
			}
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
		$rt_stud = $_POST['rt_checked'];
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
				$DB1->update("exam_details", $p_exam_details); 

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
					$DB1->update("exam_applied_subjects", $pexam_details); 
					//echo $DB1->last_query();
				}
			}
		}else{
			$revl=REVAL;
			if($revl=='0'){
				exit;
			}
			// update exam applied subjects for revalidation
			if(!empty($r_stud)){
				$exam_details =array(
					"reval_appeared"=>'Y',
					"reval_fees"=>$applicable_fee,
					"reval_entry_by"=>$this->session->userdata("uid"),
					"reval_entry_on"=>date("Y-m-d H:i:s")
				);
				$DB1->where('exam_master_id', $ex_master_id);	
				$DB1->update("exam_details", $exam_details); 

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
					$DB1->update("exam_applied_subjects", $rexam_details); 
				}
			}
			/*if(!empty($rt_stud)){
				$exam_details =array(
					"re_totaling_appeared"=>'Y',
					"reval_fees"=>$applicable_fee
				);
				$DB1->where('exam_master_id', $ex_master_id);	
				$DB1->update("exam_details", $exam_details); 

				foreach ($rt_stud as $r) {
					$rtstud = explode('~', $r);
					$rt_sub =  $rtstud[0];
					$rexam_app_sub_id =  $rtstud[1];
					$rexam_details =array(
						"re_totaling_appeared"=>'Y'
					);
					$DB1->where('exam_subject_id', $rexam_app_sub_id);	
					$DB1->update("exam_applied_subjects", $rexam_details); 
				}
			}*/
		}

		echo "SUCCESS";
	}
	// reval list
	public function list_applied()
    {
		//	error_reporting(E_ALL);
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==71){
		}else{
			redirect('home');
		}
		$this->load->model('Exam_timetable_model');
		if($_POST)
		{
			$this->load->view('header',$this->data);        
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['exam'] =$_POST['exam_session'];
			$this->data['exam_session']= $this->Reval_model->fetch_exam_session_for_reval();
			$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
			$this->data['schools']= $this->Exam_timetable_model->getSchools();
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
			$this->data['rev_list']= $this->Reval_model->get_revalidation_list($_POST['admission-branch'],$exam_id);

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

			$this->data['exam_session']= $this->Reval_model->fetch_exam_session_for_reval();
			$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
			$this->data['schools']= $this->Exam_timetable_model->getSchools();
			$this->load->view($this->view_dir.'reval_list_view',$this->data);
			$this->load->view('footer');
		}
        
    } 
    // excel applied list
    function excel_applied_list($stream_id, $exam_id){
    	//error_reporting(E_ALL); ini_set('display_errors', 1);
    	$this->load->model('Subject_model');
		$this->data['course']= $this->Subject_model->get_stream_details($stream_id);
    	$this->data['rev_list']= $this->Reval_model->get_revalidation_list($stream_id,$exam_id);
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
		$this->load->model('Examination_model'); 
		$_POST['academic_year'] = '2017';
		//$data['exam']= $this->Examination_model->fetch_stud_curr_exam();
		
		if($prn ==''){
			$stud_prn= $_POST['prn'];
		}else{
			$stud_prn= $prn;
		}
		
		$stud_id=$prn;
		$this->data['studid'] =$prn;

		if($stud_id!=''){
			$this->data['exam']= $this->Examination_model->fetch_stud_exam_details($stud_id, $exam_id);
			$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);			
			$this->data['sublist']= $this->Reval_model->get_stud_reval_subjects($stud_id, $exam_id);
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

         print_r($_POST);	exit;
		$DB1 = $this->load->database('umsdb', TRUE);
		$p_stud = $_POST['p_checked'];	
		$applicable_fee = $_POST['applicable_fee'];
		$stud_id = $_POST['student_id'];
		$ex_master_id = $_POST['ex_master_id'];
		$exam_id= $_POST['exam_id'];
		
		// update exam applied subjects for photocopy
		if(!empty($p_stud)){
			echo 11212;exit;
			$p_exam_details =array(
				"photocopy_fees"=>$applicable_fee,
				"photocpy_entry_by"=>$this->session->userdata("uid"),
				"photocpy_entry_on"=>date("Y-m-d H:i:s")
			);
			$DB1->where('exam_master_id', $ex_master_id);	
			$DB1->update("exam_details", $p_exam_details); 
			
            echo $DB1->last_query();exit;
			$prev_sub = $this->Reval_model->get_stud_reval_subjects($stud_id, $exam_id); // fetch previous all student subject
			
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
					$DB1->update("exam_applied_subjects", $pexam_details); 
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
						$DB1->update("exam_applied_subjects", $pdexam_details); 
					}
				}
           
				//echo $DB1->last_query();
			}
			
			               
								//echo $hash;
		}
		
		
	echo "SUCCESS";
	} 
	public function update_revalsubjects(){  
		 // echo '<pre>';
		 // print_r($_POST);
		 // exit;
						  
		$DB1 = $this->load->database('umsdb', TRUE);
		
		$r_stud = $_POST['r_sub'];	
		$applicable_fee = $_POST['applicable_fee'];
		$stud_id = $_POST['student_id'];
		$ex_master_id = $_POST['ex_master_id'];
		$exam_id= $_POST['exam_id'];
		$reval_type= $_POST['reval_type'];
		$txnid=date('ymdhis')."-".$_POST['student_id'];
		if($reval_type==0){
			$r_stud = $_POST['p_sub'];
		}else{
			$r_stud = $_POST['r_sub'];
		}
		// update exam applied subjects for photocopy
		if(!empty($r_stud)){
			//echo count($r_stud);exit;
			if($reval_type==0){
				$r_exam_details =array(
					"photocopy_fees"=>$applicable_fee,
					"txnid_photocopy"=>$txnid,
					"photocpy_entry_by"=>$this->session->userdata("uid"),
					"photocpy_entry_on"=>date("Y-m-d H:i:s")
				);
			}else{
				$r_exam_details =array(
					"reval_fees"=>$applicable_fee,
					"txnid_reval"=>$txnid,
					"reval_entry_by"=>$this->session->userdata("uid"),
					"reval_entry_on"=>date("Y-m-d H:i:s")
				);
			}
			
			$DB1->where('exam_master_id', $ex_master_id);	
			$DB1->update("exam_details", $r_exam_details); 
			//echo $DB1->last_query();
			$prev_sub = $this->Reval_model->get_stud_photocopy_reval_subjects($stud_id, $exam_id,$reval_type); // fetch previous all student subject
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
					echo "inside";echo "<br>";//exit;
				}else{
					
					if($reval_type==0){
						$pexam_details =array(
							"txnid_photocopy"=>$txnid,
							"photocopy_entry_by"=>$this->session->userdata("uid"),
							"photocopy_entry_on"=>date("Y-m-d H:i:s")
						);
					}else{					
						$pexam_details =array(
						//"reval_appeared"=>'Y',
						"txnid_reval"=>$txnid,
						"reval_entry_by"=>$this->session->userdata("uid"),
						"reval_entry_on"=>date("Y-m-d H:i:s")
						);
					}
					
					$DB1->where('exam_subject_id', $exam_app_sub_id);	
					$DB1->update("exam_applied_subjects", $pexam_details); 
					//echo $DB1->last_query();exit;
				}
				//delete

				foreach($prev_sub as $prsub){
					$subject_id = $prsub['sub_id'];
					if (in_array($subject_id, $curr_sub_id)){
						//echo "by";echo "<br>";
					}else{
						if($reval_type==0){
							$pdexam_details =array(
								"photocopy_appeared"=>'N',
								"photocpy_entry_by"=>$this->session->userdata("uid"),
								"photocpy_entry_on"=>date("Y-m-d H:i:s")
							);
						}else{						
							$pdexam_details =array(
							"reval_appeared"=>'N',
							"reval_entry_by"=>$this->session->userdata("uid"),
							"reval_entry_on"=>date("Y-m-d H:i:s")
							);
						}
						$DB1->where('subject_id', $subject_id);	
						$DB1->where('stud_id', $stud_id);
						$DB1->where('exam_id', $exam_id);
						$DB1->update("exam_applied_subjects", $pdexam_details); 
					}
				}

				//echo $DB1->last_query();
				
				
								//echo $hash;
								//exit();
								//////////////////////////////////////////////////////////////
								
						  
								//return array('txnid'=>$txnid,'hash'=>$hash);
			}
			$MERCHANT_KEY = "soe5Fh"; //Please change this value with live key for production
						   $hash_string = '';
						   // Merchant Salt as provided by Payu
						   $SALT = "OhVBBZuL"; //Please change this value with live salt for production
						   //$txnid=date('ddmmyyyy').rand(100,999);
						   // End point - change to https://secure.payu.in for LIVE mode
						   $PAYU_BASE_URL = "https://secure.payu.in";
						   
						   $action = '';
						   
						   $posted = array();
						   if(!empty($_POST)) {
						 //  print_r($_POST);exit();
						   foreach($_POST as $key => $value) {    
						   $posted[$key] = $value; 
						   
						   }
						   }
						  
						   
						   
						   $trans_id=$this->Online_feemodel->insert_exam_fees($_POST,$txnid);
						   
						   $recepit = date('ymd')."".$trans_id; //recepit s
						   
						   
						   $formError = 0;
						   
						  // if(empty($posted['txnid'])) {
						   // Generate random transaction id
						   //$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
						  //$txnid=date('ddmmyyyy').rand(100,999);
						 //  } else {
						   //$txnid = $posted['txnid'];
						  // }
						  
						   $hash = '';
						   //$txnid=date('dmY').rand(100,999);
						   //$txnid=date('dmY').rand(100,999);
						   // Hash Sequence
						   $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
						 
						 
						   $posted['txnid']=$txnid;
						   /* 
						   
						   if($posted['productinfo']=="Re-Registration"){
							  $amount= $this->Online_feemodel->fetch_ReRegistration($_POST);
							  $udf6=$posted['udf6'];
							  $posted['amount']=$amount+$udf6;
							//  $pay=$amount;
						   }else{
							  $posted['amount']=$posted['amount'];
						   } */
			               $posted['amount'] = $posted['applicable_fee'];
			              // $posted['amount'] = 1;
						   
						   $posted['udf1']=$recepit;//receipt_no
						  // $posted['udf2']=$posted['udf2'];//Academic Year
						   $posted['udf3']=$posted['udf3'];//enrollment_no
						   $posted['udf4']=$posted['udf4'];//mobile
						   $posted['udf5']=$posted['student_id'];//user_type
						   
						   if(empty($_POST['hash']) && sizeof($posted) > 0) {
								 
						   if(empty($posted['key'])|| empty($posted['txnid'])|| empty($posted['amount'])|| empty($posted['firstname'])|| empty($posted['email'])
						|| empty($posted['productinfo'])) {
							  $formError = 1;
							 //print_r($_POST);exit();
						   } else {
						   
						   $hashVarsSeq = explode('|', $hashSequence);
						   
						   foreach($hashVarsSeq as $hash_var) {
							$hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
							$hash_string .= '|';
						   }
						   
						   $hash_string .= $SALT;
						   
						   
						   $hash = strtolower(hash('sha512', $hash_string));
							
							// print_r($_POST);exit();
						   $action = $PAYU_BASE_URL . '/_payment';
						   }
						   } elseif(!empty($posted['hash'])) {
						   $hash = $posted['hash'];
						   $action = $PAYU_BASE_URL . '/_payment';
						   }
		}
	echo json_encode(array('txnid'=>$txnid,'hash'=>$hash,'amount'=>$posted['amount'],'udf1'=>$recepit,'udf3'=>$posted['udf3'],'udf4'=>$posted['mobile'],'udf5'=>$posted['stud_id']));
	} 
	// photocopy summary report
	public function summary_report()
    {
	//	error_reporting(E_ALL);
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==65 || $this->session->userdata("role_id")==71){
		}else{
			redirect('home');
		}
      $this->load->model('Exam_timetable_model');
      if($_POST)
      {

        $this->load->view('header',$this->data);        
		$this->data['school_code'] =$_POST['school_code'];
		$this->data['admissioncourse'] =$_POST['admission-course'];
		$this->data['stream'] =$_POST['admission-branch'];
		$this->data['report_type'] =$_POST['report_type'];
		$this->data['reval_type'] =$_POST['reval_type'];
		$this->data['exam'] =$_POST['exam_session'];
		$this->data['entry_date'] =$_POST['entry_date'];
		$this->data['exam_session']= $this->Reval_model->fetch_exam_session_for_reval();
		$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
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
			// echo 1;exit;
			$this->data['stream_list']= $this->Reval_model->get_summary_stream_list($stream, $exam_id,$_POST['reval_type'],$_POST['entry_date']);
			$i=0;
			foreach ($this->data['stream_list'] as $value) {
				$stream_id=  $value['stream_id'];
				$this->data['stream_list'][$i]['subject_list']= $this->Reval_model->get_summary_subject_list($stream_id, $exam_id,$_POST['reval_type'],$_POST['entry_date']);			
				$i++;
			}	
			$this->load->view($this->view_dir.'summary_report_view',$this->data);
			$this->load->view('footer');

		}elseif($_POST['report_type']=='studentwise'){
			// echo 11;exit;
			$this->data['student_list']= $this->Results_model->get_arrear_student_list($stream_id,$exam_id);
			$i=0;
			foreach ($this->data['student_list'] as $value) {
				$student_id=  $value['student_id'];
				$this->data['student_list'][$i]['stud_sub_applied']= $this->Results_model->stud_arrear_subject_list($stream_id,$student_id,$exam_id);
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
	
		$this->data['exam_session']= $this->Reval_model->fetch_exam_session_for_reval();
		$this->data['course_details']= $this->Exam_timetable_model->getCollegeCourse();
		$this->data['schools']= $this->Exam_timetable_model->getSchools();
        $this->load->view($this->view_dir.'summary_report_view',$this->data);
        $this->load->view('footer');
      
      }    
    }
	// download photocopy summary report
public function download_summary_report($streamid, $exam_session, $report_type, $reval_type, $entry_date='')
{
    $this->load->model('Exam_timetable_model');
    $this->load->view('header', $this->data);        

    $exam = explode('-', $exam_session);
    $exam_month = $exam[0];
    $exam_year = $exam[1];
    $exam_id = $exam[2];
    $this->data['exam_month'] = $exam_month;
    $this->data['exam_year'] = $exam_year;
    $this->data['exam_id'] = $exam_id;
    $this->data['reval_type'] = $reval_type;
    $this->data['dtdate'] = $entry_date;
    $stream = $streamid; 

    $this->load->model('Subject_model');

    if($report_type == 'subjectwise'){
        $this->data['stream_list'] = $this->Reval_model->get_summary_stream_list($stream, $exam_id, $reval_type, $entry_date);
        $i = 0;
        foreach ($this->data['stream_list'] as $value) {
            $stream_id = $value['stream_id'];
            $this->data['stream_list'][$i]['subject_list'] = $this->Reval_model->get_summary_subject_list($stream_id, $exam_id, $reval_type, $entry_date);            
            $i++;
        }    
        
        $this->load->library('m_pdf');
        
        // Prepare HTML content for the report
        $html = $this->load->view($this->view_dir.'pdf_subjectwise_arrear_report', $this->data, true);
        
        // Set file name based on revaluation type
        if($reval_type == 0){
            $fname = "Photocopy";
        } else {
            $fname = "Revaluation";
        }
        $pdfFilePath1 = $fname . "_subjectwise_summary_report.pdf";
        
        // Convert HTML to UTF-8
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        
        // Initialize mPDF
        $mpdf = new mPDF('L', 'A4', '', '', 10, 10, 35, 15, 5, 5);
        
        // Set the HTML Header for each page
        $header = '
            <table cellpadding="0" cellspacing="0" border="0" align="center" width="800">
                <tr>
                    <td width="80" align="center" style="text-align:center;padding-top:5px;" rowspan="2">
                        <img src="'. base_url() .'assets/images/logo-7.jpg" alt="" width="70" border="0">
                    </td>
                    <td style="font-weight:normal;text-align:center;">
                        <h1 style="font-size:30px;">Sandip University</h1>
                        <p>Mahiravani, Trimbak Road, Nashik – 422 213</p>
                    </td>
                    <td width="120" align="right" valign="top" style="text-align:right;" rowspan="2">
                        <span style="font-size: 20px;"><b>COE</b></span>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="text-align:center;padding-top:2px;">
                        <h3 style="font-size:14px;">
                            OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>
                            <u style="font-size:13px;">SUBJECTWISE '.$fname.' REPORT - '.$exam_month.' '.$exam_year.' FOR '. ($dtdate == '' ? 'ALL DATES' : $dtdate) .'
                        </h3>
                    </td>
                </tr>      
            </table>
            <hr>
        ';
        
        // Set the HTML Footer (including page numbers)
        $footer = '
            <table width="100%" style="font-size:10px; border-top:1px solid #aaa;">
                <tr>
                    <td width="40%">Printed on: '. date('d-m-Y H:i:s') .'</td>
                    <td width="20%" align="center">Page {PAGENO} of {nb}</td>
                    <td width="40%" align="right"><b>Total Amount Payable:</b> ' . number_format($total_amount, 2) . '</td>
                </tr>
            </table>
        ';
        
        // Set Header and Footer for the document
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);
        
        // Write HTML content to mPDF
        $mpdf->WriteHTML($html);
        
        // Output the generated PDF file to the browser (download it)
        $mpdf->Output($pdfFilePath1, "D");
    }
}

		// download photocopy summary report
	public function excel_summary_report($streamid, $exam_session, $report_type,$reval_type,$entry_date='')
    {
	//	error_reporting(E_ALL);
		$this->load->model('Exam_timetable_model');
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
			$this->data['stream_list']= $this->Reval_model->get_summary_stream_list($stream, $exam_id,$reval_type,$entry_date);
			$i=0;
			foreach ($this->data['stream_list'] as $value) {
				$stream_id=  $value['stream_id'];
				$this->data['stream_list'][$i]['subject_list']= $this->Reval_model->get_summary_subject_list($stream_id, $exam_id, $reval_type,$entry_date);			
				$i++;
			}	
			$this->load->view($this->view_dir.'excel_subjectwise_photocopy_report',$this->data);

		} 
    }
	//
		//search_student
	public function search_student_admin(){
		if($this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
		//error_reporting(E_ALL); ini_set('display_errors', 1);	
		$this->load->view('header',$this->data);
		$this->load->model('Examination_model'); 
		$this->data['exam']= $this->Reval_model->fetch_exam_session_for_reval();
		$this->load->view($this->view_dir.'search_student_byprn_admin',$this->data);
		$this->load->view('footer');
	}
	// search student for admin
	function search_studentdata_admin($prn=''){
		$this->load->model('Examination_model'); 
		$_POST['academic_year'] = '2017';
		$exam_id= $_POST['exam_id'];
		$this->data['exam_id'] = $_POST['exam_id'];
		//$data['exam']= $this->Examination_model->fetch_stud_curr_exam();
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
		$id= $this->Examination_model->get_student_id_by_prn($stud_prn);
		$stud_id=$id['stud_id'];
		$this->data['studid'] =$stud_id;
		$current_semester =$id['current_semester'];
		$stream =$id['admission_stream'];

		if($stud_id!=''){
			$this->data['exam']= $this->Examination_model->fetch_stud_exam_details($stud_id, $exam_id);
			//$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id, $exam_id);
			//$this->data['bank']= $this->Examination_model->fetch_banks();
			$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
			if($reval_type==0){
				$this->data['sublist']= $this->Reval_model->get_stud_result_subjects($stud_id, $exam_id);
			}else{
				$this->data['sublist']= $this->Reval_model->get_stud_photocopy_subjects($stud_id, $exam_id);
			}
			//$this->data['backlogsublist']= $this->Examination_model->getStudbacklogSubjectedit($stud_id);
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
		$this->data['exam_session']= $this->Reval_model->fetch_exam_session_for_reval();
	
		$exam_month =$this->data['exam_session'][0]['exam_month'];
		$exam_year =$this->data['exam_session'][0]['exam_year'];
		$exam_id =$this->data['exam_session'][0]['exam_id'];
		$this->data['exam_month'] =$exam_month;
		$this->data['exam_year'] =$exam_year;
		$this->data['exam_id'] =$exam_id;
		$this->data['stream_id'] =0;
		$this->data['rev_list']= $this->Reval_model->get_revalidation_list($stream_id=0,$exam_id);
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
		$this->data['rev_list']= $this->Reval_model->get_revalidation_studdetails($stud_id,$exam_id);
		$this->data['exam_session']= $this->Reval_model->fetch_exam_session_for_reval();
		$this->data['get_feedetails']= $this->Reval_model->fetch_revalfees_details($stud_id,$exam_id);
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
        $this->data['emp']= $this->Reval_model->pay_revalexam_fee($_POST,$payfile );
        redirect('reval/payments/'.$stud_id.'/'.$exam_id);
	
}	
	function remove_reval($enrollment_no, $exam_id){
		if($enrollment_no !='' && $exam_id !=''){
		$DB1 = $this->load->database('umsdb', TRUE);	
		$DB1->where('enrollment_no', $enrollment_no);
		$DB1->where('exam_id', $exam_id);
		$pdexam_details['reval_appeared'] ='N';
		$DB1->update("exam_applied_subjects", $pdexam_details);
		$DB1->where('enrollment_no', $enrollment_no);
		$DB1->where('exam_id', $exam_id);
		$DB1->update("exam_details", $pdexam_details);
		//echo $DB1->last_query();exit;
		}
		redirect('reval/list_applied');		
	}
	
}
  ?>