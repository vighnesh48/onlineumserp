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
                org_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Organization Name should not be empty'
                      }
                    }

                },
                org_city:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Organization City name should not be empty'
                      }
                    }

                },
                org_state:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Organization State should not be empty'
                      }
                    }

                },
                org_pincode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Organization Pincode should not be empty'
                      }
                    }

                },
                org_address:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Organization Address  should not be empty'
                      }
                    }

                }
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
    //echo "<pre>";print_r($organization_details); echo "</pre>";
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Edit Organization</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Organization</h1>
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
                            <span class="panel-title">Organization Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($organization_details['organisation_id'])?$organization_details['organisation_id']:""?>" id="organisation_id" name="organisation_id" />
                                                             
                                <div class="form-group">
                                    <label class="col-sm-3">Organization Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="org_name" name="org_name" class="form-control" value="<?=isset($organization_details['org_name'])?$organization_details['org_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('org_name');?></span></div>
                                </div>  
                                <div class="form-group">
                                    <label class="col-sm-3">Organization City <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="org_city" name="org_city" class="form-control" value="<?=isset($organization_details['org_city'])?$organization_details['org_city']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('org_city');?></span></div>
                                </div> 
								<div class="form-group">
                                    <label class="col-sm-3">Organization State <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="org_state" name="org_state" class="form-control" value="<?=isset($organization_details['org_state'])?$organization_details['org_state']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('org_state');?></span></div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3">Organization Address <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="org_address" name="org_address" class="form-control" value="<?=isset($organization_details['org_address'])?$organization_details['org_address']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('org_address');?></span></div>
                                </div> 
                                 <div class="form-group">
                                    <label class="col-sm-3">Organization Pincode <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="org_pincode" name="org_pincode" class="form-control" value="<?=isset($organization_details['org_pincode'])?$organization_details['org_pincode']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('org_pincode');?></span></div>
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