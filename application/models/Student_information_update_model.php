<?php


class Student_info_update_model extends CI_Model 
{ 

	function get_student_id_by_prn($enrollment_no){
	  $DB1 = $this->load->database('umsdb', TRUE);
			$DB1->select("stud_id,mobile");
			$DB1->from('student_master');
			$DB1->where("enrollment_no", $enrollment_no);
			$DB1->or_where("enrollment_no_new", $enrollment_no);
			$query=$DB1->get();
			$result=$query->row_array();
			return $result;
	}

	public function verify_student_mobile($post)
  	{
  		//print_r($post);die;
	 	$new_mobileno = $post['new_mobileno'];
	 	$stud_id = $post['student_code'];
	 	$email = $post['email'];
	 	$oldmobile = $post['oldmobile'];

		if($new_mobileno!='')
		{
			//echo "12";die;
		    $mobile= $new_mobileno; 
		    $DB1 = $this->load->database('umsdb', TRUE);
			$sql1 ="select * from student_master where  mobile ='$oldmobile'";
			$query1=$DB1->query($sql1);
			$result1=$query1->row_array();
			//print_r($result1);die;
		    if($result1['mobile'] == $oldmobile)
		   	{
		   		if($oldmobile  == $new_mobileno)
		   		{
		   			 echo 'Same Mobile No already registered.';
					 exit();
		   		}
		  		else
		  		{
		   			///	echo "2"; die;
					if($mobile=='' || strlen($mobile) < 10 || strlen($mobile) > 11 )
					{
					    echo 'Mobile Number not registered. Please contact student section';
					    exit();
					}
			
					$otp = rand(10000,99999);

					/*$sms_message ="Dear Staff
					Your OTP for Password Reset at Sandip University ERP is $otp
					Thank you
					Sandip University";
					*/

					//$sdata['mobile'] = $mobile ; 
					//$sdata['email'] = $email ; 

					$sdata['otp'] = $otp ; 
					$sdata['otp_date'] = date('Y-m-d') ; 
					$DB1 = $this->load->database('umsdb', TRUE);
					$DB1->where('stud_id',$stud_id);
					$DB1->update('student_master',$sdata);
                  
					$mess = urlencode("One time Password for Registration in Sandip University is:$otp");
					$smsGatewayUrl="http://login.businesslead.co.in/api/mt/SendSMS?user=SANDIPFOUNDATION&password=ABC@789&senderid=SANDIP&channel=TRANS&DCS=0&flashsms=0&number=$mobile&text=$mess&route=22&peid=1701159161247599930";
					//echo $smsGatewayUrl;die;
					$ch = curl_init();                       // initialize CURL
					curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
					curl_setopt($ch, CURLOPT_URL, $smsGatewayUrl);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$output = trim(curl_exec($ch));
					curl_close($ch); 
					//print_r($output);die;
					$response = json_decode($output, true);
					
					//print_r($response);die;
					if($response['status']== 1){
					 	return 'Y';
						//echo 'OTP has sent to your registered mobile number';
						exit();
					}

					else
					{
					 	echo 'Systeam Dely sms delivery';
						//print_r($output);
						exit();
					}
				}
			} 
		} 
		else
		{
			/*
			//echo "1";die;
			$emailid=$_POST['email']; 

			$DB1 = $this->load->database('umsdb', TRUE);
			$sql1 ="select * from student_master where  email ='$emailid'";
			$query1=$DB1->query($sql1);
			$result1=$query1->row_array();
			//echo $DB1->last_query(); die;
			//print_r($result1);die;
		    if(empty($result1['email']))
		   	{
		   		if($result1['email'] == $emailid)
		   		{
		   			 echo 'Same Emailid  already registered.';
					 exit();
		   		}
		   		else
		   		{

			        $otp = rand(10000,99999);
			        
		           	$subject="OTP For Registration";

		            $body="Your OTP for Registration : $otp";

		            $this->sendattachedemail($body,$emailid,$subject,'');  
		          	//return 'Y';
		          	//exit();
		           
		    	}
		    }
	      	else
	      	{
	      		 echo 'Same Emailid  already registered.';
				exit();
	      	}
			*/
		}
	}
	public function verify_student_mobile_otp($post)
  	{
  		//echo "1"; die;
	 	$new_mobileno = $post['new_mobileno'];
	 	$stud_id = $post['student_code'];
	 	$otp = $post['otp'];
	 	$email = $post['email'];
		if($stud_id!='')
		{
		    $mobile= $new_mobileno; 
			$DB1 = $this->load->database('umsdb', TRUE);
			$sql ="select * from student_master where  stud_id ='$stud_id'
			 AND otp ='$otp' ";
			$query=$DB1->query($sql);
			// echo $DB1->last_query();exit;
			$result=$query->result_array();
			if(isset($result))
			{
				$sdata['mobile'] = $mobile ; 
				$sdata['email'] = $email ; 
				$DB1 = $this->load->database('umsdb', TRUE);
				$DB1->where('stud_id',$stud_id);
				$DB1->update('student_master',$sdata);
				//echo $DB1->last_query(); exit;
				echo "Y";
			}
			else
			{
				echo 'OTP Not Match Please try again';
			}
		}
	} 
	
	public function verify_student_email($post)
	{

			//echo "1";die;
			$emailid=$post['email']; 
			$DB1 = $this->load->database('umsdb', TRUE);
			$sql1 ="select * from student_master where  email ='$emailid'";
			$query1=$DB1->query($sql1);
			$result1=$query1->row_array();
			//echo $DB1->last_query(); die;
			//print_r($result1);die;
		    if(empty($result1['email']))
		   	{
					//echo "1"; die;
					
		  
			        $otp = rand(10000,99999);
			        
		           	$subject="OTP For Registration";

		            $body="Your OTP for Registration : $otp";

		         $data=   $this->sendattachedemail($body,$emailid,$subject,'');  
		          	echo   $data;
		          	//exit();
		           
		    	
				
				
		    }
	      	else
	      	{
				//echo "2"; die;
				
	      		 echo 'Same Emailid  already registered.';
				exit();
	      	}

		
	}
	public function verify_student_email_otp($post)
  	{
  		
	 	$stud_id = $post['student_code'];
	 	$otp = $post['otp'];
	 	$email = $post['email'];
		if($stud_id!='')
		{
			$DB1 = $this->load->database('umsdb', TRUE);
			$sql ="select * from student_master where  stud_id ='$stud_id'
			 AND otp ='$otp' ";
			$query=$DB1->query($sql);
			// echo $DB1->last_query();exit;
			$result=$query->result_array();
			if(isset($result))
			{
				$sdata['email'] = $email ; 
				$DB1 = $this->load->database('umsdb', TRUE);
				$DB1->where('stud_id',$stud_id);
				$DB1->update('student_master',$sdata);
				//echo $DB1->last_query(); exit;
				return "Y";
			}
			else
			{
				return 'OTP Not Match Please try again';
			}
		}
	} 
	
	

	/*

	function sendattachedemail($subject,$body,$email){

		//require_once('../PHPMailer-master/class.phpmailer.php');
        //require_once("../PHPMailer-master/PHPMailerAutoload.php");
      	$this->load->library('smtp');
	    $this->load->library('phpmailer');
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
        $mail->Username = 'Kiran.Valimbe@sandipuniversity.edu.in';
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
        $mail->Password = 'Kiran@321!';
        //Set who the message is to be sent from
        $mail->setFrom('noreply@sandipuniversity.com', 'Sandip University Registration');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
       // $mail->addAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod Karole');
        $mail->addAddress('balasaheb.lengare@carrottech.in', 'Pramod Karole');
        $mail->AddAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = 'This is a plain-text message body';
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit();
        } else {
            return Y;
            exit();
            
        }
	}
	*/
	public function sendattachedemail($subject,$body,$email)
    {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$path=$_SERVER["DOCUMENT_ROOT"].'/erp/application/third_party/';
		require_once($path.'PHPMailer/class.phpmailer.php');
		date_default_timezone_set('Asia/Kolkata');
		require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
		
		
		
		
		
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
        $mail->Username = 'noreply@sandipuniversity.com';
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
          $mail->Password = 'kiran234!';
        //Set who the message is to be sent from
        $mail->setFrom('info@sandipuniversity.edu.in', '');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
       // $mail->addAddress('chaitali.veer@sandipfoundation.org', 'Chaitali');
        $mail->AddAddress('balasaheb.lengare@carrottech.in', 'balasaheb');
		$mail->AddAddress('vighnesh.sukum@sandipuniversity.edu.in', 'vighnesh');
		// $mail->AddAddress('ushakar.jha@sandipuniversity.edu.in', 'ushakar');
		//$mail->AddAddress('pankaj.mali@sandipuniversity.edu.in', 'pankaj');
		$mail->AddAddress($email);
		//$mail->AddAddress('pramod.thasal@carrottech.in', 'Pramod');
		//$mail->AddAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod');
        //Set the subject line
        $mail->Subject = $subject;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        //Replace the plain text body with one created manually

        $mail->Body = $body;

        if (!$mail->send()) {
            return 'N';
        } else {
            return 'Y';
        }

	
       /* $path=$_SERVER["DOCUMENT_ROOT"].'/erp/application/third_party/';
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
        $mail->Username = 'noreply@sandipuniversity.com';
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
          $mail->Password = 'kiran234!';
        //Set who the message is to be sent from
        $mail->setFrom('info@sandipuniversity.edu.in', '');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
        $mail->addAddress('harshad.patel@sandippolytechnic.org', 'Harshad');
        $mail->AddAddress('balasaheb.lengare@carrottech.in', 'balasaheb');
		//$mail->AddAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod');
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
       
        $mail->AddAttachment($file);
        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
			exit();
        } else {
            //echo 'Message sent!';
			return 'Y';
            exit();
        }
		*/
		
		
    } 
}

?>