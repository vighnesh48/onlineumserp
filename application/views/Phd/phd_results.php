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
$siteurl = "https://sandipuniversity.com/PHD18";
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
    <h3 style="font-size:18px;">SUNPET - AUGUST 2018 (ACADEMIC YEAR 2018-19)</h3>
      <h3 style="font-size:18px;"><u>RESULT CARD</u></h3>
    </td>
  
  </tr>
</table>


<br>
 
<table width="100%" border="1" cellspacing="0" cellpadding="0">

 <tr>
      
    <td width="180"><strong> Adm. Ticket No.: </strong></td>
        <td colspan="3"><?=strtoupper($students['reg_no'])?> </td>
  <!--  <td rowspan="3" width="100"><img src="<?=$siteurl ?>/uploads/phd/<?= $doc['doc_file']?>" width="100"></td>-->
    </tr>
  <tr>
      
    <td width="180"><strong>Candidate Name: </strong></td>
        <td colspan="3"><?=strtoupper($students['student_name'])?> </td>
  
    </tr>
    
    
  <tr>
    <td> <strong>Branch: </strong></td>
    <td colspan="3"><?= $students['stream']?></td>
    </tr>
    
  <tr>
    <td><strong>Degree Type(FT/PT): </strong></td>
   <td colspan="3"><?php if($students['exam_type']=="FT"){echo "Full Time";} if($students['exam_type']=="PT"){echo "Part Time";}?></td>
  
  
    </tr>
    
  <tr>
    <td ><strong>Marks out of 100: </strong></td>
   <td colspan="3"><?= $students['marks_obtained']?></td>
    </tr>

    




    



    
</table>
<br><br><br>
<table border="0" width="100%">
    <tr>  
  <td  height="100" width="50%" valign="bottom"><p align="right"><strong></strong></p></td>
  <td height="80" valign="bottom" align="right">
      <img src="<?= base_url() ?>assets/images/Sign-COE-011.png" width="" style="margin-bottom:-15px"><br>
      <strong>Controller of Examinations</strong>
</td>

    
    </tr>  
    </table>

</div>


<?php
}
?>







              




</body>
</html>
