<!DOCTYPE html>
<html>
<head>
    <title>Edit Bank Account</title>
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container-fluid" style="margin-top:70px;">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">Edit Bank Account</h4>
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

            <?= form_open('bankaccount/edit/'.$account->id, ['class' => 'form-horizontal']) ?>

            <div class="form-group">
                <div class="col-md-6">
                    <label>Bank Name</label>
                    <input type="text" name="bank_name" class="form-control"
                           value="<?= set_value('bank_name', html_escape($account->bank_name)) ?>">
                    <small class="text-danger"><?= form_error('bank_name') ?></small>
                </div>
                <div class="col-md-6">
                    <label>Branch Name</label>
                    <input type="text" name="branch_name" class="form-control"
                           value="<?= set_value('branch_name', html_escape($account->branch_name)) ?>">
                    <small class="text-danger"><?= form_error('branch_name') ?></small>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6">
                    <label>Account Name</label>
                    <input type="text" name="account_name" class="form-control"
                           value="<?= set_value('account_name', html_escape($account->account_name)) ?>">
                    <small class="text-danger"><?= form_error('account_name') ?></small>
                </div>
                <div class="col-md-6">
                    <label>Account Number</label>
                    <input type="text" name="account_number" class="form-control"
                           value="<?= set_value('account_number', html_escape($account->account_number)) ?>">
                    <small class="text-danger"><?= form_error('account_number') ?></small>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4">
                    <label>IFSC Code</label>
                    <input type="text" name="ifsc_code" class="form-control"
                           value="<?= set_value('ifsc_code', html_escape($account->ifsc_code)) ?>">
                    <small class="text-danger"><?= form_error('ifsc_code') ?></small>
                </div>
                <div class="col-md-4">
                    <label>Account Type</label>
                    <select name="account_type" class="form-control">
                        <option value="">-- Account Type --</option>
                        <option value="Savings" <?= set_select('account_type','Savings', $account->account_type=='Savings') ?>>Savings</option>
                        <option value="Current" <?= set_select('account_type','Current', $account->account_type=='Current') ?>>Current</option>
                        <option value="OD" <?= set_select('account_type','OD', $account->account_type=='OD') ?>>OD</option>
                    </select>
                    <small class="text-danger"><?= form_error('account_type') ?></small>
                </div>
                <div class="col-md-4">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">-- Status --</option>
                        <option value="Active" <?= set_select('status','Active', $account->status=='Active') ?>>Active</option>
                        <option value="Inactive" <?= set_select('status','Inactive', $account->status=='Inactive') ?>>Inactive</option>
                    </select>
                    <small class="text-danger"><?= form_error('status') ?></small>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6">
                    <label>POC Name</label>
                    <input type="text" name="poc_name" class="form-control"
                           value="<?= set_value('poc_name', html_escape($account->poc_name)) ?>">
                    <small class="text-danger"><?= form_error('poc_name') ?></small>
                </div>
                <div class="col-md-6">
                    <label>POC Number</label>
                    <input type="text" name="poc_number" class="form-control"
                           value="<?= set_value('poc_number', html_escape($account->poc_number)) ?>">
                    <small class="text-danger"><?= form_error('poc_number') ?></small>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label>Remarks</label>
                    <textarea name="remarks" class="form-control"><?= set_value('remarks', html_escape($account->remarks)) ?></textarea>
                    <small class="text-danger"><?= form_error('remarks') ?></small>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12 text-right">
                    <a href="<?= site_url('bankaccount') ?>" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
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
