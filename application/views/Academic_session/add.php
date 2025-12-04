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
        <li class="active"><a href="#">Add Academic Session</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Academic Session</h1>
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
                            <span class="panel-title">Academic Session Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php // if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">     
	            <?php     
                	if($this->session->flashdata('message')) {
                     echo '<p style="color: red;text-align:center;">'.$this->session->flashdata('message').'</p>';   
                     unset($_SESSION['message']);					 
					}
                 ?>           
                                <div class="form-group">
                                    <input type="hidden" name="year_id">
                                    <label class="col-sm-3">Academic Year<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
									<select id="academic_year" name="academic_year" class="form-control" required>
                                            <?php 
                                         foreach($academic_year_details as $row){ ?>
                                            <option value="<?= $row->academic_year; ?>" <?php if($_REQUEST['academic_year']==$row->academic_year){ ?> selected <?php } ?>><?= $row->academic_year; ?></option>   
                                            <?php }  ?>
                                        </select>
									
									</div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('academic_year');?></span></div>
                                </div> 
                                 <div class="form-group">
                                   
                                    <label class="col-sm-3">Academic Session<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
									<select id="academic_session" name="academic_session" class="form-control" required>
                                            <option value="SUMMER" <?php if($_REQUEST['academic_session']=="SUMMER"){ ?> selected <?php } ?>>SUMMER</option> 
                                            <option value="WINTER" <?php if($_REQUEST['academic_year']=="WINTER"){ ?> selected <?php } ?>>WINTER</option>		
                                        </select>
									
									</div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('academic_year');?></span></div>
                                </div>
								 <div class="form-group">
                                    
                                    <label class="col-sm-3">Start month<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
									<select id="start_month" name="start_month" class="form-control" required>
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
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('start_month');?></span></div>
                                </div>
								  <div class="form-group">
                                    
                                    <label class="col-sm-3">Last month<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
									<select id="last_month" name="last_month" class="form-control" required>
                                            <option value="JAN" <?php if($_REQUEST['last_month']=="JAN"){ ?> selected <?php } ?>>JAN</option> 
                                            <option value="FEB" <?php if($_REQUEST['last_month']=="FEB"){ ?> selected <?php } ?>>FEB</option>	
											<option value="MAR" <?php if($_REQUEST['last_month']=="MAR"){ ?> selected <?php } ?>>MAR</option> 
											<option value="APR" <?php if($_REQUEST['last_month']=="APR"){ ?> selected <?php } ?>>APR</option>
											<option value="MAY" <?php if($_REQUEST['last_month']=="MAY"){ ?> selected <?php } ?>>MAY</option> 
											<option value="JUN" <?php if($_REQUEST['last_month']=="JUN"){ ?> selected <?php } ?>>JUN</option>
											<option value="JUL" <?php if($_REQUEST['last_month']=="JUL"){ ?> selected <?php } ?>>JUL</option> 
											<option value="AUG" <?php if($_REQUEST['last_month']=="AUG"){ ?> selected <?php } ?>>AUG</option>
											<option value="SEP" <?php if($_REQUEST['last_month']=="SEP"){ ?> selected <?php } ?>>SEP</option> 
											<option value="OCT" <?php if($_REQUEST['last_month']=="OCT"){ ?> selected <?php } ?>>OCT</option>
											<option value="NOV" <?php if($_REQUEST['last_month']=="NOV"){ ?> selected <?php } ?>>NOV</option> 
											<option value="DEC" <?php if($_REQUEST['last_month']=="DEC"){ ?> selected <?php } ?>>DEC</option>											
                                        </select>
									
									</div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('last_month');?></span></div>
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3"> Start Date <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><input type="text" id="start_date" name="start_date" class="form-control" value="<?=isset($_REQUEST['start_date'])?$_REQUEST['start_date']:''?>"  required/></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('start_date');?></span></div>
                                </div>
																 <div class="form-group">
                                    
                                    <label class="col-sm-3">Feedback Cycle<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
									<select id="feedback_cycle" name="feedback_cycle" class="form-control" required>
                                            <option value=1 <?php if($_REQUEST['feedback_cycle']==1){ ?> selected <?php } ?>>1</option> 
                                            <option value=2 <?php if($_REQUEST['feedback_cycle']==2){ ?> selected <?php } ?>>2</option>	
																					
                                        </select>
									
									</div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('feedback_cycle');?></span></div>
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
                            <?php // } ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>