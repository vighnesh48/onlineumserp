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

    .glowing-border-button {
        border: 2px solid transparent;
        border-radius: 4px;
        transition: transform 0.3s, box-shadow 0.3s;
        /* animation: pulse 1s infinite; */
        transform: translateY(0) scale(1.0);
        /* Reset scale and translation to normal */
    }

    .glowing-border-button:hover {
        box-shadow: 0 8px 8px lightskyblue;
        transform: translateY(-2px) scale(1.05);
    }


    .glowing-border-button {
        box-shadow: 0 8px 8px lightskyblue;
        border-color: #007bff;
    }

    .glowing-border-button:hover {
        box-shadow: 0 8px 8px lightskyblue;
        border-color: blueviolet;
        /* More noticeable blue color on hover */
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1.0);
            box-shadow: 0 8px 8px rgba(0, 123, 255, 0.7);
        }

        50% {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 123, 255, 1);
        }
    }
</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Exam Management</a></li>
        <li class="active"><a href="#">Payment Calculation by Session & Date</a></li>
    </ul>

    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Payment Calculation
            </h1>
        </div>
    </div>

    <div class="panel-heading">
        <form id="filterForm" action="<?= base_url('EcrRenumerationController/paymentSessionDate') ?>" method="get">
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
                    <select name="center_id" class="form-control" onchange="submitForm()" required>
                        <option value="">Select Exam Session</option>
                        <?php foreach ($exam_centers as $center): ?>
                            <option value="<?= $center->ec_id ?>" <?= isset($_GET['center_id']) && $_GET['center_id'] == $center->ec_id ? 'selected' : '' ?>>
                                <?= $center->center_name ?> (<?= $center->center_code ?>)
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

                <div class="col-sm-2">
                    <input type="date" name="date" class="form-control"
                        value="<?= isset($_GET['date']) ? $_GET['date'] : '' ?>" onchange="submitForm()"
                        placeholder="Select Date">
                </div>

                <div class="col-sm-2">
                    <select name="session" class="form-control" onchange="submitForm()">
                        <option value="">Select Session</option>
                        <option value="FN" <?= isset($_GET['session']) && $_GET['session'] == 'FN' ? 'selected' : '' ?>>
                            Forenoon</option>
                        <option value="AN" <?= isset($_GET['session']) && $_GET['session'] == 'AN' ? 'selected' : '' ?>>
                            Afternoon</option>
                        <option value="BOTH" <?= isset($_GET['session']) && $_GET['session'] == 'BOTH' ? 'selected' : '' ?>>Both</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-sm-3 text-center">
            <a href="<?= base_url('EcrRenumerationController/downloadEmployeePaymentPDF') ?>?exam_id=<?= $this->input->get('exam_id') ?>&role_id=<?= $this->input->get('role_id') ?>&date=<?= $this->input->get('date') ?>&session=<?= $this->input->get('session') ?>&center_id=<?= $this->input->get('center_id') ?>"
                class="btn glowing-border-button" style="margin-top: 15px;">
                DATE AND SESSION WISE ACQUITTANCE REPORT
            </a>
        </div>
        <div class="col-sm-3 text-left">
            <a href="<?= base_url('EcrRenumerationController/downloadRoleWisePaymentPDF') ?>?exam_id=<?= $this->input->get('exam_id') ?>&date=<?= $this->input->get('date') ?>&session=<?= $this->input->get('session') ?>&center_id=<?= $this->input->get('center_id') ?>"
                class="btn glowing-border-button" style="margin-top: 15px;">
                ROLE WISE TOTAL PAYMENT REPORT
            </a>
        </div>
    </div>
    <br>
    <!-- Employee Payment Listing -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-heading">
                <span class="panel-title">Employee Payment List</span>
            </div>

            <div class="panel-body" style="overflow:scroll;height:800px;">
                <?php $total_payment = 0; ?>

                <table class="table table-bordered" id="datatable">
                    <thead class="bgdynamic">
                        <tr>
                            <th>Sr.No.</th>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Remuneration per Day</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($employee_payments)): ?>
                            <?php $i = 1;
                            foreach ($employee_payments as $employee): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $employee['emp_id'] ?></td>
                                    <td><?= $employee['name'] ?></td>
                                    <td><?= $employee['payment'] ?></td>
                                </tr>
                                <?php $total_payment += $employee['payment'];
                                $Extra_ssn = $employee['additional_ssn_count'] * $employee['renum'];
                                ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No records found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Extra Session Payment :</strong></td>
                            <td><?= $Extra_ssn ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: left;"><strong>Grand Total:</strong></td>
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
    $(document).ready(function () {
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