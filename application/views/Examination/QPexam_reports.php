<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<script>

    var base_url = '<?=base_url();?>';
	function load_streams(type){
                   // alert(type);
                    
		$.ajax({
			'url' : base_url + '/Examination/load_examstreams',
			'type' : 'POST', //the way you want to send data to your URL
			'data' : {'course' : type},
			'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
				var container = $('#semest'); //jquery selector (get element by id)
				if(data){
				 //   alert(data);
					//alert("Marks should be less than maximum marks");
					//$("#"+type).val('');
					container.html(data);
				}
			}
		});
	}
$(document).ready(function(){
	//auto load code

	var exam_session = '<?php echo $examsessionn;?>';
	var school_code = '<?php echo $school_code;?>';
	if(exam_session){

			if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsess_schools',
				data:{exam_session:exam_session,school_code:school_code},
				success: function (html) {
					//alert(html);
					$('#school_code').html(html);
				}
			});
		} else {
			$('#school_code').html('<option value="">Select exam session first</option>');
		}

	}

//admission
	var admission_course = '<?php echo $admission_course;?>';

	if(exam_session!='' &&  school_code!='')
	{
		
		if (school_code) {

			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examschools',
				data: {school_code:school_code,exam_session:exam_session,admission_course:admission_course},
				success: function (html) {
					//alert(html);
					$('#admission-course').html(html);
				}
			});
		} else {
			$('#admission-course').html('<option value="">Select course first</option>');
		}
	}

	//stream\\
		var admission_branch = '<?php echo $admission_branch;?>';

		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examstreams',
				data: {course_id:admission_course,exam_session:exam_session,admission_branch:admission_branch},
				success: function (html) {
					//alert(html);
					$('#stream_id').html(html);
				}
			});
		} else {
			$('#stream_id').html('<option value="">Select course first</option>');
		}

		//subject load 

		var subject_id = '<?php echo $subject_id;?>';
		var semester =  '<?php echo $semester;?>';
		//alert(admission_course);
		if (semester) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsubjects',
				data: {stream_id:admission_branch,exam_session:exam_session,semester:semester,subject_id:subject_id},
				success: function (html) {
					//alert(html);
					$('#subject_id').html(html);
				}
			});
		} else {
			$('#subject_id').html('<option value="">Select stream first</option>');
		}

	
	//end of auto load code



//
	$('#exam_session').on('change', function () {	
		var exam_session = $(this).val();
		if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsess_schools',
				data: 'exam_session=' + exam_session,
				success: function (html) {
					//alert(html);
					$('#school_code').html(html);
				}
			});
		} else {
			$('#school_code').html('<option value="">Select exam session first</option>');
		}
	}); 
	$('#examsession').on('change', function () {	
		var exam_session = $(this).val();
		if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsess_schools1',
				data: 'exam_session=' + exam_session,
				success: function (html) {
					//alert(html);
					$('#schoolcode').html(html);
				}
			});
		} else {
			$('#school_code').html('<option value="">Select exam session first</option>');
		}
	});	
	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		var exam_session = $("#exam_session").val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examschools',
				data: {school_code:school_code,exam_session:exam_session},
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
	var school_code = '<?=$school_code?>';

		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_schools',
				data: 'school_code=' + school_code,
				success: function (html) {
					//alert(html);
					var course_id = '<?=$admission_course?>';
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
		var exam_session = $("#exam_session").val();
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examstreams',
				data: {course_id:admission_course,exam_session:exam_session},
				success: function (html) {
					//alert(html);
					$('#stream_id').html(html);
				}
			});
		} else {
			$('#stream_id').html('<option value="">Select course first</option>');
		}
	}); 
	
	//load semesters
		$('#stream_id').on('change', function () {	
		var stream_id = $("#stream_id").val();
		var exam_session = $("#exam_session").val();
		//alert(admission_course);
		if (stream_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsemesters',
				data: {stream_id:stream_id,exam_session:exam_session},
				success: function (html) {
					//alert(html);
					$('#semester').html(html);
				}
			});
		} else {
			$('#semester').html('<option value="">Select stream first</option>');
		}
	});
		$('#semester').on('change', function () {	
		var stream_id = $("#stream_id").val();
		var semester = $("#semester").val();
		var exam_session = $("#exam_session").val();
		//alert(admission_course);
		if (semester) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsubjects',
				data: {stream_id:stream_id,exam_session:exam_session,semester:semester},
				success: function (html) {
					//alert(html);
					$('#subject_id').html(html);
				}
			});
		} else {
			$('#subject_id').html('<option value="">Select stream first</option>');
		}
	});	
	// edit
var admission_course = '<?=$admissioncourse?>';

		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_streams',
				data: 'course_id=' + admission_course,
				success: function (html) {
					//alert(html);
					var stream_id = '<?=$stream?>';
					$('#stream_id').html(html);
					$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
				}
			});
		} else {
			
			$('#stream_id').html('<option value="">Select course first</option>');
		}	
	$('#chk_att').change(function () {
        $('.CheckattBox').prop('checked', $(this).prop('checked'));
		
    });		
	$('#chk_ans_rec').change(function () {
        $('.CheckAnsBox').prop('checked', $(this).prop('checked'));
		
    });	
});
</script>  
<div id="content-wrapper">
	<ul class="breadcrumb breadcrumb-page">
		<div class="breadcrumb-label text-light-gray">You are here: </div>        
		<li class="active"><a href="#">Examination</a></li>
		<li class="active"><a href="#">Reports</a></li>
	</ul>
	<div class="page-header">	
		<div class="panel">
			<div class="panel-heading">
				<span class="panel-title">Daywise Exam Reports:</span>
			</div>						

			<div class="row panel-body">
				<div class="col-sm-12">
                
                        
					<form method="post" action="<?=base_url()?>Examination/download_daywise_reports_pdf">
							
					<div class="form-group">
						<label class="col-sm-3">Exam Session<sup class="redasterik" style="color:red">*</sup></label>
						<div class="col-sm-3">
							<select name="exam_session" id="exam_session" class="form-control" required>
								<option value="">--Select--</option>
                               
								<?php

								//foreach($exam_session as $exsession){
									$exam_sess = $exam_session[0]['exam_month'] .'-'.$exam_session[0]['exam_year'];
									$exam_sess_val = $exam_session[0]['exam_month'] .'-'.$exam_session[0]['exam_year'].'-'.$exam_session[0]['exam_id'];
									/*if($exam_sess_val == 'JULY-2018-8'){
										$sel = "selected";
									} else{
										$sel = '';
									}*/
									echo '<option value="' . $exam_sess_val. '">' .$exam_sess.'</option>';
								//}
								?>
								
								</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3">School<sup class="redasterik" style="color:red">*</sup></label>
						<div class="col-sm-3">
							<select name="school_code" id="school_code" class="form-control">
							
							</select>
						</div>
					
					<div class="col-sm-2">
                                <select name="admission-course" id="admission-course" class="form-control">
                                 <option value="">Select Course</option>
                                 
                                  </select>
                              </div>

                             

                              <div class="col-sm-2" id="semest">
                                <select name="admission-branch" id="stream_id" class="form-control" >
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
							
                              <div class="col-sm-2" id="" hidden>
                                <select name="semester[]" id="semester" class="form-control">
                                  <option value="">Select Semester</option>
                                  <option value="0">All </option>
                                   <option value="1" <?php if($semester==1){ echo "selected";}else{}?>>1 </option>
                                   <option value="2" <?php if($semester==2){ echo "selected";}else{}?>>2 </option>
                                   <option value="3" <?php if($semester==3){ echo "selected";}else{}?>>3 </option>
                                   <option value="4" <?php if($semester==4){ echo "selected";}else{}?>>4 </option>
								   <option value="5" <?php if($semester==5){ echo "selected";}else{}?>>5 </option>
								   <option value="6" <?php if($semester==6){ echo "selected";}else{}?>>6 </option>
								   <option value="7" <?php if($semester==7){ echo "selected";}else{}?>>7</option>
								   <option value="8" <?php if($semester==8){ echo "selected";}else{}?>>8 </option>
                                  </select>
                             </div>
							 </div>
					<div class="form-group">
						<label class="col-sm-3">Dates<sup class="redasterik" style="color:red">*</sup></label>
						<div class="col-sm-3">
							<select name="exam_date[]" id="multiple-checkboxes" multiple="multiple" class="form-control" required>
								<?php
								foreach($ex_dates as $exd){
									if($exd['exam_date'] == $exdool_code){
										$sel = "selected";
									} else{
										$sel = '';
									}
									echo '<option value="' . $exd['exam_date'] . '"' . $sel . '>' . date('d-m-Y',strtotime($exd['exam_date'])) . '</option>';
								}
								?></select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3">Timing<sup class="redasterik" style="color:red">*</sup></label>
						<div class="col-sm-3">
							<select name="exam_timing"  class="form-control" required>
								<option value="">--Select--</option>
								<option value="morning">Morning</option>
								<option value="Afternoon">Afternoon</option>
								<option value="both">Both</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3">Report Type<sup class="redasterik" style="color:red">*</sup></label>
						<div class="col-sm-3" id="">
							<select name="report_type" id="report_type" class="form-control" required>
								<option value="">Select</option>
								<option value="Daywise" <?php if($_REQUEST['report_type'] =='Daywise'){ echo "selected";}else{}?>>QP Indent </option>
								<option value="Absent" <?php if($_REQUEST['report_type'] =='Absent'){ echo "selected";}else{}?>>Dispatch Performa </option>
								<option value="Answerbooklets" <?php if($_REQUEST['report_type'] =='Answerbooklets'){ echo "selected";}else{}?>>Answer Booklets </option> 
								<option value="marksheets" <?php if($_REQUEST['report_type'] =='marksheets'){ echo "selected";}else{}?>>Marksheets </option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3"></label>
						<div class="col-sm-3" id="">
							<input type="radio" name="download_type" id="download_type" value="PDF" required> PDF &nbsp;&nbsp;
							<input type="radio" name="download_type" id="download_type" value="EXCEL" required> EXCEL
								
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3"></label>
						<div class="col-sm-2" id="">
							<input type="submit" id="" class="btn btn-primary btn-labeled" value="Export" > 
						</div>
					</div>
					<!--<div class="col-sm-3" id="semest">
					<a href="<?=base_url()?>Ums_admission/generateallpdfs">  <input type="button" id="" class="btn btn-primary btn-labeled" value="Generate All" > </a>
					</div>-->
				</div>
				</form>
                       
			</div>    
		</div></div></div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
  
                $("#multiple-checkboxes").multiselect({
               	    maxHeight: 200,
                    //enableCaseInsensitiveFiltering: true,
                    includeSelectAllOption: true
                });
				$("#multiple-checkboxes_school").multiselect({
               	    maxHeight: 200,
                    //enableCaseInsensitiveFiltering: true,
                    includeSelectAllOption: true
                });
				$(".multiple-checkboxes_stream").multiselect({
               	    maxHeight: 200,
                    //enableCaseInsensitiveFiltering: true,
                    includeSelectAllOption: true
                });
        
    });
</script>