<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        h1,
        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <?php if (!empty($arrangements)): ?>
        <?php foreach ($arrangements as $hallData):
            $totalSubjects = count($hallData['seating_arrangement']); // Total rows for this hall
            $isFirstRow = true; // Track the first row for rowspan
            ?>
            <table>
                <thead>
                    <tr>
                    <th>SR NO.</th>
                    <th>NAME OF THE PROGRAMME</th>
                    <th>COURSE</th>
                    <th>COURSE-CODE</th>
                    <th>COUNT</th>
                    <th>Total</th>
                    <th>PRN</th>
                    <th>Room No</th>
                    <th>No. Of Present</th>
                    <th>No. Of Absent</th>
                    <th>Packet No.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $srNo = 1;
                    foreach ($hallData['seating_arrangement'] as $seat):

                        $grandTotalStudents += $seat['count_subject_id'];
                        ?>
                        <tr>
                            <?php // if ($isFirstRow): ?>
                                <td><?= $srNo++ ?></td>
                            <?php // endif; ?>
                            <td><?= $seat['stream_name'] ?></td>
                            <td><?= $seat['subject_name'] ?></td>
                            <td><?= $seat['subject_code'] ?></td>
                            <td><?= $seat['count_subject_id'] ?></td>
                            <?php if ($isFirstRow): ?>
                                <td rowspan="<?= $totalSubjects ?>"><?= $hallData['total_students'] ?></td>
                            <?php endif; ?>
                            <td style="width:200px;"><?= $seat['min_enrollment'] ?> - <?= $seat['max_enrollment'] ?></td>
                            <?php if ($isFirstRow): ?>
                                <td rowspan="<?= $totalSubjects ?>"><?= $hallData['floor'] ?>-<?= $hallData['hall'] ?></td>
                                <?php $isFirstRow = false; ?>
                            <?php endif; ?>
                            <td></td>
                            <td></td>
                            <td></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


            <div class="page-break"></div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No data available for the selected criteria.</p>
    <?php endif; ?>
</body>

</html>