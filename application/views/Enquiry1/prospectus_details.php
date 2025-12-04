<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<link href="<?= site_url() ?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?= site_url() ?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style type="text/css">
  .panel-warning .panel-heading .panel-title {
    color: #000 !important;
    font-weight: 400 !important;
  }

  .panel-body {
    background: #f1f7fb !important;

  }


  .btn-info {
    color: #fff;
    border-radius: 30px !important;
  }

  .panel {
    background-color: #f1f7fb !important
  }

  .form-control {
    box-shadow: 1px 1px 5px #ccc !important;
  }

  .testtiltle {
    font-size: 14px !important;
    font-weight: 600 !important;
    margin-top: 5px !important;
    margin-bottom: 0px !important;
  }

  input[type=checkbox],
  input[type=radio] {
    margin: 2px 0 0;
    line-height: normal;
  }

  fieldset.scheduler-border {
    border: 1px solid #1d89cf !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow: 0px 0px 0px 0px #000;
    box-shadow: 0px 0px 0px 0px #0000;
  }

  border-top-color: #dadada;
  -webkit-box-shadow: none;
  box-shadow: 1px 1px 1px #ccc;

  legend.scheduler-border {
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;
    width: auto;
    padding: 0 10px;
    border-bottom: none;
  }

  .theme-default .bordered,
  .theme-default .panel,
  .theme-default .table,
  .theme-default hr {
    border-color: #ffffff;
  }

  .tab-content {
    padding: 0px 0;
  }

  .panel-heading {
    background: #fffdf0;
    border: 2px solid #f4b04f;
    padding-bottom: 2px;
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 11px;
    position: relative;
  }

  .panel-heading {
    background: #f1f7fb !important;
    border: 1px solid #1d89cf;
    padding-bottom: 2px;
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 11px;
    position: relative;
  }

  .h3,
  h3 {
    color: #666;
    font-size: 18px;
    font-weight: 300;
    line-height: 30px;
  }

  legend {
    color: #e12503 !important;
  }

  legend.scheduler-border {
    font-size: 18px !important;
    font-weight: 600 !important;
    text-align: left !important;
    width: auto;
    padding: 0 10px;
    border-bottom: none;
  }

  fieldset.scheduler-border:hover {
    border: solid 1px #f6deac !important;

  }

  .form-control {
    height: 26px;
    padding: 0px 12px;
    margin-left: 10px;
    width: 95%;
  }
</style>
<?php
$role_id = $this->session->userdata('role_id');
?>
<script>
  var fno = '20R01';
  $(document).ready(function() {

  });
</script>
<?php
$astrik = '<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
  <ul class="breadcrumb breadcrumb-page">
    <div class="breadcrumb-label text-light-gray">You are here: </div>
    <li><a href="#">Student</a></li>
    <li class="active"><a href="#">Enquiry</a></li>
  </ul>
  <div class="row">
    <div class="col-xs-12 col-sm-8">
      <div class="row">
        <hr class="visible-xs no-grid-gutter-h">
      </div>
    </div>
  </div>
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Enquiry</h1>
      <div class="col-xs-12 col-sm-8">
        <div class="row">
          <hr class="visible-xs no-grid-gutter-h">
        </div>
      </div>
    </div>

    <div class="row " style="margin-top:10px;">
      <div class="form-group">
        <div class="col-sm-12">
          <div class="panel-heading">
            <!--form method="post" action=""-->
            <div class="row" style="padding-bottom:4px;">

              <div class="hidden">
                <!--<div class="col-sm-2 from-group">
					 
                        <h4 class="testtiltle" >Search By Mobile:</h4>
                     </div>
                     <div class="col-sm-5"><input type="text" name="mobile_search" id="mobile_search" class="form-control numbersOnly" maxlength="10"  title="Enter your mobile number" value="<?php if ($mobilnparamer) {
                                                                                                                                                                                                  echo $mobilnparamer;
                                                                                                                                                                                                } ?>"></div>-->

                <div class="col-sm-1">
                  <h4 class="testtiltle">Enquiry&nbsp;No: </h4>
                </div>

                <div class="col-sm-2"><input type="text" name="Enquiry_search" id="Enquiry_search" class="form-control" title="Enter your Enquiry No" value="<?php if ($enquiryparamer) {
                                                                                                                                                                echo $enquiryparamer;
                                                                                                                                                              } ?>"></div>
              </div>
              <div class="col-sm-1">
                <h4 class="testtiltle">Aadhaar&nbsp;No: </h4>
              </div>
              <div class="col-sm-4"><input type="text" maxlength=12 pattern=".{12,}" name="adhar_search" id="adhar_search" class="form-control numbersOnly" title="Enter your Aadhaar No" value="" placeholder="Enter Aadhaar No" onkeyup="aadharValidation111();"></div>
              <input type="hidden" name="user_id" id="user_id" value="<?= $check_id_in_ic; ?>">
              <div class="col-sm-1">
                <h4 class="testtiltle">Mobile&nbsp;No: </h4>
              </div>
              <div class="col-sm-3"><input type="text" name="mobile_search" id="mobile_search" class="form-control numbersOnly" maxlength="10" title="Enter your mobile number" placeholder="Enter your mobile number" value="<?php if ($mobilnparamer) {
                                                                                                                                                                                                                                echo $mobilnparamer;
                                                                                                                                                                                                                              } ?>"></div>
              <div class="col-sm-1"><input type="button" value="Search" class="btn btn-info" id="btnsearch"></div>

            </div>

            <!--<div class="row"><div class="form-group" id="returnMessagenew"></div></div>-->
            <div id="returnMessage"></div>
            <div> <?php if (isset($validation_errors)) { ?>
                <span style='color:red;'><?php echo $validation_errors;  ?></span> <?php } ?>
              <?php
              $v = $this->session->flashdata('message_name');

              if (isset($v)) { ?>
                <span style='color:red;'><?php echo $v;  ?></span> <?php } ?>
            </div>
            <!--/form-->
          </div>
        </div>
      </div>
    </div>
    <div class="row" id="show_form_msg" style="display:none;">
      <div class="col-sm-12">
        <div id="dashboard-recent" class="panel">
          <span style="color:red; padding-left:110px;" id="sm">
            << /span>
        </div>
      </div>
    </div>
    <div class="row" id="show_form" style="display:none;">
      <div class="col-sm-12">
        <div id="dashboard-recent" class="panel ">
          <div class="tab-content">
            <span style="color:red; padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
            <div id="personal-details" class="widget-comments panel-body tab-pane fade active in">
              <div class="">
                <form id="form" name="form" action="<?= base_url('StudentRegistration/Enquiry_insert') ?>" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
                  <input type="hidden" id="enquiry_id" name="enquiry_id" class="form-control" value="" />
                  <input type="hidden" name="user_id" id="user_id" value="<?= $check_id_in_ic; ?>">

                  <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Program Details:</legend>
                    <div class="form-group">
                      <label class="col-sm-1">Last&nbsp;Exam<?= $astrik ?></label>
                      <div class="col-sm-3">
                        <select id="last_qualification" name="last_qualification" class="form-control" required="required">
                          <option value="">Select Highest Qualification</option>
                          <option value="SSC" <?php
                                              if (isset($stud->last_qualification) && !empty($stud->last_qualification) && $stud->last_qualification == "SSC") {
                                                echo "selected";
                                              }
                                              ?>> SSC </option>
                          <option value="HSC" <?php
                                              if (isset($stud->last_qualification) && !empty($stud->last_qualification) && $stud->last_qualification == "HSC") {
                                                echo "selected";
                                              }
                                              ?>> HSC </option>
                          <option value="UG" <?php
                                              if (isset($stud->last_qualification) && !empty($stud->last_qualification) && $stud->last_qualification == "UG") {
                                                echo "selected";
                                              }
                                              ?>> UG Degree </option>
                          <option value="PG" <?php
                                              if (isset($stud->last_qualification) && !empty($stud->last_qualification) && $stud->last_qualification == "PG") {
                                                echo "selected";
                                              }
                                              ?>> PG Degree </option><!--afterDP-->
                          <option value="Diploma" <?php
                                                  if (isset($stud->last_qualification) && !empty($stud->last_qualification) && $stud->last_qualification == "Diploma") {
                                                    echo "selected";
                                                  }
                                                  ?>> Diploma (Direct Second Year)</option>
                        </select>
                      </div>
                      <label class="col-sm-1">Percents%</label>
                        <div class="col-sm-3">
                          <input 
                            type="text" id="qualification_percentage" name="qualification_percentage" class="form-control" placeholder="" maxlength="6" oninput="validatePercentage(this)" 
                          />
                        </div>

                        <script>
                          function validatePercentage(input) {
                            let value = input.value;

                            value = value.replace(/[^0-9.]/g, '');

                            value = value.replace(/^([^\.]*\.[0-9]{0,2}).*$/, '$1');

                            const parts = value.split('.');

                            if (parts.length > 2) {
                              value = parts[0] + '.' + parts[1];
                            }

                            if (parseFloat(value) > 100) {
                              value = '0';
                            }

                            input.value = value;
                          }
                        </script>

                      <label class="col-sm-1">&nbsp;Type<?= $astrik ?></label>
                      <div class="col-sm-3">
                        <select name="admission_type" id="admission_type" class="form-control" onchange="get_fees_value(this.value,1)" required="required">
                          <option value="">Select Type</option>
                          <option value="1">First Year</option>
                          <option value="2">Lateral Entry</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-1">Campus City <?= $astrik ?> </label>
                      <div class="col-sm-3">
                        <select class='form-control' name='Campus_City' id='Campus_City'> <!--onChange="get_school(this.value);"-->
                          <option value=''>Select City</option>
                          <option value='1'>Nashik</option>
                          <option value='2'>Sijoul</option>

                        </select>
                      </div>

                      <label class="col-sm-1">Organization Name <?= $astrik ?> </label>
                      <div class="col-sm-3">
                        <select class='form-control' name='Campus' id='Campus'>
                          <option value=''>Select Campus</option>
                          <option value='SF'>Sandip Foundation</option>
                          <option value='SUN'>Sandip University</option>

                        </select>
                      </div>
                      <!--<label class="col-sm-3">School Name <?= $astrik ?></label>
					<div class="col-sm-3">
					<select type="text" name="school_name" id="school_name" class="form-control">
					<option value="">SELECT</option>
					</select>
					</div>-->
                    </div>

                    <div class="hidden" id="old_data">
                      <div class="form-group" ?>
                        <label class="col-sm-1" id="set_data">Select School<?= $astrik ?></label>
                        <div class="col-sm-3">
                          <select type="text" name="school_name" id="school_name" class="form-control">
                            <option value="">SELECT</option>
                          </select>
                        </div>

                        <label class="col-sm-1">Programme Type <?= $astrik ?></label>
                        <div class="col-sm-3"><select name="CoursesType" id="CoursesType" class="form-control">
                            <option value="">Select Type</option>
                          </select></div>

                        <label class="col-sm-1">Courses <?= $astrik ?></label>
                        <div class="col-sm-3"><select name="Courses" id="Courses" class="form-control">
                            <option value="">Select Courses</option>
                          </select></div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-1">Stream <?= $astrik ?></label>
                        <div class="col-sm-3"><select name="stream_id" id="stream_id" class="form-control">
                            <option value="">Select Stream</option>
                          </select></div>
                      </div>
                    </div>

                    <!--<div class="form-group hidden"  id="university_data">
                     <label class="col-sm-1">School<?= $astrik ?></label>
                     <div class="col-sm-3"><select id="school_id" name="school_id" class="form-control" onChange="load_courses(this.value)" ></select></div>
                     <label class="col-sm-1">Course<?= $astrik ?></label>
                     <div class="col-sm-3"> <select id="course_id" name="course_id" class="form-control" onChange="load_streams(this.value)" ></select>
                     </div>
                     <label class="col-sm-1">Stream<?= $astrik ?></label>
                     <div class="col-sm-3">
                     <select id="stream_id" name="stream_id" class="form-control"  onChange="get_fees_value(this.value,0)" ></select>
                     </div>
                     </div>-->

                    <div class="form-group hidden">
                      <label class="col-sm-1">Total Fees</label>
                      <div class="col-sm-3"><input type="text" id="actual_fee" name="actual_fee" readonly class="form-control col-sm-3" value="<?php
                                                                                                                                                if (isset($stud->actual_fee) && !empty($stud->actual_fee)) {
                                                                                                                                                  echo $stud->actual_fee;
                                                                                                                                                } ?>"></div>
                      <label class="col-sm-1">Tution&nbsp;Fees</label>
                      <div class="col-sm-3">
                        <input type="text" id="tution_fees" name="tution_fees" readonly class="form-control col-sm-3" value="<?php
                                                                                                                              if (isset($stud->tution_fees) && !empty($stud->tution_fees)) {
                                                                                                                                echo $stud->tution_fees;
                                                                                                                              } ?>">
                      </div>
                    </div>

                    <div class="form-group hidden">

                      <label class="col-sm-1">Renumeration amount&nbsp;<?= $astrik ?></label>
                      <div class="col-sm-3">
                        <input type="number" id="renumeration_amount" name="renumeration_amount" class="form-control" placeholder="Renumeration amount" value=0 maxlength="5" />
                      </div>
                  </fieldset>

                  <fieldset class="scheduler-border">
                    <!--<b style="color:red">Note: Enter Proper student details</b>-->
                    <legend class="scheduler-border">Student Details</legend>
                    <div class="form-group enquiry_no">
                      <label class="col-sm-1">Enquiry&nbsp;No</label>
                      <div class="col-sm-3"><input type="text" id="enquiry_no" name="enquiry_no" class="form-control enquiry_no" value="" readonly="readonly" required="required" /></div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-1">First&nbsp;Name&nbsp;<?= $astrik ?></label>
                      <div class="col-sm-3"><input type="text" id="first_name" name="first_name" class="form-control" placeholder="First&nbsp;Name" required="required" pattern="^[A-Za-z][A-Za-z0-9!@#$%^&amp;* ]*$" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '').replace(/(\..*?)\..*/g, '$1');" title="Full Name should only letters. e.g. john" /></div>
                      <label class="col-sm-1">Middle&nbsp;Name&nbsp;</label>
                      <div class="col-sm-3">
                        <input type="text" id="middle_name" name="middle_name" class="form-control" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Middle&nbsp;Name" pattern="^[A-Za-z][A-Za-z0-9!@#$%^&amp;* ]*$" title="Full Name should only letters. e.g. john" />
                      </div>
                      <label class="col-sm-1">Last&nbsp;Name&nbsp;<?= $astrik ?></label>
                      <div class="col-sm-3">
                        <input type="text" id="last_name" name="last_name" class="form-control" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Last&nbsp;Name" required="required" pattern="^[A-Za-z][A-Za-z0-9!@#$%^&amp;* ]*$" title="Full Name should only letters. e.g. john" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-1">Email&nbsp;<?= $astrik ?></label>
                      <div class="col-sm-3"><input type="email" required="required" id="email_id" name="email_id" class="form-control" placeholder="Email" />
                        <div class="email_id_msg"></div>

                      </div>
                      <label class="col-sm-1">Mobile&nbsp;<?= $astrik ?></label>
                      <div class="col-sm-3">
                        <input type="text" id="mobile" name="mobile" class="form-control" placeholder="mobile" required="required" maxlength="10" pattern="[0-9]+" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                        <div class="mobile_msg"></div>
                      </div>

                      <label class="col-sm-1">Alternate&nbsp;No&nbsp;</label>
                      <div class="col-sm-3">
                        <input type="text" id="altarnet_mobile" name="altarnet_mobile" class="form-control" maxlength="10" placeholder="Alternate&nbsp;No" pattern="[0-9]+" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                        <div class="altarnet_mobile_msg"></div>

                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-1">Nationality<?= $astrik ?></label>
                      <div class="col-sm-3">
                        <div class="">
                          <label class="radio-container m-r-45">Indian
                            <input type="radio" name="nationality" id="nationality" value="1" required="required" checked onclick="handleClick(this);">
                          </label>
                          <label class="radio-container">Others
                            <input type="radio" name="nationality" id="nationality" value="2" onclick="handleClick(this);">
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group hidden" id="others_add">
                      <label class="col-sm-1"> Country <?= $astrik ?></label>
                      <div class="col-sm-3"><!--  onchange="getstatesbycountry(this.value)"  -->
                        <select id="int_country_id" name="int_country_id" class="form-control">
                          <option value="">--Select--</option>
                          <?php

                          foreach ($countries_list as $val) {
                            if ($userinfo[0]['country'] == $val['id']) {
                              $st = 'selected';
                            } else {
                              $st = '';
                            }
                            if ($val['id'] != 101) {
                              echo "<option $st value='" . $val['id'] . "' data-myval='" . $val['phonecode'] . "'>" . $val['name'] . "</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <label class="col-sm-1">State<?= $astrik ?></label>
                      <div class="col-sm-3">
                        <select id="int_state" name="int_state" class="form-control">
                          <option value="">Select</option>
                        </select>
                      </div>
                      <label class="col-sm-1">City<?= $astrik ?></label>
                      <div class="col-sm-3">
                        <select id="int_city" name="int_city" class="form-control">
                          <option value="">Select</option>
                        </select>
                      </div>
                      <div class='form-group'></div>
                      <label class="col-sm-1">Citizen-Ship-id<?= $astrik ?></label>
                      <div class="col-sm-3"><input type="text" id="citizen_id" name="citizen_id" class="form-control" oninput="this.value = this.value.replace(/[^A-Za-z-0-9]/, '')" minlength="4" placeholder="Citizen-Ship-id">
                        <div class="citizen_id_msg"></div>
                      </div>
                    </div>
                    <div class="form-group" id="indian_add">
                      <label class="col-sm-1">State&nbsp;<?= $astrik ?></label>
                      <div class="col-sm-3">
                        <select id="state_id" name="state_id" class="form-control">
                          <option value="">select</option>
                          <?php
                          if (!empty($states)) {
                            foreach ($states as $stat) {
                          ?>
                              <option value="<?= $stat['state_id'] ?>"
                                <?php
                                if ((isset($stud->state_id) && !empty($stud->state_id) && $stud->state_id == $stat['state_id']) || $stat['state_id'] == 27) {
                                  echo "selected";
                                } ?>><?= $stat['state_name'] ?></option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <label class="col-sm-1">District&nbsp;<?= $astrik ?></label>
                      <div class="col-sm-3">
                        <select id="district_id" name="district_id" class="form-control"></select>
                      </div>
                      <label class="col-sm-1">City&nbsp;<?= $astrik ?></label>
                      <div class="col-sm-3">
                        <select id="city_id" name="city_id" class="form-control"></select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-1">Pincode<?= $astrik ?></label>
                      <div class="col-sm-3"><input type="text" id="pincode" name="pincode" class="form-control" placeholder="Pincode" required="required" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" minlength="6" maxlength="6" /></div>

                      <label class="col-sm-1">Gender<?= $astrik ?></label>
                      <div class="col-sm-3">
                        <div class="">
                          <label class="radio-container m-r-45">Male
                            <input type="radio" name="gender" id="gender" value="M" required="required">
                          </label>
                          <label class="radio-container">Female
                            <input type="radio" name="gender" id="gender" value="F">
                          </label>
                          <label class="radio-container">Transgender
                            <input type="radio" name="gender" id="gender" value="T">
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group" id="adhar_add">
                      <label class="col-sm-1">Aadhar No<?= $astrik ?></label>
                      <div class="col-sm-3"><input type="text" id="aadhar_card" name="aadhar_card" pattern=".{12,}" class="form-control" placeholder="" minlength="12" readonly maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" onkeyup="aadharValidation11();" />
                        <div class="aadhar_msg"></div>
                      </div>
                      <label class="col-sm-1">Category<?= $astrik ?></label>
                      <div class="col-sm-7">
                        <label class="radio-inline ">
                          <input type="radio" name="category" id="GEN" value="GEN" required="required" onclick="chnage_category(this);">GEN </label>
                        <label class="radio-inline"><input type="radio" name="category" id="OBC" value="OBC" onclick="chnage_category(this);">OBC</label>
                        <label class="radio-inline"><input type="radio" name="category" id="SBC" value="SBC" onclick="chnage_category(this);">SBC</label>
                        <label class="radio-inline"><input type="radio" name="category" id="SC" value="SC" onclick="chnage_category(this);">SC</label>
                        <label class="radio-inline"><input type="radio" name="category" id="ST" value="ST" onclick="chnage_category(this);">ST</label>
                        <label class="radio-inline"><input type="radio" name="category" id="VJ" value="VJ/DT-A" onclick="chnage_category(this);">VJ/DT-A</label>
                        <label class="radio-inline"><input type="radio" name="category" id="NT_B" value="NT-B" onclick="chnage_category(this);">NT-B</label>
                        <label class="radio-inline"><input type="radio" name="category" id="NT_C" value="NT-C" onclick="chnage_category(this);">NT-C</label>
                        <label class="radio-inline"><input type="radio" name="category" id="NT_D" value="NT-D" onclick="chnage_category(this);">NT-D</label>

                      </div>
                    </div>
              </div>
              </fieldset>



              <!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
              <fieldset class="scheduler-border hidden">
                <legend class="scheduler-border">Document Details:</legend>
                <div class="form-group">
                  <label class="col-sm-1">Photo<?php echo $stud->Photo; // $astrik
                                                ?></label>
                  <div class="col-sm-2">
                    YES<input type="radio" name="Candidate_Photo" id="Candidate_Photo" <?php if ($stud->Photo == "Y") { ?> checked="checked" <?php } ?> value="Y" />&nbsp;NO&nbsp;<input type="radio" name="Candidate_Photo" id="Candidate_Photon" <?php if ($stud->Photo == "N") { ?> checked="checked" <?php } ?> value="N" />
                  </div>
                  <label class="col-sm-1">Nationality<?= $astrik ?></label>
                  <div class="col-sm-2">
                    YES&nbsp;<input type="radio" name="Nationality" id="Nationality" <?php if ($stud->Nationality == "Y") { ?> checked="checked" <?php } ?> value="Y" />&nbsp;NO&nbsp;<input type="radio" name="Nationality" id="Nationalityn" <?php if ($stud->Nationality == "N") { ?> checked="checked" <?php } ?> value="N" />
                  </div>
                  <label class="col-sm-1">Domicile<?= $astrik ?></label>
                  <div class="col-sm-2">
                    YES&nbsp;<input type="radio" name="Domicile" id="Domicile" <?php if ($stud->Domicile == "Y") { ?> checked="checked" <?php } ?> value="Y" />&nbsp;NO&nbsp;<input type="radio" name="Domicile" id="Domicilen" <?php if ($stud->Domicile == "N") { ?> checked="checked" <?php } ?> value="N" />
                  </div>
                </div>
                <div class="form-group">

                  <label class="col-sm-1">Cast<?= $astrik ?></label>
                  <div class="col-sm-2">
                    YES&nbsp;<input type="radio" name="CAST" id="CAST" <?php if ($stud->Cast == "Y") { ?> checked="checked" <?php } ?> value="Y" />&nbsp;NO&nbsp;<input type="radio" name="CAST" id="CASTn" <?php if ($stud->Cast == "N") { ?> checked="checked" <?php } ?> value="N" />
                  </div>
                  <label class="col-sm-1">SSC&nbsp;<?= $astrik ?></label>
                  <div class="col-sm-2">
                    YES&nbsp;<input type="radio" name="SSC" id="SSC" <?php if ($stud->SSC == "Y") { ?> checked="checked" <?php } ?> value="Y" />&nbsp;NO&nbsp;<input type="radio" name="SSC" id="SSCn" <?php if ($stud->SSC == "N") { ?> checked="checked" <?php } ?> value="N" />
                  </div>
                  <label class="col-sm-1">HSC&nbsp;<?= $astrik ?></label>
                  <div class="col-sm-2">
                    YES&nbsp;<input type="radio" name="HSC" id="HSC" <?php if ($stud->HSC == "Y") { ?> checked="checked" <?php } ?> value="Y" />&nbsp;NO&nbsp;<input type="radio" name="HSC" id="HSCn" <?php if ($stud->HSC == "N") { ?> checked="checked" <?php } ?> value="N" />
                  </div>
                </div>

                <div class="form-group">

                  <label class="col-sm-3">CET/JEE&nbsp;Scorecard<?= $astrik ?></label>
                  <div class="col-sm-2">
                    YES&nbsp;<input type="radio" name="CET_Scorecard" <?php if ($stud->CET == "Y") { ?> checked="checked" <?php } ?> id="CET_Scorecard" value="Y" />&nbsp;NO&nbsp;<input type="radio" name="CET_Scorecard" id="CET_Scorecardn" <?php if ($stud->CET == "N") { ?> checked="checked" <?php } ?> value="N" />
                  </div>
                </div>
                <div class="form-group" id="Non_Creamy" style="display:none">
                  <label class="col-sm-3">Non-Creamy&nbsp;Layer&nbsp;Certificate<?= $astrik ?></label>
                  <div class="col-sm-2">
                    YES&nbsp;<input type="radio" name="Creamy_Layer" <?php if ($stud->vc_recepit == "Y") { ?> checked="checked" <?php } ?> id="Creamy_Layer" value="Y" />&nbsp;NO&nbsp;<input type="radio" name="Creamy_Layer" id="Creamy_Layern" <?php if ($stud->vc_recepit == "N") { ?> checked="checked" <?php } ?> value="N" />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3">Validity&nbsp;Certificate<?= $astrik ?></label>
                  <div class="col-sm-2">
                    YES&nbsp;<input type="radio" name="Validity_Certificate" <?php if ($stud->validity_certificate == "Y") { ?> checked="checked" <?php } ?> id="Validity_Certificate" value="Y" />&nbsp;NO&nbsp;<input type="radio" name="Validity_Certificate" id="Validity_Certificaten" <?php if ($stud->validity_certificate == "N") { ?> checked="checked" <?php } ?> value="N" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3">Validity&nbsp;Certificate&nbsp;Recepit<?= $astrik ?></label>
                  <div class="col-sm-2">
                    YES&nbsp;<input type="radio" name="Certificate_Recepit" <?php if ($stud->vc_recepit == "Y") { ?> checked="checked" <?php } ?> id="Certificate_Recepit" value="Y" />&nbsp;NO&nbsp;<input type="radio" name="Certificate_Recepit" id="Certificate_Recepitn" <?php if ($stud->vc_recepit == "N") { ?> checked="checked" <?php } ?> value="N" />
                  </div>
                </div>

                <!--<div class="form-group hidden" id="old_data">
<label class="col-sm-1">School Name <?= $astrik ?></label>
<div class="col-sm-3">
<select type="text" name="school_name" id="school_name" class="form-control">
<option value="">SELECT</option>
</select>
</div>

<label class="col-sm-1">Programme Type <?= $astrik ?></label> 
<div class="col-sm-3"><select name="CoursesType" id="CoursesType" class="form-control">
<option value="">Select Type</option></select></div>


<label class="col-sm-1">Courses <?= $astrik ?></label> 
<div class="col-sm-3"><select name="Courses" id="Courses" class="form-control">
<option value="">Select Courses</option></select></div>
                        
</div>-->

                <!--<div class="form-group hidden"  id="university_data">
                     <label class="col-sm-1">School<?= $astrik ?></label>
                     <div class="col-sm-3"><select id="school_id" name="school_id" class="form-control" onChange="load_courses(this.value)" ></select></div>
                     <label class="col-sm-1">Course<?= $astrik ?></label>
                     <div class="col-sm-3"> <select id="course_id" name="course_id" class="form-control" onChange="load_streams(this.value)" ></select>
                     </div>
                     <label class="col-sm-1">Stream<?= $astrik ?></label>
                     <div class="col-sm-3">
                     <select id="stream_id" name="stream_id" class="form-control"  onChange="get_fees_value(this.value,0)" ></select>
                     </div>
                     </div>-->
                <div class="form-group hidden">
                  <label class="col-sm-1">Total Fees</label>
                  <div class="col-sm-3"><input type="text" id="actual_fee" name="actual_fee" readonly class="form-control col-sm-3" value="<?php
                                                                                                                                            if (isset($stud->actual_fee) && !empty($stud->actual_fee)) {
                                                                                                                                              echo $stud->actual_fee;
                                                                                                                                            } ?>"></div>
                  <label class="col-sm-1">Tution&nbsp;Fees</label>
                  <div class="col-sm-3">
                    <input type="text" id="tution_fees" name="tution_fees" readonly class="form-control col-sm-3" value="<?php
                                                                                                                          if (isset($stud->tution_fees) && !empty($stud->tution_fees)) {
                                                                                                                            echo $stud->tution_fees;
                                                                                                                          } ?>">
                  </div>
                </div>

                <div class="form-group hidden">

                  <label class="col-sm-1">Renumeration amount&nbsp;<?= $astrik ?></label>
                  <div class="col-sm-3">
                    <input type="number" id="renumeration_amount" name="renumeration_amount" class="form-control" placeholder="Renumeration amount" value=0 maxlength="5" />
                  </div>
              </fieldset>



              <!--                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////     
-->




              <fieldset class="scheduler-border hidden">
                <legend class="scheduler-border"> Admission Form: YES&nbsp;<input type="radio" id="FormTaken" name="form_taken" value="Y" onchange="Form_check(this);">&nbsp;NO
                  <input type="radio" id="FormTaken" name="form_taken" value="N" onchange="Form_check(this);"></span>
                </legend>

                <div id="FTaken" style="display:none;">
                  <div class="form-group"></div>
                  <!--                                           original_price - (original_price * discount / 100)
                        -->
                  <div class="form-group">
                    <label class="col-sm-2">Amount <?= $astrik ?></label>
                    <div class="col-sm-3"><input type="text" id="amount" name="form_amount" readonly class="form-control" value="1000" placeholder="" /></div>
                    <!--<label class="col-sm-2">Mobile<?= $astrik ?></label>
                     <div class="col-sm-3"><input type="text" id="form_mobile"  name="form_mobile" class="form-control" />-->
                    <?php  /*if(isset($validation_errors)) { ?>
                     <span style='color:red;'>You have already registered with us using this mobile no.</span> <?php } else
                        {?> <span id="errormsg"></span> <?php } */ ?>

                  </div>

                  <div class="form-group">
                    <label class="col-sm-2">Form no: <?= $astrik ?> </label>
                    <div class="col-sm-3">
                      <div id="dshow" style="display:none;">
                      </div>
                      <input type="text" id="form_no" name="form_no" class="form-control" placeholder="Form No" onblur="return chek_duplicate_formno_exist(this.value)" />
                      <!--onblur="return chek_duplicate_formno_exist(this.value)"--><?php if (isset($validation_errors1)) { ?>
                        <span style='color:red;'>You have already registered with us using this form no.</span> <?php } else { ?> <span id="errormsgform"></span> <?php } ?>
                    </div>
                    <label class="col-sm-2">Payment Mode: <?= $astrik ?> </label>
                    <div class="col-sm-3">
                      <select name="payment_mode" class="form-control" id="payment_mode" onchange="getdd_details(this)">
                        <option value="">Select Payment type</option>
                        <option value="CASH">Cash</option>
                        <option value="OL">ONLINE</option>
                        <option value="POS">POS</option>
                        <option value="CC">CC</option>
                        <option value="DC">DC</option>
                        <option value="NB">NB</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <input type="hidden" id="acyear" name="acyear" class="form-control col-sm-8" value="<?php echo $year; ?>">
                    <div class="col-sm-6"></div>
                    <label class="col-sm-1 Transaction_lable"></label>
                    <div class="col-sm-3 Transaction_box" style="display: none;">
                      <input type="text" name="TransactionNo" id="TransactionNo" class="form-control" placeholder="" />
                    </div>
                  </div>
                </div>

            </div>
            </fieldset>


            <fieldset class="scheduler-border hidden" style="">

              <legend class="scheduler-border">Scholarship:
                YES&nbsp;<input type="radio" class="Scholarship_Allowed" value="YES" id="Scholarship_Allowed" name="scholarship_allowed" />
                &nbsp;NO&nbsp;<input type="radio" class="Scholarship_Allowed" value="NO" id="Scholarship_Allowed" name="scholarship_allowed" />
                :</legend>
              <div class="form-group">&nbsp;</div>
              <div class="form-group" style="display:none;">
                <label class="col-sm-2">Scholarship&nbsp;Type&nbsp;<?= $astrik ?></label>
                <div class="col-sm-5">
                  <?php foreach ($Scholarship_type as $type) { ?>
                    <?php echo str_replace('_', ' ', $type['type']); ?>&nbsp;<input type="checkbox" class="Scholarship_type" value="<?php echo $type['type']; ?>" id="<?php echo $type['type']; ?>" name="Scholarship_type[]" />
                  <?php } ?>
                </div>
                <div class="col-sm-3">
                </div>
              </div>
              <div class="Scholarship_allow" style="display:none;">
                <div class="Other_ship">
                  <h3>Other Scholarship</h3>
                  <div class="form-group">
                    <?php foreach ($Scholarship_typee as $Other) {
                      if (($Other['type'] == "Other_Scholarship") && ($Other['state_wise'] == "ALL") && ($Other['year'] == 0)) {
                    ?>
                        <div class="">
                          <input type="radio" name="Other_Scholarship_selected" value="<?php echo $Other['s_id']; ?>"
                            id="apply_Other" class="Other_Scholarship" lang="<?php echo $Other['consession_allowed']; ?>" />&nbsp;<?php echo $Other['schlorship_name']; ?>&nbsp;(<?php echo $Other['Criteria']; ?>)&nbsp;(<?php echo $Other['consession_allowed']; ?>)%
                        </div>
                    <?php }
                    } ?>
                    <!--  <input type="radio" name="Other_Scholarship_selected" value="<?php echo $Other['s_id']; ?>" 
                        id="apply_Other" class="Other_Scholarship"  lang="0" />
                                    --> <input type="hidden" name="Other_samount" id="Other_samount" value="0" />
                  </div>
                </div>
                <div class="Sports_ship">
                  <h3>Sports Scholarship</h3>
                  <div class="form-group">
                    <?php foreach ($Scholarship_typee as $Sports) {
                      if (($Sports['type'] == "Sports_Scholarship") && ($Sports['state_wise'] == "ALL") && ($Sports['year'] == 1)) {
                    ?>
                        <div class="">
                          <input type="radio" name="Sports_Scholarship_selecet" value="<?php echo $Sports['s_id']; ?>" id="apply_Sports"
                            lang="<?php echo $Sports['consession_allowed']; ?>" class="Sports_Scholarship" />&nbsp;<?php echo $Sports['schlorship_name']; ?>&nbsp&nbsp;(<?php echo $Sports['consession_allowed']; ?>)%
                        </div>
                    <?php }
                    } ?>
                    <input type="hidden" name="Sports_samount" id="Sports_samount" value="0" />
                  </div>
                </div>
                <div class="Merit_ship" style="">
                  <div class="form-group">
                    <h3>Merit Scholarship</h3>
                    <!--<div class="col-sm-2 Other_Scholarship"></div> -->
                    <div class="col-sm-6 Merit_Scholarship">
                      MH&nbsp;<input type="radio" value="MH" class="Scholarship_state" name="Scholarship_state" onchange="Scholarship_change(this)" />&nbsp;OMH&nbsp;<input type="radio" value="OMH" class="Scholarship_state" name="Scholarship_state" onchange="Scholarship_change(this)" />
                    </div>
                    <!--<div class="col-sm-2 Sports_Scholarship"></div>      -->
                  </div>
                  <div class="MH" style="display:none;">
                    <div class="form-group">
                      <?php foreach ($Scholarship_typee as $typee) {
                        if (($typee['type'] == "Merit_Scholarship") && ($typee['state_wise'] == "MH") && ($typee['year'] == 1)) {
                      ?>
                          <div class=""><input type="radio" name="Merit_Scholarship_selected" value="<?php echo $typee['s_id']; ?>"
                              id="apply_Merit" class="Merit_Scholarship" lang="<?php echo $typee['consession_allowed']; ?>" />&nbsp;<?php echo $typee['schlorship_name']; ?>&nbsp;(<?php echo $typee['Criteria']; ?>)&nbsp;(<?php echo $typee['consession_allowed']; ?>)%</div>
                      <?php }
                      } ?>
                    </div>
                  </div>
                  <div class="OMH" style="display:none;">
                    <div class="form-group">
                      <?php foreach ($Scholarship_typee as $typee) {
                        if (($typee['type'] == "Merit_Scholarship") && ($typee['state_wise'] == "OMH") && ($typee['year'] == 1)) {
                      ?>
                          <div class=""><input type="radio" name="Merit_Scholarship_selected" value="<?php echo $typee['s_id']; ?>"
                              id="apply_Merit" class="Merit_Scholarship" lang="<?php echo $typee['consession_allowed']; ?>" />&nbsp;<?php echo $typee['schlorship_name']; ?>&nbsp;(<?php echo $typee['Criteria']; ?>)&nbsp;(<?php echo $typee['consession_allowed']; ?>)%</div>
                      <?php }
                      } ?>
                      <input type="hidden" name="Merit_samount" id="Merit_samount" value="0" />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2">Scholarship Amount</label>
                  <div class="col-sm-3"><input type="text" id="Scholarship_Amount" name="scholarship_amount" class="form-control" readonly="readonly" /></div>
                </div>
                <div class="form-group">&nbsp;</div>
                <div class="form-group">
                  <label class="col-sm-2">Min&nbsp;Without&nbsp;Scholarship</label>
                  <div class="col-sm-3">
                    <input type="text" id="without_scholarship" name="without_scholarship" class="form-control" readonly value="<?php
                                                                                                                                if (isset($stud->actual_fee) && !empty($stud->actual_fee)) {
                                                                                                                                  echo round(25 / 100 * $stud->actual_fee);
                                                                                                                                } ?>">
                  </div>
                  <label class="col-sm-2">Min&nbsp;With&nbsp;Scholarship</label>
                  <div class="col-sm-3"><input type="text" id="with_scholarship" name="with_scholarship" class="form-control col-sm-2" readonly="readonly" /></div>
                </div>
                <div class="form-group">&nbsp;</div>
                <div class="form-group">&nbsp;</div>
                <?php if (($role_id == 24)) { ?>
                  <div class="form-group">
                    <label class="col-sm-2">Scholarship Status</label>
                    <div class="col-sm-3"><select name="scholarship_status" id="scholarship_status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="Approve">Approve</option>
                        <option value="Reject">Reject</option>
                        <option value="Pending">Pending</option>
                      </select></div>
                  </div>
                <?php } ?>
              </div>
            </fieldset>

            <fieldset class="">
              <!--  <legend class="scheduler-border">Hostel Allowed: YES&nbsp;<input type="radio" id="hostel_allowed"  name="hostel_allowed" value="Y">&nbsp;NO
                  <input type="radio" id="hostel_allowed"  name="hostel_allowed" value="N"></legend>-->
              <div class="form-group">
                <div class="row text-center">
                  <button class="btn btn-primary" id="btn_submit" type="submit">Submit</button>
                  <button class="btn btn-primary" id="btn_cancel" type="button" onclick="window.location='<?php echo base_url(); ?>StudentRegistration/Student_list_added_by_student'">Cancel</button>
                  <!--<button class="btn btn-primary" id="btn_pdf" type="button" style="display:none;">PDF</button> -->
                </div>
              </div>
            </fieldset>
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
  var enquiryparamer = '';
  var default_year = '<?php echo ADMISSION_SESSION_YEAR; ?>';

  function chnage_category(m) {
    var value = m.value;
    if ((value == "OBC") || (value == "SBC") || (value == "ST") || (value == "VJ/DT-A") || (value == "NT-B") || (value == "NT-C") || (value == "NT-D")) {
      $("#Non_Creamy").show();
    } else {
      $("#Non_Creamy").hide();
    }
  }


  function state_call(stateID, stt = 0) {
    var datavalue = {
      'state_id': stateID,
      'stt': stt
    }
    $.ajax({
      type: 'POST',
      url: '<?= base_url() ?>StudentRegistration/getStatewiseDistrict',
      data: datavalue,
      success: function(html) {
        //alert(html);
        $('#district_id').html(html);
      }
    });

  }

  function distic_call(stateID, district_id, stt = 0) {
    $.ajax({
      type: 'POST',
      url: '<?= base_url() ?>StudentRegistration/getStateDwiseCity',
      data: 'state_id=' + stateID + "&district_id=" + district_id + "&stt=" + stt,
      success: function(html) {
        //alert(html);
        $('#city_id').html(html);
      }
    });
  }

  $(function() {

    $('#adhar_searchf').on("cut copy paste", function(e) {
      e.preventDefault();
    });

    var enquiryparamer = '<?php echo $enquiryparamer; ?>';
    // alert(enquiryparamer);
    var mobilnparamer = '<?php echo $mobilnparamer; ?>';
    if ((enquiryparamer != '') || (mobilnparamer != '')) {
      // alert("fdf");
      $("#btnsearch").trigger('click');
    }
    /* if(mobilnparamer!='')
     {
       var values={mobile_no:mobile,Enquiry_search:mobilnparamer}
                $.ajax({
                    type:'POST',
                    url: '<?php echo base_url() ?>Enquiry/Serach_details', 
                    data: values,
                    success: function (resp) {
                      document.forms["form"].reset();
                      $('#returnMessage').html('');
                      $("#sname").prop('readOnly', false);
                      $("#email").prop('readOnly', false);
                      $("#mobile").prop('readOnly', false);
                      $('#course_type').html('<option value="">--Select--</option><option value="R" selected>Regular</option><option value="P">Part time</option>');
                      $("#course_type").prop('disabled', false);
                      $('#coursen').html('<option value=""> Select Course </option>');
                      $("#coursen").prop('disabled', false);
                      $("#email").prop('readOnly', false);
                      $("#amount").val();
                      $("#formno").val();
                      $("#formno").prop('disabled', false);
                      $('#paymentmode').html('<option value=""> Select Payment Type </option><option value="CASH">Cash</option><option value="OL">Online</option><option value="POS">POS</option>');
                      $("#paymentmode").prop('disabled', false);
                      if(resp=='no')
                      {
                        //alert('test');
   
                        $("#show_form").show();
                        $("#mobile").val(mobile);
                        var coursetype = $("#course_type").val();
                        var reg='Regular';
                        var coursetype='R';
                        $("#course_type").val(coursetype);
                        // var coursetype = coursetype;
                        
                         //alert(coursetype);
                     
                           else{ 
                                $('#coursen').html('<option value="" required >Select course type first</option>'); 
                             }
                             if(coursetype=='R')
                             {
                               $("#amount").val('1000');
                               $("#dshow").show();var fno='20R01'; 
                               $("#formno").val(fno);
                             }
                             else{
                                $("#dshow").show();
                                var fno='19P02';
                                $("#formno").val(fno);
                             
                                 $("#amount").val('1000'); 
                              }
                      }else{  alert(mobilnparamer);
                          $("#show_form").show();
                        var mob = JSON.parse(resp);
                        var form_no =mob[0]['adm_form_no'];
   				  $(".enquiry_no").show();
                        var enquiry_no =mob[0]['enquiry_no'];
   				  $(".enquiry_no").val(enquiry_no);
   				  
   				  if(mob[0]['enquiry_no']!="")
   				  {
   					  $("#form").attr('action', "<?php echo base_url(); ?>Enquiry/Updated");
   					  $("#btn_submit").html('Update');
   				  }
   				  $("#enquiry_id").val(mob[0]['enquiry_id'])
   				  $("#first_name").val(mob[0]['first_name']);
   				  $("#middle_name").val(mob[0]['middle_name']);
   				  $("#last_name").val(mob[0]['last_name']);
   				  $("#email_id").val(mob[0]['email_id']);
   				  $("#mobile").val(mob[0]['mobile']);
   				  $("#altarnet_mobile").val(mob[0]['altarnet_mobile']);
   				  
   				  $("#state_id").val(mob[0]['state_id']);
   				 // state_call(mob[0]['state_id'],mob[0]['district_id']);
   				  setTimeout(function() { state_call(mob[0]['state_id'],mob[0]['district_id']); }, 500);
   				  $("#district_id").val(mob[0]['district_id']);
   				  $("#city_id").val(mob[0]['city_id']);
   				 // distic_call(mob[0]['state_id'],mob[0]['district_id'],mob[0]['city_id']);
   				  setTimeout(function() { distic_call(mob[0]['state_id'],mob[0]['district_id'],mob[0]['city_id']); }, 1000);
   				  
   				  $("#pincode").val(mob[0]['pincode']);
   				  $("#admission_type").val(mob[0]['admission_type']);
   				  
   				 // $("#gender").val(mob[0]['gender']);
   				  $("input[name=gender][value=" + mob[0]['gender'] + "]").prop('checked', true);
   
   				  $("#aadhar_card").val(mob[0]['aadhar_card']);
   				 // $("#category").val(mob[0]['category']);
   				   $("input[name=category][value=" + mob[0]['category'] + "]").prop('checked', true);
   				   ///////////////////////////////////////////////////////////////////////////////////////////////////////
   				   $("#last_qualification").val(mob[0]['last_qualification']);
   				   get_school(mob[0]['last_qualification'],mob[0]['school_id']);
   				   $("#qualification_percentage").val(mob[0]['qualification_percentage']);
   				   $("#school_id").val(mob[0]['school_id']);
   				  
   				   $("#course_id").val(mob[0]['course_id']);
   				   // load_courses(mob[0]['school_id'],mob[0]['course_id']);
   					setTimeout(function() { load_courses(mob[0]['school_id'],mob[0]['course_id']); }, 500);
   				   $("#stream_id").val(mob[0]['stream_id']);
   				   setTimeout(function() { load_streams(mob[0]['course_id'],mob[0]['stream_id']); }, 1000);
   				   
   				   
   				   $("#actual_fee").val(mob[0]['actual_fee']);
   				   $("#tution_fees").val(mob[0]['tution_fees']);
   				   
   				   //$("#form_taken").val(mob[0]['form_taken']);
   				   $("input[name=form_taken][value=" + mob[0]['form_taken'] + "]").prop('checked', true);
   				   if(mob[0]['form_taken']=="Y"){
   					   $("#FTaken").show();
   				   }else{
   					   $("#FTaken").hide();
   				   }
   				   $("#form_amount").val(mob[0]['form_amount']);
   				   $("#form_mobile").val(mob[0]['form_mobile']);
   				   $("#form_no").val(mob[0]['form_no']);
   				   $("#payment_mode").val(mob[0]['payment_mode']);
   				   $("#TransactionNo").val(mob[0]['recepit_no']);
                       
                          
                      }
                      
   
                    
                    }                      
                  });
   
     }
     else
     {
      return false;
   
     }*/

  });
  $('.numbersOnly').keyup(function() {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
      this.value = this.value.replace(/[^0-9\.]/g, '');
    }
  });

  $('.Scholarship_Allowed').click(function() {
    var value = $(this).val();

    if (value == "YES") {
      $('.Scholarship_allow').show();

    } else {
      $('#Scholarship_Amount').val('');
      $('#without_scholarship').val('');
      $('#with_scholarship').val('');
      $('.Other_Scholarship').prop('checked', false); // Unchecks it
      $('.Sports_Scholarship').prop('checked', false); // Unchecks it
      $('.Merit_Scholarship').prop('checked', false); // Unchecks it
      $('.Scholarship_allow').hide();
    }


  })


  function get_courses_type(school_name, Qualification, Campus, Campus_City, CoursesType, year) {

    if (school_name) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/Get_CoursesType',
        data: {
          school_name: school_name,
          Campus: Campus,
          Qualification: Qualification,
          Campus_City: Campus_City,
          year: year
        },
        success: function(html) {
          //alert(html);
          if (html != '') {
            $('#CoursesType').html(html);
          } else {
            $('#CoursesType').html('<option value="">No Type found</option>');
          }
          $('#CoursesType').val(CoursesType);
        }
      });
    } else {
      $('#Counsellor').html('<option value="">Select School first</option>');
    }
  }


  function get_Courses(school_name, Campus, Campus_City, CoursesType, course, year = '') {

    if (school_name) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/Get_Courses',
        data: {
          school_name: school_name,
          Campus: Campus,
          CoursesType: CoursesType,
          Campus_City: Campus_City,
          year: year
        },
        success: function(html) {
          //alert(html);
          if (html != '') {
            $('#Courses').html(html);
          } else {
            $('#Courses').html('<option value="">No Course found</option>');

          }
          $('#Courses').val(course);
        }
      });
    } else {
      $('#Courses').html('<option value="">Select Programme Type</option>');
    }
  }

  function sleep(delay) {
    var start = new Date().getTime();
    while (new Date().getTime() < start + delay);
  }


  $("#btnsearch").click(function() {

    var enquiryparamer = '<?php echo $enquiryparamer; ?>';
    /*if(enquiryparamer==''){
    alert("Please wait.We are checking.....");}*/
    // $("#returnMessagenew").html("Please wait.We are checking.....");
    var uid = '<?php echo $check_id_in_ic; ?>';
    $(".enquiry_no").hide();
    var mobile = $("#mobile_search").val().trim();
    var Enquiry_search = $("#Enquiry_search").val().trim();
    var adhar_search = $("#adhar_search").val().trim();
    var year = $("#acyear").val().trim();
    var allok = 1;
    var mobileFilter = /^[0-9]{10}$/;
    var adharFilter = /^[0-9]{12}$/;
    var filter = /^[0-9-+]+$/;
    if (mobile == '') {
      mobile.length = 0;
    }
    //alert("ggg");
    if (mobile === '' && enquiryparamer === '') {
      alert('Mobile Number is mandatory.');
      allok = 0;
    }
    if (adhar_search === '' && enquiryparamer === '') {
      alert('Aadharcard  is mandatory.');
      allok = 0;
    }

    if (allok == 1) {
      if (!mobileFilter.test(mobile) && enquiryparamer === '') {
        alert('Please enter a valid 10-digit mobile number.');
        $("#mobile_search").focus();
        allok = 0;
        //return false;
      }

      if (!adharFilter.test(adhar_search) && enquiryparamer === '') {
        alert('Please enter a valid 12-digit Aadhar number.');
        $("#adhar_search").focus();
        allok = 0;
      }
    }
    if (allok == 0) {

    }
    //alert(mobile);
    else {
      {

        //if((filter.test(mobile))||(Enquiry_search!=''))
        //{  //alert('2');

        var msg_to_show = '';


        var values = {
          mobile_no: mobile,
          Enquiry_search: Enquiry_search,
          adhar_search: adhar_search,
          year: year
        }
        var is_all_set = 1;
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url() ?>StudentRegistration/check_for_entries_in_all_dbs',
          data: values,
          success: function(resp) {


            if (resp.trim() === 'no') {
              //$("#returnMessagenew").html("");

            } else {
              //alert(resp);
              //$("#returnMessagenew").html("");
              var mob1 = JSON.parse(resp);

              if (mob1[0]['admission'] == 1) {
                is_all_set = 0;
                msg_to_show = 'Admission already done';
              } else if (mob1[0]['created_by'] != uid) {
                is_all_set = 0;
                msg_to_show = 'Already registered';
              }
            }
          }
        });

        sleep(1000);
        //
        //setTimeout(continueExecution, 50000); 
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url() ?>StudentRegistration/Serach_details',
          data: values,
          success: function(resp) {
            //check_for_entries_in_all_dbs(mobile,Enquiry_search,adhar_search);

            $("#returnMessagenew").html("");
            console.log(resp);
            if (is_all_set == 1) {
              //alert("fff");
              document.forms["form"].reset();
              $('#returnMessage').html('');
              $("#sname").prop('readOnly', false);
              $("#email").prop('readOnly', false);
              $("#mobile").prop('readOnly', false);
              $('#course_type').html('<option value="">--Select--</option><option value="R" selected>Regular</option><option value="P">Part time</option>');
              $("#course_type").prop('disabled', false);
              $('#coursen').html('<option value=""> Select Course </option>');
              $("#coursen").prop('disabled', false);
              $("#email").prop('readOnly', false);
              $("#amount").val();
              $("#formno").val();
              $("#formno").prop('disabled', false);
              $('#paymentmode').html('<option value=""> Select Payment Type </option><option value="CASH">Cash</option><option value="OL">Online</option><option value="POS">POS</option>');
              $("#paymentmode").prop('disabled', false);
              if (resp == 'no') {
                //alert('test');
                $("#show_form_msg").hide();
                $("#show_form").show();
                $("#mobile").val(mobile);
                $("#aadhar_card").val(adhar_search);
                var coursetype = $("#course_type").val();
                var reg = 'Regular';
                var coursetype = 'R';
                $("#course_type").val(coursetype);
                // var coursetype = coursetype;
                if (coursetype !== '') {
                  /*$.ajax({
                          type:'POST',
                          url:'<?= base_url() ?>prospectus_fee_details/fetch_course_details',
                          data:{coursetype:coursetype,select_course:select_course},
                          success:function(html){
                            $('#coursen').html(html);
                          }
                      });*/
                }
                //alert(coursetype);
                else {
                  $('#coursen').html('<option value="" required >Select course type first</option>');
                }
                if (coursetype == 'R') {
                  $("#amount").val('1000');
                  $("#dshow").show();
                  var fno = '20R01';
                  $("#formno").val(fno);
                } else {
                  $("#dshow").show();
                  var fno = '19P02';
                  $("#formno").val(fno);

                  $("#amount").val('1000');
                }
              } else {
                var mob = JSON.parse(resp);
                //alert(mob[0]['created_by']+"//"+uid);
                if (mob[0]['created_by'] != uid) {
                  $("#show_form").hide();
                  $("#sm").html('Already Registered');
                  $("#show_form_msg").css("display", "block");
                } else {
                  $("#show_form_msg").css("display", "none");
                  $("#show_form").show();
                  var form_no = mob[0]['adm_form_no'];
                  $(".enquiry_no").show();
                  var enquiry_no = mob[0]['enquiry_no'];
                  $(".enquiry_no").val(enquiry_no);
                  var nationality = mob[0]['nationality'];
                  $("input[name=nationality][value=" + nationality + "]").prop("checked", true);
                  if (mob[0]['enquiry_no'] != "") {
                    $("#form").attr('action', "<?php echo base_url(); ?>StudentRegistration/Updated");
                    $("#btn_submit").html('Update');
                    $("#btn_pdf").show();
                  }
                  if (nationality == 2) {
                    $("#indian_add").addClass('hidden');
                    $("#others_add").removeClass('hidden');
                    $("#adhar_add").addClass('hidden');
                    $("#int_country_id").val(mob[0]['int_country_id']);
                    $("input[name='category']").prop('required', false);
                    $("#citizen_id").val(mob[0]['citizenship_id'])
                    get_states(mob[0]['int_country_id'], mob[0]['int_state']);
                    get_city(mob[0]['int_state'], mob[0]['int_city']);
                  }
                  $("#enquiry_id").val(mob[0]['enquiry_id'])
                  $("#first_name").val(mob[0]['first_name']);
                  $("#middle_name").val(mob[0]['middle_name']);
                  $("#last_name").val(mob[0]['last_name']);
                  $("#email_id").val(mob[0]['email_id']);
                  $("#mobile").val(mob[0]['mobile']);
                  $("#altarnet_mobile").val(mob[0]['altarnet_mobile']);
                  $("#Campus").val(mob[0]['Campus']);
                  $("#Campus_City").val(mob[0]['Campus_City']);
                  $("#renumeration_amount").val(mob[0]['renumeration_amount']);
                  if (year == '2025-26') {
                    //year=default_year;
                  }

                  if (mob[0]['Campus'] == 'SUN' && mob[0]['Campus_City'] == 1)
                  {
                    $("#university_data").removeClass('hidden');
                  } else {
                    get_school1(mob[0]['school_id'], mob[0]['Campus'], mob[0]['Campus_City'], year);
                    get_courses_type(mob[0]['school_id'], mob[0]['last_qualification'], mob[0]['Campus'], mob[0]['Campus_City'], mob[0]['course_type'], year);
                    get_Courses(mob[0]['school_id'], mob[0]['Campus'], mob[0]['Campus_City'], mob[0]['course_type'], mob[0]['course_id'], year);
                    $("#old_data").removeClass('hidden');
                  }
                  $("#state_id").val(mob[0]['state_id']);
                  // state_call(mob[0]['state_id'],mob[0]['district_id']);
                  setTimeout(function() {
                    state_call(mob[0]['state_id'], mob[0]['district_id']);
                  }, 500);
                  $("#district_id").val(mob[0]['district_id']);
                  $("#city_id").val(mob[0]['city_id']);
                  // distic_call(mob[0]['state_id'],mob[0]['district_id'],mob[0]['city_id']);
                  setTimeout(function() {
                    distic_call(mob[0]['state_id'], mob[0]['district_id'], mob[0]['city_id']);
                  }, 1000);

                  $("#pincode").val(mob[0]['pincode']);
                  $("#admission_type").val(mob[0]['admission_type']);

                  // $("#gender").val(mob[0]['gender']);
                  $("input[name=gender][value=" + mob[0]['gender'] + "]").prop('checked', true);

                  $("#aadhar_card").val(mob[0]['aadhar_card']);
                  // $("#category").val(mob[0]['category']);
                  $("input[name=category][value='" + mob[0]['category'] + "']").prop('checked', true);
                  ///////////////////////////////////////////////////////////////////////////////////////////////////////
                  $("#last_qualification").val(mob[0]['last_qualification']);


                  $("#qualification_percentage").val(mob[0]['qualification_percentage']);
                  $("#school_id").val(mob[0]['school_id']);


                  setTimeout(function() {
                    get_school(mob[0]['last_qualification'], mob[0]['school_id'], year);
                  }, 300);
                  $("#course_id").val(mob[0]['course_id']);
                  //get_courses_type
                  setTimeout(function() {
                    load_Programme_new(mob[0]['school_id'], mob[0]['last_qualification'], mob[0]['Campus'], mob[0]['Campus_City'], mob[0]['course_type'], year);
                  }, 500);
                  $("#stream_id").val(mob[0]['stream_id']);
                  setTimeout(function() {
                    get_new_course(mob[0]['school_id'], mob[0]['last_qualification'], mob[0]['Campus'], mob[0]['Campus_City'], mob[0]['course_type'], mob[0]['course_id'], year);
                  }, 1000);
                  setTimeout(function() {
                    get_new_stream(mob[0]['school_id'], mob[0]['last_qualification'], mob[0]['Campus'], mob[0]['Campus_City'], mob[0]['course_type'], mob[0]['course_id'], mob[0]['stream_id'], year);
                  }, 1500);


                  if ((mob[0]['category'] == "OBC") || (mob[0]['category'] == "SBC") || (mob[0]['category'] == "ST") || (mob[0]['category'] == "VJ/DT-A") || (mob[0]['category'] == "NT-B") || (mob[0]['category'] == "NT-C") || (mob[0]['category'] == "NT-D")) {
                    $("#Non_Creamy").show();
                  } else {
                    $("#Non_Creamy").hide();
                  }

                  if (mob[0]['category'] == "GEN") {
                    $("#GEN").prop('checked', true);
                  } else {
                    $("#GEN").prop('checked', false);
                  }
                  if (mob[0]['category'] == "OBC") {
                    $("#OBC").prop('checked', true);
                  } else {
                    $("#OBC").prop('checked', false);
                  }
                  if (mob[0]['category'] == "SBC") {
                    $("#SBC").prop('checked', true);
                  } else {
                    $("#SBC").prop('checked', false);
                  }
                  if (mob[0]['category'] == "SC") {
                    $("#SC").prop('checked', true);
                  } else {
                    $("#SC").prop('checked', false);
                  }
                  if (mob[0]['category'] == "ST") {
                    $("#ST").prop('checked', true);
                  } else {
                    $("#ST").prop('checked', false);
                  }
                  if (mob[0]['category'] == "VJ/DT-A") {
                    $("#VJ").prop('checked', true);
                  } else {
                    $("#VJ").prop('checked', false);
                  }
                  if (mob[0]['category'] == "NT-B") {
                    $("#NT_B").prop('checked', true);
                  } else {
                    $("#NT_B").prop('checked', false);
                  }
                  if (mob[0]['category'] == "NT-C") {
                    $("#NT_C").prop('checked', true);
                  } else {
                    $("#NT_C").prop('checked', false);
                  }
                  if (mob[0]['category'] == "NT-D") {
                    $("#NT_D").prop('checked', true);
                  } else {
                    $("#NT_D").prop('checked', false);
                  }
                  if (mob[0]['Photo'] == "Y") {
                    $("#Candidate_Photo").prop('checked', true);
                  } else {
                    $("#Candidate_Photon").prop('checked', true);
                  }
                  if (mob[0]['Nationality'] == "Y") {
                    $("#Nationality").prop('checked', true);
                  } else {
                    $("#Nationalityn").prop('checked', true);
                  }

                  if (mob[0]['Domicile'] == "Y") {
                    $("#Domicile").prop('checked', true);
                  } else {
                    $("#Domicilen").prop('checked', true);
                  }
                  if (mob[0]['Cast'] == "Y") {
                    $("#CAST").prop('checked', true);
                  } else {
                    $("#CASTn").prop('checked', true);
                  }
                  if (mob[0]['SSC'] == "Y") {
                    $("#SSC").prop('checked', true);
                  } else {
                    $("#SSCn").prop('checked', true);
                  }
                  if (mob[0]['HSC'] == "Y") {
                    $("#HSC").prop('checked', true);
                  } else {
                    $("#HSCn").prop('checked', true);
                  }

                  if (mob[0]['CET'] == "Y") {
                    $("#CET_Scorecard").prop('checked', true);
                  } else {
                    $("#CET_Scorecardn").prop('checked', true);
                  }
                  if (mob[0]['validity_certificate'] == "Y") {
                    $("#Validity_Certificate").prop('checked', true);
                  } else {
                    $("#Validity_Certificaten").prop('checked', true);
                  }

                  if (mob[0]['vc_recepit'] == "Y") {
                    $("#Certificate_Recepit").prop('checked', true);
                  } else {
                    $("#Certificate_Recepitn").prop('checked', true);
                  }

                  if (mob[0]['Creamy_Layer'] == "Y") {
                    $("#Creamy_Layer").prop('checked', true);
                  } else {
                    $("#Creamy_Layern").prop('checked', true);
                  }

                  $("#actual_fee").val(mob[0]['actual_fee']);
                  $("#tution_fees").val(mob[0]['tution_fees']);

                  //$("#form_taken").val(mob[0]['form_taken']);
                  $("input[name=form_taken][value=" + mob[0]['form_taken'] + "]").prop('checked', true);
                  if (mob[0]['form_taken'] == "Y") {
                    $("#FTaken").show();
                  } else {
                    $("#FTaken").hide();
                  }
                  $("#form_amount").val(mob[0]['form_amount']);
                  $("#form_mobile").val(mob[0]['form_mobile']);
                  $("#form_no").val(mob[0]['form_no']);
                  $("#payment_mode").val(mob[0]['payment_mode']);
                  if (mob[0]['payment_mode'] != 'CHLN') {
                    $('.Transaction_box').show();
                    $("#TransactionNo").val(mob[0]['recepit_no']);
                    $(".Transaction_lable").html('Recepit');
                  } else {
                    $(".Transaction_lable").html('');
                    $('.Transaction_box').hide();
                  }
                  //$("#TransactionNo").val(mob[0]['recepit_no']);

                  //  alert(mob[0]['scholarship_allowed']);
                  $("input[name=scholarship_allowed][value=" + mob[0]['scholarship_allowed'] + "]").prop('checked', true);

                  if (mob[0]['scholarship_allowed'] == "YES") {
                    $(".Scholarship_allow").show();
                    $("input[name=Other_Scholarship_selected][value=" + mob[0]['other_scholarship'] + "]").prop('checked', true);
                    $("input[name=Sports_Scholarship_selecet][value=" + mob[0]['sports_scholarship'] + "]").prop('checked', true);

                    $("input[name=Scholarship_state][value=" + mob[0]['merit_state'] + "]").prop('checked', true);

                    if (mob[0]['scholarship_allowed'] == "MH") {
                      $('.MH').show();
                      $('.OMH').hide();
                      $("input[name=Merit_Scholarship_selected][value=" + mob[0]['merit_scholarship'] + "]").prop('checked', true);
                    } else {
                      $('.MH').hide();
                      $('.OMH').show();
                      $("input[name=Merit_Scholarship_selected][value=" + mob[0]['merit_scholarship'] + "]").prop('checked', true);
                    }
                    //alert(mob[0]['without_scholarship']);
                    $("#Scholarship_Amount").val(mob[0]['scholarship_amount']);
                    $("#without_scholarship").val(mob[0]['without_scholarship']);
                    $("#with_scholarship").val(mob[0]['with_scholarship']);
                    $("#scholarship_status").val(mob[0]['scholarship_status']);
                  } else {
                    $("#Scholarship_Amount").val(' ');
                    $("#without_scholarship").val(' ');
                    $("#with_scholarship").val(' ');
                    $(".Scholarship_allow").hide();
                  }
                }
              }

            } else {
              $("#show_form").hide();
              $("#sm").html(msg_to_show);
              $("#show_form_msg").css("display", "block");
            }

          }
        });
        return true;
      }
    }
    //}
  });


  function check_for_entries_in_all_dbs(mobile_no, Enquiry_search, adhar_search) {

    var values = {
      mobile_no: mobile,
      Enquiry_search: Enquiry_search,
      adhar_search: adhar_search
    }
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url() ?>StudentRegistration/testing',
      data: values,
      success: function(resp) {}
    });
  
  }
  ///below code
  $(document).ready(function() {

    $('#pdob').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true


    }).on('change', function(e) {
      var selecteddate = $(this).val();
      var dt = new Date(selecteddate);
      dt.setDate(dt.getDate() - 1);
      var newdate = convert(dt);
      $("#reportdate").val(newdate);
    });

    //below function is used to Convert date from 'Thu Jun 09 2011 00:00:00 GMT+0530 (India Standard Time)' to 'YYYY-MM-DD' in javascript
    function convert(str) {
      var date = new Date(str),
        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
        day = ("0" + date.getDate()).slice(-2);
      return [date.getFullYear(), mnth, day].join("-");
    }

    $('#visit_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true
    });
    $('#cvisit_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true
    });
    //$('#idTourDateDetails').timepicker({timeFormat: 'h:mm:ss p'});
    $('#idTourDateDetails').timepicker({
      defaultTime: '',
      minuteStep: 1,
      disableFocus: false,
      template: 'dropdown',
      showMeridian: false
    });

  });
</script>
<script>
  //find total function is used to calculate sum of all input box
  function findTotal() {

    var osearch = parseInt($('#osearch').val()) || 0;
    var psearch = parseInt($('#psearch').val()) || 0;
    var direct = parseInt($('#direct').val()) || 0;
    var refferal = parseInt($('#refferal').val()) || 0;
    var social = parseInt($('#social').val()) || 0;
    var sum = osearch + psearch + direct + refferal + social;
    document.getElementById('tvisitor').value = parseInt(sum);
  }

  $('#course_type').on('change', function() {
    var coursetype = $(this).val();
    if (coursetype !== '') {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/fetch_course_details',
        data: 'coursetype=' + coursetype,
        success: function(html) {
          $('#coursen').html(html);
        }
      });
    } else {
      $('#coursen').html('<option value="" required >Select course type first</option>');
    }
    if (coursetype == 'R') {
      $("#amount").val('1000');
      $("#dshow").show();
      var fno = '20R01';
      $("#formno").val(fno);
    } else {
      $("#dshow").show();
      var fno = '19P02';
      $("#formno").val(fno);

      $("#amount").val('1000');
    }
  });


  //check duplicate mobile no
  function chek_mob_exist(mob_no) {
    if (mob_no) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/chek_dupmobno_exist',
        data: 'mobile_no=' + mob_no,
        success: function(resp) {
          var resp1 = resp.split("~");
          var dup = resp1[0];

          var mob = JSON.parse(resp1[1]);

          if (dup == "Duplicate") {
            //alert("You have already registered with us using this mobile no.");
            $("#errormsg").html("<span style='color:red;''>You have already registered with us using this mobile no.</span>");
            $("#mobile").val("");
            $('#mobile').focus();
            $("#btn_submit").prop('disabled', true);
            //alert(html);
            //$("#usrdetails").html(html);
            return false;
          } else {
            $("#btn_submit").prop('disabled', false);
            $("#errormsg").html("");
            return true
          }

        }
      });
    } else {

    }
  }
  //check duplicate form no
  function chek_duplicate_formno_exist(formno) {
    if (formno) {
      /*var course=$("#course_type").val();
   
         if(course=='R')
         {
           var newforno=formno;
         }
         else
         {//for parttime even semster
           var newforno=formno;
         }*/
      var newforno = formno;
      $.ajax({
        type: 'POST',
        async: false,
        url: '<?= base_url() ?>Enquiry/chek_formno_exist_withapprove',
        data: 'newforno=' + newforno,
        success: function(resp) {
          if (resp == "duplicate") {
            //alert("You have already registered with us using this mobile no.");
            $("#errormsgform").html("<span style='color:red;''>Form no does not exist in Database</span>");
            $("#formno").val("");
            $('#formno').focus();
            $("#btn_submit").prop('disabled', true);
            //alert(html);
            //$("#usrdetails").html(html);
            return false;
          } else {

            $.ajax({
              type: 'POST',
              url: '<?= base_url() ?>StudentRegistration/chek_formno_exist',
              data: 'newforno=' + newforno,
              success: function(resp) {
                var resp1 = resp.split("~");
                var dup = resp1[0];

                var mob = JSON.parse(resp1[1]);

                if (dup == "Duplicate") {
                  //alert("You have already registered with us using this mobile no.");
                  $("#errormsgform").html("<span style='color:red;''>You have already registered with us using this form no.</span>");
                  $("#formno").val("");
                  $('#formno').focus();
                  $("#btn_submit").prop('disabled', true);
                  //alert(html);
                  //$("#usrdetails").html(html);
                  return false;
                } else {

                  $("#errormsgform").html("");
                  $("#btn_submit").prop('disabled', false);
                  return true
                }

              }
            })
          }

        }
      });

    } else {

    }
  }

  function getdd_details(m) {

    var value = m.value;
    // alert(value);
    if (value == 'OL') {
      $(".Transaction_lable").html("Recepit No");
      $(".Transaction_box").show();
    } else if (value == 'POS') {
      $(".Transaction_lable").html("POS No");
      $(".Transaction_box").show();
    } else {
      $(".Transaction_lable").html("");
      $(".Transaction_box").hide();
    }


  }

  $(document).ready(function() {
    $('#citizen_id').on("cut copy paste", function(e) {
      e.preventDefault();
    });

    $('.TransToAdmin').change(function() {
      var value = $('input[name=TransToAdmin]:checked').val();
      if (value == 'N') {
        $('.NoTranstoAdmin').show();
      } else {
        $('.NoTranstoAdmin').hide();
      }
    })

    $('#state_id').on('change', function() {
      var stateID = $(this).val();
      $('#city_id').html('<option value="">Select city </option>');
      if (stateID) {
        $.ajax({
          type: 'POST',
          url: '<?= base_url() ?>StudentRegistration/getStatewiseDistrict',
          data: 'state_id=' + stateID,
          success: function(html) {
            //alert(html);
            $('#district_id').html(html);
          }
        });
      } else {
        $('#district_id').html('<option value="">Select state first</option>');
      }
    });
    var stateID = 27;

    if (stateID) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/getStatewiseDistrict',
        data: 'state_id=' + stateID,
        success: function(html) {
          //alert(html);
          $('#district_id').html(html);
        }
      });
    } else {
      $('#district_id').html('<option value="">Select state first</option>');
    }


    $('#district_id').on('change', function() {
      var stateID = $("#state_id").val();
      var district_id = $(this).val();
      if (district_id) {
        $.ajax({
          type: 'POST',
          url: '<?= base_url() ?>StudentRegistration/getStateDwiseCity',
          data: 'state_id=' + stateID + "&district_id=" + district_id,
          success: function(html) {
            //alert(html);
            $('#city_id').html(html);
          }
        });
      } else {
        $('#city_id').html('<option value="">Select district first</option>');
      }
    });

    $("#btn_pdf").click(function() {

      var enquiry_id = $("#enquiry_id").val();
      //alert(enquiry_id);
      window.location.href = '<?php echo base_url(); ?>StudentRegistration/download_admission_form/' + enquiry_id;
    })
    //////////////////
  });

  function get_school(val1, schoola = 0, year = '') {

    var Campus_City = $('#Campus_City').val();
    var Campus = $('#Campus').val();

    if (Campus) {
      if (Campus == "SF") {
        $("#set_data").html('Select Institute');
      } else {
        $("#set_data").html('Select School');
      }


      /*if(Campus=="SUN"){
			  $("#university_data").removeClass('hidden');
		      $("#old_data").addClass('hidden');
		 }
		 else*/
      {
        $.ajax({
          type: 'POST',
          url: '<?= base_url() ?>StudentRegistration/Get_CampusType',
          data: {
            Campus: Campus,
            Campus_City: Campus_City,
            school: schoola,
            year: year
          },
          success: function(html) {
            //alert(html);
            if (html != '') {

              $('#school_name').html(html);
            } else {
              $('#school_name').html('<option value="">No  found</option>');
            }
            $('#CoursesType').html('<option value="">Select Type</option>');
            $('#Courses').html('<option value="">Select Courses</option>');

            $("#university_data").addClass('hidden');
            $("#old_data").removeClass('hidden');
          }
        });

      }
    } else {
      $("#university_data").addClass('hidden');
      $("#old_data").addClass('hidden');

    }


    /* if(val1){
   		   //alert(schoola);
		   var last_qualification= $("#last_qualification").val();
		   last_qualification
   		  $.ajax({
                   type: 'POST',
                   url: '<?= base_url() ?>StudentRegistration/fetch_school',
                   data: {'val' : last_qualification,'schoola':val1},
                   success: function (resp) {
   					
   					$("#school_id").html(resp);
   					$("#stream_id").html('<option value="">Select Stream</option>');
   					$("#course_id").html('<option value="">Select Course Stream</option>');
   					
   					$("#jpfees").val('');
   					//$("#without_scholarship").val('');
   					
                      
                   }
               });  
   	   }*/
  }

  function load_Programme_new(school_name, Qualification, Campus, Campus_City, CoursesType, year) {
    $.ajax({
      type: 'POST',
      url: '<?= base_url() ?>StudentRegistration/Get_CoursesType',
      data: {
        Campus: Campus,
        Campus_City: Campus_City,
        school_name: school_name,
        CoursesType: CoursesType,
        Qualification: Qualification,
        year: year
      },
      success: function(html) {
        //alert(html);
        if (html != '') {
          $('#CoursesType').html(html);
        } else {
          $('#CoursesType').html('<option value="">No  found</option>');
        }
        //$('#CoursesType').val(school_name);

      }
    });
  }

  function get_school1(schoola = 0, Campus, Campus_City, year) {
    if (schoola) {
      // alert(schoola);
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/Get_CampusType',
        data: {
          Campus: Campus,
          Campus_City: Campus_City,
          year: year
        },
        success: function(html) {
          //alert(html);
          if (html != '') {
            $('#school_name').html(html);
          } else {
            $('#school_name').html('<option value="">No  found</option>');
          }
          $('#school_name').val(schoola);

        }
      });
    }
  }

  function load_courses(type, schoola = 0) {
    var highest_qualification = $("#last_qualification").val();
    var Campus = $("#Campus_City").val();
    if (highest_qualification) {
      $.ajax({
        'url': '<?= base_url() ?>StudentRegistration/load_courses',
        'type': 'POST',
        'data': {
          'school': type,
          'highest_qualification': highest_qualification,
          'schoola': schoola,
          'Campus': Campus
        },
        'success': function(data) { //probably this request will return anything, it'll be put in var "data"
          var container = $('#course_id'); //jquery selector (get element by id)
          if (data) {
            $("#stream_id").html('<option value="">Select Stream</option>');
            $("#jpfees").val('');
            // 	$("#without_scholarship").val('');

            container.html(data);
          }
        }
      });
    } else {
      alert("Please Select highest qualification");
    }
  }

  function load_streams(type, schoola = 0) {
    // alert(type);
    var highest_qualification = $("#last_qualification").val();
    var acyear = $("#acyear").val();
    var Campus = $("#Campus_City").val();
    var school_id = $("#school_id").val();
    $.ajax({
      'url': '<?= base_url() ?>StudentRegistration/get_course_streams_yearwise',
      'type': 'POST', //the way you want to send data to your URL
      'data': {
        'course': type,
        'acyear': acyear,
        'schoola': schoola,
        school_id: school_id,
        'highest_qualification': highest_qualification,
        Campus: Campus
      },
      'success': function(data) { //probably this request will return anything, it'll be put in var "data"
        // var container = $('#admission-stream'); //jquery selector (get element by id)"
        if (data) {
          $('#stream_id').html(data);
        }
      }
    });
  }

  function get_fees_value(id, is_admission_type_on_change) {



    var strm_id = $("#stream_id").val();
    var acyear = $("#acyear").val();
    var admission_type = $("#admission_type").val();


    if (strm_id && acyear && admission_type) {
      $("#jpfees").val('');
      //$("#without_scholarship").val('');
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/fetch_academic_fees_for_stream_year',
        data: {
          'strm_id': strm_id,
          'acyear': acyear,
          'admission_type': admission_type
        },
        success: function(resp) {
          var obj = jQuery.parseJSON(resp);
          $("#actual_fee").val(parseInt(obj[0].total_fees));
          $("#without_scholarship").val(parseInt(25 / 100 * obj[0].tution_fees));
          $("#tution_fees").val(parseInt(obj[0].tution_fees));


        }
      });
    } else {
      if (is_admission_type_on_change == 0) {
        if (strm_id == '') {
          alert("Please Select Stream");
        } else if (acyear == "") {
          alert("Please Select Admission year");
        } else if (admission_type == "") {
          alert("Please Select Admission type");
        }
      }
      //alert("Please enter registration no");

    }
  }

  function Form_check(m) {
    var value = m.value;
    if (value == "Y") {
      $('#FTaken').show();
    } else {
      $('#FTaken').hide();
      $("#btn_submit").prop('disabled', false);
    }
  }

  $("#last_qualification").on('change', function() {
    $('#Campus_City').val('');
    $('#Campus').val('');
    $('#school_name').val('');
    $('#stream_id').val('');
  });
  $("#Campus_City").on('change', function() {
    // $('#Campus_City').val('');
    $('#Campus').val('');
    $('#school_name').val('');
    $('#stream_id').val('');
  });


  $('#Campus').on('change', function() {

    var Campus_City = $('#Campus_City').val();
    var Campus = $('#Campus').val();
    var year = $('#acyear').val();

    if (year == '2024-25') {
      //year=default_year;
    }
    //alert(year);
    $('#school_name').val('');
    $('#stream_id').val('');
    if (Campus) {
      if (Campus == "SF") {
        $("#set_data").html('Select Institute');
      } else {
        $("#set_data").html('Select School');
      }


      /*if(Campus=="SUN"){
			  $("#university_data").removeClass('hidden');
		      $("#old_data").addClass('hidden');
		 }
		 else*/
      {
        $.ajax({
          type: 'POST',
          url: '<?= base_url() ?>StudentRegistration/Get_CampusType',
          data: {
            Campus: Campus,
            Campus_City: Campus_City,
            year: year
          },
          success: function(html) {
            //alert(html);
            if (html != '') {

              $('#school_name').html(html);
            } else {
              $('#school_name').html('<option value="">No  found</option>');
            }
            $('#CoursesType').html('<option value="">Select Type</option>');
            $('#Courses').html('<option value="">Select Courses</option>');

            $("#university_data").addClass('hidden');
            $("#old_data").removeClass('hidden');
          }
        });

      }
    } else {
      $("#university_data").addClass('hidden');
      $("#old_data").addClass('hidden');

    }
  });

  /* $('#Campus_City').on('change', function () {

    var Campus_City=$('#Campus_City').val();
	var Campus=$('#Campus').val();
	 if (Campus) {
		 if(Campus_City=="1" && Campus=="SUN"){
			  $("#university_data").removeClass('hidden');
		      $("#old_data").addClass('hidden');
		 }
		 else{
			 $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/Get_CampusType',
        data: {Campus:Campus,Campus_City:Campus_City},
        success: function (html) {
          //alert(html);
          if(html !=''){
          $('#school_name').html(html);
          }else{
          $('#school_name').html('<option value="">No  found</option>');  
          }
		  $('#CoursesType').html('<option value="">Select Type</option>');  
		   $('#Courses').html('<option value="">Select Courses</option>');
		  $("#university_data").addClass('hidden');
		  $("#old_data").removeClass('hidden'); 
        }
      });
		 }
	 }
	 else{
		 $("#university_data").addClass('hidden');
		 $("#old_data").addClass('hidden');
		
	 }
	 });*/
  /*var Campus=$('#Campus').val();
  
    if (Campus) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/Get_CampusType',
        data: {Campus:Campus,Campus_City:Campus_City},
        success: function (html) {
          //alert(html);
          if(html !=''){
          $('#school_name').html(html);
          }else{
          $('#school_name').html('<option value="">No  found</option>');  
          }
        }
      });
    } else {
      $('#school_name').html('<option value="">NotFound</option>');
    }*/


  $('#school_name').on('change', function() {
    var Qualification = $("#last_qualification").val();
    var Campus_City = $('#Campus_City').val();
    var school_name = $(this).val();
    var Campus = $('#Campus').val();

    if (school_name) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/Get_CoursesType',
        data: {
          school_name: school_name,
          Campus: Campus,
          Qualification: Qualification,
          Campus_City: Campus_City
        },
        success: function(html) {
          //alert(html);
          if (html != '') {
            $('#CoursesType').html(html);
          } else {
            $('#CoursesType').html('<option value="">No Type found</option>');
          }
        }
      });
    } else {
      $('#Counsellor').html('<option value="">Select School first</option>');
    }

  });

  $('#Courses').on('change', function() {
    var Qualification = $("#last_qualification").val();
    var Campus_City = $('#Campus_City').val();
    var school_name = $('#school_name').val();
    var Campus = $('#Campus').val();
    var Courses = $('#Courses').val();
    var CoursesType = $('#CoursesType').val();
    var year = $('#acyear').val();
    if (year == '2024-25') {
      //year=default_year;
    }

    if (school_name) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/Get_stream',
        data: {
          school_name: school_name,
          Campus: Campus,
          Qualification: Qualification,
          Campus_City: Campus_City,
          Courses: Courses,
          CoursesType: CoursesType,
          year: year
        },
        success: function(html) {
          //alert(html);
          if (html != '') {
            $('#stream_id').html(html);
          } else {
            $('#stream_id').html('<option value="">No stream found</option>');
          }
        }
      });
    } else {
      $('#Counsellor').html('<option value="">Select School first</option>');
    }

  });


  function get_new_course(school_name, last_qualification, Campus, Campus_City, CoursesType, course_id, year) {

    if (school_name) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/Get_Courses',
        data: {
          school_name: school_name,
          Campus: Campus,
          CoursesType: CoursesType,
          Campus_City: Campus_City,
          course_id: course_id,
          year: year
        },
        success: function(html) {
          //alert(html);
          if (html != '') {
            $('#Courses').html(html);
          } else {
            $('#Courses').html('<option value="">No Course found</option>');
          }
        }
      });
    } else {
      $('#Courses').html('<option value="">Select Programme Type</option>');
    }
  }

  function get_new_stream(school_name, last_qualification, Campus, Campus_City, CoursesType, Courses, stream_id, year) {

    if (school_name) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/Get_stream',
        data: {
          school_name: school_name,
          Campus: Campus,
          CoursesType: CoursesType,
          Campus_City: Campus_City,
          Courses: Courses,
          stream_id: stream_id,
          year: year
        },
        success: function(html) {
          //alert(html);
          if (html != '') {
            $('#stream_id').html(html);
          } else {
            $('#stream_id').html('<option value="">No Course found</option>');
          }
        }
      });
    } else {
      $('#stream_id').html('<option value="">Select Programme Type</option>');
    }
  }

  $('#CoursesType').on('change', function() {
    var CoursesType = $(this).val();
    var Campus_City = $('#Campus_City').val();
    var Campus = $('#Campus').val();
    var school_name = $('#school_name').val();
    var year = $('#acyear').val();

    if (year == '2024-25') {
      //year=default_year;
    }
    if (school_name) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/Get_Courses',
        data: {
          school_name: school_name,
          Campus: Campus,
          CoursesType: CoursesType,
          Campus_City: Campus_City,
          year: year
        },
        success: function(html) {
          //alert(html);
          if (html != '') {
            $('#Courses').html(html);
          } else {
            $('#Courses').html('<option value="">No Course found</option>');
          }
        }
      });
    } else {
      $('#Courses').html('<option value="">Select Programme Type</option>');
    }
  });

  function validateForm() {
    var last_qualification = $('#last_qualification').val();
    var admission_type = $('#admission_type').val();
    var Campus_City = $('#Campus_City').val();
    var Campus = $('#Campus').val();
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var mobile = $("#mobile").val();
    var nationality = $('input[name="nationality"]:checked').val();
    var int_country_id = $('#int_country_id').val();

    var int_state = $('#int_state').val();
    var int_city = $('#int_city').val();
    var state_id = $('#state_id').val();
    var district_id = $('#district_id').val();
    var city_id = $('#city_id').val();
    var pincode = $('#pincode').val();
    var gender = $('#gender').val();

    var aadhar_card = $('#aadhar_card').val();
    var school_name = $('#school_name').val();
    var CoursesType = $('#CoursesType').val();
    var Courses = $('#Courses').val();
    var stream_id = $('#stream_id').val();
    var email_id = $('#email_id').val();
    var val = mobile;
    var citizen_id = $('#citizen_id').val();
    var regex = /^[A-Za-z0-9]*$/;


    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email_id)) {

    } else {
      alert("You have entered an invalid email address!")
      return (false);
    }
    if (/^\d{10}$/.test(val)) {
      // value is ok, use it
    } else {
      alert("Invalid mobile number; must be ten digits");

      return false
    }

    var regexn = /^[a-zA-Z]*$/;
    var regexm = /^\d{10}$/;
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email_id)) {

    } else {
      alert("You have entered an invalid email address!")
      return (false);
    }
    if (regexn.test(first_name)) {

    } else {
      alert("First Name Allows Only Alphabets!")
      return (false);
    }
    if (regexn.test(last_name)) {

    } else {
      alert("Last Name Allows Only Alphabets!")
      return (false);
    }

    if (/^\d{10}$/.test(val)) {
      // value is ok, use it
    } else {
      alert("Invalid mobile number; must be ten digits");

      return false
    }
    var altarnet_mobile = $("#altarnet_mobile").val();
    if (altarnet_mobile != '') {
      if (/^\d{10}$/.test(altarnet_mobile)) {
        // value is ok, use it
      } else {
        alert("Invalid alternate number; must be ten digits");

        return false
      }
    }
    if (altarnet_mobile == val) {
      alert("Alternate number must be different from previous Mobile No.");
      return false;
    } else if (nationality == 1) {
      if (state_id == "") {
        alert("Please select State");
        return false;
      } else if (district_id == "") {
        alert("Please select District");
        return false;

      } else if (pincode != "") {
        if (pincode.length != 6) {
          alert("Please enter proper pincode");
          return false;
        }

      } else if (city_id == "") {
        alert("Please select City");
        return false;

      } else if (aadhar_card == "") {
        alert("Please enter  Aadhar card");
        return false;
      } else if (aadhar_card.length != 12) {
        alert("Please enter proper aadhar card");
        return false;
      }
    } else if (nationality == 2) {
      if (int_country_id == "") {
        alert("Please select country");
        return false;
      } else if (int_state == "") {
        alert("Please select State");
        return false;

      } else if (citizen_id == "") {
        alert("Please select Citizen-Ship-id");
        return false;
      } else if (!regex.test(citizen_id)) {
        alert("Upper letters and numbers allows only");
        return false;
      }
    }

    //  Campus_City
    if (last_qualification == '') {
      alert("Please enter your last qualification");

      return false;
    }
    if (admission_type == "") {
      alert("Please select admission type");
      return false;

    }
    if (first_name == "") {
      alert("Please enter first name");
      return false;

    }
    if (last_name == "") {
      alert("Please enter last name");
      return false;

    }
    if (mobile == "") {
      alert("Please enter mobile");
      return false;

    }
    if (pincode == "") {
      alert("Please enter pincode");
      return false;

    }
    if (gender == "") {
      alert("Please select gender");
      return false;

    }

    if (Campus_City == "") {
      alert("Please select Campus City");
      return false;

    }
    if (Campus == "") {
      alert("Please select Campus Name");
      return false;

    }
    if (school_name == "") {
      alert("Please select School/Institute");
      return false;

    }
    if (CoursesType == "") {
      alert("Please select Programme type");
      return false;

    }
    if (Courses == "") {
      alert("Please select Course");
      return false;

    }
    if (stream_id == "") {
      alert("Please select Stream");
      return false;

    }

    /*if(Campus_City=="1" && Campus=="SUN"){
	var school_name=$('#school_id').val();
	var Courses=$('#Courses').val();//course_id
	var CoursesType=$('#CoursesType').val();//stream_id
	
      if(school_name ==""){
		  alert("Please select School");
           return false;			  
	   }
	   else if(Courses ==""){
		   alert("Please select Course");
           return false;		
		   
	   }
	   else if(CoursesType ==""){
		   alert("Please select Stream");
           return false;
		   
	   }
	      
   }
   else{
	   var school_name=$('#school_name').val();
	   var Courses=$('#Courses').val();
	   var CoursesType=$('#CoursesType').val();
	   if(school_name ==""){
		  alert("Please select School");
           return false;			  
	   }
	   else if(Courses ==""){
		   alert("Please select Course");
           return false;		
		   
	   }
	   else if(CoursesType ==""){
		   alert("Please select Course type");
           return false;
		   
	   }
	   else{
		   
	   }
   }*/
    return true;
  }


  function handleClick(myRadio) {
    if (myRadio.value == 1) {
      $("#indian_add").removeClass('hidden');
      $("#others_add").addClass('hidden');
      $("#adhar_add").removeClass('hidden');
      $("#aadhar_card").prop('required', true);
      $("#citizen_id").prop('required', false);
      $("input[name='category']").prop('required', true);
    } else if (myRadio.value == 2) {
      $("#indian_add").addClass('hidden');
      $("#others_add").removeClass('hidden');
      $("#adhar_add").addClass('hidden');
      $("#aadhar_card").prop('required', false);
      $("#citizen_id").prop('required', true);
      $("input[name='category']").prop('required', false);
    }
  }

  //$("#aadhar_card").keyup(function(){
  function check_validation_for_aadhar(aadhar) {
    var stateID = aadhar;
    var year = $("#acyear").val();;
    var mobile = $("#mobile").val();
    var n = stateID.length;
    // $('.aadhar_msg').remove();
    if (n == 12) {

      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/Checkaadhar',
        data: 'stateID=' + stateID + '&mobile=' + mobile + "&year=" + year,
        dataType: "json",
        success: function(html) {

          if (html.created_by == 0) {
            check_is_exists_in_main_erp(stateID, year);
          } else {
            var user_id = '<?php echo $this->session->userdata("uid"); ?>';
            if (html.created_by == user_id) {

              if (html.froms == 1) {
                $('.aadhar_msg').html('');
                $("#btn_submit").attr("disabled", false);
              } else {
                $("#btn_submit").attr("disabled", true);
                $('.aadhar_msg').html('<span style="color:#C00">Duplicate Adhar No</span>');
              }
            } else {
              $("#btn_submit").attr("disabled", true);
              $('.aadhar_msg').html('<span style="color:#C00">Duplicate Adhar No</span>');
            }
            //alert("created");
          }
          /*if(html==0){
							   $('.aadhar_msg').html('');
							   $("#btn_submit").removeAttr("disabled");
							     check_is_exists_in_main_erp(stateID);
							   
                         //  $('#aadhar_card').html(html); 
						// $('.aadhar_msg').append('<span style="color:#C00">please enter 12 Digit Aadhar No</span>');
						   }else{
							   $("#btn_submit").attr("disabled", true);
						  $('.aadhar_msg').html('<span style="color:#C00">Duplicate Adhar No</span>');
						   }*/
        }
      });
    } else {
      $('.aadhar_msg').html('');
      //$('.aadhar_msg').append('<span style="color:#C00">please enter 12 Digit Aadhar No</span>');
    }
  }
  //});


  function check_is_exists_in_main_erp(aadhar, year) {
    $.ajax({
      type: 'POST',
      url: '<?= base_url() ?>StudentRegistration/check_is_exists_in_main_erp',
      data: 'aadhar=' + aadhar + "&year=" + year,
      success: function(html) {
        if (html == 0) {
          $('.aadhar_msg').html('');
          $("#btn_submit").removeAttr("disabled");

        } else {
          $("#btn_submit").attr("disabled", true);
          $('.aadhar_msg').html('<span style="color:#C00">Already admission done</span>');
        }
      }
    });
  }

  $('#int_state').on('change', function() {
    // alert('inside'); 
    var stateID = $(this).val();
    //alert('stateid '+stateID);
    if (stateID) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>Comman_function/getcitybystates',
        data: 'stateid=' + stateID,
        success: function(html) {

          $('#int_city').html(html);
        }
      });
    } else {
      $('#int_city').html('<option value="">Select state first</option>');
    }
  });

  $('#int_country_id').on('change', function() {

    var c = $(this).val();
    $.ajax({
      type: 'POST',
      url: '<?= base_url() ?>Comman_function/getStatebycountry',
      data: {
        'country_id': c
      },
      success: function(html) {
        //alert(html);
        $('#int_state').html(html);
        $('#int_city').html('<option value="">Select </option>');
      }
    });
  });

  function get_states(country_id, state) {
    var c = country_id;
    $.ajax({
      type: 'POST',
      url: '<?= base_url() ?>Comman_function/getStatebycountry',
      data: {
        'country_id': c
      },
      success: function(html) {
        //alert(html);
        $('#int_state').html(html);
        $('#int_state').val(state);
      }
    });
  }

  function get_city(int_state, int_city) {
    var stateID = int_state;
    //alert('stateid '+stateID);

    $.ajax({
      type: 'POST',
      url: '<?= base_url() ?>Comman_function/getcitybystates',
      data: 'stateid=' + stateID,
      success: function(html) {

        $('#int_city').html(html);
        $('#int_city').val(int_city);

      }
    });

  }

  $("#mobile").keyup(function() {
    var mobile = $(this).val();
    var year = $("#acyear").val();
    var n = mobile.length;
    // $('.aadhar_msg').remove();
    if (n >= 10) {

      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/checkmobileinerpcheckmobileinerp',
        data: 'mobile=' + mobile + "&year=" + year,
        dataType: "json",
        success: function(html) {
          if (html.length == 0) {
            $('.mobile_msg').html('');
            $("#btn_submit").removeAttr("disabled");
            // check_is_exists_in_main_erp(stateID);

            //  $('#aadhar_card').html(html); 
            // $('.aadhar_msg').append('<span style="color:#C00">please enter 12 Digit Aadhar No</span>');
          } else {

            //	$("#btn_submit").attr("disabled", true);
            if (html[0].admission == 1) {
              $('.mobile_msg').html('<span style="color:#C00">Admission already done</span>');
              $("#btn_submit").attr("disabled", true);

            }
            if (html[0].admission == 0) {
              $('.mobile_msg').html('<span style="color:#C00">Already registered</span>');
              $("#btn_submit").attr("disabled", true);
            }

          }

        }
      });
    } else {
      $('.mobile_msg').html('');
      //$('.aadhar_msg').append('<span style="color:#C00">please enter 12 Digit Aadhar No</span>');
    }
  });

  $("#altarnet_mobile").keyup(function() {
    var mobile = $(this).val();
    var year = $("#acyear").val();
    var n = mobile.length;
    // $('.aadhar_msg').remove();
    if (n >= 10) {

      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/checkmobileinerpcheckmobileinerp',
        data: 'mobile=' + mobile + "&year=" + year,
        dataType: "json",
        success: function(html) {
          if (html.length == 0) {
            $('.altarnet_mobile_msg').html('');
            $("#btn_submit").removeAttr("disabled");
            // check_is_exists_in_main_erp(stateID);

            //  $('#aadhar_card').html(html); 
            // $('.aadhar_msg').append('<span style="color:#C00">please enter 12 Digit Aadhar No</span>');
          } else {

            //$("#btn_submit").attr("disabled", true);
            if (html[0].admission == 1) {
              $('.altarnet_mobile_msg').html('<span style="color:#C00">Admission already done</span>');
              $("#btn_submit").attr("disabled", true);

            }
            if (html[0].admission == 0) {
              $('.altarnet_mobile_msg').html('<span style="color:#C00">Already registered</span>');
              $("#btn_submit").attr("disabled", true);
            }

          }

        }
      });
    } else {
      $('.mobile_msg').html('');
      //$('.aadhar_msg').append('<span style="color:#C00">please enter 12 Digit Aadhar No</span>');
    }
  });

  $("#email_id").keyup(function() {
    var email = $(this).val();
    var year = $("#acyear").val();
    var n = email.length;
    // $('.aadhar_msg').remove();
    if (n >= 10) {

      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/checkmobileinerpcheckemailinerp',
        data: 'email=' + email + "&year=" + year,
        dataType: "json",
        success: function(html) {
          if (html.length == 0) {
            $('.email_id_msg').html('');
            $("#btn_submit").removeAttr("disabled");
            // check_is_exists_in_main_erp(stateID);

            //  $('#aadhar_card').html(html); 
            // $('.aadhar_msg').append('<span style="color:#C00">please enter 12 Digit Aadhar No</span>');
          } else {

            //$("#btn_submit").attr("disabled", true);
            if (html[0].admission == 1) {
              $('.email_id_msg').html('<span style="color:#C00">Admission already done</span>');
              $("#btn_submit").attr("disabled", true);


            }
            if (html[0].admission == 0) {
              $('.email_id_msg').html('<span style="color:#C00">Already registered</span>');
              $("#btn_submit").attr("disabled", true);
            }

          }

        }
      });
    } else {
      $('.mobile_msg').html('');
      //$('.aadhar_msg').append('<span style="color:#C00">please enter 12 Digit Aadhar No</span>');
    }
  });



  function aadharValidation11() {
    // alert("Validating aadhar....");
    // $('.adhar_msg').html('');
    var aadharNumber = $("#aadhar_card").val();
    if (aadharNumber.length == 12) {
      var d = [
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
        [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
        [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
        [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
        [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
        [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
        [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
        [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
        [9, 8, 7, 6, 5, 4, 3, 2, 1, 0]
      ]
      var p = [
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
        [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
        [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
        [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
        [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
        [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
        [7, 0, 4, 6, 9, 1, 3, 2, 5, 8]
      ]
      if (aadharNumber.length != 12) {
        $("#aadhar_card").val('');
        alert("Aadhar should be 12 Digit");
        //return false;
      } else {
        if (isNaN(aadharNumber)) {
          $("#aadhar_card").val('');
          alert("Aadhaar must be a number");

          // return false;
        } else {
          var c = 0;
          var invertedArray = aadharNumber.split('').map(Number).reverse();
          var len = invertedArray.length;
          for (var i = 0; i < len; i++) {
            c = d[c][p[(i % 8)][invertedArray[i]]];
          }
          if ((c === 0) == false) {
            $("#aadhar_card").val('');
            alert("Please enter proper aadhar card");
          } else {
            check_validation_for_aadhar(aadharNumber);
          }
          //return (c === 0);
        }

      }
    }
  }

  function aadharValidation111() {
    // $('.adhar_msg').html('');
    var aadharNumber = $("#adhar_search").val();
    if (aadharNumber.length == 12) {
      var d = [
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
        [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
        [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
        [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
        [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
        [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
        [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
        [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
        [9, 8, 7, 6, 5, 4, 3, 2, 1, 0]
      ]
      var p = [
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
        [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
        [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
        [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
        [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
        [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
        [7, 0, 4, 6, 9, 1, 3, 2, 5, 8]
      ]
      if (aadharNumber.length != 12) {
        $("#adhar_search").val('');
        alert("Aadhar should be 12 Digit");
        //return false;
      } else {
        if (isNaN(aadharNumber)) {
          $("#adhar_search").val('');
          alert("Aadhaar must be a number");

          // return false;
        } else {
          var c = 0;
          var invertedArray = aadharNumber.split('').map(Number).reverse();
          var len = invertedArray.length;
          for (var i = 0; i < len; i++) {
            c = d[c][p[(i % 8)][invertedArray[i]]];
          }
          if ((c === 0) == false) {
            $("#adhar_search").val('');
            alert("Please enter proper Aadhar card");
          } else {
            //check_validation_for_aadhar(aadharNumber);	
          }
          //return (c === 0);
        }

      }
    }

  }


  $("#citizen_id").on('keyup blur tab', function(e) {

    var citizen_id = $("#citizen_id").val();
    var n = citizen_id.length;
    // $('.aadhar_msg').remove();
    if (n >= 4) {
      // alert('h2');
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>StudentRegistration/checkcitizenshipid',
        data: 'citizen_id=' + citizen_id,
        dataType: "json",
        success: function(html) {
          if (html.length == 0) {
            $('.citizen_id_msg').html('');
            $("#btn_submit").removeAttr("disabled");

          } else {
            var user_id = '<?php echo $this->session->userdata("uid"); ?>';
            var enquiry_id = $("#enquiry_id").val();
            if (html[0].created_by == user_id && html[0].enquiry_id == enquiry_id) {

            } else {
              $('.citizen_id_msg').html('<span style="color:#C00"> Already Registered</span>');
              $("#btn_submit").attr("disabled", true);
            }

          }
        }

      });
    } else {
      $('.citizen_id').html('');
    }

  });
</script>