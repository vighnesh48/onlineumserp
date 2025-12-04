<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seating Arrangement</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    <style>
        .bgdynamic {
            background: linear-gradient(44deg, #59b9f3, rgb(207 148 247), #edd6ff, #e0d3f9, #7aceff);
            background-size: 150% 150%;
            animation: gradientBackground 10s ease infinite;
        }

        @keyframes gradientBackground {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .hall-matrix {
            display: grid;
            margin-bottom: 20px;
            gap: 10px;
            /* Adds space between seats */
        }

        .seat {
            padding: 15px;
            border-radius: 8px;
            /* Rounded corners for seats */
            border: none;
            text-align: center;
            background-color: #f0f0f0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for 3D effect */
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .seat:hover {
            transform: translateY(-3px);
            /* Slight lift effect on hover */
            box-shadow: 0 6px 12px rgb(55 117 255 / 62%);
        }

        .seat:not(:empty) {
            background-color: #1da1ff;
            /* Bootstrap primary color for occupied seats */
            color: white;
        }

        .card-header {
            background-color: #333;
            color: white;
            font-size: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            min-height: 38px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 12px;
            padding-right: 12px;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .select2-container .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff;
            border-color: #006fe6;
            color: white;
        }
    </style>
    <style>
        .subject-item label {
            width: 100%;
            display: block;
            padding: 5px;
            cursor: pointer;
        }

        .subject-item label:hover {
            background-color: #f8f9fa;
        }

        .subject-checkbox {
            margin-right: 5px;
        }
    </style>
    <script>
        var selectedSubjects = <?= json_encode($selected_subjects) ?>;
       // alert(isChecked);
        var selected_floor = "<?= isset($selected_floor_id) ? $selected_floor_id : '' ?>";
        var selected_halls = "<?= isset($selected_hall_id) ? $selected_hall_id : '' ?>";
        $(document).ready(function() {
            // Define the selectedSubjects array globally if not already done
            var selectedSubjects = <?= json_encode($selected_subjects) ?>;  // Ensure this is outputting a valid JavaScript array

            // Function to fetch and render subjects
            function fetchAndCheckSubjects() {
        if ($('#exam').val() && $('#date').val()) {
            $.ajax({
                url: '<?= base_url("Seating/get_subjects") ?>',
                type: 'POST',
                data: {
                    exam_id: $('#exam').val(),
                    date: $('#date').val()
                },
                dataType: 'json',
                success: function(data) {
                    let subjectOptions = '';
                    data.subjects.forEach(function(subject) {
                        let isChecked = selectedSubjects.includes(subject.sub_id.toString()) ? 'checked' : '';
                        subjectOptions += `<li class="subject-item">
                            <label>
                                <input type="checkbox" name="subject_ids[]" value="${subject.sub_id}" class="subject-checkbox" ${isChecked}>
                                ${subject.subject_code} - ${subject.subject_name} (Batch: ${subject.batch}, Sem: ${subject.semester}, Students: ${subject.stud_count}) ${subject.stream_short_name}
                            </label>
                        </li>`;
                    });
                    $('#subjectList').html(subjectOptions);
                    validateSubjectSelection(); // Call validation after rendering
                },
                error: function() {
                    alert('Error loading subjects');
                    $('#subjectList').html('<li>No subjects available</li>');
                }
            });
        }
    }

    // Function to validate subject selection
    function validateSubjectSelection() {
        $('.subject-checkbox').on('change', function() {
            let checkedCount = $('.subject-checkbox:checked').length;
            if (checkedCount > 3) {
                alert("You can select a maximum of 3 subjects.");
                $(this).prop('checked', false); // Uncheck the last selection
            }
        });
    }

    // Initial call to fetch subjects
    fetchAndCheckSubjects();

            // Bind the change event to fetch subjects
            $('#exam, #date').change(fetchAndCheckSubjects);

            // Trigger the fetch operation on page load if both exam and date have pre-set values
            if ($('#exam').val() && $('#date').val()) {
                fetchAndCheckSubjects(); // Trigger this function on page load to handle pre-selected values
            }
        });




        $(document).ready(function () {
            const buildingSelect = $('#building');
            const floorSelect = $('#floor');
            const hallSelect = $('#hall');

            // When a building is selected, fetch floors for that building
            buildingSelect.change(function () {
                const buildingId = $(this).val(); // Store building ID
                $.ajax({
                    url: '<?= base_url("Seating/get_floors") ?>', // Assuming you have a route setup
                    type: 'GET',
                    data: { building_id: buildingId },
                    dataType: 'json',
                    success: function(data) {
                        let floorOptions = '<option value="">Select a floor</option>';
                        data.floors.forEach(function(floor) {
                            floorOptions += `<option value="${floor.floor}" ${floor.floor == selected_floor ? 'selected' : ''}>${floor.floor}</option>`;
                        });
                        floorSelect.html(floorOptions);
                        floorSelect.trigger('change'); // May need to trigger change to load halls
                    },
                    error: function () {
                        alert('Error loading floors');
                        floorSelect.html('<option value="">No floors available</option>');
                    }
                });
            });

            // When a floor is selected, fetch halls for that floor and building
      /*      floorSelect.change(function () {
                const floorId = $(this).val();
                const buildingId = buildingSelect.val(); // Use the stored building ID
                $.ajax({
                    url: '<?= base_url("Seating/get_halls") ?>', // Ensure correct API endpoint
                    type: 'GET',
                    data: {
                        floor_id: floorId,
                        building_id: buildingId // Pass building ID correctly
                    },
                    dataType: 'json',
                    success: function (data) {
                        let hallOptions = '<option value="">Select Halls</option>';
                        if (data.halls.length > 0) {
                            data.halls.forEach(function (hall) {
                                hallOptions += `<option value="${hall.id}" ${hall.id == selected_halls ? 'selected' : ''}>${hall.hall_no}</option>`;
                            });
                        } else {
                            hallOptions = '<option value="">No halls found</option>';
                        }
                        hallSelect.html(hallOptions);
                        hallSelect.trigger('change'); // May need to trigger change to load halls
                    },
                    error: function () {
                        alert('Error loading halls');
                        hallSelect.html('<option value="">No halls available</option>');
                    }
                });
            });*/
        });
        $(document).ready(function() {

            var selected_halls = "<?= isset($selected_halls) ? $selected_halls : '' ?>";

            //    alert(selected_halls);

            const buildingSelect = $('#building');
            const floorSelect = $('#floor');
            const hallList = $('#hallList'); // This is your list element for halls

            // Function to fetch and render halls
            function fetchAndRenderHalls() {
                const floorId = floorSelect.val();
                const buildingId = buildingSelect.val();
                if (floorId && buildingId) {
                    $.ajax({
                        url: '<?= base_url("Seating/get_halls") ?>',
                        type: 'GET',
                        data: {
                            floor_id: floorId,
                            building_id: buildingId
                        },
                        dataType: 'json',
                        success: function(data) {
                            let hallOptions = '';
                            if (data.halls.length > 0) {
                                data.halls.forEach(function(hall) {
                                    let isChecked = selected_halls.includes(hall.id.toString()) ? 'checked' : '';
                                    hallOptions += `<li class="hall-item">
                                        <label>
                                            <input type="checkbox" name="hall_ids[]" value="${hall.id}" class="hall-checkbox" ${isChecked}>
                                            ${hall.hall_no} - Total Seats : ${hall.capacity}
                                        </label>
                                    </li>`;
                                });
                            } else {
                                hallOptions = '<li>No halls found</li>';
                            }
                            hallList.html(hallOptions);
                        },
                        error: function() {
                            alert('Error loading halls');
                            hallList.html('<li>No halls available</li>');
                        }
                    });
                }
            }

            // Bind change event to building and floor selectors
            buildingSelect.change(fetchAndRenderHalls);
            floorSelect.change(fetchAndRenderHalls);

            // Initial fetch if values are pre-selected
            if (buildingSelect.val() && floorSelect.val()) {
                fetchAndRenderHalls();
            }
        });



    </script>
</head>

<body>
    <div class="container">
        <h1 class="mb-4">Exam Seating Arrangement</h1>
        <!-- Place this within the <body> tag, above the <h1> -->
        <div class="container">
            <form action="<?= base_url('seating/index'); ?>" method="POST">
                <div class="form-group">
                    <label for="exam">Select Exam:</label>
                    <select id="exam" name="exam_id" class="form-control select2">
                        <?php foreach ($exams as $exam): ?>
                            <option value="<?= $exam['exam_id'] ?>" <?= ($exam['exam_id'] == $selected_exam) ? 'selected' : '' ?>><?= $exam['exam_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Select Date:</label>
                    <input type="date" id="date" name="date" class="form-control" value="<?= $selected_date ?>">
                </div>
                <!-- <div class="form-group">
                    <label for="subject">Select Subjects (max 3):</label>
                    <input type="text" id="searchSubject" placeholder="Search subjects..." class="form-control mb-2">
                    <ul id="subjectList" style="height: 150px; overflow-y: scroll; list-style-type: none; padding: 0;">
                        <?php foreach ($subjects as $subject): ?>
                            <li class="subject-item">
                                <label>
                                    <input type="checkbox" name="subject_ids[]" value="<?= $subject['sub_id'] ?>"
                                        class="subject-checkbox">
                                    <?= $subject['sub_id'] . '-' . $subject['subject_name'] ?>
                                </label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div> -->
                <div class="form-group">
                    <label for="subject">Select Subjects (max 3):</label>
                    <input type="text" id="searchSubject" placeholder="Search subjects..." class="form-control mb-2">
                    <ul id="subjectList" style="height: 150px; overflow-y: scroll; list-style-type: none; padding: 0;">
                        <!-- Subject checkboxes will be populated here by JavaScript -->
                    </ul>
                </div>

                <div class="form-group">
                    <label for="building">Select Building:</label>
                    <select id="building" name="building_id" class="form-control select2">
                    <option value="">Select Building</option>
                        <?php foreach ($buildings as $building): ?>
                            <option value="<?= $building['id'] ?>" <?= ($building['id'] == $selected_building) ? 'selected' : '' ?>><?= $building['building_name'] ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="floor">Select Floor:</label>
                    <select id="floor" name="floor_id" class="form-control select2">
                        <?php foreach ($floors as $floor): ?>
                            <option value="<?= $floor['floor'] ?>" <?= ($floor['floor'] == $selected_floor) ? 'selected' : '' ?>><?= $floor['floor'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                 <!-- <div class="form-group">
                     <label for="hall">Select Halls (no selection limit):</label>
                     <select id="hall" name="hall_ids[]" class="form-control select2" multiple>
                         <?php foreach ($halls as $hall): ?>
                             <option value="<?= $hall['id'] ?>" <?= in_array($hall['id'], $selected_halls) ? 'selected' : '' ?>><?= $hall['hall_no'] ?></option>
                         <?php endforeach; ?>
                     </select>
                 </div> -->
                <div class="form-group">
                    <label for="hall">Select Halls (no selection limit):</label>
                    <ul id="hallList" style="height: 150px; overflow-y: scroll; list-style-type: none; padding: 0;">
                        <!-- Hall checkboxes will be populated here by JavaScript -->
                    </ul>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <?php // echo"<pre>";print_r($seatingArrangement); exit; ?>
        <?php foreach ($seatingArrangement as $floor => $halls): ?>
    <?php foreach ($halls as $hall_no => $info): ?>
        <div class="card mb-4">
            <div class="card-header bgdynamic">
                <h4 class="" style="color: black;">Hall: <?= $hall_no ?> - Floor: <?= $floor ?></h4>
            </div>
            <div class="card-body">
                <div style="grid-template-columns: repeat(<?= $info['rows'] ?>, 1fr);" class="hall-matrix">
                    <?php
                    $total_seats = ($info['rows'] * $info['columns']);
                    $seat_index = 0;

                    // Group students by subject_id for the current hall
                    $grouped_students = [];
                    foreach ($info['seats'] as $student) {
                        if (!empty($student)) { // Ensure null values are not grouped
                            $grouped_students[$student['subject_id']][] = $student;
                        }
                    }

                    // Extract subject IDs sorted by student count (most frequent first)
                    uasort($grouped_students, function ($a, $b) {
                        return count($b) - count($a);
                    });

                    $subject_ids = array_keys($grouped_students);
                    $subject_count = count($subject_ids);

                    // Prevent division by zero
                    if ($subject_count == 0) {
                        echo "<p class='text-danger'>No subjects available for Hall $hall_no.</p>";
                        continue;
                    }

                    // Initialize seat assignment array
                    $assigned_seats = array_fill(0, $total_seats, null);

                    // Assign subjects in alternating pattern
                    $main_subject = $subject_ids[0]; // The most frequent subject
                    $other_subjects = array_slice($subject_ids, 1); // Remaining subjects

                    $row_count = $info['columns']; // Total number of rows
                    $col_count = $info['rows']; // Total number of columns

                    // Fill the alternate pattern (A, B, A, C, A, B, A, C)
                    $seat_position = 0;

                    if ($subject_count == 1) {
                        // If only one subject exists, insert empty rows
                        $current_subject_id = $subject_ids[0];

                        for ($row = 0; $row < $row_count; $row++) {
                            if ($row % 2 == 1) {
                                // Empty row: Fill entire row with NULL
                                for ($col = 0; $col < $col_count; $col++) {
                                    $assigned_seats[$seat_position++] = null;
                                }
                            } else {
                                // Fill row with subject A
                                for ($col = 0; $col < $col_count; $col++) {
                                    if (!empty($grouped_students[$current_subject_id])) {
                                        $assigned_seats[$seat_position++] = array_shift($grouped_students[$current_subject_id]);
                                    } else {
                                        $assigned_seats[$seat_position++] = null; // Empty if no student
                                    }
                                }
                            }
                        }
                    } else {
                        // Regular alternate subject allocation when more than one subject exists
                        for ($row = 0; $row < $row_count; $row++) {
                            $current_subject_id = ($row % 2 == 0) ? $main_subject : $other_subjects[($row / 2) % count($other_subjects)];

                            for ($col = 0; $col < $col_count; $col++) {
                                if (!empty($grouped_students[$current_subject_id])) {
                                    $assigned_seats[$seat_position++] = array_shift($grouped_students[$current_subject_id]);
                                } else {
                                    $assigned_seats[$seat_position++] = null; // Empty seat if no student available
                                }
                            }
                        }
                    }
                        // Collect all remaining students that were not assigned
                        foreach ($grouped_students as $sub_id => $students) {
                            foreach ($students as $student) {
                                $remaining_students_list[] = $student;
                            }
                        }

                        // Fill the last row with remaining students (if any exist)
                        if (!empty($remaining_students_list)) {
                            for ($col = 0; $col < $col_count; $col++) {
                                if (!empty($remaining_students_list)) {
                                    $assigned_seats[($row_count - 1) * $col_count + $col] = array_shift($remaining_students_list);
                                } else {
                                    break; // Stop filling if no students left
                                }
                            }
                        }


                    // Render the seating arrangement
                    foreach ($assigned_seats as $seat): ?>
                        <div class="seat">
                            <?php if ($seat): ?>
                                <?= "{$seat_index}. {$seat['enrollment_no']}<br><strong>{$seat['subject_name']}</strong>"; ?>
                                <?php $seat_index++; ?>
                            <?php else: ?>
                                <!-- Empty seat placeholder -->
                                <br>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>


    </div>
</body>

</html>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchBox = document.getElementById('searchSubject');
        searchBox.addEventListener('input', function () {
            const searchText = this.value.toLowerCase();
            const items = document.querySelectorAll('#subjectList .subject-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchText) ? "" : "none";
            });
        });
    });
   /* document.addEventListener("DOMContentLoaded", function () {
        const checkboxes = document.querySelectorAll('#subjectList .subject-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const checkedCheckboxes = document.querySelectorAll('#subjectList .subject-checkbox:checked');
                if (checkedCheckboxes.length > 3) {
                    alert('You can only select up to 3 subjects.');
                    checkbox.checked = false;
                }
            });
        });
    });*/
</script>