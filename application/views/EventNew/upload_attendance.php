<script src="<?= base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<link href="<?= site_url() ?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?= site_url() ?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?= site_url() ?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
    .panel-heading {
        color: #8a6d3b;
        background-color: #fcf8e3;
        border-color: #faebcc;
    }
</style>


<?php
$astrik = '<sup class="redasterik" style="color:red">*</sup>';
//echo "<pre>";
//echo $total_fees['fee_paid'];
// print_r($student_details);
?>
<script>
    $(document).ready(function() {
        <?php if ($this->session->flashdata('message_project_success')): ?>
            toastr.success("<?= addslashes($this->session->flashdata('message_project_success')); ?>", "Success");
        <?php endif; ?>

        <?php if ($this->session->flashdata('message_project_error')): ?>
            toastr.error("<?= addslashes(nl2br($this->session->flashdata('message_project_error'))); ?>", "Error");
        <?php endif; ?>
    });
</script>
<?php // print_r($event_id);exit;
?>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?= base_url($currentModule) ?>">Event </a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Upload Event Attendance Sheet</h1>
            <!-- <div class="col-xs-12 col-sm-8">
                <div class="row"> 
						<br/>				
					<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if (!empty($this->session->flashdata('message_project_success'))) {
                                echo $this->session->flashdata('message_project_success');
                            } ?></span>
					<span id="flash-message" style="color:red;padding-left:50px;">
						 <?php if (!empty($this->session->flashdata('message_project_error'))) {
                                echo $this->session->flashdata('message_project_error');
                            } ?></span>
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div> -->
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading ">
                        <span class="panel-title">Upload Event Attendance Sheet </span>

                        <span id="message" style="color:red;padding-left:200px;"></span>
                        <div class="holder"></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <form id="uploadForm" action="<?= base_url($currentModule . '/import_event_attendance_excel') ?>" method="post" enctype="multipart/form-data">
                                <table class="table table-bordered" style="width:800px;max-width:100%;">
                                    <tr>
                                        <td><label for="event_date">Select Event Date:</label></td>
                                        <td><input type="date" name="event_date" id="event_date" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="file">Choose Excel File:</label></td>
                                        <td><input type="file" name="file" id="file" accept=".xls,.xlsx"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="file">Download Excel Format:</label></td>
                                        <td><button class="btn btn-success" id="download_sample_excel"><i class="fa fa-download"></i></button>(Download Event Attendance Empty Excel Format Sheet)</td>
                                    </tr>
                                    <tr>
                                        <td><input type="hidden" name="event_id" value="<?php echo $event_id; ?>"></td>
                                        <td>
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                            <a href="<?= base_url($currentModule) ?>" class="btn btn-primary">Back</a>
                                        </td>
                                    </tr>
                                </table>
                            </form>

                        </div>
                    </div>

                </div>
                <style>
                    .instruction-box {
                        background-color: #f8f9fa;
                        padding: 15px;
                        border-radius: 5px;
                        border-left: 5px solid #007bff;
                        margin-top: 10px;
                    }
                </style>
                <div class="instruction-box">
                    <h6><i class="fas fa-info-circle"></i> <strong>Note while uploading atendance excel file :</strong> </h6>
                    <ul>
                        <li><b>Sample Excel Sheet :</b> Download Event Attendance Sample Excel Format Sheet and Fill Correct Detail.</li>
                        <li><b>Missing Enrollment Number:</b> Ensure the correct Enrollment Number before uploading.</li>
                        <li><b>Duplicate Entry:</b> A student cannot be marked twice for the same event and date.</li>
                        <li><b>Invalid Date Format:</b> Ensure the date is in <code>YYYY-MM-DD</code> format (e.g., <b>2025-03-10</b>).</li>
                        <li><b>Incorrect File Format:</b> Upload only <b>.xls</b> or <b>.xlsx</b> files.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul id="errorList"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('message_project_success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> <?= $this->session->flashdata('message_project_success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('message_project_error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Warning!</strong> <?= nl2br($this->session->flashdata('message_project_error')); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<script>
    $(document).ready(function() {
        $('#download_sample_excel').click(function() {
            window.location.href = "<?= base_url('Event/download_attendance_sample_excel') ?>";
        });
    });
</script>
<script>
    $(document).ready(function() {
        $("#uploadForm").submit(function(event) {
            var fileInput = $("#file").val();
            var eventDate = $("#event_date").val();

            if (fileInput === "" || eventDate === "") {
                alert("Error: Please select an Event Date and an Excel File before uploading.");
                event.preventDefault(); // Prevent form submission
                return false;
            }

            var fileExtension = fileInput.split('.').pop().toLowerCase();
            if ($.inArray(fileExtension, ['xls', 'xlsx']) === -1) {
                alert("Invalid file format! Please upload an Excel file (.xls or .xlsx).");
                event.preventDefault(); // Prevent form submission
                return false;
            }
        });

        $('#download_sample_excel').click(function(event) {
            event.preventDefault();
            window.location.href = "<?= base_url('Event/download_attendance_sample_excel') ?>";
        });
    });
</script>

<script>
    $(document).ready(function() {
        var errorMessage = "<?= addslashes(nl2br($this->session->flashdata('message_project_model_error'))); ?>";

        if (errorMessage) {
            var errorList = errorMessage.split("<br>").map(error => `<li>${error}</li>`).join("");
            $("#errorList").html(errorList);
            $("#errorModal").modal("show"); // Show the modal
        }
    });
</script>