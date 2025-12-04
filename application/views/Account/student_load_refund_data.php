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
<?php
if($emp_list['enrollment_no']!='')
{
?>
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                
                                    <th>PRN</th>
                                     <th class="noExl">Photo</th>
                                    <th>Name</th>
                                    <th>Stream </th>
                                     <th>Year</th>
                                     <th>Actual Fee  </th>
                                      <th>Applicable Fee </th>
                                     <th>Fee Paid </th>
                                     <th>Balance Fee  </th>
                                   
                                 
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                          //  var_dump($emp_list);
                          
                            $j=1;                            
                         //   for($i=0;$i<count($emp_list);$i++)
                            //{
                               
                            ?>
							 <?php if($emp_list['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
                               
                        
                                 <td><?=$emp_list['enrollment_no']?></td> 
                                 
                                   <td  class="noExl">
                                       <?php
                                     //  $tep = base_url().'uploads/2017-18/'.$emp_list[$i]['form_number'].'/' . $emp_list[$i]['form_number'].'_PHOTO.bmp';
                                     //  echo $tep;
                                       if (file_exists('uploads/2017-18/'.$emp_list['form_number'].'/' . $emp_list['form_number'].'_PHOTO.bmp')) {
                                         //  echo "yES";
                                           $ext = 'bmp';
                                       }
                                       else
                                       {
                                             $ext = 'jpg';
                                       }
                                       ?>
                                       
                                       <img src="https://erp.sandipuniversity.com/uploads/2017-18/<?=$emp_list['form_number']?>/<?=$emp_list['form_number']?>_PHOTO.<?=$ext?>" alt="" width="60"/></td> 
                                <td>
							
							<?php
								echo $emp_list['first_name']." ".$emp_list['middle_name']." ".$emp_list['last_name'];
								?>
								</td> 
							
								   <td><?=$emp_list['stream_name']?></td>
								    <td><?=$emp_list['admission_year']?></td> 
								       <td><?=$emp_list['actual_fee']?></td> 
                                   <td><?=$emp_list['applicable_fee']?></td> 
								    <td><?=$emp_list['total_fee']?></td>
								     <td><?=$emp_list['applicable_fee']-$emp_list['total_fee']?></td>
                               
                                                   
                                                      
                
                            </tr>
                            <?php
                            $j++;
                        //    }
                            ?>        
                            	<tr id="shwbtnpay"><td colspan="9" align="center"><input type="button" name="Make Refund" id="pmnt" value="Make Refund" class="btn btn-primary" />
                            	<a href="<?=base_url()?>Account/fees_refund"><button type="button" name="Cancel" value="Cancel" class="btn btn-primary">Cancel</button></a></td></tr>
                        </tbody>
                    </table>  
            <?php
}
else
{
   echo "Record Not Found";       
}
            ?>
                       <input type="hidden" name="dcourse" value="<?=$dcourse;?>">
                     <input type="hidden" name="dyear" value="<?=$dyear;?>">
                    
                     <!-- <input type="submit" value="Apply Fees" class="btn btn-primary btn-labeled">-->
                     
                     
                     </form>
                     
                     
                     
                     
                       <div class="panel" id="makepmnt" style="display:none">
                            <div class="panel-heading">
								<span class="panel-title">Make Refund</span>
							</div>
                                <div class="panel-body">
								<form name="makePayment" id="makePayment" onsubmit="" method="POST" action="<?=base_url()?>Account/stud_pay_refund" enctype="multipart/form-data">
								<?php
									$studId = $this->uri->segment(3);
								?>
                                  <div class="form-group">
                                    <label class="col-sm-3">Refund of Rs</label>
                                    <div class="col-sm-3">
                                      <input data-bv-field="paidfee" id="paidfee" name="paidfee" class="form-control numbersOnly" value="" placeholder="Refund Amount" type="text" required>
									  <input type="hidden" name="no_of_installment" value="<?= isset($noofinst[0]['max_no_installment']) ? $noofinst[0]['max_no_installment'] : '' ?>">
									  <input type="hidden" name="stud_id" value="<?=$emp_list['stud_id']?>">
									  <input type="hidden" name="min_balance" value="<?= isset($minbalance[0]['min_balance']) ? $minbalance[0]['min_balance'] : '' ?>">
                                    </div>
                                    
                                    <label class="col-sm-3">Refund For</label>
                                    <div class="col-sm-3">
                                    <select name="refund_type" id="refund_type" class="form-control" required>
                                        <option value="">Select Refund Type</option>
									<option value="C">Admission Cancellation</option>
									<option value="E">Excess Payment Received</option>
								
									
									</select>
									
									
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                               
                                  </div>
                                  <div class="form-group">
                                      
                                           <label class="col-sm-3">Refund Mode</label>
                                    <div class="col-sm-3">
                                    <select name="payment_type" id="payment_type" class="form-control" required>
                                        <option value="">Select Payment Type</option>
									<option value="CHQ">Cheque</option>
									<option value="DD">DD</option>
									<option value="CHLN">Chalan</option>
									<option value="ITF">Internal Transfer</option>
									</select>
									
									
                                    </div>
								  <input type="hidden" name="actfee" value="<?= isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '' ?>">
								   <label class="col-sm-3"> Cheque/DD No./Chalan No.</label>
                                    <div class="col-sm-3">
                                      <input type="text" name="dd_no" class="form-control" required value="<?= isset($fee[0]['dd_no']) ? $fee[0]['dd_no'] : '' ?>" placeholder="Cheque/DD No./Chalan No" required>
                                    </div>
									
                                  
                                  </div>
                                  <div class="form-group">
                                      
                                       <label class="col-sm-3">Dated</label>
                                    <div class="col-sm-3">
                                      <input type="text" class="form-control" id="doc-sub-datepicker20" name="dd_date" required value="<?= isset($fee[0]['dd_drawn_date']) ? $fee[0]['dd_drawn_date'] : '' ?>" placeholder="Date" required readonly="true"/>
                                    </div>
                                    
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
                                   
                                  </div>
                                  
                                  <div class="form-group">
                                      
                                       <label class="col-sm-3"> Branch Name.</label>
                                    <div class="col-sm-3">
                                      <input type="text" id="dd_bank_branch" name="dd_bank_branch" class="form-control" value="" placeholder="Branch Name" required>
                                    </div>
                                    
								   <label class="col-sm-3">Upload document</label>
                                    <div class="col-sm-3"><input type="file" name="payfile"></div>
                                    
                                  </div>
                                 
                                 <div class="form-group">
                                  <label class="col-sm-3">Academic Year</label>
                                    <div class="col-sm-3">
                                    <select name="acyear" id="acyear" class="form-control" required>
                                    <option value="2025" selected>2025-26</option>
                                    <option value="2024" >2024-25</option>
                                    <option value="2023" >2023-24</option>
                                    <!--option value="2022" >2022-23</option>
                                     <option value="2021">2021-22</option>
                                    <option value="2020" >2020-21</option>
									<option value="2019" >2019-20</option>
									<option value="2018">2018-19</option>
									 <option value="2017">2017-18</option>
									 <option value="2016">2016-17</option-->
								   </select>
                                    </div>
                                    <label class="col-sm-3">Remark</label>
                                    <div class="col-sm-3">
                                    <textarea class="form-control" id="remark" name="remark"></textarea>
                                    </div>
                                    
                                    
                                    </div>
                                 
								  <div class="form-group">
								      
								      
								   <label class="col-sm-4"></label> 
								   <div class="col-sm-3"><button type="submit" name="Make_Payment" value="Make Payment" class="btn btn-primary">Make Payment</button> &nbsp;&nbsp;
								   <a href="<?=base_url()?>Account/fees_refund"><button type="button" name="Cancel" value="Cancel" class="btn btn-primary">Cancel</button></a></div>

                                   
                                      <label class="col-sm-3"></label> 
                                  </div>
                                  </form>
                                </div>
                            </div>
                            
                            
                     
                     
                     
                     
                     
                     
                   
                     <script>
                     
                     
                     
                     
$(document).ready(function () {
    
    $('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    } 
  	});
  	
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
                     
                     
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
  filename: "Student List" //do not include extension

  });

});

                     </script>
                     
                     
	    