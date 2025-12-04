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
$cm = date('m');
$nod =  cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch); 
if($cm == $msearch){
$totaldaysd= date('d')-1; 
}else{
$totaldaysd=cal_days_in_month(CAL_GREGORIAN, $msearch, $ysearch);
}			
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
  <!--<strong>Date :</strong> ___ /___ /_________-->
  </td>
  </tr>
  </table>
  
</div>
</div>



<div class="attexl" id="ReportTable1" style="">
                            <?php
							 /* echo "<pre>";
              print_r($attendance); 
			  exit(); */ 
if(!empty($attendance)){
	//echo'sdsd';exit;
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
                                    <td  colspan="7" style="border: 1px solid black;">Total
                                    </td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
$sr=0;
$total_count = array();
$grand_total=array();
foreach($all_emp as $e ){
$det = $this->Admin_model->getEmployeeById1($e['emp_id'],'y');
$name = $det[0]['fname']." ".$det[0]['mname']." ".$det[0]['lname'];
$staff_type=$det[0]['staff_type'];
$designation_name=$det[0]['designation_name'];
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
                                     <td style="border:1px solid black;">WFH
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
$emp_data=array();
$durttime='';
$it='';
$ot='';

foreach($attendance[$e['emp_id']] as $att){ 
$emp_id=$e['emp_id'];
 $designation_name=$att['designation_name'];
$fmins_array=array('HR Executive','Telecaller','Telecalling Executive');
 $no_limit=array('Business Development Executive','Business Development Manager');

$md=date('Y-m-d',strtotime($att['Intime']));

//if (!in_array($emp_id, $emp_data)) {
   $sqe="select in_time,out_time,buffer_time from employee_shift_time where emp_id=$emp_id  and 
STR_TO_DATE(active_from,'%Y-%m-%d')<='$md' and status='Y' ORDER BY emp_shift_id DESC LIMIT 1";

$get_shift_time=$this->db->query($sqe)->row();

if(empty($get_shift_time)){
	  $sqe="select in_time,out_time,buffer_time from employee_shift_time where emp_id=$emp_id  and 
STR_TO_DATE(active_from,'%Y-%m-%d')<='$md'   ORDER BY emp_shift_id DESC LIMIT 1   ";

$get_shift_time=$this->db->query($sqe)->row();
}
//array_push($emp_data,$emp_id);

//if(!empty($get_shift_time)){
 $it=$get_shift_time->in_time;
	
 $ot=$get_shift_time->out_time;
	
$buffer_time=$get_shift_time->buffer_time;

if($designation_name=='Telecaller' || $emp_id==211505 || in_array($designation_name, $fmins_array)){
	$buffer_time=30;
}

if(in_array($designation_name, $no_limit)){
	$buffer_time=300;
}





if(empty($buffer_time)){
	$buffer_time=5;
}
$buffer_time=$buffer_time+1;
$durttime=$this->Admin_model->get_time_difference($it, $ot);
$d=date('d',strtotime($att['Intime']));
$d = intval($d);




$dayIn[$e['emp_id']][$d]=$d; //array for only punched In day 
$tempdayin[$e['emp_id']][$d]=$dayIn[$e['emp_id']][$d];
$timedayin[$e['emp_id']][$d]=$att['Intime'];
$status[$e['emp_id']][$d]=$att['status'];
$leave[$e['emp_id']][$d]=$att['leave_type'];
$durl[$e['emp_id']][$d]=$att['leave_duration'];


$shfi[$e['emp_id']][$d]=$it;
$shfo[$e['emp_id']][$d]=$ot;
$shd[$e['emp_id']][$d]=$durttime;
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


$diff1[$e['emp_id']][$d]=$diff;
//$dur[$d]= $diff;   
$timedayout[$e['emp_id']][$d]=$att['Outtime']; 
$timedayin[$e['emp_id']][$d]=$att['Intime']; 
}

 } 
$CI =& get_instance();
$CI->load->model('Leave_model');
?>
<?php
//$mn=$dur;
//echo "<pre>";
//print_r($diff1);
//exit;
$dur=$diff1[$e['emp_id']];
$eidd= $e['emp_id'];
for($i=1;$i<=count($totaldays['total']);$i++){
	$difference = '';
	
//first check holiday and sunday ***********************
 $dname=$attend_date."-".$totaldays['total'][$i-1];
 $datte=date('Y-m-d', strtotime($dname));

$check_holiday=$this->Admin_model->checkHoliday_new($dname,$staff_type);//check for holiday
$check_holiday;//die();


//echo '<br>';
if($check_holiday=='true'){
$day_name="Holiday";
}else{
$day_name = date('D', strtotime($dname));
}
$worked_hours = '';
$worked_hours1=0;
$compulsory_hours='';

if (array_key_exists($i,$dur)){
	
$worked_hours1=$worked_hours = new DateTime($dur[$i]);
$worked_hours = $worked_hours->format('H:i');
$worked_hours1= $worked_hours1->format('H');


}



$compulsory_hours = new DateTime($shd[$e['emp_id']][$i]);
$compulsory_hours->modify('-5 minutes');
$compulsory_hours = $compulsory_hours->format('H:i');


if(!empty($worked_hours)){
	
 $difference = $worked_hours."-".$compulsory_hours;

$mt1 = new DateTime($worked_hours);
$mt2 = new DateTime($compulsory_hours);

// Calculate the difference between the two DateTime objects
$difference = $mt1->diff($mt2);
$difference =$difference->format('%H:%i');
}
if($status[$e['emp_id']][$i] =='present' ){
	
if(date('H:i',strtotime($timedayin[$e['emp_id']][$i])) !='00:00'){
	

$is=$this->db->get_where('leave_adjustment_list',array('emp_id'=>$eidd,'adjust_date'=>$datte))->row();


if($compulsory_hours <= $worked_hours){

	//echo $i."done";
	//echo "<br>";
	//echo print_r($shfi[$e['emp_id']][$i]);
	
	$ittocheck = new DateTime($shfi[$e['emp_id']][$i]);
    $ittocheck->modify("+$buffer_time minutes");
	$ittocheck = $ittocheck->format('H:i:s');	
    $intime_d= date('H:i:s',(strtotime($timedayin[$e['emp_id']][$i])));
 
   
  
  //
  
   if(strtotime($intime_d)<strtotime($ittocheck)){
	  $total_count[$e['emp_id']]['present'][]='1'; 
   }
   elseif(empty($is)){
		$status[$e['emp_id']][$i]='leave';
		$leave[$e['emp_id']][$i]="LWP";
		$reml[$e['emp_id']][$i]="half-day";
		$durl[$e['emp_id']][$i]='0.5';
		$total_count[$e['emp_id']]["LWP"][]='0.5';
		$total_count[$e['emp_id']]['present'][]='0.5';  
   }
   else{
	  $total_count[$e['emp_id']]['present'][]='1';  
   }
	
	//$total_count[$e['emp_id']]['present'][]='1'; 
}
elseif(!empty($special_case[$e['emp_id']][$i])){
	$total_count[$e['emp_id']]['present'][]='1';
	
}
else{

	
	
	if(empty($is)){
		
    //$total_count[$e['emp_id']]['present'][]='1';
	$status[$e['emp_id']][$i]='leave';
	$leave[$e['emp_id']][$i]="LWP";
	$reml[$e['emp_id']][$i]="half-day";
	$durl[$e['emp_id']][$i]='0.5';
    $total_count[$e['emp_id']]["LWP"][]='0.5';
    $total_count[$e['emp_id']]['present'][]='0.5';
	}
	else{
		$total_count[$e['emp_id']]['present'][]='1';
	}
}


}
elseif($e['emp_id']=="120001" || $e['emp_id']=="120220"){
$total_count[$e['emp_id']]['present'][]='1';	
}

}

elseif(($status[$e['emp_id']][$i]=='leave') || ($status[$e['emp_id']][$i]=='outduty')){
	
$ltypes=$leave[$e['emp_id']][$i];
$ltypes = strtoupper($ltypes);
$dur1 = $durl[$e['emp_id']][$i]; 

if($leave[$e['emp_id']][$i]=='WFH'){
$total_count[$e['emp_id']]['WFHH'][]='1';
}

 $rem = $reml[$e['emp_id']][$i];

if((trim($dur1)=='0.5')&& ($rem == 'hrs' || $rem == 'half-day')){

if(substr($ltypes, -1) === '*'){
	// echo 'kk';//exit;
   $total_count[$e['emp_id']]['LWP'][]='0.5';
   $total_count[$e['emp_id']][substr($ltypes,0,-1)][]=$dur1;
}else{
   // echo 'jj';//exit;
 
  if(trim($rem) === 'hrs'){
  $total_count[$e['emp_id']][$ltypes][]='0.5';
  $total_count[$e['emp_id']]['present'][]='0.5';
  //$total_count[$e['emp_id']]['present'][]='0.5';
   }else{
	  //  echo $rem.'mm';//exit;
   $total_count[$e['emp_id']][$ltypes][]=$dur1;
   $total_count[$e['emp_id']]['present'][]='0.5';
   
   }
   
}

}else{  

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

//echo $i."---".$worked_hours1."---".$worked_hours."----".$eidd;
//echo "</br>";

//echo $i."//".$eidd;
	
	//echo "</br>";
if(($status[$e['emp_id']][$i]=="holiday" || $status[$e['emp_id']][$i]=="sunday") &&  $worked_hours1 ==0){
	
	$is_ok=0;
	$nxtworkingday='';
	$pvsworkingday='';
	$n=$m=$i;
	for($m=$i-1;$m>0;$m--){
		if($status[$e['emp_id']][$m]!="holiday" && $status[$e['emp_id']][$m]!="holiday" && $status[$e['emp_id']][$m]!="sunday" && $status[$e['emp_id']][$m]!="sunday"){
			$pvsworkingday=$m;
			break;
		}
		//echo $m;
	}
	//echo "forward loop";echo "<br>";
	
	
	$tdys=count($totaldays['total'])+1;
	//$tdys=31;
	for($n=$i+1;$n<$tdys;$n++){
		if($status[$e['emp_id']][$n]!="holiday" && $status[$e['emp_id']][$n]!="holiday" && $status[$e['emp_id']][$n]!="sunday" && $status[$e['emp_id']][$n]!="sunday"){
			$nxtworkingday=$n;
			break;
		}
	}


//echo $pvsworkingday."---".$nxtworkingday;


				if(empty($pvsworkingday)){
				//echo $
				$previous_date_to_compare=$this->db->query("SELECT status,leave_type,leave_duration,remark FROM punching_backup WHERE UserId='$eidd'   
				AND STATUS !='sunday'
				AND STATUS !='holiday'
				AND STR_TO_DATE(Intime,'%Y-%m-%d')<'$datte'
				ORDER BY STR_TO_DATE(Intime,'%Y-%m-%d') DESC LIMIT 1")->row();
				
					if(!empty($previous_date_to_compare)){
						
				if($previous_date_to_compare->status=="present"  
				|| $previous_date_to_compare->leave_type=="OD" || $previous_date_to_compare->leave_type=="OD*" ||$previous_date_to_compare->leave_duration=='0.5'   )
				{
				$is_ok=1;
				}	
				}

				}
				
				
				if(empty($nxtworkingday)){
				$next_date_to_compare=	$this->db->query("SELECT status,leave_type,leave_duration,remark,Intime FROM punching_backup WHERE UserId='$eidd'   
				AND STATUS !='sunday'
				AND STATUS !='holiday'
				AND STR_TO_DATE(Intime,'%Y-%m-%d')>'$datte'
				ORDER BY  STR_TO_DATE(Intime,'%Y-%m-%d') ASC LIMIT 1")->row();
				//echo $this->db->last_query();
				
				if(!empty($next_date_to_compare)){
					//echo $datte;
					//exit;
					$check_date=strtotime("$datte 00:00:00");
					//$compare_date=(date('Y-m-d H:i:s',($check_date)));
					
					//|| $next_date_to_compare->Intime
					if($next_date_to_compare->status=="present"  
				|| $next_date_to_compare->leave_type=="OD" || $next_date_to_compare->leave_type=="OD*" ||$next_date_to_compare->leave_duration=='0.5' || strtotime($next_date_to_compare->Intime) > $check_date  ){
                  $is_ok=1;
				}	
				}
				
				}
				
				
	
	if($status[$e['emp_id']][$pvsworkingday]=="present"  || $status[$e['emp_id']][$nxtworkingday]=="present" 
	|| $leave[$e['emp_id']][$nxtworkingday]=="OD" || $leave[$e['emp_id']][$pvsworkingday]=="OD" || 
	$durl[$e['emp_id']][$pvsworkingday]==0.5 || 
	$durl[$e['emp_id']][$nxtworkingday]==0.5  ){
		
	}
	elseif($is_ok==1){
		
	}
	

	else{
		
		if($status[$e['emp_id']][$i]=="sunday"){
			$remove_lpw[] = '1';
		}
		else{
		
		
	    $remove_lph[] = '1';
		}
		$status[$e['emp_id']][$i]="leave";
		$leave[$e['emp_id']][$i]="LWP";
	}

}
?>
                                 
                                    <td style="border: 1px solid black;<?php echo $col; echo $lm; ?>">
                                      <?php  if($timedayin[$e['emp_id']][$i]!=''){ if(date('H:i',strtotime($timedayin[$e['emp_id']][$i]))=='00:00'){ echo "00:00"; }else{ echo  date('H:i',strtotime($timedayin[$e['emp_id']][$i]));} }else{ echo '00:00'; } ?>
									  <? //echo ($difference)."--".$emp_id."--".$datte;
									     //print_r($att['DeviceLogId']);
									  
									  
										$dt['extra_working_hours']=$difference;
										$dt['UserId']=$emp_id;
										$dt['datte']=$datte;
										
										///$this->Admin_model->update_employee_dta_for_working_hours($dt);
									  ?>
									  
									  
									  
									  
                                    </td>
                                   
                                    <?php   }

                                     ?>
                                    <td style="border:1px solid black;">
                                      <?php echo $p = array_sum($total_count[$e['emp_id']]['present']);
									 // print_r($total_count[$e['emp_id']]['present']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php echo $whf = array_sum($total_count[$e['emp_id']]['WFH']);
									 // print_r($total_count[$e['emp_id']]['present']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php   $s = array_sum($total_count[$e['emp_id']]['sun']); 
									         $lp= array_sum ($remove_lpw);
									
									  echo ($s-$lp); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php  
									  $h = array_sum($total_count[$e['emp_id']]['holiday']);
									  $lph=array_sum ($remove_lph);
									 echo  $h-$lph;
									   ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php  $lwp = array_sum($total_count[$e['emp_id']]['LWP']); 
									  echo ($lwp+$lp);
									  ?>
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
                                     <td style="border:1px solid black;">&nbsp;
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
                   <?//=$shfi[$e['emp_id']][$i].$shfo[$e['emp_id']][$i].$shd[$e['emp_id']][$i];

				   ?>               

								  </td>
                  <?php } ?>         
                                    <td style="border:1px solid black;">
                                      <?php echo $co = array_sum($total_count[$e['emp_id']]['C-OFF']); ?>
                                    </td>
                                    <td style="border:1px solid black;">
                                      <?php //echo $co = array_sum($total_count[$e['emp_id']]['C-OFF']); ?>
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
									$pp=$whf+$p+$cl+$sl+$ml+$el+$vl+$od+$lv+$co+$s+$h;
									if(($pp!=0)){           
//$grand_total[$e['emp_id']]=0; //$p+$s+$h+$od+$co+$cl+$sl+$el+$ml+$vl+$lv; 
                                        $lpp= array_sum ($remove_lpw);
										$lphh= array_sum ($remove_lph);
$grand_total[$e['emp_id']]= ($p+$s+$h+$od+$co+$cl+$sl+$el+$ml+$vl+$lv+$whf -$lpp)-$lphh; //-$lwp
									}else{
										$lpp= array_sum ($remove_lpw);
										$lphh=array_sum ($remove_lph);
$grand_total[$e['emp_id']]= 0;//($p+$od+$co+$cl+$sl+$el+$ml+$vl+$lv+$whf -$lpp)-$lphh; //$s+$h 
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
                                      <?php 
if($status[$e['emp_id']][$i]=='present'){
//echo $timedayin[$e['emp_id']][$temp1];
if(date('H:i:s',strtotime($timedayout[$e['emp_id']][$i]))=='00:00:00' || date('H:i:s',strtotime($timedayin[$e['emp_id']][$i]))=='00:00:00'){
echo "";
/*if($e['emp_id']=="120001"){
		echo 'P';
	}*/
}else{
echo 'P';
if(!empty($special_case[$e['emp_id']][$i])){
echo '('.$special_case[$e['emp_id']][$i].')';
}

}
if($e['emp_id']=="120001" || $e['emp_id']=="120220" ){
	echo 'P';}


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
// echo $status[$e['emp_id']][$i] ;
unset($remove_lpw);unset($remove_lph);

$data['UserId']=$e['emp_id'];
$data['ename']=$name;
$data['total_present']=$p !=0 ? $p :0;
$data['sunday']=($s-$lp)!=0 ? ($s-$lp) :0;
$data['holiday']=($h-$lph)!=0 ? ($h-$lph) :0;
$data['total_outduty']=$od!=0 ? $od :0;
$data['CL']=$cl!=0 ? $cl :0;
$data['ML']=$ml!=0 ? $ml :0;
$data['EL']=$el!=0 ? $el :0;
$data['C-Off']=$co!=0 ? $co :0;
$data['SL']=$sl!=0 ? $sl :0;
$data['VL']=$vl!=0 ? $vl :0;
$data['LEAVES']=$lv!=0 ? $lv :0;
$data['LWP']=$lwp!=0 ? $lwp :0;
$data['WFH']=$whf!=0 ? $whf :0;
$data['Total']=($grand_total[$e['emp_id']])!=0 ? ($grand_total[$e['emp_id']]) :0;
$data['for_month_year']=$ysearch.'-'.$msearch.'-'.$nod;
$data['month_days']=$totaldaysd;
$data['is_final']='Y';
$data['working_days']=$totaldaysd-$data['sunday']-$data['holiday'];


//$data['working_days']=$difference;
$this->Admin_model->update_employee_att($e['emp_id'],$data);


 ?>
                                    </td>
                                    <?php //}else{?>
                                    <?php }?>
                                    <td colspan='7'>Total:  
                                      <?php echo $grand_total[$e['emp_id']]; ?>
                                    </td>
                                  </tr>
                                  <?php }//echo"<pre>";print_r($timedayin);echo"</pre>";echo"<pre>";print_r($timedayout);echo"</pre>";  ?>
                                </tbody>
                              </table>
                              </div>
                            <?php }else{ //echo'sdsd21212';exit; ?>
                            <div>
                              <label style="color:red">
                                <b>No Attendance available.....
                                </b>
                              </label>
                            </div>
                            <?php }  ?>
                          </div>