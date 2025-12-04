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
   
	
    $('#sbutton').click(function()
	{
		// alert("hi");
		var base_url = '<?=base_url();?>';
		// alert(type);
		var prn = $("#prn").val();

		if(prn=='' )
		{
			$('#err_msg').html("Please enter PRN Number.");
			return false;
		}
        else
		{  
			$.ajax({
				'url' : base_url + '/Fees_challan/students_data',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'enrollment_no':prn},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					//var container = $('#stddata'); //jquery selector (get element by id)
					//alert(data);
					if(data != "{\"std_details\":null}")
					{
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
						$('#course').html(array.std_details.course_name);
						$('#cyear').val(array.std_details.current_year);
						$('#current_year').html(curr_year[array.std_details.current_year]);
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
                   
				    <div class="panel-heading">
					<div class="row">
						<div class="col-sm-3">
							<input type="text" class="form-control numbersOnly" required name="prn" id="prn" placeholder="PRN No."/>
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
							<div class="portlet-body form">
                          <form id="form" name="form" action="<?=base_url($currentModule.'/add_fees_challan_submit')?>" method="POST" >
                             
                            <div class="col-md-6" id="std_details" style="display:none;">
							
							<div class="panel">
                   
							<div class="panel-heading">
							<b>Student Details:</b>
							</div>
							
                            <div class="panel-body">
							<div class="col-md-12" >
                              <div class="form-group">
								<label class="col-md-4 text-right">ID:</label>
									 <div class="col-md-8" >
									 <input type="hidden" id="enroll" name="enroll" />
									 <input type="hidden" id="student_id" name="student_id" />
									 <span id="prnno" name="prnno"></span>								   
								   </div>			 
							  </div>
								<div class="form-group">
								<label class="col-md-4 text-right">Name:</label>
									 <div class="col-md-8" >
									  <span id="std_name" name="std_name"></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4 text-right">Course:</label>
									 <div class="col-md-8" >
									 
									 <span id="course" name="course"></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4 text-right">Institute:</label>
									 <div class="col-md-8" >
									 <span id="organisation" name="organisation"></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4 text-right">Current Year:</label>
									 <div class="col-md-8" >
									 
									 <span id="current_year" name="current_year"></span>								   
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4 text-right">Mobile:</label>
									 <div class="col-md-8" >
									 
									 <span id="mobile1" name="mobile1"></span>								   
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
											   /* if($yyyy==2017)
												   echo '<option selected value="'.$yyyy.'-'.$yy.'">'.$yyyy.'-'.$yy.'</option>';
											   else */
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
															?>
														  <option value="<?=$facility['faci_id']?>"><?=$facility['facility_name']?></option>  
														<?php 
															
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
														foreach($depositedto_details as $deposit){
															?>
														  <option value="<?=$deposit['bank_account_id']?>"><?=$deposit['bank_name']?></option>  
														<?php 
															
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
                                  <button type="submit" class="btn btn-primary form-control" >Generate</button>
                                </div>
                                   <div class="col-sm-4"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/'">Cancel</button></div>
                 
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
                                <label class="col-md-4 text-right">Deposit Fee:</label>
                                <div class="col-md-8">
                                   <input type="text" class="form-control numbersOnly" value="0" readonly name="deposit" id="deposit" />
                                </div>
                                
                              </div>
							  
							   <div class="form-group">
                                <label class="col-md-4 text-right">Facility Fee:</label>
                                <div class="col-md-8">
                                   <input type="text" class="form-control numbersOnly"  value="0" readonly name="facility" id="facility" />
                                </div>
                                
                              </div>
                              <div class="form-group">
								<label class="col-md-4  text-right">Other Fee:</label>
                                             <div class="col-md-8" >
											 <input type="text" class="form-control numbersOnly" name="other" id="other" value="0"/>								   
										   </div>			 
									  </div>  
										<div class="form-group">
										<label class="col-md-4  text-right">Amount:<?=$astrik?></label>
													 <div class="col-md-8" >
											 <input type="text" class="form-control numbersOnly" value="0"  name="amt" id="amt" />
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
											<input type="text" class="form-control numbersOnly"  name="receipt_number" id="receipt_number" />
										</div>
										</div>
										
										
								  <div class="form-group">
										<label class="col-md-4  text-right">Date:<?=$astrik?></label>
													 <div class="col-md-8" >
											 <input type="text" id="fees_date" name="fees_date" class="form-control"   readonly="true" />
											 
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
									<label class="col-md-4 text-right">Bank Branch:<?=$astrik?></label>
											 <div class="col-md-8" >
											 <input type="text" class="form-control alphaOnly" onchange="total_fees()" name="branch" id="branch" />
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
