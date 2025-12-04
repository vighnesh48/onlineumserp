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
                stream_id:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'stream should not be empty'
                      }
                    }

                },
				semester:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'semester should not be empty'
                      }
                    }

                },
            }       
        })
		
		// Num check logic
		$('.numbersOnly').keyup(function () {
			if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
			   this.value = this.value.replace(/[^0-9\.]/g, '');
			} 
		});
		//

		$('#dt-datepicker').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
    });

</script>
<style>
.table {
    width: 100%;
max-width: 100%;
}
.table-warning thead{border-color: #de9328 !important;
color: #fff!important;}
.table-warning thead tr {
    background: #e9a23b !important;
}
</style>
<?php
//echo $academic_year;
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Topics </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Topics and SubTopics</h1>
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
                            <span class="panel-title">Select Following Parameters</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/topic')?>" method="POST">    <div class="form-group">

                              <div class="col-sm-2" >
                                <select name="batch" id="batch" class="form-control" required>
                                  <option value="">Select Batch</option>
                                  <?php
                                    foreach ($batches as $reg) {
                                        if ($reg['batch'] == $batch) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $reg['batch'] . '"' . $sel . '>' . $reg['batch'] . '</option>';
                                    }
                                    ?>
                               </select>
                              </div>
                              <div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" required>
                                  <option value="">Select Course</option>
                                  <?php
									foreach ($course_details as $course) {
										if ($course['course_id'] == $courseId) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
									}
									?>
                               </select>
                              </div> 
                              <div class="col-sm-3" id="semest" >
                                <select name="stream_id" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                               </select>
                              </div>
								<div class="col-sm-2">
									<select id="semester" name="semester" class="form-control">
											<option value="">Semester</option>
											<?php 
											$semesterNo = $semesterNo;
											for($i=1;$i<9;$i++) {
												if ($i == $semesterNo) {
													$sel3 = "selected";
												} else {
													$sel3 = '';
												}
											?>
											<option value="<?=$i?>" <?=$sel3?>><?=$i?></option>
											<?php } ?>
									</select>
								</div> 
								
								<div class="col-sm-2"><input type="submit" class="btn btn-primary form-control" value="Search"></div>
								
                            </div>
							</form>
                        </div>
                    </div>
                </div>

            </div>    
        </div>
		  <div class="row ">
			<!--form id="form" name="form" action="<?=base_url($currentModule.'/markAttendance')?>" method="POST"-->    
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname">Report Details : 
							<?php 
							if($batch !=0){
								$batch_to = $batch;
							}else{
								$batch_to = "";
							}
							if(!empty($subdetails)){
								echo $subdetails[0]['subject_short_name'].'('.$subdetails[0]['subject_code'].')-'.$division.''.$batch_to;
							}
							?>
							</span>
                    </div>
                    <div class="panel-body">
						<div class="col-sm-12">
						
                        <div class="table-info12">  
							
							<table class="table table-bordered">
							<thead style="background: #3da1bf !important;border-top-color: #3da1bf !important;color: #fff;border-color: #e2e2e2;">
								<tr>	
									<th>#</th>
                                    <th>Stream</th>
                                    <th>Sem</th>
                                    <th>Subject code</th>
                                    <th>Subject Name</th>
                                    <th>Topic</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
								$CI =& get_instance();
								$CI->load->model('Subject_model');
								//echo "<pre>";
								//print_r($attendance_data);
								$i=1;
									if(!empty($subj_details)){
										foreach ($subj_details as $sub) {	
	
												?>
													<tr>
														<td><?=$i?></td>
														<td><?=$sub['stream_name']?></td>
														<td><?=$sub['semester']?></td>
														<td><?=$sub['subject_code']?></td>
														<td><?=$sub['subject_name']?></td>
														<td>
														<button type="button" id="<?=$sub['sub_id']?>" class="btn btn-info" onclick="toggle_details(this.id);">View</button>
														<button type="button" class="btn btn-info" onclick="add_subjects(<?=$sub['sub_id']?>);">Add</button>
														</td>
													</tr>
							<tr>
								<td colspan=9  id="details_<?=$sub['sub_id']?>" style="display:none">
									<div class="row">
<div class="col-sm-6">									
									<table class="table table-bordered" >
														
										<thead>
											<tr  style="background:#e9a23b !important">	
												<th>Topic No.</th>
												<th>Topic Name</th>
												<th>View</th>									
											</tr>
											</thead>
											<tbody id="studtbl">
											<?php
											//error_reporting(E_ALL);
											//echo $sub['sub_id'];exit;
											//$topc = $this->Subject_model->get_topic_details($sub['sub_id']);
											$topc =$CI->Subject_model->get_topic_details($sub['sub_id']);
									if(!empty($topc)){
										foreach($topc as $tpc){
												?>
													<tr>
														<td width="20%"><?=$tpc['topic_no']?></td>
														<td><?=$tpc['topic_name']?></td>
														
														<td width="15%"><button type="button" class="btn btn-info" onclick="toggle_view(<?=$tpc['subject_id']?>, <?=$tpc['topic_no']?>);">view</button></td>
														
													</tr>
															<?php 
														
														}
													}else{
														echo "<tr><td colspan=3>No data found.</td></tr>";
													}
												?>
															</tbody>
														</table></div>
														<div class="col-sm-6" id="view_subtopics">
															
														</div>
														</div>
														</td>
													</tr>
															<?php 
												}
										
											}else{
												echo "<tr><td colspan=9>No data found.</td></tr>";
											}
												?>
								</tbody>
							</table>
							
						</div>
                    </div>
                </div>
			</div>
			<!--/form-->		
		</div>
			
    </div>
</div>
<script>
	function toggle_details(id){
		$("#details_"+id).toggle( "slow", function() {
			});

	}
		function toggle_view(subid, top_no){
			//alert(top_no);
		if (top_no) {
			$.ajax({
				'url' : base_url + '/Subject/get_subtopic_details',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'subject_id' : subid,'topic_id':top_no},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#view_subtopics'); //jquery selector (get element by id)
					if(data){
						container.html(data);						
					}
				}
			});
		}
			

	}
	function add_subjects(id){
		var url = '<?=base_url()?>';
		window.location.href=url+"subject/add_topics/"+id;
	}	

$(document).ready(function () {
		var course_id = $("#course_id").val();
		//alert(course_id);
		if (course_id) {
			$.ajax({
				'url' : base_url + '/Batch_allocation/load_streams',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course_id' : course_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#stream_id'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?=$streamId ?>';
						container.html(data);
						$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
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
		
		$("#semester").change(function(){
			var streamId = $("#stream_id").val();
			var course_id = $("#course_id").val();
			var semesterId = $("#semester").val();
			
			$.ajax({
				'url' : base_url + 'Batch_allocation/load_subject',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course' : course_id,'streamId':streamId,'semesterId':semesterId},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#subject'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						container.html(data);
						//$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		});
		$('#course_id').on('change', function () {
			
			var course_id = $(this).val();
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>batch_allocation/load_streams',
					data: 'course_id=' + course_id,
					success: function (html) {
						//alert(html);
						$('#stream_id').html(html);
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
});
</script>