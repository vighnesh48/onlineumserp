<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>
var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
];
var status=0;
function validate_form(events)
{
	/* var visit = $("#visit").val();
	var distance = $("#distance").val();
	if(visit=="" && sbus=="")
	{    
		$('#err_msg').html("Please Enter/Select Bus Number");
		return false;
	}
	else if(bus=="" && sbus=="")
	{    
		$('#err_msg').html("Please Enter/Select Bus Number");
		return false;
	} 
	else */if(status==1)
	{ return false;}
}

$(document).ready(function(){
	
	setTimeout(function() {
			$(".hide-it").hide();
		}, 5000);
		
	$('#distance').on('change', function (){
		var node = $(this);
		if(((node.val().match(/[/.]/g) || []).length) > 1)
		{
			$("#err_msg1").html('Invalid decimal number(more than two dots).');
			status=1;
		}
		else
		{
			$("#err_msg1").html('');status=0;
		}
	});
	
	$('.numbersOnly').keyup(function () {
		if (this.value != this.value.replace(/[^0-9.]/g, '')) {
		   this.value = this.value.replace(/[^0-9.]/g, '');
		} 
	});
	
	$('.alphaonly').bind('keyup blur',function(){ 
		var node = $(this);
		node.val(node.val().replace(/[^a-zA-Z ]/g,'') ); }
	);
		
    $('#sbutton').click(function()
	{
		var base_url = '<?=base_url();?>';
		var bus = $("#prn").val();
		var sbus = $("#bus").val();
		var ttype = $("#ttype").val();
		
		$('#checkinout').hide();
		$('#ttype_out').val('');
		$('#busno_out').val('');
		$('#rname_out').val('');
		$('#ttime_out').val('');
		$('#rid_out').val('');
		$('#tdate_out').val('');
		$('#check_in').hide();
		$('#check_out').hide();
		
		if(bus=="" && sbus=="")
		{    
			$('#err_msg').html("Please Enter/Select Bus Number");
			return false;
		}
		else if(ttype=="")
		{
			$('#err_msg').html("Please Select Trip Type");
			return false;
		}
        else
		{  //alert(hgp_id);
			if(bus=="")
				bus=sbus;

			$.ajax({
				'url' : base_url + '/Transport/bus_checkincheckout',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'bus':bus,'ttype':ttype},
				'success' : function(data){ 
					//alert("data===="+data);
					if(data != "{\"bus_trip_details\":\"Invalid Bus Number\"}")
					{
						var array=JSON.parse(data);
					//alert(array.bus_trip_details[0].bus_no+'=='+array.bus_trip_details[0].route_name);
						$('#busno').html(array.bus_trip_details[0].bus_no);
						$('#rname').html(array.bus_trip_details[0].route_name);
						$('#dname').html(array.bus_trip_details[0].driver_name);
						var t_date = new Date(array.bus_trip_details[0].trip_date);
						$('#tdate').html(t_date.getDate()+'-'+monthNames[t_date.getMonth()]+'-'+t_date.getFullYear());
						
						$('#ttime').html(array.bus_trip_details[0].trip_time);
						$('#rid_out').val(array.bus_trip_details[0].route_id);
						
						$('#ttype_out').val(ttype);
						$('#busno_out').val(array.bus_trip_details[0].bus_no);
						$('#rname_out').val(array.bus_trip_details[0].route_name);
						$('#status').val(array.bus_trip_details[0].status);
						var t_date = new Date(array.bus_trip_details[0].trip_date);
						$('#tdate_out').val(t_date.getDate()+'-'+monthNames[t_date.getMonth()]+'-'+t_date.getFullYear());
						
						$('#ttime_out').val(array.bus_trip_details[0].trip_time);
						
						if(array.bus_trip_details[0].status=='OUT')
						{
							//alert("Going out");
							$('#checkinout').show();
							$('#err_msg').html('');
							$('#check_in').hide();
							$('#check_out').show();
							
							if(ttype=="tour")
								$('#tour_div').show();
							else
								$('#tour_div').hide();
							
							$('#check_out').html('<button class="btn btn-primary form-control" id="checkout" type="submit" >Check Out</button>');
							
						}
						else 
						{
							//alert("Coming In");
							$('#checkinout').show();
							$('#err_msg').html('');
							
							$('#check_in').html('<button class="btn btn-primary form-control" id="checkin" type="submit" >Check In</button>');
							$('#check_in').show();
							$('#check_out').hide();
						}
						
						
					}
					else
					{
						$('#checkinout').hide();
						$('#err_msg').html('Please check the Bus No,it may be wrong or doesnot exist.');
					}
				}
			});
		}
    });
});



</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Transport </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Bus Trip Entry</h1>
					
			<span class="hide-it" id="flash-messages" style="color:Green;padding-left:250px;">
			<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
			<span class="hide-it" id="flash-messages" style="color:red;padding-left:250px;">
			<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
					<div class="row">
                      <div class="col-sm-2">
						<select class="form-control" name="bus" id="bus">
								<option value="">Select Bus</option>
							<?php 
									if(!empty($bus_details)){
										foreach($bus_details as $bus){
											?>
										  <option value="<?=$bus['bus_no']?>"><?=$bus['bus_no']?></option>  
										<?php 
											
										}
									}
							  ?>	
							</select>
						</div>
					   <label class="col-sm-1" style="text-align:center;">Or</label>
					   <div class="col-sm-2">
					   <input type="text" class="form-control" name="prn" id="prn" placeholder="Bus No">
					   </div>
					   <div class="col-sm-2">
						<select class="form-control" name="ttype" id="ttype">
								<option value="">Select Trip Type</option>
								<option value="single">Single</option>
								<option value="double">Double</option>
								<option value="tour">Tour</option>
							</select>
						</div>
                      <div class="col-sm-2">
					  <button class="btn btn-primary form-control" id="sbutton" type="button" >Submit</button>
					  </div>
					  <div class="col-sm-2">
					   <button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/trip_list')?>'">Cancel</button>
					  </div>
					  
					  
                    </div>
                </div>
				<h4 id="err_msg" style="color:red;padding-left:200px;"></h4>
                <div class="panel-body"  id="checkinout" style="display:none;">
					
					<table class="table table-bordered" style="max-width:50%;">
						 <tr>
						  <th>Bus Number :</th>
						  <td class="col-sm-4"><span id="busno"></span></td>
						</tr> 
						 <tr>
						 <th>Route Name:</th>
						  <td class="col-sm-4"><span id="rname"></span></td>
						</tr>
						<tr>
						 <th>Driver Name:</th>
						  <td class="col-sm-4"><span id="dname"></span></td>
						</tr>
						<tr>
						 <th>Trip Date:</th>
						  <td class="col-sm-4"><span id="tdate"></span></td>
						</tr>	
						<tr>
						 <th>Trip Time:</th>
						  <td class="col-sm-4"><span id="ttime"></span></td>
						</tr>						
				</table>
					
					
						
						<form name="form" id="form" action="<?=base_url($currentModule.'/add_trip_entry')?>" method="POST"  onsubmit="return validate_form(event)">
						<input type="hidden" id="rid_out" name="rid_out" />
						<input type="hidden" id="ttype_out" name="ttype_out" />
						<input type="hidden" id="busno_out" name="busno_out" />
						<input type="hidden" id="rname_out" name="rname_out" />
						<input type="hidden" id="tdate_out" name="tdate_out" />
						<input type="hidden" id="ttime_out" name="ttime_out" />
						<input type="hidden" id="status" name="status" />
						<div id="tour_div" style="display:none;">
							<div class="form-group">
							<label class="col-sm-2" style="text-align:center;">Visit Location:</label>
						   <div class="col-sm-2">
						   <input type="text" class="form-control alphaonly" name="visit" id="visit" placeholder="Visit Location" >
						   </div>
							</div>
						  <div class="form-group">
						   <label class="col-sm-2" style="text-align:center;">Distance From Campus:</label>
							<div class="col-sm-2">
						   <input type="text" class="form-control numbersOnly" name="distance" id="distance" placeholder="Distance From Campus" >
						   </div>
						  <div class="col-sm-6"> 
						  <h4 id="err_msg1" style="color:red;"></h4>
						   </div>
							</div>
						
						</div>
						<div class="col-sm-2" >
						 <div  id="check_out" style="display:none;"></div>
						 <div  id="check_in" style="display:none;"></div>
						 </div>
						</form>
						
					
					  
					 <div class="col-sm-2" > 
					  <button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/trip_entry')?>'">Cancel</button>
					</div>
				</div>
    </div>
</div>
                    
