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
tr.noBorder td {
  border: 0;
}
</style>
</head>
<?php 
if($exam[0]['exam_type'] =='Regular'){
	$title ='Exam Application Form';
}else{
	$title='Special Supplementary Examinations Form';
}
if($emp[0]['course_pattern']=='SEMESTER'){
	$last_semester = $emp[0]['course_duration'] *2;
}else{
	$last_semester = $emp[0]['course_duration'];
}
//echo $emp[0]['course_pattern'].''.$emp[0]['current_semester'].''.$last_semester;exit;
if($exam[0]['exam_type'] =='Regular'){
if($emp[0]['current_semester']==$last_semester){
	$degree_fees='3000';
}else{
	$degree_fees='0';
}
}
?>
<?php 
	$bucket_key = 'uploads/student_photo/'.$emp[0]['enrollment_no'].'.jpg';
	$imageData = $this->awssdk->getsignedurl($bucket_key);
?>
<body>
<div class="m" style="border:6px double #000;padding:10px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
	<td width="20%" align="center">

	</td>
	<td width="60%" align="center"><img src="<?=base_url()?>assets/images/logo-77.png" width="200"  />
		<p>Trimbak Road, Mahiravani, Nashik – 422 213</p>
		<p>www.sandipuniversity.edu.in | <strong>Email:</strong> info@sandipuniversity.edu.in </p>
		<p><strong>Phone:</strong> (02594) 222 541 | <strong>Fax:</strong> (02594) 222 555</p>
	</td>
	<td width="20%" align="right" style="vertical-align: top;">
        <p style="border:1px  #333; font-size:20px; padding:0px; display:inline-block; margin:0;">
            <b><?=$examdetails[0]['exam_form_no'];?></b>
        </p>
    </td>
</tr>

<tr>
	<td width="20%" align="center" style="padding:10px;border-bottom:2px dotted #333;">

	</td>
	<td width="60%" align="center" style="padding:10px;border-bottom:2px dotted #333;">
		<h3><?=$title?>: <u><?=$exam[0]['exam_month']?>-<?=$exam[0]['exam_year']?></u></h3>
    </td> 
	<td width="20%" align="center" style="padding:10px;border-bottom:2px dotted #333;">
		
	</td>
 </tr>
</table>
<br />
<table cellpadding="0" cellspacing="0" border="1" width="100%" class="cell-padding">
<tr>
<td align="left"><strong>PRN :</strong></td>
<td><?=$emp[0]['enrollment_no']?>       <strong>ABC ID :</strong> <?=$emp[0]['abc_no']?> </td>
<td align="left" width="10%"><strong>Ad Year :</strong></td>
<td><?=$emp[0]['admission_session']?></td>
<td rowspan="4" align="center" width="20%"><img src="<?=$imageData?>" alt="" width="100" height="90"/></td>
</tr> 

<tr>
<td><strong>Name :</strong></td>
<td><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></td>
<td align="left"><strong>Ex Year :</strong></td>
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
<td align="left"><strong>Mother Name :</strong></td>
<td  colspan="4"><?php if(!empty($emp[0]['mother_name'])){ echo strtoupper($emp[0]['mother_name']);}?> </td>

</tr>
<tr>
<td align="left"><strong>Programme/<br>Specialization :</strong></td>
<td  colspan="4"><?=strtoupper($emp[0]['gradesheet_name'])?> / <?php if(!empty($emp[0]['specialization'])){ echo strtoupper($emp[0]['specialization']);}?> </td>

</tr>

<tr>
<td align="left"><strong>Address :</strong></td>
<td  colspan="4"><?=strtoupper($laddr[0]['address'])?><br><?=strtoupper($laddr[0]['taluka_name'])?>, <?=strtoupper($laddr[0]['district_name'])?>, <?=strtoupper($laddr[0]['state_name'])?> - <?=$laddr[0]['pincode']?>
 </td>
</tr>
</table>

<br />
<table cellpadding="0" cellspacing="0" border="1" width="100%" align="center" class="cell-padding">
<tr>
<td colspan="4" align="center" style="background:#CCC;padding:5px;"><h3>Course Appearing </h3></td>
</tr>
<tr>
<th width="10%">Sr No.</th>
<th width="13%">Semester</th>
<th width="15%">Course Code</th>
<th>Course Name</th>
</tr>
<?php
$i=1;
	if(!empty($sublist)){
		foreach($sublist as $sub){
			//if($sub['semester']==$sub['ed_sem']){
?>
<tr>	
	<td align="center"><?=$i;?></td>
    	<td align="center"><?=$sub['semester']?></td>
	
	<td align="center"><?=strtoupper($sub['subject_code'])?></td>
	<td><?=strtoupper($sub['subject_name'])?></td>
</tr>
<?php 
	$i++;
		//}
	}
	}else{
		echo "<tr><td colspan=4>No data found.</td></tr>";
	}
?>
 <tr>
			<td align="left" colspan="3">Total No. of courses Registered : <b><?=$i-1;?></b></td>
			<td align="left" colspan="1">
			<?php $degree_fees=$examdetails[0]['degree_convocation_fees'];//1500
			if($exam[0]['exam_type'] =='Regular'){
				if($emp[0]['current_semester']==$last_semester)
				{ //$degree_fees='0'; ?>
				<span>Degree Fees: <b><?=$degree_fees;?></span>, 
				<?php if($examdetails[0]['exam_fees'] !='0'){ ?>
					<span>Backlog/Fine Fees: <b> <?php  echo (int)$examdetails[0]['exam_fees']-(int)$degree_fees;?></span>, 
				<?php } 
				}else{ ?>
					<span>Backlog/Fine Fees: <b> <?php  echo (int)$examdetails[0]['exam_fees'];?></span>
				<?php } 
			} ?>
			Total Fee to be Paid: <b><?=$examdetails[0]['exam_fees'];?></b></td>			
</tr>
</table>
<br />
</div>
</body>
</html>
