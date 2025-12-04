
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<script>    
$(document).ready(function()
{
	var exam_type = '<?=$exam[0]['exam_type']?>';
	if(exam_type=='Regular'){
	var totfees = parseInt('<?=$examfees[0]['exam_fees']?>');
	 //alert(totfees);
	  $('#total_fees').html("Total fees to be paid: "+totfees);
	  $('#applicable_fee').val(totfees);
	}

	$('#dddate').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
});
$('.numbersOnly').keyup(function () {
if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
   this.value = this.value.replace(/[^0-9\.]/g, '');
}
});
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Examination</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Examination Form</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
		  <div class="row ">
			<form id="form" name="form" action="<?php echo base_url($currentModule . '/add_exam_form') ?>" method="POST">    

			<div class="col-sm-12">
				<div class="panel">
                    
                    <div class="panel-body">
					<div class="col-sm-12">
						<div class="panel">
						<div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">Personal Details</span>
						</div>
					
                        
						<table class="table table-bordered">
    					<tr>
    					  <th width="12%">PRN No :</th>
						  <td width="38%"><?php echo $emp[0]['enrollment_no'] ?></td>
						  <th width="12%">Exam Name :</th>
						  <td width="38%" ><?php echo $exam[0]['exam_month'] ?>-<?php echo $exam[0]['exam_year'] ?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name :</th>
						  <td><?php echo $emp[0]['last_name'] ?> <?php echo $emp[0]['first_name'] ?> <?php echo $emp[0]['middle_name'] ?></td>
						   <th width="">DOB:</th>
						   <td><?php echo $emp[0]['dob'] ?> </td>
						</tr>
						<tr>
    					  <th scope="col">Course Name :</th>
						  <td><?php echo $emp[0]['stream_name'] ?></td>
						   <th width="">School :</th>
						   <td><?php echo $emp[0]['school_code'] ?>-<?php echo $emp[0]['school_name'] ?></td>
    					</tr>

						</table>
						</div>
						</div>
						<?php	if(!empty($sublist)){ ?>
						<div class="col-sm-12">
						<?php	if($exam[0]['exam_type']=='Regular'){ ?>
						<div class="col-sm-6">	
						<div class="panel">
						<div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">Subject Appearing</span>
						</div>
							<table class="table table-bordered">
							<thead>
								<tr>
								    <th>#</th>
									<th>Sr.No</th>
									<th>Course Code/Name</th>
									<th>Sem</th>
									
								</tr>
							</thead>
							<tbody>
							<input type="hidden" name="exam_details" value="<?php echo $exam[0]['exam_id'] ?>~<?php echo $exam[0]['exam_month'] ?>~<?php echo $exam[0]['exam_year'] ?>~<?php echo $exam[0]['exam_type'] ?>">
							<input type="hidden" name="stream_id" value="<?php echo $emp[0]['admission_stream'] ?>">
							<input type="hidden" name="semester" value="<?php echo $emp[0]['current_semester'] ?>">
							<input type="hidden" name="student_id" value="<?php echo $emp[0]['stud_id'] ?>">
							<input type="hidden" name="enrollment_no" value="<?php echo $emp[0]['enrollment_no'] ?>">
							<input type="hidden" name="school_code" value="<?php echo $emp[0]['school_code'] ?>">
							<input type="hidden" name="course_id" value="<?php echo $emp[0]['course_id'] ?>">
								<?php
								$i = 1;
								if(!empty($sublist)){
										foreach($sublist as $appsub){
											$sub_app_id[]= $appsub['sub_id']; 
										}
								}
								if (!empty($sublist))
									{
										
									$allsubjects1 = array_merge($sublist, $semsublist);
									$allsubjects = array_unique($allsubjects1, SORT_REGULAR);
									foreach($allsubjects as $sub)
										{
											if (in_array($sub['sub_id'], $sub_app_id)){
												$applied = "checked='checked'";
												
											}else{
												$applied = "";
											}
								?>
								<tr>
									<td><input type="checkbox" name="sub1[]" value="<?php echo $sub['sub_id'] ?>~<?php echo $sub['subject_code'] ?>~<?php echo $sub['semester'] ?>" <?=$applied?>></td>
									<td><?php echo $i; ?> &nbsp; &nbsp;</td>
									<td><?php echo $sub['subject_code'].' - '.$sub['subject_name']; ?></td>
									<td><?php echo $sub['semester'] ?></td>
									
									
								</tr>
								<?php
										$i++;
										}?>

								<tr>
									<td colspan="4"><!-- <span>Total No. of courses Registered: <b><?=count($sublist)?></b></span> --><span class="pull-right">Fee to be Paid: <b><?=$examfees[0]['exam_fees']?></b></span> </td>
									
									
								</tr>
									<?php }
								  else
									{
									echo "<tr><td colspan=4 style='color:red'>The Subjects are not allocated. Please contact to school Dean.</td></tr>";
									}

								?>

								</tbody>
							</table>
							</div>
						</div>
	
					<div class="col-sm-6">	
						<div class="panel">
						<div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">BACKLOG</span>
						</div>
							<table class="table table-bordered">
							<thead>
								<tr>
								    <th>#</th>
									<th>Sr.No</th>
									<th>Course Code/Name</th>
									<th>Sem</th>
									
								</tr>
							</thead>
							<tbody>
							<input type="hidden" name="exam_details" value="<?php echo $exam[0]['exam_id'] ?>~<?php echo $exam[0]['exam_month'] ?>~<?php echo $exam[0]['exam_year'] ?>~<?php echo $exam[0]['exam_type'] ?>">
								<?php
								$k = 1;

									$bksubcnt =count($backlogsublist);
									$fin_bksubcnt = count($allsubjects) - $bksubcnt;
									$fin_bksubcnt = $fin_bksubcnt +$bksubcnt; 

									for($i=0; $i< $fin_bksubcnt; $i++)
									//foreach($backlogsublist as $bksub)
									{
										if(empty($backlogsublist[$i]['subject_code'])) {
											$disabled ="disabled='disabled'";
										}else{
											$disabled ="";
										}
								?>
								<tr>
									<td><input type="checkbox" name="sub[]" value="<?php echo $backlogsublist[$i]['sub_id'] ?>~<?php echo $backlogsublist[$i]['subject_code'] ?>~<?php echo $backlogsublist[$i]['semester'] ?>" <?=$disabled?> onclick="CheckSubjectCNT()"> 
									</td>
									<td><?php echo $k; ?> &nbsp; &nbsp;</td>
									<td><?php if(!empty($backlogsublist[$i]['subject_code'])) { echo $backlogsublist[$i]['subject_code'].' - '.$backlogsublist[$i]['subject_name']; }?></td>
									<td><?php echo $backlogsublist[$i]['semester'] ?></td>
									
									
								</tr>
								<?php
										$k++;
										}
								?>
								<tr>
									<td colspan="4"><!-- <span>Total No. of courses Registered: <b><?=$bksubcnt?></b></span> --><span class="pull-right">Fee to be Paid: <b><span id="total_feesB"></span></b></span> </td>
									
									
								</tr>
								</tbody>
							</table>
							</div>
						</div>
						<?php }else{ 
							// for backlog papers
							?>
								<div class="panel">
						<div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">Subject Appearing</span>
						</div>
							<table class="table table-bordered">
							<thead>
								<tr>
								    <th>#</th>
									<th>Sr.No</th>
									<th>Course Code/Name</th>
									<th>Sem</th>
									
								</tr>
							</thead>
							<tbody>
							<input type="hidden" name="exam_details" value="<?php echo $exam[0]['exam_id'] ?>~<?php echo $exam[0]['exam_month'] ?>~<?php echo $exam[0]['exam_year'] ?>~<?php echo $exam[0]['exam_type'] ?>">
							<input type="hidden" name="stream_id" value="<?php echo $emp[0]['admission_stream'] ?>">
							
							<input type="hidden" name="student_id" value="<?php echo $emp[0]['stud_id'] ?>">
							<input type="hidden" name="enrollment_no" value="<?php echo $emp[0]['enrollment_no'] ?>">
							<input type="hidden" name="school_code" value="<?php echo $emp[0]['school_code'] ?>">
							<input type="hidden" name="course_id" value="<?php echo $emp[0]['course_id'] ?>">
								<?php
								$i = 1;

								if (!empty($sublist))
									{
										
									
									foreach($sublist as $sub)
										{
											if (in_array($sub['sub_id'], $sub_app_id)){
												$applied = "checked='checked'";
												
											}else{
												$applied = "";
											}
											$sub_sem[] =$sub['semester'];
								?>
								<tr>
									<td><input type="checkbox" name="sub[]" value="<?php echo $sub['sub_id'] ?>~<?php echo $sub['subject_code'] ?>~<?php echo $sub['semester'] ?>" <?=$applied?>  onclick="CheckSubjectCNT()"></td>
									<td><?php echo $i; ?> &nbsp; &nbsp;</td>
									<td><?php echo $sub['subject_code'].' - '.$sub['subject_name']; ?></td>
									<td><?php echo $sub['semester'] ?></td>
									
									
								</tr>
								<?php
										$i++;
										}?>

									<?php }
								  else
									{
									echo "<tr><td colspan=4 style='color:red'>The Subjects are not allocated. Please contact to school Dean.</td></tr>";
									}

								?>

								</tbody>
							</table>
							</div>

					<?php
							$stud_sub_sem = max($sub_sem);

						}?>
						<input type="text" name="semester" value="<?php echo $stud_sub_sem; ?>">
					</div>
				
							<div class="col-sm-12">
							<div class="panel">
							<div class="panel-heading">
							<?php
							if($emp[0]['stream_id']==43||$emp[0]['stream_id']==44||$emp[0]['stream_id']==45||$emp[0]['stream_id']==46||$emp[0]['stream_id']==47||$emp[0]['stream_id']==66||$emp[0]['stream_id']==104||$emp[0]['stream_id']==5||$emp[0]['stream_id']==6||$emp[0]['stream_id']==7||$emp[0]['stream_id']==8||$emp[0]['stream_id']==10||$emp[0]['stream_id']==11||$emp[0]['stream_id']==96||$emp[0]['stream_id']==97||$emp[0]['stream_id']==22||$emp[0]['stream_id']==67||$emp[0]['stream_id']==37||$emp[0]['stream_id']==103||$emp[0]['stream_id']==6||$emp[0]['stream_id']==11||$emp[0]['stream_id']==9||$emp[0]['stream_id']==96||$emp[0]['stream_id']==97||$emp[0]['stream_id']==8||$emp[0]['stream_id']==10||$emp[0]['stream_id']==66||$emp[0]['stream_id']==31||$emp[0]['stream_id']==23||$emp[0]['stream_id']==24||$emp[0]['stream_id']==32||$emp[0]['stream_id']==38||$emp[0]['stream_id']==39||$emp[0]['stream_id']==40||$emp[0]['stream_id']==64||$emp[0]['stream_id']==71)
							{
									$dpay=400;
							}
							else if($emp[0]['stream_id']==35||$emp[0]['stream_id']==51||$emp[0]['stream_id']==49||$emp[0]['stream_id']==50||$emp[0]['stream_id']==48||$emp[0]['stream_id']==12||$emp[0]['stream_id']==19||$emp[0]['stream_id']==98||$emp[0]['stream_id']==15||$emp[0]['stream_id']==16||$emp[0]['stream_id']==13||$emp[0]['stream_id']==21||$emp[0]['stream_id']==20||$emp[0]['stream_id']==68||$emp[0]['stream_id']==26||$emp[0]['stream_id']==29)
							{
								$dpay=600;
							}
							else{
								$dpay=0;
							}

							?>
							<input type="hidden" name="applicable_fee" id="applicable_fee">
								<span class="panel-title" style="color:#FFF">Fee Details <div class="pull-right" id="total_fees"></div></span>
							</div>
							
							<div class="clearfix">&nbsp;</div>
							
							<div class="row">
								<div class="col-sm-12">
								<table class="table table-bordered" >
									<thead>
										<tr>
											<th>Payment Type</th>
											<th>Recept No</th>
											<th>Date</th>
											<th>Amount</th>
											<th>Bank Name</th>
											<th>Bank City</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i = 1;

										if (!empty($fee))
											{
										?>
										<tr>
											<td><?php echo $fee[0]['fees_paid_type'] ?></td>
											<td><?php echo $fee[0]['receipt_no'] ?></td>
											<td><?php
													if ($fee[0]['fees_date'] != '' && $fee[0]['fees_date'] != '0000-00-00')
														{
														echo date('d/m/Y', strtotime($fee[0]['fees_date']));
														}

												?>
													
											</td>
											<td><?php echo $fee[0]['amount'] ?></td>
											<td><?php echo $fee[0]['bank_name'] ?></td>
											<td><?php echo $fee[0]['bank_city'] ?></td>
										</tr>
										<?php
									}
								  else
									{
									echo '<tr><td colspan="6" style="color:red">Examination fees not paid.</td></tr>';
									} ?>
									</tbody>

								</table>
								</div>	
							</div>	
							<div class="clearfix">&nbsp;</div>
									
							
							</div>
							<div class="row">
								<div class="col-sm-12" style="align:center">
								<?php
								//if (!empty($sublist) && !empty($fee))
								//if (!empty($sublist))
									//{
								?>
								<div class="col-sm-4"></div>
								<div class="col-sm-1">
									<input type="submit" name="save" id="save" value="Submit" class="btn btn-primary"> <!--onclick="return validatechk()"-->
								</div>
								<div class="col-sm-2"><button class="btn btn-primary pull-left" id="btn_cancel" type="button" onclick="window.location='<?php echo base_url($currentModule) ?>/search_exam_form'">Cancel</button></div>	
								<?php
								/*}
							  else
								{
								} */?>							
								</div>
							</div>
							<?php }else{
								echo "<span style='color:red'>You are not applicable to submit the special supplementary examination form. Please contact to the COE department.</span>";
							}?>
							</div>
						</div>
						
                    </div>
                </div>
			</div>
			</form>
		</div>
			
    </div>
</div>
<style>
.panel-heading {
  color: #4bb1d0;
  background-color: #3da1bf!important;;
  border-color: #4bb1d0;
}
.table,table{width: 100%;max-width: 100%;}
</style>
<script>
function CheckSubjectCNT(){

	var sublist = $("[name='sub[]']:checked").length;
	var app_fee = '<?=$dpay?>';
	var exam_type = '<?=$exam[0]['exam_type']?>';
	//alert(app_fee);
	var tot_fee = app_fee * sublist;
	// alert(tot_fee);

	
	if(exam_type=='Regular'){
		$('#total_feesB').html(tot_fee);
		var totfees = parseInt('<?=$examfees[0]['exam_fees']?>')+tot_fee;
	}else{
		var totfees = tot_fee;
	}
	$('#total_fees').html("Total fees to be paid: "+totfees);
	$('#applicable_fee').val(totfees);
}

function validatechk(){

	var sublist = $("[name='sub[]']:checked").length;
	if (!sublist){
        alert("Please check at least one checkbox from BACKLOG");
        return false;
    }
}
	
</script>
