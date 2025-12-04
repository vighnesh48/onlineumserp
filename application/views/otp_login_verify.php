<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Sign In -ERP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<!-- Open Sans font from Google CDN -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

	<!-- Pixel Admin's stylesheets -->
	<link href="<?=base_url()?>assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">

<style>
body, html {
  height: 100%;
  margin: 0;
}

.bg {
  /* The image used */
  /*background-image: url("https://erp.sandipuniversity.com/uploads/desktop---bala.png")!important;*/

  /* Full height */
  height: 100%; 

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
</head>
<body class="theme-default page-signin" >
	<!-- Page background -->
	<div id="page-signin-bg">
		<!-- Background overlay -->
		<div class="overlay" style="background: rgba(0,0,0,0.2)!important;"></div>
		<!-- Replace this with your bg image -->		
	</div>
	<!-- Page background -->
	<!-- Container -->
	<div class="signin-container">
		<!-- Left side -->
       <div class="signin-info" style="background-color:#eaeaea">
		<a href="https://www.sandipuniversity.edu.in/" class="logo" target="_blank">
         <center>
		    <img src="<?=base_url()?>assets/images/su-logo.png" alt="Sandip University" style="padding-bottom: 10px;">
				</center>
			</a>
            <span style="font-size:25px;font-weight:bold;"><center> ERP </center></span>
		</div>
		<div class="signin-form">
		<!-- Form -->
			<form action="<?=base_url('login/otp_login_verify')?>" id="signin-form_id" method="post">
			
				<div class="signin-text">
					<span>Welcome &nbsp;<?=$username?></span>
				</div> <!-- / .signin-text -->
				 <?php if(!empty($this->session->flashdata('msg'))){ ?>
					  <div class="row" style="color:green;text-align:center">					 
				  <?php  echo $this->session->flashdata('msg');?>                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
				 <?php } ?>
				   <?php if(!empty($this->session->flashdata('msg1'))){ ?>
					  <div class="row" style="color:red;text-align:center ">					 
				  <?php  echo $this->session->flashdata('msg1');?>                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
				 <?php } ?>
				<div class="form-group w-icon">
					<input type="text" name="otp" id="otp" class="form-control input-lg" placeholder="Enter OTP" minlength=6 maxlength=6 pattern="[0-9]+" required>
					<span class="fa fa-user signin-form-icon"></span>
				</div> 
                 <div class="form-group"></div>
				<div class="form-actions text-center">
					<input type="submit" name="votp" value="Verify OTP" class="signin-btn " style="background-color:#ed3237;color: white">
				</div> <!-- / .form-actions -->
				<input type="hidden" name="mobile_no" value="<?=$mobile?>">
				<input type="hidden" name="username" value="<?=$username?>">
				<input type="hidden" name="roles_id" value="<?=$roles_id?>">
				<!-- CSRF Token -->
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			</form>
			<!-- / Form -->
		</div>
		<!-- Right side -->	
	</div>
	<!-- / Container -->
</body>
</html>
