<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script>

/*$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
		"pageLength": 50,
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Time Table Entry Status'
            }
        ]
    } );
} );*/
$(document).ready(function(){
			   
	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		var academic_year = $("#academic_year").val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>academic_reports/load_courses_for_studentlist',
				data: {academic_year:academic_year,school_code:school_code},
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
var academic_year = '<?=$academic_year?>';
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>academic_reports/load_courses_for_studentlist',
				data: {academic_year:academic_year,school_code:school_code},
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
		var academic_year = $("#academic_year").val();
		var school_code = $("#school_code").val();
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>academic_reports/load_streams_student_list',
				data: {academic_year:academic_year,course_id:admission_course,school_code:school_code},
				success: function (html) {
					//alert(html);
					$('#admission-branch').html(html);
				}
			});
		} else {
			$('#admission-branch').html('<option value="">Select course first</option>');
		}
	}); 

var admission_course = '<?=$admissioncourse?>';

		if (admission_course) {
			var school_code = $("#school_code").val();
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>academic_reports/load_streams_student_list',
				data: {academic_year:academic_year,course_id:admission_course,school_code:school_code},
				success: function (html) {
					//alert(html);
					var stream_id = '<?=$stream?>';
					$('#admission-branch').html(html);
					$("#admission-branch option[value='" + stream_id + "']").attr("selected", "selected");
				}
			});
		} else {
			
			$('#stream_id').html('<option value="">Select course first</option>');
		}	
	$('#admission-branch').on('change', function () {
			var stream_id = $(this).val();
			var academic_year = $("#academic_year").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>academic_reports/load_studsemesters',
					data: {academic_year:academic_year,stream_id:stream_id},
					success: function (html) {
						$('#semester').html(html);
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		});	
	var admission_branch = '<?=$stream?>';
			if(admission_branch !=''){
			if (admission_branch) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>academic_reports/load_studsemesters',
					data: {academic_year:academic_year,stream_id:admission_branch},
					success: function (html) {
						var sem = '<?=$semester?>';
						$('#semester').html(html);
						$("#semester option[value='" + sem + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		}			
});
</script>
<style>
.absent_bg{background:#ff9b9b;}
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Academic Reports</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Academic Reports Status</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Select Following Parameters</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/Reports')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />
								<div class="form-group">
								<?php
								$role_id = $this->session->userdata('role_id');
								if ($role_id != '' && in_array($role_id, [6, 53, 58])) { ?>
								<div class="col-sm-1">
                                <select name="campus" id="campus" class="form-control" required>
                                 <option value="">Select Campus</option>
                                  <option value="1" <?php if($_REQUEST['campus']=="1"){ echo "selected";}?>>SUN</option>
                                  <option value="3" <?php if($_REQUEST['campus']=="3"){ echo "selected";}?>>SF</option>
                                  <option value="2" <?php if($_REQUEST['campus']=="2"){ echo "selected";}?>>SUM</option>
                                  </select>
                              </div>
								<?php }?>
								<div class="col-sm-1" >
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
									foreach ($all_session as $yr) {
										if ($yr['academic_year'].'~'.$yr['academic_session'] == $academic_year) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session'].'"' . $sel . '>' . $yr['academic_year'].' ('.$yr['academic_session'] . ')</option>';
									}
									?>
									
                               </select>
                              </div>
							  <div class="col-sm-1">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select School</option>
                                 <option value="0" selected>All School</option>
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
							  <div class="col-sm-1">
                                <select name="admission-course" id="admission-course" class="form-control" >
                                 <option value="">Select Course</option>
                                  <option value="0">All Courses</option>
                                  </select>
                              </div>
							   <div class="col-sm-2" id="semest">
                                <select name="admission-branch" id="admission-branch" class="form-control">
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
							  <div class="col-sm-1" id="">
                                <select name="semester" id="semester" class="form-control">
                                  <option value="">Select Semester</option>
                                  </select>
                             </div>
                              <div class="col-sm-2" >
                              <select name="reporttype" id="reporttype" class="form-control" onchange="select_date(this.value)" required>
                              	<option value="">Select Report Type</option>
								<?php echo $this->session->userdata('role_id');if($this->session->userdata('role_id')==2){?>
								<option value="4" <?php if($_REQUEST['reporttype']=="4"){ echo "selected";}?> >Re-registration Not Done</option>
								<?php }else{?>
                              	<option value="1" <?php if($_REQUEST['reporttype']=="1"){ echo "selected";}?>>Time-table Entry Not Done </option>
                              	<option value="2" <?php if($_REQUEST['reporttype']=="2"){ echo "selected";}?> >Subject Not Allocated </option>
								<option value="4" <?php if($_REQUEST['reporttype']=="4"){ echo "selected";}?> >Re-registration Not Done</option>
								<option value="6" <?php if($_REQUEST['reporttype']=="6"){ echo "selected";}?> >Syllabus Not uploaded</option>
								<option value="7" <?php if($_REQUEST['reporttype']=="7"){ echo "selected";}?> >Lecture Plan Not Done</option>
								<option value="8" <?php if($_REQUEST['reporttype']=="8"){ echo "selected";}?> >Assignment Question Bank Not Done</option>
								<option value="9" <?php if($_REQUEST['reporttype']=="9"){ echo "selected";}?> >Faculty Load</option>
								<option value="11" <?php if($_REQUEST['reporttype']=="11"){ echo "selected";}?> >Overlapping Timetable Report</option>
								<option value="10" <?php if($_REQUEST['reporttype']=="10"){ echo "selected";}?> >Program/Sem/Division/Batch wise Student Count</option>
								<!--option value="5" <?php if($_REQUEST['reporttype']=="5"){ echo "selected";}?> > <70% fees paid</option-->
								<!--option value="3" <?php if($_REQUEST['reporttype']=="3"){ echo "selected";}?> >Todays Lecture Details</option-->
								<?php }?>
                              </select>
                              </div>
							  <div class="col-sm-1 "> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
							 <div class="col-sm-2 pull-right"  style="margin-top:5px; display:none" id="today">
								 <input type="text" class="form-control" name="att_date" placeholder="Date" id="dt-datepicker1" value="<?php if($_REQUEST['att_date']){ echo $_REQUEST['att_date'];}else{ echo date('Y-m-d');}?>" required>   
</div>								 
								
                            </div>
							</form>
                        </div>
                    </div>
                </div>

            </div>    
        </div>
		  <div class="row ">
			<!--form id="form" name="form" action="<?=base_url($currentModule.'/markAttendance')?>" method="POST"-->    
            <div class="col-sm-12">

                    <div class="panel-body">
						<div class="col-sm-12">
                        <div class="table-info">  
							<div class=""> 
																
							</div>
							<?php if($reporttype=='1' || $reporttype=='2') {?>
							<table class="table table-bordered" id="example">
							<thead>
								<tr>	
									<th>S.No</th>
									<th>School</th>
									<th>Stream Name</th>
									<th>Semester</th>
									<?php if($reporttype=='2') {?>
									<th>No of Student</th>
									<?php }?>
									<th>Status</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
								//echo "<pre>";
								//print_r($ttentry);
								$first_yr_streams= array('5','6','7','8','10','11','96','97','107','108','109');
								$diploma_stream=array('71');
								$subjectname ="";
								$i=1;
									if(!empty($ttentry)){
										foreach($ttentry as $tt){
											
											if($tt['current_semester']=='1' && in_array($tt['admission_stream'],$first_yr_streams)){
												echo "";
											}

														/*	else if($tt['current_semester']=='2' && in_array($tt['admission_stream'],$diploma_stream))
											{
												?>
													<tr style="<?=$stle?>">
														<td><?=$i?></td>
														<td><?=$tt['stream_name']?></td>
														<td><?=$tt['current_semester']?></td>
														<td><?=$tt['entry_status'];?></td>
														
													</tr>
															<?php
												$i++;	

											}*/
											else if($tt['current_semester']=='21' && !in_array($tt['admission_stream'],$diploma_stream))
											{
												echo "";
											}

											else{
												
												?>
													<tr style="<?=$stle?>">
														<td><?=$i?></td>
														<td><?=$tt['school_name']?></td>
														<td><?=$tt['stream_name']?></td>
														<td><?=$tt['current_semester']?></td>
														<?php if($reporttype=='2') {?>
															<td><?=$tt['studentcount']?></td>
														<?php } ?>
														<td><?php if(isset($tt['entry_status'])){echo $tt['entry_status'];} else {echo "<span style='color:red;'>not done</span>";}?> &nbsp;
																<?php if($reporttype=='2'){ ?>
															<a href="<?=base_url("subject_allocation/search_subAndStudentdetails/".$tt['course_id'].'/'.$tt['admission_stream'].'/'.$tt['current_semester'].'/'.$acd_yr)?>" target="_blank">
															<i class="fa fa-eye"></i></a> <?php }?>
															</td>
														
													</tr>
															<?php
												$i++;		unset($tt['studentcount']);									
														
														}
										}
													}else{
														echo "<tr><td colspan=5>No data found.</td></tr>";
													}
												?>
								</tbody>
							</table>
							<?php }elseif($reporttype=='7') {?>
							<table border="1" cellpadding="8" cellspacing="0"  class="table table-bordered" id="example">
							<thead>
								<tr>
									<th>School</th>
									<th>Course</th>
									<th>Stream</th>
									<th>Semester</th>
									<th>SubjectId</th>
									<th>Subject</th>
									<th>Faculty Code</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($subjects)): ?>
									<?php foreach ($subjects as $row): ?>
										<tr>
											<td><?= $row['school_short_name'] ?></td>
											<td><?= $row['course_short_name'] ?></td>
											<td><?= $row['stream_name'] ?></td>
											<td><?= $row['semester'] ?></td>
											<td><?= $row['sub_id'] ?></td>
											<td><?= $row['subject_code'] ?> - <?= $row['subject_name'] ?></td>
											<td><?= $row['faculty_code'].'-'.$row['faculty_name'] ?></td>
										</tr>
									<?php endforeach; ?>
								<?php else: ?>
									<tr><td colspan="6">No subjects found</td></tr>
								<?php endif; ?>
							</tbody>
						</table>
							<?php }elseif($reporttype=='6') {?>
							<table border="1" cellpadding="8" cellspacing="0"  class="table table-bordered" id="example">
							<thead>
								<tr>
									<th>School</th>
									<th>Course</th>
									<th>Stream</th>
									<th>Semester</th>
									<th>SubjectId</th>
									<th>Subject</th>
									<th>Type</th>
									
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($subjects)): ?>
									<?php foreach ($subjects as $row): ?>
										<tr>
											<td><?= $row['school_short_name'] ?></td>
											<td><?= $row['course_short_name'] ?></td>
											<td><?= $row['stream_name'] ?></td>
											<td><?= $row['semester'] ?></td>
											<td><?= $row['sub_id'] ?></td>
											<td><?= $row['subject_code'] ?> - <?= $row['subject_name'] ?></td>
											<td><?= $row['subject_component'] ?></td>
											
										</tr>
									<?php endforeach; ?>
								<?php else: ?>
									<tr><td colspan="6">No subjects found</td></tr>
								<?php endif; ?>
							</tbody>
						</table>
							<?php }elseif($reporttype=='8') {?>
							<table border="1" cellpadding="8" cellspacing="0"  class="table table-bordered" id="example">
							<thead>
								<tr>
									<th>School</th>
									<th>Course</th>
									<th>Stream</th>
									<th>Semester</th>
									<th>SubjectId</th>
									<th>Subject</th>
									<th>TYpe</th>
									
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($subjects)): ?>
									<?php foreach ($subjects as $row): ?>
										<tr>
											<td><?= $row['school_short_name'] ?></td>
											<td><?= $row['course_short_name'] ?></td>
											<td><?= $row['stream_name'] ?></td>
											<td><?= $row['semester'] ?></td>
											<td><?= $row['sub_id'] ?></td>
											<td><?= $row['subject_code'] ?> - <?= $row['subject_name'] ?></td>
											<td><?= $row['subject_component'] ?> </td>
											
										</tr>
									<?php endforeach; ?>
								<?php else: ?>
									<tr><td colspan="6">No subjects found</td></tr>
								<?php endif; ?>
							</tbody>
						</table>
							<?php }elseif($reporttype=='4'){?>
							<table class="table table-bordered" id="example">
							<thead>
								<tr>	
									<th>S.No</th>
									<th>Enrollment no</th>
									<th>Punching PRN</th>
									<th>Student name</th>
									<th>Mobile</th>
									<th>Parent Mobile</th>
									<th>Email</th>
									<th>school </th>
									<th>Course</th>
									<th>Stream</th>
									<th>Pattern</th>
									<th>Admission session</th>
									<th>Academic year</th>
									<th>Current Semester</th>
									<th>Current Year</th>																		
									<th>Final Semester</th>									
									<th>Course Duration</th>
									<th>Nationality</th>
									<th>Country</th>
									<th>State</th>
									<th>City</th>
									<th>Package Name</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
								//echo "<pre>";
								//print_r($stud_list);exit;
								$first_yr_streams= array('5','6','7','8','10','11','96','97','107','108','109','158','159');
								$diploma_stream=array('71');
								$subjectname ="";
								$i=1;								
									if(!empty($stud_list)){
										foreach($stud_list as $tt){
												?>
													<tr style="<?=$stle?>">
														<td><?=$i?></td>
														<td><?=$tt['enrollment_no']?></td>
														<td><?=$tt['punching_prn']?></td>
														<td><?=$tt['student_name']?></td>
														<td><?=$tt['mobile']?></td>
														<td><?=$tt['parent_mobile2']?></td>
														<td><?=$tt['email']?></td>
														<td><?=$tt['school_short_name']?></td>
														<td><?=$tt['course_short_name']?></td>
														<td><?=$tt['stream_name']?></td>
														<td><?=$tt['course_pattern']?></td>
														<td><?=$tt['admission_session']?></td>
														<td><?=$tt['academic_year']?></td>
														<td><?=$tt['current_semester']?></td>
														<td><?=$tt['current_year']?></td>
														
														<td><?=$tt['final_sem']?></td>
														
														<td><?=$tt['course_duration']?></td>
														<td><?=$tt['nationality']?></td>
														<td><?=$tt['countryname']?></td>
														<td><?=$tt['state_name']?></td>
														<td><?=$tt['taluka_name']?></td>
														<td><?=$tt['package_name']?></td>
													</tr>
															<?php
												$i++;											
														
														
												}	
										}else{
											echo "<tr><td colspan=6>No data found.</td></tr>";
										}
								
								?>
								</tbody>
							</table>
							<?php }elseif($reporttype=='9'){?>
							
							<table class="table table-bordered table-striped table-hover" id="example">
							<thead>
								<tr>
									<th>Sr. No</th>
									<th>Faculty Code</th>
									<th>Name</th>
									<th>Designation</th>
									<th>Department</th>
									<th>College</th>
									<th>Mobile</th>
									<!--th>TH Load</th-->
									<th>TH Hours</th>
									<!--th>PR Load</th-->
									
									<th>PR Hours</th>
									<!--th>Total Load</th-->
									<th>Total Hours</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1;if (!empty($faculty_load_report)) : ?>
									<?php foreach ($faculty_load_report as $row) : ?>
										<tr>
											<td><?= $i ?></td>
											<td><?= $row['faculty_code'] ?></td>
											<td><?= $row['faculty_name'] ?></td>
											<td><?= $row['designation_name'] ?></td>
											<td><?= $row['department_name'] ?></td>
											<td><?= $row['college_code'] ?></td>
											<td><?= $row['mobile_no'] ?></td>
											<!--td><?= $row['th_load'] ?></td-->
											<td><?= $row['th_hours'] ?></td>
											<!--td><?= $row['pr_load'] ?></td-->
											
											<td><?= $row['pr_hours'] ?></td>
											<!--td><?= $row['th_load']+$row['pr_load']?></td-->
											<td><?= $row['total_hours']?></td>
										</tr>
									<?php $i++;endforeach; ?>
								<?php else : ?>
									<tr><td colspan="10" class="text-center">No records found.</td></tr>
								<?php endif; ?>
							</tbody>
						</table>

							<?php }elseif($reporttype=='10'){?>
							
							<table class="table table-bordered table-striped table-hover" id="example">
							<thead>
								<tr>
									<th>Sr. No</th>
									<th>School</th>
									<th>Course</th>
									<th>Stream</th>
									<th>Semester</th>
									<th>Division</th>
									<th>Batch</th>
									<th>Student Count</th>
									
								</tr>
							</thead>
							<tbody>
								<?php $i=1;if (!empty($faculty_load_report)) : ?>
									<?php foreach ($faculty_load_report as $row) : ?>
										<tr>
											<td><?= $i ?></td>
											<td><?= $row['school_short_name'] ?></td>
											<td><?= $row['course_short_name'] ?></td>
											<td><?= $row['stream_name'] ?></td>
											<td><?= $row['semester'] ?></td>
											<td><?= $row['division'] ?></td>
											<td><?= $row['batch'] ?></td>
											<td><?= $row['student_count'] ?></td>

										</tr>
									<?php $i++;endforeach; ?>
								<?php else : ?>
									<tr><td colspan="10" class="text-center">No records found.</td></tr>
								<?php endif; ?>
							</tbody>
						</table>

							<?php }elseif($reporttype=='11'){?>
							
							<table class="table table-bordered table-striped table-hover" id="example">
							<thead>
								<tr>
									<th>Sr. No</th>
									<th>Faculty Code</th>
									<th>Faculty Name</th>
									<th>School</th>								
									<th>Department</th>								
									<th>Day</th>
									<th>Subject Codes</th>
									<th>Subject Count</th>
									
								</tr>
							</thead>
							<tbody>
								<?php $i=1;if (!empty($faculty_load_report)) : ?>
									<?php foreach ($faculty_load_report as $row) : ?>
										<tr>
											<td><?= $i ?></td>
											<td><?= $row['faculty_code'] ?></td>
											<td><?= $row['facultyname'] ?></td>
											<td><?= $row['school_short_name'] ?></td>
											<td><?= $row['department_name'] ?></td>
											<td><?= $row['wday'] ?></td>
											<td><?= $row['overlapping_subjects'] ?></td>
											<td><?= $row['subject_group_count'] ?></td>

										</tr>
									<?php $i++;endforeach; ?>
								<?php else : ?>
									<tr><td colspan="10" class="text-center">No records found.</td></tr>
								<?php endif; ?>
							</tbody>
						</table>

							<?php }?>
						</div>
                    </div>
                </div>
			</div>
			<!--/form-->		
		</div>
			
    </div>
</div>
<script>
$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
$(document).ready(function() {
    $('#example').DataTable({
        dom: 'Bfrtip',
        pageLength: 50,
        buttons: [
            {
                extend: 'excel',
                messageTop: '<?=$title?>-<?=$acd_yr?>',
                filename: '<?=$school_name?>-<?=$title?>-<?=$acd_yr?>', // <-- Set your desired file name here
            }
        ]
    });
});
function select_date(id){
	//alert(id);
	if(id==3){
		$("#today").show();
	}else{
		$("#today").hide();
	}	
}
</script>