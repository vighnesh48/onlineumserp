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
$CI->load->model('Phd_results_model');
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
  $studcredits =$this->Phd_results_model->fetch_credits_earned($stud[0]['stud_id'], $stud[0]['exam_id']);
  $arr_bklog_sems =$this->Phd_results_model->fetch_backlog_semesters($stud[0]['enrollment_no'], $stud[0]['exam_id']);
  
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
$backlog_grades= $this->Phd_results_model->fetch_student_backlog_grade_details($stud[0]['stud_id'],$stud[0]['exam_id']);
//$backlog_kiran= $this->Phd_results_model->fetch_student_backlog_grade_details_kiran($stud[0]['stud_id'],$semester_post);
$resultsgradenew= $this->Phd_results_model->fetch_student_backlog_grade_from_result_data($stud[0]['stud_id'],$stud[0]['exam_id']);
/*echo '<pre>';
print_r($resultsgradenew);exit;*/
 foreach($resultsgradenew as $rs11){
	 $res_bklogsems=array();
					$resultsgrade[] = $rs11[0]['final_grade'];
					if($rs11[0]['final_grade']=='U' || $rs11[0]['final_grade']=='F'){
						$res_bklogsems[] = $rs11[0]['semester'];
					}
				}
				$res_bklogsems=array_unique($res_bklogsems);
				if(!empty($res_bklogsems) && !empty($arr_sems)){
	  $arr_sems=array_merge($arr_sems,$res_bklogsems);
  }
  //echo 'ss';
	//print_r($arr_sems);			
 ?>
<div style="height:842px;xmargin-bottom:170px;xxbackground:#ddd;">

<table cellpadding="0" cellspacing="0" border="0" valign="top" width="800">
            <tr>
			<td  align="center" width="100" style="text-align:center;margin-left:15px;"><img src="<?=base_url()?>uploads/phd/gradesheet/<?=$stud[0]['exam_month']?><?=$stud[0]['exam_year']?>/QRCode/qrcode_<?=$exam_master_id[$i]?>.png" class="pull-right" style="margin:2px;float:right;"></td>
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
    <td width="5%">2017<?//=$stud[0]['admission_session']?></td>
	<td rowspan="4" style="padding:0;"><center><img src="https://erp.sandipuniversity.com/uploads/student_photo/<?=$stud[0]['enrollment_no']?>.jpg" width="80" height="100"/></center></td>
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

<table width="100%"  border="0" cellspacing="5" cellpadding="5" class="details-table" style="xborder:2px solid #000">
  <tr>
  <th width="5%">Sr.no</th>
   <!-- <th width="5%">SEM NO</th>-->
    <th width="10%">COURSE CODE</th>
    <th align="left">NAME OF THE COURSE</th>
	<th width="10%">ATTENDANCE GRADE</th>
    <th width="8%">CREDITS</th>
    <th width="8%">LETTER GRADE</th>
    <th width="8%">GRADE POINT</th>
    <th width="10%">RESULT<?php // print_r($backlog_kiran); ?></th>
  </tr>
  <?php 
 $sr=1;
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
  <tr><td align="center"><?=$sr;?></td>
    <!--<td align="center"><?=$val['semester'];?></td>-->
    <td align="center"><?=strtoupper($val['subject_code']);?></td>
    <td><?=strtoupper($val['subject_name']);?> <?=$subject_category;?></td>
	<td align="center"><?php if($val['attendance_grade'] !=''){ echo $val['attendance_grade'];}else{ echo "-";}?></td>
    <td align="center"><?=$val['credits'];?></td>
    <td align="center"><?=$val['final_grade'];?></td>
    <td align="center"><?=$grade_points;?></td>
    <td align="center"><?=$grade;?></td>
  </tr>
  <?php
  $sr++;
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
    <td align="center" colspan="8" style="border:0px" border="0">*** END OF STATEMENT ***</td>
  </tr>
</table>
</div>
<table width="100%" border="" cellspacing="0" cellpadding="0" class="head-table" style="border:2px solid #000">
 <!-- <tr>
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
  </tr>-->
  <tr>
    <td><strong>Credits Registered</strong>
    <?php
	//echo  error_reporting(E_ALL);
	//echo "<pre>";
   //var_dump($stud[0]['grades']);//exit;
    ?>
    </td>
    <td align="center"><?php //echo $stud[0]["grades"][1]['credits_registered'];
	if($stud[0]["grades"][1]['credits_registered'] !=''){ echo $stud[0]["grades"][1]['credits_registered'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][2]['credits_registered'];
	if($stud[0]["grades"][2]['credits_registered'] !=''){ echo $stud[0]["grades"][2]['credits_registered'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][3]['credits_registered']//
	if($stud[0]["grades"][3]['credits_registered'] !=''){ echo $stud[0]["grades"][3]['credits_registered'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][4]['credits_registered'];//
	if($stud[0]["grades"][4]['credits_registered'] !=''){ echo $stud[0]["grades"][4]['credits_registered'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][5]['credits_registered'];//
	if($stud[0]["grades"][5]['credits_registered'] !=''){ echo $stud[0]["grades"][5]['credits_registered'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][6]['credits_registered'];//
	if($stud[0]["grades"][6]['credits_registered'] !=''){ echo $stud[0]["grades"][6]['credits_registered'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][7]['credits_registered'];//
	if($stud[0]["grades"][7]['credits_registered'] !=''){ echo $stud[0]["grades"][7]['credits_registered'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][8]['credits_registered'];//
	if($stud[0]["grades"][8]['credits_registered'] !=''){ echo $stud[0]["grades"][8]['credits_registered'];}else{ echo "-";}?></td>
	<td align="center"><?php //echo $stud[0]["grades"][9]['credits_registered'];
	if($stud[0]["grades"][9]['credits_registered'] !=''){ echo $stud[0]["grades"][9]['credits_registered'];}else{ echo "-";}?></td>
	<td align="center"><?php //echo $stud[0]["grades"][10]['credits_registered'];
	if($stud[0]["grades"][10]['credits_registered'] !=''){ echo $stud[0]["grades"][10]['credits_registered'];}else{ echo "-";}?></td>
  </tr>
  <tr>
    <td><strong>Credits Earned</strong></td>
    <td align="center"><?php //echo $stud[0]["grades"][1]['credits_earned'];//
	if($stud[0]["grades"][1]['credits_earned'] !=''){ echo $stud[0]["grades"][1]['credits_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][2]['credits_earned'];//
	if($stud[0]["grades"][2]['credits_earned'] !=''){ echo $stud[0]["grades"][2]['credits_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][3]['credits_earned']//
	if($stud[0]["grades"][3]['credits_earned'] !=''){ echo $stud[0]["grades"][3]['credits_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][4]['credits_earned'];//
	if($stud[0]["grades"][4]['credits_earned'] !=''){ echo $stud[0]["grades"][4]['credits_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][5]['credits_earned'];//
	if($stud[0]["grades"][5]['credits_earned'] !=''){ echo $stud[0]["grades"][5]['credits_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][6]['credits_earned'];//
	if($stud[0]["grades"][6]['credits_earned'] !=''){ echo $stud[0]["grades"][6]['credits_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][7]['credits_earned'];//
	if($stud[0]["grades"][7]['credits_earned'] !=''){ echo $stud[0]["grades"][7]['credits_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php //echo $stud[0]["grades"][8]['credits_earned'];//
	if($stud[0]["grades"][8]['credits_earned'] !=''){ echo $stud[0]["grades"][8]['credits_earned'];}else{ echo "-";}?></td>
	<td align="center"><?php //echo $stud[0]["grades"][9]['credits_earned'];//
	if($stud[0]["grades"][9]['credits_earned'] !=''){ echo $stud[0]["grades"][9]['credits_earned'];}else{ echo "-";}?></td>
	<td align="center"><?php //echo $stud[0]["grades"][10]['credits_earned'];//
	if($stud[0]["grades"][10]['credits_earned'] !=''){ echo $stud[0]["grades"][10]['credits_earned'];}else{ echo "-";}?></td>
  </tr>
  <!--tr>
    <td><strong>Grade Points Earned</strong></td>
	<td align="center"><?php if($stud[0]['semester']==1){ echo $stud[0]['grade_points_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php if($stud[0]['semester']==2){ echo $stud[0]['grade_points_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php if($stud[0]['semester']==3){ echo $stud[0]['grade_points_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php if($stud[0]['semester']==4){ echo $stud[0]['grade_points_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php if($stud[0]['semester']==5){ echo $stud[0]['grade_points_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php if($stud[0]['semester']==6){ echo $stud[0]['grade_points_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php if($stud[0]['semester']==7){ echo $stud[0]['grade_points_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php if($stud[0]['semester']==8){ echo $stud[0]['grade_points_earned'];}else{ echo "-";}?></td>
	<td align="center"><?php if($stud[0]['semester']==9){ echo $stud[0]['grade_points_earned'];}else{ echo "-";}?></td>
    <td align="center"><?php if($stud[0]['semester']==10){ echo $stud[0]['grade_points_earned'];}else{ echo "-";}?></td>
	
  </tr-->
  <tr>
    <td><strong>Grade Points Average(GPA)<?php // print_r($arr_sems);?></strong></td>
	<td align="center"><?php if(in_array('1', $arr_sems)){echo "-";}else{ echo $stud[0]["grades"][1]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('2', $arr_sems)){echo "-";}else{ echo $stud[0]["grades"][2]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('3', $arr_sems)){echo "-";}else{ echo $stud[0]["grades"][3]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('4', $arr_sems)){echo "-";}else{ echo $stud[0]["grades"][4]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('5', $arr_sems)){echo "-";}else{ echo $stud[0]["grades"][5]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('6', $arr_sems)){echo "-";}else{ echo $stud[0]["grades"][6]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('7', $arr_sems)){echo "-";}else{ echo $stud[0]["grades"][7]['sgpa'];}?></td>
    <td align="center"><?php if(in_array('8', $arr_sems)){echo "-";}else{ echo $stud[0]["grades"][8]['sgpa'];}?></td>
	<td align="center"><?php if(in_array('9', $arr_sems)){echo "-";}else{ echo $stud[0]["grades"][9]['sgpa'];}?></td>
	<td align="center"><?php if(in_array('10', $arr_sems)){echo "-";}else{ echo $stud[0]["grades"][10]['sgpa'];}?></td>
  </tr>
  <tr>
    <td><strong>Cumulative Credits Earned</strong></td>
    <td align="center"><?=$studcredits[0]['credits_earned'];?></td>
    <td colspan="6" align="center"><strong>Cumulative Grade Point Average(CGPA)</strong></td>
    <td align="center" colspan=3><?php 
 //print_r($res_grade); 
 //print_r($bklg_grade);
 //print_r($resultsgrade);
 //exit;
	if((empty($arr_sems))){  //||(empty($res_bklogsems)
	
	
	
	if((in_array('U',$res_grade))||(in_array('F',$res_grade))||(in_array('U',$bklg_grade))||(in_array('F',$bklg_grade))||(in_array('U',$resultsgrade))||(in_array('F',$resultsgrade))){
		
		echo "-";
		
		}else{  echo bcdiv($stud[0]['cumulative_gpa'],1,2);} 
		
		}else{ echo "-";} 
		
		unset($res_grade);//unset($images[$key]);
		unset($bklg_grade);
		unset($resultsgrade);
       unset($arr_sems);
	   unset($stud[0]["grades"]);
	 //  echo '<br>';
	 //  echo 'k';
	//   print_r($res_grade); 
// print_r($bklg_grade);
// print_r($resultsgrade);
	   ?>
       
       </td>
    </tr>
	<tr>
    <td colspan=11><strong>RA</strong>-Reappearance, &nbsp;&nbsp;&nbsp;<strong>W</strong>-Withdrawal,&nbsp;&nbsp;&nbsp; <strong>PRN</strong>-Permanent Registration Number,
    &nbsp;&nbsp;&nbsp;<strong>*</strong>-Non Credit(Mandatory), &nbsp;&nbsp;&nbsp;<strong>**</strong>-Minors(Optional), &nbsp;&nbsp;&nbsp;<br><strong>***</strong>-Open Electives(Optional),&nbsp;&nbsp;&nbsp;
    <strong>****</strong>-University Research Experience(Optional)</td>
    </tr>

</table>

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
	 ?>
</body>
</html>
