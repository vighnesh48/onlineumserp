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
            fields: 
            {
                stype:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select One of the search option.'
                      }                      
                    }

                },
                serch_val:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Fill the value for search.'
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
        <li><a href="#">Employee </a></li>
        <li class="active"><a href="#">Search</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Search </h1>
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
                    <div class="panel-heading">
                            <span class="panel-title"> <form id="form" name="form" action="<?=base_url($currentModule)?>" method="POST">                                                               
                               
			                  
                                <div class="form-group">
                                    <label class="col-sm-2">By First Name &nbsp;&nbsp;&nbsp;                                 
                                  <input type="radio" name="stype" value="fname"  />  </label>                                     
                                    
                                
                                    <label class="col-sm-2">By Last Name &nbsp;&nbsp;&nbsp;                                 
                                    <input type="radio" name="stype" value="lname"  />  </label>                                  
                                   
                                
                                    <label class="col-sm-2">By Staff ID &nbsp;&nbsp;&nbsp;                               
                                    <input type="radio" name="stype" value="emp_id" />  </label>                                
                                   <label class="col-sm-2">  
                             <input type="text" name="serch_val" class="form-control" value="" />   </label>                                       
                                   	

                                    <div class="col-sm-2">
                                        <button class="btn btn-primary " id="btn_submit" type="submit" >Search </button>                                        
                                    </div>   </form>
                                    <form id="form1" name="form1" action="<?=base_url($currentModule)?>/Allempdetails" method="POST"> 
<div class="col-sm-2">
<button class="btn btn-primary "  name="sbtn1" type="submit" value="a" >All Employee</button>                   
              </div>
</form>  
							</div>	
                                     
                                </div>
                           </span>
               
                    <div class="panel-body" style="height: 1000px;overflow-y: scroll;">
                        <div class="table-info">    
                        <?php 
if(!empty($search_res1)){
  //print_r($search_res1); ?>
  <div  id="accordion" class="table-scrollable panel-group"  style="border:none!important" role="tablist" aria-multiselectable="true">
                          <table style="margin-top:0%;width:90%;" border="1" class="table-scrollable" id="accordion1">
                              <tr>
                                  <th style="background-color:#6c6674;">Staff ID</th>
                                  <th style="background-color:#6c6674;">Name</th>
                  <th style="background-color:#6c6674;">Designation</th>
                                  <th style="background-color:#6c6674;">Department</th>
                  <th style="background-color:#6c6674;">School</th>
                  <th style="background-color:#6c6674;">Date of Birth</th>
                  <th style="background-color:#6c6674;">Date of Joining</th>
                  <th style="background-color:#6c6674;">Mobile No</th>
                  <th style="background-color:#6c6674;">Official Mail</th>
                  <th style="background-color:#6c6674;">Photo</th>
                  
                              </tr>
            <?php   $ci =&get_instance();
   $ci->load->model('Admin_model');
   
                foreach($search_res1 as $val){
                  $dep = $ci->Admin_model->getDepartmentById($val['department']);
                  $deg = $ci->Admin_model->getDesignationById($val['designation']);
                  $school =  $ci->Admin_model->getSchoolById($val['emp_school']); 
 echo "<tr><td style='padding:5px;' > ".$val['emp_id']."</td><td style='padding:5px;'>".$val['fname']." ".$val['mname']." ".$val['lname']."</td>";
                               echo "<td style='padding:5px;'>".$deg[0]['designation_name']."</td>";
                              echo "<td style='padding:5px;' > ".$dep[0]['department_name']."</td>";
                               echo "<td style='padding:5px;'>".$school[0]['college_code']."</td>";
                              echo "<td style='padding:5px;' > ".date('d-m-Y',strtotime($val['date_of_birth']))."</td>";
                               echo "<td style='padding:5px;'>".date('d-m-Y',strtotime($val['joiningDate']))."</td>";
                              echo "<td style='padding:5px;' > ".$val['mobileNumber']."</td>";
                               echo "<td style='padding:5px;'>".$val['oemail']."</td>";
                              echo "<td style='padding:5px;' > <img style='width:50px;height:50px;' src='".site_url()."/uploads/employee_profilephotos/".$val['profile_pic']."' /></td>";
                               //echo "<td style='padding:5px;'>".$val['department_name']."</td>";
                             echo "</tr>";
                }
                  ?>
                </table>
  </div>
  
  <?php
}else{

?>                        
                            <?php 
							if(!empty($search_res)){
								?>
								 <div  id="accordion" class="table-scrollable panel-group"  style="border:none!important" role="tablist" aria-multiselectable="true">
                          <table style="margin-left:5% !important;margin-top:0%;width:90%;" border="1" class="table-scrollable" id="accordion1">
                              <tr>
                                  <th style="background-color:#6c6674;">Staff ID</th>
                                  <th style="background-color:#6c6674;">Name</th>
                                  <th style="background-color:#6c6674;">Department</th>
                                  <th style="background-color:#6c6674;">View</th>
                              </tr>
                              	<?php
								
		  
		
								$ci =&get_instance();
   $ci->load->model('Admin_model');
   
								foreach($search_res as $val){
									//echo $val['profile_pic'];exit;
									$bucket_key = "uploads/employee_profilephotos/".$val['profile_pic']."";
									 $imageData = $this->awssdk->getsignedurl($bucket_key);
									
									$dep = $ci->Admin_model->getDepartmentById($val['reporting_dept']);
$state = $ci->Admin_model->getStateByID($val['lstate']);
$state1 = $ci->Admin_model->getStateByID($val['pstate']);
$ldist = $ci->Admin_model->getCityByID($val['ldist']);
$pdist = $ci->Admin_model->getCityByID($val['pdist']); 
$status="";
	if($val['emp_reg']=="N"){
	    $status='<i class="fa fa-check-circle-o fa-1.5x" aria-hidden="true" style="color:green" data-toggle="tooltip" title="Active"></i>';
	}else{
	      $status='<i class="fa fa-times-circle-o fa-1x" aria-hidden="true" style="color:red" data-toggle="tooltip" title="Left"></i>';
	}
							
                              echo "<tr><td style='padding:5px;' > ".$val['emp_id']."     ". $status."</td><td style='padding:5px;'>".$val['fname']." ".$val['mname']." ".$val['lname']."</td>";
                               echo "<td style='padding:5px;'>".$val['department_name']."</td>";
                                echo  '<td>
 <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title" style="text-align:center;">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_'.$val['emp_id'].'" aria-expanded="true" aria-controls="collapseOne">
                        <i class="more-less glyphicon " id="'.$val['emp_id'].'">Open</i>
                        
                    </a>
                </h4>
            </div>';
echo '</td>
</tr>
<tr><td colspan="4">
    <div id="collapseOne_'.$val['emp_id'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne"><div class="card-block">';
     
     echo "<table style='margin-left:10%;margin-top:5%;margin-bottom:5%;width:80%;' border='1'>";
     echo "<tr><td style='background:#D2D2D2;'>Staff ID</td><td>".$val['emp_id']."</td><td rowspan='5' style='width:110px;padding-left:5px;'><img style='width:100px;height:100px;' src=".$imageData."></td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Name</td><td >".$val['fname']." ".$val['mname']." ".$val['lname']."</td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Date of Birth</td><td >".date('d M Y',strtotime($val['date_of_birth']))."</td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Date of Joining</td><td >".date('d M Y',strtotime($val['joiningDate']))."</td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Mobile No</td><td >".$val['mobileNumber']."</td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Designation</td><td colspan='2'>".$val['designation_name']."</td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Department</td><td colspan='2'>".$val['department_name']."</td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Reporting School</td><td colspan='2'>".$val['college_name']."</td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Reporting Department</td><td colspan='2'>".$dep[0]['department_name']."</td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Staff Type</td><td colspan='2'>".$val['emp_cat_name']."</td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Mail(Official)</td><td colspan='2'>".$val['oemail']."</td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Mail(Personal)</td><td colspan='2'>".$val['pemail']."</td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Local Address</td><td colspan='2'>".$val['lflatno']."".$val['larea_name']."<br>".$val['ltaluka'].",".$ldist.",".$val['lpincode']."<br> ".$state." ".$val['lcountry']."</td></tr>";
									echo "<tr><td style='background:#D2D2D2;'>Permanent Address</td><td colspan='2'>".$val['pflatno']."".$val['parea_name']."<br>".$val['ptaluka'].",".$pdist.",".$val['p_pincode']."<br> ".$state1." ".$val['pcountry']."</td></tr>";
					
     
     echo "</table>";
    echo '</div>
  </div>
  </td></tr>';
}
 ?>
</table>         
<?php 
}
else{
    
 if(isset($search_res)=="")
 {
     
 }
 else{
?>
    
            <div style="color:red;">No Records Found.</div>             
                            
          <?php }
          } }?>                  
                            
							
						
							
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script>
		    $('[data-toggle="collapse"]').click(function() {
		        var Id = $('.collapse.in').attr('id');
  //alert(Id);
  var res = Id.split("_"); 
  $("#"+res[1]).text('Open');
  $('.collapse.in').collapse('hide');
 
});
	function toggleIcon(e) {
	   // alert(e.target);
    $(e.target)
      .prev('.panel-heading')
        .find(".more-less")
       
}
$('.more-less').on('click', function(){
    var sid = this.id ;
    if($(this).text() == 'Open')
    {
     $("#"+sid).text('Close');
    }else{
         $("#"+sid).text('Open');
    }
});

</script>