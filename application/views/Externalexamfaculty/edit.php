<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url('assets/javascripts/bootstrap-datepicker.js')?>"></script>
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<style>
    .panel {
        border-radius: 12px !important;
        box-shadow: 0 3px 10px rgb(26 134 249 / 82%) !important;
        border: none !important;
    }
    .panel-heading {
        background: linear-gradient(90deg, #004aad, #0078d7) !important;
        color: white !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        border-radius: 12px 12px 0 0 !important;
        padding: 12px 20px !important;
    }
    .panel-body {
        background: #027cff17 !important;
        padding: 20px !important;
    }
    label {
        font-weight: 600;
        margin-top: 5px;
    }
    .form-control {
        border-radius: 6px;
        box-shadow: none;
        border: 1px solid #ccc;
        transition: all 0.2s ease;
    }
    .form-control:focus {
        border-color: #0078d7;
        box-shadow: 0 0 0 0.15rem rgba(0, 120, 215, 0.25);
    }
    .btn-primary {
        background: #0078d7 !important;
        border-color: #0078d7 !important;
        border-radius: 6px !important;
        font-weight: 600 !important;
    }
    .btn-primary:hover {
        background: #005fa3 !important;
        border-color: #005fa3 !important;
    }
    .btn-secondary {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .redasterik { color: red; }
    .section-divider {
        border: 0;
        height: 2px;
        background: linear-gradient(to right, #ccc, #007bff, #ccc);
        margin: 15px 0;
        border-radius: 2px;
    }
    .section-title {
        font-weight: 600;
        color: #007bff;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<script>
$(document).ready(function() {
    $('#form').bootstrapValidator({
        message: 'This value is not valid',
        group: 'form-group',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            btype: { validators: { notEmpty: { message: 'Please select Batch Type' } } },
            campus_type: { validators: { notEmpty: { message: 'Please select Campus Type' } } },
            ext_fac_name: { validators: { notEmpty: { message: 'External Faculty Name is required' } } },
            ext_fac_designation: { validators: { notEmpty: { message: 'Please select Designation' } } },
            ext_fac_mobile: {
                validators: {
                    notEmpty: { message: 'Mobile number is required' },
                    regexp: { regexp: /^[0-9]{10}$/, message: 'Enter a valid 10-digit mobile number' }
                }
            },
            ext_fac_email: {
                validators: {
                    notEmpty: { message: 'Email is required' },
                    emailAddress: { message: 'Enter a valid email address' }
                }
            },
            ext_fac_institute: { validators: { notEmpty: { message: 'Institute name is required' } } },
            distance_km: {
                validators: {
                    notEmpty: { message: 'Distance (KM) is required' },
                    numeric: { message: 'Enter a valid numeric distance' }
                }
            },
            bank_name: { validators: { notEmpty: { message: 'Select a Bank' } } },
            acc_holder_name: {
                validators: {
                    notEmpty: { message: 'Account Holder Name is required' },
                    regexp: { regexp: /^[a-zA-Z\s]+$/, message: 'Only alphabets and spaces allowed' }
                }
            },
            acc_no: {
                validators: {
                    notEmpty: { message: 'Account Number is required' },
                    regexp: { regexp: /^[0-9]+$/, message: 'Account number must be numeric' }
                }
            },
            ifsc_code: {
                validators: {
                    notEmpty: { message: 'IFSC Code is required' },
                    regexp: { regexp: /^[A-Z]{4}0[A-Z0-9]{6}$/, message: 'Enter valid IFSC Code (e.g. SBIN0001234)' }
                }
            },
            branch: {
                validators: {
                    notEmpty: { message: 'Branch name is required' },
                    regexp: { regexp: /^[a-zA-Z0-9\s]+$/, message: 'Only alphabets, numbers and spaces allowed' }
                }
            },
            cheque_file: {
                validators: {
                    file: {
                        extension: 'jpeg,jpg,png,gif,pdf',
                        type: 'image/jpeg,image/png,image/gif,application/pdf',
                        maxSize: 2097152,
                        message: 'Allowed: jpeg, jpg, png, gif, pdf (max 2MB)'
                    }
                }
            },
            id_card_file: {
                validators: {
                    file: {
                        extension: 'jpeg,jpg,png,gif,pdf',
                        type: 'image/jpeg,image/png,image/gif,application/pdf',
                        maxSize: 2097152,
                        message: 'Allowed: jpeg, jpg, png, gif, pdf (max 2MB)'
                    }
                }
            }
        }
    });
});
</script>

<?php $astrik = '<sup class="redasterik">*</sup>'; ?>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <li><a href="#">Masters</a></li>
        <li class="active">Edit External Faculty</li>
    </ul>

    <div class="panel">
        <div class="panel-heading">
            <i class="fa fa-id-card"></i> External Faculty Details
        </div>

        <div class="panel-body">
            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                <input type="hidden" name="fac_id" value="<?=isset($campus_details['id'])?$campus_details['id']:''?>">
                <input type="hidden" name="emp_code" value="<?=isset($campus_details['ext_faculty_code'])?$campus_details['ext_faculty_code']:''?>">

                <!-- Personal Details -->
                <h4 class="section-title">Personal Details</h4>
                <hr class="section-divider">

                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Batch Type <?=$astrik?></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="btype">
                                <option value="">-- Select --</option>
                                <option value="1" <?=isset($campus_details['btype'])&&$campus_details['btype']=='1'?'selected':''?>>Regular</option>
                                <option value="2" <?=isset($campus_details['btype'])&&$campus_details['btype']=='2'?'selected':''?>>Ph.D</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Campus Type <?=$astrik?></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="campus_type">
                                <option value="">-- Select --</option>
                                <option value="inside_campus" <?=isset($campus_details['campus_type'])&&$campus_details['campus_type']=='inside_campus'?'selected':''?>>Inside Campus (Sandip University/Sandip Foundation)</option>
                                <option value="outside_campus" <?=isset($campus_details['campus_type'])&&$campus_details['campus_type']=='outside_campus'?'selected':''?>>Outside Campus</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Name <?=$astrik?></label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="ext_fac_name" value="<?=isset($campus_details['ext_fac_name'])?$campus_details['ext_fac_name']:''?>"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Designation <?=$astrik?></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="ext_fac_designation">
                                <option value="">-- Select --</option>
                                <?php 
									$designations = ['Assistant Professor','Associate Professor','Professor','External','Previewer','Advocate','Consultant','Industry Person'];
									foreach($designations as $desig){
										$selected = (isset($campus_details['ext_fac_designation']) && $campus_details['ext_fac_designation']==$desig)?'selected':'';
										echo "<option value='$desig' $selected>$desig</option>";
									}
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Mobile <?=$astrik?></label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="ext_fac_mobile" maxlength="10" value="<?=isset($campus_details['ext_fac_mobile'])?$campus_details['ext_fac_mobile']:''?>"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Email <?=$astrik?></label>
                        <div class="col-sm-8"><input type="email" class="form-control" name="ext_fac_email" value="<?=isset($campus_details['ext_fac_email'])?$campus_details['ext_fac_email']:''?>"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Institute Name<?=$astrik?></label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="ext_fac_institute" value="<?=isset($campus_details['ext_fac_institute'])?$campus_details['ext_fac_institute']:''?>"></div>
                    </div> 

					<div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Institute Address<?=$astrik?></label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="ext_fac_institute_address" value="<?=isset($campus_details['ext_fac_institute_address'])?$campus_details['ext_fac_institute_address']:''?>"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Distance (KM)</label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="distance_km" value="<?=isset($campus_details['distance_km'])?$campus_details['distance_km']:''?>"></div>
                    </div>
                </div>

                <!-- Bank Details -->
                <h4 class="section-title">Bank Details</h4>
                <hr class="section-divider">

                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Bank <?=$astrik?></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="bank_name">
                                <option value="">Select Bank</option>
                                <?php foreach($bank_details as $bank){ 
                                    $selected = (isset($campus_details['bank_id']) && $campus_details['bank_id']==$bank['bank_id'])?'selected':''; ?>
                                    <option value="<?=$bank['bank_id']?>" <?=$selected?>><?=$bank['bank_name']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Account Holder Name <?=$astrik?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="acc_holder_name" value="<?=isset($campus_details['acc_holder_name'])?$campus_details['acc_holder_name']:''?>">
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Account No <?=$astrik?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="acc_no" value="<?=isset($campus_details['acc_no'])?$campus_details['acc_no']:''?>">
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">IFSC Code <?=$astrik?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="ifsc_code" value="<?=isset($campus_details['ifsc_code'])?$campus_details['ifsc_code']:''?>">
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Branch <?=$astrik?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="branch" value="<?=isset($campus_details['branch'])?$campus_details['branch']:''?>">
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Passbook/Cheque File</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="cheque_file">
							<?php if ($campus_details['cheque_file'] != ''): 
								$b_name = "uploads/phd_renumaration_files/";
								$dwnld_url = base_url()."Upload/download_s3file/".$campus_details['cheque_file'].'?b_name='.$b_name;
							?>
								<a href="<?=$dwnld_url?>" class="download-link" download>
									<i class="fa fa-file-pdf-o" style="color:red;font-size:24px" aria-hidden="true"></i>
								</a>
							<?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Upload ID Card -->
                <h4 class="section-title">ID Card</h4>
                <hr class="section-divider">

                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="col-sm-4 control-label">Upload ID Card</label>
                        <div class="col-sm-8">
						<input type="file" class="form-control" name="id_card_file">
						<?php if ($campus_details['id_card_file'] != ''): 
							$b_name = "uploads/phd_renumaration_files/";
							$dwnld_url = base_url()."Upload/download_s3file/".$campus_details['id_card_file'].'?b_name='.$b_name;
						?>
							<a href="<?=$dwnld_url?>" class="download-link" download>
								<i class="fa fa-file-pdf-o" style="color:red;font-size:24px" aria-hidden="true"></i>
							</a>
						<?php endif; ?>
						</div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <button class="btn btn-primary" type="submit">Submit</button>
                    <button class="btn btn-secondary" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>
