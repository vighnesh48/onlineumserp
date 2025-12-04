<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
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
                new_password:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'New password should not be empty'
                      }                      
                    }

                },
                old_password:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Old password should not be empty'
                      }
                    }

                },
                con_password:
                {
                    validators: 
                    {
                        notEmpty: 
                        {
                           message: 'Confirm Password should not be empty.'
                        },
                        identical: {
                            field: 'new_password',
                            message: 'The password and its confirm are not the same'
                        }
                    },
                }
            }       
        });

    });
</script>
 
<script type="text/javascript">
    $(document).ready(function()
    { 
        var is_password_change = "<?php echo $result = isset($_SESSION['change_password_success']) ? 1 : 0; ?>"
        is_password_change = parseInt(is_password_change);
        if(is_password_change){
			var role ='<?php echo $this->session->userdata("role_id"); ?>';
			if(role==4){
				var redirect_url = "<?php echo base_url(); ?>"+"login/index/student";
			}else{
				var redirect_url = "<?php echo base_url(); ?>"+"login/logoff/";
			}
            setTimeout(
              function() 
              {
                  window.location =redirect_url;  
              }, 
            4000);
                    
        }


    });
</script>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <?php
                          $this->load->view('alert');
                        ?>
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Change Password</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Change Password</h1>
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
                            <span class="panel-title">Change Password</span>
                    </div>
                    <div class="panel-body">
                        <?php  if($_SESSION['is_password_reset'] == 0){ ?>
                            <span style="color:red"><b>Note</b> Please change your password to strong password once you update your password you  need to relogin then you can able to use other tabs otherwise it will be disabled!!</span>
                            <br/>
                            <br/>
                        <?php } ?>  
                        <div class="table-info">
                        
                            <?php // if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/change_user_password')?>" method="POST">                                                               
                                <input type="hidden" value="" id="course_id" name="course_id" />
							
                                <div class="form-group">
                                    <div class="col-sm-1"></div>
                                    <label class="col-sm-2">Old Password <?=$astrik?></label>                                    
                                    <div class="col-sm-4"><input type="text" id="old_password" name="old_password" class="form-control" value="<?php echo set_value('old_password'); ?>" />
                                        <small class="help-block" style="color:red;">
                                            <?php 
                                            if(form_error('old_password')){
                                                echo "<span style='color:red'>".form_error('old_password')."</span>";
                                            } ?>
                                            </small>
                                    </div>                                    
                                  
                                </div>                                
                                <div class="form-group">
                                    <div class="col-sm-1"></div>
                                    <label class="col-sm-2">New Password <?=$astrik?></label>                                    
                                    <div class="col-sm-4"><input type="text" id="new_password" name="new_password" class="form-control" value="<?php echo set_value('new_password'); ?>" />
                                        <small class="help-block" style="color:red;"><?php if(form_error('new_password')){echo "<span style='color:red'>".form_error('new_password')."</span>";} ?></small>
                                    </div>                                    
                                    <div class="col-sm-12"> 
                                   </div>
                                </div>
                            <div class="form-group">
                                <div class="col-sm-1"></div>
                                    <label class="col-sm-2">Confirm Password <?=$astrik?></label>                                    
                                    <div class="col-sm-4"><input type="" id="con_password" name="con_password" class="form-control" value="<?php echo set_value('con_password'); ?>" />
                                        <small class="help-block" style="color:red;"><?php if(form_error('con_password')){echo "<span style='color:red'>".form_error('con_password')."</span>";} ?></small>
                                    </div>
                                                              
                                    
                                </div>
                              <?php
                              //var_dump($_SESSION);
                              if($_SESSION['name']=="170101051057")
                              {
                                  
                              }
                              else
                              {
                              ?>
                              
                              
                              
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Change Password</button>                                      
                                    </div>
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                                <?php
                              }
                                ?>
                            </form>
                            <?php //} ?>
                        </div>
                    </div>
                    <!--div class="panel-body">
                    <form id="form" name="form" action="<?=base_url($currentModule.'/Update_email')?>" method="POST">                               <div class="form-group">
                                     <div class="col-sm-1"></div>
                                    <label class="col-sm-2">Email <?=$astrik?></label>                                    
                   <div class="col-sm-4"><input type="text" id="Email_Update" name="Email_Update" class="form-control" value="<?php echo $stdata['email'];?>" /><input type="hidden" id="stud_id" name="stud_id" class="form-control" value="<?php echo $stdata['stud_id'];?>" /></div>                   <div class="col-sm-3"></div>
                                </div> 
                                <!--<div class="form-group">
                                     <div class="col-sm-1"></div>
                                    <label class="col-sm-2">Mobile <?=$astrik?></label>                                    
                   <div class="col-sm-4"><input type="text" id="Email_Update" name="Email_Update" class="form-control" value="<?php echo $stdata['email'];?>" /><input type="hidden" id="stud_id" name="stud_id" class="form-control" value="<?php echo $stdata['stud_id'];?>" /></div>                   <div class="col-sm-3"></div>
                                </div>-->
                                <!--div class="form-group">
                                    
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                 <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>                               
                    </form>
                    </div-->
                </div>
            </div>    
        </div>
    </div>
</div>