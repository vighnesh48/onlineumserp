<div class="container" style="margin-top:40px; max-width:900px; font-family:'Poppins',sans-serif;">

    <!-- Main Result Card -->
    <div style="background:#ffffff; border-radius:14px; padding:30px; 
                box-shadow:0 10px 25px rgba(0,0,0,0.12); border-left:6px solid #167ea5;">

        <h2 style="font-weight:700; color:#167ea5; margin-bottom:10px;">
            <i class="fa fa-trophy"></i> Quiz Result
        </h2>
        <h4 style="font-weight:600; color:#444;"><?= $quiz['description']; ?></h4>
        <hr style="margin:15px 0;">

        <!-- Summary Grid -->
        <div class="row text-center">

            <div class="col-md-4">
                <div style="background:#167ea5; color:#fff; padding:18px; border-radius:10px;">
                    <h4 style="margin:0; font-size:18px; font-weight:700;">Total Marks</h4>
                    <h3 style="margin-top:5px; font-size:24px; font-weight:700;">
                        <?= $attempt['total_marks']; ?>
                    </h3>
                </div>
            </div>

            <div class="col-md-4">
                <div style="background:#28a745; color:#fff; padding:18px; border-radius:10px;">
                    <h4 style="margin:0; font-size:18px; font-weight:700;">Obtained</h4>
                    <h3 style="margin-top:5px; font-size:24px; font-weight:700;">
                        <?= $attempt['obtained_marks']; ?>
                        / <?= $attempt['total_marks']; ?>
                    </h3>
                </div>
            </div>

            <div class="col-md-4">
                <div style="background:#ffc107; color:#fff; padding:18px; border-radius:10px;">
                    <h4 style="margin:0; font-size:18px; font-weight:700;">Percentage</h4>
                    <h3 style="margin-top:5px; font-size:24px; font-weight:700;">
                        <?= round($attempt['percentage'],2); ?>%
                    </h3>
                </div>
            </div>

            

        </div>
    </div>

    <!-- Question Review Title -->
    <h3 style="margin-top:35px; font-weight:700; color:#167ea5;">
        <i class="fa fa-list"></i> Question Review
    </h3>
    <hr>

    <!-- Question Cards -->
    <?php foreach($questions as $q): ?>
        <div style="background:#fff; padding:20px; border-radius:12px; margin-bottom:18px;
                    box-shadow:0 4px 12px rgba(0,0,0,0.08); border-left:6px solid #167ea5;">
            
            <p style="font-size:16px; font-weight:600; color:#333;">
                <i class="fa fa-question-circle" style="color:#167ea5;"></i> 
                <?= strip_tags($q['question_text']); ?>
            </p>

            <p><strong>Correct Answer:</strong> 
                <span class="label label-success" style="font-size:14px; padding:6px 14px;">
                    <?= $q['correct_option']; ?>
                </span>
            </p>

            <p><strong>Your Answer:</strong> 
                <?php if($q['selected_option'] == $q['correct_option']): ?>
                    <span class="label label-primary" style="font-size:14px; padding:6px 14px;">
                        <?= $q['selected_option']; ?>
                    </span>
                <?php else: ?>
                    <span class="label label-danger" style="font-size:14px; padding:6px 14px;">
                        <?= $q['selected_option']; ?>
                    </span>
                <?php endif; ?>
            </p>

            <p><strong>Marks Obtained:</strong>
                <?php if($q['marks_obtained'] > 0): ?>
                    <span class="label label-success" style="font-size:14px; padding:6px 14px;">
                        <?= $q['marks_obtained']; ?>
                    </span>
                <?php else: ?>
                    <span class="label label-danger" style="font-size:14px; padding:6px 14px;">
                        <?= $q['marks_obtained']; ?>
                    </span>
                <?php endif; ?>
            </p>

        </div>
    <?php endforeach; ?>

    <!-- Print button -->
    <center>
       <a href="<?=site_url('QuizMaster/download_result_pdf/'.$attempt['id'])?>" 
   class="btn btn-success btn-lg" 
   style="border-radius:25px; padding:8px 30px; font-weight:600; margin-top:10px;">
   <i class="fa fa-file-pdf-o"></i> Download PDF
</a>
    </center>

</div>
