<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?= site_url() ?>assets/javascripts/moment.js" type="text/javascript"></script>
<script src="<?= site_url() ?>assets/javascripts/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
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
                from_time:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'From time should not be empty'
                      }
                    }

                },
                to_time:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'To time  should not be empty'
                      }
                    }

                },
                slot_am_pm:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Slot should not be empty'
                      }
                    }

                },
				duration:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Duration should not be empty'
                      }
                    },
					stringLength: {
                        max: 2,
                        message: 'The Duration must be equal to or less than 2 digits'
                    }

                }
				
                
                
            }       
        })
    });
    
</script>
<script type="text/javascript">
           
			 $(function() {
	  
  $('#to_time').timepicker({timeFormat: 'H:i',defaultTime: 'value',minuteStep: 1,
    disableFocus: true,
    showMeridian:false});
	$('#from_time').timepicker({timeFormat: 'H:i',defaultTime: 'value',minuteStep: 1,
    disableFocus: true,
    showMeridian:false});
});
        </script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Add Lecture Slot</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Lecture Slot</h1>
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
                            <span class="panel-title">Lecture Slot Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php  if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">     
                <?php     
                    if($this->session->flashdata('message')) {
                     echo '<p style="color: red;text-align:center;">'.$this->session->flashdata('message').'</p>';   
                     unset($_SESSION['message']);                    
                    }
                 ?>          
				
				           <div class="form-group">
                                    <input type="hidden" name="slot_id">
                                    <label class="col-sm-3" >From Time<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                    <input type="text" id="from_time" name="from_time" class="form-control" value="" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('from_time');?></span></div>
                                </div> 
								<div class="form-group">
                                   
                                    <label class="col-sm-3" >To Time<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                     <input type="text" id="to_time" name="to_time" class="form-control" value="" />
                                    
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('to_time');?></span></div>
                                </div>

                               
                                <div class="form-group">
                                   
                                    <label class="col-sm-3">Slot type<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                    <select id="slot_am_pm" name="slot_am_pm" class="form-control" required> 
                                         <option value="AM" >AM</option>
                                         <option value="PM">PM</option> 
                                        </select>
                                    
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('slot_am_pm');?></span></div>
                                </div> 
                                <div class="form-group">
                                    
                                    <label class="col-sm-3">Duration<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                    <input type="number" maxlength="2" id="duration" name="duration" class="form-control" required> 
                                        
                                    
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('duration');?></span></div>
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
                            <?php  } ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>