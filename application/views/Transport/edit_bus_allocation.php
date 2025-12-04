<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
		
		$('#ptime').timepicker({ 'Default': 'now' });
			
		$('#dtime').timepicker({ 'Default': 'now' });
		
        $('#form').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: 
            {
                
				campus:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Campus'
                      },
                      required: 
                      {
                       message: 'Please Select Campus'
                      }
                     
                    }
                },
				rname:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Route Name'
                      },
                      required: 
                      {
                       message: 'Please Enter Route Name'
                      }
                     
                    }
                },
               bus:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Bus'
                      },
                      required: 
                      {
                       message: 'Please Select Bus'
                      }
                     
                    }
                }
            }       
        })
		
		
		$('.alphaonly').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z ]/g,'') ); }
		);
		$('.alphanum').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^A-Z0-9 ]/g,'') ); }
		);
		
		$('.numbersOnly').keyup(function () {
		
		if (this.value != this.value.replace(/[^0-9]/g, '')) {
		   this.value = this.value.replace(/[^0-9]/g, '');
		} 
		});
		
		$('#bus').on('change', function () {
			common_call();
		});
		
		
		var is_active='<?=$allocatedbus_details['is_active']?>';
	$('#is_active option').each(function()
	{
		//alert($(this).val()+'===='+is_active);
		if($(this).val()== is_active)
		{
			$(this).attr('selected','selected');
		}
	});
	
	
	var route='<?=$allocatedbus_details['route_id']?>';
	$('#route option').each(function()
	{
		if($(this).val()== route)
		{
			$(this).attr('selected','selected');
		}
	});
	
	var ptiming='<?=$allocatedbus_details['pickup_time']?>';
	var newpickuptime=ptiming.split(",");
	for(i=0;i<newpickuptime.length;i++)
	{
	$(".input_fields_wrap").append('<div><input type="hidden" name="pickuptiming[]" value="'+newpickuptime[i]+'"/><a class="remove_field">'+newpickuptime[i]+' <img style="height:15px;width: 18px;" src="<?=site_url()?>assets/images/closeButton.gif" alt="delete image"></a></div>');
	}
	
	
	var dtiming='<?=$allocatedbus_details['departure_time']?>';
	var newdroptime=dtiming.split(",");
	for(i=0;i<newdroptime.length;i++)
	{
	$(".input_drop_wrap").append('<div><input type="hidden" name="droptiming[]" value="'+newdroptime[i]+'"/><a class="dremove_field">'+newdroptime[i]+' <img style="height:15px;width: 18px;" src="<?=site_url()?>assets/images/closeButton.gif" alt="delete image"></a></div>');
	}
    });

	
	
	
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Transport</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm">
			<i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Bus Allocation </h1>
			
        </div>
        
        <div class="row ">
            <div class="col-sm-6"  style="padding-right:5px;">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter Details</span>
							
                    </div>
                    <div class="panel-body">
					<span style="color:red;padding-left:40px;" id="err_msg"></span>
							<span style="color:red;padding-left:40px;" id="err_msg1"></span>
							
			<span id="flash-messages" style="color:Green;padding-left:50px;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
			</span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
			</span>
                        <div class="table-info">                            
                          <?//=var_dump($allocatedbus_details)?>
                            <form id="form" name="form" action="<?=base_url($currentModule.'/edit_bus_allocation_submit/'.$this->uri->segment(3))?>" method="POST" onsubmit="return validate_faci_category(event)">     
							<div class="form-group">
							<label class="col-sm-4">Academic Year <?=$astrik?></label>
							<div class="col-sm-6">
							<select id="academic" name="academic" class="form-control" >
								<option value="">Select Academic Year</option>
						<?php 
						if(!empty($academic_details)){
							foreach($academic_details as $academic){
								$arr=explode("-",$academic['academic_year']);
								$ac_year=$arr[0];
								if($allocatedbus_details['academic_year']===$ac_year)
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
							</div>
							<!--<div class="form-group">
                                    <label class="col-sm-4">Campus <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="campus" name="campus"  onchange="check_route_exists()"  class="form-control" required>
											  <option value="">Select campus</option>
											  <option value="NASHIK">Nashik</option>
											  <option value="SIJOUL">Sijoul</option>
                                    </select>
                                    </div>                                  
                                    <div class="col-sm-6"><span style="color:red;"><?php echo form_error('campus');?></span></div>
                                </div>-->                                                            
                                <div class="form-group">
                                    <label class="col-sm-4">Route Name <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="route" name="route"  class="form-control" required>
										<option value="">Select Route</option>
											  <?php 
											if(!empty($route_details)){
												foreach($route_details as $coursename){
												if($allocatedbus_details['route_id']==$coursename['route_id'])
												{
												?>
											  <option selected value="<?=$coursename['route_id']?>"><?=$coursename['route_name']?></option> 
											<?php 
												}else{
												?>
												<option value="<?=$coursename['route_id']?>"><?=$coursename['route_name']?></option> 
												<?php
												}
												  
											
													
												}
											}
									  ?>
                                    </select>
                                    </div>                                    
                                    <div class="col-sm-6"><span style="color:red;"><?php echo form_error('rname');?></span></div>
                                </div>
                               
								<div class="form-group">
                                    <label class="col-sm-4">Select Bus <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="bus" name="bus"  class="form-control" required>
										<option value="">Select Bus</option><?php 
											if(!empty($bus_details)){
												foreach($bus_details as $bus){
												if($allocatedbus_details['bus_id']==$bus['bus_id'])
												{
												?>
												 <option selected value="<?=$bus['bus_id'].'||'.$bus['vendor_id'].'||'.$bus['bus_no']?>"><?=$bus['bus_no']?></option>
											 
											<?php 
												}else{
												?>
											 <option value="<?=$bus['bus_id'].'||'.$bus['vendor_id'].'||'.$bus['bus_no']?>"><?=$bus['bus_no']?></option>
												<?php
												}

												}
											}
									  ?>
									  </select>
                                    </div>                                    
                                    <div class="col-sm-6"><span style="color:red;"><?php echo form_error('bus');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4">Select Driver<?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                         <select class="form-control" name="did" id="did" required>
                                      <option value="">Select driver</option>
									  <?php 
											if(!empty($driver_details)){
												foreach($driver_details as $driver){
												if($allocatedbus_details['driver_id']==$driver['driver_id'])
												{
												?>
												 <option selected value="<?=$driver['driver_id']?>"><?=$driver['driver_name']?></option>
											 
											<?php 
												}else{
												?>
											 <option  value="<?=$driver['driver_id']?>"><?=$driver['driver_name']?></option>
												<?php
												}

												}
											}
									  ?></select>
                                    </div>                                    
                                    <div class="col-sm-6"><span style="color:red;"><?php echo form_error('did');?></span></div>
                                </div>	
							<div class="form-group">
							<label class="col-sm-4">Pick Up Timings<?=$astrik?></label>  
							
							 <div class="col-sm-6 input_fields_wrap" style="height:80px; border: 1px solid;overflow-y:scroll;">
							</div>
								<input type="button" class="pull-right" value="Add Pickup time" onclick="display_ptime_div()">
							</div>
							
							<div class="form-group" id="pickuptime" style="display:none;">
								
								<div class="col-sm-2 pull-right">
								<button class="add_field_button pull-right">Add</button>
								</div>
								<div class="col-sm-4 pull-right">
								<input id="ptime" name="ptime"  type="text" class=" form-control" autocomplete="off">
								</div>
							</div>
							
							<div class="form-group">
							<label class="col-sm-4">Departure Timings<?=$astrik?></label>  
							
							 <div class="col-sm-6 input_drop_wrap" style="height:80px; border: 1px solid;overflow-y:scroll;">
							</div>
								<input type="button" class="pull-right" value="Add Drop time" onclick="display_dtime_div()">
							</div>
							
							<div class="form-group" id="droptime" style="display:none;">
								
								<div class="col-sm-2 pull-right">
								<button class="add_drop_button pull-right">Add</button>
								</div>
								<div class="col-sm-4 pull-right">
								<input id="dtime" name="dtime"  type="text" class=" form-control" autocomplete="off">
								</div>
							</div>
							
							<div class="form-group">
                                    <label class="col-sm-4">Is Active? <?=$astrik?></label>                                    
                                    <div class="col-sm-6">
                                        <select id="is_active" name="is_active" class="form-control" required>
											  <option value="">Select Status</option>
											  <option value="Y">Yes</option>
											  <option value="N">No</option>
                                    </select>
                                    </div>                                  
                                    <div class="col-sm-6"><span style="color:red;"><?php echo form_error('is_active');?></span></div>
                                </div>
							
                                <div class="form-group">
                                   
                                    <div class="col-sm-4">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update </button>                                        
                                    </div>                                    
                                    <div class="col-sm-4"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/bus_allocation_list')?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div> 
			<!--
			<div class="col-sm-6" style="padding-left:5px;">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Bus Allocated List</span>
							
                    </div>
                    <div class="panel-body" style="padding-left:2px;">
				
					<table class="table table-bordered" >
							<thead>
							<tr>
						
							<th>#</th>
							<th>Bus Number</th>
							<th>Route</th>
							
							<th>Driver</th>
							<th>Pickup Time</th>
							<th>Departure Time</th>
							<th>Action</th>
								</tr>
							</thead>
							<tbody id="itemContainer">
									<?php $i=1;
						if(!empty($allocatedbus_details)){
							foreach($allocatedbus_details as $bus){
							?>	<tr>
									
									<td><?=$i?></td>
									<td><?=$bus['bus_no']?></td>
									<td><?=$bus['route_name']?></td>
									<td><?=$bus['driver_name']?></td>
									<td><?=$bus['pickup_time']?></td>
									<td><?=$bus['departure_time']?></td>
									<td><a title="Edit Allocation Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_bus_allocation/".$bus['driver_bus_id'])?>">Edit</a></td>
								</tr>
								<?php	$i++;}

								}
							?>						
							</tbody>
						</table> 
					</div>
					
				</div>
				
			</div>
-->

			
        </div>
    </div>
</div>


<script>

function display_ptime_div()
{
	$('#pickuptime').show();
}

function display_dtime_div()
{
	$('#droptime').show();
}

$(document).ready(function() {
   // var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
	
	var dwrapper         = $(".input_drop_wrap"); //Fields wrapper
    var dadd_button      = $(".add_drop_button"); //Add button ID
    
    //var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
       // if(x < max_fields){ //max input box allowed
          //  x++; //text box increment
		  var newpickuptime=$('#ptime').val();
            $(wrapper).append('<div><input type="hidden" name="pickuptiming[]" value="'+newpickuptime+'"/><a class="remove_field">'+newpickuptime+' <img style="height:15px;width: 18px;" src="<?=site_url()?>assets/images/closeButton.gif" alt="delete image"></a></div>'); //add input box
			
			$('#pickuptime').hide();
        //}
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); //x--;
    })
	
	$(dadd_button).click(function(e){ //on add input button click
        e.preventDefault();
       // if(x < max_fields){ //max input box allowed
          //  x++; //text box increment
		  var newdroptime=$('#dtime').val();
            $(dwrapper).append('<div><input type="hidden" name="droptiming[]" value="'+newdroptime+'"/><a class="dremove_field">'+newdroptime+' <img style="height:15px;width: 18px;" src="<?=site_url()?>assets/images/closeButton.gif" alt="delete image"></a></div>'); //add input box
			$('#droptime').hide();
        //}
    });
    
    $(dwrapper).on("click",".dremove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); //x--;
    })
});

var status=0,error_status=0,type='',url='',datastring={};
function check_route_exists()
{
	var rname=$('#rname').val();
	var rcode=$('#rcode').val();
	$('#err_msg').html('');
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Transport/check_route_exists',
				data: {rname:rname},
				success: function (html) {
					//alert(html);
					if(html>0)
					{$('#err_msg1').html("This route name is already there.");status=1;}
				else
					{$('#err_msg1').html("");status=0;}
				}
		});
}

function validate_faci_category(events)
{
	if(status==1)
	{ return false;}
}

function common_call()
{
	var bus_data=$('#bus').val();
	var arr=bus_data.split("||");
	var bus_id = arr[0];
	var vendor = arr[1];
	type= 'POST',url= '<?= base_url() ?>Transport/get_drivers_list_notin_driver_bus_map',datastring= {vendor : vendor};
	html_content=ajaxcall(type,url,datastring);
	//alert(html_content);
	if(html_content!="")
	{
		$('#did').html(html_content);
	}else{
		$('#did').html('<option value="">No drivers found</option>');  
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
