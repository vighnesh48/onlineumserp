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
case "2"://for student wise fees list
?>
<table id="example1" class="table table-bordered table-responsive table-hover" width="250%">
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

case "4"://for Fees detail report here
?>
<table id="example1" class="table table-bordered table-responsive table-hover" width="250%">
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


