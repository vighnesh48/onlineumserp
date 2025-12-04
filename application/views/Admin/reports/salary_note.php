<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BANK REPORT</title>
   <style>
	   @font-face {
         font-family: "Cambria";
         src: url("font/Cambria-Font-For-Windows.ttf") format("truetype");
         font-weight: normal;
         font-style: normal;
         }
	  
	  body{font-size:10px;font-family: "Cambria";}
         table td{padding:5px;font-family: "Cambria";}
		 
      </style>

</head>

<body>
<div class="col-lg-12">
<?php include('pdf_header.php'); ?>

<?php 

$tsoc1 = array_column($visit_sal, 'net_pay');
$total_salary = format_inr(array_sum($tsoc1));

?>
</div><br>
<div style="text-align:left;margin-left:50px;"><b> To,</div>
 <div style="text-align:left;margin-left:50px;"><b>The Branch Manager,<br/>
HDFC Bank,<br/> Sandip Foundation Branch<br/>Nashik.
</b></div><br/>
<div style="text-align:left;margin-left:50px;">Subject : Regarding the Remuneration for Visiting Faculties_Odd Sem for the month of <u><?php echo strtoupper(date('F Y', strtotime($dt))); ?></u></div><br/><div style="text-align:left;margin-left:50px;">Dear Sir/Madam,</div> <br/>	 <br/>			
<div style="text-align:left;margin-left:50px;">Find enclosed Cheque No. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dt. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; of Rs. <b><?php echo $total_salary; ?></b>&nbsp;&nbsp;towards Remuneration for visiting Faculties_odd sem for the month of <b><u><?php echo strtoupper(date('F Y', strtotime($dt))); ?></u></b><br/><br/>Kindly arrange to transfer the amount to their respective Bank Accounts.</div><br/>
	<div style="width:97%;margin-left:3px;" >
	
<?php
$bank1 = [];
$bankOthers = [];

foreach ($visit_sal as $val) {
    if ($val['bank_id'] == 19) {
        $bank1[] = $val;
    } else {
        $bankOthers[] = $val;
    }
}

// Reusable function to render a table
function renderTable($data, $title = '') {
    if (empty($data)) return;

    echo "<h4 style='margin-left:50px;'>$title</h4>";
    echo '<table border="1" style="page-break-inside:always;width:50%;margin-left:50px;" cellpadding="3" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th style="border: 1px solid black;width:10%;" width="3%"><b>Sr.No.</b></th>
            <th style="border: 1px solid black;width:30%;padding:7px;text-align:left;" width="20%"><b>Name of Vendor</b></th>
            <th style="border: 1px solid black;width:5%;" width="15%"><b>Sum of Total <br> Bill Amt</b></th>
            <th style="border: 1px solid black;width:5%;" width="15%"><b>Sum of TDS</b></th>
            <th style="border: 1px solid black;width:5%;" width="15%"><b>Arrears/<br>Office Advance</b></th>
            <th style="border: 1px solid black;width:5%;" width="15%"><b>TDS On Arrears/<br>Office Advance</b></th>
            <th style="border: 1px solid black;width:5%;" width="10%"><b>Net Amount</b></th>
        </tr>
    </thead>
    <tbody>';

    $i = 1;
    $tsoc = $tsoc1 = $tsoc2 = $tsoc3 = $tsoc4 = [];

    foreach ($data as $val) {
        echo '<tr>
            <td style="text-align:center;">' . $i . '</td>
            <td>' . $val['fullname'] . '</td>
            <td style="text-align:right;">' . $val['bill_amount'] . '</td>
            <td style="text-align:right;">' . $val['tds_amount'] . '</td>
            <td style="text-align:right;">' . $val['other_paid'] . '</td>
            <td style="text-align:right;">' . ($val['arrs_tds'] ? $val['arrs_tds'] : 0) . '</td>
            <td style="text-align:right;">' . format_inr($val['net_pay']) . '</td>
        </tr>';

        $tsoc[] = $val['bill_amount'];
        $tsoc1[] = $val['tds_amount'];
        $tsoc2[] = $val['other_paid'];
        $tsoc3[] = $val['arrs_tds'];
        $tsoc4[] = $val['net_pay'];
        $i++;
    }

    echo '<tr>
        <td colspan="2" style="text-align:right;"><b>TOTAL AMOUNT IN RS. :-</b></td>
        <td style="text-align:right;">' . format_inr(array_sum($tsoc)) . '</td>
        <td style="text-align:right;">' . format_inr(array_sum($tsoc1)) . '</td>
        <td style="text-align:right;">' . format_inr(array_sum($tsoc2)) . '</td>
        <td style="text-align:right;">' . format_inr(array_sum($tsoc3)) . '</td>
        <td style="text-align:right;">' . format_inr(array_sum($tsoc4)) . '</td>
    </tr>
    </tbody>
    </table><br><br>';
}

// Render both tables
renderTable($bank1, 'Yourself for NEFT/RTGS Remu. Transfer');
renderTable($bankOthers, 'Yourself for Remuneration Transfer');


// Combine both arrays
$combined = array_merge($bank1, $bankOthers);

// Initialize totals
$grand_bill = $grand_tds = $grand_other_paid = $grand_arrs_tds = $grand_net = 0;

foreach ($combined as $val) {
    $grand_bill       += $val['bill_amount'];
    $grand_tds        += $val['tds_amount'];
    $grand_other_paid += $val['other_paid'];
    $grand_arrs_tds   += ($val['arrs_tds'] ?? 0);
    $grand_net        += $val['net_pay'];
}
?>

<!-- GRAND TOTAL TABLE -->
<!-- GRAND TOTAL ROW ALIGNED -->
<!-- GRAND TOTAL ROW WITHOUT Sr.No. and Name -->
<table border="1" style="page-break-inside: avoid; width:50%; margin-left:50px;" cellpadding="3" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th style="border: 1px solid black; width:20%;"><b>Bill Amt</b></th>
            <th style="border: 1px solid black; width:20%;"><b>TDS</b></th>
            <th style="border: 1px solid black; width:20%;"><b>Arrears /<br> Office Advance</b></th>
            <th style="border: 1px solid black; width:20%;"><b>TDS on Arrears /<br> Office Advance</b></th>
            <th style="border: 1px solid black; width:20%;"><b>Net Amount</b></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align:right; font-weight:bold;"><?php echo format_inr($grand_bill); ?></td>
            <td style="text-align:right; font-weight:bold;"><?php echo format_inr($grand_tds); ?></td>
            <td style="text-align:right; font-weight:bold;"><?php echo format_inr($grand_other_paid); ?></td>
            <td style="text-align:right; font-weight:bold;"><?php echo format_inr($grand_arrs_tds); ?></td>
            <td style="text-align:right; font-weight:bold;"><?php echo format_inr($grand_net); ?></td>
        </tr>
		<tr>
    <td colspan="7" style="text-align:right; font-weight:bold; font-style: italic;">
        (<?php echo ucwords(numberToWords(round($grand_net))) . ' Only'; ?>)
    </td>
</tr>
    </tbody>
</table>


<br><br>



	  </div>
			    <br>
	  <br>
	  <br>
	  <br>
	  <br>

	
	<div style="width: 95%; margin-left: 50px; margin-top: 10px; font-size: 12px; font-weight: bold; page-break-inside: avoid;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 25%; text-align: center;">PREPARED BY</td>
            <td style="width: 25%; text-align: center;">CHECKED BY</td>
            <td style="width: 25%; text-align: center;">VERIFIED BY</td>
            <td style="width: 25%; text-align: center;">APPROVED BY</td>
        </tr>
        <tr><td colspan="4" style="height: 60px;"></td></tr> <!-- space for signature -->
        <tr>
            <td style="text-align: center;">Nsk Accountant</td>
            <td style="text-align: center;">Nsk Accountant</td>
            <td style="text-align: center;">HO Accountant</td>
            <td style="text-align: center;">Registrar/Principal</td>
        </tr>
    </table>
</div>

</div>
</body>
</html>
