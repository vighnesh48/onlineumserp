<?php
$header='';
if($report_type=="1")
$header='Hostel Fees Collection-'.$academic_year;
else if($report_type=="2")
	$header='Hostel Fees  StudentWise-'.$academic_year;
else if($report_type=="3")
	$header='Hostel Inst Statistics Fees-'.$academic_year;
else if($report_type=="4")
	$header='Hostel Outstanding Fees-'.$academic_year;
else if($report_type=="5")
	$header='Hostel Statistics Fees-'.$academic_year;
else
	$header='Hostel Fees Refund Details-'.$academic_year;
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
//echo "report_type==".$report_type;
switch($report_type){
	case "1"://for Fees detail report here
	
	?>
	<table class="content-table">
	<thead class="panel-primary">
		<tr>
			<th>#</th>
			<th>PRN/Id.</th>
			<th>Student Name</th>
			<th>Org.</th>
			<th>Inst. </th>
			<th>Course </th>
			<th>Stream </th>
			<th>Year</th>
			<th>Paid By</th>
			<th>DD/CHQ No</th>
			<th>date</th>
			<th>Bank Name</th>
			<th>Amount</th>
			<th>Fees Cancel</th>
			
			<th>Remark</th>
			<th>Admission Cancel</th>
		</tr>
		</thead>
		<tbody>
		
		<?php				
		$i=1;
			if(!empty($fees)){
				foreach($fees as $stud){
		?>
			<tr>
				<td><?=$i?></td>
				<td><?=$stud['enrollment_no_new']?></td>
				<td><?php echo $stud['first_name']." ".$stud['middle_name']." ".$stud['last_name'];?></td>
				<td><?=$stud['organisation']?></td>
				<td><?=$stud['intitute']?></td>
				<td><?=$stud['course']?></td>
				<td><?=$stud['stream']?></td>
				<td><?=$stud['year']?></td>
				<td><?=$stud['fees_paid_type']?></td>
				<td><?=$stud['ddno']?></td>
				<td><?=$stud['fdate']?></td>
				<td><?=$stud['bank_name']?></td>
				<td><?=$stud['amount']?></td>
				<td><?=$stud['chq_cancelled']?></td>
				<td><?=$stud['remark']?></td>
				<td><?=$stud['cancelled_admission']?></td>
			</tr>
		<?php
				$i++;
				}
			}else{
			   echo  '<tr><td colspan="19">Records are not found</tr>';
				
			}
			?>

		</tbody>
	</table>
	<?php  break;
	
	case "2"://for student wise fees list
	
		?>
	<table class="content-table">
	<thead>
		<tr>
			<th>#</th>
			<th>PRN/Id </th>
			<th>Student Name </th>
			<th>Mobile No</th>
			<th>Gender</th>
			<th>Org.</th>
			<th>Inst. </th>
			<th>Stream </th>
			<th>Year</th>
			<th>Deposit</th>
			<th>Hostel</th>
			<th>Exemption</th>
			<th>Gym</th>
			<th>Fine</th>
			<th>Opening Balance</th>
			<th>Applicable</th>
			<th>Paid</th>
			<th>Cancel Charges</th>
			<th>Refund</th>
			<th>Pending</th>
			<th>Cancelled</th>
			<th>Hostel</th>
			<th>R.No</th>
		</tr>
		</thead>
		<tbody>
		<?php				
		$i=1;
		$ref=0;
			if(!empty($fees)){
				foreach($fees as $stud1){
				$appl=((int)$stud1['deposit_fees']+(int)$stud1['actual_fees']+(int)$stud1['gym_fees']+(int)$stud1['fine_fees']+(int)$stud1['opening_balance'])-((int)$stud1['excemption_fees']);
		?>
			<tr>
				<td><?=$i?></td>
				<td><?=$stud1['enrollment_no']?></td>
				<td><?php echo $stud1['first_name']." ".$stud1['middle_name']." ".$stud1['last_name'];?></td>
				<td><?=$stud1['mobile']?></td>
				<td><?=$stud1['gender']?></td>
				<td><?=$stud1['organisation']?></td>
				<td><?=$stud1['intitute']?></td>
				<td><?=$stud1['stream']?></td>
				<td><?=$stud1['year']?></td>
				<td><?=$stud1['deposit_fees']?></td>
				<td><?=$stud1['actual_fees']?></td>
				<td><?=$stud1['excemption_fees']?></td>
				<td><?=$stud1['gym_fees']?></td>
				<td><?=$stud1['fine_fees']?></td>
				<td><?=$stud1['opening_balance']?></td>
				<td><?= $appl ?></td>
				<td><?=$stud1['fees_paid']?></td>
				 <td><?=$stud1['cancellation_refund']?></td>
				<td><?php 
			   // echo $stud1['cancelled_facility'];
				if($stud1['cancelled_facility']=="Y")
				{
					//$pend= $app-$stud1['fees_paid'] ;
					//echo  $refund=($appl-$stud1['cancellation_refund'])-$stud1['fees_paid'];
					$pend= $app-$stud1['fees_paid']-$stud1['cancellation_refund'];
					echo  $refund=($appl-$stud1['cancellation_refund'])-$stud1['fees_paid'];
				}
				else
				{
					//$pend=$appl-$stud1['fees_paid'];
					$pend=$appl-$stud1['fees_paid']-(int)$stud1['cancellation_refund'];
				  echo  $refund=0;
				}
				
				?></td>
				<td><?=$pend?></td>
			   
				<td><?=$stud1['cancelled_facility']?></td>
				 <td><?=$stud1['hostel_code']?></td>
				  <td><?=$stud1['room_no']?></td>
				
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
		 case "3"://for student wise fees list
		 
		?>
	<table class="content-table">
	<thead>
		<tr>
			<th width="3%">#</th>
			<th width="5%">Org. </th>
			<th width="5%">Inst. </th>
			<th width="3%">#Student</th>
			<th>Deposit</th>
			<th>Hostel</th>
			<th>Exemption</th>
			<th>Gym</th>
			<th>Fine</th>
			<th>Opening Bal.</th>
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
					$appl1=(array_sum(array_column($fees,'deposit_fees'))+array_sum(array_column($fees,'actual_fees'))+array_sum(array_column($fees,'gym_fees'))+array_sum(array_column($fees,'fine_fees'))+array_sum(array_column($fees,'opening_balance')))-(array_sum(array_column($fees,'excemption_fees')));
			
				foreach($fees as $stud1){
						$appl=((int)$stud1['deposit_fees']+(int)$stud1['actual_fees']+(int)$stud1['gym_fees']+(int)$stud1['fine_fees']+(int)$stud1['opening_balance'])-((int)$stud1['excemption_fees']);
		
		?>
			<tr>
				<td><?=$i?></td>
				<td><?=$stud1['organisation']?></td>
				<td><?=$stud1['college_name']?></td>
				<td><?=$stud1['stud_total']?></td>
				<td><?=$stud1['deposit_fees']?></td>
				<td><?=$stud1['actual_fees']?></td>
				 <td><?=$stud1['excemption_fees']?></td>
				<td><?=$stud1['gym_fees']?></td>
				<td><?=$stud1['fine_fees']?></td>
			   
				<td><?=$stud1['opening_balance']?></td>
				<td><?= $appl ?></td>
				<td><?=$stud1['fees_paid']?></td>
						   
				<td><?= $appl-$stud1['fees_paid']-$stud1['cancellation_refund'] ?></td>
				
			</tr>
		<?php
				$i++;
				}
				?>
				<tr style="font:bold">
				<th colspan="3">Total</th>
				<th><?=array_sum(array_column($fees,'stud_total'))?></th>
				<th><?=array_sum(array_column($fees,'deposit_fees'))?></th>
				<th><?=array_sum(array_column($fees,'actual_fees'))?></th>
				<th><?=array_sum(array_column($fees,'gym_fees'))?></th>
				<th><?=array_sum(array_column($fees,'fine_fees'))?></th>
				<th><?=array_sum(array_column($fees,'excemption_fees'))?></th>
				<th><?=array_sum(array_column($fees,'opening_balance'))?></th>
				<th><?=	$appl1 ?></th>
				<th><?=array_sum(array_column($fees,'fees_paid'))?></th>
				 
				<th><?= $appl1-array_sum(array_column($fees,'fees_paid')) ?></th>
				
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
		
		case "4";//for Fees detail report here
		
		?>
		 <table class="content-table">
	<thead>
	<tr>
			<th>#</th>
			<th>PRN/Id </th>
			<th>Student Name </th>
			<th>Mobile No</th>
			<th>Gender</th>
			<th>Org.</th>
			<th>Inst. </th>
			<th>Stream </th>
			<th>Year</th>
			<th>Deposit</th>
			<th>Hostel</th>
			<th>Exemption</th>
			<th>Gym</th>
			<th>Fine</th>
			<th>Opening Balance</th>
			<th>Applicable</th>
			<th>Paid</th>
				<th>Refund</th>
			<th>Pending</th>
			<th>Cancelled</th>
		</tr>
		</thead>
		<tbody>
<?php				
		$i=1;
		$ref=0;
			if(!empty($fees)){
				foreach($fees as $stud1){
				$appl=((int)$stud1['deposit_fees']+(int)$stud1['actual_fees']+(int)$stud1['gym_fees']+(int)$stud1['fine_fees']+(int)$stud1['opening_balance'])-((int)$stud1['excemption_fees']);
				$pending = $appl-($stud1['fees_paid'] + $stud1['cancellation_refund']);
				$arr_fees_paid[]=$stud1['fees_paid']; 
				$arr_cancellation_refund[]=$stud1['cancellation_refund'];
				$arr_fees_pending[]=$pending;
				$arr_appl[]=$appl;
		?>
			<tr>
				<td><?=$i?></td>
				<td><?=$stud1['enrollment_no_new']?></td>
				<td><?php echo $stud1['first_name']." ".$stud1['middle_name']." ".$stud1['last_name'];?></td>
				<td><?=$stud1['mobile']?></td>
				<td><?=$stud1['gender']?></td>
				<td><?=$stud1['organisation']?></td>
				<td><?=$stud1['intitute']?></td>
				<td><?=$stud1['stream']?></td>
				<td><?=$stud1['year']?></td>
				<td><?=$stud1['deposit_fees']?></td>
				<td><?=$stud1['actual_fees']?></td>
				   <td><?=$stud1['excemption_fees']?></td>
				<td><?=$stud1['gym_fees']?></td>
				<td><?=$stud1['fine_fees']?></td>
			 
				<td><?=$stud1['opening_balance']?></td>
				<td><?= $appl ?></td>
				<td><?=$stud1['fees_paid']?></td>
				
								  <td><?=$stud1['cancellation_refund']?></td>
				<td><?=$pending;?></td>
			  <!--  <td><?= $appl-$stud1['fees_paid'] ?></td>-->
				<td><?=$stud1['cancelled_facility']?></td>
				
			</tr>
		<?php
				$i++;
				}
				?>

			<tr>
				<td colspan="15">Total Fees</td>
				<td><h4><b><?=array_sum($arr_appl);?></h4></b></td>
				<td><h4><b><?=array_sum($arr_fees_paid);?></h4></b></td>
				<td><h4><b><?=array_sum($arr_cancellation_refund);?></h4></b></td>
				<td><h4><b><?=array_sum($arr_fees_pending);?></h4></b></td>
				 <!--td><h4><b><?=(array_sum(array_column($fees, 'applicable_total'))+array_sum(array_column($fees, 'refund')))-(array_sum(array_column($fees, 'fees_total'))-array_sum(array_column($fees, 'cancel_charges')))?></h4></b></td-->
				
			</tr>
				
				<?php
		
			}else{
				echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
			}
		
		?>
		</tbody>
	</table>
	
		
  <?php   break;
		 case "5"://for student wise fees list
		 
		?>
	<table class="content-table">
	<thead>
		<tr>
			<th width="3%">#</th>
			<th width="10%">Hostel Name </th>
			<th width="5%">Campus</th>
			<th width="5%">Area</th>
			<th width="3%">#Capacity</th>
			<th width="3%">#Increased Capacity</th>
			<th>#Allocated</th>
			<th>#Vacant</th>
			<th>Deposit</th>
			<th>Hostel</th>
			<th>Exemption</th>
			<th>Gym</th>
			<th>Fine</th>
			<th>Opening Bal.</th>
			<th>Applicable</th>
			<th>Paid</th>
			
				<th>Refund</th>
			<th>Pending</th>
		</tr>
		</thead>
		<tbody>
		<?php				
		$i=1;
		$ref=0;
			if(!empty($fees)){
					$appl1=(array_sum(array_column($fees,'deposit_fees'))+array_sum(array_column($fees,'actual_fees'))+array_sum(array_column($fees,'gym_fees'))+array_sum(array_column($fees,'fine_fees'))+array_sum(array_column($fees,'opening_balance')))-(array_sum(array_column($fees,'excemption_fees')));
			
				foreach($fees as $stud1){
						$appl=((int)$stud1['deposit_fees']+(int)$stud1['actual_fees']+(int)$stud1['gym_fees']+(int)$stud1['fine_fees']+(int)$stud1['opening_balance'])-((int)$stud1['excemption_fees']);
		
		?>
			<tr>
				<td><?=$i?></td>
				<td><?=$stud1['hostel_name']?></td>
				<td><?=$stud1['campus_name']?></td>
				<td><?=$stud1['area']?></td>
				<td><?=$stud1['actual_capacity']?></td>
				<td><?=$stud1['capacity']?></td>
				<td><?=$stud1['stud_total']?></td>
				<td><?=$stud1['capacity']-$stud1['stud_total']?></td>
				<td><?=$stud1['deposit_fees']?></td>
				<td><?=$stud1['actual_fees']?></td>
				<td><?=$stud1['excemption_fees']?></td>
				<td><?=$stud1['gym_fees']?></td>
				<td><?=$stud1['fine_fees']?></td>
				<td><?=$stud1['opening_balance']?></td>
				<td><?= $appl ?></td>
				<td><?=$stud1['fees_paid']?></td>
				   <td><?=$stud1['cancellation_refund']?></td>
				<td><?= $appl-$stud1['fees_paid']-$stud1['cancellation_refund'] ?></td>
				
			</tr>
		<?php
				$i++;
				}
				?>
				<tr style="font:bold">
				<th colspan="4">Total</th>
				<th><?=array_sum(array_column($fees,'actual_capacity'))?></th>
				<th><?=array_sum(array_column($fees,'capacity'))?></th>
				<th><?=array_sum(array_column($fees,'stud_total'))?></th>
				<th><?=array_sum(array_column($fees,'capacity'))-array_sum(array_column($fees,'stud_total'))?></th>
				<th><?=array_sum(array_column($fees,'deposit_fees'))?></th>
				<th><?=array_sum(array_column($fees,'actual_fees'))?></th>
				<th><?=array_sum(array_column($fees,'excemption_fees'))?></th>
				<th><?=array_sum(array_column($fees,'gym_fees'))?></th>
				<th><?=array_sum(array_column($fees,'fine_fees'))?></th>
				<th><?=array_sum(array_column($fees,'opening_balance'))?></th>
				<th><?=	$appl1 ?></th>
				<th><?=array_sum(array_column($fees,'fees_paid'))?></th>
				<th><?=array_sum(array_column($fees,'cancellation_refund'))?></th>
				<th><?= $appl1-array_sum(array_column($fees,'fees_paid')) ?></th>
				
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
		case "6";//for Fees detail report here
		
	?>
		<table id="example" class="content-table" width="500%">
		<thead class="panel-primary">
			<tr>
				<th>#</th>
				<th>PRN/Id.</th>
				<th>Student Name</th>
				<th>Org.</th>
				<th>Inst. </th>
				<th>Course </th>
				<th>Stream </th>
				<th>Year</th>
				<th>Paid By</th>
				<th>DD/CHQ No</th>
				<th>date</th>
				<th>Bank Name</th>
				<th>Amount</th>
				<th>Remark</th>
			</tr>
			</thead>
			<tbody>
			<?php				
			$i=1;
				if(!empty($fees)){
					foreach($fees as $stud){
			?>
				<tr>
					<td><?=$i?></td>
					<td><?=$stud['enrollment_no_new']?></td>
					<td><?php echo $stud['first_name']." ".$stud['middle_name']." ".$stud['last_name'];?></td>
					<td><?=$stud['organisation']?></td>
					<td><?=$stud['intitute']?></td>
					<td><?=$stud['course']?></td>
					<td><?=$stud['stream']?></td>
					<td><?=$stud['year']?></td>
					<td><?=$stud['fees_paid_type']?></td>
					<td><?=$stud['ddno']?></td>
					<td><?=$stud['fdate']?></td>
					<td><?=$stud['bank_name']?></td>
					<td><?=$stud['amount']?></td>
					<td><?=$stud['remark']?></td>
				</tr>
			<?php
					$i++;
					}
				}else{
				   echo  '<tr><td colspan="19">Records are not found</tr>';
					
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
	
