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
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?= base_url($currentModule) ?>">Event </a></li>
    </ul>
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Events </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <br />
                    <span id="flash-messages" style="color:Green;padding-left:50px;">
                        <?php if (!empty($this->session->flashdata('message_event_success'))) {
                            echo $this->session->flashdata('message_event_success');
                        } ?></span>
                    <span id="flash-message" style="color:red;padding-left:50px;">
                        <?php if (!empty($this->session->flashdata('message_event_error'))) {
                            echo $this->session->flashdata('message_event_error');
                        } ?></span>
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
            <div class="pull-right col-xs-12 col-sm-auto">
            </div>
        </div>
        <div class="row ">
            <?php if ($this->session->flashdata('message_event')) : ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('message_event'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading ">
                        <span class="panel-title">Upload Event Pdf File </span>

                        <span id="message" style="color:red;padding-left:200px;"></span>
                        <div class="holder"></div>
                    </div>
                    <div class="panel-body">
                        <div>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Event Name:</th>
                                    <td><?= $event['event_name'] ?></td>
                                </tr>
                                <tr>
                                    <th>Event Date:</th>
                                    <td><?= date('d M Y', strtotime($event['start_date'])) ?> - <?= date('d M Y', strtotime($event['end_date'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Event Address:</th>
                                    <td><?= $event['event_address'] ?></td>
                                </tr>
                                <tr>
                                    <th>Event Description:</th>
                                    <td><?= $event['event_description'] ?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="table-info">

                            <form action="<?= base_url($currentModule . '/save_event_images') ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm(event)">
                                <input type="hidden" value="<?= $event_id ?>" name="event_id" />

                                <div class="file-input-group">
                                    <label for="event_pdf">Select Event PDF File:</label>
                                    <input type="file" name="event_pdf" id="event_pdf" class="event-file-input" accept="application/pdf" onchange="validatePDF(this)">
                                    <span class="text-muted">Only PDF files allowed (Max: 5MB)</span>
                                    <div id="file-error" class="text-danger" style="display: none;"></div>
                                </div>

                                <button type="submit" class="btn btn-primary">Upload PDF</button>
                                <a href="<?= base_url('Event'); ?>" class="btn btn-primary btn-labeled">
                    <span class="btn-label icon fa fa-arrow-left"></span>Back
                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function validatePDF(input) {
        let file = input.files[0];
        let errorDiv = document.getElementById("file-error");

        if (!file) {
            errorDiv.innerText = "Please select a PDF file.";
            errorDiv.style.display = "block";
            return false;
        }

        let fileSize = file.size / 1024 / 1024;
        let fileType = file.type;

        if (fileType !== "application/pdf") {
            errorDiv.innerText = "Invalid file type. Please upload a PDF.";
            errorDiv.style.display = "block";
            input.value = "";
            return false;
        }

        if (fileSize > 5) {
            errorDiv.innerText = "File size exceeds 5MB. Please upload a smaller PDF.";
            errorDiv.style.display = "block";
            input.value = "";
            return false;
        }

        errorDiv.style.display = "none";
        return true;
    }

    function validateForm(event) {
        let fileInput = document.getElementById("event_pdf");

        if (!fileInput.files.length) {
            alert("Please select a PDF file.");
            event.preventDefault();
            return false;
        }

        if (!validatePDF(fileInput)) {
            event.preventDefault();
            return false;
        }

        return true;
    }
</script>


<style>
    .file-input-group {
        margin-bottom: 15px;
    }
</style>