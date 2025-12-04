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
        $('#filter_date, #filter_role, #filter_exam ,#session').on('change', function () {
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
$(document).ready(function () {
    // Initialize each center dropdown with its pre-selected value using its unique ID
    $('.center-dropdown').each(function () {
        var $centerDropdown = $(this);
        var centerId = $centerDropdown.data('selected-center');
        var uniqueId = $centerDropdown.attr('id'); // Get the unique ID (e.g., center_empId_session)
        
        if (centerId) {
            $('#' + uniqueId).val(centerId);
            $('#' + uniqueId).trigger('change'); // Trigger change to load dependent buildings
        }
    });

    // On Center Change
    $(document).on('change', '.center-dropdown', function () {
        var centerId = $(this).val();
        var empId = $(this).data('emp-id');
        var session = $(this).attr('id').split('_')[2];
        var buildingDropdownId = `building_id_${empId}_${session}`;

     //   alert(buildingDropdownId);
        
        if (centerId) {
            $.ajax({
                url: '<?= base_url("EcrEmpRegController/getBuildingsByCenter") ?>',
                type: 'POST',
                data: { center_id: centerId },
                dataType: 'json',
                success: function (buildings) {
                    var $buildingDropdown = $('#' + buildingDropdownId);
                    $buildingDropdown.empty().append('<option value="">Select Building</option>');

                    $.each(buildings, function (index, building) {
                        $buildingDropdown.append(`<option value="${building.id}">${building.building_name}</option>`);
                    });

                    $buildingDropdown.prop('disabled', false);
                    
                    var selectedBuilding = $buildingDropdown.data('selected-building');
                    if (selectedBuilding) {
                        $buildingDropdown.val(selectedBuilding).trigger('change');
                    }
                }
            });
        }
    });

    // On Building Change
    $(document).on('change', '.building-dropdown', function () {
        var buildingId = $(this).val();
        var empId = $(this).data('emp-id');
        var session = $(this).attr('id').split('_')[3];
        var floorDropdownId = `floor_${empId}_${session}`;
      //  alert(floorDropdownId);
        if (buildingId) {
            $.ajax({
                url: '<?= base_url("EcrEmpRegController/getFloorsByBuilding") ?>',
                type: 'POST',
                data: { building_id: buildingId },
                dataType: 'json',
                success: function (floors) {
                    var $floorDropdown = $('#' + floorDropdownId);
                    $floorDropdown.empty().append('<option value="">Select Floor</option>');

                    $.each(floors, function (index, floor) {
                        $floorDropdown.append(`<option value="${floor.floor}">${floor.floor}</option>`);
                    });

                    $floorDropdown.prop('disabled', false);
                    
                    var selectedFloor = $floorDropdown.data('selected-floor');
                    if (selectedFloor) {
                        $floorDropdown.val(selectedFloor).trigger('change');
                    }
                }
            });
        }
    });

    // On Floor Change
    $(document).on('change', '.floor-dropdown', function () {
        var buildingId = $(this).closest('tr').find('.building-dropdown').val();
        var floor = $(this).val();
        var empId = $(this).data('emp-id');
        var session = $(this).attr('id').split('_')[2];
        var hallDropdownId = `hall_${empId}_${session}`;
       // alert(hallDropdownId);

        if (buildingId && floor) {
            $.ajax({
                url: '<?= base_url("EcrEmpRegController/getHallsByFloor") ?>',
                type: 'POST',
                data: { building_id: buildingId, floor: floor },
                dataType: 'json',
                success: function (halls) {
                    var $hallDropdown = $('#' + hallDropdownId);
                    $hallDropdown.empty().append('<option value="">Select Hall</option>');

                    $.each(halls, function (index, hall) {
                        $hallDropdown.append(`<option value="${hall.id}">${hall.hall_no}</option>`);
                    });

                    $hallDropdown.prop('disabled', false);
                    
                    var selectedHall = $hallDropdown.data('selected-hall');
                    if (selectedHall) {
                        $hallDropdown.val(selectedHall);
                    }
                }
            });
        }
    });

    // Trigger change event on page load for center dropdowns to initialize the cascade
    $('.center-dropdown').each(function() {
        $(this).trigger('change');
    });
    


    $(document).ready(function () {
            $(document).on('change', '.hall-dropdown', function () {
                var hallId = $(this).val();
                var empId = $(this).data('emp-id');

                // Get the role and exam IDs from the selected filters
                var roleId = $('#filter_role').val();
                var examId = $('#filter_exam').val();

                // Get the date directly from the #filter_date input
                var date = $('#filter_date').val();

                //  alert(hallId);
                // Get the session from a hidden input or other source
                var session = $(this).closest('tr').find('input[name="session"]').val();

                //   if (hallId && roleId && examId && date && session) {
                $.ajax({
                    url: '<?= base_url("EcrEmpRegController/updateHallId") ?>',
                    type: 'POST',
                    data: {
                        emp_id: empId,
                        hall_id: hallId,
                        role_id: roleId,
                        exam_id: examId,
                        date: date,         // Pass the date directly from the filter input
                        session: session     // Pass the session value
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            alert(response.message);
                        } else {
                            alert('Something went wrong.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error updating hall:", error);
                        alert('Failed to update hall. Please try again.');
                    }
                });
                //  } else {
                //      alert('Please ensure all required fields (Hall, Role, Exam, Date, Session) are selected.');
                //  }
            });
        });



    });


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
            <form id="filterForm" action="<?= base_url('EcrEmpRegController/employee_hall_allocation') ?>" method="POST">
                <div class="row">
                    <div class="col-sm-2">
                        <select name="filter_exam" id="filter_exam" class="form-control filter_exam" required>
                            <option value="">Select Exam Session</option>
                            <?php foreach ($exam_sessions as $session): ?>
                                <option value="<?= $session->exam_id ?>" <?= isset($filter_exam) && $filter_exam == $session->exam_id ? 'selected' : '' ?>>
                                    <?= $session->exam_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select id="filter_role" name="filter_role" class="form-control filter_role">
                            <option value="">Select Role</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role->ecr_role_id ?>" <?= isset($filter_role) && $filter_role == $role->ecr_role_id ? 'selected' : '' ?>>
                                    <?= $role->role_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
					<div class="col-sm-2">
						<!-- input type="date"
							   id="filter_date"
							   name="filter_date"
							   class="form-control filter_date"
							   value="<?= date('Y-m-d', strtotime('+1 day')) ?>"
							   readonly
							   onkeydown="return false"
							   onmousedown="return false" -->
						<input type="date"
							   id="filter_date"
							   name="filter_date"
							   class="form-control filter_date"
							   value="<?= date('Y-m-d', strtotime('+1 day')) ?>"
							   readonly
							   onkeydown="return false"
							   onmousedown="return false" >
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
    </div>

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
                        value="<?= isset($_GET['ssn']) ? $_GET['ssn'] : '' ?>">

                    <!-- Duty Allocation Table -->
                    <table class="table table-bordered">
                        <thead class="bgdynamic">
                            <tr>
                                <th>Sr.no</th>
                                <th>Employee</th>
                                <th>Date & Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($duty_allocations)): ?>
                                <?php $i = 1;
                                foreach ($duty_allocations as $allocation): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?php echo ($allocation->is_replaced == 1) ? $allocation->replace_emp_id : $allocation->emp_id; ?>
                                            - <?= $allocation->name ?></td>
                                        <td><?= $allocation->date ?> (<?= $allocation->session ?>)<input type="hidden" name="session" value="<?= $allocation->session ?>">
                                        </td>
                                        <td>
											 <!-- Center Dropdown -->
											<select class="form-control center-dropdown" data-emp-id="<?= $allocation->emp_id ?>" data-selected-center="<?= $allocation->center_id ?>" id="center_<?= $allocation->emp_id ?>_<?= $allocation->session ?>">
												<option value="">Select Center</option>
												<?php foreach ($centers as $center): ?>
													<option value="<?= $center->ec_id ?>"><?= $center->center_name ?></option>
												<?php endforeach; ?>
											</select>

											<!-- Building Dropdown -->
											<select class="form-control building-dropdown" data-emp-id="<?= $allocation->emp_id ?>" data-selected-building="<?= $allocation->building_id ?>" id="building_id_<?= $allocation->emp_id ?>_<?= $allocation->session ?>">
												<option value="">Select Building</option>
												<!-- Options dynamically loaded by JS -->
											</select>

											<!-- Floor Dropdown -->
											<select class="form-control floor-dropdown" data-emp-id="<?= $allocation->emp_id ?>" data-selected-floor="<?= $allocation->floor ?>"  id="floor_<?= $allocation->emp_id ?>_<?= $allocation->session ?>">
												<option value="">Select Floor</option>
												<!-- Options dynamically loaded by JS -->
											</select>

											<!-- Hall Dropdown -->
											<select class="form-control hall-dropdown" data-emp-id="<?= $allocation->emp_id ?>" data-selected-hall="<?= $allocation->hall_id ?>" id="hall_<?= $allocation->emp_id ?>_<?= $allocation->session ?>">
												<option value="">Select Hall</option>
												<!-- Options dynamically loaded by JS -->
											</select>

                                        </td>


                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">No duty allocations found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>