<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECR Employee Registration</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrapValidator.min.css'); ?>">

    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrapValidator.min.js'); ?>"></script>
</head>

<body>
    <div id="content-wrapper">
        <ul class="breadcrumb breadcrumb-page">
            <div class="breadcrumb-label text-light-gray">You are here: </div>
            <li class="active"><a href="#">Examination</a></li>
            <li class="active"><a href="#">ECR Employee Registration Form</a></li>
        </ul>
        <div class="page-header">
            <div class="row">
                <h1 class="col-xs-12 col-sm-4 text-left-sm"><i
                        class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;ECR Employee Registration Form</h1>
                <div class="col-xs-12 col-sm-8">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title">
                            </span>
                        </div>
                        <div class="panel-body" style="overflow:scroll;height:800px;">
                            <div class="col-lg-12">
                                <form id="ecrEmployeeForm"
                                    action="<?php echo base_url('EcrEmpRegController/addEcrEmployee'); ?>"
                                    method="post">

                                    <!-- Exam Session -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Exam Session <span
                                                class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="exam_id" id="exam_id" class="form-control" required>
                                                <option value="">Select Exam Session</option>
                                                <?php foreach ($exam_sessions as $session): ?>
                                                    <option value="<?= $session->exam_id ?>"><?= $session->exam_name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Exam Center -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Exam Center <span
                                                class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="center_id" id="center_id" class="form-control" required>
                                                <option value="">Select Exam Center</option>
                                                <option value="0">All Exam Center</option>
                                                <?php foreach ($exam_centers as $center): ?>
                                                    <option value="<?= $center->ec_id ?>"><?= $center->center_name ?>
                                                        (<?= $center->center_code ?>)</option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- School -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">School <span
                                                class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="school_id" id="school_id" class="form-control" required>
                                                <option value="">Select School</option>
                                                <option value="0">All School</option>
                                                <?php foreach ($schools as $school): ?>
                                                    <option value="<?= $school->school_id ?>">
                                                        <?= $school->school_short_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- ECR Role -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">ECR Role <span
                                                class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="ecr_role_id" id="ecr_role_id" class="form-control" required>
                                                <option value="">Select ECR Role</option>
                                                <?php foreach ($ecr_roles as $role): ?>
                                                    <option value="<?= $role->ecr_role_id ?>"><?= $role->role_name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Search Employee -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Search Employee by Employee ID <span
                                                class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="employee_id" id="employee_id" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-primary"
                                                onclick="searchEmployee()">Search</button>
                                        </div>
                                    </div>

                                    <!-- Employee Name -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Employee Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="name" id="name" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-6">
                                            <input type="email" name="email" id="email" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <!-- Mobile -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Mobile</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="mobile" id="mobile" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group">
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-2">
                                            <button type="submit" class="btn btn-primary form-control">Submit</button>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-secondary form-control"
                                                onclick="window.location='<?= base_url('EcrEmpRegController') ?>'">Cancel</button>
                                        </div>
                                        <div class="col-sm-4"></div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript function to search employee -->
    <script>
        function searchEmployee() {
            var employee_id = $('#employee_id').val();
            if (employee_id) {
                $.ajax({
                    url: '<?php echo base_url() . 'EcrEmpRegController/searchEmployee'; ?>',
                    type: 'POST',
                    data: { employee_id: employee_id },
                    dataType: 'json',
                    success: function (data) {
                        if (data) {
                            $('#name').val(data.name);
                            $('#email').val(data.email || data.email);
                            $('#mobile').val(data.mobile || data.mobile);
                        } else {
                            alert('Employee not found');
                        }
                    },
                    error: function () {
                        alert('Error searching employee');
                    }
                });
            } else {
                alert('Please enter an Employee ID');
            }
        }
    </script>
</body>

</html>