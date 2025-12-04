<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?= base_url($currentModule) ?>">Hostel </a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i
                    class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Cancel List</h1>

            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>

        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Cancel List</span>

                        <form method="POST" action="<?= base_url($currentModule . '/list_facility_cancel') ?>">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="from_date">From Date</label>
                                    <input type="date" name="from_date" id="from_date" class="form-control"
                                        value="<?= set_value('from_date') ?>" />
                                </div>
                                <div class="col-md-3">
                                    <label for="to_date">To Date</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control"
                                        value="<?= set_value('to_date') ?>" />
                                </div>
                                <div class="col-md-3">
                                    <label for="academic_year">Academic Year</label>
                                    <select name="academic_year" id="academic_year" class="form-control select2"
                                        required>
                                        <option value="">Select Academic Year</option>
                                        <?php foreach ($academic_years as $year): ?>
                                            <option value="<?= $year['session'] ?>" <?= set_select('academic_year', $year['session']) ?>>
                                                <?= $year['academic_year'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3" style="margin-top: 25px;">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="panel-body" style="overflow-x:scroll;height:500px;">
                        <div class="table-info">
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Enrollment No</th>
                                        <th>Punching PRN</th>
                                        <th>Student Name</th>
                                        <th>Organisation</th>
                                        <th>Academic Year</th>
                                        <th>Refund Amount</th>
                                        <th>Cancel Charges</th>
                                        <th>Cancel Date</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($cancel_details)) {
                                        $i = 1;
                                        foreach ($cancel_details as $detail) {
                                            // Check if student name exists in the sf_student_master table
                                            $student_name = !empty($detail->sf_first_name) ?
                                                $detail->sf_first_name . ' ' . $detail->sf_middle_name . ' ' . $detail->sf_last_name :
                                                $detail->ums_first_name . ' ' . $detail->ums_middle_name . ' ' . $detail->ums_last_name;
                                            ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $detail->enrollment_no; ?></td>
                                                <td><?php if($detail->organisation=='SU'){ echo $detail->punching_prn;}else{ echo $detail->enrollment_no;} ?></td>
                                                <td><?= $student_name; ?></td>
                                                <td><?= $detail->organisation; ?></td>
                                                <td><?= $detail->academic_year; ?></td>
                                                <td><?= $detail->refund_amount; ?></td>
                                                <td><?= $detail->cancel_charges; ?></td>
                                                <td><?= $detail->can_date; ?></td>
                                                <td><?= $detail->remark; ?></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="6">No data found</td>
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


<script>
$(document).ready(function() {
    $('.select2').select2();
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Cancel List'
            }
        ]
    });
});
</script>