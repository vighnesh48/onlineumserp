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
                roles_name:
                {
                    validators: 
                    {
                        notEmpty: 
                        {
                            message: 'Roles name should not be empty'
                        }
                    }
                },
                roles_type:
                {
                    validators: 
                    {
                        notEmpty: 
                        {
                            message: 'Roles type should not be empty'
                        },
                        regexp: 
                        {
                            regexp: /^[a-zA-Z-/]+$/,
                            message: 'Roles type should be alphabate characters'
                        }
                    }
                }                
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
        <li class="active"><a href="#">Edit Roles</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Roles</h1>
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
                            <span class="panel-title">Roles Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <?php if(in_array("Edit", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($roles_details['roles_id'])?$roles_details['roles_id']:''?>" id="roles_id" name="roles_id" />
                                <div class="form-group">
                                    <label class="col-sm-3">Role Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="roles_name" name="roles_name" class="form-control" value="<?=isset($roles_details['roles_name'])?$roles_details['roles_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('roles_name');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Role Type <?=$astrik?></label>
                                    <div class="col-sm-6">
                                        <select id="roles_type" name="roles_type" class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="ADM" <?=$roles_details['roles_type']=="ADM"?"selected='selected'":""?> >Administrator</option>
                                            <option value="STU" <?=$roles_details['roles_type']=="STU"?"selected='selected'":""?> >Student</option>
                                            <option value="TSTF" <?=$roles_details['roles_type']=="TSTF"?"selected='selected'":""?> >Technical Staff</option>
                                            <option value="NTSTF" <?=$roles_details['roles_type']=="NTSTF"?"selected='selected'":""?> >Non Technical Staff</option>
                                             <option value="ACNT" <?=$roles_details['roles_type']=="ACNT"?"selected='selected'":""?> >Accountant</option>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('role_type');?></span></div>
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