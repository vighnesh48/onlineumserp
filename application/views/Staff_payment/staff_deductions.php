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
  $(document).ready(function() {
        $('.groupOfTexbox').keypress(function (event) {
            return isNumber(event, this)
        });
    });
	function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57) && (charCode != 8))
            return false;

        return true;
    }    
</script>


<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Add and Deduction List </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add and Deduction List </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
               
                        <div class="table-info">
                               <span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>
                                                  
                                                               
                             <div id="dashboard-recent" class="panel-warning">   
                               
									 
									 <div class="panel panel-warning">
              <div class="panel-heading">              <div class="row">
<div class="col-md-6 text-left">
For <strong><?php echo $month_name." ".$year_name; ?>
								</strong>
</div>
<div class="col-md-6 text-left">
								<label class="col-md-5">Select Month And Year</label>
								  <form id="form" name="form" action="<?=base_url($currentModule.'/staff_deductions')?>" method="POST" >
							
								<input id="dob-datepicker" required class="date-picker" name="attend_date" value="" placeholder="Month & Year" type="text">

                        
                          <input type="submit" class="btn btn-primary btn-xs col-md-2 pull-right" name="submit" value="View">
                        </form>            
</div>
</div>							


								</div>
								
								
								<!--table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011/07/25</td>
                <td>$170,750</td>
            </tr>

        </tbody>
        
    </table-->
								
								<?php //echo $ins;
if($ma=='1'){
								if(!empty($emp_deduction)){?>
                                <div class="panel-body" style="height:800px;overflow-y:scroll;">
								  <div class="form-group" >
								  <button class="btn btn-primary" id="btnExport">Export</button>
								  <form id="form" name="form" action="<?=base_url($currentModule.'/add_staff_deductions')?>" method="POST" >
								 <input type="hidden" name="for_month_year" value="<?=$dt1?>">
								  <table cellpadding="0" cellspacing="0" style="font-size:12px;border:1px solid;width:100%;" id='eduDetTable1' class="table tabsal">
								  <tr bgcolor="#9ed9ed" style="border: 1px solid black;">
 <td style="border: 1px solid black;" colspan="3"></td>
  <td style="border: 1px solid black;text-align:center;" colspan="6"><b>Deduction</b></td>
   <td style="border: 1px solid black;text-align:center;" colspan="2"><b>Add</b></td>
								  </tr>
								  <tr bgcolor="#9ed9ed" style="border: 1px solid black;">
	                              <td style="border: 1px solid black;">Sr No.</td>
	                              <td style="border: 1px solid black;">Staff Id</td>
	                              <td style="border: 1px solid black;">Staff Name</td>
	                              <td style="border: 1px solid black;">TDS</td>
	                              <td style="border: 1px solid black;">Mobile Bill</td>
								  <td style="border: 1px solid black;">Bus-fare</td>
								 
	                              <td style="border: 1px solid black;">Office Advance</td>
	                               <td style="border: 1px solid black;">CoOpSoc</td>
	                              <td style="border: 1px solid black;">Other Deductions</td>
								  <td style="border: 1px solid black;">Difference</td>
								  <td style="border: 1px solid black;">Arrears</td>
	                              </tr>
								  <?php $i=0;$j=0;		
//print_r($emp_deduction);		
if($ins =='1' || $ins == '2'){						  
if($ins =='2'){
	$in = 'get_transaction_detail_amount';
}else{
	$in = 'get_deduction_amount';
}				  
								  foreach($emp_deduction as $key=>$val){									
									 echo"<tr style='border: 1px solid black;'>";
									  echo"<td style='border: 1px solid black;'>".++$i."</td>";										 
                                      echo"<td style='border: 1px solid black;'><input readonly type='hidden' name='ins[".$j."][emp_id]' value='".$emp_deduction[$key]['emp_id']."' >".$emp_deduction[$key]['emp_id']."</td>";
									  echo"<td style='border: 1px solid black;'>"; if($emp_deduction[$key]['gender']=='male'){echo 'Mr.';}else if($emp_deduction[$key]['gender']=='female'){ echo 'Mrs.';} echo $emp_deduction[$key]['fname']." ".$emp_deduction[$key]['mname']." ".$emp_deduction[$key]['lname']."</td>";
									  echo"<td style='border: 1px solid black;'><input class='groupOfTexbox' type='text' name='ins[".$j."][TDS]'  value='".$this->Staff_payment_model->$in($emp_deduction[$key]['emp_id'],'TDS',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input class='groupOfTexbox' type='text' name='ins[".$j."][Mobile_Bill]' value='".$this->Staff_payment_model->$in($emp_deduction[$key]['emp_id'],'Mobile_Bill',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input class='groupOfTexbox' type='text' name='ins[".$j."][Bus-fare]' value='".$this->Staff_payment_model->$in($emp_deduction[$key]['emp_id'],'Bus-fare',$dt1)."' placeholder=''></td>";

									  echo"<td style='border: 1px solid black;'><input class='groupOfTexbox' type='text' name='ins[".$j."][Off_Adv]' value='".$this->Staff_payment_model->$in($emp_deduction[$key]['emp_id'],'Off_Adv',$dt1)."' placeholder=''></td>";
									 echo"<td style='border: 1px solid black;'><input type='text' name='ins[".$j."][Society_Charg]' value='".$this->Staff_payment_model->$in($emp_deduction[$key]['emp_id'],'Society_Charg',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input class='groupOfTexbox' type='text' name='ins[".$j."][Other_Deduct]' value='".$this->Staff_payment_model->$in($emp_deduction[$key]['emp_id'],'Other_Deduct',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input class='groupOfTexbox' type='text' name='ins[".$j."][Difference]' value='".$this->Staff_payment_model->$in($emp_deduction[$key]['emp_id'],'Difference',$dt1)."' placeholder=''></td>";
									  echo"<td style='border: 1px solid black;'><input class='groupOfTexbox' type='text' name='ins[".$j."][Arrears]' value='".$this->Staff_payment_model->$in($emp_deduction[$key]['emp_id'],'Arrears',$dt1)."' placeholder=''></td>";
									  
									  //echo"<td><input type='hidden' name='ins[".$emp_deduction[$key]['emp_id']."][for_month_year]' value='".$ysearch."-".$msearch."-"."01"."' placeholder=''></td>";
									 // echo"<td><input type='hidden' name='ins[".$j."][inserted_by]' value='".$this->session->userdata('uid')."' placeholder=''></td>";
									  //echo"<td><input type='hidden' name='ins[".$j."][inserted_date]' value='".date('Y-m-d h:i:s')."' placeholder=''></td>";
									 echo"</tr>";
									$j++; 
								  } 
}else{
	//print_r($emp_deduction);		
	 $emp_arr = array();	
	 foreach($emp_deduction as $key=>$val){	
$emp_arr[$emp_deduction[$key]['emp_id']][] = $val ;
//print_r($emp_arr[$emp_deduction[$key]['emp_id']]);
	 }
			foreach($emp_arr as $val){
				//echo $val[0]['emp_id'];
									 echo"<tr style='border: 1px solid black;'>";
									  echo"<td style='border: 1px solid black;'>".++$i."</td>";										 
                                      echo"<td style='border: 1px solid black;'>".$val[0]['emp_id']."</td>";
									  echo"<td style='border: 1px solid black;'>"; if($val[0]['gender']=='male'){echo 'Mr.';}else if($val[0]['gender']=='female'){ echo 'Mrs.';} echo $val[0]['fname']." ".$val[0]['mname']." ".$val[0]['lname']."</td>";
									  echo"<td style='border: 1px solid black;'>".$this->Staff_payment_model->get_transaction_detail_amount($val[0]['emp_id'],'TDS',$dt1)."</td>";
									  echo"<td style='border: 1px solid black;'>".$this->Staff_payment_model->get_transaction_detail_amount($val[0]['emp_id'],'Mobile_Bill',$dt1)."</td>";
									  echo"<td style='border: 1px solid black;'>".$this->Staff_payment_model->get_transaction_detail_amount($val[0]['emp_id'],'Bus-fare',$dt1)."</td>";
									  echo"<td style='border: 1px solid black;'>".$this->Staff_payment_model->get_transaction_detail_amount($val[0]['emp_id'],'Off_Adv',$dt1)."</td>";
									  echo"<td style='border: 1px solid black;'>".$this->Staff_payment_model->get_transaction_detail_amount($val[0]['emp_id'],'Society_Charg',$dt1)."</td>";
									  echo"<td style='border: 1px solid black;'>".$this->Staff_payment_model->get_transaction_detail_amount($val[0]['emp_id'],'Other_Deduct',$dt1)."</td>";
									  echo"<td style='border: 1px solid black;'>".$this->Staff_payment_model->get_transaction_detail_amount($val[0]['emp_id'],'Difference',$dt1)."</td>";
									  echo"<td style='border: 1px solid black;'>".$this->Staff_payment_model->get_transaction_detail_amount($val[0]['emp_id'],'Arrears',$dt1)."</td>";
									  
									  //echo"<td><input type='hidden' name='ins[".$emp_deduction[$key]['emp_id']."][for_month_year]' value='".$ysearch."-".$msearch."-"."01"."' placeholder=''></td>";
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
								   <?php if(in_array("Add",$my_privileges)){ ?>
								 <?php if($ins =='1' || $ins=='2'){?>
								   <div class="form-group">
								   <div class="col-md-3" ></div>
                                      <div class=" col-md-2">  
                                           <!-- <input type="submit" class="btn btn-primary form-control" name="save" value="Save Staff Income Detail">-->
										<?php if($ins=='1'){ ?>
											<button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Save </button>
                                        <?php }else{ ?>
											<button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Update </button>
											
											<?php } ?>
                                        </div>
                                        <?php }} ?>
										</form>
										<?php	if($ins !='3'){ ?>
										 <form id="formf" name="formf" onsubmit="return confirm('Are you sure you want to final save this month salary?');"  action="<?=base_url($currentModule.'/save_final_staff_deductions')?>" method="POST" >
							
                                       <div class=" col-md-2">  
									   <input type="hidden" name="sdate" value="<?php echo $dt1; ?>" />
                                            <input type="submit" class="btn btn-primary form-control" name="finals" value="Final save">
                                        </div>
										 </form>
									<?php } ?>
                                       <!--<div class=" col-md-2">  
                                            <input type="submit" class="btn btn-primary form-control" name="cancel" value="cancel">
                                        </div> -->
                                    </div>
                                    
								  
								  
								</div>
								</div>
									 <?php }elseif(empty($emp_deduction)){
										 if(!empty($month_name)){
										echo"<span><label style='color:red'>No Staff Deduction Details available for  ".$month_name.$year_name."</label></span>"; 
									 } }}else{
									 	 if(!empty($month_name)){
									 	echo"<span><label style='color:red;text-align:center;margin-left:35%;'>Attendance is not submitted for  ".$month_name." ".$year_name."</label></span>"; 
									 	}
									 	}?>
									</div>                       
                </div>
            </div>    
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
<script>
$(document).ready(function() {
    $('#eduDetTable1').DataTable( {
        dom: 'Bfrtip',
     "bPaginate": false,
        buttons: [
            
            'excelHtml5',
            
            'pdfHtml5'
        ]
    } );
       
} );
</script>

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
		    window.open('data:application/vnd.ms-excel,' + $('#eduDetTable1').html());
    e.preventDefault();
});   
});

</script>