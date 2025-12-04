
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<?php // print_r($fac_list);?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Question Paper</a></li>
        <!-- <li class="active"><a href="#">Subject List</a></li> -->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;QP Master</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">

                    <!--div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?= base_url($currentModule . "/add") ?>"><span class="btn-label icon fa fa-plus"></span>Add New Faculty</a></div-->                        
                    <div class="visible-xs clearfix form-group-margin"></div>

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
                            <form id="form" name="form" action="<?=base_url($currentModule.'')?>/add_new_qp" method="POST">                                                               
                                <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />
								<div class="form-group">
									<div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required>
                                 <option value="">Exam Session</option>
                               
                                  <?php

foreach ($exam_session as $exsession) {
	$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
	$exam_sess_val = $exsession['exam_month'] .'-'.$exsession['exam_year'].'-'.$exsession['exam_id'];
    if ($exam_sess_val == $_POST['exam_session']) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $exam_sess_val. '"' . $sel . '>' .$exam_sess.'</option>';
}
?></select>
                              </div>
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
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session'].'"' . $sel . '>' . $yr['academic_year'].' ('.$yr['academic_session'] . ')</option>';
									}
									?>
                               </select>
                              </div>
                              <div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" >
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
                              <div class="col-sm-2" id="semest" >
                                <select name="stream_id" id="stream_id" class="form-control" >
                                  <option value="">Select Stream</option>
                               </select>
                              </div>
							  
							   <!--div class="col-sm-2">
									<select id="semester" name="semester" class="form-control" >
                                            <option value="">Select Semester</option>
											<?php for($i=1;$i<9;$i++) {
												if ($i == $semesterNo) {
												$sel3 = "selected";
												} else {
													$sel3 = '';
												}
											?>
                                            <option value="<?=$i?>" <?=$sel3?>><?=$i?></option>
                                            <?php } ?>
											</select>
								</div--> 
								<!-- <div class="col-sm-2">
									<select id="facultyy" name="facultyy" class="form-control" >
                                            
											</select>
								</div> -->

								<div class="col-sm-2" id="semest" >
                               <select name="exam_type" id="exam_type" class="form-control" required>
                                  <option value="">Select Type</option>
                                   <option value="Reg" <?php if($_REQUEST['exam_type'] =='Reg'){ echo "selected";}else{}?>>Regular </option>
                                   <option value="bklg" <?php if($_REQUEST['exam_type'] =='bklg'){ echo "selected";}else{}?>>Backlog </option>
                                  </select>
                              </div> 
								
								
								<div class="col-sm-2 pull-right"> <button class="btn btn-primary form-control pull-right" id="btn_submit" type="submit" style="margin-top: 15px;">Search</button> </div>
                            
							</form>
                        </div>
                    </div>
                </div>

            </div>    
       
            <div class="col-sm-12">
                <div class="panel">
                  
                    <div class="panel-body">
                        <div class="table-info">    
                            <form name="mrkcrdfrom" id="mrkcrdfrom" method="post" action="<?=base_url()?>Question_paper/sendtofaculty">
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                    	<th class="noExl"><input type="checkbox" name="chk_sub_all" id="chk_sub_all"></th>
                                        <th data-orderable="false">S.No.</th>
                                        <th data-orderable="false">Subject Code</th>
                                        <th data-orderable="false">Batch</th>
                                        <!--th data-orderable="false">Image</th-->
                                        <th data-orderable="false">Subject Name</th>
                                        <th data-orderable="false">Subject Type</th>
                                        <th data-orderable="false">Semester</th>
                                        <th data-orderable="false">No. Of Sets</th>
                                        <!-- <th data-orderable="false">Assign Faculty</th> -->
                                        <!-- th data-orderable="false">Email Id</th>
                                        <th data-orderable="false">Phone</th>
                                        <th data-orderable="false">Staff Type</th> -->
                                        <!--th data-orderable="false">Action</th-->
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">

                                	<input type="hidden" name="semester" id="semester" value="<?=$semesterNo?>">
                                	<input type="hidden" name="academicyear" id="academicyear" value="<?=$academicyear?>">
                                	<input type="hidden" name="exam_session" id="exam_session" value="<?=$exam_sess_val?>">
                                	<input type="hidden" name="streamId" id="streamId" value="<?=$streamId?>">
                                	<input type="hidden" name="courseId" id="courseId" value="<?=$courseId?>">
                                	<input type="hidden" name="examtype" id="examtype" value="<?=$exam_type?>">
                        	       
                                    <?php
                                    $j = 1;
                                    if(!empty($sub_list)){
                                    for ($i = 0; $i < count($sub_list); $i++) {
										
                                        ?>
                                        							
                                        <tr>
                                        	<td class="noExl"><input type="checkbox" onclick="disablecheckbok(this.id)"  name="chk_sub[]" id="<?=$i?>" class='subCheckBox' value="<?=$sub_list[$i]['sub_id']?>"></td>
                                            <td><?= $j ?></td> 

                                            <td><?php  echo $sub_list[$i]['sub_code'];?></td> 
                                            <td><?php  echo $sub_list[$i]['batch'];?></td> 
                                            <td><?php  echo $sub_list[$i]['subject_name'];?></td> 
                                            <td><?php  echo $sub_list[$i]['subtype'];?></td> 
                                            <td><?php  echo $sub_list[$i]['semester'];?></td> 
                                            <td><input type="text" name="no_of_set[]" id="no_of_set<?php echo $i?>" disabled></td> 
                                            
                                            	
                                            	<!-- <select class="form-control" name="faculty_id[]" id="faculty_id" required>
                                            		<option >Select Faculty</option>
                                            		   <?php

                                            		   //echo '<pre>';
                                            		   //print_r($faculty_list);exit;
									foreach ($faculty_list as $faculty) {
										/*if ($course['course_id'] == $courseId) {
											$sel = "selected";
										} else {
											$sel = '';
										}*/
										echo '<option value="' . $faculty['faculty_code'] . '">' . $faculty['fname'] . ' '. $faculty['mname'] . ' '. $faculty['lname'] . '</option>';
									}
									?>
                                            		

                                            	</select> -->
                                             
                                            
                                           
													
                                          
                                        </tr>
                                        <?php
                                        $j++;
                                    }
                                    }else{
                                        echo "<tr><td colspan=9>";echo "No data found.";echo "</td></tr>";
                                    }
                                    ?>                            
                                </tbody>
                            </table>

                       <div class="row">
						<!-- <div class="col-lg-2"><input type="text" style="width:200px" min="1" max="3" name="no_of_set" id="no_of_set" required class="form-control" value="" placeholder="No. of Sets" ></div> -->
                        <div class="col-lg-2">
						<select class="form-control" name="faculty_id" id="faculty_id" required>
                                            		<option >Select Faculty</option>
                                            		   <?php

                                            		   //echo '<pre>';
                                            		   //print_r($faculty_list);exit;
									foreach ($faculty_list as $faculty) {
										/*if ($course['course_id'] == $courseId) {
											$sel = "selected";
										} else {
											$sel = '';
										}*/
										echo '<option value="' . $faculty['faculty_code'] . '">' . $faculty['fname'] . ' '. $faculty['mname'] . ' '. $faculty['lname'] . '</option>';
									}
									?>
                                            		

                                            	</select>
                                            </div>
						<div class="col-lg-2"><input type="text" style="width:200px" name="duration" id="duration"  required class="form-control" value="" placeholder="Duration" ></div>
						<!--div class="col-lg-2"><input type="radio" name="report_type" value="excel" required> &nbsp;&nbsp;EXCEL</div-->
						<div class="col-lg-2"><input type="date" style="width:200px" name="date_of_submit" id="date_of_submit" required class="form-control" value="" placeholder="Last Date of Submission" ></div>         
						<div class="col-lg-2"><input type="submit" name="send" value="Send" id="send" class="btn btn-primary" onclick="return validate_subject(this.value)"></div>
					</div>  

					</form>                  
                            <?php //}   ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
	$('#chk_sub_all').change(function () {
        $('.subCheckBox').prop('checked', $(this).prop('checked'));
    });
	
	///////////////////////////////
	// fetch stream form course
	var stream_id = $("#semester").val();
	var faculty = $("#facultyy").val();
	if(stream_id !=''){
		$("#sem_id").val(stream_id);
	}
		// fetch subject of sem_acquire
		$("#stream_id").change(function(){
			//alert("hi");
		  $('#semester option').attr('selected', false);
		});
		
		$("#division").change(function(){
			var streamId = $("#stream_id").val();
			var course_id = $("#course_id").val();
			var semesterId = $("#semester").val();
			
			var divs = $("#division").val();
			$.ajax({
				'url' : base_url + 'Batch_allocation/load_subject',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course' : course_id,'streamId':streamId,'semesterId':semesterId,'division':divs},
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
		
  });
$(document).ready(function() {
	$('#academic_year').on('change', function () {
			//alert("dfdsf");
			var academic_year = $(this).val();
			if (academic_year) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Timetable/load_ttcources',
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
			var course_id = $(this).val();
			var academic_year =$("#academic_year").val();
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
		// load div from semester
		$('#stream_id').on('change', function () {
			var stream_id = $(this).val();
			var academic_year =$("#academic_year").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Timetable/load_ttsemesters',
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

		$('#stream_id').on('change', function () {
			var room_no = $(this).val();;
			var academic_year =$("#academic_year").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Faculty/load_ttfaculty',
					data: {'room_no' : room_no,'academic_year':academic_year},
					success: function (html) {
						//alert(html);
						//$('#semester').html(html);
						$('#facultyy').html(html);
					}
				});
			} else {
				$('#facultyy').html('<option value="">Select Stream first</option>');
			}
		});
		// load div from semester
		$("#semester").change(function(){
			var room_no = $("#stream_id").val();
			var semesterId = $("#semester").val();
			var academic_year =$("#academic_year").val();
			$.ajax({
				//'url' : base_url + 'Timetable/load_division_by_acdmicyear',
				'url' : base_url + 'Faculty/load_ttfaculty',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : room_no,'semesterId':semesterId,academic_year:academic_year},
				'success' : function(html){ //probably this request will return anything, it'll be put in var "data"
					$('#facultyy').html(html);
				}
			});
		});

		/*$("#semester").change(function(){
			var room_no = $("#stream_id").val();
			var semesterId = $("#semester").val();
			var academic_year =$("#academic_year").val();
			$.ajax({
				'url' : base_url + 'Timetable/load_division_by_acdmicyear',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : room_no,'semesterId':semesterId,academic_year:academic_year},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#division'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						container.html(data);
						//$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		});*/
		////////////////////////////////////////////////////////////////
		var academic_year = '<?=$academicyear?>';
		//var exam_session = '<?=$exam_session?>';
		
	if (academic_year) {
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Timetable/load_ttcources',
			data: {academic_year:academic_year},
			success: function (html) {
				//alert(html);
				var course_id = '<?=$courseId?>';
				$('#course_id').html(html);
				$("#course_id option[value='" + course_id + "']").attr("selected", "selected");
			}
		});
	} else {
		$('#course_id').html('<option value="">Select academic year first</option>');
	}
	var course_id = '<?=$courseId?>';
	if (course_id) {
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Timetable/load_tt_streams',
			data: {course_id:course_id,academic_year:academic_year},
			success: function (html) {
				//alert(html);
				var stream_id = '<?=$streamId?>';
				$('#stream_id').html(html);
				$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
			}
		});
	} else {
		$('#stream_id').html('<option value="">Select course first</option>');
	}
		//edit division
		var stream_id2 = '<?=$streamId?>';
			if (stream_id2) {
				//alert('hii');
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Timetable/load_ttsemesters',
					data: {stream_id:stream_id2,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						var sem = '<?=$semesterNo?>';
						$('#semester').html(html);
						$("#semester option[value='" + sem + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		//edit semester
		var strem_id1 = '<?=$streamId?>';
		var semesterId1 = '<?=$semesterNo?>';
		// //alert(strem_id1);alert(semesterId1);
		// if (strem_id1 !='' && semesterId1 !='') {
		// 	//alert('hi');
		// 	$.ajax({
		// 		'url' : base_url + '/Timetable/load_division_by_acdmicyear',
		// 		'type' : 'POST', //the way you want to send data to your URL
		// 		'data' : {'room_no' : strem_id1,'semesterId':semesterId1,academic_year:academic_year},
		// 		'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
		// 			var container = $('#division'); //jquery selector (get element by id)
		// 			if(data){
		// 				//alert(data);
		// 				var division1 = '<?=$division?>';
		// 				//alert(division1);
		// 				container.html(data);
		// 				$("#division option[value='" + division1 + "']").attr("selected", "selected");
		// 			}
		// 		}
		// 	});
		// }

		var faculty1 = '<?=$facultyy?>';
		
		if (faculty1) {
			//alert(11);
				$.ajax({
					type: 'POST',
					//url: '<?= base_url() ?>Timetable/load_ttsemesters',
					'url' : base_url + 'Faculty/load_ttfaculty',
					'data' : {'room_no' : strem_id1,'semesterId':semesterId1,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						var faculty_code = '<?=$facultyy?>';
						$('#facultyy').html(html);
						$("#facultyy option[value='" + faculty_code + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#faculty').html('<option value="">Select semester first</option>');
			}
});	

function validate_subject(strm){

	var chk_stud_checked_length = $('input[class=subCheckBox]:checked').length;
	if(chk_stud_checked_length == 0){
		 alert('please check atleast one Subject from subject list');
		 return false;
	}else{
		return true;
	}
}

   function disablecheckbok(chkid) {
	   //alert(chkid);
	   //no_of_set
			var cls='no_of_set'+chkid;
			//alert(cls);
            if ($("#"+chkid).is(":checked")) {
				//alert('inside'); 
                $("#"+cls).removeAttr("disabled");
                
            }else {
				//alert('Helol');
				$("#"+cls).attr("disabled","disabled");
			}
			
    }
 	
</script>
