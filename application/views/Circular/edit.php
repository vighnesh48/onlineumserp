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
                title:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Title should not be empty'
                      }
                    }
                },
                fileatt:
                {
                    validators: 
                    {
                      
                      file:{
                        extension: 'jpeg,jpg,png,pdf',
                        type: 'image/jpeg,image/jpg,image/png,application/pdf',                        
                        message: 'The selected file is not valid'
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
        <li class="active"><a href="#">Edit Circular</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Circular</h1>
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
                            <span class="panel-title">Circuler Details</span>
							<div style="color:red;text-align:center">
                            <?php if(!empty($this->session->flashdata('message'))) {
								echo $this->session->flashdata('message');
							}
							?>
							</div>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">   
							
                            <form id="form" name="form" enctype="multipart/form-data" action="<?=base_url($currentModule.'/update_submit')?>" method="POST">                                                               
                                <input type="hidden" value="<?=$cir_details[0]['cid']?$cir_details[0]['cid']:''?>" id="cid" name="cid" />
                                <div class="form-group">
                                    <label class="col-sm-3">Title <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                      <input type="text" id="title" name="title" class="form-control" value="<?=$cir_details[0]['title']?$cir_details[0]['title']:''?>" />                                       
                                    </div>    
									<label class="col-sm-3">Circular For(type) <?=$astrik?></label>
                                    <div class="col-sm-3">
									<select class="form-control" name="circular_type" id="circular_type" required="">
										<option value="">select</option>
										<option value="Students" <?php if($cir_details[0]['circular_type']=='Students'){echo "selected";}?>>Students</option>
										<option value="Staff" <?php if($cir_details[0]['circular_type']=='Staff'){echo "selected";}?>>Staff</option>
										<option value="General" <?php if($cir_details[0]['circular_type']=='General'){echo "selected";}?>>General</option>
									</select>
									</div>      
                                </div>
								<div class="form-group">
                                      
									<label class="col-sm-3">File <?=$astrik?></label>
                                    <div class="col-sm-3"><input type="file" id="fileatt" name="fileatt" class="form-control" value="" /><?=$cir_details[0]['file_attachment']?$cir_details[0]['file_attachment']:''?></div>                                   
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
