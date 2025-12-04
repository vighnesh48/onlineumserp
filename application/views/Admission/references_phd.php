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
                        <form method="post" action="<?=base_url()?>phd_admission/update_refDetails" enctype="multipart/form-data">
                        <!--start  of references -->
                        <div id="references" class="setup-content">
    
                          <div class="panel">
                            <div class="panel-heading">References details</div>
                            <div class="panel-body">
                              <label class="col-sm-6">Reference (if any) of Relative(Blood
relation) working in SF/SU</label>
                              <table class="table table-bordered">
                                <tr>
                                  <td width="14px">Sr No.</td>
                                  <td>Reference Name</td>
                                  <td>Contact Number</td>
                                </tr>
                                <tr>
                                  <td>1 </td>
                                  <td><input type="text" name="fref1" value="<?= isset($is_from_reference[0]['person_name']) ? $is_from_reference[0]['person_name'] : '' ?>"  /></td>
                                  <td><input type="text" name="frefcont1" maxlength="10" value="<?= isset($is_from_reference[0]['contact_no']) ? $is_from_reference[0]['contact_no'] : '' ?>"></td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td><input type="text" name="fref2" value="<?= isset($is_from_reference[1]['person_name']) ? $is_from_reference[1]['person_name'] : '' ?>"/></td>
                                  <td><input type="text" name="frefcont2" maxlength="10" value="<?= isset($is_from_reference[1]['contact_no']) ? $is_from_reference[1]['contact_no'] : '' ?>" ></td>
                                </tr>
                              </table>
                              <table class="table table-bordered">
                                <tr >
                                  <td colspan="3"><label >Are you related to any person employed with Sandip University: </label>
                                    <select name="reletedsandip">
                                      <?php
    										$val = $val1 = "";
    										if ($is_uni_employed[0]['is_uni_employed'] == 'Y') {
    											$val = "selected";
    										} else {
    											$val1 = "selected";
    										}
    										?>
                                     <option value="">Select</option>
                                      <option <?php echo $val;?> value="Y">Yes</option>
                                      <option <?php echo $val1;?> value="N">No</option>
                                    </select></td>
                                </tr>
                                <tr>
                                  <td><label>Name:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="relatedname" value="<?= isset($is_uni_employed[0]['person_name']) ? $is_uni_employed[0]['person_name'] : '' ?>"/></td>
                                  <td><label>Designation:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="relateddesig" value="<?= isset($is_uni_employed[0]['designation']) ? $is_uni_employed[0]['designation'] : '' ?>"/></td>
                                  <td><label>Relation:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="relatedrelation" value="<?= isset($is_uni_employed[0]['relation']) ? $is_uni_employed[0]['relation'] : '' ?>" /></td>
                                </tr>
                                <tr >
                                  <td colspan="3"><label >Are you related to Alumini of  Sandip University: </label>
                                    <select name="aluminisandip">
                                      <?php
    									$val = $val1 = "";
    									if ($is_uni_alumni[0]['is_uni_alumni'] == 'Y') {
    										$val = "selected";
    									} else {
    										$val1 = "selected";
    									}
    									?>
                                     <option value="">Select</option>
                                      <option <?php echo $val;?> value="Y">Yes</option>
                                      <option <?php echo $val1;?> value="N">No</option>
                                    </select></td>
                                </tr>
                                <tr>
                                  <td><label>Name:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="alumininame" value="<?= isset($is_uni_alumni[0]['person_name']) ? $is_uni_alumni[0]['person_name'] : '' ?>"/></td>
                                  <td><label>passing Year:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="aluminiyear" value="<?= isset($is_uni_alumni[0]['passing_year']) ? $is_uni_alumni[0]['passing_year'] : '' ?>"/></td>
                                  <td><label>Relation:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="aluminirelation" value="<?= isset($is_uni_alumni[0]['relation']) ? $is_uni_alumni[0]['relation'] : '' ?>" /></td>
                                </tr>
                                
                                
                                
                                   
                            
                            <tr>
                              <td colspan="3"><label >Are you  from sister concern institute of SF </label>
                                <select name="concern" id="concern">
                                  <?php
									$val = $val1 = "";
									if ($is_concern[0]['is_concern_ins'] == 'Y') {
										$val = "selected";
									} else {
										$val1 = "selected";
									}
									?>
                                 <option value="">Select</option>
                                  <option <?php echo $val;?> value="Y">Yes</option>
                                  <option <?php echo $val1;?> value="N">No</option>
                                </select></td>
                            </tr>
                           <tr class="concernid">
                               
                              <td><label>Select Institute: </label>
                              <select name="cin" id="cin">
                                <option value="">Select Institute</option>
                                  <option value="SP" <?php if($is_concern[0]['institute']=='SP'){echo "selected";} ?>>SP</option>
                                  <option  value="SIP" <?php if($is_concern[0]['institute']=='SIP'){echo "selected";} ?>>SIP</option>
                                  <option  value="SIPS" <?php if($is_concern[0]['institute']=='SIPS'){echo "selected";} ?>>SIPS</option>
                                  <option  value="SITRC" <?php if($is_concern[0]['institute']=='SITRC'){echo "selected";} ?>>SITRC</option>
                                  <option  value="SIEM" <?php if($is_concern[0]['institute']=='SIEM'){echo "selected";} ?>>SIEM</option>
                                 
                                </select>
                          
                          
                          
                          
                            </tr>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                <tr >
                                  <td colspan="3"><label >Are your relatives studying in Sandip University: </label>
                                    <select name="relativesandip">
                                      <?php
    											$val = $val1 = "";
    											if ($is_uni_student[0]['is_uni_student'] == 'Y') {
    												$val = "selected";
    											} else {
    												$val1 = "selected";
    											}
    											?>
                                     <option value="">Select</option>
                                      <option <?php echo $val;?> value="Y">Yes</option>
                                      <option <?php echo $val1;?> value="N">No</option>
                                    </select></td>
                                </tr>
                                <tr>
                                  <td><label>Name:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="relativename" value="<?= isset($is_uni_student[0]['person_name']) ? $is_uni_student[0]['person_name'] : '' ?>"/></td>
                                  <td><label>CourseName:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="relativecoursenm" value="<?= isset($is_uni_student[0]['course_name']) ? $is_uni_student[0]['course_name'] : '' ?>"/></td>
                                  <td><label>Relation:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" name="relativerelation" value="<?= isset($is_uni_student[0]['relation']) ? $is_uni_student[0]['relation'] : '' ?>"/></td>
                                </tr>
                              </table>
                            </div>
                          </div>
                          <div class="panel">
                            <div class="panel-heading">How Did You Come To Know About Sandip University</div>
                            <div class="panel-body">
                              <div class="form-group">
                                <label class="col-sm-3">Select The Publicity Media:</label>
                                <div class="col-sm-8">
                                    
                                     <?php
                                      $arr = explode(',', $emp_list[0]['about_uni_know']);
foreach ($pmedia as $course) {
    ?>
   <input type="checkbox" value="<?=$course['pm_id']?>" name="publicitysandip[]" <?php if(in_array($course['pm_id'],$arr)){echo "checked";}  ?>>  <?=$course['pm_name']?>
  
  <?php
}
?>
                                    
                                    
                                 <!-- <select name="publicitysandip[]" multiple="multiple" >
                                    <option value=""><strong>Select</strong></option>
                                    <?php
    $val = $val1 = $val2 = $val3 = $val4 = $val5 = $val6 = $val7 = $val8 = $val9 = "";
    $arr = explode(',', $emp_list[0]['about_uni_know']);
    // print_r($references[0]['publicity_media']);
    foreach ($arr as $key => $val) {
        if ($arr[$key] == 'newspaper-advt') {
            $val = "selected";
        } elseif ($arr[$key] == 'newspaper-insert') {
            $val1 = "selected";
        } elseif ($arr[$key] == 'tv') {
            $val2 = "selected";
        } elseif ($arr[$key] == 'radio') {
            $val3 = "selected";
        } elseif ($arr[$key] == 'hording') {
            $val4 = "selected";
        } elseif ($arr[$key] == 'cstudent') {
            $val5 = "selected";
        } elseif ($arr[$key] == 'alumini') {
            $val6 = "selected";
        } elseif ($arr[$key] == 'staff') {
            $val7 = "selected";
        } elseif ($arr[$key] == 'website') {
            $val8 = "selected";
        } elseif ($arr[$key] == 'otherweb') {
            $val9 = "selected";
        } else {
            $val = $val1 = $val2 = $val3 = $val4 = $val5 = $val6 = $val7 = $val8 = $val9 = "";
        }
    }
    ?>
                                   <option <?php
    echo $val;
    ?> value="newspaper-advt">Newspaper Advt</option>
                                    <option <?php
    echo $val1;
    ?> value="newspaper-insert">Newspaper Insertions</option>
                                    <option <?php
    echo $val2;
    ?> value="tv">TV Advt.</option>
                                    <option <?php
    echo $val3;
    ?> value="radio">Radio Advt.</option>
                                    <option <?php
    echo $val4;
    ?> value="hording">Hording</option>
                                    <option <?php
    echo $val5;
    ?> value="cstudent">Current Student</option>
                                    <option <?php
    echo $val6;
    ?> value="alumini">University Alumani</option>
                                    <option <?php
    echo $val7;
    ?> value="staff">University Staff</option>
                                    <option <?php
    echo $val8;
    ?> value="website">University Website</option>
                                    <option <?php
    echo $val9;
    ?> value="otherweb">Other Website</option>
                                  </select>-->
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-12">Give the Reference of the candidate who may be interested to pursue academic program in sandip university:</label>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-3">Name of Candidate</label>
                                <div class="col-sm-3">
                                  <input data-bv-field="refcandidatenm" id="refcandidatenm" name="refcandidatenm" class="form-control" value="<?= isset($is_reference[0]['person_name']) ? $is_reference[0]['person_name'] : '' ?>" placeholder="Candidate Name" type="text">
                                </div>
                                <label class="col-sm-3">Contact No.</label>
                                <div class="col-sm-3">
                                  <input data-bv-field="refcandidatecont" id="refcandidatecont" name="refcandidatecont" class="form-control" maxlength="10" value="<?= isset($is_reference[0]['contact_no']) ? $is_reference[0]['contact_no'] : '' ?>" placeholder="Candidate contact" type="text">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-3">Email Id</label>
                                <div class="col-sm-3">
                                  <input data-bv-field="refcandidateemail" id="refcandidateemail" name="refcandidateemail" class="form-control" value="<?= isset($is_reference[0]['email']) ? $is_reference[0]['email'] : '' ?>" placeholder="Candidate Email" type="email">
                                </div>
                                <label class="col-sm-3">Relation with Candidate</label>
                                <div class="col-sm-3">
                                  <input data-bv-field="refcandidaterelt" id="refcandidaterelt" name="refcandidaterelt" class="form-control" value="<?= isset($is_reference[0]['relation']) ? $is_reference[0]['relation'] : '' ?>" placeholder="With Candidate relation" type="text">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-3">Area of Interest</label>
                                <div class="col-sm-3">
                                  <input data-bv-field="refcandidateinterest" id="refcandidateinterest" name="refcandidateinterest" class="form-control" value="<?= isset($is_reference[0]['area_of_interest']) ? $is_reference[0]['area_of_interest'] : '' ?>" placeholder="Candidate Interest Area" type="text">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-4"></div>
                           <div class="col-sm-2">
                             <button class="btn btn-primary nextBtn form-control" type="submit" > Update</button>
                            </div>
    
                         </div>
                        
                      </div>
                        <!--end of references --> 
                        </form>
                     </div>
                  </div>
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


