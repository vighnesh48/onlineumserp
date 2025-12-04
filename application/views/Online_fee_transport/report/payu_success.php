<?php
include 'header.php';
$user_id = $bank_ref_num;
//var_dump($stdata);


$path=$_SERVER["DOCUMENT_ROOT"].'/admission/application/views/admission/';
?>
<body>
<div id="wrapper" class="xtoggled">
  <div class="container-fluid"> 
    <!-- Sidebar -->
<?php include 'sidebar_menu.php';?>
    <!-- /#sidebar-wrapper --> 
    
    <!-- Page Content -->
    <div id="page-content-wrapper">
      <div class="container-fluid">
        <?php include 'topheader.php';?>
        <div class="row form-container">
          <div class="col-lg-12"> 
		 
            <!-- tabs -->
            <div class="tabbable">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#one" data-toggle="tab">Online Payment <i class="fa fa-angle-down" aria-hidden="true"></i> </a></li>
                
              </ul>
              <div class="tab-content form-tab">
                <div class="tab-pane active" id="one">

					<div class="col-lg-12">
							<p style="color:green">Transaction Success.</p>
                            
							<div class="clearfix">&nbsp;</div>
							<p class="text-center">Your payment has been received.  Your Transaction id# is:<b><?php   echo $txnid; ?></b></p>
                            <p class="text-center"></p>
                            <p class="text-center">You will receive payment confirmation receipt on email. Please provide the receipt for further reference.</p>
                          

					</div>
			
					
					<div class="clearfix">&nbsp;</div>
					<div class="clearfix">&nbsp;</div>
                </div>
              </div>
            </div>
            <!-- /tabs --> 
          </div>
        </div>
      </div>
    </div>
    <!-- /#page-content-wrapper --> 
  </div>
</div>
<!-- /#wrapper --> 

<!--Bootstrap core JavaScript--> 

<?php
//error_reporting(E_ALL); ini_set('display_errors', '1'); 
//ini_set('memory_limit', '-1');
/*require_once('tcpdf_config.php');
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




include($path."phpqrcode/qrlib.php");

//QRcode::png('PHP QR Code :)', 'test.png', 'L', 4, 2);
$tempDir = $_SERVER["DOCUMENT_ROOT"].'/payment/qrcodes-po/';
//$po_id = $p_row[0]['ord_no'];
$site_url1 = "https://www.sandipuniversity.com/payment/";
$codeContents = $site_url1.'check.php?po='.$user_id;

//print_r($codeContents);exit;

// we need to generate filename somehow, 
// with md5 or with database ID used to obtains $codeContents...
$fileName = 'qrcode-po' . $user_id . '.png';
$pngAbsoluteFilePath = $tempDir . $fileName;
$urlRelativeFilePath = $pngAbsoluteFilePath;

// generating
//if (!file_exists($pngAbsoluteFilePath)) {
QRcode::png($codeContents, $pngAbsoluteFilePath, 'L', 1, 2);
//}
//$output .='<table><tr><td height="20"></td></tr><tr><td><img src="'.$urlRelativeFilePath.'" /></td></tr></table>';
//qrcode code ends
global $qrimg;
$qrimg = $urlRelativeFilePath;

$site_url1 = "https://www.sandipuniversity.com/payment/";
//echo $fileName;


$name = $firstname;
$user_email = $email;
$mobile = $phone;
$feetype = $productinfo;
$amount = $amount;
$txtid = $txtid;
$date = $payment_date;
$receipt = $receipt_no;
$ref = $bank_ref_num;
// noumber to word conversion
$amount1 = convert_number_to_words($amount);
$ipAddress = $_SERVER['REMOTE_ADDR']; // ip address

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
<strong>Website:</strong> https://www.sandipuniversity.com<br>
<strong>Email:</strong> info@sandipuniversity.com<br>
<strong>Phone:</strong> (02594) 222541,42,43,44,45<br>
<strong>Fax:</strong> (02594) 222555
</td>

<td align="right" valign="top" style="padding:5px 5px 5px 5px;" height="30" ><img src="https://www.sandipuniversity.com/payment/qrcodes-po/'.$fileName.'" width="70"></td>
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
                Your Payment request has been successfully recorded. Please quote your transaction reference number for any further queries.
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
        '.$receipt.'
        </td>
    </tr>
        <tr>
        <th align="left">
          Transaction Date and Time 
        </th>
        <td>
        '.$date.'
        </td>
    </tr>
        <tr>
        <th align="left">
          Bank Reference Number
        </th>
        <td>
        '.$ref.'
        </td>
    </tr>
       
    <tr>
        <th align="left">
          Name of Student
        </th>
        <td>
         '.$name.'
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
         '.$mobile.'
        </td>
    </tr>
    <tr>
        <th align="left">
          Fees Type 
        </th>
        <td>
         '.$feetype.'
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
        '.ucwords($amount1).'
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
  <p style="margin:0px;font-size:12px;" align="center"> <i><strong>Corporate Office: 5<sup>th</sup> Floor,Koteshwar Plaza,J.N.Road,Mulund West.Mumbai(MH)-400080</strong></i></p>

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
    <img src="http://sandipuniversity.com/erp/assets/images/logo_form.png"  width="150"><br>
   A UNIVERSITY U/S 2(F) OF THE UGC ACT 1956 WITH<br>THE RIGHT TO CONFER DEGREE U/S 22 (1) GOVT. OF<br> MAHARASHTRA ACT. NO. XXXVIII OF 2015.
    
</td>
<td valign="top"  width="100%" colspan="3" style="padding:10px 0px 0px 20px;font-size:11px;">
<strong>Mahiravani, Trimbak Road, Nashik – 422 213,</strong><br> 
<strong>Website:</strong> https://www.sandipuniversity.com<br>
<strong>Email:</strong> info@sandipuniversity.com<br>
<strong>Phone:</strong> (02594) 222541,42,43,44,45<br>
<strong>Fax:</strong> (02594) 222555
</td>

<td align="right" valign="top" style="padding:5px 5px 5px 5px;" height="30" ><img src="https://www.sandipuniversity.com/payment/qrcodes-po/'.$fileName.'" width="70"></td>
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
                Your Payment request has been successfully recorded. Please quote your transaction reference number for any further queries.
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
        '.$receipt.'
        </td>
    </tr>
        <tr>
        <th align="left">
          Transaction Date and Time 
        </th>
        <td>
        '.$date.'
        </td>
    </tr>
        <tr>
        <th align="left">
          Bank Reference Number
        </th>
        <td>
        '.$ref.'
        </td>
    </tr>
       
    <tr>
        <th align="left">
          Name of Student
        </th>
        <td>
         '.$name.'
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
         '.$mobile.'
        </td>
    </tr>
    <tr>
        <th align="left">
          Fees Type 
        </th>
        <td>
         '.$feetype.'
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
        '.ucwords($amount1).'
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
  <p style="margin:0px;font-size:12px;" align="center"> <i><strong>Corporate Office: 5<sup>th</sup> Floor,Koteshwar Plaza,J.N.Road,Mulund West.Mumbai(MH)-400080</strong></i></p>

  </td>
  </tr>
  
  </table>

   </div>
</div>';




//include($path."mpdf/mpdf.php");

//$mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0); 
$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf = new mPDF('', '', 0, '0', 10, 10, 10, 0, 9, 9, 'L');


$stylesheet2 = file_get_contents('https://erp.sandipuniversity.com/assets/css/bootstrap.min.css');

$stylesheet = file_get_contents('style.css');



//$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
//$mpdf->WriteHTML($stylesheet2,1);
// $mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($output);
if($stdata[0]['admission_year']==1)
{
    $ye="FE";
}
if($stdata[0]['admission_year']==2)
{
    $ye="SE";
}

//$mpdf->Output();
$mpdf->Output($_SERVER['DOCUMENT_ROOT'].'/payment/chpdf/receipt_' . $user_id . '.pdf', 'F');
$subject="Sandip University Provisional Registration Ref. No. :".$stdata[0]['prov_reg_no'];
$message ="Dear ".$stdata[0]['student_name']."
Your provisional registration done successfully.
Please find the below details

Name : ".$stdata[0]['student_name']."
Reference Number : ".$stdata[0]['prov_reg_no']."
Course : ".$stdata[0]['sprogramm_name']."
Year :  ".$ye."
Fee Paid : ".$amount."
Thanks
Sandip University
";


require_once($path.'PHPMailer/class.phpmailer.php');

$email = new PHPMailer();

$email->Host = 'smtp.gmail.com';                 // Specify main and backup server
$email->Port = 587;                                    // Set the SMTP port
$email->SMTPAuth = true;                               // Enable SMTP authentication
$email->Username = 'developers@sandipuniversity.com';                // SMTP username
$email->Password = 'university@24';                  // SMTP password
$email->SMTPSecure = 'tls';       

$email->From = 'developers@sandipuniversity.com';
$email->FromName = 'Sandip University';
$email->Subject = "Sandip University Provisional Registration Ref. No. :".$stdata[0]['prov_reg_no'];
$email->Body = $message;
$email->AddAddress($user_email);
$email->AddBCC('balasaheb.lengare@carrottech.in');
//$email->AddBCC('hardik.gosavi@sandipuniversity.edu.in');
//$email->AddBCC('arvind.thasal@carrottech.in');
//$email->AddBCC('pramod.karole@gmail.com');


$file_to_attach = $_SERVER['DOCUMENT_ROOT'] . '/payment/chpdf/receipt_' . $user_id . '.pdf';

$email->AddAttachment($file_to_attach, 'receipt_' . $user_id . '.pdf');

$file_to_attach = $_SERVER['DOCUMENT_ROOT'] . '/payment/chpdf/admform_' . $registration_no . '.pdf';
$email->AddAttachment($file_to_attach, 'admform_' . $registration_no . '.pdf');

return $email->Send();

*/
?>
<?php include('footer.php');?>
</body>
</html>