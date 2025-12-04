

<?php 

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
					  <th>Institute</th>
						 <th>Student PRN</th>
						<!-- <th class="noExl">Photo</th>-->
						<th width="250">Name</th>
						<th>Stream </th>
						
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
			
			  <td><?=$emp_list['organisation']?></td> 
			  <td><?=$emp_list['school_name']?></td> 
					 <td><?=$emp_list['enrollment_no']?></td> 
					 
				
			<td>	
				<?php
					echo $emp_list['first_name']." ".$emp_list['middle_name']." ".$emp_list['last_name'];
					?>
					</td> 
				
					   <td><?=$emp_list['stream_name']?></td> 
						                                                         
			   
							  
					<td>
										
			<a class="btn btn-info btn-xs" href="<?php echo base_url()."Hostel/download_idcard_pdf/".$emp_list['academic_year']."/".$emp_list['organisation']."/".$emp_list['school_name']."/".str_replace("/","_",$emp_list['enrollment_no']).""?>" title="View" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i></a>


				 </td>
				</tr>
				<?php
				$j++;
				}
				?>                            
			</tbody>
		</table>
		
		
		<?php
		}
		else
		{
			
			echo "<span style=\"color:red;\">Records Not Found Please change search criteria and try again</span>";
		}



?>
