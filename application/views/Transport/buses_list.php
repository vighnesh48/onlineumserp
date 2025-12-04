<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script>

$(document).ready(function()
{
	$("#campus").change(function()
	{            
		var campus=$('#campus').val();
		
			$('#err_msg').html('');
			type='POST',url='<?= base_url() ?>Transport/get_bus_details_by_campus',datastring={campus:campus};
			html_content=ajaxcall(type,url,datastring);
			//$('#err_msg').html(html_content);
			if(html_content!="")
			{
				$('#err_msg').html('');
				$('#itemContainer').html(html_content);
				//$('#show_list').show();
			}
			else
			{
				$('#itemContainer').html('');
				//$('#show_list').hide();
				$('#err_msg').html('No Data');
				//$('#show_facilities').show();
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
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Transport</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Buses List</h1>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_bus")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>

		
        </div>

        <div class="row ">
            <div class="col-sm-12">
               <div class="panel">
             	<div class="panel-heading">
                    <span class="panel-title"><b>Details</b></span>
					<div class="pull-right col-sm-3">
					<select id="campus" name="campus" class="form-control" required>
						<option value="">Select Campus</option>
						<option value="NASHIK">NASHIK</option>
						<option value="SIJOUL">SIJOUL</option>
					  
					</select>
					</div>
                </div>	
				<div class="panel-body" >
				<h4 id="err_msg" style="color:red;padding-left:250px;"></h4>
                <h4 id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
				<h4 id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
				
				<?php
				if(!empty($bus_details))
				{
					?>
				
                    <div class="table-info">    
                    
                    <table class="table table-bordered" style="max-width:100%;">
                        <thead>
						<tr>
                                    <th>SL.NO</th>
                                    <th>Campus</th>
									<th>Vendor</th>
									<th>Bus Number</th>
									<th>Bus Company</th>
									<th>Bus Model No.</th>
									<th>Manufacture Year</th>
									<th>Capacity</th>
                                    <th>Active</th>
									
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                              <?php
							  
                            $j=1;                      
                            for($i=0;$i<count($bus_details);$i++)
                            {
                                if($bus_details[$i]['is_active']=='Y'){
								?>
								<tr>
									<td><?=$j?></td>
									<td><?=$bus_details[$i]['campus']?></td>  
									<td><?=$bus_details[$i]['vendor_name']?></td> 
									<td><?=$bus_details[$i]['bus_no']?></td>
									<td><?=$bus_details[$i]['bus_company']?></td>
									<td><?=$bus_details[$i]['bus_model_no']?></td>
									<td><?=$bus_details[$i]['manufacture_year']?></td>
									<td><?=$bus_details[$i]['capacity']?></td>
									<td><?=$bus_details[$i]['is_active']=='Y'?Yes:No?></td>
									<td>
									   <a title="Edit Bus Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_bus/".$bus_details[$i]['bus_id'])?>">Edit</a>
									</td>
								</tr>
								<?php
								$j++;
							}
								
                            }
                            ?>   
							<?php
							  
                            $k=$j;                      
                            for($i=0;$i<count($bus_details);$i++)
                            {
                                if($bus_details[$i]['is_active']=='N'){
								?>
								<tr <?php if($bus_details[$i]['is_active']=='N'){ echo "style='color:pink'";}?>>
									<td><?=$k?></td>
									<td><?=$bus_details[$i]['campus']?></td>  
									<td><?=$bus_details[$i]['vendor_name']?></td> 
									<td><?=$bus_details[$i]['bus_no']?></td>
									<td><?=$bus_details[$i]['bus_company']?></td>
									<td><?=$bus_details[$i]['bus_model_no']?></td>
									<td><?=$bus_details[$i]['manufacture_year']?></td>
									<td><?=$bus_details[$i]['capacity']?></td>
									<td><?=$bus_details[$i]['is_active']=='Y'?Yes:No?></td>
									<td>
									   <a title="Edit Bus Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_bus/".$bus_details[$i]['bus_id'])?>">Edit</a>
									</td>
								</tr>
								<?php
								$k++;
							}
								
                            }
                            ?>							
                        </tbody>
                    </table>                    
                   
                </div>
				<div class="pull-right col-xs-2 col-sm-auto">
				<a class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/bus_list_excel")?>">Excel </a></div>
				<?php
							
                            }
							else
							{
                            ?> 
							
							<h4 id="err_msg" style="color:red;padding-left:250px;">No Buses Available</h4>
							<?php
							}
							?>
				   </div>
                </div>
            </div>
			
            </div>    
        </div>
    </div>
</div>

