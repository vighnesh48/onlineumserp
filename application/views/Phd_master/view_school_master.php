<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<script>
var html_content="",type="",url="",datastring="";

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

function fullview_school(id)
{
	type='POST',url='<?= base_url() ?>Master/get_school_details',datastring={id:id};
	html_content=ajaxcall(type,url,datastring);
	//alert(html_content);
	var array=JSON.parse(html_content);
	var len=array.school_details.length;
	$('#scode').html(array.school_details.school_code);
	$('#sname').html(array.school_details.school_name);
	$('#ssname').html(array.school_details.school_short_name);
	$('#campus').html(array.school_details.campus);
	$('#stype').html(array.school_details.school_type);
	$('#cperson').html(array.school_details.contact_person);
	$('#address').html(array.school_details.school_address);
	
	$('#contact').html(array.school_details.contact_no);
	$('#mobile').html(array.school_details.mobile_no);
	$('#semail').html(array.school_details.school_email);
	$('#cemail').html(array.school_details.contact_email);
	$('#syear').html(array.school_details.start_year);
	
	var status='';
		if(array.school_details.is_active=='Y')
			status='yes';
		else
			status='No';
		$('#status').html(status);
	
	$("#myModal1").modal();
}
</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
       <!-- <li class="active"><a href="<?=base_url($currentModule)?>">School </a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; School Details </h1><span id="err_msg" style="color:red;"></span>
			<div class="pull-right col-xs-4 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_school")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>

			<span id="flash-messages" style="color:Green;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title"><b>List </b></span>
                </div>
				<!-- Modal -->
						<div id="myModal1" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content" style="width:800px;">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<center><h4>&nbsp;School Details</h4></center>
							  </div>
							  <div class="modal-body">
									<table class="table table-bordered">
										 <tr>
										  <th scope="col">School Code:</th>
										  <td><span id="scode"></span></td>
										  <th scope="col">School Name :</th>
										  <td><span id="sname"></span></td>
										</tr>   
										<tr>
										  <th scope="col">School Short Name:</th>
										  <td><span id="ssname"></span></td>
										   <th scope="col">Campus:</th>
										   <td><span id="campus"></span></td>
										</tr>
										
										<tr>
										  <th scope="col">School Type:</th>
										  <td><span id="stype"></span></td>
										  <th scope="col">Contact Person:</th>
										  <td><span id="cperson"></span></td>
										</tr>
										
										 <tr >
										  <th scope="col">School Address:</th>
										  <td><span id="address"></span></td>
										  <th scope="col">Contact No.:</th>
										  <td><span id="contact"></span></td>
										  </tr> 
										  
										  <tr >
										  <th scope="col">Mobile No.:</th>
										  <td><span id="mobile"></span></td>
										  <th scope="col">School Email:</th>
										  <td><span id="semail"></span></td>
										  </tr>
										   <tr >
										  <th scope="col">Contact Email:</th>
										  <td><span id="cemail"></span></td>
										  <th scope="col">Start Year:</th>
										  <td><span id="syear"></span></td>
										  </tr>
										  <tr >
										  
										  <th scope="col">Is Active:</th>
										  <td><span id="status"></span></td>
										  </tr>
										
										</table>				
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>

						  </div>
						</div>
						
                <div id="show_list" class="panel-body"  style="overflow-x:scroll;height:550px;">
                    <div class="table-info">    
                    
                    <table class="table table-bordered" style="width:100%;max-width:100%;">
                        <thead>
						<tr>
                                    <th>#</th>
                                    
									<th>Code</th>
									
									<th>Name</th>
                                    <th>Short Name</th>
									<th>Campus</th>
									<th>Type</th>
									<th>Start Year</th>
									<th>View</th>
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                              <?php
							  
                            $j=1;                      
                            for($i=0;$i<count($school_details);$i++)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>                                                                
                                <td><?=$school_details[$i]['school_code']?></td>
                                
                                <td><?=$school_details[$i]['school_name']?></td>
								<td><?=$school_details[$i]['school_short_name']?></td>
                                <td><?=$school_details[$i]['campus']?></td>
								<td><?=$school_details[$i]['school_type']?></td>
                                <td><?=$school_details[$i]['start_year']?></td>
                                 <td><a title="Edit Academic Year Details" class="btn btn-primary btn-xs" onclick="fullview_school('<?=$school_details[$i]['school_id']?>')">View</a></td>
                                <td>
								   <a title="Edit School Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_school/".$school_details[$i]['school_id'])?>">Edit</a>
								 <!-- 
								   <a style="width: 30%;" title="View Hostel Room Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/view_room_details?id=".$school_details[$i]['host_id'])?>" style="padding-left: 5px;">Room</a>
								   
								   <a style="width: 25%;" title="View Hostel's Allocation Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/hostel_allocation_view?id=".$school_details[$i]['host_id'])?>" style="padding-left: 5px;">View</a>
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