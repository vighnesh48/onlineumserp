<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
.panel-heading {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc;
}

    .table {
    width: 100%!important;
}
table {
    max-width: 100%!important;
}
    

</style>

<script>
function feevalidate()
{
    //alert("jugal");
 //   return false;
    
        var base_url = '<?=base_url();?>';
                   // alert(type);
                   var clreceipt = $("#clreceipt").val();
    
                $.ajax({
                    'url' : base_url + '/Ums_admission/validate_receipt',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'clreceipt':clreceipt},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                    //    var container = $('#stddata'); //jquery selector (get element by id)
                        if(data){
                          alert(data);
                          if(data.trim()!='')  
                          {
                             alert("Receipt Number Should be Unique"); 
                              e.preventDefault();
                             return false;
                          }
                          else
                          {
                              $('#makePayment').submit();
                          }
                          
                        //  alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                           // container.html(data);
                            
                        }
                       
                    }
                });
                
                 e.preventDefault();
        return false;
    
  //  alert("out");
    
  // return false;
    
    
    
    
    
    
    
    
    
}

</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Payment Details</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Make Payment</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
     		<span id="flash-messages" style="color:Green;padding-left:210px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Payment Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">   
						<table class="table table-bordered">
    					<tr>
    					  <th width="25%">PRN No :</th><td><?=$emp[0]['enrollment_no']?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name :</th><td><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></td>
						</tr>
						<tr>
    					  <th scope="col">Course Name :</th><td><?=$emp[0]['stream_name']?></td>
    					</tr>
						</table>
    				    <table class="table table-bordered">
    					<tr>
    					  <th scope="col">Academic Year</th>
    					  <th scope="col">Exam session</th>
    					  	  <th scope="col">Exam Fees</th>
    					  	   <th scope="col">Late Fees/Fine</th>
    					  <th scope="col">Exam Fees Paid</th>
    					 
    					  <th scope="col">Late Fees/Fine Paid</th>
    					  <th scope="col">Total Paid</th>
    					  <th scope="col">Total Pending</th>
    					 <th scope="col">Action</th>
    				
    					</tr>
    				<?php
    			//var_dump($get_feedetails);
    					foreach($get_feedetails as $inst){
							$ext = $inst['exam_name']."( ".$inst['exam_type'].")";
    				?>
    					<tr>
						
    						<td><?=$inst['exam_year']?></td>
    						<td><?=$inst['exam_name']."( ".$inst['exam_type'].")"?></td>
    							<td><?=$inst['exam_fees']?></td>
    								<td><?=$inst['late_fees']?></td>
    						<td><?=$inst['totfeepaid']?></td>
    					
    						<td><?=$inst['tot_fine']?></td>
    							<td><?=$inst['totfeepaid']+$inst['tot_fine']?></td>
    								<td><?=$inst['exam_fees'] + $inst['late_fees'] -($inst['totfeepaid']+$inst['tot_fine'])?></td>
    						<td> <a class="marksat" id="editpayment" data-late_fee="<?=$inst['late_fees']?>"  data-academic_year="<?= $inst['academic_year']; ?>" val="<?=$i?>" 
    						data-stud_id="<?=$studId; ?>" data-exam_fee="<?= $inst['exam_fees']; ?>" data-exam="<?= $ext; ?>" data-exam_id="<?= $inst['exam_id']; ?>" data-applicable_fee="<?= $inst['exam_session']; ?>" data-toggle="modal" data-target="#walkinModal" style="cursor:pointer"><button class="btn btn-primary btn-xs">Edit</button></a>
    					</td>
    					
    							   
    					</tr>
    					<?php
    					}
    					?>
    						
    				  </table>	
					  </div>
					  </div>
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  
					  <div class="panel">
					  <div class="panel-heading">
                        <span class="panel-title">Fees paid Details</span>
						</div>
						<div class="panel-body">
					  <table class="table table-bordered">
    					<tr>
    					  <th scope="col">Sr. No. </th>
						  <th scope="col">Paid By</th>
    					  <th scope="col">Chq/DD No</th>
    					  <th scope="col">Rcpt No</th>
						  <th scope="col">Bank</th>
    					  <th scope="col">Branch</th>
						  <th scope="col">Dated</th>
						  <th scope="col">Amount</th>
						  <th scope="col">Can Charges</th>
						  <th scope="col">Late/Fine</th>
						  <th scope="col">Status</th>
    					<!--  <th scope="col">Balance</th>
    					  
						  <th scope="col">Scan Copy</th>-->
						
						   <th scope="col">Action</th>
    					</tr>
						<?php 
						$i=1;
						if(!empty($installment)){
							foreach($installment as $inst){
								$fee_date = date('d/m/Y',strtotime($inst['fees_date'] ));
						?>
    					<tr>
    					    <td><?=$i?></td>
    					    
							<td><?=$inst['fees_paid_type']?></td>
    						<td><?= isset($inst['receipt_no']) ? $inst['receipt_no'] : '' ?></td>
    							<td><?= $inst['college_receiptno']; ?></td>
							<td><?= $inst['bank_name']; ?></td>
    						<td><?= isset($inst['bank_city']) ? $inst['bank_city'] : '' ?></td>
							<td><?= isset($fee_date) ? $fee_date : '' ?></td>
    						<td><?=$inst['amt_paid']?></td>
    							<td><?=$inst['canc_charges']?></td>
    								<td><?=$inst['exam_fee_fine']?></td>
    						<td><?php if($inst['chq_cancelled']=='N'){echo "Accepted";}else{echo "Cancelled";}?></td>
    	
						<!--	<td><?=$inst['balance_fees']?></td>-->
							
    						
						<!--	<td>
							<?php 
							if(!empty($inst['receipt_file'])){
								?>
								<a href="<?=base_url()?>uploads/student_challans/<?=$inst['receipt_file']?>" target="_blank">View</a>
							<?php }else{
								echo "No";
							}?>
							</td>-->
	<td><!--<i class="fa fa-edit"></i>--><input type="button" value="Edit" name="<?=$inst['fees_id']?>" id="editp" onclick="valid('<?=$inst['fees_id']?>')" class="btn btn-sm btn-primary">
	<?php
//	if($i>1){
	?>
<!--	<i class="fa fa-eye"></i>-->
	<input type="button" value="Del" name="<?=$inst['fees_id']?>" id="delete" onclick="delete_record('<?=$inst['fees_id']?>')" class="btn btn-sm  btn-primary">
	<?php
					//		}
	?>
	</td>
    					</tr>
						<?php
						$i++;
						
							}
						}else{
							echo "<tr><td colspan=8>No Data Found</td></tr>";
						}
						?>
    					<tr>
						<?php
						/*
						if((!empty($minbalance[0]['min_balance']) && $minbalance[0]['min_balance'] > 0)){
						if((empty($minbalance[0]['min_balance']) || //$minbalance[0]['min_balance'] > 0))
							*/{
							?>	
							<td colspan="11" align="center"><input type="button" name="make Payment" id="pmnt" value="Make Payment" class="btn btn-primary" /></td>
    				<!--/*	<?php }?>	*/-->
    						
    					</tr>	
    				  </table>

                        </div>
                    </div>
                    
                    
                    <script>
                   function delete_record(feeid) 
                   {

    if(confirm("Are you sure you want to delete this transaction ?") == true) {
       // txt = "You pressed OK!";
        
    } 
    else
    {
        return false;
    }

   var base_url = '<?=base_url();?>';
 $.ajax({
                    'url' : base_url + '/Account/delete_fees',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'feeid':feeid},
                    'success' : function(data){ 
                     
                        alert("Fees transaction deleted successfully");
                          //  container.html(data);
                          location.reload(); 
                            	return false;
                     
                    }
                });
                   }
                    
                    </script>
                    
                    
										  <!------------------------------------------------------------------------------------------------------------------------------>
					  <div class="panel" id="makepmnt" style="display:none">
                            <div class="panel-heading">
							<?php
							$dpay='';
							if($emp[0]['course_id']==2 ||$emp[0]['course_id']==8 ||$emp[0]['course_id']==10 ||$emp[0]['course_id']==12 ||$emp[0]['course_id']==5 ||$emp[0]['course_id']==19 )
							{
									$dpay=2500;
							}
							else if($emp[0]['course_id']==13 ||$emp[0]['course_id']==6 ||$emp[0]['course_id']==7 ||$emp[0]['course_id']==4 ||$emp[0]['course_id']==11 ||$emp[0]['course_id']==9 ||$emp[0]['course_id']==14 )
							{
								$dpay=2000;
							}
							else{
								$dpay=3000;
							}
							?>
	<span class="panel-title">Make Payment: <span style="color:red">For Exam Session > <?=$exam_session['exam_name']." ".$exam_session['exam_type']?></span></span>
							</div>
                                <div class="panel-body">
								<form name="makePayment" id="makePayment" onsubmit="" method="POST" action="<?=base_url()?>Account/pay_exam_fee" enctype="multipart/form-data">
								<input type="hidden" name="esession" value="<?=$exam_session['exam_id']?>" id="esession" >
								<?php
									$studId = $this->uri->segment(3);
								?>
								
								            <div class="form-group">
                                    <label class="col-sm-3">Exam Session</label>
                                    <div class="col-sm-3">
                                     <!-- <input type="text" id="dd_bank" name="dd_bank" class="form-control" value="<?= isset($fee[0]['dd_drawn_bank_branch']) ? $fee[0]['dd_drawn_bank_branch'] : '' ?>" placeholder="Bank & Branch">-->

									<select name="exam_session" id="exam_session" class="form-control" required>
									  <option value="">Select Exam Session</option>
									  <?php
										foreach ($exam_session as $branch) {
										  
											echo '<option value="' . $branch['exam_id'] . '" ' . $sel . '>' . $branch['exam_name'].'>'.$branch['exam_type']. '</option>';
										}
										?>
								   </select>

                                    </div></div>
								
								
                                  <div class="form-group">
                                    <label class="col-sm-3">Payment of Rs</label>
                                    <div class="col-sm-3">
                                      <input data-bv-field="paidfee" id="paidfee" name="paidfee" class="form-control numbersOnly" value="<?=$dpay?>" placeholder="Paid Fee" type="text" required>
									  <input type="hidden" name="no_of_installment" value="<?= isset($noofinst[0]['max_no_installment']) ? $noofinst[0]['max_no_installment'] : '' ?>">
									  <input type="hidden" name="stud_id" value="<?=$studId?>">
									  <input type="hidden" name="min_balance" value="<?= isset($minbalance[0]['min_balance']) ? $minbalance[0]['min_balance'] : '' ?>">
                                    </div>
                                    <label class="col-sm-3">Payment Type</label>
                                    <div class="col-sm-3">
                                    <select name="payment_type" id="payment_type" class="form-control" required>
                                        <option value="">Select Payment Type</option>
									<option value="CHQ">Cheque</option>
									<option value="DD">DD</option>
									<option value="CHLN">Chalan</option>
										<option value="POS">POS</option>
									</select>
									
									
                                    </div>
                                  </div>
                                  <div class="form-group">
								  <input type="hidden" name="actfee" value="<?= isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '' ?>">
								   <label class="col-sm-3"> Cheque/DD No./Chalan No.</label>
                                    <div class="col-sm-3">
                                      <input type="text" name="dd_no" class="form-control" required value="<?= isset($fee[0]['dd_no']) ? $fee[0]['dd_no'] : '' ?>" placeholder="Cheque/DD No./Chalan No" required>
                                    </div>
									
                                    <label class="col-sm-3">Dated</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker20" name="dd_date"  value="<?= isset($fee[0]['dd_drawn_date']) ? $fee[0]['dd_drawn_date'] : '' ?>" placeholder="DD Date" required />
                                    </div>
                                    
                                    <div class="col-sm-6">
                                      
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">Bank name</label>
                                    <div class="col-sm-3">
                                     <!-- <input type="text" id="dd_bank" name="dd_bank" class="form-control" value="<?= isset($fee[0]['dd_drawn_bank_branch']) ? $fee[0]['dd_drawn_bank_branch'] : '' ?>" placeholder="Bank & Branch">-->

									<select name="dd_bank" id="dd_bank" class="form-control" required>
									  <option value="">Select</option>
									  <?php
										foreach ($bank_details as $branch) {
										  
											echo '<option value="' . $branch['bank_id'] . '" ' . $sel . '>' . $branch['bank_name'] . '</option>';
										}
										?>
								   </select>

                                    </div>
                                    <label class="col-sm-3"> Branch Name.</label>
                                    <div class="col-sm-3">
                                      <input type="text" id="dd_bank_branch" name="dd_bank_branch" class="form-control" value="" placeholder="Branch Name" required>
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
								   <label class="col-sm-3">Upload document</label>
                                    <div class="col-sm-3"><input type="file" name="payfile"></div>
                                     <label class="col-sm-3">College Receipt Number</label>
                                    <div class="col-sm-3">
                                          <input type="text" id="clreceipt" name="clreceipt" class="form-control" value="" placeholder="College Receipt Number" required>
                                    </div>
                                  </div>
                                  
                                    <div class="form-group">
                                        
                                          <label class="col-sm-3">Fine If Any</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control numbersOnly" id="ffine" name="ffine"  value=""  />
                                    </div>
								       <label class="col-sm-3">Remark</label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control" id="remark" name="remark"></textarea>
                                    </div>
                                    </div>
								  <div class="form-group">
								      
								      
								   <label class="col-sm-6"></label> 
                                    <div class="col-sm-6"><button type="submit" name="Make_Payment" value="Make Payment" class="btn btn-primary">Make Payment</button>
                                    </div>
                                  </div>
                                  </form>
                                </div>
                            </div>
                            
                            
                            
                            
                            <div id="edit_fee">
                                
                                
                                </div>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                         </div>
						 <!------------------------------------------------------------------------------------------------------------------------------------------------->

                </div>
            </div>    
        </div>
    </div>
</div>

<div class="modal fade" id="walkinModal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                
                <h4 class="modal-title" id="myModalLabel">
                   <span id="fform_id">Edit Exam Fees</span>
                </h4>
            </div>
            


  <div class="modal-body">
                <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked" style="margin-top: 10px;">
                                    <div class="panel-body">
                                        <form name="editfrm" method="POST" action="<?=base_url()?>Account/updateExamfee" enctype="multipart/form-data" onsubmit="">
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1"> </label>
                                             <div class="col-sm-6"> 
                                             <label name="facdamicfee" id="facdamicfee"></label>
                                                
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Exam Session </label>
                                             <div class="col-sm-6"> 
                                                <label name="exam_sess" id="exam_sess"></label>
                                                <input type="hidden" name="fstud_id" class="form-control" id="fstud_id" style="width:50%"/>
                                                
    									        <input type="hidden" name="student_id" value="<?=$studId?>">
    									        <input type="hidden" name="acad_year" id="acad_year" >
    									         <input type="hidden" name="eid" id="eid" >

                                            </div>
                                        </div>  
                                

								   <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Examination Fees </label>
                                             <div class="col-sm-6">
                                             
                                                <input type="text" name="exam_fees" id="exam_fees" class="form-control" value="" required /> 
                                            </div>
                                        </div>
										
										
                                         
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Late Fees / Fine</label>
                                             <div class="col-sm-6">
                                             
                                                <input type="text" name="late_fees" id="late_fees" class="form-control" value="" required /> 
                                            </div>
                                        </div>
   
                                          <button type="submit" class="btn btn-primary" id="updatePayment1" >Submit</button>
                                          <button type="button" class="btn btn-default"
                                                data-dismiss="modal">
                                                    Close
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                
            </div>
            
             </div>
    </div>
</div>     
            
            
<script>
     
	 
	 
	 $(document).on("click", '#editpayment', function () {
   // var ye = $(this).value();
     //var va = $(this).attr('val');
    //alert(va);
        var stud_id = $('#editpayment').attr("data-stud_id");
        //var exam_fee = $('#editpayment').attr("data-applicable_fee");
      //  var academic_year = $('#editpayment').attr("data-academic_year");
        var academic_year = $(this).attr("data-academic_year");
        var exam_fee = $(this).attr("data-exam_fee");
		 var late_fee = $(this).attr("data-late_fee");
		var examname = $(this).attr("data-exam");
            var exam_session = $(this).attr("data-exam_session");
		 var eid = $(this).attr("data-exam_id");	
		
	//	alert(examname);
        if(stud_id !=''){
			document.getElementById("fstud_id").value = parseInt(stud_id);
		}
		
		     if(eid !=''){
		        	$("#eid").val(parseInt(eid)); 
		
		}
		
		
        if(examname !=''){
			$("#exam_sess").html(examname);
		}
        if(exam_fee !=''){
			$("#exam_fees").val(parseInt(exam_fee));
		}
	
		if(late_fee !=''){
			$("#late_fees").val(parseInt(late_fee));
			
		}
		if(academic_year !=''){
			$("#facdamicfee").html(parseInt(academic_year));
			
		}

    });	
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
var base_url = '<?=base_url();?>';

   // $('#editp').on('click', function () {
        function valid(feeid)
        {
      //  var feeid = $(this).attr('name');
   var controller = 'Account';
           
            $('#pmnt').prop('disabled', true);
            
	          $.ajax({
                    'url' : base_url + '/' + controller + '/edit_exam_fdetails',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'feeid' : feeid},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#edit_fee'); //jquery selector (get element by id)
                        if(data){
							//alert(data);
							//alert("Marks should be less than maximum marks");
							//$("#"+type).val('');
                            container.html(data);
                        }
                    }
                });
		
//	});
}








    $('#pmnt').on('click', function () {
        
		$("#makepmnt").show();
	});
    // Num check logic
  	$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
	    $('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	      $('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	       $('#doc-sub-datepicker41').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	        $('#doc-sub-datepicker42').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	</script>