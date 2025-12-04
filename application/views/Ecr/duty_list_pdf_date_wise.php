<?php 
    // Group duty_list by date and session combined
    $dateSessionMap = [];
    foreach ($duty_list as $item) {
        $dateSessionKey = $item['date'] . ' - ' . $item['session'];
        if (!isset($dateSessionMap[$dateSessionKey])) {
            $dateSessionMap[$dateSessionKey] = [];
        }
        $dateSessionMap[$dateSessionKey][] = $item;
    }

    // Sort dateSessionMap by date (convert keys to a sortable format)
    uksort($dateSessionMap, function($a, $b) {
        // Extract the date part from the key and compare
        return strtotime(explode(' - ', $a)[0]) - strtotime(explode(' - ', $b)[0]);
    });
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invigilation Duty List</title>
    <style>
        * {
            margin-top: 5px;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            padding: 10px;
        }
        .header-td {
            border: none;
        }
        .main_table, td, th {
            border: 1px solid #000;
            border-collapse: collapse;
            padding: 7px;
            font-size: 12px;
            line-height: 12px;
            font-family: sans-serif;
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
            <td class="header-td" style="font-weight:normal;text-align:center;" >
                <p style="font-size: 14px; font-color: grey; font-weight: bold"><?= $duty_list[0]['exam_name'] ?> - <?= strtoupper(htmlspecialchars($title)) ?></p>
            </td>
        </tr>
    </table>
</div>

<table width="100%" style="text-align: center;" class="main_table">
        <thead>
            <tr>
                <th>S.No</th>
                <th width="30%">Date & Session</th>
                <th colspan="3">Faculty details</th>
                
            </tr>
        </thead>
        <tbody>
            <?php 
            $rowIndex = 1; // Counter for numbering rows
            foreach ($dateSessionMap as $dateSession => $entries) {
                $rowCount = count($entries); // Number of rows for this date-session combination
                echo '
                    <tr>
                        <td rowspan="' . $rowCount . '">' . $rowIndex . '.</td>
                        <td rowspan="' . $rowCount . '">' . htmlspecialchars($dateSession) . '</td>
                        <td>1</td>
                        <td style="text-align: left" >' . strtoupper(htmlspecialchars($entries[0]['name'])) . '</td>
                        <td>' . htmlspecialchars($entries[0]['mobile']) . '</td>
                        
                    </tr>
                ';
                
                // Additional rows for remaining faculty under the same date-session
                for ($i = 1; $i < $rowCount; $i++) {
                    echo '
                        <tr>
                            <td>' . ($i+1) . '</td>
                            <td style="text-align: left" >' . strtoupper(htmlspecialchars($entries[$i]['name'])) . '</td>
                            <td>' . htmlspecialchars($entries[$i]['mobile']) . '</td>
                        </tr>
                    ';
                }
                $rowIndex++;
            }
            ?>
        </tbody>
    </table>
</body>
</html>



