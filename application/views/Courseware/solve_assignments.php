
<style>
    body { background:#eeeeee; font-family:"Roboto", sans-serif; }

    .test-box {


        padding:25px;
        margin-top:20px;
    }

    .top-meta {
        padding:10px;
        font-size:16px;
        font-weight:700;
        border-bottom:1px solid #eeeeee;
    }

    .meta-item { margin-right:25px; display:inline-block; }
    .timer { float:right; color:#008000; font-weight:700; }

    .nav-btn {
        border:1px solid #dcdcdc;
        padding:8px 18px;
        border-radius:8px;
        font-size:16px;
        cursor:pointer;
        background:#fff;
    }

    .question-area { margin-top:25px; font-size:20px; font-weight:700; }

    .mcq-badge {
        background:#dcdcdc; padding:5px 15px;
        border-radius:15px; font-size:14px;
        font-weight:700; margin-left:15px;
        display:inline-block;
    }
 .ticket-container {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 25px;
            margin: 25px auto;
           
        }
    .options { margin-top:25px; }
    .options label {
        margin-bottom:12px;
        font-size:18px;
        font-weight:500;
        display:block;
        cursor:pointer;
    }
 .btn-submit {
            background: #1c8eb3;
            color: #ffffff;
            padding: 8px 25px;
            border-radius: 25px;
            border: none;
        }
    input[type=radio] {
        margin-right:10px; width:20px; height:20px; cursor:pointer;
    }

    .footer-nav { margin-top:30px; text-align:center; }

  

</style>

<div class="container-fluid" style="padding:40px 25px;margin-top:20px">
    <div class="ticket-container">

    <div class="test-box">

        <div class="top-meta">
            <span class="meta-item">Total Question: <strong>15</strong></span>
            <span class="meta-item">Total Marks: <strong>15</strong></span>

            <span class="timer">Time: <span id="timer">00:14:46</span></span>
        </div>

        <!-- Question Navigation -->
        <div style="text-align:center; margin-top:20px;">
            <button class="nav-btn" id="prevTop">&lsaquo;</button>
            <span style="font-size:18px; font-weight:700; margin:0 15px;">Question 1 of 15</span>
            <button class="nav-btn" id="nextTop">&rsaquo;</button>
        </div>

        <!-- MCQ Badge -->
        <div style="text-align:center; margin-top:10px;">
            <span class="mcq-badge">MCQ</span>
        </div>

        <!-- Question Section -->
        <div class="question-area">
            1. Which argument strategy uses personal experiences as evidence?
        </div>

        <!-- Options -->
        <div class="options">
            <label><input type="radio" name="q1">Argument by Cause</label>
            <label><input type="radio" name="q1">Argument by Authority</label>
            <label><input type="radio" name="q1">Argument by Testimony</label>
            <label><input type="radio" name="q1">Argument by Sign</label>
        </div>

        <!-- Bottom Buttons -->
        <div class="footer-nav">
            <button class="btn-prev btn-submit">PREVIOUS</button>
            <button class="btn-submit">NEXT</button>
            <button class=" btn-submit">COMPLETE TEST</button>
        </div>

    </div>

</div>

<!-- Basic Timer Example -->
<script>
var time = 14 * 60 + 46; // 14 min 46 sec
var timerInterval = setInterval(function() {
    var minutes = Math.floor(time / 60);
    var seconds = time % 60;
    document.getElementById("timer").innerHTML =
        "00:" + (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
    time--;
    if (time < 0) { clearInterval(timerInterval); }
}, 1000);
</script>
