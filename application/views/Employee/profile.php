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
    <div class="row">
	<?php
        //$emp[0]['profile_pic'];
		if(!empty($temp[0]['profile_pic'])){
            $bucket_key = "uploads/employee_profilephotos/".$temp[0]['profile_pic'];
            $profile = $this->awssdk->getImageData($bucket_key);
			//$profile=base_url()."uploads/employee_profilephotos/".$emp[0]['profile_pic'];
		}else{
	$profile=base_url()."uploads/noimage.png";}?>
	
	
	
      <div class="col-sm-12" style="margin-top:20px"><img src="<?php echo $profile;?>" width="100" height="100" border="1px solid black"></div>
	  
	  <div class="col-sm-12 hidden" style="margin-top:20px"><a href="<?php echo base_url().'admin/create_employee?p=&id='.$temp[0]['emp_id'].'&status=Y&flag=1'?>">Edit profile</a></div>
	  
    </div>
    <div class="row">
      <div class="col-lg-12"> <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
        <form id="form" class="form-horizontal em-detail" name="form" action="<?=base_url($currentModule.'/add_emp')?>" method="POST" enctype="multipart/form-data">
          <div class="panel panel-warning panel-dark">
            <div class="panel-heading"> <span class="panel-title">Staff Details</span> </div>
            <div class="panel-body table-responsive">
              <table class="table table-bordered">
                <!--<thead><label style="color:Green;">Staff Details</label></thead>-->
                <tr class="">
                  <td width="25%"><label >Full Name</label></td>
                  <td><?php echo ucfirst($temp[0]['fname']).' '.ucfirst($temp[0]['mname']).' '.ucfirst($temp[0]['lname']); ?></td>
                  <td width="25%"><label>Employee Id</label></td>
                  <td><?php echo $temp[0]['emp_id'];?></td>
                </tr>
                <tr class="">
                  <td><label>Reference Id</label></td>
                  <td><?php echo $temp[0]['referenceID']; ?></td>
                  <td><label>Date Of Birth</label></td>
                  <td><?php echo $temp[0]['date_of_birth'];?></td>
                </tr>
                <tr class="">
                  <td><label>Gender</label></td>
                  <td><?php echo ucfirst($temp[0]['gender']); ?></td>
                  <td><label>Blood Group</label></td>
                  <td><?php echo $temp[0]['blood_gr'];?></td>
                </tr>
                <tr class="">
                  <td><label>staff Type</label></td>
                  <td><?php echo $temp[0]['emp_cat_name']; ?></td>
                  <td><label>Aadhar Number</label></td>
                  <td><?php echo $temp[0]['adhar_no'];?></td>
                </tr>
                <tr class="">
                  <td><label>Category</label></td>
                  <td><?php echo $temp[0]['category']; ?></td>
                  <td><label>Cast</label></td>
                  <td><?php echo $temp[0]['cast'];?></td>
                </tr>
        <tr class="">
                  <td><label>Sub Cast</label></td>
                  <td><?php echo $temp[0]['sub-cast']; ?></td>
                  <td><label>Joining Date</label></td>
                  <td><?php echo date('d-m-Y',strtotime($temp[0]['joiningDate'])); ?></td>
                </tr>
                <tr class="">                  
                  <td><label>Employee School</label></td>
                  <td><?php echo $temp[0]['college_name'];?></td>
                  <td><label>Designation</label></td>
                  <td><?php echo $temp[0]['designation_name']; ?></td>
                </tr>
                <tr class="">                  
                  <td><label>Department</label></td>
                  <td><?php echo $temp[0]['department_name'];?></td>
                   <td><label>Staff Grade</label></td>
                  <td><?php  echo $temp[0]['staff_grade'];?></td>
                </tr>
                <tr class="">                 
                  <td><label>Hiring Type</label></td>
                  <td><?php echo $temp[0]['hiring_type'];?></td>
                  <td><label>Qualification</label></td>
                  <td><?php echo $temp[0]['qualifiaction']; ?></td>
                </tr>
                <tr class="">                  
                  <td><label>Physical Status(Handicapped)</label></td>
                  <td><?php if($temp[0]['phy_status']==0)echo "Yes"; else echo "No";?></td>
                   <td><label>PF Status(Having PF)</label></td>
                  <td><?php if($temp[0]['pf_status']==0)echo "Yes"; else echo "No";?></td>
                </tr>
                <tr class="">                 
                  <td><label>Weekly Off</label></td>
                  <td><?php echo $temp[0]['week_off'];?></td>
                  <td><label>Alloted shift</label></td>
                  <td><?php  echo $temp[0]['shift_name'];?></td>
                </tr>
                <tr class="">                  
                  <td><label>Daily work Duration</label></td>
                  <td><?php echo $temp[0]['rtintime']." -- ".$temp[0]['rtouttime'];?></td>
                    <td><label>LandLine No.</label></td>
                  <td><?php echo $temp[0]['landline_std']."-".$temp[0]['landline_no']; ?></td>
                </tr>
                <tr class="">                
                  <td><label>Mobile Number</label></td>
                  <td><?php echo $temp[0]['mobileNumber'];?></td>
                  <td><label>Personal Email ID</label></td>
                  <td><?php echo $temp[0]['pemail']; ?></td>
                </tr>
                <tr class="">                  
                  <td><label>Official Email ID</label></td>
                  <td><?php echo $temp[0]['oemail'];?></td>
                   <td><label>Academic/Technical Experience</label></td>
                  <td><?php echo $temp[0]['aexp_yr'].".".$temp[0]['aexp_mnth']."Yr"; ?></td>
                </tr>
                <tr >                 
                  <td><label>Industrial Experience</label></td>
                  <td><?php echo $temp[0]['inexp_yr'].".".$temp[0]['inexp_mnth']."Yr"; ?></td>
                  <td><label>Research Experience</label></td>
                  <td><?php echo $temp[0]['rexp_yr'].".".$temp[0]['rexp_mnth']."Yr"; ?></td>
                </tr>
                <tr >                  
                  <td><label>Total Experience</label></td>
                  <td><?php echo $temp[0]['texp_yr'].".".$temp[0]['texp_mnth']."Yr"; ?></td>
                   <td><label>Scale Type</label></td>
                  <td><?php echo $temp[0]['scaletype']; ?></td>
                </tr>
                <!--tr >                 
                  <td><label>Basic Salary</label></td>
                  <td><?php echo $temp[0]['basic_sal']; ?></td>
                   <td><label>Special Allowance</label></td>
                  <td><?php echo $temp[0]['allowance']; ?></td>
                </tr>
                <tr >                 
                  <td><label>Pay Band</label></td>
                  <td><?php if(!empty($temp[0]['pay_band_min'])&&!empty($temp[0]['pay_band_max'])&&!empty($temp[0]['pay_band_gt']))echo $temp[0]['pay_band_min']."-".$temp[0]['pay_band_max']."+AGP ".$temp[0]['pay_band_gt'];else echo "NA"; ?></td>
                 <td><label>Other</label></td>
                  <td><?php echo $temp[0]['other_pay']; ?></td>
                </tr-->
               
                <tr >
                  <td><label>Bank Account Number</label></td>
                  <td><?php echo $temp[0]['bank_acc_no']; ?></td>
                  <td><label>Bank Name</label></td>
                  <td><?php echo $temp[0]['bank_name']; ?></td>
                </tr>
                <tr ><td><label>UAN/PF No</label></td>
         <td ><?php echo $temp[0]['pf_no']; ?></td>
            <td><label>PAN No</label></td>
            <td><?php echo $temp[0]['pan_no']; ?></td>
            </tr>
                <tr >
                  <td><label>Reporting School</label></td>
                  <td><?php $val=$this->Admin_model->getSchoolById($temp[0]['reporting_school']);echo $val[0]['college_name'];?></td>
                  <td><label>Reporting Department</label></td>
                  <td><?php $val1= $this->Admin_model->getDepartmentById($temp[0]['reporting_dept']);echo $val1[0]['department_name'] ?></td>
                </tr>
              </table>
            </div>
          </div>
          <!--<div class="panel panel-warning panel-dark">
            <div class="panel-heading"> <span class="panel-title">Personal Details</span> </div>
            <div class="panel-body table-responsive">
              <table class="table table-bordered">
                <thead><label style="color:Green;">Staff Details</label></thead>
                <tr class="">
                  <td width="25%"><label >Full Name</label></td>
                  <td><?php echo ucfirst($temp[0]['fname']).' '.ucfirst($temp[0]['mname']).' '.ucfirst($temp[0]['lname']); ?></td>
                  <td width="25%"><label>Employee Id</label></td>
                  <td><?php echo $temp[0]['emp_id'];?></td>
                </tr>
                <tr class="">
                  <td><label>Reference Id</label></td>
                  <td><?php echo $temp[0]['referenceID']; ?></td>
                  <td><label>Date Of Birth</label></td>
                  <td><?php echo $temp[0]['date_of_birth'];?></td>
                </tr>
                <tr class="">
                  <td><label>Gender</label></td>
                  <td><?php echo ucfirst($temp[0]['gender']); ?></td>
                  <td><label>Blood Group</label></td>
                  <td><?php echo $temp[0]['blood_gr'];?></td>
                </tr>
                <tr class="">
                  <td><label>staff Type</label></td>
                  <td><?php echo $temp[0]['emp_cat_name']; ?></td>
                  <td><label>Aadhar Number</label></td>
                  <td><?php echo $temp[0]['adhar_no'];?></td>
                </tr>
                <tr class="">
                  <td><label>Joining Date</label></td>
                  <td><?php echo $temp[0]['joiningDate']; ?></td>
                  <td><label>Employee School</label></td>
                  <td><?php echo $temp[0]['college_name'];?></td>
                </tr>
              </table>
            </div>
          </div>-->
          <div class="panel panel-warning panel-dark">
            <div class="panel-heading"> <span class="panel-title">Address Details</span> </div>
            <div class="panel-body table-responsive">
              <table class="table table-bordered">
                <tr>
                  <th scope="col">Local Address</th>
                  <th scope="col">Permanent Address</th>
                </tr>
                <tr>
                  <td width="50%"><div class="form-group">
                      <label class="col-sm-4" for="email">Plot/Flat No. :</label>
                      <div class="col-sm-8"> <?php echo $temp[0]['lflatno'];?> </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4">Area Name :</label>
                      <div class="col-sm-8"><?php echo $temp[0]['larea_name'];?> </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4">Taluka :</label>
                      <div class="col-sm-8"><?php echo $temp[0]['ltaluka'];?> </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4">Dist/City :</label>
                      <div class="col-sm-8"><?php echo $this->Employee_model->getCityByID($temp[0]['ldist']);?> </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4">Pin Code :</label>
                      <div class="col-sm-8"><?php echo $temp[0]['lpincode'];?> </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4">State :</label>
                      <div class="col-sm-8"><?php echo $this->Employee_model->getStateByID($temp[0]['lstate']);?> </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4">Country :</label>
                      <div class="col-sm-8"><?php echo $temp[0]['lcountry'];?> </div>
                    </div></td>
                  <td><div class="form-group">
                      <label class="col-sm-4" for="email">Plot/Flat No. :</label>
                      <div class="col-sm-8"> <?php echo $temp[0]['pflatno'];?> </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4">Area Name :</label>
                      <div class="col-sm-8"><?php echo $temp[0]['parea_name'];?></div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4">Taluka :</label>
                      <div class="col-sm-8"><?php echo $temp[0]['ptaluka'];?> </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4">Dist/City :</label>
                      <div class="col-sm-8"><?php echo $this->Employee_model->getCityByID($temp[0]['pdist']);?> </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4">Pin Code :</label>
                      <div class="col-sm-8"><?php echo $temp[0]['p_pincode'];?> </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4">State :</label>
                      <div class="col-sm-8"><?php echo $this->Employee_model->getStateByID($temp[0]['pstate']);?> </div>
                    </div>
                    <div class="form-group">
                      <label  class="col-sm-4">Country :</label>
                      <div class="col-sm-8"><?php echo $temp[0]['pcountry'];?> </div>
                    </div></td>
                </tr>
              </table>
            </div>
          </div>
        </form>
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
<style type="text/css">
.em-detail label{font-weight:bold; text-align:right}
.em-detail th{background:#f1f1f1;font-size: 17px;}
.table{width:100%;border:1px solid #e4e4e4 !important}
table{max-width:100%}
</style>
