<?php
//$basepath ="http://www.sandipuniversity.com/sandipUniversity_final/";
//$basepath ="http://www.sandipuniversity.com/";
$basepath = base_url();
//print_r($frmno);exit;
//echo $reval;exit;
?>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sandip University</title>
	<script src="<?= site_url() ?>assets/javascripts/numbertowords.js" type="text/javascript"></script>

	<script>
		function check_maxmarks(id) {
			//alert(id);
			var max_marks = parseInt($("#max_marks").val());
			var marks = parseInt($("#" + id).val());

			if (marks > max_marks) {
				alert("Please enter min marks than Max Marks");
				$("#" + id).val('');
				$("#" + id).focus();

				return false;

			} else {
				return true;
			}


		}
		$(document).ready(function () {
			$('#markentrydate').datepicker({ format: 'dd/mm/yyyy', autoclose: true });
			$('.numbersOnly').keyup(function () {
				if (this.value != this.value.replace(/[^A-B0-9\.]/g, '')) {
					this.value = this.value.replace(/[^A-B0-9\.]/g, '');
				}
			});

		});
	</script>
</head>

<body>

	<div class="container panel-body">
		<div class="row main-wrapper head-add">


			<form name="testdetails" id="testdetails" method="post"
				action="<?= base_url($currentModule) . "/updateStudMarks/" ?>">


				<div class="col-lg-12 np detail-heading" style="text-align:center;padding-top: 15px;">
					<h2>Sandip University</h2>
				</div>
				<table class="table table-bordered" border=1 cellspacing="5px" cellpadding="5px" width="100%">
					<tr>
						<td><b>Exam Session:</b> <?= $me[0]['exam_month'] . ' ' . $me[0]['exam_year'] ?></td>
						<td><b>Stream:</b> <?= $StreamSrtName[0]['stream_short_name'] ?></td>
						<td><b>Semester:</b> <?= $me[0]['semester'] ?></td>
						<td>Date: &nbsp;<input type="text" style="width:130px" class="form-control1"
								name="markentrydate" id="markentrydate" value="<?php if ($me[0]['marks_entry_date'] != '0000-00-00' && $me[0]['marks_entry_date'] != '') {
									echo date('d/m/Y', strtotime($me[0]['marks_entry_date']));
								} ?>" required></td>
					</tr>

					<tr>
						<td><b>Subject Code:</b> <?= strtoupper($ut[0]['subject_code']); ?></td>
						<td colspan=2><b>Subject Name:</b> <?= strtoupper($ut[0]['subject_name']); ?></td>
						<td><b>Max marks:</b> <input type="text" class="form-control1 numbersOnly" style="width:100px"
								name="max_marks" id="max_marks" maxlength="3" value="<?php if ($me[0]['max_marks'] != '') {
									echo $me[0]['max_marks'];
								} ?>" required></td>
					</tr>
				</table>

				<div class="col-lg-12 heading-1">
					<center>
						<h4><b><?php if ($me[0]['marks_type'] == 'TH') {
							echo "Theory";
						} else {
							echo "Practical";
						} ?> - Mark
								Entry</b></h4>
						<span style="color:red;"><small>Note: enter</small> AB <small>for Absent
								Students.</small></span>
					</center>
				</div>

		</div>
		<input type="hidden" name="m_id" value="<?= $me_id ?>">
		<div class="row detail-bg" style="overflow-x:scroll;height:600px; overflow-y:scroll;width:100%;">
			<div class="col-lg-12">

				<input type="hidden" name="sub_details" value="<?= $sub_details ?>">
				<input type="hidden" name="reval" value="<?= $reval ?>">
				<table border="1" class="table table-bordered" align="left">
					<tr>
						<td valign="top" align="left">
							<table border="1" class="table table-bordered" width="200">
								<tr>
									<th style="border-top:1px solid #000;width: 3%;" align="left">S.No</th>
									<th style="border-top:1px solid #000;width: 11%;" align="left">PRN</th>
									<th style="border-top:1px solid #000;width: 11%;" align="left">ABN</th>
									<th style="border-top:1px solid #000;width: 11%;" align="left">Barcode</th>
									
									<?php if ($reval != '') { ?>
										<th style="border-top:1px solid #000;width: 7%;" align="left">Prev. Marks</th>
										<th style="border-top:1px solid #000;width: 7%;" align="left">Reval Marks</th>
									<?php } else { ?>
										<th style="border-top:1px solid #000;width: 7%;" align="left">Marks</th>
									<?php } ?>
									<th style='border-top:1px solid #000;' align='left'>In Words</th>
								</tr>

								<?php
								//echo $reval;
								$count = 0;
								$i = 1;
								//echo "<pre>";print_r($mrks);
								if (!empty($mrks)) {
									foreach ($mrks as $stud) {
										if ($reval != '' && $stud['reval_marks'] != '') {
											$stud_mrks = $stud['reval_marks'];
										} elseif ($reval == '' && $stud['reval_marks'] == '') {
											$stud_mrks = $stud['marks'];
										} else {
											$stud_mrks = '';
										}
										if ($stud['ans_bklet_no'] != '') {
											$ans_bklet_no = $stud['ans_bklet_no'];
										} else {
											$ans_bklet_no = '-';
										}
										//echo $count;
										if ($count == 25) {
											$count = 0;
											$tb = "</table></td><td valign='top'><table class='table table-bordered' border='1'><tr><th style='border-top:1px solid #000;width: 3%;' align='left'>S.No</th>   
            <th style='border-top:1px solid #000;width: 11%;' align='left'>PRN</th>
						<th style='border-top:1px solid #000;width: 11%;' align='left'>ABN</th>";

											if ($reval != '') {
												$tb .= "<th style='border-top:1px solid #000;width: 7%;' align='left'>Prev. Marks</th>
			<th style='border-top:1px solid #000;width: 7%;' align='left'>Reval Marks</th>";
											} else {
												$tb .= "<th style='border-top:1px solid #000;width: 7%;' align='left'>Marks</th>";
											}
											$tb .= "<th style='border-top:1px solid #000;' align='left'>In Words</th></tr>
				";
											echo $tb;
										}

										//echo $count;
										?>
										<tr>
											<td><?= $i ?></td>
											<td><?= $stud['enrollment_no'] ?></td>
											<td><?= $stud['ans_bklet_no'] ?></td>
											<td><?= $stud['barcode'] ?></td>
											<?php if ($reval != '') { ?>
												<td><?= $stud['marks'] ?></td>
												<td><input type="text" name="marks_obtained[]" id="mrk_<?= $stud['stud_id'] ?>"
														style="width: 50px;"
														onkeyup="inwords<?= $stud['stud_id'] ?>.innerHTML=convertNumberToWords(this.value)"
														class="numbersOnly" maxlength="3" value="<?= $stud_mrks ?>"
														onBlur="return check_maxmarks(this.id);" class="form-control" required
														style="width:100px" required></td>
												<td id="inwords<?= $stud['stud_id'] ?>"></td>
											<?php } else { ?>
												<td><input type="text" name="marks_obtained[]" id="mrk_<?= $stud['stud_id'] ?>"
														style="width: 50px;"
														onkeyup="inwords<?= $stud['stud_id'] ?>.innerHTML=convertNumberToWords(this.value)"
														class="numbersOnly" maxlength="3" value="<?= $stud_mrks ?>"
														onBlur="return check_maxmarks(this.id);" class="form-control" required
														style="width:100px" required <?php $is_absent_value = $stud_mrks ; if($is_absent_value !='AA'){echo 'onBlur="return check_maxmarks(this.id);" required';}else{ echo "readonly='true'";}?>></td>
												<td id="inwords<?= $stud['stud_id'] ?>"></td>
											<?php } ?>
											<input type="hidden" name="stud_id[]" value="<?= $stud['stud_id'] ?>">
											<input type="hidden" name="enrollement_no[]" value="<?= $stud['enrollment_no'] ?>">
											<input type="hidden" name="mrk_id[]" value="<?= $stud['m_id'] ?>">

										</tr>
										<?php
										$i++;
										$count++;
									}
								} else {
									//echo "<tr><td colspan=4>No data found.</td></tr>";
								}
								?>


							</table>
						</td>
					</tr>
				</table>

				<?php
				//if($me[0]['approved_by'] ==''){
				?>
				<input type="submit" name="save" value="Update" class="btn btn-primary">
				<?php
				//}	
				if ($me[0]['verified_by'] == '') {
					?>
					<a
						href="<?= base_url($currentModule . "/veryfyStatus/" . base64_encode($sub_details) . '/' . base64_encode($me_id)) ?>"><span
							class="btn btn-primary">Verify</span></a>
					<?php
				}
				if ($me[0]['approved_by'] == '' && $me[0]['verified_by'] != '') {
					?>
					<a
						href="<?= base_url($currentModule . "/approveStatus/" . base64_encode($sub_details) . '/' . base64_encode($me_id)) ?>"><span
							class="btn btn-primary">Approve</span></a>
				<?php } ?>
				</form>
				<!--a href="<?= base_url($currentModule . "/index/" . $subj_Id) ?>">
		<button type="button" class="btn btn-primary ">Back</button>
	</a-->
			</div>
		</div>
	</div>


	<!--Bootstrap core JavaScript-->

	<!--<script src="https://cdn.jsdelivr.net/jsbarcode/3.5.8/barcodes/JsBarcode.code128.min.js"></script>-->

</body>

</html>