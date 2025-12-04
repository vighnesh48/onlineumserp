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
				'url' : base_url + 'Batchallocation/load_streams',
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
		
	$('.numbersOnly').keyup(function () {
		if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
		   this.value = this.value.replace(/[^0-9\.]/g, '');
		}
	});   	
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
                           <form id="form" name="form" action="<?=base_url($currentModule.'/search_subAndStudent_phd')?>" method="POST">                                                               
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
                                <select name="admission_cycle" id="admission_cycle" class="form-control" required>
                                  <option value="">Select Type</option>
                                  <?php
								  
									foreach ($cycle as $cycle) {
										if ($cycle['admission_cycle'] == $_POST['admission_cycle']) {
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
								
								<div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
                            </div>
							</form>
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
					<div class="col-sm-4" >
					<select name="division" id="division" class="form-control" required>
					  <option value="">Select Division</option>
					  <option value="A" <?php if(!empty($divT) && $divT =='A'){ echo "selected";}?>>A</option>
					<option value="B" <?php if(!empty($divT) && $divT =='B'){ echo "selected";}?>>B</option>
					<option value="C" <?php if(!empty($divT) && $divT =='C'){ echo "selected";}?>>C</option>
					<option value="D" <?php if(!empty($divT) && $divT =='D'){ echo "selected";}?>>D</option>
					<option value="E" <?php if(!empty($divT) && $divT =='E'){ echo "selected";}?>>E</option>
					<option value="F" <?php if(!empty($divT) && $divT =='F'){ echo "selected";}?>>F</option>
				   </select>
				</div>
				<div class="col-sm-4">
					<select id="subject" name="batch" class="form-control" >
						<option value="">Select batch</option>	
						
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="0">No Batch</option>
					</select>											
				</div> 
				<div class="col-sm-4"> <button class="btn btn-primary form-control" id="btn_allocate" type="submit" onclick="return validate_student(this.value)">Assign Batch</button> </div>
				<div class="clearfix">&nbsp;</div><br>
                        <div class="table-info" style="overflow:scroll;height:700px;">  
							<div class=""> 
								
								<input type="hidden" name="class" id="classa" value="<?=$class?>">
								<input type="hidden" name="sem" id="sem" value="<?=$semesterNo?>">
								<input type="hidden" name="streamId" id="streamId" value="<?=$streamId?>">
								<input type="hidden" name="academic_year" id="academicyear" value="<?=$academicyear?>">
							
							</div>
							<table id="example" class="table table-bordered">
							<thead>
								<tr>
									<th data-orderable="false"><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th>
									<th data-orderable="false">#</th>
									<th data-orderable="false">PRN</th>
									<th data-orderable="false">Student Name</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
								if(!empty($studbatch_allot_list1)){
										foreach($studbatch_allot_list1 as $stud){
											$stud_app_id[]= $stud['stud_id']; 
										}
								}
								//print_r($stud_app_id);
								$i=1;
									if(!empty($studlist)){
										foreach($studlist as $stud){
											if (!in_array($stud['stud_id'], $stud_app_id)){
								?>
									<tr>
										<td><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?=$stud['stud_id']?>"></td>
										<td><?=$i?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?php echo $stud['first_name']." ".$stud['middle_name']." ".$stud['last_name'];?></td>
										
									</tr>
								<?php
									$i++;
								}
										
										}
									}else{
										echo "<tr><td colspan=4>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table>
							
						</div>
                    </div>
                </div>
			</div>
			
			<!--form id="form" name="form" action="<?=base_url($currentModule.'/removeStudFromBatch')?>" method="POST"-->   
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
					<div class="col-sm-4"> <button class="btn btn-primary form-control" id="btn_remove" type="button" onclick="return validate_removeStudent(this.value)">Remove</button> </div>
						<div class="clearfix">&nbsp;</div><br><br>
						<div style="color:green" id="alrtmsg"></div>
                        <div class="table-info" style="overflow:scroll;height:700px;">  
						
							<table class="table table-bordered">
							<thead>
								<tr>
									<th></th>
									<th id="rlno">Sr.No.</th>
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
							
						</div>
                    </div>
                </div>
			</div>
			<!--/form-->
		</div>
			
    </div>
</div>
<div id="wait" style="display:none;position:absolute;top:30%;left:80%;padding:2px;"><img src="<?=base_url()?>assets/images/demo_wait_b.gif"/><br>Loading..</div>
<script>
$(document).ready(function () {
	$(document).ajaxStart(function(){
        $("#wait").css("display", "block");
    });
	
    $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
    });
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
			var batch = $("#subject").val();
			var classa= $("#classa").val(); 
			var division = $("#division").val();
			var sem = $("#sem").val();
			var streamId = $("#streamId").val();
			var academic_year = $("#academicyear").val();
			//alert(sem);
			if(division==""){
				alert("Please select division");
				$("#division").focus();
				return false;
			}
			if(batch==""){
				alert("Please select Batch");
				$("#subject").focus();
				return false;
			}
			var chk_checked = [];
            $.each($("input[name='chk_stud[]']:checked"), function(){            
                chk_checked.push($(this).val());
            });
			var arr_length = chk_checked.length;
			if(arr_length ==0){
				return false;
			}
			if (arr_length !=0) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Batchallocation/assign_batchToStudent',
					data: {chk_stud:chk_checked,batch:batch,division:division,sem:sem,stream:streamId,classa:classa,academic_year:academic_year},
					success: function (data) {
						//alert(data);
						$("#rlno").html("Sr.No");
						if(data!='dupyes'){
							var absent=JSON.parse(data);
							//alert(absent.astd);
							var allstud_list = absent.ss.length;
							var allocated_stud_list = absent.astd.length;
							var allAllocatedStudList = absent.allstd.length;
							//console.log(absent.cnt_absent);
							//alert(allstud_list);
							var alloc_array =[];
							for(k=0;k< allAllocatedStudList;k++)
							{
								alloc_array.push(absent.allstd[k].enrollment_no);
							}
							//console.log(alloc_array);
							var str="";
							var q=0;
							for(i=0;i< allstud_list;i++)
							{
								if(jQuery.inArray(absent.ss[i].enrollment_no, alloc_array) != -1){
									if(allstud_list == allocated_stud_list){
										var str5="";
										str5+='<tr>';
										str5+='<td colspan=4>All students are  allocated!.</td>';
										str5+='</tr>';	
										$("#studtbl").html(str5);
									}
								
								}else{
									//alert(absent.ss[i].enrollment_no);
									str+='<tr>';
									str+='<td><input type="checkbox" name="chk_stud[]" id="chk_stud" class="studCheckBox" value="'+absent.ss[i].stud_id+'"></td>'; 
									str+='<td>'+(q+1)+'</td>';   
									str+='<td>'+absent.ss[i].enrollment_no+'</td>';
									str+='<td>'+absent.ss[i].first_name+' '+absent.ss[i].middle_name+' '+absent.ss[i].last_name+'</td>';
									$("#studtbl").html(str);
								q++;
								}
							}
				
							var str1="";
							for(k=0;k< allocated_stud_list;k++)
							{
								//alert("inside");
								//alert(absent.astd[k].stud_id);
								str1+='<tr>';
								str1+='<td><input type="checkbox" name="chk_stud_batch[]" id="chk_stud_batch" class="CheckBox" value="'+absent.astd[k].stud_id+'"></td>';
								str1+='<td>'+(k+1)+'</td>';   
								str1+='<td>'+absent.astd[k].enrollment_no+'</td>';
								str1+='<td>'+absent.astd[k].first_name+' '+absent.astd[k].middle_name+' '+absent.astd[k].last_name+'</td>';
								$("#allocatestudent").html(str1);
							}
							alert("student batch allocated Successfully");
							
						}else{
							alert("already Assigned batch");
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
		
		///////////////////////
			//remove student batch
	$('#btn_remove').on('click', function () {
		//alert("hi");
		var division = $("#division").val();
		var batch = $("#subject").val();
		var classa= $("#classa").val();
		var sem = $("#sem").val();
		var streamId = $("#streamId").val();
		var academic_year = $("#academicyear").val();		
			var chk_checked_bhk = [];
            $.each($("input[name='chk_stud_batch[]']:checked"), function(){            
                chk_checked_bhk.push($(this).val());
            });
			var arr_length_bhk = chk_checked_bhk.length;
			if(arr_length_bhk ==0){
				return false;
			}
			if (arr_length_bhk !=0) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Batchallocation/removeStudFromBatch',
					data: {chk_stud:chk_checked_bhk,division:division,batch:batch,classa:classa,sem:sem,stream:streamId,academic_year:academic_year},
					success: function (data1) {
						//alert(data1);
							$("#rlno").html("Sr.No");
							var absent1=JSON.parse(data1);
							//alert(absent1);
							var stud_list = absent1.batchlist.length;
							//alert(stud_list);
							var allstud_list = absent1.ss.length;
							var allAllocatedStudList = absent1.allstd.length;
							//console.log(absent1.cnt_absent);
							//alert(allstud_list);
							var alloc_array =[];
							for(k=0;k< allAllocatedStudList;k++)
							{
								alloc_array.push(absent1.allstd[k].enrollment_no);
							}
							//console.log(alloc_array);
							var str="";
							var q=0;
							for(i=0;i< allstud_list;i++)
							{
								//alert("inside");
								//alert(absent1.ss[i].enrollment_no);
								if(jQuery.inArray(absent1.ss[i].enrollment_no, alloc_array) == -1){
									
								str+='<tr>';
								str+='<td><input type="checkbox" name="chk_stud[]" id="chk_stud" class="studCheckBox" value="'+absent1.ss[i].stud_id+'"></td>'; 
								str+='<td>'+(q+1)+'</td>';   
								str+='<td>'+absent1.ss[i].enrollment_no+'</td>';
								str+='<td>'+absent1.ss[i].first_name+' '+absent1.ss[i].middle_name+' '+absent1.ss[i].last_name+'</td>';
								$("#studtbl").html(str);
								q++;
								}
							}
							var str3="";
							for(k=0;k< stud_list;k++)
							{
								str3+='<tr>';
								str3+='<td><input type="checkbox" name="chk_stud_batch[]" id="chk_stud_batch" class="CheckBox" value="'+absent1.batchlist[k].stud_id+'"></td>';
								str3+='<td>'+(k+1)+'</td>';   
								str3+='<td>'+absent1.batchlist[k].enrollment_no+'</td>';
								str3+='<td>'+absent1.batchlist[k].first_name+' '+absent1.batchlist[k].middle_name+' '+absent1.batchlist[k].last_name+'</td>';
								$("#allocatestudent").html(str3);
							}
							alert("student removed from batch Successfully");	
					}
				});
			} else {
				$('#studtbl').html('<option value="">No data found</option>');
			}
		});
		//////////////////
		$('#subject').on('change', function () {
			//alert("hi");
			var division = $("#division").val();
			var batch = $("#subject").val();
			var classa= $("#classa").val();
			var sem = $("#sem").val();
			var streamId = $("#streamId").val();
			var academic_year = $("#academicyear").val();
			//alert(academic_year);
			if (division) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Batchallocation/fetchBatchWiseStudent',
					data: {division:division,batch:batch,classa:classa,sem:sem,stream:streamId,academic_year:academic_year},
					success: function (data1) {
						//alert(data1);
							var absent1=JSON.parse(data1);
							//alert(absent1);
							var stud_list = absent1.batchlist.length;
							//alert(stud_list);
							$("#rlno").html("Roll No");
							var str3="";
							if(stud_list !=0){
								for(k=0;k< stud_list;k++)
								{
									//alert("inside");
									if(absent1.batchlist[k].enrollment_no !='null'){
									
									str3+='<tr>';
									str3+='<td><input type="checkbox" name="chk_stud_batch[]" id="chk_stud_batch" class="CheckBox" value="'+absent1.batchlist[k].stud_id+'"></td>';
									str3+='<td><input type="text" name="stud_roll_no[]" id="'+absent1.batchlist[k].stud_id+'" style="width:50px" class="form-control numbersOnly" maxlength="2" value="'+absent1.batchlist[k].roll_no+'" onblur="updateRollNo('+"'"+absent1.batchlist[k].stud_id+"'"+')"></td>';   
									str3+='<td>'+absent1.batchlist[k].enrollment_no+'</td>';
									str3+='<td>'+absent1.batchlist[k].first_name+' '+absent1.batchlist[k].middle_name+' '+absent1.batchlist[k].last_name+'</td>';
									}
									$("#allocatestudent").html(str3);
								}
							}else{
									var str4="";
									str4+='<tr>';
									str4+='<td colspan=4>No Data Found</td>';
									str4+='</tr>';	
									$("#allocatestudent").html(str4);
							}
							//alert("student removed from batch Successfully");	
					}
				});
			} else {
				//$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		
		/////
		
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
	//update student roll no
	function updateRollNo(rId) {
		
		var studId = rId;
		var rollNo = $("#"+rId).val();
		var division = $("#division").val();
		var batch = $("#subject").val();
		var classa= $("#classa").val();
		var sem = $("#sem").val();
		var streamId = $("#streamId").val();
		var academic_year = $("#academicyear").val();
		//alert(division);
		//alert(batch);
			if (rId !='' && rId !=0) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Batchallocation/updateStudRollNo',
					data: {studId:studId,rollNo:rollNo,division:division,batch:batch,streamId:streamId,sem:sem,academic_year:academic_year},
					success: function (data1) {
						//alert(data1);
							if(data1=='SUCCESS'){	
								$('#alrtmsg').html('Roll No Updated Successfully');
							}else if(data1=='DUP'){
								alert("This Roll No is already assigned.");								
								//$("#"+rId).val('');	
								//$("#"+rId).focus();
							}
							else{
								alert("Problem while updating roll no.");	
							}
					}
				});
			} else {
				alert("test");
			}
		}
	</script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
<script>

$(document).ready(function() {
    $('#example').dataTable({
    	"bInfo" : false,
    	"bPaginate": false,
    
	});
} );
</script>