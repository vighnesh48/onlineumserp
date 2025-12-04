<?php if($this->session->flashdata('msg')): ?>
<div class="alert alert-success"><?=$this->session->flashdata('msg');?></div>
<?php endif; ?>

<h3>Add Questions - Quiz ID: <?=$quiz['id']?></h3>

<form method="post">
    <textarea name="question_text" class="form-control" required></textarea><br>
    <input type="text" name="option_a" placeholder="Option A" class="form-control" required><br>
    <input type="text" name="option_b" placeholder="Option B" class="form-control" required><br>
    <input type="text" name="option_c" placeholder="Option C" class="form-control" required><br>
    <input type="text" name="option_d" placeholder="Option D" class="form-control" required><br>

    <select name="correct_option" class="form-control" required>
        <option value="">Correct Answer</option>
        <option value="A">Option A</option>
        <option value="B">Option B</option>
        <option value="C">Option C</option>
        <option value="D">Option D</option>
    </select><br>

    <input type="number" name="marks" value="1" class="form-control" required><br>

    <button class="btn btn-primary">Add Question</button>
</form>
<hr>

<h4>Existing Questions</h4>
<table class="table table-bordered">
<tr><th>#</th><th>Question</th><th>Answer</th><th>Marks</th></tr>
<?php $i=1; foreach($questions as $q): ?>
<tr>
    <td><?=$i++?></td>
    <td><?=$q['question_text']?></td>
    <td><?=$q['correct_option']?></td>
    <td><?=$q['marks']?></td>
</tr>
<?php endforeach; ?>
</table>
