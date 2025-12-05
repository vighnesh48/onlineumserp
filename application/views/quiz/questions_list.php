
<head>
    <title>Quiz Questions</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<style>
body { background:#f2f7fd; font-family:'Poppins',sans-serif; }
.page-header-title{
    font-size:22px;font-weight:600;color:#167ea5;
    margin-bottom:15px;padding-bottom:10px;border-bottom:3px solid #167ea5;
}
.card-ui{
    background:#fff; padding:25px; border-radius:12px;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
}
.btn-info{ background:#167ea5; border-color:#167ea5;}
.btn-danger{background:#d9534f;}
</style>
</head>

<div class="container" style="max-width:1100px; margin-top:30px;">
    <div class="card-ui">

        <div class="page-header-title">
    <i class="fa fa-question-circle"></i> Questions for Quiz #<?=$quiz['id']?>

   
</div>

<a href="<?=site_url('QuizMaster/quiz_list')?>" class="btn btn-primary">
    <i class="fa fa-arrow-left"></i> Back to Quiz List
</a>
 <a href="<?=site_url('QuizMaster/deleted_questions/'.$quiz['id'])?>"
       class="btn btn-danger pull-right" style="margin-top:-5px;">
        <i class="fa fa-trash"></i> Recycle Bin
    </a>
        <hr>

        <table class="table table-bordered table-striped table-hover">
    <thead style="background:#167ea5;color:#fff;">
        <tr>
            <th>#</th>
            <th>Question</th>
            <th>Correct</th>
            <th>Marks</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
    <?php if(!empty($questions)): $i=1; foreach($questions as $q): ?>
        <tr>
            <td><?=$i++?></td>
            <td><?=strip_tags($q['question_text'])?></td>
            <td><span class="label label-info"><?=$q['correct_option']?></span></td>
            <td><?=$q['marks']?></td>
            <td>
                <!-- Preview Button -->
                <button class="btn btn-info btn-sm previewBtn" data-id="<?=$q['id']?>">
                    Preview
                </button>

                <!-- Edit Link -->
				<a href="<?=site_url('QuizMaster/edit_question/'.$q['id'])?>" 
				class="btn btn-warning btn-sm">
				Edit
				</a>
				<a href="<?=site_url('QuizMaster/delete_question/'.$q['id'])?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Are you sure you want to remove this question?');">
   Delete
</a>
            </td>
        </tr>
    <?php endforeach; else: ?>
        <tr>
            <td colspan="5" class="text-center text-danger">
                No Questions Added Yet
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

    </div>
</div>
<!-- Preview Modal -->
<div id="previewModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Question Preview</h4>
      </div>
      <div class="modal-body" id="previewContent">
        Loading...
      </div>
    </div>

  </div>
</div>
<script>
$(document).on("click", ".previewBtn", function() {
    var id = $(this).data("id");

    $.ajax({
        url: "<?=site_url('QuizMaster/preview_question/')?>/"+id,
        type: "GET",
        success: function(data){
            $("#previewContent").html(data);
            $("#previewModal").modal("show");
        }
    });
});
</script>