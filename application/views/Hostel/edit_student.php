<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
		setTimeout(function() {
			$(".hide-it").hide();
		}, 5000);
		
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
				gender:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select gender'
                      },
                      required: 
                      {
                       message: 'Please select gender'
                      }
                     
                    }
                },
				dmission:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select admission'
                      },
                      required: 
                      {
                       message: 'Please select admission'
                      }
                     
                    }
                },
				current_year:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select current year'
                      },
                      required: 
                      {
                       message: 'Please select current year'
                      }
                     
                    }
                },
				enrollment_no:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Enrollment Number should not be empty'
                      },
                      stringLength: 
                        {
                        max: 11,
                        min: 9,
                        message: 'Enrollment Number should be 2-50 characters.'
                        }
                    }
                }/*,
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
                
				 mobile:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Parent mobile should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Parent mobile should be numeric'
                      }
					  ,
                      stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Parent mobile number should be 12 digits.'
                        }
                
                    }
                }/*, pmobile2:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Another Mobile Number should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Another Mobile Number should be numeric'
                      }
					  ,
                      stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'mobile number should be 12 digits.'
                        }
                     
                    }
                },
				 pmobile:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Parent mobile should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Parent mobile should be numeric'
                      }
					  ,
                      stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Parent mobile number should be 12 digits.'
                        }
                
                    }
                }/* ,
				 aadhar:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'aadhar number should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'aadhar Number should be numeric'
                      },
                       stringLength: 
                        {
                        max: 12,
                        min: 12,
                        message: 'aadhar Number should be 12 digits.'
                        } 
                    }
                } */,
				address:
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
                fname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'First name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'First name should be 2-50 characters.'
                        }
                    }
                },
				/* mname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Middle name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Middle name should be 2-50 characters.'
                        }
                    }
                }, */
				lname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Last name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Last name should be 2-50 characters.'
                        }
                    }
                },
				email:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Email should not be empty'
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
					}

                },provisional:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Is provisional'
                      },
                      required: 
                      {
                       message: 'Please select Is provisional'
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-3 text-ctext-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Student Details</h1>
            
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                   
                    <div class="panel-body">
                       <h4 class="hide-it" id="flash-messages" style="color:Green;padding-left:250px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
					<h4 class="hide-it" id="flash-messages" style="color:red;padding-left:250px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>

						 <div class="table-info">                            
                            
                            <form id="form" name="form" onsubmit="return validate_edit_student_form(event)" action="<?=base_url($currentModule.'/edit_student_submit/'.$student_details['student_id'])?>" method="POST">                                                               
                                <input type="hidden" value="" id="college_id" name="college_id" />
								<input type="hidden" name="state" id="state">
								<input type="hidden" name="district" id="district">
								<input type="hidden" name="city" id="city">
								<input type="hidden" name="Organisation" id="Organisation" value="SF">
								<div class="form-group">
									<div class="col-sm-3">
								<label >Select Campus:<?=$astrik?></label>
								</div>
								<div class="col-sm-3">
									<select id="campus" name="campus" class="form-control" >
										<option value="">Select Campus</option>
										
                                      <?php //echo "state".$state;exit();
                                        if(!empty($campus)){
                                            foreach($campus as $campusname){
                                                ?>
                                              <option value="<?=$campusname['campus_name']?>"><?=$campusname['campus_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
									</select> 
									<span style="color:red;"><?php echo form_error('campus');?></span>										
								</div>
									
									
                                    <div class="col-sm-3">
									<label >Select institute: <?=$astrik?></label>
									</div>
								<div class="col-sm-3">
								<select class="form-control" name="college_name" id="college_name" required>
											  <option value="">select institute</option>
											  <?php //echo "state".$state;exit();
												if(!empty($program_detail)){
													foreach($program_detail as $types){
														?>
													  <option value="<?=$types['college_name']?>"><?=$types['college_name']?></option>  
													<?php 
														
													}
												}
											  ?>
										  </select>
									<span style="color:red;"><?php echo form_error('college_name');?></span>
									</div>                                    
                                   
                                    
									 
                                </div>
								
								<div class="form-group">
                                   <div class="col-sm-3">
									<label >Select Program: <?=$astrik?></label>
									</div>
								<div class="col-sm-3">
								<select class="form-control" name="program" id="program" required>
										  <option value="">select Program</option>
									  </select>
									<span style="color:red;"><?php echo form_error('program');?></span>
									</div>
									<div class="col-sm-3">
									<label >Select Admission Year<?=$astrik?></label>
                                    </div>
								<div class="col-sm-3">
								<select id="admission" name="dmission" class="form-control" >
                                            <option value="">Select Admission Year</option>
                                          <?php 
										 $yyyy=date('Y');
										 $yy=date('y')+1;
										   for($i=1;$i<=4;$i++)
										   {
											   echo '<option value="'.$yyyy.'">'.$yyyy.'-'.$yy.'</option>';
											   $yyyy--;$yy--;
										   }
										   ?>
                                        </select>   
										<span style="color:red;"><?php echo form_error('dmission');?></span>										
                                    </div>
                                </div>
								
								 <div class="form-group">
								 <div class="col-sm-3">
									<label >Select Academic Year<?=$astrik?></label>
                                   </div>
								<div class="col-sm-3">
								<select id="academic" name="academic" class="form-control" >
                                            <option value="">Select Academic Year</option>
                                           <?php //echo "state".$state;exit();
										if(!empty($academic_details)){
											foreach($academic_details as $academic){
												$arr=explode("-",$academic['academic_year']);
												$ac_year=$arr[0];
												
												?>
												<option value="<?=$ac_year?>"><?=$academic['academic_year']?></option> 
												<?php
												
												
											}
										}
									  ?>
                                        </select>   
										<span style="color:red;"><?php echo form_error('academic');?></span>										
                                    </div>
									                                  
                                   
                                    <div class="col-sm-3">
									<label >Select Current Year.:<?=$astrik?></label>
									</div>
									<div class="col-sm-3">
									<select id="current_year" name="current_year" class="form-control" >
                                            <option value="">Select Current Year</option>
                                          <?php 
										 
										   for($i=1;$i<=5;$i++)
										   {
											   if($i==$student_details['current_year']){ $sel ='selected';}else{$sel='';}
											   echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
											  
										   }
										   ?>
                                        </select> 
									<span style="color:red;" ><?php echo form_error('current_year');?></span>
									</div>
								</div>
								<div class="form-group">
                                    <div class="col-sm-3">
									<label >Enter Enrollment No.:<?=$astrik?></label>
									</div>
								<div class="col-sm-3">
								<input type="text" id="enrollment_no" name="enrollment_no" class="form-control" placeholder="enrollment_no" onchange="check_student_exists()" value="<?=$student_details['enrollment_no']?>"/>
									<span style="color:red;" id="err_hcode"><?php echo form_error('enrollment_no');?></span>
									</div>
								</div>
                                <div class="form-group">
                                    
                                    <div class="col-sm-3">
									<label >Enter Name:<?=$astrik?></label>
									</div>
								<div class="col-sm-3">
								<input type="text" id="fname" name="fname" class="form-control" value="<?=$student_details['first_name']?>" placeholder="First Name"  />                                    
                                    <span style="color:red;"><?php echo form_error('fname');?></span>
									</div>
									
                                    <div class="col-sm-3">
									
									<input type="text" id="mname" name="mname" value="<?=$student_details['middle_name']?>" placeholder="Middle Name" class="form-control"  /><span style="color:red;"><?php echo form_error('mname');?></span>
									</div>
									<div class="col-sm-3">
									
									<input type="text" id="lname" value="<?=$student_details['last_name']?>" name="lname" class="form-control" placeholder="Last Name" />                                    
                                   <span style="color:red;"><?php echo form_error('lname');?></span>
								   </div>
                                </div>
							<div class="form-group">
								<div class="col-sm-3">
								<label >Enter Gender <?=$astrik?></label>  <br/>  
								</div>
									<div class="col-sm-3">
								<label><input type="radio" value="M" id="genderm" name="gender">&nbsp;&nbsp;Male</label>
								<label><input type="radio" value="F" id="genderf" name="gender">&nbsp;&nbsp;Female</label>
								<span style="color:red;" ><?php echo form_error('gender');?></span>
								</div> 
								<div class="col-sm-3">
								<label >Enter Mobile Number: <?=$astrik?></label>
								</div>
									<div class="col-sm-3">
								<input type="text" id="mobile" name="mobile" class="form-control" value="<?=$student_details['mobile']?>" placeholder="Mobile" />
								<span style="color:red;"><?php echo form_error('mobile');?></span></div>  
							</div>												
							
							<div class="form-group">
                                
                                <div class="col-sm-3">
								<label >Select State: <?=$astrik?></label>
                                </div>
								<div class="col-sm-3">
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
								 <div class="col-sm-3">
								
                                  <select class="form-control" name="hdistrict_id" id="hdistrict_id" required>
                                      <option value="">select District</option>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hdistrict_id');?></span>
                                </div>
								<div class="col-sm-3">
								
                                   <select class="form-control" name="hcity" id="hcity" required>
                                      <option value="">select City</option>
                                  </select>
								  <span style="color:red;"><?php echo form_error('hcity');?></span>
                                </div>
								
							</div>
							
							<div class="form-group">
								<div class="col-sm-3">
								<label >Enter Address:<?=$astrik?></label>					
								</div>
									<div class="col-sm-3">
								<textarea id="address" class="form-control" NAME="address" placeholder="Address" > <?=$student_details['Address']?></textarea><span style="color:red;"><?php echo form_error('address');?></span>
								</div>										
								
								<div class="col-sm-3">
									<label >Enter Pincode<?=$astrik?></label>
							</div>
									<div class="col-sm-3">
									<input type="text" id="pincode" name="pincode" class="form-control" placeholder="Pincode" value="<?=$student_details['pincode']?>"  />
									<span style="color:red;"><?php echo form_error('pincode');?></span>
								</div>
							</div>
							
							<div class="form-group">
															
								
															
								<div class="col-sm-3">
									<label >Enter Parent Mobile 1:</label>
								</div>
									<div class="col-sm-3">
								<input type="text" id="pmobile" name="pmobile" value="<?=$student_details['parent_mobile1']?>" class="form-control" placeholder="parent mobile"  />
									<span style="color:red;"><?php echo form_error('pmobile');?></span>
								</div>
								
								<div class="col-sm-3">
								<label >Enter Parent Mobile 2:</label>
							</div>
									<div class="col-sm-3">	
							<input type="text" id="pmobile2" name="pmobile2" value="<?=$student_details['parent_mobile2']?>" class="form-control" placeholder="Another Mobile" />
								<span style="color:red;"><?php echo form_error('pmobile2');?></span></div>
								
							</div>
							
							<div class="form-group">
																
								<div class="col-sm-3">
								<label >Enter Email: <?=$astrik?></label>
								</div>
									<div class="col-sm-3">
								<input type="email" id="email" name="email" class="form-control" value="<?=$student_details['email']?>" placeholder="Email"  /><span style="color:red;"><?php echo form_error('email');?></span>
								</div>
								
								<div class="col-sm-3">
								<label>Select Is Provisional: <?=$astrik?></label>
                                </div>
									<div class="col-sm-3">
							<select class="form-control" name="provisional" id="provisional" required>
                                      <option value="">select IS provisional</option>
									  <option value="Y">Yes</option>
									  <option value="N">No</option>
                                  </select>
								  <span style="color:red;"><?php echo form_error('provisional');?></span>
                                </div>
							</div>
								
							 <div class="form-group">
                                    
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/view_student/'.$this->uri->segment(4).'/'.$student_details['campus_name'])?>'">Cancel</button></div>
									<span class="col-sm-8" style="color:red;" id="err_msg"></span>
                                    
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>


<script>
var err_status=0;

function validate_edit_student_form(events)
{
	if(err_status==1)
	{ $('#enrollment_no').focus();return false;}
	else
	{ return true;}
}

$(document).ready(function(){
	    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
	
	$("#state").val('<?=$student_details['state']?>');
	$("#district").val('<?=$student_details['district']?>');
	$("#city").val('<?=$student_details['taluka']?>');
	
	var provisional='<?=$student_details['is_provisional']?>';
	$('#provisional option').each(function()
	{              
		 if($(this).val()== provisional)
		{
		$(this).attr('selected','selected');
		}
	});
	
	var campus='<?=$student_details['campus_name']?>';
	$('#campus option').each(function()
	 {              
		 if($(this).val()== campus)
		{
		$(this).attr('selected','selected');
		}
	});
	
	var gender='<?=$student_details['gender']?>';
	if(gender=='Male')
		$("#genderm").prop("checked", true);
	else
		$("#genderf").prop("checked", true);
	
	var instute_name='<?=$student_details['instute_name']?>';
	var program_id='<?=$student_details['program_id']?>';
	
	$('#college_name option').each(function()
	 {              
		 if($(this).val()== instute_name)
		{
			$(this).attr('selected','selected');
			$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Hostel/getprogrambycollegename',
						data: 'college=' + instute_name,
						success: function (html) {
							//alert(html);
							$('#program').html(html);
							$('#program option').each(function()
							 {              
								 if($(this).val()== program_id)
								{
									$(this).attr('selected','selected');
								}
							 });
							
							
							
						}
			});
		}
	});
	
	var admission='<?=$student_details['admission_session']?>';
	$('#admission option').each(function()
	 {              
		 if($(this).val()== admission)
		{
		$(this).attr('selected','selected');
		}
	});
	
	var academic='<?=$student_details['academic_year']?>';
	$('#academic option').each(function()
	 {              
		 if($(this).val()== academic)
		{
		$(this).attr('selected','selected');
		//$('#college_name').trigger("change");
		}
	});
	
	
	var hstate_id='<?=$student_details['state_id']?>';
	var district_id='<?=$student_details['district_id']?>';
	//alert(district_id);
	var taluka_id='<?=$student_details['taluka_id']?>';

	$('#hstate_id option').each(function()
	{              
		 if($(this).val()== hstate_id)
		{
			$(this).attr('selected','selected');
			$("#state").val($("#hstate_id option:selected").text());
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + hstate_id,
				success: function (html) {
					if(html !='')
					{					
						$('#hdistrict_id').html(html);
						$('#hdistrict_id option').each(function()
						 {              
							 if($(this).val()== district_id)
							{
								//alert(district_id);
								$(this).attr('selected','selected');
								$("#district").val($("#hdistrict_id option:selected").text());
								$.ajax({
									type: 'POST',
									url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
									data: { state_id: hstate_id, district_id : district_id},
									success: function (html) {
										//alert(html);
										if(html !=''){
										$('#hcity').html(html);
										}else{
										  $('#hcity').html('<option value="">First Select District</option>');  
										}
										$('#hcity option').each(function()
										 {              
											 if($(this).val()== taluka_id)
											{
												//alert(district_id);
												$(this).attr('selected','selected');
												$("#city").val($("#hcity option:selected").text());
											}
										 });
									}
								});
							}
						 });
					}
					else
					{
						 $('#hdistrict_id').html('<option value="">First Select State</option>');  
					}			
				}
			});
				
			
		} 
		
	});  
	
  	
	// City by State
	$('#college_name').on('change', function () {
		var	college = $(this).val();
		//alert(college);
		if (college) {
			$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Hostel/getprogrambycollegename',
						data: 'college=' + college,
						success: function (html) {
							//alert(html);
							$('#program').html(html);
						}
			});
		} else {
			$('#program').html('<option value="">Select Instute first</option>');
		}
	});
	
	var id='<?=$student_details['student_id']?>';
	$('#enrollment_no').on('change', function () {
		var	enrollment_no = $(this).val();
		//check_student_exists();
		//alert(college);
		if (enrollment_no) {
			$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Hostel/check_student_exists',
						
						data: {enroll:enrollment_no,id:id},
						success: function (html) {
							console.log(html);
							if(html>0)
							{
								$('#err_msg').html('enrollment_no is already exists');err_status=1;
							}
							else
								err_status=0;
						}
			});
		}
	});
	
	
			$('#campus').on('change', function () {
		var	campus = $(this).val();
		//check_student_exists();
		//alert(college);
		if (campus) {
			$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Hostel/get_institutes_by_campus',
						data: 'campus=' + campus,
						success: function (html) {
							//alert(html);
							$('#college_name').html(html);
						}
			});
		} else {
			$('#college_name').html('<option value="">Select Institute </option>');
		}
	});
	
    // City by State
	$('#hstate_id').on('change', function () {
		 stateID = $(this).val();
			var state_ID = $("#hstate_id").val();
			$("#state").val($("#hstate_id option:selected").text());
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
		$("#district").val($("#hdistrict_id option:selected").text());
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
	
	 $("#hcity").change(function(){
      $("#city").val($("#hcity option:selected").text());
    });
	
	});	

</script>
