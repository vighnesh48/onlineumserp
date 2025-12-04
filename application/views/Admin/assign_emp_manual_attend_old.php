<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>


<style>
.attexl table{
	 border: 1px solid black;
}
.attexl table th{
 border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.attexl table td{
	 border: 1px solid black;
    padding: 5px;
}
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Employee Manual Attendance</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Manual Attendance</h1>
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
                                           
                                                               
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Employee Manual Attendance</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/staff_manual_attendance')?>" method="POST" enctype="multipart/form-data">
							    <?php if(!empty($emp_leave_info)){ //print_r($emp_leave_info);?>
								
								<input type="hidden" name="inupdate" value="1">
								
                                <?php } ?>								
								<div class="form-body">
								<div class="form-group">
								<label class="col-md-3">Select Month&Year</label>
								<div class="col-md-3" >
								<input type="text" class="form-control" placeholder="Month & Year" name="for_month_year" id="dob-datepicker" value="" required>
								</div>
								</div>
								<div class="form-group">
								<label class="col-md-3">Select School</label>
                                             <div class="col-md-3" >
											 <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="reporting_school" required>
											 <option value="">Select School</option>
											 <?php foreach($school_list as $sc) {
												 $str1='';
												 if($emp_leave_info[0]['school_id']==$sc['college_id']){
													 $str1='selected';
												 }
												 echo "<option ".$str1." value=".$sc['college_id'].">".$sc['college_name']."</option>";
											 } ?>
											
										     </select>
                                       </div>
                                  </div>
								   <div class="form-group">
								<label class="col-md-3 control-label">Department:<?=$astrik?></label>
        										<div class="col-md-3">
      <select class="form-control select2me" id="department"  onchange="getMarked_Emp_Manual_Attendance(this.value)" name="department" required >
											<option value="">Select Department</option>
											<?php $res=$this->Admin_model->getdepartmentByschool($emp_leave_info[0]['school_id']);
											foreach($res as $key=>$val){
												$str2='';
												if($res[$key]['department_id']==$emp_leave_info[0]['department_id']){
													$str2="selected";													
												}
												echo "<option ".$str2." value=".$res[$key]['department_id'].">".$res[$key]['department_name']."</option>";
											}
											
											?>
											</select>
                                       </div>
                                  </div>
								  <div class="form-group">
								<label class="col-md-3 control-label">Employee List:<?=$astrik?></label>
        										<div class="col-md-3">
        									<select class="form-control select2me" id="reporting_person" name="employee" onchange="allowForLeave()" required >
											<option value="">Select Employee</option>
<?php $res=$this->Admin_model->getSchoolDepartmentWiseEmployeeList($emp_leave_info[0]['school_id'],$emp_leave_info[0]['department_id']);

											foreach($res as $key=>$val){
												$str3='';
												if($res[$key]['emp_id']==$emp_leave_info[0]['emp_id']){
													$str3="selected";													
												}
				echo "<option ".$str3." value=".$res[$key]['emp_id'].">".$res[$key]['fname'].' '.$res[$key]['mname'].' '.$res[$key]['lname']."</option>";
											}
											
											?>
											</select>
                                       </div>
                                  </div>
								  <div id="dj"></div>
                                <div class="form-group">
								<!--For Leave -->
					<div class="clearfix" id="leave_module" style="display:none">
        			        			<div class="row ">
        				<div class="col-md-12 col-sm-12">
        					<div class="portlet box purple-wisteria">
        						<div class="portlet-title">
        							<div class="caption">
        								<i class="fa fa-edit"></i>Employee Manual Monthly Final Attendance 
        							</div>

        						</div>
        						<div class="portlet-body">
								
								<div class="form-group">
		                                    <label class="col-sm-3">Month days</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="month_days" name="month_days" value="<?=isset($emp_leave_info[0]['month_days'])?$emp_leave_info[0]['month_days']:''?>" min="0">											
        								</div>
										<label class="col-sm-3">Working Days</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="working_days" name="working_days" value="<?=isset($emp_leave_info[0]['working_days'])?$emp_leave_info[0]['working_days']:''?>" min="0">											
        								</div>
        								</div>										
										<div class="form-group">
										<label class="col-sm-3">Total Present</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="total_present" name="total_present" value="<?=isset($emp_leave_info[0]['total_present'])?$emp_leave_info[0]['total_present']:''?>" min="0">											
        								</div>
											<label class="col-sm-3">Sunday</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="sunday" name="sunday" value="<?=isset($emp_leave_info[0]['sunday'])?$emp_leave_info[0]['sunday']:''?>" min="0">											
        								</div>
        								</div>
										<div class="form-group">
										<label class="col-sm-3">Holiday</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="holiday" name="holiday" value="<?=isset($emp_leave_info[0]['holiday'])?$emp_leave_info[0]['holiday']:''?>" min="0">											
        								</div>
											<label class="col-sm-3">OD</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="total_outduty" name="total_outduty" value="<?=isset($emp_leave_info[0]['total_outduty'])?$emp_leave_info[0]['total_outduty']:''?>" min="0">											
        								</div>
        								</div>
										<div class="form-group">
										<label class="col-sm-3">CL</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="CL" name="CL" value="<?=isset($emp_leave_info[0]['CL'])?$emp_leave_info[0]['CL']:''?>" min="0">											
        								</div>
											<label class="col-sm-3">ML</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="ML" name="ML" value="<?=isset($emp_leave_info[0]['ML'])?$emp_leave_info[0]['ML']:''?>" min="0">											
        								</div>
        								</div>
										<div class="form-group">
										<label class="col-sm-3">EL</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="EL" name="EL" value="<?=isset($emp_leave_info[0]['EL'])?$emp_leave_info[0]['EL']:''?>" min="0">											
        								</div>
										<label class="col-sm-3">C-Off</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="C-Off" name="C-Off" value="<?=isset($emp_leave_info[0]['C-Off'])?$emp_leave_info[0]['C-Off']:''?>" min="0">											
        								</div>
        								</div>
										<div class="form-group">
										<label class="col-sm-3">SL</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="SL" name="SL" value="<?=isset($emp_leave_info[0]['SL'])?$emp_leave_info[0]['SL']:''?>" min="0">											
        								</div>
										<label class="col-sm-3">VL</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="VL" name="VL" value="<?=isset($emp_leave_info[0]['VL'])?$emp_leave_info[0]['VL']:''?>" min="0">											
        								</div>
        								</div>
										<div class="form-group">
										<label class="col-sm-3">LWP</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="LWP" name="LWP" value="<?=isset($emp_leave_info[0]['LWP'])?$emp_leave_info[0]['LWP']:''?>" min="0">											
        								</div>
										<label class="col-sm-3">STL</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="STL" name="STL" value="<?=isset($emp_leave_info[0]['STL'])?$emp_leave_info[0]['STL']:''?>" min="0">											
        								</div>
        								</div>
										<div class="form-group">
										<label class="col-sm-3">Total</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="Total" name="Total" value="<?=isset($emp_leave_info[0]['Total'])?$emp_leave_info[0]['Total']:''?>" min="0">											
        								</div>
        								</div>
        								</div>
        								</div>

        						</div>
        					</div>
							 
        				</div>
						<!-- end for leave-->
						
                                  </div>
				                                                                               
<div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <input type="submit" name="attend_submit" class="btn btn-primary form-control" value="Add Attendance">
                                        </div>
                                       
                                    </div>
                                  
                            </div>
                                    </form>
									</div>
									<?php 
									 /*  echo"<pre>";
	                                print_r($all_emp);
	                                echo"</pre>";
									echo"<pre>";
	                                print_r($attendance);
	                                echo"</pre>";  
	                               // die();  */
									?>							

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
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
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
	
	 $("#btnExport").click(function(e) {
		    window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
    e.preventDefault();
}); 

if($('#reporting_person').val()!=''){
	$('#leave_module').show();
}
  
});

function allowForLeave(){
	/* if($('#reporting_person').val()!=''){
		$('#leave_module').show();
	}else{
		$('#leave_module').hide();
	} */
	var sr_dt=$('#dob-datepicker').val();
	var post_data=search_dt='';
   if(sr_dt!=null){
				post_data+="&search_dt="+sr_dt;				
			}
		//alert(post_data);	
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/checkpunchingBackup",//check punching backup for searched month and year for availability of attendance
				data: encodeURI(post_data),
				success: function(data){
				//alert(data);
           if(data =='continue'){			   
			  $('#leave_module').show(); 
		   }
           if(data=='stop'){
			 $('#leave_module').hide(); 
              alert('You cant not add employee attendnce presently.You have to wait till Month end.');	
              $("#form")[0].reset();		 
		   }		   
            //$('#dj').html(data);
         
				}	
			});
	
}
</script>


