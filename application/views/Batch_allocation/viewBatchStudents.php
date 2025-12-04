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

<script>

$(document).ready(function() {
	
	$('#academic_year').on('change', function () {
			var academic_year = $(this).val();
			if (academic_year) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>batchallocation/load_batchcources',
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
					url: '<?= base_url() ?>batchallocation/load_batch_streams',
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
					url: '<?= base_url() ?>batchallocation/load_batchsemesters',
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
					url: '<?= base_url() ?>batchallocation/load_batch_division',
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
 
    // Append a caption to the table before the DataTables initialisation
    //$('#example').append('<caption style="caption-side: bottom">A fictional company\'s staff table.</caption>');
 
    $('#example').DataTable( {
        dom: 'Bfrtip',
		"bPaginate": false,
        buttons: [
            {
                extend: 'excel',
                messageTop: '<?=$streamName?>.',
				filename: 'Class Student List-Div-<?=$division?>'
            },
            {
                extend: 'pdf',
                messageTop: '<?=$streamName?>.',
				filename: 'Class Student List-Div-<?=$division?>'
            },
            {
                extend: 'print',
                messageTop: function () {
                    printCounter++;
 
                    if ( printCounter === 1 ) {
                        return 'This is the first time you have printed this document.';
                    }
                    else {
                        return 'You have printed this document '+printCounter+' times';
                    }
                },
                messageBottom: null
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
			url: '<?= base_url() ?>batchallocation/load_batchcources',
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
	//alert(course_id);
	if (course_id) {
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>batchallocation/load_batch_streams',
			data: {course_id:course_id,academic_year:academic_year},
			success: function (html) {
				//alert(html);
				var stream_id = '<?=$streamId?>';
				//alert(stream_id);
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
					url: '<?= base_url() ?>batchallocation/load_batchsemesters',
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
				'url' : base_url + '/batchallocation/load_batch_division',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'stream_id' : strem_id1,'semester':semesterId1,academic_year:academic_year},
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
        <li class="active"><a href="#">Class Students</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Class Students List</h1>
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
                            <form id="form" name="form" action="<?=base_url($currentModule.'/searchBatchStudents')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />
								<div class="form-group">
								<div class="col-sm-2" >
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
									foreach ($academic_year as $yr) {
										if ($yr['academic_year'] == $_REQUEST['academic_year']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $yr['academic_year'] . '"' . $sel . '>' . $yr['academic_year'] . '</option>';
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
									<select id="semester" name="semester" class="form-control" >
                                            <option value="">Select Semester</option>
											</select>
								</div> 
								<div class="col-sm-2" >
                                <select name="division" id="division" class="form-control" required>
                                  <option value="">Select Division</option>
                               </select>
                              </div>

								<div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
                            </div>
							</form>
                    </div>
  
                </div>

            </div>    
        </div>
		  <div class="row ">
			<!--form id="form" name="form" action="<?=base_url($currentModule.'/assign_batchToStudent')?>" method="POST"-->    
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname">Student List:
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
                        <div class="table-info table-responsive">  

							<table id="example" class="table table-bordered display">
							<thead>
								<tr>
									<th data-orderable="false">S.No.</th>
									<th data-orderable="false">ROll No.</th>
									<th data-orderable="false">PRN.</th>
									<th data-orderable="false">Student Name</th>
									<th data-orderable="false">Mobile No.</th>
									<th data-orderable="false">Email.</th>
									<th data-orderable="false">Semester</th>
									<th data-orderable="false">Division</th>
									<th data-orderable="false">Batch</th>
								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									if(!empty($batchstudents)){
										foreach($batchstudents as $stud){
										
										$division = $stud['division'];
										$batch_name = $stud['batch'];
										if($batch_name ==0){
											$batch = '';
										}else{
											$batch = $batch_name;
										}
										
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['roll_no']?></td>
										<td><?php if($stud['transefercase'] == 'Y'){ echo $stud['enrollment_no'].' <img src="https://erp.sandipuniversity.com/uploads/Transfer-PNG.png" style="width:15px; height:15px"> ';}else{echo  $stud['enrollment_no'];}?></td>
										<td><?php echo $stud['first_name']." ".$stud['middle_name']." ".$stud['last_name'];?></td>
										<td><?=$stud['mobile']?></td>
										<td><?=$stud['email']?></td>
										<td><?=$stud['semester']?></td>
										<td><?=$division?></td>
										<td><?=$batch?></td>
									</tr>
								<?php
										$i++;
										}
									}else{
										echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
									}
								?>
								</tbody>
							</table>
							
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

</script>
