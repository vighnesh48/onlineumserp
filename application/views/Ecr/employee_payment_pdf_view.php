<!-- File: application/views/employee_payment_pdf_view.php -->

<!DOCTYPE html>
<html>

<head>
    <style>
        .body {
            font-family: "Bookman Old Style", serif;
                
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid #000;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
<?php
    // Function to convert numbers to words
    function convert_number_to_words($number) {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
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
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    // Convert total payment to words
 
    ?>


        <h4 style="text-align: center;font-size: 12px;">ACQUITTANCE FOR <?= $role ?> - <?= $exam_session ?> (<?= $center ?>)</h4>

    <?php if ($role_id == 1) { ?>
        <table class="table" style="font-size: 12px;">
            <thead class="bgdynamic">
                <tr>
                    <th>Sr.No.</th>
                    <th>Date</th>
                    <th>No. of session</th>
                    <th>Employee Name</th>
                    <th>Remuneration</th>
                    <th>Total Amount (in Rs.)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_payment = 0;
                $i = 1;
                if (!empty($employee_payments)) {
                    foreach ($employee_payments as $employee) {
                        $total_payment += $employee['payment'];
                        $Extra_ssn = $employee['additional_ssn_count'] * $employee['renum'];
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $employee['date'] ?></td>
                            <td><?= $employee['session'] ?></td>
                            <td><?= $employee['name'] ?></td>
                            <td><?= $employee['renum'] ?></td>
                            <td><?= $employee['payment'] ?></td>
                        </tr>
                        <?php
                        }
                    } else { ?>
                    <tr>
                        <td colspan="6">No records found</td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <!-- tr>
                    <td colspan="5" style="text-align: left;"><strong>Extra Session Payment:</strong></td>
                    <td><?php // $Extra_ssn ?></td>
                </tr -->
                <tr>
                    <td colspan="5" style="text-align: left;"><strong>Grand Total:</strong></td>
                    <td><strong><?= $total_payment = $total_payment ?></strong></td>
                </tr>
                <tr>
                    <?php  $total_payment_in_words = convert_number_to_words($total_payment); ?>
                    <td colspan="6" style="text-align: left;"><strong>Grand Total(in words):</strong><?= ucfirst($total_payment_in_words) ?></td>
                </tr>
            </tfoot>
        </table>
        <table width="100%" style="margin-top: 70px;">
            <tr>
                <td style="text-align: left;font-size:12px;">
                <b>Received a sum of Rs.<?= $total_payment ?>/- </b>(<?= ucfirst($total_payment_in_words) ?> Only).
                </td>
                <td style="text-align: right;font-size: 13px;">
                <b>Signature of Chief Superintendent with date</b>
            </td>
            </tr>
        </table>
        <table width="100%" style="margin-top: 50px;">
            <tr>
                <!-- td style="text-align: left;font-size: 13px;">
                    <b>Place:</b><br>
                    <b>Date:<?= date('Y-m-d'); ?></b>
                </td -->
                <td style="text-align: right; font-size:12px;">
                (Affix one rupee revenue stamp if claim exceeds Rs.5000/-)
                </td>
            </tr>
        </table>
    <?php } else { ?>
        <div>
        <table width="100%" style="margin-bottom:5px;font-size: 13px;">
            <tr>
                <td style="text-align:left;">
                    <p> <strong>Date:</strong> <?= htmlspecialchars($date) ?> </p>
                </td>
                <td style="text-align:right;">
                    <p> <strong>Session:</strong> <?= htmlspecialchars($session) ?> </p>
                </td>
            </tr>
        </table>
    </div>
        <table class="table" style="font-size: 12px;">
            <thead class="bgdynamic">
                <tr>
                    <th>Sr.No.</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <!-- <th>Date & Session</th> -->
                    <th>Remuneration</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_payment = 0;
                $i = 1;
                if (!empty($employee_payments)) {
                    foreach ($employee_payments as $employee) {
                        $total_payment += $employee['payment'];
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $employee['emp_id'] ?></td>
                            <td><?= $employee['name'] ?></td>
                            <!-- <td><?= $employee['date'].' ('.$employee['session'].')' ?></td> -->
                            <td><?= $employee['payment'] ?></td>
                            <td></td>
                        </tr>
                        <?php
                    }
                } else { ?>
                    <tr>
                        <td colspan="5">No records found</td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;font-size: 12px;"><strong>Total Remuneration:</strong></td>
                    <td style="font-size: 12px;"><strong><?= $total_payment ?></strong></td>
                </tr>
            </tfoot>
			</table>
					<table width="100%" style="margin-top: 70px;">
				<tr>
					<td style="text-align: left;font-size:12px;">
					<b>Received a sum of Rs.<?= $total_payment ?>/- </b>(<?= ucfirst($total_payment_in_words) ?> Only).
					</td>
					<td style="text-align: right;font-size: 13px;">
					<b>Signature of Chief Superintendent with date</b>
				</td>
				</tr>
			</table>
			<table width="100%" style="margin-top: 50px;">
				<tr>
					<!-- td style="text-align: left;font-size: 13px;">
						<b>Place:</b><br>
						<b>Date:<?= date('Y-m-d'); ?></b>
					</td -->
					<td style="text-align: right; font-size:12px;">
					(Affix one rupee revenue stamp if claim exceeds Rs.5000/-)
					</td>
				</tr>
			</table>
    <?php } ?>
</body>

</html>