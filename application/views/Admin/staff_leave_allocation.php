<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=site_url()?>assets/javascripts/jspdf/jspdf.js" type="text/javascript"></script>

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
        <li class="active"><a href="#">Employee Leave Allocation</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Leave Allocation</h1>
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
                            	<div class="panel-heading"><strong>Employee Leave Allocation</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/staff_leave_allocation')?>" method="POST" enctype="multipart/form-data">
							    <?php if(!empty($emp_leave_info)){ //print_r($emp_leave_info);?>
								
								<input type="hidden" name="inupdate" value="1">
								
                                <?php } ?>								
								<div class="form-body">
								<div class="form-group">
								<label class="col-md-3">Select School</label>
                                             <div class="col-md-3" >
	 <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value)" id="reporting_school" >
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
      <select class="form-control select2me" id="department"  onchange="getEmp_using_dept_forleave_allocation(this.value)" name="department" >
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
        									<select class="form-control select2me" id="reporting_person" name="employee" onchange="allowForLeave()" >
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
        								<i class="fa fa-edit"></i>Leave Allocation For Employee
        							</div>

        						</div>
        						<div class="portlet-body">
								<div class="form-group">
								<?php //echo $get_quarter;
                                 $str1=$str2=$str3=$str4='readonly';								
								if(!empty($get_quarter) && $get_quarter==1){
									$str1="";
								}else if(!empty($get_quarter) && $get_quarter==2){
									$str2="";
								}else if(!empty($get_quarter) && $get_quarter==3){
									$str3="";
								}else if(!empty($get_quarter) && $get_quarter==4){
									$str4="";
								}
								?>
								
		                                    <label class="col-sm-3">Vacation Leaves</label>
										<div class="col-sm-9">	
										<table><thead><th>Slot I<?php if($get_quarter==1) echo'&nbsp;&nbsp;<b style="color:red">[ Active ]</b>';else '';?></th><th>Slot II</th><th>Slot III</th><th>Slot IV</th></thead>
                                        <tr>
<td><input <?=$str1?> type="number" id="vslot1" name="vslot1" value="<?=isset($emp_leave_info[0]['vslot1'])?$emp_leave_info[0]['vslot1']:''?>" min="0"></td>
<td><input <?=$str2?> type="number" id="vslot2" name="vslot2" value="<?=isset($emp_leave_info[0]['vslot2'])?$emp_leave_info[0]['vslot2']:''?>"min="0"></td>
<td><input <?=$str3?> type="number" id="vslot3" name="vslot3" value="<?=isset($emp_leave_info[0]['vslot3'])?$emp_leave_info[0]['vslot3']:''?>"min="0"></td>
<td><input <?=$str4?> type="number" id="vslot4" name="vslot4" value="<?=isset($emp_leave_info[0]['vslot4'])?$emp_leave_info[0]['vslot4']:''?>"min="0"></td>
										</tr>     
											</table>
											</div>
                                             </div>
								<div class="form-group">
		                                    <label class="col-sm-3">CL</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="cnt_cl" name="cnt_cl" value="<?=isset($emp_leave_info[0]['cnt_cl'])?$emp_leave_info[0]['cnt_cl']:''?>" min="0">											
        								</div>
										<label class="col-sm-3">C-OFF</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="cnt_coff" name="cnt_coff" value="<?=isset($emp_leave_info[0]['cnt_coff'])?$emp_leave_info[0]['cnt_coff']:''?>" min="0">											
        								</div>
        								</div>										
										<div class="form-group">
										<label class="col-sm-3">EL</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="cnt_el" name="cnt_el" value="<?=isset($emp_leave_info[0]['cnt_el'])?$emp_leave_info[0]['cnt_el']:''?>" min="0">											
        								</div>
											<label class="col-sm-3">ML</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="cnt_ml" name="cnt_ml" value="<?=isset($emp_leave_info[0]['cnt_ml'])?$emp_leave_info[0]['cnt_ml']:''?>" min="0">											
        								</div>
        								</div>
										<div class="form-group">
										<label class="col-sm-3">VL</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="cnt_vl" name="cnt_vl" value="<?=isset($emp_leave_info[0]['cnt_vl'])?$emp_leave_info[0]['cnt_vl']:''?>" min="0">											
        								</div>
											<label class="col-sm-3">SL</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="cnt_sl" name="cnt_sl" value="<?=isset($emp_leave_info[0]['cnt_sl'])?$emp_leave_info[0]['cnt_sl']:''?>" min="0">											
        								</div>
        								</div>
										<div class="form-group">
										<label class="col-sm-3">Leave</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="cnt_leave" name="cnt_leave" value="<?=isset($emp_leave_info[0]['cnt_leave'])?$emp_leave_info[0]['cnt_leave']:''?>" min="0">											
        								</div>
											<label class="col-sm-3">LWP</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="cnt_lwp" name="cnt_lwp" value="<?=isset($emp_leave_info[0]['cnt_lwp'])?$emp_leave_info[0]['cnt_lwp']:''?>" min="0">											
        								</div>
        								</div>
										<div class="form-group">
										<label class="col-sm-3">STL</label>
                                 <div class="col-sm-3">											
                                      <input type="number" id="cnt_leave" name="cnt_leave" value="<?=isset($emp_leave_info[0]['cnt_stl'])?$emp_leave_info[0]['cnt_stl']:''?>" min="0">											
        								</div>
        								</div>
        								</div>
        								</div>

        						</div>
        					</div>
							 <div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <input type="submit" name="submit" class="btn btn-primary form-control" value="Add Leaves">
                                        </div>
                                       
                                    </div>
        				</div>
						<!-- end for leave-->
						
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
	if($('#reporting_person').val()!=''){
		$('#leave_module').show();
	}else{
		$('#leave_module').hide();
	}
	var emp_id=$('#reporting_person').val();
	var post_data=empl_id='';
   if(emp_id!=null){
				post_data+="&empl_id="+emp_id;				
			}
			
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getjoiningdtEmp",
				data: encodeURI(post_data),
				success: function(data){
				//	alert(data);          
            $('#dj').html(data);
         
				}	
			});
	
}
</script>


