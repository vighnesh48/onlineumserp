<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
       /*  $('#form1').bootstrapValidator
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
				slname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Student Last name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Student Last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Student Last name should be 2-50 characters'
                        }
                    }
                },
                smname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Student Middle name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Student Middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Student Middle name should be 2-50 characters.'
                        }
                    }
                },
				sfname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Student First name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Student First name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Student First name should be 2-50 characters.'
                        }
                    }
                },
				slname1:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Father Last name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Father Last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Father Last name should be 2-50 characters'
                        }
                    }
                },
                smname1:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Father Middle name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Father Middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Father Middle name should be 2-50 characters.'
                        }
                    }
                },
				sfname1:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Father First name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Father First name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Father First name should be 2-50 characters.'
                        }
                    }
                },
				sfname2:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mother name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Mother name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Mother name should be 2-50 characters.'
                        }
                    }
                },
				parent_lname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Guardian last name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Guardian last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Guardian last name should be 2-50 characters.'
                        }
                    }
                },
				parent_fname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Guardian first name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Guardian first name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Guardian first name should be 2-50 characters.'
                        }
                    }
                },
				parent_mname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Guardian middle name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Guardian middle name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Guardian middle name should be 2-50 characters.'
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
				},
				mobile:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mobile number should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Mobile number should be numeric'
                      },
                      stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        }
                    }
                },
				mobile:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Mobile number should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Mobile number should be numeric'
                      },
                      stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
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
                      },
                      regexp: 
                      {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'This is not a valid email'
                      }
                      
                    }
                },
				category:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Category should not be empty'
                      }
                    }
                },
				religion:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'religion should not be empty'
                      }
                    }
                },
				res_state:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'State should not be empty'
                      }
                    }
                },
				hostel:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Hostel Facility should not be empty'
                      }
                    }
                },
				transport:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Transport Facility should not be empty'
                      }
                    }
                },
				relationship:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Guardian Relationship should not be empty'
                      }
                    }
                },
				occupation:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Guardian occupation should not be empty'
                      }
                    }
                },
				bill_A:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Local Address should not be empty'
                      }
                    }
                },
				shipping_A:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Permanent Address should not be empty'
                      }
                    }
                },
               bill_C:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address City should not be empty'
                      }
                    }
                },
				shipping_C:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address City should not be empty'
                      }
                    }
                },
				bill_D:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address State should not be empty'
                      }
                    }
                },
				shipping_D:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address State should not be empty'
                      }
                    }
                },
				bill_country:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address Country should not be empty'
                      }
                    }
                },
				shipping_country:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address Country should not be empty'
                      }
                    }
                },
				bill_pc:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address PostCode should not be empty'
                      }
                    }
                },
				shipping_pc:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Address PostCode should not be empty'
                      }
                    }
                }
            }       
        })
	 */
});
</script>
<script>
 $(document).ready(function()
    {
$('#form2').bootstrapValidator	
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
				qexam:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Entrance qualifying exam should not be empty'
                      }
                      
                    },
					 regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Entrance qualifying exam name should be alphabate characters'
                      }
                },
				pyexam:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Entrance qualifying exam passing year should not be empty'
                      }
                      
                    },
					 regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Entrance qualifying exam name should be Numeric'
                      }
                },
				cexam:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'school/college name should not be empty'
                      }
                      
                    }
                },
				roll_exam:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Exam Roll Number should not be empty'
                      }
                      
                    }				 
			   },
			   exam_rank:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Exam Rank should not be empty'
                      }
                      
                    }				 
			   },
			   tssc_eng:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'SSC English Mark should not be empty'
                      }
                      
                    },
					 regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'SSC English Mark should be Numeric'
                      }
                },
				ossc_eng:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'SSC English Mark should not be empty'
                      }
                      
                    },
					 regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'SSC English Mark should be Numeric'
                      }
                },
				sscpass_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'SSC passing date should not be empty'
                      }
                      
                    }
                },
				college_name:
				{
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Education Details Should be entered'
                      }
                      
                    }
                }
				
				
			}
})	
});	
</script>

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

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Admission Form</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Temporary Admission Form</h1>
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
                           
                              <!--  <div class="form-group">
                                    <label class="col-sm-3">Admission Year To <?=$astrik?></label>
                                    <div class="col-sm-3">
                                    <select name="" class="form-control"><?php
									foreach($course_year as $cy=>$yr){
										echo '<option value="'.$yr.'">'.$yr.'</option>';
									} ?></select></div>
                                    <label class="col-sm-2">Quota <?=$astrik?></label>
                                    <div class="col-sm-3">
                                    <select name="" class="form-control"><?php
									foreach($quota as $qcode){
										echo '<option value="'.$qcode['quota_code'].'">'.$qcode['quota_name'].'</option>';
									} ?></select></div>
                                </div>-->
                                <!--<div class="form-group">
                                    
                                    <label class="col-sm-2">Admission Date <?=$astrik?></label>
                                    <div class="col-sm-4">
                                    <div id="bs-datepicker-component" class="input-group date">
                                        <input type="text" id="po_date" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    </div>
                                </div>-->
                                <!--<div class="form-group">               
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus_state');?></span></div>
                                </div>-->
                                <div class="form-group"><h4>Name of the Applicant as in the Marks Card of Standard 10th exam</h4></div>
                              <!--  <div class="form-group">
                                    <label class="col-sm-3">Name</label>
                                    <div class="col-sm-3"><input type="text" id="lname" name="lname" class="form-control" value="<?=isset($_REQUEST['lname'])?$_REQUEST['lname']:''?>" placeholder="Last Name" /></div>                                    
                                    <div class="col-sm-3"><input type="text" id="fname" name="fname" class="form-control" value="<?=isset($_REQUEST['fname'])?$_REQUEST['fname']:''?>" placeholder="First Name" /></div>
                                    <div class="col-sm-3"><input type="text" id="mname" name="mname" class="form-control" value="<?=isset($_REQUEST['mname'])?$_REQUEST['mname']:''?>" placeholder="Middle Name" /></div>
                                </div>-->
                                
                             <div id="dashboard-recent" class="panel panel-warning">   
                                <div class="panel-heading">
                                <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Details</span>
                                <ul class="nav nav-tabs nav-tabs-xs">
							<li class="active"><a data-toggle="tab" href="#personal-details">Personal Information</a></li>
                            <li><a data-toggle="tab" href="#educational-details">Educational Details</a></li>
                            <li><a data-toggle="tab" href="#documents-certificates">Documents& Certificates</a></li>
                            <li><a data-toggle="tab" href="#references">References</a></li>
                            <li><a data-toggle="tab" href="#payment-photo">Payment Details & Photo</a></li>
						</ul>
                                </div>
                                <div class="tab-content">
                      <div class="row">
					   <div class="form-group">
                       <span style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('msg1'); ?></span>
                      <span style="color:red; padding-left:110px;"><?php echo $this->session->flashdata('msg2'); ?></span>
                      </div>
                      </div>
						<!-- Comments widget -->

						<!-- Without padding -->
						<div id="personal-details" class="widget-comments panel-body tab-pane fade active in">
							<!-- Panel padding, without vertical padding -->
                            <div class="panel">
                            	<div class="panel-heading">Personal Details</div>
                                <div class="panel-body">
								 <form id="form1" name="form1" action="<?=base_url($currentModule.'/form1step1')?>" method="POST">                                                               
                              <!--  <input type="hidden" value="" id="campus_id" name="campus_id" />-->
                                 <div class="form-group">
                                    <label class="col-sm-3">Admission To <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                    <select name="admission-course" class="form-control"><?php
									foreach($course_details as $course){
										echo '<option value="'.$course['course_id'].'">'.$course['course_code'].'</option>';
									} ?></select>
									</div>                                    
                                    
                                    <label class="col-sm-2">Branch <?=$astrik?></label>
                                    <div class="col-sm-3">
                                    <select name="admission-branch" class="form-control" data-bvalidator="required">
									<option value="">Select</option>
									<?php
									foreach($branches as $branch){
										echo '<option value="'.$branch['branch_id'].'">'.$branch['branch_code'].'</option>';
									} ?></select></div>
                                </div>
                                <div class="panel-padding no-padding-vr">
                          <div class="form-group">
         <label class="col-sm-3">Student Name</label>
        <div class="col-sm-3"><input data-bv-field="slname" id="slname" name="slname" class="form-control" value="" placeholder="Last Name" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Last name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="regexp" class="help-block" style="display: none;">Last name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="stringLength" class="help-block" style="display: none;">Last name should be 2-50 characters</small></div>                                    
        <div class="col-sm-3"><input data-bv-field="sfname" id="sfname" name="sfname" class="form-control" value="" placeholder="First Name" type="text"><i data-bv-icon-for="sfname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small></div>
        <div class="col-sm-3"><input data-bv-field="smname" id="smname" name="smname" class="form-control" value="" placeholder="Middle Name" type="text"><i data-bv-icon-for="smname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="smname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Middle name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="smname" data-bv-validator="regexp" class="help-block" style="display: none;">Middle name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="smname" data-bv-validator="stringLength" class="help-block" style="display: none;">Middle name should be 2-50 characters.</small></div>
        </div>
       <div class="form-group">
         <label class="col-sm-3">Father's/Husband Name</label>
        <div class="col-sm-3"><input data-bv-field="slname" id="slname1" name="slname1" class="form-control" value="" placeholder="Last Name" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Last name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="regexp" class="help-block" style="display: none;">Last name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="stringLength" class="help-block" style="display: none;">Last name should be 2-50 characters</small></div>                                    
        <div class="col-sm-3"><input data-bv-field="sfname" id="sfname1" name="sfname1" class="form-control" value="" placeholder="First Name" type="text"><i data-bv-icon-for="sfname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small></div>
        <div class="col-sm-3"><input data-bv-field="smname" id="smname1" name="smname1" class="form-control" value="" placeholder="Middle Name" type="text"><i data-bv-icon-for="smname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="smname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Middle name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="smname" data-bv-validator="regexp" class="help-block" style="display: none;">Middle name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="smname" data-bv-validator="stringLength" class="help-block" style="display: none;">Middle name should be 2-50 characters.</small></div>
        </div></br>
        <div class="form-group">
         <label class="col-sm-3">Mother Name</label>
       <div class="col-sm-3"><input data-bv-field="sfname" id="sfname2" name="sfname2" class="form-control" value="" placeholder="First Name" type="text"><i data-bv-icon-for="sfname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="sfname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small></div>
        </div><br>
       
        <div class="form-group">
       <label class="col-sm-3">Date of Birth</label>
       <div class="col-sm-3 input-group date" id="dob-datepicker">
       <input type="text" id="dob" name="dob" class="form-control" value="<?=isset($_REQUEST['dob'])?$_REQUEST['dob']:''?>" placeholder="Date of Birth" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
      <div class="form-group">
                 	<label class="col-sm-3">Gender </label>
                                    <div class="col-sm-2">
									<label><input type="radio" checked value="M" id="gender" name="gender">Male</label>
                                	</div>
                                    <div class="col-sm-2">
                                	<label><input type="radio" value="F" id="gender" name="gender">Female</label>
                                	</div>
                                    <div class="col-sm-2">
                                	<label><input type="radio" value="T" id="gender" name="gender" >TG</label>
                                	</div>
								</div>
       <div class="form-group">
                       <label class="col-sm-3">Mobile</label>
                       <div class="col-sm-3"><input type="text" id="mobile" name="mobile" class="form-control" value="<?=isset($_REQUEST['mobile'])?$_REQUEST['mobile']:''?>" placeholder="" /></div>
                       <label class="col-sm-3">Email</label>
                       <div class="col-sm-3"><input type="text" id="email_id" name="email_id" class="form-control" value="<?=isset($_REQUEST['email_id'])?$_REQUEST['email_id']:''?>" placeholder="Email" /></div>                       
                   </div>             
                   <div class="form-group">
                       <label class="col-sm-3">Nationality</label>
					   <div class="col-sm-3"><input type="text" id="nationality" name="nationality" class="form-control" value="Indian" placeholder="" /></div>
				   <label class="col-sm-3">Category</label>
                       <div class="col-sm-3">
                       <select id="category" name="category" class="form-control"><option value="">Select</option>
					<option value="OPEN">OPEN</option>
					<option value="SC">SC</option>
					<option value="ST">ST</option>
					<option value="VJ/DT">VJ/DT</option>
					<option value="NT1">NT1</option>
					<option value="NT2">NT2</option>
					<option value="NT3">NT3</option>
					<option value="OBC">OBC</option>
					<option value="SBC">SBC</option>
					<option value="ESBC">ESBC Maratha</option>
					<option value="SBCM">SBC Muslim</option></select></div>
				   </div>
                   <div class="form-group">
                       
                      
                   </div>
                   <div class="form-group">
                       <label class="col-sm-3">Religion </label>
                       <div class="col-sm-3">
                       <select id="religion" name="religion" class="form-control"><option value="">Select</option>
					<option value="HINDU">HINDU</option>
					<option value="MUSSLIM">MUSSLIM</option>
					<option value="CHRISTIAN">CHRISTIAN</option>
					<option value="SIKHISM">SIKHISM</option>
					<option value="BUDDH">BUDDH</option></select>
                       </div>
					   <label class="col-sm-3">OMS/MS</label>
                       <div class="col-sm-3">
                       <select id="res_state" name="res_state" class="form-control"><option value="">Select</option>
                        <option value="MS">MS</option>
                        <option value="OMS">OMS</option></select>
                       </div> 
                   </div>
				   <div class="form-group">
                      <label class="col-sm-3">Aadhar Card No </label> 
					  <div class="col-sm-3"><input type="text" id="saadhar" name="saadhar" class="form-control" ></div>
                   </div> 
			<div class="form-group">
					<label class="col-sm-3">Hostel(Fill Enclosure I)</label>
					 <div class="col-sm-3">
					  <select id="hostel" name="hostel" class="form-control">
					    <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option></select>
					 </div>
					 <div class="col-sm-6">
				
									<div class="col-sm-3">
									<label><input type="radio" value="reg" id="hosteltype" name="hosteltype">Regular</label>
                                	</div>
									
                                    <div class="col-sm-3">
                                	<label><input type="radio" value="day" id="hosteltype" name="hosteltype">Day Boarding</label>
                                	</div>
					 
                                	</div>
					 
					</div>
					<div class="form-group">
					<div class="row">
					<label class="col-sm-3">Transport(Fill Enclosure II)</label>
					 <div class="col-sm-3">
					  <select id="transport" name="transport" class="form-control">
					    <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option></select>
					 </div>
					 <div class="col-sm-6">
					 <label class="col-sm-3">Bording Point</label>
					 <div class="col-sm-3"><input type="text" name="bording_point" placeholder="Bording Point"></div>
					 
					</div>
					</div>
					</div>	 
                                  
                                </div>
                                </div>
                            </div>
							
                          
                            <div class="panel">
                             <div class="panel-heading">Contact Address</div>
							 <div class="panel-body">   
                       		<table class="table table-bordered">
		<tr><th>Local Address</th>
        <th>Permanent Address</th></tr>
		<tr>
		<!--Local Address-->
		<td width="50%">
<div class="form-group">
<label  class="col-sm-3">HouseNo:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_A" NAME="bill_A" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Street :</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_B" NAME="bill_B" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">City :</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_C" NAME="bill_C" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">State :</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_D" NAME="bill_D" SIZE=30></div> 
</div>
<div class="form-group">
<label  class="col-sm-3">Country :</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_country" NAME="bill_country" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Post Code :</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="bill_pc" NAME="bill_pc" SIZE=30></div>
</div>
</fieldset>
		</td>
		<!--Permanent Address-->
		<td width="50%"><fieldset>
<div class="form-group">
<label  class="col-sm-3">HouseNo:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_A" NAME="shipping_A" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Street:</label><div class="col-sm-3"><INPUT TYPE="TEXT" NAME="shipping_B" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">City:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_C" NAME="shipping_C" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">State:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_D" NAME="shipping_D" SIZE=30></div> 
</div>
<div class="form-group">
<label  class="col-sm-3">Country:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_country" NAME="shipping_country" SIZE=30></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Post Code:</label><div class="col-sm-3"><INPUT TYPE="TEXT" id="shipping_pc" NAME="shipping_pc" SIZE=30></div>
</div>
</td></tr>
<tr><td><label style="text-align:left"><input name="same" onclick="copyBilling (this.form) " type="checkbox">Permanent Address is Same as Local Address</label></td></tr>
</table>					   
                            		
							 	</div>
                                
                               </div>
                  
							   <div class="panel">
                             <div class="panel-heading">Parent's/Guardian's Details</div>
                              <div class="panel-body">  
                           <div class="form-group">
                                    <label class="col-sm-3">Parent/Guardian's Name</label>
                                    <div class="col-sm-3">
									<input data-bv-field="parent_lname" id="parent_lname" name="parent_lname" class="form-control" value="" placeholder="Last Name" type="text"><i data-bv-icon-for="parent_lname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="parent_lname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Guardian Last name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="regexp" class="help-block" style="display: none;">Last name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="parent_lname" data-bv-validator="stringLength" class="help-block" style="display: none;">Guardian Last name should be 2-50 characters</small>
									</div>                                    
                                    <div class="col-sm-3"><input type="text" id="parent_fname" name="fname" class="form-control" value="<?=isset($_REQUEST['fname'])?$_REQUEST['fname']:''?>" placeholder="First Name" /></div>
                                    <div class="col-sm-3"><input type="text" id="parent_mname" name="mname" class="form-control" value="<?=isset($_REQUEST['mname'])?$_REQUEST['mname']:''?>" placeholder="Middle Name" /></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3">Relationship </label>
                                    <div class="col-sm-3"><select id="relationship" name="relationship" class="form-control">
                                	<option value="">Select</option>
									<option value="Father">Father</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Uncle">Uncle</option>
                                    <option value="Other">Other</option></select>
                                	</div>                                    
                                    <label class="col-sm-3">Occupation </label>
                                    <div class="col-sm-3"><select name="occupation" class="form-control">
                                	<option value="">Select</option>
                                    <option value="Service">Service</option>
                                    <option value="Business">Business</option>
                                    <option value="Farmer">Farmer</option>
                                    <option value="Other">Other</option></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Annual Income  </label>
                                    <div class="col-sm-3"><input type="text" id="annual_income" name="annual_income" class="form-control" value="<?=isset($_REQUEST['annual_income'])?$_REQUEST['annual_income']:''?>" placeholder="Annual Income in Rs." /></div>                                    
                                    <label class="col-sm-3">E-Mail </label>
                                    <div class="col-sm-3"><input type="text" id="parent_email" name="parent_email" class="form-control" value="<?=isset($_REQUEST['parent_email'])?$_REQUEST['parent_email']:''?>" placeholder="Email" /></div>                                    
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Mobile</label>
                                    <div class="col-sm-3"><input type="text" id="parent_mobile" name="parent_mobile" class="form-control" value="<?=isset($_REQUEST['parent_mobile'])?$_REQUEST['parent_mobile']:''?>" /></div>
                                    <label class="col-sm-3">Phone No</label>
                                    <div class="col-sm-3"><input type="text" id="parent_phone" name="parent_phone" class="form-control" value="<?=isset($_REQUEST['parent_phone'])?$_REQUEST['parent_phone']:''?>" /></div>                                    
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">Address</label>
                                    <div class="col-sm-3">
                                    <textarea id="parent_address" name="parent_address" class="form-control" rows="3" cols="50"><?=isset($_REQUEST['parent_address'])?$_REQUEST['parent_address']:''?></textarea></div>
                                                                        
                                </div>
                  </div>
				   </div>
				  <div class="form-group">
                                    <div class="col-sm-4"></div>
                                   
           <?php 
		   $stepfirst=$this->session->userdata('stepfirst_status');
		   if($stepfirst=='success'){?>
		                           <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Update</button>                                        
                                    </div> 
		                            <div class="col-sm-2">
                                       <!--<a class="btn btn-primary form-control" id="next" href="#educational-details">Next</a>  --> 
                                       <a  data-toggle="tab" class="btn btn-primary form-control" id="next" href="#educational-details">Next</a>									   
                                    </div>
                                                 <div class="col-sm-2">
                                        <a class="btn btn-primary form-control" href="<?=base_url('admission/cancel1')?>">Cancel</a>                                        
                                    </div>									
		   <?php }?>
		   <?php if($stepfirst!='success'){?>
                                   <div class="col-sm-2">
								   <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>
                                                                                
                                    </div>
		   <?php } ?>

		   
				 </div>	
</form>				 
                        </div>
						<!-- / .widget-comments -->

						<div id="educational-details" class="widget-comments panel-body tab-pane fade ">
						<h3></h3>
					<form id="form2" name="form2" action="<?=base_url($currentModule.'/form2step2')?>" method="POST"/>
					    <input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
						<input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
						<div class="panel">
                             <div class="panel-heading">Admission & Qualifying exam Details</div>
                              <div class="panel-body">
							   <div class="form-group">
         <label class="col-sm-3">Name Of Qualifying Exam</label>
        <div class="col-sm-3"><input data-bv-field="slname" id="qexam" name="qexam" class="form-control" value="" placeholder="Qualifying Exam" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Qualifying Exam name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="regexp" class="help-block" style="display: none;">Qualifying Exam name should be alphabate characters</small></div>                                    
        <label class="col-sm-3">Year of Passing</label>
		<div class="col-sm-3"><input data-bv-field="slname" id="pyexam" name="pyexam" class="form-control" value="" placeholder="Year of Passing" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Qualifying Exam name should not be empty</small></div>                                    
       </div>
       <div class="form-group">	   
		<label class="col-sm-3">Name Of College/School/Institute</label>
		<div class="col-sm-3"><input data-bv-field="slname" id="cexam" name="cexam" class="form-control" value="" placeholder="Name Of College" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Name Of College/School/Institute should not be empty </small></div>                                           
	                                       
	  </div>
      	<div class="form-group">
                 	<label class="col-sm-3">Admission Basis</label>
                                    <div class="col-sm-2">
									<label><input type="radio" checked value="EN" id="admission_basis" name="admission_basis">Entrance Exam</label>
                                	</div>
                                    <div class="col-sm-2">
                                	<label><input type="radio" value="GD" id="admission_basis" name="admission_basis">GD/PI</label>
                                	</div>
                                    <div class="col-sm-2">
                                	<label><input type="radio" value="M" id="admission_basis" name="admission_basis">Merit</label>
                                	</div>
								</div>	
<div class="form-group">	   
		<label class="col-sm-3">Roll No</label>
		<div class="col-sm-3"><input data-bv-field="slname" id="roll_exam" name="roll_exam" class="form-control" value="" placeholder="Roll Number" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Roll Number should not be empty </small></div>                                           
	    <label class="col-sm-3">Entrance Exam Rank</label>
		<div class="col-sm-3"><input data-bv-field="slname" id="exam_rank" name="exam_rank" class="form-control" value="" placeholder="Exam rank" type="text"><i data-bv-icon-for="slname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="slname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Name Of College/School/Institute should not be empty </small></div>                                                                              
	  </div>
							  </div>
							  </div>
							  <div class="panel">
                             <div class="panel-heading">Admission & Qualifying exam Details</div>
                              <div class="panel-body">
                        <div class="panel-padding no-padding-vr">
                            <div class="table-primary">
					<div class="table-header">
						<div class="table-caption">
							Educational Background
						</div>
					</div>
                    <div class="table-responsive">
					<table id="eduDetTable" class="table table-bordered">
						<thead>
							<tr>
								<th>Exam</th>
								<th>Name of the School/College</th>
								<th>Month & Year of Passing</th>
								<th>Seat No.</th>
                                <th>Name of Board/University</th>
                                <th>Marks Obtained</th>
                                <th>Marks Out of</th>
                                <th>Percentage</th>
                                <th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
                                <select name="exam_id[]" class="form-control">
                                <option value="">Select</option><option value="10">10th</option><option value="12">12th</option>
                                <option value="15">Bachelor's</option><option value="17">Master's</option><option value="18">PHD</option>
                                </select></td>
								<td><input data-bv-field="college_name" type="text"  id="college_name" name="college_name[]" class="form-control" value="<?=isset($_REQUEST['college_name'])?$_REQUEST['college_name']:''?>" placeholder="Name of the School/College" /><i data-bv-icon-for="tssc_eng" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="college_name" data-bv-validator="notEmpty" class="help-block" style="display: none;">Educational Details should not be empty </small></td>
								<td><select name="pass_year[]" class="form-control">
                                <option value="">Select</option>
                                <?php for($y=date("Y");$y>=date("Y")-60;$y--){
									echo '<option value="'.$y.'">'.$y.'</option>';
								}?>
                                </select>
                                <select name="pass_month[]" class="form-control">
                                <option value="">Select</option><option value="JAN">JAN</option><option value="FEB">FEB</option><option value="MAR">MAR</option><option value="APR">APR</option><option value="MAY">MAY</option><option value="JUN">JUN</option><option value="JUL">JUL</option><option value="AUG">AUG</option><option value="SEP">SEPT</option><option value="OCT">OCT</option><option value="NOV">NOV</option><option value="DEC">DEC</option></select></td>
								<td><input type="text" name="seat_no[]" class="form-control" value="<?=isset($_REQUEST['seat_no'])?$_REQUEST['seat_no']:''?>" placeholder="Seat No." /></td>
                                <td><input type="text" name="institute_name[]" class="form-control" value="<?=isset($_REQUEST['institute_name'])?$_REQUEST['institute_name']:''?>" placeholder="Name of Board/University" /></td>
								<td><input type="text" name="marks_obtained[]" class="form-control" value="<?=isset($_REQUEST['marks_obtained'])?$_REQUEST['marks_obtained']:''?>" /></td>
								<td><input type="text" name="marks_outof[]" class="form-control" value="<?=isset($_REQUEST['marks_outof'])?$_REQUEST['marks_outof']:''?>" placeholder="" /></td>
								<td><input type="text" name="percentage[]" class="form-control" value="<?=isset($_REQUEST['percentage'])?$_REQUEST['percentage']:''?>" placeholder="" /></td>
                                <td><input type="button" class="btn btn-xs btn-primary btn-flat" value="Add More" name="addMore" /><input type="button" class="btn btn-xs btn-danger btn-flat" value="Remove" name="remove" /></td>
							</tr>
							
						</tbody>
					</table>
					</div>
				</div>
                		</div>
						</div>
						</div>
						<div class="panel">
                             <div class="panel-heading">Educational Details</div>
                              <div class="panel-body">
							  <table class="table table-bordered">
		<tr><th>Exam</th><th>Subject</th><th>Total Marks</th><th>Marks Obtained</th><th>Date Of Passing</th></tr>
		<!--<tr><td>12th(Intermediate)or Equivalent</td><td><table ><tr><td><label>Physics</label></td></tr><tr><td><label>Chemistry</label></td></tr><tr><td><label>Maths/Bio.</label></td></tr></table></td></tr>-->
		<tr><td rowspan="4">12th(Intermediate)or Equivalent</td><td><label>Physics</label></td><td><input type="text" id="thsc_phy" name="thsc_phy"></td><td><input type="text" id="ohsc_phy" name="ohsc_phy"></td><td rowspan="4"><input type="text" id="hscpass_date" name="hscpass_date" placeholder="yyyy-mm-dd"></td></tr>
		<tr><td><label>chemistry</label></td><td><input type="text" id="thsc_chem" name="thsc_chem"></td><td><input type="text" id="ohsc_chem" name="ohsc_chem"></td></tr>
		<tr><td><label>Math/Bio</label></td><td><input type="text" id="thsc_bio" name="thsc_bio"></td><td><input type="text" id="ohsc_bio" name="ohsc_bio"></td></tr>
		<tr><td><label>English</label></td><td><input type="text" id="thsc_eng" name="thsc_eng"></td><td><input type="text" id="ohsc_eng" name="ohsc_eng"></td></tr>
		<tr><td><label>10th(Matriculation)Or Equivalent</label></td><td><label>English</label></td>
		<td><input data-bv-field="tssc_eng" type="text" id="tssc_eng" name="tssc_eng"><i data-bv-icon-for="tssc_eng" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="tssc_eng" data-bv-validator="notEmpty" class="help-block" style="display: none;">Mark should not be empty </small></td>
		<td><input data-bv-field="slname" type="text" id="ossc_eng" name="ossc_eng"></td>
		<td><input data-bv-field="slname" type="text" id="sscpass_date" name="sscpass_date" placeholder="yyyy-mm-dd"></td>
		</tr>
		</table>
							  </div>
							  </div>
						<div class="form-group">
                                    <div class="col-sm-4"></div>
                                                             
           <?php 
		   $stepsecond=$this->session->userdata('stepsecond_status');
		   if($stepsecond=='success'){?>
		                           <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
                                    </div> 
		                            <div class="col-sm-2">
                                       <!--<a class="btn btn-primary form-control" id="next" href="#educational-details">Next</a>  --> 
                                       <a  data-toggle="tab" class="btn btn-primary form-control" id="next" href="#documents-certificates">Next</a>									   
                                    </div> 
									 <div class="col-sm-2">
                                        <a class="btn btn-primary form-control" href="<?=base_url('admission/cancel2')?>">Cancel</a>                                        
                                    </div>
		   <?php }?>
		   <?php if($stepsecond!='success'){?>
                                   <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Save</button>                                        
                                    </div>
		   <?php } ?>
                   			
				 </div>	
				 </form>
				 </div>
						</div>
						
						
        <div id="documents-certificates" class="widget-threads panel-body tab-pane fade">
		<form id="form3" name="form3" action="<?=base_url($currentModule.'/form3sub3')?>" method="POST">
		<input type="hidden" name="reg_id" value="<?= $this->session->userdata('student_id') ?>">
		<input type="hidden" name="step1statusval" value="<?= $this->session->userdata('stepfirst_status') ?>">
		<input type="hidden" name="step2statusval" value="<?= $this->session->userdata('stepsecond_status') ?>">
                        <div class="panel">
                             <div class="panel-heading">List Of Documents To Be Submitted</div>
                              <div class="panel-body">
		<table class="table table-bordered">
		<tr><th>Sr No.</th><th>Particulars</th><th>Mark 'NA'if not applicable</th><th>Mark'O' if Submitted in original and 'X' if xerox submitted</th>
		<th>if Pending for submission(Specify Date of Submission)</th><th>(For Official Use)</th></tr>
		<?php foreach($doc_list as $doc){?>
		<tr><td><?=$doc['document_id']?></td><td><label><?=$doc['document_name']?></label></td><td><select name="dapplicable<?=$doc['document_id']?>"><option value="">Select</option><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox<?=$doc['document_id']?>"><option value="">Select</option><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker<?=$doc['document_id']?>">
       <input type="text" id="docsub<?=$doc['document_id']?>" name="docsub<?=$doc['document_id']?>" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark<?=$doc['document_id']?>"/></td>		
		</tr>
		<?php }?>
		</table>
     		
      				  
</div>
</div>
                             <div class="panel">
                             <div class="panel-heading">Certificate's Details </div>
                              <div class="panel-body">
							  <table class="table table-bordered">
		<tr><th>Certificate Name</th><th>Certificate No.</th><th>Issue Date</th><th>Validity</th></tr>
		<tr><td><label>Income</label></td><td><input type="text" name="cno1"/></td><td><div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker17">
       <input type="text" id="issuedt1" name="issuedt1" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document issue Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div></td><td></td></tr>
		<tr><td><label>Cast/category</label></td><td><input type="text" name="cno2"/></td><td><div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker18">
       <input type="text" id="issuedt2" name="issuedt2" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document issue Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div></td><td></td></tr>
		<tr><td><label>Residence/State Subject</label></td><td><input type="text" name="cno3"/></td><td><div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker19">
       <input type="text" id="issuedt3" name="issuedt3" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document issue Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div></td><td></td></tr>
		</table>
							  
							  </div>
							  </div>
<div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Save</button>                                        
                                    </div>  
				 </div>	
				 </form>
</div>	
<div id="references" class="widget-threads panel-body tab-pane fade">
<form id="form4" name="form4" action="<?=base_url($currentModule.'/form4sub4')?>" method="POST">
 <div class="panel">
                             <div class="panel-heading">Refernces details</div>
                              <div class="panel-body">
							  <label class="col-sm-6">References(Other than Blood Relatives)</label>
		<table class="table table-bordered">
		<tr><th>Sr No.</th><th>Reference Name</th><th>Contact Number</th></tr>
		<tr><td>1</td><td><input type="text" name="fref1"/></td><td><input type="text" name="frefcont1"></td></tr>
		<tr><td>2</td><td><input type="text" name="fref2"/></td><td><input type="text" name="frefcont2"></td></tr>
		<tr ><td colspan="3"><label >Are you related to any person employed with Sandip University(Y/N):</label><select name="reletedsandip"><option value="Y">Yes</option><option value="N">No</option></select></td></tr>
		<tr><td><label>Name:</label><input type="text" name="relatedname"/></td><td><label>Designation:</label><input type="text" name="relateddesig"/></td><td><label>Relation:</label><input type="text" name="relatedrelation"/></td></tr>
		<tr ><td colspan="3"><label >Are you related to Alumini of  Sandip University(Y/N):</label><select name="aluminisandip"><option value="Y">Yes</option><option value="N">No</option></select></td></tr>
		<tr><td><label>Name:</label><input type="text" name="alumininame"/></td><td><label>passing Year:</label><input type="text" name="aluminiyear"/></td><td><label>Relation:</label><input type="text" name="aluminirelation"/></td></tr>
		<tr ><td colspan="3"><label >Are your relatives studying in Sandip University(Y/N):</label><select name="relativesandip"><option value="Y">Yes</option><option value="N">No</option></select></td></tr>
		<tr><td><label>Name:</label><input type="text" name="relativename"/></td><td><label>CourseName:</label><input type="text" name="relativecoursenm"/></td><td><label>Relation:</label><input type="text" name="relativerelation"/></td></tr>
		</table>
</div>
</div>
 <div class="panel">
                             <div class="panel-heading">How Did You Come To Know About Sandip University</div>
                              <div class="panel-body">
							  <div class="form-group">
        <label class="col-sm-4">Select The Publicity Media:</label>
        <div class="col-sm-8">
		<select name="publicitysandip[]" multiple="multiple">
		<option value="newspaper-advt">Newspaper Advt</option>
		<option value="newspaper-insert">Newspaper Insertions</option>
		<option value="tv">TV Advt.</option>
		<option value="radio">Radio Advt.</option>
		<option value="hording">Hording</option>
		<option value="cstudent">Current Student</option>
		<option value="alumini">University Alumani</option>
		<option value="staff">University Staff</option>
		<option value="website">University Website</option>
		<option value="otherweb">Other Website</option>
		</select>
		</div>
        </div>
		<div class="form-group">
		<label class="col-sm-12">Give The Reference of the candidate who may be interested to pursue academic program in sandip university:</label>
		</div>
		<div class="form-group">
         <label class="col-sm-3">Name of Candidate</label>
        <div class="col-sm-6"><input data-bv-field="refcandidatenm" id="refcandidatenm" name="refcandidatenm" class="form-control" value="" placeholder="Candidate Name" type="text"></div>                                    
        </div>
		<div class="form-group">
		<label class="col-sm-3">Contact No.</label>
 		 <div class="col-sm-3"><input data-bv-field="refcandidatecont" id="refcandidatecont" name="refcandidatecont" class="form-control" value="" placeholder="Candidate contact" type="text"></div> 
         <label class="col-sm-3">Email Id</label>
		 <div class="col-sm-3"><input data-bv-field="refcandidateemail" id="refcandidateemail" name="refcandidateemail" class="form-control" value="" placeholder="Candidate Email" type="text"></div>       
	   </div>
	   <div class="form-group">
		<label class="col-sm-3">Relation with Candidate</label>
 		 <div class="col-sm-3"><input data-bv-field="refcandidaterelt" id="refcandidaterelt" name="refcandidaterelt" class="form-control" value="" placeholder="With Candidate relation" type="text"></div> 
         <label class="col-sm-3">Area Of Interetst</label>
		 <div class="col-sm-3"><input data-bv-field="refcandidateinterest" id="refcandidateinterest" name="refcandidateinterest" class="form-control" value="" placeholder="Candidate Interest Area" type="text"></div>       
	   </div>
							  </div>
							  </div>
<div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Save</button>                                        
                                    </div>  
				 </div>	
				 </form>
</div>
						  
                        <div id="payment-photo" class="widget-threads panel-body tab-pane fade">
						<form id="form5" name="form5" action="<?=base_url($currentModule.'/form5sub5')?>" method="POST">
                        <div class="panel">
                             <div class="panel-heading">Payment Details</div>
                              <div class="panel-body">
                            	<table class="table table-bordered">
		<tr><th>particulars</th><th>Applicable Fee</th><th>Ammount Paid</th><th>Balance(if any)</th><th>Payment particulars</th></tr>
		<tr><td>Admisiion Form/prospectus Fee(Not to pay if already paid)</td><td><input type="text" name="formfeeappli"></td><td><input type="text" name="formfeepaid"></td><td><input type="text" name="formfeebal"></td></tr>
		<tr><td>Tution Fee</td><td><input type="text" name="tutionfeeappli"></td><td><input type="text" name="tutionfeepaid"></td><td><input type="text" name="tutionfeebal"></td></tr>
		<tr><td>Other</td><td><input type="text" name="otherfeeappli"></td><td><input type="text" name="otherfeepaid"></td><td><input type="text" name="otherfeebal"></td></tr>
		<tr><td>Total</td><td><input type="text" name="totalfeeappli"></td><td><input type="text" name="totalfeepaid"></td><td><input type="text" name="totalfeebal"></td></tr>
		
		</table>
		<div class="form-group">
                       <label class="col-sm-3">BOI Account No.</label>
                       <div class="col-sm-3">
                       <input type="text" id="bank_name" name="bank_name" class="form-control" value="<?=isset($_REQUEST['bank_name'])?$_REQUEST['bank_name']:''?>" placeholder="BOI Account No." />
                       </div>
                       <label class="col-sm-3">Other Bank Account No.</label>
                       <div class="col-sm-3"><input type="text" id="account_no" name="account_no" class="form-control" value="<?=isset($_REQUEST['account_no'])?$_REQUEST['account_no']:''?>" placeholder="Other Bank Account No." /></div>
                   </div>
                   <div class="form-group">
                       <label class="col-sm-3">IFSC code</label>
                       <div class="col-sm-3">
                       <input type="text" id="ifsc" name="ifsc" class="form-control" value="<?=isset($_REQUEST['ifsc'])?$_REQUEST['ifsc']:''?>" placeholder="IFSC code" />
                       </div>
                       <label class="col-sm-3">Aadhar Card Number</label>
                       <div class="col-sm-3"><input type="text" id="aadhar_no" name="aadhar_no" class="form-control" value="<?=isset($_REQUEST['aadhar_no'])?$_REQUEST['aadhar_no']:''?>" placeholder="Aadhar Card No." /></div>
                   </div>
                               </div>
                            </div>
				<div class="panel">
                             <div class="panel-heading">Photo Uplod </div>
                              <div class="panel-body">	
<div class="form-group">
		<label class="col-sm-3">Upload Photo:</label>
		<div class="col-sm-3"><input type="file" enctype="multipart/formdata" name="stud-profile-photo"></div>
		<div class="col-sm-3"><input type="submit" name="submit" value="upload"/></div>
		</div>							  
							</div>
							</div>
							<div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Save</button>                                        
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
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker1').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker2').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker3').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker4').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker5').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker6').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker7').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker8').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker9').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker10').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker11').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker12').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker13').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker14').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker15').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker16').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker17').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker18').datepicker( {format: 'yyyy-mm-dd'});
	$('#doc-sub-datepicker19').datepicker( {format: 'yyyy-mm-dd'});
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