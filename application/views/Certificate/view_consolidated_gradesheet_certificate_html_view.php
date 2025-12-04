<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">-->
<link href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
<script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js'></script>
<script src='//code.jquery.com/jquery-1.11.1.min.js'></script>
<!------ Include the above in your HEAD tag ---------->

<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
<script src='http://getbootstrap.com/dist/js/bootstrap.min.js'></script>
<style>
body{font-family:Arial, Helvetica, sans-serif;font-size:11px;
}
.details-table th{border:1px solid #000;}
.details-table td{border-right:1px solid #000;border-left:1px solid #000;padding-left:8px;border-bottom:1px solid #000;}
.head-table td{padding:4px;border:1px solid #000;line-height:10px;}
.wrapword {
   /* white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 /
    white-space: -pre-wrap;      /* Opera 4-6 /
    white-space: -o-pre-wrap;    /* Opera 7 /
    white-space: pre-wrap;       /* css-3 /
    word-wrap: break-word;       /* Internet Explorer 5.5+ /
    white-space: -webkit-pre-wrap; /* Newer versions of Chrome/Safari/
    word-break: break-all;
    white-space: normal;
    /
    overflow-wrap: break-word;
  word-wrap: break-all;
  hyphens: auto;*/
}
<style type="text/css">
.row {
margin: 0px 0px 5px 0px !important;
padding: 0px !important;
}
.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2
, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3
, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5
, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6
, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8
, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9
, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11
, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
	border:0 !important;
	padding:0 !important;
	margin-left:-0.00005 !important;
}
table td{ font-size:10px !important;}
.signature {font-size:14px;}
/*
.bg{background-image:url('<?=base_url()?>assets/images/sucertificate.jpg'); background-repeat:no-repeat; background-size:cover;margin:0 auto;}
*/
</style>
</head>
<body>


  <?php 
 /* border-top: 4px solid rgb(0,130,202);
    box-shadow:
        inset 0 -8px 4px 4px rgb(255,255,255),
        inset 0 2px 4px 0px rgba(50, 50, 50, 0.75);function orderBy($data, $field)
  {
    $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
    usort($data, create_function('$a,$b', $code));
    return $data;
  }
  function searchsemister($id, $array) {
   foreach ($array as $key => $val) {
       if ($val['semester'] === $id) {
           return 1;
       }
   }
   return 0;
}
*/
// $stud_list = orderBy($stud_list, 'subject_code');
foreach($stud_list as $list){
	
if($list['semester']==1){$semester_one[]=$list['semester'];}
if($list['semester']==2){$semester_two[]=$list['semester'];}
if($list['semester']==3){$semester_three[]=$list['semester'];}
if($list['semester']==4){$semester_four[]=$list['semester'];}
if($list['semester']==5){$semester_five[]=$list['semester'];}
if($list['semester']==6){$semester_six[]=$list['semester'];}
if($list['semester']==7){$semester_seven[]=$list['semester'];}
if($list['semester']==8){$semester_eight[]=$list['semester'];}
}
  
  $count_one=count($semester_one);
  $count_two=count($semester_two);

  $count_three=count($semester_three);

  $count_four=count($semester_four);

  $count_five=count($semester_five);

  $count_six=count($semester_six);

  $count_seven=count($semester_seven);

  $count_eight=count($semester_eight);



  if($count_one<=$count_two){
	  $result_one=$count_two -$count_one;
  }else{
	  $result_two=$count_one -$count_two;
  }
  
  if($count_three<=$count_four){
	  $result_three=$count_four - $count_three;
  }else{
	  $result_four=$count_three - $count_four;
  }
  
  if($count_five<=$count_six){
	  $result_five=$count_six -$count_five;
  }else{
	  $result_six=$count_five -$count_six;
  }
  
  
  
  if($count_seven<=$count_eight){
	  $result_seven=$count_eight -$count_seven;
  }else{
	  $result_eight=$count_seven -$count_eight;
  }
  
 // echo '<pre>'; print_r($stud_list);?>
<?php $iy=0; $array_ch_one=array();
 foreach($stud_list as $listy){


 	if($listy['semester']==1){ 

        $strlen1=strlen($listy['subject_name']); //echo'<br>';
        if($strlen1>43){
         $array_ch_one[]=1;

        // $iy++;

         }else{
         $array_ch_one[]=0;
     }

     } 
					   
		if($listy['semester']==2){ 

        $strlen2=strlen($listy['subject_name']); // echo'<br>';
        if($strlen2>43){
         $array_ch_two[]=1;

        // $iy++;

         }else{
         $array_ch_two[]=0;
     }

     } 
if($listy['semester']==3){ 

        $strlen3=strlen($listy['subject_name']); //echo'<br>';
        if($strlen3>43){
         $array_ch_three[]=1;

        // $iy++;

         }else{
         $array_ch_three[]=0;
     }

     } 

     if($listy['semester']==4){ 

        $strlen4=strlen($listy['subject_name']);// echo'<br>';
        if($strlen4>43){
         $array_ch_four[]=1;

        // $iy++;

         }else{
         $array_ch_four[]=0;
     }

     } 

     if($listy['semester']==5){ 

        $strlen5=strlen($listy['subject_name']); //echo'<br>';
        if($strlen5>43){
         $array_ch_five[]=1;

       //  $iy++;

         }else{
         $array_ch_five[]=0;
     }

     } 

     if($listy['semester']==6){ 

        $strlen6=strlen($listy['subject_name']); //echo'<br>';
        if($strlen6>43){
         $array_ch_six[]=1;

        // $iy++;

         }else{
         $array_ch_six[]=0;
     }

     } 

     if($listy['semester']==7){ 

        $strlen7=strlen($listy['subject_name']);// echo'<br>';
        if($strlen7>43){
         $array_ch_seven[]=1;

        // $iy++;

         }else{
         $array_ch_seven[]=0;
     }

     } 

     if($listy['semester']==8){ 

        $strlen8=strlen($listy['subject_name']); //echo'<br>';
        if($strlen8>43){
         $array_ch_eight[]=1;

        // $iy++;

         }else{
         $array_ch_eight[]=0;
     }

     } 

 }

    //$arrayss =$array_ch_one;
    $remove = array(0);
    $resultwithoutzerosemester1 = array_diff($array_ch_one, $remove);
    $resultwithoutzerosemester2 = array_diff($array_ch_two, $remove);
///////////////////////
    $resultwithoutzerosemester3 = array_diff($array_ch_three, $remove);
    $resultwithoutzerosemester4= array_diff($array_ch_four, $remove);
//////////////////////
    $resultwithoutzerosemester5 = array_diff($array_ch_five, $remove);
    $resultwithoutzerosemester6 = array_diff($array_ch_six, $remove);
//////////////////////
    $resultwithoutzerosemester7 = array_diff($array_ch_seven, $remove);
    $resultwithoutzerosemester8 = array_diff($array_ch_eight, $remove);                          
    
     //count($resultwithoutzerosemester2);
   

 ?>


<div class="container bg" style="text-align:center;margin-top:10px;padding:20% 8%;">

        <!--<table width="100%" border="0" cellspacing="0" cellpadding="0" id="maintable">
  <tr>
    <td align="center" style="padding:10px;">
   <img src="http://sandipuniversity.com/erp/assets/images/logo_form.png" width="300" />
    <p style="margin-top:5"><strong>Mahiravani, Trimbak Road, Nashik – 422 213</strong></p>
    <p style="margin-top:0"><strong>OFFICE OF THE CONTROLLER OF EXAMINATIONS</strong></p>
    <p style="font-size:15px;text-align:center;align:center;border:0px solid #000;"><b style="font-weight:bold;">&nbsp;&nbsp;CONSOLIDATED GRADE SHEET&nbsp;&nbsp;</b></p>  </td>
  </tr></table>-->
         <div class="row">
            <div class="col-xs-12" style="padding-bottom:10px">
               
        <div class="table-responsive">
               <table   border="1" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                     <tr>
                        <td ><b style="font-weight: bold;">&nbsp;PROGRAMME&nbsp;</b></td>
                        <td width="108">&nbsp;<?php echo strtoupper($stud_list[0]['gradesheet_name']);?>&nbsp;</td>
                        <td ><b style="font-weight: bold;">&nbsp;SPECIALIZATION&nbsp;</b></td>
                        <td>&nbsp;<?php echo strtoupper($stud_list[0]['specialization']); ?>&nbsp;</td>
                        <td><b style="font-weight: bold;">&nbsp;REGULATIONS&nbsp;</b></td>
                        <td>&nbsp;<?php echo $stud_list[0]['admission_session'];?>&nbsp;</td>
                        <td colspan="0" rowspan="3"  width=" 8%">  <img src="<?=base_url()?>uploads/student_photo/<?=$stud_list[0]['enrollment_no']?>.jpg" width="60" ></td>
                     </tr>
                     <tr>
                        <td><b style="font-weight: bold;">&nbsp;NAME OF THE<br/>
                           &nbsp;CANDIDATE&nbsp;</b>
                        </td>
                        <td>&nbsp;<?php echo strtoupper($stud_list[0]['last_name'].' '.$stud_list[0]['first_name'].' '.$stud_list[0]['middle_name']); ?>&nbsp;</td>
                        <td><b style="font-weight: bold;">&nbsp;MOTHER'S<br/>&nbsp;NAME&nbsp;</b></td>
                        <td>&nbsp;<?php echo strtoupper($stud_list[0]['mother_name']);?>&nbsp;</td>
                        <td><b style="font-weight: bold;">&nbsp;PRN&nbsp;</b></td>
                        <td>&nbsp;<?php echo $stud_list[0]['enrollment_no'];?>&nbsp;</td>
                     </tr>
                     <tr>
                        <td><b style="font-weight: bold;">&nbsp;DATE OF BIRTH&nbsp;</b><br/>&nbsp;(DD-MM-YYYY)&nbsp;</td>
                        <td>&nbsp;<?php echo $stud_list[0]['dob']; ?>&nbsp;</td>
                        <td><b style="font-weight: bold;">&nbsp;GENDER&nbsp;</b></td>
                        <td>&nbsp;<?php  if($stud_list[0]['gender']=="F"){ echo"FEMALE"; }else{ echo "MALE";}?>&nbsp;</td>
                        <td><b style="font-weight: bold;">&nbsp;MONTH&nbsp;&&nbsp;YEAR OF LAST<br/>&nbsp;APPEARANCE&nbsp;</b></td>
                        <td>&nbsp;<?php 
      echo $stud_last_ex_ses;
     /*  foreach($stud_list as $list){
  
if($list['semester']==$semester){$exc=$list['exam_month'].' '.$list['exam_year'];} } */ ?> <?php // echo $exc;// $stud_list[$last_a-1]['exam_month'].' '.$stud_list[$last_a-1]['exam_year']; ?>&nbsp;</td>
                     </tr>
                  </tbody>
               </table>
         </div>
            </div>
         </div>

<div class="row">
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" align="left">

    <table border="1" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                    <th width="16%" style="font-size:11px !important;text-align:center; padding:1px;">COURSE CODE</th>
                    <th width="65%" style="font-size:11px !important;text-align:center; padding:1px;">COURSE NAME</th>
                    <th width="8%" style="font-size:11px !important;text-align:center; padding:1px;">CR</th>
                    <th width="8%" style="font-size:11px !important;text-align:center; padding:1px;">LG</th>
                    <th width="8%" style="font-size:11px !important;text-align:center; padding:1px;">GP</t1h>
                    <th width="20%" style="font-size:11px !important;text-align:center; padding:1px;">M&Y OF PASSING</th>
                   </tr></table> 
                   </div>
                   <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" align="right">
                    <table border="1" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                   <th width="16%" style="font-size:11px !important;text-align:center; padding:1px;">COURSE CODE</th>
                    <th width="65%" style="font-size:11px !important;text-align:center; padding:1px;">COURSE NAME</th>
                    <th width="8%" style="font-size:11px !important;text-align:center; padding:1px;">CR</th>
                    <th width="8%" style="font-size:11px !important;text-align:center; padding:1px;">LG</th>
                    <th width="8%" style="font-size:11px !important;text-align:center; padding:1px;">GP</th>
                    <th width="20%" style="font-size:11px !important;text-align:center; padding:1px;">M&Y OF PASSING</th>
                  </tr>
                  </table>
                  </div>
                  </div>
                  
                  <?php $course_pattern= $stud_list[0]['course_pattern'];
				        $course_duration= $stud_list[0]['course_duration'];
				 
				       if($course_pattern=="SEMESTER"){
						
						////foreach($stud_list as $list){
				   ?>
                  
                  
                  
                  <div class="row">
                  <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" align="center">
                
                  <?php 
				 // searchsemister('1',$stud_list);
				 if(!empty($count_one)){// if(searchsemister('1',$stud_list)==1){?>
               <span style="border:1px solid #000; padding:0px; margin:10px;font-weight: bold;">&nbsp;&nbsp; SEMESTER 01&nbsp;&nbsp;</span>
                   <?php } ?>
                   <table style="border:1px solid;" cellpadding="1" cellspacing="1" width="100%">
                   <?php  foreach($stud_list as $list_1){
					   
					        if($list_1['semester']==1){ ?> 
                     <tr>
            <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list_1['subject_code'];?></td>
            <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left; "><?php echo strtoupper($list_1['subject_name']); ?></td>
           <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list_1['credits'];?></td>
            <td width="8%" style="padding:1px;text-align:left;border-right:1px solid #000;">&nbsp;<?php echo $list_1['final_grade'];?></td>
            <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list_1['grade_point'];?></td>
            <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list_1['exam_month'].' '.$list_1['exam_year']; ?></td>
            </tr>
            <?php } }?>

            <?php  if($result_one>0){ for($ione=0;$ione<$result_one;$ione++){ ?>
             <tr>
             <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="65%"align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left;<?php  $strlen11=strlen($list_1['subject_name']); if($strlen11<49){?> padding-bottom:2.6px;  <?php }?> ">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
            <?php } }?>

        <?php  $semester_tw=count($resultwithoutzerosemester2);
              for($sone=0;$sone<$semester_tw;$sone++){?>
              	 <tr>
             <td width="16%" style=" text-align:center;border-right:1px solid #000;"><?php //echo $semester_tw; ?>&nbsp;</td>
             <td width="65%" class="wrapword" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
               <?php }?>
         


                   </table>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" align="center">

                   <?php if(!empty($count_two)){ //if(searchsemister('2',$stud_list)==1){?>
                  <span style="border:1px solid #000; padding:0px; margin:10px;font-weight: bold;">&nbsp;&nbsp;SEMESTER 02&nbsp;&nbsp;</span>
                   <?php } ?>
                   <table style="border:1px solid;" cellpadding="1" cellspacing="1" width="100%">
                    <?php foreach($stud_list as $list){
					        if($list['semester']==2){ ?> 
                     <tr>
            <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['subject_code'];?></td>
            <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left;  "><?php echo strtoupper($list['subject_name']); 
 strlen($list['subject_name']); ?></td>
           <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['credits'];?></td>
            <td width="8%" style="padding:1px;text-align:left;border-right:1px solid #000;">&nbsp;<?php echo $list['final_grade'];?></td>
            <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['grade_point'];?></td>
            <td width="20%" style="padding:1px; text-align:center;border-right:1px solid #000;"><?php echo $list['exam_month'].' '.$list['exam_year']; ?></td>
         

            </tr> 
            <?php } }?>
            <?php  if($result_two>0){ for($itwo=0;$itwo<$result_two;$itwo++){ ?>
             <tr>
             <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left; <?php  $strlen22=strlen($list['subject_name']); /*if($strlen22<49)*/{?> padding-bottom:2.6px;  <?php }?> ">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
            <?php } }?>

 <?php  $semester_to=count($resultwithoutzerosemester1);
              for($stt=0;$stt<$semester_to;$stt++){?>
              	 <tr>
             <td width="16%" style=" text-align:center;border-right:1px solid #000;"><?php //echo $semester_tw; ?>&nbsp;</td>
             <td width="65%" class="wrapword" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
               <?php }?>
  


                   </table>
                   </div>
                  </div>
                  
                  
                  
                  <div class="row">
                  <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" align="center" >
                
                  <?php 
				 // searchsemister('1',$stud_list);
				 if(!empty($count_three)){  //if(searchsemister('3',$stud_list)==1){?>
                <span style="border:1px solid #000; padding:0px; margin:10px;font-weight: bold;">&nbsp;&nbsp;SEMESTER 03&nbsp;&nbsp;</span>
                   <?php } ?>
                   <table  cellpadding="1" cellspacing="1" width="100%" style="border:1px solid;">
                   <?php foreach($stud_list as $list_3){
					        if($list_3['semester']==3){
								
								$add_3[]=$list_3['subject_name'];
								
								 ?> 
                     <tr>
            <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list_3['subject_code'];?></td>
            <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left;"><?php echo strtoupper($list_3['subject_name']);?></td>
           <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list_3['credits'];?></td>
            <td width="8%" style="padding:1px;text-align:left;border-right:1px solid #000;">&nbsp;<?php echo $list_3['final_grade'];?></td>
            <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list_3['grade_point'];?></td>
            <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list_3['exam_month'].' '.$list_3['exam_year']; ?></td>
            </tr>
            <?php } }?>
            <?php if($result_three>0){ for($ithree=0;$ithree<$result_three;$ithree++){ ?>
             <tr>
             <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;"></td>
          <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;text-align: left; ">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"></td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"></td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"></td>
             <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;"></td></tr>
            <?php } } ?>
            
             <?php  $semester_f=count($resultwithoutzerosemester4);
              for($sff=0;$sff<$semester_f;$sff++){?>
              	 <tr>
             <td width="16%" style=" text-align:center;border-right:1px solid #000;"><?php //echo $semester_tw; ?>&nbsp;</td>
             <td width="65%" class="wrapword" style="text-align:center;border-right:1px solid #000;padding-bottom:2.6px;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
               <?php }?>

                   </table>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" align="center">

                   <?php if(!empty($count_four)){ //if(searchsemister('4',$stud_list)==1){?>
                 <span style="border:1px solid #000; padding:0px; margin:10px;font-weight: bold;">&nbsp;&nbsp;SEMESTER 04&nbsp;&nbsp;</span>
                   <?php } ?>
                   
                   
                   <table style="border:1px solid;" cellpadding="1" cellspacing="1" width="100%">
                    <?php foreach($stud_list as $list_f){
					        if($list_f['semester']==4){ ?> 
                     <tr>
            <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list_f['subject_code'];?></td>
            <td  width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left;"><?php echo strtoupper($list_f['subject_name']);?></td>
           <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list_f['credits'];?></td>
            <td width="8%" style="padding:1px;text-align:left;border-right:1px solid #000;">&nbsp;<?php echo $list_f['final_grade'];?></td>
            <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list_f['grade_point'];?></td>
            <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list_f['exam_month'].' '.$list_f['exam_year']; ?></td>
            </tr>
            <?php } }?>

             <?php   if($result_four>0){ for($ifour=0;$ifour<$result_four;$ifour++){ ?>
             <tr>
             <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;<?php // echo $ifour; ?>&nbsp;</td>
        <td  width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;text-align: left;">
&nbsp;&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;&nbsp;</td>
             <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;&nbsp;</td>
             </tr>
            <?php } }?>


             <?php   $semester_th=count($resultwithoutzerosemester3);
              for($sft=0;$sft<$semester_th;$sft++){?>
               <tr>
            <td width="16%" style=" text-align:center;border-right:1px solid #000;">&nbsp;<?php // echo $sft; ?>&nbsp;</td>
    <td width="65%" class="wrapword" style="text-align:center;border-right:1px solid #000;" >&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
               <?php } ?>

                   </table>
                   </div>
                  </div>
                   
                   
                   
                   
                   
                  <div class="row">
                  <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" align="center">
                
                  <?php 
				 // searchsemister('1',$stud_list);
				if(!empty($count_five)){  //if(searchsemister('5',$stud_list)==1){?>
               <span style="border:1px solid #000; padding:0px; margin:10px;font-weight: bold;">&nbsp;&nbsp; SEMESTER 05&nbsp;&nbsp;</span>
                   <?php } ?>
                   <table style="border:1px solid;" cellpadding="1" cellspacing="1" width="100%">
                   <?php foreach($stud_list as $list){
					        if($list['semester']==5){ ?> 
                     <tr>
            <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['subject_code'];?></td>
            <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left;<?php  $strlen55=strlen($list['subject_name']); if($strlen55<49){?> padding-bottom:2.6px;  <?php }?> "><?php echo strtoupper($list['subject_name']);?></td>
           <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['credits'];?></td>
            <td width="8%" style="padding:1px;text-align:left;border-right:1px solid #000;">&nbsp;<?php echo $list['final_grade'];?></td>
            <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['grade_point'];?></td>
            <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['exam_month'].' '.$list['exam_year']; ?></td>
            </tr>
            <?php } }?>
            <?php  if($result_five>0){ for($ifive=0;$ifive<$result_five;$ifive++){ ?>
             <tr>
             <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left;<?php  $strlen55=strlen($list['subject_name']); if($strlen55<49){?> padding-bottom:2.6px;  <?php }?> ">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
            <?php } }?>

            <?php  $semester_sx=count($resultwithoutzerosemester6);
              for($sx=0;$sx<$semester_sx;$sx++){?>
              	 <tr>
             <td width="16%" style=" text-align:center;border-right:1px solid #000;"><?php //echo $semester_tw; ?>&nbsp;</td>
             <td width="65%" class="wrapword" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
               <?php }?>
                   </table>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" align="center">

                   <?php if(!empty($count_six)){ //if(searchsemister('6',$stud_list)==1){?>
                  <span style="border:1px solid #000; padding:0px; margin:10px;font-weight: bold;">&nbsp;&nbsp;SEMESTER 06&nbsp;&nbsp;</span>
                   <?php } ?>
                   <table style="border:1px solid;"cellpadding="1" cellspacing="1" width="100%">
                    <?php foreach($stud_list as $list){
					        if($list['semester']==6){ ?> 
                     <tr>
            <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['subject_code'];?></td>
            <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left; <?php  $strlen66=strlen($list['subject_name']); if($strlen66<49){?> padding-bottom:2.6px;  <?php }?>"><?php echo strtoupper($list['subject_name']);?></td>
           <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['credits'];?></td>
            <td width="8%" style="padding:1px;text-align:left;border-right:1px solid #000;">&nbsp;<?php echo $list['final_grade'];?></td>
            <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['grade_point'];?></td>
            <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['exam_month'].' '.$list['exam_year']; ?></td>
            </tr>
            <?php } }?>
              <?php  if($result_six>0){ for($isix=0;$isix<$result_six;$isix++){ ?>
             <tr>
             <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left; <?php  $strlen66=strlen($list['subject_name']); if($strlen66<49){?> padding-bottom:2.6px;  <?php }?>">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
            <?php } }?>
            <?php  $semester_sxf=count($resultwithoutzerosemester5);
              for($sxf=0;$sxf<$semester_sxf;$sxf++){?>
              	 <tr>
             <td width="16%" style=" text-align:center;border-right:1px solid #000;"><?php //echo $semester_tw; ?>&nbsp;</td>
             <td width="65%" class="wrapword" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
               <?php }?>
                   </table>
                   </div>
                  </div>
                  
                  
                  
                  <div class="row">
                  <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" align="center">
                
                  <?php 
				 // searchsemister('1',$stud_list);
				if(!empty($count_seven)){//  if(searchsemister('7',$stud_list)==1){?>
               <span style="border:1px solid #000; padding:0px; margin:10px;font-weight: bold;">&nbsp;&nbsp; SEMESTER 07&nbsp;&nbsp;</span>
                   <?php } ?>
                   <table style="border:1px solid;" cellpadding="1" cellspacing="1" width="100%">
                   <?php foreach($stud_list as $list){
					        if($list['semester']==7){ ?> 
                     <tr>
            <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['subject_code'];?></td>
            <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left;<?php  $strlen77=strlen($list['subject_name']); if($strlen77<49){?> padding-bottom:2.6px;  <?php }?> "><?php echo strtoupper($list['subject_name']);?></td>
           <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['credits'];?></td>
            <td width="8%" style="padding:1px;text-align:left;border-right:1px solid #000;">&nbsp;<?php echo $list['final_grade'];?></td>
            <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['grade_point'];?></td>
            <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['exam_month'].' '.$list['exam_year']; ?></td>
            </tr>
            <?php } }?>
             <?php  if($result_seven>0){ for($iseven=0;$iseven<$result_seven;$iseven++){ ?>
             <tr>
             <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left;<?php  $strlen77=strlen($list['subject_name']); if($strlen77<49){?> padding-bottom:2.6px;  <?php }?> ">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
            <?php } }?>
             <?php  $semester_eight=count($resultwithoutzerosemester8);
              for($eig=0;$eig<$semester_eig;$eig++){?>
              	 <tr>
             <td width="16%" style=" text-align:center;border-right:1px solid #000;"><?php //echo $semester_tw; ?>&nbsp;</td>
             <td width="65%" class="wrapword" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
               <?php }?>
                   </table>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" align="center">

                   <?php if(!empty($count_eight)){ //if(searchsemister('8',$stud_list)==1){?>
                 <span style="border:1px solid #000; padding:0px; margin:10px;font-weight: bold;">&nbsp;&nbsp;SEMESTER 08&nbsp;&nbsp;</span>
                   <?php } ?>
                   <table style="border:1px solid;" cellpadding="1" cellspacing="1" width="100%">
                    <?php foreach($stud_list as $list){
					        if($list['semester']==8){ ?> 
                     <tr>
            <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['subject_code'];?></td>
            <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left;<?php  $strlen88=strlen($list['subject_name']); if($strlen88<49){?> padding-bottom:2.6px;  <?php }?> "><?php echo strtoupper($list['subject_name']);?></td>
           <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['credits'];?></td>
            <td width="8%" style="padding:1px;text-align:left;border-right:1px solid #000;">&nbsp;<?php echo $list['final_grade'];?></td>
            <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['cumulative_gpa'];?></td>
            <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;"><?php echo $list['exam_month'].' '.$list['exam_year']; ?></td>
            </tr>
            <?php } }?>
            <?php  if($result_eight>0){ for($ieight=0;$ieight<$result_eight;$ieight++){ ?>
             <tr>
             <td width="16%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="65%" align="left" class="wrapword" style="padding:2px;border-right:1px solid #000;
text-align: left;<?php  $strlen88=strlen($list['subject_name']); if($strlen88<49){?> padding-bottom:2.6px;  <?php }?> ">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="padding:1px;text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
            <?php } }?>

             <?php  $semester_seven=count($resultwithoutzerosemester7);
              for($sev=0;$sev<$semester_seven;$sev++){?>
              	 <tr>
             <td width="16%" style=" text-align:center;border-right:1px solid #000;"><?php //echo $semester_tw; ?>&nbsp;</td>
             <td width="65%" class="wrapword" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="8%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             <td width="20%" style="text-align:center;border-right:1px solid #000;">&nbsp;</td>
             </tr>
               <?php }?>
                   </table>
                   </div>
                  </div>
                  
   <?php } ?>
  <div class="row">
                  <div class="col-lg-12" align="center">&nbsp;</div>
                  </div>
   <table border="0" cellpadding="0" cellspacing="0" valign="top" width="100%">
        <tr>
            <td rowspan="4" width="35%" align="center"></td>
            <td><b style="font-weight:bold;font-size: 12px;padding-bottom:10px;"><?php $n="Cumulative Grade Point Average(CGPA)";  echo strtoupper($n); ?>:</b>&nbsp;<span style="font-weight:bold;font-size: 12px;">
			<?php
			$ty=0;
			foreach($stud_list as $listt){
				if(!empty($listt['cumulative_gpa'])){
				$cumup +=$listt['cumulative_gpa'];
				$ty++;
				}
			}
			//echo $cumup;echo '<br>';
			//echo $ty;echo '<br>';
			 echo number_format($cumup/$ty,2);
			 
			 ?></td>
            <td></td>
            <td rowspan="4" width="10%" align="center"></td>
          </tr>
          
          <tr>
            
            
            <td><span style=" font-size: 12px;font-weight:500;">CLASSIFICATION:</span>&nbsp;<span style="font-weight:bold; font-size: 12px;"><?php 
			$result='';
								   if(($stud_list[0]['Result']=="Honours")){
									$result="First Class With Honours";
									}else if($stud_list[0]['Result']=="Distinction") {
									$result= "First Class with Distinction";
									}else if($stud_list[0]['Result']=="First Class") {
									$result= "First Class";	
									}else if($stud_list[0]['Result']=="Second Class") {
									$result="Second Class";	
									}else if($stud_list[0]['Result']=="Third Class") {
									$result="Third Class
";	
									}
			
			echo strtoupper($result);  ?></span></td>
            
            
           
          </tr>
    
    </table>

</div>
<!--<div class="row" >
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo date('Y-m-d'); ?></div>
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:right"></div>
</div>-->
<div class="row">
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:left"></div>
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:right"></div>
</div>
<div class="row">
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:left"></div>
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:right"></div>
</div>
<div class="row">
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:left"></div>
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:right"></div>
</div>
<div class="row">
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:left"></div>
<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" style="text-align:right"></div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</body></html>
