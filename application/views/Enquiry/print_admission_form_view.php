<?php
//$basepath ="http://www.sandipuniversity.com/sandipUniversity_final/";
//$basepath ="http://www.sandipuniversity.com/";
$basepath = base_url();
//print_r($frmno);exit;
$form_no = $frmno[0]['username'];

$stud_id = $frmno[0]['stud_id'];
//include('code128.class.php');
//$font = '/assets/fonts/Verdana.ttf';
//$barcode = new phpCode128($form_no, 100, $font, 18);
//$barcode->saveBarcode('uploads/admission/'.$stud_id.'/'.$form_no.'.png');
?>

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sandip University</title>
<link href="<?php echo $basepath?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $basepath?>assets/css/font-awesome.min.css" rel="stylesheet">
<style>
@font-face {
    font-family:'Verdana';
    src: url('Verdana.eot');
	src: url('Verdana.eot?#iefix') format('embedded-opentype'),
		url('Verdana.woff2') format('woff2'),
		url('Verdana.woff') format('woff'),
		url('Verdana.svg#Verdana') format('svg');
    font-weight: 400;
    font-style: normal;
    font-stretch: normal;
    unicode-range: U+0020-F009;
}
.container {
	width: 600px;
}
.main-wrapper {
	background: #f4f4f4;
	padding-top: 10px;
	font-size: 10px
}
.heading-1 {
	background: #CCC;
	text-align: center
}
.heading-1 h4 {
	font-size: 15px;
	text-transform: uppercase;
	margin-top: 5px;
	margin-bottom: 5px;
	font-weight: bold;
}
p {
	text-align: inherit
}
.head-add {
	font-size: 13px
}
.detail-bg {
	background: #eee;
}
.detail-bg table tr td {
	font-size: 12px!important;
	height:25px;
}
.np {
	padding: 0;
}
.detail-heading {
	background: red;
	color: #fff;
	margin: 0px;
	font-size: 15px;
	padding: 5px 0 5px 15px;
	text-transform: uppercase;
	font-weight: 600;
}
.table th{font-size:12px;}
.pb{padding-bottom:10px;}
.bb{border-bottom:1px solid #ddd}
.pt{padding-top:10px;line-height: 23px}
ul {padding-left:15px;margin-top:10px;}
</style>
</head>

<body>
<div class="container">
  <div class="row main-wrapper">
   <div class="col-sm-9">
   <img src="<?=base_url()?>assets/images/logo_form.png" class="ximg-responsive">
   <p><strong>A UNIVERSITY U/S 2(F) OF THE UGC ACT 1956 WITH THE RIGHT TO CONFER
DEGREE U/S 22 (1) GOVT. OF MAHARASHTRA ACT. NO. XXXVIII OF 2015.</strong></p>
   </div>
   <div class="col-sm-3 pull-right">
  <strong>Form No :</strong> <?=$form_no?>
<img src="<?=base_url()?>uploads/admission/<?=$stud_id?>/<?=$form_no?>.png"> </td>
</div>

    <div class="col-md-12">
      <p class="head-add"><strong>Address :</strong> Trimbak Road, Mahirvani Nashik - 422 213, Maharashtra.<br>
      <strong>Corporate Office :</strong> Koteshwar Plaza, J N Road, Mulund (W), Mumbai - 400080 <br>
        <strong>Toll Free :</strong>  1800-212-2714 &nbsp; &nbsp;|&nbsp; &nbsp;
        <strong>Website :</strong> www.sandipuniversity.com </p>
    </div>

    <div class="col-lg-12 heading-1">
      <h4>Provisional Admission Form 2020-21</h4>
    </div>
  </div>
  <div class="row detail-bg">
    <div class="col-lg-12 np">
      <h2 class="detail-heading">COURSE INFORMATION </h2>
    </div>
    <div class="col-lg-12">
      <table class="table table-bordered">
  <tr>
    <th scope="col">Sr.</th>
    <th scope="col">Course Name</th>
  </tr>
    <?php 
	$srNo=1;
		foreach($course as $val){
	?>
  <tr>
    <td><?=$srNo?></td>
    <td><?=$val['stream_name']?></td>
  </tr>
  <?php 
	$srNo++;
	}
	?>

</table>

    </div>
  </div>
  
  
  
  
  <div class="row detail-bg">
    <div class="col-lg-12 np">
      <h2 class="detail-heading">Personal Information</h2>
    </div>
    <div class="col-lg-12">
      <table class="table">
        <tr>
          <td  align="right" width="120"><strong>Student Name :</strong></td>
          <td><?=$per[0]['student_name']?></td>
          <td rowspan="5" width="90"><?php 
		  if(!empty($photo[0]['prof_photo'])){?>
			<img src="<?=base_url()?>uploads/admission/<?=$photo[0]['stud_id']?>/<?=$photo[0]['prof_photo']?>" width="88" height="88"></td>  
		  <?php }else{ ?>
			<img src="<?=base_url()?>assets/images/user-img.jpg" width="88" height="88"></td>
		  <?php } ?></td>
        </tr>
        <tr>
          <td align="right"><strong>Date of Birth :</strong></td>
          <td><?php
            //echo $per[0]['dob'];
            if($per[0]['dob'] !='0000-00-00' && $per[0]['dob'] !=''){
			echo $newDate = date("d-m-Y", strtotime($per[0]['dob']));
            }
			?></td>
        </tr>
        <tr>
          <td align="right"><strong>Gender :</strong></td>
          <td><?=$per[0]['gender']?></td>
        </tr>
        <tr>
          <td align="right"><strong>Address :</strong></td>
          <td valign="top">
          <table width="100%">
              <tr>
                <td class="pb"><?=$per[0]['address']?></td>
              </tr>
              <tr>
                <td class="pb"><strong>City :</strong> <?=$per[0]['district_name']?><strong> &nbsp; &nbsp;State :</strong> <?=$per[0]['state_name']?>&nbsp; &nbsp; <strong>Pincode :</strong> <?=$per[0]['pincode']?></td>
              </tr>
              
            </table></td>
        </tr>
        <tr>
          <td align="right"><strong>Mobile Number :</strong></td>
          <td><?=$per[0]['mobile']?></td>
        </tr>
        <tr>
          <td align="right"><strong>Email :</strong></td>
          <td><?=$per[0]['email']?></td> 
        </tr>
        <tr>
          <td align="right"><strong>Category :</strong></td>
          <td><?=$per[0]['category']?></td>
        </tr>
         
      </table>
    </div>
  </div>
  
  <div class="row detail-bg">
    <div class="col-lg-12 np">
      <h2 class="detail-heading">Qualification details</h2>
    </div>
    <div class="col-lg-12">
      <table class="table table-bordered">
  <tr>
    <th scope="col">Qualification</th>
    <th scope="col">Specilization</th>
    <th scope="col">Board Name</th>
    <th scope="col">Year of Passing</th>
    <th scope="col">Percentage</th>
    <th scope="col">Class</th>
  </tr>
 <?php 
	$srNo1=1;
		foreach($qua as $var){
	?>
  <tr>
	
    <td><?=$var['qualification']?></td>
    <td><?=$var['specialization']?></td>
    <td><?=$var['uni_board_name']?></td>
    <td><?=$var['passing_year']?></td>
    <td><?=$var['percentages']?>%</td>
    <td><?=$var['class']?></td>
  </tr>
  <?php 
	$srNo++;
	}
	?>
</table>

    </div>
  </div>
  
  <div class="row detail-bg">
    <div class="col-lg-12 np">
      <h2 class="detail-heading">Document Encloser </h2>
    </div>
    <div class="col-lg-12">
		<?php

		foreach($qualfg as $qufg){
			$qa []=$qufg['flag'];
		}

		?>
      <table class="table table-bordered">
		  <tr>
			<th scope="col">Sr.No</th>
			<th scope="col">Name of Document</th>
			<th scope="col">Status</th>
		  </tr>
		  <tr>
			<td width="5%">1.</td>
			<td>10th Marksheet</td>
			<td>
				<?php
				if(in_array("SSC", $qa)==true){
				echo 'Y';
				}else{
					echo 'N';
					}
				?>
			</td>
		  </tr> 
		  
		  <tr>
			<td width="5%">2.</td>
			<td>12th Marksheet</td>
			<td>
			<?php
				if(in_array("HSC", $qa)==true){
				echo 'Y';
				}else{
					echo 'N';
					}
				?>
			</td>
		  </tr>
		  <tr>
			<td width="5%">3.</td>
			<td>Degree Marksheet</td>
			<td>
			<?php
				if(in_array("OTHER", $qa)==true){
				echo 'Y';
				}else{
					echo 'N';
					}
				?>
			</td>
		  </tr>
		  		  <tr>
			<td width="5%">3.</td>
			<td>Post Degree Marksheet</td>
			<td>
			<?php
				if(in_array("OTHER1", $qa)==true){
				echo 'Y';
				}else{
					echo 'N';
					}
				?>
			</td>
		  </tr>
		</table>

    </div>
  </div>
  
  <div class="row detail-bg">
    <div class="col-lg-12 np">
      <h2 class="detail-heading">Qualifying Examination</h2>
    </div>
    <div class="col-lg-12">
      <table class="table table-bordered">
  <tr>
    <th scope="col">Exam Name</th>
    <th scope="col">Registration Number</th>
    <th scope="col">Total Score</th>
    <th scope="col">Percentile</th>
  </tr>
  <tr>
    <td>SU-JEE Exam /</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>

    </div>
  </div>
  
  
  <div class="row detail-bg">
    <div class="col-lg-12 np">
      <h2 class="detail-heading">Fees Detail</h2>
    </div>
    <div class="col-lg-12">
      <table class="table table-bordered">
  <tr>
    <td><strong>Payment Type : </strong> <?=$pay[0]['fees_mode']?> </td>
    <td><strong>Receipt No :</strong> <?=$pay[0]['receipt_no']?> &nbsp;&nbsp; </td>
  </tr>
    <tr>
    <td><strong>Bank :</strong> <?=$pay[0]['bank_name']?>  <?php if(!empty($pay[0]['ifsc_code'])) {?>( <?=$pay[0]['ifsc_code']?> ) <?php }?></td>
    <td><strong>Branch Name :</strong> <?=$pay[0]['bank_branch']?></td>
  </tr>
  <tr>
    <td><strong>Fees Date :</strong> <?php
            if($pay[0]['fees_date'] !=''){
			echo $feeDate = date("d-m-Y", strtotime($pay[0]['fees_date']));
            }
			?></td>
    <td><strong>Amount :</strong> <?=$pay[0]['amount']?>/-</td>
  </tr>
</table>

    </div>
  </div>
  <!-- for Reference------------------->
    <div class="row detail-bg">
    <div class="col-lg-12 np">
      <h2 class="detail-heading">Reference Detail</h2>
    </div>
        <div class="col-lg-12">
      <table class="table table-bordered">
  <tr>
    <th scope="col">Source</th>
    <th scope="col">Reference</th>

  </tr>
  <tr>
     <?php // echo '<pre>'; print_r($per);?>
    <td><?=$per[0]['walkin_source']?></td>
    <td><?=$per[0]['walkin_source_name']?></td>
  </tr>
  <tr>
     <?php // echo '<pre>'; print_r($per);?>
    <td><?=$per[0]['source']?></td>
    <td><?=$per[0]['reference_from']?></td>
  </tr>
  
</table>

    </div>
  </div>
  <!------------------------------------------------------------------------------->
  <div class="row detail-bg" style="font-size:11px;">
    <div class="col-lg-12">
      <strong>I, the undersigned, hereby declare that:</strong>
      <ul>
      <li>All information submitted and stated by me during the course of admission and related thereto, to the best of my knowledge and belief is complete, true and 	factually correct and all the supporting and annexures to this form submitted to Sandip University are authentic. I undertake that I would be subject to all sorts of disciplinary action that University may deem fit to take against me including, but not restricted to cancellation of my admission or expulsion or rustication and other actions applicable as per relevant laws, in case the documents and information submitted and stated herewith found false, incorrect or misrepresented by me.</li>
      <li>The University has all the rights to accept my admission or reject it; mere submission of form along with fee does not mean that admission has been confirmed. The 	admission would be understood as confirmed when the University will issue the admit card or do such act that pertains to confirmation of admission.</li>
      <li>I have read and understood all the contents of the Prospectus and manual circulated along with it regarding various rules & regulations.</li>
      <li>In case I withdraw from the program for any personal reason or due to expulsion or rustication from the University on disciplinary grounds, I shall not be entitled for any refund of fees or other amount paid.</li>
      </ul>
    </div>
	<div class="col-lg-12">
	<div class="col-lg-12">
	<table class="pt no-bordered" width="100%">
	<tr>
		<td colspan="2"><strong>Date :</strong> ______________</td>
		<td class="text-right"><strong>Place :</strong> ______________</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td class="pt pb" width="33%"><strong>Signature of Applicant </strong></td>
		<td class="pt pb text-center"><strong>Signature of Adm Incharge </strong></td>
		<td class="pt pb text-right"><strong>Signature of Registrar </strong> </td>
	  </tr>
	</table>
     </div>
    
  </div>
  
</div>


<!--Bootstrap core JavaScript--> 
<script src="http://www.sandipuniversity.com/js/jquery.js"></script> 
<script src="http://www.sandipuniversity.com/js/bootstrap.min.js"></script>

<!--<script src="https://cdn.jsdelivr.net/jsbarcode/3.5.8/barcodes/JsBarcode.code128.min.js"></script>-->
</body>
</html>