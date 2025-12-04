<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once(APPPATH.'third_party/mpdf/mpdf.php');
class Examination extends CI_Controller{

	var $currentModule = "";   
	var $title = "";   
	var $table_name = "unittest_master";    
	var $model_name = "Examination_model";   
	var $model;  
	var $view_dir = 'Examination/';
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
		
		$this->load->model('Online_feemodel');
		$this->load->model('Payment_model');
		$this->load->model('Results_model');
		$menu_name = $this->uri->segment(1);
        $this->load->model('EcrEmpRegModel');
		$this->data['my_privileges'] = $this->retrieve_privileges($menu_name);
		$this->load->library('Awssdk');
		        $user_name = $this->session->userdata('name'); // this should be email
        // echo $user_name;
    
        // Store center_id in session if matching active entry exists

        $centerData = $this->EcrEmpRegModel->getCenterIdIfUserExists($user_name);

        if (!empty($centerData)) {
            $center_ids = array_column($centerData, 'center_id'); // extract only center_id values
            $this->session->set_userdata('center_ids', $center_ids);
        }
        $center_ids = $this->session->userdata('center_ids');

		
        
	}
    
    
    
	public function index($student_prn=''){  
		//	echo "Last Date to be apply is over.";exit;
		if($this->session->userdata("role_id")==4 || $this->session->userdata("role_id")==9){
			
			//echo "Last Date to be apply is over.";exit;
			
		} 
		
		//$hostarr_prn =array('220105181047','220101061013','220101051044','210101061019','210101061018','220101061011','230101061016','230105131230','230102011040','230105131229');
		
		$reddystudents= array();
		
		$ban_user = array();
		

		$ban_user_uniform = array();
		$ban_user_transport = array(240106301013,'25sun3167',240106141012,240106191008,240106121023,240106191001);
		$ban_user_hostel = array();
		$arr_prn = array();
		$for_no_fine = array();
	
		$stream_ids = array();
		
		// $stream_ids = array(7, 11, 97, 162);
			
		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}

		//echo '<pre>';
		//print_r($unifrorm->status);
		//exit;
		if (preg_match('/^25sun/i', $stud_prn) || strlen($stud_prn) != 12) {
			echo '12 Digit PRN not generated yet,kindly contact to student section';exit;
		}

		if(in_array($stud_prn, $ban_user_transport)){ 
			echo "Your Transport Fees are pending, kindly contact to transport office";exit;
		}		
		 $id = $this->Examination_model->get_student_id_by_prn($stud_prn);
		 

		 //print_r($id);exit;
		 
		 if($stud_prn=='210102321031'){


			// echo $id['current_year']; echo $id['course_duration'];
			// ini_set('display_errors', 1);
			// ini_set('display_startup_errors', 1);
			// error_reporting(E_ALL);

		}
		
		###############
		
		$this->data['exam_session_val']= $this->Examination_model->fetch_stud_curr_exam_ecr(); 
		$this->data['exam']= $this->Examination_model->fetch_stud_curr_exam_ecr();
		
		/****** Exam allowed  student list start ********/
		$allowed_prn=$this->Examination_model->get_exam_allowed_studntlist($this->data['exam_session_val'][0]['exam_id'],$stud_prn);
		
		foreach($allowed_prn as $pr) {
			// Check if the student is allowed for uniform
			if($pr['for_uniform'] == 'Y') {
				$ban_user_uniform[] = $pr['enrollment_no'];
			}
			// Check if the student is allowed for academic fees
			if($pr['for_academic_fees'] == 'Y') {
				$arr_prn[] = $pr['enrollment_no'];
			}
			if($pr['for_hostel'] == 'Y') {
				$ban_user_hostel[] = $pr['enrollment_no'];
			}
			if($pr['for_no_fine'] == 'Y') {
				$for_no_fine[] = $pr['enrollment_no'];
			}
		}
		
		//		echo '<pre>';print_r($allowed_prn);exit;

		 $this->data['for_no_fine']=$for_no_fine;
		 if($stud_prn=='240105231346'){
			/* print_r($ban_user_uniform);echo '<br>';
			print_r($arr_prn);echo '<br>';
			print_r($ban_user_hostel);echo '<br>';//exit; */
		}
		/****** Exam allowed  student list end  ********/
		
		if($this->data['exam'][0]['exam_type']!='Makeup' && $id['admission_session']==C_RE_REG_YEAR){
			//echo 'inside';exit;
			$unifrorm = file_get_contents("https://onlinepayments.sandipuniversity.com/uniform/api_for_uniform_payment_check/".$id['enrollment_no']."/".$id['enrollment_no_new']);
			$unifrorm = json_decode($unifrorm);

			$cd = $id['course_duration']-2;
			$arr_uni_not_allowed_courses =array();
			/*if($id['nationality'] !='INTERNATIONAL'){
				if(!in_array($id['course_id'],$arr_uni_not_allowed_courses)){
					if($id['course_type'] !='PG' && $cd >= $id['current_year'] ){
						if($unifrorm->status ==1 || in_array($stud_prn, $ban_user_uniform)){
									
					   }else{
							echo "Your uniform fees are not paid, kindly pay fees and try again!";exit; 
					   }
					}
				}
			}*/
			##########
			 // && $id['course_id']==5
			 $arr_uni_not_allowed_courses =array(3,19,10,12,25,22);
			 /* if(!in_array($id['course_id'],$arr_uni_not_allowed_courses)){ //mtech checking
				 
				 if($id['current_year'] != $id['course_duration']){
					if($id['course_id']==5 && $id['current_year'] != $id['course_duration']){ 
						  if($unifrorm->status ==1 || in_array($stud_prn, $ban_user_uniform)){
							//
						   }else{
							   echo "Your uniform fees are not paid, kindly pay fees and try again!";exit; 
						   }
					}
					else{
						if($unifrorm->status ==1 || in_array($stud_prn, $ban_user_uniform)){
							
						   }else{
							   echo "Your uniform fees are not paid, kindly pay fees and try again!";exit; 
						   }
					}
				 }
			 }*/
			 //echo 2;exit;
			 if($id['admission_stream']==71){	  
				//echo "Your not allowed for the exam. Kindly contact your HOD.";exit; 	 
			 }

			 if(!in_array($id['course_id'],$arr_uni_not_allowed_courses) && $id['school_code']!='1009'){
				  if($id['admission_session'] == ADMISSION_SESSION ){
					  if($unifrorm->status ==1 || in_array($stud_prn, $ban_user_uniform) || $id['nationality'] == 'INTERNATIONAL'){
						
					   }else{
						  echo "Your uniform fees are not paid, kindly pay fees and try again!";exit; 
					   } 
				 } 
			 }
		}
		/* if(($id['current_year']==1 || $id['current_year']==2 || $id['current_year']==3) && $id['academic_year']==2023){
			//echo '1';
		}else{
			echo "Exam date is over. Please contact Coe Department1.";exit; 
		} */
		$whconditions = $this->Results_model->fetch_withheld_student_data($stud_prn);
		
		if(empty($whconditions)){
			
		}else{
			echo "Your are in with held condition, thats why you are not allowed for exam. Please contact CoE Department.";exit; 
		}
		
		if(!in_array($stud_prn, $ban_user)){
               
           }else{
			   echo "You are not allowed for exam.";exit;
          }
		
		//$unifrorm = file_get_contents("https://onlinepayments.sandipuniversity.com/uniform/api_for_hostel_payment_check/".$stud_prn);
		//$unifrorm = json_decode($unifrorm);
		
		//if($unifrorm->status ==1){
			
		//}else{
			//echo "Your hostel fees are not paid, thats why you are  allowed for exam.";exit; 
		//}
		//$arr_prn= array('220105131210');
		$sem_arr =array(1,2,3);
		
         //if(in_array($id['admission_stream'],$stream_ids) && $id['academic_year'] !='2022'){
         //if(($id['academic_year'] =='2022' || $id['academic_year']=='2023') && ($id['admission_stream']!=116) && ($id['admission_stream']!=71)){
         /*if(($id['academic_year'] =='2022' || $id['academic_year']=='2023')){
			 
			 //echo $id['current_semester'];exit;
		 }else{
			//echo $id['academic_year'];
			 echo "You are not allowed for exam.";exit; 
		 }*/
	
		//$latest_exam= $this->Examination_model->get_student_latest_exam(29,$id['stud_id']);	
		//echo '<pre>';
		//print_r($latest_exam);exit;
		//echo count($latest_exam);exit;
		/*if($this->data['exam_session_val'][0]['exam_id']=32){
			//echo 'inside'; //exit;
		}else{
			$ex_allwed= array();
			if(in_array($stud_prn, $ex_allwed)){
			}else{
				echo "You are not allowed for exam.";exit; 
			}
		}*/
		
		
		
		/****** max credits allowed student list start  ********/
		/*
		$allowed_stud=$this->Examination_model->get_maxcredits_allowed_studntlist();
			foreach($allowed_stud as $std){
			$arr_studid[] = $std['stud_id'];
			}
			
			$this->data['arrstud_id'] = $arr_studid;
		*/
		/****** max credits allowed student list end  ********/	
		//print_r($arr_prn);exit;

		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}
		
		//$id= $this->Examination_model->get_student_id_by_prn($stud_prn);
		
		/******* Detained student condition checking start *********/
		if($id['is_detained']=='Y'){
		$html_detained = $this->load->view($this->view_dir.'load_detained_details',$data,true);
			echo $html_detained;exit;			 
		} 
		
		/*
		if($id['academic_year'] !='2019'){
			$arr_prn[] = $stud_prn;           //this condition is made for backlog students
		}
		*/
		
		/***** Academic fees checking condition start **********/
		
		$ref=0;$other=0;$pending=0;$per_paid=0;$hst_pending=0;
		
		$stud1=$this->Examination_model->get_studentwise_admission_fees($stud_prn,$id['academic_year']);
		//	$caution=$this->Examination_model->get_studentwise_caution_fees($stud_prn,$id['academic_year']);
		
		$apiUrl = "https://facilities.sandipuniversity.com/member-amount/" . $stud_prn;
		$response = file_get_contents($apiUrl);
		$new_caution = json_decode($response, true);

		// ✅ Check response format safely
		/*	if (empty($new_caution) || empty($new_caution['data'])) {
			echo 'No caution money record found.';
			exit;
		} */
			// echo $id['current_year'];exit; 
			
			$this->data['ad_ssn']=$id['admission_session'];
			$this->data['ad_yrr']=$id['current_year'];
			$p_stream = array(); //7, 11, 97, 162 computer branches
			if(in_array($id['admission_stream'],$p_stream)){
				echo "Your exam form is not started yet.";exit; 	 
			}
			/* 
			if($id['admission_session'] == ADMISSION_SESSION){ //2025
				echo "Your exam form is not started yet.";exit; 
			}
			 */
			/*
			if($id['current_year'] == 1){
				echo "Your exam form is not started yet.";exit; 	 
			} 
			*/
		$cautionData = $new_caution['data'];
		// print_r($cautionData);exit;
		/* if (isset($cautionData['is_paid']) && $cautionData['is_paid'] == 0) {
			echo 'Caution money payment pending. Please pay from student login under the <b> Caution Money </b> menu to open the exam form.';
			exit;
		} else {
			// Proceed normally
			// echo 'Caution money is clear.';
		}		*/
		//if($id['stud_id']==7972){
			$host=$this->Examination_model->get_studentwise_hostel_fees($stud_prn);  //fetching hostel fees
			if(!empty($host)){
					if($id['belongs_to'] == 'Package' && $id['package_name'] != 'Reddy'){
						$hst_pending = 0;
					}else{
						$hst_pending = $host[0]['pending_fees'];
					}
			}else{
				$hst_pending = 0;
			}
			//print_r($host);exit;
		//}

		$other=$stud1[0]['opening_balance']+$stud1[0]['cancel_charges'];
		if(in_array($stud_prn, $arr_prn)){ 
			$pending=0;
			$per_paid=100;
			$other=0;
		}else{
			$pending=($stud1[0]['applicable_total']+$other+$stud1[0]['refund'])-$stud1[0]['fees_total'];
			if($other >= 0){
				$fees_app = ($stud1[0]['applicable_total']+$stud1[0]['refund']);//echo"<br>";
				if($stud1[0]['fees_total'] >= $other){
					$fees_paid = $stud1[0]['fees_total']-$other;//echo"<br>";
				}else{
					$fees_paid = 0;
				}
			}else{
				$fees_app = ($stud1[0]['applicable_total']+$stud1[0]['refund']);
				if($stud1[0]['fees_total'] >= $other){
					$fees_paid = $stud1[0]['fees_total']-$other;//echo"<br>";
				}else{
					$fees_paid = 0;
				}
			}
			//  echo $fees_app;exit;
			//$fees_app = ($stud1[0]['applicable_total']+$other+$stud1[0]['refund']);
		   // $fees_paid = $stud1[0]['fees_total'];
			 $per_paid = round(($fees_paid/$fees_app)*100);
			/*if($fees_app==0 && $pending==0){
				$per_paid=100;
			}*/

		}
		if($stud1[0]['fees_total'] == $other && $stud1[0]['fees_total'] == $fees_app){
			$per_paid=100;
		}
		if($fees_app==0 && $pending==0){
				$per_paid=100;
		}
		/***** fetching exam form openeing dates **********/
		$this->data['forms_dates']= $this->Examination_model->get_form_entry_dates($this->data['exam_session_val'][0]['exam_id']);
		if($this->data['exam_session_val'][0]['exam_type']=='Regular'){
			$data['res_status']=array();
				/*if($this->data['exam_session_val'][0]['exam_id']==17){
				$exam_credits= $this->Examination_model->get_june_exam_credits($stud_prn,15);
				//print_r($$exam_credits[0]['sub_credits']);
					if(!empty($exam_credits[0]['sub_credits']) ){
						//echo 'inside';
					$this->data['june_exam_credits']=$exam_credits[0]['sub_credits'];
					}else{
						$this->data['june_exam_credits']=0;
					}
				}*/
		}
		else{
		$data['res_status']= $this->Examination_model->check_stud_result_status($stud_prn,$this->data['exam_session_val'][0]['exam_id']);
		}
			
			
		$wh_arr =array();
		if(in_array($stud_prn, $wh_arr)){
			$data['res_status']=1;
		}
		
		if($id['stud_id']==26919){
		// echo 'host-pending-'.$hst_pending;
		}
		 
		//$hst_pending=0;
		//$per_paid=100;// added only for june-20 session
		$stud_id=$id['stud_id'];
		$semester = $id['current_semester'];
		$stud_stream = $id['admission_stream'];
		
		//if(in_array($stud_id, $reddystudents) state_id){
		if($id['state_id']!=27){ 
			$val=100;
		}else{
			$val=100;
		}
		if($this->data['exam'][0]['exam_type']=='Makeup'){
			$per_paid=100; 
			$hst_pending=0;
		}
		
		if($id['package_name'] == 'Reddy'){ 
			$val=50;
			$hst_pending=0;
		}else{
			$val=70;
		}
		// echo $id['state_id'];exit;
		$states = array(36,33,32,29,28); 
		
		if(in_array($id['state_id'],$states)){
			$val=50;
			$hst_pending=0;	 
		}		
		if($id['nationality'] == 'INTERNATIONAL'){
			$val=0;
			$hst_pending=0;	 
		}
		if($id['current_year'] == 1){
			
			
			if(in_array($id['state_id'],$states)){
				$val=100;
				$hst_pending=100;	 
			}		
			

			// echo $host[0]['fees_paid'];exit;
			if($id['package_name'] == 'Reddy'){ 
			
				if($fees_paid >= 25000  && ($id['course_id'] == '2' || $id['course_id'] == '8')){
					$val=0;
				}elseif($fees_paid >= 15000  && ($id['course_id'] == '9' || $id['course_id'] == '11' || $id['course_id'] == '4')){
					$val=0;		
				}else{
					$val=100;
				}
				
				if($host[0]['fees_paid'] >= 5000 && ($id['course_id'] == '2' || $id['course_id'] == '8')){
					$hst_pending=0;
				}elseif($host[0]['fees_paid'] >= 5000 && ($id['course_id'] == '9' || $id['course_id'] == '11' || $id['course_id'] == '4')){
					$hst_pending=0;				
				}else{
					$hst_pending=100;
				}
			}else{
				$val=100;
				if(!empty($host)){
					if($id['belongs_to'] == 'Package' && $id['package_name'] != 'Reddy'){
						$hst_pending = 0;
					}else{
						$hst_pending = $host[0]['pending_fees'];
					}
				}else{
					
					$hst_pending = 0;
				}
			}
			if($id['nationality'] == 'INTERNATIONAL'){
				$val=0;
				$hst_pending=0;	 
			}
		}
		if(in_array($stud_prn, $ban_user_hostel)){ // || $id['belongs_to']=='Package'
			$hst_pending=0;
		}
		// print_r($stud_prn);exit;
		$this->data['nationality'] = $id['nationality'];
		$this->data['package_name'] = $id['package_name'];
		$this->data['state_id'] = $id['state_id'];
		
		// echo $per_paid;exit;
		if($per_paid < $val ||  !empty($data['res_status']) || in_array($prn, $wh_arr)){
			echo $html = $this->load->view($this->view_dir.'load_studacdemicfees_details',$data,true);
			exit; 
		}
		// echo $hst_pending;exit;
		if($hst_pending > 0 && (!empty($host))){
			echo $html1 = $this->load->view($this->view_dir.'load_studhostelfees_details',$data,true);
			exit; 
		}else{
		 
			
			if($stud_id !=''){
	   
				
				//print_r($this->data['exam']);exit;
				$this->data['bank']= $this->Examination_model->fetch_banks();
				$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
				$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
				if($stud_id==5318){
					//echo 'inside' ;exit;
					//$this->data['exam'][0]['exam_type']='Regular';
				}
				$this->data['examfees']= $this->Examination_model->fetch_examfeesdetails($this->data['emp'][0]['stream_id'], $this->data['exam'][0]['exam_id']);
				if($this->data['exam'][0]['exam_type']=='Regular'){
					/*$exam_not_exist= $this->Examination_model->get_june_exam_credits($stud_prn,16); 
					if(empty($exam_not_exist[0]['sub_credits']) &&  empty($exam_credits[0]['sub_credits'])){
						$this->data['sublist']= $this->Examination_model->getStudAllocatedSubject($stud_id, $semester);
						$batch = $this->data['sublist'][0]['batch'];
						$this->data['semsublist']= $this->Examination_model->getSemesterSubject_edit($semester, $this->data['emp'][0]['stream_id'], $batch);
						
					}*/
					$this->data['sublist']= $this->Examination_model->getStudAllocatedSubject($stud_id, $semester);	// this code is commented for current exam only
					$batch = $this->data['sublist'][0]['batch'];
					$this->data['semsublist']=array();
					//$this->data['semsublist']= $this->Examination_model->getSemesterSubject_edit($semester, $this->data['emp'][0]['stream_id'], $batch);
					//if($stud_id!=13410){
						$this->data['backlogsublist']= $this->Examination_model->getStudbacklogSubject($stud_id,$id['current_semester'],$this->data['emp'][0]['stream_id'],$id['academic_year']);
					//}
					/*if($stud_id=='2926'){
						$this->data['backlogsublist']= $this->Examination_model->getStudAllocatedSubject_for_supplimentry($stud_id, $semester-3);	
					}else{
					$this->data['backlogsublist']= $this->Examination_model->getStudbacklogSubject($stud_id);
					}*/
				}else{
					//echo 'insddfsdf';exit;
					$this->data['sublist']= $this->Examination_model->getExamSubject($stud_id,$stud_stream); //for revalution
					//$this->data['sublist']= $this->Examination_model->getStudbacklogSubject($stud_id,$id['current_semester']);
					if(empty($this->data['sublist'])){
						$stud_prn1_skip=array();
						//if(in_array($stud_prn, $stud_prn1_skip)){
							$this->data['sublist']= $this->Examination_model->getStudAllocatedSubject_for_supplimentry($stud_id, $semester);
						//}					
					}
				}
					
				//}
			if($id['stud_id']==7972){
			//echo 'host-pending1-'.$hst_pending;
			}
				$this->load->view('header',$this->data); 
				$this->load->view($this->view_dir.'view',$this->data);
				$this->load->view('footer');
			}else{
				redirect('home');
			}
		}
        
	}
    
    
    
    
	public function list_allstudents(){
      if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==6){
		}else{
			redirect('home');
		}
		if($_POST){
			$this->load->view('header',$this->data);        
			$college_id = 1;
			$this->data['emp_list']= $this->Examination_model->list_allstudents();
			$this->data['course_details']= $this->Examination_model->getCollegeCourse();
			$this->load->view($this->view_dir.'student_list',$this->data);
			$this->load->view('footer');    
		}
		else{
      
			$this->load->view('header',$this->data);        
    
	
			$college_id = 1;
			$this->data['course_details']= $this->Examination_model->getCollegeCourse();
			$this->load->view($this->view_dir.'student_list',$this->data);
			$this->load->view('footer');
      
		}
 
        
	}
    
    
    
    
	public function course_streams(){
		global $model;	    
		$this->data['campus_details']= $this->Examination_model->course_streams($_POST);     	    
	}
    
    
    
    public function add_exam_form(){  
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam_details =  explode('~',$this->input->post('exam_details'));
		$fee_date = str_replace('/', '-', $_POST['dddate']);
		$studid=$this->input->post('student_id');
		$enrollment_no=$this->input->post('enrollment_no');
		if($studid==13545){
		//echo '<pre>';print_r($_POST);exit;  
		$applicable_fee = $this->input->post('applicable_fee');
		//echo $applicable_fee =  base64_decode($this->input->post('examapplicable'));exit;
		}
		$applicable_fee =  base64_decode($this->input->post('examaname'));
		$marathiname=$this->input->post('marathi_name');
		$abc_no=$this->input->post('abc_no');
		
		$stdwhere = "stud_id='$studid'";
		$DB1->where($stdwhere);
		$stddata['marathi_name']=$marathiname;	
		if(!empty($abc_no)){			
			/* $chk_duplicate_abc_no = $this->Examination_model->chk_duplicate_abc_no($studid,$abc_no);
			//echo count($chk_duplicate_abc_no);//exit;
			if(count($chk_duplicate_abc_no) <=0){
				
			}else{
				echo "Duplicate ABC no. please enter correct no."; echo '<a href="https://erp.sandipuniversity.com/home"><button class="btn">Home</button></a>';exit;
			} */
			$stddata['abc_no']=$abc_no;
		}
		if($marathiname !=''){
			$DB1->update("student_master", $stddata); 
			//echo $DB1->last_query();exit;
		}
		//exit;
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
		
		$fees_paid_status = 'N';
		if($exam_details[3]=='Regular'){
			$is_regular_makeup = 'R';
		}else{
			$is_regular_makeup = 'M';
		}
		$forms_dates= $this->Examination_model->get_form_entry_dates($exam_details[0]);
		$check_student_admission_yr = $this->Examination_model->get_student_admission_yr($enrollment_no);
		
		$admission_session = $check_student_admission_yr['admission_session'];
		$admission_year = $check_student_admission_yr['admission_year'];
		$nationality = $check_student_admission_yr['nationality'];
		$package_name = $check_student_admission_yr['package_name'];
		$state_id = $check_student_admission_yr['state_id'];
		if(!empty($forms_dates)){
			// print_r($forms_dates);exit; // 7, 11, 97, 162
			$crr_date=date('Y-m-d');	
			$late_fees_date=date("Y-m-d", strtotime($forms_dates[0]['frm_latefee_date']));
			$form_end_date=date("Y-m-d", strtotime($forms_dates[0]['frm_end_date']));
			$superlate_fine_date=date("Y-m-d", strtotime($forms_dates[0]['superlate_fine_date']));
			$phase_two_form_end_date = '2025-12-05';
			$package_form_end_date = '2025-11-03';
			$phase_three_form_end_date = '2025-12-05';
			$phase_three_late_fees_date = '2025-12-06';
			$phase_three_superlate_fine_date = '2025-12-10';
			$p_stream = array(7, 11, 97, 162); // computer branches
			$states = array(36,33,32,29,28); 
			if(in_array($state_id,$states)){
				$form_end_date = $package_form_end_date;
				$late_fees_date = $package_form_end_date;
			}	
			 
			 if($nationality == 'INTERNATIONAL' || $package_name == 'Reddy'){
				$form_end_date = $package_form_end_date;
				$late_fees_date = $package_form_end_date;
			}
			if((in_array($this->input->post('stream_id'),$p_stream) && $this->input->post('semester') == 3) || ($admission_year == 2 && $admission_session == 2025)){
					$form_end_date = $phase_two_form_end_date;
					$late_fees_date = '2025-12-06';
					$superlate_fine_date = '2025-12-10';
			}
			
			if($this->input->post('semester') == 1 || ($admission_year == 1 && $admission_session == 2025)){
				$form_end_date = $phase_three_form_end_date;
				$late_fees_date = $phase_three_late_fees_date;
				$superlate_fine_date = $phase_three_superlate_fine_date;
			}
			
			// echo $form_end_date;exit;
			if($crr_date >= $late_fees_date && $crr_date > $form_end_date && $crr_date < $superlate_fine_date){
				$diff = strtotime($crr_date) - strtotime($late_fees_date);
				$no_of_days =abs(round($diff / 86400)); 
				$late_fees=200 * $no_of_days;//100
				// echo 'hii';exit;
			}elseif($crr_date >= $superlate_fine_date){
				$late_fees = 3000;	//20000		 
				// $late_fees = 0;				
			}else{
				$late_fees=0; // echo "Last Date to be apply is over";exit;
			}

		}
		$allowed_prn=$this->Examination_model->get_exam_allowed_studntlist($exam_details[0],$enrollment_no);
		$for_no_fine=array(230105132171);
		foreach($allowed_prn as $pr) {
			if($pr['for_no_fine'] == 'Y') {
				$for_no_fine[] = $pr['enrollment_no'];
			}
		}
		if(in_array($enrollment_no,$for_no_fine)){
			$late_fees=0;
		}
		
		// echo $late_fees;exit;
		$exam_ses =$exam_details[1].''.$exam_details[2];	
		$cnt_bklg = count($this->input->post('sub'));
		$course_type = $this->input->post('course_type');
		
		$course_pattern = $this->input->post('course_pattern');
		$course_duration = $this->input->post('course_duration');
		$semester = $this->input->post('semester');
		$current_academic_year = $this->input->post('current_academic_year');
		
		if($course_type=='UG' || $course_type=='DIPLOMA'){
			$dpay=400*$cnt_bklg;
		}elseif($course_type=='PG'){
			$dpay=600*$cnt_bklg;
		}else{
			$dpay=0;
		}
		if($exam_details[3]=='Regular'){
			if($course_pattern=='SEMESTER'){
				$last_semester = $course_duration *2;
			}else{
				$last_semester = $course_duration;
			}
			if($semester==$last_semester && $current_academic_year==C_RE_REG_YEAR){
				// $degree_fees='3000';//1500
				$degree_fees= 0;
			}else{
				// $degree_fees='3000';
				$degree_fees= 0;
				
			}
		}else{
			$degree_fees='0';
		}
		$total_exam_fees =$dpay+ $late_fees+$degree_fees;
		// if($studid==12405){
		//	$total_exam_fees =1;
		// }
		// echo $total_exam_fees;exit;
		
		$insert_exam_details =array(
			"stud_id"=>$this->input->post('student_id'),
			"enrollment_no"=>$this->input->post('enrollment_no'),
			"stream_id"=>$this->input->post('stream_id'),
			"course_id"=>$this->input->post('course_id'),
			"semester"=>$this->input->post('semester'),
			"school_code"=>$this->input->post('school_code'),
			"exam_fees"=>$total_exam_fees,
			"degree_convocation_fees"=>$degree_fees,
			"late_fees"=>$this->input->post('late_fees'),
			"exam_id" => $exam_details[0],
			"exam_month" => $exam_details[1],
			"exam_year" => $exam_details[2],
			"is_regular_makeup" => $is_regular_makeup,
			"entry_by" => $this->session->userdata("uid"),
			"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
			"entry_on" => date("Y-m-d H:i:s"),
			"allow_for_exam" => 'Y',
			"is_active" => 'Y',
		); 	

			//"exam_fees_paid" => $fees_paid_status,			"exam_fees_paid" => $fees_paid_status,
         
		$studprn = base64_encode($_POST['enrollment_no']);
		$chk_duplicate = $this->Examination_model->chk_duplicate_exam_form($insert_exam_details);
		if(count($chk_duplicate) <=0){

            include_once "phpqrcode/qrlib.php";
			$tempDir = 'uploads/exam/'.$exam_ses.'/QRCode/';
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0755, true);
			}
			$site_url="https://erp.sandipuniversity.com/";
			$codeContents = $site_url.'check.php?po='.$_POST['enrollment_no'];
			$fileName = 'qrcode_'.$_POST['enrollment_no'].'.png';		
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
			
		if($total_exam_fees <=0){
			
			 /*  if($_POST['enrollment_no'] =='200105132004'){
			 echo '<pre>';
			 print_r($insert_exam_details);
			 exit;
		 }  */
            //echo 1;
			//exit;	
			//$path = 'examination/index/'.$studprn;
			//echo json_encode(array('amount'=>'','path'=>$path));
			//exit;
			// Assuming $get_exam_detail_data[0] is already available
			$exam_id = $exam_details[0];

			// ✅ Fetch last form number for this exam_id
			$lastForm = $DB1->select('exam_form_no')
							->from('exam_details')
							->where('exam_id', $exam_id)
							->order_by('exam_master_id', 'DESC')   // use PK for latest
							->limit(1)
							->get()
							// echo $DB1->last_query();exit;
							 ->row_array();

			if ($lastForm && !empty($lastForm['exam_form_no'])) {
				// Extract numeric part after exam_id prefix
				$lastNumber = (int)substr($lastForm['exam_form_no'], strlen($exam_id));
				$newNumber  = $lastNumber + 1;
			} else {
				$newNumber = 1; // first form
			}

			// ✅ Generate new exam_form_no (exam_id + padded number)
			$exam_form_no = $exam_id . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
			$insert_exam_details['exam_form_no'] = $exam_form_no;

			
		$DB1->insert("exam_details", $insert_exam_details); 
		$insert_exam_subjects['allow_for_exam']='Y';
		$exam_master_id=$DB1->insert_id(); 
		//echo $DB1->last_query();exit;
		if($exam_master_id !=''){
			$insert_exam_subjects['exam_master_id'] = $exam_master_id;
			if($exam_details[3]=='Regular'){
				$subjects1 = $this->input->post('sub1');
				$subjects = $this->input->post('sub');
				if(!empty($subjects)){
					if(!empty($subjects1)){
						$allsubjects = array_merge($subjects1, $subjects);
					}else{
						$allsubjects = $subjects;
					}					
				}else{
					$allsubjects = $subjects1;
				}
				foreach($allsubjects as $sub){
					$sub = explode('~', $sub);
					$insert_exam_subjects['subject_id']=$sub[0];
					$insert_exam_subjects['subject_code']= $sub[1];
					$insert_exam_subjects['semester']= $sub[2];
					$insert_exam_subjects['sub_credits']= $sub[3];
					$insert_exam_subjects['is_backlog']= $sub[4];
					$DB1->insert("exam_applied_subjects", $insert_exam_subjects);
				}
				
			}else{
				$subjects = $this->input->post('sub');
				foreach($subjects as $sub){
					$sub = explode('~', $sub);
					$insert_exam_subjects['subject_id']=$sub[0];
					$insert_exam_subjects['subject_code']= $sub[1];
					$insert_exam_subjects['semester']= $sub[2];
					$insert_exam_subjects['sub_credits']= $sub[3];
					$insert_exam_subjects['is_backlog']= $sub[4];
					$DB1->insert("exam_applied_subjects", $insert_exam_subjects);
				}
			}

			
			if($total_exam_fees <=0){
				//redirect('examination/view_form/'.$studprn);
				$path = 'examination/view_form/'.$studprn;
				echo json_encode(array('amount'=>'','path'=>$path));
			}else{
				 $path = 'online_fee/pay_fees/Examination';
				//redirect('online_fee/pay_fees/Examination');
                echo json_encode(array('amount'=>'','path'=>$path));				
			}
			//$path = 'examination/view_form/'.$studprn;
            //echo json_encode(array('amount'=>'','path'=>$path));			
			//redirect('examination/view_form/'.$studprn); 
			}
		 }else{
			 
			
			$txnid=date('ymdhis')."-".$_POST['stud_id'];
			$insert_exam_details['txnid'] = $txnid;
			$DB1->insert("exam_details_transaction", $insert_exam_details); 
		    $insert_exam_subjects['allow_for_exam']='Y';
		    $exam_master_id=$DB1->insert_id(); 
			if($exam_master_id !=''){
			$insert_exam_subjects['exam_master_id'] = $exam_master_id;
			$insert_exam_subjects['txnid'] = $txnid;
			if($exam_details[3]=='Regular'){
				//echo 111;exit;
				$subjects1 = $this->input->post('sub1');
				$subjects = $this->input->post('sub');
				if(!empty($subjects)){
					if(!empty($subjects1)){
						$allsubjects = array_merge($subjects1, $subjects);
					}else{
						$allsubjects = $subjects;
					}					
				}else{
					$allsubjects = $subjects1;
				}
				foreach($allsubjects as $sub){
					$sub = explode('~', $sub);
					$insert_exam_subjects['subject_id']=$sub[0];
					$insert_exam_subjects['subject_code']= $sub[1];
					$insert_exam_subjects['semester']= $sub[2];
					$insert_exam_subjects['sub_credits']= $sub[3];
					$insert_exam_subjects['is_backlog']= $sub[4];
					/*  if($this->input->post('enrollment_no') =='220110022003'){
						
						print_r($insert_exam_subjects);exit;
					}  */
					$DB1->insert("exam_applied_subjects_transaction", $insert_exam_subjects);
					//echo $DB1->last_query();exit;
				}
				
			}else{
				//echo 121;exit;
				$subjects = $this->input->post('sub');
				foreach($subjects as $sub){
					$sub = explode('~', $sub);
					//print_r($sub[4]);
					$insert_exam_subjects['subject_id']=$sub[0];
					$insert_exam_subjects['subject_code']= $sub[1];
					$insert_exam_subjects['semester']= $sub[2];
					$insert_exam_subjects['sub_credits']= $sub[3];
					$insert_exam_subjects['is_backlog']= $sub[4];
					/* if($this->input->post('enrollment_no') == '220110022003'){
					print_r($insert_exam_subjects);exit;	
						
					} */
					$DB1->insert("exam_applied_subjects_transaction", $insert_exam_subjects);
					//echo $DB1->last_query();exit;
				}
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
						   //print_r($_POST);
						  // exit;
						  
						   
						   
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
						   
						   if($this->input->post('enrollment_no') == '170101051045'){
							   $posted['amount'] = $total_exam_fees;
						   }else{
			               $posted['amount'] = $total_exam_fees;
						   }
			               //$posted['amount'] = 1;
						   
						   $posted['udf1']=$recepit;//receipt_no
						  // $posted['udf2']=$posted['udf2'];//Academic Year
						   $posted['udf3']=$posted['udf3'];//enrollment_no
						   $posted['udf4']=$posted['mobile'];//mobile
						   $posted['udf5']=$posted['stud_id'];//user_type 
						   $posted['address1']=$posted['degree_convocation_fees'];//user_type 
						   
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
								//echo $hash;
								//exit();
								//////////////////////////////////////////////////////////////
								
								echo json_encode(array('txnid'=>$txnid,'hash'=>$hash,'amount'=>$posted['amount'],'udf1'=>$recepit,'udf3'=>$posted['udf3'],'udf4'=>$posted['mobile'],'udf5'=>$posted['stud_id'],'address1'=>$posted['degree_convocation_fees']));
								//return array('txnid'=>$txnid,'hash'=>$hash);
								//echo $hash;
			
			
		}
			
			
		} 
	}
		
		
		else{
			 $path = 'examination/view_form/'.$studprn;
            
			 echo json_encode(array('amount'=>'','path'=>$path));
		}
		

	} 
	
	
	

	public function edit_exam_form($student_prn){  
		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}
		
		$id= $this->Examination_model->get_student_id_by_prn($stud_prn);
		$stud_id=$id['stud_id'];
		$current_semester =$id['current_semester'];
		$stream =$id['admission_stream'];
		$ex_session = $this->Examination_model->fetch_stud_curr_exam();
		$this->data['forms_dates']= $this->Examination_model->get_form_entry_dates($ex_session[0]['exam_id']);

		$this->data['ex_session'] = $ex_session;
		if($stud_id!=''){
			$this->data['exam']= $this->Examination_model->fetch_stud_exam_details($stud_id);
			$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Examination_model->fetch_banks();
			$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
			$this->data['sublist']= $this->Examination_model->getExamAllocatedSubject_edit($stud_id);

			if($ex_session[0]['exam_type']=='Regular'){
				$this->data['backlogsublist']= $this->Examination_model->getStudbacklogSubjectedit($stud_id);
				$regulation = $this->data['sublist'][0]['batch'];
				$this->data['semsublist']= $this->Examination_model->getSemesterSubject_edit($current_semester, $stream, $regulation);
			}else{
				$this->data['allbklist']= $this->Examination_model->getExamSubject($stud_id,$stream);
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
		
		$id= $this->Examination_model->get_student_id_by_prn($stud_prn);
		$stud_id=$id['stud_id'];
		$current_semester =$id['current_semester'];
		$stream =$id['admission_stream'];
		$ex_session = $this->Examination_model->fetch_stud_curr_exam();
		$this->data['forms_dates']= $this->Examination_model->get_form_entry_dates($ex_session[0]['exam_id']);

		$this->data['ex_session'] = $ex_session;
		if($stud_id!=''){
			$this->data['exam']= $this->Examination_model->fetch_stud_exam_details($stud_id);
			$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Examination_model->fetch_banks();
			$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
			$this->data['sublist']= $this->Examination_model->getExamAllocatedSubject_edit($stud_id);

			if($ex_session[0]['exam_type']=='Regular'){
				$this->data['backlogsublist']= $this->Examination_model->getStudbacklogSubjectedit($stud_id);
				$regulation = $this->data['sublist'][0]['batch'];
				$this->data['semsublist']= $this->Examination_model->getSemesterSubject_edit($current_semester, $stream, $regulation);
			}else{
				$this->data['allbklist']= $this->Examination_model->getExamSubject($stud_id,$stream);
				//print_r($this->data['allbkist']);
			}
			
		}
		$this->load->view('header',$this->data); 
		$this->load->view($this->view_dir.'edit_student',$this->data);
		$this->load->view('footer');
        
	}	
	// view exam form
	public function view_form($student_prn){  

		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}
		
		$id= $this->Examination_model->get_student_id_by_prn($stud_prn);
		$stud_id=$id['stud_id'];
		//print_r($stud_id);exit;
		if($stud_id!=''){
			$this->data['exam']= $this->Examination_model->fetch_stud_curr_exam();
			$this->data['examdetails']= $this->Examination_model->fetch_stud_exam_details($stud_id);
			$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Examination_model->fetch_banks();
			$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
			//print_r($this->data['emp']);exit;
			//if($this->data['exam'][0]['exam_type']=='Regular'){
				$this->data['sublist']= $this->Examination_model->getExamAllocatedSubject($stud_id);	
			//}
			//$this->data['sublist']= $this->Examination_model->getExamAllocatedSubject($stud_id);
			
		}
		//print_r($this->data['emp']);exit;
		$this->load->view('header',$this->data); 
		$this->load->view($this->view_dir.'view_form',$this->data);
		$this->load->view('footer');
        
	}
	//search_exam_form
	public function search_exam_form(){
		if($this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==4 
		|| $this->session->userdata("role_id")==64 || $this->session->userdata("role_id")==65 || $this->session->userdata("role_id")==66 
		|| $this->session->userdata("role_id")==69 
		|| $this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
		$role_id = $this->session->userdata('role_id');
		/*if($role_id==4){
			echo "Last Date to be apply 25th SEPT 2020 till 5:00 PM.";exit; 
		}else{*/
		$this->load->view('header',$this->data);
		$this->data['exam']= $this->Examination_model->fetch_stud_curr_exam();
		$this->load->view($this->view_dir.'search',$this->data);
		$this->load->view('footer');
		//}
	}
	public function search_allow_for_exam(){
		if($this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
		$role_id = $this->session->userdata('role_id');
		/*if($role_id==4){
			echo "Last Date to be apply 25th SEPT 2020 till 5:00 PM.";exit; 
		}else{*/
		$this->load->view('header',$this->data); 
		$this->data['exam']= $this->Examination_model->fetch_stud_curr_exam();
		$this->load->view($this->view_dir.'search_allow_for_exam',$this->data);
		$this->load->view('footer');
		//}
	}
		public function search_malpractice(){
		if($this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data); 
		$this->load->model('Marks_model');
	    //$this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
		$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		$this->load->view($this->view_dir.'search_malpractice',$this->data);
		$this->load->view('footer');
	}

	public function get_malpractice_list_data()
	{
		if(!empty($_POST['exam_session']) && ($_POST['school_code']!='')){

		    $exam_session = $_POST['exam_session'];
		    $schoolid=$_POST['school_code'];
		    $exam = explode('-', $exam_session);
		    $exam_month =$exam[0];
		    $exam_year =$exam[1];
			$exam_id =$exam[2];
			 $this->data['schoolid']=$schoolid;
			 $this->data['exam_session']=$exam_session;
		    $this->data['malpractice_list']= $this->Examination_model->get_malpractice_list_of_student($exam_month,$exam_year, $exam_id,$_POST['school_code']);
		   
	    	$html = $this->load->view($this->view_dir.'ajax_mal_data',$this->data,true);
			echo $html;

	    }
	}

	public function genrate_malpractice_forstudents()
	{
		
			$exam_session = $_POST['exam_se'];
		    $exam = explode('-', $exam_session);
		    $exam_month =$exam[0];
		    $exam_year =$exam[1];
			$exam_id =$exam[2];
			$this->data['exam_year']=$exam_year;
	    	$this->data['exam_month']= $exam_month;
 			$this->load->library('m_pdf', $param);
  			$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '20', '10', '10', '10', '10', '10');
            foreach($_POST['chk_stud'] as $resu)
            {
                $studentid_list[]=$resu;
            }

             $studentid_lis=implode(',',$studentid_list);
            
            
			
	   		$this->data['malpractice_listkk']= $this->Examination_model->get_malpractice_no($exam_month,$exam_year, $exam_id,$_POST['schoolid'],$_POST['chk_stud'],$_POST['blockaddress']);
	   		
	   		 
	   		//$malpractice_list= $this->Examination_model->pdfforStudent_for_malpractice($exam_month,$exam_year, $exam_id,$_POST['schoolid'],$studentid_lis);
	   		//  $stud$_POST['chk_stud'];
	   		
                             foreach($studentid_list as $key=>$value){

				 				$prn=$value;
    							$this->data['malpractice_list']= $this->Examination_model->pdfforStudent_for_malpractice($exam_month,$exam_year, $exam_id,$_POST['schoolid'],$value);
			
			//print_r($malpractice_list);
			//exit();
			
	        $html = $this->load->view($this->view_dir.'malpdf_student', $this->data, true);
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
			$pdfFilePath1 =$prn."_malpractice_report.pdf";
			//$this->m_pdf->pdf->Output($pdfFilePath1, "F");
			 $this->m_pdf->pdf->Output($pdfFilePath1, "D");
			//}

	   
	   
/*
	    $this->load->library('m_pdf', $param);
	    $this->m_pdf->pdf=new mPDF('utf-8', 'A4', '20', '10', '10', '10', '10', '10');
	    $this->data['exam_month']=$exam_month ;
	      $this->data['exam_year']=$exam_year ;
	      $this->data['comment']=$_POST['comment'];
	    //$html = $this->load->view($this->view_dir.'malpdf_student', $this->data, true);
	    $pdfFilePath = $_POST['prn']."-malpractice_report.pdf";
	    
	    $this->m_pdf->pdf->WriteHTML($html);
	    //download it.
	    $this->m_pdf->pdf->Output($pdfFilePath, "D");
*/
	}
	 
	function search_studentdata(){
		
		$_POST['academic_year'] = '2021';		
		// checking fees
		$prn = $_POST['prn'];
		$this->data['exam_session_val']= $this->Examination_model->fetch_stud_curr_exam();
		
		$allowed_prn=$this->Examination_model->get_exam_allowed_studntlist($this->data['exam_session_val'][0]['exam_id'],$prn);
		foreach($allowed_prn as $pr){
			$arr_prn[] = $pr['enrollment_no'];
		}
		$arr_prn = array();
		$wh_arr =array();
		$ref=0;$other=0;$pending=0;$per_paid=0;
		
		$this->data['forms_dates']= $this->Examination_model->get_form_entry_dates($this->data['exam_session_val'][0]['exam_id']);

		$id= $this->Examination_model->get_student_id_by_prn($prn);
		/*if($id['academic_year'] !='2019'){ // for backlog students
			$arr_prn = array($prn);
		}*/
		
		if($id['admission_session']==2023){
			$val=70;
		}else{
			$val=70;
		}
		$states = array(36,33,32,29,28); 
		if(in_array($id['state_id'],$states)){
			$val=50;
			$hst_pending=0;	 
		}	
		
		
		$stud1=$this->Examination_model->get_studentwise_admission_fees($prn,$id['academic_year']);
		
		$other=$stud1[0]['opening_balance']+$stud1[0]['cancel_charges'];
		if(in_array($prn, $arr_prn)){
			$pending=0;
			$per_paid=100;  
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
			if($fees_app==0 && $pending==0){
				$per_paid=100;
			}
			if($this->session->userdata("uid")==5660 || $this->session->userdata("uid")==2982){
				//echo $fees_app = ($stud1[0]['applicable_total']+$stud1[0]['refund']);echo"<br>";
				//echo $fees_paid = $stud1[0]['fees_total']-($other);echo"<br>";
				echo 'fees_condition_required-'.$val;echo"<br>";
				echo 'applicable_total-'.$stud1[0]['applicable_total'];echo"<br>"; echo 'Other-'.$other;echo"<br>";
				echo '%-'.$per_paid; echo"<br>";
				echo 'fees_paid-'.$fees_paid;echo"<br>";
				echo 'fees_app-'.$fees_app;echo"<br>";
				echo 'fees_pending-'.$pending;
			}
		}
		
		//if($prn=='180101051083'){
			
			if($this->data['exam_session_val'][0]['exam_type']=='Regular'){
			$data['res_status']=array();
			}
			else{
			$data['res_status']= $this->Examination_model->check_stud_result_status($prn,$this->data['exam_session_val'][0]['exam_id']);
			}
		//}
		if(in_array($prn, $wh_arr)){
			$data['res_status']=1;
		}
		  //$per_paid =100; 
		//$per_paid=60;// added only for june-20 session
		$per_paid =100; 
		
		
		if($per_paid < $val  ||  !empty($data['res_status']) || in_array($prn, $wh_arr)){
			$html = $this->load->view($this->view_dir.'load_studacdemicfees_details',$data);
		
			
		}else{
			$emp_list= $this->Examination_model->searchStudentsajax($_POST);
			if(!empty($emp_list)){
				$data['emp_list']= $emp_list;
				$data['emp_list'][0]['exam_details']= $this->Examination_model->studentExamDetails($_POST);
			}else{
				$emp_list1= $this->Examination_model->searchCheckStudentbyprn($_POST);
				$data['emp_list']= $emp_list1;
			}
			$data['fees']= $this->Examination_model->fetch_fees($_POST);
			$data['online_fees']= $this->Examination_model->fetch_onlinefees($_POST);
			$data['exam']= $this->Examination_model->fetch_stud_curr_exam();
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
			$this->data['exam']= $this->Examination_model->fetch_exam_session_byid($exam_id);
			$exam_month =$this->data['exam'][0]['exam_month'];
			$exam_year =$this->data['exam'][0]['exam_year'];
			$this->data['examdetails']= $this->Examination_model->fetch_stud_exam_details($stud_id,$exam_id);
			//print_r($this->data['examdetails']);exit;
			$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Examination_model->fetch_banks();
			$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
			$semester = $this->data['emp'][0]['current_semester'];
			$this->data['sublist']= $this->Examination_model->getCurrentExamAllocatedSubject($stud_id, $semester,$exam_id);	
			if($this->data['exam'][0]['exam_year'] =='Regular'){
				$this->data['backlogsublist']= $this->Examination_model->getStudbacklogSubject($stud_id='');
			}
			
			$this->data['examfees']= $this->Examination_model->fetch_examfeesdetails($this->data['emp'][0]['stream_id'], $this->data['exam'][0]['exam_id']);
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
		$DB3 = $this->load->database('erpdel', TRUE);
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
		//$this->Examination_model->delete_subjects($insert_exam_subjects); // delete all student subject
		$prev_sub = $this->Examination_model->fetch_prev_subjects($insert_exam_subjects); // fetch previous all student subject
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
				$DB1->insert("exam_applied_subjects", $insert_exam_subjects);
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
				$sql="DELETE FROM `exam_applied_subjects` where subject_id ='$subject_id' and stud_id ='$stud_id' and stream_id ='$stream_id' and exam_id ='$exam_details[0]'";
				$DB3->query($sql);
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
		redirect('examination/view_form/'.$studprn);

	} 
	// delete exam_form
	public function delete_exam_form($prn,$exam_id){
		$DB1 = $this->load->database('erpdel', TRUE);
		$sql1="DELETE FROM `exam_details` where enrollment_no ='$prn' and exam_id ='$exam_id'";//exit;
		$DB1->query($sql1);
		$sql2="DELETE FROM `exam_applied_subjects` where enrollment_no ='$prn' and exam_id ='$exam_id'";
		$DB1->query($sql2);
		redirect('examination/search_exam_form/'.$prn);
	}
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
		redirect('examination/view_form/'.$studprn);

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
			
			$this->data['emp_list']= $this->Examination_model->list_exam_appliedStudents($exam_id);
			$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
			for($i=0;$i<count($this->data['emp_list']);$i++){
				$student_id =$this->data['emp_list'][$i]['stud_id'];
				
				$exam_month =$exam[0];
				
				$this->data['emp_list'][$i]['fees']=$this->Examination_model->getFeedetails($student_id,$exam_id); // exam fees
			 
				$this->data['emp_list'][$i]['applicable_fee']=$this->Examination_model->fetch_admissionApplicable_fees($student_id,$_POST['admission-branch'], $exam_year); // applicable_fee
				$this->data['emp_list'][$i]['tot_fees_paid']=$this->Examination_model->get_tot_fee_paid($student_id, $exam_year); // tot fees
				//$this->data['emp_list'][$i]['subdetails']= $this->Examination_model->get_subject_details($student_id,$stream_id,$semester);
				//$this->data['emp_list'][$i]['isPresent']=$this->Examination_model->getExamformStatus($student_id,$exam_month,$exam_year);
	
			} 
		
			$this->data['course_details']= $this->Examination_model->getCollegeCourse();
			$this->data['schools']= $this->Examination_model->getSchools();
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
			$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
			//$this->data['course_details']= $this->Examination_model->getCollegeCourse();
			//$this->data['schools']= $this->Examination_model->getSchools();
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
	function load_schools(){

		if($_POST["school_code"] !=''){
			//print_r($_POST);exit;
			//Get all city data
			$stream = $this->Examination_model->get_courses($_POST["school_code"], $_POST["exam_session"]);
            
			//Count total number of rows
			echo $rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				echo '<option value="0">All Course</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
			/*} else{
				echo '<option value="">Course not available</option>';
			}*/
		}
	}
	function load_schools_tts(){

		if($_POST["school_code"] !=''){
			//print_r($_POST);exit;
			//Get all city data
			$stream = $this->Examination_model->get_courses_tts($_POST["school_code"], $_POST["exam_session"]);
            
			//Count total number of rows
			echo $rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				echo '<option value="0">All Course</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
			/*} else{
				echo '<option value="">Course not available</option>';
			}*/
		}
	}
	
	function load_schools_for_results(){

		if($_POST["school_code"] !=''){
			
			//Get all city data
			$stream = $this->Examination_model->get_courses_results($_POST["school_code"]);
            
			//Count total number of rows
			echo $rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				echo '<option value="0">All Course</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
			/*} else{
				echo '<option value="">Course not available</option>';
			}*/
		}
	}
	function load_schools_tt(){

		if($_POST["school_code"] !=''){
			
			//Get all city data
			$stream = $this->Examination_model->get_courses_timetable($_POST["school_code"]);
            
			//Count total number of rows
			echo $rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Course</option>';
				echo '<option value="0">All Course</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['course_id'] . '">' . $value['course_short_name'] . '</option>';
				}
			/*} else{
				echo '<option value="">Course not available</option>';
			}*/
		}
	}	
	function load_examsess_schools(){
		if(isset($_POST["exam_session"]) && !empty($_POST["exam_session"])){
			//Get all city data
			$stream = $this->Examination_model->getSchoolsByCenter($_POST["exam_session"]);
           // print_r($stream);exit;
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select School</option>';
				echo '<option value="All">All</option>';
				foreach($stream as $value){
					if(isset($_POST['school_code']) && ($_POST['school_code']==$value['school_code']))
					{
						 $sel = "selected";
					}
					else
					{
						$sel ='';
					}
					/*if($this->session->userdata('name')=='exam_ecr1' && ($value['school_code']=='1001' || $value['school_code']=='1006')){
						echo '<option value="' . $value['school_code'] . '" '.$sel.'>' . $value['school_short_name'] . '</option>';
					}else if($this->session->userdata('name')=='exam_ecr2' && ($value['school_code']!='1001' && $value['school_code']!='1006')){
						echo '<option value="' . $value['school_code'] . '" '.$sel.'>' . $value['school_short_name'] . '</option>';
					}else if($this->session->userdata('name')=='su_coe' || $this->session->userdata('name')=='suerp'){
						echo '<option value="' . $value['school_code'] . '" '.$sel.'>' . $value['school_short_name'] . '</option>';
					}*/
					echo '<option value="' . $value['school_code'] . '" '.$sel.'>' . $value['school_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">School not available</option>';
			}
		}
	}
	
	function load_examsess_schools_new(){
		if(isset($_POST["exam_session"]) && !empty($_POST["exam_session"])){
			//Get all city data
			$stream = $this->Examination_model->load_examsess_schools_new($_POST["exam_session"]);
            $role_id = $this->session->userdata('role_id');
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select School</option>';
				if($role_id !=49){
				echo '<option value="All">All</option>';
				}
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
	function load_examsess_schools_exceptall(){
		if(isset($_POST["exam_session"]) && !empty($_POST["exam_session"])){
			//Get all city data
			$stream = $this->Examination_model->load_examsess_schools($_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select School</option>';
			
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
			$stream = $this->Examination_model->getSchoolsByCenter($_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select School</option>';
				echo '<option value="0">All School</option>';
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
			$stream = $this->Examination_model->load_exam_dates($_POST["exam_session"]);
            
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
			$stream = $this->Examination_model->get_examcourses($_POST["school_code"], $_POST["exam_session"]);
            
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
	
	
	function load_examschools_new(){
		if(isset($_POST["school_code"]) && !empty($_POST["school_code"])){
			//Get all city data
			$stream = $this->Examination_model->get_examcourses_new($_POST["school_code"], $_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Course</option><option value="0">All Course</option>';
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
			$stream = $this->Examination_model->get_streams($_POST["course_id"],$_POST["school_code"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
				echo '<option value="0">All Stream</option>';
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
	function load_streams_for_arrears(){
		//echo $_POST["course_id"];exit;
		if($_POST["course_id"] !=''){
			//Get all streams
			$stream = $this->Examination_model->get_streams_for_arrears($_POST["course_id"],$_POST["school_code"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
				echo '<option value="0">All Stream</option>';
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
	function load_streams_for_result(){
		//echo $_POST["course_id"];exit;
		if($_POST["course_id"] !=''){
			//Get all streams
			$stream = $this->Examination_model->get_streams_for_result($_POST["course_id"],$_POST["school_code"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
				echo '<option value="0">All Stream</option>';
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
	function load_streams_tt(){
		//echo $_POST["course_id"];exit;
		if($_POST["course_id"] !=''){
			//Get all streams
			$stream = $this->Examination_model->get_streams_timetable($_POST["course_id"],$_POST["school_code"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			//if($rowCount > 0){
				echo '<option value="">Select Stream</option>';
				echo '<option value="0">All Stream</option>';
				if($_POST["course_id"]==2){
					echo '<option value="9" >B.Tech First Year</option>';
				}
				/*if($_POST["course_id"]==5){
					echo '<option value="234" >MBA First Year</option>';
				}*/
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
			$stream = $this->Examination_model->get_examstreamsBySchool($_POST["course_id"], $_POST["exam_session"]);
            
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
			$stream = $this->Examination_model->get_examsemester($_POST["stream_id"], $_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Semester</option>';
				echo '<option value="0">All Semester</option>';
				foreach($stream as $value){
					echo '<option value="' . $value['semester'] . '">' . $value['semester'] . '</option>';
				}
			} else{
				echo '<option value="">Semester not available</option>';
			}
		}
	}
	function load_examsemesters_for_result(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			//echo $_POST["exam_session"];
			$stream = $this->Examination_model->get_examsemester_for_result($_POST["stream_id"], $_POST["exam_session"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select Semester</option>';
				echo '<option value="0">All Semester</option>';
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
	function hall_ticket($student_id){
		//load mPDF library
		//echo $student_id;
		ini_set("memory_limit", "-1");
		$this->load->library('m_pdf');
		$this->load->model('Ums_admission_model');
		$stud_id = base64_decode($student_id);
		$exam= $this->Examination_model->fetch_stud_curr_exam();
		$this->data['exam']=$exam;
		$exam_month =$exam[0]['exam_month'];
		$exam_year =$exam[0]['exam_year'];
		$exam_id =$exam[0]['exam_id'];
		$this->data['emp_per']= $this->Examination_model->fetch_personal_details($stud_id);
		$admission_school =$this->data['emp_per'][0]['admission_school'];
		$this->data['ex_center']= $this->Examination_model->fetch_exam_center_details($admission_school,$exam_id);
		$this->data['sublist']= $this->Examination_model->getSubjectTimetable($stud_id, $exam_month, $exam_year,$exam_id);


		
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
		function hall_ticket_qr($student_id){
		//load mPDF library
		//echo $student_id;
		$this->load->library('m_pdf');
		$this->load->model('Ums_admission_model');
		$stud_prn = base64_decode($student_id);
		$id = $this->Examination_model->get_student_id_by_prn($stud_prn);
		$stud_id = $id[0]['stud_id'];
		$exam= $this->Examination_model->fetch_stud_curr_exam();
		$this->data['exam']=$exam;
		$exam_month =$exam[0]['exam_month'];
		$exam_year =$exam[0]['exam_year'];
		$exam_id =$exam[0]['exam_id'];
		$this->data['emp_per']= $this->Examination_model->fetch_personal_details($stud_id);
		$admission_school =$this->data['emp_per'][0]['admission_school'];
		$this->data['ex_center']= $this->Examination_model->fetch_exam_center_details($admission_school,$exam_id);
		$this->data['sublist']= $this->Examination_model->getSubjectTimetable($stud_id, $exam_month, $exam_year,$exam_id);


		
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
	
	public function reports(){
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==64 || $this->session->userdata("role_id")==65 
		|| $this->session->userdata("role_id")==66|| $this->session->userdata("role_id")==69 || $this->session->userdata("role_id")==25){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		$college_id = 1;
		//$this->data['course_details']= $this->Examination_model->getCollegeCourse();
		$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam_ecr();
		$exam_id = $this->data['exam_session'][0]['exam_id'];
		//$this->data['schools']= $this->Examination_model->getExamAppledSchools($exam_id);
		$this->load->view($this->view_dir.'exam_reports',$this->data);
		$this->load->view('footer');
       
	}
	// generate reports
	function generateReports(){
		$this->load->model('Results_model');
		$StreamShortName =$this->Examination_model->getStreamShortName($_POST['admission-branch']);
		$exam = explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$exam[2];
		$ex_session = $this->Examination_model->fetch_exam_session_byid($exam_id);
		$exam_type =$ex_session[0]['exam_type'];
		$this->data['exam_session']= $ex_session;
		if($_POST['report_type']=='HallTicket'){
			ini_set('max_execution_time', 0);
			ini_set('memory_limit', '-1');			
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['emp_list']= $this->Examination_model->exam_report_students($streamid='',$year='',$exam_id,$exam_type);
			for($i=0;$i<count($this->data['emp_list']);$i++){
				$student_id =$this->data['emp_list'][$i]['stud_id'];
				
				//$this->data['emp_list'][$i]['emp_per']= $this->Examination_model->fetch_personal_details($student_id);
				
				$this->data['emp_list'][$i]['sublist']= $this->Examination_model->getSubjectTimetable($student_id, $exam_month, $exam_year,$exam_id);

			} 
			
			$this->load->library('m_pdf');
			$html = $this->load->view($this->view_dir.'exam_hallticket', $this->data, true);
			$pdfFilePath = "HT-".$StreamShortName[0]['stream_short_name']."-".$_POST['semester']."-".$_POST['exam_session'].
			".pdf";
			$this->m_pdf->pdf->WriteHTML($html);
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
			//ob_end_clean();
		}
		elseif($_POST['report_type']=='HallTicket_excel'){
		    
		   $this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['emp_list']= $this->Examination_model->get_excel_data($_POST,$exam_month,$exam_year, $exam_id);
				
			$this->load->view($this->view_dir.'exam_hallticket_excel',$this->data); 
		
		}
		elseif($_POST['report_type']=='AttendanceSheet'){
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
			$sublist= $this->Examination_model->fetchExamSubjects();
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
				$subject_id = $sublist[$i]['subject_id'];
				$subject_component = $sublist[$i]['subject_component'];
				$studlist = $this->Examination_model->getSubjectStudentList($subject_id,$_POST['admission-branch'], $exam_month, $exam_year,$exam_id);
				$streamname = $this->Examination_model->getStreamShortName($_POST['admission-branch']);
				
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
						<td>'.$stud['stud_name'].' '.$fvar.'</td>
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
			$this->data['sublist']= $this->Examination_model->fetchExamSubjects();
			for($i=0;$i<count($this->data['sublist']);$i++){
				$subject_id =$this->data['sublist'][$i]['subject_id'];
				$this->data['sublist'][$i]['studlist']= $this->Examination_model->getSubjectStudentList($subject_id,$_POST['admission-branch'], $exam_month, $exam_year,$exam_id);

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
		}
		elseif($_POST['report_type']=='SeatingArrangement_excel'){		    
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];	
			$this->data['sublist']= $this->Examination_model->fetchExamSubjects();			
			for($i=0;$i<count($this->data['sublist']);$i++){
				$subject_id =$this->data['sublist'][$i]['subject_id'];
				$this->data['sublist'][$i]['studlist']= $this->Examination_model->getSubjectStudentList($subject_id,$_POST['admission-branch'], $exam_month, $exam_year, $exam_id);
			} 				
			$this->load->view($this->view_dir.'seatingArrangement_report_excel',$this->data); 
		
		}
		elseif($_POST['report_type']=='Timetable'){
			$this->load->model('Exam_timetable_model');
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['exam_sess']= $exam_month.'-'.$exam_year;
			$this->data['stream_name']=$StreamShortName[0]['stream_short_name'];
			
			$this->data['ex_dt']= $this->Examination_model->fetch_examTimetable($_POST, $exam_month, $exam_year);
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
		//$this->data['course_details']= $this->Examination_model->getCollegeCourse();
		$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		$exam_id = $this->data['exam_session'][0]['exam_id'];
		//$this->data['schools']= $this->Examination_model->getExamAppledSchools($exam_id);
		$this->load->view($this->view_dir.'exam_attreports',$this->data);
		$this->load->view('footer');
       
	}
	public function attendance(){
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==25 || $this->session->userdata("role_id")==26){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
	
		$college_id = 1;
		//$this->data['course_details']= $this->Examination_model->getCollegeCourse();
		$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam_ecr();
		$exam_id = $this->data['exam_session'][0]['exam_id'];
		//$this->data['schools']= $this->Examination_model->getExamAppledSchools($exam_id);
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
				$this->data['sublist'][$i]['studlist']= $this->Examination_model->getSubjectStudentList($subject_id,$_POST['admission-branch'], $exam_month, $exam_year);

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
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==65 || $this->session->userdata("role_id")==69 || $this->session->userdata("role_id")==25){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
		$exam= $this->Examination_model->fetch_stud_curr_exam_ecr();
		$school = $this->Examination_model->getSchoolsByCenter($exam[0]['exam_id']);
		$this->data['schools'] =$school;			
		$this->data['exam_session'] =$exam;			
		$exam_id =$exam[0]['exam_id'];
		//$exam_id =26;
		$this->data['ex_dates']= $this->Examination_model->fetch_examdates($exam_id);
		$this->load->view($this->view_dir.'QPexam_reports',$this->data);
		$this->load->view('footer');
       
	}
	
	function download_daywise_reports_pdf(){
	   // error_reporting(E_ALL); ini_set('display_errors', '1'); 
	    if($_POST['download_type']=='PDF'){
			$exam = explode('-', $_POST['exam_session']);
			$school_code = $_POST['school_code'];
			$exam_month =$exam[0];
			$exam_year =$exam[1];
			$exam_id =$exam[2];
			
			$this->data['exam_sess'] = $this->Examination_model->fetch_exam_session_byid($exam_id);
			$exam_done_in_curr_year = $this->Examination_model->fetch_exam_count_in_year($exam_year);
			$exam_cnt =$exam_done_in_curr_year[0]['cnt'];
			//$exyr= date('y');
			$exyr = substr($exam_year, -2);
			//$exyr= '23';
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
    			h1, h4{margin:0;padding:0}
    			
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
				$stream_arr2 = array(27,28,26,70,126,150,157,164,172,184,185,186,199,200,201,202,203,214,215);
    			for($i=0;$i<count($exam_date);$i++){
    				//$examslots= $this->Examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id);
					//echo "<pre>";print_r($examslots);
					//echo $_POST['exam_timing'];exit;
					if($_POST['exam_timing']=='morning'){
						//$examslots[]= array("from_time"=>'10:00:00',"to_time"=>'01:00:00');
				$examslots= $this->Examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id,'Morning');
					}else if($_POST['exam_timing']=='Afternoon'){
						//$examslots[]= array("from_time"=>'02:00:00',"to_time"=>'05:00:00');
				$examslots= $this->Examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id,'Afternoon');
					}else{
			    $examslots= $this->Examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id,'Both');
			//print_r($examslots);exit();
					}
					
					//print_r($examslots1);exit;
    				foreach($examslots as  $slot){
						$slot_from = $slot['from_time'];
						$slot_to = $slot['to_time'];
						
						$examdetails= $this->Examination_model->exam_daywiseqpindend_report($exam_date[$i],$exam_month,$exam_year,$exam_id, $slot_from,$slot_to,$school_code,$_POST);
						
						//print_r($examdetails);exit;
						if(!empty($examdetails)){
							
							$timestamp = strtotime($examdetails[0]['date']);
							$day = date('l', $timestamp);
							$fromtime= explode(':', $examdetails[0]['from_time']);
							$totime= explode(':', $examdetails[0]['to_time']);
							$date_exam = date('d/m/Y', strtotime($examdetails[0]['date']));
							//exit;
							$header ='<table cellpadding="3" cellspacing="0" border="0" align="center" width="900" style="margin:40px;margin-top:15px">
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
							<td align="center" style="text-align:center;margin:0;padding:0px;"><h4 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>DAY WISE QP REQUIREMENT - '.$exam_month.' - '.$exam_year.'</h4></td>
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
									
									//$examdetails= $this->Examination_model->checkExamSemester($exd['subject_id'],$exam_month,$exam_year,$exam_id);
									/*if($exd['semester'] == $exd['curr_sem']){
										$subappliedstud = $this->Examination_model->subject_applied_count($exd['subject_id'],$exd['stream_id'],$exd['semester'],$exam_year);
										$applied_cnt = $subappliedstud[0]['applied_cnt'];
									}else{*/
										// total backlog subject count
										$subappliedstud = $this->Examination_model->subject_applied_count_bklog($exd['subject_id'],$exd['stream_id'],$exd['semester'],$exam_id);
										$applied_cnt = $subappliedstud[0]['applied_cnt'];
										// total stud sub applied count
										if($this->data['exam_sess'][0]['exam_type']=='Regular'){
											if($exd['curr_sem']!=$exd['semester']){
												$totsubappliedstud = $this->Examination_model->stud_arrear_subjectcount($exd['subject_id'],$exd['stream_id'],$exd['semester'],$exam_id);
											}else{
												$totsubappliedstud = $this->Examination_model->stud_applied_subjectcount($exd['subject_id'],$exd['stream_id'],$exd['semester'],$exam_id,$exd['batch']);
											}
										}else{
											$totsubappliedstud = $this->Examination_model->stud_arrear_subjectcount($exd['subject_id'],$exd['stream_id'],$exd['semester'],$exam_id);
										}
										
										
										$totsubapplied_cnt = $totsubappliedstud[0]['sub_applied_cnt'];
									//}
									$exam_subappliedstud = $this->Examination_model->exam_applied_subjectcount($exd['subject_id'],$exd['stream_id'],$exd['semester'],$exam_id);
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
									if($exd['batch']=='2015' && ($exd['semester']==1 || $exd['semester']==2) && in_array($exd['stream_id'],$stream_arr)){
										$strmname='B.Tech First Year';
									}else if($exd['batch']=='2015' && ($exd['semester']==1 || $exd['semester']==2) && in_array($exd['stream_id'],$stream_arr1)){
										$strmname='B.Sc First Year';
									}
									// else if($exd['batch']=='2022' && ($exd['semester']==1 || $exd['semester']==2) && in_array($exd['stream_id'],$stream_arr2)){
										// $strmname='MBA First Year';
									// }
									else{
										$strmname=$exd['stream_short_name'];
									}
									$sum_totsubapplied_cnt[] = $totsubapplied_cnt;
									$sum_exam_applied_cnt[] = $exam_applied_cnt;
									$sum_qp_count[] = $qp_count;
									$center =$exd['center_code'];
									$content .='<tr>
									<td align="center">'.$center.'-'.$j.'</td>
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
						//$examslots[]= array("from_time"=>'10:00:00',"to_time"=>'01:00:00');
				$examslots= $this->Examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id,'Morning');
					}else if($_POST['exam_timing']=='Afternoon'){
						//$examslots[]= array("from_time"=>'02:00:00',"to_time"=>'05:00:00');
				$examslots= $this->Examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id,'Afternoon');
					}else{
			    $examslots= $this->Examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id,'Both');
			//print_r($examslots);exit();
					}
					foreach($examslots as  $slot){
						$slot_from = $slot['from_time'];
						$slot_to = $slot['to_time'];
						$examdetails= $this->Examination_model->exam_daywise_dispatch_report($exam_date[$i],$exam_month,$exam_year,$exam_id, $slot_from,$slot_to,$school_code,$_POST);
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
							<td align="center" style="text-align:center;margin:0;padding:0"><h4 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>DISPATCH OF ANSWER PAPER PACKETS -'.$exam_month.' - '.$exam_year.'</h4></td>
							<td></td>
							</tr>
							</table>
						
							<table class="content-table" width="100%" cellpadding="3" cellspacing="0" border="1" align="center" style="font-size:12px;overflow: hidden;margin-bottom:30px!important;">		   
							<tr>
							<td width="100" height="30"><strong>Date :</strong> '.$date_exam.'</td>					
							<td width="100" height="30"><strong>Day :</strong> '.$day.'</td>
							<td width="100" height="30"><strong>Time :</strong> '.$fromtime[0].':'.$fromtime[1].'-'.$totime[0].':'.$totime[1].'</td>
							</tr>
							</table>';

							$content ='<table border="1" cellpadding="3" cellspacing="0" class="content-table" width="100%" height="550" style="font-size:12px;">
							<tr>
							<th align="center">S.No.</th>
							<th align="center">Center</th>
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
									$present_students= $this->Examination_model->exam_daywise_present_students_daywise($exam_date[$i],$sub_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);
									
									$absent_students= $this->Examination_model->exam_daywise_absent_students_daywise($exam_date[$i],$sub_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);
									
									$malpractice_students= $this->Examination_model->exam_daywise_malpractice_students($exam_date[$i],$sub_id,$stream_id,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);
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
									$center =$exd['center_code'];
									//echo $ab_commaList;exit;
									$content .='<tr>
									<td valign="top">'.$j.'</td>
									<td valign="top">'.$center.'</td>
									<td valign="top">'.$exd['stream_short_name'].'-'.$exd['semester'].'</td>
									<td valign="top">'.strtoupper($exd['subject_code']).'-'.strtoupper($exd['subject_name']).'</td>
									<td valign="top">'.$cnt_TOTREG.'</td>
									<td valign="top">'.$cnt_present_students.'</td>
									<td valign="top">'.$cnt_absent_students.'</td>
									<td valign="top">'.$cnt_malpractice_students.'</td>
									<td align="center">'.$absentlist.'</td>
									<td align="center">'.$scripts.'</td>
									<td align="center">' . $exd['bundle_numbers'] . '</td>
									</tr>';
					
									$j++;
									unset($absent_students);
									unset($ab_commaList);
									unset($scripts);
								}
							}
							$total_scripts= array_sum($tot_regestered)-array_sum($tot_absent);	
							$content .='<tr>
									<td colspan="4"><b>Total</b></td>
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
			}elseif ($_POST['report_type'] == 'Answerbooklets') {
				//  echo "Answerbooklets";exit;
				$exam_date = $_POST['exam_date'];
				ini_set('max_execution_time', 0);
				ini_set('memory_limit', '-1');
				$this->load->library('m_pdf');
				//$mpdf=new mPDF();
				$this->m_pdf->pdf = new mPDF('utf-8', 'A4-L', '15', '15', '15', '15', '45', '20');

				//echo "<pre>";
				//print_r($sublist);exit;

				$content = '<style>
				table {
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 100%; font-size:11px; margin:0 auto;
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

				$k = 1;
				for ($i = 0; $i < count($exam_date); $i++) {
					if ($_POST['exam_timing'] == 'morning') {
						//$examslots[]= array("from_time"=>'10:00:00',"to_time"=>'01:00:00');
						$examslots = $this->Examination_model->exam_daywise_slot($exam_date[$i], $exam_month, $exam_year, $exam_id, 'Morning');
					} else if ($_POST['exam_timing'] == 'Afternoon') {
						//$examslots[]= array("from_time"=>'02:00:00',"to_time"=>'05:00:00');
						$examslots = $this->Examination_model->exam_daywise_slot($exam_date[$i], $exam_month, $exam_year, $exam_id, 'Afternoon');
					} else {
						$examslots = $this->Examination_model->exam_daywise_slot($exam_date[$i], $exam_month, $exam_year, $exam_id, 'Both');
						//	print_r($examslots);exit();
					}
					foreach ($examslots as $slot) {
						$slot_from = $slot['from_time'];
						$slot_to = $slot['to_time'];
						$examdetails = $this->Examination_model->exam_daywise_Answerbooklets_report($exam_date[$i], $exam_month, $exam_year, $exam_id, $slot_from, $slot_to, $school_code, $_POST);
						if (!empty($examdetails)) {
							$timestamp = strtotime($examdetails[0]['date']);
							$day = date('l', $timestamp);
							$fromtime = explode(':', $examdetails[0]['from_time']);
							$totime = explode(':', $examdetails[0]['to_time']);
							$date_exam = date('d/m/Y', strtotime($examdetails[0]['date']));
							//exit;
							$header = '<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
							<tr>
							<td width="80" align="center" style="text-align:center;padding-top:5px;"><img src="https://erp.sandipuniversity.com/assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
							<td style="font-weight:normal;text-align:center;">
							<h1 style="font-size:20px;">Sandip University</h1>
							<p>Mahiravani, Trimbak Road, Nashik - 422 213</p>
								
							</td>
							<td width="120" align="right" valign="middle" style="text-align:center;">
							</td>
							</tr>
							<tr>
							<td></td>
							<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:12px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>ANSWER BOOKLETS FOR -<u>' . $exam_month . ' - ' . $exam_year . '</u></h3></td>
							<td></td>
							</tr>
							</table>';


							$content = '';
							$j = 1;
							//	print_r($examdetails);exit;
							if (!empty($examdetails)) {
								foreach ($examdetails as $exd) {
									$course_code = $exd['subject_code'] . '-' . $exd['subject_name'];
									$stream_name = $exd['stream_short_name'];
									$content .= '<table class="content-table" width="100%" cellpadding="5" cellspacing="0" border="1" align="center" style="font-size:10px;xoverflow: hidden;">
									<tr>
									<td style="font-size: 12px;" width="31%"><strong>Course Code and Name :</strong> ' . strtoupper($course_code) . '</td>
									<td style="font-size: 12px;" width="31%" valign="top"><strong>Date/ Day :</strong> ' . $date_exam . ', ' . $day . '</td>
									<td style="font-size: 12px;" width="31%" valign="top"><strong>Time :</strong> ' . $fromtime[0] . ':' . $fromtime[1] . '-' . $totime[0] . ':' . $totime[1] . '</td>
									</tr>
									<tr>
									<td style="font-size: 12px;" ><strong>Programme :</strong> ' . $stream_name . '</td>
									<td style="font-size: 12px;" ><strong>Bundle No. :</strong>' . $exd['bundle_no'] . '</td>
									<td style="font-size: 12px;" ><strong>Board :</strong>___________</td>
									</tr>
									';

									$fromtime = explode(':', $exd['from_time']);
									$totime = explode(':', $exd['to_time']);
									$stream_id = $exd['stream_id'];
									$absent_students = $this->Examination_model->exam_daywise_absent_students($exam_date[$i], $exd['subject_id'], $stream_id, $exam_month, $exam_year, $exam_id, $slot_from, $slot_to, $exd['bundle_no']);
									$present_students = $this->Examination_model->exam_daywise_present_students($exam_date[$i], $exd['subject_id'], $stream_id, $exam_month, $exam_year, $exam_id, $slot_from, $slot_to, $exd['bundle_no']);
									
									$cnt_present = count($present_students);
									$cnt_absent = count($absent_students);
									
									// Collect absent students in an array for easy lookup
									$absent_enrollments = array_column($absent_students, 'enrollment_no');
									
									$content .= '
									<tr>
										<td valign="top" colspan="3" style="height:400px">
											<table class="content-table" width="100%" cellpadding="5" cellspacing="0" border="1">
												<tr>';
									
									// Merge both arrays
									$all_students = array_merge($present_students, $absent_students);
									$count = 0;
									
									foreach ($all_students as $student) {
										// Check if the student is absent and apply a red background with white text
										$bgColor = in_array($student['enrollment_no'], $absent_enrollments) ? 'background-color: orange;' : '';
									
										$content .= '<td style="' . $bgColor . ' font-weight: ; font-size: 10px; padding-top: 20px;padding-bottom: 20px;padding-right: 14px;padding-left: 14px; text-align: center;">' . $student['enrollment_no'] . '</td>';
										$count++;
									
										// After every 10 students, close the current row and start a new one
										if ($count % 10 == 0) {
											$content .= '</tr><tr>';
										}
									}
									
									// Close the last row properly
									$content .= '</tr></table>
										</td>       
									</tr>
									
									
									<tr>';
									//<td height="30" colspan="2"><strong>Absentee Register Nos. :</strong>';
									// foreach ($absent_students as $ab) {
									// 	$content .= '<span>' . $ab['enrollment_no'] . ', </span>';
									// }
									// $content .= '</td>
									$content .= '<td style="font-size: 12px;" height="30"><strong>Total Absentee. : </strong>' . $cnt_absent . '</td>
								   
									<td style="font-size: 12px;" width="100%" height="30" colspan="2"><strong>Total Answer Scripts. : </strong>' . $cnt_present . '</td>
								  
									</tr>
									</table><br><br>';

									$j++;
									// unset($ab_commaList);
									//unset($stud_prn);
								}
							}


							//$content .='';
							//echo $header;echo $content;exit;
							$footer = '';
							$footer .= '<table width="900" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:40px;font-size:12px;">
							<tr>
							<td align="center">
							<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">

							<tr>
							<td align="left" class="signature" valign="bottom" style="padding-top:30px"><strong>Signature of the SUP 1 :</strong></td>
							<td align="center"  class="signature" valign="bottom" height="50"><strong>Signature of the SUP 2</strong></td>
							<td align="right" class="signature" valign="bottom" height="50"><strong>Signature of the Chief Superintendent</strong></td>
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
				$pdfFilePath = $date_file . "_AnswerBookletsReport.pdf";
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
						//$examslots[]= array("from_time"=>'10:00:00',"to_time"=>'01:00:00');
				$examslots= $this->Examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id,'Morning');
					}else if($_POST['exam_timing']=='Afternoon'){
						//$examslots[]= array("from_time"=>'02:00:00',"to_time"=>'05:00:00');
				$examslots= $this->Examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id,'Afternoon');
					}else{
			    $examslots= $this->Examination_model->exam_daywise_slot($exam_date[$i],$exam_month,$exam_year,$exam_id,'Both');
			//print_r($examslots);exit();
					}
					foreach($examslots as  $slot){
						$slot_from = $slot['from_time'];
						$slot_to = $slot['to_time'];
						$examdetails= $this->Examination_model->exam_daywise_dispatch_report($exam_date[$i],$exam_month,$exam_year,$exam_id, $slot_from,$slot_to,$school_code,$_POST);
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
									$present_students= $this->Examination_model->exam_marklist_students($exam_date[$i],$exd['subject_id'],$stream_id,$exam_month,$exam_year, $exam_id);
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
				//$examslots= $this->Examination_model->exam_daywise_slot($exam_date,$exam_month,$exam_year,$exam_id);
    				/*foreach($examslots as  $slot){
						$slot_from = $slot['from_time'];
						$slot_to = $slot['to_time'];
						$this->data['examdetails']= $this->Examination_model->exam_daywiseqpindend_report($exam_date,$exam_month,$exam_year,$exam_id, $slot_from,$slot_to);*/
						$this->data['examdetails']= $this->Examination_model->exam_daywise_report($exam_date,$exam_month,$exam_year,$exam_id);
					//}
			} 

			$this->load->view($this->view_dir.'daywiseQPreport_excel',$this->data);
	}
		function absent_entries(){
			if($this->session->userdata("role_id")==15){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);        			
		$this->data['exam_session'] =$this->Examination_model->fetch_stud_curr_exam();	
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
			
			$this->data['stud_details']= $this->Examination_model->fetch_exam_datewise_applied_student($stream,$exam_date,$subject_id,$exam_month, $exam_year, $exam_id);
		}
		//$this->data['ex_dates']= $this->Examination_model->fetch_examdates1($exam_month, $exam_year);
		$this->load->view($this->view_dir.'absent_mark_exam_view',$this->data);
		$this->load->view('footer');	
	}
	
	function fetch_examdates_by_session(){
		if(isset($_POST["exam_session"]) && !empty($_POST["exam_session"])){
			//Get all city data
			$exam= explode('-', $_POST["exam_session"]);		
			$exam_id =$exam[2];

			$exdate = $this->Examination_model->fetch_examdates($exam_id);        
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
			$exam= $this->Examination_model->fetch_stud_curr_exam();		
			$exam_month =$exam[0]['exam_month'];
			$exam_year =$exam[0]['exam_year'];
			$exam_id =$exam[0]['exam_id'];
			//
			$stream = $_POST["stream"];
			$exam_date = $_POST["exam_date"];
			$stream = $this->Examination_model->get_exam_subjects($exam_date,$stream,$exam_month,$exam_year,$exam_id);        
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
			$exam= $this->Examination_model->fetch_stud_curr_exam();		
			$exam_month =$exam[0]['exam_month'];
			$exam_year =$exam[0]['exam_year'];
			$exam_id = $exam[0]['exam_id'];
			$stream = $this->Examination_model->get_exam_streams($_POST["exam_date"],$exam_month,$exam_year, $exam_id);
          
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
		$examdata= $this->Examination_model->fetch_stud_curr_exam();
		$checked_stud = $_POST['chk_stud'];
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$examdata[0]['exam_id'];
		$sub = $_POST['subject'];
		$stream = $_POST['stream'];
		//print_r($_POST);exit;
		foreach($checked_stud as $stud){
			$this->Examination_model->mark_absent_students($stud,$sub, $stream,$exam_month, $exam_year,$exam_id);
							
		}
		echo "success";

	} 	
	public function mark_present_students(){    
		$examdata= $this->Examination_model->fetch_stud_curr_exam();
		$checked_stud = $_POST['chk_stud'];
		$exam= explode('-', $_POST['exam_session']);
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id =$examdata[0]['exam_id'];
		$sub = $_POST['subject'];
		$stream = $_POST['stream'];
		//print_r($_POST['chk_stud']);exit;
		foreach($checked_stud as $stud){
			$this->Examination_model->mark_present_students($stud, $sub, $stream,$exam_month, $exam_year, $exam_id);
							
		}
		echo "success";

	} 		
	public function malpractice_add(){
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==25 || $this->session->userdata("role_id")==26){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data); 
		$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		//print_r($this->data['exam_session']);
		//$exam_id = $this->data['exam_session'][0]['exam_id'];
		$exam_id = $this->data['exam_session'][0]['exam_id'];
		//$exam_year = $this->data['exam_session'][0]['exam_year'];
		$this->data['ex_dates']= $this->Examination_model->fetch_examdates($exam_id);
		$this->load->view($this->view_dir.'search_student',$this->data);
		$this->load->view('footer');
	}
	function search_studentdata_for_malware (){
		$_POST['academic_year'] = '2017';
		//$data['exam']= $this->Examination_model->fetch_stud_curr_exam();
		$exam = explode('-', $_POST['exam_session']);
		$exam_month = $exam[0];
		$exam_year = $exam[1];
		$exam_id =$exam[2];
		$exam_date =$_POST['exam_date'];
		$prn =$_POST['prn'];
		$data['emp_list'] = $this->Examination_model->searchStudent_for_malpractice($prn,$exam_date,$exam_month,$exam_year,$exam_id);
	
		$html = $this->load->view($this->view_dir.'load_studentdata_malware',$data,true);
		echo $html;
	}
	function update_studentdata_for_malware(){
		$is_malpractice = $_POST['is_malpractice'];
		$remark = $_POST['remark'];
		$subject = $_POST['subject'];
		$exam_sub_id = $_POST['examsub_id'];
		$exam= explode('-', $_POST['exam_session']);
		$exam= $this->Examination_model->fetch_stud_curr_exam();
		$exam_month =$exam[0]['exam_month'];
		$exam_year =$exam[0]['exam_year'];
		$exam_id =$exam[0]['exam_id'];
		$this->Examination_model->update_studentdata_for_malware($exam_sub_id,$is_malpractice, $subject,$remark, $exam_month, $exam_year,$exam_id);

		echo "success";
	}
	function generate_excelReports(){
		$StreamShortName =$this->Examination_model->getStreamShortName($_POST['admission-branch']);
		
		if($_POST['report_type']=='HallTicket'){
			//$this->load->view('header',$this->data);        
			$this->data['school_code'] =$_POST['school_code'];
			$this->data['admissioncourse'] =$_POST['admission-course'];
			$this->data['stream'] =$_POST['admission-branch'];
			$this->data['semester'] =$_POST['semester'];
			$this->data['course_details']= $this->Examination_model->getCollegeCourse();
			$this->data['schools']= $this->Examination_model->getSchools();
			$exam= $this->Examination_model->fetch_stud_curr_exam();
			$exam_month =$exam[0]['exam_month'];
			$exam_year =$exam[0]['exam_year'];
			$this->data['emp_list']= $this->Examination_model->get_excel_data($_POST,$exam_month,$exam_year);
				
			$this->load->view($this->view_dir.'exam_hallticket_excel',$this->data);
			//ob_end_clean();
		
		}
	}
	
	function malpractice_list(){
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==25 || $this->session->userdata("role_id")==26){
		}else{
			redirect('home');
		}
	   // $this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		$this->load->model('Marks_model');
	    //$this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
		$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
	    if(!empty($_POST['exam_session'])){
	        
	    $exam_session = $_POST['exam_session'];
	    $exam = explode('-', $exam_session);
	    $exam_month =$exam[0];
	    $exam_year =$exam[1];
		$exam_id =$exam[2];
		//$exam_id =26;
	    $this->data['malpractice_list']= $this->Examination_model->get_malpractice_list_data($exam_month,$exam_year, $exam_id);
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
	        $this->data['malpractice_list']= $this->Examination_model->get_malpractice_list_data($exam_month,$exam_year,$exam_id);
	        $this->load->view($this->view_dir.'malpractice_excelReports',$this->data);

	}	
	// download student malpractice report
	function malpractice_report($prn, $exam_date){
	   
	    $this->data['exam']= $this->Examination_model->fetch_stud_curr_exam();
	    $exam_month =  $this->data['exam'][0]['exam_month'];
	    $exam_year =  $this->data['exam'][0]['exam_year'];
		$exam_id =  $this->data['exam'][0]['exam_id'];
	    $exam_date = $exam_date;
	    $prn =$prn;
	    $this->data['emp_per'] = $this->Examination_model->searchStudent_for_malpractice($prn,$exam_date,$exam_month,$exam_year,$exam_id);

	    $this->load->library('m_pdf', $param);
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '20', '10', '10', '10', '10', '10');
	    
	    $html = $this->load->view($this->view_dir.'student_malpractice_report', $this->data, true);
	    $pdfFilePath = $prn."_malpractice_report.pdf";
	    
	    $this->m_pdf->pdf->WriteHTML($html);
	    //download it.
	    $this->m_pdf->pdf->Output($pdfFilePath, "D");
	    
	}
	// fetch exam strams

	// download student malpra
	function malpractice_notice_letter(){

		 	$exam_session = $_POST['exam_sessionn'];
		    $exam = explode('-', $exam_session);
		    $exam_month =$exam[0];
		    $exam_year =$exam[1];
			$exam_id =$exam[2];
	   		$this->data['malpractice_list']= $this->Examination_model->pdfforStudent_for_malpractice($exam_month,$exam_year, $exam_id,$_POST['schoolidd'],$_POST['studentid']);

	   $this->data['exam_year']=$exam_year;
	    $this->data['exam_month']= $exam_month;

	    $this->load->library('m_pdf', $param);
	    $this->m_pdf->pdf=new mPDF('utf-8', 'A4', '20', '10', '10', '10', '10', '10');
	    $this->data['exam_month']=$exam_month ;
	      $this->data['exam_year']=$exam_year ;
	      $this->data['comment']=$_POST['comment'];
	    $html = $this->load->view($this->view_dir.'malpdf_student', $this->data, true);
	    $pdfFilePath = $_POST['studentid']."-malpractice_report.pdf";
	    
	    $this->m_pdf->pdf->WriteHTML($html);
	    //download it.
	    $this->m_pdf->pdf->Output($pdfFilePath, "D");
	    
	}
	// fetch exam strams
	function load_examresltstreams(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["course_id"]) && !empty($_POST["course_id"])){
			//Get all streams
			$stream = $this->Examination_model->get_examresltstreams($_POST["course_id"]);
            
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
			$stream = $this->Examination_model->get_examresltsemester($_POST["stream_id"]);
            
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
			$stream = $this->Examination_model->get_examresltcourses($_POST["school_code"]);
            
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
			$this->data['summary_list']= $this->Examination_model->get_exam_app_studcount($_POST,$exam_month,$exam_year, $exam_id);
			$this->load->view($this->view_dir.'examappliedstudentcount_excel.php',$this->data); 
		}else{
			$this->data['summary_list']= $this->Examination_model->get_exam_app_stud($_POST,$exam_month,$exam_year, $exam_id);
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
	function download_pdf($student_id='', $exam_id=''){
		//load mPDF library
        date_default_timezone_set('Asia/Kolkata');
		//echo date('d-m-Y H:i:s');exit;
		$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		
		$this->load->library('m_pdf', $param);
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
		$stud_id = base64_decode($student_id);
		$exam_id = base64_decode($exam_id);
		if($stud_id!='' && $exam_id!='' ){
			$this->data['exam']= $this->Examination_model->fetch_exam_session_byid($exam_id);
			$exam_month =$this->data['exam'][0]['exam_month'];
			$exam_year =$this->data['exam'][0]['exam_year'];
			$this->data['examdetails']= $this->Examination_model->fetch_stud_exam_details($stud_id,$exam_id);
			//print_r($this->data['examdetails']);exit;
			$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Examination_model->fetch_banks();
			$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
			$semester = $this->data['emp'][0]['current_semester'];
			$this->data['sublist']= $this->Examination_model->getCurrentExamAllocatedSubject($stud_id, $semester,$exam_id);	
			$this->data['examfees']= $this->Examination_model->fetch_examfeesdetails($this->data['emp'][0]['stream_id'], $this->data['exam'][0]['exam_id']);
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
			
		

		$html = $this->load->view($this->view_dir.'exam_form_pdf_new11', $this->data, true);
		$pdfFilePath = $this->data['emp'][0]['enrollment_no']."_exam_form.pdf";
		$stud_name = $this->data['emp'][0]['last_name'].' '.$this->data['emp'][0]['first_name'].' '.$this->data['emp'][0]['middle_name'];
		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		$form_submitted_date= date("d-m-Y H:i:s", strtotime($this->data['examdetails'][0]['entry_on']));
		 date_default_timezone_set('Asia/Kolkata');
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
		}else{
			echo  "No data found;";exit;
		}
	}
	function download_arrearpdf($student_id, $exam_id){
		//load mPDF library
        
		$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		
		$this->load->library('m_pdf', $param);
		$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '10', '10', '10', '10', '10', '10');
		$stud_id = base64_decode($student_id);
		if($stud_id!=''){
			$this->data['exam']= $this->Examination_model->fetch_exam_session_byid($exam_id);
			$exam_month =$this->data['exam'][0]['exam_month'];
			$exam_year =$this->data['exam'][0]['exam_year'];
			$this->data['examdetails']= $this->Examination_model->fetch_stud_exam_details($stud_id,$exam_id);
			//print_r($this->data['examdetails']);exit;
			$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Examination_model->fetch_banks();
			$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
			$semester = $this->data['emp'][0]['current_semester'];
			$this->data['sublist']= $this->Examination_model->getCurrentExamAllocatedSubject($stud_id, $semester,$exam_id);	
			$this->data['examfees']= $this->Examination_model->fetch_examfeesdetails($this->data['emp'][0]['stream_id'], $this->data['exam'][0]['exam_id']);
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
			$stream = $this->Examination_model->load_ex_appliedstreams($_POST["course_id"],$exam_id);
            
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
	
	function load_ex_appliedstreams_new(){
		//echo $_POST["course_id"];exit;
		//if(isset($_POST["course_id"]) && !empty($_POST["course_id"])){
			
			//Get all streams
			$stream = $this->Examination_model->load_ex_appliedstreams_new($_POST["course_id"],$_POST["exam_session"],$_POST["school_code"]);
            
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
			$stream = $this->Examination_model->load_ex_appliedsemesters($_POST["stream_id"], $exam_id);
            
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
	function load_examsubjects(){
		//echo $_POST["course_id"];exit;
		if(isset($_POST["stream_id"]) && !empty($_POST["stream_id"])){
			//Get all streams
			//echo $_POST["exam_session"];
			$stream = $this->Examination_model->get_examsubjects($_POST["stream_id"], $_POST["exam_session"], $_POST["semester"]);
            
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
					echo '<option value="' . $value['sub_id'] . '" '.$sel.'>' . $value['subject_code'].'-'.$value['subject_name'] . '</option>';
				}
			} else{
				echo '<option value="">Subject not available</option>';
			}
		}
	}
	function search_attendance_data($examsessionn='',$school_code='',$admission_course='',$admission_branch='',$semester='',$subject_id=''){
		//error_reporting(E_ALL);
		//echo 1; exit;
		$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
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
			$this->data['stud_details']= $this->Examination_model->getSubjectStudentList_for_attendance($subject_id,$admission_branch,$exam_id);
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
			$this->data['stud_details']= $this->Examination_model->getSubjectStudentList_for_attendance($_POST['subject_id'],$_POST['admission-branch'],$exam_id);

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
		
		$remark=$_POST['remark'];
		//echo"<pre>";print_r($_POST);exit;
		
		$check_duplicate= $this->Examination_model->check_duplicate_for_attendance($subject_id,$stream_id,$semester,$exam_id,$exam_date);
		
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
			//	echo $exam_attendance_status1.'--'.$stud; echo 'insert<br>';
				
				//print_r($_POST);
		//exit();
				
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
				"inserted_by" => $this->session->userdata("uid"),
				"inserted_ip" => $_SERVER['REMOTE_ADDR'],
				"inserted_on" => date("Y-m-d H:i:s")
				);
				//echo "<pre>";print_r($_POST);  
				$DB1->insert("exam_ans_booklet_attendance", $arr_insert);
				//echo $DB1->last_query();exit;
				$i++;				
			}
			$this->session->set_flashdata('Successfully','Inserted Successfully ');
		}
		else{

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
							$check_duplicate_student= $this->Examination_model->check_duplicate_for_attendance_indivisual_student($stud,$subject_id,$stream_id,$semester,$exam_id,$exam_date);
							
						if($check_duplicate_student==0)
						{


							//echo $exam_attendance_status1.'--'.$stud; echo 'insert<br>';
								
								//print_r($_POST);
								//exit();
				
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
							"inserted_by" => $this->session->userdata("uid"),
							"inserted_ip" => $_SERVER['REMOTE_ADDR'],
							"inserted_on" => date("Y-m-d H:i:s")
							);
							//echo "<pre>";print_r($_POST);  exit;
							$DB1->insert("exam_ans_booklet_attendance", $arr_insert);

						}

						else
						{


								//echo $exam_attendance_status1.'--'.$stud; echo 'update<br>';exit;
							$update_insert =array(
							'exam_attendance_status'=>$exam_attendance_status1,
							'ans_bklet_no'=>$ans_booklet_no[$i],
							'ans_bklt_received_status'=>$ans_booklet_received1,
							'remark'=>$remark[$i],
							"updated_by" => $this->session->userdata("uid"),
							"updated_ip" => $_SERVER['REMOTE_ADDR'],
							"updated_on" => date("Y-m-d H:i:s")
							);
							$DB1->where("student_id",$stud);
							$DB1->where("subject_id",$subject_id);
							$DB1->where("stream_id",$stream_id);
							$DB1->where("semester",$semester);
							$DB1->where("exam_date",$exam_date);
							$DB1->where("exam_id",$exam_id);
							//$exam_date
							//echo "<pre>";print_r($_POST);  
							$DB1->update("exam_ans_booklet_attendance", $update_insert);
							
							//echo $DB1->last_query();exit;

						}
						$i++;


					}

		
			
	 				$this->session->set_flashdata('Successfully','Updated Successfully ');
			
		}
		
		$examsessionn=$_POST['examsessionn'];
		$school_code=$_POST['school_code'];
		 $admission_course=$_POST['admission_course'];

		$admission_branch=$_POST['admission_branch'];
		$semester=$_POST['semester'];
		$subject_id=$_POST['subject_id'];
		redirect('examination/search_attendance_data/'.$examsessionn.'/'.$school_code.'/'.$admission_course.'/'.$admission_branch.'/'.$semester.'/'.$subject_id);
		

	} 	
	
	/* code by vighnesh */
	public function school_reports(){
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==6 
		|| $this->session->userdata("role_id")==20   || $this->session->userdata("role_id")==44 
		|| $this->session->userdata("role_id")==10 || $this->session->userdata("role_id")==64
		|| $this->session->userdata("role_id")==65 || $this->session->userdata("role_id")==66
		|| $this->session->userdata("role_id")==69 ){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
		$college_id = 1;
		$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		$exam_id = $this->data['exam_session'][0]['exam_id'];
		$this->load->view($this->view_dir.'exam_school_reports',$this->data);
		$this->load->view('footer');
       
	}
	
	public function get_exam_sessions(){
		$type=$_POST['type'];
		$str="";
		$str.='<option value="">Exam Session </option>';
		if($type==1){
		  $exam_session= $this->Examination_model->fetch_stud_curr_exam();	
		}
		else if($type==2){
		  $exam_session= $this->Examination_model->fetch_stud_curr_phd_exam();	
		}
		if(!empty($exam_session)){
			
			
				foreach($exam_session as $value){
					$exam_sess = $value['exam_month'] .'-'.$value['exam_year'];
					$exam_sess_val = $value['exam_month'].'-'.$value['exam_year'].'-'.$value['exam_id'];
					$str.= '<option value="' . $exam_sess_val. '">' . $exam_sess. '</option>';
				}
		}
		echo $str;
	}
	
	
	function totalreportsummary(){	
		
		$this->data['school_code'] =$_POST['school_code'];
		//$this->data['admissioncourse'] =$_POST['admission-course'];
		$exam= explode('-', $_POST['exam_session']);
		$this->data['exam_session'] =$exam[0].'-'.$exam[1];
		$exam_month =$exam[0];
		$exam_year =$exam[1];
		$exam_id = $exam[2];
		$report_type = $_POST['report_type'];
		$type=$_POST['type'];
		$this->data['report_type'] = $_POST['report_type'];
		$this->data['exam_id']=$exam_id;
		$this->data['type']=$type;
		
		if($report_type =='Statistics'){
			$this->data['summary_list']= $this->Examination_model->get_exam_studcount_applied_and_not_applied($_POST,$exam_month,$exam_year, $exam_id,$type);
			
		
			if($_POST['act']=="view"){
                 $this->load->view($this->view_dir.'total_students_data',$this->data);
             }
             else{
                 $this->load->view($this->view_dir.'total_students_count_excel.php',$this->data); 
                 $this->session->set_flashdata('excelmsg', 'download');
             }
		}else{
			//$this->data['summary_list']= $this->Examination_model->get_exam_app_stud($_POST,$exam_month,$exam_year, $exam_id);
			//$this->load->view($this->view_dir.'exam_applied_student_excel.php',$this->data); 
		}
		
	}
	
	function details_of_students($exam_id='',$year='',$current_semester='',$stream='',$is_of='',$type=""){
		$this->load->view('header',$this->data);   
		$this->data['summary_list']= $this->Examination_model->get_exam_studcount_applied_and_not_applied_details($exam_id,$year, $current_semester,$stream,$is_of,$type);
		$this->data['exam_id']=$exam_id;
		$this->data['year']=$year;
		$this->data['current_semester']=$current_semester;
		$this->data['stream']=$stream;
		$this->data['is_of']=$is_of;
		$this->data['type']=$type;
		
		$this->load->view($this->view_dir.'student_filter_list',$this->data);
		$this->load->view('footer');
	}
	public function edit_exam_form_contocoe($student_prn){  // contact to COE
		if($student_prn !=''){
			$stud_prn = base64_decode($student_prn);
		}else{
			$stud_prn = $this->session->userdata('name');
		}
		
		$id= $this->Examination_model->get_student_id_by_prn($stud_prn);
		$stud_id=$id['stud_id'];
		$current_semester =$id['current_semester'];
		$stream =$id['admission_stream'];
		$ex_session = $this->Examination_model->fetch_stud_curr_exam();
		$this->data['ex_session'] = $ex_session;
		if($stud_id!=''){
			$this->data['exam']= $this->Examination_model->fetch_stud_exam_details($stud_id);
			$this->data['fee']= $this->Examination_model->fetch_stud_fee_exam($stud_id);
			$this->data['bank']= $this->Examination_model->fetch_banks();
			$this->data['emp']= $this->Examination_model->fetch_personal_details($stud_id);
			$this->data['sublist']= $this->Examination_model->get_stud_applied_sub_for_arrear_update($stud_id,$current_semester);
	
		}
		$this->load->view('header',$this->data); 
		$this->load->view($this->view_dir.'edit_exm_form',$this->data);
		$this->load->view('footer');
        
	}
	// arrears update exam subject
	public function update_subject_in_arrears_details(){  
		$DB1 = $this->load->database('umsdb', TRUE);
		$exam_details =  explode('~',$this->input->post('exam_details'));
		//echo $exam_details[0]-1;print_r($exam_details);exit;
		$fee_date = str_replace('/', '-', $_POST['dddate']);
		
		$insert_exam_subjects=array(
			"student_id"=>$this->input->post('student_id'),
			"enrollment_no"=>$this->input->post('enrollment_no'),
			"stream_id"=>$this->input->post('stream_id'),
			"exam_id" => $exam_details[0]-1,
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
				$is_sub_exit = $this->Examination_model->check_duplicate_sub_in_arrears($this->input->post('student_id'),$sub[0]);
				//print_r($is_sub_exit);exit;
				if(empty($is_sub_exit)){
					$DB1->insert("exam_student_subject", $insert_exam_subjects);
				}
				//echo $DB1->last_query();echo "<br>";
				
		}
		



		$studprn = base64_encode($_POST['enrollment_no']);
		redirect('examination/view_form/'.$studprn);

	} 
	function search_student_for_exam_allow(){

		$prn = $_POST['prn'];
		$this->data['exam_session_val']= $this->Examination_model->fetch_stud_curr_exam();
		$this->data['forms_dates']= $this->Examination_model->get_form_entry_dates($this->data['exam_session_val'][0]['exam_id']);

		$id= $this->Examination_model->get_student_id_by_prn($prn);
		$stud1=$this->Examination_model->get_studentwise_admission_fees($prn,$id['academic_year']);
		
		$other=$stud1[0]['opening_balance']+$stud1[0]['cancel_charges'];
		if(in_array($prn, $arr_prn)){
			$pending=0;
			$per_paid=100; 
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
			$emp_list= $this->Examination_model->searchStudentsajax($_POST);
			if(!empty($emp_list)){
				$data['emp_list']= $emp_list;
				$data['emp_list'][0]['exam_details']= $this->Examination_model->studentExamDetails($_POST);
			}else{
				$emp_list1= $this->Examination_model->searchCheckStudentbyprn($_POST);
				$data['emp_list']= $emp_list1;
			}
			$data['fees']= $this->Examination_model->fetch_fees($_POST);
			$data['exam']= $this->Examination_model->fetch_stud_curr_exam();
			$html = $this->load->view($this->view_dir.'load_studentdata_for_allowed',$data,true);
			echo $html;

	}	
	function allow_student_for_exam(){
		$DB1 = $this->load->database('umsdb', TRUE);
		$stud=$_POST['student_id'];
		$exam_id=$_POST['exam_id'];
		$check_duplicate_student= $this->Examination_model->check_duplicate_allow_student_for_exam($stud,$exam_id);
							
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
			$DB1->insert("exam_allowed_students", $arr_insert);
			  //echo $DB1->last_query();exit;  
		}
		redirect('examination/search_allow_for_exam/');
	}
		public function search_arrears(){
			
			if($this->session->userdata("role_id")==15  ||  ($this->session->userdata("role_id")==66)
				|| $this->session->userdata("role_id")==65 || $this->session->userdata("role_id")==69 
			|| $this->session->userdata("role_id")==64 
			 || $this->session->userdata("role_id")==70
			|| $this->session->userdata("role_id")==50  || $this->session->userdata("role_id")==6
			|| $this->session->userdata("role_id")==72){
		
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
		$college_id = 1;
		$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		$exam_id = $this->data['exam_session'][0]['exam_id'];
		$this->load->view($this->view_dir.'search_arrears',$this->data);
		$this->load->view('footer');
       
	}
	function student_arrears_list(){	
		$type=$_POST['type'];
		$this->data['report_type'] = $_POST['report_type'];
		$prn=trim($_POST['prn']);
		
		
		$this->data['summary_list']= $this->Examination_model->student_arrears_list($prn);
			
        $this->load->view($this->view_dir.'total_students_arrears_data.php',$this->data);

		
		
	}
	public function search_for_marks_entry(){
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==26){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
		$college_id = 1;
		$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		$exam_id = $this->data['exam_session'][0]['exam_id'];
		$this->load->view($this->view_dir.'search_for_marks_entry',$this->data);
		$this->load->view('footer');
       
	}
	public function search_for_result_entry(){
		$this->load->view('header',$this->data);        
		$this->data['school_code'] ='';
		$this->data['admissioncourse'] = '';
		$this->data['stream'] = '';
		$this->data['semester'] = '';
		$college_id = 1;
		$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		$exam_id = $this->data['exam_session'][0]['exam_id'];
		$this->load->view($this->view_dir.'search_for_result_entry',$this->data);
		$this->load->view('footer');
       
	}
	function student_result_entry_list(){	
		$type=$_POST['type'];
		$this->data['report_type'] = $_POST['report_type'];
		$prn=trim($_POST['prn']);
		$exam_id=26;
		
		$this->data['summary_list']= $this->Examination_model->student_result_entry_list($prn,$exam_id);
			
        $this->load->view($this->view_dir.'total_students_result_data.php',$this->data);		
		
	}
	function student_marks_entry_list(){	
		$type=$_POST['type'];
		$this->data['report_type'] = $_POST['report_type'];
		$prn=trim($_POST['prn']);
		
		
		$this->data['summary_list']= $this->Examination_model->student_marks_entry_list($prn);
			
        $this->load->view($this->view_dir.'total_students_marks_data.php',$this->data);		
		
	}
	/**********************************download exam applied students data***************************************************/
    function download_exam_applied_stud_data(){
		ini_set('memory_limit', '-1');
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==64
		|| $this->session->userdata("role_id")==65 || $this->session->userdata("role_id")==66 || $this->session->userdata("role_id")==69
		){
		}else{
			redirect('home');
		}
		 $this->load->view('header',$this->data); 
		 $this->load->model('Marks_model');
		$this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
		if($_POST['exam_session'] !=''){

			$exam=explode('-',$_POST['exam_session']);
			$exam_id=$exam[2];
			$type=$_POST['report_type']; 
			$this->data['loader']='loader1';
			if($type=='without_timetable'){
				//echo 'insidse';
				$this->data['loader']='loader';
				$this->data['malpractice_list'] = $this->Examination_model->fetch_exam_applied_stud_data($exam_id);
				//print_r($this->data['malpractice_list']);exit;
				$this->load->view($this->view_dir.'download_exam_applied_stud_data',$this->data);
			}else{					
				$this->data['malpractice_list']='loader';
				$this->data['malpractice_list'] = $this->Examination_model->fetch_exam_applied_stud_data_time_table($exam_id);
				$this->load->view($this->view_dir.'download_exam_applied_stud_data_time_table',$this->data);
			}
		
		}else{			
		$this->load->view($this->view_dir.'download_exam_applied_stud_data',$this->data);
        
		}
		$this->load->view('footer');
    }
	
	function load_examsess_schools_for_rank(){
		if(isset($_POST["regulation"]) && !empty($_POST["regulation"])){

			//echo 1; exit;
			//Get all city data
			$stream = $this->Examination_model->load_examsess_schools_for_rank_data($_POST["regulation"]);
            
			//Count total number of rows
			$rowCount = count($stream);

			//Display cities list
			if($rowCount > 0){
				echo '<option value="">Select School</option>';
				echo '<option value="All">All</option>';
				foreach($stream as $value){
					if(isset($_POST['school_code']) && ($_POST['school_code']==$value['school_code']))
					{
						 $sel = "selected";
					}
					else
					{
						$sel ='';
					}
					/*if($this->session->userdata('name')=='exam_ecr1' && ($value['school_code']=='1001' || $value['school_code']=='1006')){
						echo '<option value="' . $value['school_code'] . '" '.$sel.'>' . $value['school_short_name'] . '</option>';
					}else if($this->session->userdata('name')=='exam_ecr2' && ($value['school_code']!='1001' && $value['school_code']!='1006')){
						echo '<option value="' . $value['school_code'] . '" '.$sel.'>' . $value['school_short_name'] . '</option>';
					}else if($this->session->userdata('name')=='su_coe' || $this->session->userdata('name')=='suerp'){
						echo '<option value="' . $value['school_code'] . '" '.$sel.'>' . $value['school_short_name'] . '</option>';
					}*/
					echo '<option value="' . $value['school_code'] . '" '.$sel.'>' . $value['school_short_name'] . '</option>';
				}
			} else{
				echo '<option value="">School not available</option>';
			}
		}
	}
	
function verify_ht_tr_uni_payments(){
		// Merchant key here as provided by Payu
		$key = "BGdiP5";//"qyt13u";
		$salt = "cynzRXfALgCCW1O2MakDknkMaZ7rOg0A";
		$command = "verify_payment";
		
		//$trdate = date('Y-m-d');
		$trdate = '2023-04-01';
		$trans = $this->Payment_model->getverify_payment($trdate);
		$i=0;
		$j=0;
		foreach($trans as $trns){
		
		
		$var1 = $trns['txtid']; // Transaction ID
		//$var1 = '230415090822-13719'; // Transaction ID


		$hash_str = $key  . '|' . $command . '|' . $var1 . '|' . $salt ;
		$hash = strtolower(hash('sha512', $hash_str));

			$r = array('key' => $key , 'hash' =>$hash , 'var1' => $var1, 'command' => $command);
			//echo $hash;
			
			$qs= http_build_query($r);
			//$wsUrl = "https://test.payu.in/merchant/postservice.php?form=1";
			$wsUrl = "https://info.payu.in/merchant/postservice?form=2";
			$c = curl_init();
			curl_setopt($c, CURLOPT_URL, $wsUrl);
			curl_setopt($c, CURLOPT_POST, 1);
			curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
			curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
			$o = curl_exec($c);
			if (curl_errno($c)) {
			  $sad = curl_error($c);
			  throw new Exception($sad);
			}
			curl_close($c);

			$valueSerialized = @unserialize($o);
			if($o === 'b:0;' || $valueSerialized !== false) {
			 $valueSerialized;
			}
			//echo "<pre>";
			//echo $o;
			$var =json_decode($o,true);
			//print_r($var);exit;
			if($var['transaction_details'][$var1]['status']=='success'){ // if payments is successful
				$data['receipt_no']=$var['transaction_details'][$var1]['udf4'];
				$data['payment_mode']=$var['transaction_details'][$var1]['mode'];
				$data['bank_ref_num']=$var['transaction_details'][$var1]['bank_ref_num'];
				$data['error_code']=$var['transaction_details'][$var1]['error_code'];
				$data['pg_type']=$var['transaction_details'][$var1]['PG_TYPE'];
				$data['payment_status']=$var['transaction_details'][$var1]['status'];
				$data['amount']=$var['transaction_details'][$var1]['transaction_amount'];
				$txtid=$var['transaction_details'][$var1]['txnid'];
				$data['remark']='Update from API for Exam';
				//print_r($data);
				$trans = $this->Payment_model->update_api_payment($data,$txtid);
				$j++;
			}else{
			
			}
			
		$i++;	
		}
		echo $i.' records are updated';
		echo $j.' records are updated';
	}
	
	function verify_exam_failed_fees_payments(){
		
		$DB1 = $this->load->database('umsdb', TRUE);
		$key = "soe5Fh";//"qyt13u";
		$salt = "OhVBBZuL";
		$command = "verify_payment";
		
		$trdate  = date('Y-m-d');
		$exam_id = 42;			
		$trdate  = '2025-11-06';	
		$trans   = $this->Payment_model->getverify_payment_exam($trdate,$exam_id);
		$i=0;
		$j=0;
		foreach($trans as $trns){
		
		//if($trns['txtid']=='230522095534-16079'){
		$var1 = $trns['txtid']; // Transaction ID
		//$var1 = '23010512480630484'; // Transaction ID


		$hash_str = $key  . '|' . $command . '|' . $var1 . '|' . $salt ;
		$hash = strtolower(hash('sha512', $hash_str));

			$r = array('key' => $key , 'hash' =>$hash , 'var1' => $var1, 'command' => $command);
			//echo $hash;
			
			$qs= http_build_query($r);
			//$wsUrl = "https://test.payu.in/merchant/postservice.php?form=1";
			$wsUrl = "https://info.payu.in/merchant/postservice?form=2";
			$c = curl_init();
			curl_setopt($c, CURLOPT_URL, $wsUrl);
			curl_setopt($c, CURLOPT_POST, 1);
			curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
			curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
			$o = curl_exec($c);
			if (curl_errno($c)) {
			  $sad = curl_error($c);
			  throw new Exception($sad);
			}
			curl_close($c);

			$valueSerialized = @unserialize($o);
			if($o === 'b:0;' || $valueSerialized !== false) {
			 $valueSerialized;
			}
			//echo "<pre>";
			//echo $o;
			$var =json_decode($o,true);
			//print_r($var);exit;
			if($var['transaction_details'][$var1]['status']=='success'){ // if payments is successful
				$data['receipt_no']=$var['transaction_details'][$var1]['udf1'];
				$data['payment_mode']=$var['transaction_details'][$var1]['mode'];
				$data['bank_ref_num']=$var['transaction_details'][$var1]['bank_ref_num'];
				$data['error_code']=$var['transaction_details'][$var1]['error_code'];
				$data['pg_type']=$var['transaction_details'][$var1]['PG_TYPE'];
				$data['payment_status']=$var['transaction_details'][$var1]['status'];
				$data['amount']=$var['transaction_details'][$var1]['transaction_amount'];
				echo $txtid=$var['transaction_details'][$var1]['txnid'];	echo '<br>';
				$data['remark']=date('Y-m-d h:i:s').' Update from API for Exam';
				//print_r($var);
				$trans = $this->Payment_model->update_api_payment_exam($data,$txtid);
				
				$get_exam_detail_data = $this->Examination_model->get_exam_detail_data($var['transaction_details'][$var1]['udf2'],$var['transaction_details'][$var1]['udf3'],$var['transaction_details'][$var1]['udf5'],$var['transaction_details'][$var1]['txnid']);
				$check_duplicate_exam_data = $this->Examination_model->check_duplicate_exam_detail_data($var['transaction_details'][$var1]['udf2'],$var['transaction_details'][$var1]['udf3'],$var['transaction_details'][$var1]['udf5'],$var['transaction_details'][$var1]['txnid']);
         //echo '<pre>';
		 //print_r($get_exam_detail_data);exit;
		if(empty($check_duplicate_exam_data)){
		 $insert_exam_details =array(
			"stud_id"=>$get_exam_detail_data[0]['stud_id'],
			"enrollment_no"=>$get_exam_detail_data[0]['enrollment_no'],
			"stream_id"=>$get_exam_detail_data[0]['stream_id'],
			"course_id"=>$get_exam_detail_data[0]['course_id'],
			"semester"=>$get_exam_detail_data[0]['semester'],
			"school_code"=>$get_exam_detail_data[0]['school_code'],
			"exam_fees"=>$get_exam_detail_data[0]['exam_fees'],
			"exam_id" => $get_exam_detail_data[0]['exam_id'],
			"exam_month" => $get_exam_detail_data[0]['exam_month'],
			"exam_year" => $get_exam_detail_data[0]['exam_year'],
			"is_regular_makeup" => $get_exam_detail_data[0]['is_regular_makeup'],
			"exam_fees_paid" => $get_exam_detail_data[0]['exam_fees_paid'],
			"entry_by" => $get_exam_detail_data[0]['entry_by'],
			"txnid" => $var['transaction_details'][$var1]['txnid'],
			"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
			"entry_on" => date("Y-m-d H:i:s"),
			"allow_for_exam" => $get_exam_detail_data[0]['allow_for_exam'],
			"is_active" => 'Y',
		  );
		 
		  $insert_exam_subjects=array(
			"stud_id"=>$get_exam_detail_data[0]['stud_id'],
			"enrollment_no"=>$get_exam_detail_data[0]['enrollment_no'],
			"stream_id"=>$get_exam_detail_data[0]['stream_id'],
			"semester"=>$get_exam_detail_data[0]['semester'],
			"exam_id" => $get_exam_detail_data[0]['exam_id'],
			"exam_month" => $get_exam_detail_data[0]['exam_month'],
			"exam_year" => $get_exam_detail_data[0]['exam_year'],
			"txnid" => $var['transaction_details'][$var1]['txnid'],
			"entry_by" => $this->session->userdata("uid"),
			"entry_from_ip" => $_SERVER['REMOTE_ADDR'],
			"entry_on" => date("Y-m-d H:i:s"),
			"is_absent" => 'N');
	
			$DB1->insert("exam_details", $insert_exam_details); 
			$insert_exam_subjects['allow_for_exam']=$get_exam_detail_data[0]['allow_for_exam'];
			$exam_master_id=$DB1->insert_id(); 
			//echo $DB1->last_query();exit;
			if($exam_master_id !=''){
			 $insert_exam_subjects['exam_master_id'] = $exam_master_id;
			 $get_exam_subject_detail_data = $this->Examination_model->get_exam_subject_detail_data($var['transaction_details'][$var1]['udf2'],$var['transaction_details'][$var1]['udf3'],$var['transaction_details'][$var1]['udf5'],$var['transaction_details'][$var1]['txnid'],$get_exam_detail_data[0]['exam_master_id']);
				for($i=0; $i<count($get_exam_subject_detail_data); $i++){
					$insert_exam_subjects['subject_id']=$get_exam_subject_detail_data[$i]['subject_id'];
					$insert_exam_subjects['subject_code']= $get_exam_subject_detail_data[$i]['subject_code'];
					$insert_exam_subjects['semester']=   $get_exam_subject_detail_data[$i]['semester'];
					$insert_exam_subjects['sub_credits']= $get_exam_subject_detail_data[$i]['sub_credits'];
					$insert_exam_subjects['is_backlog']=  $get_exam_subject_detail_data[$i]['is_backlog'];
					$DB1->insert("exam_applied_subjects", $insert_exam_subjects);
					
				}
			
			}
			////added by jp
			try {
			$this->load->model('Challan_model');
				$prefix = '25SUNR';
				$checkChallanNo = $this->Challan_model->checkChallanNumber_for_callback($prefix);

				if ($checkChallanNo) {
					// Extract numeric part and increment
					$last_numeric = (int)substr($checkChallanNo['exam_session'], -7);
					$new_number = $last_numeric + 1;
				} else {
					$new_number = 1; // First entry for this academic year
				}

				// Format new challan number
				//$formatted_number = str_pad($new_number, 7, '0', STR_PAD_LEFT);
				// $challan_number = $prefix . $formatted_number;
				
				$challan_number = $this->Challan_model->checkChallanNumber_unique($prefix,$new_number);

				// ✅ Check if challan already inserted
				$existingChallan = $DB1->get_where('fees_challan', [
					'receipt_no' => $var['transaction_details'][$var1]['bank_ref_num']
				])->row_array();
				
				// $emp_name = $this->session->userdata("emp_name");
				// print_r($challan_number);exit;
				if (!$existingChallan) {
					// Prepare insert array
					$insert_array = [
						"exam_session"    => $challan_number,
						"enrollment_no"   => $var['transaction_details'][$var1]['udf3'],
						"student_id"      => $var['transaction_details'][$var1]['udf5'],
						"academic_year"   => C_RE_REG_YEAR,
						"type_id"         => 5,
						"challan_status"  => 'PD',
						"is_deleted"      => 'N',
						"exam_monthyear"  => $get_exam_detail_data[0]['exam_month'] . '-' . $get_exam_detail_data[0]['exam_year'],
						"bank_account_id" => 4,
						"college_receiptno" => '',
						"exam_id"         => $var['transaction_details'][$var1]['udf2'],
						"amount"          => $get_exam_detail_data[0]['exam_fees'],
						"Backlog_fees"    => $get_exam_detail_data[0]['exam_fees'],
						"Balance_Amount"  => 0,
						"fees_paid_type"  => 'GATEWAY-ONLINE'.'-'.$var['transaction_details'][$var1]['mode'],
						"TransactionNo"   => $var['transaction_details'][$var1]['bank_ref_num'],
						"TransactionDate" => date('Y-m-d'),
						"receipt_no"      => $var['transaction_details'][$var1]['bank_ref_num'],
						"fees_date"       => date('Y-m-d'),
						"bank_id"         => 19,
						"bank_city"       => 'Nashik',
						"remark"          => '',
						"entry_from_ip"   => $_SERVER['REMOTE_ADDR'],
						"created_by"      => $emp_name,
						"created_on"      => date("Y-m-d H:i:s")
					];

					// Insert into fees_challan
					$DB1->insert("fees_challan", $insert_array);
				}

			} catch (Exception $e) {
				log_message('error', 'Error inserting challan: ' . $e->getMessage());
				echo "Something went wrong while generating challan. Please contact admin.";
			}
		}
		
		 $DB11 = $this->load->database('erpdel', TRUE);
        // $DB11->delete('exam_details_transaction', array('txnid' => $get_exam_detail_data[0]['txnid'],'enrollment_no'=> $get_exam_detail_data[0]['enrollment_no'],'stud_id' =>$get_exam_detail_data[0]['stud_id']));
		//echo $DB11->last_query();exit;
        // $DB11->delete('exam_applied_subjects_transaction', array('txnid' => $get_exam_detail_data[0]['txnid'],'enrollment_no'=> $get_exam_detail_data[0]['enrollment_no'],'stud_id' =>$get_exam_detail_data[0]['stud_id']));
				$j++;
			}else{
			
			}
			
		$i++;	
		unset($var);
		}
		//}
		echo $i.' records are updated';
		echo $j.' records are updated';
	}
	
	
	function genrate_qr_code(){
		
		//exit;
		
		    include_once "phpqrcode/qrlib.php";
			$tempDir = 'uploads/exam/APR2023/QRCode/';
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 0755, true);
			}
			$site_url="https://erp.sandipuniversity.com/";
			
			$student_data = $this->Examination_model->get_exam_student_data();
			for($i=0; $i<count($student_data); $i++){
			$codeContents = $site_url.'check.php?po='.$student_data[$i]['enrollment_no'];
			$fileName = 'qrcode_'.$student_data[$i]['enrollment_no'].'.png';		
			$pngAbsoluteFilePath = $tempDir.$fileName;
			$urlRelativeFilePath = $pngAbsoluteFilePath;
			
			// generating
			//if (!file_exists($pngAbsoluteFilePath)) {
				QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);	
				if (file_exists($pngAbsoluteFilePath)) {
					$src_file = $pngAbsoluteFilePath;
					$bucket_name = 'erp-asset';
					echo $filepath = $pngAbsoluteFilePath;
					$result = $this->awssdk->uploadFile($bucket_name, $filepath, $src_file);
					unlink($filepath);
				}
			}
		
	}
	
	function degree_completed_data(){
	   // $this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
		$this->load->model('Marks_model');
	    $this->data['exam_session']= $this->Marks_model->fetch_exam_allsession();
		//$this->data['exam_session']= $this->Examination_model->fetch_stud_curr_exam();
	    if(!empty($_POST['exam_session'])){
	        
	    $exam_session = $_POST['exam_session'];
	    $exam = explode('-', $exam_session);
	    $exam_month =$exam[0];
	    $exam_year =$exam[1];
		$exam_id =$exam[2];
		//$exam_id =26;
	    $this->data['stud_list']= $this->Examination_model->get_degree_completed_data($exam_month,$exam_year, $exam_id);
	    }
        $this->load->view('header',$this->data);
        $this->load->view($this->view_dir.'degree_completed_data_list',$this->data);
        $this->load->view('footer',$this->data);
        //ob_end_clean();
	}	
	//////////////////////Code for barcode generation////////////
	
	public function update_barcodes_in_exam_applied_data() {
		// echo 11;exit;
		// $exam_id=$exam_id[2];
		$exam_id=42;
        // Fetch exam data from the model (assuming you have a method in your model to fetch exam data)
        //$exam_data = $this->Examination_model->get_exam_data_by_id($exam_id);
		//print_r($exam_data);exit;
        // Check if exam data exists
        //if($exam_data) {       
			// Generate barcodes and update them in the database         
			$this->Examination_model->generate_and_update_barcodes($exam_id);     
			// echo 'hii';exit;
            // Redirect back to the page with success message
			//$this->session->set_flashdata('success', 'Barcodes Updated successfully.');
            // redirect('Examination/download_exam_applied_stud_data');   
		//} 	
	}
	public function generate_barcodes_images() {
		/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
		$exam_id = $this->input->post('exam_id');
		$admission_branch = $this->input->post('admission_branch');
		$semester = $this->input->post('semester');
		$subject_id = $this->input->post('subject_id');

		$this->load->model('Examination_model');

		$barcodes = $this->Examination_model->generate_barcodes($exam_id, $admission_branch, $semester, $subject_id);

		require('code128.class.php');
		include_once "phpqrcode/qrlib.php";
		$generator = new Picqer\Barcode\BarcodeGeneratorPNG();

		$data = [];

		foreach ($barcodes as $barcode) {
			$barcodeImage = 'data:image/png;base64,' . base64_encode($generator->getBarcode($barcode, $generator::TYPE_CODE_128));
			
			$data['barcodess'][] = [
				'image' => $barcodeImage,
				'number' => $barcode, // Assuming the barcode itself is the number
				'enrollment_no' => $barcode['enrollment_no'],
				'subject_code' => $barcode['subject_code']
			];
		}

		// Pass $data to the view
		$this->load->view($this->view_dir.'show_barcodes_view', $data);
	}

	 public function export_to_excel($examsessionn='', $admission_branch='', $subject_id='') {
                // Load the Excel library
                $this->load->library('excel');
                
                // Create a new PHPExcel object
                $spreadsheet = new PHPExcel();
                
                // Get the active sheet
                $sheet = $spreadsheet->getActiveSheet();
                
                // Parse the exam session to get the exam ID
                $exam = explode('-', $examsessionn);
                $exam_id = $exam[2];
                
                // Fetch student details based on these parameters
                $stud_details = $this->Examination_model->getSubjectStudentList_for_attendance_excel($subject_id, $admission_branch, $exam_id);
                $headerStyle = [
                        'font' => [
                                'bold' => true,
                        ],
                        'alignment' => [
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        ],

                ];
                $dataStyle = [
                        'alignment' => [
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        ],
                ];
                // Set headers for the additional information
				// Merge cells and apply styles
				$sheet->mergeCells('A1:B1');
				$sheet->setCellValue('A1', 'Exam Session:')->getStyle('A1')->applyFromArray($headerStyle);
				$sheet->setCellValue('A2', 'Stream:')->getStyle('A2')->applyFromArray($headerStyle);
				$sheet->setCellValue('A3', 'Semester:')->getStyle('A3')->applyFromArray($headerStyle);
				$sheet->setCellValue('A4', 'Date:')->getStyle('A4')->applyFromArray($headerStyle);
				$sheet->setCellValue('A5', 'Subject Code:')->getStyle('A5')->applyFromArray($headerStyle);
				$sheet->setCellValue('A6', 'Subject Name:')->getStyle('A6')->applyFromArray($headerStyle);
				$sheet->setCellValue('A7', 'Time:')->getStyle('A7')->applyFromArray($headerStyle);

				$sheet->setCellValue('B1', $stud_details[0]['exam_month'].'-'.$stud_details[0]['exam_year']);
				$sheet->setCellValue('B2', $stud_details[0]['stream_name']);
				$sheet->setCellValue('B3', $stud_details[0]['semester']);
				$sheet->setCellValue('B4', date('d-m-Y', strtotime($stud_details[0]['exam_date'])));
				$sheet->setCellValue('B5', $stud_details[0]['subject_code']);
				$sheet->setCellValue('B6', $stud_details[0]['subject_name']);
				$sheet->setCellValue('B7', $stud_details[0]['from_time'].'-'.$stud_details[0]['to_time']);

				// Apply data style to the value cells
				$sheet->getStyle('B1:B7')->applyFromArray($dataStyle);
                // Set the table header
                $sheet->setCellValue('A9', 'sr.no.');
                $sheet->setCellValue('B9', 'PRN');
                $sheet->setCellValue('C9', 'Barcode');
                $sheet->setCellValue('D9', 'Student Name');
                $sheet->setCellValue('E9', 'Semester');
                $sheet->setCellValue('F9', 'Attendance');
                $sheet->setCellValue('G9', 'Answer Booklet No');
                $sheet->setCellValue('H9', 'Received');
                $sheet->setCellValue('I9', 'Remark');
        
                // Apply style to headers
                $headerStyle = array(
                        'font' => array(
                                'bold' => true,
                        ),
                        'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        ),
                        'borders' => array(
                                'allborders' => array(
                                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                                ),
                        ),
                        'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'C0C0C0'),
                        ),
                );
        
                $sheet->getStyle('A9:I9')->applyFromArray($headerStyle);
        
                // Apply style to data cells
                $dataStyle = array(
                        'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        ),
                        'borders' => array(
                                'allborders' => array(
                                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                                ),
                        ),
                );
        
                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle('A10:I' . $lastRow)->applyFromArray($dataStyle);
        
                // Fill data
                $row = 10;
                foreach ($stud_details as $index => $stud) {
                        $sheet->setCellValue('A' . $row, $index + 1);
                        $sheet->setCellValue('B' . $row, "'".$stud['enrollment_no']);
                        $barcode_value = "'".$stud['barcode'];
                        $sheet->setCellValue('C' . $row, $barcode_value);
                        $sheet->setCellValue('D' . $row, $stud['first_name'] . ' ' . $stud['middle_name'] . ' ' . $stud['last_name']);
                        $sheet->setCellValue('E' . $row, $stud['semester']);
                        $sheet->setCellValue('F' . $row, $stud['exam_attendance_status'] == 'P' ? 'Present' : 'Absent');
                        $sheet->setCellValue('G' . $row, $stud['ans_bklet_no']);
                        $sheet->setCellValue('H' . $row, $stud['ans_bklt_received_status'] == 'Y' ? 'Yes' : 'No');
                        $sheet->setCellValue('I' . $row, $stud['remark']);
                        $row++;
                }
        
                // Create a writer object
                $writer = new PHPExcel_Writer_Excel2007($spreadsheet);
        
                // Set headers for download
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="exam_attendance_' . date('Ymd_His') . '.xlsx"');
                header('Cache-Control: max-age=0');
        
                // Write the file to output
                $writer->save('php://output');
        }
		
		
 	public function generate_bundle_numbers()
	{
		$exam_id = $this->input->post('exam_id');
		$school_code = $this->input->post('school_code');
		$admission_course = $this->input->post('admission_course');
		$admission_branch = $this->input->post('admission_branch');
		$semester = $this->input->post('semester');
		$subject_id = $this->input->post('subject_id');
		$exam_date = $this->input->post('exam_date');

		if (empty($exam_id) || empty($school_code) || empty($admission_course) || empty($admission_branch) || empty($semester) || empty($subject_id) || empty($exam_date)) {
			echo "All fields are required";
			return;
		}

		$date = DateTime::createFromFormat('Y-m-d', $exam_date);
		if (!$date) {
			echo "Invalid exam date format";
			return;
		}

		$formatted_date = $date->format('dmy'); // Format date to DDMMYY

		// Fetch students based on the provided filters
		$students = $this->Examination_model->get_filtered_students($exam_id, $school_code, $admission_course, $admission_branch, $semester, $subject_id);

		if (empty($students)) {
			echo "No students found for the provided filters";
			return;
		}

		$center_code = $this->Examination_model->get_center_code($exam_id, $school_code);

			//print_r($center_code['ec_id']);exit;

		$center = $center_code['ec_id'];
		$exam_session = $this->Examination_model->get_exam_session($exam_id);

		if (empty($center_code) || empty($exam_session)) {
			echo "Center code or exam session not found";
			return;
		}

		// Fetch the most recent bundle number for the given exam session
		$bundle_recent_sr_no = $this->Examination_model->get_bundle_recent_sr_no($exam_id, $center, $school_code, $admission_branch);

		// 	print_r($bundle_recent_sr_no);exit;
		$starting_sr_no = (!empty($bundle_recent_sr_no)) ? $bundle_recent_sr_no + 1 : 1;

		// Start bundle number generation
		$bundle_prefix = $center_code['ec_id'];
		
		$current_bundle_no = $bundle_prefix . str_pad($starting_sr_no, 4, '0', STR_PAD_LEFT);

		// Check if the generated bundle number already exists
		$check_existing_bundle = $this->Examination_model->check_bundle_number_exists($subject_id, $exam_id, $admission_branch);
		if (!empty($check_existing_bundle)) {
			echo "Error: Bundle number already exists!";
			return;
		}

		$counter = 0;   // Counter to keep track of students in a bundle
		$bundle_sr_no = $starting_sr_no; // Start bundle number sequence 

		foreach ($students as $student) {
			if ($counter == 60) {
				// Increment the bundle sequence after every 60 students
				$bundle_sr_no++;
				$current_bundle_no = $bundle_prefix . str_pad($bundle_sr_no, 4, '0', STR_PAD_LEFT);
				$counter = 0;
			}

			// Update the student's bundle number in the database
			$this->Examination_model->update_bundle_number(
				$student['stud_id'],
				$current_bundle_no,
				$bundle_sr_no,
				$exam_id,
				$school_code,
				$admission_course,
				$admission_branch,
				$semester,
				$subject_id
			);

			$counter++;
		}

		echo "Bundle numbers generated successfully!";
	}
		
}
?>