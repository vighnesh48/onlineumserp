<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<style>
.absent_bg{background:#ff9b9b;}
</style>
<?php
$role_id = $this->session->userdata('role_id');
$astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">View Attendance</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Project-Wise Attendance</h1>
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
                       <input type="hidden" value="<?=isset($empId) ? $empId : ''?>" id="empId" name="empId" />
                            <form id="form" name="form" action="<?=base_url($currentModule.'/search_project_attendance')?>" method="POST">                                                            
                               
								<div class="form-group">   
															
								<div class="col-sm-3">
									<label class="">Select Academic Year</label>	
								
									<select id="academic_year" name="academic_year" class="form-control"  required>
										<option value="">Select Academic Year</option>
										<?php 
										if($academic_year !=''){
											$academic_year1 = $academic_year;    
										}
										else{
											$academic_year1 =ACADEMIC_YEAR;
										}
                                        if(!empty($academic_years)){
                                            foreach($academic_years as $academic_year){
                                                if($academic_year1 == $academic_year['academic_year']){
                                                    echo '<option value="'.$academic_year['academic_year'].'" selected="selected">'.$academic_year['academic_year'].'</option>';
                                                }else{
                                                   // echo '<option value="'.$academic_year['academic_year'].'">'.$academic_year['academic_year'].'</option>';
                                                }
                                            }
                                            
                                        }
										?>									
									</select>											
								</div>
								
								<?php if($role_id == 1 || $role_id == 10 || $role_id == 20 || $role_id == 53){ ?>								
								<div class="col-sm-3">
									<label class="">Select Faculty </label>
									<select id="faculty_code" name="faculty_code" class="form-control" >
										<option value="">Select Faculty</option>

									</select>											
								</div> 

								<?php } ?>
								
								<div class="col-sm-3">
									<label class="">Select Project</label>
									<select id="project_details_id" name="project_details_id" class="form-control"  required>
										<option value="">Select Project</option>
												 			
									</select>											
								</div> 
                                
								<div class="col-sm-2"><label class="">.</label> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
								<div class="col-sm-5"></div>
                            </div>
							
							</form>
                    </div>

                </div>

            </div>    
        </div>
		  <div class="row ">
			<!--form id="form" name="form" action="<?=base_url($currentModule.'/markAttendance')?>" method="POST"-->    
            <div class="col-sm-6">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname">Attendance : 
							
							</span>
                    </div>
                    <div class="panel-body">
						
                        <div class="table-info">  
							<table class="table table-bordered">
							<thead>
								<tr>
									
									<th>Sr</th>
									<th>Date</th>
									<th>Slot</th>
									<th>P</th>
									<th>A</th>
									<th>T</th>
									<th>Report Description</th>
									<th>Action</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
								//echo "<pre>";
								//print_r($attCnt);

								$i=1;
									if(!empty($attCnt)){
										foreach($attCnt as $att){
											$attendance_date = date("d-m-Y", strtotime($att['attendance_date']) );
											$slottime = $att['from_time'].'-'.$att['to_time'];
								?>
									<tr>
										
										<td><?=$i?></td>
										<td><?=$attendance_date?></td>
										<td><?=$att['from_time']?> - <?=$att['to_time']?></td>
										<td><?=$att['P_attCnt'][0]['present']?></td>
										<td><?=$att['A_attCnt'][0]['absent']?></td>
										<td><?=($att['P_attCnt'][0]['present'] + $att['A_attCnt'][0]['absent'])?></td>
										<td><?=$att['report_desc'] ?? 'N/A'?></td>
										<td><a class="viewatt" id="user_<?=$i?>" data-attdate="<?= $att['attendance_date']; ?>" data-projectId="<?=$project_details_id?>"  data-attslot="<?=$att['slot']?>" data-displaydate="<?=$attendance_date?>"   data-displayslot="<?=$slottime?>" data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button type="button" class="btn btn-primary btn-xs">View</button></a><?php 
											$b_name = "uploads/project_report/";
											$doc_url = base_url() . "Upload/download_s3file/" . $att['report'] . '?b_name=' . $b_name;
										?> |  <a href="<?=$doc_url?>" class="btn btn-primary btn-xs"> Report</a>
										
									</td>										
									</tr>
								<?php 
								
										$i++;
										}
									}else{
										echo "<tr><td colspan=7>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table>
							
						</div>
                    </div>
                </div>
			</div>
			<!--/form-->
			  
			<div class="col-sm-6">
				
				<div class="panel" id="att_details" style="display:none">
                    <div class="panel-heading">
                            <span class="panel-title">Attendance details: <span id="displaydate"></span> <span id="displayslot"></span></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">  
							<table class="table table-bordered" id="">
							<thead>
								<tr>
									<th>Roll No.</th>
									<th>PRN No.</th>
									<th>Student Name</th>
									<th>Mobile</th>
									<th>Status</th>
									<th>Remark</th>
								</tr>
							</thead>
							<tbody id="studAtt">
							</tbody>
							</table>
							
						</div>
                    </div>
                </div>
			</div>
			
		</div>
			
    </div>
</div>
<script>
$(document).ready(function () {

// Initialize Select2 for Faculty Dropdown
$("#faculty_code").select2({
	placeholder: "Select Faculty",
	allowClear: true
});

// Initialize variables from PHP
let faculty_code = <?= isset($faculty_code) ? json_encode($faculty_code) : 'null' ?>;
let academic_year = <?= json_encode($academic_year1) ?>;
let project_details_id = <?= isset($project_details_id) ? json_encode($project_details_id) : 'null' ?>;
let roles_id = <?= $this->session->userdata('role_id'); ?>;



if (roles_id !== 1 &&  roles_id !== 10  &&  roles_id !== 20 &&  roles_id !== 53) {
	
    faculty_code = <?= json_encode($this->session->userdata('name')); ?>;
    $('#faculty_code').prop('disabled', true);
    if (academic_year) {
        get_projects(faculty_code, academic_year, project_details_id);
    }
} else {
    if (academic_year) {
		
        get_faculties(academic_year, faculty_code);
    }
}

// Unified academic year change event
$(document).on("change", "#academic_year", function () {
    let academic_year = $(this).val();
    if (roles_id !== 1 &&  roles_id !== 10  &&  roles_id !== 20) {
        get_projects(faculty_code, academic_year);
    } else {
        get_faculties(academic_year);
    }
});

// Fetch projects on faculty change
$(document).on("change", "#faculty_code", function () {
	let faculty_code = $(this).val();
	let academic_year = $("#academic_year").val();
	get_projects(faculty_code, academic_year, project_details_id);
});

// Fetch attendance details on clicking .viewatt button
$(document).on("click", ".viewatt", function () {
	$('#att_details').css("display", "block");

	let att_date = $(this).attr("data-attdate");
	let project_details_id = $(this).attr("data-projectId");
	let slot = $(this).attr("data-attslot");
	let displaydate = $(this).attr("data-displaydate");
	let displayslot = $(this).attr("data-displayslot");
	let empId = $("#faculty_code").val();
	let academic_year = $("#academic_year").val();

	$('#displaydate').html(`<b>Date:</b> ${displaydate},`);
	$('#displayslot').html(`<b>Slot:</b> ${displayslot}`);

	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Project/fetchDateSlotwiseAttDetails',
		data: { att_date, slot, empId, project_details_id, academic_year },
		success: function (data) {
			if (data !== 'dupyes') {
				let absent = JSON.parse(data);
				let str = absent.ss.map(student => {
					let cls = student.is_present === 'N' ? "style='background-color: rgb(255, 123, 119);'" : "";
					let status_p = student.is_present === 'N' ? 'A' : 'P';
					let remark = student.remark ? student.remark : 'N/A';
					return `<tr ${cls}>
								<td>${student.roll_no}</td>
								<td>${student.enrollment_no}</td>
								<td>${student.first_name} ${student.middle_name ? student.middle_name + ' ' : ''}${student.last_name}</td>
								<td>${student.mobile}</td>
								<td>${status_p}</td>
								<td>${remark}</td>
							</tr>`;
				}).join('');

				$("#studAtt").html(str);
			} else {
				alert("No data found");
			}
		}
	});
});

// Function to fetch faculties
function get_faculties(academic_year, faculty_code = '') {

	$('#faculty_code').empty();
	$('#project_details_id').empty();

	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Project/fetch_project_faculty',
		data: { academic_year },
		success: function (data) {
			let faculties = JSON.parse(data);
			let html = '<option value="">Select Faculty</option>';

			if (faculties.length === 0) {
				html += '<option value="">No faculty found</option>';
			} else {
				faculties.forEach(faculty => {
					html += `<option value="${faculty.faculty_code}">${faculty.faculty_code} - ${faculty.fname} ${faculty.mname ? faculty.mname + ' ' : ''}${faculty.lname}</option>`;
				});
			}

			$('#faculty_code').html(html);

			// Re-select the faculty after options are populated
			if (faculty_code) {
				$('#faculty_code').val(faculty_code).trigger('change');
			}
		}
	});
}

// Function to fetch projects
function get_projects(faculty_code, academic_year, project_details_id = '') {
	
	if (!faculty_code || !academic_year) {
		$('#project_details_id').html('<option value="">Select Project</option>');
		return;
	}

	$.ajax({
		
		type: 'POST',
		url: '<?= base_url() ?>Project/fetch_facultyWise_projects',
		data: { faculty_code, academic_year },
		success: function (data) {
			//alert("ggss");
			let projects = JSON.parse(data);
			let html = '<option value="">Select Project</option>';

			if (projects.length === 0) {
				html += '<option value="">No project found</option>';
			} else {
				projects.forEach(project => {
					html += `<option value="${project.id}">${project.project_title}</option>`;
				});
			}

			$('#project_details_id').html(html);

			// Set selected project after updating the dropdown
			if (project_details_id) {
				$('#project_details_id').val(project_details_id).trigger('change');
			}
		}
	});
}
});


</script>
