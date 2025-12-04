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
        </div>

        <div class="row ">
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
                        <span class="panel-title">Event Details</span>
                    </div>

                    <div class="panel-body" style="overflow-x:scroll;height:500px;">
                        <div class="table-info">
                            <form method="GET" action="<?= base_url('Event/index'); ?>">
                                <div class="row">
                                    <div class="col-md-1">
                                        <select name="limit" class="form-control" onchange="this.form.submit()">
                                            <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10 rows</option>
                                            <option value="25" <?= $limit == 25 ? 'selected' : '' ?>>25 rows</option>
                                            <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50 rows</option>
                                            <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100 rows</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">

                                    </div>
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
                                        <th>Academic Year</th>
                                        <th>School</th>
                                        <th>Course</th>
                                        <th>Stream</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Address</th>
                                        <th>Description</th>
                                        <th>Event File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <?php if (!empty($events)) : ?>
                                        <?php $i = 1 + ($limit * ($this->uri->segment(3) ? $this->uri->segment(3) : 0)); ?>
                                        <?php foreach ($events as $event) : ?>
                                            <tr>
                                                <?php if ($event['status'] == 'Y') : ?>
                                                    <td><?= $i ?></td>
                                                    <td><?= $event['event_name'] ?></td>
                                                    <td><?= $event['organised_by'] ?></td>
                                                    <td><?= $event['academic_year'] ?></td>
                                                    <td><?= $event['school_name'] ?></td>
                                                    <td><?= $event['course_short_name'] ?></td>
                                                    <td><?= $event['stream_name'] ?></td>
                                                    <td><?= date('j-M-Y', strtotime($event['start_date'])) ?></td>
                                                    <td><?= date('j-M-Y', strtotime($event['end_date'])) ?></td>
                                                    <td><?= $event['start_time'] ?></td>
                                                    <td><?= $event['end_time'] ?></td>
                                                    <td><?= $event['event_address'] ?></td>
                                                    <td><?= $event['event_description'] ?></td>
                                                    <?php
                                                    $b_name = "uploads/events/";
                                                    $doc_url = (!empty($event['file_name']))
                                                        ? base_url() . "Upload/download_s3file/" . $event['file_name'] . '?b_name=' . $b_name
                                                        : '';
                                                    ?>

                                                    <td>
                                                        <?php if (!empty($event['file_name'])) : ?>
                                                            <a href="<?= $doc_url ?>" target="_blank"><i class="fa fa-eye"></i></a>
                                                        <?php else : ?>
                                                            <span style="color: red;">No File Uploaded</span>
                                                        <?php endif; ?>
                                                    </td>

                                                     <td>
                                                    <?php if (empty($event['file_name'])) { ?>
                                                        <a href="<?= base_url($currentModule . "/upload_event_photos/" . base64_encode($event['id'])) ?>" title="Upload Pdf File"><i class="fa fa-upload"></i> |</a>
                                                    <?php } ?>

                                                    <a href="<?= base_url($currentModule . "/event_allocation_list/" . base64_encode($event['id'])) ?>" title="Event Allocation and listing"><i class="fa fa-list"></i> Event Allocation & List</a>

                                                </td>
                                                <?php endif; ?>

                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="11" class="text-center">No events found.</td>
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