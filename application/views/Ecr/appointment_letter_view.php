<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: "Bookman Old Style", serif;
            margin: 0;
            padding: 0;
        }

        .date-ref {
            margin-bottom: 20px;
        }

        .content {
            margin: 20px;
            line-height: 1.6;
        }

        .subject {
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .footer {
            margin-top: 30px;
        }

        .signature {
            text-align: right;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <!-- Reference and Date -->
    <table style="width: 100%; margin-bottom: 0px;font-size: 12px;">
        <tr>
            <td style="text-align: left; width: 50%;">
                Ref. No.: SUN/COE/<?= $employee_data['exam_year'] ?>/<?= $employee_data['exam_name'] ?>/<?= $new_ref_no?>
            </td>
            <td style="text-align: right; width: 50%;">
                Date: <?= date('M d, Y') ?>
            </td> 
        </tr>
    </table>

    <?php
    switch ($employee_data['ecr_role']) {
        case 1:
            ?>
        <div style="font-size: 12px;">
            <!-- Subject -->
            <div class="subject" style="font-size: 12px;">
                <p style="text-align: center;font-size: 14px;">APPOINTMENT ORDER</p>
                <br>Subject: Appointment of <?= $employee_data['role_name'] ?> for <?php echo ($employee_data['exam_type'] = 'Regular')? 'End Semester Examination' : 'Supplementary Examination' ; ?>
                 - <?= $employee_data['exam_name'] ?>.
            </div>

            <!-- Introduction -->
            <p>With reference to the above subject, You have been appointed as
                <?= $employee_data['role_name'] ?> for the smooth functioning of work in the Examination Control Room (ECR)
                during <?php echo ($employee_data['exam_type'] = 'Regular')? 'End Semester Examination' : 'Supplementary Examination' ; ?> - <?= $employee_data['exam_name'] ?>.
            </p>
            <p>The remuneration shall be applicable as per Sandip University norms.</p>

            <!-- Details Table -->
            <table class="table" style="font-size: 12px;">
                <tr>
                    <th>Sr. No.</th>
                    <th>Employee Id</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>School / Department</th>
                    <th>Role</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td><?= $employee_data['emp_id'] ?></td>
                    <td><?= $employee_data['name'] ?></td>
                    <td><?= $employee_data['designation'] ?></td>
                    <td><?= $employee_data['department'] ?></td>
                    <td><?= $employee_data['role_name'] ?></td>
                </tr>
            </table>

            <!-- Footer Note - Switch Case for Role Specific Content -->
            <div class="footer">

                <p>The Appointment order is issued on the assumption that:
                <ul>
                    <li>No person related to you by the relationship as mentioned below is appearing in any subject at the said
                        examination viz, Son, Daughter, etc.</li>
                    <li>You will discharge the duties sincerely and honestly without any lapse.</li>
                    <li>Encl : Guidelines to Chief Superintendent</li>
                </ul>
                </p>

            </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <!-- Signature -->
            <div class="signature">
                <table style="width: 100%;font-size: 12px;">
                    <tr>
                        <td style="text-align: right; width: 50%;">
                            Controller of Examinations
                        </td>
                    </tr>
                </table>
            </div>
            <?php
            break;
        case 2:
            // For role 2, include the "report to Chief Superintendent" line
            ?>
        <div style="font-size: 12px;"> 
            <!-- Subject -->
            <div class="subject" style="font-size: 13px;">
                <p style="text-align: center;">APPOINTMENT ORDER</p>
                <br>Subject: Appointment of <?= $employee_data['role_name'] ?> for <?php echo ($employee_data['exam_type'] = 'Regular')? 'End Semester Examination' : 'Supplementary Examination' ; ?> - <?= $employee_data['exam_name'] ?>.
            </div>

            <!-- Introduction -->
            <p>With reference to the above subject, You have been appointed as
                <?= $employee_data['role_name'] ?> for the smooth functioning of work in the Examination Control Room (ECR)
                during <?php echo ($employee_data['exam_type'] = 'Regular')? 'End Semester Examination' : 'Supplementary Examination' ; ?> - <?= $employee_data['exam_name'] ?>.
            </p>
            <p>The remuneration shall be applicable as per Sandip University norms.</p>

            <!-- Details Table -->
            <table class="table" style="font-size: 12px;">
                <tr>
                    <th>Sr. No.</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>School / Department</th>
                    <th>Role</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td><?= $employee_data['name'] ?></td>
                    <td><?= $employee_data['designation'] ?></td>
                    <td><?= $employee_data['department'] ?></td>
                    <td><?= $employee_data['role_name'] ?></td>
                </tr>
            </table>

            <!-- Footer Note - Switch Case for Role Specific Content -->
            <div class="footer">

                <p>Note: You are kindly report to Chief Superintendent Prof.
                    <?= $additional_employees['name'] ?> (Mob No.: <?= $additional_employees['mobile'] ?>) urgently.
                </p>
                <p>The Appointment order is issued on the assumption that:
                <ul>
                    <li>No person related to you by the relationship as mentioned below is appearing in any subject at the said
                        examination viz, Son, Daughter, etc.</li>
                    <li>You will discharge the duties sincerely and honestly without any lapse.</li>
                </ul>
                </p>

            </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <!-- Signature -->
            <div class="signature">

                <table style="width: 100%; margin-bottom: 20px;font-size: 12px; ">
                    <tr>
                        <td style="text-align: right; width: 50%;">
                            <b>Chief Superintendent</b>
                        </td>
                    </tr>
                </table>
            </div>
            <?php
            break;
        case 7:
            // For role 7, include the "report to Chief Superintendent" line
            ?>
            <!-- Content -->
            <div class="content" style="line-height: 1.5; font-size: 12px;">
    
                <p style="text-align: center; font-size: 14px; font-weight: bold; margin-top: 0px;">APPOINTMENT ORDER</p>

                <p style="margin-bottom: 5px; font-weight: bold;">
                    From<br>
                    The Chief Superintendent<br>
                    Sandip University, Nashik.<br>
                    Through The Controller Of Examination<br>
                    Sandip University, Nashik.
                </p>

                <p style="margin-top: 0px;">
                    Mr./Ms./Dr. <b><?= $employee_data['name'] ?></b> is hereby appointed as Hall Superintendent for the 
                    <?php echo ($employee_data['exam_type'] == 'Regular') ? 'End Semester Examination' : 'Supplementary Examination'; ?> - 
                    <b><?= $employee_data['exam_name'] ?></b>. The date and time of invigilation work are notified hereunder. He/She is directed to report to the 
                    <b>Examination Control Room (ECR) at <?= $employee_data['center_name'] ?>, SUN</b> 30 minutes before the commencement of the Examination, which is mandatory for all Hall Superintendents.
                </p>

                <p style="margin-top: 0px;">
                    Hall Superintendents shall not be absent from invigilation work without the written permission of the Chief Superintendent. 
                    If unable to accept the order, he/she must find a substitute and provide the acceptance of the substitute to the Chief Superintendent. 
                    Requests for leave without an alternative arrangement will not be entertained.
                </p>

                <p style="margin-top: 0px;">
                    The Hall Superintendent will carry out the duties as per the instructions given herewith for the conduct of Examinations.
                </p>

                <!-- Examination Timing -->
                <p style="font-weight: bold; margin-top: 0px;">Note:</p>
               <!--<ul style="margin-top: 0; padding-left: 20px;">
                    <li style="margin-top: 0;">Exam Timing: Fore-Noon – 10:00 a.m. / After-Noon – 02:00 p.m.</li>
                    <li>Reporting Time: Fore-Noon – 09:30 a.m. / After-Noon – 01:30 p.m.</li>
                </ul> -->
				 <?php
                    $fn_time = '';
                    $an_time = '';
                    $fn_report = '';
                    $an_report = '';

                    if (!empty($exam_details_time)) {
                        foreach ($exam_details_time as $session_detail) {
                            if ($session_detail['session'] == 'FN') {
                                $fn_time = date('h:i A', strtotime($session_detail['from_time']));
                                $fn_report = date('h:i A', strtotime($session_detail['from_time'] . ' -30 minutes'));
                            }
                            if ($session_detail['session'] == 'AN') {
                                $an_time = date('h:i A', strtotime($session_detail['from_time']));
                                $an_report = date('h:i A', strtotime($session_detail['from_time'] . ' -30 minutes'));
                            }
                        }
                    }
                    ?>
                    <div class="row" style="width: 100%; margin-top: 10px;">
                        <div class="col-sm-6" style="float: left; width: 50%;">
                            <?php if ($fn_time): ?>
                                <ul style="margin: 0; padding-left: 20px; list-style-type: disc; font-size: 12px;">
                                    <li><strong>Exam Timing (Fore-Noon):</strong> <?= $fn_time ?></li>
                                    <li><strong>Reporting Time (Fore-Noon):</strong> <?= $fn_report ?></li>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-6" style="float: left; width: 50%;">
                            <?php if ($an_time): ?>
                                <ul style="margin: 0; padding-left: 20px; list-style-type: disc; font-size: 12px;">
                                    <li><strong>Exam Timing (After-Noon):</strong> <?= $an_time ?></li>
                                    <li><strong>Reporting Time (After-Noon):</strong> <?= $an_report ?></li>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div style="clear: both;"></div>

                <h3 style="margin-top: 0px;">Particulars of Invigilation Work</h3>

                <?php
                // Sort the dates in ascending order based on 'date' field
                usort($duiety_dates, function ($a, $b) {
                    return strtotime($a['date']) - strtotime($b['date']);
                });

                // Separate the dates based on sessions
                $fore_noon_dates = array_filter($duiety_dates, function ($date) {
                    return $date['session'] === 'FN';
                });

                $after_noon_dates = array_filter($duiety_dates, function ($date) {
                    return $date['session'] === 'AN';
                });

                // Get the maximum rows needed based on the larger array size
                $max_rows = max(count($fore_noon_dates), count($after_noon_dates));

                // Reset array pointers to use them in the loop
                $fn_dates = array_values($fore_noon_dates);
                $an_dates = array_values($after_noon_dates);
                ?>
                
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <?php
                        $max_rows_per_table = 8;
                        $total_records = max(count($fn_dates), count($an_dates));
                        $num_tables = ceil($total_records / $max_rows_per_table);

                        for ($table_index = 0; $table_index < $num_tables; $table_index++) {
                            echo '<td style="vertical-align: top; width: 20%;">'; // Each table occupies a fraction of the page width
                            echo '<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%;">';
                            echo '<thead>';
                            echo '<tr style="background-color: #f2f2f2; text-align: center;">';
                            echo '<th>FN</th>';
                            echo '<th>AN</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            // Generate rows for the current table
                            for ($row_index = 0; $row_index < $max_rows_per_table; $row_index++) {
                                $data_index = $table_index * $max_rows_per_table + $row_index;

                                if ($data_index >= $total_records) break;

                                $fn_date = $fn_dates[$data_index]['date'] ?? '-';
                                $an_date = $an_dates[$data_index]['date'] ?? '-';
                                $fn_date_raw = $fn_dates[$data_index]['date'] ?? '-';
                                $an_date_raw = $an_dates[$data_index]['date'] ?? '-';
                                
                                $fn_date = ($fn_date_raw !== '-') ? date('d-m-y', strtotime($fn_date_raw)) : '-';
                                $an_date = ($an_date_raw !== '-') ? date('d-m-y', strtotime($an_date_raw)) : '-';
                                
                                echo '<tr>';
                                echo "<td style='text-align: center; font-size:12px;'>{$fn_date}</td>";
                                echo "<td style='text-align: center; font-size:12px;'>{$an_date}</td>";
                                echo '</tr>';
                            }

                            echo '</tbody>';
                            echo '</table>';
                            echo '</td>';
                        }
                        ?>
                    </tr>
                </table>

                <br><br><br><br>
                    <!-- Signature (this will stay at the bottom) -->
                    <div class="signature" style="position: absolute; bottom: 0; width: 100%; page-break-after: always;">

                        <table style="width: 100%; margin-bottom: 30px;">
                            <tr>
                                <td style="text-align: left; width: 50%;"><b>Controller of Examinations</b></td>
                                <td style="text-align: right; width: 50%;"><b>Chief Superintendent</b></td>
                            </tr>
                        </table>
                    </div>

            </div>
            <div class="content" style="line-height: 1.5; font-size: 12px;">


                <h3 style="text-align: center;" >INSTRUCTIONS TO THE HALL SUPERINTENDENT</h3>

                <h4>Before Invigilation</h4>
                <ol>
                    <li>Decline Invigilation duty if you are aware that any of your relatives is appearing in the examination.
                    </li>
                    <li>Avoid altering exam duties, however, in extreme situations alterations can be done. The respective form
                        should be duly signed by the HoD and the Chief Superintendent and the same shall be submitted to the ECR
                        office.</li>
                </ol>

                <h4>During Invigilation</h4>
                <ol>
                    <li>Verify the hall allotment sheet. If students belong to your department or if you have handled the
                        subject, immediately inform the staff in the ECR once you sign in the attendance sheet.</li>
                    <li>Follow the special instructions regarding codes, distribution of booklets/question papers, and data
                        books given in the ECR. Clarify if required.</li>
                    <li>Read instructions regarding calculator usage in the Invigilation hall.</li>
                    <li>Collect all exam materials (answer booklets, attendance sheets, and seating arrangement) from the ECR
                        and check the count and printing before leaving.</li>
                    <li>Reach the Invigilation hall at least 30 minutes before the Exam begins.</li>
                    <li>Instruct students to keep belongings outside the Exam hall.</li>
                    <li>Ensure students occupy their respective seats and settle down 10 minutes before the Exam.</li>
                    <li>Check if sufficient space is provided in the seating arrangement.</li>
                    <li>Do not encourage late students (allowed up to the first 30 minutes).</li>
                    <li>Instruct students about malpractice and check for any material violating Exam conduct. Check
                        calculators, cases, scales for incriminating material.</li>
                    <li>Distribute the answer booklets and ask students to verify stitching, page numbers, and facsimile.</li>
                    <li>Seek assistance from ECR for any issues in the hall, including seating, printing, and distribution
                        errors.</li>
                    <li>Instruct students to fill all relevant details on the booklet's first page without mistakes.</li>
                    <li>Distribute question papers on time, asking students to check printed pages, course code, and title as in
                        the hall ticket.</li>
                    <li>Instruct students to write PRN on the question paper only.</li>
                    <li>Verify student credentials (ID card, Hall Ticket) and sign with date and full name on the first page of
                        the Answer booklet and Hall Tickets.</li>
                    <li>Provide the attendance record after verifying details (PRN, course code, etc.). Ensure signing in the
                        appropriate places.</li>
                    <li>Distribute data books after shuffling if brought by students; otherwise, distribute as is.</li>
                    <li>Keep track of time and make an announcement every 30 minutes.</li>
                    <li>Walk across the hall throughout the invigilation period.</li>
                    <li>Do not carry mobile phones to the hall.</li>
                    <li>Avoid conversing with neighboring Hall Superintendents and non-teaching staff.</li>
                    <li>Ensure students remain in the hall for the entire Exam duration.</li>
                </ol>

                <h4>After Invigilation</h4>
                <ol>
                    <li>Once the Exam ends, instruct students to remain seated and collect answer booklets and data books (if
                        provided by ECR).</li>
                    <li>Count the answer booklets against attendance. If correct, allow students to leave the hall.</li>
                    <li>Arrange answer booklets in order and submit them to the ECR. Return unused booklets, question papers,
                        and other materials (e.g., data books, staplers) to ECR.</li>
                    <li>Switch off fans and lights before leaving the Examination hall.</li>
                    <li>Remind students to take their belongings.</li>
                </ol>
            </div>

            <?php
            break;
    }
    ?>
                <table style="width: 100%; margin-bottom: 20px; font-size: 12px;">
                    <tr>
                        <td style="text-align: left; width: 65%;"> 
                            <p>It is system generated report signature is not required</p>
                        </td>
                        <td style="text-align: right; width: 35%; font-size:12px;">
                            Date: <?= date('d-m-Y') ?>
                            <br>
                             <?php date_default_timezone_set('Asia/Kolkata'); ?>
                            Time: <?= date('h:i:s A') ?>
                        </td>
                    </tr>
                </table>
</body>

</html>