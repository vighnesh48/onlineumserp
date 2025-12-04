<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<link href="<?= site_url() ?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?= site_url() ?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>
    $(document).ready(function (){
		$('#lstate_id').on('change', function () {
			//alert("hi");
			var stateID = $(this).val();
			
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
	// for edit 
		var stateID = $("#lstate_id").val();
		
			if (stateID) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
					data: 'state_id=' + stateID,
					success: function (html) {
						
						var district_id ="<?=$addr[0]['district_id']?>";
						$('#ldistrict_id').html(html);
						$("#ldistrict_id option[value='" + district_id + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#ldistrict_id').html('<option value="">Select state first</option>');
			}
			
    // City by State
	$('#ldistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#lstate_id").val();
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
	// for edit city
		var district= "<?=$addr[0]['district_id']?>";
		var state_ID = $("#lstate_id").val();
		//alert(state_ID);alert(district);
		if (district) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district},
				success: function (html) {
					//alert(html);
					if(html !=''){
						var lcity ="<?=$addr[0]['city']?>";
						//alert(lcity);
						$('#lcity').html(html);
						$("#lcity option[value='" + lcity + "']").attr("selected", "selected");	
					}else{
					  $('#lcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#lcity').html('<option value="">Select district first</option>');
		}
    });
    $(document).ready(function()
    {
		$('#date_of_birth')
			.datepicker({
				autoclose: true,
				format: 'dd-mm-yyyy'
			})
			.on('changeDate', function (e) {
				// Revalidate the date field
				$('#form').bootstrapValidator('revalidateField', 'date_of_birth');
			});
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
                        min: 1,
                        message: 'First name should be 2-50 characters'
                        }
                    }
                },
				mname:
                {
                    validators: 
                    {
                      /* notEmpty: 
                      {
                       message: 'Middle name should not be empty'
                      }, */
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Middle name should be alphabet characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 1,
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
				FacultyID:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Faculty id should not be empty'
                      }
                      
                    }
                },
				designation:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Designation should not be empty'
                      }
                      
                    }
                },
				date_of_birth:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Birth date should not be empty'
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
                      }
                    } 
                }, 
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
				emp_school:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'School should not be empty'
                      }
                    } 
                },
				department:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Department should not be empty'
                      }
                    } 
                },
				email_id:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Email should not be empty'
                      }
                    } 
                },
				 ta_applicable:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'TA Applicable should not be empty'
                      }
                    } 
                },
				ta_amount:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'TA Amount should not be empty'
                      }
                    } 
                },
				ta_tot_days:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'TA Total Days should not be empty'
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
				 bank_acc_no:
                {
                    validators: 
                    {
						/* notEmpty: 
                      {
                       message: 'Account no should not be empty'
                      }, */
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Account no should be numeric value'
                      },
                      stringLength: 
                        {
                        max: 20,
                        min: 2,
                        message: 'Account no should be 2-20 characters'
                        }
                    }
                },
                 ifsc_code:
                {
                    validators: 
                    {
						/* notEmpty: 
                      {
                       message: 'IFSC should not be empty'
                      }, */
                      regexp: 
                      {
                        regexp: /^[A-Z0-9/]+$/,
                        message: 'IFSC should be alpha numeric value'
                      },
                      stringLength: 
                        {
                        max: 11,
                        min: 11,
                        message: 'IFSC should be Exactly 11 characters'
                        }
                    }
                },
                acc_holder_name:
                {
                    validators: 
                    {
                      /* notEmpty: 
                      {
                       message: 'Account Holder Name should not be empty'
                      }, */
                      regexp: {
							regexp: /^[a-zA-Z\s]+$/,
							message: 'Account Holder Name should only contain alphabet characters and spaces'
						},
                      stringLength: 
                        {
                        max: 50,
                        min: 0,
                        message: 'Account Holder Name should be 0-50 characters'
                        }
                    }
                },
               /*  bank_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Bank Name should not be empty'
                      }
                    } 
                }, */
                  branch_name: {
						validators: {
							/* notEmpty: 
                      {
                       message: 'Branch name should not be empty'
                      }, */
							regexp: {
								regexp: /^[a-zA-Z ]+$/,
								message: 'Branch name should contain only alphabets and spaces'
							},
							stringLength: {
								min: 2,
								max: 100,
								message: 'Branch name should be 2-100 characters long'
							}
					}
				},

            }       
        })
		
});

</script>
<?php
$astrik = '<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Employee</a></li>
        <?php if (isset($emp[0]['inserted_by']) && $emp[0]['inserted_by'] == 1) { ?>
            <li class="active"><a href="#">Edit Faculty</a></li>	
        <?php } else { ?>
            <li class="active"><a href="#">Add New Faculty</a></li>
        <?php } ?>
    </ul>
    <div class="page-header">			
        <div class="row">
            <?php if (isset($emp[0]['inserted_by']) && $emp[0]['inserted_by'] == 1) { ?>
                <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Faculty Details</h1>
            <?php } else { ?>
                <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add New Faculty</h1>
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
                            <form id="form" name="form" action="<?= base_url($currentModule . '/insert_faculty') ?>" method="POST" enctype="multipart/form-data">
                                <div id="dashboard-recent" class="panel-warning">   
                                    <div class="panel">

                                        <?php if (isset($emp[0]['inserted_by']) && $emp[0]['inserted_by'] == 1) { ?>
                                            <div class="panel-heading"><strong>Edit Faculty Registration Form</strong></div>
                                        <?php } else { ?>
                                            <div class="panel-heading"><strong>New Faculty Registration</strong></div>
                                        <?php } ?>
                                        <div class="panel-body">
                                            <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                            <div class="panel-padding no-padding-vr">
                                                <div class="form-group">
                                                    <div class="clearfix">
                                                        <div class="row ">
                                                            <div class="col-md-12 col-sm-12">
                                                                <div class="portlet box red-sunglo">
                                                                    <div class="portlet-title">
                                                                        <div class="caption">
                                                                            <i class="fa fa-file"></i>Personal Details
                                                                        </div>

                                                                    </div>
                                                                    <div class="portlet-body">
                                                                        <div class="form-body">
                                                                            <input type="hidden" name="update_flg" value="<?= $update_flg ?>">
                                                                            <div class="form-group">
                                                                                <label class="col-md-3 control-label">Name:<?= $astrik ?></label>
                                                                                <div class="col-md-3">
                                                                                    <input class="form-control" data-bv-field="fname" id="fname"  name="fname" placeholder="First Name" value="<?= isset($emp[0]['fname']) ? $emp[0]['fname'] : '' ?>" type="text" >

                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <input class="form-control" name="mname" placeholder="MiddleName" value="<?= isset($emp[0]['mname']) ? $emp[0]['mname'] : '' ?>" type="text" >
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <input class="form-control" name="lname" placeholder="Last Name" value="<?= isset($emp[0]['lname']) ? $emp[0]['lname'] : '' ?>" type="text" >
                                                                                </div>
                                                                            </div>
																			<?php
																				if(isset($_REQUEST['id'])){
																					$readonly ="readonly";
																				}else{
																					$readonly ="readonly";
																				}
																			?>
                                                                            <div class="form-group">
                                                                                <label class="col-md-3 control-label">Faculty ID:<?= $astrik ?></label>
                                                                                <div class="col-md-3">
                                                                                    <input class="form-control" id="FacultyID" name="FacultyID" placeholder="Faculty ID" maxlength="7" value="<?= isset($emp[0]['emp_id']) ? $emp[0]['emp_id'] : $emp_new_id[0]['emp_id'] ?>" type="text" <?=$readonly?>>
                                                                                </div>
                                                                                <label class="col-md-3 control-label">Designation:<?= $astrik ?></label>
																				<div class="col-md-3">

																					<select class="select2me form-control" name="designation" id="designation" >
																						<option value="">Select</option>
																						<?php
																						foreach ($desig_list as $desig) {
																							if ($desig['designation_id'] == $emp[0]['designation']) {
																								$str = "selected";
																							} else {
																								$str = "";
																							}
																							echo "<option " . $str . " value=" . $desig['designation_id'] . ">" . $desig['designation_name'] . "</option>"
																							?>
																						<?php } ?>													
																					</select>
																				</div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="control-label col-md-3">Date of Birth:<?= $astrik ?></label>
                                                                                <div class="col-md-3">
                                                                                    <div class="input-group date" id="dob-datepicker">
                                                                                        <input class="form-control" id="date_of_birth" name="date_of_birth" readonly="" value="<?= isset($emp[0]['date_of_birth']) ? date('d-m-Y', strtotime($emp[0]['date_of_birth'])) : '' ?>" type="text">
                                                                                        <span class="input-group-btn">
                                                                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                                <label class="col-md-3 control-label">Gender:<?= $astrik ?></label>
                                                                                <div class="col-md-3">
                                                                                    <?php
                                                                                    $str1 = "";
                                                                                    if ($emp[0]['gender'] == 'male') {
                                                                                        $str = "checked";
                                                                                    } else {
                                                                                        $str1 = "checked";
                                                                                    }
                                                                                    ?>
                                                                                    <div class="col-sm-5"><input type="radio" <?= $str ?> name="gender" value="male">Male </div>
                                                                                    <div class="col-sm-5"><input type="radio" <?= $str1 ?> name="gender" value="female">Female </div>
                                                                                </div>
                                                                            </div>
																			<div class="form-group">
																			  <label class="col-sm-3">Mobile <?= $astrik ?></label>
																			  <div class="col-sm-3">
																				<input type="text" id="mobile" name="mobile" class="form-control numbersOnly" value="<?php if(!empty($emp[0]['mobile_no'])) { echo $emp[0]['mobile_no'];}?>" placeholder="contact no" maxlength="10" onblur="return chek_mob_exist(this.value)" required />
																			  </div>
																			  <label class="col-sm-3">Email <?= $astrik ?></label>
																			  <div class="col-sm-3">
																				<input type="email" id="email_id" name="email_id" class="form-control" value="<?php if(!empty($emp[0]['email_id'])) { echo $emp[0]['email_id'];}?>" placeholder="Email" />
																			  </div>
																			</div>
                                                                            <div class="form-group">
                                                                                <label class="col-md-3 control-label">Staff Type:<?= $astrik ?></label>
                                                                                <div class="col-md-3">
                                                                                    <select  class="form-control" name="staff_type" id="staff_type">
                                                                                        <option value="">Select</option>
                                                                                        <option value="Visiting" <?php if(!empty($emp[0]['staff_type']) && $emp[0]['staff_type'] =='Visiting') { echo 'selected';}?>>Visiting</option>
																						<option value="Guest" <?php if(!empty($emp[0]['staff_type']) && $emp[0]['staff_type'] =='Guest') { echo 'selected';}?>>Guest</option>
                                                                                    </select>
                                                                                </div>
                                                                                <label class="col-md-3 control-label">Blood Group:<?= $astrik ?></label>
                                                                                <div class="col-md-3">
                                                                                    <select  class="form-control" name="blood_gr" id="blood_gr">
                                                                                        <option value="">Select</option>
                                                                                        <?php
                                                                                        $str = $str1 = $str2 = $str3 = $str4 = $str5 = $str6 = $str7 = $str8 = $str9 = $str10 = $str11 = $str12 = "";
                                                                                        if ($emp[0]['blood_gr'] == 'A+') {
                                                                                            $str = "selected";
                                                                                        } elseif ($emp[0]['blood_gr'] == 'A-') {
                                                                                            $str1 = "selected";
                                                                                        } elseif ($emp[0]['blood_gr'] == 'A') {
                                                                                            $str2 = "selected";
                                                                                        } elseif ($emp[0]['blood_gr'] == 'B+') {
                                                                                            $str3 = "selected";
                                                                                        } elseif ($emp[0]['blood_gr'] == 'B-') {
                                                                                            $str4 = "selected";
                                                                                        } elseif ($emp[0]['blood_gr'] == 'B') {
                                                                                            $str5 = "selected";
                                                                                        } elseif ($emp[0]['blood_gr'] == 'AB+') {
                                                                                            $str6 = "selected";
                                                                                        } elseif ($emp[0]['blood_gr'] == 'AB-') {
                                                                                            $str7 = "selected";
                                                                                        } elseif ($emp[0]['blood_gr'] == 'AB') {
                                                                                            $str8 = "selected";
                                                                                        } elseif ($emp[0]['blood_gr'] == 'O+') {
                                                                                            $str9 = "selected";
                                                                                        } elseif ($emp[0]['blood_gr'] == 'O-') {
                                                                                            $str10 = "selected";
                                                                                        } elseif ($emp[0]['blood_gr'] == 'O') {
                                                                                            $str11 = "selected";
                                                                                        } elseif ($emp[0]['blood_gr'] == 'Unknown') {
                                                                                            $str12 = "selected";
                                                                                        }
                                                                                        ?>
                                                                                        <option <?= $str ?> value="A+">A Positive</option>
                                                                                        <option <?= $str1 ?> value="A-">A Negative</option>
                                                                                        <option <?= $str2 ?> value="A">A Unknown</option>
                                                                                        <option <?= $str3 ?> value="B+">B Positive</option>
                                                                                        <option <?= $str4 ?> value="B-">B Negative</option>
                                                                                        <option <?= $str5 ?> value="B">B Unknown</option>
                                                                                        <option <?= $str6 ?> value="AB+">AB Positive</option>
                                                                                        <option <?= $str7 ?> value="AB-">AB Negative</option>
                                                                                        <option <?= $str8 ?> value="AB">AB Unknown</option>
                                                                                        <option <?= $str9 ?> value="O+">O Positive</option>
                                                                                        <option <?= $str10 ?> value="O-">O Negative</option>
                                                                                        <option <?= $str11 ?> value="O">O Unknown</option>
                                                                                        <option <?= $str12 ?> value="Unknown">Unknown</option>
                                                                                    </select> 
                                                                                </div>												
                                                                            </div>
																			<div class="form-group">
																				<label class="col-md-3 control-label">School:<?= $astrik ?></label>
																				<div class="col-md-3">

																					<select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="emp_school" >
																						<option value="">Select School</option>
																						<?php
																						foreach ($school_list as $sc) {
																							if ($sc['college_id'] == $emp[0]['emp_school']) {
																								$str = "selected";
																							} else {
																								$str = "";
																							}
																							echo "<option " . $str . " value=" . $sc['college_id'] . ">" . $sc['college_name'] . "</option>"
																							?>
																				<?php } ?>
																					</select>
																				</div>
																				<label class="col-md-3 control-label">Department:<?= $astrik ?></label>
																				<div class="col-md-3">
																					<select class="form-control select2me" id="department"  name="department" >
																						<option value="">Select</option>
																						<?php
																						if (!empty($emp[0]['emp_school'])) {
																							$dept_list = $this->Admin_model->getDepartmentListById($emp[0]['emp_school']);
																							foreach ($dept_list as $dept) {
																								if ($dept['department_id'] == $emp[0]['department']) {
																									$str = "selected";
																								} else {
																									$str = "";
																								}
																								echo "<option " . $str . " value=" . $dept['department_id'] . ">" . $dept['department_name'] . "</option>";
																							}
																						}
																						?>

																					</select>
																				</div>												
																			</div>
                                                                            <div class="form-group">
                                                                                <label class="col-md-3 control-label">PAN No:</label>
																				<div class="col-md-3">
																					<input type="text" class="form-control" name="pan_no" id="pan_no" placeholder="PAN No." value="<?=isset($emp[0]['pan_card_no'])?$emp[0]['pan_card_no']:''?>" >
																				</div>
                                                                                <label class="col-md-3 control-label">Aadhar No:</label>
                                                                                <div class="col-md-3">
                                                                                    <input class="form-control" name="adhar_no" placeholder="Aadhar No" value="<?= isset($emp[0]['adhar_no']) ? $emp[0]['adhar_no'] : '' ?>" type="text">	
                                                                                </div>
                                                                            </div>	  
                                                                            <div class="form-group">
                                                                                <label class="control-label col-md-3">Category:</label>
                                                                                <div class="col-md-3">
                                                                                    <div class="input-group date" id="dob-datepicker">
                                                                                        <select id="category" name="category" class="form-control"><option value="">Select</option>
																						<?php
																						foreach ($category as $category) {
																							if ($category['caste_code'] == $emp[0]['category']) {
																								$sel = "selected";
																							} else {
																								$sel = '';
																							}
																							echo '<option value="' . $category['caste_code'] . '" ' . $sel . '>' . $category['caste_name'] . '</option>';
																						}
																						?>

                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <label class="col-md-3 control-label">Cast:</label>
                                                                                <div class="col-md-3">
                                                                                    <input class="form-control" name="cast" placeholder="cast" value="<?= isset($emp[0]['cast']) ? $emp[0]['cast'] : '' ?>" type="text">	
                                                                                </div>
                                                                            </div>
																			<div class="form-group">
                                                                                <label class="col-md-3 control-label">Punching Applicable:</label>
                                                                                <div class="col-md-3">
                                                                                    <?php
                                                                                    $str1 = "";
                                                                                    if ($emp[0]['punching_applicable'] == 'Y') {
                                                                                        $str = "checked";
                                                                                    } else {
                                                                                        $str1 = "checked";
                                                                                    }
                                                                                    ?>
                                                                                    <div class="col-sm-5"><input type="radio" <?= $str ?> name="punching_applicable" value="Y">YES </div>
                                                                                    <div class="col-sm-5"><input type="radio" <?= $str1 ?> name="punching_applicable" value="N">NO </div>
                                                                                </div>
																				
																				<label class="col-md-3 control-label">Is Payable:</label>
                                                                                <div class="col-md-3">
                                                                                    <?php
                                                                                    $str3 = "";
                                                                                    if ($emp[0]['is_payable'] == 'Y') {
                                                                                        $str2 = "checked";
                                                                                    } else {
                                                                                        $str3 = "checked";
                                                                                    }
                                                                                    ?>
                                                                                    <div class="col-sm-5"><input type="radio" <?= $str2 ?> name="is_payable" value="Y">YES </div>
                                                                                    <div class="col-sm-5"><input type="radio" <?= $str3 ?> name="is_payable" value="N">NO </div>
                                                                                </div>

                                                                            </div>
																			
																			<div class="form-group">
                                                                                <label class="col-md-3 control-label">Paying Type:</label>
                                                                                <div class="col-md-3">
                                                                                    
                                                                                    
																					<select name="pay_type" id="pay_type" class="form-control">
																						<option value="">--Select--</option>
																						<option value="hourly" <?php if($emp[0]['pay_type']=='hourly'){ echo "selected";}?>>Per Hour</option>
																						<option value="consolidated" <?php if($emp[0]['pay_type']=='consolidated'){ echo "selected";}?>>Consolidated</option>
																					</select>
																					
                                                                                </div>
																				<div id="amt_per_hr1">
																				<label class="col-md-3 control-label">Amount per hour:</label>
                                                                                <div class="col-md-3">
																				<input type="number" <?= $str2 ?> name="amount_per_hour" id="amt_per_hr" class="form-control" value="<?= isset($emp[0]['amount_per_hour']) ? $emp[0]['amount_per_hour'] : '' ?>">
                                                                                    
                                                                                </div>
</div>
                                                                            </div>
																																								<div class="form-group">
                                                                                <label class="col-md-3 control-label">TA Applicable:<?= $astrik ?></label>
                                                                                <div class="col-md-3">
                                                                                    
                                                                                    
																					<select name="ta_applicable" id="ta_applicable" class="form-control" >
																						<option value="">--Select--</option>
																						<option value="Y" <?php if($emp[0]['ta_applicable']=='Y'){ echo "selected";}?>>Yes</option>
																						<option value="N" <?php if($emp[0]['ta_applicable']=='N'){ echo "selected";}?>>No</option>
																					</select>
																					
                                                                                </div>
                                                                                </div>
																				<div class="form-group">
																				<div id="ta_amt">
																				<label class="col-md-3 control-label">Rate Of TA<?= $astrik ?></label>
                                                                                <div class="col-md-3">
																				<input type="number" <?= $str2 ?> name="ta_amount" id="ta_amount" class="form-control" value="<?= isset($emp[0]['ta_amount']) ? $emp[0]['ta_amount'] : '' ?>">
                                                                                </div>
																				<label class="col-md-3 control-label">Total TA Days<?= $astrik ?></label>
                                                                                <div class="col-md-3">
																				<input type="number" <?= $str2 ?> name="ta_tot_days" id="ta_tot_days" class="form-control" value="<?= isset($emp[0]['ta_tot_days']) ? $emp[0]['ta_tot_days'] : '' ?>">
                                                                                </div>
                                                                               </div>
                                                                            </div>
                                                                        <div class="form-group">
																			<label class="col-md-3 control-label">No of Lecture:</label>
                                                                                <div class="col-md-3">
																				<input type="number" <?= $str2 ?> name="no_of_lectures" id="no_of_lectures" class="form-control" value="<?= isset($emp[0]['no_of_lectures']) ? $emp[0]['no_of_lectures'] : '' ?>" onblur="calculate_total_amount()">
                                                                                    
                                                                                </div>

                                                                                <label class="col-md-3 control-label">Amount Payable:</label>
                                                                                
                                                                                <div class="col-md-3">
																				<input type="text" <?= $str2 ?> name="amount_payable" id="amount_payable" class="form-control" value="<?= isset($emp[0]['amount_payable']) ? $emp[0]['amount_payable'] : '' ?>" readonly>
                                                                                    
                                                                                </div>

                                                                            </div>
																			
                                                                            <div class="form-group">
                                                                                <label class="control-label col-md-3">Sub-Cast:</label>
                                                                                <div class="col-md-3">
                                                                                    <div class="input-group date" id="dob-datepicker">
                                                                                        <input class="form-control" name="sub-cast" placeholder="sub-cast" value="<?= isset($emp[0]['sub-cast']) ? $emp[0]['sub-cast'] : '' ?>" type="text">
                                                                                    </div>
                                                                                </div>
																				<label class="col-md-3">Upload Photo:</label>
																				<?php
																				if (!empty($emp[0]['profile_photo'])) {
																					$profile = base_url() . "uploads/employee_profilephotos/" . $emp[0]['profile_photo'];
																				} else {
																					$profile = base_url() . "uploads/noimage.png";
																				}
																				?>
                                                                                <div class="col-md-3">
																				<div class="col-sm-3">
                                                                                        <input type="file" id="profile_img" name="profile_img" value="<?= isset($emp[0]['profile_photo']) ? $emp[0]['profile_photo'] : '' ?>" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" >
                                                                                    </div>
																					<div class="col-sm-3">&nbsp;</div>
                                                                                    <div class="col-sm-3"><br><br>
                                                                                        <img id="blah" alt="" src="<?php echo $profile; ?>"width="100" height="100" border="1px solid black" />
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
												<div class="portlet box red-sunglo">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-chain"></i>Other Details
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
																		 <select name="bank_name" id="bank_name" class="form-control" >
																		 <option value="">Select Bank</option>
																		<?php foreach($bank_list as $ba ){
																	if($ba['bank_id']==$emp[0]['bank_id']){
																		$str="selected";
																	}else{$str="";}
																	echo "<option ".$str." value=".$ba['bank_id'].">".$ba['bank_name']."</option>"?>
																<?php } ?>
																</select>
																	</div>
																</div> 
																<div class="form-group">
																<label class="col-md-3 control-label">Account HolderName:<?=$astrik?></label>
																	<div class="col-md-3">
																	<input type="text" class="form-control" name="acc_holder_name" id="acc_holder_name" placeholder="Account Holder Name" value="<?= isset($emp[0]['acc_holder_name']) && !empty($emp[0]['acc_holder_name']) ? $emp[0]['acc_holder_name'] : (!empty($emp[0]['fname']) ? (!empty($emp[0]['mname']) ? $emp[0]['fname'] . ' ' . $emp[0]['mname'] . ' ' . $emp[0]['lname'] : $emp[0]['fname'] . ' ' . $emp[0]['lname']) : '') ?>">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-3 control-label">Branch Name:<?=$astrik?></label>
																	<div class="col-md-3">
																		<input type="text" class="form-control" name="branch_name" id="branch_name" placeholder="Branch Name" value="<?=isset($emp[0]['branch_name'])?$emp[0]['branch_name']:''?>" >
																	</div>
															<label class="col-md-3 control-label">IFSC Code:<?=$astrik?></label>
															<div class="col-md-3">
															<input type="text" class="form-control" name="ifsc_code" id="ifsc_code" placeholder="IFSC Code" value="<?=isset($emp[0]['ifsc_code'])?$emp[0]['ifsc_code']:''?>" >
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
                                                                            <i class="fa fa-save"></i>Address Details 
                                                                        </div>

                                                                    </div>
                                                                    <div class="portlet-body">

                                                                        <div class="form-body">
                                                                            <table class="table table-bordered">
                                                                                <tr><th>Local Address:<?= $astrik ?></th>
                                                                                   
                                                                                <tr>
                                                                                    <!--Local Address-->
                                                                                    <td width="100%">
                                                                                        <div class="form-group">
																						<label  class="col-sm-3">Address: <?=$astrik?></label>
																						<div class="col-sm-3">
																						  <textarea id="laddress" class="form-control" NAME="laddress" style="" required><?php if(!empty($addr[0]['address'])){ echo $addr[0]['address'];}?></textarea>
																						</div>
																					  </div>

																					  <div class="form-group">
																						<label  class="col-sm-3">State: <?=$astrik?></label>
																						<div class="col-sm-3">
																						  <select class="form-control" name="lstate_id" id="lstate_id" required>
																							  <option value="">select State</option>
																							  <?php
																								if(!empty($states)){
																									foreach($states as $stat){
																										if($stat['state_id'] == $addr[0]['state_id']){
																											$sel= "selected";
																										}else{
																											$sel="";
																										}
																										
																										?>
																									  <option value="<?=$stat['state_id']?>" <?=$sel?>><?=$stat['state_name']?></option>  
																									<?php 
																										
																									}
																								}
																							  ?>
																						  </select>
																						</div>
																						<label  class="col-sm-3">District: <?=$astrik?></label>
																						<div class="col-sm-3">
																						  <select class="form-control" name="ldistrict_id" id="ldistrict_id" required>
																							  <option value="">select District</option>
																						  </select>
																						</div>
																					  </div>
																					 
																					  <div class="form-group">
																						<label  class="col-sm-3">City: <?=$astrik?></label>
																						<div class="col-sm-3">
																						   <select class="form-control" name="lcity" id="lcity" required>
																							  <option value="">select City</option>
																						  </select>
																						</div>
																						<label  class="col-sm-3">Pin Code: <?=$astrik?></label>
																						<div class="col-sm-3">
																						  <INPUT TYPE="TEXT" class="form-control numbersOnly" id="lpincode" maxlength="6" NAME="lpincode" value="<?php if(!empty($addr[0]['pincode'])){ echo $addr[0]['pincode'];}?>" required>
																						</div>
																					  </div>
																					  
                                                                                    </td>
                                                                                    <!--Permanent Address-->
                                                                                    </tr>
																					<?php
																					if ($emp[0]['same'] == "on") {
																						$val = "checked";
																					} else {
																						$val = "";
																					}
																					?>
                                                                                    <!--<tr><td><label style="text-align:left"><input name="same" <?php echo $val; ?> onclick="copyBilling (this.form) " type="checkbox">Permanent Address is Same as Local Address</label></td></tr>-->
                                                                            </table>
                                                                            
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="clearfix">

                                                            <div class="form-actions">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-md-3">
																				<?php if (!empty($emp[0]['emp_id'])) { ?>
                                                                                    <button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Update </button>
																					<?php } else { ?>
                                                                                    <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit </button>
																					<?php } ?>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <a class="btn btn-primary form-control" id="btn_submit" type="submit" href="<?php echo base_url() . 'Faculty/visitor_list' ?>">Go Back </a>
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
    $(document).ready(function () {
		//$("#ta_amt").addClass('hidden');
        $('#date_of_birth').datepicker({format: 'dd-mm-yyyy', autoclose: true});
        $('#dob-datepicker1').datepicker({format: 'dd-mm-yyyy', autoclose: true});
        $('#intime').timepicker({autoclose: true});
        $('#outtime').timepicker({autoclose: true});
		
		 var bv = $('#form').data('bootstrapValidator'); 
		var taappl = "<?=$emp[0]['ta_applicable']?>";

			if (taappl === 'Y') {
			
				bv.enableFieldValidators('ta_amount', true);
				bv.enableFieldValidators('ta_tot_days', true);
				$("#ta_amt").removeClass('hidden');
			} else {
		         $('#ta_amount').val('');  
		         $('#ta_tot_days').val('');  
				bv.enableFieldValidators('ta_amount', false);
				bv.enableFieldValidators('ta_tot_days', false);
				$("#ta_amt").addClass('hidden');
			}
    });
</script>
<script type="text/javascript">

 $('#pay_type').on('change', function () {
		// alert('inside');
		var nat= $('#pay_type').val();
		if(nat=='hourly'){
			//alert("i");
			$('#amount_payable').prop('readonly',true);			
			$("#amt_per_hr1").removeClass('hidden');
		} 
		else{
			
		//alert("international");
			$('#amount_payable').prop('readonly',false);
			$("#amt_per_hr1").addClass('hidden');
			
		}
	 }); 
	 
	 $('#ta_applicable').on('change', function () {
		 var bv = $('#form').data('bootstrapValidator'); 
		var taappl= $('#ta_applicable').val();
		if (taappl === 'Y') {
			
				bv.enableFieldValidators('ta_amount', true);
				bv.enableFieldValidators('ta_tot_days', true);
				$("#ta_amt").removeClass('hidden');
			} else {
		      $('#ta_amount').val('');  
		      $('#ta_tot_days').val('');  
				bv.enableFieldValidators('ta_amount', false);
				bv.enableFieldValidators('ta_tot_days', false);
				$("#ta_amt").addClass('hidden');
			}
	 });
	 function calculate_total_amount()
	 {
		 var nat= $('#pay_type').val();
		 var amt_per_hr= $('#amt_per_hr').val();
		 var no_of_lectures= $('#no_of_lectures').val();
		//alert(amt_per_hr);alert(no_of_lectures);
		 if(nat=='hourly'){
			 var amt_payable = parseInt(amt_per_hr) * parseInt(no_of_lectures);
			 //alert(amt_payable);
			 $('#amount_payable').val(amt_payable);
		 }else{
			$('#amount_payable').prop('readonly',false); 
		 }
		 
	 }
	 var nat = "<?=$emp[0]['pay_type']?>";
	if(nat=='hourly'){
			//alert("i");
			$('#amount_payable').prop('readonly',true);			
			$("#amt_per_hr1").removeClass('hidden');
		} 
		else{
			
		//alert("international");
			$('#amount_payable').prop('readonly',false);
			$("#amt_per_hr1").addClass('hidden');
			
		}
		
		
// -->
</script>