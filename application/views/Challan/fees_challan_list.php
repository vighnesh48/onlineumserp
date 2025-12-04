<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<link href="<?= site_url() ?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?= site_url() ?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<?php //print_r($my_privileges); die; 
?>
<div id="content-wrapper">
	<ul class="breadcrumb breadcrumb-page">
		<div class="breadcrumb-label text-light-gray">You are here: </div>
		<li class="active"><a href="#">Fees challan</a></li>

	</ul>
	<div class="page-header">
		<div class="row">
			<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Fees challan List</h1>
			<span id="err_msg1" style="color:red;"></span>
			<div class="col-xs-12 col-sm-8">
				<div class="row 
				<?php if (isset($only_view) && $only_view == 1) {
					echo "hidden";
				} ?>
				
				">
					<hr class="visible-xs no-grid-gutter-h">
					<div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" target="_blank" class="btn btn-primary btn-labeled" href="<?= base_url("Challan_new/getchallanlist") ?>"><span class="btn-label icon fa fa-plus"></span>Report </a></div>
					<?php //if (in_array("Add", $my_privileges)) { ?>
						<div class="pull-right col-xs-12 col-sm-auto">
							<a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?= base_url($currentModule . "/add_fees_challan") ?>"><span class="btn-label icon fa fa-plus"></span>Generate </a> 
							<!-- <a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?= base_url($currentModule . "/generateFeesChallan") ?>"><span class="btn-label icon fa fa-plus"></span>Generate </a>-->
						</div>
					<?php //} ?>
				</div>
			</div>

			<span id="flash-messages" style="color:Green;padding-left:50px;">
				<?php if (!empty($this->session->flashdata('message1'))) {
					echo $this->session->flashdata('message1');
				} ?></span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
				<?php if (!empty($this->session->flashdata('message2'))) {
					echo $this->session->flashdata('message2');
				} ?></span>

		</div>

		<div class="row ">
			<div class="col-sm-12">
				<div class="panel">
					<div class="panel-heading">
						<div class="row <?php if (isset($only_view) && $only_view == 1) {
											echo "hidden";
										} ?>">
										
										
							<div class="col-md-2">
								<?php $schoolSession = isset($_SESSION['school']) ? $_SESSION['school'] : ''; ?>
								<label>School<span style="color:red">*</span></label>
								<select class="form-control" name="school_id" id="school_id"  style="width:160px;<?= (!empty($schoolSession) && $schoolSession!=SITRC) ? 'pointer-events: none; background-color: #eee;' : '' ?>">
									<option value="">--Select School--</option>
									

									
										<?php foreach ($school_list as $school) {?>
												<option value="<?= $school['school_id'] ?>" <?= ($schoolSession == $school['school_id']) ? 'selected' : '' ?>><?= $school['school_short_name']; ?></option>
												
										<?php } ?>
							
								</select>
							</div>
										
							<div class="col-md-2">
								<label style="margin-left:-55px">Academic Year<span style="color:red">*</span></label>
								<select class="form-control" name="academic_year" id="academic_year" style="width:160px;margin-left:-60px">
									<option value="" disabled selected>--Academic Year--</option>
									<?php 
											// Generate dynamic academic years from 2008 to current year
											$currentYear = date('Y');
											for ($year = 2008; $year <= $currentYear; $year++) {
												//$nextYear = substr($year + 1, -2);
												$academicYear = $year;
												$selected = '';
												/* if (!empty($academic_details)) {
													foreach ($academic_details as $academic) {
														if ($academic['academic_year'] == $academicYear && $academic['status'] == 'Y') {
															$selected = 'selected';
															break;
														}
													}
												} */
												?>
												<option value="<?= $academicYear ?>" <?= $selected ?>><?= $academicYear ?></option>
											 <?php 
											} 
											?>
								</select>
							</div>
							
							<div class="col-md-2" style="margin-left:-75px">
								<label style="margin-left:-55px">Challan Type<span style="color:red">*</span></label>
								<select class="form-control" name="challan_type" id="challan_type" style="width:160px;margin-left:-60px">
									<option value="2">Academic Challan</option>
									<option value="5">Exam Challan</option>
								</select>
							</div>
							
							<div class="col-md-2" style="margin-left:-90px">
							<label>Recepit&nbsp;No</label>
								<input type="text" class="form-control" name="Recepitid" id="Recepitid" value="" style="width:160px"/>
							</div>


							<div class="col-md-2" style="margin-left:-60px">
								<label>OR&nbsp;Enrollment</label>
								<input type="text" class="form-control" name="Mobileid" id="Mobileid" value="" style="width:160px;"/>
							</div>
							
						
							<div class="col-md-2" style="margin-left:-60px">
								<label>OR&nbsp;Transaction</label>
								<input type="text" class="form-control" name="transactionno" id="transactionno" value="" style="width:160px;"/>
							</div>
							
							<div class="col-sm-1" style="margin-top:25px;margin-left:-60px">
								<button type="button" name="Search" id="Search" class="btn btn-info">Search</button>
							</div>
							
							<div class="col-sm-1" style="margin-top:25px; margin-left:-30px">
								<button type="button" name="back" id="back" class="btn btn-info">back</button>

							</div>
						</div>
						<div class="row" style="display:none;">
							<!--label class="col-sm-1">Status</label>-->
							<div class="col-sm-3">
								<select class="form-control" name="status" id="status">
									<option value="">Select challan Status</option>
									<option value="VR">Deposited</option>
									<option value="PD">Pending</option>
									<option value="CL">Cancelled</option>
								</select>
							</div>
							<div class="col-sm-3">
								<select class="form-control" name="selectby" id="selectby">
									<option value="">Select By Duration</option>
									<option value="Datewise">Datewise</option>
									<option value="Between">Between Dates</option>
								</select>
							</div>

							<div class="form-group" id="datewise" style="display:none;">
								<!--<label class="col-sm-1">Date: <?= $astrik ?></label>-->
								<div class="col-sm-2">
									<input type="text" class="form-control" id="doc-sub-datepicker20" name="date" required readonly="true" />
								</div>
							</div>

							<div class="form-group" id="between" style="display:none;">

								<div class="col-sm-2">
									<input type="text" class="form-control" id="doc-sub-datepicker21" name="fdate" required readonly="true" />
								</div>
								<label class="col-sm-1">Between</label>

								<div class="col-sm-2">
									<input type="text" class="form-control" id="doc-sub-datepicker23" name="tdate" required readonly="true" />
								</div>
							</div>

								<!--
							<label class="col-sm-1">From</label>
							<div class="col-sm-2">
							  <input type="text" class="form-control" id="doc-sub-datepicker20" data-provide="datepicker" name="fdate" required readonly="true"/>
							</div>
							<label class="col-sm-1">To </label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="doc-sub-datepicker21" data-provide="datepicker" name="tdate" required readonly="true"/>
							</div>				
							<div class="col-sm-2"></div>
							<div class="col-sm-1">
								<label >Search:</label>
							</div>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="search" name="search" />
							</div>-->
						</div>
					</div>

					<div class="panel-body">

						<!-- Modal -->
						<div id="myModal1" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content" style="width:800px;">
									<div class="modal-header  panel-success">
										<b>Fees challan Details</b>
									</div>
									<div class="modal-body">



										<div class="panel-body">
											<div class="table-info table-responsive">
												<form name="form" id="form" action="<?= base_url($currentModule . '/challan_approval_submit') ?>" method="POST">
													<input type="hidden" id="feesid" name="feesid" />

													<div class="row">
														<div class="col-sm-12">
															<table class="table table-bordered">
																<tr>
																	<th scope="col">Name :</th>
																	<td><span id="std_name"></span></td>
																	<th scope="col">PRN :</th>
																	<td><span id="prn"></span></td>
																</tr>
																<tr>
																	<th scope="col">Challan Number :</th>
																	<td><span id="challan"></span></td>
																	<th scope="col">Academic Year :</th>
																	<td><span id="acadmic"></span></td>
																</tr>
																<tr>
																	<th scope="col">Course :</th>
																	<td><span id="course"></span></td>
																	<th scope="col">Institue :</th>
																	<td><span id="institue"></span></td>
																</tr>
																<tr>
																	<th scope="col">Deposit fee:</th>
																	<td><span id="deposit"></span></td>
																	<th scope="col">Facility fee :</th>
																	<td><span id="ffee"></span></td>
																</tr>
																<tr>
																	<th scope="col">Other fee:</th>
																	<td><span id="ofee"></span></td>
																	<th scope="col">Amount :</th>
																	<td><span id="amt"></span></td>
																</tr>
																<tr>
																	<th scope="col">Paid Type:</th>
																	<td><span id="paidtype"></span></td>
																	<th scope="col">Receipt Number :</th>
																	<td><span id="receipt"></span></td>
																</tr>
																<tr>
																	<th scope="col">Fees date:</th>
																	<td><span id="feedate"></span></td>
																	<th scope="col">Deposited to:</th>
																	<td><span id="depositto"></span></td>
																</tr>
																<tr>
																	<th scope="col">Bank :</th>
																	<td><span id="bank"></span></td>
																	<th scope="col">Bank Branch :</th>
																	<td><span id="branch"></span></td>
																</tr>
																<tr>
																	<th scope="col">challan status :</th>
																	<td><span id="cstatus"></span></td>
																</tr>
															</table>


														</div>

													</div>
													<div class="row">
														<label class="col-sm-2">Enter Remark: <?= $astrik ?></label>
														<div class="col-sm-3">
															<input class="form-control col-sm-3" type="text" id="remarks" name="remarks" />
														</div>
														<div class="col-sm-4">
															<span id="err_msg" style="color:red;"></span>
														</div>
													</div>
											</div>

											<div id="app_rej_btn">
												<div class="col-sm-2">
													<button class="btn btn-primary form-control" id="approve" name="approve" type="submit">Verified</button>
												</div>


												<div class="col-sm-2">
													<button class="btn btn-primary form-control" id="reject" name="reject">Cancelled</button>
												</div>

											</div>

											</form>

										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>

						<form action="<?= base_url($currentModule . '/deposite_fees_challan_submit') ?>" method="POST" id="depositForm">
							<button type="submit" class="btn btn-success" id="depositBtn" disabled style="margin-bottom: 10px;">Deposit Challan</button>
							<div class="table-info table-responsive">
							<div id="loader" style=" display: none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: rgba(255,255,255,0.7);z-index: 9999;text-align: center;padding-top: 350px;">
								  <img src="<?= base_url() ?>assets/images/loading.gif" alt="Loading..." style="width:100px;height:100px;">
							</div> 
								<table class="table table-bordered" style="width:100%;max-width:100%;">
									<thead>
										<tr>
											<th><!--<input type="checkbox" id="checkAll" />--></th>
											<th>#</th>
											<th>Challan</th>
											<th>Student Id</th>
											<th>Name</th>
											<th>Paid Date</th>
											<th>TransactionNo</th>
											<th>Amount</th>
											<th>Payment Status</th>
											<th>Challan Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody id="itemContainer">
										<?php
										$j = 1;
										for ($i = 0; $i < count($challan_details); $i++) {

										?>
											<tr>
												<td>
												<?php if ($challan_details[$i]['challan_status'] == 'PD' && $challan_details[$i]['type_id'] == 5){ ?>
													<input type="checkbox" name="fees_id[]" value="<?= $challan_details[$i]['fees_id'] ?>" />
												<?php }else{ 
												
												 } ?>
												</td>
												<td><?= $j ?></td>
												<td><?= $challan_details[$i]['exam_session'] ?></td>
												<td>
													<?php if ($challan_details[$i]['type_id'] == 11) {
														echo 'External';
													} else { ?>
														<?= $challan_details[$i]['enrollment_no'] ?><?php } ?></td>
												<td>
													<?php if ($challan_details[$i]['type_id'] == 11) {
														echo $challan_details[$i]['guest_name'];
													} else { ?>
														<?= $challan_details[$i]['first_name'] ?> <?= $challan_details[$i]['last_name'] ?>
													<?php } ?></td>
												
												<td><?php
													echo date("d/m/Y", strtotime($challan_details[$i]['created_on']));
													?></td>
												<td><?= $challan_details[$i]['TransactionNo'] ?></td>
												<td><?= $challan_details[$i]['amount'] ?></td>
												<td><span style="color:green">Success</span></td>
												<td><?php if ($challan_details[$i]['challan_status'] == 'VR') echo '<span style="color:Green" >Deposited</span>';
													else if ($challan_details[$i]['challan_status'] == 'CL') echo '<span style="color:red" >Cancelled</span>';
													else echo '<span style="color:#1d89cf" >Pending</span>'; ?></td>
												<td>
													<!--  <a title="View challan Details" class="btn btn-primary btn-xs" onclick="fullview_challan('<?= $challan_details[$i]['fees_id'] ?>')">View</a>
								-->
													<?php //if(in_array("Add", $my_privileges)) { 
													?>
													<a title="View challan Details" class="btn btn-primary btn-xs <?php if (isset($only_view) && $only_view == 1) {
																														echo "hidden";
																													} ?>" href="<?= base_url($currentModule . "/edit_challan/" . $challan_details[$i]['fees_id']) ?>">View</a>
													<?php //}
													?>
													<a href="<?= base_url($currentModule . "/download_challan_pdf/" . $challan_details[$i]['fees_id']) ?>" title="View" target="_blank" <?= $disable ?>><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px;color:red;"></i> </a>
												</td>

											</tr>
										<?php
											$j++;
										}
										?>
									</tbody>
								</table>
						
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
 
<script>
	/** For challan checkbox, start* */
	// const checkAllBox = document.getElementById('checkAll');
	const depositBtn = document.getElementById('depositBtn');

	function toggleDepositButton() {
		const checkboxes = document.querySelectorAll('input[name="fees_id[]"]');
		const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
		depositBtn.disabled = !anyChecked;
	}

	/*checkAllBox.addEventListener('change', function() {
		const checkboxes = document.querySelectorAll('input[name="fees_id[]"]');
		checkboxes.forEach(cb => cb.checked = this.checked);
		toggleDepositButton();
	});*/

	document.querySelectorAll('input[name="fees_id[]"]').forEach(checkbox => {
		checkbox.addEventListener('change', toggleDepositButton);
	});

	document.addEventListener("DOMContentLoaded", toggleDepositButton);
	/** For challan checkbox, end* */


	var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
		"Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
	];

	var onedate = '',
		fdate = '',
		tdate = '',
		onedate_dd = '',
		fdate_dd = '',
		tdate_dd = '',
		onedate_mm = '',
		fdate_mm = '',
		tdate_mm = '',
		onedate_yy = '',
		tdate_yy = '';
	var html_content = "",
		type = "",
		url = "",
		datastring = "";

	function validate_form(events) {
		var remark = $('#remarks').val();
		if (remark == '') {
			$('#err_msg').html('please enter remarks');
			return false;
		} else {
			$('#err_msg').html('');
		}
	}

	$(document).ready(function() {
		$("#back").click(function() {
			//window.history.back();
			window.location.href = '<?= base_url() ?>Challan'

		});
		$("#Search").click(function() {
			 
			var Recepit = $("#Recepitid").val();
			var Mobile = $("#Mobileid").val();
			var transactionno = $("#transactionno").val();
			var academic_year = $("#academic_year").val();
			var school_id = $("#school_id").val();
			var challan_type = $("#challan_type").val();
			 
			// alert(Recepit);
			if ((Recepit == '') && (Mobile == '') && (transactionno == '') && (academic_year == '' || academic_year == null)) {
				alert("Mandatory Field can not be empty");
				return false;
			} else {
				
				$("#loader").show();

				type = 'POST', url = '<?= base_url() ?>Challan/Search';
				datastring = {
					Recepit: Recepit,
					Mobile: Mobile,
					transactionno: transactionno,
					academic_year: academic_year,
					school_id: school_id,
					challan_type: challan_type
				};
				
				//html_content = ajaxcall(type, url, datastring);
				//display_content(html_content);  
				setTimeout(function(){
					html_content = ajaxcall(type, url, datastring);
					$("#loader").hide();
					display_content(html_content);
				}, 100);
				
				
			}

		})

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!
		var mmm = today.getMonth();
		var yyyy = today.getFullYear();
		if (dd < 10) {
			dd = '0' + dd;
		}
		if (mm < 10) {
			mm = '0' + mm;
		}
		var today = dd + '/' + mm + '/' + yyyy;

		//$('#header_date').html(dd+" "+monthNames[mmm]+", "+yyyy%100);

		$('#doc-sub-datepicker20').val(today);
		$('#doc-sub-datepicker21').val(today);
		$('#doc-sub-datepicker23').val(today);

		$('#doc-sub-datepicker20')
			.datepicker({

				autoclose: true,
				todayHighlight: true,
				format: 'dd/mm/yyyy',
				setDate: new Date()

			});
		$('#doc-sub-datepicker21').datepicker({
			todayHighlight: true,
			format: 'dd/mm/yyyy',
			autoclose: true,
			setDate: new Date()
		});
		$('#doc-sub-datepicker23').datepicker({
			todayHighlight: true,
			format: 'dd/mm/yyyy',
			autoclose: true,
			setDate: new Date()
		});

		$('#selectby').change(function() {

			if (this.value == 'Datewise') {
				$('#between').hide();
				$('#datewise').show();
			} else if (this.value == 'Between') {
				//alert("home");
				$('#between').show();
				$('#datewise').hide();
			} else {
				$('#between').hide();
				$('#datewise').hide();
			}
			common_call();
		});


		$('#status').change(function() {
			common_call();
		});

		$('#doc-sub-datepicker20').on('changeDate', function(e) {
			common_call();
		});

		$('#doc-sub-datepicker21').on('changeDate', function(e) {
			common_call();
		});

		$('#doc-sub-datepicker23').on('changeDate', function(e) {
			common_call();
		});

	});

	function common_call() {
		var status = $('#status').val();
		var selectby = $('#selectby').val();
		var odate = $('#doc-sub-datepicker20').val();
		var fdate = $('#doc-sub-datepicker21').val();
		var tdate = $('#doc-sub-datepicker23').val();
		type = 'POST', url = '<?= base_url() ?>Challan/challan_list_by_creteria';
		if (selectby != '' && selectby == 'Between') {
			if ((Date.parse(tdate) < Date.parse(fdate))) {
				$('#err_msg1').html('To date should be greater than From date');
			} else {
				$('#err_msg1').html('');
				datastring = {
					status: status,
					tdate: tdate,
					fdate: fdate
				};
				html_content = ajaxcall(type, url, datastring);
				display_content(html_content);
			}
		} else if (selectby != '' && selectby == 'Datewise') {
			$('#err_msg1').html('');
			datastring = {
				status: status,
				odate: odate
			};
			html_content = ajaxcall(type, url, datastring);
			display_content(html_content);
		} else {
			$('#err_msg1').html('');
			datastring = {
				status: status
			};
			html_content = ajaxcall(type, url, datastring);
			display_content(html_content);
		}
	}

	// old code backup before modification, by Amit Dubey

	// var challan_status='';
	// function display_content(html_content)
	// {
	// 	var content='';
	// 	if(html_content === "{\"std_challan_list\":[]}")
	// 	{
	// 		$('#itemContainer').html('No Data!!');
	// 	}
	// 	else
	// 	{
	// 		var array=JSON.parse(html_content);
	// 		len=array.std_challan_list.length;
	// 		//alert(len+"==="+html);
	// 		var j=1;
	// 		for(i=0;i<len;i++)
	// 		{
	// 			//alert(array.std_challan_list[i].student_id); '<td>' + checkbox + '</td>'
	// 			content+='<tr><td>'++'</td><td>'+array.std_challan_list[i].exam_session+'</td><td>'+array.std_challan_list[i].enrollment_no+'</td><td>'+array.std_challan_list[i].first_name+' '+array.std_challan_list[i].last_name+'</td><td>'+array.std_challan_list[i].amount+'</td>';

	// 			fdate = new Date(array.std_challan_list[i].fees_date);
	// 			fdate_dd = fdate.getDate();
	// 			fdate_mm = fdate.getMonth()+1;
	// 			tdate_yy = new Date(array.std_challan_list[i].fees_date).getFullYear();
	// 			if(fdate_dd<10){
	// 			fdate_dd='0'+fdate_dd;
	// 			} 
	// 			if(fdate_mm<10){
	// 			fdate_mm='0'+fdate_mm;
	// 			}
	// 			//alert(fdate_dd+' '+fdate_mm+' '+tdate_yy);
	// 			content+='<td>'+fdate_dd+'/'+fdate_mm+'/'+tdate_yy+'</td><td>'+array.std_challan_list[i].TransactionNo+'</td>';

	// 			if(array.std_challan_list[i].challan_status=='VR')
	// 				challan_status='<span style="color:Green" >Deposited</span>';
	// 			else if(array.std_challan_list[i].challan_status=='CL')
	// 				challan_status='<span style="color:red" >cancelled</span>';
	// 			else 
	// 				challan_status='<span style="color:#1d89cf" >Pending</span>';

	// 			content+='<td>'+challan_status+'</td><td><a title="View challan Details" class="btn btn-primary btn-xs" href="<?= base_url($currentModule . "/edit_challan") ?>/'+array.std_challan_list[i].fees_id+'">View</a><a href="<?= base_url($currentModule . "/download_challan_pdf") ?>/'+array.std_challan_list[i].fees_id+'" title="Download PDF" target="_blank" <?= $disable ?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a></td>';

	// 			j++;
	// 		}
	// 		$('#itemContainer').html(content);
	// 	}
	// }

	var challan_status = '';

	function display_content(html_content) {
		var content = '';

		if (html_content === "{\"std_challan_list\":[]}") {
			$('#itemContainer').html('No Data!!');
		} else {
			var array = JSON.parse(html_content);
			var challans = array.std_challan_list;
			var j = 1;

			for (var i = 0; i < challans.length; i++) {
				var challan = challans[i];
				var statusText = '';
				var statusColor = '';
				var viewButton = '';
				var checkbox = '';
				var paymentStatus = '';

				var dateObj = new Date(challan.fees_date);
				var dd = ('0' + dateObj.getDate()).slice(-2);
				var mm = ('0' + (dateObj.getMonth() + 1)).slice(-2);
				var yyyy = dateObj.getFullYear();
				var formattedDate = dd + '/' + mm + '/' + yyyy;

				if (challan.challan_status === 'VR') {
					statusText = 'Deposited';
					statusColor = 'Green';
					paymentStatus = 'Success';
				} else if (challan.challan_status === 'CL') {
					statusText = 'Cancelled';
					statusColor = 'Red';
					paymentStatus = '';
				} else {
					statusText = 'Pending';
					statusColor = '#1d89cf';
					paymentStatus = 'Success';
				}

				if (challan.challan_status !== 'VR') {
					checkbox = '<input type="checkbox" name="fees_id[]" value="' + challan.fees_id + '">';
					viewButton = '<a title="View challan Details" class="btn btn-primary btn-xs" href="<?= base_url($currentModule . "/edit_challan") ?>/' + challan.fees_id + '">View</a> ';
				}

				var pdfIcon = '<a href="<?= base_url($currentModule . "/download_challan_pdf") ?>/' + challan.fees_id + '" title="Download PDF" target="_blank" <?= $disable ?>><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px;color:red;"></i></a>';

				content += '<tr>';
				content += '<td>' + checkbox + '</td>';
				content += '<td>' + j + '</td>';
				content += '<td>' + challan.exam_session + '</td>';
				content += '<td>' + challan.enrollment_no + '</td>';
				content += '<td>' + challan.first_name + ' ' + (challan.last_name ? ' ' + challan.last_name : '') + '</td>';
				content += '<td>' + challan.amount + '</td>';
				content += '<td>' + formattedDate + '</td>';
				content += '<td>' + challan.TransactionNo + '</td>';
				//content += '<td>' + 'Success' + '</td>';
				content += '<td><span style="color:green">' + paymentStatus + '</span></td>';
				content += '<td><span style="color:' + statusColor + '">' + statusText + '</span></td>';
				content += '<td>' + viewButton + pdfIcon + '</td>';
				content += '</tr>';

				j++;
			}

			    $('#itemContainer').html(content);
                document.querySelectorAll('input[name="fees_id[]"]').forEach(checkbox => {
           			checkbox.addEventListener('change', toggleDepositButton);
        		});
        		toggleDepositButton();
		}
	}

	function ajaxcall(type, url, datastring) {
		var res;
		$.ajax({
			type: type,
			url: url,
			data: datastring,
			cache: false,
			async: false,
			success: function(result) {
				res = result;
			}
		});
		return res;
	}
</script>