<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
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
      <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Vacation Slot Add</h1>
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
                  <div class="panel-heading"><strong>Vacation Slot Add</strong></div>
                  <div class="panel-body"> 
                    <div class="panel-padding no-padding-vr">
                      <div class="form-group">
                        <div class="row"></div>
                        <div class="portlet-body form">
                          <form id="form" name="form" action="<?=base_url($currentModule.'/add_vacation_slot_submit')?>" method="POST" enctype="multipart/form-data">
                             <?php echo $this->session->userdata('err'); ?>
                              <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $err; ?></span>
<div class="form-group">
							  <div class="col-md-6">
                              <div class="form-group">
                                <label class="col-md-4 text-right">Academic Year</label>
                                <div class="col-md-8">
                                  <input type="text" class="form-control" name="academic_year" value="<?php echo $this->config->item('current_year2'); ?>" readonly  />
                                </div>
                                
                              </div>
                              <div class="form-group">
								<label class="col-md-4  text-right">Vacation Type</label>
                                             <div class="col-md-8" >
	 <select  class="form-control"  onchange="display_slot(this.value)" name="vacation_type" id="vacation_type"><option value="">Select</option><option value="winter">Winter</option><option value="summer">Summer</option></select>							   
                                       </div>			 
                                  </div>    
								  
<div class="form-group">
								<label class="col-md-4  text-right">Slot Type </label>
                                             <div class="col-md-8" >
	 <select  class="form-control" onchange="display_slot_duration(this.value)"  id="slot_type" name="slot_type"><option value="">Select</option><option value="I">I</option><option value="II">II</option><option value="III">III</option><option value="IV">IV</option></select>							   
                                   
                                       </div>
                                  </div> 
								  </div>
								  <div class="col-md-6">
<div class="form-group">
                                  <label class="col-md-4 text-right">School
                                  </label>
                                  <div class="col-md-8" >
                                    <select class="select2me form-control" name="emp_school" onchange="getstaffdept_using_school(this.value);getEmp_using_dep();" id="emp_school" >
                                      <option value="">Select School
                                      </option>
                                      <?php foreach($school_list as $sc) { echo "<option  value=".$sc['college_id'].">".$sc['college_name']."</option>"; } ?>
                                    </select>
                                  </div>
                                </div>	
<div class="form-group">
                                  <label class="col-md-4 control-label text-right">Department  
                                  </label>
                                  <div class="col-md-8">
                                    <select class="form-control select2me" id="department"  onchange="getEmp_using_dep()" name="department" >
                                      <option value="">Select Department
                                      </option>
                                    </select>
                                  </div>
                                </div>
                                 <div class="form-group"> <span id="stdu" ></span>   </div>	
</div>	</div>								
<div class="form-group">

						<div class="table-info" style="overflow-x:scroll;height:700px;">   		
											 <table class="table table-bordered" style="width:100%;max-width:100%;" >
											 <thead>
											 <tr>
											 <th><input type="checkbox" name="checkall" id="checkAll" value="1" /></th>
											 <th>Emp.ID</th>
											 <th>Name</th>
											 <th>School</th>
											 <th>Department</th>
											 </tr>
											 </thead>
                        <tbody id="itemContainer">
											 <?php  
//$ci =&get_instance();
											  //  $ci->load->model('admin_model');
											 foreach($emplist as $emp){ 
											  //$department =  $ci->admin_model->getDepartmentById($emp['department']); 
								 //$school =  $ci->admin_model->getSchoolById($emp['emp_school']); 
						
											 ?>
											 <tr>
											 <td><input type="checkbox" name="emp[]" class="empid" value="<?php echo $emp['emp_id']; ?>" /> </td>
											 <td><?php echo $emp['emp_id']; ?></td>
											 <td><?php if($emp['gender']=='male'){ echo 'Mr.'; }else{ echo 'Mrs.'; } echo $emp['fname']." ".$emp['lname']; ?></td>
											 <td><?php echo $emp['college_code']; ?></td>
											 <td><?php echo $emp['department_name']; ?></td>
											 </tr>
											 <?php }?>
											 </tr>
											 </tbody>
											 </table>
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
$("#checkAll").change(function () {
    $(".empid").prop('checked', $(this).prop("checked"));
});
function display_slot_duration(st){
  var vt = $('#vacation_type').val();
   $.ajax({
        type: "POST",
        url: "<?php echo base_url().$currentModule; ?>/get_vl_slot_type_duration/"+vt+"/"+st,
        success: function(data){
          //$('#stdu').text('');
        $('#stdu').html(data);     
        } 
      });
}
function display_slot(vt){
	//if(vt=='winter'){
	//	var opt = "<option value=''>Select</option><option value='I'>I</option><option value='II'>II</option>";
  //  			$('#slot_type option').remove();
	//			$('#slot_type').append(opt);
	//}else if(vt=='summer'){
	//	var opt = "<option value=''>Select</option><option value='III'>III</option><option value='IV'>IV</option>";
  //  			$('#slot_type option').remove();
	//			$('#slot_type').append(opt);
	//}
  $.ajax({
        type: "POST",
        url: "<?php echo base_url().$currentModule; ?>/get_vl_slot_type/"+vt,
        success: function(data){
          $('#slot_type option').remove();
        $('#slot_type').html(data);     
        } 
      });

		var dep = $('#department').val();
	var sch = $('#emp_school').val();
	$.ajax({
				type: "POST",
				url: "<?php echo base_url().$currentModule; ?>/get_emp/"+vt+"/"+sch+"/"+dep,
				success: function(data){
					//alert(data);          
            $('#itemContainer').html(data);         
				}	
			});
}
function getEmp_using_dep(){
	var dep = $('#department').val();
	var sch = $('#emp_school').val();
	var vl = $('#vacation_type').val();
	$.ajax({
				type: "POST",
				url: "<?php echo base_url().$currentModule; ?>/get_emp/"+vl+"/"+sch+"/"+dep,
				success: function(data){
					//alert(data);          
            $('#itemContainer').html(data);         
				}	
			});
	
} 
</script> 
