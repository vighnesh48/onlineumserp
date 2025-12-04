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
				rname:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Route Name'
                      },
                      required: 
                      {
                       message: 'Please Enter Route Name'
                      }
                     
                    }
                },
               rcode:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Route Code'
                      },
                      required: 
                      {
                       message: 'Please Enter Route Code'
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Transport</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm">
			<i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Route </h1>
			
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter Details</span>
							<span style="color:red;padding-left:40px;" id="err_msg"></span>
							<span style="color:red;padding-left:40px;" id="err_msg1"></span>
							
			<span id="flash-messages" style="color:Green;padding-left:50px;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
			</span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
			</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_route_submit')?>" method="POST" onsubmit="return validate_faci_category(event)">     
							<div class="form-group">
                                    <label class="col-sm-2">Campus <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="campus" name="campus"  onchange="check_route_exists()"  class="form-control" required>
											  <option value="">Select campus</option>
											  <option value="NASHIK">Nashik</option>
											  <option value="SIJOUL">Sijoul</option>
                                    </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus');?></span></div>
                                </div>                                                          
                                <div class="form-group">
                                    <label class="col-sm-2">Route Name <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <input type="text" id="rname" name="rname" onblur="check_route_exists()" class="form-control alphaonly" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('rname');?></span></div>
                                </div>
                                
								<div class="form-group">
                                    <label class="col-sm-2"> Route Code <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <input type="text" id="rcode" name="rcode" onblur="check_route_exists()" class="form-control alphanum" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('rcode');?></span></div>
                                </div>
																
                                <div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Add</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/route_master')?>'">Cancel</button></div>
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
var status=0,error_status=0;
function check_route_exists()
{
	var campus = $('#campus').val();
	var rname=$('#rname').val();
	var rcode=$('#rcode').val();
	$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Transport/check_route_exists',
				data: {rname:rname,rcode:rcode,campus:campus},
				success: function (html) {
					//alert(html);
					if(html>0)
					{$('#err_msg1').html("This route name/code is already there.");status=1;}
				else
					{$('#err_msg1').html("");status=0;}
				}
		});
}

function validate_faci_category(events)
{
	if(status==1)
	{ return false;}
}


</script>
