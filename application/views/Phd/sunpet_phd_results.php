<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style>
body{font-family: arial, sans-serif;font-size:12px;}
table tr th{padding:5px;}
table tr td{padding:5px;}
table{border-collapse:collapse;}
</style>
</head>
<?php
//$siteurl = "https://sandipuniversity.com/PHD18";
?>

<body>
    <?php
    foreach($phd as $students)
    {
    ?>
<div style="width:100%;height:1200px;margin:0 auto;overflow:hidden;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  
    <td align="center">
    <img src="<?= base_url() ?>assets/images/logo-7.png" width="200">
    <p style="padding:0;margin:0px;">Mahiravani, Trimbak Road, Nashik – 422 213</p>
    <h3 style="font-size:18px;">SUNPET - February 2024 (ACADEMIC YEAR 2023-24)</h3>
      <h3 style="font-size:18px;"><u>RESULT CARD</u></h3>
    </td>
  
  </tr>
</table>
<br>
<table width="100%" border="1" cellspacing="0" cellpadding="0">

 <tr>
      
    <td width="180"><strong> Adm. Ticket No.: </strong></td>
        <td colspan="3"><?=strtoupper($students['phd_reg_no'])?> </td>
  <!--  <td rowspan="3" width="100"><img src="<?=$siteurl ?>/uploads/phd/<?= $doc['doc_file']?>" width="100"></td>-->
    </tr>
  <tr>
      
    <td width="180"><strong>Candidate Name: </strong></td>
        <td colspan="3"><?=strtoupper($students['student_name'])?> </td>
  
    </tr>
    
    
  <tr>
    <td> <strong>Department: </strong></td>
    <td colspan="3"><?=$students['department']?></td>
    </tr>
	<tr>
    <td> <strong>Date of SUNPET Examination: </strong></td>
    <td colspan="3">Saturday, 24<sup>th</sup> FEB 2024</td>
    </tr>
    
  <!--tr>
    <td><strong>Degree Type(FT/PT): </strong></td>
   <td colspan="3"><?php if($students['admission_category']=="FT"){echo "Full Time";} if($students['admission_category']=="PT"){echo "Part Time";}?></td>
  
  
    </tr>
    
  <tr>
    <td ><strong>Entrance Marks(/100): </strong></td>
   <td colspan="3"><?= $students['entrance_marks']?></td>
    </tr>  
	<tr>
    <td ><strong>Interview Marks(/100): </strong></td>
   <td colspan="3"><?= $students['interview_marks']?></td>
    </tr-->  
	<tr>
    <td><strong>Final Marks(/100): </strong></td>
   <td colspan="3"><?php echo round(($students['entrance_marks']+$students['interview_marks'])/2)?></td>
    </tr>
</table>
<br><br><br>
<table border="0" width="100%">
    <tr>  
	    <td height="80" valign="bottom" align="left">
      <strong>Verified By</strong>
   </td>
  <!--td height="100" width="50%" valign="bottom"><p align="right"><strong></strong></p></td-->
  <td height="80" valign="bottom" align="right">
      <!--img src="<?=base_url() ?>assets/images/Sign-COE-011.png" width="" style="margin-bottom:-15px"-->
      <strong>Controller Of Examinations</strong>
        </td>
      </tr> 	  
    <tr>
	<td height="80" valign="bottom" align="left">
      <strong>printed on: <?php echo date("Y/m/d")?></strong>
   </td>
</tr>	  
    </table>
</div>


<?php
}
?>
</body>
</html>
