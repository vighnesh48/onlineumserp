<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Payment_status extends CI_Controller 
{
	var $view_dir='Online_fee/';
	 public function __construct() 
    {
        global $menudata;
        parent:: __construct();
     //   echo $_SERVER['REMOTE_ADDR'];
    // var_dump($_SESSION);
    // error_reporting(E_ALL);
    //ini_set('display_errors', 1);
        $this->load->helper("url");		
        $this->load->library('form_validation');
        $this->load->library('someclass');
		$this->load->library('session');
		$this->load->model('Challan_model');
	    $this->load->model('Online_feemodel');
		
	}
	
	
	

function check_status(){
		
		//error_reporting(0);
$working_key = 'CD259DC1D25B6EC6E48541D3230821EB'; //Shared by CCAVENUES
$access_code = 'AVGM94HH08AM38MGMA';
$payment_id='';
   
  /* $get_list=$get_data=$this->Online_feemodel->get_online_list();
   //exit();
   foreach($get_list as $slist){
	   $payment_id= $slist['payment_id'];
	 // echo '<br>';
	   $added_on= $slist['added_on'];
	   $finaly=date('Y');
	   $year = substr($finaly, -2);
      $p_date=date("md",strtotime($added_on));
	 echo $order_no =(int)$year.$p_date.$payment_id;*/
	 {
	//echo '<br>';
	 // echo '<br>';
   //exit();
 //  echo $order_no ="'".$order_no."'";
   //exit();//21081735541//21081234842//21080834316
   $order_no='21080834316';
   $merchant_json_data =array("order_no"=>$order_no); 
//print_r($merchant_json_data);
$merchant_data = json_encode($merchant_json_data);
$encrypted_data = $this->someclass->encrypt(trim($merchant_data), $working_key);
$final_data = 'enc_request='.$encrypted_data.'&access_code='.$access_code.'&command=orderStatusTracker&request_type=JSON&response_type=JSON';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.ccavenue.com/apis/servlet/DoWebTrans");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER,'Content-Type: application/json') ;
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);
// Get server response ...
$result = curl_exec($ch);
curl_close($ch);
$status = '';
$information = explode('&', $result);

$dataSize = sizeof($information);
for ($i = 0; $i < $dataSize; $i++) {
    $info_value = explode('=', $information[$i]);
    if ($info_value[0] == 'enc_response') {
	$status = $this->someclass->decrypt(trim($info_value[1]), $working_key);
	
    }
}

//print_r($status);echo 'sas<br>';
 echo '<br>';
 echo 'Status revert is:'.$status.'<pre>';
 echo '<br>';
//$result = preg_replace('/[^a-zA-Z0-9_ -]/s','',$status);
//print_r($status);
//$status = json_encode($status, JSON_UNESCAPED_UNICODE);
$status = json_encode($status, JSON_UNESCAPED_SLASHES);
//$status = json_encode($status,JSON_UNESCAPED_UNICODE);
//$status=htmlentities( (string) $status, ENT_QUOTES, 'utf-8', FALSE);
//print_r($status);
//retValue.replaceAll("\\\\u000d\\\\u000a\\s*", "")
// $status=str_replace('\\u0004', "", ($status));
$status = str_replace(
    array(
        '/\x00/', '/\x01/', '/\x02/', '/\x03/', '/\x04/',
        '/\x05/', '/\x06/', '/\x07/', '/\x08/', '/\x09/', '/\x0A/',
        '/\x0B/','/\x0C/','/\x0D/', '/\x0E/', '/\x0F/', '/\x10/', '/\x11/',
        '/\x12/','/\x13/','/\x14/','/\x15/', '/\x16/', '/\x17/', '/\x18/',
        '/\x19/','/\x1A/','/\x1B/','/\x1C/','/\x1D/', '/\x1E/', '/\x1F/',"\u0000", "\u0001", "\u0002", "\u0003", "\u0004",
        "\u0005", "\u0006", "\u0007", "\u0008", "\u0009", "\u000A",
        "\u000B", "\u000C", "\u000D", "\u000E", "\u000F", "\u0010", "\u0011",
        "\u0012", "\u0013", "\u0014", "\u0015", "\u0016", "\u0017", "\u0018",
        "\u0019", "\u001A", "\u001B", "\u001C", "\u001D", "\u001E", "\u001F","\u000f","\\u0004"
    ), 
   "", 
     $status);
 //$status = filter_var($status, FILTER_SANITIZE_STRING);
 // json_encode($status);
 // print_r($status);
  $status = json_decode($status, JSON_UNESCAPED_SLASHES);
  //print_r($status);
 // exit();
 //$status = htmlentities($status);
     // json_encode($text, JSON_UNESCAPED_UNICODE);
 // $obj =    json_decode($response, JSON_UNESCAPED_SLASHES);
 
 
 
 
 $obj = json_decode(($status),true);
 if(!empty($obj))
 print_r($obj);
 //echo 'sas<br>';
 //echo '<br>';
 
// print_r($obj['Order_Status_Result']['order_no']);
 // exit();
// echo '<br>';
  $recepit_no=trim($obj['Order_Status_Result']['order_no']); //echo '<br>';
  //echo '<br>';
  $txtid=trim($obj['Order_Status_Result']['order_ship_address']);
 $email=trim($obj['Order_Status_Result']['order_bill_email']);
 $productinfo=trim($obj['Order_Status_Result']['order_bill_name']);
 $amount=trim($obj['Order_Status_Result']['order_amt']);
 $bank_ref_num=trim($obj['Order_Status_Result']['order_bank_ref_no']);
 
 $payment_date=date("Y-m-d H:i:s", strtotime($obj['Order_Status_Result']['order_status_date_time']));
 $bank_response=trim($obj['Order_Status_Result']['order_bank_response']);
 $order_status=trim($obj['Order_Status_Result']['order_status']);
 $name=trim($obj['Order_Status_Result']['order_bill_address']);
 //exit();
 ///////////////////////////////////////////////////////////////////////////////////////////////////////
 
         
 
 
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
 
 
 
 
 if(($bank_response=="SUCCESS")&&($order_status=="Shipped")){
	// echo $recepit_no; echo '--=<br>';
  $main_status='success';
 $failure_message='';
 $payment_mode='';
 $get_data=$this->Online_feemodel->Update_Manually_Status($payment_id,$recepit_no,$txtid,$email,$productinfo,$amount,$bank_ref_num,$main_status,$payment_date);
 //print_r($get_data);
 //exit();
 ////////////////////////////////////////////////////
 
         $this->data["txnid"] =$txtid;
	     $this->data["udf1"] = $recepit_no;  //recepit_no;
	    // $this->data["udf2"] =$udf2;
	    // $this->data["udf3"] =$udf3;
	     $this->data["udf4"] =$get_data['phone'];  //Mobile_no
	    // $this->data["udf5"] =$udf5;//utype//$_REQUEST['student_type'];
		// $this->data["udf6"] =$_REQUEST['udf6'];
	     $this->data["firstname"] = $name;
	     $this->data["email"] =$email;
	     $this->data["productinfo"] =$productinfo;
	     $this->data["amount"] =$amount;
	     $this->data['addedon']=date('Y-m-d h:i:s');
	     $this->data['status']=$main_status;
	     $this->data['error']=$failure_message;
	     $this->data['PG_TYPE']='';
	     $this->data['mode']=$payment_mode;
	     $this->data['bank_ref_num']=$bank_ref_num;
	     $this->data['error_Message']=$failure_message;
 ////////////////////////////////////////////////////////////
 
 
 $user_mobile = $mobile;//$udf4//7030942420,8850633088,9545453488,9545453087;
	   $sms_message=urlencode("Dear Student
Your payment of Rs $amount is duly received and tranction no -:$txnid. Your Receipt Number is $udf1
Thanks
Sandip University");
    /*$ch = curl_init();
    $sms=$sms_message;
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$user_mobile";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://103.255.100.77/api/send_transactional_sms.php' . $query);  //http://103.255.100.77/api/send_transactional_sms.php
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);*/
 
 //$this->load->view('Online_fee/payment_success_status_manually',$this->data,true);
 
	}
	
	
	
	
	
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////	
	}
	
	
}
	
	
	
	
	
////////////////////////////////////////////////////////	
}

?>