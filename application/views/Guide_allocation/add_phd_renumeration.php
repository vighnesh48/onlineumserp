
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
	   .table-responsive {
			overflow-x: auto;
		}
		.table {
			width: 100%;
			margin-bottom: 1rem;
			color: #212529;
		}
		
    </style> 
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';

	$um_id=$this->session->userdata['uid'];

	if($um_id=='3195')
				{
					$auth='Not';
				}
			

?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">PhD Research</a></li>
    </ul>
    <div class="page-header">			
    <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; <?php if($doc_det_stud[0]['id']!=''){ ?>Edit <?php }else { ?>Add <?php  } ?>Phd Renumeration</h1>
            <div class="col-xs-12 col-sm-6">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">					   
                </div>
            </div>
			<?php if($doc_det_stud[0]['id']!=''){ ?>
              <div class="col-xs-12 col-sm-2">
                  <a style="width: 100%;" class="btn btn-primary btn-labeled" href="<?=base_url()?>Guide_allocation_phd/topic_approval_add"><span class="btn-label icon fa fa-chevron-left"></span>Back</a>
				  <div class="visible-xs clearfix form-group-margin"></div>
              </div>
			<?php } ?>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
		<?php //echo'<pre>';print_r($renum_files);exit;
     if(isset($_SESSION['status'])){ ?>
			 <script>
            var status = <?php echo json_encode($_SESSION['status']); ?>;
            alert(status.replace(/<br\s*\/?>/gi, '\n')); // Replace <br> with newline
        </script>
        <?php unset($_SESSION['status']);
       }
        ?>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title" id="guide"> &nbsp;&nbsp;&nbsp;&nbsp;<b>Guide ID-Name : <?php if($sem_det['guide_id']!=''){ echo $sem_det['guide_id'].' - '.$sem_det['guide_name']; } else { echo '<span style="color:red;"> Guide Not Assigned.</span>';}?> </b></span>
                    </div>
                </div>
            </div>    
        </div>
           <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title" id="guide"><b>Details of Student: </b><b>PRN - <?=$sem_det['enrollment_no']?> || Name - <?=$sem_det['student_name']?> || Active Semester - Sem <?=$sem_det['current_semester']?> </b></span>
                </div>
                <div class="panel-body">
                    <div class="table-info">                      
                          <table>
								<tr>
									<th>Particulars of RAC</th>
									<th>Date of Conduction</th>
									<th>Upload Approved copy of RAC</th>
									<th>Upload copy of Financial approval</th>
									<th>Internal Staff ID</th>
									<th>Select External</th>
									<th>Submit</th>
									<!--th>Sample Excel</th>
									<th>Upload EXcel</th-->
									<th>Renumeration</th>
									<th>PDF</th>
								
								</tr>
									<?php
							$topic_app_exists = false;
							$pre_thesis_exists = false;
							$final_def_exists = false;
							$topic_dis="disabled";
							$pre_dis="disabled";
							$final_dis="disabled";
							$topic_external_codes_array='';
							$pre_external_codes_array='';
							$final_external_codes_array='';
							foreach ($renum_files as $file) {
								if ($file['file_type'] == 'topic_approval') {
									$topic_app_exists = true;
									$topic_app_file = $file;
									$topic_dis="enabled";
									$topic_external_codes_array = explode(',', $file['external']);
								} elseif ($file['file_type'] == 'pre_thesis') {
									$pre_thesis_exists = true;
									$pre_thesis_file = $file;
									$pre_dis="enabled";
									$pre_external_codes_array = explode(',', $file['external']);
								} elseif ($file['file_type'] == 'final_defence') {
									$final_def_exists = true;
									$final_def_file = $file;
									$final_dis="enabled";
									$final_external_codes_array = explode(',', $file['external']);
								}
							}
					
								$rps_file_type_array=[];		
							foreach($rps_files_details as $rps){	
							$rps_file_type_array[] = $rps['file_type'];
						    } 
								
								$rps_arr=[];


								
								
								$topic_arr = '';
								$thesis_arr = '';
								$final_arr = '';
                                $thesis_rr='';
                                $final_rr='';
								$topic_rr='';
								$topic_pdf='disabled';
								$thesis_pdf='disabled';
								$final_pdf='disabled';
								// Loop through the array to find the specified types and save them into the respective variables
								foreach ($guide_renum_det as $item) {
									if ($item['type'] == 'topic_approval') {
										$topic_arr = $item['type'];
										$topic_rr='disabled';
										$topic_pdf='enabled';
									}
									elseif($item['type'] == 'pre_thesis') {
										$thesis_arr = $item['type'];
										$thesis_rr='disabled';
										$thesis_pdf='enabled';
									} elseif ($item['type'] == 'final_defence') {
										$final_arr = $item['type'];
										$final_rr='disabled';
										$final_pdf='enabled';
									}
									else{
									if(!in_Array($item['type'],$rps_arr)){
									$rps_arr[] = $item['type'];
									}
									}
								}
							?>
								<tr>
									<form action="<?=base_url($currentModule.'/insert_renum_data_files')?>" method="post" enctype="multipart/form-data">
									<input type="hidden" name="gid" value="<?=$topic_app_file['gid']?>" >
										<td>RAC Topic Approval<input type="hidden" name="type" value="topic_approval" >
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="enrollment_no" value="<?=$sem_det['enrollment_no']?>" ></td>
										<td><input class="form-control" type="text" name="cond_date" id="rac_cond_date" value="<?= $topic_app_exists ? $topic_app_file['conduction_date'] : '' ?>" <?=$auth?><?= $topic_app_exists ? 'disabled' : '' ?>  required></td>
										<td>
										<div class="col-sm-10">
										<input type="file" class="form-control" name="approval_copy"  accept="application/pdf" onchange="validateFile1(this)" <?= $topic_app_exists ? '' : 'required' ?> <?=$auth?><?= $topic_app_exists ? 'disabled' : '' ?> ></div>
									   <?php if ($topic_app_exists): 
											$b_name = "uploads/phd_renumaration_files/"; 
											$dwnld_url = base_url()."Upload/download_s3file/".$topic_app_file['approval_copy_file'].'?b_name='.$b_name;?>
											<div class="col-sm-2"> 
							           <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a></div>
										 <?php endif; ?>
										</td>
										<td>
										<div class="col-sm-10">
										<input type="file" class="form-control" name="final_app_copy"  accept="application/pdf" onchange="validateFile1(this)" <?= $topic_app_exists ? '' : 'required' ?> <?=$auth?><?= $topic_app_exists ? 'disabled' : '' ?>></div>
										   <?php if ($topic_app_exists): 
											$b_name = "uploads/phd_renumaration_files/";
											$dwnld_url = base_url()."Upload/download_s3file/".$topic_app_file['final_approval_copy'].'?b_name='.$b_name; ?>
											<div class="col-sm-2"> 
							           <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a></div>
										<?php endif; ?>
										</td>
										<td>
										<input type="number" name="internal_id" class="form-control" min="0" max="9999999" oninput="validateInput(this)" required <?=$auth?><?= $topic_app_exists ? 'disabled' : '' ?> value="<?= $topic_app_exists ? $topic_app_file['internal_id'] : '' ?>" >
										</td>
										<td style="width:350px;">
										     <select id="external_code" name="external_code[]" class="form-control" multiple="multiple" <?=$auth?><?= $topic_app_exists ? 'disabled' : '' ?> required>
												<option value="">Select External</option>
												<?php foreach($external_det as $rev){ ?>
													<option value="<?=$rev['ext_faculty_code']?>" <?php if (in_array($rev['ext_faculty_code'], $topic_external_codes_array)) { echo 'selected'; } ?>><?=$rev['ext_fac_name']?></option>
												<?php } ?>
											</select> 
										</td>
										<td><input type="submit" class="form-control" value="Submit" id="rac_sub" <?=$auth?><?= $topic_app_exists ? 'disabled' : '' ?>></td>
										<!--td><a href="<?=base_url();?>/uploads/Rac_topic_approval_copy.xlsx"><i class="fa fa-file-excel-o" style="font-size:30px;color:green"></i></a></td-->
											</form>
										<form action="<?=base_url($currentModule.'/insert_renum_excel_files')?>" method="post" enctype="multipart/form-data" >
										<td>
										<input type="hidden" name="type" value="topic_approval" >
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="guide_id" value="<?=$sem_det['guide_id']?>">
										<input type="hidden" name="internal_id" value="<?=$topic_app_file['internal_id']?>">
										<input type="hidden" name="rac_date" value="<?=$topic_app_file['conduction_date']?>">
										<input type="hidden" name="external" value="<?=$topic_app_file['external']?>">
										<!--input type="file" class="form-control" name="rac_approval_excel" onchange="validateFileExcel1(this)" required <?=$topic_dis?>  <?=$topic_rr?> -->
										<input type="submit" class="form-control" value="Renumeration" id="rac_up" <?=$topic_dis?> <?=$topic_rr?> ></td>
									</form>
									
									<form action="<?=base_url($currentModule.'/download_renumeration_pdf')?>" method="post" enctype="multipart/form-data" >
										<td>
										<input type="hidden" name="type" value="topic_approval" >
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="guide_id" value="<?=$sem_det['guide_id']?>">
										<input type="hidden" name="internal_id" value="<?=$topic_app_file['internal_id']?>">
										<input type="hidden" name="rac_date" value="<?=$topic_app_file['conduction_date']?>">
										<input type="hidden" name="external" value="<?=$topic_app_file['external']?>">
										<input type="submit" class="form-control" value="PDF" id="rac_up" <?=$topic_pdf?>></td>
									</form>
								</tr>
								
								  <tr>
									<form action="<?=base_url($currentModule.'/insert_renum_data_files')?>" method="post" enctype="multipart/form-data">
										<?php 
									$type_sequence = ['course_work', 'RPS-1', 'RPS-2', 'RPS-3', 'RPS-4', 'RPS-5', 'RPS-6', 'RPS-7', 'RPS-8', 'RPS-9'];
									?>
									 <td>
									 <select id="type" name="type" class="form-control" required>
											<?php foreach ($type_sequence as $type): ?>
												<option value="<?= $type ?>"<?php if (in_array($type, $rps_file_type_array)) { echo 'disabled'; } ?> >
												<?= ucfirst(str_replace('_', ' ', $type)) ?><?=$astrik?>
												</option>
										<?php endforeach; ?>
										</select>
										</td>
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="enrollment_no" value="<?=$sem_det['enrollment_no']?>" >
										<td><input class="form-control rps_cond_date" type="text" name="cond_date" id="rps_cond_date" required></td>
										<td>
										<div class="col-sm-10">
										<input type="file" class="form-control" name="approval_copy"  accept="application/pdf" onchange="validateFile1(this)" required ></div>
										</td>
										<td>
										<div class="col-sm-10">
										<input type="file" class="form-control" name="final_app_copy"  accept="application/pdf" onchange="validateFile1(this)" required ></div>
										</td>
										<td>
										</td>
										<td style="width:350px;">
										     <select id="external_code" name="external_code[]" class="form-control external_code4 " multiple="multiple"  required>
												<option value="">Select External</option>
												<?php foreach($external_det as $rev){ ?>
													<option value="<?=$rev['ext_faculty_code']?>"><?=$rev['ext_fac_name']?></option>
												<?php } ?>
											</select> 
										</td>
										<td><input type="submit" class="form-control" value="Submit" id="rps_sub" ></td>
										</form>
										<td></td>
										<td></td>
								</tr>
								<?php 
								       $enb='disabled';
								     if(!empty($rps_files_details)){ 
								     foreach($rps_files_details as $rps_result){
                                       $enb_pdf='disabled';$enb_excel='enabled';
									   $rps_external_codes_array = explode(',', $rps_result['external']);
									 if (in_array($rps_result['file_type'],$rps_arr)){ 
									  $enb_pdf='enabled';
									  $enb_excel='disabled';
									 }
								     ?>
								  <tr>
									<form action="<?=base_url($currentModule.'/insert_renum_data_files')?>" method="post" enctype="multipart/form-data">
									<input type="hidden" name="gid" value="<?=$rps_result['gid']?>" >
								     <td><?php if($rps_result['file_type']=='course_work'){ echo 'Course Work'; } else{ echo $rps_result['file_type']; } ?>
								        <input type="hidden" name="type" value="<?=$rps_result['file_type']?>" >
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="enrollment_no" value="<?=$sem_det['enrollment_no']?>" ></td>
										<td><input class="form-control rps_cond_date" type="text" name="cond_date" id="rps_cond_date" value="<?=$rps_result['conduction_date'] ?>" required <?=$auth?><?=$enb?>></td>
										<td>
										<div class="col-sm-10">
										<input type="file" class="form-control" name="approval_copy"  accept="application/pdf" onchange="validateFile1(this)" <?=$auth?><?=$enb?>></div>
									   <?php if ($rps_result['approval_copy_file']): 
											$b_name = "uploads/phd_renumaration_files/"; 
											$dwnld_url = base_url()."Upload/download_s3file/".$rps_result['approval_copy_file'].'?b_name='.$b_name;?>
									  <div class="col-sm-2"> 
							           <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a></div>
										 <?php endif; ?>
										</td>
										<td>
										<div class="col-sm-10">
										<input type="file" class="form-control" name="final_app_copy"  accept="application/pdf" onchange="validateFile1(this)" <?=$auth?><?=$enb?>></div>
										   <?php if ($rps_result['final_approval_copy']): 
											$b_name = "uploads/phd_renumaration_files/";
											$dwnld_url = base_url()."Upload/download_s3file/".$rps_result['final_approval_copy'].'?b_name='.$b_name; ?>
											<div class="col-sm-2"> 
							           <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a></div>
										<?php endif; ?>
										</td>
										<td></td>
										<td style="width:350px;">
										     <select id="external_code" name="external_code[]" class="form-control external_code4" multiple="multiple"  required <?=$auth?><?=$enb?>>
												<option value="">Select External</option>
												<?php foreach($external_det as $rev){ ?>
													<option value="<?=$rev['ext_faculty_code']?>" <?php if (in_array($rev['ext_faculty_code'], $rps_external_codes_array)) { echo 'selected'; } ?>><?=$rev['ext_fac_name']?></option>
												<?php } ?>
											</select> 
										</td>
										<td><input type="submit" class="form-control" value="Submit" id="rps_sub" <?=$auth?><?=$enb?>></td>
										</form>
										<form action="<?=base_url($currentModule.'/insert_renum_excel_files')?>" method="post" enctype="multipart/form-data" >
										<td>
										<input type="hidden" name="type" value="<?=$rps_result['file_type']?>" >
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="guide_id" value="<?=$sem_det['guide_id']?>">
										<input type="hidden" name="internal_id" value="<?=$rps_result['internal_id']?>">
										<input type="hidden" name="rac_date" value="<?=$rps_result['conduction_date']?>">
										<input type="hidden" name="external" value="<?=$rps_result['external']?>">
										<input type="submit" class="form-control" value="Renumeration" id="rps_up" <?=$enb_excel?>></td>
									   </form>
									<form action="<?=base_url($currentModule.'/download_renumeration_pdf')?>" method="post" enctype="multipart/form-data" >
										<td>
										<input type="hidden" name="type" value="<?=$rps_result['file_type']?>" >
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="guide_id" value="<?=$sem_det['guide_id']?>">
										<input type="hidden" name="internal_id" value="<?=$rps_result['internal_id']?>">
										<input type="hidden" name="rac_date" value="<?=$rps_result['conduction_date']?>">
										<input type="hidden" name="external" value="<?=$rps_result['external']?>">
										<input type="submit" class="form-control" value="PDF" id="rps_up" <?=$enb_pdf?>></td>
									 </form>
								</tr>

								<?php }} ?>
								
								
								<?php 
									$show_pre_thesis = false;
									//$show_pre_thesis = true;
									foreach ($rps_doc_files as $stud) {
										if ($stud['type'] == 'RPS-5' && $stud['status'] == 'Y') {
											$show_pre_thesis = true;
											break;
										}
									}  ?>
								<?php //if($topic_app_exists && $show_pre_thesis && $topic_arr ): ?>
								<tr>
									<form action="<?=base_url($currentModule.'/insert_renum_data_files')?>" method="post" enctype="multipart/form-data">
									<input type="hidden" name="gid" value="<?=$pre_thesis_file['gid']?>" >
										<td>RAC Pre Thesis<input type="hidden" name="type" value="pre_thesis">
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="enrollment_no" value="<?=$sem_det['enrollment_no']?>"></td>
										<td><input class="form-control" type="text" name="cond_date" id="thesis_cond_date" value="<?= $pre_thesis_exists ? $pre_thesis_file['conduction_date'] : '' ?>" <?=$auth?><?= $pre_thesis_exists ? 'disabled' : '' ?> required ></td>
										<td><div class="col-sm-10"> 
										<input class="form-control" type="file" name="approval_copy"  accept="application/pdf" onchange="validateFile2(this)" <?= $pre_thesis_exists ? '' : 'required' ?> <?=$auth?><?= $pre_thesis_exists ? 'disabled' : '' ?>  ></div>
										 <?php if ($pre_thesis_exists): 
											$b_name = "uploads/phd_renumaration_files/";
											$dwnld_url = base_url()."Upload/download_s3file/".$pre_thesis_file['approval_copy_file'].'?b_name='.$b_name; ?>
											<div class="col-sm-2">
							           <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a></div>
										  <?php endif; ?>
										</td>
										<td><div class="col-sm-10">
										<input class="form-control" type="file" name="final_app_copy"  accept="application/pdf" onchange="validateFile2(this)" <?= $pre_thesis_exists ? '' : 'required' ?> <?=$auth?><?= $pre_thesis_exists ? 'disabled' : '' ?> ></div>
										 <?php if ($pre_thesis_exists): 
											$b_name = "uploads/phd_renumaration_files/";
										    $dwnld_url = base_url()."Upload/download_s3file/".$pre_thesis_file['final_approval_copy'].'?b_name='.$b_name;  ?>
											<div class="col-sm-2">
							           <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a></div>
										 <?php endif; ?>
										</td>
										<td>
										<input type="number" name="internal_id" class="form-control" min="0" max="9999999" oninput="validateInput(this)" required <?=$auth?><?= $pre_thesis_exists ? 'disabled' : '' ?> value="<?= $pre_thesis_exists ? $pre_thesis_file['internal_id'] : '' ?>" >
										</td>
										<td>
										      <select id="external_code1" name="external_code[]" class="form-control" multiple="multiple" <?=$auth?><?= $pre_thesis_exists ? 'disabled' : '' ?> required>
												<option value="">Select External</option>
												<?php foreach($external_det as $rev){ ?>
													<option value="<?=$rev['ext_faculty_code']?>" <?php if (in_array($rev['ext_faculty_code'], $pre_external_codes_array)) { echo 'selected'; } ?>><?=$rev['ext_fac_name']?></option>
												<?php } ?>
											</select> 
										</td>
										<td><input class="form-control" type="submit" value="Submit" id="the_sub" <?=$auth?><?= $pre_thesis_exists ? 'disabled' : '' ?>></td>
										<!--td><a href="<?=base_url();?>/uploads/Rac_pre_thesis_approval_copy.xlsx"><i class="fa fa-file-excel-o" style="font-size:30px;color:green"></i></a></td-->										
										</form>
										<form action="<?=base_url($currentModule.'/insert_renum_excel_files')?>" method="post" enctype="multipart/form-data" >
										<td><input type="hidden" name="type" value="pre_thesis">
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="guide_id" value="<?=$sem_det['guide_id']?>">
										<input type="hidden" name="internal_id" value="<?=$pre_thesis_file['internal_id']?>">
										<input type="hidden" name="rac_date" value="<?=$pre_thesis_file['conduction_date']?>">
                                        <input type="hidden" name="external" value="<?=$pre_thesis_file['external']?>">
										<!--input type="file" class="form-control" name="rac_approval_excel"  onchange="validateFileExcel2(this)" required <?=$pre_dis?> <?=$thesis_rr?>></td-->
										<input type="submit" class="form-control" value="Renumeration" id="rac_up" <?=$pre_dis?> <?=$thesis_rr?>></td>
									</form>
									
									<form action="<?=base_url($currentModule.'/download_renumeration_pdf')?>" method="post" enctype="multipart/form-data" >
										<td>
										<input type="hidden" name="type" value="pre_thesis" >
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="guide_id" value="<?=$sem_det['guide_id']?>">
										<input type="hidden" name="internal_id" value="<?=$pre_thesis_file['internal_id']?>">
										<input type="hidden" name="rac_date" value="<?=$pre_thesis_file['conduction_date']?>">
										<input type="hidden" name="external" value="<?=$pre_thesis_file['external']?>">
										<input type="submit" class="form-control" value="PDF" id="rac_up" <?=$thesis_pdf?>></td>
									</form>
								</tr>
								<?php //endif; ?>
								<?php //if ($pre_thesis_file && $thesis_arr ): ?>
								<tr>
									<form action="<?=base_url($currentModule.'/insert_renum_data_files')?>" method="post" enctype="multipart/form-data">
									<input type="hidden" name="gid" value="<?=$final_def_file['gid']?>" >
										<td>Final Defence<input type="hidden" name="type" value="final_defence">
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="enrollment_no" value="<?=$sem_det['enrollment_no']?>"></td>
										<td><input class="form-control" type="text" name="cond_date" id="defence_cond_date" value="<?= $final_def_exists ? $final_def_file['conduction_date'] : '' ?>" <?=$auth?><?= $final_def_exists ? 'disabled' : '' ?> required ></td>
										<td><div class="col-sm-10">
										<input class="form-control" type="file" name="approval_copy"  accept="application/pdf" onchange="validateFile3(this)" <?= $final_def_exists ? '' : 'required' ?>  <?=$auth?><?= $final_def_exists ? 'disabled' : '' ?> ></div>
										<?php if ($final_def_exists): 
											$b_name = "uploads/phd_renumaration_files/";
										    $dwnld_url = base_url()."Upload/download_s3file/".$final_def_file['approval_copy_file'].'?b_name='.$b_name;  ?>
											<div class="col-sm-2">
							           <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a></div>
										  <?php endif; ?>
										</td>
										<td><div class="col-sm-10">
										<input class="form-control" type="file" name="final_app_copy"  accept="application/pdf" onchange="validateFile3(this)" <?= $final_def_exists ? '' : 'required' ?> <?=$auth?><?= $final_def_exists ? 'disabled' : '' ?> ></div>
										<?php if ($final_def_exists): 
											$b_name = "uploads/phd_renumaration_files/";
											$dwnld_url = base_url()."Upload/download_s3file/".$final_def_file['final_approval_copy'].'?b_name='.$b_name; ?>
											<div class="col-sm-2">
							           <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a></div>
										 <?php endif; ?>
										</td>
										<td>
										<input type="number" name="internal_id" class="form-control" min="0" max="9999999" oninput="validateInput(this)"  required <?=$auth?><?= $final_def_exists ? 'disabled' : '' ?> value="<?= $final_def_exists ? $final_def_file['internal_id'] : '' ?>" >
										</td>
										<td style="width:250px">
										     <select id="external_code2" name="external_code[]" class="form-control" multiple="multiple" <?=$auth?><?= $final_def_exists ? 'disabled' : '' ?> required>
												<option value="">Select External</option>
												<?php foreach($external_det as $rev){ ?>
													<option value="<?=$rev['ext_faculty_code']?>" <?php if (in_array($rev['ext_faculty_code'], $final_external_codes_array)) { echo 'selected'; } ?>><?=$rev['ext_fac_name']?></option>
												<?php } ?>
											</select> 
										</td>
										<td><input class="form-control" type="submit" value="Submit" id="def_sub" <?=$auth?><?= $final_def_exists ? 'disabled' : '' ?>></td>
										<!--td><a href="<?=base_url();?>/uploads/Final_defence.xlsx"><i class="fa fa-file-excel-o" style="font-size:30px;color:green"></i></a></td-->
										</form>
										<form action="<?=base_url($currentModule.'/insert_renum_excel_files')?>" method="post" enctype="multipart/form-data" >
										<input type="hidden" name="type" value="final_defence">
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="guide_id" value="<?=$sem_det['guide_id']?>">
										<input type="hidden" name="internal_id" value="<?=$final_def_file['internal_id']?>">
										<input type="hidden" name="rac_date" value="<?=$final_def_file['conduction_date']?>">
										<input type="hidden" name="external" value="<?=$final_def_file['external']?>">
										<!--td><input type="file" class="form-control" name="rac_approval_excel" onchange="validateFileExcel3(this)"required <?=$final_dis?> <?=$final_rr?>></td-->
										<td><input type="submit" class="form-control" value="Renumeration" id="rac_up" <?=$final_dis?> <?=$final_rr?> ></td>
									</form>
									<form action="<?=base_url($currentModule.'/download_renumeration_pdf')?>" method="post" enctype="multipart/form-data" >
										<td>
										<input type="hidden" name="type" value="final_defence" >
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="guide_id" value="<?=$sem_det['guide_id']?>">
										<input type="hidden" name="internal_id" value="<?=$final_def_file['internal_id']?>">
										<input type="hidden" name="rac_date" value="<?=$final_def_file['conduction_date']?>">
										<input type="hidden" name="external" value="<?=$final_def_file['external']?>">
										<input type="submit" class="form-control" value="PDF" id="rac_up" <?=$final_pdf?>></td>
									</form>
								</tr>
								<?php //endif; ?>
							</table>                        
                       </div>
                   </div>
              </div>
         </div>
    </div>

  <div class="panel-body">
							<div class="row" >
							<?php echo $errors; ?>
							<form class="form-horizontal" action="<?= base_url($currentModule . '/add_renum_data_details') ?>" method="post" name="upload_excel" enctype="multipart/form-data">
							 <?php if ($table): ?>
							<div class="table-responsive">
								<table class="table table-bordered" id="report">
									<tbody>
										<?= $table ?>
									</tbody>
								</table>
							</div>
							<?php endif; ?>
							<button type="Submit" class="btn btn-primary" value="Submit">Submit</button>
							</form>
							</div></div>

 <div class="row "> 
            <div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title" id="stdname">Renumeration Details </span>
						<a class="btn btn-primary" href="<?= base_url('Guide_allocation_phd/guide_exportExcel') ?>/<?=base64_encode($sem_det['student_id'])?>" class="btn btn-success">
        Export to Excel
    </a>
                    </div>
                    <div class="panel-body" style="overflow:scroll;height:700px;">
                        <div class="table-info" id='stud_view'>  
						  <?php //if(in_array("View", $my_privileges)) { ?>
							<table id="example" class="table table-bordered" width="100%">
							<thead>
								<tr>
									<th style="text-align: center">SNo</th>
									<th style="text-align: center">Type</th>
									<th style="text-align: center">Institute</th>
									<th style="text-align: center">Designation</th>
							    	<th style="text-align: center">Member Name</th>
							    	<th style="text-align: center">Mobile NO.</th>
							    
									<th style="text-align: center">Renumeration</th>
						<th style="text-align: center">Travelling Allowance</th>
						<th style="text-align: center">Total Amount</th>
							    	<th style="text-align: center">Account Holder Name</th>
							    	<th style="text-align: center">Account No</th>
							    	<th style="text-align: center">IFSC Code</th>
							    	<th style="text-align: center">Branch</th>
							    	<th style="text-align: center">Rac Date</th>
							    	<th style="text-align: center">Upload Document</th>
									
								</tr>
								</thead>
								<tbody>
								<?php			
								$i=1;
									if(!empty($guide_renum_det)){
										$type='';
										foreach($guide_renum_det as $stud){
											if($stud['type']=="topic_approval")
											{
												$type="Rac Topic Approval";
											}elseif($stud['type']=="pre_thesis")
											{
												$type="RAC Pre Thesis";
											}
											 elseif($stud['type']=="final_defence"){
												 $type="Final Defence";
											}
											elseif($stud['type']=="course_work"){
												 $type="Course Work";
											}
											else
											{
												$type=$stud['type'];
											}
								?>
									<tr align="center">
										<td><?=$i?></td>
										<td><?=$type?></td>
										<td><?=$stud['member_name']?></td>
										<td><?=$stud['designation']?></td>
										<td><?=$stud['institute']?></td>
										<td><?=$stud['mobno']?></td>	
										<td><?=$stud['renumeration']?></td>	
										<td><?=$stud['travelling_allowance']?></td>	
										<td><?=$stud['amount']?></td>
										<td><?=$stud['accountholdername']?></td>
										<td><?=$stud['acc_no']?></td>
										<td><?=$stud['ifsc']?></td>
										<td><?=$stud['branch']?></td>
										<td><?=$stud['rac_date']?></td>
										<td><div class="col-sm-6">
										<div class="col-sm-2">
										<?php if ($stud['cheque_file']): 
											$b_name = "uploads/phd_renumaration_files/";
											$dwnld_url = base_url()."Upload/download_s3file/".$stud['cheque_file'].'?b_name='.$b_name; ?>
							                <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										 <?php endif; ?></div>										
										</td>
									</tr>
								<?php
										$i++;
									  }
									}else{
										echo "<tr><td colspan='13'>No data found.</td></tr>";
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
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!--script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script-->

<script>
   $(document).ready(function() {
	   $('.rps_cond_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});
	   $('#rac_cond_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});
        $('#thesis_cond_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});
     $('#defence_cond_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});
   /*  $('#report').DataTable(
	 {
    scrollX: true,
	bPaginate: false
       }
	);
	
	    $('#example').DataTable({
        scrollX: true,
        bPaginate: false,
        dom: 'Bfrtip',
         buttons: [
			 {
				  extend: 'excel',
               exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10,11] 
               }
			 }
		]
    }); */
	
	  $('#external_code').select2({
                placeholder: "Select External",
                allowClear: true
	});	 
	 $('#external_code1').select2({
		placeholder: "Select External",
		allowClear: true
	});	
	 $('#external_code2').select2({
		placeholder: "Select External",
		allowClear: true
	});	
	
	      $('#external_code').on('change', function() {
            var selectedOptions = $(this).val();
            if (selectedOptions && selectedOptions.length > 2) {
                var notSelectedOptions = $(this).find('option').filter(function() {
                    return $.inArray($(this).val(), selectedOptions) === -1;
                });
                notSelectedOptions.prop('disabled', true);
            } else {
                $(this).find('option').prop('disabled', false);
            }
        });
		   $('#external_code1').on('change', function() {
            var selectedOptions = $(this).val();
            if (selectedOptions && selectedOptions.length > 1) {
                var notSelectedOptions = $(this).find('option').filter(function() {
                    return $.inArray($(this).val(), selectedOptions) === -1;
                });
                notSelectedOptions.prop('disabled', true);
            } else {
                $(this).find('option').prop('disabled', false);
            }
        });
		   $('#external_code2').on('change', function() {
            var selectedOptions = $(this).val();
            if (selectedOptions && selectedOptions.length > 1) {
                var notSelectedOptions = $(this).find('option').filter(function() {
                    return $.inArray($(this).val(), selectedOptions) === -1;
                });
                notSelectedOptions.prop('disabled', true);
            } else {
                $(this).find('option').prop('disabled', false);
            }
        });
		
		$('.external_code4').each(function () {
        $(this).select2({
            placeholder: "Select External",
            allowClear: true,
        });
        });

        $('.external_code4').on('change', function () {
            var selectedOptions = $(this).val(); // Get selected options
            if (selectedOptions && selectedOptions.length > 2) {
                var notSelectedOptions = $(this).find('option').filter(function () {
                    return $.inArray($(this).val(), selectedOptions) === -1;
                });
                notSelectedOptions.prop('disabled', true); // Disable non-selected options
            } else {
                $(this).find('option').prop('disabled', false); // Enable all options
            }
        });	

   }); 
   
    
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
		  function validateFile2(input) {
            const file = input.files[0];
            if (file) {
                const fileType = file.type;
                const fileSize = file.size;
                
                // Check if file is a PDF
                if (fileType !== 'application/pdf') {
                    alert('Please upload a PDF file.');
                    input.value = ''; // Clear the input
                }// Check if file size is less than 2MB
                if (fileSize > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB.');
                    input.value = ''; // Clear the input
           
                }
            }
        }
		  function validateFile3(input) {
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
		   function validateFileExcel1(input) {
            const file = input.files[0];
            if (file) {
                const fileType = file.type;
                const fileSize = file.size;
                
                // Check if file is an Excel file
                if (fileType !== 'application/vnd.ms-excel' && fileType !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    alert('Please upload an Excel file (.xls or .xlsx).');
                    input.value = ''; // Clear the input
                }
                // Check if file size is less than 2MB
                if (fileSize > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB.');
                    input.value = ''; // Clear the input
                }
            }
        }
		   function validateFileExcel2(input) {
            const file = input.files[0];
            if (file) {
                const fileType = file.type;
                const fileSize = file.size;
                
                // Check if file is an Excel file
                if (fileType !== 'application/vnd.ms-excel' && fileType !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    alert('Please upload an Excel file (.xls or .xlsx).');
                    input.value = ''; // Clear the input
                }
                // Check if file size is less than 2MB
                if (fileSize > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB.');
                    input.value = ''; // Clear the input
                }
            }
        }
		    function validateFileExcel3(input) {
            const file = input.files[0];
            if (file) {
                const fileType = file.type;
                const fileSize = file.size;
                
                // Check if file is an Excel file
                if (fileType !== 'application/vnd.ms-excel' && fileType !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    alert('Please upload an Excel file (.xls or .xlsx).');
                    input.value = ''; // Clear the input
                }
                // Check if file size is less than 2MB
                if (fileSize > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB.');
                    input.value = ''; // Clear the input
                }
            }
        }
		
		 function validateInput(input) {
            if (input.value.length > 7) {
                alert("Number must be less than 8 digits long.");
				input.value = '';
            } 
        }	
</script>