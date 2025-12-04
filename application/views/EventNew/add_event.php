<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<link href="<?= site_url() ?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?= site_url() ?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
    .panel-heading {
        color: #8a6d3b;
        background-color: #fcf8e3;
        border-color: #faebcc;
    }
</style>


<?php
$astrik = '<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?= base_url($currentModule) ?>">Event </a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Events </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <br />
                    <span id="flash-messages" style="color:Green;padding-left:50px;">
                        <?php if (!empty($this->session->flashdata('message_event_success'))) {
                            echo $this->session->flashdata('message_event_success');
                        } ?></span>
                    <span id="flash-message" style="color:red;padding-left:50px;">
                        <?php if (!empty($this->session->flashdata('message_event_error'))) {
                            echo $this->session->flashdata('message_event_error');
                        } ?></span>
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading ">
                        <span class="panel-title">Add Event </span>
                        <span id="message" style="color:red;padding-left:200px;"></span>
                        <div class="holder"></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">

                            <form id="form" name="form" action="<?= base_url($currentModule . '/save_event') ?>" method="POST" enctype="multipart/form-data">
                                <!-- <input type="hidden" value="" id="canteen_slot_id" name="canteen_slot_id" /> -->

                                <div class="form-group">

                                    <div class="col-sm-6">
                                        <label>Event Name <?= $astrik ?></label>
                                        <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Enter Event Name">
                                        <span style="color:red;"><?php echo form_error('event_name'); ?></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Event Organised By<?= $astrik ?></label>
                                        <input type="text" class="form-control" name="organised_by" id="organised_by" placeholder="Enter Organised By">
                                        <span style="color:red;"><?php echo form_error('organised_by'); ?></span>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <div class="col-sm-3">
                                        <label>Event Start Date<?= $astrik ?></label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Enter Event Start Date">
                                        <span style="color:red;"><?php echo form_error('start_date'); ?></span>
                                    </div>

                                    <div class="col-sm-3">
                                        <label>Event End Date<?= $astrik ?></label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" placeholder="Enter Event End Date">
                                        <span style="color:red;"><?php echo form_error('end_date'); ?></span>
                                    </div>

                                    <div class="col-sm-3">
                                        <label>Event Start Time<?= $astrik ?></label>
                                        <input type="time" name="start_time" id="start_time" class="form-control" placeholder="Enter Event Start Time">
                                        <span style="color:red;"><?php echo form_error('start_time'); ?></span>
                                    </div>

                                    <div class="col-sm-3">
                                        <label>Event End Time<?= $astrik ?></label>
                                        <input type="time" name="end_time" id="end_time" class="form-control" placeholder="Enter Event End Time">
                                        <span style="color:red;"><?php echo form_error('end_time'); ?></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="academic_year" class="form-label">Academic Year:</label>
                                    <select name="academic_year" id="academic_year" class="form-control">
                                        <option value="">Select Academic Year</option>
                                        <?php foreach ($academic_years as $yr) {
                                            echo '<option value="' . $yr['academic_year'] . '">' . $yr['academic_year'] . '</option>';
                                        } ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="school_id" class="form-label">School:</label>
                                    <select name="school_id" id="school_id" class="form-control">
                                        <option value="">Select School</option>
                                        <?php foreach ($school_details as $school) {
                                            echo '<option value="' . $school['school_id'] . '">' . $school['school_short_name'] . '</option>';
                                        } ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="course_id" class="form-label">Course:</label>
                                    <select name="course_id" id="course_id" class="form-control">
                                        <option value="">Select Course</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="stream_id" class="form-label">Stream:</label>
                                    <select name="stream_id" id="stream_id" class="form-control">
                                        <option value="">Select Stream</option>
                                    </select>
                                </div>

                                <div class="form-group">

                                    <div class="col-sm-6">
                                        <label>Event Address<?= $astrik ?></label>
                                        <textarea name="event_address" id="event_address" class="form-control" placeholder="Enter Event Address"></textarea>
                                        <span style="color:red;"><?php echo form_error('event_address'); ?></span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Event Description<?= $astrik ?></label>
                                        <textarea name="event_description" id="event_description" class="form-control" placeholder="Enter Event Description"></textarea>
                                        <span style="color:red;"><?php echo form_error('event_description'); ?></span>
                                    </div>

                                </div>

                                <br>

                                <div class="form-group">

                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit">Submit</button>
                                    </div>
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?= base_url($currentModule) ?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#academic_year').on('change', function() {
        var academic_year = $(this).val();
        if (academic_year) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>timetable/load_ttcources',
                data: {
                    academic_year: academic_year
                },
                success: function(html) {
                    $('#course_id').html(html);
                }
            });
        } else {
            $('#course_id').html('<option value="">Select academic year first</option>');
        }
    });
    $('#stream_id').on('change', function() {
        var stream_id = $(this).val();
        var academic_year = $("#academic_year").val();
        if (stream_id) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>timetable/load_ttsemesters',
                data: {
                    stream_id: stream_id,
                    academic_year: academic_year
                },
                success: function(html) {
                    $('#semester').html(html);
                }
            });
        } else {
            $('#semester').html('<option value="">Select Stream first</option>');
        }
    });

    var stream_id = '<?= $streamId ?>';
    var course_id = '<?= $courseId ?>';
    var academic_year = '<?= $academicyear ?>';
    if (academic_year) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>timetable/load_ttcources',
            data: {
                academic_year: academic_year
            },
            success: function(html) {
                $('#course_id').html(html);
                $("#course_id option[value='" + course_id + "']").attr("selected", "selected");
            }
        });
    }
    if (course_id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>Timetable/load_tt_streams',
            data: {
                course_id: course_id,
                academic_year: academic_year
            },
            'success': function(data) {
                var container = $('#stream_id');
                if (data) {
                    var stream_id = '<?= $streamId ?>';
                    container.html(data);
                    $("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
                }
            }
        });
    }
    if (stream_id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>timetable/load_ttsemesters',
            data: {
                stream_id: stream_id,
                academic_year: academic_year
            },
            success: function(html) {
                var semester = '<?= $semesterNo ?>';
                $('#semester').html(html);
                $("#semester option[value='" + semester + "']").attr("selected", "selected");
            }
        });
    } else {
        $('#semester').html('<option value="">Select Stream first</option>');
    }


    $('#semester').on('change', function() {
        var semester = $(this).val();
        var stream_id = $("#stream_id").val();
        var academic_year = $("#academic_year").val();
        if (semester) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>timetable/load_ttdivision',
                data: {
                    stream_id: stream_id,
                    academic_year: academic_year,
                    stream_id: stream_id,
                    semester: semester
                },
                success: function(html) {

                    $('#division').html(html);

                }
            });
        } else {
            $('#division').html('<option value="">Select Stream first</option>');
        }
    });

    var semester = '<?= $semesterNo ?>';
    if (semester) {
        var academic_year = '<?= $academicyear ?>';
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>timetable/load_ttdivision',
            data: {
                stream_id: stream_id,
                academic_year: academic_year,
                stream_id: stream_id,
                semester: semester
            },
            success: function(html) {
                var division = '<?= $division ?>';
                $('#division').html(html);
                $("#division option[value='" + division + "']").attr("selected", "selected");
            }
        });
    } else {
        $('#division').html('<option value="">Select Stream first</option>');
    }

    $('#course_id').on('change', function() {
        var academic_year = $("#academic_year").val();
        var course_id = $(this).val();
        if (course_id) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>Timetable/load_tt_streams',
                data: {
                    course_id: course_id,
                    academic_year: academic_year
                },
                success: function(html) {

                    $('#stream_id').html(html);
                }
            });
        } else {
            $('#stream_id').html('<option value="">Select course first</option>');
        }
    });
</script>
<script>
    $(document).ready(function() {
        $("#form").on("submit", function(e) {
            let isValid = true;

            $(".error-message").remove();

            function showError(input, message) {
                $(input).after('<span class="error-message text-danger">' + message + '</span>');
                isValid = false;
            }

            let alphaNumericRegex = /^[a-zA-Z0-9\s]+$/;
            let dateRegex = /^\d{4}-\d{2}-\d{2}$/;
            let timeRegex = /^([01]\d|2[0-3]):[0-5]\d$/;

            let academicYear = $("#academic_year").val();
            if (!academicYear) {
                showError("#academic_year", "Please select an Academic Year.");
            }

            let schoolId = $("#school_id").val();
            if (!schoolId) {
                showError("#school_id", "Please select a School.");
            }

            let courseId = $("#course_id").val();
            if (!courseId) {
                showError("#course_id", "Please select a Course.");
            }

            let streamId = $("#stream_id").val();
            if (!streamId) {
                showError("#stream_id", "Please select a Stream.");
            }

            let eventName = $("#event_name").val().trim();
            if (eventName.length < 3 || eventName.length > 100 || !alphaNumericRegex.test(eventName)) {
                showError("#event_name", "Event Name must be 3-100 characters and contain only letters, numbers, and spaces.");
            }

            let organisedBy = $("#organised_by").val().trim();
            if (organisedBy.length < 3 || organisedBy.length > 100 || !alphaNumericRegex.test(organisedBy)) {
                showError("#organised_by", "Organised By must be 3-100 characters and contain only letters, numbers, and spaces.");
            }

            let startDate = $("#start_date").val();
            if (!startDate.match(dateRegex)) {
                showError("#start_date", "Please enter a valid Start Date in YYYY-MM-DD format.");
            }

            let endDate = $("#end_date").val();
            if (!endDate.match(dateRegex)) {
                showError("#end_date", "Please enter a valid End Date in YYYY-MM-DD format.");
            } else if (new Date(endDate) < new Date(startDate)) {
                showError("#end_date", "End Date must be after Start Date.");
            }

            let startTime = $("#start_time").val();
            if (!startTime.match(timeRegex)) {
                showError("#start_time", "Please enter a valid Start Time in HH:MM format.");
            }

            let endTime = $("#end_time").val();
            if (!endTime.match(timeRegex)) {
                showError("#end_time", "Please enter a valid End Time in HH:MM format.");
            } else if (startDate === endDate && endTime <= startTime) {
                showError("#end_time", "End Time must be after Start Time when both dates are the same.");
            }

            let eventAddress = $("#event_address").val().trim();
            if (eventAddress.length < 5 || eventAddress.length > 255) {
                showError("#event_address", "Event Address must be between 5 and 255 characters.");
            }

            let eventDescription = $("#event_description").val().trim();
            if (eventDescription.length < 2 || eventDescription.length > 500) {
                showError("#event_description", "Event Description must be between 2 and 500 characters.");
            }

            if (isValid) {
                $("#btn_submit").prop("disabled", true).text("Submitted");
            } else {
                e.preventDefault();
            }

        });
    });
</script>