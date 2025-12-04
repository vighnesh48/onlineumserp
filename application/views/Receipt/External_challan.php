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
			    //    $("#form").trigger("reset");

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

function faci_type(){
	
	var academic = $('#academic').val();
	var facility = $('#facilty').val();
	var facility_type = $("#facilty option:selected").text();
	var enroll = $('#enroll').val();
	var stud = $('#student_id').val();
	var curr_yr = $('#curr_yr').val();
	
	$("#form").trigger("reset");
	$('#academic').val(academic);
	$('#facilty').val(facility);
	if(academic!='' && facility!=''){
		
		if(facility=="2"){
		//$("#form").trigger("reset");
		type='POST',url='<?= base_url() ?>Challan/get_fee_details_new',datastring={academic:academic,facility:facility,enroll:enroll,stud:stud,curr_yr:curr_yr};
		html_content=ajaxcall(type,url,datastring);
	//	alert(html_content);
			var array=JSON.parse(html_content);
			//alert(array[0].actual_fee);
		//	$('#deposit').val(array.actual_fee);
		
		    var apend = array[0].applicable_fee - array[0].amount_paid;
			$('#apend').val(apend);
			$('#apaid').val(array[0].amount_paid);
			$('#facility').val(array[0].applicable_fee);
			
			$('#amtpand').html(apend);
			$('#amtpaid').html(array[0].amount_paid);
			$('#totf').html(array[0].applicable_fee);
			
						$('#academic_fees').html(array[0].academic_fees);
						
						$('#tution_fees').html(array[0].tution_fees);
                        $('#Tuition_org').val(array[0].tution_fees);
						
						//if (typeof array[1] !== 'undefined' && array[1].length > 0)
						 {
						if((array[1].fees_id)!=0){
						$('.Tuition_Fees_read').html(array[1].tution_pending);
						$('#Tuition_Fees_check').val(array[1].tution_pending);
						if((array[1].tution_status)=="Y"){
						$("#Tuition_Fees_check").attr("disabled", true);
						$("#tutf").attr('readonly', true);
						}
						}else{
						$('.Tuition_Fees_read').html(array[0].tution_fees);
						$('#Tuition_Fees_check').val(array[0].tution_fees);
						}
						}
						
						//$('.Tuition_Fees_read').html(array[0].tution_fees);
						//$('#Tuition_Fees_check').val(array[0].tution_fees);
						
						$('#development').html(array[0].development);
						$('#development_org').val(array[0].development);
						
						//if (typeof array[1] !== 'undefined' && array[1].length > 0)
						 {
						if((array[1].fees_id)!=0){
						$('.Development_Fees_read').html(array[1].development_pending);
						$('#Development_Fees_check').val(array[1].development_pending);
						
						if((array[1].development_status)=="Y"){
							$("#Development_Fees_check").attr("disabled", true);
							$("#devf").attr('readonly', true);
						}
						}else{
						$('.Development_Fees_read').html(array[0].development);
						$('#Development_Fees_check').val(array[0].development);	
						}
						}
						
						$('#caution_money').html(array[0].caution_money);
						$('#caution_org').val(array[0].caution_money);
						
						//if (typeof array[1] !== 'undefined' && array[1].length > 0) 
						{
						if((array[1].fees_id)!=0){
						$('.Caution_read').html(array[1].caution_pending);
						$('#Caution_Form_check').val(array[1].caution_pending);
						if((array[1].caution_status)=="Y"){
							$("#Caution_Form_check").attr("disabled", true);
							$("#cauf").attr('readonly', true);
						}
						}else{
						$('.Caution_read').html(array[0].caution_money);
						$('#Caution_Form_check').val(array[0].caution_money);	
						}
						}
						

						$('#admission_form').html(array[0].admission_form);
						$('#admission_org').val(array[0].admission_form);
						
						//if (typeof array[1] !== 'undefined' && array[1].length > 0) 
						{
						if((array[1].fees_id)!=0){
						$('.Admission_Form_read').html(array[1].admission_pending);
						$('#Admission_Form_check').val(array[1].admission_pending);
						if((array[1].admission_status)=="Y"){
							$("#Admission_Form_check").attr("disabled", true);
							$("#admf").attr('readonly', true);
						}
						}else{
						$('.Admission_Form_read').html(array[0].admission_form);
						$('#Admission_Form_check').val(array[0].admission_form);	
						}
						}
						
						$('#exam_fees').html(array[0].exam_fees);
						$('#exam_org').val(array[0].exam_fees);
						
						//if (typeof array[1] !== 'undefined' && array[1].length > 0)
						 {
						if((array[1].fees_id)!=0){
						$('.Exam_fees_read').html(array[1].exam_pending);
						$('#Exam_fees_check').val(array[1].exam_pending);
						if((array[1].exam_status)=="Y"){
						$("#Exam_fees_check").attr("disabled", true);
						$("#exmf").attr('readonly', true);
						}
						}else{
						$('.Exam_fees_read').html(array[0].exam_fees);
						$('#Exam_fees_check').val(array[0].exam_fees);	
						}
						}
						
						$('#Gymkhana').html(array[0].Gymkhana);
						$('#disaster_management').html(array[0].disaster_management);
						$('#student_safety_insurance').html(array[0].student_safety_insurance);
						$('#library').html(array[0].library);
						$('#registration').html(array[0].registration);
						$('#eligibility').html(array[0].eligibility);
						$('#educational_industrial_visit').html(array[0].educational_industrial_visit);
						$('#seminar_training').html(array[0].seminar_training);
						
						
						
						$('#student_activity').html(array[0].student_activity);
						$('#lab').html(array.lab);
						//Number(array.academic_fees) +
						var University_Fees= Number(array[0].Gymkhana) + Number(array[0].disaster_management) + Number(array[0].student_safety_insurance) +
						Number(array[0].library) + Number(array[0].registration)+Number(array[0].eligibility) + Number(array[0].educational_industrial_visit) + 
						Number(array[0].seminar_training) + Number(array[0].student_activity) + Number(array[0].lab) +Number(array[0].internet);
						
						$('#University_org').val(University_Fees);
						//if (typeof array[1] !== 'undefined' && array[1].length > 0) 
						{
						if((array[1].fees_id)!=0){
						$('.University_fees_read').html(array[1].university_pending);
						$("#University_fees_check").val(array[1].university_pending);
						if((array[1].university_status)=="Y"){
						$("#University_fees_check").attr("disabled", true);
						$("#unirf").attr('readonly', true);
						}
						}else{
						$('.University_fees_read').html(University_Fees);
						$("#University_fees_check").val(University_Fees);	
						}
						}
			$('#Exam_Related').hide();
			$('#Other_Income').hide();		
			$('#btns').show();
			$('#fee_details').show();
			$('#err_msg2').html('');
			$("#paid_by").show();
           
		//alert(facility_type);
	//	type='POST',url='<?= base_url() ?>Challan/get_depositedto',datastring={faci_type:facility_type};
	//	html_content=ajaxcall(type,url,datastring);
		//alert(html_content);
	//	$('#depositto').html(html_content);
		}else if(facility=="5"){
			$('#btns').show();
			$('#fee_details').hide();
			$('#err_msg2').html('');
			$('#Other_Income').hide();
            $('#Exam_Related').show();
			$("#paid_by").show();
		}
		else if(facility=="10"){
			$('#btns').show();
			$('#fee_details').hide();
			$('#err_msg2').html('');
            $('#Exam_Related').hide();
			$('#Other_Income').show();
			$("#paid_by").show();
		}
		
		
	}else{
		$('#btns').hide();
		$('#fee_details').hide();
		$("#paid_by").hide();
		$('#Exam_Related').hide();
		$('#Other_Income').hide();
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
			var tutf = $('#RegistrationFees').val();
			var devf = $('#OtherFees').val();
			
			
			//alert(tutf);
			var final_amount = parseInt(tutf)+parseInt(devf); 
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
                   
				    
                    <div class="panel-body">
					<form id="form" name="form" action="<?=base_url($currentModule.'/External_submit')?>" method="POST" >
						
                          
                             
                            <div class="col-md-5" id="std_details" style="padding-right:0px;display:block;">
							
							<div class="panel">
                   
							<div class="panel-heading">
							<b> Details:</b>
							</div>
							
                            <div class="panel-body">
							
                              
								<div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Name:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 <input type="text" class="form-control" id="guest_name" name="guest_name" />								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Mobile:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									  <input type="text" class="form-control" id="guest_mobile" name="guest_mobile" maxlength="10"/>							   
								   </div>			 
							  </div>
							 
							  <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Institute:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 <input type="text" class="form-control" id="guest_organisation" name="guest_organisation" />
									 							   
								   </div>			 
							  </div>
							   <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Address:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 <textarea class="form-control" id="guest_address" name="guest_address" /></textarea>								   
								   </div>			 
							  </div>
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Academic Year:<?=$astrik?></label>
                                <div class="col-md-7" style="padding-left:0px;">
                                  <select class="form-control" name="academic" id="academic" >
									   <option value="">Academic Year</option>
											<option value="2019" selected>2019</option> 
                                            <option value="2020" >2020</option>
                                            <option value="2021" >2021</option>
                                            <option value="2022">2022</option>
									  </select>
                                </div>
                                
                              </div>
							  
							
							  
							  
							  
							  
							  
							  
							  							  
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Deposited Bank:<?=$astrik?></label>
                                <div class="col-md-7" style="padding-left:0px;">
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
                          
                        
                        <div class="col-md-7" id="emptab"> 
						
                        <!--<div class="panel">
                         <div class="panel-body"><div class="col-md-12" >
                        
                        </div></div></div>-->
                        
                        
                        <div class="panel" id="fee_details" style="display:block;">
                   
							<div class="panel-heading">
							
							
							<b>Fee Details:</b>
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
					<label class="col-md-4" style="padding-left:0px;"> </label> 
                    <label class="col-md-1"></label>
                    <label class="col-md-1"></label>
					<div class="col-md-5" ></div>
                    <div class="col-md-1" ></div>
					</div>
                                
                                
                                  
								<div class="form-group">
					<label class="col-md-4" style="padding-left:0px;">Registration Fees</label> 
                    <label class="col-md-2"></label>
                    
					<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="guest_RegistrationFees" id="RegistrationFees" value="0"  onblur="calc_final_amount();" /></div>
                    <div class="col-md-1" ></div>
					</div>
								
                       <div class="form-group">
					<label class="col-md-4" style="padding-left:0px;">Other Fees</label> 
                    <label class="col-md-2"></label>
                    
					<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="guest_OtherFees" id="OtherFees" value="0"  onblur="calc_final_amount();" /></div>
                    <div class="col-md-1" ></div>
					</div>
                                  
                                  
		
                                  
                                  
                                  
			
                                  
                                  
			
                                  <!--onblur="calc_final_amount();"-->
                                  
								   
                                  
                                  
								  
								 
                                  
                                  
                                  
                                  
                                  </div>
                                  </div>
                                  </div>
                    
						
                           	
                            
                            
                            
                                  
                                  <div class="panel" id="paid_by" style="display:block;">
                        <div class="panel-body">
						<div class="col-md-12" >
                                  <div class="form-group">
										<label class="col-md-5" style="padding-left:0px;"> Amount:<?=$astrik?></label>
													 <div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="amt" id="amt"/>
                                  
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
                                 <div class="form-group">
                              
                               
                                <div class=" col-md-5">
                                  <button type="submit" class="btn btn-primary form-control" >Generate</button>
                                </div>
                                   <div class="col-sm-5"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/add_fees_challan'">Cancel</button></div>
                 
                              </div>
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
$(document).ready(function(e) {
	
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
		$("#Excess").val(amount);
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
			var total=amth-value;
			$('#amth').val(total);
			$("#Excess").val(total);
			}else{
				//alert('2');
			var amth=$('#amth').val();
			var tutf=$('#tutf').val();
			var current=Number(amth) + Number(tutf);
			$('#amth').val(current);
			$("#Excess").val(current);
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
				$("#Excess").val(n);	
			}else{
			var amount=$("#tutf").val();
			var Excess=$("#Excess").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			$("#Excess").val(ng);
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
			$("#Excess").val(current);
			$("#tutf").val(0);
				 }
				}
			}
		}
		
		
		if(id=="Development_Fees_check"){
			var amth=$('#amth').val();
			if(Number(amth)>=Number(value)){
			if($(this).is(":checked")) {
			$("#devf").val(value);
			//var amth=$('#amth').val();
			var total=amth-value;
			$('#amth').val(total);
			$("#Excess").val(total);
			}else{
			var amth=$('#amth').val();
			var devf=$('#devf').val();
			var current=Number(amth) + Number(devf);
			$('#amth').val(current);
			$("#Excess").val(current);
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
				$("#Excess").val(n);
				}else{
			var amount=$("#tutf").val();
			var Excess=$("#Excess").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			$("#Excess").val(ng);
			$("#Excess").val(0);
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
				$("#Excess").val(current);
				$("#devf").val(0);
						}
				}
			}
		}
		if(id=="Caution_Form_check"){
			var amth=$('#amth').val();
			//alert(amth+'--'+value);
			if(Number(amth)>=Number(value)){
			if($(this).is(":checked")) {
			$("#cauf").val(value);
			//var amth=$('#amth').val();
			var total=amth-value;
			$('#amth').val(total);
			$("#Excess").val(total);
			}else{
			var cauf= $("#cauf").val();		
			var amth=$('#amth').val();
			var current=Number(amth) + Number(cauf);
			$('#amth').val(current);
			$("#Excess").val(current);
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
				$("#Excess").val(n);
				
				}else{
			var amount=$("#tutf").val();
			var Excess=$("#Excess").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			$("#Excess").val(ng);
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
			$("#Excess").val(current);
			$("#cauf").val(0);	
					}
				}
			
			}
		}
		if(id=="Admission_Form_check"){
			var amth=$('#amth').val();
			if(Number(amth)>=Number(value)){
			if($(this).is(":checked")) {
			$("#admf").val(value);
			//var amth=$('#amth').val();
			var total=amth-value;
			$('#amth').val(total);
			$("#Excess").val(total);
			}else{
			var admf=$('#admf').val();
			var amth=$('#amth').val();
			var current=Number(amth) + Number(admf);
			$('#amth').val(current);
			$("#Excess").val(current);
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
				$("#Excess").val(n);		
			//$('#Admission_Form_check').prop('checked',true);
					}else{
			var amount=$("#tutf").val();
			var Excess=$("#Excess").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			$("#Excess").val(ng);
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
			$("#Excess").val(current);	
			$("#admf").val(0);	
				}
				}
			}
		}
		
		
		if(id=="Exam_fees_check"){
			 var amth=$('#amth').val();
			 
		if(Number(amth)>=Number(value)){
		if($(this).is(":checked")) {
				
			$("#exmf").val(value);
			
			var total=amth-value;
			$('#amth').val(total);
			$("#Excess").val(total);
			}else{
			var exmf=$('#exmf').val();
			var amth=$('#amth').val();
			var current=Number(amth) + Number(exmf);
			$('#amth').val(current);
			$("#Excess").val(current);
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
				$("#Excess").val(n);	
				
			}else{
			var amount=$("#tutf").val();
			var Excess=$("#Excess").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			$("#Excess").val(ng);
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
			$("#Excess").val(current);	
			$("#exmf").val(0);
			}
		 }
			
	   }
		
		}
	 
		
		if(id=="University_fees_check"){
			 var amth=$('#amth').val();
			 
		if(Number(amth)>=Number(value)){
		
		    if($(this).is(":checked")) {
				
			$("#unirf").val(value);
			
			var total=amth-value;
			$('#amth').val(total);
			$("#Excess").val(total);	
			}else{
			var unirf=$('#unirf').val();
			var amth=$('#amth').val();
			var current=Number(amth) + Number(unirf);
			$('#amth').val(current);
			$("#Excess").val(current);
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
				$("#Excess").val(n);
		
		}else{
			var amount=$("#tutf").val();
			var Excess=$("#Excess").val();
			var ng=Number(amount) + Number(Excess);
			$('#amth').val(ng);	
			$("#Excess").val(ng);
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
		$("#Excess").val(current);
		$("#unirf").val(0);
		 }//if($(this).is(":checked")) 
		 }//if(Number(amth)!=0)
			
	   } //if(Number(amth)>=Number(value))
		
		} //if(id=="University_fees_check")
	  
		
			}//Status
		} //if(amount==0){
	})
});
</script>