<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
		$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
		$('#dt-datepicker2').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
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
            <h1 class="col-xs-12 col-sm-8 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; CIA Marks and Attendance Percentage</h1>
            <div class="col-xs-12 col-sm-4">
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
                            <span class="panel-title" id="stdname">Faculty Subject List : (<small style="color:red">Marks submission end on <b><?php echo date('d/m/Y H:i:s', strtotime($Marks_submission_date[0]['date_end'])) ?></b>  </small>)
							<?php 
							$start_date=date('Y-m-d', strtotime($Marks_submission_date[0]['date_start']));
							$end_date=date('Y-m-d', strtotime($Marks_submission_date[0]['date_end']));
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
						<div class="col-sm-12">
                        <div class="table-info">  
							<div class=""> 
																	
							</div>
							<table class="table table-bordered">
							<thead>
								<tr>	
									<th>S.No</th>
									<th>Stream Name</th>
									<th>Course Name</th>
									<th>Division</th>
									<th>Batch</th>
									<th>Semester</th>
									<th>Credits</th>
									<th>Action</th>
									<!--th>Entry On</th>
                                    <th>Veryfy On</th>
                                    <th>Approved On</th>
                                    <th>Status</th-->
									<th>Download</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								$fac_id= $this->session->userdata('name');
								$CI =& get_instance();
								$CI->load->model('Phd_marks_model');
								$today = date('Y-m-d');
								//$today ='2019-05-13';
								//echo "<pre>";
								//print_r($subject);
								$subjectname ="";
								$exam_month = $exam_session[0]['exam_month'];
								$exam_year = $exam_session[0]['exam_year'];
								$i=1;
									if(!empty($subject)){
										
										for($p=0; $p<count($subject);$p++){
									
											for($q=0; $q< count($subject[$p]['batches']); $q++){
												
												
												$division = $subject[$p]['batches'][$q]['division'];//exit;
												$batch1 = $subject[$p]['batches'][$q]['batch'];
												$subbthDetails = 'stm-'.$division.'-'.$batch1;
												$meid_detailes =$this->Phd_marks_model->fetchDivBatchEntryDetails($subject[$p]['sub_id'], $subject[$p]['stream_id'], $subject[$p]['semester'], $division, $batch1, $exam_month, $exam_year);

												if($batch1 !=0){
													$batch = $batch1;
												}else{
													$batch = '-';
												}
												
												?>
													<tr>
														<td><?=$i?></td>
														<td><?=$subject[$p]['stream_short_name']?></td>
														<td><?=$subject[$p]['batch']?>-<?=$subject[$p]['sub_code']?> - <?=$subject[$p]['subject_name']?></td>
														<td><?=$division?></td>
														<td><?=$batch;?></td>
														<td><?=$subject[$p]['semester'];?></td>
														<td><?=$subject[$p]['credits']?></td>
														<td>
								
                                    <?php 
									$exam= $exam_session[0]['exam_month'].'-'.$exam_session[0]['exam_year'].'-'.$exam_session[0]['exam_id'];
									$marks_type='CIA';
									$sub_details = $subject[$p]['sub_id'].'~1~2~'.$subject[$p]['stream_id'].'~'.$subject[$p]['semester'].'~'.$exam.'~'.$marks_type.'~'.$subbthDetails;
									//echo $tdatae=date('2019-11-24');
									//if($subject[$p]['internal_max'] !='0' || $subject[$p]['internal_max'] !='0') {
									if($today >= $start_date && $today <= $end_date){
									//if($fac_id == '210197' || $fac_id == '110363' || $fac_id == '210224' ){
									if($meid_detailes[0]['me_id'] =='') {	
									
									?>
                                    <a href="<?=base_url($currentModule."/ciamarksdetails/".base64_encode($sub_details))?>" target="_blank">Add</a>
									<?php 
										
										}else{ ?>
									
									<a href="<?=base_url($currentModule."/editCIAMarksDetails/".base64_encode($sub_details).'/'.base64_encode($meid_detailes[0]['me_id']))?>" target="_blank">Edit</a> 
									
									<?php }
									}else{ echo '<small style="color:red">Submission end</small>';//echo 'On '.$end_date;
									}
									/*}else{ 
										echo "<small>Check Sub. Internal Max Marks.</small>";
									}*/									
									?>
                                   
                               
								</td> 
								<!--td>
								<?php
									if($meid_detailes[0]['entry_on'] !=''){
										echo date('d/m/Y H:i:s', strtotime($meid_detailes[0]['entry_on']));
									}else{
										echo "";
									}
								?>
								</td> 
								<td>
									<?php
									if($meid_detailes[0]['verified_on'] !=''){
										echo date('d/m/Y H:i:s', strtotime($meid_detailes[0]['verified_on']));
									}else{
										echo "";
									}
								?>
								</td> 
								<td>
									<?php
									if($meid_detailes[0]['approved_on'] !=''){
										echo date('d/m/Y H:i:s', strtotime($meid_detailes[0]['approved_on']));
									}else{
										echo "";
									}
								?>
								</td> 
                                <td>
								<?php
									if($meid_detailes[0]['entry_status'] !=''){
										echo $meid_detailes[0]['entry_status'];
									}else{
										echo "Not Entered";
									}
								?>
								</td-->  
								<td>
									<?php
									if($meid_detailes[0]['me_id'] !='') {	 
									?>
                                    <a href="<?=base_url($currentModule."/downloadCIApdf/".base64_encode($sub_details).'/'.base64_encode($meid_detailes[0]['me_id']))?>"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i></a>
									<?php } ?>
								</td>				
													</tr>
															<?php 
												//}
												$i++;
														}
														
														
														}
													}else{
														echo "<tr><td colspan=6>No data found.</td></tr>";
													}
												?>
								</tbody>
							</table>
							<div>
								<ul> <i>Note:-</i>
									<!--li> Enter the maximum marks of CIA in to the <b>Max Marks</b> column.</li-->
									<li> Please enter the CIA marks in between <b>0 to Max Marks</b> and Attendance percentage between <b>80</b> to <b>100 only</b>.</li>
									<li> For Absent entries of CIA or Attendance, Please enter <b>AB</b> (Capital AB).</li>
									<li> Enter the Date as  Submission date.</li>
									<li> For any corrections of marks Click on  <b>Update</b> button for saving changes.</li>
									<li> For submission of Mark-sheet to the Dean/HOD Dept Click on <b>Forward to Dean/HOD </b>button. After this <b>PDF download </b>option will be available.</li>
									<li> No any updation are allowed after submission of marks to the Dean/HOD Dept</li>
								</ul>
								
							</div>
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