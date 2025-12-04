<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invigilation Duty List</title>
    <style>
        body {
            font-family: "bookman-old-style", serif;
        }

        .header-td {
            border: none;
        }

        .main_table,
        td,
        th {
            border: 1px solid #000;
            border-collapse: collapse;
            padding: 7px;
            font-size: 12px;
            line-height: 12px;
            font-family: "bookman-old-style", serif;
            margin-bottom: 10px;
        }

        .main_table {
            padding: 0;
        }
    </style>
</head>

<body>
    <div id="header">
        <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-bottom:5px;">
            <tr>
                <td class="header-td" style="font-weight:normal;text-align:center;">
                    <p style="font-size: 14px; color: grey; font-weight: bold">
                        <?= htmlspecialchars($duty_list[0]['exam_name']) ?> -
                        <?= strtoupper(htmlspecialchars($title)) ?> (<?= $center ?>)
</p>
                </td>
            </tr>
        </table>
    </div>
    <div id="header">
        <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-bottom:5px;">
            <tr>
                <td class="header-td" style="text-align:left;">
                    <p> <strong>Date:</strong><span style="font-size: 12px"> <?= htmlspecialchars($current_date) ?>
                        </span> </p>
                </td>
                <td class="header-td" style="text-align:right;">
                    <p> <strong>Session:</strong><span style="font-size: 12px">
                            <?= htmlspecialchars($current_session) ?> </span> </p>
                </td>

            </tr>
        </table>
    </div>
    <table width="100%" style="text-align: center;" class="main_table">
        <thead>
            <tr>
                <th>S.No</th>
                <th width="30%">Faculty Name</th>
                <th>Alternative Faculty</th>
                <!-- th>Date & Session</th -->
                <th>Allocated Hall</th>
                <th>Signature</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($duty_list)) {
                $facultyMap = []; // Group data by faculty name
				// print_r($duty_list);exit;
                // Group data by faculty name and duty details
                foreach ($duty_list as $item) {
					// print_r($item['name']);exit;
                    if (!isset($facultyMap[$item['NAME']])) {
                        $facultyMap[$item['NAME']] = [
                            'role_name' => $item['role_name'],
                            'dates' => [],
                            'designation_name' => $item['designation_name'],
                            'college_code' => $item['college_code'],
                            'emp_id' => $item['emp_id']
                        ];
						
                    }
                    $facultyMap[$item['NAME']]['dates'][] = [
                        'replace_emp_name' => $item['replace_emp_name'],
                        'date' => $item['date'],
                        'session' => $item['session'],
                        'building_name' => $item['building_name'],
                        'floor' => $item['floor'],
                        'hall_no' => $item['hall_no'],
                        'replace_emp_id' => $item['replace_emp_id'],
                    ];
                }

                $rowIndex = 1;  // Counter for numbering rows
            
                // Generate HTML with rowspan for each faculty group
                foreach ($facultyMap as $faculty_name => $details) {
                    $dateCount = count($details['dates']);
					// print_r($duty_list);exit;
                    echo '
                    <tr>
                        <td rowspan="' . $dateCount . '">' . $rowIndex . '</td>
                        <td rowspan="' . $dateCount . '">
                            <p>' . $details['emp_id'].' -'. strtoupper(htmlspecialchars($faculty_name)) . '</p>
                            <br>
                            <span>' . htmlspecialchars($details['designation_name']) . '-' . htmlspecialchars($details['college_code']) . '</span>
                        </td>
                        <td>' .$details['dates'][0]['replace_emp_id'].' -'. htmlspecialchars($details['dates'][0]['replace_emp_name']) . '</td>
                        <!-- td>' . htmlspecialchars($details['dates'][0]['date']) . ' (' . htmlspecialchars($details['dates'][0]['session']) . ')</td -->
                        <td>' . htmlspecialchars($details['dates'][0]['building_name']) . ' (' . htmlspecialchars($details['dates'][0]['floor']) . '-' . htmlspecialchars($details['dates'][0]['hall_no']) . ')</td>
                        <td rowspan="' . $dateCount . '"></td>
                    </tr>
                ';

                    // Insert additional rows for remaining dates
                    for ($i = 1; $i < $dateCount; $i++) {
                        echo '
                        <tr>
                            <td>' . htmlspecialchars($details['dates'][$i]['replace_emp_name']) . '</td>
                            <td>' . htmlspecialchars($details['dates'][$i]['date']) . ' (' . htmlspecialchars($details['dates'][$i]['session']) . ')</td>
                            <td>' . htmlspecialchars($details['dates'][$i]['building_name']) . ' (' . htmlspecialchars($details['dates'][$i]['floor']) . '-' . htmlspecialchars($details['dates'][$i]['hall_no']) . ')</td>
                        </tr>
                    ';
                    }

                    $rowIndex++;  // Increment row index for each faculty group
                }
            } else {
                echo '<tr><td colspan="5" class="text-center">No records found</td></tr>';
            }
            ?>

        </tbody>
    </table>
</body>

</html>
<?php // exit; ?>