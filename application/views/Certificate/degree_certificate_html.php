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
	.contain{height:550px;}
.prn{font-size:15px;margin-bottom:20px;}
.idate{font-size:15px;width:100%;padding-top:57px;
    padding-left: 5px;}
</style>
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
	$initial_3 = "him";
}else{
	$initial = "Ms";
	$initial_1 = "Daughter";
	$initial_2 = "She";
	$initial_3 = "her";
}
$sp =str_replace("--","",$emp[0]['specialization']);
if(!empty($sp)){
//if(!empty($emp[0]['specialization'])){
	$specialization =$emp[0]['specialization'];
}else{
	$specialization ="";
}

?>
<body>

<div class="wrapper">
	<div class="prn">PRN: <?=$emp[0]['student_prn']?></div>
	<?php
			$bucket_key = "uploads/degree/".$emp[0]['sexam_month']."/".$emp[0]['sexam_year']."/qrcode_".$emp[0]['enrollment_no'].".png";
			$imageData = $this->awssdk->getImageData($bucket_key);
		?>
	<div class="logo"><img src="<?=$imageData?>" width="60"></div>
	<div class="midd"><h2 style=""><em>We,<br>
the President, Vice-Chancellor<br>
and</em></h2></div>
	<div class="prfpic"><img src="<?=base_url()?>uploads/student_photo/<?=$emp[0]['enrollment_no']?>.jpg" alt="" width="80" ></div>
	
	<div class="contain">
	<h2><em>Members of the Governing Body of the Sandip University, Nashik<br />
    certify that <span style="text-decoration:underline;"><b><?=$emp[0]['stud_name']?></b></span> having been examined<br />and found duly qualified for the degree of	
    </em></h2>
	<h2><b><?=$emp[0]['course_name']?><br />in<br /> <?=$emp[0]['specialization']?></b><br /><!--with the specialisation of <br />
	<?=$specialization;?>--></h2>
	<h2 style=""><em>and placed in <span style="text-decoration:underline;"><b><?=$emp[0]['placed_in'];?></b></span> in <?=ucfirst($degree_completed[0]).' '.$degree_completed[1];?>.<br> The said degree has been conferred on <?=$initial_3?>.<br>In testimony whereof is set the seal of the said University.</em></h2>
	<div class="idate">20/12/2018<!--<?=$issued_date;?>--></div>
	</div>
	
</div>
</body>
</html>

