
<table id="example" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th style="text-align: center">SrNo</th>
									<th style="text-align: center">Academic Year</th>
									<th style="text-align: center">Member Name</th>
									<th style="text-align: center">Designation</th>
							    	<th style="text-align: center">Institute Name</th>
									<th style="text-align: center">Employee Code</th>
									<th style="text-align: center">Account Holder Name</th>
									<th style="text-align: center">Bank Name</th>
									<th style="text-align: center">Branch</th>
							    	<th style="text-align: center">IFSC</th>
							    	<th style="text-align: center">Passbook/Cheque Copy</th>
							    	<th style="text-align: center">Mobile No</th>
							    	<th style="text-align: center">Email</th>
							    	<th style="text-align: center">Students</th>
							    	<th style="text-align: center">Renumeration</th>
							    	<th style="text-align: center">Amount Payable</th>
							    	<th style="text-align: center">Amount Paid</th>
							    	<th style="text-align: center">Amount Pending</th>
							    	<th style="text-align: center">View Payment</th>
							    	<th style="text-align: center">Pay</th>
								</tr>
								</thead>
								<tbody>
								<?php	
  							
								$i=1;
									if(!empty($renum_det)){
										foreach($renum_det as $stud){
			
								?>
									<tr>
										<td><?=$i?></td>		
										<td><?=$stud['academic_year']?></td>
										<td><?=$stud['member_name']?></td>
										<td><?=$stud['designation']?></td>
										<td><?=$stud['institute']?></td>
										<td><?=$stud['emp_code']?></td>
										<td><?=$stud['accountholdername']?></td>
										<td><?=$stud['bank_name']?></td>
										<td><?=$stud['branch']?></td>
										<td><?=$stud['ifsc']?></td>
										<td><?php if ($stud['cheque_file']): 
											$b_name = "uploads/phd_renumaration_files/";
											$dwnld_url = base_url()."Upload/download_s3file/".$stud['cheque_file'].'?b_name='.$b_name; ?>
							                <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										 <?php endif; ?></td>
										<td><?=$stud['mobno']?></td>
										<td><?=$stud['email']?></td>
										<td><?=$stud['stud_count'] ? $stud['stud_count']:'0'; ?>&nbsp;&nbsp;&nbsp;<a href="<?=base_url();?>Guide_allocation_phd/fetch_guide_renumeration_det_view/<?=base64_encode($stud['emp_code']);?>/<?=base64_encode($stud['academic_year']);?>/<?=base64_encode($ren_month);?>" title="View" target="_blank" ><i class="fa fa-eye"></i></a></td>
										<td><?=$stud['renumeration'] ? $stud['renumeration']:'0'; ?></td>	
										<td><?=$stud['renumeration'] ? $stud['renumeration']:'0'; ?></td>
										<td><?=$stud['total_paid'] ? $stud['total_paid']:'0'; ?></td>
										  <?php
                                          $pending=($stud['renumeration']-$stud['total_paid']);
										 ?>	
										<td><?=$pending ? $pending:'0'; ?></td>
										<td>
											<a class="btn btn-primary" href="<?=base_url();?>Guide_allocation_phd/payment_view_history/<?=base64_encode($stud['emp_code']);?>/<?=base64_encode($stud['academic_year'])?>" title="View Payment History" target="_blank">View Payment History</a>
										</td>
										<td>
											<a class="btn btn-primary" href="<?=base_url();?>Guide_allocation_phd/make_payment/<?=base64_encode($stud['emp_code']);?>/<?=base64_encode($stud['academic_year'])?>" title="Pay" target="_blank">Pay</a>
										</td>
									</tr>
								<?php
										$i++;
										}
									}
								   ?>
								</tbody>
							</table>

<script>
$(document).ready(function() {	
     $('#example').DataTable({
        responsive: true,
        autoWidth: true,
        dom: 'Bfrtip',
		scrollY:        "700px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         true,
        fixedColumns: true,
        ordering: false,
        buttons: [
            {
                extend: 'excel',
				filename: 'guide allocation list'
            },
        ]        
    }).columns.adjust();  
}); 	 
</script>