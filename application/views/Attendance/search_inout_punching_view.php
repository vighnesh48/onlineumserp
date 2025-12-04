	 
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
	 <div class="row">  
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" id="stdname">Student List:
							</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info table-responsive">  
                            <input type="button" id="expdata" value="Export as Excel" class="btn btn-primary btn-labeled">
							<table id="example" class="table table-bordered display">
							<thead>
								<tr>
									<th data-orderable="false">S.No.</th>
									<th data-orderable="false">ROll No.</th>
									<th data-orderable="false">PRN.</th>
									<th data-orderable="false">Punching PRN.</th>
									<th data-orderable="false">Student Name</th>
									<th data-orderable="false">Mobile No.</th>
									<th data-orderable="false">Email.</th>
									<th data-orderable="false">Semester</th>
									<th data-orderable="false">Division</th>
									<th data-orderable="false">Batch</th>
									<th data-orderable="false">PunchIn</th>
									<th data-orderable="false">PunchOut</th>
								</tr>     
								</thead>
								<tbody>
								<?php				
								$i=1;
									if(!empty($batchstudents)){
										foreach($batchstudents as $stud){
										
										$division = $stud['division'];
										$batch_name = $stud['batch'];
										if($batch_name ==0){
											$batch = '';
										}else{
											$batch = $batch_name;
										}
								?>
									<tr>
										<td><?=$i?></td>
										<td><?=$stud['roll_no']?></td>
										<td><?=$stud['enrollment_no']?></td>
										<td><?=$stud['punching_prn']?></td>
										<td><?=$stud['student_name']?></td>
										<td><?=$stud['mobile']?></td>
										<td><?=$stud['email']?></td>
										<td><?=$stud['semester']?></td>
										<td><?=$division?></td>
										<td><?=$batch?></td>
										<td><?=$stud['logmin']?></td>
										<td><?=$stud['logmax']?></td>
									</tr>
								<?php
										$i++;
										}
									}else{
										echo "<tr><td colspan='11'>No Data Found</td></tr>";
									}
								?>
								</tbody>
							</table>
						</div>
                    </div>
                </div>
			</div>
		</div>
<script>
		$("#expdata").click(function(){
  $("#example").table2excel({

    exclude: ".noExl",
    name: "Worksheet Name",
  filename: "'Inout Punching Details-Div-<?=$division?>'" //do not include extension

  });
  });
		</script>