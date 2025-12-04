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
		
		if(facility=="2"){
			$('.Refresh').show();
			$("#amth").attr("readonly", "readonly");
		//$("#form").trigger("reset");
		type='POST',url='<?= base_url() ?>Challan/get_fee_details_new',datastring={academic:academic,facility:facility,enroll:enroll,stud:stud,curr_yr:curr_yr,admission_session:admission_session};
		html_content=ajaxcall(type,url,datastring);
	//	alert(html_content);
			var array=JSON.parse(html_content);
			//alert(array[0].actual_fee);
		//	$('#deposit').val(array.actual_fee);
		
		//if(array[0].applicable_fee<array[0].amount_paid)
		//{
		   
		//	var apend =   array[0].amount_paid-array[0].applicable_fee;
		//}else{
			 var apend = array[0].applicable_fee - array[0].amount_paid;

		//}
			
			$('#apend').val(apend);
			$('#apaid').val(array[0].amount_paid);
			
			$('#amtpand').html(apend);
			$('#amtpaid').html(array[0].amount_paid);
			
			$('#facility').val(array[0].applicable_fee);
			
			
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
						
						$('#Balance_org').val(array[0].opening_balance);
						
						if((array[1].fees_id)!=0){
						$('.Balance_Amount_read').html(array[1].Balance_Pending);
						$('#Balance_Amount_check').val(array[1].Balance_Pending);
						if((array[1].Balance_Amount_status)=="Y"){
						$("#Balance_Amount_check").attr("disabled", true);
						$("#Balance_Amount").attr('readonly', true);
						}
						}else{
						$('.Balance_Amount_read').html(array[0].opening_balance);
						$('#Balance_Amount_check').val(array[0].opening_balance);	
						//$('#Balance_Amount').val(array[0].opening_balance);
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
						Number(array[0].seminar_training) + Number(array[0].student_activity) + Number(array[0].lab) + Number(array[0].internet)+ Number(array[0].computerization)+ Number(array[0].nss);
						
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
			$('#Caution_money').hide();		
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
			$('.Refresh').hide();
			$("#amth").removeAttr("readonly");
			$('#fee_details').hide();
			$('#err_msg2').html('');
			$('#Other_Income').hide();
			$('#Caution_money').hide();	
            $('#Exam_Related').show();
			$('.Late_Fees').hide();
			$('.Backlog_Exam').show();
			$('.Revaluation_Fees').hide();
			$('.Photocopy_Fees').hide();
			$("#paid_by").show();
		}
		
		else if(facility=="7"){
			$('#btns').show();
			$('.Refresh').hide();
			$("#amth").removeAttr("readonly");
			$('#fee_details').hide();
			$('#err_msg2').html('');
			$('#Other_Income').hide();
			$('#Caution_money').hide();	
            $('#Exam_Related').show();
			$('.Late_Fees').show();
			$('.Backlog_Exam').show();
			$('.Revaluation_Fees').hide();
			$('.Photocopy_Fees').hide();
			$("#paid_by").show();
		}
		else if(facility=="8"){
			$('#btns').show();
			$('.Refresh').hide();
			$("#amth").removeAttr("readonly");
			$('#fee_details').hide();
			$('#err_msg2').html('');
			$('#Other_Income').hide();
			$('#Caution_money').hide();	
            $('#Exam_Related').show();
			$('.Late_Fees').hide();
			$('.Backlog_Exam').hide();
			$('.Revaluation_Fees').show();
			$('.Photocopy_Fees').hide();
			$("#paid_by").show();
		}
		else if(facility=="9"){
			$('#btns').show();
			$('.Refresh').hide();
			$("#amth").removeAttr("readonly");
			$('#fee_details').hide();
			$('#err_msg2').html('');
			$('#Other_Income').hide();
			$('#Caution_money').hide();	
            $('#Exam_Related').show();
			$('.Late_Fees').hide();
			$('.Backlog_Exam').hide();
			$('.Revaluation_Fees').hide();
			$('.Photocopy_Fees').show();
			$("#paid_by").show();
		}
		else if(facility=="10"){
			$('#btns').show();
			$('.Refresh').hide();
			$("#amth").removeAttr("readonly");
			$('#fee_details').hide();
			$('#err_msg2').html('');
            $('#Exam_Related').hide();
			$('.Late_Fees').hide();
			$('.Backlog_Exam').hide();
			$('.Revaluation_Fees').hide();
			$('.Photocopy_Fees').hide();
			$('#Other_Income').show();
			$('#Caution_money').hide();	
			$("#paid_by").show();
		}else if(facility=="12"){
			$('#btns').show();
			$('.Refresh').hide();
			$("#amth").removeAttr("readonly");
			$('#fee_details').hide();
			$('#err_msg2').html('');
            $('#Exam_Related').hide();
			$('.Late_Fees').hide();
			$('.Backlog_Exam').hide();
			$('.Revaluation_Fees').hide();
			$('.Photocopy_Fees').hide();
			$('#Other_Income').hide();
			$('#Caution_money').show();	
			$("#paid_by").show();
		}
		
		
		
		/*else if(facility=="5" || facility=="8" || facility=="7" || facility=="9"){
			$('#btns').show();
			$('.Refresh').hide();
			$("#amth").removeAttr("readonly");
			$('#fee_details').hide();
			$('#err_msg2').html('');
			$('#Other_Income').hide();
            $('#Exam_Related').show();
			$("#paid_by").show();
		}
		else if(facility=="10"){
			$('#btns').show();
			$('.Refresh').hide();
			$("#amth").removeAttr("readonly");
			$('#fee_details').hide();
			$('#err_msg2').html('');
            $('#Exam_Related').hide();
			$('#Other_Income').show();
			$("#paid_by").show();
		}*/
		
		
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
	if((ptype=='CASH'))
	{
		$('#non_cash').hide();
	   // $('#Online_pay').hide();

	}
	else if((ptype=='OL')){
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
		<input type="text" class="form-control" name="prn" id="prn" value="<?php echo $user_details[0]['enrollment_no']; ?>" placeholder="PRN No."/>
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
		<form id="form" name="form" action="<?=base_url('challan/add_fees_challan_submit')?>" method="POST" >
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
                                      <input type="hidden" name="admission_session" id="admission_session" value="" />
                                </div>
                                
                              </div>
							  <div class="form-group">
                                <label class="col-md-5" style="padding-left:0px;">Fee  Type:<?=$astrik?></label>
                                <div class="col-md-6" style="padding-left:0px;">
                                  <select class="form-control" name="facilty" id="facilty" onchange="faci_type()" >
									  <option value="">Select Fee Type</option>
									 <option value="2" <?php if($productinfo=='Admission'){ echo "selected";} ?>>Academic Fees</option>
									  <option value="5" <?php if($productinfo=='Examination'){ echo "selected";} ?>>Examination Fees</option>
                       
                                      <option value="7">Examination Late fess</option>
                                      <option value="8" <?php if($productinfo=='Revaluation'){ echo "selected";} ?>>Revaluation</option>
                                      <option value="9" <?php if($productinfo=='Photocopy'){ echo "selected";} ?>>Photocopy</option>
                                      <option value="10" >Other Fees</option>
 <option value="12" >Caution money</option>
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
								
                            
                            
                              </div>
								<div class="form-group">
					<label class="col-md-4" style="padding-left:0px;"> </label> 
                    <label class="col-md-1"></label>
                    <label class="col-md-1"></label>
					<div class="col-md-5" ></div>
                    <div class="col-md-1" ></div>
					</div>
                                
                                
                                  <div class="form-group">
					<label class="col-md-4" style="padding-left:0px;"> </label> 
                    <label class="col-md-1">Pending</label>
                    <label class="col-md-1"></label>
					<div class="col-md-5" >Amount pay</div>
                    <div class="col-md-1" ></div>
					</div>
                    
                    <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Previous Balance</label>
        <label class="col-md-2"><i class="fa fa-rupe" style="font-size:11px">&nbsp;</i><span class="Balance_Amount_read"></span><!--<span class="Balance_Amount_read"></span>--></label>
         
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Balance_Amount" id="Balance_Amount" value="0" readonly="readonly" /></div>
             <div class="col-md-1"> <input type="checkbox" class="cal_math" name="Balance_Amount_check" id="Balance_Amount_check" value="" />
									   </div>
								  </div>
                                  
								<div class="form-group">
					<label class="col-md-4" style="padding-left:0px;">Tuition Fees </label> 
                    <label class="col-md-2"><i class="fa fa-rupee" style="font-size:11px">&nbsp;</i><span class="Tuition_Fees_read"></span></label>
                    
					<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="tutf" id="tutf" value="0"  readonly="readonly" /></div>
                    <div class="col-md-1" ><input type="checkbox" class="cal_math" name="" id="Tuition_Fees_check" value="" /></div>
					</div>
								
                       <div class="form-group">
			<label class="col-md-4" style="padding-left:0px;">Development Fees</label>
            <label class="col-md-2"><i class="fa fa-rupee" style="font-size:11px">&nbsp;</i><span class="Development_Fees_read"></span></label>
              
			<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="devf" id="devf" value="0"  readonly="readonly" /></div>
                    <div class="col-md-1" ><input type="checkbox" class="cal_math" name="" id="Development_Fees_check" value="" /></div>
				</div>
                                  
                                  
		<div class="form-group">
	    <label class="col-md-4" style="padding-left:0px;">Caution Money </label>
        <label class="col-md-2"><i class="fa fa-rupee" style="font-size:11px">&nbsp;</i><span class="Caution_read"></span></label>
        
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="cauf" id="cauf" value="0"  readonly="readonly" /></div>
                    <div class="col-md-1" ><input type="checkbox" class="cal_math" name="" id="Caution_Form_check" value="" /></div>
								  </div>
                                  
                                  
                                  
			<div class="form-group">
             <label class="col-md-4" style="padding-left:0px;">Admission Form</label>
             <label class="col-md-2"><i class="fa fa-rupee" style="font-size:11px">&nbsp;</i><span class="Admission_Form_read"></span></label>
            
			 <div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="admf" id="admf" value="0"  readonly="readonly" /></div>
             <div class="col-md-1" ><input type="checkbox" class="cal_math" name="" id="Admission_Form_check" value="" />
			 </div>
								  </div>
                                  
                                  
			<div class="form-group">
			 <label class="col-md-4" style="padding-left:0px;">Exam fees</label>
             <label class="col-md-2"><i class="fa fa-rupee" style="font-size:11px">&nbsp;</i><span class="Exam_fees_read"></span></label>
            
			<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="exmf" id="exmf" value="0"  readonly="readonly" /></div>
             <div class="col-md-1"><input type="checkbox" class="cal_math" name="" id="Exam_fees_check" value="" /></div>
						</div>
                                  <!--onblur="calc_final_amount();"-->
                                  
								   <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">University Fees</label>
        <label class="col-md-2"><i class="fa fa-rupee" style="font-size:11px">&nbsp;</i><span class="University_fees_read"></span></label>
         
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="unirf" id="unirf" value="0" readonly="readonly" /></div>
             <div class="col-md-1"> <input type="checkbox" class="cal_math" name="" id="University_fees_check" value="" />
									   </div>
								  </div>
                                  
                                  
                                  
                                 <?php /* <div class="form-group">
		<label class="col-md-4" style="padding-left:0px;">Excess Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Excess" id="Excess" value="0" readonly="readonly"/></div>
             <div class="col-md-1">
									   </div>
								  </div> */?>
								  
								 
                                  
                                  
                                  
                                  
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
		<?php 
		if(!empty($examsession)){
		foreach($examsession as $list){?>
		<option value="<?php echo $list['exam_name'];?>:<?php echo $list['exam_id'];?>"><?php echo $list['exam_name'];?></option>  
		<?php }} ?>
								  </select></div>
             <div class="col-md-1">
									   </div>
								  </div>
                        
                        
                        
                        <div class="form-group Backlog_Exam" style="display:none">
		<label class="col-md-4" style="padding-left:0px;">Backlog Exam Fees</label>
        <label class="col-md-1"></label>
         <label class="col-md-1"></label>
		<div class="col-md-5" ><input type="text" class="form-control numbersOnly" name="Backlog_Exam" id="Backlog_Exam" value="0" onblur="calc_final_amount();" /></div>
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
                           
                           <div class="panel" id="Caution_money" style="display:none;">
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
                                            <option value="OL" selected="selected">Online</option>
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
										</div><div class="col-md-1"></div>
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
                                  <button type="submit" class="btn btn-primary form-control" >Generate</button>
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

<script>
$(document).ready(function(e) {
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