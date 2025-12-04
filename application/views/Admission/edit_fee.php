	 <script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
	 <script>
	     $(document).ready(function(){
   $('#cbutton').on('click', function () {
        $('#pmnt').prop('disabled', false);
        	$("#edit_fee").html('');
   });
         });
	 $('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	 	 $('#doc-sub-datepicker42').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	 </script>
	  <div class="panel" id="" style="">
                            <div class="panel-heading">
								<span class="panel-title">Edit Payment</span>
							</div>
                                <div class="panel-body">
								<form name="editPayment" id="editPayment" method="POST" action="<?=base_url()?>ums_admission/update_inst" enctype="multipart/form-data">
								<?php
									$studId = $this->uri->segment(3);
								?>
								
												 <div class="form-group">
                                    <label class="col-sm-3"> Academic Year</label>
                                     <div class="col-sm-3">
                                    <select name="acyear" id="acyear" class="form-control" >
									<option value="2023" <?php if($indet[0]['academic_year']=='2023'){echo "selected";} ?>>2023-24</option> 
									<option value="2022" <?php if($indet[0]['academic_year']=='2022'){echo "selected";} ?>>2022-23</option> 
									<option value="2021" <?php if($indet[0]['academic_year']=='2021'){echo "selected";} ?>>2021-22</option>  
                        <option value="2020" <?php if($indet[0]['academic_year']=='2020'){echo "selected";} ?>>2020-21</option>            
                        <option value="2019" <?php if($indet[0]['academic_year']=='2019'){echo "selected";} ?>>2019-20</option>
                    	<option value="2018" <?php if($indet[0]['academic_year']=='2018'){echo "selected";} ?>>2018-19</option>
                    	<option value="2017" <?php if($indet[0]['academic_year']=='2017'){echo "selected";} ?>>2017-18</option>
					    <option value="2016" <?php if($indet[0]['academic_year']=='2016'){echo "selected";} ?>>2016-17</option>
								
								
									
									</select>
									
									
                                    </div>
                                    
                                    </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">Payment of Rs</label>
                                    <div class="col-sm-3">
                                      <input data-bv-field="paidfee" id="epaidfee" name="epaidfee" class="form-control numbersOnly" value="<?=$indet[0]['amount']?>" placeholder="Paid Fee" type="text" required>

									    <input type="hidden" name="eid" id="eid" value="<?=$indet[0]['fees_id']?>">
									    <input type="hidden" name="sid" value="<?=$indet[0]['student_id']?>">
									    <input type="hidden" name="bfees" value="<?=$indet[0]['balance_fees']?>">
									    <input type="hidden" name="pfees" value="<?=$indet[0]['amount']?>">
									      
                                    </div>
                                    <label class="col-sm-3">Payment Type</label>
                                    <div class="col-sm-3">
                                    <select name="epayment_type" id="epayment_type" class="form-control">
                                        <option value="">Select Payment Type</option>
									<option value="CHQ" <?php if($indet[0]['fees_paid_type']=='CHQ'){echo "selected";} ?>>Cheque</option>
									<option value="DD" <?php if($indet[0]['fees_paid_type']=='DD'){echo "selected";} ?>>DD</option>
									<option value="CHLN" <?php if($indet[0]['fees_paid_type']=='CHLN'){echo "selected";} ?>>Chalan</option>
								<option value="ITF" <?php if($indet[0]['fees_paid_type']=='ITF'){echo "selected";} ?>>Internal Transfer</option>		
								<option value="POS" <?php if($indet[0]['fees_paid_type']=='POS'){echo "selected";} ?>>POS </option>	
									<option value="OL" <?php if($indet[0]['fees_paid_type']=='OL'){echo "selected";} ?>>Online</option>
									<option value="GATEWAY-ONLINE" <?php if($indet[0]['fees_paid_type']=='GATEWAY-ONLINE'){echo "selected";} ?>>GATEWAY-ONLINE</option>
									</select>
									
									
                                    </div>
                                  </div>
                                  <div class="form-group">
								  
								   <label class="col-sm-3"> Cheque/DD No./Chalan No.</label>
                                    <div class="col-sm-3">
                                      <input type="text" name="edd_no" class="form-control"  value="<?= isset($indet[0]['receipt_no']) ? $indet[0]['receipt_no'] : '' ?>" placeholder="Cheque/DD No./Chalan No" >
                                    </div>
									
                                    <label class="col-sm-3">Dated</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker21" name="edd_date" required value="<?= isset($indet[0]['fees_date']) ? $indet[0]['fees_date'] : '' ?>" placeholder="DD Date" required readonly="true"/>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                      
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-3">Bank name</label>
                                    <div class="col-sm-3">
                                     <!-- <input type="text" id="dd_bank" name="dd_bank" class="form-control" value="<?= isset($fee[0]['dd_drawn_bank_branch']) ? $fee[0]['dd_drawn_bank_branch'] : '' ?>" placeholder="Bank & Branch">-->

									<select name="edd_bank" id="edd_bank" class="form-control" >
									  <option value="">Select</option>
									  <?php
										foreach ($bank_details as $branch) {
										  if($branch['bank_id']==$indet[0]['bank_id'])
										  $sel ="selected";
										  else
										  $sel='';
											echo '<option value="' . $branch['bank_id'] . '" ' . $sel . '>' . $branch['bank_name'] . '</option>';
										}
										?>
								   </select>

                                    </div>
                                    <label class="col-sm-3"> Branch Name.</label>
                                    <div class="col-sm-3">
                                      <input type="text" id="edd_bank_branch" name="edd_bank_branch" class="form-control" value="<?= isset($indet[0]['bank_city']) ? $indet[0]['bank_city'] : '' ?>" placeholder="Branch Name" >
                                    </div>
                                  </div>
                                  
                                  <div class="form-group">
								   <label class="col-sm-3">Upload document</label>
                                    <div class="col-sm-3"><input type="file" name="epayfile">
                                    </div>
                                    <label class="col-sm-3">College Receipt Number</label>
                                    <div class="col-sm-3">
                                          <input type="text" id="eclreceipt" name="eclreceipt" class="form-control" value="<?= isset($indet[0]['college_receiptno']) ? $indet[0]['college_receiptno'] : '' ?>" placeholder="College Receipt Number" required>
                                    </div>
                                    
                                    
                                  </div>
                                  
                                    <div class="form-group">
                                            <label class="col-sm-3">Next Payment Date</label>
                                    <div class="col-sm-3">
                                        <?php 
                                       if($indet[0]['next_payment_date']==0000-00-00 || $indet[0]['next_payment_date']==NULL )
                                        {
                                        //    $pdate =  date('Y-m-d');
                                        }
                                        else
                                        {
                                      $pdate =  $indet[0]['next_payment_date'];      
                                        }
                                        ?>
                                      <input type="text" class="form-control" id="doc-sub-datepicker42" name="enpdate"  value="<?=$pdate; ?>" placeholder="Next Payment Date" required readonly="true"/>
                                    </div>
								       <label class="col-sm-3">Remark</label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control" id="eremark" name="eremark"><?= isset($indet[0]['remark']) ? $indet[0]['remark'] : '' ?></textarea>
                                    </div>
                                    
                                    </div>
                                     <script>
                                 
   function show1()
   {
       $('#hcontent').show();
       $('#hlabel').show();
   }
   function hide1()
   {
          $('#hcontent').hide();
       $('#hlabel').hide();
   }
   

                                  </script>
								  <div class="form-group">
								      <?php
								     if($indet[0]['chq_cancelled']=='Y')
								     {
								      ?>
							<label class="col-sm-3">Cheque Cancelled</label> <div class="col-sm-3">Yes&nbsp;
								  <input type="radio" value="Y" name="ccanc" checked onclick="show1();">
								  &nbsp;No&nbsp;
								  <input type="radio" value="N" name="ccanc" onclick="hide1();" ></div>
								 <label class="col-sm-3" id="hlabel">Bank Cancellation Charges </label> <div class="col-sm-3" id="hcontent"><input type="text" value="<?=$indet[0]['canc_charges']?>" name="cancamt" class="form-control cancamt" placeholder="" ></div>
								  
                                  <?php
								     }
								     else
								     {
								         ?>
								         	  <label class="col-sm-3">Cheque Cancelled</label> <div class="col-sm-3">Yes&nbsp;
								  <input type="radio" value="Y" name="ccanc" onclick="show1();">
								  &nbsp;No&nbsp;
								  <input type="radio" value="N" name="ccanc" checked onclick="hide1();"></div>
								  
								  <label class="col-sm-3" id="hlabel" style="display:none">Bank Cancellation Charges </label><div class="col-sm-3" id="hcontent" style="display:none" ><input type="text" value="<?=$indet[0]['canc_charges']?>" name="cancamt" class="form-control cancamt" style="" placeholder="Cancellation Bank Charges"></div>
								         <?php
								         
								     }
                                  ?>
                                  </div>
                                  
                                        <div class="form-group">
                                            <label class="col-sm-3">Fine If Any</label>
                            <div class="col-sm-3">
                                      <input type="text" class="form-control numbersOnly" id="ffine" name="ffine"  value="<?= isset($indet[0]['academic_fee_fine']) ? $indet[0]['academic_fee_fine'] : '' ?>"  />
                                    </div>
								      
                                    
                                    </div>
                                 
                                 
                                 
                                 
                                 
                                 
                                		  <div class="form-group">
								   
							<label class="col-sm-3">Amount Adjusted in Examination Fees If Any</label> <div class="col-sm-3"><input type="text" class="form-control" value="<?=$indet[0]['adjustment_amount']?>" name="adjamt"  placeholder="" ></div>
								  
                              
                                  </div> 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                  <div class="form-group">
                                       <div class="col-sm-5"></div>
                                      <div class="col-sm-1">
                                     <button type="button" name="Cancel" id="cbutton" value="Cancel" class="btn btn-primary">Cancel</button>
                                    </div>
                                    
                                    <div class="col-sm-1">
                                     <button type="submit" name="Make_Payment" value="Make Payment" class="btn btn-primary">Update </button>
                                    </div>
                                    
                                     <?php
                             if($indet[0]['college_receiptno1']=='')
                                    {
                                    ?>
                                     <div class="col-sm-2">
                                     <button type="button" id="generate_receipt" value="Generate Receipt" class="btn btn-primary"> Generate Receipt </button>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                  </div>
                                  
                                  
                                  
                                  </form>
                                </div>
                            </div>
                            
                                   <script>
                            
   $('#generate_receipt').on('click', function () {
        
        if(confirm("Are you sure you want to generate receipt Number ?") == true) {
       // txt = "You pressed OK!";
        
    } 
    else
    {
        return false;
    }
	$("#generate_receipt").hide();
	   var controller = 'Ums_admission';
           
        //    $('#pmnt').prop('disabled', true);
            
            var fee_id = $('#eid').val();
            alert(fee_id);
	          $.ajax({
                    'url' : base_url + '/' + controller + '/generate_receipt_no',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'feeid' : fee_id},
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
	
                            </script>
                            
                            