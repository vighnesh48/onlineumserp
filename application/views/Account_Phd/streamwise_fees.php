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
        fixedColumns: true,
        ordering: false,
        buttons: [
            {
                extend: 'excel',
                messageTop: '<?="Admission fees List-Streamwise"?>.',
				filename: 'Admission fees Streamwise List'
            },
            {
                extend: 'csv',
                messageTop: '<?="Admission fees List-Streamwise"?>.',
				filename: 'Admission fees Streamwise List'
            },
            //{
               // extend: 'colvis',
                //columns: ':not(.noVis)'
           // }
           
            
        ]
         
    } ).columns.adjust();
} );
</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Account</a></li>
        <li class="active"><a href="#">Admission fees</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Admission Fees Stream Wise</h1>
            <div class="col-xs-12 col-sm-6">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                   
										   
                </div>
            </div>
            <div class="col-xs-12 col-sm-2">
                 
                  <a style="width: 100%;" class="btn btn-primary btn-labeled" href="admission_fees_report"><span class="btn-label icon fa fa-chevron-left"></span>Back to Report</a>
                </div>
        </div>
     
		<div class="row ">
		 
            <div class="col-sm-12">
				<div class="panel">
                    
                    <div class="panel-body">
                        <div class="table-info">  

							<table id="example" class="table table-bordered table-responsive table-hover" width="200%">
							<thead>
								<tr>
									<th>SNo</th>
									<th> PRN </th>
								    <th>Old PRN </th>
							    	<th>Student Name </th>
							    	<th>Mobile No </th>
									<th>Stream </th>
									<th>Year</th>
									<th>Actual Fees</th>
                                	<th>Scholorship</th>
                                	<th>Opening Balance</th>
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
									if(!empty($fees)){
										foreach($fees as $stud1){
			
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud1['enrollment_no']?></td>
										<td><?=$stud1['new_prn']?></td>
										<td><?php echo $stud1['first_name']." ".$stud1['middle_name']." ".$stud1['last_name'];?></td>
										<td><?=$stud1['mobile']?></td>
										<td><?=$stud1['course']?></td>
										<td><?=$stud1['admission_year']?></td>
										<td><?=$stud1['actual_fees']?></td>
									    <td><?=(int)$stud1['actual_fees']-(int)$stud1['applicable_total']?></td>
									    <td><?=$stud1['opening_balance']?></td>
									    <td><?=$stud1['applicable_total']+$stud1['opening_balance']?></td>
									    <td><?=$stud1['fees_total']?></td>
									    <td><?=$stud1['cancel_charges']?></td>
									    <td><?=$stud1['refund']?></td>
									    <td><?=((int)$stud1['applicable_total']+(int)$stud1['refund']+(int)$stud1['opening_balance'])-((int)$stud1['fees_total']-$stud1['cancel_charges'])?></td>
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


