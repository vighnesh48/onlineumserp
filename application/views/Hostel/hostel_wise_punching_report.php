<?php //print_r($all_attend);  exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<style>

.attexl table th{
    border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.add-table tr td{border:0px}

.attexl table  td{
     border: 1px solid black;
    padding: 5px;border-collapse: collapse
}
.bottom-table{padding:50px 0 20px 0}
.bottom-table-2{padding-top:20px}
</style>

<div class="row">

<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="100"><img src="<?php echo base_url(); ?>assets/images/lg.png" alt="Sandip University" class="img-responsive"></td>
    <td valign="top" align="center">
    <span style="font-size:25px;text-align:center"><b>Sandip University</b></span><br>
    <span style="text-align:center;font-size:11px">Trimbak Road, A/p - Mahiravani, Nashik – 422 213</span><br>
    <span style="font-size:10px;text-align:center">Website : http://www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in </span><br>
    <span style="font-size:15px;;text-align:center"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></span>
    </td>
  </tr>
</table>
<hr  style="border-width:1px;">
<?php
$date=date('Y-m-d');
$d = date_parse_from_format("Y-m-d",$date);
$msearch=$d["month"];//month number
$ysearch=date("Y",strtotime($date));
$monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name
?>
<div align="center" style="text-align:center">
<?php if(!empty($students_data)){ ?>
<b>Hostel Wise Student Punching Report Of :<?=$date?></b>
<?php } if(!empty($students_data_by)){ ?>
<b>Student Punching (After 10:00 PM) Report Of :<?=$date?></b>	
<?php } if(!empty($students_data_gl)){ ?>
<b>Student Punching (After 07:00 PM) Report Of :<?=$date?></b>	
<?php } ?>
 </div>
</div>
<br>
<div class="col-lg-12">

</div>
</div>



<div class="attexl" id="ReportTable1" style="">
 <div class="table-scrollable" id="reporttab">
<table  cellpadding="0" cellspacing="0" style="font-size:11px" width="100%" align="center" class="attexl">
<tbody>

 <tr bgcolor="#9ed9ed" >
 <td width="5%"><strong>SRNo.</strong></td>
 <td width="20%"><strong>Student ID</strong></td>
 <td width="30%"><strong>Name Of Student</strong></td>
 <td width="10%"><strong>Direction</strong></td>
 <td width="25%"><strong>Punching Time</strong></td>
 <td width="10%"><strong>Hostel</strong></td>

 <?php 
 $i=1;
 //echo $sbtn;
  //print_r($all_attend);
if(!empty($students_data)){ 
 foreach($students_data as $row){ 
 ?>
 <tr> 
<td ><?=$i;?></td>
<td ><?=$row['stud_id']?></td>
<td ><?=$row['student_name']?></td>
<td ><?=$row['direction']?></td>
<td ><?=$row['LogDate']?></td>
<td ><?=$row['hostel_code']?></td>
<tr>
 <?php $i++; } } ?>
 <?php
 if(!empty($students_data_by)){  
 foreach($students_data_by as $row){ 
 ?>
 <tr> 
<td ><?=$i;?></td>
<td ><?=$row['stud_id']?></td>
<td ><?=$row['student_name']?></td>
<td ><?=$row['direction']?></td>
<td ><?=$row['LogDate']?></td>
<td ><?=$row['hostel_code']?></td>
<tr>
 <?php $i++; } } ?>
 <?php
 if(!empty($students_data_gl)){  
 foreach($students_data_gl as $row){ 
 ?>
 <tr> 
<td ><?=$i;?></td>
<td ><?=$row['stud_id']?></td>
<td ><?=$row['student_name']?></td>
<td ><?=$row['direction']?></td>
<td ><?=$row['LogDate']?></td>
<td ><?=$row['hostel_code']?></td>
<tr>
 <?php $i++; } } ?>
  
</tbody>  
</table>
