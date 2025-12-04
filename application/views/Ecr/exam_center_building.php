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
            <li class="active"><a href="#">ECR Exam Center Building Allocation </a></li>
        </ul>
        <div class="page-header">
            <div class="row">
                <h1 class="col-xs-12 col-sm-4 text-left-sm"><i
                        class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;ECR Exam Center Building Allocation </h1>
                        <div class="col-xs-12 col-sm-8">
                            <div class="row"> 
				            	<br/>				
				            	<span id="flash-messages" style="color:Green;padding-left:50px;">
				            		 <?php if(!empty($this->session->flashdata('success'))){ echo $this->session->flashdata('success'); } ?></span>
				            	<span id="flash-message" style="color:red;padding-left:50px;">
				            		 <?php if(!empty($this->session->flashdata('error'))){ echo $this->session->flashdata('error'); } ?></span>
                                <hr class="visible-xs no-grid-gutter-h">
                            </div>
                        </div>
                        
                <div class="col-xs-12 col-sm-8"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <span class="panel-title"></span>
                        </div>
                        <div class="panel-body" style="overflow:scroll;height:800px;">
                            <div class="col-lg-12">
                                <form id="ecrEmployeeForm"
                                    action="<?php echo base_url('EcrHallController/saveExamCenterBuilding'); ?>"
                                    method="post" onsubmit="return validateForm();">

                                    <!-- Exam Session -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Exam Session <span class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="session_id" id="session_id" class="form-control">
                                                <option value="">Select Exam Session</option>
                                                <?php foreach ($exam_sessions as $exam_session): ?>
                                                    
                                                    <option value="<?= $exam_session->exam_id ?>" selected><?= $exam_session->exam_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small id="sessionError" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <!-- Center -->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Exam Center <span class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="center_id" id="center_id" class="form-control">
                                                <option value="">Select Center</option>
                                                <?php foreach ($exam_centers as $exam_center): ?>
                                                    <option value="<?= $exam_center->ec_id ?>"><?= $exam_center->center_name ?> (<?php echo $exam_center->center_code ?>)</option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small id="centerError" class="text-danger"></small>
                                        </div>
                                    </div>

                                      <!-- Building -->
                                      <div class="form-group">
                                        <label class="col-sm-3 control-label">Exam Building <span class="redasterik">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="building_id" id="building_id" class="form-control">
                                                <option value="">Select Building</option>
                                                <?php foreach ($buildings as $building): ?>
                                                    <option value="<?= $building->id ?>"><?= $building->building_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small id="buildingrError" class="text-danger"></small>
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
                document.getElementById('sessionError').textContent = "";
                document.getElementById('centerError').textContent = "";
                document.getElementById('buildingrError').textContent = "";

                // Exam Center validation
                const session = document.getElementById('session_id').value;
                if (session === "") {
                    document.getElementById('sessionError').textContent = "Please select an exam session";
                    isValid = false;
                }

                // Floor validation
                const center = document.getElementById('center_id').value;
                if (center === "") {
                    document.getElementById('centerError').textContent = "Please select an exam center ";
                    isValid = false;
                }

                const building = document.getElementById('building_id').value;
                if (building === "") {
                    document.getElementById('buildingrError').textContent = "Please select an exam Building ";
                    isValid = false;
                }

             
                return isValid;
            }

            setTimeout(function() {
                document.getElementById('flash-messages').innerHTML = '';
            }, 5000);

        </script>
    </div>
</body>

</html>
