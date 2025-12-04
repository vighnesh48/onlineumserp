<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
/* ===== Modern Theme Enhancements (Bootstrap 3 Compatible) ===== */

/* Base Font + Color Palette */
body {
  background: #f6f8fb;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  color: #333;
}

/* Breadcrumb */
.breadcrumb {
  background: linear-gradient(to right, #4b6cb7, #182848);
  border-radius: 4px;
  color: #fff;
  padding: 8px 15px;
}
.breadcrumb > li > a,
.breadcrumb > .active {
  color: #fff !important;
  font-weight: 500;
}
.breadcrumb > li + li:before {
  color: rgba(255, 255, 255, 0.5);
}

/* Page Header */
.page-header {
  background: #fff;
  border-radius: 6px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  padding: 15px 20px;
  margin-top: 10px;
  border-left: 5px solid #4b6cb7;
}
.page-header h1 {
  font-size: 22px;
  font-weight: 600;
  color: #2c3e50;
  margin: 10px 0;
}
.page-header-icon {
  color: #4b6cb7;
}

/* Panels */
.panel {
  border: none !important;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  background: #fff;
}
.panel-heading {
  background: linear-gradient(to right, #4b6cb7, #182848);
  color: #fff;
  border-radius: 8px 8px 0 0;
  padding: 12px 20px;
}
.panel-title {
  font-weight: 600;
  font-size: 15px;
}

/* Form Controls */
.form-control {
  border-radius: 4px;
  border: 1px solid #d0d4da;
  box-shadow: none !important;
  transition: all 0.2s ease-in-out;
}
.form-control:focus {
  border-color: #4b6cb7;
  box-shadow: 0 0 0 2px rgba(75,108,183,0.1);
}

/* Buttons */
.btn {
  border-radius: 4px !important;
  transition: all 0.2s ease-in-out !important;
}
.btn-primary {
  background: linear-gradient(to right, #5d8fff, #0037a5) !important;
  border: none !important;
}
.btn-primary:hover {
  background: linear-gradient(to right, #3e5ca4, #152043) !important;
}
.btn-success {
  background: linear-gradient(to right, #43cea2, #185a9d) !important;
  border: none !important;
}
.btn-success:hover {
  background: linear-gradient(to right, #38b592, #144f89) !important;
}
.btn-warning {
  background: linear-gradient(to right, #fd0000, #185a9d) !important;
  border: none !important;
}
.btn-warning:hover {
  background: linear-gradient(to right, #38b592, #fd0000) !important;
}

/* Tables */
.table {
  background: #fff !important;
  border: 1px solid #dee2e6 !important;
  border-radius: 6px !important;
  overflow: hidden !important;
}
.table th {
  background: #4b6cb7 !important;
  color: #fff !important;
  text-align: center !important;
  vertical-align: middle !important;
  font-weight: 600 !important;
  border: none !important;
}
.table-bordered > thead > tr > th,
.table-bordered > tbody > tr > td {
  border: 1px solid #dee2e6 !important;
}
.table td {
  vertical-align: middle !important;
  font-size: 13px !important;
  text-align: center !important;
}
.table tr:nth-child(even) {
  background: #f9fbfd !important;
}

/* Highlight "Not Assigned" */
small[style*='color:red'] {
  color: #e74c3c !important;
  font-weight: 600 !important;
}

/* Action Icons */
.fa-edit {
  color: #2980b9 !important;
  transition: 0.3s !important;
}
.fa-edit:hover {
  color: #1c5989 !important;
}
.fa-plus {
  color: #27ae60;
  transition: 0.3s !important;
}
.fa-plus:hover {
  color: #1e874b !important;
}

/* Section Title */
h5 b {
  color: #34495e !important;
}

/* PDF Buttons Area */
.btn-labeled i {
  margin-right: 5px !important;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .form-group .col-sm-2, .form-group .col-sm-3 {
    margin-bottom: 10px !important;
  }
  .btn {
    width: 100%;
    margin-top: 10px !important;
  }
}

/* Subtle Hover Effect */
.table tr:hover {
  background: #eef2f7 !important;
  transition: 0.2s !important;
}

/* Additional Clean Look */
select.form-control option {
  padding: 5px !important;
}
</style>#fd0000

<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<script>    
$(document).ready(function()
{
	//$('#exam_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
});

function getExamDate(id){
	$('#'+id).datepicker( {format: 'dd/mm/yyyy',autoclose: true});
	$('#'+id).focus();
	return true;
}
    var base_url = '<?=base_url();?>';
	function load_streams(type){
                   // alert(type);
                    
		$.ajax({
			'url' : base_url + 'Examination/load_streams',
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
			   
	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		var batch = $("#batch").val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>marks/load_subject_coures',
				data: {school_code:school_code,batch:batch},
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
		var course_id = $(this).val();
			var batch = $("#batch").val();

			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>subject/load_streams',
					data: {course_id:course_id,batch:batch},
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
		var stream_id = $("#stream_id").val();
		var batch = $("#batch").val();

		if (stream_id) {
			$.ajax({
				'url' : base_url + 'Subject/load_semester',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'batch' : batch,stream_id:stream_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semester'); //jquery selector (get element by id)
					if(data){	
						container.html(data);
					}
				}
			});
		} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		});
		//edit semester
		var stream_id = '<?=$stream?>';
		var batch = '<?=$batch?>';
			if (stream_id) {
				$.ajax({
					type: 'POST',
					'url' : base_url + 'Subject/load_semester',
					'data' : {'batch' : batch,stream_id:stream_id},
					success: function (html) {
						//alert(html);
						var semester = '<?=$semester?>';
						$('#semester').html(html);
						$("#semester option[value='" + semester + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
	// edit
var admission_course = '<?=$admissioncourse?>';

		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>subject/load_streams',
					data: {course_id:admission_course,batch:batch},
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
        <li class="active"><a href="#">Examination</a></li>
        <li class="active"><a href="#">Marks</a></li>
    </ul>
    <div class="page-header">
<form method="post" action ="<?=base_url()?>marks/assign_prac_faculty">	
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Practical Faculty Assign </h1>
			<div>Exam Session : <?=$exam_session[0]['exam_month'].'-'.$exam_session[0]['exam_year'];?>, &nbsp;&nbsp;&nbsp;&nbsp; Subject Type: &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="marks_type" id="marks_type3" value="PR" checked="true" required> Practical   
			
		  <?php $exam_sess_val = $exam_session[0]['exam_month'] .'-'.$exam_session[0]['exam_year'].'-'.$exam_session[0]['exam_id'];?>
		  <input type="hidden" name="exam_session" id="exam_session" value="<?=$exam_sess_val?>">
			</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">
                            
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							  <div class="col-sm-2" >
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
									foreach ($academic_year as $yr) {
										if ($yr['academic_year'].'~'.$yr['academic_session'] == $academicyear) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session'].'"' . $sel . '>' . $yr['academic_year'].' ('.$yr['academic_session'] . ')</option>';
									}
									?>
									<!--option value="2019-20~SUMMER" selected>2019-20 (SUMMER)</option-->

                               </select>
                              </div>
							  <div class="col-sm-2" >
                                <select name="batch" id="batch" class="form-control" required>
                                  <option value="">Select Batch</option>
                                  <?php
                                    foreach ($batches as $bth) {
                                        if ($bth['batch'] == $batch) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $bth['batch'] . '"' . $sel . '>' . $bth['batch'] . '</option>';
                                    }
                                    ?>
                               </select>
                              </div>
							<div class="col-sm-2">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select School</option>
                                  <?php
																	  //print_r($schools);exit;
									foreach ($schools as $sch) {
										if ($sch['school_code'] == $school_code) {
											$sel1 = "selected";
										} else {
											$sel1 = '';
										}
										echo '<option value="' . $sch['school_code'] . '"' . $sel1 . '>' . $sch['school_short_name'] . '</option>';
									}
									?></select>
                              </div>
                              <div class="col-sm-2">
                                <select name="admission-course" id="admission-course" class="form-control" required>
                                 <option value="">Select Course</option>
                                  </select>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-2" id="semest">
                                <select name="admission-branch" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
                              <div class="col-sm-1" id="">
                                <select name="semester" id="semester" class="form-control" required>
                                  <option value="">Semester</option>
                                  
                                  </select>
                             </div>
                            
                          
							<div class="col-sm-1" >
                                 <input type="submit" id="" class="btn btn-primary btn-labeled " value="Search" > 
                            </div>
							 </div>
                            </form>
							
                        </span>
						<div class="form-group">
								<div class="col-sm-12" >
									<div class="col-sm-3" >
									</div>
									<div class="col-sm-3" >
										<form method="post" action="<?= base_url('marks/assign_prac_faculty_pdf') ?>" target="_blank">
											<input type="hidden" name="school_code" value="<?= $school_code ?>">
											<input type="hidden" name="admission-course" value="<?= $admissioncourse ?>">
											<input type="hidden" name="admission-branch" value="<?= $stream ?>">
											<input type="hidden" name="semester" value="<?= $semester ?>">
											<input type="hidden" name="exam_session" value="<?= $exam_session[0]['exam_month'].'-'.$exam_session[0]['exam_year'].'-'.$exam_id ?>">
											<input type="hidden" name="academic_year" value="<?= $academicyear ?>">
											<input type="hidden" name="batch" value="<?= $batch ?>">
											<button type="submit" class="btn btn-success btn-labeled pull-right">
												<i class="fa fa-file-pdf-o"></i> Generate Faculty Report PDF
											</button>
										</form>
									</div>
									<div class="col-sm-3" >
										<form method="post" action="<?= base_url('marks/practical_noticeboard_pdf') ?>" target="_blank">
											<input type="hidden" name="school_code" value="<?= $school_code ?>">
											<input type="hidden" name="admission-course" value="<?= $admissioncourse ?>">
											<input type="hidden" name="admission-branch" value="<?= $stream ?>">
											<input type="hidden" name="semester" value="<?= $semester ?>">
											<input type="hidden" name="exam_session" value="<?= $exam_session[0]['exam_month'].'-'.$exam_session[0]['exam_year'].'-'.$exam_id ?>">
											<input type="hidden" name="academic_year" value="<?= $academicyear ?>">
											<input type="hidden" name="batch" value="<?= $batch ?>">
											<button type="submit" class="btn btn-success btn-labeled pull-right">
												<i class="fa fa-file-pdf-o"></i> Generate Notice Bord Report PDF
											</button>
										</form>
									</div>	
									<div class="col-sm-3">
										<button type="button" id="verifyBtn" class="btn btn-warning btn-labeled pull-right">
											<i class="fa fa-check"></i> Verify All Bellow Faculty Allocations
										</button>
									</div>
								</div>
							</div>
                </div>

            <div class="table-info panel-body" >  
			<?php 
			$role_id=$this->session->userdata('role_id');
			//if(isset($role_id) && $role_id==1 ){?>
            <form id="" method="post" action ="<?=base_url()?>Exam_timetable/insert_exam_timetable">

            <input type="hidden" name="stream_id" value="<?=$stream?>">
			<input type="hidden" name="adm_semester" value="<?=$semester?>">
				<?php// }?>
			
                <div class="col-lg-12">
                    <div class="table-info table-responsive" id="stddata">    
				<?php 	
					if($_POST){
				$CI =& get_instance();
                $CI->load->model('Marks_model');
				?>
			
					<table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   
                                    <th>S.No.</th>
									
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
									<th>Semester</th>
									<th>Division</th>
									<th>Batch</th>
									<th>Strength</th>
                                    <th>Faculty</th>
                                    <th>Ext.Faculty</th>
									<th>Lab Assistant</th>
									<th>Date</th>
									<th>Time</th>
                                    <th width="10%">Action</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                            <?php
                          // echo "<pre>";
						  // print_r($sub_list);
                          if (!empty($sub_list)) {
    // Group subjects by subject_id
    $grouped = [];
    foreach ($sub_list as $sub) {
        $grouped[$sub['sub_id']][] = $sub;
    }

    $j = 1;
    foreach ($grouped as $subject_id => $rows) {
        $rowspan = count($rows);
        $first = true;

        foreach ($rows as $row) {
            $strength = $this->Marks_model->fetch_student_strength(
                $row['sub_id'],
                $row['tt_details'][0]['stream_id'],
                $row['semester'],
                $row['division'],
                $row['batch_no'],
                $academicyear
            );
			$studstrength = count($strength);
            $array_course = [4, 5, 43];
            $batch = in_array($row['tt_details'][0]['course_id'], $array_course) ? 0 : $row['batch_no'];

            if ($first) {
                // Start merged subject row
                echo "<tr>";
                echo "<td rowspan='{$rowspan}'>{$j}</td>";
                echo "<td rowspan='{$rowspan}'>" . strtoupper($row['subject_code']) . "</td>";
                echo "<td rowspan='{$rowspan}'>" . strtoupper($row['sub_id'] . ' - ' . $row['subject_name']) . "</td>";
                $first = false;
            } else {
                echo "<tr>";
            }

            // Remaining batch-wise columns
            ?>
                <td><?=$row['semester']?></td>
                <td><?=$row['division']?></td>
                <td><?=$row['batch_no']?></td>
                <td><?=$studstrength;?></td>
                <td>
                    <?php
                    if (!empty($row['tt_details'][0]['fname'])) {
                        echo strtoupper($row['tt_details'][0]['fname'][0] . '. ' . $row['tt_details'][0]['mname'][0] . '. ' . $row['tt_details'][0]['lname']);
                    } else {
                        echo "<small style='color:red;'>Not Assigned</small>";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if (!empty($row['tt_details'][0]['ext_faculty_code'])) {
                        echo strtoupper($row['tt_details'][0]['ext_faculty_code']);
                    } else {
                        echo "<small style='color:red;'>Not Assigned</small>";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if (!empty($row['tt_details'][0]['lab_fname'])) {
                        echo strtoupper($row['tt_details'][0]['lab_fname'][0] . '. ' . $row['tt_details'][0]['lab_mname'][0] . '. ' . $row['tt_details'][0]['lab_lname']);
                    } else {
                        echo "<small style='color:red;'>Not Assigned</small>";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if (!empty($row['tt_details'][0]['exam_date'])) {
                        echo $row['tt_details'][0]['exam_date'];
                    } else {
                        echo "<small style='color:red;'>Not Assigned</small>";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if (!empty($row['tt_details'][0]['exam_from_time'])) {
                        echo $row['tt_details'][0]['exam_from_time'] . ':00 - ' . $row['tt_details'][0]['exam_to_time'] . ':00 ' . $row['tt_details'][0]['time_format'];
                    } else {
                        echo "<small style='color:red;'>Not Assigned</small>";
                    }
                    ?>
                </td>
                <td>
					<?php if($row['tt_details'][0]['verified_flag'] == 0 || $role_id == 15){ ?>
                    <a href="<?=base_url($currentModule . '/add_subject_faculty/' . $row['sub_id'] . '/' . $row['stream_id'] . '/' . $row['semester'] . '/' . $exam_id . '/' . $school_code . '/' . $row['division'] . '/' . $row['batch_no'])?>" target="_blank">
					<i class="fa fa-edit"></i></a> || <?php } ?>
                    <a href="<?=base_url('Remuneration/faculty_subject/' . $row['sub_id'] . '/' . $row['stream_id'] . '/' . $row['semester'] . '/' . $exam_id . '/' . $school_code . '/' . $row['division'] . '/' . $row['batch_no'])?>" target="_blank">
                        <i class="fa fa-plus"></i></a>
                </td>
            </tr>
            <?php
        }
        $j++;
    }
} else {
    echo "<tr><td colspan='13'>No data found.</td></tr>";
}
                            ?>                            
                        </tbody>
                    </table>  
					<div><h5><b>Back Log Subjects:</b></h5></div>
					<div class="table-responsive">
				<table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   
                                    <th>S.No.</th>
									
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
									<th>Semester</th>
									<th>Division</th>
									<th>Batch</th>
									<th>Strength</th>
                                    <th>Faculty</th>
									<th>Ext.Faculty</th>
									<th>Lab Assistant</th>
									<th>Date</th>
									<th>Time</th>									
                                    <th width="10%">Action</th>
                                    
                            </tr>
                        </thead>
                       <tbody id="studtbl">
                            <?php
                            //echo "<pre>";
							//print_r($bksub_list);
                          if(!empty($bksub_list)){
                            $j=1;                            
                            for($i=0;$i<count($bksub_list);$i++)
                            {
                               //echo $bksub_list[$i]['isPresent']; 
							  
							   $strength =$this->Marks_model->fetch_student_strength_backlog($bksub_list[$i]['sub_id'],$bksub_list[$i]['semester'],$exam_id);
							   $bk_studstrength = count($strength);
							   
							   $array_course =array(4,5,43);
							   if(in_array($bksub_list[$i]['tt_details'][0]['course_id'],$array_course)){
								   $batch=0;
							   }else{
								   $batch=1;
							   }
                            ?>
							<input type="hidden" name="subject_id[]" id="subject_id<?=$j?>" class='studCheckBox' value="<?=$bksub_list[$i]['sub_id']?>">
							<input type="hidden" name="subject_code[]" id="subject_code<?=$j?>" class='studCheckBox' value="<?=$bksub_list[$i]['subject_code']?>">
							 <?php if($bksub_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$bksub_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
							
                              <td><?=$j?></td>
                        
                                 <td><?=strtoupper($bksub_list[$i]['subject_code'])?></td> 
                                    <td>
							
							<?php
								echo $bksub_list[$i]['sub_id'].'-'.strtoupper($bksub_list[$i]['subject_name']);
								?>
								</td> 
								<td><?=$bksub_list[$i]['semester']?></td>
								<td>A</td>
								<td><?=$batch?></td>
								<td><?=$bk_studstrength?></td>
								<td>
									<?php
										if(!empty($bksub_list[$i]['tt_details'][0]['fname'])){
											echo strtoupper($bksub_list[$i]['tt_details'][0]['fname'][0].'. '.$bksub_list[$i]['tt_details'][0]['mname'][0].'. '.$bksub_list[$i]['tt_details'][0]['lname']);
										}else{ 
											$fac_app=1;
										echo "<small style='color:red;'>Not Assigned</small>";
									}?>
								</td>
								<td>
									<?php
										if(!empty($bksub_list[$i]['tt_details'][0]['ext_faculty_code'])){
											echo strtoupper($bksub_list[$i]['tt_details'][0]['ext_faculty_code']);
										}else{ 
											$fac_app=1;
										echo "<small style='color:red;'>Not Assigned</small>";
									}?>
								</td>
								<td>
									<?php
										if(!empty($bksub_list[$i]['tt_details'][0]['lab_fname'])){
											echo strtoupper($bksub_list[$i]['tt_details'][0]['lab_fname'][0].'. '.$bksub_list[$i]['tt_details'][0]['lab_mname'][0].'. '.$bksub_list[$i]['tt_details'][0]['lab_lname']);
										}else{ 
											$fac_app=1;
										echo "<small style='color:red;'>Not Assigned</small>";
									}?>
								</td>
								
								<td><?php
										if(!empty($bksub_list[$i]['tt_details'][0]['exam_date'])){
											echo $bksub_list[$i]['tt_details'][0]['exam_date'];
										}else{ 
										
										echo "<small style='color:red;'>Not Assigned</small>";
									}?></td>
								<td><?php
										if(!empty($bksub_list[$i]['tt_details'][0]['exam_from_time'])){
											echo $bksub_list[$i]['tt_details'][0]['exam_from_time'].':00 - '.$bksub_list[$i]['tt_details'][0]['exam_to_time'].':00 '.$bksub_list[$i]['tt_details'][0]['time_format'];
										}else{ 
										
										echo "<small style='color:red;'>Not Assigned</small>";
									}?></td>
                                <td>
									<?php if($bksub_list[$i]['tt_details'][0]['verified_flag'] == 0 || $role_id == 15){
										//print_r($bksub_list[$i]);
										?>
								
									<a href="<?=base_url($currentModule . '/add_subject_faculty/' . $bksub_list[$i]['sub_id'] . '/' . $bksub_list[$i]['stream_id'] . '/' . $bksub_list[$i]['semester'] . '/' . $exam_id . '/' . $school_code . '/' . 'A' . '/' . $batch. '/' . 'bklog')?>" target="_blank">
									<i class="fa fa-edit"></i></a> || <?php } ?>
									<a href="<?=base_url('Remuneration/faculty_subject/' . $bksub_list[$i]['sub_id'] . '/' . $bksub_list[$i]['stream_id'] . '/' . $bksub_list[$i]['semester'] . '/' . $exam_id . '/' . $school_code . '/' . 'A' . '/' . $batch . '/' . 'bklog')?>" target="_blank">
									<i class="fa fa-eye"></i></a>
									<!-- a href="<?=base_url('Remuneration/faculty_subject/' . $row['sub_id'] . '/' . $row['stream_id'] . '/' . $row['semester'] . '/' . $exam_id . '/' . $school_code . '/' . $row['division'] . '/' . $batch)?>" target="_blank">
									<i class="fa fa-plus"></i></a -->
                                </td>						
                          
                            </tr>
                            <?php
                            $j++;
                            }
						  }else{
							  echo "<tr><td colspan=9> No data found.</td></tr>";
						  }
                            ?>                            
                        </tbody>
                    </table>  
					 </div>
					
			</form>		
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
});	

$(document).ready(function() {
$("#expdata").click(function(){

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
} );



$(document).ready(function() {
    $('#verifyBtn').on('click', function() {
        // Gather all selected filter values
        var data = {
            school_code: $('#school_code').val(),
            course_id: $('#admission-course').val(),
            stream_id: $('#stream_id').val(),
            semester: $('#semester').val(),
            batch: $('#batch').val(),
            academic_year: $('#academic_year').val(),
            exam_session: $('#exam_session').val()
        };

        // Optional: check if all required fields are selected
        for (var key in data) {
            if (!data[key]) {
                alert('Please select all filters before verifying.');
                return false;
            }
        }

        // Confirm before verification
        if (!confirm('Are you sure you want to verify all entries for these parameters?')) return;

        // AJAX request to update verified flag
        $.ajax({
            url: '<?= base_url("marks/verify_practical_entries") ?>',
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    alert('All entries verified successfully!');
                    location.reload(); // reload to reflect verification
                } else {
                    alert('Verification failed: ' + response.message);
                }
            },
            error: function() {
                alert('Something went wrong. Please try again.');
            }
        });
    });
});


</script>