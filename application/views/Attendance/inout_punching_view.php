<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
<script>
$(document).ready(function() {
	
			$('#academic_year').on('change', function () {
			var academic_year = $(this).val();
			if (academic_year) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttcources',
					data: {academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#course_id').html(html);
					}
				});
			} else {
				$('#course_id').html('<option value="">Select academic year first</option>');
			}
		});
		$('#course_id').on('change', function () {
			var academic_year =$("#academic_year").val();
			var course_id = $(this).val();
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Timetable/load_tt_streams',
					data: {course_id:course_id,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#stream_id').html(html);
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		$('#stream_id').on('change', function () {
			var stream_id = $(this).val();
			var academic_year =$("#academic_year").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttsemesters',
					data: {stream_id:stream_id,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#semester').html(html);
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		});
		$('#semester').on('change', function () {
			var semester = $(this).val();
			var stream_id =$("#stream_id").val();
			var academic_year =$("#academic_year").val();
			if (semester) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttdivision',
					data: {stream_id:stream_id,academic_year:academic_year,stream_id:stream_id, semester:semester},
					success: function (html) {					
						$('#division').html(html);
						
					}
				});
			} else {
				$('#division').html('<option value="">Select Stream first</option>');
			}
		});
    var printCounter = 0;
} ); 
</script>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';   
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Class Students</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; IN/Out Punching Students List</h1>
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
                          <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />
								<div class="form-group">
								<div class="col-sm-2" >
                               <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
									foreach ($academic_year as $yr) {
										if ($yr['academic_year'].'~'.$yr['academic_session'] == $academicyear) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session']. '"' . $sel . '>' . $yr['academic_year'] .' ('.$yr['academic_session'].')</option>';
									}
									?>
									<!--option value="2023-24~SUMMER">2023-24 (SUMMER)</option-->
									<option value="2024-25~WINTER">2024-25 (WINTER)</option>
                               </select>
                              </div>
                              <div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" required>
                                  <option value="">Select Course</option> 
                               </select>
                              </div> 
                              <div class="col-sm-2" id="semest" >
                                <select name="stream_id" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                               </select>
                              </div>
							  <div class="col-sm-2">
									<select id="semester" name="semester" class="form-control" >
                                         <option value="">Select Semester</option>
									</select>
								</div> 
								<div class="col-sm-2" >
                                <select name="division" id="division" class="form-control" required>
                                  <option value="">Select Division</option>
                               </select></div>                             
                                <div class="col-sm-2">
								<input type="text" class="form-control" name="log_date" id="dt-datepicker1" value="<?=date('Y-m-d')?>" placeholder="Log Date" required ></div>
								</div>
							  <div class="form-group">
								<div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
                            </div>
                    </div>
                </div>
            </div>    
        </div>
	  <div class="row ">		   
            <div class="col-sm-12">
				<div class="panel">				 
                    <div class="panel-body" style="overflow:scroll;">
						<div class="col-sm-12">
						<div id="wait" style="display:none;"><div class="loader"></div><br>Loading..</div>
                        <div class="table-info" id="studtbl" >  
						</div>
                    </div>
                </div>
			</div>			
		</div>
    </div>		
    </div>
</div>
<script>
$(document).ready(function () {

	$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
	///////////////////////////////
	// fetch stream form course
	var stream_id = $("#semester").val();
	if(stream_id !=''){
		$("#sem_id").val(stream_id);
	    }
		// fetch subject of sem_acquire
		$("#stream_id").change(function(){
			//alert("hi");
		  $('#semester option').attr('selected', false);
		});
		});

  
$('#btn_submit').click(function(){
var academic_year =$('#academic_year').val();
var course_id = $('#course_id').val();
var stream_id = $('#stream_id').val();
var semester = $('#semester').val();
var division = $('#division').val();
var log_date = $('#dt-datepicker1').val();
var base_url ='<?=base_url() ?>';
       if(academic_year =='' || course_id=='' || stream_id=='' || semester=='' || division=='' || log_date=='' )
	   {
		   alert("All Fields Required");
	   }else
	   {
		   $("#wait").css("display", "block");
     $.ajax({
				'url' : base_url + 'Student_attendance/search_inout_punching_Students',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'academic_year':academic_year,'course_id':course_id,'stream_id':stream_id,'semester':semester,'division':division,'log_date':log_date},
				'success' : function(data){ 
					if(data){						
						$('#studtbl').html(data);
                        $("#wait").css("display", "none");						
					}
					
				}
			});
	       }
		});
</script>
