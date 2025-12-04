<style>
.loader {
  border: 6px;
  border-radius: 50%;
  border-top: 6px solid pink;
  border-bottom: 6px solid pink;
  width: 100px;
  height: 200px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

.hostel-bg {
	background: #ddd;
	margin: 10px auto;
	width: 100%;
	height: 149px;
}
.hostel-bg ul li {
	border-radius: 3px;
	color: #fff;
	text-align: center;
	padding: 5px;
	width: 30px;
	height: 45px;
	outline: 1px solid #fff;
	outline-offset: -4px;
	margin: 4px 12px 4px 4px;
}
.green-bed {
	background: #2fac1e;
}
.orange-bed {
	background: #ff8a00;
}
.blue-bed {
	background: #00aeef;
}
.grey-bed {
	background: #b6b3b3;
}
.green-icon {
	color: #2fac1e;
}
.orange-icon {
	color: #ff8a00;
}
.blue-icon {
	color: #00aeef;
}
.grey-icon {
	color: #b6b3b3;
}
.hostel-bg ul {
	padding: 5px;
}
.hostel-bg .list-inline {
	margin-left: 0px;
}
.hostel-bg ul li > p {
	border: 1px solid #fff;
	height: 6px;
	border-radius: 2px;
	width: 80%;
	margin: 2px auto;
}
.no-padd {
	padding: 0px
}
.color-icon {
	padding-top:0px;
}
.color-icon li {
	font-size: 11px;
	padding-bottom: 5px;
}
.color-icon .fa {
	margin-right: 7px
}
.seatR {
	text-align: center;
	padding: 0 5px;
	font-size: 14px;
	color: #fff;
	width: 30px;
	transform: rotate(-90deg);
}
.seatI {
	margin: 1px;
	float: left;
	width: 18px;
}
.seatI a {
	border: 1px solid #a7a7a7;
	display: inline-block;
	width: 18px;
	height: 18px;
	border-radius: 26%;
	color: #666;
	text-align: center;
	font-size: 11px;
}
.rooms-div {
	border: 1px solid #3c3e4999;
	margin: 5px 6px;
	padding: 0px;
	min-height: 100px;
}
.rooms-div .room-n {
	margin: 0 0 5px 0;
	background: #3c3e4999;
	border-radius: 0%;
	color: #fff;
	text-align: center;
	font-size: 10px;
	padding: 1px;
}
.rooms-div .room-n a{color: #fff;}
.seatI >.orange-bed, .seatI >.blue-bed, .seatI >.green-bed, .seatI >.grey-bed {
	color: #fff;
}
.notifications-list table tbody tr {
	background: #fafafa;
}
td {
	xsvertical-align: middle
}
.popover {
	max-width: 500px!important;
}

.popover.right > .arrow{top:34%!important;display:none}
.popover.right {
	margin-left: 15px;
	z-index: 99999;
}
.popover-content {
	padding: 0;
}
.list-group-item {
	padding-bottom: 5px;
	padding-top: 5px;
	font-size: 12px;
	line-height: 12px;
}
.notification table {
	border: 1px solid #88898f;border-collapse: initial;
}
.notation {
	padding: 0;
	margin-top: 8px;
}
.notation .panel-heading {
	padding-left: 10px;padding-top:3px;padding-bottom:0;
}
.notation .panel-body {
	padding:0px;
}
.notation .list-group-item{padding-bottom:13px;padding-top:7px;}
.notation .list-group{margin-bottom:0px}
.padd-left{padding-left:15px;}


</style>
<script>

$(document).ready(function()
{
	$('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker42').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
});


var enroll='<?=str_replace("/","_",$student_details['enrollment_no'])?>',sf_id='<?=$student_details['sf_id']?>',org='<?=$student_details['org']?>',stud_id='<?=$student_details['student_id']?>',g_ac_year='<?=$student_details['academic_year']?>';
//alert(enroll);
var sffm_id='';
function get_student_details(f_alloc_id,sf_room_id,academic,student_id,enrollment_no)
{
	$('#btn_submit').hide();
	$('#vf').hide();
	$('#vt').hide();
	$('#paid_amt').html('');
	//alert(f_alloc_id);
	if(f_alloc_id==null)
	{	
		$('#btn_submit').show();
		$('#vf').show();
		$('#vt').show();
	}
	
	if(enroll==''||org==''||stud_id=='')
	{
	   // alert("hi");
	    
	    //alert(f_alloc_id+'=='+student_id+'=='+enrollment_no+'=='+academic);
		if(f_alloc_id!=null)
		{
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/get_stddetails',
				data: {f_alloc_id:f_alloc_id,student_id : student_id,
				enroll:enrollment_no,academic:academic},
				success: function (html) {
					//alert(html);
					var array=JSON.parse(html);
					len=array.length;
					
					if(array.std_fee_details.organization=='SU')
					{
						var imurl ='<img src="<?=base_url('uploads/student_photo')?>/'+enrollment_no+'.jpg" alt="" width="80" height="80">';
					}
					else
					{
					    	var imurl ='<img src="<?=base_url('assets/images')?>/nopic.jpg" alt="" width="80" height="80">';
					}
						 
//alert("first_name=="+array.std_fee_details.first_name+"actual_fees=="+array.std_fee_details.actual_fees+"deposit_fees=="+array.std_fee_details.deposit_fees);


					$('#acadmic').html(academic);
					$('#academic').html(array.std_fee_details.academic_year);
					$('#prn').html(enrollment_no);
					$('#std_name').html(array.std_fee_details.first_name+' '+array.std_fee_details.middle_name+' '+array.std_fee_details.last_name);
					$('#organisation').html(array.std_fee_details.organization);
					$('#institue').html(array.std_fee_details.instute_name);
					$('#course').html(array.std_fee_details.stream_short_name);
					$('#year').html(array.std_fee_details.current_year);
					$('#pphoto').html(imurl);
					$('#fee').html(array.std_fee_details.mobile);
					$('#deposit').html(array.std_fee_details.parent_mobile1);
					$('#excemption').html(array.std_fee_details.parent_mobile2);
					$('#paid_amt').html(array.std_fee_details.paid_amt);
					$('#hostelcode').html(array.std_fee_details.hostel_code);
					$('#hostel_name').html(array.std_fee_details.hostel_name);
					if(array.std_fee_details.floor_no==0)
						{check_floor='Ground';}
					else
						{check_floor=array.std_fee_details.floor_no;}
					$('#floor_no').html(check_floor);
					
					//$('#floor_no').html(array.std_fee_details.floor_no);
					$('#room_no').html(array.std_fee_details.room_no);
					sffm_id=array.std_fee_details.cat_id;
					$('#div1').show();$('#div2').show();
					$.ajax({
								type: 'POST',
								url: '<?= base_url() ?>Hostel/fetch_std_hostel_fee_details',
								data: {enrollment_no:enrollment_no,sffm_id:sffm_id,academic_year:academic},
								success: function (html) 
								{
									//alert(html);
									if(html!='')
									$('#fee_details').html(html);
								else
									$('#fee_details').html("<tr><td>"+array.std_fee_details.academic_year+"</td><td>"+array.std_fee_details.actual_fees+"</td><td>"+array.std_fee_details.deposit_fees+"</td><td>"+(parseInt(array.std_fee_details.deposit_fees)+parseInt(array.std_fee_details.actual_fees))+"</td><td>"+array.std_fee_details.gym_fees+"</td><td>"+array.std_fee_details.fine_fees+"</td><td>"+array.std_fee_details.opening_balance+"</td><td>"+array.std_fee_details.excemption_fees+"</td><td>0</td><td>"+(parseInt(array.std_fee_details.deposit_fees)+parseInt(array.std_fee_details.actual_fees))+"</td><td>"+array.std_fee_details.hostel_code+"</td></tr>");
								}
							});
				}
				
			});
			
			$("#myModal1").modal();
		}
	}
	else
	{
		if(f_alloc_id!=null)
		{
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/get_stddetails',
				data: {f_alloc_id:f_alloc_id,student_id : student_id,
				enroll:enrollment_no,academic:academic},
				success: function (html) {
					//alert(html);
					var array=JSON.parse(html);
					len=array.length;
					
					if(array.std_fee_details.organization=='SU')
					{
						var imurl ='<img src="<?=base_url('uploads/student_photo')?>/'+enrollment_no+'.jpg" alt="" width="80" height="80">';
					}
					else
					{
					    	var imurl ='<img src="<?=base_url('assets/images')?>/nopic.jpg" alt="" width="80" height="80">';
					}
						 
//alert("first_name=="+array.std_fee_details.first_name+"actual_fees=="+array.std_fee_details.actual_fees+"deposit_fees=="+array.std_fee_details.deposit_fees);


					$('#acadmic').html(array.std_fee_details.academic_year);
					$('#academic').html(array.std_fee_details.academic_year);
					$('#prn').html(enrollment_no);
					$('#std_name').html(array.std_fee_details.first_name+' '+array.std_fee_details.middle_name+' '+array.std_fee_details.last_name);
					$('#organisation').html(array.std_fee_details.organization);
					$('#institue').html(array.std_fee_details.instute_name);
					$('#course').html(array.std_fee_details.stream_short_name);
					$('#year').html(array.std_fee_details.current_year);
					$('#pphoto').html(imurl);
					$('#fee').html(array.std_fee_details.mobile);
					$('#deposit').html(array.std_fee_details.parent_mobile1);
					$('#excemption').html(array.std_fee_details.parent_mobile2);
					$('#paid_amt').html(array.std_fee_details.paid_amt);
					$('#hostelcode').html(array.std_fee_details.hostel_code);
					$('#hostel_name').html(array.std_fee_details.hostel_name);
					if(array.std_fee_details.floor_no==0)
							{check_floor='Ground';}
						else
							{check_floor=array.std_fee_details.floor_no;}
					$('#floor_no').html(check_floor);
					$('#room_no').html(array.std_fee_details.room_no);
					sffm_id=array.std_fee_details.cat_id;
					$('#div1').show();$('#div2').show();
					$.ajax({
								type: 'POST',
								url: '<?= base_url() ?>Hostel/fetch_std_hostel_fee_details',
								data: {enrollment_no:enrollment_no,sffm_id:sffm_id,academic_year:academic},
								success: function (html) 
								{
									//alert(html);
									if(html!='')
									$('#fee_details').html(html);
								else
									$('#fee_details').html("<tr><td>"+array.std_fee_details.academic_year+"</td><td>"+array.std_fee_details.actual_fees+"</td><td>"+array.std_fee_details.deposit_fees+"</td><td>"+(parseInt(array.std_fee_details.deposit_fees)+parseInt(array.std_fee_details.actual_fees))+"</td><td>"+array.std_fee_details.gym_fees+"</td><td>"+array.std_fee_details.fine_fees+"</td><td>"+array.std_fee_details.opening_balance+"</td><td>"+array.std_fee_details.excemption_fees+"</td><td>0</td><td>"+(parseInt(array.std_fee_details.deposit_fees)+parseInt(array.std_fee_details.actual_fees))+"</td><td>"+array.std_fee_details.hostel_code+"</td></tr>");
								}
							});
				}
				
			});
			
			
			$("#myModal1").modal();
		}
		else
		{
		  //  alert("test");
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/get_details',
				data: { enroll:enroll,sf_id : sf_id,org:org,stud_id:stud_id,academic_year:g_ac_year},
				success: function (html) {
				if(html=="{\"std_faci_details\":null}")
				{
					alert('Invalid Student PRN');
				}
				else
				{
					//alert(html);
					var array=JSON.parse(html);
					len=array.length;
					$('#sf_room_id').val(sf_room_id);
					$('#sf_id').val(sf_id);
					$('#std_id').val(array.std_faci_details.student_id);
					$('#enroll').val(enroll);
					//$('#academic').html(array.std_faci_details.academic_year);
					var hostelid = $('#host_id').val();
					var hid=hostelid.split('||');
					$('#h_id').val(hid[0]);
					$('#acadmic').html(g_ac_year);
					$('#academic').val(g_ac_year);
					
				//	$('#std_name').html(array.std_faci_details.first_name+' '+array.std_fee_details.middle_name+' '+array.std_fee_details.last_name);
				//	$('#organisation').html(array.std_faci_details.organization);
				//	$('#institue').html(array.std_faci_details.instute_name);
					if(array.std_faci_details.organization=='SU')
						{
							var imurl ='<img src="<?=base_url('uploads/student_photo')?>/'+enroll+'.jpg" alt="" width="80" height="80">';
						}
						else
						{
								var imurl ='<img src="<?=base_url('assets/images')?>/nopic.jpg" alt="" width="80" height="80">';
						}
					
					//deposit_fees,academic_year,actual_fees,gym_fees,fine_fees,opening_balance,excemption_fees,cancelled_facility
					
										
					//$('#acadmic').html(array.std_faci_details.academic_year);
					$('#prn').html(enroll);
					$('#std_name').html(array.std_faci_details.first_name+' '+array.std_faci_details.middle_name+' '+array.std_faci_details.last_name);
					$('#organisation').html(array.std_faci_details.organization);
					$('#institue').html(array.std_faci_details.instute_name);
					$('#course').html(array.std_faci_details.stream_short_name);
					$('#year').html(array.std_faci_details.current_year);
					$('#pphoto').html(imurl);


					$('#fee').html(array.std_faci_details.mobile);
					$('#deposit').html(array.std_faci_details.parent_mobile1);
					$('#excemption').html(array.std_faci_details.parent_mobile2);
					$('#paid_amt').html(array.std_faci_details.paid_amt);
					$('#div1').hide();$('#div2').hide();
					
					sffm_id=array.std_faci_details.cat_id;
					$.ajax({
								type: 'POST',
								url: '<?= base_url() ?>Hostel/fetch_std_hostel_fee_details',
								data: {enrollment_no:enroll,sffm_id:sffm_id,academic_year:g_ac_year},
								success: function (html) 
								{
									//alert(html);
									if(html!='')
									$('#fee_details').html(html);
								else
									$('#fee_details').html("<tr><td>"+array.std_faci_details.academic_year+"</td><td>"+array.std_faci_details.actual_fees+"</td><td>"+array.std_faci_details.deposit_fees+"</td><td>"+(parseInt(array.std_faci_details.deposit_fees)+parseInt(array.std_faci_details.actual_fees))+"</td><td>"+array.std_faci_details.gym_fees+"</td><td>"+array.std_faci_details.fine_fees+"</td><td>"+array.std_faci_details.opening_balance+"</td><td>"+array.std_faci_details.excemption_fees+"</td><td>0</td><td>"+(parseInt(array.std_faci_details.deposit_fees)+parseInt(array.std_faci_details.actual_fees))+"</td><td>"+array.std_fee_details.hostel_code+"</td></tr>");
								}
							});
						$("#myModal1").modal();
					}
				}
			});		
		}
	}
	
}

function load_hostel()
{
	var campus = $('#campus').val();
	type='POST',url='<?= base_url() ?>Hostel/get_hostel_details',datastring={campus:campus};
	html_content=ajaxcall(type,url,datastring);
	if(html_content === "{\"hostel_details\":[]}")
	{
		$('#host_id').html('No Hostel');
	}
	else
	{
		var array=JSON.parse(html_content);
		len=array.hostel_details.length;
		//alert(len+"==="+html);
		content='<option value="">Select Hostel</option>';
		var j=1;
		for(i=0;i<len;i++)
		{
			content+='<option value="'+array.hostel_details[i].host_id+'||'+array.hostel_details[i].hostel_code+'||'+array.hostel_details[i].no_of_floors+'">'+array.hostel_details[i].Area+'-'+array.hostel_details[i].hostel_code+'</option>';
		}

		$('#host_id').html(content);
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
/* 
function common_call()
{
	var bus=$('#bus').val();
	route=$('#route').val();
	if(bus!='' && route!='')
	{
		$('#err_msg1').html('');
		datastring={bus:bus,route:route};
		html_content=ajaxcall(type,url,datastring);
		display_content(html_content);
	}
} */
</script>


<!-- 1. $BODY ======================================================================================
	
	Body

	Classes:
	* 'theme-{THEME NAME}'
	* 'right-to-left'      - Sets text direction to right-to-left
	* 'main-menu-right'    - Places the main menu on the right side
	* 'no-main-menu'       - Hides the main menu
	* 'main-navbar-fixed'  - Fixes the main navigation
	* 'main-menu-fixed'    - Fixes the main menu
	* 'main-menu-animated' - Animate main menu
-->



<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>"> Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
		<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Hostel View</h1>
            <div class="col-xs-12 col-sm-8">
                <span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
				<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
            </div>
		</div>
		<div class="row">
		  <div class="panel widget-notifications">
			<div class="panel-heading">
			  <div class="row">
				<input type="hidden" id="hostel_id" name="hostel_id" />
				<input type="hidden" id="hostel_code" name="hostel_code" /> 
				<input type="hidden" id="nooffloor" name="nooffloor" />
				<div class="col-sm-2">
				  <select class="form-control" name="academic_y" id="academic_y" required>
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
				<?php
				$exp = explode("_",$_SESSION['name']);
		     if($exp[1]!="sijoul" || $exp[1]!="nashik")
			 {
				 ?>
				<div class="col-sm-2">
				<select id="campus" name="campus" class="form-control" required>
						  <option value="">Select Campus</option>
						  <option value="All">All</option>
						  <option value="NASHIK">Nashik</option>
						  <option value="SIJOUL">Sijoul</option>
				</select>  
				</div>
			 <? } ?>
				<div class="col-sm-2">
					<select class="form-control" name="host_id" id="host_id" required>
					  <option value="">Select Hostel</option>
					  <?php //echo "state".$state;exit();
						if(!empty($hostel_details)){
							foreach($hostel_details as $hostels){
								?>
							  <option value="<?=$hostels['host_id']?>||<?=$hostels['hostel_code']?>||<?=$hostels['no_of_floors']?>"><?=$hostels['Area'].'-'.$hostels['hostel_code']?></option>  
							<?php 
								
							}
						}
					  ?>
				  </select>
						 
				</div>
				<div class="col-sm-2">
					<select class="floor form-control" name="floor" id="floor" >
					  <option value=""> Select Floor</option>
				  </select>
					 
				</div>
				<!--<div class="col-sm-2">
				<button class="btn btn-primary form-control" onclick="get_hostel_details()" id="btn_submit1" >Submit</button>
				</div>-->
				<div class="col-sm-4">
				<span style="color:red;" id="err_msg"></span>
				</div>
			  </div>
			</div>
			<!-- / .panel-heading -->
			<div class="panel-body padding-sm">
			  <div class="col-md-10" style="padding-left:0;">
			  <center><div id="loader1"></div> </center>
				<div class="notifications-list" id="maincontent" style="display:none;">
				  <div id="content">
				  </div>
				</div>
			  </div>
			
			  <div class="col-md-2 notation">
			  
			  <div class="panel panel-danger panel-dark">
				  <div class="panel-heading"> <span class="panel-title">Status</span> </div>
				  <div class="panel-body">
				  
					<ul class="list-group">
					  <li class="list-group-item"> <span class="badge badge-success" id="cnt_in"></span>Student In</li>
					  <li class="list-group-item"> <span class="badge badge-warning" id="cnt_home"></span> Student Out[Home] </li>
					  <li class="list-group-item"> <span class="badge badge-warning" id="cnt_city"></span>Student Out[City]</li>
					  <li class="list-group-item"> <span class="badge badge-basic" id="cnt_free"></span> Available </li>
					  <li class="list-group-item"> <span class="badge badge-primary" id="cnt_gh"></span> Guest House </li>
					   <li class="list-group-item"> <span class="badge badge-danger" id="cnt_tot"></span> Total Beds </li>
					   <li class="list-group-item"> <span class="badge badge-danger" id="cnt_room"></span> Total Room </li>
					</ul>
				  </div>
				</div>
				
				<div class="panel panel-danger panel-dark">
				  <div class="panel-heading"> <span class="panel-title">Notation</span> </div>
				  <div class="panel-body">
				  
				  
					<ul class="list-unstyled color-icon list-group">
					   <li class="list-group-item">Student In <i class="fa fa-square green-icon pull-right" aria-hidden="true"></i> </li>
					   <li class="list-group-item">Available <i class="fa fa-square grey-icon pull-right" aria-hidden="true"></i> </li>
					   <li class="list-group-item">Guest House <i class="fa fa-square blue-icon pull-right" aria-hidden="true"></i> </li>
					   <li class="list-group-item">Student Out <i class="fa fa-square orange-icon pull-right" aria-hidden="true"></i> </li>
					</ul>
				  </div>
				</div>
								
				<div class="panel panel-danger panel-dark">
				  <div class="panel-heading"> <span class="panel-title">Institute</span> </div>
				  <div class="panel-body">
					<ul class="list-group">
					  <li class="list-group-item"> <span class="badge badge-primary">5</span> SIEM</li>
					  <li class="list-group-item"> <span class="badge badge-info">14</span> SITRC </li>
					  <li class="list-group-item"> <span class="badge badge-danger">11</span> SIP </li>
					</ul>
				  </div>
				</div>
			  </div>
			  <div id="get_info"></div>
			</div>  
			</div>
			<!-- / .panel-body --> 
		  </div>
	</div>
	
</div>	


<!-- Modal -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content" style="width:800px;">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<center><h4>Academic Year :&nbsp;
						<span id="acadmic" name="acadmic"></span></h4></center>
	  </div>
	  <div class="modal-body">
		
		
		<div class="panel panel-success">
			<div class="panel-heading">
					<span class="panel-title pull-left" >Name : &nbsp;</span>
					<span id="std_name" name="std_name"></span>
					<span class="panel-title pull-right" >PRN : &nbsp;<span id="prn" name="prn"></span></span>
					
			</div>

 
			<div class="panel-body">
				<div class="table-info">  
				<form name="form" id="form" action="<?=base_url($currentModule.'/facility_allocate_submit')?>" method="POST">
				<input type="hidden" id="h_id" name="h_id" />
				<input type="hidden" id="sf_id" name="sf_id" />
				
				<input type="hidden" id="sf_room_id" name="sf_room_id" /> 
				<input type="hidden" id="std_id" name="std_id" />
				<input type="hidden" id="enroll" name="enroll" /> 
				<input type="hidden" id="academic" name="academic" /> 
					<div class="row">
							<div class="col-sm-10">
				<table class="table table-bordered">
				 <tr>
				  <th scope="col">Course:</th>
				  <td><span id="course"></span></td>
				  <th scope="col">Current Year:</th>
				  <td><span id="year"></span></td>
				</tr>   
				<tr>
				  <th scope="col">Organisation:</th>
				  <td><span id="organisation"></span></td>
				   <th scope="col">Institute:</th>
				   <td><span id="institue"></span></td>
				</tr>
				
				
				
				<tr>
				  <th scope="col">Student Mobile:</th>
				  <td><span id="fee"></span></td>
				  <th scope="col">Parent Mobile:</th>
				  <td><span id="deposit"></span><span id="excemption" style="display:none;"></span></td>
				</tr>
				
				 <tr id="div1">
				  <th scope="col">Hostel Details:</th>
				  <td><span id="hostelcode"></span> / <span id="floor_no"></span> / <span id="room_no"></span></td>
				  </tr> 
				
				</table>
				
				
				</div>
					<div class="col-sm-2"><span id="pphoto">
				
					 </span>
					 </div>  

						
				</div>
				
				<table class="table table-bordered">
					<th>Academic</th>
					<th>Fee</th>
					<th>Deposit</th>
					<th>Applicable</th>
					<th>Gym fee</th>
					<th>Fine_fee</th>
					<th>Opening balance</th>
					<th>Exemption fee</th>
					<th>Amount Paid</th>
					<th>Remaining</th>
					
																
					
					<tbody id="fee_details"></tbody>
				</table>
				</div>
				
				<div class="col-sm-3">
					<button class="btn btn-primary form-control" type="submit" id="btn_submit" style="display:none;">Allocate</button>                                        
				</div>
				
				</form>
			</div>
		</div>
		
		
		
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  </div>
	</div>

  </div>
</div>
<script src="<?=base_url()?>assets/javascripts/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/javascripts/pixel-admin.min.js"></script>
<script>
$(document).ready(function()
{
	var id='<?=$this->uri->segment(3)?>';
	var acyear='<?=$this->uri->segment(7)?>';
	if(acyear!='')
	{
		$('#academic_y').html('<option value="">Academic year</option><option selected value="'+acyear+'">'+acyear+'</option>');
	}
	
	var temp=[];
	if(id!="")
	{
		$('#host_id option').each(function()
		 {      
			temp=($(this).val()).split('||');
			 if(temp[0]== id)
			{
				$(this).attr('selected','selected');
								
				tot_flr = temp[2];
				//$('#nooffloor').val(tot_flr);
				var input_data='<option value="">Floor</option>';
				for (i=0;i<=tot_flr;i++)
				{
					if(i==0)
					input_data+='<option value="'+i+'">G</option>';
					else
					input_data+='<option value="'+i+'"> '+i+'</option>';
				}
				$('#floor').html(input_data);
			}
		});
		
		//$("#btn_submit1").trigger("click");
		get_hostel_details();
	}
	
	$('#academic_y').change(function() {
		get_hostel_details();
	});
	
	$('#host_id').change(function() {
		get_hostel_details();
	});
	
	$('#campus').change(function() {
		load_hostel();
		get_hostel_details();
	});
	
	$('#floor').change(function() {
		get_hostel_details();
	});
  	
});

var host_id ="",floor ="",tot_flr="",len="";
var arr_room=[];

$(document).ready(function(){
	
// get no of floor by host_id
	$('#host_id').on('change', function () {
		var h_id = $(this).val();
		if (h_id) 
		{
			var hostel_data=h_id.split("||");
			 host_id = hostel_data[0];
			var hostel_code = hostel_data[1];
			$('#hostel_id').val(host_id);
			$('#hostel_code').val(hostel_code);
			//$('#hst_id').val(host_id);
			//$('#host_code').val(hostel_code);
			
			tot_flr = hostel_data[2];
			//$('#nooffloor').val(tot_flr);
			var input_data='<option value="">Floor</option>';
			for (i=0;i<=tot_flr;i++)
			{
				if(i==0)
				input_data+='<option value="'+i+'">G</option>';
				else
				input_data+='<option value="'+i+'"> '+i+'</option>';
			}
			$('#floor').html(input_data);
		} 
		else 
		{
			//$('#rms_bds_dtls').hide();
			//$('#r_div').hide();
			$('#floor').html('<option value="">First Select Hostel</option>');
			$('#maincontent').hide();
		}
	});
});

function get_hostel_details()
{
	var hostelid = $('#host_id').val();
	var floorno = $('#floor').val();
	var academic_y = $('#academic_y').val();
	if (academic_y == "")
	{
		$('#err_msg').html('Please select academic year!!');
		$('#maincontent').hide();
		return false;
	}
	else if (hostelid == "")
	{
		$('#err_msg').html('Please select Hostel!!');
		$('#maincontent').hide();
		return false;
	}
	else
	{	
		var hid=hostelid.split('||');
		var content='';
		$('#err_msg').html('');
		$("#loader1").html('<div class="loader"></div>');
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Hostel/fetch_alloted_details1',
			data: { host_id: hid[0], floors : floorno,academic_y:academic_y},
			success: function (html) {
				//alert(html);
				//$('#err_msg').html(html);
				if(html!='<span style=\"color:red;\">Hostel Not Found Please change search criteria and try again</span>')
				{
					$('#content').html(html);
					/* $('#cnt_in').html(cnt_in);
					$('#cnt_home').html(cnt_home);
					$('#cnt_city').html(cnt_city);
					$('#cnt_free').html(cnt_free);
					$('#cnt_gh').html(cnt_gh); */

					$('#maincontent').show();
				}
				else
				{
					$('#content').html(html);
					$('#maincontent').hide();
				}
				$("#loader1").html("");	
			}
		});
		
	}
}
/* function get_info(id)
{
	var arr=id.split("_");
	//alert(arr[0]+'='+arr[1]+'='+arr[2]+'='+arr[3]+'='+arr[4]);
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Hostel/get_info',
			data: { host_id: arr[2], floors : arr[1],room:arr[3],academic_y:arr[4]},
			success: function (html) {
				var array=JSON.parse(html);
				len=array.get_info.length;
				info='<div id="popover-content-pop_'+arr[1]+'_'+arr[2]+'_'+arr[3]+'_'+arr[4]+'" class="hide popover-list test"><ul class="list-group">';
				for(i=0;i<len;i++)
				{
					//alert(array.get_info[i].first_name);
					info+='<li class="list-group-item"><div class="row"><div class="col-sm-3"><img src="assets/demo/avatars/2.jpg" width="40" height="40" class="img-circle"></div><div class="col-sm-9"><strong>'+array.get_info[i].first_name+'</strong> <br><small>'+array.get_info[i].stream+' '+array.get_info[i].current_year+'<br>'+array.get_info[i].instute_name+'</small></div></div></li>';
				}
				info+='</ul></div>';
				$('#get_info').html(info);
			}
	}); 
	
	$('pop_'+arr[1]+'_'+arr[2]+'_'+arr[3]+'_'+arr[4]).popover({
		  html: true,
		  content: function() {
			var id = $('pop_'+arr[1]+'_'+arr[2]+'_'+arr[3]+'_'+arr[4]).attr('id');
			return $('#popover-content-' + id).html();
		  }
		});
		setTimeout(myFunction(arr[1],arr[2],arr[3],arr[4]), 3000);
}
function myFunction(host_id,floors,room,academic_y) {
   $('.popover fade right in').hide();
} */
</script>


