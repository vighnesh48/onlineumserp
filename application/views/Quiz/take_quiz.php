<h3>Quiz: <?=$quiz['description']?></h3>

<form method="post" action="<?=site_url('quiz/submit_quiz/'.$quiz['id'])?>">
<?php $no=1; foreach ($questions as $q): ?>
<div class="panel panel-default">
    <div class="panel-heading">Q<?=$no++?>. <?=$q['question_text']?></div>
    <div class="panel-body">
        <?php $name = "q_".$q['id']; ?>
        <label><input type="radio" name="<?=$name?>" value="A"> <?=$q['option_a']?></label><br>
        <label><input type="radio" name="<?=$name?>" value="B"> <?=$q['option_b']?></label><br>
        <label><input type="radio" name="<?=$name?>" value="C"> <?=$q['option_c']?></label><br>
        <label><input type="radio" name="<?=$name?>" value="D"> <?=$q['option_d']?></label><br>
    </div>
</div>
<?php endforeach; ?>

<button class="btn btn-success">Submit Quiz</button>
</form>
