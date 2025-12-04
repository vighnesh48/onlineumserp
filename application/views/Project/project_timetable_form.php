<?php
$astrik = '<sup style="color:red">*</sup>';
$edit   = !empty($row['id']);
?>
<div id="content-wrapper">
  <ul class="breadcrumb breadcrumb-page">
    <div class="breadcrumb-label text-light-gray">You are here: </div>
    <li><a href="#">Masters</a></li>
     <li class="active"><a href="#"><?= $edit ? 'Edit' : 'Add' ?> Project Timetable</a></li>
		
  </ul>
  
  
  <style>
  /* tiny spacing + make it feel like a toolbar */
  .pt-toolbar { margin: 10px 0 20px; }
  .pt-toolbar .btn { margin-bottom: 8px; } /* stack spacing on xs */
</style>
  

  <div class="page-header">
  

  
	
  
    <div class="row">
	
	<div class="col-sm-7">

      <h1 class="col-xs-12 col-sm-4 text-left">
        <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;<?= $edit ? 'Edit' : 'Add' ?> Project Timetable
		
      </h1>
  </div>
	<div class="col-sm-5 text-right">
	
	 <div class="col-sm-12 text-right">
      <a class="btn btn-primary btn-sm" href="<?= base_url($currentModule) ?>">
       Project list
      </a>
      <a class="btn btn-primary btn-sm" href="<?= base_url($currentModule.'/allocate_students') ?>">
       Allocate Students
      </a>
      <a class="btn btn-primary btn-sm" href="<?= base_url($currentModule.'/ptlist') ?>">
         Timetable
      </a>
	  
	  
    </div>
	  </div>
	  </div>
	
	
	

    <div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <div class="row">
      <div class="col-sm-12">
        <div class="panel">
          <div class="panel-heading">
            <?php if ($dup = $this->session->flashdata('dup_msg')): ?>
              <div style="color:red;font-weight:900;"><?= $dup ?></div>
            <?php endif; ?>
            <?php if ($ok = $this->session->flashdata('Tmessage')): ?>
              <div style="color:green;font-weight:900;"><?= $ok ?></div>
            <?php endif; ?>
          </div>

          <div class="panel-body">
            <div class="table-info">
              <form id="form" action="<?= base_url('Project/timetable_save') ?>" method="POST">
                <input type="hidden" name="id" value="<?= $row['id'] ?? '' ?>"/>

                <div class="form-group">
                  <div class="col-sm-2">Academic Year <?= $astrik ?></div>
                  <div class="col-sm-3">
                    <select name="academic_year" id="academic_year" class="form-control" required>
                      <option value="">Select Academic Year</option>
                      <?php
                     // $sel_year = $row['academic_year'] ?? ($sel_year ?? '');
					  
					  $sel_year = set_value('academic_year') ?: ACADEMIC_YEAR;
                      if (!empty($academic_years)) {
                        foreach ($academic_years as $yr) {
							if($sel_year==$yr['academic_year']){
                          $y = $yr['academic_year'];
                          $sel = ($y == $sel_year) ? 'selected' : '';
                          echo '<option value="'.$y.'" '.$sel.'>'.$y.'</option>';
							}
                        }
                      }
                      ?>
                    </select>
                  </div>
				  
				  
				 
  
			<div class="col-sm-2">Department <?= $astrik ?></div>
			<div class="col-sm-3">
			<select name="stream_id" class="form-control form-control-sm" id="department_select" required>
			<option value="">Select</option>
			<?php
			if (!empty($departments)) {
			//$selected_department = $row('stream_id', '');
			foreach ($departments as $dept) {
			$deptId = $dept['stream_id'];
			$deptName = $dept['stream_name'];
			$sel = ($deptId == $selected_department) ? 'selected' : '';
			echo '<option value="'.$deptId.'" '.$sel.'>'.$deptName.'</option>';
			}
			}
			?>
			</select>
			</div>

<div class="col-sm-2"></div>
                  
                </div>

                <div class="clearfix">&nbsp;</div>

                <div class="form-group">
				<div class="col-sm-2">Project <?= $astrik ?></div>
                 <div class="col-sm-3">
    <div class="mb-1">
        <button type="button" class="btn btn-sm btn-success" id="addAll">Add All</button>
<button type="button" class="btn btn-sm btn-danger"  id="removeAll">Remove All</button>
    </div>
    <select name="project_id[]" id="project_id" class="form-control" multiple required>
        <?php
        $selectedProjects = isset($row['project_id']) ? explode(',', $row['project_id']) : (isset($sel_project) ? (array)$sel_project : []);
        if (!empty($projects)) {
            foreach ($projects as $p) {
                $sel = in_array($p['id'], $selectedProjects) ? 'selected' : '';
                echo '<option value="'.$p['id'].'" '.$sel.'>'.
                        htmlspecialchars($p['project_title'].' - '.$p['domain']).
                     '</option>';
            }
        }
        ?>
    </select>
</div>
	</div>			
				
				  <div class="clearfix">&nbsp;</div>
				 <div class="form-group">
                  <div class="col-sm-2">Project Slot <?= $astrik ?></div>
                  <div class="col-sm-3">
                    <select name="proj_slot_id" id="proj_slot_id" class="form-control" required>
                      <option value="">Select Slot</option>
                      <?php
                      $slotSel = $row['proj_slot_id'] ?? '';
                      foreach ($slots as $s) {
                        $sel = ($s['proj_slot_id']==$slotSel)?'selected':'';
                        echo '<option value="'.$s['proj_slot_id'].'" '.$sel.'>'.
                              $s['from_time'].' - '.$s['to_time'].
                             '</option>';
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-sm-2">Week Day <?= $astrik ?></div>
                  <div class="col-sm-3">
                    <?php $daySel = $row['wday'] ?? ''; ?>
                    <select name="wday" id="wday" class="form-control" required>
                      <option value="">Select</option>
                      <?php foreach (['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $d): ?>
                        <option value="<?= $d ?>" <?= $d==$daySel ? 'selected' : '' ?>><?= $d ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                  <!--  <div class="clearfix">&nbsp;</div>

                <div class="form-group">
                  <div class="col-sm-2">Building Name</div>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="building_name" value="<?= htmlspecialchars($row['building_name'] ?? '') ?>">
                  </div>

                  <div class="col-sm-2">Floor No</div>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="floor_no" value="<?= htmlspecialchars($row['floor_no'] ?? '') ?>">
                  </div>
                </div>

                <div class="clearfix">&nbsp;</div>-->

                <div class="form-group">
                 <!-- <div class="col-sm-2">Class Room No</div>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="room_no" value="<?= htmlspecialchars($row['room_no'] ?? '') ?>">
                  </div>-->

                  <div class="col-sm-2"></div>
                  <div class="col-sm-3">
                    <button class="btn btn-primary form-control" type="submit"><?= $edit ? 'Update' : 'Submit' ?></button>
					
					
					
                  </div>
                </div>
              </form>

              <div class="clearfix">&nbsp;</div>
              <hr>

              <h4  class="hidden">Project Timetable</h4>
              <table class="table table-bordered hidden">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Academic Year</th>
                    <th>Project</th>
                    <th>Week Day</th>
                    <th>Slot</th>
                    <!--<th>Building</th>
                    <th>Floor</th>
                    <th>Room</th>-->
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php if (!empty($rows)): $i=1; foreach ($rows as $r): ?>
                  <tr <?= $r['status']=='N' ? "style='background:#FBEFF2'" : '' ?>>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($r['academic_year']) ?></td>
                    <td><?= htmlspecialchars(($r['project_title'] ?? '').' - '.($r['domain'] ?? '')) ?></td>
                    <td><?= htmlspecialchars($r['wday']) ?></td>
                    <td><?= htmlspecialchars($r['from_time'].' - '.$r['to_time']) ?></td>
                    <!--<td><?= htmlspecialchars($r['building_name']) ?></td>
                    <td><?= htmlspecialchars($r['floor_no']) ?></td>
                    <td><?= htmlspecialchars($r['room_no']) ?></td>-->
                    <td>
                      <a href="<?= base_url('Project/edit_timetable/'.$r['id']) ?>"><i class="fa fa-edit"></i></a> 
                      
                    </td>
                  </tr>
                <?php endforeach; else: ?>
                  <tr><td colspan="9">No data found.</td></tr>
                <?php endif; ?>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
var base_url = '<?= site_url() ?>';
document.getElementById('academic_year').addEventListener('change', function(){
  var y = this.value;
  var sel = document.getElementById('project_id');
  sel.innerHTML = '<option value="">Loading...</option>';
  if (!y) { sel.innerHTML = '<option value="">Select Project</option>'; return; }
  fetch(base_url + 'Project_timetable/load_projects', {
    method: 'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded'},
    body: 'academic_year=' + encodeURIComponent(y)
  }).then(r=>r.text()).then(html => sel.innerHTML = html)
    .catch(()=> sel.innerHTML = '<option value="">Select Project</option>');
});
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('#project_id').select2({
        placeholder: "Select Project(s)",
        allowClear: true,
        width: '100%'
    });

    // "Select All" logic
    $('#project_id').on('select2:select', function(e) {
        if (e.params.data.id === 'all') {
            $('#project_id > option').prop("selected", true);
            $('#project_id').trigger("change");
        }
    });
});
</script>
<script>
(function () {
  function onReady(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  onReady(function () {
    var addBtn = document.getElementById('addAll');
    var remBtn = document.getElementById('removeAll');
    var sel    = document.getElementById('project_id');
    if (!addBtn || !remBtn || !sel) return; // IDs not found

    addBtn.addEventListener('click', function () {
      for (var i = 0; i < sel.options.length; i++) sel.options[i].selected = true;
      // notify any listeners / validators
      try { sel.dispatchEvent(new Event('change', { bubbles: true })); } catch (e) {}
      if (window.jQuery && jQuery(sel).hasClass('select2-hidden-accessible')) jQuery(sel).trigger('change');
    });

    remBtn.addEventListener('click', function () {
      for (var i = 0; i < sel.options.length; i++) sel.options[i].selected = false;
      try { sel.dispatchEvent(new Event('change', { bubbles: true })); } catch (e) {}
      if (window.jQuery && jQuery(sel).hasClass('select2-hidden-accessible')) jQuery(sel).trigger('change');
    });
  });
})();
</script>
<script>
(function(){
  var baseUrl  = '<?= base_url(); ?>';
  // CSRF (if enabled)
 
  // Grab preset selected project IDs from PHP (edit mode or after validation fail)
  var preSelected = <?= json_encode(array_values($selectedProjects ?? [])) ?>;

  // Helper: render options, keep selected where applicable
  function renderProjects(list, presetIds) {
    var sel = document.getElementById('project_id');
    var html = '';
    if (Array.isArray(list) && list.length) {
      for (var i=0; i<list.length; i++) {
        var it = list[i];
        var text = it.title + (it.domain ? (' - ' + it.domain) : '');
        var selected = (presetIds && presetIds.indexOf(String(it.id)) !== -1) ? ' selected' : '';
        html += '<option value="'+it.id+'"'+selected+'>'+escapeHtml(text)+'</option>';
      }
    }
    sel.innerHTML = html;
    // If using Select2, refresh it:
    if (window.jQuery && jQuery(sel).hasClass('select2-hidden-accessible')) {
      jQuery(sel).trigger('change.select2');
    } else {
      // Fire a change event for any validators
      try { sel.dispatchEvent(new Event('change', {bubbles: true})); } catch(e) {}
    }
  }

  // Escape HTML to be safe
  function escapeHtml(s) {
    return String(s).replace(/[&<>"']/g, function(m){
      return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]);
    });
  }

  // AJAX loader
  function loadProjectsFor(streamId, presetIds) {
    var projSel = document.getElementById('project_id');
    // Clear when no department
    if (!streamId) {
      projSel.innerHTML = '';
      return;
    }
    projSel.innerHTML = '<option>Loading…</option>';

    var data = { stream_id: streamId, academic_year: getAcademicYear() };
   
    $.ajax({
      url: baseUrl + 'project/load_projects_by_stream',
      type: 'POST',
      data: data,
      dataType: 'json',
      success: function(res){
        renderProjects(res, presetIds || []);
      },
      error: function(){
        projSel.innerHTML = '<option value="">Failed to load</option>';
      }
    });
  }

  // Try to read AY if you have that select in the page
  function getAcademicYear(){
    var ay = document.querySelector('[name="academic_year"]');
    return ay ? ay.value : '';
  }

  // Bind: when department changes → reload projects
  document.getElementById('department_select').addEventListener('change', function(){
    // When user changes department, usually you should clear previous selections
    loadProjectsFor(this.value, []); 
  });

  // Initial populate on page load (if department already selected)
  document.addEventListener('DOMContentLoaded', function(){
    var dep = document.getElementById('department_select').value;
    if (dep) {
      loadProjectsFor(dep, preSelected);
    }
  });
})();
</script>
