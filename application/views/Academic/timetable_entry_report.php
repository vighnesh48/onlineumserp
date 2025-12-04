<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
		"pageLength": 50,
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Time Table Entry Status'
            }
        ]
    } );
} );
</script>
<style>
.absent_bg{background:#ff9b9b;}
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Time-table</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Time-table Entry Report</h1>
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
                            <span class="panel-title">Select Following Parameters</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                            <form id="form" name="form" action="<?=base_url($currentModule.'/timetable_entry')?>" method="POST">                                                               
                                <input type="hidden" value="<?=isset($subdet[0]['sub_id']) ? $subdet[0]['sub_id'] : ''?>" id="sub_id" name="sub_id" />
								<div class="form-group">
								<div class="col-sm-2" >
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
									foreach ($all_session as $yr) {
										if ($yr['academic_year'].'~'.$yr['academic_session'] == $academic_year) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session'].'"' . $sel . '>' . $yr['academic_year'].' ('.$yr['academic_session'] . ')</option>';
									}
									?>
									<!--option value="2022-23~SUMMER" <?php if($_REQUEST['academic_year']=="2021-22~SUMMER"){ echo "selected";}?>>2022-23 (SUMMER)</option-->
									
									<!--option value="2019-20~SUMMER" <?php if($_REQUEST['academic_year']=="2019-20~SUMMER"){ echo "selected";}?>>2019-20 (SUMMER)</option>

									<option value="2019-20~WINTER" <?php if($_REQUEST['academic_year']=="2019-20~WINTER"){ echo "selected";}?>>2019-20 (WINTER)</option>
									<option value="2018-19~SUMMER" <?php if($_REQUEST['academic_year']=="2018-19~SUMMER"){ echo "selected";}?>>2018-19 (SUMMER)</option-->
                               </select>
                              </div>
								                              
								<div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Search</button> </div>
                            </div>
							</form>
                        </div>
                    </div>
                </div>

            </div>    
        </div>
		  <div class="row ">
			<!--form id="form" name="form" action="<?=base_url($currentModule.'/markAttendance')?>" method="POST"-->    
            <div class="col-sm-12">

                    <div class="panel-body">
						<div class="col-sm-12">
                        <div class="table-info">  
							<div class=""> 
																
							</div>
							<table class="table table-bordered" id="example">
							<thead>
								<tr>	
									<th>S.No</th>
									<th>Stream Name</th>
									<th>Semester</th>
									<th>Status</th>
								</tr>
								</thead>
								<tbody id="studtbl">
								<?php
								
								//echo "<pre>";
								//print_r($subject);
								$first_yr_streams= array('5','6','7','8','10','11','96','97','107','108','109');
								$diploma_stream=array('71');
								$subjectname ="";
								$i=1;
									if(!empty($ttentry)){
										foreach($ttentry as $tt){
											if($tt['entry_status']=='Not done'){
												$stle="color:red";
											}else{
												$stle="";
											}
											if($tt['current_semester']=='1' && in_array($tt['admission_stream'],$first_yr_streams)){
												echo "";
											}
										/*	else if($tt['current_semester']=='2' && in_array($tt['admission_stream'],$diploma_stream))
											{
												?>
													<tr style="<?=$stle?>">
														<td><?=$i?></td>
														<td><?=$tt['stream_name']?></td>
														<td><?=$tt['current_semester']?></td>
														<td><?=$tt['entry_status'];?></td>
														
													</tr>
															<?php
												$i++;	

											}*/
											else if($tt['current_semester']=='2' && !in_array($tt['admission_stream'],$diploma_stream))
											{
												echo "";
											}

											else{
												
												?>
													<tr style="<?=$stle?>">
														<td><?=$i?></td>
														<td><?=$tt['stream_name']?></td>
														<td><?=$tt['current_semester']?></td>
														<td><?=$tt['entry_status'];?></td>
														
													</tr>
															<?php
												$i++;											
														
														}
										}
													}else{
														echo "<tr><td colspan=4>No data found.</td></tr>";
													}
												?>
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