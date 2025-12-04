<?php
//print_r($emp);
if($emp[0]['gender']=="M"){
	$initial = "Mr";
	$initial_1 = "Son";
	$initial_2 = "He";
}else{
	$initial = "Ms";
	$initial_1 = "Daughter";
	$initial_2 = "She";
}
/* $sp =str_replace("--","",$emp[0]['specialization']);
if(!empty($sp)){
//if(!empty($emp[0]['specialization'])){
	$specialization ="<strong>(".$emp[0]['specialization'].")</strong>";
}else{
	$specialization ="";
}*/

/*$degree_completed = explode('-', $emp[0]['degree_completed']);
if(!empty($emp[0]['issued_date'])){
 $issued_date = date('d/m/Y', strtotime($emp[0]['issued_date']));
}else{
	$issued_date='';
}

echo $sp =str_replace("--","",$emp[0]['specialization']);
if(!empty($sp)){
//if(!empty($emp[0]['specialization'])){
	$specialization ="<strong>(".$emp[0]['specialization'].")</strong>";
}else{
	$specialization ="";
}*/

?><?php $result='';
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
									}
								
								?>
<style type="text/css">
body{ font-family: "Times New Roman", Times, serif;font-size: 17px;line-height:30px;}
p{line-height:30px;text-align:center;}
</style>
    <body>	
	<div style="border:0px solid black;height:240px;">
	<p>This is to certify that <?=$initial?> <strong><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></strong> <br>
		with PRN <strong><?=$emp[0]['nenrollment_no']?></strong> <?=$initial_1?> of Shri <strong><?=$emp[0]['father_lname']?> <?=$emp[0]['father_fname']?> <?=$emp[0]['father_mname']?></strong> <br>
		passed <strong> <?php echo $emp[0]['degree_specialization'];?></strong>  Programme examination held 
by this University in the month of <strong><?=$emp[0]['sexam_month'].'-'.$emp[0]['sexam_year'];?></strong> <?=$initial_3?> was placed in <strong><?=$result;?></strong><br>
<?=$initial_3?> has satisfied all requirements for the award of final Degree certification of <br>Sandip 
University, Nashik.
</p>
</div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:1px;">
  <tr>
    <td height="100" valign="bottom" ><strong><?php print_r($mrk_cer_date); // echo date('d-m-Y') //$issued_date;?></strong></td>
    
  </tr>
</table>
  </body>
