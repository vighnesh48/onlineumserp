<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Attendance Upload - Faculty Status</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .modal-header {
            background-color: #0056b3;
            /* Deep Blue Header */
            color: white;
        }

        .modal-body {
            font-size: 16px;
            padding: 20px;
        }

        .list-group-item-danger {
            background-color: #ffdddd;
            border-left: 4px solid red;
            color: #721c24;
            font-weight: bold;
        }

        .list-group-item-danger::before {
            content: "⚠️ ";
            font-size: 18px;
        }

        .alert-success {
            background-color: #d4edda;
            border-left: 4px solid green;
            color: #155724;
            font-weight: bold;
        }

        .modal-footer {
            justify-content: center;
        }

        .btn-close {
            background-color: #28a745;
            /* Green close button */
            color: white;
        }

        .btn-close:hover {
            background-color: #218838;
        }

        .instruction-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 5px solid #007bff;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-exclamation-circle"></i> Faculty Attendance Upload Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.href='<?= base_url('Event') ?>'">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger">
                                <strong><i class="fas fa-exclamation-triangle"></i> Important:</strong> The following issues were found while uploading the attendance file:
                            </div>
                            <ul class="list-group">
                                <?php foreach ($errors as $error) : ?>
                                    <li class="list-group-item list-group-item-danger"><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="instruction-box">
                                <h6><i class="fas fa-info-circle"></i> How to Fix These Errors?</h6>
                                <ul>
                                    <li><b>Missing Enrollment Number:</b> Ensure the student is registered in the system before uploading.</li>
                                    <li><b>Duplicate Entry:</b> A student cannot be marked twice for the same event and date.</li>
                                    <li><b>Invalid Date Format:</b> Ensure the date is in <code>YYYY-MM-DD</code> format (e.g., <b>2025-03-10</b>).</li>
                                    <li><b>Incorrect File Format:</b> Upload only <b>.xls</b> or <b>.xlsx</b> files.</li>
                                </ul>
                            </div>

                        <?php endif; ?>

                        <?php if (!empty($success)) : ?>
                            <div class="alert alert-success mt-3">
                                <strong><i class="fas fa-check-circle"></i> Success:</strong> <?= $success ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-close" onclick="window.location.href='<?= base_url('Event') ?>'">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#errorModal").modal("show");
        });
    </script>

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>

</html>