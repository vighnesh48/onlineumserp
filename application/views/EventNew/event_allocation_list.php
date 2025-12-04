<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?= base_url($currentModule) ?>">Event</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Eventss Allocation List
            </h1>
        </div>
        <div class="pull-right col-xs-12 col-sm-auto">
            <form method="POST" action="<?= base_url('Event/event_allocation/' . base64_encode($event_allocation_list[0]['id'] ?? '')); ?>">
                <button type="submit" class="btn btn-primary btn-labeled">
                    <span class="btn-label icon fa fa-plus"></span>Add
                </button>
            </form> <br>
            <a href="<?= base_url('Event'); ?>" class="btn btn-primary btn-labeled">
                <span class="btn-label icon fa fa-arrow-left"></span>Back
            </a>
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
                    setTimeout(() => successBox.innerHTML = '', 500); // clear after fade
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
                <div class="panel-heading">
                    <span class="panel-title">Event Allocation List</span>
                </div>

                <div class="panel-body" style="overflow-x:scroll;height:500px;">
                    <div class="table-info">
                        <form method="GET" action="<?= base_url('Event/event_allocation_list/' . base64_encode($event_allocation_list[0]['id'] ?? '')); ?>">
                            <div class="row">
                                <div class="col-md-1">
                                    <select name="limit" class="form-control" onchange="this.form.submit()">
                                        <option value="10" <?= isset($limit) && $limit == 10 ? 'selected' : '' ?>>10 rows</option>
                                        <option value="25" <?= isset($limit) && $limit == 25 ? 'selected' : '' ?>>25 rows</option>
                                        <option value="50" <?= isset($limit) && $limit == 50 ? 'selected' : '' ?>>50 rows</option>
                                        <option value="100" <?= isset($limit) && $limit == 100 ? 'selected' : '' ?>>100 rows</option>
                                    </select>
                                </div>
                                <div class="col-md-8"></div>
                                <div class="col-md-2">
                                    <input type="text" name="search" class="form-control" placeholder="Search..." onchange="this.form.submit()" value="<?= isset($search) ? $search : '' ?>">
                                </div>

                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>

                        <br>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Event Name</th>
                                    <th>Organised By</th>
                                    <th>School Name</th>
                                    <th>Course Name</th>
                                    <th>Stream Name</th>
                                    <th>Division</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="itemContainer">
                                <?php if (!empty($event_allocation_list) && isset($event_allocation_list[0]['event_allocation_id'])) : ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($event_allocation_list as $event) : ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($event['event_name']) ?></td>
                                            <td><?= htmlspecialchars($event['organised_by']) ?></td>
                                            <td><?= htmlspecialchars($event['school_name']) ?></td>
                                            <td><?= htmlspecialchars($event['course_name']) ?></td>
                                            <td><?= htmlspecialchars($event['stream_name']) ?></td>
                                            <td><?= htmlspecialchars($event['division']) ?></td>
                                            <td><?= date('j-M-Y', strtotime($event['from_date'])) ?></td>
                                            <td><?= date('j-M-Y', strtotime($event['to_date'])) ?></td>

                                            <td>
                                                <a href="<?= base_url('Event/upload_attendance/' . base64_encode($event['event_allocation_id'])) ?>" title="Upload Event Attendance">
                                                    <i class="fa fa-user"></i>
                                                    Upload Attendance
                                                </a>
                                                |
                                                <?php if (!empty($event['attendance_exists'])) : ?>
                                                    <a href="<?= base_url('Event/view_uploaded_attendance/' . base64_encode($event['event_allocation_id'])) ?>" title="View Event Attendance">
                                                        <i class="fa fa-list"></i> View Attendance
                                                    </a>
                                                <?php else : ?>
                                                    <span style="color: gray; cursor: not-allowed;" title="Attendance not uploaded">
                                                        <i class="fa fa-ban"></i> View Attendance
                                                    </span>
                                                <?php endif; ?>

                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="10" class="text-center">No events found.</td>
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