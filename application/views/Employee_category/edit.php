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
    //echo "<pre>";print_r($category_details); echo "</pre>";
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Edit Employee Category</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Employee Category</h1>
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
                            <span class="panel-title">Employee Category Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php if(in_array("Add", $my_privileges)) { 
							
							?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($category_details['emp_cat_id'])?$category_details['emp_cat_id']:""?>" id="emp_cat_id" name="emp_cat_id" />
                                                             
                                <div class="form-group">
                                    <label class="col-sm-3">Employee Category Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="emp_cat_name" name="emp_cat_name" class="form-control" value="<?=isset($category_details['emp_cat_name'])?$category_details['emp_cat_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('emp_cat_name');?></span></div>
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