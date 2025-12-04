<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    

$(document).ready(function()
{
	 // Num check logic
  	$('.numbersOnly').keyup(function () {
		
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
	
	$('#category').on('change', function () {
		//var school = $('#school').val();
		var school=($('#school').val()).split('||');
		var category = $('#category').val();
		if(category && school) 
		{
			type='POST',url='<?= base_url() ?>Master/get_stream_list_notin_school',datastring={school:school[1],category:category};
			html_content=ajaxcall(type,url,datastring);
			//alert(html_content);
			if(html_content!="")
			{
				$('#err_msg').html('');
				$('#streamlist').html(html_content);
				$('#show_list').show();
				$('#emptab').show();
			}
			else
			{
				$('#streamlist').html('');
				$('#show_list').hide();
				$('#emptab').hide();
				$('#err_msg1').hide();
				$('#err_msg').html('No Streams available for course '+$("#category option:selected").text()+' category');
				
				//$('#show_facilities').show();
			}
		}
		else 
		{
			$('#err_msg').html('Please select school and course category');
			$('#streamlist').html('');
			$('#emptab').hide();
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

var numberOfChecked =0;
function form_validate(event)
{
	numberOfChecked = $('input:checkbox[class=chk]:checked').length;

	if(numberOfChecked==0)
	{
		$('#err_msg').html('Please select stream Name or choose other course category.');
		return false;
	}
}

function count_ischecked()
{
	numberOfChecked = $('input:checkbox[class=chk]:checked').length;
	if(numberOfChecked==0)
		$('#err_msg1').html('you have not selected any stream in streams list.');
	else
		$('#err_msg1').html('you have selected '+numberOfChecked+' streams.');
}
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <!--<li class="active"><a href="<?=base_url($currentModule)?>">Fees Master </a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-5 text-ctext-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;School Streams Mapping</h1>
			<span id="flash-messages" style="color:Green;padding-left:10px;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
			<span id="flash-messages" style="color:red;padding-left:10px;">
				 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                   
				   <div class="panel-heading">
                        <span class="panel-title">Enter Details</span><span id="err_msg" style="color:red;padding-left:50px;"></span>
					</div>
					
                    <div class="panel-body">
							<div class="portlet-body form">
                          <form id="form" name="form" action="<?=base_url($currentModule.'/add_school_stream_submit')?>" method="POST" onsubmit="return form_validate(event)">
                             
                            <div class="col-md-6">
							<div class="well well-sm"><b>School And Course Category Details:</b></div>
                              <div class="form-group">
                                <label class="col-md-5 text-right">School</label>
                                <div class="col-md-7">
                                  <select id="school" name="school" class="form-control" required>
											  <option value="">select school</option>
											  <?php 
													if(!empty($school_details)){
														foreach($school_details as $coursename){
															?>
														  <option value="<?=$coursename['school_id'].'||'.$coursename['school_code'].'||'.$coursename['school_short_name']?>"><?=$coursename['school_name']?></option>  
														<?php 
															
														}
													}
											  ?>
                          </select>
                                </div>
                                
                              </div>
							  
							   <div class="form-group">
                                <label class="col-md-5 text-right">Course Category</label>
                                <div class="col-md-7">
                                  <select id="category" name="category" class="form-control" required>
											  <option value="">Select Course Category</option>
											   <?php 
													if(!empty($course_category_details)){
														foreach($course_category_details as $coursename){
															?>
														  <option value="<?=$coursename['cr_cat_id']?>"><?=$coursename['course_category']?></option>  
														<?php 
															
														}
													}
												  ?>
                                        </select>  
                                </div>
                                
                              </div>
                             
                              <div class="form-group">
                                <div class="col-md-3"></div>
                                <div class=" col-md-4">
                                  <button type="submit" class="btn btn-primary form-control" >Allocate</button>
                                </div>
                                   <div class="col-sm-4"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/school_stream'">Cancel</button></div>
                 
                              </div>
                            </div>
                          
                        
                        <div class="col-md-6" id="emptab" style="display:none"> 
						<div class="well well-sm"><b>Stream List:</b></div>
							<div class="col-md-12"  style="overflow-x:scroll;height:300px;">
								
								 <table id='myTable' class="table table-bordered" >
									<thead>
									<tr>
												<th>#</th>
												<th>Stream Name</th>
												<!--<th>Year</th>-->
										</tr>
									</thead>
									<tbody id="streamlist">
																  
									</tbody>
								</table>  
								
							</div>
							
						</div>
						</form>
						
                      </div>
					  
					  
                    </div>
					<div class="col-md-3"></div>
					<span id="err_msg1" style="color:red;padding-left:10px;"></span>
                </div>
            </div>
        </div>    
    </div>
    
</div>


<script>


</script>
