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
                           <form method="post" action="<?= site_url('institutes_vision/store') ?>">
								<label>Institute:</label>
								<select name="institutes_id" class="form-control" required>
									<option value="">Select</option>
									<?php foreach ($institutes as $inst): ?>
										<option value="<?= $inst->school_id ?>"><?= $inst->school_name ?></option>
									<?php endforeach; ?>
								</select><br>

								<label>Vision:</label><br>
								<textarea name="vision" class="form-control " required></textarea><br>

								<label>Mission:</label><br>
								<textarea name="mission" class="form-control" required></textarea><br>

								<label>Academic Year:</label><br>
								<input type="text" name="academic_year" class="form-control" value='2025' required><br>

								<label>Status:</label>
								<select name="status" class="form-control">
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select><br><br>

								<button type="submit">Save</button>
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