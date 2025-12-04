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
                }/* ,
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
                } */
		}       
        })
   
	
    $('#sbutton').click(function()
	{
		// alert("hi");
		var base_url = '<?=base_url();?>';
		// alert(type);
		var prn = $("#prn").val();

		if(prn=='' )
		{
			$('#err_msg').html("Please enter PRN Number.");
			$('#std_details').hide();
			$('#fee_details').hide();
			$('#btns').hide();
			return false;
		}
        else
		{  
			$.ajax({
				'url' : base_url + 'Hostel/students_data',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'enrollment_no':prn},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					//var container = $('#stddata'); //jquery selector (get element by id)
					//alert(data);
					if(data != "{\"std_details\":null}")
					{
						
						$('#err_msg2').html('');
						$('#err_msg').html('');
						$('#std_details').show();
						var array=JSON.parse(data);
						
						$('#prnno').html(array.std_details.enrollment_no);
						$('#enroll').val(array.std_details.enrollment_no);
						$('#student_id').val(array.std_details.stud_id);
						$('#std_name').html(array.std_details.first_name+' '+array.std_details.middle_name+' '+array.std_details.last_name);
						$('#organisation').html(array.std_details.organisation);
						
						$('#orgs').val(array.std_details.organisation);
						$('#stream').html(array.std_details.stream_name);
						$('#crs').val(array.std_details.course_name);
						$('#name').val(array.std_details.first_name+' '+array.std_details.middle_name+' '+array.std_details.last_name);
						$('#institute').html(array.std_details.school_name);
						$('#mobile1').html(array.std_details.mobile);
						$('#mbl').val(array.std_details.mobile);
						$('#inst').val(array.std_details.school_name);
						if(array.std_details.organisation=="SU")
							$('#course').html(array.std_details.stream_name);
						else 
							if(array.std_details.admission_stream !=0){
						$('#course').html(array.std_details.course_name+' '+array.std_details.stream_name);
							}else{
							$('#course').html(array.std_details.sfcourse+' '+array.std_details.sfstream);	
							}
						$('#cyear').val(array.std_details.current_year);
						$('#current_year').html(array.std_details.current_year);
						$('#academic_year').html(array.std_details.academic_year);
						$('#admission_year').html(array.std_details.admission_session);
						var floor='';
						if(array.std_details.floor_no==0)
						floor='G';
						else	
						floor=array.std_details.floor_no;

						$('#hostel').html(array.std_details.hostel_code);
						$('#floor_no').html(floor+' / '+array.std_details.room_no);
							
					}
					else
					{
						$('#std_details').hide();
						$('#fee_details').hide();
						$('#err_msg').html('This student has no hostel facility for the selected academic year');
						//return false;
					}
				}
			});
		}
    });
});

$(document).ready(function()
{
	
	$("#fees_date").datepicker({       
        autoclose: true,
		format: 'dd-mm-yyyy'		
    }).on('changeDate', function (selected) {
        $('#form').bootstrapValidator('revalidateField', 'fees_date');

    });
	
	$('#fees_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true});	
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
	
	
	$('#year').on('change', function () {
		var academic = $('#academic').val();
		var year = $('#year').val();
		if(academic) 
		{
			type='POST',url='<?= base_url() ?>Master/get_academic_stream_list',datastring={academic:academic,year:year};
			html_content=ajaxcall(type,url,datastring);
			//alert(html_content);
			if(html_content!="")
			{
				$('#err_msg').html('');
				$('#streamlist').html(html_content);
				$('#show_list').show();
				$('#emptab').show();
			}
			else
			{
				$('#streamlist').html('');
				$('#show_list').hide();
				$('#emptab').hide();
				$('#err_msg').html('No Data');
				//$('#show_facilities').show();
			}
		}
		else 
		{
			$('#err_msg').html('Please select academic year');
			$('#streamlist').html('');
			$('#emptab').hide();
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
var numberOfChecked =0;
function form_validate(event)
{
	/* $("input:checkbox[class=chk]:checked").each(function () {
            alert("Id: " + $(this).attr("id") + " Value: " + $(this).val());
        }); */
		
	numberOfChecked = $('input:checkbox[class=chk]:checked').length;
	//var totalCheckboxes = $('input:checkbox').length;
	//var numberNotChecked = totalCheckboxes - numberOfChecked;
	
	//alert(numberOfChecked);
	if(numberOfChecked==0)
	{
		$('#err_msg').html('Please select stream Name.');
		return false;
	}
}

function faci_type()
{
	var academic = $('#academic').val();
	var facility = $('#facilty').val();
	var facility_type= $("#facilty option:selected").text();
	var enroll = $('#enroll').val();
	
	if(academic!='' && facility!='')
	{
		type='POST',url='<?= base_url() ?>Hostel/get_faci_fee_details',datastring={academic:academic,facility:facility,enroll:enroll};
		html_content=ajaxcall(type,url,datastring);
		if(html_content != "{\"fee_details\":null}")
		{
			//alert(html_content);
			var array=JSON.parse(html_content);
			//$('#deposit').val(array.fee_details.deposit_fees);
			//$('#gymfee').val(array.fee_details.gym_fees);
			//$('#finefee').val(array.fee_details.fine_fees);
			//$('#facility').val(array.fee_details.actual_fees);
			$('#btns').show();
			$('#fee_details').show();
			$('#err_msg2').html('');
		}
		else
		{
			$('#btns').hide();
			$('#fee_details').hide();
			$('#err_msg2').html('Not opted the facility yet');
		}
		//alert(facility_type);
		type='POST',url='<?= base_url() ?>Hostel/get_depositedto',datastring={faci_type:facility_type};
		html_content=ajaxcall(type,url,datastring);
		//alert(html_content);
		$('#depositto').html(html_content);
	}
	else
	{
		$('#btns').hide();
		$('#fee_details').hide();
	}
	
}
function calc_final_amount(){
			var cricket_ground_charges = $('#cricket_ground_charges').val();
			var accomodation_charges = $('#accomodation_charges').val();
			var fine = $('#finefee').val();
			var othr = $('#other').val();
			
			var final_amount = parseInt(cricket_ground_charges)+parseInt(accomodation_charges)+parseInt(fine)+parseInt(othr); 
			$('#amt').val(final_amount);
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
            <h1 class="col-xs-5 text-ctext-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Generate Guest challan </h1>
            
									
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
					</div>
					</div>
                    <div class="panel-body">
					<form id="form" name="form" action="<?=base_url($currentModule.'/add_guest_challan_submit')?>" method="POST" >
						
                          
                             <input type="hidden"  id="online_payment_id" name="online_payment_id" value="<?php echo $payment_id;?>"/>
                             <input type="hidden"  id="facilty" name="facilty" value="11"/>
                            <div class="col-md-6" id="std_details" style="padding-right:0px;">
							
							<div class="panel">
                   
							<div class="panel-heading">
							<b>Personal Details:</b>
							</div>
							
                            <div class="panel-body">
							
								<div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Name:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 <input type="text" class="form-control" id="guest_name" name="guest_name" value="<?php echo $user_details[0]['firstname']?>"/>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Mobile:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									  <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $user_details[0]['phone']?>"/>							   
								   </div>			 
							  </div>
							 
							  <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Institute:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 <input type="text" class="form-control" id="organisation" name="organisation" value="<?php echo $user_details[0]['registration_no']?>"/>
									 							   
								   </div>			 
							  </div>
							   <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Address:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 <textarea class="form-control" id="address" name="address" /></textarea>								   
								   </div>			 
							  </div>
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Academic Year:<?=$astrik?></label>
                                <div class="col-md-7" style="padding-left:0px;">
                                  <select class="form-control" name="academic" id="academic" >
									   <option value="">Academic Year</option>
									   <option value="2025" selected>2025</option> 
									   <!--option value="2022" >2022</option> 
									   <option value="2021">2021</option> 
									   <option value="2020">2020</option> 
											<option value="2019">2019</option--> 
									  </select>
                                </div>
                                
                              </div>
							  <div class="form-group">
							<span style="color:red;" id="err_msg2"></span>
						</div>
						
						  </div>
						</div>
                              
                            </div>
                          
                        
                        <div class="col-md-6" id="emptab"> 
						<div class="panel" id="fee_details">
                   
							<div class="panel-heading">
							
							
							<b>Fee Details:</b>
							</div>
                            <div class="panel-body">
							
							
						
							<div class="col-md-12" >
								
								<div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Hostel Accomodation charges:</label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control numbersOnly"  name="accomodation_charges" id="accomodation_charges" value="<?php if(!empty($user_details[0]['amount'])){ echo $user_details[0]['amount'];}else{ echo 0;}?>" onblur="calc_final_amount();"/>
                                </div>
                                
                              </div>
							  
							   <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Cricket ground charges:</label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control numbersOnly"  value="0" name="cricket_ground_charges" id="cricket_ground_charges" onblur="calc_final_amount();"/>
                                </div>
                                
                              </div>
							  
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Fine Fee:</label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control numbersOnly" value="0" name="finefee" id="finefee" onblur="calc_final_amount();" />
                                </div>
                                
                              </div>
                              <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Other Fee:</label>
                                             <div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="other" id="other" value="0" onblur="calc_final_amount();"/>								   
										   </div>			 
									  </div>  
										<div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Amount Paid:<?=$astrik?></label>
													 <div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="amt" id="amt" value="<?php echo $user_details[0]['amount'];?>" readonly/>
									   </div>
								  </div>
									<div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Paid By:<?=$astrik?></label>
										<div class="col-md-6" >
											<select name="epayment_type" id="epayment_type" class="form-control" >
											<option value="">Select Paid By</option>
											<option value="CHQ" >Cheque</option>
											<option value="DD" >DD</option>
											<option value="POS">POS</option>
											<option value="CASH">Cash</option>
											<option value="Online">Online</option>
											</select>	
										   </div>
										
									  </div>  
									  
									  <div id="non_cash" style="display:none;">
										<div class="form-group">
										
										<label class="col-md-5" style="padding-left:0px;" id="receipt"></label>
											<div class="col-md-6" >
											<input type="text" class="form-control numbersOnly"  name="receipt_number" id="receipt_number"  value="<?php echo $user_details[0]['bank_ref_num'];?>" />
										</div>
										</div>
										
										
								  <div class="form-group">
										<label class="col-md-5" style="padding-left:0px;" id="paiddate"></label>
													 <div class="col-md-6" >
											 <input type="text" id="fees_date" name="fees_date" class="form-control"  value="<?php echo $user_details[0]['payment_date'];?>"  readonly="true" />
											 
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
								  
								  <div class="form-group">
									<label class="col-md-5" style="padding-left:0px;">Bank Branch:</label>
											 <div class="col-md-6" >
											 <input type="text" class="form-control alphaOnly" onchange="total_fees()" name="branch" id="branch" />
                                       </div>
                                  </div>  
								  
								  
								  
								  </div>
								  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Deposited Bank:<?=$astrik?></label>
                                <div class="col-md-6">
								  <select class="form-control depositto" name="depositto" id="depositto" required>
									  <option value="">select Deposited Bank</option>
									   <?php 
										if(!empty($depositedto_details)){
											foreach($depositedto_details as $deposit){
												?>
											  <option value="<?=$deposit['bank_account_id']?>"><?=$deposit['account_name']?> - <?=$deposit['bank_name']?></option>  
											<?php 
												
											}
										}
								  ?>
								  </select>
                                </div>
                              </div>
							<div class="form-group" id="btns">
                               
                                <div class=" col-md-5">
                                  <button type="submit" class="btn btn-primary form-control" >Generate</button>
                                </div>
                                   <div class="col-sm-5"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/guest_challan_list'">Cancel</button></div>
                 
                              </div>
							</div>
							
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
<script>
$(document).ready(function(){
$("#epayment_type").on('change',function(e){
	
	var ptype = $('#epayment_type').val();
	var ne="";
	if(ptype=="POS")
	{
		document.querySelector('#depositto').selectedIndex = 3;
		$('#receipt').html(ptype+' No. :<?=$astrik?>');
		$('#paiddate').html(ptype+' Date. :<?=$astrik?>');
		$('#non_cash').show();
	}	
	else if(ptype=="Online")
	{
		document.querySelector('#depositto').selectedIndex = 3;
		$('#receipt').html(ptype+' No. :<?=$astrik?>');
		$('#paiddate').html(ptype+' Date. :<?=$astrik?>');
		$('#non_cash').show();
	}
	else if(ptype=="CASH")
	{
		document.querySelector('#depositto').selectedIndex = 0;
		$('#non_cash').hide();

	}else{
		document.querySelector('#depositto').selectedIndex = 0;
		$('#receipt').html(ptype+' No. :<?=$astrik?>');
		$('#paiddate').html(ptype+' Date. :<?=$astrik?>');
		$('#non_cash').show();
	}
});
});
</script>
