<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script

<!-- below code is for date picker   -->
	 
	 <script>

	 </script>

<script>    
    $(document).ready(function()
    {
			 $('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	 	 $('#doc-sub-datepicker42').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
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
                academic:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select academic'
                      },
                      required: 
                      {
                       message: 'Please select academic'
                      }
                     
                    }
                },
				htype:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Hostel Type'
                      },
                      required: 
                      {
                       message: 'Please select Hostel Type'
                      }
                     
                    }
                },
				Campus:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Campus'
                      },
                      required: 
                      {
                       message: 'Please select Campus'
                      }
                     
                    }
                },
				hostels:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select hostels'
                      },
                      required: 
                      {
                       message: 'Please select hostels'
                      }
                     
                    }
                },
				floors:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select floors'
                      },
                      required: 
                      {
                       message: 'Please select floors'
                      }
                     
                    }
                },
				rooms:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select rooms'
                      },
                      required: 
                      {
                       message: 'Please select rooms'
                      }
                     
                    }
                }
            }       
        })
    });
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Hostel</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12  text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Student Facility Allocation</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row"> 
						<br/>				
					<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Edit Student Facility Allocation</span>
                        <div class="holder"></div>
                </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/edit_stdnt_faci_submit/'.$facilities_allocation['f_alloc_id'])?>" method="POST">     
							
							<input type="hidden" id="sf_id" name="sf_id" />
							<input type="hidden" id="sf_room_id" name="sf_room_id" /> 
							<input type="hidden" id="std_id" name="std_id" />
							<input type="hidden" id="enroll" name="enroll" /> 
							<input type="hidden" id="r_no" name="r_no" />
							<input type="hidden" id="noofbeds" name="noofbeds" />
									
                                <div class="form-group">
                                    <label class="col-sm-3">Select Academic Year <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="academic" name="academic" class="form-control" >
                                            <option value="">Select academic_year</option>
                                            <option value="2017">2017-18</option>
                                             <option value="2016">2016-17</option>
                                      
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('academic');?></span></div>
                                </div>
                                
								<!--<div class="form-group">
                                    <label class="col-sm-3">Select Facility <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select class="form-control" name="faci_id" id="faci_id" required>
											  <option value="">select Facility</option>
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
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('faci_id');?></span></div>
                                </div>-->
								
								<div class="form-group">
                                    <label class="col-sm-3">Select Hostel type <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="htype" name="htype" class="form-control" >
                                            <option value="">Select Hostel type</option>
                                            <option value="B">Boys</option>
                                            <option value="G">Girls</option>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('htype');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Select Campus <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="Campus" name="Campus" class="form-control" >
                                            <option value="">Select Campus</option>
                                            <option value="Y">In Campus</option>
                                            <option value="N">Out Campus</option>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('category');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Select Hostels <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="hostels" name="hostels" class="form-control" >
                                            <option value="">Select hostels</option>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('hostels');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Select Floors <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="floors" name="floors" class="form-control" >
                                            <option value="">Select Floors</option>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('floors');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Select Rooms <?=$astrik?></label>                                    
                                    <div class="col-sm-4">
                                        <select id="rooms" name="rooms" class="form-control" >
                                            <option value="">Select Rooms</option>
                                        </select>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('rooms');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Valid From</label>
                                    <div class="col-sm-4">
                                      <input type="text" class="form-control" id="doc-sub-datepicker21" name="validfrom" required placeholder="Valid from Date" required />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('deposit');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Valid To</label>
                                    <div class="col-sm-4">
                                      <input type="text" class="form-control" id="doc-sub-datepicker42" name="validto" required placeholder="Valid to Date" required readonly="true"/>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('deposit');?></span></div>
                                </div>
								
                                <div class="form-group">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/student_allocation_list')?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>


<script>
var campus='',htype='',hostels='',floors='',room='',host_id='',hostel_code='',std_id='2',enroll='170105012';
$(document).ready(function(){

	var academic_year='<?=$facilities_allocation['academic_year']?>';
	$('#academic option').each(function()
	 {              
		 if($(this).val()== academic_year)
		{
		$(this).attr('selected','selected');
		}
	});
	
	htype='<?=$facilities_allocation['hostel_type']?>';
	$('#htype option').each(function()
	 {              
		 if($(this).val()== htype)
		{
		$(this).attr('selected','selected');
		}
	});
	
	campus='<?=$facilities_allocation['in_campus']?>';
	hostels='<?=$facilities_allocation['host_id']?>||<?=$facilities_allocation['hostel_code']?>||<?=$facilities_allocation['no_of_floors']?>';
	floors='<?=$facilities_allocation['floor_no']?>';
	rooms='<?=$facilities_allocation['sf_room_id']?>||<?=$facilities_allocation['room_no']?>||<?=$facilities_allocation['no_of_beds']?>';
	vfrom='<?=$facilities_allocation['valid_from']?>';
	vto='<?=$facilities_allocation['valid_to']?>';
	$('#doc-sub-datepicker21').val(vfrom);
	$('#doc-sub-datepicker42').val(vto);
	
	$('#Campus option').each(function()
	 {              
		 if($(this).val()== campus)
		{
			$(this).attr('selected','selected');
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/gethostelbycampus',
				data: {campus:campus,htype:htype},
				success: function (html) {
					//alert(hostels);
					$('#hostels').html(html);
					$('#hostels option').each(function()
					 {              
						 if($(this).val()== hostels)
						{
							$(this).attr('selected','selected');
								var hostel_data=hostels.split("||");
								host_id = hostel_data[0];
								hostel_code = hostel_data[1];
								var tot_flr = hostel_data[2];
								var input_data='<option value="">select Floor</option>';
								for (i=1;i<=tot_flr;i++)
								{
									input_data+='<option value="'+i+'"> '+i+'</option>';
								}
								$('#floors').html(input_data);
								$('#floors option').each(function()
								 {              
									 if($(this).val()== floors)
									{
										$(this).attr('selected','selected');
										$.ajax({
											type: 'POST',
											url: '<?= base_url() ?>Hostel/getroomnumsbyfloorno',
											data: { host_id: host_id, floors : floors},
											success: function (html) {
												if(html === "{\"flr_details\":[]}")
												{
													$('#rooms').html('<option value="">No rooms found</option>');
												}
												else
												{//alert("existed==="+html.flr_details);
													var content='<option value="">Select Rooms</option>';
													var array=JSON.parse(html);
													len=array.flr_details.length;
													 for(i=0;i<len;i++)
													{
														
														
														content+='<option value="'+array.flr_details[i].sf_room_id+'||'+array.flr_details[i].room_no+'||'+array.flr_details[i].no_of_beds+'">'+array.flr_details[i].room_no+' ['+array.flr_details[i].room_type+'] ['+array.flr_details[i].category+']</option>';
														/* array.flr_details[i].sf_room_id;
														array.flr_details[i].room_no;
														array.flr_details[i].no_of_beds;
														array.flr_details[i].room_type;
														array.flr_details[i].category; */
													}
													$('#rooms').html(content);
													$('#rooms option').each(function()
													 {              
														 if($(this).val()== rooms)
														{
															$(this).attr('selected','selected');
														}
													 });
													//////////
												}
											}
										});
									///////////////	
									}
								 });
								
						}
					});
					
					
				}
			});
		
		
		
		}
	});
	
	  	
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Hostel/getsfid_byenrollment',
		data: {std_id:std_id,enroll:enroll},
		success: function (html) {
			//alert(html);
			$('#sf_id').val(html);
			$('#std_id').val(std_id);
			$('#enroll').val(enroll);
		}
	});
	
	// City by State
	$('#Campus').on('change', function () {
	campus = $(this).val();
	 htype = $("#htype").val();
		//alert("called==="+campus);
		if (campus) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/gethostelbycampus',
				data: {campus:campus,htype:htype},
				success: function (html) {
					//alert(html);
					$('#hostels').html(html);
				}
			});
		} else {
			$('#hostels').html('<option value="">Select Campus first</option>');
		}
	});
	
	
	// get no of floor by host_id
	$('#hostels').on('change', function () {
		hostels = $(this).val();
		if (hostels) 
		{
			var hostel_data=hostels.split("||");
			host_id = hostel_data[0];
			hostel_code = hostel_data[1];
			//$('#hostel_id').val(host_id);
			//$('#hostel_code').val(hostel_code);
			//$('#hst_id').val(host_id);
			//$('#host_code').val(hostel_code);
			
			var tot_flr = hostel_data[2];
			var input_data='<option value="">select Floor</option>';
			for (i=1;i<=tot_flr;i++)
			{
				input_data+='<option value="'+i+'"> '+i+'</option>';
			}
			$('#floors').html(input_data);
		} 
		else 
		{
			$('#floors').html('<option value="">Select Hostels First</option>');
		}
	});
	
    // City by State
	$('#floors').on('change', function () {
		floors = $(this).val();
		//var state_ID = $("#hstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (floors) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/getroomnumsbyfloorno',
				data: { host_id: host_id, floors : floors},
				success: function (html) {
					//alert(html);
					/* if(html !=''){
					$('#rooms').html(html);
					}else{
					  $('#rooms').html('<option value="">No rooms found</option>');  
					} */
					
					if(html === "{\"flr_details\":[]}")
					{
						$('#rooms').html('<option value="">No rooms found</option>');
					}
					else
					{//alert("existed==="+html.flr_details);
						var content='<option value="">Select Rooms</option>';
						var array=JSON.parse(html);
						len=array.flr_details.length;
						 for(i=0;i<len;i++)
						{
							if(array.flr_details[i].tot < array.flr_details[i].no_of_beds)
							{
							content+='<option value="'+array.flr_details[i].sf_room_id+'||'+array.flr_details[i].room_no+'||'+array.flr_details[i].no_of_beds+'">'+array.flr_details[i].room_no+' ['+array.flr_details[i].room_type+'] ['+array.flr_details[i].category+']</option>';
							}
						}
						$('#rooms').html(content);
						
					}
					
				}
			});
		} else {
			$('#rooms').html('<option value="">Select Floors first</option>');
		}
	});	
	
	// get no of floor by host_id
	$('#rooms').on('change', function () {
		rooms = $(this).val();
		if (rooms) 
		{
			var room_data=rooms.split("||");
			var sf_room_id = room_data[0];
			var r_no = room_data[1];//tot no of beds in the selected floor
			var noofbeds = room_data[2];
			
			$('#sf_room_id').val(sf_room_id);
			$('#r_no').val(r_no);
			$('#noofbeds').val(noofbeds);
		} 
		else 
		{
			$('#floors').html('<option value="">Select Rooms First</option>');
		}
	});
	
	});	

</script>
