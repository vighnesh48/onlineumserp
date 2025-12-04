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
				refund:
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
                   $('#cancelform').bootstrapValidator('revalidateField', 'cdate');
               }); 

	
    $("#cancellation").click(function(){
		document.getElementById("cancelform").reset();
		
		$("#cancel_div").show();
		$('#sf_id').val(sf_id);
    });
	
	$("#ccancel").click(function(){
		$("#cancel_div").hide();
    });
	
	$("#cshhhubmit").click(function()
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
        <li class="active"><a href="#">Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Facility Details</h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    
                    <!--<div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>        -->                
                    <div class="visible-xs clearfix form-group-margin"></div>
                    
                    
                   
                </div>
            </div>
			
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>
       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <!--<div class="panel-heading">
                        <span class="panel-title">Detailed View</span>
                        
                </div>-->
				
                <div class="panel-body">
			
					<input type="hidden" name="hidacyear" id="hidacyear" value="<?=$student_list['academic_year']?>">
					<input type="hidden" name="hidfacid" id="hidfacid" value="1">
					<input type="hidden" name="cyear" id="cyear" value="<?=$student_list['current_year']?>">
					<input type="hidden" name="stud_id" id="stud_id" value="<?=$student_list['stud_id']?>">
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
						  <th width="18%">Hostel :</th>
						  <td><?=$student_list['hostel_code']?> / <?=$student_list['floor_no']=='0'?'G':$student_list['floor_no']?> / <?=$student_list['room_no']?></td>
						</tr>
						<tr>
						  <th width="18%">Course :</th>
						  <td><?php  if($student_list['course']==NULL)
							//$student_list['stream_name'].' - '.  
						  echo $student_list['course_name'];else echo $student_list['course'].' '.$student_list['stream'];?></td>
						  <th width="18%">Current Year :</th>
						  <td><?php echo $student_list['current_year'];
							/*if($student_list['current_year']==1)
								echo 'First Year';
							else if($student_list['current_year']==2)
								echo 'Second Year';
							else if($student_list['current_year']==3)
								echo 'Third Year';
							else if($student_list['current_year']==4)
								echo 'Fourth Year';*/
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
    					  <th width="col">Year</th>
    					  <th scope="col">Deposit</th>
    					   <th scope="col">Hostel</th>
    					  <th scope="col">Exepmted </th>
						  <th scope="col">Applicable </th>
						  <th scope="col">Gym </th>
						  <th scope="col">Fine</th><th scope="col">Refund</th>
						  <th scope="col">Opening balance</th>
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
			if(!empty($stud_faci_details)){
				foreach($stud_faci_details as $student_faci_details)
				{
						$applicable_fee = ((int)$student_faci_details['deposit_fees'] + (int)$student_faci_details['actual_fees']) - (int)$student_faci_details['excemption_fees'];
						
						
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
    						<td><?= isset($student_faci_details['deposit_fees']) ? $student_faci_details['deposit_fees'] : '' ?></td>
    							<td><?= isset($student_faci_details['actual_fees']) ? $student_faci_details['actual_fees'] : '' ?></td>
    							<td><?= isset($student_faci_details['excemption_fees']) ? $student_faci_details['excemption_fees'] : '' ?> 
    							<?php if(strlen($student_faci_details['excem_doc_path'])>10){?>
    							<a href="<?=base_url()?>uploads/Hostel/exepmted_fees/<?=$student_faci_details['excem_doc_path']?>" class="pull-right" target="_blank"><i class="fa fa-sticky-note-o" style="font-size:24px"></i></a>
    						<?php	}?></td>
							<td><?=$applicable_fee?></td>
    					    <td><?=$student_faci_details['gym_fees']?></td>
							<td><?=$student_faci_details['fine_fees']?></td>
						    
    						<td><?=$student_faci_details['refund']?></td>
							<td><?=$student_faci_details['opening_balance']?></td>
    						<td id="paid_amt1"><?=$paid?></td>
    						<td id="remaining1_amt">
    						<?=$bal = ($applicable_fee - (int)$paid) +(int)$student_faci_details['gym_fees']+(int)$student_faci_details['fine_fees']+(int)$student_faci_details['opening_balance']+(int)$student_faci_details['refund']  ?>
    							
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
								//echo $this->session->userdata('role_id');
								
							    if($student_list['cancelled_facility']=='N' && $this->session->userdata('roles_id')==45)
							    {
							    ?>
							<a class="btn btn-primary btn-labeled" onclick="de_allocate_bed('<?=$this->uri->segment(4)?>')" id="deallocate"  title="Click here to De-allocate Room">De-allocate</a>
							<a class="btn btn-primary btn-labeled" id="cancellation"  title="Click here to Cancel Hostel Facility">Cancellation</a>	
							<?php
							    }else if($student_list['cancelled_facility']=='N'){ ?>
									<a class="btn btn-primary btn-labeled" id="cancellation"  title="Click here to Cancel Hostel Facility">Cancellation</a>		
								<?php }
							    else
							    {
							?>
										<a class="btn btn-danger" id=""  title="Cancelled">Cancelled</a>	
							<?php
							    }
							?>
							
							</div>	
							<a class="btn btn-primary btn-labeled" href="<?=base_url()?>hostel/student_clearance_view/<?=$student_list['enrollment_no']?>" id="Clearance"  title="Click here to Cancel Hostel Facility">Clearance</a>	
							<div class="col-sm-3"></div>
						</div>
					</div>
					</br>
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
								
									<div class="form-group">
										
									   	<label class="col-sm-2" style="padding-right:0px;padding-left:0px;">Cancellation Charges: <?=$astrik1?></label>
										<div class="col-sm-2">
										  <input type="text" class="form-control" id="ccharges" name="ccharges" required />
										</div> 
										<label class="col-sm-2" style="padding-right:0px;padding-left:0px;">Refund Amount: <?=$astrik1?></label>
										<div class="col-sm-2"><input type="text" id="refund" name="refund" class="form-control" /></div> 
                         
									</div>
									<div class="form-group">
									<label class="col-sm-2" style="padding-right:0px;padding-left:0px;">Cancellation Date: <?=$astrik1?></label>
										<div class="col-sm-2">
										  <input type="text" class="form-control" id="doc-sub-datepicker21" name="cdate" required readonly="true"/>
										</div>
									<label class="col-sm-2">Remarks: <?=$astrik1?></label>
										<div class="col-sm-2"><textarea type="text" id="remarks" name="remarks" class="form-control" ></textarea></div>
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
					
					<?php
					if(!empty($installment)){
					?>
                   
                   	  <div class="row">
							   <div class="form-group">
							       <hr>
							       <h4>Payment History</h4>
							   
							   
					<table class="table table-bordered" style="width:100%;max-width:100%;">
    					<tr>
    					  <th scope="col">Sr. No. </th>
    					  <th scope="col">Academic Year</th>
						  <th scope="col">Paid By</th>
    					  <th scope="col">Chq/DD No</th>
    					  <th scope="col">Rcpt No</th>
						  <th scope="col">Bank</th>
    					  <th scope="col">Branch</th>
						  <th scope="col">Dated</th>
						  <th scope="col">Status</th>
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
    					    
    					    	<td><?=$inst['academic_year'] ?></td>
    					    	
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
							<td><?php if($inst['chq_cancelled']=='N'){echo "Accepted";}else if($inst['chq_cancelled']=='Y'){echo "Cancelled";}else {echo "Refund";}?></td>
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

	



});
</script>
                    
