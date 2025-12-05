<div class="panel panel-default" style="border-radius:10px;">
    <div class="panel-heading" style="background:#167ea5;color:#fff;border-radius:10px 10px 0 0;">
        <h4 style="margin:0;font-weight:600;">
            <i class="fa fa-eye"></i> Question Preview
        </h4>
    </div>

    <div class="panel-body" style="font-size:15px;">

        <div style="padding:10px 0;">
            <h4 style="font-weight:600;color:#167ea5;">
                <i class="fa fa-question-circle"></i> <?= $question['question_text']; ?>
            </h4>
        </div>

        <hr>

        <table class="table table-bordered">
            <tr>
                <th style="width:150px;background:#f2f2f2;">Option A</th>
                <td><?= $question['option_a']; ?></td>
            </tr>
            <tr>
                <th style="background:#f2f2f2;">Option B</th>
                <td><?= $question['option_b']; ?></td>
            </tr>
            <tr>
                <th style="background:#f2f2f2;">Option C</th>
                <td><?= $question['option_c']; ?></td>
            </tr>
            <tr>
                <th style="background:#f2f2f2;">Option D</th>
                <td><?= $question['option_d']; ?></td>
            </tr>
        </table>

        <div style="margin-top:15px;">
            <p><b>Correct Answer:</b> 
                <span class="label label-success" style="font-size:14px;">
                    <?= $question['correct_option']; ?>
                </span>
            </p>
            <p><b>Marks:</b> 
                <span class="label label-primary" style="font-size:14px;"><?= $question['marks']; ?></span>
            </p>
        </div>

    </div>
</div>
