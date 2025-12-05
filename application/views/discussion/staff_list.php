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

.filter-panel { margin-bottom: 15px; padding: 15px; background:#f7f7f7; border-radius:4px; }
</style>
</head>

<body>
<div class="container">

    <h3 class="page-header">Student Discussion Requests</h3>

    <!-- FILTERS -->
    <div class="filter-panel">
        <form id="filter-form" class="form-inline">

            <select name="filter_status" id="filter_status" class="form-control">
                <option value="">All Status</option>
                <option value="OPEN">Open</option>
                <option value="MEET_SCHEDULED">Meeting Scheduled</option>
                <option value="FACULTY_REPLIED">Faculty Replied</option>
                <option value="STUDENT_REPLIED">Student Replied</option>
                <option value="CLOSED">Closed</option>
            </select>

            <select name="filter_type" id="filter_type" class="form-control">
                <option value="">All Types</option>
                <option value="DIRECT">Direct</option>
                <option value="ONLINE_MEET">Online Meet</option>
            </select>

            <input type="date" name="from_date" id="from_date" class="form-control">
            <input type="date" name="to_date" id="to_date" class="form-control">

            <button type="button" class="btn btn-primary" id="btnFilter">
                <span class="glyphicon glyphicon-filter"></span> Apply
            </button>
        </form>
    </div>

    <!-- TICKET TABLE -->
    <table class="table table-bordered table-striped table-hover" id="ticketTable">
        <thead>
        <tr>
            <th>#</th>
            <th>Ticket No</th>
            <th>Student</th>
            <th>Subject</th>
            <th>Type</th>
            <th>Topic</th>
            <th>Status</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody id="ticketBody"></tbody>
    </table>

</div>

<script>
function loadTickets() {
    $.ajax({
        url: "<?= site_url('discussion/staff_ajax_list'); ?>",
        type: "POST",
        dataType: "json",
        data: $('#filter-form').serialize(),
        success: function(data) {
            var html = '';
            var i = 1;
            $.each(data, function(idx, t) {
                var cls = 'default';
                if(t.status=='OPEN') cls='warning';
                else if(t.status=='MEET_SCHEDULED') cls='info';
                else if(t.status=='CLOSED') cls='success';

                html += '<tr>' +
                    '<td>'+ i++ +'</td>' +
                    '<td>'+ t.ticket_no +'</td>' +
                    '<td>'+ t.stud_id +'</td>' +
                    '<td>'+ t.subject_name +'</td>' +
                    '<td>'+ t.discussion_type +'</td>' +
                    '<td>'+ t.topic_title_snapshot +'</td>' +
                    '<td><span class="label label-' + cls + '">' + t.status + '</span></td>' +
                    '<td>'+ t.created_on +'</td>' +
                    '<td>' +
                        '<a href="<?= site_url('discussion/staff_view/'); ?>'+'/'+t.ticket_id+'" class="btn btn-xs btn-primary">View</a> ';

                if(t.status != 'CLOSED'){
                    html += '<button class="btn btn-xs btn-danger" onclick="closeTicket('+t.ticket_id+')">Close</button>';
                }

                html += '</td></tr>';
            });
            $('#ticketBody').html(html);
        }
    });
}

$('#btnFilter').click(function(){
    loadTickets();
});

function closeTicket(id){
    if(confirm("Are you sure to close this ticket?")) {
        $.post("<?= site_url('discussion/close_ticket'); ?>", { ticket_id:id }, function(res){
            loadTickets();
        },'json');
    }
}

$(document).ready(function(){
    loadTickets();
});
</script>

</body>
</html>
