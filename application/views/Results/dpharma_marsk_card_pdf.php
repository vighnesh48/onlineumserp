<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Statement of Grades</title>
<style>

body{font-family:Arial, Helvetica, sans-serif;font-size:10px;
}
.details-table th{border:1px solid #000;}
.details-table td{border-right:1px solid #000;border-left:1px solid #000;padding-left:8px;border-bottom:1px solid #000;}
.head-table td{padding-left:4px;border:1px solid #000;line-height:7px;}

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
 function array_count_values_of($value, $array) {
    $counts = array_count_values($array);
    return $counts[$value];
}
$CI =& get_instance();
$CI->load->model('Marks_model');
$CI->load->model('Results_model');
 $i=0;
//var_dump($stud_data);
// exit();
 //echo "<pre>";
 //echo $stud_data[1]['exam_master_id'];
 //print_r($exam_master_id);
 //exit;
 $sum_max_marks=array();
 $sum_obt_marks=array();
 foreach($stud_data as $stud){	 
  $studcredits =$this->Marks_model->fetch_credits_earned($stud[0]['enrollment_no'], $stud[0]['exam_id']);
// print_r($studcredits);

//exit();

 ?>
<div style="height:842px;xmargin-bottom:170px;xxbackground:#ddd;">

<table cellpadding="0" cellspacing="0" border="0" valign="top" width="800">
            <tr>
			<td  align="center" width="100" style="text-align:center;margin-left:15px;"><img src="<?=base_url()?>uploads/gradesheet/<?=$stud[0]['exam_month']?><?=$stud[0]['exam_year']?>/QRCode/qrcode_<?=$exam_master_id[$i]?>.png" class="pull-right" style="margin:2px;float:right;"></td>
			<td style="font-weight:normal;text-align:center;">
			</td>
			<td width="120" align="right" valign="middle" style="text-align:center;padding-top:20px;">
			</td>
			</tr>   
			<!--tr>
			<td height='25'></td>
			</tr>
			<tr>
				<td align="center" colspan=3><strong style="font-size:15px;border:2px solid #000;padding:2px;">STATEMENT OF MARKS</strong></td>
			</tr>
			<tr>
			<td height='20'></td>
			</tr-->
</table>
<div style="width:100%;text-align:center;margin-top:55px;">
	<div style="font-size:15px;text-align:center;align:center;border:2px solid #000;padding:3px 3px 3px 3px; margin-left:37%;width:25%"><b>STATEMENT OF MARKS</b></div>
</div>
<!--table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center"><strong>STATEMENT OF MARKS</strong></td>
	</tr>
	<tr>
		<td height='10'></td>
	</tr>
</table-->
<div style="width:100%;height:620px;border:1px solid #000;overflow: hidden;margin-top:10px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="head-table" style="xborder:2px solid #000">
   <tr>
    <td width="15%"><strong>PROGRAMME</strong></td>
    <td align="left"><?=strtoupper($stud[0]['gradesheet_name']);?></td>
    <td width="7%"><strong>SPECIALIZATION</strong></td>
    <td align="left" colspan=3><?php if($stud[0]['specialization']!=NULL){echo strtoupper($stud[0]['specialization']);}else{echo "--";}?></td>
    <td width="15%"><strong>REGULATIONS</strong></td>
    <td width="5%">2017<?php //echo $stud[0]['admission_session'];?></td>
    <?php
        $bucket_key = 'uploads/student_photo/'.$stud[0]['enrollment_no'].'.jpg';
        $imageData = $this->awssdk->getImageData($bucket_key);
    ?>
	<td rowspan="4" style="padding:0;"><center><img src="<?= $imageData ?>" width="80" height="100"/></center></td>
    </tr>

    <tr>
    <td><strong>NAME OF THE CANDIDATE</strong></td>
    <td width="15%" align="left"><?=$stud[0]['stud_name']?></td>
	 <td width="7%"><strong>MOTHER'S NAME</strong></td>
    <td align="left" colspan=3><?php echo strtoupper($stud[0]['mother_name']);?></td>
    <td><strong>PRN</strong></td>
    <td width="5%"><?=$stud[0]['enrollment_no']?></td>
    </tr>
  <tr>
    <td><strong>DATE OF BIRTH </strong>(DD-MM-YYYY)</td>
    <td width="15%" align="left"><?=$stud[0]['dob']?></td>
    <td width="7%"><strong>GENDER</strong></td>
    <td align="left" colspan=3><?php if($stud[0]['gender']=='M'){echo "MALE";}else{echo "FEMALE";}?></td>
    <td><strong>MONTH &amp; YEAR OF EXAMINATION</strong></td>
    <td width="5%"><?=$stud[0]['exam_month']?>-<?=$stud[0]['exam_year']?></td>
    </tr>


</table>

<table width="100%"  border="0" cellspacing="0" cellpadding="3" class="details-table" style="xborder:2px solid #000">
  <tr>
    <th width="5%">YEAR</th>
    <th width="10%">COURSE CODE</th>
    <th align="left">NAME OF THE COURSE</th>
	<th width="8%">COURSE HEAD</th>
    <th width="8%">MAX MARKS</th>
    <th width="8%">MIN MARKS</th>
    <th width="8%">MARKS OBTAINED</th>
	<th width="8%">TOTAL</th>
    <th width="10%">RESULT</th>
  </tr>
  <?php 
	foreach($stud as $val ){
		$subdet =$this->Results_model->fetchsubject_details($val['sub_id']);
		$sum_max_marks[] = $subdet[0]['theory_max'] + $subdet[0]['internal_max'] + $subdet[0]['practical_max'];
		$sum_obt_marks[] = $val['final_garde_marks'];
		
//print_r($val['subject_code']);
	if($val['final_grade']=='U' || $val['final_grade']=='W' || $val['final_grade'] =='WH'){
		$grade = "RA";
	}else{
		$grade = "PASS";
	}
	$arr_final_grade[]= $grade;
	if($val['subject_component']=='TH'){
		$sub_type1 = 'TH';
		$sub_type2 = 'INT';
		$max_marks= $subdet[0]['theory_max'];
		$min_marks = $subdet[0]['theory_min_for_pass'];
	}else{
		$sub_type1 = 'PR';
		$sub_type2 = 'INT';
		$max_marks= $subdet[0]['practical_max'];
		$min_marks = $subdet[0]['practical_min_for_pass'];
	}
	$sub_type3='TOT';
	//$cumulative_gpa[] = $val['credits_earned'];
	if (empty($val['reval_marks'])){
		$exam_marks=$val['exam_marks'];
	}else{
		$exam_marks=round($val['reval_marks']);
	}
	?>
  <tr>
    <td align="center" rowspan="2"><?=$val['semester'];?></td>
    <td align="center"  rowspan="2"><?=strtoupper($val['subject_code']);?></td>
    <td rowspan="2"><?=strtoupper($val['subject_name']);?> <?=$subject_category;?></td>
	<td align="center"><?=$sub_type1?></td>
    <td align="center"><?=$max_marks;?></td>
    <td align="center"><?=$min_marks;?></td>
    <td align="center"><?=$exam_marks?></td>
	<td rowspan="2" align="center"><?=$exam_marks+$val['cia_marks'];?></td>
    <td rowspan="2" align="center"><?=$grade?></td>
  </tr>
  <tr>
	<td align="center"><?=$sub_type2?></td>
    <td align="center"><?=$subdet[0]['internal_max'];?></td>
    <td align="center"><?=$subdet[0]['internal_min_for_pass'];?></td>
	<td align="center"><?=$val['cia_marks'];?></td>
  </tr>
    <!--tr>
	<td align="center"><?=$sub_type3?></td>
    <td align="center"><?=$subdet[0]['theory_max']+ $subdet[0]['internal_max'];?></td>
    <td align="center"><?=$subdet[0]['theory_min_for_pass']+$subdet[0]['internal_min_for_pass'];?></td>
	<td align="center"><?=$val['exam_marks']+$val['cia_marks'];?></td>
  </tr-->
  <?php
  
 }
  ?>

  <!--tr>
    <td align="right" colspan="5">Total Max Marks: <?=array_sum($sum_max_marks);?></td><td colspan="3">Total Marks Obtained: <?=array_sum($sum_obt_marks);?></td>
  </tr-->
  <?php 
	/*$percentage =array_sum($sum_obt_marks)/array_sum($sum_max_marks)*100;
	unset($sum_obt_marks);
	unset($sum_max_marks);
	//$percentage ='87.999';
    $percentage1 = number_format((float)$percentage, 3, '.', '');
	$per = explode('.', $percentage1);
	$last_char = substr($per[1], -1);
	if($last_char >=5){
		$f_two_char = substr($per[1],0, 2);
		$dec_inc = $f_two_char+1;
		
		if($per[1]=='999'){
			$percentage_inc = $per[0]+1;
			$perctage = $percentage_inc.'.00';
		}else{
			$perctage = $per[0].'.'.$dec_inc;
		}
	}else{
		$perctage =number_format((float)$percentage, 2, '.', '');
	}
  */
  ?>
  <?php if(!in_array('RA', $arr_final_grade)){?>
  <!--tr>
    <td align="center" colspan="8" >Percentage: <?=$perctage?></td>
  </tr-->
  <?php }else{ } 
  ?>
 
</table>
    <table width="100%"  border="0" cellspacing="0" cellpadding="2" class="details-table" style="xborder:2px solid #000">
	<tr>
		<td align="center">YEAR</td>
		<td align="center">TOTAL MARKS</td>
		<td align="center">TOTAL MARKS OBTAINED</td>
		<td align="center">PERCENTAGE</td>
		<td align="center">Class</td>
	</tr>

	<?php 
	$stud_year = $this->Results_model->fetch_student_result_dpharma($stud[0]['stud_id'], $stream_df_id,$exam_df_id);
	
	
	foreach($stud_year as $res){ 
	
		$subdet =$this->Results_model->fetchDpharmaresult_details($res['student_id'],$res['stream_id'],$res['semester'], $exam_df_id);
		// echo '<pre>';
		// print_r($subdet);exit;
		$f_grade =$this->Results_model->fetchDpharmaresult_grades($res['student_id'],$res['stream_id'],$res['semester'], $exam_df_id);
		$cls_pharma =$this->Results_model->fetchDpharma_no_of_attempt($res['student_id'],$res['stream_id'],$res['semester'], $exam_df_id);
		$course_total =$this->Results_model->fetchDpharma_course_total($res['student_id'],$res['stream_id'],$res['semester'], $exam_df_id);
		foreach($f_grade as $res13){

			$fnal_exam_grade[] = $res13['final_grade'];
		}

			$arr_grade =array_merge($fnal_exam_grade,$arr_grade);
			$no_of_bk1 = array_count_values($arr_grade);
			if(empty($no_of_bk1['U'])){
				$no_of_bk =0;
			}else{
				$no_of_bk =$no_of_bk1['U'];//exit;
			}
		
	?>
<?php foreach($subdet as $resdata){?>
	<tr>
		<td align="center"><?=$resdata['semester']?></td>
		<td align="center"><?php if(!empty($resdata['credits_registered'])){ echo $resdata['credits_registered'];}else{ echo '-';}?></td>
		<td align="center"><?php if(!empty($resdata['credits_earned'])){ echo $resdata['credits_earned'];}else{ echo '-';}?></td>
		<td align="center"><?php if(!in_array('U', $arr_grade)){ echo $resdata['sgpa']; }else{ echo '--';}?></td>
		<td align="center"><?=$resdata['dpharma_class']?></td>
	</tr>
	<?php 
}
	   
		
		//}
		//print_r($pass_arr);
			//print_r($fail_arr[8]);
		unset($f_grade);
		unset($pass_arr);
		unset($fnal_exam_grade);
		unset($fail_arr);
		unset($no_of_bk);
		unset($arr_grade);
		unset($tot_mrks);
		unset($obt_mrks);
		unset($final_array);
		}
//exit;
		?>
		<tr>
    <td align="center" colspan="4" style="border:0px" border="0">*** END OF STATEMENT ***</td>
  </tr>
  </table>
</div>
<table width="100%" border="" cellspacing="0" cellpadding="0" class="head-table" style="border:2px solid #000">
	<tr>
    <td colspan=11><strong>PRN</strong>-Permanent Registration Number,
    &nbsp;&nbsp;&nbsp;<strong>TH</strong>-Theory, &nbsp;&nbsp;&nbsp;<strong>INT</strong>-Internal, &nbsp;&nbsp;&nbsp;<strong>PR</strong>-Practical, &nbsp;&nbsp;&nbsp;<strong>RA</strong>-Reappearance</td>
    </tr>

</table>

</div>
	 <?php $i++;
	 
//var_dump($stud[0]);
// exit();
	 
	  unset($studcredits[0]['credits_earned']);
	 }?>
</body>
</html>
