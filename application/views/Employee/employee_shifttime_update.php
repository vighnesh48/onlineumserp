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
<script>    
 
</script>
<script type="text/javascript">
function getTime1(shift){
	//alert(shift);
	 var post_data='';
	var shiftid=shift;
           if(shiftid!=null){

				post_data+="&shiftid="+shift;
				
			}
 jQuery.ajax({
				type: "POST",
				url: '<?=base_url()?>employee/getshift',
				data: encodeURI(post_data),
				success: function(data){
					//alert(data);
					var sf = data.split('-');
			       $("#intime").val(sf[0]);
				   $("#outtime").val(sf[1]);
				}	
			});
}

function search_emp_code(){
	//alert('gg');
	$('#nameid').val('');
	$('#schoolid').val('');
	$('#departmentid').val('');
	$('#designationid').val('');
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
             
                    
                          
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Employee Reporting</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/update_employee_shifttime_submit')?>"  method="POST"  enctype="multipart/form-data">
							    <input type="hidden" name="id" value="<?=$emp_shift[0]['emp_shift_id']?>"/>
							    <?php 
							   echo $err;
							    ?>
								<div class="form-body">
							
								        <div class="form-group">
										<div class="row">
										<div class="col-md-6">
										<div class="form-group">
										<label class="col-md-6">Staff Id</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly  name="staffid" value="<?=isset($emp_shift[0]['emp_id'])?$emp_shift[0]['emp_id']:''?>" required id="staffid" />
                          
                                                  </div>                    

																	</div>
																	
											<div class="form-group">
								<label class="col-md-6">Name</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="ename" value="<?=$emp_shift[0]['fname']." ".$emp_shift[0]['lname']?>" id="nameid" />								   
                                       </div>			 
                                  </div>    
								  
<div class="form-group">
								<label class="col-md-6">School </label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="school" value="<?=$emp_shift[0]['college_name']?>" id="schoolid" />
                                       </div>
                                  </div>                                      
<div class="form-group">
								<label class="col-md-6">Department</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="department" value="<?=$emp_shift[0]['department_name']?>" id="departmentid" />
                                       </div>
                                  </div>  
								  <div class="form-group">
								<label class="col-md-6">Designation</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="designation" value="<?=$emp_shift[0]['designation_name']?>" id="designationid" />
                                       </div>
                                  </div> 																	
																	
																	
									  </div>
									  
										<div class="col-md-6" id="emptab">
									  </div>	
										</div>
																 
                                  </div>  
 						  
 <div class="form-group">
								<label class="col-md-3">Weekly Off</label>
                                             <div class="col-md-3" >
											 <select name="week_off" id="week_off" class="form-control" >
												<option value="">Select</option>
												<?php
													 $str=$str1=$str2=$str3=$str4=$str5=$str6="";
													 if($emp_shift[0]['week_off']=='Sunday'){
														 $str="selected";
														 }elseif($emp_shift[0]['week_off']=='Monday'){
															 $str1="selected";
															 }elseif($emp_shift[0]['week_off']=='Tuesday'){
															$str2="selected";	 
															 }elseif($emp_shift[0]['week_off']=='Wednesday'){
															$str3="selected";	 
															 }elseif($emp_shift[0]['week_off']=='Thursday'){
															$str4="selected";	 
															 }elseif($emp_shift[0]['week_off']=='Friday'){
															$str5="selected";	 
															 }elseif($emp_shift[0]['week_off']=='Saturday'){
															$str6="selected";	 
															 } ?>
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
								<label class="col-md-3">Shift </label>
                                             <div class="col-md-3" >
											<select name="shift" id="shift" class="form-control" onchange="getTime1(this.value)" >
												<option value="">Select Shift </option>
	                                           <?php foreach($shift_list as $sft ){
												if($sft['shift_id']==$emp_shift[0]['shift_id']){
													$str="selected";
												}else{$str="";}
												echo "<option ".$str." value=".$sft['shift_id'].">".$sft['shift_name']."</option>"?>
											<?php } ?>
                                                </select>
												
	                                                                  </div>								 
                                  </div>
								   <div class="form-group">
								<label class="col-md-3">In Time</label>
                                             <div class="col-md-3" >											
        										<input type="text" readonly class="form-control" name="intime" id="intime" placeholder="HH:MM:SS" value="<?php echo date("H:i",strtotime($emp_shift[0]['in_time']));?>" >
        							                         </div>								 
                                  </div>
								   <div class="form-group">
								<label class="col-md-3">Out Time</label>
                                             <div class="col-md-3" >
											<input type="text" readonly class="form-control" name="outtime" id="outtime" placeholder="HH:MM:SS" value="<?php echo date("H:i",strtotime($emp_shift[0]['out_time']));?>" >
        									   </div>								 
                                  </div> 							  
								
<div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" id="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>
                                        <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/emp_shift_time_list'">Cancel</button>
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
                    </div>
                </div>
            </div>    
        </div>
    