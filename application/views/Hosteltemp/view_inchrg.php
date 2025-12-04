<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Hostel</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Incharge List</h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_inchrg")?>"><span class="btn-label icon fa fa-plus"></span>Add</a></div>                        
                    
                   
                </div>
            </div>
			<br/>
			<div class="pull-center col-xs-12 col-sm-auto">
			<span id="flash-messages" style="color:Green;padding-left:30px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
			</div>
        </div>


    
	<div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                       <div class="form-group">
						<!--<label  class="col-sm-3">Select Academic Year: <?=$astrik?></label>-->
						<div class="col-sm-4">
						  <select class="form-control" name="academic" id="academic" required>
							  <option value="">select Academic Year</option>
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
							<button class="btn btn-primary form-control" id="btn_submit" onclick="fetch_incharge_list()" >Submit</button>                                        
						</div>
						<span class="col-sm-6" style="color:red;padding-left:40px;" id="err_hcode"></span>
						
					</div>
                </div>
        <div class="panel-body" style="overflow-x:scroll;height:500px;">	
        
		<div id="r_details" style="display:none;" class="row">
		
			<div  class="col-sm-12" >
				<div class="table-info">    
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Hostel</th>
                                    <th>Name</th>
                                    <th>Responsibilty</th>
									<th>Mobile</th>
									<th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
						</tbody>
					</table>
				</div>
			</div>
			<br/><br/><br/>
			<div class="pull-left col-xs-12 col-sm-auto" style="padding-top: 20px;display:none;"><a id="edit_hrd" style="width: 100%;" class="btn btn-primary btn-labeled" href="#"><span class="btn-label icon fa fa-edit"></span>Edit </a></div>
			
		</div>
	</div>
	</div>
	</div>
	</div>
	</div>
</div>
<script>

$(document).ready(function()
{
	var id='<?=$this->uri->segment(3)?>';
	if(id!="")
	{
		$('#academic option').each(function()
		 {              
			 if($(this).val()== id)
			{
			$(this).attr('selected','selected');
			}
		});
		
		$("#btn_submit").trigger("click");
	}
  	
});

var academic="";
function fetch_incharge_list()
{
	academic=$('#academic').val();
	if(academic=="")
	{
		$('#err_hcode').html("Please select academic year!!");
	}
	else
	{
	//alert(h_id);
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Hostel/fetch_incharge_list',
			data: { academic: academic},
			success: function (html) {
				//alert(html);
				if(html!="")
				{
					$('#err_academic').html('');
					$('#itemContainer').html(html);
					//var link='<?=base_url($currentModule."/edit_flr_room_details/")?>';
					//link+='/'+h_id;
					//alert(link);
					//$("#edit_hrd").attr("href", link);
					$('#r_details').show();
				}
				else
				{
					$('#err_hcode').html('NO DATA');
					$('#r_details').hide();
				}
			}
		});
	}
}
</script>