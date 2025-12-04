<?php // views/course_outcomes/add.php ?>
<script src="<?= base_url('assets/javascripts/bootstrap-datepicker.js') ?>"></script>
<link href="<?= base_url('assets/css/bootstrapValidator.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url('assets/css/bootstrapValidator.min.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/javascripts/bootstrapValidator.js') ?>" type="text/javascript"></script>

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
            co_number: {
                validators: {
                    notEmpty: {
                        message: 'CO number is required'
                    },
                    stringLength: {
                        max: 10,
                        message: 'CO number must be less than 10 characters'
                    }
                }
            },
            co_description: {
                validators: {
                    notEmpty: {
                        message: 'CO description is required'
                    }
                }
            }
        }
    });
});
</script>

<?php $astrik = '<sup class="redasterik" style="color:red">*</sup>'; ?>
<?php $form_title = isset($co['id']) ? 'Edit Course Outcomes' : 'Add Course Outcomes'; ?>
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
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"><?= $form_title ?> Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <form id="form" name="form" action="<?= base_url($currentModule . '/submit' . (isset($co['id']) ? '/' . $co['id'] : '')) ?>" method="POST">

                                <input type="hidden" name="subject_id" id="subject_id" value='<?=$sub_id?>'>
                                <input type="hidden" name="campus_id" id="campus_id" value='<?=$campus_id?>'>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-3">CO Number <?= $astrik ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="co_number" value="<?= isset($co['co_number']) ? $co['co_number'] : '' ?>" class="form-control" required />
                                    </div>
                                </div>

                                <div class="form-group has-feedback">
                                    <label class="col-sm-3">CO Description <?= $astrik ?></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="co_description" value="<?= isset($co['co_description']) ? $co['co_description'] : '' ?>" class="form-control" required />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" type="submit">Submit</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="<?= base_url($currentModule) ?>/index/<?=$sub_id?>/<?=$campus_id?>" class="btn btn-default form-control">Cancel</a>
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
