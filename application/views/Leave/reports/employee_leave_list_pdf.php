<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sandip Academy</title>
<style>
body {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size: 12px;
}
table {
	width: 100%
}
table tr th{font-size:13px;}
table tr td, table tr th {
	padding-left: 5px;
  padding-right:5px;
	vertical-align:middle;
  xxtext-align:center;
}
</style>

</head>

<body>
<?php  ?>
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="xborder:1px solid #333;">
    <tr>
      <th  align="left" width="33%"> 
<?php
//echo $smonth;
 if($styp=='monthly'){
  
$m =date('m',strtotime('01-'.$smonth));
$y=date('Y',strtotime('01-'.$smonth));
//echo $m;
if($m <= '6'){
$ny=$y-1;
 $n= substr( $y, -2 );
$ac= $ny."-".$n;

}else{
$ny=$y+1;
 $n= substr( $ny, -2 );
$ac= $y."-".$n;
}
//echo $ac;
}else{
  $ex = explode("-",$smonth);
//$m =date('m',strtotime('01-'.$ex[0].'-'.$ex[1]));
$y=date('Y',strtotime('01-'.$ex[0].'-'.$ex[1]));
$ny=$y+1;
 $n= substr( $ny, -2 );
$ac = $y."-".$n;
}

echo '<strong>Academic Year | '.$ac.'</strong>';
?>

       <?php //$this->config->item('current_year')
       ?> </th>
      <th  align="center" width="33%"><h3 style="margin:5PX;">LEAVE DETAILS</h3></th>
      <th   align="right">
<?php if($styp=='monthly'){ ?>
      <strong>Month |</strong> <?php echo date('F',strtotime('01-'.$smonth)); ?>
      <?php }else{ 
       // echo $smonth;
$ex = explode("-",$smonth);
//print_r($ex);
//echo $ex[2];
//echo '01-'.$ex[2].'-'.$ex[3];
        ?>
      <strong><?php echo date('M Y',strtotime('01-'.$ex[0].'-'.$ex[1])); ?>  To
              <?php echo date('M Y',strtotime('01-'.ltrim($ex[2],' ').'-'.ltrim($ex[3],' '))); ?> </strong> 
      <?php } ?></th>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="border:1px solid #333;">
    <tr>
      <td width="50%" style="border-right:1px solid #333;"><strong>Staff Id :</strong> <?php echo $val['emp_id']; ?> </td>
      <td><strong>Department : </strong><?php echo $val['department_name']; ?></td>
    </tr>
    <tr>
    <td style="border-right:1px solid #333;"><strong>Name : </strong> <?php echo $val['fname']." ".$val['lname']; ?></td>
    <td><strong>School : </strong><?php echo $val['college_name']; ?></td>
    </tr>
    <tr>
       <td style="border-right:1px solid #333;"><strong>Designation : </strong> <?php echo $val['designation_name']; ?></td>
       <td><strong>Date of Joining : </strong><?php echo date('d-m-Y',strtotime($val['joiningDate'])); ?></td>
    </tr>
  </table>
  <br /><br />
  
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <th colspan="3" align="left" style="color:red">Casual Leave (CL)</th>
    </tr>
    <?php $cl = $this->leave_model->get_emp_leaves($val['emp_id'],'CL',$ac); 
$bal = $cl[0]['leaves_allocated'] - $cl[0]['leave_used'];

    ?>
    <tr>
    <th align="left"><strong>Entitled: <?php echo $cl[0]['leaves_allocated']; ?></strong></th>
    <th align="left"><strong>Availed:<?php echo $cl[0]['leave_used']; ?></strong></th>
    <th align="left"><strong>Balance:<?php echo $bal; ?></strong></th>
  </tr>

</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#c5e0b3"><strong>Sr No</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Application Id</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>From Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>To Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>No. of Days</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approved by</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approval Date</strong></td>
  </tr>
  <?php $i=1; $lev_list = $this->leave_model->getMyAllLeave_typ($val['emp_id'],$cl[0]['id'],$smonth,$styp);
  foreach($lev_list as $lval){ 
       $appr = $this->leave_model->get_approved_reporting_leave($lval['lid']);
  echo "<tr>
    <td align='center'>".$i."</td>
    <td align='center'>".$lval['lid']."</td>
    <td align='center'>".date('d-m-Y',strtotime($lval['applied_from_date']))."</td>
     <td align='center'>".date('d-m-Y',strtotime($lval['applied_to_date']))."</td>
     <td align='center'>".$lval['no_days']."</td>
    <td align='center'>".$appr[0]['empidl']." - ".$appr[0]['fname']." ".$appr[0]['lname']."</td>
    <td align='center'>".date('d-m-Y',strtotime($appr[0]['empidd']))."</td>
  </tr>";
  $i++; } 
//unset($cl);unset($lev_list);
  ?>
</table>
<br /><br />

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <th colspan="3" style="color:red" align="left"> Medical Leave (ML)</th>
     <?php $ml = $this->leave_model->get_emp_leaves($val['emp_id'],'ML',$ac); 
$mlbal = $ml[0]['leaves_allocated'] - $ml[0]['leave_used'];

    ?>
    </tr>
      <tr>
    <th align="left" ><strong>Entitled:<?php echo $ml[0]['leaves_allocated'];?></strong></th>
    <th align="left" ><strong>Availed:<?php echo $ml[0]['leave_used'];?></strong></th>
    <th align="left" ><strong>Balance:<?php echo $mlbal;?></strong></th>
  </tr>
  
 
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#c5e0b3"><strong>Sr No</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Application Id</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>From Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>To Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>No. of Days</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approved by</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approval Date</strong></td>
  </tr>
  <?php 
  if(!empty($ml[0]['id'])){
    $k=1; $lev_listml = $this->leave_model->getMyAllLeave_typ($val['emp_id'],$ml[0]['id'],$smonth,$styp);
  foreach($lev_listml as $lvalm){ 
 $apprm = $this->leave_model->get_approved_reporting_leave($lvalm['lid']);
  echo "<tr>
    <td align='center'>".$k."</td>
    <td align='center'>".$lvalm['lid']."</td>
    <td align='center'>".date('d-m-Y',strtotime($lvalm['applied_from_date']))."</td>
     <td align='center'>".date('d-m-Y',strtotime($lvalm['applied_to_date']))."</td>
     <td align='center'>".$lvalm['no_days']."</td>
     <td align='center'>".$apprm[0]['empidl']." - ".$apprm[0]['fname']." ".$apprm[0]['lname']."</td>
    <td align='center'>".date('d-m-Y',strtotime($apprm[0]['empidd']))."</td>
  </tr>";
  $k++; } }else{ ?>
<tr>
    <td >-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
  </tr>
  <?php } ?>
</table>


<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <th colspan="3" style="color:red" align="left"> Maternity Leave (MTL)</th>
    </tr>
      <tr>

    <th align="left" ><strong>Entitled:</strong></th>
    <th align="left" ><strong>Availed:</strong></th>
    <th align="left" ><strong>Balance:</strong></th>
  </tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#c5e0b3"><strong>Sr No</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Application Id</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>From Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>To Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>No. of Days</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approved by</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approval Date</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <th colspan="3" align="left" style="color:red"> Compensatory Off (C off)</th>
    </tr>
      <tr>
        <?php $coff = $this->leave_model->get_emp_leaves($val['emp_id'],'C-OFF',$ac); 
$coffbal = $coff[0]['leaves_allocated'] - $coff[0]['leave_used'];

    ?>
    <th align="left" ><strong>Entitled:<?php echo $coff[0]['leaves_allocated']; ?></strong></th>
    <th align="left" ><strong>Availed:<?php echo $coff[0]['leave_used']; ?></strong></th>
    <th align="left" ><strong>Balance:<?php echo $coffbal; ?></strong></th>
  </tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  
      
  <tr>
    <td align="center" bgcolor="#c5e0b3"><strong>Sr No</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Application Id</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>From Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>To Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>No. of Days</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approved by</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approval Date</strong></td>
  </tr>
  <?php 
if(!empty($coff[0]['id'])){
  $j=1; $lev_listc = $this->leave_model->getMyAllLeave_typ($val['emp_id'],$coff[0]['id'],$smonth,$styp);
  
  foreach($lev_listc as $lvalc){ 
    $apprc = $this->leave_model->get_approved_reporting_leave($lvalc['lid']);
  echo "<tr>
    <td>".$j.$coff[0]['id']."</td>
    <td>".$lvalc['lid']."</td>
    <td>".date('d-m-Y',strtotime($lvalc['applied_from_date']))."</td>
     <td>".date('d-m-Y',strtotime($lvalc['applied_to_date']))."</td>
     <td>".$lvalc['no_days']."</td>
      <td>".$apprc[0]['empidl']." - ".$apprc[0]['fname']." ".$apprc[0]['lname']."</td>
    <td>".date('d-m-Y',strtotime($apprc[0]['empidd']))."</td>
  </tr>";
  $j++; } }else{ ?>
<tr>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
  </tr>
  <?php } ?>
</table>
<br/><br />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <th colspan="3" align="left" style="color:red">Earned Leave (EL)</th>
    </tr>
    <?php $el = $this->leave_model->get_emp_leaves($val['emp_id'],'EL',$ac); 
    //print_r($el);exit;
$bal = $el[0]['leaves_allocated'] - $el[0]['leave_used'];

    ?>
    <tr>
    <th align="left"><strong>Entitled: <?php echo $el[0]['leaves_allocated']; ?></strong></th>
    <th align="left"><strong>Availed:<?php echo $el[0]['leave_used']; ?></strong></th>
    <th align="left"><strong>Balance:<?php echo $bal; ?></strong></th>
  </tr>

</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#c5e0b3"><strong>Sr No</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Application Id</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>From Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>To Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>No. of Days</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approved by</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approval Date</strong></td>
  </tr>
  <?php //print_r($smonth); exit;
if(!empty($el[0]['id'])){
   $i=1; $lev_list = $this->leave_model->getMyAllLeave_typ($val['emp_id'],$el[0]['id'],$smonth,$styp);
  foreach($lev_list as $lval){ 
       $appr = $this->leave_model->get_approved_reporting_leave($lval['lid']);
  echo "<tr>
    <td align='center'>".$i."</td>
    <td align='center'>".$lval['lid']."</td>
    <td align='center'>".date('d-m-Y',strtotime($lval['applied_from_date']))."</td>
     <td align='center'>".date('d-m-Y',strtotime($lval['applied_to_date']))."</td>
     <td align='center'>".$lval['no_days']."</td>
    <td align='center'>".$appr[0]['empidl']." - ".$appr[0]['fname']." ".$appr[0]['lname']."</td>
    <td align='center'>".date('d-m-Y',strtotime($appr[0]['empidd']))."</td>
  </tr>";
  $i++; } }
//unset($cl);unset($lev_list);
  ?>
</table>
<br/><br />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <th colspan="3" align="left" style="color:red">Leave </th>
    </tr>
    <?php $lev = $this->leave_model->get_emp_leaves($val['emp_id'],'Leave',$ac); 
    //print_r($el);exit;
$ballev = $lev[0]['leaves_allocated'] - $lev[0]['leave_used'];

    ?>
    <tr>
    <th align="left"><strong>Entitled: <?php echo $lev[0]['leaves_allocated']; ?></strong></th>
    <th align="left"><strong>Availed:<?php echo $lev[0]['leave_used']; ?></strong></th>
    <th align="left"><strong>Balance:<?php echo $ballev; ?></strong></th>
  </tr>

</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#c5e0b3"><strong>Sr No</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Application Id</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>From Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>To Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>No. of Days</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approved by</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approval Date</strong></td>
  </tr>
  <?php //print_r($smonth); exit;
if(!empty($lev[0]['id'])){
   $i=1; $lev_listl = $this->leave_model->getMyAllLeave_typ($val['emp_id'],$lev[0]['id'],$smonth,$styp);
  foreach($lev_listl as $lvall){ 
       $appr = $this->leave_model->get_approved_reporting_leave($lvall['lid']);
  echo "<tr>
    <td align='center'>".$i."</td>
    <td align='center'>".$lvall['lid']."</td>
    <td align='center'>".date('d-m-Y',strtotime($lvall['applied_from_date']))."</td>
     <td align='center'>".date('d-m-Y',strtotime($lvall['applied_to_date']))."</td>
     <td align='center'>".$lvall['no_days']."</td>
    <td align='center'>".$appr[0]['empidl']." - ".$appr[0]['fname']." ".$appr[0]['lname']."</td>
    <td align='center'>".date('d-m-Y',strtotime($appr[0]['empidd']))."</td>
  </tr>";
  $i++; } }
//unset($cl);unset($lev_list);
  ?>
</table>
<br/><br />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <th colspan="3" align="left" style="color:red"> Vacation (VL)</th>
    </tr>
    <?php $vl = $this->leave_model->get_emp_leaves($val['emp_id'],'VL',$ac); 
    foreach($vl as $vls){
      $vlids[] = $vls['id'];
      $aloc[] = $vls['leaves_allocated'];
      $usd[] = $vls['leave_used'];
    }
$vlbal = array_sum($aloc) - array_sum($usd);

    ?>
 <tr>
    <th align="left" ><strong>Entitled:<?php echo array_sum($aloc); ?></strong></th>
    <th align="left" ><strong>Availed:<?php echo array_sum($usd); ?></strong></th>
    <th  align="left" ><strong>Balance:<?php echo $vlbal; ?></strong></th>
  </tr>
  

</table>

<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#c5e0b3"><strong>Sr No</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Application Id</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>From Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>To Date</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>No. of Days</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approved by</strong></td>
    <td align="center" bgcolor="#c5e0b3"><strong>Approval Date</strong></td>
  </tr>
  <?php 
if(!empty($aloc)){
  foreach($vlids as $vlid){
  $j=1; $lev_listvl = $this->leave_model->getMyAllLeave_typ($val['emp_id'],$vlid,$smonth,$styp);
  
  foreach($lev_listvl as $lvalvl){ 
    $apprvl = $this->leave_model->get_approved_reporting_leave($lvalvl['lid']);
  echo "<tr>
    <td>".$j."</td>
    <td>".$lvalvl['lid']."</td>
    <td>".date('d-m-Y',strtotime($lvalvl['applied_from_date']))."</td>
     <td>".date('d-m-Y',strtotime($lvalvl['applied_to_date']))."</td>
     <td>".$lvalvl['no_days']."</td>
      <td>".$apprvl[0]['empidl']." - ".$apprvl[0]['fname']." ".$apprvl[0]['lname']."</td>
    <td>".date('d-m-Y',strtotime($apprvl[0]['empidd']))."</td>
  </tr>";
  $j++; } } }else{ ?>
<tr>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
  </tr>
  <?php } ?>
</table>
<?php  ?>
</body>
</html>
