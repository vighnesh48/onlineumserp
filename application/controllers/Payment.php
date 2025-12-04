<?php //header('Access-Control-Allow-Origin: *');
//defined('BASEPATH') OR exit('No direct script access allowed');
/*error_reporting(E_ALL); 
ini_set('display_errors', 1); 
ini_set('display_errors', 1);
*/
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
class Payment extends CI_Controller {
 function __construct() {
        parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('someclass');
		$this->load->library('session');
		$this->load->Model('Home_model');
		$this->load->Model('hostel_model');
		$this->load->Model('payment_model');
		$this->data['currentModule']= 'Home';
		 header('Access-Control-Allow-Origin: *');
		
			   //error_reporting(E_ALL);
//ini_set('display_errors', 1);
//var_dump($_SESSION);
		// session check
    }
   // payu success 

	public function payu_success() {
		date_default_timezone_set('Asia/Kolkata');
		//error_reporting(E_ALL); 
//ini_set('display_errors', 1);
		///////////////////////////////////////////////////////////////////////////
		//print_r($_REQUEST);
		//if($this->session->userdata('student_id') !=""){
			if(!empty($_REQUEST['udf2'])){
		 //$prn=$this->Home_model->generateprovisional($_REQUEST["udf1"]);
         		//if(!empty($prn))
				{ 
        // $this->data["key"] =$_REQUEST['key'];
		 //$this->data["registration_no"] =$prn;
	   //  $this->data["hash"] =$_REQUEST['hash'];
	     $this->data["txnid"] =$_REQUEST['txnid'];
	    
		 $this->data["udf1"] = $_REQUEST['udf1']; ////student_id
	     $this->data["udf2"] =$_REQUEST['udf2']; //transtion_id
		 $this->data["udf3"] =$_REQUEST['udf3']; //mobile
		 $this->data["udf4"] =$_REQUEST['udf4']; // recepitno
		 $this->data["udf5"] =$_REQUEST['udf5']; // adhar card
		 
	     $this->data["firstname"] = $_REQUEST['firstname'];
	     $this->data["email"] =$_REQUEST['email'];
	     $this->data["productinfo"] =$_REQUEST['productinfo'];
	     $this->data["amount"] =$_REQUEST['amount'];
	     $this->data['addedon']=$_REQUEST['addedon'];
	     $this->data['status']=$_REQUEST['status'];
	     $this->data['error']=$_REQUEST['error'];
	     $this->data['PG_TYPE']=$_REQUEST['PG_TYPE'];
	     $this->data['mode']=$_REQUEST['mode'];
	     $this->data['bank_ref_num']=$_REQUEST['bank_ref_num'];
	     $this->data['error_Message']=$_REQUEST['error_Message'];
		 $stud_id=$_REQUEST["udf1"];
		
		// $en_data = $this->Home_model->fetch_basic_details_from_student_master_all_details($stud_id);
		// $this->data['per'] = $en_data;//$this->Home_model->fetch_basic_details_from_student_master_all_details($stud_id);
		//$en_data = $this->Home_model->fetch_basic_details_from_student_master_all_details($stud_id);
		//$this->data['course'] = $this->Home_model->fetch_course_list_data($stud_id);
		
		//$this->data['qua'] = $this->Home_model->fetch_stud_qualifications($stud_id);
      //   exit();
		 $pay = $this->payment_model->fetch_payment_details_data($_REQUEST['udf2']);
		
		 $this->data['pay']=$pay;
		//exit();
         $this->payment_model->update_online_admissiondetails($this->data);
		 $this->payment_model->update_sf_faclitiy($pay);
		   
		    
		 
		 //exit();
		// $this->Home_model->Update_scholarship($stud_id);
		 // code by vighnesh
		 // $st_data = $this->Home_model->fetch_basic_details_from_student_master_all_details_new($stud_id);
		  //$addhar_details=$st_data->adhar_card_no;
		  
			//$ad_data = $this->Home_model->ad_data($stud_id);
			//$data_array['admission_stream']=$st_data->admission_stream;
			//$data_array['admission_school']=$st_data->admission_school;
			//$data_array['email']=$st_data->email;
			//$data_array['mobile']=$st_data->mobile;
			//$data_array['first_name']=$st_data->first_name;
			//$data_array['state']=$ad_data->state_id;
			//$data_array['city']=$ad_data->city;
			//$this->api_integration1($data_array); 
		  
		//  $enq_data = $this->Home_model->check_addhar_in_enquiry($addhar_details);
		 // if(!empty($enq_data)){
			// $this->Home_model->update_student_master_entry($stud_id,$enq_data->enquiry_id);
			// $this->Home_model->update_status_as_provisional($enq_data->enquiry_id);
			 
		//  }
		  //end by vighnesh
		 //echo "dd";
		 //exit;
		 
		 //////////////////////////////////////////////////////////////////////
		$amount=$_REQUEST['amount'];
		$txnid= $_REQUEST['txnid'];
		$udf4= $_REQUEST['udf4'];
		$udf3= $_REQUEST['udf3'];
		
		$user_mobile = $udf3;//$udf4//9545453488,9545453087,8850633088;
	    $sms_message=urlencode("Dear Student
Your payment of Rs $amount is duly received and tranction no -:$txnid. Your Receipt Number is $udf4 .please check your Email
Thanks
Sandip University");
 $sms=$sms_message;
 
 
   /* $ch = curl_init();
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SCHOOL&message=$sms&mobile=$user_mobile";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://103.255.100.77/api/send_transactional_sms.php' . $query); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);*/
	/////////////////////////////////////////////////////////////////////////'1107161951379622301'
		
		
		//  $smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$user_mobile&service=T"; 
		 
		 
		  $smsGatewayUrl = "http://162.241.114.66/api/send_sms?api_key=3126098cf46a2ca0&text=$sms&mobiles=$user_mobile&unicode=0&sender_id=SANDIP&template_id=1107161951379622301"; 
		  $smsgatewaydata = $smsGatewayUrl;
		  $url = $smsgatewaydata;

			/*$ch = curl_init();                       // initialize CURL
			curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch); */
		
		//$en_data = $this->Home_model->fetch_basic_details_from_student_master_all_details($stud_id);
		
		
	//	$enquiry_in=$this->Home_model->insert_enquiry($en_data);
		
		//$this->load->library('m_pdf', $param);
	    //$this->m_pdf->pdf=new mPDF('utf-8', 'A4', '15', '15', '15', '15', '5', '5');
		//$tempDir = $_SERVER['DOCUMENT_ROOT'].'/erp/uploads/online_payment/';
		//$content = $this->load->view('admission/provisional_certificate', $this->data, true);
		//$content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
		//$this->m_pdf->pdf->WriteHTML($content);	
       // $fname= $prn.'_provisional_certificate';
	    //$pdfFilePath = $tempDir.'/'.$fname.".pdf";
		//$this->data['provcertificate']=$pdfFilePath;
	    //download it.
	   // $this->m_pdf->pdf->Output($pdfFilePath, "F");
		//$this->load->pc($_REQUEST['email'],$pdfFilePath);
		////////////////////////////////////////////////////////////
		
		 $this->load->view('admission/payment_success',$this->data,true);
               
		 
		// $this->load->view('admission/payment_success',$this->data,true); 
		 $this->session->unset_userdata('student_id');
	 //   $this->load->view('admission/print_admission_form_view1', $this->data,true);
      //  $this->load->view('admission/print_admission_form_view_provisional_form', $this->data,true);
		
	     $this->load->view('admission/payu_success',$this->data);
		 
		 //	$enquiry_in=$this->Home_model->insert_enquiry($en_data);
		/*}
		else{
			redirect('Home');
		}*/
			}
		}
		 
    }
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function payu_failure(){	
	date_default_timezone_set('Asia/Kolkata');
	
	//print_r($_REQUEST["udf1"]);
	if(!empty($_REQUEST["udf1"])){
	    
		
		 $this->data["key"] =$_REQUEST['key'];		 
	     $this->data["hash"] =$_REQUEST['hash'];
		 $this->data["registration_no"] ='';
	     $this->data["txnid"] =$_REQUEST['txnid'];
		 
	     $this->data["udf1"] = $_REQUEST['udf1']; ////student_id
	     $this->data["udf2"] =$_REQUEST['udf2']; //transtion_id
		 $this->data["udf3"] =$_REQUEST['udf3']; //mobile
		 $this->data["udf4"] =$_REQUEST['udf4']; // recepitno
		 $this->data["udf5"] =$_REQUEST['udf4']; // adhar card
		 
	     $this->data["firstname"] = $_REQUEST['firstname'];
	     $this->data["email"] =$_REQUEST['email'];
	     $this->data["productinfo"] =$_REQUEST['productinfo'];
	     $this->data["amount"] =$_REQUEST['amount'];
	     $this->data['addedon']=$_REQUEST['addedon'];
	     $this->data['status']=$_REQUEST['status'];
	     $this->data['error']=$_REQUEST['error'];
	     $this->data['PG_TYPE']=$_REQUEST['PG_TYPE'];
	     $this->data['mode']=$_REQUEST['mode'];
	     $this->data['bank_ref_num']=$_REQUEST['bank_ref_num'];
	     $this->data['error_Message']=$_REQUEST['error_Message'];
		 $stud_id=$_REQUEST["udf1"];
		 
		 // $st_data = $this->Home_model->fetch_basic_details_from_student_master_all_details_new($stud_id);
		 // $addhar_details=$st_data->adhar_card_no;
		  
		//	$ad_data = $this->Home_model->ad_data($stud_id);
		/*	$data_array['admission_stream']=$st_data->admission_stream;
			$data_array['admission_school']=$st_data->admission_school;
			$data_array['email']=$st_data->email;
			$data_array['mobile']=$st_data->mobile;
			$data_array['first_name']=$st_data->first_name;
			$data_array['state']=$ad_data->state_id;
			$data_array['city']=$ad_data->city;
			$this->api_integration2($data_array); 
		// $this->Home_model->update_online_stuma($stud_id);*/
		//print_r($this->data);
		//exit();
	     $this->payment_model->update_online_admissiondetails($this->data);
	 //print_r($this->data);
		//exit();
	   /* $amount=$_REQUEST['amount'];
		$txnid= $_REQUEST['txnid'];
		$udf4= $_REQUEST['udf4'];
		$udf3= $_REQUEST['udf3'];
		
		  $user_mobile = $udf3;//$udf4//9545453488,9545453087,8850633088;
	   $sms_message=urlencode("Dear Student
Your payment of Rs $amount is Not received.some error occurred in transaction.
Thanks
Sandip University");*/
 $sms=$sms_message;
    
	
	
	/*$ch = curl_init();
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SCHOOL&message=$sms&mobile=$user_mobile";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://103.255.100.77/api/send_transactional_sms.php' . $query); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);*/ //'1107161951383992425'
	 
	//  $smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$user_mobile&service=T"; 
	 $smsGatewayUrl = "http://162.241.114.66/api/send_sms?api_key=3126098cf46a2ca0&text=$sms&mobiles=$user_mobile&unicode=0&sender_id=SANDIP&template_id=1107161951383992425"; 
		  $smsgatewaydata = $smsGatewayUrl;
		  $url = $smsgatewaydata;

			/*$ch = curl_init();                       // initialize CURL
			curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);*/ 
	 
	 
	 
	   //$this->Home_model->fail_payment($stud_id);
	   
	   
	   
	   
	   
	   $student_id= $this->session->userdata('student_id');
	    $this->session->set_flashdata('message', 'Something went wrong.Please try again');
	    $this->load->view('admission/payu_fail',$this->data);
	    //redirect('Home/index_second/'.$student_id);
	  
	}
	}
	
	
	

function savestudent_data(){
		date_default_timezone_set('Asia/Kolkata');
		//print_r($_POST); exit();
		$amount=0;$Balanc=0;
		if(!empty($_POST)){
		   // $smd_id=$this->Home_model->insert_data_in_smd($_POST);
			//exit();
			//$sm_is=$this->Payment->insert_data_in_sm($_POST);
			
/*$data_array['admission_stream']=$_POST['admission-branch'];
$data_array['admission_school']=$_POST['admission-school'];
$data_array['email']=$_POST['email'];
$data_array['mobile']=$_POST['smobile'];
$data_array['first_name']=$_POST['first'].' '.$_POST['smname'].' '.$_POST['slname'];
$data_array['state']=$_POST['state'];
$data_array['city']=$_POST['city_sub'];

$this->api_integration($data_array);*/
$Balance=$_POST['Balance'];
$productinfo=$_POST['productinfo']; //productinfo
$firstname =trim($_POST['firstname']); //firstname
$admission_session =$_POST['admission_session']; //50000
$hidac_year =$_POST['hidac_year']; //2021
$ac_year=$_POST['ac_year']; //2021
$fc_id =$_POST['fc_id']; //1
$hidfac_id =$_POST['hidfac_id']; //1
$c_year =$_POST['c_year']; //FY
$stud_id =$_POST['stud_id']; //26747
$adhar_card_no =$_POST['adhar_card_no']; //424736422744
$Mobile =$_POST['Mobile']; //9421502557
$email =$_POST['email']; //

$prn_no  =$_POST['prn_no'];//312021183
$org_frm =$_POST['org_frm']; // SF
//$fdeposit =$_POST['fdeposit'];// 5000
$fees =$_POST['fees']; //45000

			$check_minimum_billing_value=$this->payment_model->facility_fee_details($fc_id,$hidac_year,$org_frm);
			//print_r($check_minimum_billing_value);
			//$pay['enrollment_no']=$prn_no;
			//$pay['enrollment_no_new']=$_POST['enrollment_no_new'];
			//$pay['academic_year']=$_POST['ac_year'];
			////$pay['academic_year']=$_POST['ac_year'];
			//$stud_faci_details= $this->hostel_model->get_std_fc_details_byid($pay);
			
		//	end($stud_faci_details);
			//print_r($stud_faci_details);
		//	foreach($stud_faci_details as $list)
			//{
			//}
			//exit();
			if($admission_session==$hidac_year){
			$fees=($check_minimum_billing_value[0]['fees']);
			$deposit=$check_minimum_billing_value[0]['deposit'];	
			$amount=($fees + $deposit);
			}else{
			$fees=($check_minimum_billing_value[0]['fees']);
			$deposit=0;	
			$amount=($fees + $deposit);	
			
			}
			//echo $fees;
			//echo $deposit;	
			//echo $amount;
			$posted = array();
			
  if(($_POST['email']=="")){ //||$_POST['email']="kiran.valimbe@sandipuniversity.edu.in"
	$_POST['email'] ='kiran.valimbe@sandipuniversity.edu.in';
	//$_POST['amount'] =1;
	$email ='kiran.valimbe@sandipuniversity.edu.in';
	$posted['email']='kiran.valimbe@sandipuniversity.edu.in';
	$_POST['amount'] =($amount+$Balance);
	$amount=($amount+$Balance);//;+$Balance;
}else{
	$_POST['email'] =$_POST['email'];
	$email =$_POST['email'];
	$posted['email']=$_POST['email'];
    $_POST['amount'] =($amount+$Balance);
    $amount=$amount+$Balance;//+$Balance;
}




/*if($_POST['email']=="kiran.valimbe@sandipuniversity.edu.in"){
	//$email ='kiran.valimbe@sandipuniversity.edu.in';
	$posted['email']='kiran.valimbe@sandipuniversity.edu.in';
	$posted['amount']=1;
	$amount=1;
}*/
			
			if($check_minimum_billing_value[0]['fees'])
	{
			
			
			$arr2=array();
		
	 

		
		
			//exit();
   // $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 10);
   $MERCHANT_KEY = "soe5Fh"; //Please change this value with live key for
   $hash_string = '';
   $SALT = "OhVBBZuL"; //Please change this value with live salt for production
  
  /// $txnid=date('ddmmyyyy').rand(100,999);
   
   
   // End point - change to https://secure.payu.in for LIVE mode
   $PAYU_BASE_URL = "https://secure.payu.in";
   
   $action = '';
  // print_r($_POST);
   //exit();
   
   if(!empty($_POST)) {
   foreach($_POST as $key => $value) 
     {    
       $posted[$key] = $value; 
     } 
   }
   
    $txnid=date('ymdhis')."".$stud_id;
	
   $trans_id=$this->payment_model->insert_data_in_trans($_POST,$stud_id,$txnid,$amount,$deposit);
  //exit();
   $vat = date('ymd')."".$trans_id;
   
   $posted['txnid']=$txnid;
   //$firstname=$_POST['first'];
   
   $posted['firstname']=$firstname;
   
   $posted['udf1']=$stud_id; //student_id
   $posted['udf2']=$trans_id;  //transtion_id
   $posted['udf3']=$Mobile;//$Mobile; //mobile
   $posted['udf4']=$vat; //recepitno
   $posted['udf5']=$adhar_card_no; //adhar_card_no
   
 
 
   $formError = 0;
   $hash = '';
   $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";    
  
   if(empty($_POST['hash']) && sizeof($posted) > 0) {    
   
  if(empty($posted['key'])|| empty($posted['txnid']) || empty($posted['amount'])|| empty($posted['firstname'])
  ||empty($posted['email'])|| empty($posted['productinfo'])) {
   $formError = 1;
   } else {  
    $hashVarsSeq = explode('|', $hashSequence);
    foreach($hashVarsSeq as $hash_var) {
    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
    $hash_string .= '|';
    }
    $hash_string .= $SALT;
    $hash = strtolower(hash('sha512', $hash_string));
	$formError = 2;
     }
   } elseif(!empty($posted['hash'])) {	   
     $hash = $posted['hash'];
	 $formError = 3;
   }    
   
 //  print_r($posted);
		$this->session->set_userdata('student_id',$stud_id);
		
		if($trans_id!=0){
		echo json_encode(array('formError'=>$formError ,'amount'=>$amount,'Email'=>$email, 'txnid'=>$txnid,'hash'=>$hash,'transaction_db_id'=>$trans_id,'student_id'=>$stud_id,'adhar_card_no'=>$adhar_card_no,'vat'=>$vat,'first_name'=>$firstname,'flag'=>1,'response'=>'success'));
		}else{
		 echo json_encode(array('formError' =>$formError,'amount'=>$amount,'Email'=>$email ,'txnid'=>'','hash'=>'','transaction_db_id'=>'','student_id'=>$sm_is,'adhar_card_no'=>'','vat'=>'','first_name'=>'','flag'=>0,'response'=>'Something went wrong,Refresh and try again1'));	
			}
	}else{
			
	    if($check_minimum_billing_value==2){
	     echo json_encode(array('formError'=>$formError,'amount'=>$amount,'Email'=>$email , 'txnid'=>'','hash'=>'','transaction_db_id'=>'','student_id'=>$stud_id,'adhar_card_no'=>'','vat'=>'','first_name'=>'','flag'=>0,'response'=>'Mismatch in Amount to Pay and Minimum Applicable fee')); 
		 }else{
		  echo json_encode(array('formError' =>$formError,'amount'=>$amount,'Email'=>$email ,'txnid'=>'','hash'=>'','transaction_db_id'=>'','student_id'=>$stud_id,'adhar_card_no'=>'','vat'=>'','first_name'=>'','flag'=>0,'response'=>'Something went wrong,Refresh and try again2'));
		 }
		  
	  }
		
		
		}else{
			echo json_encode(array('txnid'=>'','hash'=>'','amount'=>$amount,'Email'=>$email,'transaction_db_id'=>'','student_id'=>$stud_id,'adhar_card_no'=>'','vat'=>'','first_name'=>'','flag'=>0,'response'=>'Something went wrong,Refresh and try again3'));
		}
		
	}
	
	
	
	
	
	function savestudent_tranport(){
		date_default_timezone_set('Asia/Kolkata');
		//print_r($_POST); exit();
		$amount=0;$Balanc=0;
		if(!empty($_POST)){
		   // $smd_id=$this->Home_model->insert_data_in_smd($_POST);
			//exit();
			//$sm_is=$this->Payment->insert_data_in_sm($_POST);
			
/*$data_array['admission_stream']=$_POST['admission-branch'];
$data_array['admission_school']=$_POST['admission-school'];
$data_array['email']=$_POST['email'];
$data_array['mobile']=$_POST['smobile'];
$data_array['first_name']=$_POST['first'].' '.$_POST['smname'].' '.$_POST['slname'];
$data_array['state']=$_POST['state'];
$data_array['city']=$_POST['city_sub'];

$this->api_integration($data_array);*/
$Balance=$_POST['Balance'];
$productinfo=$_POST['productinfo']; //productinfo
$firstname =trim($_POST['firstname']); //firstname
$admission_session =$_POST['admission_session']; //50000
$hidac_year =$_POST['hidac_year']; //2021
$ac_year=$_POST['ac_year']; //2021
$fc_id =$_POST['fc_id']; //1
$hidfac_id =$_POST['hidfac_id']; //1
$c_year =$_POST['c_year']; //FY
$stud_id =$_POST['stud_id']; //26747
$adhar_card_no =$_POST['adhar_card_no']; //424736422744
$Mobile =$_POST['Mobile']; //9421502557
$email =$_POST['email']; //

$prn_no  =$_POST['prn_no'];//312021183
$org_frm =$_POST['org_frm']; // SF
//$fdeposit =$_POST['fdeposit'];// 5000
$fees =$_POST['fees']; //45000

			$check_minimum_billing_value=$this->payment_model->facility_fee_details($fc_id,$hidac_year,$org_frm);
			//print_r($check_minimum_billing_value);
			//$pay['enrollment_no']=$prn_no;
			//$pay['enrollment_no_new']=$_POST['enrollment_no_new'];
			//$pay['academic_year']=$_POST['ac_year'];
			////$pay['academic_year']=$_POST['ac_year'];
			//$stud_faci_details= $this->hostel_model->get_std_fc_details_byid($pay);
			
		//	end($stud_faci_details);
			//print_r($stud_faci_details);
		//	foreach($stud_faci_details as $list)
			//{
			//}
			//exit();
			if($admission_session==$hidac_year){
			$fees=($check_minimum_billing_value[0]['fees']);
			$deposit=$check_minimum_billing_value[0]['deposit'];	
			$amount=($fees + $deposit);
			}else{
			$fees=($check_minimum_billing_value[0]['fees']);
			$deposit=0;	
			$amount=($fees + $deposit);	
			
			}
			//echo $fees;
			//echo $deposit;	
			//echo $amount;
			$posted = array();
			
  if(($_POST['email']=="")){ //||$_POST['email']="kiran.valimbe@sandipuniversity.edu.in"
	$_POST['email'] ='kiran.valimbe@sandipuniversity.edu.in';
	//$_POST['amount'] =1;
	$email ='kiran.valimbe@sandipuniversity.edu.in';
	$posted['email']='kiran.valimbe@sandipuniversity.edu.in';
	$_POST['amount'] =($amount+$Balance);
	$amount=($amount+$Balance);//;+$Balance;
}else{
	$_POST['email'] =$_POST['email'];
	$email =$_POST['email'];
	$posted['email']=$_POST['email'];
    $_POST['amount'] =($amount+$Balance);
    $amount=$amount+$Balance;//+$Balance;
}




/*if($_POST['email']=="kiran.valimbe@sandipuniversity.edu.in"){
	//$email ='kiran.valimbe@sandipuniversity.edu.in';
	$posted['email']='kiran.valimbe@sandipuniversity.edu.in';
	$posted['amount']=1;
	$amount=1;
}*/
			
			if($check_minimum_billing_value[0]['fees'])
	{
			
			
			$arr2=array();
		
	 
    $posted['amount']=1;
    $_POST['amount'] =1;
    $amount=1;//+$Balance;
		
		
			//exit();
   // $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 10);
   $MERCHANT_KEY = "soe5Fh"; //Please change this value with live key for
   $hash_string = '';
   $SALT = "OhVBBZuL"; //Please change this value with live salt for production
  
  /// $txnid=date('ddmmyyyy').rand(100,999);
   
   
   // End point - change to https://secure.payu.in for LIVE mode
   $PAYU_BASE_URL = "https://secure.payu.in";
   
   $action = '';
  // print_r($_POST);
   //exit();
   
   if(!empty($_POST)) {
   foreach($_POST as $key => $value) 
     {    
       $posted[$key] = $value; 
     } 
   }
   $trans_id='1';
    $txnid=date('ymdhis')."".$stud_id;
	
 //  $trans_id=$this->payment_model->insert_data_in_trans($_POST,$stud_id,$txnid,$amount,$deposit);
  //exit();
   $vat = date('ymd')."".$trans_id;
   
   $posted['txnid']=$txnid;
   //$firstname=$_POST['first'];
   
   $posted['firstname']=$firstname;
   
   $posted['udf1']=$stud_id; //student_id
   $posted['udf2']=$trans_id;  //transtion_id
   $posted['udf3']=$Mobile;//$Mobile; //mobile
   $posted['udf4']=$vat; //recepitno
   $posted['udf5']=$adhar_card_no; //adhar_card_no
   
 
 
   $formError = 0;
   $hash = '';
   $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";    
  
   if(empty($_POST['hash']) && sizeof($posted) > 0) {    
   
  if(empty($posted['key'])|| empty($posted['txnid']) || empty($posted['amount'])|| empty($posted['firstname'])
  ||empty($posted['email'])|| empty($posted['productinfo'])) {
   $formError = 1;
   } else {  
    $hashVarsSeq = explode('|', $hashSequence);
    foreach($hashVarsSeq as $hash_var) {
    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
    $hash_string .= '|';
    }
    $hash_string .= $SALT;
    $hash = strtolower(hash('sha512', $hash_string));
	$formError = 2;
     }
   } elseif(!empty($posted['hash'])) {	   
     $hash = $posted['hash'];
	 $formError = 3;
   }    
   
 //  print_r($posted);
		$this->session->set_userdata('student_id',$stud_id);
		
		if($trans_id!=0){
		echo json_encode(array('formError'=>$formError ,'amount'=>$amount,'Email'=>$email, 'txnid'=>$txnid,'hash'=>$hash,'transaction_db_id'=>$trans_id,'student_id'=>$stud_id,'adhar_card_no'=>$adhar_card_no,'vat'=>$vat,'first_name'=>$firstname,'flag'=>1,'response'=>'success'));
		}else{
		 echo json_encode(array('formError' =>$formError,'amount'=>$amount,'Email'=>$email ,'txnid'=>'','hash'=>'','transaction_db_id'=>'','student_id'=>$sm_is,'adhar_card_no'=>'','vat'=>'','first_name'=>'','flag'=>0,'response'=>'Something went wrong,Refresh and try again1'));	
			}
	}else{
			
	    if($check_minimum_billing_value==2){
	     echo json_encode(array('formError'=>$formError,'amount'=>$amount,'Email'=>$email , 'txnid'=>'','hash'=>'','transaction_db_id'=>'','student_id'=>$stud_id,'adhar_card_no'=>'','vat'=>'','first_name'=>'','flag'=>0,'response'=>'Mismatch in Amount to Pay and Minimum Applicable fee')); 
		 }else{
		  echo json_encode(array('formError' =>$formError,'amount'=>$amount,'Email'=>$email ,'txnid'=>'','hash'=>'','transaction_db_id'=>'','student_id'=>$stud_id,'adhar_card_no'=>'','vat'=>'','first_name'=>'','flag'=>0,'response'=>'Something went wrong,Refresh and try again2'));
		 }
		  
	  }
		
		
		}else{
			echo json_encode(array('txnid'=>'','hash'=>'','amount'=>$amount,'Email'=>$email,'transaction_db_id'=>'','student_id'=>$stud_id,'adhar_card_no'=>'','vat'=>'','first_name'=>'','flag'=>0,'response'=>'Something went wrong,Refresh and try again3'));
		}
		
	}
	
	
function check_payment(){
	
        $pay = $this->payment_model->fetch_payment_details_data('279');
		
		$this->data['pay']=$pay;
		exit();
        // $this->payment_model->update_online_admissiondetails($this->data);
		 $this->payment_model->update_sf_faclitiy_test($pay);
}


		


}
?>