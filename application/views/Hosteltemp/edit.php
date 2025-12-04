<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
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
                },campus:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select campus'
                      },
                      required: 
                      {
                       message: 'Please select campus'
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
				
				/* hostel_code:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Hostel code should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Hostel code should be numeric'
                      },
                     
                    }
                }, */
				
                hostel_code:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Hostel code should not be empty'
                      }/*,
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Hostel code should be numeric'
                      }
                       stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
                    }
                },
				 tot_flr:
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
                      }
                     /*  stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
                    }
                },
				 tot_rooms:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Total no. rooms should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Total no. rooms should be numeric'
                      }
                     /*  stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
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
                      }
                     /*  stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
                    }
                },
                		 actual_capacity:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Actual Capacity should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Actual Capacity should be numeric'
                      }
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
        <li class="active"><a href="<?=base_url($currentModule)?>"> Hostel</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Hostel Details</h1>
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
                        <span class="panel-title">Edit Hostel Details</span>
                        <span id="message" style="color:red;padding-left:200px;"></span>
                </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                             
                            <form id="form" name="form" action="<?=base_url($currentModule.'/edit_submit')?><?='/'.$hostel_details['host_id']?>" method="POST"  onsubmit="return form_check_exists(event)">                                                               
                                <input type="hidden" value="<?=$hostel_details['host_id']?>" id="host_id" name="host_id" />
								<div class="form-group">
                                    
									<div class="col-sm-4">
									<label>Select Hostel Type: <?=$astrik?></label>
                                        <select id="hostel_type" name="hostel_type" class="form-control" >
                                            <option value="">Select Hostel Type</option>
                                           
                                            <option value="B">Boys</option>
                                             <option value="G">Girls</option>
                                        </select>   
										<span style="color:red;"><?php echo form_error('hostel_type');?></span>										
                                    </div>
                                    <div class="col-sm-4">
									<label>Enter Hostel Name: <?=$astrik?></label>
									<input type="text" id="hostel_name" onchange="check_exists()" name="hostel_name" class="form-control" value="<?=$hostel_details['hostel_name']?>" placeholder="Enter Hostel Name"  />
									<span style="color:red;"><?php echo form_error('hostel_name');?></span>
									</div>                                    
                                   
                                    <div class="col-sm-4">
									<label>Enter Hostel Code: <?=$astrik?></label>
									<input type="text" id="hostel_code" onchange="check_exists()"  value="<?=$hostel_details['hostel_code']?>" name="hostel_code" class="form-control" placeholder="Enter Hostelcode"  />
									<span style="color:red;" id="err_hcode"><?php echo form_error('hostel_code');?></span>
									</div>
									 
                                </div>
								
								<div class="form-group">
                                    
                                    <div class="col-sm-4">
									<label>Enter No.Of Floors: <?=$astrik?></B></label>
									<input type="text" id="tot_flr" value="<?=$hostel_details['no_of_floors']?>" name="tot_flr" class="form-control" placeholder="Enter No.Of Floors"  />                                    
                                    <span style="color:red;"><?php echo form_error('tot_flr');?></span>
									</div>
									
                                    <div class="col-sm-4">
									<label>Enter No.Of Rooms:<?=$astrik?></label>
									<input type="text" id="tot_rooms" value="<?=$hostel_details['no_of_rooms']?>" name="tot_rooms" placeholder="Enter No.Of Rooms" class="form-control"  /><span style="color:red;"><?php echo form_error('tot_rooms');?></span></div>
									<div class="col-sm-4">
									<label>Increased Capacity: <?=$astrik?></label>
									<input type="text" id="tot_beds" value="<?=$hostel_details['no_of_beds']?>" name="tot_beds" class="form-control" placeholder="Increased Capacity" />                                    
                                   <span style="color:red;"><?php echo form_error('tot_beds');?></span>
								   </div>
                                </div>
							<div class="form-group">
								<div class="col-sm-4">
								<label >Select Campus:<?=$astrik?></label>
									<select id="campus" name="campus" class="form-control" >
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
									<span style="color:red;"><?php echo form_error('campus');?></span>										
								</div>

                                
								<div class="col-sm-4">
								<label >Select In Campus:<?=$astrik?></label>
									<select id="campus_id" name="campus_id" class="form-control" >
										<option value="">Select In Campus</option>
										<option value="Y">Inside</option>
										 <option value="N">Outside</option>
									</select> 
									<span style="color:red;"><?php echo form_error('campus_id');?></span>										
								</div>
								
								
								
										<div class="col-sm-4">
								<label >Actual Capacity:</label><?=$astrik?>
										<input type="text" id="actual_capacity" value="<?=$hostel_details['actual_capacity']?>" name="actual_capacity" placeholder="Actual Capacity" class="form-control"  />
										
											<span style="color:red;"><?php echo form_error('actual_capacity');?></span>
										
										</div>
							
																	
								
								
								
								
								
								
								
								
							</div>												
							
							<div class="form-group">
                                
                                <div class="col-sm-4">
								<label >Select State:<?=$astrik?></label>
                                  <select class="form-control" name="hstate_id" id="hstate_id" >
                                      <option value="">select State</option>
                                      <?php //echo "state".$state;exit();
                                        if(!empty($state)){
                                            foreach($state as $stat){
                                                ?>
                                              <option value="<?=$stat['state_id']?>"><?=$stat['state_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
                                  </select>
								  
                                </div>
								 <div class="col-sm-4">
								 <label >Select District:<?=$astrik?></label>
                                  <select class="form-control" name="hdistrict_id" id="hdistrict_id" >
                                      <option value="">select District</option>
                                  </select>
                                </div>
								<div class="col-sm-4">
								<label >Select City:<?=$astrik?></label>
                                   <select class="form-control" name="hcity" id="hcity" >
                                      <option value="">select City</option>
                                  </select>
                                </div>
								
							</div>
							
							
								 <div class="form-group">
                                                                        
                                   
                                    <div class="col-sm-4">
													<label>Address:<?=$astrik?></label>				
									<textarea id="h_address" class="form-control" NAME="h_address" placeholder="Enter Address" ><?=$hostel_details['Address']?></textarea><span style="color:red;"><?php echo form_error('h_address');?></span>
									</div> 
									
									<div class="col-sm-4">
								<label >Enter Area: <?=$astrik?></label>
								<input type="text" id="h_area" name="h_area" value="<?=$hostel_details['Area']?>" class="form-control" placeholder="Enter Area" /><span style="color:red;"><?php echo form_error('h_area');?></span></div>  

								
								<div class="col-sm-4">
								<label>Enter Pincode: <?=$astrik?></label>
								<input type="text" id="hostel_pincode" value="<?=$hostel_details['pincode']?>" name="hostel_pincode" class="form-control" placeholder="Enter Pincode"  /><span style="color:red;"><?php echo form_error('hostel_pincode');?></span>
								</div>
									
                                </div>
								
								
								<div class="form-group">
                                    
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
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

var status=0;
function check_exists()
{
	var hname = $("#hostel_name").val();
	var hcode = $("#hostel_code").val();
	var host_id='<?=$this->uri->segment(3)?>';
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Hostel/check_hcode_exist',
		data: { hname: hname,hcode:hcode,host_id:host_id},
		success: function (html) {
			//alert(html);
			var arr=html.split("||");
			if(arr[1]!=0 && arr[0]!=0)
			{$('#message').html('Hostel code and name have already exist!!');status=1;}
			else if(arr[0]!=0)
			{$('#message').html('Hostel name has already exist!!');status=1;}	
			else if(arr[1]!=0)
			{$('#message').html('Hostel code has already exist!!');status=1;}
			else 
			{$('#message').html('');status=0;}
		}
	});
}

function form_check_exists()
{
	//event.preventDefault();
	if(status==1){return false;}
}

$(document).ready(function(){
	 // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
	
	var campus='<?=$hostel_details['campus_name']?>';
	$('#campus option').each(function()
	 {              
		 if($(this).val()== campus)
		{
		$(this).attr('selected','selected');
		}
	});
	
	var campus_id='<?=$hostel_details['in_campus']?>';
	$('#campus_id option').each(function()
	 {              
		 if($(this).val()== campus_id)
		{
		$(this).attr('selected','selected');
		}
	});
	
	var hostel_type='<?=$hostel_details['hostel_type']?>';
	$('#hostel_type option').each(function()
	 {              
		 if($(this).val()== hostel_type)
		{
		$(this).attr('selected','selected');
		}
	});
	
	
	var hstate_id='<?=$hostel_details['state_id']?>';
	var district_id='<?=$hostel_details['district_id']?>';
	//alert(district_id);
	var taluka_id='<?=$hostel_details['taluka_id']?>';

	$('#hstate_id option').each(function()
	{              
		 if($(this).val()== hstate_id)
		{
			$(this).attr('selected','selected');
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + hstate_id,
				success: function (html) {
					$('#hdistrict_id').html(html);
					$('#hdistrict_id option').each(function()
					 {              
						 if($(this).val()== district_id)
						{
							//alert(district_id);
							$(this).attr('selected','selected');
							$.ajax({
								type: 'POST',
								url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
								data: { state_id: hstate_id, district_id : district_id},
								success: function (html) {
									//alert(html);
									if(html !=''){
									$('#hcity').html(html);
									}else{
									  $('#hcity').html('<option value="">No city found</option>');  
									}
									$('#hcity option').each(function()
									 {              
										 if($(this).val()== taluka_id)
										{
											//alert(district_id);
											$(this).attr('selected','selected');
										}
									 });
								}
							});
						}
					 });
						
				}
			});
				
			
		} 
		
	});  
	
	
	
	    // Num check logic
/*   	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	}); */
	
		$('#hostel_code').on('change', function () {
		 var hostel_code = $(this).val();
		 var host_id= $("#host_id").val();
//		alert("called==="+stateID);
		if (hostel_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/check_hcode_exist',
				data: { hostel_code: hostel_code, host_id : host_id},
				success: function (html) {
					//alert("err=="+html);
					$('#err_hcode').html(html);
				}
			});
		} else {
			$('#hdistrict_id').html('<option value="">Select state first</option>');
		}
	});
  	
    // City by State
	$('#hstate_id').on('change', function () {
		 var stateID = $(this).val();
		alert("called==="+stateID);
		if (stateID) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStatewiseDistrict',
				data: 'state_id=' + stateID,
				success: function (html) {
					//alert(html);
					$('#hdistrict_id').html(html);
					//var divdata=$('#err_hcode').text();
				}
			});
		} else {
			$('#hdistrict_id').html('<option value="">Select state first</option>');
		}
	});
	
    // City by State
	$('#hdistrict_id').on('change', function () {
		var district_id = $(this).val();
		var state_ID = $("#hstate_id").val();
	//	alert(state_ID);alert(district_id);
		if (district_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Ums_admission/getStateDwiseCity',
				data: { state_id: state_ID, district_id : district_id},
				success: function (html) {
					//alert(html);
					if(html !=''){
					$('#hcity').html(html);
					}else{
					  $('#hcity').html('<option value="">No city found</option>');  
					}
				}
			});
		} else {
			$('#hcity').html('<option value="">Select district first</option>');
		}
	});	
	
	
	});	

</script>
