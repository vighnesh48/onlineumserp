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
   <li class="active"><a href="#">Admission Form</a></li>
</ul>
<div class="page-header">
   <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Admission Form</h1>
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
                     <?php include 'stepbar.php';?>
                     <div class="tab-content">
                        <form method="post" action="<?=base_url()?>Ums_admission/update_bankDetails/" enctype="multipart/form-data">
                        <!--start  of photos -->
                          <div id="payment-photo" class="setup-content widget-threads panel-body tab-pane">
                           <input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
                              <input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
                              <input type="hidden" name="step2statusval" value="<?= $this->session->userdata('stepsecond_status') ?>">
                              <input type="hidden" name="step3statusval" value="<?= $this->session->userdata('stepthird_status') ?>">
                              <input type="hidden" name="step4statusval" value="<?= $this->session->userdata('stepfourth_status') ?>">
                              <div class="panel">
                                <div class="panel-heading">Payment Details
                                  <?= $astrik ?>
                               </div>
                                <div class="panel-body">
                                  <table class="table table-bordered" style="display:none">
                                    <tr>
                                      <th>particulars</th>
                                            <th>Academic Fee</th>
							  <th>Exepmted Fee</th>
                                      <th>Applicable Fee</th>
                                      <th>Amount Paid</th>
                                      <th>Balance(if any)</th>
                                      
                                    </tr>
                                    <!-- <tr>
                                      <td>Admission Form/prospectus Fee(Not to pay if already paid)</td>
                                      <td><input type="text" id="txt1" name="formfeeappli" onkeyup="sub();" value="<?= isset($fee[0]['formfeeappli']) ? $fee[0]['formfeeappli'] : '' ?>"></td>
                                      <td><input type="text" id="txt2" name="formfeepaid" onkeyup="sub();" value="<?= isset($fee[0]['formfeepaid']) ? $fee[0]['formfeepaid'] : '' ?>"></td>
                                      <td><input type="text" id="txt3" name="formfeebal" onkeyup="sub();" value="<?= isset($fee[0]['formfeebal']) ? $fee[0]['formfeebal'] : '' ?>"></td>
                                      
                                    </tr>
                                   <tr>
                                      <td>Tution Fee</td>
                                      <td><input type="text" id="txt11" name="tutionfeeappli" value="<?= isset($fee[0]['tutionfeeappli']) ? $fee[0]['tutionfeeappli'] : '' ?>" onkeyup="sub1();" ></td>
                                      <td><input type="text" id="txt12" name="tutionfeepaid" value="<?= isset($fee[0]['tutionfeepaid']) ? $fee[0]['tutionfeepaid'] : '' ?>" onkeyup="sub1();"></td>
                                      <td><input id="txt13" type="text" name="tutionfeebal" value="<?= isset($fee[0]['tutionfeebal']) ? $fee[0]['tutionfeebal'] : '' ?>" onkeyup="sub1();"></td>
                                    </tr>
                                    <tr>
                                      <td>Other</td>
                                      <td><input type="text" id="txt21" name="otherfeeappli" value="<?= isset($fee[0]['otherfeeappli']) ? $fee[0]['otherfeeappli'] : '' ?>" onkeyup="sub2();"></td>
                                      <td><input id="txt22" type="text" name="otherfeepaid" value="<?= isset($fee[0]['otherfeepaid']) ? $fee[0]['otherfeepaid'] : '' ?>"  onkeyup="sub2();"></td>
                                      <td><input type="text" id="txt23" name="otherfeebal" value="<?= isset($fee[0]['otherfeebal']) ? $fee[0]['otherfeebal'] : '' ?>" onkeyup="sub2();"></td>
                                    </tr>-->
                                    <tr>
                                      <td>Total fee</td>
                                        <td><input type="text" id="txt_acd" name="acd_totalfee" value="<?= isset($admission_details[0]['actual_fee']) ? $admission_details[0]['actual_fee'] : '' ?>" onkeyup="sub3();" style="width:100px" readonly></td>
							  <td>
							      <?php
							      $exm = (int)$admission_details[0]['actual_fee'] - (int)$admission_details[0]['applicable_fee'];
							      $bal = (int)$admission_details[0]['applicable_fee'] - (int)$get_feedetails[0]['amount']
							      
							      ?>
							      
							      
							      <input type="text" id="txt_exempt" name="exepmted_fee" value="<?=  $exm; ?>" onkeyup="sub3();" style="width:100px" readonly></td>
                             
                                      <td><input type="text" id="txt31" name="totalfeeappli" value="<?= isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '' ?>" onkeyup="sub3();" readonly></td>
                                      <td><input type="text" id="txt32" name="totalfeepaid" value="<?= isset($get_feedetails[0]['amount']) ? $get_feedetails[0]['amount'] : '' ?>" onkeyup="" ></td>
                                      <td><input type="text" id="txt33" name="totalfeebal" value="<?=  $bal ?>" onkeyup="sub3();" readonly></td>
                                    </tr>
                                  </table>
                                  <div class="panel" style="display:none;">
                                    <div class="panel-heading">Account Details
                                        <div class="panel-body">
                                          <div class="form-group">
                                            <label class="col-sm-3">Payment of Rs</label>
                                            <div class="col-sm-3">
                                              <input data-bv-field="paidfee" id="paidfee" name="paidfee" class="form-control" value="<?= isset($get_feedetails[0]['amount']) ? $get_feedetails[0]['amount'] : '' ?>" placeholder="Paid Fee" type="text" required readonly>
                                            </div>
                                            
                                                      <label class="col-sm-3">Payment Type</label>
                                    <div class="col-sm-3">
                                    <select name="payment_type" id="payment_type" class="form-control" >
                                        <option value="">Select Payment Type</option>
									<option value="CHQ" <?php if($get_feedetails[0]['fees_paid_type']=="CHQ"){echo "selected";} ?>>Cheque</option>
									<option value="DD" <?php if($get_feedetails[0]['fees_paid_type']=="DD"){echo "selected";} ?>>DD</option>
									<option value="CHLN" <?php if($get_feedetails[0]['fees_paid_type']=="CHLN"){echo "selected";} ?>>Chalan</option>
									
									</select>
									
									
                                    </div>
                                            
                                            
                                            
                                         
                                          </div>
                                          <div class="form-group">
                                              
                                                 
                                            <label class="col-sm-3"> Cheque/DD No.</label>
                                            <div class="col-sm-3">
                                              <input type="text" name="dd_no" class="form-control"  value="<?= isset($get_feedetails[0]['receipt_no']) ? $get_feedetails[0]['receipt_no'] : '' ?>" placeholder="DD No.">
                                            </div>
                                            <label class="col-sm-3">Dated</label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="doc-sub-datepicker20" name="dd_date"  value="<?= isset($get_feedetails[0]['fees_date']) ? $get_feedetails[0]['fees_date'] : '' ?>" placeholder="DD Date" />
                                            </div>
                                            
                                            <div class="col-sm-6">
                                              
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-sm-3">Bank name</label>
                                            <div class="col-sm-3">
                                              <select name="dd_bank" id="dd_bank" class="form-control" >
                                 
                                  <?php
foreach ($bank_details as $branch) {
?>

  <option value="<?php echo $branch['bank_id']; ?>" <?php if($get_feedetails[0]['bank_id']==$branch['bank_id']){echo "selected";} ?> ><?php echo $branch['bank_name']; ?></option>;
   <?php
}
?>
                               </select>
                                             
                                             
                                             <!-- <input type="text" id="dd_bank" name="dd_bank" class="form-control" value="<?= isset($get_feedetails[0]['bank_id']) ? $get_feedetails[0]['bank_id'] : '' ?>" placeholder="Bank & Branch">
                                            -->
                                            
                                            </div>
                                            <label class="col-sm-3"> Branch Name.</label>
                                            <div class="col-sm-3">
                                              <input type="text" id="dd_bank_branch" name="dd_bank_branch" class="form-control" value="<?= isset($get_feedetails[0]['bank_city']) ? $get_feedetails[0]['bank_city'] : '' ?>" placeholder="Branch Name">
                                            </div>
                                          </div>
                                          
                                           
                                  <div class="form-group">
								  
								   <label class="col-sm-3">Upload document</label>
                                    <div class="col-sm-3"><input type="file" name="payfile"><?php echo $get_feedetails[0]['receipt_file']; ?>
                                    
                                        </div>
                                  </div>
                                        </div>
                                    </div>
                                 </div>
                               
                               <div class="panel">
                                    <div class="panel-heading">Student Personal Account Details
                                        <div class="panel-body">   
                                          <div class="form-group">
                                            <label class="col-sm-3">Bank Name</label>
                                            <div class="col-sm-3">
                                                  <select name="bank_name" id="bank_name" class="form-control" >
                                              
                                  <?php
foreach ($bank_details as $branch) {
?>

  <option value="<?php echo $branch['bank_id']; ?>" <?php if($get_bankdetails[0]['bank_name']==$branch['bank_id']){echo "selected";} ?> ><?php echo $branch['bank_name']; ?></option>;
   <?php
}
?>
</select>
                                                
                                          <!--    <input type="text" id="bank_name" name="bank_name" class="form-control" value="<?= isset($get_bankdetails[0]['bank_name']) ? $get_bankdetails[0]['bank_name'] : '' ?>" placeholder="BOI Account No." />
                                            -->
                                            </div>
                                            <label class="col-sm-3"> Bank Account No.</label>
                                            <div class="col-sm-3">
                                              <input type="text" id="account_no" name="account_no" class="form-control" value="<?= isset($get_bankdetails[0]['account_no']) ? $get_bankdetails[0]['account_no'] : '' ?>" placeholder="Other Bank Account No." />
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="col-sm-3">IFSC code</label>
                                            <div class="col-sm-3">
                                              <input type="text" id="ifsc" name="ifsc" class="form-control" value="<?= isset($get_bankdetails[0]['ifsc_code']) ? $get_bankdetails[0]['ifsc_code'] : '' ?>" placeholder="IFSC code" />
                                            </div>
                                            
                                             <label class="col-sm-3">Bank Branch</label>
                                    <div class="col-sm-3">
                                      <input type="text" id="bank_branch" name="bank_branch" class="form-control" value="<?= isset($get_bankdetails[0]['bank_city']) ? $get_bankdetails[0]['bank_city'] : '' ?>" placeholder="Bank Branch">
                                    </div>
                                  </div>
                                          </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div class="panel">
                                <div class="panel-heading">Photo Uplod
                                  <?= $astrik ?>
                               </div>
                                <div class="panel-body">
                                  <div class="form-group">
                                    <label class="col-sm-3">Upload Photo:</label>
                                    <?php
       /* if (!empty($emp_list[0]['student_photo_path'])) {
            $profile = base_url() . "uploads/student_profilephotos/" . $emp_list[0]['student_photo_path'];
        } else {
            $profile = "";
        }*/
        $profile = base_url() . "uploads/student_photo/".$emp_list[0]['enrollment_no'].".jpg";
        
        ?>
                                  <!-- <input type="hidden" name="profile_img" value="<?= isset($fee[0]['profile_img']) ? $fee[0]['profile_img'] : '' ?>">-->
                                    <img id="blah" alt="Student Profile image" src="<?php
        echo $profile;
        ?>"width="100" height="100" border="1px solid black" />
                                    <input type="file" name="profile_img" value=""><span style="color:red">*Only jpg format</span>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="col-sm-4"></div>
                              <div class="col-sm-2">
                                 <button class="btn btn-success btn-lg pull-right" type="submit">Submit</button>
                                </div>
                                
                             </div>
                           
                          </div>
                        <!--end of photos --> 
                        </form>
                     </div>
                  </div>
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</div>