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
<script>
    $(document).ready(function() {
        $('#academic_year').on('change', function() {
            //alert("dfdsf");
            var academic_year = $(this).val();
            if (academic_year) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>Attendance/load_lecture_cources',
                    data: {
                        academic_year: academic_year
                    },
                    success: function(html) {
                        //alert(html);
                        $('#course_id').html(html);
                    }
                });
            } else {
                $('#course_id').html('<option value="">Select academic year first</option>');
            }
        });


        $('#course_id').on('change', function() {
            var course_id = $(this).val();
            var academic_year = $("#academic_year").val();
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
                        $('#stream_id').html(html);
                    }
                });
            } else {
                $('#stream_id').html('<option value="">Select course first</option>');
            }
        });
        // load div from semester
        $('#stream_id').on('change', function() {
            var stream_id = $(this).val();
            var academic_year = $("#academic_year").val();
            if (stream_id) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>Attendance/getSemfromAttendance',
                    data: {
                        stream_id: stream_id,
                        academic_year: academic_year
                    },
                    success: function(html) {
                        //alert(html);
                        $('#semester').html(html);
                    }
                });
            } else {
                $('#semester').html('<option value="">Select Stream first</option>');
            }
        });
        // load div from semester
        $("#semester").change(function() {
            var room_no = $("#stream_id").val();
            var semesterId = $("#semester").val();
            var academic_year = $("#academic_year").val();
            $.ajax({
                'url': base_url + 'Attendance/load_division_by_acdmicyear',
                'type': 'POST',
                'data': {
                    'room_no': room_no,
                    'semesterId': semesterId,
                    academic_year: academic_year
                },
                'success': function(data) {
                    var container = $('#division');
                    if (data) {
                        //alert(data);
                        container.html(data);
                        //$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
                    }
                }
            });
        });
        $('#dt-datepicker').datepicker({
            format: 'yyyy-mm-dd',
            endDate: '+0d',
            autoclose: true
        });

        $('#example').DataTable({
            dom: 'Bfrtip',
            "bPaginate": false,
            buttons: []
        });
    });
</script>
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Attendance Report Pdf Download</h1>
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
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Select Following Parameters</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <form id="form" name="form" action="<?= base_url($currentModule . '/student_attendance_pdf_dowload') ?>" method="POST">
                                <input type="hidden" value="<?= isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : '' ?>" id="sub_id" name="sub_id" />
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <select name="academic_year" id="academic_year" class="form-control" required>
                                            <option value="">Select Academic Year</option>
                                            <?php
                                            foreach ($academic_year as $yr) {
                                                if ($yr['academic_year'] . '~' . $yr['academic_session'] == $academicyear) {
                                                    $sel = "selected";
                                                } else {
                                                    $sel = '';
                                                }
                                                echo '<option value="' . $yr['academic_year'] . '~' . $yr['academic_session'] . '"' . $sel . '>' . $yr['academic_year'] . ' (' . $yr['academic_session'] . ')</option>';
                                            }
                                            ?>
                                            <!--option value="2021-22~WINTER">2021-22 (WINTER)</option-->
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="course_id" id="course_id" class="form-control" required>
                                            <option value="">Select Course</option>

                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="stream_id" id="stream_id" class="form-control" required>
                                            <option value="">Select Stream</option>
                                        </select>
                                    </div>


                                    <!--div class="col-sm-2" >
                                <select name="room_no" id="room_no" class="form-control" required>
                                  <option value="">Select Class</option>
                                  <?php
                                    foreach ($classRoom as $class) {
                                        if ($class['stream_id'] == $classa) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $class['stream_id'] . '"' . $sel . '>' . $class['stream_name'] . '</option>';
                                    }
                                    ?>
                               </select>
                              </div-->
                                    <div class="col-sm-2">
                                        <select name="semester" id="semester" class="form-control" required>
                                            <option value="">Select Semester</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="division" id="division" class="form-control" required>
                                            <option value="">Select Division</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_submit" type="submit">Search</button> </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row ">
            <!--form id="form" name="form" action="<?= base_url($currentModule . '/markAttendance') ?>" method="POST"-->
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title" id="stdname" style="width:50px;">Filter by Date :</span>
                        <form method="post" name="search_form" action="<?= base_url() ?>attendance/student_attendance_pdf_dowload">
                            <div style="float:right;margin-top:-26px !important; margin-right: 325px;">
                                <div class="col-sm-3"><input type="text" class="form-control" name="from_date" id="dt-datepicker1" value="<?= $_REQUEST['from_date'] ?>" placeholder="From Date" required></div>
                                <div class="col-sm-3"><input type="text" class="form-control" name="to_date" id="dt-datepicker2" value="<?= $_REQUEST['to_date'] ?>" placeholder="To Date" required></div>
                                <div class="col-sm-2"><input type="submit" name="submit" value="Search" class="btn btn-primary"></div>
                                <input type="hidden" name="stream_id" id="stream_id" value="<?= $streamID ?>">
                                <input type="hidden" name="division" id="division" value="<?= $division ?>">
                                <input type="hidden" name="semester" id="semester" value="<?= $semesterNo ?>">
                                <input type="hidden" name="academic_year" id="academic_year" value="<?= $academicyear ?>">
                        </form>
                    </div>


                    <?php
                    /*if($batch !=0){
								$batch_to = $batch;
							}else{
								$batch_to = "";
							}
							if(!empty($subdetails)){
								echo $subdetails[0]['subject_short_name'].'('.$subdetails[0]['subject_code'].')-'.$division.''.$batch_to;
							}*/
                    ?>

                </div>
                <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="table-info table-responsive">
                            <table class="table table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Enrollment No</th>
                                        <th>Student Name</th>
                                        <th>Overall Attendance (%)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sr = 1;
                                    $students = [];

                                    foreach ($attendance_data as $row) {
                                        if (!isset($students[$row['student_id']])) {
                                            $students[$row['student_id']] = [
                                                'name' => $row['first_name'],
                                                'enrollment_no' => $row['enrollment_no'],
                                                'total_percentage' => 0,
                                                'subject_count' => 0
                                            ];
                                        }
                                        $attendance_percentage = ($row['total_lectures'] > 0)
                                            ? round(($row['total_attended_lectures'] / $row['total_lectures']) * 100, 2)
                                            : 0;

                                        $students[$row['student_id']]['total_percentage'] += $attendance_percentage;
                                        $students[$row['student_id']]['subject_count']++;
                                    }

                                    foreach ($students as $student_id => $student) {
                                        $overall_attendance = ($student['subject_count'] > 0)
                                            ? round(($student['total_percentage'] / $student['subject_count']), 2)
                                            : 0;

                                        $color = ($overall_attendance >= 75) ? 'green' : 'red';

                                        echo "<tr>";
                                        echo "<td>" . $sr++ . "</td>";
                                        echo "<td>" . htmlspecialchars($student['enrollment_no']) . "</td>";
                                        echo "<td>" . htmlspecialchars($student['name']) . "</td>";
                                        echo "<td style='color: $color; font-weight: bold;'>" . $overall_attendance . "%</td>";
                                        echo '<td>
                            <form action="' . base_url('Attendance/parent_letter_report') . '" method="POST" target="_blank">
                                <input type="hidden" name="student_id" value="' . $student_id . '">
                                <input type="hidden" name="course_id" value="' . $_POST['course_id'] . '">
                                <input type="hidden" name="stream_id" value="' . $_POST['stream_id'] . '">
                                <input type="hidden" name="semester" value="' . $_POST['semester'] . '">
                                <input type="hidden" name="division" value="' . $_POST['division'] . '">
                                <input type="hidden" name="academic_year" value="' . $_POST['academic_year'] . '">
                                <input type="hidden" name="from_date" value="' . $_POST['from_date'] . '">
                                <input type="hidden" name="to_date" value="' . $_POST['to_date'] . '">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-file-pdf-o"></i> Download PDF
                                </button>
                            </form>
                        </td>';
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
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