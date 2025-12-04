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
        <li><a href="#">Assignment Question</a></li>
        <li class="active"><a href="#">Assignment Question</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Assignment Question</h1>
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
                          
    <h2>Add Assignment Question</h2>
    <?= form_open_multipart('assignment_question_bank/insert') ?>

<input type="hidden" name="campus_id" value="<?= $campus_id ?>" required>
<input type="hidden" name="subject_id" value="<?= $subject_id ?>" required>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Topic <?= $astrik ?></label>
            <select name="topic_id" id="topic_id" class="form-control select2" required>
                <option value="">Select Topic</option>
                <?php foreach ($topics as $t): ?>
                    <option value="<?= $t->topic_id ?>" <?= isset($plan) && $plan->topic_id == $t->topic_id ? 'selected' : '' ?>>
                        <?= $t->topic_order ?> <?= $t->topic_title ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Subtopic</label>
            <select name="subtopic_id" id="subtopic_id" class="form-control select2">
                <option value="">Select Subtopic</option>
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label>Question (Text) <?= $astrik ?></label>
    <textarea name="question_text" id="editor1" class="form-control"></textarea>
</div>

<div class="row">
    <div class="col-md-6">
        <label>Upload File (Optional)</label>
        <input type="file" name="question_file" class="form-control">
    </div>

    <div class="col-md-3">
        <label>Marks <?= $astrik ?></label>
        <input type="number" name="marks" maxlength="3" max="999" min="0" class="form-control" required>
    </div>

    <div class="col-md-3">
        <label>Source Exam</label>
        <input type="text" name="source_exam" class="form-control" required>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label>Course Outcome</label>
        <select name="course_outcome" class="form-control select2">
            <option value="">Select CO</option>
            <option value="CO1">CO1</option>
            <option value="CO2">CO2</option>
            <option value="CO3">CO3</option>
            <option value="CO4">CO4</option>
            <option value="CO5">CO5</option>
            <option value="CO6">CO6</option>
        </select>
    </div>

    <div class="col-md-6">
        <label>Bloom's Level</label>
        <select name="blooms_level_id" class="form-control select2" required>
            <option value="">Select Bloom's Level</option>
            <?php foreach ($blooms_levels as $bl): ?>
                <option value="<?= $bl->code ?>"><?= $bl->code ?> - <?= $bl->description ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<br>
<div class="text-center mt-4">
    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
</div>

<?= form_close() ?>


  




														<?php //} ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
  <script>
        CKEDITOR.replace('editor1');
    </script>
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