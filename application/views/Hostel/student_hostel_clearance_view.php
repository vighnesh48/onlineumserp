<!-- Include styles and scripts -->
<link href="<?= site_url() ?>assets/css/bootstrapValidator.min.css" rel="stylesheet" />
<script src="<?= base_url('assets/javascripts/bootstrap-datepicker.js') ?>"></script>
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js"></script>

<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });

        $('#form').bootstrapValidator({
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                date_of_leaving: {
                    validators: {
                        notEmpty: {
                            message: 'Date of leaving is required'
                        }
                    }
                },
                school_name: {
                    validators: {
                        notEmpty: {
                            message: 'College/School is required'
                        }
                    }
                },
                  stream_name: {
                    validators: {
                        notEmpty: {
                            message: 'Stream name is required'
                        }
                    }
                },
                created_on: {
                    validators: {
                        notEmpty: {
                            message: 'Date of Joining Hostel is required'
                        },
                        date: {
                            format: 'DD-MM-YYYY',
                            message: 'The date is not valid'
                        }
                    }
                },
                hostel_name: {
                    validators: {
                        notEmpty: {
                            message: 'Hostel No is required'
                        }
                    }
                },
                deposit_fees: {
                    validators: {
                        notEmpty: {
                            message: 'Deposit Amount is required'
                        },
                        numeric: {
                            message: 'Deposit Amount must be a number'
                        }
                    }
                },
                course_name: {
                    validators: {
                        notEmpty: {
                            message: 'Course Name is required'
                        }
                    }
                },
                year: {
                    validators: {
                        notEmpty: {
                            message: 'Year is required'
                        },
                        digits: {
                            message: 'Year must be a number'
                        }
                    }
                },
                room_no: {
                    validators: {
                        notEmpty: {
                            message: 'Room No is required'
                        }
                    }
                },
                damage_identified: {
                    validators: {
                        notEmpty: {
                            message: 'Please select if any damage is identified'
                        }
                    }
                },
                rector_remark: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter a remark'
                        }
                    }
                }
            }
        });
    });
</script>
<script>
    function form_check_exists(event) {
        const damage = document.querySelector('[name="damage_identified"]').value;
        if (!damage) {
            alert("Please select if any damage is identified.");
            return false;
        }

        return true;
    }
</script>

<?php
$astrik = '<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?= base_url($currentModule) ?>"> Hostel</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Student Hostel Clearace </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <br />
                    <span id="flash-messages" style="color:Green;padding-left:50px;">
                        <?php if (!empty($this->session->flashdata('message1'))) {
                            echo $this->session->flashdata('message1');
                        } ?></span>
                    <span id="flash-message" style="color:red;padding-left:50px;">
                        <?php if (!empty($this->session->flashdata('message2'))) {
                            echo $this->session->flashdata('message2');
                        } ?></span>
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Add Student Hostel Clearace</span>

                        <span id="message" style="color:red;padding-left:200px;"></span>
                        <div class="holder"></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">

                            <form id="form" name="form" action="<?= base_url($currentModule . '/submit_hostel_clearance') ?>" method="POST" onsubmit="return form_check_exists(event)">
                                <?php
                                $student = $student_list;
                                ?>

                                <?php
                                // Helper function to echo readonly if value is not empty, else empty string
                                function readonlyIfNotEmpty($val)
                                {
                                    return !empty($val) ? 'readonly' : '';
                                }
                                ?>
                                <input type="hidden" value="" id="" name="" />
                                <input type="hidden" name="student_id" value="<?= $student['student_id'] ?>" />
                                <input type="hidden" name="enrollment_no" value="<?= $student['enrollment_no'] ?>" />
                                <input type="hidden" name="created_on" value="<?= $student['created_on'] ?>" />


                                <?php
                                $student = $student_list;
                                ?>

                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label>Student Name:</label>
                                        <input type="text" name="student_name"  class="form-control" readonly value="<?= $student['first_name'] ?>" />
                                    </div>



                                    <div class="col-sm-4">
                                        <label>PRN No (Enrollment No):</label>
                                        <input type="text" class="form-control" readonly value="<?= $student['enrollment_no'] ?>" />
                                    </div>

                                    <div class="col-sm-4">
                                        <label>Date of Leaving Hostel:<sup class="redasterik" style="color:red">*</sup></label>
                                        <input type="text" id="date_of_leaving" name="date_of_leaving" class="form-control datepicker" placeholder="Select date" required />
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label>College/School:</label>
                                        <input type="text" name="school_name" class="form-control" <?= readonlyIfNotEmpty($student['school_name']) ?> value="<?= htmlspecialchars($student['school_name']) ?>" />

                                    </div>

                                    <div class="col-sm-4">
                                        <label>Date of Joining Hostel:</label>
                                        <input type="text" name="created_on" class="form-control" <?= readonlyIfNotEmpty($student['created_on']) ?> value="<?= !empty($student['created_on']) ? date('d-m-Y', strtotime($student['created_on'])) : '' ?>" />
                                    </div>

                                    <div class="col-sm-4">
                                        <label>Hostel No:</label>
                                        <input type="text" name="hostel_name" class="form-control" <?= readonlyIfNotEmpty($student['hostel_name']) ?> value="<?= htmlspecialchars($student['hostel_name']) ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label>Deposit Amount:</label>
                                        <input type="text" name="deposit_fees" class="form-control" <?= readonlyIfNotEmpty($student['deposit_fees']) ?> value="<?= htmlspecialchars($student['deposit_fees']) ?>" />
                                    </div>

                                    <div class="col-sm-4">
                                        <label>Course Name:</label>
                                        <input type="text" name="course_name" class="form-control" <?= readonlyIfNotEmpty($student['course_name']) ?> value="<?= htmlspecialchars($student['course_name']) ?>" />
                                    </div>

                                    
                                    <div class="col-sm-4">
                                        <label>Stream Name:</label>
                                        <input type="text" name="stream_name" class="form-control" <?= readonlyIfNotEmpty($student['stream_name']) ?> value="<?= htmlspecialchars($student['stream_name']) ?>" />
                                    </div>

                                    <div class="col-sm-4">
                                        <label>Year:</label>
                                        <input type="text" name="year" class="form-control" <?= readonlyIfNotEmpty($student['year']) ?> value="<?= htmlspecialchars($student['year']) ?>" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label>Room No:</label>
                                        <input type="text" name="room_no" class="form-control" <?= readonlyIfNotEmpty($student['room_no']) ?> value="<?= htmlspecialchars($student['room_no']) ?>" />
                                    </div>

                                    <div class="col-sm-4">
                                        <label>Any Damage Identified:<sup class="redasterik" style="color:red">*</sup></label>
                                        <select name="damage_identified" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="Y">Yes</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label>Hostel Rector Remark:<sup class="redasterik" style="color:red">*</sup></label>
                                        <textarea name="rector_remark" class="form-control" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit">Submit</button>
                                    </div>
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?= base_url($currentModule) ?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4"></div>
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