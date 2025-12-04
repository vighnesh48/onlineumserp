<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/jPages.css">
<script src="<?= base_url('assets/javascripts') ?>/jPages.js"></script>
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<?php //print_r($my_privileges); die; 
?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php
define('SITE_KEY', "6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI");
define('SECRET_KEY', "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe");
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?= base_url($currentModule) ?>">Google Captcha</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Google Captcha</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="fas fa-shield-alt"></i> Google Captcha</h4>
                    </div>

                    <div class="panel-body p-4" style="max-height: 500px; overflow-x: auto;">
                      
                        <?php if ($this->session->flashdata('message_event_success')): ?>
                            <div class="alert alert-success">
                                <?= $this->session->flashdata('message_event_success'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('message_event_error')): ?>
                            <div class="alert alert-danger">
                                <?= $this->session->flashdata('message_event_error'); ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('Event/validate_captcha') ?>" method="POST">
                            <div class="row align-items-center mb-3">
                   
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Your Name:</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Captcha Verification:</label>
                                    <div class="g-recaptcha" data-sitekey="<?php echo SITE_KEY; ?>"></div>
                                    <span class="text-danger" id="captcha-error"><?= $errors['g-recaptcha-response'] ?? '' ?></span>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-paper-plane"></i> Submit
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>