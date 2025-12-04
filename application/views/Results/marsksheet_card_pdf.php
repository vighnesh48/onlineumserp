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
 
 $bklg_grade=array();
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

foreach($res_sem as $rsem){
	$ressem[]=$rsem['semester'];
}
//print_r($ressem);
$sem_res= implode(",",$ressem);//exit;
 
 foreach($stud_data as $stud){	
	//echo $stud[0]['enrollment_no'];echo"Inside";exit; 
 if($stud[0]['admission_year']==1){
	 $s=1;
 }else{
	 $s=3;
 }

for ($x = $s; $x <= $semester_post; $x++) {
	$studallsem[]=$x;
}
  foreach($res_uniq_sem as $rsem){
	 $res_uniq_sems[] = $rsem['semester'];  
  }	
//print_r($studallsem);echo "<br>";
//print_r($res_uniq_sems);echo "<br>";
$uniq_sems=array_diff($studallsem,$res_uniq_sems);
//print_r($uniq_sems);exit;
  $studcredits =$this->Marks_model->fetch_credits_earned($stud[0]['stud_id'], $stud[0]['exam_id']);
  $arr_bklog_sems =$this->Results_model->fetch_backlog_semesters($stud[0]['enrollment_no'], $stud[0]['exam_id']);
  
  //print_r($arr_bklog_sems);
  $arr_sems =array();
  foreach($arr_bklog_sems as $sem){
	 $arr_sems[] = $sem['semester'];  
  }
  
  if(!empty($arr_sems)){
	  $arr_sems=array_unique($arr_sems);
  }
  ////////////////////////////////////////////////////////
 /* if(!empty($res_bklogsems)){
	  $arr_sems=$res_bklogsems;
  }*/
 /* if(!empty($res_bklogsems) && !empty($arr_sems)){
	  $arr_sems=array_merge($arr_sems,$res_bklogsems);
  }*/
  
 //print_r($res_bklogsems);exit;

//exit();
$backlog_grades= $this->Results_model->fetch_student_backlog_grade_details($stud[0]['stud_id'],$stud[0]['exam_id']);
//$backlog_kiran= $this->Results_model->fetch_student_backlog_grade_details_kiran($stud[0]['stud_id'],$semester_post);
$resultsgradenew= $this->Results_model->fetch_student_backlog_grade_from_result_data($stud[0]['stud_id'],$stud[0]['exam_id']);
//echo '<pre>';print_r($resultsgradenew);exit;
 foreach($resultsgradenew as $rs11){
	 $res_bklogsems=array();
					$resultsgrade[] = $rs11[0]['final_grade'];
					//$resultsgrade_test[] = $rs11[0]['final_grade'].''.$rs11[0]['subject_id'];
					if($rs11[0]['final_grade']=='U' || $rs11[0]['final_grade']=='F'){
						$res_bklogsems[] = $rs11[0]['semester'];
					}
				}
				$res_bklogsems=array_unique($res_bklogsems);
				if(!empty($res_bklogsems) && !empty($arr_sems)){
	  $arr_sems=array_merge($arr_sems,$res_bklogsems);
  }
  //echo 'ss';
	//print_r($resultsgrade_test);	exit;		
 ?>
<div style="height:842px;xmargin-bottom:170px;xxbackground:#ddd;">

<table cellpadding="0" cellspacing="0" border="0" valign="top" width="800">
            <tr>
			<?php
		    $bucket_key = "uploads/gradesheet/".$exam_ses."/QRCode/qrcode_".$exam_master_id[$i] . ".png";
			$imageData = $this->awssdk->getsignedurl($bucket_key);
		?>
			<td  align="center" width="100" style="text-align:center;margin-left:15px;"><img src="<?=$imageData?>" class="pull-right" style="margin:2px;float:right;"></td>
			<td style="font-weight:normal;text-align:center;">
			</td>
			<td width="120" align="right" valign="middle" style="text-align:center;padding-top:20px;">
			</td>
			</tr>   
			<tr>
			<td height='90'></td>
			</tr>
</table>
<div style="width:100%;text-align:center;margin-top:-65px;">
	<span style="font-size:15px;text-align:center;align:center;border:2px solid #000;padding:3px; margin-left:37%;width:27%"><b>STATEMENT OF GRADES</b></span>
</div>
<div style="width:100%;height:620px;border:1px solid #000;overflow: hidden;margin-top:10px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="head-table" style="xborder:2px solid #000">

   <tr>
    <td width="15%"><strong>PROGRAMME</strong></td>
    <td align="left"><?=strtoupper($stud[0]['gradesheet_name']);?></td>
    <td width="7%"><strong>SPECIALIZATION</strong></td>
    <td align="left" colspan=3><?php if($stud[0]['specialization']!=NULL){echo strtoupper($stud[0]['specialization']);}else{echo "--";}?></td>
    <td width="15%"><strong>REGULATIONS</strong></td>
    <td width="5%"><?=$regu_lation?></td>
    <?php
	if(!empty($stud[0]['student_photo_path'])){
          $file_name = $stud[0]['student_photo_path'];
      }else{
        $file_name = $stud[0]['enrollment_no'];  
      }
      $new_file = explode('.', $file_name);
     $photo = (isset($new_file[1]) && !empty($new_file[1])) ? $file_name : $file_name.'.jpg';
      
      echo $bucket_key = 'uploads/student_photo/' . $photo;
        //$bucket_key = 'uploads/student_photo/'.$stud[0]['enrollment_no'].'.jpg';
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
    <td width="5%"><?=$exmonyer?></td>
    </tr>


</table>

<table width="100%"  border="0" cellspacing="0" cellpadding="5" class="details-table" style="xborder:2px solid #000">
  <tr>
    <!--th width="5%">SEM NO</th-->
    <th width="10%">COURSE CODE</th>
    <th align="left" colspan=2>NAME OF THE COURSE</th>
	 <th width="8%">ATTENDANCE GRADE</th> 
    <th width="8%">CREDITS</th>
    <th width="8%">LETTER GRADE(LG)</th>
    <th width="8%">GRADE POINT(GP)</th>
		<th width="8%">CREDIT POINTS</th>							  
    <!--th width="10%">RESULT<?php // print_r($backlog_kiran); ?></th-->
    <th width="10%" colspan=2>Month & Year of Passing</th>
  </tr>
  <?php 
     $tot_cr_point = 0;
	 $tcr =0;
	 $tcrp =0;
	 $tgr =0;
	 
  if(!empty($backlog_grades)){
	  foreach($backlog_grades as $bg ){
		 $bklg_grade[] = $bg; 
	  }
  }
  //print_r($res_grade);exit;
	foreach($stud as $val ){
//print_r($val['subject_code']);
	$res_grade[] = $val['final_grade'];
	if($val['final_grade']=='U' || $val['final_grade']=='W' || $val['final_grade'] =='WH' || $val['final_grade'] =='F'){
		$grade = "RA";
	}else{
		$grade = "PASS";
	}
	$ar_pharma =array(116,119,170);
	if(!in_array($val['admission_stream'], $ar_pharma)){
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
	}else{
		if($val['final_grade']=='O'){
			$grade_points = 10;
		}elseif($val['final_grade']=='A'){
			$grade_points = 9;
		}elseif($val['final_grade']=='B'){
			$grade_points = 8;
		}elseif($val['final_grade']=='C'){
			$grade_points = 7;
		}elseif($val['final_grade']=='D'){
			$grade_points = 6;
		}elseif($val['final_grade']=='F' || $val['final_grade']=='W'){
			$grade_points = 0;
		}else{
			$grade_points = 0;
		}

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
    <!--td align="center"><?=$val['semester'];?></td-->
    <td align="center"><?=strtoupper($val['subject_code']);?></td>
    <td colspan="2"><?=strtoupper($val['subject_name']);?> <?=$subject_category;?></td>
	<td align="center"><?php if($val['attendance_grade'] !=''){ echo $val['attendance_grade'];}else{ echo "-";}?></td>
    <td align="center"><?=$val['credits'];?></td>
    <td align="center"><?=$val['final_grade'];?></td>
    <td align="center"><?=$grade_points;?></td>
	 <td align="center"><?=$grade_points*$val['credits'];?></td>
    <!--td align="center"><?=$grade;?></td-->
    <td align="center" colspan=2><?=$val['exam_month'].' '.$val['exam_year'];?></td>
  </tr>
  <?php
  $tcr+=$val['credits'];
  $tgr+=$grade_points;
  $tcrp+=$grade_points*$val['credits'];
  $tot_cr_point = $tot_cr_point+($grade_points*$val['credits']);
  
 }
 
// $fin_grade=array();
 if(!empty($bklg_grade)){
	 $fin_grade=array_push($res_grade,$bklg_grade);
 }
 if(!empty($resultsgrade)){
	 $fin_grade=array_merge($res_grade,$resultsgrade); //
 }
 //unset($res_grade);
 //print_r($bklg_grade);
 //print_r($resultsgrade);
  //print_r($resultsgrade);
 
  ?>
  <tr>
  <td colspan="4" align="right"><strong>Total</strong></td>
  <td style="border-right:none;" align="center"><strong><?=$tcr?></strong></td>
  <td style="border-left:none;"></td>
  <td  align="center"><strong><?=$tgr?></strong></td>
  <td  align="center"><strong><?=$tcrp?></strong></td>
   <td colspan="2"></td>


  </tr>
  <tr >
  <td align="center" colspan="10" style="height:25px"></td>
  </tr>
  
  
																											   
  <tr>
  <td colspan="2"><strong>SEMESTER</strong></td>
  <td align="center"><strong><?php echo numberToRoman($val['semester']);?></strong></td>
  <td align="center" colspan="2"><strong>SGPA</strong></td>
  <td align="center"><?php echo number_format($stud[0]["grades"][0]['sgpa'], 2, '.', '')?></td>
														  
  <!--td align="center"><strong>CGPA</strong></td>
  <td align="center"><?php $cgpa= round($stud[0]["grades"][0]['cumulative_gpa'],2);
  echo number_format($cgpa, 2, '.', '');
  ?></td-->
  <td align="center" colspan="3"><strong>Result</strong></td>
  <td align="center"><?=$grade;?></td>
  </tr>
  
  <tr>
  <td align="left" colspan="10" ><small><i>PRN-Permanent Registration Number, OE-Open Elective, 
AEC-Ablility Enhancement courses, 
VEC-Value Education courses, 
SEC-Skill Enhancement courses, 
IKS-Indian knowledge system, VSEC-Vocational and Skill Enhancement courses, 
CC-Cocurricular courses, **-Minor courses</i></small>

					
</td>
																																  
  </tr>
  
 <tr>
    <td align="center" colspan="8" style="border:0px" border="0">*** END OF STATEMENT ***</td>
  </tr>
</table>
</div>


<div>
    <div style="float:left; width:50%;text-align:left;"><b>Medium of Instruction: English</b></div>
    <div style="float:right;width:50%;text-align:right;"><!--b>ABC ID: <?= $stud[0]['abc_no'] ?></b--></div>
</div>

	 <?php $i++;
	 unset($bklg_grade);
		unset($resultsgrade);
		unset($resgradenew);
		unset($arr_sems);
	    unset($studcredits[0]['credits_earned']);
//var_dump($stud[0]);
// exit();
		
	 }
	    //unset($fin_grade);
		//unset($res_grade);
		unset($bklg_grade);
		unset($resultsgrade); 
		unset($resgradenew);
		unset($arr_sems);
	    unset($studcredits[0]['credits_earned']);
		//exit;
	 ?>
</body>
</html>
