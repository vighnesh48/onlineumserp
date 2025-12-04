<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<script>
var html_content="",type="",url="",datastring="";

$(document).ready(function()
{
	var campus=$('#campus').val();
	var academic=$('#academic').val();
	$('#header_year').html(campus);
	
	$('#err_msg').html('');
	check_boarding_fee_exists(campus,academic);
		
	$('#campus').on('change', function () {
		var campus=$('#campus').val();
		var academic=$('#academic').val();
		check_boarding_fee_exists(campus,academic);
	});
	
	$('#academic').on('change', function () {
		var campus=$('#campus').val();
		var academic=$('#academic').val();
		check_boarding_fee_exists(campus,academic);
	});
}); 

function check_boarding_fee_exists(campus,academic)
{
	type='POST',url='<?= base_url() ?>Transport/get_boarding_feedetails',datastring={campus:campus,academic:academic};
	html_content=ajaxcall(type,url,datastring);
	//alert(html_content);
	if(html_content!="")
	{
		$('#err_msg').html('');
		$('#itemContainer').html(html_content);
		$('#show_list').show();
		var links='<?=base_url($currentModule."/edit_all_boardingfee_details")?>';
		links +='/'+campus+'/'+academic;
		//alert(link);
		$("#edit_hrd").attr("href", links);
		$('#show_edit_all').show();
		
		$('#excelcampus').val(campus);
		$('#excelacademic').val(academic);
		$('#excel').show();
		
		$('#pdfcampus').val(campus);
		$('#pdfacademic').val(academic);
		
		$('#pdf').show();
	}
	else
	{
		$('#itemContainer').html('');
		$('#show_list').hide();
		$('#err_msg').html('Boarding fee details have not yet done.');
		$("#edit_hrd").attr("href", '');
		$('#show_edit_all').hide();
		$('#pdf').hide();
		$('#excel').hide();
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
		<li class="active"><a href="<?=base_url($currentModule)?>">Transport </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Boarding Fee Details List</h1>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_boarding_fees")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>

        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                    <div class="row">
						<div class="col-sm-3">
						<select id="campus" name="campus"  class="form-control" >
								  <option value="">Select Campus</option>
								  <?php //echo "state".$state;exit();
                                        if(!empty($campus)){
                                            foreach($campus as $campusname){
                                                ?>
                                              <option value="<?=$campusname['campus_name']?>"><?=$campusname['campus_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
						</select>
						</div>
						<div class="col-sm-3">
						<select id="academic" name="academic" class="form-control" >
							<option value="">Select Academic Year</option>
									   
							<?php //echo "state".$state;exit();
							if(!empty($academic_details)){
								foreach($academic_details as $academic){
									/* $arr=explode("-",$academic['academic_year']);
									$ac_year=$arr[0]; */
									if($academic['status']=='Y')
									{
									?>
								  <option selected value="<?=$academic['academic_year']?>"><?=$academic['academic_year']?></option>  
								<?php 
									}else{
									?>
									<option value="<?=$academic['academic_year']?>"><?=$academic['academic_year']?></option> 
									<?php
									}
									
								}
							}
							?>
						</select>
						</div>
						<div class="btn-group col-sm-1  pull-right" id="pdf">
							<form id="form" name="form" action="<?=base_url($currentModule.'/fee_details_pdfReports')?>" method="POST" >
							<input type="hidden" name="pdfacademic" id="pdfacademic" />
							<input type="hidden" name="pdfcampus" id="pdfcampus" />
							<button class="btn btn-primary form-control" id="btn_submit" type="submit" >PDF</button>
							</form>
							</div>
							<div class="btn-group col-sm-1  pull-right" id="excel">
							<form id="form" name="form" action="<?=base_url($currentModule.'/fee_details_excelReports')?>" method="POST" >
							<input type="hidden" name="excelacademic" id="excelacademic" />
							<input type="hidden" name="excelcampus" id="excelcampus" />
							<button class="btn btn-primary form-control" id="btn_submit" type="submit" >Excel</button>
							</form>
						  </div>
						
					</div>
					
					
                </div>
				<div class="row ">
				<div class="col-sm-12">
				<h4 id="err_msg" style="padding-left:250px;color:red;"></h4>
							
				<h4 id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
				<h4 id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
				</div>
				</div>
                <div id="show_list" class="panel-body" style="display:none;">
                    <div class="table-info">    
                    
                    <table class="table table-bordered" >
                        <thead>
						<tr>
                                    <th>#</th>
									<th>Boarding Point</th>
                                    <th>Transport Fees</th>
									<th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                                                      
                        </tbody>
                    </table>                    
                   
                </div>
                </div>
								
				<div class="panel-body" id="show_edit_all">
					<a id="edit_hrd" class="btn btn-primary btn-labeled" ><span class="btn-label icon fa fa-edit"></span>Edit All</a>
				
				</div>
				
				
            </div>
			
            </div>    
        </div>
    </div>
</div>