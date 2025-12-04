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
                vacation_type:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select vacation type.'
                      }
                    }
                },
                slot_type:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select Slot'
                      }
                    }
                },
                 from_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select From Date.'
                      }
                    }
                },
                 to_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select To date'
                      }
                    }
                }
				
            }       
        })
    });


</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
  <ul class="breadcrumb breadcrumb-page">
    <div class="breadcrumb-label text-light-gray">You are here: </div>
    <li><a href="#">Leaves</a></li>
    <li class="active"><a href="#">Vacation Slot </a></li>
  </ul>
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Vacation Slot Edit</h1>
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
                  <div class="panel-heading"><strong>Vacation Slot Edit</strong></div>
                  <div class="panel-body"> 
                    <div class="panel-padding no-padding-vr">
                      <div class="form-group">
                        <div class="row"></div>
                        <div class="portlet-body form">
                          <form id="form" name="form" action="<?=base_url($currentModule.'/update_vl_assign_emp_submit')?>" method="POST" enctype="multipart/form-data">
                             
                              <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->userdata('err'); ?></span>
                            
<input type="hidden" name="id" value="<?php echo $vl_assign_emp[0]['id']; ?>" />
                              <div class="form-group">
                                <label class="col-md-3 text-right">Academic Year</label>
                                <div class="col-md-3">
                                  <input type="text" class="form-control" name="academic_year" id="academic_year" value="<?php echo $vl_assign_emp[0]['academic_year']; ?>" readonly  />
                                </div>                                
                              </div>
							  <div class="form-group">
                                <label class="col-md-3 text-right">Employee ID</label>
                                <div class="col-md-3">
                                  <input type="text" class="form-control" name="emp_id" value="<?php echo $vl_assign_emp[0]['employee_id']; ?>" readonly  />
                                </div>                                
                              </div>
							  <?php
							  $ci =&get_instance();
                          $ci->load->model('admin_model');
							  $emp = $ci->admin_model->getEmployeeById($vl_assign_emp[0]['employee_id'],'Y');	
							 $department =  $ci->admin_model->getDepartmentById($emp[0]['department']); 
								 $school =  $ci->admin_model->getSchoolById($emp[0]['emp_school']); 
					
							  ?>
							  <div class="form-group">
                                <label class="col-md-3 text-right">Name</label>
                                <div class="col-md-3">
                                  <input type="text" class="form-control" name="emp_name" value="<?php if($emp[0]['gender']=='male'){echo 'Mr.';}else if($emp[0]['gender']=='female'){ echo 'Mrs.';} ?><?=$emp[0]['fname']." ".$emp[0]['lname']?>" readonly  />
                                </div>                                
                              </div>
							  <div class="form-group">
                                <label class="col-md-3 text-right">School</label>
                                <div class="col-md-3">
                                  <input type="text" class="form-control" name="emp_school" value="<?=$school[0]['college_code']?>" readonly  />
                                </div>                                
                              </div>
							  <div class="form-group">
                                <label class="col-md-3 text-right">Department</label>
                                <div class="col-md-3">
                                  <input type="text" class="form-control" name="emp_dep" value="<?=$department[0]['department_name']?>" readonly  />
                                </div>                                
                              </div>
							  <?php 
							  $chk_lev = $this->leave_model->check_applyed_leaves($vl_assign_emp[0]['id']);
if(count($chk_lev) == '0'){
							 ?>
							  
                              <div class="form-group">
								<label class="col-md-3  text-right">Vacation Type</label>
                                             <div class="col-md-3" >
	 <input  class="form-control" id="vacation_type" type="text" name="vacation_type" value="<?php echo $vl_assign_emp[0]['vacation_type']; ?>" readonly />							   
                                       </div>			 
                                  </div>    
<div class="form-group">
								<label class="col-md-3  text-right">Slot Type </label>
                                             <div class="col-md-3" >
	 <select  class="form-control" onchange="display_dates(this.value)" id="slot_type" name="slot_type"><option value="">Select</option>
<?php  $vt = $this->leave_model->get_vacation_leave_slot_list($vl_assign_emp[0]['academic_year'],$vl_assign_emp[0]['vacation_type']); 
     foreach ($vt as $key => $value) {
         echo "<option value='".$value['slot_type']."'>".$value['slot_type']."</option>";
     } ?>
   </select>							   
                                       </div>
                                  </div>  
<?php }else{ ?>

<div class="form-group">
                                <label class="col-md-3 text-right">Vacation Type</label>
                                <div class="col-md-3">
                                  <input type="text" class="form-control" name="vacation_type" value="<?php echo $vl_assign_emp[0]['vacation_type'];?>" readonly  />
                                </div>                                
                              </div>
							  <div class="form-group">
                                <label class="col-md-3 text-right">Slot Type</label>
                                <div class="col-md-3">
                                  <input type="text" class="form-control" name="slot_type" value="<?php echo $vl_assign_emp[0]['slot_type'];?>" readonly  />
                                </div>                                
                              </div>
<?php } ?>								  
<div class="form-group">
								<label class="col-md-3  text-right">From Date</label>
                                             <div class="col-md-3" >
	 <input type="text" class="form-control" name="from_date" id="frmdt-datepicker" value="<?php echo date('d-m-Y',strtotime($vl_assign_emp[0]['from_date'])); ?>" readonly />
                                       </div>
                                  </div>  
								  <input type="hidden" name="vid" id="vid" value="<?php echo $vl_assign_emp[0]['vid'] ?>"/>
								  <div class="form-group">
								<label class="col-md-3  text-right">To Date</label>
                                             <div class="col-md-3" >
	 <input type="text" class="form-control"  name="to_date" id="todt-datepicker" value ="<?php echo date('d-m-Y',strtotime($vl_assign_emp[0]['to_date'])); ?>" readonly />
                                       </div>
                                  </div>  
                              <div class="form-group">
                                <label class="col-md-3 text-right">No.Of Days</label>
                                <div class="col-md-3">
                                  	 <input type="text" class="form-control"  name="no_days" id="no_days" readonly value ="<?php echo $vl_assign_emp[0]['no_days']; ?>"  />
                                </div>
                              </div>
                             
                              <div class="form-group">
                                <div class="col-md-3"></div>
                                <div class=" col-md-2">
                                  <button type="submit" class="btn btn-primary form-control" >Submit</button>
                                </div>
                                   <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/vl_slot_list'">Cancel</button></div>
                 
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
//display_slot('<?=$vl_assign_emp[0]['vacation_type']?>');
function display_dates(st){
	var yer = $('#academic_year').val();
	var vl = $('#vacation_type').val();
	$.ajax({
				type: "POST",
				url: "<?php echo base_url().$currentModule; ?>/get_vl_info/"+yer+"/"+vl+"/"+st,
				success: function(data){
					//alert(data);          
            var exp = data.split('/');
         $('#frmdt-datepicker').val(exp[0]);
		 $('#todt-datepicker').val(exp[1]);
		 $('#no_days').val(exp[2]);
		 $('#vid').val(exp[3]);
				}	
			});
}
function display_slot(vt){
	if(vt=='winter'){
		var opt = "<option value=''>Select</option><option <?php if($vl_assign_emp[0]['slot_type']=='I'){ echo 'selected'; } ?> value='I'>I</option><option <?php if($vl_assign_emp[0]['slot_type']=='II'){ echo 'selected'; } ?> value='II'>II</option>";
    			$('#slot_type option').remove();
				$('#slot_type').append(opt);
	}else if(vt=='summer'){
		var opt = "<option value=''>Select</option><option <?php if($vl_assign_emp[0]['slot_type']=='III'){ echo 'selected'; } ?> value='III'>III</option><option <?php if($vl_assign_emp[0]['slot_type']=='IV'){ echo 'selected'; } ?> value='IV'>IV</option>";
    			$('#slot_type option').remove();
				$('#slot_type').append(opt);
	}
}

</script> 
