<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>

    <!-- Bootstrap 3 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/q5qizpro8tuffbxgbred7gh5ezvha0nx2bra8wec4a9hmmwp/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>

<style>
body { background:#f2f7fd; font-family:'Poppins',sans-serif; }
.card-ui{ background:#fff;padding:25px;border-radius:12px;box-shadow:0 5px 18px rgba(0,0,0,0.08);}
.page-header-title{ font-size:22px;font-weight:600;color:#167ea5;margin-bottom:15px;padding-bottom:10px;border-bottom:3px solid #167ea5;}
.btn-info{ background:#167ea5;border-color:#167ea5;}
</style>
</head>

<body>
<div class="container" style="max-width:900px;margin-top:30px;">
    <div class="card-ui">
        <div class="page-header-title">
            <i class="fa fa-edit"></i> Edit Question
        </div>

        <form method="post" action="<?=site_url('QuizMaster/update_question')?>">

            <input type="hidden" name="id" value="<?=$question['id']?>">
            <input type="hidden" name="quiz_id" value="<?=$question['quiz_id']?>">

            <div class="form-group">
                <label>Question</label>
                <textarea name="question_text" class="question-editor form-control" required><?=$question['question_text']?></textarea>
            </div>

            <div class="form-group">
                <label>Option A</label>
                <input type="text" name="option_a" class="form-control" value="<?=$question['option_a']?>" required>
            </div>

            <div class="form-group">
                <label>Option B</label>
                <input type="text" name="option_b" class="form-control" value="<?=$question['option_b']?>" required>
            </div>

            <div class="form-group">
                <label>Option C</label>
                <input type="text" name="option_c" class="form-control" value="<?=$question['option_c']?>" required>
            </div>

            <div class="form-group">
                <label>Option D</label>
                <input type="text" name="option_d" class="form-control" value="<?=$question['option_d']?>" required>
            </div>

            <div class="form-group">
                <label>Correct Answer</label>
                <select name="correct_option" class="form-control" required>
                    <option value="A" <?=$question['correct_option']=='A'?'selected':''?>>Option A</option>
                    <option value="B" <?=$question['correct_option']=='B'?'selected':''?>>Option B</option>
                    <option value="C" <?=$question['correct_option']=='C'?'selected':''?>>Option C</option>
                    <option value="D" <?=$question['correct_option']=='D'?'selected':''?>>Option D</option>
                </select>
            </div>

            <div class="form-group">
                <label>Marks</label>
                <input type="number" name="marks" class="form-control" value="<?=$question['marks']?>" required>
            </div>

            <button type="submit" class="btn btn-info">Update Question</button>
            <a href="<?=site_url('QuizMaster/questions/'.$question['quiz_id'])?>" class="btn btn-default">Cancel</a>
        </form>
    </div>
</div>

<script>
tinymce.init({
    selector: '.question-editor',
    height: 240,
    plugins: 'lists table link code',
    toolbar: 'undo redo | bold italic underline | bullist numlist | alignleft aligncenter alignright | table | code | link',
    branding: false
});
</script>

</body>
</html>
