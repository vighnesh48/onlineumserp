<script> 
$('#yourTableId').DataTable({
    paging: false // disables pagination
});
//datatable excel
$(document).ready(function() {
$('#table2excel').DataTable(
{
dom: 'Bfrtip',
 paging: false, 
buttons: [
'excel'
]
}
);
} );
</script>
<?php
unset($z); unset($j);
$z=1;$j=1; 
if( isset($_POST['cancel']) && $_POST['cancel']=="cancel" )
{

	if(count($student_list)>0)
		{
		   //    var_dump($student_list);
		   //    exit();
			?>
			<style>
			.table-info thead th, .table-info thead tr{background: #774545;border-color:#FFFFFF !important}
			</style>
			
			<form>
			<table class="table table-bordered" id="table2excel">
				<thead>
					<tr style="">
					<!--<th class="noExl"><input type="checkbox" name="ckbCheckAll1" id="ckbCheckAll1"></th>-->
						 <th>Sr No</th>
						  <th>Institute</th>
							<th>R.Date</th>	
							 <th>Student PRN</th>
							 <th>Prov. PRN</th>
							 <th>Punching PRN</th>
							<!-- <th class="noExl">Photo</th>-->
							<th width="250">Name</th>
							<th width="250">DOB</th>
                            <th>Academic year </th>
							<th>Stream </th>
							<th>Remark </th>
							
							<th>Allocation Status </th>
							<th class="noExl">Action</th>
					</tr>
				</thead>
				<tbody id="itemContainer">
					<?php
					//var_dump($emp_list);
				  //var_dump($student_list);
				                           
					foreach($student_list as $emp_list)
					{
						
					?>
					 <?php if($emp_list['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
						  else $bg="";?>								
					<tr <?=$bg?> <?=$emp_list["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
				<!--<td class="noExl"><input type="checkbox" name="chk_stud1[]" id="chk_stud1" class="checkBoxClass1" value="<?=$emp_list['sf_id']?>"></td>	 -->  
				<td><?=$z?></td>
				<td><?=$emp_list['created_on']?></td>
				
				  <td><?=$emp_list['school_name']?></td> 
						 <td><?=$emp_list['enrollment_no']?></td> 
						 <td><?=$emp_list['enrollment_no_new']?></td> 
						 <td><?php if($emp_list['organisation']=='SU' || $emp_list['organisation']=='SU-SIJOUL'){ echo $emp_list['punching_prn'];}else{ echo $emp_list['enrollment_no'];}?></td> 
					
				<td>	
					<?php
						echo $emp_list['first_name']." ".$emp_list['middle_name']." ".$emp_list['last_name'];
						?>
						</td> 
					 <td><?=$emp_list['dob']?></td> 
					 <td><?=$emp_list['sacademic_year']?></td> 
						   <td><?=$emp_list['stream_name']?></td> 
						   <td><?=$emp_list['remark']?></td> 
						  
							  <td align='center'>
							
							  <a class="btn btn-danger btn-xs" title="View Room Details" >Cancelled</a>
							 
							
							 
							  </td>                                                         
				   
								  
						<td>
							
	<a class="btn btn-info btn-xs" href="<?php echo base_url()."Hostel/view_std_payment/".$emp_list['enrollment_no']."/".$emp_list['stud_id']."/".$emp_list['organisation']."/".$emp_list['academic_year'].""?>" title="View" target="_blank">Fee Details</a>
   
  
					 </td>
					</tr>
					<?php
					$z++;
					}
					?>                            
				</tbody>
			</table>
			<script>

z='<?=$z?>';
$('#cancelled_tot').html(z==''?0:z-1);
</script>
			<!--div id="excel1">
					<button name="can_btn" value="can_btnexl" type="submit" class="btn btn-primary pull-right" style="margin-right: 30px">Download Excel</button>
					
					<button  name="can_btn" value="can_btnPDF" type="submit" onclick="can_pdf()" class="btn btn-primary pull-right" style="margin-right: 30px">Download PDF</button>
					</div-->
			
			
			<?php
			}
			else
			{
				
				echo "<span style=\"color:red;\">Records Not Found Please change search criteria and try again</span>";
			}
}
else{
	
	
	if(count($student_list)>0)
	{
	   //    var_dump($student_list);
	   //    exit();
		?>
		<style>
		.table-info thead th, .table-info thead tr{background: #774545;border-color:#FFFFFF !important}
		</style>
		<?php if($this->session->userdata('name') == 'canteen_nashik'){ ?>
		
		 	<form action="<?=base_url($currentModule.'/allocate_students_to_canteen')?>" method="POST" id="allocateCanteenForm">
			 	

				 <div class="form-group" >
					<div class="col-sm-3">
					<select name="canteen_name_breakfast" id="canteen_name_breakfast" class="form-control" >
										<option value="">-- Select Breakfast Canteen --</option>
										<?php foreach($canteen_list as $canteen){?>
		 						<option value="<?=$canteen['id']?>" ><?=$canteen['cName']?></option>
		 						<?php } ?>
									</select>
								
					</div>
					<div class="col-sm-3">
					<select name="canteen_name_lunch" id="canteen_name_lunch" class="form-control" >
										<option value="">-- Select Lunch Canteen --</option>
										<?php foreach($canteen_list as $canteen){?>
		 						<option value="<?=$canteen['id']?>" ><?=$canteen['cName']?></option>
		 						<?php } ?>
									</select>
					</div>
					<div class="col-sm-3">
					<select name="canteen_name_dinner" id="canteen_name_dinner" class="form-control" >
										<option value="">-- Select Dinner Canteen --</option>
										<?php foreach($canteen_list as $canteen){?>
		 						<option value="<?=$canteen['id']?>" ><?=$canteen['cName']?></option>
		 						<?php } ?>
									</select>
					</div>
					<div class="col-sm-3">
						<button class="btn btn-primary" type="submit" style="margin-top: 1.5px" >Allocate Canteen</button>
					</div>
					
			 	</div>
		 	
		
		<?php } ?>
		<div class="table-responsive">
		<table class="table table-bordered" id="table2excel">
			<thead>
				<tr style="">
				<!--th class="noExl"><input type="checkbox" name="ckbCheckAll" id="ckbCheckAll"></th>-->
				<?php if($this->session->userdata('name') == 'canteen_nashik'){ ?>
						<th>#</th>
					<?php } ?>
					 <th>Sr No</th>
					 <th>R.Date</th>	
					  <th>Institute</th>
					  
						 <th>Student PRN</th>
						 <th>Prov PRN</th>
						 <th>Punching PRN</th>
						<!-- <th class="noExl">Photo</th>-->
						<th width="250">Name</th>
						
                        <th>Academic year </th>
						<th>Stream </th>
						<th>Fees </th>
						<th>Fees Paid</th>
						<th>Package</th>
						<th>Hostel </th>
						<th>Floor/<br>RoomNo.</th>
						<th>Canteen Allocation Status </th>
						<th>Canteen Action </th>
						<th>Hostel Allocation Status </th>
						
						<th class="noExl">Action</th>
						
				</tr>
			</thead>
			<tbody id="itemContainer">
				<?php
				//var_dump($emp_list);
			  //var_dump($student_list);
			                           
				foreach($student_list as $emp_list)
				{
					
				?>
				 <?php if($emp_list['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
					  else $bg="";?>								
				<tr <?=$bg?> <?=$emp_list["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
				<?php if($this->session->userdata('name') == 'canteen_nashik'){ ?>
				<td>
				<?php 
					 $enrollment_no = $emp_list['enrollment_no'];
					 $enrollment_no_new = $emp_list['enrollment_no_new'];
					 $academic_year = $emp_list['academic_year'];
					 $student_id = $emp_list['stud_id'];
					 $disable = (in_array($enrollment_no, $canteen_allocated_students)? 'disabled' : '');
				     echo "<input type='checkbox' name='chk_stud[]' value='$enrollment_no|$academic_year|$student_id' $disable>";
					// echo "<input type='checkbox' name='chk_stud[]' value='1|1|1' $disable>";
				 ?>
				 </td>
				 <?php } ?>
			<!--td class="noExl"><input type="checkbox" name="chk_stud[]" id="chk_stud" class="checkBoxClass" value="<?=$emp_list['sf_id']?>"></td>-->	   
					<td><?=$j?><?=$emp_list['allocated_total']?></td>
					<td><?=$emp_list['created_on']?></td>
					<td><?=$emp_list['school_name']?></td> 
					<td><?=$emp_list['enrollment_no']?></td> 
					<td><?=$emp_list['enrollment_no_new']?></td> 
					<td><?php if($emp_list['organisation']=='SU' || $emp_list['organisation']=='SU-SIJOUL'){ echo $emp_list['punching_prn'];}else{ echo $emp_list['enrollment_no'];}?></td>
					 
				
			<td>	
				<?php
					echo $emp_list['first_name']." ".$emp_list['middle_name']." ".$emp_list['last_name'];
					?>
					</td> 
					 
				 <td><?=$emp_list['academic_year']?></td> 
					   <td><?=$emp_list['stream_name']?></td> 
					   <td><?=$emp_list['actual_fees']+$emp_list['deposit_fees']?></td> 
					   <td><?=$emp_list['amount'];?></td> 
					   <td><?=$emp_list['package_name']?></td>
					   <td>
					     <?php
							$htcode   = $emp_list['htcode'] ?? null;

							// ✅ Check for all empty or null
							if ($htcode === null || $htcode === '') {
								echo '-';
							} else {
								
								echo "{$htcode}";
							}
							?>
					   </td>
					   <td>
					   
					   <?php
							$floor_no = $emp_list['floor_no'] ?? null;
							$room_no  = $emp_list['room_no'] ?? null;

							// ✅ Check for all empty or null
							if (
								($floor_no === null || $floor_no === '') && 
								($room_no === null || $room_no === '')) {
								echo '-';
							} else {
								$floor_display = ($floor_no === '0' ? 'G' : $floor_no);
								echo "{$floor_display} / {$room_no}";
							}
							?></td>
						  <td align='center'><?php 
						  //if($this->session->userdata('name') == 'canteen_nashik'){
							
							
							 if(in_array($emp_list['enrollment_no'], $canteen_allocated_students) ){?>
							  
							  <!-- <a class="btn btn-primary btn-xs" href="<?php echo base_url()."Hostel/allocate_canteen/".str_replace("/","_",$emp_list['enrollment_no'])."/".$emp_list['stud_id']."/".$emp_list['organisation']."/".$emp_list['academic_year'].""?>" title="View" target="_blank">view</a> -->
							   <?php $index = array_search($emp_list['enrollment_no'], $canteen_allocated_students);
									 $canteens = ($index !== false) ? $canteen_allocated_students_with_canteen_name[$index]['canteens'] : null;
									 echo $canteens;
								
								?>

							  <?php
							  
							  } else { ?>
							  <?php //if($this->session->userdata('name') == 'canteen_nashik'){?>

								<a class="btn btn-danger btn-xs" href="<?php echo base_url()."Hostel/allocate_canteen/".str_replace("/","_",$emp_list['enrollment_no'])."/".$emp_list['stud_id']."/".$emp_list['organisation']."/".$emp_list['academic_year'].""?>" title="View" target="_blank">Allocate Canteen</a>
							  <?php
							  
							  //}else{ echo '-';}
							  }
						  ?>
						  </td>    <td>
				<?php if($this->session->userdata('role_id') !=33){
					      if(($this->session->userdata('role_id') ==45 || $this->session->userdata('role_id') ==60) && in_array($emp_list['enrollment_no'], $canteen_allocated_students) ){
							?> <a class="btn btn-primary btn-xs" href="<?php echo base_url()."Hostel/allocate_canteen_edit/".str_replace("/","_",$emp_list['enrollment_no'])."/".$emp_list['stud_id']."/".$emp_list['organisation']."/".$emp_list['academic_year'].""?>" title="View" target="_blank">Edit Canteen</a>
							<?php }
					?>	</td><td>    <?php// } else { ?>
						  	 <?php if($emp_list['cancelled_facility']=='N' && $emp_list['allocated_id']!='' && $emp_list['is_active']=='Y'){?>
							  <!--a class="btn btn-success btn-xs" title="Bed has allocated to this student!"><?php echo "Allocated";?></a> | -->
							  
							  <a class="btn btn-primary btn-xs" href="<?php echo base_url()."Hostel/student_facility_details/".str_replace("/","_",$emp_list['enrollment_no'])."/".$emp_list['f_alloc_id']."/".$emp_list['organisation']."/".$emp_list['academic_year'].""?>" title="View Room Details" target="_blank">View</a>
							  <?php
							  
							  } else { ?>
							   <?php if($this->session->userdata('role_id') ==45 || $this->session->userdata('role_id') ==60 || $this->session->userdata('role_id') ==17 || $this->session->userdata('role_id') ==22 || $this->session->userdata('role_id') ==6){?>	
							  <a  class="btn btn-danger btn-xs" href="<?php echo base_url()."Hostel/hostel_allocation_view/".str_replace("/","_",$emp_list['enrollment_no'])."/".$emp_list['stud_id']."/".$emp_list['organisation']."/".$emp_list['sf_id']."/".$emp_list['academic_year'].""?>" title="View" target="_blank">Allocate Hostel</a>
							  <?php
							  }else{ echo '-';}}
						  ?>
						  <?php// } ?>
						  </td>                                                         
			   
							  
					
							<td>
							<a class="btn btn-info btn-xs" href="<?php echo base_url()."Hostel/view_std_payment/".str_replace("/","_",$emp_list['enrollment_no'])."/".$emp_list['stud_id']."/".$emp_list['organisation']."/".$emp_list['academic_year'].""?>" title="View" target="_blank">Fee Details</a>
						 	
			<!--a class="btn btn-info btn-xs" href="<?php echo base_url()."Hostel/hostel_gatepass/".$emp_list['enrollment_no']."/".$emp_list['stud_id']."/".$emp_list['organisation']."/".$emp_list['academic_year'].""?>" title="View" target="_blank">Get pass</a-->
				<?php }?>
				 </td>
				
				 </tr>
				<?php
				$j++;
				}
				?>                            
			</tbody>
			
		</table>
		</div>
		</form>
		
		<script>
j='<?=$j?>';

$('#allocated_tot').html(j==''?0:j-1);

</script>
		<!--div id="excel" >
					<button  name="btnPDF" value="btnexl" type="submit" class="btn btn-primary pull-right" style="margin-right: 30px" value="btnEXL">Download Excel</button>
					
					<button  name="btnPDF" value="btnPDF" type="submit" onclick="pdf()" class="btn btn-primary pull-right" style="margin-right: 30px">Download PDF</button>
					
					</div-->
		<?php
		}
		else
		{
			
			echo "<span style=\"color:red;\">Records Not Found Please change search criteria and try again</span>";
		}
}


?>

