<?php
ini_set("display_errors", "On");
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Challan_new extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Challan_model_new";
     var $model_name1="Challan_model_new";
    var $model;
    var $view_dir='Challan/';
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
		$this->data['challan_details']=$this->Challan_model->fees_challan_list();
        $this->load->view($this->view_dir.'fees_challan_list',$this->data);
        $this->load->view('footer');
    }  
    public function add_fees_challan_new1()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		$this->load->view($this->view_dir.'add_fees_challan_details',$this->data);
        $this->load->view('footer');
	}
	
	 public function add_fees_challan()
	{
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		$this->load->view($this->view_dir.'add_fees_challan_details_new',$this->data);
        $this->load->view('footer');
	}

	public function edit_challan()
	{
		//ini_set("display_errors", "On");
//error_reporting(1);
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		$this->data['challan_details']=$this->Challan_model->fees_challan_list_byid($this->uri->segment(3));
		//var_dump($this->data['challan_details']);
		//exit();
		$this->load->view($this->view_dir.'edit_fees_challan_details',$this->data);
        $this->load->view('footer');
	}
	
	
	public function students_data()
	{
		$std_details = $this->Challan_model->students_data($_POST);   
		//var_dump($std_details);
	   	echo json_encode(array("std_details"=>$std_details));
	}
    /*
  	public function fees_challan_list()
    {
        $this->load->view('header',$this->data);
		$this->data['challan_details']=$this->Challan_model->fees_challan_list();
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

//$check_current=$this->Challan_model->check_current($_POST);


		$fee_details = $this->Challan_model->get_fee_details($_POST);
		
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

//$check_current=$this->Challan_model->check_current($_POST);
//if($check_current[0]['Total']==0){
	$fee_details = $this->Challan_model->get_fee_details($_POST);
//}else{
	$fee_details_new = $this->Challan_model->fee_details($_POST);
	if(empty($fee_details_new)){
		$details_new=array('fees_id'=>'');
	}else{
		$details_new=$fee_details_new;
		}
//}
//exit;

//exit;
		//$fee_details = $this->Challan_model->get_fee_details($_POST);
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
		$Check_challan=$this->Challan_model->Check_challan($currnt);
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
		}
		$fdate;
		$epayment_type=$_POST['epayment_type'];
		$receipt_number=$_POST['receipt_number'];
		//$TransactionNo=$_POST['TransactionNo'];
		//$TransactionDate=$_POST['TransactionDate'];
		if(isset($_POST['Balance_Amount_check'])){
			$Balance_c="Y";
		}else{
			$Balance_c="N";
		}
///echo $Balance_c;
//exit;
		//Remark
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
        if($_POST['facilty']==2){
		$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
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
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Amount_status"=>$Balance_c,"remark"=>$_POST['Remark']
		);
		}elseif($_POST['facilty']==5){
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"Backlog_fees"=>$_POST['Backlog_Exam'],"Photocopy_fees"=>$_POST['Photocopy_Fees'],
		"Revaluation_Fees"=>$_POST['Revaluation_Fees'],"Exam_LateFees"=>$_POST['Late_Fees'],"amount"=>$_POST['amt'],
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Amount_status"=>$Balance_c,
		"fees_paid_type"=>$_POST['epayment_type'],"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),"remark"=>$_POST['Remark'],
		"created_on"=>date("Y-m-d H:i:s"));
			
		}elseif($_POST['facilty']==10){
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
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
        $last_inserted_id= $this->Challan_model->add_fees_challan_submit($insert_array);
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
			
			if($current_month<=5){
				$month_session="2";
			}else{
				$month_session="1";
			}
			
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);
			$challan_no=$ayear.'SUN'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->Challan_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
		redirect(base_url($this->view_dir));
	}
	
	
	public function External_challan(){
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		//$this->data['challan_details']=$this->Challan_model->fees_challan_list();
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
		
		  $last_inserted_id= $this->Challan_model->add_fees_challan_submit($insert_array);
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
			
			if($current_month<=5){
				$month_session="2";
			}else{
				$month_session="1";
			}
			
			
			
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);
			$challan_no=$ayear.'SUN'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->Challan_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
	    //	redirect(base_url($this->view_dir));
		redirect("Challan/External_challan");
	}
	
	
	public function edit_fees_challan_submit(){
		
		$date = str_replace('/', '-', $_POST['deposit_date']);
		
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
	   $this->Challan_model->add_into_fees_details($insert_array);
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
        $last_inserted_id= $this->Challan_model->update_challan_no($id,$update_array);
		
		
		if($last_inserted_id){
		$this->session->set_flashdata('message1','Fees Challan '.$challan_status.' Successfully.');
		}else{
		$this->session->set_flashdata('message2','Fees Challan Not '.$challan_status.' Successfully.');
		}
		
		redirect(base_url($this->view_dir.'Challan'));
		
		
	}
	
	public function challan_list_by_creteria()
	{
		$std_challan_list=$this->Challan_model_new->fees_challan_list($_POST);
		//print_r($std_challan_list);
		//die;
		echo json_encode(array("std_challan_list"=>$std_challan_list));
	}
	
	public function challan_list_reportview()
	{
		//$std_challan_list=$this->Challan_model_new->fees_challan_list($_POST);
		/*print_r($std_challan_list);
		die;*/
		//$std_challan_list=$std_challan_list;
		$this->data['challan_details']=$this->Challan_model_new->fees_challan_list($_POST);
		//var_dump($this->data['challan_details']);
		//exit();
		$this->load->view($this->view_dir.'ajax_challan_details',$this->data);
	}

	public function challan_list_reportview_daily_report()
	{
		//$std_challan_list=$this->Challan_model_new->fees_challan_list($_POST);
		/*print_r($std_challan_list);
		die;*/
		//$std_challan_list=$std_challan_list;
		$this->data['challan_details']=$this->Challan_model_new->fees_challan_list_daily($_POST);
		//var_dump($this->data['challan_details']);
		//exit();
		echo $this->load->view($this->view_dir.'ajax_challan_details',$this->data);
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
			$std_challan_details=$this->Challan_model->fees_challan_list_byid($fees_id);
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
	public function getchallanlist()
	{
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==40){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);
		$this->data['receipt_typ']=$this->Challan_model_new->challan_rec_list();
		
		//$this->data['challan_details']=$this->Challan_model->fees_challan_list();
        $this->load->view($this->view_dir.'challan_details_list',$this->data);

        $this->load->view('footer');

	}
	public function getchallanlist_daily()
	{
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==40){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);
		$this->data['receipt_typ']=$this->Challan_model_new->challan_rec_list();
		
		//$this->data['challan_details']=$this->Challan_model->fees_challan_list();
        $this->load->view($this->view_dir.'challan_details_list_daily',$this->data);

        $this->load->view('footer');

	}
	//daily challan detailslist
	public function daily_getchallanlist()
	{
		$this->load->view('header',$this->data);
		$this->data['receipt_typ']=$this->Challan_model_new->challan_rec_list();
		
		//$this->data['challan_details']=$this->Challan_model->fees_challan_list();
        $this->load->view($this->view_dir.'daily_challan_details_list',$this->data);

        $this->load->view('footer');

	}

	public function getchallan_list($d)
	{
		
		$this->data['challan_details']=$this->Challan_model_new->fees_challan_list($_POST);
		
		

	}

	//pdf for today mode

	public function download_modefor_today_pdf()
	{
		
		$this->load->library('M_pdf');

		$this->data['challan_details_mode']=$this->Challan_model_new->fees_challan_list_today($_POST);
		$this->data['challan_details']=$this->Challan_model_new->fees_challan_list_pdf($_POST);
	
 		$mpdf=new mPDF('utf-8','A4', 0, '', 20, 20, 10, 10, 9, 9, 'L');
       	$html=$this->load->view($this->view_dir.'ajax_challan_formode_details',$this->data,true);
       	
       	$pdfFilePath ="Payment_Report".time()."-download.pdf";
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath, "D");

		
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////	

	///pdf for daily as per search

	public function download_modefor_today_pdff()
	{
		
		$this->load->library('M_pdf');

		$this->data['challan_details_mode']=$this->Challan_model_new->fees_challan_list_today($_POST);
		$this->data['challan_details']=$this->Challan_model_new->fees_challan_list_pdf($_POST);
	
 		$mpdf=new mPDF('utf-8','A4', 0, '', 20, 20, 10, 10, 9, 9, 'L');
       	$html=$this->load->view($this->view_dir.'ajax_challan_formode_details',$this->data,true);
       	
       	$pdfFilePath ="Payment_Report".time()."-download.pdf";
        $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath, "D");	
	}//end of file






}