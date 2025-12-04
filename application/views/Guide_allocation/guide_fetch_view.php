
<table id="example" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th>SNo</th>
									<th>PRN</th>
							    	<th>Student Name </th>
							    	<th>View</th>
							    	<th>Guide Id</th>
									<th>Guide Name</th>
								</tr>
								</thead>
								<tbody>
								<?php					
								$i=1;
									if(!empty($allcated_guidelist)){
										foreach($allcated_guidelist as $stud){
			
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['student_name']?></td>
										<td><a href="<?=base_url();?>Guide_allocation_phd/topic_approval_add/<?=base64_encode($stud['student_id']);?>" title="View" target="_blank" ><i class="fa fa-eye"></i>&nbsp;</a>	
										<?php if($stud['upload_file']!='' && $stud['status']=='Y' && $stud['type']=='RPS-5'){ ?>
										<a href="<?=base_url();?>Guide_allocation_phd/add_phd_section_upload_files/<?=base64_encode($stud['student_id']);?>" title="View" target="_blank" >upload-letters&nbsp;</a>
										<a href="<?=base_url();?>Guide_allocation_phd/add_coe_upaward_files/<?=base64_encode($stud['student_id']);?>" title="View" target="_blank" >coe-upload-letters&nbsp;</a>
										<a href="<?=base_url();?>Guide_allocation_phd/add_thesis_ev_dispatch_records/<?=base64_encode($stud['student_id']);?>" title="View" target="_blank" >dispatch records&nbsp;</a></td>
										<?php } ?>
										<td><?=$stud['guide_id']?></td>
										<td><?=$stud['guide_name']?></td>
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

<script>
$(document).ready(function() {	
     $('#example').DataTable({
        responsive: true,
        autoWidth: true,
        dom: 'Bfrtip',
		scrollY:        "700px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
        fixedColumns: true,
        ordering: false,
        buttons: [
            {
                extend: 'excel',
				filename: 'guide allocation list'
            },
        ]        
    }).columns.adjust();  
}); 	 
</script>