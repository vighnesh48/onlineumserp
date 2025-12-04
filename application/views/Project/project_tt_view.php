<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>

<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" type="text/css"/>

<style>
	.table1{width: 120%;}
	table1{max-width: 120%;}
</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li class="active"><a href="#">Projects</a></li>
        <li class="active"><a href="#">Project Time Table</a></li>
    </ul>

    <div class="page-header">
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Project Time Table
            </h1>
            <div class="col-xs-12 col-sm-8">
			<?php
						$role_id = $this->session->userdata('role_id');
						if($role_id==10 || $role_id==20 ) { ?>
                <div class="row">
                    <hr class="visible-xs no-grid-gutter-h">
                    <div class="pull-right col-xs-12 col-sm-auto">
                        <a style="width:100%;" class="btn btn-primary btn-labeled" href="<?= base_url('Project/timetable') ?>">
                            <span class="btn-label icon fa fa-plus"></span>Add Time table
                        </a>
                    </div>
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
						<?php } ?>
            </div>
        </div>

        <div class="row "><div class="col-sm-12">&nbsp;</div></div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9" style="color:green;float:left;font-weight:900;">
                                <?php if ($this->session->flashdata('Tmessage') != ''): ?>
                                    <?= $this->session->flashdata('Tmessage'); ?>
                                <?php endif; ?>
                            </div>
                            <?php if ($this->session->flashdata('dup_msg') != ''): ?>
                                <div class="col-sm-9" style="color:red;float:left;font-weight:900;">
                                    <?= $this->session->flashdata('dup_msg'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <form name="searchPTT" id="forms" method="POST" action="<?= base_url('Project/ptlist') ?>">
                                <div class="form-group">
                                    <div class="col-sm-2">
									
                                        <select name="academic_year" id="academic_year" class="form-control" required>
                                            <option value="">Select Academic Year</option>
                                            <?php
                                            $sel_year = ACADEMIC_YEAR;
                                            foreach ($academic_years as $yr) {
                                                $y = $yr['academic_year'];
                                                $sel = ($y == $sel_year) ? "selected" : "";
                                                echo '<option value="'.$y.'" '.$sel.'>'.$y.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <select name="project_id" id="project_id" class="form-control">
                                            <option value="">All Projects</option>
                                            <?php
                                            $pid = $sel_project ?? '';
                                            foreach (($projects ?? []) as $p) {
                                                $sel = ($p['id'] == $pid) ? 'selected' : '';
                                                $label = htmlspecialchars($p['project_title'].' - '.$p['domain']);
                                                echo "<option value=\"{$p['id']}\" $sel>$label</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-2">
                                        <input type="submit" class="btn btn-primary" value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /panel-heading -->

                    <div class="panel-body">
                        <div class="table-info table-responsive">
                            <table class="table table-bordered" width="100%" id="search-table">
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
                                <tbody id="itemContainer">
                                    <?php
                                    $j=1;
                                    if (!empty($rows)) {
                                        foreach ($rows as $r) {
                                    ?>
                                    <tr <?= ($r["status"]=="N"?"style='background-color:#FBEFF2'":"")?>>
                                        <td><?= $j ?></td>
                                        <td><?= htmlspecialchars($r['academic_year']) ?></td>
                                        <td><?= htmlspecialchars(($r['project_title'] ?? '').' - '.($r['domain'] ?? '')) ?></td>
                                        <td><?= htmlspecialchars($r['wday']) ?></td>
                                        <td><?= htmlspecialchars(($r['from_time'] ?? '').' - '.($r['to_time'] ?? '').' '.($r['slot_am_pm'] ?? '')) ?></td>
                                        <!--<td><?= htmlspecialchars($r['building_name']) ?></td>
                                        <td><?= htmlspecialchars($r['floor_no']) ?></td>
                                        <td><?= htmlspecialchars($r['room_no']) ?></td>-->
                                        <td>
                                           
											<?php if (($r['status'] ?? 'Y') === 'Y'): ?>
											<a href="<?= base_url('Project/edit_timetable/'.$r['id']) ?>"><i class="fa fa-edit"></i></a> |
											<a href="<?= base_url('Project/delete_timetable/'.$r['id']) ?>" class="ptt" title="Delete">
											<i class="fa fa-trash-o"></i>
											</a>
											<?php else: ?>
											<span class="label label-default">Deleted</span> |
											<a href="<?= base_url('Project/restore_timetable/'.$r['id']) ?>" class="ptr" title="Restore">
											<i class="fa fa-undo"></i>
											</a>
											<?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                            $j++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='9'>No data found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <div>
                                <b>NOTE:</b>
                                <ul>
                                    <li>You can update only Project Slot, Week Day.</li>
                                    <li>After updating or adding any records, kindly verify allocations.</li>
                                </ul>
                            </div>
                        </div><!-- /table-info -->
                    </div><!-- /panel-body -->
                </div><!-- /panel -->
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<script>
$(function(){
    // DataTable with export buttons (columns 0..7 exported)
 $('#search-table').DataTable({
    dom: 'Bfrtip',
    paging: false,
    buttons: [
      {
        extend: 'excelHtml5',
        title: 'Project Timetable',
        exportOptions: { columns: ':visible' }
      },
      {
        extend: 'pdfHtml5',
        title: 'Project Timetable',
        orientation: 'landscape',
        pageSize: 'A4',
        exportOptions: { columns: ':visible' }
      }
    ]
  });

    // Delete confirm
    $('.ptt').on('click', function(){
        var ok = confirm('Are you sure you want to delete this?');
        if(!ok){ return false; }
    });

    // Academic year -> projects cascade
    $('#academic_yeardd').on('change', function () {
        var y = $(this).val();
        var $sel = $('#project_id');
        $sel.html('<option value="">Loading...</option>');
        if (y) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url('Project/load_projects_for_list') ?>',
                data: {academic_year: y},
                success: function (html) { $sel.html(html); },
                error: function(){ $sel.html('<option value="">All Projects</option>'); }
            });
        } else {
            $sel.html('<option value="">All Projects</option>');
        }
    });
});
</script>
<script>
var base_url = '<?= base_url() ?>';

$('#academic_year').on('change', function () {
  var y = $(this).val();
  var $sel = $('#project_id');

  $sel.html('<option value="">Loading...</option>');

  if (!y) {
    $sel.html('<option value="">Select Project</option>');
    return;
  }

  $.ajax({
    type: 'POST',
    url: base_url + 'Project/load_projects',
    data: {academic_year: y},
    success: function (html) {
      $sel.html(html); // expects <option>...</option> list
    },
    error: function () {
      $sel.html('<option value="">Select Project</option>');
    }
  });
});
</script>