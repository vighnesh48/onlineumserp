<html>
<head>
    <title>Add PAckage Student Form</title>
    <script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
    <link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
    <link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
    <script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
    <script>    
      /*  $(document).ready(function()
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
                  
                    enrollment_no:
                    {
                        validators: 
                        {
                            notEmpty: 
                            {
                                message: 'PRN should not be empty'
                            }
                        }
                    },
                    student_name:
                    {
                        validators: 
                        {
                            notEmpty: 
                            {
                                message: 'Name should not be empty'
                            }
                        }
                    },
                    mobile:
                    {
                        validators: 
                        {
                            notEmpty: 
                            {
                                message: 'Mobile should not be empty'
                            }
                        }
                    },
                    institute:
                    {
                        validators: 
                        {
                            notEmpty: 
                            {
                                message: 'institute should not be empty'
                            }
                        }
                    },
                    amount:
                    {
                        validators: 
                        {
                            notEmpty: 
                            {
                                message: 'Amount should not be empty'
                            }
                        }
                    },
                    academic_year:
                    {
                        validators: 
                        {
                            notEmpty: 
                            {
                                message: 'academic should not be empty'
                            }
                           
                        }
                    },
                    mode:
                    {
                        validators: 
                        { notEmpty: 
                            {
                                message: 'mode should not be empty'
                            }
                           
                        }
                    },
                    status:
                    {
                        validators: 
                        {
                            notEmpty: 
                            {
                                message: 'status should not be empty'
                            }
                        }
                    },
                  
                    type:
                    {
                        validators: 
                        {
                            notEmpty: 
                            {
                                message: 'type should not be empty'
                            }
                        }
                    }
                }       
            })
        });*/
    </script>
    
    <?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
    ?>

</head>
<body>
    <div id="content-wrapper">
        <ul class="breadcrumb breadcrumb-page">
        </ul>
        <div class="page-header">			
            <div class="row">
                <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Package Student</h1>
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
                                <span class="panel-title">Package Student Details</span>
                        </div>
                        <div class="panel-body">
                            <div class="table-info">                            
                             
                                <form id="form" name="form" action="<?=base_url($currentModule.'/add')?>" method="POST">                                                               
                                    <!-- <div class="form-group">
                                    
                                    <label class="col-sm-3">Enrollment No:</label>    
                                    <div class="col-sm-3"> <input type="text" id="enrollment_no" name="enrollment_no" class="form-control" value="<?= set_value('enrollment_no'); ?>"></div>
                                    <div class="text-danger"><?php // echo form_error('enrollment_no'); ?></div>
                                    <input type="hidden" id="first_name" name="first_name" readonly>
                                    <input type="hidden" id="middle_name" name="middle_name" readonly>
                                    <input type="hidden" id="last_name" name="last_name" readonly>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button" id="search_button" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>              
                                    </div> -->

                                    <div class="form-group">
                                        <label class="col-sm-3">Enrollment No:<?=$astrik?></label>    
                                        <div class="col-sm-3">
                                            <input type="text" id="enrollment_no" name="enrollment_no" class="form-control" value="<?= set_value('enrollment_no'); ?>">
                                            <div class=" text-danger" id="enrollment_no_error"><?php  echo form_error('enrollment_no'); ?></div> 
                                        </div>

                                        <div class="col-sm-3">
                                            <button type="button" id="search_button" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3">Student ID:</label>                                    
                                        <div class="col-sm-6"><input type="text" id="student_id" name="student_id" class="form-control" readonly /></div>                                    
                                        <div class="col-sm-3"><span style="color:red;"><?php echo form_error('student_id');?></span></div>
                                    </div> 

                                    <div class="form-group">
                                        <label class="col-sm-3">Name:</label>                                    
                                        <div class="col-sm-6"><input type="" id="student_name" name="student_name" class="form-control" readonly /></div>                                    
                                        <div class="col-sm-3"><span style="color:red;"><?php echo form_error('name');?></span></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3">Mobile:</label>                                    
                                        <div class="col-sm-6"><input type="text" id="mobile" name="mobile" class="form-control" readonly /></div>                                    
                                        <div class="col-sm-3"><span style="color:red;"><?php echo form_error('mobile');?></span></div>
                                    </div>   

                                    <!-- <div class="form-group">
                                        <label class="col-sm-3">Organization:</label>
                                        <div class="col-sm-6">
                                            <select id="org_frm" name="org_frm" class="form-control">
                                                <option value="" disabled selected>Select Organization</option>
                                                <option value="SUN">SUN</option>
                                                <option value="SF">SF</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3"><span style="color:red;"><?php // echo form_error('org_frm');?></span></div>
                                    </div> *********
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                        <label class="col-sm-3">ORG:</label>                                    
                                        <input type="text" name="org_frm" value="<?php // echo set_value('org_frm'); ?>" />
                                    </div> 
                                    </div>  --> 

                                    <!-- <div class="form-group">
                                        <label class="col-sm-3">Organization:</label>                                    
                                        <div class="col-sm-6"> <input type="text" class="form-control" placeholder="NOT MANDATORY TO GET THIS FIELD" name="org_frm" value="<?php echo set_value('org_frm'); ?>" readonly/></div>                                    
                                        <div class="col-sm-3"><span style="color:red;"><?php // echo form_error('org_frm');?></span></div>
                                    </div>    -->

                                    <div class="form-group">
                                        <label class="col-sm-3">Aadhar Number:</label>                                    
                                        <div class="col-sm-6"><input type="text" id="adhar_card_no" name="adhar_card_no" class="form-control" readonly /></div>                                    
                                        <div class="col-sm-3"><span style="color:red;"><?php echo form_error('adhar_card_no');?></span></div>
                                    </div>  
                                    
                                    <div class="form-group">
                                        <label class="col-sm-3">Institute:</label>                                    
                                        <div class="col-sm-6"><input type="text" id="institute_name" name="institute_name" class="form-control" readonly /></div>                                    
                                        <div class="col-sm-3"><span style="color:red;"><?php echo form_error('institute_name');?></span></div>
                                    </div>  

                                    <div class="form-group">
                                        <label class="col-sm-3">Email:</label>                                    
                                        <div class="col-sm-6"><input type="text" id="email" name="email" class="form-control" readonly /></div>                                    
                                        <div class="col-sm-3"><span style="color:red;"><?php echo form_error('email');?></span></div>
                                    </div>  
                                    
                                    <div class="form-group">
                                        <label class="col-sm-3">Amount:</label>                                    
                                        <div class="col-sm-6">
                                            <input type="text" id="amount" name="amount" class="form-control" value="0" readonly>
                                        </div>                                    
                                        <div class="col-sm-3"><span style="color:red;"><?php echo form_error('amount');?></span></div>
                                    </div>
                              
                                    <div class="form-group">
                                        <label class="col-sm-3">Academic:</label>                                    
                                        <div class="col-sm-6"><input type="text" id="academic_year" name="academic_year" class="form-control" readonly /></div>                                    
                                        <div class="col-sm-3"><span style="color:red;"><?php echo form_error('academic_year');?></span></div>
                                    </div>  

                                    <div class="form-group">
                                        <label class="col-sm-3">Mode:</label>                                    
                                        <div class="col-sm-6"><input type="text" id="mode" name="mode" class="form-control" value="Package" readonly /></div>                                    
                                        <div class="col-sm-3"><span style="color:red;"><?php echo form_error('mode');?></span></div>
                                    </div>   
                                                                 
                                    <div class="form-group">
                                        <label class="col-sm-3">Status:</label>                                    
                                        <div class="col-sm-6"><input type="text" id="status" name="status" class="form-control" value="success" readonly /></div>                                    
                                        <div class="col-sm-3"><span style="color:red;"><?php echo form_error('status');?></span></div>
                                    </div>                                
                                                                
                                    <div class="form-group">
                                        <label class="col-sm-3">Type:</label>                                    
                                        <div class="col-sm-6"><input type="text" id="type" name="type" class="form-control" value="Uniform" readonly /></div>                                    
                                        <div class="col-sm-3"><span style="color:red;"><?php echo form_error('type');?></span></div>
                                    </div>   

                                    <div class="form-group">
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
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
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    



<script>
    $(document).ready(function() {
        function validateEnrollmentNo() {
            var enrollmentNo = $('#enrollment_no').val();
            var enrollmentNoErrorContainer = $('#enrollment_no_error');

            if (!enrollmentNo.trim() || isNaN(enrollmentNo)) {
                enrollmentNoErrorContainer.text('Enrollment No should be a non-empty numeric value');
                return false; 
            }

            enrollmentNoErrorContainer.text('');
            return true; 
        }

        function getStudentDetails() {
            if (!validateEnrollmentNo()) {
             
                return;
            }

           
            var base = '<?=base_url()?>';
            var enrollmentNo = $('#enrollment_no').val();

            fetch(base + 'Online_uniform_fee/getStudentDetails', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'enrollment_no=' + encodeURIComponent(enrollmentNo),
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    $('#first_name').val(data.first_name);
                    $('#last_name').val(data.last_name);
                    $('#middle_name').val(data.middle_name);
                    $('#mobile').val(data.mobile);
                    $('#student_name').val(data.first_name + ' ' + data.middle_name + ' ' + data.last_name);
                    $('#academic_year').val(data.academic_year);
                    $('#student_id').val(data.student_id);
                    $('#institute_name').val(data.institute_name);
                    $('#adhar_card_no').val(data.adhar_card_no);
                    $('#email').val(data.email);
                }
            })
            .catch(error => console.error('Error:', error));
        }

       
        $('#enrollment_no').on('input', function() {
            validateEnrollmentNo();
        });

       
        $('#search_button').on('click', function() {
            getStudentDetails();
        });
    });
</script>
</body>
</html>


