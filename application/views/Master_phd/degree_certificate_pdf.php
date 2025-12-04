<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Certificate</title>
<style>
body{font-family:"Times New Roman", Times, serif}
.wrapper{ width:100%;}
.logo{width:15%;float:left;}
.midd{float:left;width:65%;text-align:center;}
.prfpic{width:100px;float:left;text-align:center;border:1px solid #333;}
.contain h2,.midd h2{text-align:center;font-weight:normal;font-size:18px;margin:0;font-style:italic;}
	.contain{height:555px;}
.prn{font-size:15px;margin-bottom:20px;}
.idate{font-size:15px;width:100%;}
</style>
</head>


<?php
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
	$specialization ="<strong>(".$emp[0]['specialization'].")</strong>";
}else{
	$specialization ="";
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
<body>

<div class="wrapper">
	<div class="prn">PRN: <?=$emp[0]['enrollment_no']?><? //$emp[0]['student_prn']?></div>
	<div class="logo"><img src="<?=base_url()?>uploads/degree/<?php echo $emp[0]['sexam_month']; ?>/<?php echo $emp[0]['sexam_year']; ?>/qrcode_<?=$emp[0]['enrollment_no']?>.png" width="80"></div>
	<div class="midd"><h2 style=""><em>We,<br>
the President, Vice-Chancellor<br>
and</em></h2></div>
	<?php
        $bucket_key = 'uploads/student_photo/'.$emp[0]['enrollment_no'].'.jpg';
        $imageData = $this->awssdk->getImageData($bucket_key);
    ?>
	<div class="prfpic"><img src="<?=$imageData?>" alt="" width="100" ></div>
	
	<div class="contain">
	<h2><em>Members of the Governing Body of the Sandip University, Nashik<br />
    certify that <span style="text-decoration:underline;"><b><?=$emp[0]['stud_name']?> <? //$emp[0]['first_name']?> <? //$emp[0]['middle_name']?></b></span> having been examined<br />and found duly qualified for the degree of	
    </em></h2>
	<h2><b><?php   echo $emp[0]['course_name']?><br />in<br /> <?php echo $emp[0]['degree_specialization'];//$emp[0]['gradesheet_name'];?></b>
    <!--with the specialisation of <br />
	<?php //echo $specialization;?>--></h2>
	<h2 style=""><em>and placed in <span style="text-decoration:underline;"><b><?php echo $emp[0]['Result'];?></b></span> in <?php echo ucfirst( $emp[0]['sexam_month']).' '.$emp[0]['sexam_year'];?>.<br> The said degree has been conferred on him.<br>In testimony whereof is set the seal of the said University.</em></h2>
	</div>
	<div class="idate"><?php echo date('d-m-Y'); ?><!--<? //=$issued_date;?>--></div>
</div>
</body>
</html>

