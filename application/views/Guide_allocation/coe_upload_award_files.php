
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; <?php if($doc_det_stud[0]['id']!=''){ ?>Edit <?php }else { ?>Add <?php  } ?>Phd Notification Letters</h1>
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
							$pvcc_exists = false;
							$award_exists = false;
							foreach ($renum_files as $file) {
								if ($file['file_type'] == 'pvcc_notf') {
									$pvcc_exists = true;
									$pvcc_file = $file;
								} elseif ($file['file_type'] == 'final_deg_award') {
									$award_exists = true;
									$award_file = $file;
								}
							}
							?>
							<tr>
								<form action="<?= base_url($currentModule.'/insert_coe_notification_files') ?>" method="post" enctype="multipart/form-data">
									<td>PVVC Notification
										<input type="hidden" name="type" value="pvcc_notf">
										<input type="hidden" name="student_id" value="<?= $sem_det['student_id'] ?>">
										<input type="hidden" name="enrollment_no" value="<?= $sem_det['enrollment_no'] ?>">
									</td>
									<td>
										<input class="form-control" type="text" name="cond_date" id="pvvc_cond_date" value="<?= $pvcc_exists ? $pvcc_file['conduction_date'] : '' ?>" <?= $pvcc_exists ? 'disabled' : '' ?> required>
									</td>
									<td>
									<div  class="col-sm-8">
										<input type="file" class="form-control" name="approval_copy" accept="application/pdf" onchange="validateFile1(this)" <?= $pvcc_exists ? 'disabled' : '' ?> required ></div>
										<div  class="col-sm-3">
										<?php if ($pvcc_exists): 
											$b_name = "uploads/phd_renumaration_files/";
											$dwnld_url = base_url()."Upload/download_s3file/".$pvcc_file['notification_letter'].'?b_name='.$b_name;?>
											<a href="<?= $dwnld_url ?>" download><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										<?php endif; ?></div>
									</td>
									<td>
										<input type="submit" class="form-control" value="Submit" id="rac_sub" <?= $pvcc_exists ? 'disabled' : '' ?>>
									</td>
								</form>
							</tr>
							<tr>
								<form action="<?= base_url($currentModule.'/insert_coe_notification_files') ?>" method="post" enctype="multipart/form-data">
									<td>Final PhD Degree Award Notification
										<input type="hidden" name="type" value="final_deg_award">
										<input type="hidden" name="student_id" value="<?= $sem_det['student_id'] ?>">
										<input type="hidden" name="enrollment_no" value="<?= $sem_det['enrollment_no'] ?>">
									</td>
									<td>
										<input class="form-control" type="text" name="cond_date" id="award_cond_date" value="<?= $award_exists ? $award_file['conduction_date'] : '' ?>" <?= $award_exists ? 'disabled' : '' ?> required >
									</td>
									<td>
									<div  class="col-sm-8">
										<input class="form-control" type="file" name="approval_copy" accept="application/pdf" onchange="validateFile2(this)" <?= $award_exists ? 'disabled' : '' ?> required > </div>
										<div  class="col-sm-3">
										<?php if ($award_exists): 
											$b_name = "uploads/phd_renumaration_files/";
											 $dwnld_url = base_url()."Upload/download_s3file/".$award_file['notification_letter'].'?b_name='.$b_name;?>
											<a href="<?= $dwnld_url ?>" download><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;font-size: 24px;"></i></a>
										<?php endif; ?></div>
									</td>
									<td>
										<input class="form-control" type="submit" value="Submit" id="the_sub" <?= $award_exists ? 'disabled' : '' ?>>
									</td>
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
$('#pvvc_cond_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});
$('#award_cond_date').datepicker( {format: 'dd-mm-yyyy',autoclose: true, endDate: '0d'});

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

</script>







