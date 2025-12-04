<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />

<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>

<script>    
    $(document).ready(function()
    {
	$('#form1').bootstrapValidator	
({ 
message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
                 {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
                  },
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
                  },
            fields: 
                  {
					search_id:	
                         {
                             validators: 
                               {
                                    notEmpty: 
                                       {
                                        message: 'Please Enter Student Id,this should not be empty'
                                         }                     
                                }
						  }
				  }
})	
	});
	
	
var student_id = '<?=$student_list['stud_id']?>';
var academic_year = '<?=$student_list['academic']?>';
var enrollment_no = '<?=$student_list['enrollment_no']?>';	
	//alert(student_id+"academic_year=="+academic_year+"enrollment_no=="+enrollment_no);
	
	
	 $(document).ready(function(){
		/*  $.ajax({
                    'url' : base_url + 'Hostel/check_allocate',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'academic_year':academic_year,'student_id':student_id,'enrollment_no':enrollment_no},
                    'success' : function(data){
						//alert(data);
						if(data!='')
						{
							$('#deallocate').attr('onclick', 'de_allocate_bed('+data+')');
							$('#deallocate').show();
						}
						else
						{
							$('#deallocate').hide();
						}
					}
		 }); */
	     
               $('#hostid').click(function(){
       
             var base_url = '<?=site_url()?>';
                   // alert(type);
                   var acyear = $("#hidacyear").val();
                    var fcid = $("#hidfacid").val();
					var prn = ($("#prn").val()).trim();
					var org = $("#org").val();
					var stud_id = $("#stud_id").val();
					
					//$("#prn_no").val(prn);
					$("#org_frm").val('<?=$student_list['organisation']?>');
					$("#ac_year").val(acyear);
					$("#fc_id").val(fcid);
					
					
                $.ajax({
                    'url' : base_url + 'Hostel/facility_fee_details',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'acyear':acyear,'fcid':fcid,'org':org},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                      //  var container = $('#showhost'); //jquery selector (get element by id)
                        if(data){
							   var jdata= JSON.parse(data);
							  // alert(jdata);
                            if(jdata==null)
							{
								$('#showhost').hide();
								$('#showerr').html('For current academic year, facility fee has not declared yet.');
								$('#showerr').show();
							}
							 else{
						//	alert(jdata.deposit);
						$('#showerr').hide();
						<?php
					if(!empty($installment)){
					?>
						$("#fdeposit").val(0);
					<?php
					}
					else{
						?>
						$("#fdeposit").val(jdata.deposit);
						<?php
					}
					
					?>
							             
                                   //  $("#ffees").html(jdata.fees);
                                    $("#fees").val(jdata.fees);
									  $("#fmid").val(jdata.sffm_id);
									  $('#showhost').show();
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                          //   $('showhost').html(data);
                            	return false;
							 }
                        }
                          return false;
                    }
                });
            });
			
			
			
			
			
		              $('#reg11').click(function(){
       
      // var formData = new FormData($("#exemform"));
             var base_url = '<?=site_url()?>';
                   // alert(type);
                 //  alert()
				    var prn = $("#prn").val();
                   var acyear = $("#hidacyear").val();
                    var fcid = $("#hidfacid").val();
					   var org = $("#org").val();
                        var cyear = $("#cyear").val();
						 var exem = $("#exem").val();
						 var fdeposit = $("#fdeposit").val();
						 
						 var stud_id = $("#stud_id").val(); 
						  var fmid = $("#fmid").val(); 
						  var gym_fees=$("#gym_fees").val();
						   var pending_balance=$("#pending_balance").val();
						   //alert(gym_fees);alert(pending_balance);
						   //alert(acyear+'=='+fcid+'=='+org+'=='+prn+'=='+gym_fees+'=='+pending_balance+'=='+fdeposit);return;
					if(exem!='')
			    	 {
			    	    var efil = $("#exemfile").val(); 
			    	    if(efil=='')
			    	    {
			    	        alert("Please select exemption supporting document");
			    	      return false;
			    	    }
			    	    
			    	    else{
	      var val = efil.toLowerCase();
		var regex = new RegExp("(.*?)\.(docx|doc|pdf)$");
		 if(!(regex.test(val))) {
		alert('Please select correct file format for document !');
		return false;
		} 
      }
			    	 }
			    //	 alert("test");
                $.ajax({
                    'url' : base_url + 'Hostel/register_for_facility',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'prn':prn,'acyear':acyear,'fcid':fcid,'org':org,'cyear':cyear,'exem':exem,'stud_id':stud_id,'fmid':fmid,'fdeposit':fdeposit,'efil':efil,'gym_fees':gym_fees,'pending_balance':pending_balance},
                    'success' : function(data){ 
                        if(data){
							alert("Student Registered for facility successfully");
							var lin ='<a href="<?=site_url()?>Hostel/hostel_allocation_view/'+prn+'/'+stud_id+'/'+org+'/'+data+'"><input type="button" value="Allocate hostel"></a>';
							 $('#showhost').html(lin);
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                          //   $('showhost').html(data);
                            	return false;
                        }
                          return false;
                    }
                });
            });	
			
			
			
		
			
			
			
			
			
			
			
            });
	
	
	
	
	
	
	
	function validate()
	{
	      var base_url = '<?=site_url()?>';
                   // alert(type);
                 //  alert()
				
						 var exem = $("#exem").val();
					
						   //alert(gym_fees);alert(pending_balance);
						   
					if(exem!='' || exem!=0)
			    	 {
			    	    var efil = $("#exemfile").val(); 
			    	    if(efil=='')
			    	    {
			    	        alert("Please select exemption supporting document");
			    	      return false;
			    	    }
			    	    
			    	    else{
	      var val = efil.toLowerCase();
		var regex = new RegExp("(.*?)\.(pdf|jpg|png|bmp)$");
		 if(!(regex.test(val))) {
		alert('Please select correct file format for document i.e. jpg or png or bmp or pdf !');
		return false;
		} 
      }
	}
	
	}
	
	
	
	
	
	
	function de_allocate_bed(f_alloc_id)
			{
				if (confirm("Are you sure,Do you want to de-allocate bed for this student!")) 
				{
					$.ajax({
						'url' : base_url + 'Hostel/de_allocate_bed',
						'type' : 'POST', //the way you want to send data to your URL
						'data' : {'f_alloc_id':f_alloc_id},
						'success' : function(data){ 
							alert('de-allocated successfully!!');
							location.reload();
						}
					});
				} 
				else 
				{
					//txt = "You pressed Cancel!";
				}
				
			}
      	
			function show_exemfile()
			{
			   // alert("temp");
			    	 var exem = $("#exem").val();
			    	 //exemdiv
			    	 if(exem=='')
			    	 {
			    	    $("#exemdiv").hide(); 
			    	 }
			    	 else
			    	 {
			    	   $("#exemdiv").show();     
			    	 }
			    	 
			    
			}
			
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>						
<input type="hidden" name="hidacyear" id="hidacyear" value="<?=$student_list['academic']?>">
<input type="hidden" name="hidfacid" id="hidfacid" value="1">
<input type="hidden" name="cyear" id="cyear" value="<?=$student_list['current_year']?>">
<input type="hidden" name="stud_id" id="stud_id" value="<?=$student_list['stud_id']?>">
<input type="hidden" name="fmid" id="fmid" value="">

<?php //var_dump($student_list);
   echo "<span style='color:red;padding-left:110px;'>".@$this->session->flashdata('message1')."</span>";
   ?>
						
						<table class="table table-bordered">
						<tr>
						  <th width="18%">PRN :</th>
						  <td><?=$student_list['enrollment_no']?></td> 
						  <th width="18%">Name :</th>
						  <td><?=$student_list['first_name']." ".$student_list['middle_name']." ".$student_list['last_name']?></td>
						</tr>
						<tr>
						  <th width="18%">Organisation :</th>
						  <td><?=$student_list['organisation']?></td>
						  <th width="18%">Institute :</th>
						  <td><?=$student_list['school_name']?></td>
						</tr>
						<tr>
						  <th width="18%">Mobile :</th>
						  <td><?=$student_list['mobile']?></td>
						  <th width="18%">Email :</th>
						  <td><?=$student_list['email']?></td>
						</tr>
						<tr>
						  <th width="18%">Course :</th>
						  <td><?=$student_list['stream_short_name']?></td>
						  <th width="18%">Current Year:</th>
						  <td><?=$student_list['current_year']?></td>
						</tr>
						<tr>
						  <th width="18%">Academic Year:</th>
						  <td><?=$student_list['academic']?></td>
						  <th width="18%">Admission Year:</th>
						  <td><?=$student_list['admission_session']?></td>
						</tr>
						<tr>
						  <th width="18%">Academic Payments:</th>
						  <td><a href="https://erp.sandipuniversity.com/ums_admission/viewPayments/<?=$student_list['stud_id']?>" target="_blank">View</a></td>
						  <th width="18%">Online Academic Payments:</th>
						  <td><a href="https://erp.sandipuniversity.com/online_fee/student_payment_history/<?=$student_list['enrollment_no']?>/<?=$student_list['stud_id']?>" target="_blank">View</a></td>
						</tr>
						</table>
						
						<table class="table table-bordered">
    					<tr>
    					  <th width="15%">Academic Year</th>
    					  <th scope="col">Deposit </th>
    					   <th scope="col">Actual </th>
    					  <th scope="col">Exepmted </th>
						  <th scope="col">Applicable </th>
						  <th scope="col">Gym </th>
						  <th scope="col">Fine</th>
						  <th scope="col">Opening balance</th>
    					  <th scope="col">Amount Paid</th>
    					  <th scope="col">Remaining Balance</th>
    					 
    					  <?php
    					  if($canc_charges['canc_amount']>0)
    					  {
    					  ?>
    					    <th scope="col">Chq Cancellation Charges</th>
    					      <th scope="col">Total Outstanding</th>
    					      <?php
    					      }
    					      ?>
    					</tr>
				<?php 
			if(!empty($stud_faci_details)){
				foreach($stud_faci_details as $student_faci_details)
				{
						$applicable_fee = ((int)$student_faci_details['deposit_fees'] + (int)$student_faci_details['actual_fees']) - (int)$student_faci_details['excemption_fees'];
						
						
						//$bal = (int)$student_faci_details['applicable_fee'] - (int)$get_feedetails[0]['amount'];
					  
    					//$srNo1=1;
    					
    				$actual =	isset($student_faci_details['applicable_fee']) ? $student_faci_details['applicable_fee'] : '';
    			//		$paid =isset($totfeepaid[0]['tot_fee_paid']) ? $totfeepaid[0]['tot_fee_paid'] : '';
    						//$paid =$total_fees['fee_paid'];
    						$paid =$student_faci_details['paid_amt'];
    						//echo $paid;
    					?>
    					<tr>
						    <td><?= isset($student_faci_details['academic_year']) ? $student_faci_details['academic_year'] : '' ?></td>
    						<td><?= isset($student_faci_details['deposit_fees']) ? $student_faci_details['deposit_fees'] : '' ?></td>
    							<td><?= isset($student_faci_details['actual_fees']) ? $student_faci_details['actual_fees'] : '' ?></td>
    							<td><?= isset($student_faci_details['excemption_fees']) ? $student_faci_details['excemption_fees'] : '' ?> 
    							<?php if(strlen($student_faci_details['excem_doc_path'])>10){?>
    							<a href="<?=base_url()?>uploads/Hostel/exepmted_fees/<?=$student_faci_details['excem_doc_path']?>" class="pull-right" target="_blank"><i class="fa fa-sticky-note-o" style="font-size:24px"></i></a>
    						<?php	}?></td>
							<td><?=$applicable_fee?></td>
    					    <td><?=$student_faci_details['gym_fees']?></td>
							<td><?=$student_faci_details['fine_fees']?></td>
						    <td><?=$student_faci_details['opening_balance']?></td>
    						
    						<td id="paid_amt1"><?=$paid?></td>
    						<td id="remaining1_amt">
    						<?=$bal = $applicable_fee - (int)$paid +(int)$student_faci_details['gym_fees']+(int)$student_faci_details['fine_fees']+(int)$student_faci_details['opening_balance'] ?>
    							
    						</td>
    					
    						 <?php
    					  if($canc_charges['canc_amount']>0)
    					  {
    					  ?>
    							<td><?php echo $can_amt = $canc_charges['canc_amount']; //$canc_charges[0]['canc_amount'] ?></td>
    							<td><?php echo $can_amt + $pend; //$canc_charges[0]['canc_amount'] ?></td>
    							<?php
    					  }
				}
			}
    							?>
    					</tr>
    						
    				  </table>	
						
						<div class="row ">
							
						<div class="col-sm-12">
						
							<div class="col-sm-3"><strong>Opted Hostel Facility :</strong></div>
							
							<?php if($student_list['stat']=="Y"){
									?>
									<div class="col-sm-1"><?php echo "Yes";?> </div>
									
									<div class="col-sm-3">
									<a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=site_url()?>Hostel/view_std_payment/<?=str_replace("/","_",$student_list['enrollment_no'])?>/<?=$student_list['stud_id']?>/<?=$student_list['organisation']?>/<?=$student_list['academic']?>" target="_blank">View Payment Details </a>
									</div>
									
									
									<div class="col-sm-3">
									<!--a class="btn btn-primary btn-labeled" style="display:none;" id="deallocate"  title="Click here to De-allocate Room">De-allocate</a-->	
									</div>									
									<?php
									
									} 
									else
									{
									?>
									
									<div class="col-sm-2">
									    <button class="btn btn-primary form-control col-sm-2" id="hostid" name="hostid" type="button">Apply Hostel</button>
									</div>
									
									<?php
									}
									
									?>
									
									<span class="col-sm-6" id="showerr" style="color:red;display:none"></span>
							</div>
							
							
						</div>
						
						
						
					</div>
						  <br/>  
			<div class="row ">
							
			  
					<div class="col-sm-12" id="showhost" name="showhost" style="display:none">
					<form id="exemform" name="exemform" method="post" action="<?=base_url()?>Hostel/register_for_facility" enctype="multipart/form-data" onsubmit="return validate();">
                        <input type="hidden" name="hidac_year" id="hidac_year" value="<?=$student_list['academic']?>">
                        <input type="hidden" name="ac_year" id="ac_year">
                        <input type="hidden" name="fc_id" id="fc_id">
                        <input type="hidden" name="hidfac_id" id="hidfac_id" value="1">
                        <input type="hidden" name="email" id="email" value="<?=$student_list['email']?>">
                        <input type="hidden" name="mobile" id="mobile" value="<?=$student_list['mobile']?>">
                        <input type="hidden" name="firstname" id="firstname" value="<?=$student_list['first_name']." ".$student_list['middle_name']." ".$student_list['last_name']?>">
                        <input type="hidden" name="c_year" id="c_year" value="<?=$student_list['current_year']?>">
                        <input type="hidden" name="stud_id" id="stud_id" value="<?=$student_list['stud_id']?>">
                        <input type="hidden" class="form-control" name="prn_no" id="prn_no" value="<?=$student_list['enrollment_no']?>">
                        <input type="hidden" class="form-control" name="org_frm" id="org_frm">
						
					<table class="table table-bordered">
						<td colspan="2" >
									
									      <div class="form-group">
									     <div class="col-sm-3">
									<strong>Hostel Deposit </strong> </div><div class="col-sm-3"><input class="form-control" type="text" name="fdeposit" id="fdeposit"  required></div></div>
									  <div class="form-group">
									       <div class="col-sm-3">
									<strong>Hostel Fees  </strong> </div><div class="col-sm-3"> <input class="form-control" type="text" name="fees" id="fees"  required><!--<span id="ffees"></span>--></div></div>
								 <div class="form-group">
								 <div class="col-sm-3">
									<strong>Enter Exempted fees </strong> </div><div class="col-sm-3"><input  class="form-control" type="text" name="exem" id="exem" onchange="show_exemfile()"  >
									</div></div>
									<div class="form-group">
										<div class="col-sm-3">
											<strong>Enter Gym fees </strong> 
										</div>
										<div class="col-sm-3">
											<input class="form-control" type="text" name="gym_fees" id="gym_fees">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-3">
											<strong>Enter Fine fees </strong> 
										</div>
										<div class="col-sm-3">
											<input class="form-control" type="text" name="pending_balance" id="pending_balance">
										</div>
									</div>
								    <div class="form-group">
										<div class="col-sm-3">
											<strong>Enter Opening Balance </strong> 
										</div>
										<div class="col-sm-3">
											<input class="form-control" type="text" name="opening_balance" id="opening_balance">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-3">
											<strong>Package </strong> 
										</div>
										<div class="col-sm-3">
											<select class="form-control" name="is_package" id="is_package">
												<option value="Regular">Regular</option>
												<option value="Package">Package</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-3">
											<strong>Remark </strong> 
										</div>
										<div class="col-sm-3">
											<textarea class="form-control" type="text" name="remark" id="remark"></textarea>
										</div>
									</div>
									<div id="exemdiv" style="display:none">	  <div class="form-group">
								 <div class="col-sm-3">	<strong>Document supporting Exemption in Fees</strong> </div><div class="col-sm-2">
									<input class="form-control" type="file" name="exemfile" id="exemfile"> </div> </div>
									    </div>
										
										
									    <div>
									    
									<div class="form-group">
								 <div class="col-sm-2"><input type="submit" class="btn btn-primary form-control"  value="Register" id="reg_11" name="reg">
									</div>	</div>	
							</td>
					</table>
				</div>
						
			  </form>		
			 </div>
				
			</div>
					<?php
					if(!empty($installment)){
					?>
                   
                   	  <div class="row">
							   <div class="form-group">
							       <hr>
							       <h4>Payment details</h4>
							   
							   
							   	  <table class="table table-bordered">
    					<tr>
    					  <th scope="col">Sr. No. </th>
    					  <th scope="col">Academic Year</th>
						  <th scope="col">Paid By</th>
    					  <th scope="col">Chq/DD No</th>
    					  <th scope="col">Rcpt No</th>
						  <th scope="col">Bank</th>
    					  <th scope="col">Branch</th>
						  <th scope="col">Dated</th>
						  <th scope="col">Amount</th>
						  
    					<!--  <th scope="col">Balance</th>
    					  
						  <th scope="col">Scan Copy</th>-->
						
    					</tr>
						<?php 
						$i=1;
						if(!empty($installment)){
							foreach($installment as $inst){
								$fee_date = date('d/m/Y',strtotime($inst['fees_date'] ));
						?>
    					<tr>
    					    <td><?=$i?></td>
    					    
    					    	<td><?=$inst['academic_year']?></td>
    					    	
							<td><?=$inst['fees_paid_type']?></td>
    						<td><?= isset($inst['receipt_no']) ? $inst['receipt_no'] : '' ?></td>
    							<td><?= $inst['college_receiptno']; ?></td>
							<td><?
							
							foreach ($bank_details as $branch) 
							{
							  if($branch['bank_id']==$inst['bank_id'])
							  {echo $branch['bank_name'];break;}
							}
							
							
							 ?></td>
    						<td><?= isset($inst['bank_city']) ? $inst['bank_city'] : '' ?></td>
							<td><?= isset($fee_date) ? $fee_date : '' ?></td>
    						<td><?=$inst['amt_paid']?></td>
    					
    					</tr>
						<?php
						$i++;
						
							}
						}else{
							echo "<tr><td colspan=8>No Data Found</td></tr>";
						}
						?>
    			
    				  </table>

							   
							   
							   
							   
							   
							   
							   
							   
							   
							 </div>                      
							  </div>
                    <?php
                    }
                    ?>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                 
      