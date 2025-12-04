<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<script>
var curr_year = ["","First", "Second", "Third", "Fourth"];  
$(document).ready(function(){
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
                academic:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select academic year'
                      },
                      required: 
                      {
                       message: 'Please select academic year'
                      }
                     
                    }
                }
				,
				facilty:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select facility type'
                      },
                      required: 
                      {
                       message: 'Please select facility type'
                      }
                     
                    }
                },
				category:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Category'
                      },
                      required: 
                      {
                       message: 'Please select Category'
                      }
                     
                    }
                },
				
				epayment_type:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select paid by'
                      },
                      required: 
                      {
                       message: 'Please select paid by'
                      }
                     
                    }
                },fees_date:
				{
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Paid Date'
                      },
                      required: 
                      {
                       message: 'Please select Paid Date'
                      }
                     
                    }
                },
				bank:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select bank'
                      },
                      required: 
                      {
                       message: 'Please select bank'
                      }
                     
                    }
                },
				receipt_number:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please enter receipt number'
                      },
                      required: 
                      {
                       message: 'Please enter receipt number'
                      }
                     
                    }
                },
				amt:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please enter amount'
                      },
                      required: 
                      {
                       message: 'Please enter amount'
                      }
                     
                    }
                } ,
				depositto:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please enter deposit bank'
                      },
                      required: 
                      {
                       message: 'Please enter deposit bank'
                      }
                     
                    }
                } 
		}       
        })
    });
function display_noncash()
{
	var ptype = $('#epayment_type').val();
	if((ptype=='CASH'))
	{
		$('#non_cash').hide();
	   // $('#Online_pay').hide();

	}
	else if((ptype=='OL')||(ptype=='GATEWAY-ONLINE')){
		$('#non_cash').hide();
		$('#receipt').html('Transaction No. :<?=$astrik?>');
		$('#paiddate').html(' Date. :<?=$astrik?>');
		$('#non_cash').show();
		//$('#Online_pay').show();
	}
	else
	{ //$('#Online_pay').hide();
		$('#receipt').html(ptype+' No. :<?=$astrik?>');
		$('#paiddate').html(ptype+' Date. :<?=$astrik?>');
		$('#non_cash').show();
	}
}
$(document).ready(function(e) {
	
	
	$('.Check_recepit').on('click',function(){
		
		var receipt_number=$("#receipt_number").val();
		var epayment_type=$("#epayment_type").val();
		//alert(receipt_number);
		var formData = {receipt_number:receipt_number,epayment_type:epayment_type};
		if(receipt_number!=''){
		
	    $.ajax({
		type:"POST",
		url:'<?php echo base_url();?>Online_hostel_fee/check_facility_recepit',
		data:formData,
		
		success: function(result){
			if(result!=0){
				$('.error_msg').html('Duplicate Number');
				$('.Generate').prop('disabled', true);
			}else{
				$('.error_msg').html('PASS');
				$('.Generate').prop('disabled', false);
			}
			}
		 });
		}
		
		
		});
});
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Fees challan</a></li>
        <!--<li class="active"><a href="<?=base_url($currentModule)?>">Fees Master </a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-5 text-ctext-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Generate challan </h1>
            
									
					<span id="flash-messages" style="color:Green;padding-left:10px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:10px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
                    
                
            
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                   
				    <div class="panel-heading">
					<div class="row">
                   <?php //print_r( $user_details); ?>
						
                        <div class="col-sm-2">
			<!--<a href="<?php echo base_url();?>Challan/External_challan"><button class="btn btn-primary form-control" id="" type="button" >External Challan</button></a>-->
						</div>
						<div class="col-sm-5">
							<span style="color:red;" id="err_msg"></span>
						</div>
					</div>
					</div>
                    <div class="panel-body">
							<form id="form" name="form" action="<?=base_url('Hostel/add_fees_challan_submit')?>" method="POST" >
							<input type="hidden" class="form-control numbersOnly"  value="0" readonly name="facility" id="facility" />
							<input type="hidden" class="form-control numbersOnly"  value="<?=$pay[0]['amount']?>" readonly name="apaid" id="apaid" readonly/>
							<input type="hidden" class="form-control numbersOnly"  value="0" readonly name="apend" id="apend" readonly/>
							<input type="hidden" id="enroll" name="enroll" value="<?php echo $pay[0]['registration_no']; ?>" />
							<input type="hidden" id="student_id" name="student_id" value="<?=$pay[0]['student_id']?>" />
							<input type="hidden" id="curr_yr" name="curr_yr" value="" />
							<input type="hidden" id="admission_year" name="admission_year" value="" /> 
							<input type="hidden" id="academic_year" name="academic_year" value="<?=$pay[0]['academic_year']?>" />    
							<input type="hidden" id="online_payment_id" name="online_payment_id" value="<?php echo $payment_id; ?>" />							
                            <div class="col-md-5" id="std_details" style="padding-right:0px;">
							
							<div class="panel">
                   
							<div class="panel-heading">
							<b>Student Details:</b>
							</div>
							
                            <div class="panel-body">
							
                              <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">ID/PRN:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									
									 <span id="prnno" name="prnno"><?php echo $pay[0]['registration_no']; ?></span>								   
								   </div>			 
							  </div>
								<div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Name:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									  <span id="std_name" name="std_name"><?php echo $pay[0]['firstname']; ?></span>								   
								   </div>			 
							  </div>
							  
							  <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Mobile:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 
									 <span id="mobile1" name="mobile1"><?php echo $pay[0]['phone']; ?></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Academic Year:<?=$astrik?></label>
                                <div class="col-md-6" style="padding-left:0px;">
                                  <select class="form-control" name="academic" id="academic" >
									   <option value="">Academic Year</option>
									    
									   <!--option value="2019">2019-20</option--> 
									   <option  value="2020">2020-21</option>  
									   <option  value="2021">2021-22</option>  
                                       <option  value="2022">2022-23</option> 
									   <option  value="2023">2023-24</option> 
									   <option  value="2024">2024-25</option> 
									   <option  value="2025" selected="selected">2025-26</option> 
										<?php //echo "state".$state;exit();
										/*if(!empty($academic_details)){
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
										}*/
									  ?>
									  </select>
                                      <input type="hidden" name="admission_session" id="admission_session" value="" />
                                </div>
                                
                              </div>
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Fee  Type:<?=$astrik?></label>
                                <div class="col-md-6" style="padding-left:0px;">
                                  <select class="form-control" name="facilty" id="facilty" onchange="faci_type()" >
									  <option value="">Select Fee Type</option>									  
                                      <option value="1">Hostel Fees</option>
                                      <option value="4" <?php if($productinfo=='Hostel_Gym_new' || $productinfo=='Gym'){ echo "selected";} ?>>Hostel GYM</option>
									   

								  </select>
                                </div>
                                
                              </div>
							  
							  <div class="form-group" id="f_category" style="display:none;">
                                <label class="col-md-5" style="padding-left:0px;">category:<?=$astrik?></label>
                                <div class="col-md-6">
                                  <select class="form-control" name="category" id="category" onchange="display_fees_details()" >
									  <option value="">select category</option>
								  </select>
                                </div>
                                
                              </div>
							  							  
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Deposited Bank:<?=$astrik?></label>
                                <div class="col-md-6" style="padding-left:0px;">
								  <select class="form-control" name="depositto" id="depositto" >
									  <option value="">select Deposited Bank</option>
									   <?php 
										if(!empty($depositedto_details)){
											foreach($depositedto_details as $deposit){
												?>
											  <option value="<?=$deposit['bank_account_id']?>"  ><?=$deposit['branch_name']?> - <?=$deposit['bank_name']?></option>  
											<?php 
												
											}
										}
								  ?>
								  </select>
                                </div>
                              </div>
							  <div class="form-group">
							<span style="color:red;" id="err_msg2"></span>
						</div>
						
						  </div>
						</div>
                              
                            </div>
                          
                        
                        <div class="col-md-7" id="emptab"> 
						
                        <!--<div class="panel">
                         <div class="panel-body"><div class="col-md-12" >
                        
                        </div></div></div>-->
                        
                        
                        <div class="panel" id="fee_detailss">
                   
							<div class="panel-heading">
							
							
							<b>Fee Details:</b>
							</div>
                            
                           <div class="panel-body">
							<div id="fee_details" style="display:block;">
							
						<input type="hidden" value="" id="ffacility">
						<input type="hidden" value="" id="fdeposit">
						<input type="hidden" value="" id="fgymfee">
						<input type="hidden" value="" id="famt">
                        
							
                              </div>
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Gym Fee:</label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control numbersOnly" value="<?php echo $user_details[0]['amount']; ?>" name="gymfee" id="gymfee" onblur="calc_final_amount();"/>
                                </div>
                                
                              </div>
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Fine Fee:</label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control numbersOnly" value="0" name="finefee" id="finefee" onblur="calc_final_amount();" />
                                </div>
                                
                              </div>
                             <!-- <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Other Fee:</label>
                                             <div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="other" id="other" value="0" onblur="calc_final_amount();"/>								   
										   </div>			 
									  </div-->  
                                      <div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Excess Fees:<?=$astrik?></label>
													 <div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="Excess" id="Excess" value="0" onblur="calc_final_amount();"/>
									   </div>
								  </div>
										<div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Amount Paid:<?=$astrik?></label>
													 <div class="col-md-6" >
                                                      <input type="hidden" class="form-control numbersOnly" id="amt" value="<?php echo $user_details[0]['amount']-$user_details[0]['deposit_fees']; ?>" readonly/>
											 <input type="text" class="form-control numbersOnly" name="amt"  value="<?php echo $user_details[0]['amount']; ?>" readonly/>
									   </div>
								  </div>
									<div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Paid By:<?=$astrik?></label>
										<div class="col-md-6" >
											<select name="epayment_type" id="epayment_type" onchange1="display_noncash()" class="form-control" >
												<option value="">Select Paid By</option>
											<option value="CHQ" >Cheque</option>
											<option value="DD" >DD</option>
                                             <option value="UTR">UTR-DRCC</option>
											<option value="POS">POS</option>
                                            <option value="ONLINE" selected="selected">ONLINE</option>
											<option value="CASH">Cash</option>
                                            <option value="UPI">UPI</option>
                                            
											</select>	
										   </div>
										
									  </div>  
									  
									  <div id="non_cash">
										<div class="form-group">
										
										<label class="col-md-5" style="padding-left:0px;" id="receipt"></label>
											<div class="col-md-6" >
											<input type="text" class="form-control"  name="receipt_number" id="receipt_number" value="<?php echo $user_details[0]['bank_ref_num']; ?>" /><a href="javascript:void(0);" id="Check_recepit" class="Check_recepit btn btn-primary">Check</a>

										</div>
										
									<div class="form-group" style="display: flex; justify-content: center; align-items: center; margin-bottom: 15px;">
										<div class="col-md-4" style="flex: 0 0 33%;"></div>
										<div class="col-md-6" style="flex: 0 0 50%; text-align: center;">
											<div class="error_msg" style="color: Black; font-weight: bold;"></div>
										</div>
										<div class="col-md-1" style="flex: 0 0 17%;"></div>
									</div>

										</div>
										
										
								  <div class="form-group">
										<label class="col-md-5" style="padding-left:0px;" id="paiddate"></label>
													 <div class="col-md-6" >
											 <input type="text" id="fees_date" name="fees_date" class="form-control"   readonly="true" value="<?php echo $user_details[0]['payment_date']; ?>" />
											 
									   </div>
								  </div>
								  
								  <div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Bank Name:<?=$astrik?></label>
								<div class="col-md-6" >
									<select class="form-control" name="bank" id="bank" >
									  <option value="">select Bank</option>
									   <?php 
													if(!empty($bank_details)){
														foreach($bank_details as $bank){
															?>
														  <option value="<?=$bank['bank_id']?>"><?=$bank['bank_name']?></option>  
														<?php 
															
														}
													}
											  ?>
								  </select>
									   </div>
								  </div>
								  
								  <div class="form-group"><!--onchange="total_fees()"-->
									<label class="col-md-5" style="padding-left:0px;" id="pbranch">Bank Branch:</label>
								<div class="col-md-6" >
								<input type="text" class="form-control alphaOnly"  name="branch" id="branch" />
                                       </div>
                                  </div>  
								  
								  
								  
								  </div>
								  <div class="form-group" id="btns">
 
							  <div id="part_approval" style="display:none">
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Approved By:<?=$astrik?></label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control" name="approvar_name" id="approvar_name" />
                                </div>
                                </div>
							   <div class="form-group" >
                                <label class="col-sm-5" style="padding-left:0px;">Upload document:<?=$astrik?></label>
                                    <div class="col-sm-6"><input type="file" name="payfile" id="payfile" ><a href="http://localhost:8080/erp/uploads/student_challans/" target="_blank"></a>
									</div>
                               </div>
                             </div>
                                <div class=" col-md-5">
                                  <button type="submit" class="btn btn-primary form-control Generate" >Generate</button>
                                </div>
                                   <div class="col-sm-5"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/fees_challan_list'">Cancel</button></div>
                 
                              </div>
							</div>
							
						</div>
						
					</div>
                    
                    
                    
                    
                    
                          
                                  
                                  
                                  
								  <div class="form-group" id="btns" style="display:none;">
                                  
                              
                               
                                <div class=" col-md-5">
                                  <button type="submit" class="btn btn-primary form-control Generate" >Generate</button>
                                </div>
                                   <div class="col-sm-5"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/fees_challan_list'">Cancel</button></div>
                 
                              </div>
							
							
						</div>
						</div>
						
							
					  </form>
						
						
						
                   
					  
                    </div>
						
					<div class="col-md-3"></div>
					<span id="err_msg1" style="color:red;padding-left:10px;"></span>
                </div>
            </div>
        </div>    
    </div>
    
</div>

 