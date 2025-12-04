<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
		//form.profile_img.value=base_url+"uploads/employee_profilephotos/"+$emp[0]['profile_pic'];
		//in edit employee details display payband if scale type=scale
		if(document.getElementById('scaletype').value=='scale')
		document.getElementById('showpay').style.display = "block"; // hide body div tag	
		
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
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
            fields: 
            {
                fname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'First name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'First name should be alphabet characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'First name should be 2-50 characters'
                        }
                    }
                },
				mname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Middle name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Middle name should be alphabet characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Middle name should be 2-50 characters'
                        }
                    }
                },
				lname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Last name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Last name should be alphabet characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Last name should be 2-50 characters'
                        }
                    }
                },
				employeeID:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Employee ID should not be empty'
                      }/* ,
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Last name should be alphabet characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Last name should be 2-50 characters'
                        }*/
                    } 
                },
				/* date_of_birth: {
					validators: {
						/* date: {
							format: 'dd-mm-yyyy',
							message: 'The value is not a valid birth date'
						}, 
						notEmpty: 
                      {
                       message: 'Date Of Birth should not be empty'
                      }
					}
				}, */
				staff_type:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Staff Type should not be empty'
                      }
                    } 
                },
				adhar_no:
                {
                    validators: 
                    {
                     stringLength: 
                        {
                        max: 12,
                        min: 12,
                        message: 'Aadhar Number Length should be 12 Digit '
                        },
						regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Aadhar Number should be numeric'
                      }
                    } 
                },
				blood_gr:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'blood group should not be empty'
                      }
                    } 
                },
				 profile_img:
                {
                    /* validators: 
                    {
                      notEmpty: 
                      {
                       message: 'profile Image should  be upload '
                      }
                    }  */
					   
                validators: {
                    file: {
                        extension: 'jpeg,jpg,png',
                        type: 'image/jpeg,image/jpg,image/png',
                        maxSize: 2048 * 1024,   // 2 MB
                        message: 'The selected file is not valid'
                    }
						}
				
                }, 
				bill_A:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Local Plot/Flat No should not be empty'
                      }
                    }
                },
				/* shipping_A:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Permanent Plot/Flat No should not be empty'
                      }
                    }
                },  */
               bill_T:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Local Taluka Name should not be empty'
                      }
                    }
                },
				/*  shipping_T:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Permanent Taluka Name should not be empty'
                      }
                    }
                }, */ 
				bill_C:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address City should not be empty'
                      }
                    }
                },
				/*  shipping_C:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address City should not be empty'
                      }
                    }
                },  */
				bill_D:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address State should not be empty'
                      }
                    }
                },
				 /* shipping_D:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address State should not be empty'
                      }
                    }
                },  */
				bill_country:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address Country should not be empty'
                      }
                    }
                },
				 /* shipping_country:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address Country should not be empty'
                      }
                    }
                },  */
				bill_pc:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Local Address Pincode should not be empty'
                      },
					   regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Local Address Pincode number should be numeric'
                      },
					  stringLength: 
                        {
                        max: 6,
                        min: 6,
                        message: 'Check Pincode length '
                        }
                    }
                },
				/* shipping_pc:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Permanent Address Pincode should not be empty'
                      },
					   regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Permanent Address Pincode number should be numeric'
                      },
					  stringLength: 
                        {
                        max: 6,
                        min: 6,
                        message: 'Check Pincode length '
                        }
                    }
                }
				, */
				/* joiningDate: {
					validators: {
						/* date: {
							format: 'dd-mm-yyyy',
							message: 'The value is not a valid joining date'
						},
						notEmpty: 
                      {
                       message: 'Joining date  should not be empty'
                      }
					}
				}, */
				emp_school:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Appointd School for staff  should not be empty'
                      }
                    } 
                },
				department:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Appointd Department for staff  should not be empty'
                      }
                    } 
                },
				designation:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Designation for staff  should not be empty'
                      }
                    } 
                },
				mobileNumber:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mobile number should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Mobile number should be numeric'
                      },
                      stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        }
                    }
                },
				pemail:
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
				scaletype:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' scale type for staff  should not be empty'
                      }
                    } 
                },
				qualifiaction:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Qualification for staff  should not be empty'
                      }
                    } 
                },
				basic_sal:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Basic Salary for staff  should not be empty'
                      }
                    } 
                },
				bank_acc_no:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Basic Salary for staff  should not be empty'
                      }
                    } 
                },
				bank_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Basic Salary for staff  should not be empty'
                      }
                    } 
                },
				week_off:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Weekly Off for staff  should not be empty'
                      }
                    } 
                },
				shift:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Shift for staff  should not be empty'
                      }
                    } 
                },
				reporting_school:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Reporting School for staff  should not be empty'
                      }
                    } 
                },
				reporting_dept:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Reporting Department for staff  should not be empty'
                      }
                    } 
                },
				reporting_person:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Reporting Person for staff  should not be empty'
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
		<?php if(isset($emp[0]['inserted_by'])&&$emp[0]['inserted_by']==1){?>
		<li class="active"><a href="#">Edit Employee</a></li>	
		<?php }else{ ?>
        <li class="active"><a href="#">Add New Employee</a></li>
		<?php } ?>
    </ul>
    <div class="page-header">			
        <div class="row">
		<?php if(isset($emp[0]['inserted_by'])&&$emp[0]['inserted_by']==1){?>
		<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Employee Details</h1>
		<?php }else{ ?>
       <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add New Employee</h1>
		<?php } ?>
            
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
                    
                    <div class="panel-body">
					    <div class="table-info">
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_emp')?>" method="POST" enctype="multipart/form-data">
                         <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	
								<?php if(isset($emp[0]['inserted_by'])&&$emp[0]['inserted_by']==1){?>
		<div class="panel-heading"><strong>Edit Employee Registration Form</strong></div>
		<?php }else{ ?>
       <div class="panel-heading"><strong>New Employee Registration</strong></div>
		<?php } ?>
								<div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
							<div class="clearfix">
							<?php
							 /* echo"<pre>";
							print_r($emp);
							echo"</pre>";
							die();   */ 
/* echo $emp[0]['emp_id']; 
 */
/* print_r($dept_list);
print_r($desig_list);
echo $emp[0]['fname'];  */
//print_r($org_list);
//echo $update_flg;
//die();
?>
					<div class="row ">
					<div class="col-md-12 col-sm-12">
        					<div class="portlet box red-sunglo">
        						<div class="portlet-title">
        							<div class="caption">
        								<i class="fa fa-calendar"></i>Personal Details
        							</div>

        						</div>
        						<div class="portlet-body">
								<div class="form-body">
										<input type="hidden" name="update_flg" value="<?=$update_flg?>">
										<div class="form-group">
        										<label class="col-md-3 control-label">Name:<?=$astrik?></label>
        										<div class="col-md-3">
        						<input class="form-control" data-bv-field="fname" id="fname"  name="fname" placeholder="First Name" value="<?=isset($emp[0]['fname'])?$emp[0]['fname']:''?>" type="text" >

        										</div>
												<div class="col-md-3">
        											<input class="form-control" name="mname" placeholder="MiddleName" value="<?=isset($emp[0]['mname'])?$emp[0]['mname']:''?>" type="text" >
        										</div>
												<div class="col-md-3">
        											<input class="form-control" name="lname" placeholder="Last Name" value="<?=isset($emp[0]['lname'])?$emp[0]['lname']:''?>" type="text" >
        										</div>
        									</div>
        									
                                     <div class="form-group">
        										<label class="col-md-3 control-label">Employee ID:<?=$astrik?></label>
        										<div class="col-md-3">
 <input class="form-control" name="employeeID" placeholder="Employee ID" value="<?=isset($_REQUEST['id'])?$_REQUEST['id']:''?>" type="text" >
        										</div>
												<label class="col-md-3 control-label">Appointment Reference ID:</label>
        										<div class="col-md-3">
 <input class="form-control" name="referenceID" placeholder="Appointment Reference ID" value="<?=isset($_REQUEST['referenceID'])?$_REQUEST['referenceID']:''?>" type="text">
        										</div>
        									</div>
        									
        									<div class="form-group">
        										<label class="control-label col-md-3">Date of Birth:<?=$astrik?></label>
        										<div class="col-md-3">
												<div class="input-group date" id="dob-datepicker">
        										<input class="form-control" name="date_of_birth" readonly="" value="<?=isset($emp[0]['date_of_birth'])?date('d-m-Y', strtotime($emp[0]['date_of_birth'])):''?>" type="text" >
        												<span class="input-group-btn">
        												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
        												</span>
        											</div>
        										</div>
												<label class="col-md-3 control-label">Gender:<?=$astrik?></label>
        										<div class="col-md-3">
        											 <?php 
													 $str1="";
													 if($emp[0]['gender']=='male'){
														  $str="checked";
													  }
													  else{
														  $str1="checked";
													  }?>
													 <div class="col-sm-5"><input type="radio" <?=$str?> name="gender" value="male">Male </div>
													 <div class="col-sm-5"><input type="radio" <?=$str1?> name="gender" value="female">Female </div>
        										</div>
        									</div>
        						<div class="form-group">
								<label class="col-md-3 control-label">Staff Type:<?=$astrik?></label>
        										<div class="col-md-3">
        											 <select  class="form-control" name="staff_type" id="staff_type">
													   <option value="">Select</option>
													<?php foreach($emp_cat as $ec ){
												if($ec['emp_cat_id']==$emp[0]['staff_type']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$ec['emp_cat_id'].">".$ec['emp_cat_name']."</option>"?>
											<?php } ?>
													</select>
													 </div>
					            <label class="col-md-3 control-label">Blood Group:<?=$astrik?></label>
        										<div class="col-md-3">
												  <select  class="form-control" name="blood_gr" id="blood_gr">
												  <option value="">Select</option>
												  <?php
													 $str=$str1=$str2=$str3=$str4=$str5=$str6=$str7=$str8=$str9=$str10=$str11=$str12="";
													if($emp[0]['blood_gr']=='A+'){
															 $str="selected";
															 }elseif($emp[0]['blood_gr']=='A-'){
															$str1="selected";	 
															 }elseif($emp[0]['blood_gr']=='A'){
															$str2="selected";	 
															 }elseif($emp[0]['blood_gr']=='B+'){
															$str3="selected";	 
															 }elseif($emp[0]['blood_gr']=='B-'){
															$str4="selected";	 
															 }elseif($emp[0]['blood_gr']=='B'){
															$str5="selected";	 
															 }elseif($emp[0]['blood_gr']=='AB+'){
															$str6="selected";	 
															 }elseif($emp[0]['blood_gr']=='AB-'){
															$str7="selected";	 
															 }elseif($emp[0]['blood_gr']=='AB'){
															$str8="selected";	 
															 }elseif($emp[0]['blood_gr']=='O+'){
															$str9="selected";	 
															 }elseif($emp[0]['blood_gr']=='O-'){
															$str10="selected";	 
															 }elseif($emp[0]['blood_gr']=='O'){
															$str11="selected";	 
															 }elseif($emp[0]['blood_gr']=='Unknown'){
															$str12="selected";	 
															 }?>
    <option <?=$str?> value="A+">A Positive</option>
    <option <?=$str1?> value="A-">A Negative</option>
    <option <?=$str2?> value="A">A Unknown</option>
    <option <?=$str3?> value="B+">B Positive</option>
    <option <?=$str4?> value="B-">B Negative</option>
    <option <?=$str5?> value="B">B Unknown</option>
    <option <?=$str6?> value="AB+">AB Positive</option>
    <option <?=$str7?> value="AB-">AB Negative</option>
    <option <?=$str8?> value="AB">AB Unknown</option>
    <option <?=$str9?> value="O+">O Positive</option>
    <option <?=$str10?> value="O-">O Negative</option>
    <option <?=$str11?> value="O">O Unknown</option>
    <option <?=$str12?> value="Unknown">Unknown</option>
</select> 
                                                 </div>												
													 </div>
		<div class="form-group">
		<label class="col-md-3">Upload Photo:<?=$astrik?></label>
		<?php
		if(!empty($emp[0]['profile_pic'])){
			$profile=base_url()."uploads/employee_profilephotos/".$emp[0]['profile_pic'];
		}else{
	$profile=base_url()."uploads/noimage.png";}?>
	<div class="col-md-3">
	<div class="col-sm-3">
		<img id="blah" alt="Student Profile image" src="<?php echo $profile;?>"width="100" height="100" border="1px solid black" />
		</div><br><br><br><br>
		<div class="col-sm-3"></div>
	 <div class="col-sm-3">
        <input type="file" id="profile_img" name="profile_img" value="<?=isset($emp[0]['profile_pic'])?$emp[0]['profile_pic']:''?>" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" >
		</div>
		
		
		</div>
		<label class="col-md-3 control-label">Aadhar No:</label>
		<div class="col-md-3">
	<input class="form-control" name="adhar_no" placeholder="Aadhar No" value="<?=isset($emp[0]['adhar_no'])?$emp[0]['adhar_no']:''?>" type="text">	
		</div>
</div>	         
        								</div>
								
								</div>
        					</div>
        					
        				</div>
        				</div>
        			</div>
					
                                <div class="row ">
        				<div class="col-md-12 col-sm-12">
        					<div class="portlet box purple-wisteria">
        						<div class="portlet-title">
        							<div class="caption">
        								<i class="fa fa-calendar"></i>Address Details 
        							</div>

        						</div>
        						<div class="portlet-body">

                              <div class="form-body">
							  <table class="table table-bordered">
		<tr><th>Local Address:<?=$astrik?></th>
        <th>Permanent Address:<?=$astrik?></th></tr>
			<tr>
		<!--Local Address-->
		<td width="50%">
<div class="form-group">
<label  class="col-sm-3">Plot/Flat No.:</label><div class="col-sm-3"><INPUT TYPE="TEXT" data-bv-field="bill_A" id="bill_A" NAME="bill_A" value="<?=isset($emp[0]['lflatno'])?$emp[0]['lflatno']:'';?>" SIZE=30><i data-bv-icon-for="bill_A" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="bill_A" data-bv-validator="notEmpty" class="help-block" style="display: none;">Plaot/Flat No .should not be empty</small></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Area Name:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_B" NAME="bill_B" value="<?=isset($emp[0]['larea_name'])?$emp[0]['larea_name']:'';?>" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Taluka:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_T" NAME="bill_T" value="<?=isset($emp[0]['ltaluka'])?$emp[0]['ltaluka']:'';?>" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">State:</label>
<div class="col-sm-3">
<!--<INPUT TYPE="TEXT" id="bill_D" NAME="bill_D" value="<?=isset($emp[0]['lstate'])?$emp[0]['lstate']:'';?>" SIZE=30>-->
<select style="width:240px;height:20px" name="bill_D" id="bill_D" onchange="getcitybystates(this.value)">
<option  value="">Select</option>
<?php foreach($state as $sts){
	if($sts['state_id']==$emp[0]['lstate']){
													$str="selected";
												}else{$str="";}
												
	echo "<option ".$str." value=".$sts['state_id'].">".$sts['state_name']."</option>";
	?>

<?php }?>
</select>
</div> 
</div>

<div class="form-group">
<label  class="col-sm-3">Dist/City:</label><div class="col-sm-3">
<!--<INPUT TYPE="TEXT" id="bill_C" NAME="bill_C" value="<//isset($emp[0]['ldist'])?$emp[0]['ldist']:'';?>" SIZE=30>-->
<select style="width:240px;height:20px" name="bill_C" id="bill_C">
<option  value='' >Select </option>
                                               <?php 
                                                 if(!empty($emp[0]['lstate'])){
												$cities_list=$this->Admin_model->getCityBystatewiseId($emp[0]['lstate']);	
                                               foreach($cities_list as $ct ){
												if($ct['city_id']==$emp[0]['ldist']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$ct['city_id'].">".$ct['city_name']."</option>" ;												
												 }
                								
											 } ?>
</select>
</div>
</div>
<div class="form-group">
<label  class="col-sm-3">Pin Code:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_pc" NAME="bill_pc" value="<?=isset($emp[0]['lpincode'])?$emp[0]['lpincode']:'';?>" SIZE=30></div>
</div>

<div class="form-group">
<label  class="col-sm-3">Country:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_country" NAME="bill_country" value="<?=isset($emp[0]['lcountry'])?$emp[0]['lcountry']:'India';?>" SIZE=30></div>
</div>

</fieldset>
		</td>
		<!--Permanent Address-->
		<td width="50%"><fieldset>
<div class="form-group">
<label  class="col-sm-3">Plot/Flat No.:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_A" NAME="shipping_A" value="<?=isset($emp[0]['pflatno'])?$emp[0]['pflatno']:'';?>" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Area Name:</label><div class="col-sm-3"><INPUT TYPE="TEXT" NAME="shipping_B" value="<?=isset($emp[0]['parea_name'])?$emp[0]['parea_name']:'';?>" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Taluka:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_T" NAME="shipping_T" value="<?=isset($emp[0]['ptaluka'])?$emp[0]['ptaluka']:'';?>" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">State:</label><div class="col-sm-3">
<!--<INPUT TYPE="TEXT" id="shipping_D" NAME="shipping_D" value="<?=isset($emp[0]['pstate'])?$emp[0]['pstate']:'';?>" SIZE=30>-->
<select style="width:240px;height:20px" name="shipping_D" id="shipping_D" onchange="getcitybystates1(this.value)">
<option  value="">Select</option>
<?php foreach($state as $sts){
	if($sts['state_id']==$emp[0]['pstate']){
													$str="selected";
												}else{$str="";}
												
	echo "<option ".$str." value=".$sts['state_id'].">".$sts['state_name']."</option>";
	?>

<?php }?>


</select>
</div> 
</div>
<div class="form-group">
<label  class="col-sm-3">Dist/City:</label>
<div class="col-sm-3">
<!--<INPUT TYPE="TEXT" id="shipping_C" NAME="shipping_C" value="<//?=isset($emp[0]['pdist'])?$emp[0]['pdist']:'';?>" SIZE=30>-->
<select style="width:240px;height:20px" name="shipping_C" id="shipping_C">
<option  value='' >Select </option>
                                       <?php 
                                                 if(!empty($emp[0]['pstate'])){
												$cities_list1=$this->Admin_model->getCityBystatewiseId($emp[0]['pstate']);
												print_r($cities_list1);
                                               foreach($cities_list1 as $ct ){
												if($ct['city_id']==$emp[0]['pdist']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$ct['city_id'].">".$ct['city_name']."</option>" ;												
												 }
                								
											 } ?>
</select>
</div>
</div>
<div class="form-group">
<label  class="col-sm-3">Pin Code:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_pc" NAME="shipping_pc" value="<?=isset($emp[0]['p_pincode'])?$emp[0]['p_pincode']:'';?>" SIZE=30></div>
</div>

<div class="form-group">
<label  class="col-sm-3">Country:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_country" NAME="shipping_country" value="<?=isset($emp[0]['pcountry'])?$emp[0]['pcountry']:'India';?>" SIZE=30></div>
</div>

</td></tr>
<?php if($emp[0]['same']=="on"){
	$val="checked";
	}
else{
	$val="";
}?>
<!--<tr><td><label style="text-align:left"><input name="same" <?php echo $val;?> onclick="copyBilling (this.form) " type="checkbox">Permanent Address is Same as Local Address</label></td></tr>-->
</table>
<label style="text-align:left"><input name="same" <?php echo $val;?> onclick="copyBilling (this.form) " type="checkbox"> Permanent Address is Same as Local Address</label>	
							  </div>
        								

        						</div>
        					</div>
        				</div>
						</div>
						<div class="row">
        				<div class="col-md-12 col-sm-12">
        					<div class="portlet box red-sunglo">
        						<div class="portlet-title">
        							<div class="caption">
        								<i class="fa fa-calendar"></i>Joining Details
        							</div>

        						</div>
        						<div class="portlet-body">

        								<div class="form-body">
        									<div class="form-group">
        										<label class="control-label col-md-3">Date of Joining:<?=$astrik?></label>
												<div class="col-md-3">
												<div class="input-group date" id="dob-datepicker1">
        										<input class="form-control" id="joiningDate" name="joiningDate" readonly="" value="<?=isset($emp[0]['joiningDate'])?date('d-m-Y', strtotime($emp[0]['joiningDate'])):''?>" type="text" >
        												<span class="input-group-btn">
        												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
        												</span>
        											</div>
        										</div>
        										<label class="col-md-3 control-label">School:<?=$astrik?></label>
        										<div class="col-md-3">

        											 <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="emp_school" >
													 <option value="">Select School</option>
													<?php foreach($school_list as $sc ){
												if($sc['college_id']==$emp[0]['emp_school']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$sc['college_id'].">".$sc['college_name']."</option>"?>
											<?php } ?>
											</select>
        										</div>
        									</div>
											<div class="form-group">
        									<label class="col-md-3 control-label">Designation:<?=$astrik?></label>
        										<div class="col-md-3">

        											 <select class="select2me form-control" name="designation" id="designation" >
													 <option value="">Select</option>
											<?php foreach($desig_list as $desig ){
												if($desig['designation_id']==$emp[0]['designation']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$desig['designation_id'].">".$desig['designation_name']."</option>"?>
											<?php } ?>													
													 </select>
        										</div>
                                           <label class="col-md-3 control-label">Department:<?=$astrik?></label>
        										<div class="col-md-3">
        									<select class="form-control select2me" id="department"  name="department" >
											<option value="">Select</option>
											<?php 
                                                 if(!empty($emp[0]['emp_school'])){
												$dept_list=$this->Admin_model->getDepartmentListById($emp[0]['emp_school']);	
                                               foreach($dept_list as $dept ){
												if($dept['department_id']==$emp[0]['department']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$dept['department_id'].">".$dept['department_name']."</option>" ;												
												 }
                								
											 } ?>
											 
											</select>
        										</div>												
        									</div>
											
										<div class="form-group">
										<label class="col-md-3 control-label">Landline No:</label>
										<div class="col-md-1">
    <input class="form-control" name="landline_std" placeholder="STD " value="<?=isset($emp[0]['landline_std'])?$emp[0]['landline_std']:''?>" type="text" maxlength="6"  >
        										</div>
        										<div class="col-md-2">
    <input class="form-control" name="landline_no" placeholder="Phone No" value="<?=isset($emp[0]['landline_no'])?$emp[0]['landline_no']:''?>" type="text" maxlength="10"  >
        										</div>
        										<label class="col-md-3 control-label">Mobile Number:<?=$astrik?></label>
        										<div class="col-md-3">
    <input class="form-control" name="mobileNumber" id="mobileNumber" placeholder="Mobile Number" value="<?=isset($emp[0]['mobileNumber'])?$emp[0]['mobileNumber']:''?>" type="text">
        										</div>
        									</div>
											<div class="form-group">
                                                    <label class="col-md-3 control-label">Personal Email ID:<?=$astrik?></label>
                                                    <div class="col-md-3">
                                                        <input name="pemail" id="pemail" class="form-control" placeholder="Personal Email ID" value="<?=isset($emp[0]['pemail'])?$emp[0]['pemail']:''?>" type="email" >
                                                    </div>
													 <label class="col-md-3 control-label">Offical Email ID:</label>
                                                    <div class="col-md-3">
                                                        <input name="oemail" id="oemail" class="form-control" placeholder="Offical Email ID" value="<?=isset($emp[0]['oemail'])?$emp[0]['oemail']:''?>" type="email" >
                                                    </div>
                                                </div>
											<div class="form-group">
											<label class="col-md-3 control-label">Grade:</label>
        										<div class="col-md-3">
												<input name="staff_grade" class="form-control" placeholder="Grade" value="<?=isset($emp[0]['staff_grade'])?$emp[0]['staff_grade']:''?>" type="text" ></div>
        										<label class="col-md-3 control-label">Scale Type:<?=$astrik?></label>
        										<div class="col-md-3">

        											 <select class="select2me form-control" name="scaletype" id="scaletype" onchange="answers(this.value)" id="scaletype" >
													 <option value="">Select</option>
													 <?php $str=$str1="";
													 if($emp[0]['scaletype']=='consolidated'){
														 $str="selected";
														 }elseif($emp[0]['scaletype']=='scale'){
															 $str1="selected";
															 }?>
													<option <?=$str?> value="consolidated">Consolidated</option>
													<option <?=$str1?> value="scale">scale</option>
													 </select>
        										</div>
        									</div>
																			
											<div class="form-group">
        										<label class="col-md-3 control-label">Order Nature:<?=$astrik?></label>
        										<div class="col-md-3">

        											 <select class="select2me form-control" name="hiring_type" id="hiring_type" >
													 <option value="">Select</option>
													 <?php
													 $str=$str1=$str2="";
													 if($emp[0]['hiring_type']=='Ad-hoc'){
														 $str="selected";
														 }elseif($emp[0]['hiring_type']=='Permanent'){
															 $str1="selected";
															 }elseif($emp[0]['hiring_type']=='Visiting'){
															$str2="selected";	 
															 }?>
													 <option <?=$str?> value="Ad-hoc">Ad-hoc</option>
													 <option <?=$str1?> value="Permanent">Permanent</option>
													 <option <?=$str2?> value="Visiting">Visiting</option>
													 </select>
        										</div>
												<label class="col-md-3 control-label">Education/Qualifiaction:<?=$astrik?></label>
        										<div class="col-md-3">
        											<input type="text" class="form-control" name="qualifiaction" id="qualifiaction" placeholder="Highest Education  Qualification" value="<?=isset($emp[0]['qualifiaction'])?$emp[0]['qualifiaction']:''?>" >
        										</div>
        									</div>
											<div class="form-group">
        										<label class="col-md-3 control-label">Physically Handicaped:</label>
        										<div class="col-md-3">
												<?php
												$str=$str1="";
												if($emp[0]['phy_status']==1){
													$str="checked";
												}
													
												else{
													$str1="checked";}
												?>
        											<div class="col-sm-5"><input type="radio" <?=$str?> name="phy_status" value="0">Yes </div>
													 <div class="col-sm-5"><input type="radio" <?=$str1?> name="phy_status" value="1">No </div>
        										</div>
												<label class="col-md-3 control-label">Providend Fund:</label>
        										<div class="col-md-3">
												<?php
												$str=$str1="";
												if($emp[0]['pf_status']==1){
													$str="checked";
												}
													
												else{
													$str1="checked";}
												?>
        											<div class="col-sm-5"><input type="radio" <?=$str?> name="pf_status" value="0">Yes </div>
													 <div class="col-sm-5"><input type="radio" <?=$str1?> name="pf_status" value="1">No </div>
        										</div>
        									</div> 
											<div class="form-group">
											<label class="col-md-3 control-label">Experience:<?=$astrik?></label>
											<div class="col-md-9">
											
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Type</th>
        <th>Year</th>
        <th>Month</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><b>Academic/Technical<b></td>
        <td><input type="number" name="aexp_yr" id="aexp_yr" min="0" max="100"  placeholder="Year" value="<?=isset($emp[0]['aexp_yr'])?$emp[0]['aexp_yr']:''?>"></td>
        <td><input type="number" name="aexp_mnth" id="aexp_mnth" min="0" max="11" placeholder="Month" value="<?=isset($emp[0]['aexp_mnth'])?$emp[0]['aexp_mnth']:''?>"></td>
      </tr>
      <tr>
        <td><b>Industrial/Other<b></td>
        <td><input type="number" name="inexp_yr" id="inexp_yr" min="0" max="100" placeholder="Year" value="<?=isset($emp[0]['inexp_yr'])?$emp[0]['inexp_yr']:''?>"></td>
        <td><input type="number" name="inexp_mnth" id="inexp_mnth" min="0" max="11" placeholder="Month" value="<?=isset($emp[0]['inexp_mnth'])?$emp[0]['inexp_mnth']:''?>"></td>
      </tr>
      <tr>
        <td><b>Research</b></td>
        <td><input type="number" name="rexp_yr" id="rexp_yr" min="0" max="100" placeholder="Year" value="<?=isset($emp[0]['rexp_yr'])?$emp[0]['rexp_yr']:''?>"></td>
        <td><input type="number" name="rexp_mnth" id="rexp_mnth" min="0" max="11" placeholder="Month" value="<?=isset($emp[0]['rexp_mnth'])?$emp[0]['rexp_mnth']:''?>"></td>
      </tr>
	   <tr>
        <td><b>Total</b></td>
        <td><input type="text" name="texp_yr" id="texp_yr" min="0" max="100" placeholder="Year" onclick="get_total_experience()" value="<?=isset($emp[0]['texp_yr'])?$emp[0]['texp_yr']:''?>"></td>
        <td><input type="text" name="texp_mnth" id="texp_mnth" min="0" max="11" placeholder="Month" value="<?=isset($emp[0]['texp_mnth'])?$emp[0]['texp_mnth']:''?>"></td>
      </tr>
    </tbody>
  </table>	</div>
				</div>
				<div class="form-group">
        										<label class="col-md-3 control-label">Basic Salary:<?=$astrik?></label>
        										<div class="col-md-3">
        											<input type="text" class="form-control" name="basic_sal" id="basic_sal" placeholder="Basic Salary" value="<?=isset($emp[0]['basic_sal'])?$emp[0]['basic_sal']:''?>" >
        										</div>
												<label class="col-md-3 control-label">Special Allowance:<?=$astrik?></label>
        										<div class="col-md-3">
        											<input type="text" class="form-control" name="allowance" id="allowance" placeholder="Special Allowance" value="<?=isset($emp[0]['allowance'])?$emp[0]['allowance']:''?>" >
        										</div>
												</div>
												<div id="showpay" style="display:none;">
												<div class="form-group">
											<label class="col-md-3 control-label">Pay Band:</label>
        										
       <div class="col-md-3"><input type="text" class="form-control" name="pay_band_min" id="pay_band_min" placeholder="Min" value="<?=isset($emp[0]['pay_band_min'])?$emp[0]['pay_band_min']:''?>" >
       </div>
	   <div class="col-md-3"><input type="text" class="form-control" name="pay_band_max" id="pay_band_max" placeholder="Max" value="<?=isset($emp[0]['pay_band_max'])?$emp[0]['pay_band_max']:''?>" >
       </div>
	   <div class="col-md-3"><input type="text" class="form-control" name="pay_band_gt" id="pay_band_gt" placeholder="AGP" value="<?=isset($emp[0]['pay_band_gt'])?$emp[0]['pay_band_gt']:''?>" >
        </div>
         </div>		
        			</div> 
					<div class="form-group">
        										
												<label class="col-md-3 control-label">Other</label>
        										<div class="col-md-3">
        											<input type="text" class="form-control" name="other_pay" id="other_pay" placeholder="Other" value="<?=isset($emp[0]['other_pay'])?$emp[0]['other_pay']:''?>" >
        										</div>
        			</div> 
					
				
        								</div>

        						</div>
        					</div>
        					
        				</div>
        			</div>
					
					<div class="clearfix">
					<div class="row ">
					<div class="col-md-12 col-sm-12">
        					<div class="portlet box purple-wisteria">
        						<div class="portlet-title">
        							<div class="caption">
        								<i class="fa fa-calendar"></i>Other Details
        							</div>

        						</div>
        						<div class="portlet-body">
								<div class="form-group">
        										<label class="col-md-3 control-label">Bank Account No:<?=$astrik?></label>
        										<div class="col-md-3">
        											<input type="text" class="form-control" name="bank_acc_no" id="bank_acc_no" placeholder="Bank Account No" value="<?=isset($emp[0]['bank_acc_no'])?$emp[0]['bank_acc_no']:''?>" >
        										</div>
												<label class="col-md-3 control-label">Bank Name:<?=$astrik?></label>
        										<div class="col-md-3">
        											<!--<input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Bank Name" value="<?=isset($emp[0]['bank_name'])?$emp[0]['bank_name']:''?>" >-->
													 <select name="bank_name" id="bank_name" class="form-control" >
													 <option value="">Select Bank</option>
													<?php foreach($bank_list as $ba ){
												if($ba['bank_name']==$emp[0]['bank_name']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$ba['bank_id'].">".$ba['bank_name']."</option>"?>
											<?php } ?>
											</select>
        										</div>
        									</div> 
								<div class="form-group">
        										<label class="col-md-3 control-label">PF No:</label>
        										<div class="col-md-3">
        											<input type="text" class="form-control" name="pf_no" id="pf_no" placeholder="PF No" value="<?=isset($emp[0]['pf_no'])?$emp[0]['pf_no']:''?>" >
        										</div>
												<label class="col-md-3 control-label">PAN No:</label>
        										<div class="col-md-3">
        											<input type="text" class="form-control" name="pan_no" id="pan_no" placeholder="PAN N." value="<?=isset($emp[0]['pan_no'])?$emp[0]['pan_no']:''?>" >
        										</div>
        									</div> 
											
											<div class="form-group">
        										<label class="col-md-3 control-label">Weekly Off:<?=$astrik?></label>
        										<div class="col-md-3">
        										<select name="week_off" id="week_off" class="form-control" >
												<option value="">Select</option>
												<?php
													 $str=$str1=$str2=$str3=$str4=$str5=$str6="";
													 if($emp[0]['week_off']=='Sunday'){
														 $str="selected";
														 }elseif($emp[0]['week_off']=='Monday'){
															 $str1="selected";
															 }elseif($emp[0]['week_off']=='Tuesday'){
															$str2="selected";	 
															 }elseif($emp[0]['week_off']=='Tuesday'){
															$str3="selected";	 
															 }elseif($emp[0]['week_off']=='Tuesday'){
															$str4="selected";	 
															 }elseif($emp[0]['week_off']=='Tuesday'){
															$str5="selected";	 
															 }elseif($emp[0]['week_off']=='Tuesday'){
															$str6="selected";	 
															 }?>
	                                             <option <?=$str?> value="Sunday">Sunday</option>
	                                             <option <?=$str1?> value="Monday">Monday</option>
	                                             <option <?=$str2?> value="Tuesday">Tuesday</option>
	                                             <option <?=$str3?> value="Wensday">Wensday</option>
	                                              <option <?=$str4?> value="Thursday">Thursday</option>
	                                               <option <?=$str5?> value="Friday">Friday</option>
	                                               <option <?=$str6?> value="Saturday">Saturday</option>
                                                  </select>	
												
        										</div>
												<label class="col-md-3 control-label">Shift:<?=$astrik?></label>
        										<div class="col-md-3">
        											<select name="shift" id="shift" class="form-control" onchange="getTime(this.value)" >
												<option value="">Select Shift </option>
	                                           <?php foreach($shift_list as $sft ){
												if($sft['shift_id']==$emp[0]['shift']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$sft['shift_id'].">".$sft['shift_name']."</option>"?>
											<?php } ?>
                                                </select>	
        										</div>
        									</div> 
											<div class="form-group">
											<div id="duration">
        										<label class="col-md-3 control-label">In Time</label>
        										<div class="col-md-3">
												<?php
												      $time=strtotime($emp[0]['intime']);
												     $data_print=date("g:i a",$time);
													// echo $emp[0]['intime']; 
													// echo  $data_print; 
												?>
        										<input type="text" class="form-control" name="intime" id="intime" placeholder="HH:MM:SS" value="<?php echo date("G:i ",strtotime($emp[0]['intime']));?>" >
        										</div>
												<label class="col-md-3 control-label">Out Time</label>
        										<div class="col-md-3">
												
        											<input type="text" class="form-control" name="outtime" id="outtime" placeholder="HH:MM:SS" value="<?php echo date("G:i ",strtotime($emp[0]['outtime']));?>" >
        										</div>
												</div>
        									</div> 
											<div class="form-group">
        										<label class="col-md-3 control-label">Reporting School:<?=$astrik?></label>
        										<div class="col-md-3">
        										<select class="select2me form-control" name="reporting_school" onchange="getdept_using_school(this.value)" id="reporting_school" >
													  <option value="">Select</option>
													<?php foreach($school_list as $sc ){
												if($sc['college_id']==$emp[0]['reporting_school']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$sc['college_id'].">".$sc['college_name']."</option>"?>
											<?php } ?>
											
											</select>
												</div>
												<label class="col-md-3 control-label">Reporting Department:<?=$astrik?></label>
        										<div class="col-md-3">
        										<select name="reporting_dept" id="reporting_dept" onchange="getEmp_using_dept(this.value)" class="form-control" >
												<option value="">Select</option>
												<?php 
                                                 if(!empty($emp[0]['reporting_school'])){
												$dept_list=$this->Admin_model->getDepartmentListById($emp[0]['reporting_school']);	
                                               foreach($dept_list as $dept ){
												if($dept['department_id']==$emp[0]['reporting_dept']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$dept['department_id'].">".$dept['department_name']."</option>" ;												
												 }
                								
											 } ?>
												</select>
												</div>
												</div>
												<div class="form-group">
        										<label class="col-md-3 control-label">Reporting Person Name:<?=$astrik?></label>
        										<div class="col-md-3">
												<select class="select2me form-control" name="reporting_person" id="reporting_person" >
													  <option value="">Select</option>
												<?php 
													 if(!empty($emp[0]['reporting_person'])){
												$ro=$this->Admin_model->getSchoolDepartmentWiseEmployeeList($emp[0]['reporting_school'],$emp[0]['reporting_dept']);
												//print_r($ro);
												foreach($ro as $r ){
												if($r['emp_id']==$emp[0]['reporting_person']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$r['emp_id'].">".$r['fname'].' '.$r['mname'].' '.$r['lname']."</option>" ;												
													 }
													 }
												?>     										
												
											</select>
											
												</div>
												<label class="col-md-3 control-label">Make Me the Reporting Officer </label>
												<div class="col-md-3">
												  <?php if($emp[0]['ro_flag']=="on"){
	                                                       $valu="checked";
	                                                     }
                                                          else{
	                                                          $valu="";
                                                        }?>
												<input  type="checkbox" name="ro_flag" <?=$valu?> value="on">
												</div>
												</div>
												
								
					            </div>
					</div>
        					
        				</div>
        				</div>
					</div>
        			<div class="clearfix">
        			        			<div class="row ">
        				<div class="col-md-12 col-sm-12">
        					<div class="portlet box red-sunglo">
        						<div class="portlet-title">
        							<div class="caption">
        								<i class="fa fa-calendar"></i>Documents
        							</div>

        						</div>
        						<div class="portlet-body">

        								
											<div class="form-group">
		                                    <label class="col-sm-3">Resume</label>
											<div class="col-sm-3">
                                         <input name="resume" type="file" >
										    </div>	
											<div class="col-sm-3">
											<label ><?=isset($emp[0]['resume'])?$emp[0]['resume']:''?></label>
											</div>
                                             </div>
											 <div class="form-group">
		                                    <label class="col-sm-3">Offer Letter</label>
											<div class="col-sm-3">
                                         <input name="offerLetter" type="file">
		                                   </div>	
										   <div class="col-sm-3">
											<label ><?=isset($emp[0]['offer_letter'])?$emp[0]['offer_letter']:''?></label>
											</div>
                                             </div>
        																				
											 <div class="form-group">
		                                    <label class="col-sm-3">Joining Letter</label>
											<div class="col-sm-3">
                                         <input name="joiningLetter" type="file">
		                                   </div>
										    <div class="col-sm-3">
											<label ><?=isset($emp[0]['Joining_Letter'])?$emp[0]['Joining_Letter']:''?></label>
											</div>
                                             </div>
											
											<!-- <div class="form-group">
		                                    <label class="col-sm-3">Contract and Agreement</label>
											<div class="col-sm-3">
                                        <input name="contract" type="file">
		                                   </div>	
                                             </div>-->
        									<div class="form-group">
		                                    <label class="col-sm-3">ID Proof</label>
											<div class="col-sm-3">
                                       <input name="IDProof" type="file">
		                                   </div>
										    <div class="col-sm-3">
											<label ><?=isset($emp[0]['ID_Proof'])?$emp[0]['ID_Proof']:''?></label>
											</div>
                                             </div>
        									
        								</div>

        						</div>
        					</div>
        				</div>
        			</div>
        			
        			<div class="form-actions">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3">
									<?php if(!empty($emp[0]['emp_id'])){?>
									<button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Update </button>
									<?php }else{?>
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit </button>
									<?php } ?>
									</div>
									 <div class="col-md-3">
									 <a class="btn btn-primary form-control" id="btn_submit" type="submit" href="<?php echo base_url().'admin/employee_list'?>">Go Back </a>
									 </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>

        		</div>
        		   </div>
					 </div>
                                </div>
                            </div> 
                          </div>             
                                             
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#dob-datepicker').datepicker( {format: 'dd-mm-yyyy',autoclose: true});
	$('#dob-datepicker1').datepicker( {format: 'dd-mm-yyyy',autoclose: true});
	$('#intime').timepicker({autoclose: true});
	$('#outtime').timepicker({autoclose: true});
/* $('#intime').on('changeTime', function() {
    $('#intime').text($(this).val());
}); */
	
	
	var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
	$("#eduDetTable").on("click","input[name='addMore']", function(e){	
	//$("input[name='addMore']").on('click',function(){		
		//var content = $(this).parent().parent('tr').clone('true');
		$(this).parent().parent('tr').after(content);		
	});
	$("#eduDetTable").on("click","input[name='remove']", function(e){	
	//$("input[name='remove']").on('click',function(){
		var rowCount = $('#eduDetTable tbody tr').length;
		if(rowCount>1){
			$(this).parent().parent('tr').remove();
		}
	});	
	
	
	/* $('#reporting_school').on('change',function(){
		
        var reporting_schoolID = $(this).val();
		alert(base_url);
         if(reporting_schoolID){
			 post_data+="&rschool_id="+reporting_schoolID;
			 alert(post_data);
        jQuery.ajax({
               type: "POST",
				url: base_url+"admin/getdepartmentByschool",
                data: encodeURI(post_data),
				success: function(responce_data){
                    $('#reporting_dept').html(html);
                  
                }
            }); 
        }else{
            $('#reporting_dept').html('<option value="">Select country first</option>');
             } 
	}) */
});
</script>
<script type="text/javascript">
<!--
function copyBilling (f) {
	var s, i = 0;
	if(f.same.checked == true) {

	while (s = ['A', 'B','T', 'C', 'D', 'country', 'pc'][i++]) {
		f.elements['shipping_' + s].value = f.elements['bill_' + s].value;
		};
		/*extra for city */
		var temp = f.elements['bill_C'].value;
		var templebel = $("#bill_C :selected").text();
        
	      $('#shipping_C').append($('<option>',
         {
            value: temp,
            text : templebel,
	        selected : 'selected'
          }));
	    /* end extra for city */	
	}
	if(f.same.checked == false) {
    // alert(false);
	while (s = ['A', 'B','T','C', 'D', 'country', 'pc'][i++]) {f.elements['shipping_' + s].value ="";};
	}
}

function answers(stype){
	
if(stype=='consolidated'){
	//alert(stype);
	document.getElementById('showpay').style.display = "none"; // hide body div tag
	
}else{
	document.getElementById('showpay').style.display = "block"; // display body div tag
}
}

function get_total_experience(){
	
	var a=document.getElementById('aexp_yr').value; if(a=="")a=0;
	var b=document.getElementById('inexp_yr').value;if(b=="")b=0;
	var c=document.getElementById('rexp_yr').value;if(c=="")c=0;
	var d=document.getElementById('aexp_mnth').value;if(d=="")d=0;
	var e=document.getElementById('inexp_mnth').value;if(e=="")e=0;
	var f=document.getElementById('rexp_mnth').value;if(f=="")f=0;
	
	var total_year=parseInt(a)+ parseInt(b)+ parseInt(c);
	var total_month=parseInt(d)+ parseInt(e)+ parseInt(f);
	var mnth=total_month/12;
	var cmonth=parseInt(mnth);
	var final_year=total_year+cmonth;// final total year
	var allm= total_month % 12;
	var allmonth=parseInt(allm);
	
	var final_month=allmonth;// final total month
	/* alert (final_year);
	alert(final_month); */
	document.getElementById('texp_yr').value = final_year;
	document.getElementById('texp_mnth').value = allmonth;

}

// -->
</script>