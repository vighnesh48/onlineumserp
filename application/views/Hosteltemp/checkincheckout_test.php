<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>
var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
];
var enroll='<?=$this->uri->segment(3)?>';
var org='<?=$this->uri->segment(5)?>';
var academic_year='<?=$this->uri->segment(6)?>';
var sf_id='<?=$student_list['sf_id']?>';
var err_status=0;
$(document).ready(function(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var mmm= today.getMonth();
	var yyyy = today.getFullYear();
	if(dd<10){
	dd='0'+dd;
	} 
	if(mm<10){
	mm='0'+mm;
	} 
	var today = yyyy+'-'+mm+'-'+dd;
	$('#header_date').html(dd+" "+monthNames[mmm]+", "+yyyy%100);
	
	$('#doc-sub-datepicker20').val(today);
  
	$('#doc-sub-datepicker20').datepicker( {todayHighlight: true,format: 'yyyy-mm-dd',autoclose: true,setDate: new Date(),endDate: '+0d'});
	
	$('#doc-sub-datepicker20')
	   .datepicker({
		   
		   autoclose: true,
		   todayHighlight: true,
		   format: 'yyyy/mm/dd',
		   setDate: new Date()
		   
	   });
	
	var date=$('#doc-sub-datepicker20').val();
	//alert(date);
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
		data: {date:date,checkinout_type:'OUT'},
		success: function (html)
		{
			//alert(html);
			var content='';
			var array=JSON.parse(html);
			var len=array.std_gatepass_details.length;
			var j=1;
			for(i=0;i<len;i++)
			{
				//alert(array.std_gatepass_details[i].student_id);
				content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td><td>'+array.std_gatepass_details[i].checkout_time+'</td></tr>';
				j++;
			}
			
			$('#itemContainer').html(content);
			$('.nav-tabs a[href="#out"]').tab('show');
		}
		
	});
	
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
		data: {date:date,checkinout_type:'IN'},
		success: function (html)
		{
			//alert(html);
			var content='';
			var array=JSON.parse(html);
			var len=array.std_gatepass_details.length;
			var j=1;
			for(i=0;i<len;i++)
			{
				//alert(array.std_gatepass_details[i].student_id);
				content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td><td>'+array.std_gatepass_details[i].checkin_time+'</td></tr>';
				j++;
			}
			
			$('#itemContainer1').html(content);
		}
		
	});
	
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
		data: {date:date,checkinout_type:'HOME'},
		success: function (html)
		{
			//alert(html);
			var content='';
			var array=JSON.parse(html);
			var len=array.std_gatepass_details.length;
			var j=1;
			for(i=0;i<len;i++)
			{
				//alert(array.std_gatepass_details[i].student_id);
				content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td></tr>';
				j++;
			}
			
			$('#itemContainer2').html(content);
		}
		
	});
	
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
		data: {date:date,checkinout_type:'CITY'},
		success: function (html)
		{
			//alert(html);
			var content='';
			var array=JSON.parse(html);
			var len=array.std_gatepass_details.length;
			var j=1;
			for(i=0;i<len;i++)
			{
				//alert(array.std_gatepass_details[i].student_id);
				content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td></tr>';
				j++;
			}
			
			$('#itemContainer3').html(content);
		}
		
	});
	

	$('#doc-sub-datepicker20').on('changeDate', function (e) {
		var date=$('#doc-sub-datepicker20').val();
			//alert(date);
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
				data: {date:date,checkinout_type:'OUT'},
				success: function (html)
				{
					//alert(html);
					var content='';
					var array=JSON.parse(html);
					var len=array.std_gatepass_details.length;
					var j=1;
					for(i=0;i<len;i++)
					{
						//alert(array.std_gatepass_details[i].student_id);
						content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td><td>'+array.std_gatepass_details[i].checkout_time+'</td></tr>';
						j++;
					}
					
					$('#itemContainer').html(content);
					$('.nav-tabs a[href="#out"]').tab('show');
				}
				
			});
			
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
				data: {date:date,checkinout_type:'IN'},
				success: function (html)
				{
					//alert(html);
					var content='';
					var array=JSON.parse(html);
					var len=array.std_gatepass_details.length;
					var j=1;
					for(i=0;i<len;i++)
					{
						//alert(array.std_gatepass_details[i].student_id);
						content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td><td>'+array.std_gatepass_details[i].checkin_time+'</td></tr>';
						j++;
					}
					
					$('#itemContainer1').html(content);
				}
				
			});
			
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
				data: {date:date,checkinout_type:'HOME'},
				success: function (html)
				{
					//alert(html);
					var content='';
					var array=JSON.parse(html);
					var len=array.std_gatepass_details.length;
					var j=1;
					for(i=0;i<len;i++)
					{
						//alert(array.std_gatepass_details[i].student_id);
						content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td></tr>';
						j++;
					}
					
					$('#itemContainer2').html(content);
				}
				
			});
			
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
				data: {date:date,checkinout_type:'CITY'},
				success: function (html)
				{
					//alert(html);
					var content='';
					var array=JSON.parse(html);
					var len=array.std_gatepass_details.length;
					var j=1;
					for(i=0;i<len;i++)
					{
						//alert(array.std_gatepass_details[i].student_id);
						content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td></tr>';
						j++;
					}
					
					$('#itemContainer3').html(content);
				}
				
			});
	
	});
	
	
    $('#sbutton').click(function()
	{
		// alert("hi");
		var base_url = '<?=base_url();?>';
		
		var hgp_id = $("#prn").val();

		if(hgp_id=='' )
		{
			$('#err_msg').html("Please enter Gatepass Id!");
			return false;
		}
        else
		{  //alert(hgp_id);
			$.ajax({
				'url' : base_url + '/Hostel/gatepass_checkincheckout',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'hgp_id':hgp_id},
				'success' : function(data){ 
					//alert(data);
					var res=data.split('||');
					if(res[0]=='P')
					{
						$('#checkinout').hide();
						$('#err_msg').html('Not Approved Yet!');
					}
					else if(res[0]=='A' && res[1]=='')
					{
						//alert("Going out");
						$('#err_msg').html('');
						$('#hgp_id_out').val(hgp_id);
						$('#check_out').html('<button class="btn btn-primary form-control" id="checkout" type="submit" >Check Out</button>');
						$('#check_in').hide();
						$('#check_out').show();
					}
					else if(res[0]=='A' && res[1]=='OUT'){
						//alert("Coming In");
						$('#err_msg').html('');
						$('#hgp_id_in').val(hgp_id);
						$('#check_in').html('<button class="btn btn-primary form-control" id="checkin" type="submit" >Check In</button>');
						$('#check_in').show();
						$('#check_out').hide();
					}
				}
			});
		}
    });
});


/*  $(document).on("click", "#checkout" , function() {
	//$('#checkout').click(function()
	
		var base_url = '<?=base_url();?>';
		// alert(type);
		var hgp_id = $("#prn").val();
		$.ajax({
				'url' : base_url + '/Hostel/update_checkout',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'hgp_id':hgp_id},
				'success' : function(data){ 
					alert(data);
					$('#err_msg').html('');
				}
		});
	});

	 $(document).on("click", "#checkin" , function() {
	//$('#checkout').click(function()
	
		var base_url = '<?=base_url();?>';
		// alert(type);
		var hgp_id = $("#prn").val();
		$.ajax({
				'url' : base_url + '/Hostel/update_checkin',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'hgp_id':hgp_id},
				'success' : function(data){ 
					alert(data);
				}
		});
	}); */

function validate_form(events)
{ 
	if(err_status==1)
	{		
		$('#cancellation_err').html('Today, Already gatepass request is added for this student!');
		return false;
	}
}
</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Gatepass Check In/Out</h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    
                    <!--<div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add")?>"><span class="btn-label icon fa fa-plus"></span>Add </a></div>        -->                
                    <div class="visible-xs clearfix form-group-margin"></div>
                    
                    
                   
                </div>
            </div>
			
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>
       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
				<div class="row">
                      			  
					   <div class="col-sm-3">
					   <input type="text" class="form-control" name="prn" id="prn" placeholder="Enter Gatepass Id">
					   </div>
                      <div class="col-sm-2">
					  <button class="btn btn-primary form-control" id="sbutton" type="button" >Submit</button>
					  </div>
					  <div class="col-sm-4"><span id="err_msg" style="color:red;"></span></div>
					  <div class="col-sm-2">
						
					<form name="form" id="form" action="<?=base_url($currentModule.'/update_checkout')?>" method="POST">
					<input type="hidden" id="hgp_id_out" name="hgp_id_out" />
					 <div  id="check_out" style="display:none;"></div>
					</form>
					
					<form name="form" id="form" action="<?=base_url($currentModule.'/update_checkin')?>" method="POST">
					<input type="hidden" id="hgp_id_in" name="hgp_id_in" />
					 <div  id="check_in" style="display:none;"></div>
					</form>
					  </div>
					  
                    </div>
                </div>
				
                <div class="panel-body">
					
						<div class="row">
							<div class="col-sm-4"><span class="panel-title"><b>List for the date of <span id="header_date"></span></b></span></div>
							<div class="col-sm-3"></div>				
							<div class="col-sm-3 pull-right">
							  <input type="text" class="form-control" id="doc-sub-datepicker20" data-provide="datepicker" name="date" required readonly="true"/>
							</div>
							<label class="col-sm-1 pull-right">Date:</label>
							
						</div>
					<hr>
					  <!--<h2>Dynamic Tabs</h2>-->
					  <ul class="nav nav-tabs">
						
						<li><a data-toggle="tab" href="#out">Check Out</a></li>
						<li class="active"><a data-toggle="tab" href="#in">Check In</a></li>
						<li><a data-toggle="tab" href="#city">City</a></li>
						<li><a data-toggle="tab" href="#home">Home</a></li>
					  </ul>

					  <div class="tab-content">
						<div id="out" class="tab-pane fade">
						  <!--<h3>Menu 1</h3>-->
						  <div class="table-info" style="overflow-x:scroll;height:200px;">    
							   <table class="table table-bordered">
								<thead>
									<tr>
											<th>#</th>
											<th>Student Id</th>
											<th>Name</th>
											<th>Insitute</th>
											<th>Hostel</th>
											<th>CheckOut Time</th>
									</tr>
								</thead>
								<tbody id="itemContainer"></tbody>
								</table>
							</div>
						
						</div>
						<div id="in" class="tab-pane fade">
						  <!--h3>Menu 2</h3-->
						  <div class="table-info" style="overflow-x:scroll;height:200px;" >    
							   <table class="table table-bordered">
								<thead>
									<tr>
											<th>#</th>
											<th>Student Id</th>
											<th>Name</th>
											<th>Insitute</th>
											<th>Hostel</th>
											<th>CheckIn Time</th>
									</tr>
								</thead>
								<tbody id="itemContainer1"></tbody>
								</table>
							</div>
						</div>
						<div id="city" class="tab-pane fade">
						  <!--h3>Menu 3</h3-->
						  <div class="table-info" style="overflow-x:scroll;height:200px;" >    
							   <table class="table table-bordered">
								<thead>
									<tr>
											<th>#</th>
											<th>Student Id</th>
											<th>Name</th>
											<th>Insitute</th>
											<th>Hostel</th>
											
									</tr>
								</thead>
								<tbody id="itemContainer2"></tbody>
								</table>
							</div>
						</div>
						<div id="home" class="tab-pane fade in active">
						  <!--h3>HOME</h3-->
						  <div class="table-info" style="overflow-x:scroll;height:200px;" >    
							   <table class="table table-bordered">
								<thead>
									<tr>
											<th>#</th>
											<th>Student Id</th>
											<th>Name</th>
											<th>Insitute</th>
											<th>Hostel</th>
											
									</tr>
								</thead>
								<tbody id="itemContainer3"></tbody>
								</table>
							</div>
						</div>
					  </div>
					
				</div>
    </div>
</div>
                    
