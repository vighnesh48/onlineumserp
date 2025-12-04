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
                
				academic:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select academic year'
                      },
                      required: 
                      {
                       message: 'Please select academic year'
                      }
                     
                    }
                },
               smonth:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Start Month'
                      },
                      required: 
                      {
                       message: 'Please select Start Month'
                      }
                     
                    }
                },
				lmonth:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Last Month'
                      },
                      required: 
                      {
                       message: 'Please select Last Month'
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
       <!-- <li class="active"><a href="#">Academic Year</a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Academic Year </h1>
			<span style="color:red;padding-left:0px;" id="err_msg"></span>
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
		<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
           
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter Details</span>
							
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_academic_year_submit')?>" method="POST" onsubmit="return validate_faci_category(event)">                                                               
                                <div class="form-group">
                                    <label class="col-sm-3">Academic Year <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="academic" name="academic"  onchange="check_year_exists()" class="form-control" >
                                            <option value="">Select Academic Year</option>
                                            <?php 
										 $yyyy=date('Y');
										 $yy=date('y')+1;
										   for($i=1;$i<=4;$i++)
										   {
											   /* if($yyyy==2017)
												   echo '<option selected value="'.$yyyy.'-'.$yy.'">'.$yyyy.'-'.$yy.'</option>';
											   else */
												   echo '<option value="'.$yyyy.'-'.$yy.'">'.$yyyy.'-'.$yy.'</option>';
											   
											   $yyyy--;$yy--;
										   }
										   ?>
                                      
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('academic');?></span></div>
                                </div>
                                
								<div class="form-group">
                                    <label class="col-sm-3">Start Month <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="smonth" name="smonth" onchange="check_year_exists()" class="form-control" required>
											  <option value="">select Start Month</option>
											  <option value="January">January</option>
											  <option value="July">July</option>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('smonth');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Last Month <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="lmonth" name="lmonth" onchange="check_year_exists()" class="form-control" required>
											  <option value="">select Last Month</option>
											  <option value="June">June</option>
											  <option value="December">December</option>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('lmonth');?></span></div>
                                </div>
								
								
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Add</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/academic_year')?>'">Cancel</button></div>
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


<script>
var status=0;
function check_year_exists()
{
	var academic=$('#academic').val();
	var smonth=$('#smonth').val();
	var lmonth=$('#lmonth').val();
	if(academic=="")
	{
		$('#err_msg').html('Please select Academic year.');
	}
	else if(smonth=="")
	{
		$('#err_msg').html('Please select start month.');
	}
	else if(lmonth=="")
	{
		$('#err_msg').html('Please select last month.');
	}
	else
	{
		$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Master/check_academic_year_exists',
				data: {academic:academic,smonth:smonth,lmonth:lmonth},
				success: function (html) {
					//alert(html);
					if(html>0)
					{$('#err_msg').html("This Academic Year Details are already there.");status=1;}
				else
					{$('#err_msg').html("");status=0;}
				}
			});
	}
}

function validate_faci_category(events)
{
	if(status==1)
	{ return false;}
}


</script>
