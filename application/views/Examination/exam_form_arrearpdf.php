<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exam Form</title>
<style>
body{font-size:12px;}
.m{
	width:100%;height:100%;margin:0px auto;
}

.hd{
border-bottom:1px solid #000;padding-bottom:15px;	
}
.cell-padding tr td{padding:2px;}
.addr tr td{ text-transform:capitalize;}
</style>
</head>

<body>
<div class="m" style="border:6px double #000;padding:10px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td align="center"><img src="<?=base_url()?>assets/images/logo-77.png" width="200"  />
<p>Trimbak Road, Mahiravani, Nashik – 422 213</p>
    <p>www.sandipuniversity.edu.in | <strong>Email:</strong> info@sandipuniversity.edu.in </p>
    <p><strong>Phone:</strong> (02594) 222 541 | <strong>Fax:</strong> (02594) 222 555</p>
</td>
</tr>

<tr>
<td align="center" style="padding:10px;border-bottom:2px dotted #333;">
	<h3>Exam Application Form: <u><?=$exam[0]['exam_month']?>-<?=$exam[0]['exam_year']?></u></h3>
    </td> 
   </tr>
</table>
<br />
<table cellpadding="0" cellspacing="0" border="1" width="100%" class="cell-padding">
<tr>
<td align="left"><strong>PRN :</strong></td>
<td><?=$emp[0]['enrollment_no']?></td>
<td align="left" width="10%"><strong>Ad Year :</strong></td>
<td><?=$emp[0]['admission_session']?></td>
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
<td align="left" width="15%"><strong>DOB / Gender :</strong></td>
<td colspan=""><?=$emp[0]['dob']?> / <?php if($emp[0]['gender']=='M'){ echo 'MALE';}else{ echo "FEMALE";}?></td>
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

<br />

<?php if($exam[0]['exam_type'] =='Regular'){ 
	
?>
<br />
<table cellpadding="0" cellspacing="0" border="1" width="100%" align="center" class="cell-padding">
<tr>
<td colspan="4" align="center" style="background:#CCC;padding:5px;"><h3>Backlog</h3></td>
</tr>

<tr>
<th width="10%">Sr No.</th>
<th width="13%">Semester</th>
<th width="15%">Course Code</th>
<th>Course Name</th>

</tr>
<?php
$blck_fees = $examdetails[0]['exam_fees'] - $examfees[0]['exam_fees'];
$j=1;
	if(!empty($sublist)){
		foreach($sublist as $bksub){
			if($bksub['semester']!=$bksub['ed_sem']){
?>
<tr>	
	<td align="center"><?=$j;?></td>
    <td align="center"><?=$bksub['semester']?></td>
	<td align="center"><?=strtoupper($bksub['subject_code'])?></td>
	<td><?=strtoupper($bksub['subject_name'])?></td>
	
</tr>
<?php 
	$j++;
			}
	}
	}else{
		echo "<tr><td colspan=4>No data found.</td></tr>";
	}
?>
 <tr>
 	<tr>
			<td align="left" colspan="3">Total No. of courses Registered: <b><?=$j-1;?></b></td>
			
			<td align="left" colspan="1">Fee to be Paid: <b><?=$blck_fees?></b></td>
			
			
			
</tr>
</table>
  
<?php }?>
  

<br />
<table cellpadding="4" cellspacing="0" border="0" align="center" width="100%" style="border:1px solid #000;">
<thead>
<tr>
<td colspan="3" style="background:#CCC;padding:5px;"><h3>Fees Details</h3> </td>
<td colspan="3" style="background:#CCC;padding:5px;" align="right"><h3>Total Fees: <?=$examdetails[0]['exam_fees']?></h3></td>
</tr>
</thead>
</table>
<table cellpadding="4" cellspacing="0" border="1" align="center" width="100%">
<thead>
	<tr>
    <th>Sr No.</th>
		<th>Payment Type</th>
		<th>Recept No</th>
		<th>Date</th>
		<th>Amount</th>
		<th>Bank Name</th>
		<th>Bank City</th>
	</tr>
</thead>
<tbody>
<?php
$i = 1;

if (!empty($fee))
	{
		foreach ($fee as $key => $fees) {
		
?>
<tr>
	<td align="center">1</td>
	<td align="center"><?php echo $fees['fees_paid_type'] ?></td>
	<td align="center"><?php echo $fees['receipt_no'] ?></td>
	<td align="center"><?php
			if ($fees['fees_date'] != '' && $fees['fees_date'] != '0000-00-00')
				{
				echo date('d/m/Y', strtotime($fees['fees_date']));
				}

		?>
			
	</td>
	<td height="25" align="center"><?php echo $fees['amount'] ?></td>
	<td><?php echo $fees['bank_name'] ?></td>
	<td><?php echo $fees['bank_city'] ?></td>
	
</tr>
<tr>
	<td align="center">2</td>
	<td align="center"><?php echo $fees['fees_paid_type'] ?></td>
	<td align="center"><?php echo $fees['receipt_no'] ?></td>
	<td align="center"><?php
			if ($fees['fees_date'] != '' && $fees['fees_date'] != '0000-00-00')
				{
				echo date('d/m/Y', strtotime($fees['fees_date']));
				}

		?>
			
	</td>
	<td height="25" align="center"><?php echo $fees['amount'] ?></td>
	<td><?php echo $fees['bank_name'] ?></td>
	<td><?php echo $fees['bank_city'] ?></td>
	
</tr>
<?php
	}
}else{
	echo'<tr><td colspan="7">Exam fees not paid.</td></tr>';
}
?>
</tbody>
</table>
</div>
</body>
</html>
