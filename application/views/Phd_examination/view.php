<script src="<?php echo base_url('assets/javascripts').'/bootstrap-datepicker.js' ?> "></script>
<script>
/*$(document).on({
    "contextmenu": function(e) {
        console.log("ctx menu button:", e.which); 

        // Stop the context menu
        e.preventDefault();
    },
    "mousedown": function(e) { 
        console.log("normal mouse down:", e.which); 
    },
    "mouseup": function(e) { 
        console.log("normal mouse up:", e.which); 
    }
});*/
</script>
<?php 
$role_id = $this->session->userdata('role_id');
/**************************Code for late fees calculations******************************************/
if(!empty($forms_dates)){
	//print_r($forms_dates);exit;
	$crr_date=date('Y-m-d');	
	$late_fees_date=date("Y-m-d", strtotime($forms_dates[0]['frm_latefee_date']));
	$form_end_date=date("Y-m-d", strtotime($forms_dates[0]['frm_end_date']));
	if($crr_date < $late_fees_date && $crr_date >= $form_end_date){
		$diff = strtotime($crr_date) - strtotime('2025-08-13');
		$no_of_days =abs(round($diff / 86400)); 
		$late_fees=500 * $no_of_days;
		// $late_fees=500;
		// if($emp[0]['enrollment_no']== 242106136005){
		// 	$late_fees=0;
		// }
	}else if($crr_date > $late_fees_date){
		$late_fees=500;
	}else if($crr_date > $form_end_date){
		if($role_id==15){
			$diff = strtotime($crr_date) - strtotime($late_fees_date);
			$no_of_days =abs(round($diff / 86400)); 
			$late_fees=500 * $no_of_days;
			$late_fees = 3000;
		}else{
		 $late_fees=0; echo "Last Date to be apply is over";exit;
		}	
	}else{
		$late_fees=0;	
	}
}
/******************************************************************************/
if($exam[0]['exam_type'] =='Regular'){
	$title ='Examination';
}else{
	$title='Special Supplementary Examinations';
}
if($emp[0]['course_pattern']=='SEMESTER'){
	$last_semester = $emp[0]['course_duration'] *2;
}else{
	$last_semester = $emp[0]['course_duration'];
}
//echo $emp[0]['course_pattern'].''.$emp[0]['current_semester'].''.$last_semester;exit;
if($exam[0]['exam_type'] =='Regular'){
if($emp[0]['current_semester']==$last_semester){
	$degree_fees='1500';
}else{
	$degree_fees='0';
}
}else{
	$degree_fees='0';
}
$admstream_id=$emp[0]['admission_stream'];	
//echo $degree_fees;
?>
<script>    
$(document).ready(function()
{
	var exam_type = '<?=$exam[0]['exam_type']?>';
	if(exam_type=='Regular'){
	var totfees = parseInt('<?=$examfees[0]['exam_fees']?>')  || parseInt('<?=$late_fees?>');
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
            <h1 class="col-xs-12 col-sm-12 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<?=$title?> Form</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
		  <div class="row ">
			<form id="form" name="form" action="<?php echo base_url($currentModule . '/add_exam_form') ?>" method="POST" onsubmit="return validatechk()">    

			<div class="col-sm-12">
				<div class="panel">
                    
                    <div class="panel-body">
					<div class="col-sm-12">
						<div class="panel">
						<div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">Personal Details</span>
						</div>
					
                        <div class="table-responsive">
						<table class="table table-bordered">
    					<tr>
    					  <th width="12%">PRN No :</th>
						  <td width="38%"><?php echo $emp[0]['enrollment_no'] ?></td>
						  <th width="13%">Exam Name :</th>
						  <td width="38%" ><?php echo $exam[0]['exam_month'] ?>-<?php echo $exam[0]['exam_year'] ?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name :</th>
						  <td><?php echo $emp[0]['last_name'] ?> <?php echo $emp[0]['first_name'] ?> <?php echo $emp[0]['middle_name'] ?></td>
						   <th width="">DOB<small>(dd-mm-yyyy)</small>:</th>
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
						
						 <div class="clearfix"></div>
						
						  <div class="row">
						  <div class="col-sm-6" style="margin:5px">
						  <input type="text" class="form-control col-md-5" name="marathi_name" id="marathi_name" placeholder="Enter your marathi name here" value="<?=$emp[0]['marathi_name']?>" ></div>
						  
						  <div class="col-sm-4" style="margin:5px" ><ul style="    margin-left: -20px;"> 
									<li>Enter your Marathi Name as per Aadhar and University ERP record</li>
									
								</ul>	</div> 
    					</div> 
						<div class="row"> 
						  <div class="col-sm-6" style="margin:5px">
						  <input type="text" class="form-control col-md-5 creditCardText" name="abc_no" id="abc_no" minlength=15 maxlength=15 pattern="[0-9-]+" " placeholder="123-567-901-345" value="<?=$emp[0]['abc_no']?>" required='required'></div>
						  
						  <div class="col-sm-4" style="margin:5px" ><ul style="    margin-left: -20px;"> 
									<li>Enter your Academic Bank of Credits no <a href="https://abc.gov.in/" target="_blank">https://abc.gov.in/</a></li>
									
								</ul>	
								</div>
    					</div> 
						
						
						
						</div>
						</div>
						<?php if(!empty($sublist) || !empty($backlogsublist)){  ?>
						<div class="col-sm-12">
						<?php if($exam[0]['exam_type']=='Regular'){ ?>
							<div class="col-sm-6">	
							<div class="panel">
							<div class="panel-heading">
								<span class="panel-title" style="color:#FFF">Subject Appearing</span>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Sr.No</th>
										<th>Course Code/Name</th>
										<th>Credit</th>
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
							if($emp[0]['is_detained']=='N') { 								
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
												if($emp[0]['enrollment_no']=='170101151003'){
													$applied = "";
												}else{
												$applied = "checked='checked'";
												}
											}else{
												$applied = "";
											}
								?>
								
								<tr>
									<td><input type="checkbox" name="sub1[]" id="<?php echo $sub['sub_id'] ?>" value="<?php echo $sub['sub_id'] ?>~<?php echo $sub['subject_code'] ?>~<?php echo $sub['semester'] ?>" <?=$applied?>  rel="<?php echo $sub['credits'];?>" onclick="return false;"></td><!--onclick="get_credit_count('<?php echo $sub['credits'] ?>',this.id)"-->
									<td><?php echo $i; ?> &nbsp; &nbsp;</td>
									<td><?php echo $sub['subject_code'].' - '.$sub['subject_name']; ?></td>
									<td><?php echo $sub['credits'] ?></td>
									<td><?php echo $sub['semester'] ?></td>
									
								</tr>
										
								<?php
										$i++;
										}?>

								<tr>
									<td colspan="4"><!-- <span>Total No. of courses Registered: <b><?=count($sublist)?></b></span> --><span class="pull-right">Fee to be Paid: <b>0 <!--<?=$examfees[0]['exam_fees']?>--></b></span> </td>
									
									
								</tr>
									<?php }
								  else
									{
									echo "<tr><td colspan=4 style='color:red'>The Subjects are not allocated. Please contact to school Dean.</td></tr>";
									}
								}else { ?>
								<tr>
									
									<td colspan=5>Regular Subjects are not allowed.</td>
									
								</tr>
								<?php }?>
								</tbody>
								
							</table>
							</div>
							</div>
						</div>
	
					<div class="col-sm-6">	
						<div class="panel">
						<div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">BACKLOG</span>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered">
							<thead>
								<tr>
								    <th>#</th>
									<th>Sr.No</th>
									<th>Course Code/Name</th>
									<th>Credit</th>
									<th>Sem</th>
									
								</tr>
							</thead>
							<tbody>
							<input type="hidden" name="exam_details" value="<?php echo $exam[0]['exam_id'] ?>~<?php echo $exam[0]['exam_month'] ?>~<?php echo $exam[0]['exam_year'] ?>~<?php echo $exam[0]['exam_type'] ?>">
								<?php
								$k = 1;

									$bksubcnt =count($backlogsublist);
									$fin_bksubcnt = count($allsubjects) - $bksubcnt;
									$fin_bksubcnt1 = $fin_bksubcnt + $bksubcnt; 

									for($i=0; $i< count($backlogsublist); $i++)
									//foreach($backlogsublist as $bksub)
									{
										if(empty($backlogsublist[$i]['subject_code'])) {
											$disabled ="disabled='disabled'";
										}else{
											$disabled ="";
										}
								?>
								<tr>
									<td><input type="checkbox" name="sub[]" id="<?php echo $backlogsublist[$i]['sub_id'] ?>" value="<?php echo $backlogsublist[$i]['sub_id'] ?>~<?php echo $backlogsublist[$i]['subject_code'] ?>~<?php echo $backlogsublist[$i]['semester'] ?>" <?=$disabled?> onclick="CheckSubjectCNT(<?php echo $backlogsublist[$i]['sub_id'] ?>)" rel="<?php echo $backlogsublist[$i]['credits'];?>"> 
									</td>
									<td><?php echo $k; ?> &nbsp; &nbsp;</td>
									<td><?php if(!empty($backlogsublist[$i]['subject_code'])) { echo $backlogsublist[$i]['subject_code'].' - '.$backlogsublist[$i]['subject_name']; }?></td>
									<td><?php echo $backlogsublist[$i]['credits'] ?></td>
									<td><?php echo $backlogsublist[$i]['semester'] ?></td>
									
								</tr>
								<?php
										$k++;
										}
								?>
								<tr>
									<td colspan="5"><!-- <span>Total No. of courses Registered: <b><?=$bksubcnt?></b></span> --><span class="pull-right">Fee to be Paid: <b><span id="total_feesB"></span></b></span> </td>
									
									
								</tr>
								</tbody>
							</table>
							</div>
							</div>
						</div>
						<?php }else{ 
							// for backlog papers
							?>
								<div class="panel">
						<div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">Subject Appearing</span>
						</div>
						<div class="table-responsive">
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
									<td><input type="checkbox" name="sub[]" value="<?php echo $sub['sub_id'] ?>~<?php echo $sub['subject_code'] ?>~<?php echo $sub['semester'] ?>" <?=$applied?>  onclick="CheckSubjectCNT(<?php echo $sub['sub_id'] ?>)"></td>
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
							</div>

					<?php
							$stud_sub_sem = max($sub_sem);
							?>
							<input type="hidden" name="semester" value="<?php echo $stud_sub_sem; ?>">
	
						<?php
						
						}?>
					</div>
				
							<div class="col-sm-12">
							<div class="panel">
							<div class="panel-heading">
							<?php
							if($emp[0]['stream_id']==43 || $emp[0]['stream_id']==44 || $emp[0]['stream_id']==45 || $emp[0]['stream_id']==46 || $emp[0]['stream_id']==47 || $emp[0]['stream_id']==66 || $emp[0]['stream_id']==104 || $emp[0]['stream_id']==5 || $emp[0]['stream_id']==6 || $emp[0]['stream_id']==7 || $emp[0]['stream_id']==8 || $emp[0]['stream_id']==10 || $emp[0]['stream_id']==11 || $emp[0]['stream_id']==96 || $emp[0]['stream_id']==97 || $emp[0]['stream_id']==22 || $emp[0]['stream_id']==67 || $emp[0]['stream_id']==37 || $emp[0]['stream_id']==103 || $emp[0]['stream_id']==6 || $emp[0]['stream_id']==11 || $emp[0]['stream_id']==9 || $emp[0]['stream_id']==31 || $emp[0]['stream_id']==23 || $emp[0]['stream_id']==24 || $emp[0]['stream_id']==32 || $emp[0]['stream_id']==38 || $emp[0]['stream_id']==39 || $emp[0]['stream_id']==40 || $emp[0]['stream_id']==64 || $emp[0]['stream_id']==71 || $emp[0]['stream_id']==107 || $emp[0]['stream_id']==113 || $emp[0]['stream_id']==33 || $emp[0]['stream_id']==34 || $emp[0]['stream_id']==120 || $emp[0]['stream_id']==109 || $emp[0]['stream_id']==116 || $emp[0]['stream_id']==117 || $emp[0]['stream_id']==124 || $emp[0]['stream_id']==54 || $emp[0]['stream_id']==55 || $emp[0]['stream_id']==65 || $emp[0]['stream_id']==108 || $emp[0]['stream_id']==123 || $emp[0]['stream_id']==145 || $emp[0]['stream_id']==146 || $emp[0]['stream_id']==147 || $emp[0]['stream_id']==148 || $emp[0]['stream_id']==149 || $emp[0]['stream_id']==151 || $emp[0]['stream_id']==152 || $emp[0]['stream_id']==154 || $emp[0]['stream_id']==155 || $emp[0]['stream_id']==158 || $emp[0]['stream_id']==159 || $emp[0]['stream_id']==160 || $emp[0]['stream_id']==162 || $emp[0]['stream_id']==163 || $emp[0]['stream_id']==167 || $emp[0]['stream_id']==168 || $emp[0]['stream_id']==112 || $emp[0]['stream_id']==127 || $emp[0]['stream_id']==165)
							{
									$dpay=400;
							}
							else if($emp[0]['stream_id']==35||$emp[0]['stream_id']==36||$emp[0]['stream_id']==51||$emp[0]['stream_id']==49||$emp[0]['stream_id']==50||$emp[0]['stream_id']==48||$emp[0]['stream_id']==12||$emp[0]['stream_id']==19||$emp[0]['stream_id']==98||$emp[0]['stream_id']==15||$emp[0]['stream_id']==16||$emp[0]['stream_id']==13||$emp[0]['stream_id']==21||$emp[0]['stream_id']==20||$emp[0]['stream_id']==68||$emp[0]['stream_id']==26||$emp[0]['stream_id']==29 || $emp[0]['stream_id']==106 || $emp[0]['stream_id']==105||$emp[0]['stream_id']==121||$emp[0]['stream_id']==42|| $emp[0]['stream_id']==17 || $emp[0]['stream_id']==27 || $emp[0]['stream_id']==28 || $emp[0]['stream_id']==41 || $emp[0]['stream_id']==52 || $emp[0]['stream_id']==69 || $emp[0]['stream_id']==110 || $emp[0]['stream_id']==111 || $emp[0]['stream_id']==115 || $emp[0]['stream_id']==118 || $emp[0]['stream_id']==119 || $emp[0]['stream_id']==122 || $emp[0]['stream_id']==150 || $emp[0]['stream_id']==161 || $emp[0]['stream_id']==164 || $emp[0]['stream_id']==166 || $emp[0]['stream_id']==160 || $emp[0]['stream_id']==162 || $emp[0]['stream_id']==163 || $emp[0]['stream_id']==167 || $emp[0]['stream_id']==169)
							{
								$dpay=600;
							}
							else{
								$dpay=0;
							}

							?>
							<input type="hidden" name="applicable_fee" id="applicable_fee" value="">
								<span class="panel-title" style="color:#FFF">Fee Details <div class="pull-right" id="total_fees"></div></span>
							</div>
							
							<div class="clearfix">&nbsp;</div>
							
							<!--div class="row">
								<div class="col-sm-12">
								<div class="table-responsive">
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
									echo '<tr><td colspan="6" style="color:red"></td></tr>';
									} ?>
									</tbody>

								</table>
								</div>
								</div>	
							</div>	
							<div class="clearfix">&nbsp;</div-->
									
						
							</div>
									<div class="row"> <b>Note :</b> <ul><li>For correction in Subject Appearing. Please contact to the COE department.</li>
							<li>For correction in Personal Details. Please contact to the Student department.</li>
							</ul>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="row">
								<div class="col-sm-12" style="align:center">
								<?php
								//if (!empty($sublist) && !empty($fee))
								//if (!empty($sublist))
									//{
								?>
								<div class="col-sm-4"></div>
								<div class="col-sm-1" >
									<input type="submit" name="save" id="save" value="Submit" class="btn btn-primary" style="margin-bottom: 10px;"> <!--onclick="return validatechk()"-->
								</div>
								<div class="col-sm-2"><button class="btn btn-primary pull-left" id="btn_cancel" type="button" onclick="window.location='<?php echo base_url($currentModule) ?>/search_exam_form'">Cancel</button></div>	
								<?php
								/*}
							  else
								{
								} */?>							
								</div>
							</div>
							<?php 
						}else{
								$stdprn= base64_encode($emp[0]['enrollment_no']);
								echo "<span style='color:red'>You are not applicable to submit the examination form. Please contact to the COE department.</span>";//special supplementary 
								if($role_id ==15 || $role_id ==6){
								echo '<a href="https://erp.sandipuniversity.com/Phd_examination/edit_exam_form_contocoe/'.$stdprn.'" title="View" target="_blank"><span class="btn btn-primary">Update Arrears</span> </a>';
								}
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
$('.creditCardText').keyup(function() {
  var foo = $(this).val().split("-").join(""); // remove hyphens
  if (foo.length > 0) {
    foo = foo.match(new RegExp('.{1,3}', 'g')).join("-");
  }
  $(this).val(foo);
});
function CheckSubjectCNT(subid){

	var sublist = $("[name='sub[]']:checked").length;
	//var app_fee = '<?=$dpay?>';
	var app_fee = 600;
	var exam_type = '<?=$exam[0]['exam_type']?>';
	//alert(app_fee);
	var degree_fees = parseInt('<?=$degree_fees?>');
	var late_fees = parseInt('<?=$late_fees?>');
	//alert(degree_fees);
	var tot_fee = late_fees +(app_fee * sublist);
	 //alert(tot_fee);

	
	if(exam_type=='Regular'){
		$('#total_feesB').html(tot_fee);
		//var totfees = parseInt('<?=$examfees[0]['exam_fees']?>')+tot_fee;
		var totfees = tot_fee;
	}else{
		var totfees = tot_fee;
	}
	$('#total_fees').html("Total fees to be paid: "+totfees);
	$('#applicable_fee').val(totfees);
	
	var total = 0;
      $('input:checkbox:checked').each(function(){
       total += isNaN(parseInt($(this).attr("rel"))) ? 0 : parseInt($(this).attr("rel"));
      });   
  
    //alert(total);
	var tot_credits =36;
	
	var admstream_id = parseInt('<?=$admstream_id?>');
	/*var prn11 ='<?=$emp[0]['enrollment_no'] ?>';
	if(prn11 =='180110021059'){
		alert(admstream_id);
	}*/
	//alert(admstream_id);
	if(admstream_id ==116 || admstream_id ==119){
		return true;
	}else{		
		if(total > parseInt(tot_credits)){
			alert("Maximum(36) credits Limit excceds, please uncheck some subjects");
			//$('input:checkbox:not(:checked)').attr('disabled', 'disabled');
			//alert(subid);
			if($("#"+subid).prop("checked") == true){
					//alert("Checkbox is checked.");
					//alert(app_fee)
					var totfees_updated = totfees-app_fee;
					//alert(totfees_updated);
					$('#total_fees').html("Total fees to be paid: "+totfees_updated);
					$('#total_feesB').html("Fees to be paid: "+totfees_updated);
					$("#"+subid).prop("checked", false);
					$('#applicable_fee').val(totfees_updated);
				}
				else if($("#"+subid).prop("checked") == false){
					//alert("Checkbox is unchecked.");
					
				}
			 return false;		 
		}else{
			return true;		
		}
	}
	
}

function validatechk(){

	var sublist = $("[name='sub[]']:checked").length;
	//alert(sublist);
	var bksubcnt = '<?=$bksubcnt?>';
	//alert(bksubcnt);
	if(bksubcnt !='0'){
		if (!sublist){
			//alert("Please check at least one checkbox from Subjects List");
			//return false;
		}
	}else{
		return true;
	}
	
}
function get_credit_count(credits,subid){

	var total = 0;
      $('input:checkbox:checked').each(function(){
       total += isNaN(parseInt($(this).attr("rel"))) ? 0 : parseInt($(this).attr("rel"));
      });   
  
    //alert(total);
	var tot_credits ="36";
	var admstream_id1 =parseInt('<?=$admstream_id?>');
	//alert(admstream_id);
	if(admstream_id1 ==116 || admstream_id1 ==119){
		return true;
	}else{
		if(total > parseInt(tot_credits)){
			alert("Maximum(36) credits Limit excceds, please uncheck some subjects");
			//$('input:checkbox:not(:checked)').attr('disabled', 'disabled');
			$("#"+subid).prop("checked", false);
			 return false;		 
		}else{
			return true;		
		}
	}
	
	
}
</script>
