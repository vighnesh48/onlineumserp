<?php
// ===== helpers (Bootstrap 3 labels) =====
function statusBadge($status){
    $s = $status ?: 'Pending';
    $map = ['Pending'=>'default','Submitted'=>'info','Evaluated'=>'success'];
    $cls = isset($map[$s]) ? $map[$s] : 'default';
    return '<span class="label label-'.$cls.'">'.$s.'</span>';
}
function safe($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
$todayYmd = date('Y-m-d');

// flatten $grouped: key "sid|sname" => list
$flat = [];
if (!empty($grouped)) {
  foreach($grouped as $key=>$list){
    $parts = explode('|',$key,2);
    $sid   = $parts[0]; $sname = isset($parts[1]) ? $parts[1] : '';
    foreach($list as $row){
      $row->__subject_id   = $sid;
      $row->__subject_name = $sname;
      $flat[] = $row;
    }
  }
}
function statusKey($s){
  $s = strtolower(trim((string)$s));
  if($s==='submitted') return 'Submitted';
  if($s==='evaluated') return 'Evaluated';
  return 'Pending';
}
function dueYmd($d){ return $d ? date('Y-m-d', strtotime($d)) : null; }
function daysLeft($dueYmd,$todayYmd){
  if(!$dueYmd) return null;
  $d1 = new DateTime($todayYmd); $d2 = new DateTime($dueYmd);
  return (int)$d1->diff($d2)->format('%r%a'); // negative if overdue
}
?>

<style>
/* ===================== MODERN AURORA THEME (Bootstrap 3 markup) ===================== */
/* Scoped to this page only */
#content-wrapper{
  /* Palette */
  --bg:           #ffffff;
  --bg-soft:      #f7f9fc;
  --bg-soft-2:    #eef2f7;
  --text:         #111827;
  --muted:        #6b7280;
  --stroke:       #e5e9f2;
  --shadow:       0 10px 26px rgba(15, 23, 42, .08);

  --primary:      #6c5ce7;  /* indigo */
  --primary-2:    #7b8cff;
  --info:         #06b6d4;  /* cyan */
  --success:      #22c55e;  /* green */
  --warning:      #f59e0b;  /* amber */
  --danger:       #ef4444;  /* red */
  --hot:          #ff7eb3;  /* pink accent */

  --grad-1:       linear-gradient(135deg, #6c5ce7 0%, #06b6d4 100%);
  --grad-2:       linear-gradient(135deg, #7b8cff 0%, #6c5ce7 40%, #ff7eb3 100%);
  --grad-soft:    linear-gradient(180deg, rgba(124,58,237,.08), rgba(6,182,212,.06));
}

/* Optional Dark Mode (opt-in): add class "theme-dark" to #content-wrapper */
#content-wrapper.theme-dark{
  --bg:         #0f172a;
  --bg-soft:    #111827;
  --bg-soft-2:  #0b1220;
  --text:       #e5e7eb;
  --muted:      #9ca3af;
  --stroke:     #1f2937;
  --shadow:     0 10px 26px rgba(0,0,0,.45);
}

/* --------- Base containers --------- */
#content-wrapper { color: var(--text); }
#content-wrapper .panel { border-color: var(--stroke); border-radius:14px; box-shadow: var(--shadow); }
#content-wrapper .panel-heading {
  border-bottom-color: var(--stroke);
  background: var(--grad-soft);
  font-weight: 700; color: var(--text);
}

/* --------- Toolbar --------- */
#content-wrapper .assign-toolbar{
  margin: 0 0 16px; padding: 12px 14px;
  background: rgba(255,255,255,.6);
  border: 1px solid var(--stroke);
  border-radius: 14px;
  box-shadow: var(--shadow);
  backdrop-filter: blur(6px);
}
#content-wrapper .assign-toolbar h4{ margin:0; font-weight:800; letter-spacing:.2px; }
#content-wrapper .assign-toolbar .btn-group .btn{
  border-radius: 999px; border:1px solid var(--stroke);
  background: #fff; color: #1f2937;
  transition: .2s ease; padding:6px 12px;
}
#content-wrapper.theme-dark .assign-toolbar .btn-group .btn{ background:#0b1220; color: var(--text); }
#content-wrapper .assign-toolbar .btn-group .btn:hover{
  transform: translateY(-1px);
  box-shadow: 0 8px 22px rgba(108,92,231,.22);
  border-color: transparent;
}
#content-wrapper .assign-toolbar .btn-group .btn.active{
  color:#fff; border-color: transparent;
  background: var(--grad-1);
  box-shadow: 0 10px 26px rgba(6,182,212,.30);
}

/* --------- Subject Tabs (pills + glow underline) --------- */
#content-wrapper .subject-tab{
  border:1px solid var(--stroke); border-radius:14px; padding:8px 8px 0; background: var(--bg);
}
#content-wrapper .subject-tab>li>a{
  border:0; border-radius: 10px 10px 0 0; padding:10px 14px; color:#475569; font-weight:700;
}
#content-wrapper.theme-dark .subject-tab>li>a{ color:#cbd5e1; }
#content-wrapper .subject-tab>li>a:hover{ background: var(--bg-soft); }
#content-wrapper .subject-tab>li.active>a,
#content-wrapper .subject-tab>li.active>a:focus,
#content-wrapper .subject-tab>li.active>a:hover{
  background: var(--bg); color: var(--text);
}
#content-wrapper .subject-tab>li.active>a:after{
  content:""; position:absolute; left:14px; right:14px; bottom:0; height:3px; border-radius:3px;
  background: var(--grad-2);
}

/* Counts */
#content-wrapper .subject-tab .count-pill{
  margin-left:8px; font-size:11px; font-weight:700;
  padding:3px 8px; border-radius:999px; color:#334155;
  background: #eef2ff; border:1px solid #d9e1ff;
}
#content-wrapper.theme-dark .subject-tab .count-pill{ background:#1f2937; border-color:#334155; color:#e5e7eb; }

/* --------- Tables (Tabs & Timeline) --------- */
#content-wrapper .tab-pane .table{
  border:1px solid var(--stroke); border-radius:14px; overflow:hidden; background: var(--bg);
}
#content-wrapper .tab-pane .table>thead>tr>th{
  background: var(--bg-soft); color:#334155; font-weight:800;
  border-bottom:1px solid var(--stroke);
  position: sticky; top:0; z-index:1;
}
#content-wrapper.theme-dark .tab-pane .table>thead>tr>th{ color:#e5e7eb; }
#content-wrapper .tab-pane .table>tbody>tr:hover>td{ background: #fdfcff; }
#content-wrapper.theme-dark .tab-pane .table>tbody>tr:hover>td{ background:#0b1220; }
#content-wrapper .tab-pane .table>tbody>tr.overdue>td{
  background: rgba(239,68,68,.06) !important; border-left: 4px solid var(--danger);
}

/* Labels -> modern lozenges */
#content-wrapper .label{ border-radius:10px; padding:4px 8px; font-weight:700; border:0; }
#content-wrapper .label-default{ background:#ecf0ff; color:#3948b5; }
#content-wrapper .label-info{    background:#def7ff; color:#0369a1; }
#content-wrapper .label-success{ background:#e8fbeF; color:#047857; }
#content-wrapper .label-warning{ background:#fff4e5; color:#b45309; }
#content-wrapper .label-danger{  background:#ffe7ea; color:#b91c1c; }

/* --------- Board (Kanban-like) --------- */
#content-wrapper .board-col{
  border-radius:14px; overflow:hidden; border:1px solid var(--stroke); background: var(--bg);
  box-shadow: var(--shadow);
}
#content-wrapper .board-col .panel-heading{
  background: var(--grad-soft);
  font-weight:800; letter-spacing:.2px;
}
#content-wrapper .board-col .panel-body{ background: var(--bg); }

/* Assignment card */
#content-wrapper .assign-card{
  position:relative; border:1px solid var(--stroke);
  border-radius:14px; background: rgba(255,255,255,.75);
  padding:12px; margin-bottom:12px; backdrop-filter: blur(4px);
  transition: transform .12s ease, box-shadow .18s ease;
}
#content-wrapper.theme-dark .assign-card{ background: rgba(15,23,42,.6); }
#content-wrapper .assign-card:hover{
  transform: translateY(-2px);
  box-shadow: 0 14px 30px rgba(108,92,231,.22);
}
#content-wrapper .assign-card .title{ font-weight:800; color: var(--text); }
#content-wrapper .assign-card .subject{ color: var(--muted); font-size:12px; margin-top:2px; }

/* Chips with gradient border */
#content-wrapper .assign-card .chip{
  display:inline-block; margin-top:8px; margin-right:6px;
  padding:4px 9px; font-size:12px; line-height:1.2; color:#0f172a;
  background:
    linear-gradient(var(--bg), var(--bg)) padding-box,
    linear-gradient(120deg, #dfe6ff, #e6f6ff) border-box;
  border:1px solid transparent; border-radius:999px;
}
#content-wrapper.theme-dark .assign-card .chip{
  color:#e5e7eb;
  background:
    linear-gradient(var(--bg), var(--bg)) padding-box,
    linear-gradient(120deg, #334155, #0ea5e9) border-box;
}
#content-wrapper .assign-card .chip.due:before{
  content:"\f017"; font-family:FontAwesome; margin-right:6px; color:#0b63c5;
}
#content-wrapper .assign-card .chip.marks:before{
  content:"\f005"; font-family:FontAwesome; margin-right:6px; color:#22c55e;
}

/* Overdue ribbon */
#content-wrapper .assign-card .ribbon{
  position:absolute; top:-8px; right:-8px; color:#fff; font-size:11px;
  padding:2px 8px; border-radius:8px; background: var(--danger); box-shadow:0 8px 20px rgba(239,68,68,.35);
}
#content-wrapper .assign-card .ribbon:after{
  content:""; position:absolute; top:100%; right:8px; border:6px solid transparent; border-top-color:#b91c1c;
}

/* --------- Timeline --------- */
#content-wrapper .tl .panel{ border-radius:14px; overflow:hidden; box-shadow: var(--shadow); }
#content-wrapper .tl .table{ border:0; }
#content-wrapper .tl .table>thead>tr>th{
  background: var(--bg-soft); border-bottom:1px solid var(--stroke); font-weight:800;
}
#content-wrapper .tl .table>tbody>tr:hover>td{ background:#fcfdff; }

/* --------- Buttons polish --------- */
#content-wrapper .btn{ border-radius:10px; }
#content-wrapper .btn-default{
  background:#fff; border:1px solid var(--stroke); color:#0f172a!important;
  transition: .18s ease;
}
#content-wrapper .btn-default:hover{
  background:#f8faff; border-color:#cdd6ee; color:#0b63c5!important;
  box-shadow:0 10px 24px rgba(11,99,197,.18);
}
#content-wrapper .btn-primary{
  border:0; color:#fff; background:#26a9d1;
  box-shadow:0 10px 22px rgba(108,92,231,.25);
}
#content-wrapper .btn-primary:hover{ filter:brightness(1.05); transform: translateY(1px); }
#content-wrapper .btn-info{
  color:#fff; border:0; background: linear-gradient(135deg, #06b6d4, #0ea5e9)!important;
}
#content-wrapper .btn-success{
  color:#fff; border:0; background: linear-gradient(135deg, #22c55e, #16a34a)!important;
}

/* --------- Micro polish --------- */
#content-wrapper .table td, #content-wrapper .table th{ vertical-align:middle !important; }
#content-wrapper .text-muted{ color: var(--muted); }
#content-wrapper .label{ letter-spacing:.15px; }

/* Print */
@media print{
  #content-wrapper .assign-toolbar, #content-wrapper .btn, #content-wrapper .nav { display:none !important; }
  #content-wrapper .panel{ box-shadow:none !important; }
}

</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Assignments</a></li>
    </ul>
    <div class="page-header">			
        <div class="panel-body">
<div class="assign-toolbar clearfix">
  <div class="pull-right">
    <div class="btn-group btn-group-sm" role="group" aria-label="View">
      <button type="button" class="btn btn-default active" data-view="tabs">
        <i class="fa fa-list"></i> Tabs
      </button>
      <button type="button" class="btn btn-default" data-view="board">
        <i class="fa fa-columns"></i> Board
      </button>
      <button type="button" class="btn btn-default" data-view="timeline">
        <i class="fa fa-clock-o"></i> Timeline
      </button>
    </div>
  </div>
  <h4 style="margin-top:6px;margin-bottom:0;"><i class="fa fa-book"></i> My Assignments</h4>
</div>

<!-- =================== TABS VIEW =================== -->
<div id="view-tabs">
  <?php if(empty($grouped)): ?>
    <div class="alert alert-info">No assignments found.</div>
  <?php else: ?>
    <ul class="nav nav-tabs subject-tab" role="tablist" style="margin-bottom: 10px;">
      <?php $first=true; foreach($grouped as $key=>$list):
        $parts = explode('|',$key,2);
        $sid   = $parts[0]; $sname = isset($parts[1]) ? $parts[1] : '';
        $tabId = 'sub_'.$sid; ?>
        <li role="presentation" class="<?= $first?'active':'' ?>">
          <a href="#<?=$tabId?>" aria-controls="<?=$tabId?>" role="tab" data-toggle="tab">
            <?= safe($sname) ?>
            <span class="count-pill"><?= (int)($subjectCounts[$key] ?? count($list)) ?></span>
          </a>
        </li>
      <?php $first=false; endforeach; ?>
    </ul>

    <div class="tab-content">
      <?php $first=true; foreach($grouped as $key=>$list):
        $parts = explode('|',$key,2);
        $sid   = $parts[0]; $sname = isset($parts[1]) ? $parts[1] : '';
        $tabId = 'sub_'.$sid; ?>
        <div role="tabpanel" class="tab-pane <?= $first?'active':'' ?>" id="<?=$tabId?>">
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width:60px">#</th>
                  <th>Title</th>
                  <th style="width:140px">Created Date</th>
                  <th style="width:140px">Due Date</th>
                  <th style="width:120px">Status</th>
                  <th style="width:120px">Max Marks</th>
                  <th style="width:160px">Obt Marks</th>
                  <th style="width:120px">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php if(empty($list)): ?>
                <tr><td colspan="6" class="text-center">No assignments.</td></tr>
              <?php else: $i=1; foreach($list as $row):
                $due = dueYmd($row->due_date ?? null);
                $isOverdue = $due && $due < $todayYmd && ($row->status ?? 'Pending')!=='Submitted' && ($row->status ?? 'Pending')!=='Evaluated';
              ?>
                <tr class="<?= $isOverdue?'overdue':'' ?>">
                  <td><?= $i++ ?></td>
                  <td>
                    <strong><?= safe($row->title) ?></strong>
                    <?php if($isOverdue): ?> <span class="label label-danger">Overdue</span> <?php endif; ?>
                    <div class="text-muted" style="font-size:12px;"><?= safe($row->__subject_name ?? '') ?></div>
                  </td>
                  <td><?= $row->created_at ? date('d-m-Y', strtotime($row->created_at)) : '-' ?></td>
                  <td><?= $row->due_date ? date('d-m-Y', strtotime($row->due_date)) : '-' ?></td>
                  <td><?= statusBadge($row->status ?? 'Pending') ?></td>
                  <td><?= ($row->max_marks ?? '-') ?></td>
                  <td>
                    <?php
                      if(($row->status ?? 'Pending')==='Evaluated'){
                        echo (is_null($row->marks_obtained)?'-':(int)$row->marks_obtained)
                             . (isset($row->total_marks)?' / '.(int)$row->total_marks:'');
                      } else { echo '-'; }
                    ?>
                  </td>
                  <td>
                    <?php if (!empty($row->is_closed) && $row->is_closed == 1): ?>
						<button class="btn btn-xs btn-default ">
							<i class="fa fa-lock"></i> Closed
							<a class="btn btn-xs btn-primary" href="<?= base_url('Student_assignments/student_view/'.encrypt_id($row->assignment_id)) ?>">View</a>
						</button>
					<?php else: ?>
						<a class="btn btn-xs btn-primary" href="<?= base_url('Student_assignments/student_view/'.encrypt_id($row->assignment_id)) ?>">View</a>
					<?php endif; ?>

                  </td>
                </tr>
              <?php endforeach; endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php $first=false; endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<!-- =================== BOARD VIEW =================== -->
<div id="view-board" style="display:none">
  <?php
    $cols   = ['Pending'=>'warning','Submitted'=>'info','Evaluated'=>'success'];
    $counts = ['Pending'=>0,'Submitted'=>0,'Evaluated'=>0];
    foreach($flat as $a){ $counts[statusKey($a->status ?? 'Pending')]++; }
  ?>
  <div class="row board-wrap">
    <?php foreach($cols as $col=>$bs): ?>
      <div class="col-sm-4">
        <div class="panel panel-default board-col">
          <div class="panel-heading">
            <span class="label label-<?= $bs ?>" style="display:inline-block; width:10px; height:10px; margin-right:6px;"></span>
            <?= $col ?>
            <span class="text-muted pull-right">(<?= (int)$counts[$col] ?>)</span>
          </div>
          <div class="panel-body" id="col-<?= strtolower($col) ?>" style="max-height:62vh; overflow:auto;">
            <?php foreach($flat as $a):
              $st = statusKey($a->status ?? 'Pending'); if($st!==$col) continue;
              $due = dueYmd($a->due_date ?? null);
              $dl  = daysLeft($due,$todayYmd);
              $isOver = $due && $due < $todayYmd && $st!=='Submitted' && $st!=='Evaluated';
            ?>
            <div class="assign-card" data-title="<?= safe(strtolower($a->title ?? '')) ?>">
              <?php if($isOver): ?><span class="ribbon">Overdue</span><?php endif; ?>
              <div class="title"><?= safe($a->title) ?></div>
              <div class="subject"><?= safe($a->__subject_name ?? '—') ?></div>
              <div>
                <?php if($due): ?>
                  <span class="chip due">
                    Due: <?= date('d-m-Y', strtotime($a->due_date)) ?>
                    <span class="text-muted">
                      (<?= $dl===0 ? 'today' : ($dl>0 ? $dl.' day'.($dl>1?'s':'').' left' : abs($dl).' day'.(abs($dl)>1?'s':'').' late') ?>)
                    </span>
                  </span>
                <?php endif; ?>
                <?php if(isset($a->total_marks)): ?>
                  <span class="chip marks">Max: <?= (int)$a->total_marks ?></span>
                <?php endif; ?>
              </div>
              <div style="margin-top:8px;">
                <a href="<?= base_url('Student_assignments/student_view/'.encrypt_id($a->assignment_id)) ?>" class="btn btn-xs btn-default">Open</a>
                <?php if($st==='Pending'): ?>
                  <a href="<?= base_url('Student_assignments/student_view/'.encrypt_id($a->assignment_id)).'#submit' ?>" class="btn btn-xs btn-primary">Submit</a>
                <?php elseif($st==='Submitted'): ?>
                  <a href="<?= base_url('Student_assignments/student_view/'.encrypt_id($a->assignment_id)).'#submission' ?>" class="btn btn-xs btn-success">View Submission</a>
                <?php else: ?>
                  <a href="<?= base_url('Student_assignments/student_view/'.encrypt_id($a->assignment_id)).'#evaluation' ?>" class="btn btn-xs btn-info">View Result</a>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- =================== TIMELINE VIEW =================== -->
<div id="view-timeline" style="display:none">
  <?php
    $buckets = ['Overdue'=>[], 'This Week'=>[], 'Next Week'=>[], 'Later'=>[], 'No Due Date'=>[]];
    foreach($flat as $a){
      $due = dueYmd($a->due_date ?? null);
      if(!$due){ $buckets['No Due Date'][] = $a; continue; }
      $dl = daysLeft($due,$todayYmd);
      if($dl<0) $buckets['Overdue'][] = $a;
      elseif($dl<=6) $buckets['This Week'][] = $a;
      elseif($dl<=13) $buckets['Next Week'][] = $a;
      else $buckets['Later'][] = $a;
    }
    $order = ['Overdue','This Week','Next Week','Later','No Due Date'];
    $labels= ['Overdue'=>'danger','This Week'=>'warning','Next Week'=>'info','Later'=>'default','No Due Date'=>'default'];
  ?>
  <div class="row tl">
    <?php foreach($order as $bk): $lst=$buckets[$bk]; ?>
      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="label label-<?= $labels[$bk] ?>"></span>
            <?= $bk ?>
            <span class="text-muted pull-right">(<?= count($lst) ?>)</span>
          </div>
          <div class="panel-body">
            <?php if(empty($lst)): ?>
              <div class="text-muted">No items.</div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-condensed">
                  <thead>
                    <tr><th>Title</th><th>Subject</th><th>Due</th><th>Status</th><th class="text-right">Action</th></tr>
                  </thead>
                  <tbody>
                  <?php foreach($lst as $a):
                    $due = dueYmd($a->due_date ?? null);
                    $dl  = daysLeft($due,$todayYmd);
                  ?>
                    <tr>
                      <td><strong><?= safe($a->title) ?></strong></td>
                      <td><?= safe($a->__subject_name ?? '—') ?></td>
                      <td>
                        <?= $due ? date('d-m-Y', strtotime($a->due_date)) : '—' ?>
                        <?php if(is_int($dl)): ?>
                          <span class="text-muted" style="font-size:11px;">
                            (<?= $dl===0?'today':($dl>0?$dl.'d left':abs($dl).'d late') ?>)
                          </span>
                        <?php endif; ?>
                      </td>
                      <td><?= statusBadge($a->status ?? 'Pending') ?></td>
                      <td class="text-right">
                        <a href="<?= base_url('Student_assignments/student_view/'.encrypt_id($a->assignment_id)) ?>" class="btn btn-xs btn-default">Open</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- ===== Scripts (use your project's includes; shown here for clarity) =====
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
-->

<script>
// View toggle (Bootstrap 3)
(function(){
  var $btns = $('[data-view]');
  var $views = {
    tabs:    $('#view-tabs'),
    board:   $('#view-board'),
    timeline:$('#view-timeline')
  };
  function setView(mode){
    $.each($views, function(k,$v){ $v.toggle(k===mode); });
    $btns.removeClass('active').filter('[data-view="'+mode+'"]').addClass('active');
    // persist in URL ?view=
    var url = new URL(window.location);
    url.searchParams.set('view', mode);
    history.replaceState(null,'',url);
    // if switching to tabs, activate the first tab if none active
    if(mode==='tabs' && $('.nav-tabs li.active').length===0){
      $('.nav-tabs a:first').tab('show');
    }
  }
  var initial = (new URL(window.location)).searchParams.get('view') || 'tabs';
  setView($views[initial] ? initial : 'tabs');
  $btns.on('click', function(){ setView($(this).data('view')); });
})();

// Persist active subject tab via hash (Bootstrap 3)
(function(){
  if(location.hash && location.hash.indexOf('#sub_')===0){
    var $t = $('.nav-tabs a[href="'+location.hash+'"]');
    if($t.length){ $t.tab('show'); }
  }
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
    var sel = $(e.target).attr('href'); // #sub_xxx
    var url = new URL(window.location);
    if(url.searchParams.get('view')!=='tabs') url.searchParams.set('view','tabs');
    history.replaceState(null, '', url.toString().split('#')[0] + sel);
  });
})();
</script>
