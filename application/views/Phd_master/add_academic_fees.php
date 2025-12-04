<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    

$(document).ready(function()
{$('#current_year').hide();
	 // Num check logic
  	$('.numbersOnly').keyup(function () {
		
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
	
	
	$('#yr').on('change', function () {
		var academic = $('#academic').val();
		var year = $("#year").val();
		var yr = $("#yr").val();
		if(academic=='') 
		{	$('#streamlist').html('');
			$('#emptab').hide();	
			$('#err_msg').html('Please select academic year');
		}
		else if(year=='')
		{	$('#streamlist').html('');
			$('#emptab').hide();
			$('#err_msg').html('Please select admission year');	
		}			
		else if(yr=='') 
		{	
			$('#streamlist').html('');
			$('#emptab').hide();
			$('#err_msg').html('Please select year');
		}
		else
		{
			type='POST',url='<?= base_url() ?>Phd_master/get_academic_stream_list',datastring={academic:academic,year:year,yr:yr};
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
		
	});
	
	var len=0;
	$('#year').on('change', function () {
		var academic = $('#academic').val();
		var year = $("#year").val();
		var yr=$("#year option:selected").text();
		if(academic) 
		{
			if(academic==yr)
				len=3;
			else
				len=4;
			
			var $select = $(".select").html('<option value="">select Year</option>');
			for (i=1;i<=len;i++){
				$select.append($('<option></option>').val(i).html(i))
			}
			
			if(academic==yr)
			{
				$('#2018').show();
				$('#2017').hide();
				//$('#current_year').show();
			}
			else
			{
				$('#2018').hide();
				$('#2017').show();
				$('#current_year').hide();
				type='POST',url='<?= base_url() ?>Phd_master/get_academic_stream_list',datastring={academic:academic,year:year};
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

function total_fees()
{
	var academic = $('#academic').val();
	var year = $("#year option:selected").text();
	var academic_fee=0;
	var other_fee=0;
	var total=0;
	
	if(year!=='') 
	{		
		if(year==academic)
		{
			academic_fee=parseInt($('#Tution').val())+parseInt($('#Development').val());
		$('#academic_fee').val(academic_fee);
		
			other_fee=parseInt($('#lab').val())+parseInt($('#Gymkhana').val())+parseInt($('#Registration').val())+parseInt($('#Insurance').val())+parseInt($('#Library').val())+parseInt($('#eligibility').val())+parseInt($('#internet').val())+parseInt($('#visit').val())+parseInt($('#training').val())+parseInt($('#activity').val())+parseInt($('#exam_fees').val());
			//+parseInt($('#caution_money').val())+parseInt($('#admission_form').val())
			$('#other_fee').val(other_fee);
		}
		else
		{
			academic_fee=parseInt($('#Tution').val())+parseInt($('#Development').val());
			$('#academic_fee').val(academic_fee);
		//+parseInt($('#caution_money').val())+parseInt($('#admission_form').val())
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
        <li><a href="#">Phd_masters</a></li>
        <!--<li class="active"><a href="<?=base_url($currentModule)?>">Fees Phd_master </a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-5 text-ctext-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Academic Fees </h1>
            
									
					<span id="flash-messages" style="color:Green;padding-left:10px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:10px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
                    
                
            
        </div>

        <div class="row ">
            <div class="col-sm-12">
                
				<form id="form" name="form" action="<?=base_url($currentModule.'/add_academic_fees_submit')?>" method="POST" onsubmit="return form_validate(event)">
			
				<div class="col-md-6" style="padding-right:0px;">
				<div class="panel panel-default">
				<div class="panel-heading">
					<span class="panel-title">Fee Details:</span>
				</div>
				<div class="panel-body">
				  <div class="form-group">
					<label class="col-md-7">Academic Year</label>
					<div class="col-md-5">
					  <select class="form-control" name="academic" id="academic" required>
						  <option value="">select Academic Year</option>
						<?php //echo "state".$state;exit();
				if(!empty($academic_details)){
					foreach($academic_details as $academic){
						/* $arr=explode("-",$academic['academic_year']);
						$ac_year=$arr[0]; */
						if($academic['status']=='Y')
						{
						?>
					  <option selected value="<?=$academic['academic_year']?>"><?=$academic['academic_year']?></option>  
					<?php 
						}/* else{
						?>
						<option value="<?=$academic['academic_year']?>"><?=$academic['academic_year']?></option> 
						<?php
						} */
						
					}
				}
				?>
			</select>
					</div>
					
				  </div>
				  
				   <div class="form-group">
					<label class="col-md-7">Admission Year</label>
					<div class="col-md-5">
					  <select class="form-control" name="year" id="year" required>
						  <option value="">select Admission Year</option>
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
                  
                  
					<div class="form-group" id="current_year">
                                <label class="col-md-7">Year</label>
                                <div class="col-md-5">
                                  <select class="select form-control" name="yr" id="yr" >
									<option value="">select Year</option>
									
								  </select>
                                </div>
                                
                              </div>
                              
                              <div class="form-group">
                                <label class="col-md-7">Batch</label>
                                <div class="col-md-5">
                                  <select class="form-control" name="Batch" id="Batch" >
									<option value="">select Cycle</option>
									<option value="JAN-18">JAN.-18</option>
                                    <option value="JULY-18">JULY.-18</option>
                                    <option value="JAN-19-1">JAN.-19(1)</option>
                                    <option value="JAN-19-2">JAN.-19(2)</option>
								  </select>
                                </div>
                                
                              </div>
					<div class="form-group">
					<label class="col-md-7 ">Tution Fees </label>
					<div class="col-md-4" >
						  <input type="text" class="form-control numbersOnly" onchange="total_fees()" value="0" required name="Tution" id="Tution" />	
					   </div>
				  </div>                                      
					<div class="form-group">
					<label class="col-md-7 ">Development</label>
								 <div class="col-md-4" >
						 <input type="text" class="form-control numbersOnly" onchange="total_fees()" value="0" required name="Development" id="Development" />
				   </div>
					  </div>
					   <div class="form-group">
					<label class="col-md-7 ">Academic Fees</label>
								 <div class="col-md-4" >
								 <input type="text" class="form-control numbersOnly" onchange="total_fees()" readonly name="academic_fee" id="academic_fee" value="0"/>								   
							   </div>			 
						  </div>
					  <div class="form-group">
							<label class="col-md-7 ">Caution Money</label>
										 <div class="col-md-4" >
								 <input type="text" class="form-control numbersOnly" onchange="total_fees()" value="0" required name="caution_money" id="caution_money" />
						   </div>
					  </div>
					  <div class="form-group">
							<label class="col-md-7 ">Admission Form</label>
										 <div class="col-md-4" >
								 <input type="text" class="form-control numbersOnly" onchange="total_fees()" value="0" required name="admission_form" id="admission_form" />
						   </div>
					  </div>								
					  
				  
				  <div id="2018" style="display:none;">
				  <div class="form-group">
					<label class="col-md-7">Exam Fees</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" required onchange="total_fees()" value="0" name="exam_fees" id="exam_fees" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7">Student Safety Insurance</label>
					<div class="col-md-4">
					  <input type="text" class="form-control numbersOnly" required onchange="total_fees()" value="0" name="Insurance" id="Insurance" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7" id="regt">Enrollment</label>
					<div class="col-md-4" >
					<input type="text" class="form-control numbersOnly" required  onchange="total_fees()" value="0" name="Registration" id="Registration" />
					</div>
				  </div>
				   <div class="form-group">
					<label class="col-md-7 " id="gym">Sports & Ammenties</label>
								 <div class="col-md-4" >
								 <input type="text" class="form-control numbersOnly" onchange="total_fees()" value="0" required name="Gymkhana" id="Gymkhana" />
						   </div>
					  </div> 
				  <div class="form-group">
					<label class="col-md-7">Eligibility</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" required onchange="total_fees()" value="0" name="eligibility" id="eligibility" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7">Library</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" required  onchange="total_fees()" value="0" name="Library" id="Library" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7">Internet</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" required onchange="total_fees()" value="0" name="internet" id="internet" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7">Industrial visit</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" required onchange="total_fees()" value="0" name="visit" id="visit" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7">Seminar training</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" required onchange="total_fees()" value="0" name="training" id="training" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7">Student activity</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" required onchange="total_fees()" value="0" name="activity" id="activity" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7">Lab</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" required onchange="total_fees()" value="0" name="lab" id="lab" />
					</div>
				  </div>
				  </div>
				  <div id="2017" style="display:none;">
				  <div class="form-group">
					<label class="col-md-7 ">Gymkhana</label>
								 <div class="col-md-4" >
								 <input type="text" class="form-control numbersOnly" onchange="total_fees()" value="0" required name="khana" id="khana" />
						   </div>
					  </div>  
				  <div class="form-group">
					<label class="col-md-7">Disaster Management</label>
					<div class="col-md-4">
					  <input type="text" class="form-control numbersOnly" required onchange="total_fees()" value="0" name="mngmt" id="mngmt" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7">Computerization</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" required value="0" name="Computer" id="Computer" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7" id="regt">Registration</label>
					<div class="col-md-4" >
					<input type="text" class="form-control numbersOnly" required  onchange="total_fees()" value="0" name="Regis" id="Regis" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7">Student Safety Insurance</label>
					<div class="col-md-4">
					  <input type="text" class="form-control numbersOnly" required onchange="total_fees()" value="0" name="Insur" id="Insur" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7">Library</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" required  onchange="total_fees()" value="0" name="Libr" id="Libr" />
					</div>
				  </div>
						<div class="form-group">
					<label class="col-md-7">NSS</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" required onchange="total_fees()" value="0" name="NSS" id="NSS" />
					</div>
				  </div>
				  <div class="form-group">
					<label class="col-md-7">Exam Fees</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" required onchange="total_fees()" value="0" name="exm_fees" id="exm_fees" />
					</div>
				  </div>
				  </div>
				  
				  
				  
				   <div class="form-group">
					<label class="col-md-7 ">Other Fees</label>
								 <div class="col-md-4" >
								 <input type="text" class="form-control numbersOnly" onchange="total_fees()" readonly name="other_fee" id="other_fee" value="0" />								   
							   </div>			 
						  </div> 
				  <div class="form-group">
					<label class="col-md-7">Total Fees</label>
					<div class="col-md-4" >
					  <input type="text" class="form-control numbersOnly" name="Total" id="Total" value="0" readonly/>
					</div>
				  </div>
				 <!-- <div class="form-group">
					<label class="col-md-7">Scholorship Allowed</label>
					<div class="col-md-4" >
					  <select class="form-control" name="Scholorship" id="Scholorship" required>
						  <option value="">select Scholorship Allowed</option>
						   <option value="Y">Yes</option>
						   <option value="N">No</option>
					  </select>
					</div>
				  </div>-->
				  <div class="form-group">
					<div class="col-md-3"></div>
					<div class=" col-md-4">
					  <button type="submit" class="btn btn-primary form-control" >Save</button>
					</div>
					   <div class="col-sm-4"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/'">Cancel</button></div>
	 
				  </div>
				  </div>
				</div>
			 </div> 
			

						
                        <div class="col-md-6" id="emptab"  style=" display:none;padding-right:0px;"> 
						<div class="panel panel-default">
							<div class="panel-heading">
								<span class="panel-title">Stream List:</span>
							</div>
							<div class="panel-body" style="overflow-x:scroll; height:900px;">
				
							 <table id='myTable' class="table table-bordered" >
								<thead>
								<tr>
									<th>#</th>
									<th>Stream Name</th>
									<!--<th>Year</th>-->
								</tr>
								</thead>
								<tbody id="streamlist">
															  
								</tbody>
							</table>  
							
						</div>
						</div>
						
						</div>
						<span id="err_msg" style="color:red;padding-left:10px;"></span>
                      </div>
					  
					</form>  
                    </div>
					<div class="col-md-3"></div>
					<span id="err_msg1" style="color:red;padding-left:10px;"></span>
                </div>
            </div>

