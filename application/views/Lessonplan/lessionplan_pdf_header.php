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
	<td align="center" colspan="3"><h3><?=$sub[0]['school_name']?></h3></td>
</tr>
</table>
<?php
if($sub[0]['stream_id'] !='' && $sub[0]['stream_id']=='71'){
    $semname ='Year';
}else{
    $semname ='Semester';
}
?>
<table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
                <tr>
<td width="100" height="30" valign="middle">&nbsp;<strong>Program:</strong></td>
<td height="30" valign="middle" colspan='4'>&nbsp; <?=$sub[0]['stream_name']?></td>
<td width="80" height="30" valign="middle">&nbsp;<strong>Semester:</strong> </td>
<td  height="30" valign="middle" colspan='4'>&nbsp; <?=$sub[0]['semester']?></td>
<td width="100" height="30" valign="middle">&nbsp;<strong>Faculty Name:</strong> </td>
<td  height="30" valign="middle" colspan='4'>&nbsp; <?=$emp_name?>&nbsp;(<?=$this->session->userdata('name')?>)</td>
</tr>
<tr>
<td  height="30">&nbsp;<strong>Course Code:</strong></td>
<td height="30" colspan='4'>&nbsp;<?=strtoupper($sub[0]['subject_code'])?></td>
<td width="100" height="30" valign="middle">&nbsp;<strong>Subject Name:</strong> </td>
<td  height="30" valign="middle" colspan=4>&nbsp;<?=strtoupper($sub[0]['subject_name'])?> </td>
<td width="80" height="30" valign="middle">&nbsp;<strong>DIV/Batch:</strong> </td>
<td  height="30" valign="middle" colspan=4>&nbsp;<?=strtoupper($division)?>/ <?=strtoupper($Batch)?></td>
</tr>
</table>