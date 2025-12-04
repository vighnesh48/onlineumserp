<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<script>
var html_content="",type="",url="",datastring="";

function fullview_feedetails(fid)
{
	type='POST',url='<?= base_url() ?>Master_phd/fullview_feedetails',datastring={academic_fees_id:fid};
	html=ajaxcall(type,url,datastring);

	$('#err_msg').html('');
	var array=JSON.parse(html);
	var len=array.fees_details.length;
	$('#acadmic').html(array.fees_details.academic_year);
	$('#adms_year').html(array.fees_details.admission_year);
	$('#stream').html(array.fees_details.stream_short_name);
	$('#tut').html(array.fees_details.tution_fees);
	$('#develop').html(array.fees_details.development);
	$('#deposit').html(array.fees_details.caution_money);
	$('#adm_form').html(array.fees_details.admission_form);
	$('#aca_fee').html(array.fees_details.academic_fees);
	
	$('#gym').html(array.fees_details.Gymkhana);
	$('#reg').html(array.fees_details.registration);
	$('#insr').html(array.fees_details.student_safety_insurance);
	$('#lib').html(array.fees_details.library);
	
	
	$('#elg').html((array.fees_details.eligibility=='')?'0':array.fees_details.eligibility);
	$('#intr').html((array.fees_details.internet=='')?'0':array.fees_details.internet);
	$('#vist').html((array.fees_details.educational_industrial_visit=='')?'0':array.fees_details.educational_industrial_visit);
	$('#trn').html((array.fees_details.seminar_training=='')?'0':array.fees_details.seminar_training);
	$('#act').html((array.fees_details.student_activity=='')?'0':array.fees_details.student_activity);
	//alert(array.fees_details.admission_year);
	if(array.fees_details.admission_year>=2018)
	{//alert('2018'+array.fees_details.admission_year);
		$('#gymk').html('Sports & Ammenties :');
	$('#regt').html('Enrollment :');
		$('#ebl').show();
		$('#itr').show();
		$('#vst').show();
		$('#sem').show();
		$('#std').show();
		$('#ncc').hide();
		$('#mng').hide();
		$('#cmp').hide();
	}
	if(array.fees_details.admission_year<2018)
	{//alert('2017'+array.fees_details.admission_year);
		$('#ebl').hide();
		$('#itr').hide();
		$('#vst').hide();
		$('#sem').hide();
		$('#std').hide();
		$('#cmp').show();
		$('#mng').show();
		$('#ncc').show();
		$('#gymk').html('Gymkhana :');
	$('#regt').html('Registration :');
	}
	
	$('#diss').html((array.fees_details.disaster_management=='')?'0':array.fees_details.disaster_management);
	$('#comp').html((array.fees_details.computerization=='')?'0':array.fees_details.computerization);
	$('#ss').html((array.fees_details.nss=='')?'0':array.fees_details.nss);
	
	$('#emfee').html((array.fees_details.exam_fees=='')?'0':array.fees_details.exam_fees);
	$('#tot').html(array.fees_details.total_fees);
	$("#myModal1").modal();	

}

$(document).ready(function()
{
	var academic='<?=$_GET['academic']?>';
	
	//alert(campus);
	if(academic!="" && campus!="")
	{
		$('#academic option').each(function()
		 {              
			 if($(this).val()== academic)
			{
			$(this).attr('selected','selected');
			}
		});
		
		$("#btn_submit").trigger("click");
	}
	
	common_call();
		
	$('#academic').on('change', function () {
		common_call();
	});
	
	$('#admission_year').on('change', function () {
		common_call();
	});
});

function common_call()
{
	var academic=$('#academic').val();
	$('#header_year').html(academic);
	var admission_year=$('#admission_year').val();
	$('#err_msg').html('');
	type='POST',url='<?= base_url() ?>Master_phd/get_academic_fees_details',datastring={academic:academic,admission_year:admission_year};
	html_content=ajaxcall(type,url,datastring);
	//alert(html_content);
	if(html_content!="")
	{
		$('#err_msg').html('');
		$('#itemContainer').html(html_content);
		$('#show_list').show();
		$('#report').attr('href','<?=base_url()?>Master_phd/academic_fee_details_excelReports/'+academic);
		$('#excel').show();
	}
	else
	{
		$('#itemContainer').html('');
		$('#show_list').hide();
		$('#err_msg').html('No Data');
		$('#excel').hide();
	}
}


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
</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Fees Master </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Academic Fees Master</h1><span id="err_msg" style="color:red;"></span>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_academic_fees")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>

			<span id="flash-messages" style="color:Green;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>

		<div id="myModal1" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content" style="width:500px;">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<center><h4>Fee details</h4></center>
							  </div>
							  <div class="modal-body">
								
								<div class="panel-body">
									<div class="table-info">  
									<table class="table table-bordered">
									<tr><th scope="col">Stream :</th>
									  <td><span id="stream"></span></td>
									 </tr><tr>
									  <th scope="col">Academic Year :</th>
									  <td><span id="acadmic"></span></td>
									  
									</tr> 
									<tr>
									  
									  <th scope="col">Admission Year :</th>
									  <td><span id="adms_year"></span></td>
									</tr> 									
									<tr>
									  
									   <th scope="col">Tution Fees :</th>
									   <td><span id="tut"></span></td>
									</tr>
									
									<tr>
									  <th scope="col">Development Fees :</th>
									  <td><span id="develop"></span></td>
									  </tr>
									<tr>
									  <th scope="col">Academic fees :</th>
									  <td><span id="aca_fee"></span></td>
									  </tr> 
									<tr>
									  <th scope="col">Caution Money :</th>
									  <td><span id="deposit"></span></td>
									</tr>
									
									 <tr >
									  <th scope="col">Admission Form :</th>
									  <td><span id="adm_form"></span></td>
									  </tr>
									
									 <tr>
									  <th scope="col" ><span id="gymk">Gymkhana :</span></th>
									  <td><span id="gym"></span></td>
									  </tr>
									
									 <tr>
									  <th scope="col"><span id="regt">Registration :</span></th>
									  <td><span id="reg"></span></td>
									</tr>   
									<tr>
									  <th scope="col">Student Safety Insurance :</th>
									  <td><span id="insr"></span></td>
									  </tr> 
									  
									  <tr>
									   <th scope="col">Library Fees :</th>
									   <td><span id="lib"></span></td>
									</tr>
									<div >
									<tr id="mng" style="display:none;">
									  <th scope="col">Disaster Management  :</th>
									  <td><span id="diss"></span></td>
									  </tr> 
									  
									  <tr id="cmp" style="display:none;">
									  <th scope="col">Computerization :</th>
									  <td><span id="comp"></span></td>
									</tr>
									
									 <tr  id="ncc" style="display:none;">
									  <th scope="col">NSS :</th>
									  <td><span id="ss"></span></td>
									  </tr> 
									  
									<tr id="ebl" style="display:none;">
									  <th scope="col">Eligibility :</th>
									  <td><span id="elg"></span></td>
									  </tr> 
									  
									  <tr id="itr" style="display:none;">
									  <th scope="col">Internet :</th>
									  <td><span id="intr"></span></td>
									</tr>
									
									 <tr  id="vst" style="display:none;">
									  <th scope="col">Industrial visit :</th>
									  <td><span id="vist"></span></td>
									  </tr> 
									  
									  <tr id="sem" style="display:none;" >
									  <th scope="col">Seminar training :</th>
									  <td><span id="trn"></span></td>
									  </tr> 
									  
									  <tr  id="std" style="display:none;">
									  <th scope="col">Student activity :</th>
									  <td><span id="act"></span></td>
									  </tr> 
									  
									
									  <tr>
									  <th scope="col">Exam Fees :</th>
									  <td><span id="emfee"></span></td>
									  </tr> 
									  
									  <tr>
									  <th scope="col">Total Fees :</th>
									  <td><span id="tot"></span></td>
									</tr>
									
									  </table>
									</div>
								</div>

							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>

						  </div>
						</div>
		
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                    <div class="row">
						<div class="col-sm-4">
						<span class="panel-title"><h4>For Academic Year: <b><span id="header_year"></span></b></h4></span>
						</div>
						
						<div class="col-sm-2 pull-right">
						  <select class="form-control" name="admission_year" id="admission_year" required>
							  <option value="">select Admission Year</option>
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
						} else{
						?>
						<option value="<?=$academic['academic_year']?>"><?=$academic['academic_year']?></option>
						<?php
						} 
						
					}
				}
				?>
			</select>
			</div>
 
		<label class="col-md-2 pull-right">Admission Year:</label>
			<div class="col-sm-2  pull-right">
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
						} else{
						?>
						<option value="<?=$academic['academic_year']?>"><?=$academic['academic_year']?></option>
						<?php
						} 
						
					}
				}
				?>
			</select>
						</div>
						 					
				<label class="col-md-2 pull-right">Academic Year:</label>		
					</div>
					
					
                </div>
				
                <div id="show_list" class="panel-body" style="display:none;overflow-x:scroll;height:600px;">
                    <div class="table-info" style="">    
                    
                    <table class="table table-bordered" style="width:100%;max-width:100%;">
                        <thead>
						<tr>
                                    <th>#</th>
                                    <th>Stream&nbsp;Name</th>
									<th>Admission&nbsp;Year</th>
									<th>Year</th>
                                    <th>Batch</th>
                                    <th>Code</th>
									<th>Tution&nbsp;Fees</th>
                                    <th>Development</th>
									<th>Academic&nbsp;Fees</th>
									<th>Caution&nbsp;Money</th>
									<th>Admission&nbsp;Form</th>
									<th>Other&nbsp;Fees</th>
									<th>Exam&nbsp;Fees</th>
									<th>Total&nbsp;Fees</th>
									<!--<th>Scholorship Allowed</th>-->
									
									
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                                                      
                        </tbody>
                    </table>                    
                   
                </div>
                </div>
            </div>
			<div id="excel" style="display:none;">
			<a id="report"  target="_blank"><button class="btn btn-primary pull-right" style="margin-right: 30px">Export Excel</button></a>
			</div>
            </div>    
        </div>
    </div>
</div>