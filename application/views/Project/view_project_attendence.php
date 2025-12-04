<?php  $emp_id= $this->session->userdata('name');?>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style type="text/css">.loader {
  border: 6px;
  border-radius: 50%;
  border-top: 6px solid pink;
  border-bottom: 6px solid pink;
  width: 90px;
  height: 90px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  margin-left:50%;
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<script> 

    $(document).ready(function()
    {
    	
    	//alert(academic_year);
        $('#form').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: 
            {
                stream_id:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'stream should not be empty'
                      }
                    }

                },
				semester:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'semester should not be empty'
                      }
                    }

                },
            }       
        })
		
		// Num check logic
		$('.numbersOnly').keyup(function () {
			if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
			   this.value = this.value.replace(/[^0-9\.]/g, '');
			} 
		});
		//
		let course_id = $("#room_no").val();
		let academic_year = '<?=$academic_year?>';
		///alert(academic_year);
		if (course_id) {
			$.ajax({
				'url' : base_url + 'Attendance/load_sem',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : course_id,academic_year:academic_year},
				'success' : function(data){ //probably this request will return anything, it'll be put in let "data"
					let container = $('#semester'); //jquery selector (get element by id)
					if(data){
						let stream_id = '<?=$semesterNo ?>';
						container.html(data);
						$("#semester option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
		<?php if($emp_id !='110383'){?>
		//alert('1');,startDate: '-0d'
		$('#dt-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
		<?php }else{ ?>
		//alert('2');
		$('#dt-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true,startDate: '-0d'});//startDate: '-0d',
		<?php } ?>
    });

</script>
<style>
.absent_bg{background:#ff9b9b;}
</style>
<?php
$role_id=$this->session->userdata('role_id');
echo $this->session->userdata('emp_id');
//print_r($sb);
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<?php
// Set the timezone to India (IST)
date_default_timezone_set("Asia/Kolkata");
// Get the current time
echo $currentTime = date("H:i");//exit;

// Define the cutoff time
$cutoffTime = "23:00";

// Check if the current time is past 6:30 PM
$isDisabled = ($currentTime > $cutoffTime);


if (isset($is_today_applicable) && (int)$is_today_applicable === 0) {
    $isDisabled = true;
}

?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Project</a></li>
        <li class="active"><a href="#">Attendance</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Mark Attendance</h1>
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
							
                             <form id="form" name="form" action="<?=base_url($currentModule.'/search_project_students')?>" method="POST">                                                               
                        
                                <input type="hidden" value="<?=isset($academic_year) ? $academic_year : ACADEMIC_YEAR?>" id="academic_year" name="academic_year" />
								<div class="form-group">
								
								<?php
								$emp_id= $this->session->userdata('name');
								
								if($_REQUEST['today_date'] !=''){
			
									$att_date = $_REQUEST['today_date'];
									$input_id='dt-datepicker111';
								}else{
									$att_date = date('Y-m-d');
									$input_id='dt-datepicker111';//dt-datepicker111
								}
								
								?>
								<label class="col-sm-1">Date:</label>
								 <div class="col-sm-2"><input type="text" class="form-control" name="today_date" id="<?=$input_id?>" value="<?php echo $att_date;?>" style="width:150px;"  readonly="true" required></div>	
								 <?php if($this->session->userdata('role_id') == 1){?>
								 <div class="col-sm-2">

									<select id="faculty_code" name="faculty_code" class="form-control"  required>
										<option value="">Select Faculty</option>
										<?php
										foreach ($faculties as $faculty) {
											echo '<option value="'.$faculty['faculty_code'].'" '.($faculty_code == $faculty['faculty_code'] ? 'selected' : '').' >'.$faculty['faculty_code'].' - '.$faculty['fname'].' '.$faculty['mname'].' '.$faculty['lname'].'</option>';
										}	
										?>								
									</select>											
								</div>	
								<?php } ?>					
								<div class="col-sm-2">
									<select id="project_id" name="project_id" class="form-control"  required>
										<option value="">Select Project</option>									
									</select>											
								</div> 
								<div class="col-sm-2" >
                                <select name="slot_no" id="slot_no" class="form-control" required>
                                  <option value="">Select Slot</option>  
								  
								  <?php
								$slot_no = $this->input->post('slot_no') ?? ($_REQUEST['slot_no'] ?? '');

if (!empty($today_slots)) {
    foreach ($today_slots as $s) {
        $value = (string)$s['proj_slot_id'];
        // If your $today_slots has 'label', use it; else fallback to from-to
        $label = isset($s['label'])
            ? $s['label']
            : ((isset($s['from_time'], $s['to_time'])) ? ($s['from_time'].' - '.$s['to_time']) : $value);

        $selected = ((string)$slot_no === $value) ? 'selected' : '';

        echo '<option value="'.htmlspecialchars($value, ENT_QUOTES).'" '.$selected.'>'
           .  htmlspecialchars($label, ENT_QUOTES)
           .  '</option>';
    }
} else {
    echo '<option value="">No slot today</option>';
}
								  ?>
                               </select>
                              </div>
								<div class="col-sm-2"><?php if ($isDisabled){ ?>
        						<p style="color: red;">The button is disabled after 6:00 PM OR Slot not available today.</p>
								<?php }else{ ?><button class="btn btn-primary form-control" id="btn_submit" type="submit">Search</button><?php }?></div>
                            </div>
							</form>
                    </div>
                    
                </div>

            </div>    
        </div>
		  <div class="row ">
 
            <div class="col-sm-9">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname">Student List : 
						
							</span>
                    </div>
                    <div class="panel-body">
						<!--div class="col-sm-3">
						Date :</div> <div class="col-sm-3"><input type="text" class="form-control" name="today_date" id="dt-datepicker" value="<?=date('Y-m-d');?>" style="width:150px;" readonly="true"></div><br><br><br-->
                        <div class="table-info">  
							<div class=""> 
								<input type="hidden" name="slot" id="slot" value="<?=$slot_no?>">

							</div>
							<table class="table table-bordered">
							<thead>
								<tr>
									<th><input type="checkbox" name="chk_attstud_all" id="chk_attstud_all" checked="checked"></th>
									<th>PRN No.</th>
									<th>Student Name</th>
									<th>Project Title</th>
									<th>Remark</th>
									
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
							
								//print_r($stud_app_id);
								$i=1;
									if(!empty($project_students)){
										foreach($project_students as $stud){
											
											//exit;
								?>
									<tr id="chk<?=$stud['stud_id']?>">
                                       <?php
										$chk='';$class="";
										// if(!empty($stud['UserId'])){
										// $chk= 'checked="checked"'; 
										
										// }
										// else{
										// 	$class="hidden";
										// }
										
										?>
									
									
									
										<td><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox <?=$class;?> chk_stud<?=$stud['stud_id']?>'
										
										<?=$chk;?>
										
										
										value="<?= $stud['stud_id'] ?>" onclick="changeBackground('<?=$stud['stud_id']?>')"></td>
					
										<td><?=$stud['enrollment_no']?></td>
										<td><?php echo $stud['first_name']." ".$stud['middle_name']." ".$stud['last_name'];?></td>
										<td id="project_id<?=$stud['stud_id']?>" class="<?= $stud['project_details_id'] ?>" ><?=$stud['project_title']?></td>
										<td><input type="text" name="remark[]" placeholder="Remark" id="remark<?=$stud['stud_id']?>" class="form-control" required /></td>
										
									</tr>
								<?php 
								//}
										$i++;
										}
									}else{
										echo "<tr><td colspan=4>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table>
							<?php if(!empty($project_students)){?>
							<div class="col-sm-2">
								<label class="text-bold text-primary" >Upload Progress Report: <?= $astrik;?></label> <br> <br>
								<label class="text-bold text-primary" >Report Description: </label>
							</div>
							<div class="col-sm-4">
								<input type="file" name="report" id="report" accept=".pdf, .jpg, .png, .jpeg, .doc, .docx" > <br>
								<textarea name="report_desc" id="report_desc" class="form-control" placeholder="Report Description" ></textarea></div>
							<div class="col-sm-4"></div>
							<div class="col-sm-2">
								<button class="btn btn-primary form-control" id="btn_markAtt" type="button">Mark Attendance</button> </div>
							<?php }?>
							<div id="wait" style="display:none;"><div class="loader"></div><br>Loading..</div>
						</div>
                    </div>
                </div>
			</div>
			
			  
		
			
		</div>
			
    </div>
</div>
<script>
	// let academic_year = '<?=$academic_year?>';
$(document).ready(function () {
	
	$('#faculty_code').select2();

	$('#chk_stud_all').change(function () {
        $('.studCheckBox').prop('checked', $(this).prop('checked'));
		
    });
	$('#chk_attstud_all').change(function () {
        $('.studCheckBox').prop('checked', $(this).prop('checked'));
		
    });
	//
	$('#chk_sub_all').change(function () {
        $('.subCheckBox').prop('checked', $(this).prop('checked'));
    });
	//mark attendance
	$('#btn_markAtt').on('click', function () {
	    let today_date = $("input[name='today_date']").val();
	    if (today_date == '') {
	        alert('Please select attendance date');
	        return false;
	    }

	    let faculty_code = $("#faculty_code").length ? $("#faculty_code").val() : "<?= $_SESSION['name'] ?>";
	    let slot = $("#slot").val();
		let project_details = $("#project_id").val();
		let report_desc = $("#report_desc").val();
	    let report = $('#report')[0].files[0];

	    let checkedData = [];
	    let uncheckedData = [];
	    let missingRemarks = false;

	    $("input[name='chk_stud[]']").each(function () {
	        let checkboxValue = $(this).val();
	        let remarkValue = $("#remark" + checkboxValue).val();
	        let project_id = $("#project_id" + checkboxValue).attr("class");

	        // ✅ Check if remark is empty
	        if ( $(this).is(":not(:checked)") && (!remarkValue || remarkValue.trim() === '') ) {
	            missingRemarks = true;
	        }

	        let data = {
	            stud_id: checkboxValue,
	            remark: remarkValue,
	            project_details_id: project_id
	        };

	        if ($(this).is(":checked")) {
	            checkedData.push(data);
	        } else {
	            uncheckedData.push(data);
	        }
	    });

	    // ✅ Validation: Ensure all remarks are filled
	    if (missingRemarks) {
	        alert("Please enter remarks for Absent students.");
	        return false;
	    }

	    // ✅ Validation: Ensure a report file is uploaded
	    if (!report) {
	        alert("Please upload a report file.");
	        return false;
	    }

    	// ✅ Validation: Allow only specific file types
    	let allowedExtensions = /(\.pdf|\.jpg|\.jpeg|\.png|\.doc|\.docx)$/i;
    	if (!allowedExtensions.exec(report.name)) {
    	    alert("Invalid file type. Allowed types: PDF, JPG, PNG, JPEG, DOC, DOCX.");
    	    return false;
		}
    

	    // ✅ Use FormData for file uploads
	    let formData = new FormData();
	    formData.append('faculty_code', faculty_code);
	    formData.append('today_date', today_date);
	    formData.append('slot', slot);
	    formData.append('academic_year', academic_year);
	    formData.append('report_desc', report_desc);
        formData.append('project_id', project_details);
	    // Append JSON data as a string
	    formData.append('chk_stud', JSON.stringify(checkedData));
	    formData.append('chk_unstud', JSON.stringify(uncheckedData));
	    formData.append('report', report);

	    $("#wait").css("display", "block");

	    $.ajax({
	        type: 'POST',
	        url: '<?= base_url() ?>Project/markAttendance',
	        data: formData,
	        processData: false,  // Required for FormData
	        contentType: false,  // Required for FormData
	        success: function (data) {
	            $("#wait").css("display", "none");

	            if (data != 'dupyes') {
	                alert("Attendance marked successfully.");
	                window.location.href = '<?= base_url() ?>Project/view_project_attendence';
	            } else {
	                alert("You have already taken this batch attendance.");
	            }
	        }
	    });
	});


	
	
	});	

    let roles_id = parseInt(<?= json_encode($this->session->userdata('role_id')) ?>);
    let project_id = <?= isset($project_id) ? json_encode($project_id) : 'null' ?>;
    let faculty_code = '<?= $this->session->userdata('name'); ?>'; 
    let academic_year = $('#academic_year').val();

    if (roles_id !== 1) {
        // If the role is NOT admin, use session faculty code and load projects
        if (project_id) {
            get_projects(faculty_code, academic_year, project_id);
        } else {
            get_projects(faculty_code, academic_year);
        }
    } else {

		let selected_faculty = <?= isset($faculty_code) ? json_encode($faculty_code) : 'null' ?>;

        // If the user is admin, allow selecting faculty manually
        if (project_id) {
            get_projects(selected_faculty, academic_year, project_id);
        }

        $('#faculty_code').on('change', function () {
            let selected_faculty = $(this).val();
            let academic_year = $('#academic_year').val();
            get_projects(selected_faculty, academic_year);
        });
    }
	
		
	//Send SMS to Parents 
	
function get_count_selected(strm){

	let chk_checked_length = $('input[class=subCheckBox]:checked').length;
	//alert(chk_checked_length);
	let tot_subjects ="<?=$strmsub[0]['total_subject']?>";
	//alert(tot_subjects);
	if(chk_checked_length == tot_subjects){
		//alert("inside");
		 $('input[class=subCheckBox]:not(:checked)').attr('disabled', 'disabled');
	}else{
		//alert("outside");
		$('input[class=subCheckBox]').removeAttr('disabled');
	}
}  
function validate_student(strm){

	let chk_stud_checked_length = $('input[class=studCheckBox]:checked').length;
	if(chk_stud_checked_length == 0){
		 alert('please check atleast one Student from student table');
		 return false;
	}else{
		return true;
	}
} 
function validate_removeStudent(strm){

	let stud_checked_length = $('input[class=CheckBox]:checked').length;
	if(stud_checked_length == 0){
		 alert('please check atleast one Student to remove from batch');
		 return false;
	}else{
		return true;
	}
}
function changeBackground(id){
	let trvalue = 'chk'+id;
	if($(".chk_stud"+id).prop("checked") == true){
		$("#"+trvalue).css({"background-color":"#FFF"});
	}
	else if($(".chk_stud"+id).prop("checked") == false){
		$("#"+trvalue).css({"background-color":"#FF7B77"});
	}
}

function get_projects(faculty_code, academic_year, project_id = '') {
    if (!faculty_code || !academic_year) {
        $('#project_id').html('<option value="">Select Project</option>');
        return;
    }

    $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>Project/fetch_facultyWise_projects',
        data: { faculty_code, academic_year },
        success: function (data) {
            let projects = JSON.parse(data);
            let html = '<option value="">Select Project</option>';

            if (projects.length === 0) {
                html += '<option value="">No project found</option>';
            } else {
                projects.forEach(project => {
                    let selected = (project.id.toString() === project_id.toString()) ? 'selected' : '';
                    html += `<option value="${project.id}" ${selected}>${project.project_title}</option>`;
                });
            }

            $('#project_id').html(html);

            // Ensure selected project remains selected after options are populated
            if (project_id) {
                $('#project_id').val(project_id).trigger('change');
            }
        }
    });
}


</script>
