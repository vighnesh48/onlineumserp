<?php date_default_timezone_set('Asia/Kolkata'); ?>
<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
.attexl table{
	 border: 1px solid black;
}
.attexl table th{
 border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.attexl table td{
	 border: 1px solid black;
    padding: 5px;
}
.row{margin:0px;}

</style>
<script>
function search_emp_code(){
	//alert('gg');
	var post_data = $('#emp_id').val();
	$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>leave/get_emp_code/"+post_data,
				success: function(data){
				//	alert(data);          
            $('#emptab').html(data);         
				}	
			});	
}
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
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
            fields: 
            {
                   scaletype:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Alternate number should be numeric'
                      }
                    }
                }, basic_sal:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Basic Salary should be numeric'
                      }
                    }
                }, gross_salary:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Gross Salary should be numeric'
                      }
                    }
                }, allowance:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Allowance should be numeric'
                      }
                    }
                }, pay_band_min:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Pay Band Min should be numeric'
                      }
                    }
                }, pay_band_max:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Pay Band Max should be numeric'
                      }
                    }
                }, pay_band_gt:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Pay Band GT should be numeric'
                      }
                    }
                }			
				}       
        })
	});
	function insert_emp_id(emp,nme,sch,dep,des){
	//alert(emp);
	$('#emp_id').val(emp);
	$('#nameid').val(nme);
	$('#schoolid').val(sch);
	$('#departmentid').val(dep);
	$('#designationid').val(des);
	$("#etable").remove();
}
</script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Employee Monthly Deduction Update</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Monthly deduction Update</h1>
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
                    
                    <div class="panel-body">
                        <div class="table-info">                                    
                                                               
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong>Employee Monthly deduction Add</strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/emp_monthly_deduction_update_submit')?>" method="POST">
							        <input type="hidden" name="deduct_id" value="<?php echo $emp_deduction_details[0]['trans_id']; ?>" />
									<?php //print_r($emp_deduction_details); ?>	                         
								<div class="form-group">
								<label class="col-md-3 control-label">Deduction Of</label>
        										<div class="col-sm-4">
												<?php echo ucfirst($emp_deduction_details[0]['trans_of']); ?>
												<input type="hidden" name="deduct_of" value="<?php echo $emp_deduction_details[0]['trans_of']; ?>" />
										</div>
										</div>
								<?php  if(!empty($emp_deduction_details[0]['trans_type'])){ ?>
								<div class="form-group">
								<label class="col-md-3">Type</label>
        							<div class="col-sm-4">
								<?php  if($emp_deduction_details[0]['trans_type']=='CR'){ ?>
										 Credits
								<?php }elseif($emp_deduction_details[0]['trans_type']=='DC'){ ?>
											 Debits
								<?php } ?>
								<input type="hidden" name="deduct_typ" value="<?php echo $emp_deduction_details[0]['trans_type']; ?>" />
										</div>
										</div>
										<?php } 
										if(!empty($emp_deduction_details[0]['emp_id'])){ ?>
																		
										<div class="form-group">
								<label class="col-md-3">Employee Id</label>
        										<div class="col-sm-6">
										<?php echo $emp_deduction_details[0]['emp_id'];?>
										<input type="hidden" name="emp_id" value="<?php echo $emp_deduction_details[0]['emp_id']; ?>" />
									</div>
										</div>
										<?php } ?>
								<div class="form-group">
								<label class="col-md-3">Employee Name</label>
										<div class="col-sm-6">
										<?php 
										if($emp_deduction_details[0]['gender']=='male'){echo 'Mr.';}else if($emp_deduction_details[0]['gender']=='female'){ echo 'Mrs.';}
										echo $emp_deduction_details[0]['fname']." ".$emp_deduction_details[0]['lname']; ?>
										</div>
										</div>
							<div class="form-group">
								<label class="col-md-3">Amount</label>
        										<div class="col-sm-4">
											<input type="text"  name="deduct_amt" required class="form-control" value="<?php echo $emp_deduction_details[0]['amount']; ?>"/>																				
											</div>
										</div>
										<div class="form-group">
								<label class="col-md-3">Frequency</label>
        										<div class="col-sm-4">
											<?php if($emp_deduction_details[0]['frequency']==1){?>
												One Time
											<?php }elseif($emp_deduction_details[0]['frequency']==2){?>
												Monthly
												<?php } ?>
												<input type="hidden" name="frequency" value="<?php echo $emp_deduction_details[0]['frequency']; ?>" />
									
											</div>
										</div>
											<div class="form-group">
								<label class="col-md-3">Valid From</label>
        										<div class="col-sm-4">
										<?php echo date('M-Y',strtotime($emp_deduction_details[0]['valid_from'])); ?>												
    										<input type="hidden" name="vfmonth" value="<?php echo date('m',strtotime($emp_deduction_details[0]['valid_from'])); ?>" />
											<input type="hidden" name="vfyear" value="<?php echo date('Y',strtotime($emp_deduction_details[0]['valid_from'])); ?>" />
											</div>
										</div>
											<?php if($emp_deduction_details[0]['frequency']==2){?>
											<div class="form-group">
								<label class="col-md-3">Valid To</label>
        										<div class="col-sm-4">											
											<?php echo date('M-Y',strtotime($emp_deduction_details[0]['valid_to'])); ?>												
    									<input type="hidden" name="vtmonth" value="<?php echo date('m',strtotime($emp_deduction_details[0]['valid_to'])); ?>" />
											<input type="hidden" name="vtyear" value="<?php echo date('Y',strtotime($emp_deduction_details[0]['valid_to'])); ?>" />
										
											</div>
										</div>
											<?php } ?>
								<div class="form-group">
								<label class="col-md-3">Cancel</label>
        										<div class="col-sm-4">											
																						
    									<input type="checkbox" name="dis_status" value="Y" />
											
											</div>
										</div>
								
						<!-- end for salary cal info-->	
						   
						<div class="form-group">
								   <div class="col-md-3" ></div>
								    <div class=" col-md-3">  
                                            <input type="submit" name="up_basic_submit" class="btn btn-primary form-control" value="Update">
                                        </div>
									
                                      <div class=" col-md-3">  
                                            <input type="button" name="basic_submit" onclick="window.location='<?=base_url($currentModule)?>/emp_monthly_deduction_list'" class="btn btn-primary form-control" value="Cancel">
                                        </div>
									
                                    </div>
                               
				                                                                               

                                  
                            </div>
                                    </form>
									</div>
								</div>					

    </div>
							   </div>
                                </div>
                            </div> 
                          </div>                          
                           
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">
function check_all(){
	  if($('input:checkbox[name="emp_chk_all"]').prop("checked")) {
	$('input:checkbox[name="emp_chk[]"]').prop('checked', true);
	 } else {
     $('input:checkbox[name="emp_chk[]"]').prop('checked', false);
            }    
}
$(document).ready(function(){
	    $("#valide_from22").datepicker({
        todayBtn:  1,
        autoclose: true,
		startView: 'month',
		format: 'mm/yyyy'
    }); 
	$("#deduct_typ").change(function () {
		//alert('dd');
           var dtyp = $(this).val();
		   var arr = ["mobile","tds" ];
		   if($.inArray( $(this).val(), arr ) < 0){
			   //alert('dd');
			   $('#frm2').hide();
			   $('#frm1').show();
			   
		   }else{
			   $('#frm1').hide();
			    $('#frm2').show();
		   }
		   });
		   
		   $('input:radio[name="deduct_typ"]').change(function(){
    if($(this).val() == 'I'){
       $('#empinfo').show();
    }else{
		$('#empinfo').hide();
	}
});
});
</script>


