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
                
				ccode:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter School Code'
                      },
                      required: 
                      {
                       message: 'Please Enter School Code'
                      }
                     
                    }
                },
				cperson:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Contact Person'
                      },
                      required: 
                      {
                       message: 'Please Enter Contact Person'
                      }
                     
                    }
                },
				 mobile:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mobile should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Mobile should be numeric'
                      }
					  ,
                      stringLength: 
                        {
                        max: 12,
                        min:10,
                        message: 'Mobile number should be 12 digits.'
                        }
                
                    }
                },
				 contact:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'contact should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'contact should be numeric'
                      }
					  ,
                      stringLength: 
                        {
                        max: 12,
                        min:10,
                        message: 'contact number should be 12 digits.'
                        }
                
                    }
                },
				saddress:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Address should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: ' Address should be 2-50 characters.'
                        }
                    }
                },
				cname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'School name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'School name should be 2-50 characters.'
                        }
                    }
                },
				ssname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'School short name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'School short name should be 2-50 characters.'
                        }
                    }
                },
				country:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter country'
                      },
                      required: 
                      {
                       message: 'Please Enter country'
                      }
                     
                    }
                },
				state:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter state'
                      },
                      required: 
                      {
                       message: 'Please Enter state'
                      }
                     
                    }
                },
				district:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter district'
                      },
                      required: 
                      {
                       message: 'Please Enter district'
                      }
                     
                    }
                },
				 pincode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'pincode should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'pincode should be numeric'
                      }
					  ,
                      stringLength: 
                        {
                        max: 6,
                        min: 6,
                        message: 'Pincode should be 6 digits.'
                        }
					}

                },
				semail:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'School Email should not be empty'
                      },
                      regexp: 
                      {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'This is not a valid email'
                      }
                      
                    }
                },
				cemail:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Contact Email should not be empty'
                      },
                      regexp: 
                      {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'This is not a valid email'
                      }
                      
                    }
                },
				syear:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Start Year'
                      },
                      required: 
                      {
                       message: 'Please select Start Year'
                      }
                     
                    }
                },
				stype:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select School Type'
                      },
                      required: 
                      {
                       message: 'Please select School Type'
                      }
                     
                    }
                },
            }       
        })
		
		
		$('.alphaonly').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z ]/g,'') ); }
		);
		
		$('.numbersOnly').keyup(function () {
		
		if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
		   this.value = this.value.replace(/[^0-9\.]/g, '');
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
        <!--<li class="active"><a href="#">school</a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add School </h1>
			<span style="color:red;padding-left:0px;" id="err_msg"></span>
			<span id="flash-messages" style="color:Green;padding-left:50px;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
			</span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
			</span>
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter Details</span>
							<span style="color:red;padding-left:40px;" id="err_msg"></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_school_submit')?>" method="POST" onsubmit="return validate_faci_category(event)">    
								<div class="form-group">
                                    <div class="col-sm-4">
									<label >Start Year:<?=$astrik?></label>
									<select id="syear" name="syear" onchange="check_schl_exists()" class="form-control" >
                                            <option value="">Select Start Year</option>
                                            <?php 
										 $yyyy=date('Y');
										 $yy=date('y')+1;
										   for($i=1;$i<=4;$i++)
										   {
											   /* if($yyyy==2017)
												   echo '<option selected value="'.$yyyy.'-'.$yy.'">'.$yyyy.'-'.$yy.'</option>';
											   else */
												   echo '<option value="'.$yyyy.'">'.$yyyy.'-'.$yy.'</option>';
											   
											   $yyyy--;$yy--;
										   }
										   ?>
                                      
                                        </select>                                     
                                   <span style="color:red;"><?php echo form_error('syear');?></span>
								   </div>
								   
									
									<div class="col-sm-4">
									<label >Campus:<?=$astrik?></label>
									<select id="campus" name="campus" onchange="check_schl_exists()" class="form-control" required>
											  <option value="">select Campus</option>
											  <option value="Nashik">Nashik</option>
											  <option value="Sijoul">Sijoul</option>
                                        </select>                                    
                                    <span style="color:red;"><?php echo form_error('campus');?></span>
									</div>
									
									<div class="col-sm-4">
									<label >School Type:<?=$astrik?></label>
									<select id="stype" name="stype" onchange="check_schl_exists()" class="form-control" required>
											  <option value="">select School Type</option>
											  <option value="Regular">Regular</option>
											  <option value="Distance">Distance</option>
                                        </select>                                    
                                    <span style="color:red;"><?php echo form_error('stype');?></span>
									</div>
									
                                    
                                </div>

								<div class="form-group">
								
									<div class="col-sm-4">
									<label > School Code:<?=$astrik?></label>
									<input type="text" id="ccode" onchange="check_schl_exists()" name="ccode" class="form-control numbersOnly" placeholder="School Code"  />                                    
                                    <span style="color:red;"><?php echo form_error('ccode');?></span>
									</div>
									
                                    <div class="col-sm-4">
									<label > School Name:<?=$astrik?></label>
									<input type="text" id="cname" name="cname" onchange="check_schl_exists()" placeholder="School Name " class="form-control alphaonly"  /><span style="color:red;"><?php echo form_error('cname');?></span>
									</div>
									
									<div class="col-sm-4">
									<label > School Short Name:<?=$astrik?></label>
									<input type="text" id="ssname" name="ssname" onchange="check_schl_exists()" class="form-control alphaonly" placeholder="School Short Name" />                                    
                                   <span style="color:red;"><?php echo form_error('ssname');?></span>
								   </div>
									
									
                                </div>
								
								<div class="form-group">
                                    <div class="col-sm-4">
									<label > School Email:<?=$astrik?></label>
									<input type="text" id="semail" name="semail" placeholder="School Email" class="form-control "  /><span style="color:red;"><?php echo form_error('semail');?></span>
									</div>
									
									<div class="col-sm-4">
									<label > School Address:<?=$astrik?></label>
									<input type="text" id="saddress" name="saddress" class="form-control alphaonly" placeholder="School Address" />                                    
                                   <span style="color:red;"><?php echo form_error('saddress');?></span>
								   </div>
								   <div class="col-sm-4">
									<label > Pincode:<?=$astrik?></label>
									<input type="text" id="pincode" name="pincode" placeholder="Pincode" class="form-control "  /><span style="color:red;"><?php echo form_error('pincode');?></span>
									</div>
									
									 </div>
								
								<div class="form-group">
									
									
									<div class="col-sm-4">
									<label > Country:<?=$astrik?></label>
									<input type="text" id="country" name="country" placeholder="Country" class="form-control alphaonly"  /><span style="color:red;"><?php echo form_error('country');?></span>
									</div>
									
                                    <div class="col-sm-4">
									<label > State:<?=$astrik?></label>
									<input type="text" id="state" name="state" placeholder="State" class="form-control alphaonly"  /><span style="color:red;"><?php echo form_error('state');?></span>
									</div>
									
									<div class="col-sm-4">
									<label > District:<?=$astrik?></label>
									<input type="text" id="district" name="district" class="form-control alphaonly" placeholder="District" />                                    
                                   <span style="color:red;"><?php echo form_error('district');?></span>
								   </div>
                                </div>
								
								<div class="form-group">
                                    
                                    <div class="col-sm-4">
									<label > Contact Person:<?=$astrik?></label>
									<input type="text" id="cperson" name="cperson" placeholder="Contact Person" class="form-control alphaonly"  /><span style="color:red;"><?php echo form_error('cperson');?></span>
									</div>
									<div class="col-sm-4">
									<label > Contact Email:<?=$astrik?></label>
									<input type="text" id="cemail" name="cemail" placeholder="Contact Email" class="form-control"  /><span style="color:red;"><?php echo form_error('cemail');?></span>
									</div>
                                    <div class="col-sm-4">
									<label > Contact no. :<?=$astrik?></label>
									<input type="text" id="contact" name="contact" placeholder="contact" class="form-control "  /><span style="color:red;"><?php echo form_error('contact');?></span>
									</div>
									
                                </div>
								
								<!--<div class="form-group">
                                    <div class="col-sm-4">
									<label >Enter Mobile:<?=$astrik?></label>
									<input type="text" id="mobile" name="mobile" class="form-control alphaonly" placeholder="mobile" />                                    
                                   <span style="color:red;"><?php echo form_error('mobile');?></span>
								   </div>
									
                                </div>-->
								           
																
                                <div class="form-group">
                                    <!--<div class="col-sm-3"></div>-->
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Add</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/school_master')?>'">Cancel</button></div>
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
function check_schl_exists()
{
	var syear=$('#syear').val();
	var campus=$('#campus').val();
	var ccode=$('#ccode').val();
	var stype=$('#stype').val();
	var cname=$('#cname').val();
	var ssname=$('#ssname').val();
	var id="<?=$course_details['school_id']?>";
	
	if(syear=="")
	{
		$('#err_msg').html('Please select start year');
	}
	else if(campus=="")
	{
		$('#err_msg').html('Please Select Campus');
	}
	else if(stype=="")
	{
		$('#err_msg').html('Please Select School Type');
	}
	else if(ccode=="")
	{
		$('#err_msg').html('Please Enter School Code');
	}
	else if(cname=="")
	{
		$('#err_msg').html('Please Enter School Name');
	}
	else if(ssname=="")
	{
		$('#err_msg').html('Please Enter School Short Name');
	}
	else
	{
		$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Master/check_school_exists',
				data: {syear:syear,ccode:ccode,stype:stype,cname:cname,ssname:ssname,campus:campus,id:id},
				success: function (html) {
					//alert(html);
					if(html>0)
					{$('#err_msg').html("This School Details are already there.");status=1;}
				else
					{$('#err_msg').html("");status=0;}
				}
			});
	}
}

function validate_faci_category(events)
{
	if(status==1)
	{ return false; }
}
</script>
