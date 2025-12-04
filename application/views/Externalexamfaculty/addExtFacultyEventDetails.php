<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<link href="<?= site_url() ?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?= site_url() ?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        // Auto-calculate Total field
        function calculateTotal() {
            let ta = parseFloat($('#ta_amount').val()) || 0;
            let honorarium = parseFloat($('#honorarium_amount').val()) || 0;
            $('#total_amount').val((ta + honorarium).toFixed(2));
        }

        $('#ta_amount, #honorarium_amount').on('input', calculateTotal);
// Initialize Month-Year picker
$('#month_year').datepicker({
    format: "mm-yyyy",
    startView: "months", 
    minViewMode: "months",
    autoclose: true,
    endDate: new Date(), // Prevent future selection
    todayHighlight: true
});

// Set default to current month & year
var now = new Date();
var currentMonthYear = (now.getMonth() + 1).toString().padStart(2, '0') + '-' + now.getFullYear();
$('#month_year').datepicker('update', currentMonthYear);
$('.select2').select2();
        // BootstrapValidator initialization
        $('#form').bootstrapValidator({
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                ext_faculty: {
                    validators: {
                        notEmpty: {
                            message: 'Please select an external faculty'
                        }
                    }
                },
                event_type: {
                    validators: {
                        notEmpty: {
                            message: 'Please select an event type'
                        }
                    }
                },
                month_year: {
    validators: {
        notEmpty: {
            message: 'Please select a month and year'
        },
        regexp: {
            regexp: /^(0[1-9]|1[0-2])-(19|20)\d\d$/,
            message: 'Invalid month-year format'
        }
    }
},

                ta_amount: {
                    validators: {
                        notEmpty: {
                            message: 'TA amount is required'
                        },
                        numeric: {
                            message: 'TA amount must be a valid number'
                        }
                    }
                },
                honorarium_amount: {
                    validators: {
                        notEmpty: {
                            message: 'Honorarium amount is required'
                        },
                        numeric: {
                            message: 'Honorarium amount must be a valid number'
                        }
                    }
                },
                ext_fac_name: {
                    validators: {
                        notEmpty: {
                            message: 'Name is required'
                        },
                        stringLength: {
                            min: 2,
                            max: 100,
                            message: 'Name must be between 2 and 100 characters'
                        }
                    }
                }
            }
        });
    });
</script>

<?php
$astrik = '<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">External Faculty Event Type Detail</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<?php echo $title_name;?></h1>
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
                        <span class="panel-title"><?php echo $title_name;?></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <?php //if(in_array("Add", $my_privileges)) { 
                            ?>
                            <form id="form" name="form" action="<?= base_url($currentModule . '/submitExtFacultyEventTypeDetail') ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" id="updated_event_detail_id" name="updated_event_detail_id" value="<?= isset($updated_event_detail_id) ? $updated_event_detail_id : '' ?>" />

                                <div class="form-group">
                                    <label class="col-sm-3">Select Ext Faculty</label>
                                    <div class="col-sm-6">
                                        <select name="ext_faculty" id="ext_faculty" class="form-control select2">
                                            <option value="">Select Faculty</option>
                                            <?php
                                            $selected_faculty = set_value('ext_faculty', $sub[0]['ext_faculty_id'] ?? '');
                                            foreach ($ext_faculty_details as $result) {
                                                $selected = ($selected_faculty == $result['id']) ? 'selected' : '';
                                                echo "<option value='{$result['id']}' $selected>{$result['ext_fac_name']}</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('ext_faculty'); ?></span></div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3">Select Event Type</label>
                                    <div class="col-sm-6">
                                        <select name="event_type" id="event_type" class="form-control">
                                            <option value="">Select Event Type</option>
                                            <?php
                                            $selected_event = set_value('event_type', $sub[0]['event_type_id'] ?? '');
                                            foreach ($event_type_details as $result) {
                                                $selected = ($selected_event == $result['id']) ? 'selected' : '';
                                                echo "<option value='{$result['id']}' $selected>{$result['event_type']}</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('event_type'); ?></span></div>
                                </div>

                               

                                <div class="form-group">
    <label class="col-sm-3">Month & Year <sup class="redasterik" style="color:red">*</sup></label>
    <div class="col-sm-6">
        <input type="text" 
       class="form-control" 
       name="month_year" 
       id="month_year" 
       autocomplete="off" 
       readonly 
       value="<?= isset($sub[0]['month_year']) ? $sub[0]['month_year'] : '' ?>">

    </div>
    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('month_year'); ?></span></div>
</div>

                                <div class="form-group">
                                    <label class="col-sm-3">TA Amount <?= $astrik ?></label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control numeric-input" name="ta_amount" id="ta_amount"
                                            value="<?= isset($sub[0]['ta_amount']) ? $sub[0]['ta_amount'] : '' ?>" min="0" step="0.01">
                                    </div>
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('ta_amount'); ?></span></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3">Honorarium Amount <?= $astrik ?></label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control numeric-input" name="honorarium_amount" id="honorarium_amount"
                                            value="<?= isset($sub[0]['honorarium_amount']) ? $sub[0]['honorarium_amount'] : '' ?>" min="0" step="0.01">
                                    </div>
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('honorarium_amount'); ?></span></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3">Total</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="total_amount" id="total_amount" readonly
                                            value="<?= isset($sub[0]['ta_amount']) && isset($sub[0]['honorarium_amount']) ? ($sub[0]['ta_amount'] + $sub[0]['honorarium_amount']) : '' ?>">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3">Description</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="description" id="description" rows="3"><?= isset($sub[0]['description']) ? $sub[0]['description'] : '' ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit">Submit</button>
                                    </div>
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?= base_url($currentModule) ?>/listExtFacultyEventDetails'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            <?php //} 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>