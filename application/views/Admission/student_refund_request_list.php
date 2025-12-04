<?php //error_reporting(E_ALL); ini_set('display_errors', 1);?>
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
			
			<br>
				<?php if ($this->session->flashdata('error')): ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert" style="width:50%;">
					<?php echo $this->session->flashdata('error'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				<?php endif; ?>

				<?php if ($this->session->flashdata('success')): ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert" style="width:50%;">
					<?php echo $this->session->flashdata('success'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				<?php endif; ?>
			
                <div class="panel">
				<div class="panel-heading">
                    <span class="panel-title">Refund Request List</span>
					
					<div class="col-sm-1" style="margin-top:-4px;float:right">
					<a href="<?php echo base_url()?>ums_admission/student_cancelation_request" class="btn btn-primary form-control" id="sbutton" type="submit">Add Request</a>
				</div>
                </div>
				
				
         
            <div class="table-info panel-body">  
	
			
                <div class="col-lg-12">
                    <div class="table-info table-responsive" id="stddata" >    
                   <table class="table table-bordered" width="100%" id="example">
                        <thead>
                            <tr>
								<th>Sn</th>
								<th>Enrollment No</th>
								<th>Request For</th>
								<th>Bank Account No</th>
								<th>Bank IFSC</th>
								<th>Academic Year</th>
								<th>Requested Date</th>
								<th>Cancelled Cheque</th>
								<th>Status</th>
								<th>Remark</th>
								<th>Management Remark</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
							<?php  
							 $sn = 1;
							foreach($studentRefundRequestList as $refundRequestList){ ?>
                            <tr>
                                <td><?php echo $sn; ?></td>
                                <td><?= $refundRequestList['enrollment_no'] ?></td>
								
								<?php
								    //
								    if($refundRequestList['request_type'] == "hostel"){
										$request_type = 'Hostel';
									}
									//
									if($refundRequestList['request_type'] == "transport"){
										$request_type = 'Transport';
									}
									//
									if($refundRequestList['request_type'] == "uniform"){
										$request_type = 'Uniform';
									}
									//
									if($refundRequestList['request_type'] == "excess_fees"){
										$request_type = 'Excess Fees';
									}
									//
									if($refundRequestList['request_type'] == "cancel_admission"){
										$request_type = 'Cancel Admission';
									}
								?>

                                <td><?= $request_type ?></td> 
								<td><?= $refundRequestList['student_bank_ac_no'] ?></td> 
                                <td><?= $refundRequestList['student_bank_ifsc'] ?></td>
                                <td><?= $refundRequestList['academic_year'] ?></td> 
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
							
								<?php
								    //
								    if($refundRequestList['status'] == "pending"){
										$status = 'Pending';
									}
									//
									if($refundRequestList['status'] == "under_review"){
										$status = 'Under Review';
									}
									//
									if($refundRequestList['status'] == "approved"){
										$status = 'Approved';
									}
									//
									if($refundRequestList['status'] == "rejected"){
										$status = 'Rejected';
									}
									//
									if($refundRequestList['status'] == "refunded"){
										$status = 'Refunded';
									}
									//
									if($refundRequestList['status'] == "hod_approved"){
										$status = 'HOD Approved';
									}
									
								?>
                                <td><?= $status ?></td>
                                <td><?= $refundRequestList['remark'] ?></td>
                              <td><?= wordwrap($refundRequestList['management_remark'], 50, "<br>") ?></td>
						 
                            </tr>
							<?php $sn++;} ?>
                                                       
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
