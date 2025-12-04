<?php
//require("../inc/config2.php");
//include("../header.php");
//error_reporting(E_ALL); 
//ini_set('display_errors', 1);
//var_dump($hash);
//exit(0);
//	echo "****************";

//unset($_REQUEST);
//unset($_POST);

//composer require picqer/php-barcode-generator

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;
 
$this->load->library('Awssdk');
$this->bucket_name = 'erp-asset';


?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<style>
.contact_des h4 {
    font-size: 28px;font-weight:bold;
    margin: 7px 0px 7px 0px;text-transform: uppercase;
}
.contact_des p{font-size: 17px;}
.contact_des h4 span {
    color:green;
}
.contact_des button{font-size:21px;margin-bottom:0;}
section{padding-bottom:0px;}
.inputs_des{margin-bottom:0;}
.form-group{margin-bottom:10px;}
.kf_inr_banner{background-image:url(../images/inrbg-form.jpg);}
.kf_inr_banner:before{background: rgba(0,0,0,0.5);}
.contact_2_headung{margin-bottom:0px;border-bottom:0px;}
.contact_2_headung::before{display:none;}
.pay-form-bg{margin-bottom:40px;}
</style>
</head>
<body>
	<!--KF KODE WRAPPER WRAP START-->
    <div class="kode_wrapper">
    <!--<div class="loader"></div>-->
    <!-- register Modal -->
<?php
//include("../main_menu.php");

?>
<!--HEADER END-->

        <!--Banner Wrap Start-->

<?php
//error_reporting(E_ALL); ini_set('display_errors', '1'); 
//ini_set('memory_limit', '-1');

if($user_id !=''){
require_once('tcpdf_config.php');
require_once('tcpdf.php');



function convert_number_to_words($number) {

    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
 
}





$amount1 = ucwords(convert_number_to_words($amount));




$site_url = base_url();


$user_id  = $bank_ref_num;

$ipAddress = $_SERVER['REMOTE_ADDR'];

			include_once "phpqrcode/qrlib.php";
		//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
		//$tempDir = $_SERVER['DOCUMENT_ROOT'] . 'payment/qrcodes-po/';
		$tempDir = 'uploads/online_payment/';
			//Check if the directory already exists.
			if(!is_dir($tempDir)){
				//Directory does not exist, so lets create it.
				mkdir($tempDir, 755, true);
			}
		//$po_id = $p_row[0]['ord_no'];
	//	$site_url= $site_url."payment/";
		$codeContents = $site_url.'check.php?po='.$user_id;
		
		// we need to generate filename somehow, 
		// with md5 or with database ID used to obtains $codeContents...
		$fileName = 'qrcode_'.$user_id.'.jpg';		
		$pngAbsoluteFilePath = $tempDir.$fileName;
		$urlRelativeFilePath = $pngAbsoluteFilePath;
		
		// generating
		//if (!file_exists($pngAbsoluteFilePath)) {
		//QRcode::png($codeContents, $pngAbsoluteFilePath,'L', 1, 2);			
		//}
		//$output .='<table><tr><td height="20"></td></tr><tr><td><img src="'.$urlRelativeFilePath.'" /></td></tr></table>';
		//qrcode code ends
		global $qrimg;
		$qrimg = $urlRelativeFilePath;

        $qr = QrCode::create($codeContents);
        $writer = new PngWriter();
        $result = $writer->write($qr);
        $qrCodeData = $result->getString();             
        $qrCodeDataImg = base64_encode($qrCodeData);
        
//echo $fileName;

if($productinfo==2)
{
    $ftype = "Admission";
}
elseif($productinfo==5)
{
    $ftype = "Examination";
}

$output ='<div style="width:100%;height:842px;margin:0 auto;">
		<div style="border:1px solid #000">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;height:415px;">
<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="border-spacing:0px" border-spacing="0">
<tr>
<td valign="top" align="left"  style="padding:5px 5px 5px;font-size:8px;">
    <img src="https://erp.sandipuniversity.com/assets/images/logo_form.png"  width="150"><br>
   A UNIVERSITY U/S 2(F) OF THE UGC ACT 1956 WITH<br>THE RIGHT TO CONFER DEGREE U/S 22 (1) GOVT. OF<br> MAHARASHTRA ACT. NO. XXXVIII OF 2015.
    
</td>
<td valign="top"  width="100%" colspan="3" style="padding:10px 0px 0px 20px;font-size:11px;">
<strong>Mahiravani, Trimbak Road, Nashik – 422 213,</strong><br> 
<strong>Website:</strong> https://www.sandipuniversity.edu.in<br>
<strong>Email:</strong> info@sandipuniversity.com<br>
<strong>Phone:</strong> (02594) 222541,42,43,44,45<br>
<strong>Fax:</strong> (02594) 222555
</td>

<td align="right" valign="top" style="padding:5px 5px 5px 5px;" height="30" ><img src="data:image/png;base64,'.$qrCodeDataImg.'" width="70"></td>
</tr>


</table>

</td>
</tr>

<tr>
    <td colspan="2" style="padding:0 5px 0 0px;border-top:1px solid #000" height="30">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="">
            <tr>
                <td align="left" width="100%"><h3 style="padding:0px;margin:0px;font-size:15px">Thank You.</h3></td>
                
            </tr>
            <tr>
                <td align="left" width="100%" style="font-size:11px;">
                Your Payment request has been successfully recorded. Please note your transaction reference number for any further queries.
                </td>
                
            </tr>
        </table>
    </td>
    
</tr>
  

  

  
  
 
   <tr>
    <td colspan="2" style="height:150px;vertical-align: top;padding:0px" align="right">
    <table width="100%" border="1" cellspacing="0" cellpadding="3" align="center" style="border-spacing:0px;font-size:12px">
    <tr>
    <th colspan="2" align="left">Transaction Details</th>
    </tr>
    <tr>
    
        <th width="200px" align="left">
           Receipt No.  
        </th>
        <td width="400px">
        '.$udf1.'
        </td>
    </tr>
        <tr>
        <th align="left">
          Transaction Date and Time 
        </th>
        <td>
        '.$addedon.'
        </td>
    </tr>
        <tr>
        <th align="left">
          Bank Reference Number
        </th>
        <td>
        '.$bank_ref_num.'
        </td>
    </tr>
    <tr>
        <th align="left">
          PRN
        </th>
        <td>
         '.$udf3.'
        </td>
    </tr>   
    <tr>
        <th align="left">
          Name of Student
        </th>
        <td>
         '.$firstname.'
        </td>
    </tr>
    <tr>
        <th align="left">
          Email
        </th>
        <td>
        '.$email.'
        </td>
    </tr>
    <tr>
        <th align="left">
          Mobile No
        </th>
        <td>
         '.$udf4.'
        </td>
    </tr>
	
    <tr>
        <th align="left">
          Fees Type 
        </th>
        <td>
         '.$productinfo.'
        </td>
    </tr>
    <tr>
        <th align="left">
          Amount 
        </th>
        <td>
        '.$amount.'
        </td>
    </tr>
 
     <tr>
        <th align="left">
          Amount in words
        </th>
        <td>
        '.$amount1.'
        </td>
    </tr>

    
   </table>
   <br>
   <p style="margin:10px 0px 0px;font-size:11px;" align="right"><strong>Host Ip : '.$ipAddress.'</strong></p>
    </td>
    
  </tr> 
  <tr>
  <td colspan="2" height="20" style="padding:0" align="center">
   <br>   
  <p style="margin:0px;font-size:12px;" align="center"> <i><strong>Corporate Office: 1<sup>st</sup> Floor,Manisha Pride, J.N.Road,Mulund West.Mumbai(MH)-400080</strong></i></p>

  </td>
  </tr>
  
  </table>

   </div><br><br>
<hr style="border:dotted 1px #000" />
 <br><br><br>

<div style="border:1px solid #000">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;height:415px;">
<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="border-spacing:0px" border-spacing="0">
<tr>
<td valign="top" align="left"  style="padding:5px 5px 5px;font-size:8px;">
    <img src="https://erp.sandipuniversity.com/assets/images/logo_form.png"  width="150"><br>
   A UNIVERSITY U/S 2(F) OF THE UGC ACT 1956 WITH<br>THE RIGHT TO CONFER DEGREE U/S 22 (1) GOVT. OF<br> MAHARASHTRA ACT. NO. XXXVIII OF 2015.
    
</td>
<td valign="top"  width="100%" colspan="3" style="padding:10px 0px 0px 20px;font-size:11px;">
<strong>Mahiravani, Trimbak Road, Nashik – 422 213,</strong><br> 
<strong>Website:</strong> https://www.sandipuniversity.com<br>
<strong>Email:</strong> info@sandipuniversity.com<br>
<strong>Phone:</strong> (02594) 222541,42,43,44,45<br>
<strong>Fax:</strong> (02594) 222555
</td>

<td align="right" valign="top" style="padding:5px 5px 5px 5px;" height="30" ><img src="data:image/png;base64,'.$qrCodeDataImg.'" width="70"></td>
</tr>


</table>

</td>
</tr>

<tr>
    <td colspan="2" style="padding:0 5px 0 0px;border-top:1px solid #000" height="30">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="">
            <tr>
                <td align="left" width="100%"><h3 style="padding:0px;margin:0px;font-size:15px">Thank You.</h3></td>
                
            </tr>
            <tr>
                <td align="left" width="100%" style="font-size:11px;">
                Your Payment request has been successfully recorded. Please note your transaction reference number for any further queries.
                </td>
                
            </tr>
        </table>
    </td>
    
</tr>
  

  

  
  
 
   <tr>
    <td colspan="2" style="height:150px;vertical-align: top;padding:0px" align="right">
    <table width="100%" border="1" cellspacing="0" cellpadding="3" align="center" style="border-spacing:0px;font-size:12px">
    <tr>
    <th colspan="2" align="left">Transaction Details</th>
    </tr>
    <tr>
    
        <th width="200px" align="left">
           Receipt No.  
        </th>
        <td width="400px">
        '.$udf1.'
        </td>
    </tr>
        <tr>
        <th align="left">
          Transaction Date and Time 
        </th>
        <td>
        '.$addedon.'
        </td>
    </tr>
        <tr>
        <th align="left">
          Bank Reference Number
        </th>
        <td>
        '.$bank_ref_num.'
        </td>
    </tr>
     <tr>
        <th align="left">
          PRN
        </th>
        <td>
         '.$udf3.'
        </td>
    </tr>  
    <tr>
        <th align="left">
          Name of Student
        </th>
        <td>
         '.$firstname.'
        </td>
    </tr>
    <tr>
        <th align="left">
          Email
        </th>
        <td>
        '.$email.'
        </td>
    </tr>
    <tr>
        <th align="left">
          Mobile No
        </th>
        <td>
         '.$udf4.'
        </td>
    </tr>
    <tr>
        <th align="left">
          Fees Type 
        </th>
        <td>
         '.$productinfo.'
        </td>
    </tr>
    <tr>
        <th align="left">
          Amount 
        </th>
        <td>
        '.$amount.'
        </td>
    </tr>
     <tr>
        <th align="left">
          Amount in words
        </th>
        <td>
        '.$amount1.'
        </td>
    </tr>


   </table>
   <br> 
   
   <p style="margin:10px 0px 0px;font-size:11px;" align="right"><strong>Host Ip : '.$ipAddress.'</strong></p>
    </td>
    
  </tr>
  <tr>
  <td colspan="2" height="20" style="padding:0" align="center">
 <br>   
  <p style="margin:0px;font-size:12px;" align="center"> <i><strong>Corporate Office: 1<sup>st</sup> Floor,Manisha Pride, J.N.Road,Mulund West.Mumbai(MH)-400080</strong></i></p>

  </td>
  </tr>
  
  </table>

   </div>
</div>';




//echo $output;
//exit();

include("mpdf/mpdf.php");
 
$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf= new mPDF('','', 0, '0', 10, 10, 10, 0, 9, 9, 'L');


$stylesheet2 = file_get_contents(base_url.'assets/css/bootstrap.min.css');

$stylesheet = file_get_contents('style.css');

 
$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list

$mpdf->WriteHTML($output);
$output = $mpdf->Output('', 'S');
//$mpdf->Output($tempDir.'/'.$user_id.'.pdf', "F");
//$mpdf->Output('https://erp.sandipuniversity.com/uploads/payment/chpdf_new/receipt_'.$user_id.'.pdf', 'F');
$file=$tempDir.$user_id.'.pdf';
$result = $this->awssdk->uploadFileContent($this->bucket_name, $file, $output);

$file_name = $user_id.'.pdf';
$pdfContent = $output;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//$user_mobile = $udf4."9960006338,8850633088";//$udf4;
//$user_mobile = $udf4.",9545453488,9545453097,7030942420,8850633088";//$udf4;
      // $ch = curl_init();
   
   
   

   



//////////////////////////////////////////////////////////////////////////////////////

//$emailu = $email;


//require_once('PHPMailer/class.phpmailer.php');


$body = "Hi $firstname

Payment of Rs $amount received for sandip university and transaction no -:$txnid.

Kindly contact account section for Payment Receipt.


Thanks
Sandip University

";
$subject="SUN-Payment Receipt-".$productinfo;
//$file=$_SERVER['DOCUMENT_ROOT'] . 'payment/chpdf/receipt_'.$user_id.'.pdf';

  $path=$_SERVER["DOCUMENT_ROOT"].'application/third_party/';

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
      //  $mail->Host = 'ssl://mail360-smtp.zoho.in';
	   $mail->Host = 'smtp.gmail.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = 465;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
		$mail->Username   = 'noreply6@sandipuniversity.edu.in';  
        $mail->Password   = 'mztvpmklamlhjtac';
        //Username to use for SMTP authentication
       // $mail->Username = 'kishor.mehare@sandipuniversity.com';
        //Password to use for SMTP authentication
        //$mail->Password = '123Indi@';
       // $mail->Password = 'M360.C6700px6B87mS70k71x6700q.b6ln7mkS873JKELo4Rggi775Fm087BkKCl25M07S';
        //Set who the message is to be sent from
        $mail->setFrom('NoReply6@sandipuniversity.edu.in', 'SUN');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to pramod.karole@sandipuniversity.edu.in
    // $mail->addAddress('pramod.karole@sandipuniversity.edu.in', 'Pramod Karole');
       $mail->AddAddress($email);
	   $mail->AddAddress('kamlesh.kasar@sandipuniversity.edu.in');
	   //$mail->AddAddress('pramod.thasal@carrottech.in');
       $mail->AddAddress('balasaheb.lengare@carrottech.in');
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

        $mail->addStringAttachment($pdfContent, $file_name, 'base64', 'application/pdf');
        //$mail->AddAttachment($file);
        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
			////header("location:thankyou");
		
        }

}
//header("location:Thankyou?user_id=$user_id&txnid=$txnid");
/*
$email = new PHPMailer();
$email->From      = 'developers@sandipuniversity.com';
$email->FromName  = 'Sandip University';
$email->Subject   = 'Sandip University Online Payment';
$email->Body      = $message;
$email->AddAddress($emailu);
//$email->AddBCC('arvind.thasal@carrottech.in');
//$email->AddBCC('pramod.thasal@carrottech.in');
//$email->AddBCC('fo@sandipuniversity.edu.in');
$email->AddAddress('balasaheb.lengare@carrottech.in');
$email->AddAddress('kiran.valimbe@sandipuniversity.edu.in');
$file_to_attach = $_SERVER['DOCUMENT_ROOT'] . 'payment/chpdf/receipt_'.$user_id.'.pdf';

//$email->AddAttachment( $file_to_attach , 'receipt_'.$user_id.'.pdf' );

$email->Send();

//header("location:thankyou.php?user_id=$user_id&txnid=$txnid");
//	echo "****************";
*/
?></div>
</body>
</html>













