
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

    .modal-body {
        padding: 20px;
    }

    .form-control {
        margin-bottom: 15px;
    }
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Exam Management</a></li>
        <li class="active"><a href="#">Consolidated Payment list</a></li>
    </ul>

    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Consolidated Employee Payment list
            </h1>
        </div>
    </div>


                <div class="panel-heading">
                    <form id="filterForm" action="<?= base_url('EcrRenumerationController/consolidated_renum_view') ?>" method="get">
                        <div class="row">
                            <!-- Exam Session Dropdown -->
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

                            <!-- Role Dropdown -->
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
                        </div>
                    </form>
					<?php
					  $exam_id = $this->input->get('exam_id');
					  $role_id = $this->input->get('role_id');
					?>
					<div class="text-right" style="margin:10px 0;">
					  <a class="btn btn-danger" target="_blank"
						 href="<?= base_url('EcrRenumerationController/export_consolidated_pdf?exam_id=' . urlencode($exam_id) . '&role_id=' . urlencode($role_id)) ?>">
						<i class="fa fa-file-pdf-o"></i> Download PDF
					  </a>
					  <a class="btn btn-success" target="_blank"
						 href="<?= base_url('EcrRenumerationController/export_consolidated_excel?exam_id=' . urlencode($exam_id) . '&role_id=' . urlencode($role_id)) ?>">
						<i class="fa fa-file-excel-o"></i> Download Excel
					  </a>
					</div>

                </div>


    <!-- Consolidated Payment Report -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Consolidated Payment List</span>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered" id="datatable">
                        <thead class="bgdynamic">
                            <tr>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Total Present Sessions</th>
                                <th>Remuneration per Session</th>
                                <th>Total Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($consolidated_payments)): ?>
                                <?php foreach ($consolidated_payments as $employee): ?>
                                    <tr>
                                        <td><?= $employee['effective_emp_id'] ?></td>
                                        <td><?= $employee['name'] ?></td>
                                        <td><?= $employee['total_present_sessions'] ?></td>
                                        <td><?= $employee['renum'] ?></td>
                                        <td>
                                            <a href="<?= base_url('EcrRenumerationController/payment') . '?exam_id=' . $employee['exam_id'] . '&role_id=' . $employee['duety_name'] . '&employee_id=' . $employee['effective_emp_id'] ?>" target="_blank">
                                                <?= $employee['total_payment'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
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
            buttons: []
        });
    });
</script>
