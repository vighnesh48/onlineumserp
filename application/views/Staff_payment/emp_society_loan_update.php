<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url()?>assets/javascripts/moment.js"></script>
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
 $(document).ready(function() {
        $('#amt_limt').keypress(function (event) {
            return isNumber(event, this)
        });
    });
	function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }    
    
</script>
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
        <li><a href="#">Staff payment</a></li>
        <li class="active"><a href="#">Co-Society Loan Update</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Co-Society Loan Update</h1>
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
                        <div class="table-info">                                        
                                                               
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Co-Society Loan Update</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/emp_society_loan_update_submit')?>"  method="POST"  enctype="multipart/form-data">
							   <input type="hidden" name="soc_id" value="<?php echo $society_loan_details[0]['soc_id'];?>"/>
							   
								<div class="form-body">
							
								        <div class="form-group">
										<div class="row">
										<div class="col-md-6">
										    
										     <div class="form-group">
                                <label class="col-md-6">Staff Id</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control" name="staffid" value="<?php echo $society_loan_details[0]['emp_id']; ?>" id="staffid" />
                                </div>
                                
                              </div>									
																	<div class="form-group">
								<label class="col-md-6">Name</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="ename" value="<?php if($society_loan_details[0]['gender'] == 'male'){ $m = 'Mr.'; }elseif($society_loan_details[0]['gender'] == 'female'){ $m='Mrs.'; }echo $m." ".$society_loan_details[0]['fname']." ".$society_loan_details[0]['lname']?>" id="nameid" />								   
                                       </div>			 
                                  </div>    
								 
<div class="form-group">
								<label class="col-md-6">School </label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="school" value="<?php echo $society_loan_details[0]['emp_id']; ?>" id="schoolid" />
                                       </div>
                                  </div>                      				  
								  <div class="form-group">
								<label class="col-md-6">Loan Amount </label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" required maxlength="5"   name="loan_amt" value="<?php echo $society_loan_details[0]['loan_amount']; ?>" id="amt" />
                                       </div>
                                  </div>  
						 <div class="form-group">
								<label class="col-md-6">Active From</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control"  name="active_form" required value="<?php echo date('Y-m',strtotime($society_loan_details[0]['from_month'])); ?>" id="active_form" />
                                       </div>
                                  </div> 
							  
								</div>
										
<div class="col-md-6">
<div class="form-group">
<label class="col-md-6">&nbsp;</label>
                                             <div class="col-md-6" >
	 &nbsp;
                                       </div>
</div>
<?php $ci =&get_instance();
   $ci->load->model('admin_model'); 
    $department =  $ci->admin_model->getDepartmentById($society_loan_details[0]['department']); 
		$school =  $ci->admin_model->getSchoolById($society_loan_details[0]['emp_school']); 							 
   ?>
<div class="form-group">
								<label class="col-md-6">Department</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="department" value="<?php echo $department[0]['department_name']; ?>" id="departmentid" />
                                       </div>
                                  </div>  
								  <div class="form-group">
								<label class="col-md-6">Designation</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="designation" value="<?php echo $school[0]['college_name']; ?>" id="designationid" />
                                       </div>
                                  </div> 
								  <div class="form-group">
								<label class="col-md-6">Monthly Deduction </label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" required maxlength="5"   name="mon_dec" value="<?php echo $society_loan_details[0]['monthly_deduction']; ?>" id="mon_dec" />
                                       </div>
                                  </div> 
								   <div class="form-group">
								<label class="col-md-6">Active To</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control"  name="active_to" required value="<?php echo date('Y-m',strtotime($society_loan_details[0]['to_month'])); ?>" id="active_to" />
                                       </div>
                                  </div> 	 								  
</div>									  
										</div>
												</div>
<div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                            <button type="submit" id="submit" class="btn btn-primary form-control" >Submit</button>
                                        </div>
                                        <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/emp_society_list'">Cancel</button></div>
                                  
                                    </div>					
                                    </form>									
									</div>   </div>
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
 $(function () {
                    $("#form").submit(function () {
                        var fromdate = new Date($("#active_form").val()); //Year, Month, Date
                        var todate = new Date($("#active_to").val()); //Year, Month, Date
                        if (todate > fromdate) {
                            return true;
                        } else {
                            return false;
                        }
                    });
                });
$(function(){
	 $('#active_form').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'yyyy-mm'
    });
 $('#active_to').datepicker({
       autoclose: true,
    minViewMode: 1,
    format: 'yyyy-mm'	
    });		
});
</script>


