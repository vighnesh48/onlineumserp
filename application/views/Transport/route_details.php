<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<script>
var html_content="",type="",url="",datastring="";


$(document).ready(function()
{
	var campus=$('#campus').val();
	
	$('#header_year').html(campus);
	
	$('#err_msg').html('');
	type='POST',url='<?= base_url() ?>Transport/get_route_boarding_details',datastring={campus:campus};
	html_content=ajaxcall(type,url,datastring);

	if(html_content!="")
	{
		$('#err_msg').html('');
		$('#itemContainer').html(html_content);
		$('#show_list').show();
		
		$('#excel').show();
	}
	else
	{
		$('#itemContainer').html('');
		$('#show_list').hide();
		$('#err_msg').html('Route Boarding mapping not yet done.');
		$('#excel').hide();
	}
		
	$('#campus').on('change', function () {
		var campus=$('#campus').val();
		if(campus=='')
		$('#header_year').html('ALL');
	else
		$('#header_year').html(campus);
	
		type='POST',url='<?= base_url() ?>Transport/get_route_boarding_details',datastring={campus:campus};
		html_content=ajaxcall(type,url,datastring);
		//alert(html_content);
		if(html_content!="")
		{
			$('#err_msg').html('');
			$('#itemContainer').html(html_content);
			$('#show_list').show();
			$('#excel').show();
		}
		else
		{
			$('#itemContainer').html('');
			$('#show_list').hide();
			$('#err_msg').html('No Boarding point are mapped to this Route');
			$('#excel').hide();
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

function fullview_boarding(rid,campus)
{
	//var academic=$('#academic').val();
	//$('#err_msg').html('');
	type='POST',url='<?= base_url() ?>Transport/get_bus_boarding_details',datastring={rid:rid,campus:campus};
	html=ajaxcall(type,url,datastring);
	if(html === "{\"bus_boarding_details\":null}")
	{
		$('#err_msg').html('Invalid Partner Id.'); 
		$('#maincontent').hide();
	}
	else
	{
		$('#err_msg').html('');
		var array=JSON.parse(html);
		var len=array.bus_boarding_details.length;
		//$('#pcode').html(array.route_boarding_details.campus);
		var content='',j=1;
			
		for(i=0;i<len;i++)
		{
			content+='<tr><td>'+j+'</td><td>'+array.bus_boarding_details[i].boarding_point+'</td><td>'+array.bus_boarding_details[i].sequence_no+'</td><!--<td>'+array.bus_boarding_details[i].distance_from_campus+'</td><td>'+array.bus_boarding_details[i].pickup_timing+'</td><td>'+array.bus_boarding_details[i].drop_timing+'</td>--></tr>';
			j++;
		}
		$('#bus_boarding_details').html(content);
		$("#myModal1").modal();
	}
	
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
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Boarding Bus details List</h1>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/route_boarding_mapping")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>

        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                    <div class="row">
						<div class="col-sm-8">
						<span class="panel-title"><b>For Campus:</b> <span id="header_year"></span></span>
						</div>
						
						<div class="col-sm-3 pull-right">
						  <select id="campus" name="campus"  class="form-control" required>
								  <option value="">Select campus</option>
								  <option selected value="NASHIK">Nashik</option>
								  <option value="SIJOUL">Sijoul</option>
						</select>
						</div>
												
						
					</div>
					
					
                </div>
				
                <div id="show_list" class="panel-body" style="display:none;">
				
				<h4 id="err_msg" style="padding-left:200px;color:red;"></h4>

				<h4 id="flash-messages" style="color:Green;padding-left:200px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
				</h4>
				<h4 id="flash-messages" style="color:red;padding-left:200px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
				</h4>

				
                    <div class="table-info">    
                    
                    <table class="table table-bordered" style="max-width:100%;">
                        <thead>
						<tr>
                                    <th>#</th>
									<th>Campus</th>
                                    <th>Route Name</th>
									<th>Route Code</th>
									<th>Bus Number</th>
									<th>Driver Name</th>
									<th>Vendor Name</th>
									<th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                                                      
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
								<center><h4>&nbsp;Route Boarding Details</h4></center>
							  </div>
							  <div class="modal-body">
									<table class="table table-bordered" style="width:100%;max-width:100%;">
										<thead>
										<tr>
											<th>#</th>
											<th>Boarding Point</th>
											<th>Route Order</th>
											<!--<th>Distance From campus</th>
											<th>Pickup Timing</th>
											<th>Drop Timing</th>
											-->
										</tr>
										</thead>
										<tbody id="bus_boarding_details">
																	  
										</tbody>
									</table>			
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>

						  </div>
						</div>

				
				
            </div>
			
            </div>    
        </div>
    </div>
</div>