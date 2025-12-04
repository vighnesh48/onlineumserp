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
                campus_code:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus code should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Campus Code should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Campus code should be 10-20 characters'
                        }
                    }

                },
                campus_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Campus name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 5,
                        message: 'Campus name should be 10-50 characters.'
                        }
                    }

                },
                campus_state:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus state should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Campus state should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Campus state should be 10-50 characters'
                        }
                    }

                },
                campus_city:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus city should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Campus city should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Campus city should be 10-50 characters'
                        }
                    }

                },
                campus_address:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus address should not be empty'
                      },
                      stringLength: 
                        {
                        max: 100,
                        min: 5,
                        message: 'Campus address should be 5-100 characters'
                        }
                    }

                },
                campus_pincode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus pincode should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Campus pincode should be numeric characters'
                      },
                      stringLength: 
                        {
                        max: 6,
                        min: 6,
                        message: 'Campus pincode should be 6 digit numeric value.'
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
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Add Campus</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Campus</h1>
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
                            <span class="panel-title">Campus Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="" id="campus_id" name="campus_id" />
                                <div class="form-group">
                                    <label class="col-sm-3">Campus Code <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="campus_code" name="campus_code" class="form-control" value="<?=isset($_REQUEST['campus_code'])?$_REQUEST['campus_code']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_code');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Campus Name <?=$astrik?></label>
                                    <div class="col-sm-6"><input type="text" id="campus_name" name="campus_name" class="form-control" value="<?=isset($_REQUEST['campus_name'])?$_REQUEST['campus_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_name');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Campus State <?=$astrik?></label>
                                    <div class="col-sm-6"><input type="text" id="campus_state" name="campus_state" class="form-control" value="<?=isset($_REQUEST['campus_state'])?$_REQUEST['campus_state']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_state');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Campus City</label>
                                    <div class="col-sm-6"><input type="text" id="campus_city" name="campus_city" class="form-control" value="<?=isset($_REQUEST['campus_city'])?$_REQUEST['campus_city']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_city');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Campus Address <?=$astrik?></label>
                                    <div class="col-sm-6"><input type="text" id="campus_address" name="campus_address" class="form-control" value="<?=isset($_REQUEST['campus_address'])?$_REQUEST['campus_address']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_address');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Campus Pincode <?=$astrik?></label>
                                    <div class="col-sm-6"><input type="text" id="campus_pincode" name="campus_pincode" class="form-control" value="<?=isset($_REQUEST['campus_pincode'])?$_REQUEST['campus_pincode']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_pincode');?></span></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>