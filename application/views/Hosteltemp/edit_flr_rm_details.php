<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
var cat_type='';var status=0;
var err_count=0;
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
	
	if(err_count==1)
	{ return false;}
	
}


function check_cat_type(id,id_num)
{
	cat_type=$('#'+id).val();
	//alert(cat_type+id_num);
	if(cat_type=="Gym" || cat_type=="Parlour")
	{
		$('#flrbeds_'+id_num).val(1);
	}
}

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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Floor Details</h1>
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
                <div class="panel-body"  style="overflow-x:scroll;height:510px;">
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
                    <div class="table-info" >    
                    <form id="form" name="form" action="<?=base_url($currentModule.'/hostel_details_submit')?><?='/'.$this->uri->segment(3)?>" method="POST" onsubmit="return validate_roomcategory(event)">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
									<th>#</th>
                                    <th>Code</th>
                                    <th>#Floor</th>
                                    <th>#Room</th>
									<th>#Beds</th>
									<th>Room Type</th>
									<th>Room Category</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
							
                            $j=1;                      
                            for($i=0;$i<count($h_flr_rm_details);$i++)
                            {
                                $temp_flr=$h_flr_rm_details[$i]['floor_no'];
								if($temp_flr==0)
									$temp_flr='G';
								else
									$temp_flr=$h_flr_rm_details[$i]['floor_no'];
                            ?>
							<input type="hidden" value="<?=$h_flr_rm_details[$i]['hostel_code']?>" id="h_code<?=$i?>" name="h_code[]" />
							<input type="hidden" value="<?=$h_flr_rm_details[$i]['host_id']?>" id="host_id<?=$i?>" name="hostel_id[]" />
							<input type="hidden" value="<?=$h_flr_rm_details[$i]['sf_room_id']?>" id="h_rm_id<?=$i?>" name="h_rm_id[]" />
							<input type="hidden" value="<?=$h_flr_rm_details[$i]['floor_no']?>" id="floor_no<?=$i?>" name="floor_no[]" />

							
                            <tr <?=$h_flr_rm_details[$i]["Is_active"]=="N"?"style='background-color:#FBEFF2'":""?>>

							<td><?=$j?></td>
							<td><?=$h_flr_rm_details[$i]['hostel_code']?></td>
							<td><?=$temp_flr?>
								<!--<input style="width: 50px;" name="floor_no[]" value="<?=$h_flr_rm_details[$i]['floor_no']?>" type="text" id="flrnos_<?=$i?>" />-->
							</td>
							<td>
								<input style="width: 50px;" name="roomno[]" value="<?=$h_flr_rm_details[$i]['room_no']?>" type="text" id="rmsno_<?=$i?>" onchange="check_r(this.id,<?=$i?>)"/><br/>
								<span style="color:red;display:none;" id="rm_err_msg_<?=$i?>">Room No Already Existed!!</span>
							</td>
							<td>
								<input style="width: 50px;" name="floorbeds[]"  onChange="check_beds(this.id)" value="<?=$h_flr_rm_details[$i]['no_of_beds']?>" type="text" id="flrbeds_<?=$i?>"/>
							</td>
							<td>
								<select class="rm_type" form-control" name="flr_rm_type[]" id="flr_rm_type_<?=$i?>">
								<?
								$E_str=$D_str="";
								if($h_flr_rm_details[$i]['room_type']=='Executive')
								$E_str="selected";
							else
								$D_str="selected";
								?>
								<option value="">Select Room Type</option>
								<option <?=$E_str?> value="Executive">Executive</option>
								<option <?=$D_str?> value="Delux">Deluxe</option>
								</select>
							</td>
							<td>
								<select class="rm_cat" form-control" name="flr_rm_cat[]" id="flr_rm_cat_<?=$i?>" onchange="check_cat_type(this.id,'<?=$i?>')" id="flr_rm_cat_'+i+'">
						
							
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
												?>
												<option value="">Select Category</option>
												<option <?=$Stay?> value="Stay Room">Stay Room</option>
												<option <?=$Guest?> value="Guest House">Guest House</option>
												<option <?=$Room?> value="TV Room">TV Room</option>
												<option <?=$Gym?> value="Gym">Gym</option>
												<option <?=$Polour?> value="Parlour">Parlour</option>
												<option <?=$Rector?> value="Rector Room">Rector Room</option>
													<option <?=$Washroom?> value="Washroom">Washroom</option>
								</select>
							</td>
							</tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>                    
                   
				    <div class="form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update All</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule."/view_room_details/".$this->uri->segment(3))?>'">Cancel</button></div>
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
var total_rms=0,total_bds=0,allocated_rms=0,allocated_bds=0,available_rms=0,available_bds=0;
var host_id='<?=$this->uri->segment(3)?>';
var floor='';
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
		
	$('input[name="floorbeds[]"]').each(function() {
		initial_beds+=parseInt(this.value);
    });
	
	
	
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

function check_r(id,id_num)
{
	
	var h_rm_id=$('#h_rm_id'+id_num).val();
	var h_id=$('#host_id'+id_num).val();
	var floor=$('#flrnos_'+id_num).val();
	var r_no=$('#'+id).val();
	//alert("called"+h_rm_id+"called"+h_id+"called"+floor+"called"+r_no);
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Hostel/check_rm_exist_byflrhid',
			data: { h_rm_id:h_rm_id , hid:h_id , flr_no : floor , r_no:r_no},
			success: function (html) {
				//alert(html);
				if(html==1)
				{
				$('#rm_err_msg_'+id_num).show();
				$('#rm_err_msg_'+id_num).focus();
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
	else if(noof_beds>12)
	{$('#'+id).val(12);$('#err_msg').html('<span style="color:red;" > Maximum you can enter only 12 beds!!</span>');}
	else
	{$('#'+id).val(noof_beds);$('#err_msg').html('');}
	
	var sum=0;
	$('input[name="floorbeds[]"]').each(function() {
		sum+=parseInt(this.value);
    });
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