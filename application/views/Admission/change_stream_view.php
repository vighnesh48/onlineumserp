<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

<style>
.panel-body {
    background: #fff;
    margin: 0;
    padding: 20px;
    height: 700px;
}
.multiselect-container {
    max-height: 500px; /* Adjust the height as needed */
    overflow-y: auto;
}
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Students</a></li>
        <li class="active"><a href="#"><?=$ed?> Change Stream</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-book page-header-icon"></i>&nbsp;&nbsp;Change Stream</h1>
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
                    <div class="panel-heading">
                            <span class="panel-title">Change Stream</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <?php 
                            $message1 = $this->session->flashdata('message1');
                            if(!empty($message1)){
                                ?>
                            <div class="form-group">
                              <label class="col-sm-12" style="color:green"> <?=$message1 ?></label>     
                            </div>
                            <?php
                            }
                            ?>
							
                            <form id="form" name="form" method="POST" action="<?=base_url($currentModule.'/insert_to_changeStream')?>" enctype="multipart/form-data">                                                               
                            <input type="hidden" value="<?=$stud_details[0]['admission_stream']?>" name="previous_stream" />
							<input type="hidden" value="<?=$stud_details[0]['academic_year']?>" name="academic_year"/>
							<input type="hidden" value="<?=$stud_details[0]['current_year']?>" name="current_year"/>
							<input type="hidden" value="<?=$stud_details[0]['current_semester']?>" name="current_semester"/>
							<input type="hidden" value="<?=$stud_details[0]['admission_session']?>" name="admission_session" />
							<input type="hidden" value="<?=$stud_details[0]['stud_id']?>" name="stud_id" />
							<div class="form-group">
                              <label class="col-sm-2">PRN </label>
                              <div class="col-sm-10" ><?=$stud_details[0]['enrollment_no']?></div>
							  </div>
							  <div class="form-group">
                              <label class="col-sm-2">Student Name </label>
                              <div class="col-sm-10" ><?=$stud_details[0]['first_name'].' '.$stud_details[0]['last_name']?></div>
							  </div>
                            <div class="form-group">
                              <label class="col-sm-2">Current Stream </label>
                              <div class="col-sm-10" ><?=$stud_details[0]['stream_name']?></div>
							  </div>
							  <div class="form-group">
								  <label for="admission_stream" class="col-sm-2">Change to Stream *</label>
								  <select name="admission_stream" id="admission_stream" class="col-sm-3">
									<option value="">Select</option>
									<?php
									  foreach ($streams as $st) {
										if($stud_details[0]['admission_stream']==$st['stream_id']){
										  unset($st['stream_id']); unset($st['stream_name']);
										}
										if ($st['stream_id'] == $_REQUEST['stream_name']) {
										  $sel = "selected";
										} else {
										  $sel = '';
										}
										if($st['stream_id'] !=''){
										  echo '<option value="' . $st['stream_id'] . '"' . $sel . '>' . $st['stream_name'] . '</option>';
										}
									  }
									?>
								  </select>
								  <div id="admission_stream_error" class="text-danger" style="display:none;">This field is required.</div>
								</div>
							
                                <!--- practical end-->
								<?php 
								$curr_year = date('Y');
								$stud_acd_yr = $stud_details[0]['academic_year'];
								?>
                                <div class="form-group">   
								<?php if($stud_acd_yr >=$curr_year || $curr_year = $stud_acd_yr+1){?>
                                   <div class="col-sm-2">
									<button class="btn btn-primary form-control" id="submitfrm" name="submit" type="submit" >Update</button>										                                      
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url()?>Ums_admission/stud_list'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
								<?php }else{ echo "<div class='col-sm-4'><span style='color:red'>You can only change the stream of current Academic year students.</span></div>";?>
								 <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url()?>Ums_admission/stud_list'">Cancel</button></div>
								<?php }?>
                                </div>
                            </form>
                            <?php //} ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#admission_stream').select2({
        placeholder: 'Select Stream',
        allowClear: true,
        width: 'resolve'
      });

      $('#form').on('submit', function(event) {
        let selectedOptions = $('#admission_stream').val();
        if (selectedOptions === null || selectedOptions === "") {
          event.preventDefault();
          $('#admission_stream_error').show();
        } else {
          $('#admission_stream_error').hide();
        }
      });

      $('#admission_stream').change(function() {
        let selectedOptions = $(this).val();
        if (selectedOptions !== null && selectedOptions !== "") {
          $('#admission_stream_error').hide();
        }
      });
    });
  </script>