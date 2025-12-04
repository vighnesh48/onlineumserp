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
	$( "#frm_open_date" ).datepicker({format: 'yyyy-mm-dd'});
	$( "#frm_end_date" ).datepicker({format: 'yyyy-mm-dd'});
	$( "#frm_latefee_date" ).datepicker({format: 'yyyy-mm-dd'});
	$( "#th_start_date" ).datepicker({format: 'yyyy-mm-dd'});
	$( "#th_end_date" ).datepicker({format: 'yyyy-mm-dd'});
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
                            <?php if(in_array("Add", $my_privileges)) { ?>
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/update_exam_dates')?>" method="POST">     
                            <?php     
                                if($this->session->flashdata('message')) {
                                 echo '<p style="color: red;text-align:center;">'.$this->session->flashdata('message').'</p>';   
                                 unset($_SESSION['message']);                    
                                }
                             ?>           
                                <div class="form-group">
                                 <input type="hidden" value="<?=isset($ses_details->id)?$ses_details->id:""?>" id="year_id" name="year_id" />   
                                
                                    
                                    <label class="col-sm-3">Exam Session<?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                    <select id="exam_id" name="exam_id" class="form-control" required>
                                          
                                            <option value="<?=$exam_session->exam_id?>" selected><?=$exam_session->exam_month.'-'.$exam_session->exam_year;?></option>
                                         
                                              
                                        </select>
                                    
                                    </div>                                    
                                    
                                </div> 
								<div class="form-group">
                                    <label class="col-sm-3">Exam Form Open Date <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="frm_open_date" name="frm_open_date" class="form-control" value="<?=isset($ses_details->frm_open_date)?$ses_details->frm_open_date:''?>"  required/></div>                                     
                                
                                    <label class="col-sm-3">Exam Form End Date <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="frm_end_date" name="frm_end_date" class="form-control" value="<?=isset($ses_details->frm_end_date)?$ses_details->frm_end_date:''?>"  required/></div>                                   
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Exam Form late fees Date<?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="frm_latefee_date" name="frm_latefee_date" class="form-control" value="<?=isset($ses_details->frm_latefee_date)?$ses_details->frm_latefee_date:''?>"  required/></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('frm_latefee_date');?></span></div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-3"> CIA Start Date <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="cia_start_date" name="cia_start_date" class="form-control" value="<?=isset($ses_details->date_start)?$ses_details->date_start:''?>"  required/></div>                                    
                                    <label class="col-sm-3">CIA End Date <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="cia_end_date" name="cia_end_date" class="form-control" value="<?=isset($ses_details->date_end)?$ses_details->date_end:''?>"  required/></div>                                                              
                                </div>
                                   <div class="form-group">
                                    <label class="col-sm-3"> CAP Marks Entry Start Date <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="th_start_date" name="th_start_date" class="form-control" value="<?=isset($ses_details->th_date_start)?$ses_details->th_date_start:''?>"  required/></div>                                    
                                    <label class="col-sm-3">CAP Marks Entry End Date <?=$astrik?></label>                                    
                                    <div class="col-sm-3"><input type="text" id="th_end_date" name="th_end_date" class="form-control" value="<?=isset($ses_details->th_date_end)?$ses_details->th_date_end:''?>"  required/></div>                                                              
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