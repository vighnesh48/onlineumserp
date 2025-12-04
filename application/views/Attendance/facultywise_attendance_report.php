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

		$('#dt-datepicker').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
    });

</script>
<style>
.table {
    width: 100%;
max-width: 100%;
}
.table-warning thead{border-color: #de9328 !important;
color: #fff!important;}
.table-warning thead tr {
    background: #e9a23b !important;
}
</style>
<?php
//echo $academic_year;
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
	$first_day_of_the_week = 'Monday';
	$start_of_the_week     = strtotime("Last $first_day_of_the_week");
	if ( strtolower(date('l')) === strtolower($first_day_of_the_week) )
	{
		$start_of_the_week = strtotime('today');
	}
	$end_of_the_week = $start_of_the_week + (60 * 60 * 24 * 7) - 1;
	$date_format =  'Y-m-d';
	$start_date = date($date_format, $start_of_the_week);
// This prints out Saturday 13th of December 2014 11:59:59 PM
	$end_date =date($date_format, $end_of_the_week);
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Load Report</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Facultywise Load Report</h1>
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
                            <span class="panel-title">Select Following Parameters</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/facultywise')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />
								<div class="form-group">
								<div class="col-sm-2" >
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Academic year</option>
                                  <?php
									foreach ($all_session as $acd_sess) {
										$acd_ses = $acd_sess['academic_year'].'~'.$acd_sess['academic_session'];
										if ($acd_ses == $academic_year) {
											$sel1 = "selected";
										} else {
											$sel1 = '';
										}
										echo '<option value="'.$acd_ses.'"' . $sel1 . '>' . $acd_sess['academic_year'].' ('.$acd_sess['academic_session'].')</option>';
									}
									?>
                               </select>
                              </div> 
								<div class="col-sm-2" >
                                <select name="school_id" id="school_id" class="form-control" required>
                                  <option value="">Select School</option>
                                  <?php
									foreach ($schools as $schl) {
										if ($schl['emp_school'] == $school_id) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $schl['emp_school'] . '"' . $sel . '>' . $schl['college_code'] . '</option>';
									}
									?>
                               </select>
                              </div> 
                              <div class="col-sm-2" id="semest" >
                                <select name="department_id" id="department_id" class="form-control" required>
                                  <option value="">Select Department</option>
                               </select>
                              </div>

                              <div class="col-sm-2" >
                               <input type="text" class="form-control" name="from_date" id="dt-datepicker1" value="<?php if(!empty($from_date)){ echo $from_date;}else{ echo $start_date;}?>" placeholder="From Date">
                              </div> 
                              <div class="col-sm-2" >
                                <input type="text" class="form-control" name="to_date" id="dt-datepicker2" value="<?php if(!empty($to_date)){ echo $to_date;}else{ echo $end_date;}?>" placeholder="To Date">
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
			<!--form id="form" name="form" action="<?=base_url($currentModule.'/markAttendance')?>" method="POST"-->    
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname">Report Details : 
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
						<div class="col-sm-12">
						
                        <div class="table-info12 table-responsive">  
							
							<table class="table table-bordered">
							<thead style="background: #3da1bf !important;border-top-color: #3da1bf !important;color: #fff;border-color: #e2e2e2;">
								<tr>	
									<th>S.No</th>
									<th>Staff Id</th>
									<th>Staff Name</th>
									<th>Department </th>
									<th>Designation</th>
									<!--th>Load(Norms)</th-->
									<th>Lect.Load Allocated</th>
									<th>Excepted Lect.Load</th>
									<th>Lect. taken</th>
									<th>ATT(%)</th>
									<th>View</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
								$CI =& get_instance();
								$CI->load->model('Attendance_model');
								//echo "<pre>";
								//($attendance_data);
								$i=1;
									if(!empty($attendance_data)){
										foreach ($attendance_data as $key => $att) {	
											$lect_tkn_load =$this->Attendance_model->fetch_fac_taken_lect_load($att['faculty_code'], $academic_year, $from_date,$to_date);
											$faculty = $att['faculty_code'];	
										//print_r($att['leaves']);
												?>
													<tr>
														<td><?=$i?></td>
														<td><?=$att['faculty_code']?></td>
														<td><?=strtoupper($att['fname'].'. '.$att['mname'][0].'. '.$att['lname']);?></td>
														<td><?=$att['department_name']?></td>
														<td><?=$att['designation_name']?></td>
														<!--td><?php 
															if($att['designation_name']=='Assistant Professor'){
																echo $load_noms ='18';
															}elseif($att['designation_name']=='Associate Professor'){
																echo $load_noms ='16';
															}
															elseif($att['designation_name']=='Professor'){
																echo $load_noms ='14';
															}
															elseif($att['designation_name']=='Dean'){
																echo $load_noms ='01';
															}else{
																echo $load_noms ='';
															}
														?></td-->
														<td><?php if(!empty($att['tot_lecture_load'])){ echo $att['cnt_slot'];}else{ echo "-";}?></td>
														<td><?php if(!empty($att['tot_lecture_load'])){ echo $att['cnt_slot']-$att['leaves'];}else{ echo "-";}?></td>
														<td><?php if(!empty($lect_tkn_load[0]['taken_lect_load'])){ echo $lect_tkn_load[0]['lecttaken'];}else{ echo "-";}?></td>	
														<td><?=number_format($att['att_percentage'], 2, '.', '');?></td>
														<td><input type="button" id="<?=$att['faculty_code']?>" class="btn btn-info" onclick="toggle_details(this.id);" value="+"></td>
													</tr>
													<tr>
													<td colspan=10  id="details_<?=$att['faculty_code']?>" style="display:none">
													
														<table class="table table-bordered" >
														
							<thead>
								<tr style="background:#e9a23b !important">	
									<th>Stream Name</th>
									<th>Sem</th>
									<th>Subject Name</th>
									<th>Type</th>
									<th>Div</th>
									<th>Batch</th>
									<th>#Allocated(Hrs)</th>
									<th>#Lect. Taken(Hrs)</th>
									<th>#Students</th>
									<th>ATT(%)</th>
									<th>Details</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
								//echo "<pre>";
								//print_r($att['subject']);
								$subjectname ="";
								
									if(!empty($att['subject'])){
										for($p=0; $p<count($att['subject']);$p++){
									
											//for($q=0; $q< count($subject[$p]['cntLect']); $q++){
												$cntstudesnts = count($att['subject'][$p]['cntStud']);
												$cntLect = $att['subject'][$p]['cntLect'][0]['cnt_of_lect'];
												$lect_taken = $att['subject'][$p]['cntLect'][0]['no_of_lect_taken'];
												$totStudCnt = $cntLect * $att['subject'][$p]['cntLect'][0]['studCNT'];
												$LectPreStudCnt = $att['subject'][$p]['AvgLectPer'][0]['totPersent'];

												$AvgLectPer = ($LectPreStudCnt / $totStudCnt) * 100;
												
												$division = $att['subject'][$p]['division'];
												$stream_name = $att['subject'][$p]['stream_short_name'];
												$semester = $att['subject'][$p]['semester'];
												$batch1 = $att['subject'][$p]['batch_no'];
												$subject_component = $att['subject'][$p]['subject_component'];
												if($subject_component =='TH' || $subject_component=='EM'){
													$subtype = 'Theory';
												}else{
													$subtype = 'Practical';
												}
												if($batch1 !=0){
													$batch = $batch1;
												}else{
													$batch = '-';
												}
												$sub_code = $att['subject'][$p]['sub_id'].'-'.$att['subject'][$p]['division'].'-'.$att['subject'][$p]['batch_no'].'-'.$att['subject'][$p]['semester'].'-'.$att['subject'][$p]['stream_id']; 
												if(!empty($att['subject'][$p]['subject_name'])){
													$subjectname = $att['subject'][$p]['subject_name']." (".$att['subject'][$p]['sub_code'].")";
												}else{
													$subjectname = $att['subject'][$p]['subject_code'];
												}
												$arr_tot[]= $att['subject'][$p]['lect_load'];
												$arr_slt[]= $att['subject'][$p]['slotcnt'];
												$arr_lt[] = $cntLect;
												$arr_lect_taken[] = $lect_taken;
												//}
												?>
													<tr>
														<td><?=$stream_name?></td>
														<td><?=$semester?></td>
														<td><?=$subjectname?></td>
														<td><?=$subtype?></td>
														<td><?=$division?></td>
														<td><?=$batch;?></td>
														<td><?php if(!empty($att['subject'][$p]['lect_load'])){ echo $att['subject'][$p]['slotcnt']."(".$att['subject'][$p]['lect_load'].")";}else{echo "-";}?></td>
														<td><?if(!empty($lect_taken)){ echo $cntLect.'('.$lect_taken.')';}else{ echo "-";};?></td>
														<td><?=$cntstudesnts;?></td>
														<td><?=round($AvgLectPer, 2);?></td>
														<td><a href="<?=base_url('Attendance/search_date_wise_attendance/'.$sub_code.'/'.$faculty)?>" target="_blank"><button class="btn btn-success">View</button></a></td>
														
													</tr>
															<?php 
												//}
												
														//}
														unset($cntstudesnts);
														
														}
														?>
														<tr><td colspan=6>Total</td>
														<td><?=array_sum($arr_slt);?>(<?=array_sum($arr_tot);?>)</td>
														<td colspan=4><?=array_sum($arr_lt);?>(<?=array_sum($arr_lect_taken);?>)</td></tr>
														<?php
														unset($arr_tot);unset($arr_slt);unset($arr_lt);unset($arr_lect_taken);
													}else{
														echo "<tr><td colspan=6>No data found.</td></tr>";
													}
												?>
								</tbody>
							</table>
														</td>
													</tr>
															<?php 
															$i++;
															unset($totload[0]['tot_lect_load']);
												}
												
													}else{
														echo "<tr><td colspan=9>No data found.</td></tr>";
													}
												?>
								</tbody>
							</table>
							<a href="<?=base_url()?>Attendance_reports/load_export_excel/<?=$academic_year?>/<?=$department_id?>/<?=$school_id?>/<?=$from_date?>/<?=$to_date?>/"><button class="btn btn-info">Excel</button></a>
						</div>
                    </div>
                </div>
			</div>
			<!--/form-->		
		</div>
			
    </div>
</div>
<script>
	function toggle_details(id){
		var acc = $("#"+id).val();
		$("#details_"+id).toggle( "slow", function() {
			});
			if(acc=='+'){
				$("#"+id).val('-');
			}else{
				$("#"+id).val('+');
			}
		
	}
$(document).ready(function () {
		$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
		$('#dt-datepicker2').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
	
		$('#school_id').on('change', function () {	
		//alert('inside');		
			var school_id = $(this).val();
			if (school_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Attendance_reports/load_departments',
					data: 'school_id=' + school_id,
					success: function (html) {
						//alert(html);
						$('#department_id').html(html);
					}
				});
			} else {
				$('#department_id').html('<option value="">Select course first</option>');
			}
		});
		// edit stream
		var school_id = '<?=$school_id?>';
		//alert(school_id);
			if (school_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Attendance_reports/load_departments',
					data: 'school_id=' + school_id,
					success: function (html) {
						//alert(html);
						var department_id = '<?=$department_id?>';
						//alert(subject);
						$('#department_id').html(html);
						$("#department_id option[value='" + department_id + "']").attr("selected", "selected");
						
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		
  });
</script>