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
.table>thead>tr>th {
    vertical-align: middle;
}  
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
                messageTop: '<?="Competative Fess"?>.',
				filename: 'Competative fees List'
            }
            //{
               // extend: 'colvis',
                //columns: ':not(.noVis)'
           // }
           
            
        ]
         
    } );
} ).columns.adjust();
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Account</a></li>
        <li class="active"><a href="#">Competative fees</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-8 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Competative Exam Fee Structure <small>(MPSC, UPSC, Bank PO, PSI, STI, Etc.)</small></h1>
            <div class="col-xs-12 col-sm-4">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
     
      
		  <div class="row ">
			<!--form id="form" name="form" action="<?=base_url($currentModule.'/assign_batchToStudent')?>" method="POST"-->    
            <div class="col-sm-12">
				<div class="panel">
                    
                    <div class="panel-body">
                        <div class="table-info table-responsive">  

							<table id="example" class="table table-bordered" >
							<thead>
								<tr>
									<th rowspan=2 valign="middle">Level</th>
									<th rowspan=2>Course Module</th>
									<th rowspan=2>Students Eligible</th>
									<th rowspan=2>Total Session of 2Hr </th>
									<th colspan=3 style="text-align: -webkit-center;">Amount / No of Sessions </th>
									<th rowspan=2>Proposed Fees in Rs. </th>
								</tr>
								<tr>								
									<th>Rs.600</th>
									<th>Rs.1000 </th>									
									<th>Rs.1500 </th>
								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									if(!empty($competative_fees)){
										foreach($competative_fees as $stud){
										
										$tot[] =$stud['proposed_fees'];
								?>
									<tr>
										<td align="center"><?=$stud['com_fees_id']?></td>
										<td><?=$stud['module_name']?></td>
										<td> Appearing for above examination <?php echo $stud['eligibilty'];?></td>
										<!--td><?=$stud['eligibilty']?></td-->
										<td align="center"><?=$stud['no_of_sessions']?></td>
										<td align="center"><?=$stud['session_amount_600']?></td>
										<td align="center"><?=$stud['session_amount_1000']?></td>
									    <td align="center"><?=$stud['session_amount_1500']?></td>
									    <td align="center"><?=$stud['proposed_fees']?></td>
										
									</tr>
								<?php
										$i++;
										}?>
										<tr><td colspan=6 ></td><td >Total Fees</td><td align="center"><b><?=array_sum($tot);?></b></td>
										</tr>
									<?php 
									}else{
										echo "<tr><td colspan='8'>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table><br><br>
							<table class="table table-bordered table-hover" style="width:70% !important">
								<tr>
									<td>NOTE:</td>
									<td>Modules</td>
									<td>Discount Offered</td>
									<td>Fees to be paid</td>
								</tr>
								<tr>
									<td>1</td>
									<td>Discounted fees for total package of 2 modules (1 & 2)</td>
									<td>1000</td>
									<td>Rs. 21,000/-</td>
									
								</tr>
								<tr>
									<td>2</td>
									<td>Discounted fees for total package of 2 modules (1 & 3)</td>
									<td>1000</td>
									<td>Rs. 24,000/-</td>
								</tr>
								<tr>
									<td>3</td>
									<td>Discounted fees for total package of 2 modules (2 & 3)</td>
									<td>2000</td>
									<td>Rs. 25,000/-</td>
								</tr>
								<tr>
									<td>4</td>
									<td>Discounted fees for total package of 3 modules (1, 2, 3)</td>
									<td>4000</td>
									<td>Rs. 33,000/-</td>
								</tr>
							</table>
						</div>
                    </div>
                </div>
			</div>

		</div>
			
    </div>
</div>