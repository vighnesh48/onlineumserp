<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Sign In - ERP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<!-- Open Sans font from Google CDN -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

	<!-- Pixel Admin's stylesheets -->
	<link href="<?=base_url()?>assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">
<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->


<!-- $DEMO =========================================================================================

	Remove this section on production
-->
	
<!-- / $DEMO -->

</head>


<!-- 1. $BODY ======================================================================================
	
	Body

	Classes:
	* 'theme-{THEME NAME}'
	* 'right-to-left'     - Sets text direction to right-to-left
-->
<body class="theme-default page-signin">


	<!-- Page background -->
	<div id="page-signin-bg">
		<!-- Background overlay -->
		<div class="overlay"></div>
		<!-- Replace this with your bg image -->
		
	</div>
	<!-- / Page background -->

	<!-- Container -->
	<div class="signin-container">

		<!-- Left side -->
                <div class="signin-info" style="background-color:#f7f7f7">
			<a href="" class="logo">
                            <center>
				<img src="<?=base_url()?>assets/images/logo.png" alt="" style="margin-top: -5px;">
				</center>
			</a> <!-- / .logo -->
			 <!-- / .slogan -->
			<!--<ul>
				<li><i class="fa fa-sitemap signin-icon"></i> Flexible modular structure</li>
				<li><i class="fa fa-file-text-o signin-icon"></i> LESS &amp; SCSS source files</li>
				<li><i class="fa fa-outdent signin-icon"></i> RTL direction support</li>
				<li><i class="fa fa-heart signin-icon"></i> Crafted with love</li>
			</ul>  / Info list -->
		</div>
		<!-- / Left side -->

		<!-- Right side -->
		<div class="signin-form">

			<!-- Form -->
			<?php 
			/*if($roleid || $_REQUEST['role']=='4'){$role="Student Login"; }
			elseif($roleid || $_REQUEST['role']=='9'){$role="Parent Login";}
			else
			{
		$role="Staff Login";	    
			}
			*/
			?>
			<form action="" id="signin-form_id" method="post">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				<div class="signin-text">
					<span>Forgot Password :<span style="color:red"><?php //if($utype!=''){echo $utype;}else{echo "Staff";} //echo $login_user; ?> </span></span>
				</div> <!-- / .signin-text -->
				<?if(@$this->session->flashdata('msg')){?><div class="has-error"><span class="form-control-feedback"><?=@$this->session->flashdata('msg')?></span></div><br><? }?>
				<?/*if($msg!=''){?><div class="has-error"><span class="form-control-feedback"><?=$msg?></span></div><br><? }*/?>
				<span style="color:red" id="espan"></span>
				<div class="form-group w-icon">
					<input type="text" name="signin_username" id="username_id" class="form-control input-lg" value="" placeholder="Staff ID" required>
					<span class="fa fa-user signin-form-icon"></span>
				</div> <!-- / Username -->

   <div class=" form-group date w-icon" id="dob-datepicker"> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span> <input type="text" id="dob" name="dob" class="form-control input-lg" style="padding-left: 18px;"  value="" placeholder="Date of Birth" required />
                                          
                                       </div></div>
    
    
   <div class=" form-group date w-icon" id="otpid"> 
                                       </div>       

				<div class="form-actions">
					<input type="button" name="button" value="Reset Password" id="signin-btn" class="signin-btn" style="background-color: #ed3237;color: white">
				
				</div> 
			</form>
			<!-- / Form -->

			

			<!-- / Password reset form -->
		</div>
		<!-- Right side -->
	</div>
	<!-- / Container -->

	

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->


<!-- Pixel Admin's javascripts -->
<script src="<?=base_url()?>assets/javascripts/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/javascripts/pixel-admin.min.js"></script>

<script type="text/javascript">
	// Resize BG
	  
$(document).ready(function(){
	    $('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	    
	      $('#signin-btn').click(function(){
	          
	          

    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';


	           
	        $('#espan').html('');
	        	 $('#otpid').html();
	        var uid = $("#username_id").val();
	        var dob = $("#dob").val();
	        
	        if(uid=='')
	        {
	            alert("Enter your Staff ID");
	            return false;
	        }
	            if(dob=='')
	        {
	            alert("Date of Birth can not be blank");
	            return false;
	        }
	           $('#signin-btn').hide();
	        
	        
	        		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Forgot_password/verify_credentials_staff',
				data: { uid: uid, dob :dob,[csrfName]: csrfHash },
				success: function (data) {
				//	alert(data);
				// Update CSRF hash for next request
				csrfHash = response.csrfHash;
				if(data.trim()=='Y')
				{
				  //  alert("Yes");
				    var msg ='Enter OTP sent at registered mobile number and click on Reset Password';
	 var msg2 ='<input type="text" name="otp" id="otp" class="form-control input-lg" value="" placeholder="Enter OTP" required><span class="fa fa-user signin-form-icon"></span>';
					
var msg3 ='	<input type="button" name="button" value="Reset Password" id="reset_pass" class="signin-btn" style="background-color: #ed3237;color: white" onclick="send_logindet()">';
				
					
						 $('#otpid').html(msg2);
					 $('#espan').html(msg);
					 
					 	 $('.form-actions').html(msg3);
					 
				}
				else
				{
				//  alert("No");   
				     var msg = data;
				     $('#espan').html(msg);
				       $('#signin-btn').show();
				}
			
				}
			});
	        
	        
	        
	        
	        
	        
	        
	        
	        
    //alert("test");
   // return false;
});






















});



function send_logindet()
{
	      //    alert("hi");
	      $('#espan').html('');
	      
	        $('#reset_pass').hide();
	        
	        
	        var uid = $("#username_id").val();
	        var dob = $("#dob").val();
	         var otp = $("#otp").val(); 
	        
	        if(uid=='')
	        {
	            alert("Enter your Staff ID");
	            return false;
	        }
	            if(dob=='')
	        {
	            alert("Date of Birth can not be blank");
	            return false;
	        }
	        
	              if(otp=='')
	        {
	            alert("Enter OTP");
	            return false;
	        }
	        
	        
	        
	        		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Forgot_password/send_login_credentials_staff',
				data: { uid: uid, dob :dob, otp :otp},
				success: function (data) {
				    	if(data.trim()=='Y')
				{
				    
				       $('#espan').html("Your login credentials sent on registered mobile number");
				       
				//	alert("Your login credentials sent on registered mobile number");
				  $('#reset_pass').show();
				}
				else
				{
				      $('#espan').html("Invalid combination. Please check OTP,Staff ID and Date of Birth");
				      $('#reset_pass').show();
				  //	alert("Invalid combination. Please check OTP,Enrollment Number and Date of Birth");  
				}
			
				}
			});
	        


}









	init.push(function () {
		var $ph  = $('#page-signin-bg'),
		    $img = $ph.find('> img');

		$(window).on('resize', function () {
			$img.attr('style', '');
			if ($img.height() < $ph.height()) {
				$img.css({
					height: '100%',
					width: 'auto'
				});
			}
		});
	});

	// Show/Hide password reset form on click
	init.push(function () {
		$('#forgot-password-link').click(function () {
			$('#password-reset-form').fadeIn(400);
			return false;
		});
		$('#password-reset-form .close').click(function () {
			$('#password-reset-form').fadeOut(400);
			return false;
		});
	});

	// Setup Sign In form validation
	init.push(function () {
		$("#signin-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });
		
		// Validate username
		$("#username_id").rules("add", {
			required: true,
			minlength: 3
		});

		// Validate password
		$("#password_id").rules("add", {
			required: true,
			minlength: 6
		});
	});

	// Setup Password Reset form validation
	init.push(function () {
		$("#password-reset-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });
		
		// Validate email
		$("#p_email_id").rules("add", {
			required: true,
			email: true
		});
	});

	window.PixelAdmin.start(init);
</script>

</body>
</html>
