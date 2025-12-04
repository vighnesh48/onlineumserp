<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

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

    /* Loader Container */
    #loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Spinner Animation */
    .spinner {
        border: 8px solid #f3f3f3;
        /* Light gray */
        border-top: 8px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
    }

    /* Spinner Animation Keyframes */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    #SuccessButton,
    #VerifyButton {
        border: 2px solid transparent;
        border-radius: 4px;
        transition: transform 0.3s, box-shadow 0.3s;
        /* animation: pulse 1s infinite; */
        transform: translateY(0) scale(1.0);
        /* Reset scale and translation to normal */
    }

    #SuccessButton:hover,
    #VerifyButton:hover {
        box-shadow: 0 8px 8px lightskyblue;
        transform: translateY(-2px) scale(1.05);
    }

    #SuccessButton {
        box-shadow: 0 8px 8px lightskyblue;
        border-color: blueviolet;
    }

    #SuccessButton:hover {
        box-shadow: 0 8px 8px lightskyblue;
        border-color: green;
        /* Change to a greenish glow on hover */
    }

    #VerifyButton {
        box-shadow: 0 8px 8px lightskyblue;
        border-color: blueviolet;
    }

    #VerifyButton:hover {
        box-shadow: 0 8px 8px lightskyblue;
        border-color: #007bff;
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

<script>
    $(document).ready(function () {
        $('#form').bootstrapValidator({
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                exam_id: { validators: { notEmpty: { message: 'Exam Session is required' } } },
                center_id: { validators: { notEmpty: { message: 'Center is required' } } },
                duety_name: { validators: { notEmpty: { message: 'Duty Role is required' } } }
            }
        });

        // Handle change event to load employee and dates
        $('#duety_name, #exam_id, #center_id').on('change', function () {
            var role_id = $('#duety_name').val();
            var exam_id = $('#exam_id').val();
            var center_id = $('#center_id').val();

            if (role_id && exam_id) {
                $.ajax({
                    url: '<?= base_url("EcrEmpRegController/getEmployeesAndDatesByRole") ?>',
                    type: 'POST',
                    data: { role_id: role_id, exam_id: exam_id, center_id: center_id },
                    dataType: 'json',
                    success: function (response) {
                        if (response && response.dates && response.employees) {
                            $('#employee_dates tbody').empty();
                            $('#employee_dates thead').empty();

                            var headerRow = '<tr><th>Employee</th>';
                            if (role_id === '1' || role_id === '2') {
                                headerRow += '<th>Check All</th>';
                            }
                            $.each(response.dates, function (index, date) {
                                var formattedDate = new Date(date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short' });
                                headerRow += '<th>' + formattedDate + '</th>';
                            });
                            headerRow += '<th>Action</th></tr>';
                            $('#employee_dates thead').append(headerRow);

                            //    console.log(response.verified_emp);

                            $.each(response.employees, function (index, employee) {

                                var row = '<tr>';
                                row += '<td>' + employee.emp_id + ' - ' + employee.name + '</td>';

                                // Add this logic inside your success function where you generate the table rows
                                if (role_id == '1' || role_id == '2') {

                                    row += '<td><label><input type="checkbox" class="check-all-row" data-emp-id="' + employee.emp_id + '"></label></td>';
                                }
                                $.each(response.dates, function (i, date) {
                                    var checkedAN = response.allocations[employee.emp_id] && response.allocations[employee.emp_id][date] && response.allocations[employee.emp_id][date].includes('AN') ? 'checked' : '';
                                    var checkedFN = response.allocations[employee.emp_id] && response.allocations[employee.emp_id][date] && response.allocations[employee.emp_id][date].includes('FN') ? 'checked' : '';

                                    row += '<td>' +
                                        '<label><input type="checkbox" class="session-checkbox" data-emp-id="' + employee.emp_id + '" data-date="' + date + '" data-session="AN" ' + checkedAN + '> AN</label>' +
                                        '<label><input type="checkbox" class="session-checkbox" data-emp-id="' + employee.emp_id + '" data-date="' + date + '" data-session="FN" ' + checkedFN + '> FN</label>' +
                                        '</td>';
                                });

                                row += '<td class="action-column">' +
                                    '<button type="button" class="btn btn-labeled glowing-border-button verify-button" id="VerifyButton" data-emp-id="' + employee.emp_id + '" onclick="verifyAndConfirm(\'' + employee.emp_id + '\')">Verify & Confirm</button>' +
                                    '<button type="button" class="btn btn-labeled glowing-border-button send-button" id="SuccessButton" data-emp-id="' + employee.emp_id + '" onclick="sendAppointmentLetter(\'' + employee.emp_id + '\', \'' + employee.email + '\')" style="display:none">Send Appointment Letter</button>' +
                                    '</td>';

                                row += '</tr>';
                                $('#employee_dates tbody').append(row);


                                // Bind event listener to "Check All" checkboxes
                                // Bind event listener to "Check All" checkboxes
                                $(document).off('change', '.check-all-row').on('change', '.check-all-row', function () {
                                    var $row = $(this).closest('tr');
                                    var isChecked = $(this).is(':checked');
                                    var emp_id = $(this).data('emp-id');
                                    var $sessionCheckboxes = $row.find('.session-checkbox');

                                    if (isChecked) {
                                        // Keep "Check All" checked while processing
                                        $(this).prop('checked', true);

                                        // Collect promises for all AJAX requests
                                        let ajaxPromisesadd = [];
                                        $sessionCheckboxes.each(function () {
                                            $(this).prop('checked', true); // Check the checkbox
                                            var date = $(this).data('date');
                                            var session = $(this).data('session');
                                            var duety_name = $('#duety_name').val();
                                            var exam_id = $('#exam_id').val();
                                            var center_id = $('#center_id').val();

                                            // Push the AJAX call promise into the array
                                            ajaxPromisesadd.push(
                                                $.ajax({
                                                    url: '<?= base_url("EcrEmpRegController/insertOrDeleteAllocation") ?>',
                                                    type: 'POST',
                                                    data: {
                                                        emp_id: emp_id,
                                                        date: date,
                                                        session: session,
                                                        duety_name: duety_name,
                                                        exam_id: exam_id,
                                                        center_id: center_id,
                                                        is_checked: true
                                                    },
                                                    error: function () {
                                                        alert("An error occurred while adding an allocation.");
                                                    }
                                                })
                                            );
                                        });

                                        // Wait for all AJAX calls to finish
                                        $.when(...ajaxPromisesadd).done(function () {
                                            alert("All allocations have been added successfully.");
                                        });
                                    } else {
                                        if (confirm('Are you sure you want to remove all allocations for Employee ID: ' + emp_id + '?')) {
                                            // Keep "Check All" unchecked while processing
                                            $(this).prop('checked', false);

                                            // Collect promises for all AJAX requests
                                            let ajaxPromises = [];
                                            $sessionCheckboxes.each(function () {
                                                $(this).prop('checked', false); // Uncheck the checkbox
                                                var date = $(this).data('date');
                                                var session = $(this).data('session');
                                                var duety_name = $('#duety_name').val();
                                                var exam_id = $('#exam_id').val();
                                                var center_id = $('#center_id').val();

                                                // Push the AJAX call promise into the array
                                                ajaxPromises.push(
                                                    $.ajax({
                                                        url: '<?= base_url("EcrEmpRegController/insertOrDeleteAllocation") ?>',
                                                        type: 'POST',
                                                        data: {
                                                            emp_id: emp_id,
                                                            date: date,
                                                            session: session,
                                                            duety_name: duety_name,
                                                            exam_id: exam_id,
                                                            center_id: center_id,
                                                            is_checked: false
                                                        },
                                                        error: function () {
                                                            alert("An error occurred while removing an allocation.");
                                                        }
                                                    })
                                                );
                                            });

                                            // Wait for all AJAX calls to finish
                                            $.when(...ajaxPromises).done(function () {
                                                alert("All allocations have been removed successfully.");
                                            });
                                        } else {
                                            // Re-check the "Check All" checkbox if the user cancels the removal
                                            $(this).prop('checked', true);
                                        }
                                    }
                                });





                                $.each(response.verified_emp, function (index, verified_emp) {
                                    if (employee.emp_id == verified_emp.emp_id) {
										var $dev = "<?= $this->session->userdata('name'); ?>";
                                        if($dev != 'ecr_developer' && $dev != 'ecr_acoe' ){

                                            $('.session-checkbox[data-emp-id="' + verified_emp.emp_id + '"]').prop('disabled', true);

                                        }
                                        $('.check-all-row[data-emp-id="' + verified_emp.emp_id + '"]').prop('disabled', true);
                                        $('.verify-button[data-emp-id="' + verified_emp.emp_id + '"]').prop('disabled', true);
                                        $('.verify-button[data-emp-id="' + verified_emp.emp_id + '"]').hide();
                                        $('.send-button[data-emp-id="' + verified_emp.emp_id + '"]').show();


                                    }
                                });
                                $.each(response.sent_letter, function (index, sent_letter) {
                                    if (employee.emp_id == sent_letter.emp_id) {
                                        $('.send-button[data-emp-id="' + sent_letter.emp_id + '"]').prop('disabled', true);
                                    }
                                });
                            });

                            // Enable "Verify & Confirm" button when a checkbox in the same row is selected
                            $('.session-checkbox').on('change', function () {
                                var $row = $(this).closest('tr');
                                var $button = $row.find('.verify-button');
                                var isChecked = $row.find('.session-checkbox:checked').length > 0;
                                $button.prop('disabled', !isChecked);
                            });
                        } else {
                            $('#employee_dates tbody').append('<tr><td colspan="5">No data found for selected role and exam session</td></tr>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching data: ", error);
                        alert('Error fetching data');
                    }
                });
            }
        });

        // AJAX request for inserting or deleting allocation
        $(document).on('change', '.session-checkbox', function () {
            var emp_id = $(this).data('emp-id');
            var date = $(this).data('date');
            var session = $(this).data('session');
            var duety_name = $('#duety_name').val();
            var exam_id = $('#exam_id').val();
            var center_id = $('#center_id').val();
            var is_checked = $(this).is(':checked');

            if (is_checked) {
                // Directly add the allocation without confirmation
                $.ajax({
                    url: '<?= base_url("EcrEmpRegController/insertOrDeleteAllocation") ?>',
                    type: 'POST',
                    data: { emp_id: emp_id, date: date, session: session, duety_name: duety_name, exam_id: exam_id, center_id: center_id, is_checked: is_checked },
                    success: function (response) {
                        console.log("Allocation added successfully.");
                    },
                    error: function (xhr, status, error) {
                        console.error("Error adding allocation: ", error);
                        alert('Error adding allocation');
                    }
                });
            } else {

                if (duety_name != 1) {
                    // Show confirmation alert before removing the allocation
                    var confirmMessage = 'Are you sure you want to remove this ' + session + ' allocation for ' + emp_id + ' on ' + date + '?';

                    if (confirm(confirmMessage)) {
                        $.ajax({
                            url: '<?= base_url("EcrEmpRegController/insertOrDeleteAllocation") ?>',
                            type: 'POST',
                            data: {
                                emp_id: emp_id,
                                date: date,
                                session: session,
                                duety_name: duety_name,
                                exam_id: exam_id,
                                center_id: center_id,
                                is_checked: is_checked
                            },
                            success: function (response) {
                                console.log("Allocation removed successfully.");
                            },
                            error: function (xhr, status, error) {
                                console.error("Error removing allocation: ", error);
                                alert('Error removing allocation');
                            }
                        });
                    } else {
                        // Re-check the checkbox since the user canceled the removal
                        $(this).prop('checked', true);
                    }
                } else {
                    // Directly proceed with AJAX request for duety_name == 1 without confirmation
                    $.ajax({
                        url: '<?= base_url("EcrEmpRegController/insertOrDeleteAllocation") ?>',
                        type: 'POST',
                        data: {
                            emp_id: emp_id,
                            date: date,
                            session: session,
                            duety_name: duety_name,
                            exam_id: exam_id,
                            center_id: center_id,
                            is_checked: is_checked
                        },
                        success: function (response) {
                            console.log("Allocation removed successfully.");
                        },
                        error: function (xhr, status, error) {
                            console.error("Error removing allocation: ", error);
                            alert('Error removing allocation');
                        }
                    });
                }

            }
        });
    });

    // Function to handle "Verify & Confirm" button click
    window.verifyAndConfirm = function (empId) {
        // Get the selected exam_id and role_id values
        var examId = $('#exam_id').val();
        var roleId = $('#duety_name').val();
        var centerId = $('#center_id').val();

        if (!examId || !roleId) {
            alert('Please select both Exam Session and Duty Role.');
            return;
        }

        if (confirm('Are you sure you want to confirm this duty allocation and generate the appointment letter?')) {
            // Disable checkboxes in the row
            $('.session-checkbox[data-emp-id="' + empId + '"]').prop('disabled', true);
            $('.check-all-row[data-emp-id="' + empId + '"]').prop('disabled', true);

            // Generate PDF appointment letter and trigger download with exam_id, role_id, and emp_id as query parameters
            window.location.href = '<?= base_url("EcrEmpRegController/generateAppointmentOrder") ?>?emp_id=' + empId + '&exam_id=' + examId + '&role_id=' + roleId + '&center_id=' + centerId;

            // Hide "Verify & Confirm" button and show "Send Appointment Letter" button
            $('.verify-button[data-emp-id="' + empId + '"]').hide();
            $('.send-button[data-emp-id="' + empId + '"]').show();
        }
    };


    // Function to handle "Send Appointment Letter" button click
    window.sendAppointmentLetter = function (empId, toEmail) {
        var examId = $('#exam_id').val();
        var roleId = $('#duety_name').val();
        var centerId = $('#center_id').val();

        if (confirm('Are you sure you want to send the Appointment Letter?')) {
            $.ajax({
                url: '<?= base_url() . "EcrEmpRegController/sendAppointmentOrder" ?>',
                type: 'POST',
                data: { emp_id: empId, to_email: toEmail, exam_id: examId, role_id: roleId, center_id: centerId },
                success: function (response) {
                    alert(response.message || 'Appointment Order sent successfully');
                    $('.send-button[data-emp-id="' + empId + '"]').hide();
                },
                error: function (xhr, status, error) {
                    console.error("Error sending appointment order:", error);
                    alert('Failed to send Appointment Order. Please try again.');
                }
            });
        }
    };


</script>
<script>
    $(document).ready(function () {
        // Show loader on AJAX start
        $(document).ajaxStart(function () {
            $("#loader").show();
        });

        // Hide loader on AJAX complete
        $(document).ajaxStop(function () {
            $("#loader").hide();
        });
    });
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Exam Management</a></li>
        <li class="active"><a href="#">Duty Allocation</a></li>
    </ul>

    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i
                    class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Duty Allocation</h1>
        </div>
    </div>
    <div id="loader" style="display: none;">
        <div class="spinner"></div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Allocate Duties</span>
                </div>
                <div class="panel-body" style="overflow:scroll;height:800px;">
                    <form id="form" name="form" action="<?= base_url('EcrEmpRegController/submitDuetyAllocation') ?>"
                        method="POST">
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label>Exam Session <sup class="redasterik" style="color:red">*</sup></label>
                                <select name="exam_id" id="exam_id" class="form-control" required>
                                    <option value="">Select Exam Session</option>
                                    <?php foreach ($exam_sessions as $session): ?>
                                        <option value="<?= $session->exam_id ?>"><?= $session->exam_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>Exam Centers <sup class="redasterik" style="color:red">*</sup></label>
                                <select name="center_id" id="center_id" class="form-control" required>
                                    <option value="">All Exam Centers</option>
                                    <?php foreach ($exam_centers as $center): ?>
                                        <option value="<?= $center->ec_id ?>">
                                            <?= $center->center_name ?> (<?= $center->center_code ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>Duty Role <sup class="redasterik" style="color:red">*</sup></label>
                                <select name="duety_name" id="duety_name" class="form-control" required>
                                    <option value="">Select Duty Role</option>
                                    <?php foreach ($duety_names as $role): ?>
                                        <option value="<?= $role->ecr_role_id ?>"><?= $role->role_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd;">
                                    <table id="employee_dates" class="table table-bordered" style="margin-bottom: 0;">
                                        <thead class="bgdynamic" style="position: sticky; top: 0; z-index: 10;">
                                            <tr>
                                                <th>Employee</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3">Select a role and exam session to load employees and dates</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>