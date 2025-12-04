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
                host_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select hostel'
                      },
                      required: 
                      {
                       message: 'Please select hostel'
                      }
                     
                    }
                }
				,
				hstate_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select State'
                      },
                      required: 
                      {
                       message: 'Please select state'
                      }
                     
                    }
                },
				hdistrict_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select District'
                      },
                      required: 
                      {
                       message: 'Please select District'
                      }
                     
                    }
                },
				hcity:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select city'
                      },
                      required: 
                      {
                       message: 'Please select city'
                      }
                     
                    }
                },
				institute:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select institute'
                      },
                      required: 
                      {
                       message: 'Please select institute'
                      }
                     
                    }
                },
				department:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select department'
                      },
                      required: 
                      {
                       message: 'Please select department'
                      }
                     
                    }
                },
				Organization:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Organization'
                      },
                      required: 
                      {
                       message: 'Please select Organization'
                      }
                     
                    }
                },
				designation:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select designation'
                      },
                      required: 
                      {
                       message: 'Please select designation'
                      }
                     
                    }
                },
				responsibility:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select responsibility'
                      },
                      required: 
                      {
                       message: 'Please select responsibility'
                      }
                     
                    }
                },
				academic:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select academic'
                      },
                      required: 
                      {
                       message: 'Please select academic'
                      }
                     
                    }
                },
                office:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Office Number should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Office Number should be numeric'
                      },
                       stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Office number should be 10-12 characters.'
                        } 
                    }
                },
				 personal:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'personal Number should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'personal Number should be numeric'
                      },
                       stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'personal number should be 10-12 characters.'
                        } 
                    }
                },
				email:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Personal Email should not be empty'
                      },
                      regexp: 
                      {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'This is not a valid email'
                      }
                      
                    }
                },
				 inchrg_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Incharge name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Incharge name should be 2-50 characters.'
                        }
                    }
                },
				inchrg_address:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Incharge Address should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Incharge Address should be 2-50 characters.'
                        }
                    }
                },
               
                inchrg_pincode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Incharge pincode should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Incharge pincode should be numeric'
                      },
                      stringLength: 
                        {
                        max: 6,
                        min: 6,
                        message: 'Incharge pincode should be 6 digits.'
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
        <li class="active"><a href="<?=base_url($currentModule)?>"> Hostel</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add In-charge Details</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row"> 
						<br/>				
					<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
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
                        <span class="panel-title">Enter Details</span>
                        <div class="holder"></div>
                </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_inchrg_submit')?>" method="POST">    
							
							<input type="hidden" id="hid" name="hid" />
							<input type="hidden" id="h_code" name="h_code" />    

							<div class="form-group">
                                    
									<div class="col-sm-4">
									<label>Select Academic Year: <?=$astrik?></label>
                                        <select id="academic" name="academic" class="form-control" >
										<option value="">Select Academic Year</option>
                                           <?php //echo "state".$state;exit();
										if(!empty($academic_details)){
											foreach($academic_details as $academic){
												$arr=explode("-",$academic['academic_year']);
												$ac_year=$arr[0];
												if($academic['status']=='Y')
												{
												?>
											  <option selected value="<?=$ac_year?>"><?=$academic['academic_year']?></option>  
											<?php 
												}else{
												?>
												<option value="<?=$ac_year?>"><?=$academic['academic_year']?></option> 
												<?php
												}
												
											}
										}
									  ?>
                                      
                                        </select>	
												<span style="color:red;"><?php echo form_error('academic');?></span>
                                    </div>
                                    <div class="col-sm-4">
									<label>Select Hostel: <?=$astrik?></label>
									<select class="form-control" name="host_id" id="host_id" required>
											  <option value="">select Hostel</option>
											  <?php //echo "state".$state;exit();
												if(!empty($hostel_details)){
													foreach($hostel_details as $hostels){
														?>
													  <option value="<?=$hostels['host_id']?>||<?=$hostels['hostel_code']?>"><?=$hostels['hostel_name']?></option>  
													<?php 
														
													}
												}
											  ?>
										  </select>
										  <span style="color:red;"><?php echo form_error('host_id');?></span>
									</div>                                    
                                   
                                    <div class="col-sm-4">
									<label>Enter In-charge Name: <?=$astrik?></label>
									<input type="text" id="inchrg_name" name="inchrg_name" placeholder="Incharge Name" class="form-control" />
									<span style="color:red;"><?php echo form_error('inchrg_name');?></span>
									</div>
									 
                                </div>
								
								<div class="form-group">
                                    <div class="col-sm-4">
									<label >Select Organization: <?=$astrik?></label>
                                        <select id="Organization" name="Organization" class="form-control" >
										 <option value="">Select Organisation</option>
                                            			          <?php
					          
   		$exp = explode("_",$_SESSION['name']);

	
            if($exp[1]=="nashik")
        {
 
					          ?>
					      <option value="SU">Sandip University</option>
					  <option value="SF">Sandip Foundation</option>
					  <?php
 }
  elseif($exp[1]=="sijoul")
  {
					  ?>
					  <option value="SF-SIJOUL">Sandip Foundation Sijoul</option>
					  <?php
  }
  else
  {
					  ?>
		      <option value="SU">Sandip University</option>
					  <option value="SF">Sandip Foundation</option>
				  <option value="SF-SIJOUL">Sandip Foundation Sijoul</option>
					  <?php
  }
					  ?>
                                      
                                        </select>                                        
                                    <span style="color:red;"><?php echo form_error('Organization');?></span></div>                                    
                                    <div class="col-sm-4">
									<label >Select Institue: <?=$astrik?></label>
                                        <select id="institute" name="institute" class="form-control" >
                                      <option value="">select instute name</option>
											  
                                        </select> 
										                                       
                                   <span style="color:red;"><?php echo form_error('institute');?></span></div>
								   <div class="col-sm-4">
								   <label >Enter Department: <?=$astrik?></label>
                                     <input type="text" id="department" name="department" placeholder="Department" class="form-control" />
                                    <span style="color:red;"><?php echo form_error('department');?></span></div>
									
                                </div>
								
								<div class="form-group">
                                    
									<div class="col-sm-4">
									<label>Select Responsibility: <?=$astrik?></label>
                                    <select id="responsibility" name="responsibility" class="form-control" >
										
                                            <option value="">Select responsibility</option>
                                            <option value="In-Charge">In-Charge</option>
                                             <option value="Rector">Rector</option>
                                      
                                        </select> 
<span style="color:red;"><?php echo form_error('responsibility');?></span> 										
                                    </div>
									
									<div class="col-sm-4">
									<label>Select Designation: <?=$astrik?></label>
									<select class="form-control" name="designation" id="designation" required>
											  <option value="">select Designation</option>
											  <?php //echo "state".$state;exit();
												if(!empty($designations)){
													foreach($designations as $list){
														?>
													  <option value="<?=$list['designation_name']?>"><?=$list['designation_name']?></option>  
													<?php 
														
													}
												}
											  ?>
										  </select>
										  <span style="color:red;"><?php echo form_error('designation');?></span>
									</div>
									
                                                                        
                                   
                                    <div class="col-sm-4">
									<label>Enter Pincode: <?=$astrik?></label>
									<input type="text" id="inchrg_pincode" name="inchrg_pincode" placeholder="Enter Pincode" class="form-control"   /><span style="color:red;"><?php echo form_error('inchrg_pincode');?></span>
									</div>
									 
                                </div>
								
							<div class="form-group">
                                
                                <div class="col-sm-4">
								<label >Select State: <?=$astrik?></label>
                                  <select class="form-control" name="hstate_id" id="hstate_id" required>
                                      <option value="">select State</option>
                                      <?php //echo "state".$state;exit();
                                        if(!empty($state)){
                                            foreach($state as $stat){
                                                ?>
                                              <option value="<?=$stat['state_id']?>"><?=$stat['state_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hstate_id');?></span>
                                </div>
								<div class="col-sm-4">
								<label >Select District: <?=$astrik?></label>
                                  <select class="form-control" name="hdistrict_id" id="hdistrict_id" required>
                                      <option value="">select District</option>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hdistrict_id');?></span>
                                </div>
								<div class="col-sm-4">
								<label >Select City: <?=$astrik?></label>
                                   <select class="form-control" name="hcity" id="hcity" required>
                                      <option value="">select City</option>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hcity');?></span>
                                </div>
                              </div>
                               	
								
								<div class="form-group">
                                    <div class="col-sm-4">
                                    <label>Enter Email: <?=$astrik?></label>
									<input type="text" id="email" name="email" class="form-control" placeholder="Enter email id" />
									<span style="color:red;" id="email"><?php echo form_error('email');?></span>
									
									</div>
									
                                    
                                    <div class="col-sm-4">
									<label >Enter Office mobile:<?=$astrik?></label>
									<input type="text" id="office" name="office" class="form-control"   placeholder="Enter Office number"/><span style="color:red;"><?php echo form_error('office');?></span></div>
									
									<div class="col-sm-4">
									<label >Enter Personal mobile:<?=$astrik?></label>
									<input type="text" id="personal" name="personal" placeholder="Enter Personal number" class="form-control" /><span style="color:red;"><?php echo form_error('personal');?></span>
									</div>
									
									
                                </div>
								<div class="form-group">
									<div class="col-sm-4">
									<label >Address:<?=$astrik?></label>
									<Textarea type="text" id="inchrg_address" class="form-control" NAME="inchrg_address" placeholder="Enter Address" ></textarea>
									<span style="color:red;"><?php echo form_error('inchrg_address');?></span>
									
									</div>
								
								</div>
								
                                <div class="form-group">
                                    
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/incharge_list')?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
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
/* var status=0;
function check_incharge_exists()
{
	var org=$('#Organisation').val();
	var institute=$('#college_name').val();
	var enroll=$('#enrollment_no').val();
	if(org=="")
	{
		$('#err_msg').html('Please select Organisation!!');
	}
	else if(institute=="")
	{
		$('#err_msg').html('Please select Institute!!');
	}
	else if(enroll=="")
	{
		$('#err_msg').html('Please enter enrollment number!!');
	}
	else
	{
		$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/check_student_exists',
				data: {enroll:enroll,org:org,institute:institute},
				success: function (html) {
					//alert(html);
					if(html==1)
					{$('#err_msg').html("This student Enrollment Details are already added!!");status=1;}
				else
					{$('#err_msg').html("");status=0;}
				}
			});
	}
}

function validate_add_incharge_form(events)
{
	if(status==1)
	{ return false;}
}

 */

var host_id="",h_code="",h_name="";
$(document).ready(function(){
	$('#host_id').on('change', function () {
		 host_id = $(this).val();
		 h_name = $(this).text();
		 var hostel_data=host_id.split("||");
			 host_id = hostel_data[0];
			 $('#hid').val(host_id);
			h_code = hostel_data[1];
			$('#h_code').val(h_code);
			
	});
	
	
	$('#Organization').on('change', function () {
		var	org = $(this).val();
		//alert(org);
		if (org) {
			$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Hostel/getinstutename',
						data: 'org=' + org,
						success: function (html) {
							//alert(html);
							$('#institute').html(html);
						}
			});
		} else {
			$('#institute').html('<option value="">Select Organization first</option>');
		}
	});
  	
    // City by State
	$('#hstate_id').on('change', function () {
		 stateID = $(this).val();
			var state_ID = $("#hstate_id").val();
		//alert("called==="+stateID);
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#hdistrict_id').html(html);
				}
			});
		} else {
			$('#hdistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#hdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#hstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#hcity').html(html);
					}else{
					  $('#hcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#hcity').html('<option value="">Select district first</option>');
		}
	});	
	
	});	

</script>
