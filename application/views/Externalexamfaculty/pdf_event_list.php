<style>
    body {
        font-family: 'bookman', 'Bookman Old Style', serif;
        font-size: 16px;
    }

    .header-title {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .sub-header {
        text-align: center;
        font-size: 13px;
        margin-bottom: 20px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 11px;
    }

    th {
        background-color: #f2f2f2;
        text-align: center;
    }

    th,
    td {
        border: 1px solid #666;
        padding: 6px;
    }
</style>


<table style="width: 100%; border: none; font-size: 12px;">
    <tr>
        <td style="width: 20%; text-align: center; border: none;">
            <img src="<?= base_url('assets/images/su-logo.png') ?>" style="width: 80px; height: auto;">
        </td>
        <td style="width: 60%; text-align: center; border: none;">
            <div style="font-size: 20px; font-weight: bold; color: red;">Sandip University</div>
            <div>Mahiravani, Trimbak Road, Nashik - 422 213</div>
            <div style="font-size: 14px; font-weight: bold;">External Faculty Payment Details Report</div>
            <div style="font-weight: bold; font-size: 14px;">
                <?php
                if (!empty($month_year)) {
                    $monthYearObject = DateTime::createFromFormat('m-Y', $month_year);
                    $formattedMonthYear = $monthYearObject ? $monthYearObject->format('F Y') : $month_year;
                } else {
                    $formattedMonthYear = 'All';
                }

                $eventTypeName = !empty($event_type_name) ? $event_type_name : 'All';
                ?>
                <div style="font-weight: bold; font-size: 14px;">
                    Event Type: <?= $eventTypeName ?> | Month-Year: <?= $formattedMonthYear ?>
                </div>
            </div>
        </td>
        <td style="width: 20%; text-align: center; border: none;">
        </td>
    </tr>
</table>
<hr>

<table>
    <thead>
        <tr>
            <th>#</th>
			<th>DateTime</th>
            <th>Faculty Name</th>
            <th>Event Type</th>
            <th>TA Amount</th>
            <th>Honorarium</th>
            <th>Total</th>
            
            <!--th>Month-Year</th>
            <th>Description</th-->
        </tr>
    </thead>
    <?php
    $totalTA = 0;
    $totalHonorarium = 0;
    $totalAmount = 0;
    $i = 1;
    ?>

    <tbody>
        <?php foreach ($event_list as $row): ?>
            <?php
            $totalTA += $row['ta_amount'];
            $totalHonorarium += $row['honorarium_amount'];
            $totalAmount += $row['total_amount'];
            ?>
            <tr>
                <td style="text-align:center;"><?= $i++ ?></td>
				<td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                <td><?= $row['ext_fac_name'] ?></td>
                <td><?= $row['event_type'] ?></td>
                <td style="text-align:right;"><?= number_format($row['ta_amount'], 2) ?></td>
                <td style="text-align:right;"><?= number_format($row['honorarium_amount'], 2) ?></td>
                <td style="text-align:right;"><?= number_format($row['total_amount'], 2) ?></td>
                
                <!--td style="text-align:center;">
                    <?php
                    if (!empty($row['month_year'])) {
                        $dt = DateTime::createFromFormat('m-Y', $row['month_year']);
                        echo $dt ? $dt->format('F Y') : $row['month_year'];
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td><?= $row['description'] ?></td-->
            </tr>
        <?php endforeach; ?>
    </tbody>

    <tfoot>
        <tr>
            <th colspan="4" style="text-align:right;">Total:</th>
            <th style="text-align:right;"><?= number_format($totalTA, 2) ?></th>
            <th style="text-align:right;"><?= number_format($totalHonorarium, 2) ?></th>
            <th style="text-align:right;"><?= number_format($totalAmount, 2) ?></th>
            
        </tr>
    </tfoot>

</table>