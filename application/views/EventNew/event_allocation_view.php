<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.min.js"></script>

<script>
    $(document).ready(function() {
        $('#eventForm').bootstrapValidator({
            fields: {
                academic_year: {
                    validators: {
                        notEmpty: {
                            message: 'Please select an academic year'
                        }
                    }
                },
                school_id: {
                    validators: {
                        notEmpty: {
                            message: 'Please select a school'
                        }
                    }
                },
                course_id: {
                    validators: {
                        notEmpty: {
                            message: 'Please select a course'
                        }
                    }
                },
                stream_id: {
                    validators: {
                        notEmpty: {
                            message: 'Please select a stream'
                        }
                    }
                },
                semester: {
                    validators: {
                        notEmpty: {
                            message: 'Please select a semester'
                        }
                    }
                },
                'division[]': {
                    validators: {
                        notEmpty: {
                            message: 'Please select at least one division'
                        }
                    }
                },
                event_venue: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter the event venue'
                        },
                        stringLength: {
                            min: 3,
                            message: 'Venue name must be at least 3 characters long'
                        }
                    }
                },
                // from_date: {
                //     validators: {
                //         notEmpty: {
                //             message: 'Please select the from date'
                //         },
                //         date: {
                //             format: 'YYYY-MM-DD',
                //             message: 'The format must be YYYY-MM-DD'
                //         }
                //     }
                // },
                // to_date: {
                //     validators: {
                //         notEmpty: {
                //             message: 'Please select the to date'
                //         },
                //         date: {
                //             format: 'YYYY-MM-DD',
                //             message: 'The format must be YYYY-MM-DD'
                //         }
                //     }
                // }
            }
        });

        // Ensure that from_date is not greater than to_date
        $('#from_date, #to_date').on('change', function() {
            var fromDate = new Date($('#from_date').val());
            var toDate = new Date($('#to_date').val());

            if (fromDate > toDate) {
                alert('From Date cannot be greater than To Date.');
                $('#to_date').val('');
            }
        });

        // Apply Select2 validation on change
        $(".select2").on('change', function() {
            $('#eventForm').bootstrapValidator('revalidateField', 'division[]');
        });
    });
</script>
<style>
    .modal-content {
        border-radius: 12px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    }

    .btn {
        border-radius: 8px;
    }


    .form-check-input {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
    }

    .form-control,
    .form-select,
    .btn {
        transition: all 0.3s ease-in-out;
    }
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Event</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Event Or Other Schedule
            </h1>
        </div>
    </div>
    <div class="row">
    <div class="text-center">
            <?php if (!empty($this->session->flashdata('message_event_success'))) : ?>
                <div id="flash-success" style="color: green; font-weight: bold; margin-bottom: 10px;">
                    <?= $this->session->flashdata('message_event_success'); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($this->session->flashdata('message_event_error'))) : ?>
                <div id="flash-error" style="color: red; font-weight: bold; margin-bottom: 10px;">
                    <?= $this->session->flashdata('message_event_error'); ?>
                </div>
            <?php endif; ?>
        </div>
        <script>
            setTimeout(function() {
                const successBox = document.getElementById('flash-success');
                const errorBox = document.getElementById('flash-error');

                if (successBox) {
                    successBox.style.transition = 'opacity 0.5s';
                    successBox.style.opacity = '0';
                    setTimeout(() => successBox.innerHTML = '', 500); 
                }

                if (errorBox) {
                    errorBox.style.transition = 'opacity 0.5s';
                    errorBox.style.opacity = '0';
                    setTimeout(() => errorBox.innerHTML = '', 500);
                }
            }, 5000);
        </script>

        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading"> <br>
                    <form action="<?= base_url('Event/insert_event_allocation') ?>" id="eventForm" method="POST">
                        <div class="row g-3">
                            <input type="hidden" name="event_id" id="event_id" value="<?= isset($event_data['id']) ? $event_data['id'] : ''; ?>">

                            <div class="col-md-6">
                                <label for="event_name" class="form-label">Event Name:</label>
                                <input type="text" name="event_name" id="event_name" class="form-control"
                                    value="<?= isset($event_data['event_name']) ? htmlspecialchars($event_data['event_name']) : ''; ?>" readonly>
                            </div>

                            <!-- <div class="col-md-6">
                                <label for="from_date" class="form-label">From Date:</label>
                                <input type="date" name="from_date" id="from_date" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label for="to_date" class="form-label">To Date:</label>
                                <input type="date" name="to_date" id="to_date" class="form-control">
                            </div> -->


                            <div class="col-md-6">
                                <label for="academic_year" class="form-label">Academic Year:</label>
                                <input type="text" name="academic_year" id="academic_year" class="form-control"
                                    value="<?= isset($event_data['academic_year']) ? htmlspecialchars($event_data['academic_year']) : ''; ?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="school_id" class="form-label">School:</label>
                                <input type="text" class="form-control" value="<?= isset($event_data['school_name']) ? htmlspecialchars($event_data['school_name']) : ''; ?>" readonly>
                                <input type="hidden" name="school_id" id="school_id" value="<?= isset($event_data['school_id']) ? $event_data['school_id'] : ''; ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="course_id" class="form-label">Course Name:</label>
                                <input type="text" class="form-control" value="<?= isset($event_data['course_name']) ? htmlspecialchars($event_data['course_name']) : ''; ?>" readonly>
                                <input type="hidden" name="course_id" id="course_id" value="<?= isset($event_data['course_id']) ? $event_data['course_id'] : ''; ?>">
                            </div>

                            <div class="col-md-6">
                                <label for="stream_id" class="form-label">Stream Name:</label>
                                <input type="text" class="form-control" value="<?= isset($event_data['stream_name']) ? htmlspecialchars($event_data['stream_name']) : ''; ?>" readonly>
                                <input type="hidden" name="stream_id" id="stream_id_hidden" value="<?= isset($event_data['stream_id']) ? $event_data['stream_id'] : ''; ?>">

                            </div>


                            <div class="col-md-6">
                                <label for="semester" class="form-label">Semester:</label>
                                <select name="semester" id="semester" class="form-control">
                                    <option value="">Select Semester</option>
                                </select>
                            </div>

                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

                            <div class="col-md-6">
                                <label for="division" class="form-label">Division:</label>
                                <select name="division[]" id="division" class="form-control select2" multiple>
                                </select>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $(".select2").select2({
                                        placeholder: "Select Division(s)",
                                        allowClear: true
                                    });

                                    $('#semester').on('change', function() {
                                        var selectedSemester = $(this).val();
                                        var stream_id = $('#stream_id_hidden').val();
                                        var academic_year = $('#academic_year').val();

                                        if (selectedSemester && stream_id && academic_year) {
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?= base_url() ?>timetable/load_ttdivisionMutliselect',
                                                data: {
                                                    stream_id: stream_id,
                                                    academic_year: academic_year,
                                                    semester: selectedSemester
                                                },
                                                success: function(html) {
                                                    $('#division').html(html);
                                                    $("#division").trigger("change");
                                                }
                                            });
                                        } else {
                                            $('#division').html('<option value="all">All</option>');
                                        }
                                    });

                                    $('#division').on('change', function() {
                                        var selectedValues = $(this).val();

                                        if (selectedValues && selectedValues.includes('all')) {
                                            $("#division option").prop("selected", true);
                                            $(this).trigger("change");
                                        }
                                    });
                                });
                            </script>

                            <br>
                            <div class="col-md-6">
                                <label for="event_venue" class="form-label">Event Venue:</label>
                                <input type="text" name="event_venue" id="event_venue" class="form-control" placeholder="Enter Venue">
                            </div>

                            <!-- Time Slots -->
                            <!-- <div class="col-md-12">
                                <label class="form-label">Select Time Slots</label>
                                <div class="dropdown">
                                    <div class="dropdown-menu p-3 w-100" id="timeSlotDropdownMenu" style="max-height: 250px; overflow-y: auto;">
                                    </div>
                                    <input type="hidden" name="time_slot" id="selectedTimeSlots">
                                </div>
                            </div> -->

                            <div class="col-md-6">
                                <label for="" class="form-label">
                                    <hr>
                                </label>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Add Event</button>
                                <a href="<?= base_url('Event/event_allocation_list/' . base64_encode($event_data['id'])); ?>" class="btn btn-primary btn-labeled">
                                    <span class="btn-label icon fa fa-arrow-left"></span>Back
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#academic_year, #course_id, #stream_id, #semester, #division').on('change', function() {
            var academic_year = $('#academic_year').val();
            var course_id = $('#course_id').val();
            var stream_id = $('#stream_id').val();
            var semester = $('#semester').val();
            var division = $('#division').val();

            if (academic_year && course_id && stream_id && semester && division) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url("EventLectureController/get_time_slots_ajax") ?>',
                    data: {
                        academic_year: academic_year,
                        course_id: course_id,
                        stream_id: stream_id,
                        semester: semester,
                        division: division
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#timeSlotDropdownMenu').html('');

                        if (response.length > 0) {
                            var html = '';

                            $.each(response, function(index, slot) {
                                var label = slot.from_time + ' to ' + slot.to_time + ' (' + slot.slot_am_pm + ') - ' + slot.fname + ' ' + (slot.mname ? slot.mname : '') + ' ' + slot.lname + '-' + slot.subject_code + '(' + slot.subject_type + ')';
                                html += '<div class="form-check">' +
                                    '<input class="form-check-input timeSlotCheckbox" type="checkbox" value="' + slot.lect_slot_id + '" id="slot_' + slot.lect_slot_id + '">' +
                                    '<label class="form-check-label" for="slot_' + slot.lect_slot_id + '">' + label + '</label>' +
                                    '</div>';
                            });

                            $('#timeSlotDropdownMenu').html(html);
                        } else {
                            $('#timeSlotDropdownMenu').html('<p class="text-muted">No available slots</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching time slots:", error);
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        $(document).on('change', '.timeSlotCheckbox', function() {
            var selectedSlots = [];
            $('.timeSlotCheckbox:checked').each(function() {
                selectedSlots.push($(this).val());
            });
            $('#selectedTimeSlots').val(selectedSlots.join(','));
        });
    });
</script>

<script>
    $(document).ready(function() {
        var academic_year = $('#academic_year').val();
        var stream_id = $('#stream_id_hidden').val();

        var semester = '<?= $semesterNo ?>';
        var division = '<?= $division ?>';

        function loadSemesters(stream_id, academic_year) {
            if (stream_id && academic_year) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>timetable/load_ttsemesters',
                    data: {
                        stream_id: stream_id,
                        academic_year: academic_year
                    },
                    success: function(html) {
                        $('#semester').html(html);
                        if (semester) {
                            $("#semester").val(semester);
                        }

                        if (semester) {
                            loadDivisions(stream_id, academic_year, semester);
                        }
                    }
                });
            } else {
                $('#semester').html('<option value="">Select Stream first</option>');
            }
        }

        loadSemesters(stream_id, academic_year);

        $('#semester').on('change', function() {
            var selectedSemester = $(this).val();
            loadDivisions(stream_id, academic_year, selectedSemester);
        });
    });
</script>

</body>
</html>