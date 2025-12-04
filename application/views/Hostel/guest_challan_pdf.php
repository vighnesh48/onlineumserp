
<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
ini_set('max_execution_time', 300000);
require('code128.class.php');
//include_once "phpqrcode/qrlib.php";
$font = 'Verdana.ttf';

$form_no = $std_challan_details['exam_session'];
/* $barcode = new phpCode128($form_no);
$barcode->saveBarcode('uploads/facility_challan/'.$form_no.'.jpg'); */
$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
$barcode = 'data:image/png;base64,' .base64_encode($generator->getBarcode($form_no, $generator::TYPE_CODE_128));

function numberTowords($num)
{ 
$ones = array( 
1 => "one", 
2 => "two", 
3 => "three", 
4 => "four", 
5 => "five", 
6 => "six", 
7 => "seven", 
8 => "eight", 
9 => "nine", 
10 => "ten", 
11 => "eleven", 
12 => "twelve", 
13 => "thirteen", 
14 => "fourteen", 
15 => "fifteen", 
16 => "sixteen", 
17 => "seventeen", 
18 => "eighteen", 
19 => "nineteen" 
); 
$tens = array( 
1 => "ten",
2 => "twenty", 
3 => "thirty", 
4 => "forty", 
5 => "fifty", 
6 => "sixty", 
7 => "seventy", 
8 => "eighty", 
9 => "ninety" 
); 
$hundreds = array( 
"hundred", 
"thousand", 
"million", 
"billion", 
"trillion", 
"quadrillion" 
); //limit t quadrillion 
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){ 
if($i < 20){ 
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
$rettxt .= $tens[substr($i,0,1)]; 
$rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
$rettxt .= " ".$tens[substr($i,1,1)]; 
$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
} 
} 
if($decnum > 0){ 
$rettxt .= " and "; 
if($decnum < 20){ 
$rettxt .= $ones[$decnum]; 
}elseif($decnum < 100){ 
$rettxt .= $tens[substr($decnum,0,1)]; 
$rettxt .= " ".$ones[substr($decnum,1,1)]; 
} 
} 
return $rettxt; 
}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style>
table {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.table tr td {
	padding: 3px;
}
table {
    border-collapse: collapse;
}
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>

    <td width="33%" valign="top">
        <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="2"><strong><?=$std_challan_details['bank_name']?>-<?=$std_challan_details['branch_name']?></strong></td>
          <td><strong>Guest Copy</strong></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c No. : </strong><?php  if($std_challan_details['account_no']=="00641450000165"){ echo 'SNDFNDHOST';}else{echo $std_challan_details['account_no'];}?></td>
          <td><strong>Date:</strong>  <?=date("d/m/Y")?></td>
        </tr>
        <tr>
          <td colspan="3"><strong>Bank A/c Name :</strong><?=$std_challan_details['account_name']?></td>
		  
        </tr>
		</table>
		 <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan=2><strong>Academic Year : </strong> <?php $ayear=explode('-',$std_challan_details['academic_year']); 
			$ay=substr($ayear[0], -2)+1; echo $std_challan_details['academic_year'].'-'.$ay;?>
			</td>

        </tr>
        <tr>
          
          <td width="50%"><strong>Challan No. :</strong><?=$form_no?></td>
		  <td>&nbsp;&nbsp;&nbsp;<img style="padding-top:5px;padding-left:40px;padding-bottom:5px;" src="<?=$barcode?>" alt="Sandip University" width="100" height="50"/></td>
        </tr>

        <tr>
          <td colspan="2"><strong>Name:</strong><?=$std_challan_details['guest_name']?></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Institute :</strong>
		  <?php
		  if($std_challan_details['organisation'] !=''){
			echo $std_challan_details['organisation'];
		  }?>
		  </td>
        </tr>
        <tr>
          <td colspan="2"><strong>Contact No.:</strong> <?=$std_challan_details['mobile']?></td>
          
        </tr>
        
      </table>
      <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <th> Sr. No.</th>
          <th>Particulars</th>
          <th>Amount (Rs.)</th>
        </tr>
        <tr>
          <td align="center">1</td>
           <td>Accomodation charges</td>
          <td><?=$std_challan_details['accomodation_charges']?></td>
        </tr>
		<tr>
          <td align="center">2</td>
          <td>Cricket ground charges</td>
          <td><?=$std_challan_details['cricket_ground_charges']?></td>
        </tr>
		<tr>
          <td align="center">3</td>
          <td>Fine fee</td>
          <td><?=$std_challan_details['fine_fees']?></td>
        </tr>
        <tr>
          <td align="center">4</td>
          <td>Other fee</td>
          <td><?=$std_challan_details['other_fees']?></td>
        </tr>
        <tr>
          <td colspan="2" align="right"><strong>Total Rs/-</strong></td>
          <td><strong><?=($std_challan_details['amount'])?></strong></td>
        </tr>
        <tr>
          <td colspan="3"><strong>Amount In Words :</strong>Rupees <strong><?php echo numberTowords(($std_challan_details['amount']));?></strong>  Only</td>
        </tr>
		<tr>
		<td colspan="3"><strong>Mode of Payment:</strong> <?=$std_challan_details['fees_paid_type']?></td>
		</tr>
      </table>
	   <?php if($std_challan_details['fees_paid_type']=='CASH')
	  {
		  ?>
      <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
	  
        <tr>
          <th>Denomination</th>
          <th>No.of Pieces</th>
          <th>Amount</th>
        </tr>
        <tr>
          <td align="center">2000*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">500*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">200*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td align="center">100*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">50*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><strong>Total Amount</strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="16" colspan="3"><strong>Pan Card No :</strong></td>
        </tr>
      </table>
	  <?php
	  }
	  else{
	  ?>
	  
	  <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td><strong><?=$std_challan_details['fees_paid_type']?> No. :</strong> <?=$std_challan_details['receipt_no']?>  </td>
          <td><strong>Date :</strong> <?=date("d/m/Y", strtotime($std_challan_details['fees_date']))?> </td>
        </tr>
        <tr>
          <td><strong>Bank Name :</strong> <?=$std_challan_details['bank_name']?> </td>
          <td><strong>Branch :</strong> <?=$std_challan_details['bank_city']?></td>
        </tr>
      </table>
	  <!--table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="3" align="right" style="padding-top:132px;"><strong>Signature Of Student / Remitter</strong></td>
        </tr>
      </table-->
	  <?php
	  }
	  ?>
	  
      <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="2"><strong>For Bank Use Only</strong></td>
        </tr>
        <tr>
          <td width="50%"><strong>Rs :</strong><?=$std_challan_details['amount']?> </td>
          <td><strong>Date :</strong> <?=date("d/m/Y")?></td>
        </tr>
       
        <tr>
          <td><strong>Seal & Date :</strong></td>
          <td><strong>Authorized Signatory :</strong></td>
        </tr>
      </table>
	</td>
	
	
    <td width="33%" valign="top">
        <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="2"><strong><?=$std_challan_details['bank_name']?>-<?=$std_challan_details['branch_name']?></strong></td>
          <td><strong>Institute Copy</strong></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c No. : </strong><?php  if($std_challan_details['account_no']=="00641450000165"){ echo 'SNDFNDHOST';}else{echo $std_challan_details['account_no'];}?></td>
          <td><strong>Date:</strong>  <?=date("d/m/Y")?></td>
        </tr>
        <tr>
          <td colspan="3"><strong>Bank A/c Name :</strong><?=$std_challan_details['account_name']?></td>
		  
        </tr>
		</table>
		 <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan=2><strong>Academic Year : </strong> <?php $ayear=explode('-',$std_challan_details['academic_year']); 
			$ay=substr($ayear[0], -2)+1; echo $std_challan_details['academic_year'].'-'.$ay;?>
			</td>
          
        </tr>
        <tr>
          
          <td width="50%"><strong>Challan No. :</strong><?=$form_no?></td>
		  <td>&nbsp;&nbsp;&nbsp;<img style="padding-top:5px;padding-left:40px;padding-bottom:5px;" src="<?=$barcode?>" alt="Sandip University" width="100" height="50"/></td>
        </tr>        
        <tr>
          <td colspan="2"><strong>Name:</strong><?=$std_challan_details['guest_name']?></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Institute :</strong>
		  <?php
		  if($std_challan_details['organisation'] !=''){
			echo $std_challan_details['organisation'];
		  }?>
		  </td>
		  </tr>
        <tr>
          <td colspan="2"><strong>Contact No.:</strong> <?=$std_challan_details['mobile']?></td>
          
        </tr>
        
      </table>
      <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <th> Sr. No.</th>
          <th>Particulars</th>
          <th>Amount (Rs.)</th>
        </tr>
        <tr>
          <td align="center">1</td>
           <td>Accomodation charges</td>
          <td><?=$std_challan_details['accomodation_charges']?></td>
        </tr>
		<tr>
          <td align="center">2</td>
          <td>Cricket ground charges</td>
          <td><?=$std_challan_details['cricket_ground_charges']?></td>
        </tr>
		<tr>
          <td align="center">3</td>
          <td>Fine fee</td>
          <td><?=$std_challan_details['fine_fees']?></td>
        </tr>
        <tr>
          <td align="center">4</td>
          <td>Other fee</td>
          <td><?=$std_challan_details['other_fees']?></td>
        </tr>
        <tr>
          <td colspan="2" align="right"><strong>Total Rs/-</strong></td>
          <td><strong><?=($std_challan_details['amount'])?></strong></td>
        </tr>

        <tr>
          <td colspan="3"><strong>Amount In Words :</strong>Rupees <strong><?php echo numberTowords(($std_challan_details['amount']));?></strong>  Only</td>
        </tr>
		<tr>
		<td colspan="3"><strong>Mode of Payment:</strong> <?=$std_challan_details['fees_paid_type']?></td>
		</tr>
      </table>
	   <?php if($std_challan_details['fees_paid_type']=='CASH')
	  {
		  ?>
      <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
	  
        <tr>
          <th>Denomination</th>
          <th>No.of Pieces</th>
          <th>Amount</th>
        </tr>
        <tr>
          <td align="center">2000*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">500*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">200*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td align="center">100*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">50*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><strong>Total Amount</strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="16" colspan="3"><strong>Pan Card No :</strong></td>
        </tr>
      </table>
	  <?php
	  }
	  else{
	  ?>
	  
	  <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td><strong><?=$std_challan_details['fees_paid_type']?> No. :</strong> <?=$std_challan_details['receipt_no']?>  </td>
         <td><strong>Date :</strong> <?=date("d/m/Y", strtotime($std_challan_details['fees_date']))?> </td>
        </tr>
        <tr>
          <td><strong>Bank Name :</strong> <?=$std_challan_details['bank_name']?> </td>
          <td><strong>Branch :</strong> <?=$std_challan_details['bank_city']?></td>
        </tr>
      </table>
	  
	  <?php
	  }
	  ?>
	  <!--table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="3" align="right" style="padding-top:132px;"><strong>Signature Of Student / Remitter</strong></td>
        </tr>
      </table-->
      <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="2"><strong>For Bank Use Only</strong></td>
        </tr>
        <tr>
          <td width="50%"><strong>Rs :</strong><?=$std_challan_details['amount']?> </td>
          <td><strong>Date :</strong> <?=date("d/m/Y")?></td>
        </tr>
       
        <tr>
          <td><strong>Seal & Date :</strong></td>
          <td><strong>Authorized Signatory :</strong></td>
        </tr>
      </table>
	  
	</td>
	 
    <td width="33%">
	 <?php if($std_challan_details['fees_paid_type']!='POS')
	  {
		  ?>
       <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="2"><strong><?=$std_challan_details['bank_name']?>-<?=$std_challan_details['branch_name']?></strong></td>
          <td><strong>Bank Copy</strong></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c No. : </strong><?php  if($std_challan_details['account_no']=="00641450000165"){ echo 'SNDFNDHOST';}else{echo $std_challan_details['account_no'];}?></td>
          <td><strong>Date:</strong>  <?=date("d/m/Y")?></td>
        </tr>
        <tr>
          <td colspan="3"><strong>Bank A/c Name :</strong><?=$std_challan_details['account_name']?></td>
		  
        </tr>
		</table>
		 <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan=2><strong>Academic Year : </strong> <?php $ayear=explode('-',$std_challan_details['academic_year']); 
			$ay=substr($ayear[0], -2)+1; echo $std_challan_details['academic_year'].'-'.$ay;?>
			</td>
          
        </tr>
        <tr>
          
          <td width="50%"><strong>Challan No. :</strong><?=$form_no?></td>
		  <td>&nbsp;&nbsp;&nbsp;<img style="padding-top:5px;padding-left:40px;padding-bottom:5px;" src="<?=$barcode?>" alt="Sandip University" width="100" height="50"/></td>
        </tr>
        
       <tr>
          <td colspan="2"><strong>Name:</strong><?=$std_challan_details['guest_name']?></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Institute :</strong>
		  <?php
		  if($std_challan_details['organisation'] !=''){
			echo $std_challan_details['organisation'];
		  }?>
		  </td>
		  </tr>
        <tr>
          <td colspan="2"><strong>Contact No.:</strong> <?=$std_challan_details['mobile']?></td>
          
        </tr>
        
      </table>
      <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <th> Sr. No.</th>
          <th>Particulars</th>
          <th>Amount (Rs.)</th>
        </tr>
        <tr>
          <td align="center">1</td>
           <td>Accomodation charges</td>
          <td><?=$std_challan_details['accomodation_charges']?></td>
        </tr>
		<tr>
          <td align="center">2</td>
          <td>Cricket ground charges</td>
          <td><?=$std_challan_details['cricket_ground_charges']?></td>
        </tr>
		<tr>
          <td align="center">3</td>
          <td>Fine fee</td>
          <td><?=$std_challan_details['fine_fees']?></td>
        </tr>
        <tr>
          <td align="center">4</td>
          <td>Other fee</td>
          <td><?=$std_challan_details['other_fees']?></td>
        </tr>
        <tr>
          <td colspan="2" align="right"><strong>Total Rs/-</strong></td>
          <td><strong><?=($std_challan_details['amount'])?></strong></td>
        </tr>

        <tr>
          <td colspan="3"><strong>Amount In Words :</strong>Rupees <strong><?php echo numberTowords(($std_challan_details['amount']));?></strong>  Only</td>
        </tr>
		<tr>
		<td colspan="3"><strong>Mode of Payment:</strong> <?=$std_challan_details['fees_paid_type']?></td>
		</tr>
      </table>
	   <?php if($std_challan_details['fees_paid_type']=='CASH')
	  {
		  ?>
      <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
	  
        <tr>
          <th>Denomination</th>
          <th>No.of Pieces</th>
          <th>Amount</th>
        </tr>
        <tr>
          <td align="center">2000*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">500*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">200*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td align="center">100*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">50*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><strong>Total Amount</strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="16" colspan="3"><strong>Pan Card No :</strong></td>
        </tr>
      </table>
	  <?php
	  }
	  else{
	  ?>
	  
	  <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td><strong><?=$std_challan_details['fees_paid_type']?> No. :</strong> <?=$std_challan_details['receipt_no']?>  </td>
          <td><strong>Date :</strong> <?=date("d/m/Y", strtotime($std_challan_details['fees_date']))?> </td>
        </tr>
        <tr>
          <td><strong>Bank Name :</strong> <?=$std_challan_details['bank_name']?> </td>
          <td><strong>Branch :</strong> <?=$std_challan_details['bank_city']?></td>
        </tr>
      </table>
	  
	  <?php
	  }
	  ?>
	  <!--table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="3" align="right" style="padding-top:132px;"><strong>Signature Of Student / Remitter</strong></td>
        </tr>
      </table-->
      <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="2"><strong>For Bank Use Only</strong></td>
        </tr>
        <tr>
          <td width="50%"><strong>Rs :</strong><?=$std_challan_details['amount']?> </td>
          <td><strong>Date :</strong> <?=date("d/m/Y")?></td>
        </tr>
      
        <tr>
          <td><strong>Seal & Date :</strong></td>
          <td><strong>Authorized Signatory :</strong></td>
        </tr>
      </table> 
	  <?php } ?>
	</td>
	  
  </tr>
</table>
</body>
</html>
