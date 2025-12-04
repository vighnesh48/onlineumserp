<script src="<?= site_url() ?>assets/javascripts/jquery.min.js"></script>
<script src="<?= site_url() ?>assets/javascripts/bootstrap.min.js"></script>

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
    transform: translateY(0) scale(1.0); /* Reset scale and translation to normal */
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
    border-color: blueviolet; /* More noticeable blue color on hover */
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1.0);
        box-shadow: 0 8px 8px rgba(0, 123, 255, 0.7);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 123, 255, 1);
    }
}

</style>

<script>
    $(document).ready(function () {
        // Function to show/hide columns based on selected view option
        $('input[name="view_option"]').on('change', function () {
            var selectedOption = $('input[name="view_option"]:checked').val();

            if (selectedOption === 'attendance') {
                $('.checkbox-column').show();
                $('.attendance-column, .update-attendance-btn').show();
                $('.action-column').hide();
                $('.update-attendance-btn').show();
            }

            // Update the panel title based on selected option
            let title = selectedOption === 'attendance' ? 'Mark Attendance' :
                selectedOption === 'replace' ? 'Replace Employee' : 'Appointment Order';
            $('.panel-title').text(title + ' List');
        });

        // Initialize default view based on attendance option
        $('input[name="view_option"][value="attendance"]').prop('checked', true).trigger('change');
    });
</script>

<script>

    function openReplaceModal(empId, allocationId) {
        $('#allocation_id').val(allocationId);
        $('#replaceEmployeeModal').modal('show');
    }

    $(document).ready(function () {
        // Flag to track if search was successful
        let searchPerformed = false;

        // Submit form when date or role is selected
        $('#filter_date, #filter_role, #filter_exam, #filter_center, #session').on('change', function () {
            $('#filterForm').submit();
        });

        // Check/uncheck all checkboxes
        /*       $('#check_all').on('change', function () {
                   $('.attendance-checkbox').prop('checked', $(this).prop('checked'));
               });
       
               Uncheck "Check All" if any individual checkbox is unchecked
               $('.attendance-checkbox').on('change', function () {
                   if (!$(this).prop('checked')) {
                       $('#check_all').prop('checked', false);
                   }
               });
       */
        $('#check_all').on('change', function () {
            var isChecked = $(this).prop('checked');
            $('.attendance-checkbox').prop('checked', isChecked).trigger('change');
        });

        // Update hidden input value based on individual checkbox state
        $('.attendance-checkbox').on('change', function () {
            var isChecked = $(this).prop('checked');
            var hiddenInput = $(this).siblings('input[type="hidden"]'); // The hidden input next to the checkbox

            // Set hidden input value based on checkbox state
            hiddenInput.val(isChecked ? 'P' : 'A');

            // Uncheck "Check All" if any individual checkbox is unchecked
            if (!isChecked) {
                $('#check_all').prop('checked', false);
            }
        });
        // Disable form submission if the name field is empty
        $('#replaceEmployeeForm').on('submit', function (event) {
            var name = $('#replace_name').val();
            if (name === '' || !searchPerformed) {
                alert('Please search for an employee and ensure the name field is populated before submitting.');
                event.preventDefault(); // Prevent form submission
            }
        });

        function searchEmployee() {
            var employee_id = $('#replace_employee_id').val();
            var exam_id = $('#exam_id').val();
            if (employee_id) {
                $.ajax({
                    url: '<?php echo base_url() . 'EcrEmpRegController/searchEmployeeFromEcr'; ?>',
                    type: 'POST',
                    data: { employee_id: employee_id, exam_id: exam_id },
                    dataType: 'json',
                    success: function (data) {
                        if (data) {
                            // Populate fields with the employee data
                            $('#replace_name').val(data.name);
                            $('#replace_email').val(data.email || data.email);
                            $('#replace_mobile').val(data.mobile || data.mobile);
                            searchPerformed = true; // Mark search as successful
                        } else {
                            alert('Employee not found');
                            searchPerformed = false; // Reset if search failed
                        }
                    },
                    error: function () {
                        alert('Error searching employee');
                        searchPerformed = false; // Reset if error occurred
                    }
                });
            } else {
                alert('Please enter an Employee ID');
                searchPerformed = false; // Reset if no Employee ID was entered
            }
        }

        // Expose searchEmployee globally to be called from button click
        window.searchEmployee = searchEmployee;

    });
            //datatable
            $(document).ready(function() {
        $('#datatable').DataTable({
            dom: 'Bfrtip',
            buttons: []
        });
    });
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Exam Management</a></li>
        <li class="active"><a href="#">Exam Attendance</a></li>
    </ul>

    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i
                    class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Exam Attendance</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <!-- <label><input type="radio" name="view_option" value="attendance" checked> Attendance</label> -->
            <!-- <label><input type="radio" name="view_option" value="replace"> Replace</label> -->
        </div>
    </div>
    <div class="panel-heading">
        <form id="filterForm" action="<?= base_url('EcrEmpRegController/duetyAllocationList') ?>" method="POST">
            <div class="row">
                <div class="col-sm-2">
                    <select name="filter_exam" id="filter_exam" class="form-control" required>
                        <option value="">Select Exam Session</option>
                        <?php foreach ($exam_sessions as $session): ?>
                            <option value="<?= $session->exam_id ?>" <?php if(isset($filter_exam) && $filter_exam == $session->exam_id ){ echo 'selected'; }if(isset($_GET['filter_exam']) && $_GET['filter_exam'] == $session->exam_id){ echo 'selected'; } ?>>
                                <?= $session->exam_name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-2">
                        <select name="filter_center" id="filter_center" class="form-control" required>
                            <option value="">Select Exam Center</option>
                            <?php foreach ($exam_centers as $center): ?>
                                <option value="<?= $center->ec_id ?>" <?php if(isset($filter_center) && $filter_center == $center->ec_id ){ echo 'selected'; }if(isset($_GET['filter_center']) && $_GET['filter_center'] == $center->ec_id){ echo 'selected'; } ?>>
                                <?= $center->center_name ?> (<?= $center->center_code ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <div class="col-sm-2">
                    <select id="filter_role" name="filter_role" class="form-control">
                        <option value="">Select Role</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role->ecr_role_id ?>" <?php if(isset($filter_role) && $filter_role == $role->ecr_role_id ){ echo 'selected'; }if(isset($_GET['filter_role']) && $_GET['filter_role'] == $role->ecr_role_id){ echo 'selected'; } ?>>
                                <?= $role->role_name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <input type="date" id="filter_date" name="filter_date" class="form-control"
                        value="<?= date('Y-m-d') ?>"
                        min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" readonly>
                </div>
                <div class="col-sm-2">
                    <select id="session"  name="session" class="form-control">
                        <option value="">Select Session</option>
                        <option value="FN" <?= isset($ssn) && $ssn == 'FN' ? 'selected' : '' ?>>
                            Forenoon</option>
                        <option value="AN" <?= isset($ssn) && $ssn == 'AN' ? 'selected' : '' ?>>
                            Afternoon</option>
                    </select>
                </div>
            </div>

        </form>
    </div>

    <!-- Table Panel -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-heading">
                <span class="panel-title">Mark Duty Atteandance</span>
            </div>
            <div class="panel-body" style="overflow:scroll;height:800px;">
                <form action="<?= base_url('EcrEmpRegController/updateAttendance') ?>" method="POST">
                    <input type="hidden" name="filter_date" value="<?= isset($filter_date) ? $filter_date : '' ?>">
                    <input type="hidden" name="filter_role" value="<?= isset($filter_role) ? $filter_role : '' ?>">
                    <input type="hidden" name="filter_exam" value="<?= isset($filter_exam) ? $filter_exam : '' ?>">
                    <input type="hidden" name="filter_center" value="<?= isset($filter_center) ? $filter_center : '' ?>">
                    <input type="hidden" name="session" value="<?= isset($ssn) ? $ssn : '' ?>">

                    <!-- Duty Allocation Table -->
                    <table class="table table-bordered" id="">
                        <thead class="bgdynamic">
                            <tr>
                                <th class="checkbox-column"><input type="checkbox" id="check_all"></th>
                                <th>Exam</th>                                           
                                <th>Employee ID</th>                                            
                                <th>Employee Name</th>                                          
                                <th>Date</th>                                           
                                <th>Session</th>                                            
                                <th>Duty Name</th>                                          
                                <th class="attendance-column">Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($duty_allocations)): ?>
                                <?php foreach ($duty_allocations as $allocation): ?>
                                    <tr>
                                        <!-- <td class="checkbox-column">
                                                <input type="checkbox" class="attendance-checkbox"
                                                    name="attendance_ids[<?= $allocation->id ?>]" value="P"
                                                    <?= $allocation->attendance == 'P' ? 'checked' : '' ?>>
                                                <input type="hidden" name="attendance_ida[<?= $allocation->id ?>]" value="A">
                                            </td> -->
                                        <td class="checkbox-column">
                                            <input type="checkbox" class="attendance-checkbox"
                                                name="attendance_ids[<?= $allocation->id ?>]" value="P"
                                                <?= $allocation->attendance == 'P' ? 'checked' : '' ?>>
                                            <!-- Hidden input for "A" default -->
                                            <input type="hidden" name="attendance_ida[<?= $allocation->id ?>]"
                                                value="<?= $allocation->attendance == 'P' ? 'P' : 'A' ?>">
                                        </td>
                                        <td><?= $allocation->exam_name ?>
                                            <input type="hidden" name="exam_id" id="exam_id"
                                                value="<?= $allocation->exam_id ?>">
                                        </td>
                                        <td><?php echo ($allocation->is_replaced == 1) ? $allocation->replace_emp_id : $allocation->emp_id; ?>
                                        </td>
                                        <td><?= $allocation->name ?></td>
                                        <td><?= date('d-m-Y', strtotime($allocation->date)) ?></td>
                                        <td><?= $allocation->session ?></td>
                                        <td><?= $allocation->role_name ?></td>
                                        <td class="attendance-column"><?= $allocation->attendance ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>

                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="form-group update-attendance-btn">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-labeled glowing-border-button">Update Attendance</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
