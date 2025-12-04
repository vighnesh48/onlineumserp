<!DOCTYPE html>
<html>
<head>
    <title>Bank Accounts</title>
    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- DataTables Bootstrap 3 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container-fluid mt-4" style="margin-top:70px;">
    <div class="panel panel-primary">
        <div class="panel-heading clearfix">
            <h4 class="panel-title pull-left" style="padding-top:7px;">Bank Accounts</h4>
            <a href="<?= site_url('bankaccount/create') ?>" class="btn btn-default btn-sm pull-right">➕ Add Bank Account</a>
            <a href="<?= site_url('bankaccount/upload_bankaccount_data') ?>" class="btn btn-default btn-sm pull-right">➕ Import Excel-Bank Accounts</a>
        </div>
        <div class="panel-body">

            <!-- Flash Messages -->
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>✅ Success!</strong> <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>⚠️ Error!</strong> <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <table id="bankTable" class="table table-striped table-bordered" width="100%">
                <thead>
                    <tr class="info">
                        <th>#</th>
                        <th>Institute Name</th>
                        <th>Account Holder Name</th>
                        <th>Account No.</th>
                        <th>Bank Name</th>
                        <th>IFSC</th>
                        <th>Branch</th>
                        <th>Type</th>
                        <th>Signatory Authority</th>
                        <th>Signatory Authority Name</th>
                        <th>POC</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($accounts as $acc): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= html_escape($acc->institute_name) ?></td>
                        <td><?= html_escape($acc->account_name) ?></td>
                        <td><?= html_escape($acc->account_number) ?></td>
                        <td><?= html_escape($acc->bank_name) ?></td>
                        <td><?= html_escape($acc->ifsc_code) ?></td>
                        <td><?= html_escape($acc->branch_name) ?></td>
                        <td><?= html_escape($acc->account_type) ?></td>
                        <td><?= html_escape($acc->signatory_authority)?></td>
                        <td><?= html_escape(trim($acc->signatory_authority_names1 . ', ' . $acc->signatory_authority_names2, ', ')) ?></td>
                        <td><?= html_escape($acc->poc_name) . ' (' . $acc->poc_number . ')' ?></td>
                        <td>
                            <span class="label <?= $acc->status=='Active' ? 'label-success' : 'label-danger' ?>">
                                <?= $acc->status ?>
                            </span>
                        </td>
                        <td><?= html_escape($acc->remarks) ?></td>
                        <td>
                            <a href="<?= site_url('bankaccount/edit/'.$acc->id) ?>" class="btn btn-xs btn-warning">✏️ Edit</a>
                            <button class="btn btn-xs btn-danger delete-btn" 
                                    data-id="<?= $acc->id ?>" 
                                    data-bank="<?= html_escape($acc->bank_name) ?>">
                                🗑️ Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Single Reusable Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm Delete</h4>
      </div>
      <div class="modal-body" id="deleteModalBody"></div>
      <div class="modal-footer">
        <form id="deleteForm" method="post">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
    // DataTables optimized settings
    $('#bankTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy','excel'],
        pageLength: 100,
        deferRender: true
    });

    // Delete modal handler
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        let bankName = $(this).data('bank');
        $('#deleteModalBody').html(`Are you sure you want to delete <strong>${bankName}</strong> account?`);
        $('#deleteForm').attr('action', "<?= site_url('bankaccount/delete/') ?>" + id);
        $('#deleteModal').modal('show');
    });

    // Auto fade-out flash messages
    setTimeout(() => {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
</body>
</html>
