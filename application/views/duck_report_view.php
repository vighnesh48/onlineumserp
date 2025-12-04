<!DOCTYPE html>
<html>

<head>
    <title>Attendance Not Marked Cum Duck Report</title>
    <style>
        body {
            font-family: "Bookman Old Style", serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .a th, td {
            border-bottom: 1px solid black;
            border-bottom-color: #b2b3b5;
            border-left: 1px solid #b2b3b5;
            padding: 2px;
            text-align: center;
            font-size: 10px;
        }

        .a th {
            background-color: #f2f2f2;
        }

        h2, p {
            text-align: center;
        }

        /* Faculty summary row */
        .faculty-row td {
            border: 1px solid #adddff;
            background-color: #adddff; 
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }

        /* Add space after each faculty */
        .faculty-space {
            height: 20px;
        }
    </style>
</head>

<body>
    <table>
        <thead>

        </thead>
        <tbody>
            <?php 
			
			
			
			if (!empty($report_data)): ?>
                <?php
                $sr_no = 1;
                foreach ($report_data as $row):
				if($row['today_ducks']!=0){
                ?>
                    <!-- Faculty Summary Row -->
                    <tr class="faculty-row">
                        <td colspan="5"><strong>Faculty: </strong><?= $row['faculty_code']; ?>-<?= $row['faculty']; ?></td>
                        <td><strong>Today:</strong> <?= ($row['today_ducks'] == 0) ? '0' : $row['today_ducks']; ?></td>
                        <td><strong>Cumm:</strong> <?= $row['cumulative_ducks']; ?></td>
                        <?php 
                            $lwp = $row['cumulative_ducks'] / 3;

                            // Extract decimal part
                            $decimal = $lwp - floor($lwp);

                            if ($decimal >= 0.5) {
                                // Round to nearest .5 (e.g., 1.5, 2.5)
                                $lwp = floor($lwp) + 0.5;
                            } else {
                                // Round down (e.g., 1, 2, 3)
                                $lwp = floor($lwp);
                            }
                        ?>

                        <td style="border-right-color: #b2b3b5;"><strong>LWP:</strong> <?=$lwp?></td>
                    </tr>
                    <tr class="a">
                        <th rowspan="2">SR No.</th>
                        <th rowspan="2">School - Stream</th>
                        <th rowspan="2">Sem</th>
                        <th rowspan="2">Div</th>
                        <th rowspan="2">Subject</th>
                        <th rowspan="2">Type</th>
                        <th rowspan="2">Slot</th>
                        <th colspan="2">No. of Duck</th>
                    </tr>
                    <tr class="a">
                        <th style="border-right: 1px solid #b2b3b5;">Today</th>
                        <!-- <th style="border-right: 1px solid #b2b3b5;">Cumm</th> -->
                    </tr> 
                    <!-- Faculty Lecture Details -->
                    <?php foreach ($row['details'] as $lecture): 
					if($lecture['today'] != 0){ ?>
                        <tr class="a">
                            <td><?= $sr_no++; ?></td>
                            <td><?= $lecture['school_stream']; ?></td>
                            <td><?= $lecture['semester']; ?></td>
                            <td><?= $lecture['division'] . '-' . $lecture['batch']; ?></td>
                            <td><?= $lecture['subcod'].'-'.$lecture['subject']; ?></td>
                            <td><?= $lecture['subtype']; ?></td>
                            <td><?= $lecture['slot']; ?></td>
                            <td style="width:15%;border-right: 1px solid #b2b3b5;">
                                <?php 
                                    if ($lecture['today'] != 0) { 
                                        echo '<img src="' . site_url() . 'assets/images/duck1.png" width="30px" height="30px" />';
                                    } else { 
                                        echo $lecture['today']; 
                                    }
                                ?>
                            </td>
                            <!-- <td style="width:15%;border-right: 1px solid #b2b3b5;"></td> -->
                        </tr>
                    <?php } endforeach; ?>

                    <!-- Space after each faculty -->
                    <tr class="faculty-space">
                        <td colspan="9"></td>
                    </tr>
                <?php } endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No faculty with missing attendance.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
