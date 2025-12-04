<style>
    .bgdynamic {
        background: linear-gradient(44deg, #59b9f3, rgb(207 148 247), #edd6ff, #e0d3f9, #7aceff);
        background-size: 400% 400%;
        animation: gradientBackground 25s ease infinite;
    }

    @keyframes gradientBackground {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }
</style>


<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Exam Management</a></li>
        <li class="active"><a href="#">Payment Calculation</a></li>
    </ul>

    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Payment Calculation
            </h1>
        </div>
    </div>


    <div class="panel-heading">
        <form id="filterForm" action="<?= base_url('EcrRenumerationController/payment') ?>" method="get">
        <div class="row">
                <div class="col-sm-2">
                    <select name="exam_id" class="form-control" onchange="submitForm()" required>
                        <option value="">Select Exam Session</option>
                        <?php foreach ($exam_sessions as $session): ?>
                            <option value="<?= $session['exam_id'] ?>" <?= isset($_GET['exam_id']) && $_GET['exam_id'] == $session['exam_id'] ? 'selected' : '' ?>>
                                <?= $session['exam_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-sm-2">
                    <select name="role_id" class="form-control" onchange="submitForm()" required>
                        <option value="">Select Role</option>
                        <?php foreach ($ecr_roles as $role): ?>
                            <option value="<?= $role['ecr_role_id'] ?>" <?= isset($_GET['role_id']) && $_GET['role_id'] == $role['ecr_role_id'] ? 'selected' : '' ?>>
                                <?= $role['role_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Employee Dropdown with All Option -->
                <div class="col-sm-2">
                    <select name="employee_id" class="form-control" onchange="submitForm()">
                        <option value="">Select Employee</option>
                        <option value="">All</option>
                        <?php if (!empty($employees)): ?>
                            <?php foreach ($employees as $employee): ?>
                                <option value="<?= $employee['emp_id'] ?>" <?= isset($_GET['employee_id']) && $_GET['employee_id'] == $employee['emp_id'] ? 'selected' : '' ?>>
                                    <?= $employee['emp_id'] ?> - <?= $employee['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                </div>
        </form>
    </div>


    <!-- Employee Payment Listing -->
    <div class="row">
        <div class="col-sm-12">
                <div class="panel-heading">
                    <span class="panel-title">Employee Payment List</span>
                </div>

                <div class="panel-body" style="overflow:scroll;height:800px;">
                    <?php
                    $total_payment = 0;
                    ?>

                    <table class="table table-bordered" id="datatable">
                        <thead class="bgdynamic">
                            <tr>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Date</th>
                                <th>Attendance</th>
                                <th>Session</th>
                                <th>Remuneration per Day</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($employee_payments)): ?>
                                <?php foreach ($employee_payments as $employee): ?>
                                    <tr>
                                        <td><?= $employee['emp_id'] ?></td>
                                        <td><?= $employee['name'] ?></td>
                                        <td><?= $employee['date'] ?></td>
                                        <td><?= $employee['attendance'] ?></td>
                                        <td><?= $employee['session'] ?></td>
                                        <!-- <td><?= $employee['renum'] ?></td> -->
                                        <td><?= $employee['payment'] ?></td>
                                    </tr>
                                    <?php $total_payment += $employee['payment']; // Add payment to total 
                                    $Extra_ssn = $employee['additional_ssn_count'] * $employee['renum'];
                                    ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right;"><strong>Extra Session Payment:</strong></td>
                    <td><?= $Extra_ssn ?></td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: left;"><strong>Grand Total:</strong></td>
                    <td><strong><?= $total_payment = $total_payment + $Extra_ssn ?></strong></td>
                </tr>
            </tfoot>
                    </table>

                </div>
        </div>
    </div>
</div>

<script>
    function submitForm() {
        document.getElementById('filterForm').submit();
    }
    //datatable
    $(document).ready(function() {
        $('#datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                },
            ]
        });
    });
</script>