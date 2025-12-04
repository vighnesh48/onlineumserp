 <?php 
 function numberTowords(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
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
1 => "One", 
2 => "Two", 
3 => "Three", 
4 => "Four", 
5 => "Five", 
6 => "Six", 
7 => "Seven", 
8 => "Eight", 
9 => "Nine", 
10 => "Ten", 
11 => "Eleven", 
12 => "Twelve", 
13 => "Thirteen", 
14 => "Fourteen", 
15 => "Fifteen", 
16 => "Sixteen", 
17 => "Seventeen", 
18 => "Eighteen", 
19 => "Nineteen" 
); 
$tens = array( 
1 => "Ten",
2 => "Twenty", 
3 => "Thirty", 
4 => "Forty", 
5 => "Fifty", 
6 => "Sixty", 
7 => "Seventy", 
8 => "Eighty", 
9 => "Ninety" 
); 
$hundreds = array( 
"Hundred", 
"Thousand", 
"Million", 
"Billion", 
"Trillion", 
"Quadrillion" 
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
<table  border="1" align="center" width="100%" cellpadding="3" cellspacing="0" style="font-size:12px;">
            <thead>
			<tr style="border:1px solid #000;">
			<th style="border-top:1px solid #000" align="left">Sr.No</th>
            <th style="border:1px solid #000" align="left">Barcode</th>
			<th style="border:1px solid #000" align="left">MARKS</th>
			<th style="border:1px solid #000" align="left">MARKS IN WORDS</th>
            </tr>
			</thead>
			<tbody>
             <?php
			$count=0;
			$count_AB=0;
			$k=1;
				if(!empty($mrks)){
					foreach($mrks as $stud){
			?>
            <tr style="border:1px solid #000;">
            <td style="border:1px solid #000;" width="5%"><?=$k?></td>
            <td style="border:1px solid #000;" width="20%"><?=$stud['barcode']?></td>
           <td style="border:1px solid #000;" width="20%"><?=$stud['marks']?></td>
           <td style="border:1px solid #000;" width="20%">
		   <?php
             if($stud['marks']=="AB" || $stud['marks']=="00" || $stud['marks']=="BA")
			 {
				echo ' - ';
			 }else
			 {
		      echo numberTowords(($stud['marks']));
			 } ?>
			  </td>
			 
            </tr>
			<?php 
			if($stud['marks']=='AB'){
				$count_AB++;
			}
			$k++;
			$count++;
				}
			 }
			?>
			</tbody>

</table>
  <table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:40px;">
            <tr>
            <td align="center">
                <table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td align="center" class="signature" valign="bottom" ><strong>No.of Present :</strong> <?=count($mrks)-$count_AB;?></td>
                    <td align="center"  class="signature" valign="bottom"><strong>No.of. Absent :</strong> <?=$count_AB?></td>
                    <td align="center" class="signature" valign="bottom"><strong>Total :</strong> <?=count($mrks);?></td>
                </tr>
                </table>
            </td>
            </tr>
        </table>