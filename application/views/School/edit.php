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
                is_sun:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Sun should not be empty'
                      },
                      /*stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Color code should be 10-20 characters'
                        }*/
                    }

                },
                school_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'School Name should not be empty'
                      }
                    }

                }
                
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
    //echo "<pre>";print_r($designation_details); echo "</pre>";
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Edit Product Size</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Product Size</h1>
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
                            <span class="panel-title">School Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php if(in_array("Edit", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($school_details['id'])?$school_details['id']:""?>" id="school_id" name="school_id" />
                                                              
                                <div class="form-group">
                                    <label class="col-sm-3">School Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="school_name" name="school_name" class="form-control" value="<?=isset($school_details['school_name'])?$school_details['school_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('school_name');?></span></div>
                                </div> 
								 <div class="form-group">
									<label class="col-sm-3">Is Sun : <?=$astrik?></label>
									<div class="col-sm-6">
										<label class="radio-inline">
										  <input type="radio" name="is_sun" value="Yes"  
										  <?php if($school_details['is_sun']=='Yes') { echo "checked"; }?>>Yes
										</label>
										<label class="radio-inline">
										  <input type="radio" name="is_sun" value="No"
										  <?php if($school_details['is_sun']=='No') { echo "checked"; }?>>No
										</label>
									</div>
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