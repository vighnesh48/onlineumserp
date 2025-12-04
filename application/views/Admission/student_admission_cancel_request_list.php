<?php 
//error_reporting(E_ALL); ini_set('display_errors', 1);

?>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>.panel{
    box-shadow: 1px 2px 13px #ccc!important;
}
.panel:hover{
    box-shadow:1px 2px 7px #f2f2f2!important;
}


.table-info thead th, .table-info thead tr {    background: #1d89cf!important;
}

</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Student</a></li>
        <li class="active"><a href="#">Refund Request</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon text-danger"></i>&nbsp;&nbsp;Refund Request List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
				<div class="panel-heading">
                    <span class="panel-title">Refund Request List</span>
                </div>
         
            <div class="table-info panel-body">  
				
				<div class="row">
				<?php if($this->session->flashdata('success')): ?>
					<div id="custom-flash" 
						 style="width:500px; position:absolute; top:20px; right:20px; display:flex; align-items:center; gap:8px; padding:10px; 
								background-color:#d4edda; border:1px solid #c3e6cb; color:#155724; border-radius:5px; z-index:9999;">
						<i class="fa fa-check" style="font-size:22px; color:green;"></i>
						<span style="flex:1;"><?= $this->session->flashdata('success'); ?></span>
						<span onclick="document.getElementById('custom-flash').style.display='none';" 
							  style="cursor:pointer; font-size:20px; font-weight:bold; color:#155724;">&times;</span>
					</div>
				<?php endif; ?>
				
				<?php if($this->session->flashdata('error')): ?>
					<div id="custom-flash" 
						 style="width:500px; position:absolute; top:20px; right:20px; display:flex; align-items:center; gap:8px; padding:10px; 
								background-color:#f8d7da; border:1px solid #f5c6cb; color:#721c24; border-radius:5px; z-index:9999; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
						<i class="fa fa-times-circle" style="font-size:22px; color:#721c24;"></i>
						<span style="flex:1;"><?= $this->session->flashdata('error'); ?></span>
						<span onclick="document.getElementById('custom-flash').style.display='none';" 
							  style="cursor:pointer; font-size:20px; font-weight:bold; color:#721c24;">&times;</span>
					</div>
				<?php endif; ?>
				
				
					<form action="<?= site_url('Admission/student_admission_cancel_request_list') ?>" method="post"> 
					 <input type="hidden" name="export_flag" id="export_flag" value="0">
						<div class="col-sm-12 search_prn">
						  <div class="col-sm-2">
							<label class="control-label">Academic Year</label>
							<select class="form-control" name="academic_year">
								<option selected disabled>--Select Academic Year--</option>
								<option value="2025" <?php if(isset($searchParam['academic_year']) && $searchParam['academic_year'] == '2025'){echo "selected";} ?>>2025</option>
								
							</select>
						  </div>
						  
						  <div class="col-sm-2">
							<label class="control-label">Select Month</label>
							<select class="form-control" name="request_month">
								<option selected disabled>--Select Month--</option>
								<?php for ($i = 1; $i <= 12; $i++){ ?>
									<option value="<?= $i ?>" <?php if(isset($searchParam['request_month']) && $searchParam['request_month'] == $i){echo "selected";} ?>><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
								<?php } ?>
							</select>
						  </div>
						  
						   <div class="col-sm-2">
							<label class="control-label">Select Status</label>
							<select class="form-control" name="request_status">
								<option selected disabled>--Select Status--</option>
								  
								  <?php if(isset($_SESSION['role_id']) && $_SESSION['role_id'] != 2 ){?>
									<option value="pending" <?php if(isset($searchParam['request_status']) && $searchParam['request_status'] == 'pending'){echo "selected";} ?>>Pending</option>
									
									<option value="rejected" <?php if(isset($searchParam['request_status']) && $searchParam['request_status'] == 'rejected'){echo "selected";} ?>>Rejected</option>
								
									<option value="approved" <?php if(isset($searchParam['request_status']) && $searchParam['request_status'] == 'approved'){echo "selected";} ?>>Approved</option>
									
									<option value="refunded" <?php if(isset($searchParam['request_status']) && $searchParam['request_status'] == 'refunded'){echo "selected";} ?>>Refunded</option>
									
									<option value="cancel" <?php if(isset($searchParam['request_status']) && $searchParam['request_status'] == 'cancel'){echo "selected";} ?>>Cancel</option>
									
								  <?php } ?>
								  
								<option value="hod_approved" <?php if(isset($searchParam['request_status']) && $searchParam['request_status'] == 'hod_approved'){echo "selected";} ?>>HOD Approved</option>
								
							</select>
						  </div>
						  
						  <div class="col-sm-1" style="margin-top:25px">
							<button class="btn btn-primary form-control" id="sbutton" type="submit" >Search</button>
						  </div>
						  <?php if($_SESSION['role_id'] != 20){ ?>
							  <div class="col-sm-1" style="margin-top:25px">
								<button class="btn btn-primary form-control" id="export" type="submit">Export</button>
							  </div>
						  <?php } ?>
						  
						  <div class="col-sm-1" style="margin-top:25px">
						  
							<a href="<?php echo site_url('Admission/student_admission_cancel_request_list/')?>"  role="button" aria-pressed="true"    title="Reset Search" class="btn btn-primary form-control">Reset..</a>
							
							
							
						  </div>
						  
						</div>	
					</form>		
		
		
					<hr style="width:100%;text-align:left;margin-left:0;margin-top:95px">
					<div class="col-sm-12 search_prn" style="margin-top:20px">
					
						<form action="<?=base_url()?>Admission/updateRefundStatus" method="post">
						<?php if($_SESSION['role_id'] == 20){ ?>
						    <div class="col-sm-2">
								<label class="control-label">Select Status</label>
								<select class="form-control" name="request_status">
									<option selected disabled>--Select Status--</option>
									
									<option value="hod_approved" <?php if(isset($searchParam['request_status']) && $searchParam['request_status'] == 'hod_approved'){echo "selected";} ?>>HOD Approved</option>
									
									<option value="cancel" <?php if(isset($searchParam['request_status']) && $searchParam['request_status'] == 'cancel'){echo "selected";} ?>>Cancel</option>
									
								</select>
							</div>
							
							<div class="col-sm-1" style="margin-top:25px">
							<button class="btn btn-primary form-control" id="sbutton" type="submit" >Update Status</button>
							</div>
						<?php } ?>
					</div>
				</div>
				
				</br>
				</br>
			
                <div class="col-lg-12">
                    <div class="table-info table-responsive" id="stddata" >    
                   <table class="table table-bordered" width="100%" id="example">
                        <thead>
                            <tr>
								<th>#</th>
								<th>Sn</th>
								<th>Enrollment No</th>
								<th>Request For</th>
								<th>Student Bank</th>
								<th>Bank Account No</th>
								<th>Account Holder Name</th>
								<th>Bank IFSC</th>
								<th>Academic Year</th>
								<th>Paid Amount</th>
								<th>Deduction</th>
								<th>Refundable Amount</th>
								<th>Requested Date</th>
								<th>Cancelled Cheque</th>
								<th>Status</th>
								<th>Remark</th>
								<th style="width:95px";>Action</th>
								 
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
							<?php  
							/* echo "<pre>";
							print_r($studentRefundRequestList);die; */
							if(isset($studentRefundRequestList) && !empty($studentRefundRequestList)){
								
								 $sn = 1;
								foreach($studentRefundRequestList as $refundRequestList){ ?> 
								
								<tr>
									<td>
									<?php if(isset($refundRequestList['status']) && $refundRequestList['status'] == 'pending'){ ?>
										<input type="checkbox" name="checkedRefund[]" value="<?=$refundRequestList['id']?>">
									<?php } ?>
									</td>
									<td><?php echo $sn; ?></td>
									<td class="enrollment_no"><?= $refundRequestList['enrollment_no'] ?></td>
									
									<?php
										if($refundRequestList['request_type'] == "cancel_admission"){
											$request_type = 'Cancel Admission';
										}
									?>

									<td class="request_type"><?= $request_type ?></td> 
									<td><?= $refundRequestList['bank_name'] ?></td> 
									<td><?= $refundRequestList['student_bank_ac_no'] ?></td> 
									<td><?= $refundRequestList['student_bank_ac_holder_name'] ?></td> 
									<td><?= $refundRequestList['student_bank_ifsc'] ?></td>
									<td class="academic_year"><?= $refundRequestList['academic_year'] ?></td>  
									<td><?= $refundRequestList['total_paid_amount'] ?>&nbsp;<i class="fa fa-rupee"></i></td> 
									<td><?= $refundRequestList['processing_charge'] ?>&nbsp;<i class="fa fa-rupee"></i></td> 
									<td><?= $refundRequestList['total_refundable_amt'] ?>&nbsp;<i class="fa fa-rupee"></i></td> 
									<td><?= $refundRequestList['created_on'] ?></td> 
									<td>
										<?php 
											$url = base_url(
												'Upload/get_document/' 
												. $refundRequestList['student_cancel_cheque'] 
												. '?b_name=' . urlencode(ACADEMIC_YEAR . '/refunds/')
											);
										?>
									
										<a href="<?= $url ?>" target="_blank">
											<?= $refundRequestList['student_cancel_cheque'] ? 'View' : '' ?>
										</a>
									</td>
									<td>
									<!--onchange="change_status(this)"-->
									
									<?php 
										if(isset($refundRequestList['status']) && $refundRequestList['status'] == 'pending'){
											$status = 'Pending';
										}
										
										if(isset($refundRequestList['status']) && $refundRequestList['status'] == 'hod_approved'){
											$status = 'Approved By HOD';
										}
										
										if(isset($refundRequestList['status']) && $refundRequestList['status'] == 'cancel'){
											$status = 'Cancel';
										}
										
										if(isset($refundRequestList['status']) && $refundRequestList['status'] == 'approved'){
											$status = 'Approved';
										}
										
										if(isset($refundRequestList['status']) && $refundRequestList['status'] == 'refunded'){
											$status = 'Refunded';
										}
									?>
									
									
									<?= $status ?>
									</td>
									<td><?= $refundRequestList['remark'] ?></td>
									<td>
									
										<!--<a href="<?php //echo site_url('ums_admission/view_studentFormDetails/'.$refundRequestList['student_id'])?>" class="btn btn-primary btn-sm active" role="button" aria-pressed="true" target="_blank" style="float:left">View</a>-->
										
										<a href="<?php echo site_url('ums_admission/view_studentFormDetails/'.$refundRequestList['student_id'])?>"  role="button" aria-pressed="true" target="_blank" style="float:left" title="View">
											<img src="<?php echo base_url() ?>assets/images/view-gif.gif" style="height:45px;width:35px;float:left">
										</a>&nbsp;
										<?php if($_SESSION['role_id'] ==2){ ?>
											<a href="javascript:void(0);" onclick="openCancelModal(this)">
												<img src="<?php echo base_url() ?>assets/images/cancel-gif.gif" style="height:45px;width:35px;" title="Cancel Admission"> 
											</a>
										<?php } ?>
										
										
									
									</td>
									 
								</tr>
								<?php $sn++;}}else{ ?>
								 
									<tr> <td colspan=13 ><center>No Record Found</center></td></tr>
							<?php } ?>
                                                       
                        </tbody>
                    </table>               
                    </form>
                </div>
                </div>
                </div>
            </div>
            </div>    
        </div> 


		
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Admission Cancel Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<form action="<?php echo base_url() ?>Ums_admission/cancel_student_admission" method="post">
				
				  <div class="form-group">
					<label for="academic-year" class="col-form-label">Academic Year</label>
					<input type="text" class="form-control" id="academic_year" name="academic_year" readonly>
				  </div>
				  
				  <div class="form-group">
					<label for="enrollment-no" class="col-form-label">Enrollment No</label>
					<input type="text" class="form-control" id="enrollment_no" name="enrollment_no" readonly>
				  </div>
				   <div class="form-group">
					<label for="cancel-date" class="col-form-label">Cancel Date</label>
					<input type="date" class="form-control" id="cancel_date" name="cancel_date">
				  </div>
				  <div class="form-group">
					<label for="message-text" class="col-form-label">Remark</label>
					<textarea class="form-control" id="remark" name="cancel_remark"></textarea>
				  </div>
			
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save</button>
				</form>
			  </div>
			</div>
		  </div>
		</div>


		
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
 //Added By; Amit Dubey AS On 14-04-2025
	$(document).ready(function() {
		$("#export").click(function() {
			$("#export_flag").val("1"); // Set export flag to 1
			// $("#refundForm").submit();  // Submit the form
		});
	});
	
	function openCancelModal(el){
		 var row = el.closest('tr');
		 
		var enrollmentNo = row.querySelector('.enrollment_no').textContent.trim();
		var academic_year = row.querySelector('.academic_year').textContent.trim();
	 
		$('#enrollment_no').val(enrollmentNo);
		$('#academic_year').val(academic_year);
	 
		 $('#exampleModal').modal('show');
		//alert('amit');
	}
	
	 
</script>  
