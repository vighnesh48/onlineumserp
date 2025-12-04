<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
.panel-heading {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc;
}
</style>

<script>
$(document).ready(function()
    {
		
		$('#doc-sub-datepicker20')
               .datepicker({
                   autoclose: true,
				   todayHighlight: true,
                   format: 'yyyy/mm/dd'
               })
               .on('changeDate', function (e) {
                   // Revalidate the date field
                   $('#makePayment').bootstrapValidator('revalidateField', 'dd_date');
               }); 
		
        $('#makePayment').bootstrapValidator
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
			/*	payfile: 
				{
					validators: {
						notEmpty: 
                      {
                       message: 'Please Upload a file'
                      },
                      required: 
                      {
                       message: 'Please Upload a file'
                      },
						file: {
							extension: 'pdf',
							type: 'application/pdf',
							maxSize: 100*1024, // 100kb
							message: 'The selected file is not valid, it should be (pdf) and 100kb at maximum.'
						}
					}
				},*/
				dd_bank:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select dd bank'
                      },
                      required: 
                      {
                       message: 'Please select dd bank'
                      }
                     
                    }
                },
                acyear:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Academic'
                      },
                      required: 
                      {
                       message: 'Please select Academic'
                      }
                     
                    }
                },
				payment_type:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select payment type'
                      },
                      required: 
                      {
                       message: 'Please select payment type'
                      }
                     
                    }
                },
				/*clreceipt:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'college receipt should not be empty'
                      }
                    }
                },*/
				dd_bank_branch:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'dd bank branch should not be empty'
                      }
                    }
                },
				dd_no:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'dd number should not be empty'
                      }
                    }
                },
				dd_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'dd date should not be empty'
                      }
                    }
                },
                paidfee:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'paidfee should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'paidfee should be numeric'
                      }
					  
					}

                }
			}       
        }) 
    });


function feevalidate()
{
    //alert("jugal");
 //   return false;
    
        var base_url = 'http://localhost/erp/';
		   // alert(type);
		   var clreceipt = $("#clreceipt").val();

                $.ajax({
                    'url' : base_url + '/Ums_admission/validate_receipt',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'clreceipt':clreceipt},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                    //    var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
                          alert(data);
                          if(data.trim()!='')  
                          {
                             alert("Receipt Number Should be Unique"); 
                              e.preventDefault();
                             return false;
                          }
                          else
                          {
                              $('#makePayment').submit();
                          }
                          
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                           // container.html(data);
                            
                        }
                       
                    }
                });
                
                 e.preventDefault();
        return false;
    
  //  alert("out");
    
  // return false;
    
    
    
    
    
    
    
    
    
}





</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
   //echo "jugal";
   //echo $total_fees['fee_paid'];
  //var_dump($canc);
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Make Payment</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
			
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Payment Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">   
						<table class="table table-bordered">
    					<tr>
    					  <th width="17%">PRN No:</th><td width="35%"><?=$student_details['enrollment_no']?></td>
    					  <th width="17%">Institute:</th><td width="35%"><?=$student_details['school_name']?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name:</th><td><?=$student_details['last_name']?> <?=$student_details['first_name']?> <?=$student_details['middle_name']?></td>
						  <th width="15%">Academic Year:</th><td><?= isset($stud_details['academic_year']) ? $stud_details['academic_year'] : '' ?></td>
						</tr>
						<tr>
    					  <th scope="col">Course Name:</th>
					<td id="prgm_id"><?php  if($student_details['course']==NULL)//echo $student_details['course_short_name'].' '.
					echo $student_details['stream_short_name'].$student_details['stream'];else echo $student_details['course'].' '.$student_details['stream']?></td>
    					  <th width="15%">Year:</th><td><?=$student_details['current_year']?></td>
    					</tr>
						</table>
						</div>
						<div class="table-info" >
										
    				    <table class="table table-bordered" style="width:100%;max-width:100%;">
    					<tr>
    					  <th width="15%">Year</th>
    					  <th scope="col">Deposit</th>
    					  <th scope="col">Hostel</th>
    					  <th scope="col">Exepm -ted</th>
						  <th scope="col">Appli- cable</th>
						  <th scope="col">Concession</th>
						  <th scope="col">Gym</th>
						  <th scope="col">Fine</th>
						  <th scope="col">Opening balance</th>
						  <th scope="col">Refund</th>
						   <?php
    					  if(isset($student_faci_details['refund_paid']) &&$student_faci_details['refund_paid']>0)
    					  {
    					  ?> 
    					      <?php
    					      }
    					      ?>
							  <th scope="col">Refund Paid</th>
						  <th scope="col">Cancel Chrgs</th>
    					  <th scope="col">Amount Paid</th>
    					  	  <th scope="col">Outstand Amount</th>
							  
							 
							  
							 
							  
							  
    					  	  <?php
    					  /*if($student_faci_details['cancellation_refund']>0)
    					  {
    					  ?>
    				
    					      <th scope="col">Amount Refund</th>
    					        <th scope="col">Overall Fees</th>
    					      <?php
    					      }*/
    					      ?>
    				
    					  <th scope="col">Action</th>
    					  <?php
    					 /* if($canc_charges['canc_amount']>0)
    					  {
    					  ?>
    					    <th scope="col">Chq Cancellation Charges</th>
    					      <th scope="col">Total Outstanding</th>
    					      <?php
    					      }*/
    					      ?>
    					</tr>
    					<?php 
					if(!empty($stud_faci_details)){
						//echo '<pre>'; print_r($stud_faci_details);
						foreach($stud_faci_details as $student_faci_details)
						{
								
							$applicable_fee = ((int)$student_faci_details['deposit_fees'] + (int)$student_faci_details['actual_fees']) - (int)$student_faci_details['excemption_fees'];

							$actual =	isset($student_faci_details['applicable_fee']) ? $student_faci_details['applicable_fee'] : '';
							
							//$paid =$total_fees['fee_paid'];
							$paid =$student_faci_details['paid_amt'];
							//echo $paid;
							?>
							<tr>
							<td><?= isset($student_faci_details['academic_year']) ? $student_faci_details['academic_year'] : '' ?></td>
							<td><?= isset($student_faci_details['deposit_fees']) ? $student_faci_details['deposit_fees'] : '' ?></td>
								<td><?= isset($student_faci_details['actual_fees']) ? $student_faci_details['actual_fees'] : '' ?></td>
								
								<td><?= isset($student_faci_details['excemption_fees']) ? $student_faci_details['excemption_fees'] : '' ?> 
								<?php if(strlen($student_faci_details['excem_doc_path'])>10){?>
								<a href="<?=base_url()?>uploads/Hostel/exepmted_fees/<?=$student_faci_details['excem_doc_path']?>" class="pull-right" target="_blank"><i class="fa fa-sticky-note-o" style="font-size:24px"></i></a>
							<?php	}?></td>
							
							<td><?=$applicable_fee?></td>
							<td><?= isset($student_faci_details['concession_fees']) ? $student_faci_details['concession_fees'] : '' ?> <?php if(strlen($student_faci_details['conce_doc_path'])>10){?>
								<a href="<?=base_url()?>uploads/Hostel/concession_fees/<?=$student_faci_details['conce_doc_path']?>" class="pull-right" target="_blank"><i class="fa fa-sticky-note-o" style="font-size:24px"></i></a>
							<?php	}?></td>
							<td><?=$student_faci_details['gym_fees']?></td>
							<td><?=$student_faci_details['fine_fees']?></td>
							<td><?=$student_faci_details['opening_balance']?></td>
							<td><?=$student_faci_details['refund']?></td>
							<?php
    					  if(isset($student_faci_details['refund_paid']) &&$student_faci_details['refund_paid']>0 && $student_faci_details['refund_for']!='D')
    					  {
    					  ?> <th scope="col"><?=$student_faci_details['refund_paid']?></th>
    					      <?php
    					      }else{
    					      ?>
							  <th scope="col"></th>
							  <?php } ?>
							<td><?=$student_faci_details['cancellation_charges']?></td>
							
							<td id="paid_amt1"><?=$paid?>
								<?php 
																
								if($student_faci_details['refund_paid']==0)
								$bal = ($applicable_fee +(int)$student_faci_details['gym_fees']+(int)$student_faci_details['fine_fees']+(int)$student_faci_details['opening_balance']+(int)$student_faci_details['refund_paid'])
								-
								((int)$paid + (int)$student_faci_details['cancellation_charges']);
								else if($student_faci_details['refund_paid']>0)
									//echo 'paid -'.(int)$paid.', cancellation_charges-'.(int)$student_faci_details['cancellation_charges'].', refund_paid-'.(int)$student_faci_details['refund_paid'].', applicable_fee-'.$applicable_fee;
									//$bal=((int)$student_faci_details['refund_paid']+(int)$student_faci_details['cancellation_charges'])-(int)$paid ;
								//Canac//	
								if($student_faci_details['cancelled_facility']=='Y'){
									//echo '1';
										$bal=(int)$paid-(int)$student_faci_details['opening_balance']-(int)$student_faci_details['cancellation_charges']-(int)$student_faci_details['refund_paid'];
										//95000-0-10000 =85000;
									}else if($student_faci_details['refund_for']=='D'){
										//for deposite refund
										//echo 'AP-'.$applicable_fee; echo 'PAId-'.$paid;echo 'OP_'.(int)$student_faci_details['opening_balance']; echo 'Ch_'.(int)$student_faci_details['cancellation_charges'];
										$bal=(int)$paid-($applicable_fee+(int)$student_faci_details['opening_balance']);
									}else{
										//echo '2';
										//echo 'AP-'.$applicable_fee; echo 'PAId-'.$paid; echo 'OP_'.(int)$student_faci_details['opening_balance']; echo 'Ch_'.(int)$student_faci_details['cancellation_charges'];
										$bal = ($applicable_fee - (int)$paid )+(int)$student_faci_details['opening_balance']+((int)$student_faci_details['refund_paid']);
									}
									//+((int)$student_faci_details['refund_paid']+
									//(int)$student_faci_details['cancellation_charges'] +
									//)-
									//(int)$paid ;
									
								?>
																
								

							</td>

								<td id="remaining1_amt">
							<?= $bal?>
							</td>
									  <?php
							/*if($student_faci_details['cancellation_charges']>0)
							{
							  $bal =  $bal - $student_faci_details['cancellation_charges']; 
							?>

							  <td scope="col"><?=$student_faci_details['cancellation_charges']?></td>
								  <td scope="col"><?= $applicable_fee -$student_faci_details['cancellation_charges']?></td>
								  
								  
							  <?php
							  }*/
							  ?>


							<td>
							    <?php if($student_faci_details['academic_year']==$stud_details['academic_year'])
							{
								?>
								<a class="marksat" id="editpayment" data-stud_id="<?= $student_faci_details['sf_id']; ?>" data-file="<?=$student_faci_details['excem_doc_path']?>" data-concefile="<?=$student_faci_details['conce_doc_path']?>" data-deposite="<?= $student_faci_details['deposit_fees']; ?>" data-excemption_fees="<?= $student_faci_details['excemption_fees']; ?>" data-concession_fees="<?= $student_faci_details['concession_fees']; ?>" data-gym_fees="<?= $student_faci_details['gym_fees']; ?>" data-pending_balance="<?= $student_faci_details['fine_fees']; ?>"  data-opening_balance="<?= $student_faci_details['opening_balance']; ?>"data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button class="btn btn-primary btn-xs">Edit</button></a>
						<?php
							}
						?>
						
							</td>
							 <?php
							/*if($canc_charges['canc_amount']>0)
							{
							?>
								<td><?php echo $can_amt = $canc_charges['canc_amount']; //$canc_charges[0]['canc_amount'] ?></td>
								<td><?php echo $can_amt + $pend; //$canc_charges[0]['canc_amount'] ?></td>
								<?php
							}*/
						  
						}
						
					}
    							?>
    					</tr>
    						
    				  </table>
						</div>
					
					  <div class="table-info"> 
					  
					  <div class="panel">
					  <div class="panel-heading">
                        <span class="panel-title">Fees paid Details</span>
						</div>
						<div class="panel-body" >
					  <table class="table table-bordered" style="width:100%;max-width:100%;">
    					<tr>
    					  <th scope="col">Sr. No. </th>
    					    <th scope="col">Academic Year</th>
						  <th scope="col">Paid By</th>
    					  <th scope="col">Chq/DD No</th>
    					  <th scope="col">Rcpt No</th>
						  <th width="15%">Bank</th>
    					  <th scope="col">Branch</th>
						  <th scope="col">Dated</th>
						  <th scope="col">Amount</th>
						  <th scope="col">Deducted Amount</th>
						  <th scope="col">Cancel Charges</th>
						  <th scope="col">Status</th>
    					<!--  <th scope="col">Balance</th>
    					  
						  <th scope="col">Scan Copy</th>-->
						
						   <th width="15%">Action</th>
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
							<td style="width: 250px;"><?
							
							foreach ($bank_details as $branch) 
							{
							  if($branch['bank_id']==$inst['bank_id'])
							  {echo $branch['bank_name'];break;}
							}
							
							
							 ?></td>
    						<td><?= isset($inst['bank_city']) ? $inst['bank_city'] : '' ?></td>
							<td><?= isset($fee_date) ? $fee_date : '' ?></td>
    						<td><?=$inst['amt_paid']?></td>
							<td><?=$inst['deduct_amount']?></td>
    							<td><?=$inst['canc_charges']?></td>
									
    						<td><?php if($inst['chq_cancelled']=='N'){echo "Accepted";}else if($inst['chq_cancelled']=='Y'){echo "Cancelled";}else { if($inst['refund_for']=='D'){ echo "Deposit Refund";}else{ echo "Refund";}}?></td>
    	
						<!--	<td><?=$inst['balance_fees']?></td>-->
							
    						
						<!--	<td>
							<?php 
							if(!empty($inst['receipt_file'])){
								?>
								<a href="<?=base_url()?>uploads/student_challans/<?=$inst['receipt_file']?>" target="_blank">View</a>
							<?php }else{
								echo "No";
							}?>
							</td>-->
	<td>
	 <?php if($inst['academic_year']==$stud_details['academic_year'] && $inst['chq_cancelled']!='')
							{
								?>
	<input type="button" value="Edit" name="<?=$inst['fees_id']?>" id="editp" onclick="valid('<?=$inst['fees_id']?>')" class="btn btn-primary btn-xs">&nbsp;<input type="button" value="Del" name="<?=$inst['fees_id']?>" id="delete" onclick="delete_record('<?=$inst['fees_id']?>')" class="btn btn-primary btn-xs">
					<?php
							}
						?>
	</td>
    					</tr>
						<?php
						$i++;
						
							}
						}else{
							echo "<tr><td colspan=8>No Data Found</td></tr>";
						}
						?>
    					<tr>
						<?php
						/*
						if((!empty($minbalance[0]['min_balance']) && $minbalance[0]['min_balance'] > 0)){
						if((empty($minbalance[0]['min_balance']) || //$minbalance[0]['min_balance'] > 0))
							*/{
							    //	if($canc['can_charges']=='')
				//	{
							?>	
							<td colspan="12" align="center"><input type="button" name="make Payment" id="pmnt" value="Make Payment" class="btn btn-primary" ><input type="button" name="Make Refund" id="refundpmnt" value="Make Refund" class="btn btn-primary" /></td>
							<?php
				//	}
							?>
    				<!--/*	<?php }?>	*/-->
    						
    					</tr>	
    				  </table>

                        </div>
                    </div>
                   </div> 
					<?php
					//print_r($canc);
					if($canc['can_charges']!='')
					{
					?>
					  <div class="panel">
					  <div class="panel-heading">
                        <span class="panel-title" style="color:red">Cancellation Details</span>
						</div>
						<div class="panel-body">
					  <table class="table table-bordered">
    					<tr>
    					
						<th scope="col">Academic Year</th>
						  <th scope="col">cancellation Date</th>
						  <th scope="col">Refund Amount</th>
						  		  <th scope="col">Cancellation Charges</th>
							  <th scope="col">Remark</th>
    					<!--  <th scope="col">Balance</th>
    					  
						  <th scope="col">Scan Copy</th>-->
						
						 
    					</tr>
						<tr>
						<td><?=$canc['academic_year']?></td>
						<td><?=date('d-m-Y',strtotime($canc['can_date']))?></td>
						<td><?=$canc['refund_amount']?></td>
						<td><?=$canc['can_charges']?></td>
							
						<td><?=$canc['remark']?></td>
		
						</tr>
					
    				  </table>

                        </div>
                    </div>
                    
                    
					<?php
					}
					?>
					

                    <div class="panel" id="refundmakepmnt" style="display:none">
                            <div class="panel-heading">
								<span class="panel-title">Make Refund</span>
							</div>
                                <div class="panel-body">
								<form name="RefundPayment" id="RefundPayment" onsubmit="" method="POST" action="<?=base_url()?>Hostel/Refund_payment" enctype="multipart/form-data">
								<?php
									$rstudId = $this->uri->segment(4);
									$rinstute = $this->uri->segment(5);
								?>
								<input type="hidden" name="renrollment_no" value="<?=$student_details['enrollment_no']?>">
								
								<input type="hidden" name="rstud_id" value="<?=$rstudId?>">
								
								 <input type="hidden" name="rorg" value="<?=$rinstute?>">
                                  <div class="form-group">
                                    <label class="col-sm-3">Refund For</label>
                                    <div class="col-sm-3">
                                    <select name="refund_type" id="refund_type" class="form-control" required>
                                        <option value="">Select Refund Type</option>
									<option value="C">Hostel Cancellation</option>
									<option value="E">Excess Payment Received</option>
									<option value="D">Hostel Deposit</option>
									</select>
									</div>
									
                                  </div>
								  <div class="form-group"> 
									<label class="col-sm-3">Refund of Rs</label>
                                    <div class="col-sm-3">
                                      <input data-bv-field="rpaidfee" id="rpaidfee" name="rpaidfee" class="form-control numbersOnly" value="" placeholder="Refund Amount" type="text" required>
                                    </div>
									<label class="col-sm-3">Deducted Amount</label>
                                    <div class="col-sm-3">
                                      <input data-bv-field="deductfees" id="deductfees" name="deductfees" class="form-control numbersOnly" value="" placeholder="Deducted Amount" type="text" required>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                      
                                           <label class="col-sm-3">Refund Mode</label>
                                    <div class="col-sm-3">
                                    <select name="rpayment_type" id="rpayment_type" class="form-control" required>
                                        <option value="">Select Payment Type</option>
									<option value="CHQ">Cheque</option>
									<option value="DD">DD</option>
									<option value="CHLN">Chalan</option>
									
									</select>
									
									
                                    </div>
								
								   <label class="col-sm-3"> Cheque/DD No./Chalan No.</label>
                                    <div class="col-sm-3">
                                      <input type="text" name="rdd_no" class="form-control"  placeholder="Cheque/DD No./Chalan No" required>
                                    </div>
									
                                  
                                  </div>
                                  <div class="form-group">
                                      
                                       <label class="col-sm-3">Dated</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="rdoc-sub-datepicker20" name="rdd_date" value="" placeholder="Date" required readonly="true"/>
                                    </div>
                                    
                                    <label class="col-sm-3">Bank name</label>
                                    <div class="col-sm-3">
                                     
									<select name="rdd_bank" id="rdd_bank" class="form-control" required>
									  <option value="">Select</option>
									  <?php
										foreach ($bank_details as $branch) {
										  
											echo '<option value="' . $branch['bank_id'] . '" ' . $sel . '>' . $branch['bank_name'] . '</option>';
										}
										?>
								   </select>

                                    </div>
                                   
                                  </div>
                                  
                                  <div class="form-group">
                                      
                                       <label class="col-sm-3"> Branch Name.</label>
                                    <div class="col-sm-3">
                                      <input type="text" id="rdd_bank_branch" name="rdd_bank_branch" class="form-control" value="" placeholder="Branch Name" required>
                                    </div>
                                    
								   <label class="col-sm-3">Upload document</label>
                                    <div class="col-sm-3"><input type="file" name="rpayfile"></div>
                                    
                                  </div>
                                 
                                 <div class="form-group">
                                  <label class="col-sm-3">Academic Year</label>
                                    <div class="col-sm-3">
                                    <select name="racyear" id="racyear" class="form-control col-sm-3" required>
									  <option value="">Academic Year</option>
									   
										<?php //echo "state".$state;exit();
										if(!empty($academic_details)){
											foreach($academic_details as $academic){
												$arr=explode("-",$academic['academic_year']);
												$ac_year=$arr[0];
												if($academic['status']=='Y')
												{
												?>
											  <option selected value="<?=$ac_year?>"><?=$academic['academic_year']?></option>  
											<?php 
												}else{
												?>
												<option value="<?=$ac_year?>"><?=$academic['academic_year']?></option> 
												<?php
												}
												
											}
										}
									  ?>
								  </select>
                                    </div>
                                    <label class="col-sm-3">Remark</label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control" id="rremark" name="rremark"></textarea>
                                    </div>
                                    
                                    
                                    </div>
                                 
								  <div class="form-group">
								      
								      
								   <label class="col-sm-4"></label> 
								   <div class="col-sm-2"><button type="submit" name="rMake_Payment" value="Make Payment" class="btn btn-primary">Submit</button> </div>
									<div class="col-sm-2">
								  <button type="button" name="Cancel" value="Cancel" id="closerefundpymt" class="btn btn-primary">Cancel</button></div>

                                   
                                      <label class="col-sm-3"></label> 
                                  </div>
                                  </form>
                                </div>
                            </div>
										  <!-------jjjjjjjjjjjj----------------------------------------------------------------------------------------------------------------------->
					  <div class="panel" id="makepmnt" style="display:none">
                            <div class="panel-heading">
								<span class="panel-title">Make Payment</span>
							</div>
                                <div class="panel-body">
								<form name="makePayment" id="makePayment" onsubmit="" method="POST" action="<?=base_url()?>Hostel/pay_Installment" enctype="multipart/form-data">
								<?php
									$studId = $this->uri->segment(4);
									$instute = $this->uri->segment(5);
								?>
								     <div class="form-group">
                                    <label class="col-sm-3">Academic Year <?=$astrik?></label>
                                            <div class="col-sm-3">
											<select name="acyear" id="acyear" class="form-control col-sm-3" required>
									  <option value="">Academic Year</option>
									   
										<?php //echo "state".$state;exit();
										if(!empty($academic_details)){
											foreach($academic_details as $academic){
												$arr=explode("-",$academic['academic_year']);
												$ac_year=$arr[0];
												if($academic['status']=='Y')
												{
												?>
											  <option selected value="<?=$ac_year?>"><?=$academic['academic_year']?></option>  
											<?php 
												}else{
												?>
												<option value="<?=$ac_year?>"><?=$academic['academic_year']?></option> 
												<?php
												}
												
											}
										}
									  ?>
								  </select>
											
												
									
									</div>
									</div>
                                    
                                  <div class="form-group">
                                    <label class="col-sm-3">Payment of Rs <?=$astrik?></label>
                                    <div class="col-sm-3">
                                      <input data-bv-field="paidfee" id="paidfee" name="paidfee" class="form-control numbersOnly" value="" placeholder="Paid Fee" type="text" required>
									  <input type="hidden" name="no_of_installment" value="<?= isset($noofinst[0]['max_no_installment']) ? $noofinst[0]['max_no_installment'] : '' ?>">
									  <input type="hidden" name="enrollment_no" value="<?=$student_details['enrollment_no']?>">
									  <input type="hidden" name="stud_id" value="<?=$studId?>">
									  <input type="hidden" name="org" value="<?=$instute?>">
									  <input type="hidden" name="min_balance" value="<?= isset($minbalance[0]['min_balance']) ? $minbalance[0]['min_balance'] : '' ?>">
									  
									   <input type="hidden" name="actfee" value="<?= isset($student_faci_details['applicable_fee']) ? $student_faci_details['applicable_fee'] : '' ?>">
                                    </div>
                                    <label class="col-sm-3">Payment Type <?=$astrik?></label>
                                    <div class="col-sm-3">
                                    <select name="payment_type" id="payment_type" class="form-control" required onchange="display()">
                                        <option value="">Select Payment Type</option>
									<option value="CHQ">Cheque</option>
									<option value="DD">DD</option>
									<option value="CHLN">Chalan</option>
									<option value="CASH">Cash</option>
									<option value="ITF">ITF</option>
									</select>
									
									
                                    </div>
                                  </div>
								  
								  <div id="noncash">
                                  <div class="form-group">
								 
								   <label class="col-sm-3"> Cheque/DD No./Chalan No. <?=$astrik?></label>
                                    <div class="col-sm-3">
                                      <input type="text" name="dd_no" class="form-control" required value="<?= isset($fee[0]['dd_no']) ? $fee[0]['dd_no'] : '' ?>" placeholder="Cheque/DD No./Chalan No" required>
                                    </div>
									
                                    <label class="col-sm-3">Dated <?=$astrik?></label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker20" name="dd_date" required value="<?= isset($fee[0]['dd_drawn_date']) ? $fee[0]['dd_drawn_date'] : '' ?>" placeholder="DD Date" required readonly="true"/>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                      
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">Bank name <?=$astrik?></label>
                                    <div class="col-sm-3">
                                     <!-- <input type="text" id="dd_bank" name="dd_bank" class="form-control" value="<?= isset($fee[0]['dd_drawn_bank_branch']) ? $fee[0]['dd_drawn_bank_branch'] : '' ?>" placeholder="Bank & Branch">-->

									<select name="dd_bank" id="dd_bank" class="form-control" required>
									  <option value="">Select DD Bank <?=$astrik?></option>
									  <?php
										foreach ($bank_details as $branch) {
										  echo '<option value="' . $branch['bank_id'] . '" ' . $sel . '>' . $branch['bank_name'] . '</option>';
										}
										?>
								   </select>

                                    </div>
                                    <label class="col-sm-3"> Branch Name. <?=$astrik?></label>
                                    <div class="col-sm-3">
                                      <input type="text" id="dd_bank_branch" name="dd_bank_branch" class="form-control" value="" placeholder="Branch Name" required>
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
								   <label class="col-sm-3">Upload document </label>
                                    <div class="col-sm-3"><input type="file" name="payfile"></div>
                                     <label class="col-sm-3">College Receipt Number</label>
                                    <div class="col-sm-3">
                                          <input type="text" id="clreceipt" name="clreceipt" class="form-control" value="" placeholder="College Receipt Number" >
                                    </div>
                                  </div>
                                </div>
                                    <div class="form-group">
                                        
                                          <label class="col-sm-3">Next Payment Date</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker41" name="npdate"  value="<?= isset($fee[0]['next_payment_date']) ? $fee[0]['next_payment_date'] : '' ?>" placeholder="Next Payment Date"  readonly="true"/>
                                    </div>
								       <label class="col-sm-3">Remark</label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control" id="remark" name="remark"></textarea>
                                    </div>
                                    </div>
								  <div class="form-group">
								      
								      
								   <label class="col-sm-5"></label> 
                                    <div class="col-sm-2"><button type="submit" name="Make_Payment" value="Make Payment" class="btn btn-primary">Make Payment</button></div>
									<div class="col-sm-2"><button type="button" name="Cancel" value="Cancel" id="closemakepymt" class="btn btn-primary">Cancel</button>
                                    </div>
                                  </div>
                                  </form>
                                </div>
                            </div>
                            
                            
                            
                            
                            <div id="edit_fee">
                                
                                
                                </div>

                         </div>
						 <!------------------------------------------------------------------------------------------------------------------------------------------------->

                </div>
            </div>    
        </div>
    </div>
    
        <!-- Modal -->
<div class="modal fade" id="walkinModal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                
                <h4 class="modal-title" id="myModalLabel">
                   <span id="fform_id">Edit Fees</span>
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked" style="margin-top: 10px;">
                                    <div class="panel-body">
                                        <form name="editfrm" method="POST" action="<?=base_url()?>Account/updatePayment" enctype="multipart/form-data" onsubmit="return validate()">
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Deposite </label>
                                             <div class="col-sm-6"> 
                                                <input type="text" name="fdeposite" id="fdeposite" class="form-control" required>
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Gym Fees </label>
                                             <div class="col-sm-6"> 
                                                <input type="text" name="fgym_fees" id="fgym_fees" value="" class="form-control" required /> 
                                                <input type="hidden" name="fstud_id" class="form-control" id="fstud_id" style="width:50%"/>
                                                <input type="hidden" name="enrollment_no" value="<?=$student_details['enrollment_no']?>">
    									        <input type="hidden" name="student_id" value="<?=$studId?>">
    									        <input type="hidden" name="org" value="<?=$instute?>">
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Exempted fees </label>
                                             <div class="col-sm-6"> 
                                                <input type="text" name="exem" id="exem" class="form-control" onchange="show_exemfile()">
                                            </div>
                                        </div> 
										<div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Concession fees </label>
                                             <div class="col-sm-6"> 
                                                <input type="text" name="concession" id="concession" value="0" class="form-control" onchange="show_concefile()">
                                            </div>
                                        </div> 
                                        <div id="exemdiv" style="display:none">	  
                                            <div class="form-group">
                                                <label class="col-sm-3" for="exampleInputEmail1">Document supporting Exemption in Fees</label>
								                <div class="col-sm-6">
									                <input type="file" name="exemfile" id="exemfile" onchange="return validate()"><span id="efspan"></span>
									            </div> 
									       </div>
									    </div>
										<div id="concediv" style="display:none">	  
                                            <div class="form-group">
                                                <label class="col-sm-3" for="exampleInputEmail1">Document supporting Concession in Fees</label>
								                <div class="col-sm-6">
									                <input type="file" name="concefile" id="concefile" onchange="return validate1()"><span id="efspan1"></span>
									            </div> 
									       </div>
									    </div> 	
                                         <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Fine </label>
                                             <div class="col-sm-6"> 
                                                 <input type="text" name="fpending_balance" id="fpending_balance" class="form-control" value="" required /> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Opening Balance </label>
                                             <div class="col-sm-6"> 
                                                <input type="text" name="fopening_balance" id="fopening_balance" class="form-control" value="" required /> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Remark </label>
                                             <div class="col-sm-6"> 
                                                <textarea name="fremark" id="fremark" class="form-control" style="resize:none"></textarea>  
                                            </div>
                                        </div>  
                                         
                                          
                                          <button type="submit" class="btn btn-primary" id="updatePayment1" >Submit</button>
                                          <button type="button" class="btn btn-default"
                                           id="closemakepymt">Close</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                
            </div>
            
            <!-- Modal Footer 
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" class="btn btn-primary">
                    Save changes
                </button>
            </div>-->
        </div>
    </div>
</div>
<!-- model end-->
    
</div>


<script>

var stdid='<?=$stud_details['student_id']?>';
var orgz='<?=$stud_details['org']?>';
var enroll='<?=$stud_details['enrollment_no']?>';   
var base_url = '<?php echo site_url(); ?>';

function display()
{
	var paid_opt=$('#payment_type').val();
	if(paid_opt=='CASH')
	$('#noncash').hide();
else
	$('#noncash').show();
}

function delete_record(feeid) 
{

	if(confirm("Are you sure you want to delete this transaction ?") == true) {
	   // txt = "You pressed OK!";
		
	} 
	else
	{
		return false;
	}


	$.ajax({
		'url' : base_url + '/Hostel/delete_fees',
		'type' : 'POST', //the way you want to send data to your URL
		'data' : {'feeid' : feeid,stdid:stdid,org:orgz,enroll:enroll},
		'success' : function(data){ 
		 
			alert("Fees transaction deleted successfully");
			  //  container.html(data);
			  location.reload(); 
					return false;
		 
		}
	});
}

function valid(feeid)
{
	$('#pmnt').prop('disabled', true);
	$('#makepmnt').hide();
	
	//alert("called"+stdid+orgz+enroll);
	  $.ajax({
			'url' : base_url + '/Hostel/edit_fdetails',
			'type' : 'POST', //the way you want to send data to your URL
			'data' : {'feeid' :feeid,stdid:stdid,org:orgz,enroll:enroll},
			'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
				var container = $('#edit_fee'); //jquery selector (get element by id)
				if(data){
					//alert(data);
					//alert("Marks should be less than maximum marks");
					//$("#"+type).val('');
					container.html(data);
				}
			}
		});
}

    $('#pmnt').on('click', function () {
		$("#makepmnt").show();
		$("#refundmakepmnt").hide();
	});
	
	
	$('#refundpmnt').on('click', function () {
		$("#refundmakepmnt").show();
		$("#makepmnt").hide();
	});
	
	$('#closemakepymt').on('click', function () {
		$("#makepmnt").hide();
	});
	
	$('#closerefundpymt').on('click', function () {
		$("#refundmakepmnt").hide();
	});
	
	
    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
	$('#rdoc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker41').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker42').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
			
$(document).ready(function(){
	var prgm_id='<?=$student_details['program_id']?>';
	var ac_year='<?=$student_details['academic_year']?>';
	var std_id='<?=$student_details['student_id']?>';
	var enroll='<?=$student_details['enrollment_no']?>';
	var applicable_fee='<?=(int)$student_faci_details['excemption_fees']?>';
	//alert(prgm_id);
	/* $.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/getcoursename_by_prgmid',
				data: {prgm_id:prgm_id,academic_year:ac_year},
				success: function (html) {
					//alert(html);
					$('#prgm_id').html(html);
				}
			});*/
			
	/* $.ajax({
		
				type: 'POST',
				url: '<?= base_url() ?>Hostel/getamtpaid_by_stdid',
				data: {std_id:std_id,academic_year:ac_year,enroll:enroll},
				success: function (html) {
					//alert(html);
					if(html=="")html=0;
					
					$('#paid_amt').html(html);
					html=applicable_fee-html;
					$('#remaining_amt').html(html);
				}
			}); */	
});
/////////////////
$(document).on("click", '#editpayment', function () {
        var stud_id = $('#editpayment').attr("data-stud_id");
        var gym_fees = $('#editpayment').attr("data-gym_fees");
        var pending_balance = $('#editpayment').attr("data-pending_balance");
        var opening_balance = $('#editpayment').attr("data-opening_balance");
        var excemption_fees = $('#editpayment').attr("data-excemption_fees");
		var concession_fees = $('#editpayment').attr("data-concession_fees");
        var efile = $('#editpayment').attr("data-file");
		var concefile = $('#editpayment').attr("data-concefile");
        var deposite = $('#editpayment').attr("data-deposite");
        //alert(stud_id);alert(gym_fees);alert(pending_balance);
        if(stud_id !=''){
			document.getElementById("fstud_id").value = parseInt(stud_id);
		}
        if(gym_fees !=''){
			document.getElementById("fgym_fees").value = parseInt(gym_fees);
		}
        if(pending_balance !=''){
			document.getElementById("fpending_balance").value = parseInt(pending_balance);
		}
		if(opening_balance !=''){
			document.getElementById("fopening_balance").value = parseInt(opening_balance);
		}
		if(excemption_fees !=''){
			document.getElementById("exem").value = parseInt(excemption_fees);
		
			$("#exemdiv").show();
			if(efile!=''){
				var va ='<a href="<?=base_url()?>uploads/Hostel/exepmted_fees/'+efile+'" class="pull-right" target="_blank"><i class="fa fa-sticky-note-o" style="font-size:24px"></i></a>';
			$("#efspan").html(va);
			    
			}
		}
		if(concession_fees !=''){
			document.getElementById("concession").value = parseInt(concession_fees);
		
			$("#concediv").show();
			if(concefile!=''){
				var va ='<a href="<?=base_url()?>uploads/Hostel/concession_fees/'+concefile+'" class="pull-right" target="_blank"><i class="fa fa-sticky-note-o" style="font-size:24px"></i></a>';
			$("#efspan1").html(va);
			    
			}
		}
		if(deposite !=''){
			document.getElementById("fdeposite").value = parseInt(deposite);
		}

    });
	$('#updatePayment').on('click', function () {	
		var sf_id = $('#fstud_id').val();
		var fgym_fees = $('#fgym_fees').val();
		var fpending_balance = $('#fpending_balance').val();
		var fopening_balance = $('#fopening_balance').val();
		var fremark = $('#fremark').val();
		var exem = $("#exem").val();
		var formdata = new FormData();   
		if($('#exemfile').prop('files').length > 0)
    {
        file =$('#exemfile').prop('files')[0];
        formdata.append("music", file);
    }
		//var file_data = $("#exemfile").prop("files")[0]; 
	//	 alert(file_data);
		               
          //  form_data.append('file', file_data);
	//	alert(form_data);
		console.log(formdata);
		if(exem!='')
		{
	        var efil = $("#exemfile").val(); 
			if(efil=='')
			{
			   alert("Please select exemption supporting document");
			    return false;
			}
			else{
	            var val = efil.toLowerCase();
		        var regex = new RegExp("(.*?)\.(docx|doc|pdf)$");
		        if(!(regex.test(val))) {
		            alert('Please select correct file format for document !');
		            return false;
		        } 
            }
		}
		if(fgym_fees =='' || fpending_balance==''){
			alert('please enter fee details');
			return false;
		}else{
			
			if (sf_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>account/updatePayment',
					data: {sf_id:sf_id,fgym_fees:fgym_fees,fpending_balance:fpending_balance,fopening_balance:fopening_balance,fremark:fremark,formdata},
					success: function (html) {
						alert('updated successfully');
						//window.location.reload(true);
					}
				});
			} else {
				//$('#admission-course').html('<option value="">Select course first</option>');
			}
		}
	}); 
function show_exemfile()
			{
			   // alert("temp");
			    	 var exem = $("#exem").val();
			    	 //exemdiv
			    	 if(exem=='')
			    	 {
			    	    $("#exemdiv").hide(); 
			    	    $('#exemfile').prop('required',false);
			    	 }
			    	 else
			    	 {
			    	     
			    	   $("#exemdiv").show();
			    	   $('#exemfile').prop('required',true);
			    	   validate();
			    	 }
			    	 
			    
			}
function show_concefile()
			{
			   // alert("temp");
			    	 var conce = $("#concession").val();
			    	 //exemdiv
			    	 if(conce=='')
			    	 {
			    	    $("#concediv").hide(); 
			    	    $('#concefile').prop('required',false);
			    	 }
			    	 else
			    	 {
			    	     
			    	   $("#concediv").show();
			    	   $('#concefile').prop('required',true);
			    	   validate();
			    	 }
			    	 
			    
			}			
function validate1(){

    var efil1 = $("#concefile").val(); 
			if(efil1 !='')
			{

	            var val = efil1.toLowerCase();
		        var regex = new RegExp("(.*?)\.(jpg|png|pdf|bmp)$");
		        if(!(regex.test(val))) {
		            alert('Please select only jpg|png|pdf|bmp file format for Concession fees !');
		            $("#concefile").val("");
		            return false;
		        
                }
                // return false;
			}else{
		
		return true;
			}
}	
function validate(){
    var efil = $("#exemfile").val(); 
			if(efil !='')
			{

	            var val = efil.toLowerCase();
		        var regex = new RegExp("(.*?)\.(jpg|png|pdf|bmp)$");
		        if(!(regex.test(val))) {
		            alert('Please select only jpg|png|pdf|bmp file format for exemption fees !');
		            $("#exemfile").val("");
		            return false;
		        
                }
                // return false;
			}else{
		
		return true;
			}
}			
	</script>