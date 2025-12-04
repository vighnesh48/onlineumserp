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

$('.numbersOnly').keyup(function () {
		
		if (this.value != this.value.replace(/[^0-9]/g, '')) {
		   this.value = this.value.replace(/[^0-9]/g, '');
		} 
		});
	});
	
	
var student_id = '<?=$student_list['stud_id']?>';
var academic_year = '<?=$student_list['academic']?>';
var enrollment_no = '<?=$student_list['enrollment_no']?>';	
	//alert(student_id+"academic_year=="+academic_year+"enrollment_no=="+enrollment_no);
var boarding_fees=0;
	
	 $(document).ready(function(){
		 
		  $('#Rpoint').on('change', function () {
			 
			  var value=$(this).val();
			  var base_url = '<?=site_url()?>';
			  
			  $.ajax({'url': base_url + 'Transport/Rpoint',
			  'type' : 'POST',
			  'data' : {'Rpoint':value},
			   'success' : function(data){ 
			   $("#bpoint").html(data);
			   }
			   
		  })
			  
		  });
		
               $('#bpoint').on('change', function () {
       
             var base_url = '<?=site_url()?>';
                   // alert(type);
				   var bpoint = $(this).val();
                   var acyear = $("#hidacyear").val();
                    var fcid = $("#hidfacid").val();
					var prn = $("#prn").val();
					var org = $("#org").val();
					var stud_id = $("#stud_id").val();
					var admyr = $("#admyr").val();
					$("#prn_no").val(prn);
					//$("#org_frm").val(org);
					$("#ac_year").val(acyear);
					$("#fc_id").val(fcid);
					
					
                $.ajax({
                    'url' : base_url + 'Transport/facility_fee_details',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'acyear':acyear,'fcid':fcid,'bpoint':bpoint},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                      //  var container = $('#showhost'); //jquery selector (get element by id)
                        if(data){
							var jdata= JSON.parse(data);
							//alert(jdata);
							 if(jdata==null)
							{
								$('#showhost').hide();
								$('#showerr').html('For current academic year, Boarding fee has not declared yet.');
								$('#showerr').show();
							}
							 else
							 {
								$('#showhost').show();
								$('#tfee').show();
								if(admyr=='Full'){
									$("#ffees").html(jdata.fees);
									boarding_fees=jdata.fees;
								}else{
									$("#ffees").html(jdata.fees/2);
									boarding_fees=jdata.fees/2;
								}
								
								$("#actualfee").val(boarding_fees);
								$("#fmid").val(jdata.sffm_id);
                      
                            	//return false;
							 }
                        }
                          ///return false;
                    }
                });
            });
			
		
            });

	
	function validate()
	{
	      var base_url = '<?=site_url()?>';
                  
                 //  alert()
				
						 var exem = $("#exem").val();
					
						   //alert(gym_fees);alert(pending_balance);
						   
					if(exem!='' || exem!=0)
			    	 {
			    	    var efil = $("#exemfile").val(); 
						//alert(boarding_fees+'=='+exem);
						if(exem > boarding_fees)
			    	    {
			    	        alert("Exemption fee should be less than facility fee.");
			    	      return false;
			    	    }
			    	    else if(efil=='')
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
	

      	
			function show_exemfile()
			{
			   // alert("temp");
			    	 var exem = $("#exem").val();
			    	 //alert("temp"+exem);
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
	//echo '<pre>';print_r($student_list);
?>						
<input type="hidden" name="hidacyear" id="hidacyear" value="<?=$student_list['academic']?>">
<input type="hidden" name="hidfacid" id="hidfacid" value="2">
<input type="hidden" name="cyear" id="cyear" value="<?=$student_list['current_year']?>">
<input type="hidden" name="stud_id" id="stud_id" value="<?=$student_list['stud_id']?>">
<input type="hidden" name="fmid" id="fmid" value="">
						
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
						  <td><?=$student_list['course_short_name']?> - <?=$student_list['stream_short_name']?></td>
						  <th width="18%">Current Year :</th>
						  <td><?=$student_list['current_year']?></td>
						</tr>
						<tr>
						  <th width="18%">Academic Year:</th>
						  <td><?=$student_list['academic']?></td>
						  <th width="18%">Admission Year:</th>
						  <td><?=$student_list['admission_session']?></td>
						</tr>
						</table>
                        <table class="table table-bordered">
    					<tr>
    					<th width="20%">Local Address</th>
                        <td><?php if($Local_Address['address']==''){echo 'Not Update';}else{ echo $Local_Address['address'];} ?><?php if($Local_Address['taluka_name']==''){}else{?>&nbsp;<strong>City</strong>&nbsp;<?php echo $Local_Address['taluka_name']; } ?></td>
    					   </tr><tr>
                        <th width="20%">Perment Address</th>
                        <td><?php if($PERMNT_Address['address']==''){echo 'Not Update';}else{ echo $PERMNT_Address['address'];} ?><?php if($PERMNT_Address['taluka_name']==''){}else{?>&nbsp;<strong>City</strong>&nbsp;<?php echo $PERMNT_Address['taluka_name']; } ?></td>
                           </tr>
                           </table>
                        
						
				<?php //var_dump($stud_faci_details);
			if(!empty($stud_faci_details)){
				?>
				<table class="table table-bordered">
    					<tr>
    					  <th width="15%">Academic Year</th>
    					 
    					   <th scope="col">Actual </th>
    					  <th scope="col">Exepmted </th>
						  <th scope="col">Applicable </th>
						  <th scope="col">Amount Paid</th>
    					  <th scope="col"> Balance</th>
    					 
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
    						
    							<td><?= isset($student_faci_details['actual_fees']) ? $student_faci_details['actual_fees'] : '' ?></td>
    							<td><?= isset($student_faci_details['excemption_fees']) ? $student_faci_details['excemption_fees'] : '' ?> 
    							<?php if(strlen($student_faci_details['excem_doc_path'])>10){?>
    							<a href="<?=base_url()?>uploads/Hostel/exepmted_fees/<?=$student_faci_details['excem_doc_path']?>" class="pull-right" target="_blank"><i class="fa fa-sticky-note-o" style="font-size:24px"></i></a>
    						<?php	}?></td>
							<td><?=$applicable_fee?></td>
    					   
    						
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
						
							
							<?php if($student_list['opted']=="YES"){
									?>
									<div class="row ">
							
						<div class="col-sm-12">
						<!--
							<div class="col-sm-3"><strong>Opted Hostel Facility :</strong></div>
									<div class="col-sm-1"><?php echo "Yes";?> </div>
									-->
									<div class="col-sm-4">
									<a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=site_url()?>Transport/view_std_payment/<?=$student_list['enrollment_no']?>/<?=$student_list['stud_id']?>/<?=$student_list['organisation']?>/<?=$student_list['academic']?>">View Payment Details </a>
									</div>
									
									
									<div class="col-sm-3">
									<!--a class="btn btn-primary btn-labeled" style="display:none;" id="deallocate"  title="Click here to De-allocate Room">De-allocate</a-->	
									</div>	

									</div>
						</div>
									<?php
									
									} 
									else
									{
									?>
									
					<form id="exemform" name="exemform" method="post" action="<?=base_url()?>Transport/register_for_facility" enctype="multipart/form-data" onsubmit="return validate();">
                        <input type="hidden" name="hidac_year" id="hidac_year" value="<?=$student_list['academic']?>">
                        <input type="hidden" name="ac_year" id="ac_year">
                        <input type="hidden" name="fc_id" id="fc_id">
						<input type="hidden" name="actualfee" id="actualfee">
                        <input type="hidden" name="hidfac_id" id="hidfac_id" value="2">
                        <input type="hidden" name="c_year" id="c_year" value="<?=$student_list['current_year']?>">
                        <input type="hidden" name="stud_id" id="stud_id" value="<?=$student_list['stud_id']?>">
                        <input type="hidden" class="form-control" name="prn_no" id="prn_no">
                        <input type="hidden" class="form-control" name="org_frm" id="org_frm" value="<?=$student_list['organisation']?>">
						
					<table class="table table-bordered">
						<td colspan="2" >	 
									<div id="showhost" name="showhost" >
                                    <div class="form-group">
									     <div class="col-sm-3">
									<strong>Admission Type </strong> </div>
									<div class="col-sm-2">
                                    <select class="form-control" name="admission_type" id="admyr" required>
                                      <option value="Full">Full Year</option>
                                      <option value="Half">Half Year</option>
                                  </select><br></div></div>
                                    <div class="form-group">
									     <div class="col-sm-3">
									<strong>Select Route </strong> </div>
									<div class="col-sm-2">
                                    <select class="form-control" name="Rpoint" id="Rpoint" required>
                                      <option value="">Route Point</option>
                                      <?php //echo "state".$state;exit();
                                        if(!empty($route_details)){
                                            foreach($route_details as $point){
                                                ?>
                                              <option value="<?=$point['route_id']?>"><?=$point['route_name']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
                                  </select><br></div></div>
                                    
                                    
									      <div class="form-group">
									     <div class="col-sm-3">
									<strong>Boarding Point </strong> </div><div class="col-sm-2"><select class="form-control" name="bpoint" id="bpoint" required>
                                      <option value="">Boarding Point</option>
                                      <?php //echo "state".$state;exit();
                                        if(!empty($boarding_details)){
                                            foreach($boarding_details as $point){
                                                ?>
                                              <option value="<?=$point['board_id']?>"><?=$point['boarding_point']?></option>  
                                            <?php 
                                                
                                            }
                                        }
                                      ?>
                                  </select><br></div></div>
									  <div class="form-group" id="tfee" style="display:none;">
									       <div class="col-sm-2">
									<strong>Transport Fees  </strong> </div><div class="col-sm-2"><span id="ffees"> </span><br></div></div>
								 <div class="form-group">
								 <div class="col-sm-2">
									<strong>Enter Exempted fees </strong> </div><div class="col-sm-2"><input class="numbersOnly form-control" type="text" name="exem" id="exem" onblur="show_exemfile()"  ><br>
									</div></div>
									
									<div id="exemdiv" style="display:none">	  <div class="form-group">
								 <div class="col-sm-2">	<strong>Document supporting Exemption in Fees</strong> </div><div class="col-sm-5">
									<input type="file" class="form-control" name="exemfile" id="exemfile"><br> </div> </div>
									    </div>
										
										
									    <div>
									    
									<div class="form-group">
								 <div class="col-sm-2"><input type="submit" class="btn btn-primary form-control"  value="Register" id="reg_11" name="reg">
									</div>	</div>	
									</div>
									
							</div>
							<span class="col-sm-12" id="showerr" style="color:red;display:none"></span>
						</td>
					</table>
					</form>
									
									<?php
									}
									
									?>
							
					
						
						
						
						<!--<form id="form1" name="form1" enctype="multipart/form-data" action="<?=base_url($currentModule.'/search_student')?>" method="POST">-->
                       <div class="row">
					 
							<!--  <div class="col-sm-1"></div>
							  <div class="col-sm-3"><input type="text" class="form-control" name="prn" id="prn" placeholder="Enter Student PRN No."></div><label class="col-sm-1"></label>
							  <div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="button" >Search</button></div>
							   <div class="col-sm-6"></div>
						-->
							  
							  
							 
							  <div class="row">
							   <div class="form-group">
							   <div class="col-sm-3"></div>
							   <div class="col-sm-6">
							   <?php 
							   echo "<span style='color:red;padding-left:110px;'>".@$this->session->flashdata('message1')."</span>";
							   ?>
							   </div>
							 </div>                      
							  </div>
							 <!-- </form>-->
						</div>
                
				
					
					<?php
					if(!empty($installment)){
					?>
                   
                   	  <div class="row">
							   <div class="form-group">
							       <hr>
							       <h4>Previous Years Payment details</h4>
							   
							   
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
                    
                    
                    
                    
                    
                    
                    
                    
                    
                 
      