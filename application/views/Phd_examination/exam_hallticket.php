<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hall Ticket</title>
    <style>  
    
            table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:12px; margin:0 auto;
            }  
      td{vertical-align: top;}
                      
            .signature{
            text-align: center;
            }
            .marks-table{
            width: 100%;height:450px;
            }
            p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
            .marks-table td{height:30px;vertical-align:middle;}
			
            .marks-table th{height:30px;}
.content-table td{border:1px solid #333;padding-left:5px;vertical-align:middle;}
.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
        </style>  

</head>


<body>
 
<?php
//echo "<pre>";
//print_r($emp_list);exit;
$CI =& get_instance();
$CI->load->model('Results_model');

for($i=0;$i<count($emp_list);$i++){
	//echo $emp_list[$i]['emp_per'][0]['form_number'];
	$subjects = $emp_list[$i]['sublist'];//exit;
	if (file_exists('uploads/2017-18/'.$emp_list[$i]['emp_per'][0]['form_number'].'/' .$emp_list[$i]['emp_per'][0]['form_number'].'_PHOTO.bmp')) {
       $ext = 'bmp';
   }
   else
   {
         $ext = 'jpg';
   }	
?>



  
   <table align="center" width="700"> 
            <tbody>  
            <tr>
            <td valign="top" height="40">
            <table cellpadding="10" cellspacing="10" border="0" align="center" width="800" style="margin-top:50px;">
            <tr>
<td width="25%" align="right" style="text-align:center;padding-top:5px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
<td style="font-weight:normal;text-align:left;">
<h1 style="font-size:27px;">Sandip University</h1>
<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

</td>
<td width="20%" align="right" valign="middle" style="padding-top:20px;">

<?php
		$bucket_key = "uploads/exam/".$emp_list[$i]['exam_month'].''.$emp_list[$i]['exam_year']."/QRCode/qrcode_".$emp_list[$i]['emp_per'][0]['enrollment_no'].".png";
		$imageData = $this->awssdk->getImageData($bucket_key);
	?>
<span style="border:0px solid #333;padding:10px;"><img src="<?=$imageData?>"></td>

<tr>
<td></td>
<td align="left" style="text-align:left;margin:0;padding:0"><h3 style="font-size:18px;">Exam Hall Ticket - <?=$emp_list[$i]['exam_month']?> <?=$emp_list[$i]['exam_year']?></h3></td>
<td></td>
</tr>
            
 </table>
            </td>
            </tr>

            <tr>
            <td style="padding:0;">
            <table class="content-table" width="800" cellpadding="0" cellspacing="0" border="0" align="center" style="font-size:12px;height:150px;overflow: hidden;">
            <tr>
            <td width="120" height="30"><strong>PRN :</strong></td>
            <td><?=$emp_list[$i]['emp_per'][0]['enrollment_no']?></td>
            <td valign="top" width="120" height="100" rowspan="4">
            <?php
		        $bucket_key = 'uploads/student_photo/'.$emp_list[$i]['emp_per'][0]['enrollment_no'].'.jpg';
		        $imageData = $this->awssdk->getImageData($bucket_key);
		    ?>
            <img src="<?=$imageData?>" alt="" width="120" height="120">
            </td> 
            <!--https://erp.sandipuniversity.com/uploads/2017-18/<?=$emp_list[$i]['emp_per'][0]['form_number']?>/<?=$emp_list[$i]['emp_per'][0]['form_number']?>_PHOTO.<?=$ext?>-->
            </tr>
            <tr>
			<td height="30"><strong>Name :</strong></td>
            <td><?=$emp_list[$i]['emp_per'][0]['last_name']?> <?=$emp_list[$i]['emp_per'][0]['first_name']?> <?=$emp_list[$i]['emp_per'][0]['middle_name']?></td>
			<tr>
            <td height="30"><strong>Stream Name :</strong></td>
            <td><?=$emp_list[$i]['emp_per'][0]['stream_name']?></td>
            
            </tr>
            <tr>
            <td height="30"><strong>School Name:</strong></td>
            <td><?=$emp_list[$i]['emp_per'][0]['school_short_name']?></td>

            
            
            
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
$jk=1;
$bk=1;
$bkp=1;
	if(!empty($subjects)){
		foreach($subjects as $sub){
			$fromtime= explode(':', $sub['from_time']);
			$totime= explode(':', $sub['to_time']);
			if($sub['date']!='000-00-00' && $sub['date'] !=''){
					$examdate = date('d/m/Y', strtotime($sub['date']));
					$pr_date ="";
				}else{
					$examdate = "";
					$pr_date ="*";
				}
				if(!empty($sub['from_time']) && !empty($sub['to_time'])){
					$examtime = $fromtime[0].':'.$fromtime[1].'-'.$totime[0].':'.$totime[1];
				}else{
					$examtime = "";
				}

	if(($sub['subtype']=='TH' || $sub['subtype']=='PR') && ($emp_list[$i]['emp_per'][0]['current_semester']!=$sub['semester'])){
		
		if($ik==1){
		?>
		 <!-- here Backlog is changed to theory for temporary purpose by Arvind*/-->
		<tr style="height:5px"><td colspan=7><b>Theory</b></td></tr> 
		<?php }?>
		<?php 
		if($sub['subject_component']=='EM'){
			//$res_fail =$this->Results_model->get_failed_sub_type($emp_list[$i]['emp_per'][0]['stud_id'], $sub['sub_id']);
			$fsubtype=$CI->Results_model->get_failed_sub_type1($emp_list[$i]['emp_per'][0]['stud_id'], $sub['sub_id']);
		}
		?>
<tr>

	<td align="center"><?=$sub['semester']?></td>
	<td align="center"><?=$sub['subject_code']?></td>
	<td><?=$sub['subject_name']?> <?=$pr_date?> <?php 
		if($sub['subject_component']=='EM' && $fsubtype[0]['grade']=='U'){ echo "(".$fsubtype[0]['failed_sub_type'].")"; }?></td>
	<td><?php if($sub['subtype']=='TH'){ echo $examdate; }?></td>
	<td><?php if($sub['subtype']=='TH'){ echo $examtime; } ?></td>
	<td></td>
	<td></td>
	
	
</tr>
<?php $ik++; 
}else if(($sub['subtype']=='PR') && ($emp_list[$i]['emp_per'][0]['current_semester']==$sub['semester'])){
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
	}else if(($sub['subtype']=='TH') && ($emp_list[$i]['emp_per'][0]['current_semester']==$sub['semester'])){
	if($bk==1){
		?>
		<tr><td colspan=7><b>Theory</b></td></tr>
		<?php }?>
	<tr>		
	<td align="center"><?=$sub['semester']?></td>
	<td align="center"><?=$sub['subject_code']?></td>
	<td><?=$sub['subject_name']?></td>
	<td><?php if($sub['subtype']=='TH'){ echo $examdate; }?></td>
	<td><?php if($sub['subtype']=='TH'){ echo $examtime; } ?></td>
	<td></td>
	<td></td>		
</tr>
<?php $bk++;}else{
	
}
?>
<?php 
//$ik++;
	}
	}
?>
<tr>
		
<td colspan='7' align="left">* - <i> marked courses schedule are displayed by the school/department.</i></td>
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
  
  
  
  
 
        
         
  
  


<?php //exit;
unset($ik);unset($jk);unset($bk);
}
?>


</body>
</html>
