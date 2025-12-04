   <?php
  // var_dump($_SESSION);
   ?>

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

$('#canc').click(function(){

//alert(var1);
var  dat= $("#doc-sub-datepicker20").val();
var remark = $("#cremark").val();
var cfee = $("#cfee").val();
var stid = $("#stid").val();
var stenrl = $("#stenrl").val();
                     if(cfee=='')
                    {
                        alert("Please Enter Cancellation Fee");
                        return false;
                    }
                    
                    
                     if(dat=='')
                    {
                        alert("Please Select Cancellation Date");
                        return false;
                    }
                    
                     if(remark=='')
                    {
                        alert("Please Enter Cancellation Remark");
                        return false;
                    }
                    
var text='';

  text = "Are you sure you want to cancel Admission";  

//var txt;
    if (confirm(text) == true) {
       // txt = "You pressed OK!";
        
    } 
    else
    {
        return false;
    }


 $.ajax({
                    'url' : base_url + '/Ums_admission/cancel_stud_adm',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'stid':stid,'remark':remark,'cfee':cfee,'dat':dat,'stenrl':stenrl},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                       //if(type1=="S"){var container = $('#stest');}else{var container = $('#ptest');} //jquery selector (get element by id)
                        if(data){
                            
                       // alert(data);
                            alert("Admission Cancelled Successfully");
                            $("#makepmnt").hide();
                            $("#hidet").hide();
                            //$("#"+type).val('');
                          //  container.html(data);
                          location.reload();
                            	return false;
                        }
                          return false;
                    }
                });
});







</script>

                  
                     <div class="panel">
                     

                    <div id="dashboard-recent" class="panel panel-warning">        
                     <div class="panel-heading">
                       <span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i>Fees Refund</span>
			    		</div>
			    		<div class="panel-body">
                     
                     
                     
                       <div class="panel" id="makepmnt" style="display:">
                            <div class="panel-heading">
								<span class="panel-title">Make Refund</span>
							</div>
                                <div class="panel-body">
								<form name="makePayment" id="makePayment" onsubmit="" method="POST" action="<?=base_url()?>Account/edit_refund/<?=$refund['fees_id']?>" enctype="multipart/form-data">
								<?php
									$studId = $this->uri->segment(3);
								?>
                                  <div class="form-group">
                                    <label class="col-sm-3">Refund of Rs</label>
                                    <div class="col-sm-3">
                                      <input data-bv-field="paidfee" id="paidfee" value="<?= isset($refund['amount']) ? $refund['amount'] : '' ?>" name="paidfee" class="form-control numbersOnly"  placeholder="Refund Amount" type="text" required>
									  <input type="hidden" name="no_of_installment" value="<?= isset($noofinst[0]['max_no_installment']) ? $noofinst[0]['max_no_installment'] : '' ?>">
									  <input type="hidden" name="stud_id" value="<?=$emp_list['stud_id']?>">
									  <input type="hidden" name="fees_id" value="<?= isset($refund['fees_id']) ? $refund['fees_id'] : '' ?>">
                                    </div>
                                    
                                    <label class="col-sm-3">Refund For</label>
                                    <div class="col-sm-3">
                                    <select name="refund_type" id="refund_type" class="form-control" required>
                                        <option value="">Select Refund Type</option>
									<option value="C" <?if($refund['refund_for']=="C")echo "selected";?>>Admission Cancellation</option>
									<option value="E" <?if($refund['refund_for']=="E")echo "selected";?>>Excess Payment Received</option>
								
									
									</select>
									
									
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                               
                                  </div>
                                  <div class="form-group">
                                      
                                           <label class="col-sm-3">Refund Mode</label>
                                    <div class="col-sm-3">
                                    <select name="payment_type" id="payment_type" class="form-control" required>
                                        <option value="">Select Payment Type</option>
									<option value="CHQ" <?if($refund['refund_paid_type']=="CHQ")echo "selected";?>>Cheque</option>
									<option value="DD" <?if($refund['refund_paid_type']=="DD")echo "selected";?>>DD</option>
									<option value="CHLN" <?if($refund['refund_paid_type']=="CHLN")echo "selected";?>>Chalan</option>
									
									</select>
									
									
                                    </div>
								  <input type="hidden" name="actfee" value="<?= isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '' ?>">
								   <label class="col-sm-3"> Cheque/DD No./Chalan No.</label>
                                    <div class="col-sm-3">
                                      <input type="text" name="dd_no" class="form-control" required value="<?= isset($refund['receipt_no']) ? $refund['receipt_no'] : '' ?>" placeholder="Cheque/DD No./Chalan No" required>
                                    </div>
									
                                  
                                  </div>
                                  <div class="form-group">
                                      
                                       <label class="col-sm-3">Dated</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker20" name="dd_date" required value="<?= isset($refund['refund_date']) ? $refund['refund_date'] : '' ?>" placeholder="Date" required readonly="true"/>
                                    </div>
                                    
                                    <label class="col-sm-3">Bank name</label>
                                    <div class="col-sm-3">
                                     <!-- <input type="text" id="dd_bank" name="dd_bank" class="form-control" value="<?= isset($fee[0]['dd_drawn_bank_branch']) ? $fee[0]['dd_drawn_bank_branch'] : '' ?>" placeholder="Bank & Branch">-->

									<select name="dd_bank" id="dd_bank" class="form-control" required>
									  <option value="">Select</option>
									  <?php
										foreach ($bank_details as $branch) {
										  if($branch['bank_id']==$refund['bank_id']){
										  $sel='selected';}
										  else
										  {
										      $sel='';
										  }
											echo '<option value="' . $branch['bank_id'] . '" ' . $sel . '>' . $branch['bank_name'] . '</option>';
										}
										?>
								   </select>

                                    </div>
                                   
                                  </div>
                                  
                                  <div class="form-group">
                                      
                                       <label class="col-sm-3"> Branch Name.</label>
                                    <div class="col-sm-3">
                                      <input type="text" id="dd_bank_branch" name="dd_bank_branch" class="form-control" value="<?= isset($refund['bank_city']) ? $refund['bank_city'] : '' ?>" placeholder="Branch Name" required>
                                    </div>
                                    
								   <label class="col-sm-3">Upload document</label>
                                    <div class="col-sm-3"><input type="file" name="payfile"><a href="<?php echo base_url()?>uploads/student_challans/<?= isset($refund['receipt_file']) ? $refund['receipt_file'] : '' ?>" target="_blank"><?= isset($refund['receipt_file']) ? $refund['receipt_file'] : '' ?></a></div>
                                    
                                  </div>
                                 
                                 <div class="form-group">
                                     
                                      <label class="col-sm-3">Academic Year</label>
                                    <div class="col-sm-3">
                                    <select name="acyear" id="acyear" class="form-control" required>
									<option value="2019" <?php if($refund['academic_year']=='2019'){echo "selected";}?>>2019-20</option> 
									<option value="2018" <?php if($refund['academic_year']=='2018'){echo "selected";}?>>2018-19</option> 
									 <option value="2017" <?php if($refund['academic_year']=='2017'){echo "selected";}?>>2017-18</option>
									 <option value="2016" <?php if($refund['academic_year']=='2016'){echo "selected";}?>>2016-17</option>
								   </select>
                                    </div>
                                  <label class="col-sm-3">Remark</label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control" id="remark" name="remark"><?= isset($refund['remark']) ? $refund['remark'] : '' ?></textarea>
                                    </div>
                                    </div>
                                 
								  <div class="form-group">
								      
								      
								   <label class="col-sm-6"></label> 
                                    <div class="col-sm-6"><button type="submit" name="Make_Payment" value="Make Payment" class="btn btn-primary">Update Refund</button>
                                    </div>
                                  </div>
                                  </form>
                                </div>
                            </div>
                            
                            
                     </div>
                     
                      </div>
                     
                     
                     
                   
                     <script>
                     
                     
                     
                     
$(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });
    
    $(".checkBoxClass").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll").prop("checked",false);
        }
    });
});
                     
                     
        $('#pmnt').on('click', function () {
		$("#makepmnt").show();
	});              
                     
                     
                     
                     
                     
                     
            $('#doc-sub-datepicker20').datepicker( {format: 'yyyy-mm-dd',autoclose: true});
	      $('#doc-sub-datepicker21').datepicker( {format: 'yyyy-mm-dd',autoclose: true});           
                     


                     </script>
                     
                     
	    