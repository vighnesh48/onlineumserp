<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>


<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
<style>
.table{width: 150%;}
table.dataTable{width: 150%!important;}
</style>
<script>

$(document).ready(function() {
	$('#academic_year').on('change', function () {
			//alert("dfdsf");
			var academic_year = $(this).val();
			if (academic_year) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Attendance/load_lecture_cources',
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
					url: '<?= base_url() ?>Attendance/load_streams',
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
					url: '<?= base_url() ?>Attendance/getSemfromAttendance',
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
				'url' : base_url + 'Attendance/load_division_by_acdmicyear',
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
    var printCounter = 0;
 
    // Append a caption to the table before the DataTables initialisation
    //$('#example').append('<caption style="caption-side: bottom">A fictional company\'s staff table.</caption>');
 
    $('#example11').DataTable( {
        dom: 'Bfrtip',
		"bPaginate": false,
        buttons: [
            {
                extend: 'excel',
                messageTop: '<?=$streamName?>',
				filename: 'Consolidated Attendance Report-Div-<?=$division?>'
            }
        ]
    } );
} );
</script>
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

	var academic_year = '<?=$academicyear?>';
	if (academic_year) {
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Attendance/load_lecture_cources',
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
			url: '<?= base_url() ?>Attendance/load_streams',
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
					url: '<?= base_url() ?>Attendance/getSemfromAttendance',
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
				'url' : base_url + 'Attendance/load_division_by_acdmicyear',
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
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Attendance Report</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;  Studentwise Attendance Report</h1>
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
                            <form id="form" name="form" action="<?=base_url($currentModule.'/genericAttendanceReport')?>" method="POST">                                                               
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
									<!--option value="2021-22~WINTER">2021-22 (WINTER)</option-->
                               </select>
                              </div>
                              <div class="col-sm-1" >
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
							  <div class="col-sm-1">
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
								</div> 
								<div class="col-sm-1" >
                                <select name="division" id="division" class="form-control" required>
                                  <option value="">Select Division</option>
                               </select>
                              </div>
							  
							  
							  <div class="col-sm-1" >
    <input type="date" name="from_date" placeholder="From Date:" class="form-control" value="<?= $from_date ?? '' ?>">
	</div>

 <div class="col-sm-1" >
    <input type="date" name="to_date" placeholder="TO Date:"  class="form-control" value="<?= $to_date ?? '' ?>">
</div>


                               <div class="col-sm-1" >
                               <select name="report_type" id="report_type" class="form-control" required>
    <option value=""> Select</option>
    <option value="S" <?= ($report_type == 'S') ? 'selected' : '' ?>>Subjectwise</option>
    <option value="B" <?= ($report_type == 'B') ? 'selected' : '' ?>>Batchwise</option>
    <!--<option value="F" <?= ($report_type == 'F') ? 'selected' : '' ?>>Faculty wise</option>-->
</select>
                              </div>

								<div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
                            </div>
							</form>
                        </div>
                    </div>
                </div>

            </div>    
        </div>
		  <div class="row ">
			<!--form id="form" name="form" action="<?=base_url($currentModule.'/assign_batchToStudent')?>" method="POST"-->    
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname">Details
								<form method="post" action="<?= base_url('attendance/downloadAttendanceReport') ?>" target="_blank">
    <input type="hidden" name="stream_id" value="<?= $streamId ?>">
    <input type="hidden" name="semester" value="<?= $semesterNo ?>">
    <input type="hidden" name="division" value="<?= $division ?>">
    <input type="hidden" name="academic_year" value="<?= $academicyear ?>">
    <input type="hidden" name="from_date" value="<?= $from_date ?>">
    <input type="hidden" name="to_date" value="<?= $to_date ?>">
	<input type="hidden" name="report_type" value="<?= $report_type ?>"> 
    <button type="submit" class="btn btn-danger">
        <i class="fa fa-file-pdf-o"></i> Download PDF
    </button>
</form>

							</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info" style="overflow:scroll;height:900px;">  

							  <?php if (!empty($attendanceReport)) : ?>
    <table class="table table-bordered table-striped">
      <thead>
    <tr>
       
        <?php if ($report_type == 'B'): ?>
            <th rowspan="2">Batch</th> <!-- ✅ New batch column -->
        <?php endif; ?>
        <th rowspan="2">Sr. No.</th>
        <th rowspan="2">Student ID</th>
        <th rowspan="2">Student Name</th>

        <?php foreach ($subjects as $sub): ?>
            <th colspan="3" class="text-center"><?= $sub['subject_name'] ?></th>
        <?php endforeach; ?>

        <th colspan="3" class="text-center bg-info">Overall</th>
    </tr>
    <tr>
        <?php foreach ($subjects as $sub): ?>
            <th>Total</th>
            <th>Attended</th>
            <th>%</th>
        <?php endforeach; ?>
        <th>Total</th>
        <th>Attended</th>
        <th>%</th>
    </tr>
</thead>

        </thead>
    <tbody>
<?php if ($report_type == 'B'): ?>
    <?php 
    // Group students by batch
    $batchGroups = [];
    foreach ($attendanceReport as $row) {
        $batchGroups[$row['batch_name']][] = $row;
    }
    ?>

    <?php foreach ($batchGroups as $batchName => $students): ?>
        <?php $rowspan = count($students); ?>
        <?php $sr = 1; // reset Sr. No. for each batch ?>
        <?php foreach ($students as $index => $row): ?>
            <tr>
                <?php if ($index == 0): ?>
                    <!-- Batch column with rowspan -->
                    <td rowspan="<?= $rowspan ?>"><?= $batchName ?> (<?= $rowspan ?>)</td>
                <?php endif; ?>

                <td><?= $sr++ ?></td>
                <td><?= $row['enrollment_no'] ?></td>
                <td><?= $row['student_name'] ?></td>

                <?php foreach ($subjects as $sub): 
                    $sname   = preg_replace('/[^A-Za-z0-9]/', '_', $sub['subject_name']); 
                    $percent = $row[$sname.'_Percent'] ?? null;
                ?>
                    <td><?= $row[$sname.'_Total'] ?? '-' ?></td>
                    <td><?= $row[$sname.'_Attended'] ?? '-' ?></td>
                    <td class="<?= ($percent !== null && $percent < 75) ? 'low' : 'high' ?>">
                        <?= $percent !== null ? $percent : '-' ?>
                    </td>
                <?php endforeach; ?>

                <?php $overallPercent = $row['Overall_Percent']; ?>
                <td><?= $row['Overall_Total'] ?></td>
                <td><?= $row['Overall_Attended'] ?></td>
                <td class="<?= ($overallPercent < 75) ? 'low' : 'high' ?>">
                    <?= $overallPercent ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php else: ?>
    <?php $i=1; foreach ($attendanceReport as $row): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $row['enrollment_no'] ?></td>
            <td><?= $row['student_name'] ?></td>
            <?php foreach ($subjects as $sub): 
                $sname   = preg_replace('/[^A-Za-z0-9]/', '_', $sub['subject_name']); 
                $percent = $row[$sname.'_Percent'] ?? null;
            ?>
                <td><?= $row[$sname.'_Total'] ?? '-' ?></td>
                <td><?= $row[$sname.'_Attended'] ?? '-' ?></td>
                <td class="<?= ($percent !== null && $percent < 75) ? 'low' : 'high' ?>">
                    <?= $percent !== null ? $percent : '-' ?>
                </td>
            <?php endforeach; ?>
            <?php $overallPercent = $row['Overall_Percent']; ?>
            <td><?= $row['Overall_Total'] ?></td>
            <td><?= $row['Overall_Attended'] ?></td>
            <td class="<?= ($overallPercent < 75) ? 'low' : 'high' ?>">
                <?= $overallPercent ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>

  </table>
<?php else: ?>
    <div class="alert alert-warning">No attendance records found.</div>
<?php endif; ?>

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
    $('#example').DataTable( {
        dom: 'Bfrtip',
		"pageLength": 50,
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Time Table Entry Status'
            }
        ]
    } );
} );
</script>
