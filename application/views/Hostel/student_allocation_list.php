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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Allocation List </h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_stdnt_faci_allocation")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>                        
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
			<br/><br/>
			<span id="flash-messages" style="color:Green;padding-left:210px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
               <div class="panel-heading">
                        <span class="panel-title">Student Allocation List</span>
                        <div class="holder"></div>
                </div>
                <div class="panel-body">
					<div class="row ">
							
						<div class="col-sm-12">   
							
								
									<div class="form-group">
										<label  class="col-sm-2">Select Hostel: <?=$astrik?></label>
										<div class="col-sm-3">
										  <select class="form-control" name="host_id" id="host_id" required>
										  <option value="">select Hostel</option>
										  <?php //echo "state".$state;exit();
											if(!empty($hostel_details)){
												foreach($hostel_details as $hostels){
													?>
												  <option value="<?=$hostels['host_id']?>"><?=$hostels['hostel_name']?></option>  
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
				
				
                    <div class="table-info" id="show_facilities" style="display:none;">    
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Hostel</th>
                                    <th>#Floor</th>
                                    <th>#Room</th>
                                    <th>Enrollment_no</th>
                                    <th>Name</th>
									<th>Instute</th>
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
var html_content="",type="",url="",datastring="";
function validation()
{
	var html_content="",type="",url="",datastring="";
	var host_id=$('#host_id').val();
	//alert(faci_id);
	if(host_id=="")
	{	
		$('#show_facilities').hide();
		$('#err_msg').html('Please select hostel!!');
	}
	else
	{
		$('#err_msg').html('');
		type='POST',url='<?= base_url() ?>Hostel/get_allocation_listbyhid',datastring={host_id: host_id};
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
			$('#err_msg').html('This Hostel Has Not Yet Alloted!!');
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
