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
        <li class="active">Add Reminders</li>
    </ul>

    <div class="page-header">
        <h1><i class="fa fa-user-graduate"></i> Add Reminders</h1>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <i class="fa fa-id-card"></i> Reminders 
			</div>

        <div class="panel-body">
            <form id="form" name="form" action="<?=base_url($currentModule.'/save_reminder')?>" method="POST" enctype="multipart/form-data" class="form-horizontal">

              	<input type="hidden" name="reminder_id" value="<?= isset($reminder['id']) ? $reminder['id'] : '' ?>">

                <!-- Batch Type -->
				<div class="row col-md-12">
					<h4 class="section-title text-center">Reminders Details</h4>
					<hr class="section-divider">
					<!-- External Faculty Details -->
					<div class="form-group col-md-6">
										<label class="col-sm-3 control-label">Title*</label>
										<div class="col-sm-6">
											<input type="text" name="title" class="form-control" required value="<?= $reminder['title'] ?? '' ?>">
										</div>
									</div>

									<div class="form-group col-md-6">
										<label class="col-sm-3 control-label">Reminder Date*</label>
										<div class="col-sm-6">
											<input type="date" name="reminder_date" class="form-control" required value="<?= $reminder['reminder_date'] ?? '' ?>">
										</div>
									</div>

									<div class="form-group col-md-6">
										<label class="col-sm-3 control-label">Reminder Time</label>
										<div class="col-sm-6">
											<input type="time" name="reminder_time" class="form-control" value="<?= $reminder['reminder_time'] ?? '' ?>">
										</div>
									</div>

									<div class="form-group col-md-12">
										<label class="col-sm-2 control-label">Description</label>
										<div class="col-sm-10">
											<textarea name="description" class="form-control" rows="6"><?= $reminder['description'] ?? '' ?></textarea>
										</div>
									</div>
					
					
					<div class="form-group text-center col-md-12">
						<button type="submit" class="btn btn-success"><?= isset($reminder) ? 'Update' : 'Save' ?></button>
						<button class="btn btn-secondary" type="button" onclick="window.location='<?=base_url($currentModule)?>/reminder_view'">Cancel</button>
					</div>
				</div>

            </form>
        </div>
    </div>
</div>
