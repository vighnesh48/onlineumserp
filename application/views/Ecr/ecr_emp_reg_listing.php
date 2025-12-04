<head>
    <!-- Custom CSS -->
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


        #employee_suggestions {
            position: absolute;
            z-index: 1050;
            /* Ensure it appears above other elements in the modal */
            background: #fff;
            border: 1px solid #ddd;
            width: 50%;
            /* Match the input field width */
            max-height: 200px;
            overflow-y: auto;
            display: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Add subtle shadow for better visibility */
        }


        #employee_suggestions .dropdown-item {
            padding: 5px 10px;
            cursor: pointer;
        }

        #employee_suggestions .dropdown-item:hover {
            background: #f0f0f0;
        }

        /* Modal animations */
        /* Base modal dialog hidden state */
        .animated-modal .modal-dialog {
            transform: scale(0.7) rotateX(-30deg);
            opacity: 0;
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.6s ease;
            transform-origin: center center;
        }

        /* Modal dialog visible state */
        .animated-modal.show .modal-dialog {
            transform: scale(1) rotateX(0deg);
            opacity: 1;
        }

        /* Add a subtle glow to modal content */
        .modal-content {
            border-radius: 10px;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 123, 255, 0.2);
            overflow: hidden;
            animation: modal-glow 1.5s infinite alternate ease-in-out;
        }

        /* Modal glowing effect */
        @keyframes modal-glow {
            from {
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 20px rgba(0, 123, 255, 0.2);
            }

            to {
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(0, 123, 255, 0.5);
            }
        }

        /* Header design */
        .modal-header {
            background: linear-gradient(44deg, #59b9f3, rgb(207 148 247), #edd6ff, #e0d3f9, #7aceff);
            background-size: 400% 400%;
            border-bottom: none;
            padding: 10px;
            padding-left: 25px;
            animation: gradientBackground 25s ease infinite;
        }


        /* Button hover glow effect */
        #openModalButton:hover {
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.7);
            transform: translateY(-2px) scale(1.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        /* Fade-in and smooth scaling for modal body */
        .modal-body {
            padding: 30px;
            background: #f8f9fa;
            border-radius: 10px;
            animation: fadeInBody 0.7s ease;
        }

        /* Keyframes for body fade-in */
        @keyframes fadeInBody {
            from {
                opacity: 0;
                transform: scale(0.009);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .pulse-animation {
            animation: pulse 0.5s;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 rgba(0, 123, 255, 0.4);
            }

            50% {
                transform: scale(1.1);
                box-shadow: 0 0 20px rgba(0, 123, 255, 0.6);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 rgba(0, 123, 255, 0.4);
            }
        }

        .glowing-border-button {
            border: 2px solid transparent;
            border-radius: 4px;
            transition: border-color 0.3s, box-shadow 0.3s;
            /* animation: pulse 1s infinite; */
            border-color: #007bff;
        }

        .glowing-border-button:hover {
            border-color: blueviolet;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
    </style>
</head>

<body>
    <div id="content-wrapper">
        <ul class="breadcrumb breadcrumb-page">
            <div class="breadcrumb-label text-light-gray">You are here: </div>
            <li class="active"><a href="#">Examination</a></li>
            <li class="active"><a href="#">ECR Employee Listing</a></li>
        </ul>

        <div class="page-header">
            <div class="row">
                <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                    <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;ECR Employee Listing
                </h1>
                <div class="col-xs-12 col-sm-8">
                    <div class="pull-right col-xs-12 col-sm-auto">
                        <!-- <button style="width: 100%;" class="btn btn-primary btn-labeled glowing-border-button bgdynamic" data-toggle="modal"
                        data-target="#addEmployeeModal">
                        <span class="btn-label icon fa fa-plus"></span>Add Employee
                    </button> -->
                        <button id="openModalButton" class="btn btn-labeled glowing-border-button" data-toggle="modal">
                            <span class="btn-label icon fa fa-plus"></span> Add Employee
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <!-- Filter Form -->
        <div class="panel-heading">
            <form id="filterForm" action="<?php echo base_url() . 'EcrEmpRegController/index'; ?>" method="get">
                <div class="row">
                    <div class="form-group col-md-2">
                        <select name="exam_id" id="exam_id1" onchange="submitForm()" class="form-control">
                            <option value="">Select Exam Session</option>
                            <?php foreach ($exam_sessions as $session): ?>
                                <option value="<?= $session->exam_id ?>" <?= $this->input->get('exam_id') == $session->exam_id ? 'selected' : ''; ?>>
                                    <?= $session->exam_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <select name="center_id" id="center_id1" onchange="submitForm()" class="form-control">
                            <option value="0">All Exam Centers</option>
                            <?php foreach ($exam_centers as $center): ?>
                                <option value="<?= $center->ec_id ?>" <?= $this->input->get('center_id') == $center->ec_id ? 'selected' : ''; ?>>
                                    <?= $center->center_name ?> (<?= $center->center_code ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <select name="ecr_role_id" id="ecr_role_id1" onchange="submitForm()" class="form-control">
                            <option value="">Select ECR Role</option>
                            <?php foreach ($ecr_roles as $role): ?>
                                <option value="<?= $role->ecr_role_id ?>"
                                    <?= $this->input->get('ecr_role_id') == $role->ecr_role_id ? 'selected' : ''; ?>>
                                    <?= $role->role_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Employee Listing -->
        <div class="panel-body" style="overflow:scroll;height:800px;">
            <table class="table table-bordered table-striped table-hover" id="datatable">
                <thead class="bgdynamic">
                    <tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Exam Session</th>
                        <th>Exam Center</th>
                        <th>School</th>
                        <th>ECR Role</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($employees)): ?>
                        <?php foreach ($employees as $employee): ?>
                            <tr>
                                <td><?= $employee->emp_id ?></td>
                                <td><?= $employee->name ?></td>
                                <td><?= $employee->exam_name ?></td>
                                <td><?= $employee->center_name ?: 'All' ?></td>
                                <td><?= $employee->school_short_name ?: 'All' ?></td>
                                <td><?= $employee->role_name ?></td>
                                <td><?= $employee->email ?></td>
                                <td><?= $employee->mobile ?></td>
                                <td>

                                    <i class="status-icon fa <?= $employee->is_active ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' ?>"
                                        data-id="<?= $employee->emp_id ?>" data-status="<?= $employee->is_active ? 1 : 0 ?>"
                                        style="cursor: pointer;" title="Click to toggle status"></i>

                                        <button class="btn btn-primary btn-sm edit-button" 
                                            data-emp_id="<?= $employee->emp_id ?>" 
                                            data-name="<?= $employee->name ?>" 
                                            data-exam_id="<?= $employee->exam_id ?>" 
                                            data-center_id="<?= $employee->center_id ?>"
                                            data-school_id="<?= $employee->school_id ?>"
                                            data-role_id="<?= $employee->ecr_role ?>"
                                            data-email="<?= $employee->email ?>"
                                            data-mobile="<?= $employee->mobile ?>"
                                            data-bank_name="<?= $employee->bank_name?>"
                                            data-acc_no="<?= $employee->acc_no?>"
                                            data-ifsc="<?= $employee->ifsc?>"
                                            data-branch_name="<?= $employee->branch_name?>"
                                            >
                                            Edit
                                        </button>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">No employees found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div id="addEmployeeModal" class="modal fade animated-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-m" role="document">
            <div class="modal-content shadow">
                <form id="ecrEmployeeForm" action="<?= base_url('EcrEmpRegController/addEcrEmployee') ?>" method="post">
                    <div class="modal-header bgdynamic">
                        <h5><b>Add ECR Employee</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Exam Session -->
                        <div class="form-group">
                            <label>Exam Session <span class="redasterik">*</span></label>
                            <select name="exam_id" id="exam_id" class="form-control" required>
                                <option value="">Select Exam Session</option>
                                <?php foreach ($exam_sessions as $session): ?>
                                    <option selected value="<?= $session->exam_id ?>"><?= $session->exam_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Exam Center -->
                        <div class="form-group">
                            <label>Exam Center <span class="redasterik">*</span></label>
                            <select name="center_id" id="center_id" class="form-control" required>
                                <option value="">Select Exam Center</option>
                                <option value="0">All Exam Center</option>
                                <?php foreach ($exam_centers as $center): ?>
                                    <option value="<?= $center->ec_id ?>"><?= $center->center_name ?>
                                        (<?= $center->center_code ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- School -->
                        <div class="form-group">
                            <label>School <span class="redasterik">*</span></label>
                            <select name="school_id" id="school_id" class="form-control" required>
                                <option value="">Select School</option>
                                <option value="0">All School</option>
                                <?php foreach ($schools as $school): ?>
                                    <option value="<?= $school->school_id ?>"><?= $school->school_short_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- ECR Role -->
                        <div class="form-group">
                            <label>ECR Role <span class="redasterik">*</span></label>
                            <select name="ecr_role_id" id="ecr_role_id" class="form-control" required>
                                <option value="">Select ECR Role</option>
                                <?php foreach ($ecr_roles as $role): ?>
                                    <option value="<?= $role->ecr_role_id ?>"><?= $role->role_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Search Employee by ID or Name <span class="redasterik">*</span></label>
                            <input type="text" id="employee_input" class="form-control"
                                placeholder="Enter Employee ID or Name" >
                            <div id="employee_suggestions"></div>
                        </div>

                        <!-- Employee Details (Read-only Fields) -->
                        <div class="form-group">
                            <input type="hidden" name="employee_id" id="employee_id" class="form-control" readonly>
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="emal" id="email" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Bank Name</label>
                            <input type="text" name="bank_name" id="bank_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Account Number</label>
                            <input type="text" name="acc_no" id="acc_no" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>IFSC Code</label>
                            <input type="text" name="ifsc" id="ifsc" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Branch Name</label>
                            <input type="text" name="branch_name" id="branch_name" class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="submitButton">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	   <script>
        $(document).ready(function () {
			 
            // Function to fetch suggestions as user types
			$('#employee_input').on('input', function () {
				var query = $(this).val().trim();

				if (query.length > 1) {
					$.ajax({
						url: '<?= base_url('EcrEmpRegController/getEmployeeSuggestions') ?>',
						type: 'POST',
						data: { query: query },
						dataType: 'json',
						success: function (data) {
							const $suggestions = $('#employee_suggestions');
							$suggestions.empty().show();

							if (Array.isArray(data) && data.length > 0) {
								data.forEach(function (item) {
									const empId = item.emp_id || '';
									const fullName = item.full_name || '';
									const oemail = item.oemail || '';
									const mobile = item.mobileNumber || '';

									$suggestions.append(`<a class="dropdown-item" href="#" data-id="${empId}" data-name="${fullName}" data-email="${oemail}" data-mobile="${mobile}"> <div style="display: flex; align-items: center;"><span>${empId} - </span><span>${fullName}</span></div> </a>`);
								});
							} else {
								$suggestions.append('<a class="dropdown-item disabled">No results found</a>');
							}
						},
						error: function () {
							alert('Error fetching employee suggestions');
						}
					});
				} else {
					$('#employee_suggestions').hide();
				}
			});


            // Event listener to select an employee from the suggestions
            $('#employee_suggestions').on('click', '.dropdown-item', function (e) {
                e.preventDefault();
                var empId = $(this).data('id');
                var empName = $(this).data('name');
                var empEmail = $(this).data('email');
                var empMobile = $(this).data('mobile');

                // Populate readonly fields with selected employee data
                $('#employee_input').val(`${empId} - ${empName}`);
                $('#employee_id').val(empId);
                $('#name').val(empName);
                $('#email').val(empEmail);
                $('#mobile').val(empMobile);

                // Hide suggestions
                $('#employee_suggestions').hide();
            });
        });
        function submitForm() {
            $('#filterForm').submit();
        }



        $(document).on('click', '.edit-button', function () {
            var empId = $(this).data('emp_id')+'-'+$(this).data('name');
            var name = $(this).data('name');
            var examId = $(this).data('exam_id');
            var centerId = $(this).data('center_id');
            var schoolId = $(this).data('school_id');
            var roleId = $(this).data('role_id');
            var email = $(this).data('email');
            var mobile = $(this).data('mobile');
            var bank_name = $(this).data('bank_name');
            var acc_no = $(this).data('acc_no');
            var ifsc = $(this).data('ifsc');
            var branch_name = $(this).data('branch_name');
            employeeId = $(this).data('emp_id');
            console.log(empId, name, examId, centerId, schoolId, roleId, email, mobile, acc_no, bank_name, ifsc, branch_name);

            // Populate the modal fields
            $('#employee_input').val(empId);
            $('#employee_id').val(employeeId);
            $('#name').val(name);
            $('#exam_id').val(examId).change(); // Ensure the correct option is selected
            $('#center_id').val(centerId).change();
            $('#school_id').val(schoolId).change();
            $('#ecr_role_id').val(roleId).change();
            $('#email').val(email);
            $('#mobile').val(mobile);
            $('#bank_name').val(bank_name);
            $('#acc_no').val(acc_no);
            $('#ifsc').val(ifsc);
            $('#branch_name').val(branch_name);

            // Update modal title and button text
            $('#addEmployeeModal .modal-header h5').text('Edit ECR Employee');
            $('#submitButton').text('Update');
            $('#ecrEmployeeForm').attr('action', '<?= base_url('EcrEmpRegController/editEcrEmployee') ?>');

            // Show the modal
            $('#addEmployeeModal').modal('show');
        });

        $('#addEmployeeModal').on('hidden.bs.modal', function () {
            // Reset modal fields
            $('#ecrEmployeeForm')[0].reset();
            $('#employee_id').val('');
            $('#addEmployeeModal .modal-header h5').text('Add ECR Employee');
            $('#submitButton').text('Submit');
            $('#ecrEmployeeForm').attr('action', '<?= base_url('EcrEmpRegController/addEcrEmployee') ?>');
        });
    </script>
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
    function toggleAdditionalFields(roleId) {
        if (roleId == 6 || roleId == 9) {
            $('#employee_input').closest('.form-group').hide();
            $('#name, #mobile, #email, #bank_name, #acc_no, #ifsc, #branch_name').closest('.form-group').show();

            // Remove readonly
            $('#email').prop('readonly', false);
            $('#mobile').prop('readonly', false);
            $('#name').prop('readonly', false);

        } else {
            $('#employee_input').closest('.form-group').show();
            $('#name, #bank_name, #acc_no, #ifsc, #branch_name').closest('.form-group').hide();

            // Set readonly again
            $('#email').prop('readonly', true);
            $('#mobile').prop('readonly', true);
            $('#name').prop('readonly', true);
        }
    }

    $('#ecr_role_id').on('change', function () {
        toggleAdditionalFields($(this).val());
    });

    // Initial trigger on page load
    toggleAdditionalFields($('#ecr_role_id').val());

</script>
    <!-- JavaScript for Employee Search -->
    <script>
        $(document).ready(function () {
            // Handle status icon click
            $('.status-icon').on('click', function () {
                var empId = $(this).data('id');
                var currentStatus = $(this).data('status');
                var newStatus = currentStatus === 1 ? 0 : 1; // Toggle status

                // Confirmation prompt
                var confirmationMessage = newStatus === 1
                    ? 'Are you sure you want to activate this employee?'
                    : 'Are you sure you want to deactivate this employee?';

                if (confirm(confirmationMessage)) {
                    // Send AJAX request to update the status
                    $.ajax({
                        url: '<?= base_url('EcrEmpRegController/updateStatus') ?>',
                        type: 'POST',
                        data: { emp_id: empId, is_active: newStatus },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                // Update the icon based on new status
                                var icon = $(`.status-icon[data-id="${empId}"]`);
                                icon.data('status', newStatus);

                                if (newStatus === 1) {
                                    icon.removeClass('fa-times-circle text-danger').addClass('fa-check-circle text-success');
                                } else {
                                    icon.removeClass('fa-check-circle text-success').addClass('fa-times-circle text-danger');
                                }
                            } else {
                                alert('Failed to update employee status');
                            }
                        },
                        error: function () {
                            alert('Error occurred while updating status');
                        },
                    });
                }
            });
        });


        document.getElementById('openModalButton').addEventListener('click', function () {
            const button = this;

            // Add a pulse animation
            button.classList.add('pulse-animation');
            setTimeout(() => button.classList.remove('pulse-animation'), 300); // Remove animation class after it completes

            // Open the modal dynamically
            $('#addEmployeeModal').modal('show');
        });
        // Modal open animation
        $('#addEmployeeModal').on('show.bs.modal', function () {
            const modal = $(this).find('.modal-dialog');

            // Reset animation state
            modal.css({
                transform: 'scale(0.7) rotateX(-30deg)',
                opacity: 0,
            });

            // Trigger animation with a slight delay
            setTimeout(() => {
                modal.css({
                    transform: 'scale(1) rotateX(0deg)',
                    opacity: 1,
                });
            }, 100);
        });
    </script>
 
</body>