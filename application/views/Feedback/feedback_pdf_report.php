<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-family: 'Arial'; }
h3, h4 { color: #003366; margin-bottom: 4px; }
table { border-collapse: collapse; width: 100%; margin-bottom: 10px; }
th, td { border: 1px solid #000; padding: 6px; font-size: 12px; }
th { background: #003366; color: #fff; text-align: center; }
.center { text-align: center; }
.summary { font-weight: bold; background: #f4f4f4; }
hr { border: 1px solid #ccc; margin: 20px 0; }
.chart { text-align: center; margin-top: 20px; }
</style>
</head>

<body>

<h3>Sandip Institute of Engineering and Management, Nashik</h3>
<h4>Faculty Feedback Report</h4>

<p>
<strong>Faculty:</strong> <?= $faculty['fname'].' '.$faculty['lname']; ?><br>
<strong>Subject:</strong> <?= $subject['subject_name']; ?><br>
<strong>Semester:</strong> <?= $subject['semester'] ?? 'I'; ?> &nbsp; | &nbsp;
<strong>Branch:</strong> <?= $subject['branch'] ?? ''; ?> &nbsp; | &nbsp;
<strong>Date:</strong> <?= date('d-M-Y'); ?>
</p>

<table>
<tr>
  <th>Sr.No</th>
  <th>Question</th>
  <th>Marks Obt</th>
  <th>Total</th>
  <th>Percent %</th>
</tr>
<?php $i=1; foreach($feedback as $row): ?>
<tr>
  <td class="center"><?= $i++; ?></td>
  <td><?= $row['question_name']; ?></td>
  <td class="center"><?= $row['marks_obt']; ?></td>
  <td class="center"><?= $row['total_marks']; ?></td>
  <td class="center"><?= $row['percent']; ?>%</td>
</tr>
<?php endforeach; ?>
<tr class="summary">
  <td colspan="2">Total Marks</td>
  <td class="center"><?= $total['obt']; ?></td>
  <td class="center"><?= $total['total']; ?></td>
  <td class="center"><?= $total['percent']; ?>%</td>
</tr>
</table>

<div class="chart">
  <h4>Graphical Representation of Marks Obtained</h4>
  <img src="<?= $chart_url ?>" width="100%" style="max-height:300px;">
</div>

</body>
</html>
