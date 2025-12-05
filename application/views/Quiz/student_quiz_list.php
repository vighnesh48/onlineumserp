<style>
.quiz-card {
    background: #fff;
    border-radius: 14px;
    padding: 25px 28px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    margin-bottom: 30px;
    transition: all .3s ease;
    border: 1px solid #e8e8e8;
}
.quiz-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

.quiz-title {
    font-size: 22px;
    font-weight: 700;
    color: #233142;
    margin-bottom: 6px;
}

.quiz-meta {
    font-size: 14px;
    color: #666;
    margin-bottom: 18px;
}

.divider {
    height: 2px;
    background: #f1f1f1;
    margin: 15px 0;
}

.quiz-label {
    font-size: 13px;
    font-weight: 600;
    color: #777;
}

.quiz-value {
    font-size: 18px;
    font-weight: 700;
    color: #111;
}

.btn-view, .btn-start {
    padding: 8px 26px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
}

.btn-view {
    background: #B31312;
    border: 1px solid #B31312;
    color: #fff;
}
.btn-view:hover {
    background: #920E1C;
}

.btn-start {
    background: #167EA5;
    border: 1px solid #167EA5;
    color: #fff;
}
.btn-start:hover {
    background: #0F5C7A;
}

.status-attempted {
    color: #0C7B25;
    font-weight: 700;
}
.status-not {
    color: #C08900;
    font-weight: 700;
}

.status-icon {
    font-size: 18px;
    margin-right: 6px;
}
</style>


<div class="container" style="margin-top:35px;">
    <h2 style="color:#233142;font-weight:700;margin-bottom:10px;">Continuous Assessment</h2>
    <p style="color:#666;font-size:15px;border-bottom:3px solid #920E1C;width:200px;padding-bottom:5px;">Available Quizzes</p>

    <div class="row">
        <?php if(!empty($quizzes)){ foreach($quizzes as $q){ ?>
            <div class="col-md-6">
                <div class="quiz-card">

                    <div class="quiz-title"><?= $q['description'] ?></div>
                    <div class="quiz-meta">Objective Type Test</div>

                    <div class="divider"></div>

                    <div class="row text-center">
                        <div class="col-xs-6">
                            <div class="quiz-label">Duration</div>
                            <div class="quiz-value"><?= $q['quiz_time']; ?> Min</div>
                        </div>
                        <div class="col-xs-6">
                            <div class="quiz-label">Total Marks</div>
                            <div class="quiz-value"><?= $q['total_marks']; ?></div>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="row">
                        <div class="col-xs-6" style="padding-top:10px;">
                            <?php if($q['attempt_status']=="attempted"){ ?>
                                <span class="status-icon">✔</span>
                                <span class="status-attempted">Attempted</span>
                            <?php } else { ?>
                                <span class="status-icon">⏳</span>
                                <span class="status-not">Not Attempted</span>
                            <?php } ?>
                        </div>

                        <div class="col-xs-6 text-right">
                            <?php if($q['attempt_status']=="attempted"){ ?>
                                <a href="<?=site_url('QuizMaster/attempt_result/'.$q['attempt_id'])?>" class="btn-view">VIEW</a>
                            <?php } else { ?>
                                <a href="<?=site_url('QuizMaster/start_quiz/'.$q['id'])?>" class="btn-start">START</a>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        <?php }} else { ?>
            <p class="text-center">No Quizzes Assigned</p>
        <?php } ?>
    </div>
</div>
