<style>
        body { font-family: Arial; padding: 20px; }
        .form-box { width: 600px; padding: 20px; border: 1px solid #ccc; border-radius: 6px; }
        .form-box h2 { margin-top: 0; }
        .row { margin-bottom: 12px; }
        .row label { display: block; font-weight: bold; margin-bottom: 5px; }
        .row input, .row select { width: 100%; padding: 6px; }
        .btn { padding: 10px 14px; background: #0b5ed7; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #084298; }
        .alert { padding: 10px; margin-bottom: 10px; border-radius: 4px; }
        .alert-success { background: #e7f7e2; border: 1px solid #b6e4a3; }
        .alert-error { background: #fde4e4; border: 1px solid #f5bdbd; }
    </style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Subject List</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-8 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;  Faculty Allocated Subject List </h1>
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
                            <span class="panel-title" id="stdname">Faculty Allocated Subject List : 
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
<div class="form-box">

    <h2>Create Live Session (Faculty Subjects)</h2>

    <?php if ($this->session->flashdata('message')): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-error"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <form method="post" action="<?php echo site_url('live_session/create_with_subject'); ?>">

        <!-- TITLE -->
        <div class="row">
            <label>Session Title</label>
            <input type="text" name="title" value="Live Class">
        </div>

        <!-- SUBJECT DROPDOWN -->
        <div class="row">
            <label>Select Subject (Allocated to You)</label>
            <select name="subject_id" required>
                <option value="">-- Select Subject --</option>

                <?php if (!empty($subjects)): ?>
                    <?php foreach ($subjects as $sub): ?>

                        <?php
                            // Build label: e.g.
                            // "MTH101 - Engineering Mathematics [Course 3, Stream 2, Sem 1]"
                            $label = "";

                            if (!empty($sub->subject_code)) {
                                $label .= $sub->subject_code . " - ";
                            }

                            $label .= $sub->subject_name;

                            $extra = [];
                            if (!empty($sub->course_id))  $extra[] = "Course ".$sub->course_id;
                            if (!empty($sub->stream_id))  $extra[] = "Stream ".$sub->stream_id;
                            if (!empty($sub->semester))   $extra[] = "Sem ".$sub->semester;

                            if (!empty($extra)) {
                                $label .= " [" . implode(", ", $extra) . "]";
                            }
                        ?>

                        <option value="<?php echo $sub->sub_id; ?>">
                            <?php echo htmlspecialchars($label); ?>
                        </option>

                    <?php endforeach; ?>

                <?php else: ?>
                    <option value="">No subjects allocated to you.</option>
                <?php endif; ?>

            </select>
        </div>

        <!-- START TIME -->
        <div class="row">
            <label>Start Time (Y-m-d H:i:s)</label>
            <input type="text" name="start" value="<?php echo date('Y-m-d H:i:s'); ?>">
        </div>

        <!-- END TIME -->
        <div class="row">
            <label>End Time (Y-m-d H:i:s)</label>
            <input type="text" name="end" value="<?php echo date('Y-m-d H:i:s', strtotime('+1 hour')); ?>">
        </div>

        <div class="row">
            <button type="submit" class="btn">Create Session & Generate Meet Link</button>
        </div>

    </form>

    <br>
    <a href="<?php echo site_url('live_session/admin_list'); ?>">← Back to Session List</a>

</div>

</body>
</html>
