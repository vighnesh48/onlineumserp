<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Statement of Grades</title>
<style>

body{font-family:Arial, Helvetica, sans-serif;font-size:11px;
}
.details-table th{border:1px solid #000;}
.details-table td{border-right:1px solid #000;border-left:1px solid #000;padding-left:8px;border-bottom:1px solid #000;}
.head-table td{padding-left:4px;border:1px solid #000;line-height:10px;}

.bg{
	background-image: url("markscard.png");
background-position: center;
background-repeat: no-repeat;
background-size: auto;
}
</style>
</head>

<body>

 <?php 
$CI =& get_instance();
$CI->load->model('Marks_model');
$CI->load->model('Results_model');
 $i=0;
//print_r($stud_data[0]);
// exit();
 //echo "<pre>";
 //echo $stud_data[1]['exam_master_id'];
 //print_r($exam_master_id);
 //exit;
//echo $stud_data['enrollment_no'];
 foreach($stud_data[0] as $stud){	 
 //echo ($stud['enrollment_no']);echo '<br>';
 //echo ($stud['exam_id']);
  $studcredits =$CI->Marks_model->fetch_credits_earned($stud['enrollment_no'], $stud['exam_id']);
  //print_r($studcredits);
  $arr_bklog_sems =$CI->Results_model->fetch_backlog_semesters($stud['enrollment_no']);
  
  //echo '<br>';
  // print_r($arr_bklog_sems);
  //exit;
  foreach($arr_bklog_sems as $sem){
	 $arr_sems[] = $sem['semester'];  
  }
 //print_r($arr_sems);

//exit();

 ?>
<div style="height:842px;xmargin-bottom:170px;xxbackground:#ddd;">

<table cellpadding="0" cellspacing="0" border="0" valign="top" width="800">
            <tr>
			<td  align="center" width="100" style="text-align:center;margin-left:15px;"><img src="<?=base_url()?>uploads/gradesheet/<?=$stud['exam_month']?><?=$stud['exam_year']?>/QRCode/qrcode_<?=$exam_master_id[$i]?>.png" class="pull-right" style="margin:2px;float:right;"></td>
			<td style="font-weight:normal;text-align:center;">
			</td>
			<td width="120" align="right" valign="middle" style="text-align:center;padding-top:20px;">
			</td>
			</tr>   
			<tr>
			<td height='90'></td>
			</tr>
</table>
<div style="width:100%;height:620px;border:1px solid #000;overflow: hidden;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="head-table" style="xborder:2px solid #000">

   <tr>
    <td width="15%"><strong>PROGRAMME</strong></td>
    <td align="left"><?=strtoupper($stud['gradesheet_name']);?></td>
    <td width="7%"><strong>SPECIALIZATION</strong></td>
    <td align="left" colspan=3><?php if($stud['specialization']!=NULL){echo strtoupper($stud['specialization']);}else{echo "--";}?></td>
    <td width="15%"><strong>REGULATIONS</strong></td>
    <td width="5%"><?=$stud['admission_session']?></td>
	<td rowspan="4" style="padding:0;"><center><img src="https://erp.sandipuniversity.com/uploads/student_photo/<?=$stud['enrollment_no']?>.jpg" width="80" height="100"/></center></td>
    </tr>

    <tr>
    <td><strong>NAME OF THE CANDIDATE</strong></td>
    <td width="15%" align="left"><?=$stud['stud_name']?></td>
	 <td width="7%"><strong>MOTHER'S NAME</strong></td>
    <td align="left" colspan=3><?php echo strtoupper($stud['mother_name']);?></td>
    <td><strong>PRN</strong></td>
    <td width="5%"><?=$stud['enrollment_no']?></td>
    </tr>
  <tr>
    <td><strong>DATE OF BIRTH </strong>(DD-MM-YYYY)</td>
    <td width="15%" align="left"><?=$stud['dob']?></td>
    <td width="7%"><strong>GENDER</strong></td>
    <td align="left" colspan=3><?php if($stud['gender']=='M'){echo "MALE";}else{echo "FEMALE";}?></td>
    <td><strong>MONTH &amp; YEAR OF EXAMINATION</strong></td>
    <td width="5%"><?=$stud['exam_month']?>-<?=$stud['exam_year']?></td>
    </tr>


</table>

<table width="100%"  border="0" cellspacing="5" cellpadding="5" class="details-table" style="xborder:2px solid #000">
  <tr>
    <th width="5%">SEM NO</th>
    <th width="10%">COURSE CODE</th>
    <th align="left">NAME OF THE COURSE</th>
	<th width="8%">ATTENDANCE GRADE</th>
    <th width="8%">CREDITS</th>
    <th width="8%">LETTER GRADE</th>
    <th width="8%">GRADE POINT</th>
    <th width="10%">RESULT</th>
  </tr>
  <?php 
	foreach($stud as $val ){
//print_r($val['subject_code']);
	if($val['final_grade']=='U' || $val['final_grade']=='W' || $val['final_grade'] =='WH'){
		$grade = "RA";
	}else{
		$grade = "PASS";
	}
	if($val['final_grade']=='O'){
		$grade_points = 10;
	}elseif($val['final_grade']=='A+'){
		$grade_points = 9;
	}elseif($val['final_grade']=='A'){
		$grade_points = 8;
	}elseif($val['final_grade']=='B+'){
		$grade_points = 7;
	}elseif($val['final_grade']=='B'){
		$grade_points = 6;
	}elseif($val['final_grade']=='C+'){
		$grade_points = 5;
	}elseif($val['final_grade']=='C'){
		$grade_points = 4;
	}elseif($val['final_grade']=='U' || $val['final_grade']=='W'){
		$grade_points = 0;
	}else{
		$grade_points = 0;
	}
	if($val['subject_category']=='NCR'){
		$subject_category = '*';
	}elseif($val['subject_category']=='MNR'){
		$subject_category = '**';
	}elseif($val['subject_category']=='ADL'){
		$subject_category = '***';
	}elseif($val['subject_category']=='URE'){
		$subject_category = '****';
	}else{
		$subject_category='';
	}
	
	//$cumulative_gpa[] = $val['credits_earned'];
	
	?>
  <tr>
    <td align="center"><?=$val['semester'];?></td>
    <td align="center"><?=strtoupper($val['subject_code']);?></td>
    <td><?=strtoupper($val['subject_name']);?> <?=$subject_category;?></td>
	<td align="center"><?=$val['attendance_grade'];?></td>
    <td align="center"><?=$val['credits'];?></td>
    <td align="center"><?=$val['final_grade'];?></td>
    <td align="center"><?=$grade_points;?></td>
    <td align="center"><?=$grade;?></td>
  </tr>
  <?php
  
 }
  ?>
 <tr>
    <td align="center" colspan="8" style="border:0px" border="0">*** END OF STATEMENT ***</td>
  </tr>
</table>
</div>
<table width="100%" border="" cellspacing="0" cellpadding="0" class="head-table" style="border:2px solid #000">
  <tr>
    <td width="27%"><strong>Semester</strong></td>
    <td align="center" width="8%"><strong>I</strong></td>
    <td align="center" width="8%"><strong>II</strong></td>
    <td align="center" width="7%"><strong>III</strong></td>
    <td align="center" width="7%"><strong>IV</strong></td>
    <td align="center" width="8%"><strong>V</strong></td>
    <td align="center" width="8%"><strong>VI</strong></td>
    <td align="center" width="7%"><strong>VII</strong></td>
    <td align="center" width="7%"><strong>VIII</strong></td>
	<td align="center" width="7%"><strong>IX</strong></td>
    <td align="center" width="7%"><strong>X</strong></td>
  </tr>
  <tr>
    <td><strong>Credits Registered</strong>
    <?php
	//echo "<pre>";
   //var_dump($stud['grades']);exit;
    ?>
    </td>
    <td align="center"><?php echo $stud["grades"][1]['credits_registered'];//if($stud['semester']==1){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][2]['credits_registered'];//if($stud['semester']==2){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][3]['credits_registered']//if($stud['semester']==3){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][4]['credits_registered'];//if($stud['semester']==4){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][5]['credits_registered'];//if($stud['semester']==5){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][6]['credits_registered'];//if($stud['semester']==6){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][7]['credits_registered'];//if($stud['semester']==7){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][8]['credits_registered'];//if($stud['semester']==8){ echo $stud['credits_registered'];}?></td>
	<td align="center"><?php echo $stud["grades"][9]['credits_registered'];//if($stud['semester']==9){ echo $stud['credits_registered'];}?></td>
	<td align="center"><?php echo $stud["grades"][10]['credits_registered'];//if($stud['semester']==10){ echo $stud['credits_registered'];}?></td>
  </tr>
  <tr>
    <td><strong>Credits Earned</strong></td>
    <td align="center"><?php echo $stud["grades"][1]['credits_earned'];//if($stud['semester']==1){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][2]['credits_earned'];//if($stud['semester']==2){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][3]['credits_earned']//if($stud['semester']==3){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][4]['credits_earned'];//if($stud['semester']==4){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][5]['credits_earned'];//if($stud['semester']==5){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][6]['credits_earned'];//if($stud['semester']==6){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][7]['credits_earned'];//if($stud['semester']==7){ echo $stud['credits_registered'];}?></td>
    <td align="center"><?php echo $stud["grades"][8]['credits_earned'];//if($stud['semester']==8){ echo $stud['credits_registered'];}?></td>
	<td align="center"><?php echo $stud["grades"][9]['credits_earned'];//if($stud['semester']==9){ echo $stud['credits_registered'];}?></td>
	<td align="center"><?php echo $stud["grades"][10]['credits_earned'];//if($stud['semester']==10){ echo $stud['credits_registered'];}?></td>
  </tr>
  <!--tr>
    <td><strong>Grade Points Earned</strong></td>
	<td align="center"><?php if($stud['semester']==1){ echo $stud['grade_points_earned'];}?></td>
    <td align="center"><?php if($stud['semester']==2){ echo $stud['grade_points_earned'];}?></td>
    <td align="center"><?php if($stud['semester']==3){ echo $stud['grade_points_earned'];}?></td>
    <td align="center"><?php if($stud['semester']==4){ echo $stud['grade_points_earned'];}?></td>
    <td align="center"><?php if($stud['semester']==5){ echo $stud['grade_points_earned'];}?></td>
    <td align="center"><?php if($stud['semester']==6){ echo $stud['grade_points_earned'];}?></td>
    <td align="center"><?php if($stud['semester']==7){ echo $stud['grade_points_earned'];}?></td>
    <td align="center"><?php if($stud['semester']==8){ echo $stud['grade_points_earned'];}?></td>
	<td align="center"><?php if($stud['semester']==9){ echo $stud['grade_points_earned'];}?></td>
    <td align="center"><?php if($stud['semester']==10){ echo $stud['grade_points_earned'];}?></td>
	
  </tr-->
  <tr>
    <td><strong>Grade Points Average(GPA)</strong></td>
	<td align="center"><?php if(in_array('1', $arr_sems)){}else{ echo $stud["grades"][1]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('2', $arr_sems)){}else{ echo $stud["grades"][2]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('3', $arr_sems)){}else{ echo $stud["grades"][3]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('4', $arr_sems)){}else{ echo $stud["grades"][4]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('5', $arr_sems)){}else{ echo $stud["grades"][5]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('6', $arr_sems)){}else{ echo $stud["grades"][6]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('7', $arr_sems)){}else{ echo $stud["grades"][7]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('8', $arr_sems)){}else{ echo $stud["grades"][8]['sgpa'];}?></td>
	<td align="center"><?php if(in_array('9', $arr_sems)){}else{ echo $stud["grades"][9]['sgpa'];}?></td>
	<td align="center"><?php if(in_array('10', $arr_sems)){}else{ echo $stud["grades"][10]['sgpa'];}?></td>
  </tr>
  <tr>
    <td><strong>Cumulative Credits Earned</strong></td>
    <td align="center"><?=$studcredits[0]['credits_earned'];?></td>
    <td colspan="6" align="center"><strong>Cumulative Grade Point Average(CGPA)</strong></td>
    <td align="center" colspan=3><?php if(empty($arr_sems)){ echo number_format($stud['cumulative_gpa'], 2); }?></td>
    </tr>
	<tr>
    <td colspan=11><strong>RA</strong>-Reappearance, &nbsp;&nbsp;&nbsp;<strong>W</strong>-Withdrawal,&nbsp;&nbsp;&nbsp; <strong>PRN</strong>-Permanent Registration Number,
    &nbsp;&nbsp;&nbsp;<strong>*</strong>-Non Credit(Mandatory), &nbsp;&nbsp;&nbsp;<strong>**</strong>-Minors(Optional), &nbsp;&nbsp;&nbsp;<br><strong>***</strong>-Open Electives(Optional),&nbsp;&nbsp;&nbsp;
    <strong>****</strong>-University Research Experience(Optional)</td>
    </tr>

</table>

</div>
	 <?php $i++;
	 
//var_dump($stud);
// exit();
	 
	  unset($studcredits[0]['credits_earned']);
	 }?>
</body>
</html>
