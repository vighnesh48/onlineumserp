<?php $bucketname = 'uploads/employee_documents/';  ?>

<div class="container">
    
    <div class="report-title" style="text-align:center">Daily OD Report</div> 
    <div class="date">Date: <?php echo date('d-m-Y'); ?></div>
    <hr>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No</th>
					<th>School</th>
                    <th>Staff ID</th>
                    <th>Staff Name</th>                    
                    <th>Department</th>
                    <th>Designation</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>No of Days/Hrs</th>
                   <!-- <th>Cumm Month OD</th>
                    <th>Cumm OD(Sum-2025)</th>-->
                    <th>Reason</th>
					<!--<th>Link</th>-->
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = 1;
				 $this->load->model('login_model');
                foreach ($OD as $row) { 
                    ?>
                        <tr>
                            <td><?= $count++; ?></td>
							<td><?= $row['school']; ?></td>
                            <td><?= $row['emp_id']; ?></td>
                            <td><?= $row['employee_name']; ?></td>
                            
                            <td><?= $row['department']; ?></td>
                            <td><?= $row['designation_name']; ?></td>
                            <td><?= $row['applied_from_date']; ?></td>
                            <td><?= $row['applied_to_date']; ?></td>
                            <td>
							
							<?php
							if($row['leave_duration']=='full-day'){
								if($row['no_days'] >1){
									echo 1;
								}
								else{
									echo 1;
								}
								//$row['no_days'] > 1 ? 1
							}
							else{
								echo $row['no_hrs']." hrs";
							}
							
						
						?>
							
							
							</td>
							<?php $tc=$this->login_model->get_total_ods($row['emp_id'],$current_date);
							$tcm=$this->login_model->get_total_ods_current_month($row['emp_id'],$current_date);
							?>
							
							
                           <!--<td><?= $tcm; ?></td>
                            <td><?= $tc; ?></td>-->
							
                            <td><?= $row['reason']; ?></td>
							<!--<td><?php if(empty($row['od_document'])){}else{?><a href="<?= site_url() ?>Upload/get_document/<?php echo $row['od_document'].'?b_name='.$bucketname;  ?>" target="_blank">Click Here</a><?php } ?></td>-->
                        </tr>
                <?php  } ?>
            </tbody>
        </table>
    </div>




</div>
</body>
</html>


