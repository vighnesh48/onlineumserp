<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
#guide { display: flex; 
       justify-content: center }

</style>
<script>    
    $(document).ready(function()
    {
        $('#form').bootstrapValidator
        ({  
            message: 'This value is not valid',
            group: 'form-group',
            feedbackIcons: 
            {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: 
            {
				bank_name:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Bank Name should not be empty'
                      }
					}  
                },
				pay_mode:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Payment Mode should not be empty'
                      }
					}  
                },
				 amount: {
						validators: {
							notEmpty: {
								message: 'Amount should not be empty'
							},
							regexp: {
								regexp: /^(?!0)\d{1,7}(\.\d{1,2})?$/,
								message: 'Amount should be a numeric value, not start with 0, and be 2-8 characters long'
							},
							stringLength: {
								min: 2,
								max: 8,
								message: 'Amount should be 2-8 characters long'
							}
						}
					},
				  acc_no:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Account no should not be empty'
                      },
                       regexp: 
                      {
                        regexp:  /^[0-9]+$/,
                        message: 'Bank No should be numeric'
                      },
                      stringLength: 
                        {
                        max: 10,
                        min: 2,
                        message: 'Account no should be 2-20 characters'
                        }
                    }

                },
				   cheq_no: {
                    validators: {
                        regexp: {
                             regexp:  /^[0-9]+$/,
                             message: 'Cheque number should be numeric'
                        },
                        stringLength: {
                            min: 6,
                            max: 6,
                            message: 'Cheque number should be exactly 6 digits long'
                        }
                    }
                },
				  cheque_file: {
                    validators: {
                        file: {
                            extension: 'jpeg,jpg,png,gif,pdf',
                            type: 'image/jpeg,image/png,image/gif,application/pdf',
                            maxSize: 2097152, // 2 MB in bytes
                            message: 'Please select a valid file (jpeg, jpg, png, gif, pdf) and the file size must be less than 2 MB'
                        }
                    }
                },
				remark: {
                    validators: {
                        stringLength: {
                            min: 2,
                            max: 250,
                            message: 'Remark should be 2-250 digits long'
                        }
                    }
                },
				ref_no:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'IFSC should not be empty'
                      },
                      regexp: 
                      {
                        regexp: /^[A-Z0-9/]+$/,
                        message: 'IFSC should be alpha numeric value'
                      },
                      stringLength: 
                        {
                        max: 11,
                        min: 11,
                        message: 'IFSC should be Exactly 11 characters'
                        }
                    }

                },
					pay_mode: {
					validators: {
						regexp: {
							regexp: /^[a-zA-Z\/]+$/,
							message: 'Payment Mode can only contain alphabets and slashes'
						},
						 stringLength: {
                            min: 2,
                            max: 25,
                            message: 'Payment Mode should be 2-25 digits long'
                        }
					}
				},
            }       
        })
    }); 
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Phd Guide Allocation</a></li>
    </ul>
	
		<?php //echo'<pre>';print_r($renum_files);exit;
     if(isset($_SESSION['status']))
     {
        ?>
			<script>
			var status="<?php echo $_SESSION['status'] ?>";
			 alert(status);
			</script>
        <?php 
        unset($_SESSION['status']);
       }
   ?>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Payment Details </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row"> 
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
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
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Add Payment Details</span>						
						<span id="message" style="color:red;padding-left:200px;"></span>
                        <div class="holder"></div>
					</div>
                    <div class="panel-body">
                        <div class="table-info">                                                       
                            <form id="form" name="form" action="<?=base_url($currentModule.'/insert_payment_details')?>" method="POST" enctype="multipart/form-data"> 
							 <input type="hidden" name="emp_code" value="<?=$renum_det['emp_code'];?>" />	
							 <input type="hidden" name="academic_year" value="<?=$renum_det['academic_year'];?>" />	
							<div class="form-group">                             							
                                <div class="col-sm-4">
                                     <label>Amount: <?=$astrik?></label>
									<input type="text" id="amount" name="amount" class="form-control" placeholder="Enter Amount" />
                                   <span style="color:red;"><?php echo form_error('amount');?></span>								
                                </div>
								<div class="col-sm-4">
							   <label>Payment Mode: <?=$astrik?></label>                                  
									<select class="form-control" id="pay_mode" name="pay_mode">
                                    <option value="">Select</option>
									<option value="DD">DD</option>
									<option value="RTGS/NEFT">RTGS/NEFT</option>
                                    <option value="Cheque">CHEQUE</option>
                                    <option value="Cash">CASH</option>
                                    <option value="Other">OTHER</option>
								     </select>
									   <span style="color:red;"><?php echo form_error('pay_mode');?></span>
                                </div>	
									<div class="col-sm-4">
                                   <label>Bank Name: <?=$astrik?></label>
									<select  name="bank_name" id="bank_name" class="form-control" >
                                 <option value="">Select Bank</option>
                                 <?php
                                    foreach($bank_details as $result){?>
                                 <option value="<?php echo $result['bank_id']?>"><?php echo $result['bank_name'];?></option>
                                 <?php } ?>   
                              </select>
                                   <span style="color:red;"><?php echo form_error('bank_name');?></span>
                                </div>                             							
							</div>							 
							<div class="form-group">  
                                 <div class="col-sm-4">
                                   <label>Cheque No: </label>
									<input type="text" id="cheq_no" name="cheq_no" class="form-control" placeholder="Enter Cheque No." />
                                   <span style="color:red;"><?php echo form_error('cheq_no');?></span>
                                </div>							
                                <div class="col-sm-4">
                                     <label>Cheque Date: </label>
									<input type="text" id="cheq_date" name="cheq_date" class="form-control" />
                                   <span style="color:red;"><?php echo form_error('cheq_date');?></span>								
                                </div>		
                                  <div class="col-sm-4">
                                     <label>IFSC Code: </label>
									<input type="text" id="ref_no" name="ref_no" class="form-control" placeholder="Enter IFSC Code" />
                                   <span style="color:red;"><?php echo form_error('ref_no');?></span>								
                                </div>								
							</div>
							<div class="form-group">  
                                 <div class="col-sm-4">
                                   <label>Remarks: </label>
								   <textarea id="remark" name="remark" class="form-control"></textarea>
                                   <span style="color:red;"><?php echo form_error('remark');?></span>
                                </div>								 	
                                    <div class="col-sm-4">
                                   <label>Cheque Copy:</label>
									<input type="file" id="cheque_file" name="cheque_file" class="form-control" />
                                   <span style="color:red;"><?php echo form_error('cheque_file');?></span>
                                </div>									
							</div>
							<div class="form-group" ></div>
							 <div class="form-group" id="guide">
                                    <div class="col-sm-2">
                                       <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>
                                    </div>                                    
                                    <div class="col-sm-2"><button class="btn btn-primary form-control" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/account_phd_renum'">Cancel</button></div>
                                </div>								
							   </div>	
                            </form>
                        </div>
                    </div>
                </div>
            </div>			
        </div>
    </div>   
<script type="text/javascript">
$(document).ready(function () {
$('#cheq_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});
});
</script>
                                