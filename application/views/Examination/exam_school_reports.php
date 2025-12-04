
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
    var base_url = '<?=base_url();?>';
	function load_streams(type){
                   // alert(type);
                    
		$.ajax({
			'url' : base_url + 'Examination/load_examstreams',
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
 $('#btnView').click(function(){
                var exam_session = $("#exam_session").val();
                var school_code = $("#schoolcode").val();
                var report_type = $("#report_type").val();
                 var type = $("#type").val();
                
                  if(exam_session=="" ||school_code==""||report_type=="" || type==""){
                      alert("Please select All  Options ");
                  }
                  else {
                      $("#loader1").html('<div class="loader"></div>');
                      $.ajax({
                                'url' : base_url + 'Examination/totalreportsummary',
                                'type' : 'POST', //the way you want to send data to your URL
                                'data' : {'exam_session':exam_session,'report_type':report_type,'school_code':school_code,'act':'view','type':type},
                                'success':function (str) {
                                 //alert(str);
                                 
                                  $("#rowdata").css('display','');
                                  $("#reportdata").html(str);
                                   $("#loader1").html("");
                                }
                          });
                      
                  }
                     
                  
        });
//
	$('#exam_session').on('change', function () {	
		var exam_session = $(this).val();
		if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsess_schools',
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
	$('#examsession').on('change', function () {	
		var exam_session = $(this).val();
		if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsess_schools1',
				data: 'exam_session=' + exam_session,
				success: function (html) {
					//alert(html);
					$('#schoolcode').html(html);
				}
			});
		} else {
			$('#school_code').html('<option value="">Select exam session first</option>');
		}
	});	
	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		var exam_session = $("#exam_session").val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examschools',
				data: {school_code:school_code,exam_session:exam_session},
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
		var exam_session = $("#exam_session").val();
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examstreams',
				data: {course_id:admission_course,exam_session:exam_session},
				success: function (html) {
					//alert(html);
					$('#stream_id').html(html);
				}
			});
		} else {
			$('#stream_id').html('<option value="">Select course first</option>');
		}
	}); 
	
	//load semesters
		$('#stream_id').on('change', function () {	
		var stream_id = $("#stream_id").val();
		var exam_session = $("#exam_session").val();
		//alert(admission_course);
		if (stream_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsemesters',
				data: {stream_id:stream_id,exam_session:exam_session},
				success: function (html) {
					//alert(html);
					$('#semester').html(html);
				}
			});
		} else {
			$('#semester').html('<option value="">Select stream first</option>');
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

function load_sessions(type){
                  
              if(type==""){
				alert("please select type");  
			  } else{   
                $.ajax({
                    'url' : base_url + 'Examination/get_exam_sessions',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'type' : type},
                    'success' : function(data){ 
                   
                        if(data){
                         //   alert(data);
                            //alert("Marks should be less than maximum marks");
                            $("#exam_session").html(data);
                           
                        }
                    }
                });
			  }
            }
</script>
<?php 
if(isset($role_id) && $role_id==1 ){
?>
<style>
	.table{width: 150%;}
	table{max-width: 150%;}
</style>									
<?php }else{ ?>
	<style>
	table.dataTable{width: 210%;}</style>
<?php }?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Exam Summary</a></li>
        <li class="active"><a href="#">Reports</a></li>
    </ul>
	
<div class="col-sm-12" >
      <div class="page-header">	
		<div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">  Exam Summary:</span>
				</div>						

        <div class="row panel-body">
                         <form method="post" action="<?=base_url()?>Examination/totalreportsummary">
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							  <div class="col-sm-2">
								<select name="type" id="type" class="form-control" required  onchange="load_sessions(this.value)">
								<option value="">Select Type</option>
								<option value="1" selected>UG/PG Courses</option>
								<option value="2">PHD Courses</option>
								</select>
                              </div>
							 
							 <div class="col-sm-2">
								<select name="exam_session" id="exam_session" class="form-control" required>
								<option value="">Exam Session</option>
								<?php
								foreach ($exam_session as $exsession) {
								$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
								$exam_sess_val = $exsession['exam_month'].'-'.$exsession['exam_year'].'-'.$exsession['exam_id'];
								if ($exam_sess_val == $_POST['exam_session']) {
								$sel = "selected";
								} else {
								$sel = '';
								}
								echo '<option value="' . $exam_sess_val. '"' . $sel . '>' .$exam_sess.'</option>';
								}
								?></select>
                              </div>
							<div class="col-sm-2 hidden">
 
								<select name="school_code" id="schoolcode" class="form-control" required>
								<option value="">Select</option>
								<option value="0" selected>ALL</option>

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
                              <div class="col-sm-2 hidden">
                                <select name="report_type" id="report_type" class="form-control" required>
                                  <option value="">Select</option>
                                   <!--<option value="fresh" <?php if($_REQUEST['report_type'] =='fresh'){ echo "selected";}else{}?>>Fresh </option>
                                   <option value="backlog" <?php if($_REQUEST['report_type'] =='backlog'){ echo "selected";}else{}?>>Backlog</option>-->
                                   <option value="Statistics" selected <?php if($_REQUEST['report_type'] =='Statistics'){ echo "selected";}else{}?>>Statistics </option>
                                                             
                                  </select>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              
                               <div class="col-sm-2" id="semest">
							<input type="button" class="btn btn-primary form-control" id="btnView" value="view">
							</div>
                              <div class="col-sm-2" id="semest">
                                     <input type="hidden" name="act" value="excel">
								        
								       
								      <input type="submit"  class="btn btn-primary form-control" id="btnExcel" value="Excel">
                            </div>
                            
							
                            </div>
                            </form>
                           
							
                         
							
							  
							</div>
                       
            </div> 
<div id="loader12"> </div></center>			
    <div class="row" id="reportdata"> </div>
        </div>
    </div>
</div>
