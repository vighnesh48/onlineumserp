<style>
/* Buttons */
.btn {
  border-radius: 4px !important;
  transition: all 0.2s ease-in-out !important;
}
.btn-primary {
  background: linear-gradient(to right, #5d8fff, #0037a5) !important;
  border: none !important;
}
.btn-primary:hover {
  background: linear-gradient(to right, #3e5ca4, #152043) !important;
}
.btn-success {
  background: linear-gradient(to right, #43cea2, #185a9d) !important;
  border: none !important;
}
.btn-success:hover {
  background: linear-gradient(to right, #38b592, #144f89) !important;
}
.page-header-icon{
color:green !important;	
}
</style>

<div id="content-wrapper">
  <ul class="breadcrumb breadcrumb-page">
    <li><a href="#">Examination</a></li>
    <li class="active">Remuneration Master</li>
  </ul>

  <div class="page-header">
    <h1><i class="fa fa-money page-header-icon"></i> Remuneration Master</h1>
  </div>

  <div class="panel">
    <div class="panel-heading" style="background:linear-gradient(to right,#4b6cb7,#182848);height:75px;">
      <span class="panel-title" style="color:#fff;">Add / Manage Remuneration</span>
      <button class="btn btn-success pull-right" onclick="openModal()"><i class="fa fa-plus"></i> Add Remuneration</button>
    </div>
    <div class="panel-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>School</th>
            <th>Course</th>
            <th>Practical</th>
            <th>Project</th>
            <th>Seminar</th>
            <th>Viva Voce</th>
            <th>Dissertation</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($remunerations)): $i=1; foreach($remunerations as $r): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= $r['school_short_name'] ?></td>
            <td><?= $r['course_name'] ?></td>
            <td><?= $r['practical'] ?></td>
            <td><?= $r['project'] ?></td>
            <td><?= $r['seminar'] ?></td>
            <td><?= $r['viva_voce'] ?></td>
            <td><?= $r['dissertation'] ?></td>
            <td>
              <i class="fa fa-edit" style="cursor:pointer;color:blue;" onclick="editRemuneration(<?= $r['id'] ?>)"></i>
            </td>
          </tr>
          <?php endforeach; else: ?>
          <tr><td colspan="8">No records found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL FORM -->
<div id="remunerationModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form id="remunerationForm">
      <div class="modal-content">
        <div class="modal-header" style="background:linear-gradient(to right,#4b6cb7,#182848);color:#fff;">
          <h4 class="modal-title">Remuneration Details</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="id">

          <div class="form-group">
            <label>School</label>
            <select name="school_code" id="school_code" class="form-control" required>
              <option value="">Select School</option>
              <?php foreach($schools as $sch): ?>
                <option value="<?= $sch['school_code'] ?>"><?= $sch['school_short_name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Course</label>
            <select name="course_id" id="course_id" class="form-control" required>
              <option value="">Select Course</option>
            </select>
          </div>

          <div class="form-group">
            <label>Remuneration Details</label>
            <table class="table">
              <tr>
                <td>Practical</td>
                <td><input type="number" step="0.01" name="practical" id="practical" class="form-control"></td>
              </tr>
              <tr>
                <td>Project</td>
                <td><input type="number" step="0.01" name="project" id="project" class="form-control"></td>
              </tr>  
			  <tr>
                <td>Seminar</td>
                <td><input type="number" step="0.01" name="seminar" id="seminar" class="form-control"></td>
              </tr>
              <tr>
                <td>Viva Voce</td>
                <td><input type="number" step="0.01" name="viva_voce" id="viva_voce" class="form-control"></td>
              </tr>
              <tr>
                <td>Dissertation</td>
                <td><input type="number" step="0.01" name="dissertation" id="dissertation" class="form-control"></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
var base_url = '<?= base_url() ?>';

function openModal() {
  $('#remunerationForm')[0].reset();
  $('#id').val('');
  $('#remunerationModal').modal('show');
}

$('#school_code').on('change', function() {
  const schoolCode = $(this).val();
  $.post(base_url + 'Marks/load_courses', { school_code: schoolCode }, function(res) {
    $('#course_id').html(res);

    // ✅ Select the course automatically if in edit mode
    const selectedCourse = $('#course_id').data('selected');
    if (selectedCourse) {
      $('#course_id').val(selectedCourse);
    }
  });
});

function editRemuneration(id) {
  $.post(base_url + 'Marks/get_remuneration', { id: id }, function(res) {
    const data = JSON.parse(res);

    // Fill fields
    $('#id').val(data.id);
    $('#school_code').val(data.school_code);

    // Store the course_id temporarily in a data attribute
    $('#course_id').data('selected', data.course_id);

    // Trigger change → will load courses → then auto-select via callback above
    $('#school_code').trigger('change');

    // Fill remaining fields
    $('#practical').val(data.practical);
    $('#project').val(data.project);
    $('#seminar').val(data.seminar);
    $('#viva_voce').val(data.viva_voce);
    $('#dissertation').val(data.dissertation);

    $('#remunerationModal').modal('show');
  });
}



$('#remunerationForm').on('submit', function(e){
  e.preventDefault();
  $.post(base_url + 'Marks/remuneration_save', $(this).serialize(), function(res){
    var data = JSON.parse(res);
    alert(data.message);
    if(data.status === 'success') location.reload();
  });
});


</script>
