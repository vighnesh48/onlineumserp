<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
var html_content="",type="",url="",datastring="";
//$("#myModal1").modal();
function fullview_partnership(pid)
{
	//var academic=$('#academic').val();
	//$('#err_msg').html('');
	type='POST',url='<?= base_url() ?>Transport/get_vendor_details',datastring={pid:pid};
	html=ajaxcall(type,url,datastring);
	if(html === "{\"vendor_details\":null}")
	{
		$('#err_msg').html('Invalid Partner Id.'); 
		$('#maincontent').hide();
	}
	else
	{
		$('#err_msg').html('');
		var array=JSON.parse(html);
		var len=array.vendor_details.length;
		$('#pcode').html(array.vendor_details.campus);
		$('#pname').html(array.vendor_details.vendor_name);
		$('#cperson').html(array.vendor_details.contact_person);
		$('#pemail').html(array.vendor_details.email);
		$('#oemail').html(array.vendor_details.office_no);
		$('#mobile').html(array.vendor_details.mobile);
		$('#address').html(array.vendor_details.address);
		$('#pincode').html(array.vendor_details.pincode);
		$('#fpname').html(array.vendor_details.first_party_person);
		$('#spname').html(array.vendor_details.third_party_person);
		$('#place').html(array.vendor_details.mou_done_place);
		$('#sgdate').html(array.vendor_details.mou_sign_date);
		var ssy=GetFormattedDate(array.vendor_details.service_started_year);
		
		$('#sdate').html(ssy==true?'  -':ssy);
		var sey=GetFormattedDate(array.vendor_details.service_end_year);
		$('#edate').html(sey==true?'  -':sey);
		$('#ratio').html(array.vendor_details.mou_sharing_ratio);
		$('#factor').html(array.vendor_details.mou_share_factor);
		$('#modal_file').html('<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal1" ><i class="fa fa-file-pdf-o"></i></button>');
		var path="<?= base_url() ?>uploads/Transport/vendor/"+array.vendor_details.agreement_documents;
		if(array.vendor_details.agreement_documents!="")	
		$("#moufile").attr("src",path);
	else
		$("#modal_file").hide();
		
		var status='';
		if(array.vendor_details.is_active=='Y')
			status='yes';
		else
			status='No';
		$('#status').html(status);
		$('#maincontent').show();	
	}
	
	
	type='POST',url='<?= base_url() ?>Transport/get_vendor_buses',datastring={id:pid};
	html=ajaxcall(type,url,datastring);
	if(html === "{\"vendor_buses\":[]}")
	{
		$('#nostreams').html('Bus has not allocated yet to '+array.vendor_details.vendor_name+' vendor'); 
		$('#show_streams').hide();
	}
	else
	{
		$('#err_msg').html('');
		var array=JSON.parse(html);
		var len=array.vendor_buses.length;
		var content='',j=1;
		
		for(i=0;i<len;i++)
		{
			content+='<tr><td>'+j+'</td><td>'+array.vendor_buses[i].bus_no+'</td><td>'+array.vendor_buses[i].capacity+'</td></tr>';
			j++;
		}
		$('#prgm_details').html(content);
		$('#nostreams').html('');
		$('#show_streams').show();
		
	} 
}


function GetFormattedDate(date) {
    var todayTime = new Date(date);
    var month = todayTime .getMonth() + 1;
    var day = todayTime .getDate();
    var year = todayTime .getFullYear();
	if(isNaN(day))
		return true;
	else
    return day + " / " + month + " / " + year;
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Transport</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Vendor List</h1>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_vendor")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>


        </div>

        <div class="row ">
            <div class="col-sm-12">
               <div class="panel">
             	<div class="panel-heading">
                    <span class="panel-title"><b>Details</b></span><span id="err_msg" style="color:red;padding-left:50px;"></span>
			
                </div>	
				<div class="panel-body" style="overflow-x:scroll;height:410px;">
                <h4 id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
				<h4 id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
                 <?php
				if(!empty($vendor_details))
				{
					?>
					<div class="table-info" >    
                    
                    <table class="table table-bordered" style="max-width:100%;">
                        <thead>
						<tr>
                                    <th>#</th>
                                    
									<th>Campus</th>
									
									<th>Name</th>
                                    <th>Contact Person</th>
									
									<th>Mobile</th>
								
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                              <?php
							  
                            $j=1;                      
                            for($i=0;$i<count($vendor_details);$i++)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>                                                                
                                <td><?=$vendor_details[$i]['campus']?></td>
                                
                                <td><?=$vendor_details[$i]['vendor_name']?></td>
								<td><?=$vendor_details[$i]['contact_person']?></td>
                                
								<td><?=$vendor_details[$i]['mobile']?></td>
                                <td><a title="View Vendor Details" class="btn btn-primary btn-xs" onclick="fullview_partnership('<?=$vendor_details[$i]['vendor_id']?>')">View</a>
								   <a title="Edit Vendor Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_vendor/".$vendor_details[$i]['vendor_id'])?>">Edit</a>
								 <!-- 
								   <a style="width: 30%;" title="View Hostel Room Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/view_room_details?id=".$vendor_details[$i]['host_id'])?>" style="padding-left: 5px;">Room</a>
								   
								   <a style="width: 25%;" title="View Hostel's Allocation Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/hostel_allocation_view?id=".$vendor_details[$i]['host_id'])?>" style="padding-left: 5px;">View</a>
								   -->
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
					<h4 style="color:red;padding-left:250px;">No Vendors Are Available</h4>
					<?php
				}
				  ?>
                </div>
				<!-- Modal -->
						<div id="myModal1" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content" style="width:800px;">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<center><h4>&nbsp;Mou Document</h4></center>
							  </div>
							  <div class="modal-body">
									<embed id="moufile" width="100%" style="height:500px;" />				
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>

						  </div>
						</div>
				
				</div>
				
				   
				
					<div id="maincontent" style="display:none;">  
					
					<div class="panel">
						<div class="panel-heading">
									<span class="panel-title"><b>Vendor Details</b></span>
									
						</div>	
						<div class="panel-body">
							<table class="table table-bordered">
							 <tr>
							  <th scope="col">Campus :</th>
							  <td><span id="pcode"></span></td>
							  <th scope="col">Name :</th>
							  <td><span id="pname"></span></td>
							</tr>   
							<tr>
							  <th scope="col">Contact Person :</th>
							  <td><span id="cperson"></span></td>
							   <th scope="col">Contact Person Email :</th>
							   <td><span id="pemail"></span></td>
							</tr>
							
							<tr>
							  <th scope="col">Office Email :</th>
							  <td><span id="oemail"></span></td>
							  <th scope="col">Mobile :</th>
							  <td><span id="mobile"></span></td>
							</tr>
							
							 <tr >
							  <th scope="col">Address :</th>
							  <td><span id="address"></span></td>
							  <th scope="col">Pincode :</th>
							  <td><span id="pincode"></span></td>
							  </tr> 
							  
							  <tr>
							  <th scope="col">Service Start Date :</th>
							  <td><span id="sdate"></span></td>
							  <th scope="col">Service End Date :</th>
							  <td><span id="edate"></span></td>
							</tr>
							
															  
							  <tr >
							  <th scope="col">Is Active:</th>
							  <td><span id="status"></span></td>
							  <th scope="col">Agreement File :</th>
							  <td>	<div id="modal_file"></div>													
								</td>
							  </tr>
							
							<tr>
								
									<table id="show_streams" style="display:none;" class="table table-bordered">
										<th>S.No</th>
										<th>Bus Number</th>
										<th>Capacity</th>
										
										<tbody id="prgm_details"></tbody>
									</table>
							</tr>
							
							</table>
							<h4 id="nostreams" style="color:red" ></h4>
					</div>
					</div>
					
					
				</div>
		
				   
              
            </div>
			
            </div>    
        </div>
    </div>
</div>