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
                shift_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Shift name should not be empty'
                      }
                    }
                },
                start_hh:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select starting hours'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'starting hours value should be numeric between 1-24'
                      }
                    }
                },
                start_mm:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select starting minutes'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'starting minutes value should be numeric between 0-59'
                      }
                    }
                },
                end_hh:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select end hours'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'end hours value should be numeric between 1-24'
                      }
                    }
                },
                end_mm:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select end minutes'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'end minutes value should be numeric between 0-59'
                      }
                    }
                }
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
   
    $start_array=  explode(":",$shift_details['shift_start_time']);
    $start_hh=$start_array[0];
    $start_mm=$start_array[1];
    
    $end_array=  explode(":",$shift_details['shift_end_time']);
    $end_hh=$end_array[0];
    $end_mm=$end_array[1];
    
    
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Edit Shift</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Shift</h1>
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
                            <span class="panel-title">Shift Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($shift_details['shift_id'])?$shift_details['shift_id']:''?>" id="shift_id" name="shift_id" />
                                <div class="form-group">
                                    <label class="col-sm-3">Shift Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="shift_code" name="shift_name" class="form-control" value="<?=isset($shift_details['shift_name'])?$shift_details['shift_name']:''?>" /></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('shift_name');?></span></div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3">Start Time <?=$astrik?></label>                                    
                                    <div class="col-sm-2">
                                        <select id="start_hh" name="start_hh" class="form-control">
                                            <option value="">Select Hours</option>
                                            <?php 
                                                for($i=1;$i<24;$i++)
                                                {
                                            ?>
                                            <option <?=$start_hh==$i?"selected='selected'":''?> value="<?=$i?>"><?=$i?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div> 
                                    <div class="col-sm-2">
                                        <select id="start_mm" name="start_mm" class="form-control">
                                            <option value="">Select Minutes</option>
                                            <?php 
                                                for($i=0;$i<59;$i++)
                                                {
                                            ?>
                                            <option <?=$start_mm==$i?"selected='selected'":''?> value="<?=$i?>"><?=$i?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div> 
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('shift_name');?></span></div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3">End Time <?=$astrik?></label>                                    
                                    <div class="col-sm-2">
                                        <select id="end_hh" name="end_hh" class="form-control">
                                            <option value="">Select Hours</option>
                                            <?php 
                                                for($i=1;$i<24;$i++)
                                                {
                                            ?>
                                            <option <?=$end_hh==$i?"selected='selected'":''?> value="<?=$i?>"><?=$i?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div> 
                                    <div class="col-sm-2">
                                        <select id="end_mm" name="end_mm" class="form-control">
                                            <option value="">Select Minutes</option>
                                            <?php 
                                                for($i=0;$i<59;$i++)
                                                {
                                            ?>
                                            <option <?=$end_mm==$i?"selected='selected'":''?> value="<?=$i?>"><?=$i?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div> 
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('shift_name');?></span></div>
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