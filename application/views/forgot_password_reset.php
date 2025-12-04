<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="<?=base_url()?>assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="container" style="margin-top:50px; max-width:400px;">
        <h3>Reset Password</h3>
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-info"><?= $this->session->flashdata('msg') ?></div>
        <?php endif; ?>
        <form action="<?=site_url('login/forgot_password_reset')?>" method="post">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="6">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
        <div style="margin-top:10px;">
            <a href="<?=site_url('login')?>">Back to Login</a>
        </div>
    </div>
</body>
</html> 