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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Room details</h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    
                    <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_rms_details")?>"><span class="btn-label icon fa fa-plus"></span>Add</a></div>                        
                    
                    <!--<form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($hostel_details);$i++)
                                    {
                                ?>
                                <option value="<?=$hostel_details[$i]['host_id']?>"><?=$hostel_details[$i]['hostel_name']." [ ".$hostel_details[$i]['hostel_type']." ] "?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </form>-->
                   
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
						<label  class="col-sm-3">Select Hostel: <?=$astrik?></label>
						<div class="col-sm-4">
						  <select class="form-control" name="h_id" id="h_id" required>
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
						  </select></br>
						  <span style="color:red;" id="err_hcode"><?php echo form_error('host_id');?></span>
						</div>
						<div class="col-sm-3">
							<button class="btn btn-primary form-control" id="btn_submit" onclick="get_r_detailsbyhostid()" >Submit</button>                                        
						</div>
						
					</div>	
                </div>
                    <div class="panel-body" style="overflow-x:scroll;height:550px;">
	
	    
		
		
		<div id="r_details" style="display:none;" class="row">
			<div class="row" style="padding-bottom:5px;">
				<div  class="col-sm-12">
				<label class="col-sm-1"></label>
				<label class="col-sm-3">Name: <span id="name" style="font-weight:bold;"></span></label>
				<label class="col-sm-2">Code: <span style="font-weight:bold;" id="code"></span></label>
				<label class="col-sm-2">Type: <span style="font-weight:bold;" id="type"></span></label>
				<label class="col-sm-3">In Campus: <span style="font-weight:bold;" id="campus"></span></label>
				<label class="col-sm-1"></label>
				</div>
			</div>
			
			
			<div  class="col-sm-12" >
				<div class="table-info">    
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                   
                                    <th>Code</th>
                                    <th>#Floor</th>
                                    <th>#Room</th>
									<th>#Beds</th>
                                    <th>Room Type</th>
                                    <th>Category</th>
                                    
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
						</tbody>
					</table>
				</div>
			</div>
			<br/><br/><br/>
			<div class="pull-left col-xs-12 col-sm-auto" style="padding-top: 20px;"><a id="edit_hrd" style="width: 100%;" class="btn btn-primary btn-labeled" href="#"><span class="btn-label icon fa fa-edit"></span>Edit All</a>
			
			</div>
			<div class="pull-left col-xs-12 col-sm-auto" style="padding-top: 20px;"><a style="width: 100%;" class="btn btn-primary btn-labeled" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</a>
			
			</div>
			
			
			
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
		$('#h_id option').each(function()
		 {              
			 if($(this).val()== id)
			{
			$(this).attr('selected','selected');
			}
		});
		
		$("#btn_submit").trigger("click");
	}
	    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
	});
  	
});


var h_id="";

function get_r_detailsbyhostid()
{
	//alert("kdfhskuk");
	h_id=$('#h_id').val();
	if(h_id=="")
	{
		$('#err_hcode').html("Please select hostel!!");
	}
	else
	{
	//alert(h_id);
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Hostel/get_rms_detailsbyhid',
			data: { h_id: h_id},
			success: function (html) {
				//alert(html);
				if(html=='||||||||')
				{
					$('#r_details').hide();
					$('#err_hcode').html('No data!!');
					
				}
				else
				{
					$('#err_hcode').html('');
					var dtls=html.split("||");
					 $('#name').html(dtls[0]);
					 $('#code').html(dtls[1]);
					 var htype='';
					 if(dtls[2]=='B')
						 htype='Boys';
					 else
						 htype='Girls';
					 
					 var campus='';
					 if(dtls[3]=='Y')
						 campus='Yes';
					 else
						 campus='No';
					 
					 $('#type').html(htype);
					 $('#campus').html(campus);
					var content=dtls[4];
					$('#itemContainer').html(content);
					var link='<?=base_url($currentModule."/edit_flr_room_details/")?>';
					link+='/'+h_id;
					//alert(link);
					$("#edit_hrd").attr("href", link);
					$('#r_details').show();
				}
			}
		});
	}
}
</script>