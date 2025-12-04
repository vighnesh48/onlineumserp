<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<link href="<?= site_url() ?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?= site_url() ?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>


<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">

<style>
    .absent_bg {
        background: #ff9b9b;
    }
</style>
<?php
$astrik = '<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Attendance</a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Attendance Report</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">


            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <?php
                        $year_mapping = [
                            1 => 'F.E',
                            2 => 'S.E',
                            3 => 'T.E',
                            4 => 'B.E',
                            5 => 'Fifth Year',
                            6 => 'Sixth Year'
                        ];
                        $class_name = isset($attendance_data[0]['current_year']) ? ($year_mapping[$attendance_data[0]['current_year']] ?? 'Unknown') : 'Unknown';
                        ?>

                        <span class="panel-title" id="stdname" style="width:50px;"> <strong>Student Name: </strong><?= $attendance_data[0]['first_name'] ?> |<strong> Class:</strong> <?= $class_name ?> | <strong>Division:</strong> <?= $attendance_data[0]['division'] ?> | <strong>Semester:</strong> <?= $semester ?> | <strong> Academic Year:</strong> <?= $ac_yr ?> | <strong> Session:</strong> <?= CURRENT_SESS ?></span>
                        <form method="post" name="search_form" action="<?= base_url() ?>attendance/student_attendance_pdf_dowload">
                            <div style="float:right;margin-top:-26px !important; margin-right: 325px;">

                                <input type="hidden" name="stream_id" id="stream_id" value="<?= $streamID ?>">
                                <input type="hidden" name="division" id="division" value="<?= $division ?>">
                                <input type="hidden" name="semester" id="semester" value="<?= $semesterNo ?>">
                                <input type="hidden" name="academic_year" id="academic_year" value="<?= $academicyear ?>">
                        </form>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="table-info table-responsive">
                            <div class="">

                            </div>
                        </div>
                        <table class="table table-bordered" id="example">
                            <thead>
                                <tr style="font-size: 13px!important;">
                                    <th style="background-color:#67b5e8">#</th>
                                    <th style="background-color:#67b5e8">Subject Name</th>
                                    <th style="background-color:#67b5e8">No. of Classes Conducted</th>
                                    <th style="background-color:#67b5e8">No. of Classes Attended</th>
                                    <th style="background-color:#67b5e8">Attendance (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $total_percentage = 0;
                                $subject_count = count($attendance_data);

                                foreach ($attendance_data as $attendance) :
                                    $attendance_percentage = ($attendance['total_lectures'] > 0) ?
                                        round(($attendance['total_attended_lectures'] / $attendance['total_lectures']) * 100, 2) : 0;

                                    $total_percentage += $attendance_percentage;
                                ?>
                                    <tr style="font-size: 13px!important;">
                                        <td><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($attendance['subject_name']) ?></td>
                                        <td><?= htmlspecialchars($attendance['total_lectures']) ?></td>
                                        <td><?= htmlspecialchars($attendance['total_attended_lectures']) ?></td>
                                        <td><?= $attendance_percentage . '%' ?></td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php
                                $overall_attendance = ($subject_count > 0) ? round(($total_percentage / $subject_count), 2) : 0;
                                ?>
                            </tbody>
                        </table>

                        <div style="text-align: right; font-size: 14px; font-weight: bold; margin-top: 10px;">
                            Overall Attendance: <span style="color: <?= ($overall_attendance >= 75) ? 'green' : 'red' ?>;">
                                <?= $overall_attendance ?>%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/form-->
    </div>

</div>
</div>
<script>
    $(document).ready(function() {
        $('#dt-datepicker1').datepicker({
            format: 'yyyy-mm-dd',
            endDate: '+0d',
            autoclose: true
        });
        $('#dt-datepicker2').datepicker({
            format: 'yyyy-mm-dd',
            endDate: '+0d',
            autoclose: true
        });
        var academic_year = '<?= $academicyear ?>';
        if (academic_year) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>Attendance/load_lecture_cources',
                data: {
                    academic_year: academic_year
                },
                success: function(html) {
                    //alert(html);
                    var course_id = '<?= $courseId ?>';
                    $('#course_id').html(html);
                    $("#course_id option[value='" + course_id + "']").attr("selected", "selected");
                }
            });
        } else {
            $('#course_id').html('<option value="">Select academic year first</option>');
        }
        var course_id = '<?= $courseId ?>';
        //alert(course_id);
        if (course_id) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>Attendance/load_streams',
                data: {
                    course_id: course_id,
                    academic_year: academic_year
                },
                success: function(html) {
                    //alert(html);
                    var stream_id = '<?= $streamID ?>';
                    //alert(stream_id);
                    $('#stream_id').html(html);
                    $("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
                }
            });
        } else {
            $('#stream_id').html('<option value="">Select course first</option>');
        }
        //edit division
        var stream_id2 = '<?= $streamID ?>';
        if (stream_id2) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>Attendance/getSemfromAttendance',
                data: {
                    stream_id: stream_id2,
                    academic_year: academic_year
                },
                success: function(html) {
                    //alert(html);
                    var sem = '<?= $semesterNo ?>';
                    $('#semester').html(html);
                    $("#semester option[value='" + sem + "']").attr("selected", "selected");
                }
            });
        } else {
            $('#semester').html('<option value="">Select Stream first</option>');
        }
        //edit semester
        var strem_id1 = '<?= $streamID ?>';
        var semesterId1 = '<?= $semesterNo ?>';
        //alert(strem_id1);alert(semesterId1);
        if (strem_id1 != '' && semesterId1 != '') {
            //alert('hi');
            $.ajax({
                'url': base_url + 'Attendance/load_division_by_acdmicyear',
                'type': 'POST', //the way you want to send data to your URL
                'data': {
                    'room_no': strem_id1,
                    'semesterId': semesterId1,
                    academic_year: academic_year
                },
                'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                    var container = $('#division'); //jquery selector (get element by id)
                    if (data) {
                        //alert(data);
                        var division1 = '<?= $division ?>';
                        //alert(division1);
                        container.html(data);
                        $("#division option[value='" + division1 + "']").attr("selected", "selected");
                    }
                }
            });
        }
    });
</script>