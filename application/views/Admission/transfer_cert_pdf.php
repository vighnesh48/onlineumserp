<?php
//var_dump($bonafieddata);
//var_dump($cert_data);

$CI =& get_instance();
function numberTowords_new(float $number)
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
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' ' : '';
    return ($Rupees ? $Rupees .' ' : ''). $paise;
}
function numberTowords($num)
{ 

$ones = array(
0 =>"ZERO", 
1 => "ONE", 
2 => "TWO", 
3 => "THREE", 
4 => "FOUR", 
5 => "FIVE", 
6 => "SIX", 
7 => "SEVEN", 
8 => "EIGHT", 
9 => "NINE",
10 => "TEN", 
11 => "ELEVEN", 
12 => "TWELVE", 
13 => "THIRTEEN", 
14 => "FOURTEEN", 
15 => "FIFTEEN", 
16 => "SIXTEEN", 
17 => "SEVENTEEN", 
18 => "EIGHTEEN", 
19 => "NINETEEN",
"014" => "FOURTEEN" 
); 
$tens = array( 
0 => "ZERO",
1 => "TEN",
2 => "TWENTY", 
3 => "THIRTY", 
4 => "FORTY", 
5 => "FIFTY", 
6 => "SIXTY", 
7 => "SEVENTY", 
8 => "EIGHTY", 
9 => "NINETY" 
); 
$hundreds = array( 
"HUNDRED", 
"THOUSAND",
"MILLION", 
"BILLION", 
"TRILLION",
"QUARDRILLION" 
); /* limit t quadrillion */
$num = number_format($num,2,".",",");
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr,1); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){
	
while(substr($i,0,1)=="0")
		$i=substr($i,1,5);
if($i < 20){ 
/* echo "getting:".$i; */
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
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
/*function numberTowords12($num)
{ 
$ones = array(
0 =>"ZERO", 
1 => "ONE", 
2 => "TWO", 
3 => "THREE", 
4 => "FOUR", 
5 => "FIVE", 
6 => "SIX", 
7 => "SEVEN", 
8 => "EIGHT", 
9 => "NINE", 
10 => "TEN", 
11 => "ELEVEN", 
12 => "TWELVE", 
13 => "THIRTEEN", 
14 => "FOURTEEN", 
15 => "FIFTEEN", 
16 => "SIXTEEN", 
17 => "SEVENTEEN", 
18 => "EIGHTEEN", 
19 => "NINETEEN",
"014" => "FOURTEEN" 
); 
$tens = array( 
0 => "ZERO",
1 => "TEN",
2 => "TWENTY", 
3 => "THIRTY", 
4 => "FORTY", 
5 => "FIFTY", 
6 => "SIXTY", 
7 => "SEVENTY", 
8 => "EIGHTY", 
9 => "NINETY" 
); 
$hundreds = array( 
"HUNDRED", 
"THOUSAND", 
"MILLION", 
"BILLION", 
"TRILLION", 
"QUARDRILLION" 
); //limit t quadrillion 
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr,1); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){
while(substr($i,0,1)=="0")
$i=substr($i,1,5);
if($i < 20){ 
//echo "getting:".$i;
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
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
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Transfer Certificate</title>
<style>
body{font-family: arial, sans-serif;font-size:12px;	;
background-color:transparent;
	background-position:center;
	background-repeat: no-repeat;
	margin-left: auto;
	margin-top: 0px;
	margin-right: auto;
	background-size:cover;
	margin-bottom: 0px;}
p{padding:10px 0;}
table {
	font-family: arial, sans-serif;
	border-collapse: collapse;
	width: 100%;
	font-size: 11px;
	margin: 0 auto;


}
td {
	xvertical-align: top;
}
p {
	padding: 0px;
	margin: 0px;
}
h1, h3 {
	margin: 0;
	padding: 0
}
.content-table td, .content-table th {
	align: center;
	xvertical-align: center;
	border: 1px solid #000;
	padding-left: 7px;
	line-height: 27px;
	verticle-align:middle;
}
.content-table th {
	text-align: left;
}
.head-table td{
	border-left: 1px solid #000;
	border-right: 1px solid #000;
	border-top: 1px solid #000;
	border-bottom: 1px solid #000;
	height:30px;padding-top:20px;
	verticle-align:middle;
	}
	.content-table td,.content-table th{
	    height:30px;font-size:12px;
	}
	.footer-table td{
	  height:20px;verticle-align:middle; 
	 border:none;
	}
</style>
</head>

<body>
<div style="height:auto;margin:0px auto 0px auto;border:1px solid #ccc; padding:0px 10px">
  <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin-top:0px!important;">
    <tr>
   <td align="center"  style="font-weight:normal;text-align:center">
     <img src="https://erp.sandipuniversity.com/assets/images/logo-7.png" width="300px" >
        <p style="font-size:13px;">Mahiravani, Trimbak Road, Nashik – 422 213</p>
        <p style="font-size:13px;">Website - www.sandipuniversity.edu.in</p></td>
    </tr>
   
  </table>
  
  <hr/><h3 style="font-size:16px;margin-bottom: 10px;padding-top:10px;text-align:center">LEAVING CERTIFICATE</h3>
  
  <table border="0" class="head-table" style="margin:30px;">
    <tr>
      <td width="33%" style="margin:0;padding:0;font-size:14px;background:#ddd;xline-height:25px;" align="center"><strong>L.C. No. :</strong> <?=$cert_data[0]['cert_reg']?></td>
      <td width="33%" style="margin:0;padding:0;font-size:14px;background:#ddd;xline-height:25px;" align="center"><strong>Student ID :</strong><?=$cert_data[0]['enrollment_no']?></td>
      <td style="margin:0;padding:0;font-size:14px;background:#ddd;xline-height:25px;" align="center"><strong>Registration No. :</strong><?=$bonafieddata['general_reg_no']?></td>
    </tr>
  </table>
  <table border="1" width="100%" class="content-table" style="margin:0px 30px;">
    <tr>
      <th width="50%">Full Name</th>
      <td><?=ucwords(strtolower($bonafieddata['last_name']." ".$bonafieddata['first_name']." ".$bonafieddata['middle_name']))?></td>
    </tr>
    <tr>
      <th>Mother's Name</th>
      <td><?=$bonafieddata['mother_name']?></td>
    </tr>
    <tr>
      <th>Caste with Sub-caste</th>
      <td><?=$bonafieddata['category']." ".$bonafieddata['sub_caste']?></td>
    </tr>
    <tr>
      <th>Religion</th>
      <td><?=$bonafieddata['religion']?></td>
    </tr>
        <tr>
      <th>Place of Birth</th>
      <td><?=ucfirst($bonafieddata['birth_place'])?></td>
    </tr>

    <tr>
      <th>Nationality</th>
      <td><?=$bonafieddata['nationality']?></td>
    </tr>

    <tr>
      <th>Date of Birth</th>
      <td> <?php  
          if($bonafieddata['dob']!='')
      {
          
          echo date('d/m/Y', strtotime($bonafieddata['dob']));
     //echo $dat = date_create(date('Y-m-d', strtotime($bonafieddata['dob'])));

//echo date_format($dat,"jS F Y");
}
 ?></td>
    </tr>

    <tr>
      <th>Date of Birth in words</th>
      <td>
      <?php 
       $birth_date = $bonafieddata['dob'];
	   if(!empty($birth_date)){
$bday_month = date("F", strtotime($birth_date));
$new_birth_date = explode('-', $birth_date);//exit;
$year = $new_birth_date[2];
$month = $new_birth_date[1];
$day  = $new_birth_date[0];
 $birth_day=numberTowords($day);//exit;
//$birth_year=numberTowords($year);
// exit();
$monthNum = $bday_month;
//$dateObj = DateTime::createFromFormat('!m', $monthNum);//Convert the number into month name
//$monthName = strtoupper($dateObj->format('F'));

if(substr($year,0,2)==20){
    $ye ="Two Thousand";
    $last = numberTowords_new(substr($year,-2));
    $ye .=" ".$last;
}
else
{
       $ye =numberTowords_new(substr($year,0,2));
      $last = numberTowords_new(substr($year,-2));
    $ye .=" ".$last;
}

//$ye=numberTowords_new($year);

$dem = "$birth_day $bday_month $ye";
echo ucwords(strtolower($dem));

	   }
     // exit();
      ?>
      
      </td>
    </tr>

    <tr>
      <th>Last Institute</th>
      <td><?=$bonafieddata['last_institute']?></td>
    </tr>
        <tr>
      <th>Admission Date</th>
      <td><?php //date_create("2013-03-15");
      if($bonafieddata['admission_date']!='')
      {
      $dat = date_create(date('Y-m-d', strtotime($bonafieddata['admission_date'])));
echo date_format($dat,"jS F Y");
}
 ?></td>
    </tr>
    <tr>
      <th>Progress</th>
      <td><?=ucfirst($cert_data[0]['progress'])?></td>
    </tr>
        <tr>
      <th>Conduct</th>
      <td><?=ucfirst($cert_data[0]['conduct'])?></td>
    </tr>
    <tr>
      <th>Leaving Date</th>
      <td><?php //date_create("2013-03-15");
      if($cert_data[0]['leaving_date']!='')
      {
      $dat = date_create(date('Y-m-d', strtotime($cert_data[0]['leaving_date'])));
echo date_format($dat,"jS F Y");
}
 ?></td>
    </tr>
    <tr>
      <th>Year & Semester in which studying and since when</th>
      <td><?php if($bonafieddata['current_year']==1){echo "FE";} if($bonafieddata['current_year']==2){echo "SE";} if($bonafieddata['current_year']==3){echo "TE";} if($bonafieddata['current_year']==4){echo "BE";}?> / <?=$bonafieddata['stream_name']?> / <?=$bonafieddata['admission_session']?>-<?=substr($bonafieddata['admission_session']+1,-2)?></td>
    </tr>

    <tr>
      <th>Reason of leaving Institute</th>
      <td><?=ucfirst($cert_data[0]['reason'])?></td>
    </tr>
    <tr>
      <th>Remark</th>
      <td><?=ucfirst($cert_data[0]['remark'])?></td>
    </tr>

  </table>
 
  <table border="0" width="100%" class="footer-table" style="margin:10px 30px;margin-left:30px; !important">
      <tr>
          <td><strong>Date:</strong> <?php //date_create("2013-03-15");
      if($cert_data[0]['cert_date']!='')
      {
      $dat = date_create(date('Y-m-d', strtotime($cert_data[0]['cert_date'])));
echo date_format($dat,"jS F Y");
}
 ?> </td>
      </tr>
      
  </table>
  <table border="0" width="100%" style=" margin-left:35px; !important">
<tr>
<td align="xcenter" style="font-size:13px;">It is Certified that above information is in accordance with the Institute's records</td>
</tr>
</table>
<table border="0" width="100%" style="margin:30px;margin-bottom:10px !important; margin-left:35px; !important">
<tr>
<td align="xcenter" style="height:100px;font-size:13px;"><strong>Prepared by</strong></td>
<td align="xcenter" style="height:100px;font-size:13px;"><strong>Checked by</strong></td>
<td align="center" style="height:100px;font-size:13px;"><strong>Registrar</strong></td>
</tr>
</table>
<!--<div style='margin-left:30px; !important'>It is Certified that above information is in accordance with the Institute's records<br><br></div>
-->
</div></body>
</html>


