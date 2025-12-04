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
.empidc{ width:70px;}
</style>

<?php

    $astrik='<sup class="redasterik" style="color:red">*</sup>';

?>

<div id="content-wrapper">

    <ul class="breadcrumb breadcrumb-page">

        <div class="breadcrumb-label text-light-gray">You are here: </div>

        <li><a href="#">Attendance</a></li>

        <li class="active"><a href="#">Employee Manual Attendance</a></li>

    </ul>

    <div class="page-header">			

        <div class="row">

            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Employee Manual Attendance</h1>

            <div class="col-xs-12 col-sm-8">

                <div class="row">                    

                    <hr class="visible-xs no-grid-gutter-h">

                </div>

            </div>

        </div>       

        <div class="row ">
            <div class="col-sm-12">               

                        <div class="table-info">                                                              

                             <div id="dashboard-recent" class="panel-warning">   

                               <div class="panel">

                            	<div class="panel-heading"><strong>Employee Manual Attendance</strong></div>

                                <div class="panel-body">

								<span id="flash-messages" style="color:red;padding-left:110px;"><?php echo $this->session->flashdata('message1'); ?></span>

                                <div class="panel-padding no-padding-vr">

                            <div class="form-group">                             

							  <div class="portlet-body form">

							  <form id="form" name="form" action="<?=base_url($currentModule.'/staff_manual_attendance')?>" method="POST" enctype="multipart/form-data">

							    <?php if(!empty($attend_date)){ //print_r($emp_leave_info);?>
								<input type="hidden" name="inupdate" value="1">			

                                <?php } ?>								

								<div class="form-body">

								<div class="form-group">

								<label class="col-md-3">Select Month&Year</label>

								<div class="col-md-3" >

								<input type="text" class="form-control" placeholder="Month & Year" name="for_month_year" id="dob-datepicker" value="" required>

								</div>
 <div class=" col-md-2">  

                                            <input type="submit" name="view" class="btn btn-primary form-control" value="View Staff">

                                        </div>
								</div>								

								</form>

								

								<?php if(!empty($emp_list)){?>

								

								<?php

if(!empty($attend_date)){

//echo $attend_date;

$date =  $attend_date."-01";

$lt=date('t', strtotime($attend_date)); //get end date of month

$end = $attend_date."-".$lt;

$time=strtotime($attend_date);

		$d = date_parse_from_format("Y-m-d",$attend_date);

        $msearch=$d["month"];//month number

        $ysearch=date("Y",strtotime($attend_date));

		$monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name

		$totaldays=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);

		$i=1;

		//calculate number of sundays in given month

		function total_sundays1($monthName,$ysearch)

{

$sundays=0;

$total_days=cal_days_in_month(CAL_GREGORIAN, $monthName, $ysearch);

for($i=1;$i<=$total_days;$i++)

if(date('N',strtotime($ysearch.'-'.$monthName.'-'.$i))==7)

$sundays++;

return $sundays;

}

$total_sun=total_sundays1($msearch,$ysearch);

$total_holiday=$this->Admin_model->getTotalHoliday($msearch,$ysearch);

//echo $total_holiday;

$working_days=$totaldays-($total_sun+$total_holiday);

}

?>

								

								 <form id="form" name="form" action="<?=base_url($currentModule.'/staff_manual_attendance')?>" method="POST" enctype="multipart/form-data">

								

								<?php if(!empty($attend_date)){ //print_r($emp_leave_info);?>								

								<input type="hidden" name="attend_date" value="<?=$attend_date?>">								

                                <?php } ?>	

								<div class="form-group">

								<div class="table-scrollable text-center">
<span><b>For the month of <?php echo date('F Y',strtotime($attend_date)); ?></b></span>
                                 <table class="table table-bordered">

								 <tr>

								 <th>SrNo.</th>
								 <th>Staff ID</th>
								 <th>Staff Name</th>
								 <th>Month Days</th>
								 <th>Working Days</th>
								 <th>Present Days</th>
								 <th>Sundays</th>
								 <th>Holiday</th>
								 <th>OD</th>
								 <th>CL</th>
								 <th>ML</th>
								 <th>EL</th>
								 <th>C-Off</th>
								 <th>SL</th>
								 <th>VL</th>
								 <th>Leave</th>
								 <th>LWP</th>
<th>WFH</th>										 
<th>Total</th>

								 </tr>

								 <?php 

								 $j=0;

								 foreach($emp_list as $key=>$val){
  $wd = $totaldays - ($total_sun + $total_holiday);

								echo "<tr><td>".++$j."</td>

								          <td><input class='empidc' type='text' id='eid".$key."' name='eid[".$key."]' value='".$emp_list[$key]['emp_id']."' readonly></td>

								          <td><input type='text' id='ename".$key."' name='ename[".$key."]' value='".$emp_list[$key]['fname'].' '.$emp_list[$key]['lname']."' readonly></td>
								          <td><input type='text' class='empidc' id='month_days".$key."' name='month_days[".$key."]' value='".$totaldays." ' readonly></td>
								          <td><input type='text' class='empidc' id='working_days".$key."' name='working_days[".$key."]'  onblur='calculate_days(".$key.");' value='".$wd."'></td>
								          <td><input type='text' class='empidc' id='present_days".$key."' name='present_days[".$key."]'  onblur='calculate_days(".$key.");' value='".$val['total_present']."' min='0'></td>
								          <td><input type='text' class='empidc' id='sundays".$key."' name='sundays[".$key."]' value='".$total_sun."' ></td>
								          <td><input type='text' class='empidc' id='holidays".$key."' name='holidays[".$key."]' value='".$total_holiday."'></td>

								          <td><input type='text' class='empidc' id='OD".$key."' name='OD[".$key."]' onblur='calculate_days(".$key.");' value='".$val['total_outduty']."' min='0'></td>

								          <td><input type='text' class='empidc' id='CL".$key."' name='CL[".$key."]' onblur='calculate_days(".$key.");' value='".$val['CL']."' min='0'></td>

								          <td><input type='text' class='empidc' id='ML".$key."' name='ML[".$key."]' onblur='calculate_days(".$key.");' value='".$val['ML']."' min='0'></td>
								          <td><input type='text' class='empidc' id='EL".$key."' name='EL[".$key."]' onblur='calculate_days(".$key.");' value='".$val['EL']."' min='0'></td>
								          <td><input type='text' class='empidc' id='C-Off".$key."' name='C-Off[".$key."]' onblur='calculate_days(".$key.");' value='".$val['C-Off']."' min='0'></td>
								          <td><input type='text' class='empidc' id='SL".$key."' name='SL[".$key."]' onblur='calculate_days(".$key.");' value='".$val['SL']."' min='0'></td>
								          <td><input type='text' class='empidc' id='VL".$key."' name='VL[".$key."]' onblur='calculate_days(".$key.");' value='".$val['VL']."' min='0'></td>

								          <td><input type='text' class='empidc' id='Leave".$key."' name='Leave[".$key."]' onblur='calculate_days(".$key.");' value='".$val['Leaves']."' min='0'></td>

								          <td><input type='text' class='empidc' id='LWP".$key."' name='LWP[".$key."]' onblur='calculate_days(".$key.");' value='".$val['LWP']."' min='0'></td>
<td><input type='text' class='empidc' id='WFH".$key."' name='WFH[".$key."]' onblur='calculate_days(".$key.");' value='".$val['WFH']."' min='0'></td>											  

								          <td><input type='text' class='empidc' id='Total".$key."' name='Total[".$key."]' onclick='get_total(".$key.");' min='0' value='".$val['Total']."' required></td>								

								</tr>";	 

									 

								 }	 ?>							 

								 </table>
                				</div>
                				</div>
								<div class="form-group">
								   <div class="col-md-5" ></div>
                                      <div class=" col-md-2">  
                                            <input type="submit" name="attend_submit" class="btn btn-primary form-control" value="Save">
                                        </div>                                    </div>                         

                            </div>
                                    </form>
                                <?php } ?>	
									</div>

									
    </div>
							   </div>
                                </div>

                            </div> 
                          </div>                          </div>

                    </div>
                </div>
            </div>   
        </div>
   

<script type="text/javascript">
function calculate_days(e){
  var md = $('#month_days'+e).val();
  //alert(md);
  var wd = $('#working_days'+e).val();
  //alert(wd);
  var sd = $('#sundays'+e).val();
  var hd = $('#holidays'+e).val();
  var td = parseInt(md) - (parseInt(sd)+parseInt(hd));
  $('#working_days'+e).val(td);

  var od = $('#OD'+e).val();
  var cl = $('#CL'+e).val();
  var ml = $('#ML'+e).val();
  var el = $('#EL'+e).val();
  var coff = $('#C-Off'+e).val();
  var sl = $('#SL'+e).val();
  var vl = $('#VL'+e).val();
  var lev = $('#Leave'+e).val();
  var WFH = $('#WFH'+e).val();
  //var lwp = $('#LWP_'+e).val();
  var pd = $('#present_days'+e).val();
  if(od==''){
  	od =0;
  }
if(cl==''){
  	cl =0;
  }if(ml==''){
  	ml =0;
  }if(el==''){
  	el =0;
  }if(coff==''){
  	coff =0;
  }if(sl==''){
  	sl =0;
  }if(vl==''){
  	vl =0;
  }if(lev==''){
  	lev =0;
  }
  if(WFH==''){
  	WFH =0;
  }
    if(pd==''){
  	pd =0;
  }
 /* alert("hd"+hd);
   alert("td"+td);
    alert("od"+od);
	 alert("cl"+cl); alert("ml"+ml);
	  alert("el"+el);
	   alert("coff"+coff);
	    alert("sl"+sl);
		
		 alert("vl"+vl);
	   alert("lev"+lev);
	    alert("WFH"+WFH);
		 alert("pd"+pd);*/
		
  
  var ftot = parseFloat(hd)+parseFloat(sd)+parseFloat(pd)+parseFloat(od)+parseFloat(cl)+parseFloat(ml)+parseFloat(el)+parseFloat(coff)+parseFloat(sl)+parseFloat(vl)+parseFloat(lev)+parseFloat(WFH);
 
  if(parseFloat(ftot) <= parseFloat(md)){
  $('#Total'+e).val(ftot);
  }else{
    alert('Total days is greater then month days.');
    $('#Total'+e).val('');
  }
}
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

if($('#reporting_person').val()!=''){

	$('#leave_module').show();

}
});

function get_total($key){

	//alert($key);

var totalcnt;

var a1=document.getElementById('present_days'+$key).id;

//alert(a1);//present_days0

var wo=document.getElementById('working_days'+$key).value;

var a=document.getElementById('present_days'+$key).value;
var b=document.getElementById('sundays'+$key).value;
var c=document.getElementById('holidays'+$key).value;
var d=document.getElementById('OD'+$key).value;

var e= document.getElementById('CL'+$key).value;

var f=document.getElementById('ML'+$key).value;

var g=document.getElementById('EL'+$key).value;

var h=document.getElementById('C-Off'+$key).value;

var i=document.getElementById('SL'+$key).value;

var j=document.getElementById('VL'+$key).value;

var k=document.getElementById('Leave'+$key).value;

var l=document.getElementById('LWP'+$key).value;
var w=document.getElementById('WFH'+$key).value;
//var result = parseInt(a) + parseInt(b)+parseInt(c)+parseInt(d)+parseInt(e)+parseInt(f)+parseInt(g)+parseInt(h)+parseInt(i)+parseInt(j)+parseInt(k)+parseInt(l)+parseInt(m);

var result = parseFloat(a) + parseFloat(b)+parseFloat(c)+parseFloat(d)+parseFloat(e)+parseFloat(f)+parseFloat(g)+parseFloat(h)+parseFloat(i)+parseFloat(j)+parseFloat(k)+parseFloat(l)+parseFloat(w);

            if (!isNaN(result)) {

                document.getElementById('Total'+$key).value = result;

            }

}



/* function get_total($key){

	alert($key);

var totalcnt;

var a=$('#present_days'+$key).val();

alert($('#present_days'+$key).val());

var b=$('#sundays'+$key).val();

alert($('#sundays'+$key).val());

var c=$('#holidays'+$key).val();

alert($('#holidays'+$key).val());

var d=$('#OD'+$key).val();

alert($('#OD'+$key).val());

var e= $('#CL'+$key).val();

alert($('#CL'+$key).val());

var f=$('#ML'+$key).val();

var g=$('#EL'+$key).val();

var h=$('#C-Off'+$key).val();

var i=$('#SL'+$key).val();

var j=$('#VL'+$key).val();

var k=$('#Leave'+$key).val();

var l=$('#LWP'+$key).val();

var m=$('#STL'+$key).val();

totalcnt=(a+b+c+d_)

//totalcnt= parseInt(a)+parseInt(b)+parseInt(c)+parseInt(d)+parseInt(e)+parseInt(f)+parseFloat(g)+parseInt(h)+parseInt(i)+parseInt(j)+parseInt(k)+parseInt(l);

var finalcnt=parseInt(totalcnt);

		 alert(finalcnt);

		 $('#Total'+$key).val(finalcnt);

} */

</script>





