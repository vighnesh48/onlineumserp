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
			<i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Guest House </h1>
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Enter Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_guesthouse_submit')?>" method="POST" onsubmit="return validate_faci_category(event)">     
							<div class="form-group">
								<label class="col-sm-3">Campus:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="campus" name="campus"  onchange="check_guesthouse_exists();get_hostel_list();" class="form-control" required>
											  
                       <?php 
                        $exp = explode("_",$this->session->userdata("name"));
   // echo $exp[1];
         if($exp[1]=="sijoul")
        {              ?>
               <option value="SIJOUL">Sijoul</option>
       <?php }elseif($exp[1]=="nashik")
        { ?>
          <option value="NASHIK">Nashik</option>           
       <?php }else{ ?>
        <option value="">Select Campus</option>
       

											  <option value="NASHIK">Nashik</option>   
											  <option value="SIJOUL">Sijoul</option>
                        <?php } ?>
                                    </select>
									  
									  <div class="col-sm-3"><span style="color:red;"><?php echo form_error('campus');?></span></div>
								</div> 
								<label class="col-sm-3">Guesthouse Location:<?=$astrik?></label>
									<div class="col-sm-3">
									<select id="ghl" name="ghl"  onchange="display_location()" class="form-control" required>
											  <option value="">Select Guesthouse Location</option>
 <?php $rid= $this->session->userdata("role_id"); 
 if($rid=='17'){ ?>
											  <option value="H">Hostel</option>
											  <?php }elseif($rid=='28'){ ?>
											  <option value="T">Trustee Office</option>
											  <?php } ?>
                                    </select>
									 
									  <div class="col-sm-3"><span style="color:red;"><?php echo form_error('ghl');?></span></div>
                     </div> 
								</div>
                <div id="display_loc1" style="display:none;">
                <div class="form-group">
  <label class="col-sm-3">Room Number: <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                  <input type="text" id="roomt" name="roomt" class="form-control" required />
                    
                     <div class="col-sm-3"><span style="color:red;"><?php echo form_error('room');?></span></div>
                            
                    </div> </div>          
                </div>
								<div id="display_loc" style="display:none;">
								<div class="form-group">
                                    <label class="col-sm-3">Hostel: <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
									<select id="hostel" name="hostel"  onchange="get_room_number()" class="form-control" required>
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
									                                     
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('hostel');?></span></div>
                                </div>
								
							
                                    <label class="col-sm-3">Room Number: <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
									<select id="room" name="room" onchange="get_room_details()" class="form-control" required>
									  </select>
                     <div class="col-sm-3"><span style="color:red;"><?php echo form_error('room');?></span></div>
                            
									  </div>                                    
                                       </div>
								
								</div>
                                <div class="form-group">
                                    <label class="col-sm-3">Guest House Name<?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <input type="text" id="gname" name="gname" onchange="check_guesthouse_exists()" class="form-control " required />
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('bno');?></span></div>
                                
                                    </div>                                    
                                    
                                    <label class="col-sm-3"> Floor <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
  <input type="text" id="floor" name="floor" class="form-control " required />
                                    
                                    </div>                                    
                                    </div>
                                <div class="form-group">
 <label class="col-sm-3"> No.Singel Bed <?=$astrik?></label>       
<div class="col-sm-3">  <input type="text" id="singel_bed" name="singel_bed" onblur="cal_total();" class="form-control " required /></div>

<label class="col-sm-3"> No.Doubel Bed <?=$astrik?></label>       
<div class="col-sm-3">  <input type="text" id="doubel_bed" name="doubel_bed" value="0" onblur="cal_total();" class="form-control " required /></div>
</div>
                                <div class="form-group">

<label class="col-sm-3"> Total <?=$astrik?></label>    
<div class="col-sm-3">  <input type="text" id="capacity" name="capacity" readonly class="form-control " required /></div>
                                </div>
								<!-- <div class="form-group">
                                    <label class="col-sm-3"> Bed Capacity <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                    <select id="capacity" name="capacity" onchange="display_check_box()" class="form-control" required>
                                    <option value="">Select Bed Capacity</option>
                                    <?php //for($i=1;$i<=10;$i++){ ?>
<option value="<?=$i?>"><?=$i?></option>
                                     <?php //} ?>
                                     </select>
                                        <!-- <input type="text" id="capacity" name="capacity" class="form-control numbersOnly" required />
                                 -->   
                                 <!-- <div class="col-sm-3"><span style="color:red;"><?php //echo form_error('capacity');?></span></div>
                                    </div>
                       
                                         <label class="col-sm-3" id="sd">  </label>     
 <div class="col-sm-3" id="dbed">

 </div>

                                              </div>
								 -->
								
								<!--<div class="form-group">
                                    <label class="col-sm-3"> Bed Available <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <input type="text" id="bed" name="bed" class="form-control" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php //echo form_error('bed');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-3">Location<?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                      <textarea class="form-control" id="address" name="address" ></textarea>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php //echo form_error('address');?></span></div>
                                </div>
								-->
								
								
                                <div class="form-group">
                                   <div class="col-sm-4"></div>  
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Add</button>                                        
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
function display_check_box(){
  var gt = $('#ghl').val();
  if(gt=='T'){
  var cp = $('#capacity').val();
  var st='';
  for(var i=1;i<=cp;i++){
st += '<input type="checkbox" name="db[]"  value="'+i+'" /> '+i+'&nbsp;&nbsp;&nbsp;';
  }
  $('#sd').html('Select Doubel Beds');
$('#dbed').html(st);
}
}
function get_room_details(e){
  var camp =$('#campus').val();
  var host = $('#hostel').val();
  var rm = $('#room').val();
  //alert(rm);
   $.ajax({
      type: 'POST',
      url: '<?= base_url() ?>Guesthouse/get_room_details',
      data: {camp:camp,host:host,rm:rm},
      success: function (html) {        
        var rd = html.split('_');
        $('#gname').val(rd[0]);
        $('#floor').val(rd[2]);
          $("#capacity option[value='"+rd[2]+"']").prop('selected',true);
     }
  }); 

}
function get_hostel_list(){
    var camp=$('#campus').val();
      $.ajax({
      type: 'POST',
      url: '<?= base_url() ?>Guesthouse/get_campus_hostel_list',
      data: {camp:camp},
      success: function (html) {
        
        $('#hostel').html(html);
     }
  }); 

}
var status=0;
function check_guesthouse_exists()
{
	var campus=$('#campus').val();
	var gname=$('#gname').val();
	var html=0;
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Guesthouse/check_guesthouse_exists',
			data: {campus:campus,gname:gname},
			success: function (html) {
				if(html>0)
				{$('#err_msg').html("This Guest House Name is already Exists.");status=1;}
			else
				{$('#err_msg').html("");status=0;}
			}
	}); 
}

function validate_faci_category(events)
{
	if(status==1)
	{ return false;}
}

function display_location()
{
	var ghl=$('#ghl').val();
	if(ghl=='H'){
		$('#display_loc').show();
     $('#display_loc1').hide();
    $('#sd').html('');
$('#dbed').html('');
$("#roomt").val('');
  }
	else{
		$('#display_loc').hide();
    $('#display_loc1').show();
         $('#gname').val('');
        $('#floor').val('');
         $("#hostel option[value='']").prop('selected',true);
          $("#capacity option[value='']").prop('selected',true);
          $("#room option[value='']").prop('selected',true);
  }

}

function get_room_number()
{
	var hostel=$('#hostel').val();
	var html=0;
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Guesthouse/get_rooms_detailsbyhid',
			data: {host_id:hostel},
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
					$('#room').html(cont);
				}
				else
				{
					cont='<option value="">No Room</option>';
					$('#room').html(cont);
				}
			}
	}); 
}
</script>
