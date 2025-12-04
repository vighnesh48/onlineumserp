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
</style>

<script>
function feevalidate()
{
    //alert("jugal");
 //   return false;
    
        var base_url = 'https://erp.sandipuniversity.com/';
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
    					  <th width="25%">PRN No :</th><td><?=$std_det['prov_reg_no']?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name :</th><td><?=$std_det['student_name']?></td>
						</tr>
						<tr>
    					  <th scope="col">Course Name :</th><td><?=$std_det['sprogramm_acro']?></td>
    					</tr>
    						<tr>
    					  <th scope="col">Admission Year :</th><td><?=$std_det['admission_year']?></td>
    					</tr>
    					
    						<tr>
    			
    					
						</table>
						
						    		<table class="table table-bordered">
                         <tbody><tr><th>Actual Fees</th><th>Scholarship</th><th>Applicable Fees</th><th>Fees Paid</th> <th>Fees Pending</th> </tr>
                               <tr><td><?=$std_det['actual_fees']?></td><td><span id="espan"><?=$std_det['exemption_fees']?></span></td>
                            
                               <td> <span id="aspan"><?=$std_det['applicable_fees']?></span></td>  <td><?=$total_paid?></td>  <td><?=$std_det['applicable_fees']-$total_paid?></td></tr>
                         </tbody></table>
    				
					  </div>
					  </div>
					  
					  <?php
					 /* if($adm_det['enrollment_no']!='')
					  {
					      echo "<span style='color:green;font-weight:bold'>Student Admission is confirmed by student section. Please use regular admission screen for payment</span>";
					  }
					  else
					  {*/
					  ?>
					  <div class="panel">
					  <div class="panel-heading">
                        <span class="panel-title">Fees paid Details</span>
						</div>
						<div class="panel-body">
					  <table class="table table-bordered">
    					<tr>
    					  <th scope="col">Sr. No. </th>
    					    <th scope="col">Academic Year </th>
						  <th scope="col">Paid By</th>
    					  <th scope="col">Chq/DD No</th>
    					  <th scope="col">Rcpt No</th>
						  <th scope="col">Bank</th>
    					  <th scope="col">Branch</th>
						  <th scope="col">Dated</th>
						  <th scope="col">Amount</th>
					
						  <th scope="col">Status</th>
    					<!--  <th scope="col">Balance</th>
    					  
						  <th scope="col">Scan Copy</th>-->
						
						   <th scope="col">Action</th>
    					</tr>
						<?php 
						$i=1;
						 $j=1;
						// echo "<pre>";
						 //print_r($installment);
						if(!empty($installment)){
							foreach($installment as $inst){
								$fee_date = date('d/m/Y',strtotime($inst['fees_date'] ));
						?>
    					<tr>
    					    <td><?=$i?></td>
    					    	<td><div style="color:red"><?=$inst['academic_year']?></div></td>
							<td><?=$inst['fees_paid_type']?></td>
    						<td><?= isset($inst['receipt_no']) ? $inst['receipt_no'] : '' ?></td>
    							<td><?= $inst['college_receiptno']; ?></td>
								<td><?php if($inst['fees_paid_type']=="CHLN"){echo $inst['ubname'];} else{ echo $inst['bank_name'];}; ?></td>
    						<td><?= isset($inst['bank_city']) ? $inst['bank_city'] : '' ?></td>
							<td><?= isset($inst['fees_date']) ? $inst['fees_date'] : '' ?></td>
    						<td><?=$inst['amount']?></td>
    					
    						<td><?php if($inst['payment_status']=='V'){echo "Verified";
    					?>
    			
    					<?php
    						
    						}else{echo "Pending";}?></td>
    	
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
	<td><!--<i class="fa fa-edit"></i>-->
	<?php if($inst['payment_status']=='V'){
	    ?>
	    
	    	<a href="<?=base_url($currentModule."/generate_payment_receipt/".$inst['fees_id'])?>" title="View" target="_blank">
               <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i></a> |  <i class="fa fa-pencil-square-o" style="font-size:20px;color:green;cursor:pointer;" id="<?=$inst['fees_id']?>" onclick="edit_payment(this.id)"name="<?=$inst['fees_id']?>" title="Edit"></i>      
	    
<?php
	}
	else
	{
?>
 <i class="fa fa-pencil-square-o" style="font-size:20px;color:green;cursor:pointer;" id="<?=$inst['fees_id']?>" onclick="edit_payment(this.id)"name="<?=$inst['fees_id']?>" title="Edit"></i>      
	    
<!--<input type="button" value="Edit" name="<?=$inst['fees_id']?>" id="editp1" onclick="valid('<?=$inst['fees_id']?>')" class="btn btn-primary">-->
<?php
	}
	?>
	<?php
//	if($i>1){
	?>
<!--	<i class="fa fa-eye"></i>-->
<!--	<input type="button" value="Del" name="<?=$inst['fees_id']?>" id="delete" onclick="delete_record('<?=$inst['fees_id']?>')" class="btn btn-primary">-->
	<?php
					//		}
	?>
	</td>
    					</tr>
						<?php
						$i++;
						$j++;
							}
							
							
							
							
							
							 
    					  for($i=0;$i<count($get_refunds);$i++)
    					     {
						        ?>
						 <tr style="background: #d2c47d;">
						   
							<td><?=$j?></td>
    						<td><?=$get_refunds[$i]['refund_paid_type']?></td>
							<td><?= isset($get_refunds[$i]['receipt_no']) ? $get_refunds[$i]['receipt_no'] : '' ?></td>
									<td><?= $get_refunds[$i]['college_receiptno']; ?></td>
							<td><?= $get_refunds[$i]['bank_name']; ?></td>
							<td><?= isset($get_refunds[$i]['bank_city']) ? $get_refunds[$i]['bank_city'] : '' ?></td>
							
						
							
    						<td><?php if($get_refunds[$i]['refund_date']!=''){echo date('d-m-Y', strtotime($get_refunds[$i]['refund_date']));}?></td>
    						
    					
    						<td><?= isset($get_refunds[$i]['amount']) ? $get_refunds[$i]['amount'] : '' ?></td>
    							<td></td>
							<td>Refund</td>
    					</tr>
    				<?php
    					 $j++;    }
							
							
							
							
							
							
							
							
							
							
							
							
							
							
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
                    
                    <?php
				//	  }
                    ?>
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


 $.ajax({
                    'url' : base_url + '/Ums_admission/delete_fees',
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
								<span class="panel-title">Make Payment</span>
							</div>
                                <div class="panel-body">
								<form name="makePayment" id="makePayment" onsubmit="" method="POST" action="<?=base_url()?>Provisional_admission/add_payment" enctype="multipart/form-data">
								<?php
									$studId = $this->uri->segment(3);
								?>
								 <div class="form-group">
                                    <label class="col-sm-3"> Academic Year</label>
                                     <div class="col-sm-3">
                                    <select name="acyear" id="acyear" class="form-control" >
                    
							<option value="2019" selected>2019-20</option>
									<option value="2018" selected>2018-19</option>
                  
								
									
									</select>
									
									
                                    </div>
                                    
                                    </div>
                                        
                                  <div class="form-group">
                                    <label class="col-sm-3">Payment of Rs</label>
                                    <div class="col-sm-3">
                                      <input data-bv-field="paidfee" id="paidfee" name="paidfee" class="form-control numbersOnly" value="" placeholder="Paid Fee" type="text" required>
									  <input type="hidden" name="no_of_installment" value="<?= isset($noofinst[0]['max_no_installment']) ? $noofinst[0]['max_no_installment'] : '' ?>">
										  <input type="hidden" name="sid" value="<?=$std_det['adm_id']?>">
									      <input type="hidden" name="prov_no1" value="<?=$std_det['prov_reg_no']?>">
									  <input type="hidden" name="acye" value="<?=$acye?>">
									  <input type="hidden" name="min_balance" value="<?= isset($minbalance[0]['min_balance']) ? $minbalance[0]['min_balance'] : '' ?>">
                                    </div>
                                    <label class="col-sm-3">Payment Type</label>
                                    <div class="col-sm-3">
                                    <select name="payment_type" id="payment_type" class="form-control" >
                                        <option value="">Select Payment Type</option>
									<option value="CHQ">Cheque</option>
									<option value="DD">DD</option>
									<option value="CHLN">Challan</option>
									
										<option value="ITF">Internal Transfer</option>
											<option value="POS">POS</option>
											<option value="PG">PG </option>	
										<option value="OL">OL </option>	
									</select>
									
									
                                    </div>
                                  </div>
                                  <div class="form-group">
								  <input type="hidden" name="actfee" value="<?= isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '' ?>">
								   <label class="col-sm-3"> Cheque/DD No./Challan No.</label>
                                    <div class="col-sm-3">
                                      <input type="text" name="dd_no" class="form-control"  value="<?= isset($fee[0]['dd_no']) ? $fee[0]['dd_no'] : '' ?>" placeholder="Cheque/DD No./Challan No" >
                                    </div>
									
                                    <label class="col-sm-3">Dated</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker20" name="dd_date" required value="<?= isset($fee[0]['dd_drawn_date']) ? $fee[0]['dd_drawn_date'] : '' ?>" placeholder="DD Date" required readonly="true"/>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                      
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">Bank name</label>
                                    <div class="col-sm-3">
                                     <!-- <input type="text" id="dd_bank" name="dd_bank" class="form-control" value="<?= isset($fee[0]['dd_drawn_bank_branch']) ? $fee[0]['dd_drawn_bank_branch'] : '' ?>" placeholder="Bank & Branch">-->

									<select name="dd_bank" id="dd_bank" class="form-control">
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
                                      <input type="text" id="dd_bank_branch" name="dd_bank_branch" class="form-control" value="" placeholder="Branch Name" >
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
                                       
								       <label class="col-sm-3">Remark</label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control" id="remark" name="remark"></textarea>
                                    </div>
                                    </div>
								  <div class="form-group">
								      
								      
								   <label class="col-sm-5"></label> 
								   <div class="col-sm-1">
                                     <button type="button" name="Cancel" id="cbutton2" value="Cancel" class="btn btn-primary">Cancel</button>
                                    </div>
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
                <!-- Modal -->
<div class="modal fade" id="walkinModal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                
                <h4 class="modal-title" id="myModalLabel">
                   <span id="fform_id">Edit Payments</span>
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked" style="margin-top: 10px;">
                                    <div class="panel-body">
                                        <form name="editfrm" method="POST" action="<?=base_url()?>Ums_admission/updateAdmPayment" enctype="multipart/form-data" onsubmit="return validate()">
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Academic Fee </label>
                                             <div class="col-sm-6"> 
                                             <label name="facdamicfee" id="facdamicfee"></label>
                                                
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Actual Fees </label>
                                             <div class="col-sm-6"> 
                                                <label name="fgym_fees" id="fgym_fees"></label>
                                                <input type="hidden" name="fstud_id" class="form-control" id="fstud_id" style="width:50%"/>
                                                
    									        <input type="hidden" name="student_id" value="<?=$studId?>">
    									        <input type="hidden" name="acad_year" id="acad_year" >

                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Exempted fees </label>
                                             <div class="col-sm-6"> 
                                             <label name="exem" id="exem"></label>
                                                
                                            </div>
                                        </div> 

                                         
                                        <div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Opening Balance </label>
                                             <div class="col-sm-6">
                                             
                                                <input type="text" name="fopening_balance" id="fopening_balance" class="form-control" value="" required /> 
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
            
            <!-- Modal Footer 
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" class="btn btn-primary">
                    Save changes
                </button>
            </div>-->
        </div>
    </div>
</div>
<!-- model end-->

</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
     
 var base_url = '<?php echo site_url(); ?>';

    //$('#editp').on('click', function () {
        function edit_payment(feeid)
        {
        //var feeid =  $('#editp').attr('name');
		//alert(feeid);
   var controller = 'Provisional_admission';
           
            $('#pmnt').prop('disabled', true);
            
	          $.ajax({
                    'url' : base_url + '/' + controller + '/edit_fdetails',
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
//});




   $('#generate_receipt').on('click', function () {
        
        if(confirm("Are you sure you want to generate receipt Number ?") == true) {
       // txt = "You pressed OK!";
        
    } 
    else
    {
        return false;
    }

	   var controller = 'Provisional_admission';
           
        //    $('#pmnt').prop('disabled', true);
            
            var fee_id =('#eid').val();
            alert(feeid);
	          $.ajax({
                    'url' : base_url + '/' + controller + '/generate_receipt_no',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'feeid' : feeid},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                       // var container = $('#edit_fee'); //jquery selector (get element by id)
                        if(data){
							//alert(data);
						alert("Fee Receipt Number Generated Successfully");
						$("#generate_receipt").hide();
                           // container.html(data);
                        }
                    }
                });
	});
	
	
	








    $('#pmnt').on('click', function () {
        
		$("#makepmnt").show();
	});
	
	
    $('#cbutton2').on('click', function () {
        
		$("#makepmnt").hide();
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
/////////////////
$(document).on("click", '#editpayment', function () {
   // var ye = $(this).value();
     //var va = $(this).attr('val');
    //alert(va);
        var stud_id = $('#editpayment').attr("data-stud_id");
        var applicable_fee = $('#editpayment').attr("data-applicable_fee");
      //  var academic_year = $('#editpayment').attr("data-academic_year");
        var academic_year = $(this).attr("data-academic_year");
        var openingbal = $(this).attr("data-openingbal");
        
        var actual_fee = $('#editpayment').attr("data-actual_fee");
       // var opening_balance = $('#editpayment').attr("data-opening_balance");
       
       var opening_balance = $(this).attr("data-opening_balance");
       
       
        var excemption_fees = $('#editpayment').attr("data-excemption_fees");
		//alert(opening_balance);
        if(stud_id !=''){
			document.getElementById("fstud_id").value = parseInt(stud_id);
		}
        if(applicable_fee !=''){
			$("#fgym_fees").html(parseInt(applicable_fee));
		}
        if(actual_fee !=''){
			$("#facdamicfee").html(parseInt(actual_fee));
		}
		if(opening_balance !=''){
			$("#fopening_balance").val(parseInt(openingbal));
			
		}
		if(excemption_fees !=''){
			$("#exem").html(parseInt(excemption_fees));
			
		}
		if(academic_year !=''){
			$("#acad_year").val(parseInt(academic_year));
			
		}

    });	        
	</script>