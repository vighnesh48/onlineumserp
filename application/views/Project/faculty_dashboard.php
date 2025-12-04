<?php

$DAYS = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
function normDay($v){
  $map = array(
    'mon'=>'Monday','monday'=>'Monday',
    'tue'=>'Tuesday','tues'=>'Tuesday','tuesday'=>'Tuesday',
    'wed'=>'Wednesday','wednesday'=>'Wednesday',
    'thu'=>'Thursday','thur'=>'Thursday','thurs'=>'Thursday','thursday'=>'Thursday',
    'fri'=>'Friday','friday'=>'Friday',
    'sat'=>'Saturday','saturday'=>'Saturday',
    'sun'=>'Sunday','sunday'=>'Sunday',
  );
  $k = strtolower(trim($v ? $v : ''));
  return isset($map[$k]) ? $map[$k] : ucfirst($k);
}
function colorFor($pid){
  $palette = array('#7CB9E8','#79D3BE','#F7A5C0','#FFCF8F','#9CC0FF','#C9B7FF','#FFD98A','#95F1E4','#EDB6FF','#B9CCFF');
  $idx = 0; if(is_numeric($pid)) $idx = intval($pid) % count($palette);
  return $palette[$idx];
}
function hmToMinutes($t){
  $t = trim((string)$t); if($t==='') return null;
  $p = explode(':',$t); if(count($p)<2) return null;
  return intval($p[0])*60 + intval($p[1]);
}
function minToLabel($m){ $h=floor($m/60); $min=$m%60; return sprintf('%02d:%02d',$h,$min); }

/* ---------- Detect column names ---------- */
$slotIdField = null; $fromField = 'from_time'; $toField = 'to_time';
if (!empty($slots)) {
  $keys = array_keys((array)$slots[0]);
  foreach (array('proj_slot_id','lect_slot_id','lecture_slot_id','slot_id','id') as $c) {
    if (in_array($c, $keys, true)) { $slotIdField=$c; break; }
  }
  if (!in_array('from_time',$keys,true)) $fromField = in_array('start_time',$keys,true)?'start_time':$fromField;
  if (!in_array('to_time',$keys,true))   $toField   = in_array('end_time',$keys,true)?'end_time'  :$toField;
}
$rowSlotField=null; $rowFromField=null; $rowToField=null;
if (!empty($rows)) {
  $rk = array_keys((array)$rows[0]);
  foreach (array('proj_slot_id','lecture_slot_id','lect_slot_id','slot_id','id') as $c) { if (in_array($c,$rk,true)) { $rowSlotField=$c; break; } }
  foreach (array('from_time','start_time') as $c) { if (in_array($c,$rk,true)) { $rowFromField=$c; break; } }
  foreach (array('to_time','end_time')     as $c) { if (in_array($c,$rk,true)) { $rowToField  =$c; break; } }
}

/* ---------- Normalize events ---------- */
$events = array();
$slotLut = array();
if (!empty($slots) && $slotIdField){
  foreach ($slots as $s) {
    $sid = isset($s[$slotIdField]) ? (int)$s[$slotIdField] : 0;
    if ($sid>0) $slotLut[$sid] = array('from'=> (isset($s[$fromField])?$s[$fromField]:''), 'to'=> (isset($s[$toField])?$s[$toField]:''));
  }
}
if (!empty($rows)) {
  foreach ($rows as $r) {
    $day = normDay(isset($r['wday']) ? $r['wday'] : '');
    if (!$day) continue; $dayIdx = array_search($day,$DAYS); if($dayIdx===false) continue;

    $tf = ($rowFromField && isset($r[$rowFromField])) ? $r[$rowFromField] : '';
    $tt = ($rowToField   && isset($r[$rowToField]))   ? $r[$rowToField]   : '';
    if ((!$tf || !$tt) && $rowSlotField && isset($r[$rowSlotField])) {
      $sid = (int)$r[$rowSlotField];
      if ($sid && isset($slotLut[$sid])) { if(!$tf) $tf=$slotLut[$sid]['from']; if(!$tt) $tt=$slotLut[$sid]['to']; }
    }
    if (!$tf || !$tt) continue;

    $pid   = isset($r['project_id']) ? (int)$r['project_id'] : 0;
    $title = isset($r['project_title']) ? $r['project_title'] : 'Untitled';
    $dom   = isset($r['domain']) ? $r['domain'] : '';
    $bld   = isset($r['building_name']) ? $r['building_name'] : '';
    $room  = isset($r['room_no']) ? $r['room_no'] : '';

    $events[] = array(
      'dayIdx' => $dayIdx,
      'start'  => $tf,
      'end'    => $tt,
      'title'  => $title,
      'domain' => $dom,
      'where'  => trim($bld.' '.$room),
      'pid'    => $pid,
      'color'  => colorFor($pid)
    );
  }
}

/* ---------- Hour range + 2-hour bands ---------- */
$minMin = 9999; $maxMin = -1;
foreach ($events as $e) { $s=hmToMinutes($e['start']); $t=hmToMinutes($e['end']); if($s!==null && $s<$minMin) $minMin=$s; if($t!==null && $t>$maxMin) $maxMin=$t; }
if ($minMin==9999) $minMin = 9*60;
if ($maxMin<0)     $maxMin = 18*60;
$startHour = floor($minMin/60);
$endHour   = ceil($maxMin/60);
if ($startHour%2!==0) $startHour--;
if ($endHour%2!==0)   $endHour++;

$bands = array(); // [startMin,endMin,label]
for ($h = $startHour; $h < $endHour; $h += 2) {
  $s = $h*60; $e = ($h+2)*60;
  $bands[] = array($s,$e, minToLabel($s).' – '.minToLabel($e));
}

$academic_years_safe = isset($academic_years)?$academic_years:array();
$faculties_safe      = isset($faculties)?$faculties:array();
$sel_year_val        = isset($sel_year)?$sel_year:'';
$sel_faculty_val     = isset($sel_faculty)?$sel_faculty:'';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>Faculty Dashboard</title>
<style>
  :root{ --bg:#f6f7fb; --panel:#fff; --line:#e9edf3; --muted:#6b7280; --ink:#0f172a; --timecol:#fafbff; --zeb1:#fbfcff; --zeb2:#f8fbff; --weekend:#fff7ed; }
  body{background:var(--bg); margin:0; font-family:Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; color:var(--ink);}
  .wrap{padding:16px 18px 28px;}
  .header{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px}
  h1{font-size:20px;margin:0}
  .toolbar{display:flex;gap:6px}
  .btn{border:1px solid var(--line); background:var(--panel); color:#1f2937; border-radius:8px; padding:6px 10px; font-size:12px; text-decoration:none; display:inline-flex; gap:6px; align-items:center}
  .btn:hover{background:#f3f4f6}
  .btn.primary{background:#5b6bff;color:#fff;border-color:transparent}
  .panel{background:var(--panel); border:1px solid var(--line); border-radius:12px; margin:10px 0}
  .panel-heading{padding:10px 12px; border-bottom:1px solid var(--line); font-weight:700}
  .panel-body{padding:12px}
  .form-inline{display:flex; gap:10px; align-items:center; flex-wrap:wrap}
  select{border:1px solid var(--line); border-radius:8px; padding:6px 10px; background:#fff; font-size:13px}

  .board{border:1px solid var(--line); border-radius:14px; overflow:hidden; background:var(--panel)}
  .week{ display:grid; grid-template-columns: 120px repeat(7,1fr); height: 740px; position:relative; }
  .time-rail{ background:var(--timecol); border-right:1px solid var(--line); position:relative; }
  .band{ position:relative; border-bottom:1px solid var(--line); display:flex; align-items:center; padding-left:12px; font-size:12px; color:#374151; height:calc((100% - 34px) / <?php echo max(count($bands),1); ?>); }
  .band:last-child{ border-bottom:none; }
  .day-col{ position:relative; border-left:1px solid var(--line); background:var(--zeb1); }
  .day-col:nth-child(odd){ background:var(--zeb2); }
  .day-col.weekend{ background:var(--weekend); }
  .day-head{ position:sticky; top:0; z-index:2; background:linear-gradient(180deg,#fafbff,#fff); border-bottom:1px solid var(--line); text-align:center; font-weight:700; font-size:12px; padding:8px 0 }
  .slot-2h{ position:relative; border-bottom:1px solid #f1f3f6; height:calc((100% - 34px) / <?php echo max(count($bands),1); ?>); transition:background .15s; cursor:pointer; }
  .slot-2h:hover{ background:#f3f7ff }
  .slot-2h .badge{ position:absolute; right:8px; top:8px; min-width:18px; height:18px; padding:0 6px; background:#e8eefc; color:#1f3b7b; font-size:11px; border-radius:999px; align-items:center; justify-content:center; }
  .slot-2h.selected{ background: linear-gradient(180deg,#eef4ff 0%, #f7fbff 100%); box-shadow: inset 0 0 0 2px #98b8ff; }

  .event{ position:absolute; left:6px; right:6px; border-radius:12px; border:1px solid var(--line); background-image:linear-gradient(180deg,#ffffff, #fafbff); box-shadow:0 1px 2px rgba(0,0,0,.06); padding:8px 10px; overflow:hidden; pointer-events:auto; cursor:pointer; transition: box-shadow .12s, transform .06s }
  .event:hover{ box-shadow:0 3px 10px rgba(0,0,0,.10); }
  .event:active{ transform:scale(.995); }
  .event .title{ font-weight:800; font-size:12px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis }
  .event .meta{ font-size:11px; color:#6b7280; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-top:2px }
  .event .where{ font-size:11px; color:#4b5563; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-top:2px }

  .legend{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px}
  .legend .item{background:#fff;border:1px solid var(--line);border-radius:10px;padding:4px 8px;font-size:12px}
  .legend .sw{width:12px;height:12px;display:inline-block;border-radius:3px;margin-right:6px;vertical-align:-2px}

  /* Modal */
  .modal{ position:fixed; inset:0; background:rgba(17,24,39,.45); display:none; align-items:center; justify-content:center; z-index:50 }
  .modal .box{ background:#fff; border-radius:14px; width:min(560px,92vw); max-height:80vh; overflow:auto; box-shadow:0 10px 30px rgba(0,0,0,.18); position:relative }
  .modal .head{ padding:12px 16px; border-bottom:1px solid var(--line); font-weight:800 }
  .modal .body{ padding:12px 16px }
  .ev-item{ border:1px solid var(--line); border-left:5px solid #ddd; border-radius:10px; padding:8px 10px; margin-bottom:8px; background:#fafafa }
  .ev-item .t{ font-weight:800 }
  .close-x{ position:absolute; right:14px; top:10px; cursor:pointer; color:#6b7280 }
   body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }
    #calendar {
        max-width: 90%;
        margin: 30px auto;
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0px 4px 20px rgba(0,0,0,0.1);
    }
    /* Event tile styling */
    .fc-event {
        border-radius: 8px !important;
        border: none !important;
        padding: 5px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        opacity: 0.9;
    }
    /* Popup styling */
    .event-popup {
        position: absolute;
        background: white;
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
        padding: 15px;
        display: none;
        z-index: 1000;
        min-width: 200px;
    }
    .popup-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .popup-time {
        color: #555;
        margin-bottom: 10px;
    }
    .popup-desc {
        font-size: 14px;
        color: #333;
    }
</style>
</head>
<body>
<div class="wrap" id="content-wrapper">

  <div class="header">
    <h1>Faculty Dashboard</h1>
    <div class="toolbar">
      <a class="btn" href="<?php echo base_url($currentModule); ?>"><i class="fa fa-list"></i> Projects</a>
      <a class="btn" href="<?php echo base_url($currentModule.'/allocate_students'); ?>"><i class="fa fa-users"></i> Allocate</a>
      <a class="btn" href="<?php echo base_url($currentModule.'/timetable'); ?>"><i class="fa fa-calendar"></i> Timetable</a>
    </div>
  </div>

  <div class="panel">
    <div class="panel-heading">Filters</div>
    <div class="panel-body">
      <form method="POST" action="<?php echo base_url('Project/faculty_dashboard'); ?>" class="form-inline">
        <div>
          <select name="academic_year" id="academic_year" required>
            <option value="">Academic Year</option>
            <?php foreach ($academic_years_safe as $yr): $y=$yr['academic_year']; ?>
              <option value="<?php echo htmlspecialchars($y); ?>" <?php echo ($y==$sel_year_val?'selected':''); ?>><?php echo htmlspecialchars($y); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
         
		  
		    <select name="faculty_id" id="faculty_id" required>
    <option value="">Faculty</option>
    <?php
      $role_id = (int)$this->session->userdata('role_id');
      $my_emp  = trim((string)$this->session->userdata('aname'));

      foreach ($faculties as $f) {
          // If role is 21 or 44, show only the logged-in faculty
          if (in_array($role_id, [21, 44], true) && $f['emp_id'] != $my_emp) {
              continue;
          }
          $selected = ($f['emp_id'] == $sel_faculty_val || (in_array($role_id, [21,44], true) && $f['emp_id'] == $my_emp)) 
                      ? 'selected' : '';
          echo '<option value="'.htmlspecialchars($f['emp_id']).'" '.$selected.'>'.
               htmlspecialchars($f['emp_id'].' - '.$f['fac_name']).
               '</option>';
      }
    ?>
  </select>
  
    
        </div>
        <button class="btn primary" type="submit">Show</button>
      </form>
    </div>
  </div>

  <?php if (!empty($sel_year_val) && !empty($sel_faculty_val)): ?>
    <div class="board">
      <div class="week" id="week" data-start-hour="<?php echo (int)$startHour; ?>" data-end-hour="<?php echo (int)$endHour; ?>">
        <!-- Left 2-hour bands rail -->
        <div class="time-rail" id="time-rail">
          <div class="day-head" style="text-align:left;padding-left:12px;">Time</div>
          <?php foreach ($bands as $b): ?>
            <div class="band"><?php echo htmlspecialchars($b[2]); ?></div>
          <?php endforeach; ?>
        </div>

        <!-- Day columns -->
        <?php foreach ($DAYS as $i=>$d): ?>
          <div class="day-col <?php echo ($i>=5?'weekend':''); ?>" data-day="<?php echo htmlspecialchars($d); ?>">
            <div class="day-head"><?php echo htmlspecialchars($d); ?></div>
            <?php foreach ($bands as $b): ?>
              <div class="slot-2h" data-start="<?php echo $b[0]; ?>" data-end="<?php echo $b[1]; ?>">
                <span class="badge"></span>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Legend -->
    <?php
      $legend = array();
      foreach ($events as $e) { $pid=$e['pid']; $t=$e['title']; if($pid && $t && !isset($legend[$pid])) $legend[$pid]=$t; }
    ?>
    <?php if(!empty($legend)): ?>
      <div class="legend" style="margin-top:12px">
        <?php foreach ($legend as $pid=>$t): ?>
          <span class="item"><span class="sw" style="background:<?php echo colorFor($pid); ?>"></span><?php echo htmlspecialchars($t); ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  <?php else: ?>
    <div class="panel"><div class="panel-body">Pick Academic Year and Faculty, then click <b>Show</b>.</div></div>
  <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal" id="detailModal">
  <div class="box">
    <div class="head">
      <span id="modalTitle">Details</span>
      <span class="close-x" onclick="document.getElementById('detailModal').style.display='none'">&#10005;</span>
    </div>
    <div class="body" id="modalBody"></div>
  </div>
</div>

<script>
/* PHP -> JS */
window.weekEvents = <?php echo json_encode($events, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT); ?>;

(function(){
  var weekEl = document.getElementById('week');
  if(!weekEl) return;

  var startHour = parseInt(weekEl.getAttribute('data-start-hour') || '8', 10);
  var endHour   = parseInt(weekEl.getAttribute('data-end-hour')   || '20',10);
  var totalMin  = (endHour - startHour) * 60;
  var bodyH     = weekEl.clientHeight - 34;

  var dayCols = weekEl.querySelectorAll('.day-col');
  var byDay = [[],[],[],[],[],[],[]];
  (window.weekEvents||[]).forEach(function(e){ if(e.dayIdx>=0 && e.dayIdx<7) byDay[e.dayIdx].push(e); });

  function minutes(m){ return (m/totalMin) * bodyH + 34; } // px from top
  function toMin(hm){ var p=hm.split(':'), H=parseInt(p[0],10)||0, M=parseInt(p[1],10)||0; return H*60+M; }
  function toLabel(m){ var h=('0'+Math.floor(m/60)).slice(-2), n=('0'+(m%60)).slice(-2); return h+':'+n; }
  function dayName(idx){ return ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'][idx] || ''; }
  function esc(s){ return String(s).replace(/[&<>"']/g,function(m){return({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]);}); }

  // Highlight helper
  function selectSlot(el){
    document.querySelectorAll('.slot-2h.selected').forEach(function(x){ x.classList.remove('selected'); });
    if(el) el.classList.add('selected');
  }

  // Place events (clickable)
  for (var d=0; d<7; d++){
    var col = dayCols[d];
    var list = byDay[d];

    list.forEach(function(e){
      var sp = e.start.split(':'), ep = e.end.split(':');
      var s = (parseInt(sp[0],10)*60 + parseInt(sp[1],10)) - startHour*60;
      var t = (parseInt(ep[0],10)*60 + parseInt(ep[1],10)) - startHour*60;
      if (s<0) s=0; if (t>totalMin) t=totalMin;

      var top = minutes(s);
      var h   = minutes(t)-minutes(s);
      var div = document.createElement('div');
      div.className='event';
      div.style.top = top+'px';
      div.style.height = Math.max(h, 36)+'px';
      div.style.borderLeft = '8px solid ' + (e.color || 'rgb(255 155 214)');
	   div.style.backgroundColor = '#b4e5b5';
      div.innerHTML =
          '<div class="title">'+ esc(e.title||'Untitled') +'</div>'
        + (e.domain?'<div class="meta">'+esc(e.domain)+'</div>':'')
        + (e.where? '<div class="where">'+esc(e.where)+'</div>':'');

      // Click: open single-event modal and highlight its start band
      div.addEventListener('click', function(){
        var startAbs = toMin(e.start);
        var slots = col.querySelectorAll('.slot-2h');
        var bandEl = null;
        for (var i=0;i<slots.length;i++){
          var sBand = parseInt(slots[i].getAttribute('data-start'),10);
          var eBand = parseInt(slots[i].getAttribute('data-end'),10);
          if (startAbs >= sBand && startAbs < eBand){ bandEl = slots[i]; break; }
        }
        selectSlot(bandEl);
        openModal(e.title || 'Untitled', [e]);
      });

      col.appendChild(div);
    });

    // per 2-hour slot: count + whole-box click
    var slots = col.querySelectorAll('.slot-2h');
    for (var i=0;i<slots.length;i++){
      (function(slotEl, dayIdx){
        var sBand = parseInt(slotEl.getAttribute('data-start'),10);
        var eBand = parseInt(slotEl.getAttribute('data-end'),10);

        var found = (byDay[dayIdx]||[]).filter(function(e){
          var s = toMin(e.start), t = toMin(e.end);
          return (t > sBand) && (s < eBand); // overlap counts
        });

        var badge = slotEl.querySelector('.badge');
		
      // if (badge) badge.textContent = found.length;

        slotEl.addEventListener('click', function(){
          selectSlot(slotEl);
          var title = dayName(dayIdx)+' • '+toLabel(sBand)+' – '+toLabel(eBand);
          openModal(title, found);
        });
      })(slots[i], d);
    }
  }

  // Modal
  function openModal(title, items){
    var modal = document.getElementById('detailModal');
    document.getElementById('modalTitle').textContent = title;
    var body = document.getElementById('modalBody');
    body.innerHTML = '';
    if(!items || !items.length){
      body.innerHTML = '<div class="ev-item">No events in this slot.</div>';
    }else{
      items.forEach(function(e){
        var el = document.createElement('div');
        el.className = 'ev-item';
        el.style.borderLeftColor = e.color || '#7CB9E8';
        el.innerHTML =
          '<div class="t">'+esc(e.title||'Untitled')+'</div>'+
          '<div>'+esc(e.start)+' – '+esc(e.end)+'</div>'+
          (e.domain?'<div>'+esc(e.domain)+'</div>':'')+
          (e.where? '<div>'+esc(e.where) +'</div>':'');
        body.appendChild(el);
      });
    }
    modal.style.display='flex';
    modal.addEventListener('click', function(ev){ if(ev.target===modal) modal.style.display='none'; }, { once:true });
  }

  // (Optional) reflow on resize if you want—this simple version keeps it as-is.
  window.addEventListener('resize', function(){ /* noop */ });
})();


document.addEventListener('DOMContentLoaded', function () {
  var role = <?php echo (int)$role_id; ?>;
  if (role !== 21 && role !== 44) return;

  var fy   = document.getElementById('faculty_id');
  var ay   = document.getElementById('academic_year');
  if (!fy || !ay || !ay.value) return;

  var form = fy.form;
  // Key so we submit only once for this AY+Faculty
  var key  = 'fd_autosub:' + ay.value + ':' + fy.value;

  if (sessionStorage.getItem(key)) return; // already auto-submitted -> don't loop
  sessionStorage.setItem(key, '1');

  // optional: mark this as auto submission
  if (!form.querySelector('input[name="auto"]')) {
    var h = document.createElement('input');
    h.type = 'hidden'; h.name = 'auto'; h.value = '1';
    form.appendChild(h);
  }

  form.submit();
});
</script>
</body>
</html>
