<!DOCTYPE html>
<html>
<head>
    <title>Add Bank Account</title>
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container-fluid" style="margin-top:70px;">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">Add Bank Account</h4>
        </div>
        <div class="panel-body" style="background-color:rgb(217, 237, 247);">
		<!-- Flash Messages -->
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>✅ Success!</strong> <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>⚠️ Error!</strong> <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>
            <?= form_open('bankaccount/create', ['class' => 'form-horizontal']) ?>
			 <div class="form-group">
                <div class="col-md-6">
                    <input type="text" name="institute_name" class="form-control"
                           placeholder="Institute Name"
                           value="<?= set_value('institute_name') ?>">
                    <small class="text-danger"><?= form_error('institute_name') ?></small>
                </div>
                
            </div>
			<div class="form-group">
                <div class="col-md-6">
                    <input type="text" name="account_name" class="form-control"
                           placeholder="Account Holder Name"
                           value="<?= set_value('account_name') ?>">
                    <small class="text-danger"><?= form_error('account_name') ?></small>
                </div>
                <div class="col-md-6">
                    <input type="text" name="account_number" class="form-control"
                           placeholder="Account Number"
                           value="<?= set_value('account_number') ?>">
                    <small class="text-danger"><?= form_error('account_number') ?></small>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <input type="text" name="bank_name" class="form-control"
                           placeholder="Bank Name"
                           value="<?= set_value('bank_name') ?>">
                    <small class="text-danger"><?= form_error('bank_name') ?></small>
                </div>
                <div class="col-md-6">
                    <input type="text" name="branch_name" class="form-control"
                           placeholder="Branch Name"
                           value="<?= set_value('branch_name') ?>">
                    <small class="text-danger"><?= form_error('branch_name') ?></small>
                </div>
            </div>
			<div class="form-group">
                <div class="col-md-4">
                    <select name="signatory_authority" class="form-control">
                        <option value="">-- Signatory Authority Type --</option>
                        <option value="Single" <?= set_select('signatory_authority','Single') ?>>Single</option>
                        <option value="Joint" <?= set_select('signatory_authority','Joint') ?>>Joint</option>
   
                    </select>
                    <small class="text-danger"><?= form_error('signatory_authority') ?></small>
                </div>
                <div class="col-md-4">
                    <input type="text" name="signatory_authority_names1" class="form-control"
                           placeholder="Signatory Authority Name 1"
                           value="<?= set_value('signatory_authority_names1') ?>">
                    <small class="text-danger"><?= form_error('signatory_authority_names1') ?></small>
                </div>
				<div class="col-md-4">
                    <input type="text" name="signatory_authority_names2" class="form-control"
                           placeholder="Signatory Authority Name2"
                           value="<?= set_value('signatory_authority_names2') ?>">
                    <small class="text-danger"><?= form_error('signatory_authority_names2') ?></small>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <input type="text" name="ifsc_code" class="form-control"
                           placeholder="IFSC Code"
                           value="<?= set_value('ifsc_code', isset($account) ? html_escape($account->ifsc_code) : '') ?>">
                    <small class="text-danger"><?= form_error('ifsc_code') ?></small>
                </div>
                <div class="col-md-4">
                    <select name="account_type" class="form-control">
                        <option value="">-- Account Type --</option>
                        <option value="Savings" <?= set_select('account_type','Savings') ?>>Savings</option>
                        <option value="Current" <?= set_select('account_type','Current') ?>>Current</option>
                        <option value="OD" <?= set_select('account_type','OD') ?>>OD</option>
                    </select>
                    <small class="text-danger"><?= form_error('account_type') ?></small>
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-control">
                        <option value="">-- Status --</option>
                        <option value="Active" <?= set_select('status','Active') ?>>Active</option>
                        <option value="Inactive" <?= set_select('status','Inactive') ?>>Inactive</option>
                    </select>
                    <small class="text-danger"><?= form_error('status') ?></small>
                </div>
            </div>
	
            <div class="form-group">
                <div class="col-md-4">
                    <input type="text" name="poc_name" class="form-control"
                           placeholder="POC Name"
                           value="<?= set_value('poc_name') ?>">
                    <small class="text-danger"><?= form_error('poc_name') ?></small>
                </div>
                <div class="col-md-4">
                    <input type="text" name="poc_number" class="form-control"
                           placeholder="POC Number"
                           value="<?= set_value('poc_number') ?>">
                    <small class="text-danger"><?= form_error('poc_number') ?></small>
                </div>
				 <div class="col-md-4">
                    <input type="text" name="poc_email" class="form-control"
                           placeholder="POC Email"
                           value="<?= set_value('poc_email') ?>">
                    <small class="text-danger"><?= form_error('poc_email') ?></small>
                </div>
            </div>

            

            <div class="form-group">
                <div class="col-md-12">
                    <textarea name="remarks" class="form-control" placeholder="Remarks"><?= set_value('remarks') ?></textarea>
                    <small class="text-danger"><?= form_error('remarks') ?></small>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12 text-right">
                    <a href="<?= site_url('bankaccount') ?>" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
