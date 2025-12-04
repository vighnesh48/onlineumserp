<!DOCTYPE html>
<html>
<head>
    <title>Upload Investment Data</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background-color: #f5f7fa;
        }
        .breadcrumb-page {
            margin-bottom: 10px;
            background: #fff;
            border-radius: 4px;
            padding: 8px 15px;
            font-size: 13px;
        }
        .page-header {
            margin-top: 0;
            margin-bottom: 20px;
        }
        .page-header h1 {
            font-size: 20px;
            margin: 0;
            font-weight: 600;
            color: #34495e;
        }
        .panel {
            border-radius: 6px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .panel-heading {
            background: #337ab7 !important;
            color: #fff !important;
            border-radius: 6px 6px 0 0;
            padding: 12px 15px;
        }
        .panel-heading h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }
        label.control-label {
            font-weight: 600;
            color: #555;
        }
        .btn-primary {
            background: #337ab7;
            border-color: #2e6da4;
            font-weight: 600;
        }
        .upload-info {
            margin-top: 20px;
            font-size: 13px;
            line-height: 1.5;
            color: #444;
        }
        .upload-info i {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div id="content-wrapper" class="container-fluid" style="margin-top:10px;">

    <!-- Breadcrumb -->
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active">Upload Investment Data</li>
    </ul>

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-6 text-left">
                <i class="fa fa-upload text-primary"></i>&nbsp;&nbsp;Upload Investment Data
            </h1>
        </div>
    </div>
<?php if (!empty($upload_summary)): ?>
    <div class="alert alert-info">
        <?= $upload_summary ?>
    </div>
<?php endif; ?>

    <!-- Panel -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><i class="fa fa-file-excel-o"></i> Investment Details Upload</h3>
                </div>
                <div class="panel-body">
                    
                    <!-- Upload Form -->
                    <form class="form-horizontal" action="<?= base_url($currentModule . 'investment/upload_investment_data') ?>" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="file">Select File:</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="file" id="file"
                                           required
                                           accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" id="submit" name="Import"
                                            class="btn btn-primary btn-lg"
                                            data-loading-text="Loading...">
                                        <i class="fa fa-upload"></i> Submit
                                    </button>
                                    <p class="upload-info">
                                        <span style="color:red;">*</span>
                                        <b>Please provide investment data in the specified format.</b><br>
                                        👉 Download <b><u>Fixed Deposit</u></b> sample format here: 
                                        <a href="https://erp.sandipuniversity.com/Fixed_deposit_upload_template.xlsx" target="_blank">
                                            <i class="fa fa-file-excel-o" style="font-size:20px;color:green"></i>
                                        </a><br>👉 Download <b><u>Mediclaim</u></b> sample format here: 
                                        <a href="https://erp.sandipuniversity.com/Mediclaim_upload_template.xlsx" target="_blank">
                                            <i class="fa fa-file-excel-o" style="font-size:20px;color:green"></i>
                                        </a><br>
										👉 Download <b><u>Insurance Policy</u></b> sample format here: 
                                        <a href="https://erp.sandipuniversity.com/Insurance_policy_upload_template.xlsx" target="_blank">
                                            <i class="fa fa-file-excel-o" style="font-size:20px;color:green"></i>
                                        </a><br>
										👉 Download <b><u>Equity</u></b> sample format here: 
                                        <a href="https://erp.sandipuniversity.com/Equity_upload_template.xlsx" target="_blank">
                                            <i class="fa fa-file-excel-o" style="font-size:20px;color:green"></i>
                                        </a><br>👉 Download <b><u>Mutual Fund</u></b> sample format here: 
                                        <a href="https://erp.sandipuniversity.com/mutual_fund_upload_template.xlsx" target="_blank">
                                            <i class="fa fa-file-excel-o" style="font-size:20px;color:green"></i>
                                        </a><br>
                                        <!--span class="text-danger">Note:</span> Fields marked yellow in the Excel are mandatory.-->
                                    </p>
                                </div>
                            </div>
                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    $('#file').on('change', function() {
        var filePath = $(this).val();
        var allowedExtensions = /(\.xls|\.xlsx)$/i;
        if (!allowedExtensions.exec(filePath)) {
            alert('Please upload file having extensions .xls or .xlsx only.');
            $(this).val(''); 
        }
    });
});
</script>
</body>
</html>
