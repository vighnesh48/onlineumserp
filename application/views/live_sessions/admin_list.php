<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Session List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-8 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;  Create Session (create Calendar event & Meet)</h1>
            <div class="col-xs-12 col-sm-4">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
					<a href="https://onlineerp.sandipuniversity.com/live_session/create_with_subject" class="btn btn-primary" target="_blank">
    create
</a>
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
                            <span class="panel-title" id="stdname">Existing Sessions List : 
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
							
							
							
							
<table class="table table-bordered">
							<thead>
								 <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Title</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Faculty</th>
                    <th>Status</th>
                    <th>Meet</th>
                </tr>
								</thead>
								<tbody id="studtbl">
								  <?php $i = 1; foreach ($sessions as $s): 
                    // normalize fields for start/end
                    $start_raw = isset($s->start) ? $s->start : (isset($s->start_time) ? $s->start_time : null);
                    $end_raw   = isset($s->end) ? $s->end : (isset($s->end_time) ? $s->end_time : null);

                    $start_display = $start_raw ? date('d-M-Y H:i', strtotime($start_raw)) : '-';
                    $end_display   = $end_raw ? date('d-M-Y H:i', strtotime($end_raw)) : '-';

                    // compute completed state: either status=='completed' or end_time passed (with optional grace)
                    $grace_seconds = 60; // change if you want extra grace
                    $is_completed = false;
                    if (isset($s->status) && $s->status === 'completed') $is_completed = true;
                    else if ($end_raw && (time() > (strtotime($end_raw) + $grace_seconds))) $is_completed = true;

                    // subject label
                    $subject_label = !empty($s->subject_code) ? ($s->subject_code . ' - ') : '';
                    $subject_label .= !empty($s->subject_name) ? $s->subject_name : '';

                    // faculty label (if you have faculty name)
                    $faculty_label = isset($s->faculty_name) ? $s->faculty_name : (isset($s->faculty_id) ? 'ID:'.$s->faculty_id : '-');

                    // meet link
                    $meet = !empty($s->meet_link) ? $s->meet_link : null;
                ?>
                <tr id="session_<?php echo $s->id; ?>">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo htmlspecialchars($subject_label); ?></td>
                    <td><?php echo htmlspecialchars($s->title); ?></td>
                    <td><?php echo $start_display; ?></td>
                    <td><?php echo $end_display; ?></td>
                    <td><?php echo htmlspecialchars($faculty_label); ?></td>
                    <td>
                        <?php if ($is_completed): ?>
                            <span class="badge badge-completed">Completed</span>
                        <?php else: ?>
                            <span class="badge badge-scheduled">Scheduled</span>
                        <?php endif; ?>
                    </td>
                    <td class="action-row">
                        <?php if ($is_completed): ?>
                            <button class="btn btn-disabled" disabled title="This session is completed">Open Meet</button>
                        <?php else: ?>
                            <?php if ($meet): ?>
                                <a class="btn btn-open" href="<?php echo htmlspecialchars($meet); ?>" target="_blank" rel="noopener">Open Meet</a>
                            <?php else: ?>
                                <span class="small muted">No meet link</span>
                            <?php endif; ?>
                        <?php endif; ?>

                        <!-- optional: admin force-complete button for testing -->
                        <?php if ($this->session->userdata('is_admin')): ?>
                            <button class="btn force-complete" data-id="<?php echo $s->id; ?>" title="Force mark completed">Force Complete</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
								</tbody>
							</table>
							<!--div>
								<ul> <i>Note:-</i>
									
									<li> Please enter the CIA marks in between <b>0 to Max Marks</b> and Attendance percentage between <b>80</b> to <b>100 only</b>.</li>
									<li> For Absent entries of CIA or Attendance, Please enter <b>AB</b> (Capital AB).</li>
									<li> Enter the Date as  Submission date.</li>
									<li> For any corrections of marks Click on  <b>Update</b> button for saving changes.</li>
									<li> For submission of Mark-sheet to the Dean/HOD Dept Click on <b>Forward to Dean/HOD </b>button. After this <b>PDF download </b>option will be available.</li>
									<li> No any updation are allowed after submission of marks to the Dean/HOD Dept</li>
								</ul>
								
							</div-->
						</div>
                    </div>
                </div>
			</div>
			<!--/form-->		
		</div>
			
    </div>
</div>							

