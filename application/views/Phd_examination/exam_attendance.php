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
	//auto load code

	var exam_session = '<?php echo $examsessionn;?>';
	var school_code = '<?php echo $school_code;?>';
	if(exam_session){

			if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>phd_examination/load_examsess_schools',
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
				url: '<?= base_url() ?>phd_examination/load_examschools',
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
				url: '<?= base_url() ?>phd_examination/load_examstreams',
				data: {course_id:admission_course,exam_session:exam_session,admission_branch:admission_branch},
				success: function (html) {
					//alert(html);
					$('#stream_id').html(html);
				}
			});
		} else {
			$('#stream_id').html('<option value="">Select course first</option>');
		}
		
		
		
		//Date load 

		var subject_id = '<?php echo $subject_id;?>';
		var semester =  '<?php echo $semester;?>';
		var subject_Date = '<?php echo $subject_datee;?>';
		//alert(admission_course);
		if (semester) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>phd_examination/load_examdate',
				data: {stream_id:admission_branch,exam_session:exam_session,semester:semester,subject_id:subject_id,subject_Date:subject_Date},
				success: function (html) {
					//alert(html);
					$('#subject_Date').html(html);
				}
			});
		} else {
			$('#subject_Date').html('<option value="">Select stream first</option>');
		}

		
		
		
		
		//subject load 
		        $('#subject_id').html('');

		var subject_id = '<?php echo $subject_id;?>';
		var semester =  '<?php echo $semester;?>';
		var subject_Date = '<?php echo $subject_datee;?>';
		//alert(admission_course);
		if (semester) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>phd_examination/load_examsubjects',
				data: {stream_id:admission_branch,exam_session:exam_session,semester:semester,subject_id:subject_id,subject_Date:subject_Date},
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
		var admission_course = '<?php echo $admission_course;?>';
		var exam_session = $("#exam_session").val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>phd_examination/load_examschools',
				data: {school_code:school_code,exam_session:exam_session,admission_course:admission_course},
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
					var course_id = '<?=$admission_course?>';
					//$('#admission-course').html(html);
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
		$('#semester').on('change', function () {	
		$('#subject_id').html('');
		var stream_id = $("#stream_id").val();
		var semester = $("#semester").val();
		var exam_session = $("#exam_session").val();
		var subject_Date = '<?php echo $subject_datee;?>';
		//alert(admission_course);
		if (semester) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>phd_examination/load_examdate',
				data: {stream_id:stream_id,exam_session:exam_session,semester:semester,subject_Date:subject_Date},
				success: function (html) {
					//alert(html);
					$('#subject_Date').html(html);
				}
			});
		} else {
			$('#subject_Date').html('<option value="">Select stream first</option>');
		}
	});	
	/////////////////////////////////
	$('#subject_Date').on('change', function () {	
		var stream_id = $("#stream_id").val();
		var semester = $("#semester").val();
		var exam_session = $("#exam_session").val();
		var exam_session = $("#exam_session").val();
		var subject_Date = $("#subject_Date").val();
		//alert(admission_course);
		if (semester) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>phd_examination/load_examsubjects',
				data: {stream_id:stream_id,exam_session:exam_session,semester:semester,subject_Date:subject_Date},
				success: function (html) {
					//alert(html);
					$('#subject_id').html(html);
				}
			});
		} else {
			$('#subject_id').html('<option value="">Select stream first</option>');
		}
	});	
	
	////////////////////////////////
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
        <li class="active"><a href="#">phd_examination</a></li>
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
                            <form method="post" action="<?=base_url()?>phd_examination/search_attendance_data">
							
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
?></select>
                              </div>

                             <!--<div class="col-sm-2" style="display:none;">
                                <select name="exam_cycle" id="exam_cycle" class="form-control" required>
                                 <option value="">--Cycle--</option>
                               
                                  <?php /*
$admission_cycle=$exam_cycle;
foreach ($fetch_cycle as $cycle) {

	if ($cycle['admission_cycle'] == $admission_cycle) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $cycle['admission_cycle']. '"'.$sel.'>' .$cycle['admission_cycle'].'</option>';
}*/
?></select>
                              </div>-->
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
                                  </select>
                             </div>
                             </div> 
                              <div class="form-group">
                              <div class="col-sm-2">
                                <select name="subject_Date" id="subject_Date" class="form-control" required>
                                  <option value="">Select Date</option>
                                  </select>
                              </div>
							 <div class="col-sm-2">
                                <select name="subject_id" id="subject_id" class="form-control" required>
                                  <option value="">Select subject</option>
                                  </select>
                              </div>
                              <div class="col-sm-1" style="margin-top:5px; margin-right: 2px;" id="">
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
							<td><b>Exam Session:</b> <?=$stud_details[0]['exam_month'].'-'.$stud_details[0]['exam_year']?></td><td><b>Stream:</b> <?=$stud_details[0]['stream_name']?></td><td><b>Semester:</b> <?=$stud_details[0]['semester']?> </td><td><b>Date:</b> &nbsp;<?php if($stud_details[0]['exam_date']){ echo date('d-m-Y',strtotime($stud_details[0]['exam_date'])); } ?> </td>
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
                    <input type="hidden" name="subject_datee" id="subject_datee" class="form-control" value="<?=$subject_datee?>">
                    <input type="hidden" name="examm_cycle" id="examm_cycle" class="form-control" value="<?=$exam_cycle?>">
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
									?>
									<input type="hidden" name="chk_stud[]" id="chk_stud" value="<?=$stud['stud_id']?>">
									<input type="hidden" name="chk_prn[]" id="chk_prn" value="<?=$stud['enrollment_no']?>">
									<tr <?=$stud["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
										
										<td><?=$j?></td> 
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['first_name']?> <?=$stud['middle_name']?> <?=$stud['last_name']?></td>	
										<td><?=$stud['semester']?></td>
										<td><input type="checkbox" name="chk_att_status[]" id="chk_attBox" class='CheckattBox' value="<?=$stud['stud_id']?>"   <?php  echo $checked;?> ></td>							
										<td><input type="text" name="ans_booklet_no[]" id="ans_booklet_no" value="<?=$stud['ans_bklet_no']?>"></td>
										<td><input type="checkbox" name="ans_booklet_received[]" id="ans_booklet_received" <?php  echo $checked1;?> class='CheckAnsBox' value="<?=$stud['stud_id']?>"></td>
										<td><input type="text" name="remark[]" id="remark" value="<?=$stud['remark']?>" ></td>
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
					<?php } else {?>
						<tr style="border:0"><td colspan=11><button class="btn btn-success" >Submit</button> </td></tr>
					<?php }?>	
						</tbody>
					</table>  
									
				
				</form>
				</div>
  </div>
            </div>