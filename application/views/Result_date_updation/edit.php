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
                exam_session:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Exam Session should not be empty'
                      }
                    }

                },
                school:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'School should not be empty'
                      }
                    }

                },
                start_date: {
                validators: {
                    notEmpty: {
                        message: 'Date should not be empty'
                    },
                    callback: {
                        message: 'Start date cannot be a back date and only accept valid date',
                        callback: function(value, validator, $field) {
                            var inputDate = new Date(value);
                            var today = new Date();
                            var year = inputDate.getFullYear();
                            if (inputDate < today) {
                                return false;
                            }

                            return year >= 2017 && year <= 2030;
                        }
                    }
                }
            }
        }
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
        <li class="active"><a href="<?= base_url('Result_date_updation') ?>"> Result publication dates</a></li>
    </ul>
    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Result publication dates</h1>
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
                            <span class="panel-title">Result publication dates Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php //  if(in_array("Add", $my_privileges)) { ?>
                                <form id="form" name="form" action="<?= base_url('Result_date_updation/updateResultDate') ?>" method="POST">     
                                    <input type="hidden" name="exam_id" value="<?= $exam_session->exam_id ?>">


                                    <div class="form-group">
                                    <label class="col-sm-3">Edit Exam Session<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select name="exam_session" id="exam_session" class="form-control" required>
                                            <option value="">Add Exam Session</option>
                                            <?php
                                            foreach ($exam_sessions as $exsession) {
                                                $exam_sess_val = $exsession['exam_month'] . '-' . $exsession['exam_year'] . '-' . $exsession['exam_id'];
                                                $selected = ($exsession['exam_month'] == $exam_session->exam_month) ? 'selected' : '';
                                                echo '<option value="' . $exam_sess_val . '" ' . $selected . '>' . $exsession['exam_month'] . '-' . $exsession['exam_year'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <span style="color:red;"><?php echo form_error('exam_session');?></span>
                                </div>

                                    <div class="form-group">
                                        <label class="col-sm-3">School<?=$astrik?></label> 
                                        <div class="col-sm-6">
                                            <select id="school" name="school" class="form-control" required="required">
                                                <option value="">Select School</option>
                                                <?php 
                                                if(!empty($school_details)){
                                                    foreach($school_details as $school){
                                                        $selected = ($school['school_id'] == $exam_session->school) ? 'selected' : '';
                                                        echo '<option value="'.$school['school_id'].'" '.$selected.'>'.$school['school_name'].'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span style="color:red;"><?php echo form_error('school');?></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3">Start Date<?=$astrik?></label> 
                                        <div class="col-sm-6">
                                            <input type="datetime-local" id="start_date" name="start_date" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($exam_session->start_date)) ?>" required/>
                                        </div>
                                        <div class="col-sm-3"><span style="color:red;"><?php echo form_error('start_date');?></span></div>
                                    </div>                              

                                    <div class="form-group">
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
                                        </div>                                    
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?= base_url($currentModule) ?>'">Cancel</button>
                                        </div>
                                        <div class="col-sm-4"></div>
                                    </div>
                                    <?php
                                    if($this->session->flashdata('message')) {
                                        echo '<p style="color: red;text-align:center;">'.$this->session->flashdata('message').'</p>';   
                                        unset($_SESSION['message']);                    
                                    }
                                    ?>
                                </form>

                            <?php // } ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>


