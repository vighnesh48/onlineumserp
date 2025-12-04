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
$siteurl = "https://sandipuniversity.com/PHD19";
?>
<body>
<div style="width:100%;height:1200px;margin:0 auto;overflow:hidden;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  
    <td align="center">
    <img src="<?= base_url() ?>assets/images/logo-7.png" width="200">
    <p style="padding:0;margin:0px;">Mahiravani, Trimbak Road, Nashik – 422 213</p>
    <h3 style="font-size:18px;">SUNPET - JULY 2019 (ACADEMIC YEAR 2019-20)</h3>
      <h3 style="font-size:18px;"><u>ADMIT CARD</u></h3>
    </td>
  
  </tr>
</table>


<br>
 
<table width="100%" border="1" cellspacing="0" cellpadding="0">

 <tr>
      
    <td width="180"><strong> HALL TICKET NO.: </strong></td>
        <td colspan="2"><?=strtoupper($students['phd_reg_no'])?> </td>
    <td rowspan="3" width="100"><img src="<?=$siteurl ?>/uploads/phd/<?= $doc['doc_file']?>" width="100"></td>
    </tr>
  <tr>
      
    <td width="180"><strong> NAME OF THE CANDIDATE: </strong></td>
        <td colspan="2"><?=strtoupper($students['student_name'])?> </td>
  
    </tr>
  <tr>
    <td ><strong>DATE OF BIRTH: </strong></td>
      <td colspan="2"><?=date('d-m-Y',strtotime($students['dob']))?></td>
    </tr>
  <tr>
    <td ><strong>ADDRESS: </strong>
    </td>
   
     <td colspan="3"><?=$students['address_c']?> 
    <?=$students['city_c']?>
    <?=$students['cstate']?>
    <?=$students['pincode_c']?>
    </td>
    </tr>
      
    
  <tr>
    <td ><strong>CATEGORY: </strong></td>
   <td colspan="3"><?=$students['category']?></td>
    </tr>

    
  <tr>
    <td><strong>COURSE CATEGORY: </strong></td>
   <td colspan="3"><?php if($students['admission_category']=="FT"){echo "Full Time";} if($students['admission_category']=="PT"){echo "Part Time";}?></td>
  
  
    </tr>

  <tr>
    <td> <strong>DEPARTMENT: </strong></td>
    <td colspan="3"><?= $students['department']?></td>
    </tr>

  <tr>
    <td> <strong>DATE: </strong></td>
    <td colspan="3">18<sup>th</sup> - AUGUST - 2019 (SUNDAY)</td>
    </tr>
     <tr>
    <td> <strong>TIME: </strong></td>
    <td colspan="3">12:00 Hrs-14:00 Hrs</td>
    </tr> 
      <tr>
    <td> <strong>VENUE: </strong></td>
    <td colspan="3">“O” BUILDING SANDIP UNIVERSITY NASHIK
Trimbak Road, Mahiravani, Nashik - 422213, Maharashtra, India</td>
    </tr>
   
   
    <tr>
    <td colspan="4"> 
   <strong>Note: </strong>
   <ul>
     <li> <p align="left">Please bring your original ADHAAR/PAN/PASSPORT to appear in SUNPET Exam as Identity Proof.</p></li>
   <li> <p align="left">Please be present One hour before the Commencement of Examination.</p></li>
    <li> <p align="left">All the Candidates are requested to submit one set of self-attested photocopies of all the necessary documents as mentioned in the application form just before the commencement of Examination in the respective Examination Hall</p>
     </li>
    </td>
    </tr>
    
    



    
</table>
<br><br><br>
<table border="0" width="100%">
    <tr>  
  <td  height="100" width="50%" valign="bottom"><p align="right"><strong>Candidate Signature</strong></p></td>
  <td height="80" valign="bottom" align="right">
      <img src="<?= base_url() ?>assets/images/Sign-COE-011.png" width="" style="margin-bottom:-15px"><br>
      <strong>Controller of Examinations</strong>
</td>

    
    </tr>  
    </table>

</div>










              




</body>
</html>
