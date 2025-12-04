<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $("#checkAll").click(function() {
            $("input[name='attendance[]']").not(":disabled").prop('checked', this.checked);
        });

        $("input[name='attendance[]']").change(function() {
            if (!this.checked) {
                $("#checkAll").prop("checked", false);
            }
        });
    });

    function validateAttendanceForm() {
        let checkboxes = document.querySelectorAll('input[name="attendance[]"]:checked');
        if (checkboxes.length === 0) {
            alert("Please check at least one student.");
            return false;
        }
        return true;
    }
</script>
<style>
    .badge-custom {
        display: inline-block;
        width: 80px;
        text-align: center;
        padding: 5px 6px;
        font-size: 13px;
        border-radius: 0px;
        color: white;
    }

    .badge-marked {
        background-color: #28a745;
    }

    .badge-pending {
        background-color: #dc3545;
    }

    .instruction-box {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        border-left: 5px solid #007bff;
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?= base_url($currentModule) ?>">Event</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Event Attendance
            </h1>
        </div>
    </div>
    <div class="pull-right col-xs-12 col-sm-auto">

        <a href="<?= base_url('Event/event_allocation_list/' . base64_encode($event_allocation_data[0]['id'] ?? '')); ?>" class="btn btn-primary btn-labeled">
            <span class="btn-label icon fa fa-arrow-left"></span>Back
        </a>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <span class="text-muted">Mark Event Attendance</span> |
                        <span class="btn text-white px-4 py-2" style="background-color: rgb(163, 28, 28); cursor: default;">
                            <strong style="color: #f8f9fa;">📜<?= $event_allocation_data[0]['event_name'] ?? '' ?></strong>
                        </span>

                    </h4>
                </div>

                <div class="panel-body">
                    <div class="table-info">
                        <div class="row">

                            <div class="col-md-3">
                                <label>School Name:</label>
                                <input type="text" class="form-control" value="<?= $event_allocation_data[0]['school_name'] ?? '' ?>" readonly>
                                <input type="hidden" name="school_id" value="<?= $event_allocation_data[0]['school_id'] ?? '' ?>">
                            </div>

                            <div class="col-md-2">
                                <label>Course Name:</label>
                                <input type="text" class="form-control" value="<?= $event_allocation_data[0]['course_name'] ?? '' ?>" readonly>
                                <input type="hidden" name="course_id" value="<?= $event_allocation_data[0]['course_id'] ?? '' ?>">
                            </div>
                            <div class="col-md-2">
                                <label>Stream Name:</label>
                                <input type="text" class="form-control" value="<?= $event_allocation_data[0]['stream_name'] ?? '' ?>" readonly>
                                <input type="hidden" name="stream_id" value="<?= $event_allocation_data[0]['stream_id'] ?? '' ?>">
                            </div>
                            <div class="col-md-2">
                                <label>Semester:</label>
                                <input type="text" class="form-control" value="<?= $event_allocation_data[0]['semester'] ?? '' ?>" readonly>
                                <input type="hidden" name="semester" value="<?= $event_allocation_data[0]['semester'] ?? '' ?>">
                            </div>
                            <div class="col-md-2">
                                <label>Division:</label>
                                <input type="text" class="form-control" value="<?= $event_allocation_data[0]['division'] ?? '' ?>" readonly>
                                <input type="hidden" name="division" value="<?= $event_allocation_data[0]['division'] ?? '' ?>">
                            </div>
                            <input type="hidden" name="" id="start_date" value="<?= $event_allocation_data[0]['start_date'] ?? '' ?>">
                            <input type="hidden" name="" id="end_date" value="<?= $event_allocation_data[0]['end_date'] ?? '' ?>">
                        </div> <br>

                        <form method="POST" action="<?= base_url('Event/upload_attendance/' . base64_encode($event_allocation_data[0]['event_allocation_id'] ?? '')) ?>">
                            <input type="hidden" name="event_allocation_id" value="<?= $event_allocation_data[0]['event_allocation_id'] ?? '' ?>">
                            <input type="hidden" name="event_id" value="<?= $event_allocation_data[0]['id'] ?? '' ?>">

                            <div class="row">
                                <div class="col-sm-2">
                                    <label>Select Attendance Date:</label>
                                    <?php
                                    $startDate = isset($event_allocation_data[0]['start_date']) ? date('Y-m-d', strtotime($event_allocation_data[0]['start_date'])) : '';
                                    $endDate = isset($event_allocation_data[0]['end_date']) ? date('Y-m-d', strtotime($event_allocation_data[0]['end_date'])) : '';
                                    ?>

                                    <input type="date" id="attendance_date" name="attendance_date" class="form-control" value="<?= $attendance_date ?>">
                                </div>
                                <div class="col-sm-1 d-flex align-items-end">
                                    <label for=""></label>
                                    <button type="submit" class="btn btn-primary form-control">Search</button>
                                </div>
                                <div class="col-sm-8">
                                    <div class="instruction-box">
                                        <ul>
                                            <li><b>Attendance Restriction (Note):</b> <br>~If attendance for the selected date has already been marked, you cannot proceed further. Please choose a different date or review the existing attendance records.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <script>
                            function formatDateToDMY(date) {
                                const day = String(date.getDate()).padStart(2, '0');
                                const month = String(date.getMonth() + 1).padStart(2, '0');
                                const year = date.getFullYear();
                                return `${day}-${month}-${year}`;
                            }

                            document.querySelector("form[action*='upload_attendance']").addEventListener("submit", function(e) {
                                const startDate = new Date(document.getElementById("start_date").value);
                                const endDate = new Date(document.getElementById("end_date").value);
                                const attendanceDateInput = document.getElementById("attendance_date");
                                const attendanceDate = new Date(attendanceDateInput.value);

                                if (attendanceDate < startDate || attendanceDate > endDate) {
                                    e.preventDefault(); // Stop form submission
                                    alert("Attendance Date must be between Start Date " + formatDateToDMY(startDate) + " and End Date " + formatDateToDMY(endDate));
                                    attendanceDateInput.focus();
                                }
                            });
                        </script>

                        <form method="POST" action="<?= base_url('Event/upload_attendance_process'); ?>" onsubmit="return validateAttendanceForm();">
                            <input type="hidden" name="event_allocation_id" value="<?= $event_allocation_data[0]['event_allocation_id'] ?? '' ?>">
                            <input type="hidden" name="event_id" value="<?= $event_allocation_data[0]['id'] ?? '' ?>">

                            <?php if (!empty($attendance_date)) : ?>
                                <input type="hidden" name="attendance_date" value="<?= $attendance_date ?>">

                            <?php endif; ?>

                            <input type="hidden" name="school_id" value="<?= $event_allocation_data[0]['school_id'] ?? '' ?>">

                            <input type="hidden" name="course_id" value="<?= $event_allocation_data[0]['course_id'] ?? '' ?>">

                            <input type="hidden" name="stream_id" value="<?= $event_allocation_data[0]['stream_id'] ?? '' ?>">

                            <input type="hidden" name="semester" value="<?= $event_allocation_data[0]['semester'] ?? '' ?>">

                            <input type="hidden" name="division" value="<?= $event_allocation_data[0]['division'] ?? '' ?>">


                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkAll"></th>
                                        <th>#</th>
                                        <th>Enrollment No</th>
                                        <th>Student Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <?php if (!empty($allocateStudents)) : ?>
                                        <?php $i = 1; ?>
                                        <?php foreach ($allocateStudents as $student) :
                                            $isMarked = in_array($student['student_id'], $markedStudentIds); ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="attendance[]" value="<?= $student['student_id'] ?>" <?= $isMarked ? 'checked disabled' : '' ?>>
                                                </td>
                                                <td><?= $i ?></td>
                                                <td><?= htmlspecialchars($student['enrollment_no']) ?></td>
                                                <td><?= htmlspecialchars($student['first_name']) ?></td>
                                                <td>
                                                    <?php if ($isMarked): ?>
                                                        <span class="badge-custom badge-marked">Marked</span>
                                                    <?php else: ?>
                                                        <span class="badge-custom badge-pending">Not Marked</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No students found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <?php if (empty($markedStudentIds)): ?>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Upload Attendance</button>
                                </div>
                            <?php endif; ?>
                        </form>

                        <div class="pagination-container text-center">
                            <?= isset($pagination_links) ? $pagination_links : '' ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>