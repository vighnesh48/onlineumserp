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
        .table, .table th, .table td {
            border: 1px solid #000;
        }
        .table th, .table td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php
// --- Helper: Convert number to Indian currency words (Rupees / Paise) ---
if (!function_exists('amountToIndianCurrencyWords')) {
    function amountToIndianCurrencyWords($number) {
        $number = (float)$number;
        $no    = floor($number);
        $point = (int)round(($number - $no) * 100);

        $words = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
            6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen',
            15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
            20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
            60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        ];
        $digits = ['', 'Thousand', 'Lakh', 'Crore'];

        if ($no === 0) {
            $result = 'Zero';
        } else {
            $str = [];
            $i = 0;
            while ($no > 0) {
                $divider = ($i == 0) ? 1000 : 100; // first group can be up to 3 digits, then 2-digit groups (Indian format)
                $chunk = $no % $divider;
                $no = (int)floor($no / $divider);

                if ($chunk) {
                    $t = '';
                    // hundreds
                    if ($chunk > 99) {
                        $t .= $words[(int)($chunk / 100)] . ' Hundred ';
                        $chunk = $chunk % 100;
                    }
                    // tens & ones
                    if ($chunk > 0) {
                        if ($chunk < 20) {
                            $t .= $words[$chunk] . ' ';
                        } else {
                            $t .= $words[(int)($chunk / 10) * 10] . ' ' . $words[$chunk % 10] . ' ';
                        }
                    }
                    // unit
                    if ($i > 0 && isset($digits[$i])) {
                        $t .= $digits[$i] . ' ';
                    }
                    array_unshift($str, trim($t));
                }
                $i++;
            }
            $result = trim(implode(' ', $str));
        }

        // Paise
        if ($point > 0) {
            $p = '';
            if ($point < 20) {
                $p = $words[$point];
            } else {
                $p = $words[(int)($point / 10) * 10] . ' ' . $words[$point % 10];
            }
            return 'Rupees ' . $result . ' and ' . trim($p) . ' Paise Only';
        }

        return 'Rupees ' . $result . ' Only';
    }
}
?>

<h4 style="text-align: center;font-size: 13px;">
    Role-Wise Payment Report - <?= htmlspecialchars($exam_session) ?> (<?= htmlspecialchars($center) ?>)
</h4>

<table class="table" style="font-size: 12px;">
    <thead>
        <tr>
            <th>Role</th>
            <th>Total Payment (in Rs.)</th>
            <th>Remark</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $grand_total_payment = 0;
        if (!empty($role_payments)) {
            foreach ($role_payments as $role) {
                $grand_total_payment += (float)$role['total_payment'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($role['role']) ?></td>
                    <td><?= htmlspecialchars($role['total_payment']) ?></td>
                    <td></td>
                </tr>
                <?php
            }
        } else { ?>
            <tr>
                <td colspan="3">No records found</td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: left;font-size: 12px;"><strong>Grand Total:</strong></td>
            <td style="font-size: 12px;"><strong><?= $grand_total_payment ?></strong></td>
            <td></td>
        </tr>
    </tfoot>
</table>

<?php
// Grand total in words (no extra styling)
$grand_total_in_words = amountToIndianCurrencyWords($grand_total_payment);
echo 'Grand Total (in words): ' . htmlspecialchars($grand_total_in_words);
?>

<!-- 50px space, then bold signature text -->
<div style="margin-top:50px; text-align:right; font-weight:bold;">Signature Of Chief Superintendent</div>

</body>
</html>
