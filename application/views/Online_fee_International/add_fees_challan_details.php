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
				'url' : base_url + 'Challan/students_data',
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
						$('#curr_yr').val(array.std_details.current_year);
						
						$('#std_name').html(array.std_details.first_name+' '+array.std_details.middle_name+' '+array.std_details.last_name);
						$('#organisation').html(array.std_details.organisation);
						
						//$('#orgs').val(array.std_details.organisation);
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
						$('#course').html(array.std_details.course_name+' '+array.std_details.stream_name);
					
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
		var stud = $('#student_id').val();
		var curr_yr = $('#curr_yr').val();
	
	if(academic!='' && facility!='')
	{
		type='POST',url='<?= base_url() ?>Challan/get_fee_details',datastring={academic:academic,facility:facility,enroll:enroll,stud:stud,curr_yr:curr_yr};
		html_content=ajaxcall(type,url,datastring);
	//	alert(html_content);
			var array=JSON.parse(html_content);
		//	alert(array.actual_fee);
		//	$('#deposit').val(array.actual_fee);
		
		var apend = array.applicable_fee - array.amount_paid;
			$('#apend').val(apend);
			$('#apaid').val(array.amount_paid);
			$('#facility').val(array.applicable_fee);
			
			$('#amtpand').html(apend);
			$('#amtpaid').html(array.amount_paid);
			$('#totf').html(array.applicable_fee);
			/*******************/
						$('#academic_fees').html(array.academic_fees);
						$('#tution_fees').html(array.tution_fees);
						$('#development').html(array.development);
						$('#caution_money').html(array.caution_money);
						$('#admission_form').html(array.admission_form);
						$('#Gymkhana').html(array.Gymkhana);
						$('#disaster_management').html(array.disaster_management);
						$('#student_safety_insurance').html(array.student_safety_insurance);
						$('#library').html(array.library);
						$('#registration').html(array.registration);
						$('#eligibility').html(array.eligibility);
						$('#educational_industrial_visit').html(array.educational_industrial_visit);
						$('#seminar_training').html(array.seminar_training);
						$('#exam_fees').html(array.exam_fees);
						$('#student_activity').html(array.student_activity);
						$('#lab').html(array.lab);
						/*************************/
			$('#btns').show();
			$('#fee_details').show();
			$('#err_msg2').html('');

		//alert(facility_type);
	//	type='POST',url='<?= base_url() ?>Challan/get_depositedto',datastring={faci_type:facility_type};
	//	html_content=ajaxcall(type,url,datastring);
		//alert(html_content);
	//	$('#depositto').html(html_content);
	}
	else
	{
		$('#btns').hide();
		$('#fee_details').hide();
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
		$('#receipt').html(ptype+' No. :<?=$astrik?>');
		$('#paiddate').html(ptype+' Date. :<?=$astrik?>');
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
function calc_final_amount(){
			var tutf = $('#tutf').val();
			var devf = $('#devf').val();
			var cauf = $('#cauf').val();
			var admf =  $('#admf').val();
			var exmf = $('#exmf').val();
			var unirf = $('#unirf').val();
			//alert(tutf);
			var final_amount = parseInt(tutf)+parseInt(devf)+parseInt(cauf)+parseInt(admf)+parseInt(exmf)+parseInt(unirf); 
			$('#amt').val(final_amount);
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
                   
				    <div class="panel-heading">
					<div class="row">
						<div class="col-sm-3">
			<input type="text" class="form-control numbersOnly" required name="prn" id="prn" value="<?php echo $user_details[0]['registration_no']; ?>" placeholder="PRN No."/>
						</div>
                        <div class="col-sm-2">
						<button class="btn btn-primary form-control" id="sbutton" type="button" >Submit</button>
						</div>
						<div class="col-sm-7">
							<span style="color:red;" id="err_msg"></span>
						</div>
					</div>
					</div>
                    <div class="panel-body">
					<form id="form" name="form" action="<?=base_url($currentModule.'/add_fees_challan_submit')?>" method="POST" >
						
                          
                             
                            <div class="col-md-6" id="std_details" style="padding-right:0px;display:none;">
							
							<div class="panel">
                   
							<div class="panel-heading">
							<b>Student Details:</b>
							</div>
							
                            <div class="panel-body">
							
                              <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">ID/PRN:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 <input type="hidden" id="enroll" name="enroll" />
									 <input type="hidden" id="student_id" name="student_id" />
									 <input type="hidden" id="curr_yr" name="curr_yr" />
									 <span id="prnno" name="prnno"></span>								   
								   </div>			 
							  </div>
								<div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Name:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									  <span id="std_name" name="std_name"></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Course:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 
									 <span id="course" name="course"></span>								   
								   </div>			 
							  </div>
							 <!-- <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Institute:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 <span id="organisation" name="organisation"></span>								   
								   </div>			 
							  </div>-->
							  <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Current Year:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 
									 <span id="current_year" name="current_year"></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Mobile:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 
									 <span id="mobile1" name="mobile1"></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Academic Year:<?=$astrik?></label>
                                <div class="col-md-5" style="padding-left:0px;">
                                  <select class="form-control" name="academic" id="academic" >
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
                                <label class="col-md-5" style="padding-left:0px;">Fee  Type:<?=$astrik?></label>
                                <div class="col-md-5" style="padding-left:0px;">
                                  <select class="form-control" name="facilty" id="facilty" onchange="faci_type()" >
									  <option value="">Select Fee Type</option>
									  <option value="2">Academic Fees</option>
									  	  <option value="5">Exam Fees</option>
									   <?php 
									/*	if(!empty($facility_details)){
											foreach($facility_details as $facility){
												?>
											  <option value="<?=$facility['faci_id']?>"><?=$facility['facility_name']?></option>  
											<?php 
												
											}
										}*/
									?>

								  </select>
                                </div>
                                
                              </div>
							  
							  <div class="form-group" id="f_category" style="display:none;">
                                <label class="col-md-5" style="padding-left:0px;">category:<?=$astrik?></label>
                                <div class="col-md-5">
                                  <select class="form-control" name="category" id="category" onchange="display_fees_details()" >
									  <option value="">select category</option>
								  </select>
                                </div>
                                
                              </div>
							  							  
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Deposited Bank:<?=$astrik?></label>
                                <div class="col-md-5" style="padding-left:0px;">
								  <select class="form-control" name="depositto" id="depositto" >
									  <option value="">select Deposited Bank</option>
									   <?php 
										if(!empty($depositedto_details)){
											foreach($depositedto_details as $deposit){
												?>
											  <option value="<?=$deposit['bank_id']?>"><?=$deposit['branch_name']?> - <?=$deposit['bank_name']?></option>  
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
                          
                        
                        <div class="col-md-6" id="emptab"> 
						<div class="panel" id="fee_details" style="display:none;">
                   
							<div class="panel-heading">
							
							
							<b>Fee Details:</b><button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
    more.
  </button>
							</div>
                            <div class="panel-body">
							
							
						
							<div class="col-md-12" >
								
							<!--	<div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Actual Fee:</label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control numbersOnly" value="0" readonly name="deposit" id="deposit" />
                                </div>
                                
                              </div>-->
							  
							   <div class="form-group">
                                <label class="col-md-12" style="padding-left:0px;"> Total Fee:<span id='totf'></span>, Amount Paid: <span id='amtpaid'></span>, Amount Pending: <span id='amtpand'></span></label> 
								<input type="hidden" class="form-control numbersOnly"  value="0" readonly name="facility" id="facility" />
								   <input type="hidden" class="form-control numbersOnly"  value="0" readonly name="apaid" id="apaid" readonly/>
								   <input type="hidden" class="form-control numbersOnly"  value="0" readonly name="apend" id="apend" readonly/>
                              </div>
								
								<div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Tuition Fees:<?=$astrik?></label>
										<div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="tutf" id="tutf" value="0" onblur="calc_final_amount();"/>
									   </div>
								  </div>
								<div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Development Fees:<?=$astrik?></label>
										<div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="devf" id="devf" value="0" onblur="calc_final_amount();"/>
									   </div>
								  </div>
								  <div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Caution Money:<?=$astrik?></label>
										<div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="cauf" id="cauf" value="0" onblur="calc_final_amount();"/>
									   </div>
								  </div>
								  <div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Admission Form:<?=$astrik?></label>
										<div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="admf" id="admf" value="0" onblur="calc_final_amount();"/>
									   </div>
								  </div>
								  <div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Exam fees:<?=$astrik?></label>
										<div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="exmf" id="exmf" value="0" onblur="calc_final_amount();"/>
									   </div>
								  </div>
								   <div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">University Fees:<?=$astrik?></label>
										<div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="unirf" id="unirf" value="0" onblur="calc_final_amount();"/>
									   </div>
								  </div>
								  
								 <div class="form-group">
										<label class="col-md-5" style="padding-left:0px;"> Amount:<?=$astrik?></label>
													 <div class="col-md-6" >
		<input type="text" class="form-control numbersOnly" name="amt" id="amt" readonly/>
									   </div>
								  </div>
									<div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Paid By:<?=$astrik?></label>
										<div class="col-md-6" >
											<select name="epayment_type" id="epayment_type" onchange="display_noncash()" class="form-control" >
												<option value="">Select Paid By</option>
											<option value="CHQ" >Cheque</option>
											<option value="DD" >DD</option>
											<option value="POS">POS</option>
											<option value="CASH">Challan</option>
											</select>	
										   </div>
										
									  </div>  
									  
									  <div id="non_cash" style="display:none;">
										<div class="form-group">
										
										<label class="col-md-5" style="padding-left:0px;" id="receipt"></label>
											<div class="col-md-6" >
											<input type="text" class="form-control numbersOnly"  name="receipt_number" id="receipt_number" />
										</div>
										</div>
										
										
								  <div class="form-group">
										<label class="col-md-5" style="padding-left:0px;" id="paiddate"></label>
													 <div class="col-md-6" >
											 <input type="text" id="fees_date" name="fees_date" class="form-control"   readonly="true" />
											 
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
								  <div class="form-group" id="btns" style="display:none;">
                               
                                <div class=" col-md-5">
                                  <button type="submit" class="btn btn-primary form-control" >Generate</button>
                                </div>
                                   <div class="col-sm-5"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/fees_challan_list'">Cancel</button></div>
                 
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
<!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" >
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Academic Fees Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<table class="table table-bordered">
		<thead>

    <tbody>
		<tr>
        <th width="5%">Academic Fees</th><td><span id="academic_fees"></span></td>
        <th width="5%">Tution Fees</th><td><span id="tution_fees"></span></td>
        <th width="5%">Development Fees</th><td><span id="development"></span></td>
		<th width="5%">Caution Fees</th><td><span id="caution_money"></span></td>
		
		</tr>
		<tr>
		<th width="5%">Registration Form Fees</th><td><span id="admission_form"></span></td>
        <th width="5%">Gymkhana Fees</th><td><span id="Gymkhana"></span></td>
		
		<th width="5%">Disaster Management Fees</th><td><span id="disaster_management"></span></td>
		<th width="5%">Library Fees</th><td><span id="library"></span></td>
		</tr>
		<tr>
		 <th width="5%">Registration Fees</th><td><span id="registration"></span></td>
        <th width="5%">Eligibility Fees</th><td><span id="eligibility"></span></td>
        <th width="5%">Educational industrial visit Fees</th><td><span id="educational_industrial_visit"></span></td>
		<th width="5%">Seminar training Fees</th><td><span id="seminar_training"></span></td>	
      </tr>
	  <tr>
		<th width="5%">Exam Fees</th><td><span id="exam_fees"></span></td>
        <th width="5%">Student activity Fees</th><td><span id="student_activity"></span></td>
        <th width="5%">Lab Fees</th><td><span id="lab"></span></td>
		
      </tr>
	
      <!--tr>
        <td><label>Academic Fees: </label><span id="academic_fees"></span></td>
        <td><label>Tution Fees: </label><span id="tution_fees"></span></td>
        <td><label>Development Fees:</label><span id="development"></span></td>
		<td><label>Caution Fees:</label><span id="caution_money"></span></td>
      </tr>
      <tr>
        <td><label>Registration Form Fees:</label><span id="admission_form"></span></td>
        <td><label>Gymkhana Fees:</label><span id="Gymkhana"></span></td>
        <td><label>Disaster Management Fees:</label><span id="disaster_management"></span></td>
		<td><label>Library Fees:</label><span id="library"></span></td>
      </tr>
      <tr>
        <td><label>Registration Fees:</label><span id="registration"></span></td>
        <td><label>Eligibility Fees:</label><span id="eligibility"></span></td>
        <td><label>Educational_industrial_visit Fees:</label><span id="educational_industrial_visit"></span></td>
		<td><label>Seminar_training Fees:</label><span id="seminar_training"></span></td>
      </tr>
	  <tr>
        <td><label>Exam_fees Fees:</label><span id="exam_fees"></span></td>
        <td><label>student_activity Fees:</label><span id="student_activity"></span></td>
        <td><label>lab Fees:</label><span id="lab"></span></td>
		<td></td>
      </tr-->
    </tbody>
  </table>
		

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div>

<script>
$(document).ready(function(){
$("#sbutton").trigger('click');
});
</script>