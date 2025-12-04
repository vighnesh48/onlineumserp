<!DOCTYPE html>
<html>
<head>
    <title>Active Investments</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap.min.css">

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap.min.js"></script>
</head>
<body class="bg-light">
<div class="container-fluid" style="margin-top:80px;">
    <div class="panel panel-primary">
        <div class="panel-heading clearfix">
            <h4 class="panel-title pull-left" style="padding-top:7px;">Active Investments</h4>
            <a href="<?= site_url('investment/create') ?>" class="btn btn-default btn-sm pull-right">➕ Add Investment</a>
            <a href="<?= site_url('investment/upload_investment_data') ?>" class="btn btn-default btn-sm pull-right">➕ Import Excel-Investment</a>
        </div>
        <div class="panel-body">

            <!-- Flash messages -->
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="invTabs">
				<li class="active"><a data-type="Fixed Deposit" href="#fd" data-toggle="tab">Fixed Deposit</a></li>
				<li><a data-type="Mutual Fund" href="#mf" data-toggle="tab">Mutual Fund</a></li>
				<!--li><a data-type="Bond" href="#bond" data-toggle="tab">Bond</a></li-->
				<li><a data-type="Equity" href="#equity" data-toggle="tab">Equity</a></li>
				<li><a data-type="Insurance" href="#insurance" data-toggle="tab">Insurance</a></li>
				<li><a data-type="Mediclaim" href="#mediclaim" data-toggle="tab">Mediclaim</a></li>
				<!--li><a data-type="Others" href="#others" data-toggle="tab">Others</a></li-->
			</ul>


            <br>

            <!-- Table -->
            <table id="invTable" class="table table-bordered table-striped nowrap" style="width:100%">
                <thead>
                    <tr class="info">
                        <th>#</th>
                        <th>Type</th>

                        <!-- FD -->
                        <th class="fd">Investment No.</th>
                        <th class="fd">Bank / Institution</th>
                        <th class="fd">Account ID</th>
                        <th class="fd">Start Date</th>
						<th class="fd">Amount (₹)</th>
                        <th class="fd">Maturity Date</th>
                        <th class="fd">Maturity Amount (₹)</th>
                        <th class="fd">Rate (%)</th>
                        <th class="fd">POC Name/Number</th>
                        <th class="fd">Remarks</th>

                        <!-- Equity -->
                        <th class="equity">Company</th>
                        <th class="equity">Purchase Date</th>
                        <th class="equity">Stock Code</th>
                        <th class="equity">No. Shares</th>
                        <th class="equity">Market Value</th>
                        <th class="equity">Total Value</th>
                        <th class="equity">Broker</th>

                        <!-- Mutual Fund -->
                        <th class="mf">MF Company</th>
                        <th class="mf">Purchase Date</th>
                        <th class="mf">MF Code</th>
                        <th class="mf">Units</th>
                        <th class="mf">Price/Unit</th>
                        <th class="mf">Total Value</th>
                        <th class="mf">Broker</th>

                        <!-- Mediclaim -->
                        <th class="mediclaim">Insured Since</th>
                        <th class="mediclaim">Renewal Date</th>
                        <th class="mediclaim">Policy No</th>
                        <th class="mediclaim">Policy Holder</th>
                        <th class="mediclaim">Premium</th>
                        <th class="mediclaim">Sum Assured</th>
                        <th class="mediclaim">Plan</th>
                        <th class="mediclaim">Policy Name</th>

                        <!-- Insurance -->
                        <th class="insurance">Policy Date</th>
                        <th class="insurance">Maturity Year</th>
                        <th class="insurance">Maturity Date</th>
                        <th class="insurance">Policy Holder</th>
                        <th class="insurance">Nominee</th>
                        <th class="insurance">Policy No</th>
                        <th class="insurance">Premium</th>
                        <th class="insurance">Sum Assured</th>
                        <th class="insurance">Plan</th>
                        <th class="insurance">Company</th>

                        <!-- Last -->
                        <th>Status</th>
                        <th class="noExport">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($investments as $inv): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $inv->investment_type ?></td>

                        <!-- FD -->
                        <td><?= $inv->investment_number ?></td>
                        <td><?= $inv->bank_institution ?></td>
                        <td><?= $inv->account_id ?></td>
                        <td><?= date('d-m-Y', strtotime($inv->start_date)) ?></td>
						<td><?= number_format($inv->amount,2) ?></td>
                        <td><?= date('d-m-Y', strtotime($inv->maturity_date)) ?></td>
                       <td><?= number_format($inv->maturity_amount,2) ?></td>
                        <td><?= $inv->rate ?></td>
                        <td><?= $inv->poc_name ?><br><small><?= $inv->poc_number ?></small></td>
                        <td><?= $inv->remarks ?></td>

                        <!-- Equity -->
                        <td><?= $inv->company_name ?></td>
                        <td><?= !empty($inv->purchase_date)?date('d-m-Y',strtotime($inv->purchase_date)):'' ?></td>
                        <td><?= $inv->stock_code ?></td>
                        <td><?= $inv->no_of_shares ?></td>
                        <td><?= $inv->market_value ?></td>
                        <td><?= $inv->total_value ?></td>
                        <td><?= $inv->broker_name ?></td>

                        <!-- Mutual Fund -->
                        <td><?= $inv->mf_company ?></td>
                        <td><?= !empty($inv->mf_purchase_date)?date('d-m-Y',strtotime($inv->mf_purchase_date)):'' ?></td>
                        <td><?= $inv->mf_code ?></td>
                        <td><?= $inv->no_of_units ?></td>
                        <td><?= $inv->price_per_unit ?></td>
                        <td><?= $inv->mf_total_value ?></td>
                        <td><?= $inv->mf_broker ?></td>

                        <!-- Mediclaim -->
                        <td><?= !empty($inv->insured_since)?date('d-m-Y',strtotime($inv->insured_since)):'' ?></td>
                        <td><?= !empty($inv->renewal_date)?date('d-m-Y',strtotime($inv->renewal_date)):'' ?></td>
                        <td><?= $inv->policy_no ?></td>
                        <td><?= $inv->policy_holder ?></td>
                        <td><?= $inv->premium_amt ?></td>
                        <td><?= $inv->sum_assured ?></td>
                        <td><?= $inv->plan_name ?></td>
                        <td><?= $inv->policy_name ?></td>

                        <!-- Insurance -->
                        <td><?= !empty($inv->policy_date)?date('d-m-Y',strtotime($inv->policy_date)):'' ?></td>
                        <td><?= $inv->maturity_year ?></td>
                        <td><?= !empty($inv->insurance_maturity_date)?date('d-m-Y',strtotime($inv->insurance_maturity_date)):'' ?></td>
                        <td><?= $inv->insurance_policy_holder ?></td>
                        <td><?= $inv->nominee ?></td>
                        <td><?= $inv->insurance_policy_number ?></td>
                        <td><?= $inv->insurance_premium_amt ?></td>
                        <td><?= $inv->insurance_sum_assured ?></td>
                        <td><?= $inv->insurance_plan ?></td>
                        <td><?= $inv->insurance_company ?></td>

                        <!-- Last -->
                        <td><?= $inv->status ?></td>
                        <td>
                            <a href="<?= site_url('investment/edit/'.encrypt_id($inv->id)) ?>" class="btn btn-xs btn-warning">✏️</a>
                            <?= form_open('investment/delete',['style'=>'display:inline']) ?>
                              <input type="hidden" name="id" value="<?= encrypt_id($inv->id) ?>">
                              <button class="btn btn-xs btn-danger" onclick="return confirm('Delete?')">🗑️</button>
                            <?= form_close() ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(function(){
    var table = $('#invTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                exportOptions: { columns: ':visible:not(.noExport)' } // exclude "Actions"
            },
            {
                extend: 'excel',
                exportOptions: { columns: ':visible:not(.noExport)' } // exclude "Actions"
            }
        ],
        order: [[1,'asc']],
        scrollX: true,
        scrollY: "800px",
        scrollCollapse: true,
        fixedHeader: true,
        pageLength: 100,

        columnDefs: [
            { targets: 'equity', visible: false },
            { targets: 'mf', visible: false },
            { targets: 'mediclaim', visible: false },
            { targets: 'insurance', visible: false },
            { targets: 'bond', visible: false },
            { targets: 'fd', visible: false },
            { targets: 'others', visible: false }
        ]
    });

    // hide all extras by default
    table.columns('.equity,.mf,.mediclaim,.insurance,.bond,.fd,.others').visible(false);

    $('#invTabs a').on('click', function(e){
        e.preventDefault();
        var type = $(this).data('type');

        // reset all
        table.columns('.equity,.mf,.mediclaim,.insurance,.bond,.fd,.others').visible(false);

        // filter
        table.column(1).search('^'+type+'$',true,false).draw();

        if(type==='Equity'){ table.columns('.equity').visible(true); }
        if(type==='Mutual Fund'){ table.columns('.mf').visible(true); }
        if(type==='Mediclaim'){ table.columns('.mediclaim').visible(true); }
        if(type==='Insurance'){ table.columns('.insurance').visible(true); }
        if(type==='Bond'){ table.columns('.bond').visible(true); }
        if(type==='Fixed Deposit'){ table.columns('.fd').visible(true); }
        if(type==='Others'){ table.columns('.others').visible(true); }

        $(this).tab('show');
    });

    // ✅ Default: Fixed Deposit tab
    $('#invTabs a[data-type="Fixed Deposit"]').trigger('click');
});


</script>
</body>
</html>
