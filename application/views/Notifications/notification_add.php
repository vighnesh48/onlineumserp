					<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url('assets/javascripts/bootstrap-datepicker.js')?>"></script>
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<style>
    /* ✅ Form Styling */
	.panel {
		border-radius: 12px !important;
		box-shadow: 0 3px 10px rgb(26 134 249 / 82%) !important;
		border: none !important;
	}

	.panel-heading {
		background: linear-gradient(90deg, #004aad, #0078d7) !important;
		color: white !important;
		font-weight: 600 !important;
		font-size: 16px !important;
		border-radius: 12px 12px 0 0 !important;
		padding: 12px 20px !important;
	}

	.panel-title i {
		margin-right: 8px !important;
	}

	.panel-body {
		background: #027cff17 !important; /* Added # for valid hex */
	}

    label {
        font-weight: 600;
        margin-top: 5px;
    }
    .form-control {
        border-radius: 6px;
        box-shadow: none;
        border: 1px solid #ccc;
        transition: all 0.2s ease;
    }
    .form-control:focus {
        border-color: #0078d7;
        box-shadow: 0 0 0 0.15rem rgba(0, 120, 215, 0.25);
    }
    .btn-primary {
        background: #0078d7 !important;
        border-color: #0078d7 !important;
        border-radius: 6px !important;
        transition: all 0.2s ease !important;
        font-weight: 600 !important;
    }
    .btn-primary:hover {
        background: #005fa3 !important;
        border-color: #005fa3 !important;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .redasterik {
        color: red;
    }
	.section-divider {
		border: 0;
		height: 2px;
		background: linear-gradient(to right, #ccc, #007bff, #ccc);
		margin: 15px 0;
		border-radius: 2px;
	}

	.section-title {
		font-weight: 600;
		color: #007bff;
		margin-bottom: 10px;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}

	.form-horizontal .form-group {
		margin-bottom: 15px;
	}

	.btn-primary {
		background-color: #007bff !important;
		border-color: #007bff !important;
	}

	.btn-secondary {
		background-color: #aeb3b7 !important;
		border-color: #6c757d !important;
	}
</style>
<?php $astrik = '<sup class="redasterik">*</sup>'; ?>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <li><a href="#">Masters</a></li>
        <li class="active">Add Notification</li>
    </ul>

    <div class="page-header">
        <h1><i class="fa fa-user-graduate"></i> Add Notification</h1>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <i class="fa fa-id-card"></i> Notification 
			</div>

        <div class="panel-body">
            <form id="form" name="form" action="<?=base_url($currentModule.'/save_notification')?>" method="POST" enctype="multipart/form-data" class="form-horizontal">

              	<input type="hidden" name="notification_id" value="<?= isset($notification->id) ? $notification->id : '' ?>">

                <!-- Batch Type -->
				<div class="row col-md-12">
					<h4 class="section-title text-center">Notification Details</h4>
					<hr class="section-divider">
					<!-- External Faculty Details -->
					<div class="form-group col-md-6">
						<label class="col-sm-3 control-label">Notification Subject <?=$astrik?></label>
						<div class="col-sm-6"><input type="text" name="subject" class="form-control"
										   value="<?= isset($notification->subject) ? $notification->subject : '' ?>" required></div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="col-sm-3 control-label">Applicable Course</label>
						<div class="col-sm-6">
							<select name="applicable_course" id="applicable_course" class="form-control" >
										<option value="">Select Course</option>
									<?php	foreach ($stream_details as $stream) { ?>
									<option value="<?=$stream['stream_id']?>"  <?= (isset($notification) && $notification->applicable_course == $stream['stream_id']) ? 'selected' : '' ?>><?=$stream['stream_name']?></option>
									
									<?php } ?>
									</select>
						</div>
					</div>
					

					<div class="form-group col-md-6">
						<label class="col-sm-3 control-label">Notification Description <?=$astrik?></label>
						<div class="col-sm-6">
							<textarea name="description" class="form-control" rows="5" required><?= isset($notification->description) ? $notification->description : '' ?></textarea>
						</div>
					</div>

					
					
					<div class="form-group col-md-6">
						<label class="col-sm-3 control-label">Semester <?=$astrik?></label>
						<div class="col-sm-6">
							<select name="semester" class="form-control" >
										<option value="">Select Semester</option>
										<?php for($i=1;$i<=8;$i++){ ?>
											<option value="<?= $i ?>" <?= isset($notification) && $notification->semester==$i ? 'selected':'' ?>><?= $i ?></option>
										<?php } ?>
									</select>
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="col-sm-3 control-label">From Date<?=$astrik?></label>
						<div class="col-sm-6">
							<input type="date" name="from_date" class="form-control"
										   value="<?= isset($notification->from_date) ? $notification->from_date : '' ?>" required>
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="col-sm-3 control-label">To Date<?=$astrik?></label>
						<div class="col-sm-6">
							<input type="date" name="to_date" class="form-control"
										   value="<?= isset($notification->to_date) ? $notification->to_date : '' ?>" required>
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="col-sm-3 control-label">Notification URL<?=$astrik?></label>
						<div class="col-sm-6"><input type="url" name="notification_url" class="form-control"
										   value="<?= isset($notification->notification_url) ? $notification->notification_url : '' ?>"></div>
					</div>
					
					
					<div class="form-group text-center col-md-12">
						<button type="submit" class="btn btn-success"><?= isset($notification) ? 'Update' : 'Save' ?></button>
						<button class="btn btn-secondary" type="button" onclick="window.location='<?=base_url($currentModule)?>/notification_view'">Cancel</button>
					</div>
				</div>

            </form>
        </div>
    </div>
</div>
