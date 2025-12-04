<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
var html_content="",type="",url="",datastring="";

function fullview_partnership(pid)
{
	//var academic=$('#academic').val();
	//$('#err_msg').html('');
	type='POST',url='<?= base_url() ?>Transport/get_driver_details',datastring={pid:pid};
	html=ajaxcall(type,url,datastring);
	if(html === "{\"driver_details\":null}")
	{
		$('#err_msg').html('Invalid Partner Id.'); 
		$('#maincontent').hide();
	}
	else
	{
		$('#err_msg').html('');
		var array=JSON.parse(html);
		var len=array.driver_details.length;
		$('#pcode').html(array.driver_details.campus);
		$('#pname').html(array.driver_details.vendor_name);
		$('#cperson').html(array.driver_details.driver_name);
		/* $('#pemail').html(array.driver_details.email);
		$('#oemail').html(array.driver_details.office_no); */
		$('#mobile').html(array.driver_details.mobile);
		$('#address').html(array.driver_details.address);
		
		$('#pincode').html(array.driver_details.pincode);
		/* $('#spname').html(array.driver_details.third_party_person);
		$('#place').html(array.driver_details.mou_done_place);
		$('#sgdate').html(array.driver_details.mou_sign_date); */
		var ssd=GetFormattedDate(array.driver_details.service_started_date);
		$('#sdate').html(ssd);
		var sed=GetFormattedDate(array.driver_details.service_end_date);
		$('#edate').html(sed);
		$('#ratio').html(array.driver_details.mou_sharing_ratio);
		$('#factor').html(array.driver_details.mou_share_factor);
		$('#modal_file').html('<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal1" ><i class="fa fa-file-pdf-o"></i></button>');
		var path="<?= base_url() ?>uploads/Transport/Driver/"+array.driver_details.agreement_documents;
		 $("#moufile").attr("src",path);
		
		var status='';
		if(array.driver_details.is_active=='Y')
			status='yes';
		else
			status='No';
		$('#status').html(status);
		$('#driver_id').html(array.driver_details.driver_id);
		$('#d_licence').html(array.driver_details.driving_license_no);
		
		var imurl ='<img src="<?=base_url('assets/images')?>/nopic.jpg" alt="" width="80" height="80">';
		
		if(array.driver_details.driver_photo!=null)
		{
			imurl ='<img src="<?=base_url('uploads/Transport/Driver/')?>/'+array.driver_details.driver_photo+'" alt="" width="80" height="80">';
		}
					
		$('#pphoto').html(imurl);
		
		if(array.driver_details.bus_no==null)
		{
			$('#b_number').html('<span style="color:red;">Not Allocated</span>');
			$('#route').html('<span style="color:red;">Not Allocated</span>');
		}
		else
		{
			//alert(array.driver_details.driver_id+'==='+array.driver_details.driving_license_no);
			$('#b_number').html(array.driver_details.bus_no);
			$('#route').html(array.driver_details.route_name);
		}
		$('#maincontent').show();	
	}
	
}


function GetFormattedDate(date) {
    var todayTime = new Date(date);
    var month = todayTime .getMonth() + 1;
    var day = todayTime .getDate();
    var year = todayTime .getFullYear();
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
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Driver Bus Mapping List</h1>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/driver_bus_mapping")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>

        </div>

        <div class="row ">
            <div class="col-sm-12">
               <div class="panel">
             	<div class="panel-heading">
                    <span class="panel-title"><b>Details</b></span><span id="err_msg" style="color:red;padding-left:50px;"></span>
					
                </div>	
				<div class="panel-body" style="overflow-x:scroll;height:500px;" >
                <h4 id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
				<h4 id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
                    <div class="table-info">    
                    
                    <table class="table table-bordered" >
                        <thead>
						<tr>
                                    <th>#</th>
									<th>Campus</th>
									<th>Vendor</th>
                                    <th>Driver Name</th>
									<th>License No.</th>
									<th>Bus Number</th>
									<th>Route</th>
									<th>Mobile</th>
									
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                              <?php
							  
                            $j=1;                      
                            for($i=0;$i<count($driver_details);$i++)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>                                                                
                                <td><?=$driver_details[$i]['campus']?></td>
                                
                                <td><?=$driver_details[$i]['vendor_name']?></td>
								<td><?=$driver_details[$i]['driver_name']?></td>
                                <td><?=$driver_details[$i]['driving_license_no']?></td>
								<td><?=$driver_details[$i]['bus_no']==null?'<span style="color:red;">Not Allocated</span>':$driver_details[$i]['bus_no']?></td>
								<td><?=$driver_details[$i]['route_name']==null?'<span style="color:red;">Not Allocated</span>':$driver_details[$i]['route_name']?></td>
								<td><?=$driver_details[$i]['mobile']?></td>
                                <td><a title="View Vendor Details" class="btn btn-primary btn-xs" onclick="fullview_partnership('<?=$driver_details[$i]['driver_id']?>')">View</a>
								<?php
								if($driver_details[$i]['bus_no']!=null)
								{?>
								   <a title="Delete Driver-Bus Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/disable_driver_bus_mapping/".$driver_details[$i]['driver_id'])?>">Delete</a>
								  
								<?php
								}?>
								</td>
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                           
                        </tbody>
                    </table>                    
                   </div>
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
									<span class="panel-title"><b>Driver Details</b></span>
									
						</div>	
						<div class="panel-body">
						<div class="row">
		                  <div class="col-sm-10">
							<table class="table table-bordered">
							 <tr>
							  <th scope="col">Campus :</th>
							  <td><span id="pcode"></span></td>
							  <th scope="col">Vendor Name :</th>
							  <td><span id="pname"></span></td>
							</tr>   
							<tr>
							  <th scope="col">Driver Name :</th>
							  <td><span id="cperson"></span></td>
							   <th scope="col">Mobile :</th>
							  <td><span id="mobile"></span></td>
							</tr>
							
							<tr>
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
							  <td id="modal_file">														
								</td>
							  </tr>
							<tr>
							  <th scope="col">Driver id :</th>
							  <td><span id="driver_id"></span></td>
							  <th scope="col">Driver License No. :</th>
							  <td><span id="d_licence"></span></td>
							</tr>
							
															  
							  <tr >
							  <th scope="col">Allocated Bus Number:</th>
							  <td><span id="b_number"></span></td>
							  <th scope="col">Allocated Route :</th>
							  <td id="route">														
								</td>
							  </tr>
							</table>
						</div>
						<div class="col-sm-2"><span id="pphoto">
					
						 </span>
						 </div>  

							
					</div>
					</div>
					</div>
					
					
				</div>
				   
                </div>
            </div>
			
            </div>    
        </div>
    </div>
</div>