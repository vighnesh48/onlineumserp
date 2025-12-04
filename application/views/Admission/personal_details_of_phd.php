<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<link href="<?= site_url() ?>assets/css/pick.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script type="text/javascript">
   <!--
   function copyBilling (f) {
       var s, i = 0;
       if(f.same.checked == true) {
   
       while (s = ['A', 'B', 'C', 'D', 'country', 'pc'][i++]) {f.elements['shipping_' + s].value = f.elements['bill_' + s].value};
       }
       if(f.same.checked == false) {
       // alert(false);
       while (s = ['A', 'B', 'C', 'D', 'country', 'pc'][i++]) {f.elements['shipping_' + s].value ="";};
       }
   }
   // -->
</script>
<div id="content-wrapper">
<ul class="breadcrumb breadcrumb-page">
   <div class="breadcrumb-label text-light-gray">You are here: </div>
   <li><a href="#">Masters</a></li>
   <li class="active"><a href="#">PHD Admission Form</a></li>
</ul>
<div class="page-header">
   <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;PHD Admission Form</h1>
      <div class="col-xs-12 col-sm-8">
         <div class="row">
            <hr class="visible-xs no-grid-gutter-h">
         </div>
      </div>
   </div>
   <div class="row ">
      <div class="col-sm-12">
         <div class="panel">
            <div class="panel-body">
               <div class="xtable-info">
                  <div id="dashboard-recent" class="panel panel-warning">
                     <?php include 'stepbar_phd.php';?>
                     <div class="tab-content">
                        <form method="post" action="<?=base_url()?>phd_admission/update_personalDetails/" enctype="multipart/form-data">
                        <div id="personal-details" class="setup-content widget-comments panel-body tab-pane fade active in">
                           <!-- Panel padding, without vertical padding -->
                           <div class="panel">
                              <div class="panel-heading">Personal Details
                                 <?= $astrik ?>
                                
                              </div>
                              <div class="panel-body">
                                 <!--  <input type="hidden" value="" id="campus_id" name="campus_id" />-->
                                 <div class="panel-padding no-padding-vr">
                                     
                                     
                                     
                    <div class="form-group">
                        
                        
                              <label class="col-sm-3">Academic Year <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                      <select id="acyear" name="acyear" class="form-control" onchange="getad(value,'')" required>
                                  
                                 <!--   <option value="2018">2018-19</option>-->

                                       <?php $number = range(2018,date("Y")); 
                                    foreach ($number as $key => $value) {
                                        if($value==$emp_list[0]['academic_year'])
                                        {
                                            $selected='selected';
                                        }
                                        else
                                        {
                                            $selected='';
                                        }
                                        echo "<option value='$value' ".$selected." >$value</option>";
                                        # code...
                                    }

                                    ?>
                               </select>
                               
                               
                                </div>
                                
                                
                                     <!--label class="col-sm-3">Student GRN Number</label>
                              <div class="col-sm-3">
                         <input type="text" id="sgrn" name="sgrn" class="form-control" value="<?= isset($emp_list[0]['general_reg_no']) ? $emp_list[0]['general_reg_no'] : ''; ?>" placeholder="Student GRN Number" />
                              </div-->
                </div>
                
                                     
                                  <div class="form-group">
                              <label class="col-sm-3">Admission Type <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                   <select name="admission_type" name="admission_type" class="form-control" required disabled>
									  <option value="">Select Type</option>
                                    <option value="6"<?php if($emp_list[0]['is_fellowship']==6){echo "selected";} ?>>Part Time</option>
                                    <option value="7"<?php if($emp_list[0]['is_fellowship']==7){echo "selected";} ?>>Full Time</option>
                                    <option value="8"<?php if($emp_list[0]['is_fellowship']==8){echo "selected";} ?>>Full Time with Fellowship</option>
                                 
                               </select>
                               
                               
                                </div>
                                
                                      <label class="col-sm-3">Admission Form Number </label>
                              <div class="col-sm-3">
                               
                                <input id="sfnumber" name="sfnumber" class="form-control" value="<?= isset($emp_list[0]['form_number']) ? $emp_list[0]['form_number'] : ''; ?>" placeholder="Admission Form Number " type="text" disabled>
                               
                               
                               
                                </div>
                                
                                
                                
                                
                                
                                
                                
                                
                              </div>
                                  <div class="form-group">
                                          <label class="col-sm-3">Admission Batch <?= $astrik ?></label>
                              <div class="col-sm-3">                              
                                      <select id="admission_cycle" name="admission_cycle" class="form-control"  required >
                                        <option value="">Select Type</option>
                                        <option>JAN-18</option>
                                        <option>JULY-18</option>
                               </select>
                                </div>
                              <label class="col-sm-3">School <?= $astrik ?></label>
                              <div class="col-sm-3" >
                                <select name="admission-school" id="admission_school" readonly class="form-control" onchange="load_courses(this.value)" required>
                              <option value="">Select School</option>
                                  <?php
									foreach ($school_list as $schools) {
										if ($schools['school_id'] == $emp_list[0]['admission_school']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $schools['school_id'] . '"' . $sel . '>' . $schools['school_name'] . '</option>';
									}
									?>
                               </select>
                              </div>
                              </div>
                              
                                     
                                     
                                     
                                    <div class="form-group">
                                       <label class="col-sm-3">Course <?= $astrik ?></label>
                                       <div class="col-sm-3" >
                                          <select name="admission-course" class="form-control" onchange="load_streams(this.value)" required disabled>
                                             <option value="">Select</option>
                                             <?php
                                                foreach ($course_details as $course) {
                                                    if ($course['course_id'] == $coursedet[0]['course_id']) {
                                                        $sel = "selected";
                                                    } else {
                                                        $sel = '';
                                                    }
                                                    echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
                                                }
                                                ?>
                                          </select>
                                       </div>
                                       <script>
                                          var base_url = '<?php
                                             echo site_url();
                                             ?>';
                                           function load_streams(type){
                                          // alert(type);
                                          
                                          $.ajax({
                                          'url' : base_url + '/Ums_admission/load_streams',
                                          'type' : 'POST', //the way you want to send data to your URL
                                          'data' : {'course' : type},
                                          'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                                          var container = $('#semest'); //jquery selector (get element by id)
                                          if(data){
                                          //   alert(data);
                                          //alert("Marks should be less than maximum marks");
                                          //$("#"+type).val('');
                                          container.html(data);
                                          }
                                          }
                                          });
                                          }
                                          
                                       </script>
                                       <label class="col-sm-3">Stream <?= $astrik ?></label>
                                      <?php
                                     //var_dump($emp_list[0]);
                                     echo $emp_list['admission-stream'];
                                      ?>
                                       <div class="col-sm-3" id="semest" >
                                          <select name="admission-branch" class="form-control" required disabled>
                                             <option value="">Select</option>
                                             <?php
                                                foreach ($stream as $branch) {
                                                   ?>
                                                   
                                                    <option value="<?php echo $branch['stream_id']?>" <?php if($branch['stream_id'] == $emp_list[0]['admission_stream']){echo "selected";} ?> > <?php echo $branch['stream_name'] ?></option>;
                                                    
                                                    <?php
                                                }
                                                ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                     
                                       <label class="col-sm-3">Student Name <?= $astrik ?></label>
                                       <div class="col-sm-3">
                                           
                                           <input type="hidden" name="student_id" value="<?php echo $emp_list[0]['stud_id'];  ?>">
                                          <input data-bv-field="slname" id="sfname" name="sfname" class="form-control" value="<?= isset($emp_list[0]['first_name']) ? $emp_list[0]['first_name'] : ''; ?>" placeholder="student Name" type="text" >
                                       </div>
                                     <label class="col-sm-3">Father's/Husband Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                                <input data-bv-field="sfname1" id="sfname1" name="sfname1" class="form-control" value="<?= isset($emp_list[0]['father_fname']) ? $emp_list[0]['father_fname'] : ''; ?>" placeholder="Father Name" type="text">
                               </div>
                                    </div>
                                  
                                    <div class="form-group">
                                       <label class="col-sm-3">Mother Name <?= $astrik ?></label>
                                       <div class="col-sm-3">
                                          <input data-bv-field="sfname" id="sfname2" name="sfname2" class="form-control" value="<?= isset($emp_list[0]['mother_name']) ? $emp_list[0]['mother_name'] : ''; ?>" placeholder="First Name" type="text" required>
                                          <i data-bv-icon-for="sfname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small> 
                                       </div>
                                          <label class="col-sm-3">Aadhar Card No </label>
                              <div class="col-sm-3">
                                <input type="text" id="saadhar" maxlength="12" value="<?= isset($emp_list[0]['adhar_card_no']) ? $emp_list[0]['adhar_card_no'] : ''; ?>" name="saadhar" class="numbersOnly form-control" >
                              
                            </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-sm-3">Date of Birth <?= $astrik ?></label>
                                       <div class="col-sm-3 date" id="dob-datepicker"> <div class="input-group">
                                          <input type="text" id="dob" name="dob" class="form-control"  value="<?= isset($emp_list[0]['dob']) ? $emp_list[0]['dob'] : ''; ?>" placeholder="Date of Birth" required />
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                                       </div></div>
                                       
                                       
                                       
                                  <label class="col-sm-3">Place Of Birth <?= $astrik ?></label>
                              <div class="col-sm-3 ">
        <input type="text" id="pob" name="pob" class="form-control"  value="<?= isset($emp_list[0]['birth_place']) ? $emp_list[0]['birth_place'] : ''; ?>" placeholder="Place of Birth" required />
                                </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-sm-3">Gender <?= $astrik ?></label>
                                       <div class="col-sm-4">
                                          <label>
                                          <input type="radio" value="M" id="gender" name="gender" <?php if(isset($emp_list[0]['gender']) && $emp_list[0]['gender']=='M'){ echo "checked"; }?> required>
                                          &nbsp;&nbsp;Male</label>
                                    
                                          <label>
                                          <input type="radio" value="F" id="gender" name="gender" <?php if(isset($emp_list[0]['gender']) && $emp_list[0]['gender']=='F'){ echo "checked"; }?> required>
                                          &nbsp;&nbsp;Female</label>
                                    
                                       <label>
                                  <input type="radio" value="T" id="gender" name="gender" <?php if(isset($emp_list[0]['gender']) && $emp_list[0]['gender']=='T'){ echo "checked"; }?> required>
                                 Transgender</label>
                                          <label>
                                        
                                       </div>
                                       <label class="col-md-2 control-label">Blood Group:<?=$astrik?></label>
                            <div class="col-md-3">
                          <select  class="form-control" name="blood_gr" id="blood_gr">
                          <option value="">Select</option>
                          <?php
                           $str=$str1=$str2=$str3=$str4=$str5=$str6=$str7=$str8=$str9=$str10=$str11=$str12="";
                          if($emp_list[0]['blood_group']=='A+'){
                               $str="selected";
                               }elseif($emp_list[0]['blood_group']=='A-'){
                              $str1="selected";  
                               }elseif($emp_list[0]['blood_group']=='A'){
                              $str2="selected";  
                               }elseif($emp_list[0]['blood_group']=='B+'){
                              $str3="selected";  
                               }elseif($emp_list[0]['blood_group']=='B-'){
                              $str4="selected";  
                               }elseif($emp_list[0]['blood_group']=='B'){
                              $str5="selected";  
                               }elseif($emp_list[0]['blood_group']=='AB+'){
                              $str6="selected";  
                               }elseif($emp_list[0]['blood_group']=='AB-'){
                              $str7="selected";  
                               }elseif($emp_list[0]['blood_group']=='AB'){
                              $str8="selected";  
                               }elseif($emp_list[0]['blood_group']=='O+'){
                              $str9="selected";  
                               }elseif($emp_list[0]['blood_group']=='O-'){
                              $str10="selected";   
                               }elseif($emp_list[0]['blood_group']=='O'){
                              $str11="selected";   
                               }elseif($emp_list[0]['blood_group']=='Unknown'){
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
                                       <label class="col-sm-3">Mobile <?= $astrik ?></label>
                                       <div class="col-sm-3">
                                          <input type="text" id="mobile" name="mobile" value="<?= isset($emp_list[0]['mobile']) ? $emp_list[0]['mobile'] : ''; ?>" class="form-control numbersOnly" value="" placeholder="contact no" maxlength="10" required />
                                       </div>
                                       <label class="col-sm-3">Email</label>
                                       <div class="col-sm-3">
                                          <input type="email" id="email_id" name="email_id" class="form-control" value="<?= isset($emp_list[0]['email']) ? $emp_list[0]['email'] : ''; ?>" placeholder="Email" />
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-sm-3">Nationality </label>
                                       <div class="col-sm-3">
                                          <input type="text" id="nationality" name="nationality" class="form-control" value="<?= isset($emp_list[0]['nationality']) ? $emp_list[0]['nationality'] : ''; ?>" placeholder="" />
                                       </div>
                                      
                                       <label class="col-sm-3">Category <?= $astrik ?></label>
                                       <div class="col-sm-3">
                                          <select id="category" name="category" class="form-control" required>
                                             <option value="">Select</option>
                                             <?php
                                                foreach ($category as $category) {
                                                    if ($category['caste_code'] == $emp_list[0]['category']) {
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
                                    
                                    
                                    
                                    
                                 <div class="form-group">
                                     
                                          
                                  <label class="col-sm-3">Sub Caste </label>
                              <div class="col-sm-3 ">
        <input type="text" id="subcaste" name="subcaste" class="form-control"  value="<?= isset($emp_list[0]['sub_caste']) ? $emp_list[0]['sub_caste'] : ''; ?>" placeholder="Sub Caste" />
                                </div>
                                
                                
                              <label class="col-sm-3">Date of Admission <?= $astrik ?></label>
                              <div class="col-sm-3 date" id="doadd-datepicker">
                                  <div class="input-group">
                                <input type="text" id="doadd" name="doadd" class="form-control"  value="<?= isset($emp_list[0]['admission_date']) ? $emp_list[0]['admission_date'] : ''; ?>" placeholder="Date of Admission" required />
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div></div>
                                
                           
                                
                                
                            </div>
                            
                            
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <div class="form-group">
                                       <label class="col-sm-3">Religion <?= $astrik ?></label>
                                       <div class="col-sm-3">
                                          <select id="religion" name="religion" class="form-control" required>
                                             <option value="">Select</option>
                                             <?php
                                                foreach ($religion as $religion) {
                                                    if ($religion['rel_code'] == $emp_list[0]['religion']) {
                                                        $sel = "selected";
                                                    } else {
                                                        $sel = '';
                                                    }
                                                    echo '<option value="' . $religion['rel_code'] . '" ' . $sel . '>' . $religion['rel_name'] . '</option>';
                                                }
                                                ?>
                                          </select>
                                       </div>
                                       <label class="col-sm-3">OMS/MS</label>
                                       <div class="col-sm-3">
                                          <select id="res_state" name="res_state" class="form-control" >
                                             <option value="">Select</option>
                                             <?php
                                                $val  = "";
                                                $val1 = "";
                                                if ($emp_list[0]['domicile_status'] == "MS") {
                                                    $val = "selected";
                                                } elseif ($emp_list[0]['domicile_status'] == "OMS") {
                                                    $val1 = "selected";
                                                }
                                                elseif ($emp_list[0]['domicile_status'] == "NRI") {
                                                    $val2 = "selected";
                                                }
                                                elseif ($emp_list[0]['domicile_status'] == "PIO") {
                                                    $val3 = "selected";
                                                }
                                                ?>
                                             <option <?php
                                                echo $val;
                                                ?> value="MS">MS</option>
                                             <option <?php echo $val1; ?> value="OMS">OMS</option>
                                                 <option  <?php  echo $val2; ?>  value="NRI">NRI</option>
                                          <option  <?php echo $val3; ?>  value="PIO">PIO</option>
                                          </select>
                                       </div>
                                    </div>
                                  <!--   <div class="form-group">
                                       <label class="col-sm-3">Aadhar Card No </label>
                                       <div class="col-sm-3">
                                          <input type="text" id="saadhar" value="<?= isset($emp_list[0]['adhar_card_no']) ? $emp_list[0]['adhar_card_no'] : ''; ?>" name="saadhar" class="numbersOnly form-control" >
                                       </div>
                                    </div> -->
                                    <!--div class="form-group">
                                       <label class="col-sm-3">Hostel(Fill Enclosure I)</label>
                                       <div class="col-sm-3">
                                          <select id="hostel" name="hostel" class="form-control">
                                             <option value="">Select</option>
                                             <?php
                                                $val  = "";
                                                $val1 = "";
                                                if ($admission_details[0]['hostel_required'] == "Y") {
                                                    $val = "selected";
                                                } elseif ($admission_details[0]['hostel_required'] == "N") {
                                                    $val1 = "selected";
                                                }
                                                ?>
                                             <option <?php
                                                echo $val;
                                                ?> value="Y">Yes</option>
                                             <option <?php
                                                echo $val1;
                                                ?>value="N">No</option>
                                          </select>
                                       </div>
                                       <div class="col-sm-2">
                                          <label>
                                     <input type="radio" checked value="R" id="hosteltype" name="hosteltype" <?php if($admission_details[0]['hostel_type'] == "N"){echo "checked";} ?>>
                                          &nbsp;&nbsp;Regular</label>
                                       </div>
                                       <div class="col-sm-3">
                                          <label>
                                          <input type="radio" value="D" id="hosteltype" name="hosteltype" <?php if($admission_details[0]['hostel_type'] == "N"){echo "checked";} ?>>
                                          &nbsp;&nbsp;Day Boarding</label>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-sm-3">Transport(Fill Enclosure II)</label>
                                       <div class="col-sm-3">
                                          <select id="transport" name="transport" class="form-control">
                                            
                                             <?php
                                                $val  = "";
                                                $val1 = "";
                                                if ($admission_details[0]['transport_required'] == "Y") {
                                                    $val = "selected";
                                                } elseif ($admission_details[0]['transport_required'] == "N") {
                                                    $val1 = "selected";
                                                }
                                                ?>
                                             <option <?php
                                                echo $val;
                                                ?>  value="Y">Yes</option>
                                             <option <?php
                                                echo $val1;
                                                ?> value="N">No</option>
                                          </select>
                                       </div>
                                       <label class="col-sm-3">Bording Point</label>
                                       <div class="col-sm-3">
                                          <input type="text" name="bording_point" value="<?= isset($admission_details[0]['transport_boarding_point']) ? $admission_details[0]['transport_boarding_point'] : ''; ?>" placeholder="Bording Point" class="form-control">
                                       </div>
                                    </div-->
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                       <div class="form-group">
                         
                              <label class="col-sm-3">Last Institute Attended</label>
                              <div class="col-sm-3">
                                <input type="text" id="linst" name="linst" value="<?= isset($emp_list[0]['last_institute']) ? $emp_list[0]['last_institute'] : ''; ?>" placeholder="Last Institute Attended" class="form-control">
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-2">Defence Personal</label>
                              <div class="col-sm-2">
                         <input type="checkbox" value="Y" id="defperson" name="defperson" <?php if($emp_list[0]['is_defence']=='Y')echo "checked"; ?>>
                              </div>
                              <label class="col-sm-2">Jammu Kashmir Migrates</label>
                              <div class="col-sm-2">
                                   <input type="checkbox" value="Y" id="jk" name="jk" <?php if($emp_list[0]['is_JKMigrant']=='Y')echo "checked"; ?>>
                                  
                              </div>
                              
                              
                               <label class="col-sm-2">Weather PWD</label>
                              <div class="col-sm-2">
                                   <input type="checkbox" value="Y" id="pwd" name="pwd" <?php if($emp_list[0]['physically_handicap']=='Y')echo "checked"; ?>>
                                  
                              </div>
                              
                              
                            </div>
                            
                            
                            
                            
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                 </div>
                              </div>
                           </div>
                           <div class="panel">
                              <div class="panel-heading">Contact Address
                                 <?= $astrik ?>
                              </div>
                              <div class="panel-body" style="font-size:12px!important">
                                 <table class="table table-new">
                                    <tr>
                                       <th>Permanent Address</th>
                                    </tr>
                                    <tr>
                                       <!--Local Address-->

                                       <!--Permanent Address-->
                                       <td width="50%">
                                          <div class="form-group">
                                             <label  class="col-sm-3">Address: <?=$astrik?></label>
                                             <div class="col-sm-6">
                                                <textarea id="paddress" class="form-control" NAME="paddress" style="margin: 0px; width: 200px; height: 50px;" required><?= isset($perm_address[0]['address']) ? $perm_address[0]['address'] : ''; ?></textarea>
                                             </div>
                                          </div>
                                          <div id='adiv'>

                                          <div class="form-group">
                                             <label  class="col-sm-3">State: <?=$astrik?></label>
                                             <div class="col-sm-6">
                                                <select class="form-control" name="pstate_id" id="pstate_id" required>
                                                   <option value="">select State</option>
                                                   <?php
                                                      if(!empty($states)){
                                                          foreach($states as $stat){
                                                              ?>
                                                   <option value="<?=$stat['state_id']?>"  <?php if($stat['state_id'] == $perm_address[0]['state_id']){echo "selected";} ?>><?=$stat['state_name']?></option>
                                                   <?php 
                                                      }
                                                      }
                                                      ?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label  class="col-sm-3">District: <?=$astrik?></label>
                                             <div class="col-sm-6">
                                                <select class="form-control" name="pdistrict_id" id="pdistrict_id" required>
                                                        <?php
                                                      if(!empty($permdistrict)){
                                                          foreach($permdistrict as $stat){
                                                              ?>
                                                   <option value="<?=$stat['district_id']?>" <?php if($stat['district_id'] == $perm_address[0]['district_id']){echo "selected";} ?> ><?=$stat['district_name']?></option>
                                                   <?php 
                                                      }
                                                      }
                                                      ?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label  class="col-sm-3">City: <?=$astrik?></label>
                                             <div class="col-sm-6">
                                                <select class="form-control" name="pcity" id="pcity">
                                                   <?php
                                                      if(!empty($permcity)){
                                                          foreach($permcity as $stat){
                                                              ?>
                                                   <option value="<?=$stat['taluka_id']?>" <?php if($stat['taluka_id'] == $perm_address[0]['city']){echo "selected";} ?> ><?=$stat['taluka_name']?></option>
                                                   <?php 
                                                      }
                                                      }
                                                      ?>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label  class="col-sm-3">Pin Code: <?=$astrik?></label>
                                             <div class="col-sm-6">
                                                <INPUT TYPE="TEXT" class="form-control numbersOnly" id="ppincode" NAME="ppincode" value="<?= isset($perm_address[0]['pincode']) ? $perm_address[0]['pincode'] : ''; ?>" required>
                                             </div>
                                          </div>
                                          </div>
                                       </td>
                                    </tr>
                                    <?php
                                       if ($emp_list[0]['same'] == "on") {
                                           $val = "checked";
                                       } else {
                                           $val = "";
                                       }
                                       ?>
                                    <!--<tr><td><label style="text-align:left"><input name="same" <?php
                                       echo $val;
                                       ?> onclick="copyBilling (this.form) " type="checkbox">Permanent Address is Same as Local Address</label></td></tr>-->
                                 </table>
                                 <!--label style="text-align:left">
                                 <input name="same" <?php
                                    echo $val;
                                    ?> onclick="copyBilling (this.form) " type="checkbox">
                                 Permanent Address is Same as Local Address</label-->
                              </div>
                           </div>
                         
                           <div class="form-group">
                              <div class="col-sm-4"></div>
                              <div class="col-sm-2">
                                 <button class="btn btn-primary form-control" type="submit">Update</button>
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
</div>
 
<script type="text/javascript">

  var d=$("#acyear").val();

  var ad_cycle='<?php echo $emp_list[0]['admission_cycle'] ?>';
  //alert(ad_cycle);
  getad(d,ad_cycle);

    function getad(value,ad_cycle='')
    {
       

        var res = parseInt(value.substring(2));
		var res1= (res + 1);
        var jan="JAN-"+res1;
        var JULY="JULY-"+res;
        var sel='';
        if(jan==ad_cycle)
        {
          var sel1='selected';
        }
        if(JULY==ad_cycle)
        {
          var sel2='selected';
        }
       
        $("#admission_cycle").html("<option>Select Type</option><option "+sel1+">JAN-"+res1+"</option><option "+sel2+">JULY-"+res+"</option>");


    }
  function qualifcation(id){
      standrd = $("#"+id).val();

      res = id.split("_");
      var n= res[1];
      var streamId = '#stream_name_'+n;
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
        //alert('Inside');
       $.post("<?= base_url() ?>Ums_admission/fetch_qualification_streams/", {getspecial: 1}, function (data) {
         //alert(data);
        $(streamId).html(data);
        
      });
      }else if(standrd=='Diploma'){
        $(streamId).html("<option value='NA'>NA</option>");
        $(streamId+" option[value='NA']").attr("selected", "selected");
        $("tr.diploama").show();
      } 
  } 
  
   function strmsubject(id){
      streamId = $("#"+id).val();
      if(streamId=='Arts' || streamId=='Commerce'){
         $("tr.eng").show(); 
         $("tr.sci").hide(); 
         $("td.12eng").attr("rowspan","1");
      }else if(streamId=='Science'){
          $("td.12eng").attr("rowspan","5");
         $("tr.eng").show(); 
         $("tr.sci").show(); 
      }else{
          
      }

  } 
  
$(document).ready(function(){
 $('#nationality').blur(function(e){
  //alert('gty');
 var n = $(this).val();

 var res = n.toUpperCase();

if(res=='INDIAN' || res=='INDIA'){
    $('#adiv').show();
    $('#ladd').show();
    $('#lstate_id').attr("required", true);
     $('#ldistrict_id').attr("required", true);
      $('#lcity').attr("required", true);
       $('#lpincode').attr("required", true);
       $('#pstate_id').attr("required", true);
     $('#pdistrict_id').attr("required", true);
      $('#pcity').attr("required", true);
       $('#ppincode').attr("required", true);
    
}else{
  $('#lstate_id option:selected').attr("selected",null);
    $('#lstate_id').removeAttr( "required" );
    $('#ldistrict_id').append('<option value="" selected>Select District</option>');
     $('#ldistrict_id').removeAttr( "required" );
     $('#lcity').append('<option value="" selected>Select City</option>');
      $('#lcity').removeAttr( "required" );
      $('#lpincode').val('');    
       $('#lpincode').removeAttr( "required" );
       $('#pstate_id option:selected').attr("selected",null);
       $('#pstate_id').removeAttr( "required" );
       $('#pdistrict_id').append('<option value="" selected>Select District</option>');
     $('#pdistrict_id').removeAttr( "required" );
     $('#pcity').append('<option value="" selected>Select City</option>');
      $('#pcity').removeAttr( "required" );
      $('#ppincode').val('');
       $('#ppincode').removeAttr( "required" );
$('#adiv').hide();
$('#ladd').hide();
}
    });

<?php if(isset($emp_list[0]['nationality'])){
if(strtoupper($emp_list[0]['nationality'])!='INDIAN' || strtoupper($emp_list[0]['nationality']) !='INDIA'){ ?>


  $('#nationality').trigger("blur");

 <?php }  } ?>
    $("tr.10th").hide();
    $("tr.12th").hide();
    $("tr.diploama").hide();
    ///////
    $('#btn_sujee').on('click', function () {
    var reg_no = $("#reg_no").val();
    //alert(reg_no);
    if (reg_no) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>Ums_admission/fetch_sujee_details',
        data: 'reg_no=' + reg_no,
        success: function (html) {
        //  alert(html);
          $('#suJeexamtable').html(html);
        }
      });
    } else {
      alert("Please enter registration no");
      $("#reg_no").focus();
    }
  });
    //SU-JEE Exam show and hide
    $('#chk_sujee').change(function(){
    if($(this).is(":checked"))
    $('#enrol_div').fadeIn('slow');
    else
    $('#enrol_div').fadeOut('slow');

    });
    // Num check logic
    $('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
    });
    
    // City by State
  $('#lstate_id').on('change', function () {
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
  
    // City by State
  $('#ldistrict_id').on('change', function () {
    var district_id = $(this).val();
    var state_ID = $("#lstate_id").val();
  //  alert(state_ID);alert(district_id);
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
  /////////// for perment address
      // City by State
  $('#pstate_id').on('change', function () {
    var stateID = $(this).val();
    
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
  //  alert(state_ID);alert(district_id);
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

   /////////// for Parent's/Guardian's Details *
      // City by State
  $('#gstate_id').on('change', function () {
    var stateID = $(this).val();
    
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
  //  alert(state_ID);alert(district_id);
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
  //////////////////////////////////////////////
    $('#dob-datepicker').datepicker( {format: 'dd-mm-yyyy',autoclose: true});
     $('#doadd-datepicker').datepicker( {format: 'dd-mm-yyyy',autoclose: true});
     
    $('#doc-sub-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker2').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker3').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker4').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker5').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker6').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker7').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker8').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker9').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker10').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker11').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker12').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker13').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker14').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker15').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker16').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker17').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker18').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker19').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#doc-sub-datepicker_ssc').datepicker( {format: 'yyyy-mm',autoclose: true});
    $('#doc-sub-datepicker_hsc').datepicker( {format: 'yyyy-mm',autoclose: true});

    $('#cvaldt1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#cvaldt2').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    $('#cvaldt3').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
    
      $('#dsem1pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem2pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem3pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem4pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem5pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
      $('#dsem6pass_date').datepicker( {format: 'yyyy-mm',autoclose: true});
  
       var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
    // hide the remove button in education table
    var rowCount = $('#eduDetTable >tbody >tr').length;
    if(rowCount<2){$('#remove').hide();}
    else{$('#remove').show();}
    ///

    $("#eduDetTable").on("click","input[name='remove']", function(e){    
    //$("input[name='remove']").on('click',function(){
        var rowCount = $('#eduDetTable tbody tr').length;

        if(rowCount>1){
            $(this).parent().parent('tr').remove();
        }
    }); 
    
    var contentE = '<tr>'+$('#examDettable tbody tr').html()+'</tr>';
    // hide the removeE button in education table
    var rowCountE = $('#examDettable >tbody >tr').length;
  if(rowCountE<2){$('#removeE').hide();}
  else{$('#removeE').show();}

    $("#examDettable").on("click","input[name='addMore']", function(e){    
    //$("input[name='addMore']").on('click',function(){        
        //var contentE = $(this).parent().parent('tr').clone('true');
        $(this).parent().parent('tr').after(contentE);    
        
    });
    $("#examDettable").on("click","input[name='removeE']", function(e){    
    //$("input[name='removeE']").on('click',function(){
        var rowCountE = $('#examDettable tbody tr').length;

        if(rowCountE>1){
            $(this).parent().parent('tr').remove();
        }
    });  
    
    });  
    
    /////////// add more for edu table
    var max_fields      = 5; //maximum input boxes allowed

    var x = 1; //initlal text box count
    $("#addmore").click(function(e){ //on add input button click
 
       e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            var qid= "studqual_"+x;
            var strm = "stream_name_"+x;
            //alert(qid);
      var fieldshtml = "<tr><td> <div class='form-group'><select name='exam_id[]' id='studqual_"+x+"' class='squal form-control' onchange='qualifcation("+'"'+qid+'"'+")' required><option value=''>Select</option><option value='SSC'>SSC</option><option value='HSC'>HSC</option><option value='Graduation'>Graduation</option><option value='Post Graduation'>Post Graduations</option><option value='Diploma'>Diploma</option></select></div>   </td><td><select name='stream_name[]' id='stream_name_"+x+"' onchange='strmsubject("+'"'+strm+'"'+")' style='width:85px' class='form-control' required><option value=''>Select</option> </select></td><td><div class='form-group'><input type='text' name='seat_no[]' class='form-control' value='' placeholder='Board/University' required /></td></div><td><input type='text' name='institute_name[]' class='form-control' value='' placeholder='Name of Board/University' required /></td><td><select name='pass_year[]' class='form-control' required><option value=''>Year</option><?php  for ($y = date('Y'); $y >= date('Y') - 60; $y--) {  ?> <option value='<?=$y?>'><?=$y?></option><? }?></select><select name='pass_month[]' class='form-control' required><option value=''>Month</option><option value='JAN'>JAN</option><option value='FEB'>FEB</option><option value='MAR'>MAR</option><option value='APR'>APR</option><option value='MAY'>MAY</option><option value='JUN'>JUN</option><option value='JUL'>JUL</option><option value='AUG'>AUG</option><option value='SEP'>SEPT</option><option value='OCT'>OCT</option><option value='NOV'>NOV</option><option value='DEC'>DEC</option></select></td><td><input type='text' name='marks_obtained[]' class='form-control' value='' required/></td><td><input type='text' name='marks_outof[]' class='form-control' value='' placeholder='' required/></td><td><input type='text' name='percentage[]' class='form-control' value='' placeholder='' required/></td><td><input type='file' name='sss_doc[]' id='sss_doc' style='width:80px'></td><td><input type='button' class='remove_field btn btn-xs btn-danger btn-flat' id='remove' value='Remove' name='remove' /></td></tr>";
    
            $("#eduDetTable >tbody").append(fieldshtml); //add input box
        }
    });
    $("#eduDetTable >tbody").on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('tr').remove(); x--;
    });

</script>


<!-- steps logic-->