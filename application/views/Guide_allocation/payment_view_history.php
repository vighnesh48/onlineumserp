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


<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
	$uid=$this->session->userdata("uid");
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Payment Details</a></li>
    </ul>
    <div class="page-header">			
        
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Payment Details</span>
                    </div>
					
                    <div class="panel-body ">
                        <div class="table-info">   
							<table class="table table-bordered">
    					<tr>
    					  <th width="25%">Member name :</th><td><?=$renum_det['member_name'];?></td>
						</tr>
						<tr>
    					  <th width="25%">Academic Year :</th><td><?=$renum_det['academic_year'];?></td>
						</tr>
						<tr>
						  <th scope="col">Students Count :</th><td><?=$renum_det['stud_count'] ? $renum_det['stud_count']:'0' ;?>&nbsp;&nbsp;&nbsp;<!--a href="<?=base_url();?>Guide_allocation_phd/fetch_guide_renumeration_det_view/<?=base64_encode($stud['emp_code']);?>/<?=base64_encode($stud['academic_year']);?>" title="View" target="_blank" ><i class="fa fa-eye"></i></a--></td>
						</tr>
						<tr>
    					  <th scope="col">Total remuneration :</th><td><?=$renum_det['renumeration'] ? $renum_det['renumeration'] :'0' ;?></td>
    					</tr>						
						<tr>
    					  <th scope="col">Total Paid :</th><td><?=$renum_det['total_paid'] ? $renum_det['total_paid']:'0' ;?></td>
    					</tr>
						<tr>
						<?php 
						 $pending=($renum_det['renumeration']-$renum_det['total_paid']);						
						?>
    					  <th scope="col">Pending Payment :</th><td><?= $pending ? $pending : '0'; ?></td>
    					</tr>
						</table>
					  </div>
					  </div>
					  <div class="panel">
				   <div class="panel-body">
					  <table class="table table-bordered">
    					<tr>
    					  <th scope="col">Sr. No. </th>
						   <th scope="col">Academic Year</th>
						  <th scope="col">Amount Paid</th>
						  <th scope="col">Payment Mode</th>
						   <th scope="col">Bank Name</th>
						    <th scope="col">Cheque No</th>
							<th scope="col">Cheque Date</th>
							<th scope="col">Reference No</th>
						  <th scope="col">Remark</th>
						  <th scope="col">Uploaded Image</th>
    					 <!--th scope="col">Action</th-->
    					</tr>
						<?php 
						$i=1;
						 $j=1;
						if(!empty($payment_det)){
							foreach($payment_det as $inst){
						?>
    					<tr>
    					    <td><?=$i?></td>
    					     <td><?=$inst['academic_year']?></td>
							<td><?=$inst['amount']?></td>
							<td><?=$inst['pay_mode']?></td>
    						<td><?=$inst['bank_name']?></td>
    						<td><?=$inst['cheq_no']?></td>
    						<td><?=$inst['cheq_date']?></td>
    						<td><?=$inst['ref_no']?></td>
    						<td><?=$inst['remark']?></td>
							<td>
							<?php if ($inst['cheque_file']): 
								$b_name = "uploads/phd_renumaration_files/";
								$dwnld_url = base_url()."Upload/download_s3file/".$inst['cheque_file'].'?b_name='.$b_name; ?>
								<a href="<?= $dwnld_url ?>" download><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a><?php endif; ?>
							</td> 
							<!--td>
							<a href="javascript:void(0)"                       
							onclick="deleterecrd(<?php echo $inst['pid']; ?>)"
							>Delete transaction |</a>
							<br>
							<a href="javascript:void(0)"                         
							onclick="update_payment(<?php echo $inst['pid']; ?>)"
							>Edit Payment</a>												
							</td-->     						
    					</tr>
						<?php
						$i++;
						$j++;
							}

						}else{
							echo "<tr><td colspan=11>No Data Found</td></tr>";
						}
						?>
    					<tr>
							<td colspan="11" align="center">
							<a  class="btn btn-primary" href="<?=base_url();?>Guide_allocation_phd/make_payment/<?=base64_encode($renum_det['emp_code']);?>/<?=base64_encode($renum_det['academic_year'])?>" >Make Payment</a>							 
							<a  class="btn btn-primary" href="<?php echo base_url('Guide_allocation_phd/account_phd_renum'); ?>">Back</a>
							</td>
    					</tr>	
    				  </table>
                       </div>
                    </div>
    
                      </div>
                </div>
            </div>    
        </div>
    </div>


<div class="modal fade" id="psmodal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                
                <h4 class="modal-title" id="myModalLabel">
                   <span id="fform_id">Edit Payment
				   </span>
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default panel-hovered panel-stacked" style="margin-top: 10px;">
                                    <div class="panel-body">

										<div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Amount </label>
                                             <div class="col-sm-6">
                                           
                                                <input type="number" name="ammount" id="ammount" class="form-control" value="" required /> 
                                            </div>
                                        </div>										
										<div class="form-group">
                                            <label class="col-sm-3" for="exampleInputEmail1">Reference No </label>
                                             <div class="col-sm-6">
                                           
                                                <textarea name="refid" id="refid" class="form-control"   /> </textarea>
                                            </div>
                                        </div>
   
                                          <button type="submit" id="sbm1" class="btn btn-primary" onclick="updatepaymentv()" >Submit</button>
                                          <button type="button" class="btn btn-default"
                                                data-dismiss="modal">
                                                    Close
                                        </button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>               
					</div>
				</div>
			</div>
		</div>
<script>

/*    function updatepaymentv()
 {
	 var ammount = $("#ammount").val();
	 var refid=$("#refid").val();
	var id=$("#id_ps_foc").val();
	if(ammount==0){
		alert("please enter proper amount");
	}
	else{
	
   var controller = 'Students';
           
            $('#sbm1').prop('disabled', true);
           
			$.ajax({
                    'url' : base_url + controller + '/ueditconspayment',
                    'type' : 'POST', //the way you want to send data to your URL
                     'data' : {'id':id,'ammount':ammount,'refid':refid},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        if(data==1){
							alert("Successfully updated");
                        location.reload();
						}
						else{
						alert("Something went wrong");
                       // location.reload();
					}
                    }
					
                });
	        }
        }


function update_payment(id){
		$("#id_ps_foc").val(id)
		$("#psmodal").modal('show');
	}
 */
</script>