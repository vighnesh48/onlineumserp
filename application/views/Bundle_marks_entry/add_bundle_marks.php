<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<script>
	$(document).ready(function () {
		//$('#exam_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
	});

	function getExamDate(id) {
		$('#' + id).datepicker({ format: 'dd/mm/yyyy', autoclose: true });
		$('#' + id).focus();
		return true;
	}
	var base_url = '<?= base_url(); ?>';
	function load_streams(type) {
		// alert(type);

		$.ajax({
			'url': base_url + '/Examination/load_streams',
			'type': 'POST', //the way you want to send data to your URL
			'data': { 'course': type },
			'success': function (data) { //probably this request will return anything, it'll be put in var "data"
				var container = $('#semest'); //jquery selector (get element by id)
				if (data) {
					//   alert(data);
					//alert("Marks should be less than maximum marks");
					//$("#"+type).val('');
					container.html(data);
				}
			}
		});
	}
	$(document).ready(function () {

		$('#school_code').on('change', function () {
			var school_code = $(this).val();
			if (school_code) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Examination/load_schools',
					data: 'school_code=' + school_code,
					success: function (html) {
						//alert(html);
						$('#admission-course').html(html);
					}
				});
			} else {
				$('#admission-course').html('<option value="">Select course first</option>');
			}
		});
		// edit
		var school_code = '<?= $school_code ?>';

		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_schools',
				data: 'school_code=' + school_code,
				success: function (html) {
					//alert(html);
					var course_id = '<?= $admissioncourse ?>';
					$('#admission-course').html(html);
					$("#admission-course option[value='" + course_id + "']").attr("selected", "selected");
				}
			});
		} else {

			$('#admission-course').html('<option value="">Select course first</option>');
		}
		//load streams
		$('#admission-course').on('change', function () {
			var admission_course = $("#admission-course").val();
			var school_code = $("#school_code").val();
			//alert(admission_course);
			if (admission_course) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Examination/load_streams',
					data: { course_id: admission_course, school_code: school_code },
					success: function (html) {
						//alert(html);
						$('#stream_id').html(html);
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		$('#stream_id').on('change', function () {
			var stream_id = $(this).val();
			var exam_session = $("#exam_session").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Examination/load_examsemesters',
					data: { stream_id: stream_id, exam_session: exam_session },
					success: function (html) {
						//alert(html);
						$('#semester').html(html);
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		});
		//edit semester
		var stream_id = '<?= $stream ?>';
		var exam_session = $("#exam_session").val();
		if (stream_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsemesters',
				data: { stream_id: stream_id, exam_session: exam_session },
				success: function (html) {
					//alert(html);
					var semester = '<?= $semester ?>';
					$('#semester').html(html);
					$("#semester option[value='" + semester + "']").attr("selected", "selected");
				}
			});
		} else {
			$('#semester').html('<option value="">Select Stream first</option>');
		}
		// edit
		var admission_course = '<?= $admissioncourse ?>';

		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_streams',
				data: 'course_id=' + admission_course,
				success: function (html) {
					//alert(html);
					var stream_id = '<?= $stream ?>';
					$('#stream_id').html(html);
					$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
				}
			});
		} else {

			$('#stream_id').html('<option value="">Select course first</option>');
		}
	});

</script>
<style>
	/* Loader Wrapper */
	 #loader {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(255, 255, 255, 0.7);
		z-index: 9999;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	/* Spinner Animation */
	.spinner {
		border: 8px solid #f3f3f3;
		/* Light gray */
		border-top: 8px solid #3498db;
		/* Blue */
		border-radius: 50%;
		width: 60px;
		height: 60px;
		animation: spin 1s linear infinite;
	}

	/* Spinner Animation Keyframes */
	@keyframes spin {
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}

	select.form-control2 option {
		font-family: 'FontAwesome';
		/* You can use any icon font like FontAwesome or Material Icons */
	}

	select.form-control2 option[data-icon="✔"] {
		color: green;
	}

	select.form-control2 option[data-icon="✘"] {
		color: red;
	}
</style>

<?php
$role_id = $this->session->userdata("role_id");
if (isset($role_id) && $role_id == 1) {
	?>
	<style>
		.table {
			width: 150%;
		}

		table {
			max-width: 150%;
		}
	</style>
<?php } else { ?>
	<style>
		table.dataTable {
			width: 210%;
		}
	</style>
<?php } ?>

<div id="content-wrapper">
	<ul class="breadcrumb breadcrumb-page">
		<div class="breadcrumb-label text-light-gray">You are here: </div>
		<li class="active"><a href="#">Examination</a></li>
		<li class="active"><a href="#">Marks</a></li>
	</ul>
	<div class="page-header">
		<!-- Display flashdata message -->
		<?php if ($this->session->flashdata('error')): ?>
			<div class="alert alert-danger">
				<?php echo $this->session->flashdata('error'); ?>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('success')): ?>
			<div class="alert alert-success">
				<?php echo $this->session->flashdata('success'); ?>
			</div>
		<?php endif; ?>
		<form method="post" action="<?= base_url() ?>Bundle_marks_entry/">
			<div class="row">
				<h1 class="col-xs-12 col-sm-2 text-center text-left-sm"><i
						class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Marks Entry </h1>
				<div style="padding-top:5px;">Select Subject Type: &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio"
						name="marks_type" id="marks_type2" value="TH" <?php if ($_REQUEST['marks_type'] == 'TH') {
							echo "checked";
						} else {
						} ?> checked required> Theory &nbsp;&nbsp;
					<?php
					if (isset($role_id) && $role_id == 15) {
						?>
						<input type="radio" name="marks_type" id="marks_type3" value="PR" <?php if ($_REQUEST['marks_type'] == 'PR') {
							echo "checked";
						} else {
						} ?> required> Practical
					<?php } ?>
					&nbsp;&nbsp;<input type="checkbox" name="reval" id="reval" value="reval" <?php if ($_REQUEST['reval'] == 'reval') {
						echo "checked";
					} else {
					} ?>> Revaluation
				</div>
			</div>
			<div class="row ">
				<div class="col-sm-12">&nbsp;</div>
			</div>
			<div class="row ">
				<div class="col-sm-12">
					<div class="panel">
						<div class="panel-heading">
							<!-- Loader -->
							<div id="loader" style="display: none;">
								<div class="spinner"></div>
							</div>
							<span class="panel-title">

								<div class="form-group">
									<!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
									<div class="col-sm-2">
										<select name="exam_session" id="exam_session" class="form-control" required>
											<option value="">Exam Session</option>

											<?php

											foreach ($exam_session as $exsession) {
												$exam_sess = $exsession['exam_month'] . '-' . $exsession['exam_year'];
												$exam_sess_val = $exsession['exam_month'] . '-' . $exsession['exam_year'] . '-' . $exsession['exam_id'];
												if ($exam_sess_val == $_POST['exam_session']) {
													$sel = "selected";
												} else {
													$sel = '';
												}
												echo '<option value="' . $exam_sess_val . '"' . $sel . '>' . $exam_sess . '</option>';
											}
											?>
											<!--option value="DEC-2022-29" selected="">DEC-2022</option-->
										</select>
									</div>
									<div class="col-sm-2">
										<select name="school_code" id="school_code" class="form-control" required>
											<option value="">Select School</option>
											<option value="0">All School</option>
											<?php
											foreach ($schools as $sch) {
												if ($sch['school_code'] == $school_code) {
													$sel = "selected";
												} else {
													$sel = '';
												}
												echo '<option value="' . $sch['school_code'] . '"' . $sel . '>' . $sch['school_short_name'] . '</option>';
											}
											?>
										</select>
									</div>
									<div class="col-sm-2">
										<select name="admission-course" id="admission-course" class="form-control"
											required>
											<option value="">Select Course</option>
											<option value="0">All Courses</option>
										</select>
									</div>

									<!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
									<div class="col-sm-2" id="semest">
										<select name="admission-branch" id="stream_id" class="form-control" required>
											<option value="">Select Stream</option>
										</select>
									</div>
									<div class="col-sm-2" id="">
										<select name="semester" id="semester" class="form-control" required>
											<option value="">Select Semester</option>
											<!--option value="1" <?php if ($_REQUEST['semester'] == 1) {
												echo "selected";
											} else {
											} ?>>1 </option>
											<option value="2" <?php if ($_REQUEST['semester'] == 2) {
												echo "selected";
											} else {
											} ?>>2 </option>
											<option value="3" <?php if ($_REQUEST['semester'] == 3) {
												echo "selected";
											} else {
											} ?>>3 </option>
											<option value="4" <?php if ($_REQUEST['semester'] == 4) {
												echo "selected";
											} else {
											} ?>>4 </option-->
										</select>
									</div>
									<!--div class="col-sm-2" id="">
											<select name="marks_type" id="marks_type" class="form-control" required>
											<option value="">Marks Type</option>
											<option value="CIA" <?php if ($_REQUEST['marks_type'] == 'CIA') {
												echo "selected";
											} else {
											} ?>>CIA </option>
											<option value="TH" <?php if ($_REQUEST['marks_type'] == 'TH') {
												echo "selected";
											} else {
											} ?>>TH </option>
											<option value="PR" <?php if ($_REQUEST['marks_type'] == 'PR') {
												echo "selected";
											} else {
											} ?>>PR </option>
											<option value="OR" <?php if ($_REQUEST['marks_type'] == 'OR') {
												echo "selected";
											} else {
											} ?>>OR </option>
											<option value="PJ" <?php if ($_REQUEST['marks_type'] == 'PJ') {
												echo "selected";
											} else {
											} ?>>PJ </option>

											</select>
										</div-->
									<div class="col-sm-2" id="semest">
										<input type="submit" id="" class="btn btn-primary btn-labeled" value="Search">
									</div>
									<!--<div class="col-sm-3" id="semest">
							   <a href="<?= base_url() ?>Ums_admission/generateallpdfs">  <input type="button" id="" class="btn btn-primary btn-labeled" value="Generate All" > </a>
							</div>-->
								</div>
		</form>
		</span>
		<div class="holder1"></div>
	</div>

	<div class="table-info panel-body">
		<?php
		$role_id = $this->session->userdata('role_id');
		//if(isset($role_id) && $role_id==1 ){ ?>
		<!-- <form id="" method="post" action="<?= base_url() ?>Exam_timetable/insert_exam_timetable"> -->

		<input type="hidden" name="stream_id" value="<?= $stream ?>">
		<input type="hidden" name="adm_semester" value="<?= $semester ?>">
		<?php // } ?>

		<div class="col-lg-12">
			<div class="table-info" id="stddata" style="<?= $tbstyle ?>">
				<?php
				if ($_POST) {

					?>

					<table class="table table-bordered" id="table2excel">
						<thead>
							<tr>
								<!--th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th-->
								<th>S.No.</th>
								<th>Subject Code</th>
								<th>Subject Name</th>
								<th>Semester</th>
								<th>Bundle No</th>
								<th>Action</th>
								<th>Upload Excel</th>
								<th>Entry On</th>
								<th>Verify On</th>
								<th>Approved On</th>
								<th>Bundle Status</th>
								<th>Download</th>
								<th>Consolidated PDF</th>
								<th>Subject Status</th>
								
							</tr>
						</thead>
						<tbody id="studtbl">
							<?php
							// echo "<pre>";
							// print_r($sub_list);
							if (!empty($sub_list)) {
								$j = 1;
								for ($i = 0; $i < count($sub_list); $i++) {
									//echo $sub_list[$i]['isPresent']; 
									?>
									<input type="hidden" name="subject_id[]" id="subject_id<?= $j ?>" class='studCheckBox'
										value="<?= $sub_list[$i]['sub_id'] ?>">
									<input type="hidden" name="subject_code[]" id="subject_code<?= $j ?>" class='studCheckBox'
										value="<?= $sub_list[$i]['subject_code'] ?>">
									<?php if ($sub_list[$i]['ro_flag'] == 'on')
										$bg = "bgcolor='#e6eaf2'";
									else
										$bg = ""; ?>
									<tr <?= $bg ?> 			<?= $sub_list[$i]["cancelled_admission"] == "Y" ? "style='background-color:#f5b9a1'" : "" ?>>
										<!--th><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?= $sub_list[$i]['stud_id'] ?>"></th-->
										<td><?= $j ?></td>

										<td><?= strtoupper($sub_list[$i]['subject_code']) ?></td>
										<td>

											<?php
											echo strtoupper($sub_list[$i]['subject_name']);
											?>
										</td>
										<td>

											<?= $sub_list[$i]['semester'] ?>
										</td>
										<td>
											<select name="bundle_no[<?= $i ?>]" id="bundle_no_<?= $i ?>" class="form-control2"
												onchange="updateSubDetails(<?= $i ?>)">
												<option value="">Select Bundle Number</option>
												<?php if (!empty($sub_list[$i]['bundle_numbers'])) {
													foreach ($sub_list[$i]['bundle_numbers'] as $bundle) {
														// Query the marks_entry_master table to check if marks have been entered for this bundle_no
														$DB1 = $this->load->database('umsdb', TRUE);
														$marksEntered = $DB1->where('bundle_no', $bundle['bundle_no'])
															->count_all_results('marks_entry_master');
														// Set icon based on marks entry status
														$icon = $marksEntered > 0 ? '✔' : '✘'; // Tick or cross icon
														?>
														<option value="<?= $bundle['bundle_no'] ?>" data-icon="<?= $icon ?>">
															<?= $bundle['bundle_no'] ?>  <?= $icon ?>
														</option>
														<?php
													}
												} ?>
											</select>

										</td>

										<td>
											<?php
											$subDetails = $sub_list[$i]['sub_id'] . '~' . $school_code . '~' . $admissioncourse . '~' . $stream . '~' . $semester . '~' . $exam . '~' . $marks_type . '~' . $reval . '~' . $sub_list[$i]['subject_code'];

											//   if (empty($sub_list[$i]['mrk'][0]['me_id'])) { ?>
											<!-- Add Link -->
											<a href="#" id="link_<?= $i ?>" target="_blank" style="display:none;">Add</a>

											<!-- Edit Link -->
											<a href="#" id="edit_link_<?= $i ?>" target="_blank" style="display:none;">Edit</a>

											<!-- Download Link -->
											<!-- a href="#" id="download_link_<?= $i ?>" target="_blank" style="display:none;">
												<i class="fa fa-download" aria-hidden="true"
													style="font-size:20px;color:green;"></i>
											</a -->

											<?php // } else { ?>
											<!-- Hidden me_id -->
											<input type="hidden" id="me_id_<?= $i ?>"
												value="<?= $sub_list[$i]['mrk'][0]['me_id'] ?>">


											<?php // } ?>
										</td>


										<!-- <td>
											<?php
											$marks_type = 'TH';
											$sub_details = array();
											$sub_details[] = array($sub_list[$i]['sub_id'], $sub_list[$i]['stream_id'], $sub_list[$i]['semester'], $exam, $marks_type, $subbthDetails, $sub_list[$i]['sub_max'], $sub_list[$i]['subject_component']);
											?>
											<form
												action="<?= base_url($currentModule . "/uploadExcelData/" . base64_encode($sub_details)) ?>"
												method="post" enctype="multipart/form-data">
												<input type="hidden" name="sub_details"
													value="<?= htmlspecialchars(json_encode($sub_details)) ?>">
												<input type="file" name="file" accept=".xlsx, .xls">
												<button type="submit">Upload</button>
											</form>
										</td> -->

										<td id="upload_excel_<?= $i ?>"></td> 
										<td id="entry_on_<?= $i ?>"></td>
										<td id="verified_on_<?= $i ?>"></td>
										<td id="approved_on_<?= $i ?>"></td>
										<td id="status_<?= $i ?>"></td>

										<!-- <td>
											<?php
											if ($sub_list[$i]['mrk'][0]['entry_on'] != '') {
												echo date('d/m/Y H:i:s', strtotime($sub_list[$i]['mrk'][0]['entry_on']));
											} else {
												echo "";
											}
											?>
										</td>
										<td>
											<?php
											if ($sub_list[$i]['mrk'][0]['verified_on'] != '') {
												echo date('d/m/Y H:i:s', strtotime($sub_list[$i]['mrk'][0]['verified_on']));
											} else {
												echo "";
											}
											?>
										</td>
										<td>
											<?php
											if ($sub_list[$i]['mrk'][0]['approved_on'] != '') {
												echo date('d/m/Y H:i:s', strtotime($sub_list[$i]['mrk'][0]['approved_on']));
											} else {
												echo "";
											}
											?>
										</td>
										<td>
											<?php
											if ($sub_list[$i]['mrk'][0]['entry_status'] != '') {
												echo $sub_list[$i]['mrk'][0]['entry_status'];
											} else {
												echo "Not Entered";
											}
											?>
										</td> -->
										<td>
											<a href="#" id="pdf_link_<?= $i ?>" style="display:none;"><i class="fa fa-file-pdf-o"
													aria-hidden="true" style="font-size:20px;color:red;"></i></a>
											<a href="#" id="excel_link_<?= $i ?>" style="display:none;"><i class="fa fa-file-excel-o"
													aria-hidden="true" style="font-size:20px;color:green;"></i></a>			
											<?php
											if ($sub_list[$i]['mrk'][0]['me_id'] != '') {
												?>
												<!-- <a
													href="<?= base_url($currentModule . "/downloadpdf/" . base64_encode($subDetails) . '/' . base64_encode($sub_list[$i]['mrk'][0]['me_id'])) ?>"><i
														class="fa fa-file-pdf-o" aria-hidden="true"
														style="font-size:20px;color:red;"></i></a> -->
											<?php } ?>
										</td>
										<td>
											<a href="#" id="con_pdf_link_<?= $i ?>" style="display:none;"><i class="fa fa-file-pdf-o"
												aria-hidden="true" style="font-size:20px;color:red;"></i></a>
										</td>
										<td>
											<?php
												$check_marks_entered = $this->Marks_model->get_marks_entry_status_for_subject($sub_list[$i]['sub_id'],$semester,$stream,$exam);
											//	print_r($check_marks_entered);exit;
													echo ($check_marks_entered['completed_count'] == $check_marks_entered['total_bundles']) ? 'Entered' : 0 .' '.'/'.' '.$check_marks_entered['total_bundles']; 

											?>
											
											
										</td>
									</tr>
									<?php
									$j++;
								}
							} else {
								echo "<tr><td colspan=9> No data found.</td></tr>";
							}
							?>
						</tbody>
					</table>
					<!-- </form> -->
				<?php } ?>
			</div>
		</div>
	</div>
</div>

</div>
</div>
</div>
</div>

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">


<script>
	// document.addEventListener('DOMContentLoaded', function () {

	function updateSubDetails(index) {
		var bundleNo = document.getElementById('bundle_no_' + index).value;
		var subjectId = document.getElementById('subject_id' + (index + 1)).value;
		var subjectCode = document.getElementById('subject_code' + (index + 1)).value;
		var schoolCode = '<?= $school_code ?>';
		var admissionCourse = '<?= $admissioncourse ?>';
		var stream = '<?= $stream ?>';
		var semester = '<?= $semester ?>';
		var exam = '<?= $exam ?>';
		var marksType = '<?= $marks_type ?>';
		var reval = '<?= $reval ?>';


		// Get the selected option for bundle_no
		var selectedOption = document.querySelector('#bundle_no_' + index + ' option:checked');

		// Check if marks have been entered for the selected bundle
		var marksEntered = selectedOption ? selectedOption.getAttribute('data-marks-entered') : 0;

		// Get or create an element to show the tick or cross
		var statusElement = document.getElementById('status_' + index);
		if (!statusElement) {
			statusElement = document.createElement('span');
			statusElement.id = 'status_' + index;
			document.getElementById('bundle_no_' + index).parentElement.appendChild(statusElement);
		}

		// Get me_id or set as empty string if not found
		// var me_id = document.getElementById('me_id_' + index)?.value || '';
		subjectCode = subjectCode.replace(/\s+/g, ''); // remove all spaces

		var subDetails = subjectId + '~' + schoolCode + '~' + admissionCourse + '~' + stream + '~' + semester + '~' + exam + '~' + marksType + '~' + reval + '~' + subjectCode + '~' + bundleNo;

		subDetails = encodeURIComponent(subDetails);

		// Get references to the links
		var editLink = document.getElementById('edit_link_' + index);
		var addLink = document.getElementById('link_' + index);
		var downloadLink = document.getElementById('download_link_' + index);
		var pdfLink = document.getElementById('pdf_link_' + index);
		var excelLink = document.getElementById('excel_link_' + index);
		var conPdfLink = document.getElementById('con_pdf_link_' + index);
		var uploadCell = document.getElementById('upload_excel_' + index);
		// Send AJAX request to check if me_id and bundleNo exist in marks_entry_master
		if(bundleNo == '' || bundleNo == '0'){
			alert('Please select a bundle number');
		}else{
			$.ajax({
				url: '<?= base_url($currentModule . "/checkMarksEntryMaster") ?>',  // Update with correct controller function
				type: 'POST',
				data: {
					bundle_no: bundleNo
				},
				dataType: 'json', // Ensures response is automatically parsed as JSON
				success: function (response) {
					console.log('Response:', response);

					if (response.exists) {
						// alert('Record exists with me_id: ' + response.me_id);

						$('#entry_on_' + index).text(response.entry_on);
						$('#verified_on_' + index).text(response.verified_on);
						$('#approved_on_' + index).text(response.approved_on);
						$('#status_' + index).text(response.status);
						// Show Edit and Download links
						if (editLink) {
							editLink.href = '<?= base_url($currentModule . "/editMarksDetails/") ?>' + '/' + subDetails + '/' + response.me_id;
							editLink.style.display = 'inline';  // Show Edit link
						}
						if (pdfLink) {
							pdfLink.href = '<?= base_url($currentModule . "/download_bundle_wise_pdf/") ?>' + '/' + subDetails + '/' + response.me_id;
							pdfLink.style.display = 'inline';  // Show PDF link
						}
						if (excelLink) {
							excelLink.href = '<?= base_url($currentModule . "/download_marks_entry_excel/") ?>' + '/' + subDetails + '/' + response.me_id;
							excelLink.style.display = 'inline';  // Show Excel link
						}
						if (conPdfLink) {
							conPdfLink.href = '<?= base_url($currentModule . "/download_consolidated_pdf/") ?>' + '/' + subDetails + '/' + response.me_id;
							conPdfLink.style.display = 'inline';  // Show Excel link
						}
						if (addLink) {
							addLink.style.display = 'none';  // Hide Add link
						}
						if (downloadLink) {
							downloadLink.style.display = 'none';  // Hide download link
						}
						if (uploadCell) {
							uploadCell.innerHTML = '';  // Clear the cell content
						}
					} else {
						// alert('Record not found');
						$('#entry_on_' + index).text('');
						$('#verified_on_' + index).text('');
						$('#approved_on_' + index).text('');
						$('#status_' + index).text('Not Entered');

						// Also update the Upload Excel cell
						uploadCell.innerHTML = `
						<form action="<?= base_url($currentModule . "/uploadExcelData/" . base64_encode($sub_details)) ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="sub_details" value="<?= htmlspecialchars(json_encode($sub_details)) ?>">
							<input type="file" name="excel_file" accept=".xls,.xlsx">
							<button type="submit">Upload</button>
						</form>
						`;
						// Show Add link
						if (addLink) {
							addLink.href = '<?= base_url($currentModule . "/marksdetails/") ?>' + '/' + subDetails;
							addLink.style.display = 'inline';  // Show Add link
						}
						if (editLink) {
							editLink.style.display = 'none';  // Hide Edit link
						}
						if (downloadLink) {
							downloadLink.href = '<?= base_url($currentModule . "/downloadExcel/") ?>' + '/' + subDetails;
							downloadLink.style.display = 'inline';  // Show Download link
						}
						if (pdfLink) {
							pdfLink.style.display = 'none';  // Hide PDF link
						}
					}
				},
				error: function () {
					console.error('Error checking marks entry master');
				}
			});
		}
	}


	function validate_student(strm) {

		var chk_stud_checked_length = $('input[class=studCheckBox]:checked').length;
		if (chk_stud_checked_length == 0) {
			alert('please check atleast one Student from student list');
			return false;
		} else {
			return true;
		}
	}

	$(document).ready(function () {
		$('#chk_stud_all').change(function () {
			$('.studCheckBox').prop('checked', $(this).prop('checked'));
		});
	});

	$(document).ready(function () {
		$("#expdata").click(function () {

			$("#table2excel").table2excel({

				exclude: ".noExl",

				name: "Worksheet Name",
				filename: "Student List" //do not include extension

			});

		});
		// $('#example').DataTable( {
		//    dom: 'Bfrtip',
		//    buttons: [
		//       'csv', 'excel'
		// ]
		//} );
	});


	$(document).ready(function () {
		// Show loader before AJAX starts
		$(document).ajaxStart(function () {
			$("#loader").show();
		});

		// Hide loader after AJAX completes
		$(document).ajaxStop(function () {
			$("#loader").hide();
		});

	});


	$(document).ready(function () {
		$('.form-control2').select2({
			templateResult: formatBundleOption,
			templateSelection: formatBundleOption
		});
	});

	function formatBundleOption(option) {
		if (!option.id) {
			return option.text;
		}
		// Get the data-icon attribute and append it with the option text
		var icon = $(option.element).data('icon');
		return $('<span>' + icon + ' ' + option.text + '</span>');
	}
</script>