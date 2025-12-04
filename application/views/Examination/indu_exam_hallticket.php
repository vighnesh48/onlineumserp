<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hall Ticket</title>
    <style>  
    
            table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:11px; margin:0 auto;
            }  
      td{vertical-align: top;}
                      
            .signature{
            text-align: center;
            }
            .marks-table{
            width: 100%;height:550px;
            }
            p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
            .marks-table td{height:20px;vertical-align:middle;}
			
            .marks-table th{height:20px;}
.content-table td{border:1px solid #333;padding-left:5px;vertical-align:middle;}
.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
        </style> 

</head>

<body>
 
<?php 
if($exam[0]['exam_type'] =='Regular'){
	$title ='Exam';
}else{
	$title='Special Supplementary Examinations';
}
?>



  
   <table align="center" width="700"> 
            <tbody>  
            <tr>
            <td valign="top" height="40">
            <table cellpadding="10" cellspacing="10" border="0" align="center" width="800" style="margin-top:0px;">
            <tr>
<td width="25%" align="right" style="text-align:left;padding-top:5px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0" class="pull-right"></td>
<td style="font-weight:normal;text-align:left;">
<h1 style="font-size:27px;">Sandip University</h1>
<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

</td>
<td width="25%" align="right" valign="middle" style="text-align:center;padding-top:20px;">
	<?php
		$bucket_key = "uploads/exam/".$exam[0]['exam_month'].''.$exam[0]['exam_year']."/QRCode/qrcode_".$emp_per[0]['enrollment_no'].".png";
		$imageData = $this->awssdk->getsignedurl($bucket_key);
	?>
<span style="border:0px solid #333;padding:10px;"><img src="<?=$imageData ?>" ></span></td>

<tr>
<td align="center" style="margin:0;padding:0" colspan=3><h3 style="font-size:14px;"><?=$title?> Hall Ticket - <?=$exam[0]['exam_month']?> <?=$exam[0]['exam_year']?></h3></td>

</tr>        
 </table>
            </td>
            </tr>

            <tr>
            <td style="padding:0;">
            <table class="content-table" width="800" cellpadding="0" cellspacing="0" border="0" align="center" style="font-size:12px;height:150px;overflow: hidden;">
            <tr>
            <td width="120" height="15"><strong>PRN :</strong></td>
            <td><?=$emp_per[0]['enrollment_no']?></td>
            <td valign="top" width="120" height="100" rowspan="5">
        	<?php
			    $bucket_key = 'uploads/student_photo/'.$emp_per[0]['enrollment_no'].'.jpg';
			    $imageData = $this->awssdk->getsignedurl($bucket_key);
			?>
            <img src="<?= $imageData ?>" alt="" width="120" height="120">
            </td>
            <!--https://erp.sandipuniversity.com/uploads/2017-18/<?=$emp_per[0]['form_number']?>/<?=$emp_per[0]['form_number']?>_PHOTO.<?=$ext?>-->
            </tr>
            <tr>
			<td height="15"><strong>Name :</strong></td>
            <td><?=$emp_per[0]['last_name']?> <?=$emp_per[0]['first_name']?> <?=$emp_per[0]['middle_name']?></td>
			<tr>
			<td height="15"><strong>Center :</strong></td>
            <td><?=$ex_center[0]['center_code']?>-<?=$ex_center[0]['center_name']?></td>
			</tr>
			<tr>
			
            <td height="15"><strong>Stream Name :</strong></td>
            <td><?=$emp_per[0]['stream_name']?></td>
            
            </tr>
            <tr>
            <td height="15"><strong>School Name:</strong></td>
            <td><?=$emp_per[0]['school_short_name']?></td>
            
            
            
            </tr>
             </table>
           
            </td>
            </tr>
            
            
            <tr>
            <td class="marks-table"  style="padding:0;">
            <table border="0" class="content-table" width="800" height="800">
            <tr>
            <th width="10">Sem</th>
			<th>Course Code</th>
            <th align="left">Course Name</th>
            <th width="80">Date</th>
			<th width="60">Time</th>
            <th width="70">Ans.Book No</th>
            <th width="70">Invg.Sign</th>
            </tr>

<?php
$ik=1;
$bkp=1;
$jk=1;
$bk=1;
//echo "<pre>";
//print_r($sublist);
	if(!empty($sublist)){
		foreach($sublist as $sub){
			//$sub_compt =$sub['subject_component'];
			if($sub['subject_component']=='TH' || $sub['subject_component']=='EM'){
			    $sub_compt ='TH';
			}else{
			    $sub_compt ='PR';
			}
			$fromtime= explode(':', $sub['from_time']);
			$totime= explode(':', $sub['to_time']);
			
				if($sub['date']!='000-00-00' && $sub['date'] !=''){
					$examdate = date('d/m/Y', strtotime($sub['date']));
				}else{
					$examdate = "";
				}
				if(!empty($sub['from_time']) && !empty($sub['to_time'])){
					$examtime = $fromtime[0].':'.$fromtime[1].'-'.$totime[0].':'.$totime[1];
				}else{
					$examtime = "";
				}
?>
<?php 
//echo $emp_per[0]['current_semester'];echo "<br>";
//echo $sub['semester'];
//exit;
	if(($sub_compt=='TH' || $sub_compt=='PR') && ($emp_per[0]['current_semester']!=$sub['semester'])){
		
		if($ik==1){
		?>
		<tr style="height:5px"><td colspan=7><b>Backlog</b></td></tr>
		<?php }?>
	<tr>		
		<td align="center"><?=$sub['semester']?></td>
		<td align="center"><?=$sub['subject_code']?></td>
		<td><?=$sub['subject_name']?></td>
		<td><?php if($sub_compt=='TH'){ echo $examdate; }?></td>
		<td><?php if($sub_compt=='TH'){ echo $examtime; } ?></td>
		<td></td>
		<td></td>		
	</tr>
	<?php $ik++;
	}else if($sub_compt=='TH' && $emp_per[0]['current_semester']==$sub['semester']){
	if($bk==1){
		?>
		<tr><td colspan=7><b>Theory</b></td></tr>
		<?php }?>
	<tr>		
	<td align="center"><?=$sub['semester']?></td>
	<td align="center"><?=$sub['subject_code']?></td>
	<td><?=$sub['subject_name']?></td>
	<td><?php if($sub_compt=='TH'){ echo $examdate; }?></td>
	<td><?php if($sub_compt=='TH'){ echo $examtime; } ?></td>
	<td></td>
	<td></td>		
</tr>
<?php $bk++;}else if(($sub_compt=='PR') && ($emp_per[0]['current_semester']==$sub['semester'])){
		if($jk==1){
		?>
		<tr><td colspan=7><b>Lab</b></td></tr>
		<?php }?>
	<tr>		
		<td align="center"><?=$sub['semester']?></td>
		<td align="center"><?=$sub['subject_code']?></td>
		<td><?=$sub['subject_name']?> *</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>		
	</tr>
	<?php $jk++;
	}else
{
	
}
?>
<?php 
//$ik++;


	}
	}
?>
<tr>
		
<td colspan='7' align="left">* - <i> marked courses schedule are displayed by the school/department.</i></td>
	
</tr>

            
            </table>
            
            </td>
            </tr>

           <tr>
            <td style="border-top:1px solid #333;padding-left:5px;font-size:10px;height:50px;" height="60">
            <h4>Instruction to Candidate</h4>
            <ol>
          <li> Without Identification Card candidate shall not be allowed to write the examination. </li>    
		  <li> Attend the Examination as per the dates mentioned above.          
          </li>    
           <li>Carrying mobile phone or any Electronic device into the examination hall is strictly prohibited.
		    <li>Refer instruction at the facing sheet of the Answer book before writing the examination.
           </li> 
               
            </ol>
            </td>
            </tr>
          
          <tr>
            <td align="center" style="border-top:1px solid #333;">
            <table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center">
    <table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  
  <tr>
    <td align="center" class="signature" height="50" >&nbsp;</td>
    <td align="center" class="signature">&nbsp;</td>
    <td align="center" class="signature">&nbsp;</td>
   
  </tr>
  
  <tr>
    <td align="center" height="50" class="signature"><strong>__________________________<br>Student Signature</strong></td>
    <td align="center" height="50" class="signature"><strong>__________________________<br>Dean/HoD Signature</strong></td>
    <td align="center" height="50" class="signature"><strong>__________________________<br>COE Signature</strong></td>  
  </tr>
</table>

    </td>
  </tr>
</table>
            </td>
            </tr>

            </tbody>
            </table>
  
</body>
</html>
