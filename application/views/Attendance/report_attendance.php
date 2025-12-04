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
		var course_id = $("#room_no").val();
		//alert(course_id);
		if (course_id) {
			$.ajax({
				'url' : base_url + '/Attendance/load_sem',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : course_id},
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
		$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',startDate: new Date() ,endDate: '+0d',autoclose: true});
		$('#dt-datepicker2').datepicker( {format: 'yyyy-mm-dd',startDate: new Date() ,endDate: '+0d',autoclose: true});
    });

</script>
<style>
.absent_bg{background:#ff9b9b;}
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Report</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; My Attendance Report</h1>
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
			<!--form id="form" name="form" action="<?=base_url($currentModule.'/markAttendance')?>" method="POST"-->    
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname">Filter by Dates : 
							<div style="float:right;margin-top:-5px !important; margin-right: 325px;">
							<form method="post" name="search_form" action="<?=base_url()?>attendance/report">
								<div class="col-sm-3"><input type="text" class="form-control" name="from_date" placeholder="From Date" id="dt-datepicker1" value="<?=$_REQUEST['from_date']?>" required></div>
								<div class="col-sm-3"><input type="text" class="form-control" name="to_date" id="dt-datepicker2" placeholder="To Date" value="<?=$_REQUEST['to_date']?>"  required></div>
								<div class="col-sm-3"><input type="submit" name="submit" value="Search" onClick="return ValidateEndDate()" class="btn btn-primary"></div>
							</form>
							</div>
							<?php 
							/*if($batch !=0){
								$batch_to = $batch;
							}else{
								$batch_to = "";
							}
							if(!empty($subdetails)){
								echo $subdetails[0]['subject_short_name'].'('.$subdetails[0]['subject_code'].')-'.$division.''.$batch_to;
							}*/
							?>
							</span>
                    </div>
                    <div class="panel-body">
						<div class="col-sm-12">
                        <div class="table-info table-responsive">  
							<div class=""> 
								<input type="hidden" name="sub_code" id="sub_code" value="<?=$subCode?>">
								<input type="hidden" name="classa" id="classa" value="<?=$classa?>">
								<input type="hidden" name="division" id="division" value="<?=$division?>">
								<input type="hidden" name="batch" id="batch" value="<?=$batch?>">
								<input type="hidden" name="sem" id="sem" value="<?=$semesterNo?>">	
								<input type="hidden" name="slot" id="slot" value="<?=$slot_no?>">
																
							</div>
							<table class="table table-bordered">
							<thead>
								<tr>	
									<th>S.No</th>
									<th>Stream Name</th>
									<th>Sem</th>
									<th>Course Name (Code)</th>
									<th>Div</th>
									<th>Batch</th>
									<th>Faculty</th>
									<th>#Of Lecture</th>
									<th>% Of Present</th>
									<th>Lecture View</th>
									<th>Student View</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
								//echo "<pre>";
								//print_r($subject);
								$subjectname ="";
								$i=1;
									if(!empty($subject)){
										for($p=0; $p<count($subject);$p++){
									
											//for($q=0; $q< count($subject[$p]['cntLect']); $q++){
												
												$cntLect = count($subject[$p]['cntLect']);
												$totStudCnt = $cntLect * $subject[$p]['cntLect'][0]['studCNT'];
												$LectPreStudCnt = $subject[$p]['AvgLectPer'][0]['totPersent'];

												$AvgLectPer = ($LectPreStudCnt / $totStudCnt) * 100;
												
												$division = $subject[$p]['division'];
												$batch1 = $subject[$p]['batch_no'];
												if($batch1 !=0){
													$batch = $batch1;
												}else{
													$batch = '-';
												}
												$sub_code = $subject[$p]['sub_id'].'-'.$subject[$p]['division'].'-'.$subject[$p]['batch_no'].'-'.$subject[$p]['semester'].'-'.$subject[$p]['stream_id']; 
												$prev_subjectname = $subject[$p]['subject_name']." (".$subject[$p]['sub_code'].")";
												//}
												?>
													<tr>
														<td><?=$i?></td>
														<td><?=$subject[$p]['stream_short_name']?></td>
														<td><?=$subject[$p]['semester']?></td>
														<td><?=$prev_subjectname?></td>
														<td><?=$division?></td>
														<td><?=$batch;?></td>
														<td><?=strtoupper($subject[$p]['fname'][0].'. '.$subject[$p]['mname'][0].'. '.$subject[$p]['lname']);?></td>
														<td><?=$cntLect;?></td>
														<td><?=round($AvgLectPer, 2);?>%</td>
														<td><a href="<?=base_url($currentModule.'/search_date_wise_attendance/'.$sub_code)?>" target="_blank">View</a></td>
														<td><a href="<?=base_url($currentModule.'/studentAttendenceReport/'.$sub_code)?>" target="_blank">View</a></td>
													</tr>
															<?php 
												//}
												$i++;
														//}
														
														
														}
													}else{
														echo "<tr><td colspan=6>No data found.</td></tr>";
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
<script>
$(document).ready(function () {
	$('#chk_stud_all').change(function () {
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
			var classa= $("#classa").val(); 
			var division = $("#division").val();
			var sem = $("#sem").val();
			var streamId = $("#stream").val();
			var today_date = $("#dt-datepicker").val();
			var slot = $("#slot").val();
			//alert(sem);
			var chk_checked = [];
            $.each($("input[name='chk_stud[]']:checked"), function(){            
                chk_checked.push($(this).val());
            });
			if (chk_stud) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Attendance/markAttendance',
					data: {chk_stud:chk_checked,sub_code:sub_code,batch:batch,division:division,today_date:today_date,sem:sem,slot:slot,stream:streamId,classa:classa},
					success: function (data) {
						//alert(data);
						if(data!='dupyes'){
							var absent=JSON.parse(data);
							//alert(absent.ss);
							var list_of_absent = absent.ss.length;
							//console.log(absent.cnt_absent);
							//alert(absent.cnt_present);
							
							var total_present = absent.cnt_present;
							var total_absent = absent.cnt_absent;
							var total = absent.allcnt;
							//alert(total);alert(total_present);alert(total_absent);
							$("#tot").html(total);
							$("#per").html(total_present);	
							$("#absent").html(total_absent);
							
							var str="";
							for(i=0;i< list_of_absent;i++)
							{
								//alert("inside");
								//alert(absent.ss[i].enrollment_no);
								str+='<tr>';
								
								str+='<td>'+(i+1)+'</td>';   
								str+='<td>'+absent.ss[i].enrollment_no+'</td>';
								str+='<td>'+absent.ss[i].first_name+' '+absent.ss[i].middle_name+' '+absent.ss[i].last_name+'</td>';
								str+='<td>'+absent.ss[i].parent_mobile2+'</td>';
								str+='<td>'+absent.ss[i].subscribe_for_sms+'</td>';
								$("#allocatestudent").html(str);
							}
							alert("Attendance marked successfully.");
						}else{
							alert("You have already taken this batch attendance");
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
				'data' : {'room_no' : room_no,'semesterId':semesterId,'division':divs},
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
		
		//edit subject
		var classid = $("#room_no").val();
		var semesterid = '<?=$semesterNo ?>';
		var division = '<?=$division?>';
		//alert(course_id);
		if (classid) {
			$.ajax({
				'url' : base_url + '/Attendance/load_subject',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : classid,'semesterId':semesterid,'division':division},
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
			if (room_no) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>attendance/load_sem',
					data: 'room_no=' + room_no,
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
		var strem_id = '<?=$classId?>';
		var semesterid = '<?=$semesterNo?>';
		//alert(course_id);
		if (strem_id !='' && semesterid !='') {
			$.ajax({
				'url' : base_url + '/Attendance/load_slot',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : strem_id,'semesterId':semesterid},
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
		if (strem_id !='' && semesterid !='') {
			$.ajax({
				'url' : base_url + '/Attendance/load_division',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : strem_id,'semesterId':semesterid},
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
		}
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
		var strem_id = $("#room_no").val();
		var semesterid = $("#semester").val();
		//alert(course_id);
		if (strem_id !='' && semesterid !='') {
			$.ajax({
				'url' : base_url + '/Attendance/load_slot',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : strem_id,'semesterId':semesterid},
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
function ValidateEndDate() {
       var startDate = $("#dt-datepicker1").val();
       var endDate = $("#dt-datepicker2").val();
	   //alert(startDate); alert(endDate);
       if (startDate != '' && endDate !='') {
           if (Date.parse(startDate) > Date.parse(endDate)) {
               $("#dt-datepicker2").val('');
			   $("#dt-datepicker2").focus();
               alert("Start date should not be greater than end date");
			   return false;
           }
       }
       return true;
   }
	</script>