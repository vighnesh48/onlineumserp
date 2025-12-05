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
        <span class="glyphicon glyphicon-comment"></span> Support Ticket
        <small class="pull-right">
            <a href="<?= site_url('helpdesk'); $chat_mode = $this->session->userdata('chat_mode'); ?>" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-arrow-left"></span> Back
            </a>
        </small>
    </h3>

    <!-- Ticket Summary -->
    <div class="panel panel-info ticket-header">
        <div class="panel-heading">
            <strong><?= $ticket->ticket_no; ?></strong> &nbsp;|&nbsp;
            <?= $ticket->category_name; ?> &nbsp;|&nbsp;
            <span class="label label-success"><?= $ticket->priority; ?></span>

            <span class="pull-right">
                Status: <span class="label label-primary"><?= $ticket->status; ?></span>
            </span>
        </div>
        <div class="panel-body">
            <p><strong><?= $ticket->title; ?></strong></p>
            <p><?= nl2br($ticket->description); ?></p>
        </div>
    </div>

    <!-- Chat Box -->
<!-- CHAT_BOX -->
<div class="panel panel-custom">
    <div class="panel-heading">
        <span class="glyphicon glyphicon-envelope"></span> Conversation
        <div class="pull-right">
            <select id="chatMode" class="form-control input-sm" style="width:180px;display:inline-block;">
                <option value="whatsapp" <?= ($chat_mode=='whatsapp'?'selected':''); ?>>WhatsApp Mode</option>
                <option value="messenger" <?= ($chat_mode=='messenger'?'selected':''); ?>>Messenger Mode</option>
                <option value="zoom" <?= ($chat_mode=='zoom'?'selected':''); ?>>Zoom Mode</option>
            </select>
        </div>
    </div>

    <div class="panel-body chat-box <?= $chat_mode; ?>" id="chat-box">
        <?php foreach($messages as $msg): ?>
            <div class="chat-msg <?= $chat_mode; ?> <?= $msg->sender_type=='STUDENT'?'chat-right':'chat-left'; ?>">
                <div class="bubble">
                    <strong><?= $msg->sender_type=='STUDENT'?'You':$msg->sender_type; ?></strong>
                    <small class="text-muted"><?= date('d M h:i A', strtotime($msg->created_on)); ?></small><br>
                    <?= nl2br(htmlspecialchars($msg->message_text)); ?>

                    <?php if($msg->attachment_path): ?>
                        <br><a href="<?= base_url($msg->attachment_path); ?>" target="_blank" class="attach-link">
                            <span class="glyphicon glyphicon-paperclip"></span> Attachment
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


    <?php if($ticket->status!='CLOSED'): ?>
    <!-- Reply Box -->
    <div class="panel panel-primary reply-panel">
        <div class="panel-heading"><span class="glyphicon glyphicon-pencil"></span> Reply</div>
        <div class="panel-body">
            <div id="alert-container"></div>
            <form id="student-reply-form" enctype="multipart/form-data">
                <input type="hidden" name="ticket_id" value="<?= $ticket->ticket_id; ?>">

                <textarea name="message_text" id="message_text" rows="3" class="form-control" placeholder="Type your reply..."></textarea><br>

                <input type="file" name="attachment" id="reply_attachment" class="form-control"><br>

                <button type="submit" class="btn btn-success btn-lg btn-block">
                    <span class="glyphicon glyphicon-send"></span> Send Reply
                </button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <?php if($ticket->status=='RESOLVED' && empty($feedback)): ?>
    <!-- Feedback -->
    <div class="panel panel-success feedback-panel">
        <div class="panel-heading"><span class="glyphicon glyphicon-star"></span> Your Feedback</div>
        <div class="panel-body text-center">

            <h4>Rate Support Quality</h4>
            <div class="rating-stars">
              <i class="star glyphicon glyphicon-star-empty" data-val="1"></i>
              <i class="star glyphicon glyphicon-star-empty" data-val="2"></i>
              <i class="star glyphicon glyphicon-star-empty" data-val="3"></i>
              <i class="star glyphicon glyphicon-star-empty" data-val="4"></i>
              <i class="star glyphicon glyphicon-star-empty" data-val="5"></i>
            </div>

            <textarea id="fb_comment" class="form-control" placeholder="Additional comments (optional)"></textarea><br>
            <button id="submitFeedback" class="btn btn-success btn-lg">
                <span class="glyphicon glyphicon-ok"></span> Submit Feedback
            </button>
        </div>
    </div>
    <?php endif; ?>
</div>


<script>
var rating = 0;
$(".star").click(function(){
    rating = $(this).data("val");
    $(".star").removeClass("glyphicon-star").addClass("glyphicon-star-empty");
    for(var i=1; i<=rating; i++){
        $(".star[data-val='"+i+"']").addClass("glyphicon-star").removeClass("glyphicon-star-empty");
    }
});

$("#submitFeedback").click(function(){
    $.post('<?= site_url("helpdesk/save_feedback"); ?>',{
        ticket_id:'<?= $ticket->ticket_id; ?>',
        rating:rating,
        comment:$("#fb_comment").val()
    }, function(res){
        if(res.status=="success"){ location.reload(); }
        else alert(res.message);
    },'json');
});

$("#student-reply-form").on("submit",function(e){
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url:'<?= site_url("helpdesk/reply_student"); ?>',
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
