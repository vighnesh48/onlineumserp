<script src="<?= base_url('assets/javascripts/bootstrap-datepicker.js') ?>"></script>
<link href="<?= base_url('assets/css/bootstrapValidator.css') ?>" rel="stylesheet" />
<script src="<?= base_url('assets/javascripts/bootstrapValidator.js') ?>"></script>

<style>
    .has-feedback .form-control-feedback {
        top: 0;
        right: 15px;
        line-height: 34px;
        position: absolute;
    }
</style>

<script>
$(document).ready(function () {
    $('#form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            peo_number: {
                validators: {
                    notEmpty: { message: 'PEO number is required' },
                    stringLength: {
                        max: 10,
                        message: 'PEO number must be less than 10 characters'
                    }
                }
            },
            peo_description: {
                validators: {
                    notEmpty: { message: 'PEO description is required' }
                }
            }
        }
    });
});
</script>

<?php $astrik = '<sup style="color:red">*</sup>'; ?>
<?php $form_title = isset($peo['peo_id']) ? 'Edit Program Educational Objective' : 'Add Program Educational Objective'; ?>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#"><?= $form_title ?></a></li>
    </ul>

    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<?= $form_title ?>
            </h1>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"><?= $form_title ?> Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <form id="form" name="form" action="<?= base_url($currentModule . '/submit' . (isset($peo['peo_id']) ? '/' . $peo['peo_id'] : '')) ?>" method="POST">
                                <input type="hidden" name="program_id" value="<?= $stream_id ?>">
                                <input type="hidden" name="campus_id" value="<?= $campus_id ?>">
                                <div class="form-group">
                                    <label class="col-sm-3">PEO Number <?= $astrik ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="peo_number" value="<?= isset($peo['peo_number']) ? $peo['peo_number'] : '' ?>" class="form-control" required />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3">PEO Description <?= $astrik ?></label>
                                    <div class="col-sm-4">
                                        <textarea name="peo_description" class="form-control" required><?= isset($peo['peo_description']) ? $peo['peo_description'] : '' ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" type="submit">Submit</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="<?= base_url($currentModule . '/index/' . $stream_id . '/' . $campus_id) ?>" class="btn btn-default form-control">Cancel</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
