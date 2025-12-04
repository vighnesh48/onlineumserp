<script src="<?= site_url() ?>assets/javascripts/jquery.min.js"></script>
<script src="<?= site_url() ?>assets/javascripts/bootstrap.min.js"></script>
<style>
.bgdynamic {
    background: linear-gradient(44deg, #59b9f3, rgb(207 148 247), #edd6ff, #e0d3f9, #7aceff);
    background-size: 400% 400%;
    animation: gradientBackground 25s ease infinite;
}

@keyframes gradientBackground {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
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



#ReplaceButton {
    border: 2px solid transparent;
    border-radius: 4px;
    transition: transform 0.3s, box-shadow 0.3s;
    /* animation: pulse 1s infinite; */
    transform: translateY(0) scale(1.0); /* Reset scale and translation to normal */
}

#ReplaceButton:hover {
    box-shadow: 0 8px 8px lightskyblue;
    transform: translateY(-2px) scale(1.05);
}


#ReplaceButton {
    box-shadow: 0 8px 8px lightskyblue;
    border-color: #007bff;
}

#ReplaceButton:hover {
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

<body>
    <div id="content-wrapper">
        <ul class="breadcrumb breadcrumb-page">
            <div class="breadcrumb-label text-light-gray">You are here: </div>
            <li><a href="#">Exam Management</a></li>
            <li class="active"><a href="#">Replace Employee</a></li>
        </ul>

        <div class="page-header">
            <div class="row">
                <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i
                        class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Replace Employee</h1>
            </div>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success" role="alert">
        <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="panel-heading">

            <form id="filterForm" action="<?= base_url('EcrEmpRegController/duetyAllocationList_replace') ?>"
                method="POST">
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
                            value="<?= isset($filter_date) ? $filter_date : $_GET['filter_date'] ?>">
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


        <!-- Table Panel for Replace View -->
        <div class="row">
            <div class="col-sm-12">
            <div class="panel-heading">
                <span class="panel-title">Replace Employee</span>
            </div>
                <div class="panel-body" style="overflow:scroll;height:800px;">
                    <table class="table table-bordered" id="datatable">
                        <thead class="bgdynamic">
                            <tr>
                                <th>Exam</th>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Date</th>
                                <th>Session</th>
                                <th>Duty Name</th>
                                <th class="action-column">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($duty_allocations)): ?>
                                <?php foreach ($duty_allocations as $allocation): ?>
                                    <tr>
                                        <td><?= $allocation->exam_name ?>
                                            <input type="hidden" name="exam_id" id="exam_id"
                                                value="<?= $allocation->exam_id ?>">
                                        </td>
                                        <td><?= ($allocation->is_replaced == 1) ? $allocation->replace_emp_id : $allocation->emp_id; ?>
                                        </td>
                                        <td><?= $allocation->name ?></td>
                                        <td><?= $allocation->date ?></td>
                                        <td><?= $allocation->session ?></td>
                                        <td><?= $allocation->role_name ?></td>
                                        <td class="action-column">
                                            <button type="button" class="btn btn-labeled replace-button" id="ReplaceButton"
                                                onclick="openReplaceModal('<?= $allocation->emp_id ?>', '<?= $allocation->id ?>')">Replace</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
    
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Replace Employee Modal -->
    <div id="replaceEmployeeModal" class="modal fade animated-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-m" role="document">
            <div class="modal-content shadow">
                <form id="ecrEmployeeForm" action="<?= base_url('EcrEmpRegController/replaceEmployee') ?>" method="post">
                    <div class="modal-header bgdynamic">
                        <h5><b>Add ECR Employee</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="allocation_id" name="allocation_id">
                        <!-- <div class="form-group">
                            <label for="replace_employee_id">Employee ID</label>
                            <input type="text" id="replace_employee_id" name="replace_employee_id" class="form-control">
                            <button type="button" class="btn btn-primary" onclick="searchEmployee()">Search</button>
                        </div>
                        <div class="form-group">
                            <label for="replace_name">Employee Name</label>
                            <input type="text" id="replace_name" name="replace_name" class="form-control" readonly
                                required>
                        </div>
                        
                        <div class="form-group">
                            <label for="replace_email">Email</label>
                            <input type="email" id="replace_email" name="replace_email" class="form-control" readonly>
                        </div> -->
                        <div class="form-group">
                            <label>Search Employee by ID or Name <span class="redasterik">*</span></label>
                            <input type="text" id="employee_input" class="form-control"
                                placeholder="Enter Employee ID or Name" required>
                            <div id="employee_suggestions"></div>
                        </div>

                        <!-- Employee Details (Read-only Fields) -->
                        <div class="form-group">
                            <input type="hidden" name="employee_id" id="employee_id" class="form-control" readonly>
                            <input type="hidden" name="name" id="name" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="emal" id="email" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" id="mobile" name="mobile" class="form-control" readonly>
                            <input type="hidden" name="filter_date"
                                value="<?= isset($filter_date) ? $filter_date : '' ?>">
                            <input type="hidden" name="filter_role"
                                value="<?= isset($filter_role) ? $filter_role : '' ?>">
                            <input type="hidden" name="filter_exam"
                                value="<?= isset($filter_exam) ? $filter_exam : '' ?>">
                            <input type="hidden" name="filter_center"
                                value="<?= isset($filter_center) ? $filter_center : '' ?>">
                            <input type="hidden" name="session"
                                value="<?= isset($ssn) ? $ssn : '' ?>">
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
    function openReplaceModal(empId, allocationId) {
        // Set the values based on passed parameters
        $('#allocation_id').val(allocationId);
        var modal = $('#replaceEmployeeModal');

        // Start the modal with an animation
        modal.modal('show');
        const modalDialog = modal.find('.modal-dialog');
        modalDialog.css({
            transform: 'scale(0.7) rotateX(-30deg)',
            opacity: 0,
        });

        setTimeout(() => {
            modalDialog.css({
                transform: 'scale(1) rotateX(0deg)',
                opacity: 1,
            });
        }, 100);
    }

    // Ensure your other scripts are not conflicting and are included correctly
    $(document).ready(function () {
        // Function to fetch suggestions as user types
        $('#employee_input').on('input', function () {
            var query = $(this).val().trim();
            if (query.length > 1) {
                $.ajax({
                    url: '<?= base_url('EcrEmpRegController/getEmployeeSuggestionsForReplace') ?>',
                    type: 'POST',
                    data: { query: query },
                    dataType: 'json',
                    success: function (data) 
					{
                        $('#employee_suggestions').empty().show();
                        if (data.length > 0) {
                            data.forEach(function (item) {
                                $('#employee_suggestions').append(
                                    `<a class="dropdown-item" href="#" data-id="${item.emp_id}" data-name="${item.full_name}" data-email="${item.email}" data-mobile="${item.mobile}">
                                        <div style="display: flex; align-items: center;">
                                            <span>${item.emp_id} - </span>
                                            <span>${item.full_name}</span>
                                        </div>
                                    </a>`
                                );
                            });
                        } else {
                            $('#employee_suggestions').append('<a class="dropdown-item disabled">No results found</a>');
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

        // Handle the employee selection from suggestions
		
        $('#employee_suggestions').on('click', '.dropdown-item', function (e) {
            e.preventDefault();
            var empId = $(this).data('id');
            var empName = $(this).data('name');
            var empEmail = $(this).data('email');
            var empMobile = $(this).data('mobile');

            $('#employee_input').val(`${empId} - ${empName}`);
            $('#employee_id').val(empId);
            $('#name').val(empName);
            $('#email').val(empEmail);
            $('#mobile').val(empMobile);
            $('#employee_suggestions').hide();
        });
    });
    $(document).ready(function () {
        $('#filter_date, #filter_role, #filter_exam, #filter_center, #session').on('change', function () {
            $('#filterForm').submit();
        });
    });
</script>

    <script> 
   /*    function openReplaceModal(empId, allocationId) {
            $('#allocation_id').val(allocationId);
            $('#replaceEmployeeModal').modal('show');
        }

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
                            $('#employee_suggestions').empty().show();
                            if (data.length > 0) {
                                data.forEach(function (item) {
                                ///    console.log(item);
                                    $('#employee_suggestions').append(
                                        `                                <a class="dropdown-item" href="#" data-id="${item.emp_id}" data-name="${item.full_name}" data-email="${item.oemail}" data-mobile="${item.mobileNumber}">
                                    <div style="display: flex;  align-items: center;">
                                        <span>${item.emp_id} - </span>
                                        <span>${item.full_name}</span>
                                    </div>
                                </a>`
                                    );
                                });
                            } else {
                                $('#employee_suggestions').append('<a class="dropdown-item disabled">No results found</a>');
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
        $(document).ready(function () {
            $('#filter_date, #filter_role, #filter_exam, #filter_center').on('change', function () {
                $('#filterForm').submit();
            });
        });*/

    </script>
    
</body>