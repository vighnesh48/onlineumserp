<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script> 
var vendor='',driver_id='',campus='';   
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
                
				campus:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select campus'
                      },
                      required: 
                      {
                       message: 'Please select campus'
                      }
                     
                    }
                },
				route:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select route'
                      },
                      required: 
                      {
                       message: 'Please select route'
                      }
                     
                    }
                },
				vendor:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select vendor'
                      },
                      required: 
                      {
                       message: 'Please select vendor'
                      }
                     
                    }
                },
				did:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select driver'
                      },
                      required: 
                      {
                       message: 'Please select driver'
                      }
                     
                    }
                },
				bno:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select bus'
                      },
                      required: 
                      {
                       message: 'Please select bus'
                      }
                     
                    }
                }
            }       
        })
		
		
		$('.alphaonly').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z. ]/g,'') ); }
		);
		
		$('#campus').on('change', function () {
		 campus = $(this).val();

		if (campus) 
		{
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Transport/getvendorsbycampus',
				data: {campus : campus},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#vendor').html(html);
					}else{
					  $('#vendor').html('<option value="">No vendors found</option>');  
					}
				}
			});
			
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Transport/getroutesbycampus',
				data: {campus : campus},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#route').html(html);
					}else{
					  $('#route').html('<option value="">No routes found</option>');  
					}
				}
			});
			
		} else {
			$('#route').html('<option value="">Select campus first</option>');
				$('#vendor').html('<option value="">Select campus first</option>');
			$('#did').html('<option value="">Select campus first</option>');
			$('#bno').html('<option value="">Select campus first</option>');
		}
	});
		   
	$('#vendor').on('change', function () {
		 vendor = $(this).val();

		if (vendor) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Transport/get_drivers_list_notin_driver_bus_map',
				data: {vendor : vendor,campus:campus},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#did').html(html);
					}else{
					  $('#did').html('<option value="">No drivers found</option>');  
					}
				}
			});
			
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Transport/get_buses_list_notin_driver_bus_map',
				data: {vendor : vendor},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#bno').html(html);
					}else{
					  $('#bno').html('<option value="">No buses found</option>');  
					}
				}
			});
			
		} else {
			$('#did').html('<option value="">Select vendor first</option>');
			$('#bno').html('<option value="">Select vendor first</option>');
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
			<i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Driver Bus Mapping </h1>
			
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter Details</span>
							<span style="color:red;padding-left:40px;" id="err_msg"></span>
							
			<span id="flash-messages" style="color:Green;padding-left:50px;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
			</span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
			</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/driver_bus_mapping_submit')?>" method="POST" onsubmit="return validate_faci_category(event)">     
	
								<div class="form-group">
                                    <label class="col-sm-2">Campus <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="campus" name="campus"  class="form-control" required>
											  <option value="">Select campus</option>
											  <option value="NASHIK">Nashik</option>
											  <option value="SIJOUL">Sijoul</option>
                                    </select>
								  
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-2">Route <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="route" name="route" class="form-control" required>
										  <option value="">select Route</option>
										  
									  </select>
								  
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('route');?></span></div>
                                </div>
								
                                <div class="form-group">
                                    <label class="col-sm-2">Vendor Name<?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="vendor" name="vendor" class="form-control" required>
										  <option value="">select vendor</option>
										  
									  </select>
								  
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('vendor');?></span></div>
                                </div>
                                
								<div class="form-group">
                                    <label class="col-sm-2"> Driver id <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                         <select class="form-control" name="did" id="did" required>
                                      <option value="">select driver id</option>
									  </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('did');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-2"> Bus No. <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                         <select class="form-control" name="bno" id="bno" required>
                                      <option value="">select Bus No.</option>
									  </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('bno');?></span></div>
                                </div>
								
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Allocate</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/drivers_list')?>'">Cancel</button></div>
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
function check_crs_exists()
{
	//alert("gvjhj");
	var cname=$('#cname').val();
	var csname=$('#csname').val();
	if(cname=="")
	{
		$('#err_msg').html('Please Enter Course Name');
	}
	else if(csname=="")
	{
		$('#err_msg').html('Please Enter Course Short Name');
	}
	else
	{
		$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Master/check_course_exists',
				data: {cname:cname,csname:csname},
				success: function (html) {
					//alert(html);
					if(html>0)
					{$('#err_msg').html("This Course Details are already there.");status=1;}
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
