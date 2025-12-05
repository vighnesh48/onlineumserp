<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title; ?></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="<?= base_url('assets/css/helpdesk_student.css'); ?>">

</head>
<body>
<div class="container">
    <h3 class="page-header">
        New Helpdesk Ticket
        <small class="pull-right">
            <a href="<?= site_url('helpdesk'); ?>" class="btn btn-default btn-xs">
                <span class="glyphicon glyphicon-list"></span> My Tickets
            </a>
        </small>
    </h3>

    <div id="alert-container"></div>

    <div class="panel panel-custom">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-bullhorn"></span> Raise a Concern / Request
        </div>
        <div class="panel-body">
            <form id="ticket-form" class="form-horizontal" enctype="multipart/form-data">

                <div class="form-group">
                    <label class="col-sm-3 control-label">Category <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            <?php foreach($categories as $c): ?>
                                <option value="<?= $c->category_id; ?>"><?= $c->category_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="help-block">Choose the area of your issue/complaint.</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Priority <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <select name="priority" id="priority" class="form-control">
                            <option value="LOW">Low</option>
                            <option value="MEDIUM">Medium</option>
                            <option value="HIGH">High</option>
                            <option value="CRITICAL">Critical</option>
                        </select>
                        <span class="help-block">For emergency/sensitive issues use HIGH / CRITICAL.</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Title <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" name="title" id="title" class="form-control">
                        <span class="help-block">Short summary of your issue.</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Description <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <textarea name="description" id="description" rows="4" class="form-control" maxlength="1000"></textarea>
                        <div class="text-right"><span id="desc_count">0</span>/1000</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Attach File</label>
                    <div class="col-sm-6">
                        <input type="file" name="attachment" id="attachment" class="form-control">
                        <span class="help-block">Proof / screenshot / document (optional).</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Anonymous?</label>
                    <div class="col-sm-6">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="is_anonymous" value="1"> Do not show my name to handler
                        </label>
                        <span class="help-block">For sensitive issues, only nodal officer can see your identity.</span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-send"></span> Submit Ticket
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
$(function(){

    $('#description').on('keyup', function(){
        $('#desc_count').text($(this).val().length);
    });

    $('#ticket-form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '<?= site_url("helpdesk/store"); ?>',
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $('#alert-container').html('');
                $('button[type=submit]').prop('disabled', true);
            },
            success: function(res){
                $('button[type=submit]').prop('disabled', false);

                if(res.status === 'success'){
                    $('#alert-container').html(
                        '<div class="alert alert-success"><b>Success!</b> '+res.message+
                        ' Ticket No: <span class="label label-primary">'+res.ticket_no+'</span></div>'
                    );
                    $('#ticket-form')[0].reset();
                    $('#desc_count').text(0);
                } else if(res.errors) {
                    var list = '<ul>';
                    $.each(res.errors, function(k,v){
                        list += '<li>'+v+'</li>';
                    });
                    list += '</ul>';
                    $('#alert-container').html('<div class="alert alert-danger">'+list+'</div>');
                } else {
                    $('#alert-container').html('<div class="alert alert-danger">'+res.message+'</div>');
                }
            }
        });
    });

});
</script>
</body>
</html>
