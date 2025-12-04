<script>    
    $(document).ready(function()
    {  
		
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
				'url' : base_url + 'Subject/load_streams',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course' : course_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semest'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?=$streamId ?>';
						container.html(data);
						$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
		
    });

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
        <li class="active"><a href="#">Subject Allocation</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Subject Allocation</h1>
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
                            <span class="panel-title">Subject Allocation </span>
                    </div>

                    <div class="panel-body">
                        <div class="table-info">                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/search_subAndStudent')?>" method="POST">                                                               
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
                              <div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" required>
                                  <option value="">Select Course</option>
                                  <?php
									foreach ($course_details as $course) {
										if ($course['course_id'] == $courseId) {
											$sel1 = "selected";
										} else {
											$sel1 = '';
										}
										echo '<option value="' . $course['course_id'] . '"' . $sel1 . '>' . $course['course_short_name'] . '</option>';
									}
									?>
                               </select>
                              </div>
                          
                              <div class="col-sm-2">
                                <select name="stream_id" id="stream_id" class="form-control" required="required">
                                  <option value="">Select Stream</option>      
                               </select>
                              </div>
							  <div class="col-sm-2">
									<select id="semester" name="semester" class="form-control" required>
                                            <option value="">Select Semester</option>	
											
											</select>
									</div>  
								<div class="col-sm-2 "> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
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
			<form id="form" name="form" action="<?=base_url($currentModule.'/assign_subToStudent')?>" method="POST">    
            <div class="col-sm-6">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname">Student List</span>
                    </div>
                    <div class="panel-body" style="overflow:scroll;height:700px;">
                        <div class="table-info">  
							<table class="table table-bordered">
							<thead>
								<tr>
									<th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th>
									<th>S.No.</th>
									<th>PRN</th>
									<th>Student Name</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								if(!empty($allcated_studlist)){
										foreach($allcated_studlist as $student){
											$stud_app_id[]= $student['stud_id']; 
										}
								}
								$m=1;
									if(!empty($studlist)){
										foreach($studlist as $stud){
											if (in_array($stud['stud_id'], $stud_app_id)){
												$applied = "style='background-color:#bfd4ac;'";
												$aurl = base_url()."subject_allocation/view_studSubject/".$stud['stud_id'];
												$ahref= "<a href='$aurl' target='_blank' style='float:right'>View</a>";
												//$disabled="disabled";
												$disabled="";
											}else{
												$applied = "";
												$ahref ="";
												$disabled="";
											}
									
								?>
								<tr <?=$applied?>>
									<td><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?=$stud['stud_id']?>" <?=$disabled?>></td>
									<td><?=$m?></td>
									<td><?php if($stud['transefercase'] == 'Y'){ echo $stud['enrollment_no'].' <img src="https://erp.sandipuniversity.com/uploads/Transfer-PNG.png" style="width:15px; height:15px"> ';}else{echo  $stud['enrollment_no'];}?></td>
									<td><?php echo $stud['first_name']." ".$stud['middle_name']." ".$stud['last_name'];?> <?=$ahref?></td>
									
								</tr>
								<?php 
									$m++;
										}
									}else{
										echo "<tr><td colspan=4>Student registrations are not done.</td></tr>";
									}
								?>
								</tbody>
							</table>
							
						</div>
                    </div>
                </div>
			</div>
			<div class="col-sm-6">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Subject List- Batch: <?=$batch?></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">  
							<table class="table table-bordered">
							<thead>
								<tr>
									<th><!--input type="checkbox" name="chk_sub_all" id="chk_sub_all"--></th>
									<th>Subject Name</th>
									
								</tr>
							</thead>
							<tbody>
							<input type="hidden" name="sem_id" id="sem_id" value="<?=$semesterNo?>" >
							<input type="hidden" name="sub_stream" id="sub_stream" value="<?=$streamId?>" >
							<input type="hidden" name="acad_year" id="acad_year" value="<?=$SAacademic_year?>" >
								<?php
								
									if(!empty($sublist)){
										foreach($sublist as $sub){
											if($sub['subject_type']=='CUM'){
												//echo $studlist[0]['admission_school'];
												if($studlist[0]['admission_school']==2){
												$sub_checked ="";
												$readonly="";
												}else{
													//$sub_checked ="checked='checked'";
													//$readonly="onclick='this.checked=!this.checked;'";
												}
											}else{
												$sub_checked ="";
												$readonly="";
											}
								?>
								<tr>
									<td>
									<input type="checkbox" name="chk_sub[]" class="subCheckBox" value="<?=$sub['sub_id']?>" <?=$readonly?> <?=$sub_checked?> onclick="get_count_selected(this.value)">
									
									</td>
									<td><?=$sub['subject_code']?> - <?=$sub['subject_name']?></td>
									
								</tr>
								<?php 
										}
									}else{
										echo "<tr><td colspan=2>Subjects are not found,Kinldy check the subject master.</td></tr>";
									}
								?>
								</tbody>
							</table>
							<?php if(!empty($sublist)){?>
							<div class="col-sm-4"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" onclick="return validate_student(this.value)">Assign Subject</button> </div>
							<?php }?>
						</div>
                    </div>
                </div>
			</div>
			</form>
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
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>subject_allocation/load_streams',
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
	 $('#stream_id').change(function () {
		var course_id = $("#course_id").val();
        var stream_id = $("#stream_id").val();
		var academic_year = $("#academic_year").val();
		if (stream_id) {
			$.ajax({
				'url' : base_url + 'subject_allocation/load_semester',
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
		var course_id = '<?=$courseId?>';
        var stream_id = '<?=$streamId?>';
		var academic_year = $("#academic_year").val();
		
		if (stream_id) {
			$.ajax({
				'url' : base_url + 'subject_allocation/load_semester',
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
	
	
		//alert(stream_id);
		var academic_year = '<?=$SAacademic_year?>';
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>subject_allocation/load_streams',
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
  });
function get_count_selected(strm){
  
	var chk_checked_length = $('input[class=subCheckBox]:checked').length;
	
	var tot_subjects ="<?=$strmsub[0]['total_subject']?>";
	
	
	if(parseInt(chk_checked_length) == parseInt(tot_subjects)){
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
	</script>