<?php
unset($z); unset($j);
$z=1;$j=1; 
if( isset($_POST['cancel']) && $_POST['cancel']=="cancel" )
{
	if(count($student_list)>0)
		{
		       //var_dump($student_list);
		       //exit();
			?>
			<style>
			.table-info thead th, .table-info thead tr{background: #774545;border-color:#FFFFFF !important}
			</style>
			<table class="table table-bordered" id="table2excel">
				<thead>
					<tr style="">
					<!--<th class="noExl"><input type="checkbox" name="ckbCheckAll1" id="ckbCheckAll1"></th>-->
						 <th>Sr No</th>
						  <th>Organisation</th>
						  
							 <th>Student PRN</th>
							<!-- <th class="noExl">Photo</th>-->
							<th width="250">Name</th>
							<th>Stream </th>
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
				
				  <td><?=$emp_list['organisation']?> - <?=$emp_list['school_name']?></td> 
						 <td><?=$emp_list['enrollment_no']?></td> 
						 
					
				<td>	
					<?php
						echo $emp_list['first_name']." ".$emp_list['middle_name']." ".$emp_list['last_name'];
						?>
						</td> 
					
						   <td><?=$emp_list['stream_name']?></td> 
							  <td align='center'>
							
							  <a class="btn btn-danger btn-xs" title="View Room Details" >Cancelled</a>
							 
							
							 
							  </td>                                                         
				   
								  
						<td>
		
		 
	<a class="btn btn-info btn-xs" href="<?php echo base_url()."Transport/view_std_payment/".$emp_list['enrollment_no']."/".$emp_list['stud_id']."/".$emp_list['organisation']."/".$emp_list['academic_year'].""?>" title="View" target="_blank">Fee Details</a>
   
  
					 </td>
					</tr>
					<?php
					$z++;
					}
					
					$z--;
					
					?>                            
				</tbody>
			</table>
			
			
			<script>
z='<?=$z?>';
$('#cancelled_tot').html('('+z+')');

</script>

			<div id="excel1">
					<button type="submit" class="btn btn-primary pull-right" style="margin-right: 30px">Download Excel</button>
					
					<button  name="can_btn" value="can_btnPDF" type="submit" class="btn btn-primary pull-right" style="margin-right: 30px">Download PDF</button>
					</div>
			
			
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
                    <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr style="">
                                 <th>Sr No</th>
								  <th>Organisation</th>
                                  
									 <th>Student PRN</th>
                                    <!-- <th class="noExl">Photo</th>-->
                                    <th width="250">Name</th>
                                    <th>Mobile</th>
									<th>Boarding Point</th>
                                    <th class="noExl">Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            //var_dump($emp_list);
                          //var_dump($student_list);
                            $j=1;                            
                            foreach($student_list as $emp_list)
                            {
                                
                            ?>
							 <?php if($emp_list['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               
                        <td><?=$j?></td>
						
						  <td><?=$emp_list['organisation']?> - <?=$emp_list['school_name']?></td> 
                                 <td><?=$emp_list['enrollment_no']?></td> 
                                 
                            
						<td>	
							<?php
								echo $emp_list['first_name']." ".$emp_list['middle_name']." ".$emp_list['last_name'];
								?>
								</td> 
							
								   <td><?=$emp_list['mobile']?></td> 
                                      <td align='center'><?php 
										 if($emp_list['cancelled_facility']=='N' && $emp_list['allocated_id']!='' && $emp_list['is_active']=='Y'){
											 echo $emp_list['boarding_point'];?>
										  <!--a class="btn btn-success btn-xs" title="Bed has allocated to this student!"><?php echo "Allocated";?></a> | -->
										  <!--<a class="btn btn-primary btn-xs" href="<?php echo base_url()."Transport/student_facility_details/".str_replace("/","_",$emp_list['enrollment_no'])."/".$emp_list['f_alloc_id']."/".$emp_list['organisation']."/".$emp_list['academic_year'].""?>" title="View Room Details" target="_blank">View</a>-->
										  
										  
										  <?php
										  
										  } else { ?>
										  <!--<a  class="btn btn-danger btn-xs" href="<?php echo base_url()."Transport/hostel_allocation_view/".str_replace("/","_",$emp_list['enrollment_no'])."/".$emp_list['stud_id']."/".$emp_list['organisation']."/".$emp_list['sf_id']."/".$emp_list['academic_year'].""?>" title="View" target="_blank">Allocate Hostel</a>--> -
										  <?php
										  }
									  ?>
									  </td>                                                         
                           
                                          
                                <td>
         <a class="btn btn-primary btn-xs" href="<?php echo base_url()."Transport/student_facility_details/".trim(str_replace("/","_",$emp_list['enrollment_no']))."/".$emp_list['f_alloc_id']."/".$emp_list['organisation']."/".$emp_list['academic_year'].""?>" title="View Room Details" target="_blank">View</a>
			<a class="btn btn-info btn-xs" href="<?php echo base_url()."Transport/view_std_payment/".trim(str_replace("/","_",$emp_list['enrollment_no']))."/".$emp_list['stud_id']."/".$emp_list['organisation']."/".$emp_list['academic_year'].""?>" title="View" target="_blank">Fee Details</a>
	       
	      
                             </td>
                            </tr>
                            <?php
                            $j++;
                            }
							
							$j--;
                            ?>                            
                        </tbody>
                    </table>
					
					<script>
j='<?=$j?>';
$('#allocated_tot').html('('+j+')');


</script>

					<div id="excel" >
					<button type="submit" class="btn btn-primary pull-right" style="margin-right: 30px">Download Excel</button>
					
					<button  name="btnPDF" value="btnPDF" type="submit" class="btn btn-primary pull-right" style="margin-right: 30px">Download PDF</button>
					</div>
                    <?php
                    }
                    else
                    {
                        
                        echo "<span style=\"color:red;\">Records Not Found Please change search criteria and try again</span>";
                    }
}


?>