<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Add Institute Vision</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Institute Vision</h1>
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
                            <span class="panel-title">Vision Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <?php //if(in_array("Add", $my_privileges)) { ?>
                           <form method="post" action="<?= site_url('lecture_plan/store') ?>">
							   <?php if (isset($plan)): ?>
								  <input type="hidden" name="plan_id" value="<?= $plan->plan_id ?>">
								  
								<?php endif; ?>
								<?php if (validation_errors()): ?>
								  <div class="alert alert-danger">
									<?= validation_errors(); ?>
								  </div>
								<?php endif; ?>
								<input type="hidden" name="subdetails" value="<?=$subdetails ?>">	
								<input type="hidden" name="faculty_id" value="<?= $faculty_id ?>">
								  <input type="hidden" name="subject_id" value="<?= $subject_id ?>">
								  <input type="hidden" name="campus_id" value="<?= $campus_id ?>">

								  <!-- Faculty Name (readonly) -->
								  <label>Faculty Name:</label>
								  <input type="text" class="form-control" value="<?= $faculty_name ?>" readonly><br>

								  <!-- Subject Name (readonly) -->
								  <label>Subject Name:</label>
								  <input type="text" class="form-control" value="<?= $subject_name ?>" readonly><br>

								  <!-- Topic Dropdown -->
																	
									<label>Topic:</label>
									<select name="topic_id" id="topic_id" class="form-control" required>
									  <option value="">Select Topic</option>
									  <?php foreach($topics as $t): ?>
										<option value="<?= $t->topic_id ?>" <?= isset($plan) && $plan->topic_id == $t->topic_id ? 'selected' : '' ?>>
										  <?= $t->topic_order ?> <?= $t->topic_title ?>
										</option>
									  <?php endforeach; ?>
									</select><br>

									<!-- Subtopic Dropdown -->
									<label>Subtopic:</label>
									<select name="subtopic_id" id="subtopic_id" class="form-control">
									  <option value="">Select Subtopic</option>
									</select><br>


								  <!-- Date and Duration -->
								  <label>Planned Date:</label>
								  <input type="date" name="planned_date" class="form-control" required value="<?= isset($plan) ? $plan->planned_date : '' ?>"><br>

								  <label>Planned Duration (Hrs / Min):</label><br>
								  <input type="number" name="planned_duration_hours" value="<?= isset($plan) ? $plan->planned_duration_hours : '1' ?>" required>
								  <input type="number" name="planned_duration_minutes" value="<?= isset($plan) ? $plan->planned_duration_minutes : '0' ?>" required><br><br>

								  <!-- Lecture Mode -->
								  <label>Lecture Mode:</label>
								  <select name="lecture_mode" class="form-control">
									<?php foreach (['Offline', 'Online', 'Hybrid'] as $mode): ?>
									  <option value="<?= $mode ?>" <?= isset($plan) && $plan->lecture_mode == $mode ? 'selected' : '' ?>><?= $mode ?></option>
									<?php endforeach; ?>
								  </select><br>

								  <!-- Course Outcome -->
								  <label>Course Outcome:</label>
									<select name="course_outcome" class="form-control" required>
									  <option value="">Select Course Outcome</option>
									  <?php
										for ($i = 1; $i <= 6; $i++):
										  $co = 'CO' . $i;
										  $selected = (isset($plan) && $plan->course_outcome == $co) ? 'selected' : '';
									  ?>
										<option value="<?= $co ?>" <?= $selected ?>><?= $co ?></option>
									  <?php endfor; ?>
									</select><br>

								  <!-- Learning Outcome -->
								  <!--label>Learning Outcome:</label>
								  <textarea name="learning_outcome" class="form-control"><?= isset($plan) ? $plan->learning_outcome : '' ?></textarea><br-->

								  <!-- Teaching Methodology -->
								  <label>Pedagogical Tool/ICT Tools/Learning Methodology :</label>
								  <textarea name="teaching_methodology" class="form-control"><?= isset($plan) ? $plan->teaching_methodology : '' ?></textarea><br>

								  <!-- Remarks -->
								  <label>Remarks:</label>
								  <textarea name="remarks" class="form-control"><?= isset($plan) ? $plan->remarks : '' ?></textarea><br>

								  <!-- Status -->
								  <label>Status:</label>
								  <select name="status" class="form-control">
									<option value="1" <?= !isset($plan) || $plan->status == 1 ? 'selected' : '' ?>>Active</option>
									<option value="0" <?= isset($plan) && $plan->status == 0 ? 'selected' : '' ?>>Inactive</option>
								  </select><br>

								  <button type="submit" class="btn btn-primary"><?= isset($plan) ? 'Update' : 'Save' ?></button>
														<?php //} ?>
								</form>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>

<script>
  function loadSubtopics(topic_id, selected = null) {
    if (topic_id) {
      $.ajax({
        url: "<?= site_url('lecture_plan/get_subtopics_ajax/') ?>/" + topic_id,
        type: "GET",
        success: function(response) {
          const data = JSON.parse(response);
          let options = '<option value="">Select Subtopic</option>';
			data.forEach(function(item) {
			  const sel = selected == item.subtopic_id ? 'selected' : '';
			  options += `<option value="${item.subtopic_id}" ${sel}>${item.srno} ${item.subtopic_title}</option>`;
			});

          $('#subtopic_id').html(options);
        }
      });
    } else {
      $('#subtopic_id').html('<option value="">Select Subtopic</option>');
    }
  }

  $(document).ready(function() {
    $('#topic_id').on('change', function() {
      const topicId = $(this).val();
	  //alert(topicId);
      loadSubtopics(topicId);
    });

    // If editing, load subtopics initially
    <?php if (isset($plan) && $plan->topic_id): ?>
      loadSubtopics("<?= $plan->topic_id ?>", "<?= $plan->subtopic_id ?>");
    <?php endif; ?>
  });
</script>
