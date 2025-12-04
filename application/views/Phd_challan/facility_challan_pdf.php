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
<title>Sandip University Fees Challan Cum Receipt</title>
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
<td width="33%">
	 <?php //if($std_challan_details['fees_paid_type']!='POS')
	  //{
		  ?>
       <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="2"><strong><?=$std_challan_details['bank_code']?>-<?=$std_challan_details['branch_name']?></strong></td>
          <td><strong>Bank Copy</strong></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c No. : </strong><?=$std_challan_details['account_no']?></td>
          <td><strong>Date:</strong>  <?=date("d/m/Y", strtotime($std_challan_details['created_on']))?></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c Name :</strong><?=$std_challan_details['account_name']?></td>
		 
           <td colspan="">
		   <?php if($std_challan_details['account_no']=='50100207594285'){?>
		  <strong>Client Id :</strong><?=$std_challan_details['clinet_id']?>
		  <?php }elseif($std_challan_details['account_no']=='50100291606982'){ ?>
			  <strong>Client Id :</strong><?=$std_challan_details['clinet_id']?>
		 <?php }else{ echo "--";}?></td>
        </tr>
		</table>
		 <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td><strong>Academic Year : </strong> <?php $ayear=explode('-',$std_challan_details['academic_year']); 
			$ay=substr($ayear[0], -2)+1; echo $std_challan_details['academic_year'].'-'.$ay;?>
			</td>
          <td><strong>Class :</strong> <?php 
		 /* if($std_challan_details['current_year']==1)echo 'First year';
		  else if($std_challan_details['current_year']==2)
			  echo 'Second year'; else if($std_challan_details['current_year']==3) 
			echo 'Third year';else echo 'Fourth year';
		*/
		  if($std_challan_details['current_year']==1)
		  echo 'First year';
		  else if($std_challan_details['current_year']==2)
		  echo 'Second year'; 
	      else if($std_challan_details['current_year']==3) 
	      echo 'Third year';
          else if($std_challan_details['current_year']==4) 
		  echo 'Fourth year';
	      else
		  echo ''; 
		?></td>
        </tr>
        <tr>
          
          <td width="40%"><strong>Challan No:</strong><br><span style="font-size:13px"><?=$form_no?></span></td>
		  <td width="60%"><img style="padding-top:5px;padding-left:40px;padding-bottom:5px;" src="<?=$barcode?>" alt="Sandip University" width="100" height="50"/></td>
        </tr>
       <tr>
		<td colspan="2">
         <?php if($std_challan_details['type_id']==11){ ?>
		 <?php }else{ ?>
         <strong>Student ID :</strong> <?=$std_challan_details['enrollment_no']?><?php } ?></td>
		</tr>
        <tr>
          <td colspan="2"><strong>Name Of Student :</strong>
          <?php if($std_challan_details['type_id']==11){ ?>
		  <?=$std_challan_details['guest_name']?>
		  <?php }else{ ?>
		  <?=$std_challan_details['first_name']?> <?=$std_challan_details['middle_name']?> <?=$std_challan_details['last_name']?>
          <?php } ?>
          </td>
        </tr>
        <tr>
          <td colspan="2"><?php if($std_challan_details['type_id']==11){ ?>
		  <strong>Institute :</strong><?=$std_challan_details['guest_organisation']?>
		  <?php }else{ ?>
          <strong>Course/Branch :</strong><?=$std_challan_details['stream_name']?>
		  <?php } ?>
          </td>
        </tr>
        <tr>
          <td colspan="2"><strong>Contact No.:</strong>
           <?php if($std_challan_details['type_id']==11){ ?>
		   <?=$std_challan_details['guest_mobile']?>
            <?php }else{ ?>
		   <?=$std_challan_details['mobile']?><?php } ?>
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
          <td><strong><?php if($std_challan_details['type_id']=="2"){
		  echo 'Academic Fees';}else if($std_challan_details['type_id']=="5"){
		   echo 'Exam Fees -'; echo $std_challan_details['exam_monthyear']; }else if($std_challan_details['type_id']=="10"){
		    echo 'Other Fees';}else if($std_challan_details['type_id']=="11"){
			echo 'External Students & Staff Fees';
			}
		   ?></strong></td>
          <td></td>
        </tr>
		<?php if($std_challan_details['type_id']==2) {?>
     <?php //if($std_challan_details['Balance_Amount_status']=="Y"){?>
        <tr>
          <!--<td align="center">1</td>-->
          <td>Previous Balance</td>
          <td><?=$std_challan_details['Balance_Amount']?></td>
        </tr>
        <?php// } ?>
        <tr>
        <!--  <td align="center">2</td>-->
          <td>Tuition Fees</td>
          <td><?=$std_challan_details['tution_fees']?></td>
        </tr>
        <tr>
        <!--  <td align="center">3</td>-->
          <td>Development Fees</td>
          <td><?=$std_challan_details['development_fees']?></td>
        </tr>
        <tr>
         <!-- <td align="center">4</td>-->
          <td>Caution Money</td>
          <td><?=$std_challan_details['caution_money']?></td>
        </tr>
        <tr>
         <!-- <td align="center">5</td>-->
          <td>Admission Form</td>
          <td><?=$std_challan_details['admission_form']?></td>
        </tr>
        <tr>
        <!--  <td align="center">6</td>-->
          <td>Exam fees</td>
          <td><?=$std_challan_details['exam_fees']?></td>
        </tr>
        <tr>
         <!-- <td align="center">7</td>-->
          <td>University Fees</td>
          <td><?=$std_challan_details['university_fees']?></td>
        </tr>	
        
	<tr>
         <!-- <td align="center">8</td>-->
          <td>Excess Fees	</td>
          <td><?=$std_challan_details['Excess_Fees']?></td>
        </tr>
        <?php }elseif(($std_challan_details['type_id']==5)||($std_challan_details['type_id']==7)||($std_challan_details['type_id']==8)||($std_challan_details['type_id']==9)) {?>
         <tr>
         <!-- <td align="center">1</td>-->
          <td>Backlog Exam Fees</td>
          <td><?=$std_challan_details['Backlog_fees']?></td>
        </tr>
        <tr>
        <!--  <td align="center">2</td>-->
          <td>Photocopy Fees</td>
          <td><?=$std_challan_details['Photocopy_fees']?></td>
        </tr>
        <tr>
         <!-- <td align="center">3</td>-->
          <td>Revaluation Fees</td>
          <td><?=$std_challan_details['Revaluation_Fees']?></td>
        </tr>
        <tr>
          <!--<td align="center">4</td>-->
          <td>Late Fees</td>
          <td><?=$std_challan_details['Exam_LateFees']?></td>
        </tr>
        <?php }elseif($std_challan_details['type_id']==10){ ?>
        <tr>
          <!--<td align="center">1</td>-->
          <td>FINE/Brekage</td>
          <td><?=$std_challan_details['OtherFINE_Brekage']?></td>
        </tr>
        <tr>
         <!-- <td align="center">2</td>-->
          <td>Registration Fees</td>
          <td><?=$std_challan_details['Other_Registration']?></td>
        </tr>
        <tr>
         <!-- <td align="center">3</td>-->
          <td>Late Fees</td>
          <td><?=$std_challan_details['Other_Late']?></td>
        </tr>
        <tr>
         <!-- <td align="center">4</td>-->
          <td>Other Fees</td>
          <td><?=$std_challan_details['Other_fees']?></td>
        </tr>
		 <?php }elseif($std_challan_details['type_id']==13){ ?>
         <tr>
          <!--<td align="center">1</td>-->
          <td>Certificate Fees</td>
          <td><?=$std_challan_details['amount']?></td>
        </tr>
        <?php }elseif($std_challan_details['type_id']==11){ ?>
        <tr>
          <!--<td align="center">1</td>-->
          <td>Registration Fees</td>
          <td><?=$std_challan_details['guest_RegistrationFees']?></td>
        </tr>
        <tr>
          <!--<td align="center">2</td>-->
          <td>Other Fees</td>
          <td><?=$std_challan_details['guest_OtherFees']?></td>
        </tr>
        <?php } ?>
        
        
        <tr>
          <td align="right"><strong>Total Rs/-</strong></td>
          <td><strong><?=($std_challan_details['amount'])?></strong></td>
        </tr>
        </table>
        <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
		<tr>
          <td colspan="3"><strong>Remark:</strong><?php echo (($std_challan_details['remark']));?></td>
        </tr>
        <tr>
          <td colspan="3"><strong>Amount In Words :</strong>Rupees <strong><?php echo numberTowords(($std_challan_details['amount']));?></strong>  Only</td>
        </tr>
		<tr>
		<td colspan="3"><strong>Mode of Payment:</strong> <?=$std_challan_details['fees_paid_type']?></td>
		</tr>
		<!--	<tr>
		<td colspan="3"><?php if($std_challan_details['fees_paid_type']=='OL'){ ?><strong>Transaction No:</strong> <?=$std_challan_details['TransactionNo']?><?php } ?></td>
		</tr>
		-->
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
          <td><strong><?=$std_challan_details['fees_paid_type']?> No. :</strong> <?=$std_challan_details['receipt_no']?>  </td>
          <td><strong>Date :</strong> <?=date("d/m/Y", strtotime($std_challan_details['TransactionDate']))?> </td>
        </tr>
        <tr>
          <td><strong>Bank Name :</strong> <?=$std_challan_details['ubank_name']?> </td>
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
          <td><strong>Date :</strong> <?=date("d/m/Y", strtotime($std_challan_details['created_on']))?></td>
        </tr>
        <tr>
          <td colspan="2" height="80" valign="top">IMPORTANT INSTRUCTION TO <?=$std_challan_details['bank_code']?> BRANCH :</td>
        </tr>
        <tr>
          <td><strong>Seal & Date :</strong></td>
          <td><strong>Authorized Signatory :</strong></td>
        </tr>
         <tr>
          <td colspan="2" align="center"><span style="alignment-adjust:central">Note:-Cheque/DD are Subject to realisation</span></td>
         
        </tr><tr>
          <td colspan="2"><strong>This is computer generated receipt signature & Stamp not require</strong></td>
        </tr>
      </table> 
	  <?php // } ?>
	</td>
    <td width="33%" valign="top">
        <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="2"><strong><?=$std_challan_details['bank_code']?>-<?=$std_challan_details['branch_name']?></strong></td>
          <td><strong>University Copy</strong></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c No. : </strong><?=$std_challan_details['account_no']?></td>
          <td><strong>Date:</strong>  <?=date("d/m/Y", strtotime($std_challan_details['created_on']))?></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c Name :</strong><?=$std_challan_details['account_name']?></td>
		
          <td colspan="">
		   <?php if($std_challan_details['account_no']=='50100207594285'){?>
		  <strong>Client Id :</strong><?=$std_challan_details['clinet_id']?>
		  <?php }elseif($std_challan_details['account_no']=='50100291606982'){ ?>
			  <strong>Client Id :</strong><?=$std_challan_details['clinet_id']?>
		 <?php }else{ echo "--";}?></td>
       
        </tr>
		</table>
		 <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td><strong>Academic Year : </strong> <?php $ayear=explode('-',$std_challan_details['academic_year']); 
			$ay=substr($ayear[0], -2)+1; echo $std_challan_details['academic_year'].'-'.$ay;?>
			</td>
          <td><strong>Class :</strong> <?php 
		  if($std_challan_details['current_year']==1)
		  echo 'First year';
		  else if($std_challan_details['current_year']==2)
		  echo 'Second year'; 
	      else if($std_challan_details['current_year']==3) 
	      echo 'Third year';
          else if($std_challan_details['current_year']==4) 
		  echo 'Fourth year';
	      else
		  echo ''; 
		?></td>
        </tr>
        <tr>
          
          <td width="40%"><strong>Challan No. :</strong><br><span style="font-size:13px"><?=$form_no?></span></td>
		  <td width="60%"><img style="padding-top:5px;padding-left:40px;padding-bottom:5px;" src="<?=$barcode?>" alt="Sandip University" width="100" height="50"/></td>
        </tr>
        <tr>
		<td colspan="2">
         <?php if($std_challan_details['type_id']==11){ ?>
		 <?php }else{ ?>
         <strong>Student ID :</strong> <?=$std_challan_details['enrollment_no']?><?php } ?></td>
		</tr>
        <tr>
          <td colspan="2"><strong>Name Of Student :</strong>
          <?php if($std_challan_details['type_id']==11){ ?>
		  <?=$std_challan_details['guest_name']?>
		  <?php }else{ ?>
		  <?=$std_challan_details['first_name']?> <?=$std_challan_details['middle_name']?> <?=$std_challan_details['last_name']?>
          <?php } ?>
          </td>
        </tr>
        <tr>
          <td colspan="2"><?php if($std_challan_details['type_id']==11){ ?>
		  <strong>Institute :</strong><?=$std_challan_details['guest_organisation']?>
		  <?php }else{ ?>
          <strong>Course/Branch :</strong><?=$std_challan_details['stream_name']?>
		  <?php } ?>
          </td>
        </tr>
        <tr>
          <td colspan="2"><strong>Contact No.:</strong>
           <?php if($std_challan_details['type_id']==11){ ?>
		   <?=$std_challan_details['guest_mobile']?>
            <?php }else{ ?>
		   <?=$std_challan_details['mobile']?><?php } ?>
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
         <!-- <td align="center"></td>-->
          <td><strong><?php if($std_challan_details['type_id']=="2"){
		  echo 'Academic Fees ';}else if($std_challan_details['type_id']=="5"){
		  echo 'Exam Fees -'; echo $std_challan_details['exam_monthyear'];}else if($std_challan_details['type_id']=="10"){
		    echo 'Other Fees';}else if($std_challan_details['type_id']=="11"){
			echo 'External Students & Staff Fees';
			}
		   ?> </strong></td>
          <td></td>
        </tr>
		<?php if($std_challan_details['type_id']==2) {?>
       <?php //if($std_challan_details['Balance_Amount_status']=="Y"){?>
        <tr>
        <!--  <td align="center">1</td>-->
          <td>Previous Balance</td>
          <td><?=$std_challan_details['Balance_Amount']?></td>
        </tr>
        <?php //}?>
        <tr>
         <!-- <td align="center">2</td>-->
          <td>Tuition Fees</td>
          <td><?=$std_challan_details['tution_fees']?></td>
        </tr>
        <tr>
         <!-- <td align="center">3</td>-->
          <td>Development Fees</td>
          <td><?=$std_challan_details['development_fees']?></td>
        </tr>
        <tr>
         <!-- <td align="center">4</td>-->
          <td>Caution Money</td>
          <td><?=$std_challan_details['caution_money']?></td>
        </tr>
        <tr>
         <!-- <td align="center">5</td>-->
          <td>Admission Form</td>
          <td><?=$std_challan_details['admission_form']?></td>
        </tr>
        <tr>
         <!-- <td align="center">6</td>-->
          <td>Exam fees</td>
          <td><?=$std_challan_details['exam_fees']?></td>
        </tr>
        	
        
         <tr>
         <!-- <td align="center">7</td>-->
          <td>University Fees</td>
          <td><?=$std_challan_details['university_fees']?></td>
        </tr>
        
        
	    <tr>
        
        
          <!--<td align="center">8</td>-->
          <td>Excess Fees	</td>
          <td><?=$std_challan_details['Excess_Fees']?></td>
        </tr>
        <?php }elseif(($std_challan_details['type_id']==5)||($std_challan_details['type_id']==7)||($std_challan_details['type_id']==8)||($std_challan_details['type_id']==9)) {?>
         <tr>
          <!--<td align="center">1</td>-->
          <td>Backlog Exam Fees</td>
          <td><?=$std_challan_details['Backlog_fees']?></td>
        </tr>
        <tr>
         <!-- <td align="center">2</td>-->
          <td>Photocopy Fees</td>
          <td><?=$std_challan_details['Photocopy_fees']?></td>
        </tr>
        <tr>
          <!--<td align="center">3</td>-->
          <td>Revaluation Fees</td>
          <td><?=$std_challan_details['Revaluation_Fees']?></td>
        </tr>
        <tr>
         <!-- <td align="center">4</td>-->
          <td>Late Fees</td>
          <td><?=$std_challan_details['Exam_LateFees']?></td>
        </tr>
        <?php }elseif($std_challan_details['type_id']==10){ ?>
        <tr>
          <!--<td align="center">1</td>-->
          <td>FINE/Brekage</td>
          <td><?=$std_challan_details['OtherFINE_Brekage']?></td>
        </tr>
        <tr>
         <!-- <td align="center">2</td>-->
          <td>Registration Fees</td>
          <td><?=$std_challan_details['Other_Registration']?></td>
        </tr>
        <tr>
          <!--<td align="center">3</td>-->
          <td>Late Fees</td>
          <td><?=$std_challan_details['Other_Late']?></td>
        </tr>
        <tr>
          <!--<td align="center">4</td>-->
          <td>Other Fees</td>
          <td><?=$std_challan_details['Other_fees']?></td>
        </tr>
		 <?php }elseif($std_challan_details['type_id']==13){ ?>
         <tr>
          <!--<td align="center">1</td>-->
          <td>Certificate Fees</td>
          <td><?=$std_challan_details['amount']?></td>
        </tr>
       <?php }elseif($std_challan_details['type_id']==11){ ?>
        <tr>
          <!--<td align="center">1</td>-->
          <td>Registration Fees</td>
          <td><?=$std_challan_details['guest_RegistrationFees']?></td>
        </tr>
        <tr>
         <!-- <td align="center">2</td>-->
          <td>Other Fees</td>
          <td><?=$std_challan_details['guest_OtherFees']?></td>
        </tr>
        <?php } ?>
        <tr>
          <td  align="right"><strong>Total Rs/-</strong></td>
          <td><strong><?=($std_challan_details['amount'])?></strong></td>
        </tr>
        </table>
        <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
		<tr>
          <td colspan="3"><strong>Remark:</strong><?php echo (($std_challan_details['remark']));?></td>
        </tr>
        <tr>
          <td colspan="3"><strong>Amount In Words :</strong>Rupees <strong><?php echo numberTowords(($std_challan_details['amount']));?></strong>  Only</td>
        </tr>
		<tr>
		<td colspan="3"><strong>Mode of Payment:</strong> <?=$std_challan_details['fees_paid_type']?></td>
		</tr>
		<!--	<tr>
		<td colspan="3"><?php if($std_challan_details['fees_paid_type']=='OL'){ ?><strong>Transaction No:</strong> <?=$std_challan_details['TransactionNo']?><?php } ?></td>
		</tr>
		-->
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
          <td><strong><?=$std_challan_details['fees_paid_type']?> No. :</strong> <?=$std_challan_details['receipt_no']?>  </td>
          <td><strong>Date :</strong> <?=date("d/m/Y", strtotime($std_challan_details['TransactionDate']))?> </td>
        </tr>
        <tr>
          <td><strong>Bank Name :</strong> <?=$std_challan_details['ubank_name']?> </td>
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
          <td><strong>Date :</strong> <?=date("d/m/Y", strtotime($std_challan_details['created_on']))?></td>
        </tr>
        <tr>
          <td colspan="2" height="80" valign="top">IMPORTANT INSTRUCTION TO <?=$std_challan_details['bank_code']?> BRANCH:</td>
        </tr>
        <tr>
          <td><strong>Seal & Date :</strong></td>
          <td><strong>Authorized Signatory :</strong></td>
        </tr>
         <tr>
          <td colspan="2" align="center"><span style="alignment-adjust:central">Note:-Cheque/DD are Subject to realisation</span></td>
         
        </tr><tr>
          <td colspan="2"><strong>This is computer generated receipt signature & Stamp not require</strong></td>
        </tr>
      </table>
	</td>
	
	
    <td width="33%" valign="top">
        <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td colspan="2"><strong><?=$std_challan_details['bank_code']?>-<?=$std_challan_details['branch_name']?></strong></td>
          <td><strong>Student Copy</strong></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c No. : </strong><?=$std_challan_details['account_no']?></td>
          <td><strong>Date:</strong>  <?=date("d/m/Y", strtotime($std_challan_details['created_on']))?></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Bank A/c Name :</strong><?=$std_challan_details['account_name']?></td>
		  <td colspan="">
		   <?php if($std_challan_details['account_no']=='50100207594285'){?>
		  <strong>Client Id :</strong><?=$std_challan_details['clinet_id']?>
		  <?php }elseif($std_challan_details['account_no']=='50100291606982'){ ?>
			  <strong>Client Id :</strong><?=$std_challan_details['clinet_id']?>
		 <?php }else{ echo "--";}?></td>
        </tr>
		</table>
		 <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
        <tr>
          <td><strong>Academic Year : </strong> <?php $ayear=explode('-',$std_challan_details['academic_year']); 
			$ay=substr($ayear[0], -2)+1; echo $std_challan_details['academic_year'].'-'.$ay;?>
			</td>
          <td><strong>Class :</strong> <?php 
		/*if($std_challan_details['current_year']==1)echo 'First year';
		else if($std_challan_details['current_year']==2)
		echo 'Second year'; else if($std_challan_details['current_year']==3) 
		echo 'Third year';
	    else echo 'Fourth year';*/
		if($std_challan_details['current_year']==1)
		  echo 'First year';
		  else if($std_challan_details['current_year']==2)
		  echo 'Second year'; 
	      else if($std_challan_details['current_year']==3) 
	      echo 'Third year';
          else if($std_challan_details['current_year']==4) 
		  echo 'Fourth year';
	      else
		  echo ''; 
		?></td>
        </tr>
        <tr>
          
          <td width="40%"><strong>Challan No:</strong><br><span style="font-size:13px"><?=$form_no?></span></td>
		  <td width="60%"><img style="padding-top:5px;padding-left:40px;padding-bottom:5px;" src="<?=$barcode?>" alt="Sandip University" width="100" height="50"/></td>
        </tr>
       <tr>
		<td colspan="2">
         <?php if($std_challan_details['type_id']==11){ ?>
		 <?php }else{ ?>
         <strong>Student ID :</strong> <?=$std_challan_details['enrollment_no']?><?php } ?></td>
		</tr>
        <tr>
          <td colspan="2"><strong>Name Of Student :</strong>
          <?php if($std_challan_details['type_id']==11){ ?>
		  <?=$std_challan_details['guest_name']?>
		  <?php }else{ ?>
		  <?=$std_challan_details['first_name']?> <?=$std_challan_details['middle_name']?> <?=$std_challan_details['last_name']?>
          <?php } ?>
          </td>
        </tr>
        <tr>
          <td colspan="2"><?php if($std_challan_details['type_id']==11){ ?>
		  <strong>Institute :</strong><?=$std_challan_details['guest_organisation']?>
		  <?php }else{ ?>
          <strong>Course/Branch :</strong><?=$std_challan_details['stream_name']?>
		  <?php } ?>
          </td>
        </tr>
        <tr>
          <td colspan="2"><strong>Contact No.:</strong>
           <?php if($std_challan_details['type_id']==11){ ?>
		   <?=$std_challan_details['guest_mobile']?>
            <?php }else{ ?>
		   <?=$std_challan_details['mobile']?><?php } ?>
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
        <!--  <td align="center"></td>-->
          <td><strong><?php if($std_challan_details['type_id']=="2"){
		  echo 'Academic Fees';}else if($std_challan_details['type_id']=="5"){
		  echo 'Exam Fees -'; echo $std_challan_details['exam_monthyear']; }else if($std_challan_details['type_id']=="10"){
		    echo 'Other Fees';}else if($std_challan_details['type_id']=="11"){
			echo 'External Students & Staff Fees';
			}
		   ?> </strong></td>
          <td></td>
        </tr>
		<?php if($std_challan_details['type_id']==2) {?>
      <?php //if($std_challan_details['Balance_Amount_status']=="Y"){?>
       <tr>
          <!--<td align="center">1</td>-->
          <td>Previous Balance</td>
          <td><?=$std_challan_details['Balance_Amount']?></td>
        </tr>
        <?php //} ?>
        <tr>
         <!-- <td align="center">2</td>-->
          <td>Tuition Fees</td>
          <td><?=$std_challan_details['tution_fees']?></td>
        </tr>
        <tr>
         <!-- <td align="center">3</td>-->
          <td>Development Fees</td>
          <td><?=$std_challan_details['development_fees']?></td>
        </tr>
        <tr>
         <!-- <td align="center">4</td>-->
          <td>Caution Money</td>
          <td><?=$std_challan_details['caution_money']?></td>
        </tr>
        <tr>
         <!-- <td align="center">5</td>-->
          <td>Admission Form</td>
          <td><?=$std_challan_details['admission_form']?></td>
        </tr>
        <tr>
         <!-- <td align="center">6</td>-->
          <td>Exam fees</td>
          <td><?=$std_challan_details['exam_fees']?></td>
        </tr>
        <tr>
         <!-- <td align="center">7</td>-->
          <td>University Fees</td>
          <td><?=$std_challan_details['university_fees']?></td>
        </tr>	
       
	<tr>
          <!--<td align="center">8</td>-->
          <td>Excess Fees	</td>
          <td><?=$std_challan_details['Excess_Fees']?></td>
        </tr>
        <?php }elseif(($std_challan_details['type_id']==5)||($std_challan_details['type_id']==7)||($std_challan_details['type_id']==8)||($std_challan_details['type_id']==9)) {?>
         <tr>
         <!-- <td align="center">1</td>-->
          <td>Backlog Exam Fees</td>
          <td><?=$std_challan_details['Backlog_fees']?></td>
        </tr>
        <tr>
         <!-- <td align="center">2</td>-->
          <td>Photocopy Fees</td>
          <td><?=$std_challan_details['Photocopy_fees']?></td>
        </tr>
        <tr>
          <!--<td align="center">3</td>-->
          <td>Revaluation Fees</td>
          <td><?=$std_challan_details['Revaluation_Fees']?></td>
        </tr>
        <tr>
          <!--<td align="center">4</td>-->
          <td>Late Fees</td>
          <td><?=$std_challan_details['Exam_LateFees']?></td>
        </tr>
        <?php }elseif($std_challan_details['type_id']==10){ ?>
        <tr>
          <!--<td align="center">1</td>-->
          <td>FINE/Brekage</td>
          <td><?=$std_challan_details['OtherFINE_Brekage']?></td>
        </tr>
        <tr>
         <!-- <td align="center">2</td>-->
          <td>Registration Fees</td>
          <td><?=$std_challan_details['Other_Registration']?></td>
        </tr>
        <tr>
          <!--<td align="center">3</td>-->
          <td>Late Fees</td>
          <td><?=$std_challan_details['Other_Late']?></td>
        </tr>
        <tr>
         <!-- <td align="center">4</td>-->
          <td>Other Fees</td>
          <td><?=$std_challan_details['Other_fees']?></td>
        </tr>
		 <?php }elseif($std_challan_details['type_id']==13){ ?>
         <tr>
          <!--<td align="center">1</td>-->
          <td>Certificate Fees</td>
          <td><?=$std_challan_details['amount']?></td>
        </tr>
         <?php }elseif($std_challan_details['type_id']==11){ ?>
        <tr>
          <!--<td align="center">1</td>-->
          <td>Registration Fees</td>
          <td><?=$std_challan_details['guest_RegistrationFees']?></td>
        </tr>
        <tr>
          <!--<td align="center">2</td>-->
          <td>Other Fees</td>
          <td><?=$std_challan_details['guest_OtherFees']?></td>
        </tr>
        <?php } ?>
        <tr>
          <td  align="right"><strong>Total Rs/-</strong></td>
          <td><strong><?=($std_challan_details['amount'])?></strong></td>
        </tr> </table>
        <table width="350" border="1" cellspacing="0" cellpadding="0" class="table">
		<tr>
          <td colspan="3"><strong>Remark:</strong><?php echo (($std_challan_details['remark']));?></td>
        </tr>
        <tr>
          <td colspan="3"><strong>Amount In Words :</strong>Rupees <strong><?php echo numberTowords(($std_challan_details['amount']));?></strong>  Only</td>
        </tr>
		<tr>
		<td colspan="3"><strong>Mode of Payment:</strong> <?=$std_challan_details['fees_paid_type']?></td>
		</tr>
	<!--	<tr>
		<td colspan="3"><?php if($std_challan_details['fees_paid_type']=='OL'){ ?><strong>Transaction No:</strong> <?=$std_challan_details['TransactionNo']?><?php } ?></td>
		</tr>
		-->
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
          <td><strong><?=$std_challan_details['fees_paid_type']?> No. :</strong> <?=$std_challan_details['receipt_no']?>  </td>
         <td><strong>Date :</strong> <?=date("d/m/Y", strtotime($std_challan_details['TransactionDate']))?> </td>
        </tr>
        <tr>
          <td><strong>Bank Name :</strong> <?=$std_challan_details['ubank_name']?> </td>
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
          <td><strong>Date :</strong> <?=date("d/m/Y", strtotime($std_challan_details['created_on']))?></td>
        </tr>
        <tr>
          <td colspan="2" height="80" valign="top">IMPORTANT INSTRUCTION TO <?=$std_challan_details['bank_code']?> BRANCH :</td>
        </tr>
        <tr>
          <td><strong>Seal & Date :</strong></td>
          <td><strong>Authorized Signatory :</strong></td>
        </tr>
         <tr>
          <td colspan="2" align="center"><span style="alignment-adjust:central">Note:-Cheque/DD are Subject to realisation</span></td>
         
        </tr><tr>
          <td colspan="2"><strong>This is computer generated receipt signature & Stamp not require</strong></td>
        </tr>
      </table>
	  
	</td>
	 
    
	  
  </tr>
</table>
</body>
</html>
