<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datetimepicker.min.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>    
   /*  $(document).ready(function()
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
                }
              
            }       
        }) 
		
}); */
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
					
					   <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span><br>
                        <div class="table-info">
                           
                         <div id="dashboard-recent" class="panel-warning"> 
<div class="panel" id="type">
                            	<div class="panel-heading"><strong>Select Type Of Application</strong></div>
                                <div class="panel-body">
								<div class="col-sm-6">
								
							<label ><input type="radio" value="form-forleave" id="formtype_leave" checked name="formtype">Apply For Leave</label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label><input type="radio"  value="form-forod" id="formtype_od" name="formtype">Apply For OD</label>
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
        <th>CL</th>
        <th>C-OFF</th>
        <th>EL</th>
        <th>ML</th>
        <th>VL</th>
        <th>SL</th>
        <th>Leave</th>
        <!--<th>LWP</th>-->
        <th>Vacation Leaves</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?=$emp_detail[0]['cnt_cl']?></td>
        <td><?=$emp_detail[0]['cnt_coff']?></td>
        <td><?=$emp_detail[0]['cnt_el']?></td>
        <td><?=$emp_detail[0]['cnt_ml']?></td>
        <td><?=$emp_detail[0]['cnt_vl']?></td>
        <td><?=$emp_detail[0]['cnt_sl']?></td>
        <td><?=$emp_detail[0]['cnt_leave']?></td>
        <!--<td><?=$emp_detail[0]['cnt_lwp']?></td>-->
        <td><table class="table table-bordered">
		<tr><td>I Slot</td><td><?=$emp_detail[0]['vslot1']?></td></tr>
		<tr><td>II Slot</td><td><?=$emp_detail[0]['vslot2']?></td></tr>
		<tr><td>III Slot</td><td><?=$emp_detail[0]['vslot3']?></td></tr>
		<tr><td>IV Slot</td><td><?=$emp_detail[0]['vslot4']?></td></tr>
		
		</table></td>
       
      </tr>
      
    </tbody>
  </table>
							
							</div>				
					
					
</div>								
</div>								
                               <div class="panel" id="forleave">
                            	<div class="panel-heading"><strong> Application For Leave</strong></div>
                                <div class="panel-body">
								
					 <form id="form-forleave" name="form-forleave" action="<?=base_url($currentModule.'/add_leave')?>" method="POST" >
								<input type="hidden" name="emp_id" value="<?php echo $this->session->userdata('name');?>">
								<input type="hidden" name="in-leave" value="1">
								<div class="form-group">
								<label class="col-md-3 control-label">Current Date</label>
        										<div class="col-md-3">
												<?php $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));//display current time 24 hrs format?>
                                        
												<input class="form-control" readonly type="text" name="today_date" id="today_date" value="<?=$date->format('d-m-Y H:i:s a')?>">
												</div>	
								</div>
                                <div class="form-group">
        										<label class="col-md-3 control-label">Select Leave Type</label>
        										<div class="col-md-3">
												<select id="leave_type" name="leave_type" class="form-control" required>
												<option value=""> Select Leave Type</option>
												<?php if(isset($emp_detail[0]['cnt_cl']) && $emp_detail[0]['cnt_cl']!=0)
													echo "<option value='1'>".'CL'."</option>";?>
												<?php if(isset($emp_detail[0]['cnt_ml']) && $emp_detail[0]['cnt_ml']!=0)
													echo "<option value='2'>".'ML'."</option>";?>
												<?php if(isset($emp_detail[0]['cnt_el']) && $emp_detail[0]['cnt_el']!=0)
													echo "<option value='3'>".'EL'."</option>";?>
                                                 <?php if(isset($emp_detail[0]['cnt_coff']) && $emp_detail[0]['cnt_co']!=0)
													echo "<option value='4'>".'C-OFF'."</option>";?>
												<?php if(isset($emp_detail[0]['cnt_sl']) && $emp_detail[0]['cnt_sl']!=0)
													echo "<option value='5'>".'SL'."</option>";?>
												<?php if(isset($emp_detail[0]['cnt_vl']) && $emp_detail[0]['cnt_vl']!=0)
													echo "<option value='6'>".'VL'."</option>";?>
												<?php if(isset($emp_detail[0]['cnt_leave']) && $emp_detail[0]['cnt_leave']!=0)
													echo "<option value='7'>".'Leave'."</option>";?>
												<?php/*  if(isset($emp_detail[0]['cnt_lwp']) && $emp_detail[0]['cnt_lwp']!=0)
													echo "<option value='8'>".'LWP'."</option>"; */?>
												<?php if(isset($emp_detail[0]['cnt_stl']) && $emp_detail[0]['cnt_stl']!=0)
													echo "<option value='9'>".'STL'."</option>";?>
												<option value='9'>LWP</option>
												
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
									<input class="form-control"  required type="text" onclick="getTotalDays();" name="no_days" id="no_days" value="">
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
											
											<div class="form-group">
        										<label class="col-md-3 control-label">Reason For Leave</label>
        										<div class="col-md-9">
												<textarea  class="form-control"  style="resize:none;overflow-y:scroll;height:50px" required name="reason" placeholder="Reason For Leave" ></textarea>
												</div>
        									</div>
								 <div class="form-group">
        						<label class="col-md-3"><u>Details of Alternative Arrangement</u></label>
								<label class="col-md-9" style="color:red;">Note:Select Department Only if you want alternate arrangement from other Department</label>				
        					 </div>	
                             <div class="form-group">
							  <label class="col-md-3 control-label">Select School</label>
									 <div class="col-md-3">
									<select class="form-control" name="reporting_school" id="reporting_school" onchange="getdept_using_school(this.value)">
									<option value=" "> Select School</option>
									<?php foreach($school_list as $sc ){
												
												echo "<option value=".$sc['college_id'].">".$sc['college_name']."</option>"?>
											<?php } ?>
									</select>
									</div>
							 <label class="col-md-3 control-label">Select Department</label>
									 <div class="col-md-3">
									<select name="reporting_dept" id="reporting_dept" onchange="getEmp_using_deptforLeave(this.value)" class="form-control" >
												<option value=" ">Select Depart</option>
												<?php 
                                                  ?>
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
  <input type="text" name="leave_contct_no" id="leave_contct_no" value="<?=$emp_detail[0]['mobileNumber'];?>" class="form-control" placeholder="Address">
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
                            	<div class="panel-heading"><strong> Application For OD</strong></div>
                                <div class="panel-body">
								<form  id="form-forod"  name="form-forod" action="<?=base_url($currentModule.'/add_od')?>" method="POST" >
<input type="hidden" name="emp_id" value="<?php echo $this->session->userdata('name');?>">
<input type="hidden" name="in-od" value="1">
								<div class="form-group">
								<label class="col-md-3 control-label">Current Date</label>
        										<div class="col-md-3">
												<?php $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));//display current time 24 hrs format?>
                                        
												<input class="form-control" readonly type="text" name="today_date" id="today_date" value="<?=$date->format('d-m-Y H:i:s a')?>">
												</div>	
								</div> 
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
												<option value="half-day">Half-Day</option>
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
						  <div class="form-group" id="od-for-day" style="display:none">
        										<label class="col-md-3 control-label">OD From Date</label>
												<div class="col-md-3">        										
        										<input class="form-control" id="dob-datepicker2" name="applied_from_date" value="" onchange="checkOD_Duration()" placeholder="OD From Date" type="text" >
        										</div>
											<label class="col-md-3 control-label">OD To Date</label>
												<div class="col-md-3">        										
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
									<input class="form-control" type="text" onclick="getTotalDays1();" name="no_days_forod" id="no_days_forod" value="">
									</div>											
									</div>
                                    <div id="no_hr" style="display:none">
									 <label class="col-md-3 control-label">No Of Hrs.</label>
									 <div class="col-md-3">
									<input class="form-control"   type="text" onclick="getTotalhrs();" name="no_hrs_forod" id="no_hrs_forod" value="">
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
								<label class="col-md-9" style="color:red;">Note:Select Department Only if you want alternate arrangement from other Department</label>				
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
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Send  </button>                                      
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

$(document).ready(function(){
	
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
		format: 'yyyy-mm-dd'
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
		$('#dob-datepicker1').datepicker('setStartDate', minDate);
    });
    
    $("#dob-datepicker1").datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd'
    }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#dob-datepicker').datepicker('setEndDate', minDate);
	});
	//for od form date picker
	$("#dob-datepicker2").datepicker({
        todayBtn:  1,
        autoclose: true,
		format: 'yyyy-mm-dd'
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
		$('#dob-datepicker3').datepicker('setStartDate', minDate);
    });
    
    $("#dob-datepicker3").datepicker({
        autoclose: true,
		format: 'yyyy-mm-dd'
    }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#dob-datepicker2').datepicker('setEndDate', minDate);
	});
	//for od hrs time picker
	$('#timepicker1').timepicker({autoclose: true,use24hours: true,format: 'HH:mm'});
	$('#timepicker2').timepicker({autoclose: true,use24hours: true,format: 'HH:mm'});
	
	
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
	//leave duration
	if($('#leave_duration').val()=='half-day'){
		$("#no_days").val(0.5);
		$("#no_days").attr('readonly',true);	
	}else if($('#leave_duration').val()=='full-day'){
	var date1=$("#dob-datepicker").val();
	var date2=$("#dob-datepicker1").val();
	
	if(date2<date1){
		alert("From date should not be greater than To date");
	document.getElementById('dob-datepicker').value =" "; 
	document.getElementById('dob-datepicker1').value=" "; 		
	document.getElementById('no_days').value=" "; 
    date1=date2="";	
	}
		
	// First we split the values to arrays date1[0] is the year, [1] the month and [2] the day
date1 = date1.split('-');
date2 = date2.split('-');

// Now we convert the array to a Date object, which has several helpful methods
date1 = new Date(date1[0], date1[1], date1[2]);
date2 = new Date(date2[0], date2[1], date2[2]);

// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
date1_unixtime = parseInt(date1.getTime() / 1000);
date2_unixtime = parseInt(date2.getTime() / 1000);

// This is the calculated difference in seconds
var timeDifference = date2_unixtime - date1_unixtime;

// in Hours
var timeDifferenceInHours = timeDifference / 60 / 60;

// and finaly, in days :)
var timeDifferenceInDays = timeDifferenceInHours  / 24+1;

//alert(timeDifferenceInDays);
if(timeDifferenceInDays>0){
$("#no_days").val(timeDifferenceInDays);	
$("#no_days").attr('readonly',true);	
}	
	}
	
 
}
//for od form 
function checkdh_div(val){
	if(val=='hrs'){
		$('#od-for-hrs').show();
		$('#no_hr').show();
		$("#no_hrs_forod").attr('required',true);
		$('#od-for-day').hide();
		$('#no_d').hide();
		
		
	}else if(val=='full-day'){
		$('#od-for-day').show();
		$("#dob-datepicker2").attr('required',true);
		$('#no_d').show();
		$('#od-for-hrs').hide();
		$('#no_hr').hide();
		
	}else if(val=='half-day'){
		$('#od-for-day').show();
		$("#dob-datepicker2").attr('required',true);
		$('#no_d').show();
		$('#od-for-hrs').hide();
		$('#no_hr').hide();
		
	}
	
}


function calculateTime() {                         
        var valuestart = $('#timepicker1').val();// "8:45am";
        var valuestop = $('#timepicker2').val();//"8:46pm";
		
        var hourStart = new Date("01/01/2007 " + valuestart).getHours();
        var hourEnd = new Date("01/01/2007 " + valuestop).getHours();

        var minuteStart = new Date("01/01/2007 " + valuestart).getMinutes();
        var minuteEnd = new Date("01/01/2007 " + valuestop).getMinutes();

        var hourDiff = hourEnd - hourStart;
        var minuteDiff = minuteEnd - minuteStart;
		
        if (minuteDiff < 0) {
            hourDiff = hourDiff - 1;
			minuteDiff=60-(-(minuteDiff));
        }
   var rn=hourDiff+'.'+minuteDiff;
        return  rn;    
    }
    function getTotalhrs(){		
		var tdiff=calculateTime();
		$('#no_hrs_forod').val(tdiff);
	}


function getTotalDays1(){
	var date1=$("#dob-datepicker2").val();
	var date2=$("#dob-datepicker3").val();
	
	if(date2<date1){
		alert("From date should not be greater than To date");
	document.getElementById('dob-datepicker2').value =" "; 
	document.getElementById('dob-datepicker3').value=" "; 		
	document.getElementById('no_days_forod').value=" "; 
    date1=date2="";	
	}
		
	// First we split the values to arrays date1[0] is the year, [1] the month and [2] the day
date1 = date1.split('-');
date2 = date2.split('-');

// Now we convert the array to a Date object, which has several helpful methods
date1 = new Date(date1[0], date1[1], date1[2]);
date2 = new Date(date2[0], date2[1], date2[2]);

// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
date1_unixtime = parseInt(date1.getTime() / 1000);
date2_unixtime = parseInt(date2.getTime() / 1000);

// This is the calculated difference in seconds
var timeDifference = date2_unixtime - date1_unixtime;

// in Hours
var timeDifferenceInHours = timeDifference / 60 / 60;

// and finaly, in days :)
var timeDifferenceInDays = timeDifferenceInHours  / 24+1;

//alert(timeDifferenceInDays);
if(timeDifferenceInDays>0){
$("#no_days_forod").val(timeDifferenceInDays);	
$("#no_days_forod").attr('readonly',true);
}
 
}

function getalterdiff(id){
	//alert(id);
	id1='#fromdt'+id;
	id2='#todt'+id;
	
	var date1=$('#fromdt' +id).val();
	var date2=$('#todt' +id).val();
	if(date2<date1){
		alert("From date should not be greater than To date");
	document.getElementById('fromdt' +id).value =" "; 
	document.getElementById('todt' +id).value=" "; 		
	document.getElementById('no_of_alter_days' +id).value=" "; 
    date1=date2="";	
	}
		
	// First we split the values to arrays date1[0] is the year, [1] the month and [2] the day
date1 = date1.split('-');
date2 = date2.split('-');

// Now we convert the array to a Date object, which has several helpful methods
date1 = new Date(date1[0], date1[1], date1[2]);
date2 = new Date(date2[0], date2[1], date2[2]);

// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
date1_unixtime = parseInt(date1.getTime() / 1000);
date2_unixtime = parseInt(date2.getTime() / 1000);

// This is the calculated difference in seconds
var timeDifference = date2_unixtime - date1_unixtime;

// in Hours
var timeDifferenceInHours = timeDifference / 60 / 60;

// and finaly, in days :)
var timeDifferenceInDays = timeDifferenceInHours  / 24+1;

//alert(timeDifferenceInDays);
if(timeDifferenceInDays>0){
$("#no_of_alter_days"+id).val(timeDifferenceInDays);	//no_of_alter_days110024
}
}
function getalterdiff1(id){
	//alert(id);
	id1='#fromdt'+id;
	id2='#todt'+id;
	
	var date1=$('#fromdt' +id).val();
	var date2=$('#todt' +id).val();
	if(date2<date1){
		alert("From date should not be greater than To date");
	document.getElementById('fromdt' +id).value =" "; 
	document.getElementById('todt' +id).value=" "; 		
	document.getElementById('no_of_alter_od_days' +id).value=" "; 
    date1=date2="";	
	}
		
	// First we split the values to arrays date1[0] is the year, [1] the month and [2] the day
date1 = date1.split('-');
date2 = date2.split('-');

// Now we convert the array to a Date object, which has several helpful methods
date1 = new Date(date1[0], date1[1], date1[2]);
date2 = new Date(date2[0], date2[1], date2[2]);

// We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
date1_unixtime = parseInt(date1.getTime() / 1000);
date2_unixtime = parseInt(date2.getTime() / 1000);

// This is the calculated difference in seconds
var timeDifference = date2_unixtime - date1_unixtime;

// in Hours
var timeDifferenceInHours = timeDifference / 60 / 60;

// and finaly, in days :)
var timeDifferenceInDays = timeDifferenceInHours  / 24+1;

//alert(timeDifferenceInDays);
if(timeDifferenceInDays>0){
$("#no_of_alter_od_days"+id).val(timeDifferenceInDays);	//no_of_alter_days110024
}
}

</script>