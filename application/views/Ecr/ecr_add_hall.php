<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECR Employee Registration</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
</head>

<body>
    <div id="content-wrapper">
        <ul class="breadcrumb breadcrumb-page">
            <div class="breadcrumb-label text-light-gray">You are here: </div>
            <li class="active"><a href="#">Examination</a></li>
            <li class="active"><a href="#">ECR Hall Allocation</a></li>
        </ul>
        <div class="page-header">
            <div class="row">
                <h1 class="col-xs-12 col-sm-4 text-left-sm">
                    <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;ECR Hall Allocation
                </h1>
                <div class="col-xs-12 col-sm-8">
                    <div class="row">
                        <br />
                        <span id="flash-messages" style="color:Green;padding-left:50px;">
                            <?php if(!empty($this->session->flashdata('success'))){ echo $this->session->flashdata('success'); } ?>
                        </span>
                        <span id="flash-message" style="color:red;padding-left:50px;">
                            <?php if(!empty($this->session->flashdata('error'))){ echo $this->session->flashdata('error'); } ?>
                        </span>
                        <hr class="visible-xs no-grid-gutter-h">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title"></span>
                        </div>
                        <div class="panel-body" style="overflow:scroll;height:800px;">
                            <div class="col-lg-12">
                                <form id="ecrEmployeeForm" action="<?php echo base_url('EcrHallController/saveHall'); ?>" method="post" onsubmit="return validateForm();">
                                    
                                    <!-- Building -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Exam Building <span class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="building_id" id="building_id" class="form-control">
                                                <option value="">Select Building</option>
                                                <?php foreach ($buildings as $building): ?>
                                                    <option value="<?= $building->id ?>" <?= set_select('building_id', $building->id) ?>><?= $building->building_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small id="buildingrError" class="text-danger"><?php echo form_error('building_id'); ?></small>
                                        </div>
                                    </div>

                                    <!-- Floor -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Select Floor <span class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="floor_id" id="floor_id" class="form-control">
                                                <option value="">Select Floor</option>
                                                <?php foreach ($floors as $floor): ?>
                                                    <option value="<?= $floor->floor_name ?>" <?= set_select('floor_id', $floor->floor_name) ?>><?= $floor->floor_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small id="floorError" class="text-danger"><?php echo form_error('floor_id'); ?></small>
                                        </div>
                                    </div>
                                    
                                    <!-- Hall Matrix -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Enter Seats Rows <span class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="number" name="row_no" id="row_no" class="form-control" placeholder="Enter Number of Rows" min="1" max="30" value="<?php echo set_value('row_no'); ?>">
                                            <small id="rowNoError" class="text-danger"><?php echo form_error('row_no'); ?></small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Enter Seats Columns <span class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="number" name="col_no" id="col_no" class="form-control" placeholder="Enter Number of Columns" min="1" max="30" value="<?php echo set_value('col_no'); ?>">
                                            <small id="colNoError" class="text-danger"><?php echo form_error('col_no'); ?></small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Enter Extra Seats <span class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="number" name="extra_no" id="extra_no" class="form-control" placeholder="Enter Extra Seats" min="0" max="30" value="<?php echo set_value('extra_no'); ?>">
                                            <small id="extraError" class="text-danger"><?php echo form_error('extra_no'); ?></small>
                                        </div>
                                    </div>
                                    
                                    <!-- Hall Capacity -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Enter Hall Capacity <span class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="number" name="capacity" id="capacity" class="form-control" readonly value="<?php echo set_value('capacity'); ?>">
                                            <small id="capacityError" class="text-danger"><?php echo form_error('capacity'); ?></small>
                                        </div>
                                    </div>

                                    <!-- Hall Number -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Enter Hall Number <span class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="hall_no" id="hall_no" class="form-control" placeholder="Enter Hall Number" required value="<?php echo set_value('hall_no'); ?>">
                                            <small id="hallNoError" class="text-danger"><?php echo form_error('hall_no'); ?></small>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group">
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-2">
                                            <button type="submit" class="btn btn-primary form-control">Submit</button>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-secondary form-control" onclick="window.location='<?= base_url('EcrHallController') ?>'">Cancel</button>
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

        <script>
             function validateForm() {
                let isValid = true;

                // Clear previous error messages
                document.getElementById('buildingrError').textContent = "";
                document.getElementById('floorError').textContent = "";
                document.getElementById('rowNoError').textContent = ""; 
                document.getElementById('colNoError').textContent = "";
                document.getElementById('extraError').textContent = "";
                document.getElementById('capacityError').textContent = "";
                document.getElementById('hallNoError').textContent = "";

                // Floor validation
                const building = document.getElementById('building_id').value;
                if (building === "") {
                    document.getElementById('buildingrError').textContent = "Please select an exam Building ";
                    isValid = false;
                }

                const floor = document.getElementById('floor_id').value;
                if (floor === "") {
                    document.getElementById('floorError').textContent = "Please select an exam Floor ";
                    isValid = false;
                }

                const row = document.getElementById('row_no').value;
                if (row === "") {
                    document.getElementById('rowNoError').textContent = "Please select an exam Row ";
                    isValid = false;
                }

                const col = document.getElementById('col_no').value;
                if (col === "") {
                    document.getElementById('colNoError').textContent = "Please select an exam Column ";
                    isValid = false;
                }

                const extra = document.getElementById('extra_no').value;
                if (extra === "") {
                    document.getElementById('extraError').textContent = "Please select an exam Extra ";
                    isValid = false;
                }

                const capacity = document.getElementById('capacity').value;
                if (capacity === "") {
                    document.getElementById('capacityError').textContent = "Please select an exam Capacity ";
                    isValid = false;
                }

                const hall = document.getElementById('hall_no').value;
                if (hall === "") {
                    document.getElementById('hallNoError').textContent = "Please select an exam Hall Number ";
                    isValid = false;
                }
             
                return isValid;
            }

            // Calculate and set hall capacity
            function calculateCapacity() {
                const rows = parseInt(document.getElementById('row_no').value) || 0;
                const columns = parseInt(document.getElementById('col_no').value) || 0;
                const extraSeats = parseInt(document.getElementById('extra_no').value) || 0;
                
                const capacity = (rows * columns) + extraSeats;
                document.getElementById('capacity').value = capacity;
            }

            // Add event listeners to recalculate capacity on input change
            document.getElementById('row_no').addEventListener('input', calculateCapacity);
            document.getElementById('col_no').addEventListener('input', calculateCapacity);
            document.getElementById('extra_no').addEventListener('input', calculateCapacity);

            setTimeout(function() {
                document.getElementById('flash-messages').innerHTML = '';
            }, 5000);
        </script>

    </div>
</body>

</html>
