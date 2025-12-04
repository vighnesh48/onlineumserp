<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<?php //print_r($my_privileges); die; 
?>


<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?= base_url($currentModule) ?>">Event</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Events</h1>

            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?= base_url($currentModule . "/add_event") ?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>

            <span id="flash-messages" style="color:Green;padding-left:50px;">
                <?php if (!empty($this->session->flashdata('message_event_success'))) {
                    echo $this->session->flashdata('message_event_success');
                } ?></span>
            <span id="flash-messages" style="color:red;padding-left:50px;">
                <?php if (!empty($this->session->flashdata('message_event_error'))) {
                    echo $this->session->flashdata('message_event_error');
                } ?></span>

        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Event Attendance</span>
                    </div>
                    <div class="panel-body" style="">
                        <div class="table-info">
                            <form id="searchForm" method="GET" action="<?= base_url('Event/attendance_list'); ?>">
                                <div class="row align-items-center justify-content-between">
                                    <!-- Per Page Row Limit Dropdown (Left) -->
                                    <div class="col-md-1">
                                        <label for="limit" class="font-weight-bold">Rows per page:</label>
                                        <select name="limit" class="form-control" onchange="this.form.submit()">
                                            <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                                            <option value="25" <?= $limit == 25 ? 'selected' : '' ?>>25</option>
                                            <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
                                            <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100</option>
                                            <option value="250" <?= $limit == 250 ? 'selected' : '' ?>>250</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8"></div>

                                    <!-- Search Input (Right) -->
                                    <div class="col-md-3 d-flex justify-content-end">
                                        <label for="limit" class="font-weight-bold">Search:</label>

                                        <input type="text" name="search" class="form-control" placeholder="Search..."
                                            value="<?= isset($search) ? $search : '' ?>"
                                            oninput="document.getElementById('searchForm').submit();">
                                    </div>
                                </div>
                            </form>

                            <br>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Enrollment No</th>
                                        <th>First Name</th>
                                        <th>Event Name</th>
                                        <th>Event Date</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <?php if (!empty($attendance)) : ?>
                                        <?php $i = $offset + 1;
                                        foreach ($attendance as $row) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= htmlspecialchars($row['enrollment_no']); ?></td>
                                                <td><?= htmlspecialchars($row['first_name']); ?></td>
                                                <td><?= htmlspecialchars($row['event_name']); ?></td>
                                                <td><?= htmlspecialchars($row['event_date']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No attendance records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <div class="pagination-container text-center">
                                <?= $pagination_links ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>