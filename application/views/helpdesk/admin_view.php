<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title; ?></title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="<?= base_url('assets/css/helpdesk_chat.css'); ?>">

</head>
<body>

<div class="container">
    <h3 class="page-header">
        <span class="glyphicon glyphicon-certificate"></span> Ticket Handler
        <small class="pull-right">
            <a href="<?= site_url('helpdesk/admin'); $chat_mode = $this->session->userdata('chat_mode'); ?>" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-arrow-left"></span> Back
            </a>
        </small>
    </h3>

    <!-- Header -->
    <div class="panel panel-info ticket-header">
        <div class="panel-heading">
            <strong><?= $ticket->ticket_no; ?></strong> |
            <?= $ticket->category_name; ?> |
            <span class="label label-success"><?= $ticket->priority; ?></span>
            <span class="pull-right">
                Status:
                <span class="label label-primary"><?= $ticket->status; ?></span>
            </span>
        </div>
        <div class="panel-body">
            <p><strong><?= $ticket->title; ?></strong></p>
            <p><?= nl2br($ticket->description); ?></p>
        </div>
    </div>

    <!-- CHAT -->
    <div class="panel panel-custom">
        <div class="panel-heading"><span class="glyphicon glyphicon-envelope"></span> Conversation</div>
            <div class="chat-mode-selector text-right" style="margin-bottom:10px;">
                <select id="chatMode" class="form-control" style="width:200px;display:inline-block;">
                    <option value="whatsapp" <?= ($chat_mode=='whatsapp'?'selected':''); ?>>WhatsApp Theme</option>
                    <option value="messenger" <?= ($chat_mode=='messenger'?'selected':''); ?>>Messenger Theme</option>
                    <option value="zoom" <?= ($chat_mode=='zoom'?'selected':''); ?>>Zoom Theme</option>
                </select>
            </div>
        <div class="panel-body chat-box <?= $chat_mode; ?>">

            <?php 
            $chat_mode = $this->session->userdata('chat_mode') ?? 'whatsapp';
            foreach($messages as $msg): ?>
                
                <div class="chat-msg 
                    <?= $msg->sender_type=='ADMIN'?'chat-right':'chat-left'; ?> 
                    <?= $chat_mode; ?> 
                    <?= $msg->is_internal?'internal':''; ?>
                ">
                    <div class="bubble">
                        <strong><?= $msg->sender_type; ?></strong>
                        <small class="text-muted"><?= date('d M h:i A', strtotime($msg->created_on)); ?></small><br>
                        <?= nl2br(htmlspecialchars($msg->message_text)); ?>
                        <?php if($msg->attachment_path): ?>
                            <br><a href="<?= base_url($msg->attachment_path); ?>" target="_blank" class="attach-link">
                                <span class="glyphicon glyphicon-paperclip"></span> Attachment
                            </a>
                        <?php endif; ?>
                        <?php if($msg->is_internal): ?>
                            <span class="label label-danger pull-right">Internal</span>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </div>

    <!-- Reply + Status Controls -->
    <div class="panel panel-primary reply-panel">
        <div class="panel-heading"><span class="glyphicon glyphicon-edit"></span> Reply / Update</div>
        <div class="panel-body">
            <form id="admin-reply-form" enctype="multipart/form-data">
                <input type="hidden" name="ticket_id" value="<?= $ticket->ticket_id; ?>">

                <textarea name="message_text" id="message_text" rows="3" class="form-control" placeholder="Enter reply or note..."></textarea><br>

                <label><input type="checkbox" name="is_internal" value="1"> Internal message (not visible to student)</label><br><br>

                <input type="file" name="attachment" class="form-control"><br>

                <div class="btn-group">
                    <button name="status" value="IN_PROGRESS" class="btn btn-info">In Progress</button>
                    <button name="status" value="ON_HOLD" class="btn btn-warning">Hold</button>
                    <button name="status" value="RESOLVED" class="btn btn-primary">Resolve</button>
                    <button name="status" value="CLOSED" class="btn btn-success">Close</button>
                </div>

                <button type="submit" class="btn btn-success pull-right">
                    <span class="glyphicon glyphicon-send"></span> Submit
                </button>
            </form>
        </div>
    </div>

</div>

<script>
$("#admin-reply-form button").click(function(){
    var status = $(this).val();
    $("<input>").attr({type:"hidden", name:"status", value:status}).appendTo("#admin-reply-form");
});

$("#admin-reply-form").submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url:'<?= site_url("helpdesk/admin_reply"); ?>',
        type:'POST',
        dataType:'json',
        data:formData,
        processData:false,
        contentType:false,
        success:function(res){
            if(res.status=="success") location.reload();
        }
    });
});
$('#chatMode').change(function(){
    $.post("<?= site_url('helpdesk/set_chat_mode'); ?>",
        {mode:$(this).val()}, function(){
            location.reload();
        }
    );
});
$(".chat-box").scrollTop($(".chat-box")[0].scrollHeight);

</script>

</body>
</html>
