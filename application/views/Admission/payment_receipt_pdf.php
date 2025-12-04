<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style>
body{font-family: arial, sans-serif;font-size:13px;}
table tr td{xvertical-align:top;padding-left:4px;padding-right:4px;padding-top:2px;padding-bottom:2px;}
h2{margin:0px;font-size:20px}
h3{margin:0px;}
p{margin:0px;}
</style>
</head>
<body>
    <?php
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
4 => "fourty", 
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
if($fee_det['year']==1)
{
 $year="FE";   
}
 if($fee_det['year']==2)
{
 $year="SE";   
}
if($fee_det['year']==3)
{
 $year="TE";   
}

    ?>
<div style="width:90%;margin:0 auto;height:400px;">
    <br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:1px solid  #333;border-right:1px solid  #333;border-left:1px solid  #333;">
  <tr>
    <td><img src="<?=site_url()?>assets/images/su-logo.jpg" width="90" style="margin-top:5px"></td>
    <td align="center"><h2>SANDIP UNIVERSITY</h2>
    <p>At Post Mahirawani, Trimbak Road, Tal. & Dist. Nashik - 422 213</p>
    <p><strong>Phone:</strong> (2594) 222541 / 42 / 43 /44 / 45</p>
    <p><strong>E-mail:</strong> admissions@sandipuniversity.edu.in | www.sandipuniversity.edu.in</p>
    </td>
  </tr>

</table>
<table width="100%" border="1" cellspacing="0" cellpadding="3" style="border:1px solid  #333;">
  <tr>
    <td colspan="3" align="center"><h3><strong>RECEIPT</strong></h3></td>
    </tr>

  <tr>
    <td><strong>Receipt No. : </strong>0000<?=$fee_det['fees_id']?></td>
    <td><strong>Date : </strong><?=date('d-m-Y',strtotime($fee_det['fees_date']))?></td>
    <td><strong>Reg. No. : </strong> 18SUN0001</td>
  </tr>
  <tr>
    <td><strong>Name : </strong><?=$fee_det['last_name']." ".$fee_det['middle_name']." ".$fee_det['first_name'];?></td>
    <td><strong>Year : </strong><?=$year?></td>
    <td><strong>Academic Year : </strong><?php 
     $var = substr($fee_det['academic_year'], -2);

$var = ++$var;
   echo $fee_det['academic_year']."-".$var;?></td>
    
    </tr>
    
  
      <tr>
    <td><strong>Course : </strong><?=$fee_det['course_name']?></td>
    <td colspan="2"><strong>Stream : </strong><?=$fee_det['stream_name']?></td>
    </tr>

</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid  #333;">
  <tr>
    <th>Sr No</th>
    <th>Particulars</th>
    <th colspan="2">Amount</th>
  
    </tr>
      <tr>
    <td align="center"></td>
    <td></td>
    <th>Rs.</th>
    <th>Ps.</th>
  </tr>
  
    <tr>
    <td align="center">1</td>
    <td>Admission Fees</td>
    <td>750</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td align="center">2</td>
    <td>Caution Money Fees</td>
    <td>500</td>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td align="center">3</td>
    <td>Tuition / Interim Fees</td>
    <td>38750</td>
    <td></td>
  </tr>
  <tr>
    <td align="center">4</td>
    <td>Development Fees</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td align="center">5</td>
    <td>University Fees</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td align="center">6</td>
    <td>Exam Fees</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">7</td>
    <td>Other Fees</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><strong>Total</strong></td>
    <td><?=$fee_det['amount']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
  <tr>
    <td colspan="3"><strong>Recieved Rs.(In Word) : </strong><?=ucfirst(numberTowords($fee_det['amount']))?> Only</td>
    </tr>
  <tr>
      <td><strong>By <?=$fee_det['fees_paid_type']?> No. : </strong><?=$fee_det['receipt_no']?></td>
    <td><strong>Drawn on Bank : </strong><?=$fee_det['bank_name']?></td>
    <td><strong>Dt. : </strong><?=date('d-m-Y',strtotime($fee_det['fees_date']))?></td>
    </tr>
  <tr>
    
  </tr>

</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1" style="border-bottom:1px solid  #333;border-right:1px solid  #333;border-left:1px solid  #333;">
    <tr>
    <td width="50%" valign="bottom" height="70"><strong>Note: Ch / DD subject to realization</strong></td>
    <td align="right" valign="bottom" height="70"><strong>Cashier / Account Clerk</strong><br>for<strong> Sandip University</strong></td>
  </tr>
</table>
<br>
</div>
<hr style="border:1px dotted">
<div style="width:90%;margin:0 auto;height:400px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:1px solid  #333;border-right:1px solid  #333;border-left:1px solid  #333;">
  <tr>
    <td><img src="<?=site_url()?>assets/images/su-logo.jpg" width="90" style="margin-top:5px"></td>
    <td align="center"><h2>SANDIP UNIVERSITY</h2>
    <p>At Post Mahirawani, Trimbak Road, Tal. & Dist. Nashik - 422 213</p>
    <p><strong>Phone:</strong> (2594) 222541 / 42 / 43 /44 / 45</p>
    <p><strong>E-mail:</strong> admissions@sandipuniversity.edu.in | www.sandipuniversity.edu.in</p>
    </td>
  </tr>

</table>
<table width="100%" border="1" cellspacing="0" cellpadding="3" style="border:1px solid  #333;">
  <tr>
    <td colspan="3" align="center"><h3><strong>RECEIPT</strong></h3></td>
    </tr>

  <tr>
    <td><strong>Receipt No. : </strong>0000<?=$fee_det['fees_id']?></td>
    <td><strong>Date : </strong><?=date('d-m-Y',strtotime($fee_det['fees_date']))?></td>
        <td><strong>Reg. No. : </strong> 18SUN0001</td>
  </tr>
  <tr>
    <td><strong>Name : </strong><?=$fee_det['last_name']." ".$fee_det['middle_name']." ".$fee_det['first_name'];?></td>
    <td><strong>Year : </strong><?=$year?></td>
    <td><strong>Academic Year : </strong><?php 
     $var = substr($fee_det['academic_year'], -2);

$var = ++$var;
   echo $fee_det['academic_year']."-".$var;?></td>
    
    </tr>
    
  
      <tr>
    <td><strong>Course : </strong><?=$fee_det['course_name']?></td>
    <td colspan="2"><strong>Stream : </strong><?=$fee_det['stream_name']?></td>
    </tr>

</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid  #333;">
  <tr>
    <th>Sr No</th>
    <th>Particulars</th>
    <th colspan="2">Amount</th>
  
    </tr>
      <tr>
    <td align="center"></td>
    <td></td>
    <th>Rs.</th>
    <th>Ps.</th>
  </tr>
  
    <tr>
    <td align="center">1</td>
    <td>Admission Fees</td>
    <td>750</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td align="center">2</td>
    <td>Caution Money Fees</td>
    <td>500</td>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td align="center">3</td>
    <td>Tuition / Interim Fees</td>
    <td>38750</td>
    <td></td>
  </tr>
  <tr>
    <td align="center">4</td>
    <td>Development Fees</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td align="center">5</td>
    <td>University Fees</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td align="center">6</td>
    <td>Exam Fees</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">7</td>
    <td>Other Fees</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><strong>Total</strong></td>
    <td><?=$fee_det['amount']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #333;">
  <tr>
    <td colspan="3"><strong>Recieved Rs.(In Word) : </strong><?=ucfirst(numberTowords($fee_det['amount']))?> Only</td>
    </tr>
  <tr>
    <td><strong>By <?=$fee_det['fees_paid_type']?> No. : </strong><?=$fee_det['receipt_no']?></td>
    <td><strong>Drawn on Bank : </strong><?=$fee_det['bank_name']?></td>
    <td><strong>Dt. : </strong><?=date('d-m-Y',strtotime($fee_det['fees_date']))?></td>
    </tr>
  <tr>
    
  </tr>

</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1" style="border-bottom:1px solid  #333;border-right:1px solid  #333;border-left:1px solid  #333;">
    <tr>
    <td width="50%" valign="bottom" height="70"><strong>Note: Ch / DD subject to realization</strong></td>
    <td align="right" valign="bottom" height="70"><strong>Cashier / Account Clerk</strong><br>for<strong> Sandip University</strong></td>
  </tr>
</table>

</div>
</body>
</html>
