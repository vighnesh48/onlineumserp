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
				room_type:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select room_type'
                      },
                      required: 
                      {
                       message: 'Please select room_type'
                      }
                     
                    }
                },
				category:
				{
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select category'
                      },
                      required: 
                      {
                       message: 'Please select category'
                      }
                     
                    }
                },
				tot_beds:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Total No. Of beds should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Total No. Of beds should be numeric'
                      }/* ,
                       stringLength: 
                        {
                        max: 1,
                       
                        message: 'Total No. Of beds should not be more than 9.'
                        }  */
                    }
                },
				tot_rooms:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Room Number should not be empty'
                      }
                     /*, regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Room Number should be numeric'
                      }
                       stringLength: 
                        {
                        max: 12,
                        min: 10,
                        message: 'Mobile number should be 10-12 characters.'
                        } */
                    }
                }
			}       
        })
    });
var err_count=0;
function validate_roomcategory(events)
{
	var cat_type=$('#category').val();
	if(cat_type=="Gym" || cat_type=="Parlour")
	{
		$('#tot_beds').val(1);
	}
	if(err_count==1)
	{ return false;}
}

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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Room Details</h1>
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
                        <span style="color:red;padding-left:40px;"  id="err_msg"></span>
                </div>
                    <div class="panel-body">
                        <div class="col-sm-7">                            
                             
                            <form id="form" name="form" action="<?=base_url($currentModule.'/edit_room_submit')?><?='/'.$h_room_details['sf_room_id']?>" method="POST"  onsubmit="return validate_roomcategory(event)">
							
							<input type="hidden" id="hostel_id" name="hostel_id" class="form-control" value="<?=$h_room_details['host_id']?>"/>
							
								<div class="form-group">
                                    <label class="col-sm-4">Hostel Code <?=$astrik?></label>
                                    <div class="col-sm-8"><input type="text" id="hostel_code" name="hostel_code" class="form-control" value="<?=$h_room_details['hostel_code']?>" readonly/>
									<span style="color:red;" id="err_hcode"><?php echo form_error('hostel_code');?></span>
									</div>                                    
                                    
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-4">Floor No<?=$astrik?></label>
                                    <div class="col-sm-8"><input type="text" id="tot_flr" name="tot_flr" class="form-control" value="<?=$h_room_details['floor_no']?>" />
									<span style="color:red;"><?php echo form_error('tot_flr');?></span>
									</div>                                    
                                    
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-4">Room No. <?=$astrik?></label>
                                    <div class="col-sm-8"><input type="text" id="tot_rooms" name="tot_rooms" class="form-control" value="<?=$h_room_details['room_no']?>" onchange="check_r(this.id)" />
									<span style="color:red;"><?php echo form_error('tot_rooms');?></span>
									</div>                                    
                                    
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-4">Total No. Of beds<?=$astrik?></label>
                                    <div class="col-sm-8"><input type="text" onChange="check_beds(this.id)" id="tot_beds" name="tot_beds" class="form-control" value="<?=$h_room_details['no_of_beds']?>" />
									<span style="color:red;"><?php echo form_error('tot_beds');?></span>
									</div>                                    
                                    
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-4">Select Room Type <?=$astrik?></label>                                    
                                    <div class="col-sm-8">
                                        <select id="room_type" name="room_type" class="form-control" >
                                        <?
											$E_str=$D_str="";
											if($h_room_details['room_type']=='Executive')
											$E_str="selected";
											else
											$D_str="selected";
											?>
											<option value="">Select Room Type</option>
											<option <?=$E_str?> value="Executive">Executive</option>
											<option <?=$D_str?> value="Delux">Deluxe</option>
										</select>         
<span style="color:red;"><?php echo form_error('room_type');?></span>										
                                    </div>                                    
                                    
                                </div>
                                
								<div class="form-group">
                                    <label class="col-sm-4">Select Room Category <?=$astrik?></label>                                    
                                    <div class="col-sm-8">
                                        <select id="category" name="category" class="form-control" >
                                            <?
												$Stay=$Guest=$Room=$Gym=$Polour=$Rector=$Washroom="";
												if($h_flr_rm_details[$i]['category']=='Stay Room')
												$Stay="selected";
												elseif($h_flr_rm_details[$i]['category']=='Guest House')
												$Guest="selected";
												elseif($h_flr_rm_details[$i]['category']=='TV Room')
												$Room="selected";
												elseif($h_flr_rm_details[$i]['category']=='Gym')
												$Gym="selected";
												elseif($h_flr_rm_details[$i]['category']=='Parlour')
												$Polour="selected";
												elseif($h_flr_rm_details[$i]['category']=='Rector Room')
												$Rector="selected";
												elseif($h_flr_rm_details[$i]['category']=='Washroom')
												$Washroom="selected";
												elseif($h_flr_rm_details[$i]['category']=='Server Room')
												$server="selected";
												?>
												<option value="">Select Category</option>
												<option <?=$Stay?> value="Stay Room">Stay Room</option>
												<option <?=$Guest?> value="Guest House">Guest House</option>
												<option <?=$Room?> value="TV Room">TV Room</option>
												<option <?=$Gym?> value="Gym">Gym</option>
												<option <?=$Polour?> value="Parlour">Parlour</option>
												<option <?=$Rector?> value="Rector Room">Rector Room</option>
													<option <?=$Washroom?> value="Washroom">Washroom</option>
													<option <?=$Server?> value="Server Room">Server Room</option>
											</select>    
<span style="color:red;"><?php echo form_error('category');?></span>											
                                    </div>                                    
                                    
                                </div>
								
								
								
								
                                <div class="form-group">
                                    
                                    <div class="col-sm-3">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
                                    </div>                                    
                                    <div class="col-sm-3"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule."/view_room_details/".$h_room_details['host_id'])?>'">Cancel</button></div>
                                    
                                </div>
                            </form>
                            
                        </div>
						
						<div class="table-info col-sm-5" id="rms_bds_dtls" style="display:none;">                 
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
						
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script>

var total_rms=0,total_bds=0,allocated_rms=0,allocated_bds=0,available_rms=0,available_bds=0;
var host_id='<?=$h_room_details['host_id']?>';
var floor='<?=$h_room_details['floor_no']?>';
var actualbeds=0;
var initial_beds=0;

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

$(document).ready(function(){
	initial_beds=$('#tot_beds').val();
	rooms_allocation_details(host_id,floor);
	    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
	});
  	
	var room_type='<?=$h_room_details['room_type']?>';
	$('#room_type option').each(function()
	 {              
		 if($(this).val()== room_type)
		{
		$(this).attr('selected','selected');
		}
	});
	
	var category='<?=$h_room_details['category']?>';
	$('#category option').each(function()
	 {              
		 if($(this).val()== category)
		{
		$(this).attr('selected','selected');
		}
	});
	
	
});

function check_r(id)
{
	//alert("called");
	var hostel_code='<?=$h_room_details['hostel_code']?>';
	var rm_id='<?=$h_room_details['sf_room_id']?>';
	var floor='<?=$h_room_details['floor_no']?>';
	var r_no=$('#'+id).val();
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Hostel/check_rm_exist_byflr_rid',
			data: { hostel_code:hostel_code,sf_room_id:rm_id,flr_no : floor,r_no:r_no},
			success: function (html) {
				//alert(html);
				if(html==1)
				{
				$('#err_msg').html("Room No Already Existed!!");
				$('#'+id).focus();
				}
			else
				$('#err_msg').html("");
			}
		});
}


var temp_bds=0;
function check_beds(id)
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
	else if(noof_beds>16)
	{$('#'+id).val(16);$('#err_msg').html('<span style="color:red;" > Maximum you can enter only 16 beds!!</span>');}
	else
	{$('#'+id).val(noof_beds);$('#err_msg').html('');}
	
	var sum=$('#'+id).val();
	
	//alert("actualbeds="+actualbeds+"sum="+sum+"available_bds="+available_bds+"initial_beds="+initial_beds);
	temp_bds=((parseInt(available_bds)+parseInt(initial_beds))-parseInt(sum));
	
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