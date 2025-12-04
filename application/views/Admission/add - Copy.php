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
				},
                lhouse_no:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Housse No should not be empty'
                      },
                      regexp: 
                      {
                        regexp:/^[0-9/]+$/,
                        message: 'House No should be Numeric'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'House No should be 2-50 characters'
                        }
                    }

                }

            
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
                            <form id="form" name="form" action="<?=base_url($currentModule.'/form1sub')?>" method="POST">                                                               
                                <input type="hidden" value="" id="campus_id" name="campus_id" />
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
                            <div class="form-group"><h4>Name of the Applicant as in the Marks Card of Standard 10th exam</h4></div>
                                                        
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

						<!-- Comments widget -->

						<!-- Without padding -->
						<!--Personal details Tab-->
	<div id="personal-details" class="tab-pane fade in active">
   <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Personal Details</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
        <div class="panel-body">
		
         <div class="form-group">
         <label class="col-sm-3">Student Name</label>
        <div class="col-sm-3"><input data-bv-field="flname" id="flname" name="flname" class="form-control" value="" placeholder="Last Name" type="text"><i data-bv-icon-for="flname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="flname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Last name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="flname" data-bv-validator="regexp" class="help-block" style="display: none;">Last name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="flname" data-bv-validator="stringLength" class="help-block" style="display: none;">Last name should be 2-50 characters</small></div>                                    
        <div class="col-sm-3"><input data-bv-field="ffname" id="ffname" name="ffname" class="form-control" value="" placeholder="First Name" type="text"><i data-bv-icon-for="ffname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="ffname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="ffname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="ffname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small></div>
        <div class="col-sm-3"><input data-bv-field="fmname" id="fmname" name="fmname" class="form-control" value="" placeholder="Middle Name" type="text"><i data-bv-icon-for="fmname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="fmname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Middle name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="fmname" data-bv-validator="regexp" class="help-block" style="display: none;">Middle name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="fmname" data-bv-validator="stringLength" class="help-block" style="display: none;">Middle name should be 2-50 characters.</small></div>
        </div>
       <div class="form-group">
         <label class="col-sm-3">Father's/Husband Name</label>
        <div class="col-sm-3"><input data-bv-field="flname" id="flname" name="flname1" class="form-control" value="" placeholder="Last Name" type="text"><i data-bv-icon-for="flname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="flname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Last name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="flname" data-bv-validator="regexp" class="help-block" style="display: none;">Last name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="flname" data-bv-validator="stringLength" class="help-block" style="display: none;">Last name should be 2-50 characters</small></div>                                    
        <div class="col-sm-3"><input data-bv-field="ffname" id="ffname" name="ffname1" class="form-control" value="" placeholder="First Name" type="text"><i data-bv-icon-for="ffname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="ffname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="ffname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="ffname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small></div>
        <div class="col-sm-3"><input data-bv-field="fmname" id="fmname" name="fmname1" class="form-control" value="" placeholder="Middle Name" type="text"><i data-bv-icon-for="fmname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="fmname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Middle name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="fmname" data-bv-validator="regexp" class="help-block" style="display: none;">Middle name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="fmname" data-bv-validator="stringLength" class="help-block" style="display: none;">Middle name should be 2-50 characters.</small></div>
        </div></br>
        <div class="form-group">
         <label class="col-sm-3">Mother Name</label>
       <div class="col-sm-3"><input data-bv-field="ffname" id="ffname" name="ffname2" class="form-control" value="" placeholder="First Name" type="text"><i data-bv-icon-for="ffname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="ffname" data-bv-validator="notEmpty" class="help-block" style="display: none;">First name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="ffname" data-bv-validator="regexp" class="help-block" style="display: none;">First name should be alphabate characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="ffname" data-bv-validator="stringLength" class="help-block" style="display: none;">First name should be 2-50 characters.</small></div>
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
									<label><input type="radio" value="M" id="gender" name="gender">Male</label>
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
					   <div class="col-sm-3"><input type="text" id="nationality" name="nationality" class="form-control" value="" placeholder="" /></div>
				   <label class="col-sm-3">Category</label>
                       <div class="col-sm-3">
                       <select id="category" name="category" class="form-control"><option value="Select">Select</option>
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
                       <select id="religion" name="religion" class="form-control"><option value="Select">Select</option>
					<option value="HINDU">HINDU</option>
					<option value="MUSSLIM">MUSSLIM</option>
					<option value="CHRISTIAN">CHRISTIAN</option>
					<option value="SIKHISM">SIKHISM</option>
					<option value="BUDDH">BUDDH</option></select>
                       </div>
                   </div>
				   <div class="form-group">
                       <label class="col-sm-3">OMS/MS</label>
                       <div class="col-sm-3">
                       <select id="res_state" name="res_state" class="form-control"><option value="Select">Select</option>
                        <option value="MS">MS</option>
                        <option value="OMS">OMS</option></select>
                       </div> 
                   </div> 
			<div class="form-group">
					
					
					<label class="col-sm-3">Hostel(Fill Enclosure I)</label>
					 <div class="col-sm-3">
					  <select id="transport" name="transport" class="form-control"><option value="Select">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option></select>
					 </div>
					 <div class="col-sm-6">
				
									<div class="col-sm-3">
									<label><input type="radio" value="reg" id="transport" name="transport">Regular</label>
                                	</div>
									
                                    <div class="col-sm-3">
                                	<label><input type="radio" value="day" id="transport" name="transport">Day Boarding</label>
                                	</div>
					 
                                	</div>
					 
					</div>
					<div class="form-group">
					<div class="row">
					<label class="col-sm-3">Transport(Fill Enclosure II)</label>
					 <div class="col-sm-3">
					  <select id="transport" name="transport" class="form-control"><option value="Select">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option></select>
					 </div>
					 <div class="col-sm-6">
					 <label class="col-sm-3">Point Of Bording</label>
					 <input type="text">
					 
					</div>
					</div>
					</div>	    								
       </div>
	   <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    </div>
    							
      </div>
	   
    </div>
	 <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Address For Correspondance</a>
        </h4>
		
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
		<table class="table table-bordered">
		<tr><th>Local Address</th>
        <th>Permanent Address</th></tr>
		<tr>
		<!--Local Address-->
		<td width="50%">
		                                <div class="form-group">
                                        <label class="col-sm-4">Flat/House No</label>
                                        <div class="col-sm-8"><input type="text" id="lhouse_no" name="lhouse_no" class="form-control" value="<?=isset($_REQUEST['lhouse_no'])?$_REQUEST['lhouse_no']:''?>" placeholder="Flat/House No" /><i data-bv-icon-for="lhouse_no" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="lhouse_no" data-bv-validator="notEmpty" class="help-block" style="display: none;">House Number should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="lhouse_no" data-bv-validator="regexp" class="help-block" style="display: none;">House number should be  numeric characters</small><small data-bv-result="NOT_VALIDATED" data-bv-for="lhouse_no" data-bv-validator="stringLength" class="help-block" style="display: none;">House Number should be 1-50 characters.</small></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4">Area /Colony</label>
                                        <div class="col-sm-8"><input type="text" id="larea" name="larea" class="form-control" value="<?=isset($_REQUEST['larea'])?$_REQUEST['larea']:''?>" placeholder="Area /Colony" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4">Landmark</label>
                                        <div class="col-sm-8"><input type="text" id="llandmark" name="llandmark" class="form-control" value="<?=isset($_REQUEST['llandmark'])?$_REQUEST['llandmark']:''?>" placeholder="Landmark" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4">Taluka</label>
                                        <div class="col-sm-8"><input type="text" id="ltaluka" name="ltaluka" class="form-control" value="<?=isset($_REQUEST['ltaluka'])?$_REQUEST['ltaluka']:''?>" placeholder="Taluka" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4">City</label>
                                        <div class="col-sm-8"><input type="text" id="lcity" name="lcity" class="form-control" value="<?=isset($_REQUEST['lcity'])?$_REQUEST['lcity']:''?>" placeholder="City" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4">State</label>
                                        <div class="col-sm-8"><select id="lstate" name="lstate" class="form-control"></select></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4">District</label>
                                        <div class="col-sm-8"><select id="ldistrict" name="ldistrict" class="form-control"></select></div>
                                    </div>
									<div class="form-group">
                                        <label class="col-sm-4">Pincode</label>
                                        <div class="col-sm-8"><input type="text" id="lpincode" name="lpincode" class="form-control"></div>
                                    </div>
		</td>
		<!--Per manent Address-->
		<td width="50%"><div class="form-group">
                                        <label class="col-sm-4">Flat/House No</label>
                                        <div class="col-sm-8"><input type="text" id="phouse_no" name="phouse_no" class="form-control" value="<?=isset($_REQUEST['phouse_no'])?$_REQUEST['phouse_no']:''?>" placeholder="Flat/House No" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4">Area /Colony</label>
                                        <div class="col-sm-8"><input type="text" id="parea" name="parea" class="form-control" value="<?=isset($_REQUEST['parea'])?$_REQUEST['parea']:''?>" placeholder="Area /Colony" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4">Landmark</label>
                                        <div class="col-sm-8"><input type="text" id="plandmark" name="plandmark" class="form-control" value="<?=isset($_REQUEST['plandmark'])?$_REQUEST['plandmark']:''?>" placeholder="Landmark" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4">Taluka</label>
                                        <div class="col-sm-8"><input type="text" id="ptaluka" name="ptaluka" class="form-control" value="<?=isset($_REQUEST['ptaluka'])?$_REQUEST['ptaluka']:''?>" placeholder="Taluka" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4">City</label>
                                        <div class="col-sm-8"><input type="text" id="pcity" name="pcity" class="form-control" value="<?=isset($_REQUEST['pcity'])?$_REQUEST['pcity']:''?>" placeholder="City" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4">State</label>
                                        <div class="col-sm-8"><select id="lstate" name="lstate" class="form-control"></select></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4">District</label>
                                        <div class="col-sm-8"><select id="ldistrict" name="ldistrict" class="form-control"></select></div>
                                    </div>
									<div class="form-group">
                                        <label class="col-sm-4">Pincode</label>
                                        <div class="col-sm-8"><input type="text" id="ppincode" name="ppincode" class="form-control"></div>
                                    </div>
									</td></tr>
		<tr><td><input type="checkbox">Click Here If Local and Permanent address is same</td></tr>
		</table>							
		</div>
		<div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    </div>
      </div>
	   
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Parent's/Guardian's Details</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">
		<div class="form-group">
                                    <label class="col-sm-3">Parent/Guardian's Name</label>
                                    <div class="col-sm-3"><input type="text" id="parent_lname" name="lname" class="form-control" value="<?=isset($_REQUEST['lname'])?$_REQUEST['lname']:''?>" placeholder="Last Name" /></div>                                    
                                    <div class="col-sm-3"><input type="text" id="parent_fname" name="fname" class="form-control" value="<?=isset($_REQUEST['fname'])?$_REQUEST['fname']:''?>" placeholder="First Name" /></div>
                                    <div class="col-sm-3"><input type="text" id="parent_mname" name="mname" class="form-control" value="<?=isset($_REQUEST['mname'])?$_REQUEST['mname']:''?>" placeholder="Middle Name" /></div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3">Relationship </label>
                                    <div class="col-sm-3"><select name="relationship" class="form-control">
                                	<option value="">Select</option><option value="Father">Father</option>
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
                                    <div class="col-sm-3"><input type="text" id="anuual_income" name="anuual_income" class="form-control" value="<?=isset($_REQUEST['anuual_income'])?$_REQUEST['anuual_income']:''?>" placeholder="Annual Income in Rs." /></div>                                    
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
		<div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    </div>
      </div>
	   
    </div>
   
  </div> 
  <!--<div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>-->
	</form>  
    </div>
	<!--End of Personal Details Tab-->
						<!-- / .widget-comments -->
<!--Tab of Educational Details-->
						<div id="educational-details" class="widget-threads panel-body tab-pane no-padding fade">
						 <form id="form1" name="form1" action="<?=base_url($currentModule.'/submit')?>" method="POST"> 
						<div class="panel-group" id="accordion1">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion1" href="#collapse6">Admission & Qualifying exam Details</a>
        </h4>
      </div>
      <div id="collapse6" class="panel-collapse collapse in">
        <div class="panel-body">
		
         <div class="form-group">
         <label class="col-sm-3">Name Of Qualifying Exam</label>
        <div class="col-sm-3"><input data-bv-field="flname" id="qexam" name="qexam" class="form-control" value="" placeholder="Qualifying Exam" type="text"><i data-bv-icon-for="flname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="flname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Qualifying Exam name should not be empty</small><small data-bv-result="NOT_VALIDATED" data-bv-for="flname" data-bv-validator="regexp" class="help-block" style="display: none;">Qualifying Exam name should be alphabate characters</small></div>                                    
        <label class="col-sm-3">Year of Passing</label>
		<div class="col-sm-3"><input data-bv-field="flname" id="pyexam" name="pyexam" class="form-control" value="" placeholder="Year of Passing" type="text"><i data-bv-icon-for="flname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="flname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Qualifying Exam name should not be empty</small></div>                                    
       </div>
       <div class="form-group">	   
		<label class="col-sm-3">Name Of College/School/Institute</label>
		<div class="col-sm-3"><input data-bv-field="flname" id="cexam" name="cexam" class="form-control" value="" placeholder="Name Of College" type="text"><i data-bv-icon-for="flname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="flname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Name Of College/School/Institute should not be empty </small></div>                                           
	                                       
	  </div>
      	<div class="form-group">
                 	<label class="col-sm-3">Admission Basis</label>
                                    <div class="col-sm-2">
									<label><input type="radio" value="EN" id="admission_basis" name="admission_basis">Entrance Exam</label>
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
		<div class="col-sm-3"><input data-bv-field="flname" id="roll_exam" name="roll_exam" class="form-control" value="" placeholder="Name Of College" type="text"><i data-bv-icon-for="flname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="flname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Roll Number should not be empty </small></div>                                           
	    <label class="col-sm-3">Entrance Exam Rank</label>
		<div class="col-sm-3"><input data-bv-field="flname" id="exam_rank" name="exam_rank" class="form-control" value="" placeholder="Name Of College" type="text"><i data-bv-icon-for="flname" class="form-control-feedback" style="display: none; top: 0px;"></i><small data-bv-result="NOT_VALIDATED" data-bv-for="flname" data-bv-validator="notEmpty" class="help-block" style="display: none;">Name Of College/School/Institute should not be empty </small></div>                                                                              
	  </div>								
       </div>
      </div>
    </div>
	 <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion1" href="#collapse7">Academic History</a>
        </h4>
		
      </div>
      <div id="collapse7" class="panel-collapse collapse">
        <div class="panel-body">
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
								<td><input type="text" name="college_name[]" class="form-control" value="<?=isset($_REQUEST['college_name'])?$_REQUEST['college_name']:''?>" placeholder="Name of the School/College" /></td>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion1" href="#collapse8">Educational Details</a>
        </h4>
      </div>
      <div id="collapse8" class="panel-collapse collapse">
        <div class="panel-body">
		<table class="table table-bordered">
		<tr><th>Exam</th><th>Subject</th><th>Total Marks</th><th>Marks Obtained</th><th>Date Of Passing</th></tr>
		<!--<tr><td>12th(Intermediate)or Equivalent</td><td><table ><tr><td><label>Physics</label></td></tr><tr><td><label>Chemistry</label></td></tr><tr><td><label>Maths/Bio.</label></td></tr></table></td></tr>-->
		<tr><td rowspan="4">12th(Intermediate)or Equivalent</td><td><label>Physics</label></td><td><input type="text"></td><td><input type="text"></td><td rowspan="4"></td></tr>
		<tr><td><label>chemistry</label></td><td><input type="text"></td><td><input type="text"></td></tr>
		<tr><td><label>Math/Bio</label></td><td><input type="text"></td><td><input type="text"></td></tr>
		<tr><td><label>English</label></td><td><input type="text"></td><td><input type="text"></td></tr>
		<tr><td><label>10th(Matriculation)Or Equivalent</label></td><td><label>English</label></td><td><input type="text"></td><td><input type="text"></td></tr>
		</table>
		</div>
      </div>
    </div>
   
  </div> 
  <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
 </form>                      
</div>
<!--End Of Educational tab -->
                        <!--Documents and certificates -->
                        <div id="documents-certificates" class="widget-threads panel-body tab-pane fade">
						 <form id="form2" name="form2" action="<?=base_url($currentModule.'/submit')?>" method="POST"> 
                        <div class="panel-group" id="accordion2">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion2" href="#collapse9">List Of Documents To Be Submitted </a>
        </h4>
      </div>
      <div id="collapse9" class="panel-collapse collapse in">
        <div class="panel-body">
		<table class="table table-bordered">
		<tr><th>Sr No.</th><th>Particulars</th><th>Mark 'NA'if not applicable</th><th>Mark'O' if Submitted in original and 'X' if xerox submitted</th>
		<th>if Pending for submission(Specify Date of Submission)</th><th>(For Official Use)</th></tr>
		<tr><td>1.</td><td><label>Common Admission Form *</label></td><td><select name="dapplicable1"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox1"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker1">
       <input type="text" id="docsub1" name="docsub1" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark1"/></td>		
		</tr>
		<tr><td>2.</td><td><label>Attested Copy of matriculation or its equivalent certificate for DOB testimony*</label></td><td><select name="dapplicable2"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox2"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker2">
       <input type="text" id="docsub2" name="docsub2" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark2"/></td>		
		</tr>
		<tr><td>3.</td><td><label>Attested Copy of marks-sheet of qualifying examination*</label></td><td><select name="dapplicable3"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox3"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker3">
       <input type="text" id="docsub3" name="docsub3" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark3"/></td>		
		</tr>
		<tr><td>4.</td><td><label>one recent passport size photograph pasted on main form,enclosures and one extra*</label></td><td><select name="dapplicable4"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox4"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker4">
       <input type="text" id="docsub4" name="docsub4" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark4"/></td>		
		</tr>
		<tr><td>5.</td><td><label>Proof of residence(Passport/Votr id/ration card/Driving licenses/Bank statement/telephone Or Elecricity Bill)*</label></td><td><select name="dapplicable5"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox5"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker5">
       <input type="text" id="docsub5" name="docsub5" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark5"/></td>		
		</tr>
		<tr><td>6.</td><td><label>Migration/Transfer certificate*</label></td><td><select name="dapplicable6"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox6"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker6">
       <input type="text" id="docsub6" name="docsub6" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark6"/></td>		
		</tr>
		<tr><td>7.</td><td><label>Cast/Category certificate(if applicable)*</label></td><td><select name="dapplicable7"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox7"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker7">
       <input type="text" id="docsub7" name="docsub7" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark7"/></td>		
		</tr>
		<tr><td>8.</td><td><label>Domicile Certificate(if applicable)*</label></td><td><select name="dapplicable8"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox8"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker8">
       <input type="text" id="docsub8" name="docsub8" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark8"/></td>		
		</tr>
		<tr><td>9.</td><td><label>Proof of payment(Demand Draft/Receipt of cash deposited)</label></td><td><select name="dapplicable9"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox9"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker9">
       <input type="text" id="docsub9" name="docsub9" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark9"/></td>		
		</tr>
		<tr><td>10.</td><td><label>Entrance Test Rank/Score sheet(if applicable)</label></td><td><select name="dapplicable10"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox10"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker10">
       <input type="text" id="docsub10" name="docsub10" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark10"/></td>		
		</tr>
		<tr><td>11.</td><td><label>Recommendation by Teacher(If any)(in sealed envelope)</label></td><td><select name="dapplicable11"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox11"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker11">
       <input type="text" id="docsub11" name="docsub11" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark11"/></td>		
		</tr>
		<tr><td>12.</td><td><label>Enclosure I-Hostel Form</label></td><td><select name="dapplicable12"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox12"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker12">
       <input type="text" id="docsub12" name="docsub12" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark12"/></td>		
		</tr>
		<tr><td>13.</td><td><label>Enclosure II-Transportation Form</label></td><td><select name="dapplicable13"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox13"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker13">
       <input type="text" id="docsub13" name="docsub13" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark13"/></td>		
		</tr>
		<tr><td>14.</td><td><label>Affidavit(On Rs.10/-Non Judicial Stamp paper)if there is a gap in study after qualifying exam.</label></td><td><select name="dapplicable14"><option value="A">Yes</option><option value="NA">NA</option></select></td>
		<td><select name="ox14"><option value="O">O</option><option value="X">X</option></select></td>
		<td>
		 <div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker14">
       <input type="text" id="docsub14" name="docsub14" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document submit Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div> 
		</td>
        <td><input type="text" name="remark14"/></td>		
		</tr>
		</table>
        								
       </div>
      </div>
    </div>
	<div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion2" href="#collapse10">Certificates Details </a>
        </h4>
      </div>
      <div id="collapse10" class="panel-collapse collapse">
        <div class="panel-body">
		<table class="table table-bordered">
		<tr><th>Certificate Name</th><th>Certificate No.</th><th>Issue Date</th><th>Validity</th></tr>
		<tr><td><label>Income</label></td><td><input type="text" name="cno1"/></td><td><div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker15">
       <input type="text" id="issuedt1" name="issuedt1" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document issue Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div></td><td></td></tr>
		<tr><td><label>Cast/category</label></td><td><input type="text" name="cno2"/></td><td><div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker16">
       <input type="text" id="issuedt2" name="issuedt2" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document issue Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div></td><td></td></tr>
		<tr><td><label>Residence/State Subject</label></td><td><input type="text" name="cno3"/></td><td><div class="form-group">
       <div class="input-group date" id="doc-sub-datepicker17">
       <input type="text" id="issuedt3" name="issuedt3" class="form-control" value="<?=isset($_REQUEST['docsub'])?$_REQUEST['docsub']:''?>" placeholder="Document issue Date" />
       <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
       </div>                                    
        </div></td><td></td></tr>
		</table>
        								
       </div>
      </div>
    </div>
	</div>
	<div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
	</form>
	</div>
                        
<!--end of document and certificates-->
<!--start of References-->
  <div id="references" class="widget-threads panel-body tab-pane fade">
   <form id="form3" name="form3" action="<?=base_url($currentModule.'/submit')?>" method="POST"> 
    <div class="panel-group" id="accordion3">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion3" href="#collapse11">Refernces details </a>
        </h4>
      </div>
      <div id="collapse11" class="panel-collapse collapse in">
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
		</div>
		<div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion3" href="#collapse12">How Did You Come To Know About Sandip University </a>
        </h4>
      </div>
      <div id="collapse12" class="panel-collapse collapse ">
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
		</div>
		</div>
		<div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
		</form>
  </div>
  <!--end of References-->
  <!--start of payment-photo-->
  <div id="payment-photo" class="widget-threads panel-body tab-pane fade">
   <form id="form4" name="form4" action="<?=base_url($currentModule.'/submit')?>" method="POST"> 
   <div class="panel-group" id="accordion4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion4" href="#collapse13">Payment Details </a>
        </h4>
      </div>
      <div id="collapse13" class="panel-collapse collapse in">
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
                       <input type="text" id="boi_account_no" name="boi_account_no" class="form-control" value="<?=isset($_REQUEST['boi_account_no'])?$_REQUEST['boi_account_no']:''?>" placeholder="BOI Account No." />
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
		</div>
		<div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion4" href="#collapse14">Photo Uplod </a>
        </h4>
      </div>
      <div id="collapse14" class="panel-collapse collapse">
        <div class="panel-body">
		<div class="form-group">
		<label class="col-sm-3">Upload Photo:</label>
		<div class="col-sm-3"><input type="file" enctype="multipart/formdata" name="stud-profile-photo"></div>
		<div class="col-sm-3"><input type="submit" name="submit" value="upload"/></div>
		</div>
		</div>
		</div>
		</div>
		</div>
		<div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
		</form>
  </div>
  <!--end of payment-photo-->
                          
                              
                                
                           
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