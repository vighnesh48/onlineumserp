
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Fees challan</a></li>
         
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Fees challan List</h1>
			<span id="err_msg1" style="color:red;"></span>
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                  <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_fees_challan")?>"><span class="btn-label icon fa fa-plus"></span>Generate </a></div>
                   
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
							<select class="form-control" name="status" id="status">
								<option value="">select challan Status</option>
								<option value="VR">verified</option>
								<option value="PD">pending</option>
								<option value="CL">cancelled</option>
							</select>
						</div>
						<div class="col-sm-2">
						  <input type="text" class="form-control" id="doc-sub-datepicker20" data-provide="datepicker" name="fdate" required readonly="true"/>
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="doc-sub-datepicker21" data-provide="datepicker" name="tdate" required readonly="true"/>
						</div>				
						<!--<div class="col-sm-2"></div>
						<div class="col-sm-1">
							<label >Search:</label>
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="search" name="search" />
						</div>-->
					</div>
                </div>
				
                <div class="panel-body" style="overflow-x:scroll;height:500px;">
				
				<!-- Modal -->
						<div id="myModal1" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content" style="width:800px;">
							  <div class="modal-header  panel-success">
							  <b>Fees challan Details</b>
							</div>
							  <div class="modal-body">
							  
								
																 
										<div class="panel-body">
											<div class="table-info">  
											<form name="form" id="form" action="<?=base_url($currentModule.'/challan_approval_submit')?>" method="POST" >
											<input type="hidden" id="feesid" name="feesid" />
											
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
													 <th scope="col">Challan Number :</th>
													  <td><span id="challan"></span></td>
													  <th scope="col">Academic Year :</th>
													  <td><span id="acadmic"></span></td>
													</tr>   
													<tr>
													  <th scope="col">Course :</th>
													  <td><span id="course"></span></td>
													   <th scope="col">Institue :</th>
													   <td><span id="institue"></span></td>
													</tr>
													<tr>
													  <th scope="col">Deposit fee:</th>
													  <td><span id="deposit"></span></td>
													  <th scope="col">Facility fee :</th>
													  <td><span id="ffee"></span></td>
													</tr>
													<tr>
													  <th scope="col">Other fee:</th>
													  <td><span id="ofee"></span></td>
													  <th scope="col">Amount :</th>
													  <td><span id="amt"></span></td>
													</tr>
													<tr>
													  <th scope="col">Paid Type:</th>
													  <td><span id="paidtype"></span></td>
													  <th scope="col">Receipt Number :</th>
													  <td><span id="receipt"></span></td>
													</tr>
													<tr>
													  <th scope="col">Fees date:</th>
													  <td><span id="feedate"></span></td>
													  <th scope="col">Deposited to:</th>
													  <td><span id="depositto"></span></td>
													</tr>
													<tr>
													  <th scope="col">Bank :</th>
													  <td><span id="bank"></span></td>
													  <th scope="col">Bank Branch :</th>
													  <td><span id="branch"></span></td>
													</tr>
													<tr>
													  <th scope="col">challan status :</th>
													  <td><span id="cstatus"></span></td>
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
												<button class="btn btn-primary form-control" id="approve" name="approve" type="submit">Verified</button>												
											</div>
											
											
											<div class="col-sm-2">
												<button class="btn btn-primary form-control" id="reject" name="reject">Cancelled</button>
											</div>
											
											</div>
											
											</form>
											
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
									<th>Challan</th>
                                    <th>Student Id</th>
									<th>Name</th>
                                    <th>Amount</th>
									<th>Date</th>
                                    
									<th>Status</th>
                                    
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            $j=1;                      
                            for($i=0;$i<count($challan_details);$i++)
                            {
                                
                            ?>
                            <tr>
                                <td><?=$j?></td>                                                                
                                <td><?=$challan_details[$i]['exam_session']?></td>
								<td><?=$challan_details[$i]['enrollment_no']?></td>
								<td><?=$challan_details[$i]['first_name']?> <?=$challan_details[$i]['last_name']?></td>
                                <td><?=$challan_details[$i]['amount']?></td>
								<td><?php
								echo date("d F, y", strtotime($challan_details[$i]['created_on']));
								?></td>
								<td><?=$challan_details[$i]['challan_status']?></td>
								<td>
								<a title="View challan Details" class="btn btn-primary btn-xs" onclick="fullview_challan('<?=$challan_details[$i]['fees_id']?>')">View</a>
								
								<a title="Edit challan Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_challan/".$challan_details[$i]['fees_id'])?>">Edit</a>
								   
								<a  href="<?=base_url($currentModule."/download_challan_pdf/".$challan_details[$i]['fees_id'])?>" title="View" target="_blank" <?=$disable?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>
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
$('#doc-sub-datepicker21').val(today);
  $('#doc-sub-datepicker21').datepicker( {todayHighlight: true,format: 'yyyy-mm-dd',autoclose: true,setDate: new Date()});
	
	$('#doc-sub-datepicker20')
	   .datepicker({
		   
		   autoclose: true,
		   todayHighlight: true,
		   format: 'yyyy-mm-dd',
		   setDate: new Date()
		   
	   });
	
	$('#search').keyup(function()
	{
		var text=$('#search').val();
		$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Fees_challan/challan_list_by_creteria',
				data: {text:text},
				success: function (html) {
					var content='';
					var array=JSON.parse(html);
					len=array.std_challan_list.length;
					//alert(len+"==="+html);
					var j=1;
					for(i=0;i<len;i++)
					{
						//alert(array.std_challan_list[i].student_id);
						content+='<tr><td>'+j+'</td><td>'+array.std_challan_list[i].exam_session+'</td><td>'+array.std_challan_list[i].enrollment_no+'</td><td>'+array.std_challan_list[i].first_name+' '+array.std_challan_list[i].last_name+'</td><td>'+array.std_challan_list[i].amount+'</td>';
						
						fdate = new Date(array.std_challan_list[i].fees_date);
						fdate_dd = fdate.getDate();
						fdate_mm = monthNames[fdate.getMonth()];
						tdate_yy = new Date(array.std_challan_list[i].fees_date).getFullYear();
						//alert(fdate_dd+' '+fdate_mm+' '+tdate_yy);
						content+='<td>'+fdate_dd+' '+fdate_mm+' '+tdate_yy%100+'</td>';
						content+='<td>'+array.std_challan_list[i].challan_status+'</td><td><a title="View challan Details" class="btn btn-primary btn-xs" onclick="fullview_challan('+array.std_challan_list[i].fees_id+')">View</a><a title="Edit challan Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_challan/")?>'+array.std_challan_list[i].fees_date+'">Edit</a><a  href="<?=base_url($currentModule."/download_challan_pdf/".$challan_details[$i]['fees_id'])?>" title="View" target="_blank" <?=$disable?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a></td>';
					
						j++;
					}
					$('#itemContainer').html(content);
				}
			});
	});
	
	
	$('#status').change(function() {
		var status=$('#status').val();
		var tdate=$('#doc-sub-datepicker21').val();
		var fdate=$('#doc-sub-datepicker20').val();
		
		if ((Date.parse(tdate) < Date.parse(fdate))) 
		{
			$('#err_msg1').html('To date should be greater than From date');
		}
		else
		{
			$('#err_msg1').html('');
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Fees_challan/challan_list_by_creteria',
				data: {status:status,tdate:tdate,fdate:fdate},
				success: function (html) {
					var content='';
					var array=JSON.parse(html);
					len=array.std_challan_list.length;
					//alert(len+"==="+html);
					var j=1;
					for(i=0;i<len;i++)
					{
						//alert(array.std_challan_list[i].student_id);
						content+='<tr><td>'+j+'</td><td>'+array.std_challan_list[i].exam_session+'</td><td>'+array.std_challan_list[i].enrollment_no+'</td><td>'+array.std_challan_list[i].first_name+' '+array.std_challan_list[i].last_name+'</td><td>'+array.std_challan_list[i].amount+'</td>';
						
						fdate = new Date(array.std_challan_list[i].fees_date);
						fdate_dd = fdate.getDate();
						fdate_mm = monthNames[fdate.getMonth()];
						tdate_yy = new Date(array.std_challan_list[i].fees_date).getFullYear();
						//alert(fdate_dd+' '+fdate_mm+' '+tdate_yy);
						content+='<td>'+fdate_dd+' '+fdate_mm+' '+tdate_yy%100+'</td>';
						content+='<td>'+array.std_challan_list[i].challan_status+'</td><td><a title="View challan Details" class="btn btn-primary btn-xs" onclick="fullview_challan('+array.std_challan_list[i].fees_id+')">View</a><a title="Edit challan Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_challan/")?>'+array.std_challan_list[i].fees_date+'">Edit</a><a  href="<?=base_url($currentModule."/download_challan_pdf/".$challan_details[$i]['fees_id'])?>" title="View" target="_blank" <?=$disable?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a></td>';
					
						j++;
					}
					$('#itemContainer').html(content);
				}
			});
		}
	});
	
	
	$('#doc-sub-datepicker21').on('changeDate', function (e) {
		var status=$('#status').val();
		var tdate=$('#doc-sub-datepicker21').val();
		var fdate=$('#doc-sub-datepicker20').val();
		if ((Date.parse(tdate) < Date.parse(fdate))) 
		{
			$('#err_msg1').html('To date should be greater than From date');
		}
		else
		{
			$('#err_msg1').html('');
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Fees_challan/challan_list_by_creteria',
				data: {status:status,tdate:tdate,fdate:fdate},
				success: function (html) {
					var content='';
					var array=JSON.parse(html);
					len=array.std_challan_list.length;
					//alert(len+"==="+html);
					var j=1;
					for(i=0;i<len;i++)
					{
						content+='<tr><td>'+j+'</td><td>'+array.std_challan_list[i].exam_session+'</td><td>'+array.std_challan_list[i].enrollment_no+'</td><td>'+array.std_challan_list[i].first_name+' '+array.std_challan_list[i].last_name+'</td><td>'+array.std_challan_list[i].amount+'</td>';
						
						fdate = new Date(array.std_challan_list[i].fees_date);
						fdate_dd = fdate.getDate();
						fdate_mm = monthNames[fdate.getMonth()];
						tdate_yy = new Date(array.std_challan_list[i].fees_date).getFullYear();
						//alert(fdate_dd+' '+fdate_mm+' '+tdate_yy);
						content+='<td>'+fdate_dd+' '+fdate_mm+' '+tdate_yy%100+'</td>';
						content+='<td>'+array.std_challan_list[i].challan_status+'</td><td><a title="View challan Details" class="btn btn-primary btn-xs" onclick="fullview_challan('+array.std_challan_list[i].fees_id+')">View</a><a title="Edit challan Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_challan/")?>'+array.std_challan_list[i].fees_date+'">Edit</a><a  href="<?=base_url($currentModule."/download_challan_pdf/".$challan_details[$i]['fees_id'])?>" title="View" target="_blank" <?=$disable?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a></td>';
						j++;
					}
					$('#itemContainer').html(content);
				}
			});
		}
	}); 
			
	$('#doc-sub-datepicker20').on('changeDate', function (e) {
		var fdate=$('#doc-sub-datepicker20').val();
		var status=$('#status').val();
		//alert(date);
		var ddmmyy=fdate.split('-');
		var mmm=parseInt(ddmmyy[1]);
		
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Fees_challan/challan_list_by_creteria',
				data: {status:status,fdate:fdate},
				success: function (html) {
					var content='';
					var array=JSON.parse(html);
					len=array.std_challan_list.length;
					//alert(len+"==="+html);
					var j=1;
					for(i=0;i<len;i++)
					{
						content+='<tr><td>'+j+'</td><td>'+array.std_challan_list[i].exam_session+'</td><td>'+array.std_challan_list[i].enrollment_no+'</td><td>'+array.std_challan_list[i].first_name+' '+array.std_challan_list[i].last_name+'</td><td>'+array.std_challan_list[i].amount+'</td>';
						
						fdate = new Date(array.std_challan_list[i].fees_date);
						fdate_dd = fdate.getDate();
						fdate_mm = monthNames[fdate.getMonth()];
						tdate_yy = new Date(array.std_challan_list[i].fees_date).getFullYear();
						//alert(fdate_dd+' '+fdate_mm+' '+tdate_yy);
						content+='<td>'+fdate_dd+' '+fdate_mm+' '+tdate_yy%100+'</td>';
						content+='<td>'+array.std_challan_list[i].challan_status+'</td><td><a title="View challan Details" class="btn btn-primary btn-xs" onclick="fullview_challan('+array.std_challan_list[i].fees_id+')">View</a><a title="Edit challan Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_challan/")?>'+array.std_challan_list[i].fees_date+'">Edit</a><a  href="<?=base_url($currentModule."/download_challan_pdf/".$challan_details[$i]['fees_id'])?>" title="View" target="_blank" <?=$disable?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a></td>';
						j++;
					}
					$('#itemContainer').html(content);
				}
			});
		 }); 
	
	// Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
});

function fullview_challan(id)
{
	//alert("called");
	$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Fees_challan/get_challan_details',
				data: {id:id},
				success: function (html) {
					var array=JSON.parse(html);
					var acy=parseInt(array.challan_details.academic_year.slice(-2))+1;
					$('#acadmic').html(array.challan_details.academic_year+'-'+acy);
					$('#prn').html(array.challan_details.enrollment_no);
					$('#feesid').val(array.challan_details.fees_id);
					$('#std_name').html(array.challan_details.first_name+' '+array.challan_details.middle_name+' '+array.challan_details.last_name);
					$('#mobile').html(array.challan_details.mobile);
					$('#institue').html(array.challan_details.school_name);
					$('#course').html(array.challan_details.course_name);
					$('#challan').html(array.challan_details.exam_session);
					$('#deposit').html(array.challan_details.deposit_fees);
					$('#ffee').html(array.challan_details.facility_fees);
					$('#ofee').html(array.challan_details.other_fees);
					$('#amt').html(array.challan_details.amount);
					$('#paidtype').html(array.challan_details.fees_paid_type);
					$('#receipt').html(array.challan_details.receipt_no);
					$('#feedate').html(array.challan_details.fees_date);
					$('#branch').html(array.challan_details.bank_city);
					$('#depositto').html(array.challan_details.account_name);
					$('#bank').html(array.challan_details.bank_name);
					var s='';
					if(array.challan_details.challan_status=='VR')
						s='Verified';
					else if(array.challan_details.challan_status=='CL')
						s='Cancelled';
					else
						s='Pending';
					$('#cstatus').html(s);
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