<!DOCTYPE html>
<html>
<head>
    <title>Faculty Attendance Report</title>
    <style>
        body {
            font-family: "Bookman Old Style", serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #99d5ff;
            font-weight: bold;
        }

        .header-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        .sub-header {
            text-align: center;
            font-size: 12px;
        }

        .school-header {
            background-color: #0056b3;
            color: white;
            font-size: 14px;
            font-weight: bold;
        }

        .department-header {
            background-color: #66c0ff;
            color: black;
            font-size: 12px;
            font-weight: bold;
        }

        .faculty-table {
            border: 1px solid black;
        }

        .group-header {
            background-color: #dff0ff;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php if (!empty($report_data)): ?>
    <?php 
        // **Group data by School -> Department**
        $school_data = [];
        foreach ($report_data as $faculty) {
            $school = $faculty['school'];
            $department = $faculty['department'];

            if (!isset($school_data[$school])) {
                $school_data[$school] = [];
            }
            if (!isset($school_data[$school][$department])) {
                $school_data[$school][$department] = [];
            }

            $school_data[$school][$department][] = $faculty;
        }
    ?>

    <?php foreach ($school_data as $school => $departments):

 if(!empty($school)) {
	?>
        <!-- **School Header Row** -->
        <table>
            <tr>
                <td colspan="20" class="school-header"><?= strtoupper($school); ?></td>
            </tr>
        </table>

        <?php foreach ($departments as $department => $faculty_list):
         
		 
		
		?>
            <!-- **Department Header Row** -->
            <table>
                <tr>
                    <td colspan="20" class="department-header"><?= strtoupper($department); ?></td>
                </tr>
            </table>

            <!-- **Faculty Data Table** -->
             <table class="faculty-table" style="border: 1px solid black">
                <thead>
                    <tr>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;" rowspan="2">Sr. No.</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;" rowspan="2">Faculty Name</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;" colspan="6">Theory (TH)</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;" colspan="6">Practical (PR)</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;" rowspan="2">Monthly Leaves</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;" rowspan="2">Cumulative Leaves</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;" rowspan="2">Monthly OD's</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;" rowspan="2">Cumulative OD's</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;" rowspan="2">Swap (Additional Load) Taken</th>
                        <th style="border-bottom: 1px solid grey;" rowspan="2">Swap (Additional Load) Student Attendance Avg. %</th>
                    </tr>
                    <tr class="group-header">
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;">Load Assigned</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;">Taken</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;">Lecture %</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;">Prev. Month Lecture %</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;">Student %</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;">Prev. Month Student %</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;">Load Assigned</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;">Taken</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;">Lecture %</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;">Prev. Month Lecture %</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;">Student %</th>
                        <th style="border-right: 1px solid grey;border-bottom: 1px solid grey;">Prev. Month Student %</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sr_no = 1; foreach ($faculty_list as $faculty):
                      if(!empty($faculty['faculty_name'])){
                    
					?>
                        <tr>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $sr_no++; ?></td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['faculty_code'] . '-' . $faculty['faculty_name']; ?> (<?= $faculty['designation']; ?>)</td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['total_TH_load']; ?></td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['TH_taken']; ?></td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['TH_percentage']; ?>%</td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['prev_TH_percentage']; ?>%</td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['TH_attendance_percentage']; ?>%</td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['prev_TH_attendance_percentage']; ?>%</td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['total_PR_load']; ?></td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['PR_taken']; ?></td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['PR_percentage']; ?>%</td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['prev_PR_percentage']; ?>%</td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['PR_attendance_percentage']; ?>%</td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['prev_PR_attendance_percentage']; ?>%</td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['month_leave']; ?></td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['cumm_leave']; ?></td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['month_OD']; ?></td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['cumm_OD']; ?></td>
                            <td style="border-right: 1px solid lightgrey;border-bottom: 1px solid lightgrey;"><?= $faculty['additional_load_taken']; ?></td>
                            <td style="border-bottom: 1px solid lightgrey;"><?= $faculty['additional_load_student_attendance_avg']; ?>%</td>
                        </tr>
<?php 
$CI =& get_instance();
$CI->load->model('Student_attendance_model');
$fac['for_the_month'] =date('Y').'-03-01';
$fac['school'] =$school;
$fac['department'] =$department;
$fac['faculty_code'] =$faculty['faculty_code'];
$fac['faculty_name'] =$faculty['faculty_name'];
$fac['designation'] =$faculty['designation'];
$fac['total_TH_load'] =$faculty['total_TH_load'];
$fac['TH_taken'] =$faculty['TH_taken'];
$fac['TH_percentage'] =$faculty['TH_percentage'];
$fac['prev_TH_percentage'] =$faculty['prev_TH_percentage'];
$fac['TH_attendance_percentage'] =$faculty['TH_attendance_percentage'];
$fac['prev_TH_attendance_percentage'] =$faculty['prev_TH_attendance_percentage'];
$fac['total_PR_load'] =$faculty['total_PR_load'];
$fac['PR_taken'] =$faculty['PR_taken'];
$fac['PR_percentage'] =$faculty['PR_percentage'];
$fac['prev_PR_percentage'] =$faculty['prev_PR_percentage'];
$fac['PR_attendance_percentage'] =$faculty['PR_attendance_percentage'];
$fac['prev_PR_attendance_percentage'] =$faculty['prev_PR_attendance_percentage'];
$fac['additional_load_taken'] =$faculty['additional_load_taken'];
$fac['additional_load_student_attendance_avg'] =$faculty['additional_load_student_attendance_avg'];

$fac['TH_total_students'] =$faculty['TH_total_students'];
$fac['TH_present_students'] =$faculty['TH_present_students'];
$fac['PR_total_students'] =$faculty['PR_total_students'];
$fac['PR_present_students'] =$faculty['PR_present_students'];
$fac['present_students_unscheduled'] =$faculty['present_students_unscheduled'];
$fac['total_students_unscheduled'] =$faculty['total_students_unscheduled'];
$totalcount=$CI->Student_attendance_model->faculty_monthly_attendance_insert($fac);

} endforeach; ?>
                </tbody>
            </table>
		 <?php endforeach;  ?>
		 <?php } endforeach;  ?>

<?php else: ?>
    <p style="text-align: center; font-size: 14px;">No data available for the selected date range.</p>
<?php endif; ?>

</body>
</html>
