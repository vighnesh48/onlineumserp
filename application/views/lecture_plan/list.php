<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style>
	/* Faculty cell styling */
	.faculty-cell {
		background-color: #f4f6f9;
		font-weight: bold;
		vertical-align: middle;
	}

	/* Subject cell styling */
	.subject-cell {
		background-color: #e8f5e9;
		font-weight: 600;
		vertical-align: middle;
	}

	/* Topic cell styling */
	.topic-cell {
		background-color: #fff3e0;
		font-style: italic;
		vertical-align: middle;
	}
</style>


<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Lecture Plan</a></li>
    </ul>

    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Lecture Plan 
            </h1>
            <span id="err_msg" style="color:red;"></span>
			
			<div class="pull-right col-xs-4 col-sm-auto">
			
				<a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url('lecture_plan/add/'.$subject_id.'/'.$faculty_id.'/'.$campus_id.'/'.$subdetails)?>"><span class="btn-label icon fa fa-plus"></span>Add</a>
			</div>

			<span id="flash-messages" style="color:Green;">
				<?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?>
			</span>
			<span id="flash-messages" style="color:red;">
				<?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?>
			</span>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"><b>List</b></span>
						<?php //if (!$has_attendance): ?>
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#importModal">
						Import Lesson Plan
					</button>
					<a href="<?= base_url('lecture_plan/delete_course_plan/'.$subject_id.'/'.$faculty_id.'/'.$campus_id.'/'.$subdetails) ?>" class="btn btn-danger right" onclick="return confirm('Delete this?')">
						Delete complete course plan
					</a>
					<?php// else: ?>
						<!--span class="text-muted">Attendance Exists</span-->
					<?php //endif; ?>
					<a href="<?= base_url('lecture_plan/download_lecture_plan_pdf/'.$faculty_id.'/'.$subject_id.'/'.$campus_id.'/'.$subdetails) ?>" class="btn btn-success">
						Download Lecture Plan (PDF)
					</a>

                    </div>

                    <div id="show_list" class="panel-body" >
                        <div class="table-info">                               

						<table border="1" width="100%" class="table table-bordered">
							<thead>
								<tr>
									<th>ID</th>
									<th>Faculty Name</th>
									<th>Subject</th>
									<th>Topic</th>
									<th>Subtopic</th>
									<th>Planned Date</th>
									<th>Date of completion</th>
									<th>CO</th>
									<th>Learning Methodology</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$facultyGrouped = [];
							foreach ($plans as $plan) {
								$facultyGrouped[$plan->fname.' '.$plan->lname][$plan->subject_name][$plan->topic_order . ' ' . $plan->topic_title][] = $plan;
							}

							foreach ($facultyGrouped as $faculty => $subjects):
								$facultyRowspan = 0;
								foreach ($subjects as $topics) {
									foreach ($topics as $rows) {
										$facultyRowspan += count($rows);
									}
								}
								$firstFaculty = true;

								foreach ($subjects as $subject => $topics):
									$subjectRowspan = 0;
									foreach ($topics as $rows) {
										$subjectRowspan += count($rows);
									}
									$firstSubject = true;

									foreach ($topics as $topic => $rows):
										$topicRowspan = count($rows);
										$firstTopic = true;

										foreach ($rows as $plan): ?>
											<tr>
												<td><?= $plan->plan_id ?></td>

												<?php if ($firstFaculty): ?>
													<td rowspan="<?= $facultyRowspan ?>" class="faculty-cell"><?= $faculty ?></td>
												<?php endif; ?>

												<?php if ($firstSubject): ?>
													<td rowspan="<?= $subjectRowspan ?>" class="subject-cell"><?= $subject ?></td>
												<?php endif; ?>

												<?php if ($firstTopic): ?>
													<td rowspan="<?= $topicRowspan ?>" class="topic-cell"><?= $topic ?></td>
												<?php endif; ?>

												<td><?= $plan->srno ?> <?= $plan->subtopic_title ?></td>
												<td><?= $plan->planned_date ?></td>
												<td><?= $plan->date_of_completion ?></td>
												<td><?= $plan->course_outcome ?></td>
												<td><?= $plan->teaching_methodology ?></td>
												<td>
													<a href="<?= site_url("lecture_plan/edit/$plan->plan_id/$subdetails") ?>">Edit</a> |
													<a href="<?= site_url("lecture_plan/delete/$plan->plan_id") ?>" onclick="return confirm('Delete this?')">Delete</a>
												</td>
											</tr>
										<?php
										$firstFaculty = false;
										$firstSubject = false;
										$firstTopic   = false;
										endforeach;
									endforeach;
								endforeach;
							endforeach;
							?>
							</tbody>
						</table>



                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<!-- 🧾 Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel">
  <div class="modal-dialog" role="document">
    <form method="post" enctype="multipart/form-data" action="<?= base_url('lecture_plan/import_lesson_plan/' . $faculty_id . '/' . $subject_id . '/' . $campus_id.'/'.$subdetails) ?>">
      <div class="modal-content">
        <div class="modal-header">
		<h4>✅ Steps for Uploading Lecture Plan</h4>
    <ul>
        <li>
            <strong>Download the Sample Format</strong><br>
            Click on the <span class="highlight">“Download Sample”</span> button to get the Excel template.<br>
            Do not modify the structure or column headers.
        </li>
        <li>
            <strong>Set the First Column (Planned Date) as Text</strong><br>
            Format the first column <span class="highlight">(Planned Dates)</span> as <strong>Text</strong> in Excel.<br>
            This ensures dates are not auto-converted or reformatted.
        </li>
        <li>
            <strong>No Need to Modify Topic Details</strong><br>
            You do <strong>not</strong> need to update these columns:<br>
            <span class="highlight">Topic Order, Topic Title, Sr. No., Subtopic Title (Optional)</span>
        </li>
        <li>
            <strong>Update the Following Columns</strong><br>
            Fill in the required lecture plan details:<br>
            <ul>
                <li><span class="highlight">Planned Duration (Hrs)</span></li>
                <li><span class="highlight">Planned Duration (Min)</span></li>
                <li><span class="highlight">Lecture Mode</span> (e.g., Offline / Online)</li>
                <li><span class="highlight">Course Outcome</span></li>
                <li><span class="highlight">Learning Outcome</span></li>
                <li><span class="highlight">Teaching Methodology</span></li>
                <li><span class="highlight">Remarks</span> (Optional)</li>
            </ul>
        </li>
        <li>
            <strong>Upload the Completed Excel File</strong><br>
            After filling in the necessary details, upload the file using the <span class="highlight">Upload</span> button.<br>
            The system will validate your entries before saving.
        </li>
    </ul>
          <h4 class="modal-title" id="importModalLabel">Import Lesson Plan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Choose Excel File</label>
            <input type="file" name="excel_file" accept=".xlsx,.xls" required class="form-control">
          </div>

          <div class="form-group">
            <a href="<?= base_url('lecture_plan/download_sample_format/' . $subject_id) ?>" class="btn btn-info">
				Download Sample Format
			</a>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Import</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>