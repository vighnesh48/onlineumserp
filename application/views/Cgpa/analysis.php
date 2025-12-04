<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<script>    

function getExamDate(id){
	$('#'+id).datepicker( {format: 'dd/mm/yyyy',autoclose: true});
	$('#'+id).focus();
	return true;
}
    var base_url = '<?=base_url();?>';
	function load_streams(type){
                   // alert(type);
                    
		$.ajax({
			'url' : base_url + '/Examination/load_streams',
			'type' : 'POST', //the way you want to send data to your URL
			'data' : {'course' : type},
			'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
				var container = $('#semest'); //jquery selector (get element by id)
				if(data){
				 //   alert(data);
					//alert("Marks should be less than maximum marks");
					//$("#"+type).val('');
					container.html(data);
				}
			}
		});
	}
$(document).ready(function(){
			   
	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_schools',
				data: 'school_code=' + school_code,
				success: function (html) {
					//alert(html);
					$('#admission-course').html(html);
				}
			});
		} else {
			$('#admission-course').html('<option value="">Select course first</option>');
		}
	});  
// edit
var school_code = '<?=$school_code?>';

		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_schools',
				data: 'school_code=' + school_code,
				success: function (html) {
					//alert(html);
					var course_id = '<?=$admissioncourse?>';
					$('#admission-course').html(html);
					$("#admission-course option[value='" + course_id + "']").attr("selected", "selected");
				}
			});
		} else {
			
			$('#admission-course').html('<option value="">Select course first</option>');
		}	
		//load streams
		$('#admission-course').on('change', function () {	
		var admission_course = $("#admission-course").val();
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_streams',
				data: 'course_id=' + admission_course,
				success: function (html) {
					//alert(html);
					$('#stream_id').html(html);
				}
			});
		} else {
			$('#stream_id').html('<option value="">Select course first</option>');
		}
	}); 
	// edit
var admission_course = '<?=$admissioncourse?>';

		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_streams',
				data: 'course_id=' + admission_course,
				success: function (html) {
					//alert(html);
					var stream_id = '<?=$stream?>';
					$('#stream_id').html(html);
					$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
				}
			});
		} else {
			
			$('#stream_id').html('<option value="">Select course first</option>');
		}	
});
</script>

<style>
	.table{width: 100%;}
	table{max-width: 100%;}
</style>									

<div id="content-wrapper">
    
    <div class="page-header">
    	<div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-list page-header-icon"></i>&nbsp;&nbsp; Result Analysis</h1>
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
                        <span class="panel-title">
                            <form method="post" action ="<?=base_url()?>Results/analysis_excel" id="formId">	
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							 <div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required>
                                 <option value="">Exam Session</option>
                               
                                  <?php

									foreach ($exam_session as $exsession) {
										$exam_sess =$exsession['exam_id'];
									    if ($exam_sess == $_POST['exam_session']) {
									        $sel = "selected";
									    } else {
									        $sel = '';
									    }
									    echo '<option value="' . $exam_sess. '"' . $sel . '>' .$exsession['exam_month'] .'-'.$exsession['exam_year'].'</option>';
									}
									?>
									<option value="9">DEC-2018</option>
									<option value="10">MAR-2019</option></select>
                              </div>
							<div class="col-sm-2">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select School</option>
                                 <option value="0">All School</option>
                                  <?php
									foreach ($schools as $sch) {
									    if ($sch['school_code'] == $school_code) {
									        $sel = "selected";
									    } else {
									        $sel = '';
									    }
									    echo '<option value="' . $sch['school_code'] . '"' . $sel . '>' . $sch['school_short_name'] . '</option>';
									}
									?></select>
                              </div>
                              <div class="col-sm-2">
                                <select name="admission-course" id="admission-course" class="form-control" required>
                                 <option value="">Select Course</option>
                                  <option value="0">All Courses</option>
                                  </select>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-3" id="semest">
                                <select name="report_type" id="report_type" class="form-control" required>
                                  <option value="">Select Report</option>
                                  <option value="1">Program Wise Report</option>
                                  <option value="2">Subject Wise Report</option>
                                  </select>
                              </div>

                              <div class="col-sm-2" id="semest">
                                 <input type="button" id="search_btn" class="btn btn-primary btn-labeled" value="View" > 
                                   <input type="button" id="search_excel" class="btn btn-primary btn-labeled" value="Excel" > 
                            </div>
                             <!--<div class="col-sm-3" id="semest">
                               <a href="<?=base_url()?>Ums_admission/generateallpdfs">  <input type="button" id="" class="btn btn-primary btn-labeled" value="Generate All" > </a>
                            </div>-->
                            </div>
                            </form>
                        </span>
                        <div class="holder1"></div>
                </div>

            <div class="table-info panel-body" >  
            	<div id="rgm" style="color:green;margin-left: 15px;"><div id="resp" style="display:none;"><img src='<?=base_url()?>assets/images/demo_wait_b.gif' /></div></div>
		        <div class="row">
                <div class="col-lg-12">
                    <div class="table-info" id="stddata">    
	
			
 
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
<script>

$("#search_btn").click(function(){
    var exam_session=$("#exam_session").val();
     var school_code=$("#school_code").val();
      var course_code=$("#admission-course").val();
       var report_type=$("#report_type").val();
      // alert(exam_session+"-"+school_code+"-"+course_code+"-"+report_type);
      if(exam_session==""||school_code==""||report_type==""||report_type==""){
          alert("Please select the proper options...");
           
       }
       else{
           	$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Results/analysis',
						data: {exam_session:exam_session,school_code:school_code,course_code:course_code,report_type:report_type,data_format:'html'},
						success: function (data1) {
							//alert(data1);
								$("#stddata").html(data1);
						}
					});
       }
       
});
$("#search_excel").click(function(){
    var exam_session=$("#exam_session").val();
     var school_code=$("#school_code").val();
      var course_code=$("#admission-course").val();
       var report_type=$("#report_type").val();
      // alert(exam_session+"-"+school_code+"-"+course_code+"-"+report_type);
      if(exam_session==""||school_code==""||report_type==""||report_type==""){
          alert("Please select the proper options...");
           
       }
       else{
           	 $("#formId").submit();
       }
       
});



</script>