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
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Mobile Update</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Mobile Update</h1>
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
                            	<div class="panel-heading"><strong>Mobile Update</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/employee_mobile_master_update_submit')?>"  method="POST"  enctype="multipart/form-data">
							    <input type="hidden" name="mobile_id" value="<?php echo $mobile_details[0]['mob_id'];?>"/>
							   
								<div class="form-body">
							
								        <div class="form-group">
										<div class="row">
										<div class="col-md-6">
										    
										     <div class="form-group">
                                <label class="col-md-6">Staff Id</label>
                                <div class="col-md-4">
							
                                  <input type="text"  class="form-control" name="staffid" value="<?php echo $mobile_details[0]['emp_id'];?>" id="staffid" />
                                </div>
                                
                              </div> 								<div class="form-group">
								<label class="col-md-6">Name</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="ename" value="<?php if($mobile_details[0]['gender'] == 'male'){ $m = 'Mr.'; }elseif($mobile_details[0]['gender'] == 'female'){ $m='Mrs.'; }echo $m." ".$mobile_details[0]['fname']." ".$mobile_details[0]['lname']?>" id="nameid" />								   
                                       </div>			 
                                  </div>    
								  <?php $ci =&get_instance();
   $ci->load->model('admin_model'); 
    $department =  $ci->admin_model->getDepartmentById($mobile_details[0]['department']); 
		$school =  $ci->admin_model->getSchoolById($mobile_details[0]['emp_school']); 
		$designation =  $ci->admin_model->getDesignationById($mobile_details[0]['designation']); 
								 
   ?>
<div class="form-group">
								<label class="col-md-6">School </label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control" readonly name="school" value="<?=$school[0]['college_name']?>" id="schoolid" />
                                       </div>
                                  </div>                             				  
								  
						  <div class="form-group">
								<label class="col-md-6">Mobile No</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control"  name="mobile_no" maxlength="10"  pattern="[0-9]{10}" value="<?php echo $mobile_details[0]['mobile']; ?>" id="mobile_no" />
                                       </div>
                                  </div> 		
                                  <div class="form-group">
                <label class="col-md-6">Deduction Required</label>
                                             <div class="col-md-6" >
   <input type="radio"   name="dect_req" <?php if($mobile_details[0]['allow_for_Deduct']=='Y'){ echo 'Checked' ; } ?> value="Y" /> Yes
   <input type="radio"  name="dect_req" <?php if($mobile_details[0]['allow_for_Deduct']=='N'){ echo 'Checked' ; } ?> value="N" /> No
                                       </div>
                                  </div>      						 
								</div>
										<div class="col-md-6" id="emptab">
										
									  </div>
<div class="col-md-6">
<div class="form-group">
<label class="col-md-6">&nbsp;</label>
                                             <div class="col-md-6" >
	 &nbsp;
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
								<label class="col-md-6">Amount Limit</label>
                                             <div class="col-md-6" >
	 <input type="text" class="form-control"  name="amt_limt" required maxlength="5" value="<?php echo $mobile_details[0]['mobile_limit']; ?>" id="amt_limt" />
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
                                        <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/emp_mobile_bill_list'">Cancel</button></div>
                                  
                                    </div>							
                                    </form>									
									</div>    </div>
							   </div>
                                </div>
                            </div> 
                          </div>                           
                        </div>
                    </div>
                </div>
            </div>    
        </div>
  