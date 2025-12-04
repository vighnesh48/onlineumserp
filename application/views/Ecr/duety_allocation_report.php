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
        $('#faculty_list_pdf').on('click', function (event) {
            event.preventDefault();  // Prevents page reload

            var date = $('#filter_date').val();
            var examId = $('#filter_exam').val();
            var roleId = $('#filter_role').val();
            var centerId = $('#filter_center').val();
            var session = $('#session').val();

            // Create a form to submit the data
            var form = $('<form>', {
                action: '<?= base_url('EcrEmpRegController/generateDateWiseFacultyPDF') ?>',
                method: 'POST',
                target: '_blank' // Optional: Open in a new tab
            });

            // Append input fields for the form data
            form.append($('<input>', {
                type: 'hidden',
                name: 'examId',
                value: examId
            }));

            form.append($('<input>', {
                type: 'hidden',
                name: 'date',
                value: date
            }));

            form.append($('<input>', {
                type: 'hidden',
                name: 'roleId',
                value: roleId
            }));
            form.append($('<input>', {
                type: 'hidden',
                name: 'centerId',
                value: centerId
            }));
            
            // Append and submit the form
            $('body').append(form);
            form.submit();
            form.remove(); // Clean up the form after submission
        });

        $('#faculty_list_pdf_date_wise').on('click', function (event) {
            event.preventDefault();  // Prevents page reload

            var date = $('#filter_date').val();
            var roleId = $('#filter_role').val();
            var examId = $('#filter_exam').val();
            var centerId = $('#filter_center').val();
            var session = $('#session').val();

            // Create a form to submit the data
            var form = $('<form>', {
                action: '<?= base_url('EcrEmpRegController/generateDutyListDateWisePDF') ?>',
                method: 'POST',
                target: '_blank' // Optional: Open in a new tab
            });

            // Append input fields for the form data
            form.append($('<input>', {
                type: 'hidden',
                name: 'examId',
                value: examId
            }));

            form.append($('<input>', {
                type: 'hidden',
                name: 'date',
                value: date
            }));
            form.append($('<input>', {
                type: 'hidden',
                name: 'roleId',
                value: roleId
            }));
            form.append($('<input>', {
                type: 'hidden',
                name: 'centerId',
                value: centerId
            }));
            // Append and submit the form
            $('body').append(form);
            form.submit();
            form.remove(); // Clean up the form after submission
        });

        $('#duty_list_pdf').on('click', function (event) {
            event.preventDefault();  // Prevents page reload

            var examId = $('#filter_exam').val();
            var roleId = $('#filter_role').val();
            var date = $('#filter_date').val();
            var centerId = $('#filter_center').val();
            var session = $('#session').val();

            // Create a form to submit the data
            var form = $('<form>', {
                action: '<?= base_url('EcrEmpRegController/generateDutyListPDF') ?>',
                method: 'POST',
                target: '_blank' // Optional: Open in a new tab
            });

            // Append input fields for the form data
            form.append($('<input>', {
                type: 'hidden',
                name: 'examId',
                value: examId
            }));
            form.append($('<input>', {
                type: 'hidden',
                name: 'roleId',
                value: roleId
            }));
            form.append($('<input>', {
                type: 'hidden',
                name: 'date',
                value: date
            }));
            form.append($('<input>', {
                type: 'hidden',
                name: 'centerId',
                value: centerId
            }));
            form.append($('<input>', {
                type: 'hidden',
                name: 'session',
                value: session
            }));

            // Append and submit the form
            $('body').append(form);
            form.submit();
            form.remove(); // Clean up the form after submission
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

</script>
<script>
    function sendAppointmentOrderAjax(empId, toEmail) {
        $.ajax({
            url: '<?= base_url("EcrEmpRegController/sendAppointmentOrder") ?>',  // Adjusted URL to match your setup
            type: 'POST',
            data: {
                emp_id: empId,
                to_email: toEmail
            },
            success: function (response) {
                alert(response.message || 'Appointment Order sent successfully');
            },
            error: function (xhr, status, error) {
                console.error("Error sending appointment order:", error);
                alert('Failed to send Appointment Order. Please try again.');
            }
        });
    }
</script>
<!-- Duty Allocation List -->
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Examination</a></li>
        <li class="active"><a href="#">ECR </a></li>
    </ul>

    <!-- Filter Form -->
    <!-- Radio Buttons for View Selection -->

    <div class="row">
        <div class="col-sm-12">
            <form id="filterForm" action="<?= base_url('EcrEmpRegController/duetyAllocationList_report') ?>"
                method="GET">
                <div class="row">
                    <div class="col-sm-2">
                        <select name="filter_exam" id="filter_exam" class="form-control" required>
                            <option value="">Select Exam Session</option>
                            <?php foreach ($exam_sessions as $session): ?>
                                <option value="<?= $session->exam_id ?>" <?= isset($_GET['filter_exam']) && $_GET['filter_exam'] == $session->exam_id ? 'selected' : '' ?>>
                                    <?= $session->exam_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select name="filter_center" id="filter_center" class="form-control" required>
                            <option value="">Select Exam Center</option>
                            <?php foreach ($exam_centers as $center): ?>
                                <option value="<?= $center->ec_id ?>" <?= isset($_GET['filter_center']) && $_GET['filter_center'] == $center->ec_id ? 'selected' : '' ?>>
                                <?= $center->center_name ?> (<?= $center->center_code ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select id="filter_role" name="filter_role" class="form-control">
                            <option value="">Select Role</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role->ecr_role_id ?>" <?= isset($_GET['filter_role']) && $_GET['filter_role'] == $role->ecr_role_id ? 'selected' : '' ?>>
                                    <?= $role->role_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input type="date" id="filter_date" name="filter_date" class="form-control"
                            value="<?= isset($_GET['filter_date']) ? $_GET['filter_date'] : '' ?>">
                    </div>
                    <div class="col-sm-2">
                        <select id="session"  name="session" class="form-control">
                            <option value="">Select Session</option>
                            <option value="FN" <?= isset($_GET['session']) && $_GET['session'] == 'FN' ? 'selected' : '' ?>>
                                Forenoon</option>
                            <option value="AN" <?= isset($_GET['session']) && $_GET['session'] == 'AN' ? 'selected' : '' ?>>
                                Afternoon</option>
                        </select>
                    </div>
                    <div class="col-sm-2" id="duty_list_pdf_btn">
                        <button class="btn glowing-border-button mt-2" id="duty_list_pdf">Session Wise Duty Assigned PDF</button>
                    </div>
                    <!-- <div class="col-sm-2" id="faculty_list_pdf_btn">
                        <button class="btn glowing-border-button mt-2" id="faculty_list_pdf_date_wise">Date wise Duty List PDF</button>
                    </div>  -->
                    <div class="col-sm-2" id="faculty_list_pdf_btn">
                        <button class="btn glowing-border-button mt-2" id="faculty_list_pdf">Duty Faculty Details PDF</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <br>
    <!-- Table Panel -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Duty Allocation List</span>
                </div>
                <div class="panel-body">
                    <input type="hidden" name="filter_date"
                        value="<?= isset($_GET['filter_date']) ? $_GET['filter_date'] : '' ?>">
                    <input type="hidden" name="filter_role"
                        value="<?= isset($_GET['filter_role']) ? $_GET['filter_role'] : '' ?>">
                    <input type="hidden" name="session"
                        value="<?= isset($_GET['session']) ? $_GET['session'] : '' ?>">
               

                    <!-- Duty Allocation Table -->
                    <?php if (!empty($duty_allocations)): ?>
                    <table class="table table-bordered">
                        <thead class="bgdynamic">
                            <tr>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Date</th>
                                <th>Session</th>
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
                                        <td><?php echo ($allocation->is_replaced == 1) ? $allocation->replace_emp_id : $allocation->emp_id; ?>
                                        </td>
                                        <td><?= $allocation->name ?></td>
                                        <td><?= $allocation->date ?></td>
                                        <td><?= $allocation->session ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">No duty allocations found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        <p>No duty allocations found. Please use the filters to search.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
     <!-- <img src="<?= base_url() ?>assets/images/exam.png" alt="Examiner Cartoon" class="examiner">  -->
     <!-- <img src="<?= base_url() ?>assets/images/exam.png" alt="Cartoon" class="examiner">  -->

</div>

