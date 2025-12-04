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
    padding: 5px;
	border-collapse: collapse;
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
<div align="center" style="text-align:center"><b>Monthly Visiting Staff Attendance Report Of 
                                      <?=$monthName?>
                                      <?=$ysearch?>
                                    </b></div></div>
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
                                    <?php } ?>
                                    <td  colspan="6" style="border: 1px solid black;">Total
                                    </td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php 
								  //echo "<pre>";
//print_r($attendance);
$sr=0;
$total_count = array();
$grand_total=array();
foreach($attendance as $key=>$e ){
// echo 
$emp1 = $this->Admin_model->getVisitingEmployeeDetails($key);
//  echo $key;
$name = $emp1[0]['fname']." ".$emp1[0]['mname']." ".$emp1[0]['lname'];

$sr++;   
?>
                                  <tr style="border: 1px solid black;">
                                    <td rowspan="5" style="border: 1px solid black;">
                                      <?=$sr;?>
                                    </td>
                                    <td colspan="<?=$lt+1+6?>" style="border: 1px solid black;">
                                      <?php  echo"<b>Staff ID:</b> ".$key."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."<b>Staff Name:</b> ".$name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."<b>Designation:</b> ".$emp1[0]['designation_name']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."<b>Department:</b> ".$emp1[0]['department_name']?>
                                    </td>
                                    
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <strong>In:
                                      </strong>
                                    </td>
                                    <?php 
foreach($attendance[$key] as $att){ 
$d=date('d',strtotime($att['Intime']));
$d = intval($d);
$dayIn[$key][$d]=$d; //array for only punched In day 
$tempdayin[$key][$d]=$dayIn[$key][$d];
$timedayin[$key][$d]=$att['Intime'];
$status[$key][$d]=$att['status'];

if($att['Outtime'] != '0000-00-00 00:00:00'){
$d=date('d',strtotime($att['Outtime']));
$d = intval( $d);
//echo "<br/>";
$dayOut[$key][$d]=$d; //array for only punched In day 
$tempdayout[$key][$d]=$dayOut[$key][$d];
//echo "<br/>";
$timedayout[$key][$d]=$att['Outtime'];
} 

if(date('H:i:s',strtotime($att['Outtime'])) != '00:00:00' || date('H:i:s',strtotime($att['Intime'])) != '00:00:00'){
$d=date('d',strtotime($att['Outtime']));
$d = intval($d);
//  echo $att['Intime'];
if(date('h:i:s',strtotime($att['Intime']))!='00:00:00')$time1=date('H:i',strtotime($att['Intime']));else $time1='00:00';
if(date('h:i:s',strtotime($att['Outtime']))!='00:00:00')$time2=date('H:i',strtotime($att['Outtime'])); else $time2='00:00';
$diff=$this->Admin_model->get_time_difference($time1, $time2);
$dur[$d]= $diff;   
$timedayout[$key][$d]=$att['Outtime']; 
$timedayin[$key][$d]=$att['Intime']; 
}
 } 

									$tds = count($totaldays['total']);
									for($i=1;$i<=$tds;$i++){
//first check holiday and sunday ***********************
$dname=$attend_date."-".$totaldays['total'][$i-1];

$day_name = date('D', strtotime($dname));


if($status[$key][$i] =='present' ){
if(date('H:i',strtotime($timedayin[$key][$i])) !='00:00'){

$total_count[$key]['present'][]='1';
// }
}
}



?>                                 
                                    <td style="border: 1px solid black;<?php echo $col; echo $lm;?>">
                                      <?php  if($timedayin[$key][$i]!=''){ if(date('H:i',strtotime($timedayin[$key][$i]))=='00:00'){ echo "00:00"; }else{ echo  date('H:i',strtotime($timedayin[$key][$i]));} }else{ echo '00:00'; } ?>
                                    </td>                                   
                                    <?php } ?>
                                    <td  colspan="6" style="border:1px solid black;">
                                      Remark:
                                    </td>
                                    
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <strong>Out:
                                      </strong>
                                    </td>
                                    <?php for($i=1;$i<=$tds;$i++){ ?>                                  
                                    <td style="border: 1px solid black;<?php echo $col; echo $em; ?>">
                                      <?php  if($timedayout[$key][$i]!=''){ if(date('H:i',strtotime($timedayout[$key][$i])) =='00:00') echo "00:00"; else{ echo  date('H:i',strtotime($timedayout[$key][$i]));}}else{echo '00:00';}?>
                                    </td>
                                   
                                    <?php  } ?>
                                    <td rowspan="2" colspan="6" style="border:1px solid black;">
                                      
                                    </td>
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <strong>Dur: </strong>
                                    </td>
                                    
                                    <?php for($i=1;$i<=$tds;$i++){            ?>                                   
                                    <td style="border: 1px solid black;">
                                      <?php 
                                      if($timedayin[$key][$i]!=''){
if(date('H:i',strtotime($timedayin[$key][$i]))!='00:00' && date('H:i:s',strtotime($timedayout[$key][$i]))!='00:00:00'){
if($dur[$i]!=''){
	$ex = explode(":",$dur[$i]);
	$durt[$key][]= $ex[0];
echo $dur[$i] ; }else{echo "00:00";} }else{echo "00:00";}}else{echo "00:00";} ?>
                                    </td>
                  <?php } ?>         
                                    
                                    
                                             
                                  </tr>
                                  <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black;">
                                      <strong>sta.:
                                      </strong>
                                    </td>
                                    
                                    <?php for($i=1;$i<=$tds;$i++){?>
                                    <td style="border: 1px solid black;">
                                      <?php 
if($status[$key][$i]=='present'){
//echo $timedayin[$key][$temp1];
if(date('H:i:s',strtotime($timedayout[$key][$i]))=='00:00:00' || date('H:i:s',strtotime($timedayin[$key][$i]))=='00:00:00')
{
echo "";
}else{
echo 'P';
}
$total_count[$key]['present'][]='1';
}
// echo $status[$key][$i] ; ?>
                                    </td>                                    
                                    <?php }?>
                                    <td colspan='6'><b>Total Dur:</b>  
                                      <?php echo array_sum($durt[$key]); ?>
                                    </td>
                                  </tr>
                                  <?php } ?>
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