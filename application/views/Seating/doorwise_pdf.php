<style>
    .body {
        font-family: "Bookman Old Style";
        font-size: 14px;
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
        font-size: 12px;
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
        font-size: 12px;
    }

    .seat-arrangement {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0px;
    }

    .seat-row {
        width: 100%;
        border-collapse: separate; /* Separate cells for spacing */
        border-spacing: 5px; /* Add space between cells */
    }

    .seat-box {
        border: 1px solid #000;
        text-align: center;
        font-size: 10px;
        width: 50px;
        height: 25px;
        box-sizing: border-box;
        background-color: #f9f9f9; /* Optional for better contrast */
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
                    <td style="text-align: left; border:none; font-size:12px;font-weight: bold;">
                        Hall: <?= $hallData['hall'] ?> | Floor: <?= $hallData['floor'] ?>
                    </td>
                </tr>
            </table>
        </div>
        <table>
            <thead>
                <tr>
                    <th> SR NO. </th>
                    <th> NAME OF THE PROGRAMME </th>
                    <th> COURSE </th>
                    <th> COURSE-CODE </th>
                    <th> COUNT </th>
                    <th> PRN </th>
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
                        <td><?= $seat['stream_name'] ?> </td>
                        <td><?= $seat['subject_name'] ?> </td>
                        <td><?= $seat['subject_code'] ?> </td>
                        <td><?= $seat['count_subject_id'] ?> </td>
                        <td style="width:200px;"><?= $seat['min_enrollment'] ?> - <?= $seat['max_enrollment'] ?></td>
                    </tr> 
                <?php endforeach; ?>
            </tbody>
        </table>
        <hr>
        <div class="seat-arrangement">
            <table class="seat-row">
                <tr>
                <?php 
                    $rowCount = 0; 
                    $columnLimit = $hallData['rows']; // Number of boxes per row
                    foreach ($hallData['json_arrangement'] as $seat): ?>
                        <td class="seat-box">
                        <?php
                            $subjectId = $seat['subject_id'] ?? '';
                            $streamId = $seat['stream_id'] ?? '';
                            $compositeKey = $subjectId . '~' . $streamId;

                            $subjectMeta = $hallData['seating_arrangement']; // contains subject details

                          //  print_r($subjectMeta);exit;
                            $streamSemLabel = '';
                            foreach ($subjectMeta as $subRow) {
                                $rowKey = $subRow['subject_id'];
                                
                                if ($rowKey === $compositeKey) {
                                   // print_r($compositeKey);exit;
                                    $streamShort = $subRow['stream_short_name'] ?? '';
                                    $sem = $subRow['semester'] ?? '';
                                    $streamSemLabel = $streamShort . '_Sem ' . $sem;
                                    break;
                                }
                            }
                        ?>
                        <div style="font-size:12px;"><b><?= $seat['seat_no'] ?>.</b> <?= $seat['enrollment_no'] ?></div>
                        <hr>
                        <div style="font-size:10px;"><?= $streamSemLabel ?></div>
                        </td>

                        <?php
                        $rowCount++;
                        if ($rowCount % $columnLimit == 0): ?>
                            </tr><tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </table>
        </div>
    <?php //  echo '<pre>';
        // print_r($hallData['rows']);
        //  exit; ?>
    <div class="page-break"></div>
<?php endforeach; ?>

</div>
<?php // exit; ?>