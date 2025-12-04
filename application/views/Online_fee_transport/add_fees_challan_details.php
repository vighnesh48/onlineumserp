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
        $("#form").trigger("reset");

		if(prn=='' )
		{
			$('#err_msg').html("Please enter PRN Number.");
			$('#std_details').hide();
			$('#fee_details').hide();
			$('#btns').hide();
			return false;
		}else{  
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
						$('#enrollnew').val(array.std_details.enrollment_no_new);
						$('#student_id').val(array.std_details.stud_id);
						$('#std_name').html(array.std_details.first_name+' '+array.std_details.middle_name+' '+array.std_details.last_name);
						$('#organisation').html(array.std_details.organisation);
						
						if(array.Local==''){
						$('#LocalAddress').html(array.Local[0].address);
						$('#Localcity').html(array.Local[0].taluka_name);
						}else{
						$('#LocalAddress').html('Not Update');
						$('#Localcity').html('Not Update');	
						}
						
						if(array.PERMNT==''){
						$('#PermanentAddress').html(array.PERMNT[0].address);
						
						
						$('#Permanentcity').html(array.PERMNT[0].taluka_name);
						}else{
						$('#PermanentAddress').html('Not Update');
						
						
						$('#Permanentcity').html('Not Update');
						}
						
						//$('#Boarding_point option:eq(array.std_details.)')

                       // $('#Route_name option:eq(array.std_details.)')
					   

						$('#orgs').val(array.std_details.organisation);
						$('#stream').html(array.std_details.stream_name);
						$('#crs').val(array.std_details.course_name);
						$('#name').val(array.std_details.first_name+' '+array.std_details.middle_name+' '+array.std_details.last_name);
						$('#institute').html(array.std_details.school_name);
						$('#mobile1').html(array.std_details.mobile);
						$('#mbl').val(array.std_details.mobile);
						$('#inst').val(array.std_details.school_name);
						
						if(array.std_details.organisation=="SU"){
						$('#course').html(array.std_details.stream_name);
						}else {
						$('#course').html(array.std_details.course_name+' '+array.std_details.sfstream);
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
	var enrollnew = $('#enrollnew').val();
	if(academic!='' && facility!='')
	{
		type='POST',url='<?= base_url() ?>Transport_Challan/get_faci_fee_details',datastring={academic:academic,facility:facility,enroll:enroll,enrollnew:enrollnew};
		html_content=ajaxcall(type,url,datastring);
		if(html_content != "{\"fee_details\":null}")
		{
			//alert(html_content);
			var array=JSON.parse(html_content);
			$('#deposit').val(array.fee_details.deposit_fees);
			$('#facility').val(array.fee_details.actual_fees);
			
			
			$('#finefee').val(array.fee_details.fine_fees);
		    $('#Boarding_point').val(array.fee_details.allocated_id);
			$('#Boarding').val(array.fee_details.boarding_point);
			
			$('#Route_name').val(array.fee_details.route_id);
			$('#Route').val(array.fee_details.route_name);
			
			var amountt=Number(array.fee_details.fine_fees) + Number(array.fee_details.actual_fees)
			$('#amt').val(amountt);
			//$('#receipt_number').val(amountt);
			//fine_fees
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
			var finefee = $('#finefee').val();
			var excess = $('#excess').val();
			var transport_fees =  $('#facility').val();
			var othr = $('#other').val();
			
			var final_amount = parseInt(finefee)+parseInt(transport_fees)+parseInt(othr)+parseInt(excess); 
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
							<input type="text" class="form-control" required name="prn" id="prn" value="<?php echo $user_details[0]['registration_no']; ?>" placeholder="PRN No."/>
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
					<form id="form" name="form" action="https://erp.sandipuniversity.com/Transport_Challan/add_fees_challan_submit" method="POST" >
						
                          
                             
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
                                     <input type="hidden" id="enrollnew" name="enrollnew" />
									 <input type="hidden" id="student_id" name="student_id" />
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
							  <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Institute:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 <span id="organisation" name="organisation"></span>								   
								   </div>			 
							  </div>
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
								<label class="col-md-5" style="padding-left:0px;">Local Address:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 
									 <span id="LocalAddress" name="LocalAddress"></span>&nbsp;City:&nbsp;<span id="Localcity" name="Localcity"></span>								   								   
								   </div>			 
							  </div>
                              
                              <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Permanent Address:</label>
									 <div class="col-md-7" style="padding-left:0px;">
									 
									 <span id="PermanentAddress" name="PermanentAddress"></span>&nbsp;City:&nbsp;<span id="Permanentcity" name="Permanentcity"></span>									   
								   </div>			 
							  </div>
                              <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;"></label>
									 <div class="col-md-7" style="padding-left:0px;">
									 
																   
								   </div>			 
							  </div> 
                              
                              
                              <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Facility Type:<?=$astrik?></label>
                                <div class="col-md-5" style="padding-left:0px;">
                                  <select class="form-control" name="facilty" id="facilty" >
									  
									   <?php 
										//if(!empty($facility_details)){
											//foreach($facility_details as $facility){
												?>
											  <option value="2" selected="selected">Transport</option>  
											<?php 
												
											//}
										//}
									?>

								  </select>
                                </div>
                                
                              </div>
                              
                              
                              
                              
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Academic Year:<?=$astrik?></label>
                                <div class="col-md-5" style="padding-left:0px;">
                                  <select class="form-control" name="academic" id="academic" onchange="faci_type()">
									   <option value="" selected="selected">Select Academic Year</option>
									   <!--option  value="2020">2020-21</option>  
									   <option  value="2021">2021-22</option-->  
                                       <!--option  value="2023">2023-24</option--> 
                                       <option  value="2024">2024-25</option> 
                                       <option  value="2025">2025-26</option> 
										<?php  //echo "state".$state;exit();
										/*if(!empty($academic_details)){
											foreach($academic_details as $academic){
												$arr=explode("-",$academic['academic_year']);
												$ac_year=$arr[0];
												if($academic['status']=='Y')
												{
												?>
											  <option  value="<?=$ac_year?>" <?php if($ac_year=="2021"){?> selected="selected"<?php } ?>><?=$academic['academic_year']?></option>  
											<?php 
												}else{
												?>
												<option value="<?=$ac_year?>" <?php if($ac_year=="2021"){?> selected="selected"<?php } ?>><?=$academic['academic_year']?></option> 
												<?php
												}
												
											}
										}*/
									  ?>
									  </select>
                                </div>
                                
                              </div>
							  
                              <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Route Name:<?=$astrik?></label>
                                <div class="col-md-5" style="padding-left:0px;">
                                <input type="text" name="Route" id="Route" class="form-control" value="" readonly="readonly"/>
                                <input type="hidden" name="Route_name" id="Route_name" value="" />
                                  
                                </div>
                                
                              </div>
                              
                              
                              
                              
                              <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Boarding Point:<?=$astrik?></label>
                                <div class="col-md-5" style="padding-left:0px;">
                                <input type="text" name="Boarding" id="Boarding" class="form-control" value="" readonly="readonly"/>
                                <input type="hidden" name="Boarding_point" id="Boarding_point" value="" />
                                 
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
											  <option value="<?=$deposit['bank_account_id']?>"><?=$deposit['account_name']?> - <?=$deposit['bank_name']?></option>  
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
							
							
							<b>Fee Details:</b>
							</div>
                            <div class="panel-body">
							
							
						
							<div class="col-md-12" >
								<div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Transport Fee:</label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control numbersOnly"  value="0" name="facility" id="facility" onblur="calc_final_amount();"/>
                                </div>
                                
                              </div>
								<div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Fine Fee:</label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control numbersOnly" value="0"  name="finefee" id="finefee" onblur="calc_final_amount();"/>
                                </div>
                                
                              </div>
							  
							   
                              <div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Other Fee:</label>
                                             <div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="other" id="other" value="0" onblur="calc_final_amount();"/>								   
										   </div>			 
									  </div> 
							<div class="form-group">
								<label class="col-md-5" style="padding-left:0px;">Excess Fee:</label>
                                             <div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="excess" id="excess" value="0" onblur="calc_final_amount();"/>								   
										   </div>			 
									  </div> 
										<div class="form-group">
										<label class="col-md-5" style="padding-left:0px;">Amount Paid:<?=$astrik?></label>
													 <div class="col-md-6" >
											 <input type="text" class="form-control numbersOnly" name="amt" id="amt" readonly />
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
											<option value="CASH">Cash</option>
                                            <option value="GATEWAY-ONLINE" selected="selected">GATEWAY-ONLINE</option>
                                          
											</select>	
										   </div>
										
									  </div>  
									  
									  <div id="non_cash" style="display:none;">
										<div class="form-group">
										
										<label class="col-md-5" style="padding-left:0px;" id="receipt"></label>
											<div class="col-md-6" >
											<input type="text" class="form-control numbersOnly"  name="receipt_number" id="receipt_number" value="<?php echo $user_details[0]['bank_ref_num'];?>" /><a href="javascript:void(0);" id="Check_recepit" class="Check_recepit btn btn-primary">Check</a>

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
											 <input type="text" id="fees_date" name="fees_date" class="form-control" value="<?php echo $user_details[0]['payment_date'];?>"   readonly="true" />
											 
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
                                  <button type="submit" class="btn btn-primary form-control Generate" >Generate</button>
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
<script>
$(document).ready(function(){
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
<?php if($this->session->userdata("role_id")==5){ ?>
		//echo $this->uri->segment(3);
		
		var newsegment='<?php echo $this->uri->segment(3); ?>';
		if(newsegment==""){}else{	
		$("#prn").val(newsegment);			
        $("#sbutton").trigger("click");
		}

<?php }?>
});
						
						</script>
                        
                        </script><script>
$(document).ready(function(){
$("#sbutton").trigger('click');
setTimeout(() => { faci_type(); }, 3000);
setTimeout(() => { display_noncash(); }, 1000);
//faci_type();
});
</script>


