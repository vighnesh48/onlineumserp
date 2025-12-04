<link rel="stylesheet" href="<?=base_url('assets/bootstrap.min.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/font-awesome.min.css')?>"><!-- if you have FA -->
<style>
  /* layout + theme-friendly enhancements */
  #content-wrapper{padding:15px}
  .page-wrap{max-width:1200px;margin:0 auto}
  .panel{border-radius:14px; overflow:hidden}
  .panel .table thead th{position:sticky; top:0; background:#f8f9fa; z-index:1}
  .status-badge{font-size:.75rem}
  .row-submitted{background:#f6fff6}
  .row-pending{background:#fffaf2}
  .q-text{white-space:pre-wrap}
  .file-link{max-width:220px; display:inline-block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap}
  .toolbar{gap:.5rem}
  .form-control-sm{min-width:90px}
  .muted{opacity:.8}
  .divider{height:1px; background:rgba(0,0,0,.06)}
  .badge-blm{background:#e9ecef;color:#495057}
  .toast-ct{position:fixed; right:1rem; bottom:1rem; z-index:1080}
  .badge {
   
    padding: 0px 6px 3px 6px!important;

}
</style>

<?php
function safe($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
$maxMarks = (int)($assignment->max_marks ?? 0);
?>

<div id="content-wrapper">
  <!-- Breadcrumb -->
  <ul class="breadcrumb breadcrumb-page">
    <div class="breadcrumb-label text-light-gray">You are here:</div>
    <li><a href="#">Lecture</a></li>
    <li class="active"><a href="#">Attendance</a></li>
  </ul>

  <!-- Page Header -->
  <div class="page-header">
    <div class="row">
      <h1 class="col-xs-12 col-sm-8 text-center text-left-sm">
        <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Mark Attendance*
      </h1>
      <div class="col-xs-12 col-sm-4 text-right">
        <!-- room for header actions if needed -->
      </div>
    </div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div>
  </div>

  <!-- Subject/Division bar -->
  <div class="panel">
    <div class="panel-heading">
      <span class="panel-title" id="stdname">
        Faculty Allocated Subject List :
        <?php
          $batch_to = $batch != 0 ? $batch : "";
          if(!empty($subdetails)){
            echo $subdetails[0]['subject_short_name'].'('.$subdetails[0]['subject_code'].')-'.$division.$batch_to;
          }
        ?>
      </span>
    </div>
    <div class="panel-body">

      <div class="page-wrap1">
        <!-- Top toolbar -->
        <div class="d-flex align-items-center justify-content-between mb-15" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:15px;">
          <div>
            <a class="btn btn-sm btn-default" href="<?=base_url('assignment/my')?>/<?=encrypt_id($assignment->subject_id)?>/1">← Back</a>
          </div>
          <div class="toolbar" style="display:flex">
            <!--button id="save-all" class="btn btn-primary btn-sm">Save All</button-->
            <button id="refresh" class="btn btn-default btn-sm">Refresh</button>
          </div>
        </div>

        <!-- Assignment Summary (panel style) -->
        <div class="panel">
          <div class="panel-heading">
            <span class="panel-title">Assignment Summary</span>
          </div>
          <div class="panel-body">
            <div class="row" style="display:flex;align-items:flex-start;justify-content:space-between;">
              <div class="col-sm-6">
                <h3 class="m-t-0"><?=safe($assignment->title)?></h3>
                <div class="text-muted small">Created: <?=safe($assignment->created_at)?></div>
              </div>
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-xs-6 col-sm-3">
                    <div class="muted small">Subject ID</div>
                    <div class="fw-semibold"><?=safe($assignment->subject_code.'-'.$assignment->subject_name)?></div>
                  </div>
                  <!--div class="col-xs-6 col-sm-3">
                    <div class="muted small">Campus ID</div>
                    <div class="fw-semibold"><?=safe($assignment->campus_id)?></div>
                  </div-->
                  <div class="col-xs-6 col-sm-3">
                    <div class="muted small">Due Date</div>
                    <div class="fw-semibold"><?=safe($assignment->due_date)?></div>
                  </div>
                  <div class="col-xs-6 col-sm-3">
                    <div class="muted small">Max Marks</div>
                    <div class="fw-semibold"><?=safe($assignment->max_marks)?></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="divider m-t-15 m-b-15"></div>
            <div class="row">
              <div class="col-sm-6">
                <div class="small text-muted m-b-5">Topic</div>
                <div class="fw-semibold"><?= $context->topic_label ? safe($context->topic_label) : '-' ?></div>
              </div>
              <div class="col-sm-6">
                <div class="small text-muted m-b-5">Subtopic</div>
                <div class="fw-semibold"><?= $context->subtopic_label ? safe($context->subtopic_label) : '-' ?></div>
              </div>
            </div>
<br>
            <?php if(!empty($assignment->description)): ?>
              <div class="alert alert-info m-t-15 m-b-0">
                <div class="fw-semibold m-b-5">Description</div>
                <div><?=nl2br(safe($assignment->description))?></div>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Questions -->
        <div class="panel">
          <div class="panel-heading">
            <span class="panel-title">Questions</span>
            <span class="pull-right text-muted small">
              Total: <?=count($questions)?><?php if($maxMarks):?> • Max: <?=$maxMarks?><?php endif;?>
            </span>
          </div>
          <div class="panel-body p-0">
            <div class="table-responsive">
              <table class="table table-striped  table-bordered table-sm m-b-0" width="100%">
                <thead>
                  <tr>
                    <th style="width:48px">#</th>
                    <th>Text</th>
                    <th style="width:120px">CO</th>
                    <th style="width:120px">Bloom</th>
                    <th style="width:90px" class="text-right">Marks</th>
                  </tr>
                </thead>
                <tbody>
                <?php $i=1; $sumQ=0; foreach($questions as $q): $sumQ += (int)$q->marks; ?>
                  <tr>
                    <td class="text-muted"><?=$i++?></td>
                    <td class="q-text"><?=strip_tags(html_entity_decode($q->question_text, ENT_QUOTES, 'UTF-8'))?></td>
                    <td><span class="badge"><?=safe($q->course_outcome)?></span></td>
                    <td><span class="badge badge-blm"><?=safe($q->blooms_level)?></span></td>
                    <td class="text-right"><?=safe($q->marks)?></td>
                  </tr>
                <?php endforeach; if(empty($questions)): ?>
                  <tr><td colspan="5" class="text-center text-muted" style="padding:20px">No questions mapped.</td></tr>
                <?php endif; ?>
                </tbody>
                <?php if(!empty($questions)): ?>
                <tfoot>
                  <tr>
                    <th colspan="4" class="text-right">Total</th>
                    <th class="text-right"><?=$sumQ?></th>
                  </tr>
                </tfoot>
                <?php endif; ?>
              </table>
            </div>
          </div>
        </div>

        <!-- Students -->
        <div class="panel">
          <div class="panel-heading">
            <span class="panel-title">Assigned Students</span>
            <div class="pull-right" style="display:flex; gap:8px">
              <input type="text" id="searchBox" class="form-control input-sm" placeholder="Search name / PRN / roll">
              <select id="statusFilter" class="form-control input-sm">
                <option value="">All statuses</option>
                <option value="Submitted">Submitted</option>
                <option value="Pending">Pending</option>
                <option value="Evaluated">Evaluated</option>
              </select>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="panel-body p-0" style="padding:0">
            <div class="table-responsive">
              <table id="studentsTable" class="table table-striped table-hover table-bordered table-sm m-b-0">
                <thead>
                  <tr>
                    <th style="width:48px">#</th>
                    <th>Roll</th>
                    <th>PRN</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Uploaded File</th>
                    <th style="width:120px">Marks</th>
                    <th style="width:240px">Feedback</th>
                    <th style="width:90px">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; foreach($students as $s):
                    $status = (string)$s->status;
                    $isSubmitted = !empty($s->submitted_at) || strtolower($status)==='submitted' || strtolower($status)==='evaluated';
                    $rowClass = $isSubmitted ? 'row-submitted' : 'row-pending';
                  ?>
                    <tr class="<?=$rowClass?>" data-status="<?=safe($status)?>">
                      <td><?=$i++?></td>
                      <td><?=safe($s->roll_no)?></td>
                      <td><?=safe($s->enrollment_no)?></td>
                      <td><?=safe(trim(($s->first_name ?? '').' '.($s->last_name ?? '')))?></td>
                      <td>
                        <?php if(strtolower($status)==='submitted'): ?>
                          <span class="label label-success status-badge">Submitted</span>
                        <?php elseif(strtolower($status)==='evaluated'): ?>
                          <span class="label label-primary status-badge">Evaluated</span>
                        <?php else: ?>
                          <span class="label label-warning status-badge">Pending</span>
                        <?php endif; ?>
                      </td>
                      <td class="small"><?=safe($s->submitted_at ?? '')?></td>
                      <td>
                        <?php if(!empty($s->answer_file)): 
								$b_name = "uploads/student_assignments/";
								$dwnld_url = base_url()."Upload/download_s3file/".$s->answer_file.'?b_name='.$b_name;
						
						?>
						 <a class="file-link" href="<?=$dwnld_url?>" target="_blank"><?= safe($s->answer_file) ?></a>
                          
                        <?php else: ?>
                          <span class="text-muted">—</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <input type="number"
                               class="form-control input-sm mark"
                               data-stud="<?=$s->student_id?>"
                               min="0" <?=$maxMarks ? 'max="'.$maxMarks.'"' : ''?>
                               placeholder="0"
                               value="<?=safe($s->marks_obtained)?>">
                      </td>
                      <td>
                        <input type="text"
                               class="form-control input-sm fb"
                               data-stud="<?=$s->student_id?>"
                               placeholder="Feedback"
                               value="<?=safe($s->feedback ?? '')?>">
                      </td>
                      <td>
                        <button class="btn btn-xs btn-primary do-eval"
                                data-assign="<?=$assignment->id?>"
                                data-stud="<?=$s->student_id?>">Save</button>
                      </td>
                    </tr>
                  <?php endforeach; if(empty($students)): ?>
                    <tr><td colspan="10" class="text-center text-muted" style="padding:20px">No students mapped.</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Toasts -->
        <div class="toast-ct"></div>
      </div><!-- /.page-wrap -->

    </div><!-- /.panel-body -->
  </div><!-- /.panel (subject/division) -->
</div><!-- /#content-wrapper -->

<script>
(function(){
  const baseEvalUrl = '<?=base_url('assignment/evaluate')?>';
  const toastCt = document.querySelector('.toast-ct');

  function showToast(msg, type='success'){
    const el = document.createElement('div');
    var klass = 'alert ';
    if(type==='success') klass+='alert-success';
    else if(type==='warn') klass+='alert-warning';
    else klass+='alert-danger';
    el.className = klass;
    el.style.marginBottom = '8px';
    el.innerHTML = '<button type="button" class="close" aria-label="Close"><span>&times;</span></button>'+msg;
    toastCt.appendChild(el);
    el.querySelector('.close').onclick = ()=> el.remove();
    setTimeout(()=> el.remove(), 3000);
  }

  async function saveOne(aid, sid){
    const markEl = document.querySelector('.mark[data-stud="'+sid+'"]');
    const fbEl   = document.querySelector('.fb[data-stud="'+sid+'"]');
    const mark   = (markEl?.value ?? '').trim();
    const fb     = (fbEl?.value ?? '').trim();

    <?php if($maxMarks): ?>
    if(mark !== '' && +mark > <?=$maxMarks?>){
      showToast('Marks cannot exceed <?=$maxMarks?>','error'); 
      markEl.focus();
      return 'ERR';
    }
    <?php endif; ?>

    const form = new FormData();
    form.append('assignment_id', aid);
    form.append('student_id', sid);
    form.append('marks_obtained', mark);
    form.append('feedback', fb);

    try{
      const r = await fetch(baseEvalUrl, {method:'POST', body:form});
      const t = await r.text();
      if(t.trim()==='OK'){
        showToast('Saved');
        return 'OK';
      } else {
        showToast('Error saving','error');
        return 'ERR';
      }
    } catch(e){
      showToast('Network error','error');
      return 'ERR';
    }
  }

  // Single-row save
  document.querySelectorAll('.do-eval').forEach(btn=>{
    btn.addEventListener('click', async function(){
      this.disabled = true;
      this.innerText = 'Saving…';
      const status = await saveOne(this.dataset.assign, this.dataset.stud);
      this.disabled = false;
      this.innerText = 'Save';
      if(status==='OK'){
        const tr = this.closest('tr');
        tr?.classList.remove('row-pending');
        tr?.classList.add('row-submitted');
      }
    });
  });

  // Save All
  document.getElementById('save-all')?.addEventListener('click', async function(){
    const buttons = [...document.querySelectorAll('.do-eval')];
    if(!buttons.length) return;
    this.disabled = true; this.innerText = 'Saving…';
    let ok=0, err=0;
    for(const b of buttons){
      const res = await saveOne(b.dataset.assign, b.dataset.stud);
      if(res==='OK'){ ok++; } else { err++; }
    }
    this.disabled = false; this.innerText = 'Save All';
    showToast('Saved '+ok+' / '+buttons.length+(err?(', '+err+' failed'):''),
              err? 'warn':'success');
  });

  // Refresh
  document.getElementById('refresh')?.addEventListener('click', ()=> location.reload());

  // Inline search + status filter
  const searchBox = document.getElementById('searchBox');
  const statusFilter = document.getElementById('statusFilter');
  const rows = [...document.querySelectorAll('#studentsTable tbody tr')];

  function applyFilters(){
    const q = (searchBox?.value || '').toLowerCase();
    const st = (statusFilter?.value || '').toLowerCase();
    rows.forEach(r=>{
      const txt = r.innerText.toLowerCase();
      const rs = (r.getAttribute('data-status')||'').toLowerCase();
      const matchQ = !q || txt.includes(q);
      const matchS = !st || rs===st;
      r.style.display = (matchQ && matchS) ? '' : 'none';
    });
  }
  searchBox?.addEventListener('input', applyFilters);
  statusFilter?.addEventListener('change', applyFilters);
})();
</script>
