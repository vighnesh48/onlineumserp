<?php 
$bucketname='uploads/project_report/';

?>

<style type="text/css">
.table-bordered, 
.table-bordered > tbody > tr > td, 
.table-bordered > tbody > tr > th, 
.table-bordered > tfoot > tr > td, 
.table-bordered > tfoot > tr > th, 
.table-bordered > thead > tr > td, 
.table-bordered > thead > tr > th {
    border-color: #1d89cf !important;
    padding: 10px !important;  /* Increased padding for better spacing */
    font-size: 14px !important; /* Increased font size for better readability */
}

.table-bordered > thead > tr > th {
    color: #fff !important;
    font-size: 15px; /* Larger font size for headers */
}

.course-divider {
    border-bottom: 2px solid #1d89cf;
    height: 5px;
}

.school-space {
    height: 20px;
}

/* Adjust font size for specific columns if needed */
th, td {
    padding: 10px 15px;  /* Horizontal and Vertical Padding */
    text-align: center;
    font-size: 14px; /* Increase font size for content */
}

td {
    padding: 8px;  /* Adjust padding for table data */
}

/* Style for specific columns */
th:nth-child(1), td:nth-child(1) { /* First column */
    padding-left: 15px;
}

th:nth-child(7), td:nth-child(7) { /* Remark column */
    padding-right: 15px;
}
</style>


<div style="text-align:center;color:red;">
    <!--<h4><b>WEEKLY PROJECT ATTENDANCE REPORT</b></h4>-->
</div>

<table id="dis_data" width="100%" class="table table-bordered" border="1" style="border-color:#249f8a; border-collapse: collapse; font-size: 11px !important;">
    <tbody>
        <?php 
        // Loop through each school
        foreach ($attendance as $school_key => $courses): ?>

            <!-- School Name -->
            <tr>
                <td colspan="8" style="background: #1d89cf; color: white; font-weight: bold; text-align: center; font-size: 14px;">
                    <?= strtoupper($school_key) ?> <!-- School Name -->
                </td>
            </tr>

            <?php 
            // Loop through each course for the school
            foreach ($courses as $course_key => $course): ?>

                <!-- Course Section -->
                <tr>
                    <td colspan="8" style="background: #249f8a; color: white; font-weight: bold; text-align: center;">
                        <?= $course['course'] ?> - <?= $course['stream'] ?>
                    </td>
                </tr>

                <tr>
                     <!-- New Column -->
                    <th>Sr No.</th>
                    <th>Faculty Name</th>
                    <th>Project Title</th> <!-- New Column Added -->
                    <th>Student Name</th>
                    <th>PRN.</th>
                    <th>Status</th>
                    <th>Reason of
						<br>absenteeism</th>
					<th>Link</th>
                </tr>

                <?php 
                // Loop through dates for each course
                foreach ($course['dates'] as $date => $facultyList): ?>

                    <!-- Date Heading -->
                    <tr>
                        <td colspan="8" style="background: #f0f0f0; font-weight: bold; text-align: center; font-size: 14px;">
                            Date: <?= $date ?>
                        </td>
                    </tr>

                    <?php 
                    // Loop through each faculty for the date
                    foreach ($facultyList['faculty'] as $faculty_name => $faculty_data): ?>
                        <?php $rowspan_faculty = count($faculty_data['students']); ?>
                        <?php $firstFaculty = true; ?>

                        <?php 
                        // Loop through students for each faculty
                        foreach ($faculty_data['students'] as $row): ?>
                            <tr class="<?= ($row['attendance'] == 'P') ? 'present' : 'absent' ?>">
                                 <!-- Date Column -->
                                <td><?= $sr_no++ ?></td>

                                <?php if ($firstFaculty): ?>
                                    <td rowspan="<?= $rowspan_faculty ?>"><?= $faculty_name ?></td>
                                    <td rowspan="<?= $rowspan_faculty ?>"><?= $faculty_data['project_title'] ?></td> <!-- Project Title -->
                                    <?php $firstFaculty = false; ?>
                                <?php endif; ?>

                                <td><?= $row['name'] ?></td>
                                <td><?= $row['prn'] ?></td>
                                <td><?= ($row['attendance'] == 'P' ? 'Present' : 'Absent') ?></td>
                                <td><?php if($row['attendance']!='P') { echo  $row['remark'];} ?></td>
								<td><?php if(empty($row['link'])){}else{?><a href="<?= site_url() ?>Upload/get_document/<?php echo $row['link'].'?b_name='.$bucketname;  ?>" target="_blank">Click Here</a><?php } ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>

                <?php endforeach; ?>
                <!-- Course Divider -->
                <tr class="course-divider"><td colspan="8"></td></tr>

            <?php endforeach; ?>

            <!-- School Space -->
            <tr class="school-space"><td colspan="8"></td></tr>

        <?php endforeach; ?>
    </tbody>
</table>
