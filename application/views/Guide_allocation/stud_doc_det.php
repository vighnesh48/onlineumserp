<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
<script src="https:////cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">

	<?php 
     if(isset($_SESSION['status']))
    {
        ?>
			<script>
			var status="<?php echo $_SESSION['status'] ?>";
			 alert(status);
			</script>
        <?php 
        unset($_SESSION['status']);
      }	    
   ?>
<style>
.form-control{border-collapse:collapse !important;}
#guide { display: flex; 
       justify-content: center;
       }
	 
        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
		#guide { display: flex; 
       justify-content: center }
  
</style>
<?php
   $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Guide Allocation</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Student Documents List</h1>
            <div class="col-xs-12 col-sm-6">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">					   
                </div>
            </div>
        </div>
     </div>
	    <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading" >
                        <span class="panel-title" id="guide" > &nbsp;&nbsp;&nbsp;&nbsp;<b>Guide ID-Name : <?php if($sem_det['guide_id']!=''){ echo $sem_det['guide_id'].' - '.$sem_det['guide_name']; } else { echo '<span style="color:red;"> Guide Not Assigned.</span>';}?> </b></span>
                    </div>
					  <div class="panel-heading" >
						<span class="panel-title" id="guide" ><b>Details of Student: </b><b>PRN - <?=$sem_det['enrollment_no']?> || Name - <?=$sem_det['student_name']?> || Active Semester - Sem <?=$sem_det['current_semester']?> </b></span>
					</div>
                </div>
            </div>    
        </div>
		<div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"> &nbsp;&nbsp;&nbsp;&nbsp;<b>Academic Fees Details:-</b></span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info"> 
					 <table class="table table-bordered table-hover " width="90%">
				<tbody>
					<?php 
				
					  $exm = (int)$admission_details[0]['actual_fee'] - (int)$admission_details[0]['applicable_fee'];
			  $bal = (int)$admission_details[0]['applicable_fee'] - (int)$totfeepaid[0]['tot_fee_paid'];
					  $srNo1=1;
					  
						
    			 $popbal = ($admission_detail[1]['applicable_fee'] + $admission_det[1]['canc_amount'] + $admission_detail[1]['opening_balance']) + $admission_detail[1]['tot_refunds'] -  $admission_detail[1]['totfeepaid'] ;
    					  
    				?>
					<tr style="background-color:#F5F5F5;">
					      <td><strong>Academic Year</strong></td>
						  <td><strong>Stream</strong></td>
					       <td><strong> Year</strong></td>
					        <th scope="col">Academic Fee</th>
    					  <th scope="col">Exepmted Fee</th>
    					  <th scope="col">Applicable Fee</th>
    					  <th scope="col">Opening balance</th>
    					  <th scope="col">Amount Paid</th>
    					   <td><strong>Refund</strong></td>
    					  <th scope="col">Remaining Balance</th>   					 
    					    <th scope="col">Chq Cancellation Charges</th>
    					      <th scope="col">Total Outstanding</th>
					 </tr>
					 
					 
					 <?php 
    if($this->session->userdata("uid")==2){
		 $admission_detail; //af.admission_year=ad.academic_year AND
		//print_r($admission_detail);
		}
						$exm = (int)$admission_details[0]['actual_fee'] - (int)$admission_details[0]['applicable_fee'];
						$bal = (int)$admission_details[0]['applicable_fee'] - (int)$get_feedetails[0]['amount'];
					  
    					$srNo1=1;
    					
    		            $actual =isset($admission_details[0]['applicable_fee']) ? $admission_details[0]['applicable_fee'] : '';
    					$paid =isset($totfeepaid[0]['tot_fee_paid']) ? $totfeepaid[0]['tot_fee_paid'] : '';
    					$i=1;
    				  $cn = count($admission_detail);
    				  
    				 // var_dump($admission_detail);
    					if($cn >1)
    					{
    					
    			 $popbal = ($admission_detail[1]['applicable_fee'] + $admission_det[1]['canc_amount'] + $admission_detail[1]['opening_balance']) + $admission_detail[1]['tot_refunds'] -  $admission_detail[1]['totfeepaid'] ;
    					}
    					else
    					{
    					    $popbal = 0;
    					}
    				//	$popbal = $admission_detail[];
    					$i=1;
    					foreach($admission_detail as $admission_det)
    				  {   					    
    				//	 echo $i;
						$exm = (int)$admission_det['actual_fee'] - (int)$admission_det['applicable_fee'];
						$bal = (int)$admission_det['applicable_fee'] - (int)$admission_det['totfeepaid'];
					    $diff=(int)$admission_det['actual_fee']-$exm-(int)$admission_det['applicable_fee'];
    					$srNo1=1;
    					
    				    $actual =	isset($admission_det['applicable_fee']) ? $admission_det['applicable_fee'] : '';
    					$paid =isset($admission_det['totfeepaid']) ? $admission_det['totfeepaid'] : '';   
    					?>
    					<tr>
							<td><?= $admission_det['academic_year']; ?></td>
							<td><?= $admission_det['stream_short_name']; ?></td>
							<td><?= $admission_det['year']; ?></td>
    						<td><?= isset($admission_det['actual_fee']) ? $admission_det['actual_fee'] : '' ?></td>
    						<td><?=$exm; ?><span style="display:none !important"> diff is <?=$diff; ?></span></td>
    						<td><?= isset($admission_det['applicable_fee']) ? $admission_det['applicable_fee'] : '' ?></td>
    						<td><?= isset($admission_det['opening_balance']) ? $admission_det['opening_balance'] : '' ?></td>
    						<td><?= isset($admission_det['totfeepaid']) ? $admission_det['totfeepaid'] : '' ?></td>
    						
    						<?php
    				  if($admission_det['tot_refunds']!='')
    					  {
    					    $actual = $actual + $admission_det['tot_refunds'] ;
    					  }
    					    ?>
    					   <td><?=$admission_det['tot_refunds'] ?></td>
    					   <?
    				
    					  if($admission_det['opening_balance']!='')
    					  
    					  {
    					    $actual = $actual +   $admission_det['opening_balance'];
    					  }
    					  ?> 
    					  
    						<td><?= $pend = $actual - $paid; //isset($minbalance[0]['min_balance']) ? $minbalance[0]['min_balance'] : $admission_details[0]['applicable_fee'] ?></td>
    					
    							<td><?php echo $can_amt = $admission_det['tot_canc']; //$canc_charges[0]['canc_amount'] ?></td>
    							<td><?php echo $can_amt + $pend; //$canc_charges[0]['canc_amount'] ?></td>
    					</tr>
    					
    					<?php
    					$i++;
    					}
    					?>
				</tbody>
		    </table>
                        </div>
                    </div>
                </div>
            </div>    
        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"> &nbsp;&nbsp;&nbsp;&nbsp;<b>Uploaded Documents:-</b></span>
                    </div>
                  <div class="panel-body">
					 <div class="table-info"> 
						<table>
						<tr>
							<th>Particulars</th>
							<th>Uploaded document</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
						<?php
						$guide_allot_exists = false;
						$guide_allot_file = [];
						$rac_topic_exists = false;
						$pre_thesis_exists = false;
						foreach ($stud_det_files as $file) {
							if ($file['type'] == 'guide_allot_letter') {
								$guide_allot_exists = true;
								$guide_allot_file[] = $file;
							} elseif ($file['type'] == 'rac_topic_file') {
								$rac_topic_exists = true;
								$rac_topic_file = $file;
							} elseif ($file['type'] == 'pre_thesis') {
								$pre_thesis_exists = true;
								$pre_thesis_file = $file;
							}
						}
						?>
						   <?php if ($guide_allot_exists):
						     $i=1;
								foreach ($guide_allot_file as $guide_file): ?>
									<tr>
										<td><?=$i;?>.Guide Allotment Letter</td>
										<td>
											<?php 
											$b_name = "uploads/phd_topic_approval/";
											$dwnld_url = base_url()."Upload/download_s3file/".$guide_file['upload_file'].'?b_name='.$b_name; ?>
											<a href="<?= $dwnld_url ?>" download><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										</td>
										<td style="color: <?= ($guide_file['status'] == "Y") ? 'green' : 'red' ?>"><?= ($guide_file['status'] == "Y") ? 'Recommended' : 'Non-Recommended' ?>
										</td>
										<td>
											<?php if ($guide_file['status'] == "Y"): ?>
												<button class="btn btn-primary" id="btn_cancel" type="button" onclick="status_change_nonrecom(<?= $guide_file['id'] ?>)" <?= ($guide_file['status'] == "Y") ? 'Disabled' : '' ?>>Non-Recommended?</button>
											<?php else: ?>
												<button class="btn btn-primary" id="btn_cancel" type="button" onclick="status_change_recom(<?= $guide_file['id'] ?>)">Recommended?</button>
											<?php endif; ?>
										</td>
									</tr>
									<?php $i++;endforeach; ?>
								<?php endif; ?>
						<?php if ($rac_topic_exists): ?>
						<tr>
								<td>RAC (Topic Approval)
								</td>
								<td>
										<?php if ($rac_topic_exists): 
											$b_name = "uploads/phd_topic_approval/";
											$dwnld_url = base_url()."Upload/download_s3file/".$rac_topic_file['upload_file'].'?b_name='.$b_name; ?>
											<a href="<?= $dwnld_url ?>" download><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										<?php endif; ?>
								    </td>
									  	<td style="color: <?= ($rac_topic_file['status'] == "Y") ? 'green' : 'red' ?>"><?= ($rac_topic_file['status'] == "Y") ? 'Recommended' : 'Non-Recommended' ?>
										</td>
										<td>
											<?php if ($rac_topic_file['status'] == "Y"): ?>
												<button class="btn btn-primary" id="btn_cancel" type="button" onclick="status_change_nonrecom(<?= $rac_topic_file['id'] ?>)" <?= ($rac_topic_file['status'] == "Y") ? 'Disabled' : '' ?>>Non-Recommended?</button>
											<?php else: ?>
												<button class="btn btn-primary" id="btn_cancel" type="button" onclick="status_change_recom(<?= $rac_topic_file['id'] ?>)">Recommended?</button>
											<?php endif; ?>
										</td>
						</tr>
						<?php endif; ?>
						<?php 
						$show_pre_thesis = false;
						foreach ($stud_rps_det as $stud) {
							if ($stud['type'] == 'RPS-5' && $stud['status'] == 'Y') {
								$show_pre_thesis = true;
								break;
							}
						} 
						if ($show_pre_thesis && $pre_thesis_exists): ?>
						<tr>
								<td>RAC (Pre Thesis)
								</td>
								<td>
										<?php if ($pre_thesis_exists): 
											$b_name = "uploads/phd_topic_approval/";
											$dwnld_url = base_url()."Upload/download_s3file/".$pre_thesis_file['upload_file'].'?b_name='.$b_name; ?>
											<a href="<?= $dwnld_url ?>" download><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										<?php endif; ?>
								   </td>
								  <td style="color: <?= ($pre_thesis_file['status'] == "Y") ? 'green' : 'red' ?>"><?= ($pre_thesis_file['status'] == "Y") ? 'Recommended' : 'Non-Recommended' ?>
								  </td>
								  <td>
								<?php if ($pre_thesis_file['status'] == "Y"): ?>
												<button class="btn btn-primary" id="btn_cancel" type="button" onclick="status_change_nonrecom(<?= $pre_thesis_file['id'] ?>)"   <?= ($pre_thesis_file['status'] == "Y") ? 'Disabled' : '' ?>>Non-Recommended?</button>
											<?php else: ?>
												<button class="btn btn-primary" id="btn_cancel" type="button" onclick="status_change_recom(<?= $pre_thesis_file['id'] ?>)">Recommended?</button>
											<?php endif; ?>
								  </td>
						       </tr>
						<?php endif; ?>
					   </table>
						</div>
					</div>
				</div>    
			</div>
		  <div class="row "> 
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading" >
                    <span class="panel-title">&nbsp;&nbsp;&nbsp;&nbsp;<b>Details of Student RPS Documents: </b></span>
                </div>
                    <div class="panel-body" style="overflow:scroll;height:700px;">
                        <div class="table-info" id='stud_view'>  
						<?php // if(in_array("View", $my_privileges)) { ?>
							<table id="example" class="table table-bordered" width="100%">
							<thead>							
								<tr>
									<th style="text-align: center">SrNo</th>
									<th style="text-align: center">Semester</th>
							    	<th style="text-align: center">Research Seminar File</th>
									<th style="text-align: center">Status</th>
							    	<th style="text-align: center">Actions</th>
								</tr>
								</thead>
								<tbody>
								<?php			
								$i=1;
									if(!empty($stud_rps_det)){
										foreach($stud_rps_det as $stud){
								?>
									<tr >
										<td style="text-align: center"><?=$i?></td>
										<td style="text-align: center"><?='Sem- '.$stud['semester']?></td>									
									 <td style="text-align: center"><?php	if($stud['upload_file']!=''){
									      $b_name = "uploads/phd_topic_approval/";
										 $dwnld_url = base_url()."Upload/download_s3file/".$stud['upload_file'].'?b_name='.$b_name;
										 if($stud['type']=="course_work"){echo "Course Work"; }else{ echo $stud['type'];} ?>
						          &nbsp;&nbsp;
									<a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a><?php } ?>
                                       </td>
									   <?php if($stud['status']=="Y"){ ?>
										 <td style="color:green;text-align: center">Recommended</td>  
										   
									<?php   } else { ?>
										 <td style="color:red;text-align: center">Non-Recommended</td>     
									<?php  }  ?>
									<td style="text-align: center">
									<?php 
									// if(in_array("Edit", $my_privileges)) {
									if($stud['status']=="Y"){ ?>
									<button class="btn btn-primary" id="btn_cancel" type="button" onclick="status_change_nonrecom(<?=$stud['id']?>)" <?= ($stud['status'] == "Y") ? 'Disabled' : '' ?> >Non-Recommended?</button>
										<?php } else { ?>
										<button class="btn btn-primary" id="btn_cancel" type="button" onclick="status_change_recom(<?=$stud['id']?>)">Recommended?</button>
									<?php } //} ?>
								   </td>
									</tr>
								<?php
										$i++;
										}
									}else{
										echo "<tr><td colspan='5'>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table>
							<?php //} ?>
						</div>
                    </div>
                </div>
			</div>		
		</div>	
    </div>
<script>

   function status_change_nonrecom(id)
  {
      var status='N';
	 if(id !=''){
		var checkstr =  confirm('Are you sure you want to Non-Recommended this?');
        if(checkstr == true){
	 	$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Guide_allocation_phd/topic_approval_status_chng',
				data: 'id=' + id+'&status='+status,
				success: function (sucess) {
					
                       location.reload();
				}
			});
		}
	  }
	  else
	  {
		  alert("Something Wrong");
	  }
  } 

  
  function status_change_recom(id)
  {
      var status='Y';
	  if(id !=''){
		var checkstr =  confirm('Are you sure you want to Recommended this?');
        if(checkstr == true){
	 	$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Guide_allocation_phd/topic_approval_status_chng',
				data: 'id=' + id+'&status='+status,
				success: function (sucess) {
					
                       location.reload();
				}
			});
		}
	  }
	  else
	  {
		  alert("Something Wrong");
	  }
  }
</script>

