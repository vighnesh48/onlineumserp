<?php
//ini_set("display_errors", "On");
//error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Phd_Challan extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Phd_challan_model";
     var $model_name1="Phd_challan_model";
    var $model;
    var $view_dir='Phd_challan/';
    var $data=array();
    public function __construct() 
    {
        global $menudata;
        parent:: __construct();
  //  error_reporting(E_ALL);
//ini_set('display_errors', 1);
        $this->load->helper("url");		
        $this->load->library('form_validation');
        if($this->uri->segment(2)!="" && $this->uri->segment(2)!="submit" && !in_array($this->uri->segment(2), $this->skipActions))
           $title=$this->uri->segment(2);                   //Second segment of uri for action,In case of edit,view,add etc.
       else
           $title=$this->master_arr['index'];
        $this->currentModule=$this->uri->segment(1);        
        $this->data['currentModule']=$this->currentModule;
        $this->data['model_name']=$this->model_name;
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $model = $this->load->model($this->model_name);
        $this->load->model($model_name);
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==40){
		}else{
			redirect('home');
		}
    }
    
    public function index()
    {
        $this->load->view('header',$this->data);
		$this->data['challan_details']=$this->Phd_challan_model->fees_challan_list();
        $this->load->view($this->view_dir.'fees_challan_list',$this->data);
        $this->load->view('footer');
    } 
  /* code by vighnesh */
   public function getchallanlist()
	{
		$this->load->view('header',$this->data);
		$this->data['receipt_typ']=$this->Phd_challan_model->challan_rec_list_new();
		 
		//$this->data['challan_details']=$this->Challan_model->fees_challan_list();
        $this->load->view($this->view_dir.'challan_details_list',$this->data);

        $this->load->view('footer');

	}
	
	public function challan_list_reportview_daily_report()
	{
		//$std_challan_list=$this->Challan_model_new->fees_challan_list($_POST);
		/*print_r($std_challan_list);
		die;*/
		//$std_challan_list=$std_challan_list;
		$this->data['challan_details']=$this->Phd_challan_model->fees_challan_list_daily($_POST);
		//var_dump($this->data['challan_details']);
		//exit();
		 $this->load->view($this->view_dir.'ajax_challan_details',$this->data);
	}

/* code by vighnesh */	
    public function add_fees_challan_new1()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Phd_challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Phd_challan_model->get_depositedto();
		$this->data['academic_details']=$this->Phd_challan_model->get_academic_details();
		$this->data['bank_details']= $this->Phd_challan_model->getbanks();
		$this->load->view($this->view_dir.'add_fees_challan_details',$this->data);
        $this->load->view('footer');
	}
	
	 public function add_fees_challan()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Phd_challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Phd_challan_model->get_depositedto();
		$this->data['academic_details']=$this->Phd_challan_model->get_academic_details();
		$this->data['examsession']=$this->Phd_challan_model->get_examsession();
		$this->data['bank_details']= $this->Phd_challan_model->getbanks();
		$this->load->view($this->view_dir.'add_fees_challan_details_new',$this->data);
        $this->load->view('footer');
	}

	public function edit_challan()
	{
		//ini_set("display_errors", "On");
//error_reporting(1);
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Phd_challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Phd_challan_model->get_depositedto();
		$this->data['bank_details']= $this->Phd_challan_model->getbanks();
		$this->data['academic_details']=$this->Phd_challan_model->get_academic_details();
		$this->data['challan_details']=$this->Phd_challan_model->fees_challan_list_byid($this->uri->segment(3));
		//var_dump($this->data['challan_details']);
		//exit();
		$this->load->view($this->view_dir.'edit_fees_challan_details',$this->data);
        $this->load->view('footer');
	}
	
	
	public function students_data()
	{
		$std_details = $this->Phd_challan_model->students_data($_POST);   
		//var_dump($std_details);
	   	echo json_encode(array("std_details"=>$std_details));
	}
    /*
  	public function fees_challan_list()
    {
        $this->load->view('header',$this->data);
		$this->data['challan_details']=$this->Phd_challan_model->fees_challan_list();
        $this->load->view($this->view_dir.'fees_challan_list',$this->data);
        $this->load->view('footer');
    }  
    */
    
    
    public function get_fee_details()
	{
	 //    error_reporting(E_ALL);
//ini_set('display_errors', 1);

$academic=$_REQUEST['academic'];
$facility=$_REQUEST['facility'];
$enroll=$_REQUEST['enroll'];
$stud=$_REQUEST['stud'];
$curr_yr=$_REQUEST['curr_yr'];

//$check_current=$this->Phd_challan_model->check_current($_POST);


		$fee_details = $this->Phd_challan_model->get_fee_details($_POST);
		
		echo json_encode($fee_details);
	}
	
	
	
	 public function get_fee_details_new()
	{
	 //    error_reporting(E_ALL);
//ini_set('display_errors', 1);

$academic=$_REQUEST['academic'];
$facility=$_REQUEST['facility'];
$enroll=$_REQUEST['enroll'];
$stud=$_REQUEST['stud'];
$curr_yr=$_REQUEST['curr_yr'];
$admission_session=$_REQUEST['admission_session'];
$admission_cycle=$_REQUEST['admission_cycle'];
//$check_current=$this->Phd_challan_model->check_current($_POST);
//if($check_current[0]['Total']==0){
	$fee_details = $this->Phd_challan_model->get_fee_details($_POST);
//}else{
	$fee_details_new = $this->Phd_challan_model->fee_details($_POST);
	if(empty($fee_details_new)){
		$details_new=array('fees_id'=>'');
	}else{
		$details_new=$fee_details_new;
		}
//}
//exit;

//exit;
		//$fee_details = $this->Phd_challan_model->get_fee_details($_POST);
		//$fee=array_push($fee_details,$fee_details_new);
		$artists = array();
array_push($artists, $fee_details, $details_new);
//print_r($artists);
		//print_r($artists);
		//exit;
		
		echo json_encode($artists);
	}
    
    
    public function add_fees_challan_submit()
	{
		$challan_digits=4;
		
		$existing_record = $this->Phd_challan_model->check_existing_record_challan($_POST['student_id'], $_POST['academic'], $_POST['receipt_number'],$_POST['epayment_type']);
		if ($existing_record) {
			$this->session->set_flashdata('message2', 'Fees Challan already Deposited.');
			redirect(base_url($this->view_dir . 'fees_challan_list'));
			exit;
		}
		
		if($_POST['fees_date']=='')
			$fdate=date("Y-m-d");
		else
			$fdate=date("Y-m-d", strtotime($_POST['fees_date'])); 
	//echo '<pre>';	print_r($_POST);
		
	//	exit;
		
		$enroll=$_POST['enroll'];
		$student_id=$_POST['student_id'];
		$academic=$_POST['academic'];
		$facilty=$_POST['facilty'];
		$_POST['depositto'];
		$_POST['category'];
		
		$Balance_Amount=$_POST['Balance_Amount'];
		$tutf=$_POST['tutf'];
		$devf=$_POST['devf'];
		$cauf=$_POST['cauf'];
		$admf=$_POST['admf'];
		$exmf= $_POST['exmf'];
		$unirf= $_POST['unirf'];
		
		$_POST['amt'];
		$refund_paid=$_POST['amth'];
		$Excess_Fees=$_POST['Excess'];
		$_POST['epayment_type'];
		$_POST['receipt_number'];
		$_POST['bank'];
		$_POST['branch'];
		//echo $fdate; exit();
		//////////////////////////////////////////////////////////////////////////////////////////////
		
		$Backlog_Exam=$_POST['Backlog_Exam'];
		$Photocopy_Fees=$_POST['Photocopy_Fees'];
		$Revaluation_Fees=$_POST['Revaluation_Fees'];
		$Late_Fees=$_POST['Late_Fees'];
		
		$OtherFINE_Brekage=$_POST['OtherFINE_Brekage'];
		$Other_Registration=$_POST['Other_Registration'];
		$Other_Late=$_POST['Other_Late'];
		$Other_fees=$_POST['Other_fees'];
		//////////////////////////////////////////////////////////////////////////////////////////////
		$Balance_org=$_POST['Balance_org'];
		$Tuition_org=$_POST['Tuition_org'];
		$development_org=$_POST['development_org'];
		$caution_org=$_POST['caution_org'];
		$admission_org=$_POST['admission_org'];
		$exam_org=$_POST['exam_org'];
		$University_org=$_POST['University_org'];
		//////////////////////////////////////////////////////////////
		$currnt=array('stud'=>$student_id,'enroll'=>$enroll,'facility'=>$facilty,'academic'=>$academic);
		$Check_challan=$this->Phd_challan_model->Check_challan($currnt);
	//	print_r($Check_challan);
		//echo '<br>';
		//echo 'fees_id'.$Check_challan[0]['fees_id'];
		//echo '<br>';
		if(empty($Check_challan[0]['fees_id'])){
			$Balance_pending=$Balance_org - $Balance_Amount;
			$Tuition_pending=$Tuition_org - $tutf;
			
			$development_pending=$development_org - $devf;
			if($this->session->userdata("uid")==2){
			//echo $development_org;echo ' development_org<br>';
			//echo $devf;echo '<br>';
			//echo $development_pending;echo '<br>';
			//exit;
		   }
			
			$caution_pending=$caution_org - $cauf;
			$admission_pending=$admission_org - $admf;
			$exam_pending= $exam_org - $exmf;
			$University_pending=$University_org - $unirf;
			
			if($Balance_pending==0){
				$Balance_Amount_status='Y';
			}else{
				$Balance_Amount_status='N';
			}
			
			
			if($Tuition_pending==0){
				$tution_status='Y';
			}else{
				$tution_status='N';
			}
			
			if($development_pending==0){
			$development_status='Y';
			}else{
			$development_status='N';
			}
			
			if($caution_pending==0){
				$caution_status='Y';
			}else{
				$caution_status='N';
			}
			
			if($admission_pending==0){
				$admission_status='Y';
			}else{
				$admission_status='N';
			}
			
			if($exam_pending==0){
				$exam_status='Y';
			}else{
				$exam_status='N';
			}
			
			if($University_pending==0){
				$university_status='Y';
			}else{
				$university_status='N';
			}
			
		}else{
			
			if($Check_challan[0]['Balance_Amount_status']=="N"){
			$Balance_pending= $Check_challan[0]['Balance_Pending'] - $Balance_Amount;
			}else{
			$Balance_pending= $Check_challan[0]['Balance_Pending'];
			}
			
			
			if($Check_challan[0]['tution_status']=="N"){
			$Tuition_pending= $Check_challan[0]['tution_pending'] - $tutf;
			}else{
			$Tuition_pending= $Check_challan[0]['tution_pending'];
			}
			
			if($Check_challan[0]['development_status']=="N"){
			$development_pending= $Check_challan[0]['development_pending'] - $devf;
			}else{
			$development_pending= $Check_challan[0]['development_pending'];	
			}
			
			if($this->session->userdata("uid")==2){
			//echo $Check_challan[0]['development_pending'];echo ' Check_challan<br>';
			//echo $devf;echo '<br>';
			//echo $development_pending;echo '<br>';
			//exit;
		}
			
			
			if($Check_challan[0]['caution_status']=="N"){
			$caution_pending= $Check_challan[0]['caution_pending'] -  $cauf;
			}else{
			$caution_pending= $Check_challan[0]['caution_pending'];	
			}
			if($Check_challan[0]['admission_status']=="N"){
			$admission_pending= $Check_challan[0]['admission_pending'] - $admf;
			}else{
			$admission_pending= $Check_challan[0]['admission_pending'];	
			}
			if($Check_challan[0]['exam_status']=="N"){
			$exam_pending= $Check_challan[0]['exam_pending'] -  $exmf;
			}else{
			$exam_pending= $Check_challan[0]['exam_pending'];	
			}
			if($Check_challan[0]['university_status']=="N"){
			$University_pending= $Check_challan[0]['university_pending'] - $unirf;
			}else{
			$University_pending= $Check_challan[0]['university_pending'];	
			}
			
			
			
			if($Balance_pending==0){
				$Balance_Amount_status='Y';
			}else{
				$Balance_Amount_status='N';
			}
			
			if($Tuition_pending==0){
				$tution_status='Y';
			}else{
				$tution_status='N';
			}
			
			if($development_pending==0){
			$development_status='Y';
			}else{
			$development_status='N';
			}
			
			if($caution_pending==0){
				$caution_status='Y';
			}else{
				$caution_status='N';
			}
			
			if($admission_pending==0){
				$admission_status='Y';
			}else{
				$admission_status='N';
			}
			
			if($exam_pending==0){
				$exam_status='Y';
			}else{
				$exam_status='N';
			}
			
			if($University_pending==0){
				$university_status='Y';
			}else{
				$university_status='N';
			}
		}
		$fdate;
		$epayment_type=$_POST['epayment_type'];
		$receipt_number=$_POST['receipt_number'];
		//$TransactionNo=$_POST['TransactionNo'];
		//$TransactionDate=$_POST['TransactionDate'];
		/*if(isset($_POST['Balance_Amount_check'])){
			$Balance_c="Y";
		}else{
			$Balance_c="N";
		}*/
///echo $Balance_c;
//exit;
		//Remark
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
        if($_POST['facilty']==2){
		$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"batch"=>$_POST['admission_cycle'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"tution_fees"=>$_POST['tutf'],"development_fees"=>$_POST['devf'],
		"caution_money"=>$_POST['cauf'],"admission_form"=>$_POST['admf'],"exam_fees"=>$_POST['exmf'],
		"university_fees"=>$_POST['unirf'],"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],
		"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"),
		"refund_pay"=>$refund_paid,"Excess_Fees"=>$refund_paid,
		"tution_pending"=>$Tuition_pending,"tution_status"=>$tution_status,
		"development_pending"=>$development_pending,"development_status"=>$development_status,
		"caution_pending"=>$caution_pending,"caution_status"=>$caution_status,
		"admission_pending"=>$admission_pending,"admission_status"=>$admission_status,
		"exam_pending"=>$exam_pending,"exam_status"=>$exam_status,
		"university_pending"=>$University_pending,"university_status"=>$university_status,
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Pending"=>$Balance_pending,"Balance_Amount_status"=>$Balance_Amount_status,"remark"=>$_POST['Remark']
		);
		if($this->session->userdata("uid")==2){
			//print_r($insert_array);
			//exit;
		}
		
		}elseif(($_POST['facilty']==5)||($_POST['facilty']==7)||($_POST['facilty']==8)||($_POST['facilty']==9) ||($_POST['facilty']==13)){
			$exam_mon = $_POST['exam_monthyear'];
            $arr_exammon = explode(':', $exam_mon);
			
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"batch"=>$_POST['admission_cycle'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"Backlog_fees"=>$_POST['Backlog_Exam'],"Photocopy_fees"=>$_POST['Photocopy_Fees'],
		"Revaluation_Fees"=>$_POST['Revaluation_Fees'],"Exam_LateFees"=>$_POST['Late_Fees'],"amount"=>$_POST['amt'],
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Amount_status"=>$Balance_c,"exam_monthyear"=>$arr_exammon[0],"exam_id"=>$arr_exammon[1],
		"fees_paid_type"=>$_POST['epayment_type'],"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),"remark"=>$_POST['Remark'],
		"created_on"=>date("Y-m-d H:i:s"));
			
		}elseif($_POST['facilty']==10){
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"batch"=>$_POST['admission_cycle'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"OtherFINE_Brekage"=>$_POST['OtherFINE_Brekage'],"Other_Registration"=>$_POST['Other_Registration'],
		"Other_Late"=>$_POST['Other_Late'],"Other_fees"=>$_POST['Other_fees'],"amount"=>$_POST['amt'],
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Amount_status"=>$Balance_c,"fees_paid_type"=>$_POST['epayment_type'],
		"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"remark"=>$_POST['Remark'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"));
			
		}
		//echo '<pre>';print_r($insert_array);
		//exit;
        $last_inserted_id= $this->Phd_challan_model->add_fees_challan_submit($insert_array);
		//echo 'last_inserted_id==='.$last_inserted_id;exit();
		if($last_inserted_id)
		{
			if($last_inserted_id>9999)
			{
				$challan_digits=strlen($last_inserted_id);
			}
			
			
			if($_POST['curr_yr']=="1"){
				$addmision_type='A';
			}else{
				$addmision_type='R';
			}
			
			$current_month=date('m');
			
			//if($current_month<=5){
			//	$month_session="2";
			//}else{
				$month_session="1";
			//}
			
			$ayear= substr(2020, -2);  //explode("-",$_POST['academic']);$ayear.
			$challan_no='P'.$ayear.'SUN'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			

			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->Phd_challan_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
		     redirect('phd_Challan');
	}
	
	
	public function External_challan(){
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Phd_challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Phd_challan_model->get_depositedto();
		$this->data['academic_details']=$this->Phd_challan_model->get_academic_details();
		$this->data['bank_details']= $this->Phd_challan_model->getbanks();
		//$this->data['challan_details']=$this->Phd_challan_model->fees_challan_list();
        $this->load->view($this->view_dir.'External_challan',$this->data);
        $this->load->view('footer');
	}
	
	public function External_submit(){
        $challan_digits=4;
		if($_POST['fees_date']=='')
			$fdate=date("Y-m-d");
		else
			$fdate=date("Y-m-d", strtotime($_POST['fees_date'])); 
	//echo '<pre>';	print_r($_POST);
		 $TransactionDate=date("Y-m-d", strtotime($_POST['TransactionDate'])); 
		//exit;
		
		
		
		$guest_name=$_POST['guest_name'];
		$guest_mobile=$_POST['guest_mobile'];
		$guest_organisation=$_POST['guest_organisation'];
		$guest_address=$_POST['guest_address'];
		
		
		
		//echo $fdate; exit();
		//////////////////////////////////////////////////////////////////////////////////////////////
		
		$RegistrationFees=$_POST['RegistrationFees'];
		$OtherFees=$_POST['guest_OtherFees'];
		
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////
		 $insert_array=array(
		"academic_year"=>$_POST['academic'],"type_id"=>'11',"bank_account_id"=>$_POST['depositto'],
		"guest_name"=>$_POST['guest_name'],"guest_mobile"=>$_POST['guest_mobile'],
		"guest_organisation"=>$_POST['guest_organisation'],"guest_address"=>$_POST['guest_address'],
		"guest_RegistrationFees"=>$_POST['guest_RegistrationFees'],"guest_OtherFees"=>$_POST['guest_OtherFees'],
		"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],"TransactionNo"=>$_POST['receipt_number'],
		"TransactionDate"=>$TransactionDate,
		"receipt_no"=>$_POST['receipt_number'],"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"remark"=>$_POST['Remark'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"));
		
		  $last_inserted_id= $this->Phd_challan_model->add_fees_challan_submit($insert_array);
		//echo 'last_inserted_id==='.$last_inserted_id;exit();
		if($last_inserted_id)
		{
			if($last_inserted_id>9999)
			{
				$challan_digits=strlen($last_inserted_id);
			}
			//if($_POST['curr_yr']=="1"){
				$addmision_type='E';
			//}else{
			//	$addmision_type='R';
			//}
			
			$current_month=date('m');
			
			//if($current_month<=5){
			//	$month_session="2";
			//}else{
				$month_session="1";
			//}
			
			
			
			$ayear= substr(2020, -2);  //explode("-",$_POST['academic']);
			$challan_no='P'.$ayear.'SUN'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->Phd_challan_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
	    //	redirect(base_url($this->view_dir));
		redirect("phd_Challan");
	}
	
	
	public function edit_fees_challan_submit(){
		
		$date = str_replace('/', '-', $_POST['deposit_date']);
		$challan_no=$_REQUEST['challan_no'];
		$check_exits=$this->Phd_challan_model->check_exits($challan_no);
		$existing_record = $this->Phd_challan_model->check_existing_facility_fees($_POST['enroll'], $_POST['academic'], $_POST['receipt_number']);
		if ($existing_record) {
				$this->session->set_flashdata('message2', 'Duplicate Transaction No! hence not deposited.');
				redirect('phd_Challan');
				return;
		}
		//print_r($_POST);exit();
		if($check_exits==0)
        {
			if($_POST['challan_status']=='VR'){
			
			if($_POST['epayment_type']=='CASH'){
				
			$paid_type='CHLN';
			$paid_bank=$_POST['su_bank'];
			}else{
			$paid_type=$_POST['epayment_type'];
			$paid_bank=$_POST['bank'];
			}
			
			
			$insert_array=array("student_id"=>$_POST['student_id'],"academic_year"=>$_POST['academic'],
			"type_id"=>$_POST['facilty'],"college_receiptno"=>$_POST['challan_no'],"college_receiptno1"=>'PHD',"amount"=>$_POST['amt'],
			"fees_paid_type"=>$paid_type,"receipt_no"=>$_POST['receipt_number'],"exam_session"=>$_POST['exam_id'],"fees_date"=>date("Y-m-d", strtotime($date)),
			"bank_id"=>$paid_bank,"bank_city"=>$_POST['branch'],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],
			"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
				//var_dump($insert_array);exit();
			$this->Phd_challan_model->add_into_fees_details($insert_array);
		   
		   $this->Phd_challan_model->update_online_status($_POST['receipt_number'],$_POST['amt'],$_POST['student_id']);
			}
		
		}
		//exit();
		
		$update_array=array("challan_status"=>$_POST['challan_status'],"fees_date"=>date("Y-m-d", strtotime($date)),
		"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),
		"modified_on"=>date("Y-m-d H:i:s"));
		
		$challan_status='';
		
		
		if($_POST['challan_status']=='VR'){
		$challan_status='Verified';
		}else if($_POST['challan_status']=='CL'){
		$challan_status='Cancelled';
		}else{
		$challan_status='Pending';
		}
		
		$id=$this->uri->segment(3);
        $last_inserted_id= $this->Phd_challan_model->update_challan_no($id,$update_array);
		
		
		
		if($last_inserted_id){
		$this->session->set_flashdata('message1','Fees Challan '.$challan_status.' Successfully.');
		}else{
		$this->session->set_flashdata('message2','Fees Challan Not '.$challan_status.' Successfully.');
		}
		
		redirect('phd_Challan');
		
		
	}
	
	public function challan_list_by_creteria()
	{
		$std_challan_list=$this->Phd_challan_model->fees_challan_list($_POST);
		echo json_encode(array("std_challan_list"=>$std_challan_list));
	}
	
    public function download_challan_pdf($fees_id)
	{
		//load mPDF library
        
		//$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		//echo $hgp_id.','.$stud_prn.','.$stud_org;exit();
		$this->load->library('m_pdf', $param);
		
		if($fees_id!='')
		{
			$std_challan_details=$this->Phd_challan_model->fees_challan_list_byid($fees_id);
		  //echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
			$this->data['std_challan_details']= $std_challan_details;
		}
//$this->load->view($this->view_dir.'facility_challan_pdf', $this->data);

		$html = $this->load->view($this->view_dir.'facility_challan_pdf', $this->data, true);
		$pdfFilePath = $this->data['std_challan_details']['enrollment_no']."_facilityfee_challan_pdf.pdf";

		//$mpdf->WriteHTML($stylesheet,1);
		//$this->m_pdf->pdf->WriteHTML($stylesheet,1);
		
		//$this->m_pdf->pdf=new mPDF('L','A4-L','','5',5,5,5,5,5,5);
		$this->m_pdf->pdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            5, // margin_left
            5, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer
		$this->m_pdf->pdf->WriteHTML($html);
		//download it.
		$this->m_pdf->pdf->Output($pdfFilePath, "D");
		
		// ob_end_flush(); 
		
	}
	
	public function download_db()
	{
		$this->load->helper('file');

		$data = 'Some file data';
		if ( ! write_file('uploads/sandip_erp.sql', $data))
		{
				echo 'Unable to write the file';
		}
		else
		{
				echo 'File written!';
		}
	}
	
	public function Exam_challan()
	{
		
		$this->load->view('header',$this->data);

		$this->data['challan_details']=$this->Phd_challan_model->examfees_challan_list($_POST);
		$this->load->view($this->view_dir.'examfees_challan_list',$this->data);
	
		 $this->load->view('footer');
		

	}

	public function receipt_list($d)
	{
		//error_reporting(E_ALL);
		$this->load->view('header',$this->data);
			$this->data['receipt_typ']=$this->Phd_challan_model->challan_rec_list();
        $this->load->view($this->view_dir.'chalan_receipt',$this->data);
        $this->load->view('footer');

	}
	public function get_receipt_list(){
		$arr['pst']=$_REQUEST['pst'];
		$arr['styp']=$_REQUEST['styp'];
		$arr['sdt']=$_REQUEST['sdt'];
		$arr['dfrm']=$_REQUEST['dfrm'];
		$arr['dto']=$_REQUEST['dto'];
$this->data['rec_list']=$this->Phd_challan_model->get_recpt_list($arr);
$this->load->view($this->view_dir.'ajax_challen_receipt',$this->data);
	}
	
	public function manual_excel(){
		$this->load->view('header',$this->data);
		 $this->load->view($this->view_dir.'manual_excel',$this->data);
		    $this->load->view('footer');
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////	
public function add_Tuition_ajax(){
	$DB1 = $this->load->database('umsdb', TRUE);
	$prev_balance_amount=$this->input->post('prev_balance_amount');
	$add_Tuition=$this->input->post('add_Tuition');
	$add_Development=$this->input->post('add_Development');
	$add_Caution=$this->input->post('add_Caution');
	
	$add_Admission=$this->input->post('add_Admission');
	$add_Examfees=$this->input->post('add_Examfees');
	$add_University=$this->input->post('add_University');
	
	$enroll=$this->input->post('enroll');
	$student_id=$this->input->post('student_id');
	$academic=$this->input->post('academic');
	
	
	 $sqlcheck="SELECT count(fees_id) as Total FROM fees_challan_phd WHERE academic_year ='".$academic."' AND student_id = '".$student_id."'
			AND type_id= '2'  AND challan_status !='CL' AND type_id='2'
			ORDER BY fees_id DESC limit 0,1";
	       $querycheck = $DB1->query($sqlcheck);
			$resultcheck=$querycheck->row_array();
			//print_r($resultcheck);
		    $check=$resultcheck['Total'];
			
			//exit();
			if($check==0){
	        $add['type_id']="2";
			$add['student_id']=$student_id;
			$add['enrollment_no']=$enroll;	
			//$add['tution_pending']=$add_fee;
			//$add['tution_status']='N';
			if($add_Tuition){
			$add['tution_pending']=$add_Tuition;
			$add['tution_status']='N';
			}
			if($prev_balance_amount){
			$add['Balance_Pending']=$prev_balance_amount;
			$add['Balance_Amount_status']='N';
			}
			if($add_Development){
			$add['development_pending']=$add_Development;
			$add['development_status']='N';
			}
			if($add_Caution){
			$add['caution_pending']=$add_Caution;
			$add['caution_status']='N';
			}
			if($add_Admission){
			$add['admission_form']=$add_Admission;
			$add['admission_status']='N';
			}
			if($add_Examfees){
			$add['exam_fees']=$add_Examfees;
			$add['exam_status']='N';
			}
			if($add_University){
			$add['university_fees']=$add_University;
			$add['university_status']='N';
			}
			
			
			$add['exam_session']='20SUNR000000';
			$add['amount']='0';
			$add['remark']='Demo entrry for challan create';
			$add['challan_status']='PD';
			$add['academic_year']=$academic;
			//$add['amount']='0';
		  //  $DB1->where("fees_id", $fees_id);	
	         $DB1->insert("fees_challan_phd", $add);
			$d=$last_inserted_id=$DB1->insert_id(); 
	
			}else{
	
	$DB1 = $this->load->database('umsdb', TRUE);
			$sql="SELECT *,type_id AS ntype_id FROM fees_challan_phd WHERE academic_year ='".$academic."' AND student_id = '".$student_id."'
			AND type_id= '2'  AND challan_status !='CL' AND type_id='2'
			ORDER BY fees_id DESC limit 0,1";
			$query = $DB1->query($sql);
			$result=$query->row_array();
			 $fees_id=$result['fees_id'];
			//exit();
			$up['tution_pending']=$add_Tuition;
			$up['tution_status']='N';
			
			$up['development_pending']=$add_Development;
			$up['development_status']='N';
			
			$up['caution_pending']=$add_Caution;
			$up['caution_status']='N';
			
			$up['admission_form']=$add_Admission;
			$up['admission_status']='N';
			
			$up['exam_fees']=$add_Examfees;
			$up['exam_status']='N';
			
			$up['university_fees']=$add_University;
			$up['university_status']='N';
			
		$DB1->where("fees_id", $fees_id);	
	    $d=$DB1->update("fees_challan_phd", $up);
		if($d){
			echo '1';
		}else{
			echo '2';
		}
		
			}
	
}
public function check_recepit(){
	
	$DB1 = $this->load->database('umsdb', TRUE);
	$receipt_number=$this->input->post('receipt_number');
	$epayment_type=$this->input->post('epayment_type');
	$sql="select count(fees_id) as Total FROM fees_challan_phd WHERE fees_paid_type='$epayment_type' AND receipt_no='$receipt_number' AND challan_status!='CL'";
    $query=$DB1->query($sql);
	$result=$query->result_array();
	echo $result[0]['Total'];
}
public function Search(){
		$Recepit=$this->input->post('Recepit');
		$Mobile=$this->input->post('Mobile');
		$transactionno=$this->input->post('transactionno');
		$std_challan_list = $this->Phd_challan_model->Search_challan($Recepit, $Mobile, $transactionno);
       // $this->data['challan_details']=$std_challan_list;
		echo json_encode(array("std_challan_list"=>$std_challan_list));
	   // $this->load->view($this->view_dir.'ajax_fees_receipt_list_status',$this->data);
		
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}