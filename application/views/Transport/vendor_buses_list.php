<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<script>
var html_content="",type="",url="",datastring="";

$(document).ready(function()
{
	$('#header_year').html('All');

	$('#err_msg').html('');
	type='POST',url='<?= base_url() ?>Transport/get_vendor_bus_details',datastring={id:''};
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
		$('#err_msg').html('vender buses mapping not yet done.');
		$('#excel').hide();
	}
		
	$('#vendor').on('change', function () {
		var vendor=$('#vendor').val();
		if(vendor=='')
			$('#header_year').html('All');
		else
			$('#header_year').html($("#vendor option:selected").text());
		type='POST',url='<?= base_url() ?>Transport/get_vendor_bus_details',datastring={id:vendor};
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
			$('#err_msg').html('No Buses are mapped to this vender');
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
</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
		<li class="active"><a href="<?=base_url($currentModule)?>">Transport</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Vendor Buses List</h1>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_bus")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>

        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                    <div class="row">
						<div class="col-sm-8">
						<span class="panel-title"><b>For Vendor:</b> <span id="header_year"></span></span>
						<span id="err_msg" style="padding-left:40px;color:red;"></span>
						
			<span id="flash-messages" style="color:Green;padding-left:50px;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
			</span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
			</span>
						</div>
						
						<div class="col-sm-3 pull-right">
						  <select id="vendor" name="vendor" onchange="generate_prg_code()" class="form-control" required>
							  <option value="">select vendor</option>
							  <?php 
									if(!empty($vendor_details)){
										foreach($vendor_details as $coursename){
											?>
										  <option value="<?=$coursename['vendor_id']?>"><?=$coursename['vendor_name']?></option>  
										<?php 
											
										}
									}
							  ?>
                          </select>
						</div>
												
						
					</div>
					
					
                </div>
				
                <div id="show_list" class="panel-body" style="display:none;">
                    <div class="table-info">    
                    
                    <table class="table table-bordered" style="max-width:100%;">
                        <thead>
						<tr>
                                    <th>#</th>
									<th>Campus</th>
                                    <th>Vendor Name</th>
									<th>Bus Number</th>
									<th>Capacity</th>
									
									<!--<th>Action</th>-->
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                                                      
                        </tbody>
                    </table>                    
                   
                </div>
                </div>
            </div>
			
            </div>    
        </div>
    </div>
</div>