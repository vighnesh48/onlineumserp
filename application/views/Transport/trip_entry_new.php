<script src="<?=base_url()?>assets/javascripts/moment.js"></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datetimepicker.min.js'?> "></script>

<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script>    
    $(document).ready(function()
    {
		
		$('#time').datetimepicker({ format:'HH:mm',stepping:5}).on("dp.change", function (e) {
           //getTotalhrs();
        });
		
		$('#dob-datepicker')
   .datepicker({
	   autoclose: true,
	   todayHighlight: true,
	   format: 'dd-mm-yyyy'
   }).on('changeDate', function (selected) {
    $('#form').bootstrapValidator('revalidateField', 'tdate')
    });
	
	$('#shift').on('change', function (){
		var node = $(this).val();
	if(node=="tour")
		$('#tour_div').show();
	else
		$('#tour_div').hide();
	
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
               nos:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Enter No Of Student'
                      },
                      required: 
                      {
                       message: 'Please Enter No Of Student'
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
                },
				shift:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Shift'
                      },
                      required: 
                      {
                       message: 'Please select Shift'
                      }
                     
                    }
                },
				tdate:
				{
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Trip Date'
                      },
                      required: 
                      {
                       message: 'Please Select Trip Date'
                      }
                     
                    }
                },
				time:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please Select Trip Time'
                      },
                      required: 
                      {
                       message: 'Please Select Trip Time'
                      }
                     
                    }
                },
				checkp:
                {
                    validators: 
                    {
						notEmpty: 
                      {
                       message: 'Please select Check Point'
                      },
                      required: 
                      {
                       message: 'Please select Check Point'
                      }
                     
                    }
                }
            }       
        })
		
    });

</script>
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
                <div class="panel-body">
                        <div class="table-info">                            
                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/add_trip_entry_new')?>" method="POST" onsubmit="return validate_form(event)">     
							<div class="form-group">
								<label class="col-sm-2">Bus:<?=$astrik?></label>
									<div class="col-sm-3">
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
									  <div class="col-sm-3"><span style="color:red;"><?php echo form_error('bus');?></span></div>
								</div>  
                                <div class="form-group">
                                    <label class="col-sm-2">Shift <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <select class="form-control" name="shift" id="shift">
											<option value="">Select Shift</option>
											<option value="single">1</option>
								<option value="double">2</option>
								<option value="tour">3</option>
										</select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('shift');?></span></div>
                                </div>
								
								<div id="tour_div" style="display:none;">
							<div class="form-group">
							<label class="col-sm-2" >Visit Location:</label>
						   <div class="col-sm-3">
						   <input type="text" class="form-control alphaonly" name="visit" id="visit" placeholder="Visit Location" >
						   </div>
							</div>
						  <div class="form-group">
						   <label class="col-sm-2" >Distance From Campus:</label>
							<div class="col-sm-3">
						   <input type="text" class="form-control numbersOnly" name="distance" id="distance" placeholder="Distance From Campus" >
						   </div>
						  <div class="col-sm-6"> 
						  <h4 id="err_msg1" style="color:red;"></h4>
						   </div>
							</div>
						
						</div>
						
                                <!-- <select class="form-control" name="time" id="time">
											<option value="">Select Shift Time</option>
											<option value="5AM-6AM">5AM-6AM</option>
											<option value="6AM-7AM">6AM-7AM</option>
											<option value="6AM-7AM">7AM-8AM</option>
											<option value="6AM-7AM">8AM-9AM</option>
											<option value="6AM-7AM">9AM-10AM</option>
											<option value="6AM-7AM">10AM-11AM</option>
											<option value="6AM-7AM">11AM-12PM</option>
											<option value="5AM-6AM">12PM-1PM</option>
											<option value="6PM-7PM">1PM-2PM</option>
											<option value="6PM-7PM">2PM-3PM</option>
											<option value="6PM-7PM">3PM-4PM</option>
											<option value="6PM-7PM">4PM-5PM</option>
											<option value="6PM-7PM">5PM-6PM</option>
											<option value="6PM-7PM">6PM-7PM</option>
										</select>
										
										
										-->
								<div class="form-group">
                                    <label class="col-sm-2"> Trip Date <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                       
										<input class="form-control" id="dob-datepicker" name="tdate" placeholder="Trip Date" type="text" readonly >
										 
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('tdate');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-2"> Trip Time <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                       
										<input class="form-control" id="time" name="time"placeholder="HH:MM" type="text" >
										 
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('time');?></span></div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-sm-2"> No Of Student<?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <input type="text" id="nos" name="nos" class="form-control numbersOnly" />
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('nos');?></span></div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-2"> Check Point <?=$astrik?></label>                                    
                                    <div class="col-sm-3">
                                        <select class="form-control" name="checkp" id="checkp">
											<option value="">Select Check Point</option>
											<option value="IN">IN</option>
											<option value="OUT">OUT</option>
										</select>
                                    </div>                                    
                                    <div class="col-sm-3"><span style="color:red;"><?php echo form_error('checkp');?></span></div>
                                </div>
								
								
                                <div class="form-group">
                                   
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>                                        
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/trip_list_new')?>'">Cancel</button></div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
			</div>
    </div>
</div>
                    
