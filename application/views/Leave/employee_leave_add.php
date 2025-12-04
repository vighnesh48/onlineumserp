<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=site_url()?>assets/javascripts/jspdf/jspdf.js" type="text/javascript"></script>
<style>
.attexl table {
	border: 1px solid black;
}
.attexl table th {
	border: 1px solid black;
	padding: 5px;
	background-color: grey;
	color: white;
}
.attexl table td {
	border: 1px solid black;
	padding: 5px;
}
</style>
<script type="text/javascript">
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
                staffid:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Staff Id should not be empty.'
                      }
                    }
                },
                leave_type:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'leave type should not be empty'
                      }
                    }
                },
                 no_leave_allocate:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'No. of leave allocated should not be empty.'
                      }
                    },regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'No. of leave allocated should be numeric'
                      }
                },
                 year:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Year should not be empty'
                      }
                    }
                },
                 remark:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Remark should not be empty'
                      }
                    }
                }
				
            }       
        })
    });
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
	 $('#form').bootstrapValidator('revalidateField', 'staffid');
}
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
  <ul class="breadcrumb breadcrumb-page">
    <div class="breadcrumb-label text-light-gray">You are here: </div>
    <li><a href="#">Leaves</a></li>
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
      
            <div class="table-info">
              <div id="dashboard-recent" class="panel-warning">
                <div class="panel">
                  <div class="panel-heading"><strong>Employee Leave Allocation</strong></div>
                  <div class="panel-body"> 
                    <div class="panel-padding no-padding-vr">
                      <div class="form-group">
                        <div class="row"></div>
                        <div class="portlet-body form">
                         <form id="form" name="form" action="<?=base_url($currentModule.'/add_employee_leave_submit')?>" method="POST" enctype="multipart/form-data">
                              <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $err; ?></span>
                            <div class="form-body">
                            <div class="col-md-12">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="col-md-5 text-right">Staff Id</label>
                                <div class="col-md-5">
                                  <input type="text" class="form-control" name="staffid" value="" id="staffid" />
                                </div>
                                <div class="col-md-2">
                                <a href="#" class="btn btn-primary" id="semp" onClick="search_emp_code()"><span class="glyphicon glyphicon-search"></span></a>
                                <!--<input type="button" id="semp" onClick="search_emp_code()"  class="" value="Search"/>-->
                                </div>
                              </div>
                              <div class="form-group">
								<label class="col-md-5  text-right">Name</label>
                                             <div class="col-md-7" >
	 <input type="text" class="form-control" readonly name="ename" value="" id="nameid" />								   
                                       </div>			 
                                  </div>    
<div class="form-group">
								<label class="col-md-5  text-right">School </label>
                                             <div class="col-md-7" >
	 <input type="text" class="form-control" readonly name="school" value="" id="schoolid" />
                                       </div>
                                  </div>                                      
<div class="form-group">
								<label class="col-md-5  text-right">Department</label>
                                             <div class="col-md-7" >
	 <input type="text" class="form-control" readonly name="department" value="" id="departmentid" />
                                       </div>
                                  </div>  
								  <div class="form-group">
								<label class="col-md-5  text-right">Designation</label>
                                             <div class="col-md-7" >
	 <input type="text" class="form-control" readonly name="designation" value="" id="designationid" />
                                       </div>
                                  </div>  
                              <div class="form-group">
                                <label class="col-md-5 text-right">Leave Type</label>
                                <div class="col-md-7">
                                  <select class="select2me form-control" name="leave_type">
                                    <option value="">Select</option>
                                    <option value="CL">CL</option>
                                    <option value="EL">EL</option>
                                    <option value="ML">ML</option>                                   
                                    <option value="SL">SL</option>  
                                        <option value="Leave">Leave</option>                                
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-5 text-right">No. of Leave Assign</label>
                                <div class="col-md-7" >
                                  <input type="text" class="form-control" maxlength="3" name="no_leave_allocate" value=""/>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-5 text-right">Year</label>
                                <div class="col-md-7" >
								
                                  <select class="select2me form-control" name="year">
                                    <option value="">Select</option>
                                    <option <?php if($this->config->item('current_year2')=='2016-17') { echo 'selected'; } ?> value="2016-17">2016-17</option>
                                    <option <?php if($this->config->item('current_year2')=='2017-18') { echo 'selected'; } ?> value="2017-18">2017-18</option>
                                    <option <?php if($this->config->item('current_year2')=='2018-19') { echo 'selected'; } ?> value="2018-19">2018-19</option>
                                    <option <?php if($this->config->item('current_year2')=='2019-20') { echo 'selected'; } ?> value="2019-20">2019-20</option>
									<option <?php if($this->config->item('current_year2')=='2020-21') { echo 'selected'; } ?> value="2020-21">2020-21</option>
                                <option <?php if($this->config->item('current_year2')=='2021-22') { echo 'selected'; } ?> value="2021-22">2021-22</option>
								 <option <?php if($this->config->item('current_year2')=='2022-23') { echo 'selected'; } ?> value="2022-23">2022-23</option>
								 <option <?php if($this->config->item('current_year2')=='2023-24') { echo 'selected'; } ?> value="2023-24">2023-24</option>
								  <option <?php if($this->config->item('current_year2')=='2024-25') { echo 'selected'; } ?> value="2024-25">2024-25</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-5 text-right">Remark</label>
                                <div class="col-md-7">
                                  <textarea name="remark" class="form-control"></textarea>
                                </div>
                              </div>
                             
                            </div>
                        
                        
                        <div class="col-md-6" id="emptab"> </div>

                      </div>
                       
                              </div>
                              <div class="form-group">
                                <div class=" col-md-12 text-center">
                                  <button type="submit" class="btn btn-primary " >Submit</button>
                                
                                   <button class="btn btn-primary " id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/employee_leave_allocation'">Cancel</button></div>
                 </div></div>
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

<script type="text/javascript">

</script> 
