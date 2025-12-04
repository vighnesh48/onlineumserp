<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exam Form</title>
<style>
body{font-size:11px;}
.m{
	width:90%;height:100%;border:1px solid #fff;margin:30px auto;xfont-size:9px;overflow:hidden;
}
.ps{
padding:0px;margin:0px;	
}
.hd{
border-bottom:1px solid #000;padding-bottom:15px;	
}
</style>
</head>

<body>
<div class="m" style="">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="xfont-size:10px;margin:30px 0 0 0;margin-bottom:15px;">
  <tr>
    <td valign="middle" align="right" width="200"><img src="<?=base_url()?>assets/images/lg.png" width="60"  /></td>
    <td align="left"><h2 style="padding:0px;margin:0px;">Sandip University</h2>
    <p class="ps">Trimbak Road, Mahiravani, Nashik – 422 213</p>
    <p class="ps">www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in </p>
    <p class="ps"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></p>
	
    </td> 
   </tr>
<tr>
	<td valign="middle" align="center" class="hd" width="200"></td>
    <td valign="middle" align="left" class="hd" >
	<p><h3 align="center">Exam Application Form: <u><?=$exam[0]['exam_month']?>-<?=$exam[0]['exam_year']?></u></h3></p>
    </td> 
   </tr>
</table>

<table cellpadding="4" cellspacing="0" border="1" width="100%">
<tr>
<td align="left" width="15%"><strong>PRN :</strong></td>
<td><?=$emp[0]['enrollment_no']?></td>
<td align="left" width="10%"><strong>Ad Year :</strong></td>
<td width="10%"><?=$emp[0]['admission_session']?></td>
<?php
    $bucket_key = 'uploads/student_photo/'.$emp[0]['enrollment_no'].'.jpg';
    $imageData = $this->awssdk->getImageData($bucket_key);
?>
<td rowspan="4" align="center" width="20%"><img src="<?=$imageData?>" alt="" width="100" height="90"/></td>
</tr> 

<tr>
<td><strong>Name :</strong></td>
<td><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></td>
<td align="left"><strong>Year :</strong></td>
<td><?=$exam[0]['exam_month']?>-<?=$exam[0]['exam_year']?></td>

</tr> 

<tr>
<td align="left"><strong>DOB / Gender :</strong></td>
<td colspan=""><?=$emp[0]['dob']?> / <?php if($emp[0]['gender']=='M'){ echo 'Male';}else{ echo "Female";}?></td>
<td align="left"><strong>Mobile :</strong></td>
<td  colspan=""><?=$emp[0]['mobile']?></td>
</tr> 


<tr>
<td align="left"><strong>Email :</strong></td>
<td  colspan=""><?=$emp[0]['email']?></td>
<td align="left" ><strong>Sem :</strong></td>
<td  colspan=""><?=$exam_semes;?></td>
</tr>
<tr>
<td align="left"><strong>Programme :</strong></td>
<td  colspan="4"><?=strtoupper($emp[0]['stream_name'])?> </td>

</tr>

<tr>
<td align="left"><strong>Address :</strong></td>
<td  colspan="4"><?=strtoupper($laddr[0]['address'])?><br><?=strtoupper($laddr[0]['taluka_name'])?>, <?=strtoupper($laddr[0]['district_name'])?>, <?=strtoupper($laddr[0]['state_name'])?> - <?=$laddr[0]['pincode']?>
 </td>
</tr>
</table>


  
  

<h3 style="margin:5px;" align="left">Course Appearing(A) </h3>

<table cellpadding="2" cellspacing="0" border="1" width="100%" align="center">

<tr>
<th width="10%">Sr No.</th>

<th>Course Code</th>
<th>Course Name</th>
<th>Semester</th>
</tr>
<?php
$i=1;
	if(!empty($sublist)){
		foreach($sublist as $sub){
?>
<tr>
	
	<td align="center" width="10%"><?=$i;?></td>
	
	<td align="center" width="20%"><?=strtoupper($sub['subject_code'])?></td>
	<td><?=strtoupper($sub['subject_name'])?></td>
	<td align="center" width="15%"><?=$sub['semester']?></td>
	
	
	
</tr>
<?php 
	$i++;
	}
	}else{
		echo "<tr><td colspan=4>No data found.</td></tr>";
	}
?>
 <tr>
 	<tr>
			<?php if($exam[0]['exam_type'] =='Regular'){ $colspan_fee="2";}else{ $colspan_fee="4";} ?>
			<td align="left" colspan="<?=$colspan_fee?>">Total No. of courses Registered : <b><?=count($sublist);?></b></td>
			<?php if($exam[0]['exam_type'] =='Regular'){ ?>
			<td align="left" colspan="2">Fee to be Paid: <b><?=$examfees[0]['exam_fees']?></b></td>
			<?php }?>
</tr>
</table>

<?php if($exam[0]['exam_type'] =='Regular'){ 
	
?>
<h3 style="margin:5px;" align="left">Backlog(B)</h3>
<table cellpadding="2" cellspacing="0" border="1" width="100%" align="center">
<tr>
<th width="10%">Sr No.</th>
<th>Course Code</th>
<th>Course Name</th>
<th>Semester</th>
</tr>
<?php
$blck_fees = $examdetails[0]['exam_fees'] - $examfees[0]['exam_fees'];
$i=1;
	if(!empty($backlogsublist)){
		foreach($backlogsublist as $bksub){
?>
<tr>
	
	<td align="center" width="10%"><?=$i;?></td>
	
	<td align="center" width="20%"><?=strtoupper($bksub['subject_code'])?></td>
	<td><?=strtoupper($bksub['subject_name'])?></td>
	<td align="center" width="15%"><?=$bksub['semester']?></td>
	
	
	
</tr>
<?php 
	$i++;
	}
	}else{
		echo "<tr><td colspan=4>No data found.</td></tr>";
	}
?>
 <tr>
 	<tr>
			<td align="left" colspan="2">Total No. of courses Registered: <b><?=count($backlogsublist);?></b></td>
			
			<td align="left" colspan="2">Fee to be Paid: <b><?=$blck_fees?></b></td>
			
			
			
</tr>
</table>
  
<?php }?>
  

<table width="100%" style="margin:5px;"><tr><td align="left" ><span ><h3>Fees Details</h3> </span> </td><td align="right"><span class="pull-right"><h3>Total Fees: <?=$examdetails[0]['exam_fees']?></h3></span></td></tr></table>

<table cellpadding="4" cellspacing="0" border="1" align="center" width="100%">
<thead1>
	<tr>
		<th>Payment Type</th>
		<th>Recept No</th>
		<th>Date</th>
		<th>Amount</th>
		<th>Bank Name</th>
		<th>Bank City</th>
	</tr>
</thead1>
<tbody>
<?php
$i = 1;

if (!empty($fee))
	{
		foreach ($fee as $key => $fees) {
		
?>
<tr>
	<td><?php echo $fees['fees_paid_type'] ?></td>
	<td><?php echo $fees['receipt_no'] ?></td>
	<td><?php
			if ($fees['fees_date'] != '' && $fees['fees_date'] != '0000-00-00')
				{
				echo date('d/m/Y', strtotime($fees['fees_date']));
				}

		?>
			
	</td>
	<td height="25"><?php echo $fees['amount'] ?></td>
	<td><?php echo $fees['bank_name'] ?></td>
	<td><?php echo $fees['bank_city'] ?></td>
</tr>
<?php
	}
}else{
	echo'<tr><td colspan="6">Exam fees not paid.</td></tr>';
}
?>
</tbody>
</table>

</body>
</html>
