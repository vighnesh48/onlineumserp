<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<link href="<?= site_url() ?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?= site_url() ?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js" type="text/javascript"></script>

<div id="content-wrapper">
	<ul class="breadcrumb breadcrumb-page">
		<div class="breadcrumb-label text-light-gray">You are here: </div>
		<li class="active"><a href="#">Masters</a></li>
		<li class="active"><a href="#">Student Application details</a></li>
	</ul>
	<div class="page-header">
		<div class="row">
			<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Enquiry Details</h1>
			<div class="col-xs-12 col-sm-8">
				<div class="row">
					<hr class="visible-xs no-grid-gutter-h">
					
					
						<div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?= base_url("StudentRegistration/New_Enquiry") ?>"><span class="btn-label icon fa fa-plus"></span>Add Application Form</a></div>
						<div class="visible-xs clearfix form-group-margin"></div>
					
				

				
				</div>
			</div>
		</div>
		<br />

		<div class="panel">
			<div class="panel-heading panel-info">
				<h1>Enquiry Details</h1>
			</div>

			<div class="panel-body">
				<div class="row">
					<div class="table-info" style="overflow:scroll;height:800px;">
						<table class="table table-bordered table-list-search table-striped" id="example">
							<thead>
								<tr>
									<th>Sr.No</th>
									<?php if (($role_id == '4') || ($role_id == '8') || ($role_id == '7') || ($role_id == '1')  || ($role_id == '30') || ($role_id == '27')) { ?>
										<th>Consultant Name</th>
									<?php } ?>
									<th>Enquired Student Name</th>
									<th>Admitted Student Name</th>
									<th>Campus</th>
									<th>Enquiry No</th>
									<th>Aadhar Card No</th>
									<th>Mobile</th>
									<th>State/District/City</th>
									<th>Course Interested</th>
									<th>Lead Status</th>
									<th>Fees Details
										<br>
										Applicable/Paid
									</th>
									<th>Remuneration</th>
								</tr>
							</thead>
							<tbody id="itemContainer">
								<?php
								if (!empty($smd)) {
									$j = 1;
									foreach ($smd as $row) {
										$y = $acd1 = $this->config->item('current_year');
										$current_year = explode('-', $acd1);
										$acd = $current_year[0];

										if ($row->Campus == 'SUN' || $row->Campus == 'SF') {
											if ($row->Campus_City == 1) {
												$DB1 = $this->load->database('umsdb', TRUE);
												$ICDB = $this->load->database('icdb', TRUE);
												$datas = $DB1->query("select a.amount as renum,sm.first_name,sm.enrollment_no,sm.cancelled_admission,admission_confirm,adm.applicable_fee,fees_paid from student_master sm 
							left join
							(select sum(sandipun_ums.fees_details.amount) as fees_paid,sandipun_ums.fees_details.student_id from sandipun_ums.fees_details where sandipun_ums.fees_details.type_id=2 and sandipun_ums.fees_details.academic_year='$acd' and sandipun_ums.fees_details.chq_cancelled='N' and sandipun_ums.fees_details.is_deleted='N' group by sandipun_ums.fees_details.student_id) as
							fees_details on fees_details.student_id=sm.stud_id
							left join sandipun_ums.admission_details adm on sm.stud_id=adm.student_id and adm.academic_year='$acd' 
							left join  sandipun_ic_erp22.admission_benefits_and_source as a on sm.stud_id=a.student_id and belong_to_ic=4 and is_for=1 and a.benefit_to=" . $row->creator . " where adhar_card_no='" . $row->aadhar_card . "' and admission_session='$acd' and adhar_card_no !='' and adhar_card_no !=0 ")->row();
											} else {
												$DB1 = $this->load->database('ums_sijoul', TRUE);
												$datas = $DB1->query("select   a.amount as renum,sm.first_name,sm.enrollment_no,sm.cancelled_admission,admission_confirm,adm.applicable_fee,fees_paid from student_master sm 
							left join
							(select sum(sandipun_ums_sijoul.fees_details.amount) as fees_paid,sandipun_ums_sijoul.fees_details.student_id from sandipun_ums_sijoul.fees_details where sandipun_ums_sijoul.fees_details.type_id=2 and sandipun_ums_sijoul.fees_details.academic_year='$acd' and sandipun_ums_sijoul.fees_details.chq_cancelled='N' and sandipun_ums_sijoul.fees_details.is_deleted='N' group by sandipun_ums_sijoul.fees_details.student_id) as
							fees_details on fees_details.student_id=sm.stud_id
							left join sandipun_ums_sijoul.admission_details adm on sm.stud_id=adm.student_id and adm.academic_year='$acd'
							left join  sandipun_ic_erp22.admission_benefits_and_source as a on sm.stud_id=a.student_id and belong_to_ic=4 and is_for=2 and a.benefit_to=" . $row->creator . " where adhar_card_no='" . $row->aadhar_card . "' and admission_session='$acd' and adhar_card_no !='' and adhar_card_no !=0 ")->row();
											}
										} else {
											$datas = $ICDB->query("select   a.amount as renum,sm.student_name as first_name,sm.enrollment_no,sm.is_cancelled as cancelled_admission,'Y' as admission_confirm,applicable_fees as applicable_fee,paid_fees as fees_paid from sf_admission_data sm  left join  sandipun_ic_erp22.admission_benefits_and_source as a on sm.id=a.student_id and belong_to_ic=4 and is_for=3 and a.benefit_to=" . $row->creator . " where aadhar_card='" . $row->aadhar_card . "' and sm.academic_year='$acd1' and aadhar_card !='' and aadhar_card !=0")->row();
										}
								?>
										<tr>
											<td><?= $j ?></td>
											<?php if (($role_id == '4') || ($role_id == '8') || ($role_id == '7') || ($role_id == '1')  || ($role_id == '30') || ($role_id == '27')) { ?>
												<td><?= $row->contact_person; ?></td>
											<?php } ?>
											<td><?= $row->first_name . " " . $row->middle_name . " " . $row->last_name; ?></td>
											<td><?
												if (!empty($datas)) {
													echo $datas->first_name;
												} else {
													echo "--";
												}

												?></td>
											<td><?php
												if ($row->Campus == 'SUN') {
													if ($row->Campus_City == 1) {
														echo "Nashik";
													} else {
														echo "Sijoul";
													}
												} else {
													echo "SF";
												}


												?></td>
											<td><?php
												if (!empty($datas)) {
													echo $row->enquiry_no;
												} else { ?>
													<a href="<?php echo base_url('StudentRegistration/New_Enquiry/0/' . $row->enquiry_no); ?>" target="_blank"><?php echo $row->enquiry_no; ?></a>
												<?php   }

												?>
											</td>
											<td><?= $row->aadhar_card; ?></td>
											<td><?= $row->mobile1; ?></td>
											<td><?= $row->state_name . "/" . $row->district_name . "/" . $row->taluka_name; ?></td>
											<td><?= $row->school_code . ":" . $row->course; ?></td>
											<td>
												<?php

												if (!empty($datas)) {
													if ($datas->cancelled_admission == 'Y' || $datas->cancelled_admission == 1) {
														echo "Cancelled";
													} else if ($datas->admission_confirm == 'Y') {
														echo "Confirm Admission";
														echo ":" . $datas->enrollment_no;
													} else {
														echo "Provisional Admission";
														echo ":" . $datas->enrollment_no;
													}
												} else {
													echo "Enquiry";
												}
												?>
											</td>
											<td>
												<?php
												if (!empty($datas)) {
													echo $datas->applicable_fee . "/" . $datas->fees_paid;
												} else {
													echo "--";
												}

												?>
											</td>
											<td>
												<?php
												if (!empty($datas)) {
													echo $datas->renum;
												} else {
													echo "--";
												}

												?>
											</td>
										</tr>
								<?php $j++;
									}
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#example').DataTable({
				dom: 'Bfrtip',
				"bPaginate": false,
				buttons: [
					'excel', 'print'
					//'copy', 'csv', 'excel', 'pdf', 'print'
				]
			});
		});
	</script>