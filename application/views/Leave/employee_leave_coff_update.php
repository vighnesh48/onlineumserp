<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datetimepicker.min.js'?> "></script>
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
<script type="text/javascript">
$(document).ready(function(){
$("#datepicker1").datepicker({       
        autoclose: true,
		format: 'dd-mm-yyyy'
    });
});
function search_emp_coff(){
	var sid = $('#staffid').val();
	var edate = $('#datepicker1').val();
	$.ajax({
				type: "POST",
				url: "get_emp_coff/"+sid+"/"+edate,
				
				success: function(data){
				//	alert(data);          
            $('#empcoff').html(data);
         
				}	
			});
}
function search_emp_code(){
	//alert('gg');
	var post_data = $('#staffid').val();
	$.ajax({
				type: "POST",
				url: "get_emp_code/"+post_data,
				
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
function validateForm() {
    //var si = document.forms["form"]["staffid"].value;
	//var dt = document.forms["form"]["date"].value;
	var st = document.forms["form"]["status"].value;
	var rm = document.forms["form"]["remark"].value;
     if (rm == "") {
        alert("Remark should not be empty");
        return false;
    }else if(st == ""){
		alert("Select Status");
        return false;
	}
} 

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Leaves</a></li>
        <li class="active"><a href="#">Employee C-Off</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee C-Off </h1>
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
                            	<div class="panel-heading"><strong>Employee C-Off</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" onsubmit="return validateForm()" action="<?=base_url($currentModule.'/update_employee_coff')?>" method="POST" enctype="multipart/form-data">
							    	<input type="hidden" name="id"  value="<?=isset($leave[0]['id'])?$leave[0]['id']:''?>" id="id" />
                               
								
								<div class="form-body">
								<div class="col-md-6">
								        <div class="form-group">
								<label class="col-md-6">Staff Id</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" name="staffid" readonly value="<?=isset($leave[0]['emp_id'])?$leave[0]['emp_id']:''?>" id="staffid" />
                               
									     
									   
                                       </div>
									   
									 
                                  </div>    
<div class="form-group">
								<label class="col-md-6">Name</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="ename" value="<?=$leave[0]['fname']." ".$leave[0]['lname']?>" id="nameid" />								   
                                       </div>			 
                                  </div>    
								  <?php $ci =&get_instance();
   $ci->load->model('admin_model');
    $department =  $ci->admin_model->getDepartmentById($leave[0]['department']); 
		$school =  $ci->admin_model->getSchoolById($leave[0]['emp_school']); 
		$designation =  $ci->admin_model->getDesignationById($leave[0]['designation']); 
								 
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
                                  <div class="form-group">
								<label class="col-md-6">Date</label>
                                             <div class="col-md-6" >
	<input class="form-control" id="datepicker1" name="date" readonly value="<?=date('d-m-Y',strtotime($leave[0]['date']))?>"   type="text" >
        									                            
                                       </div>
                                  </div>
                                   <?php if($leave[0]['is_special_case']=='Y'){ ?>
                    
                    <div class="form-group">
                <label class="col-md-6">Special Case</label>
                                             <div class="col-md-6" >
  <input  name="special_case" readonly value="Y" checked   type="checkbox" >
                                                      
                                       </div>
                                  </div>
                  <div class="form-group">
                <label class="col-md-6">Upload File</label>
                                             <div class="col-md-6" >
  <a href="<?php echo base_url(); ?>leave/download/<?php echo $leave[0]['file_path']; ?>" ><?php echo $leave[0]['file_path']; ?></a>                                                  
                                       </div>
                                  </div>
                    
                  <?php } ?>
<div class="form-group">
	 <label class="col-md-6">Status</label>
	  <div class="col-md-6" >
	  <select class="form-control form-control-inline" name="status"  type="text">
													<option value="">Select</option>												
													<option <?php if($leave[0]['status']=='Cancel'){echo 'Selected'; } ?> value="Cancel">Cancel</option>
													</select> </div>                                       
                                    </div>		 
	 <div class="form-group">
								<label class="col-md-6">Remark</label>
                                             <div class="col-md-6" >
	 <textarea name="remark" class="form-control"><?=$leave[0]['remark']?></textarea>
                                       </div>
                                  </div> <div class="form-group">
								   <div class="col-md-6" ></div>
                                      <div class=" col-md-3">  
                                            <button type="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div> 
<div class=" col-md-3">  
                                            <button type="button" class="btn btn-primary form-control" onclick="window.location='<?=base_url($currentModule)?>/employee_coff_list'" >Cancel</button>
                                        </div>  										
                                    </div>						
							  
                            </div>
                                    </form>
									</div>
									 <div class="col-md-6" id="emptab">
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
</div>



