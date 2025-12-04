<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script>

$(document).ready(function(){
	
	var input_data='<option value="">Select No. Of Person</option>';

	for (i=1;i<=10;i++)
	{
		input_data+='<option value="'+i+'"> '+i+'</option>';
	}
	$('#nperson').html(input_data);
	
	$('#status').change(function() {
		common_call();
	});
	
	$('#gtype').change(function() {
		common_call();
	});
	
	$('#nperson').change(function() {
		common_call();
	}); 
	
	$('#doc-sub-datepicker21').on('changeDate', function (e) {
		common_call();
	}); 
			
	$('#doc-sub-datepicker22').on('changeDate', function (e) {
		common_call();
	}); 
	
	$('#doc-sub-datepicker21').datepicker( {
  todayHighlight: true,
  format: 'dd/mm/yyyy',
  autoclose: true,
  setDate: new Date()
  });
	$('#doc-sub-datepicker22').datepicker( {
  todayHighlight: true,
  format: 'dd/mm/yyyy',
  autoclose: true,
  setDate: new Date()
  });
	
});

function common_call()
{
	var status=$('#status').val();
	var gtype=$('#gtype').val();
	var nperson=$('#nperson').val();
	var fdate=$('#doc-sub-datepicker21').val();
	var tdate=$('#doc-sub-datepicker22').val();

	type='POST',url='<?= base_url() ?>Guesthouse/booking_list_by_creteria';
	datastring={status:status,gtype:gtype,nperson:nperson,cin:fdate,cout:tdate};
	html_content=ajaxcall(type,url,datastring);
	display_content(html_content);		
}

function display_content(html_content)
{
	var content='';
	var content1='';
	if(html_content === "{\"booking_list\":[]}")
	{
		$('#tableinfo').hide();
		$('#pdf').hide();
		$('#excel').hide();
		$('#err_msg1').html('Records Not Found Please change search criteria and try again');
	}
	else
	{
		$('#err_msg1').html('');
		$('#pdf').show();
		$('#excel').show();
		var array=JSON.parse(html_content);
		len=array.booking_list.length;
		//alert(len+"==="+html);
		var j=1,gen='',ghname='';
		for(i=0;i<len;i++)
		{
			if(array.booking_list[i].gender=='M')
				gen='Male';
			else
				gen='Female';
			
			if(array.booking_list[i].guesthouse_name==null)
			ghname=' - ';
		else
			ghname=array.booking_list[i].guesthouse_name;
			content+='<tr><td>'+j+'</td><td>'+array.booking_list[i].visitor_name+'</td><td>'+gen+'</td><td>'+array.booking_list[i].mobile+'</td><td><b>'+ghname+'</b></td><td>'+array.booking_list[i].charges+'</td><td>'+array.booking_list[i].no_of_person+'</td><td>'+array.booking_list[i].proposed_in_date+'</td><td>'+array.booking_list[i].proposed_out_date+'</td><td>'+array.booking_list[i].checkin_on+'</td><td>'+array.booking_list[i].checkin_out+'</td><td>';
			
			if(array.booking_list[i].current_status=='BOOKING-DONE')
				content+='<span style="color:Green" >BOOKING-DONE</span>';
			else if(array.booking_list[i].current_status=='CANCELLED')
				content+= '<span style="color:red" >CANCELLED</span>';
			else 
				content+= '<span style="color:#1d89cf" >'+array.booking_list[i].current_status+'</span>';
			
			content+='</td><td>';
			
			if(array.booking_list[i].current_status=='CHECK-IN')
			{
				content+='<a title="Check-Out Guesthouse" class="btn btn-primary btn-xs" href="'+base_url+'checkincheckout/'+array.booking_list[i].booking_id+'">Check-Out</a>';
			}
			else if(array.booking_list[i].current_status=='BOOKING-DONE')
			{
				content+='<a title="Edit Booking Details" class="btn btn-primary btn-xs" href="'+base_url+'edit_booking_details/'+array.booking_list[i].booking_id+'">Edit</a><a title="Check-In Guesthouse" class="btn btn-primary btn-xs" href="'+base_url+'checkincheckout/'+array.booking_list[i].booking_id+'">Check-In</a>';
			}
			content+='</td></tr>';
			j++;
		}
		$('#itemContainer1').html(content);
		$('#tableinfo').show();
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Guest House</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Booking List</h1>
			
        </div>

        <div class="row ">
            <div class="col-sm-12">
               <div class="panel">
             	<div class="panel-heading">
                    <div class="row">
                           <div class="col-sm-2" style="padding-left:0px;">
						<select id="status" name="status" class="form-control" >
								  <option value="">Select Status</option>
								  <option value="BOOKING-DONE">BOOKING-DONE</option>
								  <option value="CANCELLED">CANCELLED</option>
								  <option value="CHECK-IN">CHECK-IN</option>
								  <option value="CHECK-OUT">CHECK-OUT</option>
						</select>
						</div>
						<div class="col-sm-2" style="padding-left:0px;">
							<select id="gtype" name="gtype" class="form-control" >
									  <option value="">Select Guest House</option>
									  <?php 
									if(!empty($guesthouse_details)){
										foreach($guesthouse_details as $gh){
											?>
										  <option value="<?=$gh['gh_id']?>"><?=$gh['guesthouse_name']?></option>  
										<?php 
											
										}
									}
							  ?>
							</select>
						</div>
						
							<!--label class="col-sm-1" style="padding-left:0px;">CheckIn:</label>-->
							<div class="col-sm-2" style="padding-left:0px;">
							  <input type="text" class="form-control" placeholder="CheckIn Date" id="doc-sub-datepicker21" name="fdate"  readonly="true"/>
							</div>
							<!--label class="col-sm-1" style="padding-left:0px;">CheckOut:</label>-->
						
							<div class="col-sm-2" style="padding-left:0px;">
							  <input type="text" class="form-control" placeholder="CheckOut Date" id="doc-sub-datepicker22" name="tdate"  readonly="true"/>
							</div>
							<div class="col-sm-2" style="padding-left:0px;">
						<select id="nperson" name="nperson" class="form-control" >
								  
								 
						</select>
						</div>
						
							<!--<div class="col-sm-2" style="padding-left:0px;">
							<button style="padding-left:6px;" class="btn btn-primary form-control" id="btn_submit" type="submit" >Check Availability</button>
							</div>-->
                    </div>
					
                </div>	
				<div class="panel-body" >
                <h4 id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
				<h4 id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
                 <?php
				if(!empty($booking_list))
				{
					?>   <div class="table-info table-responsive" id="tableinfo">    
                    
                    <table class="table table-bordered" >
                        <thead>
						<tr>
                                    <th>#</th>
									<th>Name</th>
									<th>Gender</th>
                                    <th>Mobile</th>
									<th>Guest House</th>
									<!--th>Charges</th-->
									
									<th>No. Of Person</th>
									<th>Referred by</th>
									<th>From Date</th>
									<th>To Date</th>
									<th>Check In</th>
									<th>Check Out</th>
									<th>Current Status</th>
									
									<th>Action</th>
									<!--<th>mobile</th>
									<th>mobile</th>-->
                                    
                            </tr>
                        </thead>
                        <tbody id="itemContainer1">
                              <?php
							  
                            $j=1;                      
                            for($i=0;$i<count($booking_list);$i++)
                            {
								?>
								<tr>
									<td><?=$j?></td>	
									<td><?=$booking_list[$i]['visitor_name']?></td>	
									<td><?=$booking_list[$i]['gender']=='M'?'Male':'Female'?></td>
									<td><?=$booking_list[$i]['mobile']?></td>			
									<td><b><?=(!empty($booking_list[$i]['guesthouse_name']))?$booking_list[$i]['guesthouse_name']:' - '?></b></td>
									<!--td><?=$booking_list[$i]['charges']?></td-->
									
									<td><?=$booking_list[$i]['no_of_person']?></td>
									<td><?=$booking_list[$i]['reference_of']?></td>
									<td><?=date('d-m-Y H:i:s',strtotime($booking_list[$i]['proposed_in_date']))?></td>
<td><?=date('d-m-Y H:i:s',strtotime($booking_list[$i]['proposed_out_date']))?></td>
<td><?php if($booking_list[$i]['checkin_on'] !=''){ echo date('d-m-Y h:i',strtotime($booking_list[$i]['checkin_on'])); }else{ echo ''; } ?></td>
<td><?php if($booking_list[$i]['checkin_out'] !=''){ echo date('d-m-Y h:i',strtotime($booking_list[$i]['checkin_out'])); }else{ echo ''; } ?></td>
									<td>
									<?php if($booking_list[$i]['current_status']=='BOOKING-DONE')echo '<span style="color:Green" >BOOKING-DONE</span>';
									else if($booking_list[$i]['current_status']=='CANCELLED')echo '<span style="color:red" >CANCELLED</span>';else echo '<span style="color:#1d89cf" >'.$booking_list[$i]['current_status'].'</span>';?> 
									</td>
									
									<td>
									<?php if($booking_list[$i]['current_status']=='BOOKING-DONE' || $booking_list[$i]['current_status']=='CHECK-IN')
									{
										if($booking_list[$i]['current_status']=='CHECK-IN')
										{
									?>		<a title="Edit Booking Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_booking_details/".$booking_list[$i]['booking_id'])?>">Edit</a>
											<a title="Check-Out Guesthouse" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/checkincheckout/".$booking_list[$i]['booking_id'])?>" >Check-Out</a>
										<?php 
										}
										else
										{
											?>
											<a title="Edit Booking Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_booking_details/".$booking_list[$i]['booking_id'])?>">Edit</a>
											<a title="Check-In Guesthouse" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/checkincheckout/".$booking_list[$i]['booking_id'])?>" >Check-In</a>
									
									<?php 
										}
									}
									if($booking_list[$i]['current_status']=='CHECK-OUT')
										{	?>
                                        
                                        <!--a title="Check-In Guesthouse" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/download_challan_pdf/".$booking_list[$i]['booking_id'])?>" >pdf</a-->
									<?php } ?>
                                    </td>
								</tr>
								<?php
								$j++;
                            }
                            ?>                           
                        </tbody>
                    </table>                    
                  
                </div>
				<?php
				}else{
					?>
					<h4 style="color:red;padding-left:200px;">Guest House Have Not Found</h4>
					<?php
				}
				  ?>
				  <h4 style="color:red;padding-left:200px;" id="err_msg1"></h4>
				   </div>
                </div>
            </div>
			
            </div>    
        </div>
    </div>
</div>

