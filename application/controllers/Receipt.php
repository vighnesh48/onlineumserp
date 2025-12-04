<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Receipt extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Receipt_model";
     var $model_name1="Receipt_model";
    var $model;
    var $view_dir='Receipt/';
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
		$this->load->model('Challan_model');
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function index()
    {
        $this->load->view('header',$this->data);
		$this->data['challan_details']=$this->Receipt_model->fees_challan_list();
		//print_r($this->data['challan_details']);
        $this->load->view($this->view_dir.'fees_receipt_list',$this->data);
        $this->load->view('footer');
    }  
    public function add_fees_challan_new1()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Receipt_model->get_facility_types();
		$this->data['depositedto_details']=$this->Receipt_model->get_depositedto();
		$this->data['academic_details']=$this->Receipt_model->get_academic_details();
		$this->data['bank_details']= $this->Receipt_model->getbanks();
		$this->load->view($this->view_dir.'add_fees_receipt_details',$this->data);
        $this->load->view('footer');
	}
	
	 public function add_fees_receipt()
	{
		exit();
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Receipt_model->get_facility_types();
		$this->data['depositedto_details']=$this->Receipt_model->get_depositedto();
		$this->data['academic_details']=$this->Receipt_model->get_academic_details();
		$this->data['bank_details']= $this->Receipt_model->getbanks();
		$this->load->view($this->view_dir.'add_fees_receipt_details_new',$this->data);
        $this->load->view('footer');
	}

	public function edit_challan()
	{
		//ini_set("display_errors", "On");
//error_reporting(1);
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Receipt_model->get_facility_types();
		$this->data['depositedto_details']=$this->Receipt_model->get_depositedto();
		$this->data['bank_details']= $this->Receipt_model->getbanks();
		$this->data['academic_details']=$this->Receipt_model->get_academic_details();
		$this->data['challan_details']=$this->Receipt_model->fees_challan_list_byid_edit($this->uri->segment(3));
		//var_dump($this->data['challan_details']);
		//exit();
		$this->load->view($this->view_dir.'edit_fees_receipt_details',$this->data);
        $this->load->view('footer');
	}
	
	
	public function students_data()
	{
		$std_details = $this->Receipt_model->students_data($_POST);   
		//var_dump($std_details);
	   	echo json_encode(array("std_details"=>$std_details));
	}
    /*
  	public function fees_challan_list()
    {
        $this->load->view('header',$this->data);
		$this->data['challan_details']=$this->Receipt_model->fees_challan_list();
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

//$check_current=$this->Receipt_model->check_current($_POST);


		$fee_details = $this->Receipt_model->get_fee_details($_POST);
		
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

//$check_current=$this->Receipt_model->check_current($_POST);
//if($check_current[0]['Total']==0){
	$fee_details = $this->Receipt_model->get_fee_details($_POST);
//}else{
	$fee_details_new = $this->Receipt_model->fee_details($_POST);
	if(empty($fee_details_new)){
		$details_new=array('fees_id'=>'');
	}else{
		$details_new=$fee_details_new;
		}
//}
//exit;

//exit;
		//$fee_details = $this->Receipt_model->get_fee_details($_POST);
		//$fee=array_push($fee_details,$fee_details_new);
		$artists = array();
array_push($artists, $fee_details, $details_new);
//print_r($artists);
		//print_r($artists);
		//exit;
		
		echo json_encode($artists);
	}
    
    
    public function add_fees_receipt_submit()
	{
		$challan_digits=4;
		if($_POST['fees_date']=='')
			$fdate=date("Y-m-d");
		else
			$fdate=date("Y-m-d", strtotime($_POST['fees_date'])); 
	//echo '<pre>';	print_r($_POST);
		
	//	exit;
		
	  /* $enroll=$_POST['enroll'];
		$student_id=$_POST['student_id'];
		$academic=$_POST['academic'];
		$facilty=$_POST['facilty'];
		$_POST['depositto'];
		$_POST['category'];
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
		$Tuition_org=$_POST['Tuition_org'];
		$development_org=$_POST['development_org'];
		$caution_org=$_POST['caution_org'];
		$admission_org=$_POST['admission_org'];
		$exam_org=$_POST['exam_org'];
		$University_org=$_POST['University_org'];
		//////////////////////////////////////////////////////////////
		$currnt=array('stud'=>$student_id,'enroll'=>$enroll,'facility'=>$facilty,'academic'=>$academic);
		$Check_challan=$this->Receipt_model->Check_challan($currnt);
	//	print_r($Check_challan);
		//echo '<br>';
		//echo 'fees_id'.$Check_challan[0]['fees_id'];
		//echo '<br>';
		if(empty($Check_challan[0]['fees_id'])){
			$Tuition_pending=$Tuition_org - $tutf;
			$development_pending=$development_org - $devf;
			$caution_pending=$caution_org - $cauf;
			$admission_pending=$admission_org - $admf;
			$exam_pending= $exam_org - $exmf;
			$University_pending=$University_org - $unirf;
			
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
			
			if($Check_challan[0]['tution_status']=="N"){
			$Tuition_pending= $Check_challan[0]['tution_pending'] - $tutf;
			}else{
			$Tuition_pending= $Check_challan[0]['tution_pending'];
			}
			
			if($Check_challan[0]['development_pending']=="N"){
			$development_pending= $Check_challan[0]['development_pending'] - $devf;
			}else{
			$development_pending= $Check_challan[0]['development_pending'];	
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
		}*/
		
		/*student_id
		Name
		course
		course_id
		current_year
		mobile1
		academic
		depositto
		facilty*/
		//print_r($_POST);
		//exit;
		$fdate;
		$epayment_type=$_POST['epayment_type'];
		$receipt_number=$_POST['receipt_number'];
		//$TransactionNo=$_POST['TransactionNo'];
		//$TransactionDate=$_POST['TransactionDate'];
		
		//Remark
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
        if($_POST['facilty']==2){
		$insert_array=array("enrollment_no"=>'',"student_id"=>$_POST['student_id'],"student_name"=>$_POST['Name'],
		"mobile_no"=>$_POST['mobile_no'],"cousre_name"=>$_POST['course'],"course_id"=>$_POST['course_id'],"curr_year"=>$_POST['current_year'], 
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>'',"tution_fees"=>$_POST['tutf'],"development_fees"=>$_POST['devf'],
		"caution_money"=>$_POST['cauf'],"admission_form"=>$_POST['admf'],"exam_fees"=>$_POST['exmf'],
		"university_fees"=>$_POST['unirf'],"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],
		"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"),
		"refund_pay"=>$refund_paid,"Excess_Fees"=>$refund_paid,
		"tution_pending"=>'',"tution_status"=>'',
		"development_pending"=>'',"development_status"=>'',
		"caution_pending"=>'',"caution_status"=>'',
		"admission_pending"=>'',"admission_status"=>'',
		"exam_pending"=>'',"exam_status"=>'',
		"university_pending"=>'',"university_status"=>'',
		"Balance_Amount"=>$_POST['Balance_Amount'],'Excess_Fees'=>$_POST['Excess'],"remark"=>$_POST['Remark']
		);
		}elseif($_POST['facilty']==5){
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"Backlog_fees"=>$_POST['Backlog_Exam'],"Photocopy_fees"=>$_POST['Photocopy_Fees'],
		"Revaluation_Fees"=>$_POST['Revaluation_Fees'],"Exam_LateFees"=>$_POST['Late_Fees'],"amount"=>$_POST['amt'],"Balance_Amount"=>$_POST['Balance_Amount'],
		"fees_paid_type"=>$_POST['epayment_type'],"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),"remark"=>$_POST['Remark'],
		"created_on"=>date("Y-m-d H:i:s"));
			
		}elseif($_POST['facilty']==10){
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"OtherFINE_Brekage"=>$_POST['OtherFINE_Brekage'],"Other_Registration"=>$_POST['Other_Registration'],
		"Other_Late"=>$_POST['Other_Late'],"Other_fees"=>$_POST['Other_fees'],"amount"=>$_POST['amt'],"Balance_Amount"=>$_POST['Balance_Amount'],"fees_paid_type"=>$_POST['epayment_type'],
		"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"remark"=>$_POST['Remark'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"));
			
		}
		//echo '<pre>';print_r($insert_array);
		//exit;
        $last_inserted_id= $this->Receipt_model->add_fees_challan_submit($insert_array);
		//echo 'last_inserted_id==='.$last_inserted_id;exit();
		if($last_inserted_id)
		{
			if($last_inserted_id>9999)
			{
				$challan_digits=strlen($last_inserted_id);
			}
			
			
			//if($_POST['curr_yr']=="1"){
				$addmision_type='A';
			//}else{
				//$addmision_type='R';
			//}
			
			$current_month=date('m');
			
			//if($current_month<=5){
			//	$month_session="2";
			//}else{
				$month_session="1";
			//}
			
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);
			$challan_no='R'.$ayear.'SUN'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->Receipt_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
		redirect(base_url($this->view_dir));
	}
	
	
	public function External_challan(){
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Receipt_model->get_facility_types();
		$this->data['depositedto_details']=$this->Receipt_model->get_depositedto();
		$this->data['academic_details']=$this->Receipt_model->get_academic_details();
		$this->data['bank_details']= $this->Receipt_model->getbanks();
		//$this->data['challan_details']=$this->Receipt_model->fees_challan_list();
        $this->load->view($this->view_dir.'External_receipt',$this->data);
        $this->load->view('footer');
	}
	
	public function External_submit(){
        $challan_digits=4;
		if($_POST['fees_date']=='')
			$fdate=date("Y-m-d");
		else
			$fdate=date("Y-m-d", strtotime($_POST['fees_date'])); 
	//echo '<pre>';	print_r($_POST);
		
	//	exit;
		
		
		
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
		"TransactionDate"=>$fdate,
		"receipt_no"=>$_POST['receipt_number'],"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"remark"=>$_POST['Remark'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"));
		
		  $last_inserted_id= $this->Receipt_model->add_fees_challan_submit($insert_array);
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
			
			
			
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);
			$challan_no=$ayear.'SUN'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->Receipt_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
	    //	redirect(base_url($this->view_dir));
		redirect("Challan/External_receipt");
	}
	
	
	public function edit_fees_challan_submit(){
		$this->db->trans_begin();
		$uId=$this->session->userdata('uid');

		//print_r($_POST);
		//exit;
		/*if($uId=='2')
		{
			print_r($_POST);
			echo $newDate =date("Y-m-d", strtotime($_POST['fees_date']));
			die;
		}*/
		//print_r($_POST);
		//echo $newDate =date("Y-m-d", strtotime($_POST['fees_date']));
		//exit;
		/*$date = str_replace('/', '-', $_POST['deposit_date']);
		
		if($_POST['challan_status']=='VR'){
		
		if($_POST['epayment_type']=='CASH'){
			
		$paid_type='CHLN';
		$paid_bank=$_POST['su_bank'];
		}else{
		$paid_type=$_POST['epayment_type'];
		$paid_bank=$_POST['bank'];
		}
		
		
		$insert_array=array("student_id"=>$_POST['student_id'],"academic_year"=>$_POST['academic'],
		"type_id"=>$_POST['facilty'],"college_receiptno"=>$_POST['challan_no'],"amount"=>$_POST['amt'],
		"fees_paid_type"=>$paid_type,"receipt_no"=>$_POST['receipt_number'],"fees_date"=>date("Y-m-d", strtotime($date)),
		"bank_id"=>$paid_bank,"bank_city"=>$_POST['branch'],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],
		"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
			//var_dump($insert_array);exit();
	   $this->Receipt_model->add_into_fees_details($insert_array);
		}
		
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
        $last_inserted_id= $this->Receipt_model->update_challan_no($id,$update_array);
		
		
		if($last_inserted_id){
		$this->session->set_flashdata('message1','Fees receipt '.$challan_status.' Successfully.');
		}else{
		$this->session->set_flashdata('message2','Fees receipt Not '.$challan_status.' Successfully.');
		}*/


		 $DB1 = $this->load->database('icdb', TRUE);
        
        //$check_recip=$this->Receipt_model->Recepit_duplicate($_POST['Receiptno']);
 $msg="";

		if($_POST['challan_status']=="VR"){

	 $check_duplicate= $this->Receipt_model->check_duplicate($_POST['Receiptno']);
	if($check_duplicate==0){


		$arr = explode('/', $_POST['fees_date']);
		$feedet1['student_id']=$_POST['stud_id'];
		$feedet1['amount']=$_POST['amt'];
		$feedet1['type_id']=2;
		$feedet1['fees_paid_type']=$_POST['epayment_type'];
		$feedet1['academic_year']= $_POST['academicyear'];
				
		$feedet1['receipt_no']=$_POST['receipt_number']; //Check No ,DDNo
		$feedet1['fees_date']=$_POST['fees_date'];//date("Y-m-d", strtotime($_POST['fees_date'])); //$_POST['fees_date']; 
		$feedet1['bank_id']=$_POST['bank'];//$data['dd_bank'];
		$feedet1['bank_city']=$_POST['branch'];//'branch';//$data['dd_bank_branch'];
		$feedet1['entry_from_ip']=$_SERVER['REMOTE_ADDR'];
		$feedet1['created_on']= date('Y-m-d h:i:s');
		$feedet1['created_by']= $_SESSION['uid'];
		//$feedet1['modified_on']= date('Y-m-d h:i:s');
		//$feedet1['modified_by']= $_SESSION['uid'];
        $feedet1['provisionalre']=$_POST['provisionalNo'];
		$feedet1['remark']=$_POST['remark'];
		$feedet1['college_receiptno']=$_POST['Receiptno']; //Recepit No
		$feedet1['payment_status']="V";
		
		if($payfile !=''){
		$feedet1['receipt_file']=$payfile;
		}
		
        $DB1->insert('provisional_fees_details',$feedet1);
	    $exit_idd=$DB1->insert_id(); 
		
	//print_r($feedet);exit;
//		 $DB1->where('fees_id', $fee_id);
	  



	 
	 $current_date=date('Y-m-d');
	 
	 if($_POST['epayment_type']=="Cash"){
	 $paytype="CHLN";
	 }else{
	 $paytype=$_POST['epayment_type'];
	 }

	 // $arr = explode('/', $_POST['fees_date']);
     $newDate =date("Y-m-d", strtotime($_POST['fees_date']));// $arr[2].'-'.$arr[1].'-'.$arr[0];
	 $ums_student_id = $this->Receipt_model->get_student_id_by_prn($_POST['provisionalNo']);
	
	 if($ums_student_id!=''){
		 $ums_student_id=$ums_student_id;
	 }else{
		 $ums_student_id=$_POST['provisionalNo'];
	 }

	 $insert_array=array("student_id"=>$ums_student_id,"academic_year"=>$_POST['academicyear'],
		"type_id"=>'2',"college_receiptno"=>$_POST['Receiptno'],"amount"=>$_POST['amt'],
		"fees_paid_type"=>$paytype,"receipt_no"=>$_POST['receipt_number'],"fees_date"=>$newDate,
		"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],
		"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"prov_reg_no"=>trim($_POST['provisionalNo']),
		"provisionalre"=>trim($_POST['provisionalNo']),"prov_fees_id"=>$exit_idd,"is_provisional"=>"Y");
			//var_dump($insert_array);exit();
	  $exit_id= $this->Challan_model->add_into_fees_details($insert_array);
	  $msg="Y";
	  //////////////////////////////////////////////////////////////////////////
	}else{
	  $exit_id='';
	  $msg="N";
	}

	 
	 if($exit_id){
	// fees_id
	$DB2 = $this->load->database('umsdb', TRUE);
	$upds['challan_status']='VR';
	$upds['provisionalre']==$_POST['provisionalNo'];
	$DB2->where('fees_id', $_POST['fees_id']);
	$DB2->update('receipt',$upds);
	 }
	 ///////////////////////////////////////////////////////////////////////
	
		}else{
	$DB2 = $this->load->database('umsdb', TRUE);
	$upds['challan_status']='CL';
	$DB2->where('fees_id', $_POST['fees_id']);
	$DB2->update('receipt',$upds);
		}



	if(($_POST['last_status']=="VR")&&($_POST['challan_status']=="CL") )
   {
   $DB3 = $this->load->database('umsdb', TRUE);
    $feesd['chq_cancelled']='Y';
	$DB3->where('college_receiptno', $_POST['Receiptno']);
	$DB3->update('fees_details',$feesd);
   }



	if ($this->db->trans_status() === FALSE)
{
        $this->db->trans_rollback();
        if($msg=="Y"){
$this->session->set_flashdata('message1','Fees receipt '.$challan_status.' Fail. AND Receipt no Alreddy having');
        }else{
$this->session->set_flashdata('message1','Fees receipt '.$challan_status.' Fail.');
        }
		//$this->session->set_flashdata('message1','Fees receipt '.$challan_status.' Fail.');
}
else
{
        $this->db->trans_commit();
		if($_POST['challan_status']=='VR'){
		$challan_status='Verified';
		}else if($_POST['challan_status']=='CL'){
		$challan_status='Cancelled';
		}else{
		$challan_status='Pending';
		}
		
		 if($msg=="Y"){
		
	$this->session->set_flashdata('message1','Fees receipt '.$challan_status.' Not Successfully Receipt no Alreddy having.');
                 }else{
    $this->session->set_flashdata('message1','Fees receipt '.$challan_status.' Successfully.');

                 }
}	
		
	    
		redirect('Receipt');
		
		
	}
	
	public function challan_list_by_creteria()
	{ //$this->load->library('uri');
		 $this->load->library('pagination');
		     $this->load->helper('url');

		 // init params
        $params = array();
        $limit_per_page = 10000;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		if($start_index==0){
		$start_index =$start_index;
		}else{
		$start_index =$this->uri->segment(3)*$limit_per_page;
		}
        $total_records = $this->Receipt_model->get_total($_POST);
		 //////////////////////////////////////////////////////////
		//$std_challan_list=$this->Receipt_model->fees_challan_list_status($_POST);
		//$this->data['challan_details']=$std_challan_list;
		if ($total_records > 0) 
        {
            // get current page records
            
            $config['base_url'] = base_url() . 'Receipt/challan_list_by_creteria';
            $config['total_rows'] = $total_records;
		    $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
			$config['use_page_numbers'] = TRUE;

             $config['full_tag_open'] = '<ul class="pagination">';
 $config['full_tag_close'] = '</ul>';
 $config['prev_link'] = '&laquo;';
 $config['prev_tag_open'] = '<li>';
 $config['prev_tag_close'] = '</li>';
 $config['next_tag_open'] = '<li>';
 $config['next_tag_close'] = '</li>';
 $config['cur_tag_open'] = '<li class="active"><a href="#">';
 $config['cur_tag_close'] = '</a></li>';
 $config['num_tag_open'] = '<li>';
 $config['num_tag_close'] = '</li>';

$config['next_link'] = '&raquo;';
            
			
			
			
			
			
            $this->pagination->initialize($config,true);
			$this->data["links"] = $this->pagination->create_links();
			$std_challan_list = $this->Receipt_model->fees_challan_list_status($limit_per_page, $start_index,$_POST);
            $this->data['challan_details']=$std_challan_list;
             
            // build paging links
            
        }
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////

		 echo $this->load->view($this->view_dir.'ajax_fees_receipt_list_status',$this->data);
		//echo json_encode(array("std_challan_list"=>$std_challan_list));
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
			$std_challan_details=$this->Receipt_model->fees_challan_list_byid($fees_id);
		  //echo json_encode(array("std_gatepass_details"=>$std_gatepass_details));
			$this->data['std_challan_details']= $std_challan_details;
		}
//$this->load->view($this->view_dir.'facility_challan_pdf', $this->data);

		$html = $this->load->view($this->view_dir.'facility_receipt_pdf', $this->data, true);
		$pdfFilePath = $this->data['std_challan_details']['exam_session']."_Recepit_pdf.pdf";

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
	public function check_new(){
	echo	$std_challan_details=$this->Receipt_model->check_new();
	}
	
	public function check_provision(){
		$provisionalNo=$this->input->post('provisionalNo');
		 //$this->Receipt_model->check_provision($provisionalNo);
		 $this->Receipt_model->check_provision($provisionalNo);
	}
	public function Payment_update_fees_details(){
		$DB1 = $this->load->database('icdb', TRUE);
	
		//echo 'One';
		$sql="SELECT * FROM provisional_fees_details WHERE college_receiptno IN('R19SUNA10312',
'R19SUNA10319',
'R19SUNA10321',
'R19SUNA10323',
'R19SUNA10336',
'R19SUNA10332',
'R19SUNA10284',
'R19SUNA10334',
'R19SUNA10335',
'R19SUNA10277',
'R19SUNA10294',
'R19SUNA10272',
'R19SUNA10305',
'R19SUNA10281',
'R19SUNA10290',
'R19SUNA10286',
'R19SUNA10292',
'R19SUNA10318',
'R19SUNA10350',
'R19SUNA10298',
'R19SUNA10296',
'R19SUNA10349',
'R19SUNA10345',
'R19SUNA10315',
'R19SUNA10351',
'R19SUNA10322',
'R19SUNA10306',
'R19SUNA10320',
'R19SUNA10333',
'R19SUNA10326',
'R19SUNA10340',
'R19SUNA10337',
'R19SUNA10328',
'R19SUNA10302',
'R19SUNA10344',
'R19SUNA10347',
'R19SUNA10348',
'R19SUNA10329',
'R19SUNA10342',
'R19SUNA10343',
'R19SUNA10341',
'R19SUNA10339',
'R19SUNA10331',
'R19SUNA10316')";
		$query = $DB1->query($sql);
		$row=$query->result_array();
		//print_r($query);
		//exit;
		foreach($row as $list){
	echo $check_duplicate= $this->Receipt_model->check_duplicate($list['student_id'],$list['collage_receiptno'],$list['amount']);
	//echo $list['student_id'];
	//exit;
	if($check_duplicate==0){
	 $current_date=date('Y-m-d');
	 //echo $list['fees_date'];
	 // $date = new DateTime($list['fees_date']);
	 $arr = explode('/', $list['fees_date']);
     $newDate = $arr[2].'-'.$arr[1].'-'.$arr[0];
	 //$newdate=$date->format('d-m-Y');
	 
	 $insert_array=array("student_id"=>$list['student_id'],"academic_year"=>$list['academic_year'],
		"type_id"=>$list['type_id'],"college_receiptno"=>$list['college_receiptno'],"amount"=>$list['amount'],
		"fees_paid_type"=>$list['fees_paid_type'],"receipt_no"=>$list['receipt_no'],"fees_date"=>$newDate,
		"bank_id"=>$list['bank_id'],"bank_city"=>$list['bank_city'],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],
		"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"),"prov_reg_no"=>$_POST['provisionalNo'],
		"provisionalre"=>$_POST['provisionalNo'],"is_provisional"=>"Y");
			var_dump($insert_array);exit();
	  $exit_id[]= $this->Challan_model->add_into_fees_details($insert_array);
	}else{
	//echo  $exit_id='';
	}
		}
		print_r($exit_id);
		echo count($exit_id);
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////	

public function Test()
	{ 
	
	$newh=($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	
	//echo "TEST".$newh;
	//exit();
	//$this->load->library('uri');
		$this->load->library('pagination_kiran');
		$this->load->helper('url');
        $data['status']='VR';
		$config = array();

		 // init params
        $params = array();
        $limit_per_page = 50;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		if($start_index==0){
		$start_index =$start_index;
		}else{
		$start_index =$this->uri->segment(3)*$limit_per_page;
		}
		//echo $start_index;
        $total_records = $this->Receipt_model->get_total($data);
		 //////////////////////////////////////////////////////////
		//$std_challan_list=$this->Receipt_model->fees_challan_list_status($_POST);
		//$this->data['challan_details']=$std_challan_list;
		if ($total_records > 0) 
        {
            // get current page records
            
            $config['base_url'] = base_url() . 'Receipt/Test_ajax';
            $config['total_rows'] = $total_records;
		    $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
			$config['use_page_numbers'] = TRUE;


            $config['full_tag_open'] = '<ul class="pagination">';
 $config['full_tag_close'] = '</ul>';
 $config['prev_link'] = '&laquo;';
 $config['prev_tag_open'] = '<li>';
 $config['prev_tag_close'] = '</li>';
 $config['next_tag_open'] = '<li>';
 $config['next_tag_close'] = '</li>';
 $config['cur_tag_open'] = '<li class="active"><a href="#">';
 $config['cur_tag_close'] = '</a></li>';
 $config['num_tag_open'] = '<li>';
 $config['num_tag_close'] = '</li>';

$config['next_link'] = '&raquo;';
            
            $this->pagination_kiran->initialize($config,true);
			$this->data["links"] = $this->pagination_kiran->create_links();
			$std_challan_list = $this->Receipt_model->fees_challan_list_status_test($limit_per_page, $start_index,$data);
            $this->data['challan_details']=$std_challan_list;
             
            // build paging links
            
        }
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////
          $this->load->view('header',$this->data);
		  $this->load->view($this->view_dir.'Test',$this->data);
		  $this->load->view('footer');
		//echo json_encode(array("std_challan_list"=>$std_challan_list));
	}
	public function Search(){
		$Recepit=$this->input->post('Recepit');
		$Mobile=$this->input->post('Mobile');
		$std_challan_list = $this->Receipt_model->Search($Recepit, $Mobile);
        $this->data['challan_details']=$std_challan_list;
	    $this->load->view($this->view_dir.'ajax_fees_receipt_list_status',$this->data);
		
	}
	public function Test_ajax()
	{ 
	
	$newh=($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	
	//echo "TEST".$newh;
	//exit();
	//$this->load->library('uri');
		$this->load->library('pagination_kiran');
		$this->load->helper('url');
        $data['status']='VR';
		$config = array();

		 // init params
        $params = array();
        $limit_per_page = 50;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		if($start_index==0){
		$start_index =$start_index;
		}else{
		$start_index =$this->uri->segment(3)*$limit_per_page;
		}
		//echo $start_index;
        $total_records = $this->Receipt_model->get_total($data);
		 //////////////////////////////////////////////////////////
		//$std_challan_list=$this->Receipt_model->fees_challan_list_status($_POST);
		//$this->data['challan_details']=$std_challan_list;
		if ($total_records > 0) 
        {
            // get current page records
            
            $config['base_url'] = base_url() . 'Receipt/Test_ajax';
            $config['total_rows'] = $total_records;
		    $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
			$config['use_page_numbers'] = TRUE;


            $config['full_tag_open'] = '<ul class="pagination">';
 $config['full_tag_close'] = '</ul>';
 $config['prev_link'] = '&laquo;';
 $config['prev_tag_open'] = '<li>';
 $config['prev_tag_close'] = '</li>';
 $config['next_tag_open'] = '<li>';
 $config['next_tag_close'] = '</li>';
 $config['cur_tag_open'] = '<li class="active"><a href="#">';
 $config['cur_tag_close'] = '</a></li>';
 $config['num_tag_open'] = '<li>';
 $config['num_tag_close'] = '</li>';

$config['next_link'] = '&raquo;';
            
            $this->pagination_kiran->initialize($config,true);
			$this->data["links"] = $this->pagination_kiran->create_links();
			$std_challan_list = $this->Receipt_model->fees_challan_list_status_test($limit_per_page, $start_index,$data);
            $this->data['challan_details']=$std_challan_list;
             
            // build paging links
            
        }
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////
         // $this->load->view('header',$this->data);
		  $this->load->view($this->view_dir.'Test_ajax',$this->data);
		//  $this->load->view('footer');
		//echo json_encode(array("std_challan_list"=>$std_challan_list));
	}
	
	
	
	
	function recepit_check(){
		$this->load->view('header',$this->data);
		$this->data['challan_details']=$this->Receipt_model->fees_challan_list();
		//print_r($this->data['challan_details']);
        $this->load->view($this->view_dir.'recepit_check',$this->data);
        $this->load->view('footer');
	}
	
	public function check_Search(){
		$Recepit=$this->input->post('Recepit');
		$Mobile=$this->input->post('Mobile');
		$std_challan_list = $this->Receipt_model->check_Search($Recepit, $Mobile);
        $this->data['challan_details']=$std_challan_list;
		//$this->load->view($this->view_dir.'recepit_check',$this->data);
	    $this->load->view($this->view_dir.'recepit_result',$this->data);
		
	}
	
	public function receipt_checklist($d)
	{
		//error_reporting(E_ALL);
		$this->load->view('header',$this->data);
		$this->data['receipt_checklist']=$this->Receipt_model->receipt_checklist();
        $this->load->view($this->view_dir.'check_recepit_list',$this->data);
        $this->load->view('footer');

	}
	
////////////////////////////////////////////////////////////////////////////////////////////
}