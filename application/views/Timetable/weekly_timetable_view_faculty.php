<style>
    table { border-collapse: collapse; width: 100%; margin-bottom: 30px; font-family: Arial, sans-serif; }
    th, td { border: 1px solid #444; padding: 6px; text-align: center; vertical-align: top; font-size: 12px; }
    th { background: #f2f2f2; }
    td { min-width: 160px; }
    .lecture-block { padding: 4px; border-radius: 4px; color: #000; font-size: 12px; }
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Time Table Master</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Lecture  Time Table <span class="panel-title"></span></h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php// if(in_array("Add", $my_privileges)) { ?>
                                           
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php //} ?>

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
							
						</div>	
						<div class="col-sm-9" style="color:green;float:left;font-weight: 900;">
							<?php
							$role_id = $this->session->userdata('role_id');
							if ($this->session->flashdata('Tmessage') != ''): 
								echo $this->session->flashdata('Tmessage'); 
							endif;
							?>
						</div>
					</div>
					<div class="row">
					<?php
                                            if ($role_id != '' && in_array($role_id, [6, 53, 58,10,20,44])) {
                                                ?>
					<form name="searchTT" id="forms" method="POST" action="<?=base_url()?>timetable/viewTtable">
					<?php
                                            if ($role_id != '' && in_array($role_id, [6, 53, 58])) {
                                                ?>
						<div class="col-sm-1">
                                <select name="campus" id="campus" class="form-control" required>
                                 <option value="">Select Campus</option>
                                  <option value="1" <?php if($_REQUEST['campus']=="1"){ echo "selected";}?>>SUN</option>
                                  <option value="3" <?php if($_REQUEST['campus']=="3"){ echo "selected";}?>>SF</option>
                                  <option value="2" <?php if($_REQUEST['campus']=="2"){ echo "selected";}?>>SUM</option>
                                  </select>
                              </div>
											<?php }?>
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
									<?php
									//if($this->session->userdata('name')=='110074'){
										//echo '<option value="2022-23~WINTER">2022-23 (WINTER)</option>';
									//}?>
                               </select>

                              </div>
                            
								
                                                <div class="col-sm-2">
                                                    <select name="faculty_id" id="faculty_id" class="form-control " required>
                                                        <option value="">Select Faculty</option>
                                                    </select>
                                                </div>
                                            
								<div class="col-sm-2"><input type="submit" class="btn btn-primary" value="Search"></div>
								
                            </div>
                              </form> 
							  <?php } ?>
							  <form method="post">
    <input type="hidden" name="faculty_id" value="<?= $faculty_id ?>">
    <input type="hidden" name="stream_id" value="<?= $streamId ?>">
    <input type="hidden" name="semester" value="<?= $semesterNo ?>">
    <input type="hidden" name="division" value="<?= $division ?>">
    <input type="hidden" name="academic_year" value="<?= $academicyear ?>">
    <button type="submit" name="download_pdf" value="1" class="btn btn-danger">
        Download PDF
    </button>
</form>
					</div>
                </div>
                <div class="panel-body" style="">
				
                    <div class="table-info table-responsive" >   
<table>
    <thead>
        <tr>
            <th>Time / Day</th>
            <?php 
            $days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            foreach($days as $d): ?>
                <th><?= $d ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($hours as $i => $slot): ?>
            <tr>
                <td><b><?= date("h:i A", strtotime($slot['start'])) ?> - <?= date("h:i A", strtotime($slot['end'])) ?></b></td>
                <?php foreach($days as $day): ?>
                    <td>
                        <?php 
                        if(isset($timetable[$day][$i]) && !empty($timetable[$day][$i])):
                            $lectures = $timetable[$day][$i];
                            $count = count($lectures);
                            foreach($lectures as $idx => $lec):

                                // Set color based on lecture type
                                if($lec['subject_type'] == 'TH'){
                                    $color = '#BBDEFB'; // Blue for Theory
                                } else {
                                    $color = '#C8E6C9'; // Green for Practical/Project/etc
                                }
                        ?>
                        <div class="lecture-block" style="background-color:<?= $color ?>; margin-bottom:<?= $count>1?'2px':'0'?>;">
                            <b><?= $lec['subcode'] ?></b>-<b><?= $lec['subject_code'] ?></b> (<?= $lec['subject_type'] ?>)<br>
                            Faculty: <?= $lec['faculty_code'].'-'.$lec['faculty_name'] ?><br>
							Program/sem: <?= $lec['stream_name'].'-'.$lec['semester'] ?><br>
                            Division: <?= $lec['division'].'-'.$lec['batch_no'] ?><br>
                            Time: <?= date("h:i A", strtotime($lec['from_time'])).'-'.date("h:i A", strtotime($lec['to_time'])) ?><br>
                            Room: <?= $lec['buliding_name'] ?> <?= $lec['floor_no'].'-'.$lec['room_no'] ?>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
	</div>
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
        // Initialize Select2
        $('#faculty_id').select2({
            placeholder: "Select Faculty",
            allowClear: true
        });

        // Trigger AJAX when school or stream changes
        $('#academic_year').on('change', function () {

            var academic_year = $('#academic_year').val();
            var campus = $('#campus').val();

            var faculty_code = '<?= $faculty_id ?>';

            if (academic_year) {
                $.ajax({
                    url: "<?= base_url('timetable/fetchFaculty') ?>", // Call Controller Function
                    type: "POST",
                    data: {
                        academic_year: academic_year,campus:campus,
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#faculty_id').empty().append('<option value="">Select Faculty</option>');
                        $.each(response, function (index, faculty) {
                            $('#faculty_id').append('<option value="' + faculty.faculty_code + '">' + faculty.faculty_code +'-'+faculty.faculty_name + '</option>');

                        });
                        // $('#faculty_id').trigger('change'); // Refresh Select2
                        $('#faculty_id').val(faculty_code).trigger('change');
                    }
                });
            } else {
                $('#faculty_id').empty().append('<option value="">Select Faculty</option>');
            }
        });

        $('#academic_year').trigger('change');
		
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
		//

			var stream_id ='<?=$streamId?>';
			var course_id ='<?=$courseId?>';
			var academic_year ='<?=$academicyear?>';
			if (academic_year) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttcources',
					data: {academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#course_id').html(html);
						$("#course_id option[value='" + course_id + "']").attr("selected", "selected");
					}
				});
			}
			if (course_id) {
					$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Timetable/load_tt_streams',
						data: {course_id:course_id,academic_year:academic_year},
						'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
						var container = $('#stream_id'); //jquery selector (get element by id)
						if(data){
							var stream_id = '<?=$streamId?>';
							container.html(data);
							$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
						}
					}
				});
			}
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttsemesters',
					data: {stream_id:stream_id,academic_year:academic_year},
					success: function (html) {
						var semester = '<?=$semesterNo?>';
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

			var semester = '<?=$semesterNo?>';
			if (semester) {
				var academic_year ='<?=$academicyear?>';
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttdivision',
					data: {stream_id:stream_id,academic_year:academic_year,stream_id:stream_id, semester:semester},
					success: function (html) {
						var division ='<?=$division?>';
						$('#division').html(html);
						$("#division option[value='" + division + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#division').html('<option value="">Select Stream first</option>');
			}

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
		
    });

</script>