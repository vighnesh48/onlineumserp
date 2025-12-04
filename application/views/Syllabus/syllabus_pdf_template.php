<!DOCTYPE html>
<html>
<head>
    <title>Syllabus PDF</title>
    <style>
        body {
        font-family: sans-serif;
        font-size: 11px;
        margin: 10px 15px 15px 15px; /* 10px top, 15px sides and bottom */
    }

       .header-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
        font-family: sans-serif;
    }

    .header-table td {
        vertical-align: middle;
        font-size: 12px;
    }

    .header-title {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
    }

    .header-date {
        text-align: right;
        font-size: 12px;
    }

    .header-logo {
        text-align: left;
        width: 25%;
    }

    .header-logo img {
        height: 30px;
    }
    .subject-details {
        margin-top: 5px;
        text-align: center;
        font-size: 12px;
        font-weight: bold;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
    }

    th, td {
        border: 1px solid #000;
        padding: 5px;
        text-align: center;
        font-size: 11px;
    }

    .topic-row {
        background-color: #d9edf7;
        font-weight: bold;
    }
    </style>
</head>
<body>

<table class="header-table">
    <tr>
        <td class="header-logo">
            <!-- Optional logo -->
			<?php if($campus_id==1){?>
           <img src="https://www.sandipuniversity.edu.in/images/logo-dark.png" alt="Sandip university" class="desktop-logo lg-logo ptrans">
			<?php }elseif($campus_id==2){?>
           <img src="https://www.sandipuniversity.edu.in/images/logo-dark.png" alt="Sandip university" class="desktop-logo lg-logo ptrans">
			<?php }elseif($campus_id==3){?>
           <img src="https://sitrc.sandipfoundation.org/wp-content/uploads/2023/09/SIPS.png" alt="Sandip university" class="desktop-logo lg-logo ptrans">
		   <?php }?>
        </td>
        <td class="header-title">
            Syllabus Report
        </td>
        <td class="header-date">
            Date: <?= date('d-m-Y') ?>
        </td>
    </tr>
</table>
<div class="subject-details">
		<span>Course Code: <?= $subject['subject_code'] ?></span>
        <span>Course Name: <?= $subject['subject_name'] ?>(<?= $subject['subject_component'] ?>)</span>
        
    </div>
    <table>
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Topic</th>
                <th>Order No.</th>
                <th>Course Outcome</th>
                <th>Hours</th>
                <th>Minutes</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = 1;
            foreach($topics as $topic): ?>
                <tr class="main-topic">
                    <td><?= $topic['topic_order'] ?></td>
                    <td><?= $topic['topic_title'] ?></td>
                    <td><?= $topic['topic_order'] ?></td>
                    <td><?= $topic['tcos'] ?></td>
					<td><?= $topic['thours'] ?></td>
					<td><?= $topic['tminutes'] ?></td>
                </tr>
                <?php if (!empty($topic['subtopics'])): 
                    $subcount = 1;
                    foreach($topic['subtopics'] as $sub): ?>
                        <tr>
                            <td><?= $sub['srno'] ?></td>
                            <td><?= $sub['subtopic_title'] ?></td>
                            <td><?= $sub['subtopic_order'] ?></td>
                            <td><?= $sub['cos'] ?></td>
                            <td><?= $sub['shours'] ?></td>
                            <td><?= $sub['sminutes'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
