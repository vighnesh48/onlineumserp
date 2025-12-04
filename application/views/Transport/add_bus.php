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
                
				bno:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Bus Number'
                      },
                      required: 
                      {
                       message: 'Please Enter Bus Number'
                      }
                     
                    }
                },
               capacity:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter capacity'
                      },
                      required: 
                      {
                       message: 'Please Enter Capacity'
                      }
                     
                    }
                },
				company:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter company'
                      },
                      required: 
                      {
                       message: 'Please Enter company'
                      }
                     
                    }
                },
				model:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Model Number'
                      },
                      required: 
                      {
                       message: 'Please Enter Model Number'
                      },
                      stringLength: 
                        {
                        max: 10,
                       
                        message: 'Model Number should Not be More Than 10 digits.'
                        }
                     
                    }
                },
				myear:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Manufacture Year'
                      },
                      required: 
                      {
                       message: 'Please Select Manufacture Year'
                      }
                     
                    }
                },
				inhouse:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select In house'
                      },
                      required: 
                      {
                       message: 'Please select In house'
                      }
                     
                    }
                }
            }       
        })
		
		
		$('.alphaonly').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z. ]/g,'') ); }
		);
		$('.alphanum').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z0-9 ]/g,'') ); }
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Transport</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm">
			<i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Bus </h1>
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter Details</span>
							<span style="color:red;padding-left:40px;" id="err_msg"></span>
							<span id="flash-messages" style="color:Green;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_bus_submit')?>" method="POST" onsubmit="return validate_faci_category(event)">     
							<div class="form-group">
								<label class="col-sm-2">Vendor:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="vendor" name="vendor"  class="form-control" required>
									<option value="">Select vendor</option>
									 <?php 
											if(!empty($vendor_details)){
												foreach($vendor_details as $coursename){
													?>
												  <option value="<?=$coursename['vendor_id']?>"><?=$coursename['vendor_name']?></option>  
												<?php 
													
												}
											}
									  ?>
									  </select>
									  </div> 
									  <div class="col-sm-3"><span style="color:red;"><?php echo form_error('vendor');?></span></div>
								</div>  
                                <div class="form-group">
                                    <label class="col-sm-2">Bus Number <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <input type="text" id="bno" name="bno" onchange="check_bus_exists()" class="form-control alphanum" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('bno');?></span></div>
                                </div>
                                
								<div class="form-group">
                                    <label class="col-sm-2"> Bus Capacity <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <input type="text" id="capacity" name="capacity" class="form-control numbersOnly" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('capacity');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-2"> Bus Company <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <input type="text" id="company" name="company" class="form-control" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('company');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-2"> Bus Model No. <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <input type="text" id="model" name="model" class="form-control" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('model');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-2">Manufacture Year<?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                       <!-- <input type="text" id="myear" name="myear" class="form-control numbersOnly" />-->
										
										<select id="myear" name="myear" class="form-control" >
                                            <option value="">Select Manufacture Year</option>
                                          <?php 
										 $yyyy=date('Y');
										 //$yy=date('y');
										   for($i=1;$i<=9;$i++)
										   {
											   echo '<option value="'.$yyyy.'">'.$yyyy.'</option>';
											   $yyyy--;//$yy--;
										   }
										   ?>
                                        </select> 
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('myear');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-2">Is In-House?<?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <select id="inhouse" name="inhouse"  class="form-control" required>
											  <option value="">Select Status</option>
											  <option value="Y">Yes</option>
											  <option value="N">No</option>
                                    </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('inhouse');?></span></div>
                                </div>
								
                                <div class="form-group">
                                   
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Add</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/buses_list')?>'">Cancel</button></div>
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
function check_bus_exists()
{
	var bno=$('#bno').val();
	if(bno=="")
	{
		$('#err_msg').html('Please Enter Bus Number');
	}
	else
	{
		$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Transport/check_bus_exists',
				data: {bno:bno},
				success: function (html) {
					//alert(html);
					if(html>0)
					{$('#err_msg').html("This Bus is already there.");status=1;}
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
