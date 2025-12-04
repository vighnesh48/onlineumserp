<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <style>
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
    $roles_id=$this->session->userdata('role_id');
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">PhD Research</a></li>
    </ul>
    <div class="page-header">			
    <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Research Progress Reports</h1>
            <div class="col-xs-12 col-sm-6">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">					   
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
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
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"> &nbsp;&nbsp;&nbsp;&nbsp;<b>Upload Documents:-</b></span>
                    </div>
                  <div class="panel-body">
					 <div class="table-info"> 						
						  <table>
						<tr>
							<th>Particulars</th>	
							<th>Upload document</th>
							<th>Submit</th>
						</tr>
						<?php 
						$guide_allot_exists = false;
						$guide_allot_file = [];
						$rac_topic_exists = false;
						$pre_thesis_exists = false;
						foreach ($doc_det as $file) {
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
						<tr>
							<form action="<?= base_url($currentModule.'/submit_topic_approval') ?>" method="post" enctype="multipart/form-data">
								<td>Guide Allotment Letter <?=$astrik;?> 
									<input type="hidden" id="type" name="type" value="guide_allot_letter" />
									<input type='hidden' name="semester" value="<?=$sem_det['current_semester']?>">
									<input type='hidden' name="student_id" value="<?=$sem_det['student_id']?>">
								</td>
								<td>
									<div class="col-sm-6">
										<input type="file" class="form-control" name="guide_file" accept="application/pdf" onchange="validateFile1(this)" required></div>
									<div class="col-sm-3">
										<?php if ($guide_allot_exists): 
											foreach ($guide_allot_file as $guide_file) {
											$b_name = "uploads/phd_topic_approval/";
											$dwnld_url = base_url()."Upload/download_s3file/".$guide_file['upload_file'].'?b_name='.$b_name;?>
											<a href="<?= $dwnld_url ?>" download><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										<?php } ?>
										</div><div class="col-sm-3"><span style="color: <?= ($guide_file['status'] == "Y") ? 'green' : 'red' ?>"><?= ($guide_file['status'] == "Y") ? 'Recommended' : 'Non-Recommended' ?><?php endif; ?>
								  </span></div>
										
								</td>
								<td>
									<input type="submit" class="form-control" value="Submit" id="rac_sub" >
								</td>
							</form>
						</tr>
						<?php if ($guide_allot_exists && $guide_file['status']=="Y" ): ?>
						<tr>
							<form action="<?= base_url($currentModule.'/submit_topic_approval') ?>" method="post" enctype="multipart/form-data">
								<td>RAC (Topic Approval) <?=$astrik;?>
								  </span>
									<input type="hidden" name="type" value="rac_topic_file">
									<input type='hidden' name="semester" value="<?=$sem_det['current_semester']?>">
									<input type='hidden' name="student_id" value="<?=$sem_det['student_id']?>">
								</td>
								<td>
									<div class="col-sm-6">
										<input class="form-control" type="file" name="guide_file" accept="application/pdf" onchange="validateFile1(this)" <?= $rac_topic_exists ? 'disabled' : '' ?> required></div>
									<div class="col-sm-3">
										<?php if ($rac_topic_exists): 
											$b_name = "uploads/phd_topic_approval/";
											$dwnld_url = base_url()."Upload/download_s3file/".$rac_topic_file['upload_file'].'?b_name='.$b_name; ?>
											<a href="<?= $dwnld_url ?>" download><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										</div><div class="col-sm-3"><span style="color: <?= ($rac_topic_file['status'] == "Y") ? 'green' : 'red' ?>"><?= ($rac_topic_file['status'] == "Y") ? 'Recommended' : 'Non-Recommended' ?></div><?php endif; ?>
										 
								</td>
								<td>
									<input class="form-control" type="submit" value="Submit" id="the_sub" <?= $rac_topic_exists ? 'disabled' : '' ?>>
								</td>
							</form>
						</tr>
						<?php endif; ?>

						<?php if ($rac_topic_exists && $rac_topic_file['status']=="Y" ): ?>
						<tr>
							<form action="<?= base_url($currentModule.'/submit_topic_approval') ?>" method="post" enctype="multipart/form-data">
								<?php 
								         $sts='';
										foreach ($rps_doc_files as $stud) {
										if ($stud['type'] == 'course_work' && $stud['status'] == 'Y' && $sem_det['current_semester']=='1') {
										 $sts='disabled';
										 break;
										}elseif ($stud['type'] == 'RPS-1' && $stud['status'] == 'Y' && $sem_det['current_semester']=='2') {
										 $sts='disabled';
										  break;
										}elseif ($stud['type'] == 'RPS-2' && $stud['status'] == 'Y' && $sem_det['current_semester']=='3') {
										 $sts='disabled';
										  break;
										}
										elseif ($stud['type'] == 'RPS-3' && $stud['status'] == 'Y' && $sem_det['current_semester']=='4') {
										 $sts='disabled';
										  break;
										}
										elseif ($stud['type'] == 'RPS-4' && $stud['status'] == 'Y' && $sem_det['current_semester']=='5') {
										 $sts='disabled';
										  break;
										}
										elseif ($stud['type'] == 'RPS-5' && $stud['status'] == 'Y' && $sem_det['current_semester']=='6') {
										 $sts='disabled';
										  break;
										}elseif ($stud['type'] == 'RPS-6' && $stud['status'] == 'Y' && $sem_det['current_semester']=='7') {
										 $sts='disabled';
										  break;
										}
										elseif ($stud['type'] == 'RPS-7' && $stud['status'] == 'Y' && $sem_det['current_semester']=='8') {
										 $sts='disabled';
										  break;
										}
										elseif ($stud['type'] == 'RPS-8' && $stud['status'] == 'Y' && $sem_det['current_semester']=='9') {
										 $sts='disabled';
										  break;
										}
										elseif ($stud['type'] == 'RPS-9' && $stud['status'] == 'Y' && $sem_det['current_semester']=='10') {
										 $sts='disabled';
										  break;
										}
									}
						            
									$highest_completed_type = '';
									$type_sequence = ['course_work', 'RPS-1', 'RPS-2', 'RPS-3', 'RPS-4', 'RPS-5', 'RPS-6', 'RPS-7', 'RPS-8', 'RPS-9'];

									// Determine the highest completed type
									foreach ($type_sequence as $type) {
										foreach ($rps_doc_files as $stud) {
											if ($stud['type'] == $type && $stud['status'] == "Y") {
												$highest_completed_type = $type;
												break;
											}
										}
									}

									// Determine the next type to enable
									$next_type = '';
									if ($highest_completed_type) {
										$index = array_search($highest_completed_type, $type_sequence);
										if ($index !== false && $index < count($type_sequence) - 1) {
											$next_type = $type_sequence[$index + 1];
										}
									}

									?>
                                     <?php if($roles_id!=23){?>
									 
									<td>
										<select id="type" name="type" class="form-control">
											<?php foreach ($type_sequence as $type): ?>
												<?php if ($sem_det['current_semester'] == array_search($type, $type_sequence) + 1): ?>
													<option value="<?= $type ?>" <?= ($next_type != $type && $type != 'course_work') ? 'disabled' : '' ?>>
														<?= ucfirst(str_replace('_', ' ', $type)) ?><?=$astrik?>
													</option>
												<?php endif; ?>
											<?php endforeach; ?>
										</select>
									</td>
									 <?php }else{ $sts=''; ?>
									 <td>
									 <select id="type" name="type" class="form-control">
											<?php foreach ($type_sequence as $type): ?>
													<option value="<?= $type ?>" >
														<?= ucfirst(str_replace('_', ' ', $type)) ?><?=$astrik?>
													</option>
											<?php endforeach; ?>
										</select>
									 </td>
									 <?php } ?>

									<input type="hidden" name="student_id" value="<?= $sem_det['student_id'] ?>">
									<input type='hidden' name="semester" value="<?=$sem_det['current_semester']?>">
								</td>
								<td>
									<div class="col-sm-6">
										<input class="form-control" type="file" name="guide_file" accept="application/pdf" onchange="validateFile1(this)" required <?=$sts;?>></div>
								</td>
								<td>
									<input class="form-control" type="submit" value="Submit" id="the_sub" <?=$sts;?>>
								</td>
							</form>
						</tr>
						<?php endif; ?>

						<?php 
						$show_pre_thesis = false;
						foreach ($rps_doc_files as $stud) {
							if ($stud['type'] == 'RPS-5' && $stud['status'] == 'Y') {
								$show_pre_thesis = true;
								break;
							}
						}
						if ($show_pre_thesis): ?>
						<tr>
							<form action="<?= base_url($currentModule.'/submit_topic_approval') ?>" method="post" enctype="multipart/form-data">
								<td>RAC (Pre Thesis) <?=$astrik;?>
								  
									<input type="hidden" name="type" value="pre_thesis">
									<input type="hidden" name="student_id" value="<?= $sem_det['student_id'] ?>">
									<input type='hidden' name="semester" value="<?=$sem_det['current_semester']?>">
								</td>
								<td>
									<div class="col-sm-6">
										<input class="form-control" type="file" name="guide_file" accept="application/pdf" onchange="validateFile1(this)" <?= $pre_thesis_exists ? 'disabled' : '' ?> required></div>
									<div class="col-sm-3">
										<?php if ($pre_thesis_exists): 
											$b_name = "uploads/phd_topic_approval/";
											$dwnld_url = base_url()."Upload/download_s3file/".$pre_thesis_file['upload_file'].'?b_name='.$b_name; ?>
											<a href="<?= $dwnld_url ?>" download><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										</div><div class="col-sm-3"> <span style="color: <?= ($pre_thesis_file['status'] == "Y") ? 'green' : 'red' ?>"><?= ($pre_thesis_file['status'] == "Y") ? 'Recommended' : 'Non-Recommended' ?></span></div><?php endif; ?>
										
								</td>
								<td>
									<input class="form-control" type="submit" value="Submit" id="the_sub" <?= $pre_thesis_exists ? 'disabled' : '' ?>>
								</td>
							</form>
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
                    <div class="panel-heading">
                        <span class="panel-title" id="stdname">Documents Details :-</span>
                    </div>
                    <div class="panel-body" style="overflow:scroll;height:700px;">
                        <div class="table-info" id='stud_view'> 
                         <?php //if(in_array("View", $my_privileges)) { ?>
							<table id="example" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th style="text-align: center">Sr No.</th>
									<th style="text-align: center">Semester</th>
									<th style="text-align: center">Research Seminar File</th>									
							    	<th style="text-align: center">Status</th>
								</tr>
								</thead>
								<tbody>
								<?php				
								$i=1;
									if(!empty($rps_doc_files)){
										foreach($rps_doc_files as $stud){		
								?>
									<tr align="center">
										<td style="text-align: center"><?=$i?></td>
										<td style="text-align: center"><?='Sem- '.$stud['semester']?></td>
									  <td style="text-align: center"><?php if($stud['type']=="course_work"){echo "Course Work"; }else{ echo $stud['type'];} ?> <?php  if($stud['upload_file']!=''){	
									     $b_name = "uploads/phd_topic_approval/";
										 $dwnld_url = base_url()."Upload/download_s3file/".$stud['upload_file'].'?b_name='.$b_name; ?>
									 &nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a><?php } ?>
                                       </td>									   
									      <?php if($stud['status']=="Y"){ ?>
										 <td style="color:green;text-align: center;">Recommended</td>  
										   
									<?php   } else { ?>
										 <td style="color:red;text-align: center;">Non-Recommended</td>     
									<?php  }  ?>
									</tr>
								<?php
										$i++;
											}
									}else{
										echo "<tr><td colspan='8'>No data found.</td></tr>";
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
</div>
<script type="text/javascript">
  function validateFile1(input) {
            const file = input.files[0];
            if (file) {
                const fileType = file.type;
                const fileSize = file.size;
                
                // Check if file is a PDF
                if (fileType !== 'application/pdf') {
                    alert('Please upload a PDF file.');
                    input.value = ''; // Clear the input
                }
                // Check if file size is less than 2MB
                 if (fileSize > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB.');
                    input.value = ''; // Clear the input
               }
			   
			}
        }		  
</script>

