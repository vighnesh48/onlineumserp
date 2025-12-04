
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Exam Fees challan</a></li>
         
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Exam Fees challan List</h1>
			<span id="err_msg1" style="color:red;"></span>
			<div class="col-xs-12 col-sm-8">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                 <!--  <div class="pull-right col-xs-12 col-sm-auto"><a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_fees_challan")?>"><span class="btn-label icon fa fa-plus"></span>Generate </a></div> -->
                   
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
				
					<!-- <div class="row">
				
						<div class="col-sm-3">
						<select class="form-control" name="status" id="status">
								<option value="">Select challan Status</option>
								<option value="VR">Deposited</option>
								<option value="PD">Pending</option>
								<option value="CL">Cancelled</option>
							</select>
						</div>
						<div class="col-sm-3">
							<select class="form-control" name="selectby" id="selectby">
								<option value="">Select By Duration</option>
								<option value="Datewise">Datewise</option>
								<option value="Between">Between Dates</option>
							</select>
						</div>
						
						<div class="form-group" id="datewise" style="display:none;">
						<!--<label class="col-sm-1">Date: <?=$astrik?></label>-->
						<!-- 	<div class="col-sm-2">
							<input type="text" class="form-control" id="doc-sub-datepicker20" name="date" required readonly="true"/>
							</div>
						</div>
						
						<div class="form-group" id="between" style="display:none;">
					
							<div class="col-sm-2">
							  <input type="text" class="form-control" id="doc-sub-datepicker21" name="fdate" required readonly="true"/>
							</div>
							<label class="col-sm-1">Between</label>
						
							<div class="col-sm-2">
							  <input type="text" class="form-control" id="doc-sub-datepicker23" name="tdate" required readonly="true"/>
							</div>
						</div> -->
						
						<!--
						<label class="col-sm-1">From</label>
						<div class="col-sm-2">
						  <input type="text" class="form-control" id="doc-sub-datepicker20" data-provide="datepicker" name="fdate" required readonly="true"/>
						</div>
						<label class="col-sm-1">To </label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="doc-sub-datepicker21" data-provide="datepicker" name="tdate" required readonly="true"/>
						</div>				
						<div class="col-sm-2"></div>
						<div class="col-sm-1">
							<label >Search:</label>
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="search" name="search" />
						</div>-->
					</div> 
                </div>
				
                <div class="panel-body">
				
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
                       <table class="table table-bordered" style="width:100%;max-width:100%;">
                        <thead>
                            <tr>
                                    <th>#</th>
									<th>Challan</th>
                                    <th>Student Id</th>
									<th>Name</th>
                                    <th>Amount</th>
									<th>Paid Date</th>
                                    
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
								<td>
								<?php if($challan_details[$i]['type_id']==11){echo 'External';}else{?>
								<?=$challan_details[$i]['enrollment_no']?><?php } ?></td>
								<td>
								<?php if($challan_details[$i]['type_id']==11){echo $challan_details[$i]['guest_name'];}else{?>
								<?=$challan_details[$i]['first_name']?> <?=$challan_details[$i]['last_name']?>
                                <?php } ?></td>
                                <td><?=$challan_details[$i]['amount']?></td>
								<td><?php
								echo date("d/m/Y", strtotime($challan_details[$i]['created_on']));
								?></td>
								<td><?php if($challan_details[$i]['challan_status']=='VR')echo '<span style="color:Green" >Deposited</span>';
											else if($challan_details[$i]['challan_status']=='CL')echo '<span style="color:red" >Cancelled</span>';else echo '<span style="color:#1d89cf" >Pending</span>';?></td>
								<td>
								<!--  <a title="View challan Details" class="btn btn-primary btn-xs" onclick="fullview_challan('<?=$challan_details[$i]['fees_id']?>')">View</a>
								-->
								<a title="View challan Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/editexam_challan/".$challan_details[$i]['fees_id'])?>">View</a>
								   
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
	
  $('#doc-sub-datepicker20').val(today);
$('#doc-sub-datepicker21').val(today);
$('#doc-sub-datepicker23').val(today);
	
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
            $('#between').hide();
			$('#datewise').show();
        }
        else if (this.value == 'Between') {
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
	

	$('#status').change(function() {
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
	var status=$('#status').val();
	var selectby=$('#selectby').val();
	var odate=$('#doc-sub-datepicker20').val();
	var fdate=$('#doc-sub-datepicker21').val();
	var tdate=$('#doc-sub-datepicker23').val();
	type='POST',url='<?= base_url() ?>Challan/challan_list_by_creteria';
	if(selectby!='' && selectby=='Between')
	{
		if ((Date.parse(tdate) < Date.parse(fdate))) 
		{
			$('#err_msg1').html('To date should be greater than From date');
		}
		else
		{
			$('#err_msg1').html('');
			datastring={status:status,tdate:tdate,fdate:fdate};
			html_content=ajaxcall(type,url,datastring);
			display_content(html_content);
		}
	}
	else if(selectby!='' && selectby=='Datewise')
	{
		$('#err_msg1').html('');
		datastring={status:status,odate:odate};
		html_content=ajaxcall(type,url,datastring);
		display_content(html_content);
	}
	else
	{
		$('#err_msg1').html('');
		datastring={status:status};
		html_content=ajaxcall(type,url,datastring);
		display_content(html_content);
	}
}

var challan_status='';
function display_content(html_content)
{
	var content='';
	if(html_content === "{\"std_challan_list\":[]}")
	{
		$('#itemContainer').html('No Data!!');
	}
	else
	{
		var array=JSON.parse(html_content);
		len=array.std_challan_list.length;
		//alert(len+"==="+html);
		var j=1;
		for(i=0;i<len;i++)
		{
			//alert(array.std_challan_list[i].student_id);
			content+='<tr><td>'+j+'</td><td>'+array.std_challan_list[i].exam_session+'</td><td>'+array.std_challan_list[i].enrollment_no+'</td><td>'+array.std_challan_list[i].first_name+' '+array.std_challan_list[i].last_name+'</td><td>'+array.std_challan_list[i].amount+'</td>';
			
			fdate = new Date(array.std_challan_list[i].fees_date);
			fdate_dd = fdate.getDate();
			fdate_mm = fdate.getMonth()+1;
			tdate_yy = new Date(array.std_challan_list[i].fees_date).getFullYear();
			if(fdate_dd<10){
			fdate_dd='0'+fdate_dd;
			} 
			if(fdate_mm<10){
			fdate_mm='0'+fdate_mm;
			}
			//alert(fdate_dd+' '+fdate_mm+' '+tdate_yy);
			content+='<td>'+fdate_dd+'/'+fdate_mm+'/'+tdate_yy+'</td>';
			
			if(array.std_challan_list[i].challan_status=='VR')
				challan_status='<span style="color:Green" >Deposited</span>';
			else if(array.std_challan_list[i].challan_status=='CL')
				challan_status='<span style="color:red" >cancelled</span>';
			else 
				challan_status='<span style="color:#1d89cf" >Pending</span>';
			
			content+='<td>'+challan_status+'</td><td><a title="View challan Details" class="btn btn-primary btn-xs" href="<?=base_url($currentModule."/edit_challan")?>/'+array.std_challan_list[i].fees_id+'">View</a><a href="<?=base_url($currentModule."/download_challan_pdf")?>/'+array.std_challan_list[i].fees_id+'" title="Download PDF" target="_blank" <?=$disable?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a></td>';
		
			j++;
		}
		$('#itemContainer').html(content);
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