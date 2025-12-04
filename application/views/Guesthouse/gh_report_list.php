  
		
			<div class="panel-body table-reponsive" style="width:100%;overflow:scroll;height:700px;padding:0px;">
			<div class="row">&nbsp;</div>
				<?php // echo $report;
				switch($report){
					case "1";//for Fees detail report here
					?>
		<table id="example1" class="table table-bordered table-responsive table-hover" >
		<thead>
			<tr>
				<th>SNo</th>
                <th>Campus</th>
                <th>GuestHouse Name</th>
                <th>Booking ID</th>
				<th>Name </th>	
				<th>Visitor Name </th>
                <th>Mobile No </th>
                <th>Room No</th>
                <th>Bed No </th>
				<th>NO Of Person</th>
				<th>NO Of Days</th>
				<th>Charges </th>
                <th>Payment&nbsp;Mode </th>
                <th>Receipt&nbsp;No</th>
                <th>Challan&nbsp;No</th>
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
if($rows['location']!='T'){
						$rm = explode('_', $rows['location']);
					}else{
						$rm='';
					}
					
			?>
				<tr>
					<td>
					<?php
					if($details[$j-1]['booking_id'] != $details[$j]['booking_id']){
						echo $i;
					} ?></td><td><?php 
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
                    <td><?php echo $rows['vis_mobile'];?></td>
                    <td><?php echo $rm[2];?></td>
                    <td><?php echo $rows['bed_no'];?></td>
                    <?php if($details[$j-1]['booking_name'] != $details[$j]['booking_name']){ 
$tot_per[]=$rows['no_of_person'];
					$tot_char[]=$rows['charges'];
                    	?>
					<td><?=$rows['no_of_person']?></td>
					<td><?=$rows['no_of_days']?></td>
					<td><?=$rows['charges']?></td>
                    <td><?=$rows['mode_of_payment']?> </td>
                    <td><?=$rows['receipt_no']?></td>
                    <td><?=$rows['challan_No']?></td>
					<td><?=$rows['reference_of']?></td>
					<td><?=$rows['visiting_purpose']?></td>
					<td><?=$rows['proposed_in_date']?></td>
					<td><?=$rows['proposed_out_date']?></td>
					<?php }else{ ?>
	                 <td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
<td></td><td></td><td></td>
<?php } ?>
					<td><?=$rows['current_status']?></td>
				</tr>
			<?php
			if($details[$j-1]['booking_id'] != $details[$j]['booking_id']){
					$i++;
				}
					$j++;
					}
				}else{
					echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
				}
			
			?>
			<tr>
				<td><b>Total:-</b></td><td></td>
				<td></td><td></td>
				<td></td><td></td>
				<td></td><td></td>
				<td></td><td><b><?php echo array_sum($tot_per); ?></b></td>
				<td></td><td><b><?php echo array_sum($tot_char); ?></b></td><td></td><td></td><td></td>
				<td></td><td></td>
				<td></td><td></td>
<td></td>
			</tr>
			</tbody>
           </table>
	  <?php  break;
		
		case "2"://for student wise details list
			?>
		<table id="example1" class="table table-bordered table-responsive table-hover" width="100%">
		<thead>
			<tr>
				<th>SNo</th>
                <th>Campus</th>
                <th>GuestHouse Type</th>				
				<th>No of Booking</th>
				<th>Booking Done</th>
				<th>Cancelled</th>
		
			</tr>
			</thead>
			<tbody>
			<?php 
//print_r($details); 
			$i=1;
foreach ($details as $key => $value) {
	# code...
foreach ($value as $key1 => $val) {
	# code...


			?>
				<tr>
					<td><?=$i?></td>
					<td><?=$key?></td>
					<td><?php if($key1=='H'){ echo 'Hostel'; }else{ echo 'Trustee';} ?></td>
					<td><?=$val['BOOKING-DONE']+$val['CANCELLED']?></td>
					<td><?=$val['BOOKING-DONE']?></td>
					<td><?=$val['CANCELLED']?></td>
					
					
				</tr>
				<?php $i++; }  }?>
			
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
                                  
    
            
   
<style>


</style>
<script>
$('#example1').DataTable( {
        dom: 'Bfrtip',
         targets: 'no-sort',
bSort: false,
     "bPaginate": false,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Guesthouse Report'
            }
        ]
    } );

</script>

