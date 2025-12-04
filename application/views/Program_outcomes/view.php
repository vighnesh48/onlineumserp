<link rel="stylesheet" href="<?= base_url('assets/stylesheets/jPages.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/stylesheets/select2.css') ?>">
<script src="<?= base_url('assets/javascripts/jPages.js') ?>"></script>
<script src="<?= base_url('assets/javascripts/select2.min.js') ?>"></script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Program Outcomes Master</a></li>
    </ul>

    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Program Outcomes
            </h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <div class="pull-right col-xs-12 col-sm-auto">
                        <a class="btn btn-primary btn-labeled" href="<?= base_url($currentModule . "/add/" . $stream_id . "/" . $campus_id) ?>">
                            <span class="btn-label icon fa fa-plus"></span>Add Program Outcomes
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
                    <span class="panel-title"><b> Course Name:<?=$subject['course_short_name'];?> , Program Name:<?=$subject['stream_name'];?></b></span><button class="btn btn-info" data-toggle="modal" data-target="#importModal" style="float:right">
				<i class="fa fa-upload"></i> Import from Excel
			</button>
                </div>
                    <div class="panel-body">
                        <div class="table-info">
                            <table id="poTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Campus ID</th>
                                        <th>Program ID</th>
                                        <th>PO Number</th>
                                        <th>PO Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; foreach ($program_outcome_det as $row) { ?>
                                        <tr <?= $row['status'] == 0 ? "style='background-color:#FBEFF2'" : '' ?>>
                                            <td><?= $i++ ?></td>
                                            <td><?= $row['campus_id'] ?></td>
                                            <td><?= $row['program_id'] ?></td>
                                            <td><?= htmlspecialchars($row['po_number']) ?></td>
                                            <td><?= htmlspecialchars($row['po_description']) ?></td>
                                            <td>
                                                <a href="<?= base_url($currentModule . '/edit/' . $row['id']) ?>"><i class="fa fa-edit"></i></a>
                                                <a href="<?= base_url($currentModule . '/' . ($row['status'] == 1 ? 'disable' : 'enable') . '/' . $row['id']) ?>">
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

<!-- DataTables for Export -->
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
    $('#poTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['excelHtml5'],
        order: [[0, 'asc']],
        columnDefs: [{ orderable: false, targets: -1 }]
    });
});
</script>
<!-- Excel Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('program_outcomes/import_excel') ?>" enctype="multipart/form-data" onsubmit="return validateExcel();">
	<input type="hidden" name="subject_id" value="<?= $subject_id ?>">
	<input type="hidden" name="campus_id" value="<?= $campus_id ?>">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title text-white">Import POs from Excel</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <p><strong>Note:</strong> Excel must follow this format:</p>
          <a href="<?= base_url('uploads/program_outcomes_template.xlsx') ?>" class="btn btn-sm btn-success mb-2">
            <i class="fa fa-download"></i> Download Format
          </a>

          <div class="form-group">
            <label>Select Excel File (.xls or .xlsx)</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xls,.xlsx" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Import</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function validateExcel() {
  const fileInput = document.getElementById('excel_file');
  const filePath = fileInput.value;
  const allowedExtensions = /(\.xls|\.xlsx)$/i;

  if (!allowedExtensions.exec(filePath)) {
    alert('Please upload a valid Excel file (.xls or .xlsx).');
    fileInput.value = '';
    return false;
  }
  return true;
}
</script>