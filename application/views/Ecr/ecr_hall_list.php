<div id="content-wrapper">
    <!-- Breadcrumb -->
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Examination</a></li>
        <li class="active"><a href="#">ECR Hall Allocation</a></li>
    </ul>

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;ECR Hall Allocation
            </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="pull-right">
                    <button id="openModalButton" class="btn btn-primary" data-toggle="modal">Add New Hall</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="panel">
        <div class="panel-heading">
            <form id="filterForm" action="<?= base_url('EcrHallController') ?>" method="get">
                <div class="form-group">
                    <select name="building_filter" id="building_filter" class="form-control" onchange="this.form.submit()">
                        <option value="">Filter by Building</option>
                        <?php foreach ($buildings as $building): ?>
                            <option value="<?= $building->id ?>" <?= isset($build_id) && $build_id == $building->id ? 'selected' : '' ?>><?= $building->building_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>Sr.no</th>
                        <th>Building</th>
                        <th>Floor</th>
                        <th>Hall Number</th>
                        <th>Capacity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; foreach ($halls as $hall): ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><?= $hall->building_id ?></td>
                            <td><?= $hall->floor ?></td>
                            <td><?= $hall->hall_no ?></td>
                            <td><?= $hall->capacity ?></td>
                            <td>
                                <button class="btn btn-info" onclick="openEditModal(<?= $hall->id ?>);">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal HTML and JavaScript logic for add/edit hall will be similar to provided earlier in the response -->

<!-- Add/Edit Hall Modal -->
<div class="modal fade" id="hallModal" tabindex="-1" role="dialog" aria-labelledby="hallModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hallModalLabel">Add Hall</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="hallForm" action="" method="post">
                <div class="modal-body">
                    <!-- Building Dropdown -->
                    <div class="form-group">
                        <label for="building_id">Building</label>
                        <select name="building_id" id="building_id_modal" class="form-control" required>
                            <option value="">Select Building</option>
                            <?php foreach ($buildings as $building): ?>
                                <option value="<?= $building->id ?>"><?= $building->building_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Floor Dropdown -->
                    <div class="form-group">
                        <label for="floor_id">Floor</label>
                        <select name="floor_id" id="floor_id_modal" class="form-control" required>
                            <option value="">Select Floor</option>
                            <?php foreach ($floors as $floor): ?>
                                <option value="<?= $floor->floor_name ?>"><?= $floor->floor_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Hall Number Input -->
                    <div class="form-group">
                        <label for="hall_no">Hall Number</label>
                        <input type="text" name="hall_no" id="hall_no_modal" class="form-control" placeholder="Enter Hall Number" required>
                    </div>
					
					<!-- Hall Type Dropdown -->
					<div class="form-group">
						<label for="hall_type">Hall Type</label>
						<select name="hall_type" id="hall_type_modal" class="form-control" required>
							<option value="">Select Hall Type</option>
							<option value="Classroom">Classroom</option>
							<option value="Lab">Lab</option>
						</select>
					</div>

					<!-- Lab Name Input (Initially Hidden) -->
					<div class="form-group" id="lab_name_group" style="display: none;">
						<label for="lab_name">Lab Name</label>
						<input type="text" name="lab_name" id="lab_name_modal" class="form-control" placeholder="Enter Lab Name">
					</div>
					
                    <!-- Rows Input -->
                    <div class="form-group">
                        <label for="row_no">Rows</label>
                        <input type="number" name="row_no" id="row_no_modal" class="form-control" placeholder="Enter number of rows" min="1" max="30" required>
                    </div>

                    <!-- Columns Input -->
                    <div class="form-group">
                        <label for="col_no">Columns</label>
                        <input type="number" name="col_no" id="col_no_modal" class="form-control" placeholder="Enter number of columns" min="1" max="30" required>
                    </div>

                    <!-- Extra Seats Input -->
                    <div class="form-group">
                        <label for="extra_no">Extra Seats</label>
                        <input type="number" name="extra_no" id="extra_no_modal" class="form-control" placeholder="Enter number of extra seats" min="0" max="30" required>
                    </div>

                    <!-- Capacity (Automatically Calculated) -->
                    <div class="form-group">
                        <label for="capacity">Capacity</label>
                        <input type="number" name="capacity" id="capacity_modal" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Hall</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    // Initialize DataTable
    $('#datatable').DataTable({
        dom: 'Bfrtip',
        buttons: []
    });

    // Open Add Modal
    $('#openModalButton').click(function () {
        $('#hallModalLabel').text('Add New Hall');
        $('#hallForm').attr('action', '<?= base_url('EcrHallController/saveHall') ?>');
        $('#hallForm')[0].reset();
        $('#capacity_modal').val(''); // Clear the capacity field
        $('#hallModal').modal('show');
    });

    // Open Edit Modal
    window.openEditModal = function (hallId) {
        $('#hallModalLabel').text('Edit Hall');
        $('#hallForm').attr('action', '<?= base_url('EcrHallController/updateHall') ?>/' + hallId);

        // Fetch hall details
        $.ajax({
            url: '<?= base_url('EcrHallController/getHallDetails') ?>/' + hallId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log(data); // Inspect data structure

                // Ensure `data` contains expected keys
                if (data) {
                    $('#building_id_modal').val(data.building_id);
                    $('#floor_id_modal').val(data.floor);
                    $('#hall_no_modal').val(data.hall_no);
                    $('#hall_type_modal').val(data.hall_type).trigger('change');
                    $('#lab_name_modal').val(data.lab_name);
                    $('#row_no_modal').val(data.matrix_rows);
                    $('#col_no_modal').val(data.matrix_columns);
                    $('#extra_no_modal').val(data.matrix_extra);
                    $('#capacity_modal').val(data.capacity);
                    $('#hallModal').modal('show');
                } else {
                    alert('Failed to fetch hall details. Please try again.');
                }
            },
            error: function () {
                alert('Error occurred while fetching hall details.');
            }
        });
    };

    // Calculate Capacity dynamically
    $('#row_no_modal, #col_no_modal, #extra_no_modal').on('input', function () {
        calculateCapacity();
    });

    function calculateCapacity() {
        const rows = parseInt($('#row_no_modal').val()) || 0;
        const columns = parseInt($('#col_no_modal').val()) || 0;
        const extras = parseInt($('#extra_no_modal').val()) || 0;
        const capacity = (rows * columns) + extras;
        $('#capacity_modal').val(capacity);
    }
	
	// Show/hide Lab Name based on Hall Type
    $('#hall_type_modal').on('change', function () {
        const selectedType = $(this).val();
        if (selectedType === 'Lab') {
            $('#lab_name_group').show();
            $('#lab_name_modal').attr('required', true);
        } else {
            $('#lab_name_group').hide();
            $('#lab_name_modal').val(''); // Clear value
            $('#lab_name_modal').removeAttr('required');
        }
    });
});


</script>