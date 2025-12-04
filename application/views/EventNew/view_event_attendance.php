<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>

<script>
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
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View Event Attendance
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
                        </div><br>
                        <form method="POST" action="<?= base_url('Event/view_attendance/' . base64_encode($event_allocation_data[0]['event_allocation_id'] ?? '')) ?>">
                            <input type="hidden" name="event_allocation_id" value="<?= $event_allocation_data[0]['event_allocation_id'] ?? '' ?>">
                            <input type="hidden" name="event_id" value="<?= $event_allocation_data[0]['id'] ?? '' ?>">

                            <div class="row">
                                <div class="col-sm-2">
                                    <label>Select Attendance Date:</label>
                                    <input type="date" name="attendance_date" class="form-control" value="<?= $attendance_date ?>">
                                </div>
                                <div class="col-sm-1 d-flex align-items-end">
                                    <label for=""></label>
                                    <button type="submit" class="btn btn-primary form-control">Search</button>
                                </div>
                            </div>
                        </form>

                        <input type="hidden" name="event_allocation_id" value="<?= $event_allocation_data[0]['event_allocation_id'] ?? '' ?>">
                        <input type="hidden" name="event_id" value="<?= $event_allocation_data[0]['id'] ?? '' ?>">

                        <input type="hidden" name="school_id" value="<?= $event_allocation_data[0]['school_id'] ?? '' ?>">

                        <input type="hidden" name="course_id" value="<?= $event_allocation_data[0]['course_id'] ?? '' ?>">

                        <input type="hidden" name="stream_id" value="<?= $event_allocation_data[0]['stream_id'] ?? '' ?>">

                        <input type="hidden" name="semester" value="<?= $event_allocation_data[0]['semester'] ?? '' ?>">

                        <input type="hidden" name="division" value="<?= $event_allocation_data[0]['division'] ?? '' ?>">

                        <br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Enrollment No</th>
                                    <th>Student Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="itemContainer">
                                <?php if (!empty($attendance_date)) : ?>
                                    <?php if (!empty($markedAttendance) && is_array($markedAttendance)) : ?>
                                        <?php $i = 1; ?>
                                        <?php foreach ($markedAttendance as $student) : ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= isset($student['enrollment_no']) ? htmlspecialchars($student['enrollment_no']) : 'N/A' ?></td>
                                                <td><?= isset($student['first_name']) ? htmlspecialchars($student['first_name']) : 'N/A' ?></td>
                                                <td>

                                                    <span class="badge-custom badge-marked">Marked</span>

                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="3" class="text-center">No attendance records found for the selected date.</td>
                                        </tr>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Please select a date to view attendance records.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="pagination-container text-center">
                            <?= isset($pagination_links) ? $pagination_links : '' ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>