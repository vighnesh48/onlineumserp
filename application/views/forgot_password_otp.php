<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enter OTP</title>
    <link href="<?=base_url()?>assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="container" style="margin-top:50px; max-width:400px;">
        <h3>Enter OTP</h3>
        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-info"><?= $this->session->flashdata('msg') ?></div>
        <?php endif; ?>
        <form action="<?=site_url('login/forgot_password_otp')?>" method="post">
            <div class="form-group">
                <label for="otp">Enter the OTP sent to your registered mobile number</label>
                <input type="text" name="otp" id="otp" class="form-control" required maxlength="6" pattern="[0-9]{6}">
            </div>
            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
        <div style="margin-top:10px;">
            <a href="<?=site_url('login/forgot_password')?>">Back</a>
        </div>
    </div>
</body>
</html> 