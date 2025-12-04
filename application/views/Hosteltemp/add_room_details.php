<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
        $('#form1').bootstrapValidator
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
                hostel_type:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select hostel_type'
                      },
                      required: 
                      {
                       message: 'Please select hostel_type'
                      }
                     
                    }
                },
				campus_id:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select in_campus'
                      },
                      required: 
                      {
                       message: 'Please select in_campus'
                      }
                     
                    }
                },
                flr_rooms:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'flr_rooms should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'flr_rooms should be numeric'
                      },
                     /*  stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
                    }
                },
				 .numbersOnly:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Total no. floors should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Total no. floors should be numeric'
                      },
                     /*  stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
                    }
                },
				 .room_no:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'room number should not be empty'
                      },
                      stringLength: 
                        {
                       
                        min: 1,
                        message: 'room number should be atleast 1 character.'
                        } 
                    }
                },
				 tot_beds:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Total no. beds should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Total no. beds should be numeric'
                      },
                     /*  stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
                    }
                },
				 h_area:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Hostel Area name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Hostel Area name should be 2-50 characters.'
                        }
                    }
                },
				h_address:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Hostel Address should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'Hostel Address should be 2-50 characters.'
                        }
                    }
                },
                hostel_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Hostel name should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: 'H name should be 2-50 characters.'
                        }
                    }
                },
                hostel_pincode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Total no. beds should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Total no. beds should be numeric'
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
        <li class="active"><a href="<?=base_url($currentModule)?>"> Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Room</h1>
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
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Enter Details</span>
                        <div class="holder"></div>
                </div>
                    <div class="panel-body">
                         <div class="row ">
							
							<div class="col-sm-6">   
							
								
									<div class="form-group">
										<label  class="col-sm-6">Select Hostel: <?=$astrik?></label>
										<div class="col-sm-6">
										  <select class="form-control" name="host_id" id="host_id" required>
											  <option value="">select Hostel</option>
											  <?php //echo "state".$state;exit();
												if(!empty($hostel_details)){
													foreach($hostel_details as $hostels){
														?>
													  <option value="<?=$hostels['host_id']?>||<?=$hostels['hostel_code']?>||<?=$hostels['no_of_floors']?>"><?=$hostels['hostel_name']?></option>  
													<?php 
														
													}
												}
											  ?>
										  </select>
										</div>
									</div>
									
									<div class="form-group">
									<label class="col-sm-6">Select Floor: <?=$astrik?></label>
									<div class="col-sm-6">
									  <select class="floor form-control" name="floor" id="floor" required>
										  <option value="">select Floor</option>
									  </select>
									</div>
								  </div>
									  
									<div id="nonexistsflr" class="form-group">
                                    <label class="col-sm-6">Enter No.of Room: <?=$astrik?></label>
                                    <div class="col-sm-6"><input type="text" id="flr_rooms" name="flr_rooms" class="form-control numbersOnly" /></div>                                    
                                    <div class="col-sm-2"><span style="color:red;"><?php echo form_error('flr_rooms');?></span></div>
									</div>
									
									
									<div id="nonexistsflr2" class="form-group">
										<div class="col-sm-4"></div>
										<div class="col-sm-4">
											<button class="btn btn-primary form-control" onclick="validation()" id="btn_submit" >Submit</button>                                     
										</div>                                    
										<div class="col-sm-4"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule."/view_room_details")?>'">Cancel</button></div>
										
									</div>
									
									
							
									<!--<div class="form-group">
										<div class="col-sm-4"></div>
										<div class="col-sm-6">
											<button class="btn btn-primary form-control" onclick="validation()" id="btn_submit" >Submit</button>                                        
										</div>                                    

									</div>-->
									
									
									
								
							</div>  
							<div class="table-info col-sm-6" id="rms_bds_dtls" style="display:none;">                 
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>TYPE</th>
										<th>ROOM</th>
										<th>BED</th>
									</tr>
								</thead>
								<tbody id="rmsbds_dtls">
								</tbody>
							</table>
							</div>
							
							
							<div class="form-group">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-8"><span style="color:red;" id="err_msg"></span></div>                                    
                                    <div class="col-sm-2"></div>
									</div>
							
							
						</div>
						
						<div class="row ">
						<div id="r_div" class="col-sm-12" style="overflow-x:scroll;height:700px;display:none;">
								<div class="table-info">    
									<form id="form" name="form" action="<?=base_url($currentModule.'/room_details_submit')?>" method="POST" onsubmit="return validate_roomcategory(event)">
									<input type="hidden" id="hostel_id" name="hostel_id" />
									<input type="hidden" id="hostel_code" name="hostel_code" /> 
									<input type="hidden" id="floor_no" name="floor_no" /> 
									
									<table class="table table-bordered">
										<thead>
											<tr>
											<th>#</th>
													<th>#Room</th>
													<th>No Of Beds</th>
													<th>Room Type</th>
													<th>Room Category</th>
											</tr>
											
										</thead>
										
										<tbody id="itemContainer">
										
										
										
										
										</tbody>
										</table>
										<p></p>
										<div class="col-sm-6">   
											
											<div class="form-group">
												
												<div class="col-sm-6">
													<button class="btn btn-primary form-control" type="submit" id="btn_submit" >Save</button>                                        
												</div>   
												<div class="col-sm-6">
												<button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule."/add_rms_details")?>'">Cancel</button>
												
												</div>

											</div>
										
										
										</div>
									</form>
								</div>
							</div>
						
						
						
						
							<div id="existedrooms" style="display:none;" class="col-sm-12">
								<div class="panel">
									<div class="panel-heading" style="padding-bottom: 20px;">
									<span class="panel-title">Existed Floor Details</span>
									<span style="padding-left: 45px;color:red;" id="formerrmsg"></span>		
									<div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" onclick="addroom()" ><span class="btn-label icon fa fa-plus"></span>Add Room</a>
									</div>
									
									
									</div>
									<div class="panel-body" style="overflow-x:scroll;height:700px;">
										
										<div class="table-info" >    
										<form id="form1" name="form1" action="<?=base_url($currentModule.'/in_up_submit')?>" method="POST" onsubmit="return validate_roomcategory(event)">
													<input type="hidden" id="hst_id" name="hst_id" />
													<input type="hidden" id="host_code" name="host_code" /> 
													<input type="hidden" id="fr_no" name="fr_no" /> 
													
													<table class="table table-bordered">
														<thead>
															<tr>
															<th>#</th>
																	<th>#Room No</th>
																	<th>No Of Beds</th>
																	<th>Room Type</th>
																	<th>Room Category</th>
															</tr>
															
														</thead>
														
														<tbody id="itemContainer1">
														
														
														
														
														</tbody>
														</table>
														<div class="col-sm-6">   
															
												<div class="form-group">
													
													<div class="col-sm-6">
														<button class="btn btn-primary form-control" type="submit" id="btn_submit" >Update</button>                                        
													</div>  
													<div class="col-sm-6">
												<button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule."/add_rms_details")?>'">Cancel</button>
												
												</div>

												</div>
											
											
											</div>
														
														
												</div>
										
											
											
											
										
										</div>
										
											
											
										
										</form>
									</div>
								</div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>


<script>
var host_id ="",floor ="",len="",sr_no='';
var arr_room=[],initial_beds=0,actualbeds=0;
var cat_type='',status=0,err_count=0;
function validate_roomcategory(events)
{
	var leng=$('input[name="floorbeds[]"]').length;
	//alert(leng);
	for (i=0;i<leng;i++)
	{
		cat_type=$('#flr_rm_cat_'+i).val();
		if(cat_type=="Gym" || cat_type=="Parlour")
		{
			$('#flrbeds_'+i).val(1);
		}
	}
	
	/* var valid = true;

	$.each($('.givenclass'), function (index1, item1) {

		$.each($('.givenclass').not(this), function (index2, item2) {

			if ($(item1).val() == $(item2).val()) {
				$(item1).css("border-color", "red");
				valid = false;
			}
			else
			{
				 $(item1).css("border-color", "");
			}

		});
	});

	alert(valid); */
	
	

	if(checkDuplicates())
	{
	 $('#err_msg').html('Has duplication room number');
	 return false;
	}
	
	
	if(checkDuplicates1())
	 {
	 $('#err_msg').html('Has duplication room number');
	 return false;
	}
	 
	 
	/* $('input[type=submit]').on('click', function(e) {
	e.preventDefault();
	if(checkDuplicates())
	 $('p').html('Has duplication');
	 else  $('p').html('No duplication');
	}) */
	
	
	if(err_count==1 || valid==false)
	{ return false;}
}


function checkDuplicates() {
	  // get all input elements
	  var $elems = $('.givenclass');

	  // we store the inputs value inside this array
	  var values = [];
	  values.length=0;
	  //alert(values.length);
	  // return this
	  var isDuplicated = false;
	  // loop through elements
	  $elems.each(function () {
		//If value is empty then move to the next iteration.
		if(!this.value) return true;
		//If the stored array has this value, break from the each method
		if(values.indexOf(this.value) !== -1) {
			$(this).css("border-color", "red");
		   isDuplicated = true;
		   //return false;
		 }
		 else
		 	$(this).css("border-color", "");
		// store the value
		values.push(this.value);
	  });   
	  
		return isDuplicated;     
	}
	
function checkDuplicates1()
{
		   var $elems = $('.givenclass1');

	  // we store the inputs value inside this array
	  var values1 = [];
	  values1.length=0;
	  //alert(values.length);
	  // return this
	  var isDuplicated1 = false;
	  // loop through elements
	  $elems.each(function () {
		//If value is empty then move to the next iteration.
		if(!this.value) return true;
		//If the stored array has this value, break from the each method
		if(values1.indexOf(this.value) !== -1) {
			$(this).css("border-color", "red");
		   isDuplicated1 = true;
		   //return false;
		 }
		 else
		 	$(this).css("border-color", "");
		// store the value
		values1.push(this.value);
	  }); 
	  
	  return isDuplicated1;
}

$(document).ready(function(){
	
	 // Num check logic
  	$('.numbersOnly').keyup(function () {
		
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
	
  	// get no of floor by host_id
	$('#host_id').on('change', function () {
		var h_id = $(this).val();
		if (h_id) 
		{
			var hostel_data=h_id.split("||");
			 host_id = hostel_data[0];
			var hostel_code = hostel_data[1];
			$('#hostel_id').val(host_id);
			$('#hostel_code').val(hostel_code);
			$('#hst_id').val(host_id);
			$('#host_code').val(hostel_code);
			
			var tot_flr = hostel_data[2];
			var input_data='<option value="">select Floor</option>';
			for (i=0;i<=tot_flr;i++)
			{
				if(i==0)
					input_data+='<option value="'+i+'">G</option>';
				else
					input_data+='<option value="'+i+'"> '+i+'</option>';
			}
			$('#floor').html(input_data);
		} 
		else 
		{
			$('#flr_rooms').val('');
			$('#nonexistsflr').show();
			$('#nonexistsflr2').show();
			$('#existedrooms').hide();
			$('#rms_bds_dtls').hide();
			$('#r_div').hide();
			$('#floor').html('<option value="">Select Floor</option>');
		}
	});
	
	$('#floor').on('change', function () {
		//var host_id = $('#host_id').val();
		 floor = $(this).val();
		 $('#fr_no').val(floor);
		if (floor!='') 
		{ //alert(floor+"==="+host_id);
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/check_flr_exist',
				data: { host_id:host_id,flr_no : floor},
				success: function (html) {
					//alert(html);
					if(html === "{\"flr_details\":[]}")
					{//alert(html.flr_details);
						rooms_allocation_details(host_id,floor);
						$('#r_div').hide();
						//$('#itemContainer1').html(input_data);
						$('#existedrooms').hide();
						$('#flr_rooms').val('');
						$('#nonexistsflr').show();
						$('#nonexistsflr2').show();
					}
					else
					{//alert("existed==="+html.flr_details);
						$('#err_msg').html("");
						status=1;
						var array=JSON.parse(html);
						//alert(array.flr_details[0].hostel_code);
						var str="",r_type1="",r_type2="",c_type1="",c_type2="",c_type3="",c_type4="",c_type5="",c_type6="",input_data='';
						//alert(flr_details[0].hostel_code);
						len=array.flr_details.length;
						initial_beds=0;
						
						 for(i=0;i<len;i++)
						{
							sr_no=i+1;
							r_type1="";r_type2="";
							if(array.flr_details[i].room_type=="Executive")
								r_type1="selected";
							else
								r_type2="selected"; 
							
							c_type1="",c_type2="",c_type3="",c_type4="",c_type5="",c_type6="",c_type7="";
							if(array.flr_details[i].category=="Stay Room")
								c_type1="selected";
							else if(array.flr_details[i].category=="Guest House")
								c_type2="selected";
							else if(array.flr_details[i].category=="TV Room")
								c_type3="selected";
				
							else if(array.flr_details[i].category=="Gym")
								c_type4="selected";
							else if(array.flr_details[i].category=="Parlour")
								c_type5="selected";
							else if(array.flr_details[i].category=="Rector Room")
								c_type6="selected";	
									else if(array.flr_details[i].category=="Washroom")
								c_type7="selected";
							arr_room.push(array.flr_details[i].room_no);
							
							initial_beds+=parseInt(array.flr_details[i].no_of_beds);
							
							//array.flr_details[i].room_no
							input_data+='<tr id="'+i+'"><td>'+sr_no+'</td><td><input type="hidden" value="'+array.flr_details[i].sf_room_id+'" name="sf_room_id[]" /><input style="width: 50px;" class="givenclass" name="room_no[]" type="text" id="rm_no_'+i+'" value="'+array.flr_details[i].room_no+'" onchange="check_r(this.id,'+i+')" readonly/><br/><span style="color:red;display:none;" id="rm_err_msg_'+i+'">Room No either Empty/Already Existed!!</span></td><td><input class="form-control" style="width: 50px;" name="floorbeds[]" type="text" id="flrbeds_'+i+'" value="'+array.flr_details[i].no_of_beds+'"  onChange="check_beds(this.id,'+i+')" required/><span id="bd_err_msg_'+i+'"></span></td><td><select class="form-control" onfocus="hide_msg('+i+')" name="flr_rm_type[]" id="flr_rm_type_'+i+'"><option '+r_type1+' value="1">Executive</option><option '+r_type2+' value="2">Deluxe</option></select></td><td><select class="form-control" form-control" name="flr_rm_cat[]" onchange="check_cat_type(this.id,'+i+')" id="flr_rm_cat_'+i+'"><option '+c_type1+' value="Stay Room">Stay Room</option><option '+c_type2+' value="Guest House">Guest House</option><option '+c_type3+' value="TV Room">TV Room</option><option  '+c_type4+' value="Gym">Gym</option><option '+c_type5+' value="Parlour">Parlour</option><option '+c_type6+' value="Parlour">Rector Room</option><option '+c_type7+' value="Washroom">Washroom</option></select></td></tr>';
						} 
						//alert(arr_room);
						$('#nonexistsflr').hide();
						$('#nonexistsflr2').hide();
						$('#itemContainer1').html(input_data);
						$('#existedrooms').show();
						rooms_allocation_details(host_id,floor);
						
					}
				}
			});
			//initial_beds=countexistedbeds;
		}
		else 
		{
			
			$('#flr_rooms').val();
			$('#rms_bds_dtls').hide();
			$('#r_div').hide();
			$('#existedrooms').hide();
			$('#nonexistsflr').show();
			$('#nonexistsflr2').show();
			//$('#floor').html('<option value="">Select Floor</option>');
		}
	});
	
});	

function addroom()
{
	if(available_rms==0)
	{
		$('#err_msg').html("You cannot add rooms,because Rooms limit reached!!!");
		return;
	}
	else
	{
		available_rms=available_rms-1;
		$('#err_msg').html("");
		//alert(available_rms);
	}
	sr_no=len+1;
	var input_data='<tr id="remove_'+len+'"><td>'+sr_no+'</td><td><input type="hidden" name="sf_room_id[]" /><input style="width: 50px;" class="givenclass" name="room_no[]" type="text" id="rm_no_'+len+'" onchange="check_r(this.id,'+len+')" required/><br/><span style="color:red;display:none;" id="rm_err_msg_'+len+'">Room No either Empty/Already Existed!!</span></td><td><input class="form-control" style="width: 50px;" name="floorbeds[]" type="text" id="flrbeds_'+len+'" value="1"  onChange="check_beds(this.id,'+len+')" required/><span id="bd_err_msg_'+len+'"></span></td><td><select class="form-control" onfocus="hide_msg('+i+')" name="flr_rm_type[]" id="flr_rm_type_'+len+'"><option value="1">Executive</option><option value="2">Deluxe</option></select></td><td><select class="form-control" form-control" name="flr_rm_cat[]" onchange="check_cat_type(this.id,'+len+')" id="flr_rm_cat_'+len+'"><option value="Stay Room">Stay Room</option><option value="Guest House">Guest House</option><option value="TV Room">TV Room</option><option value="Gym">Gym</option><option value="Parlour">Parlour</option><option value="Rector Room">Rector Room</option><option value="Washroom">Washroom</option></select></td><td><a id="'+len+'" style="padding-left: 10px;" onclick="remove_room(this.id)"><span class="glyphicon glyphicon-trash"></span></a></td></tr>';
	
	$('#itemContainer1').append(input_data);
	len++;
}

function remove_room(id)
{
	available_rms=available_rms+1;
	$('#err_msg').html("");
	//alert(available_rms);
	$('#remove_'+id).remove();
}

var total_rms=0,total_bds=0,allocated_rms=0,allocated_bds=0,available_rms=0,available_bds=0;
function rooms_allocation_details(host_id,floor)
{
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Hostel/rooms_allocation_details',
			data: { host_id:host_id,flr_no : floor},
			success: function (html) {
				//alert(html);
				var rm_allocate_dtls=html.split("||");
				 total_rms = rm_allocate_dtls[0];
				 total_bds = rm_allocate_dtls[1];
				 allocated_rms = rm_allocate_dtls[2]==""?0:rm_allocate_dtls[2];
				 allocated_bds = rm_allocate_dtls[3]==""?0:rm_allocate_dtls[3];
				 available_rms = total_rms-allocated_rms;
				 available_bds = total_bds-allocated_bds;
				 actualbeds=available_bds;
				$('#rmsbds_dtls').html('<tr><td><b>Total</b></td><td><span style="font-weight:bold;color:#1d89cf;">'+total_rms+'</span></td><td><span style="font-weight:bold;color:#1d89cf;">'+total_bds+'</span> </td></tr><tr> <td><b>Entered Details</b></td><td> <span style="font-weight:bold;color:RED;" >'+allocated_rms+'</span> </td><td><span style="font-weight:bold;color:RED;">'+allocated_bds+'</span></td></tr><tr><td><b>Not Entered Details</b></td><td><span style="font-weight:bold;color:GREEN;">'+available_rms+'</span></td><td><span style="font-weight:bold;color:GREEN;">'+available_bds+'</span></td> </tr>');
				$('#rms_bds_dtls').show();
			}
	});
}


function check_cat_type(id,id_num)
{
	cat_type=$('#'+id).val();
	if(cat_type=="Gym" || cat_type=="Parlour")
	{
		$('#flrbeds_'+id_num).val(1);
	}
}

function validation()
{
	var flr_rooms=$('#flr_rooms').val();
	if (host_id == "" || floor == "" || flr_rooms == "")
	{
		$('#err_msg').html("Please fill all the fields!!!");
		return false;
	}
	else
	{
		$('#err_msg').html('');
		if(flr_rooms > available_rms){
		$('#err_msg').html("Only "+available_rms+" Rooms Are Available In This Hostel!!!");
		$('#r_div').hide();
		}
		else if(available_rms==0){
		$('#err_msg').html("No Rooms Are Available In This Floor!!!");
		$('#r_div').hide();
		}
		else
		{
			$('#err_msg').html("");
			$('#floor_no').val(floor);
			
			var input_data="";
			for (i=0;i<flr_rooms;i++)
			{//value="F'+floor+i+'"
				sr_no=i+1;
				input_data+='<tr id="'+i+'"><td>'+sr_no+'</td><td><input style="width: 50px;" class="givenclass1" name="room_no[]" type="text" id="rm_no_'+i+'" onchange="check_r(this.id,'+i+')" required/><br/><span style="color:red;display:none;" id="rm_err_msg_'+i+'">Room No either Empty/Already Existed!!</span></td><td><input class="form-control" style="width: 50px;" name="floorbeds[]" type="text" id="flrbeds_'+i+'" value="1"  onChange="check_beds(this.id,'+i+')"/><span id="bd_err_msg_'+i+'"></span></td><td><select onblur="hide_msg('+i+')" class="form-control"  name="flr_rm_type[]" id="flr_rm_type_'+i+'"><option value="1">Executive</option><option value="2">Deluxe</option></select></td><td><select class="form-control" form-control" name="flr_rm_cat[]" onchange="check_cat_type(this.id,'+i+')" id="flr_rm_cat_'+i+'"><option value="Stay Room">Stay Room</option><option value="Guest House">Guest House</option><option value="TV Room">TV Room</option><option value="Gym">Gym</option><option value="Parlour">Parlour</option><option value="Rector Room">Rector Room</option><option value="Washroom">Washroom</option></select></td></tr>';
			}
			$('#itemContainer').html(input_data);
			$('#r_div').show();
		}
	}
}

function hide_msg()
{
	$('#err_msg').html('');
}

function onlynumber(id,id_num)
{
	var r_no=$('#'+id).val();
	r_no = r_no.replace(/[^0-9\.]/g, '');
	$('#'+id).val(r_no);
}

function check_r(id,id_num)
{
	var r_no=$('#'+id).val();
	if(r_no=="")
	{
		//$('#'+id).focus();
		$('#rm_err_msg_'+id_num).show();
	}
	//alert("fvsayvdsua");
	
	
	
	/* var inputs=$('.givenclass');
        inputs.each(function(){
            $(this).change(function(){
                var current=$(this);
                inputs.each(function(){
                    if(current.val() == $(this).val())
                    {
                        current.next().html("'"+current.val()+"' already entered");
                        break;
                    }
                });
            });

        }); */
	
	/* else
	{
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Hostel/room_existsbyflrofhostel',
			data: { host_id:host_id,flr_no : floor,r_no:r_no},
			success: function (html) 
			{
				if(html=="exists")
				{
					$('#rm_err_msg_'+id_num).show();
					//$('#'+id).focus();
				}
				else
				{
					$('#rm_err_msg_'+id_num).hide();
				}
			}
		});
		
	} */
}

var temp_bds=0;
function check_beds(id,id_num)
{
	if(actualbeds < 0)
	{
		//if(status==1){$('#formerrmsg').html('All beds are filled!!');}
		$('#err_msg').html('All beds are filled!!');
		err_count=1;
		//$('#'+id).focus();
	}
	else if(actualbeds==0)
	{
		//if(status==1){$('#formerrmsg').html('All beds are filled!!');}
		$('#err_msg').html('All beds are filled!!');err_count=0;
		$(':input[type="submit"]').prop('disabled', false);
		//$('#bd_err_msg_'+id_num).prop('disabled', true);
	}
	else
	{
		//if(status==1){$('#formerrmsg').html('<span style="color:Green;" > Less than '+actualbeds+' Beds have to enter!!</span>');}
		
		$('#err_msg').html('<span style="color:Green;" > Less than '+actualbeds+' Beds have to enter!!</span>');err_count=0;
		//$('#bd_err_msg_'+id_num).html('');
		//$('#bd_err_msg_'+id_num).prop('disabled', false);
	}
	
	var noof_beds=$('#'+id).val();
	noof_beds = noof_beds.replace(/[^0-9\.]/g, '');
	if(noof_beds=='')
	{$('#'+id).val(1);$('#err_msg').html('');}
	else if(noof_beds>12)
	{$('#'+id).val(12);$('#err_msg').html('<span style="color:red;" > Maximum you can enter only 12 beds!!</span>');}
	else
	{$('#'+id).val(noof_beds);$('#err_msg').html('');}
	
	var sum=0;
	$('input[name="floorbeds[]"]').each(function() {
		sum+=parseInt(this.value);
    });
	//alert("actualbeds="+actualbeds+"sum="+sum+"available_bds="+available_bds+"initial_beds="+initial_beds);
	temp_bds=(available_bds+initial_beds)-sum;
	
	if(temp_bds < 0)
	{
		$('#'+id).focus();
		//if(status==1){$('#formerrmsg').html('You Have Entered More Than beds Limit!!');}
		$('#err_msg').html('You Have Entered More Than The beds Limit!!!!');
		err_count=1;
	}
	else if(temp_bds==0)
	{
		actualbeds=temp_bds;
		//if(status==1){$('#formerrmsg').html('All beds are filled!!');}
		$('#err_msg').html('All beds are filled!!');
		err_count=0;
		$(':input[type="submit"]').prop('disabled', false);
		//$('#bd_err_msg_'+id_num).prop('disabled', true);
	}
	else
	{
		actualbeds=temp_bds;err_count=0;
		//$('#bd_err_msg_'+id_num).prop('disabled', false);
	}
	
	//$('#bd_err_msg_'+id_num).hide();
}
</script>
