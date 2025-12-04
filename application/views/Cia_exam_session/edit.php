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
                academic_session:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Academic session should not be empty'
                      }
                    }

                },
                academic_year:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Academic Year should not be empty'
                      }
                    }

                },
                start_month:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Start Month should not be empty'
                      }
                    }

                },
                last_month:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Last Month should not be empty'
                      }
                    }

                },
                start_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Start date should not be empty'
                      }
                    }

                }
                
            }       
        })
    });
    $( function() {
        
    $( "#cia_start_date" ).datepicker({format: 'yyyy-mm-dd'});
	$( "#cia_end_date" ).datepicker({format: 'yyyy-mm-dd'});
	$( "#cia_frm_open_date" ).datepicker({format: 'yyyy-mm-dd'});
	$( "#cia_frm_end_date" ).datepicker({format: 'yyyy-mm-dd'});
	$( "#cia_frm_latefee_date" ).datepicker({format: 'yyyy-mm-dd'});
  } );
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
    //echo "<pre>";print_r($state_details); echo "</pre>";
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Edit Exam Session</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit exam Session</h1>
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
                            <span class="panel-title">Exam Session Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php // if(in_array("Add", $my_privileges)) { ?>
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/update_cia_exam_dates')?>" method="POST">     
                            <?php     
                                if($this->session->flashdata('message')) {
                                 echo '<p style="color: red;text-align:center;">'.$this->session->flashdata('message').'</p>';   
                                 unset($_SESSION['message']);                    
                                }
                             ?>           
                                <div class="form-group">
                                 <input type="hidden" value="<?=isset($ses_details->id)?$ses_details->id:""?>" id="year_id" name="year_id" />   
                                
                                    
                                    <label class="col-sm-3">CIA Name<?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                    <select id="cia_exam_id" name="cia_exam_id" class="form-control" required>
                                          
                                            <option value="<?=$cia_exam_session->cia_exam_id?>" selected><?=$cia_exam_session->cia_exam_name;?></option>
                                         
                                              
                                        </select>
                                    
                                    </div>    

                                    <label class="col-sm-3">CIA Type<?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                    <select id="cia_exam_id" name="cia_exam_id" class="form-control" required>
                                          
                                            <option value="<?=$cia_exam_session->cia_exam_id?>" selected><?=$cia_exam_session->cia_exam_type;?></option>
                                         
                                              
                                        </select>
                                    
                                    </div> 
                                    
                                </div> 

                                 <div class="form-group">
                                    <label class="col-sm-3">Start Date <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="cia_start_date" name="cia_start_date" class="form-control" value="<?=isset($ses_details->start_date)?$ses_details->start_date:''?>"  required/></div>                                    
                                    <label class="col-sm-3">End Date <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="cia_end_date" name="cia_end_date" class="form-control" value="<?=isset($ses_details->end_date)?$ses_details->end_date:''?>"  required/></div>                                                              
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
                            
                             <?php  // } ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>