
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
         <li class="active"><a href="<?=base_url($currentModule)?>">Hostel </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-5 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Gate Pass Application List </h1>
			
			<div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/hostel_gatepass")?>"><span class="btn-label icon fa fa-plus"></span>Issue </a></div>
			
			

        </div>
       
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">  
					<div class="row">
						<div class="col-sm-5">
						<span class="panel-title"><h4>List for the date of <b><span id="header_date"></span></b></h4></span>
						</div>
						<div class="col-sm-2"></div>				
						<div class="col-sm-3 pull-right">
						<input type="hidden" class="form-control" name="ac_year" id="ac_year" value="<?=$current_academic?>">
						  <input type="text" class="form-control" id="doc-sub-datepicker20" data-provide="datepicker" name="date" required readonly="true"/>
						</div>
						<label class="col-sm-1 pull-right"><b>Date:</b></label>
					</div>
                </div>
				
                <div class="panel-body" style="overflow-x:scroll;height:500px;">
				<span id="flash-messages" style="color:Green;padding-left:150px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:150px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
						 
						 
				<!-- Modal -->
						<div id="myModal1" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content" style="width:800px;">
							  <div class="modal-header  panel-success">
							  <b>Hostel Gatepass Details</b>
							</div>
							  <div class="modal-body">
							  
								
																 
										<div class="panel-body">
											<div class="table-info">  
											<form name="form" id="form" action="<?=base_url($currentModule.'/getpass_approval_submit')?>" method="POST" onsubmit="return validate_form(event)">
											<input type="hidden" id="hgp_id" name="hgp_id" />
											
												<div class="row">
												<div class="col-sm-12">
													<table class="table table-bordered">
													 <tr>
													  <th scope="col">Name :</th>
													  <td><span id="std_name"></span></td>
													  <th scope="col">PRN :</th>
													  <td><span id="prn"></span></td>
													</tr> 
													 <tr>
													 <th scope="col">Organisation :</th>
													  <td><span id="organisation"></span></td>
													  <th scope="col">Academic Year :</th>
													  <td><span id="acadmic"></span></td>
													</tr>   
													<tr>
													  <th scope="col">Going To :</th>
													  <td><span id="type"></span></td>
													   <th scope="col">Reason :</th>
													   <td><span id="reason"></span></td>
													</tr>
													
													
													
													<tr>
													  <th scope="col">From Date :</th>
													  <td><span id="fdate"></span></td>
													  <th scope="col">To Date :</th>
													  <td><span id="tdate"></span></td>
													</tr>
													
													
													
													</table>
												
												
												</div>
																								
												</div>
											<div class="row">
												<label class="col-sm-2">Enter Remark: <?=$astrik?></label>
												<div class="col-sm-3">
												<input class="form-control col-sm-3" type="text" id="remarks" name="remarks" />
												</div>
												<div class="col-sm-4">
												<span id="err_msg" style="color:red;"></span>
												</div>
											</div>
											</div>
											
											<div id="app_rej_btn">
											<div class="col-sm-2">
												<button class="btn btn-primary form-control" id="approve" name="approve" type="submit">Approve</button>												
											</div>
											
											
											<div class="col-sm-2">
												<button class="btn btn-primary form-control" id="reject" name="reject">Reject</button>
											</div>
											
											</div>
											
											</form>
											
											<!--<form name="form" id="form" action="<?=base_url($currentModule.'/getpass_reject_submit')?>" method="POST" onsubmit="return validate_form(event)">
											<input type="hidden" id="hgpid" name="hgpid" />
											<div class="form-group" id="reject_remark" style="display:none;">
												<label class="col-sm-2">Enter Remark: <?=$astrik?></label>
												<div class="col-sm-3">
												<input class="form-control col-sm-3" type="text" id="remarks" name="remarks" />
												</div>
												<div class="col-sm-3">
												<button class="btn btn-primary" type="submit" name="submit">Submit</button>
												<span class="btn btn-primary" id="getpass_cancel">cancel</span>
												</div>                                    
												
											</div>
											
											<div class="col-sm-4">
											<span id="err_msg" style="color:red;"></span>
											</div>
											
											</form>-->
										</div>
									
							 </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							  </div>
							</div>
				</div>
				</div>
				
				
                    <div class="table-info" >    
                       <table class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Student Id</th>
									<th>Name</th>
                                    <th>Insitute</th>
									<th>Hostel</th>
                                    <th>GoingTo</th>
									<th>Date</th>
                                    <th>Status</th>
									<!--<th>CheckIn Status</th>
                                    <th>Gatepass Status</th>-->
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                      
                            for($i=0;$i<count($hostel_details);$i++)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>                                                                
                                <td><?=$hostel_details[$i]['stud_prn']?></td>
								<td><?=$hostel_details[$i]['first_name']?> <?=$hostel_details[$i]['last_name']?></td>
                                <td><?=$hostel_details[$i]['stud_org']?> - <?=$hostel_details[$i]['school_name']?></td>
                                <td><?=$hostel_details[$i]['hostel_code']?></td>
								<td><?=$hostel_details[$i]['type']?></td>
								<td><?php
									$fdate= date("F", strtotime($hostel_details[$i]['from_date']));
								$tdate = date("F", strtotime($hostel_details[$i]['to_date']));
								
								if($hostel_details[$i]['from_date']!=$hostel_details[$i]['to_date'])
								{
									 if($fdate!=$tdate)
									{
										echo date("d F", strtotime($hostel_details[$i]['from_date']))." to ". date("d F, y", strtotime($hostel_details[$i]['to_date']));
									}
									else{
										echo date("d", strtotime($hostel_details[$i]['from_date']))." to ". date("d F, y", strtotime($hostel_details[$i]['to_date']));
									} 
								}
								else
								echo date("d F, y", strtotime($hostel_details[$i]['from_date']));
							?>
								</td>
                                
                                <td>
								<?php
								if($hostel_details[$i]['approval_status']=="A")
								{
									echo '<a title="Gatepass Approved" class="btn btn-success btn-xs"> Approved </a>';
								}
								else if($hostel_details[$i]['approval_status']=="P")
								{
									$temp='gatepass_process("'.$hostel_details[$i]['stud_prn'].'","'.$hostel_details[$i]['stud_org'].'",'.$hostel_details[$i]['hgp_id'].')';
									echo "<a title=\"Gatepass Pending\" onclick=".$temp." class=\"btn btn-primary btn-xs\"> Pending </a>";
								}
								else
								{
									echo '<a title="Gatepass Rejected" class="btn btn-danger btn-xs"> Rejected </a>';
								}
								
								?>
								
								</td>
                                <td>
								
								<?php
								if($hostel_details[$i]['approval_status']=="P")
								{
									?>
								   <a title="Edit Hostel Gatepass Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_gatepass/".$hostel_details[$i]['hgp_id'])?>">Edit</a>
								  <?php
								}
								
								if($hostel_details[$i]['approval_status']=="A")
								{
									?>
									<a  href="<?=base_url($currentModule."/download_gatepass_pdf/".$hostel_details[$i]['hgp_id']."/".$hostel_details[$i]['stud_prn']."/".$hostel_details[$i]['stud_org']."/".$hostel_details[$i]['academic_year'])?>" title="View" target="_blank" <?=$disable?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>
								<?php }
							
								?>								  
								</td>
								
								
								</tr>
								<?php
								$j++;
                            }
                            ?>                            
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

var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
];

var fdate='',tdate='',fdate_dd='',tdate_dd='',fdate_mm='',tdate_mm='',tdate_yy='';

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
	

	
	$('#doc-sub-datepicker20').on('changeDate', function (e) {
		var date=$('#doc-sub-datepicker20').val();
		var ddmmyy=date.split('-');
		var mmm=parseInt(ddmmyy[1]);
		$('#header_date').html(ddmmyy[2]+" "+monthNames[mmm]+", "+ddmmyy[0]%100);
		var ac_year = $("#ac_year").val();
		//alert(ac_year);
				$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Hostel/gatepass_listbydate',
				data: {date:date,ac_year:ac_year},
				success: function (html) {
					var content='';
					var array=JSON.parse(html);
					len=array.std_gatepass_details.length;
					var j=1;
					for(i=0;i<len;i++)
					{
						//alert(array.std_gatepass_details[i].student_id);
						content+='<tr><td>'+j+'</td><td>'+array.std_gatepass_details[i].enrollment_no+'</td><td>'+array.std_gatepass_details[i].first_name+' '+array.std_gatepass_details[i].last_name+'</td><td>'+array.std_gatepass_details[i].organisation+' - '+array.std_gatepass_details[i].school_name+'</td><td>'+array.std_gatepass_details[i].hostel_code+'</td><td>'+array.std_gatepass_details[i].type+'</td>';
						
						fdate='',tdate='',fdate_dd='',tdate_dd='',fdate_mm='',tdate_mm='',tdate_yy='';
						
						//var fm=(new Date(array.std_gatepass_details[i].from_date).getMonth());
						if(array.std_gatepass_details[i].from_date!=array.std_gatepass_details[i].to_date)
						{
							if((new Date(array.std_gatepass_details[i].from_date).getMonth()) != (new Date(array.std_gatepass_details[i].to_date).getMonth()))
							{
								 fdate = new Date(array.std_gatepass_details[i].from_date);
								 tdate = new Date(array.std_gatepass_details[i].to_date);
								 fdate_dd = fdate.getDate();
								 tdate_dd = tdate.getDate();
								 fdate_mm = monthNames[fdate.getMonth()];
								 tdate_mm = monthNames[tdate.getMonth()];
								 tdate_yy = new Date(array.std_gatepass_details[i].to_date).getFullYear();
								 content+='<td>'+fdate_dd+' '+fdate_mm+' to '+tdate_dd+' '+tdate_mm+' '+tdate_yy%100+'</td>';
							}
							else
							{
								 fdate = new Date(array.std_gatepass_details[i].from_date);
								 tdate = new Date(array.std_gatepass_details[i].to_date);
								 fdate_dd = fdate.getDate();
								 tdate_dd = tdate.getDate();
								 fdate_mm = monthNames[fdate.getMonth()];
								 tdate_mm = monthNames[tdate.getMonth()];
								 tdate_yy = new Date(array.std_gatepass_details[i].to_date).getFullYear();
								//alert(fdate_dd+' to '+tdate_dd+' '+fdate_mm+' '+tdate_yy);
								content+='<td>'+fdate_dd+' to '+tdate_dd+' '+fdate_mm+' '+tdate_yy%100+'</td>';
							}
						}
						else
						{
							 fdate = new Date(array.std_gatepass_details[i].from_date);
							 fdate_dd = fdate.getDate();
							 fdate_mm = monthNames[fdate.getMonth()];
							 tdate_yy = new Date(array.std_gatepass_details[i].to_date).getFullYear();
							//alert(fdate_dd+' '+fdate_mm+' '+tdate_yy);
							content+='<td>'+fdate_dd+' '+fdate_mm+' '+tdate_yy%100+'</td>';
						}
						
						if(array.std_gatepass_details[i].approval_status=='A')
						{
							content+='<td><a title="Gatepass Approved" class="btn btn-success btn-xs"> A </a></td><td><a  href="<?=base_url($currentModule."/download_gatepass_pdf/")?>/'+array.std_gatepass_details[i].hgp_id+'/'+array.std_gatepass_details[i].enrollment_no+'/'+array.std_gatepass_details[i].organisation+'/'+ac_year+'" title="View" target="_blank" <?=$disable?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a></td>';
						}
						else if(array.std_gatepass_details[i].approval_status=='P')
						{
							var temp='gatepass_process('+array.std_gatepass_details[i].enrollment_no+',"'+array.std_gatepass_details[i].organisation+'",'+array.std_gatepass_details[i].hgp_id+')';
							content+="<td><a title=\"Gatepass Pending\" onclick="+temp+" class=\"btn btn-primary btn-xs\"> P </a></td><td><a title=\"Edit Hostel Gatepass Details\" class=\"btn btn-primary btn-xs\" href=\"<?=base_url()?>Hostel/edit_gatepass/"+array.std_gatepass_details[i].hgp_id+"\">Edit</a></td>";
						}
						else
						content+='<td><a title="Gatepass Rejected" class="btn btn-danger btn-xs"> R </a></td>';
						
						
						
						j++;
					}
					$('#itemContainer').html(content);
				}
			});
		 }); 
	
/* 	$("#doc-sub-datepicker20").datepicker("setDate", new Date());   
	$('#doc-sub-datepicker20').datepicker({
        "setDate": new Date(),
        "autoclose": true
}); */
	
	    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
});

function gatepass_process(prn,org,id)
{
	var ac_year = $("#ac_year").val();
	alert("called");
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Hostel/get_gatepass_details',
		data: {hgp_id:id,enroll:prn,org:org,ac_year:ac_year},
		success: function (html) {
			//alert(html);
			var array=JSON.parse(html);
			var acy=parseInt(array.std_gatepass_details.academic_year.slice(-2))+1;
			$('#acadmic').html(array.std_gatepass_details.academic_year+'-'+acy);
			$('#prn').html(prn);
			$('#std_name').html(array.std_gatepass_details.first_name+' '+array.std_gatepass_details.middle_name+' '+array.std_gatepass_details.last_name);
			$('#organisation').html(org);
			$('#type').html(array.std_gatepass_details.type);
			var f_date = new Date(array.std_gatepass_details.from_date);
			$('#fdate').html(f_date.getDate()+'-'+monthNames[f_date.getMonth()]+'-'+f_date.getFullYear());
			var t_date = new Date(array.std_gatepass_details.to_date);
			$('#tdate').html(t_date.getDate()+'-'+monthNames[t_date.getMonth()]+'-'+t_date.getFullYear());
			$('#reason').html(array.std_gatepass_details.purpose);
			$('#deposit').html(array.std_gatepass_details.mobile);
			$('#hgp_id').val(id);
			$('#hgpid').val(id);
		}
	});
	$('#remarks').val('');
	$("#myModal1").modal();
}
/* 
$('#getpass_cancel').click(function()
{
	$('#err_msg').html('');
	$('#app_rej_btn').show();
	$('#reject_remark').hide();
	
});

$('#reject').click(function()
{
	$('#app_rej_btn').hide();
	$('#reject_remark').show();
}); */


</script>