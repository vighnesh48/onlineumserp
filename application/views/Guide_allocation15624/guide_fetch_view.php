
<table id="example" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th>SNo</th>
									<th>PRN</th>
							    	<th>Student Name </th>
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