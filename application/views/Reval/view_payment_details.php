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
						<table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <!--th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th-->
                                    <th>S.No.</th>
									<th>PRN.</th>	
                                    <th>Student Name</th>
                                     <th>Semester</th>
									 <th>Stream Name</th> 
									 <?if($reval==0){ ?>
									 <th>Photocopy Fees</th>
            						<?php }else{ ?>
 									<th>Revaluation Fees</th> 	
            						<?php }  ?>
									 <th>No. Subjects</th>
                                     <th>Action</th>            
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        <?php 
                    	$result_data = $school_code.'~'.$stream.'~'.$exam_month.'~'.$exam_year.'~'.$exam_id;
                    	?>
                        	  <input type="hidden" id="res_data" name="res_data" value="<?=$result_data?>">

                            <?php
                           // echo "<pre>";
							//print_r($stream_list);
                          
                            $j=1;  
                            if(!empty($rev_list)){                          
                            foreach ($rev_list as $key => $value) {
                               if($reval==0){
					                $fees =$value['photocopy_fees']; 
					            }else{
					                $fees =$value['reval_fees']; 
					            }  
                            ?>				
                            <tr>
                              <td><?=$j?></td>
                              <td><?=$value['enrollment_no']?></td>
								<td><?=$value['stud_name']?></td> 
								<td><?=$value['semester']?></td> 
								<td><?=$value['stream_short_name']?></td>
								<td><?=$fees?></td>
								<td><?=$value['sub_cnt']?></td>
                                <td><?php if(empty($get_feedetails)){ ?><input type="button" class="btn btn-primary" name="make Payment" id="pmnt" value="Make Payment">
								<?php }else{ echo 'Paid';}?>
								</td>
                            </tr>
                            <?php
                            $j++;
                            }
                        }else{
                        	echo "<tr><td colspan='6'>No data found.</td></tr>";
                        }
                            ?>                            
                        
                        </tbody>
                    </table> 
    				   
					  </div>
					  </div>
				  
					  
<?php 
					//print_r($get_feedetails);
					if(!empty($get_feedetails)){
						$dispaly="display:block";
					}else{
						$dispaly="display:none";
					}
					?>
					  <div class="panel" style="<?=$dispaly?>">
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
    					</tr>
						<?php 
						$i=1;
						if(!empty($get_feedetails)){
							foreach($get_feedetails as $inst){
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
    

    					</tr>
						<?php
						$i++;
						
							}
						}else{
							echo "<tr><td colspan=8>No Data Found</td></tr>";
						}
						?>
						<tr>

							<td colspan="11" align="center"><a href="<?=base_url()?>Reval/photocopy_list_for_accounts"><input type="button" name="make Payment" value="Back" class="btn btn-primary" /></a></td>
    				
    						
    					</tr>
    					<tr>
    						
    					</tr>	
    				  </table>

                        </div>
                    </div>
<!------------------------------------------------------------------------------------------------------------------------------>
					  <div class="panel" id="makepmnt" style="display:none">
                            <div class="panel-heading">
							<?php
							if($reval==0){
					                $dpay =$rev_list[0]['photocopy_fees']; 
					            }else{
					                $dpay =$rev_list[0]['reval_fees']; 
					            }							
							?>
	<span class="panel-title">Make Payment: <span style="color:red">For Exam Session > <?=$exam_session[0]['exam_month']." ".$exam_session[0]['exam_year']?></span></span>
							</div>
                                <div class="panel-body">
								<form name="makePayment" id="makePayment" onsubmit="" method="POST" action="<?=base_url()?>Reval/pay_revalexam_fee" enctype="multipart/form-data">
								<input type="hidden" name="esession" value="<?=$exam_session['exam_id']?>" id="esession" >
								<?php
									$studId = $this->uri->segment(3);
								?>
								
								            <div class="form-group">
                                    <label class="col-sm-3">Exam Session</label>
                                    <div class="col-sm-3">
									<select name="exam_session" id="exam_session" class="form-control" required>
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
									  
									  <input type="hidden" name="stud_id" value="<?=$studId?>">
									  
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
                                    <div class="col-sm-6"><button type="submit" name="Make_Payment" value="Make Payment" class="btn btn-primary">PAY</button>
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