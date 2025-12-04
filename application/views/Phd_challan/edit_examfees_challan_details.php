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
                },challan_status:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select action'
                      },
                      required: 
                      {
                       message: 'Please select action'
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
var challan_status='<?=$challan_details['challan_status']?>';

$(document).ready(function()
{	 var challan_status='<?=$challan_details['challan_status']?>';	$('#challan_status option').each(function()	{              		 if($(this).val()== challan_status)		{		$(this).attr('selected','selected');		}	}); 	
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var mmm= today.getMonth();
	var yyyy = today.getFullYear();
	if(dd<10){
	dd='0'+dd;
	} 
	if(mm<10){
	mm='0'+mm;
	} 
	var today = dd+'/'+mm+'/'+yyyy;
	
	//$('#header_date').html(dd+" "+monthNames[mmm]+", "+yyyy%100);
	
  $('#deposit_date').val(today);
  
  
	$("#fees_date").datepicker({       
        autoclose: true,
		format: 'dd/mm/yyyy'		
    }).on('changeDate', function (selected) {
        $('#form').bootstrapValidator('revalidateField', 'fees_date');

    });
	
	$("#deposit_date").datepicker({       
        autoclose: true,
		format: 'dd/mm/yyyy'		
    }).on('changeDate', function (selected) {
        $('#form').bootstrapValidator('revalidateField', 'fees_date');

    });
	
	$('#fees_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});	
	
	display_noncash();
	
	if(challan_status=='PD')
	{
		$("#display").show();
	}
	else
	{
		$("#display").hide();
		$("#btn_cancel").html('Back');
	}
	
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
var student_id='<?=$challan_details['student_id']?>';
var enrollment_no='<?=$challan_details['enrollment_no']?>';
var academic_year='<?=$challan_details['academic_year']?>';
var type_id='<?=$challan_details['type_id']?>';
function display_noncash()
{
	$('#student_id').val(student_id);
	$('#enroll').val(enrollment_no);
	$('#academic').val(academic_year);	
	$('#facilty').val(type_id);
	var ptype = $('#epayment_type').val();
	if(ptype=='CASH')
	{
		$('#non_cash').hide();
	}
	else
	{
		$('#receipt').html(ptype+' no. :<?=$astrik?>');
		$('#paiddate').html(ptype+' date. :<?=$astrik?>');
		$('#non_cash').show();
	}
		faci_type();
}

function faci_type(){	
var academic = $('#academic').val();	
var facility = $('#facilty').val();	
var enroll = $('#enroll').val();	
var stud = $('#student_id').val();
	if(academic!='' && facility!='')	{	
		type='POST';		url='<?= base_url() ?>Challan/get_fee_details';		datastring={academic:academic,facility:facility,enroll:enroll,stud:stud};	
			html_content=ajaxcall(type,url,datastring);		
			var array=JSON.parse(html_content);	
	var apend = array.applicable_fee - array.amount_paid;	
	$('#apend').val(apend);	
	if(facility=="2"){
	$('#apaid').val(array.amount_paid);		
	$('#facility').val(array.applicable_fee);	
	}else if(facility=="5"){
		var amt =$('#amt').val();
	$('#apaid').val(amt);		
	$('#facility').val(amt);
	}else if(facility=="10"){
			var amt =$('#amt').val();
	$('#apaid').val(amt);		
	$('#facility').val(amt);
	}else if(facility=="11"){
			var amt =$('#amt').val();
	$('#apaid').val(amt);		
	$('#facility').val(amt);
	}
					
		$('#err_msg2').html('');	}	}
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
            <h1 class="col-xs-5 text-ctext-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View challan </h1>            <span id="rrrr" style="color:red;"></span>
        </div>

        <div class="row ">
            <div class="col-sm-12">
				
                   <form id="form" name="form" action="<?=base_url($currentModule.'/edit_fees_challan_submit/'.$challan_details['fees_id'])?>" method="POST" >
                             
                            <div class="col-md-6" id="std_details" style="padding-right:0px;">
							
							<div class="panel">
                   
							<div class="panel-heading">
							<b>Student Details:</b>
							</div>
							
                            <div class="panel-body">
				
                              
                                <?php
								//print_r($challan_details);
								
								
								 if($challan_details['type_id']==11){ ?> 
                                <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Name:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 
									 <span id="mobile1" name="mobile1"><?=$challan_details['guest_name']?></span>								   
								   </div>			 
							  </div>
                              <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Mobile:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 
									 <span id="mobile1" name="mobile1"><?=$challan_details['guest_mobile']?></span>								   
								   </div>			 
							  </div>
                              <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Institute:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 
									 <span id="mobile1" name="mobile1"><?=$challan_details['guest_organisation']?></span>								   
								   </div>			 
							  </div>
                                <?php }else{ ?>
                              <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">ID/PRN:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 <input type="hidden" id="enroll" name="enroll" value="<?=$challan_details['enrollment_no']?>" />
									 <input type="hidden" id="student_id" name="student_id" value="<?=$challan_details['student_id']?>" />
									  <input type="hidden" id="challan_no" name="challan_no" value="<?=$challan_details['exam_session']?>" />
									 
									 <span id="prnno" name="prnno"> <?=$challan_details['enrollment_no']?></span>								   
								   </div>			 
							  </div>
                              
								<div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Name:</label>
									 <div class="col-md-8" style="padding-left:20px;" >
									  <span id="std_name" name="std_name">
									  <?=$challan_details['first_name']?> <?=$challan_details['middle_name']?> <?=$challan_details['last_name']?>
                                      </span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Course:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 
									 <span id="course" name="course"><?=$challan_details['course_name']?></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Institute:</label>
									 <div class="col-md-7"  style="padding-left:20px;">
									 <span id="organisation" name="organisation"><?=$challan_details['school_name']?></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Current Year:</label>
									 <div class="col-md-7"  style="padding-left:20px;">
									 
									 <span id="current_year" name="current_year"><?=$challan_details['current_year']?></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Mobile:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 
									 <span id="mobile1" name="mobile1"><?=$challan_details['mobile']?></span>								   
								   </div>			 
							  </div>
                              
                              <?php } ?>
                              
                              
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Academic Year:<?=$challan_details['academic_year']?></label>
                                <div class="col-md-5" style="padding-left:0px;">
                                  
							<?php 
							/*$yyyy=date('Y');
							$yy=date('y')+1;
							for($i=1;$i<=4;$i++)
							{
							   if($yyyy==$challan_details['academic_year'])
								{*/
										?> 
										<input type="hidden" class="form-control" name="academic" id="academic" value="<?=$challan_details['academic_year']?>" />
										
										  <input type="text" class="form-control" readonly name="academicyear" id="academicyear" value="<?=$challan_details['academic_year']?>" />
										<?php 
								/*}						   
							   $yyyy--;$yy--;
							}*/
							?>
								  
                                </div>
                                
                              </div>
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Fee Type:</label>
                                <div class="col-md-5"  style="padding-left:0px;">
								
									   <?php 
									if($challan_details['type_id']==2)	
									$ftype='Academic Fees';	
									else if($challan_details['type_id']==5)
									$ftype='Exam Fees';
									else if($challan_details['type_id']==10)
									$ftype='Other Fees';
									else if($challan_details['type_id']==11)
									$ftype='External Fees';
										?> 
										  <input type="hidden" class="form-control numbersOnly" name="facilty" id="facilty" value="<?=$challan_details['type_id']?>" />
										  
										  <input type="text" class="form-control numbersOnly" readonly name="facilty_type" id="facilty_type" value="<?=$ftype?>" />
										

								 
                                </div>
                              </div>
							  
							  <div class="form-group" id="f_category" style="display:none;">
                                <label class="col-md-5" style="padding-left:0px;">category:</label>
                                <div class="col-md-5"  style="padding-left:0px;">
                                  <select class="form-control" name="category" id="category" onchange="11display_fees_details()" >
									  <option value="">select category</option>
									  
									  
								  </select>
                                </div>
                                
                              </div>
							  							  
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Deposited Bank:</label>
                                <div class="col-md-5"  style="padding-left:0px;">
								 
							<?php 
									if(!empty($depositedto_details)){
										foreach($depositedto_details as $facility){
											if($facility['bank_id']==$challan_details['bank_account_id'])
											{
											?>
											<input type="hidden" name="su_bank" value="<?=$challan_details['bank_account_id']?>">
										<input type="text" class="form-control" readonly name="depositto" id="depositto" value="<?=$facility['account_name']?> - <?=$facility['bank_name']?>" /> 														  
										<?php 
											}
											
										}
									}
							  ?>
				
                                </div>
                              </div>
							  
			
						  </div>
						</div>
                              
                      </div>
                          
                        
                        <div class="col-md-6" id="emptab"> 
						<div class="panel" id="fee_details" >
                   
							<div class="panel-heading">
							
							
							<b>Challan Details:</b>
							</div>
                            <div class="panel-body">
                            		<div class="form-group">                              
                                  <label class="col-md-5" style="padding-left:0px;"> Backlog Exam Fees:</label>                      
                                  <div class="col-md-6">                                   
                       		<input type="text" class="form-control numbersOnly"  value="<?=$challan_details['Backlog_fees']?>" readonly name="Backlog" id="Backlog" />                 
                                      </div>                                                              
                                  </div> 

                                  	<div class="form-group">                              
                                  <label class="col-md-5" style="padding-left:0px;"> Photocopy Fees:</label>                      
                                  <div class="col-md-6">                                   
                       		<input type="text" class="form-control numbersOnly"  value="<?=$challan_details['Photocopy_fees']?>" readonly name="Photocopy" id="Photocopy" />                 
                                      </div>                                                              
                                  </div>
                                   	<div class="form-group">                              
                                  <label class="col-md-5" style="padding-left:0px;"> Revaluation Fees:</label>                      
                                  <div class="col-md-6">                                   
                       		<input type="text" class="form-control numbersOnly"  value="<?=$challan_details['Revaluation_Fees']?>" readonly name="Revaluation" id="Revaluation" />                 
                                      </div>                                                              
                                  </div>
                                    	<div class="form-group">                              
                                  <label class="col-md-5" style="padding-left:0px;"> Late Fees:</label>                      
                                  <div class="col-md-6">                                   
                       		<input type="text" class="form-control numbersOnly"  value="<?=$challan_details['Exam_LateFees']?>" readonly name="Late" id="Revaluation" />                 
                                      </div>                                                              
                                  </div>
								<div class="form-group">                              
                                  <label class="col-md-5" style="padding-left:0px;"> Total Fee:</label>                      
                                  <div class="col-md-6">                                   
                       <input type="text" class="form-control numbersOnly"  value="<?=$challan_details['amount']?>" readonly name="facility" id="facility" />                 
                                      </div>                                                              </div>                     
                                                  <div class="form-group">                               
                                                   <label class="col-md-5" style="padding-left:0px;">Amount Paid:</label>  
                             <div class="col-md-6">                        
                             <input type="text" class="form-control numbersOnly"  value="<?=$challan_details['amount']?>" readonly name="apaid" id="apaid" readonly/>                                </div>                                                              </div>                                                                  <div class="form-group">                                <label class="col-md-5" style="padding-left:0px;">Amount Pending:</label>                                <div class="col-md-6">                                   <input type="text" class="form-control numbersOnly"  value="0" readonly name="apend" id="apend" readonly/>                               
                                             </div>                                                            
                                               </div> 
										<div class="form-group">
										<label class="col-md-5">Amount:</label>
													 <div class="col-md-6" >
											 <input type="text" readonly class="form-control numbersOnly"  value="<?=$challan_details['amount']?>" name="amt" id="amt" />
									   </div>
								  </div>
										<div class="form-group">
										<label class="col-md-5">Paid By:</label>
										<div class="col-md-6" >
										<input type="text" class="form-control " value="<?=$challan_details['fees_paid_type']?>" readonly name="epayment_type" id="epayment_type" />
										
										   </div>
										
									  </div>  
									  
									  
									  
					<div id="non_cash" style="display:none;">
										<div class="form-group">
										
										<label class="col-md-5" id="receipt"></label>
											<div class="col-md-6" >
											<input type="text" class="form-control numbersOnly"  name="receipt_number" readonly id="receipt_number" value="<?=$challan_details['receipt_no']?>" />
										</div>
										</div>
										
										
								  <div class="form-group">
										<label class="col-md-5"id="paiddate"></label>
													 <div class="col-md-6" >
											 <input type="text" id="fees_date" value="<?php echo date("d/m/Y", strtotime($challan_details['fees_date']));?>" name="fees_date" class="form-control"   readonly="true" />
											 
									   </div>
								  </div>
								  <div class="form-group">
										<label class="col-md-5">Bank Name:</label>
								<div class="col-md-6" >
								
									   <?php 
									if(!empty($bank_details)){
										foreach($bank_details as $bank){	
												if($bank['bank_id']==$challan_details['bank_id'])
												{
												?>
											  <input type="hidden" class="form-control " value="<?=$bank['bank_id']?>" name="bank" id="bank" />
											  <input type="text" class="form-control " value="<?=$bank['bank_name']?>" readonly name="bankname" id="bankname" />
											<?php 
												}														
											}
										}
								  ?>
								
							</div>
								  </div>
								  
								  <div class="form-group">
									<label class="col-md-5">Bank Branch:</label>
											 <div class="col-md-6" >
											 <input type="text" class="form-control alphaOnly" value="<?=$challan_details['bank_city']?>" readonly onchange="total_fees()" name="branch" id="branch" />
                                       </div>
                               </div>  
								  
								  
								  
						</div>
							
							<div class="form-group">
								<label class="col-md-5">Action:<?=$astrik?></label>
								<div class="col-md-6" >
									<select name="challan_status" id="challan_status" class="form-control" >
										<option value="">Select Action</option>
									<option value="VR" >Deposited</option>
									<option value="CL" >Cancelled</option>
									</select>	
								   </div>
								
							  </div> 
							<div class="form-group">
										<label class="col-md-5" >Deposited Date:<?=$astrik?></label>
													 <div class="col-md-6" >
											 <input type="text" id="deposit_date" name="deposit_date" class="form-control"   readonly="true" />
											 
									   </div>
								  </div>
							
							
							<div class="form-group">
                                <div class="col-md-2"></div>
                                <div class=" col-md-4">
                                  <button type="submit" id="display" class="btn btn-primary form-control" >Submit</button>
                                </div>
                                   <div class="col-sm-4"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                 
                              </div>
							  
							 <div class="form-group">
							 <div class="col-md-12">
								<span id="flash-messages" style="color:Green;">
										 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
									<span id="flash-messages" style="color:red;">
										 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
								</div>
								</div>
							</div>
						</div>
						
					
							<span id="err_msg" style="color:red;padding-left:10px;"></span>
							
							
					
					  
					  
					  
				
					  
					 
				</form>
					  
                </div>
					
				
					
					<div class="col-md-3"></div>
					
					<span id="err_msg1" style="color:red;padding-left:10px;"></span>
            </div>
				
          </div>
			
			
        </div>    
		
    </div>
    
</div>
