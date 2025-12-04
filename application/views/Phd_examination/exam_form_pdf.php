<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exam Form</title>
<style>
.m{
	width:90%;height:100%;border:1px solid #fff;margin:30px auto;font-size:9px;overflow:hidden;
}
.ps{
padding:0px;margin:0px;	
}
.hd{
border-bottom:1px dotted #000;	
}
</style>
</head>

<body>
<div class="m" style="">
<table width="700" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:13px;margin:50px 0">
  <tr>
    <td valign="middle" align="center" class="hd" ><img src="<?=base_url()?>assets/images/lg.png" width="60"  /></td>
    <td align="center" class="hd"><h2 style="padding:0px;margin:0px;">Sandip University</h2>
    <p class="ps">Trimbak Road, A/p - Mahiravani, Nashik – 422 213</p>
    <p class="ps">Website : http://www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in </p>
    <p class="ps"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></p>
    </td>
    <td align="center" class="hd"><br>
    <!--img src="<?=base_url()?>uploads/exam_barcodes/<?=$emp[0]['form_number']?>.png"--></td>   
   </tr>
   <tr>
   <td colspan="3" align="center">
   <table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td align="center">
<br>
<h2>Examination Application Form</h2><br></td>
</tr> 

<tr>
<td align="center">
<table cellpadding="4" cellspacing="0" border="1" width="700" align="center">
<tr>
<td align="left"  width="82"><strong>Programme :</strong></td>
<td><?=$emp[0]['stream_name']?></td>
<td align="left"><strong>Exam Month/Year :</strong></td>
<td><?=$exam[0]['exam_month']?>-<?=$exam[0]['exam_year']?></td>
</tr> 
<tr>
<td align="left"  width="100"><strong>PRN :</strong></td>
<td><?=$emp[0]['enrollment_no']?></td>
<td align="left"><strong>School :</strong></td>
<td><?=$emp[0]['school_short_name']?></td>
</tr> 
</table>
</td>
</tr> 

<tr>
<td><br>

<table cellpadding="4" cellspacing="0" border="0" width="700">
<tr>
<td width="120"><strong>Name :</strong></td>
<td colspan="3"><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></td>
<?php
  $bucket_key = 'uploads/student_photo/'.$emp[0]['enrollment_no'].'.jpg';
  $imageData = $this->awssdk->getImageData($bucket_key);
?>
<td rowspan="4" align="right"><img src="<?=$imageData ?>" alt="" width="100"/></td>
</tr> 

<tr>
<td align="left"><strong>DOB :</strong></td>
<td colspan=""><?=$emp[0]['dob']?></td>
<td align="left" width="100"><strong>Gender :</strong></td>
<td  colspan=""><?php if($emp[0]['gender']=='M'){ echo 'Male';}else{ echo "Female";}?></td>
</tr> 


<tr>
<td align="left" width="100"><strong>Email :</strong></td>
<td  colspan=""><?=$emp[0]['email']?></td>
<td align="left" width="100"><strong>Mobile :</strong></td>
<td  colspan=""><?=$emp[0]['mobile']?></td>
</tr>


<tr>
<td align="left" width="100"><strong>Address :</strong></td>
<td  colspan="3"><?=$laddr[0]['address']?><br><strong>City :</strong> <?=$laddr[0]['taluka_name']?> &nbsp; &nbsp;<strong>Dist :</strong> <?=$laddr[0]['district_name']?><strong> &nbsp; &nbsp;State :</strong> <?=$laddr[0]['state_name']?> &nbsp; &nbsp; <strong>Pincode :</strong> <?=$laddr[0]['pincode']?><br>
 </td>
</tr>
</table>

</td>
</tr> 
<!--<tr>
<td>
<table cellpadding="5" cellspacing="0" border="0" width="100%" align="center">
<tr>
<td valign="top" width="150" rowspan="2"><strong>Address :</strong></td>
<td rowspan="2">Trimbak Road, A/p - Mahiravani, <br>Nashik – 422 213</td>
<td valign="top"><strong>Mobile :</strong></td>
<td valign="top">1236547890</td>
</tr>
<tr>

<td valign="top"><strong>Email :</strong></td>
<td valign="top">info@sandipuniversity.com</td>
</tr>
</table>
</td>
</tr>-->





  
   </table>
   </td>
   </tr>
  
<tr>
<td colspan="3" align="left" style="border-top:1px dotted #000;">
<h2 style="margin:5px;">Subject Appearing</h2><br>
<table cellpadding="2" cellspacing="0" border="1" width="700" align="center">
<tr>
<th>Sr No.</th>
<th>Semester</th>
<th>Subject Code</th>
<th>Subject Name</th>
</tr>
<?php
$i=1;
	if(!empty($sublist)){
		foreach($sublist as $sub){
?>
<tr>
	
	<td align="center"><?=$i;?></td>
	<td align="center"><?=$sub['semester']?></td>
	<td><?=$sub['subject_code1']?></td>
	<td><?=$sub['subject_name']?></td>
	
	
	
</tr>
<?php 
	$i++;
	}
	}else{
		echo "<tr><td colspan=4>No data found.</td></tr>";
	}
?>
 <tr>
</table><br>
</td>
</tr>  
  
  
  
  
 <tr>
<td colspan="3" align="left" style="border-top:1px dotted #000;border-bottom:1px dotted #000;">
<h2 style="margin:5px;">Fees Details</h2><br>
<table cellpadding="4" cellspacing="0" border="1" align="center" width="700">
<tr>
<td><strong>Exam Fees :</strong></td>
<td><?=$fee[0]['amount']?>/-</td>
<td><strong>DD No. :</strong></td>
<td><?=$fee[0]['receipt_no']?></td>
<td><strong>Date :</strong></td>
<td><?
if($fee[0]['fees_date'] !="0000-00-00" && $fee[0]['fees_date'] !=''){	
	echo date('d-m-Y', strtotime($fee[0]['fees_date']));
}else{
	echo "-";
	}?></td>

</tr>

<tr>
<td><strong>Bank Name :</strong></td>
<td colspan="2"><?=$fee[0]['bank_name']?></td>
<td><strong>Branch Name :</strong></td>
<td colspan="2"><?=$fee[0]['bank_city']?></td>


</tr>
</table>
<br>
</td> 
 </tr> 
 
 
<tr>
<td colspan="3" align="center" style="padding-top:100px;">
<table cellpadding="0" cellspacing="0" border="0" align="center" width="700">
<tr>
<td width="25%" align="center">---------------</td>
<td width="25%" align="center">---------------</td>
<td width="25%" align="center">---------------</td>
<td width="25%" align="center">---------------</td>
</tr>
<tr>
<td align="center"><strong>Student Sign</strong></td>
<td align="center"><strong>Finance Sign</strong></td>
<td align="center"><strong>Dean Sign</strong></td>
<td align="center"><strong>COE Sign</strong></td>
</tr>
</table>
</td>
</tr> 
 








</table>




</body>
</html>
