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
		
		//edit division
		var strem_id1 = '<?=$streamId?>';
		var semesterId1 = '<?=$semesterNo?>';
		//alert(strem_id1);alert(semesterId1);
		if (strem_id1 !='' && semesterId1 !='') {
			//alert('hi');
			$.ajax({
				'url' : base_url + '/Batch_allocation/load_division',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : strem_id1,'semesterId':semesterId1},
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
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Batch Allocation</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Batch Allocation</h1>
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
                            <span class="panel-title">Batch Allocation</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/search_subAndStudent')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />
								<div class="form-group">
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
										echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_name'] . '</option>';
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
											<?php for($i=1;$i<=10;$i++) {
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
								<div class="col-sm-2" >
                                <select name="division" id="division" class="form-control" required>
                                  <option value="">Select Division</option>
                               </select>
                              </div>
								<div class="col-sm-2">
									<select id="subject" name="subject" class="form-control" >
										<option value="">Select Subject</option>	
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
            <div class="col-sm-6">
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
                        <div class="table-info">  
							<div class=""> 
								<input type="hidden" name="sub_code" id="sub_code" value="<?=$subCode?>">
								<input type="hidden" name="class" id="classa" value="<?=$class?>">
								<input type="hidden" name="division" id="division" value="<?=$division?>">
								<input type="hidden" name="batch" id="batch" value="<?=$batch?>">
								<input type="hidden" name="sem" id="sem" value="<?=$semesterNo?>">
								<input type="hidden" name="streamId" id="streamId" value="<?=$streamId?>">
							
							</div>
							<table id="example" class="table table-bordered">
							<thead>
								<tr>
									<th data-orderable="false"><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th>
									<th data-orderable="false">Sr.No.</th>
									<th data-orderable="false">PRN</th>
									<th data-orderable="false">Student Name</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
								if(!empty($studbatch_allot_list)){
										foreach($studbatch_allot_list as $stud){
											$stud_app_id[]= $stud['sub_applied_id']; 
										}
								}
								//print_r($stud_app_id);
								$i=1;
									if(!empty($studlist)){
										foreach($studlist as $stud){
											if (!in_array($stud['sub_applied_id'], $stud_app_id)){
								?>
									<tr>
										<td><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?=$stud['sub_applied_id']?>"></td>
										<td><?=$i?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?php echo $stud['first_name']." ".$stud['middle_name']." ".$stud['last_name'];?></td>
										
									</tr>
								<?php }
										$i++;
										}
									}else{
										echo "<tr><td colspan=4>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table>
							<div class="col-sm-4"> <button class="btn btn-primary form-control" id="btn_allocate" type="submit" onclick="return validate_student(this.value)">Assign Batch</button> </div>
						</div>
                    </div>
                </div>
			</div>
			
			<form id="form" name="form" action="<?=base_url($currentModule.'/removeStudFromBatch')?>" method="POST">   
			<div class="col-sm-6">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title"> Batch List :
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
                        <div class="table-info">  
							<table class="table table-bordered">
							<thead>
								<tr>
									<th></th>
									<th>Sr.No.</th>
									<th>PRN No.</th>
									<th>Student Name</th>
								</tr>
								</thead>
								<tbody id="allocatestudent">
								<?php
								$j=1;
									if(!empty($studbatch_allot_list)){
										foreach($studbatch_allot_list as $std){
								?>
								<tr>
									<td><input type="checkbox" name="chk_stud_batch[]" id="chk_stud_batch" class='CheckBox' value="<?=$std['sub_applied_id']?>"></td>
									<td><?=$j?></td>
									<td><?=$std['enrollment_no']?></td>
									<td><?php echo $std['first_name']." ".$std['middle_name']." ".$std['last_name'];?></td>
									
								</tr>
								<?php 
								$j++;
										}
									}else{
										echo "<tr><td colspan=4>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table>
							<div class="col-sm-4"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" onclick="return validate_removeStudent(this.value)">Remove</button> </div>
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
	///////////////////////////////
	
	//Allocate batch
	$('#btn_allocate').on('click', function () {
		//alert("hi");
			var chk_stud = $("#chk_stud").val();
			var sub_code = $("#sub_code").val();
			var batch = $("#batch").val();
			var classa= $("#classa").val(); 
			var division = $("#division").val();
			var sem = $("#sem").val();
			var streamId = $("#streamId").val();
			//alert(sem);
			var chk_checked = [];
            $.each($("input[name='chk_stud[]']:checked"), function(){            
                chk_checked.push($(this).val());
            });
			if (chk_stud) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Batch_allocation/assign_batchToStudent',
					data: {chk_stud:chk_checked,sub_code:sub_code,batch:batch,division:division,sem:sem,stream:streamId,classa:classa},
					success: function (data) {
						//alert(data);
						if(data!='dupyes'){
							var absent=JSON.parse(data);
							//alert(absent.astd);
							var allstud_list = absent.ss.length;
							var allocated_stud_list = absent.astd.length;
							//console.log(absent.cnt_absent);
							//alert(allstud_list);
							/*var alloc_array =[];
							for(k=0;k< allocated_stud_list;k++)
							{
								alloc_array.push(absent.astd[k].enrollment_no);
							}*/
							//console.log(alloc_array);
							var str="";
							for(i=0;i< allstud_list;i++)
							{
								//alert("inside");
								//alert(absent.ss[i].enrollment_no);
								//if(jQuery.inArray(absent.ss[i].enrollment_no, alloc_array) != -1){
								str+='<tr>';
								str+='<td><input type="checkbox" name="chk_stud[]" id="chk_stud" class="studCheckBox" value="'+absent.ss[i].sub_applied_id+'"></td>'; 
								str+='<td>'+(i+1)+'</td>';   
								str+='<td>'+absent.ss[i].enrollment_no+'</td>';
								str+='<td>'+absent.ss[i].first_name+' '+absent.ss[i].middle_name+' '+absent.ss[i].last_name+'</td>';
								$("#studtbl").html(str);
								//}
							}
							
							var str1="";
							for(k=0;k< allocated_stud_list;k++)
							{
								//alert("inside");
								//alert(absent.ss[i].enrollment_no);
								str1+='<tr>';
								str1+='<td><input type="checkbox" name="chk_stud_batch[]" id="chk_stud_batch" class="CheckBox" value="'+absent.astd[k].sub_applied_id+'"></td>';
								str1+='<td>'+(k+1)+'</td>';   
								str1+='<td>'+absent.astd[k].enrollment_no+'</td>';
								str1+='<td>'+absent.astd[k].first_name+' '+absent.astd[k].middle_name+' '+absent.astd[k].last_name+'</td>';
								$("#allocatestudent").html(str1);
							}
							alert("student batch allocated Successfully");
							
						}else{
							alert("You have already taken this batch attendance");
						}
						
					}
				});
			} else {
				$('#studtbl').html('<option value="">No data found</option>');
			}
		});
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
		
		$("#semester").change(function(){
			var room_no = $("#stream_id").val();
			var semesterId = $("#semester").val();
			
			$.ajax({
				'url' : base_url + 'Batch_allocation/load_division',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : room_no,'semesterId':semesterId},
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
		
		//post back subject
		var division_edit = '<?=$division?>';
			if(division_edit !=''){
				
				var streamId = '<?=$streamId?>';
				var semesterId = '<?=$semesterNo?>';
				var course_id = $("#course_id").val();
				//alert(streamId);alert(course_id);alert(semester_Id);
				$.ajax({
					'url' : base_url + 'Batch_allocation/load_subject',
					'type' : 'POST', //the way you want to send data to your URL
					'data' : {'course' : course_id,'streamId':streamId,'semesterId':semesterId,'division':division_edit},
					'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
						var container = $('#subject'); //jquery selector (get element by id)
						if(data){
							//alert(data);
							var subject_id = '<?=$subject_req ?>';
							//alert(subject_id);
							container.html(data);
							$("#subject option[value='" + subject_id + "']").attr("selected", "selected");
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
function get_count_selected(strm){

	var chk_checked_length = $('input[class=subCheckBox]:checked').length;
	//alert(chk_checked_length);
	var tot_subjects ="<?=$strmsub[0]['total_subject']?>";
	//alert(tot_subjects);
	if(chk_checked_length == tot_subjects){
		//alert("inside");
		 $('input[class=subCheckBox]:not(:checked)').attr('disabled', 'disabled');
	}else{
		//alert("outside");
		$('input[class=subCheckBox]').removeAttr('disabled');
	}
}  
function validate_student(strm){

	var chk_stud_checked_length = $('input[class=studCheckBox]:checked').length;
	if(chk_stud_checked_length == 0){
		 alert('please check atleast one Student from student table');
		 return false;
	}else{
		return true;
	}
} 
function validate_removeStudent(strm){

	var stud_checked_length = $('input[class=CheckBox]:checked').length;
	if(stud_checked_length == 0){
		 alert('please check atleast one Student to remove from batch');
		 return false;
	}else{
		return true;
	}
}
	</script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
<script>

$(document).ready(function() {
    $('#example').dataTable({
    "bPaginate": false
	});
} );
</script>	