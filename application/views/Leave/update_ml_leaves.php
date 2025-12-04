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
                status:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Status should not be empty'
                      }
                    }
                },
                ro_recommendation:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Recommendation should not be empty'
                      }
                    }
                }
				
            }       
        })
    });
</script>
<style>
.leaveid{line-height: 1;background: #4bb1d0;font-weight: bold; font-size: 16px !important;height: 25px;border: 1px solid #3086a0; }
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Leaves</a></li>
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
                            	<div class="panel-heading"><strong>Leave Application ID :- &nbsp;<span class="badge leaveid"><?php echo $details[0]['lid']; ?></span></strong>
                            	<span class="pull-right"><b>Applied On: <?php echo date('d-m-Y',strtotime($details[0]['applied_on_date']));?> </b>				
                         </span></div>
                                <div class="panel-body">
                                <div class="panel-padding no-padding-vr">
								<form id="form" name="form" action="<?=base_url($currentModule.'/update_ml_leave_application_submit')?>" method="POST">
								
								<div class="form-body">
								    <div class="form-group">
								        <?php 	if($details[0]['leave_apply_type'] != 'OD'){ ?>
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
        <td><?php
        if($val['leave_type']=='VL'){
                 // echo $val['vl_id'];
            $cnt = $this->leave_model->get_vacation_leave_list('',$val['vl_id']);
            echo $val['leave_type']." (".$cnt[0]['vacation_type']."-".$cnt[0]['slot_type'].")";
    }else{     
        echo $val['leave_type']; } ?></td>
        <td><?=$val['leaves_allocated']?></td>
        <td><?=$val['leave_used']?></td>
        <td><span id="<?=$val['leave_type']?>"><?=$val['leaves_allocated']-$val['leave_used']?></span></td>
		</tr>
	  <?php } ?>     
    </tbody>
  </table>
  <?php }else{ ?>
  
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Leave Type</th>
        <th>Total OD</th>
        
      </tr>
    </thead>
    <tbody>     
	 <tr>
        <td>OD</td>
        <td><?php 
        $cnt = $this->leave_model->get_emp_od_cnt($details[0]['emp_id']);
        //print_r($cnt);       
            echo $cnt;
        
        ?></td>
       
		</tr>
	  
    </tbody>
  </table>
  
  <?php } ?>
							
							</div>				
                                <div class="form-group">
								<label class="col-md-3">Applicant Name</label>
								<input type="hidden" name="lid" value="<?php echo isset($details[0]['lid'])?$details[0]['lid']:'';?>">
								<input type="hidden" name="emp_id" value="<?php echo isset($details[0]['emp_id'])?$details[0]['emp_id']:'';?>">
							
									<input type="hidden" name="emp_lev" value="<?php 
								$uid = $this->session->userdata("name");
									if($details[0]['emp1_reporting_person'] == $uid){
										$k=1;
									echo "emp1_reporting_person";
									}elseif($details[0]['emp2_reporting_person'] == $uid){
										$k=2;
									echo "emp2_reporting_person";
									}elseif($details[0]['emp3_reporting_person'] == $uid){
										$k=3;
									echo "emp3_reporting_person";
									}elseif($details[0]['emp4_reporting_person']==$uid){
										$k=4;
									echo "emp4_reporting_person";
									}     ?>" >
								<div class="col-md-3">
                                       <input class="form-control" readonly name="ename" value="<?php echo isset($details[0]['fname'])?$details[0]['fname']:'';?> <?php echo isset($details[0]['lname'])?$details[0]['lname']:'';?>" type="text">
                                            </div>
                                            <label class="col-md-3 control-label">Staff ID</label>
												<div class="col-md-3" >
												<input type="text" class="form-control"  disabled  name="leave_types" value="<?php echo $details[0]['emp_id'];?>">
												</div>
											</div>
											 <div class="form-group">
								<label class="col-md-3">Leave Type</label>
								<div class="col-md-3">
								<input type="hidden" name="leave_type" value="<?php echo $details[0]['leave_type'];?>">
                <input type="hidden" name="leave_name" value="<?php 
                if($details[0]['leave_apply_type'] == 'OD'){
                    echo 'OD';
                }else{
                if($details[0]['leave_type'] == 'lwp'){
                echo $this->leave_model->getLeaveTypeById1('9');
              }else{
                
                  echo $this->leave_model->getLeaveTypeById($details[0]['leave_type']);
              }
                } ?>">
								<input type="hidden" name="no_days" value="<?php echo $details[0]['no_days'];?>">
								<input type="text" class="form-control"  disabled  name="leave_types" value="<?php 
								if($details[0]['leave_apply_type'] == 'OD'){
								    echo 'OD';
								}else{
								 if($details[0]['leave_type'] == 'lwp'){
								echo $this->leave_model->getLeaveTypeById1('9');
              }else{
                    $lt = $this->leave_model->getLeaveTypeById($details[0]['leave_type']);
                if($lt == 'VL'){
            $cnt = $this->leave_model->get_vid_emp_allocation($details[0]['leave_type']);
        echo $lt." (".$cnt[0]['vacation_type']."-".$cnt[0]['slot_type'].")";    
        }else{
            echo $lt;
        }
              }
								} ?>">
                                                  
												
                                            </div>
								<label class="col-md-3 control-label">Select Leave Duration</label>
												<div class="col-md-3" >
												<input type="text" class="form-control"  disabled  name="leave_types" value="<?php echo $details[0]['leave_duration'];?>">
												<input type="hidden" name="leave_duration" value="<?php echo $details[0]['leave_duration'];?>">
												
												</div>
											</div>
											<div class="form-group" id='sl_gatepass' >
						 <div class="col-md-3"></div>
<label class="col-md-3" style="color:red;">Do You Want Gate Pass??</label>
<div class="col-md-3">
<label ><input type="radio" value="Y" disabled id="gate_pass_yes" <?php if($details[0]['gate_pass']=='Y'){echo "checked"; }?>  name="gate_pass">Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label ><input type="radio" value="N" disabled id="gate_pass_no"  <?php if($details[0]['gate_pass']=='N'){echo "checked"; }?> name="gate_pass">No</label>
</div>
</div>				<?php if($details[0]['leave_duration'] == 'hrs'){ ?>
<div class="form-group">
                <label class="col-md-3">OD Date</label>
                                             <div class="col-md-3" >
                       <input type="text" class="form-control" readonly name="applied_from_date" value="<?php echo date('d-m-Y',strtotime($details[0]['departure_time']));?>" >
                                  <!--<input id="dob-datepicker" class="form-control date-picker" name="applied_for_date" value="<?=isset($details[0]['applied_for_date'])?$details[0]['applied_for_date']:'';?>"  readonly placeholder="Enter Date" type="text">-->

                                             </div>
                                             </div>
											 <div class="form-group">
								<label class="col-md-3">Departure Time</label>
                                             <div class="col-md-3" >
											 <input type="text" class="form-control" readonly name="departure_time" value="<?php echo date('G:i',strtotime($details[0]['departure_time']));?>" >
                                  <!--<input id="dob-datepicker" class="form-control date-picker" name="applied_for_date" value="<?=isset($details[0]['applied_for_date'])?$details[0]['applied_for_date']:'';?>"  readonly placeholder="Enter Date" type="text">-->

                                             </div>
                                  
								<label class="col-md-3">Arrival Time</label>
                                             <div class="col-md-3" >
											 <input type="text" class="form-control" readonly name="arrival_time" value="<?php echo date('G:i',strtotime($details[0]['arrival_time']));?>" >
                                  <!--<input id="dob-datepicker" class="form-control date-picker" name="applied_for_date" value="<?=isset($details[0]['applied_for_date'])?$details[0]['applied_for_date']:'';?>"  readonly placeholder="Enter Date" type="text">-->

                                             </div>
                                  </div>
                                   <div class="form-group">
									 <label class="col-md-3 control-label">Total Hrs.</label>
									 <div class="col-md-3">
									<input class="form-control" readonly  type="text"  name="no_days" id="no_days" value="<?php echo $details[0]['no_hrs'] ; ?> ">
									</div>
<?php }else{?>

<div class="form-group">
								<label class="col-md-3">Leave from Date</label>
                                             <div class="col-md-3" >
											 <input type="text" class="form-control" readonly name="applied_from_date" value="<?php echo date('d-m-Y ',strtotime($details[0]['applied_from_date']));?>" >
                                  <!--<input id="dob-datepicker" class="form-control date-picker" name="applied_for_date" value="<?=isset($details[0]['applied_for_date'])?$details[0]['applied_for_date']:'';?>"  readonly placeholder="Enter Date" type="text">-->

                                             </div>
                                  
								<label class="col-md-3">Leave To Date</label>
                                             <div class="col-md-3" >
											 <input type="text" class="form-control" readonly name="applied_to_date" value="<?php echo date('d-m-Y ',strtotime($details[0]['applied_to_date']));?>" >
                                  <!--<input id="dob-datepicker" class="form-control date-picker" name="applied_for_date" value="<?=isset($details[0]['applied_for_date'])?$details[0]['applied_for_date']:'';?>"  readonly placeholder="Enter Date" type="text">-->

                                             </div>
                                  </div>
                                   <div class="form-group">
									 <label class="col-md-3 control-label">No Of Days.</label>
									 <div class="col-md-3">
									<input class="form-control" readonly  type="text"  name="no_days" id="no_days" value="<?php echo $details[0]['no_days'] ;?> ">
									</div>


<?php } ?>
									 <label class="col-md-3 control-label">Designation</label>
									 <div class="col-md-3">
									<input class="form-control" readonly type="text" name="designation" id="designation" value="<?php
										$dg = $this->Admin_model->getDesignationById($details[0]['designation']);
										echo $dg[0]['designation_name'];?>">
									</div>
									</div>
                                    <div class="form-group">
									<label class="col-md-3 control-label">Department</label>
									 <div class="col-md-3">
									<input class="form-control" readonly type="text" name="department" id="department" value="<?php
									$dp = $this->Admin_model->getDepartmentById($details[0]['department']);
									     echo	$dp[0]['department_name'];
									?>">
									</div>
									<label class="col-md-3 control-label">School</label>
									 <div class="col-md-3">
									<input class="form-control" readonly type="text" name="school" id="school" value="<?php
$sc = $this->Admin_model->getSchoolById($details[0]['emp_school']);
								 echo $sc[0]['college_name'];
									?>">
									</div>
                                      </div>		
                                  
                                  <?php $lt =  $this->leave_model->getLeaveTypeById($details[0]['leave_type']); 
if($lt == 'ML'){ ?>                   
                                  <div class="form-group">
                <label class="col-md-3">Upload Medical Certificate</label>
                <div class="col-md-9" >
                    <?php $bucketname = 'uploads/employee_documents/'; ?>
                <a href="<?= site_url() ?>Upload/get_document/<?php echo $details[0]['medical_certificate'].'?b_name='.$bucketname; ?>" ><?php echo $details[0]['medical_certificate']; ?></a>
                  </div>
                                  </div>
<?php } ?>
								   <div class="form-group">
								<label class="col-md-3">Reason</label>
                                             <div class="col-md-9" >
                                  <textarea name="reason"  readonly class="form-control"><?=isset($details[0]['reason'])?$details[0]['reason']:'';?></textarea>

                                             </div>
                                  </div>
                                  <div class="form-group">
        						<label class="col-md-6"><u>Details of Alternative Arrangement</u></label>
										
        					 </div>	
        					 <?php $al = $this->leave_model->getLeaveAlternativeDetailById($details[0]['lid']); 
        				//	 print_r($al);
        					 ?>
        					 <div class="form-group">
									<label class="col-md-3 control-label">School</label>
									 <div class="col-md-3">
								<input class="form-control" readonly type="text" name="school" id="school" value="<?php 
								 $sc = $this->Admin_model->getSchoolById($al[0]['school_id']);
								 echo $sc[0]['college_name'];
								 ?>">
									</div>
									<label class="col-md-3 control-label">Department</label>
									 <div class="col-md-3">
									     	<input class="form-control" readonly type="text" name="department" id="department" value="<?php
									     	 $dp = $this->Admin_model->getDepartmentById($al[0]['depart_id']);
									     echo	$dp[0]['department_name'];?>">
									
									</div>
                                      </div>	
        					 
        		  <div class="form-group">
							   
							   <div  style="margin-left:10px;">
  <table id="emp-table" class="table table-bordered table-striped">
      <?php 
      	echo"<thead>
   
      <th>Staff Id</th>
	  <th>From Date</th>
	  <th>To Date</th>";
    if($details[0]['leave_duration']=='hrs'){
      echo "<th>No.Of.Hrs</th>";
    }else{
	  echo "<th>No.Of.Days</th>";
  }
        echo "</thead>";
        foreach($al as $emp){
            $emp_de = $this->leave_model->fetchEmployeeData($emp['alter_staff_id']);
        echo"<tr>
	<td>".$emp['alter_staff_id']." - ".$emp_de[0]['fname']." ".$emp_de[0]['lname']."</td>";
   if(!is_null($emp['from_dt'])){ 
	echo "<td>".date('d-m-Y',strtotime($emp['from_dt']))."</td>";
   }else{ ?>
<td>00-00-0000</td>
    <?php } 
	echo "<td>".date('d-m-Y',strtotime($emp['to_dt']))."</td>";

	echo "<td>".$emp['no_of_days']."</td>";

	echo "</tr>"; 
        }
	?>
  </table>

  
</div>
        					 
        			 <div class="form-group">
  <label class="col-md-3 control-label">Contact Details During Leave Period</label>
  <div class="col-md-3">
  <textarea name="leave_contct_address" readonly class="form-control" id="leave_contct_address" ><?=isset($details[0]['leave_contct_address'])?$details[0]['leave_contct_address']:'';?></textarea>
  </div>
  <label class="col-md-3 control-label">Mobile No.</label>
<div class="col-md-3">  
  <input type="text" name="leave_contct_no" readonly id="leave_contct_no" value="<?=isset($details[0]['leave_contct_no'])?$details[0]['leave_contct_no']:'';?>" class="form-control" placeholder="Mobile No">
</div> 
</div> 	
<?php if($details[0]['leave_apply_type'] == 'OD'){?>
	 <div class="form-group">
  <label class="col-md-3 control-label">State</label>
   <div class="col-md-3">
   	<input class="form-control" readonly type="text" name="state" id="state" value="<?php echo $this->Admin_model->getStateByID($details[0]['l_od_state']); ?>">
   </div>
  
<label class="col-md-3 control-label">City</label>
   <div class="col-md-3">
  	<input class="form-control" readonly type="text" name="city" id="city" value="<?php echo $this->Admin_model->getCityByID($details[0]['l_od_city']);?>">
   </div>
</div> 


<?php } ?>
				       <div class="panel">
				            <div class="panel-heading" style="background-color: #3da1bf;color:white;"><strong>Reporting Details</strong>
        						
        					 </div>	   
							 <div class="form-group">
							<?php 
							
		echo "<table class='table table-striped table-bordered table-hover no-footer'>";
		echo "<tr><td><b>Level</b></td><td><b>Name</b></td><td><b>Status</b></td><td><b>Remark</b></td><td><b>Date</b></td></tr>";
						
					$cnt = $this->leave_model->getcountreporting($details[0]['lid']);
							for($j=1;$j<=$cnt;$j++){
								$emp_detail=$this->leave_model->fetchEmployeeData($details[0]['emp'.$j.'_reporting_person']);
							echo "<tr><td>Reporting ".$j."</td>";
		   	echo "<td>".$details[0]['emp'.$j.'_reporting_person']." - ".$emp_detail[0]['fname']." ".$emp_detail[0]['lname']."</td>";
				echo "<td>".$details[0]['emp'.$j.'_reporting_status']."</td>";
				echo "<td>".$details[0]['emp'.$j.'_reporting_remark']."</td>";
				echo "<td>";
				if(!empty($details[0]['emp'.$j.'_reporting_date'])){
				echo date('d-m-Y',strtotime($details[0]['emp'.$j.'_reporting_date']));
				}else{
					echo "";
				}
				echo "</td></tr>";
							}  
			  
	
		echo "</table>"; ?>
						</div>
</div>						
								   
                                  <div class="form-group">
								<label class="col-md-3">Status Of Application</label>
								<div class="col-md-3">
								   
                                <select class="form-control form-control-inline" name="status" required type="text">
													<option value="">Select</option>												
													<option  value="Rejected">Not Varified (Original Certificate Not Varified)</option>												
													<option  value="Approved">Varified (Original Certificate Varified)</option>
													
												</select>
                                            </div>
											</div>                                      

                                  
                       
              
                  <div class="form-group">             
                <label class="col-md-3">Remark</label>
                                 <div class="col-md-3" >
                                  <textarea id="remark" name="remark" class="form-control" required><?=isset($details[0]['adm_comment'])?$details[0]['adm_comment']:'';?></textarea>
                                             </div>
                                             </div>

                
                              <div class="form-group">
							  <div class="col-md-3"></div>
							  <?php //if($details[0]['fstatus'] != 'Rejected'){
if(!empty($fs) || $k == '1' || $this->session->userdata("uid")==1){ ?>
                                      <div class="col-md-3">  
                                            <input type="submit" name="afsubmit" value="Submit" class="btn btn-primary form-control" >
                                        </div>
                                        <?php }//} ?>
										      <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/ml_leave_list'">Cancel</button></div>
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

function change_leave_status(val){
	if(val=='Rejected'){
		$('#rege').show();
		$('#ro_recommendation').removeAttr('required');
		$('#af').hide();
	}else if(val=='Approved'){
		$('#af').show();
		$('#ro_rejection').removeAttr('required');
		$('#rege').hide();
	}
	
}

</script>