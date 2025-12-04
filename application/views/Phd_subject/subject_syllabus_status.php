<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

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
	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		var academic_year = $("#academic_year").val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>academic_reports/load_courses_for_studentlist',
				data: {academic_year:academic_year,school_code:school_code},
				success: function (html) {
					//alert(html);
					$('#course_id').html(html);
				}
			});
		} else {
			$('#course_id').html('<option value="">Select course first</option>');
		}
	});
	
		var school_code = '<?=$school_code?>';
		var academic_year = $("#academic_year").val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>academic_reports/load_courses_for_studentlist',
				data: {academic_year:academic_year,school_code:school_code},
				success: function (html) {
					//alert(html);
					
					var course_id = '<?=$courseId ?>';
					$('#course_id').html(html);
					$("#course_id option[value='" + course_id + "']").attr("selected", "selected");
				}
			});
		} else {
			$('#course_id').html('<option value="">Select course first</option>');
		}		
    });
/*$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
		"pageLength": 50,
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Subject Syllabus Status'
            }
        ]
    } );
} );*/
</script>
<style>
.form-control{border-collapse:collapse !important;}
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Subject Syllabus Status</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Subject Syllabus Status</h1>
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
                            <span class="panel-title">Filter below</span>
                    </div>

                    <div class="panel-body">
                        <div class="table-info">                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/search_subsylabus')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />
							<div class="form-group">
								<div class="col-sm-2" >
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
									foreach ($academic_year as $yr) {
									//	$acd_yr= explode('-',$yr['academic_year']);
										if ($yr['academic_year'] == $SAacademic_year) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' .$yr['academic_year']. '"' . $sel . '>' . $yr['academic_year'] . '</option>';
									}
									?>
                               </select>
                               
                              </div>
							  <div class="col-sm-2">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select School</option>
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
                              <div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" required>
                                  <option value="">Select Course</option>

                               </select>
                              </div>
                          
                              <div class="col-sm-2">
                                <select name="stream_id" id="stream_id" class="form-control" required="required">
                                  <option value="">Select Stream</option>      
                               </select>
                              </div>
							  <div class="col-sm-1">
									<select id="semester" name="semester" class="form-control">
                                            <option value="">Select Semester</option>	
											</select>
									</div>  
									<div class="col-sm-2">
									<select id="rp_status" name="rp_status" class="form-control" required>
                                            <option value="0">Select All</option>
											<option value="1" <?php if($_REQUEST['rp_status']==1){ echo "selected";}?>>Done</option>	
											<option value="2" <?php if($_REQUEST['rp_status']==2){ echo "selected";}?>>Not Done</option>												
											</select>
									</div>
								<div class="col-sm-1 pull-right"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
                            </div>
							</form>
                        </div>
                    </div>
                </div>

            </div>    
        </div>
						<div style="color:green;font-weight: 900;">
						<?php
						if ($this->session->flashdata('Smessage') != ''): 
							echo $this->session->flashdata('Smessage'); 
						endif;
						?>
					</div>
		  <div class="row ">  
			<div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Subject List- Batch: <b><?=$batch?></b>, Total subjects: <b><?=count($totsubjects)?></b>, <?php if($rp_status=='1'){ ?> Syllabus Done: <b><?=count($sublist)?></b>, Syllabus Not Done: <b><?=count($totsubjects) - count($sublist)?></b> 
							<?php }else{?>
							 Syllabus Done: <b><?=count($totsubjects) - count($sublist)?></b>, Syllabus Not Done: <b><?=count($sublist)?></b>
							<?php }?>
							</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">  
							<table class="table table-bordered" id="example">
							<thead>
								<tr>
									<th>Sr.No</th>
									<th>Stream Name</th>
									<th>Semester</th>
									<th>Subject Name</th>
									<th>Syllabus Status</th>
								</tr>
							</thead>
							<tbody>
							<input type="hidden" name="sem_id" id="sem_id" value="<?=$semesterNo?>" >
							<input type="hidden" name="sub_stream" id="sub_stream" value="<?=$streamId?>" >
							<input type="hidden" name="acad_year" id="acad_year" value="<?=$SAacademic_year?>" >
								<?php
								
									if(!empty($sublist)){
										$i=1;
										foreach($sublist as $sub){
											if($sub['subject_type']=='CUM'){
												$sub_checked ="";//$sub_checked ="checked='checked'";
												$readonly="";//$readonly="onclick='this.checked=!this.checked;'";
											}else{
												$sub_checked ="";
												$readonly="";
											}
								?>
								<tr>
									<td><?=$i?>
									</td>
									<td><?=$sub['stream_name']?></td>
									<td><?=$sub['semester']?></td>
									<td><?=$sub['subject_code']?> - <?=$sub['subject_name']?></td>
									<td><?php if($rp_status=='1'){ echo "Done";}else{ echo "Not Done";}?> </td>
								</tr>
								<?php 
								$i++;
										}
									}else{
										echo "<tr><td colspan=2>No Data Available</td></tr>";
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
	$('#chk_stud_all').change(function () {
        $('.studCheckBox').prop('checked', $(this).prop('checked'));
    });
	//
	$('#chk_sub_all').change(function () {
        $('.subCheckBox').prop('checked', $(this).prop('checked'));
    });
	
	// fetch stream form course
	var stream_id = $("#semester").val();
	if(stream_id !=''){
		$("#sem_id").val(stream_id);
	}
	$('#course_id').on('change', function () {			
			var course_id = $(this).val();
			var academic_year = $("#academic_year").val();
			var school_code = $("#school_code").val();
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>subject_allocation/load_streams',
					data: {course_id:course_id,academic_year:academic_year,school_code:school_code},
					success: function (html) {
						//alert(html);
						$('#stream_id').html(html);
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		var school_code = '<?=$school_code?>';
		//alert(school_code);
		var course_id = '<?=$courseId?>';
        var stream_id = '<?=$streamId?>';
		//alert(course_id);alert(stream_id);
			if (course_id) {
				var academic_year = $("#academic_year").val();
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>subject_allocation/load_streams',
					data: {course_id:course_id,academic_year:academic_year,school_code:school_code},
					success: function (html) {
						//alert(html);
						var streamId = '<?=$streamId?>';
						$('#stream_id').html(html);
						$("#stream_id option[value='" + streamId + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
	
	 $('#stream_id').change(function () {
		var course_id = $("#course_id").val();
        var stream_id = $("#stream_id").val();
		var academic_year = $("#academic_year").val();
		if (stream_id) {
			$.ajax({
				'url' : base_url + '/subject_allocation/load_semester',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'academic_year' : academic_year,stream_id:stream_id,course_id:course_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
				//alert(data);
					var container = $('#semester'); //jquery selector (get element by id)
					if(data){	
						container.html(data);
					}
				}
			});
		}
    });		


		var academic_year = $("#academic_year").val();
		if (stream_id) {
			$.ajax({
				'url' : base_url + '/subject_allocation/load_semester',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'academic_year' : academic_year,stream_id:stream_id,course_id:course_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semester'); //jquery selector (get element by id)
					if(data){	
						var semester = '<?=$semesterNo?>';
						container.html(data);
						$("#semester option[value='" + semester + "']").attr("selected", "selected");
					}
				}
			});
		}
  });
function get_count_selected(strm){

	var chk_checked_length = $('input[class=subCheckBox]:checked').length;
	//alert(chk_checked_length);
	var tot_subjects ="<?=$strmsub[0]['total_subject']?>";
	//alert(tot_subjects);
	
	if(chk_checked_length == tot_subjects){
		//alert("inside");
		alert("You can select Maximum "+tot_subjects);
		 $('input[class=subCheckBox]:not(:checked)').attr('disabled', 'disabled');		 
	}else{
		//alert("outside");
		$('input[class=subCheckBox]').removeAttr('disabled');
	}
}  
function validate_student(strm){

	var chk_stud_checked_length = $('input[class=studCheckBox]:checked').length;
	var chk_sub_checked_length = $('input[class=subCheckBox]:checked').length;
	if(chk_stud_checked_length == 0){
		 alert('please check atleast one Student from student list');
		 return false;
	}else if(chk_sub_checked_length == 0){
		 alert('please check atleast one Subject from subject list');
		 return false;
	}else{
		return true;
	}
} 
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
		"pageLength": 50,
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Subject Syllabus Status'
            }
        ]
    } );
} );
</script>