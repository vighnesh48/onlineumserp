<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
th, td { text-align: center; }

th:nth-child(5), td:nth-child(5) {
    background-color: #f9f9f9;  /* Max Marks */
    font-weight: 600;
}

th:nth-child(6), td:nth-child(6) {
    background-color: #fff3cd;  /* Total Students (Yellow) */
}

th:nth-child(7), td:nth-child(7) {
    background-color: #fef5d7;  /* Pending (Light Yellow) */
}

th:nth-child(8), td:nth-child(8) {
    background-color: #e7f1ff;  /* Submitted (Light Blue) */
}

th:nth-child(9), td:nth-child(9) {
    background-color: #e2f7e1;  /* Evaluated (Light Green) */
}


</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Assignments</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-8 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;  My Assignments </h1>
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
                            <span class="panel-title" id="stdname">Assignments List : 
							<?php 
							
							if($batch !=0){
								$batch_to = $batch;
							}else{
								$batch_to = "";
							}
							if(!empty($subdetails)){
								echo $subdetails[0]['subject_short_name'].'('.$subdetails[0]['subject_code'].')-'.$division.''.$batch_to;
							}
							?>
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
										<th>Title</th>
										<th>Created On</th>
										<th>Due Date</th>	
										<th>Max Marks</th>
										<th>Total Students</th>
										<th>Pending</th>
										<th>Submitted</th>
										<th>Evaluated</th>
										<th>Status</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1; foreach ($list as $r): ?>
									<tr>
										<td><?= $i++ ?></td>
										<td><?= $r->title ?></td>
										<td><?= date('d-M-Y', strtotime($r->created_at)) ?></td>
										<td><?= date('d-M-Y', strtotime($r->due_date)) ?></td>										
										<td><?= $r->max_marks ?? '-' ?></td>
										<td><?= $r->total_students ?? 0 ?></td>
										<td><?= $r->pending_count ?? 0 ?></td>
										<td><?= $r->submitted_count ?? 0 ?></td>
										<td><?= $r->evaluated_count ?? 0 ?></td>
										<td>
										<?php if ($r->is_closed == 1): ?>
											<span class="badge bg-danger" style="line-height: 1;">Closed</span>
										<?php else: ?>
											<span class="badge bg-success" style="line-height: 1;">Open</span>
										<?php endif; ?>
									</td>
									<td>
										<a class="btn btn-xs btn-info" href="<?= base_url('assignment/view/'.encrypt_id($r->id)) ?>">View</a>

										<?php if ($r->is_closed == 0): ?>
											<a class="btn btn-xs btn-warning"
											   href="<?= base_url('assignment/close_assignment/'.encrypt_id($r->id)) ?>"
											   onclick="return confirm('Are you sure you want to close this assignment? After closing, students cannot submit.');">
												Close
											</a>
										<?php else: ?>
											<a class="btn btn-xs btn-success"
											   href="<?= base_url('assignment/reopen_assignment/'.encrypt_id($r->id)) ?>"
											   onclick="return confirm('Do you want to reopen this assignment? Students will again be able to submit.');">
												Reopen
											</a>
										<?php endif; ?>
									</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>

						</div>
                    </div>
                </div>
			</div>
			<!--/form-->		
		</div>
			
    </div>
</div>

