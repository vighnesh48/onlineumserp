<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
$role_id = $this->session->userdata("role_id");
if($role_id ==4){
	$reval = REVAL;
}else{
	$reval = $this->session->userdata('reval');
}
if($reval==0){
    $report_name="PHOTOCOPY";
    $reportName="Photocopy";
}else{
    $report_name="REVALUATION";
    $reportName="Revaluation";
}    
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$report_name?></title>
<style type="text/css">
body{ font-family:Times New Roman, Times, serif;font-size:13px;}

.space{height:150px;vertical-align:bottom;}

.detail-table tr td{padding:5px;}
.detail-table tr th{padding:8px 5px;}
ol.li { margin-bottom:7px!important;}
</style>
</head>

<body >
<div style="align:center;border:5px double #000;padding:10px;height:1200px!important;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" align="center"><img width="200" height="53" src="https://erp.sandipuniversity.com/assets/images/logo-su.png"></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong>OFFICE OF THE CONTROLLER OF EXAMINATIONS</strong> <br>
  <strong>APPLICATION FORM- <?=$report_name?> - <?=$exam[0]['exam_month']?> <?=$exam[0]['exam_year']?><br><br>&nbsp;</strong></td>
  </tr>
  
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="detail-table">
    <tr>
    <td width="30%">PRN. No </td>
    <td><strong>  <?=$emp[0]['enrollment_no']?></strong> </td>
  </tr>
  <tr>
    <td> Name Of The Candidate</td>
    <td><strong><?=strtoupper($emp[0]['last_name'].' '.$emp[0]['first_name'].' '.$emp[0]['middle_name']);?></strong></td>
  </tr>
  <tr>
    <td>School </td>
     <td><strong><?=$emp[0]['school_name']?> (<?=$emp[0]['school_code']?>)</strong></td>    
  </tr>
  <tr>
    <td>Programme </td>
    <td><strong><?=$emp[0]['stream_name']?></strong></td>
  </tr>
  <tr>
    <td>Semester/Year</td>
    <td> <strong><?=$emp[0]['current_semester']?>/<?=$emp[0]['current_year']?></strong></td>
  </tr>
  <tr>
    <td>Batch</td>
    <td><strong><?=$emp[0]['admission_session']?></strong></td>
  </tr>

</table>
<br /><br />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="detail-table">
  <tr>
    <td colspan="6" align="center"><!--strong>Photocopy  of Answer Script   : Rs. 500/- for each  course</strong><br /-->
      <strong><?=$reportName?>  of Answer Script: Rs. 500/- for each course</strong></td>
    </tr>
  <tr>
    <th width="3%">Sem</th>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>CIA</th>
	<!--th>EXT Marks</th>
	<th>Final Grade</th-->
    <th><?=ucfirst($reportName);?></th>
    <th>Fees (In Rs.)</th>
  </tr>
  <?php
	$i=1;
	if(!empty($sublist)){
		foreach($sublist as $sub){
		?>
  <tr>
    <td align="center"><?=$sub['semester']?></td>
    <td align="center"><?=$sub['subject_code']?></td>
    <td><?=$sub['subject_name']?></td>
    <td><?=$sub['cia_marks']?></td>
	<!--td><?=$sub['exam_marks']?></td>
	<td><?=$sub['final_grade']?></td-->
    <td align="center"><?=$reportName?></td>
    <td>500/-</td>
  </tr>
  <?php 
	$i++;
	}
	}else{
		echo "<tr><td colspan=8>No data found.</td></tr>";
	}
	?>
  <tr>
  <td colspan="3" align="left" height="50" valign="bottom"><strong>No. Of subject appeared::</strong> <?php if(!empty($sublist)){ echo count($sublist);}?></td>
    <td colspan="3" align="right" height="50" valign="bottom"><strong>Total Amount:</strong>
	<?php 
	if($reval==0){ 
		if(!empty($sublist[0]['photocopy_fees'])){ 
			echo $sublist[0]['photocopy_fees'].'/';
		}
	}else{ 
		if(!empty($sublist[0]['reval_fees'])){ 
			echo $sublist[0]['reval_fees'].'/';
		}
	}?>
	</td>
    </tr>
	<tr>
    <td colspan="6" align="left"><p style="padding-bottom:10px!important;"><b>Subject Handling Faculty Affirmation(Please Tick)</b></p>

<ol><li style="padding-bottom:10px!important;">Finds that any answer(s) to question(s) that has/ have not been evaluated</li>
<li>Finds that the answer-script valuation in full or part is not justified and there is reasonable ground for revaluation.</li></ol></td>
    </tr>
  <tr>
    <td colspan="6" align="center"><em>The above particulars are verified and found to be correct.</em></td>
    </tr>
</table>

<table width="100%" border="1" cellspacing="0" cellpadding="0" class="detail-table">
  <tr>
    <td>&nbsp;</td>
    <td align="center" height="80" valign="top"><em>Forwarded</em></td>
    <td colspan="2" align="center" height="80" valign="top"><em>Recommended & Forwarded</em></td>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td align="center">Signature of the Candidate</td>
    <td align="center">Name  &amp; Signature of the Faculty Advisor with date</td>
    <td colspan="2" align="center">Signature  of the Head of the Department with Date</td>
    <td colspan="2" align="center">Signature of the Dean</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
<td height="30" valign="bottom" width="22%"><br><br>Payment By : </td>
<td style="border-bottom:2px dotted #000;" height="30" valign="bottom">DD / CHQ/ POS&nbsp;</td>

  </tr>
  <tr>
  <td valign="bottom" height="30">DD/CHQ/POS Ref No. <strong>:</strong></td>
  <td style="border-bottom:2px dotted #000;" height="30" valign="bottom">&nbsp;</td>
  </tr>
  <tr>
  <td  valign="bottom" height="30">Payment Paid <strong>:</strong></td>
  <td style="border-bottom:2px dotted #000;" height="30" valign="bottom">&nbsp;</td>
  </tr>
  <tr>
  <td valign="bottom" height="30">Paid Date <strong>:</strong></td>
  <td style="border-bottom:2px dotted #000;" height="30" valign="bottom">&nbsp;</td>
  </tr>
  <tr>
  <td valign="bottom" height="30">Bank & Branch <strong>:</strong></td>
  <td style="border-bottom:2px dotted #000;" height="30" valign="bottom">&nbsp;</td>
  </tr>
  <tr>
  <td align="right" class="space" colspan="2">Accounts Dept. </tr>
  </tr>
</table>
</div>

<div style="align:center;border:5px double #000;padding:10px;height:1200px!important;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><p><strong>For office use only</strong></p></td>
  </tr>
</table>


<table width="100%" border="1" cellspacing="0" cellpadding="0" class="detail-table">
 <tr>
    <th width="3%">Sem</th>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Marks Obtained</th>
    <th >Issued / Evaluated by</th>
    <th>Marks After</th>
  </tr>
  <?php
  $i=1;
  if(!empty($sublist)){
    foreach($sublist as $sub){
    ?>
  <tr>
    <td align="center"><?=$sub['semester']?></td>
    <td align="center"><?=$sub['subject_code']?></td>
    <td><?=$sub['subject_name']?></td>
    <td align="center"></td>
  <!--td><?=$sub['exam_marks']?></td>
  <td><?=$sub['final_grade']?></td-->
    <td align="center"></td>
    <td></td>
  </tr>
  <?php 
  $i++;
  }
  }else{
    echo "<tr><td colspan=8>No data found.</td></tr>";
  }
  ?>
  

</table>
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="space">
<tr>
    <td colspan="2" height="100"><p>Evaluated  by</p></td>	 
  </tr>
  <tr>
    <td colspan="2" height="150"><p>Verified  by</p></td>	 
  </tr>
  <tr>
    <td height="150"><p>DCOE / ACOE</p> </td>
	<td><p align="center">COE</p></td>
   
  </tr>
</table>

</div>
</body>
</html>
