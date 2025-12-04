<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style>
	.table{width: 120%;}
	table{max-width: 120%;}
	.valin{vertical-align: top !IMPORTANT; }
</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Course Master </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Subjectwise Student Info. </h1>
            <div class="col-xs-12 col-sm-8">

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
							
						</div>	
						<div class="col-sm-9" style="color:green;float:left;font-weight: 900;">
							<?php
							if ($this->session->flashdata('Tmessage') != ''): 
								echo $this->session->flashdata('Tmessage'); 
							endif;
							?>
						</div>
					</div>
					<div class="row">
					<form name="searchTT" id="forms" method="POST" action="<?=base_url()?>subject/subject_wise_academic_studentinfo">
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
                                <select name="batch" id="batch" class="form-control" required>
                                  <option value="">Select Batch</option>
                                  <?php
                                    foreach ($batches as $bth) {
                                        if ($bth['batch'] == $batch) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $bth['batch'] . '"' . $sel . '>' . $bth['batch'] . '</option>';
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
                              <div class="col-sm-2" id="semest" >
                                <select name="stream_id" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                               </select>
                              </div>
								<div class="col-sm-2">
									<select id="semester" name="semester" class="form-control" required>
											<option value="">Semester</option>
									</select>
								</div> 
								<div class="col-sm-2">
									<select id="subject" name="subject" class="form-control" required>
											<option value="">Subject</option>
									</select>
								</div><br><br>
								<div class="col-sm-2">
									<select id="division" name="division" class="form-control" required>
											<option value="">Division</option>
									</select>
								</div>
								<div class="col-sm-2"><input type="submit" class="btn btn-primary" value="Search"></div>
								
                            </div>
                              </form> 
					</div>
                </div>
                <div class="panel-body">
				
                    <div class="table-info" >    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" style="width:100%!important">
                        <thead>
                            <tr>
                                    <th width="5%" class="valin">#</th>
									<th width="5%" class="valin">PRN</th>
                                    <th class="valin">Student Name</th> 
									<th class="valin">Mobile</th>
									<!--th>Stream</th>
									<th>Semester</th>
									<th>Division</th-->
									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							$j=1;
                            //echo "<pre>";print_r($student_details);
							if(!empty($student_details)){
							foreach($student_details as $sd)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>
								<td><?=$sd['enrollment_no']?></td>   
                                <td><?=ucfirst($sd['first_name'].' '.$sd['middle_name'].' '.$sd['last_name']);?></td>
								<td><?=$sd['mobile']?></td>
								<!--td><?=$sd['stream_name']?></td> 
                                <td><?=$sd['semester']?></td>
                                <td><?=$sd['division']?></td-->	
								
                            </tr>
                            <?php
                            $j++;
                            }
							}else{
								echo "<tr>";echo "<td colspan=4>";echo "No data found.";echo "</td>";echo "</tr>";
							}
                            ?>                            
                        </tbody>
                    </table>
					<div class="row">
						<div class="col-sm-8">
						<span style="float:left;"><strong>Note:</strong> Students are mapped as per Subject Allocation.</span>
						</div>
						<!--div class="col-sm-4 pull-right" >
						  <span style="float:right;">Total Admission Strength: <strong><?php if(!empty($stud_strength)){ echo $stud_strength[0]['stud_streangth'];}?>.</strong></span>
						</div-->
					</div><br>
					<?php if(!empty($subject)){ ?>
					<a href="<?=base_url()?>subject/subject_wise_academic_studentinfo_pdf/<?=$subject?>/<?=$academicyear?>/<?=$streamId?>/<?=$semester?>/<?=$batch?>/<?=$division?>"><button class="btn btn-primary" >PDF</button><?php }?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>    
    $(document).ready(function()
    {
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
<script>
	$('#stream_id').change(function () {
        var stream_id = $("#stream_id").val();
		var batch = $("#batch").val();

		if (stream_id) {
			$.ajax({
				'url' : base_url + 'Subject/load_semester',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'batch' : batch,stream_id:stream_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semester'); //jquery selector (get element by id)
					if(data){	
						container.html(data);
					}
				}
			});
		}
    });	
		//

			var stream_id ='<?=$streamId?>';
			var batch = '<?=$batch?>';
			if (stream_id) {
				$.ajax({
					type: 'POST',
					'url' : base_url + 'Subject/load_semester',
					data: {'batch' : batch,stream_id:stream_id},
					success: function (html) {
						var semester = '<?=$semester?>';
						$('#semester').html(html);
						$("#semester option[value='" + semester + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}


		$('#semester').on('change', function () {
			var semester = $(this).val();
			var stream_id =$("#stream_id").val();
			var academic_year =$("#academic_year").val();
			var course_id = $("#course_id").val();
			var batch = $("#batch").val();
			if (semester) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>subject/load_stud_subjects',
					data: {course_id:course_id,academic_year:academic_year,stream_id:stream_id, semester:semester,batch:batch},
					success: function (html) {
						
						$('#subject').html(html);
						
					}
				});
			} else {
				$('#division').html('<option value="">Select Stream first</option>');
			}
		});
		//edit
			var semester = '<?=$semester?>';
			var stream_id ='<?=$streamId?>';
			var batch = '<?=$batch?>';
			var academic_year ='<?=$academicyear?>';
			var course_id = '<?=$courseId?>';

			if (semester) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>subject/load_stud_subjects',
					data: {course_id:course_id,academic_year:academic_year,stream_id:stream_id, semester:semester,batch:batch},
					success: function (html) {
						var sub_id = '<?=$subject?>';
						$('#subject').html(html);
						$("#subject option[value='" + sub_id + "']").attr("selected", "selected");
					}
				});
			}
		$('#subject').on('change', function () {
			var subject_id = $(this).val();
			var stream_id =$("#stream_id").val();
			var academic_year =$("#academic_year").val();
			var semester = $("#semester").val();
			if (subject_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>subject/load_stud_subjects_div',
					data: {academic_year:academic_year,stream_id:stream_id, semester:semester,subject_id:subject_id},
					success: function (html) {
						
						$('#division').html(html);
						
					}
				});
			} else {
				$('#division').html('<option value="">Select Subject first</option>');
			}
		});
		//
		var subject_id = '<?=$subject?>';
			
			if (subject_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>subject/load_stud_subjects_div',
					data: {academic_year:academic_year,stream_id:stream_id, semester:semester,subject_id:subject_id},
					success: function (html) {
						var div = '<?=$division?>';
						$('#division').html(html);
						$("#division option[value='" + div + "']").attr("selected", "selected");
					}
				});
			}
</script>