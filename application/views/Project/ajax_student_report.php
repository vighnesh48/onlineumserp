<style type="text/css">
.table-bordered, 
.table-bordered > tbody > tr > td, 
.table-bordered > tbody > tr > th, 
.table-bordered > tfoot > tr > td, 
.table-bordered > tfoot > tr > th, 
.table-bordered > thead > tr > td, 
.table-bordered > thead > tr > th {
    border-color: #1d89cf !important;
    padding: 7px !important;
}

.table-bordered > thead > tr > th {
    color: #fff !important;
}

.course-divider {
    border-bottom: 2px solid #1d89cf;
    height: 5px;
}

.school-space {
    height: 20px;
}
</style>

<div style="text-align:center;color:red;">
    <h4><b>Project Attendance Report</b></h4>
</div>

<table id="dis_data" width="100%" class="table table-bordered" border="1" style="border-color:#249f8a; border-collapse: collapse; font-size: 11px !important;">
    <tbody>
        <?php 
        // Extract unique dates from the attendance data
        $dates = [];
        foreach ($attendance as $school => $courses) {
            foreach ($courses as $course) {
                foreach ($course['dates'] as $date => $facultyList) {
                    $dates[$date] = true;
                }
            }
        }
        ksort($dates); // Sort dates in ascending order

        foreach ($dates as $date => $_): ?>
            <!-- Date Heading -->
            <tr>
                <td colspan="7" style="background: #f0f0f0; font-weight: bold; text-align: center; font-size: 14px;">
                    Date: <?= $date ?>
                </td>
            </tr>

            <?php foreach ($attendance as $school_key => $courses): ?>
                <!-- School Name with extra space after it -->
                <tr>
                    <td colspan="7" style="background: #1d89cf; color: white; font-weight: bold; text-align: center; font-size: 14px;">
                        <?= strtoupper($school_key) ?> <!-- School Name -->
                    </td>
                </tr>

                <?php foreach ($courses as $course_key => $course): ?>
                    <?php if (!isset($course['dates'][$date])) continue; // Skip if no data for this date ?>
                    
                    <!-- Course Section -->
                    <tr>
                        <td colspan="7" style="background: #249f8a; color: white; font-weight: bold; text-align: center;">
                            <?= $course['course'] ?> - <?= $course['stream'] ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Sr No.</th>
                        <th>Faculty Name</th>
                        <th>Project Title</th> <!-- New Column Added -->
                        <th>Student Name</th>
                        <th>PRN.</th>
                        <th>Status</th>
                        <th>Reason of
						<br>absenteeism</th>
                    </tr>

                    <?php $sr_no = 1; ?>
                    <?php foreach ($course['dates'][$date]['faculty'] as $faculty_name => $faculty_data): ?>
                        <?php $rowspan_faculty = count($faculty_data['students']); ?>
                        <?php $firstFaculty = true; ?>

                        <?php foreach ($faculty_data['students'] as $row): ?>
                            <tr class="<?= ($row['attendance'] == 'P') ? 'present' : 'absent' ?>">
                                <td><?= $sr_no++ ?></td>

                                <?php if ($firstFaculty): ?>
                                    <td rowspan="<?= $rowspan_faculty ?>"><?= $faculty_name ?></td>
                                    <td rowspan="<?= $rowspan_faculty ?>"><?= $faculty_data['project_title'] ?></td> <!-- New Column -->
                                    <?php $firstFaculty = false; ?>
                                <?php endif; ?>

                                <td><?= $row['name'] ?></td>
                                <td><?= $row['prn'] ?></td>
                                <td><?= ($row['attendance'] == 'P' ? 'Present' : 'Absent') ?></td>
                                <td><? if($row['attendance']!='P') { echo  $row['remark'];} ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>

                    <!-- Course Divider -->
                    <tr class="course-divider"><td colspan="7"></td></tr>
                <?php endforeach; ?>

                <!-- School Space -->
                <tr class="school-space"><td colspan="7"></td></tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>  
