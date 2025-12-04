<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-bottom:5px;">
	<tr>
	<td width="80" align="right" style="text-align:right;padding-top:5px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
	<td style="font-weight:normal;text-align:center;">
	<h1 style="font-size:30px;">Sandip University</h1>
	<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

	</td>
	<td width="120" align="right" valign="top" style="text-align:center;padding-top:15px;">
	<h3 style="font-size: 25px">COE</h3></td>

	<tr>
	<td></td>
	<<?php if($sts=='Y'){ ?>
	<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:18px;"><?php if($me[0]['marks_type']=='TH'){ echo "Theory";}else{ echo "Laboratory";}?> Mark Entry - <?=$me[0]['exam_month'].' '.$me[0]['exam_year'] ?></h3></td>
	<?php } else { ?>
	<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:18px;">CIA Marks and Attendance Percentage - <?=$me[0]['exam_month'].' '.$me[0]['exam_year'] ?></h3></td>
	<?php } ?>
	<td></td>
	</tr><br>
			
 </table>
<?php
if($streamId !='' && $streamId=='71'){
	$semname ='Year';
}else{
	$semname ='Semester';
}
?>
<table width="100%" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;">
<tr>
<td width="100" height="30" valign="middle">&nbsp;<strong>School Name:</strong></td>
<td height="30" valign="middle" colspan='4'>&nbsp; <?=$StreamSrtName[0]['school_name']?></td>
<td width="85" height="30" valign="middle">&nbsp;<strong>Programme:</strong> </td>
<td height="30" valign="middle" colspan='4'>&nbsp;<?=$StreamSrtName[0]['stream_name']?> </td>


</tr>
<tr>
<td height="30">&nbsp;<strong>Bundle No.:</strong></td>
<td height="30" colspan='3'>&nbsp;<?=strtoupper($bundle_number)?></td>
<td height="30">&nbsp;<strong>Course Code:</strong></td>
<td height="30" colspan='1'>&nbsp;<?=strtoupper($ut[0]['subject_code'])?></td>
<td height="30" valign="middle">&nbsp;<strong>Name:</strong> </td>
<td height="30" valign="middle" colspan=3>&nbsp;<?=strtoupper($ut[0]['subject_name'])?> </td>
</tr>


<tr>
<td height="30">&nbsp;<strong>Max Marks:</strong></td>
<td height="30" colspan='3'>&nbsp;<?php if($me[0]['max_marks'] !=''){ echo $me[0]['max_marks'];}?></td>
<td height="30" valign="middle">&nbsp;<strong>Credits:</strong> </td>
<td height="30" valign="middle">&nbsp;<?=$ut[0]['credits']?> </td>
<td height="30" valign="middle">&nbsp;<strong><?=$semname?>:</strong> </td>
<td height="30" valign="middle">&nbsp;<?=$me[0]['semester']?> </td>
<td height="30" valign="middle">&nbsp;<strong>Date:</strong> </td>
<td height="30" valign="middle">&nbsp;<?php if($me[0]['marks_entry_date'] !='0000-00-00' && $me[0]['marks_entry_date'] !=''){ echo date('d/m/Y', strtotime($me[0]['marks_entry_date']));}?></td>			

</tr>
 </table>
          