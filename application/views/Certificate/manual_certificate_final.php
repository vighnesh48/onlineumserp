<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Certificate</title>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style>
body{font-family:"Times New Roman", Times, serif}
.wrapper{ width:100%;}
.logo{width:15%;float:left;}
.midd{float:left;width:65%;text-align:center;}
.prfpic{width:100px;float:left;text-align:center;border:1px solid #333;}
.contain h2,.midd h2{text-align:center;font-weight:normal;font-size:18px;margin:0;font-style:italic;}
.contain{height:555px;}
.prn{font-size:15px;margin-bottom:20px;}
.idate{font-size:15px;width:100%;}
#maintable_one,#table2excel{ font-size:12px;}
#maintable{ font-size:16px;}
/*.tt{
  display: inline-block !important;
  width: 50% !important;margin: -1en;
}
#maintable_one { display: inline-block; vertical-align: top; border: 1px solid;margin: -1en; }
*/
</style>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-sm-6"><table width="100%" border="1" cellspacing="0" cellpadding="0" id="maintable_one">
 <tr>
 <td colspan="6">Semestar<?php ?></td>
 </tr>
  <tr>
    <td><b>Course Code</b></td>
    <td><b>Course Title</b></td>
    <td><b>Cr</b></td>
    <td><b>LG</b></td>
    <td><b>GP</b></td>
    <td><b>M&Y Of Passing</b></td>
  </tr>
</table></div>
    <div class="col-sm-6"><table width="100%" border="1" cellspacing="0" cellpadding="0" id="maintable_one">
 <tr>
 <td colspan="6">Semestar<?php ?></td>
 </tr>
  <tr>
    <td><b>Course Code</b></td>
    <td><b>Course Title</b></td>
    <td><b>Cr</b></td>
    <td><b>LG</b></td>
    <td><b>GP</b></td>
    <td><b>M&Y Of Passing</b></td>
  </tr>
</table></div>
  </div>
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" id="maintable">
  <tr>
    <td align="center">
    <img src="http://sandipuniversity.com/erp/assets/images/logo_form.png" width="300" />
    <p style="margin-top:0"><strong>SANDIP UNIVERSITY,NASHIK</strong></p>
    <p style="margin-top:0"><strong>OFFICE OF THE CONTROLLER OF EXAMINATIONS</strong></p>
    <p style="margin-top:5; font-size:15px !important;"><b>DEGREE DETAILS</b></p>  </td>
  </tr>
</table>
<div><br /></div>
<table width="100%" border="1" cellspacing="0" cellpadding="0" id="maintable_one">
  <tr>
    <td><b>No</b></td>
    <td><b>Name</b></td>
    <td><b>Date Of Birth</b></td>
    <td><b>Programme And Branch</b></td>
  </tr>
  <tr>
    <td><?php print_r($regulation);?></td>
    <td><?php print_r($regulation);?></td>
    <td><?php print_r($exam_new);?></td>
    <td><?php print_r($schoolname_new);?></td>
  </tr>
   <tr>
    <td><b>Month&Year Of last Appearance</b></td>
    <td><b>Regultion</b></td>
    <td><b>Gender</b></td>
  </tr>
  <tr>
    <td><?php print_r($admissioncourse_new);?></td>
    <td><?php print_r($admissionbranch_new);?></td>
    <td>&nbsp;</td>
  </tr>
</table><div><br /></div>
<!--<div style="width:100%">-->
<table width="100%" border="1" cellspacing="0" cellpadding="0" id="">
  <tr>
    <td><b>Course Code</b></td>
    <td><b>Course Title</b></td>
    <td><b>Cr</b></td>
    <td><b>LG</b></td>
    <td><b>GP</b></td>
    <td><b>M&Y Of Passing</b></td>
    <td><b>Course Code</b></td>
    <td><b>Course Title</b></td>
    <td><b>Cr</b></td>
    <td><b>LG</b></td>
    <td><b>GP</b></td>
    <td><b>M&Y Of Passing</b></td>
  </tr>
</table>
<div class="tt">
<table width="100%" border="1" cellspacing="0" cellpadding="0" id="maintable_one">
 <tr>
 <td colspan="6">Semestar<?php ?></td>
 </tr>
  <tr>
    <td><b>Course Code</b></td>
    <td><b>Course Title</b></td>
    <td><b>Cr</b></td>
    <td><b>LG</b></td>
    <td><b>GP</b></td>
    <td><b>M&Y Of Passing</b></td>
  </tr>
</table>
</div>
<div class="tt">
<table width="100%" border="1" cellspacing="0" cellpadding="0" id="maintable_one">
 <tr>
 <td colspan="6">Semestar<?php ?></td>
 </tr>
  <tr>
    <td><b>Course Code</b></td>
    <td><b>Course Title</b></td>
    <td><b>Cr</b></td>
    <td><b>LG</b></td>
    <td><b>GP</b></td>
    <td><b>M&Y Of Passing</b></td>
  </tr>
</table>
</div>
<!--</div>-->




<table width="100%" border="0" cellspacing="0" cellpadding="0" id="maintable_one">
 <br />
 
</table>
<div><br /></div>

<div><br /></div>
</body>
</html>