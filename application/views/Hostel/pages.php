<?php 
	$siteUrl = site_url().'Upload/getImageInfo/';
	$bucketname = 'uploads/student_photo/'; 
?>


<script>

$(document).ready(function()
{
	$('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	$('#doc-sub-datepicker42').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	
	$('.Disallow').click(function(){
		var id=$('.btn_disallow').attr('id');
		var enrollment_no=$('.btn_disallow').attr('lang');
		var sf_room_id=$('.btn_disallow').attr('role');
		//alert(id);
		if (confirm('Are you sure?')) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/hostel_Disallow',
				data: {f_alloc_id:id,enrollment_no:enrollment_no,sf_room_id:sf_room_id},
				success: function (data) {
					if(data==1){
						alert('PRN :'+enrollment_no+' Deallocate for Hostel');
						 jQuery("#btn_submit1").trigger('click');
                          $('#myModal1').modal('hide');
					}
				}
			});
      //var url = $(this).attr('href');
      //$('#content').load(url);
	//  alert('1');
    }else{
		//alert('2');
	}
		});
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
		$('.btn_disallow').hide();
	}else{
		$('.btn_disallow').show();
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
					$('.btn_disallow').attr('id',f_alloc_id);
					$('.btn_disallow').attr('lang',enrollment_no);
					$('.btn_disallow').attr('role',sf_room_id);
					if(array.std_fee_details.organization=='SU')
					{
						//var imurl ='<img src="<?=base_url('uploads/student_photo')?>/'+enrollment_no+'.jpg" alt="" width="80" height="80">';
						//var imurl ='<img src="<?= $siteUrl ?>'+enrollment_no+'.jpg?b_name=<?=$bucketname ?>" alt="" width="80" height="80">';
						var url = '<?= $siteUrl."Upload/getImageInfo" ?>/'+enrollment_no+'.jpg?b_name=<?=$bucketname ?>';
						$.ajax({url: url, async: false,
							success: function(response){ imageData = response.imageData;
						}});
						var imurl ='<img src="'+imageData+'" alt="" width="80" height="80">';
						console.log('here1');
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
						//var imurl ='<img src="<?=base_url('uploads/student_photo')?>/'+enrollment_no+'.jpg" alt="" width="80" height="80">';
						//var imurl ='<img src="<?= $siteUrl ?>'+enrollment_no+'.jpg?b_name=<?=$bucketname ?>" alt="" width="80" height="80">';
						var url = '<?= $siteUrl."Upload/getImageInfo" ?>/'+enrollment_no+'.jpg?b_name=<?=$bucketname ?>';
						// $.post(url, {}, function(response){ 
						//     imageData = response.imageData;
						// });
							$.ajax({url: url, dataType: 'json', async: false,
								success: function(response){ imageData = response.imageData;
							}});
							var imurl ='<img src="'+imageData+'" alt="" width="80" height="80">';
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
							//var imurl ='<img src="<?=base_url('uploads/student_photo')?>/'+enroll+'.jpg" alt="" width="80" height="80">';
							//var imurl ='<img src="<?= $siteUrl ?>'+enroll+'.jpg?b_name=<?=$bucketname ?>" alt="" width="80" height="80">';
							var url = '<?= site_url() ?>Upload/getImageInfo/'+enroll+'.jpg?b_name=<?=$bucketname ?>';
							
							$.ajax({url: url, dataType: 'json', async: false,
								success: function(response){ imageData = response.imageData;
							}});
							var imurl ='<img src="'+imageData+'" alt="" width="80" height="80">';
							
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
</script>


<style>
.hostel-bg{background: #ddd;margin:10px auto;width: 100%;
min-height:205px; position: relative;}
.hostel-bg .col-md-10{position: absolute!important;bottom:5px;}
.hostel-bg ul li{border-radius: 3px;
color: #fff;text-align: center;padding: 5px;
width:25px;
height:35px;
outline: 1px solid #fff;
outline-offset:-4px;margin:4px 12px 4px 4px;
}
.green-bed{background:#2fac1e;}
.orange-bed{background:#ede90d;}
.blue-bed{background:#00aeef;}
.grey-bed{background:#b6b3b3;}


.red-bed{background:#ed280e;}
.pink-bed{background:#d87cdd;}
.yellow-bed{background:#edc423;}
.purple-bed{background:#752aed;}

.red-icon{color:#ed280e;}
.pink-icon{color:#d87cdd;}
.yellow-icon{color:#edc423;}


.green-icon{color:#2fac1e;}
.orange-icon{color:#ede90d;}
.blue-icon{color:#00aeef;}
.grey-icon{color:#b6b3b3;}
.hostel-bg ul{padding:5px;}
.hostel-bg .list-inline{margin-left:0px;}
.hostel-bg ul li > p{
border:1px solid #fff;height:5px;
border-radius:2px;
width: 80%;
margin:1px auto;}
.no-padd{padding:0px}
.color-icon{padding-top: 7px;}
.color-icon li {font-size:11px;}
</style>




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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Hostel Allocation View</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row"> 
						<br/>				
					<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="col-sm-12">
							<!--<form class="form-horizontal" action="/action_page.php">
							</form>-->
							<input type="hidden" id="hostel_id" name="hostel_id" />
							<input type="hidden" id="hostel_code" name="hostel_code" /> 
							<input type="hidden" id="nooffloor" name="nooffloor" />
							<div class="col-md-2">
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
							<div class="col-sm-2">
									<select class="form-control" name="host_id" id="host_id" required>
									  <option value="">Select Hostel</option>
									  <?php //echo "state".$state;exit();
										if(!empty($hostel_details)){
											foreach($hostel_details as $hostels){
												?>
											  <option value="<?=$hostels['host_id']?>||<?=$hostels['hostel_code']?>||<?=$hostels['no_of_floors']?>"><?=$hostels['hostel_name']?></option>  
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
									<div class="col-sm-2">
									<button class="btn btn-primary form-control" onclick="get_hostel_details()" id="btn_submit1" >Submit</button>
									
									<!--<label class="radio-inline">
									  <input type="radio" name="optradio">Nashik
									</label>
									<label class="radio-inline">
									  <input type="radio" name="optradio">Sijoul
									</label>-->
									</div>
									<div class="col-sm-4">
				<span style="color:red;" id="err_msg"></span>
				</div>
						  
                </div>
				
				
                    <div class="panel-body">
					<!-- Trigger the modal with a button 
						<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

					-->

						<!-- Modal -->
						<div id="myModal1" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content" style="width:800px;">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<center><h4>Academic Year:&nbsp;
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
											  
											 <!-- <th scope="col">Hostel Code :</th>
											  <td><span id="hostelcode"></span></td>
											</tr>   
											<tr id="div2">
											  <th scope="col">#Floor :</th>
											  <td><span id="floor_no"></span></td>
											   <th scope="col">#Room :</th>
											   <td><span id="room_no"></span></td>
											</tr>-->
											
											
											
											
											<!--<tr>
											  <th scope="col">Deposit :</th><td><span id="deposit"></span></td>
											</tr>
											<tr>
											  <th scope="col">Excemption :</th><td><span id="excemption"></span></td>
											</tr>
											<tr>
											  <th scope="col">Amount Paid :</th><td><span id="paid_amt"></span></td>
											</tr>
											<tr id="vf" style="display:none;">
											  <th scope="col">Valid From :</th><td><input type="text" class="form-control" id="doc-sub-datepicker21" name="validfrom" required placeholder="Valid from Date" required /></td>
											</tr>
											<tr id="vt" style="display:none;">
											  <th scope="col">Valid To :</th><td><input type="text" class="form-control" id="doc-sub-datepicker42" name="validto" required placeholder="Valid to Date" required /></td>
											</tr>-->
											
											
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
<!--                        <button class="btn btn-primary form-control" type="submit" id="btn_submit" style="display:none;">Allocate</button> 
-->                        <span style=""><a href="#" class="btn btn-primary form-control Disallow btn_disallow" lang="" id="" role="">Deallocate</a></span>                                      
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
						
						</div>
						
						<div class="row" id="maincontent" style="display:none;">
							<div class="clearfix"></div>
							<hr>
								<div class="col-lg-12">
							<ul class="list-inline list-unstyled color-icon text-right">
								
								<li><i class="fa fa-square green-icon" aria-hidden="true"></i> Student in <b>[<span id="cnt_in"></span>]</b></li>
								<li><i class="fa fa-square orange-icon" aria-hidden="true"></i> Student out [CITY] <b>[<span id="cnt_city"></span>]</b></li>

								<li><i class="fa fa-square red-icon" aria-hidden="true"></i> Student out [HOME] <b>[<span id="cnt_home"></span>]</b></li>
								<li><i class="fa fa-square blue-icon" aria-hidden="true"></i> Guest House <b>[<span id="cnt_gh"></span>]</b></li>
								<li><i class="fa fa-square grey-icon" aria-hidden="true"></i> Not Allocated <b>[<span id="cnt_free"></span>]</b></li>
							</ul>
								</div>
							<div class="clearfix"></div>
							<hr>
							
							<div id="content"></div>
						
						</div>
						<!-- / #content-wrapper -->
						<div id="main-menu-bg"></div>
									<div class="col-lg-12" id="summary">
									<ul class="list-inline list-unstyled color-icon text-left">
										
										
									</ul>
								</div>
						<div class="clearfix"></div>
															
					
						</div> 
					
				</div>
			</div>
		</div>
	</div>			
</div>		
	


 <!-- / #main-wrapper -->

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
		
		$("#btn_submit1").trigger("click");
	}
	   
  	
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
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Hostel/fetch_alloted_details',
			data: { host_id: hid[0], floors : floorno,academic_y:academic_y},
			success: function (html) {
				//alert(html);
				if(html === "{\"flr_details\":[]}")
				{
					$('#err_msg').html('Not yet Alloted this hostel!!'); 
					$('#maincontent').hide();
				}
				else
				{
					$('#err_msg').html('');
					var array=JSON.parse(html);
					len=array.flr_details.length;
					//alert(array.flr_details[0].hostel_code);
					var cnt_in=0,cnt_home=0,cnt_city=0,cnt_gh=0,cnt_free=0;
					var rno='',fullcontent='',header='',footer='',subheader='';
					var ftemp=array.flr_details[0].floor_no,rtemp=array.flr_details[0].room_no;
					
						var hflag=0,shflag=0,cflag=0,fflag=0;
						var troom='',tfloor='';
						var alloc_status='';
						var check_floor=array.flr_details[0].floor_no;
						if(check_floor==0)
							{check_floor='Ground Floor';}
						else
							{check_floor='Floor No '+check_floor;}
						fullcontent='<div class="col-lg-12"><h4><em>Hostel '+array.flr_details[0].hostel_code+' | '+check_floor+' </em></h4></div><div class="col-lg-2"><div class="hostel-bg row"><ul class="list-inline list-unstyled">';
						//alert(array.flr_details[0].present_status);
						var enroll_num='';
						for(i=0;i<len;i++)
							{
								//\nName: '+array.flr_details[i].first_name+'
								if(array.flr_details[i].enrollment_no!=null)
								enroll_num = "'"+(array.flr_details[i].enrollment_no).replace(/\//g, '_')+"'";
								else
									enroll_num = array.flr_details[i].enrollment_no;
								if(array.flr_details[i].student_id)
								{
									/* if(array.flr_details[i].present_status==null)
										alloc_status='onclick="get_student_details('+array.flr_details[i].f_alloc_id+','+array.flr_details[i].sf_room_id+','+array.flr_details[i].academic_year+','+array.flr_details[i].student_id+','+enroll_num+')" title="student_id: '+array.flr_details[i].student_id+'\nenrollment_no: '+enroll_num+'\nStatus: Not yet checked In" class="blue-bed" data-toggle="modal" data-target="#myModal"';
									else  */
									if(array.flr_details[i].present_status=='CITY')
									{
										cnt_city++;
										alloc_status='onclick="get_student_details('+array.flr_details[i].f_alloc_id+','+array.flr_details[i].sf_room_id+','+array.flr_details[i].academic_year+','+array.flr_details[i].student_id+','+enroll_num+')" title="student_id: '+array.flr_details[i].student_id+'\nenrollment_no: '+enroll_num+'\nStatus: '+array.flr_details[i].present_status+'" class="yellow-bed" data-toggle="modal" data-target="#myModal"';
									}
									else if(array.flr_details[i].present_status=='HOME')
									{
										cnt_home++;
										alloc_status='onclick="get_student_details('+array.flr_details[i].f_alloc_id+','+array.flr_details[i].sf_room_id+','+array.flr_details[i].academic_year+','+array.flr_details[i].student_id+','+enroll_num+')" title="student_id: '+array.flr_details[i].student_id+'\nenrollment_no: '+enroll_num+'\nStatus: '+array.flr_details[i].present_status+'" class="red-bed" data-toggle="modal" data-target="#myModal"';
									}
									else if(array.flr_details[i].present_status=='IN')
									{
										cnt_in++;
										if(array.flr_details[i].category=="Guest House"){
											var cls= "purple-bed";
										}else{
											var cls= "green-bed";
										}
										alloc_status='onclick="get_student_details('+array.flr_details[i].f_alloc_id+','+array.flr_details[i].sf_room_id+','+array.flr_details[i].academic_year+','+array.flr_details[i].student_id+','+enroll_num+')" title="student_id: '+array.flr_details[i].student_id+'\nenrollment_no: '+enroll_num+'\nStatus: '+array.flr_details[i].present_status+'" class='+cls+' data-toggle="modal" data-target="#myModal"';
									}
								}
								else
								{
									if(array.flr_details[i].category=="Gym")
									{
										alloc_status='title=" GYM " class="purple-bed" data-toggle="modal" data-target="#myModal"';
									}
									else if(array.flr_details[i].category=="Guest House")
									{
										cnt_gh++;
										alloc_status='title=" Guest House " class="blue-bed" data-toggle="modal" data-target="#myModal"';
										alloc_status='onclick="get_student_details('+array.flr_details[i].f_alloc_id+','+array.flr_details[i].sf_room_id+','+array.flr_details[i].academic_year+','+array.flr_details[i].student_id+','+enroll_num+')" title="student_id: '+array.flr_details[i].student_id+'\nenrollment_no: '+enroll_num+'\nStatus: '+array.flr_details[i].present_status+'" class="blue-bed" data-toggle="modal" data-target="#myModal"';
										//alloc_status="G";
									}
									else if(array.flr_details[i].category=="Parlour")
									{
										alloc_status='title=" Parlour " class="pink-bed" data-toggle="modal" data-target="#myModal"';
									}
									else
									{
										cnt_free++;
										alloc_status='onclick="get_student_details('+array.flr_details[i].f_alloc_id+','+array.flr_details[i].sf_room_id+','+array.flr_details[i].academic_year+','+array.flr_details[i].student_id+','+enroll_num+')" title="Bed Available" class="grey-bed" data-toggle="modal" data-target="#myModal"';
									}
								}	//alloc_status='onclick="get_student_details('+array.flr_details[i].f_alloc_id+','+array.flr_details[i].sf_room_id+')" class="grey-bed" data-toggle="modal" data-target="#myModal"';
								
							//	console.log("rows=="+i+'f=='+ftemp+'r==='+array.flr_details[i].room_no);
								if(ftemp==array.flr_details[i].floor_no)
								{
									//alert(array.flr_details[i].floor_no);
									//alert("floor");
									console.log('i_'+i+'_room_no'+array.flr_details[i].room_no+'--'+array.flr_details[i].category);
									if(rtemp==array.flr_details[i].room_no)
									{//alert("room");
										//alert("bedno==="+array.flr_details[i].bed_number);
										//content='<li '+alloc_status+'><p>&nbsp;</p><div>'+array.flr_details[i].bed_number+'</div></li>';
										//if(array.flr_details[i].category=="Guest House"){
									//content='<li '+alloc_status+'><p>&nbsp;</p><div>Guest'+array.flr_details[i].bed_number+'</div></li>';
									//	}else{
									content='<li '+alloc_status+'><p>&nbsp;</p><div>'+array.flr_details[i].bed_number+'</div></li>';
								//}
									}
									else
									{
										//alert("room changed");
									console.log('room_changed i_'+i+'_room_no'+array.flr_details[i].room_no+'--'+array.flr_details[i].category);	
										//console.log("bedno==="+array.flr_details[i].bed_number);
										
										footer='</ul><div class="col-md-10">Room no. <strong>'+rtemp+'</strong></div></div></div><div class="col-lg-2"><div class="hostel-bg row"><ul class="list-inline list-unstyled"><li '+alloc_status+'><p>&nbsp;</p><div>'+array.flr_details[i].bed_number+'</div></li>';
										//alert(fullcontent);
										troom=array.flr_details[i].room_no;
										//break;
										cflag=1;fflag=1;
									}		
									//}
									
								}
								else
								{//alert("floor changed");
							console.log('floor changed '+i+'--'+array.flr_details[i].category);
									hflag=1;shflag=1;cflag=1;
									header='</ul><div class="col-md-10">Room no.  <strong>'+rtemp+'</strong></div></div></div><div class="col-lg-12"><h4><em>Hostel '+array.flr_details[i].hostel_code+' | Floor No '+array.flr_details[i].floor_no+' </em></h4></div>';
									subheader='<div class="col-lg-2"><div class="hostel-bg row"><ul class="list-inline list-unstyled">';
									
									//if(array.flr_details[i].category=="Guest House"){
									//content='<li '+alloc_status+'><p>&nbsp;</p><div>Guest'+array.flr_details[i].bed_number+'</div></li>';
									//	}else{
									content='<li '+alloc_status+'><p>&nbsp;</p><div>'+array.flr_details[i].bed_number+'</div></li>';
								//}
									tfloor=array.flr_details[i].floor_no;
									troom=array.flr_details[i].room_no;
								}
								
								//rtemp=troom;
								//ftemp=tfloor;
								
								//alert("hflag=="+hflag+"shflag=="+shflag+"cflag=="+cflag+"fflag=="+fflag);
								if(hflag==0 && shflag==0 && cflag==0 && fflag==0)
								{	fullcontent+=content;}
								if(cflag==1 && fflag==1 && hflag==0 && shflag==0)
								{
									fullcontent+=footer;
									rtemp=troom;}
								if(cflag==1 && hflag==1 && shflag==1 && fflag==0)
								{
									fullcontent+=header+subheader+content;
									ftemp=tfloor;rtemp=troom;}
								
								//alert(fullcontent);
								hflag=0,shflag=0,cflag=0,fflag=0;
								
							}
							//alert(fullcontent);	
							
							//content+='</div>';
							
						//}
					//}	
					fullcontent+='</ul><div class="col-md-10">Room no.  <strong>'+rtemp+'</strong></div></div></div>';
					//alert(fullcontent);
					$('#content').html(fullcontent);
					$('#cnt_in').html(cnt_in);
					$('#cnt_home').html(cnt_home);
					$('#cnt_city').html(cnt_city);
					$('#cnt_free').html(cnt_free);
					$('#cnt_gh').html(cnt_gh);

					$('#maincontent').show();
					//alert(content);
				}
					
			}
		});
		
	}
}

</script>