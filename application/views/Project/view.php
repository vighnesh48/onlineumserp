<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap.min.css">

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap.min.js"></script>

<!-- Buttons + Excel dependency -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<style>
  .dt-buttons { margin-bottom: 10px; float: right; }
</style>
<?php //print_r($my_privileges); die; ?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
         <li class="active"><a href="<?=base_url($currentModule)?>">Projects</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Projects</h1>
			
			<div class="col-xs-12 col-sm-8 ">
                <div class="row"> 
					   <hr class="visible-xs no-grid-gutter-h">
                    <!--<div class="pull-right col-xs-12 col-sm-auto" style="margin: 10px;"><a style="width: 100%; " class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/upload_project_details")?>"><span class="btn-label icon fa fa-upload"></span>Upload</a></div>  --> 
<?php $role=$this->session->userdata("role_id") ;
if($role==10 || $role==20) {


?>
				<!--<div class="pull-right col-xs-12 col-sm-auto" style="margin: 10px;"><a style="width: 100%; " class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/timetable")?>"><span class="btn-label icon fa fa-upload"></span>Add Timetable</a></div>	
                <div class="pull-right col-xs-12 col-sm-auto" style="margin: 10px;"><a style="width: 100%; " class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/allocate_students")?>"><span class="btn-label icon fa fa-upload"></span>Allocate Students</a></div>	    -->           	
 				<div class="pull-right col-xs-12 col-sm-auto" style="margin: 10px;"><a style="width: 100%; " class="btn btn-primary btn-labeled" href="<?=base_url($currentModule."/add_project_details")?>"><span class="btn-label icon fa fa-upload"></span>Add Projects</a></div>
<?php } ?>				
                    <div class="visible-xs clearfix form-group-margin"></div>
                </div>
            </div>
			
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message_event_success'))){ echo $this->session->flashdata('message_project_success'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message_event_error'))){ echo $this->session->flashdata('message_project_error'); } ?></span>

        </div>
       <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        	
                        <span class="panel-title">
                        <?php
						$role_id = $this->session->userdata('role_id');
						if($role_id==1 || $role_id==53 ) { ?>
						
                        <form name="searchTT" id="forms" method="POST" action="<?=base_url()?>project" >
						<div class="form-group">
						<div class="col-md-2">
          
            <select name="academic_year" class="form-control form-control-sm" required>
                <option value="">Select</option>
             <?php
      // $academic_year is an array like: [ ['academic_year'=>'2025-26'], ... ]
      foreach ($academic_year as $ay) {
          $ayv = $ay['academic_year'];
          $sel = ($ayv === ($acad ?? '')) ? 'selected' : '';
          echo "<option value=\"{$ayv}\" {$sel}>{$ayv}</option>";
      }
      ?>
            </select>
        </div>
						
						
					<div class="col-md-2">
					<select name="school" class="form-control" id="school_select" >
					<option value="">All Schools</option>
					<?php foreach ($school_list as $s): ?>
        <option value="<?= $s['school_code']; ?>"
          <?= (($school ?? '') === $s['school_code']) ? 'selected' : ''; ?>>
          <?= $s['school_short_name']; ?>
        </option>
      <?php endforeach; ?>
					</select>
					</div>
					
					
					<div class="col-md-3">
  <select name="stream_id" id="department_select" class="form-control" <?= empty($school) ? 'disabled' : '' ?>>
    <option value="">Select Department</option>
    <?php if (!empty($departments)): 
        $preSel = (string)($selected_stream_id ?? '');
        foreach ($departments as $d):
          $sel = ((string)$d['stream_id'] === $preSel) ? 'selected' : '';
    ?>
      <option value="<?= $d['stream_id'] ?>" <?= $sel ?>><?= htmlspecialchars($d['stream_name']) ?></option>
    <?php endforeach; endif; ?>
  </select>
</div>
                            
							  
                              
                             
							  
								
								
								<div class="col-sm-2"><input type="submit" class="btn btn-primary form-control" value="Search"></div>
								
                            </div>
                              </form> </span>
							  
						<?php } ?>
							  
							  
                        <div class="holder"></div>
                </div>
                <div class="panel-body" style="overflow-y: auto;">
				     <div class="row ">
						<div class="col-sm-9" style="color:green;float:left;font-weight: 900;">
							<?php
							if ($this->session->flashdata('message') != ''): 
								echo $this->session->flashdata('message'); 
							endif;
							?>
						</div>
					</div>
				<div class="row">
					</div>
                      <div class="table-info" > 
                        <form method="GET" action="<?= base_url('Project/index'); ?>">
                            <div class="row">
                            <div class="col-md-1">
                                    <select name="limit" class="form-control" onchange="this.form.submit()">
                                        <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10 rows</option>
                                        <option value="25" <?= $limit == 25 ? 'selected' : '' ?>>25 rows</option>
                                        <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50 rows</option>
                                        <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100 rows</option>
                                    </select>
                                </div>
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= isset($search) ? $search : '' ?>">
                                </div>
                                
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary">Apply</button>
                                </div>
                            </div>
                        </form>   
                        <br>
                       <table id="projectsTable" class="table table-bordered">
                        <thead>
                            <tr>
                                    <th>#</th>
									<th>Academic year</th>
									<th>School</th>
									<th>Department</th>
									<th>Faculty Name</th> 
                                    <th>Project Title</th>
									<th>Domain</th>
									<th>Industry Sponsored</th>
                                    <th>Programming Language/Technology Used</th>    
                                    <th>Bloom Level</th>
                                    <th>Student Count</th>									
                                    <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php if (!empty($projects)) : ?>
                                <?php $i = 1 + (($this->uri->segment(3) ? $this->uri->segment(3) : 0)); ?>
                                <?php foreach ($projects as $project) : ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $project['academic_year'] ?></td>
										<td><?= $project['school_short_name'] ?></td>
										<td><?= $project['stream_name'] ?></td>
                                        <td><?= $project['faculty_id']."-".$project['fac_name'] ?></td>                                       
										<td><?= $project['project_title'] ?></td>
                                        <td><?= $project['domain'] ?></td>
                                        <td><?= $project['industry_sponsored'] ?></td>
										<td><?= $project['programminglanguage'] ?></td>
                                        <td><?= $project['Bl_level'] ?></td>
										<td><?= $project['student_count'] ?></td>
                                        <td>
                                            <a href="<?= base_url($currentModule . "/view_project_students/" . base64_encode($project['id'])."/".base64_encode($project['academic_year'])) ?>" title="View allocated students"><i class="fa fa-user"></i></a>
											
											 <?php if($role==10 || $role==20) { ?>
											 <a href="<?= base_url($currentModule . "/edit/" . (int)$project['id']) ?>"
       title="Edit Project">
        <i class="fa fa-pencil"></i>
    </a>
	 <a href="javascript:void(0)"
       onclick="deleteProject(<?= $project['id'] ?>, '<?= $project['academic_year'] ?>')"
       title="Delete Project" style="color:red;">
        <i class="fa fa-trash"></i>
    </a>
											 <?php }  ?>
											 
											 
											
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    No Projects found.
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        
                    </table>   
                    <div class="pagination-container text-center">
                        <?= $pagination_links ?>
                    </div>                 
                
                </div>
					
                </div>
            </div>
            </div>    
        </div>
    </div>

       <script>
$(function () {
  var acad = <?= json_encode($acad ?? ''); ?>; // if you have $acad in the view
  $('#projectsTable').DataTable({
    paging: false,       // keep your PHP pagination
    searching: false,    // keep your existing search box
    ordering: false,     // keep server-side order
    info: false,
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'excelHtml5',
        text: 'Download Excel',
        title: 'Projects_' + (acad || 'list'),
        exportOptions: {
          // export all visible columns except the last "Action" column
          columns: ':visible:not(:last-child)'
        }
      }
    ]
  });
});


</script> 
   <script>
function deleteProject(projectId, academicYear) {
    if (confirm('Are you sure you want to delete this project?')) {
        $.ajax({
            url: "<?= base_url($currentModule . '/delete_project') ?>",
            method: "POST",
            data: {
                id: projectId,
                academic_year: academicYear
            },
            dataType: "json",
            success: function (res) {
                if (res.status === 'success') {
                    alert('Project deleted successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function (xhr) {
                alert('Error deleting project: ' + xhr.statusText);
            }
        });
    }
}
</script>


<script>
var baseUrl  = '<?= base_url(); ?>';
var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

function renderDepartments(list, preset) {
  var html = '<option value="">Select Department</option>';
  if (Array.isArray(list)) {
    for (var i=0; i<list.length; i++) {
      var sel = (preset && String(preset) === String(list[i].stream_id)) ? ' selected' : '';
      html += '<option value="'+list[i].stream_id+'"'+sel+'>'+list[i].stream_name+'</option>';
    }
  }
  $('#department_select').html(html);
}

function loadDepartmentsFor(schoolCode, preset) {
  if (!schoolCode) {
    // No school → clear & disable stream
    renderDepartments([], '');
    $('#department_select').prop('disabled', true).val('');
    return;
  }
  $('#department_select').prop('disabled', true).html('<option>Loading…</option>');
  var data = { school: schoolCode }; data[csrfName] = csrfHash;

  $.post(baseUrl + 'project/load_departments', data, function(res){
    renderDepartments(res, preset || '');
    $('#department_select').prop('disabled', false);
  }, 'json').fail(function(){
    $('#department_select').html('<option value="">Failed to load</option>').prop('disabled', false);
  });
}

// When school changes
$('#school_select').on('change', function(){
  var sc = this.value;
  // Also clear current selection if school cleared
  if (!sc) { $('#department_select').val(''); }
  loadDepartmentsFor(sc, '');
});

// On initial load: only populate stream if a school is already selected
$(function(){
  var initialSchool   = $('#school_select').val() || '';
  var presetStreamId  = '<?= htmlspecialchars((string)($selected_stream_id ?? ''), ENT_QUOTES, "UTF-8"); ?>';
  if (initialSchool) {
    // If server already rendered departments, do nothing. Otherwise fetch.
    if ($('#department_select option').length <= 1) {
      loadDepartmentsFor(initialSchool, presetStreamId);
    } else {
      $('#department_select').prop('disabled', false);
    }
  } else {
    // Ensure disabled and cleared when no school
    renderDepartments([], '');
    $('#department_select').prop('disabled', true).val('');
  }
});
</script>