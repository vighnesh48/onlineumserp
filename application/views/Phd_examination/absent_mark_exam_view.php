<div id="content-wrapper">
	<ul class="breadcrumb breadcrumb-page">
		<div class="breadcrumb-label text-light-gray">You are here: </div>        
		<li class="active"><a href="#">Examination</a></li>
		<li class="active"><a href="#">Absent Mark</a></li>
	</ul>
	<div class="page-header">	
		<div class="panel">
			<div class="panel-heading">
				<span class="panel-title">Absent Entries:</span>
			</div>						

			<div class="row panel-body">
				<div class="col-sm-12">
                
                        
					<form method="post" action="<?=base_url()?>Examination/absent_entries">
							
					<div class="form-group">
						
						<div class="col-sm-2">
							<select name="exam_session" id="exam_session" class="form-control" required>
								<option value="">Select Exam Session</option>
                               
								<?php
								foreach($exam_session as $exsession){
									$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
									$exam_sess_val = $exsession['exam_month'] .'-'.$exsession['exam_year'].'-'.$exsession['exam_id'];
									if($_REQUEST['exam_session'] == $exam_sess_val){
										$sel = "selected";
									} else{
										$sel = '';
									}
									echo '<option value="' . $exam_sess_val. '"' . $sel . '>' .$exam_sess.'</option>';
								}
								?></select>
						</div>
					
						
						<div class="col-sm-2">
							<select name="exam_date" id="exam_date" class="form-control" required >
								<option value="">Exam Dates</option>
								<?php
								/*foreach($ex_dates as $exd){
									if($exd['exam_date'] == $exam_date){
										$sel = "selected";
									} else{
										$sel = '';
									}
									echo '<option value="' . $exd['exam_date'] . '"' . $sel . '>' . date('d-m-Y',strtotime($exd['exam_date'])) . '</option>';
								}*/
								?></select>
						</div>
					
						
						<div class="col-sm-3" id="">
							<select name="stream" id="stream" class="form-control" required>
								<option value="">Select Stream</option>
								<?php
								foreach($streams as $strm){
									
									echo '<option value="' . $strm['stream_id'] . '">'.$strm['stream_short_name'].'</option>';
								}
								?>
								 
							</select>
						</div>
						<div class="col-sm-2" id="">
							<select name="subject" id="subject" class="form-control" required>
								<option value="">Select Subject</option>
								<?php
								foreach($ex_dates as $exd){
									if($exd['exam_date'] == $exdool_code){
										$sel = "selected";
									} else{
										$sel = '';
									}
									echo '<option value="' . $exd['exam_date'] . '"' . $sel . '>' . date('d-m-Y',strtotime($exd['exam_date'])) . '</option>';
								}
								?>
								
								 
							</select>
						</div>
								
						
						<div class="col-sm-2" id="">
							<input type="submit" id="" class="btn btn-primary btn-labeled" value="Search" > 
						</div>
					</div>

				</div>
				</form>
                                
				<div class="row">
				</div>
				<div class="table-info">    
					<?php //if(in_array("View", $my_privileges)) { ?>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th class="noExl"><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th>
								<th>#</th>
								<th>PRN</th>
								<th>Student Name</th>
								<th>Stream Name</th>
								<th>Semester</th> 
								<th>Status</th>
							</tr>
						</thead>
						<tbody id="itemContainer">
							<?php
							$j=1;  
							if(!empty($stud_details)){
								foreach($stud_details as $stud){
                                
									?>
									<tr <?=$stud["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
										<td><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox chk_stud<?=$stud['stud_id']?>' value="<?=$stud['exam_subject_id']?>"></td>
										<td><?=$j?></td> 
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['first_name']?> <?=$stud['middle_name']?> <?=$stud['last_name']?></td>								
										<td><?=$stud['stream_short_name']?></td>
										<td><?=$stud['semester']?></td>
										<td><?php 
											if($stud['is_absent']=='N'){
												echo "<button class='btn btn-success'>Present</button>";
									
											}else{
												echo "<button class='btn btn-danger'>Absent</button>";
											}
											?></td>
                              
                                
									</tr>
									<?php
									$j++;
								}
							}else{
								echo "<tr><td colspan=11>No data found.</td></tr>";
							}
							?>                            
						</tbody>
					</table>   
					<div class="col-sm-2"> <button class="btn btn-danger" id="btn_absent" >Mark Absent</button> </div>
					<div class="col-sm-2"> <button class="btn btn-success" id="btn_present" >Mark Present</button> </div>
				</div>
                  
			</div>  
			  
		</div></div></div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#exam_session').on('change', function () {	
		var exam_session = $(this).val();
		//alert(exam_session);
		if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/fetch_examdates_by_session',
				data: 'exam_session=' + exam_session,
				success: function (html) {
					//alert(html);
					$('#exam_date').html(html);
				}
			});
		} else {
			$('#exam_date').html('<option value="">Select exam session first</option>');
		}
	}); 
//
	var exam_session = '<?=$ex_session?>';
		//alert(exam_session);
		if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/fetch_examdates_by_session',
				data: 'exam_session=' + exam_session,
				success: function (html) {
					var exam_date = '<?=$exam_date?>';
					$('#exam_date').html(html);
					$("#exam_date option[value='" + exam_date + "']").attr("selected", "selected");
				}
			});
		} else {
			$('#school_code').html('<option value="">Select exam session first</option>');
		}
			$('#exam_date').on('change', function () {	
					var exam_date = $(this).val();
					if (exam_date) {
						$.ajax({
								type: 'POST',
								url: '<?= base_url() ?>Examination/load_stream',
								data: 'exam_date=' + exam_date,
								success: function (html) {
									//alert(html);
									$('#stream').html(html);
								}
							});
					} else {
						$('#subject').html('<option value="">Select Stream first</option>');
					}
				}); 
			//edit
				
			var exam_date = '<?=$exam_date?>';
			if (exam_date) {
				$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Examination/load_stream',
						data: 'exam_date=' + exam_date,
						success: function (html) {
							var stream_id = '<?=$stream?>';
							$('#stream').html(html);
							$("#stream option[value='" + stream_id + "']").attr("selected", "selected");
						}
					});
			} else {
				$('#subject').html('<option value="">Select Stream first</option>');
			}
				
			///////////////////
			$('#stream').on('change', function () {	
					var stream = $(this).val();
					var exam_date = $("#exam_date").val();
					if (stream) {
						$.ajax({
								type: 'POST',
								url: '<?= base_url() ?>Examination/load_subject',
								data: {stream:stream,exam_date:exam_date},
								success: function (html) {
									//alert(html);
									$('#subject').html(html);
								}
							});
					} else {
						$('#subject').html('<option value="">Select Stream first</option>');
					}
				});         
			// edit subject
			var stream_id1 = '<?=$stream?>';
			var exam_date = '<?=$exam_date?>';
			//alert(stream_id1);alert(exam_date);
			if (stream_id1) {
				$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Examination/load_subject',
						data: {stream:stream_id1,exam_date:exam_date},
						success: function (html) {
							var subject_id = '<?=$subject?>';
							//alert(html);
							$('#subject').html(html);
							$("#subject option[value='"+subject_id+"']").attr("selected", "selected");
						}
					});
			} else {
				$('#subject').html('<option value="">Select Stream first</option>');
			}
		});
	function validate_student(strm){

		var chk_stud_checked_length = $('input[class=studCheckBox]:checked').length;
		if(chk_stud_checked_length == 0){
			alert('please check atleast one Student from student list');
			return false;
		}else{
			return true;
		}
	}
	$(document).ready(function () {
			$('#chk_stud_all').change(function () {
					$('.studCheckBox').prop('checked', $(this).prop('checked'));
				});
	
			//Allocate batch
			$('#btn_absent').on('click', function () {
					//alert("hi");
					var chk_stud = $("#chk_stud").val();

					var stream = $("#stream").val();
					var subject = $("#subject").val();
					var exam_session = $("#exam_session").val();
					//alert(exam_session);
					var chk_checked = [];
					$.each($("input[name='chk_stud[]']:checked"), function(){            
							chk_checked.push($(this).val());
						});
					var arr_length = chk_checked.length;
					if(arr_length ==0){
						alert('please check atleast one Student from student list');
						return false;
					}
					if (arr_length !=0) {
						$.ajax({
								type: 'POST',
								url: '<?= base_url() ?>Examination/mark_absent_students',
								data: {chk_stud:chk_checked,stream:stream,subject:subject,exam_session:exam_session},
								success: function (data) {
									alert("Selected students mark absent successfully..");
									location.reload();						
								}
							});
					} else {
						$('#studtbl').html('<option value="">No data found</option>');
					}
				});
			//
			///////////////////
			$('#btn_present').on('click', function () {
					//alert("hi");
					//var chk_stud = $("#chk_stud").val();

					var stream = $("#stream").val();
					var subject = $("#subject").val();
					var exam_session = $("#exam_session").val();
					//alert(exam_session);
					var chk_checked = [];
					$.each($("input[name='chk_stud[]']:checked"), function(){            
							chk_checked.push($(this).val());
						});
					var arr_length = chk_checked.length;
					if(arr_length ==0){
						return false;
					}
					if (arr_length !=0) {
						$.ajax({
								type: 'POST',
								url: '<?= base_url() ?>Examination/mark_present_students',
								data: {chk_stud:chk_checked,stream:stream,subject:subject,exam_session:exam_session},
								success: function (data) {
									alert("Selected students mark present successfully..");
									location.reload();						
								}
							});
					} else {
						$('#studtbl').html('<option value="">No data found</option>');
					}
				});
			//

		});			
</script>