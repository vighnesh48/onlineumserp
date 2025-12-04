<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script>
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

function fullview_boarding(rid)
{
	//var academic=$('#academic').val();
	//$('#err_msg').html('');
	type='POST',url='<?= base_url() ?>Transport/get_bus_boarding_details',datastring={rid:rid};
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
		$('#blist').html("Boarding Points of Route Code "+array.bus_boarding_details[len-1].route_code+" :");	
		for(i=0;i<len;i++)
		{
			if(array.bus_boarding_details[i].details_id!=null)
			{
			content+='<tr><td>'+j+'</td><td>'+array.bus_boarding_details[i].boarding_point+'</td><td>'+array.bus_boarding_details[i].sequence_no+'</td><!--<td>'+array.bus_boarding_details[i].distance_from_campus+'</td><td>'+array.bus_boarding_details[i].pickup_timing+'</td><td>'+array.bus_boarding_details[i].drop_timing+'</td>--></tr>';
			j++;
			}
		}
		$('#bus_boarding_details').html(content);
		$('#detailcontent').show();
		//$("#myModal1").modal();
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
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Route List</h1>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_route")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>

		
        </div>

        <div class="row ">
		<h4 id="err_msg" style="color:red;padding-left:250px;"></h4>

		<h4 id="flash-messages" style="color:Green;padding-left:250px;">
		<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
		<h4 id="flash-messages" style="color:red;padding-left:250px;">
		<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
		 <?php
				if(!empty($route_details))
				{
					?>
            <div class="col-sm-6 pull-left" style="padding-right:0px;">
               <div class="panel">
             	<div class="panel-heading">
                    <span class="panel-title"><b>Details</b></span>
                </div>	
				<div class="panel-body" >
                
                   <div class="table-info" style="padding-right:0px;">
                    <table class="table table-bordered" style="max-width:100%;">
                        <thead>
						<tr>
                                    <th>#</th>
                                    
									<th>Name</th>
									
									<th>Code</th>
                                    
									
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                              <?php
							  
                            $j=1;                      
                            for($i=0;$i<count($route_details);$i++)
                            {
                                
								?>
								<tr>
									<td><?=$j?></td>                                                                
									<td><?=$route_details[$i]['route_name']?></td>
									
									<td><?=$route_details[$i]['route_code']?></td>
									
									<td><?php $campus='fullview_boarding('.$val['route_id'].',\''.$val['campus'].'\')';?>
									<a title="View boarding Details" class="btn btn-primary btn-xs" onclick="fullview_boarding(<?=$route_details[$i]['route_id']?>)" >View</a>
									<a title="Edit Route Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_route/".$route_details[$i]['route_id'])?>">Edit</a>
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
			   
			 
			</div>
		</div>
			<div class="col-sm-6 pull-right" style="padding-left:0px;display:none;" id="detailcontent">
               <div class="panel">
             	<div class="panel-heading">
                    
					<span class="panel-title" ><b id="blist">Details</b></span>
                </div>	
				<div class="panel-body" >
				<div class="table-info " >    
									
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
			   </div>
				
				
				
				
            </div>    
        </div>
		 <?php
				}else{
					?>
					<h4 style="color:red;padding-left:250px;">No Routes Are Available</h4>
					<?php
				}
				  ?>
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
								<center><h4>&nbsp;Route Boarding Details</h4></center>
							  </div>
							  <div class="modal-body">
												
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>

						  </div>
						</div>