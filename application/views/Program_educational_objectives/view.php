<link rel="stylesheet" href="<?= base_url('assets/stylesheets/jPages.css') ?>">
<script src="<?= base_url('assets/javascripts/jPages.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/stylesheets/select2.css') ?>">
<script src="<?= base_url('assets/javascripts/select2.min.js') ?>"></script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Program Educational Objective Master</a></li>
    </ul>

    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Program Educational Objectives
            </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <div class="pull-right col-xs-12 col-sm-auto">
                        <a class="btn btn-primary btn-labeled" href="<?= base_url($currentModule . "/add/" . $stream_id . "/" . $campus_id) ?>">
                            <span class="btn-label icon fa fa-plus"></span>Add Program Educational Objective
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php } ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">List</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <table id="peoTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Program</th>
                                        <th>PEO Number</th>
                                        <th>PEO Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($peo_list as $row) { ?>
                                        <tr <?= $row['status'] == 0 ? "style='background-color:#FBEFF2'" : '' ?>>
                                            <td><?= $i++ ?></td>
                                            <td><?= htmlspecialchars($row['program_id']) ?></td>
                                            <td><?= htmlspecialchars($row['peo_number']) ?></td>
                                            <td><?= htmlspecialchars($row['peo_description']) ?></td>
                                            <td>
                                                <a href="<?= base_url($currentModule . '/edit/' . $row['peo_id']) ?>"><i class="fa fa-edit"></i></a>
                                                <a href="<?= base_url($currentModule . '/' . ($row['status'] == 1 ? 'disable' : 'enable') . '/' . $row['peo_id']) ?>">
                                                    <i class="fa <?= $row['status'] == 1 ? 'fa-ban' : 'fa-check' ?>" title="<?= $row['status'] == 1 ? 'Disable' : 'Enable' ?>"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>

<!-- DataTables Export Integration -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

<script>
$(document).ready(function() {
    $('#peoTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['excelHtml5'],
        order: [[0, 'asc']],
        columnDefs: [{ orderable: false, targets: -1 }]
    });
});
</script>
