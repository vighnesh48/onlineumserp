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
  table.dataTable thead th, table.dataTable tbody tr td{white-space: nowrap;}
    
</style>
<script>
$(document).ready(function() {
   
    $('#example').DataTable( {
        responsive: true,
        autoWidth: true,
        dom: 'Bfrtip',
		scrollY:        "700px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
         ordering: false,
        fixedColumns: true,
        buttons: [
            {
                extend: 'excel',
                messageTop: '<?="Admission Fees Report"?>.',
				filename: 'Admission fees Report',
				exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11]
            }
            },
            {
                extend: 'csv',
                messageTop: '<?="Admission Fees"?>.',
				filename: 'Admission fees Report'
            },
            //{
               // extend: 'colvis',
                //columns: ':not(.noVis)'
           // }
           
            
        ]
         
    } );
   
} );
</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Account</a></li>
        <li class="active"><a href="#">Admission Fees Report</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-8 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Cumulative Report-Admission Fees</h1>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-3"></div>
        </div>
             <ul class="nav nav-tabs" id="myTab">
			  <li class="active"><a data-target="#stream" data-toggle="tab" id="stream_table">Stream Wise</a></li>
			  <li><a data-target="#student" data-toggle="tab" id="student_table">Student Wise</a></li>
			  </ul>
			</ul>
			<div class="tab-content">
			  <div class="tab-pane active" id="stream">
			        <div class="row ">
				<div class="panel">
                    <div class="panel-body">
                        <div class="table-info">  
							<table id="example" class="table table-bordered table-responsive table-hover" width="100%">
							<thead>
								<tr>
									<th  style="width:1%!important">SNo</th>
									<th >School </th>
									<th >Stream </th>
									<th >Year</th>
									<th >#Student</th>
									<th >Actual</th>
                                	<th >Scholorship</th>
									<th >Applicable</th>
									<th >Collection</th>
									<th >Charges</th>
									<th >Refund</th>
									<th >Pending</th>
								    <th >Details</th>
								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;  
							//	print_r($fees[0]);
									if(!empty($fees)){
										foreach($fees as $stud){
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['school_short_name']?></td>
										<td><?=$stud['course']?></td>
										<td><?=$stud['admission_year']?></td>
									    <td><?=$stud['stud_total']?></td>
                                        <td><?=$stud['actual_fees']?></td>
									    <td><?=(int)$stud['actual_fees']-(int)$stud['applicable_total']?></td>
									    <td><?=$stud['applicable_total']?></td>
									    <td><?=$stud['fees_total']?></td>
									    <td><?=$stud['cancel_charges']?></td>
									    <td><?=$stud['refund']?></td>
									    <td><?=((int)$stud['applicable_total']+(int)$stud['refund'])-((int)$stud['fees_total']-(int)$stud['cancel_charges'])?></td>
										<td>
										    <a href="admission_fees_streamwise?academic_year=2017&year=<?=$stud['admission_year']?>&stream_id=<?=$stud['stream_id']?>" class="btn btn-sm btn-primary" >View</a>
										   </td>
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
							
						</div>
                    </div>
                </div>
			</div>
			      
			  </div>
			   <div class="tab-pane" id="student">
			  	<div class="row ">
		 
            <div class="col-sm-12">
				<div class="panel">
                    
                    <div class="panel-body">
                        <div class="table-info">  

							<table id="example1" class="table table-bordered table-responsive table-hover" width="250%">
							<thead>
								<tr>
									<th>SNo</th>
								    <th>PRN </th>
								    <th>Old PRN </th>
							    	<th>Student Name </th>
							    	<th>Mobile No </th>
							    	<th>Gender </th>
							    	<th>School </th>
									<th>Stream </th>
									<th>Year</th>
									<th>Actual Fees</th>
                                	<th>Scholorship</th>
									<th>Applicable</th>
									<th>Collection</th>
									<th>Charges</th>
									<th>Refund</th>
									<th>Pending</th>
									<th>Admission cancel</th>
								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
								$ref=0;
									if(!empty($studfees)){
										foreach($studfees as $stud1){
										
								?>
									<tr>
										<td><?=$i?></td>
										<td><?='*'.$stud1['enrollment_no']?></td>
										<td><?=$stud1['new_prn']?></td>
										<td><?php echo $stud1['first_name']." ".$stud1['middle_name']." ".$stud1['last_name'];?></td>
										<td><?=$stud1['mobile']?></td>
										<td><?=$stud1['gender']?></td>
										<td><?=$stud1['school_short_name']?></td>
										<td><?=$stud1['course']?></td>
										<td><?=$stud1['admission_year']?></td>
										<td><?=$stud1['actual_fees']?></td>
									    <td><?=(int)$stud1['actual_fees']-(int)$stud1['applicable_total']?></td>
									    <td><?=$stud1['applicable_total']?></td>
									    <td><?=$stud1['fees_total']?></td>
									    <td><?=$stud1['cancel_charges']?></td>
									     <td><?=$stud1['refund']?></td>
									    <td><?=((int)$stud1['applicable_total']+(int)$stud1['refund'])-((int)$stud1['fees_total']-$stud1['cancel_charges'])?></td>
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
							
						</div>
                    </div>
                </div>
			</div>

		</div>
 
			   </div>
		
		</div>
			
    </div>
</div>

<script>
$(document).ready(function() {
    $('#example1').DataTable( {
        responsive: true,
        autoWidth: true,
        dom: 'Bfrtip',
		scrollY:        "700px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
         ordering: false,
        fixedColumns: true,
        buttons: [
           // {
               // extend: 'excel',
               // messageTop: '<?="Admission Fees Report-Student wise"?>.',
			//	filename: 'Admission fees Report',
			//	exportOptions: {
               // columns: [0,1,2,3,4,5,6,7,8,9,10,11,12]
           // }
           // },
            {
                extend: 'csv',
                messageTop: '<?="Admission Fees"?>.',
				filename: 'Admission fees Report'
            },
            //{
               // extend: 'colvis',
                //columns: ':not(.noVis)'
           // }
           
            
        ]
         
    } );
} );
</script>

