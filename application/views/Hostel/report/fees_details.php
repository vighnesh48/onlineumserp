<script>
$(document).ready(function() {

$(".toggle-accordion").on("click", function() {
var accordionId = $(this).attr("accordion-id"),
numPanelOpen = $(accordionId + ' .collapse.in').length;

$(this).toggleClass("active");

if (numPanelOpen == 0) {
openAllPanels(accordionId);
} else {
closeAllPanels(accordionId);
}
})

openAllPanels = function(aId) {
console.log("setAllPanelOpen");
$(aId + ' .panel-collapse:not(".in")').collapse('show');
}
closeAllPanels = function(aId) {
console.log("setAllPanelclose");
$(aId + ' .panel-collapse.in').collapse('hide');
}

});
//datatable excel
$(document).ready(function() {
$('#example1').DataTable(
{
dom: 'Bfrtip',
buttons: [
'excel'
]
}
);
} );

</script>
<style>
.table{width:100%;} 
table{max-width: 100%;}
</style>
<div class="page-header">
<div class="row">
<div class="col-sm-12">
<div class="fancy-collapse-panel">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<div class="panel panel-default">
<div class="table-responsive">
<div class="panel-heading" role="tab" id="headingOne">
<h4 class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">Report Details:
</a>
</h4>
</div>
<div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
<div class="panel-body table-reponsive" style="width:100%;overflow:scroll;height:700px;padding:0px;">
<?php
switch($report_type){
case "1";//for Fees detail report here
?>
<table id="example" class="table table-bordered table-hover" width="500%">
<thead class="panel-primary">
<tr>
<th>SNo</th>
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
echo  '<tr><td colspan="19">Recordsa are not found</tr>';

}
?>

</tbody>
</table>
<?php  break;

case "2"://for student wise fees list
?>
<table id="example1" class="table table-bordered table-responsive table-hover" width="250%">
<thead>
<tr>
<th>SNo</th>
<th>PRN/Id </th>
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
<th>Deposite Bank</th>
<th>Cancel Charges</th>
<th>Refund</th>
<th>Pending</th>
<th>Cancelled</th>
<th>H-Name</th>
<th>Hostel</th>
<th>R.No</th>
<th>Is Package</th>
<th>Admission Cancelled</th>
<th>Remark</th>
</tr>
</thead>
<tbody>
<?php				
$i=1;
$ref=0;
if(!empty($fees)){
	//echo '<pre>';print_r($fees);
foreach($fees as $stud1){
	
$appl=((int)$stud1['deposit_fees']+(int)$stud1['actual_fees']+(int)$stud1['gym_fees']+(int)$stud1['fine_fees']+(int)$stud1['opening_balance'])-((int)$stud1['excemption_fees']);
?>
<tr>
<td><?=$i?></td>
<td><?=$stud1['enrollment_no_new']?></td>
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
<td><?=$stud1['bank_name']?></td>
<td><?=$stud1['cancellation_refund']?></td>
<td><?php 
// echo $stud1['cancelled_facility'];
if($stud1['cancelled_facility']=="Y")
{
$pend= $stud1['fees_paid']-$stud1['cancellation_refund'];
echo  $refund=($appl-$stud1['cancellation_refund'])-$stud1['fees_paid'];
}
else
{
	
//$pend=$appl-$stud1['fees_paid'];
$pend=($appl-$stud1['fees_paid'])+(int)$stud1['cancellation_refund'];
echo  $refund=0;
}

?></td>
<td><?=$pend?></td>

<td><?=$stud1['cancelled_facility']?></td>
<td><?=$stud1['hostel_name']?></td>
<td><?=$stud1['hostel_code']?></td>
<td><?=$stud1['room_no']?></td>
<td><?=$stud1['belongs_to']?></td>
<td><?=$stud1['cancelled_admission']?></td>
<td><?=$stud1['remark']?></td>

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
<table id="example1" class="table table-bordered table-responsive table-hover" width="120%">
<thead>
<tr>
<th width="3%">S.No</th>
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
<th><?=array_sum(array_column($fees,'excemption_fees'))?></th>
<th><?=array_sum(array_column($fees,'gym_fees'))?></th>
<th><?=array_sum(array_column($fees,'fine_fees'))?></th>
<th><?=array_sum(array_column($fees,'opening_balance'))?></th>
<th><?=	$appl1 ?></th>
<th><?=array_sum(array_column($fees,'fees_paid'))?></th>

<th><?= $appl1-array_sum(array_column($fees,'fees_paid'))-array_sum(array_column($fees,'cancellation_refund')) ?></th>

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
<table id="example1" class="table table-bordered table-responsive table-hover" width="250%">
<thead>
<tr>
<th>SNo</th>
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
	
	$appl1=(array_sum(array_column($fees,'deposit_fees'))+array_sum(array_column($fees,'actual_fees'))+array_sum(array_column($fees,'gym_fees'))+array_sum(array_column($fees,'fine_fees'))+array_sum(array_column($fees,'opening_balance')))-(array_sum(array_column($fees,'excemption_fees')));
	
foreach($fees as $stud1){
$appl=((int)$stud1['deposit_fees']+(int)$stud1['actual_fees']+(int)$stud1['gym_fees']+(int)$stud1['fine_fees']+(int)$stud1['opening_balance'])-((int)$stud1['excemption_fees']);
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
<td><?= $appl-($stud1['fees_paid'] + $stud1['cancellation_refund']) ?></td>
<!--  <td><?= $appl-$stud1['fees_paid'] ?></td>-->
<td><?=$stud1['cancelled_facility']?></td>

</tr>
<?php
$i++;
}
?>

<tr>
<td colspan="15">Total Fees</td>
<th><?=	$appl1 ?></th>
<th><?=array_sum(array_column($fees,'fees_paid'))?></th>
<th><?=array_sum(array_column($fees,'cancellation_refund'))?></th>
<th><?=$appl1 -(array_sum(array_column($fees,'fees_paid'))+array_sum(array_column($fees,'cancellation_refund')))?></th>

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
<table id="example1" class="table table-bordered table-responsive table-hover" width="120%">
<thead>
<tr>
<th width="3%">S.No</th>
<th width="10%">Hostel Name </th>
<th width="5%">Campus</th>
<th width="5%">Area</th>
<th width="3%">#Capacity</th>
<th width="3%">#Increased Capacity</th>
<th>#Allocated</th>
<th>#Vacant</th>
<th>Owner</th>
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
<td>
<?php
									$owners = get_hostel_owners($stud1['host_id']); // 👈 using helper
									if (!empty($owners)) {
									  echo "<ul class='pl-3'>";
									  foreach ($owners as $o) {
										echo "<li>
												<b>{$o['owner_name']}</b> ({$o['academic_year']}) - ₹{$o['rent_amount']}
												<br><small>{$o['from_date']} to {$o['to_date']}</small>
											  </li>";
									  }
									  echo "</ul>";
									} else {
									  echo "<em>No owners assigned</em>";
									}
								  ?>
								  </td>
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
<table id="example" class="table table-bordered table-hover" width="500%">
<thead class="panel-primary">
<tr>
<th>SNo</th>
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
<?php  break;

}
?>
</div>
</div>				
</div>
</div>
</div>
</div>
</div>   
</div>
</div>
</div>


<style>
tr.collapse.in {
display:table-row;
}

/* GENERAL STYLES */
body {

font-family: Verdana;
}

/* FANCY COLLAPSE PANEL STYLES */
.fancy-collapse-panel .panel-default > .panel-heading {
padding: 0;

}
.fancy-collapse-panel .panel-heading a {
padding: 12px 35px 12px 15px;
display: inline-block;
width: 100%;
background-color:#136fab;
color: #ffffff;
font-size: 16px;
font-weight: 200;
position: relative;
text-decoration: none;

}
.fancy-collapse-panel .panel-heading a:after {
font-family: "FontAwesome";
content: "\f147";
position: absolute;
right: 20px;
font-size: 20px;
font-weight: 400;
top: 50%;
line-height: 1;
margin-top: -10px;

}

.fancy-collapse-panel .panel-heading a.collapsed:after {
content: "\f196";
}


</style>


