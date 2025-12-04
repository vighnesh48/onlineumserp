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
                ext_fac_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'External Faculty name should not be empty'
                      }
                    }

                },
				ext_fac_designation:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'External Faculty designation should not be empty'
                      }
                    }

                },
                ext_fac_mobile:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'External Faculty mobile should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'External Faculty mobile should be numeric characters'
                      }
                    }

                },
                ext_fac_email:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'External Faculty Email should not be empty'
                      }
                    }

                },

                ext_fac_institute:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'External Faculty institute should not be empty'
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
        <li class="active"><a href="#">Add External Faculty</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add External Faculty</h1>
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
                            <span class="panel-title">External Faculty Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php //if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="" id="fac_id" name="fac_id" />
                                <div class="form-group">
                                    <label class="col-sm-3">Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" class="form-control" name="ext_fac_name" id="ext_fac_name" value="<?php if(!empty($sub[0]['ext_fac_name'])){ echo $sub[0]['ext_fac_name'];}?>"></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('ext_fac_name');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Designation <?=$astrik?></label>
                                    <div class="col-sm-6">
									<select class="form-control" name="ext_fac_designation" id="ext_fac_designation">
											<option value="">--select--</option>
											<option value="Assistant Professor">Assistant Professor</option>
											<option value="Associate Professor">Associate Professor</option>
											<option value="Professor">Professor</option>
										</select></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('ext_fac_designation');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Mobile <?=$astrik?></label>
                                    <div class="col-sm-6"><input type="text" class="form-control" name="ext_fac_mobile" id="ext_fac_mobile" value="<?php if(!empty($sub[0]['ext_fac_mobile'])){ echo $sub[0]['ext_fac_mobile'];}?>" maxlength='12'></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('ext_fac_mobile');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Email</label>
                                    <div class="col-sm-6"><input type="email" class="form-control" name="ext_fac_email" id="ext_fac_email" value="<?php if(!empty($sub[0]['ext_fac_email'])){ echo $sub[0]['ext_fac_email'];}?>"></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('ext_fac_email');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Institute <?=$astrik?></label>
                                    <div class="col-sm-6"><input type="text" class="form-control" name="ext_fac_institute" id="ext_fac_institute" value="<?php if(!empty($sub[0]['ext_fac_institute'])){ echo $sub[0]['ext_fac_institute'];}?>" ></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('ext_fac_institute');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Distance(KM)</label>
                                    <div class="col-sm-6"><input type="text" class="form-control" name="distance_km" id="distance_km" value="<?php if(!empty($sub[0]['distance_km'])){ echo $sub[0]['distance_km'];}?>" ></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('distance_km');?></span></div>
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
                            <?php //} ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>