<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
.help-block {
    display: block;
    margin-top: 5px;
    margin-bottom: 10px;
    color: #e92323;
}
</style>
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
            fields: 
            {
                college_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'College Name should not be empty'
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
                branch_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select branch name.'
                      }
                    }

                },
                course_year:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select course year.'
                      }
                    }

                },
				name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Name should not be empty.'
                      }
                    }

                },
				fees_paid:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select Fees Paid By.'
                      }
                    }

                },
				rec_no:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Receipt No. should not be empty.'
                      }
                    }

                },
				fees_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Please select Fees Date.'
                      }
                    }

                },
				fees_amt:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Fees Amount should not be empty.'
                      },
						regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Fees Amount should be numeric'
                      }
                    }

                },
				bank_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Bank Name should not be empty.'
                      }
                    }

                },
				bank_city:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Bank City should not be empty.'
                      }
                    }

                }
            }       
        })
    });
	$(document).ready(function(){
	$("#fees_date").datepicker({       
        autoclose: true,
		format: 'dd-mm-yyyy'		
    }).on('changeDate', function (selected) {
        $('#form').bootstrapValidator('revalidateField', 'fees_date');

    });
	$("#entry_date").datepicker({       
        autoclose: true,
		format: 'dd-mm-yyyy',
		todayHighlight: true		
    }).on('changeDate', function (selected) {
        $('#form').bootstrapValidator('revalidateField', 'entry_date');

    });
	$("#college_name").change(function(){
		var post_data = $(this).val();
	
	
	$.ajax({
				type: "POST",
				url: "get_course_name/"+post_data,
				
				success: function(data){
					//alert(data);          
            $('#course_name').html(data);
         
				}	
			});
		
	});
	$("#course_name").change(function(){
		var post_data = $('#college_name').val()+'/'+$(this).val();		
	$.ajax({
				type: "POST",
				url: "get_branch_name/"+post_data,
				
				success: function(data){
					//alert(data);          
            $('#branch_name').html(data);
         
				}	
			});
	});
});

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add </h1>
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
			 <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">  
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">
                           
							<div class="row">
								<div class="col-sm-6"># Fees Details&nbsp;&nbsp;&nbsp;&nbsp;<font color="red"><i>(Note:* This fields are compulsary)</i></font></span>
								<span class="pull-right"> Entry Date : </span>
								</div>                                    
                                    <div class="col-sm-3">
                                       <input type="text" id="entry_date" name="entry_date" class="form-control" value="<?=date('d-m-Y');?>" style="width:150px" />
                                    </div> 
									<div class="col-sm-3">
										<span class="pull-right">Academic Year:<?php echo date('Y')."-".date('y',strtotime('+1 year')); ?></b></span>
									</div>
								</div>
                            
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php //if(in_array("Add", $my_privileges)) { ?>
                                                                                        
                               
                                <div class="col-md-6">								                               
                                                               
                                <div class="form-group">
                                    <label class="col-sm-3">College Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6"> <select id="college_name" name="college_name" class="form-control">
                                           <option value="">Select College Name</option>
										   <?php foreach($college_details as $val){
											    echo '<option value="'.$val['college_name'].'">'.$val['college_name'].'</option>';
										   }
										   ?>
                                        </select></div>                                    
                                    <div class="col-sm-3"><span style="color:red;!important"><?php echo form_error('course_name');?></span></div>
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-3">Course Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="course_name" name="course_name" class="form-control">
                                            <option value="">Select Course Name</option>
                                           
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;!important"><?php echo form_error('course_type');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Branch Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="branch_name" name="branch_name" class="form-control">
                                            <option value="">Select Branch Name</option>
                                            
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;!important"><?php echo form_error('course_type');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Course Year <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="course_year" name="course_year" class="form-control">
                                            <option value=""> Select Year </option>
                                            <option value="1"> First Year </option>
                                            <option value="2"> Second Year </option>
                                            <option value="3"> Third Year </option>
                                            <option value="4"> Final Year </option>
                                        </select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <input type="text" id="name" name="name" class="form-control" value="" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Enrollment No </label>                                    
                                    <div class="col-sm-6">
                                        <input type="text" id="reg_no" maxlength="20" name="reg_no" class="form-control" value="<?=isset($_REQUEST['course_name'])?$_REQUEST['course_name']:''?>" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Fees Type <?=$astrik?></label>                                    
                                    <div class="col-sm-6"><select id="fees_type" name="fees_type" class="form-control">
                                           
                                            <!--option value="1"> Admission </option>
                                            <option value="2"> Hostel </option>
                                            <option value="3"> Transport </option-->
                                            <option selected value="4"> Uniform </option>
                                        </select></div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_code');?></span></div>
                                </div>  
											
								
								
								</div>
								 <div class="col-md-6">
								                               
								<div class="form-group">
                                    <label class="col-sm-3">Fees Paid By <?=$astrik?></label>                                    
                                    <div class="col-sm-8">
                                        <input type="radio" id="fees_paid" name="fees_paid" class="" value="DD" /> DD
										<input type="radio" id="fees_paid" name="fees_paid" class="" value="CHQ" /> Cheque
										<input type="radio" id="fees_paid" name="fees_paid" class="" value="RECPT" /> Receipt
										<input type="radio" id="fees_paid" name="fees_paid" class="" value="PG" /> Online Payment
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Receipt No <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <input type="text" id="rec_no" maxlength="20" name="rec_no" class="form-control" value="" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Fees Amount <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <input type="text" id="fees_amt" maxlength="6" name="fees_amt" class="form-control" value="" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Chq/DD- Date <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <input type="text" id="fees_date" name="fees_date" class="form-control"  />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Bank Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <input type="text" id="bank_name" name="bank_name" class="form-control" value="" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div>
										
								<div class="form-group">
                                    <label class="col-sm-3">Bank City <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <input type="text" id="bank_city" name="bank_city" class="form-control" value="" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Remark </label>                                    
                                    <div class="col-sm-6">
                                        <input type="text" id="remark" name="remark" class="form-control" value="" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('course_type');?></span></div>
                                </div>
								</div>
								
								
								
								
                               <div class="col-lg-12 text-center">
                                <div class="form-group text-center">  
 <div class="col-sm-4"></div>								
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                                                    </div>
                            
                            <?php //} ?>
                        </div>
						</div>
                    </div>
                </div>
				</form>
            </div>    
        </div>
    </div>
</div>