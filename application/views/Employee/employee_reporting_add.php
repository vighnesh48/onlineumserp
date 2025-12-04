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
<script>    
    $(document).ready(function()
    {
       
       $("#submit").click(function(){
            var sid = $('#staffid').val();
              var favorite = [];
var f = 0;

            $.each($("input[name='ch[]']:checked"), function(){            

                favorite.push($(this).val());

            });
           
            fLen = favorite.length;
           // alert(favorite);
            for (i = 0; i < fLen; i++) {
                var kk = $('#reporting_person'+favorite[i]).val();
              //  alert(kk);
                if(kk == ''){
                    f = favorite[i];
   
                }
}
if(f!=0){
     alert('select reporting '+f);
  return false;
}
 if(sid == null || sid == ''){
	alert('select Staff Id');
  return false; 
 }      
       });
       

		
});
 function getEmp_using_dept1(dept_id,sid,did){
var e = document.getElementById(sid);
var school_id = e.options[e.selectedIndex].value;
var post_data='';
if(school_id!=null && dept_id!=null){
               
				post_data+="&school="+school_id+"&department="+dept_id;
				
			}
        
jQuery.ajax({
				type: "POST",
				url: base_url+"Employee/getEmpListDepartmentSchool1",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				$('#'+did).html(data);
         		}	
			});

}
 
function getdept_using_school1(school_id,did,pid){
//alert(school_id);
 var post_data=schoolid='';
	var schoolid=school_id;
	if(schoolid=='V'){
		
		$('#'+did).html('<option value="v">Visiting</option>');
		jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getvisitinglist",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				   //alert(did);     
            //$('#reporting_dept').append(data);
            $('#'+pid).html(data);
           //$("#dept-emp").html(emp_list);
				}	
			});
	}else{
           if(school_id!=null){

				post_data+="&school_id="+schoolid;
				
			}
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getdepartmentByschool",
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
				        
            //$('#reporting_dept').append(data);
            $('#'+did).html(data);
           //$("#dept-emp").html(emp_list);
				}	
			});
}
	
}
</script>
<script type="text/javascript">
function check_sel_rep(chk){
    var f ;
    if($("#"+chk).is(':checked')) {
     if(chk > 1){
         for(var i=1;i<chk;i++){
        if($("#"+i).is(':checked')){
   f = 0; // checked
}else{
    f = 1;
   $("#"+chk).prop('checked', false); 
    }
         }
        if(f==1){
            alert('select previous reporting');
        }
    }
    }else{
         for(var i=chk;i<=4;i++){
        $("#"+i).prop('checked', false); 
         }
    }  
    }
function search_emp_code(){
	//alert('gg');
	var post_data = $('#staffid').val();
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>leave/get_emp_code/"+post_data,
				
				success: function(data){
				//	alert(data);          
            $('#emptab').html(data);
         
				}	
			});
	
}
function insert_emp_id(emp,nme,sch,dep,des){
	//alert(emp);
	$('#staffid').val(emp);
	$('#nameid').val(nme);
	$('#schoolid').val(sch);
	$('#departmentid').val(dep);
	$('#designationid').val(des);
	$("#etable").remove();
}
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Employee Reporting</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Reporting</h1>
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
                            	<div class="panel-heading"><strong>Employee Reporting</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/update_employee_reporting_submit')?>"  method="POST"  enctype="multipart/form-data"  onsubmit="return validateForm()">
							    <input type="hidden" name="er_id" value=""/>
							    <?php 
							   echo $err;
							    ?>
								<div class="form-body">
							
								        <div class="form-group">
										<div class="row">
										<div class="col-md-6">
										    
										     <div class="form-group">
                                <label class="col-md-6">Staff Id</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control" name="staffid" value="" id="staffid" />
                                </div>
                                <div class="col-md-2 text-right">
                                <a href="#" class="btn btn-primary" id="semp" onClick="search_emp_code()"><span class="glyphicon glyphicon-search"></span></a>
                                <!--<input type="button" id="semp" onClick="search_emp_code()"  class="" value="Search"/>-->
                                </div>
                              </div>
										    
										    
										    
									
																	<div class="form-group">
								<label class="col-md-6">Name</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="ename" value="<?=$emp_shift[0]['fname']." ".$emp_shift[0]['lname']?>" id="nameid" />								   
                                       </div>			 
                                  </div>    
								  <?php $ci =&get_instance();
   $ci->load->model('admin_model'); 
    $department =  $ci->admin_model->getDepartmentById($emp_shift[0]['department']); 
		$school =  $ci->admin_model->getSchoolById($emp_shift[0]['emp_school']); 
		$designation =  $ci->admin_model->getDesignationById($emp_shift[0]['designation']); 
								 
   ?>
<div class="form-group">
								<label class="col-md-6">School </label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="school" value="<?=$school[0]['college_name']?>" id="schoolid" />
                                       </div>
                                  </div>                                      
<div class="form-group">
								<label class="col-md-6">Department</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="department" value="<?=$department[0]['department_name']?>" id="departmentid" />
                                       </div>
                                  </div>  
								  <div class="form-group">
								<label class="col-md-6">Designation</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="designation" value="<?=$designation[0]['designation_name']?>" id="designationid" />
                                       </div>
                                  </div>  		
																	
									  </div>
										<div class="col-md-6" id="emptab">
									  </div>	
										</div>
																 
                                  </div>  
 						  
 <!--<div class="form-group">
								<label class="col-md-3">Weekly Off</label>
                                             <div class="col-md-3" >
											 <select name="week_off" id="week_off" class="form-control" >
												<option value="">Select</option>
												<?php
												/*	 $str=$str1=$str2=$str3=$str4=$str5=$str6="";
													 if($emp_rep_details[0]['weekly_off']=='Sunday'){
														 $str="selected";
														 }elseif($emp_rep_details[0]['weekly_off']=='Monday'){
															 $str1="selected";
															 }elseif($emp_rep_details[0]['weekly_off']=='Tuesday'){
															$str2="selected";	 
															 }elseif($emp_rep_details[0]['weekly_off']=='Wednesday'){
															$str3="selected";	 
															 }elseif($emp_rep_details[0]['weekly_off']=='Thursday'){
															$str4="selected";	 
															 }elseif($emp_rep_details[0]['weekly_off']=='Friday'){
															$str5="selected";	 
															 }elseif($emp_rep_details[0]['weekly_off']=='Saturday'){
															$str6="selected";	 
															 } */?>
	                                             <option <?=$str?> value="Sunday">Sunday</option>
	                                             <option <?=$str1?> value="Monday">Monday</option>
	                                             <option <?=$str2?> value="Tuesday">Tuesday</option>
	                                             <option <?=$str3?> value="Wednesday">Wednesday</option>
	                                              <option <?=$str4?> value="Thursday">Thursday</option>
	                                               <option <?=$str5?> value="Friday">Friday</option>
	                                               <option <?=$str6?> value="Saturday">Saturday</option>
                                                  </select>	
												
	                                                                  </div>								 
                                  </div>
								   <div class="form-group">
								<label class="col-md-3">Shift</label>
                                             <div class="col-md-3" >
											<select name="shift" id="shift" class="form-control" onchange="getTime(this.value)" >
												<option value="">Select Shift </option>
	                                           <?php /*foreach($shift_list as $sft ){
												if($sft['shift_id']==$emp_rep_details[0]['shift']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$sft['shift_id'].">".$sft['shift_name']."</option>"?>
											<?php } */?>
                                                </select>
												
	                                                                  </div>								 
                                  </div>
								   <div class="form-group">
								<label class="col-md-3">In Time</label>
                                             <div class="col-md-3" >
												<?php /*
												      $time=strtotime($emp_rep_details[0]['in_time']);
												     $data_print=date("h:i",$time); */
													// echo $emp[0]['intime']; 
													// echo  $data_print; 
												?>
        										<input type="text" class="form-control" name="intime" id="intime" placeholder="HH:MM:SS" value="<?php echo date("h:i",strtotime($emp_rep_details[0]['in_time']));?>" >
        							
												
	                                                                  </div>								 
                                  </div>
								   <div class="form-group">
								<label class="col-md-3">Out Time</label>
                                             <div class="col-md-3" >
											<input type="text" class="form-control" name="outtime" id="outtime" placeholder="HH:MM:SS" value="<?php echo date("h:i",strtotime($emp_rep_details[0]['outtime']));?>" >
        									   </div>								 
                                  </div> */-->
								<div class="form-group">
								<label class="col-md-3">Leave Route</label>
								<div class="col-md-3">
								<input type="checkbox" name="route[]" id="route1" value="1"  /> Route1 (OD/Leave/CL/Vacation) &nbsp;&nbsp;
								<input type="checkbox" name="route[]" id="route2" value="2"  /> Route2 (EL/ML)
								</div>
								</div>
								  
								  <div class="form-group">
								  <table id="emp-table-od" class="table table-bordered table-striped">
								  <tr><td></td><td>Reporting <br>Level</td><td>Reporting School</td><td>Reporting Department</td><td>Person Name</td></tr>
       
<?php for($i=1;$i<=4;$i++){?>
	   <tr><td><input type='checkbox' value='<?php echo $i;?>' <?php if($i==1){ echo 'required'; } ?>  onclick='check_sel_rep(<?php echo $i;?>)' id='<?php echo $i;?>' name='ch[]'></td>
	       <td><?php echo $i; ?></td>
		<td><select class="select2me form-control" name="report_school<?php echo $i;?>" <?php if($i==1){ echo 'required'; } ?> onchange="getdept_using_school1(this.value,'reporting_dept<?php echo $i;?>','reporting_person<?php echo $i;?>')" id="reporting_school<?php echo $i;?>" >
													  <option value="">Select</option>
													<?php foreach($school_list as $sc ){
												if($sc['college_id']==$emp_rep_details[0]['report_school']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$sc['college_id'].">".$sc['college_name']."</option>"?>
											<?php } ?>
											<option value="V">Visiting </option>
											</select> </td>
											<td>
											<select name="report_department" id="reporting_dept<?php echo $i;?>" <?php if($i==1){ echo 'required'; } ?> onchange="getEmp_using_dept1(this.value,'reporting_school<?php echo $i;?>','reporting_person<?php echo $i;?>')" class="form-control" >
												<option value="">Select</option>
												<?php 
                                                 if(!empty($emp_rep_details[0]['report_school'])){
												$dept_list=$this->Admin_model->getDepartmentListById($emp_rep_details[0]['report_school']);	
                                               foreach($dept_list as $dept ){
												if($dept['department_id']==$emp_rep_details[0]['report_department']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$dept['department_id'].">".$dept['department_name']."</option>" ;												
												 }
                								
											 } ?>
												</select>
											</td>
											<td>
											<select class="select2me form-control"  name="report_person<?php echo $i;?>" id="reporting_person<?php echo $i;?>" >
													  <option value="">Select</option>
												<?php 
													 if(!empty($emp_rep_details[0]['report_person'])){
												$ro=$this->Admin_model->getSchoolDepartmentWiseEmployeeList($emp_rep_details[0]['report_school'],$emp_rep_details[0]['report_department']);
												//print_r($ro);
												foreach($ro as $r ){
												if($r['emp_id']==$emp_rep_details[0]['report_person']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$r['emp_id'].">".$r['fname'].' '.$r['mname'].' '.$r['lname']."</option>" ;												
													 }
													 }
												?>     										
												
											</select>
											</td></tr>
											
<?php } ?>
  </table>
								  
								  
								  
								  
								
<div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" id="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>
                                        <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/employee_reporting'">Cancel</button></div>
                                  
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
    </div>
</div>


<script type="text/javascript">

$(document).ready(function() {
	
	$("#semp_rep_details").click(function() {
//alert('gg');
	var post_data = $('#staffid').val();
	jQuery.ajax({
				type: "POST",
				url: base_url+"leave/get_emp_rep_details_code/"+post_data,
				
				success: function(data){
				//	alert(data);          
            $('#emp_rep_detailstab').html(data);
         
				}	
			});
	});

    $("#etable td").click(function() {
        alert("You clicked my <td>! My TR is:");
        //get <td> element values here!!??
    });
});​


function validateForm() {
            var checkboxes = document.getElementsByName('route[]');
            var checked = false;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checked = true;
                    break;
                }
            }
            if (!checked) {
                alert('Please select at least one leave route.');
                return false;
            }
            return true;
        }
</script>


