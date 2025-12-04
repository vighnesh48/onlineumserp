<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>
var bed_assigned=0;    
    $(document).ready(function()
    {
		var id='<?=$guesthouse_details['gh_id']?>';
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Guesthouse/check_guesthouse_beds_remaining',
				data: {ghid:id},
				success: function (html) {
					  
					if(html>0)
					bed_assigned=html;
				}
		});
		
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
                
				gname:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Guest house Name'
                      },
                      required: 
                      {
                       message: 'Please Enter Guest house Name'
                      }
                     
                    }
                },
               capacity:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter Bed capacity'
                      },
                      required: 
                      {
                       message: 'Please Enter Bed Capacity'
                      }
                     
                    }
                },
				campus:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Guest house campus'
                      },
                      required: 
                      {
                       message: 'Please select Guest house campus'
                      }
                     
                    }
                },
				address:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: ' Location should not be empty'
                      },
                      stringLength: 
                        {
                        max: 50,
                        min: 2,
                        message: ' Location should be 2-50 characters.'
                        }
                    }
                },gtype:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Guest house Type'
                      },
                      required: 
                      {
                       message: 'Please select Guest house Type'
                      }
                     
                    }
                }
            }       
        })
		
		
		$('.alphaonly').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z. ]/g,'') ); }
		);
		$('.alphanum').bind('keyup blur',function(){ 
			var node = $(this);
			node.val(node.val().replace(/[^a-zA-Z0-9 ]/g,'') ); }
		);
		
		$('.numbersOnly').keyup(function () {
		
		if (this.value != this.value.replace(/[^0-9]/g, '')) {
		   this.value = this.value.replace(/[^0-9]/g, '');
		} 
		});
		
    });

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Guest House</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm">
			<i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit Guest House </h1>
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter Details</span>
							
							<span id="flash-messages" style="color:Green;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
			<span id="flash-messages" style="color:red;padding-left:50px;">
			 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/edit_guesthouse_submit/'.$guesthouse_details['gh_id'])?>" method="POST" onsubmit="return validate_faci_category(event)">     
							
							<input type="hidden" id="sghl" name="sghl" value="" />
								<div id="display_loc" style="display:none;">
								<div class="form-group">
                                    <label class="col-sm-3">Hostel: <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
									<select id="hostel" name="hostel" readonly  onchange="get_room_number()" class="form-control" required>
											  <option value="">Select hostel</option>
									<?php //echo "state".$state;exit();
                                        if(!empty($hostel_details)){
                                            foreach($hostel_details as $hostel){
                                                ?>
                                              <option value="<?=$hostel['host_id']?>"><?=$hostel['hostel_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
									  </select>
									  </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('hostel');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-3">Room Number: <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
									<select id="room" name="room" readonly class="form-control" required>
									  </select>
									  </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('room');?></span></div>
                                </div>
								</div>
                                <div class="form-group">
                                    <label class="col-sm-3">Guest House Name<?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <input type="text"  value="<?=$guesthouse_details['guesthouse_name']?>" id="gname" name="gname" onchange="check_guesthouse_exists()" class="form-control" required />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('bno');?></span></div>
                                </div>
								
                                
    <div class="form-group">
 <label class="col-sm-3"> No.Singel Bed <?=$astrik?></label>       
 <?php
$c = explode(",",$guesthouse_details['doubel_bed']); 

$s = $guesthouse_details['bed_capacity'] - count($c);

 ?>
<div class="col-sm-3">  <input type="text" id="singel_bed" name="singel_bed" value="<?=$s?>" onblur="cal_total();" class="form-control " required /></div>

<label class="col-sm-3"> No.Doubel Bed <?=$astrik?></label>       
<div class="col-sm-3">  <input type="text" id="doubel_bed" name="doubel_bed" value="<?=count($c)?>"  onblur="cal_total();" class="form-control " required /></div>
</div>
                                <div class="form-group">

<label class="col-sm-3"> Total <?=$astrik?></label>    
<div class="col-sm-3">  <input type="text" id="capacity" name="capacity" value="<?= $guesthouse_details['bed_capacity']?>" readonly class="form-control " required /></div>
                                </div>




							
								
								<!--<div class="form-group">
                                    <label class="col-sm-3">Location<?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                      <textarea class="form-control" id="address" name="address" > <?=$guesthouse_details['location']?> </textarea>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('address');?></span></div>
                                </div>-->
								
								
								<div class="form-group">
                                    <label class="col-sm-3">Is Active? <?=$astrik?></label>                 
                                    <div class="col-sm-3">
                                        <select id="status" name="status"  class="form-control" required>
											  <option value="">Select Is Active</option>
											  <option value="Y">Yes</option>
											  <option value="N">No</option>
                                    </select>                                   
                                    
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('status');?></span></div>
                                </div>
								
                                <div class="form-group">
                                   <div class="col-sm-2"></div>  
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Update</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/view_guesthouse')?>'">Cancel</button></div>
                                    <div class="col-sm-6">
									<span style="color:red;padding-left:0px;" id="err_msg"></span>
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


<script>
function cal_total(){
  var sbed = $('#singel_bed').val();
  var dbed = $('#doubel_bed').val();
  var tt = parseInt(sbed)+parseInt(dbed);
  $('#capacity').val(tt);
}
var status=0;
function check_guesthouse_exists()
{
	var id='<?=$guesthouse_details['gh_id']?>';
	var campus=$('#campus').val();
	var gname=$('#gname').val();
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Guesthouse/check_guesthouse_exists',
			data: {campus:campus,gname:gname,id:id},
			success: function (html) {
				  
				if(html>0)
				{$('#err_msg').html("This Guest House Name is already exists.");status=1;}
			else
				{$('#err_msg').html("");status=0;}
			}
	}); 
}

function check_guesthouse_beds_remaining()
{
	var changed=$('#capacity').val();
	var actual_bed='<?=$guesthouse_details['bed_capacity']?>';
	if(changed < actual_bed)
	{
		var remaining=actual_bed-bed_assigned;
		var reducedto=actual_bed-changed;//bed_assigned
		if(remaining < reducedto)
			{
				//alert('kkkkk');
				$('#err_msg').html("You can reduce up to "+remaining+" beds. Rest All beds are assigned.");status=1;
			}
		else
			{
				//alert('lll');
				$('#err_msg').html("");status=0;
			}
	}
}

function validate_faci_category(events)
{
	if(status==1)
	{ return false;}
}
function display_location()
{
	var ghl=$('#ghl').val();
	if(ghl=='H')
		$('#display_loc').show();
	else
		$('#display_loc').hide();

}

var loc='<?=$guesthouse_details['location']?>';
//alert(loc);
	var ghl ='';
	var hostel = 0;
	var room = 0;

function get_room_number()
{
	var host=$('#hostel').val();
	var html=0;

	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Guesthouse/get_rooms_detailsbyhid',
			data: {host_id:host},
			success: function (html) {//rm_dts
				if(html !== "{\"rm_dts\":null}")
				{
					var array=JSON.parse(html);
					var len=array.rm_dts.length;
					
					var cont='<option value="">Select Room Number</option>';
					for (i=0;i<len;i++)
					{
						cont+='<option value="'+array.rm_dts[i].room_no+'">'+array.rm_dts[i].room_no+'</option>';
						
					}
					
					if(host==hostel)
					{cont+='<option value="'+room+'">'+room+'</option>';}
					$('#room').html(cont);
				}
			}
	}); 
}

$(document).ready(function(){

	if(loc=='T')
	{
		$('#sghl').val('T');
	}
	else
	{
		var arr=loc.split('_');
		ghl = arr[0];
		$('#sghl').val(ghl);
		hostel = arr[1];
		room = arr[2];
		if(ghl=='H')
			$('#display_loc').show();
		else
			$('#display_loc').hide();
	}
	
	$('#ghl option').each(function()
	{
		if($(this).val()== ghl)
		{
			$(this).attr('selected','selected');
		}
	});
	
	$('#hostel option').each(function()
	{
		if($(this).val()== hostel)
		{
			$(this).attr('selected','selected');
			$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Guesthouse/get_rooms_detailsbyhid',
			data: {host_id:hostel},
			success: function (html) 
				{
					if(html !== "{\"rm_dts\":null}")
					{
						var array=JSON.parse(html);
						var len=array.rm_dts.length;
						
						var cont='<option value="">Select Room Number</option>';
						for (i=0;i<len;i++)
						{
							cont+='<option value="'+array.rm_dts[i].room_no+'">'+array.rm_dts[i].room_no+'</option>';
							
						}
						cont+='<option value="'+room+'">'+room+'</option>';
						$('#room').html(cont);
						$('#room option').each(function()
						{
							if($(this).val()== room)
							{
								$(this).attr('selected','selected');
							}
						});
					}
				}
			});
			
		}
	});
	
	var campus='<?=$guesthouse_details['campus']?>';
	$('#campus option').each(function()
	{
		if($(this).val()== campus)
		{
			$(this).attr('selected','selected');
		}
	});
	
	var status='<?=$guesthouse_details['is_active']?>';
	$('#status option').each(function()
	{
		if($(this).val()== status)
		{
			$(this).attr('selected','selected');
		}
	});
	
	var gtype='<?=$guesthouse_details['guesthouse_type']?>';
	$('#gtype option').each(function()
	{
		if($(this).val()== gtype)
		{
			$(this).attr('selected','selected');
		}
	});

	
	});	
</script>
