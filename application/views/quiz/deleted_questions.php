<!DOCTYPE html>
<html>
<head>
    <title>Deleted Questions</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<style>
body { background:#f2f7fd; font-family:'Poppins',sans-serif; }
.page-header-title{
    font-size:22px;font-weight:600;color:#d9534f;
    margin-bottom:15px;padding-bottom:10px;border-bottom:3px solid #d9534f;
}
.card-ui{
    background:#fff;padding:25px;border-radius:12px;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
}
</style>
</head>

<body>

<div class="container" style="max-width:1100px;margin-top:30px;">
    <div class="card-ui">
        <div class="page-header-title">
            <i class="fa fa-trash"></i> Deleted Questions (Recycle Bin)

            <a href="<?=site_url('QuizMaster/questions/'.$quiz_id)?>" 
               class="btn btn-primary pull-right" style="margin-top:-5px;">
               <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>

        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-success"><?=$this->session->flashdata('msg');?></div>
        <?php endif; ?>

        <table class="table table-bordered table-hover">
            <thead style="background:#d9534f;color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Deleted On</th>
                    <th>Restore</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($questions as $q): ?>
                <tr>
                    <td><?=$i++?></td>
                    <td><?=strip_tags($q['question_text']);?></td>
                    <td><?=date("d-m-Y h:i A", strtotime($q['deleted_at']))?></td>
                    <td>
                        <a href="<?=site_url('QuizMaster/restore_question/'.$q['id'].'/'.$quiz_id)?>"
                           class="btn btn-success btn-sm">
                           <i class="fa fa-reply"></i> Restore
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>
