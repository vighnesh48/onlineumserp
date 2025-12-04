<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
var err_status=0;
$(document).ready(function()
{
	var academic = $('#academic').val();
	var year = '<?=$academic_fee_details['admission_year']?>';
	var academic_fee=0;
	var other_fee=0;
	var total=0;
	if(year>=2019)
	{
		academic_fee=parseInt('<?=$academic_fee_details['tution_fees']?>')+parseInt('<?=$academic_fee_details['development']?>');
		$('#academic_fee').val(academic_fee);
	
		other_fee=parseInt('<?=$academic_fee_details['Gymkhana']?>')+parseInt('<?=$academic_fee_details['registration']?>')+parseInt('<?=$academic_fee_details['student_safety_insurance']?>')+parseInt('<?=$academic_fee_details['library']?>')+parseInt('<?=$academic_fee_details['eligibility']?>')+parseInt('<?=$academic_fee_details['internet']?>')+parseInt('<?=$academic_fee_details['educational_industrial_visit']?>')+parseInt('<?=$academic_fee_details['seminar_training']?>')+parseInt('<?=$academic_fee_details['student_activity']?>')+parseInt('<?=$academic_fee_details['lab']?>')+parseInt('<?=$academic_fee_details['exam_fees']==''?0:$academic_fee_details['exam_fees']?>');
		//+parseInt('<?=$academic_fee_details['caution_money']?>')+parseInt('<?=$academic_fee_details['admission_form']?>')
		$('#other_fee').val(other_fee);
		
		$('#2018').show();
		$('#2017').hide();
	}
	if(year<2019)
	{
		academic_fee=parseInt('<?=$academic_fee_details['tution_fees']?>')+parseInt('<?=$academic_fee_details['development']?>');
		//+parseInt('<?=$academic_fee_details['caution_money']?>')+parseInt('<?=$academic_fee_details['admission_form']?>')
		$('#academic_fee').val(academic_fee);
	
		other_fee=parseInt('<?=$academic_fee_details['Gymkhana']?>')+parseInt('<?=$academic_fee_details['registration']?>')+parseInt('<?=$academic_fee_details['student_safety_insurance']?>')+parseInt('<?=$academic_fee_details['library']?>')+parseInt('<?=$academic_fee_details['disaster_management']?>')+parseInt('<?=$academic_fee_details['computerization']?>')+parseInt('<?=$academic_fee_details['nss']?>')+parseInt('<?=$academic_fee_details['exam_fees']==''?0:$academic_fee_details['exam_fees']?>');
		//alert(other_fee);
		$('#other_fee').val(other_fee);
		
		$('#2018').hide();
		$('#2017').show();
	}
	
	total=academic_fee+other_fee+parseInt('<?=$academic_fee_details['caution_money']?>')+parseInt('<?=$academic_fee_details['admission_form']?>');
		/* total=parseInt($('#Tution').val())+parseInt($('#Development').val())+parseInt($('#caution_money').val())+parseInt($('#admission_form').val())+parseInt($('#Gymkhana').val())+parseInt($('#Disaster').val())+parseInt($('#Computerization').val())+parseInt($('#Registration').val())+parseInt($('#Insurance').val())+parseInt($('#Library').val())+parseInt($('#NSS').val()); */
		//alert(total);
		$('#Total').val(total);
	
	var stream = $('#stream_id').val();
	var fees_id = $('#fees_id').val();
	 // Num check logic
  	$('.numbersOnly').keyup(function () {
		
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
	
	var acyear='<?=$academic_fee_details['academic_year']?>';
	$('#academic option').each(function()
	 {              
		 if($(this).val()== acyear)
		{
		$(this).attr('selected','selected');
		}
	});
	
	var year1='<?=$academic_fee_details['admission_year']?>';
	$('#year option').each(function()
	 {              
		 if($(this).val()== year1)
		{
			$(this).attr('selected','selected');
		}
	});
	
	
	
	var academic = $('#academic').val();
	var yr=$("#year").val();
	var len=0;
	if(yr>2018)
		len=3;
	else
	{
		len=4;
		$('#current_year').hide();
	}
	var $select = $(".select").html('<option value="">select Year</option>');
	for (i=1;i<=len;i++){
		$select.append($('<option></option>').val(i).html(i))
	}
	
	var y='<?=$academic_fee_details['year']?>';
	$('#yr option').each(function()
	 {              
		 if($(this).val()== y)
		{
			$(this).attr('selected','selected');
		}
	});
	/* var Scholorship='<?=$academic_fee_details['scholorship_allowed']?>';
	$('#Scholorship option').each(function()
	 {              
		 if($(this).val()== Scholorship)
		{
		$(this).attr('selected','selected');
		}
	}); */
	
	var html_content='';
	$('#academic').on('change', function () {
		var academic = $(this).val();
		var adyear = $('#year').val();
		if(academic=='' || adyear=='')
			$('#err_msg').html('please select both academic year and admission year.');
		else{
			type='POST',url='<?= base_url() ?>Master/edit_check_academicfee_exists',datastring={academic:academic,fees_id:fees_id,stream_id:stream,year:adyear};
			html_content=ajaxcall(type,url,datastring);
			//alert(html_content);
			if(html_content>0)
			{
				$('#err_msg').html('Already fee details exists for academic year - '+academic);
				err_status=1;
			}
			else{
				$('#err_msg').html('');
				err_status=0;
			}
		}
	});
	
	$('#year').on('change', function () {
		var admyear = $(this).val();
		
		var academic = $('#academic').val();
		if(academic=='' || admyear=='')
			$('#err_msg').html('please select both academic year and admission year.');
		else{
			//alert(admyear);
			var len=0;
			if(admyear>2018)
				len=3;
			else
				len=4;
			
			var $select = $(".select").html('<option value="">select Year</option>');
			for (i=1;i<=len;i++){
				$select.append($('<option></option>').val(i).html(i))
			}
			if(admyear>2018)
			{
				other_fee=parseInt('<?=$academic_fee_details['Gymkhana']==''?0:$academic_fee_details['Gymkhana']?>')+parseInt('<?=$academic_fee_details['registration']==''?0:$academic_fee_details['registration']?>')+parseInt('<?=$academic_fee_details['student_safety_insurance']==''?0:$academic_fee_details['student_safety_insurance']?>')+parseInt('<?=$academic_fee_details['library']==''?0:$academic_fee_details['library']?>')+parseInt('<?=$academic_fee_details['eligibility']==''?0:$academic_fee_details['eligibility']?>')+parseInt('<?=$academic_fee_details['internet']==''?0:$academic_fee_details['internet']?>')+parseInt('<?=$academic_fee_details['educational_industrial_visit']==''?0:$academic_fee_details['educational_industrial_visit']?>')+parseInt('<?=$academic_fee_details['seminar_training']==''?0:$academic_fee_details['seminar_training']?>')+parseInt('<?=$academic_fee_details['student_activity']==''?0:$academic_fee_details['student_activity']?>')+parseInt('<?=$academic_fee_details['lab']==''?0:$academic_fee_details['lab']?>')+parseInt('<?=$academic_fee_details['exam_fees']==''?0:$academic_fee_details['exam_fees']?>');
		//+parseInt('<?=$academic_fee_details['caution_money']?>')+parseInt('<?=$academic_fee_details['admission_form']?>')
		$('#other_fee').val(other_fee);
				$('#gym').html('Sports & Ammenties');
				$('#regt').html('Enrollment');
				$('#2018').show();
				$('#2017').hide();
				$('#current_year').show();
			}
			else
			{
				$('#current_year').hide();
				other_fee=parseInt('<?=$academic_fee_details['Gymkhana']==''?0:$academic_fee_details['Gymkhana']?>')+parseInt('<?=$academic_fee_details['registration']==''?0:$academic_fee_details['registration']?>')+parseInt('<?=$academic_fee_details['student_safety_insurance']==''?0:$academic_fee_details['student_safety_insurance']?>')+parseInt('<?=$academic_fee_details['library']==''?0:$academic_fee_details['library']?>')+parseInt('<?=$academic_fee_details['disaster_management']==''?0:$academic_fee_details['disaster_management']?>')+parseInt('<?=$academic_fee_details['computerization']==''?0:$academic_fee_details['computerization']?>')+parseInt('<?=$academic_fee_details['nss']==''?0:$academic_fee_details['nss']?>')+parseInt('<?=$academic_fee_details['exam_fees']==''?0:$academic_fee_details['exam_fees']?>');
		//alert(other_fee);
		$('#other_fee').val(other_fee);
				$('#gym').html('Gymkhana');
				$('#regt').html('Registration');
				$('#2018').hide();
				$('#2017').show();
			}
			type='POST',url='<?= base_url() ?>Master/edit_check_academicfee_exists',datastring={academic:academic,fees_id:fees_id,stream_id:stream,year:admyear};
			html_content=ajaxcall(type,url,datastring);
			if(html_content>0)
			{
				$('#err_msg').html('Already fee details exists for the year - '+admyear+' & academic - '+academic);
				err_status=1;
			}
			else{
				$('#err_msg').html('');
				err_status=0;
			}
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

function form_validate(event)
{
	/* var total=parseInt($('#academic_fee').val())+parseInt($('#Tution').val())+parseInt($('#Development').val())+parseInt($('#caution_money').val())+parseInt($('#admission_form').val())+parseInt($('#Gymkhana').val())+parseInt($('#Disaster').val())+parseInt($('#Computerization').val())+parseInt($('#Registration').val())+parseInt($('#Insurance').val())+parseInt($('#Library').val())+parseInt($('#NSS').val());
	//alert(total);
	$('#Total').val(total); */
	if(err_status==1)
		return false;
	
}

function total_fees()
{
	if($('#academic_fee').val()=='')$('#academic_fee').val(0);
	if($('#Tution').val()=='')$('#Tution').val(0);
	if($('#Development').val()=='')$('#Development').val(0);
	if($('#caution_money').val()=='')$('#caution_money').val(0);
	if($('#admission_form').val()=='')$('#admission_form').val(0);
	if($('#Gymkhana').val()=='')$('#Gymkhana').val(0);
	if($('#Disaster').val()=='')$('#Disaster').val(0);
	if($('#Computerization').val()=='')$('#Computerization').val(0);
	if($('#Registration').val()=='')$('#Registration').val(0);
	if($('#Insurance').val()=='')$('#Insurance').val(0);
	if($('#Library').val()=='')$('#Library').val(0);
	if($('#NSS').val()=='')$('#NSS').val(0);
	
	if($('#eligibility').val()=='')$('#eligibility').val(0);
	if($('#internet').val()=='')$('#internet').val(0);
	if($('#Registration').val()=='')$('#Registration').val(0);
	if($('#visit').val()=='')$('#visit').val(0);
	if($('#training').val()=='')$('#training').val(0);
	if($('#activity').val()=='')$('#activity').val(0);
	if($('#lab').val()=='')$('#lab').val(0);
	if($('#exam_fees').val()=='')$('#exam_fees').val(0);
	
	var academic = $('#academic').val();
	var year = $('#year').val();//$("#year option:selected").text();
	var academic_fee=0;
	var other_fee=0;
	var total=0;
	//alert(year);
	if(year!=='') 
	{		
		if(year>2019)
		{
			academic_fee=parseInt($('#Tution').val())+parseInt($('#Development').val());
		$('#academic_fee').val(academic_fee);
		
			other_fee=parseInt($('#Gymkhana').val())+parseInt($('#Registration').val())+parseInt($('#Insurance').val())+parseInt($('#Library').val())+parseInt($('#eligibility').val())+parseInt($('#internet').val())+parseInt($('#visit').val())+parseInt($('#training').val())+parseInt($('#activity').val())+parseInt($('#lab').val())+parseInt($('#exam_fees').val());
			//+parseInt($('#caution_money').val())+parseInt($('#admission_form').val())
			$('#other_fee').val(other_fee);
		}
		else
		{
			academic_fee=parseInt($('#Tution').val())+parseInt($('#Development').val());
			//+parseInt($('#caution_money').val())+parseInt($('#admission_form').val())
		$('#academic_fee').val(academic_fee);
		
			other_fee=parseInt($('#khana').val())+parseInt($('#mngmt').val())+parseInt($('#Computer').val())+parseInt($('#Regis').val())+parseInt($('#Insur').val())+parseInt($('#Libr').val())+parseInt($('#NSS').val())+parseInt($('#exm_fees').val());
			$('#other_fee').val(other_fee);
		}
		
		total=academic_fee+other_fee+parseInt($('#caution_money').val())+parseInt($('#admission_form').val());
		/* total=parseInt($('#Tution').val())+parseInt($('#Development').val())+parseInt($('#caution_money').val())+parseInt($('#admission_form').val())+parseInt($('#Gymkhana').val())+parseInt($('#Disaster').val())+parseInt($('#Computerization').val())+parseInt($('#Registration').val())+parseInt($('#Insurance').val())+parseInt($('#Library').val())+parseInt($('#NSS').val()); */
		//alert(total);
		$('#Total').val(total);
	}
	else 
	{
		alert('Please select admission year');
		$('#year').focus();
		$('#emptab').hide();
	}
}

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <!--<li class="active"><a href="<?=base_url($currentModule)?>">Fees Master </a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-5 text-ctext-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Update Academic Fees </h1>
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                   <div class="panel-heading">
                        <span class="panel-title">Fee Details of <b><?=$academic_fee_details['stream_short_name']?></b></span>
						<span id="err_msg" style="color:red;padding-left:10px;"></span>				
					<span id="flash-messages" style="color:Green;padding-left:10px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:10px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
                </div>
                    <div class="panel-body">
							<div class="portlet-body form">
                          <form id="form" name="form" action="<?=base_url($currentModule.'/edit_academic_fees_submit')?>" method="POST" onsubmit="return form_validate(event)">
                             
                             <input type="HIDDEN" class="form-control" name="fees_id" id="fees_id" value="<?=$academic_fee_details['academic_fees_id']?>"/>                             
							 <input type="HIDDEN" class="form-control" name="stream_id" id="stream_id" value="<?=$academic_fee_details['stream_id']?>"/> 
                            <div class="col-md-6">
							<div class="form-group">
                                <label class="col-md-6 text-right">Stream Name</label>
                                <div class="col-md-5" >
                                  <input type="text" class="form-control" value="<?=$academic_fee_details['stream_short_name']?>" readonly name="stream" id="stream" />
                                </div>
                              </div>
							
                              <div class="form-group">
                                <label class="col-md-6 text-right">Academic Year</label>
                                <div class="col-md-5">
                                  <select class="form-control" name="academic" id="academic" >
									  <option value="">select Academic Year</option>
									   <?php 
												 $yyyy=date('Y');
												 $yy=date('y')+1;
												   for($i=1;$i<=4;$i++)
												   {
													   if($yyyy==$academic_fee_details['academic_year'])
														   echo '<option selected value="'.$yyyy.'-'.$yy.'">'.$yyyy.'-'.$yy.'</option>';
													   else
														   echo '<option value="'.$yyyy.'-'.$yy.'">'.$yyyy.'-'.$yy.'</option>';
													   
													   $yyyy--;$yy--;
												   }
												   ?>
								  </select>
                                </div>
                                
                              </div>
							  
							   <div class="form-group">
                                <label class="col-md-6 text-right">Admission Year</label>
                                <div class="col-md-5">
                                  <select class="form-control" name="year" id="year" >
									  <option value="">select Admission Year</option>
						  <?php 
								$yyyy=date('Y');
								$yy=date('y')+1;
								for($i=1;$i<=4;$i++)
								{
								   if($yyyy==$academic_fee_details['admission_year'])
									   echo '<option selected value="'.$yyyy.'">'.$yyyy.'-'.$yy.'</option>';
								   else 
									echo '<option value="'.$yyyy.'">'.$yyyy.'-'.$yy.'</option>';
								   
								   $yyyy--;$yy--;
								}
							?>
					  </select>
                                </div>
                                
                              </div>
                              <div class="form-group" id="current_year">
                                <label class="col-md-6 text-right">Year</label>
                                <div class="col-md-5">
                                  <select class="select form-control" name="yr" id="yr" >
									<option value="">select Year</option>
									
								  </select>
                                </div>
                                
                              </div>   
							<div class="form-group">
							<label class="col-md-6  text-right">Tution Fees </label>
							<div class="col-md-5" >
								  <input type="text" class="form-control numbersOnly" value="<?=$academic_fee_details['tution_fees']?>" onchange="total_fees()"  name="Tution" id="Tution" />	
							   </div>
						  </div>                                      
							<div class="form-group">
							<label class="col-md-6  text-right">Development</label>
										 <div class="col-md-5" >
								 <input type="text" class="form-control numbersOnly" value="<?=$academic_fee_details['development']?>" onchange="total_fees()"  name="Development" id="Development" />
						   </div>
						</div>
						<div class="form-group">
								<label class="col-md-6  text-right">Academic Fees</label>
                                             <div class="col-md-5" >
											 <input type="text" class="form-control numbersOnly" value="<?=$academic_fee_details['academic_fees']?>" onchange="total_fees()"  name="academic_fee" id="academic_fee" />								   
										   </div>			 
									  </div> 
								  <div class="form-group">
										<label class="col-md-6  text-right">Caution Money</label>
													 <div class="col-md-5" >
											 <input type="text" class="form-control numbersOnly" value="<?=$academic_fee_details['caution_money']?>" onchange="total_fees()"  name="caution_money" id="caution_money" />
									   </div>
								  </div>
								  <div class="form-group">
										<label class="col-md-6  text-right">Admission Form</label>
													 <div class="col-md-5" >
											 <input type="text" class="form-control numbersOnly" value="<?=$academic_fee_details['admission_form']?>" onchange="total_fees()"  name="admission_form" id="admission_form" />
									   </div>
								  </div>
								  
								                   
                            </div>
                          <div class="col-md-6">
						  
				  <div id="2018" style="display:none;">
				  
				  <div class="form-group">
					<label class="col-md-7 text-right">Exam Fees</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly"  onchange="total_fees()" value="<?=$academic_fee_details['exam_fees']?>" name="exam_fees" id="exam_fees" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right">Student Safety Insurance</label>
					<div class="col-md-4">
					  <input type="text" class="form-control numbersOnly"  onchange="total_fees()" value="<?=$academic_fee_details['student_safety_insurance']?>" name="Insurance" id="Insurance" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right" id="regt">Enrollment</label>
					<div class="col-md-4" >
					<input type="text" class="form-control numbersOnly"   onchange="total_fees()" value="<?=$academic_fee_details['registration']?>" name="Registration" id="Registration" />
					</div>
				  </div>
				   <div class="form-group">
					<label class="col-md-7 text-right " id="gym">Sports & Ammenties</label>
								 <div class="col-md-4" >
								 <input type="text" class="form-control numbersOnly" onchange="total_fees()" value="<?=$academic_fee_details['Gymkhana']?>"  name="Gymkhana" id="Gymkhana" />
						   </div>
					  </div> 
				  <div class="form-group">
					<label class="col-md-7 text-right">Eligibility</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly"  onchange="total_fees()" value="<?=$academic_fee_details['eligibility']?>" name="eligibility" id="eligibility" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right">Library</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly"   onchange="total_fees()" value="<?=$academic_fee_details['library']?>" name="Library" id="Library" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right">Internet</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly"  onchange="total_fees()" value="<?=$academic_fee_details['internet']?>" name="internet" id="internet" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right">Industrial visit</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly"  onchange="total_fees()" value="<?=$academic_fee_details['educational_industrial_visit']?>" name="visit" id="visit" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right">Seminar training</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly"  onchange="total_fees()" value="<?=$academic_fee_details['seminar_training']?>" name="training" id="training" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right">Student activity</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly"  onchange="total_fees()" value="<?=$academic_fee_details['student_activity']?>" name="activity" id="activity" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right">Lab</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly"  onchange="total_fees()" value="<?=$academic_fee_details['lab']?>" name="lab" id="lab" />
					</div>
				  </div>
				  </div>
					
				<div id="2017" style="display:none;">
				  <div class="form-group">
					<label class="col-md-7 text-right ">Gymkhana</label>
								 <div class="col-md-4" >
								 <input type="text" class="form-control numbersOnly" onchange="total_fees()" value="<?=$academic_fee_details['Gymkhana']?>"  name="khana" id="khana" />
						   </div>
					  </div>  
				  <div class="form-group">
					<label class="col-md-7 text-right">Disaster Management</label>
					<div class="col-md-4">
					  <input type="text" class="form-control numbersOnly"  onchange="total_fees()" value="<?=$academic_fee_details['disaster_management']?>" name="mngmt" id="mngmt"  />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right">Computerization</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly"  value="<?=$academic_fee_details['computerization']?>" name="Computer" id="Computer"  />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right" id="regt">Registration</label>
					<div class="col-md-4" >
					<input type="text" class="form-control numbersOnly"   onchange="total_fees()" value="<?=$academic_fee_details['registration']?>" name="Regis" id="Regis" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right">Student Safety Insurance</label>
					<div class="col-md-4">
					  <input type="text" class="form-control numbersOnly"  onchange="total_fees()" value="<?=$academic_fee_details['student_safety_insurance']?>" name="Insur" id="Insur" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right">Library</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly"   onchange="total_fees()" value="<?=$academic_fee_details['library']?>" name="Libr" id="Libr" />
					</div>
				  </div>
				<div class="form-group">
					<label class="col-md-7 text-right">NSS</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly"  onchange="total_fees()" value="<?=$academic_fee_details['nss']?>" name="NSS" id="NSS"  />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7 text-right">Exam Fees</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly"  onchange="total_fees()" value="<?=$academic_fee_details['exam_fees']?>" name="exm_fees" id="exm_fees" />
					</div>
				  </div>
				  </div>
						<div class="form-group">
							<label class="col-md-7 text-right">Other Fees</label>
								 <div class="col-md-5" >
								 <input type="text" class="form-control numbersOnly" onchange="total_fees()" readonly name="other_fee" id="other_fee" value="0" />								   
							   </div>			 
						  </div> 
							  <div class="form-group">
                                <label class="col-md-7 text-right">Total Fees</label>
                                <div class="col-md-5" >
                                  <input type="text" class="form-control numbersOnly" name="Total" id="Total" value="" readonly/>
                                </div>
                              </div>
							  
						  </div>
							<div class="row">
							<div class="col-md-7" >
								<div class="form-group">
                                <div class="col-md-1"></div>
                                <div class=" col-md-4">
                                  <button type="submit" class="btn btn-primary form-control" >Update</button>
                                </div>
                                   <div class="col-sm-4"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/'">Cancel</button></div>
                 
                              </div>
							  </div>
							</div>
                        </form>
                      </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    
</div>


<script>


</script>
