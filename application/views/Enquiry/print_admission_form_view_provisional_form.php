
<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//include("mpdf/mpdf.php");
//include("mpdf/mpdf.php");
$basepath = base_url();

$tempDir = $_SERVER['DOCUMENT_ROOT'].'/erp/uploads/online_payment/';
if(!is_dir($tempDir)){
mkdir($tempDir, 0755, true);
}

$course_naem=$course[0]['stream_name'];
$current_sem=$per->current_semester;
$school_name=$course[0]['school_name'];
$output ='<html>
<Head>
	<title>
	Provisional Certificate
</title>

</Head>
   <body>
      <div style="width:100%!important; margin:auto!important;padding:20px 30px!important;">
         <div  align="center" style="text-align:center!important;">
            <img src="https://www.sandipuniversity.edu.in/images/sandip-university-logo.png" alt="Sandip University Logo"><br/>
            <p align="center" style="font-size:15px!important;padding:0px 3%!important;line-height:24px!important"><strong>Mahiravani, Trimbak Road, Nashik – 422 213</strong><br/>
               <span>Website</span> :http://www.sandipuniversity.edu.in <span>Email : </span>info@sandipuniversity.edu.in</span>
               <span>Ph</span> : (02594) 222 541/42 <span>Fax</span>: (02594) 222 545<br/>
            </p>
         </div>
         <div>
            <h2 align="center" style="padding:10px 0px;text-align:center!important;"> <em>PROVISIONAL ADMISSION LETTER</em></h2>
            <p>
			   To,<br/>
               Dear Candidate Mast. /Ms. '. $per->first_name.'
           
			<p>
			  It gives us immense pleasure to inform you that you have beenprovisionally admitted to the program – <span><i><b>'.$course_naem.'</i> Semester '.$current_sem.'</span> in the <span>Sandip
               University’s '.$school_name.'</span> in the Academic Year-2020-21 on the following terms:
            </p>
			
            <ol>
            <li>You will submit all original documents along with one attested Photocopy (list is Attached).</li>
            <li>The Provisional Admission will be finalized by the authorities of Sandip University after verification of all original documents. If any deficiency or false document is identified, the provisional admission will be cancelled automatically.</li>
            <li>You have to remit the Academic Fees and other Fees as per the rule after verification of all concerned documents and after the satisfaction of the authorities of Sandip University.</li>
            <li>You will follow all the rules and regulations as prescribed from time to time of Sandip University, Nashik.</li>
            </ol>
         </div>
         <hr/>
      
            <div>
               <div style="width:50%;float:left;10px!important;">
                  <h4>Receipt No. </h4>
                  <h4>Date:</h4>
                  <h4>Place:</h4>
               </div>
               <div style="width:50%!important;;float:right!important;">
			   
                  <h4 align="right" style="text-align:right!important;padding-top:30%!important;vertical-align:baseline;" class="men">Registrar</h4>
               </div>
            </div>
          <div style="clear:both!important;"></div>
        
		   <hr/>
      </div>
   </body>
</html>';
$body = "Hi $per->first_name

Below Attached is form Copy.

Kindly contact Student section for Further process.

Thanks
Sandip University

";
 
$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf= new mPDF('','', 0, '0', 10, 10, 10, 0, 9, 9, 'L');
$stylesheet2 = file_get_contents(base_url().'assets/css/bootstrap.min.css');
$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
$mpdf->WriteHTML($output);
$mpdf->Output($tempDir.'Provisional.pdf', "F");
$file=$tempDir.'Provisional.pdf';

$subject="Provisional certificate ";
$path=$_SERVER["DOCUMENT_ROOT"].'/erp/application/third_party/';
        require_once($path.'PHPMailer/class.phpmailer.php');
        date_default_timezone_set('Asia/Kolkata');
         require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'ssl://mail360-smtp.zoho.in';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Username = 'kishor.mehare@sandipuniversity.com';
        $mail->Password = 'M360.C6700px6B87mS70k71x6700q.b6ln7mkS873JKELo4Rggi775Fm087BkKCl25M07S';
        $mail->setFrom('noreply@sandipuniversity.com', 'SUN');
	    //$mail->AddAddress($per->email);
		//$mail->AddAddress('ar@sandipuniversity.edu.in');
        $mail->AddAddress('kiran.valimbe@sandipuniversity.edu.in');
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = 'This is a plain-text message body';
        $mail->AddAttachment($file);
        if (!$mail->send()) {
			//echo "dd";
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
			//echo "ssdd";
            //echo 'Message sent!';
			////header("location:thankyou");		
        }
		//echo $output;
?>


		
</body>
</html>