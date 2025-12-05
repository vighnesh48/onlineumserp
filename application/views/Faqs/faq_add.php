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
        <li class="active">Add FAQs</li>
    </ul>

    <div class="page-header">
        <h1><i class="fa fa-user-graduate"></i> Add FAQs</h1>
    </div>

    <div class="panel">
        <div class="panel-heading">
            <i class="fa fa-id-card"></i> FAQs 
			</div>

        <div class="panel-body">
            <form id="form" name="form" action="<?=base_url($currentModule.'/save_faq')?>" method="POST" enctype="multipart/form-data" class="form-horizontal">

               <input type="hidden" name="faq_id" value="<?= isset($faq['id']) ? $faq['id'] : '' ?>">
               <input type="hidden" name="status" value="1">

                <!-- Batch Type -->
				<div class="row col-md-12">
					<h4 class="section-title text-center">FAQs Details</h4>
					<hr class="section-divider">
					<!-- External Faculty Details -->
					<div class="form-group col-md-6">
						<label class="col-sm-3 control-label">Question<?=$astrik?></label>
						<div class="col-sm-6"><textarea name="question" class="form-control" required><?= isset($faq['question']) ? $faq['question'] : '' ?></textarea></div>
					</div>
					
					
					<div class="form-group col-md-6">
						<label class="col-sm-3 control-label">Answer<?=$astrik?></label>
						<div class="col-sm-6"><textarea name="answer" class="form-control" rows="5" required><?= isset($faq['answer']) ? $faq['answer'] : '' ?></textarea></div>
					</div>

					<div class="form-group col-md-6">
						<label class="col-sm-3 control-label">Category <?=$astrik?></label>
						<div class="col-sm-6">
							<select class="form-control" name="category" id="category">
								<option value="profile" <?= isset($faq['category']) && $faq['category']=="profile" ? 'selected' : '' ?>>Profile Update</option>
							<option value="general" <?= isset($faq['category']) && $faq['category']=="general" ? 'selected' : '' ?>>General Query</option>
							<option value="assignments" <?= isset($faq['category']) && $faq['category']=="assignments" ? 'selected' : '' ?>>Assignments</option>
							<option value="fee" <?= isset($faq['category']) && $faq['category']=="fee" ? 'selected' : '' ?>>Fee Query</option>
							<option value="results" <?= isset($faq['category']) && $faq['category']=="results" ? 'selected' : '' ?>>Results Online</option>
							</select>
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="col-sm-3 control-label">Order No<?=$astrik?></label>
						<div class="col-sm-6">
							<input type="number" name="order_no" class="form-control" value="<?= isset($faq['order_no']) ? $faq['order_no'] : 1 ?>">
						</div>
					</div>
					
					<div class="form-group text-center col-md-12">
						<button type="submit" class="btn btn-success"><?= isset($faq) ? 'Update' : 'Save' ?></button>
						<button class="btn btn-secondary" type="button" onclick="window.location='<?=base_url($currentModule)?>/faq_view'">Cancel</button>
					</div>
				</div>

            </form>
        </div>
    </div>
</div>
