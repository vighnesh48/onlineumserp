<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>
var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
];


$(document).ready(function(){
	
    $('#sbutton').click(function()
	{
		// alert("hi");
		var base_url = '<?=base_url();?>';
		
		var hgp_id = $("#prn").val();
	
		if(hgp_id=="" )
		{    
		    alert("Please enter Gatepass Id");
		    $('#checkinout').show();
			$('#err_msg').html("Please enter Gatepass Id");
			$('#checkinout').hide();
			
			$('#hgp_id_in').val('');
			$('#hgp_id_out').val('');
			$('#std_name_out').val('');
			$('#std_name').val('');
			$('#mobile_in').val('');
			$('#mobile_out').val('');
			$('#f_alloc_id_in').val('');
			$('#f_alloc_id_out').val('');
			$('#check_in').hide();
			$('#check_out').hide();
			return false;
		}
        else
		{  //alert(hgp_id);
			$.ajax({
				'url' : base_url + '/Hostel/gatepass_checkincheckout',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'hgp_id':hgp_id},
				'success' : function(data){ 
				//	alert("data===="+data);
					if(data != "{\"std_gatepass_details\":null}")
					{
						var array=JSON.parse(data);
					//	alert(array.std_gatepass_details.approval_status+'=='+array.std_gatepass_details.checkin_status);
						var acy=parseInt(array.std_gatepass_details.academic_year.slice(-2))+1;
						$('#acadmic').html(array.std_gatepass_details.academic_year+'-'+acy);
						$('#prn_num').html(array.std_gatepass_details.enrollment_no);
						$('#f_alloc_id').html(array.std_gatepass_details.f_alloc_id);
						$('#std_name').html(array.std_gatepass_details.first_name+' '+array.std_gatepass_details.middle_name+' '+array.std_gatepass_details.last_name);
						$('#organisation').html(array.std_gatepass_details.stud_org+' - '+array.std_gatepass_details.school_name);
						$('#type').html(array.std_gatepass_details.type);
						var f_date = new Date(array.std_gatepass_details.from_date);
						$('#fdate').html(f_date.getDate()+'-'+monthNames[f_date.getMonth()]+'-'+f_date.getFullYear());
						var t_date = new Date(array.std_gatepass_details.to_date);
						$('#tdate').html(t_date.getDate()+'-'+monthNames[t_date.getMonth()]+'-'+t_date.getFullYear());
						$('#reason').html(array.std_gatepass_details.purpose);
						
						if(array.std_gatepass_details.approval_status=='R')
						{
							$('#checkinout').hide();
							$('#err_msg').html('Gatepass Application is Rejected!!!');
						}
						else if(array.std_gatepass_details.approval_status=='P')
						{
							$('#checkinout').hide();
							$('#err_msg').html('Gatepass Application is not yet Approved !!!');
						}
						else if(array.std_gatepass_details.approval_status=='A' && array.std_gatepass_details.checkin_status==null)
						{
							//alert("Going out");
							$('#checkinout').show();
							$('#err_msg').html('');
							$('#check_in').hide();
							$('#check_out').show();
							$('#hgp_id_in').val('');
							$('#hgp_id_out').val(hgp_id);
							$('#mobile_in').val('');
							$('#mobile_out').val(array.std_gatepass_details.parent_mobile1+','+array.std_gatepass_details.parent_mobile2);
							$('#std_name_in').val('');
							$('#std_name_out').val(array.std_gatepass_details.first_name+' '+array.std_gatepass_details.middle_name+' '+array.std_gatepass_details.last_name);
							$('#goingto').val(array.std_gatepass_details.type);
							$('#f_alloc_id_in').val('');
							$('#f_alloc_id_out').val(array.std_gatepass_details.f_alloc_id);
							$('#check_out').html('<button class="btn btn-primary form-control" id="checkout" type="submit" >Check Out</button>');
							
						}
						else if(array.std_gatepass_details.approval_status=='A' && array.std_gatepass_details.checkin_status=='OUT'){
							//alert("Coming In");
							$('#checkinout').show();
							$('#err_msg').html('');
							$('#hgp_id_out').val('');
							$('#std_name_in').val(array.std_gatepass_details.first_name+' '+array.std_gatepass_details.middle_name+' '+array.std_gatepass_details.last_name);
							$('#std_name_out').val('');
							$('#hgp_id_in').val(hgp_id);
							$('#mobile_in').val(array.std_gatepass_details.parent_mobile1+','+array.std_gatepass_details.parent_mobile2);
							$('#mobile_out').val('');
							$('#f_alloc_id_in').val(array.std_gatepass_details.f_alloc_id);
							$('#f_alloc_id_out').val('');
							$('#check_in').html('<button class="btn btn-primary form-control" id="checkin" type="submit" >Check In</button>');
							$('#check_in').show();
							$('#check_out').hide();
						}
						else if(array.std_gatepass_details.approval_status=='A' && array.std_gatepass_details.checkin_status=='IN'){
							$('#checkinout').show();
							$('#err_msg').html('Gatepass IN entry is  already done..!!! ');
							$('#hgp_id_in').val('');
							$('#hgp_id_out').val('');
							$('#mobile_out').val('');
							$('#mobile_in').val('');
							$('#std_name_out').val('');
							$('#std_name_in').val('');
							$('#f_alloc_id_in').val('');
							$('#f_alloc_id_out').val('');
							$('#check_in').hide();
							$('#check_out').hide();
						}
						
					}
					else
					{
						$('#checkinout').hide();
						$('#err_msg').html('Please check the Gatepass No,it may be wrong or doesnot exist.');
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
        <li class="active"><a href="#">Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Gatepass Entry</h1>
					
			<span id="flash-messages" style="color:Green;padding-left:250px;">
			<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
			<span id="flash-messages" style="color:red;padding-left:250px;">
			<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
					<div class="row">
                      <label class="col-sm-3">Gate Pass Application Id:</label>
					   <div class="col-sm-3">
					   <input type="text" class="form-control" name="prn" id="prn" placeholder="Gatepass Id">
					   </div>
                      <div class="col-sm-2">
					  <button class="btn btn-primary form-control" id="sbutton" type="button" >Submit</button>
					  </div>
					  <div class="col-sm-4"></div>
					  
					  
                    </div>
                </div>
				
                <div class="panel-body"  id="checkinout" style="display:none;">
					<h4 id="err_msg" style="color:red;"></h4>
					<table class="table table-bordered">
						 <tr>
						  <th>Name :</th>
						  <td class="col-sm-4"><span id="std_name"></span></td>
						  <th style="text-align: left;">PRN:</th>
						  <td class="col-sm-4"><span id="prn_num"></span></td>
						</tr> 
						 <tr>
						 <th>Institue:</th>
						  <td class="col-sm-4"><span id="organisation"></span></td>
						  <th style="text-align: left;">Academic Year:</th>
						  <td class="col-sm-4"><span id="acadmic"></span></td>
						</tr>   
						<tr>
						  <th>Going To:</th>
						  <td class="col-sm-4"><span id="type"></span></td>
						   <th style="text-align: left;">Reason:</th>
						   <td class="col-sm-4"><span id="reason"></span></td>
						</tr>
						
						
						
						<tr>
						  <th>From Date:</th>
						  <td class="col-sm-4"><span id="fdate"></span></td>
						  <th style="text-align: left;">To Date:</th>
						  <td class="col-sm-4"><span id="tdate"></span></td>
						</tr>
						
						
						
				</table>
					
					<div class="col-sm-2" >
						
						<form name="form" id="form" action="<?=base_url($currentModule.'/update_checkout')?>" method="POST">
						<input type="hidden" id="hgp_id_out" name="hgp_id_out" />
						<input type="hidden" id="goingto" name="goingto" />
						<input type="hidden" id="std_name_out" name="std_name_out" />
						<input type="hidden" id="mobile_out" name="mobile_out" />
						<input type="hidden" id="f_alloc_id_out" name="f_alloc_id_out" />
						 <div  id="check_out" style="display:none;"></div>
						</form>
						
						<form name="form" id="form" action="<?=base_url($currentModule.'/update_checkin')?>" method="POST">
						<input type="hidden" id="hgp_id_in" name="hgp_id_in" />
						<input type="hidden" id="std_name_in" name="std_name_in" />
						<input type="hidden" id="mobile_in" name="mobile_in" />
						<input type="hidden" id="f_alloc_id_in" name="f_alloc_id_in" />
						 <div  id="check_in" style="display:none;"></div>
						</form>
					  </div>
					
				</div>
    </div>
</div>
                    
