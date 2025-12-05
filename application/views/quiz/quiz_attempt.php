<?php
$total_questions = count($questions);
$total_marks = 0;
foreach($questions as $qq){ $total_marks += $qq['marks']; }
?>

<style>
body{
    background:#f4f6fb;
    font-family:'Poppins',sans-serif;
}

/* ===== PAGE LAYOUT ===== */
.quiz-page{
    max-width:1200px;
    margin:25px auto 60px;
    padding:0 15px;
}

/* ===== HEADER (GRADIENT) ===== */
.quiz-header{
    background:linear-gradient(135deg,#ff416c,#ff4b2b);
    border-radius:18px;
    padding:16px 24px;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:space-between;
    box-shadow:0 10px 30px rgba(255,65,108,0.35);
}

.header-left-title{
    font-size:18px;
    font-weight:600;
}

.header-meta{
    font-size:12px;
    opacity:0.9;
    margin-top:4px;
}

.header-right{
    display:flex;
    align-items:center;
    gap:14px;
}

.timer-pill{
    background:#ffffff;
    color:#ff2e63;
    padding:6px 16px;
    border-radius:999px;
    font-size:14px;
    font-weight:700;
    border:2px solid rgba(255,255,255,0.8);
}

/* progress bar */
.progress-wrapper{
    width:180px;
}
.progress-label{
    font-size:11px;
    font-weight:600;
    margin-bottom:4px;
}
.progressbar{
    width:100%;
    height:7px;
    border-radius:999px;
    background:rgba(255,255,255,0.35);
    overflow:hidden;
}
.progress-fill{
    height:100%;
    width:0%;
    border-radius:999px;
    background:linear-gradient(90deg,#00c9ff,#92fe9d);
    transition:width .25s ease-out;
}

/* ===== MAIN CARD LAYOUT ===== */
.quiz-layout{
    display:flex;
    gap:18px;
    margin-top:18px;
}

/* main question area */
.quiz-main{
    flex:1;
    background:#ffffff;
    border-radius:16px;
    padding:22px 26px 26px;
    box-shadow:0 8px 22px rgba(15,23,42,0.12);
}

/* sidebar palette */
.quiz-sidebar{
    width:230px;
    background:#ffffff;
    border-radius:16px;
    padding:18px 18px 20px;
    box-shadow:0 8px 22px rgba(15,23,42,0.12);
}

/* ===== TOP STRIP (TOTALS) ===== */
.main-top-strip{
    display:flex;
    justify-content:flex-start;
    gap:18px;
    margin-bottom:12px;
    font-size:12px;
    font-weight:600;
}

.main-pill{
    background:#f3f4ff;
    padding:6px 12px;
    border-radius:10px;
    color:#111827;
}
.main-pill span.value{
    font-weight:700;
    margin-left:4px;
}

/* ===== QUESTION NAV BAR ===== */
.question-nav{
    display:flex;
    align-items:center;
    justify-content:center;
    margin:12px 0 4px;
}

.nav-arrow{
    width:30px;
    height:30px;
    border-radius:999px;
    border:1px solid #ff416c;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    font-size:18px;
    color:#ff416c;
    margin:0 14px;
    transition:.2s;
    background:#fff7f9;
}
.nav-arrow:hover{
    background:#ff416c;
    color:#fff;
}
.nav-arrow.disabled{
    opacity:.35;
    pointer-events:none;
}

.nav-pill{
    padding:6px 18px;
    border-radius:999px;
    border:1px solid #e5e7eb;
    font-size:13px;
    font-weight:600;
    color:#111827;
    background:#f9fafb;
}

/* MCQ badge */
.qtype-badge{
    display:inline-block;
    margin-top:6px;
    padding:3px 12px;
    border-radius:999px;
    background:#edf2ff;
    color:#4338ca;
    font-size:11px;
    font-weight:600;
}

/* divider */
.main-divider{
    border:0;
    border-top:1px solid #e5e7eb;
    margin:14px 0 18px;
}

/* ===== QUESTION TEXT ===== */
.question-text{
    font-size:15px;
    font-weight:600;
    color:#111827;
    margin-bottom:18px;
    line-height:1.5;
}

/* ===== OPTIONS (with glow) ===== */
.option-item{
    display:flex;
    align-items:flex-start;
    gap:10px;
    padding:10px 13px;
    border-radius:12px;
    border:1px solid #e5e7eb;
    margin-bottom:8px;
    font-size:14px;
    cursor:pointer;
    background:#fdfdff;
    transition:background .18s,border-color .18s,box-shadow .18s,transform .12s;
}
.option-item:hover{
    background:#f0f7ff;
    border-color:#60a5fa;
    box-shadow:0 0 0 1px rgba(96,165,250,0.7);
}
.option-item input[type=radio]{
    margin-top:2px;
    transform:scale(1.1);
    cursor:pointer;
}
.option-text{
    color:#1f2937;
}

/* selected (glow) */
.option-item.selected{
    border-color:#ff416c;
    background:#fff1f5;
    box-shadow:0 0 0 2px rgba(255,65,108,0.45),0 6px 12px rgba(248,113,113,0.35);
    transform:translateY(-1px);
}
.option-item.selected .option-text{
    color:#7f1d1d;
    font-weight:600;
}

/* ===== FOOTER BUTTONS ===== */
.quiz-footer{
    margin-top:22px;
    text-align:center;
}
.quiz-btn{
    display:inline-block;
    min-width:120px;
    padding:9px 20px;
    border-radius:999px;
    border:none;
    font-size:12px;
    font-weight:600;
    letter-spacing:.04em;
    cursor:pointer;
    margin:0 6px;
    transition:.2s;
}

.btn-prev{
    background:#e5e7eb;
    color:#374151;
}
.btn-prev:hover{ background:#d1d5db; }

.btn-next{
    background:linear-gradient(135deg,#ff416c,#ff4b2b);
    color:#fff;
}
.btn-next:hover{
    filter:brightness(0.92);
}

.btn-complete{
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    color:#fff;
}
.btn-complete:hover{
    filter:brightness(0.92);
}
.btn-prev:disabled{
    opacity:.4;
    cursor:not-allowed;
}

/* ===== SIDEBAR / PALETTE ===== */
.sidebar-title{
    font-size:13px;
    font-weight:600;
    margin-bottom:10px;
    color:#111827;
}
.palette-grid{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
}
.palette-item{
    width:34px;
    height:34px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    border:1px solid #e5e7eb;
    background:#f9fafb;
    color:#4b5563;
    transition:.2s;
}
.palette-item:hover{
    background:#eff6ff;
    border-color:#60a5fa;
}

/* palette states */
.palette-item.current{
    background:#ff416c;
    color:#fff;
    border-color:#ff416c;
    box-shadow:0 0 0 2px rgba(255,65,108,0.4);
}
.palette-item.answered{
    background:#2563eb;
    color:#fff;
    border-color:#2563eb;
}
.palette-item.not-visited{
    opacity:.6;
}

.sidebar-legend{
    margin-top:14px;
    font-size:11px;
}
.sidebar-legend span.dot{
    display:inline-block;
    width:10px;
    height:10px;
    border-radius:999px;
    margin-right:4px;
}
.legend-entry{ margin-bottom:4px; }
</style>

<div class="quiz-page">

    <!-- ===== Header / Title / Timer / Progress ===== -->
    <div class="quiz-header">
        <div>
            <div class="header-left-title">
                <?= !empty($quiz['description']) ? htmlspecialchars($quiz['description']) : 'Online Assessment'; ?>
            </div>
            <div class="header-meta">
                MCQ • <?= $total_questions; ?> Questions • <?= $total_marks; ?> Marks
            </div>
        </div>

        <div class="header-right">
            <div class="progress-wrapper">
                <div class="progress-label">Progress: <span id="progressText">0%</span></div>
                <div class="progressbar"><div id="progressFill" class="progress-fill"></div></div>
            </div>
            <div class="timer-pill">
                Time: <span id="quizTimer">00:00</span>
            </div>
        </div>
    </div>

    <!-- ===== MAIN LAYOUT: Question + Palette ===== -->
    <div class="quiz-layout">

        <!-- MAIN QUESTION AREA -->
        <div class="quiz-main">
            <div class="main-top-strip">
                <div class="main-pill">
                    Total Question:<span class="value"><?= $total_questions; ?></span>
                </div>
                <div class="main-pill">
                    Total Marks:<span class="value"><?= $total_marks; ?></span>
                </div>
            </div>

            <!-- Question nav row -->
            <div class="question-nav">
                <div id="prevArrow" class="nav-arrow">&#8249;</div>
                <div class="nav-pill">
                    Question <span id="currentQ">1</span> of <?= $total_questions; ?>
                </div>
                <div id="nextArrow" class="nav-arrow">&#8250;</div>
            </div>
            <div style="text-align:center;">
                <span class="qtype-badge">MCQ</span>
            </div>

            <hr class="main-divider">

            <!-- Questions -->
            <?php $i=0; foreach($questions as $q): ?>
                <div class="question-block" id="qBlock_<?= $i; ?>"
                    data-qindex="<?= $i; ?>" data-qid="<?= $q['id']; ?>"
                    style="<?= $i==0 ? '' : 'display:none;'; ?>">

                    <div class="question-text">
                        <?= ($i+1).'. '.$q['question_text']; ?>
                    </div>

                    <label class="option-item">
                        <input type="radio" class="opt-radio"
                               name="q<?= $q['id']; ?>" value="A">
                        <span class="option-text"><?= $q['option_a']; ?></span>
                    </label>

                    <label class="option-item">
                        <input type="radio" class="opt-radio"
                               name="q<?= $q['id']; ?>" value="B">
                        <span class="option-text"><?= $q['option_b']; ?></span>
                    </label>

                    <label class="option-item">
                        <input type="radio" class="opt-radio"
                               name="q<?= $q['id']; ?>" value="C">
                        <span class="option-text"><?= $q['option_c']; ?></span>
                    </label>

                    <label class="option-item">
                        <input type="radio" class="opt-radio"
                               name="q<?= $q['id']; ?>" value="D">
                        <span class="option-text"><?= $q['option_d']; ?></span>
                    </label>
                </div>
            <?php $i++; endforeach; ?>

            <!-- Buttons -->
            <div class="quiz-footer">
                <button type="button" id="btnPrev" class="quiz-btn btn-prev" disabled>PREVIOUS</button>
                <button type="button" id="btnNext" class="quiz-btn btn-next">NEXT</button>
                <button type="button" id="btnComplete" class="quiz-btn btn-complete">COMPLETE TEST</button>
            </div>
        </div>

        <!-- SIDEBAR: PALETTE -->
        <div class="quiz-sidebar">
            <div class="sidebar-title">Question Palette</div>
            <div class="palette-grid">
                <?php for($i=0;$i<$total_questions;$i++): ?>
                    <div class="palette-item not-visited" id="pal_<?= $i; ?>" data-target="<?= $i; ?>">
                        <?= $i+1; ?>
                    </div>
                <?php endfor; ?>
            </div>

            <div class="sidebar-legend">
                <div class="legend-entry">
                    <span class="dot" style="background:#ff416c;"></span> Current Question
                </div>
                <div class="legend-entry">
                    <span class="dot" style="background:#2563eb;"></span> Answered
                </div>
                <div class="legend-entry">
                    <span class="dot" style="background:#e5e7eb;"></span> Not Visited
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden fields -->
<input type="hidden" id="attemptId" value="<?= $attempt['id']; ?>">
<input type="hidden" id="quizId" value="<?= $quiz['id']; ?>">
<input type="hidden" id="tabCount" value="0">
<input type="hidden" id="remainingSeconds" value="<?= (int)$remaining_seconds; ?>">

<script>
var totalQuestions = <?= (int)$total_questions; ?>;
var currentIndex   = 0;
var attemptId      = $('#attemptId').val();
var remaining      = parseInt($('#remainingSeconds').val()) || 0;
var tabCount       = 0;
var answeredMap    = {}; // questionIndex => true/false

/* ===== TIMER ===== */
function startTimer(){
    updateTimerLabel();
    var t = setInterval(function(){
        remaining--;
        if(remaining <= 0){
            clearInterval(t);
            alert("Time is over. Your test will be submitted automatically.");
            submitAttempt('timeout');
        } else {
            updateTimerLabel();
        }
    },1000);
}
function updateTimerLabel(){
    var min = Math.floor(remaining/60);
    var sec = remaining%60;
    var text = ('0'+min).slice(-2)+':'+('0'+sec).slice(-2);
    $('#quizTimer').text(text);
}

/* ===== NAVIGATION ===== */
function showQuestion(index){
    $('.question-block').hide();
    $('#qBlock_'+index).show();
    $('#currentQ').text(index+1);

    // prev button & arrow
    if(index === 0){
        $('#btnPrev').prop('disabled', true);
        $('#prevArrow').addClass('disabled');
    }else{
        $('#btnPrev').prop('disabled', false);
        $('#prevArrow').removeClass('disabled');
    }

    // palette current highlight
    $('.palette-item').removeClass('current');
    $('#pal_'+index).removeClass('not-visited').addClass('current');
}

$('#btnPrev, #prevArrow').on('click', function(){
    if(currentIndex>0){
        currentIndex--;
        showQuestion(currentIndex);
    }
});
$('#btnNext, #nextArrow').on('click', function(){
    if(currentIndex<totalQuestions-1){
        currentIndex++;
        showQuestion(currentIndex);
    }
});

/* ===== PALETTE CLICK ===== */
$('.palette-item').on('click', function(){
    var idx = parseInt($(this).data('target'));
    currentIndex = idx;
    showQuestion(currentIndex);
});

/* ===== SAVE ANSWER + GLOW + PROGRESS ===== */
function updateProgress(){
    var answeredCount = Object.keys(answeredMap).length;
    var perc = totalQuestions>0 ? Math.round((answeredCount/totalQuestions)*100) : 0;
    $('#progressText').text(perc+'%');
    $('#progressFill').css('width', perc+'%');

    // palette color for answered
    for (var i=0;i<totalQuestions;i++){
        var pal = $('#pal_'+i);
        if(answeredMap[i]){
            pal.removeClass('not-visited').addClass('answered');
        }
    }
}

$('.opt-radio').on('change', function(){
    var block = $(this).closest('.question-block');
    var qid   = block.data('qid');
    var val   = $(this).val();
    var qindex= parseInt(block.data('qindex'));

    // glow selection UI
    block.find('.option-item').removeClass('selected');
    $(this).closest('.option-item').addClass('selected');

    // mark answered
    answeredMap[qindex] = true;
    updateProgress();

    // send to server
    $.post("<?= site_url('QuizMaster/save_answer'); ?>", {
        attempt_id: attemptId,
        question_id: qid,
        selected_option: val
    });
});

/* ===== SUBMIT / COMPLETE TEST ===== */
$('#btnComplete').on('click', function(){
    if(confirm("Are you sure you want to submit the test?")){
        submitAttempt('student');
    }
});

function submitAttempt(reason){
    // REMOVE page-leave warning
    window.onbeforeunload = null;

    $.post("<?= site_url('QuizMaster/submit_attempt'); ?>", {
        attempt_id: attemptId,
        reason: reason
    }, function(res){
        if(res.status){
            window.location = res.redirect;
        }else{
            alert(res.msg || 'Unable to submit. Please contact admin.');
        }
    }, 'json');
}
/* ===== ANTI-CHEAT: TAB CHANGE ===== */
/*document.addEventListener("visibilitychange", function () {
    if (document.hidden) {
        tabCount++;
        $('#tabCount').val(tabCount);

        $.post("<?= site_url('QuizMaster/update_tab_count'); ?>", {
            attempt_id: attemptId,
            tab_count : tabCount
        });

        if(tabCount === 1){
            alert("Warning: Do not switch tabs during the test. (1/3)");
        } else if(tabCount === 2){
            alert("Final Warning: Next tab switch will close your test. (2/3)");
        } else if(tabCount >= 3){
            alert("You switched tabs multiple times. Your test will be submitted.");
            submitAttempt('violation');
        }
    }
});*/

/* ===== BEFORE UNLOAD ===== */
window.onbeforeunload = function(){
    return "Your test is still running. If you leave, the test may be submitted.";
};

/* INIT */
$(function(){
    // mark first palette as current not visited
    $('#pal_0').removeClass('not-visited').addClass('current');
    showQuestion(0);
    startTimer();
    updateProgress();
});
</script>
