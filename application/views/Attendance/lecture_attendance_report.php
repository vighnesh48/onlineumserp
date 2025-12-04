<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<?php// print_r($all_emp_basicsal);?>
<style>
.view-btn{padding:0px;}
.view-btn i{padding: 3px 0;list-style:none;width:35px;text-align: center;color:#fff;background:#4bb1d0;xpadding: 5px 10px;margin:2px;}
.view-btn i a{color:#fff;font-weight:bold;}
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Attendance</a></li>
        <li class="active"><a href="#">Lecture Attendance</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Lecture Attendance Report</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                     <div class="visible-xs clearfix form-group-margin"></div>
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
                   <h4><b>Lecture Attendance Report</b></h4>    
                </div>
                <div class="panel-body" style="height: 1000px;overflow-y: scroll;">
                    <div class="table-info" style="width:100% !important;"> 
                    <div class="col-md-2 ">
                            <a href="<?=base_url($currentModule.'/generateLectureAttendanceExcel')?>" ><button type="button" class="btn btn-primary form-control" >Excel
                                    </button></a>     
                                    </div>   
									<div class="col-md-2 "> <a href="<?=base_url($currentModule.'/lecture_attendance_report')?>/PDF" ><button type="button" class="btn btn-primary form-control" >PDF
                                    </button></a>    
                                    </div> 
									
                                    <div class="col-md-2 "> <a href="<?=base_url($currentModule.'/lecture_attendance_report')?>/mail" ><button type="button" class="btn btn-primary form-control" >Mail
                                    </button></a>    
                                    </div>
                                    <br/>               					
                    <br/>								
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    <table class="table table-bordered" style="width:100% !important;">
                        <thead>
                            <tr>
								<th rowspan="2">#</th>
								<th rowspan="3">School</th>
								<th rowspan="3">Program Name</th>
								<th colspan="3">I Sem</th>
								<th colspan="3">III Sem</th>
								<th colspan="3">V Sem</th>
								<th colspan="3">VII Sem</th>
								<th colspan="3">IX Sem</th>
								<th rowspan="3">Avg</th>
							</tr>
							<tr>
								<th>Total</th>
								<th>RR</th>
								<th>Present</th>
								<th>Total</th>
								<th>RR</th>
								<th>Present</th>
								<th>Total</th>
								<th>RR</th>
								<th>Present</th>
								<th>Total</th>
								<th>RR</th>
								<th>Present</th>
								<th>Total</th>
								<th>RR</th>
								<th>Present</th>
							</tr>
                        </thead>
                        <tbody id="itemContainer">
                              <?php
								if (!empty($stud_data)) {
									$j = 1;$previous_school='';
									$organized_data = [];

									// Organize data by stream_name and semester
									foreach ($re_stud_data as $row) {
										$organized_data[$row['stream_name']][$row['school']][$row['semester']] = [
											'stud_count' => $row['stud_count'],
											'present_count' => $row['present_count'],
											'present_percentage' => $row['present_percentage'],
											'rereg_stud_count' => $row['rereg_stud_count']
										];
									}

									// Display organized data
									foreach ($organized_data as $stream_name => $schools) {
                                      foreach ($schools as $school => $semesters) {
										$sem1_rereg = isset($semesters[1]) ? $semesters[1]['rereg_stud_count'] : '-';
										$sem1_total = isset($semesters[1]) ? $semesters[1]['stud_count'] : '-';
										$sem1_present = isset($semesters[1]) ? $semesters[1]['present_count'] : '-';
										
										$sem3_rereg = isset($semesters[3]) ? $semesters[3]['rereg_stud_count'] : '-';
										$sem3_total = isset($semesters[3]) ? $semesters[3]['stud_count'] : '-';
										$sem3_present = isset($semesters[3]) ? $semesters[3]['present_count'] : '-';
										
										$sem5_rereg = isset($semesters[5]) ? $semesters[5]['rereg_stud_count'] : '-';
										$sem5_total = isset($semesters[5]) ? $semesters[5]['stud_count'] : '-';
										$sem5_present = isset($semesters[5]) ? $semesters[5]['present_count'] : '-';
										
										$sem7_rereg = isset($semesters[7]) ? $semesters[7]['rereg_stud_count'] : '-';
										$sem7_total = isset($semesters[7]) ? $semesters[7]['stud_count'] : '-';
										$sem7_present = isset($semesters[7]) ? $semesters[7]['present_count'] : '-';
										
										$sem9_rereg = isset($semesters[9]) ? $semesters[9]['rereg_stud_count'] : '-';
										$sem9_total = isset($semesters[9]) ? $semesters[9]['stud_count'] : '-';
										$sem9_present = isset($semesters[9]) ? $semesters[9]['present_count'] : '-';

										// Calculate average percentage, only including existing semesters
										$total_percentage = 0;
										$count = 0;
										foreach ([$semesters[1]['present_percentage'] ?? 0, $semesters[3]['present_percentage'] ?? 0, $semesters[5]['present_percentage'] ?? 0, $semesters[7]['present_percentage'] ?? 0, $semesters[9]['present_percentage'] ?? 0] as $percentage) {
											if ($percentage !== 0) {
												$total_percentage += $percentage;
												$count++;
											}
										}
										$avg_percentage = ($count > 0) ? round($total_percentage / $count, 2) : '-'; ?>						
                                 <tr>
                                
								  <?php 
									 if ($school !== $previous_school) {
									echo  '<td>'.$j.'</td> ';
									echo  '<td>'.$school.'</td>'; 
										$previous_school = $school;$j++;
									}  else
									{
										echo '<td></td>';
										echo '<td></td>';
									}
									?>
								</td> 
                                <td><?=$stream_name?></td>
                                <td><?=$sem1_total?></td>
                                <td><?=$sem1_total?></td> 
                                <td><?=$sem1_present?></td> 
								<td><?=$sem3_rereg?></td>
                                <td><?=$sem3_total?></td> 
                                <td><?=$sem3_present?></td> 
								<td><?=$sem5_rereg?></td>
                                <td><?=$sem5_total?></td> 
                                <td><?=$sem5_present?></td> 
								<td><?=$sem7_rereg?></td>
                                <td><?=$sem7_total?></td> 
                                <td><?=$sem7_present?></td> 
								<td><?=$sem9_rereg?></td>
                                <td><?=$sem9_total?></td> 
                                <td><?=$sem9_present?></td> 
                                <td><?=$avg_percentage?></td>  
                             </tr>
								<?php }}}else{
								echo"<tr><td colspan='14'><label style='color:red'> No Record Found !!!!</label></td></tr>";
							}
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
