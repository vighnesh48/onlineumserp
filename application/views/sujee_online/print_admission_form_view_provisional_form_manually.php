<?php
       // var_dump($bonafieddata);
        $name= $all_data[0]['student_name'];
        if($all_data[0]['gender']=='M')
        {
            $title ='Mr.';
            $tem='He';
        }
        else
        {
           $title ='Ms.'; 
            $tem='She';
        }
        
        if($all_data[0]['admission_year']==1)
        {
            $crsem ='1st Year';
        }
          if($all_data[0]['admission_year']==2)
        {
            $crsem ='2nd Year';
        }
        if($all_data[0]['admission_year']==3)
        {
            $crsem ='3rd Year';
        }
        if($all_data[0]['admission_year']==4)
        {
            $crsem ='4th Year';
        }
        if($all_data['admission_year']==5)
        {
            $crsem ='V';
        }
        if($all_data['admission_year']==6)
        {
            $crsem ='VI';
        }
        if($all_data['admission_year']==7)
        {
            $crsem ='VII';
        }
        if($all_data['admission_year']==8)
        {
            $crsem ='VII';
        }
        
        ?>
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
            <p align="center" style="font-size:15px!important;padding:0px 3%!important;line-height:24px!important"><strong>Neelam Vidya Vihar,Village Sijoul,Madhubani,Bihar</strong><br/>
               <span>Website</span> :http://www.sandipuniversity.edu.in <span>Email : </span>info.sijoul@sandipuniversity.edu.in</span>
               <span>Ph</span> : 1800-313-2714<br/>
            </p>
         </div>
		 
			      <h2 align="left" style="" class="men">Ref-:'.$all_data[0]['full_ref_no'].'</h2>
                  <h2 align="right" style="text-align:right!important; margin:auto!important;" class="men">Date-:'.$all_data[0]['date_in'].'</h2>
               
         <div>
            <h2 align="center" style="padding:10px 0px;text-align:center!important;"> <em>TO WHOMSOEVER IT MAY CONCERN<br>
Fee Structure for Session 2021-23</em></h2>
            <p>
			  This is to certify that <b>'.$all_data[0]['student_name'].'</b> D/O <b>'.$all_data[0]['father_name'].'</b> resident of </b>'.$all_data[0]['District'].' ,'.$all_data[0]['village'].'</b> has been
admitted in <b>'.$crsem.'</b> in Course:-<b>'.$all_data[0]['stream_name'].'</b> for the Academic
Year <b>2021 – 22</b> at Sandip University, Sijoul, Madhubani. The Course duration is <b>'.$all_data[0]['course_duration'].'</b> Years.
The approximate expenses for pursuing the above entire course are as under:</p>

<p><b>Academic Fees</b>


 <table  border="1" style="font-size:13px;border:#ddd solid 1px !important !important;border-collapse: collapse;width:100%!important;text-align:left!important;font-size:12px!important;">
        <tr>
         <th>Sr.No</th>
         <th>Particulars</th>
		 <th>1st Year</th>
		 <th>2nd Year</th>
		 <th>Total</th>
        </tr>
		<tr>
		<th>1</th>
		<th>Tuition Fee</th>
		<th>74,750</th>
		<th>74,750</th>
		<th>149,500</th>
		</tr>
		<tr>
		<th>2</th>
		<th>Other Fee</th>
		<th>74,750</th>
		<th>74,750</th>
		<th>149,500</th>
		</tr>
		<tr>
		<th>3</th>
		<th>Hostel Type-1</th>
		<th>36,000</th>
		<th>36,000</th>
		<th>72,000</th>
		</tr>
		<tr>
		<th>4</th>
		<th>Hostel Caution Money</th>
		<th>5000</th>
		<th>-</th>
		<th>5000</th>
		</tr>
		<tr>
		<th></th>
		<th>Total</th>
		<th>172,750</th>
		<th>167,750</th>
		<th>340,500</th>
		</tr>
      </table>
</p>

           
			<p>
			  In addition to the academic fees mentioned above, the following will be applicable:
			  <ol>
            <li>Hostel fee will be subject to yearly revision.</li>
            <li>Rs. ___-____ for Computer/Laptop if needed.</li>
            <li>The Fee once paid will not be Refunded.</li>
           
            </ol>
            </p>
			<p>All fee and charges indicated above are tentative and subject to revision by the
Management. <br>Note</p>
			
            <ol>
            <li>Kindly issue DD/Pay Order in favour of “SANDIP UNIVERSITY” A/C. No. :
50100212258694. HDFC Bank, IFSC Code: HDFC0000118 payable at Mumbai for academic fees</li>
            <li>Kindly issue DD/Pay Order in favour of “SANDIP FOUNDATION” A/C No.:
912010059716140,
Axis Bank, IFSC Code: UTIB0001486 Payable at Madhubani, for Hostel fee..</li>
            <li>Kindly issue DD/Pay Order in favour of “____________________” payable at ________ for
transport charges..</li>
            
            </ol><p>This certificate is issued to him / her for the Loan purpose on his / her own request</p>
         </div>
         <hr/>
      
            <div>
               <div style="width:50%;float:left;10px!important;">
                  <h4>Authorized Signatory. </h4>
                 
               </div>
               <div style="width:50%!important;;float:right!important;">
			   
                  <h4 align="right" style="text-align:right!important;padding-top:30%!important;vertical-align:baseline;" class="men"></h4>
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
echo $output;
 exit();
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
	   // $mail->AddAddress($per->email);
		$mail->AddAddress('kiran.valimbe@sandipuniversity.edu.in');
        //$mail->AddAddress('vighnesh.sukum@carrottech.in');
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