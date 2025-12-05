<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title; ?></title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="<?= base_url('assets/css/helpdesk_admin.css'); ?>">

</head>
<body>

<div class="container">

    <h3 class="page-header">
        <span class="glyphicon glyphicon-console"></span> Helpdesk Admin Dashboard
        <small class="pull-right">
            <span class="glyphicon glyphicon-time"></span> SLA Monitoring Panel
        </small>
    </h3>

    <!-- Stats Cards -->
    <div class="row text-center dashboard-cards">
        <div class="col-sm-3">
            <div class="card-info card-open">
                <h4><span class="glyphicon glyphicon-folder-open"></span></h4>
                <p id="stat-open">0</p>
                <small>Open Tickets</small>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card-info card-progress">
                <h4><span class="glyphicon glyphicon-cog"></span></h4>
                <p id="stat-progress">0</p>
                <small>In Progress</small>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card-info card-critical">
                <h4><span class="glyphicon glyphicon-fire"></span></h4>
                <p id="stat-critical">0</p>
                <small>Critical Priority</small>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card-info card-resolved">
                <h4><span class="glyphicon glyphicon-ok-circle"></span></h4>
                <p id="stat-closed">0</p>
                <small>Closed Tickets</small>
            </div>
        </div>
    </div>

    <!-- Filter Panel -->
    <div class="panel filter-panel animated-panel">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-filter"></span> Filters
        </div>
        <div class="panel-body">
            <form id="filter-form" class="form-inline">
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="OPEN">Open</option>
                    <option value="IN_PROGRESS">In Progress</option>
                    <option value="ON_HOLD">On Hold</option>
                    <option value="RESOLVED">Resolved</option>
                    <option value="CLOSED">Closed</option>
                    <option value="REOPENED">Re-opened</option>
                </select>
                <select name="category_id" class="form-control">
                    <option value="">All Categories</option>
                    <?php foreach($categories as $c): ?>
                        <option value="<?= $c->category_id; ?>"><?= $c->category_name; ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="priority" class="form-control">
                    <option value="">All Priority</option>
                    <option value="LOW">Low</option>
                    <option value="MEDIUM">Medium</option>
                    <option value="HIGH">High</option>
                    <option value="CRITICAL">Critical</option>
                </select>
                <input type="date" name="from_date" class="form-control">
                <input type="date" name="to_date" class="form-control">

                <button type="button" id="btnFilter" class="btn btn-primary">
                    <span class="glyphicon glyphicon-search"></span> Apply
                </button>
            </form>
        </div>
    </div>

    <!-- Tickets Table -->
    <table class="table table-bordered table-hover animated-table" id="ticketTable">
        <thead>
        <tr>
            <th><span class="glyphicon glyphicon-tag"></span> Ticket No</th>
            <th>Category</th>
            <th>Title</th>
            <th>Priority</th>
            <th>Status</th>
            <th>SLA Due</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

</div>

<script>
function loadTickets(){
    $.ajax({
        url:'<?= site_url("helpdesk/admin_ajax_list"); ?>',
        type:'POST',
        dataType:'json',
        data:$('#filter-form').serialize(),
        success:function(data){
            let html='', open=0, progress=0, closed=0, critical=0;

            $.each(data,function(i,t){
                if(t.status=='OPEN') open++;
                if(t.status=='IN_PROGRESS') progress++;
                if(t.status=='CLOSED') closed++;
                if(t.priority=='CRITICAL') critical++;

                let pcls=(t.priority=='HIGH'||t.priority=='CRITICAL')?'danger':(t.priority=='MEDIUM'?'warning':'info');
                let scls='default';
                if(t.status=='OPEN') scls='warning';
                else if(t.status=='IN_PROGRESS') scls='info';
                else if(t.status=='RESOLVED') scls='primary';
                else if(t.status=='CLOSED') scls='success';
                else if(t.status=='ON_HOLD') scls='danger';

                let slaColor = t.sla_expired == 'YES' ? "style='color:red;font-weight:bold'" : "";

                html+=`<tr>
                    <td>${t.ticket_no}</td>
                    <td>${t.category_name}</td>
                    <td>${t.title}</td>
                    <td><span class="label label-${pcls}">${t.priority}</span></td>
                    <td><span class="label label-${scls}">${t.status}</span></td>
                    <td ${slaColor}>${t.sla_due_on?t.sla_due_on:"-"}</td>
                    <td>${t.created_on}</td>
                    <td><a href="<?= site_url("helpdesk/admin_view/"); ?>/${t.ticket_id}" class="btn btn-xs btn-primary">
                        <span class="glyphicon glyphicon-eye-open"></span> Open
                    </a></td>
                </tr>`;
            });

            $("#ticketTable tbody").html(html);

            $("#stat-open").text(open);
            $("#stat-progress").text(progress);
            $("#stat-critical").text(critical);
            $("#stat-closed").text(closed);
        }
    });
}

$('#btnFilter').on('click', loadTickets);
$(document).ready(loadTickets);
</script>

</body>
</html>
