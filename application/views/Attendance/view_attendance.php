<?php  $emp_id= $this->session->userdata('name');?>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style type="text/css">.loader {
  border: 6px;
  border-radius: 50%;
  border-top: 6px solid pink;
  border-bottom: 6px solid pink;
  width: 90px;
  height: 90px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  margin-left:50%;
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<script> 

    $(document).ready(function()
    {
    	
    	//alert(academic_year);
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
		var course_id = $("#room_no").val();
		var academic_year = '<?=$academic_year?>';
		///alert(academic_year);
		if (course_id) {
			$.ajax({
				'url' : base_url + 'Attendance/load_sem',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : course_id,academic_year:academic_year},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semester'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?=$semesterNo ?>';
						container.html(data);
						$("#semester option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
		<?php if($emp_id !='110383'){?>
		//alert('1');,startDate: '-0d'
		$('#dt-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
		<?php }else{ ?>
		//alert('2');
		$('#dt-datepicker').datepicker( {format: 'yyyy-mm-dd',autoclose: true,startDate: '-0d'});//startDate: '-0d',
		<?php } ?>
    });

</script>
<style>
.absent_bg{background:#ff9b9b;}
</style>
<?php
$role_id=$this->session->userdata('role_id');
echo $this->session->userdata('emp_id');
//print_r($sb);
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<?php
// Set the timezone to India (IST)
date_default_timezone_set("Asia/Kolkata");
// Get the current time
echo $currentTime = date("H:i");//exit;

// Define the cutoff time
$cutoffTime = "18:15";

// Check if the current time is past 6:30 PM
$isDisabled = ($currentTime > $cutoffTime);
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Attendance</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Mark Attendance</h1>
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
					<?php if($this->session->userdata('emp_id')=='21101'){ ?>
						<form id="form" name="form" action="<?=base_url($currentModule.'/search_subAndStudent_testing')?>" method="POST">    
					<?php }else{?>
                             <form id="form" name="form" action="<?=base_url($currentModule.'/search_subAndStudent')?>" method="POST">    
					<?php }?>
                             <form id="form" name="form" action="<?=base_url($currentModule.'/search_subAndStudent')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />
                                <input type="hidden" value="<?=isset($academic_year) ? $academic_year : ''?>" id="academic_year" name="academic_year" />
								<div class="form-group">
								<!--div class="col-sm-2" >
                                <select name="room_no" id="room_no" class="form-control" required>
                                  <option value="">Select Class</option>
                                  <?php
									foreach ($classRoom as $class) {
										if ($class['stream_id'] == $classId) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $class['stream_id'] . '"' . $sel . '>' . $class['stream_short_name'] . '</option>';
									}
									?>
                               </select>
                              </div>
                              <div class="col-sm-2" >
                                <select name="semester" id="semester" class="form-control" required>
                                  <option value="">Select Semester</option>
                               </select>
                              </div> 
                              <div class="col-sm-2" >
                                <select name="division" id="division" class="form-control" required>
                                  <option value="">Select Division</option>
                               </select>
                              </div>
							                                
								<div class="col-sm-2">
									<select id="subject" name="subject" class="form-control" onchange="getSloat()" required>
										<option value="">Select Subject</option>	
									</select>											
								</div>-->
								<?php
								$emp_id= $this->session->userdata('name');
								//$att_date = date('Y-m-d');
								/*if($emp_schol_id==7){
									if($_REQUEST['today_date'] !=''){
										$att_date = $_REQUEST['today_date'];
									}else{ 
										//$att_date = date('Y-m-d');
										$att_date = $_REQUEST['today_date'];
									}
									$input_id='dt-datepicker1111';
								}else*/
								//110073
								if($_REQUEST['today_date'] !=''){
									//$att_date = date('Y-m-d');
									$att_date = $_REQUEST['today_date'];
									$input_id='dt-datepicker111';
								}else{
									$att_date = date('Y-m-d');
									$input_id='dt-datepicker111';//dt-datepicker111
								}
								if($emp_id==110073){
									//$att_date = '';
								}
								?>
								<label class="col-sm-1">Date:</label>
								 <div class="col-sm-2"><input type="text" class="form-control" name="today_date" id="<?=$input_id?>" value="<?php echo $att_date;?>" style="width:150px;"  readonly="true" required></div>							
								<div class="col-sm-3">
								
									<select id="subject" name="subject" class="form-control" onchange="getSloat()" required>
										<option value="">Select Subject</option>
										<?php 
										if($sub_details !=''){
											$sub_details = $sub_details;
										}else{
											$sub_details = $_REQUEST['subject'];
										}
										//print_r($sb);
										if(!empty($sb)){
											foreach($sb as $sub){
												$batchcode = $sub['subject_id'].'-'.$sub['division'].'-'.$sub['batch'].'-'.$sub['semester'].'-'.$sub['stream_id'].'-'.$sub['subject_type'];
												if ($batchcode == $sub_details) {
													$sel = "selected";
												} else {
													$sel = '';
												}

												$divsion = $sub['division'];
												$batchno =$sub['batch'];
												$stream_short_name = $sub['stream_short_name'];
												
												if($sub['subject_id'] !='OFF'){
													if($batchno ==0){
														$sub_batch = "";
													}else{
														$sub_batch =$batchno;
													}
													if(empty($sub['sub_code'])){
														$subjetcode=$sub['subject_id'];
													}else{
														$subjetcode=$sub['sub_code'];
													}
													echo '<option value="'.$sub['subject_id'].'-'.$sub['division'].'-'.$sub['batch'].'-'.$sub['semester'].'-'.$sub['stream_id'].'-'.$sub['subject_type'].'"' . $sel . '>'.$sub['subject_short_name'].'('.$subjetcode.')-'.$divsion.''.$sub_batch.' ('.$stream_short_name.')</option>';
												}
											}
										}
										?>									
									</select>											
								</div> 
								<div class="col-sm-2" >
                                <select name="slot_no" id="slot_no" class="form-control" required>
                                  <option value="">Select Slot</option>  
                               </select>
                              </div>
								<div class="col-sm-2"><?php if ($isDisabled){ ?>
        <p style="color: red;">The button is disabled after 6:00 PM.</p>
								<?php }else{ ?><button class="btn btn-primary form-control" id="btn_submit" type="submit">Search</button><?php }?></div>
                            </div>
							</form>
                    </div>
                    
                </div>

            </div>    
        </div>
		  <div class="row ">
			<!--form id="form" name="form" action="<?=base_url($currentModule.'/markAttendance')?>" method="POST"-->    
            <div class="col-sm-6">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname">Student List : 
							<?php 
							//echo $batch;
							if($batch !='0'){
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
						<!--div class="col-sm-3">
						Date :</div> <div class="col-sm-3"><input type="text" class="form-control" name="today_date" id="dt-datepicker" value="<?=date('Y-m-d');?>" style="width:150px;" readonly="true"></div><br><br><br-->
                        <div class="table-info">  
							<div class=""> 
								<input type="hidden" name="sub_code" id="sub_code" value="<?=$subCode?>">
								<input type="hidden" name="division" id="division" value="<?=$division?>">
								<input type="hidden" name="subject_type" id="subject_type" value="<?=$subjecttype?>">
								<input type="hidden" name="batch" id="batch" value="<?=$batch?>">
								<input type="hidden" name="sem" id="sem" value="<?=$semesterNo?>">	
								<input type="hidden" name="slot" id="slot" value="<?=$slot_no?>">
								<input type="hidden" name="stream_code" id="stream_code" value="<?=$classId?>">
							</div>
							<table class="table table-bordered">
							<thead>
								<tr>
									<th><!--input type="checkbox" name="chk_attstud_all" id="chk_attstud_all" checked="checked"--></th>
									<th>Roll No.</th>
									<th>PRN No.</th>
									<th>Student Name</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
							
								//print_r($stud_app_id);
								$i=1;
									if(!empty($studbatch_allot_list)){
										foreach($studbatch_allot_list as $stud){
											
											//exit;
								?>
									<tr id="chk<?=$stud['stud_id']?>">
                                       <?php
										$chk='';$class="";
										if(!empty($stud['UserId'])){
										$chk= 'checked="checked"'; 
										
										}
										else{
											$class="hidden";
										}
										
										?>
									
									
									
										<td><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox <?=$class;?> chk_stud<?=$stud['stud_id']?>'
										
										<?=$chk;?>
										
										
										value="<?=$stud['stud_id']?>" onclick="changeBackground('<?=$stud['stud_id']?>')"></td>
										<td><?=$stud['roll_no'];?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?php echo $stud['first_name']." ".$stud['middle_name']." ".$stud['last_name'];?></td>
										
									</tr>
								<?php 
								//}
										$i++;
										}
									}else{
										echo "<tr><td colspan=4>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table>
							<?php if(!empty($studbatch_allot_list)){?>
							<div class="form-group" id="other_topic" style="display:block">
							<label class="col-sm-2">Topic Covered Details <?= $astrik ?></label>
	                           <div class="col-sm-10">
	                                <textarea name="topic_contents" id="topic_contents" class="form-control" required="required"></textarea>
	                            </div>							 	
							</div>
							<div class="col-sm-4"> <button class="btn btn-primary form-control" id="btn_markAtt" type="button">Mark Attendance</button> </div>
							<?php }?>
							<div id="wait" style="display:none;"><div class="loader"></div><br>Loading..</div>
						</div>
                    </div>
                </div>
			</div>
			<!--/form-->
			  
			<div class="col-sm-6">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title"> Attendance Report</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">  
							<table class="table table-bordered">
							
								<tr>
									<th>Total Student </th><td ><span id="tot"></span></td>
								</tr>
								<tr>
									<th>Total Present Student</th><td> <span id="per"></span></td>
								</tr>
								<tr>
									<th>Total Absent Student</th><td><span id="absent"></span></td>
								</tr>
									
							</table>
							
						</div>
                    </div>
                </div>
				<?php 
				$faculty_id = $this->session->userdata("name");
				if($faculty_id=='110109'){?>
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Select Topic Covered</span>
							<span class="pull-right"><input type="radio" name="lplan"> Lesson Plan &nbsp;&nbsp;&nbsp;<input type="radio" name="lplan"> Other </span>
                    </div>
					<?php 
					//print_r($topics);
					?>
                    <div class="panel-body">
                        <div class="table-info">  
							<div class="form-group"> 		
							<label class="col-sm-4">Topic Name <?= $astrik ?></label>
	                            <div class="col-sm-8">
	                                <select name="topic_no" id="topic_no" class="form-control" required>
	                                  <option value="" >Select</option>
	                                  <?php foreach ($topics as $topc) {
										$topic_val = $topc['unit_no'].'.'.$topc['topic_no'];
										echo '<option value="'.$topic_val. '"' . $sel . '>' . $topic_val.'
										'.$topc['topic_name'].'</option>';
									}
									?>
	                                </select>
	                            </div>  
                            </div>
							<div class="form-group">
							<label class="col-sm-4">Subtopic Name <?= $astrik ?></label>
	                           <div class="col-sm-8" id="lsubtopic">
	                               
	                            </div>						 	
							</div>
							<div class="form-group">
							<label class="col-sm-4">Other Type Details <?= $astrik ?></label>
	                           <div class="col-sm-8">
	                                <textarea name="topic_contents" id="topic_contents" class="form-control"> </textarea>
	                            </div>							 	
							</div>
							
						</div>
                    </div>
                </div>
				<?php }?>
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Absent Student List</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">  
							<table class="table table-bordered" id="">
							<thead>
								<tr>
									<th>Roll No.</th>
									<th>PRN No.</th>
									<th>Student Name</th>
									<th>Parent Mobile</th>
									<th>Subscribe for sms</th>
								</tr>
							</thead>
							<tbody id="allocatestudent">
							</tbody>
							</table>
							<input type='hidden' name="absentStud" id="absentStud" value="">
							<!--div class="col-sm-3"> <button class="btn btn-primary form-control" id="btnSMS">Send SMS</button> </div-->
						</div>
                    </div>
                </div>
			</div>
			
		</div>
			
    </div>
</div>
<script>
	var academic_year = '<?=$academic_year?>';
$(document).ready(function () {
	//var academic_year = '<?=$academic_year?>';
	$('#chk_stud_all').change(function () {
        $('.studCheckBox').prop('checked', $(this).prop('checked'));
		
    });
	$('#chk_attstud_all').change(function () {
        $('.studCheckBox').prop('checked', $(this).prop('checked'));
		
    });
	//
	$('#chk_sub_all').change(function () {
        $('.subCheckBox').prop('checked', $(this).prop('checked'));
    });
	//mark attendance
	$('#btn_markAtt').on('click', function () {
		//alert("hi");
			var chk_stud = $("#chk_stud").val();
			var sub_code = $("#sub_code").val();
			var batch = $("#batch").val();
			var academic_year= $("#academic_year").val(); 
			var division = $("#division").val();
			var sem = $("#sem").val();
			var streamId = $("#stream").val();
			var subject = $("#subject").val();
			var topic_contents = $("#topic_contents").val();
			//var today_date = $("#dt-datepicker1111").val();
			var today_date = $("input[name='today_date']").val();
			if(today_date==''){
				alert('please select attendance date');
				return false;
			}
			if(topic_contents==''){
				alert('please enter the Topic Covered Details');
				$("#topic_contents").focus();
				return false;
			}
			//alert(today_date);
			var slot = $("#slot").val();
			var stream_code = $("#stream_code").val();
			//alert(stream_code);
			var chk_checked = [];
            $.each($("input[name='chk_stud[]']:checked"), function(){            
                chk_checked.push($(this).val());
            });
			if (chk_stud) {
				$("#wait").css("display", "block");
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Attendance/markAttendance',
					data: {chk_stud:chk_checked,sub_code:sub_code,batch:batch,division:division,today_date:today_date,sem:sem,slot:slot,stream:streamId,academic_year:academic_year,stream_code:stream_code,subject:subject,topic_contents:topic_contents},
					success: function (data) {
						//alert(data);
						if(data!='dupyes'){
							var absent=JSON.parse(data);
							//alert(absent.ss);
							var list_of_absent = absent.ss.length;
							//console.log(absent.cnt_absent);
							//alert(list_of_absent);
							
							var total_present = absent.cnt_present;
							var total_absent = absent.cnt_absent;
							var total = absent.allcnt;
							//alert(total);alert(total_present);alert(total_absent);
							$("#tot").html(total);
							$("#per").html(total_present);	
							$("#absent").html(total_absent);
							
							var str="";
							var pmoblist = [];
							for(i=0;i< list_of_absent;i++)
							{
								if(absent.ss[i].parent_mobile2 !=''){
									pmoblist.push(absent.ss[i].parent_mobile2+'~'+absent.ss[i].first_name+' '+absent.ss[i].last_name);
								}
								//alert("inside");
								//alert(absent.ss[i].enrollment_no);
								str+='<tr>';
								
								str+='<td>'+absent.ss[i].roll_no+'</td>';   
								str+='<td>'+absent.ss[i].enrollment_no+'</td>';
								str+='<td>'+absent.ss[i].first_name+' '+absent.ss[i].middle_name+' '+absent.ss[i].last_name+'</td>';
								str+='<td>'+absent.ss[i].parent_mobile2+'</td>';
								str+='<td>'+absent.ss[i].subscribe_for_sms+'</td>';
								$("#allocatestudent").html(str);
							}
							alert("Attendance marked successfully.");
							$("#wait").css("display", "none");
							$('input[name="absentStud"]').val(pmoblist);
						}else{
							alert("You have already taken this batch attendance");
							$("#wait").css("display", "none");
						}
						
					}
				});
			} else {
				$('#allocatestudent').html('<option value="">No data found</option>');
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
			var room_no = $("#room_no").val();
			var semesterId = $("#semester").val();
			var divs = $("#division").val();
			$.ajax({
				'url' : base_url + 'Attendance/load_subject',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : room_no,'semesterId':semesterId,'division':divs,academic_year:academic_year},
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
			var room_no = $("#room_no").val();
			var semesterId = $("#semester").val();
			
			$.ajax({
				'url' : base_url + 'Attendance/load_division',
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
		
		//edit subject
		/*var classid = $("#room_no").val();
		var semesterid = '<?=$semesterNo ?>';
		var division = '<?=$division?>';
		//alert(course_id);
		if (classid) {
			$.ajax({
				'url' : base_url + 'Attendance/load_subject',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : classid,'semesterId':semesterid,'division':division,academic_year:academic_year},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#subject'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						var subject = '<?=$sub_batch?>';
						//alert(subject);
						container.html(data);
						$("#subject option[value='" + subject + "']").attr("selected", "selected");
					}
				}
			});
		}
		$('#room_no').on('change', function () {
			
			var room_no = $(this).val();
			//alert(academic_year);
			if (room_no) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>attendance/load_sem',
					data: {room_no:room_no,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#semester').html(html);
					}
				});
			} else {
				$('#semester').html('<option value="">Select course first</option>');
			}
		});
		//for edit sloat
		
		if (strem_id !='' && semesterid !='') {
			$.ajax({
				'url' : base_url + 'Attendance/load_division',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : strem_id,'semesterId':semesterid,academic_year:academic_year},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#division'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						var division1 = '<?=$division?>';
						//alert(subject);
						container.html(data);
						$("#division option[value='" + division1 + "']").attr("selected", "selected");
					}
				}
			});
		}*/
		var strem_id = '<?=$classId?>';
		var subject = '<?=$sub_details?>';
		//alert(subject);
		if (subject !='') {
			$.ajax({
				'url' : base_url + 'Attendance/load_slot',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'subject' : subject},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#slot_no'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						var slotid = '<?=$slot_no?>';
						//alert(subject);
						container.html(data);
						$("#slot_no option[value='" + slotid + "']").attr("selected", "selected");
					}
				}
			});
		}
	//Send SMS to Parents 
	$('#btnSMS').on('click', function () {
		//alert("hi");
			var absentStud = $("#absentStud").val();
			var sub_code = $("#sub_code").val();
			var today_date = $("#dt-datepicker").val();
			var slot = $("#slot").val();
			//alert(absentStud);alert(sub_code);alert(today_date);alert(slot);
			if (absentStud) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Attendance/sendAbsentSms',
					data: {absentStud:absentStud,sub_code:sub_code,today_date:today_date,slot:slot},
					success: function (data) {
						//alert(data);
						if(data!='SUCCESS'){							
							alert("SMS sent successfully.");
							
						}else{
							alert("Y");
						}
						
					}
				});
			} else {
				
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
function changeBackground(id){
	var trvalue = 'chk'+id;
	if($(".chk_stud"+id).prop("checked") == true){
		$("#"+trvalue).css({"background-color":"#FFF"});
	}
	else if($(".chk_stud"+id).prop("checked") == false){
		$("#"+trvalue).css({"background-color":"#FF7B77"});
	}
}
function getSloat(){		
		var subject = $("#subject").val();
		//var semesterid = $("#semester").val();
		//alert(course_id);
		if (subject !='') {
			$.ajax({
				'url' : base_url + 'Attendance/load_slot',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'subject' : subject},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#slot_no'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						//var subject = '<?=$sub_batch?>';
						//alert(subject);
						container.html(data);
						//$("#slot_no option[value='" + subject + "']").attr("selected", "selected");
					}
				}
			});
		}
}
	</script>
<script>	
$(document).ready(function() {
		$('#topic_no').on('change', function () {
			var topic_no = $(this).val();
			var subject_id = '<?=$subCode?>';
			if (topic_no) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Attendance/load_subtopics',
					data: {topic_no:topic_no,subject_id:subject_id},
					success: function (response) {
						//alert(response);
						$("#lsubtopic").html(response);
					
					}
					 
				});
			} else {
				$('#stopic_no').html('<option value="">Select Topic first</option>');
			}
		});
		//$('#stopic_no').multiselect('rebuild');
});
</script>	