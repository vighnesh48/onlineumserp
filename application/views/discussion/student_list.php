<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    /* Background */
body {
    background: #eef2f7 !important;
    font-family: "Segoe UI", Roboto, sans-serif !important;
}

/* Page Title Styling */
.page-header {
    border-bottom: 2px solid #1976D2 !important;
    padding-bottom: 10px !important;
    animation: headerGlow 2s infinite alternate !important;
}

/* Glow animation for header */
@keyframes headerGlow {
    0% { text-shadow: 0 0 4px #1976d2 !important; }
    100% { text-shadow: 0 0 12px #004aad !important; }
}

/* =====================
   Table Styling
===================== */
.table {
    background: #fff !important;
    border-radius: 6px !important;
    box-shadow: 0 3px 10px rgba(0,0,0,0.10) !important;
}

.table > thead > tr {
    background: linear-gradient(135deg,#004aad,#2196f3) !important;
    color:#fff !important;
    text-transform: uppercase !important;
    font-size:13px !important;
}

.table-hover tbody tr:hover {
    background:#e3f2fd !important;
    transform: scale(1.01) !important;
    transition: .25s ease-in-out !important;
}

/* Animated labels (status, type) */
.label {
    animation: labelPulse 1.8s infinite alternate !important;
}

@keyframes labelPulse {
    0% { transform: scale(1) !important; opacity:0.9 !important; }
    100% { transform: scale(1.12) !important; opacity:1 !important; }
}

/* Button with hover lift */
.btn {
    transition: all .3s ease-in-out !important;
}

.btn:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.28) !important;
}

/* Jumping icon animation */
.glyphicon {
    animation: iconJump 1.3s infinite ease-in-out !important;
    display: inline-block !important;
}

/* Jumping animation keyframes */
@keyframes iconJump {
    0% { transform: translateY(0) rotate(0deg) !important; }
    40% { transform: translateY(-6px) rotate(3deg) !important; }
    80% { transform: translateY(3px) rotate(-3deg) !important; }
    100% { transform: translateY(0) rotate(0deg) !important; }
}

/* No records row */
.text-muted {
    font-size: 15px !important;
    font-weight: 600 !important;
    color:#777 !important;
}

</style>
</head>
<body>
<div class="container">
    <h3 class="page-header">
        My Discussion Requests
        <small class="pull-right">
            <a href="<?= site_url('discussion/create'); ?>" class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-plus"></span> New Request
            </a>

        </small>
    </h3>

    <table class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Ticket No</th>
            <th>Subject</th>
            <th>Topic</th>
            <th>Type</th>
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
                <td><?= $t->subject_name; ?></td>
                <td><?= $t->topic_title_snapshot; ?></td>
                <td>
                    <span class="label label-<?= $t->discussion_type=='ONLINE_MEET'?'info':'primary'; ?>">
                        <?= $t->discussion_type; ?>
                    </span>
                </td>
                <td>
                    <?php
                    $cls = 'default';
                    if($t->status=='OPEN') $cls='warning';
                    elseif($t->status=='MEET_SCHEDULED') $cls='info';
                    elseif($t->status=='CLOSED') $cls='success';
                    ?>
                    <span class="label label-<?= $cls; ?>"><?= $t->status; ?></span>
                </td>
                <td><?= date('d-m-Y H:i', strtotime($t->created_on)); ?></td>
                <td>
                    <a href="<?= site_url('discussion/view/'.$t->ticket_id); ?>" class="btn btn-xs btn-primary">
                        View
                    </a>
                </td>
            </tr>
        <?php endforeach; else: ?>
            <tr>
                <td colspan="8" class="text-center text-muted">No requests found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>
</body>
</html>
