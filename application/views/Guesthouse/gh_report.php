<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap.min.css">

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
                                    <h4 >
                                        Report Details
                                        
                                    </h4>
                                </div>
		<div id="collapseOne1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			<div class="panel-body table-reponsive" style="width:100%;overflow:scroll;height:700px;padding:0px;">
				<?php echo $report;
				switch($report){
					case "1";//for Fees detail report here
					?>
		<table id="example1" class="table table-bordered table-responsive table-hover" width="250%">
		<thead>
			<tr>
				<th>SNo</th>
                <th>Campus</th><th>GuestHouse Name</th>
                <th>Booking ID</th>
				<th>Name </th>	
				<th>Visitor Name </th>
                <th>Mobile No </th>
				<th>NO Of Person</th>
				<th>Charges </th>
				<th>Reference Of</th>
				<th>Visiting Purpose</th>
				<th>Propose In Date</th>
				<th>Propose Out Date</th>
				<th>Current Status</th>
			</tr>
			</thead>
			<tbody>
			<?php				
			$i=1;
			$ref=0;
			$j=0;
				if(!empty($details)){
					foreach($details as $rows){
					
			?>
				<tr>
					<td><?=$i?></td><td><?php 
					if($details[$j-1]['campus'] != $details[$j]['campus']){
					echo $rows['campus'];
					} ?></td>
                    <td><?php echo $rows['guesthouse_name'];?></td>	
                    <td><?php  if($details[$j-1]['booking_id'] != $details[$j]['booking_id']){
						 echo $rows['booking_id'];
					} ?></td>
					<td><?php if($details[$j-1]['booking_name'] != $details[$j]['booking_name']){
					echo $rows['booking_name'];
					} ?></td>
					<td><?php echo $rows['visitor_name'];?></td>
                    <td><?php echo $rows['mobile'];?></td>
					<td><?=$rows['no_of_person']?></td>
					<!--<td><?=$rows['no_of_days']?></td>-->
					<td><?=$rows['charges']?></td>
					<td><?=$rows['reference_of']?></td>
					<td><?=$rows['visiting_purpose']?></td>
					<td><?=$rows['proposed_in_date']?></td>
					<td><?=$rows['proposed_out_date']?></td>
					<td><?=$rows['current_status']?></td>
				</tr>
			<?php
					$i++;
					$j++;
					}
				}else{
					echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
				}
			
			?>
			</tbody>
           </table>
	  <?php  break;
		
		case "2"://for student wise details list
			?>
		<table id="example1" class="table table-bordered table-responsive table-hover" width="250%">
		<thead>
			<tr>
				<th>SNo</th>
				<th>Visitor Name </th>
				
				<th>Gender</th>
				<th>Mobile No</th>
				<th>Id Proof</th>
				<th>Id Ref No</th>
				<th>Email </th>
				<th>Reference Of</th>
				<th>Visiting Purpose</th>
				<th>Checkin On</th>
				
			</tr>
			</thead>
			<tbody>
			<?php				
			$i=1;
			$ref=0;
				if(!empty($details)){
					foreach($details as $rows){
					
			?>
				<tr>
					<td><?=$i?></td>
					<td><?php echo $rows['visitor_name'];?></td>
					<td><?=$rows['gender']?></td>
					<td><?=$rows['mobile']?></td>
					<td><?=$rows['id_proof']?></td>
					<td><?=$rows['id_ref_no']?></td>
					<td><?=$rows['email']?></td>
					<td><?=$rows['reference_of']?></td>
					<td><?=$rows['visiting_purpose']?></td>
					<td><?=$rows['checkin_on']?></td>
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
case "3"://for student wise details list
?>
<table id="example1" class="table table-bordered table-responsive table-hover" width="120%">
	<thead>
			<tr>
				<th>SNo</th>
				<th>Guesthouse</th>
				
				<th>Campus</th>
				
				
			<th>Visitor Name</th>
			<th>Mobile</th>
			<th>No.Of Days</th>
			<th>No.Of Person</th>
			<th>Reference Of</th>
			<th>Visiting Purpose</th>
			<th>Charges_paid</th>
			</tr>
			</thead>
			<tbody>
			<?php				
			$i=1;
			$ref=0;
				if(!empty($details)){
					foreach($details as $rows){
					
			?>
				<tr>
					<td><?=$i?></td>			
					<td><?php echo $rows['guesthouse_name'];?></td>
					<td><?=$rows['campus']?></td>
					
					
					<td><?=$rows['visitor_name']?></td>
					<td><?=$rows['mobile']?></td>
					<td><?=$rows['no_of_days']?></td>
					<td><?=$rows['no_of_person']?></td>
					<td><?=$rows['reference_of']?></td>
					<td><?=$rows['visiting_purpose']?></td>
					<td><?=$rows['charges']?></td>
				</tr>
			<?php
					$i++;
					}
				}else{
					echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td></tr>";
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
				<th>Visitor Name </th>
				<th>Gender</th>
				<th>Mobile No</th>
				<th>NO Of Days</th>
				<th>NO Of Person</th>
				<th>Charges </th>
				<th>Reference Of</th>
				<th>Visiting Purpose</th>
				<th>Checkin On</th>
				<th>Checkin Out</th>
				<th>Current Status</th>
			</tr>
			</thead>
			<tbody>
			<?php				
			$i=1;
			$ref=0;
				if(!empty($details)){
					foreach($details as $rows){
					
			?>
				<tr>
					<td><?=$i?></td>
					<td><?php echo $rows['visitor_name'];?></td>
					<td><?=$rows['gender']?></td>
					<td><?=$rows['mobile']?></td>
					<td><?=$rows['no_of_days']?></td>
					<td><?=$rows['no_of_person']?></td>
					<td><?=$rows['charges']?></td>
					<td><?=$rows['reference_of']?></td>
					<td><?=$rows['visiting_purpose']?></td>
					<td><?=$rows['checkin_on']?></td>
					<td><?=$rows['checkin_out']?></td>
					<td><?=$rows['current_status']?></td>
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


<?php   break;
case "5"://for student wise details list
?>
<table id="example1" class="table table-bordered table-responsive table-hover" width="120%">
		<thead>
			<tr>
				<th>SNo</th>
				<th>Guesthouse Name</th>
				
				<th>Campus</th>
				<th>Visitor Total</th>
				<th>Charges_paid</th>
			
			</tr>
			</thead>
			<tbody>
			<?php				
			$i=1;
			$ref=0;
				if(!empty($details)){
					foreach($details as $rows){
					
			?>
				<tr>
					<td><?=$i?></td>			
					<td><?php echo $rows['guesthouse_name'];?></td>
					<td><?=$rows['campus']?></td>
					<td><?=$rows['visitor_total']?></td>
					<td><?=$rows['fees_paid']?></td>

				</tr>
			<?php
					$i++;
					}
				}else{
					echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td></tr>";
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
<script>

</script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>

