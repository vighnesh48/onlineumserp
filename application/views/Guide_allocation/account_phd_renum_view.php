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

	<?php 
     if(isset($_SESSION['status']))
    {
        ?>
			<script>
			//alert("Your Details already Submitted.");
			var status="<?php echo $_SESSION['status'] ?>";
			 alert(status);
			</script>
        <?php 
        unset($_SESSION['status']);
       }
   ?>
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
        <li class="active"><a href="#">Guide Renumeration</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Guide Renumeration</h1><button class="btn btn-primary" data-toggle="modal" data-target="#detailsModal">Renumeration Policy Details</button>
            <div class="col-xs-12 col-sm-6">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">					   
                </div>
            </div>
             <div class="col-xs-12 col-sm-2">
				  <div class="visible-xs clearfix form-group-margin"></div>
              </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Renumeration Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
							<div class="form-group">
							 <div class="col-sm-2" >
                                <select name="acad_year" id="acad_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
								    $year=ACADEMIC_YEAR;
									foreach ($academic_year as $acad_year) {
										if ($acad_year['academic_year'] == $year) {
											$sel1 = "selected";
										} else {
											$sel1 = '';
										}
										echo '<option value="' . $acad_year['academic_year'] . '"' . $sel1 . '>' . $acad_year['academic_year'] . '</option>';
									}
									?>
                               </select>
                              </div> 
                              <!--div class="col-sm-2" >
                                <select name="admission_cycle" id="admission_cycle" class="form-control" required>
                                  <option value="">Select Batch</option>
                                  <?php
									foreach ($cycle as $cycle) {
										if ($cycle['admission_cycle'] == $admission_cycle) {
											$sel1 = "selected";
										} else {
											$sel1 = '';
										}
										echo '<option value="' . $cycle['admission_cycle'] . '"' . $sel1 . '>' . $cycle['admission_cycle'] . '</option>';
									}
									?>
                               </select>
                              </div> 
                             <div class="col-sm-2" >
                                <select name="dept_id" id="dept_id" class="form-control" required>
                                  <option value="">Select Department</option>
                               </select>
                              </div> 
							  <div class="col-sm-2" >
                                <select name="renum_type" id="renum_type" class="form-control" required>
                                  <option value="">Select Type</option>
                                  <?php
									foreach ($renum_types as $types) {
										echo '<option value="' . $types['type'] . '">' . $types['type'] . '</option>';
									}
									?>
                               </select>
                              </div-->
							  <div class="col-sm-2" >
                                 <input type="text" id="ren_month" name="ren_month" class="form-control monthPicker" placeholder="Select Month"/> 
                              </div> 
                                <div class="col-sm-2" >
                                <select name="emp_code" id="emp_code" class="form-control" required>
                                  <option value="">Select Guide/External</option>
                                  <?php
									foreach ($guide_det as $result) {

										echo '<option value="' . $result['emp_code'] . '">' .$result['emp_code'].' - '. $result['member_name'] . '</option>';
									}
									?>
                               </select>
                              </div> 
								<div class="col-sm-2 "> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
     </div>
		  <div class="row "> 
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title" id="stdname">Renumeration List</span>
                    </div>
                    <div class="panel-body" style="overflow:scroll;height:700px;">
                        <div class="table-info" id='stud_view'>  
							<table id="example" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th style="text-align: center">SrNo</th>
									<th style="text-align: center">Academic Year</th>
									<th style="text-align: center">Member Name</th>
									<!--th style="text-align: center">Designation</th-->
							    	<th style="text-align: center">Institute Name</th>
									<th style="text-align: center">Employee Code</th>
									<th style="text-align: center">Account Holder Name</th>
									<th style="text-align: center">Bank Name</th>
									<th style="text-align: center">Branch</th>
							    	<th style="text-align: center">IFSC</th>
							    	<th style="text-align: center">Passbook/Cheque Copy</th>
							    	<th style="text-align: center">Mobile No</th>
							    	<th style="text-align: center">Email</th>
							    	<th style="text-align: center">Students</th>
							    	<th style="text-align: center">Renumeration</th>
							    	<th style="text-align: center">Amount Payable</th>
							    	<th style="text-align: center">Amount Paid</th>
							    	<th style="text-align: center">Amount Pending</th>
							    	<th style="text-align: center">View Payment</th>
							    	<th style="text-align: center">Pay</th>
								</tr>
								</thead>
								<tbody>
								<?php	
  							
								$i=1;
									if(!empty($renum_det)){
										foreach($renum_det as $stud){
			
								?>
									<tr>
										<td><?=$i?></td>		
										<td><?=$stud['academic_year']?></td>
										<td><?=$stud['member_name']?></td>
										<!--td><?=$stud['designation']?></td-->
										<td><?=$stud['institute']?></td>
										<td><?=$stud['emp_code']?></td>
										<td><?=$stud['accountholdername']?></td>
										<td><?=$stud['bank_name']?></td>
										<td><?=$stud['branch']?></td>
										<td><?=$stud['ifsc']?></td>
										<td><?php if ($stud['cheque_file']): 
											$b_name = "uploads/phd_renumaration_files/";
											$dwnld_url = base_url()."Upload/download_s3file/".$stud['cheque_file'].'?b_name='.$b_name; ?>
							                <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										 <?php endif; ?></td>
										<td><?=$stud['mobno']?></td>
										<td><?=$stud['email']?></td>
										<td><?=$stud['stud_count'] ? $stud['stud_count']:'0'; ?> &nbsp;&nbsp;&nbsp;<a href="<?=base_url();?>Guide_allocation_phd/fetch_guide_renumeration_det_view/<?=base64_encode($stud['emp_code']);?>/<?=base64_encode($stud['academic_year']);?>" title="View" target="_blank" ><i class="fa fa-eye"></i></a></td>
										<td><?=$stud['renumeration'] ? $stud['renumeration']:'0'; ?></td>	
										<td><?=$stud['renumeration'] ? $stud['renumeration']:'0'; ?></td>
										<td><?=$stud['total_paid'] ? $stud['total_paid']:'0'; ?></td>
										  <?php
                                          $pending=($stud['renumeration']-$stud['total_paid']);
										 ?>	
										<td><?=$pending ? $pending:'0'; ?></td>
										<td>
											<a class="btn btn-primary" href="<?=base_url();?>Guide_allocation_phd/payment_view_history/<?=base64_encode($stud['emp_code']);?>/<?=base64_encode($stud['academic_year'])?>" title="View Payment History" target="_blank">View Payment History</a>
										</td>
										<td>
											<a class="btn btn-primary" href="<?=base_url();?>Guide_allocation_phd/make_payment/<?=base64_encode($stud['emp_code']);?>/<?=base64_encode($stud['academic_year'])?>" title="Pay" target="_blank">Pay</a>
										</td>
									</tr>
								<?php
										$i++;
										}
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
<script>
$(document).ready(function () {
	
	 $('.monthPicker').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'mm-yyyy',
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
$("#btn_submit").click(function(){

	var emp_code=$("#emp_code").val();
	var acad_year=$("#acad_year").val();
	var ren_month=$("#ren_month").val();
	if(acad_year == '' && emp_code == '' && ren_month == ''){
	     alert('please select atleast one option');
		 return false;
	}else{
			$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Guide_allocation_phd/fetch_guide_renumeration_det',
					data: {acad_year:acad_year,emp_code:emp_code,ren_month:ren_month},
				    'success' : function(data){ //probably this request will return 
				   
				   $('#stud_view').html(data);
				}
			});
	     }	
    });
  
	
	$("#admission_cycle").change(function (){

		$('#dept_id').html();
		var cycle=$("#admission_cycle").val();
		if(cycle ==''){
	     alert('please select Batch');
		 return false;
	}else{
			$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Guide_allocation_phd/fetch_dept_onbatch',
					data: {cycle:cycle},
				'success' : function(data){ //probably this request will return 
				   
				   $('#dept_id').html(data);
				}
			});
	     }	
		
	});
}); 
</script>
