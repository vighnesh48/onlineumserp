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
            fields: 
            {       
                cia_exam_month:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'cia_Exam month should not be empty'
                      }
                    }

                },
                cia_exam_year:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'cia_Exam Year should not be empty'
                      }
                    }

                },
                cia_exam_type:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'cia_Exam Type should not be empty'
                      }
                    }

                }
                
                
            }       
        })
    });
    $( function() {
        
    $( "#start_date" ).datepicker({format: 'yyyy-mm-dd'});
  } );
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Add CIA Exam Session</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add CIA Exam Session</h1>
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
                            <span class="panel-title">CIA Exam Session Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php //  if(in_array("Add", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/submit')?>" method="POST">     
                                <?php     
                                    if($this->session->flashdata('message')) {
                                     echo '<p style="color: red;text-align:center;">'.$this->session->flashdata('message').'</p>';   
                                     unset($_SESSION['message']);                    
                                    }
                                 ?>          

                                 <div class="form-group">
                                    <label class="col-sm-3">Academic Year<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <input type="text" name="academic_year" id="academic_year" value="<?php echo ACADEMIC_YEAR; ?>" class="form-control" readonly>
                                        <input type="text" name="ac_session" id="ac_session" value="<?php echo $ac_sessions->academic_session; ?>" class="form-control" readonly>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('cia_exam_year');?></span></div>
                                </div>        
                                <div class="form-group">
                                    <input type="hidden" name="cia_exam_id">
                                    <label class="col-sm-3">Subject Component<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                    <select id="subject_component" name="subject_component" class="form-control" required> 
                                         <option value="TH" <?php if($_REQUEST['subject_component']=="TH"){ ?> selected <?php } ?>>TH</option>
                                         <option value="PR" <?php if($_REQUEST['subject_component']=="PR"){ ?> selected <?php } ?>>PR</option> 
                                    </select>
                                    
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('cia_exam_name');?></span></div>
                                </div>                       
                                <div class="form-group">
                                    <input type="hidden" name="cia_exam_id">
                                    <label class="col-sm-3">CIA Name<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="cia_exam_name" name="cia_exam_name" class="form-control" required> 
                                             <option value="CIA1" <?php if($_REQUEST['cia_exam_name']=="CIA1"){ ?> selected <?php } ?>>CIA1</option>
                                             <option value="CIA2" <?php if($_REQUEST['cia_exam_name']=="CIA2"){ ?> selected <?php } ?>>CIA2</option> 
                                             <option value="CIA3" <?php if($_REQUEST['cia_exam_name']=="CIA3"){ ?> selected <?php } ?>>CIA3</option>
                                             <option value="CIA4" <?php if($_REQUEST['cia_exam_name']=="CIA4"){ ?> selected <?php } ?>>CIA4</option>
                                             <option value="CIA1 & CIA4" <?php if($_REQUEST['cia_exam_name'] == "CIA1 & CIA4"){ ?> selected <?php } ?>>CIA1 & CIA2</option> 
                                        </select>   
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('cia_exam_name');?></span></div>
                                </div> 
                                <div class="form-group">
                                    <input type="hidden" name="cia_exam_id">
                                    <label class="col-sm-3">CIA Type<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                    <select id="cia_exam_type" name="cia_exam_type" class="form-control" required> 
                                         <option value="viva" <?php if($_REQUEST['cia_exam_type']=="viva"){ ?> selected <?php } ?>>Viva-voce/ Quizzes /Assignments/Mini Project-Pr</option>
                                         <option value="lab_pr_works" <?php if($_REQUEST['cia_exam_type']=="lab_pr_works"){ ?> selected <?php } ?>> Based on continuous assessment of lab / practical works, considering regularity and timely submission of Lab Records</option>
                                         <option value="behavioural_attitude" <?php if($_REQUEST['cia_exam_type']=="behavioural_attitude"){ ?> selected <?php } ?>>Behavioural Attitude+ General Discipline</option>
                                         <option value="attendance" <?php if($_REQUEST['cia_exam_type']=="attendance"){ ?> selected <?php } ?>>Theory+ Practical Attendance</option>
                                    </select>
                                    
                                    </div>                                    
                                </div>
                                
                                <input type="hidden" name ="max_marks" id="maxMarks">


                                
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            <?php // } ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Function to update CIA exam names based on subject component
        function updateCIAExamNames() {
            var subjectComponent = $('#subject_component').val();
            var ciaExamNameSelect = $('#cia_exam_name');
    
            ciaExamNameSelect.empty(); // Clear previous options
            
            // Add options based on subject component
            if (subjectComponent === 'TH' || subjectComponent === 'EM') {
                ciaExamNameSelect.append($('<option>', {value: 'CIA1', text: 'CIA1'}));
                ciaExamNameSelect.append($('<option>', {value: 'CIA2', text: 'CIA2'}));
                ciaExamNameSelect.append($('<option>', {value: 'CIA3', text: 'CIA3'}));
                ciaExamNameSelect.append($('<option>', {value: 'CIA4', text: 'CIA4'}));
            } else if (subjectComponent === 'PR') {
                ciaExamNameSelect.append($('<option>', {value: 'CIA1 & CIA2', text: 'CIA1 & CIA2'}));
                ciaExamNameSelect.append($('<option>', {value: 'CIA3', text: 'CIA3'}));
                ciaExamNameSelect.append($('<option>', {value: 'CIA4', text: 'CIA4'}));
            }
        }
        
        // Update CIA exam names on page load
        updateCIAExamNames();
        
        // Update CIA exam names when subject component changes
        $('#subject_component').change(function() {
            updateCIAExamNames();
        });

        function updateCIATypes() {
            var ciaType = $('#cia_exam_type');
            var subjectComponent = $('#subject_component').val();
            var ciaExamNameSelect = $('#cia_exam_name').val();
            ciaType.empty(); // Clear previous options
            
            var inputField = $('#maxMarks');
            var ciaExamNameSelect = $('#cia_exam_name').val();

            if (subjectComponent === 'TH' || subjectComponent === 'EM') {
            if (ciaExamNameSelect === 'CIA1') {
                inputField.val(10);
            } else if (ciaExamNameSelect === 'CIA2') {
                inputField.val(50);
            } else if (ciaExamNameSelect === 'CIA3') {
                inputField.val(10);
            } else if (ciaExamNameSelect === 'CIA4') {
                inputField.val(5);
            } 
            }
            else  {

             if (ciaExamNameSelect === 'CIA1 & CIA2') {
                inputField.val(20);
            } else if (ciaExamNameSelect === 'CIA3') {
                inputField.val(20);
            } else if (ciaExamNameSelect === 'CIA4') {
                inputField.val(5);
            }

            }
        

            // Add options based on CIA type and subject component
            if (ciaExamNameSelect === 'CIA1') {
                if (subjectComponent === 'TH' || subjectComponent === 'EM') {
                    ciaType.append($('<option>', {value: 'CIA1', text: 'CIA1'}));
                } 
            } 
            else if (ciaExamNameSelect === 'CIA1 & CIA2') {
                if (subjectComponent === 'PR') {
                ciaType.append($('<option>', {value: 'lab_pr_works', text: 'Based on continuous assessment of lab / practical works, considering regularity and timely submission of Lab Records'}));
                }
            }
            else if (ciaExamNameSelect === 'CIA2') {
                if (subjectComponent === 'TH' || subjectComponent === 'EM' ) {
                    ciaType.append($('<option>', {value: 'CIA2', text: 'CIA2'}));
                }
            }
            else if (ciaExamNameSelect === 'CIA3') {
                if (subjectComponent === 'TH' || subjectComponent === 'EM' ) {
                ciaType.append($('<option>', {value: 'CIA3', text: 'CIA3'}));
                } else if (subjectComponent === 'PR') {
                    ciaType.append($('<option>', {value: 'viva', text: 'Viva-voce/ Quizzes /Assignments/Mini Project-Pr'}));
                }
            }
             else if (ciaExamNameSelect === 'CIA4') {
                // Add options for CIA4 based on subject component
                if (subjectComponent === 'TH' || subjectComponent === 'EM' || subjectComponent === 'PR') {
                    ciaType.append($('<option>', {value: 'behavioural_attitude', text: 'Behavioural Attitude+ General Discipline'}));
                    ciaType.append($('<option>', {value: 'attendance', text: 'Theory+ Practical Attendance'}));
                }
            }
        }
        
        // Update CIA  TYPES on page load
        updateCIATypes();
        
        // Update CIA exam names when CIA type or subject component changes
        $('#cia_exam_name, #subject_component').change(function() {
            updateCIATypes();
        });
    });
</script>