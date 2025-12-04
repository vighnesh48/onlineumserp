<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Salary REGISTER</title>
<style> 
 .table tr td,.table tr th{
		  white-space: nowrap; font-size:20px;border:1px solid #333;word-wrap: break-word;  }
		  </style>
</head>

<body>
<div class="col-lg-12">
<?php include('pdf_header.php'); ?>
<hr  style="border-width:1px;">

</div>
<div style="white-space:nowrap;text-align:center;padding:10px;"><strong>SALARY REGISTER REPORT FOR THE MONTH OF <?php echo date('M Y',strtotime($dt));?></strong></div>
	<?php 
$ms=(sizeOf($emp_sal));
?>	
<table  border="0" style="page-break-inside:always;" id="saltab" class="table table-bordered table-hover" width="100%"  cellpadding="3" cellspacing="0">
								 
								  <tr>
								  <th style="border: 1px solid black;padding:20px;" colspan="7" >Teaching Staff</th>
								   <th style="border: 1px solid black;text-align:center;padding:20px;" colspan="9" ><b>Earnings</b></th>
								    <th style="border: 1px solid black;padding:20px;" colspan="1" ></th>
									 <th style="border: 1px solid black;text-align:center;padding:20px;" colspan="3" ><b>CTC</b></th>
									 <th style="border: 1px solid black;text-align:center;padding:20px;" colspan="9" ><b>Deductions</b></th>
									  <th style="border: 1px solid black;padding:20px;" colspan="3" ></th>
								  </tr>
								  <tr bgcolor="#9ed9ed"  >
	                              <th>Sr No.</th>
	                              <th>Staff Id</th>
	                              <th>Staff Name</th>
								  <th >Basic</th>
								  <th  >Sex</th>
								  <th >M.Days</th>
	                              <th  >P.Days</th>
	                              <th  >Basic</th>
								  <th  >DP</th>
								   <th  >DA</th>
	                              <th  >HRA</th>
	                              <th  >TA</th>
								  <th>Incr</th>
	                              <th  >Income<br/> Diff.</th>
	                              <th  >Other <br/>income</th>
	                              <th  >Special <br/> A.</th>
	                              <th  >Gross <br/>Total</th>
								  <th>Gratuity</th>
	                              <th>ER EPF</th>
								  <th>Total CTC</th>
								  <th>EPF</th>
								  <th>Gratuity</th>
								  <th>ER EPF</th>
	                              <th  >PTAX</th>
	                              <th  >TDS</th>
	                              <th  >Bus Ded.</th>
	                              <th  >Mob-Bill</th>
								  <th  >CoOp<br/>Soc</th>
	                              <th  >Office <br/>Adv.</th>	                              
	                              <th  >Other <br/>Deduc(Adv.)</th>
								  <th  >Total <br/>Deductions</th>
	                              <th  >Net Salary</th>	                            
								  </tr>
								  
								   
								   
								   
								   <tbody>		
<?php 
 $i=1;$j=0;$epf=0;$ptax=0;$k=1;
 $tgross = array();$tepf=array();$tptax=array();$ttds=array();$tbus=array();$tmobile=array();$tsoc=array();$toffadv=array();$tothadv=array();$tdet=array();$tnet=array();
	  	$month = cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($dt)),date('Y',strtotime($dt)));
		$staff_type1='';
//print_r($emp_sal);		
foreach($emp_sal as $key=>$val){
	 $staff_type=$emp_sal[$key]['staff_type'];
	if(($staff_type !=$staff_type1 && $staff_type1!='')){ 
	
	?>
		
					
 <tr><td>&nbsp;</td></tr>
 <tr>
<td colspan="7" style="font-weight: bold;padding:20px;text-align:right;" >Total</td>

<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_bs); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_dp); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_da); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_hra); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_ta); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_increment); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_diff); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_otha); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_spea); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_gross); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_gratuity); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_epf_er); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_ctc); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_edf); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_gratuity); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_epf_er); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_ptax); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_tds); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_busf); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_mobb); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_cos); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_offa); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_othad); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_othde); ?></td><td style="font-weight: bold;"><?php echo array_sum($tot_finntsal); ?></td>
 </tr>

				  <tr>
								  <td colspan="2" style="font-weight: bold;padding:10px;" rowspan="2">Total</td>
								  <td colspan="1" style="font-weight: bold;padding:10px;">Total Earning</td>
								   <td colspan="4" style="font-weight: bold;padding:10px;">EPF</td>
								    <td colspan="3" style="font-weight: bold;padding:10px;">PTAX</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">TDS</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">BUS Fare</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">MOBILE</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">CO-OP.Soc</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">Office Adv</td>
									 <td colspan="2" style="font-weight: bold;padding:10px;">Other</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">Total Deductions</td>
									 <td colspan="2" style="font-weight: bold;padding:10px;">Total Net Salary</td>
									 
								  </tr>
								  <tr>								 
								  <td style="font-weight: bold;padding:10px;"><?php echo array_sum($tgross); ?></td>
								 <td colspan="4" style="font-weight: bold;padding:10px;"><?php echo array_sum($tepf); ?></td>
								    <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($tptax);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($ttds);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($tbus);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($tmobile);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($tsoc);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($toffadv);?></td>
									 <td colspan="2" style="font-weight: bold;padding:10px;"><?php echo array_sum($tothadv);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($tdet);?></td>
									 <td colspan="2" style="font-weight: bold;padding:10px;"><?php echo array_sum($tnet);?></td>									
								  </tr>
								  
								 <?php

 $tgross = array();$tepf=array();$tptax=array();$ttds=array();$tbus=array();$tmobile=array();$tsoc=array();$toffadv=array();$tothadv=array();$tdet=array();$tnet=array();
	  	$month = cal_days_in_month(CAL_GREGORIAN,date('m',strtotime($dt)),date('Y',strtotime($dt)));
		
	$tot_bs= array();
	$tot_dp= array();
	$tot_da= array();
	$tot_hra= array();
	$tot_ta= array();
$tot_increment= array();
$tot_diff= array();
$tot_otha= array();
$tot_spea= array();
$tot_gross= array();
$tot_gratuity= array();
$tot_epf_er= array();
$tot_ctc= array();
$tot_edf= array();
$tot_gratuity= array();
$tot_epf_er= array();
$tot_ptax= array();
$tot_tds= array();
$tot_busf= array();
$tot_mobb= array(); 
$tot_cos= array(); 
$tot_othad= array();
$tot_othde= array();
$tot_finntsal= array();
		
		

 ?>								 
								  
								  
								  
 <tr colspan="31"><td style="border: 1px solid #ededed">&nbsp;</td></tr>
 
 
								  <tr>
								  <th style="border: 1px solid black;padding:20px;" colspan="7" >Non-Teaching Staff</th>
								   <th style="border: 1px solid black;text-align:center;padding:20px;" colspan="9" ><b>Earnings</b></th>
								    <th style="border: 1px solid black;padding:20px;" colspan="1" ></th>
									 <th style="border: 1px solid black;text-align:center;padding:20px;" colspan="3" ><b>CTC</b></th>
									 <th style="border: 1px solid black;text-align:center;padding:20px;" colspan="9" ><b>Deductions</b></th>
									  <th style="border: 1px solid black;padding:20px;" colspan="3" ></th>
								  </tr>
								  <tr bgcolor="#9ed9ed"  >
	                              <th>Sr No.</th>
	                              <th>Staff Id</th>
	                              <th>Staff Name</th>
								  <th >Basic</th>
								  <th  >Sex</th>
								  <th >M.Days</th>
	                              <th  >P.Days</th>
	                              <th  >Basic</th>
								  <th  >DP</th>
								   <th  >DA</th>
	                              <th  >HRA</th>
	                              <th  >TA</th>
								  <th>Incr</th>
	                              <th  >Income<br/> Diff.</th>
	                              <th  >Other <br/>income</th>
	                              <th  >Special <br/> A.</th>
	                              <th  >Gross <br/>Total</th>
								  <th>Gratuity</th>
	                              <th>ER EPF</th>
								  <th>Total CTC</th>
								  <th>EPF</th>
								  <th>Gratuity</th>
								  <th>ER EPF</th>
	                              <th  >PTAX</th>
	                              <th  >TDS</th>
	                              <th  >Bus Ded.</th>
	                              <th  >Mob-Bill</th>
								  <th  >CoOp <br/>Soc</th>
	                              <th  >Office <br/>Adv.</th>	                              
	                              <th  >Other <br/>Deduc(Adv.)</th>
								  <th  >Total <br/>Deductions</th>
	                              <th  >Net Salary</th>	                            
								  </tr>
								   
 
								  <tr style="margin-top:10px;">
	    <td><?php echo $k;?><!--<?=$staff_type?> --></td>	
		 <td><?php echo $val['emp_id']; ?></td>
		  <td style="white-space: nowrap;">
		  <?php if($val['gender']=='male'){
                                       echo 'Mr.';
									   }else if($val[$i]['gender']=='female'){ 
									   echo 'Mrs.';}
									  echo $val['fname']." ".$val['mname']." ".$val['lname'];
									  echo "<br/>";
									  $deg = $this->Staff_payment_model->getDesignationById($emp_sal[$key]['designation']);
									  echo $deg[0]['designation_name'];
									  echo "<br/>";
									 // echo "<br/>";
									  //$html .= "<p>";
									  if(!empty($emp_sal[$key]['pay_band_min'])&&!empty($emp_sal[$key]['pay_band_max'])&&!empty($emp_sal[$key]['pay_band_gt'])){
										 echo $emp_sal[$key]['pay_band_min']."-".$emp_sal[$key]['pay_band_max']."+AGP ".$emp_sal[$key]['pay_band_gt'];
									  }else {
										  echo $emp_sal[$key]['basic_salary']; 
									  } //$html .= "</p>";
									  ?>
									  </td>
                                     <td ><?php echo $emp_sal[$key]['basic_salary']; ?></td>
									 <td ><?php
									 if($emp_sal[$key]['gender']=='male'){ 
									 echo 'M';
									 }else{ 
									 echo 'F'; } ?>
									 </td>
									 <td ><?php echo $month; ?></td>
									 <td ><?php echo $emp_sal[$key]['pdays']; ?></td>
                                     <td ><?php echo $tot_bs[] = $emp_sal[$key]['basic_sal'];?></td>
									
									 <td style="width:20px;" width="20"><?php echo $tot_dp[] = $emp_sal[$key]['dp']; ?></td>									 
                                      <td ><?php echo $tot_da[] = $emp_sal[$key]['da']; ?></td>
									  <td ><?php echo $tot_hra[] = $emp_sal[$key]['hra']; ?></td>
									  <td ><?php echo $tot_ta[] = $emp_sal[$key]['ta'];?></td>
									  <td ><?php echo $tot_increment[] = $emp_sal[$key]['increment'];?></td>
									  <td ><?php echo $tot_diff[] = $emp_sal[$key]['difference']; ?></td>
									  <td ><?php echo $tot_otha[] = $emp_sal[$key]['other_allowance']; ?></td>
									 <td ><?php echo $tot_spea[] = $emp_sal[$key]['special_allowance']; ?></td>
									  <td style='font-weight: bold;'><?php echo $tot_gross[] = $emp_sal[$key]['gross'];?></td>
									  <td ><?php echo $tot_gratuity[] = $emp_sal[$key]['gratuity'];?></td>
									  <td ><?php echo $tot_epf_er[] = $emp_sal[$key]['epf_er'];?></td>
									  <td ><?php echo $tot_ctc[] = $emp_sal[$key]['ctc'];?></td>
									  <td ><?php echo $tot_edf[] = $emp_sal[$key]['epf'];?></td>
									  <td ><?php echo $tot_gratuity[] = $emp_sal[$key]['gratuity'];?></td>
									  <td ><?php echo $tot_epf_er[] = $emp_sal[$key]['epf_er'];?></td>

									  <td ><?php echo $tot_ptax[] = $emp_sal[$key]['ptax'];?></td>									  
									  <td ><?php echo $tot_tds[] = $emp_sal[$key]['TDS']; ?></td>
									  <td ><?php echo $tot_busf[] = $emp_sal[$key]['bus_fare']; ?></td>
									  <td ><?php echo $tot_mobb[] = $emp_sal[$key]['mobile_bill'];?></td>
									  <td ><?php echo $tot_cos[] = $emp_sal[$key]['co_op_society'];?></td>
									  <td ><?php echo $tot_offa[] = $emp_sal[$key]['Off_Adv'];?></td>									  
									  <td ><?php echo $tot_othad[] = $emp_sal[$key]['other_advance'];?></td>
									  <td style='font-weight: bold;'><?php echo $tot_othde[] = $emp_sal[$key]['total_deduct'];?></td>
									  <td style='font-weight: bold;'><?php echo $tot_finntsal[] = $emp_sal[$key]['final_net_sal']; ?></td>
										</tr>	
								  
		
	<?php } else{
		
		
		
		
		
	?>
 <tr>
	    <td><?php echo $k;?><!---<?=$staff_type?>--></td>	
		 <td><?php echo $val['emp_id']; ?></td>
		  <td style="white-space: nowrap;">
		  <?php if($val['gender']=='male'){
                                       echo 'Mr.';
									   }else if($val[$i]['gender']=='female'){ 
									   echo 'Mrs.';}
									  echo $val['fname']." ".$val['mname']." ".$val['lname'];
									  echo "<br/>";
									  $deg = $this->Staff_payment_model->getDesignationById($emp_sal[$key]['designation']);
									  echo $deg[0]['designation_name'];
									  echo "<br/>";
									 // echo "<br/>";
									  //$html .= "<p>";
									  if(!empty($emp_sal[$key]['pay_band_min'])&&!empty($emp_sal[$key]['pay_band_max'])&&!empty($emp_sal[$key]['pay_band_gt'])){
										 echo $emp_sal[$key]['pay_band_min']."-".$emp_sal[$key]['pay_band_max']."+AGP ".$emp_sal[$key]['pay_band_gt'];
									  }else {
										  echo $emp_sal[$key]['basic_salary']; 
									  } //$html .= "</p>";
									  ?>
									  </td>
                                     <td ><?php echo $emp_sal[$key]['basic_salary']; ?></td>
									 <td ><?php
									 if($emp_sal[$key]['gender']=='male'){ 
									 echo 'M';
									 }else{ 
									 echo 'F'; } ?>
									 </td>
									 <td ><?php echo $month; ?></td>
									 <td ><?php echo $emp_sal[$key]['pdays']; ?></td>
                                     <td ><?php echo $tot_bs[] = $emp_sal[$key]['basic_sal'];?></td>
									
									 <td style="width:20px;" width="20"><?php echo $tot_dp[] = $emp_sal[$key]['dp']; ?></td>									 
                                      <td ><?php echo $tot_da[] = $emp_sal[$key]['da']; ?></td>
									  <td ><?php echo $tot_hra[] = $emp_sal[$key]['hra']; ?></td>
									  <td ><?php echo $tot_ta[] = $emp_sal[$key]['ta'];?></td>
									  <td ><?php echo $tot_increment[] = $emp_sal[$key]['increment'];?></td>
									  <td ><?php echo $tot_diff[] = $emp_sal[$key]['difference']; ?></td>
									  <td ><?php echo $tot_otha[] = $emp_sal[$key]['other_allowance']; ?></td>
									 <td ><?php echo $tot_spea[] = $emp_sal[$key]['special_allowance']; ?></td>
									  <td style='font-weight: bold;'><?php echo $tot_gross[] = $emp_sal[$key]['gross'];?></td>
									  <td ><?php echo $tot_gratuity[] = $emp_sal[$key]['gratuity'];?></td>
									  <td ><?php echo $tot_epf_er[] = $emp_sal[$key]['epf_er'];?></td>
									  <td ><?php echo $tot_ctc[] = $emp_sal[$key]['ctc'];?></td>
									  <td ><?php echo $tot_edf[] = $emp_sal[$key]['epf'];?></td>
									  <td ><?php echo $tot_gratuity[] = $emp_sal[$key]['gratuity'];?></td>
									  <td ><?php echo $tot_epf_er[] = $emp_sal[$key]['epf_er'];?></td>

									  <td ><?php echo $tot_ptax[] = $emp_sal[$key]['ptax'];?></td>									  
									  <td ><?php echo $tot_tds[] = $emp_sal[$key]['TDS']; ?></td>
									  <td ><?php echo $tot_busf[] = $emp_sal[$key]['bus_fare']; ?></td>
									  <td ><?php echo $tot_mobb[] = $emp_sal[$key]['mobile_bill'];?></td>
									  <td ><?php echo $tot_cos[] = $emp_sal[$key]['co_op_society'];?></td>
									  <td ><?php echo $tot_offa[] = $emp_sal[$key]['Off_Adv'];?></td>									  
									  <td ><?php echo $tot_othad[] = $emp_sal[$key]['other_advance'];?></td>
									  <td style='font-weight: bold;'><?php echo $tot_othde[] = $emp_sal[$key]['total_deduct'];?></td>
									  <td style='font-weight: bold;'><?php echo $tot_finntsal[] = $emp_sal[$key]['final_net_sal']; ?></td>
										</tr>	 
										
										
<?php }?>
	 <?php
	 $atgross[] =$tgross[] = $emp_sal[$key]['gross'];
	 $atepf[] =	   $tepf[] = $emp_sal[$key]['epf'];
		   $atptax[] =$tptax[]=$emp_sal[$key]['ptax'];
		   $attds[] =$ttds[]=$emp_sal[$key]['TDS'];
		   $atbus[] =$tbus[]=$emp_sal[$key]['bus_fare'];
		   $atmobile[] =$tmobile[]=$emp_sal[$key]['mobile_bill'];
		   $atsoc[] =$tsoc[]=$emp_sal[$key]['co_op_society'];
		   $atoffadv[] =$toffadv[]=$emp_sal[$key]['Off_Adv'];
		   $atothadv[] =$tothadv[]=$emp_sal[$key]['other_advance'];
		   $atdet[] =$tdet[]=$emp_sal[$key]['total_deduct'];
		   $atnet[] =$tnet[]=$emp_sal[$key]['final_net_sal'];
				$k++;				 
	 	  $i++;
	  $j++;
	  $staff_type1 =$staff_type;
	  
	  if($ms==$i-1){ ?>
		    <tr>
<td colspan="7" style="font-weight: bold;padding:20px;text-align:right;" >Total</td>

<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_bs); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_dp); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_da); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_hra); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_ta); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_increment); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_diff); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_otha); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_spea); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_gross); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_gratuity); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_epf_er); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_ctc); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_edf); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_gratuity); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_epf_er); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_ptax); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_tds); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_busf); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_mobb); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_cos); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_offa); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_othad); ?></td>
<td style="font-weight: bold;padding:10px;"><?php echo array_sum($tot_othde); ?></td><td style="font-weight: bold;"><?php echo array_sum($tot_finntsal); ?></td>
 </tr>

				  <tr>
								  <td colspan="2" style="font-weight: bold;padding:10px;" rowspan="2">Total</td>
								  <td colspan="1" style="font-weight: bold;padding:10px;">Total Earning</td>
								   <td colspan="4" style="font-weight: bold;padding:10px;">EPF</td>
								    <td colspan="3" style="font-weight: bold;padding:10px;">PTAX</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">TDS</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">BUS Fare</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">MOBILE</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">CO-OP.Soc</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">Office Adv</td>
									 <td colspan="2" style="font-weight: bold;padding:10px;">Other</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">Total Deductions</td>
									 <td colspan="2" style="font-weight: bold;padding:10px;">Total Net Salary</td>
									 
								  </tr>
								  <tr>								 
								  <td style="font-weight: bold;padding:10px;"><?php echo array_sum($tgross); ?></td>
								 <td colspan="4" style="font-weight: bold;padding:10px;"><?php echo array_sum($tepf); ?></td>
								    <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($tptax);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($ttds);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($tbus);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($tmobile);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($tsoc);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($toffadv);?></td>
									 <td colspan="2" style="font-weight: bold;padding:10px;"><?php echo array_sum($tothadv);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($tdet);?></td>
									 <td colspan="2" style="font-weight: bold;padding:10px;"><?php echo array_sum($tnet);?></td>									
								  </tr>
	 <?php }
	  
	  
	  
}//} ?>
 <tr colspan="31"><td style="border: 1px solid #ededed">&nbsp;</td></tr>
<tr>
								  <td colspan="2" style="font-weight: bold;padding:10px;" rowspan="2">Grand Total</td>
								  <td colspan="1" style="font-weight: bold;padding:10px;">Total Earning</td>
								   <td colspan="4" style="font-weight: bold;padding:10px;">EPF</td>
								    <td colspan="3" style="font-weight: bold;padding:10px;">PTAX</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">TDS</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">BUS Fare</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">MOBILE</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">CO-OP.Soc</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">Office Adv</td>
									 <td colspan="2" style="font-weight: bold;padding:10px;">Other</td>
									 <td colspan="3" style="font-weight: bold;padding:10px;">Total Deductions</td>
									 <td colspan="2" style="font-weight: bold;padding:10px;">Total Net Salary</td>
									 
								  </tr>
 <tr>								 
								  <td style="font-weight: bold;padding:10px;"><?php echo array_sum($atgross); ?></td>
								 <td colspan="4" style="font-weight: bold;padding:10px;"><?php echo array_sum($atepf); ?></td>
								    <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($atptax);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($attds);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($atbus);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($atmobile);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($atsoc);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($atoffadv);?></td>
									 <td colspan="2" style="font-weight: bold;padding:10px;"><?php echo array_sum($atothadv);?></td>
									 <td colspan="3" style="font-weight: bold;padding:10px;"><?php echo array_sum($atdet);?></td>
									 <td colspan="2" style="font-weight: bold;padding:10px;"><?php echo array_sum($atnet);?></td>									
								  </tr>
	</tbody>
							  
	  </table>	
</body>
</html>
