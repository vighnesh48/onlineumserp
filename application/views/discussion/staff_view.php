<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title; ?></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    /* ===========================
   GLOBAL LAYOUT + BACKGROUND
=========================== */
body {
    background: #eef2f7 !important;
    font-family: "Segoe UI", Roboto, sans-serif !important;
}

/* Page header */
.page-header {
    border-bottom: 2px solid #1976d2 !important;
    padding-bottom: 12px !important;
    animation: headerGlow 2s infinite alternate !important;
}

@keyframes headerGlow {
    0%   { text-shadow:0 0 4px #2196f3 !important; }
    100% { text-shadow:0 0 14px #004aad !important; }
}

/* ===========================
   PANEL UI
=========================== */
.panel {
    border-radius: 8px !important;
    border: none !important;
    box-shadow:0 3px 12px rgba(0,0,0,0.15) !important;
}

.panel-heading {
    background: linear-gradient(135deg,#004aad,#2196f3) !important;
    color:#fff !important;
    font-size:16px !important;
    font-weight:600 !important;
    animation: headPulse 2s infinite alternate !important;
}

@keyframes headPulse {
    0% { opacity: .9 !important; }
    100% { opacity: 1 !important; }
}

/* ===========================
   CHAT BUBBLE MESSAGE UI
=========================== */
.panel-body {
    background:#ffffff !important;
}

.chat-msg {
    padding:10px 14px !important;
    border-radius:12px !important;
    margin-bottom:10px !important;
    max-width:80% !important;
    animation: fadeGrow .4s ease !important;
}

.chat-student {
    background:#e3f2fd !important;
    border-left:4px solid #2196f3 !important;
}

.chat-staff {
    background:#fff3cd !important;
    border-left:4px solid #ff9800 !important;
}

@keyframes fadeGrow {
    from { opacity:0 !important; transform:scale(.95) !important; }
    to { opacity:1 !important; transform:scale(1) !important; }
}

/* ===========================
   ICON ANIMATION JUMP
=========================== */
.glyphicon {
    animation: iconJump 1.3s infinite ease-in-out !important;
    display: inline-block !important;
}

@keyframes iconJump {
    0%   { transform: translateY(0) rotate(0deg) !important; }
    40%  { transform: translateY(-6px) rotate(4deg) !important; }
    80%  { transform: translateY(3px) rotate(-4deg) !important; }
    100% { transform: translateY(0) rotate(0deg) !important; }
}

/* ===========================
   BUTTON ANIMATION
=========================== */
.btn {
    transition: all .3s ease !important;
}

.btn:hover {
    transform: translateY(-3px) !important;
    box-shadow:0 4px 12px rgba(0,0,0,.25) !important;
}

.btn-success {
    animation: btnPulse 2s infinite alternate !important;
}

@keyframes btnPulse {
    0% { box-shadow:0 0 4px rgba(46,204,113,.5) !important; }
    100% { box-shadow:0 0 14px rgba(46,204,113,.95) !important; }
}

/* ===========================
   FORM ERROR HANDLING
=========================== */
.has-error .form-control {
    border-color:#d9534f !important;
    box-shadow:0 0 6px rgba(217,83,79,.6) !important;
    animation: shake 0.2s 2 !important;
}

@keyframes shake {
    0%,100% { transform: translateX(0) !important; }
    25% { transform: translateX(-3px) !important; }
    75% { transform: translateX(3px) !important; }
}

</style>
</head>
<body>
<div class="container">
    <h3 class="page-header">
        Handle Discussion Request
        <small class="pull-right">
            <a href="<?= site_url('discussion/staff'); ?>" class="btn btn-default btn-xs">
                Back to list
            </a>
        </small>
    </h3>

    

    <div class="panel panel-info">
        <div class="panel-heading">
            Ticket: <?= $ticket->ticket_no; ?> |
            Student: <?= $ticket->stud_id; ?> |
            Subject: <?= $ticket->subject_name; ?> |
            Type: <?= $ticket->discussion_type; ?>
        </div>
        <div class="panel-body">
            <p><strong>Topic:</strong> <?= $ticket->topic_title_snapshot; ?></p>
            <p><strong>Student Remark:</strong><br><?= nl2br(htmlspecialchars($ticket->student_remark)); ?></p>

            <?php if($ticket->discussion_type == 'ONLINE_MEET'): ?>
                <p>
                    <strong>Current Meet Details:</strong><br>
                    Link: <?= $ticket->meet_link ? '<a target="_blank" href="'.$ticket->meet_link.'">'.$ticket->meet_link.'</a>' : 'Not scheduled'; ?><br>
                    Date-Time: <?= $ticket->meet_start_datetime ? date('d-m-Y H:i', strtotime($ticket->meet_start_datetime)) : '-'; ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Conversation -->
    <!-- Chat messages -->
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Conversation</strong></div>
        <div class="panel-body" style="max-height:350px; overflow-y:auto;">
            <?php if(!empty($messages)): foreach($messages as $msg): ?>
                <div style="margin-bottom:10px;">
                    <strong>[<?= $msg->sender_type; ?> <?= $msg->sender_id; ?>]</strong>
                    <small class="text-muted"><?= date('d-m-Y H:i', strtotime($msg->created_on)); ?></small>
                    <br>
                    <?= nl2br(htmlspecialchars($msg->message_text)); ?>
                    <?php if (!empty($msg->attachment_path)): ?>
                        <br>
                        <a href="<?= base_url($msg->attachment_path); ?>" target="_blank" class="label label-info">
                            <span class="glyphicon glyphicon-paperclip"></span> View Attachment
                        </a>
                    <?php endif; ?>
                </div>
                <hr style="margin:5px 0;">
                <?php endforeach;  else: ?>
                <p class="text-muted text-center">No messages yet.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php if($ticket->status != 'CLOSED'){ ?>
    <!-- Reply / Schedule -->
    <div class="panel panel-primary">
        <div class="panel-heading">Reply / Schedule Meeting</div>
        <div class="panel-body">
            <div id="alert-container"></div>
            <form id="staff-reply-form" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="ticket_id" value="<?= $ticket->ticket_id; ?>">

                <div class="form-group">
                    <label class="col-sm-2 control-label">Reply Message</label>
                    <div class="col-sm-7">
                        <textarea name="message_text" id="message_text" rows="3" class="form-control"></textarea>
                        <span class="help-block">Reply for direct discussion or additional notes for meeting.</span>
                    </div>
                </div>

                <?php if($ticket->discussion_type == 'ONLINE_MEET'): ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Google Meet Link</label>
                        <div class="col-sm-7">
                            <input type="text" name="meet_link" id="meet_link" value="<?= $ticket->meet_link; ?>" class="form-control" placeholder="https://meet.google.com/..." required>
                            <span class="help-block">Paste meeting URL generated from Google Calendar/Meet.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Meeting Date-Time</label>
                        <div class="col-sm-4">
                            <input type="datetime-local" name="meet_datetime" id="meet_datetime" class="form-control">
                            <span class="help-block">Optional, if you want to reschedule.</span>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Attach File (if required)</label>
                    <div class="col-sm-7">
                        <input type="file" name="attachment" id="staff_attachment" class="form-control">
                        <span class="help-block">Optional: notes, solutions, reference material.</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-7">
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-send"></span> Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php }else{ ?>
    <div class="panel panel-primary">
        <h4 style="color:green;">Current Ticket Is Closed.</h4>
    </div>
    <?php } ?>
</div>

<script>
$(function () {

    // Auto scroll chat to bottom
    $('.panel-body').scrollTop($('.panel-body')[0].scrollHeight);

    // AJAX form submit handler
    $('#staff-reply-form').on('submit', function (e) {
        e.preventDefault();

        var form = this;
        var formData = new FormData(form);

        $.ajax({
            url: '<?= site_url("discussion/staff_reply"); ?>',
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('button[type=submit]').html('<span class="glyphicon glyphicon-refresh"></span> Sending...').prop('disabled', true);
            },
            success: function (res) {
                $('button[type=submit]').html('<span class="glyphicon glyphicon-send"></span> Submit').prop('disabled', false);

                if (res.status === "success") {
                    $('#alert-container').html('<div class="alert alert-success">Reply submitted successfully!</div>');
                    $('#message_text').val('');
                    $('#staff_attachment').val('');
                } else {
                    $('#alert-container').html('<div class="alert alert-danger">' + res.message + '</div>');
                    $('[name="message_text"]').closest('.form-group').addClass("has-error");
                }

                // Scroll after update
                $('html,body').animate({scrollTop: $("#alert-container").offset().top - 120}, 300);
            },
            error: function () {
                $('#alert-container').html('<div class="alert alert-danger">Server Error!</div>');
            }
        });
    });
});

</script>

</body>
</html>
