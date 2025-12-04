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
	type='POST',url='<?= base_url() ?>Master/get_partnership_details',datastring={pid:pid};
	html=ajaxcall(type,url,datastring);
	if(html === "{\"partnership_details\":null}")
	{
		$('#err_msg').html('Invalid Partner Id.'); 
		$('#maincontent').hide();
	}
	else
	{
		$('#err_msg').html('');
		var array=JSON.parse(html);
		var len=array.partnership_details.length;
		$('#pcode').html(array.partnership_details.partnership_code);
		$('#pname').html(array.partnership_details.partner_name);
		$('#cperson').html(array.partnership_details.contact_person);
		$('#pemail').html(array.partnership_details.contact_person_email);
		$('#oemail').html(array.partnership_details.office_email);
		$('#mobile').html(array.partnership_details.mobile);
		$('#address').html(array.partnership_details.address);
		
		$('#fpname').html(array.partnership_details.first_party_person);
		$('#spname').html(array.partnership_details.third_party_person);
		$('#place').html(array.partnership_details.mou_done_place);
		$('#sgdate').html(array.partnership_details.mou_sign_date);
		$('#sdate').html(array.partnership_details.mou_start_date);
		$('#edate').html(array.partnership_details.mou_expiray_date);
		$('#ratio').html(array.partnership_details.mou_sharing_ratio);
		$('#factor').html(array.partnership_details.mou_share_factor);
		$('#modal_file').html('<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal1" ><i class="fa fa-file-pdf-o"></i></button>');
		var path="<?= base_url() ?>uploads/student_challans/"+array.partnership_details.mou_document_file;
		 $("#moufile").attr("src",path);
		
		var status='';
		if(array.partnership_details.mou_active_status=='Y')
			status='yes';
		else
			status='No';
		$('#status').html(status);
		$('#maincontent').show();	
	}
	
	
	type='POST',url='<?= base_url() ?>Master/get_partnership_streams',datastring={pid:pid};
	html=ajaxcall(type,url,datastring);
	if(html === "{\"partnership_streams\":[]}")
	{
		$('#nostreams').html('No streams in this partnership.'); 
		$('#show_streams').hide();
	}
	else
	{
		$('#err_msg').html('');
		var array=JSON.parse(html);
		var len=array.partnership_streams.length;
		var content='',j=1;
		
		for(i=0;i<len;i++)
		{
			content+='<tr><td>'+j+'</td><td>'+array.partnership_streams[i].stream_name+'</td><td>'+array.partnership_streams[i].course_pattern+'</td><td>'+array.partnership_streams[i].course_duration+'</td><td>'+array.partnership_streams[i].start_year+'</td></tr>';
			j++;
		}
		$('#prgm_details').html(content);
		$('#nostreams').html('');
		$('#show_streams').show();
		
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
        <li class="active"><a href="<?=base_url($currentModule)?>">partnership </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Partnership Institue </h1><span id="err_msg" style="color:red;"></span>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_partnership")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>

			<span id="flash-messages" style="color:Green;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
			<span id="flash-messages" style="color:red;">
				 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>

        <div class="row ">
            <div class="col-sm-12">
               <div class="panel">
             	<div class="panel-heading">
                            <span class="panel-title"><b>List</b></span>
							
                </div>	
				<div class="panel-body">
                
                    <div class="table-info" style="overflow-x:scroll;height:350px;">    
                    
                    <table class="table table-bordered" style="width:100%;max-width:100%;">
                        <thead>
						<tr>
                                    <th>#</th>
                                    
									<th>Code</th>
									
									<th>Name</th>
                                    <th>Contact Person</th>
									<th>Address</th>
									<th>Mobile</th>
									<th>View</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                              <?php
							  
                            $j=1;                      
                            for($i=0;$i<count($partnership_details);$i++)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>                                                                
                                <td><?=$partnership_details[$i]['partnership_code']?></td>
                                
                                <td><?=$partnership_details[$i]['partner_name']?></td>
								<td><?=$partnership_details[$i]['contact_person']?></td>
                                <td><?=$partnership_details[$i]['address']?></td>
								<td><?=$partnership_details[$i]['mobile']?></td>
                                <td><a title="Edit Academic Year Details" class="btn btn-primary btn-xs" onclick="fullview_partnership('<?=$partnership_details[$i]['partner_id']?>')">View</a></td>
                                
                                <td>
								   <a title="Edit partnership Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_partnership/".$partnership_details[$i]['partner_id'])?>">Edit</a>
								 <!-- 
								   <a style="width: 30%;" title="View Hostel Room Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/view_room_details?id=".$partnership_details[$i]['host_id'])?>" style="padding-left: 5px;">Room</a>
								   
								   <a style="width: 25%;" title="View Hostel's Allocation Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/hostel_allocation_view?id=".$partnership_details[$i]['host_id'])?>" style="padding-left: 5px;">View</a>
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
						
				<div id="maincontent" style="display:none;">  
					
					<div class="panel">
						<div class="panel-heading">
									<span class="panel-title"><b>Partnership Details</b></span>
									
						</div>	
						<div class="panel-body">
							<table class="table table-bordered">
							 <tr>
							  <th scope="col">Code :</th>
							  <td><span id="pcode"></span></td>
							  <th scope="col">Name :</th>
							  <td><span id="pname"></span></td>
							</tr>   
							<tr>
							  <th scope="col">Contact Person :</th>
							  <td><span id="cperson"></span></td>
							   <th scope="col">contact_person_email :</th>
							   <td><span id="pemail"></span></td>
							</tr>
							
							<tr>
							  <th scope="col">office_email :</th>
							  <td><span id="oemail"></span></td>
							  <th scope="col">Mobile :</th>
							  <td><span id="mobile"></span></td>
							</tr>
							
							 <tr >
							  <th scope="col">Address :</th>
							  <td><span id="address"></span></td>
							  </tr> 
							
							</table>
					</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
									<span class="panel-title"><b>Mou Details</b></span>
									
						</div>	
						<div class="panel-body">
							<table class="table table-bordered">
										 <tr>
										  <th scope="col">First Party Name :</th>
										  <td><span id="fpname"></span></td>
										  <th scope="col">Third Party Name :</th>
										  <td><span id="spname"></span></td>
										</tr>   
										<tr>
										  <th scope="col">Mou Done Place :</th>
										  <td><span id="place"></span></td>
										   <th scope="col">Mou Sign Date :</th>
										   <td><span id="sgdate"></span></td>
										</tr>
										
										<tr>
										  <th scope="col">Mou Start Date :</th>
										  <td><span id="sdate"></span></td>
										  <th scope="col">Mou Expiry Date :</th>
										  <td><span id="edate"></span></td>
										</tr>
										
										 <tr >
										  <th scope="col">Mou Sharing Ratio :</th>
										  <td><span id="ratio"></span></td>
										  <th scope="col">Mou Share Factor :</th>
										  <td><span id="factor"></span></td>
										  </tr> 
										  
										  <tr >
										  <th scope="col">Mou Active Status:</th>
										  <td><span id="status"></span></td>
										  <th scope="col">Mou File :</th>
										  <td id="modal_file">														
											</td>
										  </tr>
										
										</table>
					</div>
					</div>
					
					<div class="panel">
						<div class="panel-heading">
									<span class="panel-title"><b>Partnership Program Details</b></span>
									
						</div>	
						<div class="panel-body">
							<h4 id="nostreams" style="color:red" ></h4>
										<table id="show_streams" style="display:none;" class="table table-bordered">
											<th>S.No</th>
											<th>Stream Name</th>
											<th>Course Pattern</th>
											<th>Course Duration</th>
											<th>Start Year</th>
											<tbody id="prgm_details"></tbody>
										</table>
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