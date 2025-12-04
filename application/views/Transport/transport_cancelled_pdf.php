<?php

$org=$student_details[0]['organisation'];
if($org=='SU')
$org='Sandip University';
else if($org=='SF')
	$org='Sandip Foundation';
else if($org=='SF-SIJOUL')
	$org='Sandip Foundation Sijoul';
else
	$org='For All Campus';

$header='';
if(isset($stud_details['cancel']))
	$header=' Cancelled';
?>
<!DOCTYPE html>
<html>
<head>
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
	<p><h3 align="center"><u><?=$org.' Transport'.$header.' Student Details for the academic year -'.$student_details[0]['academic_year']?></u></h3></p>
    </td> 
   </tr>
</table><br/>
	<table class="content-table" border="1" width="100%">
		<thead>
			<tr >
				 <th>S.No</th>
                    <th>Student PRN</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Current Year</th>
                    <th>Course</th>
                    <th>Institute</th>
                    <th>Mobile</th>
                    <th>Deposit Fee</th>
                     <th>Transport Fee</th>      
					 <th>Excemption</th>
					 <th>Applicable</th>
					 <th>Paid</th>
					 <th>Refund_paid</th>
					 <th>Cancel Charges</th>
					 <th>Remaining</th>
			</tr>
		</thead>
		<tbody id="studtbl">
		<?php
		$rowno=1;
$x=4;
for($i=0;$i<count($student_details);$i++){		 
	$applicable='';
	$remaining='';
	
    $sname = $student_details[$i]['first_name'].' '.$student_details[$i]['middle_name'].' '.$student_details[$i]['last_name'];
	$applicable=($student_details[$i]['deposit_fees']+$student_details[$i]['actual_fees']+$student_details[$i]['fine_fees'])-$student_details[$i]['excemption_fees'];
	$remaining=$student_details[$i]['paid_amt']-($student_details[$i]['refund_paid']+$student_details[$i]['cancellation_charges']);
	?>
	<tr>
	<td><?=($x-3)?></td>
	<td><?=$student_details[$i]['enrollment_no']?></td>
	<td><?=$sname?></td>
	<td><?=$student_details[$i]['gender']?></td>
	<td><?=$student_details[$i]['current_year']?></td>
	<td><?=$student_details[$i]['stream_name']?></td>
	<td><?=$student_details[$i]['school_name']?></td>
	<td><?=$student_details[$i]['mobile']?></td>
	<td><?=$student_details[$i]['deposit_fees']?></td>
	<td><?=$student_details[$i]['actual_fees']?></td>
	<td><?=$student_details[$i]['excemption_fees']?></td>
	<td><?=$applicable?></td>
	<td><?=$student_details[$i]['paid_amt']?></td>
	<td><?=$student_details[$i]['refund_paid']?></td>
	<td><?=$student_details[$i]['cancellation_charges']?></td>
	<td><?=$remaining?></td>
	</tr>
<?php
	$x++;


}

?>
		
		</tbody>
	</table>  
	<div>
	   <br><br><br>
	   <strong>Transport Coordinator Sign</strong>
	    </div>
</div>    
</body>
</html>