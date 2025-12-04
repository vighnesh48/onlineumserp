<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   ?><!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login Form</title>
      <!-- Bootstrap 5 CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <style>
         body {
         background: #f1f1f1;
         height: 100vh;
         display: flex;
         justify-content: center;
         align-items: center;
         }
         .login-card {
         width: 450px;
         padding: 30px;
         border-radius: 12px;
         box-shadow: 0 10px 25px rgba(0,0,0,0.1);
         background: #fff;
         }
         .btn-gradient {
         background: linear-gradient(90deg, #ff6600, #ff0066);
         color: #fff;
         }
         .btn-gradient:hover {
         opacity: 0.9;
         color: #fff;
         }
		 
		 .redtext{
    color: #ff1056;
    text-decoration: none;
    padding: 10px;
    font-weight: 600;
	margin-bottom:7px;
}
		 		
    .logo-light {
        width:330px;
    }

		 @media (max-width: 991px) {
    .logo-light {
        width: 270px;
    }
}
      </style>
	  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php
define('SITE_KEY',SITE_KEY);
define('SECRET_KEY',SECRET_KEY);
?>

   </head>
   <body class="theme-default page-signin" >
      <div class="login-card text-center">
         <a href="https://www.sandipuniversity.edu.in/" class="logo" target="_blank">
            <center>
               <img src="https://onlineeducation.sandipuniversity.edu.in/images/logo.png" alt="Sandip University" class="logo-light" style="padding-bottom: 10px;">
            </center>
         </a>
       
         <form action="<?=site_url('login')?>" id="signin-form_id" method="post">
            <span>Sign In to your account :<strong><span class="redtext"> <?php if($utype!=''){echo $utype; }else{echo "Staff";} //echo $login_user; ?>  Login </span></strong></span>
            <?php if(@$this->session->flashdata('msg')){ ?>
    <div class="has-error redtext">
        <span class="form-control-feedback redtext"><?=@$this->session->flashdata('msg')?></span>
    </div>
<?php } ?>

<?php if($msg!=''){ ?>
    <div class="has-error redtext" style="text-align:center">
        <span class="form-control-feedback redtext"><?=$msg?></span>
    </div>
<?php } ?>
            <!-- Username -->
            <div class="mb-3 text-start" style="padding-top:10px">
               <!--<label class="form-label">Username</label>-->
               <input type="text" name="signin_username" id="username_id" class="form-control input-lg" placeholder=" Username" required>
            </div>
            <!-- Password -->
            <div class="mb-3 text-start">
              <!-- <label class="form-label">Password</label>-->
               <input type="password" name="signin_password" id="password_id" class="form-control input-lg" placeholder="Password" required>
               <input type="hidden" name="uttype" value="<?php if($utype){ $utp = $utype;}else{$utp='';} echo $utp;?>">
               <input type="hidden" name="role_id" value="<?php if($_REQUEST['role']!=''){ $val = $_REQUEST['role'];}elseif($roleid !=''){$val =$roleid;}else{$val='';} echo $val;?>">
            </div>
  
           <!-- <div class="g-recaptcha" data-sitekey="<?php echo SITE_KEY; ?>"></div>
            <span class="text-danger" id="captcha-error"><?= $errors['g-recaptcha-response'] ?? '' ?></span>
            
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />-->
            <!-- Login Button -->
            <div class="form-actions">
               <input type="submit" name="submit" value="SIGN IN" class="signin-btn btn btn-gradient w-100 mt-3 " >
               <!--<p> <span style="color:red ; font-weight: bold;">Erp is under maintenance</span></p> -->
               <?php
                  if($utype=="student")
                  {
                      $ank ="https://erp.sandipuniversity.com/login/forgot_password/student";
                  }
                  	else if($utype=="parent")
                  {
                    	    $ank ="https://erp.sandipuniversity.com/forgot_password/parent";  
                  }
                  else
                  {
                      	    $ank ="https://erp.sandipuniversity.com/forgot_password";
                  }
                  ?>
               <a href="<?=$ank?>" class="forgot-password redtext" id="forgot-password-link " >Forgot your password?</a>
            </div>
         </form>
      </div>
      <!-- Get jQuery from Google CDN -->
      <!--[if !IE]> -->
      <script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js">'+"<"+"/script>"); </script>
      <!-- <![endif]-->
      <!--[if lte IE 9]>
      <script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
      <![endif]-->
      <!-- Pixel Admin's javascripts -->
      <script src="<?=base_url()?>assets/javascripts/bootstrap.min.js"></script>
      <script src="<?=base_url()?>assets/javascripts/pixel-admin.min.js"></script>
      <script type="text/javascript">
         // assumes you're using jQuery
         $(document).ready(function() {
         $('.confirm-div').hide();
         <?php if($this->session->flashdata('msgg')){ ?>
         $('.confirm-div').html('<?php echo $this->session->flashdata('msgg'); ?>').show();
         <?php } ?>
         });
         /*console.log(Object.defineProperties(new Error, {
           toString: {value() {(new Error).stack.includes('toString@') && alert('Safari devtools')}},
           message: {get() {window.location.href = 'http://www.google.com';}},
         }));
         */
         
         window.console.log = function(){
             console.error('The developer console is temp...');
             window.console.log = function() {
                 return false;
             }
         }
         
         
         	// Resize BG
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
         
         
         
         	window.PixelAdmin.start(init);
      </script>
   </body>
</html>