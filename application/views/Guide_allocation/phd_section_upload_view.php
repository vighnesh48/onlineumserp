
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
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">PhD Research</a></li>
    </ul>
    <div class="page-header">			
    <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; <?php if($doc_det_stud[0]['id']!=''){ ?>Edit <?php }else { ?>Add <?php  } ?>Phd Renumeration Files</h1>
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
									<th>Particulars</th>
									<th>Date</th>
									<th>Upload document</th>
									<th>Submit</th>
								</tr>
								
								<?php
							$pro_adm_exists = false;
							$pre_thesis_exists = false;
							$thesis_sub_exists = false;
							$thesis_panel_exists = false;
							foreach ($renum_files as $file) {
								if ($file['file_type'] == 'pro_adm_letter') {
									$pro_adm_exists = true;
									$pro_adm_file = $file;
								} elseif ($file['file_type'] == 'pre_thesis_notf') {
									$pre_thesis_exists = true;
									$pre_thesis_file = $file;
								}elseif ($file['file_type'] == 'thesis_sub_let') {
									$thesis_sub_exists = true;
									$thesis_sub_file = $file;
								}elseif ($file['file_type'] == 'thesis_panel') {
									$thesis_panel_exists = true;
									$thesis_panel_file = $file;
								}
							}
							?>
								<tr>
									<form action="<?=base_url($currentModule.'/insert_phdsection_renum_files')?>" method="post" enctype="multipart/form-data">
										<td>Provisional Admission Letter<input type="hidden" name="type" value="pro_adm_letter" >
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="enrollment_no" value="<?=$sem_det['enrollment_no']?>" ></td>
										<td><input class="form-control" type="text" name="cond_date" id="pro_cond_date" value="<?= $pro_adm_exists ? $pro_adm_file['conduction_date'] : '' ?>" <?= $pro_adm_exists ? 'disabled' : '' ?> required></td>
										<td>
										<div  class="col-sm-8">
										<input type="file" class="form-control" name="approval_copy"  accept="application/pdf" onchange="validateFile1(this)" <?= $pro_adm_exists ? 'disabled' : '' ?> required ></div>
										<?php if ($pro_adm_exists): 
											$b_name = "uploads/phd_renumaration_files/";
											$dwnld_url = base_url()."Upload/download_s3file/".$pro_adm_file['notification_letter'].'?b_name='.$b_name; ?>
									   <div  class="col-sm-3">
							           <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										<?php endif; ?> </div>
										</td>
										<td><input type="submit" class="form-control" value="Submit" id="rac_sub" <?= $pro_adm_exists ? 'disabled' : '' ?>></td>
									</form>
								</tr>
								<tr>
									<form action="<?=base_url($currentModule.'/insert_phdsection_renum_files')?>" method="post" enctype="multipart/form-data">
										<td>RAC (Pre Thesis Notification)<input type="hidden" name="type" value="pre_thesis_notf">
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="enrollment_no" value="<?=$sem_det['enrollment_no']?>"></td>
										<td><input class="form-control" type="text" name="cond_date" id="thesis_cond_date" value="<?= $pre_thesis_exists ? $pre_thesis_file['conduction_date'] : '' ?>" <?= $pre_thesis_exists ? 'disabled' : '' ?> required ></td>
										<td>
										<div  class="col-sm-8">
										<input class="form-control" type="file" name="approval_copy"  accept="application/pdf" onchange="validateFile2(this)" <?= $pre_thesis_exists ? 'disabled' : '' ?> required></div>
										<?php if ($pre_thesis_exists): 
											$b_name = "uploads/phd_renumaration_files/";
										     $dwnld_url = base_url()."Upload/download_s3file/".$pre_thesis_file['notification_letter'].'?b_name='.$b_name;?>
									   <div  class="col-sm-3">
							           <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										 <?php endif; ?></div>
										</td>
										<td><input class="form-control" type="submit" value="Submit" id="the_sub" <?= $pre_thesis_exists ? 'disabled' : '' ?>></td>										
										</form>
								</tr>
								<tr>
									<form action="<?=base_url($currentModule.'/insert_phdsection_renum_files')?>" method="post" enctype="multipart/form-data">
										<td>Thesis submission letter<input type="hidden" name="type" value="thesis_sub_let">
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="enrollment_no" value="<?=$sem_det['enrollment_no']?>"></td>
										<td><input class="form-control" type="text" name="cond_date" id="sub_cond_date" value="<?=$thesis_sub_exists ? $thesis_sub_file['conduction_date'] : '' ?>" <?= $thesis_sub_exists ? 'disabled' : '' ?> required></td>
										<td>
										<div  class="col-sm-8">
										<input class="form-control" type="file" name="approval_copy"  accept="application/pdf" onchange="validateFile3(this)" <?= $thesis_sub_exists ? 'disabled' : '' ?> required ></div>
										<?php if ($thesis_sub_exists): 
											$b_name = "uploads/phd_renumaration_files/";
											$dwnld_url = base_url()."Upload/download_s3file/".$thesis_sub_file['notification_letter'].'?b_name='.$b_name; ?>
									   <div  class="col-sm-3">
							           <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										 <?php endif; ?></div>
										
										</td>
										<td><input class="form-control" type="submit" value="Submit" id="def_sub"  <?= $thesis_sub_exists ? 'disabled' : '' ?>></td>
										</form>
								</tr>
								<tr>
									<form action="<?=base_url($currentModule.'/insert_phdsection_renum_files')?>" method="post" enctype="multipart/form-data">
									     
										<td>Thesis Panel submission letter to COE by Guide<input type="hidden" name="type" value="thesis_panel">
										<input type="hidden" name="student_id" value="<?=$sem_det['student_id']?>" >
										<input type="hidden" name="enrollment_no" value="<?=$sem_det['enrollment_no']?>"></td>
										<td><input class="form-control" type="text" name="cond_date" id="panel_cond_date" value="<?=$thesis_panel_exists ? $thesis_panel_file['conduction_date'] : '' ?>" <?= $thesis_panel_exists ? 'disabled' : '' ?> required ></td>
										<td>
										<div  class="col-sm-8">
										<input class="form-control" type="file" name="approval_copy"  accept="application/pdf" onchange="validateFile3(this)" <?= $thesis_panel_exists ? 'disabled' : '' ?> required ></div>
										<?php if ($thesis_panel_exists): 
											$b_name = "uploads/phd_renumaration_files/";
											$dwnld_url = base_url()."Upload/download_s3file/".$thesis_panel_file['notification_letter'].'?b_name='.$b_name; ?>
									   <div  class="col-sm-3">
							           <a href="<?php echo $dwnld_url ?>" download ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										<?php endif; ?>
										 </div>
										</td>
										<td><input class="form-control" type="submit" value="Submit" id="def_sub"  <?= $thesis_panel_exists ? 'disabled' : '' ?>></td>
										</form>
								  </tr>
							</table>                        
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
<script>

   $(document).ready(function() {
   
  // $('#report1').DataTable();
    $('#report').DataTable(
	 {
    scrollX: true,
	bPaginate: false
       }
	);
   }); 
   
    
</script>
<script type="text/javascript">
$(document).ready(function () {
$('#pro_cond_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});
$('#thesis_cond_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});
$('#sub_cond_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});
$('#panel_cond_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});
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
</script>