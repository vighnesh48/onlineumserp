<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

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
                var report_type = 2;//$("#report_type").val();
				 var partner = $("#partner").val();
                  if(academic_year=="" ||admission_type==""||report_type=="" || partner=="" ){
                      alert("Please select All  Options ");
                  }
                  else {
					   //academic_year = academic_year.split("-");
					  // academic_year=academic_year[1];
                      $("#loader1").html('<div class="loader"></div>');
                      $.ajax({
                                'url' : base_url + 'Kp_report/get_admission_fees_report',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'report_type':report_type,'admission_type':admission_type,'act':'view','partner':partner},
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
                var report_type = 2;//$("#report_type").val();
                var partner = $("#partner").val();
				
                   if(academic_year=="" ||admission_type==""||report_type=="" || partner=="" ){
                      alert("Please select All  Options ");
                  }
                  else
                  {
					    //academic_year = academic_year.split("-");
					   //academic_year=academic_year[1];
                      // $("#loader1").html('<div class="loader"></div>');
                       $("#FrmAdm").submit();
                       
                        $.ajax({
                                'url' : base_url + 'Kp_report/get_admission_fees_report',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'academic_year':academic_year,'report_type':report_type,'admission_type':admission_type,'act':'excel','partner':partner},
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
        <li><a href="#">Kp_report</a></li>
        <li class="active">Reports<a href="#"></a></li>
    </ul>
   <form action="<?=base_url($currentModule.'/get_admission_fees_report');?>" method="POST" id="FrmAdm">
     
    <div class="page-header">
      <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title form-group"><i class="fa fa-list-alt page-header-icon h3"></i>&nbsp;&nbsp;KP Report</span>
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
													<option value="2023">2023-24</option>
													<option value="2022">2022-23</option>
													<option value="2021">2021-22</option>
													<option value="2020">2020-21</option>
													<option value="2019">2019-20</option>
									           	</select>
                						    </div>
											
											<div class="col-sm-2">

                                <select name="partner" id="partner" class="form-control" required>
                                 <option value="">Select partner</option>
								  <option value="All">Select All</option>
                                  <?php $sel='';

														foreach ($partner_list as $list) {
															//$exam_sess = $exsession['academic_year'];
															//$exam_sess_val =  $exsession['session'];
														/*	if ($exam_sess_val == $_POST['academic_year']) {
																$sel = "selected";
															} else {
																$sel = '';
															}*/
															echo '<option value="' . $list['partner_id']. '"' . $sel . '>' .$list['partner_name'].'</option>';
														}
                                                     ?>
                                
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
                						
								            <input type="hidden" name="act" value="excel">
								        <div class="col-sm-1" ><input type="button" class="btn btn-primary form-control" id="btnView" value="view"></div>
								       
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
           

><div class="bs-example">
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

    //$('#myModal').fullscreen();
    
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

    
  
 
    
    


