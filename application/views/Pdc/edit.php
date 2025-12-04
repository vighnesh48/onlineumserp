<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
        $('#form11').bootstrapValidator
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
                course_code:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Course code should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Course Code should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Course code should be 10-20 characters'
                        }
                    }

                },
                course_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Course name should not be empty'
                      }
                    }

                },
                course_type:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select course type.'
                      }
                    }

                },
                duration:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select course type.'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Please select valid option for course duration'
                      },
                    }

                }
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
    //echo "<pre>";    print_r($course_details);    die;
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Edit Pdc</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Pdc</h1>
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
                  <!--  <div class="panel-heading">
                            <span class="panel-title">New Registration</span>
                    </div>-->
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <div>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/edit_submit_pdc')?>" method="POST" enctype="multipart/form-data">                                                               
                                <input type="hidden"  id="student_id" name="student_id" value="<?= isset($pdc_details[0]['student_id']) ? $pdc_details[0]['student_id'] : ''; ?>" />
                                <input type="hidden" id="pdc_idd" name="pdc_idd" value="<?= isset($pdc_details[0]['pdc_id']) ? $pdc_details[0]['pdc_id'] : ''; ?>" />
                                                             
                                  <div class="form-group">
                              <label class="col-sm-3">Student Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                  <input data-bv-field="sfname" id="sfname" name="sfname" class="form-control" value="<?= isset($pdc_details[0]['first_name']) ? $pdc_details[0]['first_name'] : ''; ?>" placeholder="Student Name" type="text" required="required">
                               
                               
                                </div>  
                                
                            <label class="col-sm-3">PRN Number </label>
                              <div class="col-sm-3">
                               
                               <input type="text" id="prn" name="prn" class="form-control" readonly="readonly" placeholder="Student prn Number" value="<?= isset($pdc_details[0]['enrollment_no']) ? $pdc_details[0]['enrollment_no'] : ''; ?>" required="required" />
                    
                                </div>   
                                
                              </div>

                                  <div class="form-group">
                              <label class="col-sm-3">Cheque No <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                  <input data-bv-field="chk_no" id="chk_no" name="chk_no" class="form-control"  placeholder="Cheque No" type="text" value="<?= isset($pdc_details[0]['chq_dd_no']) ? $pdc_details[0]['chq_dd_no'] : ''; ?>" required="required">
                               
                               
                                </div>   
                                
                            <label class="col-sm-3">Upload Cheque Receipt </label>
                              <div class="col-sm-3">
                               
                               <input type="file" name="upload"  />
                               <img src="<?php echo base_url();?>uploads/student_document/<?= isset($pdc_details[0]['chq_dd_file']) ? $pdc_details[0]['chq_dd_file'] : ''; ?>" width="100" height="100"/>
                                <input type="hidden" name="upload1" value="<?= isset($pdc_details[0]['chq_dd_file']) ? $pdc_details[0]['chq_dd_file'] : ''; ?>" />
                    
                                </div>   
                                
                              </div>
                                  <div class="form-group">
                              <label class="col-sm-3">Amount <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                  <input data-bv-field="amount" id="amount" name="amount" class="form-control" placeholder="Enter Amount" type="text" value="<?= isset($pdc_details[0]['amount']) ? $pdc_details[0]['amount'] : ''; ?>" required="required">
                               
                               
                                </div>  
                                
                            <label class="col-sm-3">Cheque Date <?= $astrik ?> </label>
                              <div class="col-sm-3">
                               
                              <input type="text" required="required" class="form-control" id="idate" name="idate" placeholder="Select date" value="<?= isset($pdc_details[0]['chq_dd_date']) ? $pdc_details[0]['chq_dd_date'] : ''; ?>">
                    
                                </div>   
                                
                              </div>
                                  <div class="form-group">
                              <label class="col-sm-3">Bank Name <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                  <select id="bank_name" name="bank_name" class="form-control" required="required">
                                            <option value="">Select Bank</option>
                                            <?php  if(isset($bank_details))
                                            {
                                                foreach($bank_details as $bankd)
                                                {
                                                    if($bankd['bank_id']==$pdc_details[0]['chq_bank_id'])
                                          $sel ="selected";
                                          else
                                          $sel='';
                                                    ?>
                                                    <option value="<?php echo $bankd['bank_id']; ?>" <?php echo $sel; ?> ><?php echo $bankd['bank_name'];?></option>
                                                    <?php 
                                                }
                                            }
                                                ?>

                                            
                                           
                                        </select>
                               
                               
                                </div>  
                                
                            <label class="col-sm-3">City Name </label>
                              <div class="col-sm-3">
                               
                               <input type="text" id="city_name" name="city_name" value="<?= isset($pdc_details[0]['chq_bank_city']) ? $pdc_details[0]['chq_bank_city'] : ''; ?>" class="form-control"  placeholder="Enter city name" />
                    
                                </div>   
                                
                              </div>
                                  <div class="form-group">
                              <label class="col-sm-3">Academic Year <?= $astrik ?></label>
                              <div class="col-sm-3">
                               
                                  <input data-bv-field="academic_year" id="academic_year" name="academic_year" class="form-control" value="<?= isset($pdc_details[0]['academic_year']) ? $pdc_details[0]['academic_year'] : ''; ?>" placeholder="" type="text" required="required">
                               
                               
                                </div>  
                                
                            <label class="col-sm-3">Remark</label>
                              <div class="col-sm-3">
                               
                            <textarea class="form-control" id="remark" name='remark' rows="3"><?= isset($pdc_details[0]['remark']) ? $pdc_details[0]['remark'] : ''; ?></textarea>
                    
                                </div>   
                                
                              </div>

                             <!--    <div class="form-group">
                                    <label class="col-sm-3">Campus Type <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="course_type" name="course_type" class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="E">Engineering</option>
                                            <option value="M">Management</option>
                                            <option value="P">Polytechnic</option>
                                            <option value="PH">Pharmacy</option>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Campus Duration [in Yrs] <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="duration" name="duration" class="form-control">
                                            <option value="">Select Type</option>
                                            <?php for($i=1;$i<=10;$i++) {?>
                                            <option value="<?=$i?>"><?=$i." Yrs "?></option>
                                            <?php } ?>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div> -->
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Edit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
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
    var date = new Date();
  var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  $('#idate').datepicker( {format: "yyyy-mm-dd",
todayHighlight: true,
startDate: today,

autoclose: true});




</script>