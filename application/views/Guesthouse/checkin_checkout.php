<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>
var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
var status=0;
var error_status=0;
var ghouses = {};
var map1 = new Map();
var temp_arr="";
$(document).ready(function(){
	var cur_status='<?=$visitor_details['current_status']?>';
	
	if(cur_status=='CHECK-IN')
	{
		var visitor_id='<?=$visitor_details['booking_id']?>';
		//alert(visitor_id);
		$.ajax({
			'url' : base_url + 'Guesthouse/guesthouse_count_details',
			'type' : 'POST', //the way you want to send data to your URL
			'data' : {'visitor_id':visitor_id},
			'success' : function(data1){ 
				//alert(data1);
				var array=JSON.parse(data1);
				len=array.guesthouse_details.length;;
				var j=1;
				for(i=0;i<len;i++)
				{
					temp_arr+=(array.guesthouse_details[i].gh_id)+'_'+(array.guesthouse_details[i].guesthouse_name)+'_'+(array.guesthouse_details[i].bed_available)+'='+(array.guesthouse_details[i].bed_count)+'[]';
				}
				temp_arr=temp_arr.slice(0,-2);
				//alert('temp_arr=='+temp_arr);
				$('#remain_bed_available').val(temp_arr);
				//$('#err_msg').html(temp_arr);
			}
		});
	}
});
function display_noncash()
{
	var ptype = $('#epayment_type').val();
	if((ptype=='CASH'))
	{
		$('#non_cash').hide();
	   // $('#Online_pay').hide();

	}
	else if((ptype=='OL')){
		$('#non_cash').hide();
		$('#receipt').html('Transaction No. :<?=$astrik?>');
		$('#paiddate').html(' Date. :<?=$astrik?>');
		$('#non_cash').show();
		//$('#Online_pay').show();
	}
	else
	{ //$('#Online_pay').hide();
		$('#receipt').html(ptype+' No. :<?=$astrik?>');
		$('#paiddate').html(ptype+' Date. :<?=$astrik?>');
		$('#non_cash').show();
	}
}

function match_count(id)
{
	status=0;
	var selected_val=$('#'+id).val();
	if(selected_val!="")
		$('#err'+id).html('');
	else
		$('#err'+id).html('Please Select Visitor Guesthouse');
	
	var len=$('#itemContainer select[name="ghouse[]"]').length;
	var cnt=0,i;
	
	for(i=1;i<=len;i++)
	{
		val=$('#gh_'+i).val();
		if(selected_val==val)
		{cnt++;}
	}
	var actual_bed=map1.get(selected_val);
	val=selected_val.split('_');
	if(cnt > actual_bed)
	{
		status=1;
		$('#err_msg1').html(val[1]+' has only '+val[2]+' beds but u have selected more');
		//$('#err_msg1').html(val[0]+' has only '+val[2]+' beds');
	}
}
function pending(th){
	var Charge="<?php echo $visitor_details['charges']; ?>";
	var amount=th.value;
	var final_amount=Charge - amount;
	$("#Pendingamt").val(final_amount);
	
	//alert(th.value);
}

function pay(is){
	var Charge="<?php echo $visitor_details['balance']; ?>";
	var amount=is.value;
	var final_amount=Charge - amount;
	//$("#amt").val(final_amount);
}
<?php 
$content='';
if(!empty($get_beds_available_gh)){
	foreach($get_beds_available_gh as $gh){
	  $content.='<option value="'.$gh['gh_id'].'_'.$gh['guesthouse_name'].'_'.$gh['bed_available'].'">'.$gh['guesthouse_name'].'</option>';?>

	  ghouses['<?=$gh['gh_id'].'_'.$gh['guesthouse_name'].'_'.$gh['bed_available']?>'] = '<?=$gh['bed_available']?>';	
		
	map1.set('<?=$gh['gh_id'].'_'.$gh['guesthouse_name'].'_'.$gh['bed_available']?>', '<?=$gh['bed_available']?>');
	
<?php 
	}
	//$content.='</select>';
}
?>

</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Guest House </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Guest House Entry</h1>
					
			<span id="flash-messages" style="color:Green;padding-left:250px;">
			<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
			<span id="flash-messages" style="color:red;padding-left:250px;">
			<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
               <!-- <div class="panel-heading">
					<div class="row">
                      <label class="col-sm-3">Guest House Registered Mobile:</label>
					   <div class="col-sm-3">
					   <input type="text" class="onlynum form-control" name="vmobile" id="vmobile" placeholder="Registered Mobile" maxlength="10">
					   </div>
                      <div class="col-sm-2">
					  <button class="btn btn-primary form-control" id="sbutton" type="button" >Submit</button>
					  </div>
					  <div class="col-sm-4"></div>
					  
					  
                    </div>
                </div>-->
				<h4 id="err_msg" style="padding-left:100px;color:red;"></h4>
                <div class="panel-body"  id="checkinout">
					
					<table class="table table-bordered">
						 <tr>
						  <th>Name :</th>
						  <td class="col-sm-4"><span id="std_name"><?=$visitor_details['visitor_name']?></span></td>
						  <th>Mobile:</th>
						  <td class="col-sm-4"><span id="type"><?=$visitor_details['mobile']?></span></td>
						  
						</tr> 
						 <tr>
						 <th>Gender:</th>
						  <td class="col-sm-4"><span id="organisation"><?=$visitor_details['gender']?></span></td>
						  <th style="text-align: left;">Email:</th>
						  <td class="col-sm-4"><span id="acadmic"><?=$visitor_details['email']?></span></td>
						</tr>   
						<tr>
						  <th style="text-align: left;">Reference Of:</th>
						  <td class="col-sm-4"><span id="prn_num"><?=$visitor_details['reference_of']?></span></td>
						   <th style="text-align: left;">Visiting Purpose:</th>
						   <td class="col-sm-4"><span id="reason"><?=$visitor_details['visiting_purpose']?></span></td>
						</tr>
						
						<tr>
						  <th>Proposed In Date:</th>
						  <td class="col-sm-4"><span id="fdate"><?=$visitor_details['proposed_in_date']?></span></td>
						  <th style="text-align: left;">Proposed Out Date:</th>
						  <td class="col-sm-4"><span id="tdate"><?=$visitor_details['proposed_out_date']?></span></td>
						</tr>
						
						<tr id="chck_date" style="display:none;">
						  <th>Check In Date:</th>
						  <td class="col-sm-4"><span id="cin_date"></span></td>
						  <th style="text-align: left;">Check Out Date:</th>
						  <td class="col-sm-4"><span id="cout_date"></span></td>
						</tr>
						
						<tr>
						  <th style="text-align: left;">No. Of Person:</th>
						  <td class="col-sm-4"><span id="nov"><?=$visitor_details['no_of_person']?></span></td>
						   <th style="text-align: left;">No. Of Days:</th>
						   <td class="col-sm-4"><span id="bkgh"><?=$visitor_details['no_of_days']?></span></td>
						</tr>

				</table>
				<?php
				$path='';
				if($visitor_details['current_status']=='CHECK-IN')
					$path=base_url($currentModule.'/update_checkout/'.$visitor_details['booking_id']);
				else if($visitor_details['current_status']=='BOOKING-DONE')
					$path=base_url($currentModule.'/update_checkin/'.$visitor_details['booking_id']);
				?>
				
				<form name="form" id="form" action="<?=$path?>" <?php
				if($visitor_details['current_status']=='BOOKING-DONE')
				{
					?>
			onsubmit="return validate_faci_category(event)" 
			<?php
				}
				
				?>
				method="POST">
                
				<table class="table table-bordered" id="visitors" >
					<thead>
						<tr>
						<th>#</th>
						<th>Visitors Name</th>
						<th>Mobile</th>
						<th>GuestHouse</th>
                        <th>Bed&nbsp;No</th>
						</tr>
					</thead>
					
					<tbody id="itemContainer">
						<?php $gh_selected=0;$i=1;
							if(!empty($selected_guesthouse)){
								
								foreach($selected_guesthouse as $gh){
									?>
								<tr>
									<td><?=$i?></td>
									<td><?=$gh['visitor_name']?></td>
									<td><?=$gh['mobile']?></td>
									<td>
									<?php 
									if($gh['gh_id']>0)
									{$gh_selected=1;
									?>
									<?=$gh['guesthouse_name']?>
									<?php
									}else{
									?>
									<input type="hidden" value="<?=$gh['vr_id']?>" name="vr_id[]"/>
									<select  data-rule-required="true" style="width: 150px;" id="gh_<?=$i?>" class="vsghouse form-control" name="ghouse[]" onchange="match_count(this.id)" ><option value="">Select GuestHouse</option><?=$content?></select><span style="color:RED;" id="errgh_<?=$i?>"></span>
									<?php
									
									}
									$i++;
									?>
									</td>
                                    <td><?=$gh['bed_no']?></td>
								</tr>
								<?php 
									
								}
							}
						  ?>
					</tbody>
				</table>
                <?php if($visitor_details['current_status']=='BOOKING-DONE'){ ?>
                <div class="panel-body">
						<div class="col-md-6" >
                        <div class="form-group">
						<label class="col-md-4" style="padding-left:0px;"> Room Rate:<?=$astrik?></label>
						<div class="col-md-6" >
						<input type="text" class="form-control numbersOnly" name="Charge" readonly="readonly" value="<?php echo $visitor_details['charges']; ?>" id="Charge"/>
                        </div>
                                         <div class="col-md-1"></div>
								  </div>
                           <div class="form-group">
						<label class="col-md-4" style="padding-left:0px;">Adavance Amount:<?=$astrik?></label>
						<div class="col-md-6" >
						<input type="text" class="form-control numbersOnly" name="amt" id="amt" onchange="pending(this)"/>
                        </div>
                                         <div class="col-md-1"></div>
								  </div>  
                                  <div class="form-group">
						<label class="col-md-4" style="padding-left:0px;">Pending Amount:<?=$astrik?></label>
						<div class="col-md-6" >
						<input type="text" class="form-control numbersOnly" name="Pendingamt" id="Pendingamt" value="<?php echo $visitor_details['balance'];?>" readonly="readonly"/>
                        </div>
                                         <div class="col-md-1"></div>
								  </div>     
                                  
									<div class="form-group">
										<label class="col-md-4" style="padding-left:0px;">Paid By:<?=$astrik?></label>
										<div class="col-md-6" >
											<select name="epayment_type" id="epayment_type" onchange="display_noncash()" class="form-control" >
											<option value="">Select Paid By</option>
											
											<option value="POS">POS</option>
											<option value="CASH">Challan/CASH</option>
                                            
											</select>	
										   </div>
										<div class="col-md-1"></div>
									  </div>  
									  
									  
										
									   
                                 <div class="form-group">
										
										<label class="col-md-4" style="padding-left:0px;" id="">Remark:</label>
											<div class="col-md-6" >
											<input type="text" name="Remark" id="Remark" class="form-control" />
										</div><div class="col-md-1"></div>
										</div>
                                 </div>
                                 
                                 <div class="col-md-6" >
                                 <div id="Online_pay" style="display:none;">
									   <div class="form-group">
										
										<label class="col-md-4" style="padding-left:0px;" id="">Transaction No:<?=$astrik?> </label>
											<div class="col-md-6" >
											<input type="text" class="form-control"  name="TransactionNo" id="TransactionNo" />
										</div><div class="col-md-1"></div>
										</div>
										 <div class="form-group">
										
										<label class="col-md-4" style="padding-left:0px;" id="">Transaction Date:<?=$astrik?> </label>
											<div class="col-md-6" >
											<input type="text" class="form-control"  name="TransactionDate" id="TransactionDate" />
										</div><div class="col-md-1"></div>
										</div>
										
									   </div>
									  <div id="non_cash" style="display:none;">
										<div class="form-group">
										
										<label class="col-md-4" style="padding-left:0px;" id="receipt"></label>
											<div class="col-md-6" >
											<input type="text" class="form-control numbersOnly"  name="receipt_number" id="receipt_number" />
										</div><div class="col-md-1"></div>
										</div>
										
										
								  <div class="form-group">
										<label class="col-md-4" style="padding-left:0px;" id="paiddate"></label>
													 <div class="col-md-6" >
											 <input type="text" id="fees_date" name="fees_date" class="form-control"   readonly="true" />
											 
									   </div><div class="col-md-1"></div>
								  </div>
								  <div class="form-group">
										<label class="col-md-4" style="padding-left:0px;">Bank Name:<?=$astrik?></label>
								<div class="col-md-6" >
									<select class="form-control" name="bank" id="bank" >
									  <option value="">select Bank</option>
									   <?php 
													if(!empty($bank_details)){
														foreach($bank_details as $bank){
															?>
														  <option value="<?=$bank['bank_id']?>"><?=$bank['bank_name']?></option>  
														<?php 
															
														}
													}
											  ?>
								  </select>
									   </div><div class="col-md-1"></div>
								  </div>
								  
								  <div class="form-group">
									<label class="col-md-4" style="padding-left:0px;">Bank Branch:</label>
											 <div class="col-md-6" >
											 <input type="text" class="form-control alphaOnly" onchange="total_fees()" name="branch" id="branch" />
                                       </div><div class="col-md-1"></div>
                                  </div>  
								 </div></div>
                                 </div>
                <?php }elseif(($visitor_details['current_status']=='CHECK-IN')&&($visitor_details['balance']!=0)){ ?>
                <div class="panel-body">
						<div class="col-md-6" >
                        <div class="form-group">
						<label class="col-md-4" style="padding-left:0px;"> Room Rate:<?=$astrik?></label>
						<div class="col-md-6" >
						<input type="text" class="form-control numbersOnly" name="Charge" readonly="readonly" value="<?php echo $visitor_details['charges']; ?>" id="Charge"/>
                        </div>
                                         <div class="col-md-1"></div>
								  </div>
                                  <div class="form-group">
						<label class="col-md-4" style="padding-left:0px;">Pending Amount:<?=$astrik?></label>
						<div class="col-md-6" >
						<input type="text" class="form-control numbersOnly" name="Pendingamt" id="Pendingamt" value="<?php echo $visitor_details['balance'];?>" readonly="readonly"/>
                      <input type="hidden" class="form-control numbersOnly" name="pay_amount" id="pay_amount" value="<?php echo $visitor_details['pay_amount'];?>" readonly="readonly"/>
                        </div>
                                         <div class="col-md-1"></div>
								  </div>
                           <div class="form-group">
						<label class="col-md-4" style="padding-left:0px;">Pay Amount:<?=$astrik?></label>
						<div class="col-md-6" >
						<input type="text" class="form-control numbersOnly" name="amt" id="amt"/>
                        </div>
                                         <div class="col-md-1"></div>
								  </div>  
                                       
                                  
									<div class="form-group">
										<label class="col-md-4" style="padding-left:0px;">Paid By:<?=$astrik?></label>
										<div class="col-md-6" >
											<select name="epayment_type" id="epayment_type" onchange="display_noncash()" class="form-control" >
											<option value="">Select Paid By</option>
											
											<option value="POS">POS</option>
											<option value="CASH">Challan/CASH</option>
                                            
											</select>	
										   </div>
										<div class="col-md-1"></div>
									  </div>  
									  
									  
										
									   
                                 <div class="form-group">
										
										<label class="col-md-4" style="padding-left:0px;" id="">Remark:</label>
											<div class="col-md-6" >
											<input type="text" name="Remark" id="Remark" class="form-control" />
										</div><div class="col-md-1"></div>
										</div>
                                 </div>
                                 
                                 <div class="col-md-6" >
                                 <div id="Online_pay" style="display:none;">
									   <div class="form-group">
										
										<label class="col-md-4" style="padding-left:0px;" id="">Transaction No:<?=$astrik?> </label>
											<div class="col-md-6" >
											<input type="text" class="form-control"  name="TransactionNo" id="TransactionNo" />
										</div><div class="col-md-1"></div>
										</div>
										 <div class="form-group">
										
										<label class="col-md-4" style="padding-left:0px;" id="">Transaction Date:<?=$astrik?> </label>
											<div class="col-md-6" >
											<input type="text" class="form-control"  name="TransactionDate" id="TransactionDate" />
										</div><div class="col-md-1"></div>
										</div>
										
									   </div>
									  <div id="non_cash" style="display:none;">
										<div class="form-group">
										
										<label class="col-md-4" style="padding-left:0px;" id="receipt"></label>
											<div class="col-md-6" >
											<input type="text" class="form-control numbersOnly"  name="receipt_number" id="receipt_number" />
										</div><div class="col-md-1"></div>
										</div>
										
										
								  <div class="form-group">
										<label class="col-md-4" style="padding-left:0px;" id="paiddate"></label>
													 <div class="col-md-6" >
											 <input type="text" id="fees_date" name="fees_date" class="form-control"   readonly="true" />
											 
									   </div><div class="col-md-1"></div>
								  </div>
								  <div class="form-group">
										<label class="col-md-4" style="padding-left:0px;">Bank Name:<?=$astrik?></label>
								<div class="col-md-6" >
									<select class="form-control" name="bank" id="bank" >
									  <option value="">select Bank</option>
									   <?php 
													if(!empty($bank_details)){
														foreach($bank_details as $bank){
															?>
														  <option value="<?=$bank['bank_id']?>"><?=$bank['bank_name']?></option>  
														<?php 
															
														}
													}
											  ?>
								  </select>
									   </div><div class="col-md-1"></div>
								  </div>
								  
								  <div class="form-group">
									<label class="col-md-4" style="padding-left:0px;">Bank Branch:</label>
											 <div class="col-md-6" >
											 <input type="text" class="form-control alphaOnly" onchange="total_fees()" name="branch" id="branch" />
                                       </div><div class="col-md-1"></div>
                                  </div>  
								 </div></div>
                                 </div>
				<?php } ?>
				<input type="hidden" name="remain_bed_available" id="remain_bed_available" />
				
				<div class="col-sm-2" >
				<?php
				if($visitor_details['current_status']=='BOOKING-DONE')
				{
					?>
					<button class="btn btn-primary form-control" id="checkin" type="submit" >Check In</button>
				<?php
				}else if($visitor_details['current_status']=='CHECK-IN')
				{
					?>

					<button class="btn btn-primary form-control" id="checkout" type="submit" >Check Out</button>
					<?php
				}?>
				</div>
				<?php
				if($visitor_details['current_status']=='BOOKING-DONE')
				{
					?>
				<div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="cancellation(<?=$visitor_details['booking_id']?>)">Cancellation</button></div>
				<?php
				}?>
				
				<div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule.'/booking_list')?>'">Back</button></div>
				<div class="col-sm-8">
				<span style="color:red;padding-left:0px;" id="err_msg1"></span>
				</div> 
				</form>
										
				</div>
    </div>
</div>
  <script>
  function cancellation(id)
{
	if (confirm("Are you sure,Do you want to cancel this Guesthouse?")) 
	{
		$.ajax({
			'url' : base_url + 'Guesthouse/cancellation',
			'type' : 'POST', //the way you want to send data to your URL
			'data' : {'visitor_id':id},
			'success' : function(data){ 
				alert(data);
				//$('#err_msg1').html(data);
				window.location.replace(base_url+'Guesthouse/booking_list');
			}
		});
	} 
	else 
	{
		//txt = "You pressed Cancel!";
	}
	
}

var temp_obj={};

function validate_faci_category(events)
{
	/* alert('coming');
	var gh_selected='<?=$gh_selected?>';
	if(gh_selected==0)
	{ */
		
		var array_elements=[];
		var len='<?=$i-1?>';
		var val;
		err_sts=0;
		for(i=1;i<=len;i++)
		{
			val=$('#gh_'+i).val();
			array_elements.push(val);
			
			var gh_val=$('#gh_'+i).val();
			if(gh_val=="")
			{
				err_sts=1;
				$('#errgh_'+i).html('Please Select Visitor Guesthouse');
			}
			else 
				$('#errgh_'+i).html('');
		}

		var frequencies = {};
		array_elements.map( 
		  function (v) {
			if (frequencies[v]) { frequencies[v] += 1; }
			else { frequencies[v] = 1; }
			return v;
		}, frequencies);

		var temp_arr="";
		status=0;					 
		$.each(frequencies, function( key, value ) {
			console.log( key+'=='+value );
		if(key!='' || typeof key === "undefined")
		{temp_arr+=key+'='+value+'[]';}
	
		var actual_bed=map1.get(key);
		val=key.split('_');
		if(value > actual_bed)
		{
			status=1;
			$('#err_msg1').html(val[1]+' has only '+val[2]+' beds but u have selected more');
		}
		//alert(JSON.stringify(temp_obj));
		});
		temp_arr=temp_arr.slice(0,-2);
		//alert('temp_arr=='+temp_arr);
		$('#remain_bed_available').val(temp_arr);
		
		if(error_status==1 || status==1 || err_sts==1)
		{
			$(':input[type="submit"]').prop('disabled', false);	return false;
		}
		//return false;
	//}
}
</script>  
