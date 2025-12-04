<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<script>
$(document).on({
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
});
</script>
<?php 
//$arrstud_id = array(1673);
if(in_array($emp[0]['stud_id'], $arrstud_id)){
	$max_credits=44;
}else{
	$max_credits=44;
}
$role_id = $this->session->userdata('role_id');
 $aname = $this->session->userdata('name');
$late_allowed = array();
/**************************Code for late fees calculations******************************************/
if(!empty($forms_dates)){
	//print_r($forms_dates);exit;

	$crr_date=date('Y-m-d');	
	$late_fees_date=date("Y-m-d", strtotime($forms_dates[0]['frm_latefee_date']));
	$form_end_date=date("Y-m-d", strtotime($forms_dates[0]['frm_end_date']));
	$frm_open_date=date("Y-m-d", strtotime($forms_dates[0]['frm_open_date']));
	$superlate_fine_date=date("Y-m-d", strtotime($forms_dates[0]['superlate_fine_date']));
	$phase_two_form_end_date = '2025-12-05';
	$phase_three_form_end_date = '2025-12-05';
	$phase_three_late_fees_date = '2025-12-06';
	$phase_three_superlate_fine_date = '2025-12-11';
	$package_form_end_date = '2025-11-03';
	$p_stream = array(7, 11, 97, 162); // computer branches
	
	$states = array(36,33,32,29,28); 
	if(in_array($state_id,$states)){
	 	$form_end_date = $package_form_end_date;
		$late_fees_date = $package_form_end_date;
	}	
	if($nationality == 'INTERNATIONAL' || $package_name == 'Reddy'){
		$form_end_date = $package_form_end_date;
		$late_fees_date = $package_form_end_date;
		// echo 'hii';exit;
	}
	if((in_array($emp[0]['stream_id'],$p_stream) && $emp[0]['current_semester'] == 3) || ($ad_yrr == 2 && $ad_ssn == 2025)){
		$form_end_date = $phase_two_form_end_date;
		$late_fees_date = '2025-12-06';
		$superlate_fine_date = '2025-12-11';
		// echo 'hii';exit;
	}else{
		$form_end_date = $form_end_date;
		$late_fees_date = $late_fees_date;
		// echo 'bye';exit;
		
	}
	
	if($crr_date < $frm_open_date){
		echo 'Exam form not opened yet. Please Wait.';exit;
	}	
	
	if($emp[0]['current_semester'] == 1 || ($ad_yrr == 1 && $ad_ssn == 2025)){
		$form_end_date = $phase_three_form_end_date;
		$late_fees_date = $phase_three_late_fees_date;
		$superlate_fine_date = $phase_three_superlate_fine_date;
	}
	// echo  $form_end_date.'____'.$late_fees_date.'____'.$superlate_fine_date;exit;
	if($crr_date >=$late_fees_date && $crr_date > $form_end_date && $crr_date < $superlate_fine_date){
		//echo 1;exit;
		$diff = strtotime($crr_date) - strtotime($late_fees_date);
		$no_of_days =abs(round($diff / 86400)); 
		$late_fees=200 * $no_of_days;
		//$late_fees=100 * 4;
	}elseif($crr_date >= $superlate_fine_date){
		$late_fees=3000;	//20000		
		// $late_fees=0;		
	}else{
		$late_fees=0; // echo "Last Date to be apply is over";exit;
	}
	
	$newenroll = array();
	 if(($late_fees == 3000 && (($ad_yrr != 1 && $ad_ssn != 2025)||( ($ad_yrr != 2 && $ad_ssn != 2025) 
		 && !in_array($emp[0]['stream_id'],$p_stream))) && $role_id != 15) && !in_array($aname, $newenroll)){
		echo 'your exam form last date is over.';exit;
	} 
}  
//$late_fees=0;
/******************************************************************************/

$nolatefess = array(230105132171);


if(in_array($emp[0]['enrollment_no'], $nolatefess)){
	
	$late_fees=0;
	
}

$nolatefess1 = $for_no_fine;

if(in_array($emp[0]['enrollment_no'], $nolatefess1)){
	
	$late_fees=0;
	
}


//echo $june_exam_credits;exit;
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
	//echo C_RE_REG_YEAR;exit;
	if($emp[0]['current_semester']==$last_semester && $emp[0]['academic_year']==C_RE_REG_YEAR){
		// $degree_fees='3000';//1500
		 $degree_fees='0';
	}else{
		$degree_fees='0';
	}
}else{
	$degree_fees='0';
}
$admstream_id=$emp[0]['admission_stream'];	
// echo $degree_fees;exit;
?>
<script>


function UncheckAll(){ 
       
      //var w = document.getElementsByTagName('sub');
	  //$("[name='sub[]']:checked").length;
	  $("[name='sub[]']").attr('checked',false);
/* alert(w.length);	  
      for(var i = 0; i < w.length; i++){ 
        if(w[i].type=='checkbox'){ 
          w[i].checked = false; 
        }
      } */
  }    
$(document).ready(function(){
	
	 window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    // Handle page restore.
    window.location.reload();
  }
});
	//location.reload(); */
}); 
$(document).ready(function()
{
	//$("input:checkbox:checked").attr("checked", "");
	var exam_type = '<?=$exam[0]['exam_type']?>';
	var degree_fees = '<?=$degree_fees?>';
	var lateFees = parseInt('<?=$late_fees?>');
var degreeFees = parseInt('<?=$degree_fees?>');
var totfees = lateFees + degreeFees;
	 //alert(degree_fees);
	if(exam_type=='Regular'){
	//var totfees = parseInt('<?=$examfees[0]['exam_fees']?>')  || parseInt('<?=$late_fees?>') || parseInt('<?=$degree_fees?>');
	// alert(totfees);
	  $('#total_fees').html("Total fees to be paid: "+totfees);
	  $('#applicable_fee').val(totfees);
	  var totfees_encod = btoa(totfees);
	  $('#examaname').val(totfees_encod);
	}

	$('#dddate').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
	if(totfees >0){
	  $("#save").css("display", "none");
      $("#pay").css("display", "block");	  
	}
	if(totfees <= 0){
	  $("#pay").css("display", "none");
	  $("#save").css("display", "block");
	}
	
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
			<form id="form" name="form" action="https://secure.payu.in/_payment" method="POST" onsubmit="return submitPayuForm()">    

			<div class="col-sm-12">
				<div class="panel">
                    
                    <div class="panel-body">
					 <input type="hidden" name="key" value="soe5Fh" /><?php //echo $MERCHANT_KEY ?>
                     <input type="hidden" name="hash" id="hash" value=""/>
                     <input type="hidden" name="txnid" id="txnid" value="" />
                     <input type="hidden" name="amount" id="amount" value="" />
                    <!-- <input type="hidden" name="action" value="https://secure.payu.in/_payment" />-->
                     <?php // $vat = date('ymd')."".rand(1000,9999); ?>
                     <input name="firstname" id="firstname" type="hidden"  placeholder="Enter your Name*"  value="<?php echo trim( $emp[0]['first_name']); ?>"  required />
                     <input name="email" id="email" type="hidden"  placeholder="Email*"  value="<?php if($emp[0]['email'] != ''){echo $emp[0]['email'];}else{echo 'balasaheb.lengare@carrottech.in';} ?>"  required />
                     <input type="hidden" name="mobile" id="mobile_hp" value="<?php echo $emp[0]['mobile']; ?>" required="required">
                     <input type="hidden" name="udf1" id="udf1" value="">
                     <input type="hidden" name="udf2" id="udf2" value="<?php echo $exam[0]['exam_id']; ?>">
                     <input type="hidden" name="udf3" id="udf3" value="<?php echo $emp[0]['enrollment_no']; ?>"> 
                     <input type="hidden" name="academic_year" value="<?php echo C_RE_REG_YEAR ?>">					 
                     <input type="hidden" name="current_academic_year" value="<?php echo $emp[0]['academic_year']; ?>">					 
                     <input type="hidden" name="udf4" id="udf4" value="<?php echo $emp[0]['mobile']; ?>">
                     <input type="hidden" name="udf5" id="udf5" value="<?php echo $emp[0]['stud_id']; ?>"> 
                     <input type="hidden" name="address1" id="address1" value="<?php echo $degree_fees; ?>"> 
                     <input type="hidden" name="stud_id" id="stud_id" value="<?php echo $emp[0]['stud_id']; ?>" required="required">
                     <input type="hidden" name="surl" value="<?=base_url(); ?>Online_fee/exam_success"/>
                     <input type="hidden" name="furl" value="<?=base_url(); ?>Online_fee/failure"/>
                     <!--input type="hidden" name="productinfo" id="productinfo" value="<?php echo $emp[0]['course_pattern'] ?>-<?php echo $exam[0]['exam_year'] ?>_Exam_Fees" / -->
                     <input type="hidden" name="productinfo" id="productinfo" value="Examination" />
                     <input type="hidden" name="course_duration" id="course_duration" value="<?php echo $emp[0]['course_duration'] ?>" />
                     <input type="hidden" name="course_pattern" id="course_pattern" value="<?php echo $emp[0]['course_pattern'] ?>" />
                     <input type="hidden" name="course_type" id="course_type" value="<?php echo $emp[0]['course_type'] ?>" />
					 
					<div class="col-sm-12">
						<div class="panel">
						<div class="panel-heading"> 
                            <span class="panel-title" style="color:#FFF">Personal Details</span>
							<input type="hidden" name="applicable_fee" id="applicable_fee" value="">
							
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
						<tr style="border-bottom: #e4e4e4 solid 1px;">
    					  <th scope="col">Course Name :</th>
						  <td><?php echo $emp[0]['stream_name'] ?></td>
						   <th width="">School :</th>
						   <td><?php echo $emp[0]['school_code'] ?>-<?php echo $emp[0]['school_name'] ?></td>
    					</tr>
						
						</table>
					
    					 
						
						</div>
						
						
						 <div class="clearfix"></div>
						 <?php 
						 if($emp[0]['nationality'] =='Indian' && ($emp[0]['admission_session']==2023 || $emp[0]['admission_session']==2022 || $emp[0]['admission_session']==2024)){
							 $req='required="required"';
						 }else{
							 $req='';
						 }
						 ?>
						  <div class="row">
						  <div class="col-sm-6" style="margin:5px">
						  <input type="text" class="form-control col-md-5" name="marathi_name" id="marathi_name" placeholder="Enter your marathi name here" value="<?=$emp[0]['marathi_name']?>" required='required' ></div>
						  
						  <div class="col-sm-4" style="margin:5px" ><ul style="    margin-left: -20px;"> 
									<li>Enter your Marathi Name as per Aadhar and University ERP record</li>
									
								</ul>	</div> 
    					</div> 
						<div class="row"> 
						  <div class="col-sm-6" style="margin:5px">
						  <input type="text" class="form-control col-md-5 creditCardText" name="abc_no" id="abc_no" minlength=15 maxlength=15 pattern="[0-9-]+" placeholder="123-567-901-345" value="<?=$emp[0]['abc_no']?>" <?=$req?>></div>
						  
						  <div class="col-sm-4" style="margin:5px" ><ul style="    margin-left: -20px;"> 
									<li>Enter your Academic Bank of Credits no <a href="https://abc.gov.in/" target="_blank">https://abc.gov.in/</a></li>
									
								</ul>	</div>
    					</div> 
						<input type="hidden" name="examaname" id="examaname" value="">
						
						
						
						
						
						
						
						
						
							</div>
							</div>
							<div class="clearfix">&nbsp;</div>
						<?php	
						if($emp[0]['enrollment_no']=='200110011055'){
							//print_r($sublist);exit;
						}
						if(!empty($sublist) || !empty($backlogsublist)){ ?>
						<div class="col-sm-12">
						<?php	if($exam[0]['exam_type']=='Regular'){ ?>
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
									<th>Subject Type</th>
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
							<input type="hidden" name="degree_convocation_fees" value="<?php echo $degree_fees ?>">
							<input type="hidden" name="late_fees" value="<?php echo $late_fees ?>">
							
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
												$applied = "checked='checked'";
											}else{
												$applied = "";
											}
								?>
								
								<tr>
									<td><input type="checkbox" name="sub1[]" id="<?php echo $sub['sub_id'] ?>" value="<?php echo $sub['sub_id'] ?>~<?php echo $sub['subject_code'] ?>~<?php echo $sub['semester'] ?>~<?php echo $sub['credits'];?>~N" <?=$applied?>  rel="<?php echo $sub['credits'];?>" class="cheksub" onclick="return false;"></td><!--onclick="get_credit_count('<?php echo $sub['credits'] ?>',this.id)"-->
									<td><?php echo $i; ?> &nbsp; &nbsp;</td>
									<td><?php echo $sub['subject_code'].' - '.$sub['subject_name']; ?></td>
									<td><?=$sub['subject_component']?> <?php if($sub['subject_component'] == 'EM'){echo '<small>('.$sub['failed_sub_type'].')</small>';} ?></td>
									<td><?php echo $sub['credits'] ?></td>
									<td><?php echo $sub['semester'] ?></td>
									
								</tr>
										
								<?php
										$i++;
										}?>

								<tr>
									<td colspan="4"><!-- <span>Total No. of courses Registered: <b><?=count($sublist)?></b></span>><span class="pull-right">Fee to be Paid: <b>0 <!--<?=$examfees[0]['exam_fees']?>></b></span--> </td>
									
									
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
									<th>Subject Type</th>
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
									<td><input  type="checkbox" name="sub[]" id="<?php echo $backlogsublist[$i]['sub_id'] ?>" value="<?php echo $backlogsublist[$i]['sub_id'] ?>~<?php echo $backlogsublist[$i]['subject_code'] ?>~<?php echo $backlogsublist[$i]['semester'] ?>~<?php echo $backlogsublist[$i]['credits'];?>~Y" <?=$disabled?> onclick="CheckSubjectCNT(<?php echo $backlogsublist[$i]['sub_id'] ?>)" rel="<?php echo $backlogsublist[$i]['credits'];?>" class="cheksub"> 
									</td>
									<td><?php echo $k; ?> &nbsp; &nbsp;</td>
									<td><?php if(!empty($backlogsublist[$i]['subject_code'])) { echo $backlogsublist[$i]['subject_code'].' - '.$backlogsublist[$i]['subject_name']; }?></td>
									<td><?=$sub['subject_component']?> <?php if($sub['subject_component'] == 'EM'){echo '<small>('.$sub['failed_sub_type'].')</small>';} ?></td>
									
									<td><?php echo $backlogsublist[$i]['credits'] ?></td>
									<td><?php echo $backlogsublist[$i]['semester'] ?></td>
									
								</tr>
								<?php
										$k++;
										}
								?>
								<tr>
									<td colspan="5"><!-- <span>Total No. of courses Registered: <b><?=$bksubcnt?></b></span> --<span class="pull-right">Fee to be Paid: <b><span id="total_feesB"></span></b></span--> </td>
									
									
								</tr>
								</tbody>
							</table>
							</div>
							</div>
						</div>
						<?php }else{ 
							// for backlog supplimentry exam papers
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
									<th>Subject Type</th>
									
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
							<!--input type="hidden" name="failed_sub_type" value="<?php echo $sub['failed_sub_type'] ?>" -->
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
									<td><input type="checkbox" name="sub[]" id="<?php echo $sub['sub_id'] ?>" value="<?php echo $sub['sub_id'] ?>~<?php echo $sub['subject_code'] ?>~<?php echo $sub['semester'] ?>~<?php echo $sub['credits'];?>~Y" <?=$applied?>  onclick="CheckSubjectCNT(<?php echo $sub['sub_id'] ?>)" rel="<?php echo $sub['credits'];?>" class="cheksub"></td>
									<td><?php echo $i; ?> &nbsp; &nbsp;</td>
									
									<td><?php echo $sub['subject_code'].' - '.$sub['subject_name']; ?></td>
									<td><?=$sub['subject_component']?> <?php if($sub['subject_component'] == 'EM'){echo '<small>('.$sub['failed_sub_type'].')</small>';} ?></td>
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
							if($emp[0]['course_type']=='UG' || $emp[0]['course_type']=='DIPLOMA'){
									$dpay=400;
							}
							else{
								$dpay=600;
							}
							?>
							
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
									<div class="row"> <b>Note :</b> <ul><li>For correction in Subject Appearing. Please contact to the HOD.</li>
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
								if($role_id ==15 || $role_id ==6 || $role_id ==4 || $role_id ==65 ){		
								?>
								<div class="col-sm-3"></div>
								<div class="col-sm-1"><img src="<?=base_url()?>Spinner-3.gif" class="loader" style="display:none"></div>
								<div class="col-sm-1" >
									<input type="submit" name="save" id="save" value="Submit" class="btn btn-primary" style="margin-bottom: 10px;" onclick="return validatechk()">
									<input type="submit" name="pay" id="pay" value="Pay" style="display:none" class="btn btn-primary" style="margin-bottom: 10px;" onclick="return validatechk()>
									<!--onclick="return validatechk()"-->
								</div>
								<div class="col-sm-2"><button class="btn btn-primary pull-left" id="btn_cancel" type="button" onclick="window.location='<?php echo base_url($currentModule) ?>/search_exam_form'">Cancel</button></div>	
								<?php
								}
								/*}
							  else
								{
								} */?>							
								</div>
							</div>
							<?php }else{
								$stdprn= base64_encode($emp[0]['enrollment_no']);
								echo "<span style='color:red'>You are not applicable to submit the examination form. Please contact to the COE department.</span>";//special supplementary 
								if($role_id ==15 || $role_id ==6){
								echo '<a href="https://erp.sandipuniversity.com/examination/edit_exam_form_contocoe/'.$stdprn.'" title="View" target="_blank"><span class="btn btn-primary">Update Arrears</span> </a>';
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
/*
function CheckSubjectCNT(subid){

	var sublist = $("[name='sub[]']:checked").length;
	var app_fee = '<?=$dpay?>';
	var exam_type = '<?=$exam[0]['exam_type']?>';
	//alert(app_fee);
	var degree_fees = parseInt('<?=$degree_fees?>');
	var late_fees = parseInt('<?=$late_fees?>');
	//var late_fees = 100;
	//alert(late_fees);
	var appl_fees = (app_fee * sublist);
	var tot_fee = parseInt(degree_fees +late_fees+(app_fee * sublist));
	 //alert(tot_fee);

	
	if(exam_type=='Regular'){
		$('#total_feesB').html(tot_fee);
		//var totfees = parseInt('<?=$examfees[0]['exam_fees']?>')+tot_fee;
		var totfees = tot_fee;
		var totfees_encode = btoa(tot_fee);
	}else{
		var totfees = tot_fee;
		var totfees_encode = btoa(tot_fee);
	}
	//alert(totfees);
	$('#total_fees').html("Total fees to be paid (Late Fine: "+late_fees+"+Backlog Fees: "+appl_fees+"+Degree Fees: "+degree_fees+")= "+totfees);
	$('#applicable_fee').val(totfees);
	$('#examaname').val(totfees_encode);
	
	
	
	
	
	if(totfees >0){
	  $("#save").css("display", "none");
      $("#pay").css("display", "block");	  
	}
	if(totfees <= 0){
	  $("#pay").css("display", "none");
	  $("#save").css("display", "block");
	}
	var total = 0;//parseInt('<?=$june_exam_credits?>'); // credits changed 0 to june exam
	//alert(total);
      $('input:checkbox:checked').each(function(){
       total += isNaN(parseInt($(this).attr("rel"))) ? 0 : parseInt($(this).attr("rel"));
      });   
  
    // alert(total);
	var tot_credits ='<?=$max_credits?>';
	//alert();
	var admstream_id = parseInt('<?=$admstream_id?>');
	/*var prn11 ='<?=$emp[0]['enrollment_no'] ?>';
	if(prn11 =='180110021059'){
		alert(admstream_id);
	}*/
	//alert(admstream_id);
	/*if(admstream_id ==116 || admstream_id ==119){
		return true;
	}else{		
		if(total > parseInt(tot_credits)){
			// alert(total);
			alert("Maximum(<?=$max_credits?>) credits Limit excceds, please uncheck some subjects");
			$('input:checkbox:not(:checked)').attr('disabled', 'disabled');
			//alert(subid);
			if($("#"+subid).prop("checked") == true){
					//alert("Checkbox is checked.");
					//alert(app_fee)
					var totfees_updated = totfees-app_fee;
					//alert(totfees_updated);
					var totfees_encode_up = btoa(totfees_updated);
					$('#total_fees').html("Total fees to be paid: "+totfees_updated);
					//$('#total_feesB').html("Fees to be paid: "+totfees_updated);
					$("#"+subid).prop("checked", false);
					$('#applicable_fee').val(totfees_updated);
					
					$('#examaname').val(totfees_encode_up);
				}
				else if($("#"+subid).prop("checked") == false){
					//alert("Checkbox is unchecked.");
					
				}
			 return false;		 
		}else{
			return true;		
		}
	}
	
}*/
function CheckSubjectCNT(subid) {
    var sublist = $("[name='sub[]']:checked").length;
    var app_fee = parseInt('<?=$dpay?>');
    var exam_type = '<?=$exam[0]['exam_type']?>';
    var degree_fees = parseInt('<?=$degree_fees?>');
    var late_fees = parseInt('<?=$late_fees?>');
    var appl_fees = app_fee * sublist;
    var tot_fee = degree_fees + late_fees + appl_fees;

    var totfees = tot_fee;
    var totfees_encode = btoa(tot_fee);

    $('#total_fees').html("Total fees to be paid (Late Fine: " + late_fees + " + Backlog Fees: " + appl_fees + " + Degree Fees: " + degree_fees + ") = " + totfees);
    $('#applicable_fee').val(totfees);
    $('#examaname').val(totfees_encode);

    if (totfees > 0) {
        $("#save").hide();
        $("#pay").show();
    } else {
        $("#pay").hide();
        $("#save").show();
    }

    // 🔹 Calculate selected credits
	var total = 0;
      $('input:checkbox:checked').each(function(){
       total += isNaN(parseInt($(this).attr("rel"))) ? 0 : parseInt($(this).attr("rel"));
      });   
	// alert(total);

    var tot_credits = parseInt('<?=$max_credits?>');
    var admstream_id = parseInt('<?=$admstream_id?>');

    if (admstream_id == 116 || admstream_id == 119) {
        return true;
    } else {
        // 🔹 Remaining credits allowed
        var remaining = tot_credits - total;
		//alert(total);
        if (remaining < 0) {
            // Exceeded limit
            alert("Maximum (" + tot_credits + ") credits limit exceeded. Please uncheck some subjects.");
            $('input[name="sub[]"]:not(:checked)').attr('disabled', true);

            // Uncheck the last clicked subject
            if ($("#" + subid).prop("checked")) {
                $("#" + subid).prop("checked", false);

                var updated_fee = totfees - app_fee;
                var updated_fee_encode = btoa(updated_fee);

                $('#total_fees').html("Total fees to be paid: " + updated_fee);
                $('#applicable_fee').val(updated_fee);
                $('#examaname').val(updated_fee_encode);
            }
            return false;
        } else if (remaining <= 3) {
            // 🔹 Allow subjects until limit exceeds (≤3 difference)
            $('input[name="sub[]"]').removeAttr('disabled');
        } else {
            // 🔹 Enough credit available — enable all
            $('input[name="sub[]"]').removeAttr('disabled');
        }
        return true;
    }
}




function validatechk(){

	var sublist = $("[name='sub[]']:checked").length;
	//alert(sublist);
	var bksubcnt = '<?=$bksubcnt?>';
	//alert('inside');
	if(bksubcnt !='0'){
		if (!sublist){
			alert("Please check at least one checkbox from Subjects List"); //commented for sunstone students
			return false;
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
  
    alert(total);
	var tot_credits ="44";
	var admstream_id1 =parseInt('<?=$admstream_id?>');
	//alert(admstream_id);
	if(admstream_id1 ==116 || admstream_id1 ==119){
		return true;
	}else{
		if(total > parseInt(tot_credits)){
			alert("Maximum(44) credits Limit excceds, please uncheck some subjects");
			//$('input:checkbox:not(:checked)').attr('disabled', 'disabled');
			$("#"+subid).prop("checked", false);
			 return false;		 
		}else{
			return true;		
		}
	}
	
	
}
    
function  donep(){ 
//alert($("#address1").val());
//$(".loader").hide();
   var payuForm = document.forms.form;
   payuForm.submit();
 //$('#payuForm').trigger('submit');

   }
   function submitPayuForm() {
	   //alert(1);
	   var sublist = $("[name='sub[]']:checked").length;
	//alert(sublist);
	 $(':input[type="submit"]').prop('disabled', true);
	var bksubcnt = '<?=$bksubcnt?>';
	//alert('inside');
	if(bksubcnt !='0'){
		if (!sublist){
			alert("Please check at least one checkbox from Subjects List"); //commented for sunstone students
			return false;
		}
	}else{
		//return true;
	}
	$('.loader').show();
	 $.ajax({
   'url' : base_url + 'Examination/add_exam_form',
   'type' : 'POST', //the way you want to send data to your URL
   'data' : $('#form').serialize(),
   'dataType': "json",
   'success' : function(data){ 
       //alert(data) 
   //probably this request will return anything, it'll be put in var "data"
   //var container = $('#feepend'); //jquery selector (get element by id)
   if(data!=''){
	   console.log(data);
	   //break;
	 if(data.amount != ''){
      //alert(data);
 
    $('#txnid').val(data.txnid);
	$('#hash').val(data.hash);
	$('#amount').val(data.amount);
	
	$('#udf1').val(data.udf1);
	//$('#udf2').val(data.udf2);
	$('#udf3').val(data.udf3);
	$('#udf4').val(data.udf4);
	$('#udf5').val(data.udf5);
	$('#address1').val(data.address1);
	$("input.cheksub").prop("disabled", !this.checked);
	/* if(productinfo=='Re-Registration'){
	 $('#amount').attr('readonly', true); 
	}else{
	$('#amount').attr('readonly', false); 
	} */
	setTimeout(function(){ donep() }, 2000);
   }
   else{
	   //alert(data.path);
	   
	   window.location.href = base_url+data.path;
   }
   }
   }
   })
	 
	 
	  return false;
	 
    
   }
</script>
