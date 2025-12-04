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
								<div class="col-sm-2" >
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
									
									<!--option value="2023-24~WINTER" selected="selected" <?php if($_REQUEST['academic_year']=="2023-24~WINTER"){ echo "selected";}?>>2023-24 (WINTER)</option-->
									
									
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
									?></select>
                              </div>
							  <div class="col-sm-2">
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
							  <div class="col-sm-2" id="">
                                <select name="semester" id="semester" class="form-control">
                                  <option value="">Select Semester</option>
                                  </select>
                             </div>
                              <div class="col-sm-2" >
                              <select name="reporttype" id="reporttype" class="form-control" required onchange="select_date(this.value)" >
                              	<option value="">Select Report Type</option>
								<?php echo $this->session->userdata('role_id');if($this->session->userdata('role_id')==2){?>
								<option value="4" <?php if($_REQUEST['reporttype']=="4"){ echo "selected";}?> >Re-registration Not Done</option>
								<?php }else{?>
								<option value="4" <?php if($_REQUEST['reporttype']=="4"){ echo "selected";}?> >Re-registration Not Done</option>
                              	<option value="1" <?php if($_REQUEST['reporttype']=="1"){ echo "selected";}?>>Time-table Entry Report </option>
                              	<option value="2" <?php if($_REQUEST['reporttype']=="2"){ echo "selected";}?> >Subject Not Allocted </option>
								<option value="3" <?php if($_REQUEST['reporttype']=="3"){ echo "selected";}?> >Todays Lecture Details </option>
								<?php }?>
                              </select>
                              </div>
							  <div class="col-sm-2 pull-right" style="margin-top:5px;"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>                          
								
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
							
							<table class="table table-bordered" id="example">
							<thead>
								<tr>	
									<th>S.No</th>
									<th>Enrollment no</th>
									<th>Punching PRN</th>
									<th>Student name</th>
									<th>Mobile</th>
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
		"pageLength": 50,
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Consolated Lecture Details'
            }
        ]
    } );
} );
function select_date(id){
	//alert(id);
	if(id==3){
		$("#today").show();
	}else{
		$("#today").hide();
	}	
}
</script>