<!DOCTYPE html>
<html>
<head>
    <title>Quiz List</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        body { background:#f2f7fd; font-family:'Poppins',sans-serif; }
        .page-header-title{
            font-size:22px;font-weight:600;color:#167ea5;
            margin-bottom:20px;padding-bottom:10px;border-bottom:3px solid #167ea5;
        }
        .table-responsive {
            background:#fff;
            padding:20px;
            border-radius:10px;
            box-shadow:0 5px 18px rgba(0,0,0,0.08);
        }
        table th, table td { vertical-align:middle !important; }
        table thead { font-size:14px; }
        table tbody tr:hover { background:#eef8ff; transition:0.2s; }
        .btn-info, .btn-primary { background:#167ea5;border-color:#167ea5; }
        .btn-info:hover, .btn-primary:hover { background:#0d5c75;border-color:#0d5c75; }
        .label-info { background:#167ea5; }
		
		
		.btn-sm {
    font-size:13px;
    font-weight:600;
    border-radius:4px;
}

.btn-info {
    background:#167ea5;
    border-color:#167ea5;
}

.btn-info:hover {
    background:#0f6b85;
}

.btn-danger:hover {
    background:#c9302c;
}

    </style>
</head>

<body>
<div class="container" style="margin-top:40px; max-width:1200px;">

    <div class="page-header-title"><i class="fa fa-list"></i> Quiz Listing</div>

    <?php if($this->session->flashdata('msg')): ?>
        <div class="alert alert-success"><?=$this->session->flashdata('msg');?></div>
    <?php endif; ?>

    <a href="<?=site_url('QuizMaster')?>" class="btn btn-primary" style="margin-bottom:15px;">
        <i class="fa fa-plus"></i> Create New Quiz
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead style="background:#167ea5;color:#fff;">
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Unit</th>
                    <th>Description</th>
                    <th>Total Questions</th>
                    <th>Created At</th>
                    <th style="width:170px;">Action</th>
                </tr>
            </thead>

            <tbody>
            <?php if(!empty($quizzes)): $i=1; foreach($quizzes as $q): ?>
                <tr>
                    <td><?=$i++?></td>
                    <td><?=$q['subject_name']?></td>
                    <td><?=$q['topic_title']?></td>
                    <td><?=$q['description']?></td>
                    <td><span class="label label-info"><?=$q['total_questions']?></span></td>
                    <td><?=$q['created_at']?></td>
                  <td style="white-space:nowrap;">

    <a href="<?=site_url('QuizMaster/questions/'.$q['id'])?>"
       class="btn btn-info btn-sm"
       style="margin-right:6px; padding:5px 12px;">
       <i class="fa fa-eye"></i>
    </a>

    <a href="<?=site_url('QuizMaster/delete_quiz/'.$q['id'])?>"
       class="btn btn-danger btn-sm"
       onclick="return confirm('Move this quiz to Recycle Bin?')"
       style="padding:5px 12px;">
       <i class="fa fa-trash"></i>
    </a>

</td>
                </tr>
            <?php endforeach; else: ?>
                <tr>
                    <td colspan="7" class="text-center text-danger">No Quiz Available</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>
