<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style>
body{font-family: arial, sans-serif}
table {
    border-collapse: collapse;
}
table tr th{font-size:12px;padding:5px;}
table tr td{font-size:13px;padding:5px;height:20px;}
</style>
</head>

<body>
    <?php
    
 // var_dump($students);
    ?>
<div style="width:100%;height:950px;margin:0 auto;overflow:hidden;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="22%" valign="bottom"><strong>Reg. No:</strong> <?= $students[0]['prov_reg_no'] ?></td>
    <td align="center">
    <img src="<?= base_url() ?>assets/images/logo-7.png" width="200">
    <p style="padding:0;margin:0px;">Mahiravani, Trimbak Road, Nashik – 422 213</p>
    <h3 style="font-size:18px;">Registration Form : 2019-20</h3>
    </td>
    <td width="22%" align="right" valign="bottom"><strong></strong><br>
    <strong>Date : </strong><?= $students[0]['doa'] ?>
    </td>
  </tr>
</table>

<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td height="18" colspan="2"><strong>School Name: </strong><?= $students[0]['school_name']?></td>
    </tr>
  <tr>
    <td><strong>Course : </strong><?= $students[0]['sprogramm_name']?></td>
    <td><strong>Year : </strong><?= $students[0]['admission_year']?>  </td>
  </tr>
</table>
              
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4" align="center" style="margin:0;padding:0;font-size:18px;background:#ddd;line-height:25px;"><strong>Personal Details</strong></td>
    </tr>
  <tr>
    <td colspan="4"><strong>Student Name: </strong><?= $students[0]['student_name']?></td>
    </tr>
  <tr>
    <td colspan="4"><strong>Address : </strong><?= $students[0]['address']?>,<?= $students[0]['landmark']?></td>
    </tr>
  <tr>
    <td colspan="2"><strong>State:</strong><?= $students[0]['state_name']?></td>
    <td><strong>City:</strong><?= $students[0]['city_name']?></td>
    <td><strong>Pincode:</strong><?= $students[0]['pincode']?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Mobile 1:</strong><?= $students[0]['mobile1']?></td>
    <td colspan="2"><strong>Sex:</strong><?= $students[0]['gender']?></td>
    </tr>
  <tr>
    <td colspan="2"><strong>Mobile 2:</strong><?= $students[0]['mobile2']?></td>
    <td colspan="2"><strong>DOB:</strong><?= date('d-m-Y', strtotime(str_replace("/","-",$students[0]['dob'])))?></td>
    </tr>
  <tr>
    <td colspan="2"><strong>Landline:</strong></td>
    <td colspan="2"><strong>Annual Income:</strong></td>
    </tr>
  <tr>
    <td colspan="2"><strong>Email Id: </strong><?= $students[0]['email']?></td>
    <td colspan="2"><strong>Parents Occupation:</strong></td>
    </tr>
  <tr>
    <td colspan="2"><strong>Adhaar Card No:</strong><?= $students[0]['adhar_no']?></td>
    <td colspan="2"><strong>Blood Group:</strong></td>
    </tr>
  <tr>
    <td><strong>Religion:</strong></td>
    <td><strong>Caste:</strong></td>
    <td><strong>Sub Caste:</strong></td>
    <td><strong>Category:</strong></td>
  </tr>
  <tr>
    <td colspan="4"><strong>Candidate from Maharashtra State / Out of Maharashtra State: </strong></td>
    </tr>
</table>

<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4" style="margin:0;padding:0;font-size:18px;background:#ddd;line-height:25px;" align="center"><strong>Entrance Exam Details</strong></td>
    </tr>
  <tr>
    <th>SUJEE-2019</th>
    <th>SUJEE Score(Out of 200)</th>
    <th>Other Entrance Exam</th>
    <th>Score</th>
 
  </tr>
    <tr>
    <td align="center"><?php if($students[0]['sujee_regno']!=''){echo $students[0]['sujee_regno']; }  ?></td>
    <td><?php if($students[0]['sujee_regno']!=''){echo $students[0]['sujee_score']; }  ?></td>
    <td><?php if($students[0]['other_exam_name']!=''){echo $students[0]['other_exam_name']; }  ?></td>
    <td><?php if($students[0]['other_exam_name']!=''){echo $students[0]['other_exam_score']; }  ?></td>
 
  </tr>
  
  </table>
  
<?php
$ssc = array_search('SSC', array_column($academics, 'qualification'));

$hsc = array_search('HSC', array_column($academics, 'qualification'));


$dip = array_search('Diploma', array_column($academics, 'qualification'));

$grad = array_search('Graduation', array_column($academics, 'qualification'));
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="7" style="margin:0;padding:0;font-size:18px;background:#ddd;line-height:25px;" align="center"><strong>Education Qualification</strong></td>
    </tr>
  <tr>
    <th>Sr No.</th>
    <th>Degree</th>
    <th>Stream</th>
    <th>Board</th>
    <th>Pass Year</th>
    <th>Percentage</th>
    <th>Class</th>
  </tr>
  <tr>
    <td align="center">1</td>
    <td>SSC</td>
    <td><?=$academics[$ssc]['specialization']?></td>
    <td><?=$academics[$ssc]['board_name']?></td>
    <td><?=$academics[$ssc]['pass_year']?></td>
    <td><?=$academics[$ssc]['percentage']?></td>
    <td><?=$academics[$ssc]['class']?></td>
  </tr>
  <tr>
    <td align="center">2</td>
    <td>HSC</td>
     <td><?php if($hsc!=''){echo $academics[$hsc]['specialization'];}?></td>
    <td><?php if($hsc!=''){echo $academics[$hsc]['board_name'];}?></td>
    <td><?php if($hsc!=''){echo $academics[$hsc]['pass_year'];}?></td>
    <td><?php if($hsc!=''){echo $academics[$hsc]['percentage'];}?></td>
    <td><?php if($hsc!=''){echo $academics[$hsc]['class'];}?></td>
  </tr>
  <tr>
    <td align="center">3</td>
    <td>DIPLOMA</td>
    <td><?php if($dip!=''){echo $academics[$dip]['specialization'];}?></td>
    <td><?php if($dip!=''){echo $academics[$dip]['board_name'];}?></td>
    <td><?php if($dip!=''){echo $academics[$dip]['pass_year'];}?></td>
    <td><?php if($dip!=''){echo $academics[$dip]['percentage'];}?></td>
    <td><?php if($dip!=''){echo $academics[$dip]['class'];}?></td>
  </tr>
    <tr>
    <td align="center">4</td>
    <td>UG</td>
    <td><?php if($grad!=''){echo $academics[$grad]['specialization'];}?></td>
    <td><?php if($grad!=''){echo $academics[$grad]['board_name'];}?></td>
    <td><?php if($grad!=''){echo $academics[$grad]['pass_year'];}?></td>
    <td><?php if($grad!=''){echo $academics[$grad]['percentage'];}?></td>
    <td><?php if($grad!=''){echo $academics[$grad]['class'];}?></td>
  </tr>
   <tr>
    <td colspan="7"><strong>Last Appearing Institute (As Per LC/TC): </strong></td>
    </tr>
    <tr>
    <td height="18" colspan="2"><strong>Hostel (Y/N):</strong></td>
    <td colspan="2"><strong>Transport (Y/N):</strong></td>
    <td colspan="3"><strong>Pickup Point:</strong></td>
    </tr>
</table>

<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="10" style="margin:0;padding:0;font-size:18px;background:#ddd;line-height:25px;" align="center"><strong>How did you come to know about Sandip University?</strong></td>
    </tr>
<tr>
    <th>News Paper</th>
    <th>Hordings</th>
    <th>Friends</th>
    <th>TV Advt.</th>
    <th>Our Student</th>
    <th>Web Site</th>
    <th>Campus Visit</th>
    <th>Seminar</th>
    <th>SU-JEE Exam</th>
    <th>Others</th>
  </tr>
  <tr>
    <td>
       &nbsp;  <?php $know = explode(",",$students[0]['how_to_know']); if(in_array("2",$know)){echo "Y";} ?>
       </td>
    <td>&nbsp;<?php if(in_array("1",$know)){echo "Y";} ?></td>
    <td>&nbsp;<?php if(in_array("3",$know)){echo "Y";} ?></td>
    <td>&nbsp;<?php if(in_array("4",$know)){echo "Y";} ?></td>
    <td>&nbsp;<?php if(in_array("12",$know)){echo "Y";} ?></td>
    <td>&nbsp;<?php if(in_array("6",$know)){echo "Y";} ?></td>
    <td>&nbsp;<?php if(in_array("8",$know)){echo "Y";} ?></td>
    <td>&nbsp;<?php if(in_array("7",$know)){echo "Y";} ?></td>
    <td>&nbsp;<?php if(in_array("9",$know)){echo "Y";} ?></td>
    <td>&nbsp;<?php if(in_array("11",$know)){echo "Y";} ?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>I/We give acceptance to recieve messages & information form Sandip University on our Contact Nos. and e-mail account.</td>
  </tr>
  <tr>
    <td align="right"  valign="bottom" style="padding-top:100px"><strong>Signature of Candidate / Parent</strong></td>
  </tr>
</table>
</div>
<div style="width:100%;height:950px;margin:0 auto;overflow:hidden;">

<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" colspan="5">
    <h3 style="font-size:18px;margin:0;">Office Use Only</h3></td>
  </tr>
  <tr>
    <td  colspan="5" style="margin:0;padding:10px;font-size:15px;line-height:25px;background:#ddd;"><strong>Courses Fees Details</strong></td>
  </tr>
  <tr>
    <th>Program Fees</th>
    <th>Scholarship Fees</th>
    <th>Applicable</th>
    <th>Paid</th>
    <th>Balance</th>
  </tr>
  <tr>
    <td align="center"><?= $students[0]['actual_fees']?></td>
    <td align="center"><?= $students[0]['exemption_fees']?></td>
    <td align="center"><?= $students[0]['applicable_fees']?></td>
    <td align="center"><?=$fees[0]['amount']?></td>
    <td align="center"><?=$students[0]['applicable_fees']-$fees[0]['amount']?></td>
  </tr>
    <tr>
    <td colspan="5" align="left"><strong>Scholarship Applicable (if Any):</strong></td>
    </tr>
    <tr>
    <td colspan="5" align="left"><strong>Remark:</strong></td>
    </tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th>Sr.</th>
    <th>Reference Through </th>
    <th>Name</th>
    <th>Institute</th>
    <th>Remark</th>
  </tr>
  <tr>
    <td align="center">1</td>
    <td><strong>Staff</strong></td>
    <td><?php if($students[0]['admission_refer_by']=="STAFF"){echo $refer_by;}?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">2</td>
    <td><strong>Student</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">3</td>
    <td><strong>FOU</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">4</td>
    <td><strong>IC</strong></td>
    <td><?php if($students[0]['admission_refer_by']=="IC"){echo $refer_by;}?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">5</td>
    <td><strong>Knowledge Partner </strong></td>
    <td><?php if($students[0]['admission_refer_by']=="KP"){echo $refer_by;}?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">6</td>
    <td><strong>Any Other</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
    <tr>
    <td align="center"></td>
    <td><strong></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td align="center">Original Reference</td>
    <td><strong>  <?php echo $ref_type." >> ".$ref_id;?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th>Desk No</th>
    <th>Person Attendend</th>
    <th width="20%">Signature</th>
    <th width="25%">Remark</th>
  </tr>
  <tr>
    <td><strong>Desk-1 (ERP)</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Desk-2 (Counselling)</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Desk-3 (Admission Processing)</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Desk-4 (Eligibility)</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Desk-5 (Accounts)</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Desk-6 (Student Section)</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="7" style="margin:0;padding:10px;font-size:15px;line-height:25px;background:#ddd;"><strong>Payment Details</strong></td>
    </tr>
      <tr>
   <!-- <td colspan="5"><strong>Mode of Payment (DD/Cheque/POS/Online) :</strong></td>-->
    </tr>

  <tr>
      <th>Sr. No.</th>
       <th>Mode of Payment</th>
    <th>DD/CHQ/POS No.</th>
    <th>Amount</th>
    <th>Bank &amp; Branch</th>
    <th>Date</th>
    <th>Remark</th>
  </tr>
  <!--<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>-->
  <?php
  $i=1;
foreach($fees as $fees)
{
    
    if($fees['fees_paid_type']!='')
    {
?>
	 <tr><td><?=$i?></td><td><?=$fees['fees_paid_type']?></td><td><?=$fees['receipt_no']?></td><td><?=$fees['amount']?></td>
	<td><?php if($fees['fees_paid_type']=="CHLN"){}else{echo $fees['bank_name'].", ".$fees['bank_city']; } ?></td>
	 <td><?=$fees['fees_date']?></td>
	 	 <td></td>
	 </tr>
  <?php
  $i++;
} 

}
  ?>
  
  
  <tr>
       <td><?=$i?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
     <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong>Remark (Admission Dept) : </strong><?= $students[0]['admission_remark']?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="padding-top:140px" valign="bottom" align="right"><strong>Director (Admissions)</strong></td>
  </tr>
</table>

</div>
</body>
</html>
