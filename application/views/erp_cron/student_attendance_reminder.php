<!DOCTYPE html>
<html>
<head>
	<link href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
<script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js'></script>
<script src='//code.jquery.com/jquery-1.11.1.min.js'></script>
<!------ Include the above in your HEAD tag ---------->

<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
<script src='http://getbootstrap.com/dist/js/bootstrap.min.js'></script>
<style>
	
td 
{
	height: 30px; 
	width: 30px;
}

#cssTable td 
{
	text-align: center; 
	vertical-align: middle;
}
#cssTable th 
{
	text-align: center; 
	vertical-align: middle;
	padding: 10px;
}
</style>
</head>
<body>

 <div class='table-responsive'>
 	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td align="center">
    <img src="http://sandipuniversity.com/erp/assets/images/logo_form.png" width="300" />
    <p style="margin-top:0"><strong>Mahiravani, Trimbak Road, Nashik – 422 213,</strong><br> 

    </td>
  </tr>
</table>
<div style="text-align:center;color:red;padding-top:5px;padding-bottom:0px;font-size:15px;"><b>Daily Attendance Not Mark Report</b></div>

<div style="text-align:center;color:red;padding-top:0px;padding-bottom:0px;"><b><?=$school_name?></b></div>
<?php //print_r($courses);  exit;?>

	<table id="cssTable" width="100%" style="align:center;" border="1" cellspacing="0" cellpadding="0">
	<tr> <td colspan="1" align="center"><h4><b><?php echo $rdate; ?></b></h4></td><td colspan="3"></td><td colspan="1" align="center"><?=$rday?></td></tr>
	<?php foreach($courses as $ckey =>$crs){ 

		foreach($crs['stream'] as $skey=> $semv){
			foreach ($semv['semsis'] as $dkey => $dval) {
				//print_r($dval);
			foreach ($dval['divis'] as $divk => $divv) { ?>
				
	<tr style="background:#6BCEEF;"> <td colspan="5" align="left" style="padding:10px;">&nbsp;<b>Class: </b>&nbsp;<?=$skey?>&nbsp; | &nbsp;<b>SEM:</b>&nbsp;<?=$dkey?>&nbsp;|&nbsp; <b>DIVISION:</b>&nbsp;<?=$divk?></td></tr>

<tr style="background:#D2D2D2;"> <th align="center" ><b>Sr.no</b></th><th  align="center"><b>Subject Name</b></th><th  align="center"><b>Type</b></th><th  align="center"><b>Slot</b></th><th  align="center"><b>Faculty Name</b></th></tr>
<?php
$acnt = count($divv);
if($acnt>0){
$i=1;
foreach ($divv as $fack => $facv) {
	//echo $facv;
$ex_fac = explode("/", $facv);
if($ex_fac[1]=='TH'){
								$stype="TH";
							}else{
								$stype="PR";
							} ?>
<tr> <td align="center"><?=$i?></td><td  align="left">&nbsp;<?=$ex_fac[0]?></td><td  align="center"><?=$stype?></b></td><td  align="left">&nbsp;<?=$ex_fac[2]?></td><td  align="left">&nbsp;<?php  if($ex_fac[3]!=''){ echo $ex_fac[3]; if($ex_fac[4]!=''){ echo "<br/>"; echo "<span style='color:red'><b>".$ex_fac[4]."</b></span>"; } }else{ echo 'Not Assign'; } ?></td></tr>
<?php
$i++;
}
}else{ ?>
	<tr> <td colspan="5" align="center">No Data Found </td></tr>
<?php
}
}
}
}// end of sem
}//end of crs
	 //}
?>
	</table>

</div>

</body>
</html>
