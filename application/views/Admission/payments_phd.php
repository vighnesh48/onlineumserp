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
                        <form method="post" action="<?=base_url()?>phd_admission/update_bankDetails/" enctype="multipart/form-data">
                        <!--start  of photos -->
                          <div id="payment-photo" class="setup-content widget-threads panel-body tab-pane">
                           <input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
                              <input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
                              <input type="hidden" name="step2statusval" value="<?= $this->session->userdata('stepsecond_status') ?>">
                              <input type="hidden" name="step3statusval" value="<?= $this->session->userdata('stepthird_status') ?>">
                              <input type="hidden" name="step4statusval" value="<?= $this->session->userdata('stepfourth_status') ?>">
                           <div class="panel-body">
                       <div class="panel">
                            <div class="panel-heading">Student Personal Details</div>
                                <div class="panel-body">   
                                  <div class="form-group">
                                    <label class="col-sm-3">Student Photo (only .jpg allowed)</label>
                                    <div class="col-sm-3">
									<input type="file" id="profile_img" name="profile_img" class="form-control" value="" >
                                    </div>
									<?php
								    $file_name = $emp_list[0]['enrollment_no'];
									$photo = $file_name.'.jpg';
									$bucket_key = 'uploads/student_photo/' .$photo;
									$bucket_name = 'erp-asset';
									$this->load->library('awssdk');
									$profile = $this->awssdk->getImageData($bucket_key);
									?>
									 <img id="blah" alt="Student Profile image" src="<?php echo $profile; ?>"width="100" height="100" border="1px solid black" />
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">Current Employment</label>
                                    <div class="col-sm-3">
                                   <input type="radio" id="government" name="employment" value="government"<?php if($emp_list[0]['employment']=='government')echo "checked"; ?> >
									 <label for="govt">Government Service</label><br>
									  <input type="radio" id="private" name="employment" value="private"<?php if($emp_list[0]['employment']=='private')echo "checked"; ?>>
									 <label for="private">Private Service</label><br>
                                    </div>
									 <input type="radio" id="self" name="employment" value="self"<?php if($emp_list[0]['employment']=='self')echo "checked"; ?>>
									 <label for="self">Self Employed</label><br>
									  <input type="radio" id="business" name="employment" value="business"<?php if($emp_list[0]['employment']=='business')echo "checked"; ?>>
									 <label for="business">Business </label>
                                  </div>
								      <div class="form-group">
                                    <label class="col-sm-3">Remark</label>
                                    <div class="col-sm-3">
									<textarea id="remark" name="remark"><?= isset($emp_list[0]['remark']) ? $emp_list[0]['remark'] : '' ?></textarea>
                                    </div>
                                  </div>
								   <div class="form-group">
                                    <label class="col-sm-3">Employer NOC (only .pdf allowed)</label>
                                    <div class="col-sm-3">
									<input type="file" id="emp_noc" name="emp_noc" class="form-control" value="" >
								   <?php	
									$file_name = $emp_list[0]['enrollment_no'];
									$noc_file = $file_name.'-EMP-NOC.pdf'; 
									//$year = getStudentYear($student_id);
                                                $student_id = $this->session->userdata('studId');
                                                $bucketname = 'uploads/student_document/';
                                                $s3_path = 'uploads/student_document/'.$noc_file;
												$s3_file =   $this->awssdk->isFileExist('erp-asset',$s3_path);
												
                                        if(!empty($s3_file)){  ?>
                                   <a href="<?= site_url() ?>Upload/get_document/<?php echo $noc_file .'?b_name='.$bucketname;  ?>" target="_blank">View</a>
										<?php } ?>
                                       </div>
                                     </div>
                                   </div>
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
<script>
$(document).ready(function(){
    $('#emp_noc').on('change', function(){
        var fileName = $(this).val();
        var ext = fileName.split('.').pop().toLowerCase();
        if($.inArray(ext, ['pdf']) == -1) {
            alert('Please select a PDF file.');
            $(this).val('');
        }
    });
	
	   $('#profile_img').on('change', function(){
        var fileName = $(this).val();
        var ext = fileName.split('.').pop().toLowerCase();
        if($.inArray(ext, ['jpg']) == -1) {
            alert('Please select a jpg file.');
            $(this).val('');
        }
    });
    });
	
	</script>