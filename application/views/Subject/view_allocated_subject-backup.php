
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Subject Allocation </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Subject Allocation</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
		  <div class="row ">
			<form id="form" name="form" action="<?=base_url($currentModule.'/assign_subToStudent')?>" method="POST">    

			<div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title">Subject List</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">  
						<div class="table-responsive">
						<table class="table table-bordered">
    					<tr>
    					  <th width="25%">PRN No :</th><td><?=$emp[0]['enrollment_no']?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name :</th><td><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></td>
						</tr>
						<tr>
    					  <th scope="col">Course Name :</th><td><?=$emp[0]['stream_name']?></td>
    					</tr>
						</table>
						</div>
							<div class="row">
						<ul class="nav nav-tabs">
						<?php
							$k=1;
							if(!empty($sems)){
								foreach($sems as $sem){
							//echo $sem['semester'];exit;
							if($emp[0]['current_semester']==$sem['semester']){
								$act ="active";
							}else{
								$act ="";
							}
						?>
							<li class="<?=$act?>"><a data-toggle="tab" href="#sem<?=$sem['semester']?>">Semester - <?=$sem['semester']?></a></li>
							
							<?php
							$k++;
								}
							}
							?>
							
						  </ul>

						  <div class="tab-content">
						  <?php
							$k=1;
							$CI =& get_instance();
							$CI->load->model('Subject_allocation_model');
							if(!empty($sems)){
								foreach($sems as $sem){
								if($emp[0]['current_semester']==$sem['semester']){
								$actv ="active";
								$actv ="active";
							}else{
								$actv ="";
							}
								$sublist =$this->Subject_allocation_model->getStudAllocatedSubject($emp[0]['stud_id'], $sem['semester']);//check for attendance
						?>
	
							<div id="sem<?=$sem['semester']?>" class="tab-pane fade in <?=$actv?>">
							<div class="table-responsive">
							 <table class="table table-bordered">
							<thead>
								<tr>
									<th>Sr.No</th>
									<th>Batch</th>
									<th>Subject Code</th>
									<th>Subject Name</th>
									<th>Semester</th>
									<th>CIA marks</th>
									<?php 
									if($emp[0]['current_semester']==$sem['semester']){
										if($this->session->userdata('role_id')==2 || $this->session->userdata('role_id')==10 || $this->session->userdata('role_id')==20){
									?>
									<th>Remove</th>
										<?php }}?>
									
								</tr>
							</thead>
							<tbody>
								<?php
								$i=1;
									if(!empty($sublist)){
										foreach($sublist as $sub){
								?>
								<tr>
									<td><?=$i;?></td>
									<td><?=$sub['batch']?></td>
									<td><?=$sub['subject_code']?></td>
									<td><?=$sub['subject_name']?></td>
									<td><?=$sub['semester']?></td>
									<td><?=$sub['cia_marks']?></td>
									<?php 
									if($emp[0]['current_semesterorg']==$sem['semester']){
										if($this->session->userdata('role_id')==10 || $this->session->userdata('role_id')==20){
									?>
									<td><a href="<?=base_url()?>Subject_allocation/removeSubject/<?=$sub['sub_applied_id']?>/<?=$sub['stud_id']?>" onclick="return confirm('Are you sure you want to Remove this Subject?');"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
									<?php }}?>
									
								</tr>
								<?php 
									$i++;
									}
									}else{
										echo "<tr><td colspan=5>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table>
							</div>
							<?php 
									if($emp[0]['current_semesterorg']==$sem['semester']){
									if($this->session->userdata('role_id')==10 || $this->session->userdata('role_id')==20){	
										?>
							<a href="<?=base_url()?>Subject_allocation/removeAllSubjects/<?=$sub['stud_id']?>/<?=$sem['semester']?>/<?=$emp[0]['admission_stream']?>"  onclick="return confirm('Are you sure you want to Remove All the Subject?');">Remove All</a>
									<?php }
									}?>
							</div>
						
							<?php
							$k++;
								}
							}
							?>
						  </div>
						</div>
							
						</div>
                    </div>
                </div>
			</div>
			</form>
		</div>
			
    </div>
</div>
