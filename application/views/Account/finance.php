<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>    
    $(document).ready(function(){
     var base_url = 'https://erp.sandipuniversity.com/';
      $('#exam_session').addClass('hide');
      $("#emp_data_show").hide();
       $("#msg-alert").hide();

   	$("#report_date").datepicker({       
        autoclose: true,
		format: 'dd-mm-yyyy'		
    });
    $("#report_month1").datepicker({       
        autoclose: true,
		format: 'dd-mm-yyyy'		
    });
    $("#from_date").datepicker({       
        autoclose: true,
		format: 'dd-mm-yyyy'		
    });
     $("#to_date").datepicker({       
        autoclose: true,
		format: 'dd-mm-yyyy'		
    });
 $('#report_month').datepicker( {format: "m-yyyy",startView: "months",minViewMode: "months",autoclose:true});
  
  $('#report_by').change(function() {
    //alert($(this).val());
    if($(this).val()==1){
        $('#datewise').removeClass('hide');
        $('#monthwise').addClass('hide');
        $('#durationwise').addClass('hide');
    }
    if($(this).val()==2){
         $('#datewise').addClass('hide');
        $('#monthwise').removeClass('hide');
        $('#durationwise').addClass('hide');
    }
    if($(this).val()==3){
         $('#datewise').addClass('hide');
        $('#monthwise').addClass('hide');
        $('#durationwise').removeClass('hide');
    }
    

    });
        $('#report_type').change(function() {   
             if($(this).val()==4){
             $('#exam_session').removeClass('hide');
           }
           else{
             $('#exam_session').addClass('hide');
           }
           
            });
   
    
     $('#btnExcel').click(function(){
         
          var academic_year = $("#academic_year").val();
                var report_type = $("#report_type").val();
                var report_by = $("#report_by").val();
                var report_date = $("#report_date").val();
                var report_month = $("#report_month").val();
                var from_date = $("#from_date").val();
                var to_date = $("#to_date").val();
                
              if(academic_year=="0" ||report_type=="0"|| report_by=="0"){
                      alert("Please select proper options ");
                      return false;
                  }
                  else{
                    switch(report_by){
                         case "1":
                             if(report_date==""){
                                 alert("Please select Report Date");
                                  return false;
                             }
                           
                         break;
                          case "2":
                             if(report_month==""){
                                  alert("Please select Report Month");
                                   return false;
                             }
                             
                         break;
                          case "3":
                             if(from_date=="" ||to_date==""){
                                 alert("Please select Report Duration");
                                  return false;
                             }
                            
                         break;
                          case "0":
                             alert("Please select Report by");
                              return false;
                         break;
                     }
                       $("#loader1").html('<div class="loader"></div>');
                     $("#frmreport").submit();
                      $.ajax({
                            'url' : base_url + '/account/get_reports_data',
                            'type' : 'POST', //the way you want to send data to your URL
                            'data' :'act=excel',
                            'success':function (str){
                           //  alert(str);
                            $("#reportdata").html(str);
                             $("#loader1").html('');
                            }
                      });
                   
               }
         
         // window.location.href = base_url + '/Account/get_reports';
     });
     
      
               
        $('#btnView').click(function(){
         
               var academic_year = $("#academic_year").val();
                var exam_session = $("#exam_session").val();
                var report_type = $("#report_type").val();
                var report_by = $("#report_by").val();
                var report_date = $("#report_date").val();
                var report_month = $("#report_month").val();
                var from_date = $("#from_date").val();
                var to_date = $("#to_date").val();
                var urldata='academic_year='+academic_year+'&report_type='+report_type+'&report_by='+report_by+'&report_date='+report_date+'&report_month='+report_month+'&from_date='+from_date+'&to_date='+to_date+'&act=view&exam_session='+exam_session;
              if(academic_year=="0" ||report_type=="0"|| report_by=="0"){
                      alert("Please select proper options ");
                      return 0;
                  }
                  else{
                    switch(report_by){
                         case "1":
                             if(report_date==""){
                                 alert("Please select Report Date");
                                  return false;
                             }
                           
                         break;
                          case "2":
                             if(report_month==""){
                                  alert("Please select Report Month");
                                   return false;
                             }
                             
                         break;
                          case "3":
                             if(from_date=="" ||to_date==""){
                                 alert("Please select Report Duration");
                                  return false;
                             }
                            
                         break;
                          case "0":
                             alert("Please select Report by");
                              return false;
                         break;
                     }
                       $("#loader1").html('<div class="loader"></div>');
                    $.ajax({
                            'url' : base_url + '/account/get_reports_data',
                            'type' : 'POST', //the way you want to send data to your URL
                            'data' : urldata,
                            'success':function (str){
                            // alert(str);
                             $("#loader1").html('');
                            $("#reportdata").html(str);
  
                            }
                      });
               }

        });
      
		
    });

</script>
<style>
    .table {
    width: 100%!important;
}
table {
    max-width: 100%!important;
}
    
</style>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Account</a></li>
        <li class="active">Reports<a href="#"></a></li>
    </ul>

    <div class="page-header">
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title form-group"><i class="fa fa-list-alt page-header-icon h3"></i>&nbsp;&nbsp;Finance Report </span>
                           
                    </div>
                    <div class="panel-body">  <form action="<?=base_url($currentModule.'/get_reports_data');?>" method="POST" id="">
                        <div class="table-info">
                            
                             <div class="row">
                                   
                               
                                   <div class="form-group">
                                    	<label class="col-sm-2 control-label">Academic Year</label>
                                            <div class="col-sm-3">
                                            	<select id="academic_year" name="academic_year" class="form-control"  required>
        											<option value="0"> Select Academic Year</option>
													<option value="2021">2021-22</option>
													<option value="2020">2020-21</option>
													<option value="2019">2019-20</option>
        													<option value="2018">2018-19</option>
        												<option value="2017">2017-18</option>
        													<option value="2016">2016-17</option>
        								
        										</select>
                						    </div>
                						    
                						    <label class="col-sm-2 control-label">Report Type</label>
                						    <div class="col-sm-3">
                                    	        <select id="report_type" name="report_type" class="form-control"  required>
        											<option value="0"> Select Report Type</option>
        												<option value="1">Admission Fees </option>
        													<option value="2">Checque Cancel</option>
        													    <option value="3">Refund Fees</option>
        													    	<option value="4">Examination Fees</option>
									           	</select>
									           	
								            </div>
								            <div class="col-sm-2">
								                	<select id="exam_session" name="exam_session" class="form-control"  class='hide'>
        											  <option value="0"> Select Exam Session</option>
        												<option value="5">Dec-2017(Regular)</option>
        												
									           	</select>
								            </div>
								    </div>
							    </div>
							<div class="row">
                                   <div class="form-group">
                                    	<label class="col-sm-2 control-label">Report By</label>
                                        <div class="col-sm-3">
                                        	<select id="report_by" name="report_by" class="form-control"  required>
    											<option value="0"> Select Report frequency</option>
    												<option value="1">Datewise</option>
    													<option value="2">Monthwise</option>
    													    <option value="3">Duration</option>
    										</select>
    								    </div>
    								     
    								     <span id='datewise' class='hide'>
    								        <label class="col-sm-2 control-label">Select Date</label>
    								            <div class="col-sm-2 input-group input-append date" id="datePicker">
                                                     <input type="text" id="report_date" name="report_date" class="form-control"/>
                                                </div>
                                        </span>
                                        <span id='monthwise' class='hide'>
    								        <label class="col-sm-2 control-label">Select Month</label>
    								            <div class="col-sm-2 input-group input-append date" id="datePicker">
    								                <input id="report_month"  class="form-control form-control-inline input-medium date-picker" name="report_month" value="" placeholder="Enter Month" type="text">
                                                    
                                                </div>
                                        </span>
                                        <span id='durationwise' class='hide'>
    								        <label class="col-sm-2 control-label">Select Duration</label>
    								        <div class="col-sm-5"  id="datePicker">
    								            <div class="row">
    								                <div class="col-sm-4"> <input type="text" id="from_date" name="from_date" class="form-control"></div>
    								                <div class="col-sm-1">To</div>
    								           <div class="col-sm-4"> <input type="text" id="to_date" name="to_date" class="form-control"/></div>
    								        </div>
    								        </div>
    								       <input type="hidden" name="act" value="excel">
    								       
                                        </span>
                                </div>
                             </div>
                        	<div class="row">
                        	      <div class="col-sm-4"></div>
                                  <div class="col-sm-2"><input type="button" class="btn btn-primary form-control" id="btnView" value="view"></div>
                                  <div class="col-sm-2"><input type="submit"  class="btn btn-primary form-control" value="Excel"></div>
                                  <div class="col-sm-2">
                                 </div>
                            </div>  
                            
                        </div>
                   	  </form>   
				   </div>    
                </div>
            </div>
            
            
        </div>
    </div>
 <center><div id="loader1"></div> </center>
    <div class="row" id="reportdata">
        
        
    </div>
           
            
</div>
<style>
.loader {
  border: 6px;
  border-radius: 50%;
  border-top: 6px solid pink;
  border-bottom: 6px solid pink;
  width: 90px;
  height: 90px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}


@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
