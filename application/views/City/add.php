<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
        $("#state_id").select2
        ({
              placeholder: "Enter state",
              allowClear: true
        });
        
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
                state_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select state.'
                      }
                    }

                },
                city_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'City name should not be empty'
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
        <li class="active"><a href="#">Add City</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add City</h1>
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
                            <span class="panel-title">City Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                                                                                                                             
                                <div class="form-group">
                                    <label class="col-sm-3">State Name</label>
                                    <div class="col-sm-6">                                        
                                        <select name="state_id" id="state_id" class="form-control">
                                            <option value="">Select State</option>
                                            <?php for($i=0;$i<count($state_details);$i++){?>
                                            <option value="<?=$state_details[$i]['state_id']?>"><?=$state_details[$i]['state_name']?></option>
                                            <?php }?>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('state_id');?></span></div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" value="" id="city_id" name="city_id" />
                                    <label class="col-sm-3">City Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="city_name" name="city_name" class="form-control" value="<?=isset($_REQUEST['city_name'])?$_REQUEST['city_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('city_name');?></span></div>
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