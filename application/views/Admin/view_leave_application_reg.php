<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
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
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
            fields: 
            {
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
                        message: 'Last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Last name should be 2-50 characters'
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
                        message: 'Middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Middle name should be 2-50 characters.'
                        }
                    }
                },
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
                        message: 'First name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'First name should be 2-50 characters.'
                        }
                    }
                },
				flname:
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
                        message: 'Last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Last name should be 2-50 characters'
                        }
                    }
                },
                fmname:
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
                        message: 'Middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Middle name should be 2-50 characters.'
                        }
                    }
                },
				ffname:
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
                        message: 'First name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'First name should be 2-50 characters.'
                        }
                    }
                },
				mlname:
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
                        message: 'Last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Last name should be 2-50 characters'
                        }
                    }
                },
                mmname:
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
                        message: 'Middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Middle name should be 2-50 characters.'
                        }
                    }
                },
				mfname:
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
                        message: 'First name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'First name should be 2-50 characters.'
                        }
                    }
                },
				dob: {
					validators: {
						date: {
							format: 'YYYY-MM-DD',
							message: 'The value is not a valid birth date'
						}
					}
				}
                /*campus_state:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus state should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Campus state should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Campus state should be 10-50 characters'
                        }
                    }

                },
                campus_city:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus city should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Campus city should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Campus city should be 10-50 characters'
                        }
                    }

                },
                campus_address:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus address should not be empty'
                      },
                      stringLength: 
                        {
                        max: 100,
                        min: 5,
                        message: 'Campus address should be 5-100 characters'
                        }
                    }

                },
                campus_pincode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Campus pincode should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Campus pincode should be numeric characters'
                      },
                      stringLength: 
                        {
                        max: 6,
                        min: 6,
                        message: 'Campus pincode should be 6 digit numeric value.'
                        }
                    }

                },*/
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
        <li class="active"><a href="#">Leave Applications </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Leave Applications </h1>
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
                                <div class="form-group">
                                    <div class="col-sm-2">
						          </div> 
                                </div>
                                
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Leave Application </strong></div>
                                <div class="panel-body">
                                <div class="panel-padding no-padding-vr">
								<form id="form" name="form" action="<?=base_url($currentModule.'/update_leave_application_registrar')?>" method="POST">
								<?php  //print_r($details);?>
								<div class="form-body">
                                <div class="form-group">
								<label class="col-md-3">Applicant Name</label>
								<input type="hidden" name="lid" value="<?php echo isset($details[0]['lid'])?$details[0]['lid']:'';?>">
								<input type="hidden" name="emp_id" value="<?php echo isset($details[0]['emp_id'])?$details[0]['emp_id']:'';?>">
								<div class="col-md-3">
                                       <input class="form-control" readonly name="ename" value="<?php echo isset($details[0]['ename'])?$details[0]['ename']:'';?>" type="text">
                                            </div>
											</div>
											 <div class="form-group">
								<label class="col-md-3">Leave Type</label>
								<div class="col-md-3">
								<input type="hidden" name="leave_type" value="<?php echo $details[0]['leave_type'];?>">
								<input type="hidden" name="no_days" value="<?php echo $details[0]['no_days'];?>">
								<input type="text" class="form-control"  disabled  name="leave_types" value="<?php echo $this->Admin_model->getLeaveTypeById($details[0]['leave_type']);?>">
                                                   <!-- <select class="form-control form-control-inline" name="leave_type"   type="text">
													<option value="" readonly>Select</option>
													
												<?php 
												
												/* foreach($leave as $l){
													if($l['lm_id']==$details[0]['leave_type']){
														$str="selected";
													}else{$str="";}
													echo "<option ".$str." value=".$l['lm_id'].">".$l['ltype']."</option>";
												} */
												?>
													</select>-->
                                            </div>
								
											</div>
											 <div class="form-group">
								<label class="col-md-3">Leave from Date</label>
                                             <div class="col-md-3" >
											 <input type="text" class="form-control" readonly name="applied_from_date" value="<?php echo isset($details[0]['applied_from_date'])?$details[0]['applied_from_date']:'';?>" >
                                  <!--<input id="dob-datepicker" class="form-control date-picker" name="applied_for_date" value="<?=isset($details[0]['applied_for_date'])?$details[0]['applied_for_date']:'';?>"  readonly placeholder="Enter Date" type="text">-->

                                             </div>
                                  </div>
								  <div class="form-group">
								<label class="col-md-3">Leave To Date</label>
                                             <div class="col-md-3" >
											 <input type="text" class="form-control" readonly name="applied_to_date" value="<?php echo isset($details[0]['applied_to_date'])?$details[0]['applied_to_date']:'';?>" >
                                  <!--<input id="dob-datepicker" class="form-control date-picker" name="applied_for_date" value="<?=isset($details[0]['applied_for_date'])?$details[0]['applied_for_date']:'';?>"  readonly placeholder="Enter Date" type="text">-->

                                             </div>
                                  </div>
								   <div class="form-group">
								<label class="col-md-3">Reason</label>
                                             <div class="col-md-3" >
                                  <textarea name="reason" readonly class="form-control"><?=isset($details[0]['reason'])?$details[0]['reason']:'';?></textarea>

                                             </div>
                                  </div>
				              <div class="form-group">
							 <label class="col-md-3">Applied On</label>
                                            <div class="col-md-3">
							<input type="text" class="form-control" readonly name="applied_on_date" value="<?php echo isset($details[0]['applied_on_date'])?$details[0]['applied_on_date']:'';?>" >				
                                             <!-- <input id="datepicker2" class="form-control date-picker" name="applied_on_date" readonly  value="<?=isset($details[0]['applied_on_date'])?$details[0]['applied_on_date']:'';?>" placeholder="Enter Date" type="text">-->
                                            </div>
                                  </div>
                                  <div class="form-group">
								<label class="col-md-3">Status Of Application</label>
								<div class="col-md-3">
                                                    <select class="form-control form-control-inline" name="reg_approval_status"  type="text">
													<option value="">Select</option>
													<?php 
													$val=$val1=$val2="";
													if($details[0]['status']=='Pending'){
													$val="selected";	
													}elseif($details[0]['status']=='Rejected'){
													$val1="selected";	
													}elseif($details[0]['status']=='Approved'){
														$val2="selected";
													}else{
													$val=$val1=$val2="";	
													}
														
													?>
													<option <?=$val?> value="Pending">Pending</option>
													<option <?=$val1?> value="Rejected">Rejected</option>
													<option <?=$val2?> value="Approved">Approved</option>
												</select>
                                            </div>
											</div>                                      
                                     <div class="form-group">
							 <label class="col-md-3">Comment</label>
                                            <div class="col-md-3">
							<input type="text" class="form-control"  name="reg_comment" required value="<?php echo isset($details[0]['reg_comment'])?$details[0]['reg_comment']:'';?>" >				
                                           
                                            </div>
                                  </div>
                                   <div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>
                                       
                                    </div>
                            </div>
                                    </form>
                                  
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
	$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#datepicker2').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
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
});
</script>