<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Rank Certificate</title>
 <style>  
body{
    
	font-family:Monotype Corsiva, Times, Serif;
	
}

 h2{font-size: 20px;line-height: 0px;}
 
h6 {
    font-size: 15px;
    line-height: 0px;
}
 
 h3 {
    font-size: 19px;
    line-height: 0px;
}
.wt1{width:20%}
.wt{float:right;}
.clear{clear:both;}
 p{
 font-family: Monotype Corsiva, Times, Serif;
font-size:20px;
line-height:30px;
word-spacing: 8px;
text-align: justify;
}
 table {
  /*font-family: sans-serif;*/
  border-collapse: collapse;
  width: 100%;font-size:14px;line-height:24px;
}
.t{border:0px solid #fff!important}
td{
  border: 0px solid #000;
  text-align: left;
  padding: 4px;
}
 th {
  border: 0px solid #000;
  text-align: center;
  padding: 4px;
}

.prfpic{width:100px;float:right;text-align:center;border:1px solid #333}

        </style>  
</head>
<body>
<div>


<!--Header-->

<?php

//echo '<pre>';print_r($emp[0]);exit;
?>
<!--Header-->
<div>
<?php
		  $bucket_key = "uploads/student_photo/".$emp[0]['enrollment_no'].".jpg";
			$imageData = $this->awssdk->getsignedurl($bucket_key);
		?>
<img  class="prfpic" src="<?=$imageData?>" alt="" width="100" >
<p>This is to certify that</p>
<p class="center" style="text-align:center;margin:0;padding:0"><b style="margin:0;padding:0"><?= $emp[0]['stud_name'] ?> (<?= $emp[0]['enrollment_no'] ?>)</b></p>
<p>
is awarded with <strong style="font-weight: bold;"><?php if($emp[0]['rnk'] == 1){ echo 'GOLD MEDAL'; }elseif($emp[0]['rnk'] ==2){ echo 'SILVER MEDAL';}elseif($emp[0]['rnk'] == 3){echo 'BRONZE MEDAL';}?></strong> for securing the  <strong style="font-weight:bold"><?php if($emp[0]['rnk'] == 1){ echo 'FIRST'; }elseif($emp[0]['rnk'] ==2){ echo 'SECOND';}elseif($emp[0]['rnk'] == 3){echo 'THIRD';}?> </strong>position among the candidates graduated in the Degree of
<strong><?=  $emp[0]['course_name'] ?></strong> in <strong><?= $emp[0]['degree_specialization']?></strong>  programme
under the '<b><?= $emp[0]['school_name'] ?>'</b> from the <strong>Sandip University</strong>, 
<strong>Nashik </strong> in <strong><?= $emp[0]['exam_month'] ?>-<?= $emp[0]['exam_year'] ?></strong> on the basis of performance in all the Examinations held during <strong><?= $emp[0]['admission_session'] ?>-<?= $emp[0]['exam_year'] ?>.</strong>
</p>
</div>
<div>*******************************************</div>
<!--div class="clear"></div>
<br/>
<div style="width:20%;float:left;margin-bottom:20px">
<p style="text-align:left"><strong>Date:</strong></p></div>
<div style="width:60%;float:right;margin-bottom:20px" ><p style="text-align:right"><strong>CONTROLLER OF EXAMINATIONS</strong></p></div>
</div-->
</body>
</html>