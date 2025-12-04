<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script>    
$(document).ready(function()
{
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
			<div class="col-sm-12">
				<div class="panel">           
                    <div class="panel-body">
					<div class="col-sm-12">
						<div class="panel">
						<div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">Personal Details</span>
						</div>
					<form name="exam_form" method="POST" action="<?=base_url($currentModule.'/update_subject_details')?>">
                         
						<table class="table table-bordered">
    					<tr>
    					  <th width="12%">PRN No :</th>
						  <td width="38%"><?=$emp[0]['enrollment_no']?></td>
						  <th width="12%">Exam Name :</th>
						  <td width="38%"><?=$exam[0]['exam_month']?>-<?=$exam[0]['exam_year']?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name :</th>
						  <td><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></td>
						   <th >DOB:</th>
						   <td><?=$emp[0]['dob']?> </td>
						</tr>
						<tr>
    					  <th scope="col">Course Name :</th>
						  <td><?=$emp[0]['stream_name']?></td>
						   <th>School :</th>
						   <td><?=$emp[0]['school_code']?>-<?=$emp[0]['school_name']?></td>
    					</tr>

						</table>
						</div>
						</div>

						<div class="col-sm-12">
						<div class="panel">
						<div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">Subject appearing</span>
						</div>
						<div class="panel-body">	
							<table class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Sr.No</th>
									<th>Subject Code</th>
									<th>Subject Name</th>
									<th>Semester</th>
									
								</tr>
							</thead>
							<tbody>
							<input type="hidden" name="exam_details" value="<?=$exam[0]['exam_id']?>~<?=$exam[0]['exam_month']?>~<?=$exam[0]['exam_year']?>~<?=$exam[0]['exam_master_id']?>">
							<input type="hidden" name="stream_id" value="<?=$emp[0]['admission_stream']?>">
							<input type="hidden" name="semester" value="<?=$emp[0]['admission_semester']?>">
							<input type="hidden" name="student_id" value="<?=$emp[0]['stud_id']?>">
							<input type="hidden" name="enrollment_no" value="<?=$emp[0]['enrollment_no']?>">
							<input type="hidden" name="school_code" value="<?=$emp[0]['school_code']?>">
								<?php
								//echo $ex_session[0]['exam_type'];
								if($ex_session[0]['exam_type']=='Regular'){
								//echo "<pre>";print_r($semsublist);
								if(!empty($sublist)){
										foreach($sublist as $appsub){
											$sub_app_id[]= $appsub['sub_id']; 
										}
								}
								/*if(!empty($backlogsublist)){
										foreach($backlogsublist as $bklgsub){
											$bklgsub[]= $bklgsub['sub_id']; 
										}
								}*/
								//echo count($semsublist);
								$i=1;
									if(!empty($semsublist)){
										$allsubjects1 = array_merge($sublist, $semsublist);
										$allsubjects2 = array_merge($allsubjects1, $backlogsublist);
										$allsubjects = array_unique($allsubjects2, SORT_REGULAR);
										//echo "<pre>";print_r($allsubjects);echo "<pre>"; print_r($allsubjects);echo "backlog";print_r($backlogsublist);
										foreach($allsubjects as $sub){
											if (in_array($sub['sub_id'], $sub_app_id)){
												$applied = "checked='checked'";
												
											}else{
												$applied = "";
												$ahref ="";
											}
								?>
								<tr>
									
									<td><input type="checkbox" name="chk_sub[]" id="chk_sub" class='studCheckBox' value="<?=$sub['sub_id']?>~<?=$sub['subject_code']?>~<?=$sub['semester']?>" <?=$applied?>>
			
									</td>
									<td><?=$i;?></td>
									<td>
									<?=$sub['subject_code']?></td>
									<td><?=$sub['subject_name']?></td>
									<td><?=$sub['semester']?></td>
									
									
								</tr>

								<?php 
									$i++;
									}
									}else{
										echo "<tr><td colspan=4>No data found.</td></tr>";
									}
								?>
								<?php }else{

								if(!empty($sublist)){
										foreach($sublist as $appsub){
											$sub_app_id[]= $appsub['sub_id']; 
										}
								}
								$i=1;
									if(!empty($allbklist)){

										foreach($allbklist as $sub){
											if (in_array($sub['sub_id'], $sub_app_id)){
												$applied = "checked='checked'";
												
											}else{
												$applied = "";
												$ahref ="";
											}
								?>
								<tr>
									
									<td><input type="checkbox" name="chk_sub[]" id="chk_sub" class='studCheckBox' value="<?=$sub['sub_id']?>~<?=$sub['subject_code']?>~<?=$sub['semester']?>" <?=$applied?> onclick="CheckSubjectCNT()">
			
									</td>
									<td><?=$i;?></td>
									<td>
									<?=$sub['subject_code']?></td>
									<td><?=$sub['subject_name']?></td>
									<td><?=$sub['semester']?></td>
									
									
								</tr>
								<?php 
									$i++;
									}
									}else{
										echo "<tr><td colspan=4>No data found1.</td></tr>";
									}
								}
								?>
								</tbody>
							</table>
							<input type="hidden" name="applicable_fee" id="applicable_fee">
							
							<div class="row">
								<div class="col-sm-12">
								<div class="col-sm-2">
									<input type="submit" name="save" id="save" value="Update Subjects" class="btn btn-primary">
								</div>
								<div class="col-sm-2"><button class="btn btn-primary pull-left" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/search_exam_form'">Cancel</button></div>								
								</div>
							</div>
							</div>
							</div>
						</div>
						</form>
							<div class="clearfix">&nbsp;</div>

							<div class="col-sm-12">
						<div class="panel">
						<div class="panel-heading">
                            <?php
							if($emp[0]['stream_id']==43||$emp[0]['stream_id']==44||$emp[0]['stream_id']==45||$emp[0]['stream_id']==46||$emp[0]['stream_id']==47||$emp[0]['stream_id']==66||$emp[0]['stream_id']==104||$emp[0]['stream_id']==5||$emp[0]['stream_id']==6||$emp[0]['stream_id']==7||$emp[0]['stream_id']==8||$emp[0]['stream_id']==10||$emp[0]['stream_id']==11||$emp[0]['stream_id']==96||$emp[0]['stream_id']==97||$emp[0]['stream_id']==22||$emp[0]['stream_id']==67||$emp[0]['stream_id']==37||$emp[0]['stream_id']==103||$emp[0]['stream_id']==6||$emp[0]['stream_id']==11||$emp[0]['stream_id']==9||$emp[0]['stream_id']==96||$emp[0]['stream_id']==97||$emp[0]['stream_id']==8||$emp[0]['stream_id']==10||$emp[0]['stream_id']==66||$emp[0]['stream_id']==31||$emp[0]['stream_id']==23||$emp[0]['stream_id']==24||$emp[0]['stream_id']==32||$emp[0]['stream_id']==38||$emp[0]['stream_id']==39||$emp[0]['stream_id']==40||$emp[0]['stream_id']==64)
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
							
								<span class="panel-title" style="color:#FFF">Fee Details <div class="pull-right" id="total_fees"><?php if(!empty($exam[0]['exam_fees'])) { echo 'Applied Fees :'.$exam[0]['exam_fees'];}?></div></span>
							</div>
							
							<div class="clearfix">&nbsp;</div>
							<?php
							if (!empty($fee))
								{
							?>
							<div class="row">
								<div class="col-sm-12">
								<label class="col-sm-2">Payment Type:</label>
								<div class="col-sm-4">
									<?php echo $fee[0]['fees_paid_type'] ?>
								</div>
								<label class="col-sm-2">Recept No:</label>
								<div class="col-sm-4">
									<?php echo $fee[0]['receipt_no'] ?>
								</div>
																
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="row">
								<div class="col-sm-12">
								<label class="col-sm-2">Date:</label>
								<div class="col-sm-4">
									<?php
										if ($fee[0]['fees_date'] != '' && $fee[0]['fees_date'] != '0000-00-00')
											{
											echo date('d/m/Y', strtotime($fee[0]['fees_date']));
											}

									?>
								</div>
								<label class="col-sm-2">Amount:</label>
								<div class="col-sm-4">
									<?php echo $fee[0]['amount'] ?>
								</div>								
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="row">
								<div class="col-sm-12">
								<label class="col-sm-2">Bank Name:</label>
								<div class="col-sm-4">
									<?php echo $fee[0]['bank_name'] ?>
								</div>
								<label class="col-sm-2">Bank City:</label>
								<div class="col-sm-4">
									<?php echo $fee[0]['bank_city'] ?>
								</div>								
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
									<?php
									}
								  else
									{
									echo '<div class="row"><div class="col-sm-12" style="color:red">
																	Exam fees are not paid.Please check the exam fees from Finance Section.
																</div></div>';
									} ?>
							</div>
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

	var sublist = $("[name='chk_sub[]']:checked").length;
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