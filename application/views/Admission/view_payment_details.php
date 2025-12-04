<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
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
function feevalidate()
{
    //alert("jugal");
 //   return false;
    
        var base_url = 'https://erp.sandipuniversity.com/';
                   // alert(type);
                   var clreceipt = $("#clreceipt").val();
                 
                $.ajax({
                    'url' : base_url + 'Ums_admission/validate_receipt',
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
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Payment Details</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Make Payment</h1>
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
                        <span class="panel-title">Payment Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">   
						<table class="table table-bordered">
    					<tr>
    					  <th width="25%">PRN No :</th><td colspan=3><?=$emp[0]['enrollment_no']?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name :</th><td colspan=3><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></td>
						</tr>
						<tr>
    					  <th scope="col" colspan>Course Name :</th><td colspan=3><?=$emp[0]['stream_name']?></td>
    					</tr>
						 <tr>
						   <td><b>Current Semester</b></td>
						   <td><?=$emp[0]['current_semester']?></td>
							<td><b>ABC Id</b></td>
						   <td><?php if(!empty($emp[0]['abc_no'])){ echo $emp[0]['abc_no'];}else{ echo '-';}?></td>
						 </tr>
						 <tr>
						   <td><b>Admission Cycle</b></td>
						   <td><?php if(!empty($emp[0]['admission_cycle'])){ echo $emp[0]['admission_cycle'];}else{ echo $emp[0]['admission_session'];}?></td>
						   <td><b>Package</b></td>
							<td><?php if($emp[0]['belongs_to'] == 'Package' ){ echo 'Yes'; echo ' - '.$emp[0]['package_name']; }else{ echo 'No';}?></td>
						 </tr>
						 <tr>
						  
						 </tr>
						 
						 <tr>
						   <td><b>Transfer Case</b></td>
						   <td><?php if($emp[0]['transefercase'] == 'Y' ){ echo 'Yes';}else{ echo 'No';}?></td>
						   <td><b>Cancellation Status</b></td>
									   <td><?php if($emp[0]['cancelled_admission'] == 'Y' ){ echo 'Yes';}else{ echo 'No';}?></td>
						 </tr>
						 <tr>
						   
						 </tr>
						 <?php if($role_id==2 || $role_id==6){?>
						 <tr>
						   <td>Username:</td>
						   <td><b><?php if(!empty($emp[0]['username'])){ echo $emp[0]['username'];}else{ echo 'Not Generated';}?></b></td>
						   <td>Password:</td>
						   <td><b><?php if(!empty($emp[0]['password'])){ echo $emp[0]['password'];}?></b></td>
						 </tr>
						 <?php }?>
						 <?php 
							if($this->session->userdata('role_id')!="4" || $this->session->userdata('role_id')!="9"){
						 ?>
						 <tr>
						   <td>Online payments</td>
							<td><a href="<?=base_url()?>online_fee/student_payment_history/<?=$emp[0]['enrollment_no']?>/<?=$emp[0]['stud_id']?>" target="_blank">view</a></td>
						 </tr>
							<?php }?>
						</table>
    				    <table class="table table-bordered">
    					<tr>
    					   <th scope="col">Academic Year</th>
    					   <th scope="col">Year</th>
						   <th scope="col">Stream</td>
    					  <th scope="col">Academic Fee</th>
    					  <th scope="col">Exepmted Fee</th>
    					  <th scope="col">Applicable Fee</th>
    					  <th scope="col">Opening balance</th>
						  
    					  <th scope="col">Amount Paid</th>
    				
    					   <td><strong>Refund</strong></td>
    					  
    					  
    					  <th scope="col">Remaining Balance</th>
    					 
    					    <th scope="col">Chq Cancellation Charges</th>
    					      <th scope="col">Total Outstanding</th>
    					      <th scope="col">Hostel</th>
    					    
    					    <th scope="col">Action</th>
							 <th scope="col">Remark</th>
    					</tr>
    					<?php 

						$exm = (int)$admission_details[0]['actual_fee'] - (int)$admission_details[0]['applicable_fee'];
						$bal = (int)$admission_details[0]['applicable_fee'] - (int)$get_feedetails[0]['amount'];
					  
    					$srNo1=1;
    					
    				$actual =	isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '';
    					$paid =isset($totfeepaid[0]['tot_fee_paid']) ? $totfeepaid[0]['tot_fee_paid'] : '';
    					$i=1;
    				  $cn = count($admission_detail);
    				  
    				 // print_r($admission_detail);e
    					if($cn >1)
    					{
    					
							$popbal = ($admission_detail[1]['applicable_fee'] + $admission_detail[1]['tot_canc'] + $admission_detail[1]['opening_balance']) + $admission_detail[1]['tot_refunds'] -  $admission_detail[1]['totfeepaid'] ;
    					}
    					else
    					{
    					    $popbal = 0;
    					}
    				//	$popbal = $admission_detail[];
    					$i=1;
						
    					foreach($admission_detail as $admission_det)
    					{
    					    $popbal = ($admission_detail[$i]['applicable_fee'] + $admission_detail[$i]['tot_canc'] + $admission_detail[$i]['opening_balance']) + $admission_detail[$i]['tot_refunds'] -  $admission_detail[$i]['totfeepaid'] ;
    				//	 echo $i;
						$exm = (int)$admission_det['actual_fee'] - (int)$admission_det['applicable_fee'];
						$bal = (int)$admission_det['applicable_fee'] - (int)$admission_det['totfeepaid'];
					  
    					$srNo1=1;
    					
    				$actual =	isset($admission_det['applicable_fee']) ? $admission_det['applicable_fee'] : '';
    					$paid =isset($admission_det['totfeepaid']) ? $admission_det['totfeepaid'] : '';   
    					?>
    					<tr>
							<td><?= $admission_det['academic_year']; ?></td>
								<td><?= $admission_det['year']; ?></td>
								<td><?= $admission_det['stream_short_name']; ?></td>
    						<td><?= isset($admission_det['actual_fee']) ? $admission_det['actual_fee'] : '' ?></td>
    						<td><?=  $exm; ?></td>
    						<td><?= isset($admission_det['applicable_fee']) ? $admission_det['applicable_fee'] : '' ?></td>
    						<td><?= isset($admission_det['opening_balance']) ? $admission_det['opening_balance'] : '' ?></td>
							
    						<td><?= isset($admission_det['totfeepaid']) ? $admission_det['totfeepaid'] : '' ?></td>
    						
    						<?php
    				  if($admission_det['tot_refunds']!='')
    					  {
    					    $actual = $actual + $admission_det['tot_refunds'] ;
    					  }
    					    ?>
    					   <td><?=$admission_det['tot_refunds'] ?></td>
    					   <?
    				
    					  if($admission_det['opening_balance']!='')
    					  
    					  {
    					    $actual = $actual +   $admission_det['opening_balance'];
    					  }
    					  ?> 
    					  
    						<td><?= $pend = $actual - $paid; //isset($minbalance[0]['min_balance']) ? $minbalance[0]['min_balance'] : $admission_details[0]['applicable_fee'] ?></td>
    					
    							<td><?php echo $can_amt = $admission_det['tot_canc']; //$canc_charges[0]['canc_amount'] ?></td>
    							<td><?php echo $can_amt + $pend; //$canc_charges[0]['canc_amount'] ?></td>
								<td><?php if(isset($admission_det['prn'])){?> <a href="<?=base_url()?>Hostel/student_facility_details/<?=$admission_det['enrollment_no']?>/<?=$admission_det['f_alloc_id']?>/SU/<?=$admission_det['academic_year']?>" target="_blank">View</a><?php }else{ echo '-';}?></td>
    							<td>
    							  <?php
    					//	 if(($cn>1) && ($i==1))
							//echo $this->session->userdata('name');
						  if(($this->session->userdata('role_id')=="5" && $this->session->userdata('name')=="662659") || $this->session->userdata('role_id')=="6")//$this->config->item('cyear')==$admission_det['academic_year'] &&
    					  {
    							  ?>
    						    <a class="marksat" id="editpayment" data-openingbal="<?=$popbal?>"  data-academic_year="<?= $admission_det['academic_year']; ?>" val="<?=$i?>" data-stud_id="<?= $admission_det['student_id']; ?>" data-actual_fee="<?= $admission_det['actual_fee']; ?>" data-excemption_fees="<?= $exm; ?>" data-applicable_fee="<?= $admission_det['applicable_fee']; ?>" data-opening_balance="<?= $admission_det['opening_balance'] ?>" data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button class="btn btn-primary btn-xs">Edit</button></a>
    					<?php
    				}
    					?>
    					
    						</td>
							<td><?php if($this->session->userdata('roles_id')=="5" || $this->session->userdata('roles_id')=="6"){?><?= isset($admission_det['concession_remark']) ? $admission_det['concession_remark'] : '' ?><?php }?></td>
    					</tr>
    					
    					<?php
    					$i++;
    					}
    					?>
    					<!--<tr>
							<td><?= $admission_details[0]['academic_year']; ?></td>
								<td><?= $admission_details[0]['year']; ?></td>
    						<td><?= isset($admission_details[0]['actual_fee']) ? $admission_details[0]['actual_fee'] : '' ?></td>
    						<td><?=  $exm; ?></td>
    						<td><?= isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '' ?></td>
    						<td><?= isset($admission_details[0]['opening_balance']) ? $admission_details[0]['opening_balance'] : '' ?></td>
    						<td><?= isset($totfeepaid[0]['tot_fee_paid']) ? $totfeepaid[0]['tot_fee_paid'] : '' ?></td>
    						
    						<?php
    					  if($tot_refunds['rsum']!='')
    					  {
    					    $actual = $actual + $tot_refunds['rsum'] ;
    					    ?>
    					   <td><?=$tot_refunds['rsum']?></td>
    					   <?
    					  }
    					  if($admission_details[0]['opening_balance']!='')
    					  
    					  {
    					    $actual = $actual +   $admission_details[0]['opening_balance'];
    					  }
    					  ?> 
    					  
    						<td><?= $pend = $actual - $paid; //isset($minbalance[0]['min_balance']) ? $minbalance[0]['min_balance'] : $admission_details[0]['applicable_fee'] ?></td>
    						 <?php
    					  if($canc_charges['canc_amount']>0)
    					  {
    					  ?>
    							<td><?php echo $can_amt = $canc_charges['canc_amount']; //$canc_charges[0]['canc_amount'] ?></td>
    							<td><?php echo $can_amt + $pend; //$canc_charges[0]['canc_amount'] ?></td>
    							<?php
    					  }
    							?>
    							<td>
    						    <a class="marksat" id="editpayment" data-academic_year="<?= $admission_details[0]['academic_year']; ?>" data-stud_id="<?= $admission_details[0]['student_id']; ?>" data-actual_fee="<?= $admission_details[0]['actual_fee']; ?>" data-excemption_fees="<?= $exm; ?>" data-applicable_fee="<?= $admission_details[0]['applicable_fee']; ?>" data-opening_balance="<?= $admission_details[0]['opening_balance']; ?>"data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button class="btn btn-primary btn-xs">Edit</button></a>
    						</td>
    					</tr>-->
    						
    				  </table>	
					  </div>
					  </div>
					  <div class="panel">
					  <div class="panel-heading">
                        <span class="panel-title">Fees paid Details</span>
						</div>
						<div class="panel-body">
					  <table class="table table-bordered">
    					<tr>
    					  <th scope="col">Sr. No. </th>
    					    <th scope="col">Academic Year </th>
						  <th scope="col">Paid By</th>
    					  <th scope="col">Chq/DD No</th>
    					  <th scope="col">Rcpt No</th>
						  <th scope="col">Bank</th>
    					  <th scope="col">Branch</th>
						  <th scope="col">Dated</th>
						  <th scope="col">Amount</th>
						  <th scope="col">Can Charges</th>
						 
						  <th scope="col">Status</th>
						   <th scope="col">Remark</th>
    					<!--  <th scope="col">Balance</th>
    					  
						  <th scope="col">Scan Copy</th>-->
						
						   <th scope="col">Action</th>
    					</tr>
						<?php 
						$i=1;
						 $j=1;
						if(!empty($installment)){
							foreach($installment as $inst){
								$fee_date = date('d/m/Y',strtotime($inst['fees_date'] ));
						?>
    					<tr <?php if($inst['fees_paid_type']=='ITF'){?>style="background:#f78686" <?php }?>>
    					    <td><?=$i?></td>
    					    	<td><div style="color:red"><?=$inst['academic_year']?></div></td>
							<td><?=$inst['fees_paid_type']?></td>
    						<td><?= isset($inst['receipt_no']) ? $inst['receipt_no'] : '' ?></td>
    							<td><?= $inst['college_receiptno']; ?></td>
							<td><?= $inst['bank_name']; ?></td>
    						<td><?= isset($inst['bank_city']) ? $inst['bank_city'] : '' ?></td>
							<td><?= isset($fee_date) ? $fee_date : '' ?></td>
    						<td><?=$inst['amt_paid']?></td>
    							<td><?=$inst['canc_charges']?></td>
    						<td><?php if($inst['chq_cancelled']=='N'){echo "Accepted";}else{echo "Cancelled";}?></td>
							<td><?=$inst['remark'];?> </td>
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
	    <?php
		//echo $this->session->userdata('name');
		//if($admission_detail[0]['academic_year']==$inst['academic_year'])
		//if(($this->config->item('cyear')==$inst['academic_year'] || $inst['fees_paid_type']=='CHQ') && ($this->session->userdata('role_id')=="40" || $this->session->userdata('role_id')=="5" ))
		$acd=2022;	
	    if(($this->config->item('cyear')==$inst['academic_year']  ))
	    //if(($this->session->userdata('role_id')=="5") )//&& $acd==$inst['academic_year']
	    {
	    ?>
	    
	    <!--input type="button" value="Edit" name="<?=$inst['fees_id']?>" id="editp" onclick="valid('<?=$inst['fees_id']?>')" class="btn btn-primary"-->


	<!--input type="button" value="Del" name="<?=$inst['fees_id']?>" id="delete" onclick="delete_record('<?=$inst['fees_id']?>')" class="btn btn-primary"-->
<?php
}
?>
	</td>
    					</tr>
						<?php
						$i++;
						$j++;
							}
							
							
							
							
							
							 
    					  for($i=0;$i<count($get_refunds);$i++)
    					     {
						        ?>
						 <tr style="background: #d2c47d;">
						   
							<td><?=$j?></td>
								<td><?=$get_refunds[$i]['academic_year']?></td>
    						<td><?=$get_refunds[$i]['refund_paid_type']?></td>
							<td><?= isset($get_refunds[$i]['receipt_no']) ? $get_refunds[$i]['receipt_no'] : '' ?></td>
									<td><?= $get_refunds[$i]['college_receiptno']; ?></td>
							<td><?= $get_refunds[$i]['bank_name']; ?></td>
							<td><?= isset($get_refunds[$i]['bank_city']) ? $get_refunds[$i]['bank_city'] : '' ?></td>
							
						
							
    						<td><?php if($get_refunds[$i]['refund_date']!=''){echo date('d-m-Y', strtotime($get_refunds[$i]['refund_date']));}?></td>
    						
    					
    						<td><?= isset($get_refunds[$i]['amount']) ? $get_refunds[$i]['amount'] : '' ?></td>
    							<td></td>
							<td>Refund</td>
    					</tr>
    				<?php
    					 $j++;    }
							
							
							
							
							
							
							
							
							
							
							
							
							
							
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
							?>	
							<td colspan="6" align="center"><?php if($this->session->userdata('name')=="6031"){?><input type="button" name="make Payment" id="pmnt" value="Make Payment" class="btn btn-primary" /><?php }?></td>
							<td colspan="6" align="center"><?php if($this->session->userdata('name')=="6031"){?><a href="<?=base_url()?>Account/student_fees_refund/<?=$emp[0]['enrollment_no']?>" target="_blank"><input type="button" name="Click here for Refund" value="Click here for Refund" class="btn btn-primary" /></a><?php }?></td>
    				<!--/*	<?php }?>	*/-->
    						
    					</tr>	
    				  </table>

                        </div>
                    </div>
                    
                    
                    <script>
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
                    'url' : base_url + 'Ums_admission/delete_fees',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'feeid':feeid},
                    'success' : function(data){ 
                     
                        alert("Fees transaction deleted successfully");
                          //  container.html(data);
                          location.reload(); 
                            	return false;
                     
                    }
                });
                   }
                    
                    </script>
                    
                    
										  <!------------------------------------------------------------------------------------------------------------------------------>
					 
				
					  <div class="panel" id="makepmnt" style="display:none">
                            <div class="panel-heading">
								<span class="panel-title">Make Payment</span>
							</div>
                                <div class="panel-body">
								<form name="makePayment" id="makePayment" onsubmit="" method="POST" action="<?=base_url()?>ums_admission/pay_Installment" enctype="multipart/form-data">
								<?php
									$studId = $this->uri->segment(3);
								?>
								 <div class="form-group">
                                    <label class="col-sm-3"> Academic Year</label>
                                     <div class="col-sm-3">
                                    <select name="acyear" id="acyear" class="form-control" >
									<option value="2025" selected>2025-26</option>
									<option value="2024" selected>2024-25</option>
									<option value="2023" selected>2023-24</option>
									<!--option value="2022" selected>2022-23</option>
									<option value="2021" selected>2021-22</option>
                    <option value="2020" selected>2020-21</option>
                    <option value="2019" selected>2019-20</option>
                    <option value="2018" >2018-19</option>
                    <option value="2017" >2017-18</option-->
               <!-- 	   <option value="2017" >2017-18</option>
							 	<option value="2016">2016-17</option>
									-->
								
									
									</select>
									
									
                                    </div>
                                    
                                    </div>
                                        
                                  <div class="form-group">
                                    <label class="col-sm-3">Payment of Rs</label>
                                    <div class="col-sm-3">
                                      <input data-bv-field="paidfee" id="paidfee" name="paidfee" class="form-control numbersOnly" value="" placeholder="Paid Fee" type="text" required>
									  <input type="hidden" name="no_of_installment" value="<?= isset($noofinst[0]['max_no_installment']) ? $noofinst[0]['max_no_installment'] : '' ?>">
									  <input type="hidden" name="stud_id" value="<?=$studId?>">
									  <input type="hidden" name="acye" value="<?=$acye?>">
									  <input type="hidden" name="min_balance" value="<?= isset($minbalance[0]['min_balance']) ? $minbalance[0]['min_balance'] : '' ?>">
                                    </div>
                                    <label class="col-sm-3">Payment Type</label>
                                    <div class="col-sm-3">
                                    <select name="payment_type" id="payment_type" class="form-control" >
                                        <option value="">Select Payment Type</option>
									<option value="CHQ">Cheque</option>
									<option value="DD">DD</option>
									<option value="CHLN">Chalan</option>
									
										<option value="ITF">Internal Transfer</option>
											<option value="POS">POS</option>
												<option value="OL">Online</option>
												<option value="GATEWAY-ONLINE">GATEWAY-ONLINE	</option>
									</select>
									
									
                                    </div>
                                  </div>
                                  <div class="form-group">
								  <input type="hidden" name="actfee" value="<?= isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '' ?>">
								   <label class="col-sm-3"> Cheque/DD No./Chalan No.</label>
                                    <div class="col-sm-3">
                                      <input type="text" name="dd_no" class="form-control"  value="<?= isset($fee[0]['dd_no']) ? $fee[0]['dd_no'] : '' ?>" placeholder="Cheque/DD No./Chalan No" >
                                    </div>
									
                                    <label class="col-sm-3">Dated</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker20" name="dd_date" required value="<?= isset($fee[0]['dd_drawn_date']) ? $fee[0]['dd_drawn_date'] : '' ?>" placeholder="DD Date" required readonly="true"/>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                      
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">Bank name</label>
                                    <div class="col-sm-3">
                                     <!-- <input type="text" id="dd_bank" name="dd_bank" class="form-control" value="<?= isset($fee[0]['dd_drawn_bank_branch']) ? $fee[0]['dd_drawn_bank_branch'] : '' ?>" placeholder="Bank & Branch">-->

									<select name="dd_bank" id="dd_bank" class="form-control">
									  <option value="">Select</option>
									  <?php
										foreach ($bank_details as $branch) {
										  
											echo '<option value="' . $branch['bank_id'] . '" ' . $sel . '>' . $branch['bank_name'] . '</option>';
										}
										?>
								   </select>

                                    </div>
                                    <label class="col-sm-3"> Branch Name.</label>
                                    <div class="col-sm-3">
                                      <input type="text" id="dd_bank_branch" name="dd_bank_branch" class="form-control" value="" placeholder="Branch Name" >
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
								   <label class="col-sm-3">Upload document</label>
                                    <div class="col-sm-3"><input type="file" name="payfile"></div>
                                     <label class="col-sm-3">College Receipt Number</label>
                                    <div class="col-sm-3">
                                          <input type="text" id="clreceipt" name="clreceipt" class="form-control" value="" placeholder="College Receipt Number" required>
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
                                            <label class="col-sm-3" for="exampleInputEmail1">Late Fees / Fine</label>
                                             <div class="col-sm-6">
                                             
                                                <input type="text" name="late_fees" id="late_fees" class="form-control" value="" required /> 
                                            </div>
                                        </div>
								  <div class="form-group">
								      
								      
								   <label class="col-sm-5"></label> 
								   <div class="col-sm-1">
                                     <button type="button" name="Cancel" id="cbutton" value="Cancel" class="btn btn-primary">Cancel</button>
                                    </div>
                                    <div class="col-sm-6"><button type="submit" name="Make_Payment" value="Make Payment" class="btn btn-primary">Add Payment</button>
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
                   <span id="fform_id">Edit Payments</span>
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked" style="margin-top: 10px;">
                                    <div class="panel-body">
                                        <form name="editfrm" method="POST" action="<?=base_url()?>Ums_admission/updateAdmPayment" enctype="multipart/form-data" onsubmit="return validate()">
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Academic Fee </label>
                                             <div class="col-sm-6"> 
                                             <label name="facdamicfee" id="facdamicfee"></label>
                                                
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Actual Fees </label>
                                             <div class="col-sm-6"> 
                                                <label name="fgym_fees" id="fgym_fees"></label>
                                                <input type="hidden" name="fstud_id" class="form-control" id="fstud_id" style="width:50%"/>
                                                
    									        <input type="hidden" name="student_id" value="<?=$studId?>">
    									        <input type="hidden" name="acad_year" id="acad_year" >

                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Exempted fees </label>
                                             <div class="col-sm-6"> 
                                             <label name="exem" id="exem"></label>
                                                
                                            </div>
                                        </div> 

                                         
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Opening Balance </label>
                                             <div class="col-sm-6">
                                             
                                                <input type="text" name="fopening_balance" id="fopening_balance" class="form-control" value="" required /> 
                                            </div>
                                        </div>
   
                                          <button type="submit" class="btn btn-primary" id="updatePayment1" >Submit</button>
                                          <button type="button" class="btn btn-default"
                                                data-dismiss="modal">
                                                    Close
                                        </button>
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
     
 var base_url = '<?php echo site_url(); ?>';

   // $('#editp').on('click', function () {
        function valid(feeid)
        {
      //  var feeid = $(this).attr('name');
   var controller = 'Ums_admission';
           
            $('#pmnt').prop('disabled', true);
            
	          $.ajax({
                    'url' : base_url + controller + '/edit_fdetails',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'feeid' : feeid},
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
		
//	});
}






	  $('#cbutton').on('click', function () {
        //$('#pmnt').prop('disabled', false);
        	$("#makepmnt").hide();
   });

    $('#pmnt').on('click', function () {
        
		$("#makepmnt").show();
	});
    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9-\.]/g, '')) {
       this.value = this.value.replace(/[^0-9-\.]/g, '');
    } 
  	});
	    $('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	      $('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	       $('#doc-sub-datepicker41').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	        $('#doc-sub-datepicker42').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
/////////////////
$(document).on("click", '#editpayment', function () {
   // var ye = $(this).value();
     //var va = $(this).attr('val');
    //alert(va);
        var stud_id = $('#editpayment').attr("data-stud_id");
        var applicable_fee = $('#editpayment').attr("data-applicable_fee");
      //  var academic_year = $('#editpayment').attr("data-academic_year");
        var academic_year = $(this).attr("data-academic_year");
        var openingbal = $(this).attr("data-openingbal");
        //alert(openingbal);
        var actual_fee = $('#editpayment').attr("data-actual_fee");
       // var opening_balance = $('#editpayment').attr("data-opening_balance");
       
       var opening_balance = $(this).attr("data-opening_balance");
       
       
        var excemption_fees = $('#editpayment').attr("data-excemption_fees");
		//alert(opening_balance);
        if(stud_id !=''){
			document.getElementById("fstud_id").value = parseInt(stud_id);
		}
        if(applicable_fee !=''){
			$("#fgym_fees").html(parseInt(applicable_fee));
		}
        if(actual_fee !=''){
			$("#facdamicfee").html(parseInt(actual_fee));
		}
		if(opening_balance !=''){
			$("#fopening_balance").val(parseInt(openingbal));
			
		}
		if(excemption_fees !=''){
			$("#exem").html(parseInt(excemption_fees));
			
		}
		if(academic_year !=''){
			$("#acad_year").val(parseInt(academic_year));
			
		}

    });	        
	</script>