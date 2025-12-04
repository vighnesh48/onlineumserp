<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Syllabus</a></li>
        <li class="active"><a href="#">Edit Topic</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Edit SubTopic</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">SubTopic Details</span>
                    </div>
                    <div class="panel-body">
					<div class="table-info">
                            <?php //if(in_array("Edit", $my_privileges)) { ?>
                             <form method="post" action="">
								<div class="form-group">
									<label>Subtopic Title</label>
									<textarea name="subtopic_title" class="form-control" required><?= $subtopic['subtopic_title'] ?></textarea>
								</div>

								<div class="form-group">
									<label>Order No.</label>
									<input type="number" name="subtopic_order" class="form-control" value="<?= $subtopic['subtopic_order'] ?>" required>
								</div>

								<div class="form-group">
									<label>Course Outcome (CO)</label>
									<input type="text" name="cos" class="form-control" value="<?= $subtopic['cos'] ?>" required>
								</div>

								<div class="form-group">
									<label>Hours</label>
									<input type="number" name="shours" class="form-control" value="<?= $subtopic['shours'] ?>" required>
								</div>

								<div class="form-group">
									<label>Minutes</label>
									<input type="number" name="sminutes" class="form-control" value="<?= $subtopic['sminutes'] ?>" required>
								</div>

								<button type="submit" class="btn btn-success">Update Subtopic</button>
								<a href="<?= base_url('SyllabusController/index/' . $subject_id.'/'.$campus_id) ?>" class="btn btn-secondary">Cancel</a>
							</form>
                            <?php //} ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
					
