<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title; ?></title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
body{
    background:#eef2f7 !important;
    font-family:"Segoe UI",Roboto,sans-serif !important;
}

.page-header{
    background:linear-gradient(135deg,#004aad,#2196f3) !important;
    color:white !important;
    padding:15px 20px !important;
    border-radius:8px !important;
    box-shadow:0 4px 12px rgba(0,0,0,0.2) !important;
}

.page-header .glyphicon{
    animation:iconBounce 1.4s infinite ease-in-out !important;
}

/* Table design */
.table{
    background:white !important;
    border-radius:8px !important;
    overflow:hidden !important;
    box-shadow:0 2px 12px rgba(0,0,0,0.15) !important;
}

.table > thead > tr{
    background:#004aad !important;
    color:white !important;
    text-transform:uppercase !important;
    font-size:13px !important;
}

.table-hover > tbody > tr:hover{
    background:#eaf3ff !important;
    transform:scale(1.01) !important;
    transition:.2s !important;
}

/* Badges Jumping */
.label, .btn{
    animation:btnPulse 1.8s infinite alternate !important;
}

/* Button styling */
.btn-success{
    background:#28a745 !important;
    border:none !important;
    font-weight:bold !important;
    padding:6px 14px !important;
}
.btn-success:hover{
    background:#1f7c34 !important;
    transform:translateY(-2px) !important;
    box-shadow:0 5px 12px rgba(0,0,0,0.25) !important;
}

/* Animations */
@keyframes iconBounce{
    0%{transform:translateY(0);}
    50%{transform:translateY(-6px);}
    100%{transform:translateY(0);}
}
@keyframes btnPulse {
    0% {box-shadow:0 0 8px rgba(0,123,255,.4);}
    100% {box-shadow:0 0 16px rgba(0,123,255,1);}
}

/* Filter bar */
.filter-bar{
    background:white !important;
    padding:12px !important;
    border-radius:6px !important;
    box-shadow:0 2px 10px rgba(0,0,0,0.15) !important;
    margin-bottom:12px !important;
}

</style>

</head>
<body>

<div class="container">

    <h3 class="page-header">
        <span class="glyphicon glyphicon-briefcase"></span> My Helpdesk Tickets
        <small class="pull-right">
            <a href="<?= site_url('helpdesk/create'); ?>" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-plus"></span> Create Ticket
            </a>
        </small>
    </h3>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="row">
            <div class="col-sm-4">
                <input id="searchBox" type="text" class="form-control" placeholder="Search ticket by title or No">
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped table-hover" id="ticketTable">
        <thead>
        <tr>
            <th>#</th>
            <th><span class="glyphicon glyphicon-tag"></span> Ticket No</th>
            <th><span class="glyphicon glyphicon-list"></span> Category</th>
            <th><span class="glyphicon glyphicon-text-size"></span> Title</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Created On</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        <?php if(!empty($tickets)): $i=1; foreach($tickets as $t): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><strong><?= $t->ticket_no; ?></strong></td>
                <td><?= $t->category_name; ?></td>
                <td><?= $t->title; ?></td>
                <td>
                    <span class="label label-<?= $t->priority=='HIGH' || $t->priority=='CRITICAL'?'danger':($t->priority=='MEDIUM'?'warning':'info'); ?>">
                        <?= $t->priority; ?>
                    </span>
                </td>
                <td>
                    <?php
                    $cls = 'default';
                    if($t->status=='OPEN') $cls='warning';
                    elseif($t->status=='IN_PROGRESS') $cls='info';
                    elseif($t->status=='RESOLVED') $cls='primary';
                    elseif($t->status=='CLOSED') $cls='success';
                    elseif($t->status=='ON_HOLD') $cls='danger';
                    ?>
                    <span class="label label-<?= $cls; ?>"><?= $t->status; ?></span>
                </td>
                <td><?= date('d-m-Y H:i', strtotime($t->created_on)); ?></td>
                <td>
                    <a href="<?= site_url('helpdesk/view/'.$t->ticket_id); ?>" class="btn btn-primary btn-xs">
                        <span class="glyphicon glyphicon-eye-open"></span> View
                    </a>
                </td>
            </tr>
        <?php endforeach; else: ?>
            <tr>
                <td colspan="8" class="text-center text-muted">No tickets found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
// Search filter
$("#searchBox").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#ticketTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});
</script>

</body>
</html>
