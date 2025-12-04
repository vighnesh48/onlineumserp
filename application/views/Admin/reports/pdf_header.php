<table width="100%" border="0" cellspacing="0" cellpadding="0"   >
  <tr>
    <td valign="middle" align="left" width="90" style="padding-left:20px;">
      
        <img src="<?php echo site_url();?>assets/images/logo_exl.jpg" width="70" style="vertical-align:middle;padding-top:10px">

    </td>

<td valign="top" align="center" style="padding-left:-80px; padding-top:10px;">
    <br/>
    <!-- Sandip Foundation -->
    <p style="font-size:24px; color:red; font-weight:bold; line-height:35px; margin-bottom:15px;">
      SANDIP UNIVERSITY
 
    </p>
    <p style="font-size:10px; color:#333; line-height:22px; margin-bottom:0;">
               TRIMBAK ROAD, MAHIRAVANI, NASHIK-422213			
    </p>
</td>
  </tr>
</table><hr style="width:95%;margin:0px auto;"/>


<?php
function format_inr($number) {
    $number = (float)$number;
    $number = number_format($number, 2, '.', '');
    $exploded = explode('.', $number);
    $decimal = $exploded[1];
    $number = $exploded[0];
    $len = strlen($number);
    if ($len > 3) {
        $last3 = substr($number, -3);
        $restunits = substr($number, 0, $len - 3);
        $restunits = (strlen($restunits) % 2 == 1) ? "0".$restunits : $restunits;
        $expunit = str_split($restunits, 2);
        $inr = "";
        foreach ($expunit as $k => $v) {
            if ($k == 0) $v = (int)$v;
            $inr .= $v . ",";
        }
        $output = $inr . $last3;
    } else {
        $output = $number;
    }
    return $output;
}


function numberToWords($number) {
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'Negative ';
    $decimal     = ' point ';
    $dictionary  = [
        0 => 'Zero',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety',
        100 => 'Hundred',
        1000 => 'Thousand',
        100000 => 'Lakh',
        10000000 => 'Crore'
    ];

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
        // overflow
        return false;
    }

    if ($number < 0) {
        return $negative . numberToWords(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int)($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = (int)($number / 100);
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . numberToWords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            if ($baseUnit > 10000000) $baseUnit = 10000000;
            elseif ($baseUnit > 100000) $baseUnit = 100000;
            elseif ($baseUnit > 1000) $baseUnit = 1000;

            $numBaseUnits = (int)($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = numberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $separator . numberToWords($remainder);
            }
            break;
    }

    if ($fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = [];
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

?>