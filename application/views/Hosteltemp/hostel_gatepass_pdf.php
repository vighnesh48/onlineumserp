<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gate pass</title>
<style>
.details td{padding:5px 0;}
.border{border:1px solid #000;}
.sign{height:50px;border-top:1px solid #000;}

</style>
</head>
<body>
<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
ini_set('max_execution_time', 300000);
require('code128.class.php');
//include_once "phpqrcode/qrlib.php";
$font = 'Verdana.ttf';

$form_no = $std_gatepass_details['hgp_id'];
$barcode = new phpCode128($form_no);
$barcode->saveBarcode('uploads/gatepass/'.$form_no.'.jpg');

?>
  <br><br>  
<div style="width:95%;xheight:842px;margin:0 auto;border:1px solid #000;padding:10px;">
 
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;xheight:415px">
    <tr>
      <td style="border-bottom:1px solid #000"><strong>App. No :</strong><?=$std_gatepass_details['hgp_id']?><br />
        <img style="padding-top:5px;" src="<?=base_url()?>uploads/gatepass/<?=$form_no?>.jpg" alt="Sandip University" /></td>
      <td valign="top" align="center" style="border-bottom:1px solid #000" width="60%"><img src="<?=base_url()?>SF.jpg">
        <p><strong>Phone:</strong>(02594) 222 541, 42, 43, 44, 45 | <strong>Fax:</strong>(02594) 222 555</p></td>
      <td align="center" style="border-bottom:1px solid #000"><strong>Student Copy</strong></td>
    </tr>
    
<tr>
<td colspan="3" align="left" width="100%">
<table width="800" border="0" cellspacing="0" cellpadding="0" class="details">
<tr>
      <td><span style="border:1px solid #000;padding:5px 15px;"><?=$std_gatepass_details['hostel_code']?>/<?=$std_gatepass_details['floor_no']?>/<?=$std_gatepass_details['room_no']?></span></td>
      <td align="center" width="300"><h2><strong>Gate Pass</strong></h2></td>
      <td align="right"><strong>Date:</strong> <?=date("d/m/Y", strtotime($std_gatepass_details['added_on']))?></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><p>The undermentioned Student is authorized for</p></td>
    </tr>

<tr>  <td width="250"><strong>Going To:</strong> <?=$std_gatepass_details['type']?></td>
      <td colspan="2"><strong>For Date:</strong> <?php
		$fdate= date("F", strtotime($std_gatepass_details['from_date']));
		$tdate = date("F", strtotime($std_gatepass_details['to_date']));

		if($std_gatepass_details['from_date']!=$std_gatepass_details['to_date'])
		{
			 if($fdate!=$tdate)
			{
				echo date("d F", strtotime($std_gatepass_details['from_date']))." to ". date("d F, y", strtotime($std_gatepass_details['to_date']));
			}
			else{
				echo date("d", strtotime($std_gatepass_details['from_date']))." to ". date("d F, y", strtotime($std_gatepass_details['to_date']));
			} 
		}
		else
		echo date("d F, y", strtotime($std_gatepass_details['from_date']));
	  ?>
	  </td>
      
    </tr>
    <tr>
      <td colspan="3"><strong>Purpose:</strong> <?=$std_gatepass_details['purpose']?></td>
    </tr>
    <tr>
      <td><strong>Student Id:</strong> <?=$std_gatepass_details['stud_prn']?></td>
      <td colspan="2"><strong>Name:</strong> <?=$std_gatepass_details['first_name']?> <?=$std_gatepass_details['last_name']?></td>
    </tr>
    <tr>
      <td><strong>Institute:</strong> <?=$std_gatepass_details['organisation']?> - <?=$std_gatepass_details['school_name']?></td>
      <td colspan="2"><strong>Course / Year:</strong> <?=$std_gatepass_details['course_name']?> / <?=$std_gatepass_details['current_year']?></td>
    </tr>
   
		<tr>
      <td align="center" class="sign"><p>&nbsp;</p></td>
      <td align="center" class="sign"><p>&nbsp;</p></td>
      <td align="center" class="sign"><p>&nbsp;</p></td>
    </tr>
    <tr>
      <td align="center"><strong>Signature of Student</strong></td>
      <td align="center"><strong>Signature of In-charge</strong></td>
      <td align="center"><strong>Printed on:</strong> <?=date('d/m/Y')?></td>
    </tr>
</table>

</td>
</tr>
    
  </table>
  <hr style="border:dotted 1px #000" />
   <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;xheight:415px">
    <tr>
      <td style="border-bottom:1px solid #000"><strong>App. No :</strong><?=$std_gatepass_details['hgp_id']?><br />
        <img style="padding-top:5px;" src="<?=base_url()?>uploads/gatepass/<?=$form_no?>.jpg" alt="Sandip University" /></td>
      <td valign="top" align="center" style="border-bottom:1px solid #000" width="60%"><img src="<?=base_url()?>SF.jpg">
        <p><strong>Phone:</strong>(02594) 222 541, 42, 43, 44, 45 | <strong>Fax:</strong>(02594) 222 555</p></td>
      <td align="center" style="border-bottom:1px solid #000"><strong>Hostel Copy</strong></td>
    </tr>
    
<tr>
<td colspan="3" align="left" width="100%">
<table width="800" border="0" cellspacing="0" cellpadding="0" class="details">
<tr>
      <td><span style="border:1px solid #000;padding:5px 15px;"><?=$std_gatepass_details['hostel_code']?>/<?=$std_gatepass_details['floor_no']?>/<?=$std_gatepass_details['room_no']?></span></td>
      <td align="center" width="300"><h2><strong>Gate Pass</strong></h2></td>
      <td align="right"><strong>Date:</strong> <?=date("d/m/Y", strtotime($std_gatepass_details['added_on']))?></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><p>The undermentioned Student is authorized for</p></td>
    </tr>

<tr>  <td width="250"><strong>Going To:</strong> <?=$std_gatepass_details['type']?></td>
        <td colspan="2"><strong>For Date:</strong> <?php
		$fdate= date("F", strtotime($std_gatepass_details['from_date']));
		$tdate = date("F", strtotime($std_gatepass_details['to_date']));

		if($std_gatepass_details['from_date']!=$std_gatepass_details['to_date'])
		{
			 if($fdate!=$tdate)
			{
				echo date("d F", strtotime($std_gatepass_details['from_date']))." to ". date("d F, y", strtotime($std_gatepass_details['to_date']));
			}
			else{
				echo date("d", strtotime($std_gatepass_details['from_date']))." to ". date("d F, y", strtotime($std_gatepass_details['to_date']));
			} 
		}
		else
		echo date("d F, y", strtotime($std_gatepass_details['from_date']));
	  ?>
	  </td>
      
    </tr>
    <tr>
      <td colspan="3"><strong>Purpose:</strong> <?=$std_gatepass_details['purpose']?></td>
    </tr>
    <tr>
      <td><strong>Student Id:</strong> <?=$std_gatepass_details['stud_prn']?></td>
      <td colspan="2"><strong>Name:</strong> <?=$std_gatepass_details['first_name']?> <?=$std_gatepass_details['last_name']?></td>
    </tr>
    <tr>
      <td><strong>Institute:</strong> <?=$std_gatepass_details['organisation']?> - <?=$std_gatepass_details['school_name']?></td>
      <td colspan="2"><strong>Course / Year:</strong> <?=$std_gatepass_details['course_name']?> / <?=$std_gatepass_details['current_year']?></td>
    </tr>
   
		<tr>
      <td align="center" class="sign"><p>&nbsp;</p></td>
      <td align="center" class="sign"><p>&nbsp;</p></td>
      <td align="center" class="sign"><p>&nbsp;</p></td>
    </tr>
    <tr>
      <td align="center"><strong>Signature of Student</strong></td>
      <td align="center"><strong>Signature of In-charge</strong></td>
      <td align="center"><strong>Printed on:</strong> <?=date('d/m/Y')?></td>
    </tr>
</table>

</td>
</tr>
    
  </table>
   <hr style="border:dotted 1px #000" />
   <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;xheight:415px">
    <tr>
      <td style="border-bottom:1px solid #000"><strong>App. No :</strong><?=$std_gatepass_details['hgp_id']?><br />
        <img style="padding-top:5px;" src="<?=base_url()?>uploads/gatepass/<?=$form_no?>.jpg" alt="Sandip University" /></td>
      <td valign="top" align="center" style="border-bottom:1px solid #000" width="60%"><img src="<?=base_url()?>SF.jpg">
        <p><strong>Phone:</strong>(02594) 222 541, 42, 43, 44, 45 | <strong>Fax:</strong>(02594) 222 555</p></td>
      <td align="center" style="border-bottom:1px solid #000"><strong>Hostel Copy</strong></td>
    </tr>
    
<tr>
<td colspan="3" align="left" width="100%">
<table width="800" border="0" cellspacing="0" cellpadding="0" class="details">
<tr>
      <td><span style="border:1px solid #000;padding:5px 15px;"><?=$std_gatepass_details['hostel_code']?>/<?=$std_gatepass_details['floor_no']?>/<?=$std_gatepass_details['room_no']?></span></td>
      <td align="center" width="300"><h2><strong>Gate Pass</strong></h2></td>
      <td align="right"><strong>Date:</strong> <?=date("d/m/Y", strtotime($std_gatepass_details['added_on']))?></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><p>The undermentioned Student is authorized for</p></td>
    </tr>

<tr>  <td width="250"><strong>Going To:</strong> <?=$std_gatepass_details['type']?></td>
        <td colspan="2"><strong>For Date:</strong> <?php
		$fdate= date("F", strtotime($std_gatepass_details['from_date']));
		$tdate = date("F", strtotime($std_gatepass_details['to_date']));

		if($std_gatepass_details['from_date']!=$std_gatepass_details['to_date'])
		{
			 if($fdate!=$tdate)
			{
				echo date("d F", strtotime($std_gatepass_details['from_date']))." to ". date("d F, y", strtotime($std_gatepass_details['to_date']));
			}
			else{
				echo date("d", strtotime($std_gatepass_details['from_date']))." to ". date("d F, y", strtotime($std_gatepass_details['to_date']));
			} 
		}
		else
		echo date("d F, y", strtotime($std_gatepass_details['from_date']));
	  ?>
	  </td>
      
    </tr>
    <tr>
      <td colspan="3"><strong>Purpose:</strong> <?=$std_gatepass_details['purpose']?></td>
    </tr>
    <tr>
      <td><strong>Student Id:</strong> <?=$std_gatepass_details['stud_prn']?></td>
      <td colspan="2"><strong>Name:</strong> <?=$std_gatepass_details['first_name']?> <?=$std_gatepass_details['last_name']?></td>
    </tr>
    <tr>
      <td><strong>Institute:</strong> <?=$std_gatepass_details['organisation']?> - <?=$std_gatepass_details['school_name']?></td>
      <td colspan="2"><strong>Course / Year:</strong> <?=$std_gatepass_details['course_name']?> / <?=$std_gatepass_details['current_year']?></td>
    </tr>
   
		<tr>
      <td align="center" class="sign"><p>&nbsp;</p></td>
      <td align="center" class="sign"><p>&nbsp;</p></td>
      <td align="center" class="sign"><p>&nbsp;</p></td>
    </tr>
    <tr>
      <td align="center"><strong>Signature of Student</strong></td>
      <td align="center"><strong>Signature of In-charge</strong></td>
      <td align="center"><strong>Printed on:</strong> <?=date('d/m/Y')?></td>
    </tr>
</table>

</td>
</tr>
    
  </table>
</div>


</body>
</html>
