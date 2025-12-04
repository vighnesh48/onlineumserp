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
               fee:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Fee'
                      },
                      required: 
                      {
                       message: 'Please Enter Fee'
                      }
                     
                    }
                }
            }       
        })
		
		
		$('.alphaonly').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z ]/g,'') ); }
		);
		$('.alphanum').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^A-Z0-9 ]/g,'') ); }
		);
		
		$('.numbersOnly').keyup(function () {
		
		if (this.value != this.value.replace(/[^0-9]/g, '')) {
		   this.value = this.value.replace(/[^0-9]/g, '');
		} 
		});
		
    });

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Transport </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm">
			<i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Boarding Fee Details</h1>
			
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Details</span>
							
                    </div>
                    <div class="panel-body">
				<h4 style="color:red;padding-left:250px;" id="err_msg"></h4>
				<h4 style="color:red;padding-left:250px;" id="err_msg1"></h4>

				<h4 id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
				</h4>
				<h4 id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
				</h4>
			<div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/edit_boarding_fee_submit/'.$boarding_fee_details['sffm_id'].'/'.$campus.'/'.$academic)?>" method="POST">    

								<div class="form-group">
                                    <label class="col-sm-2">Campus</label>                                    
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="campus" name="campus" value="<?=$campus?>" readonly />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2">Academic Year</label>                                    
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="academic" name="academic" value="<?=$academic?>" readonly/>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('academic');?></span></div>
                                </div>
                                
								<div class="form-group">
                                    <label class="col-sm-2"> Boarding Point</label>                                    
                                    <div class="col-sm-4">
                                        <input type="text"  class="form-control" id="point" name="point" value="<?=$boarding_fee_details['boarding_point']?>" readonly/>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('point');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-2"> Fee  <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <input type="text" id="fee" name="fee" value="<?=$boarding_fee_details['fees']?>" class="form-control alphanum" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('fee');?></span></div>
                                </div>
																
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
