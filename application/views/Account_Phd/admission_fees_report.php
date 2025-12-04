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
				var school_code = $("#school_code").val();
				var admission_course = $("#admission-course").val();
				var stream_id = $("#stream_id").val();
                  if(academic_year=="" ||admission_type==""||report_type=="" || school_code=="" ){
                      alert("Please select All  Options ");
                  }
                  else {
					   //academic_year = academic_year.split("-");
					  // academic_year=academic_year[1];
                      $("#loader1").html('<div class="loader"></div>');
                      $.ajax({
                                'url' : base_url + '/account/get_admission_fees_report',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'report_type':report_type,'admission_type':admission_type,'act':'view','school_code':school_code,'admission_course':admission_course,'stream_id':stream_id},
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
                var school_code = $("#school_code").val();
				var admission_course = $("#admission-course").val();
				var stream_id = $("#stream_id").val();
                   if(academic_year=="" ||admission_type==""||report_type=="" || school_code=="" ){
                      alert("Please select All  Options ");
                  }
                  else
                  {
					    //academic_year = academic_year.split("-");
					   //academic_year=academic_year[1];
                      // $("#loader1").html('<div class="loader"></div>');
                       $("#FrmAdm").submit();
                       
                        $.ajax({
                                'url' : base_url + '/account/get_admission_fees_report',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'report_type':report_type,'admission_type':admission_type,'act':'excel','school_code':school_code,'admission_course':admission_course,'stream_id':stream_id},
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
   <form action="<?=base_url($currentModule.'/get_admission_fees_report');?>" method="POST" id="FrmAdm">
     
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
                                        <div class="col-sm-2">
                                            	<select id="academic_year" name="academic_year" class="form-control"  required>
        											<option value="">Select Academic Year</option>
													<!---<option value="2019">2019-20</option>
        												<option value="2018">2018-19</option>
        												<option value="2017">2017-18</option>
        													<option value="2016">2016-17</option>-->
													
													 <?php

														foreach ($exam_session as $exsession) {
															$exam_sess = $exsession['academic_year'];
															$exam_sess_val =  $exsession['session'];
															if ($exam_sess_val == $_POST['academic_year']) {
																$sel = "selected";
															} else {
																$sel = '';
															}
															echo '<option value="' . $exam_sess_val. '"' . $sel . '>' .$exam_sess.'</option>';
														}
                                                     ?>
													
									           	</select>
                						    </div>
											
											<div class="col-sm-2">

                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select School</option>
                                  <option value="0" <?php if($_POST['school_code']==0){ echo "selected";}else{}?>>All School</option>
                                
                              </select>
                              </div>
							  <div class="col-sm-2">
                                <select name="admission_course" id="admission-course" class="form-control" >
                                 <option value="">Select Course</option>
                                  <option value="0">All Courses</option>
                                  </select>
                              </div>
							  <div class="col-sm-2" id="semest">
                                <select name="stream_id" id="stream_id" class="form-control" >
                                  <option value="">Select Stream</option>
                                  <option value="0">All Stream</option>
                                  </select>
                              </div>
                                        <div class="col-sm-2">
                                    	        <select id="admission_type" name="admission_type" class="form-control"  required>
        											<option value=""> Select Admission Type</option>
        												<option value="N">New Admission</option>
        											 	<option value="R">Re-Registration</option>
        											 	<option value="A">Both</option>
        												
        													    
									           	</select>
								            </div>
                						<div class="col-sm-2">
                                    	        <select id="report_type" name="report_type" class="form-control"  required>
        											<option value=""> Select Report Type</option>
													<?php $role_id = $this->session->userdata('role_id'); 
													if($role_id==10 || $role_id==20) {
													?>
													<option value="2">Student Wise Fees</option>
													<?php } else { ?>
        												<option value="1">Fees Details</option>
        											 	<option value="2">Student Wise Fees</option>
        												<option value="3">Fees Statistics</option>
        												<option value="4">Fees Outstanding</option>
														<option value="5">Sem Wise Fees Details</option>
														<option value="6">Sem Wise Student Wise Fees</option>
														<option value="7">Sem Wise Fees Statistics</option>
														<option value="8">Sem Wise Fees Outstanding</option>
													<?php } ?>
									           	</select>
								            </div>
								            <input type="hidden" name="act" value="excel">
								        <div class="col-sm-1" style="margin-top:10px;"><input type="button" class="btn btn-primary form-control" id="btnView" value="view"></div>
								       
								        <div class="col-sm-1" style="margin-top:10px;"><input type="submit"  class="btn btn-primary form-control" id="btnExcel" value="Excel"></div>
								        
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
  
  	$('#academic_year').on('change', function () {	
		var exam_session = $(this).val();
		//alert(exam_session);
		if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsess_schools_new',
				data: 'exam_session=' + exam_session,
				success: function (html) {
					//alert(html);
					$('#school_code').html(html);
				}
			});
		} else {
			$('#school_code').html('<option value="">Select exam session first</option>');
		}
	});

	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		var exam_session = $("#academic_year").val();
		//alert(school_code);
		if (school_code) {
		  if(school_code=="All"){
			 $('#admission-course').html('<option value="">Select All</option>');
			  $('#stream_id').html('<option value="">Select All</option>');
			  
		  }
		  else{
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examschools_new',
				data: {school_code:school_code,exam_session:exam_session},
				success: function (html) {
					//alert(html);
					$('#admission-course').html(html);
				}
			});
		  }
		} else {
			$('#admission-course').html('<option value="">Select course first</option>');
		}
	}); 

$('#admission-course').on('change', function () {	
		var admission_course = $("#admission-course").val();
		var exam_session = $("#academic_year").val();
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_ex_appliedstreams_new',
				data: {course_id:admission_course,exam_session:exam_session},
				success: function (html) {
					//alert(html);
					$('#stream_id').html(html);
					$("#stream_id option[value='" + admission_course + "']").attr("selected", "selected");
				}
			});
		} else {
			$('#stream_id').html('<option value="">Select course first</option>');
		}
	});  	
</script>

    
  
 
    
    


