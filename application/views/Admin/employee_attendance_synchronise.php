<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>

<div id="content-wrapper">

    <ul class="breadcrumb breadcrumb-page">

        <div class="breadcrumb-label text-light-gray">You are here: </div>

        <li><a href="#">Attendance</a></li>

        <li class="active"><a href="#">Employee Attendance Synchronization</a></li>

    </ul>

    <div class="page-header">			

        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Attendance Synchronization</h1>

            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h"><span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                </div>
            </div>
        </div>       
       
							  <form id="formsy" name="formsy" action="<?=base_url($currentModule.'/synchronise_attendance_emp')?>" method="POST" enctype="multipart/form-data">

							    
								<div class="row">

<div class="col-md-6">
<div class="panel">
               <div class="panel-heading" ><b>Employee List</b></div>
<div class="table-info" style="height:500px;overflow-y:scroll;padding:10px;">    
                                    <table class="table table-bordered" >
                                        <thead>
                                            <tr><th><input type='checkbox'  name="emp_chk_all" onclick='check_all()'></th>
                                                    <th>#</th>
                                                    <th>Emp.Id</th>
													<th>Name</th>
													
													<th>Department</th>
													</tr>
													</thead>
													<tbody>
													<?php $i=1; foreach($emplist as $val){ ?>
													<tr id="emp_<?php echo $val['emp_id']; ?>">
													<td><input type="checkbox" name="emp[]" id="<?php echo $val['emp_id']; ?>" onclick="get_sel_chk(<?php echo $val['emp_id']; ?>)" value="<?php echo $val['emp_id']; ?>" /> </td>
													<td><?php echo $i; ?></td>
													<td><?php echo $val['emp_id']; ?></td>
													<td><?php echo $val['fname']." ".$val['lname']; ?></td>
													
													<td><?php echo $val['department_name']; ?></td>													
													</tr>													
													<?php $i++; } ?>													
													</tbody>
													</table>
													</div></div>
													</div>
<div class="col-md-6">
<div class="panel">
               <div class="panel-heading" >

								<b>Select Month</b>

										<input type="text"  placeholder="Month & Year" name="for_month_year" id="dob-datepicker" value="" required>
</div>
								

								

								

								   <div class="table-info" id="monlist" style="padding:10px;height:500px;overflow-y:scroll;">    
								
								</div>
</div>
                                    </div>

								

								
									</div>
<div class="form-group">
                                <div class="col-md-3"></div>
                                <div class=" col-md-2">
                                  <button type="submit" class="btn btn-primary form-control" >Submit</button>
                                </div>
                                   <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/employee_attendance_synchronise'">Cancel</button></div>
                 
                              </div>
									
    </div></form>
							   </div>
                                </div>

                           

<script type="text/javascript">
function check_all(){
      if($('input:checkbox[name="emp_chk_all"]').prop("checked")) {
    $('input:checkbox[name="emp[]"]').prop('checked', true);   
     } else {
     $('input:checkbox[name="emp[]"]').prop('checked', false);     
            }    
}
function get_sel_chk(e){
 if($('#'+e).prop("checked")) {
     $('#emp_'+e).css('background-color','#D2D2D2');
     } else {
         $('#emp_'+e).css('background-color','#FFFFFF');
            }    
}
function get_sel_chk_dt(e){
 if($('#'+e).prop("checked")) {
     $('#dt_'+e).css('background-color','#D2D2D2');
     } else {
         $('#dt_'+e).css('background-color','#FFFFFF');
            }    
}
function check_all_date(){
      if($("input:checkbox[name='chkal']").prop("checked")) {
    $("input:checkbox[name='datelist[]']").prop("checked", true);   
     } else {
     $("input:checkbox[name='datelist[]']").prop("checked", false);     
            }    
}
$(document).ready(function(){

	$('#dob-datepicker').datepicker({format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true}).on('changeDate', function (selected) {
            $.ajax({
                type: "POST",
                url: base_url+"admin/get_month_date/"+$(this).val(),              
                success: function(data){
                $('#monlist').html(data);
				
        // window.loction = base_url+"leave/vacation_leave_list" ;
                }   
            });
  });
$('#formsy').on('submit', function() {

 var favorite = [];
var datel = [];
            $.each($("input[name='emp[]']:checked"), function(){            
                favorite.push($(this).val());
            });
           $.each($("input[name='datelist[]']:checked"), function(){            
                datel.push($(this).val());
            });
            var fLen = favorite.length;
            var dlen = datel.length;
            //alert(fLen);
            if(fLen == 0){
                alert('Select Employees.');
            return false;
            
            }else if(dlen == 0){
                 alert('Select Date.');
            return false;
            }

});
	
});


</script>





