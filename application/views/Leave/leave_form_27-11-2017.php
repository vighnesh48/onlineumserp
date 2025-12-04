<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datetimepicker.min.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>


<script>    
     $(document).ready(function()
    {
        $('#form-forleave').bootstrapValidator
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
                no_days:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'No Of Days should not be empty'
                      }
                    }
                },
        leave_applied_from_date:
        {
              validators: 
                    {
                      notEmpty: 
                      {
                       message: 'From Date should not be empty'
                      }
                    }
      },
      medical_cert: {
            validators: {
        notEmpty: 
                      {
                       message: 'Please attach medical certificate.'
                      },
                file: {
                    extension: 'doc,docx,pdf,jpg,png,jpeg',
                    type: 'application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/jpeg,image/png,image/jpg',
                    message: 'Please choose a doc,docx,pdf,jpg,png file'
                }
            }
        }
            }       
        });
    $('#form-forod').bootstrapValidator
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
      applied_from_date:
        {
              validators: 
                    {
                      notEmpty: 
                      {
                       message: 'From Date should not be empty'
                      }
                    }
      }, 
       od_applied_to_date:
        {
              validators: 
                    {
                      notEmpty: 
                      {
                       message: 'To Date should not be empty'
                      }
                    }
      },  no_days_forod:
        {
              validators: 
                    {
                      notEmpty: 
                      {
                       message: 'No of days should not be empty'
                      }
                    }
      }, od_departure_time: {
              validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Departure time should not be empty'
                      }
                    }
      }, od_arrival_time: {
              validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Arrival time should not be empty'
                      }
                    }
      }, no_hrs_forod: {
              validators: 
                    {
                      notEmpty: 
                      {
                       message: 'No of Hrs should not be empty'
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
        <li class="active"><a href="#">Apply Leave/OD</a></li>
    </ul>
    <div class="page-header">     
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Application For Leave/OD</h1>
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
          
             <span id="flash-messages" style="color:red;padding-left:110px;"><?php if(!empty($this->session->flashdata('message1'))){ echo "<script>alert('".$this->session->flashdata('message1')."')</script>"; } ?></span><br>
                        <div class="table-info">
                           
                         <div id="dashboard-recent" class="panel-warning"> 
<div class="panel" id="type">
                              <div class="panel-heading"><strong>Select Type Of Application</strong></div>
                                <div class="panel-body">
                <div class="col-sm-6">
                
              <label ><input type="radio" value="leave" id="formtype_leave" checked name="formtype">Apply For Leave</label>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label><input type="radio"  value="od" id="formtype_od" name="formtype">Apply For OD</label>
              </div>        
          
          
</div>                
</div>
<div class="panel" id="leaveBal" style="">
                              <div class="panel-heading"><strong>Staff Leave Balance</strong></div>
                                <div class="panel-body">
                <div class="form-group">
                <table class="table table-bordered">
    <thead>
      <tr>
        <th>Leave Type</th>
        <th>Total Allocated</th>
        <th>Used leaves</th>
        <th>Balance</th>
      </tr>
    </thead>
    <tbody>     
    <?php 
    foreach($emp_leave_list as $val){
                    
    ?> <tr>
        <td><?=$val['leave_type']?></td>
        <td><?=$val['leaves_allocated']?></td>
        <td><?=$val['leave_used']?></td>
        <td><span id="<?=$val['leave_type']?>"><?=$val['leaves_allocated']-$val['leave_used']?></span></td>
    </tr>
    <?php } 
    ?>
    </tbody>
  </table>
              
              </div>        
          
          
</div>                
</div>                
                               <div class="panel" id="forleave">
                              <div class="panel-heading"><strong> Application For Leave</strong>
                                <?php $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));?>
  <span class="pull-right"><b>Current Date: <?=$date->format('d-m-Y H:i:s a')?>     </b>        
                         </span></div>
                              
                            
                                <div class="panel-body">
                
           <form id="form-forleave" name="form-forleave" action="<?=base_url($currentModule.'/add_leave')?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="emp_id" value="<?php echo $this->session->userdata('name');?>">
                <input type="hidden" name="in-leave" value="1">
                <input type="hidden" name="apply_leave_type" value="leave">
                <input class="form-control"  type="hidden" name="today_date" id="today_date" value="<?=$date->format('d-m-Y H:i:s a')?>">
                      
                                <div class="form-group">
                            <label class="col-md-3 control-label">Select Leave Type</label>
                            <div class="col-md-3">
                        <select id="leave_type" name="leave_type" onchange="display_duration(this.value);" class="form-control"  required>
                        <option value=""> Select Leave Type</option>
                        <?php foreach($emp_leave_list as $val){
                          echo "<option value='".$val['id']."'>".$val['leave_type']."</option>";
                        }
                          echo "<option value='lwp'>LWP</option>"; 
                        ?>
                      <!--  <option value='9'>LWP</option> -->
                        
                        <?php /* foreach($leave as $l){
                          echo "<option value=".$l['leave_id'].">".$l['ltype']."</option>";
                        } */
                        ?>
                        </select>
                        </div>
                        <label class="col-md-3 control-label">Select Leave Duration</label>
                        <div class="col-md-3" >
                        <select id="leave_duration" name="leave_duration"  class="form-control" required>
                        <option value=""> Select Duration</option>
                        <option value="full-day">Full-Day</option>
                        <option value="half-day">Half-Day</option>
                        </select>
                        </div>
                        
                      
                          </div>
<div class="form-group" id='sl_gatepass' >
             <div class="col-md-3"></div>
<label class="col-md-3" style="color:red;">Do You Want Gate Pass??</label>
<div class="col-md-3">
<label ><input type="radio" value="Y" id="gate_pass_yes"  name="gate_pass">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label ><input type="radio" value="N" id="gate_pass_no" checked name="gate_pass">No</label>
</div>
</div>              
              
                <div class="form-group">
                
                      <label class="col-md-3 control-label">Staff Name</label>
                  <div class="col-md-3">
                                    <input class="form-control" readonly type="text" name="ename" value="<?=$emp_detail[0]['fname'].' '.$emp_detail[0]['mname'].' '.$emp_detail[0]['lname']?>">               
                          </div>
                      <?php //print_R($school_list);?>
                                    <label class="col-md-3 control-label">Staff ID</label>
                  <div class="col-md-3">
                                    <input class="form-control" readonly  type="text" name="emp_id" value="<?=$emp_detail[0]['emp_id']?>">                
                          </div>                      
                      
                          </div>        
                                                          
                                        <div class="form-group">
                            <label class="col-md-3 control-label">Leave From Date</label>
                        <div class="col-md-3">                            
                            <input class="form-control" id="dob-datepicker" name="leave_applied_from_date" value="" onchange="checkLeaveDuration()" placeholder="Leave From Date" type="text" required>
                            </div>
                      <label class="col-md-3 control-label">Leave To Date</label>
                        <div class="col-md-3">                          
                              <input class="form-control" id="dob-datepicker1" name="leave_applied_to_date"  value="" placeholder="Leave To Date" type="text" >
                              <input class="form-control" id="dob-for-half-day" style="display:none" name="applied_to_date1"  value="" placeholder="Leave To Date" type="text">
                            </div>    
                          </div>
                                     <div class="form-group">
                   <label class="col-md-3 control-label">No Of Days.</label>
                   <div class="col-md-3">
                  <input class="form-control"  required type="text" readonly onclick="getTotalDays();" name="no_days" id="no_days" value="">
                  </div>
                   <label class="col-md-3 control-label">Designation</label>
                   <div class="col-md-3">
                  <input class="form-control" readonly type="text" name="designation" id="designation" value="<?=$emp_detail[0]['designation_name']?>">
                  </div>
                  </div>
                                    <div class="form-group">
                  <label class="col-md-3 control-label">Department</label>
                   <div class="col-md-3">
                  <input class="form-control" readonly type="text" name="department" id="department" value="<?=$emp_detail[0]['department_name']?>">
                  </div>
                  <label class="col-md-3 control-label">School</label>
                   <div class="col-md-3">
                  <input class="form-control" readonly type="text" name="school" id="school" value="<?=$emp_detail[0]['college_name']?>">
                  </div>
                                      </div>                   
                      <div class="form-group" id="certify" style="display:none;">
                            <label class="col-md-3 control-label">Upload Medical Certificate</label>
                            <div class="col-md-9">                        
                           <input name="medical_cert" type="file">
                        </div>
                          </div>
                      <div class="form-group">
                            <label class="col-md-3 control-label">Reason For Leave</label>
                            <div class="col-md-9">
                        <textarea  class="form-control"  style="resize:none;overflow-y:scroll;height:50px" required name="reason" placeholder="Reason For Leave" ></textarea>
                        </div>
                          </div>
                 <div class="form-group">
                    <label class="col-md-3"><u>Details of Alternative Arrangement</u></label>
               <!-- <label class="col-md-9" style="color:red;">Note:Select Department Only if you want alternate arrangement from other Department</label>   -->     
                   </div> 
                             <div class="form-group">
                <label class="col-md-3 control-label">Select School</label>
                   <div class="col-md-3">
                  <select class="form-control" name="reporting_school"  id="reporting_school" onchange="getdept_using_school(this.value)">
                  <option value=" "> Select School</option>
                  <?php foreach($school_list as $sc ){
                        
                        echo "<option value=".$sc['college_id'].">".$sc['college_name']."</option>"?>
                      <?php } ?>
                  </select>
                  </div>
               <label class="col-md-3 control-label">Select Department</label>
                   <div class="col-md-3">
                  <select name="reporting_dept" id="reporting_dept"  onchange="getEmp_using_deptforLeave(this.value)" class="form-control" >
                        <option value=" ">Select Department</option>
                        
                        </select>
                  </div>    
                             </div>
                               <div class="form-group">
                 
                 <div  style="margin-left:10px;">
  <table id="emp-table" class="table table-bordered table-striped">
        
  </table>

  <script>
//$('emp-table').tableCheckbox({ /* options */ });
</script> 
</div>
                 
                                         
              </div>  
 <div class="form-group">
  <label class="col-md-3 control-label">Contact Details During Leave Period</label>
  <div class="col-md-3">
  <textarea name="leave_contct_address" class="form-control" id="leave_contct_address" ><?=$emp_detail[0]['lflatno'].','.$emp_detail[0]['larea_name'].','.$emp_detail[0]['larea_name'].','.$emp_detail[0]['ltaluka'].','.$emp_detail[0]['ldist'].' - '.$emp_detail[0]['lpincode']?></textarea>
  </div>
  <label class="col-md-3 control-label">Mobile No.</label>
<div class="col-md-3">  
  <input type="text" name="leave_contct_no" id="leave_contct_no" value="<?=$emp_detail[0]['mobileNumber'];?>" class="form-control" placeholder="Mobile No">
</div> 
</div> 
                                    <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit  </button>                                      
                                    </div> 
                                    </div>                        
                      </div>
                 </form>              
                                </div>
                <!--Form For the Od-->                
                <div class="panel" style="display:none;" id="forod">
                
                
                <div class="panel" id="leaveBal" style="">
                              <div class="panel-heading"><strong>Staff OD Balance</strong></div>
                                <div class="panel-body">
                <div class="form-group">
                <table class="table table-bordered">
    <thead>
      <tr>
        <th>Leave Type</th>        
        <th>Total </th>       
      </tr>
    </thead>
    <tbody>     
   <tr>
       <td>OD</td>
        <td><?php 
    $ci =&get_instance();
     $ci->load->model('leave_model');
        $uid = $this->session->userdata("name");
        $cnt = $ci->leave_model->get_emp_od_cnt($uid);
        //print_r($cnt);
       
            echo $cnt;
        
        ?></td>
          </tr>
    
    </tbody>
  </table>
              
              </div>        
          
          
</div>                
</div>    
            
 <div class="panel-heading"><strong> Application For OD</strong><?php $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));?>
  <span class="pull-right"><b>Current Date: <?=$date->format('d-m-Y H:i:s a')?></b>       
                         </span></div>
                                <div class="panel-body">
                <form  id="form-forod"  name="form-forod" action="<?=base_url($currentModule.'/add_leave')?>" method="POST" >
<input type="hidden" name="emp_id" value="<?php echo $this->session->userdata('name');?>">
<input type="hidden" name="in-od" value="1">
<input type="hidden" name="apply_leave_type" value="OD">
                
                                        
             <input class="form-control"  type="hidden" name="today_date" id="today_date" value="<?=$date->format('d-m-Y H:i:s a')?>">
                      
                 <div class="form-group">
                            <label class="col-md-3 control-label">Select OD Type</label>
                            <div class="col-md-3">
                        <select id="od_type" name="od_type" class="form-control" required>
                        <option value=""> Select OD Type</option>
                        <option value="official" selected >Official</option>
                        </select>
                        </div>
                        <label class="col-md-3 control-label">Select OD Duration</label>
                        <div class="col-md-3" >
                        <select id="od_duration" name="od_duration"  onchange="checkdh_div(this.value)"  class="form-control" required>
                        <option value=""> Select Duration</option>
                        <option value="hrs">Hrs</option>
                        <option value="full-day">Full-Day</option>
                        <!--<option value="half-day">Half-Day</option>-->
                        </select>
                        </div>
                        
                      
                          </div>
                      
             <div class="form-group">
             <div class="col-md-3"></div>
<label class="col-md-3" style="color:red;">Do You Want Gate Pass??</label>
<div class="col-md-3">
<label ><input type="radio" value="Y" id="gate_pass_yes" checked name="gate_pass">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label ><input type="radio" value="N" id="gate_pass_no"  name="gate_pass">No</label>
</div>
</div>
             <div class="form-group">
                
                      <label class="col-md-3 control-label">Staff Name</label>
                  <div class="col-md-3">
                                    <input class="form-control" readonly type="text" name="ename" value="<?=$emp_detail[0]['fname'].' '.$emp_detail[0]['mname'].' '.$emp_detail[0]['lname']?>">               
                          </div>
                      <?php //print_R($school_list);?>
                                    <label class="col-md-3 control-label">Staff ID</label>
                  <div class="col-md-3">
                                    <input class="form-control" readonly  type="text" name="emp_id" value="<?=$emp_detail[0]['emp_id']?>">                
                          </div>                      
                      
                          </div>
                      
<div class="form-group">
<label class="col-md-3 control-label">Designation</label>
                   <div class="col-md-3">
                  <input class="form-control" readonly type="text" name="designation" id="designation" value="<?=$emp_detail[0]['designation_name']?>">
                  </div>
                  <label class="col-md-3 control-label">Department</label>
                   <div class="col-md-3">
                  <input class="form-control" readonly type="text" name="department" id="department" value="<?=$emp_detail[0]['department_name']?>">
                  </div>
                  
</div>
<div class="form-group">
<label class="col-md-3 control-label">School</label>
                   <div class="col-md-3">
                  <input class="form-control" readonly type="text" name="school" id="school" value="<?=$emp_detail[0]['college_name']?>">
                  </div>
                  </div>
              <div class="form-group"  >
                            <label class="col-md-3 control-label">OD From Date</label>
                        <div class="col-md-3">                            
                            <input class="form-control" required id="dob-datepicker2" name="applied_from_date" value="" onchange="checkOD_Duration()" placeholder="OD From Date" type="text" >
                            </div>
                      <label class="col-md-3 control-label" id="od-for-day">OD To Date</label>
                        <div class="col-md-3" id="od-for-day1">                            
                              <input class="form-control" id="dob-datepicker3" name="od_applied_to_date" value="" placeholder="OD To Date" type="text" >
                           <input class="form-control" id="od-for-half-day" style="display:none" name="applied_to_date2"  value="" placeholder="OD To Date" type="text" > 
                        </div>    
                          </div>
<div class="form-group" id="od-for-hrs" style="display:none">
                            <label class="col-md-3 control-label">Departure Time</label>
                        <div class="col-md-3">                          
                            <input class="form-control" id="timepicker1" name="od_departure_time" value="" placeholder="HH:MM" type="text" >
                            </div>
                      <label class="col-md-3 control-label">Arrival Time</label>
                        <div class="col-md-3">                            
                              <input class="form-control" id="timepicker2" name="od_arrival_time" value="" placeholder="HH:MM" type="text" >
                            </div>    
                          </div>                      
                                    <div class="form-group">
                  <div id="no_d" style="display:none">
                   <label class="col-md-3 control-label">No Of Days.</label>
                   <div class="col-md-3">
                  <input class="form-control" type="text" readonly onclick="getTotalDays1();" name="no_days_forod" id="no_days_forod" value="">
                  </div>                      
                  </div>
                                    <div id="no_hr" style="display:none">
                   <label class="col-md-3 control-label">No Of Hrs.</label>
                   <div class="col-md-3">
                  <input class="form-control"   type="text" readonly onclick="getTotalhrs();" name="no_hrs_forod" id="no_hrs_forod" value="">
                  </div>                      
                  </div>                  
                  </div>
<div class="form-group">
                            <label class="col-md-3 control-label">Purpose For OD</label>
                            <div class="col-md-9">
                        <textarea  class="form-control"  style="resize:none;overflow-y:scroll;height:50px" required name="reason_od" placeholder="Purpose For OD" ></textarea>
                        </div>
                          </div>    
 <div class="form-group">
                    <label class="col-md-3"><u>Details of Alternative Arrangement</u></label>
               <!-- <label class="col-md-9" style="color:red;">Note:Select Department Only if you want alternate arrangement from other Department</label>  -->      
                   </div> 
                             <div class="form-group">
                <label class="col-md-3 control-label">Select School</label>
                   <div class="col-md-3">
                  <select class="form-control" name="reporting_school_od" id="reporting_school_od" onchange="getdept_using_school_forod(this.value)">
                  <option value=" "> Select School</option>
                  <?php foreach($school_list as $sc ){
                        
                        echo "<option value=".$sc['college_id'].">".$sc['college_name']."</option>"?>
                      <?php } ?>
                  </select>
                  </div>
               <label class="col-md-3 control-label">Select Department</label>
                   <div class="col-md-3">
  <select name="reporting_dept_od" id="reporting_dept_od" onchange="getEmp_using_deptforod(this.value)" class="form-control" >
                        <option value="">Select Depart</option>
                        <?php 
                                                  ?>
                        </select>
                  </div>    
                             </div>
                               <div class="form-group">
                 
                 <div  style="margin-left:10px;">
  <table id="emp-table-od" class="table table-bordered table-striped">
        
  </table>

  <script>
//$('emp-table').tableCheckbox({ /* options */ });
</script> 
</div>
                 
                                         
              </div>  
               <div class="form-group">
                <label class="col-md-3 control-label">Location Of Duty</label>
                 <div class="col-md-3">
                 <input type="text" name="location_od" id="location_od" class="form-control" placeholder="OD Address" required>
               </div>
                <label class="col-md-3 control-label">Mobile No.</label>
<div class="col-md-3">  
  <input type="text" name="od_contct_no" id="od_contct_no" value="<?=$emp_detail[0]['mobileNumber'];?>" class="form-control" placeholder="Mobile No." required>
</div>
               </div>
               <div class="form-group">
  <label class="col-md-3 control-label">State</label>
   <div class="col-md-3">
   <select id="state" name="state" onchange="getcitybystatesod(this.value)" class="form-control" required>
                  <option value="">Select</option>
                  <?php foreach($state as $key=>$val){?>
                  <option value="<?php echo $state[$key]['state_id'];?>"><?php echo $state[$key]['state_name'];?></option>
                  <?php } ?>
                  </select>
   </div>
  
<label class="col-md-3 control-label">City</label>
   <div class="col-md-3">
  <select id="city" name="city" class="form-control" required>
  <option value="">Select City</option>
  </select>
   </div>
    <span class="pull-right" style="color:red;">(Note:If any city is not listed ,then Please contact to admin Dept.)</span>
</div> 
<!--<div class="form-group">
<label class="col-md-6" style="color:red;">Note:Do You Have Any Faculty who Will Be With You For OD??</label>
<div class="col-md-3">
<label ><input type="radio" value="Y" id="facilty_with_yes" name="facilty_with">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label ><input type="radio" value="N" id="facilty_with_no" name="facilty_with">No</label>
</div>
</div>-->
<!--<div class="form-group">
<label class="col-md-3" >Forward To Application To</label>
<div class="col-md-3"><select name="od_to" class="form-control"><option value="ro">RO</option></select></div>
</div>-->
                      
<div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Send  </button>                                      
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
</div>
<script type="text/javascript">

function display_duration(dr){
  var lty1 = $('#leave_type option:selected').text();
  //alert(lty1);
  if(lty1=='ML' || lty1=='EL' || lty1=='VL' || lty1=='C-OFF'){
  $('#leave_duration').find('option[value="half-day"]').hide();
  if(lty1=='ML'){
  $('#certify').show();
  }
  }else{
  $('#leave_duration').find('option[value="half-day"]').show();
    $('#certify').hide();
  }
}
function get_unchecked_box(eid,lt){
             
        if(lt=='OD'){
            var fd = $("#dob-datepicker2").val();
            var lt = $("#od_duration").val();
            if (lt == 'hrs') {
                var td = $("#dob-datepicker2").val();                
            } else {
                var td = $("#dob-datepicker3").val();               
            }
         }else{
       var fd = $("#dob-datepicker").val();
            var lt = $("#leave_duration").val();
            if (lt == 'half-day') {
                var td = $("#dob-datepicker").val();
            } else {
                var td = $("#dob-datepicker1").val();
            }
         }
     
  if((fd !='' || fd != null) || (td !='' || td != null)){
          date1 = fd.split('-');
                    date2 = td.split('-');
           var start = new Date(date1[2]+"-"+date1[1]+"-"+date1[0]),
           end = new Date(date2[2]+"-"+date2[1]+"-"+date2[0]),
        year = start.getFullYear(),
    month = start.getMonth(),
    day = start.getDate(),
    dates = [start];
          
      while(dates[dates.length-1] < end) {          
  dates.push(new Date(year, month, ++day));  
}
//alert(dates); 
  if(dates.length > 1){
        var dcnt = parseInt(dates.length)-1;
      }else{
        var dcnt = parseInt(dates.length);
      }
    //alert(fd);
   // alert(td);
    if(fd==td){
      $("#fromdt"+eid).find('option').remove().end();
      $("#todt"+eid).find('option').remove().end();
    }else{
      $("#fromdt"+eid).find('option').remove().end().append($('<option>', {value:'', text:'Select'}));
      $("#todt"+eid).find('option').remove().end().append($('<option>', {value:'', text:'Select'}));
      }
      for (j = 0; j < dcnt; j++) {  
      var d1 = new Date(dates[j]);      
      var mm1 = d1.getMonth();
        var mm = parseInt(mm1) + 1;
      if(mm < '10'){
        var mm = "0"+mm;
      }else{
        var mm = mm;
      }
      var dd1 = d1.getDate();
      var dd = parseInt(dd1);
      if(dd < '10'){
        dd = "0"+dd;
      }else{
        dd = dd;
      }
    
      var str = dd+"-"+mm+"-"+d1.getFullYear();


   $("#fromdt"+eid).append($('<option>', {value:str, text:str})); 
  
$("#todt"+eid).append($('<option>', {value:str, text:str}));
$('#todt'+eid+' option[value=""]').prop('selected', true);

  } 
  } 
  
}
function get_checked_box(eid,fd,td){
   if(fd==td){
     $("#fromdtdt"+eid).append($('<option>', {value:str, text:str}));
     $("#todt"+eid).append($('<option>', {value:fd, text:fd}));
   }else{
              var favorite = [];        
       $.each($("input[name='ch[]']:checked"), function(){       
       favorite.push($(this).val());
       });
     // alert(favorite);
  for (i = 0; i <= favorite.length; i++) {     
          var frdat = $("#fromdt"+favorite[i]+" :selected").val();
          var todat = $("#todt"+favorite[i]+" :selected").val();
       // alert(frdat);
          if((frdat !='' || frdat != null) || (todat !='' || todat != null)){
          date1 = frdat.split('-');
                    date2 = todat.split('-');
        
            var start = new Date(date1[2]+"-"+date1[1]+"-"+date1[0]),
           end = new Date(date2[2]+"-"+date2[1]+"-"+date2[0]),
        year = start.getFullYear(),
    month = start.getMonth(),
    day = start.getDate(),
    dates = [start];          
          //alert(end);          
        while(dates[dates.length-1] < end) {          
  dates.push(new Date(year, month, ++day));  
}
      if(dates.length > 1){
        var dcnt = parseInt(dates.length)-1;
      }else{
        var dcnt = parseInt(dates.length);
      }
      for (j = 0; j < dcnt; j++) {  
      var d1 = new Date(dates[j]);
      //alert(i);
      //alert(d1.getFullYear());
      var mm1 = d1.getMonth();
        var mm = parseInt(mm1) + 1;
      if(mm < '10'){
        var mm = "0"+mm;
      }else{
        var mm = mm;
      }
      var dd1 = d1.getDate();
      var dd = parseInt(dd1);
      if(dd < '10'){
        dd = "0"+dd;
      }else{
        dd = dd;
      }
    
      var str = dd+"-"+mm+"-"+d1.getFullYear();
      //alert(str);      
      $("#todt"+eid+" option[value='"+str+"']").remove();
        $("#fromdt"+eid+" option[value='"+str+"']").remove();      
      }      
    }
        
}
   }         
}
function onCheck(eid){
  //alert(dd);
  $('#btn_submit').attr('disabled',false);
  var nd = $('#no_days').val();
  var total=$('input[name="ch[]"]:checked').length;
  var arr = $('input[name="no_of_alter_days[]"]');
 // alert(arr);
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    //alert(tot);
  var nd1;
  if(nd == '0.5'){
   nd1 = '1';
  }else{
     nd1 = nd;
  }
  //alert(total);
  //alert(nd1);
  if(tot < nd1){
  if(total <= nd1 ){
  
  var fd= $("#dob-datepicker").val();
  var lt = $("#leave_duration").val();
  if(lt=='half-day'){
    var td= $("#dob-datepicker").val();
  }else{
var td= $("#dob-datepicker1").val();
  }
  $('#fromdt'+eid).prop("disabled", false);
  //$('#fromdt'+eid).val(fd);
  $('#todt'+eid).prop("disabled", false);
  //$('#todt'+eid).val(td);
  $('#no_of_alter_days'+eid).prop("disabled", false);
  $('#no_of_alter_days'+eid).val(nd);
  get_checked_box(eid,fd,td);
  
  
  }else{
    $('#'+eid).attr('checked', false); 
  }
}else{
    $('#'+eid).attr('checked', false); 
  }
}
function onUnCheck(eid){
  get_unchecked_box(eid,'LE');
  
 $('#no_of_alter_days' + eid).val('');  
    //$('#fromdt'+eid).find('option:selected').val(''); 
  $('#fromdt' + eid).prop("disabled", true);
    $('#todt' + eid).prop("disabled", true);
    $('#no_of_alter_days' + eid).prop("disabled", true);
  
}

function onCheckod(eid){
	 $('#btn_submit1').attr('disabled',false);
  //alert(dd);
  var total1=$('input[name="ch[]"]:checked').length;
  //alert(total);
  var nd = $('#no_hrs_forod').val();
  var lt = $("#od_duration").val();
  var arr = $('input[name="no_of_alter_od_days[]"]');
  //alert(arr);
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
  var nd2;
  if(lt == 'hrs'){
   nd2 = '1';
  }else{
    var nd = $('#no_days_forod').val();
     nd2 = nd;
  }
  //alert(tot);
  //alert(nd2);
  if(tot < nd2){
  if(total1 <= nd2){
  var fd= $("#dob-datepicker2").val();
  var lt = $("#od_duration").val();
  if(lt=='hrs'){
    var td= $("#dob-datepicker2").val();
    var nd = $('#no_hrs_forod').val();
  }else{
var td= $("#dob-datepicker3").val();
var nd = $('#no_days_forod').val();
  }
  $('#fromdt'+eid).prop("disabled", false);
  //$('#fromdt'+eid).val(fd);
  $('#todt'+eid).prop("disabled", false);
  //$('#todt'+eid).val(td);
  $('#no_of_alter_od_days'+eid).prop("disabled", false);
 // alert(nd);
$('#no_of_alter_od_days'+eid).val(nd);
if(fd == td){
    
  }else{  
get_checked_box(eid,fd,td);
  }
}else{
    
    $('#'+eid).attr('checked', false); 
  }
  
  }else{
    
    $('#'+eid).attr('checked', false); 
  }
//$('#fromdt'+eid).val('<option>'fd);
}
function onUnCheckod(eid){
  
  get_unchecked_box(eid,'OD');
  //$('#fromdt'+eid).val('');
  //$('#todt'+eid).val('');
  $('#no_of_alter_od_days'+eid).val('');
  $('#fromdt'+eid).prop("disabled", true);  
  $('#todt'+eid).prop("disabled", true);
  $('#no_of_alter_od_days'+eid).prop("disabled", true);
  
}
$(document).ready(function(){
    var i=1;
  $( "#form-forleave" ).submit(function( event ) {
 
   $('#form-forleave').bootstrapValidator('revalidateField', 'medical_cert');
   
   var altern = [];        
       $.each($("input[name='ch[]']:checked"), function(){       
       altern.push($(this).val());
       });
	   //alert(altern.length);
	   if(altern.length < 1){
	   	 if(i=='1'){
		   alert('Select Alternative Arrangement.');
		}
		i=i+1;
		   //$('#form-forleave').bootstrapValidator('revalidateField', 'ch[]');
	  return false;
	  }else{
		  // alert('ff1');
		   return true;
	   }   
});
$( "#form-forod" ).submit(function( event ) {
  
   var altern = [];        
       $.each($("input[name='ch[]']:checked"), function(){       
       altern.push($(this).val());
       });
	   //alert(altern.length);
	   if(altern.length < 1){
		   if(i=='1'){
		   alert('Select Alternative Arrangement.');
		}
		i=i+1;
		   //$('#form-forleave').bootstrapValidator('revalidateField', 'ch[]');
	  return false;
	  }else{
		  // alert('ff1');
		   return true;
	   }   
});
  $("input[name='formtype']").click(function () {
  
            if ($("#formtype_leave").is(":checked")) {
        $("#forleave").show();
        $("#leaveBal").show();
                $("#forod").hide();
            } else if($("#formtype_od").is(":checked")){
               $("#forod").show();
                $("#forleave").hide();
        $("#leaveBal").hide();
            }
        });
    
      
  
  $("#state").select2({
        placeholder: "Select State",
        allowClear: true
    });
  $("#city").select2({
        placeholder: "Select City",
        allowClear: true
    });
  $("#leave_type").select2({
        placeholder: "Select Leave Type",
        allowClear: true
    });
  $("#reporting_school").select2({
        placeholder: "Select School",
        allowClear: true
    });
  $("#reporting_dept").select2({
        placeholder: "Select Department",
        allowClear: true
    });
   //$('#today_date').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
  /*$('#dob-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
   */
   //for leave form datepicker
       $("#dob-datepicker").datepicker({
        todayBtn:  1,
        autoclose: true,
    format: 'dd-mm-yyyy'
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
    $('#dob-datepicker1').datepicker('setStartDate', minDate);
    //getTotalDays();
    $('#form-forleave').bootstrapValidator('revalidateField', 'leave_applied_from_date');
    $('#form-forleave').bootstrapValidator('revalidateField', 'no_days');
    });
    
    $("#dob-datepicker1").datepicker({        
        autoclose: true,
    format: 'dd-mm-yyyy'     
    }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#dob-datepicker').datepicker('setEndDate', minDate);
            getTotalDays();
  });
  //for od form date picker
  $("#dob-datepicker2").datepicker({
        todayBtn:  1,
        autoclose: true,
    format: 'dd-mm-yyyy'
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
    $('#dob-datepicker3').datepicker('setStartDate', minDate);
  
  getTotalDays1();
    });
    
    $("#dob-datepicker3").datepicker({
        autoclose: true,
    format: 'dd-mm-yyyy'
    }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#dob-datepicker2').datepicker('setEndDate', minDate);
      $('#form-forod').bootstrapValidator('revalidateField', 'od_applied_to_date');
             getTotalDays1();
  });
  //for od hrs time picker
  $('#timepicker1').datetimepicker({ format:'HH:mm'}).on("dp.change", function (e) {
           getTotalhrs();
        });
  $('#timepicker2').datetimepicker({ format:'HH:mm'}).on("dp.change", function (e) {
           getTotalhrs();
        });
 
  
  
  
  // $('#datetimepicker1').datetimepicker();

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
/* function changevisible(val){
  if(val=='half-day'){
  $("#dob-datepicker1").hide(); 
  $("#dob-for-half-day").show();    
  }else if(val=='full-day'){
  $("#dob-datepicker1").show(); 
  $("#dob-for-half-day").hide();    
  }
} */


//date check for leave duration function
function checkLeaveDuration(){
  var lty = $('#leave_type option:selected').text();

  
  if($('#leave_duration').val()=='half-day'){
    
  var d1=$("#dob-datepicker").val();  
  $("#dob-datepicker1").hide();
  $("#dob-datepicker1").val('');
  $("#dob-for-half-day").show();  
  $("#dob-for-half-day").val(d1); 
  $("#dob-for-half-day").attr('readonly', 'true');
  $("#no_days").val(0.5);
  }else if($('#leave_duration').val()=='full-day'){
    $("#no_days").val('');    
  $("#dob-datepicker1").show(); 
  $("#dob-for-half-day").hide();
    $("#dob-for-half-day").val(''); 
  }
  var to_date = $("#dob-datepicker1").val();
  //alert(to_date);
  if(to_date !=""){
   // alert("inside");
  getTotalDays();
  $('#form-forleave').bootstrapValidator('revalidateField', 'no_days');
  }
}
//date check for od duration function
function checkOD_Duration(){
  if($('#od_duration').val()=='half-day'){
  var d1=$("#dob-datepicker2").val(); 
  $("#dob-datepicker3").hide();
    $("#dob-datepicker3").val('');  
  $("#od-for-half-day").show(); 
  $("#od-for-half-day").val(d1);  
  $("#od-for-half-day").attr('readonly', 'true');
  $("#no_days_forod").attr('required', 'true');
  $("#no_days_forod").val(0.5);
//  
  //clear timepicker values
   $('#timepicker1').val(' ');
   $('#timepicker2').val(' ');
  }else if($('#od_duration').val()=='full-day'){
    $("#no_days_forod").val('');
  $("#dob-datepicker3").show(); 
  $("#dob-datepicker3").attr('required', 'true'); 
  $("#od-for-half-day").hide();
$("#no_days_forod").attr('required', 'true'); 
  //clear timepicker values
   $('#timepicker1').val(' ');
   $('#timepicker2').val(' ');
  }
}


//for leave form
function getTotalDays(){
  //alert('ff');
  if($('#leave_duration').val()==''){
    alert('Please select Duration for Leave');
  }
  var lty = $('#leave_type option:selected').text();
  var spid = $('#'+lty).text();
  //alert(lty);
  //leave duration
   if($('#leave_duration').val()=='half-day' && lty == 'EL'){
  alert('EL is not applicable for half-day.');
}else{
  
  if($('#leave_duration').val()=='half-day'){
    $("#no_days").val(0.5);
    $("#no_days").attr('readonly',true);  
  }else if($('#leave_duration').val()=='full-day'){
  var date1=$("#dob-datepicker").val();
  var date2=$("#dob-datepicker1").val();
  
  var firstValue = date1.split('-');
var secondValue = date2.split('-');

 var firstDate=new Date();
 firstDate.setFullYear(firstValue[2],(firstValue[1] - 1 ),firstValue[0]);

 var secondDate=new Date();
 secondDate.setFullYear(secondValue[2],(secondValue[1] - 1 ),secondValue[0]);     
  if (firstDate > secondDate)
  {
    alert("From date should not be greater than To date");
  //document.getElementById('dob-datepicker').value =" "; 
  //document.getElementById('dob-datepicker1').value=" ";    
  $("#dob-datepicker1").val(''); 
  document.getElementById('no_days').value=" "; 
    date1=date2=""; 
  }
    var start = new Date(firstValue[2]+"-"+firstValue[1]+"-"+firstValue[0]),
           end = new Date(secondValue[2]+"-"+secondValue[1]+"-"+secondValue[0]),
        year = start.getFullYear(),
    month = start.getMonth(),
    day = start.getDate(),
    dates = [start];
          //alert(start); 
          //alert(end);
        while(dates[dates.length-1] < end) {
          
  dates.push(new Date(year, month, ++day));
  
}
      if(dates.length > 1){
        var timeDifferenceInDays = parseInt(dates.length)-1;
      }else{  
      var timeDifferenceInDays = dates.length;
      }

//alert(timeDifferenceInDays);
if(lty == 'EL' && timeDifferenceInDays < 4 ){
    alert('Minimum 4 leaves are allow for EL.');
}else{
  if(lty!='LWP'){
if(timeDifferenceInDays>0 && timeDifferenceInDays <= spid){
$("#no_days").val(timeDifferenceInDays);  
$("#no_days").attr('readonly',true);  
}else{
    alert('You have exceeded your allocated leaves.');
    $("#dob-datepicker1").val('');
    document.getElementById('no_days').value=" ";
} 
  }else{
    if(timeDifferenceInDays>0){
     //alert(timeDifferenceInDays);
  $("#no_days").val(timeDifferenceInDays);  
  $("#no_days").attr('readonly',true);  
  }
  }
  }
  }
   
} 
 $('#form-forleave').bootstrapValidator('revalidateField', 'no_days');
}
//for od form 
function checkdh_div(val){
  if(val=='hrs'){
    $('#od-for-hrs').show();
    $('#no_hr').show();
    $("#no_hrs_forod").attr('required',true);
    $('#od-for-day').hide();
  $('#od-for-day1').hide();
    $('#no_d').hide();
    
    
  }else if(val=='full-day'){
    $('#od-for-day').show();
    $("#dob-datepicker2").attr('required',true);
    $('#no_d').show();
    $('#od-for-hrs').hide();
  $('#od-for-day1').show();
    $('#no_hr').hide();
    $("#no_hrs_forod").removeAttr('required',true);
  }else if(val=='half-day'){
    $('#od-for-day').show();
    $("#dob-datepicker2").attr('required',true);
    $('#no_d').show();
    $('#od-for-hrs').hide();
    $('#no_hr').hide();
    $("#no_hrs_forod").removeAttr('required',true);
  }
  
}


function calculateTime() {  
                       
        var valuestart1 = $('#timepicker1').val();// "8:45am";
        var valuestop1 = $('#timepicker2').val();//"8:46pm";    
  //  alert(valuestart1);
 // alert(valuestop1);
  if(valuestart1 != '' && valuestop1 !=''){
         var valuestart = moment(valuestart1, "HH:mm");
    var valuestop = moment(valuestop1, "HH:mm");   
    
        var hourStart = new Date(valuestart).getHours();
        var hourEnd = new Date(valuestop).getHours();

        var minuteStart = new Date(valuestart).getMinutes();
        var minuteEnd = new Date(valuestop).getMinutes();

        var hourDiff = hourEnd - hourStart;
        var minuteDiff = minuteEnd - minuteStart;
    
        if (minuteDiff < 0) {
            hourDiff = hourDiff - 1;
      minuteDiff=60-(-(minuteDiff));
        }
    // alert(hourDiff);
    //alert(minuteDiff); 

    if(hourDiff >= 0){
   var rn=hourDiff+'.'+minuteDiff;
 }else{
  alert('Arrival Time must be greater then Departure Time');
   var rn='';
 }
}else{
  var rn ='';
}
        return  rn;    
    }
    function getTotalhrs(){   
  //alert('gg');
    var tdiff=calculateTime();
    //alert(tdiff);
    $('#no_hrs_forod').val(tdiff);
    $('#form-forod').bootstrapValidator('revalidateField', 'od_departure_time');
    $('#form-forod').bootstrapValidator('revalidateField', 'od_arrival_time');
    $('#form-forod').bootstrapValidator('revalidateField', 'no_hrs_forod');
  }


function getTotalDays1(){
  
  var date1=$("#dob-datepicker2").val();
  var date2=$("#dob-datepicker3").val();
  var firstValue = date1.split('-');
var secondValue = date2.split('-');

 var firstDate=new Date();
 firstDate.setFullYear(firstValue[2],(firstValue[1] - 1 ),firstValue[0]);

 var secondDate=new Date();
 secondDate.setFullYear(secondValue[2],(secondValue[1] - 1 ),secondValue[0]);     
  if (firstDate > secondDate)
  {
 
    alert("From date should not be greater than To date");
   // $("#dob-datepicker2").val('');
    $("#dob-datepicker3").val('');
  //document.getElementById('dob-datepicker2').value =" "; 
  //document.getElementById('dob-datepicker3').value=" ";     
  document.getElementById('no_days_forod').value=" "; 
    date1=date2=""; 
  }
    var start = new Date(firstValue[2]+"-"+firstValue[1]+"-"+firstValue[0]),
           end = new Date(secondValue[2]+"-"+secondValue[1]+"-"+secondValue[0]),
        year = start.getFullYear(),
    month = start.getMonth(),
    day = start.getDate(),
    dates = [start];
          //alert(start); 
          //alert(end);
        while(dates[dates.length-1] < end) {
          
  dates.push(new Date(year, month, ++day));
  
}
      if(dates.length > 1){
        var timeDifferenceInDays = parseInt(dates.length)-1;
      }else{  
      var timeDifferenceInDays = dates.length;
      }
  
//alert(timeDifferenceInDays);
if(timeDifferenceInDays>0){
$("#no_days_forod").val(timeDifferenceInDays);  
$("#no_days_forod").attr('readonly',true);

}
 $('#form-forod').bootstrapValidator('revalidateField', 'applied_from_date');
 $('#form-forod').bootstrapValidator('revalidateField', 'no_days_forod');
  $('#form-forod').bootstrapValidator('revalidateField', 'od_departure_time');
}

function getalterdiff(id){
  //alert(id);
  id1='#fromdt'+id;
  id2='#todt'+id;
  
  var date1=$('#fromdt' +id).val();
  var date2=$('#todt' +id).val();
 var firstValue = date1.split('-');
var secondValue = date2.split('-');

 var firstDate=new Date();
 firstDate.setFullYear(firstValue[2],(firstValue[1] - 1 ),firstValue[0]);

 var secondDate=new Date();
 secondDate.setFullYear(secondValue[2],(secondValue[1] - 1 ),secondValue[0]);     
  if (firstDate > secondDate)
  {
    alert("From date should not be greater than To date");
 // $('#fromdt' +id).val('');
 $('#todt' +id).val('');  
  document.getElementById('no_of_alter_days' +id).value=" "; 
    date1=date2=""; 
  }
   var start = new Date(firstValue[2]+"-"+firstValue[1]+"-"+firstValue[0]),
           end = new Date(secondValue[2]+"-"+secondValue[1]+"-"+secondValue[0]),
        year = start.getFullYear(),
    month = start.getMonth(),
    day = start.getDate(),
    dates = [start];
          //alert(start); 
          //alert(end);
        while(dates[dates.length-1] < end) {
          
  dates.push(new Date(year, month, ++day));
  
}
      if(dates.length > 1){
        var timeDifferenceInDays = parseInt(dates.length)-1;
      }else{  
      var timeDifferenceInDays = dates.length;
      }
      
//alert(timeDifferenceInDays);
if(timeDifferenceInDays>0){
  
$("#no_of_alter_days"+id).val(timeDifferenceInDays);  //no_of_alter_days110024
}
}
function getalterdiff1(id){
  //alert(id);
  id1='#fromdt'+id;
  id2='#todt'+id;
  
  var date1=$('#fromdt' +id).val();
  var date2=$('#todt' +id).val();
var firstValue = date1.split('-');
var secondValue = date2.split('-');

 var firstDate=new Date();
 firstDate.setFullYear(firstValue[2],(firstValue[1] - 1 ),firstValue[0]);

 var secondDate=new Date();
 secondDate.setFullYear(secondValue[2],(secondValue[1] - 1 ),secondValue[0]);     
  if (firstDate > secondDate)
  {
    alert("From date should not be greater than To date");
 // $('#fromdt' +id).val('');
 $('#todt' +id).val('');  
  document.getElementById('no_of_alter_days' +id).value=" "; 
    date1=date2=""; 
  }
   var start = new Date(firstValue[2]+"-"+firstValue[1]+"-"+firstValue[0]),
           end = new Date(secondValue[2]+"-"+secondValue[1]+"-"+secondValue[0]),
        year = start.getFullYear(),
    month = start.getMonth(),
    day = start.getDate(),
    dates = [start];
          //alert(start); 
          //alert(end);
        while(dates[dates.length-1] < end) {
          
  dates.push(new Date(year, month, ++day));
  
}
      if(dates.length > 1){
        var timeDifferenceInDays = parseInt(dates.length)-1;
      }else{  
      var timeDifferenceInDays = dates.length;
      }
//alert(timeDifferenceInDays);
if(timeDifferenceInDays>0){
$("#no_of_alter_od_days"+id).val(timeDifferenceInDays); //no_of_alter_days110024
}
}
 
      
function get_datet(eid,dty){
var dty = dty;
   
    if(dty=='od'){
        //alert(dty);
        getalterdiff1(eid);
    }else{
getalterdiff(eid);
}        
        //   getalterdiff(eid);
      }
</script>