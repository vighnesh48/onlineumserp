<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/bootstrap-modal-fullscreen/1.0.3/bootstrap-modal-fullscreen.min.js"></script>
<style>
.model{overflow: hidden !important;}
.clickable{
    cursor: pointer;   
    	margin-top: 12px;
	   font-size: 15px;
}


    .modal-dialog {
      width: 100%;
      padding: 0;
      margin:0;
    }
    
    .modal-body{
    max-height:calc(100vh - 100px);
    overflow-y: auto;
    }
.modal-open {
    overflow: hidden;
}

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

<script>    
    $(document).ready(function(){
     var base_url = 'https://erp.sandipuniversity.com/';

        $('#btnView').click(function(){
                var academic_year = $("#academic_year").val();
                var admission_type = $("#admission_type").val();
                var report_type = $("#report_type").val();
               
                
                  if(academic_year=="" ||admission_type==""||report_type==""){
                      alert("Please select All  Options ");
                  }
                  else {
                      $("#loader1").html('<div class="loader"></div>');
                      $.ajax({
                                'url' : base_url + '/account/get_admission_fees_report_same',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'report_type':report_type,'admission_type':admission_type,'act':'view'},
                                'success':function (str) {
                                 //alert(str);
                                 
                                  $("#rowdata").css('display','');
                                  $("#reportdata").html(str);
                                   $("#loader1").html("");
                                }
                          });
                      
                  }
                     
                  
        });
        
        $('#btnExcel').click(function(){
                var academic_year = $("#academic_year").val();
                var admission_type = $("#admission_type").val();
                var report_type = $("#report_type").val();
     
                  if(academic_year=="" ||admission_type==""||report_type==""){
                      alert("Please select All  Options ");
                  }
                  else
                  {
                      // $("#loader1").html('<div class="loader"></div>');
                       $("#FrmAdm").submit();
                       
                        $.ajax({
                                'url' : base_url + '/account/get_admission_fees_report_same',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'report_type':report_type,'admission_type':admission_type,'act':'excel'},
                                'success':function (str) {
                                // alert(str);
                                 // $("#reportdata").html("<div class="loader"></div>");
                                 
                                }
                          });
           
                  }
            
            
        });
      
		
    });

</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Account</a></li>
        <li class="active">Reports<a href="#"></a></li>
    </ul>
  <form action="<?=base_url($currentModule.'/get_admission_fees_report_same');?>" method="POST" id="FrmAdm">
     
    <div class="page-header">
      <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title form-group"><i class="fa fa-list-alt page-header-icon h3"></i>&nbsp;&nbsp;Admission Fees Report</span>
                    </div>
                    <div class="panel-body">
                             <div class="row">
                                   <div class="form-group">
                                        <div class="col-sm-3">
                                            	<select id="academic_year" name="academic_year" class="form-control"  required>
        											<option value="">Select Academic Year</option>
        												<option value="2018">2018-19</option>
        												<option value="2017">2017-18</option>
        													<option value="2016">2016-17</option>
									           	</select>
                						    </div>
                                        <div class="col-sm-3">
                                    	        <select id="admission_type" name="admission_type" class="form-control"  required>
        											<option value=""> Select Admission Type</option>
        												<option value="N">New Admission</option>
        											 	<option value="R">Re-Registration</option>
        											 	<option value="A">Both</option>
        												
        													    
									           	</select>
								            </div>
                						<div class="col-sm-3">
                                    	        <select id="report_type" name="report_type" class="form-control"  required>
        											<option value=""> Select Report Type</option>
        												<option value="1">Fees Details</option>
        											 	<option value="2">Student Wise Fees</option>
        												<option value="3">Fees Statistics</option>
        												<option value="4">Fees Outstanding</option>
        													    
									           	</select>
								            </div>
								            <input type="hidden" name="act" value="excel">
								        <div class="col-sm-1"><input type="button" class="btn btn-primary form-control" id="btnView" value="view"></div>
								       
								        <div class="col-sm-1"><input type="submit"  class="btn btn-primary form-control" id="btnExcel" value="Excel"></div>
								        
								          </form>
								        
								        
								    </div>
							    </div>
		         
                    </div>  
                             
                   </div><center>
                  <div id="loader12"> </div></center>
           </div>
       </div>
 <center><div id="loader1"></div> </center>
    </div>
    <div class="row" id="reportdata">

    </div
           

<div class="bs-example">
 <div id="myModal" class="modal fade modal-fullscreen">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
</div>

  
<script>
  $(document).ready(function (){
      
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});

    $('#myModal').fullscreen();
   
  });
</script>

    
  
 
    
    


