<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<style>
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { border: 1px solid #ccc; padding: 8px; vertical-align: top; }
        th { background: #f2f2f2; }
        td p { margin: 0; }
    </style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
    </ul>

    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Assignment Question
            </h1>
            <span id="err_msg" style="color:red;"></span>
			
			<div class="pull-right col-xs-4 col-sm-auto">
			<?php //print_r($_SESSION);exit; if($this->session->userdata('role_id')==6 || $this->session->userdata('role_id')==15 || $this->session->userdata('role_id')==10 || $this->session->userdata('role_id')==20 || $this->session->userdata('role_id')==44 || $this->session->userdata('role_id')==68){?>
				<a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url('assignment_question_bank/add/'.$subject_id.'/'.$campus_id)?>"><span class="btn-label icon fa fa-plus"></span>Add</a>
			<?php //}?>
			</div>

			<span id="flash-messages" style="color:Green;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
			</span>
			<span id="flash-messages" style="color:red;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
			</span>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">
    <span class="label-text">Subject Code:</span> <span class="value-text"><?= $subject['subject_code']; ?></span>
    <span class="label-text">Subject Name:</span> <span class="value-text"><?= $subject['subject_name']; ?> (<?= $subject['subject_component'] ?>)</span>
    <span class="label-text">Semester:</span> <span class="value-text"><?= $subject['semester']; ?></span>
</span>
                    </div>

                    <div id="show_list" class="panel-body" >
                        <div class="table-info">    
                      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    table.table-bordered th, 
    table.table-bordered td {
        vertical-align: top;
        padding: 6px;
    }

    /* Topic column: darker grey */
    .topic-col {
        width: 15%;
        background:#e0e0e0;  /* ✅ darker grey */
        font-weight:bold;
        color:#000;
    }

    /* Subtopic column: light green */
    .subtopic-col {
        width: 15%;
        background:#dff6e0;  /* ✅ light green */
        font-weight:600;
        color:#000;
    }

    .qno-col {
        width: 6%;
        text-align: center;
        font-weight: bold;
    }

    .question-col {
        width: 30%;
        word-wrap: break-word;
        white-space: normal;
    }

    .actions-col {
        width: 8%;
        white-space: nowrap;
        text-align: center;
    }

    .actions-col a {
        display: inline-block;
        margin: 0 3px;
        font-size: 16px;
        color: #fff;
        padding: 6px 8px;
        border-radius: 4px;
    }
    .btn-edit { background-color: #f0ad4e; }
    .btn-delete { background-color: #d9534f; }
    .btn-edit:hover { background-color: #ec971f; }
    .btn-delete:hover { background-color: #c9302c; }

    .grand-total td {
        background: #dcdcdc;
        font-weight: bold;
        text-align: center;
        border-top: 3px solid #000;
    }
</style>

<table class="table table-bordered">
     <thead>
        <tr>
            <th style="width:4%;">Sr.No</th>
            <th class="topic-col">Topic</th>
            <th class="subtopic-col">Subtopic</th>
            <th class="qno-col">Q. No</th>
            <th class="question-col">Question</th>
            <th style="width:5%;">Marks</th>
            <th style="width:5%;">CO</th>
            <th style="width:8%;">Blooms Level</th>
            <th style="width:8%;">Source Exam</th>
            <th style="width:5%;">File</th>
            <th style="width:10%;">Created At</th>
            <th class="actions-col">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($questions)) {
        // 🔹 Group questions by Topic → Subtopic
        $topicGrouped = [];
        foreach ($questions as $q) {
            $topicKey = $q->topic_order . '. ' . $q->topic_title;
            $subtopicKey = $q->srno . '. ' . $q->subtopic_title;
            $topicGrouped[$topicKey][$subtopicKey][] = $q;
        }

        $i = 1; 
        $grandTotal = 0;

        foreach ($topicGrouped as $topic => $subtopics):
            // Count total rows for rowspan
            $topicRowspan = 0;
            foreach ($subtopics as $rows) {
                $topicRowspan += count($rows);
            }
            $firstTopic = true;

            foreach ($subtopics as $subtopic => $rows):
                $subtopicRowspan = count($rows);
                $firstSubtopic = true;

                $qNo = 1; 
                foreach ($rows as $q): 
                    $grandTotal++; ?>
                    <tr>
                        <td><?= $i++ ?></td>

                        <!-- Topic only once -->
                        <?php if ($firstTopic): ?>
                            <td rowspan="<?= $topicRowspan ?>" class="topic-col" style="vertical-align:top;">
                                <?= $topic ?>
                            </td>
                        <?php endif; ?>

                        <!-- Subtopic only once -->
                        <?php if ($firstSubtopic): ?>
                            <td rowspan="<?= $subtopicRowspan ?>" class="subtopic-col" style="vertical-align:top;">
                                <?= $subtopic ?>
                            </td>
                        <?php endif; ?>

                        <td class="qno-col"><?= $qNo++ ?></td>
                        <td class="question-col"><?= html_entity_decode($q->question_text) ?></td>
                        <td><?= $q->marks ?></td>
                        <td><?= $q->course_outcome ?></td>
                        <td><?= $q->blooms_level ?></td>
                        <td><?= $q->source_exam ?></td>
                        <td>
                            <?php if ($q->question_file): ?>
                                <a href="<?= base_url('uploads/assignment_questions/' . $q->question_file) ?>" target="_blank">Download</a>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d-m-Y H:i', strtotime($q->created_at)) ?></td>
                        <td class="actions-col">
                            <a href="<?= base_url('assignment_question_bank/edit/' . $q->id) ?>" class="btn-edit" title="Edit">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a href="<?= base_url('assignment_question_bank/delete/' . $q->id.'/'.$q->subject_id.'/'.$q->campus_id) ?>" 
                               class="btn-delete" onclick="return confirm('Delete this question?')" title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php 
                $firstTopic = false;
                $firstSubtopic = false;
                endforeach;
            endforeach;
        endforeach; ?>

        <!-- ✅ Grand total row -->
        <tr class="grand-total">
            <td colspan="12">Total Questions in All Topics: <?= $grandTotal ?></td>
        </tr>

    <?php } else {
        echo '<tr><td colspan="12">No records found.</td></tr>';
    } ?>
    </tbody>
</table>













                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
