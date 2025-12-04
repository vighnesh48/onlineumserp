
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Transport</a></li>
         
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Buses Trip Details List</h1>
			
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
                  <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/trip_entry")?>"><span class="btn-label icon fa fa-plus"></span>Entry </a></div>
                   
                </div>
            </div>

        </div>
       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">  
				
					<div class="row">
					<!--label class="col-sm-1">Status</label>-->
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
						<div class="col-sm-2">
						<select class="form-control" name="route" id="route">
								<option value="">Select By Report</option>
								<option value="day">Daywise List</option>
								<option value="summary">Summarywise List</option>
								
						</select>
						</div>
						<div class="col-sm-2">
							<select class="form-control" name="selectby" id="selectby">
								<option value="">Select By Duration</option>
								<option value="Datewise">Datewise</option>
								<option value="Between">Between Dates</option>
							</select>
						</div>
						
						<div class="form-group" id="datewise" style="display:none;">
						<!--<label class="col-sm-1">Date: <?=$astrik?></label>-->
							<div class="col-sm-2">
							<input type="text" class="form-control" id="doc-sub-datepicker20" name="date" required readonly="true"/>
							</div>
						</div>
						
						<div class="form-group" id="between" style="display:none;">
							<label class="col-sm-1">From:</label>
							<div class="col-sm-2">
							  <input type="text" class="form-control" id="doc-sub-datepicker21" name="fdate" required readonly="true"/>
							</div>
							<label class="col-sm-1">To:</label>
						
							<div class="col-sm-2">
							  <input type="text" class="form-control" id="doc-sub-datepicker23" name="tdate" required readonly="true"/>
							</div>
						</div>
						
					</div>
                </div>
				
                <div class="panel-body">
				<h4 id="err_msg1" style="color:red;padding-left:200px;"></h4>
				<h4  class="hide-it" id="flash-messages" style="color:Green;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></h4>
				<h4 class="hide-it" id="flash-messages" style="color:red;padding-left:250px;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></h4>
				<?php
				if(!empty($trip_details))
				{
					?>
                    <div class="table-info" id="tableinfo">    
                       <table class="table table-bordered" style="width:100%;max-width:100%;">
                        <thead>
                            <tr>
                                    <th>#</th>
									<th>Bus Number</th>
                                    <th>Route Name</th>
									<th>Trip Type</th>
									<th>Date</th>
                                    <th>Time</th>
									<th>Status</th>
                                    
									<!--<th>Status</th>
                                    
                                    <th>Action</th>-->
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                             $j=1;                      
                            for($i=0;$i<count($trip_details);$i++)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>
                                <td><?=$trip_details[$i]['bus_no']?></td>
								<td><?=$trip_details[$i]['route_name']?></td>
								<td><?=$trip_details[$i]['trip_type']?></td>
								<td><?=date("d/m/Y", strtotime($trip_details[$i]['trip_date']))?></td>
                                <td><?=$trip_details[$i]['trip_time']?></td>
								<td><?=$trip_details[$i]['status']?></td>					
							</tr>
								<?php
								$j++;
                            } 
                            ?>                            
                        </tbody>
                    </table>                    
                
                </div>
				
				<div class="table-info" id="summarytableinfo">    
                       <table class="table table-bordered" style="width:100%;max-width:100%;">
                        <thead>
                            <tr>
                                    <th>#</th>
									<th>Bus Number</th>
                                    <th>Route Name</th>
									<th>Trip Type</th>
									<th>Date</th>
                                    <th>Trip Count</th>
									                                    
									<!--<th>Time</th>
									
									<th>Status</th>
                                    
                                    <th>Action</th>-->
                            </tr>
                        </thead>
                        <tbody id="itemContainer1">
                                                       
                        </tbody>
                    </table>                    
                
                </div>
				
				<div class="btn-group col-sm-2  pull-right" id="pdf">
					<form id="form" name="form" action="<?=base_url($currentModule.'/trip_details_pdfReports')?>" method="POST" >
					<input type="hidden" name="buspdf" id="buspdf" />
					<input type="hidden" name="routepdf" id="routepdf" />
					<input type="hidden" name="odatepdf" id="odatepdf" />
					<input type="hidden" name="fdatepdf" id="fdatepdf" />
					<input type="hidden" name="tdatepdf" id="tdatepdf" />
					<button class="btn btn-primary form-control" id="btn_submit" type="submit" >PDF</button>
					</form>
					</div>
					<div class="btn-group col-sm-2  pull-right" id="excel">
					<form id="form" name="form" action="<?=base_url($currentModule.'/trip_details_excelReports')?>" method="POST" >
					
					<input type="hidden" name="busexcel" id="busexcel" />
					<input type="hidden" name="routeexcel" id="routeexcel" />
					<input type="hidden" name="odateexcel" id="odateexcel" />
					<input type="hidden" name="fdateexcel" id="fdateexcel" />
					<input type="hidden" name="tdateexcel" id="tdateexcel" />
					
					<button class="btn btn-primary form-control" id="btn_submit" type="submit" >Excel</button>
					</form>
				  </div>
				  <?php
				}else{
					?>
					<h4 style="color:red;padding-left:250px;">Bus Trip Has Not Started Yet</h4>
					<?php
				}
				  ?>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<script>
var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
];
var route='';
var onedate='',fdate='',tdate='',onedate_dd='',fdate_dd='',tdate_dd='',onedate_mm='',fdate_mm='',tdate_mm='',onedate_yy='',tdate_yy='';
var html_content="",type="",url="",datastring="";

function validate_form(events)
{
	var remark=$('#remarks').val();
	if(remark=='')
	{
		$('#err_msg').html('please enter remarks');
		return false;
	}
	else
	{
		$('#err_msg').html('');
	}
}

$(document).ready(function(){
	setTimeout(function() {
			$(".hide-it").hide();
		}, 5000);
	
	$('#summarytableinfo').hide();
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
	var today = dd+'/'+mm+'/'+yyyy;
	
	//$('#header_date').html(dd+" "+monthNames[mmm]+", "+yyyy%100);
		
	$('#doc-sub-datepicker20')
	   .datepicker({
		   
		   autoclose: true,
		   todayHighlight: true,
		   format: 'dd/mm/yyyy',
		   setDate: new Date()
		   
	   });
	 $('#doc-sub-datepicker21').datepicker( {
  todayHighlight: true,
  format: 'dd/mm/yyyy',
  autoclose: true,
  setDate: new Date()
  });
	$('#doc-sub-datepicker23').datepicker( {
  todayHighlight: true,
  format: 'dd/mm/yyyy',
  autoclose: true,
  setDate: new Date()
  });
	
	$('#selectby').change(function() {
	
        if (this.value == 'Datewise') {
			$('#doc-sub-datepicker20').val(today);
            $('#between').hide();
			$('#datewise').show();
        }
        else if (this.value == 'Between') {
			$('#doc-sub-datepicker21').val(today);
			$('#doc-sub-datepicker23').val(today);
            //alert("home");
			$('#between').show();
			$('#datewise').hide();
        }
		else
		{
			$('#between').hide();
			$('#datewise').hide();
		}
		common_call();
	});
	

	$('#bus').change(function() {
		common_call();
	});
	
	$('#route').change(function() {
		common_call();
	});
	
	$('#doc-sub-datepicker20').on('changeDate', function (e) {
		common_call();
	}); 
	
	$('#doc-sub-datepicker21').on('changeDate', function (e) {
		common_call();
	}); 
			
	$('#doc-sub-datepicker23').on('changeDate', function (e) {
		common_call();
	}); 

});

function common_call()
{
	var bus=$('#bus').val();
	route=$('#route').val();
	var selectby=$('#selectby').val();
	var odate=$('#doc-sub-datepicker20').val();
	var fdate=$('#doc-sub-datepicker21').val();
	var tdate=$('#doc-sub-datepicker23').val();
	$('#busexcel').val(bus);
	$('#routeexcel').val(route);
	$('#odateexcel').val(odate);
	$('#fdateexcel').val(fdate);
	$('#tdateexcel').val(tdate);
	$('#buspdf').val(bus);
	$('#routepdf').val(route);
	$('#odatepdf').val(odate);
	$('#fdatepdf').val(fdate);
	$('#tdatepdf').val(tdate);
	type='POST',url='<?= base_url() ?>Transport/get_bus_trip_list_by_creteria';
	if(selectby!='' && selectby=='Between')
	{
		if ((Date.parse(tdate) < Date.parse(fdate))) 
		{
			$('#err_msg1').html('To date should be greater than From date');
		}
		else
		{
			$('#err_msg1').html('');
			datastring={bus:bus,route:route,tdate:tdate,fdate:fdate};
			html_content=ajaxcall(type,url,datastring);
			display_content(html_content);
		}
	}
	else if(selectby!='' && selectby=='Datewise')
	{
		$('#err_msg1').html('');
		datastring={bus:bus,route:route,odate:odate};
		html_content=ajaxcall(type,url,datastring);
		display_content(html_content);
	}
	else if(bus!='' && route!='')
	{
		$('#err_msg1').html('');
		datastring={bus:bus,route:route};
		html_content=ajaxcall(type,url,datastring);
		display_content(html_content);
	}
	else if(route!='')
	{
		$('#err_msg1').html('');
		datastring={route:route};
		html_content=ajaxcall(type,url,datastring);
		display_content(html_content);
	}
	else if(bus!='')
	{
		$('#err_msg1').html('');
		datastring={bus:bus};
		html_content=ajaxcall(type,url,datastring);
		display_content(html_content);
	}
	else
	{
		$('#err_msg1').html('');
		datastring={};
		html_content=ajaxcall(type,url,datastring);
		display_content(html_content);
	}
		
}

var challan_status='';
function display_content(html_content)
{
	var content='';
	var content1='';
	if(html_content === "{\"trip_list\":[]}")
	{
		$('#itemContainer').html('');
		$('#tableinfo').hide();
		$('#itemContainer1').html('');
		$('#summarytableinfo').hide();
		$('#pdf').hide();
		$('#excel').hide();
		$('#err_msg1').html('Records Not Found Please change search criteria and try again');
	}
	else
	{
		$('#pdf').show();
		$('#excel').show();
		var array=JSON.parse(html_content);
		len=array.trip_list.length;
		//alert(len+"==="+html);
		var j=1;
		for(i=0;i<len;i++)
		{
			content+='<tr><td>'+j+'</td><td>'+array.trip_list[i].bus_no+'</td><td>'+array.trip_list[i].route_name+'</td><td>'+array.trip_list[i].trip_type+'</td>';
			
			fdate = new Date(array.trip_list[i].trip_date);
			fdate_dd = fdate.getDate();
			fdate_mm = fdate.getMonth()+1;
			tdate_yy = new Date(array.trip_list[i].trip_date).getFullYear();
			if(fdate_dd<10){
			fdate_dd='0'+fdate_dd;
			} 
			if(fdate_mm<10){
			fdate_mm='0'+fdate_mm;
			}
			//alert(fdate_dd+' '+fdate_mm+' '+tdate_yy);
			content+='<td>'+fdate_dd+'/'+fdate_mm+'/'+tdate_yy+'</td>';
			
			if(route=='summary' && array.trip_list[i].trip_type=='double')
				content+='<td>'+Math.floor((array.trip_list[i].trip_count)/8)+'</td></tr>';
			else if(route=='summary')
				content+='<td>'+Math.floor((array.trip_list[i].trip_count)/2)+'</td></tr>';
			else
				content+='<td>'+array.trip_list[i].trip_time+'</td><td>'+array.trip_list[i].status+'</td></tr>';
			
			j++;
		}
		if(route=='summary')
		{
			$('#itemContainer1').html(content);
			$('#summarytableinfo').show();
			$('#tableinfo').hide();
		}
		else
		{
			$('#itemContainer').html(content);
			$('#tableinfo').show();
			$('#summarytableinfo').hide();
		}
		$('#err_msg1').html('');
	}
}

function ajaxcall(type,url,datastring)
{  
	var res;
	$.ajax({
		type:type,
		url:url,
		data:datastring,
		cache:false,
		async:false,
		success: function(result)
	 {
	  res=result;	 
	 }
	});
	return res; 
}
</script>