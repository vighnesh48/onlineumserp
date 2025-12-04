<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<style>
.absent_bg{background:#ff9b9b;}
</style>
<?php
$role_id = $this->session->userdata('role_id');
$astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">View Attendance</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Lecture-Wise Attendance</h1>
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
                       <input type="hidden" value="<?=isset($empId) ? $empId : ''?>" id="empId" name="empId" />
                            <form id="form" name="form" action="<?=base_url($currentModule.'/search_date_wise_attendance')?>" method="POST">                                                            
                                <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />
								<!--input type="hidden" value="<?=isset($sb[0]['stream_id']) ? $sb[0]['stream_id'] : ''?>" id="stream_id" name="stream_id" -->
								<div class="form-group">   
								<label class="col-sm-2">Select Subject</label>								
								<div class="col-sm-3">
								
									<select id="subject" name="subject" class="form-control" onchange="getSloat()" required>
										<option value="">Select Subject</option>
										<?php 
										if($sub_Code !=''){
											$sub_Code = $sub_Code;
										}else{
											$sub_Code = $_REQUEST['subject'];
										}
										if(!empty($sb)){
											foreach($sb as $sub){
												$batchcode = $sub['subject_id'].'-'.$sub['division'].'-'.$sub['batch'].'-'.$sub['semester'].'-'.$sub['stream_id'];
												if ($batchcode == $sub_Code) {
													$sel = "selected";
												} else {
													$sel = '';
												}

												$divsion = $sub['division'];
												$batchno =$sub['batch'];
												$stream_short_name =$sub['stream_short_name'];
												if($sub['subject_id'] !='OFF'){
													if($batchno ==0){
														$batch = "";
													}else{
														$batch =$batchno;
													}
													if(empty($sub['sub_code'])){
														$subjetcode=$sub['subject_id'];
													}else{
														$subjetcode=$sub['sub_code'];
													}
													echo '<option value="'.$sub['subject_id'].'-'.$sub['division'].'-'.$sub['batch'].'-'.$sub['semester'].'-'.$sub['stream_id'].'"' . $sel . '>'.$sub['subject_short_name'].'('.$subjetcode.')-'.$divsion.''.$batch.' ('.$stream_short_name.')</option>';
												}
											}
										}
										?>									
									</select>											
								</div> 
								<div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
								<div class="col-sm-5"></div>
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
                            <span class="panel-title" id="stdname">Attendance : 
							<?php 
							
							if($divbatch !=0){
								$batchto = ', Batch: '.$divbatch;
							}else{
								$batchto = "";
							}
							if($divbatch !=''){
							echo $streamName[0]['stream_name'].", Semester : ".$semesterNo.", Division : ".$division.' '.$batchto; 
							}
							?>
							</span>
                    </div>
                    <div class="panel-body">
						
                        <div class="table-info">  
							<table class="table table-bordered">
							<thead>
								<tr>
									
									<th>Sr</th>
									<th>Date</th>
									<th>Slot</th>
									<th>P</th>
									<th>A</th>
									<th>T</th>
									<th>Action</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
								//echo "<pre>";
								//print_r($attCnt);

								$i=1;
									if(!empty($attCnt)){
										foreach($attCnt as $att){
											$attendance_date = date("d-m-Y", strtotime($att['attendance_date']) );
											$slottime = $att['from_time'].'-'.$att['to_time'].'-'.$att['slot_am_pm'];
								?>
									<tr>
										
										<td><?=$i?></td>
										<td><?=$attendance_date?></td>
										<td><?=$att['from_time']?> - <?=$att['to_time']?></td>
										<td><?=$att['P_attCnt'][0]['present']?></td>
										<td><?=$att['A_attCnt'][0]['absent']?></td>
										<td><?=($att['P_attCnt'][0]['present'] + $att['A_attCnt'][0]['absent'])?></td>
										<td><a class="viewatt" id="user_<?=$i?>" data-attdate="<?= $att['attendance_date']; ?>" data-sem="<?= $semesterNo; ?>" data-attsubid="<?=$subId?>" data-attslot="<?=$att['slot']?>" data-displaydate="<?=$attendance_date?>"  data-attdiv="<?=$division?>" data-attbatch="<?=$divbatch?>" data-displayslot="<?=$slottime?>" data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button type="button" class="btn btn-primary btn-xs">View</button></a><?php 
										//if($role_id==21){
										?> | <!--a href="<?=base_url($currentModule."/DeleteAttendanceEntry/".$att['attendance_date'].'/'.$att['slot'].'/'.$sub_Code)?>" class="tt" onclick="return confirm('Are you sure to delete this Attendance Records?');"><button type="button" class="btn btn-primary btn-xs">Delete</button></a-->
										<?php// }?>
									</td>										
									</tr>
								<?php 
								//}
										$i++;
										}
									}else{
										echo "<tr><td colspan=7>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table>
							
						</div>
                    </div>
                </div>
			</div>
			<!--/form-->
			  
			<div class="col-sm-6">
				
				<div class="panel" id="att_details" style="display:none">
                    <div class="panel-heading">
                            <span class="panel-title">Attendance details: <span id="displaydate"></span> <span id="displayslot"></span></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">  
							<table class="table table-bordered" id="">
							<thead>
								<tr>
									<th>Roll No.</th>
									<th>PRN No.</th>
									<th>Student Name</th>
									<th>Mobile</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody id="studAtt">
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
$(document).ready(function() {
	$(".viewatt").each(function () {
		
		$(document).on("click", '#' + this.id, function () {
			$('#att_details').css("display","block");
			var att_date = $('#' + this.id).attr("data-attdate");
			var sub_id = $('#' + this.id).attr("data-attsubid");
			var slot = $('#' + this.id).attr("data-attslot");
			var displaydate = $('#' + this.id).attr("data-displaydate");
			var displayslot = $('#' + this.id).attr("data-displayslot");
			var sem = $('#' + this.id).attr("data-sem");
			var div = $('#' + this.id).attr("data-attdiv");
			var batch = $('#' + this.id).attr("data-attbatch");
			$('#displaydate').html("<b>Date</b> "+displaydate+',');
			$('#displayslot').html("<b>Slot</b> "+displayslot);
			var empId = $("#empId").val();
		    //alert(att_date);alert(sub_id);alert(slot);
			$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Attendance/fetchDateSlotwiseAttDetails',
					data: {att_date:att_date,sub_id:sub_id,slot:slot,empId:empId,sem:sem,div:div,batch:batch},
					success: function (data) {
						//alert(data);
						if(data!='dupyes'){
							var absent=JSON.parse(data);
							var list_of_absent = absent.ss.length;

							var str="";
							for(i=0;i< list_of_absent;i++)
							{
								var is_present = absent.ss[i].is_present;
								if(is_present=='N'){
									var cls = "style='background-color: rgb(255, 123, 119);'";
									var status_p = 'A';
								}else{
									cls='';
									var status_p = 'P';
								}
								//alert("inside");
								//alert(absent.ss[i].enrollment_no);
								str+='<tr '+cls+'>';
								
								str+='<td>'+absent.ss[i].roll_no+'</td>';   
								str+='<td>'+absent.ss[i].enrollment_no+'</td>';
								str+='<td>'+absent.ss[i].first_name+' '+absent.ss[i].middle_name+' '+absent.ss[i].last_name+'</td>';
								str+='<td>'+absent.ss[i].mobile+'</td>';
								str+='<td>'+status_p+'</td>';
								$("#studAtt").html(str);
							}
							//alert("Refresh.");
						}else{
							alert("No data found");
						}
						
					}
				});
		});
	});
});
</script>
