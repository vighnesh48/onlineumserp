<!DOCTYPE html>
<html>
<head>
<style>
body { font-family: DejaVu Sans, sans-serif; font-size:12px; color:#222; }

.header {
    text-align:center;
    margin-bottom:15px;
    padding-bottom:10px;
    border-bottom:2px solid #0a5275;
}

.header h1 { margin:0; font-size:28px; font-weight:700; color:#0a5275; }
.header h3 { margin:5px 0 0; font-size:16px; font-weight:600; color:#444; }

.info-table, .summary-table {
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}
.info-table td {
    padding:6px 10px;
    font-weight:600;
}

.summary-title {
    font-size:17px;
    font-weight:700;
    color:#0a5275;
    margin-top:10px;
    margin-bottom:6px;
}

.summary-table td, .summary-table th {
    border:1px solid #777;
    padding:10px;
    font-size:14px;
}
.summary-table th {
    background:#0a5275;
    color:white;
    width:25%;
}

.status-pass {
    color:#28a745; font-weight:800; font-size:15px;
}
.status-fail {
    color:#dc3545; font-weight:800; font-size:15px;
}

.section-title {
    font-size:17px; font-weight:700; margin-top:15px; color:#0a5275;
}

.result-table {
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}
.result-table th, .result-table td {
    border:1px solid #999;
    padding:8px;
    font-size:13px;
}
.result-table th {
    background:#0a5275;
    color:white;
    font-weight:600;
    text-align:center;
}
.result-table td {
    vertical-align:top;
}
.correct { color:#28a745; font-weight:700; text-align:center; }
.wrong { color:#dc3545; font-weight:700; text-align:center; }

.footer {
    margin-top:15px;
    text-align:center;
    font-size:11px;
    opacity:0.6;
}
</style>
</head>

<body>

<div class="header">
    <h1>QUIZ RESULT REPORT</h1>
    <h3><?= strtoupper($quiz['description']); ?></h3>
</div>

<h3 class="summary-title">Score Summary</h3>

<table class="summary-table">
<tr>
    <th>Total Marks</th>
    <td><?= $attempt['total_marks'] ?></td>
</tr>
<tr>
    <th>Obtained Marks</th>
    <td><?= $attempt['obtained_marks'] ?> / <?= $attempt['total_marks'] ?></td>
</tr>
<tr>
    <th>Percentage</th>
    <td><?= round($attempt['percentage'],2) ?>%</td>
</tr>
<tr>
    <th>Status</th>
    <td>
        <?php if($attempt['status']=="PASS"): ?>
        <span class="status-pass">PASS</span>
        <?php else: ?>
        <span class="status-fail">FAIL</span>
        <?php endif; ?>
    </td>
</tr>
</table>

<h3 class="section-title">Question-Based Performance</h3>

<table class="result-table">
<thead>
<tr>
    <th width="5%">#</th>
    <th width="60%">Question</th>
    <th width="10%">Correct</th>
    <th width="10%">Your Ans</th>
    <th width="10%">Marks</th>
</tr>
</thead>
<tbody>
<?php $i=1; foreach($questions as $q): ?>
<tr>
    <td style="text-align:center;"><?= $i++ ?></td>
    <td><?= strip_tags($q['question_text']); ?></td>
    <td class="correct"><?= $q['correct_option']; ?></td>
    <td class="<?= ($q['selected_option']==$q['correct_option'])?'correct':'wrong'; ?>">
        <?= $q['selected_option']; ?>
    </td>
    <td class="<?= ($q['marks_obtained']>0)?'correct':'wrong'; ?>">
        <?= $q['marks_obtained']; ?>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<div class="footer">
    Generated on <?= date("d M, Y h:i A") ?> | Powered by Sandip University | © All Rights Reserved
</div>
<script>
    // Disable back button navigation
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script>
</body>
</html>
