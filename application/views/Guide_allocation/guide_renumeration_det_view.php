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
$(document).ready(function () {
    $('#example').DataTable({
        responsive: true,
        autoWidth: true,
        dom: 'Bfrtip',
        scrollY: "700px",
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: true,
        ordering: false,
        buttons: [
            {
                extend: 'excel',
                filename: 'Renumeration Details',
                exportOptions: {
                    // Exclude footer totals row from export
                    columns: ':visible',
                }
            },
        ]
    }).columns.adjust();
});

</script> 
<style>
.form-control{border-collapse:collapse !important;}
</style>
<?php
   $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Phd Renumeration</a></li>
    </ul>
    <div class="page-header">		
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Renumeration Details</h1> <button class="btn btn-primary" data-toggle="modal" data-target="#detailsModal">Renumeration Policy Details</button>
            <div class="col-xs-12 col-sm-6">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">					   
                </div>
            </div>
        </div>
     </div>
		  <div class="row "> 
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title" id="stdname">Details List</span>
                    </div>
                    <div class="panel-body" style="overflow:scroll;height:700px;">
                        <div class="table-info" id='stud_view'>  
						  <?php //if(in_array("View", $my_privileges)) { ?>
							<table id="example" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th style="text-align: center">SNo</th>
									<th style="text-align: center">Academic Year</th>
									<th style="text-align: center">Type</th>
									<th style="text-align: center">Institute</th>
									<th style="text-align: center">Designation</th>
							    	<th style="text-align: center">Member Name</th>
							    	<th style="text-align: center">Employee Code</th>									
						            <th style="text-align: center">Student Name</th>
						            <th style="text-align: center">Enrollment No</th>
							    	<th style="text-align: center">Rac Date</th>
									<th style="text-align: center">Created On</th>
									<th style="text-align: center">Renumeration</th>
						            <th style="text-align: center">Travelling Allowance</th>
						            <th style="text-align: center">Total Amount</th>
								</tr>
								</thead>
								<tbody>
								<?php	
  							
								$i=1;$ren_amt='';$trav_amt='';$tot_amt='';
									if(!empty($renum_det)){
										foreach($renum_det as $stud){
                                       if($stud['type']=="topic_approval")
											{
												$type="Rac Topic Approval";
											}elseif($stud['type']=="pre_thesis")
											{
												$type="RAC Pre Thesis";
											}
											 elseif($stud['type']=="final_defence"){
												 $type="Final Defence";
											}
											elseif($stud['type']=="course_work"){
												 $type="Course Work";
											}
											else
											{
												$type=$stud['type'];
											}
									?>
									<tr>
										<td><?=$i?></td>		
										<td><?=$stud['academic_year']?></td>
										<td><?=$type?>
										
										</td>
										<td><?=$stud['institute']?></td>
										<td><?=$stud['designation']?></td>
										<td><?=$stud['member_name']?></td>
										<td><?=$stud['emp_code']?></td>
										<td><?=$stud['first_name'].' '.$stud['sm.middle_name'].' '.$stud['sm.last_name']?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['rac_date']?></td>
										<td><?=$stud['created_on']?></td>
										<td><?=$stud['renumeration']?></td>
										<td><?=$stud['travelling_allowance']?></td>
										<td><?=$stud['amount']?></td>

									          </tr>
											<?php
													$ren_amt += $stud['renumeration'];
													$trav_amt += $stud['travelling_allowance'];
													$tot_amt += $stud['amount'];
													$i++;
												}
											}
											?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="11" style="text-align:right"><strong>Total</strong></td>
												<td><?= $ren_amt ?></td>
												<td><?= $trav_amt ?></td>
												<td><?= $tot_amt ?></td>
											</tr>
										</tfoot>
									</table>
						  <?php //} ?>
						</div>
                    </div>
                </div>
			</div>		
		</div>	
		</div>	
		
		<div class="container">
        <!-- Modal -->
        <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="detailsModalLabel">Details</h4>
                    </div>
                    
<div class="modal-body">
                <?php 
                if (!empty($renum_amount_det)) { 
                    // Group data by 'type'
                    $groupedData = [];
                    foreach ($renum_amount_det as $item) {
                        $groupedData[$item['type']][] = $item;
                    }

                    // Define headers for each type
                    $headers = [
                        1 => 'RAC(Topic Approval)',
                        2 => 'Research Progress Seminar(RPS)',
                        3 => 'RAC(Pre-Thesis)',
                        4 => 'PHD Final Thesis Evaluation',
                        5 => 'PHD Defence Final Viva Voce Examination'
                    ];

                    // Display data grouped by 'type'
                    foreach ($groupedData as $type => $items) { 
                        ?>
                        <h5><strong><?php echo $headers[$type] ?? 'Unknown Type'; ?></strong></h5>
                        <ul>
                            <?php foreach ($items as $amt) { ?>
                                <li>
                                    <strong>Designation:</strong> <?php if($amt['designation']=='Guide'){ echo $amt['designation'].'/Supervisor'; }else{ echo $amt['designation']; } ?>, 
                                    <strong>Amount:</strong> <?php echo $amt['amount']; ?>
                                </li>
                            <?php } ?>
                        </ul>
                        <hr>
                    <?php } }  ?>
                         </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
