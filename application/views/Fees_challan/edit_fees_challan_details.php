<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
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
				f_category:
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
				depositto:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select deposit to '
                      },
                      required: 
                      {
                       message: 'Please select deposit to '
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
                },
				branch:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please enter bank branch'
                      },
                      required: 
                      {
                       message: 'Please enter bank branch'
                      }
                     
                    }
                }
		}       
        })
   
	
});
var facility='<?=$challan_details['type_id']?>';
var category='<?=$challan_details['college_receiptno']?>';//category
var paidby='<?=$challan_details['fees_paid_type']?>';
$(document).ready(function()
{
	
	$("#fees_date").datepicker({       
        autoclose: true,
		format: 'yyyy-mm-dd'		
    }).on('changeDate', function (selected) {
        $('#form').bootstrapValidator('revalidateField', 'fees_date');

    });
	
	$('#fees_date').datepicker( {format: 'yyyy-mm-dd',autoclose: true});	
	 // Num check logic
  	$('.numbersOnly').keyup(function () {
		
    if (this.value != this.value.replace(/[^0-9]/g, '')) {
       this.value = this.value.replace(/[^0-9]/g, '');
    } 
  	});
	
	$('.alphaOnly').keyup(function () {
		
    if (this.value != this.value.replace(/[^A-Za-z ]/g, '')) {
       this.value = this.value.replace(/[^A-Za-z ]/g, '');
    } 
  	});
	
	
	$('#facilty option').each(function()
	{              
		if($(this).val()== facility)
		{
			$(this).attr('selected','selected');
		}
		faci_type();
	});
	
	$('#category option').each(function()
	{              
		if($(this).val()== category)
		{
			$(this).attr('selected','selected');
		}
	});
   
   $('#epayment_type option').each(function()
	{              
		if($(this).val()== paidby)
		{
			$(this).attr('selected','selected');
		}
		display_noncash();
	});
});
	
function ajaxcall(type,url,datastring)
{  
	var res;
	$.ajax({
		type:type,
		url:url,
		data:datastring,
		cache:false,
		async:false,
		success: function(result)
	 {
	  res=result;	 
	 }
	});
	return res; 
}

function faci_type()
{
	var academic = $('#academic').val();
	var facility = $('#facilty').val();
	if(academic && facility)
	{
		/* if(facility==1)
			url='<?= base_url() ?>Fees_challan/get_faci_fee_details';
		else */
		//alert(facility);
			url='<?= base_url() ?>Fees_challan/get_faci_category_details';
		type='POST',datastring={academic:academic,facility:facility};
		html_content=ajaxcall(type,url,datastring);
		if(html_content!="")
		{
			//alert(html_content);
			$('#f_category').show();
			$('#category').html(html_content);
		}
		else
		{
			$('#category').html(html_content);
		}
	}
	else
	{
		$('#f_category').hide();
	}
}

function display_fees_details()
{
	var academic = $('#academic').val();
	var facility = $('#facilty').val();
	var category = $('#category').val();
	//alert(academic+'=='+facility+'=='+category);
	if(academic!='' && facility!='' && category!='')
	{
		type='POST',url='<?= base_url() ?>Fees_challan/get_faci_fee_details',datastring={academic:academic,facility:facility,category:category};
		html_content=ajaxcall(type,url,datastring);
		if(html_content != "{\"fee_details\":null}")
		{
			//alert(html_content);
			var array=JSON.parse(html_content);
			$('#deposit').val(array.fee_details.deposit);
			$('#facility').val(array.fee_details.fees);
			$('#fee_details').show();
		}
		else
		{
			$('#fee_details').hide();
		}
	}
	
	
}


function display_noncash()
{
	var ptype = $('#epayment_type').val();
	if(ptype=='CASH')
	{
		$('#non_cash').hide();
	}
	else
	{
		$('#non_cash').show();
	}
}

function count_ischecked()
{
	numberOfChecked = $('input:checkbox[class=chk]:checked').length;
	if(numberOfChecked==0)
		$('#err_msg1').html('you have not selected any stream in streams list.');
	else
		$('#err_msg1').html('you have selected '+numberOfChecked+' streams.');
}
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>

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
                   
                    <div class="panel-body">
					<?php// echo var_dump($challan_details);?>
							<div class="portlet-body form">
                          <form id="form" name="form" action="<?=base_url($currentModule.'/edit_fees_challan_submit/'.$challan_details['fees_id'])?>" method="POST" >
                             
                            <div class="col-md-6" id="std_details">
							
							<div class="panel">
                   
							<div class="panel-heading">
							<b>Student Details:</b>
							</div>
							
                            <div class="panel-body">
							<div class="col-md-12" >
                              <div class="form-group">
								<label class="col-md-4 text-right">ID:</label>
									 <div class="col-md-8" >
									 <input type="hidden" id="enroll" name="enroll" value="<?=$challan_details['enrollment_no']?>" />
									 <input type="hidden" id="student_id" name="student_id" value="<?=$challan_details['student_id']?>" />
									 <span id="prnno" name="prnno"> <?=$challan_details['enrollment_no']?></span>								   
								   </div>			 
							  </div>
								<div class="form-group">
								<label class="col-md-4 text-right">Name:</label>
									 <div class="col-md-8" >
									  <span id="std_name" name="std_name"><?=$challan_details['first_name']?> <?=$challan_details['middle_name']?> <?=$challan_details['last_name']?></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4 text-right">Course:</label>
									 <div class="col-md-8" >
									 
									 <span id="course" name="course"><?=$challan_details['course_name']?></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4 text-right">Institute:</label>
									 <div class="col-md-8" >
									 <span id="organisation" name="organisation"><?=$challan_details['school_name']?></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4 text-right">Current Year:</label>
									 <div class="col-md-8" >
									 
									 <span id="current_year" name="current_year"><?=$challan_details['current_year']?></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4 text-right">Mobile:</label>
									 <div class="col-md-8" >
									 
									 <span id="mobile1" name="mobile1"><?=$challan_details['mobile']?></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
                                <label class="col-md-4 text-right">Academic Year:<?=$astrik?></label>
                                <div class="col-md-8">
                                  <select class="form-control" name="academic" id="academic" >
									  <option value="">select Academic Year</option>
									   <?php 
											$yyyy=date('Y');
											$yy=date('y')+1;
											for($i=1;$i<=4;$i++)
											{
											   if($yyyy==$challan_details['academic_year'])
												   echo '<option selected value="'.$yyyy.'">'.$yyyy.'-'.$yy.'</option>';
											   else 
												   echo '<option value="'.$yyyy.'">'.$yyyy.'-'.$yy.'</option>';
											   
											   $yyyy--;$yy--;
											}
										?>
								  </select>
                                </div>
                                
                              </div>
							  <div class="form-group">
                                <label class="col-md-4 text-right">Facility Type:<?=$astrik?></label>
                                <div class="col-md-8">
                                  <select class="form-control" name="facilty" id="facilty" onchange="faci_type()" >
									  <option value="">select facility</option>
									   <?php 
													if(!empty($facility_details)){
														foreach($facility_details as $facility){
															if($facility['faci_id']==$challan_details['type_id'])
															{
															?>
														  <option selected value="<?=$facility['faci_id']?>"><?=$facility['facility_name']?></option>  
														<?php 
															}
															else
															{
																?>
																
																<option  value="<?=$facility['faci_id']?>"><?=$facility['facility_name']?></option> 
														<?php
															}
														}
													}
											  ?>

								  </select>
                                </div>
                                
                              </div>
							  
							  <div class="form-group" id="f_category" style="display:none;">
                                <label class="col-md-4 text-right">category:<?=$astrik?></label>
                                <div class="col-md-8">
                                  <select class="form-control" name="category" id="category" onchange="display_fees_details()" >
									  <option value="">select category</option>
									  
									  
								  </select>
                                </div>
                                
                              </div>
							  							  
							  <div class="form-group">
                                <label class="col-md-4 text-right">Deposited To:<?=$astrik?></label>
                                <div class="col-md-8" >
								  <select class="form-control" name="depositto" id="depositto" >
									  <option value="">select Deposited To</option>
									   <?php 
													if(!empty($depositedto_details)){
														foreach($depositedto_details as $facility){
															if($facility['bank_account_id']==$challan_details['bank_account_id'])
															{
															?>
														  <option selected value="<?=$facility['bank_account_id']?>"><?=$facility['bank_name']?></option>  
														<?php 
															}
															else
															{
																?>
																
																<option  value="<?=$facility['bank_account_id']?>"><?=$facility['bank_name']?></option> 
														<?php
															}
														}
													}
											  ?>
								  </select>
                                </div>
                              </div>
							  
							</div>  
						  </div>
						</div>
                              <div class="form-group">
                                <div class="col-md-3"></div>
                                <div class=" col-md-4">
                                  <button type="submit" class="btn btn-primary form-control" >Update</button>
                                </div>
                                   <div class="col-sm-4"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/'">Cancel</button></div>
                 
                              </div>
                            </div>
                          
                        
                        <div class="col-md-6" id="emptab"> 
						<div class="panel" id="fee_details" ">
                   
							<div class="panel-heading">
							
							
							<b>Fee Details:</b>
							</div>
                            <div class="panel-body">
							
							
						
							<div class="col-md-12" >
								
								<div class="form-group">
                                <label class="col-md-4 text-right">Deposit Fee:</label>
                                <div class="col-md-8">
                                   <input type="text" class="form-control numbersOnly" readonly name="deposit" id="deposit" value="<?=$challan_details['deposit_fees']?>" />
                                </div>
                                
                              </div>
							  
							   <div class="form-group">
                                <label class="col-md-4 text-right">Facility Fee:</label>
                                <div class="col-md-8">
                                   <input type="text" class="form-control numbersOnly" value="<?=$challan_details['facility_fees']?>" readonly name="facility" id="facility" />
                                </div>
                                
                              </div>
                              <div class="form-group">
								<label class="col-md-4  text-right">Other Fee:</label>
                                             <div class="col-md-8" >
											 <input type="text" class="form-control numbersOnly" name="other" id="other" value="<?=$challan_details['other_fees']?>" />								   
										   </div>			 
									  </div>  
										<div class="form-group">
										<label class="col-md-4  text-right">Amount:<?=$astrik?></label>
													 <div class="col-md-8" >
											 <input type="text" class="form-control numbersOnly"  value="<?=$challan_details['amount']?>" name="amt" id="amt" />
									   </div>
								  </div>
										<div class="form-group">
										<label class="col-md-4  text-right">Paid By:<?=$astrik?></label>
										<div class="col-md-8" >
											<select name="epayment_type" id="epayment_type" onchange="display_noncash()" class="form-control" >
												<option value="">Select Paid By</option>
											<option value="CHQ" >Cheque</option>
											<option value="DD" >DD</option>
											<option value="CHLN">Challan</option>
											<option value="CASH">Cash</option>
											</select>	
										   </div>
										
									  </div>  
									  
									  <div id="non_cash" style="display:none;">
										<div class="form-group">
										
										<label class="col-md-4  text-right">Receipt no.:<?=$astrik?></label>
											<div class="col-md-8" >
											<input type="text" class="form-control numbersOnly"  name="receipt_number" id="receipt_number" value="<?=$challan_details['receipt_no']?>" />
										</div>
										</div>
										
										
								  <div class="form-group">
										<label class="col-md-4  text-right">Date:<?=$astrik?></label>
													 <div class="col-md-8" >
											 <input type="text" id="fees_date" value="<?=$challan_details['fees_date']?>" name="fees_date" class="form-control"   readonly="true" />
											 
									   </div>
								  </div>
								  <div class="form-group">
										<label class="col-md-4  text-right">Bank Name:<?=$astrik?></label>
								<div class="col-md-8" >
									<select class="form-control" name="bank" id="bank" >
									  <option value="">select Bank</option>
									   <?php 
													if(!empty($bank_details)){
														foreach($bank_details as $bank){
															
															
															if($bank['bank_id']==$challan_details['bank_id'])
															{
															?>
														  <option selected value="<?=$bank['bank_id']?>"><?=$bank['bank_name']?></option> 
														<?php 
															}
															else
															{
																?>
																
																<option value="<?=$bank['bank_id']?>"><?=$bank['bank_name']?></option>
														<?php
															}
															
															
														}
													}
											  ?>
								  </select>
									   </div>
								  </div>
								  
								  <div class="form-group">
									<label class="col-md-4 text-right">Bank Branch:<?=$astrik?></label>
											 <div class="col-md-8" >
											 <input type="text" class="form-control alphaOnly" value="<?=$challan_details['bank_city']?>" onchange="total_fees()" name="branch" id="branch" />
                                       </div>
                                  </div>  
								  
								  </div>
							</div>
							
						</div>
						
					</div>
							<span id="err_msg" style="color:red;padding-left:10px;"></span>
						</div>
						</form>
						
                      </div>
					  
					  
                    </div>
					<div class="col-md-3"></div>
					<span id="err_msg1" style="color:red;padding-left:10px;"></span>
                </div>
            </div>
        </div>    
    </div>
    
</div>
