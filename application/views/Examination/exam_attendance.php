<script>

    var base_url = '<?=base_url();?>';
	function load_streams(type){
                   // alert(type);
                    
		$.ajax({
			'url' : base_url + 'Examination/load_examstreams',
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
        <li class="active"><a href="#">Examination</a></li>
        <li class="active"><a href="#">Attendance</a></li>
    </ul>
    <?php if($responce = $this->session->flashdata('Successfully')): ?>
      <div class="box-header">
        <div class="col-lg-6">
           <div class="alert alert-success"><?php echo $responce;?></div>
        </div>
      </div>
    <?php endif;?>
	<div class="col-sm-12">
    <div class="page-header">	
		<div class="panel">
                <div class="panel-heading">
                        <span class="panel-title"> Exam Attendance:</span>
				</div>						

        <div class="row panel-body">
                            <form method="post" action="<?=base_url()?>Examination/search_attendance_data">
							
                            <div class="form-group">
							 <div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required>
                                 <option value="">--Select Exam Session--</option>
                               
                                  <?php

foreach ($exam_session as $exsession) {


	$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
	$exam_sess_val = $exsession['exam_month'].'-'.$exsession['exam_year'].'-'.$exsession['exam_id'];

	if ($exam_sess_val == $examsessionn) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $exam_sess_val. '"'.$sel.'>' .$exam_sess.'</option>';
}
?>
</select>
                              </div>

                             
							<div class="col-sm-2">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select School</option>
                                 
                                  <?php
foreach ($schools as $sch) {
    if ($sch['school_code'] ==$school_code) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $sch['school_code'] . '"' . $sel . '>' . $sch['school_short_name'] . '</option>';
}
?></select>
                              </div>

                              <div class="col-sm-2">
                                <select name="admission-course" id="admission-course" class="form-control" required>
                                 <option value="">Select Course</option>
                                 
                                  </select>
                              </div>

                             

                              <div class="col-sm-2" id="semest">
                                <select name="admission-branch" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
							
                              <div class="col-sm-2" id="">
                                <select name="semester" id="semester" class="form-control" required>
                                  <option value="">Select Semester</option>
                                  <option value="0">All </option>
                                   <option value="1" <?php if($semester==1){ echo "selected";}else{}?>>1 </option>
                                   <option value="2" <?php if($semester==2){ echo "selected";}else{}?>>2 </option>
                                   <option value="3" <?php if($semester==3){ echo "selected";}else{}?>>3 </option>
                                   <option value="4" <?php if($semester==4){ echo "selected";}else{}?>>4 </option>
                                   <option value="5" <?php if($semester==5){ echo "selected";}else{}?>>5 </option>
                                   <option value="6" <?php if($semester==6){ echo "selected";}else{}?>>6 </option>
                                   <option value="7" <?php if($semester==7){ echo "selected";}else{}?>>7 </option>
                                   <option value="8" <?php if($semester==8){ echo "selected";}else{}?>>8 </option>
                                   <option value="9" <?php if($semester==9){ echo "selected";}else{}?>>9 </option>
                                   <option value="10" <?php if($semester==10){ echo "selected";}else{}?>>10 </option>
                                
                                  </select>
                             </div>
							 <div class="col-sm-2">
                                <select name="subject_id" id="subject_id" class="form-control" required>
                                  <option value="">Select subject</option>
                                  </select>
                              </div>
                              <div class="col-sm-2 pull-right" style="margin-top:5px; margin-right: 2px;" id="">
                                 <input type="submit" id="" class="btn btn-primary btn-labeled pull-right" value="Search" > 
                            </div>
							
                             <!--<div class="col-sm-3" id="semest">
                               <a href="<?=base_url()?>Ums_admission/generateallpdfs">  <input type="button" id="" class="btn btn-primary btn-labeled" value="Generate All" > </a>
                            </div>-->
                            
                            </form>
				</div>    
        </div>
    </div>
</div>
<div class="panel">
                <div class="panel-heading">
                        <span class="panel-title"></span>
				<div class="row">
				<?php 
				$frmtime = explode(':', $stud_details[0]['from_time']);
				$totime = explode(':', $stud_details[0]['to_time']);
				$ex_time = $frmtime[0].':'.$frmtime[1].'-'.$totime[0].':'.$totime[1];
				?>
				<table class="table table-bordered" border="1" cellspacing="5px" cellpadding="5px" width="100%">
					<tbody>
						<tr>
							<td><b>Exam Session:</b> <?=$stud_details[0]['exam_month'].'-'.$stud_details[0]['exam_year']?></td><td><b>Stream:</b> <?=$stud_details[0]['stream_name']?></td><td><b>Semester:</b> <?=$stud_details[0]['semester']?> </td><td><b>Date:</b> &nbsp;<?=date('d-m-Y',strtotime($stud_details[0]['exam_date']))?> </td>
						</tr>
						
						<tr>
							<td><b>Subject Code:</b> <?=$stud_details[0]['subject_code']?></td><td colspan="2"><b>Subject Name:</b> <?=$stud_details[0]['subject_name']?></td><td><b>Time:</b><?=$ex_time?></td>
						</tr>
						
					</tbody>
				</table>
				</div>
				<table class="table table-bordered" border="1" cellspacing="5px" cellpadding="5px" width="100%">
					<tbody>
						<tr><td><b>Notations:</b></td>
							<td><i class='fa fa-check-square-o' aria-hidden='true'></i> Present</td>
							<td><i class='fa fa-square-o' aria-hidden='true'></i> Uncheck for Absent</td>
							<td><i class='fa fa-check-square-o' aria-hidden='true'></i> Received</td>
							<td><i class='fa fa-square-o' aria-hidden='true'></i> Uncheck for Not Received</td>
						</tr>
					</tbody>
				</table>
				<form id="form1" name="form1" action="<?=base_url($currentModule.'/mark_attandance_ansbklt_students')?>" method="POST"  >
				<div class="table-info">    
					<?php //if(in_array("View", $my_privileges)) { ?>
					<!-- <input type="hidden" name="subject_id" id="subject_id" value="<?=$stud_details[0]['subject_id']?>">
					<input type="hidden" name="stream_id" id="stream_id" value="<?=$stud_details[0]['stream_id']?>">
					<input type="hidden" name="semester" id="semester" value="<?=$stud_details[0]['semester']?>"> -->
					<input type="hidden" name="subject_id" id="subject_id" value="<?=$subject_id?>">
					<input type="hidden" name="stream_id" id="stream_id" value="<?=$admission_branch?>">
					<input type="hidden" name="semester" id="semester" value="<?=$semester?>">
					<input type="hidden" name="admission_branch" id="admission_branch" value="<?=$admission_branch;?>">
					<input type="hidden" name="admission_course" id="admission_course" value="<?=$admission_course;?>">
					<input type="hidden" name="school_code" id="school_code" value="<?=$school_code;?>">
					<input type="hidden" name="examsessionn" id="examsessionn" value="<?=$examsessionn?>">

					<input type="hidden" name="exam_id" id="exam_id" value="<?=$stud_details[0]['exam_id']?>">
					<input type="hidden" name="exam_from_time" id="exam_from_time" value="<?=$stud_details[0]['from_time']?>">
					<input type="hidden" name="exam_to_time" id="exam_to_time" value="<?=$stud_details[0]['to_time']?>">
					<input type="hidden" name="exam_date" id="exam_date" value="<?=$stud_details[0]['exam_date']?>">

					<table class="table table-bordered">
						<thead>
							<tr>
								
								<th>#</th>
								<th>PRN</th>
								<th>Student Name</th>
								<th>Semester</th>
								<th><input type="checkbox" name="chk_stud_all" id="chk_att"> Att </th>
								<th>Ans Booklet No</th> 
								<th><input type="checkbox" name="chk_stud_all" id="chk_ans_rec"> Received</th> 
								<th>Remark</th>
							</tr>
						</thead>
						<tbody id="itemContainer">
							<?php
								$j=1;  
								/*print_r($stud_details);
								die;*/
							if(!empty($stud_details)){
								 $checked='';
								foreach($stud_details as $stud){

									$exam_attendance_status=$stud['exam_attendance_status'];
									if($exam_attendance_status=='P')
									{
										 $checked = 'checked';
										
									}
									else
									{
										 $checked = '';
										
									}
									$ans_bklt_received_status=$stud['ans_bklt_received_status'];
									if($ans_bklt_received_status=='Y')
									{
										 $checked1 = 'checked';
										
									}
									else
									{
										 $checked1 = '';
										
									}	
									if(!empty($stud['ans_bklet_no'])){
										$disabled="";//disabled
									}else{
										$disabled="";
									}
									?>
									<input type="hidden" name="chk_stud[]" id="chk_stud" value="<?=$stud['stud_id']?>" <?=$disabled?>>
									<input type="hidden" name="chk_prn[]" id="chk_prn" value="<?=$stud['enrollment_no']?>" <?=$disabled?>>
									<tr <?=$stud["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
										
										<td><?=$j?></td> 
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['first_name']?> <?=$stud['middle_name']?> <?=$stud['last_name']?></td>	
										<td><?=$stud['semester']?></td>
										<td><input type="checkbox" name="chk_att_status[]" id="chk_attBox" class='CheckattBox' value="<?=$stud['stud_id']?>"   <?php  echo $checked;?> <?=$disabled?>></td>							
										<td><input type="text" name="ans_booklet_no[]" id="ans_booklet_no" value="<?=$stud['ans_bklet_no']?>" <?=$disabled?>></td>
										<td><input type="checkbox" name="ans_booklet_received[]" id="ans_booklet_received" <?php  echo $checked1;?> class='CheckAnsBox' value="<?=$stud['stud_id']?>" <?=$disabled?>></td>
										<td><input type="text" name="remark[]" id="remark" value="<?=$stud['remark']?>" <?=$disabled?>></td>
									</tr>
									<?php
									$j++;
								}
								echo "<tr><td><b>Total Students</b></td><td colspan=10><b>".count($stud_details)."</b></td></tr>";
							}else{
								echo "<tr><td colspan=11>No data found.</td></tr>";
								
							}
						
							?>  
							
							<?php if($stud_details[0]['student_id']!='') { ?> 
								<tr style="border:0"><td colspan=11><button class="btn btn-success"  >Update</button> </td></tr>
								<tr style="border:0">
									<td colspan=11>
										<button class="btn btn-primary" onclick="generateBundleNumbers()">Generate Bundle Numbers</button>
									</td>
								</tr>
							<?php } else {?>
								<tr style="border:0"><td colspan=11><button class="btn btn-success" >Submit</button> </td></tr>
								
							<?php }?>	
					
						</tbody>
					</table>  
							
<?php $roles_id=$this->session->userdata('role_id');

if($roles_id==15 || $roles_id==26  || $roles_id==6){?>							
										<input type="hidden" name="examsessionn" value="<?= $examsessionn ?>">
                                        <input type="hidden" name="school_code" value="<?= $school_code ?>">
                                        <input type="hidden" name="admission_course" value="<?= $admission_course ?>">
                                        <input type="hidden" name="admission_branch" value="<?= $admission_branch ?>">
                                        <input type="hidden" name="semester" value="<?= $semester ?>">
                                        <input type="hidden" name="subject_id" value="<?= $subject_id ?>">
                                        <a href="<?= base_url() ?>Examination/export_to_excel/<?= $examsessionn ?>/<?= $admission_branch ?>/<?= $subject_id ?>" class="btn btn-primary">Export to Excel</a>
<?php }?>
				</form>
				</div>
  </div>
            </div>
			<?php if($roles_id==15 || $roles_id==26 || $roles_id==6){?>
			<button class="btn btn-success" onclick="generateBarcodes()">Generate Barcode</button>
					<?php }?>
<script>
    function generateBarcodes() {
        var exam_id = $('#exam_id').val();
        var school_code = $('#school_code').val();
        var admission_course = $('#admission-course').val();
        var admission_branch = $('#stream_id').val();
        var semester = $('#semester').val();
        var subject_id = $('#subject_id').val();

        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>Examination/generate_barcodes_images',
            data: {
                exam_id: exam_id,
                school_code: school_code,
                admission_course: admission_course,
                admission_branch: admission_branch,
                semester: semester,
                subject_id: subject_id
            },
            success: function (response) {
                // Open the response in a new browser page
                var newWindow = window.open();
                newWindow.document.write(response);
                newWindow.document.close();
            }
        });
    }
</script>
<script>
	$(document).ready(function () {
		// Function to check if any student is present or checked
		function toggleGenerateBundleButton() {
			let showButton = false;

			// Check if any checkbox is checked or `exam_attendance_status` is 'P'
			$('.CheckattBox').each(function () {
				if ($(this).prop('checked')) {
					showButton = true; // If any checkbox is checked, show the button
					return false; // Break out of the loop
				}
			});

			// Toggle the visibility of the button
			if (showButton) {
				$('#generateBundleButton').show(); // Show button
			} else {
				$('#generateBundleButton').hide(); // Hide button
			}
		}

		// Initial check on page load
		toggleGenerateBundleButton();

		// Bind the change event to checkboxes
		$('.CheckattBox').on('change', function () {
			toggleGenerateBundleButton();
		});
	});

	function generateBundleNumbers() {
		// Ensure all required fields are selected
		var exam_id = $('#exam_id').val();
		var school_code = $('#school_code').val();
		var admission_course = $('#admission-course').val();
		var admission_branch = $('#stream_id').val();
		var semester = $('#semester').val();
		var subject_id = $('#subject_id').val();
		var exam_date = $('#exam_date').val();

		// Check for empty values
		if (!exam_id || !school_code || !admission_course || !admission_branch || !semester || !subject_id || !exam_date) {
			alert('Please make sure all fields are selected before generating bundle numbers.');
			return; // Exit the function if any field is empty
		}

		// Show loader
		$('#loader').show();

		// AJAX request
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Examination/generate_bundle_numbers',
			data: {
				exam_id: exam_id,
				school_code: school_code,
				admission_course: admission_course,
				admission_branch: admission_branch,
				semester: semester,
				subject_id: subject_id,
				exam_date: exam_date
			},
			success: function (response) {
				// Hide loader
				$('#loader').hide();
				alert(response); // Show success response
			},
			error: function (xhr, status, error) {
				// Hide loader
				$('#loader').hide();
				alert('Error: ' + error); // Show error message
			}
		});
	}
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

</script>
