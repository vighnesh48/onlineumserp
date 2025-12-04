<!-- Include Select2 for Multi-Select Dropdown -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<style>
/* Improved modal styling */
.modal-content {
    border-radius: 12px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
}

/* Button Styling */
.btn {
    border-radius: 8px;
}

/* Customizing the dropdown for time slots */
.dropdown-menu {
    display: block !important;
    position: relative !important;
    max-height: 250px;
    overflow-y: auto;
    border-radius: 8px;
    padding: 10px;
    background-color: #fff;
    width: 100%;
}

/* Custom checkbox style */
.form-check-input {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

/* Apply soft focus to form fields */
.form-control:focus,
.form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
}

/* Smooth transition effects */
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
        <li class="active"><a href="#">Time Table Master</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i
                    class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Event Or Other Schedule<span
                    class="panel-title"></span></h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php // if(in_array("Add", $my_privileges)) { ?>
                    <div class="pull-right col-xs-12 col-sm-auto"></div>
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php //} ?>

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
                        <div class="row ">
                            <div class="col-sm-3">
                                <button class="btn btn-primary mb-3" id="addEventBtn">Add Event</button>
                            </div>
                            <div class="col-sm-9" style="color:green;float:left;font-weight: 900;">
                                <?php
                                if ($this->session->flashdata('Tmessage') != ''):
                                    echo $this->session->flashdata('Tmessage');
                                endif;
                                ?>
                            </div>
                        </div>

                    </div>
                    <div class="panel-body" style="">


                        <div class="table-info table-responsive">
                            <?php //if(in_array("View", $my_privileges)) { ?>
                            <table class="table table-bordered" width="100%" id="search-table">
                                <thead>
                                    <tr>
                                        <th>Academic Year</th>
                                        <th>School</th>
                                        <th>Stream</th>
                                        <th>Semester</th>
                                        <th>Division</th>
                                        <th>Event Name</th>
                                        <th>Date</th>
                                        <th>Time Slot</th>
                                        <th>Venue</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($events as $event) { ?>
                                        <tr>
                                            <td><?= $event['academic_year'] ?></td>
                                            <td><?= $event['school_short_name'] ?></td>
                                            <td><?= $event['stream_name'] ?></td>
                                            <td><?= $event['semester'] ?></td>
                                            <td><?= $event['division'] ?></td>
                                            <td><?= $event['event_name'] ?></td>
                                            <td><?= $event['from_date'] . ' to ' . $event['to_date'] ?></td>
                                            <td><?= $event['from_time'] . ' to ' . $event['to_time'] . '(' . $event['slot_am_pm'] . ')' ?>
                                            </td>
                                            <td><?= $event['event_venue'] ?></td>
                                            <td>
                                                <a
                                                    href="<?= base_url('EventLectureController/toggle_status/' . $event['id'] . '/' . ($event['status'] == 'Active' ? 'Inactive' : 'Active')) ?>">
                                                    <?= $event['status'] ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="editBtn"
                                                    data-id="<?= $event['id'] ?>"><i class="fa fa-edit"></i></a>
                                                <!-- <a href="<?= base_url('EventLectureController/delete_event/' . $event['id']) ?>"
                                                    class="btn btn-danger btn-sm">Delete</a> -->
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Large modal for better spacing -->
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-calendar"></i> Event Details</h5>
            </div>

            <div class="modal-body">
                <form id="eventForm">
                    <input type="hidden" id="event_id" name="id">

                    <div class="row g-3"> 
                        <div class="col-md-6">
                            <label for="academic_year" class="form-label">Academic Year:</label>
                            <select name="academic_year" id="academic_year" class="form-control" required>
                                <option value="">Select Academic Year</option>
                                <?php foreach ($academic_years as $yr) {
                                    echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session'] . '">' . $yr['academic_year'] . '</option>';
                                } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="school_id" class="form-label">School:</label>
                            <select name="school_id" id="school_id" class="form-control" required>
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

                        <div class="col-md-6">
                            <label for="semester" class="form-label">Semester:</label>
                            <select name="semester" id="semester" class="form-control">
                                <option value="">Select Semester</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="division" class="form-label">Division:</label>
                            <select name="division" id="division" class="form-control">
                                <option value="">Select Division</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="event_name" class="form-label">Event Name:</label>
                            <input type="text" name="event_name" id="event_name" class="form-control"
                                placeholder="Enter Event Name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="from_date" class="form-label">From Date:</label>
                            <input type="date" name="from_date" id="from_date" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control" required>
                        </div>

                        <!-- Custom Styled Time Slot Multi-Select -->
                        <div class="col-md-12">
                            <label class="form-label">Select Time Slots</label>
                            <div class="dropdown">
                                <div class="dropdown-menu p-3 w-100" id="timeSlotDropdownMenu" style="max-height: 250px; overflow-y: auto;">
                                    <!-- Checkboxes will be added dynamically here -->
                                </div>
                                <input type="hidden" name="time_slot" id="selectedTimeSlots">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="event_venue" class="form-label">Event Venue</label>
                            <input type="text" name="event_venue" id="event_venue" class="form-control"
                                placeholder="Enter Venue" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
  
    $(document).ready(function () {
        $('#eventTable').DataTable();

        $('#addEventBtn').on('click', function () {
            $('#eventForm')[0].reset();
            $('#event_id').val("");  // Ensure it's blank for insert
            $('#timeSlotDropdownMenu').empty();  // Clear any old values
            $('#selectedTimeSlots').val("");  // Reset hidden input
            $('#eventModal').modal('show');
        });

        $('.editBtn').on('click', function () {
            var eventId = $(this).data('id');
            $.get('<?= base_url("EventLectureController/get_event/") ?>' + '/' + eventId, function (data) {
                var event = JSON.parse(data);
                $('#event_id').val(event.id);
                $('#academic_year').val(event.academic_year);
                $('#school_id').val(event.school_id);
                $('#course_id').val(event.course_id);
                $('#stream_id').val(event.stream_id);
                $('#semester').val(event.semester);
                $('#division').val(event.division);
                $('#event_name').val(event.event_name);
                $('#from_date').val(event.from_date);
                $('#to_date').val(event.to_date);
                $('#time_slot').val(event.time_slot);
                $('#event_venue').val(event.event_venue);
                $('#eventModal').modal('show');
            });
        });

        $('#eventForm').submit(function (e) {
            e.preventDefault();
            var eventId = $('#event_id').val();
            var url = eventId ? '<?= base_url("EventLectureController/update_event") ?>' + '/' + eventId : '<?= base_url("EventLectureController/insert_event") ?>';

            $.ajax({
                type: 'POST',
                url: url,
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === "success") {
                        alert(eventId ? "Event updated successfully!" : "Event inserted successfully!");
                        $('#eventModal').modal('hide');
                        location.reload();
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log("AJAX Error: " + error);
                    console.log(xhr.responseText);
                }
            });
        });
    });


    $(document).ready(function () {
    $('#academic_year, #course_id, #stream_id, #semester, #division').on('change', function () {
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
                success: function (response) {
                    $('#timeSlotDropdownMenu').html(''); // Clear previous checkboxes

                    if (response.length > 0) {
                        var html = ''; // ✅ Store all checkboxes in a variable

                        $.each(response, function (index, slot) {
                            var label = slot.from_time + ' to ' + slot.to_time + ' (' + slot.slot_am_pm + ') - ' + slot.fname + ' ' + (slot.mname ? slot.mname : '') + ' ' + slot.lname +'-'+ slot.subject_code + '(' + slot.subject_type + ')';
                            html += '<div class="form-check">' +
                                    '<input class="form-check-input timeSlotCheckbox" type="checkbox" value="' + slot.lect_slot_id + '" id="slot_' + slot.lect_slot_id + '">' +
                                    '<label class="form-check-label" for="slot_' + slot.lect_slot_id + '">' + label + '</label>' +
                                    '</div>';
                        });

                        $('#timeSlotDropdownMenu').html(html); // ✅ Replace dropdown content
                    } else {
                        $('#timeSlotDropdownMenu').html('<p class="text-muted">No available slots</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching time slots:", error);
                    console.error(xhr.responseText);
                }
            });
        }
    });

    // Store selected checkboxes in the hidden input field
    $(document).on('change', '.timeSlotCheckbox', function () {
        var selectedSlots = [];
        $('.timeSlotCheckbox:checked').each(function () {
            selectedSlots.push($(this).val());
        });
        $('#selectedTimeSlots').val(selectedSlots.join(',')); // ✅ Store in hidden input field
    });
});





</script>

<script>
    $('#academic_year').on('change', function () {
        var academic_year = $(this).val();
        if (academic_year) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>timetable/load_ttcources',
                data: { academic_year: academic_year },
                success: function (html) {
                    //alert(html);
                    $('#course_id').html(html);
                }
            });
        } else {
            $('#course_id').html('<option value="">Select academic year first</option>');
        }
    });
    $('#stream_id').on('change', function () {
        var stream_id = $(this).val();
        var academic_year = $("#academic_year").val();
        if (stream_id) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>timetable/load_ttsemesters',
                data: { stream_id: stream_id, academic_year: academic_year },
                success: function (html) {
                    //alert(html);
                    $('#semester').html(html);
                }
            });
        } else {
            $('#semester').html('<option value="">Select Stream first</option>');
        }
    });
    //

    var stream_id = '<?= $streamId ?>';
    var course_id = '<?= $courseId ?>';
    var academic_year = '<?= $academicyear ?>';
    if (academic_year) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>timetable/load_ttcources',
            data: { academic_year: academic_year },
            success: function (html) {
                //alert(html);
                $('#course_id').html(html);
                $("#course_id option[value='" + course_id + "']").attr("selected", "selected");
            }
        });
    }
    if (course_id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>Timetable/load_tt_streams',
            data: { course_id: course_id, academic_year: academic_year },
            'success': function (data) { //probably this request will return anything, it'll be put in var "data"
                var container = $('#stream_id'); //jquery selector (get element by id)
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
            data: { stream_id: stream_id, academic_year: academic_year },
            success: function (html) {
                var semester = '<?= $semesterNo ?>';
                $('#semester').html(html);
                $("#semester option[value='" + semester + "']").attr("selected", "selected");
            }
        });
    } else {
        $('#semester').html('<option value="">Select Stream first</option>');
    }


    $('#semester').on('change', function () {
        var semester = $(this).val();
        var stream_id = $("#stream_id").val();
        var academic_year = $("#academic_year").val();
        if (semester) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>timetable/load_ttdivision',
                data: { stream_id: stream_id, academic_year: academic_year, stream_id: stream_id, semester: semester },
                success: function (html) {

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
            data: { stream_id: stream_id, academic_year: academic_year, stream_id: stream_id, semester: semester },
            success: function (html) {
                var division = '<?= $division ?>';
                $('#division').html(html);
                $("#division option[value='" + division + "']").attr("selected", "selected");
            }
        });
    } else {
        $('#division').html('<option value="">Select Stream first</option>');
    }

    $('#course_id').on('change', function () {
        var academic_year = $("#academic_year").val();
        var course_id = $(this).val();
        if (course_id) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>Timetable/load_tt_streams',
                data: { course_id: course_id, academic_year: academic_year },
                success: function (html) {
                    //alert(html);
                    $('#stream_id').html(html);
                }
            });
        } else {
            $('#stream_id').html('<option value="">Select course first</option>');
        }
    });

</script>

</body>

</html>