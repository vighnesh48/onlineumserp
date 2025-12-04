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
                campus_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select campus'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Invalid campus name selected'
                      }
                    }

                },
                college_code:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'College code should not be empty'
                      },
                      stringLength: 
                        {
                        max: 20,
                        min: 2,
                        message: 'College code should be 2-20 characters.'
                        }
                    }
                },
                college_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'College name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'College name should be 2-50 characters.'
                        }
                    }
                },
                college_pincode:
                {
                    validators: 
                    {                      
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'College pincode should be numeric characters'
                      }
                    }

                }
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
    //echo "<pre>";print_r($college_details); die;
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Edit College</a></li>
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
                                <input type="hidden" value="<?=$college_details['college_id']?>" id="college_id" name="college_id" />
                                <div class="form-group">
                                    <label class="col-sm-3">Select Campus <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="campus_id" name="campus_id" class="form-control" >
                                            <option value="">Select Campus</option>
                                            <?php for($i=0;$i<count($campus_details);$i++) { ?>
                                            <option <?=$college_details['campus_id']==$campus_details[$i]['campus_id']?"selected='selected'":''?> value="<?=$campus_details[$i]['campus_id']?>"><?=$campus_details[$i]['campus_name']?></option>
                                            <?php } ?>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_id');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">College Code <?=$astrik?></label>
                                    <div class="col-sm-6"><input type="text" id="college_code" name="college_code" class="form-control" value="<?=isset($college_details['college_code'])?$college_details['college_code']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('college_code');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">College Name <?=$astrik?></label>
                                    <div class="col-sm-6"><input type="text" id="college_name" name="college_name" class="form-control" value="<?=isset($college_details['college_name'])?$college_details['college_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('college_name');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">College City</label>
                                    <div class="col-sm-6"><input type="text" id="college_city" name="college_city" class="form-control" value="<?=isset($college_details['college_city'])?$college_details['college_city']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('college_city');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">College State </label>
                                    <div class="col-sm-6"><input type="text" id="college_state" name="college_state" class="form-control" value="<?=isset($college_details['college_state'])?$college_details['college_state']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('college_state');?></span></div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-sm-3">College Address </label>
                                    <div class="col-sm-6"><input type="text" id="college_address" name="college_address" class="form-control" value="<?=isset($college_details['college_address'])?$college_details['college_address']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('college_address');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">College Pincode</label>
                                    <div class="col-sm-6"><input type="text" id="college_pincode" name="college_pincode" class="form-control" value="<?=isset($college_details['college_pincode'])?$college_details['college_pincode']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('college_pincode');?></span></div>
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