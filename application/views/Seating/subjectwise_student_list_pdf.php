<style>
    .body {
        font-family: "Bookman Old Style";
        font-size: 11px;
    }

    .header {
        text-align: center;

    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        border: 1px solid #000;
        padding: 2px;
        text-align: center;
        font-size: 11px;
    }

    td {
        border: 1px solid #000;
        padding: 5px;
        text-align: center;
        font-size: 10px;
    }

    th {
        background-color: #f2f2f2;
    }

    .branch-info {
        font-weight: bold;
        text-align: left;
        padding: 5px;
        font-size: 11px;
    }

    .page-break {
        page-break-before: always;
    }
</style>
<div class="body">
    <?php foreach ($arrangements as $hallData): ?>
        <div class="hall-header">
            <table>
                <tr>
                     <td style="text-align: left; border:none; font-size:12px;font-weight: bold;">
                        Date & Session : <?= date('d-m-Y', strtotime($exam_date)) ?> &
						<?= $session === 'FN' ? 'Forenoon (09:30 AM - 12:30 PM)' : 'Afternoon (2:00 PM - 5:00 PM)' ?>
                    </td>
                    <td style="text-align: left; border:none; font-size:11px;font-weight: bold;">
                        Hall: <?= $hallData['hall'] ?> | Floor: <?= $hallData['floor'] ?>
                    </td>
                </tr>
            </table>
        </div>
        <table style="border-collapse: collapse; width: 100%; font-size: 10px; border: 0.5px solid #000;">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Reg. No.</th>
                    <th>Name of Student</th>
                    <th colspan="8">Answer Book No.</th>
                    <th>* Write AB for Absent</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hallData['seating_arrangement'] as $subject): ?>
                    <tr>
                        <td colspan="13" class="branch-info">
                            Branch(s): <?= $subject['stream_name'] ?> |
                            Course Code and Name: <?= $subject['subject_code'] ?> - <?= $subject['subject_name'] ?> | Sem: <?= $subject['semester'] ?>
                        </td>
                    </tr>
                    <?php
                    $srNo = 1;
                    foreach ($subject['students'] as $enrollment => $studentName): ?>
                        <tr>
                            <td style="font-size:10px; padding: 2px; line-height: 1;"><?= $srNo++ ?></td>
                            <td style="font-size:10px; padding: 2px; line-height: 1;"><?= $enrollment ?></td>
                            <td style="font-size:10px; padding: 2px; line-height: 1;text-align:left;"><?= $studentName ?></td>
                            <td style="font-size:10px; padding: 2px; line-height: 1;"></td>
                            <td style="font-size:10px; padding: 2px; line-height: 1;"></td>
                            <td style="font-size:10px; padding: 2px; line-height: 1;"></td>
                            <td style="font-size:10px; padding: 2px; line-height: 1;"></td>
                            <td style="font-size:10px; padding: 2px; line-height: 1;"></td>
                            <td style="font-size:10px; padding: 2px; line-height: 1;"></td>
                            <td style="font-size:10px; padding: 2px; line-height: 1;"></td>
                            <td style="font-size:10px; padding: 2px; line-height: 1;"></td>
                            <td style="font-size:10px; padding: 2px; line-height: 1;width:100px;"></td>
                            <td style="font-size:10px; padding: 2px; line-height: 1;width:70px;"></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>

            </tbody>

        </table>
        
        <?php
        $totalSubjects = count($hallData['seating_arrangement']); // Total rows for this hall
        $isFirstRow = true; // Track the first row for rowspan
        ?>
        <table style="margin-top:20px;">
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
						// Skip row if course, prn, or program is empty or N/A
						if (
							empty($seat['max_enrollment']) || strtolower($seat['max_enrollment']) === 'n/a' &&
							empty($seat['subject_name']) || strtolower($seat['subject_name']) === 'n/a'
						) {
							$seat['count_subject_id'] = 0;
						}
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

</div>