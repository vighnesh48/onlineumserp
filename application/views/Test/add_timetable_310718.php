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
                subject_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'please enter subject name'
                      }
                    }

                },
                subject_code:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'time table code should not be empty'
                      },
                      stringLength: 
                        {
                        max: 20,
                        min: 2,
                        message: 'time table code should be 2-20 characters.'
                        }
                    }
                },
                subject_type:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Time table type should not be empty'
                      }
                    }
                },
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
				sub_type:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'lecture type should not be empty'
                      }
                    }

                },
				room_no1:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'Room No should not be empty'
                      }
                    }

                },
				division:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'division should not be empty'
                      }
                    }

                },
				faculty1:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'faculty should not be empty'
                      }
                    }

                },
				lecture_slot:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'slot should not be empty'
                      }
                    }

                },
				subject:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'subject should not be empty'
                      }
                    }

                },
				wday:
                {
                    validators: 
                    {                      
                      notEmpty: 
                      {
                       message: 'week day should not be empty'
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
		var course_id = $("#course_id").val();
		//alert(course_id);
		if (course_id) {
			$.ajax({
				'url' : base_url + 'subject/load_streams',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course' : course_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semest'); //jquery selector (get element by id)
					//alert(data);
					if(data){
						var stream_id_session = '<?= $streamId ?>';
						var stream_id_edit = '<?= $ttdet[0]['stream_id'] ?>';
						if(stream_id_session !=''){
							var stream_id = stream_id_session;
						}else if(stream_id_edit !=''){
							var stream_id = stream_id_edit;
						}else{
							var stream_id='';
						}
						//alert(stream_id);
						container.html(data);
						$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
		
		var semesterId = '<?php if($semesterNo !=''){echo $semesterNo;}else{ echo $ttdet[0]['semester'];} ?>';
		if(semesterId !=''){
			var streamId = '<?php if($streamId !=''){echo $streamId;}else{ echo $ttdet[0]['stream_id'];} ?>';
			var course_id = '<?php if($courseId !=''){echo $courseId;}else{ echo $ttdet[0]['course_id'];} ?>';
			
			//alert(semesterId);alert(streamId);alert(course_id);
			$.ajax({
				'url' : base_url + '/Timetable/load_subject',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course' : course_id,'streamId':streamId,'semesterId':semesterId},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#subject'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						var sub = '<?php if($Tsubject !=''){echo $Tsubject;}else{ echo $ttdet[0]['subject_code'];} ?>';
						container.html(data);
						$("#subject option[value='" + sub + "']").attr("selected", "selected");
					}
				}
			});
		}
		// subjuct type change batch selection
		// for theroy there should not be any batch
		$("#sub_type").change(function(){
		    var subtype = $("#sub_type").val();
		    if(subtype=="TH"){
		        $("#batch_no").html("<option value=''>Select</option><option value='0'>No Batch</option>");
		        //$("#batch_no option[value='0']").attr("selected", "selected");
		    }else{
				//$("#batch_no").prop('required',true);
		        $("#batch_no").html("<option value=''>Select</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option>");
		    }
		    
		});
		
		$("#batch_no").change(function(){
		    var batch_no = $("#batch_no").val();
		    if(batch_no !=''){
		        $("#batch").html("");
				$("#btn_submit").prop('disabled', false);
				$("#btn_submit1").prop('disabled', false);
		        //$("#batch_no option[value='0']").attr("selected", "selected");
		    }else{
				
		    }
		    
		});
		
		var subtype1 = '<?=$ttdet[0]['subject_type']?>';
		//alert(subtype1);
			if(subtype1){
				
		    if(subtype1=="TH"){
			//	alert('hi');
		        $("#batch_no").html("<option value=''>Select</option><option value='0'>No Batch</option>");
		        $("#batch_no option[value='0']").attr("selected", "selected");
		    }
			}
		
		// revert semester id
		$("#stream_id").change(function(){
		  $('#semester option').attr('selected', false);
		});
		
		$("#semester").change(function(){
			var streamId = $("#stream_id").val();
			var course_id = $("#course_id").val();
			var semesterId = $("#semester").val();
			
			$.ajax({
				'url' : base_url + '/Timetable/load_subject',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course' : course_id,'streamId':streamId,'semesterId':semesterId},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#subject'); //jquery selector (get element by id)
					if(data){
						//var stream_id = '<?= $ttdet[0]['stream_id'] ?>';
						container.html(data);
						//$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		});
		//fetch department
		$("#school").change(function(){
			var school_id = $("#school").val();		
			$.ajax({
				'url' : base_url + '/Timetable/load_department',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'school_id' : school_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#dept'); //jquery selector (get element by id)
					if(data){
						container.html(data);
					}
				}
			});
		});
		//fetch faculty
		$("#dept").change(function(){
			var school_id = $("#school").val();		
			var dept = $("#dept").val();
			var faculty_type = $("#faculty_type").val();
			$.ajax({
				'url' : base_url + '/Timetable/load_faculty',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'school_id' : school_id,'dept_id':dept, 'faculty_type':faculty_type},
				'success' : function(data1){ //probably this request will return anything, it'll be put in var "data"
					var container1 = $('#faculty_id'); //jquery selector (get element by id)
					if(data1){
						container1.html(data1);
					}
				}
			});
		});
		//Asign faculty 
		$("#faculty_id").change(function(){
			var fac_id = $("#faculty_id").val();	
			if(fac_id !=''){
				$("#faculty").val(fac_id);
				$("#faculty_val").html("");
			}else{
				$("#faculty").val('');
			}
		});
    });
function checkOfflecture(){
	var subjectval = $("#subject").val();	
	//alert(subjectval);
	if(subjectval=='OFF'){
		$("#faculty").prop('required',false);;
		//alert('inside');
		
	}
}
function validate_batch(){
	var batch = $("#batch_no").val();	
	var faculty = $("#faculty").val();	
	//alert(batch);
	if(batch==''){
		$("#batch_no").prop('required',true);
		$("#batch").html("Please select batch");
		//alert('please select batch');
		$("#batch_no").focus();
		return false;
		//alert('inside');
		
	}else if(faculty==''){
		$("#faculty").prop('required',true);
		$("#faculty_val").html("Please select faculty");
		//alert('please select faculty');
		$("#faculty").focus();
		return false;
		//alert('inside');
		
	}else{
	return true;
	}
}
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
	$tp = $this->uri->segment(3);
	if($tp!=''){
		$ed ="Edit";
	}else{
		$ed ="Add";
	}
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#"><?=$ed?> Time table</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<?=$ed?> Time table</h1>
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
                        <div class="row ">
						<div class="col-sm-3">
							<span class="panel-title">Time table</span>
						</div>	
							<?php
							if ($this->session->flashdata('dup_msg') != ''){
							?>
							<div class="col-sm-9" style="color:red;float:left;font-weight: 900;">
						
						<?php
							if ($this->session->flashdata('dup_msg') != ''): 
								echo $this->session->flashdata('dup_msg'); 
							endif;
							?>
							</div>
							
						
							<?php
							}
							if ($this->session->flashdata('Tmessage') != ''){
							?>
							<div class="col-sm-9" style="color:green;float:left;font-weight: 900;">
							
							<?php
							if ($this->session->flashdata('Tmessage') != ''): 
								echo $this->session->flashdata('Tmessage'); 
							endif;
							?>
							</div>
							<?php }?>
					</div>
                    </div>

                    <div class="panel-body">
                        <div class="table-info">                            
                            <?php if(!empty($ttdet[0]['time_table_id'])) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/update_timetable')?>" method="POST" onsubmit="return validate_batch()">  
							<?php }else{ ?>
							<form id="form" name="form" action="<?=base_url($currentModule.'/insert_timetable')?>" method="POST" onsubmit="return validate_batch()">  
							<?php }?>							
                                <input type="hidden" value="<?=isset($ttdet[0]['time_table_id']) ? $ttdet[0]['time_table_id'] : ''?>" id="time_table_id" name="time_table_id" />							<div class="form-group">							<div class="col-sm-3">Academic year <?=$astrik?></div>                              <div class="col-sm-3" >                                <select name="academic_year" id="academic_year" class="form-control" required>                                  <option value="">Select Academic Year</option>                                  <?php                                  if($ttdet[0]['academic_session']=='WIN'){                                  	$curr_sess = "WINTER";                                  }else{                                  	$curr_sess = "SUMMER";                                  }                                  if($ttdet[0]['academic_year'] !=''){                                  		$acad_year =$ttdet[0]['academic_year'].'~'.$curr_sess;                                  }else{                                  	$acad_year = $academicyear;                                  }                                  									foreach ($academic_year as $yr) {										if ($yr['academic_year'].'~'.$yr['academic_session'] == $acad_year) {											$sel = "selected";										} else {											$sel = '';										}										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session']. '"' . $sel . '>' . $yr['academic_year'] .'-'.$yr['academic_session'].'</option>';									}									?>                               </select>                              </div>                              </div>
							<div class="form-group">
							<div class="col-sm-3">Course <?=$astrik?></div>
                              <div class="col-sm-3" >
                                <select name="course_id" id="course_id" class="form-control" onchange="load_streams(this.value)" required>
                                  <option value="">Select Course</option>
                                  <?php
									foreach ($course_details as $course) {
										if($ttdet[0]['course_id'] !=''){
											$courseIdT = $ttdet[0]['course_id'];
										}else{
											$courseIdT = $courseId;
										}
										if ($course['course_id'] == $courseIdT) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_name'] . '</option>';
									}
									?>
                               </select>
                              </div>
                              <script>
                                     var base_url = '<?php
										echo site_url();
										?>';
                                      function load_streams(type){
											   // alert(type);
												
											$.ajax({
												'url' : base_url + 'timetable/load_streams',
												'type' : 'POST', //the way you want to send data to your URL
												'data' : {'course' : type},
												'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
													var container = $('#stream_id'); //jquery selector (get element by id)
													if(data){
													 //   alert(data);
														//alert("Marks should be less than maximum marks");
														//$("#"+type).val('');
														container.html(data);
													}
												}
											});
										}
										
                                    </script>
                              <div class="col-sm-3">Stream <?=$astrik?></div>
                              <div class="col-sm-3" id="semest" >
                                <select name="stream_id" class="form-control" id="stream_id" required>
                                  <option value="">Select Stream </option>
                                  
                               </select>
                              </div>	
                            </div>
                                <div class="form-group">
									<div class="col-sm-3">Semester <?=$astrik?></div>
									<div class="col-sm-3">
									<select id="semester" name="semester" class="form-control">
                                            <option value="">Select Semester</option>
											<?php 
											if($semesterNo !=''){ $semT = $semesterNo;}else{$semT = $ttdet[0]['semester'];}
											for($i=1;$i<9;$i++) {
												if ($i == $semT) {
													$sel3 = "selected";
												} else {
													$sel3 = '';
												}
											?>
                                            <option value="<?=$i?>" <?=$sel3?>><?=$i?></option>
                                            <?php } ?>
									</select>
									</div> 
									<label class="col-sm-3">Division<?=$astrik?></label>
									<div class="col-sm-3">
									<?php
										if($division !=''){ $divT = $division;}else{$divT = $ttdet[0]['division'];}
									?>
									    <select id="division" name="division" class="form-control"/>
										<option value="">Select</option>
										<option value="A" <?php if(!empty($divT) && $divT =='A'){ echo "selected";}?>>A</option>
										<option value="B" <?php if(!empty($divT) && $divT =='B'){ echo "selected";}?>>B</option>
										<option value="C" <?php if(!empty($divT) && $divT =='C'){ echo "selected";}?>>C</option>
										<option value="D" <?php if(!empty($divT) && $divT =='D'){ echo "selected";}?>>D</option>
										<option value="E" <?php if(!empty($divT) && $divT =='E'){ echo "selected";}?>>E</option>
										<option value="F" <?php if(!empty($divT) && $divT =='F'){ echo "selected";}?>>F</option>										
									</select>
									
									</div> 									

                                </div>

                                <div class="form-group">
                                    
                                    
                                </div>
                                <div class="form-group">
									<label class="col-sm-3">Subject <?=$astrik?></label>                                    
									<div class="col-sm-3">
                                        <select id="subject" name="subject" class="form-control" onchange="checkOfflecture()" >
                                            <option value="">Select Subject</option>	
										</select>											
                                    </div>  
                                    <label class="col-sm-3">Lecture Type<?=$astrik?></label>
                                    <div class="col-sm-3">
									<select id="sub_type" name="sub_type" class="form-control"/>
										<option value="">Select</option>
										<option value="TH" <?php if(!empty($ttdet[0]['subject_type']) && $ttdet[0]['subject_type'] =='TH'){ echo "selected";}elseif(!empty($Tsub_type) && $Tsub_type =='TH'){ echo "selected"; }?>>Theory</option>
										<option value="PR" <?php if(!empty($ttdet[0]['subject_type']) && $ttdet[0]['subject_type'] =='PR'){ echo "selected";}elseif(!empty($Tsub_type) && $Tsub_type =='PR'){ echo "selected"; }?>>Practical</option>
									</select>
									</div>                                    
                                     
                                </div>                                
                                <div class="form-group">
                                    
									<label class="col-sm-3">Lecture Slot<?=$astrik?></label>
								    <div class="col-sm-3">
										<select id="lecture_slot" name="lecture_slot" class="form-control"/>
										<option value="">Select</option>
										<?php
										foreach ($slot as $slt) {
										
												if ($slt['lect_slot_id'] == $ttdet[0]['lecture_slot']) {
													$sel4 = "selected";
												} else {
													$sel4 = '';
												}
											echo '<option value="'.$slt['lect_slot_id'].'" '.$sel4.'>'.$slt['from_time'].' - '.$slt['to_time'].' '.$slt['slot_am_pm'].'</option>';
										}
										?>
									</select>
									</div>
                                    <label class="col-sm-3">Week Day<?=$astrik?></label>
								    <div class="col-sm-3">
										<select id="wday" name="wday" class="form-control"/>
										<option value="">Select</option>
										<option value="Monday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Monday'){ echo "selected";}?>>Monday</option>
										<option value="Tuesday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Tuesday'){ echo "selected";}?>>Tuesday</option>
										<option value="Wednesday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Wednesday'){ echo "selected";}?>>Wednesday</option>
										<option value="Thursday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Thursday'){ echo "selected";}?>>Thursday</option>
										<option value="Friday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Friday'){ echo "selected";}?>>Friday</option>
										<option value="Saturday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Saturday'){ echo "selected";}?>>Saturday</option>
										<option value="Sunday" <?php if(!empty($ttdet[0]['wday']) && $ttdet[0]['wday'] =='Sunday'){ echo "selected";}?>>Sunday</option>
									</select>								
									</div>
                                </div>
                                <div class="form-group">
									<label class="col-sm-3">Class Room<?=$astrik?></label>
									<div class="col-sm-3">
									<input type="text" id="room_no" name="room_no" class="form-control" value="<?php if(!empty($ttdet[0]['room_no'])){ echo $ttdet[0]['room_no'];}?>" />
									
									</div>
                                    <label class="col-sm-3">Faculty<?=$astrik?></label>
                                    <div class="col-sm-3"><a href="" data-toggle="modal" data-target="#loginbox" style="text-decoration:none;"><input type="text" id="faculty" name="faculty" class="form-control" value="<?=isset($ttdet[0]['faculty_code']) ? $ttdet[0]['faculty_code'].'/'.$f_name[0]['fname'][0].'. '.$f_name[0]['mname'][0].'. '.$f_name[0]['lname'] : $Tfaculty?>"/></a>
										<div id="faculty_val" style="color:red;margin-top:2px;"></div>
									</div>                                 
                                    
                                </div>
                                 <div class="form-group">
									
                                    <label class="col-sm-3">Batch<?=$astrik?></label>
                                    <div class="col-sm-3"><select id="batch_no" name="batch_no" class="form-control"/>
										<option value="">Select</option>
										<option value="1" <?php if(!empty($ttdet[0]['batch_no']) && $ttdet[0]['batch_no'] =='1'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='1'){ echo "selected"; }?>>1</option>
										<option value="2" <?php if(!empty($ttdet[0]['batch_no']) && $ttdet[0]['batch_no'] =='2'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='2'){ echo "selected"; }?>>2</option>
										<option value="3" <?php if(!empty($ttdet[0]['batch_no']) && $ttdet[0]['batch_no'] =='3'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='3'){ echo "selected"; }?>>3</option>
										<option value="4" <?php if(!empty($ttdet[0]['batch_no']) && $ttdet[0]['batch_no'] =='4'){ echo "selected";}elseif(!empty($Tbatch_no) && $Tbatch_no =='4'){ echo "selected"; }?>>4</option>										
									</select>
									<div id="batch" style="color:red;margin-top:2px;"></div>
									</div> 
									
                                    
                                </div>
								
                                <div class="clearfix">&nbsp;</div>
                                <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
										<?php if($tp !=''){?>
                                        <button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Update</button> 
										<?php }else{?>  
										<button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button> 
										<?php }?>                                        										
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/ttlist'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            <?php //} ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    <!----------------- View table list------------------------------->
	<?php if($tp ==''){?>
<div class="row ">
            <div class="col-sm-12">
                <div class="panel">
				<div class="panel-heading">
                        <span class="panel-title">Time Table</span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body">
                    <div class="table-info" style="overflow:scroll;height:400px;">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <!--th>Academic Year</th>
                                    <th>Stream Name</th>
                                    <th>Semester</th-->
                                    <th>Subject Name</th>
                                    <th>Type</th>
                                    <th>Division</th>
									<th>Batch No</th>
                                    <!--th>Room No</th-->
									<th>Faculty</th>
									<th>Day</th>
									<th>Slot</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;
							if(!empty($tt_details)){
                            for($i=0;$i<count($tt_details);$i++)
                            {
                                
                            ?>
                            <tr <?=$tt_details[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                                <td><?=$j?></td>     
								<!--td><?=$tt_details[$i]['academic_year']?></td>								
                                <td><?=$tt_details[$i]['stream_name']?></td>
                                <td><?=$tt_details[$i]['semester']?></td-->
                                <td>
								<?php
								if($tt_details[$i]['subject_code']== 'OFF'){
									echo "OFF Lecture";
								}else if($tt_details[$i]['subject_code']=='Library'){
									echo "Library";
								}else if($tt_details[$i]['subject_code']== 'Tutorial'){
									echo "Tutorial";
								}else if($tt_details[$i]['subject_code']== 'Tutor'){
									echo "Tutor";
								}else{
									echo $tt_details[$i]['sub_code'].' - '.$tt_details[$i]['subject_name'];
								}
								?>
								</td> 
                                <td><?=$tt_details[$i]['subject_type']?></td>
                                <td><?=$tt_details[$i]['division']?></td>
                                <td><?=$tt_details[$i]['batch_no']?></td>
                                <!--td><?=$tt_details[$i]['room_no']?></td--> 
								<td><?=strtoupper($tt_details[$i]['fname'][0].'. '.$tt_details[$i]['mname'][0].'. '.$tt_details[$i]['lname']);?></td>
								<td><?=$tt_details[$i]['wday']?></td>
								<td><?=$tt_details[$i]['from_time']?> - <?=$tt_details[$i]['to_time']?> <?=$tt_details[$i]['slot_am_pm']?></td>
                                <td>
                                    <?php //if(in_array("Edit", $my_privileges)) { ?>
                                    <a href="<?=base_url($currentModule."/edit/".$tt_details[$i]['time_table_id'])?>"><i class="fa fa-edit"></i></a> | 
									<a class="close" href="<?=base_url($currentModule."/removeTimetableEntry/".$tt_details[$i]['time_table_id'])?>"><i class="fa fa-trash-o"></i></a> 	    
									
                                    <?php// } ?>
                                    <?php //if(in_array("Delete", $my_privileges)) { ?>
                                    <!--a href='<?=base_url($currentModule).$tt_details[$i]["status"]=="Y"?"disable/".$tt_details[$i]["time_table_id"]:"enable/".$tt_details[$i]["sub_id"]?>'><i class='fa <?=$tt_details[$i]["status"]=="Y"?"fa-ban":"fa-check"?>' title='<?=$tt_details[$i]["status"]=="Y"?"Disable":"Enable"?>'></i></a-->
                                    <?php //} ?>
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }
							}else{
								echo "<tr>";echo "<td colspan=13>";echo "No data found.";echo "</td>";echo "</tr>";
							}
                            ?>                            
                        </tbody>
                    </table>                    
                    <?php //} ?>
                </div>
                </div>
            </div>
	</div>
</div>	
<?php }?>
    </div>
</div>
<!--- Add Faculty POP uP------------>
<div class="modal fade" id="loginbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <h4 class="modal-title" id="myModalLabel">Select Faculty</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked">
                                    <div class="panel-body">
                                        <form class="form-horizoontal" role="form" name="frmlogin" id="frmlogin">
										<div class="row">
											<div class="form-group">
												<label class="col-sm-3">Faculty Type</label>
												<div class="col-sm-6">
													<select name="faculty_type" class="form-control" id="faculty_type">
														<option value="">--Select--</option>
														<option value="per">Permenent</option>
														<option value="guest">Visiting</option>
													</select>  
												</div>
											</div>
										</div>
										<div class="row">
											<div class="form-group">
												<label class="col-sm-3">School</label>
												<div class="col-sm-6">
													<select name="school" class="form-control" id="school">
														<option value="">--Select--</option>
														<?php
														foreach ($school_details as $school) {
															if ($school['course_id'] == $courseId) {
																$sel = "selected";
															} else {
																$sel = '';
															}
															echo '<option value="' . $school['college_id'] . '"' . $sel . '>' . $school['college_name'] . '</option>';
														}
														?>
													</select>
												</div>
											</div>
											
										</div>
										<div class="clearfix">&nbsp;</div>
										<div class="row">
											<div class="form-group">
												<label class="col-sm-3">Department</label>
												<div class="col-sm-6">
													<select name="dept" class="form-control" id="dept">
														<option value="">--Select--</select>
													</select>
												</div>
											</div>
										</div>
										<div class="clearfix">&nbsp;</div>
										<div class="row">
											<div class="form-group">
												<label class="col-sm-3">Faculty</label>
												<div class="col-sm-6">
													<select name="faculty_id" class="form-control" id="faculty_id">
														<option value="">--Select--</select>
													</select>
												</div>
											</div>
										</div>
                                        </form>
                                    </div>
                                    <!-- #end panel body -->
                                </div>
                                <!-- #end panel -->
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="btnlogin" data-dismiss="modal" class="btn btn-primary">OK</button>
                    </div>
                </div>
            </div>
        </div>
 <!-- #end model -->		