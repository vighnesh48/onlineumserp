
<style>
    
    .dataTables_scrollBody {
        border: 1px solid #ddd;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>    
    $(document).ready(function()
    {  
		
		$('.numbersOnly').keyup(function () {
			if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
			   this.value = this.value.replace(/[^0-9\.]/g, '');
			} 
		});
		//
		var course_id = $("#course_id").val();
		//alert(course_id);
		if (course_id) {
			$.ajax({
				'url' : base_url + 'Subject/load_streams',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course' : course_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semest'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?=$streamId ?>';
						container.html(data);
						$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
		
    });

</script>
<style>
.form-control{border-collapse:collapse !important;}
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';

?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Projects</a></li>
        <li class="active"><a href="#">Student Allocation</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Allocation</h1>
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
                          
							<!--<h4>Project: <?= $project_details['project_title'] ?? 'N/A'; ?></h4>-->
                    </div>

                    <div class="panel-body">
                        <div class="table-info">  
						
                            <form id="searchForm" name="form" action="<?=base_url($currentModule.'/allocate_students/')?>" method="POST">                                                               
                                <input type="hidden" name="project_id" value="<?= $encoded_project_id ?>" />
							<div class="form-group">
								<div class="col-sm-2" >
									<select name="academic_year" id="academic_year" class="form-control" required>
									<option value="">Select Academic Year</option>
									<?php
									$selected_year = $SAacademic_year ?? ACADEMIC_YEAR;
									
									
									foreach ($academic_year as $yr) {
									$sel = ($yr['academic_year'] == $selected_year) ? "selected" : "";
									if($selected_year==$yr['academic_year']){
									
									echo '<option value="' . $yr['academic_year'] . '" ' . $sel . '>' . $yr['academic_year'] . '</option>';
									}
									}
									?>
									</select>
                               
                              </div>
                              <div class="col-sm-2" >
										<select name="course_id" id="course_id" class="form-control" required>
										<option value="">Select Course</option>
										<?php
										$selected_course = $selected_course ?? '';
										foreach ($course_details as $course) {
										$sel1 = ($course['course_id'] == $selected_course) ? "selected" : "";
										echo '<option value="' . $course['course_id'] . '" ' . $sel1 . '>' . $course['course_short_name'] . '</option>';
										}
										?>
										</select>
                              </div>
                          
                              <div class="col-sm-2">
                                <select name="stream_id" id="stream_id" class="form-control" required="required">
                                  <option value="">Select Stream</option>      
                               </select>
                              </div>
							   <div class="col-sm-2">
									<select id="semester" name="semester" class="form-control" required>
                                            <option value="">Select Semester</option>	
											
											</select>
									</div>  
								<div class="col-sm-2 "> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
								<div class="col-sm-2 "> <a href="<?= base_url('project') ?>" class="btn btn-primary form-control">Back to List</a> </div>
								<!--<div class="col-sm-2 "> <a href="<?= base_url('project/timetable') ?>" class="btn btn-primary form-control">Project Timetable</a> </div>-->
                            </div>
							</form>
                        </div>
                    </div>
                </div>

            </div>    
        </div>
						<div style="color:green;font-weight: 900;">
						<?php
						if ($this->session->flashdata('Smessage') != ''): 
							echo $this->session->flashdata('Smessage'); 
						endif;
						?>
					</div>
					<!-- Error Message -->
					<div style="color:red;font-weight:900;">
					<?php if ($this->session->flashdata('message_project_error') != ''): ?>
					<?= $this->session->flashdata('message_project_error'); ?>
					<?php endif; ?>
					</div>
		  <div class="row ">
			<form id="form" name="form" action="<?=base_url($currentModule.'/assign_projectToStudent')?>" method="POST">    
            <div class="col-sm-6">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname">Student List</span>
                    </div>
                    <div class="panel-body" style="overflow:scroll;height:700px;">
                        <div class="table-info">  
							<table class="table table-bordered" id="studentTable">
							<thead>
								<tr>
									<th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th>
									<th>S.No.</th>
									<th>PRN</th>
									<th>Student Name</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								if(!empty($allcated_studlist)){
										foreach($allcated_studlist as $student){
											$stud_app_id[]= $student['stud_id']; 
										}
								}
								
											$m = 1;
											if (!empty($studlist)) {
											foreach ($studlist as $stud) {
											$is_assigned = in_array($stud['stud_id'], $stud_app_id ?? []);
											$applied = $is_assigned ? "style='background-color:#bfd4ac;'" : "";
											$disabled = $is_assigned ? "disabled" : "";
											?>
											<tr <?= $applied ?>>
											<td>
											<input type="checkbox"
											name="chk_stud[]"
											class="studCheckBox"
											value="<?= $stud['stud_id'] ?>"
											<?= $disabled ?>>
											</td>
											<td><?= $m ?></td>
											<td>
											<?= $stud['enrollment_no'] ?>
											<?php if ($stud['transefercase'] == 'Y'): ?>
											<img src="https://erp.sandipuniversity.com/uploads/Transfer-PNG.png" style="width:15px; height:15px">
											<?php endif; ?>
											</td>
											<td><?= $stud['first_name'] . " " . $stud['middle_name'] . " " . $stud['last_name'] ?></td>
											</tr>
											<?php
											$m++;
											}
											} else {
											echo "<tr>Student registrations are not done.</tr>";
											}
											?>
								</tbody>
							</table>
							
						</div>
                    </div>
                </div>
			</div>
			<div class="col-sm-6">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Projects: </span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">

							<div class="row" style="margin-bottom:10px;">
							<div class="col-sm-8">
							<input id="projectSearch" type="text" class="form-control" placeholder="Search projects (title, domain,faculty )">
							</div>
							<div class="col-sm-4 text-right hidden" style="padding-top:6px;">
							<small>
							<span id="projCountVisible">0</span>/<span id="projCountTotal">0</span> visible
							&nbsp;|&nbsp;
							<label style="font-weight:normal;">
							<input type="checkbox" id="hideFullProjects"> Hide full projects
							</label>
							</small>
							</div>
							</div>
						
							<table class="table table-bordered">
							<thead>
								<tr>
									<th><!--input type="checkbox" name="chk_sub_all" id="chk_sub_all"--></th>
									<th>Project Title</th>
									
								</tr>
							</thead>
							<tbody>
							
							
                            <input type="hidden" name="acad_year" value="<?= $SAacademic_year ?>">
							  <input type="hidden" name="course_id" value="<?= $selected_course ?>">
                               <input type="hidden" name="stream_id" value="<?= $selected_stream ?>">
							    <input type="hidden" name="semester" value="<?= $selected_semester ?>">
							<?php
							$MAX = 5;
							$assigned_project_ids = $assigned_project_ids ?? [];
							if (!empty($projects)) {
							foreach ($projects as $p) {
							$is_assigned = in_array($p['id'], $assigned_project_ids);
							 $count     = (int)($assigned_counts[$p['id']] ?? 0);
                             $remaining = max(0, $MAX - $count);
                             $is_full   = ($remaining === 0);
							?>
							<tr data-search="<?=
  htmlspecialchars(
    strtolower(trim(($p['project_title'] ?? '').' '.($p['domain'] ?? '').' '.($p['faculty_id'] ?? ''))),
    ENT_QUOTES
  )
?>" data-is-full="<?= $is_full ? '1' : '0' ?>">
								<td>
								<input type="radio"
								name="chk_sub"
								class="subRadio"
								value="<?= $p['id'] ?>"
								data-remaining="<?= $remaining ?>"
								<?= $is_full ? 'disabled' : '' ?>>
								<input type="hidden" name="faculty_id_map[<?= $p['id'] ?>]" value="<?= $p['faculty_id'] ?>">
								</td>
								<td>
								<?= $p['project_title'] ?> - <?= $p['domain'] ?>
								<span style="margin-left:8px;">
								(<?= $count ?>/<?= $MAX ?> filled, <?= $remaining ?> left)
								</span>
								<?php if ($is_full): ?>
								<span class="proj-full-flag" style="color:red;margin-left:6px;">(Full)</span>
								<?php endif; ?>
								</td>
							</tr>
							<?php 
							}
							} else {
							echo "<tr><td colspan=2>Project are not found.</td></tr>";
							}
							?>
								</tbody>
							</table>
							<?php if(!empty($projects)){?>
							<div class="col-sm-4"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" onclick="return validate_student()">Assign Project</button> </div>
							<?php }?>
						</div>
                    </div>
                </div>
			</div>
			</form>
		</div>
			
    </div>
</div>
<script>


$(document).ready(function () {
	const TRIGGER_SEARCH = <?php echo !empty($trigger_search) ? 'true' : 'false'; ?>;
  let submittedOnce = false;
	 function loadStreams(courseId, academicYear) {
    return $.ajax({
      type: 'POST',
      url: '<?= base_url() ?>subject_allocation/load_streams',
      data: { course_id: courseId, academic_year: academicYear }
    }).done(function (html) {
      $('#stream_id').html(html);
    });
  }

  function loadSemesters(courseId, streamId, academicYear) {
    return $.ajax({
      type: 'POST',
      url: base_url + 'subject_allocation/load_semester',
      data: { course_id: courseId, stream_id: streamId, academic_year: academicYear }
    }).done(function (html) {
      $('#semester').html(html);

      // Preselect semester if provided from backend
      var presetSem = '<?= $selected_semester ?? $semesterNo ?? '' ?>';
      if (presetSem) {
        $('#semester').val(presetSem);
      }

      // Submit once only after semesters are available
      if (TRIGGER_SEARCH && !submittedOnce && $('#semester option').length > 1) {
        submittedOnce = true;
        $('#searchForm').trigger('submit');
      }
    });
  }
	
	
	var selectedStreamId = '<?= $selected_stream ?? '' ?>';
    var selectedCourseId = '<?= $selected_course ?? '' ?>';

    var selectedYear = '<?= $SAacademic_year ?? ACADEMIC_YEAR ?>';
	 var selectedSemester = '<?= $selected_semester ?? '' ?>';

    if (selectedCourseId) {
         loadStreams(selectedCourseId, selectedYear).then(function () {
      if (selectedStreamId) {
        $('#stream_id').val(selectedStreamId).trigger('change');
		
      }
		 });
	}

	//
	
	
	// fetch stream form course
	var stream_id = $("#semester").val();
	if(stream_id !=''){
		$("#sem_id").val(stream_id);
	}

		 $('#course_id').on('change', function () {
    var cid = this.value, ay = $('#academic_year').val();
    if (!cid) {
      $('#stream_id').html('<option value="">Select course first</option>');
      $('#semester').html('<option value="">Select Semester</option>');
      return;
    }
    loadStreams(cid, ay).then(function () {
      $('#stream_id').val('').trigger('change'); // clears semester via handler
      $('#semester').html('<option value="">Select Semester</option>');
      submittedOnce = false; // allow auto-submit again for the new selection
    });
  });

  // Stream change -> fetch semesters
  $('#stream_id').on('change', function () {
    var sid = this.value, cid = $('#course_id').val(), ay = $('#academic_year').val();
    if (!sid) {
      $('#semester').html('<option value="">Select Semester</option>');
      return;
    }
    loadSemesters(cid, sid, ay);
  });	
	
	
		var course_id = '<?=$courseId?>';
        var stream_id = '<?=$streamId?>';
		var academic_year = $("#academic_year").val();
		
		if (stream_id) {
			$.ajax({
				'url' : base_url + 'subject_allocation/load_semester',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'academic_year' : academic_year,stream_id:stream_id,course_id:course_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semester'); //jquery selector (get element by id)
					if(data){	
						var semester = '<?=$semesterNo?>';
						container.html(data);
						$("#semester option[value='" + semester + "']").attr("selected", "selected");
					}
				}
			});
		}
	
	
		//alert(stream_id);
		var academic_year = '<?=$SAacademic_year?>';
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>subject_allocation/load_streams',
					data: {course_id:course_id,academic_year:academic_year},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#stream_id'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?=$streamId?>';
						container.html(data);
						$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
  });
 
function validate_student() {
    var selectedProject = $('input.subRadio:checked');
    if (selectedProject.length === 0) {
        alert('Please select one project');
        return false;
    }
    var remaining = parseInt(selectedProject.data('remaining') || 0, 10);
    var selectedStudents = $('input.studCheckBox:checked').length;

    if (selectedStudents === 0) {
        alert('Please select at least one student from the student list');
        return false;
    }
    if (selectedStudents > remaining) {
        alert('You selected ' + selectedStudents + ' students but only ' + remaining + ' slot(s) are left for this project.');
        return false;
    }
    return true;
}
	</script>
	<script>
	$(document).ready(function () { $('#studentTable').DataTable({
        "paging": false,         // ❌ No pagination
        "searching": true,       // ✅ Enable search
        "info": false,           // ❌ Hide "Showing 1 to X of Y"
        "ordering": false,       // ❌ Disable sorting (optional)
        "scrollY": "600px",      // ✅ Optional: vertical scroll
        "scrollCollapse": true
    });
	$('#chk_stud_all').change(function () {
        $('.studCheckBox:enabled').prop('checked', $(this).prop('checked'));
    });
	});
</script>

<script>
(function() {
  function normalize(s) {
    return (s || '').toString().toLowerCase().trim();
  }

  function applyProjectFilter() {
    var q = normalize($('#projectSearch').val());
    var hideFull = $('#hideFullProjects').is(':checked');
    var total = 0, visible = 0;

    // Only rows inside the Projects table body
    var $rows = $('table.table.table-bordered')
      .has('input.subRadio') // ensure it's the projects table
      .find('tbody > tr');

    $rows.each(function() {
      total++;
      var $tr = $(this);
      var hay = $tr.data('search') || '';
      var isFull = ($tr.data('is-full') === 1 || $tr.data('is-full') === '1');
      var match = !q || hay.indexOf(q) !== -1;
      var passFull = !hideFull || !isFull;

      if (match && passFull) {
        $tr.show();
        visible++;
      } else {
        $tr.hide();
      }
    });

    $('#projCountTotal').text(total);
    $('#projCountVisible').text(visible);

    // If selected radio is now hidden (filtered out), clear it to avoid confusion
    var $sel = $('input.subRadio:checked');
    if ($sel.length && !$sel.closest('tr').is(':visible')) {
      $sel.prop('checked', false);
    }
  }

  $(document).ready(function() {
    // Initialize counts once DOM is ready
    applyProjectFilter();

    // Wire events
    $('#projectSearch').on('input', applyProjectFilter);
    $('#hideFullProjects').on('change', applyProjectFilter);
  });
})();
</script>
