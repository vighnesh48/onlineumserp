<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
    input.editable {
        background-color: #fff8dc;
        border: 1px solid #d1a300;
    }
</style>
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

th, td { white-space: nowrap;  }
td>input { white-space: nowrap;width:100%;padding:2px 3px }
element {
    width: 19.2333px;
}
.table.table-bordered thead > tr > th {
    border-bottom: 0;
        border-bottom-color: currentcolor;
}
table.dataTable thead th{padding: 5px 30px;}
.cal-table tr th{padding:4px 20px!important;}
.header{
        position:sticky;
        top: 0 ;
    }
	.panel-body {
    padding: 0px!important;

</style>

<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Staff Payment</a></li>
        <li class="active"><a href="#">Staff Salary Details </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Staff Salary Details </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
            <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
<?php endif; ?>
        <div class="row ">
            <div class="col-sm-12">                
                        <div class="table-info">	 
									 <div class="panel panel-warning">
              <div class="panel-heading ">
              <div class="row">
<div class="col-md-6 text-left">
              <strong>Staff Salary For 
								<?php echo date("F", mktime(0, 0, 0, $month_name, 10))." ".$year_name; ?>
								</strong>
                            </div>
                            <div class="col-md-6 text-left">
								<label class="col-md-5">Select Month And Year</label>
								 <form id="form" name="form" action="<?=base_url($currentModule.'/visiting_staff_salary')?>" method="POST" >
							
								  <input id="ym-datepicker" required class="date-picker col-md-4" name="attend_date" value="<?=$attend_date?>" placeholder="Month & Year" type="text">
                        
                          <input type="submit" class="btn btn-primary btn-xs col-md-2 pull-right" name="submit" value="View">
                        </form>            
							</div>
							  </div>
								</div>
								<?php if(!empty($visit_sal)){?>
                                <div class="panel-body" style="height:450px;overflow:scroll;">
								  <form id="form" name="form" action="<?=base_url($currentModule.'/save_visiting_monthly_salary_data')?>" method="POST" >
								  <div class="form-group" >
								
								 <input type="hidden" id="dt1" name="for_month_year" value="<?=$dt1?>">
								<input type="hidden" id="dt2"  value="<?php  echo date('M Y',strtotime($dt1));?>">
								
								
								  <table  id="saltab" class="table table-bordered table-hover cal-table" width="100%"  style="font-size:12px;border:1px solid;">
								<thead style="position: sticky;top: 0" class="thead-dark">
								  <tr>
								   <th style="border: 1px solid black;text-align:center;font-size:15px;background-color:#66d566!important;" colspan="3" ><b>Staff Details</b></th>
									 <th style="border: 1px solid black;text-align:center;font-size:15px;background-color:#909ddf!important;" colspan="9" ><b>LectureWise Details</b></th>
									 <!--th style="border: 1px solid black;" colspan="1" ><b>Others</b></th-->
									 <th style="border: 1px solid black;text-align:center;font-size:15px;background-color:#800046!important;" colspan="1" ><b>Deductions</b></th>
									<th style="border: 1px solid black;text-align:center;" colspan="2" ><b>Others</b></th>
									 <th style="border: 1px solid black;text-align:center;font-size:15px;background-color:#66d566!important;" colspan="1" ><b>Earnings</b></th>
									 <th style="border: 1px solid black;text-align:center;font-size:15px;background-color:#d3d3d3!important;" colspan="5" ><b>Bank Details</b></th>

								  </tr>
								  <tr bgcolor="#9ed9ed" style="text-align:center;" >
	                              <th >Sr No.</th>
	                              <th >Staff Id</th>
	                              <th >Staff Name</th>
								  <th >Year-Month</th>
								  <!--th >No. Of Theory Lectures</th>
	                              <th >No.Of Practical Lectures</th-->
								  <th >No.Of Lectures Hours</th>
								  <!--th >TH Rate</th>
								  <th >PR Rate</th-->
								  <th >Total LectureWise Amount</th>
	                              <th >No.Of T.A Days</th>
	                              <th >Rate Of T.A</th>
	                              <th >T.A Amount</th>
	                              <th >Bill Amount</th>
	                              <th >TDS Amount</th>
	                              <th >Arrears</th>
	                              <th >Arrears TDS</th>
	                              <th >Net payable</th>
	                              <th >Bank A/c No.</th>
	                              <th >A/c Holder Name</th>
	                              <th >Bank Name</th>
	                              <th >Branch</th>
	                              <th >IFSC Code</th>
								  </tr>
								   </thead>
								   <tbody>
                             <?php $i=0;$j=1;$epf=0;$ptax=0;	
								//echo "kk".$flag;exit;
								//echo'<pre>';print_r($visit_sal);exit;
								$d=cal_days_in_month(CAL_GREGORIAN,$month_name,$year_name);
								 if($flag =='0'){
									  foreach($visit_sal as $key=>$val){

									  echo"<tr id='".$j."'>";
									  echo"<td >".++$i."</td>";										 
                                      echo"<td >".$visit_sal[$key]['emp_code']."</td>";
                                      echo"<td >".$visit_sal[$key]['fullname']."</td>";
                                      echo"<td >".$visit_sal[$key]['month_of_sal']."</td>";
                                     // echo"<td >".$visit_sal[$key]['th_count']."</td>";
                                     // echo"<td >".$visit_sal[$key]['pr_count']."</td>";
									  echo"<td >".$visit_sal[$key]['total_payable_hours']."</td>";
									 // echo"<td >".$visit_sal[$key]['th_amount']."</td>";
									 // echo"<td >".$visit_sal[$key]['pr_amount']."</td>";
									  echo"<td >".$visit_sal[$key]['total_lecturewise_amount']."</td>";
									  echo"<td >".$visit_sal[$key]['ta_days_count']."</td>";
									  echo"<td >".$visit_sal[$key]['rate_of_ta']."</td>";
									  echo"<td >".$visit_sal[$key]['ta_amount']."</td>";
                                      echo"<td >".$visit_sal[$key]['bill_amount']."</td>";
                                      echo"<td >".$visit_sal[$key]['tds_amount']."</td>";
                                      echo"<td >".$visit_sal[$key]['other_paid']."</td>";
                                      echo"<td >".$visit_sal[$key]['arrs_tds']."</td>";
                                      echo"<td >".$visit_sal[$key]['net_pay']."</td>";
                                      echo"<td >".$visit_sal[$key]['bank_acc_no']."</td>";
                                      echo"<td >".$visit_sal[$key]['acc_holder_name']."</td>";
                                      echo"<td >".$visit_sal[$key]['bank_name']."</td>";
                                      echo"<td >".$visit_sal[$key]['branch_name']."</td>";
                                      echo"<td >".$visit_sal[$key]['bank_ifsc']."</td>";
									  echo"</tr>";
									  $j++; 
										  
									  }
								 }else{

								  foreach($visit_sal as $key=>$val){
									  /*********salary calculation part**********/
									  
									 $mons = date('m',strtotime($dt1.'-01'));
									 $month = cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($dt1)),date('Y',strtotime($dt1)));
									 $ta_amount=round($visit_sal[$key]['ta_days_count']*$visit_sal[$key]['rate_of_ta']);
                                     $th_total_amount=round($visit_sal[$key]['tot_th_count']*$visit_sal[$key]['th_amount']);
                                     $pr_total_amount=round($visit_sal[$key]['tot_pr_count']*$visit_sal[$key]['pr_amount']);
                                   //  $bill_amount=round($th_total_amount+$pr_total_amount+$ta_amount);
								   
								     //$total_amount=round($visit_sal[$key]['total_payable']*$visit_sal[$key]['th_amount']); 
								    // $total_amount=round($th_total_amount+$pr_total_amount); 
								     $total_amount=round($visit_sal[$key]['subject_total_amount']); 
                                     $bill_amount=round($total_amount+$ta_amount);
                                     $tds_amount=round($bill_amount*0.1); /////10%of bill Amount 
									 $net_pay=round($bill_amount-$tds_amount);
									   
								  echo"<tr id='".$j."'>"; 
								  echo"<td >".++$i."</td>";										 
								  echo"<td ><input  type='hidden' name='ins[".$j."][emp_code]' value='".$visit_sal[$key]['emp_code']."'>".$visit_sal[$key]['emp_code']."</td>";
								  echo"<td ><input  type='hidden' name='ins[".$j."][fullname]' value='".$visit_sal[$key]['fullname']."'>".$visit_sal[$key]['fullname']."</td>";
								  echo"<td ><input  type='hidden' name='ins[".$j."][attend_date]' value='".$attend_date."'>".$attend_date."</td>";
								 // echo"<td ><input  type='hidden' name='ins[".$j."][th_count]' value='".$visit_sal[$key]['tot_th_count']."'>".$visit_sal[$key]['tot_th_count']."</td>";
								 // echo"<td ><input  type='hidden' name='ins[".$j."][pr_count]' value='".$visit_sal[$key]['tot_pr_count']."'>".$visit_sal[$key]['tot_pr_count']."</td>";
								  
								  echo"<td ><input  type='hidden' name='ins[".$j."][total_payable_hours]' value='".$visit_sal[$key]['total_payable']."'>".$visit_sal[$key]['total_payable']."</td>";
								//  echo"<td ><input  type='hidden' name='ins[".$j."][th_amount]' value='".$visit_sal[$key]['th_amount']."'>".$visit_sal[$key]['th_amount']."</td>";
								 // echo"<td ><input  type='hidden' name='ins[".$j."][pr_amount]' value='".$visit_sal[$key]['pr_amount']."'>".$visit_sal[$key]['pr_amount']."</td>";
								  
								  echo"<td ><input  type='hidden' name='ins[".$j."][total_lecturewise_amount]' value='".$total_amount."'>".$total_amount."</td>";
								  
								  
								  echo"<td class='mon'><input type='number' name='ins[".$j."][ta_days_count]' value='".$visit_sal[$key]['ta_days_count']."' /></td>";
								  echo"<td class='mon'><input type='number' name='ins[".$j."][rate_of_ta]' value='".$visit_sal[$key]['rate_of_ta']."'  /></td>";
								  
								  echo"<td class='mon'><input type='number' name='ins[".$j."][ta_amount]' value='".$ta_amount."'  /></td>";

								 echo"<td ><input  type='number' readonly class='editable' id='bill_amount_".$j."' name='ins[".$j."][bill_amount]' value='".$bill_amount."'></td>";
								  
								 echo"<td ><input  type='number' readonly class='editable'  name='ins[".$j."][tds_amount]' id='tds_amount_".$j."' oninput='updateNetPay($j)' value='".$tds_amount."'></td>";
								  
								 echo"<td ><input  type='number' name='ins[".$j."][other_paid]' id='other_paid_".$j."' oninput='updateNetPay($j)'</td>";
								 
								 echo"<td ><input  type='number' name='ins[".$j."][arrs_tds]' id='arrs_tds_".$j."''</td>";
								  
								 echo"<td ><input  type='number' readonly class='editable' name='ins[".$j."][net_pay]' id='net_pay_" . $j . "' value='".$net_pay."'></td>";
								  
								  echo"<td ><input  type='hidden' name='ins[".$j."][bank_acc_no]' value='".$visit_sal[$key]['bank_acc_no']."'>".$visit_sal[$key]['bank_acc_no']."</td>";
								  echo"<td ><input  type='hidden' name='ins[".$j."][acc_holder_name]' value='".$visit_sal[$key]['acc_holder_name']."'>".$visit_sal[$key]['acc_holder_name']."</td>";
								  echo"<td ><input  type='hidden' name='ins[".$j."][bank_name]' value='".$visit_sal[$key]['bank_name']."'><input  type='hidden' name='ins[".$j."][bank_id]' value='".$visit_sal[$key]['bank_id']."'>".$visit_sal[$key]['bank_name']."</td>";
								  echo"<td ><input  type='hidden' name='ins[".$j."][branch_name]' value='".$visit_sal[$key]['branch_name']."'>".$visit_sal[$key]['branch_name']."</td>";
								  echo"<td ><input  type='hidden' name='ins[".$j."][bank_ifsc]' value='".$visit_sal[$key]['bank_ifsc']."'>".$visit_sal[$key]['bank_ifsc']."</td>";
								 
								  echo"</tr>";
									$j++; 
								  
								      }	?>
								  </tbody>
								  </table>
								  </div>
								  <br>
								   <?php //if(in_array("Add",$my_privileges)){ ?>
								   <div class="form-group">
								   <div class="col-md-6" ></div>
                                      <div class=" col-md-2">  
                                           <!-- <input type="submit" class="btn btn-primary form-control" name="save" value="Save Staff Income Detail">-->
											<button class="btn btn-primary form-control" id="btn_submit1" type="submit" >Save</button>
                                        </div>
                                       <div class=" col-md-2">  
                                            <!--input type="submit" class="btn btn-primary form-control" name="cancel" value="cancel"-->
											<!--button onclick="ExportToExcel('xlsx')">Export table to excel</button-->
                                        </div> 
                                    </div>
								 <?php } //} ?>
								  </form>
								  </div>
								</div>
								</div>
									 <?php  }elseif(empty($visit_sal)){
										 if(!empty($month_name)){
										 	if(!empty($this->session->flashdata('message1'))){
										echo"<span class='text-center col-md-12'><label style='color:red'>".$this->session->flashdata('message1')." for  ".date("F", mktime(0, 0, 0, $month_name, 10))."  ".$year_name."</label></span>"; 
										
                                      }else if(!empty($this->session->flashdata('message2'))){
										echo"<span class='text-center col-md-12'><label style='color:red'>".$this->session->flashdata('message2')."</label></span>"; 
									      }
									    }
									 }   ?>
								  
                          </div>                              
                        </div>
                    </div>
                </div>
            </div>    
        </div>
   

<script type="text/javascript">

function calculate_gross_amt(e){
	//alert(e);	
	var basic_sal_c = $('#'+e).closest("tr").find(".basic_sal_c").text();
	//alert(basic_sal_c);
	$('#'+e).closest("tr").find(".basic_sal_c").val(basic_sal_c);
	var dp = $('#'+e).closest("tr").find(".dp").text();
	var da = $('#'+e).closest("tr").find(".da").text();
	var hra = $('#'+e).closest("tr").find(".hra").text();
	var ta = $('#'+e).closest("tr").find(".ta").text();
	var diff = $('#ins'+e).val();
	var otha = $('#'+e).closest("tr").find(".otha").text();
	var spea = $('#'+e).closest("tr").find(".spea").text();
	
	var gratuity = $('#'+e).closest("tr").find(".gratuity").text();
	var epf_er = $('#'+e).closest("tr").find(".epf_er").text();
	
	var gratuity_val = Math.round(parseFloat(gratuity));
	var epf_er_val = Math.round(parseFloat(epf_er));
	$('#gross_salary').val('');
	//alert(gratuity);
	//alert(epf_er);
//alert(parseInt(basic_sal_c));

	var grosst = (parseFloat(basic_sal_c)+Math.round(parseFloat(da))+Math.round(parseFloat(hra))+Math.round(parseFloat(dp))+Math.round(parseFloat(ta))+Math.round(parseFloat(diff))+Math.round(parseFloat(otha))+Math.round(parseFloat(spea)));
	
$('#gross'+e).val(parseFloat(grosst).toFixed(2));
var ctc1 =parseFloat(grosst)+gratuity_val+epf_er_val;
var ctc =ctc1.toFixed(2);
//alert(ctc);
$('#ctc'+e).val(ctc);

    var epf = $('#epf'+e).val();
	var ptax = $('#ptax'+e).val();
	var tds = $('#tds'+e).val();
	var busd = $('#busd'+e).val();
	var mobb = $('#mobb'+e).val();
	var socc = $('#socc'+e).val();
	var offa = $('#offa'+e).val();
	var othd = $('#othd'+e).val();
	
	
	var totd = ((gratuity_val!=''?parseFloat(gratuity_val):0)+(epf_er_val!=''?parseFloat(epf_er_val):0)+(epf!=''?parseFloat(epf):0)+(ptax!=''?parseFloat(ptax):0)+(tds!=''?parseFloat(tds):0)+(busd!=''?parseFloat(busd):0)+(mobb!=''?parseFloat(mobb):0)+(offa!=''?parseFloat(offa):0)+(othd!=''?parseFloat(othd):0)+(socc!=''?parseFloat(socc):0));
	//alert(totd);
	$('#totd'+e).val(parseFloat(totd).toFixed(2));
	
//var final_net_sal= (parseFloat(grosst)-parseFloat(totd));
var final_net_sal= (parseFloat(ctc)-parseFloat(totd));
$('#nets'+e).val('');
$('#nets'+e).val(parseFloat(final_net_sal).toFixed(2));	
	
}
$(document).ready(function(){
	 
	$('#dob-datepicker').datepicker( {format: "yyyy-m",startView: "months",minViewMode: "months",autoclose:true});
	
	$('#ym-datepicker').datepicker( {  autoclose: true,
    minViewMode: 1,
    format: 'yyyy-mm',
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }});
	var content = '<tr>'+$('#eduDetTable tbody tr').html()+'</tr>';
	$("#eduDetTable").on("click","input[name='addMore']", function(e){	

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
<script type="text/javascript">
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('saltab');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }
$(document).ready(function () {
    var table = $('#saltab').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
                dom: 'lBfrtip',
            "bPaginate": false,
                "bInfo": false,
        buttons: [
            'excel'
        ]
    });
});
	
</script>
<!--script>
function updateNetPay(index) {
    const billAmountEl = document.getElementById(`bill_amount_${index}`);
    const tdsInput = document.getElementById(`tds_amount_${index}`);
    const othrInput = document.getElementById(`other_paid_${index}`);
    const netPayInput = document.getElementById(`net_pay_${index}`);

    if (!billAmountEl) console.warn(`Missing: bill_amount_${index}`);
    if (!tdsInput) console.warn(`Missing: tds_amount_${index}`);
    if (!othrInput) console.warn(`Missing: other_paid_${index}`);
    if (!netPayInput) console.warn(`Missing: net_pay_${index}`);

    if (billAmountEl && tdsInput && othrInput && netPayInput) {
        const billAmount = parseFloat(billAmountEl.value) || 0;
        const tdsAmount = parseFloat(tdsInput.value) || 0;
        const othrPaid = parseFloat(othrInput.value) || 0;

        let netPay = Math.round(billAmount - tdsAmount);
        netPay += othrPaid;

        netPayInput.value = netPay.toFixed(2);
    }
}
</script-->

<script>
function getIndexFromName(nameAttr) {
    const match = nameAttr.match(/\[(\d+)\]/);
    return match ? match[1] : null;
}

function updateTAAmt(index) {
    const taDays = parseFloat($(`[name='ins[${index}][ta_days_count]']`).val()) || 0;
    const taRate = parseFloat($(`[name='ins[${index}][rate_of_ta]']`).val()) || 0;
    const taAmount = taDays * taRate;

    $(`[name='ins[${index}][ta_amount]']`).val(taAmount.toFixed(2));
    updateBillAmount(index);
}

function updateBillAmount(index) {
    const lectureAmount = parseFloat($(`[name='ins[${index}][total_lecturewise_amount]']`).val()) || 0;
    const taAmount = parseFloat($(`[name='ins[${index}][ta_amount]']`).val()) || 0;

    const billAmount = lectureAmount + taAmount;
    $(`[name='ins[${index}][bill_amount]']`).val(billAmount.toFixed(2));
    updateTDSAmount(index);
}

function updateTDSAmount(index) {
    const billAmount = parseFloat($(`[name='ins[${index}][bill_amount]']`).val()) || 0;
    const tdsAmount = billAmount * 0.10;

    $(`[name='ins[${index}][tds_amount]']`).val(tdsAmount.toFixed(2));
    updateNetPay(index);
}

function updateNetPay(index) {
    const billAmount = parseFloat($(`[name='ins[${index}][bill_amount]']`).val()) || 0;
    const tdsAmount = parseFloat($(`[name='ins[${index}][tds_amount]']`).val()) || 0;
    const otherPaid = parseFloat($(`[name='ins[${index}][other_paid]']`).val()) || 0;

    const netPay = billAmount - tdsAmount + otherPaid;
    $(`[name='ins[${index}][net_pay]']`).val(netPay.toFixed(2));
}

$(document).ready(function () {
    // Trigger calculations on input changes
    $(document).on('input', 'input[name$="[ta_days_count]"], input[name$="[rate_of_ta]"]', function () {
        const index = getIndexFromName($(this).attr('name'));
        if (index) updateTAAmt(index);
    });

    $(document).on('input', 'input[name$="[ta_amount]"]', function () {
        const index = getIndexFromName($(this).attr('name'));
        if (index) updateBillAmount(index);
    });

    $(document).on('input', 'input[name$="[bill_amount]"]', function () {
        const index = getIndexFromName($(this).attr('name'));
        if (index) updateTDSAmount(index);
    });

    $(document).on('input', 'input[name$="[tds_amount]"], input[name$="[other_paid]"]', function () {
        const index = getIndexFromName($(this).attr('name'));
        if (index) updateNetPay(index);
    });
});
</script>


