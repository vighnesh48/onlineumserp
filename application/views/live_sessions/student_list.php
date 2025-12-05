<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>My Live Sessions</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    :root{
      --card-bg:#fff; --muted:#777; --accent:#0d6efd;
      --success:#198754; --danger:#dc3545; --gray:#bbb;
    }
    body{font-family:Inter,Arial,Helvetica,sans-serif;background:#f4f6f9;margin:0;padding:24px;}
    .container{max-width:1100px;margin:0 auto;}
    .card{background:var(--card-bg);border-radius:10px;padding:18px;box-shadow:0 6px 18px rgba(0,0,0,0.04);}
    .top{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;}
    h2{margin:0;font-size:20px}
    .tabs{display:flex;gap:8px}
    .tab{padding:8px 12px;border-radius:8px;background:#eef3ff;color:#084298;cursor:pointer}
    .tab.active{background:#0d6efd;color:#fff}
    table{width:100%;border-collapse:collapse;margin-top:12px}
    th,td{padding:10px 12px;text-align:left;border-bottom:1px solid #eef2f5;vertical-align:middle}
    th{background:#fbfdff;font-weight:600;color:#333}
    .subject-chip{display:inline-flex;align-items:center;gap:8px;padding:6px 8px;border-radius:10px;color:#fff;font-size:13px}
    .title {font-weight:600}
    .muted{color:var(--muted);font-size:13px}
    .btn{padding:8px 12px;border-radius:8px;border:0;cursor:pointer}
    .btn-join{background:var(--success);color:#fff}
    .btn-disabled{background:var(--gray);color:#fff;cursor:not-allowed}
    .btn-leave{background:var(--danger);color:#fff;margin-left:8px}
    .badge{display:inline-block;padding:0px 10px;border-radius:999px;color:#fff;font-size:12px}
    .badge-completed{background:#6c757d}
    .badge-scheduled{background:var(--success)}
    .right{white-space:nowrap}
    .time-spent{font-weight:600;color:#0b5ed7}
    @media (max-width:800px){
      table,thead,tbody,tr,th,td{display:block}
      thead{display:none}
      tr{margin-bottom:8px;border-radius:8px;background:#fff;padding:10px}
      td{border:none;padding:6px}
      td.row-label{font-weight:600;color:#333}
      .right{margin-top:8px}
    }
  </style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Session List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-8 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; My Live Sessions</h1>
            <div class="col-xs-12 col-sm-4">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
					
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        
		  <div class="row ">
			<!--form id="form" name="form" action="<?=base_url($currentModule.'/markAttendance')?>" method="POST"-->    
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname"><div class="muted">Click <strong>Join</strong> to record attendance and open Google Meet. Time spent is shown when available.</div>
							<?php if ($this->session->flashdata('message')): ?>
							<p style="color:green;"><?php echo $this->session->flashdata('message'); ?></p>
						<?php endif; ?>
							</span>
                    </div>
                    <div class="panel-body">
						<div class="col-sm-12">
                        <div class="table-info">  
							<div class=""> 
																	
							</div>
  <div class="card">
    <div class="top">
 

      <div class="tabs" id="tabs">
        <div class="tab active" data-filter="today">Today</div>
        <div class="tab" data-filter="upcoming">Upcoming</div>
        <div class="tab" data-filter="past">Past</div>
        <div class="muted" style="align-self:center;margin-left:12px;font-size:13px" id="totalCount"></div>
      </div>
    </div>

    <div style="overflow:auto">
      <table id="sessionTable" aria-describedby="sessions">
        <thead>
          <tr>
            <th>Subject</th>
            <th>Title</th>
            <th>When</th>
            <th>Status</th>
            <th>Time Spent</th>
            <th class="right">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sessions as $s):
            $start_raw = $s->start ?? $s->start_time ?? null;
            $end_raw   = $s->end ?? $s->end_time ?? null;
            $start_ts = $start_raw ? strtotime($start_raw) : null;
            $end_ts = $end_raw ? strtotime($end_raw) : null;

            // status logic
            $status = $s->status ?? null;
            if (!$status) {
              if ($end_ts && $end_ts < time()) $status = 'completed';
              else $status = 'scheduled';
            }
            $is_completed = ($status === 'completed');

            // subject color (deterministic)
            $seed = !empty($s->subject_code) ? $s->subject_code : ($s->subject_id ?? $s->id);
            $hex = substr(md5($seed),0,6);
            $bg = '#'.$hex;
            // compute border slightly darker
            $r = hexdec(substr($hex,0,2)); $g = hexdec(substr($hex,2,2)); $b = hexdec(substr($hex,4,2));
            $factor = 0.78;
            $border = sprintf("#%02x%02x%02x",(int)($r*$factor),(int)($g*$factor),(int)($b*$factor));

            // formatted when
            $when = $start_raw ? date('d-M H:i', $start_ts) . ($end_ts ? ' — ' . date('H:i', $end_ts) : '') : '-';

            // friendly subject label
            $subject_label = trim((!empty($s->subject_code)? $s->subject_code.' - ':'').(!empty($s->subject_name)? $s->subject_name : ''),' -');
          ?>
          <tr class="session-row" data-session-id="<?php echo $s->id; ?>"
              data-start-ts="<?php echo $start_ts ?? 0; ?>"
              data-end-ts="<?php echo $end_ts ?? 0; ?>">
            <td>
              <span class="subject-chip" style="background:<?php echo $bg; ?>;border:2px solid <?php echo $border; ?>">
                <?php echo htmlspecialchars($subject_label); ?>
              </span>
              <div class="muted" style="margin-top:6px"><?php echo htmlspecialchars($s->subject_short_name ?? ''); ?></div>
            </td>

            <td>
              <div class="title"><?php echo htmlspecialchars($s->title); ?></div>
              <div class="muted"><?php echo htmlspecialchars($s->remark ?? ''); ?></div>
            </td>

            <td>
              <div><?php echo $when; ?></div>
              <div class="muted"><?php echo $start_raw ? date('Y-m-d', $start_ts) : ''; ?></div>
            </td>

            <td>
              <?php if ($is_completed): ?>
                <span class="badge badge-completed">Completed</span>
              <?php else: ?>
                <span class="badge badge-scheduled">Scheduled</span>
              <?php endif; ?>
            </td>

            <td>
              <div id="time_spent_<?php echo $s->id; ?>" class="time-spent muted">—</div>
              <div class="muted" style="font-size:12px" id="last_seen_<?php echo $s->id; ?>"></div>
            </td>

            <td class="right">
              <?php if ($is_completed): ?>
                <button class="btn btn-disabled" disabled>Session Ended</button>
              <?php else: ?>
                <?php if (!empty($s->meet_link)): ?>
                  <button class="btn btn-join" data-id="<?php echo $s->id; ?>">Join</button>
                <?php else: ?>
                  <button class="btn btn-disabled" disabled>No Meet</button>
                <?php endif; ?>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
(function($){
  'use strict';

  const HB_INTERVAL = 15000;
  const joinUrlBase = '<?php echo site_url("live_session/join_ajax"); ?>';
  const pingUrl = '<?php echo site_url("live_session/attendance_ping"); ?>';
  const leaveUrl = '<?php echo site_url("live_session/attendance_leave"); ?>';
  const summaryUrlBase = '<?php echo site_url("live_session/attendance_summary"); ?>'; // append /{session_id}

  // track active attendance timers
  window.activeAttendances = window.activeAttendances || {};

  // utility: format seconds to H:mm:ss or mm:ss
  function formatDuration(sec) {
    if (!sec && sec !== 0) return '—';
    sec = Math.max(0, parseInt(sec,10));
    const h = Math.floor(sec/3600);
    const m = Math.floor((sec%3600)/60);
    const s = sec%60;
    if (h>0) return h + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    return String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
  }

  // send leave using sendBeacon / fetch keepalive / sync xhr
  function sendLeaveKeepalive(attId) {
    try {
      const params = new URLSearchParams(); params.append('attendance_id', String(attId));
      const body = params.toString();
      const blob = new Blob([body], { type: 'application/x-www-form-urlencoded' });
      if (navigator.sendBeacon) { navigator.sendBeacon(leaveUrl, blob); return; }
      if (window.fetch) { fetch(leaveUrl, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body: body, keepalive:true }).catch(()=>{}); return; }
      var xhr = new XMLHttpRequest(); xhr.open('POST', leaveUrl, false); xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded'); xhr.send(body);
    } catch(e){ console.warn(e); }
  }

  // heartbeat + leave handling (keeps working as previous)
  function startHeartbeat(attendanceId, meetWindow, joinBtn, leaveBtn) {
    // immediate ping
    $.post(pingUrl, { attendance_id: attendanceId }).fail(()=>{});
    const timer = setInterval(function(){
      $.post(pingUrl, { attendance_id: attendanceId }).fail(()=>{});
      try {
        if (meetWindow && meetWindow.closed) {
          clearInterval(timer);
          $.post(leaveUrl, { attendance_id: attendanceId }).always(function(){
            if (leaveBtn) leaveBtn.remove();
            if (joinBtn) joinBtn.prop('disabled', false).text('Join');
            delete window.activeAttendances[attendanceId];
            // refresh time spent after finalized
            fetchAttendanceSummaryForRow(joinBtn ? joinBtn.data('id') : null);
          });
        }
      } catch(e){}
    }, HB_INTERVAL);
    window.activeAttendances[attendanceId] = { timerRef: timer, meetWindow: meetWindow };
  }

  // fetch attendance summary for session -> populate Time Spent fields
  function fetchAttendanceSummaryForRow(sessionId) {
    if (!sessionId) return;
    $.getJSON(summaryUrlBase + '/' + sessionId, function(res){
      if (!res) return;
      if (res.status === 'ok') {
        const att = res.attendance;
        $('#time_spent_' + sessionId).text(att.duration_seconds !== null ? formatDuration(att.duration_seconds) : (att.left_at ? '0:00' : 'In progress'));
        if (att.last_ping_at) $('#last_seen_' + sessionId).text('Last seen: ' + new Date(att.last_ping_at).toLocaleString());
      } else {
        $('#time_spent_' + sessionId).text('—');
      }
    }).fail(function(){ /* ignore */ });
  }

  // initial fetch for all rows
  $(document).ready(function(){
    // populate all time spent cells
    $('#sessionTable tbody tr.session-row').each(function(){
      const sessionId = $(this).data('session-id');
      fetchAttendanceSummaryForRow(sessionId);
    });

    // tab functionality: today/upcoming/past
    function computeFilter() {
      const now = Date.now()/1000;
      return function($row, filter) {
        const s = Number($row.data('start-ts') || 0);
        const e = Number($row.data('end-ts') || 0);
        if (filter === 'today') {
          // start within today (midnight->next midnight)
          const startOfToday = new Date(); startOfToday.setHours(0,0,0,0);
          const endOfToday = new Date(startOfToday.getTime()+24*3600*1000);
          return s >= startOfToday.getTime()/1000 && s < endOfToday.getTime()/1000;
        } else if (filter === 'upcoming') {
          return (!e || e >= now) && s > now - 3600*4; // upcoming and not far past (4h grace)
        } else if (filter === 'past') {
          return e && e < now;
        }
        return true;
      };
    }

    const rowFilter = computeFilter();

    $('#tabs .tab').on('click', function(){
      $('#tabs .tab').removeClass('active');
      $(this).addClass('active');
      const filter = $(this).data('filter');
      let visible = 0;
      $('#sessionTable tbody tr.session-row').each(function(){
        const $r = $(this);
        if (rowFilter($r, filter)) { $r.show(); visible++; } else $r.hide();
      });
      $('#totalCount').text(visible + ' sessions');
    });

    // trigger initial tabs filter (today)
    $('#tabs .tab.active').trigger('click');

    // Join button handler (delegated)
    $('#sessionTable').on('click', '.btn-join', function(e){
      e.preventDefault();
      const $btn = $(this);
      const sessionId = $btn.data('id') || $btn.closest('tr.session-row').data('session-id');
      if (!sessionId) return;
      // disable to avoid double click
      $btn.prop('disabled', true).text('Joining...');
      $.post(joinUrlBase + '/' + sessionId, {}, function(res){
        if (!res) { alert('Server error'); $btn.prop('disabled', false).text('Join'); return; }
        if (res.status === 'unauth') { alert('Please login'); window.location = '<?php echo site_url("auth/login"); ?>'; return; }
        if (res.status === 'expired') { alert(res.message || 'Session expired'); $btn.prop('disabled', true).text('Session Ended'); return; }
        if (res.status !== 'ok') { alert(res.message || 'Unable to join'); $btn.prop('disabled', false).text('Join'); return; }

        const attendanceId = res.attendance_id;
        const meetLink = res.meet_link;
        if (!attendanceId || !meetLink) { alert('Missing server data'); $btn.prop('disabled', false).text('Join'); return; }

        // open meet
        let meetWindow = null;
        try { meetWindow = window.open(meetLink, 'meet_' + attendanceId, 'noopener'); } catch(e){ window.location = meetLink; return; }

        // insert leave button next to join
        let $leave = $('<button>').addClass('btn btn-leave').text('Leave').insertAfter($btn);
        $leave.on('click', function(){
          try { if (meetWindow && !meetWindow.closed) meetWindow.close(); } catch(e){}
          const info = window.activeAttendances[attendanceId];
          if (info && info.timerRef) clearInterval(info.timerRef);
          $.post(leaveUrl, { attendance_id: attendanceId }).always(function(){
            $leave.remove();
            $btn.prop('disabled', false).text('Join');
            // refresh time spent
            fetchAttendanceSummaryForRow(sessionId);
          });
        });

        // start heartbeat
        startHeartbeat(attendanceId, meetWindow, $btn, $leave);

        // when join, immediately refresh time spent cell (will show In progress)
        fetchAttendanceSummaryForRow(sessionId);

      }, 'json').fail(function(){ alert('Network error'); $btn.prop('disabled', false).text('Join'); });
    });

  }); // ready

})(jQuery);
</script>

</body>
</html>
