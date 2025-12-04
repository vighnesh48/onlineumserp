
<?php 
$faculty_arr = array();
foreach ($faculty_list as $value) {
	$faculty_arr[] = $value['emp_id'].", ".$value['fac_name'].", ".$value['department_name'];
}

 ?>
				 <?php 
     if(isset($_SESSION['status']))
    {
        ?>
			<script>
			//alert("Your Details already Submitted.");
			var status="<?php echo $_SESSION['status'] ?>";
			 alert(status);
			</script>
        <?php 
        unset($_SESSION['status']);
       }
   ?>

<script>    
    $(document).ready(function()
    {  
	  var tempArray = <?php echo json_encode($faculty_arr);?>;
      var dataSrc = tempArray;
 
    $(".faculty_search").autocomplete({
        source:dataSrc
    });
		//Num check logic
		$('.numbersOnly').keyup(function () {
			if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
			   this.value = this.value.replace(/[^0-9\.]/g, '');
			} 
		});		
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
        <li class="active"><a href="#">Guide Allocation</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Guide Allocation</h1>
            <div class="col-xs-12 col-sm-6">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">					   
                </div>
            </div>
            <div class="col-xs-12 col-sm-2">
                  <a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url()?>Guide_allocation_phd/guide_allocation_view"><span class="btn-label icon fa fa-chevron-left"></span>Allocated Guide List</a>
				  <div class="visible-xs clearfix form-group-margin"></div>
              </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Guide Allocation</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info"> 
                             <?php // if(in_array("Search", $my_privileges)) { ?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/search_subAndStudent')?>" method="POST">
                                <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />
							<div class="form-group">
							    <div class="col-sm-2" >
                                <select name="admission_cycle" id="admission_cycle" class="form-control" required>
                                  <option value="">Select Batch</option>
                                  <?php
									foreach ($cycle as $cycle) {
										if ($cycle['admission_cycle'] == $admission_cycle) {
											$sel1 = "selected";
										} else {
											$sel1 = '';
										}
										echo '<option value="' . $cycle['admission_cycle'] . '"' . $sel1 . '>' . $cycle['admission_cycle'] . '</option>';
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
							 <?php //} ?>
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
			<form id="form" name="form" action="<?php //base_url($currentModule.'/assign_faculty_to_student')?>" method="POST">    
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
									<th><!--input type="checkbox" name="chk_stud_all" id="chk_stud_all"--></th>
									<th>S.No.</th>
									<th>PRN</th>
									<th>Student Name</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								  $disabled="";
									if(!empty($allcated_guidelist)){
										foreach($allcated_guidelist as $student){
											$stud_app_id[]= $student['student_id']; 
										}
								}
								$m=1;$key=0;
									if(!empty($studlist)){
										foreach($studlist as $stud){
											
								if (in_array($stud['stud_id'], $stud_app_id)){
									$disabled='disabled';
								     }else{ $disabled='';}
		
								?>
								<tr>
									<td><input type="checkbox" name="chk_stud[<?=$key?>][id]" id="chk_stud" class='studCheckBox' value="<?=$stud['stud_id']?>" <?=$disabled?>>
									<!--input type="hidden" name="chk_stud[<?=$key?>][prn]" id="stud_prn" class='studCheckBox' value="<?=$stud['enrollment_no']?>" <?=$disabled?>>
									<input type="hidden" name="chk_stud[<?=$key?>][name]" id="stud_name" class='studCheckBox' value="<?=$stud['first_name'].' '.$stud['last_name']?>"  -->
                                    </td>
									<td><?=$m?></td>
									<td><?=$stud['enrollment_no']?></td>
									<td><?php echo $stud['first_name']." ".$stud['middle_name']." ".$stud['last_name'];?> <?=$ahref?></td>
								</tr>
								<?php 
									$m++;$key++;
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
                            <span class="panel-title">Faculty List</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">  
							<table class="table table-bordered">
							<thead>
								<tr>
									<th>Faculty List</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>
									<input type="text" class="form-control faculty_search" name="faculty" id="faculty_search" value=""><small>Type Faculty Name or Code</small>
                                    </th>
								</tr>
								</tbody>
							</table>
							  <?php //if(in_array("Add", $my_privileges)){ ?>
							<div class="col-sm-4"> <button class="btn btn-primary form-control" id="btn_submit" type="button" onclick="return validate_student(this.value)">Assign Faculty</button> </div>
							  <?php //} ?>
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
			var admission_cycle = $("#admission_cycle").val();
			if(admission_cycle=='')
			{
				alert('Select Any Batch');
			}
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Guide_allocation_phd/load_streams',
					data: {course_id:course_id,admission_cycle:admission_cycle},
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
		var admission_cycle = $("#admission_cycle").val();
		if (stream_id) {
			$.ajax({
				'url' : base_url + 'Guide_allocation_phd/load_semester',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {admission_cycle: admission_cycle,stream_id:stream_id,course_id:course_id},
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
		var admission_cycle = $("#admission_cycle").val();
		
		if (stream_id) {
			$.ajax({
				'url' : base_url + 'Guide_allocation_phd/load_semester',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'admission_cycle' : admission_cycle,stream_id:stream_id,course_id:course_id,phd:1},
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
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Guide_allocation_phd/load_streams',
					data: {course_id:course_id,admission_cycle:admission_cycle},
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
	//alert(chk_checked_length);
	var tot_subjects ="<?=$strmsub[0]['total_subject']?>";
	//alert(tot_subjects);
	
	if(chk_checked_length == tot_subjects){
		//alert("inside");
		alert("You can select Maximum "+tot_subjects);
		// $('input[class=subCheckBox]:not(:checked)').attr('disabled', 'disabled');		 
	}else{

		$('input[class=subCheckBox]').removeAttr('disabled');
	}
}  
 function validate_student(strm){
    var chk_stud = [];
 $('input[class=studCheckBox]:checked').each(function() {
   chk_stud.push($(this).val());
 });
	var chk_stud_checked_length = $('input[class=studCheckBox]:checked').length;
    var faculty=$("#faculty_search").val();
	if(chk_stud_checked_length == 0){
		 alert('please check atleast one Student from student list');
		 return false;
	}else if(faculty ==''){
	     alert('please select one Faculty from Faculty list');
		 return false;
	}else{
			$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Guide_allocation_phd/assign_faculty_to_student',
					data: {chk_stud:chk_stud,faculty:faculty},
				'success' : function(data){ //probably this request will return 
					if(data!=0){
						location.reload();
                         alert("Guide Allocation Done Successfully.");
						  
					}
					else
					{
						 alert("Something Wrong.");
					}
				}
			});
	}
}  
	</script>
