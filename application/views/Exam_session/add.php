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
                exam_month:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Exam month should not be empty'
                      }
                    }

                },
                exam_year:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Exam Year should not be empty'
                      }
                    }

                },
                exam_type:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Exam Type should not be empty'
                      }
                    }

                }
                
                
            }       
        })
    });
    $( function() {
        
    $( "#start_date" ).datepicker({format: 'yyyy-mm-dd'});
  } );
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Add Exam Session</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Exam Session</h1>
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
                            <?php  if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">     
                <?php     
                    if($this->session->flashdata('message')) {
                     echo '<p style="color: red;text-align:center;">'.$this->session->flashdata('message').'</p>';   
                     unset($_SESSION['message']);                    
                    }
                 ?>          

                                <div class="form-group">
                                    
                                    <label class="col-sm-3">Exam month<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                    <select id="exam_month" name="exam_month" class="form-control" required>
                                            <option value="JAN" <?php if($_REQUEST['start_month']=="JAN"){ ?> selected <?php } ?>>JAN</option> 
                                            <option value="FEB" <?php if($_REQUEST['start_month']=="FEB"){ ?> selected <?php } ?>>FEB</option>  
                                            <option value="MAR" <?php if($_REQUEST['start_month']=="MAR"){ ?> selected <?php } ?>>MAR</option> 
                                            <option value="APR" <?php if($_REQUEST['start_month']=="APR"){ ?> selected <?php } ?>>APR</option>
                                            <option value="MAY" <?php if($_REQUEST['start_month']=="MAY"){ ?> selected <?php } ?>>MAY</option> 
                                            <option value="JUN" <?php if($_REQUEST['start_month']=="JUN"){ ?> selected <?php } ?>>JUN</option>
                                            <option value="JUL" <?php if($_REQUEST['start_month']=="JUL"){ ?> selected <?php } ?>>JUL</option> 
                                            <option value="AUG" <?php if($_REQUEST['start_month']=="AUG"){ ?> selected <?php } ?>>AUG</option>
                                            <option value="SEP" <?php if($_REQUEST['start_month']=="SEP"){ ?> selected <?php } ?>>SEP</option> 
                                            <option value="OCT" <?php if($_REQUEST['start_month']=="OCT"){ ?> selected <?php } ?>>OCT</option>
                                            <option value="NOV" <?php if($_REQUEST['start_month']=="NOV"){ ?> selected <?php } ?>>NOV</option> 
                                            <option value="DEC" <?php if($_REQUEST['start_month']=="DEC"){ ?> selected <?php } ?>>DEC</option>                                          
                                        </select>
                                    
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('exam_month');?></span></div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-3">Exam year<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                    <select id="exam_year" name="exam_year" class="form-control" required>
                                            <option value="2024" <?php if($_REQUEST['exam_year']=="2024"){ ?> selected <?php } ?>>2024</option> 
                                            <option value="2025" <?php if($_REQUEST['exam_year']=="2025"){ ?> selected <?php } ?>>2025</option>  
                                            <option value="2026" <?php if($_REQUEST['exam_year']=="2026"){ ?> selected <?php } ?>>2026</option> 
                                            <option value="2027" <?php if($_REQUEST['exam_year']=="2027"){ ?> selected <?php } ?>>2027</option>
                                            <option value="2028" <?php if($_REQUEST['exam_year']=="2028"){ ?> selected <?php } ?>>2028</option> 
                                                                                        
                                        </select>
                                    
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('exam_year');?></span></div>
                                </div>                              
                                
                                <div class="form-group">
                                    <input type="hidden" name="exam_id">
                                    <label class="col-sm-3">Exam Type<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                    <select id="exam_type" name="exam_type" class="form-control" required> 
                                         <option value="Regular" <?php if($_REQUEST['exam_type']=="Regular"){ ?> selected <?php } ?>>Regular</option>
                                         <option value="Makeup" <?php if($_REQUEST['exam_type']=="Makeup"){ ?> selected <?php } ?>>Makeup</option> 
                                        </select>
                                    
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('exam_type');?></span></div>
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