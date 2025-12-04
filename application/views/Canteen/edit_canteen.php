<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
.panel-heading {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc;
}
</style>


<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
   //echo "<pre>";
   //echo $total_fees['fee_paid'];
 // print_r($student_details);
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Canteen </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Canteen </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row"> 
						<br/>				
					<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message_canteen_1'))){ echo $this->session->flashdata('message_canteen_1'); } ?></span>
					<span id="flash-message" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message_canteen_2'))){ echo $this->session->flashdata('message_canteen_2'); } ?></span>
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Edit Canteen </span>
						
						<span id="message" style="color:red;padding-left:200px;"></span>
                        <div class="holder"></div>
					</div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                        <form id="form" name="form" action="<?= base_url($currentModule.'/update_canteen') ?>" method="POST" onsubmit="return validateForm(event)">
                            <input type="hidden" value="<?= $canteen_details['id'] ?>" id="id" name="id" />

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label>Canteen Name <?=$astrik?></label>
                                    <input type="text" class="form-control" name="cName" id="cName" placeholder="Enter Canteen Name" value="<?= $canteen_details['cName'] ?>" required>
                                    <span style="color:red;" id="cNameError"></span>
                                </div>

                                <div class="col-sm-4">
                                    <label>Canteen Contact No. <?=$astrik?></label>
                                    <input type="text" class="form-control" name="cPhone" id="cPhone" placeholder="Enter Canteen Contact No." value="<?= $canteen_details['cPhone'] ?>" required>
                                    <span style="color:red;" id="cPhoneError"></span>
                                </div>

                                <div class="col-sm-4">
                                    <label>Canteen Code <?=$astrik?></label>
                                    <input type="text" class="form-control" name="cId" id="cId" placeholder="Enter Canteen Code" value="<?= $canteen_details['cId'] ?>" required>
                                    <span style="color:red;" id="cIdError"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label>Canteen Address <?=$astrik?></label>
                                    <textarea name="cAddress" id="cAddress" class="form-control" placeholder="Enter Canteen Address" required><?= $canteen_details['cAddress'] ?></textarea>
                                    <span style="color:red;" id="cAddressError"></span>
                                </div>

                                <div class="col-sm-4">
                                    <label>Enter Machine ID</label>
                                    <input type="text" class="form-control" name="machine_id" id="machine_id" placeholder="Enter Machine ID" value="<?= $canteen_details['machine_id'] ?>" required>
                                    <span style="color:red;" id="machineIdError"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2">
                                    <button class="btn btn-primary form-control" id="btn_submit" type="submit">Update</button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?= base_url($currentModule) ?>'">Cancel</button>
                                </div>
                            </div>
                        </form>
                            
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>

<script>
    function validateForm(event) {
        let isValid = true;

        // Reset error messages
        document.getElementById('cNameError').innerText = '';
        document.getElementById('cPhoneError').innerText = '';
        document.getElementById('cIdError').innerText = '';
        document.getElementById('cAddressError').innerText = '';
        document.getElementById('machineIdError').innerText = '';

        // Canteen Name validation
        const cName = document.getElementById('cName').value;
        if (cName.trim() === '') {
            document.getElementById('cNameError').innerText = 'Canteen Name is required.';
            isValid = false;
        }

        // Canteen Contact No validation
        const cPhone = document.getElementById('cPhone').value;
        const phonePattern = /^[0-9]{10}$/; // Adjust this pattern based on your requirement
        if (!phonePattern.test(cPhone)) {
            document.getElementById('cPhoneError').innerText = 'Enter a valid 10-digit contact number.';
            isValid = false;
        }

        // Canteen Code validation
        const cId = document.getElementById('cId').value;
        if (cId.trim() === '') {
            document.getElementById('cIdError').innerText = 'Canteen Code is required.';
            isValid = false;
        }

        // Canteen Address validation
        const cAddress = document.getElementById('cAddress').value;
        if (cAddress.trim() === '') {
            document.getElementById('cAddressError').innerText = 'Canteen Address is required.';
            isValid = false;
        }

        // Machine ID validation
        const machineId = document.getElementById('machine_id').value;
        if (machineId.trim() === '') {
            document.getElementById('machineIdError').innerText = 'Machine ID is required.';
            isValid = false;
        }

        // If any validation fails, prevent form submission
        if (!isValid) {
            event.preventDefault();
        }

        return isValid;
    }
</script>
