<!DOCTYPE html>
<html>
<head>
    <title>Fees Challan Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-4">
    <h3 class="mb-3 text-primary">💰 Fees Challan Deposited Report</h3>

    <?php 
        $today = date('Y-m-d'); 
        $selFdate = isset($_POST['fdate']) ? $_POST['fdate'] : $today;
        $selTdate = isset($_POST['tdate']) ? $_POST['tdate'] : $today;
        $selCampus = isset($_POST['campus']) ? $_POST['campus'] : 'nashik';
    ?>

    <form method="post" class="row g-3 mb-4">
        <div class="col-md-2">
            <label>From Date</label>
            <input type="date" name="fdate" class="form-control" value="<?= $selFdate ?>">
        </div>
        <div class="col-md-2">
            <label>To Date</label>
            <input type="date" name="tdate" class="form-control" value="<?= $selTdate ?>">
        </div>
        <div class="col-md-2">
            <label>Type</label>
            <select name="status" class="form-select">
                <option value="">All</option>
                <option value="Academic" <?= (isset($_POST['status']) && $_POST['status']=='Academic') ? 'selected' : '' ?>>Academic</option>             
                <option value="Uniform" <?= (isset($_POST['status']) && $_POST['status']=='Uniform') ? 'selected' : '' ?>>Uniform</option>
				<option value="Hostel" <?= (isset($_POST['status']) && $_POST['status']=='Hostel') ? 'selected' : '' ?>>Hostel</option>
                <option value="Transport" <?= (isset($_POST['status']) && $_POST['status']=='Transport') ? 'selected' : '' ?>>Transport</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Campus</label>
            <select name="campus" class="form-select">
                <option value="nashik" <?= ($selCampus=='nashik') ? 'selected' : '' ?>>Nashik</option>
                <option value="sijoul" <?= ($selCampus=='sijoul') ? 'selected' : '' ?>>Sijoul</option>
                <option value="sf" <?= ($selCampus=='sf') ? 'selected' : '' ?>>SF Nashik</option>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" name="search" value="1" class="btn btn-primary me-2">Search</button>
            <?php if (!empty($results)) { ?>
            <a href="<?= base_url('Feesummary/export_excel_challan?fdate='.$selFdate.'&tdate='.$selTdate.'&status='.($_POST['status']??'').'&campus='.$selCampus); ?>" class="btn btn-success">Download Excel</a>
            <?php } ?>
        </div>
    </form>

    <?php if (!empty($results)) { 
        $total = array_sum(array_column($results, 'amount'));
    ?>
    <div class="table-responsive bg-white shadow-sm p-3 rounded">
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Sr.No.</th>
					<th>Challan No.</th>
					<th>Bank Ref No</th>
					<th>Enrollment No</th>
                    <th>Name</th>
                    <th>Stream</th>
                    <th>Amount</th>
                    <th>Payment Type</th>
                    <th>Created On</th>
                    <th>SU Bank</th>
                    <th>Academic Year</th>
                    <th>Campus</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;
				foreach($results as $r){ ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $r['college_receiptno']; ?></td>
                    <td><?= $r['receipt_no']; ?></td>
                    <td><?= $r['enrollment_no']; ?></td>
                    <td><?= $r['first_name'].' '.$r['last_name']; ?></td>
                    <td><?= $r['stream_short_name']; ?></td>
                    <td><?= number_format($r['amount'],2); ?></td>
                    <td><?= $r['fees_paid_type']; ?></td>
                    <td><?= date('d-M-Y H:i', strtotime($r['created_on'])); ?></td>
                    <td><?= $r['student_bank']; ?></td>

                    <td><?= $r['academic_year']; ?></td>
                    <td><?= ucfirst($selCampus); ?></td>
                </tr>
                <?php $i++;} ?>
            </tbody>
            <tfoot>
                <tr class="table-warning fw-bold">
                    <td colspan="5" class="text-end">Total:</td>
                    <td><?= number_format($total,2); ?></td>
                    <td colspan="5"></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php } else if ($_SERVER['REQUEST_METHOD'] === 'POST') { ?>
        <div class="alert alert-warning mt-3">No records found for the selected duration.</div>
    <?php } ?>
</div>
</body>
</html>