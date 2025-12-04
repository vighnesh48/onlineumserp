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
        <li class="active"><a href="<?= base_url($currentModule) ?>">Hostel </a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Hostel Student Clearence List</h1>

             <div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;"  href="javascript:void(0);" data-toggle="modal" data-target="#addClearanceModal" class="btn btn-primary btn-labeled" ><span class="btn-label icon fa fa-plus"></span> Add Clearance </a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                
                </div>
            </div>
<!-- Modal -->
<div class="modal fade" id="addClearanceModal" tabindex="-1" role="dialog" aria-labelledby="addClearanceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="<?= base_url('hostel/student_clearance_view') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClearanceModalLabel">Add Student Hostel Clearance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="enrollment_no">Enrollment No</label>
                        <input type="text" class="form-control" name="enrollment_no" id="enrollment_no" required>
                    </div>
                    <!-- You can add more fields here if needed -->
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Proceed</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

            <span id="flash-messages" style="color:Green;padding-left:50px;">
                <?php if (!empty($this->session->flashdata('message1'))) {
                    echo $this->session->flashdata('message1');
                } ?></span>
            <span id="flash-messages" style="color:red;padding-left:50px;">
                <?php if (!empty($this->session->flashdata('message2'))) {
                    echo $this->session->flashdata('message2');
                } ?></span>
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
					     <form method="get" action="<?= base_url($currentModule . '/clearance_list') ?>" class="form-inline" style="margin-bottom: 15px;">
							<div class="form-group">
								<label for="academic_year">Academic Year:</label>
								<select name="academic_year" id="academic_year" class="form-control select2" style="width: 200px;">
									<option value="">All</option>
									<?php
										$startYear = 2025;
										$endYear = date('Y');
										for ($year = $startYear; $year <= $endYear; $year++) {
											$selected = ($this->input->get('academic_year') == $year) ? 'selected' : '';
											echo "<option value='$year' $selected>$year</option>";
										}
									?>
								</select>
							</div>
							<button type="submit" class="btn btn-sm btn-primary">Search</button>
						</form>

                        <span class="panel-title"></span>
                    </div>
                    <div class="panel-body" style="overflow-x:scroll;height:500px;">
                        <div class="table-info">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Enrollment No</th>
                                        <th>Student Name</th>
                                        <th>School</th>
                                        <th>Course</th>
                                        <th>Stream</th>
                                        <th>Academic year</th>
                                        <th>Hostel No</th>
                                        <th>Room No</th>
                                        <th>Date of Joining</th>
                                        <th>Date of Leaving</th>
                                        <th>Damage Identified</th>
                                        <th>Rector Remark</th>
                                        <th>Status</th>
                                        <th>Cleared On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($clearance_list)): ?>
                                        <?php $count = 1; ?>
                                        <?php foreach ($clearance_list as $row): ?>
                                            <tr>
                                                <td><?= $count++ ?></td>
                                                <td><?= htmlspecialchars($row['enrollment_no']) ?></td>
                                                <td><?= htmlspecialchars($row['student_name']) ?></td>
                                                <td><?= htmlspecialchars($row['school_name']) ?></td>
                                                <td><?= htmlspecialchars($row['course_name']) ?></td>
                                                <td><?= htmlspecialchars($row['stream_name']) ?></td>
                                                <td><?= htmlspecialchars($row['academic_year']) ?></td>
                                                <td><?= htmlspecialchars($row['hostel_no']) ?></td>
                                                <td><?= htmlspecialchars($row['room_no']) ?></td>
                                                <td><?= date('d-m-Y', strtotime($row['date_of_joining'])) ?></td>
                                                <td><?= date('d-m-Y', strtotime($row['date_of_leaving'])) ?></td>
                                                <td><?= htmlspecialchars($row['damage_identified']) ?></td>
                                                <td><?= htmlspecialchars($row['hostel_rector_remark']) ?></td>
                                                <td><?= htmlspecialchars($row['clearance_status']) ?></td>
                                                <td><?= !empty($row['cleared_on']) ? date('d-m-Y H:i:s', strtotime($row['cleared_on'])) : '' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="11" class="text-center">No hostel clearance records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>