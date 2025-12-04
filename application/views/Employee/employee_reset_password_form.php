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

<script type="text/javascript">
 
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
        <li><a href="#">Employee</a></li>
        <li class="active"><a href="#">Employee Reset Password</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Reset Password</h1>
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
                            	<div class="panel-heading"><strong>Employee Reset Password</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/employee_reset_password_submit')?>"  method="POST"  enctype="multipart/form-data">
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
                                  <input type="text" class="form-control" required name="staffid" value="" id="staffid" />
                                </div>
                                <div class="col-md-2 text-right">
                                <a href="#" class="btn btn-primary" id="semp" onClick="search_emp_code()"><span class="glyphicon glyphicon-search"></span></a>
                                <!--<input type="button" id="semp" onClick="search_emp_code()"  class="" value="Search"/>-->
                                </div>
                              </div>
										    
										    
										    
									
																	<div class="form-group">
								<label class="col-md-6">Name</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly required name="ename" value="" id="nameid" />								   
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
								
<div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" id="submit" class="btn btn-primary form-control" >Reset</button>
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
</script>


