          <style>
#myModal{overflow: hidden !important;}
#model{overflow: hidden !important;}
.modal-open{overflow: hidden !important;}
</style>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              
                <div class="row">
                    <div class="col-sm-4"><h4>Stream:<?=$fees[0]['stream_short_name']?></h4></div>
                     <div class="col-sm-4"><h4>Student List </h4></div>
                     
                     <div class="col-sm-1"><h4>Year:<?=$fees[0]['admission_year']?></h4></div>
                      <div class="col-sm-2 pull-right"><h4>Academic Year:<?=$fees[0]['academic_year']?></h4></div>
                     
                </div>
               
            </div>
            <div class="modal-body">
              <table id="example" class="table table-bordered table-responsive table-hover" >
							<thead>
								<tr>
                                            									<th>SNo</th>
                                            								    <th>PRN </th>
                                            								    <th>Old PRN </th>
                                            							    	<th>Student Name </th>
                                            							    	<th>Mobile No </th>
                                            							    	<th>Gender </th>
                                            							    	<th>School </th>
                                            									<th>Stream </th>
                                            									<th>Year</th>
                                            									<th>Actual Fees</th>
                                                                            	<th>Scholorship</th>
                                            									<th>Applicable</th>
                                            									<th>Opening Balance</th>
                                            									<th>Charges</th>
                                            									<th>Other Fees</th>
                                            									<th>Refund</th>
                                            									<th>Collection</th>
                                            									<th>Pending</th>
                                            									<th>Admission cancel</th>
                                            								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									$ref=0;$other=0;$pending=0;
                                            									if(!empty($fees)){
                                            										foreach($fees as $stud1){
                                            										$other=$stud1['opening_balance']+$stud1['cancel_charges'];
                                            										$pending=($stud1['applicable_total']+$other+$stud1['refund'])-$stud1['fees_total'];
                                            								?>
                                            									<tr>
                                            										<td><?=$i?></td>
                                            										<td><?=$stud1['enrollment_no_new']?></td>
                                            										<td><?=$stud1['enrollment_no']?></td>
                                            										<td><?php echo $stud1['first_name']." ".$stud1['middle_name']." ".$stud1['last_name'];?></td>
                                            										<td><?=$stud1['mobile']?></td>
                                            										<td><?=$stud1['gender']?></td>
                                            										<td><?=$stud1['school_short_name']?></td>
                                            										<td><?=$stud1['course']?></td>
                                            										<td><?=$stud1['admission_year']?></td>
                                            										<td><?=$stud1['actual_fees']?></td>
                                            									    <td><?=(int)$stud1['actual_fees']-(int)$stud1['applicable_total']?></td>
                                            									    <td><?=$stud1['applicable_total']?></td>
                                            									    <td><?=$stud1['opening_balance']?></td>
                                            									    <td><?=$stud1['cancel_charges']?></td>
                                            									    <td><?=$other?></td>
                                            									     <td><?=$stud1['refund']?></td>
                                            									    <td><?=$stud1['fees_total']?></td>
                                            									    <td><?=	$pending?></td>
                                            									    <td><?=$stud1['cancelled_admission']?></td>
                                            									    
                                            									</tr>
								<?php
										$i++;
										}
									}else{
										echo "<tr><td>No data found.</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
									}
								
								?>
								</tbody>
							</table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
 





     
			
    
