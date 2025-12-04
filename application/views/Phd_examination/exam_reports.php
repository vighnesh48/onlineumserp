<script>
    var base_url = '<?=base_url();?>';
	function load_streams(type){
                   // alert(type);
                    
		$.ajax({
			'url' : base_url + '/phd_examination/load_examstreams',
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

//
	$('#exam_session').on('change', function () {	
		var exam_session = $(this).val();
		if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>phd_examination/load_examsess_schools',
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
				url: '<?= base_url() ?>phd_examination/load_examsess_schools1',
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
				url: '<?= base_url() ?>phd_examination/load_examschools',
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
				url: '<?= base_url() ?>phd_examination/load_schools',
				data: 'school_code=' + school_code,
				success: function (html) {
					//alert(html);
					var course_id = '<?=$admissioncourse?>';
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
				url: '<?= base_url() ?>phd_examination/load_examstreams',
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
				url: '<?= base_url() ?>phd_examination/load_examsemesters',
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
	// edit
var admission_course = '<?=$admissioncourse?>';

		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>phd_examination/load_streams',
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
});
</script>
<?php 
if(isset($role_id) && $role_id==1 ){
?>
<style>
	.table{width: 150%;}
	table{max-width: 150%;}
</style>									
<?php }else{ ?>
	<style>
	table.dataTable{width: 210%;}</style>
<?php }?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">phd_examination</a></li>
        <li class="active"><a href="#">Reports</a></li>
    </ul>
	<div class="col-sm-6">
    <div class="page-header">	
		<div class="panel">
                <div class="panel-heading">
                        <span class="panel-title"> Exam Reports:</span>
				</div>						

        <div class="row panel-body">
                            <form method="post" action="<?=base_url()?>phd_examination/generateReports">
							
                            <div class="form-group">
                             <label class="col-sm-3">Exam Session<sup class="redasterik" style="color:red">*</sup></label>
							 <div class="col-sm-6">
                                <select name="exam_session" id="exam_session" class="form-control" required>
                                 <option value="">--Select--</option>
                               
                                  <?php

foreach ($exam_session as $exsession) {
	$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
	$exam_sess_val = $exsession['exam_month'].'-'.$exsession['exam_year'].'-'.$exsession['exam_id'];
    echo '<option value="' . $exam_sess_val. '">' .$exam_sess.'</option>';
}
?></select>
                              </div>
							 </div>
							 <div class="form-group">
                             <label class="col-sm-3">School<sup class="redasterik" style="color:red">*</sup></label>
							<div class="col-sm-6">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select</option>
                                 
                                  <?php
foreach ($schools as $sch) {
    if ($sch['school_code'] == $school_code) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $sch['school_code'] . '"' . $sel . '>' . $sch['school_short_name'] . '</option>';
}
?></select>
                              </div>
							  </div>
							  <div class="form-group">
                             <label class="col-sm-3">Course<sup class="redasterik" style="color:red">*</sup></label>
                              <div class="col-sm-6">
                                <select name="admission-course" id="admission-course" class="form-control" required>
                                 <option value="">Select</option>
                                 
                                  </select>
                              </div>
							  </div>
                             
                            <div class="form-group">
                             <label class="col-sm-3">Stream<sup class="redasterik" style="color:red">*</sup></label>
                              <div class="col-sm-6" id="semest">
                                <select name="admission-branch" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
							  </div>
							  <div class="form-group">
                             <label class="col-sm-3">Semester<sup class="redasterik" style="color:red">*</sup></label>
                              <div class="col-sm-6" id="">
                                <select name="semester" id="semester" class="form-control" required>
                                  <option value="">Select</option>
                                  <option value="0">All </option>
                                   <option value="1" <?php if($_REQUEST['semester'] ==1){ echo "selected";}else{}?>>1 </option>
                                   <option value="2" <?php if($_REQUEST['semester'] ==2){ echo "selected";}else{}?>>2 </option>
                                   <option value="3" <?php if($_REQUEST['semester'] ==3){ echo "selected";}else{}?>>3 </option>
                                   <option value="4" <?php if($_REQUEST['semester'] ==4){ echo "selected";}else{}?>>4 </option>
                                  </select>
                             </div>
							 </div>
							  <div class="form-group">
                             <label class="col-sm-3">Report Type<sup class="redasterik" style="color:red">*</sup></label>
                              <div class="col-sm-6" id="">
                                <select name="report_type" id="report_type" class="form-control" required>
                                  <option value="">Select</option>
                                   <option value="HallTicket" <?php if($_REQUEST['report_type'] =='HallTicket'){ echo "selected";}else{}?>>Hall Ticket </option>
                                   <option value="HallTicket_excel" <?php if($_REQUEST['report_type'] =='HallTicket_excel'){ echo "selected";}else{}?>>Hall Ticket Excel </option>
                                   <option value="AttendanceSheet" <?php if($_REQUEST['report_type'] =='AttendanceSheet'){ echo "selected";}else{}?>>Attendance Sheet </option>
                                   <option value="SeatingArrangement" <?php if($_REQUEST['report_type'] =='SeatingArrangement'){ echo "selected";}else{}?>>Seating Arrangement </option>
								   <option value="SeatingArrangement_excel" <?php if($_REQUEST['report_type'] =='SeatingArrangement_excel'){ echo "selected";}else{}?>>Seating Arrangement Excel</option>
                                   <!--option value="Timetable" <?php if($_REQUEST['report_type'] =='Timetable'){ echo "selected";}else{}?>>Timetable</option-->
                                  </select>
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
                            
                            </form>
				</div>    
        </div>
    </div>
</div>

<div class="col-sm-6" >
      <div class="page-header">	
		<div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">  Exam Summary:</span>
				</div>						

        <div class="row panel-body">
                        
                            <form method="post" action="<?=base_url()?>phd_examination/reportsummary">
							
                            <div class="form-group">
                             <label class="col-sm-3">Exam Session<sup class="redasterik" style="color:red">*</sup></label>
							 <div class="col-sm-6">
                                <select name="exam_session" id="examsession" class="form-control" required>
                                 <option value="">--Select--</option>
                               
                                  <?php

foreach ($exam_session as $exsession) {
	$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
	$exam_sess_val = $exsession['exam_month'].'-'.$exsession['exam_year'].'-'.$exsession['exam_id'];
    echo '<option value="' . $exam_sess_val. '">' .$exam_sess.'</option>';
}
?></select>
                              </div>
							 </div>
							 <div class="form-group">
                             <label class="col-sm-3">School<sup class="redasterik" style="color:red">*</sup></label>
							<div class="col-sm-6">
                                <select name="school_code" id="schoolcode" class="form-control" required>
                                 <option value="">Select</option>
								 <option value="0">ALL</option>
                                 
                                  <?php
foreach ($schools as $sch) {
    if ($sch['school_code'] == $school_code) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $sch['school_code'] . '"' . $sel . '>' . $sch['school_short_name'] . '</option>';
}
?></select>
                              </div>
							  </div>
							  <div class="form-group">
                             <label class="col-sm-3">Report Type<sup class="redasterik" style="color:red">*</sup></label>
                              <div class="col-sm-6" id="">
                                <select name="report_type" id="report_type" class="form-control" required>
                                  <option value="">Select</option>
                                   <option value="fresh" <?php if($_REQUEST['report_type'] =='fresh'){ echo "selected";}else{}?>>Fresh </option>
                                   <option value="backlog" <?php if($_REQUEST['report_type'] =='backlog'){ echo "selected";}else{}?>>Backlog</option>
                                   <option value="Statistics" <?php if($_REQUEST['report_type'] =='Statistics'){ echo "selected";}else{}?>>Statistics </option>
                                                             
                                  </select>
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
                            
                            </form>
							</div>
                       
            </div>    
        </div>
    </div>
</div>
