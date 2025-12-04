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
		
		<th>Old PRN </th>
		<th>PRN</th>
		<th>Student Name</th>
		<th>School </th>
		<th>Course </th>
		<th>Stream </th>
		<th>Is Partnership</th>
		<th>Partnership Code</th>
		<th>Year</th>
		<th>Paid By</th>
		<th>DD/CHQ No</th>
		<th>date</th>
		<th>Receipt No</th>
		<th>Bank Name</th>
		<th>Amount</th>
		<th>Fees Cancel</th>
		<th>Actual Fees</th>
		<th>Scholorship</th>
		<th>Applicable Fees</th>
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
			<td><?='',$stud['enrollment_no']?></td>
			<td><?php echo $stud['first_name']." ".$stud['middle_name']." ".$stud['last_name'];?></td>
			<td><?=$stud['school_short_name']?></td>
			<td><?=$stud['course_short_name']?></td>
			<td><?=$stud['stream_short_name']?></td>
			<td><?=$stud['is_partnership']?></td>
			<td><?=$stud['partnership_code']?></td>
			<td><?=$stud['year']?></td>
			<td><?=$stud['fees_paid_type']?></td>
			<td><?=$stud['ddno']?></td>
			<td><?=$stud['fdate']?></td>
			<td><?=$stud['college_receiptno']?></td>
			<td><?=$stud['bank_name']?></td>
			<td><?=$stud['amount']?></td>
			<td><?=$stud['chq_cancelled']?></td>
			<td><?=$stud['actual_fee']?></td>
			<td><?=$stud['actual_fee']-$stud['applicable_fee']?></td>
			<td><?=$stud['applicable_fee']?></td>
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
		<th>Package </th>
		<th>Old PRN </th>
		<th>PRN </th>
		<th>Student Name </th>
		<th>Mobile No </th>
		<th>Gender </th>
		<th>School </th>
		<th>Stream </th>
		<th>Is Partnership</th>
		<th>Partnership Code</th>
		<th>Year</th>
		<th>Actual Fees</th>
		<th>Scholorship</th>
		<th>Applicable</th>
		<th>Opening Balance</th>
		<th>Charges</th>
		<th>Other Fees</th>
		<th>Refund</th>
		<th>Collection</th>
		<th>Pending</th>
		<th>Admission cancel</th>
	</tr>
	</thead>
	<tbody>
	<?php				
	$i=1;
	$ref=0;$other=0;$pending=0;
		if(!empty($fees)){
			foreach($fees as $stud1){
			$other=$stud1['opening_balance']+$stud1['cancel_charges'];
			$pending=($stud1['applicable_total']+$other+$stud1['refund'])-$stud1['fees_total'];
	?>
		<tr>
			<td><?=$i?></td>
			<td><?=$stud1['belongs_to']?></td>
			<td><?=$stud1['enrollment_no_new']?></td>
			<td><?=$stud1['enrollment_no']?></td>
			<td><?php echo $stud1['first_name']." ".$stud1['middle_name']." ".$stud1['last_name'];?></td>
			<td><?=$stud1['mobile']?></td>
			<td><?=$stud1['gender']?></td>
			<td><?=$stud1['school_short_name']?></td>
			<td><?=$stud1['course']?></td>
			<td><?=$stud1['is_partnership']?></td>
			<td><?=$stud1['partnership_code']?></td>
			<td><?=$stud1['admission_year']?></td>
			<td><?=$stud1['actual_fees']?></td>
			<td><?=(int)$stud1['actual_fees']-(int)$stud1['applicable_total']?></td>
			<td><?=$stud1['applicable_total']?></td>
			<td><?=$stud1['opening_balance']?></td>
			<td><?=$stud1['cancel_charges']?></td>
			<td><?=$other?></td>
			 <td><?=$stud1['refund']?></td>
			<td><?=$stud1['fees_total']?></td>
			<td><?=	$pending?></td>
			<td><?=$stud1['cancelled_admission']?></td>
			
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
		<th width="3%">SNo</th>
		<th width="5%">School </th>
		<th width="7%">Course </th>
		<th width="15%">Stream </th>
		<th>Is Partnership</th>
		<th>Partnership Code</th>
		<th width="3%">Year</th>
		<th width="5%">#Student</th>
		<th width="15%">Actual Fees</th>
		<th width="10%">Scholorship</th>
		<th width="10%">Applicable</th>
		<th width="10%">Opening Balance</th>
		<th width="10%">Charges</th>
		<th width="10%">Other Fees</th>
		<th width="10%">Refund</th>
		<th width="10%">Collection</th>
		<th width="10%">Pending</th>
		<th width="10%">Action</th>
	</tr>
	</thead>
	<tbody>
	<?php				
	$i=1;
	$ref=0;
	$other=0;$pending=0;
		if(!empty($fees)){
			foreach($fees as $stud1){
			$other=$stud1['opening_balance']+$stud1['cancel_charges'];
			$pending=($stud1['applicable_total']+$other+$stud1['refund'])-$stud1['fees_total'];
	?>
		<tr>
			<td><?=$i?></td>
		
			<td><?=$stud1['school_short_name']?></td>
			<td><?=$stud1['course_short_name']?></td>
			<td><?=$stud1['stream_short_name']?></td>
			<td><?=$stud1['is_partnership']?></td>
			<td><?=$stud1['partnership_code']?></td>
			<td><?=$stud1['admission_year']?></td>
			<td><?=$stud1['stud_total']?></td>
			<td><?=$stud1['actual_fees']?></td>
			<td><?=(int)$stud1['actual_fees']-(int)$stud1['applicable_total']?></td>
			<td><?=$stud1['applicable_total']?></td>
			<td><?=$stud1['opening_balance']?></td>
			<td><?=$stud1['cancel_charges']?></td>
			<td><?=$other?></td>
			<td><?=$stud1['refund']?></td>
			<td><?=$stud1['fees_total']?></td>
			<td><?=$pending?></td>
			 <td><a href="<?= base_url()?>account/admission_fees_streamwise12?academic_year=2017&year=<?=$stud1['admission_year']?>&stream_id=<?=$stud1['stream_id']?>"  class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">View</a></td>

			
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
<table id="example1" class="table table-bordered table-responsive table-hover" width="250%">
<thead>
	<tr>
		<th>SNo</th>
		<th>Old PRN </th>
		<th>PRN </th>
		<th>Student Name </th>
		<th>Mobile No </th>
		<th>Gender </th>
		<th>School </th>
		<th>Stream </th>
		<th>Is Partnership</th>
		<th>Partnership Code</th>
		<th>Year</th>
		<th>Actual Fees</th>
		<th>Scholorship</th>
		<th>Applicable</th>
		<th>Opening Balance</th>
		<th>Charges</th>
		<th>Other Fees</th>
		<th>Collection</th>
		<th>Refund</th>
		<th>Pending</th>
		
	</tr>
	</thead>
	<tbody>
<?php				
	$i=1;
	$ref=0;$other=0;$pending=0;
		if(!empty($fees)){
			foreach($fees as $stud1){
			$other=$stud1['opening_balance']+$stud1['cancel_charges'];
			$pending=($stud1['applicable_total']+$other+$stud1['refund'])-$stud1['fees_total'];
?>
		<tr>
			<td><?=$i?></td>
			<td><?=$stud1['enrollment_no_new']?></td>
			<td><?=$stud1['enrollment_no']?></td>
			<td><?php echo $stud1['first_name']." ".$stud1['middle_name']." ".$stud1['last_name'];?></td>
			<td><?=$stud1['mobile']?></td>
			<td><?=$stud1['gender']?></td>
			<td><?=$stud1['school_short_name']?></td>
			<td><?=$stud1['course']?></td>
			<td><?=$stud1['is_partnership']?></td>
			<td><?=$stud1['partnership_code']?></td>
			<td><?=$stud1['admission_year']?></td>
			<td><?=$stud1['actual_fees']?></td>
			<td><?=(int)$stud1['actual_fees']-(int)$stud1['applicable_total']?></td>
			<td><?=$stud1['applicable_total']?></td>
			<td><?=$stud1['opening_balance']?></td>
			<td><?=$stud1['cancel_charges']?></td>
			<td><?=$other?></td>
			 <td><?=$stud1['fees_total']?></td>
			<td><?=$stud1['refund']?></td>
			<td><?=$pending?></td>	
			 
		</tr>
	<?php
			$i++;
			}
			?>

		<tr>
			<td colspan="17">Total Fees</td>
		
			 <td><h4><b><?=(array_sum(array_column($fees, 'applicable_total'))+array_sum(array_column($fees, 'refund')))-(array_sum(array_column($fees, 'fees_total'))-array_sum(array_column($fees, 'cancel_charges')))?></h4></b></td>
			
		</tr>
			
			<?php
	
		}else{
			echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
		}
	
	?>
	</tbody>
</table>


<?php  break;
case "5";//for Fees detail report here
?>
<table id="example" class="table table-bordered table-hover" width="500%">
<thead class="panel-primary">
	<tr>
		<th>SNo</th>
		<th>Old PRN </th>
		<th>PRN.</th>
		<th>Student Name</th>
		<th>School </th>
		<th>Course </th>
		<th>Stream </th>
		<th>Is Partnership</th>
		<th>Partnership Code</th>
		<th>Year</th>
		<th>Paid By</th>
		<th>DD/CHQ No</th>
		<th>date</th>
		<th>Receipt No</th>
		<th>Bank Name</th>
		<th>Amount</th>
		<th>Fees Cancel</th>
		<th>Actual Fees</th>
		<th>Sem wise Scholorship </th>
		<th>Sem wise Applicable Fees</th>
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
			<td><?='',$stud['enrollment_no']?></td>
			<td><?php echo $stud['first_name']." ".$stud['middle_name']." ".$stud['last_name'];?></td>
			<td><?=$stud['school_short_name']?></td>
			<td><?=$stud['course_short_name']?></td>
			<td><?=$stud['stream_short_name']?></td>
			<td><?=$stud['is_partnership']?></td>
			<td><?=$stud['partnership_code']?></td>
			<td><?=$stud['year']?></td>
			<td><?=$stud['fees_paid_type']?></td>
			<td><?=$stud['ddno']?></td>
			<td><?=$stud['fdate']?></td>
			<td><?=$stud['college_receiptno']?></td>
			<td><?=$stud['bank_name']?></td>
			<td><?=$stud['amount']?></td>
			<td><?=$stud['chq_cancelled']?></td>
			<td><?=$stud['actual_fee']/2?></td>
			<td><?=($stud['actual_fee']-$stud['applicable_fee'])/2?></td>
			<td><?=($stud['applicable_fee']/2)?></td>
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

case "6"://for student wise fees list
?>
<table id="example1" class="table table-bordered table-responsive table-hover" width="250%">
<thead>
	<tr>
		<th>SNo</th>
		<th>Old PRN </th>
		<th> PRN </th>
		<th>Student Name </th>
		<th>Mobile No </th>
		<th>Gender </th>
		<th>School </th>
		<th>Stream </th>
		<th>Is Partnership</th>
		<th>Partnership Code</th>
		<th>Year</th>
		<th>Actual Fees</th>
		<th>Sem wise Scholorship</th>
		<th>Sem wise Applicable Fees</th>
		<th>Opening Balance</th>
		<th>Charges</th>
		<th>Other Fees</th>
		<th>Refund</th>
		<th>Collection</th>
		<th>Pending</th>
		<th>Admission cancel</th>
	</tr>
	</thead>
	<tbody>
	<?php				
	$i=1;
	$ref=0;$other=0;$pending=0;
		if(!empty($fees)){
			foreach($fees as $stud1){
			$other=$stud1['opening_balance']+$stud1['cancel_charges'];
			$pending=(($stud1['applicable_total']/2)+$other+$stud1['refund'])-$stud1['fees_total'];
	?>
		<tr>
			<td><?=$i?></td>
			<td><?=$stud1['enrollment_no_new']?></td>
			<td><?=$stud1['enrollment_no']?></td>
			<td><?php echo $stud1['first_name']." ".$stud1['middle_name']." ".$stud1['last_name'];?></td>
			<td><?=$stud1['mobile']?></td>
			<td><?=$stud1['gender']?></td>
			<td><?=$stud1['school_short_name']?></td>
			<td><?=$stud1['course']?></td>
			<td><?=$stud1['is_partnership']?></td>
			<td><?=$stud1['partnership_code']?></td>
			<td><?=$stud1['admission_year']?></td>
			<td><?=$stud1['actual_fees']/2?></td>
			<td><?=((int)$stud1['actual_fees']-(int)$stud1['applicable_total'])/2?></td>
			<td><?=($stud1['applicable_total']/2)?></td>
			<td><?=$stud1['opening_balance']?></td>
			<td><?=$stud1['cancel_charges']?></td>
			<td><?=$other?></td>
			 <td><?=$stud1['refund']?></td>
			<td><?=$stud1['fees_total']?></td>
			<td><?=	$pending?></td>
			<td><?=$stud1['cancelled_admission']?></td>
			
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
case "7"://for student wise fees list
?>
<table id="example1" class="table table-bordered table-responsive table-hover" width="120%">
<thead>
	<tr>
		<th width="3%">SNo</th>
		<th width="5%">School </th>
		<th width="7%">Course </th>
		<th width="15%">Stream </th>
		<th>Is Partnership</th>
		<th>Partnership Code</th>
		<th width="3%">Year</th>
		<th width="5%">#Student</th>
		<th width="15%">Actual Fees</th>
		<th width="10%">Sem wise Scholorship</th>
		<th>Sem wise Applicable Fees</th>
		<th width="10%">Opening Balance</th>
		<th width="10%">Charges</th>
		<th width="10%">Other Fees</th>
		<th width="10%">Refund</th>
		<th width="10%">Collection</th>
		<th width="10%">Pending</th>
		<th width="10%">Action</th>
	</tr>
	</thead>
	<tbody>
	<?php				
	$i=1;
	$ref=0;
	$other=0;$pending=0;
		if(!empty($fees)){
			foreach($fees as $stud1){
			$other=$stud1['opening_balance']+$stud1['cancel_charges'];
			$pending=(($stud1['applicable_total']/2)+$other+$stud1['refund'])-$stud1['fees_total'];
	?>
		<tr>
			<td><?=$i?></td>
		
			<td><?=$stud1['school_short_name']?></td>
			<td><?=$stud1['course_short_name']?></td>
			<td><?=$stud1['stream_short_name']?></td>
			<td><?=$stud1['is_partnership']?></td>
			<td><?=$stud1['partnership_code']?></td>
			<td><?=$stud1['admission_year']?></td>
			<td><?=$stud1['stud_total']?></td>
			<td><?=$stud1['actual_fees']/2?></td>
			<td><?=((int)$stud1['actual_fees']-(int)$stud1['applicable_total'])/2?></td>
			<td><?=($stud1['applicable_total']/2)?></td>
			<td><?=$stud1['opening_balance']?></td>
			<td><?=$stud1['cancel_charges']?></td>
			<td><?=$other?></td>
			<td><?=$stud1['refund']?></td>
			<td><?=$stud1['fees_total']?></td>
			<td><?=$pending?></td>
			 <td><a href="<?= base_url()?>account/admission_fees_streamwise12?academic_year=2017&year=<?=$stud1['admission_year']?>&stream_id=<?=$stud1['stream_id']?>"  class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">View</a></td>

			
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

case "8";//for Fees detail report here
?>
<table id="example1" class="table table-bordered table-responsive table-hover" width="250%">
<thead>
	<tr>
		<th>SNo</th>
		<th>Old PRN </th>
		<th> PRN </th>
		<th>Student Name </th>
		<th>Mobile No </th>
		<th>Gender </th>
		<th>School </th>
		<th>Stream </th>
		<th>Is Partnership</th>
		<th>Partnership Code</th>
		<th>Year</th>
		<th>Actual Fees</th>
		<th>Sem wise Scholorship</th>
		<th>Sem wise Applicable Fees</th>
		<th>Opening Balance</th>
		<th>Charges</th>
		<th>Other Fees</th>
		<th>Collection</th>
		<th>Refund</th>
		<th>Pending</th>
		
	</tr>
	</thead>
	<tbody>
<?php				
	$i=1;
	$ref=0;$other=0;$pending=0;
		if(!empty($fees)){
			foreach($fees as $stud1){
			$other=$stud1['opening_balance']+$stud1['cancel_charges'];
			$pending=(($stud1['applicable_total']/2)+$other+$stud1['refund'])-$stud1['fees_total'];
?>
		<tr>
			<td><?=$i?></td>
			<td><?=$stud1['enrollment_no_new']?></td>
			<td><?=$stud1['enrollment_no']?></td>
			<td><?php echo $stud1['first_name']." ".$stud1['middle_name']." ".$stud1['last_name'];?></td>
			<td><?=$stud1['mobile']?></td>
			<td><?=$stud1['gender']?></td>
			<td><?=$stud1['school_short_name']?></td>
			<td><?=$stud1['course']?></td>
			<td><?=$stud1['is_partnership']?></td>
			<td><?=$stud1['partnership_code']?></td>
			<td><?=$stud1['admission_year']?></td>
			<td><?=$stud1['actual_fees']/2?></td>
			<td><?=((int)$stud1['actual_fees']-(int)$stud1['applicable_total'])/2?></td>
			<td><?=($stud1['applicable_total']/2)?></td>
			<td><?=$stud1['opening_balance']?></td>
			<td><?=$stud1['cancel_charges']?></td>
			<td><?=$other?></td>
			 <td><?=$stud1['fees_total']?></td>
			<td><?=$stud1['refund']?></td>
			<td><?=$pending?></td>	
			 
		</tr>
	<?php
			$i++;
			}
			?>

		<tr>
			<td colspan="17">Total Fees</td>
		
			 <td><h4><b><?=(((array_sum(array_column($fees, 'applicable_total')))/2)+array_sum(array_column($fees, 'refund')))-(array_sum(array_column($fees, 'fees_total'))-array_sum(array_column($fees, 'cancel_charges')))?></h4></b></td>
			
		</tr>
			
			<?php
	
		}else{
			echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
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


