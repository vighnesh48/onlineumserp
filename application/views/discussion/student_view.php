<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title; ?></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    body {
    background:#eef2f7 !important;
    font-family:"Segoe UI",Roboto,sans-serif !important;
}

/* Page header */
.page-header {
    border-bottom: 2px solid #1976d2 !important;
    padding-bottom: 12px !important;
    animation: headerGlow 2s infinite alternate !important;
}

.panel-heading {
    background:linear-gradient(135deg,#004aad,#2196f3) !important;
    color:#fff !important;
    padding:14px !important;
    font-size:16px !important;
    font-weight:600 !important;
    border-radius:10px 10px 0 0 !important;
    animation:glowHead 2s infinite alternate !important;
}

/* GLOW ANIMATION */
@keyframes glowHead {
    0% { box-shadow:0 0 5px #fff !important; }
    100% { box-shadow:0 0 14px #004aad !important; }
}

/* CHAT SCROLLBAR */
.panel-body {
    scrollbar-width:thin !important;
    scrollbar-color:#004aad #ddd !important;
}
.panel-body::-webkit-scrollbar {
    width:6px !important;
}
.panel-body::-webkit-scrollbar-thumb {
    background:#004aad !important;
    border-radius:6px !important;
}

/* BUTTONS */
.btn-success {
    font-size:15px !important;
    padding:8px 20px !important;
    animation:btnPulse 2s infinite alternate !important;
}
.btn-success:hover {
    transform:translateY(-4px) !important;
    box-shadow:0 4px 12px rgba(0,0,0,0.3) !important;
}

/* PULSE BUTTON */
@keyframes btnPulse {
    0% { box-shadow:0 0 4px rgba(33,150,243,.6) !important; }
    100% { box-shadow:0 0 15px rgba(33,150,243,1) !important; }
}

/* JUMPING ICONS */
.glyphicon {
    animation:iconJump 1.2s infinite ease-in-out !important;
    display:inline-block !important;
}
@keyframes iconJump {
    0%   { transform:translateY(0) rotate(0deg) !important; }
    40%  { transform:translateY(-6px) rotate(3deg) !important; }
    80%  { transform:translateY(3px) rotate(-3deg) !important; }
    100% { transform:translateY(0) rotate(0deg) !important; }
}

/* CHAT MESSAGE BUBBLES */
.chat-msg {
    background:#ffffff !important;
    border-left:4px solid #004aad !important;
    padding:10px !important;
    border-radius:6px !important;
    margin-bottom:12px !important;
    animation:fadeSlide 0.4s ease !important;
}
@keyframes fadeSlide {
    from { opacity:0; transform:translateX(-10px) !important; }
    to { opacity:1; transform:translateX(0) !important; }
}

/* ERROR SHAKE */
.has-error .form-control {
    border-color:#d9534f !important;
    animation:shake 0.4s linear !important;
}
@keyframes shake {
    0%,100% { transform:translateX(0) !important; }
    20% { transform:translateX(-6px) !important; }
    40% { transform:translateX(6px) !important; }
    60% { transform:translateX(-4px) !important; }
    80% { transform:translateX(4px) !important; }
}

</style>
</head>

<body>
<div class="container">

    <h3 class="page-header">
        Discussion Request Details
        <small class="pull-right">
            <a href="<?= site_url('discussion'); ?>" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-arrow-left"></span> Back
            </a>
        </small>
    </h3>

    <!-- Ticket summary -->
    <div class="panel panel-info">
        <div class="panel-heading">
            Ticket: <?= $ticket->ticket_no; ?> |
            Status: <span class="label label-primary"><?= $ticket->status; ?></span>
        </div>
        <div class="panel-body">
            <p><strong>Subject:</strong> <?= $ticket->subject_name; ?></p>
            <p><strong>Topic:</strong> <?= $ticket->topic_title_snapshot; ?></p>
            <p><strong>Discussion Type:</strong> <?= $ticket->discussion_type; ?></p>
            <p><strong>Student Remark:</strong><br><?= nl2br($ticket->student_remark); ?></p>

            <?php if($ticket->discussion_type == 'ONLINE_MEET'): ?>
                <hr>
                <strong>Meeting Details</strong><br>
                Link:
                <?= $ticket->meet_link ?
                    '<a href="'.$ticket->meet_link.'" target="_blank">'.$ticket->meet_link.'</a>' :
                    '<span class="text-danger">Not scheduled yet</span>'; ?>
                <br>
                Date-Time:
                <?= $ticket->meet_start_datetime ?
                    date('d-m-Y H:i', strtotime($ticket->meet_start_datetime)) :
                    '-'; ?>
            <?php endif; ?>
        </div>
    </div>

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
    <!-- Reply section -->
    <div class="panel panel-primary">
        <div class="panel-heading">Reply</div>
        <div class="panel-body">

            <div id="alert-container"></div>

            <form id="student-reply-form" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="ticket_id" value="<?= $ticket->ticket_id; ?>">

                <div class="form-group">
                    <label class="col-sm-2 control-label">Message</label>
                    <div class="col-sm-7">
                        <textarea name="message_text" id="message_text" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Attach File (if required)</label>
                    <div class="col-sm-7">
                        <input type="file" name="attachment" id="reply_attachment" class="form-control">
                        <span class="help-block">Optional: upload supporting document or image.</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-7">
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-send"></span> Send Reply
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

    // Auto-scroll chat to latest message
    $(".panel-body").scrollTop($(".panel-body")[0].scrollHeight);

    $('#student-reply-form').on('submit', function (e) {
        e.preventDefault();

        var form = this;
        var formData = new FormData(form);

        $.ajax({
            url: '<?= site_url("discussion/student_reply"); ?>',
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,

            beforeSend: function () {
                $('button[type=submit]').html('<span class="glyphicon glyphicon-refresh"></span> Sending...')
                    .prop('disabled', true);
                $('#alert-container').html('');
            },

            success: function (res) {
                $('button[type=submit]').html('<span class="glyphicon glyphicon-send"></span> Send Reply')
                    .prop('disabled', false);

                if (res.status === 'success') {
                    $('#alert-container').html('<div class="alert alert-success">Message sent. Reload to view.</div>');
                    $('#message_text').val('');
                    $('#reply_attachment').val('');
                } else {
                    $('#alert-container').html('<div class="alert alert-danger">' + res.message + '</div>');
                    $('[name="message_text"]').closest('.form-group').addClass("has-error");
                }
            },

            error: function () {
                $('button[type=submit]').prop('disabled', false);
                $('#alert-container').html('<div class="alert alert-danger">Server issue. Try again.</div>');
            }
        });
    });

});

</script>


</body>
</html>
