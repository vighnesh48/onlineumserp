<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Certificate</title>
<style> body{font-family:"Times New Roman", Times, serif}
 /*body{font-family: freeserif; }border:1px solid #333;*/ .wrapper{ width:100%;}
 .logo{width:15%;float:left;} .midd{float:left;width:65%;text-align:center;} 
 .prfpic{width:80px;float:left;text-align:center;} <?php if($emp[0]['stream_id']!=165){?>
 .contain h2,.midd h2{text-align:center;font-weight:normal;font-size:15px;margin:0;font-style:italic;} 
 .contain{height:555px; font-size:12px;} <?php }else{?> 
 .contain h2,.midd h2{text-align:center;font-weight:normal;font-size:18px;margin:0;font-style:italic;}
 .contain{height:555px; font-size:15px;} <?php }?> .prn{font-size:15px;margin-bottom:20px;} 
 .idate{font-size:15px;width:100%;} 
 .br { display: block !important; margin-bottom: -1em !important; line-height: 45px !important; } 
 /*br {display: block;margin-top: 15px;line-height: 50px;}*/ </style>

</head>
																			

<?php
if($emp[0]['gender']=="M"){
	$initial = "Mr";
	$initial_1 = "Son";
	$initial_2 = "He";
	$initial_3 = "him";
	$initial_m='हे';
}else{
	$initial = "Ms";
	$initial_1 = "Daughter";
	$initial_2 = "She";
	$initial_3 = "her";
	$initial_m='या';
}
 $sp =str_replace("--","",$emp[0]['specialization']);
if(!empty($sp)){
//if(!empty($emp[0]['specialization'])){
	$specialization ="<strong>(".$emp[0]['specialization'].")</strong>";
}else{
	$specialization ="";
}
if($emp[0]['stream_id']==165){
	$degree_type="diploma";
}else{
	//$degree_type="degree of"; // removed as per coe request of coe on 17/02/2024
	$degree_type="degree";
}
if($emp[0]['stream_id']==31 || $emp[0]['stream_id']==32 || $emp[0]['stream_id']==33 || $emp[0]['stream_id']==34){
	$integrated="Integrated";
	$integrated_m="एकात्मिक";
}else{
	$integrated="";
	$integrated_m="";
}
/*$degree_completed = explode('-', $emp[0]['degree_completed']);
if(!empty($emp[0]['issued_date'])){
 $issued_date = date('d/m/Y', strtotime($emp[0]['issued_date']));
}else{
	$issued_date='';
}

echo $sp =str_replace("--","",$emp[0]['specialization']);
if(!empty($sp)){
//if(!empty($emp[0]['specialization'])){
	$specialization =$emp[0]['specialization'];
}else{
	$specialization ="";
}*/

?>
<?php 
			$CI =& get_instance();
			$CI->load->model('Certificate_model');
			$isDrop = $this->Certificate_model->check_drop_or_not($stud_list[0]['enrollment_no']);
			$isBacklog = $this->Certificate_model->check_backlog_or_not($stud_list[0]['enrollment_no']);
			

$result='';
								    if(($emp[0]['Result']=="Honours")){
										if ($isDrop || $isBacklog) {
											$result_before="";
											$result= "First Class";	
											$result_marathi="प्रथम श्रेणीत";
										}else{
											$result="First Class With Honours";
											$result_before="सन्मानासह";
											$result_marathi="प्रथम श्रेणीत";
										}
									}else if($emp[0]['Result']=="Distinction") {
										if ($isDrop || $isBacklog) {
											$result_before="";
											$result= "First Class";	
											$result_marathi="प्रथम श्रेणीत";
										}else{
											$result= "First Class with Distinction";
											$result_before="प्रविण्यासह";
											$result_marathi="प्रथम श्रेणीत";
										}
									}else if($emp[0]['Result']=="First Class") {
									$result_before="";
									$result= "First Class";	
									$result_marathi="प्रथम श्रेणीत";
									}else if($emp[0]['Result']=="Second Class") {
									$result_before="";
									$result="Second Class";	
									$result_marathi="द्वितीय श्रेणीत";
									}else if($emp[0]['Result']=="Third Class") {
									$result_before="";	
									$result="Third Class";	
									$result_marathi="तृतीय श्रेणीत";
									}else{
									 $result=$emp[0]['placed_in'];
									}
									$prn = substr($emp[0]['enrollment_no'], 0, 2);
									if($prn=='16'){
										$enrollment_no =$emp[0]['student_prn'];
									}else{
										$enrollment_no =$emp[0]['enrollment_no'];
									}
								
								
								
								?>
<body>

<div class="wrapper">
	<div class="prn">PRN: <?=$enrollment_no?><? //$emp[0]['student_prn']?></div>
		<?php
			$bucket_key = "uploads/degree/".$emp[0]['sexam_month']."/".$emp[0]['sexam_year']."/qrcode_".$emp[0]['enrollment_no'].".png";
			$imageData = $this->awssdk->getsignedurl($bucket_key);
		?>
	<div class="logo"><img src="<?=$imageData?>" width="80"></div>														   
	<div class="midd"><h2 style=""><!--<em>We,<br>
the President, Vice-Chancellor<br>
and</em>--> <div class="br" style="padding-top:30px;">We,</div><div class="br">the President, Vice-Chancellor</div><div class="br">and</div></h2></div>
<?php
		$bucket_key = 'uploads/student_photo/'.$emp[0]['enrollment_no'].'.jpg';
    $imageData = $this->awssdk->getsignedurl($bucket_key);
  ?>
	<div class="logo"><img src="<?=$imageData?>" alt="" width="60" ></div>
	
	<div class="contain">
	<h2><em>Members of the Governing Body of the Sandip University, Nashik<br />
    certify that <span style="text-decoration:underline;"><b><?=$emp[0]['stud_name']?> <? //$emp[0]['first_name']?> <? //$emp[0]['middle_name']?></b></span><?php if($emp[0]['stream_id']==165){?><br><?php }?> having been examined<br />and found duly qualified for the <?=$integrated?> <?php if($emp[0]['stream_id']!=165){?><?=$degree_type?><?php }?> of 	
    <div class=""><b><?php   echo $emp[0]['course_name']?> </b></div><?php if(!empty($emp[0]['degree_specialization'])){ ?><div class="" style="line-height:25px !important;"><b>in</b> </div><div class="" style="line-height:25px; !important"><b><?php echo $emp[0]['degree_specialization'];?></b></div><?php }?>
    <!--with the specialisation of <br />-->
	<?php // echo $specialization;?></em></h2>
	<h2 style=""><em>and placed in <span style="text-decoration:underline;"><b><?php  if($emp[0]['enrollment_no'] == '180102021013'){echo 'First Class with Distinction';}else{echo $result;}?></b></span> in <?php echo ($stud_last_ex_ses);?>.<br /><!--<div class="br"></div>-->The said <?=$degree_type?> has been conferred on <?=$initial_3;?>.<br>In testimony whereof is set the seal of the said University.</em></h2>
	<!--<h2 style="font-size:12px;"><em>
<?php $text=""; 
//echo htmlspecialchars($get_marathi[0]['marathi_text'], ENT_NOQUOTES, "UTF-8");
//echo $get_marathi[0]['marathi_text'];
?>आम्ही,<br />अध्यक्ष, कुलगुरू आणि नियमन परिषदेचे सदस्य संदिप विदयापीठ, नाशिक<br />
 <b>अभियांत्रिकी स्नातक अंतर्गत <?php echo $emp[0]['course_name_marathi'];?> ही पदवी <?php echo $emp[0]['exam_month_marathi'];?> </b>
 मधील परिक्षेत <b><?php echo $result_marathi;?> </b>उत्तीर्ण झाल्याबद्दल <b><?php echo $emp[0]['marathi_name'];?></b> यांना हि पदवी प्रदान करण्यात येत आहे.<br />
  ज्याच्या साक्षीत वरील विदयापीठाचा शिक्का आहे.
</b></em></h2>-->
<?php if($emp[0]['stream_id']!=165){?>
<p style="font-style: italic; font-size: 11px;text-align: center;"><em><strong> 
आम्ही,<br /> संदीप विद्यापीठ नाशिकचे अध्यक्ष, कुलगुरु आणि नियामक मंडळाचे सदस्य प्रमाणित करतो की,<br />
 </strong><b style="font-size: 13px;">
 <?php echo $emp[0]['marathi_name'];?> </b> 
 <span style="font-style: italic;font-size: 10px;text-align: center;">&nbsp;&nbsp;&nbsp;<em><strong>
 <?php echo $initial_m;?>&nbsp;&nbsp;</strong></em></span> <b style="font-size: 12px;">
 <?php echo $emp[0]['exam_month_marathi'];?> </b><strong>मधील<br /> 
 <b style="font-size: 12px;"><?php echo $emp[0]['course_name_marathi'];?> <?php if(!empty($emp[0]['degree_specialization'])){ ?><br />
 इन <br /><?php echo $emp[0]['stream_name_marathi'];?><?php } ?></b><br />
 परीक्षेत <?php if($emp[0]['enrollment_no'] == '180102021013'){echo 'प्रविण्यासह';}else{echo $result_before;}?> </strong><b style="font-size: 13px;">
 <?php echo $result_marathi;?></b><strong> उत्तीर्ण झाल्याबद्दल त्यांना ही <?=$integrated_m?> पदवी प्रदान करण्यात येत आहे. 
 <br /> त्याची साक्ष म्हणून विद्यापीठाची अधिकृत मुद्रा येथे अंकीत करण्यात येत आहे. </strong> </em></p>

<?php }?>
    </div>
	<div class="idate"><?php //print_r($mrk_cer_date); //echo date('d-m-Y'); ?><!--<? //=$issued_date;?>--></div>
</div>

</body>
</html>

