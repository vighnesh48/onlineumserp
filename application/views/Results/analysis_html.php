
                                   <?php
                                   switch($rpt['report_type']){
                                       case "1":
                                      
                                   
                                   ?>
                                    <table class="table table-bordered">
            						<thead>
            							<tr>
            								<th width="5%">#</th>
            								<th width="15%">Stream</th>
            								<th width="5%">Sem</th>
            								<th width="2%">#Appeared</th>
            								<th>P1</th>
            								<th>P2</th>
            								<th>P3</th>
            								<th>P4</th>
            								<th>P5</th>
            								<th>P6</th>
            								<th>P7</th>
            								<th>P8</th>
            								<th>P9</th>
            								<th>P10</th>
            								<th>#With held</th>
            								<th>#All Clear</th>
            								<th>Passing(%)</th>
            							</tr>
            						</thead>
            						<tbody class="valign-middle">
                                    <?php
                                    $i=1;
                                    
                                    foreach($result as $row){
                                    
                                    echo' <tr data-toggle="collapse" data-target=".order'.$i.'">
                                        <td>'.$i.' </td>
                                         <td>'.$row['stream_short_name'].'</td>
                                         <td>'.$row['semester'].'</td>
                                         <td><b>'.$row['appeared'].'</b></td>
                                         <td>'.$row['sub1'].'</td>
                                         <td>'.$row['sub2'].'</td>
                                          <td>'.$row['sub3'].'</td>
                                           <td>'.$row['sub4'].'</td>
                                            <td>'.$row['sub5'].'</td>
                                             <td>'.$row['sub6'].'</td>
                                              <td>'.$row['sub7'].'</td>
                                               <td>'.$row['sub8'].'</td>
                                                <td>'.$row['sub9'].'</td>
                                                 <td>'.$row['sub10'].'</td>
                                                  <td>'.$row['with_heald'].'</td>
                                                   <td><b>'.$row['all_clear'].'</b></td>
                                                    <td><b>'.sprintf('%.2f',round((((int)$row['all_clear']/(int)$row['appeared'])*100),2)).'</b></td></tr>';
                                         
                                        $i++;
                                    }
                                    if($i==1){
                                        echo'<tr><td colspan="15">Records not found.. </td></tr>';
                                    }
                                    ?>
                                   </tbody>
                                   </table>
                                   <?php
                                   break;
                                    case "2":
                                  
                                       
                                       ?>
                                         <table class="table table-bordered">
            						<thead>
            							<tr>
            								<th width="5%">#</th>
            								<th width="20%">Stream</th>
            								<th width="5%">Sem</th>
            								<th width="5%">Code</th>
            								<th width="20%">Name</th>
            								<th >#Appeared</th>
            								<th>#Fail</th>
            								<th>#With held</th>
            								<th>#All Clear</th>
            								<th>Passing(%)</th>
            							</tr>
            						</thead>
            						<tbody class="valign-middle">
                                    <?php
                                    $i=1;
                                    
                                    foreach($result as $row){
                                    
                                    echo' <tr data-toggle="collapse" data-target=".order'.$i.'">
                                        <td>'.$i.' </td>
                                         <td>'.$row['stream_short_name'].'</td>
                                         <td>'.$row['semester'].'</td>
                                          <td>'.$row['subject_code'].'</td>
                                           <td>'.$row['subject_name'].'</td>
                                         <td><b>'.$row['sub_total'].'</b></td>
                                         <td><b>'.$row['fail'].'</b></td>
                                         <td>'.$row['withheald'].'</td>
                                        <td><b>'.$row['pass'].'</b></td>
                                      <td><b>'.sprintf('%.2f',round((((int)$row['pass']/(int)$row['sub_total'])*100),2)).'</b></td></tr>';
                                         
                                        $i++;
                                    }
                                    
                                    if($i==1){
                                        echo'<tr><td colspan="15">Records not found.. </td></tr>';
                                    }
                                    
                                    ?>
                                   </tbody>
                                   </table>
                                   <?php
                                   
                                   break;
								   
								  case "3":
								  case "4":
                                  
                                       
                                       ?>
                                                                                    
                                        <style>
                        

                                            .report-title {
                                                text-align: center;
                                                font-size: 24px;
                                                font-weight: 700;
                                                color: #2e86c1;
                                                margin-bottom: 20px;
                                            }

                                            .school-name {
                                                font-size: 16px;
                                                font-weight: bold;
                                                margin: 10px 0 25px;
                                                color: #1f618d;
                                                background-color: #b6babb; /* Light blue highlight */
                                                padding: 10px 15px;
                                                border-left: 4px solid #2980b9; /* Optional accent line */
                                                border-radius: 4px; /* Slight rounding */
                                            }

                                            table {
                                                width: 100%;
                                                border-collapse: collapse;
                                                margin-bottom: 35px;
                                                box-shadow: 0 2px 4px rgba(46, 134, 193, 0.15);
                                            }

                                            th, td {
                                                border: 1px solid #ccd1d1;
                                                padding: 10px;
                                                font-size: 14px;
                                                text-align: center;
                                            }

                                            th {
                                                background-color: #d6eaf8;
                                                color: #1b4f72;
                                                font-weight: 600;
                                            }

                                            .stream-header {
                                                background-color: #ebf5fb;
                                                font-weight: 700;
                                                color: #21618c;
                                                text-align: left;
                                                padding-left: 10px;
                                            }

                                            .total-row td {
                                                background-color: #aed6f1;
                                                font-weight: bold;
                                                color: #154360;
                                            }

                                            tr:nth-child(even) td {
                                                background-color: #f9f9f9;
                                            }
                                        </style>


											<div class="report-title">EXAM SUMMARY REPORT</div>

											<?php
											$schools = [];
											foreach ($result as $row) {
												$original_school = $row['school_short_name'];
												$school = in_array($original_school, ['SOET', 'SOCSE']) ? 'Engineering' : $original_school;

												$semester = (int)$row['semester'];
												$stream = ($semester === 1 || $semester === 2) ? 'General First Year' : $row['stream_name'];
												$semesterKey = $semester;
												$schools[$school][$stream][$semesterKey][] = $row;
											}
											?>

											<?php foreach ($schools as $school_name => $streams): ?>
												<div class="school-name">School Name :- <?= $school_name ?></div>

												<?php
												$grand_total_applied = 0;
												$grand_total_pass = 0;
												$grand_total_fail = 0;
												$grand_th = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
												$grand_pr = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
												?>

												<?php foreach ($streams as $stream_name => $semesters): ?>
													<table border="1">
														<tr>
															<td class="stream-header" colspan="10">Stream Name:- <?= $stream_name ?></td>
														</tr>
														<tr>
															<th rowspan="2">Semester</th>
															<th colspan="2">Applied Students</th>
															<th colspan="2">Passed Students</th>
															<th colspan="2">Fail Students</th>
															<th colspan="2">Passing Percentage</th>
														</tr>
														<tr>
															<th>TH</th><th>PR</th>
															<th>TH</th><th>PR</th>
															<th>TH</th><th>PR</th>
															<th>TH</th><th>PR</th>
														</tr>

														<?php
														$total_applied = 0;
														$total_passed = 0;
														$total_failed = 0;
														$total_th = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
														$total_pr = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
														?>

														<?php foreach ($semesters as $semester => $components): ?>
															<?php
															
															$componentsData = [
																'TH' => ['appeared' => 0, 'pass' => 0, 'fail' => 0],
																'PR' => ['appeared' => 0, 'pass' => 0, 'fail' => 0],
															];

															foreach ($components as $row) {
																$comp = ($row['subject_component'] === 'EM') ? 'TH' : $row['subject_component'];
																if (!isset($componentsData[$comp])) {
																	$componentsData[$comp] = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
																}
																$componentsData[$comp]['appeared'] += $row['appeared'];
																$componentsData[$comp]['pass'] += $row['all_clear'];
																$componentsData[$comp]['fail'] += $row['fail'];
															}

															$percentTH = ($componentsData['TH']['appeared'] > 0) ? round(($componentsData['TH']['pass'] / $componentsData['TH']['appeared']) * 100, 2) : 0;
															$percentPR = ($componentsData['PR']['appeared'] > 0) ? round(($componentsData['PR']['pass'] / $componentsData['PR']['appeared']) * 100, 2) : 0;

															// Track total per stream
															$total_th['appeared'] += $componentsData['TH']['appeared'];
															$total_th['pass'] += $componentsData['TH']['pass'];
															$total_th['fail'] += $componentsData['TH']['fail'];

															$total_pr['appeared'] += $componentsData['PR']['appeared'];
															$total_pr['pass'] += $componentsData['PR']['pass'];
															$total_pr['fail'] += $componentsData['PR']['fail'];

															// Track stream-level totals
															$total_applied += $componentsData['TH']['appeared'] + $componentsData['PR']['appeared'];
															$total_passed += $componentsData['TH']['pass'] + $componentsData['PR']['pass'];
															$total_failed += $componentsData['TH']['fail'] + $componentsData['PR']['fail'];

															// Track grand totals
															$grand_total_applied += $componentsData['TH']['appeared'] + $componentsData['PR']['appeared'];
															$grand_total_pass += $componentsData['TH']['pass'] + $componentsData['PR']['pass'];
															$grand_total_fail += $componentsData['TH']['fail'] + $componentsData['PR']['fail'];

															$grand_th['appeared'] += $componentsData['TH']['appeared'];
															$grand_th['pass'] += $componentsData['TH']['pass'];
															$grand_th['fail'] += $componentsData['TH']['fail'];

															$grand_pr['appeared'] += $componentsData['PR']['appeared'];
															$grand_pr['pass'] += $componentsData['PR']['pass'];
															$grand_pr['fail'] += $componentsData['PR']['fail'];
															?>
															<tr>
																<td><?= $semester ?></td>
																<td><?= $componentsData['TH']['appeared'] ?></td>
																<td><?= $componentsData['PR']['appeared'] ?></td>
																<td><?= $componentsData['TH']['pass'] ?></td>
																<td><?= $componentsData['PR']['pass'] ?></td>
																<td><?= $componentsData['TH']['fail'] ?></td>
																<td><?= $componentsData['PR']['fail'] ?></td>
																<td><?= $percentTH ?>%</td>
																<td><?= $percentPR ?>%</td>
															</tr>
														<?php endforeach; ?>

														<?php
														$percentTH_total = ($total_th['appeared'] > 0) ? round(($total_th['pass'] / $total_th['appeared']) * 100, 2) : 0;
														$percentPR_total = ($total_pr['appeared'] > 0) ? round(($total_pr['pass'] / $total_pr['appeared']) * 100, 2) : 0;
														?>
														<tr class="total-row">
															<td><strong>Total</strong></td>
															<td><?= $total_th['appeared'] ?></td>
															<td><?= $total_pr['appeared'] ?></td>
															<td><?= $total_th['pass'] ?></td>
															<td><?= $total_pr['pass'] ?></td>
															<td><?= $total_th['fail'] ?></td>
															<td><?= $total_pr['fail'] ?></td>
															<td><?= $percentTH_total ?>%</td>
															<td><?= $percentPR_total ?>%</td>
														</tr>
													</table>
												<?php endforeach; ?>

												<?php
												$grand_percentTH = ($grand_th['appeared'] > 0) ? round(($grand_th['pass'] / $grand_th['appeared']) * 100, 2) : 0;
												$grand_percentPR = ($grand_pr['appeared'] > 0) ? round(($grand_pr['pass'] / $grand_pr['appeared']) * 100, 2) : 0;
												?>
												<table border="1">
													<tr class="total-row">
														<td colspan="1"><strong>Grand Total</strong></td>
													
														<td><?= $grand_th['appeared'] ?></td>
														<td><?= $grand_pr['appeared'] ?></td>
														<td><?= $grand_th['pass'] ?></td>
														<td><?= $grand_pr['pass'] ?></td>
														<td><?= $grand_th['fail'] ?></td>
														<td><?= $grand_pr['fail'] ?></td>
														<td><?= $grand_percentTH ?>%</td>
														<td><?= $grand_percentPR ?>%</td>
													</tr>
												</table>
												<br><br>
											<?php endforeach; ?>

                         

                                    


                                   <?php
                                   
                                   break;
                                   
            
                                  	case "5":
                                  
                                       
                                       ?>
                                                                                    
                                        <style>
                        

                                            .report-title {
                                                text-align: center;
                                                font-size: 24px;
                                                font-weight: 700;
                                                color: #2e86c1;
                                                margin-bottom: 20px;
                                            }

                                            .school-name {
                                                font-size: 16px;
                                                font-weight: bold;
                                                margin: 10px 0 25px;
                                                color: #1f618d;
                                                background-color: #b6babb; /* Light blue highlight */
                                                padding: 10px 15px;
                                                border-left: 4px solid #2980b9; /* Optional accent line */
                                                border-radius: 4px; /* Slight rounding */
                                            }

                                            table {
                                                width: 100%;
                                                border-collapse: collapse;
                                                margin-bottom: 35px;
                                                box-shadow: 0 2px 4px rgba(46, 134, 193, 0.15);
                                            }

                                            th, td {
                                                border: 1px solid #ccd1d1;
                                                padding: 10px;
                                                font-size: 14px;
                                                text-align: center;
                                            }

                                            th {
                                                background-color: #d6eaf8;
                                                color: #1b4f72;
                                                font-weight: 600;
                                            }

                                            .stream-header {
                                                background-color: #ebf5fb;
                                                font-weight: 700;
                                                color: #21618c;
                                                text-align: left;
                                                padding-left: 10px;
                                            }

                                            .total-row td {
                                                background-color: #aed6f1;
                                                font-weight: bold;
                                                color: #154360;
                                            }

                                            tr:nth-child(even) td {
                                                background-color: #f9f9f9;
                                            }
                                        </style>


											<div class="report-title">RESULT ANALYSIS REPORT</div>

											<?php
											$schools = [];
											foreach ($result as $row) {
												$original_school = $row['school_short_name'];
												$school = in_array($original_school, ['SOET', 'SOCSE']) ? 'Engineering' : $original_school;

												$semester = (int)$row['semester'];
												$stream = $row['stream_name'];
												$semesterKey = $semester;
												$schools[$school][$stream][$semesterKey][] = $row;
											}
											?>

											<?php foreach ($schools as $school_name => $streams): ?>
												<div class="school-name">School Name :- <?= $school_name ?></div>

												<?php
												$grand_total_applied = 0;
												$grand_total_pass = 0;
												$grand_total_fail = 0;
												?>

												<?php foreach ($streams as $stream_name => $semesters): ?>
													<table border="1">
														<tr>
															<td class="stream-header" colspan="5">Stream Name:- <?= $stream_name ?></td>
														</tr>
														<tr>
															<th>Semester</th>
															<th>Applied Students</th>
															<th>Passed Students</th>
															<th>Fail Students</th>
															<th>Passing Percentage</th>
														</tr>

														<?php
														$total_applied = 0;
														$total_passed = 0;
														$total_failed = 0;
														$total = ['appeared' => 0, 'pass' => 0, 'fail' => 0];
														?>

														<?php foreach ($semesters as $semester => $components): ?>
															<?php

															$appeared = 0; $pass = 0; $fail = 0;
															foreach ($components as $row) {
															
																$appeared += $row['appeared'];
																$pass += $row['all_clear'];
																$fail += $row['fail'];
															
															}
															// print_r($appeared);
															$percent = ($appeared > 0) ? round(($pass / $appeared) * 100, 2) : 0;

															// Track total per stream
															$total['appeared'] += $appeared;
															$total['pass'] += $pass;
															$total['fail'] += $fail;


															// Track stream-level totals
															$total_applied += $appeared;
															$total_passed += $pass;
															$total_failed += $fail;

															// Track grand totals
															$grand_total_applied += $appeared;
															$grand_total_pass += $pass;
															$grand_total_fail += $fail;

															$grand['appeared'] += $appeared;
															$grand['pass'] += $pass;
															$grand['fail'] += $fail;

					
															?>
															<tr>
																<td><?= $semester ?></td>
																<td><?= $appeared ?></td>
																<td><?= $pass ?></td>
																<td><?= $fail ?></td>
																<td><?= $percent?>%</td>
															</tr>
														<?php endforeach; ?>

														<?php
														$percent_total = ($total['appeared'] > 0) ? round(($total['pass'] / $total['appeared']) * 100, 2) : 0;
														?>
														<tr class="total-row">
															<td><strong>Total</strong></td>
															<td><?= $total['appeared'] ?></td>
															<td><?= $total['pass'] ?></td>
															<td><?= $total['fail'] ?></td>
															<td><?= $percent_total ?>%</td>
														</tr>
													</table>
												<?php endforeach; ?>

												<?php
												$grand_percent = ($grand['appeared'] > 0) ? round(($grand['pass'] / $grand['appeared']) * 100, 2) : 0;
												?>
												<table border="1">
													<tr class="total-row">
														<td colspan="1"><strong>Grand Total</strong></td>
													
														<td>Appeared : <?= $grand['appeared'] ?></td>
														<td>Pass : <?= $grand['pass'] ?></td>
														<td>Fail : <?= $grand['fail'] ?></td>
														<td>Percentage : <?= $grand_percent ?>%</td>
													</tr>
												</table>
												<br><br>
											<?php endforeach; ?>

                         

                                    


                                   <?php
                                   
                                   break;
                                   }
            
                                   ?>
                                  
                              <input type="submit" id="search_excel" class="btn btn-primary btn-labeled" value="Excel" > 
                           
                                  
                               