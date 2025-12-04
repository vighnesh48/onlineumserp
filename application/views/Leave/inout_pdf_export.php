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
<div align="center" style="text-align:center"><b>Monthly Attendance Report Of 
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
              
if(!empty($attendance)){
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
                              <table cellpadding="0" cellspacing="0"   style="font-size:11px;border:1px solid;" >
                                <thead>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">Sr No.
                                    </td>
                                    <td style="border: 1px solid black;">Date 
                                      <br/>
                                      Day
                                    </td>
                                    <?php while(strtotime($date) <= strtotime($end)) {
$day_num = date('d', strtotime($date));
$day_name = date('D', strtotime($date));
$totaldays['total'][]=$day_num;
$totaldays['weekd'][]=$day_name ;
$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));?>
                                    <td style="border: 1px solid black;">
                                      <?=$day_num?>
                                      <br/>
                                      <?=$day_name?>
                                    </td>
                                    <?php }
?>
                                    <td  colspan="6" style="border: 1px solid black;">Total
                                    </td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
/*  echo "total days=". count($totaldays['total'])  ;
print_r($totaldays['total']);
print_r($totaldays['weekd']); 
*/
?>
                                  <?php 
//print_r($all_emp);
$sr=0;
$total_count = array();
$grand_total=array();
foreach($all_emp as $e ){
// echo 
$det = $this->Admin_model->getEmployeeById1($e['emp_id'],'y');
//  echo $e['emp_id'];
$name = $det[0]['fname']." ".$det[0]['mname']." ".$det[0]['lname'];
$staff_type=$det[0]['staff_type'];
/*   echo"<pre>";
print_r($attendance[$e['emp_id']]);
echo"</pre>"; */
$sr++;   
?>
                                  <tr style="border: 1px solid black;">
                                    <td rowspan="5" style="border: 1px solid black;">
                                      <?=$sr;?>
                                    </td>
                                    <td colspan="<?=$lt+1?>" style="border: 1px solid black;">
                                      <?php echo"<b>Staff ID:</b> ".$e['emp_id']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."<b>Staff Name:</b> ".$name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."<b>Designation:</b> ".$det[0]['designation_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."<b>Department:</b> ".$det[0]['department_name']?>
                                    </td>
                                    <td style="border:1px solid black;">P
                                    </td>
                                    <td style="border:1px solid black;">S
                                    </td>
                                    <td style="border:1px solid black;">H
                                    </td>
                                    <td style="border:1px solid black;">LWP
                                    </td>
                                    <td style="border:1px solid black;">OD
                                    </td>
                  <td style="border:1px solid black;">LV
                                    </td>
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <strong>In:
                                      </strong>
                                    </td>
                                    <?php 
//echo "<pre>";
//print_r($attendance[$e['emp_id']]);exit;
//echo $attendance[$e['emp_id']][0]['status'];
foreach($attendance[$e['emp_id']] as $att){ 
$d=date('d',strtotime($att['Intime']));
$d = intval($d);
$dayIn[$e['emp_id']][$d]=$d; //array for only punched In day 
$tempdayin[$e['emp_id']][$d]=$dayIn[$e['emp_id']][$d];
$timedayin[$e['emp_id']][$d]=$att['Intime'];
$status[$e['emp_id']][$d]=$att['status'];
$leave[$e['emp_id']][$d]=$att['leave_type'];
$durl[$e['emp_id']][$d]=$att['leave_duration'];
$reml[$e['emp_id']][$d]=$att['remark'];

if($att['late_mark']=='1'){
$latemark[$e['emp_id']][$d]=$att['late_mark'];
}
if($att['early_mark']=='Y'){
	$earlymark[$e['emp_id']][$d]=$att['early_mark'];
}

//if(!empty($att['special_case'])){
$special_case[$e['emp_id']][$d]=$att['special_case'];
//}
if($att['Outtime'] != '0000-00-00 00:00:00'){
$d=date('d',strtotime($att['Outtime']));
$d = intval( $d);
//echo "<br/>";
$dayOut[$e['emp_id']][$d]=$d; //array for only punched In day 
$tempdayout[$e['emp_id']][$d]=$dayOut[$e['emp_id']][$d];
//echo "<br/>";
$timedayout[$e['emp_id']][$d]=$att['Outtime'];
} 

if(date('H:i:s',strtotime($att['Outtime'])) != '00:00:00' && date('H:i:s',strtotime($att['Intime'])) != '00:00:00'){
$d=date('d',strtotime($att['Outtime']));
$d = intval($d);
//  echo $att['Intime'];
if(date('h:i:s',strtotime($att['Intime']))!='00:00:00')$time1=date('H:i',strtotime($att['Intime']));else $time1='00:00';
if(date('h:i:s',strtotime($att['Outtime']))!='00:00:00')$time2=date('H:i',strtotime($att['Outtime'])); else $time2='00:00';
$diff=$this->Admin_model->get_time_difference($time1, $time2);
$dur[$d]= $diff;   
$timedayout[$e['emp_id']][$d]=$att['Outtime']; 
$timedayin[$e['emp_id']][$d]=$att['Intime']; 
}


 } 
$CI =& get_instance();
$CI->load->model('Leave_model');
?>
<?php 

for($i=1;$i<=count($totaldays['total']);$i++){
//first check holiday and sunday ***********************
$dname=$attend_date."-".$totaldays['total'][$i-1];

$check_holiday=$this->Admin_model->checkHoliday_new($dname,$staff_type);//check for holiday
 $check_holiday;//die();

if($check_holiday=='true'){
$day_name="Holiday";
}else{
$day_name = date('D', strtotime($dname));
}





// echo $day_name;
//echo $timedayin[$e['emp_id']][$temp];
if($status[$e['emp_id']][$i] =='present' && ($day_name!="Holiday" && $day_name!="Sun") ){
	
if(date('H:i',strtotime($timedayin[$e['emp_id']][$i])) !='00:00'){
//  if($durl[$e['emp_id']][$i] != '1' ){
//  echo date('H:i',strtotime($timedayin[$e['emp_id']][$temp]));
$total_count[$e['emp_id']]['present'][]='1';
// }
}

}elseif($status[$e['emp_id']][$i]=='leave' || $status[$e['emp_id']][$i]=='outduty'){
	
$ltypes=$leave[$e['emp_id']][$i];
$ltypes = strtoupper($ltypes);
$dur1 = $durl[$e['emp_id']][$i]; 

$rem = $reml[$e['emp_id']][$i];

if(trim($dur1) == '0.5' && ($rem == 'hrs' || $rem == 'half-day')){
  if(substr($ltypes, -1) === '*'){
$total_count[$e['emp_id']]['LWP'][]='0.5';
$total_count[$e['emp_id']][substr($ltypes,0,-1)][]=$dur1;
  }else{
    //echo 'jj';exit;

$total_count[$e['emp_id']]['present'][]='0.5';
if(trim($rem) === 'hrs'){
  $total_count[$e['emp_id']][$ltypes][]='0.5';
}else{
$total_count[$e['emp_id']][$ltypes][]=$dur1;
}
}
}else{  
 // echo $rem ;
if(trim($rem) === 'hrs'){
$total_count[$e['emp_id']][$ltypes][]='0.5';
$total_count[$e['emp_id']]['present'][]='0.5';
}else{
$total_count[$e['emp_id']][$ltypes][]=$dur1;
}
}
}  
$temp1=array_search($i,$tempdayin[$e['emp_id']]);
//echo $status[$e['emp_id']][$i];

if($status[$e['emp_id']][$i]=='holiday' || $status[$e['emp_id']][$i]=='sunday'){
  $col = 'color:red;';
  
}else{
  $col ='';
}


 $cd = date('d'); //echo '<br>';
 $cm = date('m');//echo '<br>';
$ad = date_parse_from_format("m",$attend_date);
//echo $i;echo '<br>';
//echo $cm.'--';print_r($ad);


if($cm==$ad){
//	echo '1';
if($i<=$cd){
	//echo $i;echo '<br>';
  if($status[$e['emp_id']][$i]=='sunday'){
   $total_count[$e['emp_id']]['sun'][] = '1';
  }
  if($status[$e['emp_id']][$i]=='holiday'){
  $total_count[$e['emp_id']]['holiday'][]='1';
  }
}

}else{
	//echo '2';
	  
  if($status[$e['emp_id']][$i]=='sunday'){
	
	 // echo  $leave[$e['emp_id']][$i]
    $total_count[$e['emp_id']]['sun'][] = '1';
  }
  if($status[$e['emp_id']][$i]=='holiday'){
	//  echo $attend_date."-".$totaldays['total'][$i-1];;
   $total_count[$e['emp_id']]['holiday'][]='1';
  }
}
if($latemark[$e['emp_id']][$i]=='1'){
	$lm = 'background-color:#D2D2D2;';
}else{
	$lm = '';
}

//echo $attend_date."-".$totaldays['total'][$i-1].'--'.$leave[$e['emp_id']][$i].'--'.$status[$e['emp_id']][$i];
if($status[$e['emp_id']][$i]=="sunday"){
//	echo $status[$e['emp_id']][$i-2];
//$remove_lpw[];
	if(($status[$e['emp_id']][$i+1]=="leave")&&($status[$e['emp_id']][$i-2]=="leave")){
		$remove_lpw[] = '';
	}
}
//$total_count[$e['emp_id']]['sun'][] = '-1';
?>
                                 
                                    <td style="border: 1px solid black;<?php echo $col; echo $lm; ?>">
                                      <?php  if($timedayin[$e['emp_id']][$i]!=''){ if(date('H:i',strtotime($timedayin[$e['emp_id']][$i]))=='00:00'){ echo "00:00"; }else{ echo  date('H:i',strtotime($timedayin[$e['emp_id']][$i]));} }else{ echo '00:00'; } ?>
                                    </td>
                                   
                                    <?php   }

                                     ?>
                                    <td style="border:1px solid black;">
                                      <?php echo $p = array_sum($total_count[$e['emp_id']]['present']);
									 // print_r($total_count[$e['emp_id']]['present']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php  $s = array_sum($total_count[$e['emp_id']]['sun']); 
									$lp= array_sum ($remove_lpw);
									  echo $s-$lp;?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $h = array_sum($total_count[$e['emp_id']]['holiday']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $lwp = array_sum($total_count[$e['emp_id']]['LWP']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $od = array_sum($total_count[$e['emp_id']]['OD']); ?>
                                    </td>
                  <td style="border:1px solid black;">
                                      <?php echo $lv = array_sum($total_count[$e['emp_id']]['LEAVE']); ?>
                                    </td>
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <strong>Out:
                                      </strong>
                                    </td>
                                    <?php
//print_r($attendance[$e['emp_id']]);

for($i=1;$i<=count($totaldays['total']);$i++){
  if($status[$e['emp_id']][$i]=='holiday' || $status[$e['emp_id']][$i]=='sunday'){
  $col = 'color:red;';
}else{
  $col ='';
}
if($earlymark[$e['emp_id']][$i]=='Y'){
	$em = 'background-color:#D2D2D2;';
}else{
	$em = '';
}
?>
                                    
                                    
                                    
                                    <td style="border: 1px solid black;<?php echo $col; echo $em;?>">
 <?php  if($timedayout[$e['emp_id']][$i]!=''){ 
 if(date('H:i',strtotime($timedayout[$e['emp_id']][$i])) =='00:00'){ echo "00:00";
 } else{ echo  date('H:i',strtotime($timedayout[$e['emp_id']][$i]));}}else{echo '00:00';}?>
                                    </td>
                                   
                                    <?php  } ?>
                                    <td style="border:1px solid black;">CO
                                    </td>
                                    <td style="border:1px solid black;">CL
                                    </td>          
                                    <td style="border:1px solid black;">SL
                                    </td>
                                    <td style="border:1px solid black;">EL
                                    </td>
                                    <td style="border:1px solid black;">ML
                                    </td>
                    <td style="border:1px solid black;">VL
                                    </td>
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <strong>Dur: </strong>
                                    </td>
                                    
                                    <?php for($i=1;$i<=count($totaldays['total']);$i++){ 
                  if($status[$e['emp_id']][$i]=='holiday' || $status[$e['emp_id']][$i]=='sunday'){
  $col = 'color:red;';
}else{
  $col ='';
}?>
                                  
                                    
                                    <td style="border: 1px solid black;<?php echo $col;?>">
                                      <?php 
                                      if($timedayin[$e['emp_id']][$i]!=''){
if(date('H:i',strtotime($timedayin[$e['emp_id']][$i]))!='00:00' && date('H:i:s',strtotime($timedayout[$e['emp_id']][$i]))!='00:00:00'){
if($dur[$i]!=''){
echo $dur[$i] ; }else{echo "00:00";} }else{echo "00:00";}}else{echo "00:00";} ?>
                                    </td>
                  <?php } ?>         
                                    <td style="border:1px solid black;">
                                      <?php echo $co = array_sum($total_count[$e['emp_id']]['C-OFF']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $cl = array_sum($total_count[$e['emp_id']]['CL']); ?>
                                    </td>          
                                    <td style="border:1px solid black;">
                                      <?php echo $sl = array_sum($total_count[$e['emp_id']]['SL']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $el = array_sum($total_count[$e['emp_id']]['EL']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $ml = array_sum($total_count[$e['emp_id']]['ML']); ?>
                                    </td>
                  <td style="border:1px solid black;">
                                      <?php echo $vl = array_sum($total_count[$e['emp_id']]['VL']); ?>
                                    </td>
                                    <?php     
									if(empty($p)){           
$grand_total[$e['emp_id']]=0; //$p+$s+$h+$od+$co+$cl+$sl+$el+$ml+$vl+$lv; 
									}else{
										$lpp= array_sum ($remove_lpw);
$grand_total[$e['emp_id']]= $p+$s+$h+$od+$co+$cl+$sl+$el+$ml+$vl+$lv-$lpp;
									}?>               
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <strong>sta.:
                                      </strong>
                                    </td>
                                    
                                    <?php for($i=1;$i<=count($totaldays['total']);$i++){
if($status[$e['emp_id']][$i]=='holiday' || $status[$e['emp_id']][$i]=='sunday'){
  $col = 'color:red;';
}else{
  $col ='';
}
?>
                                    <td style="border: 1px solid black;<?php echo $col;?>">
                                      <?php //echo $status[$e['emp_id']][$i];
if($status[$e['emp_id']][$i]=='present'){
//echo $timedayin[$e['emp_id']][$temp1];
if(date('H:i:s',strtotime($timedayout[$e['emp_id']][$i]))=='00:00:00' || date('H:i:s',strtotime($timedayin[$e['emp_id']][$i]))=='00:00:00')
{
echo "";
}else{
echo 'P';

if(!empty($special_case[$e['emp_id']][$i])){
echo '('.$special_case[$e['emp_id']][$i].')';
}
}
$total_count[$e['emp_id']]['present'][]='1';
}elseif($status[$e['emp_id']][$i]=='leave' || $status[$e['emp_id']][$i]=='outduty'){
$ltypes=$leave[$e['emp_id']][$i];
$dur1 = $durl[$e['emp_id']][$i];
 
if($ltypes=='LWP'){
 
if(trim($durl[$e['emp_id']][$i])=='0.5' && $reml[$e['emp_id']][$i]=='half-day'){
echo '<span style="color:red;">'.$ltypes.'(H)</span>'; 
}else{
echo '<span style="color:red;">'.$ltypes.'</span>'; 
}
}else{
  $st = '0.5';
  if(trim($durl[$e['emp_id']][$i])=='0.5' && $reml[$e['emp_id']][$i]=='half-day'){
    $ds = '(H)';
  }elseif($reml[$e['emp_id']][$i]=='hrs'){
    $ds = '(Hrs)';
  }else{
    $ds ='(F)';
  }
//print_r($special_case[$e['emp_id']][2]);
echo '<span style="color:green;">'.$ltypes.''.$ds.'</span>'; 
}

$total_count[$e['emp_id']][$ltypes][]=$dur1;
}elseif($status[$e['emp_id']][$i]=='sunday'){
  echo '<span style="color:red;">Sun</span>'; 
}elseif($status[$e['emp_id']][$i]=='holiday'){
  echo '<span style="color:red;">Hol</span>'; 
}
// echo $status[$e['emp_id']][$i] ; ?>
                                    </td>
                                    <?php //}else{?>
                                    <?php }?>
                                    <td colspan='6'>Total:  
                                      <?php echo $grand_total[$e['emp_id']]; ?>
                                    </td>
                                  </tr>
                                  <?php }//echo"<pre>";print_r($timedayin);echo"</pre>";echo"<pre>";print_r($timedayout);echo"</pre>";  ?>
                                </tbody>
                              </table>
                              </div>
                            <?php } else{?>
                            <div>
                              <label style="color:red">
                                <b>No Attendance available.....
                                </b>
                              </label>
                            </div>
                            <?php } ?>
                          </div>