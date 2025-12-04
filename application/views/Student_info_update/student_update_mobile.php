<style>.panel{
    box-shadow: 1px 2px 13px #ccc!important;
}
.panel:hover{
    box-shadow:1px 2px 7px #f2f2f2!important;
}
</style>


<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>    
    $(document).ready(function()
    {
        $('#form').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: 
            {
                
                oldmobile:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Mobile no should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Mobile number should be numeric'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 10,
                        message: 'please put in proper mobile number, Mobile no should be 10 characters'
                        }
                    }

                },

                email:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Email should not be empty'
                      },
                      regexp: 
                      {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'This is not a valid email'
                      }
                      
                    }
                },

                new_mobileno:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'New Mobile No should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Mobile number should be numeric'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 10,
                        message: 'please put in proper mobile number, Mobile no should be 10 characters'
                        }
                    }

                }

            }       
        })

        $('#email_form').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: 
            {
                
                

                email1:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Email should not be empty'
                      },
                      regexp: 
                      {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'This is not a valid email'
                      }
                      
                    }
                },

               

            }       
        })



    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <!--<li><a href="#">Masters</a></li> -->
        <li class="active"><a href="#">Update Mobile No / Email Id</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon text-danger"></i>&nbsp;&nbsp;Update Mobile No / Email Id</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Update Mobile No / Email Id</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info"> 







             <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Update Mobile No </a></li>
                <li><a data-toggle="tab" href="#menu1">Update Email Id</a></li>

              </ul>

              <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                            
                        <div class="row">
                            <div class="col-sm-12">
                             <form id="form" action="" id="signin-form_id" method="post">
                                <div class="row">
                                    <div class="clearfix"></div>
                                <div class="form-group w-icon"><div class="col-sm-12"><span style="color:green" id="otpdone"></span></div></div>
                                 <div class="clearfix"></div>

                                 <input type="hidden" name="student_code" value="<?=$stud_id?>" id="student_code">
                                       

                                    <div class="form-group w-icon">
                                          <div class="col-sm-1"></div>
                                          <label class="col-sm-2">  Mobile No <?=$astrik?></label>

                                        <div class="col-sm-4"><input type="text" name="oldmobile" id="oldmobile" class="form-control " value="<?=$old_mobile_no?>" placeholder="Old Mobile No" readonly required></div>
                                    </div>

                                    <div class="form-group w-icon hidden">
                                          <div class="col-sm-1"></div>
                                          <label class="col-sm-2">Email ID  <?=$astrik?></label>

                                        <div class="col-sm-4"><input type="text" name="email" id="email" class="form-control " value="" placeholder="Enter Email Id" required></div>
                                    </div>
                                    <div class="form-group w-icon">
                                         <div class="col-sm-1"></div>
                                        <label class="col-sm-2">New Mobile No <?=$astrik?></label>
                                       <div class="col-sm-4"> <input type="text" name="new_mobileno" id="new_mobileno" class="form-control " value="" placeholder="Enter Mobile NO*" required></div>
                                    </div>
                                    <div class="form-group w-icon">
                                         <div class="col-sm-1"></div>
                                        <div class="col-sm-2"></div>
                                         <div class="col-sm-4"><span style="color:red" id="espan"></span></div>
                                    </div>

                                    
                                    <div class=" form-group date w-icon" id="otpid"> </div>  
                                    <!--
                                    <div class="form-actions">
                                        <input type="button" name="button" value="Submit" id="signin-btn" class="signin-btn btn btn-primary" style="background-color: #ed3237;color: white">
                                    </div>  
                                    -->
                                    <div class="form-group form-actions">
                                    
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-2">
                                           
                                             <input type="button" name="button" value="Submit" id="signin-btn" class="signin-btn btn btn-primary " style="background-color: #ed3237;color: white">                                        
                                        </div>                                    
                                        
                                    </div>
                                     </div>
                            </form>
                        </div>
                       </div>

                  </div>

                <div id="menu1" class="tab-pane fade">
                    
                     <form id="email_form" action="" id="signin-form_id" method="post">
                                <div class="row">
                                <div class="clearfix"></div>
                                <div class="form-group w-icon">
                                    <div class="col-sm-12">
                                        <span style="color:green" id="otpdone_email"></span>
                                    </div>
                                 </div>
                                 <div class="clearfix"></div>
                                    <input type="hidden" name="student_code" value="<?=$stud_id?>" id="student_code">
                                    <input type="hidden" name="oldmobile" value="<?=$old_mobile_no?>" id="oldmobile">
									<div class="form-group w-icon">
                                          <div class="col-sm-1"></div>
                                          <label class="col-sm-2">Current Email ID  <?=$astrik?></label>

                                        <div class="col-sm-4"><?=$email?></div>
                                    </div>
                                    <div class="form-group w-icon">
                                          <div class="col-sm-1"></div>
                                          <label class="col-sm-2">New Email ID  <?=$astrik?></label>

                                        <div class="col-sm-4"><input type="text" name="email1" id="email1" class="form-control " value="" placeholder="Enter Email Id" required></div>
                                    </div>
                                    
                                    <div class="form-group w-icon">
                                         <div class="col-sm-1"></div>
                                         <div class="col-sm-2"></div>
                                         <div class="col-sm-4"><span style="color:red" id="espan_email"></span></div>
                                    </div>
                                    <div class=" form-group date w-icon" id="otpid_email"> </div>  
                                    <!--
                                    <div class="form-actions">
                                        <input type="button" name="button" value="Submit" id="signin-btn" class="signin-btn btn btn-primary" style="background-color: #ed3237;color: white">
                                    </div>  
                                    -->
                                    <div class="form-group form-actions_email">
                                    
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-2">
                                           
                                             <input type="button" name="button" value="Submit" id="signin-btn_email" class="signin-btn btn btn-primary " style="background-color: #ed3237;color: white">                                        
                                        </div>                                    
                                        
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
        </div>
    </div>
</div>
<script>
$(document).ready(function(){


        $('#signin-btn_email').click(function(){
             
            $('#espan_email').html('');
            $('#otpid_email').html();
            var oldmobile = $("#oldmobile").val();
            var email = $("#email1").val();
            var student_code = $("#student_code").val();
            $('#signin-btn_email').hide();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>student_info_update/verify_student_email',
                data: { student_code:student_code,email:email,oldmobile:oldmobile},
                success: function (data) {
                  //alert(data);
                if(data.trim()=='Y')
                    {
                      //  alert("Yes");
                var msg_email ='Enter OTP Sent on Email ID';

                var msg_email_2 ='<div class="form-group w-icon"><div class="col-sm-1"></div><label class="col-sm-2">Enter OTP <?=$astrik?></label><div class="col-sm-4"> <input type="text" name="otp_email" id="otp_email" class="form-control" value="" placeholder="Enter OTP" required></div></div>';

                var msg_email_3 ='<div class="col-sm-3"></div><div class="col-sm-2"> <input type="button" name="button" value="verify OTP" id="reset_pass_email" class="btn btn-primary"></div>'; 


                        $('#otpid_email').html(msg_email_2);
                        $('#espan_email').html(msg_email);
                        $('.form-actions_email').html(msg_email_3);  


                         $('#reset_pass_email').click(function(){
                           // alert('1');
                           
                            var email = $("#email1").val();
                            var student_code = $("#student_code").val();
                            var otp_email = $("#otp_email").val();
                            
                            $.ajax({
                                type: 'POST',
                                url: '<?= base_url() ?>student_info_update/verify_student_email_otp',
                                data: {student_code:student_code,email:email,otp:otp_email},
                                success: function (data1) {
                                  //alert(data1);
                                  if(data1.trim()=='Y')
                                   {
                                        var msg4 ='Email Id is Updated. Please check your Profile';
                                        $('#otpdone_email').html(msg4);

                                        setTimeout(function(){ window. location. reload(); }, 1000);

                                       // window.location.reload();
                                        //window.location.reload();
                                        //alert('You');

                                    }
                                    else
                                    {
                                        alert('OTP Not Match Please try again.');
										return false;										
                                    }
                                }
                            });
                        }); 
                    }
                    else
                    {
                    //  alert("No");   
                        var msg = data;
                        $('#espan_email').html(msg);
                        $('#signin-btn_email').show();
                    }
                }
            });
        });


          $('#signin-btn').click(function(){
             
            $('#espan').html('');
            $('#otpid').html();

            var oldmobile = $("#oldmobile").val();
            var new_mobileno = $("#new_mobileno").val();
            var email = $("#email").val();
            var student_code = $("#student_code").val();
            if(new_mobileno=='')
            {
                alert("Enter Mobile NO");
				$("#new_mobileno").focus();
                return false;
            }
            $('#signin-btn').hide();

            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>student_info_update/verify_student_mobile',
                data: { new_mobileno: new_mobileno,student_code:student_code,email:email,oldmobile:oldmobile},
                success: function (data) {
                 // alert(data);
                if(data.trim()=='Y')
                    {
                      //  alert("Yes");
                var msg ='Enter OTP received on new mobile number';

                var msg2 ='<div class="form-group w-icon"><div class="col-sm-1"></div><label class="col-sm-2">Enter OTP <?=$astrik?></label><div class="col-sm-4"> <input type="text" name="otp" id="otp" class="form-control" value="" placeholder="Enter OTP" required></div></div>';

                var msg3 ='<div class="col-sm-3"></div><div class="col-sm-2"> <input type="button" name="button" value="verify OTP" id="reset_pass" class="btn btn-primary"></div>'; 


                        $('#otpid').html(msg2);
                        $('#espan').html(msg);
                        $('.form-actions').html(msg3);  


                         $('#reset_pass').click(function(){
                           // alert('1');
                            var new_mobileno = $("#new_mobileno").val();
                            var email = $("#email").val();
                            var student_code = $("#student_code").val();
                             var otp = $("#otp").val();
                            $.ajax({
                                type: 'POST',
                                url: '<?= base_url() ?>student_info_update/verify_student_mobile_otp',
                                data: { new_mobileno: new_mobileno,student_code:student_code,email:email,otp:otp},
                                success: function (data) {
                                  //alert(data);
                                if(data.trim()=='Y')
                                    {
                                        var msg4 ='Mobile No is Updated. Please check your profile';
                                        $('#otpdone').html(msg4);

                                        setTimeout(function(){ window. location. reload(); }, 1000);
                                        
                                        //window.location.reload();
                                        //alert('You');

                                    }
                                    else
                                    {

                                        alert('OTP Not Match Please try again'); 
                                    }
                                }
                            });
                        }); 
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
        });
 }); 
</script>