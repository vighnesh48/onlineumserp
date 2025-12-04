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
.prn{font-size:15px;margin-bottom:15px;}
.idate{font-size:15px;width:100%;}
</style>
</head>


<?php
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
	$specialization ="<strong>(".$emp[0]['specialization'].")</strong>";
}else{
	$specialization ="";
}
if($emp[0]['stream_id']==165){
	$degree_type="diploma";
}else{
	$degree_type="degree";
}
if($emp[0]['stream_id']==31 || $emp[0]['stream_id']==32){
	$integrated="Integrated";
}else{
	$integrated="";
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
<?php $result='';
								   if(($emp[0]['Result']=="Honours")){
									$result="First Class With Honours";
									}else if($emp[0]['Result']=="Distinction") {
									$result= "First Class with Distinction";
									}else if($emp[0]['Result']=="First Class") {
									$result= "First Class";	
									}else if($emp[0]['Result']=="Second Class") {
									$result="Second Class";	
									}else if($emp[0]['Result']=="Third Class") {
									$result="Third Class
";	
									}else{
										$result=$emp[0]['placed_in'];
									}
									$prn = substr($emp[0]['enrollment_no'], 0, 2);
									if($prn=='16' || $emp[0]['enrollment_no']=='180106043001'){
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
			$imageData = $this->awssdk->getImageData($bucket_key);
		?>
	<div class="logo"><img src="<?=$imageData?>" width="80"></div>
	<div class="midd"><h2 style=""><em>We,<br>
the President, Vice-Chancellor<br>
and</em></h2></div>

<?php
      if(!empty($emp[0]['student_photo_path'])){
          $file_name = $emp[0]['student_photo_path'];
      }else{
        $file_name = $emp[0]['enrollment_no'];  
      }
      $new_file = explode('.', $file_name);
      $photo = (isset($new_file[1]) && !empty($new_file[1])) ? $file_name : $file_name.'.jpg';
      
      $bucket_key = 'uploads/student_photo/' . $photo;
      $bucket_name = 'erp-asset';
      $this->load->library('awssdk');
      $profile = $this->awssdk->getImageData($bucket_key);

  ?>
	<div class="prfpic"><img src="<?=$profile?>" alt="" width="100" ></div>
	
	<div class="contain">
	<h2><em>Members of the Governing Body of the Sandip University, Nashik<br />
    certify that <span style="text-decoration:underline;"><b><?=$emp[0]['stud_name']?> <? //$emp[0]['first_name']?> <? //$emp[0]['middle_name']?></b></span> having been examined<br />and found duly qualified for the <?=$integrated?> <?=$degree_type?> of	
    </em></h2>
	<h2><b><?php   echo $emp[0]['course_name']?> <br /><?php if(!empty($emp[0]['degree_specialization'])){ ?>in<br /> <?php echo $emp[0]['degree_specialization'];?></b><?php }?>
    <!--with the specialisation of <br />
	<?php // echo $specialization;?>--></h2>
	<h2 style=""><em>and placed in <span style="text-decoration:underline;"><b><?php if($emp[0]['enrollment_no'] == '180102021013'){echo 'First Class with Distinction';}else{echo $result;}?></b></span> in <?php echo ($stud_last_ex_ses);?>.<br> The said <?=$degree_type?> has been conferred on <?=$initial_3;?>.<br>In testimony whereof is set the seal of the said University.</em></h2>
	</div>
	<div class="idate"><?php //print_r($mrk_cer_date); //echo date('d-m-Y'); ?><!--<? //=$issued_date;?>--></div>
</div>
</body>
</html>

