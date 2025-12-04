<style>
    body {
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }
</style>

<div id="content-wrapper">
    <!-- Breadcrumb -->
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Reports</a></li>
        <li class="active"><a href="#">Faculty Attendance Report</a></li>
    </ul>

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Faculty Attendance Report
            </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="pull-right">
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-heading">
            <form method="POST" action="<?= base_url('erp_cron_attendance/faculty_monthly_report') ?>">
                <label>From Date:</label>
                <input type="date" name="from_date" value="<?= isset($from_date) ? $from_date : date('Y-m-01'); ?>" required>
                
                <label>To Date:</label>
                <input type="date" name="to_date" value="<?= isset($to_date) ? $to_date : date('Y-m-t'); ?>" required>
                
                <button type="submit" name="submit">Generate Report</button>
            </form>
        </div>
        <div id="show_list" class="panel-body" style="overflow-x:scroll;height:550px;">
            <?php if (!empty($report_data)): ?>
                <div class="table-info">

                    <table class="table table-bordered" style="width:100%;max-width:100%;" id="datatable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Faculty Name</th>
                                <th>Total TH Load Assigned</th>
                                <th>TH Taken</th>
                                <th>TH Taken Avg. %</th>
                                <th>Prev Month TH Taken Avg. %</th>
                                <th>TH Student Present Avg. %</th>
                                <th>Prev Month Student Present Avg. %</th>
                                <th>Total PR Load Assigned</th>
                                <th>PR Taken</th>
                                <th>PR Taken Avg %</th>
                                <th>Prev Month PR Taken Avg. %</th>
                                <th>PR Student Present Avg. %</th>
                                <th>Prev Month Student Present Avg. %</th>
                                <th>Monthly Leaves</th>
                                <th>Cummu. Leave (Summer <?= ADMISSION_SESSION; ?>)</th>
                                <th>Monthly OD's</th>
                                <th>Cummu. OD's (Summer <?= ADMISSION_SESSION; ?>)</th>
                                <th>Additional Load Taken</th>
                                <th>Additional Load Student Present Avg. %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sr_no = 1;
                            foreach ($report_data as $faculty):

							?>
                                <tr>
                                    <td><?= $sr_no++; ?></td>
                                    <td><?= $faculty['faculty_code'] . '-' . $faculty['faculty_name']; ?> (<?= $faculty['designation']; ?>)</td>
                                    <td><?= $faculty['total_TH_load']; ?></td>
                                    <td><?= $faculty['TH_taken']; ?></td>
                                    <td><?= $faculty['TH_percentage']; ?>%</td>
                                    <td><?= $faculty['prev_TH_percentage']; ?>%</td>
                                    <td><?= $faculty['TH_attendance_percentage']; ?>%</td>
                                    <td><?= $faculty['prev_TH_attendance_percentage']; ?>%</td>
                                    <td><?= $faculty['total_PR_load']; ?></td>
                                    <td><?= $faculty['PR_taken']; ?></td>
                                    <td><?= $faculty['PR_percentage']; ?>%</td>
                                    <td><?= $faculty['prev_PR_percentage']; ?>%</td>
                                    <td><?= $faculty['PR_attendance_percentage']; ?>%</td>
                                    <td><?= $faculty['prev_PR_attendance_percentage']; ?>%</td>
                                    <td><?= $faculty['month_leave']; ?></td>
                                    <td><?= $faculty['cumm_leave']; ?></td>
                                    <td><?= $faculty['month_OD']; ?></td>
                                    <td><?= $faculty['cumm_OD']; ?></td>
                                    <td><?= $faculty['additional_load_taken']; ?></td>
                                    <td><?= $faculty['additional_load_student_attendance_avg']; ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <!-- ✅ PDF Download Button -->
            <form method="POST" action="<?= base_url('erp_cron_attendance/faculty_monthly_report_pdf') ?>" target="_blank">
                <input type="hidden" name="from_date" value="<?= $from_date; ?>">
                <input type="hidden" name="to_date" value="<?= $to_date; ?>">
                <button type="submit">Download PDF</button>
            </form>
            <?php else: ?>
                <p>No data available for the selected date range.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
        $('#datatable').DataTable({
        dom: 'Bfrtip',
        buttons: []
    });
</script>