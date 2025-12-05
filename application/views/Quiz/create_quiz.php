<!DOCTYPE html>
<html>
<head>
    <title>Create Quiz & Add Questions</title>

    <!-- Bootstrap 3 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/q5qizpro8tuffbxgbred7gh5ezvha0nx2bra8wec4a9hmmwp/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>

<style>
body { background:#f2f7fd; font-family:'Poppins', sans-serif; }
.page-header-title{
    font-size:22px;font-weight:600;color:#167ea5;
    margin-bottom:15px;padding-bottom:10px;border-bottom:3px solid #167ea5;
}
.card-ui{
    background:#fff;padding:25px;border-radius:12px;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
}
label{font-weight:600;}
.panel{border-radius:10px;border:1px solid #dfe8f3;margin-bottom:20px;}
</style>
</head>

<body>

<div class="container" style="max-width:1100px;margin-top:30px;">
    <div class="card-ui">

        <div class="page-header-title">
            <i class="fa fa-book"></i> Create Quiz & Add Questions
        </div>

        <?php if($this->session->flashdata('msg')): ?>
            <div class="alert alert-success"><?=$this->session->flashdata('msg');?></div>
        <?php endif; ?>

        <!-- MAIN FORM -->
        <form method="post" enctype="multipart/form-data" action="<?=site_url('Quizmaster/save_multiple_questions')?>" id="quizMainForm">

            <div class="row">
                <div class="col-md-6">
                    <label>Subject</label>
                    <select name="subject_id" id="subject_id" class="form-control" required>
                        <option value="">Select Subject</option>
                        <?php foreach($subjects as $s): ?>
                            <option value="<?=$s['sub_id']?>"><?=$s['subject_name']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Unit</label>
                    <select name="unit_id" id="unit_id" class="form-control" required>
                        <option value="">Select Unit</option>
                    </select>
                </div>
            </div><br>

            <div class="form-group">
                <label>Quiz Description</label>
                <textarea name="description" class="form-control"
                          placeholder="Describe quiz (optional)"></textarea>
            </div>

            <hr>
			<div class="row">
			<div class="col-md-6">
			<label>Quiz Duration (Minutes)</label>
			<input type="number" name="quiz_time" class="form-control" placeholder="30" required>
			</div>

			<div class="col-md-6">
			<label>Negative Marking (Mark deduction per wrong answer)</label>
			<input type="number" name="negative_marks" step="0.01" class="form-control" placeholder="0 or 0.25" required>
			</div>
			</div>

			<br>
            <!-- Questions container -->
            <div id="questionContainer">

                <div class="questionBlock panel panel-default" style="padding:15px;">
                    <h4 style="margin-top:0;color:#167ea5;font-weight:600;">
                        Question <span class="qNo">1</span>
                    </h4>

                    <textarea name="question_text[]" class="question-editor"></textarea><br>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Option A</label>
                            <input type="text" name="option_a[]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Option B</label>
                            <input type="text" name="option_b[]" class="form-control" required>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Option C</label>
                            <input type="text" name="option_c[]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Option D</label>
                            <input type="text" name="option_d[]" class="form-control" required>
                        </div>
                    </div><br>

                    <label>Correct Answer</label><br>
                    <label class="radio-inline"><input type="radio" name="correct_option[0]" value="A"> A</label>
                    <label class="radio-inline"><input type="radio" name="correct_option[0]" value="B"> B</label>
                    <label class="radio-inline"><input type="radio" name="correct_option[0]" value="C"> C</label>
                    <label class="radio-inline"><input type="radio" name="correct_option[0]" value="D"> D</label>
                    <br><br>

                    <label>Marks</label>
                    <input type="number" name="marks[]" class="form-control" value="1" required><br>

                    <button type="button" class="btn btn-danger removeQuestion" style="display:none;">
                        <i class="fa fa-trash"></i> Remove
                    </button>
                </div>
            </div>

            <button type="button" id="addMoreQ" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add More Questions
            </button>

            <br><br>

            <!-- Excel Upload Section -->
            <h4 style="color:#167ea5;font-weight:bold;">OR Upload Excel</h4>

            <label>Choose Excel File (.xlsx only)</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xlsx"><br>

            <a href="<?=base_url('assets/SAMPLE QUIZ QUESTION UPLOAD FORMAT.xlsx')?>"
               target="_blank" class="btn btn-info">
                <i class="fa fa-download"></i> Download Sample Format
            </a>

            <br><br>

            <button type="submit" id="saveBtn" class="btn btn-success">
                <i class="fa fa-save"></i> Save Quiz & Questions
            </button>

        </form>

    </div>
</div>


<script>
$(function() {

    $("#subject_id").change(function(){
        $.ajax({
            url: "<?=site_url('Quizmaster/get_units')?>",
            type: "POST",
            data: {subject_id: $(this).val()},
            dataType: "json",
            success: function(res){
                $("#unit_id").html('<option value="">Select Unit</option>');
                $.each(res, function(i, v){
                    $("#unit_id").append('<option value="'+v.topic_id+'">'+v.topic_title+'</option>');
                });
            }
        });
    });

    var $template = $(".questionBlock:first").clone();
    $template.find("textarea").val("");
    $template.find("input[type=text]").val("");
    $template.find("input[type=number]").val(1);
    $template.find("input[type=radio]").prop("checked", false);
    $template.find('.removeQuestion').hide();

    function initTiny(){
        tinymce.remove('.question-editor');
        tinymce.init({
            selector: '.question-editor',
            height: 240,
            plugins: 'lists table link code',
            toolbar: 'undo redo | bold italic underline | bullist numlist | alignleft aligncenter alignright | table | code | link',
            branding: false
        });
    }
    initTiny();

    let index = 0;
    $("#addMoreQ").click(function(){
        index++;
        let newQ = $template.clone();
        newQ.find('.qNo').text(index + 1);
        newQ.find('input[type=radio]').attr("name","correct_option["+index+"]");
        newQ.find('.removeQuestion').show();
        $("#questionContainer").append(newQ);
        initTiny();
    });

    $(document).on("click",".removeQuestion",function(){
        $(this).closest(".questionBlock").remove();
    });

    $("#saveBtn").click(function(e){
        e.preventDefault();
        if($("#excel_file").val()){
            $("#quizMainForm").attr("action","<?=site_url('Quizmaster/import_excel')?>");
        } else {
            $("#quizMainForm").attr("action","<?=site_url('Quizmaster/save_multiple_questions')?>");
        }
        tinymce.triggerSave();
        $("#quizMainForm").submit();
    });

});
</script>

</body>
</html>
