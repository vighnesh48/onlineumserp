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
.col-md-6,.col-md-4,.col-md-3{xxxpadding:0px;}
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
			 row: {
        valid: 'field-success',
        invalid: 'field-error'
    },
            fields: 
            {
                  basic_sal:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Value should be numeric'
                      }
                    }
                }, pay_band_min:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Value should be numeric'
                      }
                    }
                }, pay_band_max:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Value should be numeric'
                      }
                    }
                }, pay_band_gt:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9/]+$/,
                        message: 'Value should be numeric'
                      }
                    }
                }, staff_da:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9]\d*(\.\d+)?$/,
                        message: 'Value should be numeric'
                      }
                    }
                },staff_hra:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9]\d*(\.\d+)?$/,
                        message: 'Value should be numeric',
						 decimalSeparator: '.'
                      }
                    }
                }, staff_ta:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9]\d*(\.\d+)?$/,
                        message: 'Value should be numeric'
                      }
                    }
                }, staff_indiff:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9]\d*(\.\d+)?$/,
                        message: 'Value should be numeric'
                      }
                    }
                }, special_allowance:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9]\d*(\.\d+)?$/,
                        message: 'Value should be numeric'
                      }
                    }
                }, other_allowance:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9]\d*(\.\d+)?$/,
                        message: 'Value should be numeric'
                      }
                    }
                }, staff_otherincm:
                {
                    validators: 
                    {
                      regexp: 
                      {
                        regexp: /^[0-9]\d*(\.\d+)?$/,
                        message: 'Value should be numeric'
                      }
                    }
                }

				
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
        <li><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#"> Salary Structure Details </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Salary Structure Details </h1>
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
                
                        <div class="table-info">                                    
                                                               
                             <div id="dashboard-recent" class="panel-warning">   
                               <div class="panel">
                            	<div class="panel-heading"><strong> Salary Structure Details </strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/staff_basic_salarydetails')?>" method="POST">
							    <?php if(!empty($emp_basic_sal_info)){ //print_r($emp_basic_sal_info);?>
								
								<input type="hidden" name="inupdate" value="1">
								<input type="hidden" name="sal_structure_id" value="<?php echo $emp_basic_sal_info[0]['sal_structure_id'];?>">
                                				                             
								<?php } ?>							
								<div class="form-body">
								<div class="col-md-4">
								<div class="form-group">
								<label class="col-md-4 text-right">Name :</label>
                                             <div class="col-md-8" >
											 <label ><b><?php if($emp_basic_sal_info[0]['gender']=='male'){echo 'Mr.';}else if($emp_basic_sal_info[0]['gender']=='female'){ echo 'Mrs.';} echo $emp_basic_sal_info[0]['fname']." ".$emp_basic_sal_info[0]['lname']; ?></b></label>
												</div>
                                  </div>
								  <div class="form-group">
								<label class="col-md-4  text-right">Designation:</label>
        										<div class="col-md-8">
      <label ><b><?php echo $emp_basic_sal_info[0]['designation_name']; ?></b></label>
										</div>
                                  </div>
								 
								   </div>
								  <div class="col-md-4">
								  <div class="form-group">
								<label class="col-md-4 text-right">Emp ID :</label>
                                             <div class="col-md-8" >
											 <input type="hidden" name="emp_id" value="<?php echo $emp_basic_sal_info[0]['em_emp_id']; ?>" />
											<label><b><?php echo $emp_basic_sal_info[0]['em_emp_id']; ?></b></label>
												</div>
                                  </div>
								  <div class="form-group">
								<label class="col-md-4 text-right">School :</label>
                                             <div class="col-md-8" >
											 <label ><b><?php echo $emp_basic_sal_info[0]['college_name']; ?></b></label>
												</div>
                                  </div>								  								   
								   </div>	
<div class="col-md-4">
 <div class="form-group">
								<label class="col-md-6 text-right">Date Of Joining :</label>
                                             <div class="col-md-6" >
											  <label ><b><?php echo date('m-d-Y',strtotime($emp_basic_sal_info[0]['joiningDate'])); ?></b></label>
												</div>
										</div>		
								<label class="col-md-6 text-right">Department :</label>
        										<div class="col-md-6">
      <label><b><?php echo $emp_basic_sal_info[0]['department_name']; ?></b></label>
											
                                       </div>                                  
                                  </div>
								   
                                <div class="form-group">
								<!--For salary cal info -->
					<div class="clearfix" id="basic_sal_module" >
        			        			<div class="row ">
        				<div class="col-md-12 col-sm-12">
        					<div class="portlet box red-sunglo">
        						<div class="portlet-title">
        							<div class="caption">
        								<i class="fa fa-inr"></i> Salary Structure Details  
        							</div>

        						</div>
        						<div class="portlet-body row">								
								<div class="col-md-6">
								<div class="form-group">
								<label class="col-sm-6">Scale Type:</label>
        										<div class="col-sm-6">
												<select onchange="remove_fields(this.value);" class="col-sm-6 form-control" id="scaletype" name="scaletype">
												<option <?php if($emp_basic_sal_info[0]['scaletype']=='scale'){echo 'selected';} ?> value="scale">Scale</option>
    									<option <?php if($emp_basic_sal_info[0]['scaletype']=='consolidated'){echo 'selected';} ?> value="consolidated">Consolidated</option>
    							</select>
										</div>
										</div>
								 			
								 
								  <div class="form-group">
								<label class="col-sm-6 ">Pay Band Min:</label>
        										<div class="col-sm-6">
      <input type="text" name="pay_min" id="pay_min" class="form-control" value="<?php echo $emp_basic_sal_info[0]['pay_band_min']; ?>" />
										</div>
										</div>
										<div class="form-group">
										<label class="col-sm-6 ">Pay Band Max:</label>
        										<div class="col-sm-6">
      <input type="text" name="pay_max" id="pay_max"   class="form-control" value="<?php echo $emp_basic_sal_info[0]['pay_band_max']; ?>" />
										</div>
                                  </div>
								  <div class="form-group">
								<label class="col-sm-6 ">Pay Band AGP:</label>
        										<div class="col-sm-6">
      <input type="text" name="pay_band_gt" id="pay_band_gt"  class="form-control" value="<?php echo $emp_basic_sal_info[0]['pay_band_gt']; ?>" />
										</div>
										</div>
										<div class="form-group">
                <label class="col-sm-6">Basic Salary:</label>
                            <div class="col-sm-6">
      <input type="text" name="basic_sal" id="basic_sal"  onblur="calculate_gross_amt();" class="form-control" value="<?php echo $emp_basic_sal_info[0]['basic_sal']; ?>" />
                    </div>
                    </div>
								  
								</div>
								
								<div class="col-md-6">
								
								<div class="form-group">
								<label class="col-sm-6">Dearness Allowance(DA)%</label>
                                 <div class="col-sm-4">											
                                      <input type="text" onblur="calculate_gross_amt();cal_val(this.value,'da_e');" class="form-control" id="staff_da" name="staff_da" value="<?=isset($emp_basic_sal_info[0]['da'])?$emp_basic_sal_info[0]['da']:''?>"  required>											
        								</div><div class="col-sm-2"><span id="da_e"></span></div>
										</div>
								<div class="form-group">
								<label class="col-sm-6">House Rent Allowance(HRA)%</label>
                                 <div class="col-sm-4">											
                                      <input type="text" onblur="calculate_gross_amt();cal_val(this.value,'hra_e');" class="form-control" id="staff_hra" name="staff_hra" value="<?=isset($emp_basic_sal_info[0]['hra'])?$emp_basic_sal_info[0]['hra']:''?>"  required>											
        								</div><div class="col-sm-2"><span id="hra_e"></span></div>
										</div>
										<div class="form-group">
								<label class="col-sm-6">Transport Allowance(TA)</label>
                                 <div class="col-sm-4">											
                                      <input type="text" onblur="calculate_gross_amt();" class="form-control" id="staff_ta" name="staff_ta" value="<?=isset($emp_basic_sal_info[0]['ta'])?$emp_basic_sal_info[0]['ta']:''?>"  required>											
        								</div><div class="col-sm-2"></div>
</div>
								
										<div class="form-group">
								<label class="col-sm-6">Other Allowance</label>
                                 <div class="col-sm-4">											
                                      <input type="text" class="form-control" onblur="calculate_gross_amt();" id="staff_otherincm" name="staff_otherincm" value="<?=isset($emp_basic_sal_info[0]['other_allowance'])?$emp_basic_sal_info[0]['other_allowance']:''?>" >											
        								</div>	<div class="col-sm-2"></div>
										</div>
								
										<div class="form-group">
								<label class="col-sm-6">Special Allowance</label>
                                 <div class="col-sm-4">											
                                      <input type="text" class="form-control" onblur="calculate_gross_amt();" id="special_allowance" name="special_allowance" value="<?=isset($emp_basic_sal_info[0]['special_allowance'])?$emp_basic_sal_info[0]['special_allowance']:''?>" >											
        								</div><div class="col-sm-2"></div>
										</div>
										<div class="form-group">
										<label class="col-sm-6">Gross Salary:</label>
        										<div class="col-sm-4">
      <input type="text" name="gross_salary" readonly id="gross_salary"  class="form-control" value="<?php echo $emp_basic_sal_info[0]['gross_salary']; ?>" />
										</div><div class="col-sm-2"></div>
                                  </div>
								
								</div>							
										<?php if(!empty($emp_basic_sal_info[0]['sal_structure_id'])){/*$emp_basic_sal_info[0]['basic_sal']==0*/?>
										 <input type="hidden"  name="act_type" value="up" />											
        							
										<?php }else{?>
										 <input type="hidden"  name="act_type" value="iup" />	       							
										<?php } ?>
										 
								</div>							
						</div>
						</div>
						</div>
						</div>
						<!-- end for salary cal info-->	
						   </div>
						<div class="form-group">
								   <div class="col-md-3" >
								   <div class=" col-md-3">  
										<a href="<?=base_url()?>staff_payment/staff_basic_salary_increment/<?=$emp_basic_sal_info[0]['em_emp_id'];?>" title="" class="btn btn-primary " target="_blank">Increment</a>
                                        </div>
								   </div>
								    <div class=" col-md-3">  
                                            <input type="submit" name="up_basic_submit" class="btn btn-primary form-control" value="Submit">
                                        </div>
                                      <div class=" col-md-3">  
                                            <input type="button" name="basic_submit" onclick="window.location='<?=base_url($currentModule)?>/staff_basic_salary_details_list'" class="btn btn-primary form-control" value="Cancel">
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
    
<script type="text/javascript">
remove_fields('<?php echo $emp_basic_sal_info[0]['scaletype'];?>');
function remove_fields(sc){
	if(sc=='consolidated'){
		$('#staff_da').prop('disabled',true);
		$('#staff_hra').prop('disabled',true);	
	$('#staff_ta').prop('disabled',true);	
	// $('#staff_otherincm').prop('disabled',true);
	// $('#special_allowance').prop('disabled',true);	
	 $('#pay_band_gt').prop('disabled',true);
	 $('#pay_max').prop('disabled',true);
	 $('#pay_min').prop('disabled',true);
	
	 
	}else{
		$('#staff_da').prop('disabled',false);
		$('#staff_hra').prop('disabled',false);	
	$('#staff_ta').prop('disabled',false);	
	 $('#staff_otherincm').prop('disabled',false);
	 $('#special_allowance').prop('disabled',false);
	 $('#other_pay').prop('disabled',false);
	 $('#pay_band_gt').prop('disabled',false);
	 $('#pay_max').prop('disabled',false);
	 $('#pay_min').prop('disabled',false);
	 
	}
}
function cal_val(vl,id){
  //alert(vl);  
  var bs = $('#basic_sal').val();
  var da = ((parseInt(vl)/100)*parseInt(bs));
  $('#'+id).text(parseFloat(da));
}
function calculate_gross_amt(){
	var sch = $("#scaletype option:selected").val();
	if(sch=='scale'){
	var bs = $('#basic_sal').val();
	var staff_da = $('#staff_da').val();
	var staff_hra = $('#staff_hra').val();
	
	var staff_ta = $('#staff_ta').val();
	
	//var oth_pay = $('#other_pay').val();
	var oth_inc = $('#staff_otherincm').val();
	var spe_all = $('#special_allowance').val();
	var da = ((parseInt(staff_da)/100)*parseInt(bs));
	var hra = ((parseInt(staff_hra)/100)*parseInt(bs));


	$('#gross_salary').val('');
	//alert(parseFloat(da));alert(dp);alert(hra);
	var gtot = parseFloat(bs)+parseFloat(da)+parseFloat(hra)+parseFloat(staff_ta)+parseFloat(oth_inc)+parseFloat(spe_all);
	//alert(gtot);
	$('#gross_salary').val(Math.round(gtot));
}else{
	var bs = $('#basic_sal').val();
	var oth_inc = $('#staff_otherincm').val();
	var spe_all = $('#special_allowance').val();
	$('#gross_salary').val('');
	$('#gross_salary').val(parseFloat(bs)+parseFloat(oth_inc)+parseFloat(spe_all));

}
}
$(document).ready(function(){
	
	$('#dob-datepicker').datepicker( {format: "yyyy",startView: "years",minViewMode: "years",autoclose:true});
	var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
	$("#eduDetTable").on("click","input[name='addMore']", function(e){	
	//$("input[name='addMore']").on('click',function(){		
		//var content = $(this).parent().parent('tr').clone('true');
		$(this).parent().parent('tr').after(content);		
	});
	$("#eduDetTable").on("click","input[name='remove']", function(e){	
	//$("input[name='remove']").on('click',function(){
		var rowCount = $('#eduDetTable tbody tr').length;
		if(rowCount>1){
			$(this).parent().parent('tr').remove();
		}
	});	
	
	 $("#btnExport").click(function(e) {
		    window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
    e.preventDefault();
}); 

if($('#reporting_person').val()!=''){
	$('#basic_sal_module').show();
}
  
});

function allowForLeave(){
	if($('#reporting_person').val()!=''){
		$('#basic_sal_module').show();
	}else{
		$('#basic_sal_module').hide();
	}
	var em_emp_id=$('#reporting_person').val();
	var post_data=empl_id='';
   if(em_emp_id!=null){
				post_data+="&empl_id="+em_emp_id;				
			}
			
 jQuery.ajax({
				type: "POST",
				url: base_url+"admin/getjoiningdtEmp",
				data: encodeURI(post_data),
				success: function(data){
				//	alert(data);          
            $('#dj').html(data);
         
				}	
			});
	
}
</script>


