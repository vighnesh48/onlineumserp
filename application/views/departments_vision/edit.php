<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>
    var base_url = '<?=base_url();?>';
$(document).ready(function(){

	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		var campus = 1;
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>departments_vision/load_courses',
				data: {school_code:school_code,campus_id:campus},
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
var school_code = '<?=$institutes_id?>';
var campus = 1;
//alert(school_code);
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>departments_vision/load_courses',
				data: {school_code:school_code,campus_id:campus},
				success: function (html) {
					//alert(html);
					var course_id = '<?=$institutes_id?>';
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
		var school_code = $("#school_code").val();
		var campus_id = 1;
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>departments_vision/load_streams',
				data: {course_id:admission_course,campus_id:campus_id,school_code:school_code},
				success: function (html) {
					//alert(html);
					$('#stream_id').html(html);
				}
			});
		} else {
			$('#stream_id').html('<option value="">Select course first</option>');
		}
	}); 
	
	// edit
var admission_course = '<?=$department_id?>';

		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>departments_vision/load_streams',
				data: {course_id:admission_course,campus_id:campus_id,school_code:school_code},
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
								<form method="post" action="<?= site_url('departments_vision/update/'.$vision->id) ?>">
									<label>Institute:</label>
									<select name="institutes_id" id="school_code" class="form-control" required>
									<option value="">Select</option>
									<?php foreach ($institutes as $inst): ?>
										<option value="<?= $inst->school_id ?>"><?= $inst->school_name ?></option>
									<?php endforeach; ?>
								</select><br>
									<label>Course<sup class="redasterik" style="color:red">*</sup></label>
									<select name="admission-course" id="admission-course" class="form-control" required>
									<option value="">Select</option>
									</select><br>
									
									<label>Stream<sup class="redasterik" style="color:red">*</sup></label>
									<select name="department_id" id="stream_id" class="form-control" required>
									<option value="">Select Stream</option>
									</select><br>
									
									<label>Vision:</label><br>
									<textarea name="vision" required><?= $vision->vision ?></textarea><br>

									<label>Mission:</label><br>
									<textarea name="mission" required><?= $vision->mission ?></textarea><br>

									<label>Admission Year:</label><br>
									<input type="text" name="admission_batch" value="<?=$vision->admission_batch ?>" required><br>

									<label>Status:</label>
									<select name="status" class="form-control">
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select><br><br>

									<button type="submit">Update</button>
								</form>
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
    CKEDITOR.replace('vision');
    CKEDITOR.replace('mission');
</script>
