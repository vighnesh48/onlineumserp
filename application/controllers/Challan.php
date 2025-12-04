<?php
//ini_set("display_errors", "On");
//error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class Challan extends CI_Controller 
{
    var $currentModule="";
    var $title="";
    var $model_name="Challan_model";
     var $model_name1="Challan_model";
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
        $menu_name=$this->uri->segment(1);        
        $this->data['my_privileges']=$this->retrieve_privileges($menu_name);
    }
    
    public function index()
    {
		//echo $this->session->userdata("role_id");exit;
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==40 || $this->session->userdata("role_id")==66){
			//echo 11;exit;
		}else{
			redirect('home');
		}
        $this->load->view('header',$this->data);
		$this->load->model('Ums_admission_model');
		$this->data['school_list'] = $this->Ums_admission_model->list_schools();

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
		if($this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6 || $this->session->userdata("role_id")==40){
		}else{
			redirect('home');
		}
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		$this->load->view($this->view_dir.'add_fees_challan_details_new',$this->data);
        $this->load->view('footer');
	}



    public function add_fees_challan_internationl()
	{
		
		
	$ch = curl_init();
   // $sms=$sms_message;
    $query="?base=USD";
	curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
    //curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'https://api.exchangeratesapi.io/latest?base=USD'); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);
	$n=json_decode($res);
		//print_r($n);
		 number_format($n->rates->INR,2);
   $this->data['current_rate']= number_format($n->rates->INR,2);
		 //exit;
		
		
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		$this->data['examsession']=$this->Challan_model->get_examsession();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		$this->load->view($this->view_dir.'add_fees_challan_details_internationl',$this->data);
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

	public function deposite_fees_challan_submit()
	{
		// echo $this->session->userdata("emp_name");exit;
		$fees_ids = $this->input->post('fees_id'); 
		// $status = $this->input->post('challan_status');  
		$status = 'VR'; 
		// $date = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['deposit_date'])));
		$date = date("Y-m-d");
		$emp_name = $this->session->userdata("emp_name");
		$created_by = $this->session->userdata("uid");
		$ip = $_SERVER['REMOTE_ADDR'];
	
		if ($status == 'VR' && is_array($fees_ids)) {
			foreach ($fees_ids as $fees_id) {
				
				$challan = $this->db->get_where('sandipun_ums.fees_challan', ['fees_id' => $fees_id])->row_array();
			//	echo "<pre>";print_r($challan);exit;
				if (!$challan) continue;
				$receipt_no_base = $challan['receipt_no'] ?? '';
				        // ✅ Check if record already exists in fees_details
				$exists = $this->db
					->where('receipt_no', $receipt_no_base)
					->where('student_id', $challan['student_id'])
					->where('amount', $challan['amount'])
					->get('sandipun_ums.fees_details')
					->row_array();

				if (!$exists) {
					$insert_array = [
						"type_id" => $challan['type_id'],
						"student_id" => $challan['student_id'],
						"fees_paid_type" =>  $challan['fees_paid_type'],
						"receipt_no" => $receipt_no_base, 
						"amount" => $challan['amount'],
						"deposited_date" => $date,
						"fees_date" => $challan['fees_date'],
						"bank_id" =>   $challan['bank_id'],
						"bank_city" => $challan['bank_city'],
						"academic_year" => $challan['academic_year'],
						"exam_session" => $challan['exam_id'],
						"entry_from_ip" => $ip,
						"created_by" => $created_by,
						"created_on" => date("Y-m-d H:i:s"),
						"college_receiptno" => $challan['exam_session'] ?? ''
					]; 
					// echo "<pre>";print_r($insert_array);exit;
					$this->db->insert('sandipun_ums.fees_details', $insert_array);
					// echo $this->db->last_query(); die;
				}
				$update_array = [
					"challan_status" => $status,
					"fees_date" => $date,
					"modify_from_ip" => $ip,
				   // "created_by"     => $emp_name,
					"modified_by" => $created_by,
					"modified_on" => date("Y-m-d H:i:s")
				];
				$this->db->where('fees_id', $fees_id)->update('sandipun_ums.fees_challan', $update_array); 
	
				 $this->Challan_model->update_online_payment($insert_array['receipt_no'], $challan['student_id'], $challan['amount']);
			}
	
			$this->session->set_flashdata('message1', 'Selected Challans Deposited Successfully.');
		} else {
			$this->session->set_flashdata('message2', 'No Challans Deposited. Invalid input or status.');
		}
	
		redirect('Challan');
	}



		public function edit_challan_international()
	{
		//ini_set("display_errors", "On");
//error_reporting(1);
		$this->load->view('header',$this->data);
		$this->data['facility_details']=$this->Challan_model->get_facility_types();
		$this->data['depositedto_details']=$this->Challan_model->get_depositedto();
		$this->data['bank_details']= $this->Challan_model->getbanks();
		$this->data['academic_details']=$this->Challan_model->get_academic_details();
		$this->data['challan_details']=$this->Challan_model->fees_internationalchallan_list_byid($this->uri->segment(3));
		//var_dump($this->data['challan_details']);
		//exit();
		$this->load->view($this->view_dir.'edit_fees_challan__internationaldetails',$this->data);
        $this->load->view('footer');
	}
	
	
	public function students_data()
	{
		$std_details = $this->Challan_model->students_data($_POST);   
		//var_dump($std_details);
	   	echo json_encode(array("std_details"=>$std_details));
	}
	public function students_data_international()
	{
		$std_details = $this->Challan_model->students_data_international($_POST);   
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

	public function get_fee_details_international()
	{
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
	$fee_details_new = $this->Challan_model->fee_details_international($_POST);
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
		
		$existing_record = $this->Challan_model->check_existing_record_challan($_POST['student_id'], $_POST['academic'], $_POST['receipt_number'],$_POST['epayment_type']);
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
		$pkgf=$_POST['pkgf'];
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
		$package_org=$_POST['package_org'];
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
			
			$Balance_pending=$Balance_org - $Balance_Amount;
			$Tuition_pending=$Tuition_org - $tutf;
			$package_pending=$package_org - $pkgf;
			
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
			if($Check_challan[0]['package_fees_status']=="N"){
			$package_pending= $Check_challan[0]['package_fees_pending'] - $pkgf;
			}else{
			$package_pending= $Check_challan[0]['package_fees_pending'];
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
			if($package_pending==0){
				$package_fees_status='Y';
			}else{
				$package_fees_status='N';
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
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"tution_fees"=>$_POST['tutf'],"package_fees"=>$_POST['pkgf'],"development_fees"=>$_POST['devf'],
		"caution_money"=>$_POST['cauf'],"admission_form"=>$_POST['admf'],"exam_fees"=>$_POST['exmf'],
		"university_fees"=>$_POST['unirf'],"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],
		"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"),
		"refund_pay"=>$refund_paid,"Excess_Fees"=>$refund_paid,
		"tution_pending"=>$Tuition_pending,"tution_status"=>$tution_status,"package_fees_pending"=>$package_pending,"package_fees_status"=>$package_fees_status,
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
		
		}elseif(($_POST['facilty']==5)||($_POST['facilty']==7)||($_POST['facilty']==8)||($_POST['facilty']==9)||($_POST['facilty']==13) ||($_POST['facilty']==22)){
			$exam_mon = $_POST['exam_monthyear'];
            $arr_exammon = explode(':', $exam_mon);
			
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"Backlog_fees"=>$_POST['Backlog_Exam'],"Photocopy_fees"=>$_POST['Photocopy_Fees'],"degree_certificate_fees"=>$_POST['degree_certificate_fees'],
		"Revaluation_Fees"=>$_POST['Revaluation_Fees'],"Exam_LateFees"=>$_POST['Late_Fees'],"amount"=>$_POST['amt'],
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Amount_status"=>$Balance_c,"exam_monthyear"=>$arr_exammon[0],"exam_id"=>$arr_exammon[1],"Other_fees"=>$_POST['Certificate_fees'], 
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
			
			//if($current_month<=5){
			//	$month_session="2";
			//}else{
				$month_session="1";
			//}
			
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);$ayear.
			$challan_no=$ayear.'SUN'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->Challan_model->update_challan_no($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
		     redirect('Challan');
	}





	public function add_fees_challan_international_submit()
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
		$Check_challan=$this->Challan_model->Check_challan_international($currnt);
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
		"accommodation"=>$_POST['Accommodation'],
		"university_pending"=>$University_pending,"university_status"=>$university_status,
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Pending"=>$Balance_pending,"Balance_Amount_status"=>$Balance_Amount_status,"remark"=>$_POST['Remark']
		);
		if($this->session->userdata("uid")==2){
			//print_r($insert_array);
			//exit;
		}
		
		}elseif(($_POST['facilty']==5)||($_POST['facilty']==7)||($_POST['facilty']==8)||($_POST['facilty']==9)){
			$exam_mon = $_POST['exam_monthyear'];
            $arr_exammon = explode(':', $exam_mon);
			
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"Backlog_fees"=>$_POST['Backlog_Exam'],"Photocopy_fees"=>$_POST['Photocopy_Fees'],
		"Revaluation_Fees"=>$_POST['Revaluation_Fees'],"Exam_LateFees"=>$_POST['Late_Fees'],"amount"=>$_POST['amt'],
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Amount_status"=>$Balance_c,"exam_monthyear"=>$arr_exammon[0],"exam_id"=>$arr_exammon[1],
		"fees_paid_type"=>$_POST['epayment_type'],"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),"remark"=>$_POST['Remark'],
		"accommodation"=>$_POST['Accommodation'],
		"created_on"=>date("Y-m-d H:i:s"));
			
		}elseif($_POST['facilty']==10){
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"OtherFINE_Brekage"=>$_POST['OtherFINE_Brekage'],"Other_Registration"=>$_POST['Other_Registration'],
		"Other_Late"=>$_POST['Other_Late'],"Other_fees"=>$_POST['Other_fees'],"amount"=>$_POST['amt'],
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Amount_status"=>$Balance_c,"fees_paid_type"=>$_POST['epayment_type'],
		"accommodation"=>$_POST['Accommodation'],
		"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"remark"=>$_POST['Remark'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"));
			
		}
		//echo '<pre>';print_r($insert_array);
		//exit;
        $last_inserted_id= $this->Challan_model->add_fees_challan_international_submit($insert_array);
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
			
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);$ayear.
			$challan_no=$ayear.'SUN'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->Challan_model->update_challan_no_international($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
		     redirect('challan/challan_international_list');
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
			
			//if($current_month<=5){
			//	$month_session="2";
			//}else{
				$month_session="1";
			//}
			
			
			
			$ayear= substr(C_RE_REG_YEAR, -2);  //explode("-",$_POST['academic']);
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
	
		function get_student_detail_by_prn_new($stud_id){
	//echo 'enrollment_no'.($enrollment_no);//exit;
        $DB1 = $this->load->database('umsdb', TRUE);
		$DB1->select("stud_id,enrollment_no,first_name,mobile");
		$DB1->from('student_master');
		$DB1->where("stud_id", $stud_id);
		$query=$DB1->get();
		$result=$query->row_array();
		return $result;
        

}
	
	
	
	
	public function edit_fees_challan_submit(){
		
		$date = str_replace('/', '-', $_POST['deposit_date']);
		$fees_date=date("Y-m-d", strtotime($date));
		$opening_balance='';
		$challan_no=$_REQUEST['challan_no'];
		$check_exits=$this->Challan_model->check_exits($challan_no,$_POST['epayment_type'],$fees_date);
		$existing_record = $this->Challan_model->check_existing_facility_fees($_POST['enroll'], $_POST['academic'], $_POST['receipt_number'],$_POST['epayment_type'],$fees_date);
		if ($existing_record) {
				$this->session->set_flashdata('message2', 'Fees Challan Receipt No/Challan No is already Present. Please check.');
				redirect(base_url($this->view_dir));
				return;
		}
		//$check_exits=0;
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
				if($_POST['facilty']==5){
					$insert_array['exam_session'] =$_POST['exam_session'];
				}
				
				$insert_array=array("student_id"=>$_POST['student_id'],"academic_year"=>$_POST['academic'],"exam_session"=>$_POST['exam_id'],
				"type_id"=>$_POST['facilty'],"college_receiptno"=>$_POST['challan_no'],"amount"=>$_POST['amt'],
				"fees_paid_type"=>$paid_type,"receipt_no"=>$_POST['receipt_number'],"fees_date"=>date("Y-m-d", strtotime($date)),
				"bank_id"=>$paid_bank,"bank_city"=>$_POST['branch'],"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],
				"created_by"=>$this->session->userdata("uid"),"created_on"=>date("Y-m-d H:i:s"));
					//var_dump($insert_array);exit();
			  $add_into= $this->Challan_model->add_into_fees_details($insert_array);
			   if($_POST['student_id']==12284){
				   //echo 'inside--';print_r($insert_array);exit;
			   }
			   if($_POST['Previouspaid']!=0){
			   $d=$this->Challan_model->get_opening_balnce($_POST['academic'],$_POST['enroll'],$_POST['student_id']);//Balance_Amount
			   $opening_balance=($d[0]['opening_balance']-$_POST['Previouspaid']); //
			   $update_opening=array("opening_balance"=>$opening_balance);
			   //$last_inserted_id= $this->Challan_model->update_opening($_POST['academic'],$_POST['enroll'],$_POST['student_id'],$update_opening);
			   }
		   
			}
		}else{
			echo "Duplicate Challan no";exit;
		}
		$update_array=array("challan_status"=>$_POST['challan_status'],"fees_date"=>date("Y-m-d", strtotime($date)),
		"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),
		"modified_on"=>date("Y-m-d H:i:s"));
		
	
		$id=$this->uri->segment(3);
        $last_inserted_id= $this->Challan_model->update_challan_no($id,$update_array);


        if(($_POST['challan_status']=='CL')&&($_POST['current_status']=='VR')){
		$update_array_f=array("chq_cancelled"=>'Y',"is_deleted"=>'Y',
		"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),
		"modified_on"=>date("Y-m-d H:i:s"));
		$last_inserted_id= $this->Challan_model->update_fees_details($_POST,$update_array_f);
		$update_cancellation=$this->challan_model->update_fees_challan_details($_POST);
		
		}

		if(($_POST['challan_status']=='CL')&&($_POST['current_status']=='PD'))
		{
			
			$update_array_f=array("chq_cancelled"=>'Y',"is_deleted"=>'Y',
			"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),
			"modified_on"=>date("Y-m-d H:i:s"));

				$last_inserted_id= $this->Challan_model->update_fees_details($_POST,$update_array_f);
			////////new concept//while cancel

			$update_array=array("challan_status"=>$_POST['challan_status'],"fees_date"=>date("Y-m-d", strtotime($date)),
			"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),
			"modified_on"=>date("Y-m-d H:i:s"));
			
		
			$id=$this->uri->segment(3);
	        $last_inserted_id= $this->Challan_model->update_challan_no($id,$update_array);



		////end

		}


		
		$challan_status='';

		if($_POST['challan_status']=='VR'){
		$last_online_payment= $this->Challan_model->update_online_payment($_POST['receipt_number'],$_POST['student_id'],$_POST['amt']);
		$challan_status='Verified';
		/*$udet = $this->get_student_detail_by_prn_new($_POST['student_id']);
		if($udet['mobile']!='')
{
	$mobile= $udet['mobile'];
	$amn=$_POST['amt'];
	$sms_message ="Dear Student
Amount Rs $amn Verified by Account Section.
Thank you
Sandip University.
";
$sms=urlencode($sms_message);
    //$smsGatewayUrl = "http://apivm.valuemobo.com/SMS/SMS_ApiKey.asmx/SMS_APIKeyNUC?apiKey=Kv86pzbqreoOBrD&cellNoList=$mobile&msgText=$sms&senderId=SANDIP";
	///$smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$mobile&service=T";  
	 $smsGatewayUrl = "http://162.241.114.66/api/send_sms?api_key=3126098cf46a2ca0&text=$sms&mobiles=$mobile&unicode=0&sender_id=SANDIP&template_id=1107161951403516001"; 
	$smsgatewaydata = $smsGatewayUrl;
	$url = $smsgatewaydata;
	$ch = curl_init();                       // initialize CURL
	curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);   	
}*/
		
		}else if($_POST['challan_status']=='CL'){
		$challan_status='Cancelled';
		
		}else{
		$challan_status='Pending';
		}
		
		if($last_inserted_id){
		$this->session->set_flashdata('message1','Fees Challan '.$challan_status.' Successfully.');
		}else{
		$this->session->set_flashdata('message2','Fees Challan Not '.$challan_status.' Successfully.');
		}
		
		redirect('Challan');
		
		
	}
	
	
	
	

		public function edit_fees_challan_international_submit(){

		
		$date = str_replace('/', '-', $_POST['deposit_date']);
		
		if($_POST['challan_status']=='VR'){
		
		if($_POST['epayment_type']=='CASH'){
			
		$paid_type='CHLN';
		$paid_bank=$_POST['su_bank'];
		}else{
		$paid_type=$_POST['epayment_type'];
		$paid_bank=$_POST['bank'];
		}
		if($_POST['facilty']==5){
			$insert_array['exam_session'] =$_POST['exam_session'];
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
		
	
		$id=$this->uri->segment(3);
        $last_inserted_id= $this->Challan_model->update_challan_no_international($id,$update_array);


        if(($_POST['challan_status']=='CL')&&($_POST['current_status']=='VR')){
        	
		$update_array_f=array("chq_cancelled"=>'Y',"is_deleted"=>'Y',
		"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),
		"modified_on"=>date("Y-m-d H:i:s"));

		$last_inserted_id= $this->Challan_model->update_fees_details($_POST,$update_array_f);

		////////new concept//while cancel

	$update_cancellation=$this->Challan_model->update_fees_challan_internation_details($_POST);




		////end
		}

		if(($_POST['challan_status']=='CL')&&($_POST['current_status']=='PD'))
		{
			
			$update_array_f=array("chq_cancelled"=>'Y',"is_deleted"=>'Y',
			"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),
			"modified_on"=>date("Y-m-d H:i:s"));

			$last_inserted_id= $this->Challan_model->update_fees_details($_POST,$update_array_f);
			////////new concept//while cancel

			$update_array=array("challan_status"=>$_POST['challan_status'],"fees_date"=>date("Y-m-d", strtotime($date)),
			"modify_from_ip"=>$_SERVER['REMOTE_ADDR'],"modified_by"=>$this->session->userdata("uid"),
			"modified_on"=>date("Y-m-d H:i:s"));
			
		
			$id=$this->uri->segment(3);
	        $last_inserted_id= $this->Challan_model->update_challan_no_international($id,$update_array);



		////end

		}


		
		$challan_status='';

		if($_POST['challan_status']=='VR'){
		$challan_status='Verified';
		}else if($_POST['challan_status']=='CL'){
		$challan_status='Cancelled';
		
		}else{
		$challan_status='Pending';
		}
		
		if($last_inserted_id){
		$this->session->set_flashdata('message1','Fees Challan '.$challan_status.' Successfully.');
		}else{
		$this->session->set_flashdata('message2','Fees Challan Not '.$challan_status.' Successfully.');
		}
		
		redirect('Challan/challan_international_list');
		
		
	}
	
	public function challan_list_by_creteria()
	{
		$std_challan_list=$this->Challan_model->fees_challan_list($_POST);
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
			$std_challan_details=$this->Challan_model->fees_challan_list_byid($fees_id);
			//print_r($std_challan_details);
			//exit;
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

	    public function download_challan_international_pdf($fees_id)
	{
		//load mPDF library
        
		//$this->load->model('Ums_admission_model');
		//$param = '"en-GB-x","A4","","",0,0,0,0,-10,-10,P';
		//echo $hgp_id.','.$stud_prn.','.$stud_org;exit();
		$this->load->library('m_pdf', $param);
		
		if($fees_id!='')
		{
			$std_challan_details=$this->Challan_model->fees_internationalchallan_list_byid($fees_id);
			//print_r($std_challan_details);
			//exit;
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
		if($this->session->userdata("role_id")==15 || $this->session->userdata("role_id")==5 || $this->session->userdata("role_id")==6){
		}else{
			redirect('home');
		}

		$this->load->model('Examination_model');
		$ex_session = $this->Examination_model->fetch_stud_curr_exam();
		$exam_type =$ex_session[0]['exam_type'];
		$exam_id =$ex_session[0]['exam_id'];
		
		
		$this->load->view('header',$this->data);

		$this->data['challan_details']=$this->Challan_model->examfees_challan_list($_POST,$exam_id);
		$this->load->view($this->view_dir.'examfees_challan_list',$this->data);
	
		 $this->load->view('footer');
		

	}

	public function receipt_list($d='')
	{
		//error_reporting(E_ALL);
		$this->load->view('header',$this->data);
		$this->data['receipt_typ']=$this->Challan_model->challan_rec_list();
        $this->load->view($this->view_dir.'chalan_receipt',$this->data);
        $this->load->view('footer');

	}
	public function get_receipt_list(){
		$arr['pst']=$_REQUEST['pst'];
		$arr['styp']=$_REQUEST['styp'];
		$arr['sdt']=$_REQUEST['sdt'];
		$arr['dfrm']=$_REQUEST['dfrm'];
		$arr['dto']=$_REQUEST['dto'];
$this->data['rec_list']=$this->Challan_model->get_recpt_list($arr);
$this->load->view($this->view_dir.'ajax_challen_receipt',$this->data);
	}
	
	public function manual_excel(){
		$this->load->view('header',$this->data);
		 $this->load->view($this->view_dir.'manual_excel',$this->data);
		    $this->load->view('footer');
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////	
 public function add_fees_internationl()
	{
		$challan_digits=4;
		if($_POST['fees_date']==''){
			$fdate=date("Y-m-d");
		}
		else{
			$fdate=date("Y-m-d", strtotime($_POST['fees_date'])); 
		}
	//echo '<pre>';	print_r($_POST);
		
	//	exit;
		
		$enroll=$_POST['enroll'];
		$student_id=$_POST['student_id'];
		$academic=$_POST['academic'];
		$facilty=$_POST['facilty'];
		$_POST['depositto'];
		
		$Balance_Amount=$_POST['Balance_Amount'];
		$tutf=$_POST['tutf'];
		$devf=$_POST['devf'];
		$cauf=$_POST['cauf'];
		$admf=$_POST['admf'];
		$exmf= $_POST['exmf'];
		$unirf= $_POST['unirf'];
		
	//	$_POST['amt'];
	//	$refund_paid=$_POST['amth'];
		//$Excess_Fees=$_POST['Excess'];
		//$_POST['epayment_type'];
		//$_POST['receipt_number'];
		//$_POST['bank'];
	//	$_POST['branch'];
		//echo $fdate; exit();
		//////////////////////////////////////////////////////////////////////////////////////////////
		
		//$Backlog_Exam=$_POST['Backlog_Exam'];
		//$Photocopy_Fees=$_POST['Photocopy_Fees'];
		//$Revaluation_Fees=$_POST['Revaluation_Fees'];
		//$Late_Fees=$_POST['Late_Fees'];
		
		//$OtherFINE_Brekage=$_POST['OtherFINE_Brekage'];
		//$Other_Registration=$_POST['Other_Registration'];
		//$Other_Late=$_POST['Other_Late'];
		//$Other_fees=$_POST['Other_fees'];
		//////////////////////////////////////////////////////////////////////////////////////////////
		//$Balance_org=$_POST['Balance_org'];
		//$Tuition_org=$_POST['Tuition_org'];
		//$development_org=$_POST['development_org'];
		//$caution_org=$_POST['caution_org'];
	//	$admission_org=$_POST['admission_org'];
	//	$exam_org=$_POST['exam_org'];
	//	$University_org=$_POST['University_org'];
		//////////////////////////////////////////////////////////////
		$currnt=array('stud'=>$student_id,'enroll'=>$enroll,'facility'=>$facilty,'academic'=>$academic);
		$Check_challan=$this->Challan_model->Check_challan_international($currnt);
	//	print_r($Check_challan);
		//echo '<br>';
		//echo 'fees_id'.$Check_challan[0]['fees_id'];
		//echo '<br>';
		if(empty($Check_challan[0]['fees_id']))
		{
			//$Balance_pending=$Balance_org - $Balance_Amount;
			//$Tuition_pending=$Tuition_org - $tutf;
			
			//$development_pending=$development_org - $devf;
			//if($this->session->userdata("uid")==2){
			//echo $development_org;echo ' development_org<br>';
			//echo $devf;echo '<br>';
			//echo $development_pending;echo '<br>';
			//exit;
		  // }
			
			
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
        if($_POST['facilty']==2){
		$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>0,"tution_fees"=>$_POST['tutf'],"development_fees"=>$_POST['devf'],
		"caution_money"=>$_POST['cauf'],"admission_form"=>$_POST['admf'],"exam_fees"=>$_POST['exmf'],
		"university_fees"=>$_POST['unirf'],"hostel_fees"=>$_POST['Hostel'],
		"amount"=>$_POST['amt'],"fees_paid_type"=>$_POST['epayment_type'],
		"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"),
		"refund_pay"=>$refund_paid,"Excess_Fees"=>$refund_paid,"accommodation"=>$_POST['Accommodation'],
		
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Pending"=>$Balance_pending,"Balance_Amount_status"=>$Balance_Amount_status,"remark"=>$_POST['Remark']
		);
		if($this->session->userdata("uid")==2){
			//print_r($insert_array);
			//exit;
		}
		
		}elseif($_POST['facilty']==5){
			$exam_mon = $_POST['exam_monthyear'];
            $arr_exammon = explode(':', $exam_mon);
			
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>$_POST['category'],"Backlog_fees"=>$_POST['Backlog_Exam'],"Photocopy_fees"=>$_POST['Photocopy_Fees'],
		"Revaluation_Fees"=>$_POST['Revaluation_Fees'],"Exam_LateFees"=>$_POST['Late_Fees'],"amount"=>$_POST['amt'],
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Amount_status"=>$Balance_c,"exam_monthyear"=>$arr_exammon[0],"exam_id"=>$arr_exammon[1],
		"fees_paid_type"=>$_POST['epayment_type'],"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),"remark"=>$_POST['Remark'],
		"created_on"=>date("Y-m-d H:i:s"));
			
		}elseif($_POST['facilty']==10){
			$insert_array=array("enrollment_no"=>$_POST['enroll'],"student_id"=>$_POST['student_id'],
		"academic_year"=>$_POST['academic'],"type_id"=>$_POST['facilty'],"bank_account_id"=>$_POST['depositto'],
		"college_receiptno"=>0,"OtherFINE_Brekage"=>$_POST['OtherFINE_Brekage'],"Other_Registration"=>$_POST['Other_Registration'],
		"Other_Late"=>$_POST['Other_Late'],"Other_fees"=>$_POST['Other_fees'],"amount"=>$_POST['amt'],
		"Balance_Amount"=>$_POST['Balance_Amount'],"Balance_Amount_status"=>$Balance_c,"fees_paid_type"=>$_POST['epayment_type'],
		"TransactionNo"=>$receipt_number,"TransactionDate"=>$fdate,
		"receipt_no"=>$receipt_number,"fees_date"=>$fdate,"bank_id"=>$_POST['bank'],"bank_city"=>$_POST['branch'],"remark"=>$_POST['Remark'],
		"entry_from_ip"=>$_SERVER['REMOTE_ADDR'],"created_by"=>$this->session->userdata("uid"),
		"created_on"=>date("Y-m-d H:i:s"));
			
		}
		//echo '<pre>';print_r($insert_array);
		//exit;
        $last_inserted_id= $this->Challan_model->add_fees_challan_international_submit($insert_array);
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
			
		//	if($current_month<=5){
			//	$month_session="2";
			//}else{
				$month_session="1";
			//}
			
			$ayear= substr($_POST['academic'], -2);  //explode("-",$_POST['academic']);$ayear.
			$challan_no='I20SUN'.$addmision_type.$month_session.str_pad( $last_inserted_id, $challan_digits, "0", STR_PAD_LEFT );
			
			$update_array=array("exam_session"=>$challan_no);
			$last_inserted_id= $this->Challan_model->update_challan_no_international($last_inserted_id,$update_array);
			$this->session->set_flashdata('message1','Fees Challan Generated Successfully.');
		}
		else
			$this->session->set_flashdata('message2','Fees Challan Not Generated Successfully.');
        
		     redirect('challan/challan_international_list');
	}




}
public function challan_international_list()
{

$this->load->view('header',$this->data);
$this->data['challan_details']=$this->Challan_model->fees_challan_internationlist();

$this->load->view($this->view_dir.'internationa_challna_list',$this->data);
$this->load->view('footer');
}



public function Search(){
		$Recepit=$this->input->post('Recepit');
		$Mobile=$this->input->post('Mobile');
		$transactionno=$this->input->post('transactionno');
		$academic_year = $this->input->post('academic_year');
		$school_id = $this->input->post('school_id');
		$challan_type = $this->input->post('challan_type');
		$std_challan_list = $this->Challan_model->Search($Recepit, $Mobile, $transactionno,$academic_year, $school_id,$challan_type);
       // $this->data['challan_details']=$std_challan_list;
		echo json_encode(array("std_challan_list"=>$std_challan_list));
	   // $this->load->view($this->view_dir.'ajax_fees_receipt_list_status',$this->data);
		
	}


  public function Create_challan_manually(){
	//  exit();
	  $DB1 = $this->load->database('umsdb', TRUE);
	 /* $sql="SELECT fd.student_id,s.enrollment_no,fc.student_id as new_id FROM fees_details AS fd
LEFT JOIN fees_challan AS fc ON fc.student_id=fd.student_id 
INNER JOIN student_master AS s ON s.stud_id=fd.student_id AND s.admission_cycle IS NULL

WHERE fc.student_id IS NULL 
GROUP BY fd.student_id 
HAVING fd.student_id>3114";*/

$sql="SELECT fd.student_id,s.enrollment_no,fc.student_id as new_id,fc.`enrollment_no` as new_enrollment_no,s.`admission_cycle` FROM fees_details AS fd
LEFT JOIN fees_challan_phd AS fc ON fc.student_id=fd.student_id 
INNER JOIN student_master AS s ON s.stud_id=fd.student_id 

WHERE fc.student_id IS NULL AND s.`admission_cycle` IS NOT NULL
GROUP BY fd.student_id";
	 /* $sql="SELECT fd.student_id,s.enrollment_no,fc.student_id AS nstudent_id,fc.`enrollment_no` AS nenrollment_no,s.`admission_cycle` ,ad.`applicable_fee`
FROM fees_details AS fd
LEFT JOIN fees_challan AS fc ON fc.student_id=fd.student_id 
INNER JOIN student_master AS s ON s.stud_id=fd.student_id AND s.`cancelled_admission`='N' AND s.`reported_status`='Y'
INNER JOIN admission_details AS ad ON ad.student_id=fd.student_id 
WHERE fc.student_id IS NULL AND s.`admission_cycle` IS NULL
GROUP BY fd.student_id";*/
	  $query=$DB1->query($sql);
	  $result=$query->result_array();
	  //print_r($result);
	
	foreach($result as $list){
		  
  /*$sql2="SELECT SUM(fd.amount) AS amount_paid,ad.applicable_fee,ad.actual_fee FROM fees_details AS fd
LEFT JOIN admission_details AS ad ON ad.student_id=fd.`student_id`
WHERE  fd.student_id='".$list['student_id']."'";	*/
$sql2="SELECT SUM(fd.amount) AS amount_paid,ad.applicable_fee,ad.actual_fee FROM admission_details AS ad
LEFT JOIN fees_details AS fd ON ad.student_id=fd.student_id AND ad.batch_cycle='".$list['admission_cycle']."' AND
 fd.academic_year='2019'
WHERE  ad.student_id='".$list['student_id']."' AND ad.academic_year='2019'";
 $query2=$DB1->query($sql2);
 
$result2=$query2->result_array(); 

 foreach($result2 as $list2){
	 
	 $pending= $list2['applicable_fee']- $list2['amount_paid'];

	echo  $list['applicable_fee'].'_'.$list['student_id'].'--'.$pending;echo '<br>';
	
$data['type_id']='2';
$data['bank_account_id']='1';	
$data['student_id']	=$list['student_id'];
$data['enrollment_no']	=$list['enrollment_no'];
$data['fees_paid_type']='CHLN';	
$data['TransactionNo']	='';
$data['TransactionDate']='';
$data['batch']=$list['admission_cycle'];
$data['deposit_date']='';	
$data['receipt_no']	='0';
$data['receipt_file']	='0';
$data['tution_fees']	='0';
$data['tution_pending']	=$pending;
$data['tution_status']	='N';
$data['development_fees']='0';	
$data['development_pending	']='0';
$data['development_status']	='Y';
$data['caution_money']	='0';
$data['caution_pending']	='0';
$data['caution_status']	='Y';
$data['admission_form']	='0';
$data['admission_pending']	='0';
$data['admission_status']	='Y';
$data['exam_fees']	='0';
$data['exam_pending']	='0';
$data['exam_status']	='Y';
$data['university_fees']='0';	
$data['university_pending']	='0';
$data['university_status']	='Y';
$data['Backlog_fees']	='0';
$data['Photocopy_fees']	='0';
$data['Revaluation_Fees']	='0';
$data['Exam_LateFees']	='0';
$data['OtherFINE_Brekage']	='0';
$data['Other_Registration']	='0';
$data['Other_Late']	='0';
$data['Other_fees']	='0';
$data['guest_name']	='0';
$data['guest_mobile']='0';	
$data['guest_organisation']	='0';
$data['guest_address']	='0';
$data['guest_RegistrationFees']='0';	
$data['guest_OtherFees']	='0';
$data['amount']	='0';
$data['refund_pay']	='0';
$data['Excess_Fees']	='0';
$data['Balance_Amount']	='0';
$data['Balance_Pending']	='0';
$data['Balance_Amount_status']	=	'N';
$data['fees_date']	=	'';
$data['bank_id']	=	'';
$data['bank_city']	=	'';
$data['academic_year']	=	'2019';
$data['exam_session']=	'19000000';	
$data['exam_monthyear']	=	'';
$data['exam_id']	=	'';
$data['entry_from_ip']	=	'';
$data['modify_from_ip']	=	'';
$data['created_by']	=	'';
$data['created_on']	=	'';
$data['modified_by']=	'';	
$data['modified_on']=	'';
$data['remark']=	'Recepit PAy';
$data['canc_charges']='0';	
$data['exam_fee_fine']	='0';
$data['college_receiptno']	='';
$data['challan_status']	='VR';
$data['is_deleted']='N';
//$this->Challan_model->Search($Recepit, $Mobile);
//$DB1->insert("fees_challan_phd", $data);

 }
 

 
 }
 
//print_r($data);

  }



public function challan_details($fees_paid_type="",$type="",$sub_type="",$date="",$comparison_parameter="")
    { 
	
	   
        $this->load->view('header',$this->data);
		$this->data['challan_details']=$this->Challan_model->fees_challan_list_details($fees_paid_type,$type,$sub_type,$date,$comparison_parameter);
		$this->data['only_view']=1;
        $this->load->view($this->view_dir.'fees_challan_list',$this->data);
        $this->load->view('footer');
    }  


public function check_recepit(){
	
	$DB1 = $this->load->database('umsdb', TRUE);
	$receipt_number=$this->input->post('receipt_number');
	$epayment_type=$this->input->post('epayment_type');
	$sql="select count(fees_id) as Total FROM fees_challan WHERE fees_paid_type='$epayment_type' AND receipt_no='$receipt_number' AND challan_status!='CL'";
    $query=$DB1->query($sql);
	$result=$query->result_array();
	echo $result[0]['Total'];
}


public function add_Tuition(){
	$DB1 = $this->load->database('umsdb', TRUE);
	$add_fee=$this->input->post('add_fee');
	$enroll=$this->input->post('enroll');
	$student_id=$this->input->post('student_id');
	$academic=$this->input->post('academic');
	
	 $sqlcheck="SELECT count(fees_id) as Total FROM fees_challan WHERE academic_year ='".$academic."' AND student_id = '".$student_id."'
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
			$add['tution_pending']=$add_fee;
			$add['development_pending']=$this->input->post('development_fees');
			$add['caution_pending']=$this->input->post('caution_money');
			$add['admission_pending']=$this->input->post('admission_form');
			$add['exam_pending']=$this->input->post('exam_fees');
			$add['university_pending']=$this->input->post('university_fees');
			
			$add['tution_status']='N';
			$add['exam_session']='20SUNR000000';
			$add['amount']='0';
			$add['remark']='Demo entrry for challan create';
			$add['challan_status']='PD';
			$add['academic_year']=$academic;
			//$add['amount']='0';
		  //  $DB1->where("fees_id", $fees_id);	
	         $DB1->insert("fees_challan", $add);
				$d=$last_inserted_id=$DB1->insert_id(); 
				}else{
	
	
	      
			$sql="SELECT *,type_id AS ntype_id FROM fees_challan WHERE academic_year ='".$academic."' AND student_id = '".$student_id."'
			AND type_id= '2'  AND challan_status !='CL' AND type_id='2'
			ORDER BY fees_id DESC limit 0,1";
			$query = $DB1->query($sql);
			$result=$query->row_array();
			echo $fees_id=$result['fees_id'];
			//exit();
			$up['tution_pending']=$add_fee;
			$up['development_pending']=$this->input->post('development_fees');
			$up['caution_pending']=$this->input->post('caution_money');
			$up['admission_pending']=$this->input->post('admission_form');
			$up['exam_pending']=$this->input->post('exam_fees');
			$up['university_pending']=$this->input->post('university_fees');
			$up['tution_status']='N';
		    $DB1->where("fees_id", $fees_id);	
	        $d=$DB1->update("fees_challan", $up);
			//echo $DB1->last_query();
			}
		if($d){
			echo '1';
		}else{
			echo '2';
		}
	
}
public function add_package(){
	$DB1 = $this->load->database('umsdb', TRUE);
	$add_fee=$this->input->post('add_fee');
	$enroll=$this->input->post('enroll');
	$student_id=$this->input->post('student_id');
	$academic=$this->input->post('academic');
	
	 $sqlcheck="SELECT count(fees_id) as Total FROM fees_challan WHERE academic_year ='".$academic."' AND student_id = '".$student_id."'
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
			$add['package_fees_pending']=$add_fee;
			/*$add['development_pending']=$this->input->post('development_fees');
			$add['caution_pending']=$this->input->post('caution_money');
			$add['admission_pending']=$this->input->post('admission_form');
			$add['exam_pending']=$this->input->post('exam_fees');
			$add['university_pending']=$this->input->post('university_fees');*/
			
			$add['package_fees_status']='N';
			$add['exam_session']='20SUNR000000';
			$add['amount']='0';
			$add['remark']='Demo entrry for challan create';
			$add['challan_status']='PD';
			$add['academic_year']=$academic;
			//$add['amount']='0';
		  //  $DB1->where("fees_id", $fees_id);	
	         $DB1->insert("fees_challan", $add);
				$d=$last_inserted_id=$DB1->insert_id(); 
				}else{
	
	
	      
			$sql="SELECT *,type_id AS ntype_id FROM fees_challan WHERE academic_year ='".$academic."' AND student_id = '".$student_id."'
			AND type_id= '2'  AND challan_status !='CL' AND type_id='2'
			ORDER BY fees_id DESC limit 0,1";
			$query = $DB1->query($sql);
			$result=$query->row_array();
			echo $fees_id=$result['fees_id'];
			//exit();
			$up['package_fees_pending']=$add_fee;
			/*$up['development_pending']=$this->input->post('development_fees');
			$up['caution_pending']=$this->input->post('caution_money');
			$up['admission_pending']=$this->input->post('admission_form');
			$up['exam_pending']=$this->input->post('exam_fees');
			$up['university_pending']=$this->input->post('university_fees');*/
			$up['package_fees_status']='N';
		    $DB1->where("fees_id", $fees_id);	
	        $d=$DB1->update("fees_challan", $up);
			//echo $DB1->last_query();
			}
		if($d){
			echo '1';
		}else{
			echo '2';
		}
	
}

//////////////////////////////////////////////////////////////////


}