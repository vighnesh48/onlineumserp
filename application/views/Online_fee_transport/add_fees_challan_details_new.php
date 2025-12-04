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
			    //    $("#form").trigger("reset");

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
						$('#curr_yr').val(array.std_details.current_year);
						$('#admission_session').val(array.std_details.admission_session);
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
						$('#academic_year').val(array.std_details.academic_year);
						$('#admission_year').val(array.std_details.admission_session);
						
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
						$('#err_msg').html('This student has Account facility for the selected academic year');
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
	$('#TransactionDate').datepicker( {format: 'dd-mm-yyyy',autoclose: true});	
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

function faci_type(){
	
	var academic = $('#academic').val();
	var facility = $('#facilty').val();
	var facility_type = $("#facilty option:selected").text();
	var enroll = $('#enroll').val();
	var stud = $('#student_id').val();
	var curr_yr = $('#curr_yr').val();
	var admission_session = $('#admission_session').val();
	
	$("#form").trigger("reset");
	$('#academic').val(academic);
	$('#facilty').val(facility);
	if(academic!='' && facility!=''){
		
		if(facility=="1"){
			$('.Refresh').show();
			$("#amth").attr("readonly", "readonly");
		//$("#form").trigger("reset");
		type='POST',url='<?= base_url() ?>Hostel/get_faci_fee_details',datastring={academic:academic,facility:facility,enroll:enroll,stud:stud,curr_yr:curr_yr,admission_session:admission_session};
		html_content=ajaxcall(type,url,datastring);
		//if(html_content != "{\"fee_details\":null}")
		{
			//alert(html_content);
			var array=JSON.parse(html_content);
			$('#deposit').val(array.fee_details.deposit_fees);
			$('#gymfee').val(array.fee_details.gym_fees);
			//$('#finefee').val(array.fee_details.fine_fees);
			$('#facility').val(parseInt(array.fee_details.actual_fees)-parseInt(array.fee_details.deposit_fees));
			
			$('#fdeposit').val(array.fee_details.deposit_fees);
			$('#fgymfee').val(array.fee_details.gym_fees);
			//$('#ffinefee').val(array.fee_details.fine_fees);
			$('#ffacility').val(array.fee_details.actual_fees);
			
			
			$('#amt').val(parseInt(array.fee_details.actual_fees) + parseInt(array.fee_details.deposit_fees) + parseInt(array.fee_details.gym_fees));
			$('#famt').val(parseInt(array.fee_details.actual_fees) + parseInt(array.fee_details.deposit_fees) + parseInt(array.fee_details.gym_fees));
			$('#btns').show();
			$('#fee_details').show();
			$('#err_msg2').html('');
		}
		
		//alert(facility_type);
		//type='POST',url='<?= base_url() ?>Hostel/get_depositedto',datastring={faci_type:facility_type};
		//html_content=ajaxcall(type,url,datastring);
		//alert(html_content);
		//$('#depositto').html(html_content);
		
		
	}else{
		$('#btns').hide();
		$('#fee_details').hide();
		$("#paid_by").hide();
		$('#Exam_Related').hide();
		$('#Other_Income').hide();
	}
	}
}

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

function count_ischecked()
{
	numberOfChecked = $('input:checkbox[class=chk]:checked').length;
	if(numberOfChecked==0)
		$('#err_msg1').html('you have not selected any stream in streams list.');
	else
		$('#err_msg1').html('you have selected '+numberOfChecked+' streams.');
}
function calc_final_amount(){
			var tutf = $('#Backlog_Exam').val();
			var devf = $('#Photocopy_Fees').val();
			var cauf = $('#Revaluation_Fees').val();
			var admf =  $('#Late_Fees').val();
			
			var OtherFINE_Brekage =  $('#OtherFINE_Brekage').val();
			var Other_Registration =  $('#Other_Registration').val();
			var Other_Late =  $('#Other_Late').val();
			var Other_fees =  $('#Other_fees').val();
			
			//alert(tutf);
			var final_amount = parseInt(tutf)+parseInt(devf)+parseInt(cauf)+parseInt(admf)
			+parseInt(OtherFINE_Brekage)+parseInt(Other_Registration)+parseInt(Other_Late)+parseInt(Other_fees); 
			$('#amt').val(parseInt(final_amount));
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
                   <?php //print_r( $user_details); ?>
						<div class="col-sm-3">
		<input type="text" class="form-control" name="prn" id="prn" value="<?php echo $user_details[0]['registration_no']; ?>" placeholder="PRN No."/>
						</div>
                        <div class="col-sm-2">
						<button class="btn btn-primary form-control" id="sbutton" type="button" >Submit</button>
						</div>
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
		<input type="hidden" class="form-control numbersOnly"  value="0" readonly name="apaid" id="apaid" readonly/>
		<input type="hidden" class="form-control numbersOnly"  value="0" readonly name="apend" id="apend" readonly/>
        <input type="hidden" id="enroll" name="enroll" value="" />
		<input type="hidden" id="student_id" name="student_id" value="" />
		<input type="hidden" id="curr_yr" name="curr_yr" value="" />
        <input type="hidden" id="admission_year" name="admission_year" value="" /> 
        <input type="hidden" id="academic_year" name="academic_year" value="" />
                          
                            <div class="col-md-5" id="std_details" style="padding-right:0px;display:none;">
							
							<div class="panel">
                   
							<div class="panel-heading">
							<b>Student Details:</b>
							</div>
							
                            <div class="panel-body">
							
                              <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">ID/PRN:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									
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
                                <div class="col-md-6" style="padding-left:0px;">
                                  <select class="form-control" name="academic" id="academic" >
									   <option value="">Academic Year</option>
									    
									   <!--<option value="2019">2019-20</option> -->
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
									  <!--<option value="2" <?php if($productinfo=='Admission'){ echo "selected";} ?>>Academic Fees</option>
									  <option value="5" <?php if($productinfo=='Examination'){ echo "selected";} ?>>Examination Fees</option>
                       
                                      <option value="7">Examination Late fess</option>
                                      <option value="8" <?php if($productinfo=='Revaluation'){ echo "selected";} ?>>Revaluation</option>
                                      <option value="9" <?php if($productinfo=='Photocopy'){ echo "selected";} ?>>Photocopy</option>
                                      <option value="10" >Other Fees</option>
                                      <option value="13">Certificate Fees</option>-->
                                      <option value="1" selected="selected">Hostel Fees</option>
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
                        
                        
                        <div class="panel" id="fee_details" style="display:none;">
                   
							<div class="panel-heading">
							
							
							<b>Fee Details:</b>
							</div>
                            <div class="panel-body">
							
							
						<input type="hidden" value="" id="ffacility">
						<input type="hidden" value="" id="fdeposit">
						<input type="hidden" value="" id="fgymfee">
						<input type="hidden" value="" id="famt">
							<div class="col-md-12" >
							<div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Payment Type:<?=$astrik?></label>
                                <div class="col-md-6">
								  <select class="form-control" name="pymnt_type" id="pymnt_type" onchange="pymt_type(this.value)" required>
									  <option value="">select Payment Type</option>
											  <option value="Full" selected="selected">Full Payment</option>
											  <option value="Part">Partial Payment</option>											  
								  </select>
                                </div>
                              </div>	
							<div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Deposit Fee:</label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control numbersOnly" value="0"  name="deposit" id="deposit" onblur="calc_final_amount();" readonly/>
                                </div>
                                
                              </div>
							  
							   <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Hostel Fee:</label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control numbersOnly"  value="<?php echo $user_details[0]['actual_fees']-5000; ?>" name="facility" id="facility" onblur="calc_final_amount();" readonly />
                                </div>
                                
                              </div>
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Gym Fee:</label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control numbersOnly" value="0" name="gymfee" id="gymfee" onblur="calc_final_amount();"/>
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
                                                      <input type="hidden" class="form-control numbersOnly" id="amt" value="<?php echo $user_details[0]['actual_fees']-5000; ?>" readonly/>
											 <input type="text" class="form-control numbersOnly" name="amt"  value="<?php echo $user_details[0]['actual_fees']; ?>" readonly/>
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
									  
									  <div id="non_cash" style="display:none;">
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
								  <div class="form-group" id="btns" style="display:none;">
                               <!--<div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Deposited Bank:<?=$astrik?></label>
                                <div class="col-md-6">
								  <select class="form-control" name="depositto" id="depositto" >
									  <option value="">select Deposited Bank</option>
									   <?php 
										/*if(!empty($depositedto_details)){
											foreach($depositedto_details as $deposit){
												?>
											  <option value="<?=$deposit['bank_account_id']?>"><?=$deposit['account_name']?> - <?=$deposit['bank_name']?></option>  
											<?php 
												
											}
										}*/
								  ?>
								  </select>
                                </div>
                              </div>-->
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
                    
						<!--<div class="panel" id="Exam_Related" style="display:none;">
                        <div class="panel-heading">
							
							
							<b>Fee Details:</b>
							</div>
                        <div class="panel-body">
						<div class="col-md-12" >
                        
                        <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Exam Session</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" >
        
        <select class="form-control" name="exam_monthyear" id="exam_monthyear" required>
		<option value="">select Exam session</option>
		<?php 
		if(!empty($examsession)){
		foreach($examsession as $list){
			$exsession= $list['exam_name'].':'.$list['exam_id'];
			if($productinfo=='Revaluation' || $productinfo=='Photocopy'){
				$exam_ses='DEC-2019:13';
			}else{
				$exam_ses='MAR-2020:14';
			}
			if($exsession ==$exam_ses){
				$sel="selected";
			}else{
				$sel="";
			}
			?>
		<option value="<?php echo $exsession;?>" <?=$sel?>><?php echo $list['exam_name'];?></option>  
		<?php }} ?>
								  </select></div>
             <div class="col-md-1">
									   </div>
								  </div>
                        
                        
                        
                        <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Backlog Exam Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Backlog_Exam" id="Backlog_Exam" value="<?php if($productinfo=='Examination'){echo $user_details[0]['amount'];}else{ echo "0";}?>" onblur="calc_final_amount();" /></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Photocopy Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Photocopy_Fees" id="Photocopy_Fees" value="<?php if($productinfo=='Photocopy'){echo $user_details[0]['amount'];}else{ echo "0";}?>" onblur="calc_final_amount();" /></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Revaluation Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Revaluation_Fees" id="Revaluation_Fees" value="<?php if($productinfo=='Revaluation'){echo $user_details[0]['amount'];}else{ echo "0";}?>"  onblur="calc_final_amount();"/></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Late Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Late_Fees" id="Late_Fees" value="0" onblur="calc_final_amount();" /></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  
                                  
                          </div>
                          </div>                       
                           </div>-->
                           	
                            <!--<div class="panel" id="Other_Income" style="display:none;">
                            <div class="panel-heading">
							
							
							<b>Fee Details:</b>
							</div>
                         <div class="panel-body">
                         <div class="col-md-12" >
                        <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">FINE/Brekage</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="OtherFINE_Brekage" id="OtherFINE_Brekage" value="0"  onblur="calc_final_amount();"/></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Registration Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Other_Registration" id="Other_Registration" value="0"  onblur="calc_final_amount();"/></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Late Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Other_Late" id="Other_Late" value="0"  onblur="calc_final_amount();"/></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Other Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Other_fees" id="Other_fees" value="0"  onblur="calc_final_amount();"/></div>
             <div class="col-md-1">
									   </div>
								  </div>
                        </div>
                        </div>
                        </div>-->
                            
                            <div class="panel" id="Exam_Related" style="display:none;">
                        <div class="panel-heading">
							
							
							<b>Fee Details:</b>
							</div>
                        <div class="panel-body">
						<div class="col-md-12" >
                        
                        <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Exam Session</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" >
        
        <select class="form-control" name="exam_monthyear" id="exam_monthyear" required>
		<option value="">Exam session</option>
		<?php  $sell="";
		if(!empty($examsession)){
		foreach($examsession as $list){
			if($list['exam_id']==$user_details[0]['examsession']){$sell="selected='selected'";}else{$sell="";}
			?>
		<option value="<?php echo $list['exam_name'];?>:<?php echo $list['exam_id'];?>" <?php echo $sell;?>><?php echo $list['exam_name'];?></option>  
		<?php }} ?>
								  </select></div>
             <div class="col-md-1">
									   </div>
								  </div>
                        
                        
                        
                        <div class="form-group Backlog_Exam" style="display:none">
		<label class="col-md-4" style="padding-left:0px;">Backlog Exam Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Backlog_Exam" id="Backlog_Exam" value="<?php echo $user_details[0]['amount'];?>" onblur="calc_final_amount();" /></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  <div class="form-group Photocopy_Fees" style="display:none">
		<label class="col-md-4" style="padding-left:0px;">Photocopy Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Photocopy_Fees" id="Photocopy_Fees" value="0" onblur="calc_final_amount();" /></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  <div class="form-group Revaluation_Fees" style="display:none">
		<label class="col-md-4" style="padding-left:0px;">Revaluation Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Revaluation_Fees" id="Revaluation_Fees" value="0"  onblur="calc_final_amount();"/></div>
             <div class="col-md-1">
									   </div>
								  </div>
                              <div class="form-group Late_Fees" style="display:none">
		<label class="col-md-4" style="padding-left:0px;">Late Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		  <div class="col-md-5"><input type="text" class="form-control numbersOnly" name="Late_Fees" id="Late_Fees" value="0" onblur="calc_final_amount();" /></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  
                                  
                          </div>
                          </div>                       
                           </div>
                           
                           
                           <div class="panel" id="Other_Income" style="display:none;">
                            <div class="panel-heading">
							
							
							<b>Fee Details:</b>
							</div>
                         <div class="panel-body">
                         <div class="col-md-12" >
                        <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">FINE/Brekage</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="OtherFINE_Brekage" id="OtherFINE_Brekage" value="0"  onblur="calc_final_amount();"/></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Registration Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Other_Registration" id="Other_Registration" value="0"  onblur="calc_final_amount();"/></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Late Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Other_Late" id="Other_Late" value="0"  onblur="calc_final_amount();"/></div>
             <div class="col-md-1">
									   </div>
								  </div>
                                  <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Other Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Other_fees" id="Other_fees" value="0"  onblur="calc_final_amount();"/></div>
             <div class="col-md-1">
									   </div>
								  </div>
                        </div>
                        </div>
                        </div>
                           
                           
                           
                                  
                                  <div class="panel" id="paid_by" style="display:none;">
                        <div class="panel-body">
						<div class="col-md-12" >
                        <div class="form-group">
								   <label class="col-md-4" style="padding-left:0px;"> Excess Fees:</label>
                                   
													 <div class="col-md-6" >
											
                                   <input type="text" class="form-control numbersOnly" name="amth" id="amth" value="" readonly="readonly"/>
                                   <input type="hidden" class="form-control" name="amth_status" id="amth_status" value="N"/>
									   </div> <div class="col-md-1"></div>
								  </div>
                        
                        
                        
                                  <div class="form-group">
										<label class="col-md-4" style="padding-left:0px;"> Amount:<?=$astrik?></label>
													 <div class="col-md-6" >
	<input type="text" class="form-control numbersOnly" name="amt" id="amt" value="<?php echo $user_details[0]['amount'];?>"/>
                               
									   </div>
                                         <div class="col-md-1"> <a href="javascript:void(0);" id="" class='Refresh'>Refresh</a></div>
								  </div>
									<div class="form-group">
										<label class="col-md-4" style="padding-left:0px;">Paid By:<?=$astrik?></label>
										<div class="col-md-6" >
											<select name="epayment_type" id="epayment_type" onchange="display_noncash()" class="form-control" >
											<option value="">Select Paid By</option>
											<option value="CHQ" >Cheque</option>
											<option value="DD" >DD</option>
											<option value="POS">POS</option>
											<option value="CASH">Challan</option>
                                            <option value="OL" >ONLINE</option>
                                             <option value="GATEWAY-ONLINE" selected="selected">GATEWAY-ONLINE</option>
											</select>	
										   </div>
										<div class="col-md-1"></div>
									  </div>  
									  
									  
										
									   <div id="Online_pay" style="display:none;">
									   <div class="form-group">
										
										<label class="col-md-4" style="padding-left:0px;" id="">Transaction No:<?=$astrik?> </label>
											<div class="col-md-6" >
				<input type="text" class="form-control"  name="TransactionNo" id="TransactionNo" value="<?php echo $user_details[0]['bank_ref_num']; ?>" />
										</div><div class="col-md-1"></div>
										</div>
										 <div class="form-group">
										
										<label class="col-md-4" style="padding-left:0px;" id="">Transaction Date:<?=$astrik?> </label>
											<div class="col-md-6" >
							<input type="text" class="form-control"  name="TransactionDate" id="TransactionDate" />
										</div><div class="col-md-1"></div>
										</div>
										
									   </div>
									  <div id="non_cash" style="display:none;">
										<div class="form-group">
										
										<label class="col-md-4" style="padding-left:0px;" id="receipt"></label>
											<div class="col-md-6" >
<input type="text" class="form-control numbersOnly"  name="receipt_number" id="receipt_number" value="<?php echo $user_details[0]['bank_ref_num']; ?>" />
										</div><a href="javascript:void(0);" id="Check_recepit" class="Check_recepit btn btn-primary">Check</a>

										
										
									<div class="form-group" style="display: flex; justify-content: center; align-items: center; margin-bottom: 15px;">
										<div class="col-md-4" style="flex: 0 0 33%;"></div>
										<div class="col-md-6" style="flex: 0 0 50%; text-align: center;">
											<div class="error_msg" style="color: Black; font-weight: bold;"></div>
										</div>
										<div class="col-md-1" style="flex: 0 0 17%;"></div>
									</div>
										</div>
										<div class="form-group">
									    <div class="col-md-4"></div>
										<div class="col-md-6"><div class="error_msg"></div></div>
                                        <div class="col-md-1"></div>
										</div>
										
								  <div class="form-group">
										<label class="col-md-4" style="padding-left:0px;" id="paiddate"></label>
													 <div class="col-md-6" >
					<input type="text" id="fees_date" name="fees_date" class="form-control" value="<?php echo $user_details[0]['payment_date'];?>"   readonly="true" />
											 
									   </div><div class="col-md-1"></div>
								  </div>
								  <div class="form-group">
										<label class="col-md-4" style="padding-left:0px;">Bank Name:<?=$astrik?></label>
								<div class="col-md-6" >
									<!--<select class="form-control" name="bank" id="bank" >
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
								  </select>-->
									   </div><div class="col-md-1"></div>
								  </div>
								  
								  <div class="form-group">
									<label class="col-md-4" style="padding-left:0px;">Bank Branch:</label>
											 <div class="col-md-6" >
											 <input type="text" class="form-control alphaOnly" onchange="total_fees()" name="branch" id="branch" />
                                       </div><div class="col-md-1"></div>
                                  </div>  
								 </div>
                                 <div class="form-group">
										
										<label class="col-md-4" style="padding-left:0px;" id="">Remark:</label>
											<div class="col-md-6" >
											<input type="text" name="Remark" id="Remark" class="form-control" />
										</div><div class="col-md-1"></div>
										</div>
                                 </div>
                                 </div>
                                 </div>
                                  
                                  
								  <div class="form-group" id="btns" style="display:none;">
                                  
                               <input type="hidden" name="balanace_org" id="balanace_org" value="" />
                               <input type="hidden" name="Tuition_org" id="Tuition_org" value="" />
                               <input type="hidden" name="development_org" id="development_org" value="" />
                               <input type="hidden" name="caution_org" id="caution_org" value="" />
                               <input type="hidden" name="admission_org" id="admission_org" value="" />
                               <input type="hidden" name="exam_org" id="exam_org" value="" />
                               <input type="hidden" name="University_org" id="University_org" value="" />
                               
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
<div class="modal fade" id="myModal_add">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" >
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tuition Fees Add</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<table class="table table-bordered">
		<thead>

    <tbody>
		<tr>
        <th width="5%">Tuition Fees</th><td><input type="text" id="add_fee" name="add_fee" value="" /></td>
       
		
		</tr>
        <tr>
        </tr>
        <tr><td><button name="" id="add_Tuition" >SAVE</button></td></tr>
		
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
<script>
$(document).ready(function(e) {
	
	
	$('.Check_recepit').on('click',function(){
		
		var receipt_number=$("#receipt_number").val();
		var epayment_type=$("#epayment_type").val();
		//alert(receipt_number);
		var formData = {receipt_number:receipt_number,epayment_type:epayment_type};
		if(receipt_number!=''){
		
	    $.ajax({
		type:"POST",
		url:'<?php echo base_url();?>Challan/check_recepit',
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
	
	$('#add_Tuition').on('click',function(){
		
		var add_fee=$("#add_fee").val();
		var enroll=$("#enroll").val();
		var student_id=$("#student_id").val();
		var academic=$("#academic").val();
		//alert(receipt_number);
		var formData = {add_fee:add_fee,enroll:enroll,student_id:student_id,academic:academic};
		if(student_id!=''){
		
	    $.ajax({
		type:"POST",
		url:'<?php echo base_url();?>Challan/add_Tuition',
		data:formData,
		
		success: function(result){
			if(result!=0){
				faci_type();
			///	$("#myModal_add").hide();
			$("#add_fee").val('');
				$('#myModal_add').modal('hide');
			//	$('.error_msg').html('not Added Number');
				//$('.Generate').prop('disabled', true);
			}else{
				faci_type();
				$("#add_fee").val('');
				$('#myModal_add').modal('hide');
				//$('.error_msg').html('PASS');
				//$('.Generate').prop('disabled', false);
			}
			}
		 });
		}
		
		
		});
	
	$('.Refresh').on('click',function(){
		$("#tutf").val(0);
		$("#devf").val(0);
		$("#cauf").val(0);
		$("#admf").val(0);
		$("#exmf").val(0);
		$("#unirf").val(0);
		$("#amth").val(0);
		$("#amt").val(0);
		$("#amth_status").val('N');
		
		
		})
	
    $('.cal_math').on('click',function(){
		
		var value=$(this).val();
		var id=$(this).attr('id');
		var amount =$('#amt').val();
		
		if(amount==0){
		alert('Please Enter Amount');
		$(this).prop('checked',false);
		}else{
		var amth_status =$('#amth_status').val();
		
		if(amth_status=="N"){
		$('#amth_status').val('Y');
		$('#amth').val(amount);
		//$("#Excess").val(amount);
		}
		
		
		
		
		
			
			var amth_status=$('#amth_status').val();
			if(amth_status=="Y"){
	    	
			
			if(id=="Tuition_Fees_check"){
		
			var amth=$('#amth').val();
			
			if(Number(amth)>=Number(value))
			{
			//	alert('1');
			if($(this).is(":checked")) {
			$("#tutf").val(value);
			//var amth=$('#amth').val();
			var total=Number(amth)-Number(value);
			$('#amth').val(total);
			//$("#Excess").val(total);
			}else{
				//alert('2');
			var amth=$('#amth').val();
			var tutf=$('#tutf').val();
			var current=Number(amth) + Number(tutf);
			$('#amth').val(current);
			//$("#Excess").val(current);
			$("#tutf").val(0);
			}
			
			}else{
				//alert('3');
			//alert('Amount Balance is less Than Current Amount');
			//$('#Tuition_Fees_check').prop('checked',false);
			if(Number(amth)!=0){
			//	alert('4');
			//	alert('2');
			//	$('#Tuition_Fees_check').prop('checked',false);
			/*var total=value - amth;
			$('#amth').val(amth);
			var namth=$('#amth').val();
			$("#tutf").val(0);*/
			
			if($(this).is(":checked")) {
			  var total=Number(value)-Number(amth);
				//var amtn=
				
				var namth=$('#amth').val();
				var n=Number(namth) - Number(amth);
				$("#tutf").val(amth);
				$('#amth').val(n);	
				//$("#Excess").val(n);	
			}else{
			var amount=$("#tutf").val();
			var Excess=$("#amth").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			//$("#Excess").val(ng);
			$("#tutf").val(0);
			}
			
		     }else{
				// alert('5');
			if($(this).is(":checked")) {
			alert('Balance Amount is less Than Current Amount');
			$('#Tuition_Fees_check').prop('checked',false);
			}else{
			//	alert('6');
			var amth=$('#amth').val();
			var tutf=$('#tutf').val();
			var current=Number(amth) + Number(tutf);
			$('#amth').val(current);
		//	$("#Excess").val(current);
			$("#tutf").val(0);
				 }
				}
			}
		}
		////////////////////////////////////////////////////
		
		if(id=="Development_Fees_check"){
			var amth=$('#amth').val();
			if(Number(amth)>=Number(value)){
			if($(this).is(":checked")) {
			$("#devf").val(value);
			//var amth=$('#amth').val();
			var total=amth-value;
			$('#amth').val(total);
			//$("#Excess").val(total);
			}else{
			var amth=$('#amth').val();
			var devf=$('#devf').val();
			var current=Number(amth) + Number(devf);
			$('#amth').val(current);
			//$("#Excess").val(current);
			$("#devf").val(0);
			}
			}else{
				
			//alert('Amount Balance is less Than Current Amount');
			//$('#Development_Fees_check').prop('checked',false);
			//alert();
			//$('#Development_Fees_check').prop('checked',false);
			    if(Number(amth)!=0){
				if($(this).is(":checked")) {	
				var total=Number(value)-Number(amth);
				//var amtn=
				
				var namth=$('#amth').val();
				var n=Number(namth) -Number(amth);
				$("#devf").val(amth);
				$('#amth').val(n);
				//$("#Excess").val(n);
				}else{
			var amount=$("#devf").val();
			var Excess=$("#amth").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			//$("#Excess").val(ng);
			//$("#Excess").val(0);
			}	
				
				
				
				//$('#Development_Fees_check').prop('checked',true);
					}else{
			if($(this).is(":checked")) {	
			alert('Balance Amount is less Than Current Amount');
			$('#Development_Fees_check').prop('checked',false);
						}else{
				
			    var amth=$('#amth').val();
				var devf=$('#devf').val();
				var current=Number(amth) + Number(devf);
				$('#amth').val(current);
				//$("#Excess").val(current);
				$("#devf").val(0);
						}
				}
			}
		}
		////////////////////////////////////////////////
		
		if(id=="Caution_Form_check"){
			var amth=$('#amth').val();
			//alert(amth+'--'+value);
			if(Number(amth)>=Number(value)){
			if($(this).is(":checked")) {
			$("#cauf").val(value);
			//var amth=$('#amth').val();
			var total=amth-value;
			$('#amth').val(total);
			//$("#Excess").val(total);
			}else{
			var cauf= $("#cauf").val();		
			var amth=$('#amth').val();
			var current=Number(amth) + Number(cauf);
			$('#amth').val(current);
			//$("#Excess").val(current);
			$("#cauf").val(0);	
			}
			}else{
			//alert('Amount Balance is less Than Current Amount');
			//$('#Caution_Form_check').prop('checked',false);
		//	$('#Caution_Form_check').prop('checked',false);
			if(Number(amth)!=0){
				
				/*var total=value-amth;
				$('#amth').val(amth);
				var namth=$('#amth').val();
				$("#cauf").val(0);*/
				if($(this).is(":checked")) {
				var total=Number(value)-Number(amth);
				//var amtn=
				
				var namth=$('#amth').val();
				var n=Number(namth) -Number(amth);
				$("#cauf").val(amth);
				$('#amth').val(n);		
				//$("#Excess").val(n);
				
				}else{
			var amount=$("#tutf").val();
			var Excess=$("#amth").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			//$("#Excess").val(ng);
			$("#cauf").val(0);
			}	
				
					//$('#Caution_Form_check').prop('checked',true);
					}else{
					if($(this).is(":checked")) {	
			alert('Balance Amount is less Than Current Amount');
			$('#Caution_Form_check').prop('checked',false);
					}else{
			var cauf= $("#cauf").val();		
			var amth=$('#amth').val();
			var current=Number(amth) + Number(cauf);
			$('#amth').val(current);
			//$("#Excess").val(current);
			$("#cauf").val(0);	
					}
				}
			
			}
		}
		/////////////////////////////////////////////////
		if(id=="Admission_Form_check"){
			var amth=$('#amth').val();
			if(Number(amth)>=Number(value)){
			if($(this).is(":checked")) {
			$("#admf").val(value);
			//var amth=$('#amth').val();
			var total=amth-value;
			$('#amth').val(total);
			//$("#Excess").val(total);
			}else{
			var admf=$('#admf').val();
			var amth=$('#amth').val();
			var current=Number(amth) + Number(admf);
			$('#amth').val(current);
			//$("#Excess").val(current);
			$("#admf").val(0);	
			}
			}else{
			//alert('Amount Balance is less Than Current Amount');
			//$('#Admission_Form_check').prop('checked',false);
			//$('#Admission_Form_check').prop('checked',false);
			if(Number(amth)!=0){
				
			/*var total=value-amth;
			$('#amth').val(amth);
			var namth=$('#amth').val();
			$("#admf").val(0);*/
			if($(this).is(":checked")) {
			var total=Number(value)-Number(amth);
				//var amtn=
				
				var namth=$('#amth').val();
				var n=Number(namth) -Number(amth);
				$("#admf").val(amth);
				$('#amth').val(n);
			//	$("#Excess").val(n);		
			//$('#Admission_Form_check').prop('checked',true);
					}else{
			var amount=$("#tutf").val();
			var Excess=$("#amth").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			//$("#Excess").val(ng);
			$("#admf").val(0);
			}	
			}else{
				if($(this).is(":checked")) {		
			alert('Balance Amount is less Than Current Amount');
			$('#Admission_Form_check').prop('checked',false);
				}else{
			var admf=$('#admf').val();
			var amth=$('#amth').val();
			var current=Number(amth) + Number(admf);
			$('#amth').val(current);
			//$("#Excess").val(current);	
			$("#admf").val(0);	
				}
				}
			}
		}
		
		////////////////////////////////////////////////
		if(id=="Exam_fees_check"){
			 var amth=$('#amth').val();
			 
		if(Number(amth)>=Number(value)){
		if($(this).is(":checked")) {
				
			$("#exmf").val(value);
			
			var total=Number(amth) - Number(value);
			$('#amth').val(total);
			//$("#Excess").val(total);
			}else{
			var exmf=$('#exmf').val();
			var amth=$('#amth').val();
			var current=Number(amth) + Number(exmf);
			$('#amth').val(current);
			//$("#Excess").val(current);
			$("#exmf").val(0);
			}
	  }else{
			//alert('Amount Balance is less Than Current Amount');
			//$('#Exam_fees_check').prop('checked',false);
			//$('#Exam_fees_check').prop('checked',false);
		if(Number(amth)!=0){
			
	/*	var total=value-amth;
		$('#amth').val(amth);
		var namth=$('#amth').val();
		$("#exmf").val(0);*/
		if($(this).is(":checked")) {
		var total=Number(value)-Number(amth);
				//var amtn=
				
				var namth=$('#amth').val();
				var n=Number(namth) -Number(amth);
				$("#exmf").val(amth);
				$('#amth').val(n);
				//$("#Excess").val(n);	
				
			}else{
			var amount=$("#tutf").val();
			var Excess=$("#amth").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			//$("#Excess").val(ng);
			$("#exmf").val(0);
			}	
				
				
		//$('#Exam_fees_check').prop('checked',true);		
		}else{
			
			if($(this).is(":checked")) {
			alert('Balance Amount is less Than Current Amount');
			$('#Exam_fees_check').prop('checked',false);
			}else{
			var exmf=$('#exmf').val();
			var amth=$('#amth').val();
			var current=Number(amth) + Number(exmf);
			$('#amth').val(current);
			//$("#Excess").val(current);	
			$("#exmf").val(0);
			}
		 }
			
	   }
		
		}
	 ///////////////////////////////////////////
		
		if(id=="University_fees_check"){
		var amth=$('#amth').val();
			 
		if(Number(amth)>=Number(value)){
		
		    if($(this).is(":checked")) {
				
			$("#unirf").val(value);
			
			var total=amth-value;
			$('#amth').val(total);
			//$("#Excess").val(total);	
			}else{
			var unirf=$('#unirf').val();
			var amth=$('#amth').val();
			var current=Number(amth) + Number(unirf);
			$('#amth').val(current);
			//$("#Excess").val(current);
			$("#unirf").val(0);
			}
	  }else{
			//alert('Amount Balance is less Than Current Amount');
			//$('#Exam_fees_check').prop('checked',false);
			//$('#University_fees_check').prop('checked',false);
		if(Number(amth)!=0){
			
		/*var total=value-amth;
		$('#amth').val(amth);
		var namth=$('#amth').val();
		$("#unirf").val(0);*/	
		if($(this).is(":checked")) {
		var total=Number(value)-Number(amth);
				//var amtn=
				
				var namth=$('#amth').val();
				var n=Number(namth) -Number(amth);
				$("#unirf").val(amth);
				$('#amth').val(n);	
				//$("#Excess").val(n);
		
		}else{
			var amount=$("#Balance_Amount").val();
			var Excess=$("#amth").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			//$("#Excess").val(ng);
			$("#unirf").val(0);
			}
		
		
		
		//$('#University_fees_check').prop('checked',true);	
		}else{
			//alert('2');
		if($(this).is(":checked")) {
		alert('Balance Amount is less Than Current Amount');
		$('#University_fees_check').prop('checked',false);
		}else{
			//alert('3');
		var unirf=$('#unirf').val();
		var amth=$('#amth').val();
		var current=Number(amth) + Number(unirf);
		$('#amth').val(current);
		//$("#Excess").val(current);
		$("#unirf").val(0);
		 }//if($(this).is(":checked")) 
		 }//if(Number(amth)!=0)
			
	   } //if(Number(amth)>=Number(value))
		
		} //if(id=="University_fees_check")
	  
  
  /////////////////////////////////////////////////////
  if(id=="Balance_Amount_check"){
		var amth=$('#amth').val();
			 
		if(Number(amth)>=Number(value)){
		
		    if($(this).is(":checked")) {
				
			$("#Balance_Amount").val(value);
			
			var total=amth-value;
			$('#amth').val(total);
			//$("#Excess").val(total);	
			}else{
			var unirf=$('#Balance_Amount').val();
			var amth=$('#amth').val();
			var current=Number(amth) + Number(unirf);
			$('#amth').val(current);
			//$("#Excess").val(current);
			$("#Balance_Amount").val(0);
			}
	  }else{
			//alert('Amount Balance is less Than Current Amount');
			//$('#Exam_fees_check').prop('checked',false);
			//$('#University_fees_check').prop('checked',false);
		if(Number(amth)!=0){
			
		/*var total=value-amth;
		$('#amth').val(amth);
		var namth=$('#amth').val();
		$("#unirf").val(0);*/	
		if($(this).is(":checked")) {
		var total=Number(value)-Number(amth);
				//var amtn=
				
				var namth=$('#amth').val();
				var n=Number(namth) -Number(amth);
				$("#Balance_Amount").val(amth);
				$('#amth').val(n);	
				//$("#Excess").val(n);
		
		}else{
			var amount=$("#Balance_Amount").val();
			var Excess=$("#amth").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			//$("#Excess").val(ng);
			$("#Balance_Amount").val(0);
			}
		
		
		
		//$('#University_fees_check').prop('checked',true);	
		}else{
			//alert('2');
		if($(this).is(":checked")) {
		alert('Balance Amount is less Than Current Amount');
		$('#University_fees_check').prop('checked',false);
		}else{
			//alert('3');
		var unirf=$('#Balance_Amount').val();
		var amth=$('#amth').val();
		var current=Number(amth) + Number(unirf);
		$('#amth').val(current);
		//$("#Excess").val(current);
		$("#Balance_Amount").val(0);
		 }//if($(this).is(":checked")) 
		 }//if(Number(amth)!=0)
			
	   } //if(Number(amth)>=Number(value))
		
		} //if(id=="University_fees_check")
	  
  /*if(id=="Balance_Amount_check"){
	  if($(this).is(":checked")) {
	 var Balance_Amount=$('#Balance_Amount').val();
	 var amth= $('#amth').val();
	 var amt=$("#amt").val();
	 
	 var newbalnce=(Number(amt) - Number(Balance_Amount ));
	// $("#amt").val(newbalnce);
	 $('#amth').val(newbalnce);
	  }else{
	 var Balance_Amount=$('#Balance_Amount').val();
	 var amth= $('#amth').val();
	 var amt=$("#amt").val();
	 
	var Balance_Amount=$('#Balance_Amount').val();//Math.abs($('#Balance_Amount').val());
	if (Math.sign(Balance_Amount) === 1) {

	  var newbalnce=(Number(amt) - Number(Balance_Amount));
	}else{
		var newbalnce=(Number(amt) + Number(Balance_Amount));
	}
	// $("#amt").val(newbalnce);
	 $('#amth').val(newbalnce);  
	  }
	 
  }*/
  
  
		
			}//Status
		} //if(amount==0){
	})
});
</script><script>
$(document).ready(function(){
$("#sbutton").trigger('click');
setTimeout(() => { faci_type(); }, 3000);
setTimeout(() => { display_noncash(); }, 1000);
//faci_type();
});
</script>