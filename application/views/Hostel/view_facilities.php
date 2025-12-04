<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Fee Master</h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_facility")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
			
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>
       
        <div class="row">
            <div class="col-sm-12">
                <div class="panel">
               <div class="panel-heading">
                        <div class="row ">
							
						<div class="col-sm-12">   
							
								
									<div class="form-group">
										
										<div class="col-sm-3">
										  <select class="form-control" name="academic" id="academic" required>
											  <option value="">Select Academic Year</option>
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
										
										<div class="col-sm-3">
										  <select class="form-control" name="faci_id" id="faci_id" required>
											  <option value="">select Type</option>
											  <?php //echo "state".$state;exit();
												if(!empty($facilities_types)){
													foreach($facilities_types as $types){
														?>
													  <option value="<?=$types['faci_id']?>"><?=$types['facility_name']?></option>  
													<?php 
														
													}
												}
											  ?>
										  </select>
										</div>
										<div class="col-sm-2">
											<button class="btn btn-primary form-control" onclick="validation()" id="btn_submit" >Submit</button>                                     
										</div> 
									</div>
									
									
						</div>
					</div>
                </div>
                <div class="panel-body" style="overflow-x:scroll;height:500px;">
					
				
				
                    <div class="table-info" id="show_facilities"  style="display:none;">    
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Deposit Fee</th>
                                    <th>Facility Fee</th>
                                    <th>Hostel Type</th>
                                    <th>Academic Year</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                                                       
                        </tbody>
                    </table>                    
                   
                </div>
				
				<div class="row">
					<span id="err_msg" style="color:red;padding-left:200px;"></span>
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
	var id='<?=$this->uri->segment(4)?>',academic='<?=$this->uri->segment(3)?>';
	if(id!="" && academic!="")
	{
		$('#faci_id option').each(function()
		 {              
			 if($(this).val()== id)
			{
			$(this).attr('selected','selected');
			}
		});
		$('#academic option').each(function()
		 {              
			 if($(this).val()== academic)
			{
			$(this).attr('selected','selected');
			}
		});
		$("#btn_submit").trigger("click");
	}
	
	   
});


var html_content="",type="",url="",datastring="";
function validation()
{
	var html_content="",type="",url="",datastring="";
	var faci_id=$('#faci_id').val();
	var academic=$('#academic').val();
	//alert(faci_id);
	if(academic=="")
	{	
		$('#show_facilities').hide();
		$('#err_msg').html('Please select academic!!');
	}
	else if(faci_id=="")
	{	
		$('#show_facilities').hide();
		$('#err_msg').html('Please select facility type!!');
	}
	else
	{
		$('#err_msg').html('');
		type='POST',url='<?= base_url() ?>Hostel/getallfailities',datastring={faci_id: faci_id,academic:academic};
		html_content=ajaxcall(type,url,datastring);
		//alert(html_content);
		if(html_content!="")
		{
			$('#err_msg').html('');
			$('#itemContainer').html(html_content);
			$('#show_facilities').show();
		}
		else
		{
			$('#show_facilities').hide();
			$('#err_msg').html('No Data');
			//$('#show_facilities').show();
		}
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
