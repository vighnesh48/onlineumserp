<html>

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sandip University</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
td, th {
    padding: 10px!important;
}
table td {

    border: #ccc solid 1px!important;
}
</style>
</head>
<body style="font-family:arial !important;
    font-weight: 400;">
<?php
//echo print_r($Enquiry_data['enquiry_no']);
//exit;
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include("mpdf/mpdf.php");

$basepath = base_url();

$tempDir = $_SERVER['DOCUMENT_ROOT'].'/ic_erp/uploads1/student_document/';
if(!is_dir($tempDir)){
mkdir($tempDir, 0755, true);
}

if($Enquiry_data['admission_type']==1){
	$admission_year='First Year';
}else{
	$admission_year='Direct Second Year';
}
//<strong>Address :</strong>Mahiravani, Trimbak Road, Nashik, Maharashtra 422 213.<br>
$output ='<div class="container" style="width: 600px;margin:auto;padding:5px;background: #eee;">
  <div class="row main-wrapper" style="background: #f4f4f4;
    padding-top: 5px;padding:5px;
    font-size: 10px;">
   <div class="col-sm-9" style="float:left;width:70%;">
   <img src="'.base_url().'assets/images/sandip-university-logo.png" class="ximg-responsive" width="180">
  
   </div>
   <div class="col-sm-3 pull-right"  style="float:right;width:30%;">
  <strong style="font-size: 12px;">Enquiry No :</strong> '.$Enquiry_data['enquiry_no'].'
  <br><strong style="font-size: 12px;">Provisional No :</strong> '.$Enquiry_data['provisional_no'].'
</div>
<div class="clear:both"></div>
    <div class="col-md-12" style="float:left;width:100%;">
      <p class="head-add" style="font-size: 12px"><strong>Toll Free :</strong>1800-212-2714 &nbsp;|&nbsp;<strong> Website :</strong> www.sandipuniversity.edu.in</p>
    </div>

    <div class="col-lg-12 heading-1" style="background: #CCC;
	text-align: center">
      <h5 style="font-size: 14px;
	text-transform: uppercase;
	margin-top: 3px;
	margin-bottom: 3px;
	font-weight: bold;">Provisional Admission Form 2022-23</h5><strong style="font-size: 12px;" class="pull-right">version :</strong> 1.'.$Enquiry_data['version'].'
    </div>
  </div>
  
  <div class="row detail-bg" style="background: #eee;">
    <div class="col-lg-12 np" style="padding: 0">
      <h2 class="detail-heading" style="background: red;
	color: #fff;
	margin: 0px;
	font-size: 12px!important;
	font-weight:bold!important;
	padding: 5px 0 5px 15px;
	text-transform: uppercase;
margin: 10px;">COURSE INFORMATION </h2>
    </div>
    <div class="col-lg-12" style="padding:10px;"> 
      <table class="table" cellspacing="5" cellpadding="5"  style="border-collapse: collapse;width:100%!important;border:#ddd solid 1px!important;text-align:left!important;font-size:12px!imporatnt;">
  <tr>
    <th scope="col" style="font-size:12px;text-align:left!important;">&nbsp;Admission year: '.$admission_year.'&nbsp;</th>
	<th scope="col" style="font-size:12px;text-align:left!important;">&nbsp;&nbsp;&nbsp;</th>
	<th scope="col" style="font-size:12px;text-align:left!important;">&nbsp;Date: '.date("d-m-Y", strtotime($Enquiry_data['date_enter'])).'&nbsp;</th>
	</tr>
	
	</table>
	  
	  
	  
	  <table class="table" cellspacing="5" cellpadding="5" border="1" style="border-collapse: collapse;width:100%!important;border:#ddd solid 1px!important;text-align:left!important;font-size:12px!imporatnt;">
  <tr>
    <th scope="col" style="font-size:12px;text-align:left!important;">School Name.</th>
    <th scope="col" style="font-size:12px;text-align:left!important;">Course Name</th>
	<th scope="col" style="font-size:12px;text-align:left!important;">Stream Name</th>
  </tr>';
 
  $srNo=1;
 //foreach($course as $val){
 $output .='<tr>
    <td style="font-size:12px;text-align:left!important;">'.$Enquiry_data['school_name'].'</td>
    <td style="font-size:12px;text-align:left!important;">'.$Enquiry_data['course_short_name'].'</td>
	<td style="font-size:12px;text-align:left!important;">'.$Enquiry_data['stream_name'].'</td></tr>';
 
	$srNo++;
//	}
	  
$output .='</table>

    </div>
  </div>
  <div class="row detail-bg" style="background: #eee;">
    <div class="col-lg-12 np" style="padding: 0">
      <h2 class="detail-heading" style="background: red;
	color: #fff;
	margin: 0px;
		font-size: 13px!important;
	font-weight:bold!important;
	padding: 5px 0 5px 15px;
	text-transform: uppercase;
margin: 10px;">Personal Information</h2>
    </div>
    <div class="col-lg-12" style="padding:10px;">
      <table  border="1" style="font-size:13px;border:#ddd solid 1px !important !important;border-collapse: collapse;width:100%!important;text-align:left!important;font-size:12px!important;">
        <tr>
          <td  width="120"><strong>Student Name :</strong></td>
          <td>'.$Enquiry_data['first_name'].' '.$Enquiry_data['middle_name'].' '.$Enquiry_data['last_name'].'</td>
        
        </tr>
        <tr>
          <td><strong>Address :</strong></td>
          <td valign="top" c>
         
              
             <strong>City :</strong> '.$Enquiry_data['taluka_name'].'<strong> &nbsp; &nbsp;State :</strong> '.$Enquiry_data['state_name'].'&nbsp; <strong>Pincode :</strong> '.$Enquiry_data['pincode'].'<strong>
			  </td>
			 
        </tr>
        <tr>
          <td ><strong>Contact Details:</strong></td>
          <td><strong>mobile:&nbsp;</strong>'.$Enquiry_data['mobile'].'<strong> &nbsp; &nbsp;Email :</strong> '.$Enquiry_data['email_id'].'&nbsp; <strong></td>
		  
        </tr>
       
        <tr>
          <td><strong>Category :</strong></td>
          <td>'.$Enquiry_data['category'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Aadhar Card:&nbsp;</strong>'.$Enquiry_data['aadhar_card'].'<strong> &nbsp;</td>
		  
        </tr>
          <tr>
          <td><strong>Last Qualification :</strong></td>
          <td>'.$Enquiry_data["last_qualification"].'<strong> &nbsp; &nbsp;Percentage :</strong> '.$Enquiry_data["qualification_percentage"].'%&nbsp; <strong></td>
		  
        </tr>
      </table>
    </div>
  </div>';
 if(($Enquiry_data["form_taken"]=="Y")){
	
  $output .='<div class="row detail-bg" style="background: #eee;">
    <div class="col-lg-12 np" style="padding: 0">
      <h2 class="detail-heading" style="background: red;
	color: #fff;
	margin: 0px;
		font-size: 13px!important;
	font-weight:bold!important;
	padding: 5px 0 5px 15px;
	text-transform: uppercase;
	font-weight: 600;margin: 10px;">Form Detail</h2>
    </div>
    <div class="col-lg-12" style="padding:10px;">
      <table class="table" cellspacing="5" cellpadding="5" border="1" style="border-collapse: collapse;width:100%!important;border:#ddd solid 1px!important;text-align:left!important;font-size:12px!important;">
  <tr>
  <td><strong>Form No : </strong>'.$Enquiry_data["form_no"].'</td><td>&nbsp;<strong>Payment Type : </strong>'.$Enquiry_data["payment_mode"].' &nbsp; </td><td><strong>Receipt No :</strong> '.$Enquiry_data["recepit_no"].'</td></tr>
  <tr>';?>
    
	<?php // if(($Enquiry_data["payment_mode"]=="CHLN")||($Enquiry_data["payment_mode"]=="CASH")){}else{ ?>
   <?php  //$output .='<td><strong>Receipt No :</strong> '.$Enquiry_data["recepit_no"].' &nbsp;&nbsp; </td>'; ?>
    <?php //} 
  $output .='</tr>
    <tr>
    
  </tr>
  <tr>
    <td><strong>Fees Date:&nbsp;</strong>'; 
	

            if($Enquiry_data["payment_date"] !=""){
			$output .=date("d-m-Y", strtotime($Enquiry_data["payment_date"]));
            }
			
			
			$output .='&nbsp;  </td><td><strong>Amount :</strong>&nbsp;'.$Enquiry_data["form_amount"].'-/</td><td></td>
			
   
  </tr>
</table>

    </div>
  </div>';
 }
 
 if(($Enquiry_data["scholarship_allowed"]=="YES")){
	
  $output .='<div class="row detail-bg" style="background: #eee;">
    <div class="col-lg-12 np" style="padding: 0">
      <h2 class="detail-heading" style="background: red;
	color: #fff;
	margin: 0px;
		font-size: 13px!important;
	font-weight:bold!important;
	padding: 5px 0 5px 15px;
	text-transform: uppercase;
	font-weight: 600;margin: 10px;">Scholarship Detail</h2>
    </div>
    <div class="col-lg-12" style="padding:10px;">
      <table class="table" cellspacing="5" cellpadding="5" border="1" style="border-collapse: collapse;width:100%!important;border:#ddd solid 1px!important;text-align:left!important;font-size:12px!important;">
  <tr>
  <td><strong>Scholarship Type : </strong>'.str_replace('_',' ',$Enquiry_data["scholarship_type"]).'</td>
  <td><strong>Scholarship Name : </strong>'.$Enquiry_data["scholarship_name"].'</td>
  <tr>
    <td><strong>Scholarship Amount : </strong>'.$Enquiry_data["scholarship_amount"].'</td> 
    <td> </td>
   </tr>
    <tr>
    
  </tr>
</table>

    </div>
  </div>';
 }
 
	
  $output .='<div class="row detail-bg" style="background: #eee;">
    <div class="col-lg-12 np" style="padding: 0">
     
    </div>
    <div class="col-lg-12" style="padding:10px;">
      <table class="table" cellspacing="5" cellpadding="5" border="1" style="border-collapse: collapse;width:100%!important;border:#ddd solid 1px!important;text-align:left!important;font-size:12px!important;">
  <tr>
  <td><strong>Reference Source : </strong>'.str_replace('_',' ',$Enquiry_data["reference"]).'</td>
  <td colspan="2"><strong>Other reference : </strong>'.$Enquiry_data["other_reference"].'</td>
  <tr>
    <td><strong>Taken by : </strong>'.$Enquiry_data["enquiry_taken"].'</td> 
    <td><strong>Mobile No : </strong>'.$Enquiry_data["enquiry_mobile"].'</td>
	<td><strong>Staff ID : </strong>'.$Enquiry_data["staff_id"].'</td>
   </tr>
    <tr>
    
  </tr>
</table>

    </div>
  </div>';
 
 
    /* <li>All information submitted and stated by me during the course of admission and related thereto, to the best of my knowledge and belief is complete, true and 	factually correct and all the supporting and annexures to this form submitted to Sandip University are authentic. I undertake that I would be subject to all sorts of disciplinary action that University may deem fit to take against me including, but not restricted to cancellation of my admission or expulsion or rustication and other actions applicable as per relevant laws, in case the documents and information submitted and stated herewith found false, incorrect or misrepresented by me.</li>
 */
 
 
 
 $output .=' <div class="row detail-bg" style="font-size:12px;">
    <div class="col-lg-12" style="background: #eeeeee;padding:10px;">
      <strong>I, the undersigned, hereby declare that:</strong>
      <ul style="padding-left:15px;font-size:10px;margin-top:10px;line-height:22px;">
  
      <li>The University has all the rights to accept my admission or reject it; mere submission of form along with fee does not mean that admission has been confirmed. The 	admission would be understood as confirmed when the University will issue the admit card or do such act that pertains to confirmation of admission.</li>
      <li>I have read and understood all the contents of the Prospectus and manual circulated along with it regarding various rules & regulations.</li>
      <li>In case I withdraw from the program for any personal reason or due to expulsion or rustication from the University on disciplinary grounds, I shall not be entitled for any refund of fees or other amount paid.</li>
      </ul>
    </div>

	<div class="col-lg-12" style="background: #eeeeee;padding:10px;">
	<table border="1" style="padding-top:10px;line-height: 22px;border-collapse: collapse;     border: 1px solid #ddd!important;text-align:left!important;font-size:11px!imporatnt;" class="pt no-bordered" width="100%">
	<tr>
		<td colspan="2"><strong>Date :</strong> ______________</td>
		<td class="text-right"><strong>Place :</strong> ______________</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="padding-top:10px;line-height: 20px; font-size:12px;" class="pt pb" width="33%" style="padding-bottom:10px;"><strong>Student Signature</strong></td>
		<td style="padding-top:10px;line-height: 20px;font-size:12px;" class="pt pb text-center" style="padding-bottom:10px;"><strong>Parents Signature</strong></td>
		<td  style="padding-top:10px;line-height: 20px;font-size:12px;" class="pt pb text-right" style="padding-bottom:10px;"><strong>DOA Signature</strong> </td>
	  </tr>
	</table>
     </div>
    
  </div>
  
</div>

<script src="http://www.sandipuniversity.com/js/jquery.js"></script> 
<script src="http://www.sandipuniversity.com/js/bootstrap.min.js"></script>';
$body = "Hi $per->first_name

Below Attached is form Copy.

Kindly contact Student section for Further process.

Thanks
Sandip University

";

 //echo $output;
 $basepath = base_url();

$tempDir = $_SERVER['DOCUMENT_ROOT'].'/erp/uploads1/student_document/';
if(!is_dir($tempDir)){
mkdir($tempDir, 0755, true);
}

$mpdf = new mPDF('utf-8', 'A4-L');
$mpdf= new mPDF('','', 0, '0', 10, 10, 10, 0, 9, 9, 'L');
$stylesheet2 = file_get_contents(base_url().'assets/css/bootstrap.min.css');
$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
$mpdf->WriteHTML($output);
$namepdf='Admission_2020_21-'.$Enquiry_data['enquiry_no'];


$mpdf->Output($tempDir.$namepdf.'.pdf', "F");
$file=$tempDir.$namepdf.'.pdf';
//$mpdf->Output($namepdf.'.pdf', "D");
//$mpdf->Output($tempDir.'Provisional.pdf', "F");

//$file=$tempDir.'/Admission_'.$namepdf.'.pdf';

$subject="Admission form ";
$path=$_SERVER["DOCUMENT_ROOT"].'/erp/application/third_party/';
        require_once($path.'PHPMailer/class.phpmailer.php');
        date_default_timezone_set('Asia/Kolkata');
         require_once(APPPATH."third_party/PHPMailer/PHPMailerAutoload.php");
        $mail = new PHPMailer;
        $mail->isSMTP();
      //  $mail->Host = 'ssl://mail360-smtp.zoho.in';
	  $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        //$mail->Username = 'kishor.mehare@sandipuniversity.com';
       // $mail->Password = 'M360.C6700px6B87mS70k71x6700q.b6ln7mkS873JKELo4Rggi775Fm087BkKCl25M07S';
	    $mail->Username = 'noreply@sandipuniversity.com'; 
	    $mail->Password = 'kiran234!';
        $mail->setFrom('noreply@sandipuniversity.com', 'SUN');
	    $mail->AddAddress($Enquiry_data['email_id']);
		$mail->AddAddress('kiran.valimbe@sandipuniversity.edu.in');
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = 'This is a plain-text message body';
        $mail->AddAttachment($file);
       if (!$mail->send()) {
			//echo "dd";
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
			//echo "ssdd";
            echo 'Message sent!';
			////header("location:thankyou");
		
        }
		//echo $output;
?>


		
</body>
</html>