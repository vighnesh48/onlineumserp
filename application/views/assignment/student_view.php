<?php
// ===== helpers (Bootstrap 3 labels) =====
function statusLabel($status){
    $s = $status ?: 'Pending';
    $map = ['Pending'=>'default','Submitted'=>'info','Evaluated'=>'success'];
    $cls = isset($map[$s]) ? $map[$s] : 'default';
    return '<span class="label label-'.$cls.'">'.$s.'</span>';
}
function safe($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

$dueYmd   = !empty($assignment->due_date) ? date('Y-m-d', strtotime($assignment->due_date)) : null;
$todayYmd = date('Y-m-d');
$isOverdue = $dueYmd && $dueYmd < $todayYmd && ($assignment->status ?? 'Pending')!=='Submitted' && ($assignment->status ?? 'Pending')!=='Evaluated';

$backHash = '';
if (!empty($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], '#sub_') !== false) {
    $parts = explode('#', $_SERVER['HTTP_REFERER'], 2);
    $backHash = '#'.($parts[1] ?? '');
}
?>

<style>
/* ===================== MODERN AURORA THEME — BOOTSTRAP 3 (scoped) ===================== */
/* Change colors here to quickly rebrand */
#content-wrapper{
  --bg:        #ffffff;
  --bg-soft:   #f7f9fc;
  --bg-soft-2: #eef2f7;
  --text:      #0f172a;
  --muted:     #6b7280;
  --stroke:    #e5e9f2;
  --shadow:    0 12px 30px rgba(15,23,42,.08);

  --primary:   #6c5ce7;  /* indigo */
  --primary-2: #7b8cff;
  --info:      #06b6d4;  /* cyan */
  --success:   #22c55e;  /* green */
  --warning:   #f59e0b;  /* amber */
  --danger:    #ef4444;  /* red */

  --grad-1:    linear-gradient(135deg, #6c5ce7 0%, #06b6d4 100%);
  --grad-2:    linear-gradient(135deg, #7b8cff 0%, #6c5ce7 45%, #ff7eb3 100%);
  --grad-soft: linear-gradient(180deg, rgba(108,92,231,.10), rgba(6,182,212,.08));
}

/* ---------- Breadcrumb polish ---------- */
#content-wrapper .breadcrumb{
  background: var(--bg-soft);
  border:1px solid var(--stroke);
  border-radius: 12px;
  padding:8px 12px;
}
#content-wrapper .breadcrumb > li + li:before{ color:#c0c6d6; }

/* ---------- Panels (cards feel) ---------- */
#content-wrapper .panel{
  border-color: var(--stroke);
  border-radius: 16px;
  box-shadow: var(--shadow);
  overflow: hidden;
  background: var(--bg);
}
#content-wrapper .panel-heading{
  background: var(--grad-soft);
  border-bottom: 1px solid var(--stroke);
  font-weight: 800;
  color: var(--text);
  letter-spacing: .2px;
}
#content-wrapper .panel-title{ font-weight: 800; }

/* ---------- Head pills / badges (top-right summary) ---------- */
#content-wrapper .hdr-pill{
  display:inline-block; font-size:12px; font-weight:700; color:#1e2a78;
  background:#eef2ff; border:1px solid #dbe2ff; padding:4px 9px; border-radius:999px;
}
#content-wrapper .text-muted{ color: var(--muted); }

/* ---------- Labels (lozenge style, still BS3 .label) ---------- */
#content-wrapper .label{ border-radius: 10px; padding: 4px 8px; font-weight: 700; border:0; }
#content-wrapper .label-default{ background:#ecf0ff; color:#3948b5; }
#content-wrapper .label-info{    background:#def7ff; color:#0369a1; }
#content-wrapper .label-success{ background:#e8fbef; color:#047857; }
#content-wrapper .label-warning{ background:#fff4e5; color:#b45309; }
#content-wrapper .label-danger{  background:#ffe7ea; color:#b91c1c; }

/* ---------- Buttons ---------- */
#content-wrapper .btn{ border-radius: 10px; font-weight: 700; transition: .18s ease; }
#content-wrapper .btn-default{
  background:#fff; border:1px solid var(--stroke); color:#0f172a;
}
#content-wrapper .btn-default:hover{
  background:#f8faff; border-color:#cfd7ee; color:#0b63c5;
  box-shadow:0 10px 24px rgba(11,99,197,.18); transform: translateY(-1px);
}
#content-wrapper .btn-primary{
  border:0; color:#fff; background: var(--grad-1);
  box-shadow:0 10px 22px rgba(108,92,231,.25);
}
#content-wrapper .btn-primary:hover{ filter:brightness(1.05); transform: translateY(-1px); }
#content-wrapper .btn-success{
  border:0; color:#fff; background: linear-gradient(135deg, #22c55e, #16a34a)!important;
  box-shadow:0 10px 22px rgba(34,197,94,.25)!important;
}

/* ---------- Overdue hint ---------- */
#content-wrapper .overdue-hint{
  background: rgba(239,68,68,.06);
  border:1px solid #ffc7cd;
  border-radius: 12px;
  padding:8px 10px;
  box-shadow: 0 8px 18px rgba(239,68,68,.12);
}

/* ---------- Forms ---------- */
#content-wrapper .form-control{
  border-radius: 12px;
  border:1px solid var(--stroke);
  box-shadow: none;
}
#content-wrapper .form-control:focus{
  border-color:#cfd7ee;
  box-shadow: 0 0 0 3px rgba(108,92,231,.15);
}
#content-wrapper .help-block{ color: var(--muted); }

/* ---------- Question accordion (BS3 collapse) ---------- */
#content-wrapper .q-acc .panel{
  border-radius:12px; overflow:hidden; box-shadow:0 8px 18px rgba(15,23,42,.06);
}
#content-wrapper .q-acc .panel-heading{ background:#fafcff; }
#content-wrapper .q-acc .panel-title a{
  display:block; color:#0f172a; position:relative; padding-right:24px;
}
#content-wrapper .q-acc .panel-title a .q-num{
  display:inline-block; min-width:22px; text-align:center; margin: 5px;
  background:#eef2ff; border:1px solid #dbe2ff; color:#1e2a78;
  border-radius:999px; padding:2px 6px; font-size:12px;
}
#content-wrapper .q-acc .panel-title a:after{
  content:"\f107"; font-family:FontAwesome; position:absolute; right:4px; top:50%;
  transform: translateY(-50%) rotate(0deg); transition: .15s ease;
  color:#6b7280; font-size:14px;
}
#content-wrapper .q-acc .panel-title a[aria-expanded="true"]:after{
  transform: translateY(-50%) rotate(180deg);
}

/* ---------- Chips & file row ---------- */
#content-wrapper .chip{
  display:inline-block; margin-top:6px; margin-right:6px; padding:4px 9px; font-size:12px; line-height:1.2;
  border-radius:999px; color:#0f172a;
  background: linear-gradient(#fff,#fff) padding-box, linear-gradient(120deg, #dfe6ff, #e6f6ff) border-box;
  border:1px solid transparent;
}
#content-wrapper .chip.marks:before{ content:"\f005"; font-family:FontAwesome; margin-right:6px; color:#22c55e; }
#content-wrapper .chip.due:before{   content:"\f017"; font-family:FontAwesome; margin-right:6px; color:#0b63c5; }
#content-wrapper .file-row{ font-size:.95rem; }

/* ---------- Tables (if any inside panels) ---------- */
#content-wrapper .table{
  background:#fff; border:1px solid var(--stroke);
  border-radius:14px; overflow:hidden;
}
#content-wrapper .table>thead>tr>th{
  background: var(--bg-soft);
  color:#334155; font-weight:800; border-bottom:1px solid var(--stroke);
}
#content-wrapper .table>tbody>tr:hover>td{ background:#fcfdff; }

/* ---------- Utility spacing ---------- */
#content-wrapper .mb-0{ margin-bottom:0!important; }
#content-wrapper .mb-5{ margin-bottom:5px!important; }
#content-wrapper .mb-10{ margin-bottom:10px!important; }
#content-wrapper .mb-15{ margin-bottom:15px!important; }
#content-wrapper .mt-5{ margin-top:5px!important; }
#content-wrapper .mt-10{ margin-top:10px!important; }

</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Assignments</a></li>
    </ul>
    <div class="page-header">			
        <div class="panel-body">

<div class="row">
  <div class="col-sm-12">
    <!-- Top bar -->
    <div class="clearfix mb-10">
      <div class="pull-left">
        <a href="<?= base_url('Student_assignments/').$backHash ?>" class="btn btn-outline btn-xs"><i class="fa fa-arrow-left"></i> Back to subjects</a>
      </div>
      <div class="pull-right">
        <span class="hdr-pill">Subject: <?= safe($assignment->subject_name) ?></span>
        <?php if(isset($assignment->total_marks)): ?>
          <span class="hdr-pill">Max: <?= (int)$assignment->total_marks ?></span>
        <?php endif; ?>
        <span class="hdr-pill"><?= statusLabel($assignment->status ?? 'Pending') ?></span>
        <?php if($isOverdue): ?>
          <span class="label label-danger" style="margin-left:6px;">Overdue</span>
        <?php endif; ?>
      </div>
    </div>

    <!-- Title + Due -->
    <div class="mb-10">
      <h3 class="mb-5" style="margin-top:0; font-weight:800;"><?= safe($assignment->title) ?></h3>
      <div class="<?= $isOverdue ? 'overdue-hint' : '' ?>">
        <strong>Due Date:</strong>
        <?= !empty($assignment->due_date) ? date('d-m-Y', strtotime($assignment->due_date)) : '-' ?>
        <?php if(!empty($assignment->instruction_file)): ?>
          <span style="margin-left:10px;">
            <a class="btn btn-outline btn-xs"
               href="<?= base_url('uploads/assignment_instructions/'.rawurlencode($assignment->instruction_file)) ?>"
               target="_blank"><i class="fa fa-download"></i> Download Instructions</a>
          </span>
        <?php endif; ?>
      </div>
    </div>

    <!-- Main columns -->
    <div class="row">
      <!-- Left: Questions & Submission Summary -->
      <div class="col-sm-8">
        <!-- Questions (accordion via BS3 collapse) -->
        <div class="panel panel-default mb-15">
          <div class="panel-heading"><strong>Questions</strong> <span class="text-muted"> (<?= count($questions) ?>)</span></div>
          <div class="panel-body">
            <?php if(empty($questions)): ?>
              <div class="alert alert-info mb-0">No questions attached to this assignment.</div>
            <?php else: ?>
              <div class="panel-group q-acc" id="qAccordion" role="tablist" aria-multiselectable="true">
                <?php $i=1; foreach($questions as $idx=>$q):
                  $collapseId = 'qCollapse'.$idx;
                  $headingId  = 'qHeading'.$idx;
                  $in = ($idx===0) ? 'in' : '';
                ?>
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="<?= $headingId ?>">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#qAccordion" href="#<?= $collapseId ?>" aria-expanded="<?= $in?'true':'false' ?>" aria-controls="<?= $collapseId ?>">
                        <span class="q-num"><?= $i++ ?></span><span style="font-weight: 400;"><?= strip_tags(html_entity_decode($q->question_text, ENT_QUOTES, 'UTF-8')) ?></span>
                      </a>
                    </h4>
                  </div>
                  <div id="<?= $collapseId ?>" class="panel-collapse collapse <?= $in ?>" role="tabpanel" aria-labelledby="<?= $headingId ?>">
                    <div class="panel-body">
					 <?php if(!empty($q->question_file)): ?>
                        <div class="file-row mt-10">
							<img src="https://erp.sandipuniversity.com/uploads/assignment_questions/<?=rawurlencode($q->question_file) ?>" 
						 alt="Attachment" 
						 style="max-width:300px; height:auto; border:1px solid #ccc; margin-top:10px;">
                        </div>
                      <?php endif; ?>
                      <?php if(!empty($q->marks)): ?>
                        <span class="chip marks">Marks: <?= (int)$q->marks ?></span>
                      <?php endif; ?>
                      <?php if(!empty($q->question_file)): ?>
                        <div class="file-row mt-10">
                          <span class="label label-info" style="margin-right:6px;">Attachment</span>
                          <a href="<?= base_url('uploads/assignment_questions/'.rawurlencode($q->question_file)) ?>" target="_blank"><?= safe($q->question_file) ?></a>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Submission summary -->
        <?php if(($assignment->status ?? '') !== ''): ?>
        <a id="submission"></a><a id="evaluation"></a>
        <div class="panel panel-default">
          <div class="panel-heading">
            <strong>Your Submission</strong>
            <?php if(($assignment->status ?? 'Pending')==='Submitted'): ?>
              <span class="label label-info" style="margin-left:6px;">Submitted</span>
            <?php elseif(($assignment->status ?? '')==='Evaluated'): ?>
              <span class="label label-success" style="margin-left:6px;">Evaluated</span>
            <?php endif; ?>
          </div>
          <div class="panel-body">
            <?php if(!empty($assignment->submitted_at)): ?>
              <p class="mb-5"><strong>Submitted On:</strong> <?= date('d-m-Y H:i', strtotime($assignment->submitted_at)) ?></p>
            <?php endif; ?>

            <?php if(($assignment->status ?? '')==='Evaluated'): ?>
              <p class="mb-5">
                <strong>Marks:</strong>
                <?= is_null($assignment->marks_obtained) ? '-' : (int)$assignment->marks_obtained ?>
                <?php if(isset($assignment->total_marks)): ?>/ <?= (int)$assignment->total_marks ?><?php endif; ?>
              </p>
              <p class="mb-0"><strong>Feedback:</strong> <?= !empty($assignment->feedback) ? nl2br(safe($assignment->feedback)) : '—' ?></p>
            <?php endif; ?>

            <?php if(!empty($assignment->answer_text)): ?>
              <hr>
              <p class="mb-5" style="font-weight:700">Answer Text</p>
              <pre class="mb-10"><?= safe($assignment->answer_text) ?></pre>
            <?php endif; ?>

            <?php if(!empty($assignment->answer_file)): 
					$b_name = "uploads/student_assignments/";
					$dwnld_url = base_url()."Upload/download_s3file/".$assignment->answer_file.'?b_name='.$b_name;
			?>
              <p class="mb-0">
                <span class="label label-primary" style="margin-right:6px;">Uploaded File</span>
                <a href="<?=$dwnld_url?>" target="_blank"><?= safe($assignment->answer_file) ?></a>
              </p>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <!-- Right: Submit / Update -->
      <div class="col-sm-4">
        <a id="submit"></a>
        <div class="panel panel-default">
          <div class="panel-heading clearfix">
            <strong>Submit / Update</strong>
            <?php if(($assignment->status ?? 'Pending')==='Evaluated'): ?>
              <span class="label label-default pull-right">Locked</span>
            <?php endif; ?>
          </div>
         <div class="panel-body">
  <?php if (!empty($assignment->is_closed) && $assignment->is_closed == 1): ?>
      <div class="alert alert-danger mb-0">
        <i class="fa fa-lock"></i> This assignment has been <strong>closed</strong> by your faculty. Submissions are no longer allowed.
      </div>

  <?php elseif(($assignment->status ?? 'Pending')==='Evaluated'): ?>
      <div class="alert alert-warning mb-0">
        This assignment is already <strong>evaluated</strong>. Further submissions are disabled.
      </div>

  <?php else: ?>
      <form method="post" action="<?= base_url('Student_assignments/student_submit') ?>" enctype="multipart/form-data" id="submitForm">
        <input type="hidden" name="assignment_id" value="<?= (int)$assignment->id ?>">

        <div class="form-group">
          <label>Answer Text <span class="text-muted">(optional)</span></label>
          <textarea name="answer_text" class="form-control" rows="6" maxlength="5000"
                    placeholder="Type your answer here..."><?= safe($assignment->answer_text ?? '') ?></textarea>
          <p class="help-block"><span id="charCount">0</span>/5000</p>
        </div>

        <div class="form-group">
          <label>Upload File <span class="text-muted">(pdf, doc, docx, zip, png, jpg; max 5MB)</span></label>
          <input type="file" name="answer_file" id="answer_file" class="form-control" accept=".pdf,.doc,.docx,.zip,.png,.jpg,.jpeg">
          <?php if(!empty($assignment->answer_file)): ?>
            <p class="help-block">Current: <?= safe($assignment->answer_file) ?></p>
          <?php endif; ?>
        </div>

        <?php if($isOverdue): ?>
          <div class="alert alert-danger">
            Due date has passed. Submission may be counted as late, if allowed by policy.
          </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-success btn-block">Submit</button>
      </form>
  <?php endif; ?>
</div>

        </div>
      </div>
    </div><!-- /.row -->
  </div>
</div>

<script>
// jQuery required (CI3/BS3 usual). Char count + file size check.
(function($){
  var $ta = $('textarea[name="answer_text"]');
  var $cc = $('#charCount');
  if($ta.length && $cc.length){
    var update = function(){ $cc.text(($ta.val()||'').length); };
    $ta.on('input', update); update();
  }
  var $file = $('#answer_file');
  if($file.length){
    $file.on('change', function(){
      var f = this.files && this.files[0];
      if(!f) return;
      var max = 5 * 1024 * 1024;
      if(f.size > max){
        alert('File exceeds 5 MB limit.');
        this.value = '';
      }
    });
  }
})(jQuery);
</script>
