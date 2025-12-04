<?php
$header='';
$academic_year=$fees[0]['academic_year'];
if($report_type=="2")
	$header='Competitive Exam Fees Details Student Wise - '.$academic_year;
else if($report_type=="4")
	$header='Competitive Exam Fees Out Standing Details - '.$academic_year;

//echo 'h======='.$header;
?>

	
<!DOCTYPE html>
<html>
<head>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>  
            table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:14px; xmargin:0 auto;
            }  
			td{vertical-align: top;}
                      
            .signature{
            text-align: center;
            }
            .marks-table{
            width: 100%;xxheight:650px;
            }
            p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
            .marks-table td{height:30px;vertical-align:middle;}
            .marks-table th{height:30px;}
            xxcontent-table tr td{border:1px solid #333;vertical-align:middle;}
			xxx.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
			.content-table td,.content-table th{padding:4px;font-size:15px;}
        </style>  

</head>
<body>
<div class="m" style="padding:20px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td align="center" style="border-bottom:1px solid #000"><img src="https://sandipuniversity.com/admission/assets/images/logo.png" />
		<p class="ps">Trimbak Road, Mahiravani, Nashik – 422 213</p>
		<p class="ps">www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in </p>
		<p class="ps"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></p>
		
		</td> 
	   </tr>         
	</table>
	<br/><br/>
	<table>
     <tr>
	<td valign="middle" align="center" class="hd" width="200">
	<p><h3 align="center"><u><?=$header?></u></h3></p>
    </td> 
   </tr>
</table>
<br/>

<?php
switch($report_type){
case "2"://for student wise fees list
?>
<table class="table">
<thead>
	<tr>
		<th>SNo</th>
		<th>Reg No</th>
		<th>Student Name </th>
		<th>Mobile No</th>
		<th>Gender</th>
		<th>Org.</th>
		<th>Entrance Type</th>
		<th>Applicable</th>
		<th>Paid</th>
		<th>Pending</th>
	</tr>
	</thead>
	<tbody>
	<?php				
	$i=1;
	$ref=0;
		if(!empty($fees)){
			foreach($fees as $stud1){
			$appl=((int)$stud1['applicable_fees']);
	?>
		<tr>
			<td><?=$i?></td>
			<td><?=$stud1['reg_no']?></td>
			<td><?=$stud1['student_name']?></td>
			<td><?=$stud1['student_mobileno']?></td>
			<td><?=$stud1['gender']=='M'?'Male':'Female'?></td>
			<td><?=$stud1['student_org']?></td>
			<td><?=$stud1['entrance_type']?></td>
			<td><?= $appl ?></td>
			<td><?=(!empty($stud1['fees_paid']))?$stud1['fees_paid']:0?></td>
			<?php $pend=$appl-$stud1['fees_paid'];?>
			<td><?=$pend?></td>	
		</tr>
	<?php
			$i++;
			}
		}else{
			echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
		}
	
	?>
	</tbody>
</table>

<?php
break;

case "4";//for Fees detail report here
?>
<table class="table">
<thead>
<tr>
		<th>SNo</th>
		<th>Reg No</th>
		<th>Student Name </th>
		<th>Mobile No</th>
		<th>Gender</th>
		<th>Org.</th>
		<th>Entrance Type</th>
		<th>Applicable</th>
		<th>Paid</th>
		<th>Pending</th>
	</tr>
	</thead>
	<tbody>
<?php				
	$i=1;
	$ref=0;
		if(!empty($fees)){
			foreach($fees as $stud1){
			$appl=((int)$stud1['applicable_fees']);
	?>
		<tr>
			<td><?=$i?></td>
			<td><?=$stud1['reg_no']?></td>
			<td><?=$stud1['student_name']?></td>
			<td><?=$stud1['student_mobileno']?></td>
			<td><?=$stud1['gender']=='M'?'Male':'Female'?></td>
			<td><?=$stud1['student_org']?></td>
			<td><?=$stud1['entrance_type']?></td>
			<td><?= $appl ?></td>
			<td><?=(!empty($stud1['fees_paid']))?$stud1['fees_paid']:0?></td>
			<?php $pend=$appl-$stud1['fees_paid'];?>
			<td><?=$pend?></td>	
		</tr>
	<?php
			$i++;
			}
						$appl1=(array_sum(array_column($fees,'applicable_fees')));
			?>

		<tr>
			<td colspan="9"><h4><b>Total Fees</h4></b></td>
		
			 <td><h4><b><?=$appl1-array_sum(array_column($fees,'fees_paid'))?></h4></b></td>
			
		</tr>
			
			<?php
	
		}else{
			echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
		}
	
	?>
	</tbody>
</table>

<?php
break;

}
?>
</div>    
</body>
</html>
