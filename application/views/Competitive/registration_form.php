<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

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
                
				/* sfname:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Student First Name'
                      },
                      required: 
                      {
                       message: 'Please Enter Student First Name'
                      }
                     
                    }
                },smname:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Student Middle Name'
                      },
                      required: 
                      {
                       message: 'Please Enter Student Middle Name'
                      }
                     
                    }
                }, */slname:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Student Last Name'
                      },
                      required: 
                      {
                       message: 'Please Enter Student Last Name'
                      }
                     
                    }
                },
				ref:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Reference Of'
                      },
                      required: 
                      {
                       message: 'Please Enter Reference Of'
                      }
                     
                    }
                },
				purpose:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Purpose'
                      },
                      required: 
                      {
                       message: 'Please Enter Purpose'
                      }
                     
                    }
                },
               mobile:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Mobile'
                      },
                      required: 
                      {
                       message: 'Please Enter Mobile'
                      }
                     
                    }
                },pmobile:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Parent Mobile'
                      },
                      required: 
                      {
                       message: 'Please Enter Parent Mobile'
                      }
                     
                    }
                },
				/* email:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Email'
                      },
                      required: 
                      {
                       message: 'Please Enter Email'
                      }
                     
                    }
                }, */
				gender:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Gender'
                      },
                      required: 
                      {
                       message: 'Please select Gender'
                      }
                     
                    }
                },occupation:
				{
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select father occupation'
                      },
                      required: 
                      {
                       message: 'Please select father occupation'
                      }
                     
                    }
                },moccupation:
				{
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select mother occupation'
                      },
                      required: 
                      {
                       message: 'Please select mother occupation'
                      }
                     
                    }
                },
				stype:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Student type'
                      },
                      required: 
                      {
                       message: 'Please select Student type'
                      }
                     
                    }
                },
				 pindate:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Propose In Date'
                      },
                      required: 
                      {
                       message: 'Please select Propose In Date'
                      }
                     
                    }
                },
				poutdate:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Propose Out Date'
                      },
                      required: 
                      {
                       message: 'Please select Propose Out Date'
                      }
                     
                    }
                },
				laddress:
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
                        message: 'Address should be 2-50 characters.'
                        }
                    }
                },
				lpincode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Pincode should not be empty'
                      },
                      stringLength: 
                        {
                        max: 6,
                        min: 6,
                        message: ' Pincode should be 6 digits.'
                        }
                    }
                },
				lstate_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select State'
                      },
                      required: 
                      {
                       message: 'Please Select State'
                      }
                     
                    }
                },
				ldistrict_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select District'
                      },
                      required: 
                      {
                       message: 'Please Select District'
                      }
                     
                    }
                },
				lcity:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select City'
                      },
                      required: 
                      {
                       message: 'Please Select City'
                      }
                     
                    }
                },paddress:
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
                        message: 'Address should be 2-50 characters.'
                        }
                    }
                },
				ppincode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Pincode should not be empty'
                      },
                      stringLength: 
                        {
                        max: 6,
                        min: 6,
                        message: ' Pincode should be 6 digits.'
                        }
                    }
                },
				pstate_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select State'
                      },
                      required: 
                      {
                       message: 'Please Select State'
                      }
                     
                    }
                },
				pdistrict_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select District'
                      },
                      required: 
                      {
                       message: 'Please Select District'
                      }
                     
                    }
                },
				pcity:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select City'
                      },
                      required: 
                      {
                       message: 'Please Select City'
                      }
                     
                    }
                },
				nop:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select No.Of Visitors'
                      },
                      required: 
                      {
                       message: 'Please Select No.Of Visitors'
                      }
                     
                    }
                },
				ischrg:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select is chargable?'
                      },
                      required: 
                      {
                       message: 'Please Select is chargable?'
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
			node.val(node.val().replace(/[^a-zA-Z0-9 ]/g,'') ); }
		);
		
		$('#slname').keyup(function() {
		$(this).val($(this).val().toUpperCase());
	});
	
	$('#instute').keyup(function() {
		$(this).val($(this).val().toUpperCase());
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Competitive Exam</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm">
			<i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Admission Form</h1>
        </div>
		<div class="row ">
		<div class="col-sm-12">
			<div class="panel">
				
				<div class="panel-body">  
				<h4 id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
				<h4 id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
		<!--<div class="row " >
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter The Details</span>
                    </div>-->
					<form id="form" name="form" action="<?=base_url($currentModule.'/form_submit')?>" method="POST" onsubmit="return validate_form(event)" >
                    <div class="panel-body">
                        <div class="table-info">  
							
							<div class="form-group">
								<div class="col-sm-3">
								<label >Form No.:<?=$astrik?></label>
									</div>
									<div class="col-sm-3">
									<input type="text" id="formno" name="formno" placeholder="Form Number" class="form-control" required />                                     
                                   <span style="color:red;"><?php echo form_error('formno');?></span>
									</div>
								
							<div class="col-sm-3">
							<label >Student Type:<?=$astrik?></label>
								</div>
								<div class="col-sm-3">
								<select id="stype" name="stype" class="form-control" >
											  <option value="">Select Student Type</option>
											  <option value="I">In House Student</option>
											  <option value="O">Other</option>
                                </select>                                   
							   <span style="color:red;"><?php echo form_error('stype');?></span>
							   
								</div>
							</div>
							<div id="institute" style="display:none;">
								<div class="form-group">
								<div class="col-sm-3">
								<label >Institute Name:<?=$astrik?></label>
									</div>
									<div class="col-sm-9">
									<input type="text" id="instute" name="instute" value="<?=$student_list['instute']?>" placeholder="Instute Name" class="alphaonly form-control" required />                                  
								   <span style="color:red;"><?php echo form_error('instute');?></span>
								</div>
								</div>	
							</div>
							<div id="inhouse" style="display:none;">
							<div class="form-group">
							<div class="col-sm-3">
							<label >Organisation:<?=$astrik?></label>
								</div>
								<div class="col-sm-3">
								<select id="org" name="org" class="form-control" required >
											  <option value="">Select Organisation</option>
											  <option value="SU">SU</option>
											  <option value="SITRC">SITRC</option>
											  <option value="SIEM">SIEM</option>
											  <option value="SIPS">SIPS</option>
											  <option value="SIP">SIP</option>
											  <option value="SP">SP</option>
											  <option value="SNJCOE">SNJCOE</option>
											  <option value="SF">SRP</option>
                                </select>                                   
							   <span style="color:red;"><?php echo form_error('org');?></span>
								</div>
								
							<label class="col-sm-3">PRN Number</label>
                              <div class="col-sm-3">
								<input type="text" id="prn" name="prn" class="numonly form-control"  placeholder="PRN Number" onchange="check_visitor_exists()" />
                              </div>
							  </div>
							  <!--<div class="form-group">
							<label class="col-sm-3">Select School:</label>
								<div class="col-sm-3">
								  <select id="school" name="school" onchange="get_streams()" class="form-control" required>
								  <option value="">Select School</option>
								  <?php 
										/* if(!empty($school_details)){
											foreach($school_details as $coursename){
												?>
											  <option value="<?=$coursename['school_id']?>"><?=$coursename['school_name']?></option>  
											<?php 
												
											}
										} */
								  ?>
								  </select>
								<input type="hidden" name="school_name" id="school_name">  
								</div>
								
								<label class="col-sm-3">Select Stream:</label>
								<div class="col-sm-3">
								  <select id="stream" name="stream" class="form-control" required>
								   <option value="">Select Stream</option>
								  </select>
								  <input type="hidden" name="stream_name" id="stream_name"> 
								  </div>
							</div>-->
							</div>
							
							<div class="form-group">
                              <label class="col-sm-3">Student Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <input data-bv-field="slname" id="slname" name="slname" class="form-control" placeholder="Student Name" type="text">
                                </div>
                            <label class="col-sm-3">Date of Admission <?= $astrik ?></label>
                              <div class="col-sm-3 date" id="dob-datepicker1">
                                  <div class="input-group">
                                <input type="text" id="ad_date" name="ad_date" class="form-control" placeholder="Admission Date" required />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div></div>
                            </div>
							
							<div class="form-group">
								<div class="col-sm-3">
								<label >Mobile (Student):<?=$astrik?></label>
									</div>
									<div class="col-sm-3">
									<input type="text" maxlength="10" id="mobile" name="mobile" placeholder="Student Mobile" class="form-control numbersOnly"  />                                     
                                   <span style="color:red;"><?php echo form_error('mobile');?></span>
									</div>
								
							<div class="col-sm-3">
							<label >Mobile (Parent):<?=$astrik?></label>
								</div>
								<div class="col-sm-3">
								<input type="text" maxlength="10"  id="pmobile" name="pmobile" placeholder="Parent Mobile" class="form-control numbersOnly"  />                                     
							   <span style="color:red;"><?php echo form_error('pmobile');?></span>
								</div>
							</div>	
							
							<div class="form-group">
								<div class="col-sm-3">
									<label>Email:</label>
									
								   </div>
								   <div class="col-sm-3">
									
									<input type="email"  id="email" name="email" placeholder="Email" class="form-control"  />                                  
                                  
								   </div>
								<label class="col-sm-3">Date of Birth <?= $astrik ?></label>
                              <div class="col-sm-3 date" id="dob-datepicker">
                                  <div class="input-group">
                                <input type="text" id="dob" name="dob" class="form-control"   placeholder="Date of Birth" required />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div></div>
							</div>
							
							<div class="form-group">
							<div class="col-sm-3">
								<label>Gender:<?=$astrik?></label>
								
								</div>
								
								<div class="col-sm-3">
								<select id="gender" name="gender" class="form-control" >
											  <option value="">Select Gender</option>
											  <option value="M">MALE</option>
											  <option value="F">FEMALE</option>
											  <option value="T">TRANSGENDER</option>
											  
                                    </select>                                  
								<span style="color:red;"><?php echo form_error('gender');?></span>
								</div>
							<label class="col-sm-3">Category <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
							   <select id="category" name="category" class="form-control" required="">
                                  <option value="">Select</option>
                                  <?php //echo "state".$state;exit();
                                        if(!empty($caste)){
                                            foreach($caste as $category){
                                                ?>
                                              <option value="<?=$category['caste_id']?>"><?=$category['caste_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>              
								</select>
                              </div>
							</div>
			<div class="col-sm-6 pull-left" style="padding-left:0px;">
               <div class="panel">
             	<div class="panel-heading">
                    <span class="panel-title"><b>Local Address</b></span>
                </div>	
				</div>
			</div>
			<div class="col-sm-6 pull-right" style="padding-left:0px;">
               <div class="panel">
             	<div class="panel-heading">
                    <span class="panel-title"><b>Permanent Address</b></span>
                </div>	
				</div>
			</div>
			
			<div class="form-group">
				<label  class="col-sm-3">Address: <?=$astrik?></label>
				<div class="col-sm-3">
				  <textarea id="laddress" class="form-control" NAME="laddress" required></textarea>
				  
				</div>
				<label  class="col-sm-3">Address: <?=$astrik?></label>
				<div class="col-sm-3">
				  <textarea id="paddress" class="form-control" NAME="paddress" style="margin: 0px; width: 175px; height: 50px;" required></textarea>
				</div>
			  </div>

			  <div class="form-group">
				<label  class="col-sm-3">State: <?=$astrik?></label>
				<div class="col-sm-3">
				  <select class="form-control" name="lstate_id" id="lstate_id" required>
					  <option value="">select State</option>
					  <?php
						if(!empty($state)){
							foreach($state as $stat){
								?>
							  <option value="<?=$stat['state_id']?>"><?=$stat['state_name']?></option>  
							<?php 
								
							}
						}
					  ?>
				  </select>
				  
				  <input type="hidden" id="state_name" name="state_name" />
				  
				</div>
				<label  class="col-sm-3">State: <?=$astrik?></label>
				<div class="col-sm-3">
				  <select class="form-control" name="pstate_id" id="pstate_id" required>
					  <option value="">select State</option>
					  <?php
						if(!empty($state)){
							foreach($state as $stat){
								?>
							  <option value="<?=$stat['state_id']?>"><?=$stat['state_name']?></option>  
							<?php 
								
							}
						}
					  ?>
				  </select>
				  <input type="hidden" id="pstate_name" name="pstate_name" />
				  
				</div>
			  </div>
			  <div class="form-group">
				<label  class="col-sm-3">District: <?=$astrik?></label>
				<div class="col-sm-3">
				  <select class="form-control" name="ldistrict_id" id="ldistrict_id" required>
					  <option value="">select District</option>
				  </select>
				  <input type="hidden" id="district_name" name="district_name" />
				  
				</div>
				<label  class="col-sm-3">District: <?=$astrik?></label>
				<div class="col-sm-3">
				  <select class="form-control" name="pdistrict_id" id="pdistrict_id" required>
					  <option value="">select District</option>
				  </select>
				  <input type="hidden" id="pdistrict_name" name="pdistrict_name" />
				 
				</div>
			  </div>
			  <div class="form-group">
				<label  class="col-sm-3">City: <?=$astrik?></label>
				<div class="col-sm-3">
				   <select class="form-control" name="lcity" id="lcity" required>
					  <option value="">select City</option>
				  </select>
				  <input type="hidden" id="city_name" name="city_name" />
				  
				</div>
				<label  class="col-sm-3">City: <?=$astrik?></label>
				<div class="col-sm-3">
				   <select class="form-control" name="pcity" id="pcity" required>
					  <option value="">select City</option>
				  </select>
				   <input type="hidden" id="pcity_name" name="pcity_name" />
				</div>
			  </div>
			  <div class="form-group">
				<label  class="col-sm-3">Pin Code: <?=$astrik?></label>
				<div class="col-sm-3">
				  <INPUT TYPE="TEXT" class="form-control numbersOnly" id="lpincode" maxlength="6" NAME="lpincode" required>
				</div>
				 <label  class="col-sm-3">Pin Code: <?=$astrik?></label>
				<div class="col-sm-3">
				  <INPUT TYPE="TEXT" class="form-control numbersOnly" id="ppincode" maxlength="6" NAME="ppincode" required>
				</div>
			  </div>
				
               <div class="form-group">              
                          <label style="text-align:left">
                            <input name="same" id="same" value="N" onclick="copyBilling (this.form) " type="checkbox">
                            Permanent Address is Same as Local Address</label>
               </div>        
                     <!-- </div>-->
								
							<div class="form-group">
								<div class="col-sm-3">
								<label >Father Occupation:</label>
									</div>
									<div class="col-sm-3">
									<select name="occupation" class="form-control">
									<option value="">Select</option>
									<option value="Service">Service</option>
									<option value="Business">Business</option>
									<option value="Farmer">Farmer</option>
									<option value="Retired">Retired</option>
									<option value="Other">Other</option>
								  </select> <span style="color:red;"><?php echo form_error('occupation');?></span>
									  
									</div>
									
									
									<label class="col-sm-3">Mother Occupation:</label>
								
								<div class="col-sm-3">
								
								  <select name="moccupation" class="form-control">
									<option value="">Select</option>
									<option value="HouseWife">HouseWife</option>
									<option value="Service">Service</option>
									<option value="Business">Business</option>
									<option value="Farmer">Farmer</option>
									<option value="Retired">Retired</option>
									<option value="Other">Other</option>
								  </select> <span style="color:red;"><?php echo form_error('moccupation');?></span>
								</div>
								</div>
								
							<div class="form-group">
								
								<div class="col-sm-3">
								<label >Highest Qualifcation:<?=$astrik?></label>
								</div>
								<div class="col-sm-3">
								<select name="qualifcation" onchange="qualification(this.id)" id="qualifcation" class="squal form-control" required>
                                        <option value="">Select</option>
                                        <option value="SSC">SSC</option>
                                        <option value="HSC">HSC</option>
                                        <option value="Graduation">Graduation</option>
                                        <option value="Post Graduation">Post Graduation's</option>
                                        <option value="Diploma">Diploma</option>
                                      </select>
								<span style="color:red;"><?php echo form_error('qualifcation');?></span>
								</div>
								<div class="col-sm-3">
								<label >Specify Stream:</label>
								</div>
								<div class="col-sm-3">
								<select id="hq_stream" name="hq_stream" class="form-control" required>
                                        <option value="">Select Stream</option>
                                    
                                      </select>
						
								<span style="color:red;"><?php echo form_error('hq_stream');?></span>
								</div>
								
								
							</div>
							
							<div class="form-group">
							<div class="col-sm-3">
									<label>Aware About UPSC:</label>
								   </div>
								<div class="col-sm-3">
								<select name="upsc" id="upsc" class="form-control"  required>
                                        <option value="">Select Aware About UPSC</option>
                                        <option value="Y">Yes</option>
										<option value="N">No</option>
                                      </select>
								<span style="color:red;"><?php echo form_error('upsc');?></span>
								</div>
							<div class="col-sm-3">
								<label >Entrance Type:<?=$astrik?></label>
								</div>
								<div class="col-sm-3">
								<select name="etype" id="etype" class="form-control"  required>
                                        <option value="">Select Entrance Type</option>
                                        <option value="UPSC">UPSC</option>
                                        <option value="MPSC">MPSC</option>
                                        <option value="BANK PO">BANK PO</option>
                                        <option value="CDSE">CDSE</option>
                                        <option value="OTHER">OTHER</option>
										
                                      </select>
								<span style="color:red;"><?php echo form_error('etype');?></span>
								</div>
								
							</div>
							
							<div id="entrance" style="display:none;">
							<div class="form-group">
								<div class="col-sm-3">
								<label >Specify Entrance Type:<?=$astrik?></label>
								</div>
								<div class="col-sm-3">
								<input type="text" id="e_other" name="e_other" placeholder="Specify Other Entrance" class="form-control" required />
								<span style="color:red;"><?php echo form_error('e_other');?></span>
								</div>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-3">How do you come to know about SU:</label>
								<div class="col-sm-3">
								<?php 
											if(!empty($publicmedia)){
												$j=1;
												foreach($publicmedia as $val){
													?>
								<input onclick="media_values()" id="media_<?=$val['pm_id']?>" class="chk" type="checkbox" value="<?=$val['pm_name']?>" name="source[]"><?=$val['pm_name']?></br><?php
													$j++;
												}
											}
									  ?>
									  
								<input type="hidden" name="media" id="media"/>					  
					
								</div>
								
								
								<div class="col-sm-3">
								<label >Hobbies:</label>
								</div>
								<div class="col-sm-3">
								<textarea class="form-control" id="hobbies" name="hobbies" ></textarea>                                    
                                 
								</div>
							</div>
							<div class="form-group">
									<div class="col-sm-3">
									<label>Academic Achievement:</label>
								   </div>
								   <div class="col-sm-3">
									<textarea class="form-control" id="Achievement" name="Achievement" ></textarea>									
									</div>
									<div class="col-sm-3">
									<label>Co-Curricular Achievement:</label>
								   </div>
								   <div class="col-sm-3">
									<textarea class="form-control" id="curri" name="curri" ></textarea>                                    
                                   
									
									</div>
							</div>
							 
							 <div class="form-group">
								<div class="col-sm-3">
								<label >Enquiry For Class:<?=$astrik?></label>
								</div>
								<div class="col-sm-3">
								 <?php 
											if(!empty($module_details)){
												$j=1;
												foreach($module_details as $val){
													?>
								<input onclick="fetch_fees()" id="module_<?=$val['com_fees_id']?>" class="module" type="checkbox" value="<?=$val['proposed_fees']?>" name="module[]"><?=$val['module_no']?></br><?php
													$j++;
												}
											}
									  ?>
								<input type="hidden" name="module_val" id="module_val"/>
								<span style="color:red;"><?php echo form_error('module');?></span>
								</div>
								<div class="col-sm-3">
									<label>Applicable fees:</label>
								   </div>
								   <div class="col-sm-3">
									<input type="text" id="fee" name="fee" placeholder="Applicable fees " class="form-control" readonly />
								</div>
							 </div>
							 <span style="color:red;padding-left:0px;" id="err_msg"></span>
                          <div class="form-group">
                                   
							<div class="col-sm-2">
								<button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
							</div>                                    
							<div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/student_list')?>'">Cancel</button></div>
							<div class="col-sm-8">
							<span style="color:red;padding-left:0px;" id="err_msg1"></span>
							</div> 
						</div>
                           
							
                        </div>
                    </div>
               
				</form>		
                   <!-- </div>
                </div>
            </div> -->
 </div>
            </div>    
        </div>
    </div>
			
        </div>
    </div>



<script>
var status=0;
var error_status=0;
var comtoknow_values="";
var module_values="";

function copyBilling (f) {
    //alert('hi');
    var s, i = 0;
    if(f.same.checked == true) {
		 $('#same').val('Y');
    // fetch district
        var stateID = $("#lstate_id").val();
        var district_id = $("#ldistrict_id").val();
        var lcity = $("#lcity").val();
		
		if (stateID) {
			$("#pstate_name").val($("#lstate_id option:selected").text());
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#pdistrict_id').html(html);
					$("#pdistrict_id option[value='" + district_id + "']").attr("selected", "selected");
					$("#pdistrict_name").val($("#pdistrict_id option:selected").text());
				}
			});
		} else {
			$('#pdistrict_id').html('<option value="">Select state first</option>');
		}
	// fetch district
		if (district_id) {
			
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: stateID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#pcity').html(html);
					$("#pcity option[value='" + lcity + "']").attr("selected", "selected");
					$("#pcity_name").val($("#pcity option:selected").text());
					}else{
					  $('#pcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#pcity').html('<option value="">Select district first</option>');
		}
		
    

    while (s = ['address', 'state_id', 'district_id', 'city', 'pincode'][i++]) {f.elements['p' + s].value = f.elements['l' + s].value};
    }
    if(f.same.checked == false) {
		 $('#same').val('N');
    // alert(false);
    $('#pdistrict_id').html('<option value="">Select state first</option>');
    $('#pcity').html('<option value="">Select district first</option>');
    while (s = ['address', 'state_id', 'district_id', 'city', 'pincode'][i++]) {f.elements['p' + s].value ="";};
    }
    
}
function validate_form(events)
{
	fetch_fees();
	if(status==1)
	{
		$('#err_msg').html('Please Select Enquiry For Class');
		$(':input[type="submit"]').prop('disabled', false);
		return false;
	}
}

function media_values()
{
	var customArraychecked=[];
	//$('input:checkbox[class=chk]:checked').length;
   $('input:checkbox[class=chk]:checked').each(function(i) {
		   // alert(this.value);
		   customArraychecked.push(this.value);
	});
	comtoknow_values=customArraychecked.join(",");
	$('#media').val(comtoknow_values);
}

function fetch_fees()
{
	status=0;
	var customArraychecked=[];
	var n=0;
	//$('input:checkbox[class=chk]:checked').length;
   $('input:checkbox[class=module]:checked').each(function(i) {
		   // alert(this.value);
		   customArraychecked.push(this.id);
		   n++;
	});
	module_values=customArraychecked.join(",");
	$('#module_val').val(module_values);
	
	var arr=module_values.split(",");
	var fee=0;

	if(n==3)
	{
		$('#err_msg').html('');
		fee=(parseInt($('#module_1').val())+parseInt($('#module_2').val())+parseInt($('#module_3').val()))-4000;
	}
	else if(n==2)
	{
		$('#err_msg').html('');
		if(module_values==='module_1,module_2')
		fee=(parseInt($('#module_1').val())+parseInt($('#module_2').val()))-1000;
		else if(module_values==='module_1,module_3')
			fee=(parseInt($('#module_1').val())+parseInt($('#module_3').val()))-1000;
		else if(module_values==='module_2,module_3')
			fee=(parseInt($('#module_2').val())+parseInt($('#module_3').val()))-2000;
	}
	else if(n==1)
	{
		$('#err_msg').html('');
		fee=($('#'+module_values).val());
	}
	else
		status=1;
	
	$('#fee').val(fee);	
	//alert('module_values=='+module_values);
	
	/* var module=$('#module').val();
	//var org=$('#org').val();
	var g="",s="",d="",c="";
	var html='';
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Competitive_exam/fetch_fees',
			data: {module:module},
			success: function (html) {
				//alert(html);
				//$('#err_msg1').html('res======'+html);
				if(html !== "{\"fee_details\":null}")
				{
					//$('#err_msg1').html('');
					var array=JSON.parse(html);
					len=array.length;
					//alert(array.student_details.visitor_name);
					$('#fee').val(array.fee_details.proposed_fees);
				}
				else
					$('#fee').val(0);
			}
	}); */
}

function get_streams()
{
	var school=$('#school').val();
	$("#school_name").val($("#school option:selected").text());
	//var org=$('#org').val();
	var g="",s="",d="",c="";
	var html='';
	var content='<option value="">Select Stream</option>';
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Competitive_exam/get_stream_list_in_school',
			data: {school:school},
			success: function (html) {
				//alert(html);
				//$('#err_msg1').html('res======'+html);
				if(html !== "{\"stream_details\":null}")
				{
					//$('#err_msg1').html('');
					var array=JSON.parse(html);
					var len=array.stream_details.length;
					var j=1;
					
					for(i=0;i<len;i++)
					{
						content+='<option value="'+array.stream_details[i].stream_id+'">'+array.stream_details[i].stream_short_name+'</option>';
					}
					//alert(content);
					$('#stream').html(content);
				}
			}
	});
}

function qualification(id){
      standrd = $("#"+id).val();
	//alert('helllooo');
     // res = id.split("_");
      //var n= res[1];
      var streamId = '#hq_stream';
      var sub = $(streamId).val();
       if(standrd=='SSC'){
    	  $(streamId).html("<option value='NA'>NA</option>");
    	  $(streamId+" option[value='NA']").attr("selected", "selected");
    	  $("tr.10th").show();
    	//$('.10th').show();
      }else if(standrd=='HSC'){
    	  $(streamId).html("<option value=''>-select-</option><option value='Arts'>Arts</option><option value='Commerce'>Commerce</option><option value='Science'>Science</option>");
    	  $("tr.12th").show();
    	  
      }else if(standrd=='Graduation'){		
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Competitive_exam/fetch_qualification_streams',
			data: {level:'UG'},
			success: function (data) {
				//alert(data);
				$(streamId).html(data);
			}
		});
				
      }else if(standrd=='Diploma'){
    	 $.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Competitive_exam/fetch_qualification_streams',
			data: {level:'DIP'},
			success: function (data) {
				$(streamId).html(data);
			}
		});
      }
      else if(standrd=='Post Graduation'){
    	 $.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Competitive_exam/fetch_qualification_streams',
			data: {level:'PG'},
			success: function (data) {
				$(streamId).html(data);
			}
		});
    	 
      } 
  }

function check_visitor_exists()
{
	var prn=$('#prn').val();
	var org=$('#org').val();
	var g="",s="",d="",c="";
	var html='';
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Competitive_exam/check_prn_exists',
			data: {prn:prn,org:org},
			success: function (html) {
				//alert(html);
				//$('#err_msg1').html('res======'+html);
				if(html !== "{\"student_details\":null}")
				{
					//$('#err_msg1').html('');
					var array=JSON.parse(html);
					len=array.length;
					//alert(array.student_details.visitor_name);
					$('#sfname').val(array.student_details.first_name);
					$('#smname').val(array.student_details.middle_name);
					$('#slname').val(array.student_details.last_name);
					$('#mobile').val(array.student_details.mobile);
					$('#email').val(array.student_details.email);
					$('#address').html(array.student_details.address);
					$('#pincode').val(array.student_details.pincode);
					$('#pmobile').val(array.student_details.parent_mobile1);
					s=array.student_details.state;
					d=array.student_details.district;
					c=array.student_details.city;
					g=array.student_details.gender;
					p=array.student_details.id_proof;
					$('#ref').focus();
					$('#hstate_id option').each(function()
					{              
						 if($(this).val()== s)
						{
							$(this).attr('selected','selected');
							var state_name=$("#hstate_id option:selected").text();
							$('#state_name').val(state_name);
							$.ajax({
								type: 'POST',
								url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
								data: 'state_id=' + s,
								success: function (html) {
									if(html !='')
									{					
										$('#hdistrict_id').html(html);
										$('#hdistrict_id option').each(function()
										 {              
											 if($(this).val()== d)
											{
												//alert(district_id);
												$(this).attr('selected','selected');
												var district_name=$("#hdistrict_id option:selected").text();
												$('#district_name').val(district_name);
												$.ajax({
													type: 'POST',
													url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
													data: { state_id: s, district_id : d},
													success: function (html) {
														//alert(html);
														if(html !=''){
														$('#hcity').html(html);
														}else{
														  $('#hcity').html('<option value="">First Select District</option>');  
														}
														$('#hcity option').each(function()
														 {              
															 if($(this).val()== c)
															{
																//alert(district_id);
																$(this).attr('selected','selected');
																var city_name=$("#hcity option:selected").text();
												$('#city_name').val(city_name);
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
					
										
					$('#gender option').each(function()
					{
						if($(this).val()== g)
						{
							$(this).attr('selected','selected');
						}
					});
					$('#pref option').each(function()
					{
						if($(this).val()== p)
						{
							$(this).attr('selected','selected');
						}
					});
				}
			}
	});
}


	var diffDays =0;
	$(document).ready(function(){
	
	$('#stype').on('change', function () {
		var stype = $(this).val();
		if(stype=='I')
		{
			$('#institute').hide();
			$('#inhouse').show();
		}
		else
		{
			$('#institute').show();
			$('#prn').val('');
			$('#org').val('');
			$('#school').val('');
			$('#stream').val('');
			$('#inhouse').hide();
		}
	});
	
	$('#stream').on('change', function () {
		$("#stream_name").val($("#stream option:selected").text());
	});
	
	$('#etype').on('change', function () {
		var etype = $(this).val();
		if(etype=='OTHER')
			$('#entrance').show();
		else
		{
			$('#e_other').val('');
			$('#entrance').hide();
		}
	});
	
	$('.numonly').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^0-9]/g,'') ); }
		);
	
	// City by State
	$('#lstate_id').on('change', function () {
		var stateID = $(this).val();
		$("#state_name").val($("#lstate_id option:selected").text());
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#ldistrict_id').html(html);
				}
			});
		} else {
			$('#ldistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#ldistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#lstate_id").val();
		$("#district_name").val($("#ldistrict_id option:selected").text());
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#lcity').html(html);
					}else{
					  $('#lcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#lcity').html('<option value="">Select district first</option>');
		}
	});	
	
	$("#lcity").change(function(){
      $("#city_name").val($("#lcity option:selected").text());
    });
  /////////// for perment address
      // City by State
	$('#pstate_id').on('change', function () {
		var stateID = $(this).val();
		$("#pstate_name").val($("#pstate_id option:selected").text());
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#pdistrict_id').html(html);
				}
			});
		} else {
			$('#pdistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#pdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#pstate_id").val();
		$("#pdistrict_name").val($("#pdistrict_id option:selected").text());
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#pcity').html(html);
					}else{
					  $('#pcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#pcity').html('<option value="">Select district first</option>');
		}
	});	
	
	$("#pcity").change(function(){
      $("#pcity_name").val($("#pcity option:selected").text());
    });
	 /////////// for Parent's/Guardian's Details *
      // City by State
	$('#gstate_id').on('change', function () {
		var stateID = $(this).val();
		$("#gstate_name").val($("#gstate_id option:selected").text());
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#gdistrict_id').html(html);
				}
			});
		} else {
			$('#gdistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#gdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#gstate_id").val();
		$("#gdistrict_name").val($("#gdistrict_id option:selected").text());
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#gcity').html(html);
					}else{
					  $('#gcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#gcity').html('<option value="">Select district first</option>');
		}
	});
	$("#gcity").change(function(){
      $("#gcity_name").val($("#gcity option:selected").text());
    });
	
 // City by State
	$('#hstate_id').on('change', function () {
		 stateID = $(this).val();
			var state_ID = $("#hstate_id").val();
			$("#state_name").val($("#hstate_id option:selected").text());
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
			$('#hdistrict_id').html('<option value="">Select State First</option>');
		}
	});
	
    // City by State
	$('#hdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#hstate_id").val();
		$("#district_name").val($("#hdistrict_id option:selected").text());
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
					  $('#hcity').html('<option value="">No City Found</option>');  
					}
				}
			});
		} else {
			$('#hcity').html('<option value="">Select District First</option>');
		}
	});

		 $("#hcity").change(function(){
      $("#city_name").val($("#hcity option:selected").text());
    });
	
	
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var mmm= today.getMonth();
	var yyyy = today.getFullYear();
	if(dd<10){
	dd='0'+dd;
	} 
	if(mm<10){
	mm='0'+mm;
	} 
	var today = dd+'-'+mm+'-'+yyyy;
	
	$('#dob-datepicker').datepicker( {format: 'dd-mm-yyyy',autoclose: true}).on('changeDate', function (e) {
		$('#form').bootstrapValidator('revalidateField', 'dob');
		});
		
	$('#dob-datepicker1').datepicker( {format: 'dd-mm-yyyy',autoclose: true}).on('changeDate', function (e) {
		$('#form').bootstrapValidator('revalidateField', 'ad_date');
		});
	
	
	$('.numbersOnly').keyup(function () {
		//alert('qwrwq');
		if (this.value != this.value.replace(/[^0-9]/g, '')) {
		   this.value = this.value.replace(/[^0-9]/g, '');
		} 
		});
		
	
});	

</script>
