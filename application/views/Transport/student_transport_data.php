<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>
var enroll='<?=$this->uri->segment(3)?>';
var org='<?=$this->uri->segment(5)?>';
var academic_year='<?=$this->uri->segment(6)?>';
var sf_id='<?=$student_list['sf_id']?>';



function de_allocate_bed(f_alloc_id)
{
	if (confirm("Are you sure,Do you want to de-allocate bed for this student!")) 
	{
		$.ajax({
			'url' : base_url + 'Hostel/de_allocate_bed',
			'type' : 'POST', //the way you want to send data to your URL
			'data' : {'f_alloc_id':f_alloc_id},
			'success' : function(data){ 
				alert('de-allocated successfully!!');
				//alert(base_url+'Hostel/student_list/'+enroll+'/'+academic_year+'/'+org);
				window.location.replace(base_url+'Hostel/student_list/'+enroll+'/'+academic_year+'/'+org);
			}
		});
	} 
	else 
	{
		//txt = "You pressed Cancel!";
	}
	
}
	
   
    $(document).ready(function()
    {
        //var sf_id='<?=$student_list['sf_id']?>';
     //   alert(sf_id);
		$('#enroll').val(enroll);
$('#academic_year').val(academic_year);
$('#sf_id').val(sf_id);
$('#borg').val(org);
$('#benroll').val(enroll);
$('#bacademic_year').val(academic_year);
$('#bsf_id').val(sf_id);
		$('#boardingform').bootstrapValidator
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
				bpoint:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select boarding point'
                      },
                      required: 
                      {
                       message: 'Please select boarding point'
                      }
                     
                    }
                },
                	bccharges:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Actual fees should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Actual fees should be numeric'
                      }
                    }
                },
                
				bcharges:
                {
                     validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Applicable fees should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Applicable fees should be numeric'
                      }
                    }
				}
			}
			
		});

        $('#cancelform').bootstrapValidator
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
				charges:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Refund amount should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Refund amount  should be numeric'
                      },
                     /*  stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
                    }
                },
                	ccharges:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Cancellation Charges should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Cancellation Charges should be numeric'
                      },
                     /*  stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
                    }
                },
                
				remarks:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Cancellation remarks should not be empty'
                      }/*,
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Cancellation Fees should be numeric'
                      },
                       stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
                    }
                }
			}
			
		});
		
	$('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});			
				
	$('#doc-sub-datepicker20')
               .datepicker({
                   autoclose: true,
				   todayHighlight: true,
                   format: 'yyyy/mm/dd'
               })
               .on('changeDate', function (e) {
                   // Revalidate the date field
                 //  $('#cancelform').bootstrapValidator('revalidateField', 'date');
               }); 
	

		
	$('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});			
				
	$('#doc-sub-datepicker21')
               .datepicker({
                   autoclose: true,
				   todayHighlight: true,
                   format: 'yyyy/mm/dd'
               })
               .on('changeDate', function (e) {
                   // Revalidate the date field
                   $('#cancelform').bootstrapValidator('revalidateField', 'date');
               }); 

	
    $("#cancellation").click(function(){
		document.getElementById("cancelform").reset();
		$("#boarding_div").hide();
		$("#cancel_div").show();
		$('#sf_id').val(sf_id);
    });
	
	$("#changboarding").click(function(){
		document.getElementById("boardingform").reset();
		$("#cancel_div").hide();
		$("#boarding_div").show();
		$('#bsf_id').val(sf_id);
    });
	
	$("#bccancel").click(function(){
		$("#cancel_div").hide();
    });
	
	$("#ccancel").click(function(){
		$("#boarding_div").hide();
    });
	
	
	$("#csubmit").click(function()
	{
		var charges=$('#charges').val();
		var remarks=$('#remarks').val();
		var cdate=$('#doc-sub-datepicker20').val();
		if(charges==''||remarks==''||cdate=='')
		{
			//$("#cancellation_err").html('Please fill all Cancellation detail fields!!');
		}
		else
		{
			if (confirm("Are you sure, Do you want to cancel this facility?")) 
			{
				$.ajax({
					'url' : base_url + 'Hostel/hostel_cancellation',
					'type' : 'POST', //the way you want to send data to your URL
					'data' : {'f_alloc_id':f_alloc_id},
					'success' : function(data){ 
						alert('de-allocated successfully!!');
						//alert(base_url+'Hostel/student_list/'+enroll+'/'+academic_year+'/'+org);
						window.location.replace(base_url+'Hostel/student_list/'+enroll+'/'+academic_year+'/'+org);
					}
				});
			} 
			else 
			{
				//txt = "You pressed Cancel!";
			}
		}
	});
	
});
</script>
<?php
    $astrik1='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Transport Facility</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Facility Details</h1>
        </div>
       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <!--<div class="panel-heading">
                        <span class="panel-title">Detailed View</span>
                        
                </div>-->
				
                <div class="panel-body">
				<h4 id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
				<h4 id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
						 
						 
					<input type="hidden" name="hidacyear" id="hidacyear" value="<?=$student_list['academic_year']?>">
					<input type="hidden" name="hidfacid" id="hidfacid" value="1">
					<input type="hidden" name="cyear" id="cyear" value="<?=$student_list['current_year']?>">
					<input type="hidden" name="stud_id" id="stud_id" value="<?=$student_list['student_id']?>">
					<input type="hidden" name="fmid" id="fmid" value="">

<?php //var_dump($student_list);?>
						
						<table class="table table-bordered">
						<tr>
						  <th width="18%">PRN :</th>
						  <td><?=$student_list['enrollment_no']?></td> 
						  <th width="18%">Name :</th>
						  <td><?=$student_list['first_name']." ".$student_list['middle_name']." ".$student_list['last_name']?></td>
						</tr>
						<tr>
						  <th width="18%">Institute :</th>
						  <td><?=$student_list['organisation']?> - <?=$student_list['school_name']?></td>
						  <th width="18%">Boarding :</th>
						  <td><?=$student_list['boarding_point']?> - <?=$student_list['campus']?></td>
						</tr>
						<tr>
						 <th scope="18%">Course Name:</th><td id="prgm_id"><?php
						 if($student_list['course']==null)
						 echo $student_list['course_short_name'].' ['.$student_list['stream_short_name'].']';
						else
							echo $student_list['course'].' ['.$student_list['stream'].']';
					 ?></td>
						  <th width="18%">Current Year :</th>
						  <td><?php
							echo $student_list['current_year'];
						  ?></td>
						</tr>
						<tr>
						  <th width="18%">Academic Year:</th>
						  <td><?=$student_list['academic_year']?></td>
						  <th width="18%">Admission Year:</th>
						  <td><?=$student_list['admission_session']?></td>
						</tr>
						<tr>
						  <th width="18%">Mobile :</th>
						  <td><?=$student_list['mobile']?></td>
						  <th width="18%">Email :</th>
						  <td><?=$student_list['email']?></td>
						</tr>
						</table>

  <table class="table table-bordered">
    					<tr>
    					  <th width="15%">Academic Year</th>
    					  <!--th scope="col">Deposit </th>-->
    					   <th scope="col">Transport Fees </th>
    					  <th scope="col">Exepmted </th>
						  <th scope="col">Applicable </th>
						  <!--<th scope="col">Gym </th>
						  <th scope="col">Fine</th>
						  <th scope="col">Opening balance</th>-->
    					  <th scope="col">Amount Paid</th>
    					  <th scope="col">Remaining Balance</th>
    					 
    					  <?php
    					  if($canc_charges['canc_amount']>0)
    					  {
    					  ?>
    					    <th scope="col">Chq Cancellation Charges</th>
    					      <th scope="col">Total Outstanding</th>
    					      <?php
    					      }
    					      ?>
    					</tr>
				<?php 
				
				$act_fee=0;$exmp_fee=0;$appli=0;
			if(!empty($stud_faci_details)){
				foreach($stud_faci_details as $student_faci_details)
				{
						$applicable_fee = ((int)$student_faci_details['deposit_fees'] + (int)$student_faci_details['actual_fees']) - (int)$student_faci_details['excemption_fees'];
						
						if($this->uri->segment(6)==$student_faci_details['academic_year'])
						{ $act_fee=$student_faci_details['actual_fees'];
					$exmp_fee=$student_faci_details['excemption_fees'];
					$appli=$act_fee-$exmp_fee;}
						//$bal = (int)$student_faci_details['applicable_fee'] - (int)$get_feedetails[0]['amount'];
					  
    					//$srNo1=1;
    					
    				$actual =	isset($student_faci_details['applicable_fee']) ? $student_faci_details['applicable_fee'] : '';
    			//		$paid =isset($totfeepaid[0]['tot_fee_paid']) ? $totfeepaid[0]['tot_fee_paid'] : '';
    						//$paid =$total_fees['fee_paid'];
    						$paid =$student_faci_details['paid_amt'];
    						//echo $paid;
    					?>
    					<tr>
						    <td><?= isset($student_faci_details['academic_year']) ? $student_faci_details['academic_year'] : '' ?></td>
    						<!--<td><?= isset($student_faci_details['deposit_fees']) ? $student_faci_details['deposit_fees'] : '' ?></td>-->
    							<td><?= isset($student_faci_details['actual_fees']) ? $student_faci_details['actual_fees'] : '' ?></td>
    							<td><?= isset($student_faci_details['excemption_fees']) ? $student_faci_details['excemption_fees'] : '' ?> 
    							<?php if(strlen($student_faci_details['excem_doc_path'])>10){?>
    							<a href="<?=base_url()?>uploads/Hostel/exepmted_fees/<?=$student_faci_details['excem_doc_path']?>" class="pull-right" target="_blank"><i class="fa fa-sticky-note-o" style="font-size:24px"></i></a>
    						<?php	}?></td>
							<td><?=$applicable_fee?></td>
    					    <!--<td><?=$student_faci_details['gym_fees']?></td>
							<td><?=$student_faci_details['fine_fees']?></td>
						    <td><?=$student_faci_details['opening_balance']?></td>-->
    						
    						<td id="paid_amt1"><?=$paid?></td>
    						<td id="remaining1_amt">
    						<?=$bal = $applicable_fee - (int)$paid +(int)$student_faci_details['gym_fees']+(int)$student_faci_details['fine_fees']+(int)$student_faci_details['opening_balance'] ?>
    							
    						</td>
    					
    						 <?php
    					  if($canc_charges['canc_amount']>0)
    					  {
    					  ?>
    							<td><?php echo $can_amt = $canc_charges['canc_amount']; //$canc_charges[0]['canc_amount'] ?></td>
    							<td><?php echo $can_amt + $pend; //$canc_charges[0]['canc_amount'] ?></td>
    							<?php
    					  }
				}
			}
    							?>
    					</tr>
    						
    				  </table>	





                
					<div class="row ">
							
						<div class="col-sm-12">
							<div class="col-sm-3"></div>
													
							<div class="col-sm-6">
							    <?php
							    if($student_list['cancelled_facility']=='N')
							    {
							    ?>
							<!--<a class="btn btn-primary btn-labeled" id="changboarding"  title="Click here to change boarding">Change Boarding</a>-->	
							<a class="btn btn-primary btn-labeled" id="cancellation"  title="Click here to Cancel Transport Facility">Transport Cancel</a>	
							<?php
							    }
							    else
							    {
							?>
										<a class="btn btn-danger" id=""  title="Cancelled">Cancelled</a>	
							<?php
							    }
							?>
							
							</div>	
							
							<div class="col-sm-3"></div>
						</div>
					</div>
					</br>
					<div class="row " id="boarding_div" style="display:none;">
						<div class="col-sm-12">
							<div class="panel">
								<div class="panel-heading">
										<span class="panel-title">Boarding Change Form</span>
										<span id="boarding_err" style="padding-left:30px;color:red;"><span>
								</div>
								
								<div class="panel-body">
								<form name="boardingform" id="boardingform" action="<?=base_url($currentModule.'/boardingform_submit')?>" method="POST">
								
								<input type="hidden" id="borg" name="borg" />
								<input type="hidden" id="benroll" name="benroll" />
								<input type="hidden" id="bacademic_year" name="bacademic_year" />
								<input type="hidden" id="bsf_id" name="bsf_id" />
								<input type="hidden" id="bexcemcharges" value="<?=$exmp_fee?>" name="bexcemcharges"/>
								
                                <div class="form-group">
								 
									<label class="col-sm-3">Route Point: <?=$astrik1?> </label> 
									<div class="col-sm-3"><select class="form-control" name="Rpoint" id="Rpoint" required>
                                      <option value="">Route Point</option>
                                      <?php //echo "state".$state;exit();
                                        if(!empty($route_details)){
                                            foreach($route_details as $point){
                                                ?>
                                              <option value="<?=$point['route_id']?>"><?=$point['route_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
                                  </select>
								  </div>
								  </div>
                                
                                
                                <div class="form-group">
								 
									<label class="col-sm-3">Boarding Point: <?=$astrik1?> </label> 
									<div class="col-sm-3"><select class="form-control" name="bpoint" id="bpoint" required>
                                      <option value="">select Boarding Point</option>
                                      <?php echo "state==".$point['board_id'].'=='.$student_list['boarding_point'];
                                        if(!empty($boarding_details)){
                                            foreach($boarding_details as $point){
												if($point['boarding_point']==$student_list['boarding_point'])
												{
                                                ?>
                                              <option selected value="<?=$point['board_id']?>"><?=$point['boarding_point']?></option>  
                                            <?php 
                                                
                                            }
											else{
												
                                                ?>
                                              <option value="<?=$point['board_id']?>"><?=$point['boarding_point']?></option>  
                                            <?php 
                                                
                                            }
										  }
										}
                                      ?>
                                  </select>
								  </div>
								  </div>
								  <div class="form-group">
								  <label class="col-sm-3">Boarding Charges: <?=$astrik1?></label>
										<div class="col-sm-3">
										  <input type="text" class="form-control" id="bccharges" value="<?=$act_fee?>" name="bccharges" readonly />
										</div> 
								  </div>
									<div class="form-group">
										<label class="col-sm-3">Applicable Amount: <?=$astrik1?></label>
										<div class="col-sm-3"><input type="text" id="bcharges" name="bcharges" value="<?=$appli?>" class="form-control" /></div>                                    
									<!--	<div class="col-sm-3"><span style="color:red;"><?php echo form_error('charges');?></span></div>-->
									   			 
                         
									</div>
									
									<div class="form-group">
									<div class="col-sm-2"></div>
									<div class="col-sm-2">
									<button class="btn btn-primary form-control" id="csubmit" type="submit" >Submit</button>
									</div>
									<div class="col-sm-2">
									
									<button class="btn btn-primary form-control" id="ccancel" type="reset" >Cancel</button>
									<!--<a class="btn btn-primary btn-labeled" id="csubmit" >Submit</a>	
									<a class="btn btn-primary btn-labeled" id="ccancel" >Cancel</a>	-->
									</div>
									</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row " id="cancel_div" style="display:none;">
						<div class="col-sm-12">
							<div class="panel">
								<div class="panel-heading">
										<span class="panel-title">Cancellation Form</span>
										<span id="cancellation_err" style="padding-left:30px;color:red;"><span>
								</div>
								
								<div class="panel-body">
								<form name="cancelform" id="cancelform" action="<?=base_url($currentModule.'/cancel_faci_submit')?>" method="POST">
								
								<input type="hidden" id="enroll" name="enroll" />
								<input type="hidden" id="academic_year" name="academic_year" />
								<input type="hidden" id="sf_id" name="sf_id" />
								<input type="hidden" id="rstud_id" name="rstud_id" value="<?=$student_list['student_id']?>" />
									<div class="form-group">
										<label class="col-sm-3">Refund Amount: <?=$astrik1?></label>
										<div class="col-sm-3"><input type="text" id="charges" name="charges" class="form-control" /></div>                                    
									<!--	<div class="col-sm-3"><span style="color:red;"><?php echo form_error('charges');?></span></div>-->
									   			<label class="col-sm-3">Cancellation Charges: <?=$astrik1?></label>
										<div class="col-sm-3">
										  <input type="text" class="form-control" id="ccharges" name="ccharges" required />
										</div>  
                         
									</div>
									<div id="hidediv" style="display:none;">
									<div class="form-group">
									     <label class="col-sm-3">Payment Type <?=$astrik?></label>
									           <div class="col-sm-3">
                                    <select name="payment_type" id="payment_type" class="form-control" >
                                        <option value="">Select Payment Type</option>
									<option value="CHQ">Cheque</option>
									<option value="DD">DD</option>
									<option value="CHLN">Chalan</option>
									<option value="CASH">Cash</option>
									</select>
									  </div>
									  <label class="col-sm-3">Refund For</label>
									  <div class="col-sm-3">
                                    <select name="refund_type" id="refund_type" class="form-control" required >
                                        <option value="">Select Refund Type</option>
									<option value="C">Transport Cancellation</option>
									<option value="E">Excess Payment Received</option>
								
									
									</select>
									
									
                                    </div>
									
                                    </div>
                                    
									
									
									
									<div class="form-group">
									   <label class="col-sm-3"> Cheque/DD No./Chalan No. <?=$astrik?></label>
                                    <div class="col-sm-3">
                                      <input type="text" name="dd_no" class="form-control"  value="<?= isset($fee[0]['dd_no']) ? $fee[0]['dd_no'] : '' ?>" placeholder="Cheque/DD No./Chalan No" >
                                    </div>
									
									       <label class="col-sm-3">Dated <?=$astrik?></label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker20" name="dd_date"  value="<?= isset($fee[0]['dd_drawn_date']) ? $fee[0]['dd_drawn_date'] : '' ?>" placeholder="Date"  readonly="true"/>
                                    </div>
									
									</div>
								
										<div class="form-group">
										    
										                         <label class="col-sm-3">Bank name <?=$astrik?></label>
                                    <div class="col-sm-3">
                                     <!-- <input type="text" id="dd_bank" name="dd_bank" class="form-control" value="<?= isset($fee[0]['dd_drawn_bank_branch']) ? $fee[0]['dd_drawn_bank_branch'] : '' ?>" placeholder="Bank & Branch">-->

									<select name="dd_bank" id="dd_bank" class="form-control" >
									  <option value="">Select  Bank <?=$astrik?></option>
									  <?php
										foreach ($bank_details as $branch) {
										  echo '<option value="' . $branch['bank_id'] . '" ' . $sel . '>' . $branch['bank_name'] . '</option>';
										}
										?>
								   </select>

                                    </div>
                                    <label class="col-sm-3"> Branch Name. <?=$astrik?></label>
                                    <div class="col-sm-3">
                                      <input type="text" id="dd_bank_branch" name="dd_bank_branch" class="form-control" value="" placeholder="Branch Name" >
                                    </div>  	
									
									
									</div>
									
									
									<div class="form-group">
									         <label class="col-sm-3">College Receipt Number</label>
                                    <div class="col-sm-3">
                                          <input type="text" id="clreceipt" name="clreceipt" class="form-control" value="" placeholder="College Receipt Number" >
                                    </div>
										<label class="col-sm-3">Remarks: <?=$astrik1?></label>
										<div class="col-sm-3"><textarea type="text" id="remarks" name="remarks" class="form-control" ></textarea></div>                                    
									<!--	<div class="col-sm-3"><span style="color:red;"><?php echo form_error('remarks');?></span></div>-->
									</div>
									<div class="form-group">
									<label class="col-sm-3">Cancellation Date: <?=$astrik1?></label>
										<div class="col-sm-3">
										  <input type="text" class="form-control" id="doc-sub-datepicker21" name="date" required readonly="true"/>
										</div>
										
								
										
										
										
										
									</div> 
									</div>
									
									
									<div class="form-group">
									<div class="col-sm-2"></div>
									<div class="col-sm-2">
									<button class="btn btn-primary form-control" id="csubmit" type="submit" >Submit</button>
									</div>
									<div class="col-sm-2">
									
									<button class="btn btn-primary form-control" id="bccancel" type="reset" >Cancel</button>
									<!--<a class="btn btn-primary btn-labeled" id="csubmit" >Submit</a>	
									<a class="btn btn-primary btn-labeled" id="ccancel" >Cancel</a>	-->
									</div>
									</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					
					<?php
					if(!empty($installment)){
					?>
                   
                   	  <div class="row">
							   <div class="form-group">
							       <hr>
							       <h4>Payment History</h4>
							   
							   
					<table class="table table-bordered">
    					<tr>
    					  <th scope="col">Sr. No. </th>
    					  <th scope="col">Academic Year</th>
						  <th scope="col">Paid By</th>
    					  <th scope="col">Chq/DD No</th>
    					  <th scope="col">Rcpt No</th>
						  <th scope="col">Bank</th>
    					  <th scope="col">Branch</th>
						  <th scope="col">Dated</th>
						  <th scope="col">Amount</th>
						  
    					<!--  <th scope="col">Balance</th>
    					  
						  <th scope="col">Scan Copy</th>-->
						
    					</tr>
						<?php 
						$i=1;
						if(!empty($installment)){
							foreach($installment as $inst){
								$fee_date = date('d/m/Y',strtotime($inst['fees_date'] ));
						?>
    					<tr>
    					    <td><?=$i?></td>
    					    
    					    	<td><?=$inst['academic_year']?></td>
    					    	
							<td><?=$inst['fees_paid_type']?></td>
    						<td><?= isset($inst['receipt_no']) ? $inst['receipt_no'] : '' ?></td>
    							<td><?= $inst['college_receiptno']; ?></td>
							<td><?
							
							foreach ($bank_details as $branch) 
							{
							  if($branch['bank_id']==$inst['bank_id'])
							  {echo $branch['bank_name'];break;}
							}
							
							
							 ?></td>
    						<td><?= isset($inst['bank_city']) ? $inst['bank_city'] : '' ?></td>
							<td><?= isset($fee_date) ? $fee_date : '' ?></td>
    						<td><?=$inst['amt_paid']?></td>
    					
    					</tr>
						<?php
						$i++;
						
							}
						}else{
							echo "<tr><td colspan=8>No Data Found</td></tr>";
						}
						?>
    			
    				</table>

							   
							   
							   
							   
							   
							   
							   
							   
							   
							 </div>                      
							  </div>
                    <?php
                    }
                    ?>
                    <div id="showhost" name="showhost" style="display:none">
					<form id="exemform" name="exemform">
					<table class="table table-bordered">
						<td colspan="2" >	 
									
									      <div class="form-group">
									     <div class="col-sm-2">
									<strong>Facility Deposit </strong> </div><div class="col-sm-1"><input type="text" name="fdeposit" id="fdeposit"><br></div></div>
									  <div class="form-group">
									       <div class="col-sm-2">
									<strong>Facility Fees  </strong> </div><div class="col-sm-1"><span id="ffees"></span><br></div></div>
								 <div class="form-group">
								 <div class="col-sm-2">
									<strong>Enter Exempted fees </strong> </div><div class="col-sm-1"><input type="text" name="exem" id="exem" onchange="show_exemfile()"><br>
									</div></div>
								
									<div id="exemdiv" style="display:none">	  <div class="form-group">
								 <div class="col-sm-2">	<strong>Document supporting Exemption in Fees</strong> </div><div class="col-sm-2">
									<input type="file" name="exemfile" id="exemfile"><br> </div> </div>
									    </div>
										
										
									    <div>
									    
									<div class="form-group">
								 <div class="col-sm-2"><input type="button" class="btn btn-primary form-control"  value="Register" id="reg" name="reg">
									</div>	</div>	</div>
						</td>
					</table>
					</form>
					
					
					
                    </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
	
		
$('#charges').on('change', function() {
   
   var dat =  $("#charges").val();
    
  if(dat > 0)
  {
    $("#hidediv").show();
  }
  else{
	$("#hidediv").hide();
  }
  });

	
$('#bpoint').on('change', function () {
       
             var base_url = '<?=site_url()?>';
                   // alert(type);
				   var bpoint = $(this).val();
                   var acyear = '<?=$this->uri->segment(6)?>';
                   			
                $.ajax({
                    'url' : base_url + 'Transport/facility_fee_details',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'acyear':acyear,'fcid':2,'bpoint':bpoint},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                      //  var container = $('#showhost'); //jquery selector (get element by id)
                        if(data){
							var jdata= JSON.parse(data);
							//alert(jdata);
							 if(jdata==null)
							{
								$('#showhost').hide();
								$('#showerr').html('For current academic year, facility fee has not declared yet.');
								$('#showerr').show();
							}
							 else
							 {
								//$('#showhost').show();
								//$("#ffees").html(jdata.fees);
								boarding_fees=jdata.fees;
								$("#bccharges").val(boarding_fees);
								var exmp='<?=$exmp_fee?>';
								var applicable=boarding_fees-exmp;
								$("#bcharges").val(applicable);
                      
                            	//return false;
							 }
                        }
                          ///return false;
                    }
                });
            });


});
</script>
                    
