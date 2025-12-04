<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Assignment Question</a></li>
        <li class="active"><a href="#">Edit Assignment Question</a></li>
    </ul>

    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-6 text-center text-left-sm">
                <i class="fa fa-edit page-header-icon"></i>&nbsp;&nbsp;Edit Assignment Question
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading"><span class="panel-title">Edit Details</span></div>
                <div class="panel-body">
                    <?= form_open_multipart('assignment_question_bank/update/'.$question->id) ?>
                    
                    <input type="hidden" name="campus_id" value="<?= $question->campus_id ?>">
                    <input type="hidden" name="subject_id" value="<?= $question->subject_id ?>">

                    <div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Topic <span class="text-danger">*</span></label>
            <select name="topic_id" id="topic_id" class="form-control select2" required>
                <option value="">Select Topic</option>
                <?php foreach($topics as $t): ?>
                    <option value="<?= $t->topic_id ?>" <?= $t->topic_id == $question->topic_id ? 'selected' : '' ?>>
                        <?= $t->topic_order ?> - <?= $t->topic_title ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label>Subtopic</label>
            <select name="subtopic_id" id="subtopic_id" class="form-control select2">
                <option value="">Select Subtopic</option>
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label>Question Text</label>
    <textarea name="question_text" id="editor1"><?= $question->question_text ?></textarea>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label>Marks</label>
            <input type="number" name="marks" value="<?= $question->marks ?>" class="form-control" required>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <label>Course Outcome</label>
            <select name="course_outcome" class="form-control select2">
                <option value="">Select CO</option>
                <?php foreach(['CO1', 'CO2', 'CO3', 'CO4', 'CO5', 'CO6'] as $co): ?>
                    <option value="<?= $co ?>" <?= $question->course_outcome == $co ? 'selected' : '' ?>><?= $co ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <label>Bloom's Level</label>
            <select name="blooms_level" class="form-control select2">
                <?php foreach($blooms_levels as $bl): ?>
                    <option value="<?= $bl->code ?>" <?= $question->blooms_level == $bl->code ? 'selected' : '' ?>>
                        <?= $bl->code ?> - <?= $bl->description ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <label>Source Exam</label>
            <input type="text" name="source_exam" value="<?= $question->source_exam ?>" required class="form-control">
        </div>
    </div>
</div>

<div class="form-group">
    <label>Upload New File (Optional)</label>
    <input type="file" name="question_file" class="form-control">
    <?php if ($question->question_file): ?>
        <p class="text-info">Existing File: 
            <a href="<?= base_url('uploads/assignment_questions/'.$question->question_file) ?>" target="_blank">
                <?= $question->question_file ?>
            </a>
        </p>
    <?php endif; ?>
</div>

<div class="form-group text-right">
    <button type="submit" class="btn btn-primary">Update Question</button>
</div>


                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor1');

    function loadSubtopics(topic_id, selected = null) {
        if (topic_id) {
            $.ajax({
                url: "<?= site_url('lecture_plan/get_subtopics_ajax/') ?>/" + topic_id,
                type: "GET",
                success: function(response) {
                    const data = JSON.parse(response);
                    let options = '<option value="">Select Subtopic</option>';
                    data.forEach(function(item) {
                        const sel = selected == item.subtopic_id ? 'selected' : '';
                        options += `<option value="${item.subtopic_id}" ${sel}>${item.srno} ${item.subtopic_title}</option>`;
                    });
                    $('#subtopic_id').html(options);
                }
            });
        } else {
            $('#subtopic_id').html('<option value="">Select Subtopic</option>');
        }
    }

    $(document).ready(function() {
        const topicId = <?= $question->topic_id ?>;
        const subtopicId = <?= $question->subtopic_id ?: 'null' ?>;
        if (topicId) {
            loadSubtopics(topicId, subtopicId);
        }

        $('#topic_id').on('change', function() {
            loadSubtopics($(this).val());
        });
    });
</script>
