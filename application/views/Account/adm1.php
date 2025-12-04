<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<style>
th, td { white-space: nowrap; }
    
</style>
<script>

$(document).ready(function() {
	
    $('#example').DataTable( {
        responsive: true,
        autoWidth: true,
        dom: 'Bfrtip',
		scrollY:        "900px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        //fixedColumns: true,
     ordering: false,
        columnDefs: [
            { width: '100%', targets: 0 }
        ],
        buttons: [
            {
                extend: 'excel',
                messageTop: '<?="Admission Fess"?>.',
				filename: 'Admission fees List'
            },
            {
                extend: 'csv',
                messageTop: '<?="Admission Fess"?>.',
				filename: 'Admission fees List'
            },
            //{
               // extend: 'colvis',
                //columns: ':not(.noVis)'
           // }
           
            
        ]
         
    } );
} ).columns.adjust();
</script>
	<table id="example" class="table table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th >SNo</th>
									<th>PRN.</th>
									<th>Student Name</th>
									<th>School </th>
									<th>Course </th>
									<th>Stream </th>
									<th >Year</th>
									<th>Paid By</th>
									<th >DD/CHQ No</th>
									<th>date</th>
									<th >Receipt No</th>
									<th >Bank Name</th>
									<th >Amount</th>
									<th >Fees Cancel</th>
									<th >Actual Fees</th>
									<th >Scholorship</th>
									<th >Applicable Fees</th>
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
										<td><?=$stud['enrollment_no']?></td>
										<td><?php echo $stud['first_name']." ".$stud['middle_name']." ".$stud['last_name'];?></td>
										<td><?=$stud['school_short_name']?></td>
										<td><?=$stud['course_short_name']?></td>
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['admission_year']?></td>
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
										echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
									}
								?>
								</tbody>
							</table>
					


