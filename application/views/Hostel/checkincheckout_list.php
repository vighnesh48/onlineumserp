<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>
var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
];

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
	$('#itemContainer').html('');
	$('#itemContainer1').html('');
	$('#itemContainer2').html('');
	$('#itemContainer3').html('');
	
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
		data: {date:date,checkinout_type:'IN'},
		success: function (html)
		{
			//alert(html);
			if(html != "{\"std_gatepass_details\":[]}")
			{
				$('#show_in').show();
				$('#no_in').html('');
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
				else
				{
					$('#show_in').hide();
					$('#no_in').html('#in').html('<span style="padding-left:20px;color:red;">No Student Has Checked IN Yet.</span>');
				}
		}
		
	});
	
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
		data: {date:date,checkinout_type:'CITY'},
		success: function (html)
		{
			//alert(html);
			if(html != "{\"std_gatepass_details\":[]}")
			{
				$('#show_city').show();
				$('#no_city').html('');
				var content='';
				var array=JSON.parse(html);
				var len=array.std_gatepass_details.length;
				var j=1;
				for(i=0;i<len;i++)
				{
					//alert(array.std_gatepass_details[i].student_id);
					content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td><td>'+array.std_gatepass_details[i].mobile+'</td><td>'+array.std_gatepass_details[i].checkout_time+'</td><td>'+array.std_gatepass_details[i].checkin_time+'</td></tr>';
					j++;
				}
				
				$('#itemContainer2').html(content);
			}
				else
				{
					$('#show_city').hide();
					$('#no_city').html('<span style="padding-left:20px;color:red;">No Student Has Checked In/Out for City Yet.</span>');
				}
		}
		
	});
	
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
		data: {date:date,checkinout_type:'HOME'},
		success: function (html)
		{
			//alert(html);
			if(html != "{\"std_gatepass_details\":[]}")
			{
				$('#show_home').show();
				$('#no_home').html('');
				var content='';
				var array=JSON.parse(html);
				var len=array.std_gatepass_details.length;
				var j=1;
				for(i=0;i<len;i++)
				{
					//alert(array.std_gatepass_details[i].student_id);
					content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td><td>'+array.std_gatepass_details[i].mobile+'</td><td>'+array.std_gatepass_details[i].checkout_time+'</td><td>'+array.std_gatepass_details[i].checkin_time+'</td></tr>';
					j++;
				}
				
				$('#itemContainer3').html(content);
				
			}
				else
				{
					
					$('#show_home').hide();
					$('#no_home').html('<span style="padding-left:20px;color:red;">No Student Has Checked In/Out for Home Yet.</span>');
				}
		}
		
	});
	
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
		data: {date:date,checkinout_type:'OUT'},
		success: function (html)
		{
			//alert(html);
			
			if(html != "{\"std_gatepass_details\":[]}")
				{
					$('#show_out').show();
					$('#no_out').html('');
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
				else
				{
					$('.nav-tabs a[href="#out"]').tab('show');
					$('#show_out').hide();
					$('#no_out').html('<span style="padding-left:20px;color:red;">No Student Has Checked Out Yet.</span>');
				}
		}
		
	});
	

	$('#doc-sub-datepicker20').on('changeDate', function (e) {
	$('#itemContainer').html('');
	$('#itemContainer1').html('');
	$('#itemContainer2').html('');
	$('#itemContainer3').html('');
		var date=$('#doc-sub-datepicker20').val();
		var ddmmyy=date.split('-');
		var mmm=parseInt(ddmmyy[1]);
		$('#header_date').html(ddmmyy[2]+" "+monthNames[mmm]+", "+ddmmyy[0]%100);
			//alert(date);
			
			
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
				data: {date:date,checkinout_type:'IN'},
				success: function (html)
				{
					//alert(html);
					if(html != "{\"std_gatepass_details\":[]}")
					{
						$('#show_in').show();
						$('#no_in').html('');
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
				else
				{
					$('#show_in').hide();
					$('#no_in').html('<span style="padding-left:20px;color:red;">No Student Has Checked In Yet.</span>');
				}
				}
				
			});
			
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
				data: {date:date,checkinout_type:'CITY'},
				success: function (html)
				{
					//alert(html);
					if(html != "{\"std_gatepass_details\":[]}")
					{
						$('#show_city').show();
						$('#no_city').html('');
						var content='';
						var array=JSON.parse(html);
						var len=array.std_gatepass_details.length;
						var j=1;
						for(i=0;i<len;i++)
						{
							//alert(array.std_gatepass_details[i].student_id);
							content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td><td>'+array.std_gatepass_details[i].mobile+'</td><td>'+array.std_gatepass_details[i].checkout_time+'</td><td>'+array.std_gatepass_details[i].checkin_time+'</td></tr>';
							j++;
						}
						
						$('#itemContainer2').html(content);
					}
				else
				{
					$('#show_city').hide();
					$('#no_city').html('<span style="padding-left:20px;color:red;">No Student Has Checked In/Out for City Yet.</span>');
				}
				}
				
			});
			
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
				data: {date:date,checkinout_type:'HOME'},
				success: function (html)
				{
					//alert(html);
					if(html != "{\"std_gatepass_details\":[]}")
					{
						$('#show_home').show();
						$('#no_home').html('');
						var content='';
						var array=JSON.parse(html);
						var len=array.std_gatepass_details.length;
						var j=1;
						for(i=0;i<len;i++)
						{
							//alert(array.std_gatepass_details[i].student_id);
							content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td><td>'+array.std_gatepass_details[i].mobile+'</td><td>'+array.std_gatepass_details[i].checkout_time+'</td><td>'+array.std_gatepass_details[i].checkin_time+'</td></tr>';
							j++;
						}
						
						$('#itemContainer3').html(content);
					}
				else
				{
					$('#show_home').hide();
					$('#no_home').html('<span style="padding-left:20px;color:red;">No Student Has Checked In/Out for Home Yet.</span>');
				}
				}
				
			});
	
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/gatepass_trailbalance',
				data: {date:date,checkinout_type:'OUT'},
				success: function (html)
				{
					if(html != "{\"std_gatepass_details\":[]}")
					{
						$('#show_out').show();
						$('#no_out').html('');
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
					else
					{
						('.nav-tabs a[href="#out"]').tab('show');
						$('#show_out').hide();
						$('#no_out').html('<span style="padding-left:20px;color:red;">No Student Has Checked Out Yet.</span>');
					}
				}
				
			});
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
            <h1 class="col-xs-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Check In/Out List   </h1>
            <div class="col-xs-12 col-sm-auto">
                 <span id="flash-messages" style="color:Green;padding-left:50px;">
				 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
							 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
            </div>
              <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/checkincheckout")?>"><span class="btn-label icon fa fa-print"></span>Gate Pass Entry </a></div>                                       
 
        </div>
       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
					<div class="row">
							<div class="col-sm-5"><span class="panel-title"><h4>List for the date of <b><span id="header_date"></span></b></h4></span></div>
							<div class="col-sm-2"></div>				
							<div class="col-sm-3 pull-right">
							  <input type="text" class="form-control" id="doc-sub-datepicker20" data-provide="datepicker" name="date" required readonly="true"/>
							</div>
							<label class="col-sm-1 pull-right"><b>Date:</b></label>
							
						</div>
                </div>
				
                <div class="panel-body">
					
						
				
					  <!--<h2>Dynamic Tabs</h2>-->
					  <ul class="nav nav-tabs">
						
						<li><a data-toggle="tab" href="#out">Check Out</a></li>
						<li class="active"><a data-toggle="tab" href="#in">Check In</a></li>
						<li><a data-toggle="tab" href="#city">City</a></li>
						<li><a data-toggle="tab" href="#home">Home</a></li>
					  </ul>

					  <div class="tab-content">
						<div id="out" class="tab-pane fade">
						  <h4 id="no_out"></h4>
						  <div class="table-info" id="show_out" style="overflow-x:scroll;height:400px;display:none;">    
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
						  <h4 id="no_in"></h4>
						  <div class="table-info" id="show_in" style="overflow-x:scroll;height:400px;display:none;" >    
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
						  <h4 id="no_city"></h4>
						  <div class="table-info" id="show_city" style="overflow-x:scroll;height:400px;display:none;" >    
							   <table class="table table-bordered">
								<thead>
									<tr>
											<th>#</th>
											<th>Student Id</th>
											<th>Name</th>
											<th>Insitute</th>
											<th>Hostel</th>
											<th>Mobile</th>
											<th>CheckOut Time</th>
											<th>CheckIn Time</th>
									</tr>
								</thead>
								<tbody id="itemContainer2"></tbody>
								</table>
							</div>
						</div>
						<div id="home" class="tab-pane fade in active">
						  <h4 id="no_home"></h4>
						  <div class="table-info" id="show_home" style="overflow-x:scroll;height:400px;display:none;" >    
							   <table class="table table-bordered">
								<thead>
									<tr>
											<th>#</th>
											<th>Student Id</th>
											<th>Name</th>
											<th>Insitute</th>
											<th>Hostel</th>
											<th>Mobile</th>
											<th>CheckOut Time</th>
											<th>CheckIn Time</th>
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
                    
