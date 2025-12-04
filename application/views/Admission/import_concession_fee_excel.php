<script src="<?= base_url('assets/javascripts/bootstrap-datepicker.js') ?>"></script>
<link href="<?= site_url() ?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?= site_url() ?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Admission</a></li>
        <li class="active"><a href="#">Concession Fee Update</a></li>
    </ul>

    <div class="page-header">
        <h1 class="text-center text-left-sm">
            <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Concession Fee Update
        </h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card p-3 shadow-sm" style="background-color:#f9f9f9;">
                <div class="row align-items-end">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Select Concession Type</label>
                            <select name="concession_type" id="concession_type" class="form-control">
                                <option value="">-- Select --</option>
                                <?php
                                $selected_type = isset($conc_types) ? $conc_types : $this->input->post('concession_type');

                                foreach ($concession_types as $row):
                                ?>
                                    <option value="<?= $row->concession_type ?>" <?= ($row->concession_type == $selected_type) ? 'selected' : '' ?>>
                                        <?= $row->concession_type ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <form id="downloadForm" method="post" action="<?= base_url('Ums_admission/download_concession_excel') ?>">
                            <input type="hidden" name="concession_type" id="download_concession_type">
                            <label>&nbsp;</label><br>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fa fa-download"></i> Download Excel
                            </button>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <form id="importForm" method="post" enctype="multipart/form-data" action="<?= base_url('Ums_admission/import_concession_fee_excel') ?>">
                            <?php $selected_type = isset($conc_types) ? $conc_types : $this->input->post('concession_type'); ?>

                            <?php if (!empty($selected_type)): ?>
                                <input type="hidden" name="conc_type" id="import_concession_type" value="<?= $selected_type ?>">
                            <?php else: ?>
                                <input type="hidden" name="conc_type" id="import_concession_type">
                            <?php endif; ?>

                            <div class="form-group">
                                <label>Upload Excel File</label>
                                <input type="file" name="excel_file" class="form-control" required accept=".xls,.xlsx">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-2">
                                <i class="fa fa-upload"></i> Import Excel
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        const mainDropdown = document.getElementById('concession_type');
        const downloadInput = document.getElementById('download_concession_type');
        const importInput = document.getElementById('import_concession_type');

        mainDropdown.addEventListener('change', () => {
            downloadInput.value = mainDropdown.value;
            importInput.value = mainDropdown.value;
        });

        document.getElementById('importForm').addEventListener('submit', function(e) {
            if (!importInput.value) {
                alert('Please select a Concession Type before importing Excel.');
                e.preventDefault();
            }
        });
    </script>
    <hr>
<br>
    <div class="row mt-3">
        <div class="col-md-12">
            <?php if ($this->session->flashdata('message')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('message') ?></div>
            <?php elseif ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($excel_data)): ?>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="panel">
                    <div id="dashboard-recent" class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <?php if (!empty($excel_data)): ?>
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <strong>Imported Concession Data Preview</strong>
                                        </div>
                                        <div class="panel-body table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <?php foreach ($excel_data[1] as $col_name): ?>
                                                            <th><?= $col_name ?></th>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 2; $i <= count($excel_data); $i++): ?>
                                                        <tr>
                                                            <?php foreach ($excel_data[$i] as $val): ?>
                                                                <td><?= $val ?></td>
                                                            <?php endforeach; ?>
                                                        </tr>
                                                    <?php endfor; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <form method="post" action="<?= base_url('Ums_admission/save_imported_concession_data') ?>">
                            <input type="hidden" name="uploaded_file" value="<?= isset($uploaded_file) ? $uploaded_file : '' ?>">

                            <?php $selected_type = isset($conc_types) ? $conc_types : $this->input->post('concession_type'); ?>
                            <input type="hidden" name="conc_type" value="<?= $selected_type ?>">
                            <div class="text-right" style="margin-top:10px;">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-database"></i>Update Excel Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>