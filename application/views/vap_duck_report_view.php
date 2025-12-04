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

        .a th,
        td {
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

        h2,
        p {
            text-align: center;
        }

        /* Faculty summary row */
        .faculty-row td {
            border: 1px solid #adddff;
            background-color: #99d5ff;
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }

        /* Add space after each faculty */
        .faculty-space {
            height: 40px;
        }
    </style>
</head>

<body>
    <table>
        <thead>

        </thead>
        <tbody>
            <?php if (!empty($report_data)): ?>
                <?php
                $sr_no = 1;
                $displayedSlots = []; // Track unique (slot, division) pairs
                $grouped_data = [];

                // **Step 1: Group data by subcod, then faculty**
                foreach ($report_data as $row) {
                    foreach ($row['details'] as $lecture) {
                        $subcod = $lecture['subcod'];
                        $faculty_code = $row['faculty_code'];

                        // Ensure every faculty appears under each subcod they teach
                        if (!isset($grouped_data[$subcod])) {
                            $grouped_data[$subcod] = [];
                        }
                        if (!isset($grouped_data[$subcod][$faculty_code])) {
                            $grouped_data[$subcod][$faculty_code] = [
                                'faculty' => $row, // Store faculty details
                                'details' => [] // Store lectures
                            ];
                        }
                        $grouped_data[$subcod][$faculty_code]['details'][] = $lecture;
                    }
                }

                // **Step 2: Display grouped data**
                foreach ($grouped_data as $subcod => $faculty_data): ?>
                    <!-- Row for subcod -->
                    <!-- Space after each faculty -->
                    <tr class="faculty-space">
                        
                    </tr>
                    <tr class="faculty-row">
                        <td colspan="13" style="text-align: center; font-weight: bold; background-color: #ffc5b3;">
                            Subject Code: <?= $subcod; ?>
                        </td>
                    </tr>

                    <?php foreach ($faculty_data as $faculty_code => $faculty_info): ?>
                        <!-- Row for faculty -->
                        <tr class="faculty-row">
                            <td colspan="5"><strong>Faculty:
                                </strong><?= $faculty_info['faculty']['faculty_code'] . '-' . $faculty_info['faculty']['faculty']; ?>
                            </td>
                            <td colspan="2"><strong>Today's TH: </strong> <?= $faculty_info['faculty']['total_lectures_TH'] ?>
                                <strong>PR: </strong><?= $faculty_info['faculty']['total_lectures_PR'] ?></td>
                            <td colspan="2"><strong>Lec. Taken: </strong> <?= $faculty_info['faculty']['Taken_lectures_TH'] ?>
                                <strong>PR: </strong><?= $faculty_info['faculty']['Taken_lectures_PR'] ?></td>
                            <td colspan="2"><strong>Today's Ducks
                                    <?php echo '<img src="' . site_url() . 'assets/images/duck1.png" width="15px" height="15px"/>'; ?>
                                    :</strong>
                                <?= ($faculty_info['faculty']['today_ducks'] == 0) ? '0' : $faculty_info['faculty']['today_ducks']; ?>
                            </td>
                            <?php
                            $lwp = $faculty_info['faculty']['cumulative_ducks'] / 3;

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

                            <td colspan="2" style="border-right-color: #b2b3b5;"><strong>Cumm. Duck:</strong>
                                <?= $faculty_info['faculty']['cumulative_ducks']; ?><strong> LWP:</strong> <?= $lwp ?></td>
                        </tr>
                        <tr class="faculty-row">
                            <td colspan="4"><strong>Weekly Load : Th-
                                </strong><?= $faculty_info['faculty']['total_hours_TH']; ?><strong>; PR-
                                </strong><?= $faculty_info['faculty']['total_hours_PR']; ?></td>
                            <td colspan="9"></td>
                        </tr>

                        <!-- Table structure -->
                        <tr class="a">
                            <th rowspan="2">SR No.</th>
                            <th rowspan="2">School - Stream</th>
                            <th rowspan="2">Sem</th>
                            <th rowspan="2">Div</th>
                            <th rowspan="2">Subject</th>
                            <th rowspan="2">Type</th>
                            <th rowspan="2">Slot</th>
                            <th rowspan="2">Total Students</th>
                            <th rowspan="2">Pr Students</th>
                            <th rowspan="2">AB Students</th>
                            <th rowspan="2">Attendance %</th>
                            <th colspan="2">No. of Duck</th>
                        </tr>
                        <tr class="a">
                            <th style="border-right: 1px solid #b2b3b5;">Today</th>
                            <th style="border-right: 1px solid #b2b3b5;">Cumm</th>
                        </tr>

                        <!-- Faculty Lecture Details -->
                        <?php
                        $facultyDisplayedSlots = []; // Track unique (slot, division) for this faculty
            
                        foreach ($faculty_info['details'] as $lecture):
                            $slot = trim($lecture['slot']);
                            $division = trim($lecture['division']);
                            $uniqueKey = $slot . '_' . $division;

                            if (isset($facultyDisplayedSlots[$uniqueKey])) {
                                continue;
                            }

                            $facultyDisplayedSlots[$uniqueKey] = true;
                            ?>
                            <tr class="a">
                                <td><?= $sr_no++; ?></td>
                                <td><?= $lecture['school_stream']; ?></td>
                                <td><?= $lecture['semester']; ?></td>
                                <td><?= $lecture['division'] . '-' . $lecture['batch']; ?></td>
                                <td><?= $lecture['subcod'] . '-' . $lecture['subject']; ?></td>
                                <td style="width:6%;"><?= $lecture['subtype']; ?></td>
                                <td style="width:10%;"><?= $lecture['slot']; ?></td>
                                <td style="width:8%;"><?= $lecture['total_students']; ?></td>
                                <td style="width:8%;"><?= $lecture['present_students']; ?></td>
                                <td style="width:8%;"><?= $lecture['absent_students']; ?></td>
                                <td style="width:8%;"><?= $lecture['attendance_percentage']; ?></td>
                                <td style="width:8%;border-right: 1px solid #b2b3b5;">
                                    <?php
                                    if ($lecture['today'] != 0) {
                                        echo '<img src="' . site_url() . 'assets/images/duck1.png" width="20px" height="20px" />';
                                    } else {
                                        echo $lecture['today'];
                                    }
                                    ?>
                                </td>

                                <td style="width:8%;border-right: 1px solid #b2b3b5;">
                                    <?php
                                    $subject_key = json_encode([
                                        'designation' => $lecture['designation'],
                                        'school_stream' => $lecture['school_stream'],
                                        'semester' => $lecture['semester'],
                                        'division' => $lecture['division'],
                                        'batch' => $lecture['batch'],
                                        'subject' => $lecture['subject'],
                                        'subcod' => $lecture['subcod'],
                                        'subtype' => $lecture['subtype'],
                                        'slot' => $lecture['slot'],
                                        'today' => $lecture['today'],
                                        'total_students' => $lecture['total_students'],
                                        'present_students' => $lecture['present_students'],
                                        'absent_students' => $lecture['absent_students'],
                                        'attendance_percentage' => $lecture['attendance_percentage']
                                    ]);

                                    echo isset($faculty_info['faculty']['cumulative_ducks_subject'][$subject_key])
                                        ? $faculty_info['faculty']['cumulative_ducks_subject'][$subject_key]
                                        : 0;
                                    ?>
                                </td>
                            </tr>
                                                <!-- Space after each faculty -->

                        <?php endforeach; ?>
                    <tr class="faculty-space">
                        <td colspan="9"></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="13">No faculty with missing attendance.</td>
                </tr>
            <?php endif; ?>

        </tbody>

    </table>
</body>

</html>

