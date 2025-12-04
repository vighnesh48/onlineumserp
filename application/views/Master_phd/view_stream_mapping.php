<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<script>
var html_content="",type="",url="",datastring="";


$(document).ready(function()
{
	/* var academic='<?=$_GET['academic']?>';
	
	//alert(campus);
	if(academic!="" && campus!="")
	{
		$('#academic option').each(function()
		 {              
			 if($(this).val()== academic)
			{
			$(this).attr('selected','selected');
			}
		});
		
		$("#btn_submit").trigger("click");
	}
	
	//alert($('#academic').val());
	$('#header_year').html($('#academic').val());
	var academic=$('#academic').val();
	$('#err_msg').html('');
	type='POST',url='<?= base_url() ?>Master/get_academic_fees_details',datastring={academic:academic};
	html_content=ajaxcall(type,url,datastring);
	//alert(html_content);
	if(html_content!="")
	{
		$('#err_msg').html('');
		$('#itemContainer').html(html_content);
		$('#show_list').show();
		$('#report').attr('href','<?=base_url()?>Master/academic_fee_details_excelReports/'+academic);
		$('#excel').show();
	}
	else
	{
		$('#itemContainer').html('');
		$('#show_list').hide();
		$('#err_msg').html('No Data');
		$('#excel').hide();
	}
		
	 */
});

$('#academic').on('change', function () {
		var school = $(this).val();
		//$('#header_year').html(academic);
		type='POST',url='<?= base_url() ?>Master/get_stream_mapping_details',datastring={school:school};
		html_content=ajaxcall(type,url,datastring);
		alert(html_content);
		if(html_content!="")
		{
			$('#err_msg').html('');
			$('#itemContainer').html(html_content);
			$('#show_list').show();
			//$('#report').attr('href','<?=base_url()?>Master/academic_fee_details_excelReports/'+school);
			$('#excel').show();
		}
		else
		{
			$('#itemContainer').html('');
			$('#show_list').hide();
			$('#err_msg').html('No Data');
			$('#excel').hide();
		}
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
        <li class="active"><a href="<?=base_url($currentModule)?>">Stream Mapping </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Stream Mapping </h1><span id="err_msg" style="color:red;"></span>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_stream_mapping")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>

			<span id="flash-messages" style="color:Green;">
			<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
			<span id="flash-messages" style="color:red;">
			<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                 <div class="panel-heading">
                    <div class="row">
						<div class="col-sm-6">			
						</div>
						<div class="col-sm-2">
						<b>School Name:</b>
						</div>
						<div class="col-sm-4 pull-right">
						  <select class="form-control" name="academic" id="academic" required>
							  <option value="">select School Name</option>
							   <?php //echo "state".$state;exit();
								if(!empty($school_details)){
									foreach($school_details as $types){
										?>
									  <option value="<?=$types['school_id']?>"><?=$types['school_short_name']?></option>  
									<?php 
										
									}
								}
							  ?>
						  </select>
						</div>
												
						
					</div>
					
					
                </div>
				
                <div id="show_list" class="panel-body">
                    <div class="table-info"  style="overflow-x:scroll;height:550px;">    
                    
                    <table class="table table-bordered" style="width:100%;max-width:100%;">
                        <thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Short Name</th>
								<th>Is Active</th>
								<th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                        <?php
							  
                            $j=1;                      
                            for($i=0;$i<count($course_details);$i++)
                            {
								?>
								<tr>
									<td><?=$j?></td>                                                                
									<td><?=$course_details[$i]['course_name']?></td>
									<td><?=$course_details[$i]['course_short_name']?></td>
																
									<td><?=$course_details[$i]['is_active']?></td>
									
									<td>
									   <a title="Edit Academic Session Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_course/".$course_details[$i]['course_id'])?>">Edit</a>
									 <!-- 
									   <a style="width: 30%;" title="View Hostel Room Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/view_room_details?id=".$course_details[$i]['host_id'])?>" style="padding-left: 5px;">Room</a>
									   
									   <a style="width: 25%;" title="View Hostel's Allocation Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/hostel_allocation_view?id=".$course_details[$i]['host_id'])?>" style="padding-left: 5px;">View</a>
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
                </div>
            </div>
			
            </div>    
        </div>
    </div>
</div>