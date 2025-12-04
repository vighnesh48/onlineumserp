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
echo $sp =str_replace("--","",$emp[0]['specialization']);
if(!empty($sp)){
//if(!empty($emp[0]['specialization'])){
	$specialization ="<strong>(".$emp[0]['specialization'].")</strong>";
}else{
	$specialization ="";
}

?>
<style type="text/css">
body{ font-family: "Times New Roman", Times, serif;font-size: 17px;line-height:30px;}
p{line-height:30px;text-align:center;}
</style>
    <body>	
	<div style="border:0px solid black;height:240px;">
	<p>This is to certify that <?=$initial?> <strong><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></strong> <br>
		with PRN <strong><?=$emp[0]['student_prn']?></strong> <?=$initial_1?> of Shri <strong><?=$emp[0]['father_lname']?> <?=$emp[0]['father_fname']?> <?=$emp[0]['father_mname']?></strong> <br>
		passed <strong><?=$emp[0]['gradesheet_name']?></strong> <?=$specialization;?> Programme examination held 
by this University in the month of <strong><?=$degree_completed[0].'-'.$degree_completed[1];?></strong> <?=$initial_3?> was placed in <strong><?=$emp[0]['placed_in'];?></strong><br>
<?=$initial_3?> has satisfied all requirements for the award of final Degree certification of <br>Sandip 
University, Nashik.
</p>
</div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:1px;">
  <tr>
    <td height="100" valign="bottom" ><strong><?=$issued_date;?></strong></td>
    
  </tr>
</table>
  </body>
