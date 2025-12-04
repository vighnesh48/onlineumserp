
<link rel="stylesheet" href="<?= base_url('assets') ?>/stylesheets/select2.css">
<script src="<?= base_url('assets/javascripts') ?>/select2.min.js"></script>
<?php // print_r($fac_list);?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Employee</a></li>
        <li class="active"><a href="#">Faculty List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Faculty List</h1>
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
                            <form id="form" name="form" action="<?=base_url($currentModule.'')?>" method="POST">                                                               
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
							  <div class="col-sm-2">
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
								</div> <div class="col-sm-1" >OR </div>
								<div class="col-sm-3" >
									<input type="text" name="emp_name" id="emp_name" class="form-control" placeholder="Search by Faculty name">    
                              </div>

								<div class="col-sm-2 pull-right"> <button class="btn btn-primary form-control pull-right" id="btn_submit" type="submit" style="margin-top: 15px;">Search</button> </div>
                            </div>
							</form>
                        </div>
                    </div>
                </div>

            </div>    
       
            <div class="col-sm-12">
                <div class="panel">
                  
                    <div class="panel-body">
                        <div class="table-info">    
                            <?php //if(in_array("View", $my_privileges)) { ?>
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th data-orderable="false">#</th>
                                        <th data-orderable="false">FacultyID</th>
                                        <!--th data-orderable="false">Image</th-->
                                        <th data-orderable="false">Name</th>
                                        <th data-orderable="false">Dept</th>
                                        <th data-orderable="false">Email Id</th>
                                        <th data-orderable="false">Phone</th>
                                        <th data-orderable="false">Staff Type</th>
                                        <!--th data-orderable="false">Action</th-->
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <?php
                                    $j = 1;
                                    if(!empty($fac_list)){
                                    for ($i = 0; $i < count($fac_list); $i++) {
										$f_type= substr($fac_list[$i]['emp_id'],0,1);
                                        ?>
                                        <?php
                                        if ($fac_list[$i]['ro_flag'] == 'on')
                                            $bg = "bgcolor='#e6eaf2'";
                                        else
                                            $bg = "";
                                        ?>								
                                        <tr <?= $bg ?> <?= $fac_list[$i]["status"] == "N" ? "style='background-color:#FBEFF2'" : "" ?>>
                                            <td><?= $j ?></td> 

                                            <td><?php if(!empty($fac_list[$i]['emp_id'])){ echo $fac_list[$i]['emp_id'];}else{ echo $fac_list[$i]['faculty_code'];} ?></td> 
                                            <!--td>
                                                <?php
                                                if (!empty($fac_list[$i]['profile_photo'])) {
                                                    $profile = base_url() . "uploads/employee_profilephotos/" . $fac_list[$i]['profile_photo'];
                                                } else {
                                                    $profile = base_url() . "uploads/noprofile.png";
                                                }
                                                ?>
                                                <img src=" <?= $profile; ?> " alt="ProfileImage" height="80px"></td--> 
                                            <td><?= ucfirst($fac_list[$i]['lname']) . " " . ucfirst($fac_list[$i]['fname']); ?></td>                                                                
                                            <td style="width: 250px;">Stream : <strong><?php    
                                                        echo $fac_list[$i]['stream_name'];
                                                        ?></strong><br>
                                                Designation: <strong><?php
                                                        $res = $this->Admin_model->getDesignationById($fac_list[$i]['designation']);
                                                        // print_r($res);
                                                        echo $res[0]['designation_name'];
                                                        ?></strong><br>
														Semester: <strong><?=$fac_list[$i]['semester'];?> </strong>
                                            </td>                                
                                            <td> <?php
                                                /*$date1 = $fac_list[$i]['date_of_birth'];
                                                $date2 = date("Y-m-d");
                                                $diff = abs(strtotime($date2) - strtotime($date1));
                                                $years = floor($diff / (365 * 60 * 60 * 24));
                                                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                                printf("%d years, %d months, %d days\n", $years, $months, $days);*/
                                                echo $fac_list[$i]['email_id'];
                                                ?></td>                                
                                            <td><?= $fac_list[$i]['mobile_no']; ?></td>                                
                                            <td><?php if ($fac_list[$i]['staff_nature'] == 'P') { ?> 
                                                    <span class=""> Permanent </span>
                                                <?php } else if($fac_list[$i]['staff_nature'] == 'V') { ?>
                                                    <span class=""> Visiting </span>
                                                <?php }else{ echo "<span> Other </span>";} ?></td>                                

                                            <!--td>
                                                <p> <?php
												if($fac_list[$i]['staff_nature'] == 'V'){
												?>
                                                    
                                                    <a  href="<?php echo base_url() . "Faculty/add?id=" . $fac_list[$i]['emp_id'] . "&status=" . $fac_list[$i]['staff_nature'] . "&flag=" . '1' . "" ?>" title="Edit"><i class="fa fa-edit"></i> </a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    
												<?php }?>
													</p>
                                            </td-->
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
		// load div from semester
		$("#semester").change(function(){
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
		});
		////////////////////////////////////////////////////////////////
		var academic_year = '<?=$academicyear?>';
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
		//alert(strem_id1);alert(semesterId1);
		if (strem_id1 !='' && semesterId1 !='') {
			//alert('hi');
			$.ajax({
				'url' : base_url + '/Timetable/load_division_by_acdmicyear',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : strem_id1,'semesterId':semesterId1,academic_year:academic_year},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#division'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						var division1 = '<?=$division?>';
						//alert(division1);
						container.html(data);
						$("#division option[value='" + division1 + "']").attr("selected", "selected");
					}
				}
			});
		}
});		
</script>
