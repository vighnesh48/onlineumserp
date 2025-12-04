<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="<?=site_url()?>assets/javascripts/jspdf/jspdf.js" type="text/javascript"></script>

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
.tabsal td>input{
	width:100%;
}
</style>
<script>
 /* $(document).ready(function()
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
                attend_date:
                {
                    validators: 
                    {
                      notEmpty: 
                      {
                       message: 'Select month'
                      }
                    }
                }
            }       
        })
		
}); */
  
</script>


<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Salary Status </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Salary Status </h1>
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
                            	<div class="panel-heading"><strong>Add/View Salary Status </strong></div>
                                <div class="panel-body">
								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                <div class="panel-padding no-padding-vr">
                            <div class="form-group">
                              <div class="row"></div>
							  <div class="portlet-body form">
							  <form id="form" name="form" action="<?=base_url($currentModule.'/salary_status')?>" method="POST" >
								<div class="form-body">
								
                                <div class="form-group">
								<label class="col-md-3">Select Month And Year</label>
                                             <div class="col-md-3" >
                          <input id="dob-datepicker" required class="form-control form-control-inline  date-picker" name="attend_date" value="" placeholder="Month & Year" type="text">

                                             </div>
											 <div class=" col-md-2">  
                                            <input type="submit" class="btn btn-primary form-control" name="submit" value="View ">
                                        </div> 
                                  </div>
                                   
                            </div>
                                    </form>
									</div>
									 </div>
							   </div>
                                </div>
                            </div>
									 <?php if(!empty($emp_sal)){?>
									 <div class="panel">
              <div class="panel-heading text-center"><strong>Staff Deduction <?php //if(isset($fordepart) && isset($forschool)){echo $fordepart.'Department['.$forschool."]"; } else{ unset($forschool);unset($fordepart);echo "All Deartment and All School";}?> For 
								<?php echo $month_name." ".$year_name;
                               /*  $d = date_parse_from_format("Y-m-d", $inc_dt);
								//print_r($d);
								$msearch=$d["month"];
							$month_name = date("F", mktime(0, 0, 0, $msearch, 10));
                                $ysearch=$d["year"];
								 */?>
								</strong></div>
                                <div class="panel-body" style="height:800px;overflow-y:scroll;">
								  <div class="form-group" >
								  <form id="form" name="form" action="<?=base_url($currentModule.'/add_staff_deductions')?>" method="POST" >
								 <input type="hidden" name="for_month_year" value="<?=$dt1?>">
								  <table cellpadding="0" cellspacing="0" style="font-size:12px;border:1px solid;width:100%;" class="table tabsal">
								  <tr bgcolor="#9ed9ed" style="border: 1px solid black;">
	                              <td style="border: 1px solid black;">Sr No.</td>
	                              <td style="border: 1px solid black;">Staff Id</td>
	                              <td style="border: 1px solid black;">Staff Name</td>
	                              <td style="border: 1px solid black;">TDS</td>
	                              <td style="border: 1px solid black;">Mobile Bill</td>
								  <td style="border: 1px solid black;">Bus-fare</td>
	                              <td style="border: 1px solid black;">Office Advance</td>
	                              <td style="border: 1px solid black;">Other Deductions</td>
								  <td style="border: 1px solid black;">Difference</td>
								  <td style="border: 1px solid black;">Arrears</td>
	                              </tr>
								  <?php $i=0;$j=0;		
//print_r($emp_sal);		
if($ins =='1'){						  
								  foreach($emp_sal as $key=>$val){									
									 echo"<tr style='border: 1px solid black;'>";
									  echo"<td style='border: 1px solid black;'>".++$i."</td>";										 
                                      echo"<td style='border: 1px solid black;'><input readonly type='hidden' name='ins[".$j."][emp_id]' value='".$emp_sal[$key]['emp_id']."' >".$emp_sal[$key]['emp_id']."</td>";
									  echo"<td style='border: 1px solid black;'>"; if($emp_sal[$key]['gender']=='male'){echo 'Mr.';}else if($emp_sal[$key]['gender']=='female'){ echo 'Mrs.';} echo $emp_sal[$key]['fname']." ".$emp_sal[$key]['mname']." ".$emp_sal[$key]['lname']."</td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][TDS]'  value='".$this->Staff_payment_model->get_deduction_amount($emp_sal[$key]['emp_id'],'TDS',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Mobile_Bill]' value='".$this->Staff_payment_model->get_deduction_amount($emp_sal[$key]['emp_id'],'Mobile_Bill',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Bus-fare]' value='".$this->Staff_payment_model->get_deduction_amount($emp_sal[$key]['emp_id'],'Bus-fare',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Off_Adv]' value='".$this->Staff_payment_model->get_deduction_amount($emp_sal[$key]['emp_id'],'Off_Adv',$dt1)."' placeholder=''></td>";
									 // echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Society_Charg]' value='".$this->Staff_payment_model->get_deduction_amount($emp_sal[$key]['emp_id'],'Society_Charg',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Other_Deduct]' value='".$this->Staff_payment_model->get_deduction_amount($emp_sal[$key]['emp_id'],'Other_Deduct',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Difference]' value='".$this->Staff_payment_model->get_deduction_amount($emp_sal[$key]['emp_id'],'Difference',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Arrears]' value='".$this->Staff_payment_model->get_deduction_amount($emp_sal[$key]['emp_id'],'Arrears',$dt1)."' placeholder=''></td>";
									  
									  //echo"<td><input type='hidden' name='ins[".$emp_sal[$key]['emp_id']."][for_month_year]' value='".$ysearch."-".$msearch."-"."01"."' placeholder=''></td>";
									 // echo"<td><input type='hidden' name='ins[".$j."][inserted_by]' value='".$this->session->userdata('uid')."' placeholder=''></td>";
									  //echo"<td><input type='hidden' name='ins[".$j."][inserted_date]' value='".date('Y-m-d h:i:s')."' placeholder=''></td>";
									 echo"</tr>";
									$j++; 
								  } 
}else{
	//print_r($emp_sal);		
	 foreach($emp_sal as $key=>$val){									
									 echo"<tr style='border: 1px solid black;'>";
									  echo"<td style='border: 1px solid black;'>".++$i."</td>";										 
                                      echo"<td style='border: 1px solid black;'><input readonly type='hidden' name='ins[".$j."][emp_id]' value='".$emp_sal[$key]['emp_id']."' >".$emp_sal[$key]['emp_id']."</td>";
									  echo"<td style='border: 1px solid black;'>"; if($emp_sal[$key]['gender']=='male'){echo 'Mr.';}else if($emp_sal[$key]['gender']=='female'){ echo 'Mrs.';} echo $emp_sal[$key]['fname']." ".$emp_sal[$key]['mname']." ".$emp_sal[$key]['lname']."</td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][TDS]'  value='".$this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'TDS',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Mobile_Bill]' value='".$this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Mobile_Bill',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Bus-fare]' value='".$this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Bus-fare',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Off_Adv]' value='".$this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Off_Adv',$dt1)."' placeholder=''></td>";
									 // echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Society_Charg]' value='".$this->Staff_payment_model->get_deduction_amount($emp_sal[$key]['emp_id'],'Society_Charg',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Other_Deduct]' value='".$this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Other_Deduct',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Difference]' value='".$this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Difference',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Arrears]' value='".$this->Staff_payment_model->get_transaction_detail_amount($emp_sal[$key]['emp_id'],'Arrears',$dt1)."' placeholder=''></td>";
									  
									  //echo"<td><input type='hidden' name='ins[".$emp_sal[$key]['emp_id']."][for_month_year]' value='".$ysearch."-".$msearch."-"."01"."' placeholder=''></td>";
									 // echo"<td><input type='hidden' name='ins[".$j."][inserted_by]' value='".$this->session->userdata('uid')."' placeholder=''></td>";
									  //echo"<td><input type='hidden' name='ins[".$j."][inserted_date]' value='".date('Y-m-d h:i:s')."' placeholder=''></td>";
									 echo"</tr>";
									$j++; 
								  } 
	
}  
								  
								  ?>
								  </table>
								  </div>
								  <br>
								   <div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-3">  
                                           <!-- <input type="submit" class="btn btn-primary form-control" name="save" value="Save Staff Income Detail">-->
											<button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Save Staff Deductions </button>
                                        </div>
                                       <!--<div class=" col-md-2">  
                                            <input type="submit" class="btn btn-primary form-control" name="cancel" value="cancel">
                                        </div> -->
                                    </div>
								  </form>
								  
								</div>
								</div>
									 <?php }elseif(empty($emp_sal)){
										 if(!empty($month_name)){
										echo"<span><label style='color:red'>No Staff Deduction Details available for  ".$month_name.$year_name."</label></span>"; 
									 } }?>
									</div>                          
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
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
});
</script>


