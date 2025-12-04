<?php //print_r($all_attend);  exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<style>

.attexl table th{
    border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.add-table tr td{border:0px}

.attexl table  td{
     border: 1px solid black;
    padding: 5px;border-collapse: collapse
}
.bottom-table{padding:50px 0 20px 0}
.bottom-table-2{padding-top:20px}
</style>

<div class="row">

<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="100"><img src="<?php echo base_url(); ?>assets/images/lg.png" alt="Sandip University" class="img-responsive"></td>
    <td valign="top" align="center">
    <span style="font-size:25px;text-align:center"><b>Sandip University</b></span><br>
    <span style="text-align:center;font-size:11px">Trimbak Road, A/p - Mahiravani, Nashik – 422 213</span><br>
    <span style="font-size:10px;text-align:center">Website : http://www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in </span><br>
    <span style="font-size:15px;;text-align:center"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></span>
    </td>
  </tr>
</table>
<hr  style="border-width:1px;">
<?php
$date =  $attend_date."-01";
$lt=date('t', strtotime($attend_date)); //get end date of month
$end = $attend_date."-".$lt;
$time=strtotime($attend_date);
$d = date_parse_from_format("Y-m-d",$attend_date);
$msearch=$d["month"];//month number
$ysearch=date("Y",strtotime($attend_date));
$monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name
?>
<div align="center" style="text-align:center"><b>Monthly Attendance Report Of :
                                      <?=$monthName?>
                                      <?=$ysearch?>
                                    </b></div>
</div>
<br>
<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td align="right">
  <strong>Date :</strong> ___ /___ /_________
  </td>
  </tr>
  </table>
  
</div>
</div>



<div class="attexl" id="ReportTable1" style="">
                            <?php
				//print_r($all_attend);
 //exit;			
if(!empty($all_attend)){
	 $i=1;
//echo $attend_date;
$date =  $attend_date."-01";
$lt=date('t', strtotime($attend_date)); //get end date of month
$end = $attend_date."-".$lt;
$time=strtotime($attend_date);
$d = date_parse_from_format("Y-m-d",$attend_date);
$msearch=$d["month"];//month number
$ysearch=date("Y",strtotime($attend_date));
$monthName = date('F', mktime(0, 0, 0, $msearch, 10));// month name
?>
                            
                            <div class="table-scrollable" id="reporttab">
                             <table  cellpadding="0" cellspacing="0" style="font-size:11px" width="100%" align="center" class="attexl">
<tbody>

 <tr bgcolor="#9ed9ed" >
 <td><strong>SRNo.</strong></td>
 <td ><strong>Staff ID</strong></td>
 <td width="18%"><strong>Name Of Employee</strong></td>
 <td ><strong>Month Days</strong></td>
 <td ><strong>Working Days</strong></td>
 <td ><strong>Present Days</strong></td>
 <td ><strong>Sunday</strong></td>
 <td ><strong>Holiday</strong></td>
  <td ><strong>WFH</strong></td>
 <td ><strong>OD</strong></td>

 <td ><strong>CL</strong></td>
 <td ><strong>ML</strong></td>
 <td ><strong>EL</strong></td>
 <td ><strong>C-off</strong></td>
 <td ><strong>SL</strong></td>
 <td ><strong>VL</strong></td>
 <td><strong>Leave</strong></td>
 <!--<td style="border: 1px solid black;">Other</td>-->
 <td ><strong>LWP</strong></td>
 
 <!--<td style="border: 1px solid black;">Lcome/EG o</td>-->
 <td ><strong>Total</strong></td>
  </tr>

 <?php 
 
 //$i=1;
 //eprint_rcho $sbtn;

 if($sbtn=='1' ){ 
  //print_r($all_attend); 
 foreach($all_attend as $key=>$val){ 
 ?>
 <tr <?php if(($i % 2)=='0'){ echo 'bgcolor="#D9D9D9"'; } ?>> 
   <td ><?=$i;?></td>
<td ><?=$all_attend[$key]['UserId']?></td>
<td ><?=$all_attend[$key]['ename']?></td>
<td ><?=$all_attend[$key]['month_days']?></td><!--Total Month Days-->
<td ><?=$all_attend[$key]['working_days']?></td><!--Working days of Month excluding Sundays and Holidays-->
<td ><?=($all_attend[$key]['total_present']);?></td><!--Total Present Day without OD-->
<td ><?=isset($all_attend[$key]['sunday'])?$all_attend[$key]['sunday']:0;?></td><!--Sundays Count-->
<td ><?=isset($all_attend[$key]['holiday'])?$all_attend[$key]['holiday']:0?></td><!--Holidays-->
<td ><?=isset($all_attend[$key]['WFH'])?$all_attend[$key]['WFH']:0?></td>
<td ><?=isset($all_attend[$key]['total_outduty'])?$all_attend[$key]['total_outduty']:0?></td><!--OD-->
<td ><?=isset($all_attend[$key]['CL'])?$all_attend[$key]['CL']:0?></td><!--CL-->
<td ><?=isset($all_attend[$key]['ML'])?$all_attend[$key]['ML']:0?></td><!--ML-->
<td ><?=isset($all_attend[$key]['EL'])?$all_attend[$key]['EL']:0?></td><!--EL-->
<td ><?=isset($all_attend[$key]['C-Off'])?$all_attend[$key]['C-Off']:0?></td><!--C-off-->
<td ><?=isset($all_attend[$key]['SL'])?$all_attend[$key]['SL']:0?></td><!--SL-->
<td ><?=isset($all_attend[$key]['VL'])?$all_attend[$key]['VL']:0?></td><!--VL-->
<td ><?=isset($all_attend[$key]['Leave'])?$all_attend[$key]['Leave']:0?></td><!--Leave-->
<td ><?=isset($all_attend[$key]['LWP'])?$all_attend[$key]['LWP']:0?></td><!--LWP-->
<td ><b><?=($all_attend[$key]['Total'])?></b></td>
</tr> 
  <?php $i++;
 }
 }else{
	// echo '2';
 foreach($all_attend as $key=>$val){
	
?>
<tr  <?php if(($i % 2)=='0'){ echo 'bgcolor="#D9D9D9"'; } ?>>

<td ><?=$i;?></td>
<td ><?=$all_attend[$key]['UserId']?></td>
<td ><?=$all_attend[$key]['ename']?></td>
<td ><?=$all_attend[$key]['month_days']?></td><!--Total Month Days-->
<td ><?=$all_attend[$key]['working_days']?></td><!--Working days of Month excluding Sundays and Holidays-->
<td ><?=$all_attend[$key]['total_present'];?></td><!--Total Present Day without OD-->
<td ><?=isset($all_attend[$key]['sunday'])?$all_attend[$key]['sunday']:0;?></td><!--Sundays Count-->
<td ><?=isset($all_attend[$key]['holiday'])?$all_attend[$key]['holiday']:0?></td><!--Holidays-->
<td ><?=isset($all_attend[$key]['total_WFH'])?$all_attend[$key]['total_WFH']:0?></td>
<td ><?=isset($all_attend[$key]['total_outduty'])?$all_attend[$key]['total_outduty']:0?></td><!--OD-->
<td ><?=isset($all_attend[$key]['total_CL'])?$all_attend[$key]['total_CL']:0?></td><!--CL-->
<td ><?=isset($all_attend[$key]['total_ML'])?$all_attend[$key]['total_ML']:0?></td><!--ML-->
<td ><?=isset($all_attend[$key]['total_EL'])?$all_attend[$key]['total_EL']:0?></td><!--EL-->
<td ><?=isset($all_attend[$key]['total_Coff'])?$all_attend[$key]['total_Coff']:0?></td><!--C-off-->
<td ><?=isset($all_attend[$key]['total_SL'])?$all_attend[$key]['total_SL']:0?></td><!--SL-->
<td ><?=isset($all_attend[$key]['total_VL'])?$all_attend[$key]['total_VL']:0?></td><!--VL-->
<td ><?=isset($all_attend[$key]['total_leave'])?$all_attend[$key]['total_leave']:0?></td><!--Leave-->
<td ><?=isset($all_attend[$key]['total_LWP'])?$all_attend[$key]['total_LWP']:0?></td><!--LWP-->
<td ><b><?=isset($all_attend[$key]['total'])?$all_attend[$key]['total']:0?><?php //($all_attend[$key]['total_present']+$all_attend[$key]['sunday']+
//$all_attend[$key]['holiday']+$all_attend[$key]['total_outduty']+$all_attend[$key]['total_CL']+$all_attend[$key]['total_ML']+$all_attend[$key]['total_EL']+$all_attend[$key]['total_Coff']+
//$all_attend[$key]['total_SL']+$all_attend[$key]['total_VL']+$all_attend[$key]['total_leave']);//$all_attend[$key]['total_present_half']+?></b></td>

</tr> 
 <?php $i++; } } ?>
  
</tbody>  
</table>
                              </div>
                            <?php   } else{?>
                            <div>
                              <label style="color:red">
                                <b>No Attendance available.....
                                </b>
                              </label>
                            </div>
                            <?php } ?>
                          </div>