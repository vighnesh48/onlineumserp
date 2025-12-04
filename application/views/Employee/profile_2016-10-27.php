<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
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
                lname:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Last name should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[a-zA-Z-/]+$/,
                        message: 'Last name should be alphabate characters'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Last name should be 2-50 characters'
                        }
                    }
                }
              
            }       
        })
		
});
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">View Employee</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View Employee</h1>
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
					   <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                        <div class="table-info">
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_emp')?>" method="POST" enctype="multipart/form-data">
                         <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Employee Details</strong></div>
                                <div class="panel-body">
                                <div class="table-responsive">
							<div><img src="<?php echo base_url().'uploads/employee_profilephotos/'.$temp[0]['profile_pic'];?>" width="100" height="100" border="1px solid black"></div><br>
					  <table class="table table-bordered">
					  <tr class="info"><td><label>Full Name</label></td><td><?php echo ucfirst($temp[0]['fname']).' '.ucfirst($temp[0]['mname']).' '.ucfirst($temp[0]['lname']); ?></td>
					  <td>Employee Id</td><td><?php echo ($temp[0]['emp_id'])?></td>
					  </tr>
					 <tr class="success"><td><label>Email Id</label></td><td><?php echo $temp[0]['mail_id']; ?></td>
					  <td>Mobile No</td><td><?php echo ($temp[0]['mobile_no'])?></td>
					  </tr>
					   <tr class="info"><td><label>Date Of Birth</label></td><td><?php echo $temp[0]['dob']; ?></td>
					  <td>Gender</td><td><?php echo ($temp[0]['gender'])?></td>
					  </tr>
					   <tr class="success"><td><label>Local Address</label></td><td><?php echo $temp[0]['local_address']; ?></td>
					  <td>Permanent Address</td><td><?php echo ($temp[0]['permanent_address'])?></td>
					  </tr>
					  <tr class="info"><td><label>Joining Date</label></td><td><?php echo $temp[0]['joining_date']; ?></td>
					  <td>Organization</td><td><?php  $res=$this->Admin_model->getOrganizationById($temp[0]['organization']); echo $res[0]['org_name']?></td>
					  </tr>
					  <tr class="success"><td><label>City</label></td><td><?php echo $temp[0]['city']; ?></td>
					  <td>Organization_Location</td><td><?php echo ($temp[0]['org_location'])?></td>
					  </tr>
					  <tr class="info"><td><label>Department</label></td><td><?php  $res=$this->Admin_model->getDepartmentById($temp[0]['department']); echo $res[0]['department_name']?></td>
					  <td>Designation</td><td><?php $res=$this->Admin_model->getDesignationById($temp[0]['designation']);echo $res[0]['designation_name'];?></td>
					  </tr>
					  <tr class="success"><td><label>Hiring Type</label></td><td><?php echo $temp[0]['hiring_type']; ?></td>
					  <td>Employee Category</td><td><?php echo ($temp[0]['emp_category'])?></td>
					  </tr>
					  <tr class="info"><td><label>Reporting Officer</label></td><td><?php echo $temp[0]['reporting_officer']; ?></td>
					  <td>Joining CTC</td><td><?php echo $temp[0]['joining_ctc']."Lakh";?></td>
					  </tr>
					  </table>
					  </div>
					            </div>
							 <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-primary form-control" id="btn_submit" type="submit" href="<?php echo base_url().'home'?>">Go Back </a>                                        
                                    </div> 
                             </div>									
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
<script type="text/javascript">
$(document).ready(function(){
	$('#dob-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#dob-datepicker1').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
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
});
</script>