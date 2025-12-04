<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Certificate</title>
<style>
body{font-family:"Times New Roman", Times, serif; background:url('https://erp.sandipuniversity.com/assets/images/sucertificate.jpg') no-repeat center top; background-size:595px 100%;}
.wrapper{ width: 510px;
    margin: 135px auto 0 auto;
}
.logo{width:15%;float:left;}
.midd{float:left;width:65%;text-align:center;}
.prfpic{width:80px;float:left;text-align:center;border:1px solid #333;}
.contain h2,.midd h2{text-align:center;font-weight:normal;font-size:18px;margin:0;font-style:italic;line-height:30px;}
	.contain{height: 860px;}
.prn{font-size: 15px;
    margin-bottom: 5px;
    padding-top: 27px;
}
.idate{font-size:15px;width:100%;padding-top:57px;
    padding-left: 5px;}
</style>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
    $(this).bind("contextmenu", function(e) {
        e.preventDefault();
    });
}); 
</script>
<script type="text/JavaScript"> 
    function killCopy(e){ return false } 
    function reEnable(){ return true } 
    document.onselectstart=new Function ("return false"); 
    if (window.sidebar)
    { 
        document.onmousedown=killCopy; 
        document.onclick=reEnable; 
    } 
</script>
</head>


<?php
$degree_completed = explode('-', $emp[0]['degree_completed']);
if(!empty($emp[0]['issued_date'])){
 $issued_date = date('d/m/Y', strtotime($emp[0]['issued_date']));
}else{
	$issued_date='';
}
if($emp[0]['gender']=="M"){
	$initial = "Mr";
	$initial_1 = "Son";
	$initial_2 = "He";
}else{
	$initial = "Ms";
	$initial_1 = "Daughter";
	$initial_2 = "She";
}
$sp =str_replace("--","",$emp[0]['specialization']);
if(!empty($sp)){
//if(!empty($emp[0]['specialization'])){
	$specialization =$emp[0]['specialization'];
}else{
	$specialization ="";
}

$result='';
								    if(($emp[0]['placed_in']=="Honours")){
									$result="First Class With Honours";
									$result_before="सन्मानासह";
									$result_marathi="प्रथम श्रेणीत";
									}else if($emp[0]['placed_in']=="Distinction") {
									$result= "First Class with Distinction";
									$result_before="प्रविण्यासह";
									$result_marathi="प्रथम श्रेणीत";
									}else if($emp[0]['placed_in']=="First Class") {
									$result_before="";
									$result= "First Class";	
									$result_marathi="प्रथम श्रेणीत";
									}else if($emp[0]['placed_in']=="Second Class") {
									$result_before="";
									$result="Second Class";	
									$result_marathi="द्वितीय श्रेणीत";
									}else if($emp[0]['placed_in']=="Third Class") {
									$result_before="";	
									$result="Third Class";	
									$result_marathi="तृतीय श्रेणीत";
									}else{
									 $result=$emp[0]['placed_in'];
									}


?>
<body>

<div class="wrapper">
	<div class="prn">PRN: <?=$emp[0]['student_prn']?></div>
	<div class="logo"><img src="<?=base_url()?>uploads/degree/<?=$emp[0]['degree_completed']?>/qrcode_<?=$emp[0]['enrollment_no']?>.png" width="60"></div>
	<div class="midd"><h2 style=""><em>We,<br>
the President, Vice-Chancellor<br>
and</em></h2></div>
	<div class="prfpic"><img src="<?=base_url()?>uploads/student_photo/<?=$emp[0]['enrollment_no']?>.jpg" alt="" width="80" ></div>
	
	<div class="contain">
	<h2><em>Members of the Governing Body of the Sandip University, Nashik<br />
    certify that <span style="text-decoration:underline;"><b><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></b></span> having been examined<br />and found duly qualified for the degree of	
    </em></h2>
	<h2><b><?=$emp[0]['course_name']?><br />in<br /> <?=$emp[0]['degree_specialization']?></b><br /><!--with the specialisation of <br />
	<?=$specialization;?>--></h2>
	<h2 style=""><em>and placed in <span style="text-decoration:underline;"><b><?=$result;?></b></span> in <?php echo ($stud_last_ex_ses);?><?php //ucfirst($degree_completed[0]).' '.$degree_completed[1];?>.<br> The said degree has been conferred on 
	
	<?php 
	$initial_m='';
	if($emp[0]['gender']=='M'){
		echo "him";
		$initial_m='हे';
	}
	else{
		echo "her";
		$initial_m='या';
	}
	 ?>
	.<br>In testimony whereof is set the seal of the said University.</em></h2>
	
	<h2 style="font-style: italic; font-size: 11px;text-align: center;"><em><strong>
आम्ही,<br />
संदीप विद्यापीठ नाशिकचे अध्यक्ष, कुलगुरु आणि नियामक मंडळाचे सदस्य प्रमाणित करतो की,<br />
</strong><b style="font-size: 13px;"><?php echo $emp[0]['marathi_name'];?> </b>
<span style="font-style: italic;font-size: 10px;text-align: center;">&nbsp;&nbsp;&nbsp;<em><strong><?php echo $initial_m;?>&nbsp;&nbsp;</strong></em></span>
<b style="font-size: 12px;"><?php echo $emp[0]['exam_month_marathi'];?> </b><strong>मधील<br />
<b style="font-size: 12px;"><?php echo $emp[0]['course_name_marathi'];?> <?php if(!empty($emp[0]['degree_specialization'])){ ?><br />इन <br /><?php echo $emp[0]['stream_name_marathi'];?><?php } ?></b><br />
परीक्षेत <?php echo $result_before;?> </strong><b style="font-size: 13px;"><?php echo $result_marathi;?></b><strong> उत्तीर्ण झाल्याबद्दल त्यांना ही पदवी प्रदान करण्यात येत आहे. <br />
त्याची साक्ष म्हणून विद्यापीठाची अधिकृत मुद्रा येथे अंकीत करण्यात येत आहे. </strong> 
</em></h2>
	
	<div class="idate"><?=$issued_date;?></div>
	</div>
	
</div>
</body>
</html>

