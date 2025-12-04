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

        <li class="active"><a href="#">Employee Punching Log</a></li>

    </ul>

    <div class="page-header">			

        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Punching Log</h1>

            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>       
       
							 
							    
								<div class="row">

<div class="col-md-6">
<div class="panel">
               <div class="panel-heading" ><b>Select Month And Employee </b></div>
    <div class="panel-body">                     
                    <div class="panel-padding no-padding-vr">      
                               <div class="form-group">
 <label class="col-md-3 ">Month </label>
                                  <div class="col-md-4">
                                    <input type="text" id="sdate" name="sdate" class="form-control" value="" />
                                  </div>
                               </div>   
                               <div class="form-group">
 <label class="col-md-3 ">Employee ID </label>
                                  <div class="col-md-4">
                                    <input type="text" id="empid" name="empid" class="form-control" value="" />
                                  </div>
                               </div>  
                                <div class="form-group">
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
  <button type="button" id="serbtn" class="btn btn-primary form-control" >View
                                    </button></div>
                               </div>   
													</div></div></div></div>
													
<div class="col-md-6">
<div class="panel">
               <div class="panel-heading" >
								<b>Punching Log</b>										
</div>
								   <div class="table-info" id="monlist" style="padding:10px;height:500px;overflow-y:scroll;">    
								
								</div>
</div>
                                    </div>

								

								
									</div>

							   </div>
                                </div>

                           

<script type="text/javascript">
$(document).ready(function(){

	$('#sdate').datepicker({format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
 $('#serbtn').on('click', function() {
    var mon = $('#sdate').val();
    var emp = $('#empid').val();
    if(mon==''){
        alert('Select Month.');
        }else if(emp == ''){
alert('Enter Employee ID');
        }else{
 $.ajax({
                type: "POST",
                url: base_url+"admin/get_month_punching_date/"+mon+"/"+emp,              
                success: function(data){
                $('#monlist').html(data);
                
        // window.loction = base_url+"leave/vacation_leave_list" ;
                }   
	});
}
});
});

</script>





