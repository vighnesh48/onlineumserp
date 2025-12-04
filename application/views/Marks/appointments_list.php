<?php // header & CSS already loaded by your main layout ?>
<style>
.panel {
  border: none !important;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  background: #fff;
}
.panel-heading {
  background: linear-gradient(to right, #4b6cb7, #182848);
  color: #fff;
  border-radius: 8px 8px 0 0;
  padding: 12px 20px;
}
.panel-title {
  font-weight: 600;
  font-size: 15px;
  color: white;
}
.btn-primary {
  background: linear-gradient(to right, #5d8fff, #0037a5) !important;
  border: none !important;
}
.btn-primary:hover {
  background: linear-gradient(to right, #3e5ca4, #152043) !important;
}
/* Tables */
.table {
  background: #fff !important;
  border: 1px solid #dee2e6 !important;
  border-radius: 6px !important;
  overflow: hidden !important;
}
.table th {
  background: #4b6cb7 !important;
  color: #fff !important;
  text-align: center !important;
  vertical-align: middle !important;
  font-weight: 600 !important;
  border: none !important;
}
.table-bordered > thead > tr > th,
.table-bordered > tbody > tr > td {
  border: 1px solid #dee2e6 !important;
}
.table td {
  vertical-align: middle !important;
  font-size: 13px !important;
  text-align: center !important;
}
.table tr:nth-child(even) {
  background: #f9fbfd !important;
}
</style>
<div id="content-wrapper" class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <h3 class="page-header">
        <i class="glyphicon glyphicon-briefcase"></i> External Practical Faculty — Appointment Orders
      </h3>
    </div>
  </div>
  <!-- Results Panel -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong class='panel-title' ><i class="glyphicon glyphicon-list-alt"></i> Allocated Externals</strong> 
	  <!-- Filter Form -->
	  <form id="filterForm" method="get" class="form-inline text-right" style="margin-bottom:0px; width:100%;">
		<div class="form-group">
		  <select name="school_code" id="school_code" class="form-control input-sm" required>
			<option value="">Select School</option>
			<?php foreach ($schools as $sch): ?>
			  <option value="<?= $sch['school_code']; ?>" <?= ($sch['school_code'] == $school_code) ? 'selected' : ''; ?>>
				<?= $sch['school_short_name']; ?>
			  </option>
			<?php endforeach; ?>
		  </select>
		</div>

		<input type="hidden" name="exam_session" id="exam_session"
			   value="<?= $exam_session[0]['exam_month'].'-'.$exam_session[0]['exam_year'].'-'.$exam_session[0]['exam_id'] ?>">

		<button type="submit" class="btn btn-primary btn-sm">
		  <i class="glyphicon glyphicon-search"></i> Search
		</button>
	  </form>
    </div>
	
    <div class="panel-body table-responsive">

      <?php if (!empty($assignments)) : ?>
        <table class="table table-bordered table-hover table-condensed">
          <thead>
            <tr class="info">
              <th style="width:5%;">#</th>
              <th style="width:18%;">External Faculty Name</th>
              <th style="width:14%;">Designation</th>
              <th style="width:18%;">Institute</th>
              <th style="width:10%;">Mobile</th>
              <th style="width:15%;">Email</th>
              <th style="width:10%;">Status</th>
              <th style="width:10%;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; foreach ($assignments as $ext): ?>
              <tr>
                <td><?= $i++; ?></td>
                <td><?= $ext['ext_fac_name']; ?></td>
                <td><?= $ext['ext_fac_designation']; ?></td>
                <td><?= $ext['ext_fac_institute']; ?></td>
                <td><?= $ext['ext_fac_mobile']; ?></td>
                <td><?= $ext['ext_fac_email']; ?></td>
                <td>
                  <?php if ($ext['letter_sent'] == 'Y'): ?>
                    <span class="label label-success">Sent</span>
                  <?php elseif ($ext['letter_verified'] == 'Y'): ?>
                    <span class="label label-info">Verified</span>
                  <?php else: ?>
                    <span class="label label-warning">Pending</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($ext['letter_verified'] != 'Y'): ?>
                    <button class="btn btn-xs btn-primary verify-btn"
                            data-code="<?= $ext['ext_faculty_code']; ?>">
                      <i class="glyphicon glyphicon-ok"></i> Verify
                    </button>
                  <?php elseif ($ext['letter_sent'] != 'Y'): ?>
                    <button class="btn btn-xs btn-success send-btn"
                            data-code="<?= $ext['ext_faculty_code']; ?>">
                      <i class="glyphicon glyphicon-envelope"></i> Send
                    </button>
                  <?php else: ?>
                    <button class="btn btn-xs btn-default" disabled>
                      <i class="glyphicon glyphicon-check"></i> Completed
                    </button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <div class="alert alert-info text-center" style="margin:20px 0;">
          Please select filters and click <strong>Search</strong> to view assigned externals.
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>


<script>
$(function(){
    var base_url = '<?= base_url() ?>';

    // ✅ Verify & view appointment order
    $('.verify-btn').on('click', function(){
        var id = $(this).data('code');
		var school_code = $("#school_code").val();
		var exam_session = $("#exam_session").val();
		
        var $btn = $(this);
        $btn.prop('disabled', true).text('Verifying...');

        $.post(base_url + 'marks/verify_and_get_url', {id: id ,school_code: school_code,exam_session: exam_session}, function(resp){
            if (resp.status === 'success') {
                // open virtual PDF in new tab
                const win = window.open("", "_blank");
                win.document.write("<iframe width='100%' height='100%' src='" + resp.download_url + "'></iframe>");

                // update UI
                $btn.closest('tr').find('td:nth-child(7)').html('<span class="badge badge-info">Verified</span>');
                $btn.closest('td').html('<button class="btn btn-sm btn-success send-btn" data-code="' + id + "'>Send</button>");
            } else {
                alert('Error: ' + (resp.message || 'unknown'));
                $btn.prop('disabled', false).text('Verify');
            }
        }, 'json').fail(function(){
            alert('Request failed');
            $btn.prop('disabled', false).text('Verify');
        });
    });

	// ✅ Send appointment letter via email
	$(document).on('click', '.send-btn', function(){
		var id = $(this).data('code');
		var school_code = $("#school_code").val();
		var exam_session = $("#exam_session").val();
		var $btn = $(this);
		$btn.prop('disabled', true).text('Sending...');

		$.post(base_url + 'marks/send_and_mail_letter', {id: id, school_code: school_code, exam_session: exam_session}, function(resp){
			if (resp.status === 'success') {
				alert('Appointment Letter sent successfully.');
				$btn.closest('tr').find('td:nth-child(7)').html('<span class="badge badge-success">Sent</span>');
				$btn.closest('td').html('<button class="btn btn-sm btn-secondary" disabled>Completed</button>');
			} else {
				alert(resp.message || 'Error sending mail.');
				$btn.prop('disabled', false).text('Send');
			}
		}, 'json').fail(function(){
			alert('Request failed.');
			$btn.prop('disabled', false).text('Send');
		});
	});

});

</script>
