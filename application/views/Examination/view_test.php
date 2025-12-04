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
	$max_credits=36;
}else{
	$max_credits=36;
}
$role_id = $this->session->userdata('role_id');
/**************************Code for late fees calculations******************************************/
if(!empty($forms_dates)){
	//print_r($forms_dates);exit;
	$crr_date=date('Y-m-d');	
	$late_fees_date=date("Y-m-d", strtotime($forms_dates[0]['frm_latefee_date']));
	$form_end_date=date("Y-m-d", strtotime($forms_dates[0]['frm_end_date']));
	$frm_open_date=date("Y-m-d", strtotime($forms_dates[0]['frm_open_date']));
	if($crr_date < $frm_open_date){
		echo 'Exam form not opened yet. Please Wait.';exit;
	}
	if($crr_date >$late_fees_date && $crr_date <= $form_end_date){
		$diff = strtotime($crr_date) - strtotime($late_fees_date);
		$no_of_days =abs(round($diff / 86400)); 
		$late_fees=200 * $no_of_days;
		//$late_fees=100 * 4;
	}else if($crr_date > $form_end_date){
		if($role_id==15 || $role_id==4){ //roleid 4 added for time being
			$diff = strtotime($crr_date) - strtotime($late_fees_date);
			$no_of_days =abs(round($diff / 86400)); 
			$late_fees=200 * $no_of_days;
		}else{
		 $late_fees=0; echo "Last Date to be apply is over";exit;
		}		 
	}else{
		$late_fees=0;	
	}
}
$late_fees=3000;
/******************************************************************************/

$nolatefess = array(190101051039,220102451001,220102451008,220106251008,220105132158,220101062021,210105011022,210105041003,220105181002,220110011050,220110011051,220110011054,220110011020,220110011058,220110011057,200110021036,230105133014,230105131470,210105231053,'210105011038','230105131247','210110021104','210110021069','210110021009','210110021057','200110021018','200110021010','200110021002','230106271126','230106271130','230106271146','230106271123','230106271105','230106271178','230106271112','230106271115','230106271141','230106271016','230106271054','230106271044','230106271015','230106271034','230106271001','230106271043','230106271065','230106271055','230106271171','230106271163','230106271185','230106301002','220101061016','210106111004','200101051022','200101051025','200101051026','200101051029','200101051030','200101051031','200101051032','200101081001','200101091004','200101091005','200104071012','200105121009','200105121010','200105121013','200105181018','210101051002','210101051003','210101051007','210101051097','210101061002','210101061010','210101061012','210101061013','210101061015','210101091001','210101381001','210101381006','210101381008','210102011003','210102011004','210102011005','210102011011','210102011013','210102011019','210102011020','210102011023','210102011026','210102011029','210102011033','210102011036','210102011037','210102011038','210102171019','210103011010','210103011012','210104011002','210104021004','210104061003','210104061006','210104061021','210104061027','210104071002','210105011008','210105011011','210105011026','210105041004','210105131001','210105131004','210105131005','210105131007','210105131009','210105131011','210105131012','210105131013','210105131042','210105131045','210105181025','210105181051','210105231050','210105231053','210106111003','210106111004','210106111015','210106111026','210110021004','210110021005','210110021006','210110021007','210110021014','210110021015','210110021033','210110021098','220101051002','220101051005','220101051007','220101051041','220101061001','220101061014','220101091002','220101091003','220101221001','220102011004','220102011005','220102011006','220102011018','220102011019','220102011020','220102031001','220102031003','220102161014','220104051002','220104051003','220104061002','220105011001','220105131001','220105131004','220105131005','220105131006','220105131007','220105131009','220105131011','220105131052','220105131547','220105141001','220106011001','220106111001','220106111011','220109041001','220110021001','220110021003','220110021006','220110021027','220161021001','230101061017','230101081014','230102011043','230105011470','230105121028','230105131353','230105131462','230105181041','230105231402','230106111042','230106111044','230106121020','230106131010','230110021059','230110021064','230110021075','210105131016','210101051001','220101161002','220110021023','210101051096','220101051003','220101061003','210105131016','210101051001','220101161002','220110021023','210101051096','220101051003','220101061003','210101061004','220101091003','220102011003','220105121001','210101061004','210110021009','210102011040','210102011031',210105011006,210105231053,220101061002,210101051096,210105131009,220105121001,220101051007,220102011003,220101151007);


if(in_array($emp[0]['enrollment_no'], $nolatefess)){
	
	$late_fees=0;
	
}

$nolatefess1 = array(230105231371,230105231269,220105231019,220105131169,230105231122,230101461034,220105231154,220110011057,210101062037,220110011046,'230105231349','230105131194','230105231122','230105231298','230105231126','230105231003','230105231252','230105231217','230105181024','230105011415','230105231152','230105231244','230105231356','230105231038','230101461029','230105231117','230106271183','230105131444','230101081008','230105231186','230105231259','230105231387','230105231306','230105231335','230105231337','230105231370','230105131472','230105131433','230105231419','230105231293','230105232016','230105232017','230105232010','230105231382','230105231165','230102041028','230105231225','230105231173','230105231266','230105231230','230105231200','230105231072','230105231058','230105231085','230105231178','230101051029','230105121016','230105231138','230105231149','230105231147','230105231148','230105231365','230105231069','230105231171','230105231071','230105231342','230105231214','230105231080','230105231139','230105231311','230105231223','230105231218','230101091014','230105231390','230105231404','230105231041','230105231039','230105231175','230105231083','230105231208','230105231258','230105131360','230105131331','230105231260','230105231351','230105231405','230105131290','230105231316','230105231325','230105231279','230105231346','230105231348','230105131412','230105131402','230105231363','230105231371','230105231384','230105131473','230105231416','230105231156','230105231277','230105131257','230101461034','230105231403','230105231327','230105231347','230105231257','230105231233','230105231226','230105131104','230105231157','230105231143','230105231070','230105231340','230105231158','230105231159','230106271211','230105231245','230105231236','230105231241','230105231062','230105231389','230105231392','230105131407','230105231210','230105131218','230105131183','230105231212','230105231246','230105231301','230105231315','230105231237','230105231145','230105231183','230105231213','230105181026','230102041029','230105231265','230106271197','230105231222','230105231202','230105231379','230105231407','230106271159','230105231398','230105231310','230105231336','230105231269','230105231350','230105231378','230105231239','230105231305','230105231307','230106271201','230105231272','230105231304','230105231303','230105121026','230105231377','230105231326','230106301020','230105231352','230105231343','230105231359','230105231362','230101431010','230102041031','230106301023','230105231411','230105231409','230105181039','230105231406','230105231400','230105231410','230105232023','220105231117','220105231095','220105131315','220105231091','220105181041','220105231084','220106271061','220106271057','220106271058','220106271059','220106271060','220105231085','220105231101','220102011038','220105231013','220105231066','220105131141','220106271054','220105231022','220106271062','220105231114','220105231036','220105131185','220102041008','220106271030','220105231070','220106271024','220106271028','220106271063','220106271033','220106271043','220106271046','220105231069','220105131145','220105231041','220105231043','220105231057','220106271050','220105231124','220105131276','220106271069','220105231123','220105231118','220105131170','220106271071','220105231140','220106271078','220105231141','220105231135','220105231133','220105231129','220105131492','220106271072','220105231132','220105231154','220106271085','220105231153','220105231152','220105231110');

if(in_array($emp[0]['enrollment_no'], $nolatefess1)){
	
	$late_fees=500;
	
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
	if($emp[0]['current_semester']==$last_semester){
		$degree_fees='3000';//1500
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
                     <input type="hidden" name="udf4" id="udf4" value="<?php echo $emp[0]['mobile']; ?>">
                     <input type="hidden" name="udf5" id="udf5" value="<?php echo $emp[0]['stud_id']; ?>"> 
                     <input type="hidden" name="address1" id="address1" value="<?php echo $degree_fees; ?>"> 
                     <input type="hidden" name="stud_id" id="stud_id" value="<?php echo $emp[0]['stud_id']; ?>" required="required">
                     <input type="hidden" name="surl" value="<?=base_url(); ?>Online_fee/exam_success"/>
                     <input type="hidden" name="furl" value="<?=base_url(); ?>Online_fee/failure"/>
                     <!--input type="hidden" name="productinfo" id="productinfo" value="<?php echo $exam[0]['exam_month'] ?>-<?php echo $exam[0]['exam_year'] ?>_Exam_Fees" / -->
                     <input type="hidden" name="productinfo" id="productinfo" value="Examination" />
					 
					<div class="col-sm-12">
						<div class="panel">
						<div class="panel-heading"> 
                            <span class="panel-title" style="color:#FFF">Personal Details</span>
							<input type="hidden" name="applicable_fee" id="applicable_fee" value="3400">
							
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
						 if($emp[0]['nationality'] =='Indian' && ($emp[0]['admission_session']==2023 || $emp[0]['admission_session']==2022)){
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
						<input type="hidden" name="examaname" id="examaname" value="MzQwMA==">
						
						
						
						
						
						
						
						
						
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

								$bksubcnt = count($backlogsublist);
								$fin_bksubcnt = count($allsubjects) - $bksubcnt;
								$fin_bksubcnt1 = $fin_bksubcnt + $bksubcnt; 

								for($i = 0; $i < count($backlogsublist); $i++) {
									$disabled = empty($backlogsublist[$i]['subject_code']) ? "disabled='disabled'" : "";
								?>
								<tr>
									<td>
										<input type="checkbox" name="sub[]" id="<?php echo $backlogsublist[$i]['sub_id'] ?>" value="<?php echo $backlogsublist[$i]['sub_id'] ?>~<?php echo $backlogsublist[$i]['subject_code'] ?>~<?php echo $backlogsublist[$i]['semester'] ?>~<?php echo $backlogsublist[$i]['credits'] ?>~Y" <?= $disabled ?> onclick="CheckSubjectCNT(<?php echo $backlogsublist[$i]['sub_id'] ?>)" rel="<?php echo $backlogsublist[$i]['credits'] ?>" class="cheksub"> 
									</td>
									<td><?php echo $k; ?>&nbsp; &nbsp;</td>
									<td><?php if(!empty($backlogsublist[$i]['subject_code'])) { echo $backlogsublist[$i]['subject_code'] . ' - ' . $backlogsublist[$i]['subject_name']; } ?></td>
									<td>
										<?php echo $backlogsublist[$i]['subject_component']; ?> 
										<?php if($backlogsublist[$i]['subject_component'] == 'EM'){echo '<small>(' . $backlogsublist[$i]['failed_sub_type'] . ')</small>';} ?>
									</td>
									<td><?php echo $backlogsublist[$i]['credits'] ?></td>
									<td><?php echo $backlogsublist[$i]['semester'] ?></td>
								</tr>
								<?php
									$k++;
								}
								?>
								<tr>
									<td colspan="5">
										<!-- <span>Total No. of courses Registered: <b><?= $bksubcnt ?></b></span> --<span class="pull-right">Fee to be Paid: <b><span id="total_feesB"></span></b></span--> 
									</td>
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
								if($role_id ==15 || $role_id ==6 || $role_id ==4){		
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
  
    //alert(total);
	var tot_credits ='<?=$max_credits?>';
	//alert();
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
	
}

function validatechk(){

	var sublist = $("[name='sub[]']:checked").length;
	//alert(sublist);
	var bksubcnt = '<?=$bksubcnt?>';
	//alert('inside');
	if(bksubcnt !='0'){
		if (!sublist){
			//alert("Please check at least one checkbox from Subjects List"); //commented for sunstone students
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
    
function  donep(){ 
//alert($("#address1").val());
//$(".loader").hide();
   var payuForm = document.forms.form;
   requestForm = $("#form");
    requestForm.find(":Checkbox").filter(function(){ return !this.value; }).attr("disabled", "disabled");
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
			//alert("Please check at least one checkbox from Subjects List"); //commented for sunstone students
			//return false;
		}
	}else{
		//return true;
	}
	$('.loader').show();
	 $.ajax({
   'url' : base_url + 'Examination/add_exam_form_test',
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
