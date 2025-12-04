 <table cellpadding="0" cellspacing="0" border="0" align="center" width="800" style="">
<tr>
<td width="80" align="center" style="text-align:center;padding-top:25px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
<td style="font-weight:normal;text-align:center;padding-top:25px;" colspan="2">
<h1 style="font-size:30px;">Sandip University</h1>
<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

</td>
<td width="120" align="right" valign="top" style="text-align:center;padding-top:25px;">
<span style="border:0px solid #333;padding:10px;font-size:30px;"><b>COE</b></span></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" align="center" width="800" style="margin-bottom:1px;">
 <tr>
	<td align="center" colspan="3"><h3>END SEMESTER EXAM (Practical <?=$exam?>).<br>MARKS ENTRY</h3></td>
</tr>
</table>
<?php
if($streamId !='' && $streamId=='71'){
    $semname ='Year';
}else{
    $semname ='Sem/Div/Batch';
}
?>
<table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
                <tr>
<td width="100" height="30" valign="middle">&nbsp;<strong>School Name:</strong></td>
<td height="30" valign="middle" colspan='4'>&nbsp; <?=$StreamSrtName[0]['school_name']?></td>
<td width="80" height="30" valign="middle">&nbsp;<strong>Program:</strong> </td>
<td  height="30" valign="middle" colspan='4'>&nbsp;<?=$StreamSrtName[0]['stream_name']?> </td>


</tr>
<tr>
<td  height="30">&nbsp;<strong>Course Code:</strong></td>
<td height="30" colspan='4'>&nbsp;<?=strtoupper($ut[0]['subject_code'])?></td>
<td width="80" height="30" valign="middle">&nbsp;<strong>Name:</strong> </td>
<td  height="30" valign="middle" colspan=4>&nbsp;<?=strtoupper($ut[0]['subject_name'])?> </td>
</tr>


<tr>
<td  height="30">&nbsp;<strong>Max Marks:</strong></td>
<td height="30" colspan='3'>&nbsp;<?php if($me[0]['max_marks'] !=''){ echo $me[0]['max_marks'];}?></td>
<td width="80" height="30" valign="middle">&nbsp;<strong>Credits:</strong> </td>
<td  height="30" valign="middle">&nbsp;<?=$ut[0]['credits']?> </td>
<td height="30" valign="middle">&nbsp;<strong><?=$semname?>:</strong> </td>
<td width height="30" valign="middle">&nbsp;<?=$me[0]['semester']?>/<?=$me[0]['division']?>/<?=$me[0]['batch_no']?> </td>
<td height="30" valign="middle">&nbsp;<strong>Date:</strong> </td>
<td  height="30" valign="middle">&nbsp;<?php if($me[0]['marks_entry_date'] !='0000-00-00' && $me[0]['marks_entry_date'] !=''){ echo date('d/m/Y', strtotime($me[0]['marks_entry_date']));}?></td>           

</tr>

             </table>