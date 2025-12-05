<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title; ?></title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>

body {
    background: #eef2f7 !important;
    font-family: "Segoe UI", Roboto, sans-serif !important;
}

.panel-custom {
    border-radius: 8px !important;
    border: none !important;
    box-shadow: 0 3px 12px rgba(0,0,0,0.12) !important;
}

.panel-custom > .panel-heading {
    background: linear-gradient(135deg,#004aad,#2196f3) !important;
    color:#fff !important;
    padding: 18px !important;
    font-size: 18px !important;
    font-weight:600 !important;
    border-radius:8px 8px 0 0 !important;
}

.form-control:focus {
    border-color: #2196f3 !important;
    box-shadow: 0 0 6px rgba(33,150,243,.5) !important;
}

label {
    font-weight:600 !important;
}

.help-block {
    color:#555 !important;
    font-size: 11px !important;
}

#discussion-form button[type=submit] {
    transition: all .3s ease !important;
    font-size: 15px !important;
    padding:10px 22px !important;
}

#discussion-form button[type=submit]:hover {
    background:#0b7dda !important;
    transform: translateY(-2px) !important;
}

.character-count {
    font-size:11px !important;
    color:#777 !important;
}

.input-icon {
    margin-right: 6px !important;
    color:#2196f3 !important;
}

.required {
    color:#d9534f !important;
    font-weight:bold !important;
}

.select-loading {
    background: url('https://i.imgur.com/LLF5iyg.gif') no-repeat right center !important;
    background-size: 20px !important;
}

.attachment-info {
    font-size:12px !important; 
    color:#555 !important;
}

.top-summary {
    padding:10px 15px !important;
    background: #fff !important;
    border-left: 4px solid #2196f3 !important;
    border-radius:6px !important;
    margin-bottom:20px !important;
    font-size:14px !important;
}
.glyphicon {
    animation: iconBounce 1.2s infinite alternate !important;
    display: inline-block !important;
}

/* Bounce Effect */
@keyframes iconBounce {
    0%   { transform: translateY(0) rotate(0deg) !important; }
    50%  { transform: translateY(-4px) rotate(3deg) !important; }
    100% { transform: translateY(0) rotate(-3deg) !important; }
}
.panel-heading .glyphicon {
    animation: iconBounce 0.9s infinite alternate !important;
}
@keyframes iconBounce {
    0%   { transform: translateY(0) !important; }
    60%  { transform: translateY(-6px) !important; }
    100% { transform: translateY(0) !important; }
}

</style>

</head>
<body>

<div class="container">

    <h3 class="page-header">
        <b><span class="glyphicon glyphicon-education"></span> Student Discussion Forum</b>
        <small class="pull-right">
            <a href="<?= site_url('discussion'); ?>" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-list"></span> My Requests
            </a>
        </small>
    </h3>

    <div class="top-summary">
        <b>UGC & NAAC Compliance:</b> Enhancing Academic Interaction | Digital Student Engagement | Direct Mentoring Support
    </div>
    <div class="panel panel-custom">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-comment"></span> Submit Your Academic Query
        </div>

        <div class="panel-body">
            <div id="alert-container"></div>
            <form id="discussion-form" class="form-horizontal" enctype="multipart/form-data">

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span class="glyphicon glyphicon-random input-icon"></span> Discussion Type <span class="required">*</span>
                    </label>
                    <div class="col-sm-6">
                        <select name="discussion_type" id="discussion_type" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="DIRECT">Direct Discussion</option>
                            <option value="ONLINE_MEET">Online Meeting (Google Meet)</option>
                        </select>
                        <p class="help-block">Choose type of discussion required</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span class="glyphicon glyphicon-book input-icon"></span> Subject <span class="required">*</span>
                    </label>
                    <div class="col-sm-6">
                        <select name="subject_id" id="subject_id" class="form-control">
                            <option value="">-- Select Subject --</option>
                            <?php foreach ($subjects as $sub): ?>
                                <option value="<?= $sub['subject_id']; ?>">
                                    <?= $sub['subject_code'].' - '.$sub['subject_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="help-block">Your enrolled subjects for the current session</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span class="glyphicon glyphicon-tasks input-icon"></span> Unit / Topic <span class="required">*</span>
                    </label>
                    <div class="col-sm-6">
                        <select name="topic_id" id="topic_id" class="form-control">
                            <option value="">-- Select Topic --</option>
                        </select>
                        <p class="help-block">Select relevant unit/topic for discussion</p>
                    </div>
                </div>

                <div id="meet-block" style="display:none;">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            <span class="glyphicon glyphicon-time input-icon"></span> Preferred Date & Time
                        </label>
                        <div class="col-sm-6">
                            <input type="datetime-local" name="preferred_datetime" id="preferred_datetime" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span class="glyphicon glyphicon-pencil input-icon"></span> Your Query <span class="required">*</span>
                    </label>
                    <div class="col-sm-6">
                        <textarea name="student_remark" id="student_remark" rows="4" class="form-control" maxlength="1000"></textarea>                       
                        <div class="text-right character-count">
                            <span id="remark_count">0</span>/1000 characters
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        <span class="glyphicon glyphicon-paperclip input-icon"></span> Attach File
                    </label>
                    <div class="col-sm-6">
                        <input type="file" name="attachment" id="attachment" class="form-control">
                        <p class="attachment-info">Upload: PDF, DOC, PPT, XLS, JPG, PNG (Max 5MB)</p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-success btn-block">
                            <span class="glyphicon glyphicon-send"></span> Submit Request
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
$(function() {

    $('#discussion_type').on('change', function() {
        ($(this).val()==='ONLINE_MEET') ? $('#meet-block').slideDown() : $('#meet-block').slideUp();
    });

    $('#subject_id').on('change', function(){
        var subject_id = $(this).val();
        $('#topic_id').addClass('select-loading');
        $('#topic_id').html('<option>Loading...</option>');

        $.getJSON('<?= site_url('discussion/get_topics'); ?>/' + subject_id, function(res){
            var html = '<option value="">-- Select Topic --</option>';
            $.each(res, function(i, row){
                html += '<option value="'+row.topic_id+'">'+row.topic_order+'. '+row.topic_title+'</option>';
            });
            $('#topic_id').removeClass('select-loading').html(html);
        });
    });

    $('#student_remark').on('keyup', function(){
        $('#remark_count').text($(this).val().length);
    });

    $('#discussion-form').on('submit', function(e){
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url:'<?= site_url('discussion/store'); ?>',
            type:'POST',
            dataType:'json',
            data:formData,
            processData:false,
            contentType:false,
            beforeSend:function(){
                $('button[type=submit]').html('<i class="glyphicon glyphicon-refresh spinning"></i> Submitting...').prop('disabled',true);
            },
            success:function(res){
                $('button[type=submit]').html('<span class="glyphicon glyphicon-send"></span> Submit Request').prop('disabled',false);

                if(res.status==='success'){
                    $('#alert-container').html('<div class="alert alert-success"><b>Success!</b> ' + res.message + '</div>');
                    $('#discussion-form')[0].reset();
                    $('#meet-block').hide();
                    $('#remark_count').text(0);
                } if(res.status === 'error') {

                    // Build formatted message list
                    var list = '<ul>';
                    $.each(res.errors, function (k, v) {
                        list += '<li>' + v + '</li>';
                    });
                    list += '</ul>';

                    $('#alert-container').html(
                        '<div class="alert alert-danger">'+ list +'</div>'
                    );

                    // Highlight invalid fields
                    $('.form-group').removeClass('has-error');
                    $.each(res.errors, function (field, msg) {
                        $('[name="'+field+'"]').closest('.form-group').addClass('has-error');
                    });

                    // Scroll to top to show error clearly
                    $('html, body').animate({ scrollTop: $('#alert-container').offset().top - 100 }, 300);
                }

            }
        });
    });

});
</script>

</body>
</html>
