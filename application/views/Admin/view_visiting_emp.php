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
        <li><a href="#">Employee</a></li>
        <li class="active"><a href="#">View Visiting Employee</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View Visiting Employee</h1>
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
                            	<div class="panel-heading"><strong>Visiting Employee Details</strong></div>
                                <div class="panel-body">
                                <div class="table-responsive">
							<div>
							<?php if(!empty($temp[0]['profile_pic'])){?>
							<img src="<?php echo base_url().'uploads/employee_profilephotos/'.$temp[0]['profile_pic'];?>" width="100" height="100" border="1px solid black">
							<?php }?></div><br>
					  <table class="table table-bordered">
					  <thead><label style="color:Green;">Staff Details</label></thead>
		
					  <tr class=""><td><label >Full Name</label></td><td style="color:Blue;"><?php echo ucfirst($temp[0]['fname']).' '.ucfirst($temp[0]['mname']).' '.ucfirst($temp[0]['lname']); ?></td>
					  <td><label >Employee Id/Password</label></td><td style="color:Blue;"><?php echo $temp[0]['eid'];?> / <?php echo $temp[0]['password'];?></td>
					  </tr>
					 <tr class=""><td><label>Appointment Reference Id</label></td><td style="color:Blue;"><?php echo $temp[0]['rid']; ?></td>
					  <td><label>Date Of Birth</label></td><td style="color:Blue;"><?php echo date('d-m-Y',strtotime($temp[0]['date_of_birth']));?></td>
					  </tr>
					   <tr class=""><td><label>Gender</label></td><td style="color:Blue;"><?php echo ucfirst($temp[0]['gender']); ?></td>
					  <td><label>Blood Group</label></td><td style="color:Blue;"><?php echo $temp[0]['blood_gr'];?></td>
					  </tr>
					   <tr class=""><td><label>Pan No</label></td><td style="color:Blue;"><?php echo $temp[0]['pan_card_no']; ?></td>
					  <td><label>Aadhar Number</label></td><td style="color:Blue;"><?php echo $temp[0]['adhar_no'];?></td>
					  </tr>
					    <tr class=""><td><label>Category</label></td><td style="color:Blue;"><?php echo $temp[0]['category']; ?></td>
					  <td><label>Cast</label></td><td style="color:Blue;"><?php echo $temp[0]['cast'];?></td>
					  </tr>
					   <tr class=""><td><label>Sub Cast</label></td><td style="color:Blue;"><?php echo $temp[0]['sub-cast']; ?></td>
					  <td><label>Joining Date</label></td><td style="color:Blue;"><?php echo date('d-m-Y',strtotime($temp[0]['jd'])); ?></td>
					  </tr>
					  <tr class="">
					  <td>Employee School</td><td style="color:Blue;"><?php echo $temp[0]['college_name'];?></td>
					  <td><label>Designation</label></td><td style="color:Blue;"><?php echo $temp[0]['designation_name']; ?></td>
					  </tr>
					  <tr class="">
					  <td>Department</td><td style="color:Blue;"><?php echo $temp[0]['department_name'];?></td>
					  <td><label>Hiring Type</label></td><td style="color:Blue;"><?php echo $temp[0]['hiring_type'];?></td>
					  </tr>
					  
					  <tr class="">
					  <td><label>Physical Status(Handicapped)</label></td><td style="color:Blue;"><?php if($temp[0]['phy_status']==0)echo "Yes"; else echo "No";?></td>
					  <td><label>PF Status(Having PF)</label></td><td style="color:Blue;"><?php if($temp[0]['pf_status']==0)echo "Yes"; else echo "No";?></td>
					  </tr>
					<tr class="">
					  <td><label>Punching Applicable</label></td><td style="color:Blue;"><?php if($temp[0]['punching_applicable']=='Y')echo "Yes"; else echo "No";?></td>
					  <td><label>Is Payable</label></td><td style="color:Blue;"><?php if($temp[0]['is_payable']=='Y')echo "Yes"; else echo "No";?></td>
					  </tr>
						
					  <tr class="">
					  <td><label>Mobile Number</label></td><td style="color:Blue;"><?php echo $temp[0]['mobile_no'];?></td>
					  <td><label>Personal Email ID</label></td><td style="color:Blue;"><?php echo $temp[0]['email_id']; ?></td>
					  </tr>
					  
					  </table>
					  
					  <table class="table table-bordered">
					 
		<tr><th>Address Details</th>
       </tr>
			<tr>
		<!--Local Address-->
		<td width="100%">
<div class="form-group">
<label  class="col-sm-3">Address:</label><div class="col-sm-3" style="color:Blue;"><?php echo $temp[0]['address'];?></div>
</div>


<div class="form-group">
<label  class="col-sm-3">Dist/City:</label><div class="col-sm-3" style="color:Blue;"><?php echo $temp[0]['district_name'];?> / <?php echo $temp[0]['taluka_name'];?></div>
</div>
<div class="form-group">
<label  class="col-sm-3">Pin Code:</label><div class="col-sm-3" style="color:Blue;"><?php echo $temp[0]['pincode'];?></div>
</div>
<div class="form-group">
<label  class="col-sm-3">State:</label><div class="col-sm-3" style="color:Blue;"><?php echo $temp[0]['state_name'];?></div> 
</div>


</fieldset>
		</td>
		</tr>
</table>
					  
					  
					  </div>
					            </div>
							 <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-primary form-control" id="btn_submit" type="submit" href="<?php echo base_url().'Faculty/visitor_list'?>">Go Back </a>                                        
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