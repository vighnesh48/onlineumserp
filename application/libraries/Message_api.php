<?php

class Message_api
{
    private $CI;
 
    function __construct()
    {
        $this->CI = get_instance();
    }
 
    function send_sms($mobile,$sms){
	
	$sms=urlencode($sms);
	
	
	//$sms=urlencode($sms_message);
     $smsGatewayUrl = "http://apivm.valuemobo.com/SMS/SMS_ApiKey.asmx/SMS_APIKeyNUC?apiKey=Kv86pzbqreoOBrD&cellNoList=$mobile&msgText=$sms&senderId=SANDIP";
	///$smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$mobile&service=T";  
	$smsgatewaydata = $smsGatewayUrl;
	$url = $smsgatewaydata;
	$ch = curl_init();                       // initialize CURL
	curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);   	
	
	//print_r($output);
	//exit();
    /*$smsGatewayUrl = "http://apivm.valuemobo.com/SMS/SMS_ApiKey.asmx/SMS_APIKeyNUC?apiKey=Kv86pzbqreoOBrD&cellNoList=$mobile&msgText=$sms&senderId=SANDIP";
	///$smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$mobile&service=T";  
	$smsgatewaydata = $smsGatewayUrl;
	$url = $smsgatewaydata;
	$ch = curl_init();                       // initialize CURL
	curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);   */
  
	 //   echo "Y";
	 /////////////////////////////////////////////////////////////////////////////////////
	 /*	
		  $ch = curl_init();
   $sms=$sms_message;
    $query="?username=SANDIP03&password=sandip2018&from=SANDIP&to=$mobile&text=$sms&coding=0";
  

     curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_URL,'http://49.50.67.32/smsapi/httpapi.jsp' . $query); 

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      $res = trim(curl_exec($ch));  
     //print_r($res);
   curl_close($ch);
*/	
    /*$sms_message =urlencode($sms);
    $ch = curl_init();
    $sms=$sms_message;
    $query="?username=u4282&msg_token=j8eAyq&sender_id=SANDIP&message=$sms&mobile=$mobile";
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL,'http://bulksms.omegatelesolutions.com/api/send_transactional_sms.php' . $query); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $res = trim(curl_exec($ch));
    curl_close($ch);*/
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////

    }
	
	public function sendattachedemailotp($body,$subject,$file,$to,$cc,$bcc,$from)
    {
	
        $path=$_SERVER["DOCUMENT_ROOT"].'/application/third_party/';
        require_once($path.'PHPMailer/class.phpmailer.php');
        date_default_timezone_set('Asia/Kolkata');
         require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
        
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        //$mail->SMTPDebug = 4;
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        //Username to use for SMTP authentication
		$mail->Username = 'noreply10@sandipuniversity.edu.in';
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
	   $mail->Password = 'pgef sqab ruxv cdvy';
        //Set who the message is to be sent from
        $mail->setFrom($from,'ERP');
       $mail->AddAddress($to);
	   $mail->AddCC($cc);
	   $all_bcc = explode(',', $bcc);
		foreach ($all_bcc as $bcc_email) {
			$bcc_email = trim($bcc_email);
			if (!empty($bcc_email)) {
				$mail->AddBCC($bcc_email);
			}
		}
      // $mail->AddBCC($bcc);
        //Set the subject line
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        if(!empty($file)){
			$mail->AddAttachment($file);
		}
        //send the message, check for errors
        if (!$mail->send()) {
           // echo 'Mailer Error: ' . $mail->ErrorInfo;
			return 0;
        } else {
        //    echo 'Message sent!';
			return 1;
        }
    }
	function send_new($mobile,$sms)
	{
		$username = urlencode("u4282");
$msg_token = urlencode("j8eAyq");
$sender_id = urlencode("SANDIP"); // optional (compulsory in transactional sms)
$message = urlencode($sms);
$mobile = urlencode($mobile);

$api = "http://bulksms.omegatelesolutions.com/api/send_transactional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile."";

$response = file_get_contents($api);

return $response;
		
	}
	
	
	public function sendattachedemail($body,$subject,$file,$to,$cc,$bcc,$from)
    {
        $path=$_SERVER["DOCUMENT_ROOT"].'/application/third_party/';
        require_once($path.'PHPMailer/class.phpmailer.php');
        date_default_timezone_set('Asia/Kolkata');
         require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
        
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        //$mail->SMTPDebug = 4;
        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        //Username to use for SMTP authentication
       $mail->Username = 'noreply10@sandipuniversity.edu.in';
		$mail->Password = 'pgef sqab ruxv cdvy';
		//Set who the message is to be sent from
		$mail->setFrom($from,'SANDIP UNIVERSITY');
		//$mail->AddAddress('kiran.valimbe@sandipuniversity.edu.in');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to pramod.karole@sandipuniversity.edu.in
    // $mail->addAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod Karole');
       $mail->AddAddress($to);
	   
	  // $mail->AddAddress('vighnesh.sukum@sandipuniversity.edu.in');
	   //$mail->AddCC($cc);
       //$mail->AddBCC($bcc);
        //Set the subject line
        $mail->Subject = $subject;
		$mail->isHTML(true);
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually

        $mail->Body = $body;


        $mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        if(!empty($file)){
			$mail->AddAttachment($file);
		}
        //send the message, check for errors
        if (!$mail->send()) {
           // echo 'Mailer Error: ' . $mail->ErrorInfo;
			return 0;
        } else {
          // echo 'Message sent!';
			return 1;
        }
    } 
	//////////////////////////////////////////////////////////////////////////////
    function send_sms_reset_password($mobile,$sms){
	
	$sms=urlencode($sms);
	
	
	//$sms=urlencode($sms_message);
    $smsGatewayUrl = "http://login.businesslead.co.in/api/mt/SendSMS?user=SANDIPFOUNDATION&password=ABC@789&senderid=SANDIP&channel=TRANS&DCS=0&flashsms=0&number=$mobile&text=$sms&route=22&peid=1107168069936498781";
	///$smsGatewayUrl = "http://bulksms.bulkfactory.in/api/v2/sms/send?access_token=b5bb44175fe4aafb9b7e3b7c482d4b8e&message=$sms&sender=SANDIP&to=$mobile&service=T";  
	$smsgatewaydata = $smsGatewayUrl;
	$url = $smsgatewaydata;
	$ch = curl_init();                       // initialize CURL
	curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);   	

    }	
}


?>