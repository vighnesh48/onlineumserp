<?php
$body = "Dear Student
To get your academic information and regular updates kindly logon to
https://www.sandipuniversity.edu.in/erp-login.php
<br>
Username: $username
Password: $password
<br>
Thanks
Sandip University
";
$subject="PRN Number With Login Details";
//$file=$_SERVER['DOCUMENT_ROOT'] . 'payment/chpdf/receipt_'.$user_id.'.pdf';

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
        $mail->Username   = 'noreply6@sandipuniversity.edu.in';  
        $mail->Password   = 'mztvpmklamlhjtac';
        //Set who the message is to be sent from
        $mail->setFrom('NoReply6@sandipuniversity.edu.in', 'Sandip University');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to pramod.karole@sandipuniversity.edu.in
    // $mail->addAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod Karole');
	    $mail->AddAddress($email);
		$mail->AddAddress('balasaheb.lengare@carrottech.in');
	//	$mail->AddAddress('vighnesh.sukum@carrottech.in');
	  // $mail->AddAddress('kamlesh.kasar@sandipuniversity.edu.in');
	  // $mail->AddAddress('pramod.thasal@carrottech.in');
       $mail->AddAddress('mihir.jha@sandipuniversity.edu.in');
       //$mail->AddAddress('kiran.valimbe@sandipuniversity.edu.in');
        //Set the subject line
        $mail->Subject = $subject;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually

        $mail->Body = $body;


        $mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
        
       // $mail->AddAttachment($file);
		//$mail->AddAttachment($provcertificate);
        //send the message, check for errors
       
	   
	   if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            //echo 'Message sent!';
			////header("location:thankyou");
		
        }
		
		if($mobile!=''){
		/*$username = $username;
$password = $password;
$sms_message ="Dear Student
To get your academic information and regular updates kindly logon to
https://www.sandipuniversity.edu.in/erp-login.php
Username: $username
Password: $password
Thank you
Sandip University.
";

//echo "<br>stu".$mobile.">>".$sms_message;exit;

	$mobile=$mobile;
	$sms=urlencode($sms_message);

	$smsGatewayUrl = "http://162.241.114.66/api/send_sms?api_key=3126098cf46a2ca0&text=$sms&mobiles=$mobile&unicode=0&sender_id=SANDIP&template_id=1108163170053606141";  
	$smsgatewaydata = $smsGatewayUrl;
	$url = $smsgatewaydata;
	/*$ch = curl_init();                       // initialize CURL
	curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);   */      
        
 // $s++;
  //exit;
 // echo 1;
}else{
	//echo 2;
    // }
}
		
		
?>