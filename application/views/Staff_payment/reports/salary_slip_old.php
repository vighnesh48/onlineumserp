<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>table tr, td{padding:3px 5px;}</style>
</head>
<body>
<?php 
$ci =&get_instance();
   $ci->load->model('admin_model');
   date_default_timezone_set('Asia/Kolkata');
   //print_r($emp_sal);exit;
foreach($emp_sal as $val){

	$department =  $ci->admin_model->getDepartmentById($val['department']); 
   $designation =  $ci->admin_model->getDesignationById($val['designation']); 
   $emp_school =  $ci->admin_model->getSchoolById($val['emp_school']); 
	?>
 <div style="width:90%;border:1px solid black;margin-bottom:5px;font-size:12px;align:center;margin-left:auto;margin-right:auto;" >
			   <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:0px solid #000;margin-top:10px;">
  <tr>
    
    <td align="center" style="border-bottom:1px dotted #000;padding-bottom:0px;padding-bottom:0px" colspan="3"><img src="<?php echo site_url(); ?>assets/su_logo.jpg" width="170" />
    <p style="padding:0px;margin:0px;font-size:8px;">Trimbak Road, A/p - Mahiravani, Nashik – 422 213</p>
    <p style="padding:0px;margin:0px;font-size:10px;">Website : http://www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in<br/><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></p>
    </td>
   </tr>
   <tr>
</table>

    <table width="90%" border="" cellspacing="0" cellpadding="0" align="center" style="margin:10px 10px">
  <tr style="margin-top:3px;">
    <td align="center"><p style="font-size:15px;padding:10px 0px!important;line-height:0px;"><strong>PAY-SLIP FOR THE MONTH OF	<?php echo strtoupper(date('M-Y',strtotime($dt)));?></strong></p><br/>
	</td>
     </tr>
	 </table>
	 
	 
	  <table width="100%" border="" cellspacing="0" cellpadding="0" style="margin:10px 40px">
	 <tr>
	 <td>
		 <table width="100%" border="" cellspacing="0" cellpadding="0">
		<tr>
		<td style="font-size:10px;" width="5%"><strong >STAFF ID	</strong></td>
		<td style="font-size:10px;" width="1%"><strong >:	</strong></td>
		<td style="font-size:10px;" width="94%"><?php echo $val['emp_id'];?></td>
	  </tr>
	  <tr>
	  <tr>
		<td style="font-size:10px;" width="5%"><strong >PRESENT DAYS	</strong></td>
		<td style="font-size:10px;" width="1%"><strong >:	</strong></td>
		<td style="font-size:10px;" width="94%"><?php echo $val['pdays'];?></td>
	  </tr>
	  <tr>
		<<td style="font-size:10px;" width="5%"><strong>DESIGNATION 	</strong></td>
		<td style="font-size:10px;" width="1%"><strong >:	</strong></td>
		<td style="font-size:10px;" width="94%"><?php echo $designation[0]['designation_name'];?></td>
	  </tr>
	  <tr>
		<td style="font-size:10px;" width="5%"><strong>BANK A/C NO 	</strong></td>
		<td style="font-size:10px;" width="1%"><strong >:	</strong></td>
		<td style="font-size:10px;" width="94%"><?php echo $val['bank_acc_no'];?></td>
	  </tr>
	  <tr>
		<td style="font-size:10px;" width="5%"><strong>UAN NO	   </strong></td>
		<td style="font-size:10px;" width="1%"><strong >:	</strong></td>
		<td style="font-size:10px;" width="94%"> <?php echo $val['pf_no'];?></td>
	  </tr>
	</table>   
		 </td>
 	 <td>
	  <table width="100%" border="" cellspacing="0" cellpadding="0" >
  <tr>
   <td style="font-size:10px;" width="5%"><strong>STAFF NAME </strong></td>
	<td style="font-size:10px;" width="1%"><strong >:	</strong></td>
    <td style="font-size:10px;" width="94%">
	<?php if($val['gender']=='male'){
                                      echo 'Mr.';
									   }else if($val[$i]['gender']=='female'){ 
									   echo 'Mrs.';}
		echo $val['fname'].' '.$val['mname'].' '.$val['lname']; ?></td>
  </tr>
  <tr>
    <td style="font-size:10px;" width="5%"><strong>SCHOOL</strong></td>
	<td style="font-size:10px;" width="1%"><strong >:	</strong></td>
    <td style="font-size:10px;" width="94%"><?php echo $emp_school[0]['college_code'];?></td>
  </tr>
  <tr>
    <td style="font-size:10px;" width="5%"><strong>DEPARTMENT	</strong></td>
	<td style="font-size:10px;" width="1%"><strong >:	</strong></td>
    <td style="font-size:10px;" width="94%"><?php echo $department[0]['department_name'];?></td>
  </tr>
  <tr>
    <td style="font-size:10px;" width="5%"><strong>PAY SCALE    </strong></td>
	<td style="font-size:10px;" width="1%"><strong >:	</strong></td>
    <td style="font-size:10px;" width="94%"><?php 
$CIS =& get_instance();
	  $CIS->load->model('Staff_payment_model'); 
	  $val1 = $CIS->Staff_payment_model->fetchEmpBasicSalByempid($val['emp_id'],'Y');
	  if($val1[0]['pay_band_min'] != 0 || !empty($val1[0]['pay_band_min'])){
    echo $val1[0]['pay_band_min']."-".$val1[0]['pay_band_max']."+AGP ".$val1[0]['pay_band_gt'];
    }else{ echo '-'; } ?></td>
  </tr>
  <tr>
    <td style="font-size:10px;" width="5%"><strong>BASIC	 </strong></td>
	<td style="font-size:10px;" width="1%"><strong >:	</strong></td>
    <td style="font-size:10px;" width="94%"><?php echo $val['basic_sal'];?></td>
  </tr>
	 </td>
	 </tr>
</table>

  
  
  
</table>
    
    <table width="100%" border="1"  cellspacing="0" cellpadding="3" align="center" style="margin:10px 40px">
    <tr>
    <th colspan="2" width="250" style="font-size:12px;">Earning</th>
    <th colspan="2" width="250" style="font-size:12px;">Deduction</th>
    </tr>
  <tr>
    <td  style="font-size:11px;"><strong>Basic</strong></td>
    <td  style="font-size:11px;text-align:right;"><?php echo $val['basic_sal'];?></td>
    <td  style="font-size:11px;"><strong>EPF</strong></td>
    <td  style="font-size:11px;text-align:right;"><?php echo $val['epf'];?></td>
  </tr>
  <tr>
    <td><strong style="font-size:11px;">DP</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['dp'];?></td>
    <td><strong style="font-size:11px;">P.TAX</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['ptax']; ?></td>
  </tr>
  <tr>
   <td><strong style="font-size:11px;">DA</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['da'];?></td>
    <td><strong style="font-size:11px;">TDS</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['TDS'];?></td>
  </tr>
  <tr>
   <td><strong style="font-size:11px;">HRA</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['hra']; ?></td>
    <td><strong style="font-size:11px;">BUS FARE</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['bus_fare'];?></td>
  </tr>
  <tr>
   <td><strong style="font-size:11px;">TA</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['ta'];?></td>
    <td><strong style="font-size:11px;">MOBILE BILL</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['mobile_bill'];?></td>
  </tr>
  <tr>
    <td><strong style="font-size:11px;">OTHER</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['other_allowance'];?></td>
    <td><strong style="font-size:11px;">OTHER</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['other_advance'];?></td>
  </tr>
  <tr>
  <td><strong style="font-size:11px;">DIFF.</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['difference'];?></td>
    <td><strong style="font-size:11px;">ADVANCES</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['Off_Adv'];?></td>
  </tr>
  <tr>
  <td><strong style="font-size:11px;">SPECIAL ALLOWANCES</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['special_allowance'];?></td>
    <td><strong style="font-size:11px;">CO-OP.SOC</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['co_op_society'];?></td>
  </tr>
  <tr>
   <td><strong style="font-size:11px;">GROSS EARNING</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['gross'];?></td>
    <td><strong style="font-size:11px;">GROSS DEDUCTION</strong></td>
    <td style="font-size:11px;text-align:right;"><?php echo $val['total_deduct'];?></td>
  </tr>
 
</table>    
   
 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:0px solid #000;">
 <tr>
<td align="center" style="padding:10px 0;font-size:10px;">
<p>NET PAY:- <strong>Rs. <?php $formattedAmount = number_format($val['final_net_sal'], 2, '.', ','); echo $formattedAmount;?></strong> &nbsp;&nbsp;&nbsp;In Word:- <strong>Rs.: 
<?php $this->load->library('Numbertowords');
$number= $val['final_net_sal'];
$test = NEW Numbertowords();
//$obj = New Consts();
//$curr_sess = $obj->fetchCurrSession();
echo $test->convertToIndianCurrency($number); ?> </strong></p>
</td>  
  </tr>
 
</table>

<div style="border-top:#000 dotted 1px;font-size:10px;padding:5px;">
<div style="text-align:left;width:55%;float:left;">This is Computerised Pay-slip, So Signature is not required. </div> 
 <div style="text-align:right;width:45%;float:right;">printed on: <?php echo date('Y-m-d h:i:s')?> </div><div><?php } ?>
 

</body>
</html>
