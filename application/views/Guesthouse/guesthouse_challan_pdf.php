<?php
//print_r($std_challan_details[0]);
//exit;
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
ini_set('max_execution_time', 300000);
require('code128.class.php');
//include_once "phpqrcode/qrlib.php";
$font = 'Verdana.ttf';

$form_no = $std_challan_details[0]['exam_session'];
/* $barcode = new phpCode128($form_no);
$barcode->saveBarcode('uploads/facility_challan/'.$form_no.'.jpg'); */
$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
$barcode = 'data:image/png;base64,' .base64_encode($generator->getBarcode($form_no, $generator::TYPE_CODE_128));
function numberTowords(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees .' ' : ''). $paise;
}
function numberTowords_t($num)
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
<table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
<td width="33%">
	 <?php //if($std_challan_details[0]['fees_paid_type']!='POS')
	  //{
		  ?>
       <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="2"><strong><?=$std_challan_details[0]['bank_code']?>-<?=$std_challan_details[0]['branch_name']?></strong></td>
          <td><strong>Bank Copy</strong></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c No. : </strong><?=$std_challan_details[0]['account_no']?></td>
          <td><strong>Date:</strong>  <?=date("d/m/Y")?></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c Name :</strong><?=$std_challan_details[0]['account_name']?></td>
		 
           <td colspan="">
		   <?php if($std_challan_details[0]['account_no']=='50100207594285'){?>
		  <strong>Client Id :</strong><?=$std_challan_details[0]['clinet_id']?>
		  <?php } ?></td>
        </tr>
		</table>
		 <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td><strong>Booking ID : </strong> <?php 
		  echo $std_challan_details[0]['Booking_id'];?>
			</td>
          <td><strong>Booking Date :</strong> <?php 
		  echo $std_challan_details[0]['In_Date'];?></td>
        </tr>
        <tr>
          
          <td width="40%"><strong>Challan No:</strong><br><span style="font-size:13px"><?=$std_challan_details[0]['challan_No']?></span></td>
		  <td width="60%"><img style="padding-top:5px;" src="<?=base_url()?>uploads/facility_challan/190005.jpg" alt="Sandip University" /></td>
        </tr>
       <tr>
		<td colspan="2">
         
         <strong>Hostel ID :</strong> <?=$std_challan_details[0]['Guest_House']?></td>
		</tr>
        <tr>
          <td colspan="2"><strong>Name :</strong>
          <?=$std_challan_details[0]['Name']?>
          </td>
        </tr>
        <tr>
          <td>
		  <strong>No Of Person :</strong><?=$std_challan_details[0]['No_Person']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
          <td>
          <strong>No Of Day :</strong><?=$std_challan_details[0]['No_Days']?>
		  
          </td>
        </tr>
        <tr>
          <td >
		  <strong>Check In :</strong><?=$std_challan_details[0]['In_Date']?>&nbsp;&nbsp;&nbsp;&nbsp;
		  </td>
          <td>
          <strong>Check Out :</strong><?=$std_challan_details[0]['Out_Date']?>
		  
          </td>
        </tr>
        <tr>
          <td colspan="2"><strong>Contact No.:</strong>
           
		   <?=$std_challan_details[0]['Mobile']?>
           </td>
          
        </tr>
        
      </table>
      <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
    
      
        <tr>
         <!-- <th> Sr. No.</th>-->
          <th>Particulars</th>
          <th>Amount (Rs.)</th>
        </tr>
        <tr>
          <!--<td align="center"></td>-->
          <td><strong></strong></td>
          <td></td>
        </tr>
         <tr>
         <!-- <td align="center">2</td>-->
          <td>Charge Amount</td>
          <td><?=$std_challan_details[0]['Charges']?></td>
        </tr>
        
        
		
        
        <tr>
          <td align="right"><strong>Total Rs/-</strong></td>
          <td><strong><?=($std_challan_details[0]['Charges'])?></strong></td>
        </tr>
        </table>
        <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
		<tr>
          <td colspan="3"><strong>Remark:</strong><?php echo (($std_challan_details[0]['remark']));?></td>
        </tr>
        <tr>
          <td colspan="3"><strong>Amount In Words :</strong>Rupees <strong><?php echo numberTowords((0));?></strong>  Only</td>
        </tr>
		<tr>
		<td colspan="3"><strong>Mode of Payment:</strong> <?=$std_challan_details[0]['mode_of_payment']?></td>
		</tr>
		<!--	<tr>
		<td colspan="3"><?php if($std_challan_details[0]['mode_of_payment']=='OL'){ ?><strong>Transaction No:</strong> <?=$std_challan_details[0]['TransactionNo']?><?php } ?></td>
		</tr>
		-->
      </table>
	   <?php if($std_challan_details[0]['mode_of_payment']=='CASH')
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
          <td align="center">20*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td align="center">10*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td align="center">5*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">2*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">1*</td>
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
          <td><strong><?=$std_challan_details[0]['mode_of_payment']?> No. :</strong> <?=$std_challan_details[0]['receipt_no']?>  </td>
          <td><strong>Date :</strong> <?=date("d/m/Y", strtotime($std_challan_details[0]['fees_date']))?> </td>
        </tr>
        <tr>
          <td><strong>Bank Name :</strong> <?=$std_challan_details[0]['ubank_name']?> </td>
          <td><strong>Branch :</strong> <?=$std_challan_details[0]['Bank_Branch']?></td>
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
          <td width="50%"><strong>Rs :</strong><?=$std_challan_details[0]['Charges']?> </td>
          <td><strong>Date :</strong> <?=date("d/m/Y")?></td>
        </tr>
        <tr>
          <td colspan="2" height="100" valign="top">IMPORTANT INSTRUCTION TO <?=$std_challan_details[0]['bank_code']?> BRANCH :</td>
        </tr>
        <tr>
          <td><strong>Seal & Date :</strong></td>
          <td><strong>Authorized Signatory :</strong></td>
        </tr>
         <tr>
          <td colspan="2" align="center"><span style="alignment-adjust:central">Note:-Cheque/DD are Subject to realisation</span></td>
         
        </tr>
      </table> 
	  <?php // } ?>
	</td>
    <td width="33%">
	 <?php //if($std_challan_details[0]['fees_paid_type']!='POS')
	  //{
		  ?>
       <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="2"><strong><?=$std_challan_details[0]['bank_code']?>-<?=$std_challan_details[0]['branch_name']?></strong></td>
          <td><strong>Guest Copy</strong></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c No. : </strong><?=$std_challan_details[0]['account_no']?></td>
          <td><strong>Date:</strong>  <?=date("d/m/Y")?></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c Name :</strong><?=$std_challan_details[0]['account_name']?></td>
		 
           <td colspan="">
		   <?php if($std_challan_details[0]['account_no']=='50100207594285'){?>
		  <strong>Client Id :</strong><?=$std_challan_details[0]['clinet_id']?>
		  <?php } ?></td>
        </tr>
		</table>
		 <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td><strong>Booking ID : </strong> <?php 
		  echo $std_challan_details[0]['Booking_id'];?>
			</td>
          <td><strong>Booking Date :</strong> <?php 
		  echo $std_challan_details[0]['In_Date'];?></td>
        </tr>
        <tr>
          
          <td width="40%"><strong>Challan No:</strong><br><span style="font-size:13px"><?=$std_challan_details[0]['challan_No']?></span></td>
		  <td width="60%"><img style="padding-top:5px;" src="<?=base_url()?>uploads/facility_challan/190005.jpg" alt="Sandip University" /></td>
        </tr>
       <tr>
		<td colspan="2">
         
         <strong>Hostel ID :</strong> <?=$std_challan_details[0]['Guest_House']?></td>
		</tr>
        <tr>
          <td colspan="2"><strong>Name :</strong>
          <?=$std_challan_details[0]['Name']?>
          </td>
        </tr>
        <tr>
          <td>
		  <strong>No Of Person :</strong><?=$std_challan_details[0]['No_Person']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
          <td>
          <strong>No Of Day :</strong><?=$std_challan_details[0]['No_Days']?>
		  
          </td>
        </tr>
        <tr>
          <td >
		  <strong>Check In :</strong><?=$std_challan_details[0]['In_Date']?>&nbsp;&nbsp;&nbsp;&nbsp;
		  </td>
          <td>
          <strong>Check Out :</strong><?=$std_challan_details[0]['Out_Date']?>
		  
          </td>
        </tr>
        <tr>
          <td colspan="2"><strong>Contact No.:</strong>
           
		   <?=$std_challan_details[0]['Mobile']?>
           </td>
          
        </tr>
        
      </table>
      <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
    
      
        <tr>
         <!-- <th> Sr. No.</th>-->
          <th>Particulars</th>
          <th>Amount (Rs.)</th>
        </tr>
        <tr>
          <!--<td align="center"></td>-->
          <td><strong></strong></td>
          <td></td>
        </tr>
         <tr>
         <!-- <td align="center">2</td>-->
          <td>Charge Amount</td>
          <td><?=$std_challan_details[0]['Charges']?></td>
        </tr>
        
        
		
        
        <tr>
          <td align="right"><strong>Total Rs/-</strong></td>
          <td><strong><?=($std_challan_details[0]['Charges'])?></strong></td>
        </tr>
        </table>
        <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
		<tr>
          <td colspan="3"><strong>Remark:</strong><?php echo (($std_challan_details[0]['remark']));?></td>
        </tr>
        <tr>
          <!--td colspan="3"><strong>Amount In Words :</strong>Rupees <strong><?php echo numberTowords(($std_challan_details[0]['Charges']));?></strong>  Only</td-->
		  <td colspan="3"><strong>Amount In Words :</strong>Rupees <strong><?php echo numberTowords((0));?></strong>  Only</td>
        </tr>
		<tr>
		<td colspan="3"><strong>Mode of Payment:</strong> <?=$std_challan_details[0]['mode_of_payment']?></td>
		</tr>
		<!--	<tr>
		<td colspan="3"><?php if($std_challan_details[0]['mode_of_payment']=='OL'){ ?><strong>Transaction No:</strong> <?=$std_challan_details[0]['TransactionNo']?><?php } ?></td>
		</tr>
		-->
      </table>
	   <?php if($std_challan_details[0]['mode_of_payment']=='CASH')
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
          <td align="center">20*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td align="center">10*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td align="center">5*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">2*</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center">1*</td>
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
          <td><strong><?=$std_challan_details[0]['mode_of_payment']?> No. :</strong> <?=$std_challan_details[0]['receipt_no']?>  </td>
          <td><strong>Date :</strong> <?=date("d/m/Y", strtotime($std_challan_details[0]['fees_date']))?> </td>
        </tr>
        <tr>
          <td><strong>Bank Name :</strong> <?=$std_challan_details[0]['ubank_name']?> </td>
          <td><strong>Branch :</strong> <?=$std_challan_details[0]['Bank_Branch']?></td>
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
          <td width="50%"><strong>Rs :</strong><?=$std_challan_details[0]['Charges']?> </td>
          <td><strong>Date :</strong> <?=date("d/m/Y")?></td>
        </tr>
        <tr>
          <td colspan="2" height="100" valign="top">IMPORTANT INSTRUCTION TO <?=$std_challan_details[0]['bank_code']?> BRANCH :</td>
        </tr>
        <tr>
          <td><strong>Seal & Date :</strong></td>
          <td><strong>Authorized Signatory :</strong></td>
        </tr>
         <tr>
          <td colspan="2" align="center"><span style="alignment-adjust:central">Note:-Cheque/DD are Subject to realisation</span></td>
         
        </tr>
      </table> 
	  <?php // } ?>
	</td>
	
	
    
	 
    
	  
  </tr>
</table>
</body>
</html>
